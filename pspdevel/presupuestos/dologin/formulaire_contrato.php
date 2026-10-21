<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	$date_t = date ('Y-m-d H:i:s');
	require 'get_contrato.php';
	$paymentMethods = array('Tarjeta de Credito', 'Tarjeta de Credito a cuenta', 'Transferencia', 'Transferencia a cuenta');
	foreach($paymentMethods as $i => $method)
		if(strcasecmp($mode_pay, $method) == 0)
			$checkedPayment[$i + 1] = ' checked';
		else
			$checkedPayment[$i + 1] = '';
	if(empty($id_presupuesto)) {
		// When creating a new contract, always set seguimiento to the current user
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Contrato</title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css"/>
	<script language="JavaScript" type="text/javascript" src="date.js"></script>
	<script language="JavaScript" src="../../presupuestos/calendario/CalendarPopup.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../presupuestos/calendario/CalendarStyle.css" type="text/css"/>
	<script language="JavaScript" type="text/javascript">
	<!--
		function isNumericOrEmpty(t) {
			if(t == "")
				return true;
			var validChars = "0123456789.";
			var c;
			for (i = 0; i < t.length; i++)
				if(validChars.indexOf(t.charAt(i)) == -1)
					return false;
			return true;
		}
		function validateForm(f) {
			l = f.mode_pay.length;
			mode_pay_set = false;
			for(i = 0; i < l; i++)
				if(f.mode_pay[i].checked) {
					mode_pay_set = true;
					break;
				}
			if(f.comenzando_fecha.value == "")
				alert("La fecha de salida debe de especificarse.");
			else if(!isValidDate(f.comenzando_fecha.value))
				alert("La fecha de salida debe de ser vàlida");
			else if(f.fecha_llegada.value == "")
				alert("La fecha de llegada debe de especificarse");
			else if(!isValidDate(f.fecha_llegada.value))
				alert("La fecha de llegada debe de ser vàlida.");
			else if(f.ciudad.value == "")
				alert("La ciudad de salida debe de especificarse.");
			else if(f.ciudad_arrivee.value == "")
				alert("La ciudad de llegada debe de especificarse.");
			else if(f.ref_dossier.value == "")
				alert("Introducir el número de Dossier.");
			else if(f.fecha_opcion.value == "")
				alert("Introducir la fecha de caducidad.");
			else if(!isValidDate(f.fecha_opcion.value))
				alert("La fecha de caducidad debe de ser vàlida.");
			else if(f.fecha_pago.value == "")
				alert("Introducir la fecha del pago.");
			else if(!isValidDate(f.fecha_pago.value))
				alert("La fecha del pago debe de ser vàlida.");
			else if(f.nom1.value == "")
				alert("Introducir el nombre del primer pasajero.");
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
				alert("El importe de las Tasas Portuarias debe de tener valor numérico.");
			else if(!isNumericOrEmpty(f.paq_areo_vac.value))
				alert("El importe de las tasas portuarias debe de tener un valor numérico.");				
			else if(!isNumericOrEmpty(f.qte_seguro.value))
				alert("La cantidad del seguro debe de ser un valor numérico.");
			else if(!isNumericOrEmpty(f.seguro.value))
				alert("El seguro debe de ser un valor numérico.");
			else if(!isNumericOrEmpty(f.remise_cache.value))
				alert("La cantidad del descuento debe de ser un valor numérico.");
			else if(!isNumericOrEmpty(f.remise_pourcentage.value))
				alert("La percentual del descuento debe de ser un valor numérico.");
			else if(!mode_pay_set)
				alert("Escoger la modalidad de pago.");
			else if(f.adulto.value=="")
					alert("El numero de adultos debe de especificarse.");	
			else if(f.ninos.value=="")
					alert("El numero de niños debe de especificarse.");									
			else
				return true;
			return false;
		}
		function effacer() {
			if(confirm("Desea realmente cancelar este contrato?"))
				location.href = "borrar.php?id_presupuesto=<?=$id_presupuesto?>";
				//window.close();
		}
		var calendar = new CalendarPopup("calendardiv");
		calendar.setCssPrefix("CALENDAR");
		calendar.showYearNavigation();
		calendar.showYearNavigationInput();
	//-->
	</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="contrato_visual.php" onSubmit="return validateForm(this)">
	<input name="statut" type="hidden" value="<?=$statut?>"/>
	<input name="num_cabine" type="hidden" value="<?=$num_cabine?>"/>
	<input name="id_crucero" type="hidden" value="<?=$id_crucero?>"/>
	<img name="agent" src="../images/top.jpg" alt="<?=$pseudo?>">
	<table width="100%" border="0" class="login3">
		<tr>
			<td width="104" bgcolor="#D7D7FF">
				<span class="error"><?php if($seguimiento != $pseudo) echo $pseudo; ?>
				<input name="seguimiento" type="hidden" value="<?=$seguimiento?>"/>
				</span>
			</td>
			<td colspan="3" width="193" bgcolor="#D7D7FF" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td bgcolor="#D7D7FF" nowrap>Contrato N&deg;</td>
			<td colspan="2" bgcolor="#D7D7FF" class="error"><?php if($id_presupuesto == 0) echo isset($_REQUEST['contrat_creer']) ? 'Nuevo Contrato' : 'Contrato Copiado'; else echo $id_presupuesto;?><input name="id_presupuesto" type="hidden" value="<?=$id_presupuesto?>"/></td>
			<td bgcolor="#D7D7FF"><span class="error"><?=$sitio?>
			<input name="sitio" type="hidden" value="<?=$sitio?>"/>
			</span></td>
		</tr>
		<tr>
			<td colspan="4" class="header1">Informaciones del cliente</td>
		</tr>
		<tr>
			<td class="data">Apellido</td>
			<td width="193" class="data" nowrap>
				<input name="apellido_1" type="text" id="apellido_1" size="10" value="<?=$apellido_1?>"/>
				<input name="apellido_2" type="text" id="apellido_2" size="10" value="<?=$apellido_2?>"/>
			</td>
			<td width="119" class="data">Tel&eacute;fono</td>
			<td width="166" class="data"><input name="phone" type="text" id="phone" size="16" value="<?=$phone?>"/></td>
		</tr>
		<tr>
			<td class="data">Nombre</td>
			<td class="data"><input name="nombre" type="text" id="nombre" value="<?=$nombre?>"/></td>
			<td class="data">Fax</td>
			<td class="data"><input name="fax" type="text" id="fax" size="16" value="<?=$fax?>"/><input name="zip" type="hidden" value="<?=$zip?>"/><input name="pays" type="hidden" value="<?=$pays?>"/></td>
		</tr>
		<tr>
			<td class="data">E mail</td>
			<td colspan="3" class="data"><input name="email" type="text" size="36" id="email" value="<?=$email?>"/>
			</td>
		</tr>
	</table>
	<table width="100%" border="0" class="login3">
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
			<td class="data" colspan="2" nowrap>Volo
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
	<table width="100%" border="0" class="login3">
		<tr>
			<td colspan="4" class="header1">Detalles del viaje</td>
		</tr>
		<tr>
			<td class="data">Viaje</td>
			<td class="data"><input name="nombre_crucero" type="text" size="18" id="nombre_crucero" value="<?=$nombre_crucero?>"/></td>
			<td class="data">Destino</td>
			<td class="data"><input name="destino" type="text" id="destino" value="<?=$destino?>" /></td>
		</tr>
		<tr>
			<td class="data">Proveedor</td>
			<td class="data">
				<select name="compania">
					<?=$companias?>
				</select>
			</td>
			<td class="data">Estancia o Circuito</td>
			<td class="data"><input name="buque" type="text" id="buque" value="<?=$buque?>"/></td>
		</tr>
		<tr>
			<td class="data">Fecha de salida</td>
			<td class="data"><input name="comenzando_fecha" type="text" size="11" maxlength="10" id="comenzando_fecha" value="<?=$comenzando_fecha?>"/>&nbsp;<a href="#" onclick="calendar.select(document.forms[0].comenzando_fecha,'comenzando_fecha_button','dd/MM/yyyy');return false;" name="comenzando_fecha_button" id="comenzando_fecha_button"><img src="../../presupuestos/calendario/calendario.png" border="0" style="vertical-align:middle"/></a></td>
			<td class="data">Fecha de llegada</td>
			<td class="data"><input name="fecha_llegada" type="text" size="11" maxlength="10" id="fecha_llegada" value="<?=$fecha_llegada?>"/>&nbsp;<a href="#" onclick="calendar.select(document.forms[0].fecha_llegada,'fecha_llegada_button','dd/MM/yyyy');return false;" name="fecha_llegada_button" id="fecha_llegada_button"><img src="../../presupuestos/calendario/calendario.png" border="0" style="vertical-align:middle"/></a></td>
		</tr>
		<tr>
			<td class="data">Ciudad de salida</td>
			<td class="data"><input name="ciudad" type="text" id="ciudad" size="18" value="<?=$ciudad?>"/></td>
			<td class="data">Ciudad de llegada</td>
			<td class="data"><input name="ciudad_arrivee" type="text" id="ciudad_arrivee" size="18" value="<?=$ciudad_arrivee?>"/></td>
		</tr>
		<tr>
			<td rowspan="2" class="data">Itinerario</td>
			<td rowspan="2" class="data"><textarea name="itineraire" cols="24" rows="4" id="itineraire" class="textarea"><?=$villes?></textarea></td>
			<td class="data">Duraci&oacute;n</td>
			<td class="data"><input name="duracion_texto" type="text" id="duracion_texto" value="<?=$duracion_texto?>"/></td>
		</tr>
<?php
/*
		<tr>
			<td class="data">Formalit&agrave;</td>
			<td class="data"><textarea name="formalites" id="formalites" cols="20" rows="2"><?=$formalites?></textarea></td>
		</tr>
*/
?>
	</table>
	<table width="100%" border="0" class="login3">
		<tr>
			<td colspan="4" class="header1">Detalles del contrato</td>
		</tr>
		<tr>
			<td class="data" nowrap>Num. dossier *</td>
			<td class="data"><input name="ref_dossier" type="text" id="ref_dossier" maxlength="15" size="14" value="<?=$ref_dossier?>"/></td>
			<td class="data" nowrap>Fecha de opci&oacute;n *</td>
			<td class="data"><input name="fecha_opcion" type="text" size="11" maxlength="10" id="fecha_opcion" value="<?=$fecha_opcion?>"/>&nbsp;<a href="#" onclick="calendar.select(document.forms[0].fecha_opcion,'fecha_opcion_button','dd/MM/yyyy');return false;" name="fecha_opcion_button" id="fecha_opcion_button"><img src="../../presupuestos/calendario/calendario.png" border="0" style="vertical-align:middle"/></a></td>
		</tr>
		<tr>
			<td class="data" nowrap>Fecha del pago *</td>
			<td class="data" colspan="3"><input name="fecha_pago" type="text" size="11" maxlength="10" id="fecha_pago" value="<?=$fecha_pago?>"/>&nbsp;<a href="#" onclick="calendar.select(document.forms[0].fecha_pago,'fecha_pago_button','dd/MM/yyyy');return false;" name="fecha_pago_button" id="fecha_pago_button"><img src="../../presupuestos/calendario/calendario.png" border="0" style="vertical-align:middle"/></a></td>
		</tr>
		<tr>
			<td class="data">Pasajero 1 *</td>
			<td class="data"><input name="nom1" type="text" id="nom1" size="15" maxlength="40" value="<?=$nom1?>"/></td>
			<td class="data">Pasajero 2</td>
			<td class="data"><input name="nom2" type="text" id="nom2" size="15" maxlength="40" value="<?=$nom2?>"/></td>
		</tr>
		<tr>
			<td class="data">Pasajero 3</td>
			<td class="data"><input name="nom3" type="text" id="nom3" size="15" maxlength="40" value="<?=$nom3?>"/></td>
			<td class="data">Pasajero 4</td>
			<td class="data"><input name="nom4" type="text" id="nom4" size="15" maxlength="40" value="<?=$nom4?>"/></td>
		</tr>
	</table>
	<table width="100%" border="0" class="login3">
		<tr>
			<td colspan="4" class="header1">Detalles presupuesto</td>
		</tr>
		<tr>
			<td colspan="2" class="header2"><div align="center">Denominaci&oacute;n</div></td>
			<td class="header2"><div align="center">Cantidad</div></td>
			<td class="header2"><div align="center">Precio Unitario</div></td>
		</tr>
		<tr>
			<td colspan="2" class="data">
			<input name="det_pass1" type="text" size="36" maxlength="50" id="det_pass1" value="<?=$det_pass1?>"/>
			</td>
			<td class="data"><input name="qte1" type="text" id="qte1" size="3" maxlength="3" value="<?=$qte1?>"/></td>
			<td class="data"><input name="prix1" type="text" id="prix1" size="10" maxlength="10" value="<?=$prix1?>" /></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><input name="det_pass2" type="text" size="36" maxlength="50" id="det_pass2" value="<?=$det_pass2?>" /></td>
			<td class="data"><input name="qte2" type="text" id="qte2" size="3" maxlength="3" value="<?=$qte2?>"/></td>
			<td class="data"><input name="prix2" type="text" id="prix2" size="10" maxlength="10" value="<?=$prix2?>"/></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><input name="det_pass3" type="text" size="36" maxlength="50" id="det_pass3" value="<?=$det_pass3?>" /></td>
			<td class="data"><input name="qte3" type="text" id="qte3" size="3" maxlength="3" value="<?=$qte3?>"/></td>
			<td class="data"><input name="prix3" type="text" id="prix3" size="10" maxlength="10" value="<?=$prix3?>"/></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><input name="det_pass4" type="text" size="36" maxlength="50" id="det_pass4" value="<?=$det_pass4?>" /></td>
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
			<td colspan="2" bgcolor="#E6E6CC">Seguros <input name="text_seguro" type="text" id="text_seguro" value="<?=$text_seguro?>" maxlength="30"/></td>
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
			<td colspan="4" class="header4">
				<table>
					<tr>
						<td>Modalidad de pago :</td>
						<td valign="top" colspan="3">
							<input type="radio" name="mode_pay" value="<?=$paymentMethods[0]?>"<?=$checkedPayment[1]?>>Pago con Tarjeta de Cr&eacute;dito<br/>
							<input type="radio" name="mode_pay" value="<?=$paymentMethods[1]?>"<?=$checkedPayment[2]?>>Pago con Tarjeta de Cr&eacute;dito a cuenta<br/>
							<input type="radio" name="mode_pay" value="<?=$paymentMethods[2]?>"<?=$checkedPayment[3]?>>Pago por transferencia<br/>
							<input type="radio" name="mode_pay" value="<?=$paymentMethods[3]?>"<?=$checkedPayment[4]?>>Pago a cuenta con transferencia
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="data" class="login">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" class="header4">Comentarios del vendedor</td>
		</tr>
		<tr>
			<td colspan="4" class="data"><textarea name="comentarios_vendedor" cols="82" rows="4" id="comentarios_vendedor"><?=$comentarios_vendedor?></textarea></td>
		</tr>
		<tr>
			<td colspan="4" class="header3">Notas</td>
		</tr>
		<tr>
			<td colspan="4" class="data"><textarea name="notas" cols="82" rows="4" id="notas"><?=$notas?></textarea></td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<a href="JavaScript:effacer()"><img src="images/trash.png" vspace="3" border="0" align="right" alt="Cancelar" title="Cancela el contrato"></a>
				<input type="submit" name="visualiser" value="Visualiza"/>
			</td>
		</tr>
	</table>
</form>
<div id="calendardiv" style="position:absolute;visibility:hidden;background-color:white;layer-background-color:white"></div>
</body>
</html>
