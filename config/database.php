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
    $configuration = $private;
    foreach (array('env' => 'SVL_ENV', 'registration_token' => 'SVL_REGISTRATION_TOKEN',
                   'passenger_export_token' => 'SVL_PASSENGER_EXPORT_TOKEN') as $key => $variable) {
        $value = getenv($variable);
        if ($value !== false) {
            $configuration[$key] = $value;
        } elseif (!isset($configuration[$key])) {
            $configuration[$key] = $key === 'env' ? 'production' : '';
        }
    }
    return $configuration;
}

function svl_database_configuration($role)
{
    if (!in_array($role, array('web', 'newsletter'), true)) {
        throw new InvalidArgumentException('Unknown SVL database role.');
    }
    $configuration = svl_configuration();
    $database = isset($configuration['databases'][$role]) ? $configuration['databases'][$role] : array();
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
    if ($database['database'] === '' || $database['user'] === '') {
        throw new RuntimeException('SVL database not configured. See config/local.example.php.');
    }
    return $database;
}
