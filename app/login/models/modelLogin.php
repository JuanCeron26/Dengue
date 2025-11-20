<?php 
include_once "../../../conexionBD/BaseDatos.php";

class LoginModel
{
   private $conexion;

        public function __construct()
        {
            //Se crea la instancia de la BD
            $bd= new BaseDatos("1234");
            $this->conexion= $bd->conectar;
        }

        public function GetUsuarioDocum($documento, $password)
        {
           $sql= "SELECT * FROM tblusuarios WHERE id_cedula= $1 AND contraseña= $2"; /*El $1 es un placehor que representa el primer 
           parametro enviado con pg_query_params*/

           $result= pg_query_params($this->conexion, $sql, array($documento, $password));

           return pg_fetch_assoc($result); //Devuelve solo una fila como un array asociativo 
        }

    //Lo que hace esta función es obtener la información del usuario por medio de su documento.
}
?>