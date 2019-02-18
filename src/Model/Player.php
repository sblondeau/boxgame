<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App\Model;


class Player
{
    const DEFAULT_DIRECTION = 'E';
    private $x;
    private $previousX;
    private $y;
    private $previousY;

    private $direction;
    private $hammer;


    /**
     * Player constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x = 0, int $y = 0, $direction=self::DEFAULT_DIRECTION)
    {
        $this->setX($x);
        $this->setY($y);
        $this->setDirection($direction);
        if (!$this->getHammer() === null) {
            $this->setHammer(false);
        }
    }



    /**
     * @return int
     */
    public function getX(): ?int
    {
        return $this->x;
    }

    /**
     * @param int $x
     * @return Player
     */
    public function setX(int $x): Player
    {
        $this->setPreviousX($this->getX());
        $this->x = $x;

        return $this;
    }

    /**
     * @return int
     */
    public function getY(): ?int
    {
        return $this->y;
    }

    /**
     * @param int $y
     * @return Player
     */
    public function setY(int $y): Player
    {
        $this->setPreviousY($this->getY());
        $this->y = $y;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDirection() :string
    {
        return $this->direction ?? self::DEFAULT_DIRECTION;
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



    /**
     * @return mixed
     */
    public function getHammer() :?bool
    {
        return $this->hammer;
    }

    /**
     * @param boolean
     * @return Player
     */
    public function setHammer(bool $hammer) :self
    {
        $this->hammer = $hammer;

        return $this;
    }

    public function render() :string
    {
        return $this->getHammer() ? 'playerHammer.png' : 'player.png';
    }

    /**
     * @return mixed
     */
    public function getPreviousX() :?int
    {
        return $this->previousX;
    }

    /**
     * @param mixed $previousX
     * @return Player
     */
    public function setPreviousX(?int $previousX) :self
    {
        $this->previousX = $previousX;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPreviousY() :?int
    {
        return $this->previousY;
    }

    /**
     * @param mixed $previousY
     * @return Player
     */
    public function setPreviousY(?int $previousY) :self
    {
        $this->previousY = $previousY;

        return $this;
    }



}