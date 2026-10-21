<?php
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$arr = array();

if ($_POST["nombre_pais"] != ""){
	$nombre_pais = $_POST["nombre_pais"];
}


 if ($nombre_pais != '0'){
	$sql = "select id_pais,nombre_pais from paises_svl where nombre_pais = '$nombre_pais'";
 }
 else {
	$sql = "select id_pais,nombre_pais from destinos_svl";
 }

$result = execute_sql($sql);
	
	while( $RS = mysqli_fetch_array($result) ) {
		$arr[] = $RS;
	}		

echo json_encode($arr);
?>



