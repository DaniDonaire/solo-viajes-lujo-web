<?php
include ("../../include/sql.php");
include ("../../include/execute_sql.php");

if ($_GET["id_lanza"] != ""){
	$id_lanza = $_GET["id_lanza"];
}
else {
	$id_lanza = 1;
}
if ($_GET["idioma"] != ""){
	$idioma = $_GET["idioma"];
}
else {
	$idioma = 'es';
}
$sql_all_news_lanza = sql_all_news_lanza($id_lanza);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es-es">
<head>
        
<meta property="og:title" content="<? echo "$titulo"; ?>">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">       
		<link rel="StyleSheet" href="css/estilos.css" type="text/css"> 
    	<!-- NAME: 1 COLUMN -->
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><? echo "$titulo"; ?></title>
        
		
</head> 
<body id="archivebody" style="margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #F2F2F2;height: 100% !important;width: 100% !important;" offset="0" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"> 
    <center>
		<table id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 0;background-color: #F2F2F2;height: 100% !important;width: 100% !important;" height="100%" align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td id="bodyCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 20px;border-top: 0;height: 100% !important;width: 100% !important;" align="center" valign="top">
						<!-- BEGIN TEMPLATE // -->
						<table id="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;" width="600" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr>
								<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" align="center" valign="top">
									<!-- BEGIN PREHEADER // -->
									<table id="templatePreheader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;min-width: 100%;background-color: #011F29;border-top: 0;border-bottom: 0;" width="600" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td class="preheaderContainer" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
												<table class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
												<tbody class="mcnTextBlockOuter">
													<tr>
														<td class="mcnTextBlockInner" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">

															<table style="max-width: 390px;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer" align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
															<tbody><tr><td><img alt="" src="images/logo.png" width="150"></td></tr>
															<tr>
																<td class="mcnTextContent" style="padding-top: 0;padding-left: 18px;padding-bottom: 9px;padding-right: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #FFFFFF;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;" valign="top">Las ideas m&aacute;s exclusivas para tu pr&oacute;ximo Gran Viaje de la mano de <a href="http://www.soloviajesdelujo.com" target="_blank" style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #FFFFFF;font-weight: normal;text-decoration: underline;">soloviajesdelujo.com</a>
																</td>
																</tr>
															</tbody></table>

															<table style="max-width: 210px;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer" align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
															<tbody>
																<tr>
																<td class="mcnTextContent" style="padding-top: 0;padding-left: 18px;padding-bottom: 9px;padding-right: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;" valign="top">
									
																<div style="text-align: right;">
																	<a href="http://www.soloviajesdelujo.com/newsletter/ofertas/news-agencias.php?id_lanza=<? echo "$id_lanza"; ?>" target="_blank" style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #FFFFFF;font-weight: normal;text-decoration: underline;">Abre el mail en tu navegador</a><br>
																	<!--a href="#" target="_blank" style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-weight: normal;text-decoration: underline;">Descarga el pdf</a-->
																</div>
																</td>
																</tr>
															</tbody>
															</table>

														</td>
													</tr>
													</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
												
								</td>
							</tr>
							<tr>
								<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" align="center" valign="top">
									<!-- BEGIN HEADER // -->
									<?php
											$result_sql_all_news = execute_sql($sql_all_news_lanza);
											while($RS = mysqli_fetch_array($result_sql_all_news)) {
													$id_new = $RS["id_news"];
													$titulo = $RS["titulo"];
													$imagen = $RS["imagen"];
													$texto = $RS["texto"];
													$texto = preg_replace('@(\[web=([^\]]*)]([^\]]*)\[\/web\])@', '<a href="\2" class="estilolink" target="_blank">\3</a>', $texto);
													$texto = preg_replace('@(\[web=([^\]]*)]([^\]]*)\[\/web\])@', '<a href="\2" class="estilolink" target="_blank">\3</a>', $texto);
													$destino = $RS["destino"];
													$nombre_pagina_destino = $RS["nombre_pagina_destino"];
													$id_lanzamiento_imagen = $RS["id_lanzamiento_imagen"];
									 ?>
									<table id="templateHeader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;min-width: 100%;background-color: #011F29;border-top: 0;border-bottom: 0;" width="600" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td class="headerContainer" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
													<table class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
													<tbody class="mcnImageBlockOuter">
													<h1 align="center" style="color: #FFFFFF;"><? echo "$titulo"; ?></h1>
													<tr>
														<td style="padding: 0px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner" valign="top">
															<table class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
																<tbody>
																	<tr>
																		<td class="mcnImageContent" style="padding-right: 0px;padding-left: 0px;padding-top: 0;padding-bottom: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
																		<img alt="" src="../images/<? echo "$id_lanzamiento_imagen"; ?>/<? echo "$imagen"; ?>" style="max-width: 1240px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage" align="left" width="600">
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													</tbody>
													</table>
													<table class="mcnShareBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
														<tbody class="mcnShareBlockOuter">
															<tr>
																<td style="padding: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnShareBlockInner" valign="top"></td>
															</tr>
														</tbody>
													</table>
													<table class="mcnDividerBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
													<!--tbody class="mcnDividerBlockOuter">
														<tr>
															<td class="mcnDividerBlockInner" style="min-width: 100%;padding: 5px 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
																<table class="mcnDividerContent" style="min-width: 100%;border-top: 1px solid #666666;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
																	<tbody><tr>
																		<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
																			<span></span>
																		</td>
																	</tr>
																</tbody></table>

															</td>
														</tr>
													</tbody-->
													</table>
													
													<table class="mcnTextBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
													<tbody class="mcnTextBlockOuter">
														<tr>
															<td class="mcnTextBlockInner" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
																
																<table class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" align="left" width="600" cellspacing="0" cellpadding="0" border="0">
																	<tbody><tr>
																		
																		<td class="mcnTextContent" style="padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #FFFFFF;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;" valign="top">
																		
																			<div style="text-align: left;"><span style="font-size:12px"><span style="font-family:arial,helvetica neue,helvetica,sans-serif"><strong><? echo "$texto"; ?></span></span></div>

																		</td>
																	</tr>

																</tbody></table>
															</td>

														</tr>
																																							
													</tbody>
													<tbody>
													<?php
														if ($idioma == 'ca'){  ?>
															<tr>
																<td align="center"><a class="boton" href="https://www.soloviajesdelujo.com/viajes/<? echo "$nombre_pagina_destino"; ?>/viaje-<? echo "$nombre_pagina_destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>" target="_blank" style="">VEURE DESCRIPCI&Oacute;</a>&nbsp;&nbsp;&nbsp;
																<a class="boton" href="http://www.soloviajesdelujo.com/contacto.php?id=<?php echo "$id_new"; ?>" target="_blank" style="">ACCEDIR A LA VENDA</a></td>
															</tr>
															
													<?php }	else {  ?>
															<tr>
																<td align="center"><a class="boton" href="https://www.soloviajesdelujo.com/viajes/<? echo "$nombre_pagina_destino"; ?>/viaje-<? echo "$nombre_pagina_destino"; ?>.php?id_viaje=<? echo "$id_new"; ?>" target="_blank" style="">VER DESCRIPCI&Oacute;N</a>&nbsp;&nbsp;&nbsp;
																<a class="boton" href="http://www.soloviajesdelujo.com/contacto.php?id=<?php echo "$id_new"; ?>" target="_blank" style="">ACCEDER A LA VENTA</a></td>
															</tr>
													<?php } ?>
													</tbody>
														<tbody class="mcnDividerBlockOuter">
														<tr>
															<td class="mcnDividerBlockInner" style="min-width: 100%;padding: 5px 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
																<table class="mcnDividerContent" style="min-width: 100%;border-top: 1px solid #666666;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
																	<tbody><tr>
																		<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
																			<span></span>
																		</td>
																	</tr>
																</tbody></table>

															</td>
														</tr>
													</tbody>
													</table>
													<?php }
			
		?>  	
													<table class="mcnTextBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
													<tbody class="mcnTextBlockOuter">
														<tr>
															<td class="mcnTextBlockInner" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
																
																<table class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" align="left" width="600" cellspacing="0" cellpadding="0" border="0">
																	<tbody><tr>
																		
																		<td class="mcnTextContent" style="padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #FFFFFF;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;" valign="top">
																		
																			<div style="text-align: center;"><span style="font-size:12px"><span style="font-family:arial,helvetica neue,helvetica,sans-serif"><strong><h2>!SOLICITA 3 DESEOS!</h2></strong>
