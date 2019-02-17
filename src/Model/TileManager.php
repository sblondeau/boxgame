<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 10/02/19
 * Time: 13:31
 */

namespace App\Model;

class TileManager extends AbstractManager
{

    public function findAll(Level $level) :array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tile where level_id=:level');
        $stmt->bindValue('level', $level->getId());
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find(Tile $tile)
    {
//        $stmt = $this->pdo->prepare('SELECT * FROM level WHERE x=:x AND y:y');
//        $stmt->bindParam('x', $tile->getX());
//        $stmt->bindParam('y', $tile->getY());
    }

    public function add()
    {

    }

    public function update(Tile $tile)
    {

    }

    public function delete(Tile $tile)
    {

    }
}