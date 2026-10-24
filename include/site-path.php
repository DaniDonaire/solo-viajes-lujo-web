<?php
/** Prefix internal site paths when a protected preview is installed in a subdirectory. */
require_once __DIR__.'/../config/database.php';

function svl_site_path($path)
{
    if (!is_string($path) || $path === '' || $path[0] !== '/' || strpos($path, '//') === 0
        || preg_match('/[\x00-\x1f\\\\]/', $path)
        || preg_match('~(?:^|/)\.{1,2}(?:/|[?#]|$)~', $path)) {
        throw new InvalidArgumentException('Expected an internal root-relative site path.');
    }
    return svl_configuration()['base_path'].$path;
}
