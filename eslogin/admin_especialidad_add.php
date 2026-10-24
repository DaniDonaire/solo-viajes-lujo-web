<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$sql_all_paises = sql_paises_svl();
$result_all_paises = execute_sql($sql_all_paises);	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Para agregar una oferta</TITLE>

	<link rel="stylesheet" type="text/css" href="jquery/css/smoothness/jquery-ui-1.9.0.custom.css" />
	<link rel="stylesheet" type="text/css" href="jquery/css/smoothness/jquery-ui-1.9.0.custom.min.css" />
	<script src="jquery/js/jquery-1.8.2.js" type="text/javascript"></script>
	<script src="jquery/js/jquery-ui-1.9.0.custom.min.js" type="text/javascript"></script>
	<script src="jquery/js/jquery-ui-1.9.0.custom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
	// Fonction qui permet de controler le formulaire avant de l'envoyer
	function controle()
	{
		
		if (document.formulaire.nombre_especialidad.value == "")
		{
			alert("informar el nombre del especialidad !");
			document.formulaire.nombre_especialidad.focus();
			return false;
		}
		if (document.formulaire.id_pais.value == "")
		{
			alert("informar el nombre del pais !");
			document.formulaire.id_pais.focus();
			return false;
		}		
		else {
		  existe = buscarEspecialidad();
		  if (existe){
			alert("Especialidad ya existe!");
			return false;
		  }
		  else {
			document.formulaire.submit();
		  }
		}	
	}

	function buscarEspecialidad(){
		var especialidad = document.formulaire.nombre_especialidad.value;
		var retorno=false;
		if(especialidad != '0')
		{
			$.ajax({
				async:false,
				data: { nombre_especialidad : especialidad },
				url:   'especialidades.php',
				type:  'POST',
				dataType: 'json',
				success:  function (r) 
				{
					$(r).each(function(i, v){ // indice, valor
						if (especialidad == v.destino){
							retorno=true;
						}
					})
				},
				error: function()
				{
					alert('Ocurrio un error en el servidor .. intentalo de nuevo');
					retorno=true;
				}
			});
		}
		return retorno;
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
<?php include("includes/menu.php"); ?>
		</td>
		<td align="center" width="600">
			<strong><font color="#CC0000" size="2" face="Arial, Helvetica, sans-serif">Anadir Especialidad</font></strong>
			<form name="formulaire" method="post" action="admin_especialidad_add_script.php" onSubmit="return controle();" enctype="multipart/form-data">				
				<table width="100%" border="0" cellspacing="5" cellpadding="5" align="left">
															
					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Nombre Especialidad :</font>
							</strong>
							<br>
							<input name="nombre_especialidad" type="text" size="80">
						</td>
					</tr>
					<tr>
						<td >
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Pais Especializacion:</font>
							</strong>
							<br>
							<select name="id_pais" onchange="buscarDestinos()">
<?php
								// Afficher tout les armateurs pour le choix
								while( $RS = mysqli_fetch_array($result_all_paises) )
								{
									$id_pais = $RS["id_pais"];
									$nombre_pais = $RS["nombre_pais"];
?>
								<option value="<?php echo "$id_pais"; ?>"><?php echo "$nombre_pais"; ?></option>
<?php
								}
?>
							</select>
						</td>
					</tr>				
					<tr>
						<td colspan="3">
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Imagen (800 x 533 o parecido):</font>
							</strong>
							<br>
							<input name="imagen" type="file" size="120" maxlength="50">
						</td>
      				</tr>
					
					<tr>
						<td colspan="3">
							<input name="activo" type="checkbox">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Activo : </font>
							</strong>
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
