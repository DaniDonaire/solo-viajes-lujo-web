<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	if(empty($_REQUEST['email']))
		// This error should never occur, because filtered by JavaScript
		exit('email not specified');
	// Get current vendor and state of this contact
	$email = $_REQUEST['email'];
	$result = execute_sql("SELECT vendeur,vendu FROM email_contact WHERE email='".addslashes($email)."'");
	if($result === FALSE)
		exit(mysqli_error());
	if(!list($vendeur, $vendu) = mysqli_fetch_row($result)) {
		$template = file_get_contents('templates/email_not_found.html');
		echo $template;
		exit();
	}
	// Get the full list of vendor usernames
	$result = execute_sql("SELECT pseudo FROM admin WHERE level<>'A' ORDER BY pseudo");
	if($result === FALSE)
		exit(mysqli_error());
	$vendors_list = '';
	while(list($username) = mysqli_fetch_row($result))
		if(strcasecmp($username, $vendeur) == 0)
			$vendors_list .= '<option selected>'.$username.'</option>';
		else
			$vendors_list .= '<option>'.$username.'</option>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Modificaci&oacute;n de la asociaci&oacute;n e mail - vendedor</title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<form method="post" action="modifier_contact.php" onSubmit="return validateForm(this)">
	<input type="hidden" name="email" value="<?=$email?>">
	<table width="600" border="0" cellspacing="0" cellpadding="6" class="login1" style="margin:auto">
		<tr>
			<td colspan="6" bgcolor="#006699"><div align="center" class="login">Associazione cliente-venditore</div></td>
		</tr>
		<tr>
			<td bgcolor="#B7DBFF">E mail :</td>
			<td bgcolor="#B7DBFF" align="center"><?=$email?></td>
			<td bgcolor="#B7DBFF">Vendedor :</td>
			<td bgcolor="#B7DBFF" align="center">
				<select name="vendeur">
					<option value="">(nessuno)</option>
					<?=$vendors_list?>
				</select>
			</td>
			<td bgcolor="#B7DBFF">Vendido :</td>
			<td bgcolor="#B7DBFF">
				<select name="vendu">
					<option<?php if($vendu == 'si') echo ' selected'?>>si</option>
					<option<?php if($vendu == 'no') echo ' selected'?>>no</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="6" align="center">
				<input type="submit" name="sauvegarder" value="Salva" onClick="this.form.action='modifier_contact.php'"/>
				<input type="submit" name="courriel" value="Salir" onClick="this.form.action='index.php'"/>
			</td>
		</tr>
	</table>
</form>
</body>
</html>
