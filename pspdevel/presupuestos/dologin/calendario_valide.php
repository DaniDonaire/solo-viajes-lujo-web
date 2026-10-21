<?php
	require 'include/verifLogin.php';
	require '../../include/sqlfunctions.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	/**
	 * Converts an italian/french date to a MySQL date
	 */
	function toMySQLDate($textDate) {
		if(!preg_match('!^(\d\d*)/(\d\d*)/(\d{4})( \d\d:\d\d:\d\d)?$!', $textDate, $matches))
			return '';
		if(empty($matches[4]))
			return $matches[3].'-'.$matches[2].'-'.$matches[1];
		return $matches[3].'-'.$matches[2].'-'.$matches[1].$matches[4];
	}
	$id_dossier = getParametre('id_dossier');
	if(!is_numeric($id_dossier))
		$id_dossier = 0;
	$apellido = getParametre('apellido');
	$nombre = getParametre('nombre');
	$phone = getParametre('phone');
	$email = getParametre('email');
	if(!$hora_recordatorio = getParametre('hora_recordatorio'))
		$hora_recordatorio = '00:00';
	$fecha_recordatorio = toMySQLDate(getParametre('fecha_recordatorio').' '.$hora_recordatorio.':00');
	$notas = getParametre('notas');
	$seguimiento = getParametre('seguimiento');
	$date_saisie = date('Y-m-d H:i:s');
	if(($id = getParametre('id')) && is_numeric($id))
		sqlUpdate('calendario', array(
				'fecha_recordatorio' => $fecha_recordatorio,
		 		'date_saisie' => $date_saisie,
				'notas' => $notas
			),
	  	'id='.$id
		);
	else
		sqlInsert('calendario', array(
			'apellido' => $apellido,
			'nombre' => $nombre,
			'email' => $email,
			'phone' => $phone,
			'fecha_recordatorio' => $fecha_recordatorio,
			'date_saisie' => $date_saisie,
			'notas' => $notas,
			'seguimiento' => $pseudo,
			'id_dossier' => $id_dossier
		));
	// Repost all form values
	$fields = '';
	foreach($_POST as $name => $value)
		if($name != 'x' && $name != 'y')
			$fields .= '  <input type="hidden" name="'.$name.'" value="'.$value."\">\r\n";
	if($backurl = getParametre('backurl')) {
		$onLoad = 'document.forms[0].submit()';
		$output = '<form action="'.$backurl.'" method="post">'.$fields.'</form>';
	}
	else {
		$onLoad = 'window.opener.location.reload();window.close()';
		$output = '';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Memorizarzione impegno nel calendario</title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css" />
</head>
<body onLoad="<?=$onLoad?>" style="margin: 0">

Acci&oacute;n memorizada en el calendario
<?=$output?>

</body>
</html>