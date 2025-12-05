<?php
include_once "../../../conexionBD/BaseDatos.php";

class modelTanque
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos("1234");
        $this->conexion = $bd->conectar;
    }


    //Obtener tanques por zoocriadero
    public function SelectTanquesZoo($cod_zoo)
    {
        try {
            $sql = "SELECT zt.cod_zootanque, zt.nom_zootanque, zt.cod_tipotanque, 
                    tt.nomtiptan, zt.cod_estado
                    FROM tblzootanque zt
                    LEFT JOIN tbltipotanque tt ON zt.cod_tipotanque = tt.cod_tipotanque
                    WHERE zt.cod_zoo = $cod_zoo AND zt.cod_estado = 1
                    ORDER BY zt.cod_zootanque DESC";

            $result = pg_query($this->conexion, $sql);
            return $result ? pg_fetch_all($result) : [];
        } catch (Exception $e) {
            error_log("Error al obtener tanques: " . $e->getMessage());
            return [];
        }
    }

    //Insertar un nuevo tanque
    public function InsertarTanque($cod_zoo, $cod_tipotanque, $nom_zootanque)
    {
        try {
            $nom_zootanque_escaped = pg_escape_string($this->conexion, $nom_zootanque);

            $sql = "INSERT INTO tblzootanque (cod_zoo, cod_tipotanque, nom_zootanque, cod_estado) 
                VALUES ($cod_zoo, $cod_tipotanque, '$nom_zootanque_escaped', 1)";

            $resultado = pg_query($this->conexion, $sql);

            if ($resultado) {
                return true;
            } else {
                error_log("Error al insertar tanque: " . pg_last_error($this->conexion));
                return false;
            }
        } catch (Exception $e) {
            error_log("Error al insertar tanque: " . $e->getMessage());
            return false;
        }
    }

    //Editar tanque (nombre y tipo)
    public function EditarTanque($cod_zootanque, $cod_tipotanque, $nom_zootanque)
    {
        try {
            $nom_zootanque_escaped = pg_escape_string($this->conexion, $nom_zootanque);

            $sql = "UPDATE tblzootanque 
                    SET cod_tipotanque = $cod_tipotanque, 
                        nom_zootanque = '$nom_zootanque_escaped'
                    WHERE cod_zootanque = $cod_zootanque";

            $resultado = pg_query($this->conexion, $sql);

            if ($resultado) {
                return true;
            } else {
                error_log("Error al editar tanque: " . pg_last_error($this->conexion));
                return false;
            }
        } catch (Exception $e) {
            error_log("Error al editar tanque: " . $e->getMessage());
            return false;
        }
    }

    //Anular tanque (cambiar estado a inactivo)
    public function AnularTanque($cod_zootanque)
    {
        try {
            $sql = "UPDATE tblzootanque
                    SET cod_estado = 2
                    WHERE cod_zootanque = $cod_zootanque";

            $resultado = pg_query($this->conexion, $sql);

            if ($resultado) {
                return true;
            } else {
                error_log("Error al anular tanque: " . pg_last_error($this->conexion));
                return false;
            }
        } catch (Exception $e) {
            error_log("Error al anular tanque: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtener información de un tanque específico
     */
    public function SelectTanqueId($cod_zootanque)
    {
        try {
            $sql = "SELECT zt.cod_zootanque, zt.nom_zootanque, zt.cod_tipotanque, 
                    zt.cod_zoo, tt.nomtiptan, zt.cod_estado
                    FROM tblzootanque zt
                    LEFT JOIN tbltipotanque tt ON zt.cod_tipotanque = tt.cod_tipotanque
                    WHERE zt.cod_zootanque = $cod_zootanque";

            $result = pg_query($this->conexion, $sql);
            return $result ? pg_fetch_assoc($result) : null;
        } catch (Exception $e) {
            error_log("Error al obtener tanque: " . $e->getMessage());
            return null;
        }
    }

    //Obtener tipos de tanque disponibles
    public function SelectTiposTanque()
    {
        $sql = "SELECT cod_tipotanque, nomtiptan
                FROM tbltipotanque
                ORDER BY nomtiptan";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }
}
