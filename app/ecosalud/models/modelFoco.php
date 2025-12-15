<?php
include_once '../../../conexionBD/BaseDatos.php';

class modelFofo
{
    private $conexion;
    private $objDB;

    public function __construct()
    {
        $this->objDB = new BaseDatos("ceron123");
        $this->conexion = $this->objDB->conectar;
    }

    protected function InsertFocoPotencial($focolugar, $muchos)
    {

        try {
            pg_query($this->conexion, "BEGIN");

            $cod_focopotlugar = $this->objDB->InsertReturning("tblfocopotenciallugar", $focolugar, "cod_focopotlugar");

            if (!$cod_focopotlugar) {
                pg_query($this->conexion, "ROLLBACK");
            }

            $array = $muchos;
            $array['cod_focopotlugar'] = (int)$cod_focopotlugar;

            $sqlMuchos = $this->objDB->Insert("tblfocopotencialtipofoco", $array);

            if ($sqlMuchos) {
                pg_query($this->conexion, "COMMIT");
            }

            return true;
        } catch (Exception $th) {
            throw $th;
        }
    }

    protected function GetTiposFocos()
    {
        return $this->objDB->Select("tbltipofoco");
    }

    protected function GetFocosPotenciales()
    {
        $sql = "SELECT ftf.cod_focopotencial_tipofoco, fpl.*, tf.cod_tipo_foc, tf.nombre_foco
        FROM tblfocopotencialtipofoco ftf
        INNER JOIN tblfocopotenciallugar fpl ON fpl.cod_focopotlugar = ftf.cod_focopotlugar
        INNER JOIN tbltipofoco tf ON ftf.cod_tipo_foc = tf.cod_tipo_foc";

        $ejecutar = pg_query($this->conexion, $sql);
        return pg_fetch_all($ejecutar);
    }

    protected function UpdateFocoPotencial($cod_focopotlugar, $datos_lugar, $datos_tipo)
    {
        try {
            pg_query($this->conexion, "BEGIN");

            // Actualizar tblfocopotenciallugar
            $where = ["cod_focopotlugar" => $cod_focopotlugar];
            $updateLugar = $this->objDB->Update("tblfocopotenciallugar", $datos_lugar, $where);

            if (!$updateLugar) {
                pg_query($this->conexion, "ROLLBACK");
                return false;
            }

            // Actualizar tblfocopotencialtipofoco (la relación)
            $where2 = ["cod_focopotlugar" => $cod_focopotlugar];
            $updateTipo = $this->objDB->Update("tblfocopotencialtipofoco", $datos_tipo, $where2);

            if ($updateTipo) {
                pg_query($this->conexion, "COMMIT");
                return true;
            } else {
                pg_query($this->conexion, "ROLLBACK");
                return false;
            }
        } catch (Exception $th) {
            pg_query($this->conexion, "ROLLBACK");
            throw $th;
        }
    }

    protected function GetParticipantes($cod_territorio)
    {
        // Este será el <select> de los participantes a la hora de registrar el foco

        $sql = "SELECT CONCAT(p.nom_part, ' ', p.ape_part) as nombre, p.id_part as id
        FROM tblterprioparticipantes tp
        INNER JOIN tblparticipantes p ON p.id_part = tp.id_part
        WHERE tp.cod_territorio = $cod_territorio";
        $ejecutar = pg_query($this->conexion, $sql);
        return pg_fetch_all($ejecutar);
    }

    protected function GetUsersEcosalud($cod_territorio)
    {
        // Tambien para los selects del control de actividad

        $sql = "SELECT cau.id_usuariocontroleco as id, CONCAT(u.nombre_usu, ' ', u.apellido_usu) as nombre
        FROM tblcontrolactividad ca
        INNER JOIN tblcontrolactividadusuarios cau ON cau.cod_controlactividadeco = ca.cod_controlactividadeco
        INNER JOIN tblusuariocontrolacteco eu ON cau.id_usuariocontroleco = eu.id_usuariocontroleco
        INNER JOIN tblusuarios u ON u.id_usuarios = eu.id_usuarios
        WHERE ca.cod_territorio = $cod_territorio AND ca.cod_actividadeco = 1";
        // el 3 es el $cod_territorio, y el 1 si es estático

        $ejecutar = pg_query($this->conexion, $sql);
        $resultado = pg_fetch_all($ejecutar);
        return $resultado === false ? [] : $resultado;
    }

    protected function GetFocoPotencial($cod_focopotlugar)
    {
        $id = (int)$cod_focopotlugar;
        $sql = "SELECT ftf.cod_focopotencial_tipofoco, fpl.*, tf.cod_tipo_foc, tf.nombre_foco
            FROM  tblfocopotenciallugar fpl 
            INNER JOIN tblfocopotencialtipofoco ftf ON fpl.cod_focopotlugar = ftf.cod_focopotlugar
            INNER JOIN tbltipofoco tf ON ftf.cod_tipo_foc = tf.cod_tipo_foc
            WHERE fpl.cod_focopotlugar = $1";

        $ejecutar = pg_query_params($this->conexion, $sql, [$id]);

        return pg_fetch_assoc($ejecutar);
    }

    protected function GetFocosActuales($cod_territorio, $ecosalud = false)
    {
        $sql = "SELECT 
                fl.cod_focopotlugar as id,
                fl.dirección as direccion,
                fl.tipo_via,
                fl.numero_via,
                fl.sufijo,
                fl.distancia,
                fl.realizo,
                fl.lugar,
                --fl.fecha,
                tf.nombre_foco as nombre,
                tf.cod_tipo_foc,
                ftf.cod_focopotencial_tipofoco
            FROM tblfocopotencialtipofoco ftf
            INNER JOIN tblfocopotenciallugar fl ON fl.cod_focopotlugar = ftf.cod_focopotlugar
            INNER JOIN tbltipofoco tf ON tf.cod_tipo_foc = ftf.cod_tipo_foc
            WHERE fl.cod_territorio = $cod_territorio";
        if ($ecosalud == true) {
            $sql .= " AND fl.realizo = 'Equipo Ecosalud'";
        } else {
            $sql .= " AND fl.realizo != 'Equipo Ecosalud'";
        }

        $ejecutar = pg_query($this->conexion, $sql);
        return pg_fetch_all($ejecutar);
    }

    protected function DeleteFocoActual($cod)
    {
        try {

            $d = [
                "cod_focopotlugar" => $cod
            ];
            pg_query($this->conexion, "BEGIN");

            $ejec1 = $this->objDB->Delete("tblfocopotencialtipofoco", $d);
            if (!$ejec1) {
                pg_query($this->conexion, "ROLLBACK");
            }

            $ejec2 = $this->objDB->Delete("tblfocopotenciallugar", $d);
            if (!$ejec2) {
                pg_query($this->conexion, "ROLLBACK");
            }

            pg_query($this->conexion, "COMMIT");
            return true;
        } catch (Exception $th) {
            throw $th;
        }
    }
}
/*
$c = new modelFofo();
print_r($c->GetUsersEcosalud(3));
*/
/*
$c = new modelFofo();
print_r($c->GetFocosActuales(3, false));
*/