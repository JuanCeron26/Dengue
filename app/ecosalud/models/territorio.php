<?php
require_once '../../../conexionBD/BaseDatos.php';

class TerritorioModel
{

    private $conectar;

    public function __construct()
    {
        // Conexión a la base de datos
        $db = new BaseDatos("ceron123");
        $this->conectar = $db->conectar;
    }

    /* ============================================================
       LISTAR TERRITORIOS (VISTA PRINCIPAL)
    ============================================================ */
    public function listarTerritorios()
    {
        $sql = "SELECT 
                    l.id_lider,
                    l.nombre_lider,
                    l.apellido_lider,
                    l.correo_lider,
                    l.celular,
                    l.id_cedula,
                    l.clase_liderazgo,
                    t.cod_territorio,
                    t.fecha_registro,
                    s.cod_sitioeco,
                    s.nombre_sitio,
                    b.nombarrio,
                    c.nomcomun
                FROM tbllider l
                INNER JOIN tblterritoriopriorizado t ON l.id_lider = t.id_lider
                LEFT JOIN tblsitioecosalud s ON t.cod_sitioeco = s.cod_sitioeco
                LEFT JOIN tblbarrios b ON s.cod_barrio = b.cod_barrio
                LEFT JOIN tblcomuna c ON b.cod_comun = c.cod_comun
           ORDER BY t.fecha_registro DESC";

        return $this->Select($sql);
    }

    /* ============================================================
       DETALLE DE UN TERRITORIO
    ============================================================ */
    public function detalleTerritorio($cod_territorio)
    {
        error_log("🔍 Buscando territorio: " . $cod_territorio);

        $sql = "SELECT 
                tp.cod_territorio,
                tp.id_lider,
                tp.cod_sitioeco,
                tp.fecha_registro,
                l.nombre_lider,
                l.apellido_lider,
                l.correo_lider,
                l.celular,
                l.id_cedula,
                l.clase_liderazgo,
                s.nombre_sitio,
                s.direccion AS direccion_sitio,
                b.nombarrio,
                b.cod_barrio,
                c.nomcomun,
                c.cod_comun
            FROM tblterritoriopriorizado tp
            INNER JOIN tbllider l ON l.id_lider = tp.id_lider
            INNER JOIN tblsitioecosalud s ON s.cod_sitioeco = tp.cod_sitioeco
            LEFT JOIN tblbarrios b ON b.cod_barrio = s.cod_barrio
            LEFT JOIN tblcomuna c ON c.cod_comun = b.cod_comun
            WHERE tp.cod_territorio = $1
            LIMIT 1
        ";

        $result = $this->Select($sql, [$cod_territorio]);
        error_log("📦 Resultado: " . print_r($result, true));

        return $result ? $result[0] : false;
    }

    /* ============================================================
       VERIFICAR SI UN TERRITORIO TIENE PARTICIPANTES
    ============================================================ */
    public function verificarParticipantesTerritorio($cod_territorio)
    {
        $sql = "SELECT 1 FROM tblterprioparticipantes 
                WHERE cod_territorio = $1 
                LIMIT 1";

        $result = $this->Select($sql, [$cod_territorio]);
        return !empty($result);
    }

    /* ============================================================
       LISTAR SITIOS ECOSALUD
    ============================================================ */
    public function listarSitiosEcosalud()
    {
        $sql = "SELECT 
                s.cod_sitioeco,
                s.nombre_sitio,
                s.direccion,
                b.nombarrio,
                c.nomcomun
            FROM tblsitioecosalud s
            LEFT JOIN tblbarrios b ON b.cod_barrio = s.cod_barrio
            LEFT JOIN tblcomuna c ON c.cod_comun = b.cod_comun
            ORDER BY s.nombre_sitio ASC";

        return $this->Select($sql);
    }

    /* ============================================================
       LISTAR LÍDERES
    ============================================================ */
    public function listarLideres()
    {
        $sql = "SELECT 
                    id_lider, 
                    nombre_lider, 
                    apellido_lider, 
                    correo_lider,
                    id_cedula
                FROM tbllider 
                ORDER BY nombre_lider ASC";

        return $this->Select($sql);
    }

