<?php
include ("include/sql.php");
include ("include/execute_sql.php");

?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="en">

<head>
	<script src="js/newsletter.js" defer></script>
	<script src="js/google-analytics.js"></script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="solo Viajes de Lujo - Viajes De lujo, Exclusivos, para Empresas, Safaris, Islas Mauricio, Tanzania, Botswana, Namibia, Sudafrica">
    <meta name="author" content="Ingenio Proyectos | Innovacorp Technology">
    <title>Solo Viajes de Lujo - Viajes Exclusivos</title>

	<!-- Favicons-->
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
	<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">
	
	<!-- Google web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">

	<!-- CSS -->
	<link href="css/base.css" rel="stylesheet">

	<!-- CSS -->
	<link href="css/blog.css" rel="stylesheet">

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
                    	<h1><a href="index.php" title="Solo Viajes de Lujo">Solo Viajes de Lujo</a></h1>
                    </div>
                </div>
                <nav class="col-md-9 col-sm-9 col-xs-9">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="img/logo_sticky.png" width="152" height="69" alt="Solo Viajes de Lujo" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul>
                            <li><a href="nosotros.html" >Quienes somos</a></li>
							<li><a href="index.php#destinos" >Principales destinos</a></li>
							<li><a href="index.php#rutas" >Rutas</a></li>
							<li><a href="cruceros.html" >Cruceros</a></li>
							<li><a href="ofertas-exclusivas.php" >Ofertas Exclusivas</a></li>
							<li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Corporativo<i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="viajes-empresas.html">Viajes empresas</a></li>
                                    <li><a href="buques-exclusiva.html">Fullcharter</a></li>
                                </ul>
                            </li>
							<li><a href="contacto.php" >Contacto</a></li>
                        </ul>
                    </div><!-- End main-menu -->

                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

	<section class="parallax-window" data-parallax="scroll" data-image-src="img/ofertas-bg.jpg" data-natural-width="1400" data-natural-height="470">
		<div class="parallax-content-1">
			<div class="animated fadeInDown">
				<h1>Ofertas Exclusivas</h1>
				<p>No busque su viaje. Búsquenos y le contaremos como será!</p>
			</div>
		</div>
	</section>
	<!-- End section -->

	<main>
		<div id="position">
			<div class="container">
				<ul>
					<li><a href="index.php">Home</a>
					</li>
					<li>Ofertas Exclusivas</li>
				</ul>
			</div>
		</div>
		<!-- End position -->

		<div class="container margin_60">
			<div class="row">
				<aside class="col-md-3 add_bottom_30">
				   <div class="box_style_2">
						<i class="icon_set_1_icon-57"></i>
						<h4>No pierdas estas <span>Ofertas</span> <br><br> Contáctanos</h4>
						<a href="tel:+34610461529" class="phone">+34 610461529</a>
						<small>Lunes a Viernes 9.00am - 7.30pm</small>
					</div>
				</aside>
				<!-- End aside -->

				<div class="col-md-9">
				
					<?php
					$sql_ofertas_exclusivas = sql_ofertas_exclusivas();
					$result_sql_ofertas_exclusivas = execute_sql($sql_ofertas_exclusivas);
					while($RS = mysqli_fetch_array($result_sql_ofertas_exclusivas)) {
							$id_lanzamiento = $RS['id_lanzamiento'];
							$id_viaje = $RS["id_news"];
							$titulo = $RS["titulo"];
							$imagen = $RS["imagen"];
							$texto = substr($RS["texto"],0,76);
							$nombre_pagina_destino = $RS["nombre_pagina_destino"];
					?>
						<div class="box_style_1">
							<div class="post">
								<a href="viajes/<?php echo "$nombre_pagina_destino"; ?>/viaje-<?php echo "$nombre_pagina_destino"; ?>.php?id_viaje=<?php echo "$id_viaje"; ?>" title="<?php echo "$titulo"; ?>"><img src="newsletter/images/<?php echo "$id_lanzamiento"; ?>/<?php echo "$imagen"; ?>" alt="<?php echo "$nombre_pagina_destino"; ?>" class="img-responsive"></a>
								<h2><?php echo "$titulo"; ?></h2>
								<p>
									<?php echo "$texto"; ?>
								</p>
								<div class="container">
									<a href="viajes/<?php echo "$nombre_pagina_destino"; ?>/viaje-<?php echo "$nombre_pagina_destino"; ?>.php?id_viaje=<?php echo "$id_viaje"; ?>" class="btn_1">Ver Descripción</a>
									<a href="contacto.php?id=<?php echo "$id_viaje"; ?>" class="btn_1">Acceder a la Venta</a>
								</div>
							</div>
							<hr>
						</div>
					<hr>
					<?php } ?> 
					<div class="text-center">
						<ul class="pagination">
							<li><a href="#">Anterior</a>
							</li>
							<li class="active"><a href="#">1</a>
							</li>
							<li><a href="#">2</a>
							</li>
							<li><a href="#">3</a>
							</li>
							<li><a href="#">4</a>
							</li>
							<li><a href="#">5</a>
							</li>
							<li><a href="#">Siguiente</a>
							</li>
						</ul>
						<!-- end pagination-->
					</div>
				</div>
				<!-- End col-md-9-->
			</div>
			<!-- End row-->
		</div>
		<!-- End container -->
	</main>
	<!-- End main -->

 <footer class="revealed">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-3">
					<p><img src="img/logo.png" width="152" height="69" alt="Solo Viajes de Lujo" data-retina="true" id="logo">
					</p>
					<p>Somos especialistas en Turismo, más de 25 años de experiencia en el sector turístico nos avalan. Nuestro objetivo ofrecer a nuestros clientes las mejores alternativas y servicio totalmente desarrollado a medida de sus necesidades</p>
				</div>
                <div class="col-md-2 col-sm-3">
                    <h3>Mapa del Sitio</h3>
                    <ul>
                        <li><a href="nosotros.html">Quienes somos</a></li>
                        <li><a href="index.php#rutas">Rutas</a></li>
                        <li><a href="cruceros.html">Cruceros</a></li>
                        <li><a href="ofertas-exclusivas.php">Ofertas exclusivas</a></li>
						<li><a href="viajes-empresas.html">Viajes empresas</a></li>
						<li><a href="buques-exclusiva.html">Fullcharter</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
						<li><a href="terminos-condiciones.html">Términos y condiciones</a></li>
						<li><a href="politica-privacidad.html">Política de privacidad</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6" id="newsletter">
					<h3>Newsletter</h3>
					<p>Suscríbete a las mejores ofertas.</p>
					<div id="message-newsletter_2"></div>
					<form method="post" action="registro.php" name="newsletter_2" id="newsletter_2" data-newsletter-form>
						<div style="position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden" aria-hidden="true"><label>Dejar este campo vacío<input type="text" name="website" value="" tabindex="-1" autocomplete="off"></label></div>
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
                            <li><a href="#"><i class="icon-google"></i></a></li>>
                            <li><a href="#"><i class="icon-instagram"></i></a></li>
                            <li><a href="#"><i class="icon-pinterest"></i></a></li>
                            <li><a href="#"><i class="icon-vimeo"></i></a></li>
                            <li><a href="#"><i class="icon-youtube-play"></i></a></li>
                            <li><a href="#"><i class="icon-linkedin"></i></a></li> -->
                        </ul>
                        <p>© Solo Viajes de Lujo 2018</p>
						<p>Viajes a Europa, Asia, America, Africa, Estados Unidos, Brasil, Argentina, China, Costa-Rica, Mexico, Canada, Artico, Noruega, Nepal, Laponia, Rusia, Paises Balticos, Perú, Australia, Nueva Zelanda, Fiji, India, Empresas: Eventos, Viajes</p>
						
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
	<script src="js/jquery-2.2.4.min.js"></script>
	<script src="js/common_scripts_min.js"></script>
	<script src="js/functions.js"></script>

</body>

</html>