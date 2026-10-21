<?php	
include ("include/sql.php");
include ("include/execute_sql.php");
	
error_reporting(E_ALL);
ini_set('display_errors', '1');

  $jsondata = array();
  $jsondata["success"] = true;
  
  $id = "";
$nombre = "";
$email = "";
$destino = "";
$fecha = "";
$ciudad_inicial = "";
$lastname_contact = "";
$lastname_contact2 = "";
$phone_contact = "";
$message_contact = "";
$adultos = "";
$ninos = "";
$hora_recordatorio = "";
$vuelo = "";
$vuelo = "";

  try {

  	if ($_POST["id"] != ""){
		$id = $_POST["id"];
	}
	if ($_POST["nombre"] != ""){
		$nombre = $_POST["nombre"];
	}
	if ($_POST["email"] != ""){
		$email = $_POST["email"];
	}
	if ($_POST["destino"] != ""){
		$destino = $_POST["destino"];
	}
	if ($_POST["fecha"] != ""){
		$fecha = $_POST["fecha"];
	}
	if ($_POST["ciudad_inicial"] != ""){
		$ciudad_inicial = $_POST["ciudad_inicial"];
	}
	if ($_POST["lastname_contact"] != ""){
		$lastname_contact = $_POST["lastname_contact"];
	}
	if ($_POST["lastname_contact2"] != ""){
		$lastname_contact2 = $_POST["lastname_contact2"];
	}
	if ($_POST["phone_contact"] != ""){
		$phone_contact = $_POST["phone_contact"];
	}
	if ($_POST["message_contact"] != ""){
		$message_contact = $_POST["message_contact"];
	}
	if ($_POST["exampleSelect1"] != ""){
		$adultos = $_POST["exampleSelect1"];
	}
	if ($_POST["exampleSelect2"] != ""){
		$ninos = $_POST["exampleSelect2"];
	}
	if ($_POST["exampleSelect3"] != ""){
		$hora_recordatorio = $_POST["exampleSelect3"];
	}
	if ($_POST["inlineRadio1"] != ""){
		$vuelo = $_POST["inlineRadio1"];
	}
	else if ($_POST["inlineRadio2"] != ""){
		$vuelo = $_POST["inlineRadio2"];
	}

	function get_ip() {
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif(isset($_SERVER['HTTP_CLIENT_IP']))
			$ip  = $_SERVER['HTTP_CLIENT_IP'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;
	}

	
	$fecha = date('Y-m-d H:i:s');
/*
	sqlInsert('presupuesto', array(
		'id_crucero' => $id,
		'destino' => $destino,
		'comenzando_fecha' => toMySQLDate($fecha),
		'adulto' => $adultos,
		'ninos' => $ninos,
		'vuelo' => $vuelo,
		'ciudad' => $ciudad_inicial,
		'nombre' => $nombre,
		'apellido_1' => $lastname_contact,
		'apellido_2' => $lastname_contact2,
		'phone' => $phone_contact,
		'email' => $email,
		'hora_recordatorio' => $hora_recordatorio,
		'comentarios' => $message_contact,
		'sitio' => 'SoloViajesDeLujo',
		'date_last_added' => $fecha,
		'ip' => $ip_address,
		'itineraire' => '',
		'comentarios_vendedor' => '',
		'ciudad_vuelo' => 'bcn',
		'puerto_salida' => '',
		'seguimiento' => ''
	));*/
	
	$sql_insert_presupuesto = sql_insert_presupuesto($id,$destino,toMySQLDate($fecha),$adultos,$ninos,$vuelo,$ciudad_inicial,$nombre,$lastname_contact,$lastname_contact2,$phone_contact,$email,$hora_recordatorio,$message_contact,$fecha,$ip_address);
	$idPrep= execute_insert_sql($sql_insert_presupuesto);

			/*
	sqlInsert('peticiones', array(
		'id' => mysql_insert_id(),
		'fecha' => $fecha,
		'emailhash' => md5($email),
		'sitio' => 'SoloViajesDeLujo',
		'ip_address' => $ip_address
	));
	*/
	
	$sql_insert_peticion = sql_insert_peticion($idPrep ,$fecha ,md5($email) ,$ip_address);
	execute_sql($sql_insert_peticion);
	
	// Traitement de la date
	setlocale(LC_TIME, 'es_ES');
	$form_vuelo = '';
	if ($vuelo == '1')
		$form_vuelo = 'si';
	else
		$form_vuelo = 'no';

	$search = array('$nombre', '$email', '$destino','$comenzando_fecha', '$ciudad', '$apellido_1','$apellido_2', '$phone', '$message_contact','$hora_recordatorio','$adulto','$ninos','$tarifas_nombre','$vuelo','$compania','$buque');
	$replace = array( $nombre, $email, $destino, $fecha, $ciudad_inicial, $idPrep, $lastname_contact2, $phone_contact, $message_contact, $hora_recordatorio, $adultos, $ninos, ' ', $form_vuelo, ' ', ' ');
	//$replace = array( $nombre, $email, $destino, toMySQLDate($fecha), $ciudad_inicial, $lastname_contact, $lastname_contact2, $phone_contact, //$message_contact, $hora_recordatorio, $adultos, $ninos, ' ', $form_vuelo, ' ', ' ');
		
		// *****************************
	// Envoye du mail pour le client
	// *****************************

	$html = file_get_contents('templates/email_presupuesto_client.html');
	$html = str_replace($search, $replace, $html);
	
	$sujet_client = 'Demanda de presupuesto personalizado';

	$message = $message_client_html;
	$titulo = "Demanda de presupuesto personalizado";
	
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Cabeceras adicionales
	$cabeceras .= 'To: <$email>' . "\r\n";
	$cabeceras .= 'From: Soloviajesdelujo.com <info@soloviajesdelujo.com>' . "\r\n";
	//$cabeceras .= 'Cc:  Soloviajesdelujo <info@soloviajesdelujo.com>' . "\r\n";
	
	mail($email, $titulo, $html, $cabeceras);
	
	} catch (Exception $e) {
		echo $e->getMessage();
		$jsondata["success"] = false;
		$jsondata["data"]["message"] = $e->getMessage();
		 
	}

	header('Content-type: application/json; charset=utf-8');

	echo json_encode($jsondata);
	exit();
	

?>