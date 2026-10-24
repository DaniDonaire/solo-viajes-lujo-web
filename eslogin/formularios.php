<?php
/** Contact and newsletter views. Protected by eslogin/.htaccess on Apache. */
require __DIR__.'/includes/inbox-data.php';
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store, private');
header('X-Content-Type-Options: nosniff');
header("Content-Security-Policy: default-src 'none'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; form-action 'self'; frame-ancestors 'none'; base-uri 'none'");

$title = $view === 'contacts' ? 'Contactos' : 'Suscriptores de newsletter';
$fieldLabels = array(
    'name' => 'Nombre', 'last_name' => 'Primer apellido', 'last_name_2' => 'Segundo apellido',
    'email' => 'Email', 'destination' => 'Destino', 'travel_date' => 'Fecha del viaje',
    'departure_city' => 'Ciudad de salida', 'phone' => 'Teléfono', 'comments' => 'Comentarios',
    'adults' => 'Adultos', 'children' => 'Niños', 'flight' => 'Vuelo incluido',
    'contact_time' => 'Horario de contacto', 'trip_id' => 'Referencia del viaje',
    'nombre' => 'Nombre', 'apellido_1' => 'Primer apellido', 'apellido_2' => 'Segundo apellido',
    'destino' => 'Destino', 'comenzando_fecha' => 'Fecha del viaje', 'ciudad' => 'Ciudad de salida',
    'adulto' => 'Adultos', 'ninos' => 'Niños', 'vuelo' => 'Vuelo incluido',
    'hora_recordatorio' => 'Horario de contacto', 'comentarios' => 'Comentarios',
    'date_last_added' => 'Fecha de guardado', 'id_presupuesto' => 'Referencia del presupuesto',
    'sitio' => 'Origen', 'ip' => 'Dirección IP', 'source' => 'Página de origen',
    'lista' => 'Lista', 'fecha' => 'Fecha del correo preparado',
);
$mailOptions = array('' => 'Todos', 'review' => 'Pendientes o fallidos', 'pending' => 'Pendiente',
    'captured' => 'Capturado en local', 'accepted' => 'Aceptado por el servidor',
    'failed' => 'Fallido', 'unknown' => 'Sin registro');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo svl_inbox_escape($title); ?> · Solo Viajes de Lujo</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f9f9f9;color:#444;font:14px/1.5 Arial,sans-serif}
        header{background:#333;color:white;padding:18px 20px;border-bottom:2px solid #c29b4d}header p{margin:4px 0 0;color:#ddd}h1{font-size:24px;font-weight:normal;margin:0}
        main{max-width:1300px;margin:20px auto;padding:0 20px}a{color:#78591f}nav{display:flex;gap:8px;flex-wrap:wrap;margin:16px 0}
        nav a{padding:9px 13px;background:white;border:1px solid #ccc;text-decoration:none}nav a.active{background:#c29b4d;color:#222;border-color:#c29b4d}
        .panel{background:#fff;border:1px solid #ddd;padding:18px;margin:16px 0}.muted{color:#777}.notice{background:#eee;padding:10px 14px;border-left:3px solid #c29b4d}
        .error{background:#fff0ed;border-left-color:#a33;color:#922}form{display:flex;align-items:end;gap:12px;flex-wrap:wrap}label{display:block;font-weight:bold;font-size:13px;margin-bottom:4px}input,select,button{font:inherit;padding:8px;border:1px solid #bbb;border-radius:0}input[type=search]{min-width:240px}input[type=date]{width:155px}select{max-width:270px}button{background:#c29b4d;color:#222;cursor:pointer;border-color:#b18b42}
        .results-count{margin:14px 0 0;color:#777;font-size:13px}.scroll{overflow:auto}table{width:100%;border-collapse:collapse;font-size:14px}th,td{text-align:left;vertical-align:top;padding:11px 10px;border-bottom:1px solid #ddd}th{background:#eee;white-space:nowrap}.status{display:inline-block;font-size:12px;padding:3px 6px;background:#eee;white-space:nowrap}.status.failed{background:#fff0ed;color:#922}.status.captured{background:#f4eddf;color:#78591f}.status.accepted{background:#edf4eb;color:#315c27}small{display:block;margin-top:3px;color:#777}
        dl{display:grid;grid-template-columns:minmax(140px,220px) 1fr;gap:0;margin:0}dt,dd{margin:0;padding:9px 0;border-bottom:1px solid #eee;overflow-wrap:anywhere}dt{font-weight:bold}dd{white-space:pre-wrap}pre{white-space:pre-wrap;overflow-wrap:anywhere;font:14px/1.6 Arial,sans-serif}.pager{display:flex;gap:20px;align-items:center}.back{display:inline-block;margin-bottom:5px}h2{font-size:17px;margin:0 0 14px}.empty{padding:24px;text-align:center;color:#777}
        @media(max-width:600px){main{padding:0 10px}header{padding:16px}h1{font-size:22px}.panel{padding:14px}dl{grid-template-columns:1fr}dt{border-bottom:0;padding-bottom:0}dd{padding-top:2px}form>div{width:100%}input[type=search],input[type=date],select{min-width:0;width:100%;max-width:none}}
    </style>
</head>
<body class="svl-admin-page">
<?php require __DIR__.'/includes/menu.php'; ?>
<header><h1><?php echo svl_inbox_escape($title); ?></h1><p>Solo Viajes de Lujo · Administración</p></header>
<main>
    <a class="back" href="admin_especialidad_visul.php">Volver al inicio del panel</a>
    <nav aria-label="Contactos y newsletter">
        <a class="<?php echo $view === 'contacts' ? 'active' : ''; ?>" href="formularios.php?view=contacts">Contactos<?php echo isset($counts['contact']) ? ' (' . (int) $counts['contact'] . ')' : ''; ?></a>
        <a class="<?php echo $view === 'newsletter' ? 'active' : ''; ?>" href="formularios.php?view=newsletter">Newsletter<?php echo isset($counts['newsletter']) ? ' (' . (int) $counts['newsletter'] . ')' : ''; ?></a>
    </nav>
    <?php if ($error !== ''): ?>
        <p class="notice error" role="alert"><?php echo svl_inbox_escape($error); ?></p>
    <?php elseif ($detail !== null): ?>
        <?php
        $detailStatus = $detail['mail_status'] ?? 'unknown';
        $payload = svl_inbox_payload($detail['payload'] ?? '');
        if ($view === 'contacts') {
            $fields = array();
            foreach (array('id_presupuesto', 'date_last_added', 'nombre', 'apellido_1', 'apellido_2', 'email',
                'phone', 'destino', 'comenzando_fecha', 'ciudad', 'adulto', 'ninos', 'vuelo',
                'hora_recordatorio', 'comentarios', 'sitio', 'ip') as $field) {
                if (array_key_exists($field, $detail)) {
                    $fields[$field] = $detail[$field];
                }
            }
            if (array_key_exists('name', $payload)) {
                $fields = array('id_presupuesto' => $detail['id_presupuesto'], 'date_last_added' => $detail['date_last_added']) + $payload;
            }
        } else {
            $fields = array('email' => $detail['email'], 'lista' => $detail['lista'], 'fecha' => $detail['fecha']);
            if (isset($payload['source'])) {
                $fields['source'] = $payload['source'];
            }
        }
        ?>
        <a href="<?php echo svl_inbox_escape(svl_inbox_url()); ?>">Volver al listado</a>
        <section class="panel">
            <h2><?php echo $view === 'contacts' ? 'Solicitud #' . (int) $detail['id_presupuesto'] : 'Email y último correo'; ?></h2>
            <p><strong>Datos guardados.</strong> Correo: <span class="status <?php echo svl_inbox_escape($detailStatus); ?>"><?php echo svl_inbox_escape(svl_inbox_status($detailStatus)); ?></span></p>
            <?php if ($detailStatus === 'failed'): ?><p class="notice error">El correo ha fallado. Los datos permanecen guardados.</p><?php elseif ($detailStatus === 'unknown'): ?><p class="notice">No consta el resultado del correo para este registro.</p><?php endif; ?>
            <dl>
                <?php foreach ($fields as $key => $value): ?>
                    <dt><?php echo svl_inbox_escape($fieldLabels[$key] ?? $key); ?></dt>
                    <dd><?php echo svl_inbox_escape(svl_inbox_value($key, $value)); ?></dd>
                <?php endforeach; ?>
            </dl>
        </section>
        <?php if (!empty($detail['submission_id'])): ?>
            <section class="panel">
                <h2>Correo preparado</h2>
                <p><strong>Para:</strong> <?php echo svl_inbox_escape($detail['email']); ?><br><strong>Asunto:</strong> <?php echo svl_inbox_escape($detail['mail_subject'] ?? ''); ?></p>
                <pre><?php echo svl_inbox_escape($detail['mail_text'] ?? ''); ?></pre>
                <details><summary>Ver código del correo HTML</summary><pre><?php echo svl_inbox_escape($detail['mail_html'] ?? ''); ?></pre></details>
            </section>
        <?php endif; ?>
    <?php else: ?>
        <section class="panel">
            <h2>Buscar y filtrar</h2>
            <form method="get" action="formularios.php">
                <input type="hidden" name="view" value="<?php echo svl_inbox_escape($view); ?>">
                <div><label for="search"><?php echo $view === 'contacts' ? 'Nombre, email o teléfono' : 'Email'; ?></label><input id="search" name="q" value="<?php echo svl_inbox_escape($search); ?>" maxlength="254" type="search" autocomplete="off"></div>
                <div><label for="date-from">Desde</label><input id="date-from" name="date_from" value="<?php echo svl_inbox_escape($dateFrom); ?>" type="date"></div>
                <div><label for="date-to">Hasta</label><input id="date-to" name="date_to" value="<?php echo svl_inbox_escape($dateTo); ?>" type="date"></div>
                <?php if ($view === 'contacts'): ?>
                    <div><label for="destination">Destino</label><select id="destination" name="destination"><option value="">Todos</option><?php foreach ($destinations as $option): ?><option value="<?php echo svl_inbox_escape($option); ?>"<?php echo $destination === (string) $option ? ' selected' : ''; ?>><?php echo svl_inbox_escape($option); ?></option><?php endforeach; ?></select></div>
                    <div><label for="origin">Origen</label><select id="origin" name="origin"><option value="">Todos</option><?php foreach ($origins as $option): ?><option value="<?php echo svl_inbox_escape($option); ?>"<?php echo $origin === (string) $option ? ' selected' : ''; ?>><?php echo svl_inbox_escape($option); ?></option><?php endforeach; ?></select></div>
                <?php else: ?>
                    <div><label for="list">Lista</label><select id="list" name="list"><option value="">Todas</option><?php foreach ($lists as $option): ?><option value="<?php echo svl_inbox_escape($option); ?>"<?php echo $listFilter === (string) $option ? ' selected' : ''; ?>><?php echo svl_inbox_escape($option); ?></option><?php endforeach; ?></select></div>
                <?php endif; ?>
                <div><label for="mail">Correo</label><select id="mail" name="mail"><?php foreach ($mailOptions as $statusValue => $statusLabel): ?><option value="<?php echo svl_inbox_escape($statusValue); ?>"<?php echo $mailFilter === $statusValue ? ' selected' : ''; ?>><?php echo svl_inbox_escape($statusLabel); ?></option><?php endforeach; ?></select></div>
                <button type="submit">Filtrar</button><a href="formularios.php?view=<?php echo svl_inbox_escape($view); ?>">Limpiar</a>
            </form>
            <p class="results-count"><?php echo number_format($filteredCount, 0, ',', '.'); ?> resultados</p>
        </section>
        <section class="panel scroll" aria-label="Resultados">
            <?php if (!$rows): ?><p class="empty">No hay registros para estos filtros.</p>
            <?php elseif ($view === 'contacts'): ?>
                <table><thead><tr><th>Fecha</th><th>Contacto</th><th>Destino</th><th>Adultos / niños</th><th>Vuelo</th><th>Correo</th><th>Detalle</th></tr></thead><tbody>
                <?php foreach ($rows as $row): ?>
                    <tr><td><?php echo svl_inbox_escape($row['date_last_added']); ?></td><td><?php echo svl_inbox_escape(trim($row['nombre'] . ' ' . $row['apellido_1'] . ' ' . $row['apellido_2'])); ?><br><?php echo svl_inbox_escape($row['email']); ?><?php if ($row['phone'] !== ''): ?><small><?php echo svl_inbox_escape($row['phone']); ?></small><?php endif; ?></td><td><?php echo svl_inbox_escape($row['destino']); ?></td><td><?php echo svl_inbox_escape($row['adulto']); ?> / <?php echo svl_inbox_escape($row['ninos']); ?></td><td><?php echo svl_inbox_escape(svl_inbox_value('vuelo', $row['vuelo'])); ?></td><td><span class="status <?php echo svl_inbox_escape($row['mail_status']); ?>"><?php echo svl_inbox_escape(svl_inbox_status($row['mail_status'])); ?></span></td><td><a href="<?php echo svl_inbox_escape(svl_inbox_url(array('id' => (int) $row['id_presupuesto']))); ?>">Ver</a></td></tr>
                <?php endforeach; ?></tbody></table>
            <?php else: ?>
                <table><thead><tr><th>Fecha</th><th>Email</th><th>Lista</th><th>Último correo</th><th>Detalle</th></tr></thead><tbody>
                <?php foreach ($rows as $row): ?>
                    <tr><td><?php echo svl_inbox_escape($row['fecha']); ?></td><td><?php echo svl_inbox_escape($row['email']); ?></td><td><?php echo svl_inbox_escape($row['lista']); ?></td><td><span class="status <?php echo svl_inbox_escape($row['mail_status']); ?>"><?php echo svl_inbox_escape(svl_inbox_status($row['mail_status'])); ?></span></td><td><?php if (!empty($row['submission_id'])): ?><a href="<?php echo svl_inbox_escape(svl_inbox_url(array('submission' => (int) $row['submission_id']))); ?>">Ver</a><?php else: ?>—<?php endif; ?></td></tr>
                <?php endforeach; ?></tbody></table>
            <?php endif; ?>
        </section>
        <p class="pager"><?php if ($page > 1): ?><a href="<?php echo svl_inbox_escape(svl_inbox_url(array('page' => $page - 1))); ?>">Anterior</a><?php endif; ?><span>Página <?php echo (int) $page; ?></span><?php if ($hasNext): ?><a href="<?php echo svl_inbox_escape(svl_inbox_url(array('page' => $page + 1))); ?>">Siguiente</a><?php endif; ?></p>
    <?php endif; ?>
    <?php if ($view === 'newsletter'): ?><p class="muted">El estado muestra el último correo de confirmación registrado para cada email.</p><?php endif; ?>
    <p class="notice">«Sin registro» indica que no consta el resultado del correo. «Capturado en local» significa que se ha guardado sin enviarlo. «Aceptado por el servidor» no confirma su recepción. Un fallo del correo no elimina los datos guardados.</p>
</main>
</body>
</html>
