<?php
include('includes/sql_admin.php');
include('includes/execute_sql_admin.php');

$arr = array();

if ($_POST["id_pais"] != ""){
	$id_pais = $_POST["id_pais"];
}
else {
	$id_pais = '0';
}

 if ($id_pais != '0'){
	$sql = "select id_destino,destino from destinos_svl where id_pais = '$id_pais'";
 }
 else {
	$sql = "select id_destino,destino from destinos_svl";
 }

$result = execute_sql($sql);
	
	while( $RS = mysqli_fetch_array($result) ) {
		$arr[] = $RS;
	}		

echo json_encode($arr);
?>



