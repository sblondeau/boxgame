<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 11/02/19
 * Time: 22:46
 */

namespace App\Controller;


class AdminController
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function make()
    {
        return $this->twig->render('admin.html.twig', [
            ]
        );

    }
}