<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$id_lanzamiento_1 = filter_input(INPUT_POST, 'id_lanzamiento_1', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) ?: 0;
$id_lanzamiento_2 = filter_input(INPUT_POST, 'id_lanzamiento_2', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) ?: 0;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Para agregar una oferta</TITLE>

<script language="JavaScript" type="text/JavaScript">
	// Fonction qui permet de controler le formulaire avant de l'envoyer
	function controle()
	{
		// Test sur le champs 'form_nombre'
		if (document.formulaire.id_news.value == "0")
		{
			alert("informar la news principal !");
			document.formulaire.id_news.focus();
			return false;
		}

		if (document.formulaire.nombre.value == "")
		{
			alert("informar para quien es !");
			document.formulaire.nombre.focus();
			return false;
		}
		
		// Si tout les test sont OK, envoye du formulaire au fichier 'admin_banners_add_script.php'
		document.formulaire.submit();
	}
	function recargar()
	{
		document.formulaire.action="admin_copiarNews_add.php";
		document.formulaire.submit();
	}
</script>
</HEAD>
<body>

<table width="800px"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="3"><img src="top.jpg" width="800" height="120" ></td>
	</tr>
	<tr>
		<td valign="top" width="200">
<?php
		include("includes/menu.php");
		
		$sql_all_lanzamientos = sql_all_lanzamientos();
		$result_all_lanzamientos = execute_sql($sql_all_lanzamientos);

		if ($id_lanzamiento_2 > 0){
			$sql_all_titulos = sql_all_titulos($id_lanzamiento_2);
			$result_all_titulos = execute_sql($sql_all_titulos);
						
		}
		else { 
			$sql_all_titulos = sql_all_titulos_defecto();
			$result_all_titulos = execute_sql($sql_all_titulos);
			
		}
		
		//echo $sql_otros_titulos;
?>

		</td>
		<td align="center" width="600">
			<strong><font color="#CC0000" size="2" face="Arial, Helvetica, sans-serif">Copiar News</font></strong>
			<form name="formulaire" method="post" action="admin_copiarNews_add_script.php" onSubmit="return controle();" enctype="multipart/form-data">				
				<table width="100%" border="0" cellspacing="5" cellpadding="5" align="left">

					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Lanzamiento a copiar:</font>
							</strong>
							<br>
										<select name="id_lanzamiento_1">
<?php
											// Afficher tout les armateurs pour le choix
											while( $RS = mysqli_fetch_array($result_all_lanzamientos) )
											{
												$id_lanzamiento = $RS["id_lanzamiento"];
												$nombre = $RS["nombre"];
												
												if ($id_lanzamiento_1 == $id_lanzamiento)
												{
?>
											<option value="<?php echo "$id_lanzamiento"; ?>" selected="selected"><?php echo "$nombre"; ?></option>
<?php
												} else {
?>											
											<option value="<?php echo "$id_lanzamiento"; ?>"><?php echo "$nombre"; ?></option>
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
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Lanzamiento para copiar:</font>
							</strong>
							<br>
										<select name="id_lanzamiento_2" onchange="recargar()">
<?php
											// Afficher tout les armateurs pour le choix
											mysqli_data_seek($result_all_lanzamientos, 0);
											while( $RS = mysqli_fetch_array($result_all_lanzamientos) )
											{
												$id_lanzamiento = $RS["id_lanzamiento"];
												$nombre = $RS["nombre"];
												
												if ($id_lanzamiento_2 == $id_lanzamiento)
												{
?>
											<option value="<?php echo "$id_lanzamiento"; ?>" selected="selected"><?php echo "$nombre"; ?></option>
<?php
												} else {
?>											
											<option value="<?php echo "$id_lanzamiento"; ?>"><?php echo "$nombre"; ?></option>
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
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Titulo :</font>
							</strong>
							<br>
										<select name="id_news">
<?php
											// Afficher tout les armateurs pour le choix
											while( $RS = mysqli_fetch_array($result_all_titulos) )
											{
												$id_new = $RS["id_news"];
												$titulo = $RS["titulo"];
?>
											<option value="<?php echo "$id_new"; ?>"><?php echo "$titulo"; ?></option>
<?php
											}
?>
										</select>
									</td>
					</tr>
					
					<tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" name="Submit" value="Envoyer"></td>
				</table>
			</form>
		</td>
	</tr>
</table>

</body>
</html>
