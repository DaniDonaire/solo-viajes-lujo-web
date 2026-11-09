<?php
/** Public contact/newsletter intake. Commit data before attempting email delivery. */
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/form-mail.php';
require_once __DIR__.'/form-error.php';

function svl_forms_connection()
{
    $profile = svl_database_configuration('web');
    $configuration = svl_configuration();
    if ($configuration['env'] === 'local'
        && (!in_array($profile['host'], array('localhost', '127.0.0.1'), true)
            || strpos($profile['database'], 'svl_local_') !== 0)) {
        throw new RuntimeException('Local forms require an imported local database.');
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = new mysqli($profile['host'], $profile['user'], $profile['password'],
        $profile['database'], 0, $profile['socket'] !== '' ? $profile['socket'] : null);
    $connection->set_charset('utf8mb4');
    return $connection;
}

function svl_forms_ready($connection)
{
    try {
        $connection->query('SELECT id FROM svl_form_submissions LIMIT 0');
        return true;
    } catch (mysqli_sql_exception $error) {
        if ($error->getCode() === 1146) {
            return false;
        }
        throw $error;
    }
}

function svl_form_input(array $input, $key, $maximum = 255)
{
    if (!isset($input[$key])) {
        return '';
    }
    if (!is_string($input[$key])) {
        throw new InvalidArgumentException('Revisa los datos del formulario.');
    }
    $value = trim($input[$key]);
    if (!mb_check_encoding($value, 'UTF-8') || strpos($value, "\0") !== false
        || mb_strlen($value, 'UTF-8') > $maximum) {
        throw new InvalidArgumentException('Uno de los campos tiene un formato o una longitud no válidos.');
    }
    return $value;
}

function svl_form_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match('/[\r\n]/', $email)
        || strlen($email) > 254) {
        throw new InvalidArgumentException('Introduce una dirección de email válida.');
    }
    return $email;
}

function svl_form_contact_data(array $input)
{
    $data = array();
    foreach (array('name' => array('name_contact', 120), 'email' => array('email_contact', 254),
        'last_name' => array('lastname_contact', 120), 'last_name_2' => array('lastname_contact2', 120),
        'destination' => array('destino', 100), 'departure_city' => array('ciudad_inicial', 200),
        'phone' => array('phone_contact', 60), 'comments' => array('message_contact', 8000),
        'contact_time' => array('exampleSelect3', 80), 'travel_date' => array('fecha-viaje', 10),
        'flight' => array('inlineRadioOptions', 1)) as $field => $source) {
        $data[$field] = svl_form_input($input, $source[0], $source[1]);
    }
    if ($data['name'] === '') {
        throw new InvalidArgumentException('Indica tu nombre.');
    }
    $data['email'] = svl_form_email($data['email']);
    if ($data['travel_date'] !== '') {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $data['travel_date']);
        if (!$date || $date->format('Y-m-d') !== $data['travel_date']) {
            throw new InvalidArgumentException('Revisa la fecha del viaje.');
        }
    }
    foreach (array('adults' => array('exampleSelect1', 1, 1, 10),
        'children' => array('exampleSelect2', 0, 0, 10), 'trip_id' => array('id', 0, 0, 2147483647)) as $key => $rule) {
        $value = svl_form_input($input, $rule[0], 10);
        if ($value === '') {
            $data[$key] = $rule[1];
        } elseif (!ctype_digit($value) || (int) $value < $rule[2] || (int) $value > $rule[3]) {
            throw new InvalidArgumentException('Revisa el número de viajeros o el viaje seleccionado.');
        } else {
            $data[$key] = (int) $value;
        }
    }
    if (!in_array($data['flight'], array('', '0', '1'), true)) {
        throw new InvalidArgumentException('Revisa la opción de vuelo.');
    }
    return $data;
}

