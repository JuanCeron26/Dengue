<?php

header('Content-Type: application/json; charset=utf-8');

include_once '../controllers/controllerFoco.php';

$objFoco = new controllerFoco();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['ajax'])) {
        switch ($_GET['ajax']) {
            case 'traer_tiposfocos':
                $traer = $objFoco->traerTiposFocos();
                echo json_encode($traer);
                break;

            case 'traer_focospotenciales':
                $traer = $objFoco->traerFocosPotenciales();
                echo json_encode($traer);
                break;

            case 'traer_focopotencial':
                $traer = $objFoco->traerFocoPotencial($_GET['id']);
                echo json_encode($traer);
                break;

            case 'traer_focosactuales':
                $traer = [];
                if ($_GET['ecosalud'] == 'true') {
                    $traer = $objFoco->traerFocosActuales($_GET['id'], true);
                } else {
                    $traer = $objFoco->traerFocosActuales($_GET['id'], false);
                }
                echo json_encode($traer);
                break;

            case 'eliminar_focoactual':
                $traer = $objFoco->eliminarFocoActual($_GET['id']);
                echo ($traer);
                break;
            case 'obtener_foco':
                $id = $_GET['id'] ?? 0;
                $foco = $objFoco->traerFocoPotencial($id);

                if ($foco) {
                    echo json_encode($foco);
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
                // Leer JSON en lugar de $_POST
                $input = file_get_contents('php://input');
                $post = json_decode($input, true);
                $reg = $objFoco->RegistrarFocoPotencial($post);
                // echo json_encode($post);                
                if ($reg) {
                    echo json_encode(["success" => true]);
                } else {
                    echo "fallo";
                }
                break;


            case 'traer_usuarios_eco':
                $traer = $objFoco->traerUsersEco($_POST);
                echo json_encode($traer);
                break;
            case 'traer_participantes':
                $traer = $objFoco->traerParticipantes($_POST);
                echo json_encode($traer);
                break;

            case 'actualizar_foco':
                $post = json_decode(file_get_contents('php://input'), true);
                $resultado = $objFoco->ActualizarFocoPotencial($post);
                echo json_encode(['success' => $resultado]);
                break;

            default:
                # code...
                break;
        }
    }
}
