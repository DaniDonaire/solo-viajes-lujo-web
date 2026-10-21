<?php
	/**
	 * This function converts a MySQL date to an European formatted date
	 * and prevents 30/11/1999 from being displayed when date is empty.
	 * @author Massimiliano Alessandri
	 */
	function getEuropeanDate($mysqlDate) {
		if($mysqlDate == '' || strncmp($mysqlDate, '0000-00-00', 10) == 0)
			return '';
		return date('d/m/Y', strtotime($mysqlDate));
	}
	require '../include/sql.php';
	require 'get_logo.php';
	$id_rand = $_GET['id_rand'];
	if(empty($_GET['id_rand']))
		exit('Identificatore non specificato 8');
	$id_rand = $_GET['id_rand'];
	$sql = "SELECT * FROM presupuesto WHERE id_rand='".addslashes($id_rand)."'";
	$result = execute_sql($sql);
	if($result === FALSE)
		exit(mysqli_error());
	if(!$RS = @mysqli_fetch_array($result))
		exit('Presupuesto non trovato');
	$id_presupuesto = $RS['id_presupuesto'];
	$fecha_presupuesto = getEuropeanDate($RS['date_last_added']);
	$date_trait = getEuropeanDate($RS['date_trait']);
	$apellido_1 = $RS['apellido_1'];
	$apellido_2 = $RS['apellido_2'];
	$nombre = $RS['nombre'];
	$email = $RS['email'];
	$phone = $RS['phone'];
	$adresse = $RS['adresse'];
	$fax = $RS['fax'];
	$zip = $RS['zip'];
	$pays = $RS['pays'];
	$id_crucero = $RS['id_crucero'];
	$compania = $RS['compania'];
	$buque = $RS['buque'];
	$vuelo = $RS['vol'];
	$ciudad_vuelo = $RS['ciudad_vuelo'];
	$destino = $RS['destino'];
	$comenzando_fecha = getEuropeanDate($RS['comenzando_fecha']);
	$fecha_llegada = getEuropeanDate($RS['fecha_llegada']);
	$ciudad = $RS['ciudad'];
	$ciudad_arrivee = $RS['ciudad_arrivee'];
	$itineraire = $RS['itineraire'];
	$hora_recordatorio = $RS['hora_recordatorio'];
	$tarifas_nombre = $RS['tarifas_nombre'];
	$num_cabine = $RS['num_cabine'];
	$adulto = $RS['adulto'];
	$ninos = $RS['ninos'];
	$fecha_pago = getEuropeanDate($RS['fecha_pago']);
	$duracion_texto = $RS['duracion_texto'];
	$formalites = $RS['formalites'];
	if($formalites == '')
		$formalites = '-';
	$nom1 = $RS['nom1'];
	$nom2 = $RS['nom2'];
	$nom3 = $RS['nom3'];
	$nom4 = $RS['nom4'];
	$det_pass1 = $RS['det_pass1'];
	$det_pass2 = $RS['det_pass2'];
	$det_pass3 = $RS['det_pass3'];
	$det_pass4 = $RS['det_pass4'];
	$det_pass5 = $RS['det_pass5'];
	$prix1 = $RS['prix1'];
	$prix2 = $RS['prix2'];
	$prix3 = $RS['prix3'];
	$prix4 = $RS['prix4'];
	$prix5 = $RS['prix5'];
	$qte1 = $RS['qte1'];
	$qte2 = $RS['qte2'];
	$qte3 = $RS['qte3'];
	$qte4 = $RS['qte4'];
	$qte5 = $RS['qte5'];
	$sitio = $RS['sitio'];
	$prix_total = $RS['prix_total'];
	$remise_cache = $RS['remise_cache'];
	$remise_pourcentage = $RS['remise_pourcentage'];
	$prix_ttc = $RS['prix_ttc'];
	$qte_taxes_portuaires = $RS['qte_tax_portuaires'];
	$taxes_portuaires = $RS['tax_portuaires'];
	$qte_paq_areo_vac = $RS['qte_paq_areo_vac'];
	$paq_areo_vac = $RS['paq_areo_vac'];
	$qte_seguro = $RS['qte_seguro'];
	$seguro = $RS['seguro'];
	$text_seguro = $RS['text_seguro'];
	if($text_seguro != '')
		$text_seguro = ' ('.$text_seguro.')';
	$seguimiento = $RS['seguimiento'];
	$comentarios = $RS['comentarios'];
	$comentarios_vendedor = $RS['comentarios_vendedor'];
	$result = execute_sql("SELECT email_direct FROM admin WHERE pseudo='$seguimiento' LIMIT 1");
	if($result === FALSE)
		exit(mysqli_error());
	if(!$row = mysqli_fetch_row($result))
		exit("ERRORE: L'indirizzo email del venditore non &egrave; stato trovato");
	$maild = $row[0];
	$logo_compania = get_arm_logo($compania);
	$total1 = $prix1 * $qte1;
	$total2 = $prix2 * $qte2;
	$total3 = $prix3 * $qte3;
	$total4 = $prix4 * $qte4;
	$total5 = $prix5 * $qte5;
	$prix_broch = $total1 + $total2 + $total3 + $total4 + $total5;
	// Notas: $remise1 is the resulting additional percentage discount
	if($remise_pourcentage != 0)
		$remise1 = $prix_broch * $remise_pourcentage / 100;
	else
		$remise1 = 0;
	$remise = round($remise_cache + $remise1, 0);
	$prix_remise = $prix_broch - $remise;
	$total_taxes_portuaires = $qte_taxes_portuaires * $taxes_portuaires;
	$total_paq_areo_vac = $qte_paq_areo_vac * $paq_areo_vac;
	$prix_sa = $prix_remise + $total_taxes_portuaires + $total_paq_areo_vac;
	$total_seguro = $qte_seguro * $seguro;
	$prix_aa = $prix_sa + $total_seguro;
	$acuenta = round($prix_aa * 0.3, 0);
	$solde = $prix_aa - $acuenta;
	// Get nombre crucero
	$result = execute_sql('SELECT nombre_cruceros FROM ofertas_cruceros WHERE id_crucero='.$id_crucero);
	if($result === FALSE)
		exit(mysqli_error());
	if(!list($nombre_crucero) = mysqli_fetch_row($result))
		$nombre_crucero = $RS['nombre_crucero'];
	// Get compania URL
	$result = execute_sql("SELECT id_compania FROM compania WHERE nombre_compania='".$compania."'");
	if($result === FALSE)
		exit(mysqli_error());
	if(list($id_compania) = mysqli_fetch_row($result))
		$urlcompania = '../crucero/barcelona/compania/compania.php?compania_id='.$id_compania;
	else
		$urlcompania = '';
	// Get buque URL
	$result = execute_sql("SELECT id_buque FROM buque WHERE nombre_buque='".$buque."'");
	if($result === FALSE)
		exit(mysqli_error());
	if(list($id_buque) = mysqli_fetch_row($result))
		$urlbuque = '../crucero/barcelona/compania/buque.php?buque_id='.$id_buque;
	else
		$urlbuque = '';
	if($num_cabine > 0)
		$num_cabine = 'N&deg; <b>'.$num_cabine.'</b>';
	else
		$num_cabine = '';
	if(!file_exists('templates/presupuesto.html'))
		exit('ERRORE: Non &egrave; stato possibile visualizzare il presupuesto.');
	if ($compania == 'SoloViajesdeLujo.com') {
		$template = file_get_contents('templates/presupuesto_svl.html');
		$maild = str_replace("entre3mundos","soloviajesdelujo",$maild);
	}
	else		
		$template = file_get_contents('templates/presupuesto.html');
	// Hides from the template elements which are not needed (because variable is empty)
	if($comentarios_vendedor == '' && preg_match('!^(.+)<tr id="comentarios_vendedor">.+?</tr>(.+)$!is', $template, $matches))
		$template = $matches[1].$matches[2];
	if($remise == 0 && preg_match('!^(.+)<tr id="remise">.+?</tr>(.+)$!is', $template, $matches))
		$template = $matches[1].$matches[2];
	if($det_pass1 == '' && preg_match('!^(.+)<tr id="det1">.+?</tr>(.+)$!is', $template, $matches))
		$template = $matches[1].$matches[2];
	if($det_pass2 == '' && preg_match('!^(.+)<tr id="det2">.+?</tr>(.+)$!is', $template, $matches))
		$template = $matches[1].$matches[2];
	if($det_pass3 == '' && preg_match('!^(.+)<tr id="det3">.+?</tr>(.+)$!is', $template, $matches))
		$template = $matches[1].$matches[2];
	if($det_pass4 == '' && preg_match('!^(.+)<tr id="det4">.+?</tr>(.+)$!is', $template, $matches))
		$template = $matches[1].$matches[2];
	if($det_pass5 == '' && preg_match('!^(.+)<tr id="det5">.+?</tr>(.+)$!is', $template, $matches))
		$template = $matches[1].$matches[2];
	echo str_replace(
		array('$date_trait', '$logo_compania', '$seguimiento', '$maild', '$nombre_crucero', '$id_crucero', '$id_presupuesto', '$urlcompania', '$compania', '$urlbuque', '$buque', '$adulto', '$ninos', '$fecha_pago', '$tarifas_nombre', '$num_cabine', '$ciudad_arrivee', '$comenzando_fecha', '$ciudad', '$fecha_llegada', '$destino', '$duracion_texto', '$itineraire', '$formalites', '$fecha_presupuesto', '$apellido_1', '$apellido_2', '$nombre', '$phone', '$email', '$det_pass1', '$total1', '$qte1', '$prix1', '$det_pass2', '$total2', '$qte2', '$prix2', '$det_pass3', '$total3', '$qte3', '$prix3', '$det_pass4', '$total4', '$qte4', '$prix4', '$det_pass5', '$total5', '$qte5', '$prix5', '$prix_broch', '$remise', '$prix_remise', '$qte_taxes_portuaires', '$taxes_portuaires', '$total_taxes_portuaires', '$qte_seguro', '$seguro', '$text_seguro', '$total_seguro', '$prix_sa', '$prix_aa', '$acuenta', '$solde', '$comentarios_vendedor', '$qte_paq_areo_vac', '$paq_areo_vac', '$total_paq_areo_vac'),
		array($date_trait, $logo_compania, $seguimiento, $maild, $nombre_crucero, $id_crucero, $id_presupuesto, $urlcompania, $compania, $urlbuque, $buque, $adulto, $ninos, $fecha_pago, $tarifas_nombre, $num_cabine, $ciudad_arrivee, $comenzando_fecha, $ciudad, $fecha_llegada, $destino, $duracion_texto, $itineraire, $formalites, $fecha_presupuesto, $apellido_1, $apellido_2, $nombre, $phone, $email, $det_pass1, $total1, $qte1, $prix1, $det_pass2, $total2, $qte2, $prix2, $det_pass3, $total3, $qte3, $prix3, $det_pass4, $total4, $qte4, $prix4, $det_pass5, $total5, $qte5, $prix5, $prix_broch, $remise, $prix_remise, $qte_taxes_portuaires, $taxes_portuaires, $total_taxes_portuaires, $qte_seguro, $seguro, $text_seguro, $total_seguro, $prix_sa, $prix_aa, $acuenta, $solde, $comentarios_vendedor,$qte_paq_areo_vac, $paq_areo_vac, $total_paq_areo_vac),
		$template
	);
?>