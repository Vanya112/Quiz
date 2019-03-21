<?php
/**
 * Created by PhpStorm.
 * User: rufus
 * Date: 24.08.2018
 * Time: 13:46
 */

namespace App\Services\Admin;


use Symfony\Component\HttpFoundation\Response;

class editUser
{
    public function editData($data)
    {
        return new Response('<html><div>edit</div>'.$data.'</body></html>');
    }
}