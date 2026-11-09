<?php
$listPath = 'admin_news_visul.php';
require __DIR__.'/includes/news-list.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<TITLE>Visualizar las news</TITLE>
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
            <form class="svl-list-filter" method="get" action="<?= svl_list_escape($listPath) ?>">
                <label>Lanzamiento
                    <select name="id_lanzamiento">
                        <?php foreach ($launches as $launch): ?>
                            <option value="<?= (int) $launch['id_lanzamiento'] ?>"<?= $selectedLaunch === (int) $launch['id_lanzamiento'] ? ' selected' : '' ?>><?= svl_list_escape($launch['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
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
<?php foreach ($listRows as $RS) {
				$id_new = $RS["id_news"];
				$titulo = $RS["titulo"];
				$imagen = $RS["imagen"];
				$texto = $RS["texto"];
				$textoAmp = $RS["textoAmp"];
				$orden = $RS["orden"];
				$visible = $RS["visible"];
				$descuento = $RS["descuento"];
				$esbanner = $RS["esbanner"];
				$esbanner_eventos = $RS["esbanner_eventos"];
				$nombre_pais = $RS["nombre_pais"];
				$destino = $RS["destino"];
				// Traitement sur la description, Si la chaine de caractere est trop longue, on la coupe et on ajoute '...'
				if (strlen($texto) > 300)
				{
					$texto = substr($texto, 0, 300) . ' ...';
				}
?>

				<tr>
					<td bgcolor="#EBEBEB" align="center" colspan="2">
						<strong>
							<font color="#000099" size="2" face="Verdana"><? echo "$titulo"; ?></font>
						</strong>
					</td>
				</tr>
								
				<tr>
					<td>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Imagen : <? echo "$imagen"; ?></font>
						</strong>
					</td>
				</tr>

				<tr>
					<td>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">texto  :</font>
						</strong>
					</td>
				</tr>
				<tr>
					<td><? echo "$texto"; ?></td>
				</tr>	

				<tr>
					<td>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">texto Ampliado:</font>
						</strong>
					</td>
				</tr>
				<tr>
					<td><? echo "$textoAmp"; ?></td>
				</tr>	
				
				</tr>					
							<td colspan="2">
							<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">orden : <? echo "$orden"; ?></font>
							</strong>
							</td>
				</tr>

				
				</tr>					
						<td >
						<strong>
						<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">visible : <? echo "$visible"; ?></font>
						</strong>
						</td>

				</tr>
					
				</tr>					
						<td colspan="2">
						<strong>
						<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">descuento : <? echo "$descuento"; ?></font>
						</strong>
						</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<input name="esbanner" type="checkbox" <? if ($esbanner == 1) {echo'checked="checked"';} ?> disabled>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Es banner</font>
						</strong>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="esbanner_eventos" type="checkbox" <? if ($esbanner_eventos == 1) {echo'checked="checked"';} ?> disabled>
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Es banner eventos</font>
						</strong>
					</td>
				</tr>

				<tr>
					<td >
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Pais Especializacion : <? echo "$nombre_pais"; ?></font>
						</strong>
						<br>
					</td>
					<td >
						<strong>
							<font color="#000099" size="2" face="Arial, Helvetica, sans-serif">Destino : <? echo "$destino"; ?></font>
						</strong>
						<br>
					</td>
				</tr>
					
				</tr>		
										
					<td>
						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="40%">&nbsp;</td>
								<td width="30%" align="center"><a href="admin_news_modif.php?id=<? echo "$id_new"; ?>">Visualizar</a></td>
								<td width="30%" align="center"><a href="admin_news_supp.php?id=<? echo "$id_new"; ?>" onclick="if (! confirm('Seguro que quieres borrar new?')) return false;">Quitar</a></td>			
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
<?php } ?>
			</table>
		</td>
	</tr>
</table>
</body>
</HTML>