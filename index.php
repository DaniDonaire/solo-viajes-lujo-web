<?php
require_once __DIR__ . '/config/database.php';
$svlPrivateConfiguration = svl_configuration();
$svlRegistrationToken = isset($svlPrivateConfiguration['registration_token']) ? (string) $svlPrivateConfiguration['registration_token'] : '';
include ("include/sql.php");
include ("include/execute_sql.php");

$sql_especialidades = sql_especialidades();
$result_sql_especialidades = execute_sql($sql_especialidades);

$sql_rutas = sql_rutas();
$result_sql_rutas = execute_sql($sql_rutas);

?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html lang="es">
<script language="JavaScript" type="text/JavaScript">
	// Fonction qui permet de controler le formulaire avant de l'envoyer
	function controle1()
	{
		//alert(document.forms[0].email_newsletter_1.value);
		if (document.forms[0].email_newsletter_1.value != '')
		{
			enviarEmail(document.forms[0].email_newsletter_1.value);
		} else {
			return;
		}
	}
	function controle2()
	{
		//alert(document.newsletter_2.email_newsletter_2.value);
		if(document.newsletter_2.email_newsletter_2.value != '' ){
			enviarEmail(document.newsletter_2.email_newsletter_2.value);
		} else {
			return;
		}
	}
	
	function enviarEmail(email){
		//var email = formulario.email_contact.value;
		//alert(email);
		var dataString = 'email=' + email ;
			$.ajax({
				async:true,
				data: dataString,
				url:   'registro.php',
				type:  'POST',
				dataType: 'json',
				success:  function (data) 
				{
					if (data.success){
						alert('Registro completado.Muchas Gracias');
					} else {
						alert('No se ha podido enviar, intentalo de nuevo');
					}
				},
				error: function()
				{
					alert('Ocurrio un error en el servidor .. intentalo de nuevo');
				}
			});
	}
