<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	require 'get_contrato.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Enviar el email</title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<form id="form1" name="form1" method="post" action="formulaire_valide.php">
<input type="hidden" name="statut" value="<?=$statut?>">
<input type="hidden" name="seguimiento" value="<?=$seguimiento?>">
<input type="hidden" name="apellido_1" value="<?=$apellido_1?>">
<input type="hidden" name="apellido_2" value="<?=$apellido_2?>">
<input type="hidden" name="nombre" value="<?=$nombre?>">
<input type="hidden" name="phone" value="<?=$phone?>">
<input type="hidden" name="adresse" value="<?=$adresse?>">
<input type="hidden" name="fax" value="<?=$fax?>">
<input type="hidden" name="zip" value="<?=$zip?>">
<input type="hidden" name="pays" value="<?=$pays?>">
<input type="hidden" name="croisiere" value="<?=$nombre_crucero?>">
<input type="hidden" name="id_crucero" value="<?=$id_crucero?>">
<input type="hidden" name="compania" value="<?=$compania?>">
<input type="hidden" name="ref_dossier" value="<?=$ref_dossier?>">
<input type="hidden" name="buque" value="<?=$buque?>">
<input type="hidden" name="vuelo" value="<?=$vuelo?>">
<input type="hidden" name="ciudad_vuelo" value="<?=$ciudad_vuelo?>">
<input type="hidden" name="destino" value="<?=$destino?>">
<input type="hidden" name="comenzando_fecha" value="<?=$comenzando_fecha?>">
<input type="hidden" name="fecha_llegada" value="<?=$fecha_llegada?>">
<input type="hidden" name="puerto_salida" value="<?=$puerto_salida?>">
<input type="hidden" name="ciudad" value="<?=$ciudad?>">
<input type="hidden" name="ciudad_arrivee" value="<?=$ciudad_arrivee?>">
<input type="hidden" name="itineraire" value="<?=$itineraire?>">
<input type="hidden" name="hora_recordatorio" value="<?=$hora_recordatorio?>">
<input type="hidden" name="tarifas_nombre" value="<?=$tarifas_nombre?>">
<input type="hidden" name="num_cabine" value="<?=$num_cabine?>">
<input type="hidden" name="adulto" value="<?=$adulto?>">
<input type="hidden" name="ninos" value="<?=$ninos?>">
<input type="hidden" name="duracion_texto" value="<?=$duracion_texto?>">
<input type="hidden" name="formalites" value="<?=$formalites?>">
<input type="hidden" name="nom1" value="<?=$nom1?>">
<input type="hidden" name="nom2" value="<?=$nom2?>">
<input type="hidden" name="nom3" value="<?=$nom3?>">
<input type="hidden" name="nom4" value="<?=$nom4?>">
<input type="hidden" name="prix1" value="<?=$prix1?>">
<input type="hidden" name="prix2" value="<?=$prix2?>">
<input type="hidden" name="prix3" value="<?=$prix3?>">
<input type="hidden" name="prix4" value="<?=$prix4?>">
<input type="hidden" name="qte1" value="<?=$qte1?>">
<input type="hidden" name="qte2" value="<?=$qte2?>">
<input type="hidden" name="qte3" value="<?=$qte3?>">
<input type="hidden" name="qte4" value="<?=$qte4?>">
<input type="hidden" name="det_pass1" value="<?=$det_pass1?>">
<input type="hidden" name="det_pass2" value="<?=$det_pass2?>">
<input type="hidden" name="det_pass3" value="<?=$det_pass3?>">
<input type="hidden" name="det_pass4" value="<?=$det_pass4?>">
<input type="hidden" name="newsletter" value="<?=$newsletter?>">
<input type="hidden" name="comentarios" value="<?=$comentarios?>">
<input type="hidden" name="comentarios_vendedor" value="<?=$comentarios_vendedor?>">
<input type="hidden" name="remise_cache" value="<?=$remise_cache?>">
<input type="hidden" name="remise_pourcentage" value="<?=$remise_pourcentage?>">
<input type="hidden" name="seguro" value="<?=$seguro?>">
<input type="hidden" name="notas" value="<?=$notas?>">
<input type="hidden" name="qte_tax_portuaires" value="<?=$qte_tax_portuaires?>">
<input type="hidden" name="tax_portuaires" value="<?=$tax_portuaires?>">
<input type="hidden" name="qte_seguro" value="<?=$qte_seguro?>">
<input type="hidden" name="qte_paq_areo_vac" value="<?=$qte_paq_areo_vac?>">
<input type="hidden" name="paq_areo_vac" value="<?=$paq_areo_vac?>">
	
