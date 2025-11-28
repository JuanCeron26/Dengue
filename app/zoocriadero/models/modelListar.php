<?php
include_once "../../../conexionBD/BaseDatos.php";

class modelListar
{
    private $conexion;

    public function __construct()
    {
        //Se crea la instancia de la BD
        $bd = new BaseDatos("1234");
        $this->conexion = $bd->conectar;
    }

    //Consulta SQL Zoocriadero
    public function SelectZoo()
    {
        $sql = "SELECT z.cod_zoo, z.nombre_zoo, z.direccion_zoo, 
        tp.nomtiptan, u.nombre_usu, u.apellido_usu, z.id_usuarios
        FROM tblzoocriadero z
        LEFT JOIN tbltipotanque tp ON z.cod_tipotanque = tp.cod_tipotanque
        LEFT JOIN tblusuarios u ON z.id_usuarios = u.id_usuarios
        ORDER BY z.cod_zoo DESC";


        $result = pg_query($this->conexion, $sql);

        return $result ? pg_fetch_all($result) : [];
    }

    //Consulta SQL Encargado del Zoo
    public function SelectEncargado()
    {
        $sql = "SELECT DISTINCT u.id_usuarios, u.nombre_usu, u.apellido_usu
        FROM tblusuarios u
        INNER JOIN tblzoocriadero z ON u.id_usuarios = z.id_usuarios
        ORDER BY u.nombre_usu, u.apellido_usu ";

        $result = pg_query($this->conexion, $sql);

        return $result ? pg_fetch_all($result) : [];
    }

    //Consulta SQL Tipo de Tanque
    public function SelectTiposTanque()
    {
        $sql = "SELECT DISTINCT cod_tipotanque, nomtiptan
            FROM tbltipotanque
            ORDER BY nomtiptan DESC";

        $result = pg_query($this->conexion, $sql);

        return $result ? pg_fetch_all($result) : [];
    }
}