</script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
	<meta name="description" content="Los Mejores Viajes por el Mundo al Mejor Precio a Europa,Asia,America,Africa,EstadosUnidos,Brasil,Argentina,China,Costa-Rica,Mexico,Canada,Noruega Laponia">
	<meta name="keywords" content="solo viajes de lujo por el mundo, Viajes,Europa,Asia,America,Africa,Estados Unidos,Brasil,Argentina,China,Costa-Rica,Mexico,Canada,Artico,Noruega,Nepal,Laponia,Rusia, Paises Balticos, Perú, Australia, Nueva Zelanda, Fiji, India, Empresas: Eventos" />
	<title>Los Mejores Viajes de Lujo por el Mundo | soloviajesdelujo.com</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">
	
	<!-- Google web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Lato:300,400|Montserrat:400,400i,700,700i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Open+Sans|Roboto" rel="stylesheet"> 

    <!-- BASE CSS -->
    <link href="css/base.css" rel="stylesheet">
	
	<!-- SPECIFIC CSS >
    <link href="css/jquery.cookiebar.css" rel="stylesheet"-->

    <!-- REVOLUTION SLIDER CSS -->
    <link rel="stylesheet" type="text/css" href="rev-slider-files/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
	<link rel="stylesheet" type="text/css" href="rev-slider-files/fonts/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="rev-slider-files/css/settings.css">
    
   <!-- REVOLUTION LAYERS STYLES -->
	<style>
		.tp-caption.Travel-BigCaption,
		.Travel-BigCaption {
			color: rgba(255, 255, 255, 1.00);
			font-size: 50px;
			line-height: 50px;
			font-weight: 700;
			font-style: normal;
			text-transform: uppercase;
			text-decoration: none;
			background-color: transparent;
			border-color: transparent;
			border-style: none;
			border-width: 0px;
			border-radius: 0 0 0 0px
		}

		.tp-caption.Travel-SmallCaption,
		.Travel-SmallCaption {
			color: rgba(255, 255, 255, 1.00);
			font-size: 25px;
			line-height: 30px;
			font-weight: 400;
			font-family: "Lato";
			font-style: normal;
			text-decoration: none;
			background-color: transparent;
			border-color: transparent;
			border-style: none;
			border-width: 0px;
			border-radius: 0 0 0 0px
		}
		
		.tp-caption.NotGeneric-Title,
		.NotGeneric-Title {
			color: rgba(255, 255, 255, 1.00);
			font-size: 70px;
			line-height: 80px;
			font-weight: 800;
			font-style: normal;
			text-decoration: none;
			background-color: transparent;
			border-color: transparent;
			border-style: none;
			border-width: 0px;
			border-radius: 0 0 0 0px
		}

		.tp-caption.NotGeneric-SubTitle,
		.NotGeneric-SubTitle {
			color: rgba(255, 255, 255, 1.00);
			font-size: 13px;
			line-height: 20px;
			font-weight: 500;
			font-style: normal;
			text-decoration: none;
			background-color: transparent;
			border-color: transparent;
			border-style: none;
			border-width: 0px;
			border-radius: 0 0 0 0px;
			letter-spacing: 0px
		}

		.tp-caption.NotGeneric-CallToAction,
		.NotGeneric-CallToAction {
			color: rgba(255, 255, 255, 1.00);
			font-size: 14px;
			line-height: 14px;
			font-weight: 500;
			font-style: normal;
			text-decoration: none;
			background-color: rgba(0, 0, 0, 0);
			border-color: rgba(255, 255, 255, 0.50);
			border-style: solid;
			border-width: 0;
			border-radius: 0px 0px 0px 0px;
			letter-spacing: 0px
		}

		.tp-caption.NotGeneric-CallToAction:hover,
		.NotGeneric-CallToAction:hover {
			color: rgba(255, 255, 255, 1.00);
			text-decoration: none;
			background-color: transparent;
			border-color: rgba(255, 255, 255, 1.00);
			border-style: solid;
			border-width: 0;
			border-radius: 0px 0px 0px 0px;
			cursor: pointer
		}

		.tp-caption.NotGeneric-Icon,
		.NotGeneric-Icon {
			color: rgba(255, 255, 255, 1.00);
			font-size: 30px;
			line-height: 30px;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			background-color: rgba(0, 0, 0, 0);
			border-color: rgba(255, 255, 255, 0);
			border-style: solid;
			border-width: 0px;
			border-radius: 0px 0px 0px 0px;
			letter-spacing: 0px
		}
	</style>
	<style type="text/css">
		.hermes.tp-bullets {}

		.hermes .tp-bullet {
			overflow: hidden;
			border-radius: 50%;
			width: 16px;
			height: 16px;
			background-color: rgba(0, 0, 0, 0);
			box-shadow: inset 0 0 0 2px rgb(255, 255, 255);
			-webkit-transition: background 0.3s ease;
			transition: background 0.3s ease;
			position: absolute
		}

		.hermes .tp-bullet:hover {
			background-color: rgba(0, 0, 0, 0.21)
		}

		.hermes .tp-bullet:after {
			content: ' ';
			position: absolute;
			bottom: 0;
			height: 0;
			left: 0;
			width: 100%;
			background-color: rgb(255, 255, 255);
			box-shadow: 0 0 1px rgb(255, 255, 255);
			-webkit-transition: height 0.3s ease;
			transition: height 0.3s ease
		}

		.hermes .tp-bullet.selected:after {
			height: 100%
		}
		
		#mc_embed_signup input#email_newsletter_1 {
			font-family: "Montserrat", Arial, sans-serif;
			font-size: 15px;
			color: #000;
			background-color: #fff;
			line-height: 46px;
			padding: 0 20px;
			cursor: text;
			border: 0;
			width: 400px;
			margin-bottom: 0px;
			-webkit-transition: background-color 0.5s;
			-moz-transition: background-color 0.5s;
			-o-transition: background-color 0.5s;
			-ms-transition: background-color 0.5s;
			transition: background-color 0.5s;
			-webkit-border-radius: 0px;
			-moz-border-radius: 0px;
			border-radius: 0px
		}

		#mc_embed_signup input#email_newsletter_1[type="email"]:focus {
			background-color: #f5f5f5
		}

		#mc_embed_signup input#mc-embedded-subscribe,
		#mc_embed_signup input#mc-embedded-subscribe:focus {
			font-family: "Montserrat", Arial, sans-serif;
			line-height: 46px;
			letter-spacing: 0px;
			text-transform: uppercase;
			font-size: 15px;
			font-weight: 400;
			padding: 0 20px;
			border: 0;
			background: #ffab40;
			color: #fff;
			-webkit-border-radius: 0px;
			-moz-border-radius: 0px;
			border-radius: 0px
		}

		#mc_embed_signup input#mc-embedded-subscribe:hover {
			background: #fff;
			color: #ffab40
		}

		@media only screen and (max-width: 767px) {
			#mc_embed_signup input#email_newsletter_1 {
				width: 120px
			}
		}
	</style>

    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
	<!-- Event snippet for Vista de una página conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-366659895/wRQ1CICSzf0bELeS664B',
      'value': 1.0,
      'currency': 'EUR'
  });
