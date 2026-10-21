<?php
include ("../../include/sql.php");
include ("../../include/execute_sql.php");

if ($_GET["id"] != ""){
	$id = $_GET["id"];
}
else {
	$id = 1;
}
$sql_destino = sql_destino($id);
$result_sql_destino = execute_sql($sql_destino);

$RS = mysqli_fetch_array($result_sql_destino);
if($RS){
	$imagen_destino = $RS['imagen_destino'];
	$nombre_pagina_pais = $RS['nombre_pagina_pais'];
	$nombre_pais = $RS['nombre_pais'];
	$destino = $RS['destino'];
	$id_pais = $RS['id_pais'];
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

	<meta name="description" content="Viajes <? echo "$destino"; ?>">
    <title>Viajes <? echo "$destino"; ?></title>


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
                            </li-->
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
							<li><a href="cruceros.html" >Cruceros</a></li>
							<li><a href="../../ofertas-exclusivas.php" >Ofertas Exclusivas</a></li>
							<li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Corporativo<i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="../../viajes-empresas.html">Viajes empresas</a></li>
                                    <li><a href="../../buques-exclusiva.html">Fullcharter</a></li>
                                </ul>
                            </li>
							<li><a href="../../contacto.php" >Contacto</a></li>
                        </ul>
                    </div><!-- End main-menu -->
                    <!--ul id="top_tools">
          
                        <li>
                            <div class="dropdown dropdown-cart">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class=" icon-basket-1"></i>(0)</a>
                                <ul class="dropdown-menu" id="cart_items">
                                    <li>
                                        <div class="image"><img src="../../img/thumb_cart_1.jpg" alt="image"></div>
                                        <strong>
										<a href="#">Louvre museum</a>1x $36.00 </strong>
                                        <a href="#" class="action"><i class="icon-trash"></i></a>
                                    </li>
                                    <li>
                                        <div class="image"><img src="../../img/thumb_cart_2.jpg" alt="image"></div>
                                        <strong>
										<a href="#">Versailles tour</a>2x $36.00 </strong>
                                        <a href="#" class="action"><i class="icon-trash"></i></a>
                                    </li>
                                    <li>
                                        <div class="image"><img src="../../img/thumb_cart_3.jpg" alt="image"></div>
                                        <strong>
										<a href="#">Versailles tour</a>1x $36.00 </strong>
                                        <a href="#" class="action"><i class="icon-trash"></i></a>
                                    </li>
                                    <li>
                                        <div>Total: <span>$120.00</span></div>
                                        <a href="cart.html" class="button_drop">Carrito</a>
                                        <a href="payment.html" class="button_drop outline">Completar</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul-->
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

	<section class="parallax-window" data-parallax="scroll" data-image-src="img/<? echo "$imagen_destino"; ?>" data-natural-width="1400" data-natural-height="470">
		<div class="parallax-content-2">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-8">
						<h1>Los mejores viajes por <? echo "$destino"; ?></h1>
					</div>

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
					
					<li>
					<a href="../../destinos/<? echo "$nombre_pagina_pais"; ?>/destinos-<? echo "$nombre_pagina_pais"; ?>.php?id=<? echo "$id_pais"; ?>">
					<? echo "$nombre_pais"; ?></a>
					</li>
					
					<li><? echo "$destino"; ?></li>
				</ul>
			</div>
		</div>
		<!-- Position -->
<!-- 
		<div class="collapse" id="collapseMap">
			<div id="map" class="map"></div>
		</div> -->
		<!-- End Map -->


		<div class="container margin_60">

			<div class="row">
				<aside class="col-lg-3 col-md-3">
					<!-- <p>
						<a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a>
					</p> -->

					<!--End filters col-->
					<div class="box_style_2">
						<i class="icon_set_1_icon-57"></i>
						<h4>Ayuda <span>para tu Viaje a </span> <? echo "$destino"; ?> ?</h4>
						<a href="tel:+34610461529">+ 34 610461529</a><br>
						<small> lunes a viernes <br> 
						9:30h - 14:30h. 15:45h - 19:00h </small>
					</div>
				</aside>
				<!--End aside -->
				
				<div class="col-lg-9 col-md-9">
				
			<?php
			$sql_viajes = sql_viajes($id);
			$result_sql_viajes = execute_sql($sql_viajes);
			while($RS = mysqli_fetch_array($result_sql_viajes)) {
					$id_lanzamiento = $RS['id_lanzamiento'];
					$id_viaje = $RS["id_news"];
					$titulo = $RS["titulo"];
					$imagen = $RS["imagen"];
					$texto = substr($RS["texto"],0,300);
					//$texto = $RS["texto"];
					$nombre_pagina_destino = $RS["nombre_pagina_destino"];
					$id_lanzamiento_imagen = $RS["id_lanzamiento_imagen"];
			?>
				
					<div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4">
								<div class="img_list">
									<a href="viaje-<? echo "$nombre_pagina_destino"; ?>.php?id_viaje=<? echo "$id_viaje"; ?>"><img src="../../newsletter/images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" alt="<? echo "$titulo"; ?>">
										<!-- <div class="short_info"><i class="icon_set_1_icon-4"></i>Museums </div> -->
									</a>
								</div>
							</div>
							<div class="clearfix visible-xs-block"></div>
							<div class="col-lg-6 col-md-6 col-sm-6">
								<div class="tour_list_desc">
									<h3><strong>Viaje <? echo "$destino"; ?></strong></h3>
									<h3><strong><? echo "$titulo"; ?></strong></h3>
									<p><? echo "$texto"; ?></p>
					
								</div>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-2">
								<div class="price_list">
									<div>
										<p><a href="viaje-<? echo "$nombre_pagina_destino"; ?>.php?id_viaje=<? echo "$id_viaje"; ?>" class="btn_1">Detalles</a>
										</p>
									</div>

								</div>
							</div>
						</div>
					</div>
					
			<?php } ?>  	
					<!--End strip >

					
					<hr-->

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
					</div>
					<!-- end pagination-->

				</div>
				<!-- End col lg-9 -->
			</div>
			<!-- End row -->
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
                        <li><a href="../../nosotros.html">Quienes somos</a></li>
                        <li><a href="index.php#rutas">Rutas</a></li>
                        <li><a href="cruceros.html">Cruceros</a></li>
                        <li><a href="../../ofertas-exclusivas.php">Ofertas exclusivas</a></li>
						<li><a href="viajes-empresas.html">Viajes empresas</a></li>
						<li><a href="buques-exclusiva.html">Fullcharter</a></li>
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
						<p>Viajes a <? echo "$destino"; ?></p>
						
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
	<!-- Cat nav mobile -->
	<script src="../../js/cat_nav_mobile.js"></script>
	<script>
		$('#cat_nav').mobileMenu();
	</script>
	<!-- Check and radio inputs -->
	<script src="../../js/icheck.js"></script>
	<script>
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-grey',
			radioClass: 'iradio_square-grey'
		});
	</script>
	<!-- Map >
	<script src="http://maps.googleapis.com/maps/api/js"></script-->
                                   
                                   
	<!--script src="../../js/map.js"></script>
	<script src="../../js/infobox.js"></script-->
</body>

</html>