<?php

include_once '../controllers/controllerUser.php';
header('Content-Type: application/json; charset=utf-8');

$objUser = new User();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['ajax'])) {
        switch ($_GET['ajax']) {
            case 'pintar_usuarios':
                $usuarios = $objUser->traerUsuarios();
                echo json_encode($usuarios);
                break;

            case 'documentos':
                $documentos = $objUser->traerTiposDocumento();
                echo json_encode($documentos);
                break;

            case 'roles':
                $roles = $objUser->traerRoles();
                echo json_encode($roles);
                break;

            case 'segmentos':
                $segmentos = $objUser->traerSegmentos();
                echo json_encode($segmentos);
                break;

            default:
                # code...
                break;
        }
    }
}
