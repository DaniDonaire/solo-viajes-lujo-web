<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Récupération des parametres
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
if ($id === null || $id === false) {
	http_response_code(404);
	exit('Registro no encontrado.');
}


// Création des requettes sql
$sql_news_id = sql_news_id($id);

// Execution des requettes Sql
$result_news = execute_sql($sql_news_id);

// Initialisation des variables
if (!($result_news instanceof mysqli_result)) {
	http_response_code(404);
	exit('Registro no encontrado.');
}
$RS = mysqli_fetch_array($result_news);
if (!$RS) {
	http_response_code(404);
	exit('Registro no encontrado.');
}


$id_new = $RS['id_news'];
$titulo = $RS['titulo'];
$id_lanzamiento = $RS['id_lanzamiento'];
$imagen = $RS['imagen'];
$texto = $RS['texto'];
$textoAmp = $RS['textoAmp'];
$orden = $RS['orden'];
$visible = $RS['visible'];
$descuento = $RS['descuento'];
$esbanner = $RS['esbanner'];
$esbanner_eventos = $RS['esbanner_eventos'];
$id_pais_espe = $RS['id_pais_espe'];

$sql_all_lanzamientos = sql_all_lanzamientos();
$result_all_lanzamientos = execute_sql($sql_all_lanzamientos);

$sql_all_paises = sql_all_paises();
$result_all_paises = execute_sql($sql_all_paises);		
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


		if (document.formulaire.imagen.value == "" && document.formulaire.imagen_ant.value == ""))
		{
	  		alert("informar imagen !");
			document.formulaire.imagen.focus();
			return false;
		}
		// Test sur le champs 'texto'
		if (document.formulaire.texto.value == "" )
		{
			alert("informar el descipcion del texto !");
			document.formulaire.texto.focus();
			return false;
		}
		// Test sur le champs 'texto'
		if (document.formulaire.orden.value == "" )
		{
			alert("informar el descipcion del orden !");
			document.formulaire.orden.focus();
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
		<td align="center" width="600">
			<strong><font color="#CC0000" size="2" face="Arial, Helvetica, sans-serif">Modificar la oferta</font></strong>
			<form name="formulaire" method="post" action="admin_news_modif_script.php" onSubmit="return controle();" enctype="multipart/form-data">
				<input type="hidden" name="form_id_new" value="<? echo "$id_new"; ?>">
				<input type="hidden" name="imagen_ant" value="<? echo "$imagen"; ?>">
				<table width="100%" border="0" cellspacing="5" cellpadding="5" align="left">
				
					
						<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Lanzamiento :</font>
							</strong>
							<br>
							<select name="id_lanzamiento">
<?php
											// Afficher tout les armateurs pour le choix
											while( $RS = mysqli_fetch_array($result_all_lanzamientos) )
											{
												$id_lanza = $RS["id_lanzamiento"];
												$nombre = $RS["nombre"];

												if ($id_lanza == $id_lanzamiento)
												{
?>
											<option value="<?php echo "$id_lanza"; ?>" selected="selected"><?php echo "$nombre"; ?></option>
<?php
												} else {
?>
											<option value="<?php echo "$id_lanza"; ?>"><?php echo "$nombre"; ?></option>
<?php
												}
											}
?>
										</select>
						</td>
						</tr>										
					
					
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
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">imagen : <? echo "$imagen"; ?></font>
							</strong>
							<br>
							<input name="imagen" type="file" size="80" maxlength="50">
						</td>
      				</tr>
					
					<tr>
						<td colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">texto :</font>
										</strong>
									</td>
								</tr>
								<tr>
									<td>
										<textarea name="texto" cols="60" rows="10"><? echo "$texto"; ?></textarea>
									</td>
								</tr>
							</table>
						</td>
					</tr>	

					<tr>
						<td colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Para link [web=http://www.google.es]GooGLe[/web] :</font>
										</strong>
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
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Negrita : &lt;B&gt; texto&lt;/B&gt;</font>
										</strong>
									</td>
								</tr>	
								<tr>
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Cursiva : &lt;I&gt; texto&lt;/I&gt;</font>
										</strong>
									</td>
								</tr>									
								<tr>
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">texto Ampliado:</font>
										</strong>
									</td>
								</tr>
								<tr>
									<td>
										<textarea name="textoAmp" cols="60" rows="10"><? echo "$textoAmp"; ?></textarea>
									</td>
								</tr>
							</table>
						</td>
					</tr>	
					
					<tr>		
						<td>
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">orden :</font>
							</strong>
							<br>
							<input name="orden" type="text" size="2" maxlength="2" value="<? echo "$orden"; ?>">
						</td>
						
						<td>
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">visible :</font>
							</strong>
							
							<select name="visible">
								<?php if ($visible == 'S') {?>
									<option value="S" selected="selected">Si</option>
									<option value="N">No</option>
								<?php	} else { ?>
									<option value="S" >Si</option>
									<option value="N" selected="selected">No</option>
								<?php	} ?>																
							</select>
						</td>
						
						<td >
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">descuento :</font>
							</strong>
							<br>
							<input name="descuento" type="text" size="2" maxlength="2" value="<? echo "$descuento"; ?>">
						</td>								
						
      				</tr>		
				
					<tr>
						<td>
							<input name="esbanner" type="checkbox" <? if ($esbanner == 1) {echo'checked="checked"';} ?>>
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Es banner :</font>
							</strong>
						</td>
						<td colspan="2">
							<input name="esbanner_eventos" type="checkbox" <? if ($esbanner_eventos == 1) {echo'checked="checked"';} ?>>
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Es banner Eventos3Mundos :</font>
							</strong>
						</td>
					</tr>

					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Pais Especializacion:</font>
							</strong>
							<br>
										<select name="id_pais">
<?php
											// Afficher tout les armateurs pour le choix
											while( $RS = mysqli_fetch_array($result_all_paises) )
											{
												$id_pais = $RS["id_pais"];
												$nombre_pais = $RS["nombre_pais"];
												
												if ($id_pais_espe == $id_pais)
												{
?>
											<option value="<?php echo "$id_pais"; ?>" selected="selected"><?php echo "$nombre_pais"; ?></option>
<?php
												} else {
?>
											<option value="<?php echo "$id_pais"; ?>"><?php echo "$nombre_pais"; ?></option>
<?php
												}												
											}
?>
										</select>
									</td>
					</tr>
					
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="Submit" value="Envoyer"></td>
					</tr>
					
				</table>
			</form>
		</td>
	</tr>
</table>

</body>
</html>