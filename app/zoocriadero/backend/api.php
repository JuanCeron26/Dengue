<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['view'])) {
        switch ($_GET['view']) {
            case 'inicio':
                header("Location:../views/dashboard.php");
                break;

            case 'listar':
                header("Location:../views/listar.php");
                break;

            case 'configuracion':
                break;

            default:

                break;
        }
    }
}
