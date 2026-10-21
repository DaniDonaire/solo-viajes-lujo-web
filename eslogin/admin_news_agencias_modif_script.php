<?php
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Récupération des parametres
$id_new= $_POST["form_id_new"];
$titulo = $_POST["titulo"];
$id_lanzamiento = $_POST["id_lanzamiento"];
$imagen = $_POST["imagen"];
$imagen_ant = $_POST["imagen_ant"];
$texto = $_POST["texto"];
$textoAmp = $_POST[textoAmp];
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

// Taitement pour les Descripcions
//$form_descripcion = string_bd ($form_descripcion);
$texto = string_bd ($texto);
$textoAmp = string_bd ($textoAmp);

// Création de la requette
if ($_FILES["imagen"]["name"] != "") {
	$imagenMasDir = "newsletter/images/".$id_lanzamiento."/".str_replace(' ','',basename($_FILES["imagen"]["name"]));
	$sql_update_news = sql_update_news($id_new, $titulo, $id_lanzamiento, $imagenMasDir , $texto,$textoAmp,$orden,$visible,$descuento,$esbanner,$id_pais,$esbanner_eventos);
} else {
		$sql_update_news = sql_update_news($id_new, $titulo, $id_lanzamiento, $imagen_ant, $texto,$textoAmp,$orden,$visible,$descuento,$esbanner,$id_pais,$esbanner_eventos);
}

//echo $sql_update_news;
// Insert a la base de donnée
execute_sql($sql_update_news);

// upload imatge
$message = "ok";
if ($_FILES["imagen"]["name"] != "") {
	$cid = ftp_connect((getenv('SVL_FTP_HOST') !== false ? getenv('SVL_FTP_HOST') : '127.0.0.1'));	
	$resultado = ftp_login($cid, (getenv('SVL_FTP_USER') !== false ? getenv('SVL_FTP_USER') : ''), (getenv('SVL_FTP_PASSWORD') !== false ? getenv('SVL_FTP_PASSWORD') : ''));
	if ((!$cid) || (!$resultado)) 
	{		$message = "Fallo en la conexión"; } 
	if ($message == "ok") {
		ftp_pasv ($cid, true) ;	
		$local = str_replace(' ','',$_FILES["imagen"]["name"]);	
		$remoto = str_replace(' ','',$_FILES["imagen"]["tmp_name"]);			
		//$local = $_FILES["imagen"]["name"];	
		//$remoto = $_FILES["imagen"]["tmp_name"];	
		$tama = $_FILES["imagen"]["size"];	
		$ruta = "../newsletter/images/".$id_lanzamiento."/".$local;		
		if (is_uploaded_file($remoto)){				
			copy($remoto, $ruta);		
			//copy($remoto, $local);	
			$message = "MOdificada la news";	
		}			
		else {				
			$message = "no se pudo subir el archivo " . $remoto . "($imagen) a " .$ruta;	
		}
	}
}
// fi upload imatge

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