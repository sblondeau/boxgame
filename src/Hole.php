<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App;


class Hole extends Tile
{
    public function __construct(int $x = 0, int $y = 0)
    {
        parent::__construct($x, $y);
        $this->setMovable(false);
        $this->setTraversable(false);
    }

    public function render(): string
    {
        return $this->isTraversable() ? 'traversable_hole.png' : 'not_traversable_hole.png';
    }
}
