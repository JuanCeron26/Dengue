<?php 
include_once '../../../conexionBD/BaseDatos.php';

class modelAnular
{
    private $base;

    public function __construct()
    {
        $this->base = new BaseDatos("ceron123");
    }

    // Verificar que un sitioECO existe antes de ser anulado
    public function VerificarSitioEcoExiste($codSitioeco)
    {
        $sql = "SELECT cod_sitioeco FROM tblsitioecosalud WHERE cod_sitioeco = $1";
        $result = pg_query_params($this->base->conectar, $sql, [$codSitioeco]);

        return $result && pg_num_rows($result) > 0;
    }

    //Verificar si el sitio tiene territorios asociados
    public function TieneTerritoriosAsociados($codSitioeco)
    {
        $sql = "SELECT COUNT(*) as total 
                FROM tblterritoriopriorizado 
                WHERE cod_sitioeco = $1";
        
        $result = pg_query_params($this->base->conectar, $sql, [$codSitioeco]);

        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            return (int)$row['total'] > 0;
        }

        return false;
    }

    // Anular un sitioECO (cambiar estado a 2)
    public function AnularSitioEco($codSitioeco)
    {
        $datos = [
            "cod_estadositioeco" => 2  // Estado "Anulado"
        ];

        $condicion = [
            "cod_sitioeco" => $codSitioeco
        ];

        // Usar la conexión existente (sin crear una nueva)
        return $this->base->Update("tblsitioecosalud", $datos, $condicion);
    }
}
?>