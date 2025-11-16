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
            INNER JOIN tblroles r ON r.cod_rol = u.cod_rol
            ORDER BY u.id_usuarios DESC";

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

    public function GetUsuario($id_user)
    {
        $id = (int)$id_user;
        $conexion = $this->conexion;
        $sql = "SELECT u.*, td.nombre_tipodocum as tipo_doc, s.nomsegmento as segmento, r.nombre_rol as rol 
            FROM tblusuarios u 
            INNER JOIN tbltipodocum td ON td.cod_tipodocum = u.cod_tipodocum
            INNER JOIN tblsegmentos s ON s.cod_segmento = u.cod_segmento
            INNER JOIN tblroles r ON r.cod_rol = u.cod_rol 
            WHERE id_usuarios = $1";

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

    public function UpdateUsuario($datos, $id)
    {
        $id_user = [
            "id_usuarios" => (int)$id
        ];
        $editar = $this->objDB->Update("tblusuarios", $datos, $id_user);
        if ($editar) {
            return true;
        } else {
            return false;
        }
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
