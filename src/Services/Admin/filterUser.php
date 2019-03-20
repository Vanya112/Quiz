<?php
namespace App\Services\Admin;


use Symfony\Component\HttpFoundation\Response;

class filterUser
{
    public function filterData($data, $username, $email, $id)
    {
        $compare = new concurrencesFinder();
        $string_data = json_encode($data);
        $array_data = json_decode($string_data,true);
        $var = array();
        $counter = 0;
        $string='';
        if($username) {
            for ($i = 0; $i < count($array_data); $i++) {
                if ($compare->finder($array_data[$i]['username'], $username)) {
                    $var[$counter] = $array_data[$i];;
                    $counter++;
                }
            }
            return $response = new Response(json_encode($var));
        }
        else return $response = new Response(json_encode($data));

    }

}