function svl_form_request_guard($kind)
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        throw new InvalidArgumentException('Envía el formulario desde la página de contacto o suscripción.');
    }
    if (svl_form_input($_POST, 'website', 500) !== '') {
        throw new InvalidArgumentException('No hemos podido validar el formulario.');
    }
    $origin = $_SERVER['HTTP_ORIGIN'] ?? ($_SERVER['HTTP_REFERER'] ?? '');
    if ($origin !== '') {
        $host = parse_url('http://'.($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);
        if (!$host || strcasecmp((string) parse_url($origin, PHP_URL_HOST), $host) !== 0) {
            throw new InvalidArgumentException('Envía el formulario desde esta web.');
        }
    }
    $configuration = svl_configuration();
    if ($kind !== 'contact' || svl_is_test_environment()) {
        return;
    }
    $secret = getenv('SVL_RECAPTCHA_SECRET');
    if ($secret === false || $secret === '') {
        $secret = $configuration['recaptcha_secret'] ?? '';
    }
    $token = svl_form_input($_POST, 'g-recaptcha-response', 4096);
    if ($secret === '' || $token === '') {
        throw new InvalidArgumentException('Completa la comprobación antirrobots antes de enviar.');
    }
    $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt_array($curl, array(CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query(array('secret' => $secret, 'response' => $token)),
        CURLOPT_CONNECTTIMEOUT => 3, CURLOPT_TIMEOUT => 8));
    try {
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    } finally {
        unset($curl);
    }
    $verification = is_string($response) ? json_decode($response, true) : null;
    $allowedHosts = array('soloviajesdelujo.com', 'www.soloviajesdelujo.com');
    if ($status !== 200 || !is_array($verification) || empty($verification['success'])
        || !in_array(strtolower($verification['hostname'] ?? ''), $allowedHosts, true)) {
        throw new InvalidArgumentException('No se ha podido validar la comprobación antirrobots. Inténtalo de nuevo.');
    }
}

function svl_form_insert($connection, $table, array $fields)
{
    if (!in_array($table, array('presupuesto', 'peticiones', 'nuevos_mails', 'svl_form_submissions'), true)) {
        throw new InvalidArgumentException('Unknown form table.');
    }
    foreach (array_keys($fields) as $column) {
        if (!preg_match('/^[a-z_][a-z0-9_]*$/D', $column)) {
            throw new InvalidArgumentException('Unknown form column.');
        }
    }
    $columns = '`'.implode('`,`', array_keys($fields)).'`';
    $statement = $connection->prepare('INSERT INTO `'.$table.'` ('.$columns.') VALUES ('
        .implode(',', array_fill(0, count($fields), '?')).')');
    $statement->execute(array_values($fields));
    return (int) $connection->insert_id;
}

function svl_form_outbox($connection, $kind, array $data, $referenceId)
{
    $message = null;
    try {
        $message = svl_form_message($kind, $data);
    } catch (Throwable $error) {
        // Data is still stored if rendering the confirmation email fails.
    }
    $id = svl_form_insert($connection, 'svl_form_submissions', array(
        'kind' => $kind, 'reference_id' => $referenceId, 'email' => $data['email'],
        'payload' => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
        'mail_subject' => $message['subject'] ?? '', 'mail_html' => $message['html'] ?? '',
        'mail_text' => $message['text'] ?? '', 'mail_headers' => $message['headers'] ?? '',
        'mail_status' => $message === null ? 'failed' : 'pending',
        'mail_error' => $message === null ? 'message_render_failed' : null
    ));
    return array('id' => $id, 'reference_id' => $referenceId, 'message' => $message);
}

function svl_form_finish($connection, array $saved)
{
    try {
        $delivery = $saved['message'] === null ? array('status' => 'failed', 'error' => 'message_render_failed')
            : svl_form_deliver($saved['message']);
    } catch (Throwable $error) {
        $delivery = array('status' => 'failed', 'error' => 'mail_transport_failed');
    }
    try {
        $statement = $connection->prepare('UPDATE svl_form_submissions SET mail_status=?, mail_error=?, updated_at=CURRENT_TIMESTAMP WHERE id=?');
        $statement->execute(array($delivery['status'], $delivery['error'] ?? null, $saved['id']));
    } catch (Throwable $error) {
        // The committed request and prepared email remain available as pending.
        error_log('SVL form mail status could not be updated; submission '.$saved['id']);
        $delivery['status'] = 'pending';
    }
    return array('id' => $saved['id'], 'reference_id' => $saved['reference_id'],
        'mail_status' => $delivery['status'], 'capture_file' => $delivery['capture_file'] ?? null);
}

