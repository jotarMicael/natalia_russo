<?php

require_once ROOTPATH . '/model/Teacher.php';
require_once ROOTPATH . '/db/Database.php';

class TeacherController
{

	function insert_teacher(&$teacher_)
	{


		$database = new Database();
		$db = $database->getConnection();

		$teacher = new Teacher($db);


		return $teacher->insert_teacher($teacher_);
	}

	function get_all_teachers(){

		$database = new Database();
		$db = $database->getConnection();

		$teacher = new Teacher($db);


		return $teacher->get_all_teachers();

	}


}
