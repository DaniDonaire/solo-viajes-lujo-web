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
$sql_destino_id = sql_destino_id($id);

// Execution des requettes Sql
$result_destino = execute_sql($sql_destino_id);

// Initialisation des variables
if (!($result_destino instanceof mysqli_result)) {
	http_response_code(404);
	exit('Registro no encontrado.');
}
$RS = mysqli_fetch_array($result_destino);
if (!$RS) {
	http_response_code(404);
	exit('Registro no encontrado.');
}


$id_pais = $RS['id_pais'];
$nombre_pais = $RS['nombre_pais'];
$imagen = $RS['imagen_pais'];
$activo = $RS['activo'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Modificar el banner</TITLE>

		<link rel="stylesheet" type="text/css" href="jquery/css/smoothness/jquery-ui-1.9.0.custom.css" />
	<link rel="stylesheet" type="text/css" href="jquery/css/smoothness/jquery-ui-1.9.0.custom.min.css" />
	<script src="jquery/js/jquery-1.8.2.js" type="text/javascript"></script>
	<script src="jquery/js/jquery-ui-1.9.0.custom.min.js" type="text/javascript"></script>
	<script src="jquery/js/jquery-ui-1.9.0.custom.js" type="text/javascript"></script>
	
<script language="JavaScript" type="text/JavaScript">
	// Fonction qui permet de controler le formulaire avant de l'envoyer
	function controle()
	{
		// Test sur le champs 'form_nombre'
		if (document.formulaire.nombre_destino.value == "")
		{
			alert("informar el nombre del destino !");
			document.formulaire.nombre_destino.focus();
			return false;
		}
		// Si tout les test sont OK, envoye du formulaire au fichier 'admin_banners_add_script.php'
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
			<strong><font color="#CC0000" size="2" face="Arial, Helvetica, sans-serif">Modificar Destino</font></strong>
			<form name="formulaire" method="post" action="admin_destinos_modif_script.php" onSubmit="return controle();" enctype="multipart/form-data">
				<input type="hidden" name="id_pais" value="<? echo "$id_pais"; ?>">
				<input type="hidden" name="imagen_ant" value="<? echo "$imagen"; ?>">
				<table width="100%" border="0" cellspacing="5" cellpadding="5" align="left">
				
					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Nombre Destino (EN MINUSCULAS) :</font>
							</strong>
							<br>
							<input name="nombre_destino" type="text" size="80" value="<? echo "$nombre_pais"; ?>">
						</td>
					</tr>
					
					<tr>
						<td>
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">imagen (800x533 o parecido) : <? echo "$imagen"; ?></font>
							</strong>
							<br>
							<input name="imagen" type="file" size="80" maxlength="50">
						</td>
						
						<td colspan="2">
			
							<!--font color="#000099" size="2" face="Arial, Helvetica, sans-serif">imagen actual: <? echo "$imagen"; ?></font-->
							<img src="../destinos/img/<? echo "$imagen"; ?>" >
				
							<br>
							
						</td>
						
      				</tr>
					
					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Activo : </font>
							</strong>
							
							<input name="activo" type="checkbox" <? if ($activo == 1) {echo'checked="checked"';} ?>>

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