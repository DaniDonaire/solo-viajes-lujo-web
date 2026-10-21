<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	require 'get_presupuesto.php';
	$total1 = $prix1 * $qte1;
	$total2 = $prix2 * $qte2;
	$total3 = $prix3 * $qte3;
	$total4 = $prix4 * $qte4;
	$total5 = $prix5 * $qte5;
	$prix_broch = $total1 + $total2 + $total3 + $total4 + $total5;
	$remise = $prix_broch * $remise_pourcentage;
	$remise1 = $remise/100;
	$prix_total1 = $prix_broch - $remise_cache - $remise1;
	$total_tax_portuaires = $qte_tax_portuaires * $tax_portuaires;
	$total_paq_areo_vac = $qte_paq_areo_vac * $paq_areo_vac;
	$total_seguro = $qte_seguro * $seguro;
	$prix_total = $prix_total1 + $total_tax_portuaires + $total_paq_areo_vac + $total_seguro;
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
			if(confirm("Vuoi veramente cancellare questa pratica?"))
				location.href = "borrar.php?id=<?=$id_presupuesto?>";
				//window.close();
		}
	//-->
	</script>
</head>

<body class="login3">

<form id="form1" name="form1" method="post" action="formulaire_valide.php">
	<input name="id" type="hidden" value="<?=$id_presupuesto?>"/>
	<input type="hidden" name="statut" value="<?=$statut?>">
	<input name="apellido_1" type="hidden" value="<?=$apellido_1?>"/>
	<input name="apellido_2" type="hidden" value="<?=$apellido_2?>"/>
	<input name="nombre" type="hidden" value="<?=$nombre?>"/>
	<input name="phone" type="hidden" value="<?=$phone?>"/>
	<input name="fax" type="hidden" value="<?=$fax?>"/>
	<input name="zip" type="hidden" value="<?=$zip?>"/>
	<input name="pays" type="hidden" value="<?=$pays?>"/>
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
	<input name="itineraire" type="hidden" value="<?=$itineraire?>"/>
	<input name="tarifas_nombre" type="hidden" value="<?=$tarifas_nombre?>"/>
	<input name="num_cabine" type="hidden" value="<?=$num_cabine?>"/>
	<input name="adulto" type="hidden" value="<?=$adulto?>"/>
	<input name="ninos" type="hidden" value="<?=$ninos?>"/>
	<input name="email" type="hidden" value="<?=$email?>"/>
	<input name="newsletter" type="hidden" value="<?=$newsletter?>"/>
	<input name="nombre_crucero" type="hidden" value="<?=$nombre_crucero?>"/>
	<input name="id_crucero" type="hidden" value="<?=$id_crucero?>"/>
	<input type="hidden" name="villes" value="<?=$villes?>">
	<input name="prix1" type="hidden" value="<?=$prix1?>"/>
	<input name="prix2" type="hidden" value="<?=$prix2?>"/>
	<input name="prix3" type="hidden" value="<?=$prix3?>"/>
	<input name="prix4" type="hidden" value="<?=$prix4?>"/>
	<input name="prix5" type="hidden" value="<?=$prix5?>"/>
	<input name="tax_portuaires" type="hidden" value="<?=$tax_portuaires?>"/>
	<input name="paq_areo_vac" type="hidden" value="<?=$paq_areo_vac?>"/>
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
	if($paq_areo_vac != '')
		$paq_areo_vac .= '&nbsp;&euro;';		
	if($seguro != '')
		$seguro .= '&nbsp;&euro;';
	if($remise_cache != '')
		$remise_cache .= '&nbsp;&euro;';
?>
	<table width="600" border="0">
		<tr>
			<td colspan="3" bgcolor="#D7D7FF">Pratica N&deg; <?=$id_presupuesto?>
				Seguita da <span class="error"><?=$seguimiento?></span>
			</td>
			<td bgcolor="#D7D7FF"><?=$sitio?>
				<input name="sitio" type="hidden" value="<?=$sitio?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="header1">Informaciones del cliente</td>
		</tr>
		<tr>
			<td width="25%" class="data">Apellido</td>
			<td width="25%" class="data"><?=$apellido?></td>
			<td width="25%" class="data">Tel&eacute;fono</td>
			<td width="25%" class="data"><?=$phone?></td>
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
			<td class="data"><?=$nombre_crucero?></td>
			<td class="data">Destino</td>
			<td class="data"><?=$destino?></td>
		</tr>
		<tr>
			<td class="data">Proveedor</td>
			<td class="data"><?=$compania?></td>
			<td class="data">Estancia o Circuito</td>
			<td class="data"><?=$buque?></td>
		</tr>
		<tr>
			<td class="data">Fecha di partenza</td>
			<td class="data"><?=$comenzando_fecha?></td>
			<td class="data">Fecha di arrivo</td>
			<td class="data"><?=$fecha_llegada?></td>
		</tr>
		<tr>
			<td class="data">Citt&agrave; di partenza</td>
			<td class="data"><?=$ciudad?></td>
			<td class="data">Citt&agrave; di arrivo</td>
			<td class="data"><?=$ciudad_arrivee?></td>
		</tr>
		<tr>
			<td class="data" nowrap>Llamar<br></td>
			<td class="data"><?=$hora_recordatorio?></td>
			<td class="data">Duraci&oacute;n</td>
			<td class="data"><?=$duracion_texto?></td>
		</tr>
		<tr>
			<td class="data">Vuelo incluido</td>
			<td colspan="3" class="data"><?=$vuelo?></td>
		</tr>
		<tr>
			<td class="data">Itinerario</td>
			<td colspan="3" class="data"><?=$itineraire?></td>
		</tr>
		<tr>
			<td colspan="4" class="header1">Dettaglio prenotazione</td>
		</tr>
		<tr>
			<td class="data" nowrap>Categor�a Hotel</td>
			<td colspan="3" class="data"><?=$tarifas_nombre?></td>
		</tr>
		<tr>
			<td class="data" nowrap>N&uacute;mero de adultos</td>
			<td class="data"><?=$adulto?></td>
			<td class="data" nowrap>N&uacute;mero de ni�os</td>
			<td class="data"><?=$ninos?></td>
		</tr>
		<tr>
			<td colspan="4" class="header1">Mensaje</td>
		</tr>
		<tr>
			<td class="data">Direcci&oacute;n de email</td>
			<td colspan="3" class="data"><?=$email?></td>
		</tr>
<!--
	<tr>
		<td class="data">Objet</td>
		<td colspan="3" class="data">$Objet</td>
	</tr>
-->
		<tr>
			<td class="data">Mensaje</td>
			<td colspan="3" class="data"><?=$message?></td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<br/>
				<input type="button" value="Salir" onClick="window.close()"/>
				<input type="submit" name="devis_copier" value="Copiar" onClick="this.form.action='formulaire_presupuesto.php'"/>
			</td>
		</tr>
	</table>
</form>
</body>
</html>