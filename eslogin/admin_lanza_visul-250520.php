<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Requette pour prendre tout les armateurs
$sql_all_lanzamientos = sql_all_lanzamientos();
$resul_all_lanzamientos = execute_sql($sql_all_lanzamientos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Visualizar el banner</TITLE>
</HEAD>
<body>
<table width="1000px"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2"><img src="top.jpg" width="800" height="120" ></td>
	</tr>
	<tr>
		<td valign="top" width="200">
<?php
		include("includes/menu.php");
 ?>
 		</td>
		<td width="600">
			<table cellpadding="0" cellspacing="0" width="100%">
<?php

			while($RS = mysqli_fetch_array($resul_all_lanzamientos))
			{
				$nombre = $RS["nombre"];
				$id_lanzamiento = $RS["id_lanzamiento"];
				
				$texto_click = $RS["texto_click"];
				$logo = $RS["logo"];
				$texto_cabecera = $RS["texto_cabecera"];
				$logo_pie_wrld = $RS["logo_pie_wrld"];
				$logo_pie_svl = $RS["logo_pie_svl"];
				$logo_pie_eve = $RS["logo_pie_eve"];
				$logo_pie_cru = $RS["logo_pie_cru"];

?>

				<tr>
					<td bgcolor="#EBEBEB" align="center" colspan="2">
						<strong>
							<font color="#000099" size="2" face="Verdana"><? echo "$nombre"; ?></font>
						</strong>
					</td>
				</tr>
				
				<tr>
					<td width="20%">
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Texto click : </font>
						</strong>
					</td>
					<td width="80%"><? echo "$texto_click"; ?></font>
					</td>
				</tr>
								<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="20%">
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Texto cabecera : </font>
						</strong>
					</td>
					<td width="80%"> <? echo "$texto_cabecera"; ?></td>					
				</tr>
								<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>
						<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Logo cabecera :</font>
						</strong>
						
						<select name="logo_cab">
							<option value="S" <? if ($logo == 'S') {echo'selected="selected"';} ?>>Soloviajesdelujo</option>
							<option value="W" <? if ($logo == 'W') {echo'selected="selected"';} ?>>Worldcruceros</option>
							<option value="C" <? if ($logo == 'C') {echo'selected="selected"';} ?>>CrucerosEnSuite</option>
							<option value="E" <? if ($logo == 'E') {echo'selected="selected"';} ?>>Eventos3mundos</option>
							<option value="M" <? if ($logo == 'M') {echo'selected="selected"';} ?>>Entre3mundos</option>
						</select>
						</td>	
				</tr>
	
				<tr>
					<td width="30%">
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie svl :</font>
							<input name="esbanner" type="checkbox" <? if ($logo_pie_svl == 1) {echo'checked="checked"';} ?> disabled>
						</strong>
					</td>
					
					<td width="70%">
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie wrld  wrld :</font>
							<input name="esbanner" type="checkbox" <? if ($logo_pie_wrld == 1) {echo'checked="checked"';} ?> disabled>
						</strong>
					</td>
				</tr>	
				<tr>
					<td width="30%">
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie cruensuite :</font>
							<input name="esbanner" type="checkbox" <? if ($logo_pie_cru == 1) {echo'checked="checked"';} ?> disabled>
						</strong>
					</td>
					
					<td width="70%">
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie Eventos3Mundos :</font>
							<input name="esbanner" type="checkbox" <? if ($logo_pie_eve == 1) {echo'checked="checked"';} ?> disabled>
						</strong>
					</td>
				</tr>	
				
				<tr>
					<td>&nbsp;</td>
				</tr>
				
				<tr>								
								
					<td width="30%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-1.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo 1</a></td>
					<td width="70%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-2.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo 2</a></td>
				
				</tr>
					
				<tr>								
								
					<td width="30%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-agencias.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo Agencias</a></td>	
					<td width="70%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-agencias.php?id_lanza=<? echo "$id_lanzamiento"; ?>&idioma=ca" target="_blank">Ver modelo Agencias Catala</a></td>						
				</tr>	
				
				<tr>								
								
					<td width="30%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-incentivos.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo Agencias Incentivos</a></td>	
					<td width="70%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-agencias-2.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo Agencias nuevo</a></td>						
				</tr>	
				
				<tr>								
								
					<td width="30%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-agencias-3-all.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo Agencias nuevo con todos los viajes</a></td>	
					<td width="70%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-agencias-3.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo Agencias nuevo con 3 viajes</a></td>						
				</tr>	
				
				
				<tr>						

					<td width="30%"><a href="admin_lanza_modif.php?id=<? echo "$id_lanzamiento"; ?>">Visualizar</a></td>
					<td width="70%"><a href="admin_lanza_supp.php?id=<? echo "$id_lanzamiento"; ?>">Quitar</a></td>
					
				</tr>
				
				<tr>
					<td width="30%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-11.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo NUEVO 1</a></td>
					<td width="70%"><a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-22.php?id_lanza=<? echo "$id_lanzamiento"; ?>" target="_blank">Ver modelo NUEVO 2</a></td>
				</tr>
				
				<tr>
					<td>&nbsp;</td>
				</tr>
<?php
			}
?>
			</table>
		</td>
	</tr>
</table>
</body>
</HTML>