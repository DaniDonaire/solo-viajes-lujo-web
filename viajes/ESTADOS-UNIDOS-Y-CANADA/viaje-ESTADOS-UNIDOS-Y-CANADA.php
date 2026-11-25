<?php
// Compatibility with the public route already stored in the catalogue.
if (!isset($_GET['id_viaje'])) {
    header('Location: viajes-'.rawurlencode('ESTADOS-UNIDOS-Y-CANADA').'.php?id=170', true, 302);
    exit;
}
include __DIR__.'/../cuerpo-viaje.php';
