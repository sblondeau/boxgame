<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App;


use App\Model\Box;
use App\Model\Finish;
use App\Model\Hole;
use App\Model\Level;
use App\Model\Player;
use App\Model\Tile;
use \SplObserver;

class BoxGame implements \SplSubject
{
    const DIRECTIONS = [
        'N' => [0, -1],
        'S' => [0, 1],
        'E' => [1, 0],
        'W' => [-1, 0],
    ];

    /**
     * @var
     */
    private $player;

    private $level;

    /**
     * @var
     */
    private $tiles;

    private $observers = [];

    /**
     * @var
     */
    private $twig;

    /**
     * BoxGame constructor.
     * @param Player $player
     * @param array $tiles
     */
    public function __construct(Player $player, Level $level, array $tiles = [], \Twig_Environment $twig = null)
    {
        $this->setPlayer($player);
        $this->setTiles($tiles);
        $this->twig = $twig;
        $this->setLevel($level);
        foreach ($this->getTiles() as $tile) {
            if ($tile instanceof SplObserver) {
                $this->attach($tile);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getTiles(): array
    {
        return $this->tiles;
    }

    /**
     * @param mixed $tiles
     * @return BoxGame
     */
    public function setTiles(array $tiles): self
    {
        $this->tiles = $tiles;

        return $this;
    }

    /**
     * @param string $direction
     */
    public function movePlayer(string $direction): void
    {
        if (!array_key_exists($direction, self::DIRECTIONS)) {
            throw new \LogicException('Unknown direction');
        }

        $this->getPlayer()->setDirection($direction);
        [$targetX, $targetY] = $this->playerTargetPosition();

        $this->moveBoxIfExist();

        if ($this->isTraversable() && !$this->isBorder($targetX, $targetY)) {
            $this->getPlayer()->setX($targetX);
            $this->getPlayer()->setY($targetY);
            $this->notify();
        }

    }

    /**
     * @return array
     */
    private function playerTargetPosition() :array
    {
        $direction = $this->getPlayer()->getDirection();
        $targetX = $this->getPlayer()->getX() + self::DIRECTIONS[$direction][0];
        $targetY = $this->getPlayer()->getY() + self::DIRECTIONS[$direction][1];
        return [$targetX, $targetY];
    }

    /**
     * @param Player $player
     * @return BoxGame
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return BoxGame
     */
    public function setPlayer(Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    /** check if the player can move a box to a position
     * @param int $x
     * @param int $y
     * @return bool
     */
    private function moveBoxIfExist(): void
    {
        $direction = $this->getPlayer()->getDirection();
        $x = $this->getPlayer()->getX() + self::DIRECTIONS[$direction][0];
        $y = $this->getPlayer()->getY() + self::DIRECTIONS[$direction][1];

        // get position n+2 of player (according to the move direction)
        $nextX = $x + ($x <=> $this->getPlayer()->getX());
        $nextY = $y + ($y <=> $this->getPlayer()->getY());

        $tile = $this->getTile($x, $y);
        if ($tile instanceof Tile && $tile->isMovable()
            && ($this->isEmpty($nextX, $nextY) || $this->getTile($nextX, $nextY) instanceof Hole)
            && !$this->isBorder($nextX, $nextY)) {

            // if destination is hole, hole is full by box and box is delete
            if ($this->getTile($nextX, $nextY) instanceof Hole) {
                if ($this->getTile($nextX, $nextY)->isTraversable() === false) {
                    $this->removeTile($tile);
                }
                $this->getTile($nextX, $nextY)->setTraversable(true);

            } else {
                // move the box in the next position if it is box free or not map limit
                $tile->setX($nextX)->setY($nextY);
            }

        }

    }

    /**
     * @param int $x
     * @param int $y
     * @return Tile|null
     */
    public function getTile(int $x, int $y): ?Tile
    {
        return $this->getTilesArray()[$x][$y] ?? null;
    }

    /**
     * @return mixed
     */
    public function getTilesArray(): array
    {
        foreach ($this->getTiles() as $tile) {
            if ($tile instanceof Tile) {
                $tiles[$tile->getX()][$tile->getY()] = $tile;
            }
        }

        return $tiles ?? [];
    }

    /** Check is there is a tile or not
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isEmpty(int $x, int $y): bool
    {
        return !$this->getTile($x, $y) instanceof Tile;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    private function isBorder(int $x, int $y): bool
    {
        return $x < 0 || $x > $this->getLevel()->getSizeX() || $y < 0 || $y > $this->getLevel()->getSizeY();
    }

    /**
     * @param Tile $tile
     */
    public function removeTile(Tile $tile): void
    {
        unset($this->getTilesArray()[$tile->getX()][$tile->getY()]);

        foreach ($this->getTiles() as $key => $tileToRemove) {
            if ($tileToRemove === $tile) {
                unset($this->tiles[$key]);
            }
        }
    }

    /** Can be cross by player but not by a Movable Object
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function isTraversable(): bool
    {
        [$x, $y] = $this->playerTargetPosition();

        return
            $this->isEmpty($x, $y) ||
            $this->getTile($x, $y) instanceof Tile && $this->getTile($x, $y)->isTraversable() === true;
    }

    /**
     *
     */
    public function notify()
    {
        foreach ($this->observers as $value) {
            $value->update($this);
        }
    }

    /**
     * @return bool
     */
    public function isWin(): bool
    {
        return $this->getTile($this->getPlayer()->getX(), $this->getPlayer()->getY()) instanceof Finish;
    }


    public function render(): string
    {
        return $this->twig->render('map.html.twig', [
            'game' => $this,
        ]);
    }

    /**
     * destroy if x/y is a Destroyable tile and if player have the Hammer
     * @param int $x
     * @param int $y
     */
    public function destroy(): void
    {
        $box = $this->getTile(...$this->playerTargetPosition());
        if ($this->getPlayer()->getHammer() === true && $box instanceof Box) {
            $box->setTraversable(true);
            $box->setMovable(false);
            $this->getPlayer()->setHammer(false);
        }
    }


    /**
     * @param SplObserver $observer
     */
    public function attach(\SplObserver $observer)
    {
        $this->observers[] = $observer;
    }


    /**
     * @param SplObserver $observer
     */
    public function detach(\SplObserver $observer)
    {
        $key = array_search($observer, $this->observers, true);
        if ($key) {
            unset($this->observers[$key]);
        }
    }

    /**
     * @return array
     */
    public function getObservers(): array
    {
        return $this->observers;
    }

    /**
     * @return Level
     */
    public function getLevel(): Level
    {
        return $this->level;
    }

    /**
     * @param Level $level
     * @return BoxGame
     */
    public function setLevel(Level $level): BoxGame
    {
        $this->level = $level;

        return $this;
    }



}
