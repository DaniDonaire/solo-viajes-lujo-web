<?php
include ("../../sql.php");
include ("../../execute_sql.php");

$id_prep = $_GET["id_prep"];

	$sql_prep_lanza = sql_prep_lanza($id_prep);
	$result_sql_prep_lanza = execute_sql($sql_prep_lanza);
	//echo $result_sql_all_news;
	while($RS = mysql_fetch_array($result_sql_prep_lanza)) {
		$para = $RS["para"];
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><title>Soloviajesdelujo.com</title>

<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-2.css?v=1323820464" />
<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-3.css?v=1322040781" />

</head>
<body bgcolor="#ffffff">

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#312b2b">

  <tr>
    <td bgcolor="#FFFFFF"><center><a style="color:#000000; font-size:20px;" href="http://www.soloviajesdelujo.com"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/logo.jpg" width="600" height="100" border="0" alt="ofertas"></a></center></td>
  </tr>

  <tr>
          <td style="font: normal 18px Arial, Verdana; color:#ffffff" align="center">¡Solicite 3 deseos¡<br>Hacer el viaje de mis sueños.Único para mí y los míos.<br>Con la mejor relación calidad precio del mercado.<br>www.soloviajesdelujo.com<br>902106359 / 933621351 - info@soloviajesdelujo.com
          </td>

  </tr>
   <br>
   <tr>
          <td style="font: normal 18px Arial, Verdana; color:#ffffff" align="left">Oferta para <? echo "$para"; ?>
          </td>

  </tr>
 
 
  <tr>
    <td>
	    <?php
	$sql_all_preps_lanza = sql_all_preps_lanza($id_prep);
	$result_sql_all_news = execute_sql($sql_all_preps_lanza);
	//echo $result_sql_all_news;
	while($RS = mysql_fetch_array($result_sql_all_news)) {
		$id_new = $RS["id_news"];
		$titulo = $RS["titulo"];
		$imagen = $RS["imagen"];
		$texto = $RS["texto"];
		$texto = preg_replace('@(\[web=([^\]]*)]([^\]]*)\[\/web\])@', '<a href="\2" class="estilolink" target="_blank">\3</a>', $texto);
		$descuento = $RS["descuento"];	
		$para = $RS["para"];		
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
                <td width="210" valign="top" align="left"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/ofertas.php?id_new=<? echo "$id_new"; ?>"><img style="display:block;" src="http://www.worldcruceros.com/<? echo "$imagen"; ?>" width="200" height="126" border="0" alt=""></a></td>
                <td width="340" valign="top">
                  <table width="340" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                        <td colspan="2" style="font: normal 12px Arial, Verdana; color:#ffffff" align="left" height="60"><? echo "$texto"; ?></td>
                     </tr>
                     <tr>
                      <td width="150" align="left"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/ofertas.php?id_new=<? echo "$id_new"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/ver-anuncio.gif" width="150" height="36" border="0" alt="Ver anuncio"></a></td>
                      <td width="190" align="right"><a href="http://www.soloviajesdelujo.com/contacto.php?destino=<?php echo "$titulo"; ?>"><img style="display:block;" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/venta.gif" width="180" height="36" border="0" alt="Ver la venta"></a></td>
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
     
      <td><a href="http://www.crucerosensuite.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/cruensuite.png"style="display:block; border:0;" alt="crucerosensuite.com" /></a>     </td>
     
      <td><a href="http://www.eventos3mundos.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/eventos3m.png"style="display:block; border:0;" alt="eventos3mundos.com"  /></a>     </td>
     
      <td><a href="http://www.soloviajesdelujo.com" target="_blank"><img src="http://soloviajesdelujo.com/newsletter/ofertas/images/svl.png"style="display:block; border:0;" alt="soloviajesdelujo" /></a>     </td>
    </tr>
	
	</table>
	</td>
	</tr>
	
</table>	
</body>
</html>
