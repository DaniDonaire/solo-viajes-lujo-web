<?php
	require '../include/verifLogin.php';
	$user = $_SESSION['user'];
	$pseudo = $user['pseudo'];
	ob_start();
	require '../format_date.php';
	$now = time();
	if(isset($_REQUEST['retarde']) && $_SESSION['level'] == 'A') {
		$title = 'Calendario: acciones retrasadas';
		$sql = "SELECT id,fecha_recordatorio,nombre,phone,email,date_saisie,seguimiento,notas FROM calendario WHERE $now - UNIX_TIMESTAMP(fecha_recordatorio) > 86400 ORDER BY fecha_recordatorio";
	}
	else {
		$title = 'Calendario';
		$sql = "SELECT id,fecha_recordatorio,nombre,phone,email,date_saisie,seguimiento,notas FROM calendario WHERE seguimiento IN('$pseudo','todos') ORDER BY fecha_recordatorio";
	}
	$result = execute_sql($sql);
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
	<meta name="description" content="Calendario">
	<script language="JavaScript" type="text/javascript">
	<!--
		function popup(url) {
			window.open(url, "calendario", "toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,menuBar=no,width=640,height=520,left=100,top=50");
		}
		function view(id) {
			popup("../calendario_visual.php?id=" + id);
			return true;
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
<p align="center">No hay actualmente acciones pendientes en el calendario.<br/>
<a href="JavaScript:popup('../formulaire_calendario.php')">Adjuntar una acci&oacute;n al calendario</a></p>
<?php
	}
	else {
?>
<table width="800" border="0" align="center">
	<tr>
		<td nowrap><a href="JavaScript:popup('../formulaire_calendario.php')">Adjuntar</a></td>
		<td colspan="2" align="right" nowrap><a href="../index.php">Volver al men&uacute; resumen</a></td>
	</tr>
	<tr>
		<td colspan="3"><table width="100%" align="center" border="0">
			<tr>
				<th class="listheader" nowrap>Volver a llamar al</th>
				<th class="listheader" nowrap>Apellido e nome</th>
				<th class="listheader">Tel&eacute;fono</th>
				<th class="listheader">E mail</th>
				<th class="listheader" nowrap>Agregado el </th>
				<th class="listheader" nowrap>Seguimiento efectuado por</th>
				<th class="listheader">Notas</th>
			</tr>
<?php
		while($RS = @mysqli_fetch_array($result)) {
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
			$notas = $RS['notas'];
			if(strlen($notas) > 30) {
				$p = strpos($notas, ' ', 30);
				if($p > 0)
					$notas = substr($notas, 0, $p + 1).'...';
				else
					$notas = substr($notas, 0, 30).'...';
			}
?>
			<tr align="justify" class="<?=$styleclass?>">
				<td nowrap><?=$fecha_recordatorio?></td>
				<td nowrap><?=$nom.' '.$nombre?></td>
				<td nowrap><?=$phone?></td>
				<td nowrap><?=$email?></td>
				<td nowrap><?=$date_saisie?></td>
				<td nowrap><?=$seguimiento?></td>
				<td nowrap><?=$notas?></td>
				<td><a href="#" onClick="view(<?=$id?>)"><img name="prendre" src="../images/document.png" alt="devis" border="0"></a></td>
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
<p align="center"><a href="../index.php">Volver al men&uacute; resumen</a></p>
</body>
</html>