<?php
 try {
	// Importation des fichiers
	include('includes/sql_admin.php');
	include('includes/execute_sql_admin.php');

	// Récupération des parametres
	$id_new= $_POST["form_id_new"];
	$titulo = $_POST["titulo"];
		$titulo = addslashes($titulo);
	$id_lanzamiento = $_POST["id_lanzamiento"];
	$imagen = $_POST["imagen"];
	$imagen_ant = $_POST["imagen_ant"];
	$texto = $_POST["texto"];
		$texto = addslashes($texto);
	$textoAmp = $_POST[textoAmp];
	  $textoAmp = addslashes($textoAmp);
	$orden = $_POST["orden"];
	$visible = $_POST["visible"];
	$descuento = $_POST["descuento"];
	$esbanner = $_POST["esbanner"];
	$id_pais = $_POST["id_pais"];
	//echo $esbanner;
	$esbanner = checkbox_bd($esbanner);
	//echo $esbanner;
	$esbanner_eventos = $_POST["esbanner_eventos"];
	$esbanner_eventos = checkbox_bd($esbanner_eventos);
	$id_lanzamiento_imagen = $_POST["id_lanzamiento_imagen"];

	// Taitement pour les Descripcions
	//$form_descripcion = string_bd ($form_descripcion);
	//$texto = string_bd ($texto);
	//$textoAmp = string_bd ($textoAmp);
	$id_destino = $_POST["destinos"];

	// Création de la requette
	if ($_FILES["imagen"]["name"] != "") {
		$imagenMasDir = basename($_FILES["imagen"]["name"]);
		$sql_update_news = sql_update_news($id_new, $titulo, $id_lanzamiento, $imagenMasDir , $texto,$textoAmp,$orden,$visible,$descuento,$esbanner,$id_pais,$esbanner_eventos,$id_destino, $id_lanzamiento);
	} else {
			$sql_update_news = sql_update_news($id_new, $titulo, $id_lanzamiento, $imagen_ant, $texto,$textoAmp,$orden,$visible,$descuento,$esbanner,$id_pais,$esbanner_eventos,$id_destino,$id_lanzamiento_imagen);
	}

	//echo $sql_update_news;
	// Insert a la base de donnée
	execute_sql($sql_update_news);

	// upload imatge
	$message = "news modificada sin imagen";
	if ($_FILES["imagen"]["name"] != "") {

		$uploadFileDir = "../newsletter/images/".$id_lanzamiento."/";
		$fileTmpPath = $_FILES['imagen']['tmp_name'];
		$dest_path = $uploadFileDir . $imagenMasDir;
		if(move_uploaded_file($fileTmpPath, $dest_path))
		{
		  $message ='news modificada e Imagen subida correctamente';
		}
		else
		{
		  $message = 'news modificada. NO se ha podido subir la imagen al servidor';
		}
	}
// fi upload imatge
} catch (Exception $e) {
	$message = "Excepción capturada : ". $e;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Modificar la oferta</TITLE>
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