<?php
/** Shared navigation only. Existing page actions and access protection stay in place. */
require_once __DIR__.'/../../config/database.php';
$svlNavPage = basename($_SERVER['SCRIPT_NAME'] ?? ($_SERVER['PHP_SELF'] ?? ''));
$svlNavView = isset($_GET['view']) && is_string($_GET['view']) ? $_GET['view'] : 'contacts';
if ($svlNavView === 'newsletter_history'
    || (($svlNavView === 'new' || !isset($_GET['view'])) && ($_GET['kind'] ?? '') === 'newsletter')) {
    $svlNavView = 'newsletter';
} elseif (!in_array($svlNavView, array('contacts', 'newsletter'), true)) {
    $svlNavView = 'contacts';
}
if ($svlNavPage === 'formularios.php' && isset($view) && in_array($view, array('contacts', 'newsletter'), true)) {
    $svlNavView = $view;
}
$svlNavSpecialties = $svlNavPage === 'admin_especialidad_visul.php'
    && (($_GET['seccion'] ?? '') === 'especialidades'
        || isset($_GET['id_destino']) || isset($_POST['id_destino']));
$svlNavEnvironment = svl_configuration()['env'];
$svlNavLocal = $svlNavEnvironment === 'local';
$svlNavGroups = array(
    array('label' => 'Contactos', 'links' => array(
        array('Consultar contactos', 'formularios.php?view=contacts', array('formularios.php'), 'contacts'),
    )),
    array('label' => 'Destinos', 'links' => array(
        array('A&ntilde;adir un destino', 'admin_destinos_add.php', array('admin_destinos_add.php')),
        array('Consultar un destino', 'admin_destinos_visul.php', array('admin_destinos_visul.php', 'admin_destinos_modif.php')),
    )),
    array('label' => 'Especialidades', 'links' => array(
        array('A&ntilde;adir una especialidad', 'admin_especialidad_add.php', array('admin_especialidad_add.php')),
        array('Consultar una especialidad', 'admin_especialidad_visul.php?seccion=especialidades#especialidades', array('admin_especialidad_visul.php', 'admin_especialidad_modif.php'), 'specialties'),
    )),
    array('label' => 'Newsletter', 'links' => array(
        array('Suscriptores newsletter', 'formularios.php?view=newsletter', array('formularios.php'), 'newsletter'),
        array('Adjuntar newsletter', 'admin_news_add.php', array('admin_news_add.php')),
        array('Consultar newsletter', 'admin_news_visul.php', array('admin_news_visul.php', 'admin_news_modif.php')),
        array('Copiar newsletter', 'admin_copiarNews_add.php', array('admin_copiarNews_add.php')),
        array('Ofertas para agencias', 'admin_news_agencias_visul.php', array('admin_news_agencias_visul.php', 'admin_news_agencias_modif.php')),
        array('Adjuntar oferta para agencias', 'admin_news_agencias_add.php', array('admin_news_agencias_add.php')),
    )),
    array('label' => 'Lanzamientos', 'links' => array(
        array('Adjuntar t&iacute;tulo lanzamiento', 'admin_lanza_add.php', array('admin_lanza_add.php')),
        array('Consultar t&iacute;tulos lanzamiento', 'admin_lanza_visul.php', array('admin_lanza_visul.php', 'admin_lanza_modif.php')),
    )),
);
$svlNavIsActive = static function (array $link) use ($svlNavPage, $svlNavView, $svlNavSpecialties) {
    if (!in_array($svlNavPage, $link[2], true)) {
        return false;
    }
    if (($link[3] ?? '') === 'specialties') {
        return $svlNavPage === 'admin_especialidad_modif.php' || $svlNavSpecialties;
    }
    return !isset($link[3]) || $svlNavView === $link[3];
};
?>
<link rel="stylesheet" href="assets/admin.css">
<?php if (preg_match('/^admin_(?:(?:destinos|especialidad|news(?:_agencias)?|lanza)_(?:add|modif)|copiarNews_add)\.php$/D', $svlNavPage)): ?>
<script src="assets/form-submit.js" data-read-only="<?php echo $svlNavEnvironment === 'production' ? 'false' : 'true'; ?>" defer></script>
<?php endif; ?>
<aside class="svl-admin-sidebar" aria-label="Administraci&oacute;n">
    <a class="svl-admin-brand" href="admin_especialidad_visul.php">
        <span>Solo Viajes de Lujo<small>Administraci&oacute;n</small></span>
    </a>
    <?php if ($svlNavLocal): ?><span class="svl-admin-local">Local &middot; Los cambios del cat&aacute;logo est&aacute;n desactivados</span><?php endif; ?>
    <details class="svl-admin-navigation" open>
        <summary>Men&uacute; del administrador</summary>
        <nav class="svl-admin-nav-content" aria-label="Navegaci&oacute;n principal">
            <?php $svlNavHome = in_array($svlNavPage, array('index.php', 'admin_especialidad_visul.php'), true) && !$svlNavSpecialties; ?>
            <a class="svl-admin-nav-link svl-admin-nav-home<?php echo $svlNavHome ? ' is-active' : ''; ?>" href="admin_especialidad_visul.php"<?php echo $svlNavHome ? ' aria-current="page"' : ''; ?>>Inicio</a>
            <?php foreach ($svlNavGroups as $svlNavGroup):
                $svlNavGroupOpen = false;
                foreach ($svlNavGroup['links'] as $svlNavLink) {
                    $svlNavGroupOpen = $svlNavGroupOpen || $svlNavIsActive($svlNavLink);
                } ?>
                <details class="svl-admin-nav-group" name="svl-admin-sections"<?php echo $svlNavGroupOpen ? ' open' : ''; ?>>
                    <summary><?php echo $svlNavGroup['label']; ?></summary>
                    <?php foreach ($svlNavGroup['links'] as $svlNavLink):
                        $svlNavActive = $svlNavIsActive($svlNavLink); ?>
                        <a class="svl-admin-nav-link<?php echo $svlNavActive ? ' is-active' : ''; ?>" href="<?php echo htmlspecialchars($svlNavLink[1], ENT_QUOTES, 'UTF-8'); ?>"<?php echo $svlNavActive ? ' aria-current="page"' : ''; ?>><?php echo $svlNavLink[0]; ?></a>
                    <?php endforeach; ?>
                </details>
            <?php endforeach; ?>
        </nav>
    </details>
    <a class="svl-admin-view-site" href="../">Ver la web</a>
</aside>
