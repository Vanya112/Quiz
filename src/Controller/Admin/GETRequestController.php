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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(User::class);
        $delete = new deleteUser();
        $filter = new filterUser();
        $edit = new editUser();
        $services = array("delete");
        $request = Request::createFromGlobals();
        $type = $request->query->get('type');
        if (in_array($type, $services))
        {
            $response = $$type -> editData($request->query->get('data'), $repository, $em);
            return $response;
        }
        return new Response('<html><body>1234</body></html>');
    }
}