<?php

use App\Box;
use App\BoxGame;
use App\Finish;
use App\Hammer;
use App\Hole;
use App\Player;
use App\Teleport;
use App\Wall;

require '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../src/View');
$twig = new Twig_Environment($loader, []);

session_start();

if (!empty($_GET['start'])) {
    session_destroy();
    session_start();
}


$player = new Player($_SESSION['player']['x'] ?? 0, $_SESSION['player']['y'] ?? 0);

$dir = $_GET['dir'] ?? null;



if (empty($_SESSION['tiles'])) {
    $level = $_GET['level'] ?? 1;
    if ($level==1) {
        $tiles[] = new Hammer(1, 0);
        $tiles[] = new Box(7, 0);
        $tiles[] = new Box(1, 1);
        $tiles[] = new Box(2, 1);
        $tiles[] = new Box(6, 1);
        $tiles[] = new Box(8, 1);
        $tiles[] = new Box(2, 2);
        $tiles[] = new Box(5, 2);
        $tiles[] = new Box(9, 2);
        $tiles[] = new Box(1, 3);
        $tiles[] = new Box(3, 3);
        $tiles[] = new Box(0, 4);
        $tiles[] = new Box(3, 4);
        $tiles[] = new Box(7, 4);
        $tiles[] = new Box(9, 4);
        $tiles[] = new Box(1, 5);
        $tiles[] = new Box(4, 5);
        $tiles[] = new Box(6, 5);
        $tiles[] = new Box(7, 5);
        $tiles[] = new Box(3, 6);
        $tiles[] = new Box(1, 7);
        $tiles[] = new Box(4, 7);
        $tiles[] = new Box(5, 7);

        $tiles[] = new Wall(2, 0);
        $tiles[] = new Wall(0, 1);
        $tiles[] = new Wall(4, 1);
        $tiles[] = new Wall(4, 2);
        $tiles[] = new Wall(7, 2);
        $tiles[] = new Wall(8, 3);
        $tiles[] = new Wall(2, 4);
        $tiles[] = new Wall(5, 5);
        $tiles[] = new Wall(8, 5);
        $tiles[] = new Wall(5, 6);
        $tiles[] = new Wall(8, 6);
        $tiles[] = new Wall(8, 7);

        $tiles[] = new Hole(5, 3);
        $tiles[] = new Hole(9, 3);
        $tiles[] = new Hole(9, 5);
        $tiles[] = new Hole(1, 6);
    }
    if ($level==2) {
        $teleport1 = new Teleport(3,2);
        $teleport2 = new Teleport(0,7);
        $teleport1->setDestination($teleport2);

        $tiles[] = $teleport1;
        $tiles[] = $teleport2;
        $tiles[] = new Wall(6, 2);
        $tiles[] = new Wall(2, 5);
        $tiles[] = new Hole(3, 7);
    }


    $tiles[] = new Finish(9, 7);
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

if (!$dir) {
    echo $twig->render('index.html.twig', [
            'game' => $boxGame,
        ]
    );
} else {
    echo $boxGame->render();
}