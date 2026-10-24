<?php
/** Isolated public-site preview for PHP's built-in server; not a production router. */
if (PHP_SAPI !== 'cli-server' || getenv('SVL_ENV') !== 'local') {
    http_response_code(403);
    exit('Local preview only.');
}
$localHost = parse_url('http://'.($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);
if (!in_array(strtolower((string) $localHost), array('localhost', '127.0.0.1', '[::1]', '::1'), true)) {
    http_response_code(403);
    exit('Local host required.');
}
header('X-Robots-Tag: noindex, nofollow');
header("Content-Security-Policy: default-src 'self' data:; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self' data:; connect-src 'self'; frame-src 'none'; object-src 'none'; base-uri 'self'; form-action 'self'");
$method = $_SERVER['REQUEST_METHOD'];
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');
$path = preg_replace('~/+~', '/', $path);
// A real directory URL needs its trailing slash for relative admin links/assets.
if ($path === '/eslogin' && in_array($method, array('GET', 'HEAD'), true)) {
    $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    header('Location: /eslogin/'.($query !== null && $query !== '' ? '?'.$query : ''), true, 302);
    exit;
}
if ($path === '/eslogin' || $path === '/eslogin/') {
    $path = '/eslogin/index.php';
}
$segments = explode('/', $path);
$forbidden = strpos($path, "\0") !== false || strpos($path, '\\') !== false;
foreach ($segments as $segment) {
    if ($segment !== '' && $segment[0] === '.') {
        $forbidden = true;
    }
}
$formEndpoint = in_array($path, array('/confirmacion.php', '/registro.php'), true);
$adminPages = array('index.php', 'formularios.php', 'admin_destinos_add.php',
    'admin_destinos_visul.php', 'admin_destinos_modif.php', 'admin_especialidad_add.php',
    'admin_especialidad_visul.php', 'admin_especialidad_modif.php', 'admin_news_add.php',
    'admin_news_visul.php', 'admin_news_modif.php', 'admin_news_agencias_add.php',
    'admin_news_agencias_visul.php', 'admin_news_agencias_modif.php', 'admin_lanza_add.php',
    'admin_lanza_visul.php', 'admin_lanza_modif.php', 'admin_copiarNews_add.php');
$adminPage = in_array($path, array_map(function ($page) { return '/eslogin/'.$page; }, $adminPages), true);
$adminAsset = preg_match('~^/eslogin/(?:assets|js|jquery)/[^?]+\.(?:css|js|png|gif|jpg|jpeg|svg|woff2?|ttf|eot)$~i', $path)
    || $path === '/eslogin/top.jpg';
// These existing POST actions only change catalogue filters, never records.
$adminFilter = in_array($path, array('/eslogin/admin_especialidad_visul.php',
    '/eslogin/admin_news_visul.php', '/eslogin/admin_news_agencias_visul.php',
    '/eslogin/admin_copiarNews_add.php'), true);
if (!in_array($method, array('GET', 'HEAD'), true)
    && !($method === 'POST' && ($formEndpoint || $adminFilter))) {
    http_response_code(405);
    header('Allow: GET, HEAD');
    exit('This route is read-only in the local preview.');
}
if ($forbidden || (!$adminPage && !$adminAsset && preg_match('~^/(?:config|tools|eslogin|pspdevel|lists)(?:/|$)~i', $path))
    || (!$formEndpoint && preg_match('~(?:^|/)(?:config(?:\.example)?\.php|info\.php|registro\.php|confirmacion\.php|enviar-mail\.php|baja(?:-newsletter)?\.php)(?:/|$)~i', $path))
    || preg_match('~\.(?:log|sql(?:\.(?:gz|bz2|xz))?|bak(?:\.[^/]*)?|cnf|ini|env)(?:/|$)~i', $path)) {
    http_response_code(403);
    exit('This route is disabled in the local preview.');
}
$root = realpath(dirname(__DIR__));
$target = realpath($root.$path);
if ($target === false) {
    http_response_code(404);
    exit;
}
if ($target !== $root && strpos($target, $root.DIRECTORY_SEPARATOR) !== 0) {
    http_response_code(403);
    exit;
}
if (is_dir($target)) {
    if ($target === $root) {
        $path = '/index.php';
        $target .= '/index.php';
    } elseif (is_file($target.'/index.html')) {
        $path = rtrim($path, '/').'/index.html';
        $target .= '/index.html';
    } else {
        http_response_code(403);
        exit;
    }
}
$extension = strtolower(pathinfo($target, PATHINFO_EXTENSION));
if ($extension === 'php') {
    $publicPage = preg_match('~^/(?:index|contacto|ofertas-exclusivas)\.php$~', $path)
        || preg_match('~^/destinos/[^/]+/destinos-[^/]+\.php$~', $path)
        || preg_match('~^/viajes/[^/]+/(?:viaje|viajes)-[^/]+\.php$~', $path);
    if (!$publicPage && !$formEndpoint && !$adminPage) {
        http_response_code(403);
        exit('This PHP route is outside the public-site preview.');
    }
} elseif (!in_array($extension, array('html', 'htm', 'css', 'js', 'map', 'jpg', 'jpeg',
        'png', 'gif', 'webp', 'svg', 'ico', 'pdf', 'woff', 'woff2', 'ttf', 'eot', 'otf',
        'txt', 'xml', 'json'), true)) {
    http_response_code(403);
    exit;
}
return false;
