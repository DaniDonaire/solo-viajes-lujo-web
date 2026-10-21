<?php
	require '../../include/sql.php';
	$currentDate = date ('Y-m-d H:i:s');
	if(empty($_GET['id_rand']))
		exit('ERROR: No identifier specified');
	$id_rand = $_GET['id_rand'];
	$sql = "SELECT compania,buque,comenzando_fecha,tarifas_nombre,ref_dossier,adulto,ninos FROM presupuesto WHERE id_rand='".addslashes($id_rand)."'";
	$result = execute_sql($sql,$link);
	if($result === FALSE)
		exit('ERROR: Cannot display contract - database error');
	if(!$croisiere = mysqli_fetch_assoc($result))
		exit('ERROR: Contract not found');
	$template = file_get_contents('ficha.html');
	// Get the passenger table, to be repeated for each passenger
	$tot_pass = $croisiere['adulto'] + $croisiere['ninos'];
	if(preg_match('!^(.+)<div id="pasajero">(.+?)</div>(.+)$!is', $template, $matches)) {
		$template = $matches[1];
		$toBeCompleted = true;
	}
	else
		$toBeCompleted = false;
	$template = str_replace(
		array('$id_rand', '$tot_pass', '$compania', '$buque', '$comenzando_fecha', '$tarifas_nombre', '$ref_dossier'),
		array($id_rand, $tot_pass, $croisiere['compania'], $croisiere['buque'], date('d/m/Y', strtotime($croisiere['comenzando_fecha'])), !empty($croisiere['tarifas_nombre']) ? $croisiere['tarifas_nombre'] : '&nbsp;', !empty($croisiere['ref_dossier']) ? $croisiere['ref_dossier'] : '&nbsp;'),
		$template
	);
	if($toBeCompleted) {
		// Note: Additional box are displayed, initially invisible,
		// to enter data for more passengers up to 5
		for($i = 1; $i <= $tot_pass; $i++) {
			// Do not display the "copier" button
			if($i == 1 && preg_match('!^(.+)<input id="copier"[^>]*>(.+)$!is', $matches[2], $submatches))
				$subtemplate = $submatches[1].$submatches[2];
			else
				$subtemplate = $matches[2];
			$template .= str_replace('$n', $i, $subtemplate);
		}
		$template .= "\t<div style=\"text-align:right\"><a id=\"linkadd$tot_pass\" href=\"JavaScript:ajouterPasajero($tot_pass)\" style=\"display:inline\">Adjuntar un pasajero</a></div>\n";
		for($i = $tot_pass + 1; $i <= 5; $i++) {
			$template .= "\t\t\t<div id=\"additional$i\" style=\"display:none\">\n".str_replace('$n', $i, $matches[2])."\n\t\t\t</div>\n";
			if($i < 5)
				$template .= "\t<div style=\"text-align:right\"><a id=\"linkadd$i\" style=\"display:none\" href=\"JavaScript:ajouterPasajero($i)\" style=\"display:inline\">Adjuntar un pasajero</a></div>";
		}
		$template .= $matches[3];
	}
	echo $template;
?>