<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	$date_actuel = date ('Y-m-d H:i:s');
	require 'get_presupuesto.php';
	// Get info about this email address (last vendor who dealt with him,
	// deal most recent date, if vendor sold something to this customer)
	//prova jaume
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
	// fi prova jaume
	if($email != '') {
		$result = execute_sql("SELECT vendeur,date,vendu FROM email_contact WHERE email='".addslashes($email)."'");
		if($result === FALSE)
			exit(mysqli_error());
		if(list($vendeur, $vendor_date, $vendu) = mysqli_fetch_row($result)) {
			if($vendeur != '' && $vendeur != $pseudo) {
				if($vendu == 'si')
					// This should never occur, unless an id is manually fed to this procedure
					// without using the web interface, to attempt stealing customers from other vendors
					exit('No puedes gestionar este presupuesto, el cliente esta siendo gestionado por otro vendedor.');
				// If statut is not waiting, prevent other vendors editing it
				// Note: For Italy, if another vendor dealt with this customer,
				// it will be forever locked to that vendor.
				if($statut_id != 1/* || time() - strtotime($vendor_date) < 172800*/) {
					echo file_get_contents('templates/interdit2.html');
					return;
				}
			}
		}
		else {
			$vendeur = '';
			$vendor_date = date('Y-m-d H:i:s');
			$vendu = 'no';
		}
		// If it is a "presupuestos en attente"
		if($statut_id == 1) {
			// ******************************************
			// Count all saved items for the current user
			// ******************************************
			$result = execute_sql("SELECT COUNT(*) FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut AND s.id=2 WHERE seguimiento='$pseudo'");
			if($result === FALSE)
				exit('ERROR: No ha sido possible contra los presupuestos salvado por vuestro clientes.');
			if($row = mysqli_fetch_row($result))
				// If there are 15 or more saved items, do not store another one
				// except if it is one of my customers (those I sold to at least once).
				if($row[0] >= 15 && ($vendeur != $pseudo || $vendu != 'si')) {
					// If we did not deal before with the client who requested this item,
					// and we saved 15 items to work later on them, forbid editing it,
					// unless it was taken more than 48 hours in the past
					$template = file_get_contents('templates/interdit.html');
					echo str_replace('$total', $row[0], $template);
					return;
				}
			if(!isset($_POST['devis_copier'])) {
				// ****************************************************************
				// When the item is first picked, copy duracion_texto from database
				// ****************************************************************
				// This won't be overwritten on next item states, so can be manually edited later
				$result = execute_sql("SELECT duracion_texto FROM ofertas_cruceros WHERE id_crucero=$id_crucero");
				if($result === FALSE)
					exit(mysqli_error());
				if(!list($duracion_texto) = mysqli_fetch_row($result))
					$duracion_texto = '';
				// ***************************************************************************
				// When the item is first picked, also get the cruise route (if not specified)
				// ***************************************************************************
				if(trim($villes) == '' && $id_crucero != 0) {
					// PLEASE NOTE: The ville field in the cruceros_ruta table is broken!!!
					// Accented characters were replaced by ?, so we need a join with "ciudad" table
					$results = execute_sql("SELECT nombre_ciudad FROM cruceros_ruta r INNER JOIN ciudad c ON r.id_ciudad=c.id_ciudad WHERE id_crucero=$id_crucero ORDER BY dia");
					$villes = array();
					$i = 0;
					while($RS = mysqli_fetch_row($results))
						$villes[++$i] = $RS[0];
					// If departure and/or arrival cities were not specified, get them from the database
					if($ciudad == '')
						$ciudad = $villes[1];
					if($ciudad_arrivee == '')
						$ciudad_arrivee = $villes[$i];
					$villes = implode(', ', $villes);
				}
			}
			// **********************************************
			// Marks this customer as followed by this vendor
			// **********************************************
			// Note: This is safe, because it will never happen that
			// another vendor will take this item if some other vendor sold
			// to it, and so old vendor will never be overwritten.
			execute_sql("UPDATE email_contact SET vendeur='".addslashes($pseudo)."',date=Now() WHERE email='".addslashes($email)."'") or die(mysqli_error());
			if(mysqli_affected_rows() == 0)
				execute_sql("INSERT INTO email_contact(email,vendeur,date,vendu) VALUES('".addslashes($email)."','".addslashes($pseudo)."',Now(),'no')") or die('ERRORE SQL: '.mysqli_error());
			// *************************************************************
			// Marks this item as saved (no other users will see it anymore)
			// and stores all data generated from other database tables
			// *************************************************************
			// Note: This is only performed on "presupuestos en attente"
			if(!empty($id_presupuesto) && is_numeric($id_presupuesto))
				execute_sql("UPDATE presupuesto SET seguimiento='$pseudo',statut='$statuts[2]',date_last_added='$date_actuel',ciudad_arrivee='".addslashes($ciudad_arrivee)."',itineraire='".addslashes($villes)."',duracion_texto='".addslashes($duracion_texto)."' WHERE id_presupuesto=$id_presupuesto AND statut='$statuts[1]'") or die(mysqli_error());
			$statut = $statuts[2];
			$seguimiento = $pseudo;
			// Tell the main window to reload list, without the saved item
			$onLoad = ' onLoad="window.opener.location.reload()"';
		}
		else
			$onLoad = '';
	}
	else
		$onLoad = '';
	if(empty($id_presupuesto)) {
		// When creating a new item, always set seguimiento to the current user
		$seguimiento = $pseudo;
		$fecha_presupuestos = date('d/m/Y H:i:s');
	}
	// **************************************************
	// Get all navigation companies and generate selector
	// **************************************************
	$result = execute_sql('SELECT nombre_compania FROM compania ORDER BY nombre_compania');
	if($result === FALSE)
		exit(mysqli_error());
	$companias = '';
	$found = FALSE;
	while(list($name) = mysqli_fetch_row($result))
		if(strcasecmp($name, $compania) == 0) {
			$companias .= '<option selected>'.$name.'</option>';
			$found = TRUE;
		}
		else
			$companias .= '<option>'.$name.'</option>';
	// This should never happen, but if name stored in the database
	// was not found in the list, add it at the top of the list
	if(!$found)
		$companias = '<option selected>'.$compania.'</option>'.$companias;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Presupuesto</title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css"/>
	<script language="JavaScript" type="text/javascript" src="date.js"></script>
	<script language="JavaScript" src="../../presupuestos/calendario/CalendarPopup.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../presupuestos/calendario/CalendarStyle.css" type="text/css"/>
	<script language="JavaScript" type="text/javascript">
		<!--
			var sendEmail = false;
			function isNumericOrEmpty(t) {
				if(t == "")
					return true;
				return !isNaN(t);
			}
			function validateForm(f) {
				if(!sendEmail && f.comenzando_fecha.value == "")
					alert("La fecha de salida debe de especificarse.");
				else if(f.comenzando_fecha.value != "" && !isValidDate(f.comenzando_fecha.value))
					alert("La fecha de salida debe de ser vàlida");
				else if(!sendEmail && f.fecha_llegada.value == "")
					alert("La fecha de llegada debe de especificarse");
				else if(f.fecha_llegada.value != "" && !isValidDate(f.fecha_llegada.value))
					alert("La fecha de llegada debe de ser vàlida.");
				else if(!sendEmail && f.ciudad.value == "")
					alert("La ciudad de salida debe de especificarse.");
				else if(!sendEmail && f.ciudad_arrivee.value == "")
					alert("La ciudad de llegada debe de especificarse.");
				else if(f.fecha_pago.value != "" && !isValidDate(f.fecha_pago.value))
					alert("La fecha del pago debe de ser vàlida.");
				else if(!isNumericOrEmpty(f.prix1.value))
					alert("El precio 1 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.qte1.value))
					alert("La cantidad 1 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.prix2.value))
					alert("El precio 2 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.qte2.value))
					alert("La cantidad 2 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.prix3.value))
					alert("El precio 3 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.qte3.value))
					alert("La cantidad 3 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.prix4.value))
					alert("El precio 4 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.qte4.value))
					alert("La cantidad 4 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.prix5.value))
					alert("El precio 5 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.qte5.value))
					alert("La cantidad 5 debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.qte_tax_portuaires.value))
					alert("El importe de las Tasas Portuarias debe de tener valor numérico.");					
				else if(!isNumericOrEmpty(f.tax_portuaires.value))
					alert("El importe de las tasas portuarias debe de tener un valor numérico.");
				else if(!isNumericOrEmpty(f.qte_paq_areo_vac.value))
					alert("El importe del paquete aereo debe de tener valor numérico.");	
				else if(!isNumericOrEmpty(f.paq_areo_vac.value))
					alert("El importe del paquete aereo debe de tener valor numérico.");	
				else if(!isNumericOrEmpty(f.qte_seguro.value))
					alert("La cantidad del seguro debe de ser un valor numérico.");
				else if(!isNumericOrEmpty(f.seguro.value))
					alert("El seguro debe de ser un valor numérico.");
				else if(!isNumericOrEmpty(f.remise_cache.value))
					alert("La cantidad del descuento debe de ser un valor numérico.");
				else if(!isNumericOrEmpty(f.remise_pourcentage.value))
					alert("La percentual del descuento debe de ser un valor numérico.");
				else if(f.adulto.value=="")
					alert("El numero de adultos debe de especificarse.");					
				else if(f.ninos.value=="")
					alert("El numero de niños debe de especificarse.");				
				else if(f.qte_tax_portuaires.value=="" || f.tax_portuaires.value=="")
					alert("Las tasas deben de especificarse.");	
				else if(f.qte_paq_areo_vac.value=="" || f.paq_areo_vac.value=="")
					alert("El paquete aereo debe de especificarse.");						
				else if(f.qte_seguro.value=="" || f.seguro.value=="")
					alert("Los seguros deben de especificarse.");		
				//else if(f.remise_pourcentage.value=="" || f.remise_cache.value=="")
				//	alert("Los descuentos deben de especificarse.");																								
				else
					return true;
				return false;
			}
			function effacer() {
				if(confirm("Desea realmente cancelar este presupuesto?"))
					location.href = "borrar.php?id_presupuesto=<?=$id_presupuesto?>";
					//window.close();
			}
			var calendar = new CalendarPopup("calendardiv");
			calendar.setCssPrefix("CALENDAR");
			calendar.showYearNavigation();
			calendar.showYearNavigationInput();
		//-->
		function afegiracomentvend() {
			if(document.form.enlace.value != "http://www." && document.form.texto.value != ""){
				document.form.comentarios_vendedor.value = document.form.comentarios_vendedor.value + ' <a href=""' + document.form.enlace.value + '"" target=""_blank"">' + document.form.texto.value + '</a>';
				//document.form.comentarios_vendedor.value = htmlspecialchars(document.form.comentarios_vendedor.value);
				//alert(comentarios_vendedor);
				//alert(document.form.comentarios_vendedor.value);
			}
		}
	</script>
</head>
<body<?=$onLoad?>>

<form id="form" name="form" method="post" action="presupuesto_visual.php" onSubmit="return validateForm(this)">
	<table width="600" border="0" class="login1">
		<tr>
			<td colspan="3"><img name="agent" src="../images/top.jpg" alt="<?=$pseudo?>"/></td>
		</tr>
		<tr>
			<td bgcolor="#D7D7FF">
				<span class="error"><?php if($seguimiento != $pseudo) echo $seguimiento;?><input name="seguimiento" type="hidden" value="<?=$seguimiento?>"/></span>
			</td>
			<td colspan="2" bgcolor="#D7D7FF" align="center">estado: <?=$statut?><input name="statut" type="hidden" value="<?=$statut?>"/></td>
		</tr>
		<tr>
			<td bgcolor="#D7D7FF" nowrap>
				Presupuesto N&deg;<?php if($id_presupuesto == 0) echo isset($_REQUEST['devis_creer']) ? '(nuevo presupuesto)' : '(presupuesto copiado)'; else echo $id_presupuesto;?><input name="id_presupuesto" type="hidden" id="id_presupuesto" value="<?=$id_presupuesto?>"/></td>
			<td bgcolor="#D7D7FF" colspan="2" align="center"><span class="error"><?=$sitio?>
			<input name="sitio" type="hidden" id="sitio" value="<?=$sitio?>"/>
			</span></td>
		</tr>
	</table>
	<table width="100%" border="0" class="login1">
		<tr>
			<td colspan="4" class="header1">Informaciones del cliente</td>
		</tr>
		<tr>
			<td class="data">Apellido</td>
			<td class="data" nowrap>
				<input name="apellido_1" type="text" id="apellido_1" size="9" value="<?=$apellido_1?>"/>
				<input name="apellido_2" type="text" id="apellido_2" size="9" value="<?=$apellido_2?>"/>
			</td>
			<td class="data" nowrap>Nombre</td>
			<td class="data"><input name="nombre" type="text" size="14" id="nombre" value="<?=$nombre?>"/></td>
		</tr>
		<tr>
			<td class="data">Tel&eacute;fono</td>
			<td class="data"><input name="phone" type="text" id="phone" size="16" value="<?=$phone?>"/></td>
			<td class="data">Fax</td>
			<td class="data">
				<input name="fax" type="text" size="16" id="fax" value="<?=$fax?>"/>
				<input name="zip" type="hidden" id="zip" value="<?=$zip?>"/>
				<input name="pays" type="hidden" id="pays" value="<?=$pays?>"/>
			</td>
		</tr>
		<tr>
			<td class="data">E Mail</td>
			<td colspan="3" class="data">
				<input name="email" type="text" size="50" maxlength="60" id="email" value="<?=$email?>"/>
			</td>
		</tr>
	</table>
	<table width="600" border="0" class="login1">
		<tr>
			<td class="header1" colspan="2">Petici&oacute;n</td>
		</tr>
		<tr>
			<td class="data" colspan="2" nowrap>
				Categor&iacute;a Hotel
				<input name="tarifas_nombre" type="text" id="tarifas_nombre" size="20" maxlength="30" value="<?=$tarifas_nombre?>"/>
				Localizador
				<input name="num_cabine" type="text" size="6" maxlength="6" id="num_cabine" value="<?=$num_cabine?>"/>
			</td>
		</tr>
		<tr>
			<td class="data" colspan="2" nowrap>
				N&uacute;mero de adultos
				<input name="adulto" type="text" size="3" maxlength="2" id="adulto" value="<?=$adulto?>"/>
				N&uacute;mero de ni&ntilde;os
				<input name="ninos" type="text" size="3" maxlength="2" id="ninos" value="<?=$ninos?>"/>
				Llamar
				<input name="hora_recordatorio" type="text" size="14" maxlength="30" id="hora_recordatorio" value="<?=$hora_recordatorio?>"/>
			</td>
		</tr>
		<tr>
			<td class="data" colspan="2" nowrap>Vuelo
				<select name="vuelo" id="vuelo">
				<option value="1" <?php if($vuelo == 1) echo ' selected="selected"';?>>si</option>
				<option value="0" <?php if($vuelo != 1) echo ' selected="selected"';?>>no</option>
				</select>
				Salida desde
				<input type="text" id="ciudad_vuelo" name="ciudad_vuelo" size="12" maxlength="30" value="<?=$ciudad_vuelo?>"/>
			</td>
		</tr>
		<tr>
			<td class="data">Comentarios<br/>del cliente</td>
			<td class="data"><textarea name="comentarios" cols="66" rows="3" id="comentarios"><?=$comentarios?></textarea></td>
		</tr>
	</table>
	<table width="600" border="0" class="login1">
		<tr>
			<td colspan="4" class="header1">Detalles del viaje</td>
		</tr>
		<tr>
			<td width="20%" class="data">Viaje</td>
			<td width="30%" class="data"><input name="nombre_crucero" type="text" size="16" id="nombre_crucero" value="<?=$nombre_crucero?>"/><input name="id_crucero" type="hidden" id="id_crucero" value="<?=$id_crucero?>"/></td>
			<td width="20%" class="data">Destino</td>
			<td width="30%" class="data"><input name="destino" type="text" size="13" id="destino" value="<?=$destino?>" /></td>
		</tr>
		<tr>
			<td class="data">Proveedor</td>
			<td class="data">
				<select name="compania">
					<?=$companias?>
				</select>
			</td>
			<td class="data">Estancia/circuito</td>
			<td class="data"><input name="buque" type="text" size="13" id="buque" value="<?=$buque?>"/></td>
		</tr>
		<tr>
			<td class="data" nowrap>Fecha de salida</td>
			<td class="data"><input name="comenzando_fecha" type="text" size="10" maxlength="10" id="comenzando_fecha" value="<?=$comenzando_fecha?>"/>&nbsp;<a href="#" onclick="calendar.select(document.forms[0].comenzando_fecha,'comenzando_fecha_button','dd/MM/yyyy');return false;" name="comenzando_fecha_button" id="comenzando_fecha_button"><img src="../../presupuestos/calendario/calendario.png" border="0" style="vertical-align:middle"/></a></td>
			<td class="data" nowrap>Fecha de llegada</td>
			<td class="data"><input name="fecha_llegada" type="text" size="10" maxlength="10" id="fecha_llegada" value="<?=$fecha_llegada?>"/>&nbsp;<a href="#" onclick="calendar.select(document.forms[0].fecha_llegada,'fecha_llegada_button','dd/MM/yyyy');return false;" name="fecha_llegada_button" id="fecha_llegada_button"><img src="../../presupuestos/calendario/calendario.png" border="0" style="vertical-align:middle"/></a></td>
		</tr>
		<tr>
			<td class="data" nowrap>Ciudad de salida</td>
			<td class="data"><input name="ciudad" type="text" size="13" id="ciudad" value="<?=$ciudad?>"/></td>
			<td class="data" nowrap>Ciudad de llegada</td>
			<td class="data"><input name="ciudad_arrivee" type="text" size="13" id="ciudad_arrivee" value="<?=$ciudad_arrivee?>"/></td>
		</tr>
		<tr>
			<td class="data">Duraci&oacute;n</td>
			<td class="data"><input name="duracion_texto" type="text" size="16" id="duracion_texto" value="<?=$duracion_texto?>"/></td>
			<td class="data">Fecha del pago</td>
			<td class="data"><input name="fecha_pago" type="text" size="11" maxlength="10" id="fecha_pago" value="<?=$fecha_pago?>"/>&nbsp;<a href="#" onclick="calendar.select(document.forms[0].fecha_pago,'fecha_pago_button','dd/MM/yyyy');return false;" name="fecha_pago_button" id="fecha_pago_button"><img src="../../presupuestos/calendario/calendario.png" border="0" style="vertical-align:middle"/></a></td>
		</tr>
		<tr>
			<td class="data">Descripcion del viaje</td>
			<td colspan="3" class="data"><textarea name="itineraire" cols="60" rows="3" id="itineraire" class="textarea" ><?=$villes?></textarea></td>
		</tr>
		<tr>
			<td class="data">Adjuntar archivo</td>
			<td colspan="2" class="data"><input name="adjunt" type="file" size="50" id="adjunt" value="<?=$fitxer?>"/></td>
			<td class="data"><input type="button" value="Borrar archivo" onclick="this.form.adjunt.value=''"/></td>
		</tr>
<?php
/*
		<tr>
			<td class="data">Formalit&agrave;</td>
			<td colspan="3" class="data"><input type="text" name="formalites" id="formalites" size="70" value="<?=$formalites?>"/></td>
		</tr>
*/
?>
	</table>
	<table width="600" border="0" class="login1">
		<tr>
			<td colspan="4" class="header1">Detalles del presupuesto</td>
		</tr>
		<tr>
			<td colspan="2" class="header2"><div align="center">Denominaci&oacute;n</div></td>
			<td class="header2"><div align="center">Cantidad</div></td>
			<td class="header2"><div align="center">Precio unitario</div></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><input name="det_pass1" type="text" size="36" maxlength="50" id="det_pass1" value="<?=$det_pass1?>"/></td>
			<td class="data"><input name="qte1" type="text" id="qte1" size="3" maxlength="3" value="<?=$qte1?>"/></td>
			<td class="data"><input name="prix1" type="text" id="prix1" size="10" maxlength="10" value="<?=$prix1?>" /></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><input name="det_pass2" type="text" size="36" maxlength="50" id="det_pass2" value="<?=$det_pass2?>"/></td>
			<td class="data"><input name="qte2" type="text" id="qte2" size="3" maxlength="3" value="<?=$qte2?>"/></td>
			<td class="data"><input name="prix2" type="text" id="prix2" size="10" maxlength="10" value="<?=$prix2?>"/></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><input name="det_pass3" type="text" size="36" maxlength="50" id="det_pass3" value="<?=$det_pass3?>"/></td>
			<td class="data"><input name="qte3" type="text" id="qte3" size="3" maxlength="3" value="<?=$qte3?>"/></td>
			<td class="data"><input name="prix3" type="text" id="prix3" size="10" maxlength="10" value="<?=$prix3?>"/></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><input name="det_pass4" type="text" size="36" maxlength="50" id="det_pass4" value="<?=$det_pass4?>"/></td>
			<td class="data"><input name="qte4" type="text" id="qte4" size="3" maxlength="3" value="<?=$qte4?>"/></td>
			<td class="data"><input name="prix4" type="text" id="prix4" size="10" maxlength="10" value="<?=$prix4?>"/></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><input name="det_pass5" type="text" size="36" maxlength="50" id="det_pass5" value="<?=$det_pass5?>"/></td>
			<td class="data"><input name="qte5" type="text" id="qte5" size="3" maxlength="3" value="<?=$qte5?>"/></td>
			<td class="data"><input name="prix5" type="text" id="prix5" size="10" maxlength="10" value="<?=$prix5?>"/></td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#E6E6CC">Tasas</td>
			<td bgcolor="#E6E6CC"><input name="qte_tax_portuaires" type="text" id="qte_tax_portuaires" size="3" maxlength="3" value="<?=$qte_tax_portuaires?>"/></td>
			<td bgcolor="#E6E6CC"><input name="tax_portuaires" type="text" id="tax_portuaires" size="10" maxlength="10" value="<?=$tax_portuaires?>"/> &euro;</td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#E6E6CC">Paquete aéreo vacacional</td>
			<td bgcolor="#E6E6CC"><input name="qte_paq_areo_vac" type="text" id="qte_paq_areo_vac" size="3" maxlength="3" value="<?=$qte_paq_areo_vac?>"/></td>
			<td bgcolor="#E6E6CC"><input name="paq_areo_vac" type="text" id="paq_areo_vac" size="10" maxlength="10" value="<?=$paq_areo_vac?>"/> &euro;</td>
		</tr>		
		<tr>
			<td colspan="2" bgcolor="#E6E6CC">Seguros : <input name="text_seguro" type="text" id="text_seguro" value="<?=$text_seguro?>" maxlength="30"/></td>
			<td bgcolor="#E6E6CC"><input name="qte_seguro" type="text" size="3" maxlength="3" id="qte_seguro" value="<?=$qte_seguro?>"/></td>
			<td bgcolor="#E6E6CC" nowrap><input name="seguro" type="text" id="seguro" size="10" maxlength="10" value="<?=$seguro?>"/> &euro;</td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#DFFFDF">Descuentos</td>
			<td bgcolor="#DFFFDF" nowrap><input name="remise_pourcentage" type="text" size="3" maxlength="3" id="remise_pourcentage" value="<?=$remise_pourcentage?>"/> %</td>
			<td bgcolor="#DFFFDF" nowrap>
				<input name="remise_cache" type="text" id="remise_cache" size="10" maxlength="10" value="<?=$remise_cache?>"/> &euro;
			</td>
		</tr>
		<tr>
			<td colspan="4" class="header4">Comentarios del vendedor</td>
		</tr>
		<tr>
			<td colspan="4" class="data"><textarea name="comentarios_vendedor" cols="70" rows="4" id="comentarios_vendedor" style="width:580px"><?=$comentarios_vendedor?></textarea></td>
		</tr>

		
		
	</table>
	<table width="500" border="0" class="login1">	
		<tr>
			<td class="data">texto</td>
			<td class="data">
				<input name="texto" type="text" size="60" maxlength="90" id="email" value=""/>
			</td>
		</tr>	
		<tr>
			<td class="data">link</td>
			<td class="data">
				<input name="enlace" type="text" size="50" maxlength="90" id="email" value="http://www."/>
			</td>
			<td>
			<input type="button" value="Añadir a comentarios vendedor" onclick="afegiracomentvend()"/>
			</td>
		</tr>
	</table>
	<table width="600" border="0" class="login1">
	
	
		<tr>
			<td colspan="4" class="header3">Notas</td>
		</tr>
		<tr>
			<td colspan="4" class="data"><textarea name="notas" cols="70" rows="4" id="notas" style="width:580px"><?=$notas?></textarea></td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<a href="JavaScript:effacer()"><img src="images/trash.png" vspace="3" border="0" align="right" alt="Cancela" title="Cancela el presupuesto"/></a>
				<input type="submit" name="visualiser" value="Visualiza"/>
				<input type="submit" name="devis_sauvegarder" value="Memorizar" onclick="sendEmail=false;this.form.action='formulaire_valide.php'"/>
				<input type="submit" name="courriel" value="Enviar el email" onclick="sendEmail=true;this.form.action='mail2.php'"/>
			</td>
		</tr>
	</table>
</form>
<div id="calendardiv" style="position:absolute;visibility:hidden;background-color:white;layer-background-color:white"></div>
</body>
</html>
