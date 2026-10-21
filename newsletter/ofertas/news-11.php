<?php
include ("../../include/sql.php");
include ("../../include/execute_sql.php");

if ($_GET["id_lanza"] != ""){
	$id_lanza = $_GET["id_lanza"];
}
else {
	$id_lanza = 1;
}

$sql_lanza_id = sql_lanza_id($id_lanza);
// Execution des requettes Sql
$result_news = execute_sql($sql_lanza_id);

// Initialisation des variables
$RS = mysqli_fetch_array($result_news);
$id_lanza = $RS[id_lanzamiento];
$titulo = $RS[nombre];

$texto_click = $RS["texto_click"];
$logo = $RS["logo"];
$texto_cabecera = $RS["texto_cabecera"];
$logo_pie_wrld = $RS["logo_pie_wrld"];
$logo_pie_svl = $RS["logo_pie_svl"];
$logo_pie_eve = $RS["logo_pie_eve"];
$logo_pie_cru = $RS["logo_pie_cru"];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
    <!--[if IE 6]>
    <xml:namespace ns="urn:schemas-microsoft-com:vml" prefix="v" />
    <![endif]-->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Soloviajesdelujo - ofertas</title>
    <meta name="title" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-1.css?v=1321362450" />
<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-2.css?v=1323820464" />
<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-3.css?v=1322040781" />
<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-4.css?v=1322040781" />
<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-5.css?v=1321362451" />
<link type="text/css" rel="stylesheet" media="all" href="http://www.soloviajesdelujo.com/newsletter/ofertas/styles/estils-6.css?v=1321362450" />

</head>
<body bgcolor="#4C4747">
	<div id="page-container">
		<center><font face="Verdana,Arial" size="1"><a style="color: #000;" href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-1.php?id_lanza=<? echo "$id_lanza"; ?>""><? echo "$texto_click"; ?></a></font></center>
		<div id="page-content">
            <div id="content">
				<div id="sdv-thematique">
					<div id="thematiques">
						<h3><span>LAS OFERTAS ESPECIALES de la semana</span>:</h3>
						<div class="evenement">
							<div class="evenement-image">
								<a href="http://www.soloviajesdelujo.com">  
								<img align="center" src="http://www.soloviajesdelujo.com/newsletter/ofertas/images/logo.jpg" alt="ofertas"/>
								</a>    
							</div>
						</div>
						<h3><span>Ofertas, </span> Esta semana <strong>soloviajesdelujo.com</strong> ha seleccionado para ti  :</h3>

<?php
 	$sql_all_news_lanza = sql_all_news_lanza($id_lanza);
	$result_sql_all_news = execute_sql($sql_all_news_lanza);
while($RS = mysqli_fetch_array($result_sql_all_news))
{
		$id_new = $RS["id_news"];
		$titulo = $RS["titulo"];
		$imagen = $RS["imagen"];
		$texto = $RS["texto"];
		$texto = preg_replace('@(\[web=([^\]]*)]([^\]]*)\[\/web\])@', '<a href="\2" class="estilolink" target="_blank">\3</a>', $texto);
		$descuento = $RS["descuento"];			

		$texto_click = $RS["texto_click"];
		$logo = $RS["logo"];
		$texto_cabecera = $RS["texto_cabecera"];
		$logo_pie_wrld = $RS["logo_pie_wrld"];
		$logo_pie_svl = $RS["logo_pie_svl"];
		$logo_pie_eve = $RS["logo_pie_eve"];
		$logo_pie_cru = $RS["logo_pie_cru"];
		$destino = $RS["nombre_pagina_destino"];
		$id_lanzamiento_imagen = $RS["id_lanzamiento_imagen"];	
?>
						
						<div class="thematique">
							<div class="th-txt">
								<div class="th-titre-pct">
									<div class="th-titre"><? echo "$titulo"; ?></div>
										<?php if ($descuento > 0) { ?> 
										<div class="th-pct">- <? echo "$descuento"; ?> % </div>
										<?php } ?> 
								</div>
								<div class="th-photo">
									<a href="https://www.soloviajesdelujo.com/viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>"><img src="../images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>"/></a>
								</div>
								<div class="th-contenu">
									<div class="th-contenu-txt">
										<div class="th-contenu-txt-dates">Ahora a la venta :
										</div>
										<br>
										<div class="th-contenu-txt-accroche"><? echo "$texto"; ?><br /></div>
									</div>
								</div>
								<div class="clearBoth"></div>
							</div>
							<div class="th-foot"></div>
						</div>

<?php }?>  
							
                     </div>
				</div>
				<div class="clearBoth"></div>
			</div>
        </div>
    
	
		<div id="page-footer">
			<ul id="bottom-menu">
			<li><a href="http://www.soloviajesdelujo.com/nosotros.html">Quienes somos?</a></li> |  
			<li><a href="http://www.soloviajesdelujo.com/terminos-condiciones.html">Condiciones generales de venta</a></li> | 
			<li><a href="https://soloviajesdelujo.com" target="_blank">condiciones del seguro</a></li> | 
			<li class="social-links">Siguenos en    <a target="blank" href="http://www.facebook.com/pages/Eventos3Mundos/103404759752951?ref=ts" class="hide-text footer-social-icon footer-social-icon-fb"></a>
			<a target="blank" href="http://twitter.com/#!/eventos3mundos" class="hide-text footer-social-icon footer-social-icon-twitter"></a>
			</li>
			</ul>
		</div>
	
	</div>
</body>
</html>
