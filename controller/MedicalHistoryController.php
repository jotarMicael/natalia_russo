<?php

require_once ROOTPATH . '/model/MedicalHistory.php';
require_once ROOTPATH . '/db/Database.php';

class MedicalHistoryController
{

	function get_medical_history($bool=false)
	{


		$database = new Database();
		$db = $database->getConnection();

		$medical_history= new MedicalHistory($db);
        
        return $medical_history->get_medical_history($bool);
		
	}

}
