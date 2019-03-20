<?php

namespace App\Services\Admin;

use App\Controller\Admin\DataDecodeController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class deleteUser extends AbstractController
{
    public function editData($data, $repository, $entityManager)
    {
        $decoder = new DataDecodeController();
        $getter = new getUsersId();
        $decode_data = $decoder -> DecodeStringToArray($data);
        $users_id = $getter -> getUsersIdArray($decode_data);
        $user_by_id = $repository->findBy(['id'=>$users_id]);
        for($i=0; $i<count($user_by_id); $i++)
        {

            if($user_by_id[$i]!=NULL)
                $entityManager->remove($user_by_id[$i]);
        }
        $entityManager->flush();
        return new Response('<html><body>success</body></body></html>');

    }

}