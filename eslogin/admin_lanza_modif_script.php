<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Récupération des parametres
$id_lanza= $_POST["id_lanza"];
$titulo = $_POST["titulo"];
$texto_click = $_POST["texto_click"];
$logo = $_POST["logo"];
$texto_cabecera = $_POST["texto_cabecera"];
$logo_pie_wrld = $_POST["logo_pie_wrld"];
$logo_pie_svl = $_POST["logo_pie_svl"];
$logo_pie_eve = $_POST["logo_pie_eve"];
$logo_pie_cru = $_POST["logo_pie_cru"];

$logo_pie_wrld = checkbox_bd($logo_pie_wrld);
$logo_pie_svl = checkbox_bd($logo_pie_svl);
$logo_pie_eve = checkbox_bd($logo_pie_eve);
$logo_pie_cru = checkbox_bd($logo_pie_cru);

// Taitement pour les Descripcions
//$form_descripcion = string_bd ($form_descripcion);
$texto = string_bd ($texto);

$sql_update_lanza = sql_update_lanza($id_lanza, $titulo,$texto_click,$logo,$texto_cabecera,$logo_pie_wrld,$logo_pie_svl,$logo_pie_eve,$logo_pie_cru);

// Insert a la base de donnée
execute_sql($sql_update_lanza);

$message = "Modificado el lanzamiento !";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Modificado lanzamiento</TITLE>
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
			<?php echo $message; ?>
		</td>
	</tr>
</table>
</body>
</HTML>