    /* ============================================================
       VERIFICAR SI LÍDER YA EXISTE
    ============================================================ */
    public function verificarLiderExiste($nombre, $apellido)
    {
        $sql = "SELECT 
                id_lider,
                nombre_lider,
                apellido_lider,
                correo_lider,
                celular,
                id_cedula,
                clase_liderazgo
            FROM tbllider 
            WHERE LOWER(TRIM(nombre_lider)) = LOWER(TRIM($1))
            AND LOWER(TRIM(apellido_lider)) = LOWER(TRIM($2))
            LIMIT 1
        ";

        $result = $this->Select($sql, [$nombre, $apellido]);
        return $result ? $result[0] : false;
    }

    /* ============================================================
       VERIFICAR SI CÉDULA YA EXISTE
    ============================================================ */
    public function verificarCedulaExiste($cedula)
    {
        $sql = "SELECT 
                id_lider,
                nombre_lider,
                apellido_lider,
                id_cedula
            FROM tbllider 
            WHERE id_cedula = $1
            LIMIT 1
        ";

        $result = $this->Select($sql, [$cedula]);
        return $result ? $result[0] : false;
    }

    /* ============================================================
       VERIFICAR ASOCIACIÓN LÍDER – TERRITORIO
    ============================================================ */
    public function verificarAsociacion($id_lider, $cod_sitioeco)
    {
        $sql = "SELECT cod_territorio 
                FROM tblterritoriopriorizado 
                WHERE id_lider = $1 
                AND cod_sitioeco = $2 
                LIMIT 1";

        $result = $this->Select($sql, [$id_lider, $cod_sitioeco]);
        return !empty($result);
    }

    /* ============================================================
       MÉTODOS CRUD GENÉRICOS
    ============================================================ */

    public function Select($sql, $params = [])
    {
        $result = pg_query_params($this->conectar, $sql, $params);

        if (!$result) {
            error_log("Error SELECT: " . pg_last_error($this->conectar));
            return false;
        }

        return pg_fetch_all($result);
    }

    public function Insert($tabla, $datos)
    {
        $campos = array_keys($datos);
        $valores = array_values($datos);

        // placeholders: $1, $2, $3...
        $placeholders = [];
        for ($i = 1; $i <= count($datos); $i++) {
            $placeholders[] = '$' . $i;
        }

        $sql = "INSERT INTO $tabla (" . implode(",", $campos) . ")
                VALUES (" . implode(",", $placeholders) . ")
                RETURNING *";

        $result = pg_query_params($this->conectar, $sql, $valores);

        if (!$result) {
            error_log("Error INSERT: " . pg_last_error($this->conectar));
            return false;
        }

        return pg_fetch_assoc($result);
    }

    public function Update($tabla, $datos, $id)
    {
        $campo_id = key($id);
        $valor_id = $id[$campo_id];

        $set = [];
        $valores = [];
        $i = 1;

        foreach ($datos as $campo => $valor) {
            $set[] = "$campo = $$i";
            $valores[] = $valor;
            $i++;
        }

        // Agregar ID al final
        $valores[] = $valor_id;

        $sql = "UPDATE $tabla 
                SET " . implode(", ", $set) . " 
                WHERE $campo_id = $$i";

        $result = pg_query_params($this->conectar, $sql, $valores);

        if (!$result) {
            error_log("Error UPDATE: " . pg_last_error($this->conectar));
            return false;
        }

        return true;
    }

    public function Delete($tabla, $datos)
    {
        $campo = key($datos);
        $valor = $datos[$campo];

        $sql = "DELETE FROM $tabla WHERE $campo = $1";

        return pg_query_params($this->conectar, $sql, [$valor]) ? true : false;
    }





    /* ============================================================
   MÉTODOS PARA FILTROS
============================================================ */

    // Obtener todas las comunas únicas
    public function obtenerComunas()
    {
        $sql = "SELECT DISTINCT c.cod_comun, c.nomcomun
            FROM tblcomuna c
            INNER JOIN tblbarrios b ON b.cod_comun = c.cod_comun
            INNER JOIN tblsitioecosalud s ON s.cod_barrio = b.cod_barrio
            INNER JOIN tblterritoriopriorizado t ON t.cod_sitioeco = s.cod_sitioeco
            ORDER BY c.nomcomun ASC";

        return $this->Select($sql);
    }

