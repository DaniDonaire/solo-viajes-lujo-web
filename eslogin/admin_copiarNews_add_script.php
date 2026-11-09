<?php
require __DIR__.'/includes/form-submit.php';

$message = svl_admin_form('admin_copiarNews_add.php', static function () {
    svl_admin_save(
        'INSERT INTO newsletter (id_lanzamiento, titulo, imagen, texto, orden, visible, descuento, textoAmp, esbanner, id_pais_espe, id_lanzamiento_imagen, id_destino, esbanner_eventos)
        SELECT l.id_lanzamiento, n.titulo, n.imagen, n.texto, n.orden, n.visible, n.descuento, n.textoAmp,
            n.esbanner, n.id_pais_espe, n.id_lanzamiento_imagen, n.id_destino, n.esbanner_eventos
        FROM newsletter n JOIN lanzamientos l ON l.id_lanzamiento=? WHERE n.id_news=?',
        array(svl_admin_number('id_lanzamiento_1', 'Lanzamiento de destino'), svl_admin_number('id_news', 'Oferta')),
        null,
        true
    );
    return 'Oferta copiada correctamente.';
});
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Copiada News</TITLE>
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