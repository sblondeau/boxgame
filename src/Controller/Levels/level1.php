<?php


use App\Model\Box;
use App\Model\Hammer;
use App\Model\Wall;
use App\Model\Hole;
use App\Model\Finish;

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
$tiles[] = new Box(9, 6);
$tiles[] = new Box(1, 7);
$tiles[] = new Box(4, 7);
$tiles[] = new Box(5, 7);

$tiles[] = new Hammer(6, 7);

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

$tiles[] = new Finish(9, 7);

return $tiles;