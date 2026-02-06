<?php
//session_start();
require('includes/functions.php');

if (!isset($_SESSION["login"])) {
	header('Location: home.php');
	exit;
}else{
	header('Location: dashboard.php');
}

?>
