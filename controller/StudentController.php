<?php

require_once ROOTPATH . '/model/Student.php';
require_once ROOTPATH . '/db/Database.php';

class StudentController
{

	function insert_student(&$student_)
	{


		$database = new Database();
		$db = $database->getConnection();

		$student = new Student($db);


        return $student->insert_student($student_);
		
	}

	function get_all_students()
	{


		$database = new Database();
		$db = $database->getConnection();

		$student = new Student($db);


        return $student->get_all_student();
		
	}

}
