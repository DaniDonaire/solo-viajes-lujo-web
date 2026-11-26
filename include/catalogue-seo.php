<?php
/** Public catalogue URL policy. This file never writes to the catalogue. */
require_once __DIR__.'/site-path.php';

function svl_preferred_program_id($slug, $id)
{
    // Verified identical itineraries. Keep the old pages and their enquiry IDs usable.
    // 978 has recorded search visibility; 975 is already indexed by Google.
    $duplicates = $slug === 'Egipto' ? array(974 => 978, 979 => 975) : array();
    return $duplicates[(int) $id] ?? (int) $id;
}

function svl_catalogue_id($key)
{
    $value = $_GET[$key] ?? null;
    if (!is_string($value) || !preg_match('/^[1-9][0-9]{0,9}$/D', $value)) {
        svl_catalogue_not_found();
    }
    return (int) $value;
}

function svl_catalogue_not_found()
{
    http_response_code(404);
    header('Content-Type: text/plain; charset=UTF-8');
    exit('Página no encontrada.');
}

function svl_catalogue_page_path($type, $slug, $id)
{
    $slug = rawurlencode($slug);
    return '/viajes/'.$slug.'/'.$type.'-'.$slug.'.php?'
        .($type === 'viaje' ? 'id_viaje' : 'id').'='.(int) $id;
}

function svl_catalogue_resolve_path($type, $slug, $id)
{
    $path = svl_catalogue_page_path($type, $slug, $id);
    $expected = rawurldecode(parse_url(svl_site_path($path), PHP_URL_PATH));
    $actual = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '');
    if ($actual !== $expected) {
        // A valid ID under another destination must resolve to its actual catalogue URL.
        $targetId = $type === 'viaje' ? svl_preferred_program_id($slug, $id) : $id;
        $status = in_array($_SERVER['REQUEST_METHOD'] ?? 'GET', array('GET', 'HEAD'), true) ? 301 : 308;
        header('Location: '.svl_site_path(svl_catalogue_page_path($type, $slug, $targetId)), true, $status);
        exit;
    }
    $preferredId = $type === 'viaje' ? svl_preferred_program_id($slug, $id) : $id;
    return 'https://soloviajesdelujo.com'.svl_catalogue_page_path($type, $slug, $preferredId);
}
