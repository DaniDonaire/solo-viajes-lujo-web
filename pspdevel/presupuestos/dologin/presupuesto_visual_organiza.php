<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	require 'get_presupuesto.php';
	if($prix1 != '' && $qte1 != '')
		$total1 = $prix1 * $qte1;
	else
		$total1 = 0;
	if($prix2 != '' && $qte2 != '')	
		$total2 = $prix2 * $qte2;
	else
		$total2 = 0;
	if($prix3 != '' && $qte3 != '')
		$total3 = $prix3 * $qte3;
	else
		$total3 = 0;
	if($prix4 != '' && $qte4 != '')
		$total4 = $prix4 * $qte4;
	else
		$total4 = 0;
	if($prix5 != '' && $qte5 != '')
		$total5 = $prix5 * $qte5;
	else
		$total5 = 0;
	$prix_broch = $total1 + $total2 + $total3 + $total4 + $total5;
		// mod jaume descomptes	
		/* part vella
		$prix_broch = $total1 + $total2 + $total3 + $total4 + $total5;
		$remise = $prix_broch * $remise_pourcentage;
		$remise1 = $remise/100;
		$prix_total1 = $prix_broch - $remise_cache - $remise1;
		// fi part vella */
		// part nova 
		$remise1 = 0;
		if($remise_cache != '' && $remise_cache != '0') {	
			$remise1 = $remise_cache;
		}
		else {
			if($remise_pourcentage != '' && $remise_pourcentage != '0') {	
					$remise = $prix_broch * $remise_pourcentage;
					$remise1 = $remise/100;
			}
		}
		$prix_total1 = $prix_broch - $remise1;
		// fi part nova
		// fi mod jaume descomptes	
	
	$total_tax_portuaires = $qte_tax_portuaires * $tax_portuaires;
	$total_seguro = $qte_seguro * $seguro;
	$prix_total = $prix_total1 + $total_tax_portuaires + $total_seguro;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Visualiza <?=$statut?></title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css"/>
	<script language="JavaScript" type="text/javascript">
	<!--
		function effacer() {
			if(confirm("Desea realmente cancelar este presupuesto?"))
				location.href = "borrar.php?id=<?=$id_presupuesto?>";
				//window.close();
		}
	//-->
	</script>
</head>

<body class="login3">

<form id="form1" name="form1" method="post" action="formulaire_valide.php">
	<input name="id_presupuesto" type="hidden" value="<?=$id_presupuesto?>"/>
	<input type="hidden" name="statut" value="<?=$statut?>">
	<input name="apellido_1" type="hidden" value="<?=$apellido_1?>"/>
	<input name="apellido_2" type="hidden" value="<?=$apellido_2?>"/>
	<input name="phone" type="hidden" value="<?=$phone?>"/>
	<input name="nombre" type="hidden" value="<?=$nombre?>"/>
	<input name="fax" type="hidden" value="<?=$fax?>"/>
	<input name="zip" type="hidden" value="<?=$zip?>"/>
	<input name="pays" type="hidden" value="<?=$pays?>"/>
	<input name="email" type="hidden" value="<?=$email?>"/>
	<input name="nombre_crucero" type="hidden" value="<?=$nombre_crucero?>"/>
	<input name="id_crucero" type="hidden" value="<?=$id_crucero?>"/>
	<input name="destino" type="hidden" value="<?=$destino?>"/>
	<input name="compania" type="hidden" value="<?=$compania?>"/>
	<input name="buque" type="hidden" value="<?=$buque?>"/>
	<input name="comenzando_fecha" type="hidden" value="<?=$comenzando_fecha?>"/>
	<input name="fecha_llegada" type="hidden" value="<?=$fecha_llegada?>"/>
	<input name="puerto_salida" type="hidden" value="<?=$puerto_salida?>"/>
	<input name="ciudad" type="hidden" value="<?=$ciudad?>"/>
	<input name="ciudad_arrivee" type="hidden" value="<?=$ciudad_arrivee?>"/>
	<input name="hora_recordatorio" type="hidden" value="<?=$hora_recordatorio?>"/>
	<input name="duracion_texto" type="hidden" value="<?=$duracion_texto?>"/>
	<input name="vuelo" type="hidden" value="<?=$vuelo?>"/>
	<input name="ciudad_vuelo" type="hidden" value="<?=$ciudad_vuelo?>"/>
	<input name="itineraire" type="hidden" value="<?=$itineraire?>"/>
	<input name="tarifas_nombre" type="hidden" value="<?=$tarifas_nombre?>"/>
	<input name="num_cabine" type="hidden" value="<?=$num_cabine?>"/>
	<input name="adulto" type="hidden" value="<?=$adulto?>"/>
	<input name="ninos" type="hidden" value="<?=$ninos?>"/>
	<input name="formalites" type="hidden" value="<?=$formalites?>"/>
	<input name="det_pass1" type="hidden" value="<?=$det_pass1?>"/>
	<input name="qte1" type="hidden"	value="<?=$qte1?>"/>
	<input name="det_pass2" type="hidden" value="<?=$det_pass2?>"/>
	<input name="qte2" type="hidden"	value="<?=$qte2?>"/>
	<input name="det_pass3" type="hidden" value="<?=$det_pass3?>"/>
	<input name="qte3" type="hidden"	value="<?=$qte3?>"/>
	<input name="det_pass4" type="hidden" value="<?=$det_pass4?>"/>
	<input name="qte4" type="hidden"	value="<?=$qte4?>"/>
	<input name="det_pass5" type="hidden" value="<?=$det_pass5?>"/>
	<input name="qte5" type="hidden"	value="<?=$qte5?>"/>
	<input name="qte_tax_portuaires" type="hidden" value="<?=$qte_tax_portuaires?>"/>
	<input name="text_seguro" type="hidden" value="<?=$text_seguro?>"/>
	<input name="qte_seguro" type="hidden"	value="<?=$qte_seguro?>"/>
	<input name="prix_total" type="hidden" value="<?=$prix_total?>"/>
	<input name="comentarios" type="hidden" value="<?=$comentarios?>"/>
	<input name="comentarios_vendedor" type="hidden" value="<?=$comentarios_vendedor?>"/>
	<input name="notas" type="hidden" value="<?=$notas?>"/>
	<input type="hidden" name="villes" value="<?=$villes?>">
	<input name="prix1" type="hidden" value="<?=$prix1?>"/>
	<input name="prix2" type="hidden" value="<?=$prix2?>"/>
	<input name="prix3" type="hidden" value="<?=$prix3?>"/>
	<input name="prix4" type="hidden" value="<?=$prix4?>"/>
	<input name="prix5" type="hidden" value="<?=$prix5?>"/>
	<input name="tax_portuaires" type="hidden" value="<?=$tax_portuaires?>"/>
	<input name="seguro" type="hidden" value="<?=$seguro?>"/>
	<input name="remise_cache" type="hidden" value="<?=$remise_cache?>"/>
	<input name="remise_pourcentage" type="hidden" value="<?=$remise_pourcentage?>"/>
	<input name="seguimiento" type="hidden" value="<?=$seguimiento?>"/>
	<img name="agent" src="../images/top.jpg" alt="<?=$seguimiento?>">
