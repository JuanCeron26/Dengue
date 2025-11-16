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
}
