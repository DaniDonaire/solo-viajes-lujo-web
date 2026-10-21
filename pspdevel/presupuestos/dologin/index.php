<?php
	require 'include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	$level = $user['level'];
	if($level == 'A') {
		$template = file_get_contents('templates/admin_menu.html');
		$template = str_replace('$pseudo', $pseudo, $template);
	}else if ($level == 'E') {
		header('Location:list/presupuestos_revista_organiza.php');
	}			
	else {
		// This single SQL query counts all items for each status
		// without having to issue multiple queries
		// Only items owned by this user are displayed, with the exception of waiting items
		// (these are always displayed, because not initially owned by anybody)
		$result = execute_sql("SELECT s.id,COUNT(*) FROM $tablename d INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND (s.id=1 OR seguimiento='$pseudo') GROUP BY d.statut");
		if($result === FALSE)
			exit('SQL error: '.mysqli_error());
		$statusCount = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		while(list($status, $count) = mysqli_fetch_row($result))
			$statusCount[$status] = $count;
		// Get "presupuestos en attente de vos devis"
		$result = execute_sql("SELECT COUNT(*) FROM $tablename d INNER JOIN statut s ON d.statut=s.statut INNER JOIN email_contact e ON d.email=e.email WHERE date_last_added>'2007-07-23 00:00:00' AND s.id=1 AND e.vendeur='$pseudo' AND e.vendu='si'");
		if($result === FALSE)
			exit('SQL error: '.mysqli_error());
		if($row = mysqli_fetch_row($result))
			$countVosClients = $row[0];
		// Get "presupuestos en attente de autres devis"
		$result = execute_sql("SELECT COUNT(*) FROM $tablename d LEFT JOIN email_contact e ON d.email=e.email INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND s.id=1 AND (vendu IS NULL OR vendu='no')");
		if($result === FALSE)
			exit('SQL error: '.mysqli_error());
		if($row = mysqli_fetch_row($result))
			$countAutresClients = $row[0];
		// Get calendar summary
		$endOfToday = date('Y-m-d 23:59:59');
		$result = execute_sql("SELECT id,fecha_recordatorio,nombre,phone,email,seguimiento FROM calendario WHERE fecha_recordatorio<='$endOfToday' AND seguimiento IN('$pseudo','todos') ORDER BY fecha_recordatorio");
		if($result === FALSE)
			exit('ERRORE SQL: '.mysqli_error());
		if($RS = mysqli_fetch_array($result)) {
			$calendarsummary = <<<HTML
						<script language="JavaScript" type="text/javascript">
						<!--
							function popup(url) {
								window.open(url, "calendario", "toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,menuBar=no,width=640,height=520,left=100,top=50");
							}
							function viewCalendar(id) {
								popup("calendario_visual.php?id=" + id);
								return true;
							}
						//-->
						</script>
						<table>
							<tr>
								<th class="listheader" nowrap>Volver a llamar al</th>
								<th class="listheader" nowrap>Apellido e nome</th>
								<th class="listheader" nowrap>Tel&eacute;fono</th>
								<th class="listheader" nowrap>Seguimiento efectuado por</th>
							</tr>
HTML;
			$now = time();
			do {
				$id = $RS['id'];
				$fecha_recordatorio = strtotime($RS['fecha_recordatorio']);
				if($now - $fecha_recordatorio > 86400)
					$styleclass = 'list2';
				else
					$styleclass = 'list';
				$fecha_recordatorio = date('d/m/Y H:i', $fecha_recordatorio);
				if(substr($fecha_recordatorio, -6) == ' 00:00')
					$fecha_recordatorio = substr($fecha_recordatorio, 0, -6);
				$nom = $RS['nom'];
				$nombre = $RS['nombre'];
				$phone = $RS['phone'];
				$email = $RS['email'];
				$date_saisie = date('d/m/Y', strtotime($RS['date_saisie']));
				$seguimiento = $RS['seguimiento'];
				if($seguimiento == '')
					$seguimiento = '(tout)';
				$calendarsummary .= <<<HTML
							<tr align="justify" class="$styleclass">
								<td nowrap>$fecha_recordatorio</td>
								<td nowrap>$nom $nombre</td>
								<td nowrap>$phone</td>
								<td nowrap>$seguimiento</td>
								<td><a href="#" onClick="viewCalendar($id)"><img name="prendre" src="images/document.png" alt="Calendario" title="Prendi" border="0"></a></td>
							</tr>
HTML;
			}
			while($RS = mysqli_fetch_assoc($result));
			$calendarsummary .= <<<HTML
						</table></td>
HTML;
		}
		else
			$calendarsummary = '';
		$template = file_get_contents('templates/users_menu.html');
		$template = str_replace(
			array('$pseudo', '$devisVosClients', '$devisAutresClients', '$devisSauvegardes', '$devisARelancer', '$devisEnvoyes', '$contratsSauvegardes', '$contratsARelancer', '$contratsEnvoyes', '$contratsViernesdu', '$emailEnvoyes', '$devisArchives', '$calendarsummary'),
			array($pseudo, $countVosClients, $countAutresClients, $statusCount[2], $statusCount[3], $statusCount[3] + $statusCount[4], $statusCount[5], $statusCount[6], $statusCount[6] + $statusCount[7], $statusCount[8], $statusCount[9], $statusCount[0], $calendarsummary),
			$template
		);
	}
	echo $template;
?>