<table width="600" border="0" class="login1">
	<tr>
		<td colspan="4">
			<img name="agent" src="../images/top.jpg" alt="<?=$pseudo?>">
		</td>
	</tr>
	<tr>
		<td bgcolor="#D7D7FF">
			<span class="error"><?php if($seguimiento != $pseudo) echo $pseudo;?>
			<input name="seguimiento" type="hidden" id="seguimiento" value="<?=$pseudo?>"/>
			</span>
		</td>
		<td bgcolor="#D7D7FF" colspan="3" align="center"></td>
	</tr>
	<tr>
		<td bgcolor="#D7D7FF">Presupuesto N&deg; </td>
		<td bgcolor="#D7D7FF"><input name="id" type="text" id="id" value="<?=$id_presupuesto?>"/></td>
		<td bgcolor="#D7D7FF" colspan="2"><span class="error"><?=$sitio?>
		<input name="sitio" type="hidden" id="sitio" value="<?=$sitio?>"/>
		</span></td>
	</tr>
	<tr>
		<td colspan="4" class="header1"></td>
	</tr>
	<tr>
		<td colspan="4" class="header1">Informaciones del cliente</td>
	</tr>
	<tr>
		<td width="25%" class="data">Apellido</td>
		<td width="25%" class="data"><?=$apellido?><input name="apellido_1" type="hidden" id="apellido_1" value="<?=$apellido_1?>"/><input name="apellido_2" type="hidden" id="apellido_2" value="<?=$apellido_2?>"/></td>
		<td width="25%" class="data">Tel&eacute;fono</td>
		<td width="25%" class="data"><?=$phone?><input name="phone" type="hidden" id="phone" value="<?=$phone?>"/></td>
	</tr>
	<tr>
		<td class="data">Nombre</td>
		<td class="data"><?=$nombre?><input name="nombre" type="hidden" id="nombre" value="<?=$nombre?>"/></td>
		<td class="data">Fax</td>
		<td class="data"><?=$fax?><input name="fax" type="hidden" id="fax" value="<?=$fax?>"/><input name="zip" type="hidden" id="zip" value="<?=$zip?>"/><input name="pays" type="hidden" id="pays" value="<?=$pays?>"/></td>
	</tr>
	<tr>
		<td class="data">E mail</td>
		<td colspan="3" class="data"><?=$email?><input name="email" type="hidden" id="email" value="<?=$email?>"/><input name="newsletter" type="hidden" id="newsletter" value="<?=$newsletter?>"/></td>
	</tr>
	<tr>
		<td colspan="4" class="header1">Detalles del viaje</td>
	</tr>
	<tr>
		<td class="data">Viaje</td>
		<td class="data"><?=$nombre_crucero?><input name="nombre_crucero" type="hidden" id="nombre_crucero" value="<?=$nombre_crucero?>"/><input name="id_crucero" type="hidden" id="id_crucero" value="<?=$id_crucero?>"/></td>
		<td class="data">Destino</td>
		<td class="data"><?=$destino?><input name="destino" type="hidden" id="destino" value="<?=$destino?>"/></td>
	</tr>
	<tr>
		<td class="data">Proveedor</td>
		<td class="data"><?=$compania?> <input name="compania" type="hidden" id="compania" value="<?=$compania?>"/></td>
		<td class="data">Estancia o Circuito</td>
		<td class="data"><?=$buque?> <input name="buque" type="hidden" id="buque" value="<?=$buque?>"/></td>
	</tr>
	<tr>
		<td class="data">Fecha de salida</td>
		<td class="data"><?=$comenzando_fecha?> <input name="comenzando_fecha" type="hidden" id="comenzando_fecha" value="<?=$comenzando_fecha?>"/></td>
		<td class="data">Fecha de llegada</td>
		<td class="data"><?=$fecha_llegada?><input name="fecha_llegada" type="hidden" id="fecha_llegada" value="<?=$fecha_llegada?>"/></td>
	</tr>
	<tr>
		<td class="data">Ciudad de salida</td>
		<td class="data"><?=$ciudad?><input name="ciudad" type="hidden" id="ciudad" value="<?=$ciudad?>"/></td>
		<td class="data">Ciudad de llegada</td>
		<td class="data"><?=$ciudad_arrivee?><input name="ciudad_arrivee" type="hidden" id="ciudad_arrivee" value="<?=$ciudad_arrivee?>"/></td>
	</tr>
	<tr>
		<td class="data">Duraci&oacute;n</td>
		<td class="data"><?=$duracion_texto?><input name="duracion_texto" type="hidden" value="<?=$duracion_texto?>"/></td>
		<td class="data" nowrap>chiamare<br></td>
		<td class="data"><?=$hora_recordatorio?><input name="hora_recordatorio" type="hidden" id="hora_recordatorio" value="<?=$hora_recordatorio?>"/></td>
	</tr>
	<tr>
		<td class="data">Vuelo incluido</td>
		<td colspan="3" class="data"><?=$vuelo?> <input name="vuelo" type="hidden" id="vuelo" value="<?=$vuelo?>"/></td>
	</tr>
	<tr>
		<td class="data">Itinerario</td>
		<td colspan="3" class="data"><?=$itineraire?>
		<input name="itineraire" type="hidden" id="itineraire" value="<?=$itineraire?>"/></td>
	</tr>
	<tr>
		<td colspan="4" class="header1">Detalles de la reserva</td>
	</tr>
	<tr>
		<td class="data" nowrap>Categor&iacute;a Hotel</td>
		<td colspan="3" class="data"><?=$tarifas_nombre?><input name="tarifas_nombre" type="hidden" id="tarifas_nombre" value="<?=$tarifas_nombre?>"/><input name="num_cabine" type="hidden" id="num_cabine" value="<?=$num_cabine?>" /></td>
	</tr>
	<tr>
		<td class="data" nowrap>N&uacute;mero de adultos</td>
		<td class="data" nowrap><?=$adulto?> <input name="adulto" type="hidden" id="adulto" value="<?=$adulto?>"/></td>
		<td class="data" nowrap>N&uacute;mero de ni&ntilde;os</td>
		<td class="data"><?=$ninos?> <input name="ninos" type="hidden" id="ninos" value="<?=$ninos?>"/></td>
	</tr>
	<tr>
		<td colspan="4" class="header1">Mensaje</td>
	</tr>
	<tr>
		<td class="data">Direcci&oacute;n de email</td>
		<td colspan="3" class="data"><input name="email" type="text" id="email" value="<?=$email?>" size="40"/>
		</td>
	</tr>
	<tr>
		<td class="data">Objeto</td>
		<td colspan="3" class="data"><input name="Objet" type="text" id="Objet" size="40"/></td>
	</tr>
	<tr>
		<td class="data">&nbsp;</td>
		<td colspan="3" class="data"><textarea name="message" cols="58" rows="20" id="message">Buenos d&iacute;as </textarea></td>
	</tr>
	<tr>
		<td colspan="4" align="center">
			<input type="submit" name="retour" value="Atr&aacute;s" onClick="this.form.action='<?=$_SERVER['HTTP_REFERER']?>'"/>
			<input type="submit" name="envoyer_message" value="Env&iacute;a el mensaje"/>
		</td>
	</tr>
</table>
</form>
</body>
</html>
