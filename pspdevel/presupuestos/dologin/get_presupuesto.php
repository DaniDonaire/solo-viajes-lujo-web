<?php
	if(!isset($_SESSION))
		exit();
	// ********************
	// Get all status names
	// ********************
	$result = execute_sql('SELECT id,statut FROM statut ORDER BY id');
	if($result === FALSE)
		exit('ERRORE SQL: '.mysqli_error());
	while(list($s_id, $s_nom) = mysqli_fetch_row($result))
		$statuts[$s_id] = $s_nom;
	// If "visualizer" or "retour" buttons have been pressed, we should get form values
	// instead of reading existing item from database
	if(isset($_POST['visualiser']) || isset($_POST['retour']) || isset($_POST['devis_copier']) || isset($_POST['contrat_copier']) || isset($_REQUEST['devis_creer'])) {
		if(isset($_POST['devis_copier']) || isset($_REQUEST['devis_creer'])) {
			// Notas: When copying or creating, identifier will be 0, which will be interpreted
			// as a special value which means a new item has to be created
			$id_presupuesto = 0;
			$statut = $statuts[2];
			$statut_id = 1;
		}
		elseif(isset($_POST['contrat_copier'])) {
			// Notas: When copying, identifier will be 0, which will be interpreted
			// as a special value which means a new item has to be created
			$id_presupuesto = 0;
			$statut = $statuts[5];
			$statut_id = 5;
		}
		else {
			$id_presupuesto = getParametre('id_presupuesto');
			$statut = getParametre('statut');
			$statut_id = array_search($statut, $statuts);
		}
		$comenzando_fecha = getParametre('comenzando_fecha');
		$fecha_llegada = getParametre('fecha_llegada');
		$apellido_1 = getParametre('apellido_1');
		$apellido_2 = getParametre('apellido_2');
		$nombre = getParametre('nombre');
		$email = getParametre('email');
		$adresse = getParametre('adresse');
		$phone = getParametre('phone');
		$fax = getParametre('fax');
		$pays = getParametre('pays');
		$zip = getParametre('zip');
		$nombre_crucero = getParametre('nombre_crucero');
		$id_crucero = getParametre('id_crucero');
		$destino = getParametre('destino');
		$compania = getParametre('compania');
		$buque = getParametre('buque');
		$tarifas_nombre = getParametre('tarifas_nombre');
		$num_cabine = getParametre('num_cabine');
		$itineraire = getParametre('itineraire');
		$puerto_salida = getParametre('puerto_salida');
		$ciudad = getParametre('ciudad');
		$ciudad_arrivee = getParametre('ciudad_arrivee');
		$duracion_texto = getParametre('duracion_texto');
		$hora_recordatorio = getParametre('hora_recordatorio');
		$fecha_pago = getParametre('fecha_pago');
		$fecha_opcion = getParametre('fecha_opcion');
		//$budget = getParametre('budget');
		$vuelo = getParametre('vuelo');
		$ciudad_vuelo = getParametre('ciudad_vuelo');
		$adulto = getParametre('adulto');
		$ninos = getParametre('ninos');
		$formalites = getParametre('formalites');
		if(!$sitio = getParametre('sitio'))
			$sitio = 'manual';
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
		$seguimiento = getParametre('seguimiento');
		$remise_cache = getParametre('remise_cache');
		$remise_pourcentage = getParametre('remise_pourcentage');
		$qte_tax_portuaires = getParametre('qte_tax_portuaires');
		$tax_portuaires = getParametre('tax_portuaires');
		$qte_paq_areo_vac = getParametre('qte_paq_areo_vac');		
		$paq_areo_vac = getParametre('paq_areo_vac');
		$qte_seguro =  getParametre('qte_seguro');
		$seguro = getParametre('seguro');
		$text_seguro = getParametre('text_seguro');
		$comentarios = getParametre('comentarios');
		$comentarios_vendedor = getParametre('comentarios_vendedor');
		$notas = getParametre('notas');
		$villes = getParametre('itineraire');
		$fitxer = getParametre('fitxer');
	}
	else {
		if(!$id_presupuesto = getParametre('id_presupuesto'))
			exit('ERROR: Identificatore non specificato! 6');
		if(!is_numeric($id_presupuesto))
			exit('ERROR: Identificatore non numerico!');
		$sql = "SELECT * FROM $tablename WHERE id_presupuesto=$id_presupuesto";
		$result = execute_sql($sql);
		if($result === FALSE)
			exit('ERROR SQL: '.mysqli_error());
		if(!$RS = @mysqli_fetch_array($result))
			exit('ERROR: Non trovato');
		$statut = $RS['statut'];
		$statut_id = array_search($statut, $statuts);
		$fecha_presupuesto = $RS['date_last_added'];
		$apellido_1 = $RS['apellido_1'];
		$apellido_2 = $RS['apellido_2'];
		$nombre = $RS['nombre'];
		$email = $RS['email'];
		$phone = $RS['phone'];
		$adresse = $RS['adresse'];
		$fax = $RS['fax'];
		$zip = $RS['zip'];
		$pays = $RS['pays'];
		$nombre_crucero = $RS['nom_croisiere'];
		$id_crucero = $RS['id_crucero'];
		$compania = $RS['compania'];
		$buque = $RS['buque'];
		$vuelo = $RS['vuelo'];
		$ciudad_vuelo = $RS['ciudad_vuelo'];
		$destino = $RS['destino'];
		$comenzando_fecha = $RS['comenzando_fecha'];
		$fecha_llegada = $RS['fecha_llegada'];
		$itineraire = $RS['itineraire'];
		$hora_recordatorio = $RS['hora_recordatorio'];
		$tarifas_nombre = $RS['tarifas_nombre'];
		$num_cabine = $RS['num_cabine'];
		$adulto = $RS['adulto'];
		$ninos = $RS['ninos'];
		$duracion_texto = $RS['duracion_texto'];
		$formalites = $RS['formalites'];
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
		$seguimiento = $RS['seguimiento'];
		$comentarios = $RS['comentarios'];
		$comentarios_vendedor = $RS['comentarios_vendedor'];
		$notas = $RS['notas'];
		$remise_cache = $RS['remise_cache'];
		$remise_pourcentage = $RS['remise_pourcentage'];
		$qte_tax_portuaires = $RS['qte_tax_portuaires'];
		$tax_portuaires = $RS['tax_portuaires'];
		$qte_paq_areo_vac = $RS['qte_paq_areo_vac'];
		$paq_areo_vac = $RS['paq_areo_vac'];		
		$qte_seguro = $RS['qte_seguro'];
		$seguro = $RS['seguro'];
		$text_seguro = $RS['text_seguro'];
		$fecha_presupuesto = strncmp($fecha_presupuesto, '0000-00-00', 10) != 0 ? date('d/m/Y H:i:s', strtotime($fecha_presupuesto)) : '';
		$comenzando_fecha = $comenzando_fecha != '0000-00-00' ? date('d/m/Y', strtotime($comenzando_fecha)) : '';
		$fecha_llegada = $fecha_llegada != '0000-00-00' ? date('d/m/Y', strtotime($fecha_llegada)) : '';
		$puerto_salida = $RS['puerto_salida'];
		$ciudad = $RS['ciudad'];
		$ciudad_arrivee = $RS['ciudad_arrivee'];
		$villes = $RS['itineraire'];
		// Notas: This field will only contain text in "email envoye" display
		$message = $RS['message'];
		$fitxer = $RS['fitxer'];
	}
	// This variable is generated as a commodity
	$apellido = trim($apellido_1.' '.$apellido_2);
?>