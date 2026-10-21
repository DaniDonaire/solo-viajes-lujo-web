<?php
	//include("Mail.php");
	//include('Mail/mime.php');
	
	function enviarMail($email,$message,$subject,$text) {
			$recipients = $email.", pruebas@entre3mundos.com";
			$headers["From"] = "info@entre3mundos.com";
			$headers["To"] = $email;
			//$headers["Cc"] = "pruebas@entre3mundos.com";
			//$headers["Bcc"] = "pruebas@entre3mundos.com";
			$headers["Subject"] = $subject;
			
			$params["host"] = (getenv('SVL_SMTP_HOST') !== false ? getenv('SVL_SMTP_HOST') : '127.0.0.1');
			$params["port"] = "25";
			$params["auth"] = true;
			$params["username"] = (getenv('SVL_SMTP_USER') !== false ? getenv('SVL_SMTP_USER') : '');
			$params["password"] = (getenv('SVL_SMTP_PASSWORD') !== false ? getenv('SVL_SMTP_PASSWORD') : '');
			
			$mime = new Mail_mime($crlf);         
      $mime->setTXTBody($text);        
      $mime->setHTMLBody($html);         
      $mime->addAttachment($message,'application/octet-stream'); 
     
      $body = $mime->get();
			$mail_object =& Mail::factory("smtp", $params);
			
			//$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			//$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			//if ( $mail_object->send($recipients, $headers,$message,$cabeceras) ) {
			if ( $mail_object->send($recipients, $headers,$body) ) {	
				//echo "Mensaje enviado ok";
			}
			else {
				echo "error al enviar el mensaje";
			}
	
	}
	
	function enviarMail2($email,$message,$subject) {
			$crlf = "rn";
			$text = 'Text version of email';
			$html = '<html><body>HTML version of email</body></html>';

			$recipients = $email.", pruebas@entre3mundos.com";
			$headers["From"] = "info@entre3mundos.com";
			$headers["To"] = $email;
			//$headers["Cc"] = "pruebas@entre3mundos.com";
			//$headers["Bcc"] = "pruebas@entre3mundos.com";
			$headers["Subject"] = $subject;
			
			$params["host"] = (getenv('SVL_SMTP_HOST') !== false ? getenv('SVL_SMTP_HOST') : '127.0.0.1');
			$params["port"] = "25";
			$params["auth"] = true;
			$params["username"] = (getenv('SVL_SMTP_USER') !== false ? getenv('SVL_SMTP_USER') : '');
			$params["password"] = (getenv('SVL_SMTP_PASSWORD') !== false ? getenv('SVL_SMTP_PASSWORD') : '');
			
			$mime = new Mail_mime($crlf);         
      $mime->setTXTBody($text);        
      $mime->setHTMLBody($html);         
      $mime->addAttachment($message,'application/octet-stream'); 
     
      $body = $mime->get();
      //$hdrs = $mime->headers($hdrs); 
     
			$mail_object =& Mail::factory("smtp", $params);
			
			//$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			//$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			//if ( $mail_object->send($recipients, $headers,$message,$cabeceras) ) {
			if ( $mail_object->send($recipients, $headers,$body) ) {	
				//echo "Mensaje enviado ok";
			}
			else {
				echo "error al enviar el mensaje";
			}
	
	}
	
	function enviarMail3($email,$html,$subject,$text,$fitxer) {	
		// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Cabeceras adicionales
		$cabeceras .= 'To: <$email>' . "\r\n";
		$cabeceras .= 'From: Entre3mundos.com <info@entre3mundos.com>' . "\r\n";
		//$cabeceras .= 'Cc:  Entre3mundos <$maild>' . "\r\n";

		// Mail it
		mail($email, $titulo, $html, $cabeceras);
	}	
	
	function enviarMail3Old($email,$html,$subject,$text,$fitxer) {	
		//$file = $_SERVER['DOCUMENT_ROOT'].'\Fitxers\Navidad en Famila.doc';
		$file = $_SERVER['DOCUMENT_ROOT'] . '\pspdevel\presupuestos\dologin\fitxers'.'\\'. $fitxer;
		$params["host"] = (getenv('SVL_SMTP_HOST') !== false ? getenv('SVL_SMTP_HOST') : '127.0.0.1');
		$params["port"] = "25";
		$params["auth"] = true;
		$params["username"] = (getenv('SVL_SMTP_USER') !== false ? getenv('SVL_SMTP_USER') : '');
		$params["password"] = (getenv('SVL_SMTP_PASSWORD') !== false ? getenv('SVL_SMTP_PASSWORD') : '');
		$crlf = "\n";
		$hdrs = array(              
							'From'    => "info@soloviajesdelujo.com",              
							'To'      => $email,             
							'Subject' => $subject              
							);     					
		$mime = new Mail_mime($crlf);         
		$mime->setTXTBody($text);        
		$mime->setHTMLBody($html);         
		//$mime->addAttachment($file,'application/octet-stream'); 
		if( file_exists( $file))  { 
			$mime->addAttachment($file, 'text/plain'); 
		}
		$body = $mime->get();
		$hdrs = $mime->headers($hdrs); 
		//$mail =& Mail::factory('mail', $params);
		$mail =& Mail::factory('smtp',$params);
		$mail->send($email, $hdrs, $body); 
	}	
	
	function enviarMail3_old($email,$html,$subject,$text) {
		
		//$file = './files/example.zip';
		$crlf = "\n";
		$hdrs = array(              
							'From'    => "info@entre3mundos.com",              
							'To'      => $email,     
							'Bcc' 		=> "pruebas@entre3mundos.com",            
							'Subject' => $subject              
							);     
						
		$mime = new Mail_mime($crlf);         
		$mime->setTXTBody($text);        
		$mime->setHTMLBody($html);         
		//$mime->addAttachment($file,'application/octet-stream'); 
		$body = $mime->get();
		$hdrs = $mime->headers($hdrs); 
		//$mail =& Mail::factory('mail', $params);
		$mail =& Mail::factory('mail');
		$mail->send($email, $hdrs, $body); 
	}
		
?>