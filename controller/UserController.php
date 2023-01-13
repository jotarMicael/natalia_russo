<?php

require_once ROOTPATH . '/model/User.php';
require_once ROOTPATH . '/db/Database.php';

class UserController
{

	function login()
	{

		$errors = array();

		if (!isset($_POST['username']) || empty($_POST['username'])) {
			$errors["username"] = array('Debe ingresar el Usuario.');
		}
		if (!isset($_POST['password']) || empty($_POST['password'])) {
			$errors["password"] = array('Debe ingresar la Clave.');
		}

		if (!empty($errors)) {
			return $errors;
		}

		$database = new Database();
		$db = $database->getConnection();

		$user = new User($db);

		$user->username = trim($_POST['username']);
		$user->password = trim($_POST['password']);

		$user->password = md5($user->username . $user->password);

		$user->login();

		if ($user->user_id != null) {

			$user->updateLastLogin();

			$this->setSession($user);

			/*if($user->rol == 'OPE') {
				header('Location: home.php');
			} elseif($user->rol == 'ADM') {
				header('Location: adm/home/');
			} */
			header('Location: ' . BASE_URL . 'views/students/create_student.php');
			die();
		} else {
			$errors['password'] = array("error" => "Usuario o clave incorrecta.");
			return $errors;
		}
	}


	function changePassword()
	{

		$database = new Database();
		$db = $database->getConnection();

		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$user = new User($db);

		$user->user_id = intval($_SESSION['user_id']);

		$user->findById();

		$user->password = trim($_POST['password']);
		$user->password = md5($user->username . $user->password);

		try {

			$user->changePassword();

			header('Location: ' . BASE_URL . 'logout.php');
			die();
		} catch (PDOException $ex) {

			$errors['db'] = array("Se ha producido un error, intentalo más tarde.");

			return $errors;
		}
	}

	function setSession($user)
	{
		$_SESSION['IN'] = true;
		$_SESSION['msg'] = true;
		$_SESSION['user_id'] = intval($user->user_id);
		$_SESSION['user'] = $user->name;
		$_SESSION['rol'] = $user->rol;
	}
}
