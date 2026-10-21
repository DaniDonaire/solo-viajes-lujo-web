<?php
	require 'include/verifLogin.php';
	require '../../include/enviarMail.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];

	function createMessage($text, $html, $pseudo) {
		$top_image = file_get_contents('../images/top.jpg');
		$top_image = chunk_split(base64_encode($top_image));
		$left_image = file_get_contents('../images/left.png');
		$left_image = chunk_split(base64_encode($left_image));
		$right_image = file_get_contents('../images/right.png');
		$right_image = chunk_split(base64_encode($right_image));
		$bottom_image = file_get_contents('../images/bottom.png');
		$bottom_image = chunk_split(base64_encode($bottom_image));
		$filename = '../images/staff/'.$pseudo.'.jpg';
		if(!file_exists($filename))
			$filename = 'images/fake.gif';
		$staff_image = file_get_contents($filename);
		$staff_image = chunk_split(base64_encode($staff_image));
		return <<<TEXT

This is a multi-part message in MIME format.
------=_NextPart_000_002C_01CDACEF.4A8D9BB0
Content-Type: text/plain; charset="utf-8"

$text

------=_NextPart_000_002C_01CDACEF.4A8D9BB0
Content-Type: multipart/related; boundary="----=_NextPart_000_002C_01CDACEF.6C8E9BB0"


------=_NextPart_000_002C_01CDACEF.6C8E9BB0
Content-Type: text/html; charset="utf-8"
Content-Transfer-Encoding: 7bit

$html

------=_NextPart_000_002C_01CDACEF.6C8E9BB0
Content-Type: image/jpeg; name="top.jpg"
Content-Transfer-Encoding: base64
Content-Location: http://www.soloviajesdelujo.com/pspdevel/presupuestos/images/top.jpg

$top_image

------=_NextPart_000_002C_01CDACEF.6C8E9BB0
Content-Type: image/png; name="left.png"
Content-Transfer-Encoding: base64
Content-Location: http://www.soloviajesdelujo.com/pspdevel/presupuestos/images/left.png

$left_image

------=_NextPart_000_002C_01CDACEF.6C8E9BB0
Content-Type: image/png; name="right.png"
Content-Transfer-Encoding: base64
Content-Location: http://www.soloviajesdelujo.com/pspdevel/presupuestos/images/right.png

$right_image

------=_NextPart_000_002C_01CDACEF.6C8E9BB0
Content-Type: image/png; name="bottom.png"
Content-Transfer-Encoding: base64
Content-Location: http://www.soloviajesdelujo.com/pspdevel/presupuestos/images/bottom.png

$bottom_image

------=_NextPart_000_002C_01CDACEF.6C8E9BB0
Content-Type: image/jpeg; name="$pseudo.jpg"
Content-Transfer-Encoding: base64
Content-Location: http://www.soloviajesdelujo.com/pspdevel/presupuestos/images/staff/$pseudo.jpg

$staff_image

------=_NextPart_000_002C_01CDACEF.6C8E9BB0--

------=_NextPart_000_002C_01CDACEF.4A8D9BB0--

TEXT;
	}

	// Note: Fields written by the web form are only the following ones:
	// id_crucero, comenzando_fecha, tarifas_nombre, adulto, ninos, vuelo, ciudad, nombre, apellido_1, apellido_2, phone, email, hora_recordatorio, comentarios, newsletter, date_last_added, sitio, ip
	require '../../include/sqlfunctions.php';
	function getIdRand($id_presupuesto) {
		global presupuesto;
		// If there's no identifier associated with this item, generate a new one
		$result = execute_sql("SELECT id_rand FROM presupuesto WHERE id_presupuesto=$id_presupuesto AND id_rand<>''");
		if($result === FALSE)
			exit(mysqli_error());
		if($row = mysqli_fetch_row($result))
			return $row[0];
		$id1 = rand();
		$id2 = rand();
		return substr(md5($id1.$id_presupuesto.$id2), 0, 20);
	}
	function getAdminEmail($pseudo) {
		// Get the logged administrator email to use it as email sender
		$result = execute_sql("SELECT email_direct FROM admin WHERE pseudo='$pseudo'");
		if($result === FALSE)
			exit(mysqli_error());
		if($RS = @mysqli_fetch_row($result))
			return $RS[0];
		exit("ERRORE: Non &egrave; stato possibile leggere l'email del venditore");
	}
	function pujarArxiu2(){
	/*
		$SafeFile = $HTTP_POST_FILES['fitxer']['name'];
		$uploaddir = "fitxers/";
		$path = $uploaddir.$SafeFile;
		if($ufile != none){ //AS LONG AS A FILE WAS SELECTED...
			if (copy($HTTP_POST_FILES['fitxer']['tmp_name'], $path)){
				exit("OK");
			} else {
				exit("ERROR");
			}
		}*/

		$tmp_name = getParametre($_FILES["fitxer"]["tmp_name"]);	
        $name = getParametre(basename($_FILES["fitxer"]["name"]));
		$ruta = "fitxers/".$name;	
        if (move_uploaded_file($tmp_name, $name)){
			exit("OK");	
		//if (is_uploaded_file($tmp_name)){					
			// copiamos el archivo temporal, del directorio de temporales de nuestro servidor a la ruta que creamos			
			//copy($tmp_name, $name);			
		} else {
			//exit("ERROR");
			exit("CANNOT MOVE ".$error_types[$_FILES['fitxer']['error']]);
			
		}

	}
	function pujarArxiu($local,$remoto,$tama){
		// upload imatge
		$cid = ftp_connect((getenv('SVL_FTP_HOST') !== false ? getenv('SVL_FTP_HOST') : '127.0.0.1'));	
		$resultado = ftp_login($cid, (getenv('SVL_FTP_USER') !== false ? getenv('SVL_FTP_USER') : ''), (getenv('SVL_FTP_PASSWORD') !== false ? getenv('SVL_FTP_PASSWORD') : ''));	
		if ((!$cid) || (!$resultado)) {		
			//echo "Fallo en la conexión"; die;	
			exit("ERROR: Fallo en la conexión");		
		} 
		ftp_pasv ($cid, true) ;	
		//ftp_chdir($cid, "..\crucero\barcelona\imagen\imagen");	
		//$local = $_FILES["fitxer"]["name"];	
		//$remoto = $_FILES["fitxer"]["tmp_name"];	
		//$tama = $_FILES["fitxer"]["size"];	
		// Juntamos la ruta del servidor con el nombre real del archivo	
		$ruta = "fitxers/" . $local;	
		// Verificamos si ya se subio el archivo temporal		
		if (is_uploaded_file($remoto)){			
			// copiamos el archivo temporal, del directorio de temporales de nuestro servidor a la ruta que creamos			
			copy($remoto, $ruta);		
			//copy($remoto, $local);		
		}		
			// Sino se pudo subir el temporal		
		else {			
			exit("ERROR: no se pudo subir el archivo " . $remoto . "($local) a " .$ruta." ".$_FILES['fitxer']['error']);		
		}
		// fi upload imatge
	}
	$comenzando_fecha = getParametre('comenzando_fecha');
	$fecha_llegada = getParametre('fecha_llegada');
	//$puerto_salida = getParametre('puerto_salida');
	$apellido_1 = getParametre('apellido_1');
	$apellido_2 = getParametre('apellido_2');
	$apellido = trim($apellido_1.' '.$apellido_2);
	$nombre = getParametre('nombre');
	$email = getParametre('email');
	$adresse = getParametre('adresse');
	$phone = getParametre('phone');
	$fax = getParametre('fax');
	$pays = getParametre('pays');
	if(!$id_presupuesto = getParametre('id_presupuesto'))
		$id_presupuesto = getParametre('id');
	// This prevents errors with getIdRand when manually creating items
	if($id_presupuesto == '')
		$id_presupuesto = 0;
	$zip = getParametre('zip');
	$nombre_crucero = getParametre('nombre_crucero');
	//$id_crucero = getParametre('id_crucero');
	$destino = getParametre('destino');
	$compania = getParametre('compania');
	$ref_dossier = getParametre('ref_dossier');
	$buque = getParametre('buque');
	$tarifas_nombre = getParametre('tarifas_nombre');
	$itineraire = getParametre('itineraire');
	$fitxer = $_POST["adjunt"];
		$tmp_name = $_FILES["adjunt"]["tmp_name"];	
        $name = $_FILES["adjunt"]["name"];
		$ruta = "fitxers/".$name;	
        if (move_uploaded_file($tmp_name, $name)){
			exit("OK");	
		//if (is_uploaded_file($tmp_name)){					
			// copiamos el archivo temporal, del directorio de temporales de nuestro servidor a la ruta que creamos			
			//copy($tmp_name, $name);			
		} else {
			//exit("ERROR");
			exit("CANNOT MOVE ".$error_types[$_FILES['adjunt']['error']]);
		}
	$ciudad = getParametre('ciudad');
	$ciudad_arrivee = getParametre('ciudad_arrivee');
	$duracion_texto = getParametre('duracion_texto');
	$hora_recordatorio = getParametre('hora_recordatorio');
	$fecha_pago = getParametre('fecha_pago');
	$fecha_opcion = getParametre('fecha_opcion');
	$vuelo = getParametre('vuelo');
	$ciudad_vuelo = getParametre('ciudad_vuelo');
	$adulto = getParametre('adulto');
	$ninos = getParametre('ninos');
	//$formalites = getParametre('formalites');
	$sitio = getParametre('sitio');
	//$newsletter = getParametre('newsletter');
	$nom1 = getParametre('nom1');
	$nom2 = getParametre('nom2');
	$nom3 = getParametre('nom3');
	$nom4 = getParametre('nom4');
	$det_pass1 = getParametre('det_pass1');
	$det_pass2 = getParametre('det_pass2');
	$det_pass3 = getParametre('det_pass3');
	$det_pass4 = getParametre('det_pass4');
	$det_pass5 = getParametre('det_pass5');
	$prix1 = getParametre('prix1');
	$prix2 = getParametre('prix2');
	$prix3 = getParametre('prix3');
	$prix4 = getParametre('prix4');
	$prix5 = getParametre('prix5');
	$qte1 = getParametre('qte1');
	$qte2 = getParametre('qte2');
	$qte3 = getParametre('qte3');
	$qte4 = getParametre('qte4');
	$qte5 = getParametre('qte5');
	$remise_pourcentage = getParametre('remise_pourcentage');
	$remise_cache = getParametre('remise_cache');
	$text_seguro = getParametre('text_seguro');
	$qte_tax_portuaires = getParametre('qte_tax_portuaires');
	$tax_portuaires = getParametre('tax_portuaires');
	$qte_paq_areo_vac = getParametre('qte_paq_areo_vac');
	$paq_areo_vac = getParametre('paq_areo_vac');	
	//$qte_paq_areo_vac = 0;
	//$paq_areo_vac = 0;	
	$qte_seguro = getParametre('qte_seguro');
	$seguro = getParametre('seguro');
	$mode_pay = getParametre('mode_pay');
	$comentarios = getParametre('comentarios');
	$comentarios_agent = getParametre('comentarios_vendedor');
	//$comentarios_agent = htmlspecialchars(getParametre('comentarios_vendedor'));
	$notas = getParametre('notas');
	$num_cabine = getParametre('num_cabine');
	if(!is_numeric($num_cabine))
		$num_cabine = 0;
	$seguimiento = getParametre('seguimiento');
	$tot_pass = $adulto + $ninos;
	if($prix1 != '' && $qte1 != '')
		$total1 = $prix1 * $qte1;
	else {
		$total1 = 0;	
		$prix1 = 0;	
		$qte1 = 0;	
	}
	if($prix2 != '' && $qte2 != '')
		$total2 = $prix2 * $qte2;
	else {
		$total2 = 0;	
		$prix2 = 0;	
		$qte2 = 0;	
	}		
	if($prix3 != '' && $qte3 != '')
		$total3 = $prix3 * $qte3;
	else {
		$total3 = 0;
		$prix3 = 0;	
		$qte3 = 0;	
	}		
	if($prix4 != '' && $qte4 != '')
		$total4 = $prix4 * $qte4;
	else {
		$total4 = 0;
		$prix4 = 0;	
		$qte4 = 0;	
	}	
	if($prix5 != '' && $qte5 != '')
		$total5 = $prix5 * $qte5;
	else {
		$total5 = 0;	
		$prix5 = 0;	
		$qte5 = 0;	
	}
	$prix_broch = $total1 + $total2 + $total3 + $total4 + $total5;
	$remise = $prix_broch * $remise_pourcentage;
	$remise1 = $remise / 100;
	if($remise_pourcentage == '' && $remise_cache == '') {
		$remise_pourcentage = 0;	
		$remise_cache = 0;	
	}
	else {
		if($remise_pourcentage == '' && $remise_cache != '')
			$remise_pourcentage = 0;	
		else 
			$remise_cache = $remise1;
	}	
	// Note: These two totals are written to the database
	// to allow them being viewed through PHPMyAdmin
	$prix_ttc = $prix_broch - $remise_cache - $remise1 + ($qte_tax_portuaires * $tax_portuaires) + ($qte_paq_areo_vac * $paq_areo_vac);
	$prix_total = $prix_ttc + $qte_seguro * $seguro;
	$currentDate = date('Y-m-d H:i:s');
	$date_trait = $currentDate;
	// fitxer adjunt
	//$local = $_FILES["fitxer"]["name"];	
	//$remoto = $_FILES["fitxer"]["tmp_name"];	
	//$tama = $_FILES["fitxer"]["size"];	
	// ********************
	// Get all status names
	// ********************
	$result = execute_sql('SELECT id,statut FROM statut ORDER BY id');
	if($result === FALSE)
		exit('SQL ERREUR: '.mysqli_error());
	while(list($statut_id, $statut_nom) = mysqli_fetch_row($result))
		$statuts[$statut_id] = $statut_nom;
	$extraFields = array();
	if(isset($_POST['devis_sauvegarder']) || isset($_POST['contrat_sauvegarder'])) {
		if(isset($_POST['contrat_sauvegarder']))
			$statut = $statuts[5];
		else
			$statut = $statuts[2];
		$okResponse = 'presupuesto grabado';
		$saveData = TRUE;
		$sendEmail = FALSE;
	}
	elseif(isset($_POST['devis_envoye'])) {
		$statut = $statuts[3];
		$maild = getAdminEmail($pseudo);
		// Generate a new id rand or load previous one
		$id_rand = getIdRand($id_presupuesto);
		// Load the email templates and replace placeholder variables
		//$devis_text = file_get_contents('templates/email_presupuesto.txt');
		//$devis_html = file_get_contents('templates/email_presupuesto.html');
		if ($compania == 'SoloViajesdeLujo.com') {		
			$contrat_text = file_get_contents('templates/email_presupuesto_svl.txt');
			$contrat_html = file_get_contents('templates/email_presupuesto_svl.html');
			$maild = str_replace("entre3mundos","soloviajesdelujo",$maild);
		}
		else{
			$contrat_text = file_get_contents('templates/email_presupuesto.txt');
			$contrat_html = file_get_contents('templates/email_presupuesto.html');
		}
		$sujet = 'Presupuesto para '.$apellido.' '.$nombre;
		$sujet2 = 'Presupuesto de '.$apellido.' '.$nombre;
		/*
		$headers = <<<TEXT
From: entre3mundos <$maild>
Cc: info@entre3mundos.com
Bcc: pruebas@entre3mundos.com
Return-Path: <$maild>
MIME-Version: 1.0
Content-Type: multipart/alternative; boundary="----=_NextPart_000_002C_01CDACEF.4A8D9BB0"
TEXT;
		$message = createMessage($devis_text, $devis_html, $pseudo);
		*/
		$okResponse = 'presupuesto enviado';
		$extraFields['id_rand'] = $id_rand;
		$saveData = TRUE;
		$sendEmail = TRUE;
	}
	elseif(isset($_POST['devis_relance'])) {
		$response = 'presupuesto para reenviar';
		sqlUpdate(presupuesto, array('statut' => $statuts[4]), "id_presupuesto=$id_presupuesto");
		$saveData = FALSE;
		$sendEmail = FALSE;
	}
	elseif(isset($_POST['contrat_envoye'])) {
		$statut = $statuts[6];
		$maild = getAdminEmail($pseudo);
		// Generate a new id rand or load previous one
		$id_rand = getIdRand($id_presupuesto);
		// Load the email templates and replace placeholder variables
		if ($compania == 'SoloViajesdeLujo.com') {		
			$contrat_text = file_get_contents('templates/email_contrato_svl.txt');
			$contrat_html = file_get_contents('templates/email_contrato_svl.html');
			$maild = str_replace("entre3mundos","soloviajesdelujo",$maild);
		}
		else{
			$contrat_text = file_get_contents('templates/email_contrato.txt');
			$contrat_html = file_get_contents('templates/email_contrato.html');
		}
		$sujet = 'Contrato para '.$apellido.' '.$nombre;
		$sujet2 = 'Contrato de '.$apellido.' '.$nombre;
		/*
		$headers = <<<TEXT
From: entre3mundos <$maild>
Cc: info@entre3mundos.com
Bcc: pruebas@entre3mundos.com
Return-Path: <$maild>
MIME-Version: 1.0
Content-Type: multipart/alternative; boundary="----=_NextPart_000_002C_01CDACEF.4A8D9BB0"
TEXT;
		$message = createMessage($contrat_text, $contrat_html, $pseudo);
		*/
		$okResponse = 'contrato enviado';
		$extraFields['id_rand'] = $id_rand;
		$saveData = TRUE;
		$sendEmail = TRUE;
	}
	elseif(isset($_POST['contrat_relance'])) {
		$response = $statuts[7];
		sqlUpdate(presupuesto, array('statut' => $statuts[7]), 'id_presupuesto='.$id_presupuesto);
		$saveData = FALSE;
		$sendEmail = FALSE;
	}
	elseif(isset($_POST['contrat_vendu'])) {
		sqlUpdate(presupuesto, array(
	 		'statut' => $statuts[8]
			),
			'id_presupuesto='.$id_presupuesto
		);
		sqlUpdate('email_contact', array(
			'vendeur' => $seguimiento,
			'date' => $currentDate,
			'vendu' => 'si'
			),
			"email='".addslashes($email)."'"
		);
		$response = $statuts[8];
		$saveData = FALSE;
		$sendEmail = FALSE;
	}
	elseif(isset($_POST['envoyer_message'])) {
		// These two form fields are only available in the mail form
		$Objet = getParametre('Objet');
		$message = getParametre('message');
		// The email message (not the HTML) will be saved with all the other data
		$statut = $statuts[9];
		$extraFields['message'] = $message;
		$result = execute_sql("SELECT email_direct FROM admin WHERE pseudo='$pseudo' LIMIT 1");
		if($result === FALSE)
			exit(mysqli_error());
		if(!$row = mysqli_fetch_row($result))
			exit('ERROR: Non &egrave; stato possibile leggere l\'email del venditore');
		$maild = $row[0];
		// Load the email templates and replace placeholder variables
		$mail_text = file_get_contents('templates/email_message.txt');
		$mail_text = str_replace(
			array('$id_presupuesto', '$maild', '$pseudo', '$Objet', '$message'),
			array($id_presupuesto, $maild, $pseudo, $Objet, $message),
			$mail_text
		);
		$mail_text = <<<_TXT_

$mail_text

_TXT_;
		$mail_html = file_get_contents('templates/email_message.html');
		$mail_html = str_replace(
			array('$id_presupuesto', '$maild', '$Objet', '$message'),
			array($id_presupuesto, $maild, $Objet, $message),
			$mail_html
		);
$mail_html = <<<_HTML_

$mail_html

_HTML_;
		//$message = createMessage($mail_text, $mail_html, $pseudo);
		//mail ($email, $sujet, $message, $headers);
		//mail ($maild, $sujet1, $message, $headers);
		
		$subject = "Mensaje de entre3mundos";
		enviarMail3($email,$mail_html,$subject,$mail_text);
		$subject1 = "Mensaje enviado";
		enviarMail3($maild,$mail_html,$subject1,$mail_text);
		
		$okResponse = 'email enviado';
		$saveData = TRUE;
		// An email has just been sent, and we do not want to send the order email
		$sendEmail = FALSE;
	}
	elseif(isset($_POST['notas_sauvegarder'])) {
		// Note: This only saves the notas, with no other modification
		// Could be extended to allow editing any item properties
		sqlUpdate(presupuesto, array('notas' => $notas), "id_presupuesto=$id_presupuesto");
		$response = 'note salvate';
		$saveData = FALSE;
		$sendEmail = FALSE;
	}
	else
		exit('Nessun parametro specificato');
	if($saveData) {
		$values = array(
			'nombre' => $nombre,
			'apellido_1' => $apellido_1,
			'apellido_2' => $apellido_2,
			'email' => $email,
			'adresse' => $adresse,
			'phone' => $phone,
			'fax' => $fax,
			'pays' => $pays,
			'zip' => $zip,
			'statut' => $statut,
			'nom_croisiere' => $nombre_crucero,
			//'nombre_crucero' => $nombre_crucero,
			//'id_crucero' => $id_crucero,
			'destino' => $destino,
			'compania' => $compania,
			'buque' => $buque,
			'tarifas_nombre' => $tarifas_nombre,
			'num_cabine' => $num_cabine,
			'itineraire' => $itineraire,
			'fitxer' => $fitxer,
			'ciudad' => $ciudad,
			'ciudad_arrivee' => $ciudad_arrivee,
			//'puerto_salida' => $puerto_salida,
			'comenzando_fecha' => toMySQLDate($comenzando_fecha),
			'fecha_llegada' => toMySQLDate($fecha_llegada),
			'duracion_texto' => $duracion_texto,
			// heure_rappel en francais
			'hora_recordatorio' => $hora_recordatorio,
			'fecha_pago' => toMySQLDate($fecha_pago),
			'fecha_opcion' => toMySQLDate($fecha_opcion),
			'ref_dossier' => $ref_dossier,
			'vuelo' => $vuelo,
			//'ciudad_vuelo' => $ciudad_vuelo,
			'adulto' => $adulto,
			'ninos' => $ninos,
			//'formalidad' => $formalites,
			'sitio' => $sitio,
			'nom1' => $nom1,
			'nom2' => $nom2,
			'nom3' => $nom3,
			'nom4' => $nom4,
			'det_pass1' => $det_pass1,
			'det_pass2' => $det_pass2,
			'det_pass3' => $det_pass3,
			'det_pass4' => $det_pass4,
			'det_pass5' => $det_pass5,
			'prix1' => $prix1,
			'prix2' => $prix2,
			'prix3' => $prix3,
			'prix4' => $prix4,
			'prix5' => $prix5,
			'qte1' => $qte1,
			'qte2' => $qte2,
			'qte3' => $qte3,
			'qte4' => $qte4,
			'qte5' => $qte5,
			'prix_total' => $prix_total,
			'remise_cache' => $remise_cache,
			'remise_pourcentage' => $remise_pourcentage,
			'prix_ttc' => $prix_ttc,
			'qte_tax_portuaires' => $qte_tax_portuaires,
			'tax_portuaires' => $tax_portuaires,
			'qte_seguro' => $qte_seguro,
			'seguro' => $seguro,
			'text_seguro' => $text_seguro,
			'mode_pay' => $mode_pay,
			'comentarios' => $comentarios,
			'comentarios_vendedor' => $comentarios_agent,
			'notas' => $notas,
			'seguimiento' => $seguimiento,
			'qte_paq_areo_vac' => $qte_paq_areo_vac,
			'paq_areo_vac' => $paq_areo_vac
		);
		
		if(count($extraFields) > 0)
			$values = array_merge($values, $extraFields);
		$values['date_trait'] = $currentDate;
		// This allows creating (or copying) an item with a new identifier
		if(empty($id_presupuesto)) {
			// Note: date_last_added (which should be named fecha_presupuesto)
			// is only set when creating item for the first time
			// and is never modified afterwards anymore!
			$values['date_last_added'] = $currentDate;
			$id_presupuesto = sqlInsert(presupuesto, $values);
			//if(!empty($fitxer) && $fitxer != '' && $fitxer != null) {
				//pujarArxiu($local,$remoto,$tama);
				pujarArxiu2();
			//}
			//echo $id_presupuesto;
			$response = $okResponse;
			//$response = $id_presupuesto;
		}
		else {
			sqlUpdate(presupuesto, $values, 'id_presupuesto='.$id_presupuesto);
			$response = $okResponse;
		}
		// Marks this customer as followed by this vendor
		sqlUpdate('email_contact',
			array(
				'vendeur' => $seguimiento,
				'date' => $currentDate
			),
			"email='".addslashes($email)."'"
		);
		// This should only happen if email address was edited, because email_contact
		// is written when the item is opened (from devis en attente)
		if(mysqli_affected_rows() == 0)
			sqlInsert('email_contact', array(
				'email' => $email,
				'vendeur' => $seguimiento,
				'date' => $currentDate,
				'vendu' => 'no'
			));
	}
	if($sendEmail) {
		// Replace template variables in the message text
		$conditionsPage = str_replace(' ', '_', strtolower($compania));
		/*
		$message = str_replace(
			//array('$id_rand', '$id_presupuesto', '$maild', '$pseudo', '$nombre_crucero', '$buque', '$compania', '$comenzando_fecha', '$tarifas_nombre', '$tot_pass', '$apellido_1', '$apellido_2', '$apellido', '$nombre', '$email', '$phone', '$conditionsPage'),
			array('$id_rand', '$id_presupuesto', '$maild', '$pseudo', '$destino','$buque', '$compania', '$comenzando_fecha', '$tarifas_nombre', '$tot_pass', '$apellido_1', '$apellido_2', '$apellido', '$nombre', '$email', '$phone', '$conditionsPage'),
			//array($id_rand, $id_presupuesto, $maild, $pseudo, $nombre_crucero, $buque, $compania, $comenzando_fecha, $tarifas_nombre, $tot_pass, $apellido_1, $apellido_2, $apellido, $nombre, $email, $phone, $conditionsPage),
			array($id_rand, $id_presupuesto, $maild, $pseudo, $destino, $buque, $compania, $comenzando_fecha, $tarifas_nombre, $tot_pass, $apellido_1, $apellido_2, $apellido, $nombre, $email, $phone, $conditionsPage),
			$message
		); */
		$contrat_html = str_replace(
			array('$id_rand', '$id_presupuesto', '$maild', '$pseudo', '$destino','$buque', '$compania', '$comenzando_fecha', '$tarifas_nombre', '$tot_pass', '$apellido_1', '$apellido_2', '$apellido', '$nombre', '$email', '$phone', '$conditionsPage'),
			array($id_rand, $id_presupuesto, $maild, $pseudo, $destino, $buque, $compania, $comenzando_fecha, $tarifas_nombre, $tot_pass, $apellido_1, $apellido_2, $apellido, $nombre, $email, $phone, $conditionsPage),
			$contrat_html
		);
		//mail($email, $sujet, $message, $headers);
		//mail($maild, $sujet2, $message, $headers);
		//enviarMail($email,$message,$sujet);		
		enviarMail3($email,$contrat_html,$sujet,$contrat_text);
		//enviarMail($maild,$message,$sujet2);		
		enviarMail3($maild,$contrat_html,$sujet2,$contrat_text);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Invio dati</title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css"/>
</head>
<body onUnload="window.opener.location.reload()" style="margin: 0">

<?=$response?>
<script language="JavaScript" type="text/javascript">
<!--
	window.setTimeout('window.close()', 1000);
//-->
</script>
</body>
</html>