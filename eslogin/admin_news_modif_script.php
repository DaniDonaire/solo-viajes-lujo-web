<?php
require __DIR__.'/includes/form-submit.php';

$list = ($_POST['admin_section'] ?? '') === 'agencias' ? 'admin_news_agencias_visul.php' : 'admin_news_visul.php';
$message = svl_admin_form($list, static function () {
    $launch = svl_admin_number('id_lanzamiento', 'Lanzamiento');
    $image = svl_admin_image(false);
    $visible = svl_admin_text('visible', 'Visible', true);
    if (!in_array($visible, array('S', 'N'), true)) {
        throw new SvlAdminFormError('Revisa el campo «Visible».');
    }
    $values = array(svl_admin_text('titulo', 'Título', true), $launch, $image['name'] ?? null,
        svl_admin_text('texto', 'Texto', true), svl_admin_text('textoAmp', 'Texto ampliado'),
        svl_admin_number('orden', 'Orden', 0), $visible, svl_admin_number('descuento', 'Descuento', 0, 0),
        svl_admin_text('esbanner', 'Banner') === 'on' ? 1 : 0, svl_admin_number('id_pais', 'País'),
        svl_admin_text('esbanner_eventos', 'Banner de eventos') === 'on' ? 1 : 0,
        isset($_POST['destinos']) ? svl_admin_number('destinos', 'Destino', 0) : null, $image === null ? null : $launch);
    $values[] = svl_admin_number('form_id_new', 'Oferta');
    svl_admin_save(
        'UPDATE newsletter SET titulo=?, id_lanzamiento=?, imagen=COALESCE(?, imagen), texto=?, textoAmp=?, orden=?, visible=?, descuento=?, esbanner=?, id_pais_espe=?, esbanner_eventos=?, id_destino=COALESCE(?, id_destino), id_lanzamiento_imagen=COALESCE(?, id_lanzamiento_imagen) WHERE id_news=?',
        $values,
        $image === null ? null : static function () use ($image, $launch) {
            svl_admin_store_image($image, dirname(__DIR__).'/newsletter/images/'.$launch.'/'.$image['name']);
        }
    );
    return 'Oferta modificada correctamente.';
});
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Modificar la oferta</TITLE>
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
