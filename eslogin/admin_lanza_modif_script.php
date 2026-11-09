<?php
require __DIR__.'/includes/form-submit.php';

$message = svl_admin_form('admin_lanza_visul.php', static function () {
    svl_admin_save(
        'UPDATE lanzamientos SET nombre=?, texto_click=?, logo=?, texto_cabecera=?, logo_pie_wrld=?, logo_pie_svl=?, logo_pie_eve=?, logo_pie_cru=? WHERE id_lanzamiento=?',
        array(svl_admin_text('titulo', 'Nombre', true), svl_admin_text('texto_click', 'Texto del enlace'),
            svl_admin_text('logo', 'Logo'), svl_admin_text('texto_cabecera', 'Texto de cabecera'),
            svl_admin_text('logo_pie_wrld', 'Logo WorldCruceros') === 'on' ? 1 : 0,
            svl_admin_text('logo_pie_svl', 'Logo Solo Viajes') === 'on' ? 1 : 0,
            svl_admin_text('logo_pie_eve', 'Logo Eventos') === 'on' ? 1 : 0,
            svl_admin_text('logo_pie_cru', 'Logo Cruceros') === 'on' ? 1 : 0, svl_admin_number('id_lanza', 'Lanzamiento'))
    );
    return 'Lanzamiento modificado correctamente.';
});
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Modificado lanzamiento</TITLE>
</HEAD>
<body>
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
			<?php echo htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
		</td>
	</tr>
</table>
</body>
</HTML>