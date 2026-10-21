<?php
 try {
	// Importation des fichiers
	include('includes/sql_admin.php');
	include('includes/execute_sql_admin.php');

	// Récupération des parametres
	$titulo = $_POST["titulo"];
		$titulo = addslashes($titulo);
	$id_lanzamiento = $_POST["id_lanzamiento"];
	$imagen = $_POST["imagen"];
	$texto = $_POST["texto"];
		$texto = addslashes($texto);
	$textoAmp = $_POST["textoAmp"];
	  $textoAmp = addslashes($textoAmp);
	$orden = $_POST["orden"];
	$visible = $_POST["visible"];
	$descuento = $_POST["descuento"];
	if ($descuento == '') $descuento=0;
	$esbanner = $_POST["esbanner"];
	$esbanner = checkbox_bd($esbanner);
	$esbanner_eventos = $_POST["esbanner_eventos"];
	$esbanner_eventos = checkbox_bd($esbanner_eventos);
	$id_pais = $_POST["id_pais"];
	$id_destino = $_POST["destinos"];
				
	// Taitement pour les Descripcions
	//$texto = string_bd ($texto);
	
	if ($_FILES["imagen"]["name"] != "") {
		$imagen = basename($_FILES["imagen"]["name"]);
	}

	$sql_insert_news = sql_insert_news($titulo, $id_lanzamiento, $imagen ,$texto,$textoAmp,$orden,$visible,$descuento,$esbanner,$id_pais,$esbanner_eventos,$id_destino);
	execute_sql($sql_insert_news);
	
	$message = "news insertada sin imagen";
	if ($_FILES["imagen"]["name"] != "") {

		$uploadFileDir = "../newsletter/images/".$id_lanzamiento."/";
		if(!is_dir($uploadFileDir)) {
			try {
				mkdir($uploadFileDir,0777);
				//$message ='creado directorio '.$uploadFileDir;
				
			} catch (Exception $e) {
				$message ='Error en la alta de la news';
			}
		}
		
		$fileTmpPath = $_FILES['imagen']['tmp_name'];
		$dest_path = $uploadFileDir . $imagen;
		if(move_uploaded_file($fileTmpPath, $dest_path))
		{
		  $message ='news insertada y Imagen subida correctamente';
		}
		else
		{
		  $message = 'news insertada. NO se ha podido subir la imagen al servidor';
		}
	}
} catch (Exception $e) {
	$message = "Excepción capturada : $e->getMessage()"; 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Para agregar una oferta</TITLE>
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