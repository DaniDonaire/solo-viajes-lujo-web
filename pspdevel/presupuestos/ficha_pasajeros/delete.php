<?php
require_once __DIR__ . '/../../../config/database.php';
$svlPrivateConfiguration = svl_configuration();
$svlPassengerExportToken = isset($svlPrivateConfiguration['passenger_export_token']) ? (string) $svlPrivateConfiguration['passenger_export_token'] : '';
	// *********************************************************************
	// This script deletes all "ficha pasajeros" having the specified items.
	// It is called only after ensuring data have been stored correctly.
	// Written by Massimiliano Alessandri (m.alessandri@volaincrociera.com)
	// *********************************************************************
	// Password based protection (later, it will be replaced by IP protection)
	if ($svlPassengerExportToken === '' || !isset($_REQUEST['password']) || !is_string($_REQUEST['password']) || !hash_equals($svlPassengerExportToken, $_REQUEST['password']))
		exit();
	require '../../include/sql.php';
	$n = '';
	$identifiers = array();
	while(!empty($_REQUEST['id'.$n])) {
		$id = $_REQUEST['id'.$n];
		if(is_numeric($id))
			$identifiers[$id] = $id;
		if($n == '')
			$n = 2;
		else
			$n++;
	}
	execute_sql('DELETE FROM boleto_direccion WHERE id IN('.implode(',', $identifiers).')');
	execute_sql('DELETE FROM ficha_pasajeros WHERE id IN('.implode(',', $identifiers).')');
	echo 'DELETED '.implode(' ', $identifiers);
?>