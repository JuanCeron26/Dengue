<?php 
include_once '../../../conexionBD/BaseDatos.php';

class modelRegistrar
{
    private $conexion;

    //Iniciar instancia de Conexión
    public function __construct()
    {
        $bd= new BaseDatos("1234");
        $this->conexion= $bd->conectar;
    }

    //Registar Sitio ECO
    public function RegistarSitioEco($datos)
    {
        $base= new BaseDatos("1234");
        return $base->Insert("tblsitioecosalud", $datos);
    }

    //Obtener el ultimo sitio ECO registrado
    public function ObtenerUltimoSitioEco()
    {
        $sql = "SELECT cod_sitioeco
        FROM tblsitioecosalud 
        ORDER BY cod_sitioeco DESC 
        LIMIT 1";

        $result= pg_query($this->conexion, $sql);

        if($result && pg_num_rows($result) > 0){
            $row= pg_fetch_assoc($result);
            return $row['cod_sitioeco'];
        }

        return null;
    }

    //Obtener Barrio
    public function SelectBarrio()
    {
        $sql= "SELECT cod_barrio, nombarrio
        FROM tblbarrios
        ORDER BY nombarrio";

        $result= pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result): [];
    }
}

?>