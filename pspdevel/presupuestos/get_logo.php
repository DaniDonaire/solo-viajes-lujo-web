<?php
	function get_arm_logo($compania){
		$result = execute_sql("SELECT logo_enlace FROM compania WHERE nombre_compania='".addslashes($compania)."'");
		if($result === FALSE)
			trigger_error(mysqli_error());
		if(!$row = mysqli_fetch_row($result))
			return '';
		return 'Image/'.$row[0];
	}
?>