</script>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-366659895"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-366659895');
</script>


	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-197221152-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-197221152-1');
	</script>
<!-- Event snippet for Vista de una página conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-366659895/wRQ1CICSzf0bELeS664B',
      'value': 1.0,
      'currency': 'EUR',
      'event_callback': callback
  });
  return false;
}
</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P53P964T');</script>
<!-- End Google Tag Manager -->
</head>

<body>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P53P964T"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
							<li>
                            </li>
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
							<li><a href="#destinos" >Principales destinos</a></li>
							<li><a href="#rutas" >Rutas</a></li>
							<li><a href="#cruceros" >Cruceros</a></li>
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
	
	<main>
		<div id="rev_slider_22_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="travel-static-captions1" data-source="gallery" style="margin:0px auto;background:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
			<!-- START REVOLUTION SLIDER 5.4.1 auto mode -->
			<div id="rev_slider_22_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.1">
				<ul>
					<!-- SLIDE  -->
					<li data-index="rs-69" data-transition="parallaxhorizontal" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="rev-slider-files/assets/100x50_travel1.jpg" data-rotate="0" data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off" data-title="Number One" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
						<!-- MAIN IMAGE -->
						<img src="rev-slider-files/assets/svl1.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
						<!-- LAYERS -->
					</li>
					<!-- SLIDE  -->
					<li data-index="rs-70" data-transition="parallaxhorizontal" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="rev-slider-files/assets/100x50_travel2.jpg" data-rotate="0" data-saveperformance="off" data-title="Number Two" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
						<!-- MAIN IMAGE -->
						<img src="rev-slider-files/assets/svl2.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
						<!-- LAYERS -->
					</li>
					<!-- SLIDE  -->
					<li data-index="rs-71" data-transition="parallaxhorizontal" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="rev-slider-files/assets/100x50_travel3.jpg" data-rotate="0" data-saveperformance="off" data-title="Number Three" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
						<!-- MAIN IMAGE -->
						<img src="rev-slider-files/assets/svl3.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
						<!-- LAYERS -->
					</li>
					<!-- SLIDE  -->
					<li data-index="rs-72" data-transition="parallaxhorizontal" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="rev-slider-files/assets/100x50_travel4.jpg" data-rotate="0" data-saveperformance="off" data-title="Number Four" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
						<!-- MAIN IMAGE -->
						<img src="rev-slider-files/assets/svl4.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
						<!-- LAYERS -->
					</li>
					<!-- SLIDE  -->
					<li data-index="rs-73" data-transition="parallaxhorizontal" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="rev-slider-files/assets/100x50_travel4.jpg" data-rotate="0" data-saveperformance="off" data-title="Number Five" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
						<!-- MAIN IMAGE -->
						<img src="rev-slider-files/assets/svl5.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
						<!-- LAYERS -->
					</li>
					<!-- SLIDE  -->
					<li data-index="rs-74" data-transition="parallaxhorizontal" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="rev-slider-files/assets/100x50_travel4.jpg" data-rotate="0" data-saveperformance="off" data-title="Number Six" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
						<!-- MAIN IMAGE -->
						<img src="rev-slider-files/assets/svl6.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
						<!-- LAYERS -->
					</li>
				</ul>
				<div style="" class="tp-static-layers">
						
						<!-- LAYER NR. 3 -->
						<div class="tp-caption NotGeneric-Title   tp-resizeme tp-static-layer" id="slide-134-layer-1" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['-95','-90','-120','-50']" data-fontsize="['56','56','56','56']" data-lineheight="['46','46','50','45 ']" data-fontweight="['700','700','700','700']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-startslide="0" data-endslide="6" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"z:0;rX:0deg;rY:0;rZ:0;sX:1.5;sY:1.5;skX:0;skY:0;opacity:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]' data-textAlign="['center','center','center','center']" data-paddingtop="[10,10,10,10]" data-paddingright="[0,0,0,0]" data-paddingbottom="[10,10,10,10]" data-paddingleft="[3,3,3,3]" style="z-index: 7; white-space: nowrap; font-size: 46px; line-height: 46px; font-weight: 700;font-family:Great Vibes;">Pide 3 Deseos</div>

						<!-- LAYER NR. 4 -->
						<div class="tp-caption NotGeneric-SubTitle   tp-resizeme tp-static-layer" id="slide-134-layer-4" data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" data-y="['middle','middle','middle','middle']" data-voffset="['-15','-30','-35','28']" data-fontsize="['25','20','20','20']" data-lineheight="['33','33','33','33 ']" data-fontweight="['600','600','600','600']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-startslide="0" data-endslide="6" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:[100%];s:inherit;e:inherit;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]' data-textAlign="['center','center','center','center']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 7; white-space: nowrap; line-height: 22px; font-weight: 400;font-family:Open sans;">
						Hacer el viaje de mis sueños
						<br>
						Único para mí y los míos
						<br>
						Con un Servicio y Exclusividad Garantizada
						</div>

						<!-- LAYER NR. 5 -->
						<div class="tp-caption NotGeneric-CallToAction tp-static-layer" id="slide-134-layer-11" data-x="['center','center','center','center']" data-hoffset="['0','0','0','-1']" data-y="['top','top','top','top']" data-voffset="['394','336','350','350']" data-fontsize="['15','15','15','12']" data-fontweight="['400','500','500','400']" data-width="none" data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on" data-responsive="off" data-startslide="0" data-endslide="6" data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"opacity:0;","ease":"Power2.easeInOut"}]' data-textAlign="['left','center','center','center']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 12; white-space: nowrap; font-weight: 400;font-family:Open sans;cursor:default;">
							<div id="mc_embed_signup">
								<form action="contacto.php" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate">
									<input type="hidden" name="clau" value="<?php echo htmlspecialchars($svlRegistrationToken, ENT_QUOTES, 'UTF-8'); ?>">
									<label for="formGroupExampleInput">Para acceder a nuestros mejores viajes !apúntate ya!</label>
									<div id="mc_embed_signup_scroll">
										<!--input type="email" value="" name="email_newsletter_1" id="email_newsletter_1" class="email" placeholder="Tu correo electrónico" required-->
										<!--input type="email" value="" name="email_newsletter_1" class="email" id="email_newsletter_1" placeholder="Tu correo electrónico" required>
										<div style="position: absolute; left: -5000px;">
											<input type="text" name="b_a5738148e5ec630766e28de16_3e718acc63" tabindex="-1" value="">
										</div-->
										<input type="submit" value="Recibir ofertas" name="subscribe" id="mc-embedded-subscribe" class="button">
									</div>
									<!--div class="form-check">
											<input class="form-check-input" type="checkbox" id="gridCheck">
											<label class="form-check-label" for="gridCheck">
													Deseo recibir las news actualizadas	
											</label>
											
									</div-->
								</form>
							</div>
						</div>
					
				</div>
				<div class="tp-bannertimer tp-bottom" style="height: 7px; background: rgba(255,255,255,0.25);"></div>
			</div>
		</div>
		<!-- END REVOLUTION SLIDER -->
		
		
