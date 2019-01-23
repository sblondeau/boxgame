<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App;

class Box extends Tile
{
    public function __construct(int $x = 0, int $y = 0)
    {
        parent::__construct($x, $y);
        $this->setMovable(true);
        $this->setTraversable(false);
    }

    public function render(): string
    {
        return 'box.png';
    }
}
