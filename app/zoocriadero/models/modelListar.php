<?php
include_once "../../../conexionBD/BaseDatos.php";

class modelListar
{
    private $conexion;

    public function __construct()
    {
        //Se crea la instancia de la BD
        $bd = new BaseDatos("1234");
        $this->conexion = $bd->conectar;
    }

    //Consulta SQL Zoocriadero
    public function SelectZoo()
    {
        $sql = "SELECT z.cod_zoo, z.nombre_zoo, z.direccion_zoo, 
        tp.nomtiptan, u.nombre_usu, u.apellido_usu, z.id_usuarios
        FROM tblzoocriadero z
        LEFT JOIN tbltipotanque tp ON z.cod_tipotanque = tp.cod_tipotanque
        LEFT JOIN tblusuarios u ON z.id_usuarios = u.id_usuarios
        WHERE z.cod_estado = 1
        ORDER BY z.cod_zoo DESC";


        $result = pg_query($this->conexion, $sql);

        return $result ? pg_fetch_all($result) : [];
    }

    //Consulta SQL Encargado del Zoo
    public function SelectEncargado()
    {
        $sql = "SELECT DISTINCT u.id_usuarios, u.nombre_usu, u.apellido_usu
        FROM tblusuarios u
        INNER JOIN tblzoocriadero z ON u.id_usuarios = z.id_usuarios
        ORDER BY u.nombre_usu, u.apellido_usu ";

        $result = pg_query($this->conexion, $sql);

        return $result ? pg_fetch_all($result) : [];
    }

    //Consulta SQL Tipo de Tanque
    public function SelectTiposTanque()
    {
        $sql = "SELECT DISTINCT cod_tipotanque, nomtiptan
            FROM tbltipotanque
            ORDER BY nomtiptan DESC";

        $result = pg_query($this->conexion, $sql);

        return $result ? pg_fetch_all($result) : [];
    }

    //Consulta SQL Barrios
    public function SelectBarrios()
    {
        $sql = "SELECT cod_barrio, nombarrio
        FROM tblbarrios
        ORDER BY nombarrio";

        $result = pg_query($this->conexion, $sql);

        return $result ? pg_fetch_all($result) : [];
    }

    //Insertar nuevos tanques
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
    
    //Actualizar tipo de tanque y nombre del tanque
    public function ActualizarTanque($cod_zootanque, $cod_tipotanque, $nom_zootanque)
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
                error_log("Error al actualizar tanque: " . pg_last_error($this->conexion));
                return false;
            }
        } catch (Exception $e) {
            error_log("Error al actualizar tanque: " . $e->getMessage());
            return false;
        }
    }

    
    public function EliminarTanque($cod_zootanque)
    {
        try {
            // Cambiar estado a 2 (inactivo) en lugar de eliminar
            $sql = "UPDATE tblzootanque 
                SET cod_estado = 2 
                WHERE cod_zootanque = $cod_zootanque";

            $resultado = pg_query($this->conexion, $sql);

            if ($resultado) {
                return true;
            } else {
                error_log("Error al inactivar tanque: " . pg_last_error($this->conexion));
                return false;
            }
        } catch (Exception $e) {
            error_log("Error al inactivar tanque: " . $e->getMessage());
            return false;
        }
    }
}
