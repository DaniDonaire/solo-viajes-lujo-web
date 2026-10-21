<?php
require_once __DIR__ . '/../config/database.php';

function seConnecter_phplist() {
	$svlDb = svl_database_configuration('newsletter');
	$host_db = $svlDb['host'];
	$db_name = $svlDb['database'];
	$user_db = $svlDb['user'];
	$pass_db = $svlDb['password'];
	$socket = isset($svlDb['socket']) && $svlDb['socket'] !== '' ? $svlDb['socket'] : null;
	$link = new mysqli($host_db, $user_db, $pass_db, $db_name, 0, $socket);

	if ($link->connect_error) {
		die('Error de Conexi�nnn (' . $link->connect_errno . ') '. $link->connect_error);
	}

	$link->set_charset("utf8");
	return $link;

}

function seDeconnecter_phplist($link) {
	mysqli_close($link);
}

function execute_sql_phplist($sql) {
 
 try {
	//$nom="/log/logg-".date("Y-m-d").".log";
	//$ddf = fopen($nom,'a'); 
	//fwrite($ddf,"[".date("r")."] Sql : $sql \r\n"); 

	$mysqli = seConnecter_phplist();
	$query = $mysqli -> query ($sql);
	
	seDeconnecter_phplist($mysqli);
	
	//fwrite($ddf,mysqli_num_rows($query) ); 

	return $query;
} catch (Exception $e) {
	//fwrite($ddf,"[".date("r")."] Excepci�n capturada : $e->getMessage() \r\n"); 
	echo 'Excepci�n capturada : $e->getMessage()';
}
  //fclose($ddf); 
}

function execute_insert_sql_phplist($sql) {
 
 try {
	//$nom="/log/logg-".date("Y-m-d").".log";
	//$ddf = fopen($nom,'a'); 
	//fwrite($ddf,"[".date("r")."] Sql : $sql \r\n"); 

	$mysqli = seConnecter_phplist();
	$query = $mysqli -> query ($sql);
	
	$id= mysqli_insert_id($mysqli);
	seDeconnecter_phplist($mysqli);
	
	//fwrite($ddf,mysqli_num_rows($query) ); 

	//return mysqli_insert_id($mysqli);
	return $id;
	//return $query;
} catch (Exception $e) {
	//fwrite($ddf,"[".date("r")."] Excepci�n capturada : $e->getMessage() \r\n"); 
	echo 'Excepci�n capturada : $e->getMessage()';
}
  //fclose($ddf); 
}

function num_rows_phplist($result) {
	$link = seConnecter_phplist();
	$rows = mysql_num_rows($result);
	seDeconnecter_phplist($link);
	return $rows;
}

function sqlInsert_phplist($tableau,$champs){
		
	$noms=implode(',',array_keys($champs));

	foreach($champs as $nom => $valeur){
		if(is_null($valeur)) {
			$champs[$nom]='NULL';
		} else {
			$champs[$nom]=$valeur;
		}
	}
	$result="INSERT INTO $tableau($noms) VALUES(".implode(',',$champs).")";
	execute_sql($result);

}
	
	function toMySQLDate($textDate) {
		if(!preg_match('!^(\d\d*)/(\d\d*)/(\d{4})( \d\d:\d\d:\d\d)?$!', $textDate, $matches))
			return '';
		if(empty($matches[4]))
			return $matches[3].'-'.$matches[2].'-'.$matches[1];
		return $matches[3].'-'.$matches[2].'-'.$matches[1].$matches[4];
	}
	

?>
