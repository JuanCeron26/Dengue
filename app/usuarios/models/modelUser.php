<?php
include_once '../../../conexionBD/BaseDatos.php';

class modelUser
{
    private $conexion;
    private $objDB;

    public function __construct()
    {
        $this->objDB = new BaseDatos("ceron123");
        $this->conexion = $this->objDB->conectar;
    }

    public function GetUsuarios()
    {
        $conexion = $this->conexion;

        $sql = "SELECT 
                u.id_usuarios,
                u.nombre_usu,
                u.apellido_usu,
                u.id_cedula,
                u.correo_electronico,
                td.nombre_tipodocum as tipo_doc,
                r.nombre_rol,
                s.nomsegmento,
                ms.nombre_modseg
            FROM tblusuarios u 
            INNER JOIN tbltipodocum td ON td.cod_tipodocum = u.cod_tipodocum
            INNER JOIN tblpermisos p ON p.cod_permiso = u.cod_permiso
            INNER JOIN tblroles r ON r.cod_rol = p.cod_rol
            INNER JOIN tblsegmentos s ON s.cod_segmento = p.cod_segmento
            LEFT JOIN tblmodulossegmentos ms ON ms.cod_modseg = p.cod_modseg
            ORDER BY u.id_usuarios DESC";

        $ejecucion = pg_query($conexion, $sql);

        if (!$ejecucion) {
            return [
                "status" => "error",
                "mensaje" => pg_last_error($conexion)
            ];
        }

        $filas = pg_fetch_all($ejecucion);
        return $filas ? $filas : [];
    }

    public function GetTipoDocumento()
    {
        $documentos = $this->objDB->Select("tbltipodocum");
        return $documentos;
    }

    public function GetPerfiles()
    {
        $conexion = $this->conexion;

        $sql = "SELECT 
                p.cod_permiso,
                p.nombre_permiso,
                p.cod_segmento,
                p.cod_rol,
                p.cod_modseg,
                r.nombre_rol,
                s.nomsegmento,
                ms.nombre_modseg
            FROM tblpermisos p
            INNER JOIN tblroles r ON r.cod_rol = p.cod_rol
            INNER JOIN tblsegmentos s ON s.cod_segmento = p.cod_segmento
            LEFT JOIN tblmodulossegmentos ms ON ms.cod_modseg = p.cod_modseg
            ORDER BY p.cod_permiso";

        $ejecucion = pg_query($conexion, $sql);

        if (!$ejecucion) {
            return [];
        }

        $filas = pg_fetch_all($ejecucion);
        return $filas ? $filas : [];
    }

    public function GetUsuario($id_user)
    {
        $id = (int)$id_user;
        $conexion = $this->conexion;

        $sql = "SELECT 
                u.*,
                td.nombre_tipodocum as tipo_doc,
                r.nombre_rol,
                s.nomsegmento,
                ms.nombre_modseg
            FROM tblusuarios u 
            INNER JOIN tbltipodocum td ON td.cod_tipodocum = u.cod_tipodocum
            INNER JOIN tblpermisos p ON p.cod_permiso = u.cod_permiso
            INNER JOIN tblroles r ON r.cod_rol = p.cod_rol
            INNER JOIN tblsegmentos s ON s.cod_segmento = p.cod_segmento
            LEFT JOIN tblmodulossegmentos ms ON ms.cod_modseg = p.cod_modseg
            WHERE u.id_usuarios = $1";

        $ejecucion = pg_query_params($conexion, $sql, [$id]);
        if ($ejecucion) {
            return pg_fetch_assoc($ejecucion);
        } else {
            return false;
        }
    }

    // Funciones de CRUD

    public function InsertUsuario($datos)
    {
        $insertar = $this->objDB->Insert("tblusuarios", $datos);
        return $insertar;
    }

    public function UpdateUsuario($id, $datos)
    {
        $actualizar = $this->objDB->Update("tblusuarios", $datos, ["id_usuarios" => $id]);
        return $actualizar;
    }

    public function DeleteUser($id)
    {
        $eliminar = $this->objDB->Delete("tblusuarios", ["id_usuarios" => $id]);
        if ($eliminar) {
            return true;
        } else {
            return false;
        }
    }
}