function svl_store_contact($connection, array $data)
{
    if (!svl_forms_ready($connection)) {
        throw new RuntimeException('Form storage has not been prepared.');
    }
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = '0.0.0.0';
    }
    $data['ip'] = $ip;
    $data['source'] = parse_url($_SERVER['HTTP_REFERER'] ?? '', PHP_URL_PATH) ?: '/contacto.php';
    $now = date('Y-m-d H:i:s');
    $connection->begin_transaction();
    try {
        $reference = svl_form_insert($connection, 'presupuesto', array(
            'id_rand' => bin2hex(random_bytes(15)), 'id_crucero' => $data['trip_id'],
            'nombre_crucero' => '', 'destino' => $data['destination'], 'itineraire' => '',
            'comenzando_fecha' => $data['travel_date'] !== '' ? $data['travel_date'] : null,
            'adulto' => $data['adults'], 'ninos' => $data['children'],
            'vuelo' => $data['flight'] !== '' ? $data['flight'] : null,
            'ciudad_vuelo' => '', 'ciudad' => $data['departure_city'], 'puerto_salida' => '',
            'nombre' => $data['name'], 'apellido_1' => $data['last_name'], 'apellido_2' => $data['last_name_2'],
            'phone' => $data['phone'], 'email' => $data['email'], 'hora_recordatorio' => $data['contact_time'],
            'comentarios' => $data['comments'], 'comentarios_vendedor' => '', 'message' => '', 'seguimiento' => '',
            'sitio' => 'SoloViajesDeLujo', 'date_last_added' => $now, 'ip' => $ip
        ));
        svl_form_insert($connection, 'peticiones', array('id' => $reference, 'fecha' => $now,
            'emailhash' => md5($data['email']), 'sitio' => 'SoloViajesDeLujo', 'ip_address' => $ip));
        $saved = svl_form_outbox($connection, 'contact', $data, $reference);
        $connection->commit();
    } catch (Throwable $error) {
        $connection->rollback();
        throw $error;
    }
    return svl_form_finish($connection, $saved);
}

function svl_store_newsletter($connection, $email)
{
    $email = svl_form_email($email);
    if (!svl_forms_ready($connection)) {
        throw new RuntimeException('Form storage has not been prepared.');
    }
    $lockName = 'svl_signup_'.substr(hash('sha256', strtolower($email)), 0, 40);
    $lock = $connection->prepare('SELECT GET_LOCK(?, 5)');
    $lock->execute(array($lockName));
    if ((int) $lock->get_result()->fetch_row()[0] !== 1) {
        throw new RuntimeException('The subscription could not be locked.');
    }
    try {
        $connection->begin_transaction();
        try {
            $exists = $connection->prepare('SELECT 1 FROM nuevos_mails WHERE email=? AND lista=5 LIMIT 1');
            $exists->execute(array($email));
            if ($exists->get_result()->fetch_row()) {
                $connection->commit();
                return array('id' => null, 'reference_id' => null, 'mail_status' => 'not_needed', 'duplicate' => true);
            }
            svl_form_insert($connection, 'nuevos_mails', array('email' => $email, 'lista' => 5));
            $data = array('email' => $email,
                'source' => parse_url($_SERVER['HTTP_REFERER'] ?? '', PHP_URL_PATH) ?: '/registro.php');
            $saved = svl_form_outbox($connection, 'newsletter', $data, null);
            $connection->commit();
        } catch (Throwable $error) {
            $connection->rollback();
            throw $error;
        }
        return svl_form_finish($connection, $saved);
    } finally {
        try {
            $release = $connection->prepare('SELECT RELEASE_LOCK(?)');
            $release->execute(array($lockName));
        } catch (Throwable $error) {
            // Closing the connection also releases this lock; committed data stays saved.
        }
    }
}

function svl_form_wants_json()
{
    return stripos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false
        || strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '', 'XMLHttpRequest') === 0;
}

function svl_form_reply_json(array $result, $message)
{
    header('Content-Type: application/json; charset=UTF-8');
    header('Cache-Control: no-store');
    echo json_encode(array('success' => true, 'saved' => true, 'id' => $result['id'],
        'mail_status' => $result['mail_status'], 'message' => $message), JSON_UNESCAPED_UNICODE);
    exit;
}

function svl_form_fail(Throwable $error)
{
    $validation = $error instanceof InvalidArgumentException;
    http_response_code($validation ? 422 : 503);
    header('Cache-Control: no-store');
    $message = $validation ? $error->getMessage() : 'No hemos podido guardar los datos. Inténtalo de nuevo o contacta con nosotros.';
    if (!$validation) {
        error_log('SVL form could not be saved ('.get_class($error).', code '.(int) $error->getCode().').');
        if ($error instanceof mysqli_sql_exception && in_array($error->getCode(), array(1044, 1045, 2002, 2003), true)) {
            $message = 'No hemos podido conectar con el servicio que guarda el formulario. Conserva tus datos e inténtalo más tarde.';
        }
    }
    if (svl_form_wants_json()) {
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(array('success' => false, 'saved' => false, 'message' => $message), JSON_UNESCAPED_UNICODE);
    } else {
        svl_render_form_error($message, $validation ? 422 : 503, 'contacto.php');
    }
    exit;
}
