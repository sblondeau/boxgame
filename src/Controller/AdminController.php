<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 11/02/19
 * Time: 22:46
 */

namespace App\Controller;


use App\Model\LevelManager;
use App\Model\Tile;
use App\Model\TileManager;

class AdminController
{
    const TILES = ['Box', 'Finish', 'Hammer', 'Hole', 'Teleport', 'Wall'];

    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function designLevel(int $levelNumber)
    {
        $levelManager = new LevelManager();
        $level = $levelManager->findByNumber($levelNumber);

        $tileManager = new TileManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['x']) && isset($_POST['y'])) {

            try {
                $tile = $tileManager->isTile($level->getId(), $_POST['x'], $_POST['y']);

                if($tile) {
                    if (in_array($_POST['tileType'], self::TILES)) {
                        $tileManager->update($tile, $_POST['tileType']);
                    } else {
                        $tileManager->delete($tile);
                    }
                } elseif (in_array($_POST['tileType'], self::TILES)) {
                    $tileManager->add($level->getId(), $_POST['tileType'], $_POST['x'], $_POST['y']);
                }

            } catch (\PDOException $e) {
                echo($e->getMessage());
            }
        }

        return $this->twig->render('admin.html.twig', [
                'level'     => $level,
                'tilesType' => self::TILES,
            ]
        );

    }
}