<?php
include_once "../../../conexionBD/BaseDatos.php";

class modelAnular
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos("ceron123");
        $this->conexion = $bd->conectar;
    }

    //Verificar si un Zoo existe antes de anular
    public function VerificarZooExiste($codZoo)
    {
        $sql = "SELECT cod_zoo FROM tblzoocriadero WHERE cod_zoo = $1";
        $result = pg_query_params($this->conexion, $sql, [$codZoo]);

        return $result && pg_num_rows($result) > 0;
    }

    //Anular un Zoo
    public function AnularZoo($codZoo)
    {
        $datos = [
            "cod_estado" => 2
        ];

        $condicion = [
            "cod_zoo" => $codZoo
        ];

        $base = new BaseDatos("ceron123");
        return $base->Anular("tblzoocriadero", $datos, $condicion);
    }
}
