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

    protected function GetAllModulosAcciones()
    {
        $sql = "SELECT m.cod_mod, m.nom_modulo, a.cod_accionesmod, a.nom_accion
        FROM tblmodulos m
        CROSS JOIN tblaccionesmodulo a
        ORDER BY m.cod_mod, a.cod_accionesmod";

        $ejecutar = pg_query($this->conexion, $sql);

        $modulos = [];

        while ($fila = pg_fetch_assoc($ejecutar)) {
            $cod_mod = $fila['cod_mod'];

            if (!isset($modulos[$cod_mod])) {
                $modulos[$cod_mod] = [
                    "cod_mod" => $cod_mod,
                    "nom_mod" => $fila['nom_modulo'],
                    "acciones" => []
                ];
            }

            $modulos[$cod_mod]['acciones'][] = [
                "cod_accionesmod" => $fila['cod_accionesmod'],
                "nom_accion" => $fila['nom_accion']
            ];
        }

        return $modulos;
    }

    protected function GetAccionesPermiso($cod_permiso)
    {
        $permiso = (int)$cod_permiso;

        $sql = "SELECT m.nom_modulo, am.nom_accion, p.cod_permiso, pa.cod_peracc, m.cod_mod, am.cod_accionesmod
        FROM tblpermisos p
        INNER JOIN tblpermisosacciones pa ON p.cod_permiso = pa.cod_permiso
        INNER JOIN tblaccionesmodulo am ON am.cod_accionesmod = pa.cod_accionesmod
        INNER JOIN tblmodulos m ON m.cod_mod = pa.cod_mod
        WHERE p.cod_permiso = $1";

        $ejecutar = pg_query_params($this->conexion, $sql, [$permiso]);

        $acciones = [];
        while ($fila = pg_fetch_assoc($ejecutar)) {
            $acciones[] = $fila;
        }

        return $acciones;
    }

    public function UpdatePermisos($cod_permiso, $permisos)
    {
        try {

            pg_query($this->conexion, "BEGIN");


            $sqlDelete = "DELETE FROM tblpermisosacciones WHERE cod_permiso = $1";
            $resultDelete = pg_query_params($this->conexion, $sqlDelete, [$cod_permiso]);

            if (!$resultDelete) {
                throw new Exception("Error al eliminar permisos anteriores");
            }

            // Insertar los nuevos permisos
            $sqlInsert = "INSERT INTO tblpermisosacciones (cod_permiso, cod_accionesmod, cod_mod) 
                VALUES ($1, $2, $3)";

            foreach ($permisos as $permiso) {
                $resultInsert = pg_query_params(
                    $this->conexion,
                    $sqlInsert,
                    [
                        $cod_permiso,
                        $permiso['cod_accionesmod'],
                        $permiso['cod_mod']
                    ]
                );

                if (!$resultInsert) {
                    throw new Exception("Error al insertar permiso");
                }
            }

            pg_query($this->conexion, "COMMIT");

            return "exito";
        } catch (Exception $e) {
            pg_query($this->conexion, "ROLLBACK");

            return "fallo";
        }
    }
}
