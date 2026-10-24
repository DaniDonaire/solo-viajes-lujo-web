<?php
/** Shared administration entry point; catalogue actions keep their existing URLs. */
require_once __DIR__.'/../../include/forms.php';
header('Content-Type: text/html; charset=UTF-8');
header('Cache-Control: no-store, private');
header('X-Content-Type-Options: nosniff');
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline'; img-src 'self' data:; form-action 'self'; frame-ancestors 'none'; base-uri 'none'");

function svl_dashboard_escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function svl_dashboard_number($value)
{
    return $value === null ? '—' : number_format((int) $value, 0, ',', '.');
}

$isLocal = svl_configuration()['env'] === 'local';
$countryValue = $_GET['id_destino'] ?? ($_POST['id_destino'] ?? '0');
$countryId = filter_var($countryValue, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0)));
$error = $countryId === false ? 'El destino seleccionado no es válido.' : '';
if ($error !== '') {
    $countryId = 0;
    http_response_code(400);
}
$countries = array();
$specialties = array();
$counts = array('contacts' => null, 'newsletter' => null);
$connection = null;
try {
    $connection = svl_forms_connection();
    $counts['contacts'] = (int) $connection->query('SELECT COUNT(*) FROM presupuesto')->fetch_row()[0];
    $counts['newsletter'] = (int) $connection->query('SELECT COUNT(*) FROM nuevos_mails')->fetch_row()[0];
    $countries = $connection->query('SELECT id_pais, nombre_pais FROM paises_svl ORDER BY nombre_pais')->fetch_all(MYSQLI_ASSOC);
    if ($countryId > 0 && !in_array($countryId, array_map('intval', array_column($countries, 'id_pais')), true)) {
        $error = 'El destino seleccionado no existe.';
        http_response_code(400);
    }
    if ($error === '') {
        $statement = $connection->prepare('SELECT d.id_destino, d.destino, d.activo, p.nombre_pais FROM destinos_svl d LEFT JOIN paises_svl p ON p.id_pais=d.id_pais WHERE (?=0 OR d.id_pais=?) ORDER BY p.nombre_pais, d.destino');
        $statement->execute(array($countryId, $countryId));
        $specialties = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        $statement->close();
    }
} catch (Throwable $exception) {
    http_response_code(503);
    $error = 'No se han podido cargar los datos del panel. Comprueba que MySQL esté iniciado.';
    error_log('SVL dashboard data unavailable (code '.(int) $exception->getCode().').');
} finally {
    if ($connection instanceof mysqli) {
        $connection->close();
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Panel de administración · Solo Viajes de Lujo</title>
</head>
<body class="svl-admin-page">
<?php require __DIR__.'/menu.php'; ?>
<main class="svl-admin-main">
    <header class="svl-admin-heading">
        <h1>Administración</h1>
    </header>

    <?php if ($error !== ''): ?><p class="svl-admin-note svl-admin-error" role="alert"><?php echo svl_dashboard_escape($error); ?></p><?php endif; ?>
    <section class="svl-admin-section" aria-label="Resumen de formularios">
        <h2>Contactos y newsletter</h2>
        <table class="svl-admin-summary"><tbody>
            <tr><th scope="row">Contactos</th><td><?php echo svl_dashboard_number($counts['contacts']); ?></td><td><a href="formularios.php?view=contacts">Ver contactos</a></td></tr>
            <tr><th scope="row">Suscriptores newsletter</th><td><?php echo svl_dashboard_number($counts['newsletter']); ?></td><td><a href="formularios.php?view=newsletter">Ver suscriptores</a></td></tr>
        </tbody></table>
    </section>

    <section class="svl-admin-section" id="especialidades">
        <div class="svl-admin-section-heading"><h2>Especialidades por destino</h2><a class="svl-admin-button" href="admin_especialidad_add.php">Añadir especialidad</a></div>
        <form class="svl-admin-filter" method="get" action="admin_especialidad_visul.php">
            <div><label for="id-destino">Destino</label><select id="id-destino" name="id_destino"><option value="0">Todos los destinos</option><?php foreach ($countries as $country): ?><option value="<?php echo (int) $country['id_pais']; ?>"<?php echo $countryId === (int) $country['id_pais'] ? ' selected' : ''; ?>><?php echo svl_dashboard_escape($country['nombre_pais']); ?></option><?php endforeach; ?></select></div>
            <button class="svl-admin-button" type="submit">Filtrar</button><span class="svl-admin-muted"><?php echo count($specialties); ?> especialidades</span>
        </form>
        <div class="svl-admin-table-wrap">
            <table class="svl-admin-table"><thead><tr><th scope="col">Especialidad / ruta</th><th scope="col">Destino</th><th scope="col">Estado</th><th scope="col">Acciones</th></tr></thead><tbody>
            <?php foreach ($specialties as $specialty): ?>
                <tr><td><strong><?php echo svl_dashboard_escape($specialty['destino']); ?></strong></td><td><?php echo svl_dashboard_escape($specialty['nombre_pais']); ?></td><td><span class="svl-admin-status<?php echo (string) $specialty['activo'] === '1' ? ' is-active' : ''; ?>"><?php echo (string) $specialty['activo'] === '1' ? 'Activa' : 'Inactiva'; ?></span></td><td><div class="svl-admin-actions"><a href="admin_especialidad_modif.php?id=<?php echo (int) $specialty['id_destino']; ?>">Visualizar / editar</a><?php if ($isLocal): ?><span class="svl-admin-muted" title="El borrado está desactivado en la vista local">Quitar · desactivado en local</span><?php else: ?><a class="svl-admin-danger" href="admin_especialidad_supp.php?id=<?php echo (int) $specialty['id_destino']; ?>" onclick="return confirm('¿Seguro que quieres borrar esta especialidad?');">Quitar</a><?php endif; ?></div></td></tr>
            <?php endforeach; ?>
            <?php if (!$specialties): ?><tr><td colspan="4" class="svl-admin-muted">No hay especialidades para este filtro.</td></tr><?php endif; ?>
            </tbody></table>
        </div>
    </section>
    <?php if ($isLocal): ?><p class="svl-admin-note">Vista local del administrador. Los formularios de contacto y newsletter guardan en la copia local; las acciones antiguas de guardar o borrar contenidos permanecen desactivadas en esta vista.</p><?php endif; ?>
</main>
</body>
</html>
