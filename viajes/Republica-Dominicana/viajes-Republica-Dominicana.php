<?php
// Compatibility with the public route already stored in the catalogue.
$_GET['id'] = $_GET['id'] ?? 54;
include __DIR__.'/../cuerpo-viajes.php';
