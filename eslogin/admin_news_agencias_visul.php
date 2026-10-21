<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$id_lanzamiento_selec = $_POST["id_lanzamiento"];
//echo 'a : '.$id_lanzamiento_selec;
if ($id_lanzamiento_selec == '' || $id_lanzamiento_selec == ' '){
	//echo 'b : ';
	$sql_last_lanzamiento = sql_last_lanzamiento();
	//echo $sql_last_lanzamiento;
	$last_lanzamiento = execute_sql($sql_last_lanzamiento);
	$RS = mysqli_fetch_array($last_lanzamiento);
	$id_lanzamiento_selec = $RS[max_id_lanzamiento];
	//echo 'c : '.$id_lanzamiento_selec;
}
// Requette pour prendre tout les armateurs
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Visualizar las news</TITLE>
</HEAD>
<body>
<table width="800px"  border="0" cellspacing="0" cellpadding="0">
<form name="formulaire" method="post" action="admin_news_visul.php" enctype="multipart/form-data">
	<tr>
		<td colspan="2"><img src="top.jpg" width="800" height="120" ></td>
	</tr>
	<tr>
		<td valign="top" width="200">
<?php
		include("includes/menu.php");
		$sql_all_lanzamientos = sql_all_lanzamientos();
		$result_all_lanzamientos = execute_sql($sql_all_lanzamientos);	

 ?>
 		</td>
		<td width="600">
			<table cellpadding="0" cellspacing="0" width="100%">
			
					<tr>
						<td bgcolor="#EBEBEB" align="left">
							<strong>
								<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Lanzamiento : </font>
							</strong>
				
							<select name="id_lanzamiento" onchange="document.formulaire.submit()">
<?php
											// Afficher tout les armateurs pour le choix
											while( $RS = mysqli_fetch_array($result_all_lanzamientos) )
											{
												$id_lanzamiento = $RS["id_lanzamiento"];
												$nombre = $RS["nombre"];
												
												if ($id_lanzamiento_selec == $id_lanzamiento)
												{
?>
											<option value="<?php echo "$id_lanzamiento"; ?>" selected="selected"> <?php echo "$nombre"; ?> </option>
<?php
												} else {
?>
											<option value="<?php echo "$id_lanzamiento"; ?>"> <?php echo "$nombre"; ?> </option>
<?php
												}
											}
?>
							</select>
						</td>

					</tr>
					
<?php
		if ($id_lanzamiento != '' || $id_lanzamiento != ' ') {
			$sql_all_news = sql_all_news_lanza($id_lanzamiento_selec);
			$resul_all_news = execute_sql($sql_all_news);
			//echo $sql_all_news;
			while($RS = mysqli_fetch_array($resul_all_news))
			{
				$id_new = $RS["id_news"];
				$titulo = $RS["titulo"];
				$imagen = $RS["imagen"];
				$texto = $RS["texto"];
				$textoAmp = $RS["textoAmp"];
				$orden = $RS["orden"];
				$visible = $RS["visible"];
				$descuento = $RS["descuento"];
				$esbanner = $RS["esbanner"];
				$esbanner_eventos = $RS["esbanner_eventos"];
				$nombre_pais = $RS["nombre_pais"];
				// Traitement sur la description, Si la chaine de caractere est trop longue, on la coupe et on ajoute '...'
				if (strlen($texto) > 300)
				{
					$texto = substr($texto, 0, 300) . ' ...';
				}
?>

				<tr>
					<td bgcolor="#EBEBEB" align="center" colspan="2">
						<strong>
							<font color="#000099" size="2" face="Verdana"><? echo "$titulo"; ?></font>
						</strong>
					</td>
				</tr>
								
				<tr>
					<td>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Imagen : <? echo "$imagen"; ?></font>
						</strong>
					</td>
				</tr>

				<tr>
					<td>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">texto  :</font>
						</strong>
					</td>
				</tr>
				<tr>
					<td><? echo "$texto"; ?></td>
				</tr>	

				<tr>
					<td>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">texto Ampliado:</font>
						</strong>
					</td>
				</tr>
				<tr>
					<td><? echo "$textoAmp"; ?></td>
				</tr>	
				
				</tr>					
							<td colspan="2">
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">orden : <? echo "$orden"; ?></font>
							</strong>
							</td>
				</tr>

				
				</tr>					
						<td >
						<strong>
						<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Visible : <? echo "$visible"; ?></font>
						</strong>
						</td>

				</tr>
					
				</tr>					
						<td colspan="2">
						<strong>
						<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">descuento : <? echo "$descuento"; ?></font>
						</strong>
						</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<input name="esbanner" type="checkbox" <? if ($esbanner == 1) {echo'checked="checked"';} ?> disabled>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Es banner</font>
						</strong>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="esbanner_eventos" type="checkbox" <? if ($esbanner_eventos == 1) {echo'checked="checked"';} ?> disabled>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Es banner eventos</font>
						</strong>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Pais Especializacion : <? echo "$nombre_pais"; ?></font>
						</strong>
						<br>
					</td>
		
				</tr>
					
				</tr>		
										
					<td>
						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="40%">&nbsp;</td>
								<td width="30%" align="center"><a href="admin_news_modif.php?id=<? echo "$id_new"; ?>">Visualizar</a></td>
								<td width="30%" align="center"><a href="admin_news_supp.php?id=<? echo "$id_new"; ?>">Quitar</a></td>
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