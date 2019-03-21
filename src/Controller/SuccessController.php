<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuccessController extends AbstractController
{
    /**
     * @Route("/success/{type}/", name="success")
     *
     * @return Response
     */
    public function access(string $type): Response
    {

        return $this->render('success.html.twig', ['type' => $type]);
    }


}