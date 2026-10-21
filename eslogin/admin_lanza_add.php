<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<TITLE>Para agregar un lanzamiento</TITLE>

<script language="JavaScript" type="text/JavaScript">
	// Fonction qui permet de controler le formulaire avant de l'envoyer
	function controle()
	{
		// Test sur le champs 'form_nombre'
		if (document.formulaire.nombre.value == "")
		{
			alert("informar el nombre del nombre_banner !");
			document.formulaire.nombre.focus();
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
		<td colspan="3"><img src="top.jpg" width="800" height="120" ></td>
	</tr>
	<tr>
		<td valign="top" width="200">
<?php
		include("includes/menu.php");
?>
		</td>
		<td align="center" width="600">
			<strong><font color="#CC0000" size="2" face="Arial, Helvetica, sans-serif">Anadir lanzamiento</font></strong>
			<form name="formulaire" method="post" action="admin_lanza_add_script.php" onSubmit="return controle();" enctype="multipart/form-data">				
				<table width="100%" border="0" cellspacing="5" cellpadding="5" align="left">
															
					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Titulo :</font>
							</strong>
							<br>
							<input name="nombre" type="text" size="80">
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Texto click :</font>
							</strong>
							<br>
							<input name="texto_click" type="text" size="80" value="Click aquí si no visualiza correctamente este mensaje">
						</td>
					</tr>
					<tr>
						<td>
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Logo cabecera :</font>
							</strong>
							
							<select name="logo_cab">
								<option value="S">Soloviajesdelujo</option>
								<option value="W">Worldcruceros</option>
								<option value="C">CrucerosEnSuite</option>
								<option value="E">Eventos3mundos</option>
								<option value="M">Entre3mundos</option>
							</select>
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
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Texto cabecera :</font>
							</strong>
							<br>
							<textarea name="texto_cabecera" cols="80" rows="4">¡Solicite 3 deseos¡<br>Hacer el viaje de mis sueños.Único para mí y los míos.<br>Con la mejor relación calidad precio del mercado.<br>www.soloviajesdelujo.com<br>902106359 / 933621351 - info@soloviajesdelujo.com</textarea>
						</td>
					</tr>		
					<tr>
						<td>
							<input name="logo_pie_svl" type="checkbox">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie svl :</font>
							</strong>
						</td>
						
						<td colspan="2">
							<input name="logo_pie_wrld" type="checkbox">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie wrld  wrld :</font>
							</strong>
						</td>
					</tr>	
					<tr>
						<td>
							<input name="logo_pie_cru" type="checkbox">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie cruensuite :</font>
							</strong>
						</td>
						
						<td colspan="2">
							<input name="logo_pie_eve" type="checkbox">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">logo pie Eventos3Mundos :</font>
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