<a name="destinos"></a>
		<div class="container margin_60">

			<div class="main_title">
				<h2>Principales <span>Destinos</span></h2>
				<p>Solo Viajes de Lujo te brinda los mejores Destinos</p>
			</div>

			<div class="row">

				<?php
				$cont=0;
				while($RS = mysqli_fetch_array($result_sql_especialidades)) {
						$id_pais = $RS["id_pais"];
						$imagen_pais = $RS["imagen_pais"];
						$nombre_pais = $RS["nombre_pais"];
						$nombre_pagina_pais = $RS["nombre_pagina_pais"];
						$cont++;	
				?>
				<div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.<? echo "$cont"; ?>s">
					<div class="tour_container">
						
						<div class="img_container">
							<a href="destinos/<? echo "$nombre_pagina_pais"; ?>/destinos-<? echo "$nombre_pagina_pais"; ?>.php?id=<? echo "$id_pais"; ?>">
								<img src="destinos/img/<? echo "$imagen_pais"; ?>" class="img-responsive" alt="<? echo "$nombre_pais"; ?>" style="width:400px;height:250px;">
								<div class="short_info">
									<i class="icon_set_1_icon-44"></i><? echo "$nombre_pais"; ?><span class="price"><sup></sup></span>
								</div>
							</a>
						</div>
						<div class="tour_title">
							<h3><strong><? echo "$nombre_pais"; ?></strong></h3>
							<!-- end rating -->
							<!--div class="wishlist">
								<a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Lista de Deseos</span></span></a>
							</div-->
							<!-- End wish list-->
						</div>
					</div>
					<!-- End box tour -->
				</div>
				<?php }	?>

			</div>
			<!-- End row -->
			<!--p class="text-center add_bottom_30">
				<a href="principales-destinos.html" class="btn_1 medium"><i class="icon-eye-7"></i>Ver Destinos </a>
			</p-->

			<hr>

			<a name="rutas"></a>
			<div class="main_title">
				<h2>Algunas de Nuestras <span>Rutas</span></h2>
				<p>Tenemos los mejores planes para ti y los tuyos, con nuestros itinerarios a medida, totalmente exclusivas. Descúbrelas!</p>
			</div>

			<div class="row">

				<?php
				$cont=0;
				while($RS = mysqli_fetch_array($result_sql_rutas)) {
						$id_lanzamiento = $RS["id_lanzamiento"];
						$id_news = $RS["id_news"];
						$imagen = $RS["imagen"];
						$titulo = substr($RS["titulo"],0,78);
						$destino = $RS["nombre_pagina_destino"];
						$cont++;	
				?>
				<div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.<? echo "$cont"; ?>s">
					<div class="hotel_container">
						<div class="img_container">
							<a href="viajes/<? echo "$destino"; ?>/viaje-<? echo "$destino"; ?>.php?id_viaje=<? echo "$id_news"; ?>">
								<img src="newsletter/images/<? echo "$id_lanzamiento"; ?>/<? echo "$imagen"; ?>" width="800" height="533" class="img-responsive" alt="<? echo "$destino"; ?>" style="width:400px;height:250px;">
								<div class="short_info hotel">
								</div>
							</a>
						</div>
						<div class="hotel_title">
							<h4><strong><? echo "$titulo"; ?></strong> </h4>
							<!--div class="rating">
								<i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i>
							</div-->
						</div>
					</div>
					<!-- End box -->
				</div>
				<!-- End col-md-4 -->
			<?php }	?>
		</div><!-- End container -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 nopadding features-intro-img">
					<div class="features-bg">
						<div class="features-img">
						</div>
					</div>
				</div>
				<div class="col-md-6 nopadding">
					<div class="features-content">
						<h3>Viajes para Empresas</h3>
						<p>
							Porque cada Perfil es único y es así como queremos que se sientan con nosotros, para que nuestra empresa se convierta en su referente de marca, para que la huella de nuestro evento perdure en el tiempo, para que la ilusión esté presente antes durante y después. El objetivo su objetivo, fidelizar de forma indefinida.
						</p>
						<br>
						<p>
							Para todo ello disponemos de los mejores profesionales, nuestra experiencia abarca todos los ámbitos.
						</p>
						<p>
							<a href="viajes-empresas.html" class=" btn_1 white">Más Información</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		
		<a name="cruceros"></a>
		<div class="white_bg">
			<div class="container margin_60">
				<div class="main_title">
					<h2>Los <span>Mejores</span> Cruceros</h2>
					<p>
						Disfruta el placer del Mar con los cruceros mpas exclusivos.
					</p>
				</div>
				
				<!-- End row -->

				<div class="row">
					<div class="col-md-4 col-sm-6 text-center">
						<p>
							<a href="#"><img src="img/crucero1.jpg" alt="Pic" class="img-responsive"></a>
						</p>
						<h4><span>Wind</span> Star</h4>
						<p>
							Una de las mejores flotas de cruceros de lujo del mundo. Sus seis yates transportan entre 148 y 310 pasajeros y realizan cruceros a más de 50 naciones.
						</p>
					</div>
					<div class="col-md-4 col-sm-6 text-center">
						<p>
							<a href="#"><img src="img/crucero2.jpg" alt="Pic" class="img-responsive"></a>
						</p>
						<h4><span>Seabourn  </span>Mediterraneo</h4>
						<p>
							Seabourn, la compañía de ultra lujo del grupo Carnival, fue galardonada como la mejor compañía de Cruceros Pequeños de Lujo.
						</p>
					</div>
					<div class="col-md-4 col-sm-6 text-center">
						<p>
							<a href="#"><img src="img/crucero3.jpg" alt="Pic" class="img-responsive"></a>
						</p>
						<h4><span>Disney</span> Cruices</h4>
						<p>
							Exclusiva línea de buques diseñado por Walt Disney Imagineering. Fantasía y diversión garantizada para toda la familia. 
						</p>
					</div>
					<div class="col-md-4 col-sm-6 text-center">
						<p>
							<a href="#"><img src="img/crucero4.jpg" alt="Pic" class="img-responsive"></a>
						</p>
						<h4><span>Lujo en </span>Alaska</h4>
						<p>
							Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset, doctus volumus explicari qui ex.
						</p>
					</div>
					<div class="col-md-4 col-sm-6 text-center">
						<p>
							<a href="#"><img src="img/crucero5.jpg" alt="Pic" class="img-responsive"></a>
						</p>
						<h4><span>Crucero por el </span> Caribe</h4>
						<p>
							Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset, doctus volumus explicari qui ex.
						</p>
					</div>
					<div class="col-md-4 col-sm-6 text-center">
						<p>
							<a href="#"><img src="img/crucero6.jpg" alt="Pic" class="img-responsive"></a>
						</p>
						<h4><span>Cruceros de</span> Lujo</h4>
						<p>
							Sólo viajes Lujo. Excelente servicio personalizado. Disponemos de corresponsales en todo el mundo. Los mejores Cruceros
						</p>
					</div>
				</div>
				<!-- End row -->
				<p class="text-center nopadding">
					<a href="cruceros.html" class="btn_1 medium"><i class="icon-eye-7"></i>Nuestra Selección</a>
				</p>
			</div>
			<!-- End container -->
			
		</div>
		<!-- End white_bg -->
		
		<section class="promo_full">
			<div class="promo_full_wp magnific">
				<div>
					<br>
					<br>
					<h3>¿Sabes qué es un Full Charter?</h3>
					<a href="buques-exclusiva.html" class="btn_1 white">Conoce más</a>
					<br>
					<br>
					<!-- <p>
						Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset, doctus volumus explicari qui ex.
					</p> -->
					<!-- <a href="https://www.youtube.com/watch?v=Zz5cu72Gv5Y" class="video"><i class="icon-play-circled2-1"></i></a> -->
				</div>
			</div>
		</section>
		<!-- End section -->

		<div class="container margin_60">

			<div class="main_title">
				<h2>Razones de <span>Lujo</span></h2>
				<p>
					Quisque at tortor a libero posuere laoreet vitae sed arcu. Curabitur consequat.
				</p>
			</div>

			<div class="row">

				<div class="col-md-4 wow zoomIn" data-wow-delay="0.2s">
					<div class="feature_home">
						<i class="icon_set_1_icon-41"></i>
						<h3>Destinos <span>Exclusivos</span></h3>
						<!-- <p>
							Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset.
						</p> -->
						<a href="#destinos" class="btn_1 outline">Más Información</a>
					</div>
				</div>

				<div class="col-md-4 wow zoomIn" data-wow-delay="0.4s">
					<div class="feature_home">
						<i class="icon_set_1_icon-30"></i>
						<h3>Rutas <span>Increíbles</span></h3>
						<!-- <p>
							Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset.
						</p> -->
						<a href="#rutas" class="btn_1 outline">Más Información</a>
					</div>
				</div>

				<div class="col-md-4 wow zoomIn" data-wow-delay="0.6s">
					<div class="feature_home">
						<i class="icon_set_1_icon-57"></i>
						<h3><span>La mejor</span> Atención</h3>
						<!-- <p>
							Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset.
						</p> -->
						<a href="contacto.php" class="btn_1 outline">Más Información</a>
					</div>
				</div>

			</div>
			<!--End row -->

			<hr>

			<div class="row">
				<div class="col-md-6 col-sm-6 hidden-xs">
					<img src="img/laptop.png" alt="Laptop" class="img-responsive laptop">
				</div>
				<div class="col-md-6 col-sm-6">
				  <div class="main_title">
					<h2><span>Vacaciones a</span> Medida</h2>
				  </div> 	
					<p>
						Cuéntanos el viaje de tu vida y lo haremos realidad, en cualquier lugar del mundo, ¿Por qué? Porque somos diferentes y queremos ser únicos como tu.
					</p>
					<ul class="list_order">
						<li><span>1</span>Selecciona tu destino</li>
						<li><span>2</span>Escoge las fechas</li>
						<li><span>3</span>Contáctanos y nos encargaremos del resto</li>
					</ul>
					<a href="#destinos" class="btn_1">Quiero mi Viaje</a>
				</div>
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
					<p><img src="img/logo.png" width="152" height="69" alt="Solo Viajes de Lujo" data-retina="true" id="logo">
					</p>
					<p>Somos especialistas en Turismo, más de 25 años de experiencia en el sector turístico nos avalan. Nuestro objetivo ofrecer a nuestros clientes las mejores alternativas y servicio totalmente desarrollado a medida de sus necesidades</p>
				</div>
                <div class="col-md-2 col-sm-3">
                    <h3>Mapa del Sitio</h3>
                    <ul>
                        <li><a href="nosotros.html">Quienes somos</a></li>
                        <li><a href="#rutas">Rutas</a></li>
                        <li><a href="#cruceros">Cruceros</a></li>
                        <li><a href="ofertas-exclusivas.php">Ofertas exclusivas</a></li>
						<li><a href="#">Viajes empresas</a></li>
						<li><a href="#">Fullcharter</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
						<li><a href="terminos-condiciones.html">Términos y condiciones</a></li>
						<li><a href="politica-privacidad.html">Política de privacidad</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6" id="newsletter">
					<h3>Newsletter</h3>
					<p>Suscríbete a las mejores ofertas.</p>
					<div id="message-newsletter_2"></div>
					<form method="post" action="contacto.php" name="newsletter_2" id="newsletter_2" >
						<input type="hidden" name="clau" value="<?php echo htmlspecialchars($svlRegistrationToken, ENT_QUOTES, 'UTF-8'); ?>">	
						<div class="form-group">
							<!--input name="email_newsletter_2" id="email_newsletter_2" type="email" value="" class="form-control" placeholder="Tu correo electrónico" required-->
						</div>
						<!--input type="submit" value="Suscribirme	" class="btn_1" id="submit-newsletter_2"-->
						<input type="submit" value="Suscribirme	" class="btn_1" id="">
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
                            <li><a href="#"><i class="icon-google"></i></a></li> 
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

    <!-- SLIDER REVOLUTION SCRIPTS  -->
    <script type="text/javascript" src="rev-slider-files/js/jquery.themepunch.tools.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/jquery.themepunch.revolution.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.actions.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.carousel.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.kenburn.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.layeranimation.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.migration.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.navigation.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.parallax.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.slideanims.min.js"></script>
	<script type="text/javascript" src="rev-slider-files/js/extensions/revolution.extension.video.min.js"></script>
	<script type="text/javascript">
		var tpj = jQuery;
		var revapi22;
		var revapi52;
		
		tpj(document).ready(function () {
			if (tpj("#rev_slider_22_1").revolution == undefined) {
				revslider_showDoubleJqueryError("#rev_slider_22_1");
			} else {
				revapi22 = tpj("#rev_slider_22_1").show().revolution({
					sliderType: "standard",
					jsFileLocation: "rev-slider-files/js/",
					sliderLayout: "auto",
					dottedOverlay: "none",
					delay: 6000,
					navigation: {
						keyboardNavigation: "off",
						keyboard_direction: "horizontal",
						mouseScrollNavigation: "off",
						mouseScrollReverse: "default",
						onHoverStop: "off",
						touch: {
							touchenabled: "on",
							touchOnDesktop: "off",
							swipe_threshold: 75,
							swipe_min_touches: 1,
							swipe_direction: "horizontal",
							drag_block_vertical: false
						},
						bullets: {
							enable: true,
							hide_onmobile: true,
							hide_under: 600,
							style: "hermes",
							hide_onleave: true,
							hide_delay: 200,
							hide_delay_mobile: 1200,
							direction: "vertical",
							h_align: "right",
							v_align: "center",
							h_offset: 30,
							v_offset: 0,
							space: 5,
							tmp: ''
						}
					},
					viewPort: {
						enable: true,
						outof: "pause",
						visible_area: "80%",
						presize: false
					},
					responsiveLevels: [1240, 1024, 778, 480],
					visibilityLevels: [1240, 1024, 778, 480],
					gridwidth: [1240, 1024, 778, 480],
					gridheight: [650, 500, 600, 500],
					lazyType: "none",
					parallax: {
						type: "mouse",
						origo: "slidercenter",
						speed: 2000,
						levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 47, 48, 49, 50, 51, 55],
					},
					shadow: 0,
					spinner: "off",
					stopLoop: "off",
					stopAfterLoops: -1,
					stopAtSlide: -1,
					shuffle: "off",
					autoHeight: "off",
					hideThumbsOnMobile: "off",
					hideSliderAtLimit: 0,
					hideCaptionAtLimit: 0,
					hideAllCaptionAtLilmit: 0,
					debugMode: false,
					fallbacks: {
						simplifyAll: "off",
						nextSlideOnWindowFocus: "off",
						disableFocusListener: false,
					}
				});
			}
		}); /*ready*/
		
		tpj(document).ready(function () {
			if (tpj("#rev_slider_52_1").revolution == undefined) {
				revslider_showDoubleJqueryError("#rev_slider_52_1");
			} else {
				revapi52 = tpj("#rev_slider_52_1").show().revolution({
					sliderType: "hero",
					jsFileLocation: "rev-slider-files/js/",
					sliderLayout: "fullwidth",
					dottedOverlay: "none",
					delay: 9000,
					navigation: {},
					responsiveLevels: [1240, 1024, 778, 480],
					visibilityLevels: [1240, 1024, 778, 480],
					gridwidth: [1240, 1024, 778, 480],
					gridheight: [650, 500, 420, 420],
					lazyType: "none",
					parallax: {
						type: "mouse",
						origo: "slidercenter",
						speed: 2000,
						levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 47, 48, 49, 50, 51, 55],
					},
					shadow: 0,
					spinner: "off",
					autoHeight: "off",
					disableProgressBar: "on",
					hideThumbsOnMobile: "off",
					hideSliderAtLimit: 0,
					hideCaptionAtLimit: 0,
					hideAllCaptionAtLilmit: 0,
					debugMode: false,
					fallbacks: {
						simplifyAll: "off",
						disableFocusListener: false,
					}
				});
			}
		}); /*ready*/
	</script>

	<!-- Cookie bar script >
    <script src="js/jquery.cookiebar.js"></script>
    <script>
		$(document).ready(function(){
		'use strict';
		 $.cookieBar({
			fixed: true
		});
		});
	</script-->
	
</body>

</html>