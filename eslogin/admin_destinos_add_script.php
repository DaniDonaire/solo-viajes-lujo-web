<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$message ='Init';

// Récupération des parametres
$nombre_destino = $_POST["nombre_destino"];
$pagina_destino = $_POST["nombre_destino"];

//$pagina_destino = preg_replace("/[^a-zA-Z0-9\_\-]+/", "", $pagina_destino);
//$imagen = $_POST["imagen"];
//$imagenDestino = $_POST["nombre_destino"].".jpg";
$imagenDestino = $pagina_destino.".jpg";
$activo = $_POST["activo"];
$activo = checkbox_bd($activo);

setlocale(LC_CTYPE, 'es_ES');
//$charset='ISO-8859-1'; // o 'UTF-8'
$charset='UTF-8'; // o 'UTF-8'
$pagina_destino = iconv($charset, 'ASCII//TRANSLIT', $pagina_destino);

$pagina_destino = str_replace(' ','-',$pagina_destino);

//$imagenDestino = str_replace(' ','-',$imagenDestino);
$imagenDestino = $pagina_destino.".jpg";

// Création de la requette
$sql_insert_destino = sql_insert_destino($nombre_destino ,$pagina_destino, $imagenDestino, $activo);
execute_sql($sql_insert_destino);

$fileTmpPath = $_FILES['imagen']['tmp_name'];
$uploadFileDir = '../destinos/img/';
$dest_path = $uploadFileDir . $pagina_destino . '.jpg';
 
if(move_uploaded_file($fileTmpPath, $dest_path))
{
  $message ='Destino añadido e Imagen subida';
}
else
{
  $message = 'Destino añadido NO se ha podido subir la Imagen ';
}

// crear directorio y pagina
$directorioDestino = "../destinos/".$pagina_destino;
if(!is_dir($directorioDestino)) {
	try {
		mkdir($directorioDestino,0777);

		$fitxerCopiar="../destinos/Africa/destinos-Africa.php";
		$fitxerNew=$directorioDestino."/destinos-".$pagina_destino.".php";
		copy($fitxerCopiar,$fitxerNew);

	} catch (Exception $e) {
		$message ='Error en la pagina de la nueva especialidad';
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Para agregar un destino</TITLE>
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