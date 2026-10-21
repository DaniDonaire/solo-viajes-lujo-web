<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Récupération des parametres
$id = $_POST[id];


// Supprimer un bateau
$sql_delete_pais_svl = sql_delete_pais_svl($id);
execute_sql($sql_delete_pais_svl);

$message = "Destino eliminado !";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Quitar la News</TITLE>
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