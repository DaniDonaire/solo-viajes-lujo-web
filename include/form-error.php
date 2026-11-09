<?php

function svl_render_form_error($message, $status, $returnUrl)
{
    http_response_code($status);
    header('Content-Type: text/html; charset=UTF-8');
    header('Cache-Control: no-store');
    $escape = static function ($value) {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    };
    echo '<!doctype html><html lang="es"><meta charset="UTF-8"><title>Revisar formulario</title>'
        .'<h1>Revisar formulario</h1><p role="alert">'.$escape($message).'</p>'
        .'<p><a href="'.$escape($returnUrl).'" onclick="if (history.length > 1) { history.back(); return false; }">Volver al formulario</a></p>'
        .'<script>window.alert(document.querySelector(\'[role=alert]\').textContent);</script></html>';
    exit;
}
