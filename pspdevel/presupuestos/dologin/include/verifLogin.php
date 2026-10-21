<?php
	if(file_exists('include'))
		$path = '';
	else
		$path = '../';
	require $path.'../../include/sql.php';
	session_start();
	if(isset($_POST['COMMANDE_LOGIN'])) {
		$login = getParametre('login');
		$password = getParametre('password');
		if($login != '' && $password != '') {
			// Note: Passwords are encrypted using MD5
			$req = execute_sql("SELECT id_membre,nombre,pseudo,level FROM admin WHERE pseudo='".addslashes($login)."' AND passe=MD5('".addslashes($password)."')");
			//$req2 = "SELECT id_membre,nombre,pseudo,level FROM admin WHERE pseudo='$login'";	
			//$req = execute_sql("SELECT id_membre,nombre,pseudo,level FROM admin WHERE pseudo='$login'");			
			if($req === FALSE)
				exit('DATABASE ERROR WHILE AUTHENTICATING');
			if($data = mysqli_fetch_assoc($req))
				$_SESSION['user'] = $data;
			else
				// TODO: We should show message embedded in the template
				echo '<div align=center class=error>POr favor escribe nuevamente login y password !</div>';
				//echo '<div align=center class=error>'.$req2.'</div>';
		}
	}
	if(!isset($_SESSION['user'])) {
		$template = file_get_contents($path.'templates/login.html');
		echo str_replace('$path', $path, $template);
		exit();
	}
	// Otherwise, the including file will be executed
?>