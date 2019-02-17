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
    public function getTiles()
    {
        $tileManager = new TileManager();
        $tiles = $tileManager->findAll($this);
        foreach ($tiles as $tile) {
            $tileType = 'App\Model\\' .ucfirst($tile['type']);
            $tile = (new  $tileType)->setX($tile['x'])->setY($tile['y']);
            $tiles[] = $tile;
        }
        return $tiles;
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


}