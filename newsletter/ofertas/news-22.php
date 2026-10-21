<?php
include ("../../include/sql.php");
include ("../../include/execute_sql.php");

//$id_lanza = $_GET["id_lanza"];
if ($_GET["id_lanza"] != ""){
	$id_lanza = $_GET["id_lanza"];
}
else {
	$id_lanza = 1;
}

$sql_all_news_lanza = sql_all_news_lanza($id_lanza);
$result_sql_all_news = execute_sql($sql_all_news_lanza);
$RS = mysqli_fetch_array($result_sql_all_news);
	
$texto_click = $RS["texto_click"];
$logo = $RS["logo"];
$texto_cabecera = $RS["texto_cabecera"];
$logo_pie_wrld = $RS["logo_pie_wrld"];
$logo_pie_svl = $RS["logo_pie_svl"];
$logo_pie_eve = $RS["logo_pie_eve"];
$logo_pie_cru = $RS["logo_pie_cru"];
$titulo = $RS["titulo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Soloviajesdelujo.com</title>

<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-2.css?v=1323820464" />
<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-3.css?v=1322040781" />

</head>
<body bgcolor="#ffffff">
<center><font face="Verdana,Arial" size="1"><a style="color: #000;" href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-22.php?id_lanza=<? echo "$id_lanza"; ?>"><? echo "$texto_click"; ?></a></font></center>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#312b2b">

		<? if ($logo == 'W') { ?>
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#312b2b">
		<? } else if ($logo == 'S') { ?>
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#312b2b">		
		<? } else if ($logo == 'C') { ?>
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#312b2b">			
		<? } else if ($logo == 'E') { ?>
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#312b2b">		
		<? } else if ($logo == 'M') { ?>
			<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0AB1F8">
		<? } ?>
		
  <tr>
    <td bgcolor="#FFFFFF"><center>
	
	<? if ($logo == 'W') { ?>
		<a style="color:#000000; font-size:20px;" href="http://www.worldcruceros.com">
		<img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/logo-cap-wrld.jpg" width="600" height="100" border="0" alt="ofertas">
	<? } else if ($logo == 'S') { ?>
		<a style="color:#000000; font-size:20px;" href="http://www.soloviajesdelujo.com">
		<img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/logo.jpg" width="600" height="100" border="0" alt="ofertas">
	<? } else if ($logo == 'C') { ?>
		<a style="color:#000000; font-size:20px;" href="http://www.crucerosensuite.com">
		<img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/logo-cruensuite.jpg" width="600" height="100" border="0" alt="ofertas">
	<? } else if ($logo == 'E') { ?>
		<a style="color:#000000; font-size:20px;" href="http://www.eventos3mundos.com">
		<img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/logo-eventos.jpg" width="600" height="100" border="0" alt="ofertas">
	<? } else if ($logo == 'M') { ?>
		<a style="color:#000000; font-size:20px;" href="http://www.entre3mundos.com">
		<img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/logo-e3m.jpg" width="600" height="100" border="0" alt="ofertas">
	<? } ?>
							
	</a></center></td>
  </tr>

  <tr>
          <td style="font: normal 18px Arial, Verdana; color:#ffffff" align="center"><? echo "$texto_cabecera"; ?></td>

  </tr>
 
 
 
  <tr>
    <td>
	    <?php

	//echo $sql_all_news_lanza;
	if(mysqli_num_rows($result_sql_all_news) > 0) {
		mysqli_data_seek($result_sql_all_news, 0);
	
	while($RS = mysqli_fetch_array($result_sql_all_news)) {
		$id_new = $RS["id_news"];
		$titulo = $RS["titulo"];
		$imagen = $RS["imagen"];
		$texto = $RS["texto"];
		$texto = preg_replace('@(\[web=([^\]]*)]([^\]]*)\[\/web\])@', '<a href="\2" class="estilolink" target="_blank">\3</a>', $texto);
		$descuento = $RS["descuento"];			
		$destino = $RS["nombre_pagina_destino"];
		$id_lanzamiento_imagen = $RS["id_lanzamiento_imagen"];	
?> 
      <table width="560" border="0" align="center" cellpadding="0" cellspacing="0">

        <tr>
		<td width="560" valign="top" bgcolor="#423c3c">	
            <table width="560" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td colspan="3">
                  <table width="560" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="10"><center></center></td>
                      <td width="490" style="font: bold 14px Arial, Verdana; color:#ffffff" align="left"><? echo "$titulo"; ?></td>
					   <?php if ($descuento > 0) { ?> 
						<td width="60" bgcolor="#960641" style="font: bold 14px Arial, Verdana; color:#ffffff" align="center">- <? echo "$descuento"; ?>%</td>
					   <?php } else { ?> 
						<td width="60" style="font: bold 14px Arial, Verdana; color:#ffffff" align="center"></td>
					   <?php } ?> 
                    </tr>
                  </table>
                </td>
              </tr>

              <tr>
                <td width="10"></td>
				<? if ($logo == 'W') { ?>
					<td width="210" valign="top" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="../images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" width="200" height="126" border="0" alt=""></a></td>
				<? } else if ($logo == 'S') { ?>
					<td width="210" valign="top" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="../images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" width="200" height="126" border="0" alt=""></a></td>
				<? } else if ($logo == 'C') { ?>
					 <td width="210" valign="top" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="../images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" width="200" height="126" border="0" alt=""></a></td>
				<? } else if ($logo == 'E') { ?>
					  <td width="210" valign="top" align="left"><a href="http://www.eventos3mundos.com/ofertas.php?id_new=<? echo "$id_new"; ?>"><img style="display:block;" src="../images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" width="200" height="126" border="0" alt=""></a></td>
				<? } else if ($logo == 'M') { ?>
					 <td width="210" valign="top" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="../images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" width="200" height="126" border="0" alt=""></a></td>
				<? } ?>				
                  
                <td width="340" valign="top">
                  <table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                        <td colspan="2" style="font: normal 12px Arial, Verdana; color:#ffffff" align="left" height="60"><? echo "$texto"; ?></td>
                     </tr>
                     <tr>
					<? if ($logo == 'W') { ?>
						<td width="150" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/ver-anuncio.jpg" width="150" height="36" border="0" alt="Ver anuncio"></a></td>
						<td width="190" align="right"><a href="http://www.soloviajesdelujo.com/contacto.php?&id=<?php echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/venta.jpg" width="180" height="36" border="0" alt="Ver la venta"></a></td>
					<? } else if ($logo == 'S') { ?>
						<td width="150" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/ver-anuncio.jpg" width="150" height="36" border="0" alt="Ver anuncio"></a></td>
						<td width="190" align="right"><a href="http://www.soloviajesdelujo.com/contacto.php?id=<?php echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/venta.jpg" width="180" height="36" border="0" alt="Ver la venta"></a></td>						
					<? } else if ($logo == 'C') { ?>
						 <td width="150" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/ver-anuncio.jpg" width="150" height="36" border="0" alt="Ver anuncio"></a></td>
						<td width="190" align="right"><a href="http://www.soloviajesdelujo.com/contacto.php?id=<?php echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/venta.jpg" width="180" height="36" border="0" alt="Ver la venta"></a></td>						 
					<? } else if ($logo == 'E') { ?>
						  <td width="150" align="left"><a href="http://www.eventos3mundos.com/ofertas.php?id_new=<? echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/ver-anuncio.jpg" width="150" height="36" border="0" alt="Ver anuncio"></a></td>
						<td width="190" align="right"><a href="http://www.eventos3mundos.com/empresa-organizadora-incentivos.php?destino=<?php echo "$titulo"; ?>&id_lanza=<?php echo "$id_lanza"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/venta.jpg" width="180" height="36" border="0" alt="Ver la venta"></a></td>						  
					<? } else if ($logo == 'M') { ?>
						 <td width="150" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/ver-anuncio.jpg" width="150" height="36" border="0" alt="Ver anuncio"></a></td>
						<td width="190" align="right"><a href="http://www.soloviajesdelujo.com/contacto.php?id=<?php echo "$id_lanza"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/venta.jpg" width="180" height="36" border="0" alt="Ver la venta"></a></td>						 
					<? } ?>						 
                    </tr>
                  </table>
                </td>
              </tr>

            </table>
          </td>
        </tr>
		
		<tr><td align="center">
				<font face="Verdana,Arial" style="color:#ffffff;" size="1"> </font>
			 </td>
		 </tr>
		 		
		<br>


		 
      </table>
	  <?php } }?>  
     </td>
	</tr>

			<tr><td align="center">
				<font face="Verdana,Arial" style="color:#ffffff;" size="2"> </font>
			 </td>
			 <tr><td align="center">
				<font face="Verdana,Arial" style="color:#ffffff;" size="2"> </font>
			 </td>
			</tr>

	<tr>
    <td>  
	<table width="560" border="0" align="center" cellpadding="0" cellspacing="0" >
	
    <tr>
	<? if ($logo_pie_wrld == 1) { ?>
     <td><a href="http://www.worldcruceros.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/wrld.png" style="display:block; border:0;" alt="worldcruceros.com" /></a>     </td>
     <? } if ($logo_pie_cru == 1) { ?>
      <td align="center"><a href="http://www.crucerosensuite.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/cruensuite.png"style="display:block; border:0;" alt="crucerosensuite.com" /></a>     </td>
     <? } if ($logo_pie_eve == 1) { ?>
      <td align="center"><a href="http://www.eventos3mundos.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/eventos3m.png"style="display:block; border:0;" alt="eventos3mundos.com"  /></a>     </td>
     <? } if ($logo_pie_svl == 1) { ?>
      <td align="center"><a href="http://www.soloviajesdelujo.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/svl.png"style="display:block; border:0;" alt="soloviajesdelujo" /></a>     </td>
	  <? } ?>
    </tr>

	</table>
	</td>
	</tr>
	
</table>	
</body>
</html>
