<?php
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$arr = array();

if ($_POST["nombre_especialidad"] != ""){
	$nombre_especialidad = $_POST["nombre_especialidad"];
}

 if ($nombre_especialidad != '0'){
	$sql = "select id_destino,destino from destinos_svl where destino = '$nombre_especialidad'";
 }

$result = execute_sql($sql);
	
	while( $RS = mysqli_fetch_array($result) ) {
		$arr[] = $RS;
	}		

echo json_encode($arr);
?>



