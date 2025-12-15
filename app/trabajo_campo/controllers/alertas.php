<?php

function alertAndRedirect($msg, $tipo = 'success')
{
    $esExito = strpos($msg, '✓') === 0;
    $tipo = $esExito ? 'success' : 'error';

    $icono = $tipo === 'success' ? '✔' : '✖';
    $titulo = $tipo === 'success' ? '¡Éxito!' : '¡Error!';

    $color_principal = $tipo === 'success' ? '#10B981' : '#EF4444';
    $color_secundario = $tipo === 'success' ? '#059669' : '#DC2626';

    $mensaje_limpio = trim(str_replace(['✓', '✗'], '', $msg));

    include __DIR__ . '/alerta_template.php';
    exit;
}
