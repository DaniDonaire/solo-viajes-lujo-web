<?php
include ("../../include/sql.php");
include ("../../include/execute_sql.php");

if ($_GET["id"] != ""){
	$id = $_GET["id"];
}
else {
	$id = 1;
}

$sql_especialidad = sql_especialidad($id);
$result_sql_especialidad = execute_sql($sql_especialidad);
$RS = mysqli_fetch_array($result_sql_especialidad);
if($RS){
	$imagen_pais = $RS["imagen_pais"];
	$nombre_pais = $RS["nombre_pais"];
	$destinos = $RS["destinos"];
	
	$destinos = str_replace(',',', ',$destinos);
}
else {
	$sql_pais = sql_pais($id);
	$result_sql_pais = execute_sql($sql_pais);
	$RS = mysqli_fetch_array($result_sql_pais);
	if($RS){
		$imagen_pais = $RS["imagen_pais"];
		$nombre_pais = $RS["nombre_pais"];
	}
}

?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="en">

<head>
	<script src="../../js/newsletter.js" defer></script>
	<script src="../../js/google-analytics.js"></script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="Viajes <?php echo "$nombre_pais"; ?> : <?php echo "$destinos"; ?>">
	<meta name="keywords" content="viajes,<?php echo "$nombre_pais"; ?> ,<?php echo "$destinos"; ?>" />
    <title>Viajes <?php echo "$nombre_pais"; ?> los mejores destinos</title>


	<!-- Favicons-->
	<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" type="image/x-icon" href="../../img/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="../../img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="../../img/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="../../img/apple-touch-icon-144x144-precomposed.png">
	
	<!-- Google web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">

	<!-- CSS -->
	<link href="../../css/base.css" rel="stylesheet">

	<!-- Radio and check inputs -->
	<link href="../../css/skins/square/grey.css" rel="stylesheet">

	<!-- Range slider -->
	<link href="../../css/ion.rangeSlider.css" rel="stylesheet">
	<link href="../../css/ion.rangeSlider.skinFlat.css" rel="stylesheet">

	<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
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
						<!--li><a href="wishlist.html" id="wishlist_link">Mi Lista</a></li>
							<li>
                                <div class="dropdown dropdown-access">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="access_link">Cuenta</a>
                                    <div class="dropdown-menu">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <a href="#" class="bt_facebook">
                                                    <i class="icon-facebook"></i>Facebook</a>
                                            </div>
                                            
                                        </div>
                                        <div class="login-or">
                                            <hr class="hr-or">
                                            <span class="span-or">O</span>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="inputUsernameEmail" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="inputPassword" placeholder="Contraseña">
                                        </div>
                                        <a id="forgot_pw" href="#">Olvido su contraseña?</a>
                                        <input type="submit" name="Sign_in" value="Ingresar" id="Sign_in" class="button_drop">
                                        <input type="submit" name="Sign_up" value="Registro" id="Sign_up" class="button_drop outline">
                                    </div>
                                </div>
                            </li -->
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
	
	<section class="parallax-window" data-parallax="scroll" data-image-src="../../destinos/img/<?php echo "$imagen_pais"; ?>" data-natural-width="1400" data-natural-height="470" alt="<?php echo "$nombre_pais"; ?>">
		<div class="parallax-content-1">
			<div class="animated fadeInDown">
				<h1>Los mejores Destinos en <?php echo "$nombre_pais"; ?></h1>
				<p>Solo Viajes de Lujo</p>
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
				</ul>
			</div>
		</div>
		<!-- Position -->

		
		<!-- End Map -->

		<div class="container margin_60">

			<div class="main_title">
				<h2> <span><?php echo "$nombre_pais"; ?></span></h2>
				<br>
				<p>En Solo Viajes de Lujo somos especialista en viajes a <strong><?php echo "$destinos"; ?></strong>. Con todo tipo de opciones: circuitos regulares, auto-rutas, viajes a medida.</p>
			    <br>
			</div>
			
			<?php
			$sql_destinos = sql_destinos($id);
			$result_sql_destinos = execute_sql($sql_destinos);
			while($RS = mysqli_fetch_array($result_sql_destinos)) {
					$id_pais = $RS["id_pais"];
					$id_destino = $RS["id_destino"];
					$destino = $RS["destino"];
					$imagen = $RS["imagen_destino"];
					$nombre_pagina_destino = $RS["nombre_pagina_destino"];
			?>
			<div class="row">

				<div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
					<div class="hotel_container">
								<div class="img_container">
									<a href="../../viajes/<?php echo "$nombre_pagina_destino"; ?>/viajes-<?php echo "$nombre_pagina_destino"; ?>.php?id=<?php echo "$id_destino"; ?>">
										<img src="../../viajes/<?php echo "$nombre_pagina_destino"; ?>/img/<?php echo "$imagen"; ?>" class="img-responsive" alt="viajes <?php echo "$destino"; ?>" style="width:380px;height:250px;" alt="<?php echo "$destino"; ?>">
									</a>
								</div>
								<div class="hotel_title">
									<h3><strong><?php echo "$destino"; ?></strong></h3>
									<!--div class="wishlist">
										<a class="tooltip_flip tooltip-effect-1" href="#">+<span class="tooltip-content-flip"><span class="tooltip-back">Lista de Deseos</span></span></a>
									</div-->
									<!-- End wish list-->
								</div>
							</div>
					<!-- End box tour -->
				</div>
				<?php } ?>  	

			</div>
			<!-- End row -->
			
			<hr>

					<div class="text-center">
						<ul class="pagination">
							<li><a href="#">Anterior</a>
							</li>
							<li class="active"><a href="#">1</a>
							</li>
							<li><a href="#">Siguiente</a>
							</li>
						</ul>
					</div>
					<!-- end pagination-->
		</div>
		<!-- End container -->
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
                        <li><a href="../../contacto.php">Contacto</a></li>
						<li><a href="../../terminos-condiciones.html">Términos y condiciones</a></li>
						<li><a href="../../politica-privacidad.html">Política de privacidad</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6" id="newsletter">
					<h3>Newsletter</h3>
					<p>Suscríbete a las mejores ofertas.</p>
					<div id="message-newsletter_2"></div>
					<form method="post" action="../../registro.php" name="newsletter_2" id="newsletter_2" data-newsletter-form>
						<div style="position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden" aria-hidden="true"><label>Dejar este campo vacío<input type="text" name="website" value="" tabindex="-1" autocomplete="off"></label></div>
						<div class="form-group">
							<input name="email_newsletter_2" id="email_newsletter_2" type="email" value="" placeholder="Correo" class="form-control" autocomplete="email" required>
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
						<p>Los mejores destinos en <?php echo "$nombre_pais"; ?> : <?php echo "$destinos"; ?></p>
						
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
	<!-- Check and radio inputs -->
	<script src="../../js/icheck.js"></script>
	<script>
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-grey',
			radioClass: 'iradio_square-grey'
		});
	</script>
	<!-- Map>
	<script src="http://maps.googleapis.com/maps/api/js"></script -->
                                   
                                   
	<!--script src="../../js/map_hotels.js"></script>
	<script src="../../js/infobox.js"></script-->

</body>

</html>