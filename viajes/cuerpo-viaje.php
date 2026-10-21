<?php
include ("../../include/sql.php");
include ("../../include/execute_sql.php");

if ($_GET["id_viaje"] != ""){
	$id_viaje = $_GET["id_viaje"];
}
else {
	$id = 1;
}

$sql_detalle_viaje = sql_detalle_viaje($id_viaje);
$result_detalle_viaje = execute_sql($sql_detalle_viaje);
while($RS = mysqli_fetch_array($result_detalle_viaje))
{
	$id_lanzamiento = $RS[id_lanzamiento];
	$id_new = $RS[id_news];
	$titulo = $RS[titulo];
	$imagen = $RS[imagen];
	$texto = $RS[texto];
	$textoAmp = $RS[textoAmp];
	$orden = $RS[orden];
	$lado = $RS[lado];
	$descuento = $RS[descuento];
	$nombre_pagina_destino = $RS[nombre_pagina_destino];
	$nombre_pagina_pais = $RS[nombre_pagina_pais];
	$destino = $RS[destino];
	$id_destino = $RS[id_destino];
	$id_pais = $RS[id_pais];
	$nombre_pais = $RS[nombre_pais];
	$id_lanzamiento_imagen = $RS[id_lanzamiento_imagen];
	
	//$lineas = (strlen($texto)/90) * 100;
	//$lineas = (strlen($textoAmp)/90) * 100;
	$lineas = round(strlen($textoAmp)/90) * 10;
	
	$textoAmp = preg_replace('@(\[web=([^\]]*)]([^\]]*)\[\/web\])@', '<a href="\2" class="estilolink" target="_blank">\3</a>', $textoAmp);
	$texto = preg_replace('@(\[web=([^\]]*)]([^\]]*)\[\/web\])@', '<a href="\2" class="estilolink" target="_blank">\3</a>', $texto);
}

?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="Viaje <? echo "$destino"; ?> : <? echo "$titulo"; ?>">
    
    <title>Viaje <? echo "$destino"; ?> - <? echo "$titulo"; ?></title>

	<!-- Favicons-->
	<link rel="shortcut icon" href="../../img/favicon.ico" type="../../image/x-icon">
	<link rel="apple-touch-icon" type="../../image/x-icon" href="../../img/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" type="../../image/x-icon" sizes="72x72" href="../../img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" type="../../image/x-icon" sizes="114x114" href="../../img/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon" type="../../image/x-icon" sizes="144x144" href="../../img/apple-touch-icon-144x144-precomposed.png">
	
	<!-- Google web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">

	<!-- CSS -->
	<link href="../../css/base.css" rel="stylesheet">

	<!-- SPECIFIC CSS -->
	<link href="../../css/timeline.css" rel="stylesheet">
	
	<!-- CSS -->
	<link href="../../css/slider-pro.min.css" rel="stylesheet">
	<link href="../../css/date_time_picker.css" rel="stylesheet">

	<!--[if lt IE 9]>
      <script src="../../js/html5shiv.min.js"></script>
      <script src="../../js/respond.min.js"></script>
    <![endif]-->

</head>

