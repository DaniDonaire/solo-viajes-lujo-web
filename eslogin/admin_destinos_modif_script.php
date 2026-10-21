<?php

// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Récupération des parametres
$id_pais= $_POST["id_pais"];
$nombre_destino = $_POST["nombre_destino"];
$pagina_destino = $_POST["nombre_destino"];
//$pagina_destino = str_replace(' ','-',$pagina_destino);
//$pagina_destino = preg_replace("/[^a-zA-Z0-9\_\-]+/", "", $pagina_destino);
$imagen = $_POST["imagen"];
$imagen_ant = $_POST["imagen_ant"];
//$imagenDestino = $_POST["nombre_destino"].".jpg";

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
if ($_FILES["imagen"]["name"] != "") {
	//$imagenMasDir = "newsletter/images/".$id_lanzamiento."/".str_replace(' ','',basename($_FILES["imagen"]["name"]));
	$imagenMasDir = str_replace(' ','',basename($_FILES["imagen"]["name"]));
	$sql_update_pais_svl = sql_update_pais_svl($id_pais, $nombre_destino,$pagina_destino,  $imagenDestino ,$activo);
} else {
	$sql_update_pais_svl = sql_update_pais_svl($id_pais, $nombre_destino,$pagina_destino, $imagenDestino,$activo);
}

//echo $sql_update_news;
// Insert a la base de donnée
execute_sql($sql_update_pais_svl);

// upload imatge
$message = "ok";
if ($_FILES["imagen"]["name"] != "") {

	$fileTmpPath = $_FILES['imagen']['tmp_name'];
	$fileName = $_FILES['imagen']['name'];

	$uploadFileDir = '../destinos/img/';
	$dest_path = $uploadFileDir . $pagina_destino . '.jpg';
	 
	if(move_uploaded_file($fileTmpPath, $dest_path))
	{
	  $message ='Destino modificado e Imagen subida';
	}
	else
	{
	  $message = 'Destino modificado NO se ha podido subir la Imagen';
	}
}
else{
	$message ='Destino modificado. Imagen NO modificada';
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
	<TITLE>Modificado destino</TITLE>
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