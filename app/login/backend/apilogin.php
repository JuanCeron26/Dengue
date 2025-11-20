<?php
header("Content-Type: application/json");
include_once "../controllers/controllerLogin.php";

$documento = $_POST["documento"] ?? "";
$password  = $_POST["password"] ?? "";

$control = new LoginController();
$respuesta = $control->IniciarSesion($documento, $password);

    if($respuesta == "exito"){
        echo json_encode(["mensaje" => $respuesta]);
    }

    /*
        Esta API recibe los datos enviados desde JavaScript (documento y password)
        y los envía al controlador para validar el inicio de sesión con la base de datos.
    */
?>