<body>

	<!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

	<div id="preloader">
		<div class="sk-spinner sk-spinner-wave">
			<div class="sk-rect1"></div>
			<div class="sk-rect2"></div>
			<div class="sk-rect3"></div>
			<div class="sk-rect4"></div>
			<div class="sk-rect5"></div>
		</div>
	</div>
	<!-- End Preload -->

	<div class="layer"></div>
	<!-- Mobile menu overlay mask -->

	<!-- Header================================================== -->
	<header>
        <div id="top_line">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3">
						
					</div>
                    
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <ul id="top_links">
                            <li><i class="icon-phone"></i><strong>+34 610461529 </strong></li>
						<li><i class="icon-mail"></i><strong> info@soloviajesdelujo.com</strong></li>
				
                        </ul>
                    </div>
                </div><!-- End row -->
            </div><!-- End container-->
        </div><!-- End top line-->
        
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div id="logo_home">
                    	<h1><a href="../../index.php" title="Solo Viajes de Lujo">Solo Viajes de Lujo</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="../../img/logo_sticky.png" width="152" height="69" alt="Solo Viajes de Lujo" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul>
                            <li><a href="../../nosotros.html" >Quienes somos</a></li>
							<li><a href="../../index.php#destinos" >Principales destinos</a></li>
							<li><a href="../../index.php#rutas" >Rutas</a></li>
							<li><a href="../../index.php#cruceros" >Cruceros</a></li>
							<li><a href="../../ofertas-exclusivas.php" >Ofertas Exclusivas</a></li>
							<li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Corporativo<i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="#">Viajes empresas</a></li>
                                    <li><a href="#">Fullcharter</a></li>
                                </ul>
                            </li>
							<li><a href="../../contacto.php" >Contacto</a></li>
                        </ul>
                    </div><!-- End main-menu -->
                   
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

	<section class="parallax-window" data-parallax="scroll" data-image-src="../../newsletter/images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" data-natural-width="1400" data-natural-height="470">
		<div class="parallax-content-2">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-8">
						<h1>VIAJE <? echo "$destino"; ?> : <? echo "$titulo"; ?></h1>
						<!--span> CON DESAYUNOS AMERICANOS.</span-->
					</div>
					<!-- <div class="col-md-4 col-sm-4">
						<div id="price_single_main">
							from/per person <span><sup>$</sup>52</span>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</section>
	<!-- End section -->

	<main>
		<div id="position">
			<div class="container">
				<ul>
					<li><a href="../../index.php">Home</a>
					</li>
				
					<li><a href="../../destinos/<? echo "$nombre_pagina_pais"; ?>/destinos-<? echo "$nombre_pagina_pais"; ?>.php?id=<? echo "$id_pais"; ?>"><? echo "$nombre_pais"; ?></a>
					</li>	
					
					<li>
					<a href="viajes-<? echo "$nombre_pagina_destino"; ?>.php?id=<? echo "$id_destino"; ?>"><? echo "$destino"; ?></a></li>
					
			
					<li><? echo "$titulo"; ?></li>
				</ul>
			</div>
		</div>
		<!-- End Position -->


		<!--div class="collapse" id="collapseMap">
			<div id="map" class="map"><h2></div>
		</div-->
		<!-- End Map -->

		<div class="container margin_60">
			<div class="row">
				<div class="col-md-8" id="single_tour_desc">

					<!--hr-->
					
					<div class="main_title">
						<h2>Nuestro <span>Itinerario</span></h2>
					</div>
			 <ul class="cbp_tmtimeline">
				<li>
					<time class="cbp_tmtime"><span>Día 1</span></time>
					<!--div class="cbp_tmicon timeline_icon_point"></div-->
					<div class="cbp_tmlabel">
						<h2>VIAJES <? echo "$nombre_pagina_destino"; ?><h2>
						<h2>VIAJE <? echo "$titulo"; ?><h2>
						<h3><span></span><? echo "$texto"; ?><h3>
						<p><? echo "$textoAmp"; ?></p>
					</div>
				</li>

			 </ul>

					<!--hr>
	
					<hr-->
				</div>
				<!--End  single_tour_desc-->

				<aside class="col-md-4">
					<div class="box_style_1 expose">
						<!--h3 class="inner">- Reserva -</h3>


						<br-->
	
						<a class="btn_full" href="../../contacto.php?id=<? echo "$id_viaje"; ?>">Solicitar informacion viaje <? echo "$nombre_pagina_destino"; ?> - <? echo "$titulo"; ?> </a>
						<!--a class="btn_full_outline" href="#"><i class=" icon-heart"></i>Agregar a Mi lista</a-->
					</div>
					<!--/box_style_1 -->

					<div class="box_style_4">
						<i class="icon_set_1_icon-90"></i>
						<h4><span>Reserva</span> Telefónica</h4>
						<a href="tel:+34610461529" class="phone">+ 34 610461529</a>
						<small>Lunes a Viernes 9:30h - 14:30h. 15:45h - 19:00h </small>
					</div>

				</aside>
			</div>
			<!--End row -->
		</div>
		<!--End container -->
        
        <div id="overlay"></div>
		<!-- Mask on input focus -->
        
	</main>
	<!-- End main -->

