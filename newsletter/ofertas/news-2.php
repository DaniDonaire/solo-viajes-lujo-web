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
<center><font face="Verdana,Arial" size="1"><a style="color: #000;" href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-2.php?id_lanza=<? echo "$id_lanza"; ?>">Clic aquí si no visualiza correctamente este mensaje</a></font></center>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#312b2b">

  <tr>
    <td bgcolor="#FFFFFF"><center><a style="color:#000000; font-size:20px;" href="http://www.soloviajesdelujo.com"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/logo.jpg" width="600" height="100" border="0" alt="ofertas"></a></center></td>
  </tr>

  <tr>
          <td style="font: normal 18px Arial, Verdana; color:#ffffff" align="center">¡Solicite 3 deseos¡<br>Hacer el viaje de mis sueños.Único para mí y los míos.<br>Con la mejor relación calidad precio del mercado.<br>www.soloviajesdelujo.com<br>902106359 / 933621351 - info@soloviajesdelujo.com
          </td>

  </tr>
 
 
 
  <tr>
    <td>
	    <?php
	$sql_all_news_lanza = sql_all_news_lanza($id_lanza);
	$result_sql_all_news = execute_sql($sql_all_news_lanza);
	//echo $sql_all_news_lanza;
	while($RS = mysqli_fetch_array($result_sql_all_news)) {
		$id_new = $RS["id_news"];
		$titulo = $RS["titulo"];
		$imagen = $RS["imagen"];
		$texto = $RS["texto"];
		$texto = preg_replace('@(\[web=([^\]]*)]([^\]]*)\[\/web\])@', '<a href="\2" class="estilolink" target="_blank">\3</a>', $texto);
		$descuento = $RS["descuento"];	
		$destino = $RS["destino"];			
		$id_lanzamiento_imagen = $RS["id_lanzamiento_imagen"];		
		$nombre_pagina_destino = $RS["nombre_pagina_destino"];
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
                <td width="210" valign="top" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$nombre_pagina_destino"; ?>/viaje-<? echo "$nombre_pagina_destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="../images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" width="200" height="126" border="0" alt=""></a></td>
                <td width="340" valign="top">
                  <table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                        <td colspan="2" style="font: normal 12px Arial, Verdana; color:#ffffff" align="left" height="60"><? echo "$texto"; ?></td>
                     </tr>
                     <tr>
                      <td width="150" align="left"><a href="https://www.soloviajesdelujo.com/viajes/<? echo "$nombre_pagina_destino"; ?>/viaje-<? echo "$nombre_pagina_destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/ver-anuncio.jpg" width="150" height="36" border="0" alt="Ver anuncio"></a></td>
                      <td width="190" align="right"><a href="http://www.soloviajesdelujo.com/contacto.php?id=<?php echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/venta.jpg" width="180" height="36" border="0" alt="Ver la venta"></a></td>
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
	  <?php }?>  
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
     <td><a href="http://www.worldcruceros.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/wrld.png" style="display:block; border:0;" alt="worldcruceros.com" /></a>     </td>
     
      <td align="center"><a href="http://www.crucerosensuite.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/cruensuite.png"style="display:block; border:0;" alt="crucerosensuite.com" /></a>     </td>
     
      <td align="center"><a href="http://www.eventos3mundos.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/eventos3m.png"style="display:block; border:0;" alt="eventos3mundos.com"  /></a>     </td>
     
      <td align="center"><a href="http://www.soloviajesdelujo.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/svl.png"style="display:block; border:0;" alt="soloviajesdelujo" /></a>     </td>
    </tr>
	
	</table>
	</td>
	</tr>
	
</table>	
</body>
</html>
