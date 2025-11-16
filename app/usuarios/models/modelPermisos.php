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
}
