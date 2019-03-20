<?php
/**
 * Created by PhpStorm.
 */

namespace App\Controller\Admin;


use App\Services\Admin\deleteUser;
use App\Services\Admin\editUser;
use App\Services\Admin\filterUser;

class DatabaseEditController
{
	public function find(){
        	$delete = new deleteUser();
        	$filter = new filterUser();
        	$edit = new editUser();
        	$services = array("delete","edit","filter");
    	}
}