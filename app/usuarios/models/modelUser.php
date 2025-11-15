<?php
include_once '../../../conexionBD/BaseDatos.php';

class modelUser
{
    private $conexion;
    private $objDB;

    public function __construct()
    {
        $this->objDB = new BaseDatos("ceron123"); // para usar las funciones genéricas
        $this->conexion = $this->objDB->conectar; // para hacer funciones propias
    }

    public function GetUsuarios()
    {
        $conexion = $this->conexion;

        $sql = "SELECT u.*, td.nombre_tipodocum as tipo_doc, s.nomsegmento as segmento, r.nombre_rol as rol 
            FROM tblusuarios u 
            INNER JOIN tbltipodocum td ON td.cod_tipodocum = u.cod_tipodocum
            INNER JOIN tblsegmentos s ON s.cod_segmento = u.cod_segmento
            INNER JOIN tblroles r ON r.cod_rol = u.cod_rol";

        $ejecucion = pg_query($conexion, $sql);

        if (!$ejecucion) {
            // SIEMPRE devolver JSON aunque haya error 
            return [
                "status" => "error",
                "mensaje" => pg_last_error($conexion)
            ];
        }

        $filas = pg_fetch_all($ejecucion);

        // Si viene false, devolver array vacío para no romper JSON
        return $filas ? $filas : [];
    }

    public function GetTipoDocumento()
    {
        $documentos = $this->objDB->Select("tbltipodocum");
        return $documentos;
    }

    public function GetRoles()
    {
        $roles = $this->objDB->Select("tblroles");
        return $roles;
    }

    public function GetSegmentos()
    {
        $segmentos = $this->objDB->Select("tblsegmentos");
        return $segmentos;
    }
}
