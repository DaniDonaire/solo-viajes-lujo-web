<?php
/** Read-only unified contact and newsletter lists. Never copies or rewrites records. */
require_once __DIR__.'/../../include/forms.php';

function svl_inbox_escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function svl_inbox_rows(mysqli $connection, $sql, array $parameters = array())
{
    $statement = $connection->prepare($sql);
    try {
        if ($parameters) {
            $types = '';
            foreach ($parameters as $value) {
                $types .= is_int($value) ? 'i' : 's';
            }
            $statement->bind_param($types, ...$parameters);
        }
        $statement->execute();
        return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    } finally {
        $statement->close();
    }
}

function svl_inbox_payload($json)
{
    $decoded = json_decode((string) $json, true);
    return is_array($decoded) ? $decoded : array();
}

function svl_inbox_status($status)
{
    $labels = array('pending' => 'Pendiente de correo', 'captured' => 'Capturado en local',
        'accepted' => 'Aceptado por el servidor', 'failed' => 'Correo fallido');
    return $labels[$status] ?? 'Sin registro';
}

function svl_inbox_value($key, $value)
{
    if ($key === 'flight' || $key === 'vuelo') {
        return $value === null || $value === '' ? 'No indicado'
            : (in_array($value, array(true, 1, '1'), true) ? 'Sí' : 'No');
    }
    if (is_bool($value)) {
        return $value ? 'Sí' : 'No';
    }
    if (is_array($value)) {
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    return $value === null || $value === '' ? 'No indicado' : (string) $value;
}

function svl_inbox_url(array $changes = array())
{
    global $view, $search, $mailFilter, $dateFrom, $dateTo, $destination, $origin, $listFilter, $page;
    $query = array('view' => $view, 'q' => $search, 'mail' => $mailFilter,
        'date_from' => $dateFrom, 'date_to' => $dateTo, 'page' => $page);
    if ($view === 'contacts') {
        $query['destination'] = $destination;
        $query['origin'] = $origin;
    } else {
        $query['list'] = $listFilter;
    }
    $query = array_merge($query, $changes);
    return 'formularios.php?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);
}

function svl_inbox_parameter($name, $maximum)
{
    if (!isset($_GET[$name])) {
        return '';
    }
    if (!is_string($_GET[$name]) || !mb_check_encoding($_GET[$name], 'UTF-8')
        || strpos($_GET[$name], "\0") !== false || mb_strlen($_GET[$name], 'UTF-8') > $maximum) {
        throw new InvalidArgumentException('Revisa el formato de los filtros.');
    }
    return trim($_GET[$name]);
}

function svl_inbox_date($name)
{
    $value = svl_inbox_parameter($name, 10);
    if ($value !== '') {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value) {
            throw new InvalidArgumentException('Revisa las fechas del filtro.');
        }
    }
    return $value;
}

function svl_inbox_like($value)
{
    return '%'.str_replace(array('=', '%', '_'), array('==', '=%', '=_'), $value).'%';
}

$requestedView = isset($_GET['view']) && is_string($_GET['view']) ? $_GET['view'] : '';
$view = in_array($requestedView, array('newsletter', 'newsletter_history'), true)
    || (in_array($requestedView, array('', 'new'), true) && ($_GET['kind'] ?? '') === 'newsletter')
    ? 'newsletter' : 'contacts';
$search = $mailFilter = $dateFrom = $dateTo = $destination = $origin = $listFilter = '';
$page = 1;
$id = $submissionId = null;
$error = '';
$rows = $counts = $destinations = $origins = $lists = array();
$counts = array('contact' => 0, 'newsletter' => 0);
$detail = null;
$ready = $hasNext = false;
$filteredCount = 0;
$connection = null;

