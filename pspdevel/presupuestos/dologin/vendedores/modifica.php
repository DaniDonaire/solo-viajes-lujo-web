<?php
	function htmlSelected($data, $value) {
		if($data == $value)
			return ' selected';
		return '';
	}
	require '../include/verifLogin.php';
	$user = $_SESSION['user'];
	$level = $user['level'];
	if($level != 'A')
		exit('UNAUTHORIZED');
	$id = getParametre('id');
	if(!is_numeric($id))
		exit('ERREUR: Identificatore non numerico');
	$result = execute_sql('SELECT * FROM admin WHERE id_membre='.$id);
	if(!$data = mysqli_fetch_assoc($result))
		exit('ERREUR: Agent pas trouv&eacute;');
	$template = file_get_contents('../templates/modifica_venditore.html');
	$template = str_replace(
		array('$id', '$nombre', '$email', '$telephone', '$pseudo', '$selectedA', '$selectedB', '$selectedC', '$selectedD'),
		array($data['id_membre'], $data['nombre'], $data['email_direct'], $data['tel_direct'], $data['pseudo'], htmlSelected($data['level'], 'A'), htmlSelected($data['level'], 'B'), htmlSelected($data['level'], 'C'), htmlSelected($data['level'], 'D')),
		$template
	);
	echo $template;
?>