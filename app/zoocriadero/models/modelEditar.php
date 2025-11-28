<?php
include_once "../../../conexionBD/BaseDatos.php";

class modelEditar
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos();
        $this->conexion = $bd->conectar;
    }

    //Obtener la información del Zoo a editar
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

    //Obtener tanques del Zoo
    public function ObtenerTanquesZoo($codZoo)
    {
        $sql = "SELECT zt.nom_zootanque, tp.nomtiptan, zt.cod_zootanque
        FROM tblzootanque zt
        LEFT JOIN tbltipotanque tp ON zt.cod_tipotanque = tp.cod_tipotanque
        WHERE zt.cod_zoo = $1
        ORDER BY zt.nom_zootanque, tp.nomtiptan DESC";

        $result = pg_query_params($this->conexion, $sql, [$codZoo]);

        return $result ? pg_fetch_all($result) : [];
    }

    //Verificar si el Zoo existe antes de editar
    public function VerificarZooExiste($codZoo)
    {
        $sql = "SELECT cod_zoo FROM tblzoocriadero WHERE cod_zoo = $1";

        $result = pg_query_params($this->conexion, $sql, [$codZoo]);
        return $result && pg_num_rows($result) > 0;
    }

    //Editar los datos del Zoo
    public function EditarZoo($codZoo, $datos)
    {
        $datosActualizar = [
            "nombre_zoo"      => $datos['nombre_zoo'],
            "direccion_zoo"   => $datos['direccion_zoo'],
            "cod_barrio"      => $datos['cod_barrio'],
            "id_usuarios"     => $datos['id_usuarios']
        ];

        $condicion = [
            "cod_zoo" => $codZoo
        ];

        $base = new BaseDatos();
        return $base->Update("tblzoocriadero", $datosActualizar, $condicion);
    }

    //Obtener Barrios 
    public function ObtenerBarrios()
    {
        $sql = "SELECT cod_barrio, nombarrio FROM tblbarrios ORDER BY nombarrio ASC";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }

    //Obtener Encargados
    public function ObtenerEncargados()
    {
        $sql = "SELECT id_usuarios, nombre_usu, apellido_usu FROM tblusuarios 
        WHERE cod_estadousu = true 
        ORDER BY nombre_usu ASC";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }
}
?>