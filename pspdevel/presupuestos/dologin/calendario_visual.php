<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	if(!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id']))
		exit('ERRORE: Identificatore non specificato 3');
	$id = $_REQUEST['id'];
	$result = execute_sql("SELECT id_dossier,c.nom,c.nombre,c.phone,c.email,fecha_recordatorio,c.seguimiento,c.notas,s.id FROM calendario c LEFT JOIN $tablename d ON c.id_dossier=d.id_presupuesto LEFT JOIN statut s ON d.statut=s.statut WHERE c.id=$id");
	if($result === FALSE)
		exit(mysqli_error());
	if(!list($id_dossier, $nom, $nombre, $phone, $email, $fecha_recordatorio, $seguimiento, $notas, $statut_id) = mysqli_fetch_row($result))
		exit('ERRORE: Impegno non trovato nel calendario');
	if($fecha_recordatorio != '0000-00-00') {
		$hora_recordatorio = date('H:i', strtotime($fecha_recordatorio));
		if($hora_recordatorio == '00:00')
			$hora_recordatorio = '';
		$fecha_recordatorio = date('d/m/Y', strtotime($fecha_recordatorio));
	}
	else {
		$fecha_recordatorio = '';
		$hora_recordatorio = '';
	}
	// **************************************************
	// Loads template, fixes links and replaces variables
	// **************************************************
	$template = file_get_contents('templates/calendario_visual.html');
	if($id_dossier != 0) {
		$devisnum = ' (presupuesto N&deg; <span class="error">'.$id_dossier.'</span>)';
		switch($statut_id) {
			case 1: case 2:
				$url = 'formulaire_presupuesto.php';
				break;
			case 3: case 4:
				$url = 'presupuesto_visual.php';
				break;
			case 5:
				$url = 'formulaire_contrato.php';
				break;
			case 6: case 7: case 8:
				$url = 'contrato_visual.php';
				break;
			case 9:
				$url = 'email_visual.php';
		}
		$dossierbutton = '<input type="hidden" name="id_dossier" value="'.$id_dossier.'"/><input type="button" value="Visualiza pratica" onClick="location.href=\''.$url.'\?id='.$id_dossier.'\'"/>';
	}
	else {
		$devisnum = '';
		$dossierbutton = '';
	}
	$template = str_replace(
		array('../', '$id', '$id_dossier', '$nom', '$nombre', '$phone', '$email', '$fecha_recordatorio', '$hora_recordatorio', '$seguimiento', '$notas', '$devisnum', '$dossierbutton'),
		array('', $id, $id_dossier, $nom, $nombre, $phone, $email, $fecha_recordatorio, $hora_recordatorio, $pseudo, $notas, $devisnum, $dossierbutton),
		$template
	);
	echo $template;
?>