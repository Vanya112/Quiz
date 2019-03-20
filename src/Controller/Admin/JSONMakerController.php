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
        $filter = new filterUser();
        $request = Request::createFromGlobals();
        $username = $request->query->get('username');
        $id = $request->query->get('id');
        $email = $request->query->get('email');
        if ($format == 'json') {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $data = $repository->findAll();
            $filter_data = $filter->filterData($data, $username, $email, $id);

            return $filter_data;
        }
        return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
    }

}