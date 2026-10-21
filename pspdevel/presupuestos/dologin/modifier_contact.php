<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	if(empty($_REQUEST['email']))
		// These errors should never occur, because filtered by JavaScript
		exit('email non specificata');
	if(!isset($_REQUEST['vendeur']))
		// These errors should never occur, because filtered by JavaScript
		exit('venditore not specificato');
	if(empty($_REQUEST['vendu']))
		// These errors should never occur, because filtered by JavaScript
		exit('venduto not specificato');
	$vendu = $_REQUEST['vendu'];
	if($vendu != 'si')
		$vendu = 'no';
	if(!execute_sql("UPDATE email_contact SET vendeur='".addslashes($_REQUEST['vendeur'])."',vendu='".$vendu."' WHERE email='".$_REQUEST['email']."'"))
		exit(mysqli_error());
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/clienti/dologin/index.php');
?>