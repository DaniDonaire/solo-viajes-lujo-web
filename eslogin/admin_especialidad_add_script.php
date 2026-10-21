<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$message ='Init';

$nombre_especialidad = $_POST["nombre_especialidad"];
$nombre_pagina=$nombre_especialidad;
//$nombre_pagina = preg_replace("/[^a-zA-Z0-9\_\-]+/", "", $nombre_pagina);
//$nombre_pagina = preg_replace("/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/", "", $nombre_pagina);
//$nombre_pagina = preg_replace("/[^a-zA-Z0-9\_\-]+/", "", $nombre_especialidad);

setlocale(LC_CTYPE, 'es_ES');
//$charset='ISO-8859-1'; // o 'UTF-8'
$charset='UTF-8'; // o 'UTF-8'
$nombre_pagina = iconv($charset, 'ASCII//TRANSLIT', $nombre_pagina);

$id_pais = $_POST["id_pais"];
$imagenDestino=null;
$activo = $_POST["activo"];
$activo = checkbox_bd($activo);

$nombre_pagina = str_replace(' ','-',$nombre_pagina);

if ($_FILES["imagen"]["name"] != "") {
	$imagenDestino = $nombre_pagina.".jpg";
}

$sql_insert_especialidad = sql_insert_especialidad($nombre_especialidad,$nombre_pagina, $id_pais , $imagenDestino, $activo);
execute_sql($sql_insert_especialidad);

$message = "Especialidad insertada sin imagen";
if ($_FILES["imagen"]["name"] != "") {

	$fileTmpPath = $_FILES['imagen']['tmp_name'];
	$uploadFileDir = "../viajes/".$nombre_pagina;
	$uploadFileDir2 = "../viajes/".$nombre_pagina."/img/";

	if(!is_dir($uploadFileDir)) {
		try {
			mkdir($uploadFileDir,0777);
			
			$uploadFileDir2 = "../viajes/".$nombre_pagina."/img/";
			$fitxerCopiar="../viajes/Alaska/viajes-Alaska.php";
			$fitxerCopiar2="../viajes/Alaska/viaje-Alaska.php";
			$fitxerNew=$uploadFileDir."/viajes-".$nombre_pagina.".php";
			$fitxerNew2=$uploadFileDir."/viaje-".$nombre_pagina.".php";
			copy($fitxerCopiar,$fitxerNew);
			copy($fitxerCopiar2,$fitxerNew2);
			if(!is_dir($uploadFileDir2)) {
				mkdir($uploadFileDir2,0777);
			}
		} catch (Exception $e) {
			$message ='Error en la alta de la especialidad';
		}
	}
	else {
		//$message ='creado directorio '.$uploadFileDir;
		if(!is_dir($uploadFileDir2)) {
			try {
				mkdir($uploadFileDir2,0777);
			} catch (Exception $e) {
				$message ='Error en la alta de la especialidad';
			}
		}
	}
	
	$dest_path = $uploadFileDir2 . $nombre_pagina . '.jpg';
	if(move_uploaded_file($fileTmpPath, $dest_path))
	{
	  $message ='Especialidad insertada y Imagen subida correctamente';
	}
	else
	{
	  $message = 'Especialidad insertada. NO se ha podido subir la imagen al servidor';
	}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Para agregar una especialidad</TITLE>
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
			<br>
		</td>
	</tr>
</table>
</body>
</HTML>