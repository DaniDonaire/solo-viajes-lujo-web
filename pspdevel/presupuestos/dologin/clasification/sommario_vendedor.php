<?php
	require '../include/verifLogin.php';
	$user = $_SESSION['user'];
	$level = $user['level'];
	// Checks login has been performed and level is Administrator
	if($level != 'A')
		header('Location:index.php');
	// Get the full list of vendor usernames
	$result = execute_sql("SELECT pseudo FROM admin WHERE level<>'A' ORDER BY pseudo");
	if($result === FALSE)
		exit(mysqli_error());
	$vendorsList = '';
	while(list($username) = mysqli_fetch_row($result)) {
		$vendors[$username] = $username;
		$vendorsList .= '<input type="submit" name="vendeur" value="'.$username.'" style="width:120px"><br/>';
	}
	// Gets the nickname of the currently selected vendor
	// If empty, or not existing, assume "Pilar"
	if(empty($_REQUEST['vendeur']))
		$vendeur = 'Pilar';
	else {
		$vendeur = $_REQUEST['vendeur'];
		if(!isset($vendors[$vendeur]))
			$vendeur = 'Pilar';
	}
	// This single SQL query counts all items for each status
	// without having to issue multiple queries
	// Only items owned by this user are displayed, with the exception of waiting items
	// (these are always displayed, because not initially owned by anybody)
	$result = execute_sql("SELECT s.id,COUNT(*) FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE s.id=1 OR seguimiento='$vendeur' GROUP BY d.statut");
	if($result === FALSE)
		exit('SQL error 0 : '.mysqli_error());
	$statusCount = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	while(list($status, $count) = mysqli_fetch_row($result))
		$statusCount[$status] = $count;
	// Get "presupuestos en attente de vos devis"
	$result = execute_sql("SELECT COUNT(*) FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut INNER JOIN email_contact e ON d.email=e.email WHERE s.id=1 AND e.vendeur='$vendeur' AND e.vendu='si'");
	if($result === FALSE)
		exit('SQL error 1 : '.mysqli_error());
	if($row = mysqli_fetch_row($result))
		$countVosClients = $row[0];
	// Get "presupuestos en attente de autres devis"
	$result = execute_sql("SELECT COUNT(*) FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut LEFT JOIN email_contact e ON d.email=e.email AND vendu<>'si' WHERE s.id=1");
	if($result === FALSE)
		exit('SQL error 2 : '.mysqli_error());
	if($row = mysqli_fetch_row($result))
		$countAutresClients = $row[0];
	$template = file_get_contents('../templates/sommario_vendedor.html');
	$template = str_replace(
		array('$pseudo', '$vendorsList', '$devisVosClients', '$devisAutresClients', '$devisSauvegardes', '$devisARelancer', '$devisEnvoyes', '$contratsSauvegardes', '$contratsARelancer', '$contratsEnvoyes', '$contratsViernesdu', '$emailEnvoyes', '$devisArchives'),
		array($vendeur, $vendorsList, $countVosClients, $countAutresClients, $statusCount[2], $statusCount[3], $statusCount[3] + $statusCount[4], $statusCount[5], $statusCount[6], $statusCount[6] + $statusCount[7], $statusCount[8], $statusCount[9], $statusCount[0]),
		$template
	);
	echo $template;
?>