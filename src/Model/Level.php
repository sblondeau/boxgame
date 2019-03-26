<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 10/02/19
 * Time: 13:30
 */

namespace App\Model;


class Level
{
    private $id;

    private $number;

    private $sizeX;
    private $sizeY;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Level
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getTiles() :array
    {
        $tileManager = new TileManager();
        $tiles = $tileManager->findAll($this);
        foreach ($tiles as $tile) {
            $tileType = 'App\Model\\' . ucfirst($tile['type']);
            $tile = (new  $tileType)->setX($tile['x'])->setY($tile['y']);
            $tilesArray[] = $tile;
        }

        return $tilesArray ?? [];
    }
    /**
     * @return mixed
     */
    public function getTilesArray() :array
    {
        foreach ($this->getTiles() as $tile) {
            $tilesArray[$tile->getX()][$tile->getY()] = $tile;
        }
        return $tilesArray ?? [];
    }


    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return Level
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSizeX()
    {
        return $this->sizeX;
    }

    /**
     * @param mixed $sizeX
     * @return Level
     */
    public function setSizeX($sizeX)
    {
        $this->sizeX = $sizeX;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSizeY()
    {
        return $this->sizeY;
    }

    /**
     * @param mixed $sizeY
     * @return Level
     */
    public function setSizeY($sizeY)
    {
        $this->sizeY = $sizeY;

        return $this;
    }



}