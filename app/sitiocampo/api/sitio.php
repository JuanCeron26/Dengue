<?php
require_once "../models/ResponsableModel.php";
require_once "../controller/sitio.php";

// ⚠️ IMPORTANTE: No debe haber NADA antes de este <?php

$controller = new SitiosController();

$id = $_GET['id'] ?? null;
$accion = $_GET['accion'] ?? null;

/* ===========================================
   LISTAR SITIOS CON FILTROS
=========================================== */
if ($accion === 'listar_filtros') {
    $filters = [
        "f_sitio"  => $_GET['f_sitio'] ?? "",
        "f_barrio" => $_GET['f_barrio'] ?? "",
        "f_nombre" => $_GET['f_nombre'] ?? ""
    ];

    header('Content-Type: application/json');
    echo json_encode($controller->listarSitiosConFiltros($filters));
    exit();
}

/* ===========================================
   ELIMINAR SITIO
=========================================== */
if ($accion === 'eliminar') {
    $id = (int)$id;
    $ok = $controller->eliminarSitio($id);

    header('Content-Type: application/json');
    echo json_encode(['status' => $ok]);
    exit();
}

/* ===========================================
   DETALLE SITIO
=========================================== */
if ($accion === 'detalle') {
    $detalle = $controller->verDetalle($id);

    if (!$detalle) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No se encontró información']);
        exit();
    }

    header("Content-Type: application/json");
    echo json_encode($detalle[0]);
    exit();
}

/* ===========================================
   OBTENER SITIO
=========================================== */
if ($accion === 'obtener') {
    $detalle = $controller->verDetalle($id);

    header('Content-Type: application/json');
    echo json_encode($detalle ? $detalle[0] : ['error' => 'No encontrado']);
    exit();
}

// Si no hay acción válida
header('Content-Type: application/json');
echo json_encode(['error' => 'Acción no válida']);
exit();
