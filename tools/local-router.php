<?php
/** Isolated public-site preview for PHP's built-in server; not a production router. */
if (PHP_SAPI !== 'cli-server' || getenv('SVL_ENV') !== 'local') {
    http_response_code(403);
    exit('Local preview only.');
}
header('X-Robots-Tag: noindex, nofollow');
header("Content-Security-Policy: default-src 'self' data:; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self' data:; connect-src 'self'; frame-src 'none'; object-src 'none'; base-uri 'self'; form-action 'none'");
$method = $_SERVER['REQUEST_METHOD'];
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');
$path = preg_replace('~/+~', '/', $path);
$segments = explode('/', $path);
$forbidden = strpos($path, "\0") !== false || strpos($path, '\\') !== false;
foreach ($segments as $segment) {
    if ($segment !== '' && $segment[0] === '.') {
        $forbidden = true;
    }
}
if (!in_array($method, array('GET', 'HEAD'), true)) {
    http_response_code(405);
    header('Allow: GET, HEAD');
    exit('Forms are disabled in this local preview.');
}
if ($forbidden || preg_match('~^/(?:config|tools|eslogin|pspdevel|lists)(?:/|$)~i', $path)
    || preg_match('~(?:^|/)(?:config(?:\.example)?\.php|info\.php|registro\.php|confirmacion\.php|enviar-mail\.php|baja(?:-newsletter)?\.php)(?:/|$)~i', $path)
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
    if (!$publicPage) {
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
