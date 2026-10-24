<?php
/** Prepare only the local imported database. Never runs from a web request. */
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit;
}
require_once __DIR__.'/../include/forms.php';
if (svl_configuration()['env'] !== 'local') {
    throw new RuntimeException('This setup command only accepts SVL_ENV=local.');
}
$connection = svl_forms_connection();
$connection->query(file_get_contents(__DIR__.'/schema-forms.sql'));
// Preserve accents, non-Latin names and comments without changing other tables.
$charset = $connection->query("SELECT TABLE_COLLATION FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='presupuesto'")->fetch_row()[0];
if ($charset !== 'utf8mb4_spanish_ci') {
    $connection->query('ALTER TABLE presupuesto CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci');
}
foreach (array('presupuesto' => 'ip', 'peticiones' => 'ip_address') as $table => $column) {
    $length = $connection->query("SELECT CHARACTER_MAXIMUM_LENGTH FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table' AND COLUMN_NAME='$column'")->fetch_row()[0];
    if ((int) $length < 45) {
        $connection->query("ALTER TABLE `$table` MODIFY `$column` VARCHAR(45) NOT NULL");
    }
}
echo "Recepción de formularios preparada en la base local.\n";
