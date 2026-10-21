<?php
	require '../include/verifLogin.php';
	$user = $_SESSION['user'];
	$level = $user['level'];
	// Checks login has been performed and level is Administrator
	if($level != 'A')
		header('Location:index.php');
	for($i = 0; $i <= 9; $i++) {
		$statut_counts[$i] = array();
		$statut_html[$i] = '';
	}
	// *****************************************************
	// Get "presupuestos en attente de vos devis" for each vendor
	// *****************************************************
	$result = execute_sql("SELECT vendeur,COUNT(*) FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut INNER JOIN email_contact e ON d.email=e.email WHERE s.id=1 AND e.vendu='si' GROUP BY vendeur");
	if($result === FALSE)
		exit(mysqli_error());
	while(list($vendeur, $count) = mysqli_fetch_row($result))
		$statut_counts[1][$vendeur] = $count;
	// ***************************************
	// Get item for each state and each vendor
	// ***************************************
	$result = execute_sql("SELECT s.id,seguimiento,COUNT(*) FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE s.id<>1 GROUP BY seguimiento,d.statut ORDER BY s.id,seguimiento");
	if($result === FALSE)
		exit(mysqli_error());
	while(list($statut_id, $seguimiento, $count) = mysqli_fetch_row($result))
		switch($statut_id) {
			case 3:
				$statut_counts[3][$seguimiento] = $count;
				$statut_counts[4][$seguimiento] = $count;
				break;
			case 4:
				// Sum up "presupuestos &agrave; relancer" with "presupuestos envoy&eacute;s"
				$statut_counts[4][$seguimiento] += $count;
				break;
			case 6:
				$statut_counts[6][$seguimiento] = $count;
				$statut_counts[7][$seguimiento] = $count;
				break;
			case 7:
				// Sum up "contrats &agrave; relancer" with "contrats envoy&eacute;s"
				$statut_counts[7][$seguimiento] += $count;
				break;
			default:
				$statut_counts[$statut_id][$seguimiento] = $count;
		}
	// ********************************
	// Create HTML for each statut list
	// ********************************
	for($i = 0; $i <= 9; $i++)
		foreach($statut_counts[$i] as $seguimiento => $count) {
			if($seguimiento == '')
				$seguimiento = 'senza venditore';
			$statut_html[$i] .= '<li>'.$seguimiento.': '.$count.'</li>';
		}
	$template = file_get_contents('../templates/sommario_estado.html');
	$template = str_replace(
		array('$sommaire1', '$sommaire2', '$sommaire3', '$sommaire4', '$sommaire5', '$sommaire6', '$sommaire7', '$sommaire8', '$sommaire9', '$sommaire0'),
		array($statut_html[1], $statut_html[2], $statut_html[3], $statut_html[4], $statut_html[5], $statut_html[6], $statut_html[7], $statut_html[8], $statut_html[9], $statut_html[0]),
		$template
	);
	echo $template;
?>