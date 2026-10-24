<?php
/** Environment configuration. Never put production credentials in this file. */
function svl_configuration()
{
    static $configuration = null;
    if ($configuration !== null) {
        return $configuration;
    }
    $privateFile = getenv('SVL_CONFIG_FILE') ?: __DIR__.'/local.php';
    if (is_file($privateFile) && strtolower(pathinfo($privateFile, PATHINFO_EXTENSION)) !== 'php') {
        throw new RuntimeException('SVL_CONFIG_FILE must be a PHP file returning an array.');
    }
    $private = is_file($privateFile) ? require $privateFile : array();
    if (!is_array($private)) {
        throw new RuntimeException('Invalid private SVL configuration.');
    }
    $candidate = $private;
    foreach (array('env' => 'SVL_ENV', 'base_path' => 'SVL_BASE_PATH',
                   'mail_capture_dir' => 'SVL_MAIL_CAPTURE_DIR',
                   'registration_token' => 'SVL_REGISTRATION_TOKEN',
                   'passenger_export_token' => 'SVL_PASSENGER_EXPORT_TOKEN') as $key => $variable) {
        $value = getenv($variable);
        if ($value !== false) {
            $candidate[$key] = $value;
        } elseif (!isset($candidate[$key])) {
            $candidate[$key] = $key === 'env' ? 'production' : '';
        }
    }
    if (!is_string($candidate['env']) || !in_array($candidate['env'], array('production', 'local', 'staging'), true)) {
        throw new RuntimeException('Unknown SVL environment.');
    }
    if (!is_string($candidate['base_path']) || strlen($candidate['base_path']) > 255) {
        throw new RuntimeException('SVL_BASE_PATH must be an empty path or a site subdirectory.');
    }
    $candidate['base_path'] = rtrim($candidate['base_path'], '/');
    if ($candidate['base_path'] !== ''
        && !preg_match('~^(?:/[A-Za-z0-9][A-Za-z0-9_-]*)+$~D', $candidate['base_path'])) {
        throw new RuntimeException('SVL_BASE_PATH contains an unsafe path.');
    }
    if ($candidate['env'] === 'staging') {
        if ($candidate['base_path'] === '') {
            throw new RuntimeException('Staging requires its own non-root SVL_BASE_PATH.');
        }
        $databases = array();
        foreach (array('web', 'newsletter') as $role) {
            $databases[] = svl_resolve_database_configuration($candidate, $role)['database'];
        }
        if ($databases[0] === $databases[1]) {
            throw new RuntimeException('Staging web and newsletter databases must be distinct.');
        }
        $capture = $candidate['mail_capture_dir'];
        if (!is_string($capture) || $capture === '' || $capture[0] !== '/'
            || preg_match('~(?:^|/)\.{1,2}(?:/|$)|[\x00-\x1f]~', $capture)) {
            throw new RuntimeException('Staging requires an absolute private mail_capture_dir.');
        }
        $capture = rtrim($capture, '/');
        $roots = array(realpath(dirname(__DIR__)));
        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            $roots[] = realpath($_SERVER['DOCUMENT_ROOT']);
        }
        foreach ($roots as $root) {
            if ($root !== false && ($capture === $root || strpos($capture, $root.'/') === 0)) {
                throw new RuntimeException('Staging mail captures must stay outside the public directory.');
            }
        }
        if ($capture === '') {
            throw new RuntimeException('Staging requires a private mail_capture_dir.');
        }
        $candidate['mail_capture_dir'] = $capture;
    }
    // Cache only a fully validated profile; failures must not expose partial settings.
    $configuration = $candidate;
    return $configuration;
}

function svl_resolve_database_configuration(array $configuration, $role)
{
    if (!in_array($role, array('web', 'newsletter'), true)) {
        throw new InvalidArgumentException('Unknown SVL database role.');
    }
    $database = isset($configuration['databases'][$role]) ? $configuration['databases'][$role] : array();
    if (!is_array($database)) {
        throw new RuntimeException('Invalid SVL database profile.');
    }
    $prefix = $role === 'web' ? 'SVL_WEB_DB_' : 'SVL_NEWSLETTER_DB_';
    foreach (array('host' => 'HOST', 'database' => 'NAME', 'user' => 'USER',
                   'password' => 'PASSWORD', 'socket' => 'SOCKET') as $key => $suffix) {
        $value = getenv($prefix.$suffix);
        if ($value !== false) {
            $database[$key] = $value;
        } elseif (!isset($database[$key])) {
            $database[$key] = $key === 'host' ? 'localhost' : '';
        }
    }
    foreach (array('host', 'database', 'user', 'password', 'socket') as $key) {
        if (!is_string($database[$key])) {
            throw new RuntimeException('Invalid SVL database field.');
        }
    }
    if ($database['database'] === '' || $database['user'] === '') {
        throw new RuntimeException('SVL database not configured. See config/local.example.php.');
    }
    if ($configuration['env'] === 'staging'
        && !preg_match('/_(?:preprod|staging)_/i', $database['database'])) {
        throw new RuntimeException('Staging only accepts dedicated databases named with _preprod_ or _staging_.');
    }
    return $database;
}

function svl_database_configuration($role)
{
    return svl_resolve_database_configuration(svl_configuration(), $role);
}

function svl_is_test_environment()
{
    return in_array(svl_configuration()['env'], array('local', 'staging'), true)
        || PHP_SAPI === 'cli' || PHP_SAPI === 'cli-server';
}
