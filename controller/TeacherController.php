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

	function get_all_student_actives()
	{


		$database = new Database();
		$db = $database->getConnection();

		$student = new Student($db);


		return $student->get_all_student_actives();
	}

	function get_information_student(&$student_id)
	{
		$database = new Database();
		$db = $database->getConnection();

		$student = new Student($db);


		return $student->get_information_student($student_id);
	}

	function pay_social_fee(&$student_id, $share_date, &$import)
	{

		$database = new Database();
		$db = $database->getConnection();

		$student = new Student($db);


		return $student->pay_social_fee($student_id, $share_date, $import);
	}

	function generate_fee_pdf(&$share_id)
	{
		$database = new Database();
		$db = $database->getConnection();
		$student = new Student($db);

		return $student->generate_fee_pdf($share_id);
	}
}
