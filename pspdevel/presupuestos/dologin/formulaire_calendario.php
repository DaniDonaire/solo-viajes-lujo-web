<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	// Notas: This field is only set when adding a calendar item from a dossier
	if(isset($_POST['calendario_dossier']) || isset($_POST['calendario_dossier_x'])) {
		//require 'get_contrato.php';
		$id_dossier = getParametre('id');
		if(!is_numeric($id_dossier))
			$id_dossier = 0;
		$backurl = $_SERVER['HTTP_REFERER'];
	}
	else {
		$id_dossier = 0;
		// This will set up the Save button to close window
		$backurl = '';
	}
	$fecha_recordatorio = date('d/m/Y');
	// ****************************
	// Generate the vendors listing
	// ****************************
	$result = execute_sql("SELECT pseudo FROM admin WHERE level<>'A' ORDER BY pseudo");
	if($result === FALSE)
		exit(mysqli_error());
	$vendors = '';
	while(list($login) = mysqli_fetch_row($result))
		if(strcasecmp($login, $pseudo) == 0)
			$vendors .= '<option selected>'.$login.'</option>';
		else
			$vendors .= '<option>'.$login.'</option>';
	// Repost all form values
	$fields = '';
	foreach($_POST as $name => $value) {
		if($name == 'id')
			$name = 'id_dossier';
		if($name != 'x' && $name != 'y')
			$fields .= '  <input type="hidden" name="'.$name.'" value="'.$value."\">\r\n";
	}
	if($id_dossier != 0)
		$devisnum = ' (pratica N&deg; <span class="error">'.$id_dossier.'</span>)';
	else
		$devisnum = '';
	// **************************************************
	// Loads template, fixes links and replaces variables
	// **************************************************
	$template = file_get_contents('templates/formulaire_calendario.html');
	$template = str_replace(
		array('$id_dossier', '$apellido', '$nombre', '$phone', '$email', '$fecha_recordatorio', '$pseudo', '$notas', '$backurl', '$pseudo', '$fields', '$devisnum', '$vendors'),
		array($id_dossier, $apellido, $nombre, $phone, $email, $fecha_recordatorio, $pseudo, $notas, $backurl, $pseudo, $fields, $devisnum, $vendors),
		$template
	);
	echo $template;
?>