<?php
	require 'include/verifLogin.php';
	if(!$id_presupuesto = getParametre('id'))
		$id_presupuesto = getParametre('id_presupuesto');
	if(!$id_presupuesto)
		exit('ERRORE: Identificatore non specificato 7');
	if(!is_numeric($id_presupuesto))
		exit('ERRORE: Identificatore non numerico');
	// ********************
	// Get all status names
	// ********************
	$result = execute_sql('SELECT id,statut FROM statut ORDER BY id');
	if($result === FALSE)
		exit('ERRORE SQL: '.mysqli_error());
	while(list($s_id, $s_nom) = mysqli_fetch_row($result))
		$statuts[$s_id] = $s_nom;
	if(!execute_sql("UPDATE $tablename SET statut='$statuts[1]',seguimiento='' WHERE id_presupuesto=$id_presupuesto"))
		exit(mysqli_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Recupera pratica cancellata</title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<p align="center">La pratica &egrave; stata recuperata</p>
<!--<p align="center"><input type="button" value="Atr&aacute;s" onClick="location.href='index.php'"></p>-->

<script language="JavaScript" type="text/javascript">
<!--
	window.opener.location.reload();
	window.close();
//-->
</script>

</body>
</html>