<footer class="revealed">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-3">
					<p><img src="../../img/logo.png" width="152" height="69" alt="Solo Viajes de Lujo" data-retina="true" id="logo">
					</p>
					<p>Somos especialistas en Turismo, más de 25 años de experiencia en el sector turístico nos avalan. Nuestro objetivo ofrecer a nuestros clientes las mejores alternativas y servicio totalmente desarrollado a medida de sus necesidades</p>
				</div>
                <div class="col-md-2 col-sm-3">
                    <h3>Mapa del Sitio</h3>
                    <ul>
                        <li><a href="../../nosotros.html">Quines somos</a></li>
                        <li><a href="../../index.php#rutas">Rutas</a></li>
                        <li><a href="../../index.php#cruceros">Cruceros</a></li>
                        <li><a href="../../ofertas-exclusivas.php">Ofertas exclusivas</a></li>
						<li><a href="#">Viajes empresas</a></li>
						<li><a href="#">Fullcharter</a></li>
                        <li><a href="../../confirmacion.php">Contacto</a></li>
						<li><a href="../../terminos-condiciones.html">Términos y condiciones</a></li>
						<li><a href="../../politica-privacidad.html">Política de privacidad</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6" id="newsletter">
					<h3>Newsletter</h3>
					<p>Suscríbete a las mejores ofertas.</p>
					<div id="message-newsletter_2"></div>
					<form method="post" action="registro.php" name="newsletter_2" id="newsletter_2">
						<div class="form-group">
							<input name="email_newsletter_2" id="email_newsletter_2" type="email" value="" placeholder="Correo" class="form-control" required>
						</div>
						<input type="submit" value="Suscribirme	" class="btn_1" id="submit-newsletter_2">
					</form>
				</div>
                <div class="col-md-3 col-sm-3">
                    <h3>Contáctanos</h3>
                    <a href="tel://+34610461529" id="phone">+ 34 610461529</a>
                    <a href="mailto:info@soloviajesdelujo.com" id="email_footer">info@soloviajesdelujo.com</a>
					<h3> 	
						Lunes a Viernes
						<br	> 
						9:30h - 14:30h.
						15:45h - 19:00h 
					</h3>
                </div>
                </div>
            </div><!-- End row -->
            <div class="row">
                <div class="col-md-12">
                    <div id="social_footer">
                        <ul>
                            <!-- <li><a href="#"><i class="icon-facebook"></i></a></li>
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-google"></i></a></li> >
                            <li><a href="#"><i class="icon-instagram"></i></a></li>
                            < <li><a href="#"><i class="icon-pinterest"></i></a></li>
                            <li><a href="#"><i class="icon-vimeo"></i></a></li>
                            <li><a href="#"><i class="icon-youtube-play"></i></a></li>
                            <li><a href="#"><i class="icon-linkedin"></i></a></li> -->
                        </ul>
                        <p>© Solo Viajes de Lujo 2018</p>
						<p>Viajes <? echo "$destino"; ?> - <? echo "$titulo"; ?></p>
						
                    </div>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
    </footer><!-- End footer -->

	<div id="toTop"></div><!-- Back to top button -->
	
	<!-- Search Menu -->
	<div class="search-overlay-menu">
		<span class="search-overlay-close"><i class="icon_set_1_icon-77"></i></span>
		<form role="search" id="searchform" method="get">
			<input value="" name="q" type="search" placeholder="Search..." />
			<button type="submit"><i class="icon_set_1_icon-78"></i>
			</button>
		</form>
	</div><!-- End Search Menu -->

	<!-- Common scripts -->
	<script src="../../js/jquery-2.2.4.min.js"></script>
	<script src="../../js/common_scripts_min.js"></script>
	<script src="../../js/functions.js"></script>

	<!-- Specific scripts -->
	<script src="../../js/icheck.js"></script>
	<script>
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-grey',
			radioClass: 'iradio_square-grey'
		});
	</script>
	<!-- Date and time pickers -->
	<script src="../../js/jquery.sliderPro.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function ($) {
			$('#Img_carousel').sliderPro({
				width: 960,
				height: 500,
				fade: true,
				arrows: true,
				buttons: false,
				fullScreen: false,
				smallSize: 500,
				startSlide: 0,
				mediumSize: 1000,
				largeSize: 3000,
				thumbnailArrows: true,
				autoplay: false
			});
		});
	</script>

	<!-- Date and time pickers -->
	<script src="../../js/bootstrap-datepicker.js"></script>
	<script src="../../js/bootstrap-timepicker.js"></script>
	<script>
		$('input.date-pick').datepicker('setDate', 'today');
		$('input.time-pick').timepicker({
			minuteStep: 15,
			showInpunts: false
		})
	</script>

	<!--Review modal validation >
	<script src="assets/validate.js"></script-->

	<!-- Map >
	<script src="http://maps.googleapis.com/maps/api/js"></script-->
                                   
                                   
	<!--script src="../../js/map.js"></script>
	<script src="../../js/infobox.js"></script-->
</body>

</html>