<?php 
class Conexion
{
    private $servername = "localhost";
    private $database = "bd_dengue";
    private $username = "postgres";
    private $password = "1234";
    private $conexion;

    //Método Conexión
    public function __construct()
    {
        //Cadena de conexión
        $conn_string = "host=$this->servername dbname=$this->database user=$this->username 
        password=$this->password";

        //Conectar
        $this->conexion = pg_connect($conn_string);

        //Validar Conexión
        if(!$this->conexion){
            die("¡Error de conexión! No se pudo conectar con PotsgreSQL". pg_last_error());
        }
        return $this->conexion;
    }

    //La cadena de conexión es un string (cadena de texto) que le permite a PostgreSQL cómo y en 
    //dónde conectarse. "$conn_string" es solamente el nombre de la variable.
}

$obj = new Conexion();

?>