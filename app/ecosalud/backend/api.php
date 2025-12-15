<?php

include_once '../controllers/controllerEcosalud.php';

$obj = new controllerEcosalud();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['ajax'])) {
        switch ($_GET['ajax']) {
            case 'territorios':
                $t = $obj->TraerTerritorios();
                echo json_encode($t);
                break;

            case 'detalle_territorio':
                $t = $obj->VerDetalleTerritorio($_GET['id']);
                echo json_encode($t);
                break;

            case 'detalle_participantes':
                $t = $obj->VerDetalleParticipantes($_GET['id']);
                echo json_encode($t);
                break;

            default:

                break;
        }
    }
}
