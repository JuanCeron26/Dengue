<?php
include_once '../../../conexionBD/BaseDatos.php';

class modelEditar
{
    private $base; 

    public function __construct()
    {
        $this->base = new BaseDatos("ceron123"); 
    }

    //Editar el nombre del SitioECO
    public function EditarSitioEco($nomsitio, $codsitio)
    {
        //Datos a actualizar (solamente el nombre)
        $datos = ['nombre_sitio' => $nomsitio];

        //ID para identificar el registro que se va editar
        $id = ['cod_sitioeco' => $codsitio];

        // Usar la conexión existente 
        return $this->base->Update("tblsitioecosalud", $datos, $id);
    }

    //Validar que un SitioECO exista antes de editar
    public function ValidarSitioEcoExista($codsitio)
    {
        $sql = "SELECT cod_sitioeco FROM tblsitioecosalud WHERE cod_sitioeco = $1";
        $result = pg_query_params($this->base->conectar, $sql, [$codsitio]);

        return $result && pg_num_rows($result) > 0;
    }
}
