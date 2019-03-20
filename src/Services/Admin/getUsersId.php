<?php
/**
 * Created by PhpStorm.
 * User: rufus
 * Date: 25.08.2018
 * Time: 12:10
 */

namespace App\Services\Admin;


class getUsersId
{
    public function getUsersIdArray($usersData)
    {
        $users_id_array = array();
        for ($i=0; $i < count($usersData); $i++)
        {
            $users_id_array[$i] = $usersData[$i]['id'];
        }
        return $users_id_array;
    }

}