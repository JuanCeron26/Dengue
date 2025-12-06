<?php 
include_once '../../../conexionBD/BaseDatos.php';

class modelEditar
{
    private $conexion;

    public function __construct()
    {
       $bd= new BaseDatos("1234");
       $this->conexion= $bd->conectar;
    }

    //Editar el nombre del SitioECO
    public function EditarSitioEco($nomsitio, $codsitio)
    {
        //Datos a actualizar (solamente el nombre)
        $datos= ['nombre_sitio' => $nomsitio];

        //ID para identificar el registro que se va editar
        $id= ['cod_sitioeco' => $codsitio];


        $base= new BaseDatos("1234");
        return $base->Update("tblsitioecosalud", $datos, $id);
    }

    //Validar que un SitioECO exista antes de editar
    public function ValidarSitioEcoExista($codsitio)
    {
        $sql= "SELECT cod_sitioeco FROM tblsitioecosalud WHERE cod_sitioeco = $1";
        $result= pg_query_params($this->conexion, $sql, [$codsitio]);

        return $result && pg_num_rows($result) > 0;
    }
}
?>