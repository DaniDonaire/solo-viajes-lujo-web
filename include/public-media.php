<?php
/** Public media aliases keep historical catalogue data untouched. */
require_once __DIR__.'/site-path.php';

function svl_media_manifest()
{
    static $manifest;
    if ($manifest === null) {
        $manifest = json_decode(file_get_contents(__DIR__.'/public-media.json'), true, 512, JSON_THROW_ON_ERROR);
    }
    return $manifest;
}

function svl_image_url($path, $size = 'hero')
{
    $manifest = svl_media_manifest();
    $path = trim($path);
    $path = $manifest['aliases'][$path] ?? $path;
    if (isset($manifest['images'][$path][$size])) {
        $path = $manifest['images'][$path][$size];
    } elseif (!is_file(dirname(__DIR__).$path)) {
        // No invented destination photograph when the original was never uploaded.
        $path = '/img/destination-placeholder.svg';
    }
    $path = implode('/', array_map('rawurlencode', explode('/', $path)));
    return htmlspecialchars(svl_site_path($path), ENT_QUOTES, 'UTF-8');
}

function svl_catalogue_url($type, $slug, $id)
{
    if (!in_array($type, array('destinos', 'viajes', 'viaje'), true) || !ctype_digit((string) $id)
        || (int) $id < 1 || $slug === '') {
        return htmlspecialchars(svl_site_path('/index.php#destinos'), ENT_QUOTES, 'UTF-8');
    }
    $folder = $type === 'destinos' ? 'destinos' : 'viajes';
    $key = $type === 'viaje' ? 'id_viaje' : 'id';
    // The small compatibility entry points retain these existing public URLs.
    return htmlspecialchars(svl_site_path('/'.$folder.'/'.rawurlencode($slug).'/'.$type.'-'.rawurlencode($slug).'.php?'.$key.'='.(int) $id), ENT_QUOTES, 'UTF-8');
}

function svl_render_travel_links($text)
{
    return preg_replace_callback('~\[web=(.*?)\](.*?)\[/web\]~s', function ($match) {
        $url = trim(html_entity_decode(strip_tags($match[1]), ENT_QUOTES, 'UTF-8'));
        if (strpos($url, 'www.ba?us-discovery.com') === 0) {
            return $match[2];
        }
        // Recover a nested editor marker and pasted labels before a full URL.
        if (preg_match('~https?://[^\s<>\[\]]+~i', $url, $found)) {
            $url = $found[0];
        } elseif (preg_match('~^www\.[^\s<>]+$~i', $url)) {
            $url = 'https://'.$url;
        } elseif (strpos($url, 'o.com/en-us/barcelo-maya-grand-resort/') === 0) {
            $url = 'https://www.barcelo.com/en-us/barcelo-maya-grand-resort/';
        }
        if (preg_match('~^https?://(?:www\.)?soloviajesdelujo\.com/viajes/Turquia/viajes-$~i', $url)) {
            $url = 'https://soloviajesdelujo.com/viajes/Turquia/viajes-Turquia.php?id=39';
        }
        // Broken/ambiguous addresses remain readable text instead of fake local links.
        $parts = parse_url($url);
        if (!$parts || !in_array(strtolower($parts['scheme'] ?? ''), array('https', 'http'), true)
            || empty($parts['host']) || strpos($parts['host'], '?') !== false
            || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $match[2];
        }
        return '<a href="'.htmlspecialchars($url, ENT_QUOTES, 'UTF-8').'" class="estilolink" target="_blank" rel="noopener noreferrer">'.$match[2].'</a>';
    }, $text);
}
