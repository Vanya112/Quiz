<?php
/**
 * Created by PhpStorm.
 * User: rufus
 * Date: 16.08.2018
 * Time: 17:09
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/",name="homeController")
     */
    public function home()
    {
        return $this->render('index.html.twig');
    }
}