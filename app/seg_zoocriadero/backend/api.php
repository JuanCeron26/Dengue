<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../controllers/controllerSegZoo.php';

$objZoo = new controllerZoo();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['ajax'])) {
        switch ($_GET['ajax']) {
            case 'traer_zoocriaderos':
                $zoos = $objZoo->traerZoocriaderos();
                if ($zoos) {
                    echo json_encode($zoos);
                }
                break;

            case 'traer_tanques':
                $zoos = $objZoo->traerTanques($_GET['id']);
                if ($zoos) {
                    echo json_encode($zoos);
                }
                break;

            case 'traer_operarios':
                $zoos = $objZoo->traerOperarios($_GET['id']);
                if ($zoos) {
                    echo json_encode($zoos);
                }
                break;

            case 'traer_actividades':
                $zoos = $objZoo->traerActividades();
                if ($zoos) {
                    echo json_encode($zoos);
                }
                break;

            case 'traer_seguimientos':
                $seguimientos = $objZoo->traerSeguimientos();
                if ($seguimientos) {
                    echo json_encode($seguimientos);
                }
                break;

            case 'traer_seguimiento_detalle':
                $seguimientos = $objZoo->traerSeguimientoById($_GET['id']);
                if ($seguimientos) {
                    echo json_encode($seguimientos);
                }
                break;

            default:
                # code...
                break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['accion'])) {
        switch ($_GET['accion']) {
            case 'registrar':
                $reg = $objZoo->RegistrarSeguimiento($_POST);
                echo $reg;
                break;

            case 'editar':
                $edit = $objZoo->EditarSeguimiento($_POST);
                if ($edit) {
                    echo "exito";
                } else {
                    echo $edit;
                }
                break;

            case 'eliminar':
                $edit = $objZoo->AnularSeguimiento($_POST);
                if ($edit) {
                    echo "exito";
                } else {
                    echo $edit;
                }
                break;

            case 'ver_detalle':
                $edit = $objZoo->VerDetalleSeguimiento($_POST);
                if ($edit) {
                    echo json_encode($edit);
                } else {
                    echo $edit;
                }
                break;

            default:
                # code...
                break;
        }
    }
}
