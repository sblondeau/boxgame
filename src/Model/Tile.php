<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 09/01/19
 * Time: 00:09
 */

namespace App\Model;


abstract class Tile
{

    private $x;
    private $y;

    private $movable;
    private $traversable;

    /**
     * Box constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x = 0, int $y = 0)
    {
        $this->setX($x);
        $this->setY($y);
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     * @return Box
     */
    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     * @return Box
     */
    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    /**
     * @return mixed
     */
    public function isMovable(): bool
    {
        return $this->movable;
    }

    /**
     * @param mixed $movable
     * @return Tile
     */
    public function setMovable(bool $movable)
    {
        $this->movable = $movable;

        return $this;
    }

    /**
     * @return mixed
     */
    public function isTraversable() :bool
    {
        return $this->traversable;
    }

    /**
     * @param mixed $traversable
     * @return Tile
     */
    public function setTraversable(bool $traversable)
    {
        $this->traversable = $traversable;
        return $this;
    }


    abstract public function render(): string;
}