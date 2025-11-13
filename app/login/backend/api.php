<?php
include_once '../../../conexionBD/BaseDatos.php';

class Login
{
    private $conexion;

    public function __construct()
    {
        $obj = new BaseDatos("ceron123");
        $this->conexion = $obj->conectar;
    }

    public function insertar()
    {
        $sql = "INSERT INTO tblzoocriadero (nombre_zoo, direccion_zoo, cod_barrio) 
        VALUES ('Juan Jose', 'CALLE 1223', 3)";

        $insertar = $this->conexion->prepare($sql);
        $ejecutar = $insertar->execute();

        if ($ejecutar) {
            echo "<script>alert('funciono')</script>";
        } else {
            echo "no";
        }
    }
}

$create = new Login();
$create->insertar();
