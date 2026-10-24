<?php
/** Mail rendering and transport for public forms. This file never sends on include. */

function svl_form_mail_escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function svl_form_message($kind, array $data)
{
    if (!in_array($kind, array('contact', 'newsletter'), true)) {
        throw new InvalidArgumentException('Unknown form message.');
    }
    $email = isset($data['email']) && is_string($data['email']) ? trim($data['email']) : '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match('/[\r\n]/', $email)) {
        throw new InvalidArgumentException('Invalid message recipient.');
    }

    $rows = array();
    if ($kind === 'contact') {
        $subject = 'Solicitud de presupuesto personalizado';
        $introduction = 'Hemos recibido tu solicitud. Nuestro equipo se pondrá en contacto contigo.';
        $labels = array(
            'name' => 'Nombre', 'last_name' => 'Primer apellido', 'last_name_2' => 'Segundo apellido',
            'email' => 'Email', 'phone' => 'Teléfono', 'destination' => 'Destino',
            'travel_date' => 'Fecha del viaje', 'departure_city' => 'Ciudad de salida',
            'adults' => 'Adultos', 'children' => 'Niños', 'contact_time' => 'Horario de contacto',
            'comments' => 'Comentarios'
        );
        foreach ($labels as $key => $label) {
            $value = isset($data[$key]) && is_scalar($data[$key]) ? (string) $data[$key] : '';
            $rows[$label] = $value !== '' ? $value : 'No indicado';
        }
        $flight = isset($data['flight']) ? (string) $data['flight'] : '';
        $rows['Vuelo incluido'] = $flight === '1' ? 'Sí' : ($flight === '0' ? 'No' : 'No indicado');
    } else {
        $subject = 'Registro en la newsletter realizado';
        $introduction = 'Hemos registrado tu suscripción a las ofertas y novedades de Solo Viajes de Lujo.';
        $rows['Email'] = $email;
    }

    $plain = "Solo Viajes de Lujo\r\n\r\n".$introduction."\r\n\r\n";
    $html = '<!doctype html><html lang="es"><head><meta charset="UTF-8"></head>'
        .'<body style="margin:0;background:#f5f5f5;color:#222;font-family:Arial,sans-serif">'
        .'<table role="presentation" style="max-width:640px;width:100%;margin:24px auto;border-collapse:collapse;background:#fff">'
        .'<tr><td style="padding:24px;background:#222;color:#fff;font-size:22px">Solo Viajes de Lujo</td></tr>'
        .'<tr><td style="padding:24px"><p>'.svl_form_mail_escape($introduction).'</p>'
        .'<table style="width:100%;border-collapse:collapse">';
    foreach ($rows as $label => $value) {
        $plain .= $label.': '.preg_replace('/\r\n|\r|\n/', "\r\n", $value)."\r\n";
        $html .= '<tr><th scope="row" style="padding:9px;text-align:left;vertical-align:top;border-bottom:1px solid #ddd;width:38%">'
            .svl_form_mail_escape($label).'</th><td style="padding:9px;border-bottom:1px solid #ddd">'
            .nl2br(svl_form_mail_escape($value), false).'</td></tr>';
    }
    $plain .= "\r\nTeléfono: +34 610 461 529\r\nEmail: info@soloviajesdelujo.com\r\n";
    $html .= '</table><p style="margin-top:24px">Teléfono: +34 610 461 529<br>'
        .'<a href="mailto:info@soloviajesdelujo.com">info@soloviajesdelujo.com</a></p>';
    if ($kind === 'newsletter') {
        $plain .= "Para cancelar tu suscripción, escríbenos a info@soloviajesdelujo.com.\r\n";
        $html .= '<p style="font-size:12px;color:#666">Para cancelar tu suscripción, escríbenos a '
            .'<a href="mailto:info@soloviajesdelujo.com">info@soloviajesdelujo.com</a>.</p>';
    }
    $html .= '</td></tr></table></body></html>';

    $boundary = 'svl_'.bin2hex(random_bytes(18));
    $headers = implode("\r\n", array(
        'MIME-Version: 1.0',
        'From: Solo Viajes de Lujo <info@soloviajesdelujo.com>',
        'Cc: info@soloviajesdelujo.com',
        'Reply-To: '.$email,
        'Content-Type: multipart/alternative; boundary="'.$boundary.'"'
    ));
    $body = 'This is a multipart message in MIME format.' . "\r\n\r\n";
    foreach (array('text/plain' => $plain, 'text/html' => $html) as $type => $content) {
        $body .= '--'.$boundary."\r\n"
            .'Content-Type: '.$type.'; charset=UTF-8'."\r\n"
            .'Content-Transfer-Encoding: base64'."\r\n\r\n"
            .chunk_split(base64_encode($content), 76, "\r\n");
    }
    $body .= '--'.$boundary."--\r\n";

    return array(
        'to' => $email, 'subject' => $subject, 'html' => $html, 'text' => $plain,
        'headers' => $headers, 'body' => $body,
        'subject_encoded' => '=?UTF-8?B?'.base64_encode($subject).'?='
    );
}

