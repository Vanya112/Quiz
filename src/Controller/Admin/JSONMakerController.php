<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Services\Admin\filterUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JSONMakerController extends AbstractController
{
    /**
     * @Route("ajax/usertable.{format}", name="usertableajax")
     * @return Response
     */
    public function ajaxUserTable(string $format)
    {
        
    }

}