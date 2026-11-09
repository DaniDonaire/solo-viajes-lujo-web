<?php
require_once __DIR__.'/../../include/form-error.php';
require_once __DIR__.'/execute_sql_admin.php';

class SvlAdminFormError extends RuntimeException
{
}

function svl_admin_form($list, callable $save)
{
    $json = stripos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;
    header('Cache-Control: no-store');
    try {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            header('Allow: POST');
            throw new SvlAdminFormError('Abre el formulario del panel para guardar los cambios.', 405);
        }
        if (svl_configuration()['env'] !== 'production') {
            throw new SvlAdminFormError('La publicación del catálogo está desactivada en esta vista de pruebas.', 403);
        }
        if (!$_POST && !$_FILES && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
            throw new SvlAdminFormError('El servidor no ha podido leer el formulario. Comprueba el tamaño de la imagen.', 413);
        }
        $message = $save();
        if (!$json) {
            return $message;
        }
        $response = array('success' => true, 'message' => $message, 'redirect' => $list);
    } catch (Throwable $error) {
        $status = 503;
        if ($error instanceof SvlAdminFormError) {
            $message = $error->getMessage();
            $status = $error->getCode() ?: 422;
        } else {
            error_log('SVL admin form failed ('.get_class($error).', code '.(int) $error->getCode().').');
            $message = 'El servidor no ha podido confirmar el guardado. Comprueba el listado antes de volver a publicar.';
            if ($error instanceof mysqli_sql_exception) {
                switch ($error->getCode()) {
                    case 1062: $message = 'Ya existe un registro con estos datos.'; $status = 409; break;
                    case 1146: $message = 'La base de datos del catálogo no está preparada para guardar este formulario.'; break;
                    case 1406: $message = 'Uno de los campos supera la longitud que admite el catálogo.'; $status = 422; break;
                    case 1452: $message = 'El destino o lanzamiento relacionado ya no está disponible.'; $status = 422; break;
                    case 1044: case 1045: case 2002: case 2003:
                        $message = 'No se ha podido conectar con la base de datos para guardar los cambios.';
                        break;
                }
            }
        }
        if (!$json) {
            svl_render_form_error($message, $status, $list);
        }
        http_response_code($status);
        $response = array('success' => false, 'message' => $message);
    }
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

function svl_admin_text($key, $label, $required = false)
{
    $value = $_POST[$key] ?? '';
    if (!is_string($value) || ($required && trim($value) === '')) {
        throw new SvlAdminFormError('Revisa el campo «'.$label.'».');
    }
    return $value;
}

function svl_admin_number($key, $label, $minimum = 1, $default = null)
{
    $value = trim(svl_admin_text($key, $label));
    if ($value === '' && $default !== null) {
        return $default;
    }
    if ($value !== '' && ctype_digit($value)) {
        $value = ltrim($value, '0') ?: '0';
    }
    $number = filter_var($value, FILTER_VALIDATE_INT, array('options' => array('min_range' => $minimum)));
    if ($number === false) {
        throw new SvlAdminFormError('Revisa el campo «'.$label.'».');
    }
    return $number;
}

function svl_admin_save($sql, array $values, ?callable $publish = null, $mustCopy = false)
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $connection = seConnecter(MYSQLI_CLIENT_FOUND_ROWS);
    try {
        $connection->begin_transaction();
        $statement = $connection->prepare($sql);
        $statement->execute($values);
        if ($connection->warning_count > 0) {
            throw new SvlAdminFormError('La base de datos no ha podido guardar los campos tal como se enviaron. Revisa su longitud y formato.');
        }
        if ($statement->affected_rows === 0) {
            $message = $mustCopy ? 'La oferta seleccionada ya no existe o el lanzamiento de destino no está disponible.'
                : 'El registro que intentas guardar ya no está disponible. Vuelve al listado y abre la ficha de nuevo.';
            throw new SvlAdminFormError($message, 404);
        }
        if ($publish !== null) {
            $publish();
        }
        $connection->commit();
    } finally {
        // Closing the connection rolls back any transaction that did not reach commit.
        $connection->close();
    }
}

function svl_admin_image($required = false)
{
    $image = $_FILES['imagen'] ?? array('error' => UPLOAD_ERR_NO_FILE);
    $error = $image['error'] ?? null;
    if ($error === UPLOAD_ERR_NO_FILE && !$required) {
        return null;
    }
    if ($error === UPLOAD_ERR_NO_FILE) {
        throw new SvlAdminFormError('Selecciona una imagen para publicar.');
    }
    if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
        throw new SvlAdminFormError('La imagen supera el tamaño permitido por el servidor.', 413);
    }
    if ($error === UPLOAD_ERR_PARTIAL) {
        throw new SvlAdminFormError('La imagen se ha recibido incompleta. Vuelve a seleccionarla.');
    }
    if ($error !== UPLOAD_ERR_OK || !is_uploaded_file($image['tmp_name'])) {
        throw new SvlAdminFormError('El servidor no ha podido recibir la imagen.', 503);
    }
    $info = @getimagesize($image['tmp_name']);
    $extensions = array(IMAGETYPE_JPEG => array('jpg', 'jpeg'), IMAGETYPE_PNG => array('png'),
        IMAGETYPE_GIF => array('gif'), IMAGETYPE_WEBP => array('webp'));
    $name = basename($image['name']);
    if (!$info || !in_array(strtolower(pathinfo($name, PATHINFO_EXTENSION)), $extensions[$info[2]] ?? array(), true)
        || preg_match('/[\x00-\x1f\\\\]/', $name) || $name[0] === '.' || substr_count($name, '.') !== 1) {
        throw new SvlAdminFormError('Selecciona una imagen JPG, PNG, GIF o WebP con una extensión válida. Usa un nombre sin puntos adicionales.');
    }
    return array('name' => $name, 'tmp_name' => $image['tmp_name']);
}

function svl_admin_directory($directory)
{
    if (!is_dir($directory) && !@mkdir($directory, 0777, true) && !is_dir($directory)) {
        throw new SvlAdminFormError('El servidor no ha podido crear la carpeta de publicación. Revisa los permisos del alojamiento.', 503);
    }
}

function svl_admin_template($template, $destination)
{
    if (!is_file($destination) && !@copy($template, $destination)) {
        throw new SvlAdminFormError('No se ha podido crear la página desde su plantilla. Revisa la plantilla y los permisos del alojamiento.', 503);
    }
}

function svl_admin_store_image(array $image, $path)
{
    svl_admin_directory(dirname($path));
    if (!@move_uploaded_file($image['tmp_name'], $path)) {
        throw new SvlAdminFormError('La imagen llegó al servidor, pero no se pudo guardar. Revisa los permisos y el espacio del alojamiento.', 503);
    }
}

function svl_admin_slug($name)
{
    setlocale(LC_CTYPE, 'es_ES');
    $transliterated = @iconv('UTF-8', 'ASCII//TRANSLIT', trim($name));
    $slug = $transliterated === false ? '' : str_replace(' ', '-', $transliterated);
    if ($slug === '' || $slug[0] === '.' || preg_match('~[/?#\\\\\x00-\x1f]~', $slug)) {
        throw new SvlAdminFormError('El nombre no se puede usar para crear una página. Revisa los caracteres del nombre.');
    }
    return $slug;
}
