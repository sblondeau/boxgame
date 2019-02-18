<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App\Model;


use App\BoxGame;
use SplSubject;

class Teleport extends Tile implements \SplObserver
{
    static public $justTeleported;
    private $destination;

    public function __construct(int $x = 0, int $y = 0)
    {
        parent::__construct($x, $y);
        $this->setMovable(false);
        $this->setTraversable(true);
    }

    /**
     * @param SplSubject|BoxGame $subject
     */
    public function update(SplSubject $subject)
    {
        if (!$this->getDestination() instanceof Teleport) {
            throw new \LogicException('Teleport should have a destination');
        }
        if (
            $subject->getPlayer()->getX() === $this->getX() &&
            $subject->getPlayer()->getY() === $this->getY() &&
            $subject->getPlayer()->getPreviousX() !== $this->getDestination()->getX() &&
            $subject->getPlayer()->getPreviousY() !== $this->getDestination()->getY()
        ) {
            $subject->getPlayer()
                ->setX($this->getDestination()->getX())
                ->setY($this->getDestination()->getY());
        }
    }

    public function getDestination(): ?Teleport
    {
        return $this->destination;
    }

    public function setDestination(Teleport $teleportDestination)
    {
        $this->destination = $teleportDestination;
        if (empty($teleportDestination->getDestination())) {
            $teleportDestination->setDestination($this);
        }

    }

    public function render(): string
    {
        return 'teleport.png';
    }
}
