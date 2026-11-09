<?php
require __DIR__.'/includes/form-submit.php';

$message = svl_admin_form('admin_destinos_visul.php', static function () {
    $name = svl_admin_text('nombre_destino', 'Nombre del destino', true);
    $slug = svl_admin_slug($name);
    $image = svl_admin_image(true);
    $active = svl_admin_text('activo', 'Activo') === 'on' ? 1 : 0;
    $root = dirname(__DIR__).'/destinos';
    $filename = $slug.'.jpg';
    svl_admin_save(
        'INSERT INTO paises_svl (nombre_pais, nombre_pagina_pais, imagen_pais, activo) VALUES (?, ?, ?, ?)',
        array($name, $slug, $filename, $active),
        static function () use ($root, $slug, $filename, $image) {
            $directory = $root.'/'.$slug;
            svl_admin_directory($directory);
            svl_admin_template($root.'/Africa/destinos-Africa.php', $directory.'/destinos-'.$slug.'.php');
            if ($image !== null) {
                svl_admin_store_image($image, $root.'/img/'.$filename);
            }
        }
    );
    return 'Destino creado correctamente.';
});
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Para agregar un destino</TITLE>
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