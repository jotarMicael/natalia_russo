<?php

require_once ROOTPATH . '/model/Disease.php';
require_once ROOTPATH . '/db/Database.php';

class DiseaseController
{

	function get_diseases($type)
	{


		$database = new Database();
		$db = $database->getConnection();

		$disease = new Disease($db);


        return $disease->get_diseases($type);
		
	}

}
