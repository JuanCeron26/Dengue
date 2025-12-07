<?php 
include_once '../../../conexionBD/BaseDatos.php';

class modelVerDetalle
{
    private $base;

    public function __construct()
    {
       $this->base = new BaseDatos("1234");
    }

    // Obtener la información completa de un sitioECO específico
    public function VerDetalleSitioEco($codSitioeco)
    {
        $sql = "SELECT s.cod_sitioeco, s.nombre_sitio, s.direccion, b.nombarrio,c.nomcomun
        FROM tblsitioecosalud s
        LEFT JOIN tblbarrios b ON s.cod_barrio = b.cod_barrio
        LEFT JOIN tblcomunas c ON b.cod_comun = c.cod_comun
        WHERE s.cod_sitioeco = $1";

        $result = pg_query_params($this->base->conectar, $sql, [$codSitioeco]);

        if($result && pg_num_rows($result) > 0){
            return pg_fetch_assoc($result);
        }
        return null;
    }
}
?>