<?php
	session_start();
	require '../../../include/sql.php';
	$user = $_SESSION['user'];
	$level = $user['level'];
	if($level != 'A')
		exit('UNAUTHORIZED');
	$pseudo = $user['pseudo'];
	if(isset($_POST['recherche'])) {
		$search = addslashes($_POST['recherche']);
		$recherche = " WHERE d.apellido_1 LIKE '%$search%' OR d.apellido_2 LIKE '%$search%' OR d.nombre LIKE '%$search%' OR c.email LIKE '%$search%'";
	}
	else
		$recherche = '';
	$result = execute_sql("SELECT DISTINCT c.id,CONCAT(d.apellido_1,' ',d.apellido_2,' ',d.nombre),c.email,vendeur,vendu FROM email_contact c INNER JOIN presupuesto d ON c.email=d.email$recherche ORDER BY 2");
	if($result === FALSE)
		exit(mysqli_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Modifica associazione email-venditore</title>
	<link href="../presupuestos.css" rel="stylesheet" type="text/css"/>
	<script language="JavaScript" type="text/javascript">
		<!--
			function edit(id) {
				document.forms[0].id.value = id;
				document.forms[0].submit();
			}
		//-->
	</script>
</head>
<body>

<table width="600" border="0" cellspacing="0" cellpadding="6" class="list" style="margin:auto">
	<tr>
		<td colspan="6" bgcolor="#006699">
			<div align="center" class="login">Escoge al cliente para asociarlo a otro vendedor</div>
		</td>
	</tr>
	<tr>
		<th bgcolor="#DBFFB7" nowrap>Nombre y apellido</th>
		<th bgcolor="#DBFFB7" nowrap>Email</th>
		<th bgcolor="#DBFFB7" nowrap>Vendedor</th>
		<th bgcolor="#DBFFB7" nowrap>Vendido</th>
	</tr>
<?php
	$n = 0;
	while(list($id, $nom, $email, $vendeur, $vendu) = mysqli_fetch_row($result)) {
?>
	<tr class="list<?=$n % 2 + 1?>" onclick="edit(<?=$id?>)">
		<td nowrap><?=$nom?></td>
		<td><?=$email?></td>
		<td align="center"><?=$vendeur?></td>
		<td align="center"><?=$vendu?></td>
	</tr>
<?php
		$n++;
	}
?>
	<tr>
		<td colspan="6" align="center">
			<input type="button" value="Salir" onClick="location.href='../index.php'"/>
		</td>
	</tr>
</table>
<form method="post" action="modifier.php">
	<input type="hidden" name="id"/>
</form>
</body>
</html>
