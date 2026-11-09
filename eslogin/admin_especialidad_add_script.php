<?php
require __DIR__.'/includes/form-submit.php';

$message = svl_admin_form('admin_especialidad_visul.php?seccion=especialidades', static function () {
    $name = svl_admin_text('nombre_especialidad', 'Nombre de la especialidad', true);
    $slug = svl_admin_slug($name);
    $country = svl_admin_number('id_pais', 'Destino');
    $image = svl_admin_image();
    $active = svl_admin_text('activo', 'Activo') === 'on' ? 1 : 0;
    $root = dirname(__DIR__).'/viajes';
    $filename = $image === null ? '' : $slug.'.jpg';
    svl_admin_save(
        'INSERT INTO destinos_svl (id_pais, destino, nombre_pagina_destino, imagen_destino, activo) VALUES (?, ?, ?, ?, ?)',
        array($country, $name, $slug, $filename, $active),
        static function () use ($root, $slug, $filename, $image) {
            $directory = $root.'/'.$slug;
            svl_admin_directory($directory);
            svl_admin_template($root.'/Alaska/viajes-Alaska.php', $directory.'/viajes-'.$slug.'.php');
            svl_admin_template($root.'/Alaska/viaje-Alaska.php', $directory.'/viaje-'.$slug.'.php');
            if ($image !== null) {
                svl_admin_store_image($image, $directory.'/img/'.$filename);
            }
        }
    );
    return 'Especialidad creada correctamente.';
});
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Para agregar una especialidad</TITLE>
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
			<br>
		</td>
	</tr>
</table>
</body>
</HTML>