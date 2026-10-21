<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');
// Récupération des parametres
$id_lanzamiento_1 = $_POST["id_lanzamiento_1"];
$id_news = $_POST["id_news"];	
	
// Création de la requette
$sql_insert_copiarNews = sql_insert_copiarNews($id_lanzamiento_1,$id_news);
// Insert a la base de donnée
$resul=execute_sql($sql_insert_copiarNews);

//echo $sql_insert_prepNews;

$message = "News copiada!";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Copiada News</TITLE>
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