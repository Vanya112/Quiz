<?php
/**
 * Created by PhpStorm.
 * User: rufus
 * Date: 27.08.2018
 * Time: 4:23
 */

namespace App\Services\Admin;


class concurrencesFinder
{
    public function finder($data, $string)
    {
        return (bool) strpos('@'.$data, $string);
    }

}