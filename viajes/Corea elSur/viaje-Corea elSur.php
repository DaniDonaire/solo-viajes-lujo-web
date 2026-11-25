<?php
// Compatibility with the public route already stored in the catalogue.
if (!isset($_GET['id_viaje'])) {
    header('Location: viajes-'.rawurlencode('Corea elSur').'.php?id=73', true, 302);
    exit;
}
include __DIR__.'/../cuerpo-viaje.php';
