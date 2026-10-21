<?php		
if ($_POST["g-recaptcha-response"] == "" or $_POST["g-recaptcha-response"] == " " or is_null($_POST["g-recaptcha-response"])){
	header('Location:https://www.soloviajesdelujo.com');
	exit();
}

include ("include/sql.php");
include ("include/execute_sql.php");
  
$id = "";
$nombre = "";
$email = "";
$destino = "";
$fecha = "";
$ciudad_inicial = "";
$lastname_contact = "";
$lastname_contact2 = "";
$phone_contact = "";
$message_contact = "";
$adultos = "";
$ninos = "";
$hora_recordatorio = "";
$vuelo = "";
$vuelo = "";
$ip_address = get_ip();

if ($_POST["id"] != ""){
	$id = $_POST["id"];
}
if ($_POST["name_contact"] != ""){
	$nombre = $_POST["name_contact"];
}
if ($_POST["email_contact"] != ""){
	$email = $_POST["email_contact"];
}
if ($_POST["destino"] != ""){
	$destino = $_POST["destino"];
}
if ($_POST["fecha-viaje"] != ""){
	$fecha = $_POST["fecha-viaje"];
}
if ($_POST["ciudad_inicial"] != ""){
	$ciudad_inicial = $_POST["ciudad_inicial"];
}
if ($_POST["lastname_contact"] != ""){
	$lastname_contact = $_POST["lastname_contact"];
}
if ($_POST["lastname_contact2"] != ""){
	$lastname_contact2 = $_POST["lastname_contact2"];
}
if ($_POST["phone_contact"] != ""){
	$phone_contact = $_POST["phone_contact"];
}
if ($_POST["message_contact"] != ""){
	$message_contact = $_POST["message_contact"];
}
if ($_POST["exampleSelect1"] != ""){
	$adultos = $_POST["exampleSelect1"];
}
if ($_POST["exampleSelect2"] != ""){
	$ninos = $_POST["exampleSelect2"];
}
if ($_POST["exampleSelect3"] != ""){
	$hora_recordatorio = $_POST["exampleSelect3"];
}
if ($_POST["inlineRadio1"] != ""){
	$vuelo = $_POST["inlineRadio1"];
}
else if ($_POST["inlineRadio2"] != ""){
	$vuelo = $_POST["inlineRadio2"];
}

function get_ip() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	elseif(isset($_SERVER['HTTP_CLIENT_IP']))
		$ip  = $_SERVER['HTTP_CLIENT_IP'];
	else
		$ip = $_SERVER['REMOTE_ADDR'];
	return $ip;
}


$fecha_sistema = date('Y-m-d H:i:s');

$sql_insert_presupuesto = sql_insert_presupuesto($id,$destino,$fecha,$adultos,$ninos,$vuelo,$ciudad_inicial,$nombre,$lastname_contact,$lastname_contact2,$phone_contact,$email,$hora_recordatorio,$message_contact,$fecha_sistema,$ip_address);
$idPrep= execute_insert_sql($sql_insert_presupuesto);

$sql_insert_peticion = sql_insert_peticion($idPrep ,$fecha_sistema ,md5($email) ,$ip_address);
execute_sql($sql_insert_peticion);

// Traitement de la date
setlocale(LC_TIME, 'es_ES');
$form_vuelo = '';
if ($vuelo == '1')
	$form_vuelo = 'si';
else
	$form_vuelo = 'no';

$search = array('$nombre', '$email', '$destino','$comenzando_fecha', '$ciudad', '$apellido_1','$apellido_2', '$phone', '$message_contact','$hora_recordatorio','$adulto','$ninos','$tarifas_nombre','$vuelo','$compania','$buque');
$replace = array( $nombre, $email, $destino, $fecha, $ciudad_inicial, $lastname_contact, $lastname_contact2, $phone_contact, $message_contact, $hora_recordatorio, $adultos, $ninos, ' ', $form_vuelo, ' ', '');

// *****************************
// Envoye du mail pour le client
// *****************************

$html = file_get_contents('templates/email_presupuesto_client.html');
$html = str_replace($search, $replace, $html);

$sujet_client = 'Demanda de presupuesto personalizado';

$message = $message_client_html;
$titulo = "Demanda de presupuesto personalizado";

$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
$cabeceras .= 'To: <$email>' . "\r\n";
$cabeceras .= 'From: Soloviajesdelujo.com <info@soloviajesdelujo.com>' . "\r\n";
$cabeceras .= 'Cc:  Soloviajesdelujo <info@soloviajesdelujo.com>' . "\r\n";

