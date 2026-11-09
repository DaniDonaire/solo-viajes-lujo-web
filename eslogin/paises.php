<?php
header('Content-Type: application/json; charset=UTF-8');
$nombre = $_POST['nombre_pais'] ?? '';
if (!is_string($nombre) || $nombre === '' || $nombre === '0') {
    echo '[]';
    return;
}

require_once __DIR__.'/includes/execute_sql_admin.php';

$connection = seConnecter();
$statement = $connection->prepare('SELECT CAST(id_pais AS CHAR) AS id_pais, nombre_pais FROM paises_svl WHERE nombre_pais = ?');
$statement->bind_param('s', $nombre);
$statement->execute();
echo json_encode($statement->get_result()->fetch_all(MYSQLI_BOTH), JSON_INVALID_UTF8_SUBSTITUTE);
