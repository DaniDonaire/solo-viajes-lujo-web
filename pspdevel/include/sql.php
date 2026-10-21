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
		die('Error de Conexi�nnn (' . $link->connect_errno . ') '. $link->connect_error);
	}

	$link->set_charset("utf8");
	return $link;

}

function seConnecterOld() {
	return seConnecter();
}

function seDeconnecter($link) {
	mysqli_close($link);
}

function execute_sql($sql) {
 
 try {
	$nom="/log/logg-".date("Y-m-d").".log";
	$ddf = fopen($nom,'a'); 
	fwrite($ddf,"[".date("r")."] Sql : $sql \r\n"); 

	$mysqli = seConnecter();
	$query = $mysqli -> query ($sql);
	
	seDeconnecter($mysqli);
	
	fwrite($ddf,mysqli_num_rows($query) ); 

	return $query;
} catch (Exception $e) {
	fwrite($ddf,"[".date("r")."] Excepci�n capturada : $e->getMessage() \r\n"); 
	echo 'Excepci�n capturada : $e->getMessage()';
}
  fclose($ddf); 
}

function execute_insert_sql($sql) {
 
 try {
	//$nom="/log/logg-".date("Y-m-d").".log";
	//$ddf = fopen($nom,'a'); 
	//fwrite($ddf,"[".date("r")."] Sql : $sql \r\n"); 

	$mysqli = seConnecter();
	$query = $mysqli -> query ($sql);
	
	$id= mysqli_insert_id($mysqli);
	seDeconnecter($mysqli);
	
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

	/**
	 * Allows the script working with register_globals = off
	 * and with or without magic_quotes_gpc = on.
	 * Note: If magic_quotes_gpc is set to On, request variables are
	 * returned by PHP with added slashes, but we do not want any
	 * slash to be automatically added, because some of these fields
	 * are to be sent in automatically formatted email messages!
	 * Variables will be escaped only when writing them to MySQL.
	 * @author Massimiliano Alessandri
	 */
	 if (!function_exists('getParametre')) {
		function getParametre($name) {
			if(!isset($_REQUEST[$name]))
				return FALSE;
			if(get_magic_quotes_gpc())
				return stripslashes($_REQUEST[$name]);
			return $_REQUEST[$name];
		}
	}
	/**
	 * This function will execute a SQL query and return the resultset
	 * @return mixed the resultset
	 */
	 if (!function_exists('sqlQuery')) {	 
		function sqlQuery($sql) {
			$result = mysqli_query($sql);
			if($result === FALSE)
				exit(mysqli_error());
			return $result;
		}
	}
	
	if (!function_exists('getParametreItineraire')) {
		function getParametreItineraire($name) {
			if(!isset($_REQUEST[$name]))
				return FALSE;
			return addslashes($_REQUEST[$name]); 
		}
	}
?>