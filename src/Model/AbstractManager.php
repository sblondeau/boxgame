<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 10/02/19
 * Time: 20:48
 */

namespace App\Model;


abstract class AbstractManager
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO(DSN, USER, PASS);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); // Set Errorhandling to Exception
    }


}