    // Obtener todos los barrios únicos (opcionalmente filtrados por comuna)
    public function obtenerBarrios($cod_comun = null)
    {
        $sql = "SELECT DISTINCT b.cod_barrio, b.nombarrio, c.nomcomun
            FROM tblbarrios b
            INNER JOIN tblcomuna c ON c.cod_comun = b.cod_comun
            INNER JOIN tblsitioecosalud s ON s.cod_barrio = b.cod_barrio
            INNER JOIN tblterritoriopriorizado t ON t.cod_sitioeco = s.cod_sitioeco";

        $params = [];

        if ($cod_comun) {
            $sql .= " WHERE b.cod_comun = $1";
            $params[] = $cod_comun;
        }

        $sql .= " ORDER BY b.nombarrio ASC";

        return $this->Select($sql, $params);
    }

    // Obtener todos los nombres de líderes únicos
    public function obtenerNombresLideres()
    {
        $sql = "SELECT DISTINCT l.id_lider, 
                   l.nombre_lider, 
                   l.apellido_lider,
                   CONCAT(l.nombre_lider, ' ', l.apellido_lider) as nombre_completo
            FROM tbllider l
            INNER JOIN tblterritoriopriorizado t ON t.id_lider = l.id_lider
            ORDER BY l.nombre_lider ASC, l.apellido_lider ASC";

        return $this->Select($sql);
    }

    // Obtener todos los tipos de liderazgo únicos
    public function obtenerTiposLiderazgo()
    {
        $sql = "SELECT DISTINCT l.clase_liderazgo
            FROM tbllider l
            INNER JOIN tblterritoriopriorizado t ON t.id_lider = l.id_lider
            WHERE l.clase_liderazgo IS NOT NULL 
            AND l.clase_liderazgo != ''
            ORDER BY l.clase_liderazgo ASC";

        return $this->Select($sql);
    }

    // Listar territorios con filtros aplicados
    public function listarTerritoriosFiltrados($filtros = [])
    {
        $sql = "SELECT 
                l.id_lider,
                l.nombre_lider,
                l.apellido_lider,
                l.correo_lider,
                l.celular,
                l.id_cedula,
                l.clase_liderazgo,
                t.cod_territorio,
                t.fecha_registro,
                s.cod_sitioeco,
                s.nombre_sitio,
                b.nombarrio,
                b.cod_barrio,
                c.nomcomun,
                c.cod_comun
            FROM tbllider l
            INNER JOIN tblterritoriopriorizado t ON l.id_lider = t.id_lider
            LEFT JOIN tblsitioecosalud s ON t.cod_sitioeco = s.cod_sitioeco
            LEFT JOIN tblbarrios b ON s.cod_barrio = b.cod_barrio
            LEFT JOIN tblcomuna c ON b.cod_comun = c.cod_comun
            WHERE 1=1";

        $params = [];
        $paramIndex = 1;

        // Filtro por comuna
        if (!empty($filtros['comuna'])) {
            $sql .= " AND c.cod_comun = $" . $paramIndex;
            $params[] = $filtros['comuna'];
            $paramIndex++;
        }

        // Filtro por barrio
        if (!empty($filtros['barrio'])) {
            $sql .= " AND b.cod_barrio = $" . $paramIndex;
            $params[] = $filtros['barrio'];
            $paramIndex++;
        }

        // Filtro por nombre de líder
        if (!empty($filtros['nombre'])) {
            $sql .= " AND l.id_lider = $" . $paramIndex;
            $params[] = $filtros['nombre'];
            $paramIndex++;
        }

        // Filtro por tipo de liderazgo
        if (!empty($filtros['liderazgo'])) {
            $sql .= " AND LOWER(TRIM(l.clase_liderazgo)) = LOWER(TRIM($" . $paramIndex . "))";
            $params[] = $filtros['liderazgo'];
            $paramIndex++;
        }

        // Filtro por fecha
        if (!empty($filtros['fecha'])) {
            $sql .= " AND DATE(t.fecha_registro) = $" . $paramIndex;
            $params[] = $filtros['fecha'];
            $paramIndex++;
        }

        $sql .= " ORDER BY t.fecha_registro DESC";

        return $this->Select($sql, $params);
    }
}
