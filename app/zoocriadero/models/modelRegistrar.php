<?php 
include_once "../../../conexionBD/BaseDatos.php";

class modelRegistrar
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos("ceron123");
        $this->conexion = $bd->conectar;
    }

    // Registrar zoocriadero
    public function RegistrarZoo($datos)
    {
        $base = new BaseDatos("ceron123");
        return $base->Insert("tblzoocriadero", $datos);
    }

    // Obtener el último zoocriadero registrado
    public function ObtenerUltimoZoo()
    {
        $sql = "SELECT cod_zoo 
                FROM tblzoocriadero 
                ORDER BY cod_zoo DESC 
                LIMIT 1";
        
        $result = pg_query($this->conexion, $sql);
        
        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            return $row['cod_zoo'];
        }
        
        return null;
    }

    // Registrar un tanque 
    public function RegistrarTanqueZoo($datos)
    {
        $base = new BaseDatos("ceron123");
        return $base->Insert("tblzootanque", $datos);
    }

    // Obtener barrios
    public function SelectBarrio()
    {
        $sql = "SELECT cod_barrio, nombarrio
                FROM tblbarrios
                ORDER BY nombarrio";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }

    // Obtener tipos de tanque (para el select)
    public function SelectTiposTanque()
    {
        $sql = "SELECT cod_tipotanque, nomtiptan
                FROM tbltipotanque
                ORDER BY nomtiptan";
        
        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }
}
?>