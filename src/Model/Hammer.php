<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 02/01/19
 * Time: 14:01
 */

namespace App\Model;

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
     * @param SplSubject $subject
     */
    public function update(SplSubject $subject)
    {
        $tile = $this->getTile($this->getPlayer()->getX(), $this->getPlayer()->getY());
        if ($tile instanceof Hammer) {
            $this->getPlayer()->setHammer(true);
            $this->removeTile($tile);
        }
    }


}
