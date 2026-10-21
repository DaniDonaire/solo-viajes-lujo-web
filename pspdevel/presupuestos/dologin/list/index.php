<?php
	// This file is externally included and uses the variable $type
	// which should be already set (can be passed as a parameter if remotely including
	// or if register_globals is set to On and URL is ca lasd with type parameter
	require '../include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	ob_start();
	require '../format_date.php';
	$fields = "d.id_presupuesto,s.id AS statut_id,d.statut,date_last_added,date_trait,IF(apellido_2='',apellido_1,CONCAT(apellido_1,' ',apellido_2)) AS apellido,nombre,d.email,date_last_added,compania,buque,sitio,comenzando_fecha,comentarios";
	// ************************************************
	// Loads different content depending on user choice
	// ************************************************
	if(!isset($_GET['type']))
		$type = 1;
	else
		$type = $_GET['type'];
	$sortBy = empty($_GET['sort']) ? 1 : $_GET['sort'];
	if($type == 'v' || $type == 'o' || $type == 'a')
		$dateField = 'date_last_added';
	else
		$dateField = 'date_trait';
	switch($sortBy) {
		case 2:
			$orderBy = 'statut';
			break;
		case 3:
			$orderBy = 'apellido_1,apellido_2,nombre';
			break;
		case 4:
			$orderBy = 'comenzando_fecha';
			break;
		case 5:
			$orderBy = 'compania';
			break;
		case 6:
			$orderBy = 'buque';
			break;
		case 7:
			$orderBy = 'sitio';
			break;
		case 8:
			$orderBy = 'seguimiento';
			break;
		default:
			$orderBy = $dateField;
	}
	if(!empty($_GET['dir']) && $_GET['dir'] != 'asc') {
		$orderBy .= ' DESC';
		$reverseDir = 'asc';
	}
	else
		$reverseDir = 'desc';
	for($i = 1; $i <= 8; $i++) {
		if($sortBy == $i)
			$sortArrow[$i] = $reverseDir == 'desc' ? '&darr;' : '&uarr;';
		else
			$sortArrow[$i] = '';
	}
	$displaySuivi = FALSE;
	$relanceParameter = '';
	switch($type) {
		case 'v':
			$title = 'Presupuestos en espera de vuestros clientes';
			$result = execute_sql("SELECT $fields FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut AND s.id=1 INNER JOIN email_contact e ON d.email=e.email AND e.vendeur='$pseudo' AND e.vendu='si' WHERE date_last_added>'2007-07-23 00:00:00' ORDER BY $orderBy");
			break;
		case 'o':
			$title = 'Presupuestos en espera de otros clientes';
			// Get all "presupuestos en attente de autres devis"
			// These are: customers which I did not sold anything, and which
			// other vendors did not sell anything too
			$result = execute_sql("SELECT $fields,vendeur AS seguimiento FROM presupuesto d LEFT JOIN email_contact e ON d.email=e.email INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND s.id=1 AND (vendu IS NULL OR vendu='no') ORDER BY $orderBy");
			$displaySuivi = TRUE;
			break;
		case 'de':
			$title = 'Presupuestos enviados';
			$result = execute_sql("SELECT $fields FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND s.id IN(3,4) AND seguimiento='$pseudo' ORDER BY $orderBy");
			break;
		case 'ce':
			$title = 'Contratos enviados';
			$result = execute_sql("SELECT $fields FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND s.id IN(6,7) AND seguimiento='$pseudo' ORDER BY $orderBy");
			break;
		case 'r':
			$title = 'Busqueda';
			if(!empty($_REQUEST['busqueda']))
				$busqueda = $_REQUEST['busqueda'];
			else
				$busqueda = '';
			if(is_numeric($busqueda))
				$condition = "d.id_presupuesto=$busqueda OR id_crucero=$busqueda";
			else
				$condition = "apellido_1 LIKE '$busqueda%' OR apellido_2 LIKE '$busqueda%' OR email LIKE '%$busqueda%' OR buque LIKE '%$busqueda%'";
			$result = execute_sql("SELECT $fields,seguimiento FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND ($condition) ORDER BY $orderBy");
			$displaySuivi = TRUE;
			break;
		case 'a':
			$title = 'Presupuestos cancelados';
			$result = execute_sql("SELECT $fields FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND s.id=0 AND seguimiento='$pseudo' ORDER BY $orderBy");
			break;
		case 2:
			$title = 'Presupuestos memorizados';
			break;
		case 3:
			$title = 'Presupuestos para reenviar';
			// Notas: This extra parameter will tell presupuesto_visual.php
			// to only display Relanc&eacute; and Sortir buttons
			$relanceParameter = 'relance=1&';
			break;
		case 4:
			$title = 'Presupuestos reenviados';
			break;
		case 5:
			$title = 'Contratos memorizados';
			break;
		case 6:
			$title = 'Contratos para reenviar';
			// Notas: This extra parameter will tell contrato_visual.php
			// to only display Relanc&eacute; and Sortir buttons
			$relanceParameter = 'relance=1&';
			break;
		case 7:
			$title = 'Contratos enviados';
			break;
		case 8:
			$title = 'Contratos vendidos';
			break;
		case 9:
			$title = 'Email remitidos';
			break;
		case '10':			
		  // revista-organiza
		  $title = 'revista-organiza';
			$result = execute_sql("SELECT $fields FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND sitio='$pseudo' ORDER BY $orderBy");
			//$result = execute_sql("SELECT $fields FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut");
			break;
		default:
			// No parameters specified: get all items
			$result = execute_sql("SELECT $fields FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND seguimiento='$pseudo' ORDER BY $orderBy");
	}
	if($type >= 2 && $type <= 9)
		$result = execute_sql("SELECT $fields FROM presupuesto d INNER JOIN statut s ON d.statut=s.statut WHERE date_last_added>'2007-07-23 00:00:00' AND s.id=$type AND seguimiento='$pseudo' ORDER BY $orderBy");
	if($result === FALSE)
		exit('SQL ERREUR: '.mysqli_error());
	$lignes = @mysqli_num_rows($result);
	$url = $_SERVER['SCRIPT_NAME'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<title><?=$title?></title>
	<script language="JavaScript" type="text/javascript">
	<!--
		function edit(statut_id, item_id) {
			if(statut_id == 1 || statut_id == 2)
				url = "formulaire_presupuesto.php";
			else if(statut_id == 0 || statut_id == 3 || statut_id == 4)
				url = "presupuesto_visual.php";
			else if(statut_id == 5)
				url = "formulaire_contrato.php";
			else if(statut_id == 6 || statut_id == 7 || statut_id == 8)
				url = "contrato_visual.php";
			else if(statut_id == 9)
				url = "email_visual.php";
			else
				return false;
			window.open("../" + url + "?<?=$relanceParameter?>id_presupuesto=" + item_id, "formulaire", "toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,menuBar=no,width=640,height=700,left=100,top=50");
			return true;
		}
		function edit_organiza(statut_id, item_id) {
			url = "presupuesto_visual_organiza.php";
			window.open("../" + url + "?<?=$relanceParameter?>id_presupuesto=" + item_id, "formulaire", "toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,menuBar=no,width=640,height=700,left=100,top=50");
			return true;
		}
		function sort(field) {
			url = "<?=$url?>?sort=" + field;
			if(field == <?=$sortBy?>)
				url += "&dir=<?=$reverseDir?>";
			location.href = url;
		}
	//-->
	</script>
	<link href="../presupuestos.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<h2 align="center"><?=$title?></h2>
<?php
	if($lignes == 0) {
?>
<p align="center">Vuestra b&uacute;squeda no ha dado resultado</p>
<?php
	}
	else {
?>
<table width="800" border="0" align="center">
	<tr>
		<td width="155" align="left" class="textarea"><?=$pseudo;?></td>
		<td align="center"><A HREF="#" onclick="document.location.reload();return(false)" class="error">Actualiza la p&aacute;gina antes de coger un presupuesto</A></td>
		<td align="right" nowrap><a href="../index.php">Volver al men&uacute; resumen</a></td>
	</tr>
	<tr>
		<td colspan="3"><table id="table0" class="sortable" width="100%" align="center" border="0">
			<tr>
				<th class="listheader" onClick="sort(1)">Fecha<?=$sortArrow[1]?></th>
<?php
				//<th class="listheader" onClick="sort(2)">Statut$sortArrow[2]</th>
?>
				<th class="listheader" onClick="sort(3)" nowrap>Apellido &amp; Nombre<?=$sortArrow[3]?></th>
				<th class="listheader" onClick="sort(4)" nowrap>Fecha part.<?=$sortArrow[4]?></th>
				<th class="listheader" onClick="sort(5)">Proveedor<?=$sortArrow[5]?></th>
				<th class="listheader" onClick="sort(6)">Estancia<?=$sortArrow[6]?></th>
				<th class="listheader" onClick="sort(7)">Sitio<?=$sortArrow[7]?></th>
<?php
		if($displaySuivi) {
?>
<th class="listheader" onClick="sort(8)" nowrap>Seguimiento efectuado por<?=$sortArrow[8]?></th>
<?php
		}
?>
			</tr>
<?php
		while( $RS = @mysqli_fetch_array($result) ) {
			$id_presupuesto = $RS['id_presupuesto'];
			$statut_id = $RS['statut_id'];
			$statut = $RS['statut'];
			$date_column = $RS[$dateField];
			$apellido = $RS['apellido'];
			$nombre = $RS['nombre'];
			$email = $RS['email'];
			$comenzando_fecha = $RS['comenzando_fecha'];
			$compania = $RS['compania'];
			$buque = $RS['buque'];
			$comentarios = trim($RS['comentarios']);
			$sitio = $RS['sitio'];
			$date = strncmp($date_column, '0000-00-00', 10) == 0 ? '-' : date('d/m/Y', strtotime($date_column));
			$comenzando_fecha_a = strncmp($comenzando_fecha, '0000-00-00', 10) == 0 ? '-' : date('d/m/Y', strtotime($comenzando_fecha));
			if($comentarios != '')
				$comentarios = <<<HTML
<img name="comment" src="../images/comment.png" alt="Comentarios" title="$comentarios" border="0">
HTML;
?>
<?php
	if($type != '10') {
?>
			<tr align="justify" class="list" onClick="edit(<?=$statut_id?>,<?=$id_presupuesto?>)">
<?php
	}
	else {
?>
			<tr align="justify" class="list" onClick="edit_organiza(<?=$statut_id?>,<?=$id_presupuesto?>)">
<?php
		}
?>

				
				<td><font size=2><?=$date?></font></td>
<?php
				//<td nowrap>$statut</td>
?>
				<td nowrap><?=$apellido.' '.$nombre?></td>
				<td align="center"><?=$comenzando_fecha_a?></td>
				<td nowrap><?=$compania?></td>
				<td nowrap><?=$buque?></td>
				<td nowrap><?=$sitio?></td>
<?php
			if($displaySuivi) {
				$seguimiento = $RS['seguimiento'];
?>
				<td nowrap><?=$seguimiento?></td>
<?php
			}
?>
				<td width="20"><?=$comentarios?></td>
				<td><img src="../images/email.gif" width="20" alt="E mail" title="<?=$email?>" border="0"></td>
			</tr>
<?php
		}
?>
		</table></td>
	</tr>
</table>
<?php
	}
?>

<?php
	if($type != '10') {
?>
<p align="center"><a href="../index.php">Volver al men&uacute; resumen</a></p>
<?php
	}
	else {
?>
<p align="center"><a href="../salida.php">Salir</a></p>
<?php
		}
?>

</body>
</html>