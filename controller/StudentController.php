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

	function delete_student(&$student_id)
	{
		$database = new Database();
		$db = $database->getConnection();
		$student = new Student($db);
		return $student->delete_student($student_id);
	}

	function get_only_student(&$student_id)
	{
		$database = new Database();
		$db = $database->getConnection();
		$student = new Student($db);
		return $student->get_only_student($student_id);
	}

	function update_student(&$student_){

		$database = new Database();
		$db = $database->getConnection();
		$student = new Student($db);
		return $student->update_student($student_);
	}

	function get_students_birthdate(){
		$database = new Database();
		$db = $database->getConnection();
		$student = new Student($db);
		return $student->get_students_birthdate();
	}
}
