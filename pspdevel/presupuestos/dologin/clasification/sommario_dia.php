<?php
	require '../include/verifLogin.php';
	$user = $_SESSION['user'];
	$level = $user['level'];
	// Checks login has been performed and level is Administrator
	if($level != 'A')
		header('Location:index.php');
	//$result = mysql_unbuffered_query("SELECT DATE(fecha),sitio,COUNT(emailhash),COUNT(DISTINCT emailhash) FROM peticiones GROUP BY DATE(fecha),sitio ORDER BY 1 DESC");
	//$result = mysql_unbuffered_query("SELECT sitio,COUNT(emailhash),COUNT(DISTINCT emailhash) FROM peticiones GROUP by sitio ORDER BY 1 DESC");
	$result = execute_sql("SELECT DATE(fecha),sitio,COUNT(emailhash),COUNT(DISTINCT emailhash) FROM peticiones GROUP BY DATE(fecha),sitio ORDER BY 1 DESC");
	if($result === FALSE)
		trigger_error(mysqli_error());
	$sommaire = array();
	while($row = mysqli_fetch_row($result)) {
		$sitio = strtolower($row[1]);
		$sommaire[$row[0]][$sitio][0] = $row[2];
		$sommaire[$row[0]][$sitio][1] = $row[3];
	}
	// ****************
	// Create HTML list
	// ****************
	$template = file_get_contents('../templates/sommario_dia.html');
	if(preg_match('!^(.+)(<tr id="listrow"[^>]*>.+?</tr>)(.+)$!is', $template, $matches)) {
		$template = $matches[1];
		foreach($sommaire as $date => $totals)
			$template .= str_replace(
				array('$date', '$total1', '$distinct1'),
				array(strncmp($date, '0000-00-00', 10) != 0 ? date('d/m/Y', strtotime($date)) : '', $totals['soloviajesdelujo'][0], $totals['soloviajesdelujo'][1]),
				$matches[2]
			);
		$template .= $matches[3];
	}
	echo $template;
?>