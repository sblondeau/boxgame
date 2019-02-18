<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App\Model;

use App\BoxGame;
use SplSubject;

class Hammer extends Tile implements \SplObserver
{
    public function __construct(int $x = 0, int $y = 0)
    {
        parent::__construct($x, $y);
        $this->setMovable(false);
        $this->setTraversable(true);
    }

    public function render(): string
    {
        return 'hammer.png';
    }

    /**
     * @param SplSubject|BoxGame $subject
     */
    public function update(SplSubject $subject)
    {
        if ($subject->getPlayer()->getX() === $this->getX() && $subject->getPlayer()->getY() === $this->getY()) {
            $subject->getPlayer()->setHammer(true);
            $subject->removeTile($this);
        }
    }



}
