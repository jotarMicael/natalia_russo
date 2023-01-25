<?php

require_once ROOTPATH . '/model/SocialWork.php';
require_once ROOTPATH . '/db/Database.php';

class SocialWorkController
{

	function get_social_works()
	{


		$database = new Database();
		$db = $database->getConnection();

		$social_work = new SocialWork($db);


        return $social_work->get_social_works();
		
	}

	function get_only_social_work(&$id){

		$database = new Database();
		$db = $database->getConnection();

		$social_work = new SocialWork($db);


        return $social_work->get_only_social_work($id);

	}

}