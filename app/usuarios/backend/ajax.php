<?php
include_once '../controllers/controllerPermisos.php';
header('Content-Type: application/json; charset=utf-8');

// ../backend/ajax.php?modulo=rol&accion=editar

$objPermiso = new Permisos();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['api'])) {
        switch ($_GET['api']) {
            case 'traer_roles':
                $roles = $objPermiso->traerRoles();
                echo json_encode($roles);
                break;

            case 'traer_segmentos':
                $segmentos = $objPermiso->traerSegmentos();
                echo json_encode($segmentos);
                break;

            case 'traer_perfiles':
                $perfiles = $objPermiso->traerPerfiles();
                echo json_encode($perfiles);
                break;

            case 'traer_acciones':
                $acciones = $objPermiso->traerAcciones($_GET['permiso']);
                echo json_encode($acciones);
                break;

            case 'traer_modulos_acciones':
                $modulos = $objPermiso->traerAllModulosAcciones();
                echo json_encode($modulos);
                break;



            default:
                # code...
                break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['modulo']) && $_GET['modulo'] == 'rol') {
        switch ($_GET['accion']) {
            case 'editar':
                $editar = $objPermiso->editarRol($_POST);
                if ($editar) {
                    echo "exito";
                }
                break;

            case 'crear':
                $crear = $objPermiso->crearRol($_POST);
                if ($crear) {
                    echo "exito";
                }
                break;

            case 'eliminar':
                $eliminar = $objPermiso->anularRol($_POST);
                if ($eliminar) {
                    echo "exito";
                }
                break;

            default:
                # code...
                break;
        }
    }
    if (isset($_GET['modulo']) && $_GET['modulo'] == 'permisos') {
        switch ($_GET['accion']) {
            case 'actualizar_permisos':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['cod_permiso']) && isset($data['permisos'])) {
                    $resultado = $objPermiso->ActualizarPermisos($data['cod_permiso'], $data['permisos']);
                    header('Content-Type: application/json');
                    echo json_encode(['status' => $resultado]); // ✅ Cambiar a JSON
                    exit;
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'fallo', 'message' => 'Datos incompletos']);
                    exit;
                }
                break;


            default:
                # code...
                break;
        }
    }
}