HACER EL VIAJE DE MIS SUE&Ntilde;OS
&Uacute;NICO PARA MI Y LOS M&Iacute;OS
CON UN SERVICIO Y EXCLUSIVIDAD  GARANTIZADOS.<strong><h2>!CONCEDIDO!</h2></strong>Llama ahora al 0034 610461529 o env&iacute;anos tu solicitud a :
<a href="mailto:info@soloviajesdelujo.com" style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #6DC6DD;font-weight: normal;text-decoration: underline;">info@soloviajesdelujo.com</a>
<br>
													Grupo Global MPS Viajes y Cruceros S.L.<br>
MAYORISTA DE VIAJES EXCLUSIVOS PARA PARTICULARES, GRUPOS E INCENTIVOS.<br>
Bloqueos a&eacute;reos a todos los destinos a nivel internacional, tarifas a&eacute;reas negociadas y nuestra  red de corresponsales por el mundo.</span></span></div>

																		</td>
																	</tr>
																</tbody></table>

																
															</td>
														</tr>
													</tbody>
													</table>
													<table class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
													<tbody class="mcnTextBlockOuter">
														<tr>
															<td class="mcnTextBlockInner" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">

																<table style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer" align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
																	<tbody><tr>
																		
																		<td class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #FFFFFF;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;" valign="top">
																		
																					<div style="text-align: center;">
													<hr><span style="font-size:11px"><span style="font-family:arial,helvetica neue,helvetica,sans-serif">
													Grupo Global MPS Viajes y Cruceros S.L informa que en virtud de la Ley en el RGPD (Reglamento (UE) 2016/679), les proporcionamos la Informaci&oacute;n Detallada de Protecci&oacute;n de Datos. <a href="https://www.soloviajesdelujo.com/terminos-condiciones.html" style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #6DC6DD;font-weight: normal;text-decoration: underline;">LEY</a>. Puede ejercer su derecho de acceso, rectificaci&oacute;n, cancelaci&oacute;n u oposici&oacute;n, dirigiéndose por escrito a Grupo Global MPS Viajes y Cruceros S.L (<a href="mailto:info@soloviajesdelujo.com" target="_blank" style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #6DC6DD;font-weight: normal;text-decoration: underline;">info@soloviajesdelujo.com</a>) o a trav&eacute;s del enlace de BAJA al pie de esta comunicaci&oacute;n.</span></span></div>

																		</td>
																	</tr>
																</tbody></table>
															</td>
														</tr>
													</tbody>
													</table>
												</td>
											</tr>
										</tbody></table>
												<!-- // END HEADER -->
									</td>
								</tr>
								<tr>
									<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" align="center" valign="top">
										<!-- BEGIN BODY // -->
										<table id="templateBody" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;min-width: 100%;background-color: #011F29;border-top: 0;border-bottom: 0;" width="600" cellspacing="0" cellpadding="0" border="0">
											<tbody><tr>
												<td class="bodyContainer" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top"></td>
											</tr>
										</tbody></table>
										<!-- // END BODY -->
									</td>
								</tr>
										<tr>
											<td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" align="center" valign="top">
												<!-- BEGIN FOOTER // -->
												<table id="templateFooter" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;min-width: 100%;background-color: #011F29;border-top: 0;border-bottom: 0;" width="600" cellspacing="0" cellpadding="0" border="0">
													<tbody><tr>
														<td class="footerContainer" style="padding-bottom: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top"><table class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
				<tbody class="mcnTextBlockOuter">
					<tr>
						<td class="mcnTextBlockInner" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top">
							<!--[if mso]>
							<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
							<tr>
							<![endif]-->
							
							<!--[if mso]>
							<td valign="top" width="600" style="width:600px;">
							<![endif]-->
							<table style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnTextContentContainer" align="left" width="100%" cellspacing="0" cellpadding="0" border="0">
								<tbody><tr>
									
									<td class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #FFFFFF;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;" valign="top">
									
										<em>Copyright © 2017 Grupo Global MPS Viajes y Cruceros S.L, All rights reserved.</em><br>
				<br>


									</td>
								</tr>
							</tbody></table>

						</td>
					</tr>
				</tbody>
				</table></td>
													</tr>
												</tbody></table>
												<!-- // END FOOTER -->
											</td>
										</tr>
									</tbody></table>
									<!-- // END TEMPLATE -->
								</td>
							</tr>
			</tbody>
		</table>
   </center>
         
	
</body>
</html>