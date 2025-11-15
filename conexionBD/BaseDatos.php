<?php 
class Conexion
{
    private $conexion;

    function Conexionpg()
    {
        //Párametros de conexión
        $servername = "localhost";
        $database = "bd_dengue";
        $username = "postgres";
        $password = "1234";

        //Cadena de conexión
        $coon_string = "host=$servername dbname=$database user=$username password=a$password";

        //Conectar
        $this->conexion = pg_connect($coon_string);

        //Validar conexión
        if(!$this->conexion){
            die("Error al conectar a PostgreSQL". pg_last_error());
        }

        return $this->conexion;
    }

    //La cadena de conexión es un string (cadena de texto) que le permite a PostgreSQL cómo y en 
    //dónde conectarse. "$coon_string" es solamente el nombre de la variable.
}



?>