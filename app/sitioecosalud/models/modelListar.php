<?php
include_once '../../../conexionBD/BaseDatos.php';

class modelListar
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos('ceron123');
        $this->conexion = $bd->conectar;
    }

    // Listar todos los sitios ACTIVOS de ECOSalud con filtros opcionales
    public function ListarSitioEco($filtros = [])
    {
        $sql = "SELECT s.cod_sitioeco, s.nombre_sitio, s.direccion, s.cod_barrio,
                b.nombarrio, c.nomcomun, c.cod_comun
                FROM tblsitioecosalud s
                LEFT JOIN tblbarrios b ON s.cod_barrio = b.cod_barrio
                INNER JOIN tblcomuna c ON b.cod_comun = c.cod_comun
                WHERE s.cod_estadositioeco = 1"; // Solo sitios activos

        $params = [];
        $paramCount = 1;

        // Filtro por comuna
        if (!empty($filtros['comuna'])) {
            $sql .= " AND c.cod_comun = $" . $paramCount;
            $params[] = $filtros['comuna'];
            $paramCount++;
        }

        // Filtro por barrio
        if (!empty($filtros['barrio'])) {
            $sql .= " AND b.cod_barrio = $" . $paramCount;
            $params[] = $filtros['barrio'];
            $paramCount++;
        }

        $sql .= " ORDER BY s.nombre_sitio ASC";

        if (empty($params)) {
            $result = pg_query($this->conexion, $sql);
        } else {
            $result = pg_query_params($this->conexion, $sql, $params);
        }

        return $result ? pg_fetch_all($result) : [];
    }

    // Obtener lista de Barrios 
    public function SelectBarrios()
    {
        $sql = "SELECT cod_barrio, nombarrio
                FROM tblbarrios
                ORDER BY nombarrio";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }

    // Obtener lista de Comunas
    public function SelectComunas()
    {
        $sql = "SELECT cod_comun, nomcomun
                FROM tblcomuna
                ORDER BY nomcomun ASC";

        $result = pg_query($this->conexion, $sql);
        return $result ? pg_fetch_all($result) : [];
    }
}
