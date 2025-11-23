<?php
include_once '../../../conexionBD/BaseDatos.php';

class ModelPermisos
{
    private $objDB;
    private $conexion;

    public function __construct()
    {
        $this->objDB = new BaseDatos("ceron123");
        $this->conexion = $this->objDB->conectar;
    }

    //======== ROLES ================

    protected function GetRoles()
    {
        $sql = $this->objDB->Select("tblroles");
        return $sql;
    }

    protected function GetSegmentos()
    {
        $sql = $this->objDB->Select("tblsegmentos");
        return $sql;
    }


    protected function UpdateRol($datos, $id)
    {
        $sql = $this->objDB->Update("tblroles", $datos, $id);
        return $sql;
    }

    protected function CreateRol($datos)
    {
        $sql = $this->objDB->Insert("tblroles", $datos);
        if ($sql) {
            return true;
        }
    }

    protected function DeleteRol($id)
    {
        $sql = $this->objDB->Delete("tblroles", $id);
        if ($sql) {
            return true;
        } else {
            return false;
        }
    }

    // ======= PERMISOS =========

    protected function GetPerfiles()
    {
        $conexion = $this->conexion;

        $sql = "SELECT p.cod_permiso, s.*, r.*, ms.*
            FROM tblpermisos p 
            INNER JOIN tblsegmentos s ON s.cod_segmento = p.cod_segmento
            INNER JOIN tblroles r ON r.cod_rol = p.cod_rol
            INNER JOIN tblmodulossegmentos ms ON ms.cod_modseg = p.cod_modseg";

        $permisos = pg_query($conexion, $sql);
        return pg_fetch_all($permisos);
    }

    protected function GetPermisos($cod_permiso)
    {
        $permiso = (int)$cod_permiso;
        $conexion = $this->conexion;

        $sql = "SELECT pa.*, p._cod_permiso, am.*,  FROM tblpermisosacciones pa 
        INNER JOIN tblpermisos p ON p.cod_permiso = pa.cod_permiso
        INNER JOIN tblaccionesmodulo am ON am.cod_accionesmod = pa.cod_accionesmod";
    }
}