<?php
	if($prix1 != '')
		$prix1 .= '&nbsp;&euro;';
	if($prix2 != '')
		$prix2 .= '&nbsp;&euro;';
	if($prix3 != '')
		$prix3 .= '&nbsp;&euro;';
	if($prix4 != '')
		$prix4 .= '&nbsp;&euro;';
	if($prix5 != '')
		$prix5 .= '&nbsp;&euro;';
	if($tax_portuaires != '')
		$tax_portuaires .= '&nbsp;&euro;';
	if($seguro != '')
		$seguro .= '&nbsp;&euro;';
	if($remise_cache != '')
		$remise_cache .= '&nbsp;&euro;';
	$itineraire = str_replace(',', ', ', $itineraire);
	if($id_presupuesto == 0)
		$title_presupuesto = 'Nuevo presupuesto';
	else
		$title_presupuesto = 'Presupuesto N&deg; '.$id_presupuesto;
?>
	<table width="600" border="0">
		<tr>
			<td colspan="3" bgcolor="#D7D7FF"><?=$title_presupuesto?> -
				Seguimiento efectuado por <span class="error"><?=$seguimiento?></span>
			</td>
			<td bgcolor="#D7D7FF"><?=$sitio?>
				<input name="sitio" type="hidden" value="<?=$sitio?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="header1">Informaciones del cliente</td>
		</tr>
		<tr>
			<td width="100" class="data">Apellido</td>
			<td width="100" class="data"><?=$apellido_1.' '.$apellido_2?></td>
			<td width="100" class="data">Tel&eacute;fono</td>
			<td width="100" class="data"><?=$phone?></td>
		</tr>
		<tr>
			<td class="data">Nombre</td>
			<td class="data"><?=$nombre?></td>
			<td class="data">Fax</td>
			<td class="data"><?=$fax?></td>
		</tr>
		<tr>
			<td class="data">E mail</td>
			<td colspan="3" class="data"><?=$email?></td>
		</tr>
		<tr>
			<td colspan="4" class="header1">Detalles del viaje</td>
		</tr>
		<tr>
			<td class="data">Viaje</td>
			<td class="data" colspan="3"><?=$nombre_crucero?></td>
		</tr>
		<tr>
			<td class="data">Destino</td>
			<td class="data"><?=$destino?></td>
			<td class="data">Proveedor</td>
			<td class="data"><?=$compania?></td>
		</tr>
		<tr>
			<td class="data">Estancia o circuito</td>
			<td class="data"><?=$buque?></td>
			<td class="data">Duraci&oacute;n</td>
			<td class="data"><?=$duracion_texto?></td>
		</tr>
		<tr>
			<td class="data">Fecha de salida</td>
			<td class="data"><?=$comenzando_fecha?></td>
			<td class="data">Fecha de llegada</td>
			<td class="data"><?=$fecha_llegada?></td>
		</tr>
		<tr>
			<td class="data">Ciudad de salida</td>
			<td class="data"><?=$ciudad?></td>
			<td class="data">Ciudad de llegada</td>
			<td class="data"><?=$ciudad_arrivee?></td>
		</tr>
		<tr>
			<td class="data">Llamar<br></td>
			<td class="data"><?=$hora_recordatorio?></td>
		</tr>
		<tr>
			<td class="data">Vuelo incluido</td>
			<td class="data"><?=$vuelo?></td>
			<td class="data">Salida desde</td>
			<td class="data"><?=$ciudad_vuelo?></td>
		</tr>
		<tr>
			<td class="data">Descripcion de viaje</td>
			<td colspan="3" class="data"><?=$itineraire?></td>
		</tr>
