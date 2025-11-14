<?php

require_once '../controllers/controllerZoo.php';
require_once '../models/modelZoo.php';
require_once '../../../conexionBD/BaseDatos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_GET['accion']) {
        case 'registrar':
            $objModel = new ModelZoo($_POST);
            break;

        default:
            # code...
            break;
    }
}
