<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Récupération des parametres
$id = $_GET[id];

// Création des requettes sql
$sql_lanza_id = sql_lanza_id($id);

// Execution des requettes Sql
$result_news = execute_sql($sql_lanza_id);

// Initialisation des variables
$RS = mysqli_fetch_array($result_news);
$id_lanza = $RS[id_lanzamiento];
$titulo = $RS[nombre];

$texto_click = $RS["texto_click"];
$logo = $RS["logo"];
$texto_cabecera = $RS["texto_cabecera"];
$logo_pie_wrld = $RS["logo_pie_wrld"];
$logo_pie_svl = $RS["logo_pie_svl"];
$logo_pie_eve = $RS["logo_pie_eve"];
$logo_pie_cru = $RS["logo_pie_cru"];
				
$sql_all_lanzamientos = sql_all_lanzamientos();
$result_all_lanzamientos = execute_sql($sql_all_lanzamientos);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Modificar el banner</TITLE>

<script language="JavaScript" type="text/JavaScript">
	// Fonction qui permet de controler le formulaire avant de l'envoyer
	function controle()
	{
		// Test sur le champs 'nombre_banner'
		if (document.formulaire.titulo.value == "")
		{
			alert("informar el nombre del banner !");
			document.formulaire.titulo.focus();
			return false;
		}

		// Si tout les test sont OK, envoye du formulaire au fichier 'admin_banners_modif_script.php'
		document.formulaire.submit();
	}

</script>

</HEAD>
<body>

<table width="800px"  border="0" cellspacing="0" cellpadding="0">
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
			<tr>
			<td colspan="3" align="center">
				<strong><font color="#CC0000" size="2" face="Arial, Helvetica, sans-serif">Modificar titulo lanzamiento</font></strong>
			</td>
			</tr>
			<form name="formulaire" method="post" action="admin_lanza_modif_script.php" onSubmit="return controle();" enctype="multipart/form-data">
				<input type="hidden" name="id_lanza" value="<? echo "$id_lanza"; ?>">
				
											
					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">titulo :</font>
							</strong>
							<br>
							<input name="titulo" type="text" size="80" value="<? echo "$titulo"; ?>">
						</td>
					</tr>	
	<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Texto click :</font>
							</strong>
							<br>
							<input name="texto_click" type="text" size="80" value="<? echo "$texto_click"; ?>">
						</td>
					</tr>
								<tr>
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Para salto de linea o linea en blanco : &lt;BR&gt; </font>
										</strong>
									</td>
								</tr>	
								<tr>
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Negrita : &lt;B&gt;texto&lt;/B&gt;</font>
										</strong>
									</td>
								</tr>	
								<tr>
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Cursiva : &lt;I&gt;texto&lt;/I&gt; </font>
										</strong>
									</td>
								</tr>	
					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Texto cabecera : </font>
							</strong>
							<br>
							<textarea name="texto_cabecera" cols="80" rows="4"><? echo "$texto_cabecera"; ?></textarea>
						</td>
					</tr>	
					
					<tr>
						<td>
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Logo cabecera :</font>
							</strong>
							
							<select name="logo">
								<option value="S" <? if ($logo == 'S') {echo'selected="selected"';} ?>>Soloviajesdelujo</option>
								<option value="W" <? if ($logo == 'W') {echo'selected="selected"';} ?>>Worldcruceros</option>
								<option value="C" <? if ($logo == 'C') {echo'selected="selected"';} ?>>CrucerosEnSuite</option>
								<option value="E" <? if ($logo == 'E') {echo'selected="selected"';} ?>>Eventos3mundos</option>
								<option value="M" <? if ($logo == 'M') {echo'selected="selected"';} ?>>Entre3mundos</option>
							</select>
							</td>	
					</tr>
	
					<tr>
						<td>
							<input name="logo_pie_svl" type="checkbox" <? if ($logo_pie_svl == 1) {echo'checked="checked"';} ?>>
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif" >logo pie svl :</font>
							</strong>
						</td>
						
						<td colspan="2">
							<input name="logo_pie_wrld" type="checkbox" <? if ($logo_pie_wrld == 1) {echo'checked="checked"';} ?>>
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie wrld  wrld :</font>
							</strong>
						</td>
					</tr>	
					<tr>
						<td>
							<input name="logo_pie_cru" type="checkbox" <? if ($logo_pie_cru == 1) {echo'checked="checked"';} ?>>
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif" >logo pie cruensuite :</font>
							</strong>
						</td>
						
						<td colspan="2">
							<input name="logo_pie_eve" type="checkbox" <? if ($logo_pie_eve == 1) {echo'checked="checked"';} ?>>
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie Eventos3Mundos :</font>
							</strong>
						</td>
					</tr>						
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="Submit" value="Envoyer"></td>
					</tr>
					
			</form>
		</table>
		</td>
	</tr>
</table>

</body>
</html>