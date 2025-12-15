<?php
include_once "../models/modelLogin.php";

class LoginController
{
    private $model;

    public function __construct()
    {
        $this->model = new LoginModel();
    }

    public function IniciarSesion($documento, $password)
    {

        $doc = (int)$documento;
        //Buscar el usuario por su documento
        $usuario = $this->model->GetUsuarioDocum($doc, $password);

        if ($usuario) {
            session_start();
            //Crear sesión
            $_SESSION["id_usuarios"] = $usuario["id_usuarios"];
            $_SESSION["documento"] = $usuario["id_cedula"];
            $_SESSION["nombre"] = $usuario["nombre_usu"];
            $_SESSION["apellido"] = $usuario["apellido_usu"];
            $_SESSION["rol"] = $usuario["rol"];
            $_SESSION["segmento"] = $usuario["segmento"];
            $_SESSION["modulo"] = ($usuario != NULL) ? $usuario["modulo"] : '';
            $_SESSION["permiso"] = $usuario["permiso"];
            return [
                "mensaje" => "exito",
                "usuario" => $usuario
            ];
        } else {
            return var_dump($usuario);
        }
    }

    public function CerrarSesion()
    {
        session_destroy();
        $_SESSION = [];
        header('Location:../../login');
    }
}
