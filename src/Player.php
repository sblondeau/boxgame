<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App;


class Player
{
    private $x;
    private $y;

    private $direction;
    /**
     * Player constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x = 0, int $y = 0, $direction='E')
    {
        $this->setX($x);
        $this->setY($y);
        $this->setDirection($direction);
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
     * @return Player
     */
    public function setX(int $x): Player
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
     * @return Player
     */
    public function setY(int $y): Player
    {
        $this->y = $y;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param mixed $direction
     * @return Player
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    public function render() {
        return 'player.png';
    }
}