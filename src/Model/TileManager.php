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

    /**
     * @param Level $level
     * @return array
     */
    public function findAll(Level $level) :array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM tile where level_id=:level');
        $stmt->bindValue('level', $level->getId());
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $level
     * @param int $x
     * @param int $y
     * @return Tile|null
     */
    public function isTile(int $level, int $x, int $y)
    {
        $stmt = $this->pdo->prepare('SELECT type, id, x, y, level_id FROM tile WHERE x=:x AND y=:y AND level_id=:level');
        $stmt->bindParam('level', $level, \PDO::PARAM_INT);
        $stmt->bindParam('x', $x, \PDO::PARAM_INT);
        $stmt->bindParam('y', $y, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch()['id'];
    }

    /**
     * @param int $level
     * @param string $tileType
     * @param int $x
     * @param int $y
     */
    public function add(int $level, string $tileType, int $x, int $y) :void
    {
        $stmt = $this->pdo->prepare('INSERT INTO tile (x, y, type, level_id) VALUES(:x, :y, :type, :level)');
        $stmt->bindValue('x', $x, \PDO::PARAM_INT);
        $stmt->bindValue('y', $y, \PDO::PARAM_INT);
        $stmt->bindValue('type', $tileType, \PDO::PARAM_STR);
        $stmt->bindValue('level', $level, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @param Tile $tile
     * @param string $tileType
     */
    public function update(int $tile, string $tileType)
    {
        $stmt = $this->pdo->prepare('UPDATE tile SET type=:type WHERE id=:id');
        $stmt->bindValue('type', $tileType, \PDO::PARAM_STR);
        $stmt->bindValue('id', $tile, \PDO::PARAM_INT);

        $stmt->execute();
    }

    /**
     * @param Tile $tile
     */
    public function delete(int $tile) :void
    {
        if ($tile) {
            $stmt = $this->pdo->prepare('DELETE FROM tile WHERE id=:id');
            $stmt->bindValue('id', $tile, \PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}