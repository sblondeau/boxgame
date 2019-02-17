<?php

use App\BoxGame;
use App\Model\LevelManager;
use App\Model\Player;


require '../vendor/autoload.php';
require '../config/db.php';

$loader = new Twig_Loader_Filesystem('../src/View');
$twig = new Twig_Environment($loader, []);

session_start();

if(!empty($_GET['route']) && $_GET['route']=='admin') {
    $admin = new \App\Controller\AdminController($twig);
    echo $admin->make();
    exit();
}

if (!empty($_GET['level'])) {
    if ($_GET['level'] != ($_SESSION['level'] ?? 1)) {
        session_destroy();
        session_start();
    }
    $_SESSION['level'] = $_GET['level'];
}

$player = new Player($_SESSION['player']['x'] ?? 0, $_SESSION['player']['y'] ?? 0);

$dir = $_GET['dir'] ?? null;

$levelManager = new LevelManager();
$levels = $levelManager->findAll();
$level = $levelManager->findByNumber($_SESSION['level'] ?? 1);

if (empty($_SESSION['tiles'])) {
    $tiles = $level->getTiles();

//    if ($level==1) {
//        $tiles[] = new Hammer(6, 7);
//        $tiles[] = new Box(7, 0);
//        $tiles[] = new Box(1, 1);
//        $tiles[] = new Box(2, 1);
//        $tiles[] = new Box(6, 1);
//        $tiles[] = new Box(8, 1);
//        $tiles[] = new Box(2, 2);
//        $tiles[] = new Box(5, 2);
//        $tiles[] = new Box(9, 2);
//        $tiles[] = new Box(1, 3);
//        $tiles[] = new Box(3, 3);
//        $tiles[] = new Box(0, 4);
//        $tiles[] = new Box(3, 4);
//        $tiles[] = new Box(7, 4);
//        $tiles[] = new Box(9, 4);
//        $tiles[] = new Box(1, 5);
//        $tiles[] = new Box(4, 5);
//        $tiles[] = new Box(6, 5);
//        $tiles[] = new Box(7, 5);
//        $tiles[] = new Box(3, 6);
//        $tiles[] = new Box(1, 7);
//        $tiles[] = new Box(4, 7);
//        $tiles[] = new Box(5, 7);
//        $tiles[] = new Box(9, 6);
//
//        $tiles[] = new Wall(2, 0);
//        $tiles[] = new Wall(0, 1);
//        $tiles[] = new Wall(4, 1);
//        $tiles[] = new Wall(4, 2);
//        $tiles[] = new Wall(7, 2);
//        $tiles[] = new Wall(8, 3);
//        $tiles[] = new Wall(2, 4);
//        $tiles[] = new Wall(5, 5);
//        $tiles[] = new Wall(8, 5);
//        $tiles[] = new Wall(5, 6);
//        $tiles[] = new Wall(8, 6);
//        $tiles[] = new Wall(8, 7);
//
//        $tiles[] = new Hole(5, 3);
//        $tiles[] = new Hole(9, 3);
//        $tiles[] = new Hole(9, 5);
//        $tiles[] = new Hole(1, 6);
//    }
//    if ($level==2) {
//        $teleport1 = new Teleport(3,2);
//        $teleport2 = new Teleport(0,7);
//        $teleport1->setDestination($teleport2);
//
//        $tiles[] = $teleport1;
//        $tiles[] = $teleport2;
//        $tiles[] = new Wall(6, 2);
//        $tiles[] = new Wall(2, 5);
//        $tiles[] = new Hole(3, 7);
//    }
//
//
//    $tiles[] = new Finish(9, 7);
} else {
    $tiles = $_SESSION['tiles'];
}

$boxGame = new BoxGame($player, $tiles, $twig);

$boxGame->getPlayer()->setHammer( $_SESSION['hammer'] ?? false);
$boxGame->getPlayer()->setDirection($_SESSION['direction'] ?? null);

if (!empty($_GET['destroy'])){
    $boxGame->destroy();
}

if (!empty($dir)) {
    $boxGame->movePlayer($dir);
    $_SESSION['direction'] = $dir;
}

$_SESSION['tiles'] = $boxGame->getTiles();
$_SESSION['player']['x'] = $boxGame->getPlayer()->getX();
$_SESSION['player']['y'] = $boxGame->getPlayer()->getY();
$_SESSION['hammer'] = $boxGame->getPlayer()->getHammer();

if (!$dir && empty($_GET['destroy'])) {
    echo $twig->render('index.html.twig', [
            'game' => $boxGame,
            'levels' => $levels,
            'currentLevel' => $level,
        ]
    );
} else {
    echo $boxGame->render();
}