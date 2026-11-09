<?php
require_once __DIR__ . '/../../config/database.php';

function seConnecter($flags = 0) {
	$svlDb = svl_database_configuration('web');
	$host_db = $svlDb['host'];
	$db_name = $svlDb['database'];
	$user_db = $svlDb['user'];
	$pass_db = $svlDb['password'];
	$socket = isset($svlDb['socket']) && $svlDb['socket'] !== '' ? $svlDb['socket'] : null;
	$link = mysqli_init();
	$link->real_connect($host_db, $user_db, $pass_db, $db_name, 0, $socket, $flags);

	if ($link->connect_error) {
		die('Error de Conexiónnn (' . $link->connect_errno . ') '. $link->connect_error);
	}

	//mysql_query('SET NAMES LATIN1');
	$link->set_charset("utf8");
	return $link;

}

function seDeconnecter($link) {
	//mysql_close($link);
	mysqli_close($link);
}

function execute_sql($sql) {
	$log = false;
	if (svl_configuration()['env'] !== 'local') {
		$log = @fopen(__DIR__.'/../log/logg-'.date('Y-m-d').'.log', 'a');
	}
	$connection = null;
	try {
		if ($log !== false) {
			@fwrite($log, '['.date('r')."] Sql : $sql\r\n");
		}
		$connection = seConnecter();
		$result = $connection->query($sql);
		if ($log !== false && $result !== false) {
			$rows = $result instanceof mysqli_result ? $result->num_rows : $connection->affected_rows;
			@fwrite($log, $rows."\r\n");
		}
		return $result;
	} catch (mysqli_sql_exception $exception) {
		error_log('SVL admin query failed (code '.(int) $exception->getCode().').');
		return false;
	} finally {
		if ($connection instanceof mysqli) {
			seDeconnecter($connection);
		}
		if ($log !== false) {
			fclose($log);
		}
	}
}

function num_rows($result) {
	$link = seConnecter();
	$rows = mysql_num_rows($result);
	seDeconnecter($link);
	return $rows;
}
?>
