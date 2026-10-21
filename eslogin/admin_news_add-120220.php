<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');
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
		// Test sur le champs 'form_nombre'
		if (document.formulaire.titulo.value == "")
		{
			alert("informar el nombre del nombre_banner !");
			document.formulaire.titulo.focus();
			return false;
		}
		// Test sur le champs 'form_descripcion_pequena'
		// Test sur le champs 'form_nombre'
		if (document.formulaire.imagen.value == "")
		{
			alert("informar el nombre de la imagen !");
			document.formulaire.imagen.focus();
			return false;
		}

		// Test sur le champs 'form_descipcion'
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

		if (document.formulaire.id_pais.value == "0" )
		{
			alert("informar el pais !");
			document.formulaire.id_pais.focus();
			return false;
		}
		
		if (document.formulaire.destinos.value == "" || document.formulaire.destinos.value == "0")
		{
			alert("informar el destino !");
			document.formulaire.destinos.focus();
			return false;
		}
		// Si tout les test sont OK, envoye du formulaire au fichier 'admin_banners_add_script.php'
		document.formulaire.submit();
	}

	function buscarDestinos(){
	
		var destinos = $("#destinos");
		destinos.find('option').remove();
		var pais = document.formulaire.id_pais.value;
		if(pais != '0')
		{
			$.ajax({
				data: { id_pais : pais },
				url:   'destinos.php',
				type:  'POST',
				dataType: 'json',

				success:  function (r) 
				{
				   
					$(r).each(function(i, v){ // indice, valor
						destinos.append('<option value="' + v.id_destino + '">' + v.destino + '</option>');
					})
					//destinos.prop('disabled', false);
				},
				error: function()
				{
					alert('Ocurrio un error en el servidor ..');
				}
			});
		}
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
		
		$sql_all_paises = sql_all_paises();
		$result_all_paises = execute_sql($sql_all_paises);		
?>

		</td>
		<td align="center" width="600">
			<strong><font color="#CC0000" size="2" face="Arial, Helvetica, sans-serif">Anadir oferta</font></strong>
			<form name="formulaire" method="post" action="admin_news_add_script.php" onSubmit="return controle();" enctype="multipart/form-data">				
				<table width="100%" border="0" cellspacing="5" cellpadding="5" align="left">
										
					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Lanzamiento:</font>
							</strong>
							<br>
										<select name="id_lanzamiento">
<?php
											// Afficher tout les armateurs pour le choix
											while( $RS = mysqli_fetch_array($result_all_lanzamientos) )
											{
												$id_lanzamiento = $RS["id_lanzamiento"];
												$nombre = $RS["nombre"];
?>
											<option value="<?php echo "$id_lanzamiento"; ?>"><?php echo "$nombre"; ?></option>
<?php
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
							<input name="titulo" type="text" size="80">
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Imagen :</font>
							</strong>
							<br>
							<input name="imagen" type="file" size="120" maxlength="50">
						</td>
      				</tr>
				
					<tr>
						<td colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Texto(mail) :</font>
										</strong>
									</td>
								</tr>
								<tr>
									<td><textarea name="texto" cols="60" rows="5"></textarea></td>
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
									<td>
										<strong>
											<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Texto Ampliado(web) :</font>
										</strong>
									</td>
								</tr>
								<tr>
									<td><textarea name="textoAmp" cols="60" rows="5"></textarea></td>
								</tr>
							</table>
						</td>
					</tr>
					
					</tr>					
						<td >
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">orden :</font>
							</strong>
							<br>
							<input name="orden" type="text" size="2" maxlength="2" value="<? echo "$orden"; ?>">
						</td>
						
						<td>
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Visible :</font>
							</strong>
							
							<select name="visible">
								<option value="S">Si</option>
								<option value="N">No</option>
							</select>
						</td>
					
						
						<td>
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Descuento :</font>
							</strong>

							<br>
								<input name="descuento" type="text" size="2" maxlength="2" value="<? echo "$descuento"; ?>">
      				</tr>	
					
					<tr>
						<td>
							<input name="esbanner" type="checkbox">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Es banner :</font>
							</strong>
						</td>
						
						<td colspan="2">
							<input name="esbanner_eventos" type="checkbox">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Es banner Eventos3Mundos :</font>
							</strong>
						</td>
						
					</tr>
					
					<tr>
						<td >
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Destino :</font>
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
						<td colspan="2">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Especializacion :</font>
							</strong>
							<br>
										<select id="destinos" name="destinos" ></select>
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
