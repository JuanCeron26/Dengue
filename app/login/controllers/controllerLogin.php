<?php 
include_once "../models/modelLogin.php";

class LoginController
{
    private $model;

        public function __construct()
        {
            $this->model = new LoginModel();
            session_start();
        }

        public function IniciarSesion($documento, $password)
        {
            //Buscar el usuario por su documento
            $usuario = $this->model->GetUsuarioDocum($documento, $password);

            if($usuario){
                //Crear sesión
            $_SESSION["id_usuarios"] = $usuario["id_usuarios"];
            $_SESSION["documento"] = $usuario["id_cedula"];
            $_SESSION["nombre"] = $usuario["nombre_usu"];
            $_SESSION["rol"] = $usuario["cod_rol"];
                return "exito";
            }
            else{
                return "Fallo";
            }

            

            

            
        }
}


?>