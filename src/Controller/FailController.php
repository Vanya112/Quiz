<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FailController extends AbstractController
{
    /**
     * @Route("/fail/{type}/", name="fail")
     *
     * @return Response
     */
    public function fail(string $type): Response
    {
        $request = Request::createFromGlobals();
        $text = $request->query->get('text');
        return $this->render('fail.html.twig', ['type' => $type, 'text' => $text]);
    }


}