try {
    $search = svl_inbox_parameter('q', 254);
    $mailFilter = svl_inbox_parameter('mail', 20);
    if (!in_array($mailFilter, array('', 'review', 'pending', 'captured', 'accepted', 'failed', 'unknown'), true)) {
        throw new InvalidArgumentException('El estado del correo no es válido.');
    }
    $dateFrom = svl_inbox_date('date_from');
    $dateTo = svl_inbox_date('date_to');
    if ($dateFrom !== '' && $dateTo !== '' && $dateFrom > $dateTo) {
        throw new InvalidArgumentException('La fecha inicial no puede ser posterior a la final.');
    }
    $page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT,
        array('options' => array('min_range' => 1, 'max_range' => 100000)));
    if ($page === false) {
        $page = 1;
        throw new InvalidArgumentException('La página solicitada no es válida.');
    }
    foreach (array('id' => 'id', 'submission' => 'submissionId') as $parameter => $variable) {
        if (isset($_GET[$parameter])) {
            $$variable = filter_var($_GET[$parameter], FILTER_VALIDATE_INT,
                array('options' => array('min_range' => 1)));
            if ($$variable === false) {
                $$variable = null;
                throw new InvalidArgumentException('El identificador de la solicitud no es válido.');
            }
        }
    }
    $connection = svl_forms_connection();
    $ready = svl_forms_ready($connection);
    $counts['contact'] = (int) svl_inbox_rows($connection, 'SELECT COUNT(*) AS total FROM presupuesto')[0]['total'];
    $counts['newsletter'] = (int) svl_inbox_rows($connection, 'SELECT COUNT(*) AS total FROM nuevos_mails')[0]['total'];

    // Old inbox detail links used ledger IDs. Resolve them before applying the new views.
    if (in_array($requestedView, array('', 'new'), true) && $id !== null) {
        $legacy = $ready ? svl_inbox_rows($connection,
            'SELECT id, kind, reference_id FROM svl_form_submissions WHERE id=?', array($id)) : array();
        if (!$legacy && $requestedView === 'new') {
            http_response_code(404);
            $error = 'No se ha encontrado esta solicitud.';
        } elseif ($legacy && $legacy[0]['kind'] === 'contact') {
            $view = 'contacts';
            $id = (int) $legacy[0]['reference_id'];
            $submissionId = null;
        } elseif ($legacy) {
            $view = 'newsletter';
            $submissionId = (int) $legacy[0]['id'];
            $id = null;
        }
    }
    if (($view === 'newsletter' && $id !== null) || ($view === 'contacts' && $submissionId !== null)) {
        throw new InvalidArgumentException('El identificador no corresponde a esta sección.');
    }

    $mailColumns = $ready
        ? "s.id AS submission_id, COALESCE(s.mail_status, 'unknown') AS mail_status, s.mail_subject, s.mail_html, s.mail_text, s.mail_headers, s.payload, s.created_at"
        : "NULL AS submission_id, 'unknown' AS mail_status, NULL AS mail_subject, NULL AS mail_html, NULL AS mail_text, NULL AS mail_headers, NULL AS payload, NULL AS created_at";
    if ($view === 'contacts') {
        $destination = svl_inbox_parameter('destination', 100);
        $origin = svl_inbox_parameter('origin', 100);
        $destinations = array_column(svl_inbox_rows($connection,
            "SELECT DISTINCT TRIM(destino) AS value FROM presupuesto WHERE TRIM(destino)<>'' ORDER BY value"), 'value');
        $origins = array_column(svl_inbox_rows($connection,
            "SELECT DISTINCT TRIM(sitio) AS value FROM presupuesto WHERE TRIM(sitio)<>'' ORDER BY value"), 'value');
        $columns = 'p.id_presupuesto, p.nombre, p.apellido_1, p.apellido_2, p.email, p.destino, p.date_last_added, '
            .'p.adulto, p.ninos, p.vuelo, p.hora_recordatorio, p.comenzando_fecha, p.ciudad, p.phone, p.comentarios, p.sitio, p.ip, '.$mailColumns;
        $from = ' FROM presupuesto p';
        if ($ready) {
            $from .= " LEFT JOIN (SELECT reference_id, MAX(id) AS submission_id FROM svl_form_submissions WHERE kind='contact' GROUP BY reference_id) last_mail ON last_mail.reference_id=p.id_presupuesto"
                .' LEFT JOIN svl_form_submissions s ON s.id=last_mail.submission_id';
        }
        $dateColumn = 'p.date_last_added';
        $searchColumn = "CONCAT_WS(' ', p.nombre, p.apellido_1, p.apellido_2, p.email, p.phone)";
        $order = ' ORDER BY p.date_last_added DESC, p.id_presupuesto DESC';
        if ($id !== null && $error === '') {
            $selected = svl_inbox_rows($connection, 'SELECT '.$columns.$from.' WHERE p.id_presupuesto=?', array($id));
            $detail = $selected[0] ?? null;
        }
    } else {
        $listFilter = svl_inbox_parameter('list', 6);
        if ($listFilter !== '' && filter_var($listFilter, FILTER_VALIDATE_INT,
            array('options' => array('min_range' => -32768, 'max_range' => 32767))) === false) {
            throw new InvalidArgumentException('La lista seleccionada no es válida.');
        }
        $lists = array_map('strval', array_column(svl_inbox_rows($connection,
            'SELECT DISTINCT lista AS value FROM nuevos_mails ORDER BY lista'), 'value'));
        $columns = 'm.email, m.lista, m.fecha, '.$mailColumns;
        $from = ' FROM nuevos_mails m';
        if ($ready) {
            $from .= " LEFT JOIN (SELECT email, MAX(id) AS submission_id FROM svl_form_submissions WHERE kind='newsletter' GROUP BY email) last_mail"
                .' ON m.lista=5 AND CONVERT(m.email USING utf8mb4) COLLATE utf8mb4_spanish_ci=last_mail.email'
                .' LEFT JOIN svl_form_submissions s ON s.id=last_mail.submission_id';
        }
        $dateColumn = 'm.fecha';
        $searchColumn = 'm.email';
        $order = ' ORDER BY m.fecha DESC, m.email, m.lista';
        if ($submissionId !== null && $error === '' && $ready) {
            $selected = svl_inbox_rows($connection,
                "SELECT s.email, 5 AS lista, s.created_at AS fecha, s.id AS submission_id, s.mail_status, s.mail_subject, s.mail_html, s.mail_text, s.mail_headers, s.payload, s.created_at FROM svl_form_submissions s WHERE s.id=? AND s.kind='newsletter'",
                array($submissionId));
            $detail = $selected[0] ?? null;
        }
    }
    if (($id !== null || $submissionId !== null) && $detail === null && $error === '') {
        http_response_code(404);
        $error = 'No se ha encontrado esta solicitud.';
    }
    if ($id === null && $submissionId === null && $error === '') {
        $where = $parameters = array();
        if ($search !== '') {
            $where[] = $searchColumn." LIKE ? ESCAPE '='";
            $parameters[] = svl_inbox_like($search);
        }
        if ($dateFrom !== '') {
            $where[] = $dateColumn.' >= ?';
            $parameters[] = $dateFrom.' 00:00:00';
        }
        if ($dateTo !== '') {
            $where[] = $dateColumn.' <= ?';
            $parameters[] = $dateTo.' 23:59:59';
        }
        if ($view === 'contacts' && $destination !== '') {
            $where[] = 'TRIM(p.destino)=?';
            $parameters[] = $destination;
        }
        if ($view === 'contacts' && $origin !== '') {
            $where[] = 'TRIM(p.sitio)=?';
            $parameters[] = $origin;
        }
        if ($view === 'newsletter' && $listFilter !== '') {
            $where[] = 'm.lista=?';
            $parameters[] = (int) $listFilter;
        }
        $mailColumn = $ready ? "COALESCE(s.mail_status, 'unknown')" : "'unknown'";
        if ($mailFilter === 'review') {
            $where[] = $mailColumn." IN ('pending', 'failed')";
        } elseif ($mailFilter !== '') {
            $where[] = $mailColumn.'=?';
            $parameters[] = $mailFilter;
        }
        $filterSql = $where ? ' WHERE '.implode(' AND ', $where) : '';
        $filteredCount = (int) svl_inbox_rows($connection,
            'SELECT COUNT(*) AS total'.$from.$filterSql, $parameters)[0]['total'];
        $parameters[] = 50;
        $parameters[] = ($page - 1) * 50;
        $rows = svl_inbox_rows($connection, 'SELECT '.$columns.$from.$filterSql.$order.' LIMIT ? OFFSET ?', $parameters);
        $hasNext = $page * 50 < $filteredCount;
    }
} catch (Throwable $exception) {
    if ($exception instanceof InvalidArgumentException) {
        http_response_code(400);
        $error = $exception->getMessage();
    } else {
        http_response_code(503);
        $error = 'No se ha podido consultar la lista. Comprueba que MySQL esté iniciado.';
        error_log('SVL inbox data unavailable (code '.(int) $exception->getCode().').');
    }
} finally {
    if ($connection instanceof mysqli) {
        $connection->close();
    }
}
