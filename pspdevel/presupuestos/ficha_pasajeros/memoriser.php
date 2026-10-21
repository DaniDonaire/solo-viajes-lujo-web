<?php
	/**
	 * Converts an italian/french date to a MySQL date
	 */
	function toMySQLDate($textDate) {
		if(!preg_match('!^(\d\d*)[/.-](\d\d*)[/.-](\d{2,4})$!', $textDate, $matches))
			return '';
		return $matches[3].'-'.$matches[2].'-'.$matches[1];
	}
	/**
	 * Inserts a new database row into the database.
	 * @return integer the created row identifier
	 * @author Massimiliano Alessandri
	 */
	function sqlInsert($tableau,$champs){
		$nombres=implode(',',array_keys($champs));
		foreach($champs as $nombre=>$valeur)
			if(is_null($valeur)) $champs[$nombre]='NULL';
			else $champs[$nombre]="'".addslashes($valeur)."'";
		//sqlQuery("INSERT INTO $tableau($nombres) VALUES(".implode(',',$champs).')');
		execute_sql("INSERT INTO $tableau($nombres) VALUES(".implode(',',$champs).')');
		return mysqli_insert_id();
	}
	/**
	 * Updates a row in the database.
	 * @author Massimiliano Alessandri
	 */
	function sqlUpdate($tableau,$champs,$condition = ''){
		$q=array();
		foreach($champs as $nombre=>$valeur){
			if(is_null($valeur))$q[]=$nombre.'=NULL';
			else $q[]=$nombre."='".addslashes($valeur)."'";
		}
		$q=implode(',',$q);
		if($condition != '')
			$q .= ' WHERE '.$condition;
		//return sqlQuery("UPDATE $tableau SET $q");
		return execute_sql("UPDATE $tableau SET $q");
		
	}
	require '../../include/sql.php';
	$id_rand = getParametre('id_rand');
	// Derive identifier of "presupuesto" from id_rand
	// (it cannot be posted by the previous form, because it would be unsafe!)
	//$result = sqlQuery("SELECT id_presupuesto,compania,buque,comenzando_fecha,tarifas_nombre,ref_dossier,adulto,ninos FROM presupuesto WHERE id_rand='".addslashes($id_rand)."'");
	$result = execute_sql("SELECT id_presupuesto,compania,buque,comenzando_fecha,tarifas_nombre,ref_dossier,adulto,ninos FROM presupuesto WHERE id_rand='".addslashes($id_rand)."'");
	if(!$croisiere = mysqli_fetch_assoc($result))
		exit('ERREUR: Presupuesto non trovato');
	$id_presupuesto = $croisiere['id_presupuesto'];
	mysqli_free_result($result);
	$envoi_nombre = getParametre('envoi_nombre');
	$envoi_direccion = getParametre('envoi_direccion');
	$envoi_zip = getParametre('envoi_zip');
	$envoi_ciudad = getParametre('envoi_ciudad');
	sqlQuery('BEGIN');
	// Get rid of any previous stored data (to allow user modifying his data)
	sqlQuery('DELETE FROM boletos_direccion WHERE id_presupuesto='.$id_presupuesto);
	sqlQuery('DELETE FROM ficha_pasajeros WHERE id_presupuesto='.$id_presupuesto);
	sqlInsert('boletos_direccion', array(
 		'id_presupuesto' => $id_presupuesto,
		'nombre' => $envoi_nombre,
		'direccion' => $envoi_direccion,
		'codigo_postal' => $envoi_zip,
		'ciudad' => $envoi_ciudad
	));
	$n = 1;
	$prefix = 'pasajero'.$n.'_';
	$ficha_pasajeros = array();
	while(!empty($_POST[$prefix.'nombre'])) {
		$nombre = getParametre($prefix.'nombre');
		$apellido = getParametre($prefix.'apellido');
		$nacionalidad = getParametre($prefix.'nacionalidad');
		$lugar_nacimiento = getParametre($prefix.'lugar_nacimiento');
		$fecha_nacimiento = getParametre($prefix.'fecha_nacimiento');
		$typo_doc = getParametre($prefix.'typo_doc');
		$numero_doc = getParametre($prefix.'numero_doc');
		$fecha_emission_doc = getParametre($prefix.'fecha_emission_doc');
		$lugar_emission_doc = getParametre($prefix.'lugar_emission_doc');
		$fecha_expiration_doc = getParametre($prefix.'fecha_expiration_doc');
		$telefono = getParametre($prefix.'telefono');
		$mobile = getParametre($prefix.'mobile');
		$fax = getParametre($prefix.'fax');
		$email = getParametre($prefix.'email');
		$ficha_pasajeros[$n] = array(
			'id_presupuesto' => $id_presupuesto,
			'num_pass' => $n,
			'nombre' => $nombre,
			'apellido' => $apellido,
			'nacionalidad' => $nacionalidad,
			'lugar_nacimiento' => $lugar_nacimiento,
			'fecha_nacimiento' => $fecha_nacimiento,
			'typo_doc' => $typo_doc,
			'numero_doc' => $numero_doc,
			'fecha_emission_doc' => $fecha_emission_doc,
			'lugar_emission_doc' => $lugar_emission_doc,
			'fecha_expiration_doc' => $fecha_expiration_doc,
			'telefono' => $telefono,
			'mobile' => $mobile,
			'fax' => $fax,
			'email' => $email
		);
		sqlInsert('ficha_pasajeros', array(
			'id_presupuesto' => $id_presupuesto,
			'num_pass' => $n,
			'nombre' => $nombre,
			'apellido' => $apellido,
			'nacionalidad' => $nacionalidad,
			'lugar_nacimiento' => $lugar_nacimiento,
			'fecha_nacimiento' => toMySQLDate($fecha_nacimiento),
			'typo_doc' => $typo_doc,
			'numero_doc' => $numero_doc,
			'fecha_emission_doc' => toMySQLDate($fecha_emission_doc),
			'lugar_emission_doc' => $lugar_emission_doc,
			'fecha_expiration_doc' => toMySQLDate($fecha_expiration_doc),
			'telefono' => $telefono,
			'mobile' => $mobile,
			'fax' => $fax,
			'email' => $email
		));
		$n++;
		$prefix = 'pasajero'.$n.'_';
	}
	sqlQuery('COMMIT');
	$template = file_get_contents('ficha2.html');
	if(preg_match('!^(.+)<div id="pasajero">(.+)</div>(.+)$!isU', $template, $matches)) {
		$template = str_replace(
			array('$compania', '$buque', '$comenzando_fecha', '$tarifas_nombre', '$ref_dossier', '$envoi_nombre', '$envoi_direccion', '$envoi_zip', '$envoi_ciudad'),
			array($croisiere['compania'], $croisiere['buque'], date('d/m/Y', strtotime($croisiere['comenzando_fecha'])), !empty($croisiere['tarifas_nombre']) ? $croisiere['tarifas_nombre'] : '&nbsp;', !empty($croisiere['ref_dossier']) ? $croisiere['ref_dossier'] : '&nbsp;', $envoi_nombre, $envoi_direccion, $envoi_zip, $envoi_ciudad),
			$matches[1]
		);
		foreach($ficha_pasajeros as $n => $ficha_pasajero) {
			$template .= str_replace(
				array('$n', '$pasajero_nombre', '$pasajero_apellido', '$pasajero_nacionalidad', '$pasajero_lugar_nacimiento', '$pasajero_fecha_nacimiento', '$pasajero_typo_doc', '$pasajero_numero_doc', '$pasajero_fecha_emission_doc', '$pasajero_lugar_emission_doc', '$pasajero_fecha_expiration_doc', '$pasajero_telefono', '$pasajero_mobile', '$pasajero_fax', '$pasajero_email'),
				array($n, $ficha_pasajero['nombre'], $ficha_pasajero['apellido'], $ficha_pasajero['nacionalidad'], $ficha_pasajero['lugar_nacimiento'], $ficha_pasajero['fecha_nacimiento'], $ficha_pasajero['typo_doc'], $ficha_pasajero['numero_doc'], $ficha_pasajero['fecha_emission_doc'], $ficha_pasajero['lugar_emission_doc'], $ficha_pasajero['fecha_expiration_doc'], $ficha_pasajero['telefono'], $ficha_pasajero['mobile'], $ficha_pasajero['fax'], $ficha_pasajero['email']),
				$matches[2]
			);
		}
		$template .= $matches[3];
		$headers = <<<TEXT
From: entre3mundos <info@entre3mundos.com>
Return-Path: <info@entre3mundos.com>
MIME-Version: 1.0
Content-Type: multipart/alternative;
 boundary="----=_NextPart_000_002C_01CDACEF.4A8D9BB0"
TEXT;
		$message = <<<TEXT
This is a multi-part message in MIME format.
------=_NextPart_000_002C_01CDACEF.4A8D9BB0
Content-Type: text/plain; charset=ISO-8859-1; format=flowed
Content-Transfer-Encoding: 7bit

Please set your email client to display the HTML version of the message.
------=_NextPart_000_002C_01CDACEF.4A8D9BB0
Content-Type: text/html; charset=utf-8

$template
TEXT;
		$apellido = $ficha_pasajeros[1]['apellido'];
		$nombre = $ficha_pasajeros[1]['nombre'];
		//mail('m.alessandri@volaincrociera.com', "Ficha Pasajeros $nombre $apellido", $message, $headers);
		mail('psardi@entre3mundos.com', "Ficha Pasajeros $nombre $apellido", $message, $headers);
		mail('info@entre3mundos.com', "Ficha Pasajeros $nombre $apellido", $message, $headers);
		mail('pruebas@entre3mundos.com', "Ficha Pasajeros $nombre $apellido", $message, $headers);
		//mail('maurizio@webcroisieres.com', "Ficha Pasajeros $nombre $apellido", $message, $headers);
	}
	$template = file_get_contents('memoriser.html');
	echo $template;
?>