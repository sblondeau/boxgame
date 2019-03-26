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
    echo $admin->designLevel($_GET['level']);
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

$levelManager = new LevelManager();
$levels = $levelManager->findAll();
$level = $levelManager->findByNumber($_SESSION['level'] ?? 1);

$tiles = $_SESSION['tiles'] ?? $level->getTiles();

$boxGame = new BoxGame($player, $level, $tiles, $twig);

$boxGame->getPlayer()->setHammer( $_SESSION['hammer'] ?? false);
$boxGame->getPlayer()->setDirection($_SESSION['direction'] ?? null);

if (!empty($_GET['destroy'])){
    $boxGame->destroy();
}

$dir = $_GET['dir'] ?? null;
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