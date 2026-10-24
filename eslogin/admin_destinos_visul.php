<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Requette pour prendre tout les armateurs
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Visualizar destinos</TITLE>
	
	<script language="JavaScript" type="text/JavaScript">
		// Fonction qui permet de controler le formulaire avant de l'envoyer
		function controle(id)
		{
			document.formulaire.id.value=id;
			var opcion = confirm("Seguro que quieres borrar destino");
			if (opcion == true) {
				document.formulaire.submit();
			} 
		}

	
	</script>
	
	
</HEAD>
<body>
<table width="800px"  border="0" cellspacing="0" cellpadding="0">
<form name="formulaire" method="post" action="admin_destinos_supp.php" enctype="multipart/form-data">
<input type="hidden" name="id" value="">
	<tr>
		<td colspan="2"><img src="top.jpg" width="800" height="120" ></td>
	</tr>
	<tr>
		<td valign="top" width="200">
<?php
		include("includes/menu.php");
		$sql_paises_svl = sql_paises_svl();
		$result_all_paises = execute_sql($sql_paises_svl);	

 ?>
 		</td>
		<td width="600">
			<table cellpadding="0" cellspacing="0" width="100%">
					
<?php

			while($RS = mysqli_fetch_array($result_all_paises))
			{
				$id_pais = $RS['id_pais'];
				$nombre_pais = $RS['nombre_pais'];

?>
				<tr>
					<td>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Destinos  :</font>
						</strong>
					</td>
				</tr>
				<tr>
					<td bgcolor="#EBEBEB" align="center" colspan="2">
						<strong>
							<font color="#000099" size="2" face="Verdana"><? echo "$nombre_pais"; ?></font>
						</strong>
					</td>
				</tr>
				<tr>														
					<td>
						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="40%">&nbsp;</td>
								<td width="30%" align="center"><a href="admin_destinos_modif.php?id=<? echo "$id_pais"; ?>">Visualizar</a></td>
								<td width="30%" align="center"><a href="javascript:controle(<? echo "$id_pais"; ?>)">Quitar</a></td>
							</tr>
						</table>
					</td>
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
	</form>
</table>
</body>
</HTML>