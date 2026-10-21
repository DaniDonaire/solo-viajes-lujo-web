<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$id_destino_selec = $_POST["id_destino"];
/*
if ($id_destino_selec == '' || $id_destino_selec == ' '){
	$sql_last_lanzamiento = sql_last_lanzamiento();
	$last_lanzamiento = execute_sql($sql_last_lanzamiento);
	$RS = mysqli_fetch_array($last_lanzamiento);
	$id_destino_selec = $RS[max_id_lanzamiento];

}*/
// Requette pour prendre tout les armateurs
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Visualizar las especialidades</TITLE>

</HEAD>
<body>
<table width="800px"  border="0" cellspacing="0" cellpadding="0">
<form name="formulaire" method="post" action="admin_especialidad_visul.php" enctype="multipart/form-data">
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
			
					<tr>
						<td bgcolor="#EBEBEB" align="left">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Destino : </font>
							</strong>
				
							<select name="id_destino" onchange="document.formulaire.submit()">
<?php
											// Afficher tout les armateurs pour le choix
											while( $RS = mysqli_fetch_array($result_all_paises) )
											{
												$id_pais = $RS[id_pais];
												$nombre_pais = $RS[nombre_pais];
												
												if ($id_destino_selec == $id_pais)
												{
?>
											<option value="<?php echo "$id_pais"; ?>" selected="selected"> <?php echo "$nombre_pais"; ?> </option>
<?php
												} else {
?>
											<option value="<?php echo "$id_pais"; ?>"> <?php echo "$nombre_pais"; ?> </option>
<?php
												}
											}
?>
							</select>
						</td>

					</tr>
					
<?php
		if ($id_destino != '' || $id_destino != ' ') {
			$sql_destinos = sql_destinos($id_destino_selec);
			$resul_sql_destinos = execute_sql($sql_destinos);
			while($RS = mysqli_fetch_array($resul_sql_destinos))
			{
				$id_destino = $RS[id_destino];
				$destino = $RS[destino];

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
							<font color="#000099" size="2" face="Verdana"><? echo "$destino"; ?></font>
						</strong>
					</td>
				</tr>
				<tr>														
					<td>
						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="40%">&nbsp;</td>
								<td width="30%" align="center"><a href="admin_especialidad_modif.php?id=<? echo "$id_destino"; ?>">Visualizar</a></td>
								<td width="30%" align="center"><a href="admin_especialidad_supp.php?id=<? echo "$id_destino"; ?>" onclick="if (! confirm('Seguro que quieres borrar especialidad?')) return false;">Quitar</a></td>
								
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
<?php
			}
		}
?>
			</table>
		</td>
	</tr>
	</form>
</table>
</body>
</HTML>