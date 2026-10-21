<?php
	if(isset($_REQUEST[session_name()]) || defined('SID')) {
		session_start();
		$_SESSION = array();
		session_destroy();
	}
	setcookie(session_name(), '', time() - 42000);
	header('Location: index.php');
?>