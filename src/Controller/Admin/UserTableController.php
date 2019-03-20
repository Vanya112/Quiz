<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserTableController extends AbstractController
{
    /**
     * @Route("/usertable",name="userTableController")
     */
    public function home(UserRepository $userRepository)
    {
        return $this->render('admin/usertable.html.twig', ['user' => $userRepository->findAll()]);
    }
}