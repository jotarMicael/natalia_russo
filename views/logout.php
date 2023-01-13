<?php 

require_once '../utils/const.php';

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_destroy();

header("Location: " . BASE_URL . "views/login.php");
die();