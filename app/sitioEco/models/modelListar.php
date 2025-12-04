<?php
include_once '../../../conexionBD/BaseDatos.php';

class modelListar
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos('1234');
        $this->conexion = $bd->conectar;
    }

    //Listar todos los sitios de ECOSalud
    public function ListarSitioEco()
    {
        $sql = "SELECT s.cod_sitioeco, s.nombre_sitio, s.direccion, s.cod_barrio,
        b.nombarrio, c.nomcomun, c.cod_comun
        FROM tblsitioecosalud s
        LEFT JOIN tblbarrios b ON s.cod_barrio = b.cod_barrio
        INNER JOIN tblcomuna c ON b.cod_comun = c.cod_comun
        ORDER BY s.nombre_sitio ASC";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }

    //Obtener lista de Barrios 
    public function SelectBarrios()
    {
        $sql = "SELECT cod_barrio, nombarrio
        FROM tblbarrios
        ORDER BY nombarrio";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }

    //Obtener lista de Comunas
    public function SelectComunas()
    {
        $sql = "SELECT cod_comun, nomcomun
        FROM tblcomuna
        ORDER BY nomcomun ASC";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }
}
