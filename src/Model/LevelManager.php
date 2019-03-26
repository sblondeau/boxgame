<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 10/02/19
 * Time: 13:31
 */

namespace App\Model;

class LevelManager
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO(DSN, USER, PASS);
    }

    public function findAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM level');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByNumber(int $number)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM level where number=:number');
        $stmt->bindValue('number', $number);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_CLASS, Level::class);
        return $stmt->fetch();
    }

    public function add()
    {

    }

    public function update(Level $level)
    {

    }

    public function delete(Level $level)
    {

    }
}