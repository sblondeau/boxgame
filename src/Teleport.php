<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App;


class Teleport extends Tile
{

    private $destination;

    public function __construct(int $x = 0, int $y = 0)
    {
        parent::__construct($x, $y);
        $this->setMovable(false);
        $this->setTraversable(true);
    }

    public function setDestination(Teleport $teleportDestination)
    {
        $this->destination = $teleportDestination;
        if (empty($teleportDestination->getDestination())) {
            $teleportDestination->setDestination($this);
        }

    }

    public function getDestination() : ?Teleport
    {
        return $this->destination;
    }


    public function render(): string
    {
        return 'teleport.png';
    }
}
