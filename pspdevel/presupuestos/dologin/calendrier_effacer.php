<?php
	require 'include/verifLogin.php';
	if(!isset($_REQUEST['id']))
		exit('ERRORE: Identificatore non specificato 4');
	$id = $_REQUEST['id'];
	if(!is_numeric($id))
		exit('ERRORE: Identificatore non numerico');
	execute_sql("DELETE FROM calendario WHERE id=$id") or die(mysqli_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Cancelarzione impegno dal calendario</title>
	<link href="presupuestos.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<p align="center">L'impegno &egrave; stato cancellato dal calendario.</p>
<!--<p align="center"><input type="button" value="Atr&aacute;s" onClick="location.href='index.php'"></p>-->

<script language="JavaScript" type="text/javascript">
<!--
	window.opener.location.reload();
	window.close();
//-->
</script>

</body>
</html>