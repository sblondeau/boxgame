<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 13:57
 */

namespace Tests;


use App\Model\Box;
use App\Model\Finish;
use App\Model\Hammer;
use App\Model\Hole;
use App\Model\Teleport;
use App\Model\Wall;
use PHPUnit\Framework\TestCase;
use App\BoxGame;
use App\Model\Player;

class MoveTest extends TestCase
{
    public function testInitialPlayerPosition()
    {
        $player = new Player(0, 0);
        $boxGame = new BoxGame($player);
        $this->assertEquals(0, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());
    }

    public function testSimpleMovePlayer()
    {
        $player = new Player(2, 2);
        $boxGame = new BoxGame($player);
        $boxGame->movePlayer('N');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(1, $boxGame->getPlayer()->getY());
    }

    public function testMultipleMovePlayer()
    {
        $player = new Player(2, 2);
        $boxGame = new BoxGame($player);
        $boxGame->movePlayer('S');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(3, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('E');
        $this->assertEquals(3, $boxGame->getPlayer()->getX());
        $this->assertEquals(3, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('N');
        $this->assertEquals(3, $boxGame->getPlayer()->getX());
        $this->assertEquals(2, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('W');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(2, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('N');
        $boxGame->movePlayer('N');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());
    }

    public function testWithBox()
    {
        $player = new Player(2, 2);
        $box = new Box(3, 3);
        $boxGame = new BoxGame($player, [$box]);
        $boxGame->movePlayer('S');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(3, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('E');
        $this->assertEquals(3, $boxGame->getPlayer()->getX());
        $this->assertEquals(3, $boxGame->getPlayer()->getY());
    }

    public function testMultipleBox()
    {
        $player = new Player(2, 2);
        $boxes[] = new Box(3, 2);
        $boxes[] = new Box(4, 2);
        $boxGame = new BoxGame($player, $boxes);
        $boxGame->movePlayer('E');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(2, $boxGame->getPlayer()->getY());
    }

    public function testMultipleBoxWithSpace()
    {
        $player = new Player(2, 2);
        $boxes[] = new Box(3, 2);
        $boxes[] = new Box(5, 2);

        $boxGame = new BoxGame($player, $boxes);
        $boxGame->movePlayer('E');
        $this->assertEquals(3, $boxGame->getPlayer()->getX());
        $this->assertEquals(2, $boxGame->getPlayer()->getY());

        $boxGame->movePlayer('E');
        $this->assertEquals(3, $boxGame->getPlayer()->getX());
        $this->assertEquals(2, $boxGame->getPlayer()->getY());
    }

    public function testMoveLimit()
    {
        $player = new Player(1, 1);

        $boxGame = new BoxGame($player);

        $boxGame->movePlayer('N');
        $this->assertEquals(1, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());

        $boxGame->movePlayer('N');
        $this->assertEquals(1, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());

        $boxGame->movePlayer('W');
        $this->assertEquals(0, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());

        $boxGame->movePlayer('W');
        $this->assertEquals(0, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());
    }

    public function testMoveLimitBox()
    {
        $player = new Player(2, 2);
        $boxes[] = new Box(2, 1);

        $boxGame = new BoxGame($player, $boxes);

        $boxGame->movePlayer('N');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(1, $boxGame->getPlayer()->getY());

        $boxGame->movePlayer('N');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(1, $boxGame->getPlayer()->getY());

        $boxGame->movePlayer('E');
        $boxGame->movePlayer('N');
        $this->assertEquals(3, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());

        $boxGame->movePlayer('W');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());

        $boxGame->movePlayer('W');
        $this->assertEquals(1, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('W');
        $this->assertEquals(1, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());
    }

    public function testUnMovableBox()
    {
        $player = new Player(2, 2);
        $boxes[] = new Wall(2, 1);

        $boxGame = new BoxGame($player, $boxes);

        $boxGame->movePlayer('N');
        $this->assertEquals(2, $boxGame->getPlayer()->getX());
        $this->assertEquals(2, $boxGame->getPlayer()->getY());
    }

    public function testWin()
    {
        $player = new Player(5, 4);
        $tiles[] = new Finish(6, 5);

        $boxGame = new BoxGame($player, $tiles);
        $boxGame->movePlayer('S');
        $this->assertFalse($boxGame->isWin());
        $boxGame->movePlayer('E');
        $this->assertTrue($boxGame->isWin());
    }

    public function testFalseDirection()
    {
        $this->expectException(\LogicException::class);
        $player = new Player();

        $boxGame = new BoxGame($player);
        $boxGame->movePlayer('A');
    }

    public function testHole()
    {
        $player = new Player(5, 5);
        $tiles[] = new Hole(6, 5);

        $boxGame = new BoxGame($player, $tiles);
        $boxGame->movePlayer('E');
        $this->assertEquals(5, $boxGame->getPlayer()->getX());

    }

    public function testHoleWithBox()
    {
        $player = new Player(4, 5);
        $tiles[] = new Box(5, 5);
        $tiles[] = new Hole(6, 5);

        $boxGame = new BoxGame($player, $tiles);
        $boxGame->movePlayer('E');
        $this->assertEquals(5, $boxGame->getPlayer()->getX());
        $boxGame->movePlayer('E');
        $this->assertEquals(6, $boxGame->getPlayer()->getX());

    }

    public function testTeleportation()
    {
        $player = new Player(0, 0);
        $teleport1 = new Teleport(1, 0);
        $teleport2 = new Teleport(6, 6);
        $teleport1->setDestination($teleport2);

        $tiles[] = $teleport1;
        $tiles[] = $teleport2;

        $boxGame = new BoxGame($player, $tiles);
        $boxGame->movePlayer('E');
        $this->assertEquals(6, $boxGame->getPlayer()->getX());
        $this->assertEquals(6, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('N');
        $boxGame->movePlayer('S');
        $this->assertEquals(1, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());
    }

    public function testTeleportationWithBlockingTile()
    {
        $player = new Player(0, 0);
        $teleport1 = new Teleport(1, 0);
        $teleport2 = new Teleport(6, 6);
        $teleport1->setDestination($teleport2);

        $tiles[] = $teleport1;
        $tiles[] = $teleport2;
        $tiles[] = new Wall(6,5);

        $boxGame = new BoxGame($player, $tiles);
        $boxGame->movePlayer('E');
        $this->assertEquals(6, $boxGame->getPlayer()->getX());
        $this->assertEquals(6, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('N');
        $this->assertEquals(6, $boxGame->getPlayer()->getX());
        $this->assertEquals(6, $boxGame->getPlayer()->getY());
        $boxGame->movePlayer('S');
        $boxGame->movePlayer('N');
        $this->assertEquals(1, $boxGame->getPlayer()->getX());
        $this->assertEquals(0, $boxGame->getPlayer()->getY());
    }

    public function testGetHammer()
    {
        $player = new Player(4, 5);
        $this->assertNull($player->getHammer());

        $tiles[] = new Hammer(5, 5);
        $boxGame = new BoxGame($player, $tiles);
        $boxGame->movePlayer('E');
        $this->assertTrue($player->getHammer());
        $this->assertEquals(5, $boxGame->getPlayer()->getX());

    }

    public function testHammerMoveBox()
    {
        $player = new Player(4, 5);
        $tiles[] = new Box(5, 5);
        $tiles[] = new Hammer(6, 5);
        $boxGame = new BoxGame($player, $tiles);
        $boxGame->movePlayer('E');
        $this->assertEquals(4, $boxGame->getPlayer()->getX());
    }

    public function testDestroyTile()
    {
        $player = new Player(4, 5);
        $player->setHammer(true);
        $box = new Box(5, 5);
        $box2 = new Box(6, 5);
        $tiles[] = $box;
        $tiles[] = $box2;

        $boxGame = new BoxGame($player, $tiles);
        $boxGame->movePlayer('E');
        $this->assertEquals(4, $boxGame->getPlayer()->getX());
        $boxGame->destroy();
        $boxGame->movePlayer('E');
        $this->assertEquals(5, $boxGame->getPlayer()->getX());
        $this->assertFalse($player->getHammer());

    }


    public function testDestroyAndMoveAcrossBox()
    {
        $player = new Player(4, 5);
        $player->setHammer(true);

        $box = new Box(5, 5);
        $box2 = new Box(6, 5);
        $tiles[] = $box;
        $tiles[] = $box2;

        $boxGame = new BoxGame($player, $tiles);
        $boxGame->destroy();
        $boxGame->movePlayer('E');
        $boxGame->destroy();

        $this->assertEquals(5, $boxGame->getPlayer()->getX());
        $player->setHammer(true);
        $boxGame->movePlayer('E');
        $boxGame->destroy();

        $this->assertEquals(6, $boxGame->getPlayer()->getX());

    }

}