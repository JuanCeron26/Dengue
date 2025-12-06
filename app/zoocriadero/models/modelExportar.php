<?php
include_once "../../../conexionBD/BaseDatos.php";

class ModelExportar
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos("1234");
        $this->conexion = $bd->conectar;
    }

    public function obtenerZoocriadero($cod_zoo)
    {
        $sql = "SELECT 
                    z.cod_zoo,
                    z.nombre_zoo,
                    z.direccion_zoo,
                    CONCAT(u.nombre_usu, ' ', u.apellido_usu) as encargado,
                    b.nombarrio
                FROM tblzoocriadero z
                LEFT JOIN tblusuarios u ON z.id_usuarios = u.id_usuarios
                LEFT JOIN tblbarrios b ON z.cod_barrio = b.cod_barrio
                WHERE z.cod_zoo = $cod_zoo AND z.cod_estado = 1";

        $result = pg_query($this->conexion, $sql);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }

        return null;
    }

    public function obtenerTanques($cod_zoo)
    {
        $sql = "SELECT zt.cod_zootanque, zt.nom_zootanque, zt.cod_estado, tt.nomtiptan
        FROM tblzootanque zt
        INNER JOIN tbltipotanque tt ON zt.cod_tipotanque = tt.cod_tipotanque
        WHERE zt.cod_zoo = $cod_zoo
        ORDER BY zt.cod_estado DESC, zt.cod_zootanque";

        $result = pg_query($this->conexion, $sql);

        return $result ? pg_fetch_all($result) : [];
    }
}