mail($email, $titulo, $html, $cabeceras);
	
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="description" content="olo Viajes de Lujo - Viajes De lujo, Exclusivos, para Empresas, Safaris, Islas Mauricio, Tanzania, Botswana, Namibia, Sudafrica">
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

	<!-- Radio and check inputs -->
	<link href="css/skins/square/grey.css" rel="stylesheet">

</head>

<body>

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

	<section id="hero_2">
		<div class="intro_title animated fadeInDown">
			<h1>Informacion enviada un consultor de soloviajesdelujo se pondra en contacto con usted</h1>
			<!--div class="bs-wizard">

				<div class="col-xs-4 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum">Pedido</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="cart.html" class="bs-wizard-dot"></a>
				</div>

				<div class="col-xs-4 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum">Detalles de Pago</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="payment.html" class="bs-wizard-dot"></a>
				</div>

				<div class="col-xs-4 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum">Final!</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
				</div>

			</div-->
			<!-- End bs-wizard -->
		</div>
		<!-- End intro-title -->
	</section>
	<!-- End Section hero_2 -->

	<main>

		<!-- End position -->

		<div class="container margin_60">
			<div class="row">
				<div class="col-md-8 add_bottom_15">

					<div class="form_title">
						<h3><strong><i class="icon-ok"></i></strong>Gracias por su pedido de viaje!</h3>
					</div>
					<div class="step">
						<p>
							Le agradecemos su confianza<br/>
							Un consultor de soloviajesdelujo se pondra en contacto con usted
						</p>
					</div>
					<!--End step -->

					<div class="form_title">
						<h3><strong><i class="icon-tag-1"></i></strong>Resumen de pedido</h3>
					</div>
					<div class="step">
						<table class="table confirm">
							<!--thead>
								<tr>
									<th colspan="2">
										Item 1
									</th>
								</tr>
							</thead-->
							<tbody>
								<tr>
									<td>
										<strong>Destino</strong>
									</td>
									<td>
										<? echo "$destino"; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Fecha salida</strong>
									</td>
									<td>
										<? echo "$fecha"; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Viajero</strong>
									</td>
									<td>
										<? echo "$nombre".' '."$lastname_contact".' '."$lastname_contact2"; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Email</strong>
									</td>
									<td>
										<? echo "$email"; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong>Telefono</strong>
									</td>
									<td>
										<? echo "$phone_contact"; ?>
									</td>
								</tr>								
							</tbody>
						</table>
						<!--table class="table confirm">
							<thead>
								<tr>
									<th colspan="2">
										Item 2
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<strong>Senna river tour</strong>
									</td>
									<td>
										2x
									</td>
								</tr>
								<tr>
									<td>
										<strong>Fecha regreso</strong>
									</td>
									<td>
										30 Junio 2018
									</td>
								</tr>
								<tr>
									<td>
										<strong>Viajero 2</strong>
									</td>
									<td>
										Jhon Doe
									</td>
								</tr>
								<tr>
									<td>
										<strong>Tipo de pago</strong>
									</td>
									<td>
										Tarjeta de Crédito
									</td>
								</tr>
							</tbody>
						</table-->
					</div>
					<!--End step -->
				</div>
				<!--End col-md-8 -->

				<aside class="col-md-4">
					<!--div class="box_style_1">
						<h3 class="inner">Felicidades!</h3>
						<p>
							Nihil inimicus ex nam, in ipsum dignissim duo. Tale principes interpretaris vim ei, has posidonium definitiones ut. Duis harum fuisset ut his, duo an dolor epicuri appareat.
						</p>
						<hr>
						<a class="btn_full_outline" href="invoice.html" target="_blank">Ver factura</a>
					</div-->
					<div class="box_style_4">
						<i class="icon_set_1_icon-57"></i>
						<h4><span>Consultas?</span></h4>
						<a href="tel:+34 610461529" class="phone">+34 610461529</a>
						<small>Lunes a viernes 9.00am - 7.30pm</small>
					</div>
				</aside>

			</div>
			<!--End row -->
		</div>
		<!--End container -->
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

	<!-- Jquery -->
	<script src="js/jquery-2.2.4.min.js"></script>
	<script src="js/common_scripts_min.js"></script>
	<script src="js/functions.js"></script>

	<script src="js/icheck.js"></script>
	<script>
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-grey',
			radioClass: 'iradio_square-grey'
		});
	</script>





</body>

</html>