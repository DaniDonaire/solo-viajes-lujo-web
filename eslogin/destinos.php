<?php
header('Content-Type: application/json; charset=UTF-8');
$valor = $_POST['id_pais'] ?? '';
$idPais = filter_var($valor === '' ? '0' : $valor, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0)));
if ($idPais === false) {
    echo '[]';
    return;
}

require_once __DIR__.'/includes/execute_sql_admin.php';

$connection = seConnecter();
$statement = $connection->prepare('SELECT CAST(id_destino AS CHAR) AS id_destino, destino FROM destinos_svl WHERE ? = 0 OR id_pais = ?');
$statement->bind_param('ii', $idPais, $idPais);
$statement->execute();
echo json_encode($statement->get_result()->fetch_all(MYSQLI_BOTH), JSON_INVALID_UTF8_SUBSTITUTE);
