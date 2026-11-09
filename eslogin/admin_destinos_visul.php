<?php
require_once __DIR__.'/includes/sql_admin.php';
require_once __DIR__.'/includes/execute_sql_admin.php';
require_once __DIR__.'/includes/list-controls.php';

$listPath = 'admin_destinos_visul.php';
$sortColumns = array(
    'name' => array('Destino', array('nombre_pais')),
    'status' => array('Estado', array('activo')),
    'id' => array('Referencia', array('id_pais')),
);
$listOptions = svl_list_options($sortColumns, 'name', 'asc', 25);
$listParameters = $listOptions;
[$listRows, $pagination, $listError] = svl_list_catalogue(
    sql_paises_svl(),
    'SELECT COUNT(*) FROM paises_svl',
    svl_list_order($listOptions, $sortColumns, 'id_pais ASC'),
    $listOptions
);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Visualizar destinos</TITLE>
	
	<script language="JavaScript" type="text/JavaScript">
		// Fonction qui permet de controler le formulaire avant de l'envoyer
		function controle(id)
		{
			document.formulaire.id.value=id;
			var opcion = confirm("Seguro que quieres borrar destino");
			if (opcion == true) {
				document.formulaire.submit();
			} 
		}

	
	</script>
	
	
</HEAD>
<body>
<form name="formulaire" method="post" action="admin_destinos_supp.php" enctype="multipart/form-data">
<input type="hidden" name="id" value="">
</form>
<table width="800px"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2"><img src="top.jpg" width="800" height="120" ></td>
	</tr>
	<tr>
		<td valign="top" width="200">
<?php
		include("includes/menu.php");
 ?>
 		</td>
		<td width="600">
            <form class="svl-list-filter" method="get" action="<?= svl_list_escape($listPath) ?>">
                <?php svl_list_selects($listOptions, $sortColumns); ?>
                <button class="svl-admin-button" type="submit">Aplicar</button>
                <span class="svl-admin-muted"><?= number_format($pagination['total'], 0, ',', '.') ?> resultados</span>
            </form>
            <?php if ($listError !== ''): ?>
                <p class="svl-admin-note svl-admin-error" role="alert"><?= svl_list_escape($listError) ?></p>
            <?php elseif (!$listRows): ?>
                <p>No hay registros en este listado.</p>
            <?php endif; ?>
            <?php svl_list_pager($listPath, $listParameters, $pagination); ?>
			<table cellpadding="0" cellspacing="0" width="100%">
					
<?php

			foreach ($listRows as $RS)
			{
				$id_pais = $RS['id_pais'];
				$nombre_pais = $RS['nombre_pais'];

?>
				<tr>
					<td>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Destinos  :</font>
						</strong>
					</td>
				</tr>
				<tr>
					<td bgcolor="#EBEBEB" align="center" colspan="2">
						<strong>
							<font color="#000099" size="2" face="Verdana"><? echo "$nombre_pais"; ?></font>
						</strong>
					</td>
				</tr>
				<tr>														
					<td>
						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="40%">&nbsp;</td>
								<td width="30%" align="center"><a href="admin_destinos_modif.php?id=<? echo "$id_pais"; ?>">Visualizar</a></td>
								<td width="30%" align="center"><a href="javascript:controle(<? echo "$id_pais"; ?>)">Quitar</a></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
<?php
			}
?>
			</table>
		</td>
	</tr>
</table>
</body>
</HTML>