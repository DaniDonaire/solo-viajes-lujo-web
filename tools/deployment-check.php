<?php
/** CLI-only, read-only deployment checks. Never prints credentials or customer data. */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__.'/../config/database.php';
$report = array('php' => PHP_VERSION, 'errors' => array(), 'warnings' => array());
if (version_compare(PHP_VERSION, '8.1.0', '<')) {
    $report['errors'][] = 'PHP 8.1 or later is required; the changes were tested with PHP 8.2.';
}
foreach (array('mysqli', 'mbstring', 'curl') as $extension) {
    if (!extension_loaded($extension)) {
        $report['errors'][] = 'Missing PHP extension: '.$extension;
    }
}
if (!filter_var(ini_get('short_open_tag'), FILTER_VALIDATE_BOOLEAN)) {
    $report['warnings'][] = 'Legacy templates require short_open_tag=On. Check the web PHP configuration too.';
}
$connection = null;
try {
    $configuration = svl_configuration();
    $report['environment'] = $configuration['env'];
    $report['base_path'] = $configuration['base_path'] ?? '';
    $profile = svl_database_configuration('web');
    $report['database'] = $profile['database'];
    if (!$report['errors']) {
        require_once __DIR__.'/../include/forms.php';
        $connection = svl_forms_connection();
        $report['database_version'] = $connection->server_info;
        $statement = $connection->prepare('SELECT TABLE_NAME, ENGINE, TABLE_COLLATION FROM information_schema.TABLES WHERE TABLE_SCHEMA=? AND TABLE_NAME IN (\'presupuesto\',\'peticiones\',\'nuevos_mails\',\'svl_form_submissions\')');
        $statement->execute(array($profile['database']));
        $report['tables'] = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        $tables = array_column($report['tables'], null, 'TABLE_NAME');
        foreach (array('presupuesto', 'peticiones', 'nuevos_mails') as $table) {
            if (!isset($tables[$table])) {
                $report['errors'][] = 'Missing required table: '.$table;
            } elseif ($tables[$table]['ENGINE'] !== 'InnoDB') {
                $report['errors'][] = 'Transactional form storage requires InnoDB: '.$table;
            }
        }
        $report['forms_table_present'] = isset($tables['svl_form_submissions']);
        if (!$report['forms_table_present']) {
            $report['warnings'][] = 'Form migration has not been applied. Do not activate the new form endpoints yet.';
        } elseif ($tables['svl_form_submissions']['ENGINE'] !== 'InnoDB') {
            $report['errors'][] = 'svl_form_submissions must use InnoDB.';
        } else {
            $connection->query('SELECT id,kind,reference_id,email,payload,mail_subject,mail_html,mail_text,mail_headers,mail_status,mail_error,created_at,updated_at FROM svl_form_submissions LIMIT 0');
        }
        if (isset($tables['presupuesto']) && $tables['presupuesto']['TABLE_COLLATION'] !== 'utf8mb4_spanish_ci') {
            $report['warnings'][] = 'presupuesto still requires the UTF-8 migration.';
        }
        $report['ip_columns'] = $connection->query("SELECT TABLE_NAME,COLUMN_NAME,CHARACTER_MAXIMUM_LENGTH FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND ((TABLE_NAME='presupuesto' AND COLUMN_NAME='ip') OR (TABLE_NAME='peticiones' AND COLUMN_NAME='ip_address'))")->fetch_all(MYSQLI_ASSOC);
        $foundIpColumns = array();
        foreach ($report['ip_columns'] as $column) {
            $foundIpColumns[] = $column['TABLE_NAME'].'.'.$column['COLUMN_NAME'];
            if ((int) $column['CHARACTER_MAXIMUM_LENGTH'] < 45) {
                $report['warnings'][] = 'IP column requires 45 characters: '.$column['TABLE_NAME'].'.'.$column['COLUMN_NAME'];
            }
        }
        foreach (array('presupuesto.ip', 'peticiones.ip_address') as $requiredColumn) {
            if (!in_array($requiredColumn, $foundIpColumns, true)) {
                $report['errors'][] = 'Missing required IP column: '.$requiredColumn;
            }
        }
        if ($configuration['env'] === 'production' && empty($configuration['recaptcha_secret']) && !getenv('SVL_RECAPTCHA_SECRET')) {
            $report['errors'][] = 'Production contact forms require the private reCAPTCHA secret.';
        }
    }
} catch (Throwable $error) {
    $report['errors'][] = 'Configuration/database check failed ('.get_class($error).', code '.(int) $error->getCode().'). Check the private profile and database access.';
} finally {
    if ($connection instanceof mysqli) {
        $connection->close();
    }
}
$report['ready'] = !$report['errors'] && !$report['warnings'];
echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).PHP_EOL;
exit($report['errors'] || (in_array('--require-ready', $argv, true) && !$report['ready']) ? 1 : 0);
