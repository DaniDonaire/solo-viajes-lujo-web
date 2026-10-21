<?php
require_once __DIR__ . '/../../config/database.php';

function seConnecter() {
	$svlDb = svl_database_configuration('web');
	$host_db = $svlDb['host'];
	$db_name = $svlDb['database'];
	$user_db = $svlDb['user'];
	$pass_db = $svlDb['password'];
	$socket = isset($svlDb['socket']) && $svlDb['socket'] !== '' ? $svlDb['socket'] : null;
	$link = new mysqli($host_db, $user_db, $pass_db, $db_name, 0, $socket);

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
 
 try {
  $nom="log/logg-".date("Y-m-d").".log";
  //$ddf = fopen('error.log','a'); 
  $ddf = fopen($nom,'a'); 
  fwrite($ddf,"[".date("r")."] Sql : $sql \r\n"); 

	$mysqli = seConnecter();
	$query = $mysqli -> query ($sql);
	
	seDeconnecter($mysqli);

  //$ddf = fopen('error.log','a'); 
  fwrite($ddf,mysqli_num_rows($query) ); 
  //fwrite($ddf,"[".date("r")."] Result: $sql \r\n"); 

	return $query;
} catch (Exception $e) {
	fwrite($ddf,"[".date("r")."] Excepción capturada : $e->getMessage() \r\n"); 
}
  //fclose($ddf); 
}

function num_rows($result) {
	$link = seConnecter();
	$rows = mysql_num_rows($result);
	seDeconnecter($link);
	return $rows;
}
?>
