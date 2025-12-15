<?php
include_once "../../../conexionBD/BaseDatos.php";

class modelVerDetalle
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos("ceron123");
        $this->conexion = $bd->conectar;
    }

    // Obtener información de UN zoocriadero específico
    public function VerDetalleZoo($codZoo)
    {
        $sql = "SELECT z.cod_zoo, z.nombre_zoo, z.direccion_zoo, 
                u.nombre_usu, u.apellido_usu, z.id_usuarios,
                b.nombarrio
                FROM tblzoocriadero z
                LEFT JOIN tblusuarios u ON z.id_usuarios = u.id_usuarios
                LEFT JOIN tblbarrios b ON z.cod_barrio = b.cod_barrio
                WHERE z.cod_zoo = $1";

        $result = pg_query_params($this->conexion, $sql, [$codZoo]);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }

        return null;
    }

    // Obtener TODOS los tanques de un zoocriadero
    public function VerTanquesZoo($codZoo)
    {
        $sql = "SELECT zt.nom_zootanque, tp.nomtiptan, zt.cod_tipotanque
                FROM tblzootanque zt
                LEFT JOIN tbltipotanque tp ON zt.cod_tipotanque = tp.cod_tipotanque
                WHERE zt.cod_zoo = $1
                ORDER BY tp.nomtiptan, zt.nom_zootanque";

        $result = pg_query_params($this->conexion, $sql, [$codZoo]);

        return $result ? pg_fetch_all($result) : [];
    }
}
