<?php
	/**
	 * Converts an italian/french date to a MySQL date
	 */
	function toMySQLDate($textDate) {
		if(!preg_match('!^(\d\d*)/(\d\d*)/(\d{4})( \d\d:\d\d:\d\d)?$!', $textDate, $matches))
			return '';
		if(empty($matches[4]))
			return $matches[3].'-'.$matches[2].'-'.$matches[1];
		return $matches[3].'-'.$matches[2].'-'.$matches[1].$matches[4];
	}
	/**
	 * Inserts a new database row into the database.
	 * @return integer the created row identifier
	 */
	function sqlInsert($tableau,$champs){
		$noms=implode(',',array_keys($champs));
		foreach($champs as $nom => $valeur)
			if(is_null($valeur)) $champs[$nom]='NULL';
			else $champs[$nom]="'".addslashes($valeur)."'";
		//$result=sqlQuery("INSERT INTO $tableau($noms) VALUES(".implode(',',$champs).')');
		//sqlQuery("INSERT INTO $tableau($noms) VALUES(".implode(',',$champs).')');
		execute_sql("INSERT INTO $tableau($noms) VALUES(".implode(',',$champs).')');
		/*
		$fhandle = fopen( '/errors'.date('Ymd').'.txt', 'a' );
		if($fhandle){
			fwrite( $fhandle, mysqli_error(). "\r\n" );
			fwrite( $fhandle, $result. "\r\n" );
			fclose(( $fhandle ));
		}
		*/
		return mysqli_insert_id();
	}
	/**
	 * Updates a row in the database.
	 */
	function sqlUpdate($tableau,$champs,$condition = ''){
		$q=array();
		foreach($champs as $nom=>$valeur){
			if(is_null($valeur))$q[]=$nom.'=NULL';
			else $q[]=$nom."='".addslashes($valeur)."'";
		}
		$q=implode(',',$q);
		if($condition != '')
			$q .= ' WHERE '.$condition;
		//return sqlQuery("UPDATE $tableau SET $q");
		return execute_sql("UPDATE $tableau SET $q");
	}
?>