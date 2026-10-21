<?php
	require '../../../include/sqlfunctions.php';
		
	echo '1';
	
	function sqlUpdate2($tableau,$champs,$condition = ''){
		echo '4\n';

		$q=array();
		foreach($champs as $nom=>$valeur){
			echo 'f ';
			echo $nom;
			echo ' - ';
			echo $valeur;
			if(is_null($valeur))$q[]=$nom.'=NULL';
			else $q[]=$nom."='".addslashes($valeur)."'";
		}
		$q=implode(',',$q);
		if($condition != '')
			$q .= ' WHERE '.$condition;
		//return sqlQuery("UPDATE $tableau SET $q");
		//return execute_sql("UPDATE $tableau SET $q");
		echo("UPDATE $tableau SET $q");
	}
	echo '2\n';
	
	$a = array(
    "uno" => 1,
    "dos" => 2,
    "tres" => 3,
    "diecisiete" => 17
		);
print_r( array_values($a));

	$data = array(
		"nombre" => "nombree",
		"email_direct" => "emaill",
		"tel_direct" => "telephonee",
		"pseudo" => "pseudoo",
		"level" => "levell"
	);
	print_r( array_values($data));
	
	sqlUpdate2('admin', $data, 'id_membre='.$id);
	
?>