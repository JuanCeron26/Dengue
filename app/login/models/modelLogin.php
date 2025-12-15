<?php
include_once "../../../conexionBD/BaseDatos.php";

class LoginModel
{
    private $conexion;

    public function __construct()
    {
        //Se crea la instancia de la BD
        $bd = new BaseDatos("ceron123");
        $this->conexion = $bd->conectar;
    }

    public function GetUsuarioDocum($documento, $password)
    {
        $sql = "SELECT u.*, r.nombre_rol as rol, s.nomsegmento as segmento, ms.nombre_modseg as modulo, u.cod_permiso as permiso
            FROM tblusuarios u
            INNER JOIN tblpermisos p ON p.cod_permiso = u.cod_permiso
            INNER JOIN tblsegmentos s ON p.cod_segmento = s.cod_segmento
            INNER JOIN tblroles r ON r.cod_rol = p.cod_rol
            LEFT JOIN tblmodulossegmentos ms ON ms.cod_modseg = p.cod_modseg -- Ya que pueden No haber coincidencias
            WHERE id_cedula= $1 AND contraseña= $2"; /*El $1 es un placehor que representa el primer 
           parametro enviado con pg_query_params*/

        $result = pg_query_params($this->conexion, $sql, array($documento, $password));

        return pg_fetch_assoc($result); //Devuelve solo una fila como un array asociativo 
    }

    //Lo que hace esta función es obtener la información del usuario por medio de su documento.
}