function svl_form_mail_is_local(array $config)
{
    $environment = getenv('SVL_ENV');
    if ($environment === false) {
        $environment = isset($config['env']) ? $config['env'] : 'production';
    }
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $host = $host !== '' ? parse_url('http://'.$host, PHP_URL_HOST) : '';
    return $environment !== 'production'
        || PHP_SAPI === 'cli' || PHP_SAPI === 'cli-server'
        || in_array(strtolower((string) $host), array('localhost', '127.0.0.1', '[::1]', '::1'), true);
}

function svl_form_mail_capture(array $message, array $config)
{
    $directory = getenv('SVL_MAIL_CAPTURE_DIR');
    if ($directory === false || trim($directory) === '') {
        $directory = isset($config['mail_capture_dir']) ? $config['mail_capture_dir']
            : sys_get_temp_dir().'/solo-viajes-lujo-mail';
    }
    if (!is_string($directory) || $directory === '' || is_link($directory)) {
        throw new RuntimeException('Invalid mail capture directory.');
    }
    if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) {
        throw new RuntimeException('Mail capture directory is unavailable.');
    }
    $directory = realpath($directory);
    $root = realpath(dirname(__DIR__));
    $documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
    foreach (array($root, $documentRoot) as $publicRoot) {
        if ($publicRoot !== false && ($directory === $publicRoot
                || strpos($directory, $publicRoot.DIRECTORY_SEPARATOR) === 0)) {
            throw new RuntimeException('Mail captures must remain outside the public directory.');
        }
    }
    if ($directory === false || !@chmod($directory, 0700) || !is_writable($directory)) {
        throw new RuntimeException('Mail capture directory is not private and writable.');
    }
    $path = $directory.DIRECTORY_SEPARATOR.gmdate('Ymd-His').'-'.bin2hex(random_bytes(12)).'.eml';
    $capture = 'Date: '.date(DATE_RFC2822)."\r\n"
        .'Message-ID: <'.bin2hex(random_bytes(16)).'@soloviajesdelujo.com>'."\r\n"
        .'To: '.$message['to']."\r\n"
        .'Subject: '.$message['subject_encoded']."\r\n"
        .$message['headers']."\r\n\r\n".$message['body'];
    $mask = umask(0077);
    try {
        $stream = @fopen($path, 'xb');
    } finally {
        umask($mask);
    }
    if ($stream === false) {
        throw new RuntimeException('Mail capture could not be created.');
    }
    try {
        $written = fwrite($stream, $capture);
        if ($written !== strlen($capture)) {
            throw new RuntimeException('Mail capture could not be completed.');
        }
    } finally {
        fclose($stream);
    }
    return $path;
}

function svl_form_deliver(array $message, array $config = array())
{
    $base = function_exists('svl_configuration') ? svl_configuration() : array();
    $config = array_merge($base, $config);
    foreach (array('to', 'subject', 'subject_encoded', 'headers', 'body') as $key) {
        if (!isset($message[$key]) || !is_string($message[$key])) {
            return array('status' => 'failed', 'error' => 'invalid_message');
        }
    }
    if (!filter_var($message['to'], FILTER_VALIDATE_EMAIL) || preg_match('/[\r\n]/', $message['to'])) {
        return array('status' => 'failed', 'error' => 'invalid_recipient');
    }

    if (svl_form_mail_is_local($config)) {
        if (getenv('SVL_TEST_MAIL_FAIL') === '1') {
            return array('status' => 'failed', 'error' => 'simulated_mail_failure', 'transport' => 'capture');
        }
        try {
            return array('status' => 'captured', 'capture_file' => svl_form_mail_capture($message, $config),
                'transport' => 'capture');
        } catch (Throwable $error) {
            return array('status' => 'failed', 'error' => 'mail_capture_failed', 'transport' => 'capture');
        }
    }
    if (!function_exists('mail')) {
        return array('status' => 'failed', 'error' => 'mail_transport_unavailable', 'transport' => 'mail');
    }
    try {
        $accepted = @mail($message['to'], $message['subject_encoded'], $message['body'], $message['headers']);
        return array('status' => $accepted ? 'accepted' : 'failed',
            'error' => $accepted ? null : 'mail_transport_rejected', 'transport' => 'mail');
    } catch (Throwable $error) {
        return array('status' => 'failed', 'error' => 'mail_transport_failed', 'transport' => 'mail');
    }
}
