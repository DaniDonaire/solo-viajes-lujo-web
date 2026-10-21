<?php
	require '../include/verifLogin.php';
	$user = $_SESSION['user'];
	$level = $user['level'];
	if($level != 'A')
		exit('UNAUTHORIZED');
	require '../../../include/sqlfunctions.php';
	// ********************
	// Saves all agent data
	// ********************
	$id = getParametre('id');
	$data = array(
		'nombre' => getParametre('nombre'),
		'email_direct' => getParametre('email'),
		'tel_direct' => getParametre('telephone'),
		'pseudo' => getParametre('pseudo'),
		'level' => getParametre('level')
	);
	if($passe = getParametre('passe'))
		$data['passe'] = md5($passe);
	if($id === FALSE)
		sqlInsert('admin', $data);
	else {
		if(!is_numeric($id))
			exit('ERROR: Identificatore non numerico');
		sqlUpdate('admin', $data, 'id_membre='.$id);
	}
?>
<html>
<body onload="window.opener.location.reload();window.close()">
</body>
</html>