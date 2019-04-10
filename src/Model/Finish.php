<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App\Model;

use SplSubject;

class Finish extends Tile implements \SplObserver
{
    public function __construct(int $x = 0, int $y = 0)
    {
        parent::__construct($x, $y);
        $this->setMovable(false);
        $this->setTraversable(true);
    }

    public function update(SplSubject $subject)
    {
        if ($subject->getPlayer()->getX() === $this->getX() && $subject->getPlayer()->getY() === $this->getY()) {
            $subject->setWin(true);
        }
    }

    public function render(): string
    {
        return 'finish.png';
    }
}