<?php
/*
		<tr>
			<td class="data">Formalit&agrave;</td>
			<td colspan="3" class="data"><?=$formalites?>
			</td>
		</tr>
*/
?>
	</table>
	<table width="600" border="0">
		<tr>
			<td colspan="4" class="header1">Detalles de la reserva</td>
		</tr>
		<tr>
			<td class="data" nowrap>Categor&iacute;a Hotel</td>
			<td class="data"><?=$tarifas_nombre?></td>
			<td class="data">N&uacute;mero de adultos</td>
			<td class="data"><?=$adulto?></td>
		</tr>
		<tr>
			<td class="data">N&deg; localizador</td>
			<td class="data"><?=$num_cabine?></td>
			<td class="data">N&uacute;mero de ni&ntilde;os</td>
			<td class="data"><?=$ninos?></td>
		</tr>
	</table>
	<table width="600" border="0">
		<tr>
			<td colspan="4" class="header1">Nuestros presupuesto</td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#59ACFF"><div align="center">Denominaci&oacute;n</div></td>
			<td bgcolor="#59ACFF"><div align="center">Quantit&agrave;</div></td>
			<td bgcolor="#59ACFF"><div align="center">Precio Unitario</div></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><?=$det_pass1?></td>
			<td class="data"><?=$qte1?></td>
			<td class="data"><?=$prix1?></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><?=$det_pass2?>
			</td>
			<td class="data"><?=$qte2?></td>
			<td class="data"><?=$prix2?></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><?=$det_pass3?>
			</td>
			<td class="data"><?=$qte3?></td>
			<td class="data"><?=$prix3?></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><?=$det_pass4?>
			</td>
			<td class="data"><?=$qte4?></td>
			<td class="data"><?=$prix4?></td>
		</tr>
		<tr>
			<td colspan="2" class="data"><?=$det_pass5?>
			</td>
			<td class="data"><?=$qte5?></td>
			<td class="data"><?=$prix5?></td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#E6E6CC">Tasas</td>
			<td bgcolor="#E6E6CC"><?=$qte_tax_portuaires?></td>
			<td bgcolor="#E6E6CC"><?=$tax_portuaires?></td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#E6E6CC">Seguros<?php if($text_seguro != '') echo ' ('.$text_seguro.')';?>:</td>
			<td bgcolor="#E6E6CC"><?=$qte_seguro?></td>
			<td bgcolor="#E6E6CC"><?=$seguro?></td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#DFFFDF">Descuentos</td>
			<td bgcolor="#DFFFDF"><?=$remise_pourcentage?>&nbsp;%</td>
			<td bgcolor="#DFFFDF"><?=$remise_cache?></td>
		</tr>
		<tr>
			<td colspan="3" bgcolor="#FFD2D2">Total</td>
			<td bgcolor="#FFD2D2"><?=$prix_total?> &nbsp;&euro;</td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="#006699" class="login">Comentarios del cliente</td>
			<td colspan="2" class="data"><?=$comentarios?></td>
		</tr>
		<tr>
			<td colspan="2" class="header4">Comentarios del vendedor</td>
			<td colspan="2" class="data"><?=$comentarios_vendedor?>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="header3">Notas</td>
		</tr>
		<tr>
			<td colspan="4" class="data"><textarea name="notas" cols="70" rows="3"><?=$notas?></textarea></td>
		</tr>
		<!--tr>
			<td colspan="4" align="center">
<?=$buttons?>
			</td>
		</tr-->
	</table>
</form>
</body>
</html>