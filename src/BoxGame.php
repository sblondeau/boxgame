<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App;


class BoxGame
{

    const DIRECTIONS = [
        'N' => [0, -1],
        'S' => [0, 1],
        'E' => [1, 0],
        'W' => [-1, 0],
    ];

    const MAX_X_SIZE = 9;
    const MAX_Y_SIZE = 7;

    /**
     * @var
     */
    private $player;

    /**
     * @var
     */
    private $tiles;

    /**
     *
     * @var
     */
    private $moves;

    /**
     * @var
     */
    private $twig;

    /**
     * BoxGame constructor.
     * @param Player $player
     * @param array $tiles
     */
    public function __construct(Player $player, array $tiles = [], \Twig_Environment $twig=null)
    {
        $this->setPlayer($player);
        $this->setTiles($tiles);
        $this->twig = $twig;
        $this->setMoves(0);
    }

    /**
     * @param string $direction
     */
    public function movePlayer(string $direction): void
    {
        if (!array_key_exists($direction, self::DIRECTIONS)) {
            throw new \LogicException('Unknown direction');
        }

        $targetX = $this->getPlayer()->getX() + self::DIRECTIONS[$direction][0];
        $targetY = $this->getPlayer()->getY() + self::DIRECTIONS[$direction][1];
        $this->getPlayer()->setDirection($direction);

        $this->moveBoxIfExist($targetX, $targetY);

        if ($this->isTraversable($targetX, $targetY) && !$this->isBorder($targetX, $targetY)) {
            $this->getPlayer()->setX($targetX);
            $this->getPlayer()->setY($targetY);
            $this->setMoves($this->getMoves() + 1);
        }

        $this->teleportation();
    }

    public function teleportation()
    {
        $teleport = $this->getTile($this->getPlayer()->getX(), $this->getPlayer()->getY());

        if ($teleport instanceof Teleport && $teleport->getDestination() instanceof Teleport) {
                $this->getPlayer()
                    ->setX($teleport->getDestination()->getX())
                    ->setY($teleport->getDestination()->getY());
        }
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




    /** check if the player can move to a position
     * @param int $x
     * @param int $y
     * @return bool
     */
    private function moveBoxIfExist(int $x, int $y): void
    {
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
        // TODO check if tile coord in MIN/MAX range and pass min/max as construct param ?
        foreach ($this->getTiles() as $tile) {
            if ($tile instanceof Tile) {
                $tiles[$tile->getX()][$tile->getY()] = $tile;
            }
        }

        return $tiles ?? [];
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
        return $x < 0 || $x > self::MAX_X_SIZE || $y < 0 || $y > self::MAX_Y_SIZE;
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
    public function isTraversable(int $x, int $y): bool
    {
        return $this->isEmpty($x, $y) || ($this->getTile($x, $y) instanceof Tile && $this->getTile($x, $y)->isTraversable() === true);
    }

    /**
     * @return int
     */
    public function getMoves(): int
    {
        return $this->moves;
    }

    /**
     * @param int $moves
     * @return BoxGame
     */
    public function setMoves(int $moves): BoxGame
    {
        $this->moves = $moves;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWin(): bool
    {
        return $this->getTile($this->getPlayer()->getX(), $this->getPlayer()->getY()) instanceof Finish;
    }

    public function render() :string
    {
        return $this->twig->render('map.html.twig', [
            'game' => $this
        ]);
    }
}
