<?php
 try {
// Importation des fichiers
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

// Récupération des parametres
$titulo = $_POST["titulo"];
$id_lanzamiento = $_POST["id_lanzamiento"];
$imagen = $_POST["imagen"];
$texto = $_POST["texto"];
$textoAmp = $_POST["textoAmp"];
  $textoAmp = addslashes($textoAmp);
$orden = $_POST["orden"];
$lado = $_POST["lado"];
$descuento = $_POST["descuento"];
if ($descuento == '') $descuento=0;
$esbanner = $_POST["esbanner"];
$esbanner = checkbox_bd($esbanner);
$esbanner_eventos = $_POST["esbanner_eventos"];
$esbanner_eventos = checkbox_bd($esbanner_eventos);
$id_pais = $_POST["id_pais"];
$id_destino = $_POST["destinos"];
			
// Taitement pour les Descripcions
$texto = string_bd ($texto);

$imagenMasDir = "newsletter/images/".$id_lanzamiento."/".str_replace(' ','',basename($_FILES["imagen"]["name"]));
// Création de la requette
$sql_insert_news = sql_insert_news($titulo, $id_lanzamiento, $imagenMasDir ,$texto,$textoAmp,$orden,$lado,$descuento,$esbanner,$id_pais,$esbanner_eventos,$id_destino);
// Insert a la base de donnée
//echo $sql_insert_news;
//echo $sql_insert_news;
execute_sql($sql_insert_news);

// upload imatge
$message = "ok";
$cid = ftp_connect((getenv('SVL_FTP_HOST') !== false ? getenv('SVL_FTP_HOST') : '127.0.0.1'));	
$resultado = ftp_login($cid, (getenv('SVL_FTP_USER') !== false ? getenv('SVL_FTP_USER') : ''), (getenv('SVL_FTP_PASSWORD') !== false ? getenv('SVL_FTP_PASSWORD') : '')); 
if ((!$cid) || (!$resultado)) 
{		$message = "Fallo en la conexión"; } 
if ($message == "ok") {
	ftp_pasv ($cid, true) ;	
	$nuevodirectorio = "../newsletter/images/".$id_lanzamiento;
	if (!is_dir($nuevodirectorio)) {
		mkdir($nuevodirectorio,0777);
	}
	$local = str_replace(' ','',$_FILES["imagen"]["name"]);	
	$remoto = str_replace(' ','',$_FILES["imagen"]["tmp_name"]);	
	$tama = $_FILES["imagen"]["size"];	
	//$ruta = "../newsletter/images/" . $local;	
	$ruta = $nuevodirectorio . "/" . $local;			
	if (is_uploaded_file($remoto)){				
		copy($remoto, $ruta);		
		//copy($remoto, $local);	
		$message = "Creada la newssss";	
	}			
	else {				
		if($_FILES['imagen']['error']) { 
			$message = "no se pudo subir el archivo por error : " . $_FILES['imagen']['error'];
		}
		else {
			$message = "no se pudo subir el archivo " . $remoto . "($imagen) a " .$ruta;	
		}
	}
}
// fi upload imatge
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