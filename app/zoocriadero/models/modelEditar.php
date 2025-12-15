<?php
include_once "../../../conexionBD/BaseDatos.php";

class modelEditar
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos('ceron123');
        $this->conexion = $bd->conectar;
    }

    public function ObtenerZoo($codZoo)
    {
        $sql = "SELECT z.cod_zoo, z.nombre_zoo, z.direccion_zoo, z.cod_barrio,
                u.nombre_usu, u.apellido_usu, z.id_usuarios, b.nombarrio
                FROM tblzoocriadero z
                LEFT JOIN tblusuarios u ON z.id_usuarios = u.id_usuarios
                LEFT JOIN tblbarrios b ON z.cod_barrio = b.cod_barrio
                WHERE z.cod_zoo = $1";
        
        $result = pg_query_params($this->conexion, $sql, [$codZoo]);

        if($result && pg_num_rows($result) > 0){
            return pg_fetch_assoc($result);
        }
        return null;
    }

    //INNER JOIN para obtener solo tanques con zoocriadero
    public function ObtenerTanquesZoo($codZoo)
    {
        $sql = "SELECT 
                    zt.cod_zootanque,
                    zt.nom_zootanque,
                    zt.cod_tipotanque,
                    tp.nomtiptan,
                    zt.cod_zoo
                FROM tblzootanque zt
                INNER JOIN tblzoocriadero z ON zt.cod_zoo = z.cod_zoo
                INNER JOIN tbltipotanque tp ON zt.cod_tipotanque = tp.cod_tipotanque
                WHERE zt.cod_zoo = $1
                ORDER BY tp.nomtiptan, zt.nom_zootanque ASC";

        $result = pg_query_params($this->conexion, $sql, [$codZoo]);

        return $result ? pg_fetch_all($result) : [];
    }

    public function VerificarZooExiste($codZoo)
    {
        $sql = "SELECT cod_zoo FROM tblzoocriadero WHERE cod_zoo = $1";

        $result = pg_query_params($this->conexion, $sql, [$codZoo]);
        return $result && pg_num_rows($result) > 0;
    }

    public function EditarZoo($codZoo, $datos)
    {
        $sql = "UPDATE tblzoocriadero SET 
                nombre_zoo = $1,
                direccion_zoo = $2,
                cod_barrio = $3,
                id_usuarios = $4
                WHERE cod_zoo = $5";

        $params = [
            $datos['nombre_zoo'],
            $datos['direccion_zoo'],
            $datos['cod_barrio'],
            $datos['id_usuarios'],
            $codZoo
        ];

        $result = pg_query_params($this->conexion, $sql, $params);
        
        return $result ? true : false;
    }

    public function ObtenerBarrios()
    {
        $sql = "SELECT cod_barrio, nombarrio 
                FROM tblbarrios 
                ORDER BY nombarrio ASC";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }

    public function ObtenerEncargados()
    {
        $sql = "SELECT id_usuarios, nombre_usu, apellido_usu 
                FROM tblusuarios 
                WHERE cod_estadousu = true 
                ORDER BY nombre_usu ASC";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }

    // Método para editar un tanque individual
    public function EditarTanque($codTanque, $datos)
    {
        $sql = "UPDATE tblzootanque SET 
                nom_zootanque = $1,
                cod_tipotanque = $2
                WHERE cod_zootanque = $3";

        $params = [
            $datos['nom_zootanque'],
            $datos['cod_tipotanque'],
            $codTanque
        ];

        $result = pg_query_params($this->conexion, $sql, $params);
        return $result ? true : false;
    }

    // Método para eliminar tanque
    public function EliminarTanque($codTanque)
    {
        $sql = "DELETE FROM tblzootanque WHERE cod_zootanque = $1";
        $result = pg_query_params($this->conexion, $sql, [$codTanque]);
        return $result ? true : false;
    }

    // Obtener tipos de tanque para el select
    public function ObtenerTiposTanque()
    {
        $sql = "SELECT cod_tipotanque, nomtiptan 
                FROM tbltipotanque 
                ORDER BY nomtiptan ASC";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }
}
?>