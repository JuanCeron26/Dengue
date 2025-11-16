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

            case 'traer_usuario':
                if (isset($_GET['id'])) {
                    $usuario = $objUser->traerUsuario($_GET['id']);
                    echo json_encode($usuario);
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
                $registrar = $objUser->registrarUsuario($_POST);
                if ($registrar == "exito") {
                    header("Location:../views/dashboard.php");
                } else {
                    echo "Error";
                }
                break;

            case 'editar':
                $editar = $objUser->editarUsuario($_POST);
                if ($editar == "exito") {
                    echo $editar;
                } else {
                    echo "error";
                }
                break;

            case 'eliminar':
                $eliminar = $objUser->eliminarUsuario($_POST);
                if ($eliminar == "exito") {
                    echo $eliminar;
                } else {
                    echo "error";
                }
                break;

            default:
                # code...
                break;
        }
    }
}
