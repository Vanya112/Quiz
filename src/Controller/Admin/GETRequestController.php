<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Services\Admin\editUser;
use App\Services\Admin\deleteUser;
use App\Services\Admin\filterUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GETRequestController extends AbstractController
{
    /**
     * @Route("ajax/usertable/edit", name="usertabeditor")
     * @return Response
     */
    public function getClass()
    {
        
    }
}