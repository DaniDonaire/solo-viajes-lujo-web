<?php
/** Schema-only migration for an isolated staging DB. Default mode only prints a plan. */
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__.'/../include/forms.php';
$connection = null;
try {
    if (svl_configuration()['env'] !== 'staging') {
        throw new RuntimeException('This command accepts staging only. It cannot migrate production.');
    }
    $profile = svl_database_configuration('web');
    $options = getopt('', array('apply', 'database:'));
    $apply = isset($options['apply']);
    if ($apply && ($options['database'] ?? '') !== $profile['database']) {
        throw new RuntimeException('--apply requires --database with the exact staging database name.');
    }
    $connection = svl_forms_connection();
    $before = array();
    foreach (array('presupuesto', 'peticiones', 'nuevos_mails') as $table) {
        $statement = $connection->prepare('SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=?');
        $statement->execute(array($table));
        $engine = $statement->get_result()->fetch_row()[0] ?? '';
        if ($engine !== 'InnoDB') {
            throw new RuntimeException('Missing table or nontransactional engine: '.$table);
        }
        $before[$table] = (int) $connection->query('SELECT COUNT(*) FROM `'.$table.'`')->fetch_row()[0];
    }
    $triggersBefore = $connection->query('SHOW TRIGGERS')->fetch_all(MYSQLI_ASSOC);
    foreach ($triggersBefore as $trigger) {
        if (preg_match('/\b(?:solov_ggmps|solov_wp)`?\s*\./i', $trigger['Statement'])) {
            throw new RuntimeException('A copied trigger explicitly references production; fix the staging copy first.');
        }
    }
    $queries = array(file_get_contents(__DIR__.'/schema-forms.sql'));
    $collation = $connection->query("SELECT TABLE_COLLATION FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='presupuesto'")->fetch_row()[0];
    if ($collation !== 'utf8mb4_spanish_ci') {
        $queries[] = 'ALTER TABLE presupuesto CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci';
    }
    foreach (array('presupuesto' => 'ip', 'peticiones' => 'ip_address') as $table => $column) {
        $metadata = $connection->query("SELECT CHARACTER_MAXIMUM_LENGTH,IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table' AND COLUMN_NAME='$column'")->fetch_assoc();
        if (!$metadata) {
            throw new RuntimeException('Missing IP column: '.$table.'.'.$column);
        }
        if ((int) $metadata['CHARACTER_MAXIMUM_LENGTH'] < 45) {
            $queries[] = "ALTER TABLE `$table` MODIFY `$column` VARCHAR(45) ".($metadata['IS_NULLABLE'] === 'YES' ? 'NULL' : 'NOT NULL');
        }
    }
    if (!$apply) {
        echo 'STAGING ONLY: '.$profile['database'].PHP_EOL.'Plan; no changes applied.'.PHP_EOL;
        foreach ($queries as $query) {
            echo rtrim($query, ";\r\n").';'.PHP_EOL;
        }
        exit;
    }
    foreach ($queries as $query) {
        $connection->query($query);
    }
    foreach ($before as $table => $count) {
        if ((int) $connection->query('SELECT COUNT(*) FROM `'.$table.'`')->fetch_row()[0] !== $count) {
            throw new RuntimeException('Row count changed during migration; keep staging closed and investigate.');
        }
    }
    if ($triggersBefore !== $connection->query('SHOW TRIGGERS')->fetch_all(MYSQLI_ASSOC)) {
        throw new RuntimeException('Trigger metadata changed; keep staging closed and investigate.');
    }
    echo 'Staging schema prepared. Existing row counts and triggers are unchanged.'.PHP_EOL;
} catch (Throwable $error) {
    fwrite(STDERR, 'Migration stopped ('.get_class($error).', code '.(int) $error->getCode().'): '.$error->getMessage().PHP_EOL);
    exit(1);
} finally {
    if ($connection instanceof mysqli) {
        $connection->close();
    }
}
