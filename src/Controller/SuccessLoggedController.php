<?php

namespace App\Controller\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SuccessLoggedController extends AbstractController
{
    /**
     * @Route("/logged", name="logged")
     */
    public function logged()
    {
        return $this->redirectToRoute('homeController',array('type'=>"logging"),301);
    }

}