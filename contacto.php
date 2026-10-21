<?php
include ("include/sql.php");
include ("include/execute_sql.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

//if ($_GET["id"] != ""){
$valor = ( empty ($_GET["id"] ) ? NULL : $_GET["id"]);
if ($valor){
	$id = $_GET["id"];
	
	$sql_detalle_viaje = sql_detalle_viaje($id);
	$result_detalle_viaje = execute_sql($sql_detalle_viaje);

	while($RS = mysqli_fetch_array($result_detalle_viaje))
	{
		$id_new = $RS["id_news"];
		$titulo = $RS["titulo"];
		
	}

}
else {
	//header('Location:https://www.soloviajesdelujo.com');
	$id = 0;
	$titulo = '';
}



?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="es">
<script language="JavaScript" type="text/JavaScript">
	// Fonction qui permet de controler le formulaire avant de l'envoyer
	function controle()
	{
		formulario=document.forms[0];
		if (formulario.name_contact.value == "")
		{
			alert("Informar Nombre !");
			formulario.name_contact.focus();
			return false;
		}
		if (formulario.email_contact.value == "")
		{
			alert("Informar Email !");
			formulario.email_contact.focus();
			return false;
		}
		else {
			if (formulario.email_contact.value.indexOf("@") == "-1" || formulario.email_contact.value.indexOf(".") == "-1" ){
				alert("Informar Email correcto!");
				formulario.email_contact.focus();
				return false;
			}
		}
		//enviarEmail();
		formulario.submit();
	}

	function enabledSubmit() {
		
		//document.getElemenstByName('enviar')[0].disabled = false;
		//formulario=document.forms[0];
		//formulario.submit-contact.disabled = false;
		document.getElementById("submit-contact").disabled = false;
	}
	/*
	function enviarEmail(){
		var nombre = formulario.name_contact.value;
		var id = formulario.id.value;
		var email = formulario.email_contact.value;
		var destino = formulario.destino.value;
		//alert(new Date(formulario.date.value));
		var fecha = formulario.date.value;
		var ciudad_inicial = formulario.ciudad_inicial.value;
		var lastname_contact = formulario.lastname_contact.value;
		var lastname_contact2 = formulario.lastname_contact2.value;
		var phone_contact = formulario.phone_contact.value;
		var message_contact = formulario.message_contact.value;
	
		var dataString = 'id='+ id + '&nombre='+ nombre + '&email=' + email + '&destino=' + destino + '&fecha='+ fecha + '&ciudad_inicial=' + ciudad_inicial + '&lastname_contact=' + lastname_contact + '&lastname_contact2='+ lastname_contact2 + '&phone_contact=' + phone_contact + '&message_contact=' + message_contact;
		//alert(dataString);
		//var retorno=false;
		//if(destino != '0')
		//{
			$.ajax({
				async:true,
				data: dataString,
				url:   'enviar-mail.php',
				type:  'POST',
				dataType: 'json',
				success:  function (data) 
				{
					if (data.success){
						alert('Informacion enviada correctamente');
					} else {
						alert('No se ha podido enviar, intentalo de nuevo');
					}
				},
				error: function()
				{
					alert('Ocurrio un error en el servidor .. intentalo de nuevo');
					//alert(data.message);
					//alert(error);
					//retorno=true;
				}
			});
		//}
		//return retorno;
	}*/
</script>
<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="Solo Viajes de Lujo - Viajes De lujo, Exclusivos, para Empresas, Safaris, Islas Mauricio, Tanzania, Botswana, Namibia, Sudafrica">

    <title>Solo Viajes de Lujo - Viajes De lujo, Exclusivos, para Empresas, Safaris, Islas Mauricio, Tanzania, Botswana, Namibia, Sudafrica</title>

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
						<!--li><a href="wishlist.html" id="wishlist_link">Mi Lista</a></li-->
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
							<li><a href="index.php#cruceros" >Cruceros</a></li>
							<li><a href="ofertas-exclusivas.php" >Ofertas Exclusivas</a></li>
							<li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Corporativo<i class="icon-down-open-mini"></i></a>
                                <ul>
                                    <li><a href="#">Viajes empresas</a></li>
                                    <li><a href="#">Fullcharter</a></li>
                                </ul>
                            </li>
							<li><a href="contacto.php" >Contacto</a></li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->

	<section class="parallax-window" data-parallax="scroll" data-image-src="img/header_bg.jpg" data-natural-width="1400" data-natural-height="470">
		<div class="parallax-content-1">
			<div class="animated fadeInDown">
				<h1>Cuéntanos el viaje de tu vida </h1>
				<h2>!Y lo Haremos Realidad!</h2>
			</div>
		</div>
	</section>
	<!-- End Section -->

	<main>
		<div id="position">
			<div class="container">
				<ul>
					<li><a href="index.php">Home</a>
					</li>
					<!-- <li><a href="#">Category</a>
					</li> -->
					<li>Contacto</li>
				</ul>
			</div>
		</div>
		<!-- End Position -->

		<div class="container margin_60">
			<div class="row">
				<div class="col-md-8 col-sm-8">
					<div class="form_title">
						<h3><strong><i class="icon-pencil"></i></strong>Contáctanos a través de nuestro formunlario</h3>
						<p>
							Complete la información siguiente con el fin de recibir un presupuesto personalizado por parte de un consejero: Los campos indicados con un asterisco (*) son obligatorios.
						</p>
					</div>
					<div class="step">

						<div id="message-contact"></div>
						<form method="post" action="confirmacion.php" onSubmit="return controle();" id="">
						<input type="hidden" name="id" value="<? echo "$id"; ?>">						
						<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Fecha de viaje</label>
										<input type="date" class="form-control" id="fecha-viaje" name="fecha-viaje" placeholder="*Fecha">
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Destino</label>
										<input type="text" class="form-control" id="destino" name="destino" value="<? echo "$titulo"; ?>">
									</div>
								</div>
							</div>
							<!-- End row -->
							<div class="row">
								<div class="col-md-2 col-sm-2">
									<label for="exampleSelect1">Adultos</label>
										<select class="form-control" id="exampleSelect1">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">9+</option>
										</select>
								</div>
								<div class="col-md-2 col-sm-2">
									<label for="exampleSelect2">Niños</label>
										<select class="form-control" id="exampleSelect2">
											<option value="0">0</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">9+</option>
										</select>
								</div>
								<div class="col-md-2 col-sm-2">
									<div class="form-check form-check-inline">
										<label>Vuelo incluido</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label">
											<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1"> Si
											<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="0"> No
										</label>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<label>Ciudad inicial</label>
										<input type="text" class="form-control" id="ciudad_inicial" name="ciudad_inicial" >
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-4">
									<div class="form-group">
										<label>Nombre</label>
										<input type="text" class="form-control" id="name_contact" name="name_contact"  maxlength="30">
									</div>
								</div>	
								<div class="col-md-4 col-sm-4">	
									<div class="form-group">
										<label>1° Apellido</label>
										<input type="text" class="form-control" id="lastname_contact" name="lastname_contact" placeholder="">
									</div>
								</div>
								<div class="col-md-4 col-sm-4">	
									<div class="form-group">
										<label>2° Apellido</label>
										<input type="text" class="form-control" id="lastname_contact2" name="lastname_contact2" placeholder="">
									</div>
								</div>	
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-4">
									<div class="form-group">
										<label>Teléfono</label>
										<input type="text" class="form-control" id="phone_contact" name="phone_contact" placeholder="">
									</div>
								</div>	
								<div class="col-md-4 col-sm-4">	
									<div class="form-group">
										<label>Email</label>
										<input type="text" class="form-control" id="email_contact" name="email_contact" placeholder="">
									</div>
								</div>
								<div class="col-md-4 col-sm-4">	
									<div class="form-group">
										<label for="exampleSelect3">Hora que desea le contactemos:</label>
										<select class="form-control" id="exampleSelect3">
											<option value="mañana(9-12)">9H a mediodía</option>
											<option value="mediodía(12-14)">De mediodía a 14H</option>
											<option value="tarde(14-18)">De 14H a 18H</option>
											<option value="noche(18-21)">Despues de las 18H</option>
										</select>
									</div>
								</div>	
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<label for="exampleTextarea">Comentarios</label>
										<textarea class="form-control" id="message_contact" name="message_contact" rows="3"></textarea>
									</div>
								</div>
							</div>
							

							
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="form_title2">
										<p>
											Antes de enviar este formulario, debes leer la siguiente información básica sobre protección de datos. <a href="politica-privacidad.html">INFORMACIÓN BÁSICA SOBRE PRIVACIDAD</a>. El responsable del tratamiento es Grupo Global MPS Viajes y  Cruceros S.L. La finalidad es la gestión de la web y de la relación con sus usuarios, mejora de la calidad, envío de publicidad y perfiles comerciales. La base jurídica es la existencia de una relación contractual, nuestro interés legítimo es promocionar nuestros productos y servicios y su consentimiento para la elaboración de los viajes a medida solicitados. Sólo comunicaremos sus datos cuando sea necesario para la tramitación de sus solicitudes, a otras empresas del grupo de Grupo Global MPS Viajes y Cruceros S.L. o a nuestros proveedores-colaboradores  turísticos, con su previo consentimiento o por obligación legal. Tiene derecho a acceder, rectificar y suprimir los datos, así como otros derechos como se explica en nuestra política de privacidad.
										</p>
										
									</div>
									
								
									<div class="form_title2">
										<div class="g-recaptcha" data-sitekey="6LeUddUUAAAAAFl8kcpUvMH1QySg_qYAA__8_ukq" data-callback="enabledSubmit"></div>
									</div>
									
									
									<input type="submit" value="Enviar" class="btn_1" id="submit-contact" disabled>
								</div>
								
							</div>
							
						</form>
					</div>
				</div>
				<!-- End col-md-8 -->

				<div class="col-md-4 col-sm-4">
					<div class="box_style_1">
						<span class="tape"></span>
						<h4>Solo Viajes de Lujo<span><i class="icon-paper-plane pull-right"></i></span></h4>
						<p>
							Cuéntanos el viaje de tu vida y lo haremos realidad, en cualquier lugar del mundo.
							<br>
							¿Por qué? Porque somos diferentes y queremos ser únicos para ti.
						</p>
					</div>
					<div class="box_style_4">
						<i class="icon_set_1_icon-57"></i>
						<h4><span></span></h4>
						<a href="tel:+34610461529" class="phone">+34 610461529</a>
						<a a href="mailto:info@soloviajesdelujo.com> class="mail">info@soloviajesdelujo.com</a>
						<!-- <small>Monday to Friday 9.00am - 7.30pm</small> -->
					</div>
				</div>
				<!-- End col-md-4 -->
			</div>
			<!-- End row -->
		</div>
		<!-- End container -->

		<!-- <div id="map_contact"></div> -->
		<!-- end map-->
		<!-- <div id="directions">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<form action="http://maps.google.com/maps" method="get" target="_blank">
							<div class="input-group">
								<input type="text" name="saddr" placeholder="Enter your starting point" class="form-control style-2" />
								<input type="hidden" name="daddr" value="New York, NY 11430" /> -->
								<!-- Write here your end point -->
								<!-- <span class="input-group-btn">
					<button class="btn" type="submit" value="Get directions" style="margin-left:0;">GET DIRECTIONS</button>
					</span>
							</div> -->
							<!-- /input-group -->
						<!-- </form>
					</div>
				</div>
			</div>
		</div> -->
		<!-- end directions-->
		
		<section class="promo_full2">
			<div class="promo_full_wp magnific">
				<div>
					<h3>A un paso del viaje de tu vida</h3>
					<h3>Junto a Viajes de Lujo</h3>
					
					<!-- <p>
						Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset, doctus volumus explicari qui ex.
					</p> -->
					<!-- <a href="https://www.youtube.com/watch?v=Zz5cu72Gv5Y" class="video"><i class="icon-play-circled2-1"></i></a> -->
				</div>
			</div>
		</section>
		
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
                        <li><a href="nosotros.html">Quines somos</a></li>
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

	<!-- Specific scripts -->
	<script src="assets/validate.js"></script>
	<!--script src="http://maps.googleapis.com/maps/api/js"></script-->
                                 
                                   
	<!--script src="js/map_contact.js"></script>
	<script src="js/infobox.js"></script-->


</body>

</html>