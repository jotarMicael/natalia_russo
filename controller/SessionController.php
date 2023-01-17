<?php

class SessionController {

	public static function mustBeLoggedIn() {
		if(!isset($_SESSION['IN']) || !$_SESSION['IN']) {
			header('Location: ' . BASE_URL . 'views/logout.php');
  			exit();
        }
	}

	/*public static function mustBeAdminLoggedIn() {
		if(!isset($_SESSION['IN']) || $_SESSION['rol'] != 'ADM') {
			header('Location: ' . BASE_URL . '/views/logout.php');
  			die();
		}
	}
	*/

	public static function isLoggedIn() {
		return isset($_SESSION['IN']) && $_SESSION['IN'];
	}

}