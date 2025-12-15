<?php


class BaseDatos
{
    private $user;
    private $password;
    private $dbname;
    private $host;
    private $port;
    public $conectar;

    public function __construct($contra = "")
    {
        $this->user = 'postgres';
        $this->password = $contra;
        $this->dbname = 'bd_dengue_ceron';
        $this->port = '5432';
        $this->host = 'localhost';

        $cadena = "host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->password";
        $this->conectar = pg_connect($cadena);

        if (!$this->conectar) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => '❌ Error al conectar a la base de datos']);
            exit;
        }
    }


    // LISTAR RESPONSABLES
    public function listarResponsables()
    {
        try {
            $sql = "SELECT 
                    id_responsable,
                    nombre_responsable,
                    apellido_responsable,
                    cedula,
                    celular
                FROM tblresponsablesitio
                ORDER BY nombre_responsable ASC";

            $result = pg_query($this->conectar, $sql);

            if (!$result) {
                throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
            }

            $responsables = [];
            while ($row = pg_fetch_assoc($result)) {
                $responsables[] = $row;
            }

            return $responsables;
        } catch (Exception $e) {
            error_log("Error en listarResponsables(): " . $e->getMessage());
            return [];
        }
    }




    // Verificar si un sitio ya existe por nombre
    public function verificarSitioExistePorNombre($nombre_sitio)
    {
        try {
            $sql = "SELECT cod_sitiocontrolbiolo, nombre_sitio, direccion_sitio 
                FROM tblsitiocontrolbiologico 
                WHERE LOWER(TRIM(nombre_sitio)) = LOWER(TRIM($1))";

            $result = pg_query_params($this->conectar, $sql, [$nombre_sitio]);

            if (!$result) {
                throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
            }

            $sitio = pg_fetch_assoc($result);
            return $sitio ? $sitio : null;
        } catch (Exception $e) {
            error_log("Error en verificarSitioExistePorNombre(): " . $e->getMessage());
            return null;
        }
    }



    // Verificar si un sitio ya existe por dirección
    public function verificarSitioExistePorDireccion($direccion_sitio)
    {
        try {
            $sql = "SELECT cod_sitiocontrolbiolo, nombre_sitio, direccion_sitio 
                FROM tblsitiocontrolbiologico 
                WHERE LOWER(TRIM(direccion_sitio)) = LOWER(TRIM($1))";

            $result = pg_query_params($this->conectar, $sql, [$direccion_sitio]);

            if (!$result) {
                throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
            }

            $sitio = pg_fetch_assoc($result);
            return $sitio ? $sitio : null;
        } catch (Exception $e) {
            error_log("Error en verificarSitioExistePorDireccion(): " . $e->getMessage());
            return null;
        }
    }



    // INSERT GENERICO
    public function Insert($tabla, $datos)
    {
        $campos = array_keys($datos);
        $valores = array_values($datos);

        $placeholders = [];
        for ($i = 1; $i <= count($datos); $i++) {
            $placeholders[] = '$' . $i;
        }

        $sql = "INSERT INTO $tabla (" . implode(",", $campos) . ")
                VALUES (" . implode(",", $placeholders) . ")
                RETURNING *";

        $result = pg_query_params($this->conectar, $sql, $valores);

        return $result ? pg_fetch_assoc($result) : false;
    }

    // UPDATE GENERICO
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

        $valores[] = $valor_id;

        $sql = "UPDATE $tabla SET " . implode(", ", $set) . " 
                WHERE $campo_id = $" . $i;

        $result = pg_query_params($this->conectar, $sql, $valores);

        if (!$result) {
            error_log("Error en UPDATE: " . pg_last_error($this->conectar));
            return false;
        }

        return true;
    }

    // DELETE GENERICO
    public function Delete($tabla, $datos)
    {
        $campo = key($datos);
        $valor = $datos[$campo];

        $sql = "DELETE FROM $tabla WHERE $campo = $1";

        return pg_query_params($this->conectar, $sql, [$valor]) ? true : false;
    }

    // SELECT GENERICO
    public function Select($sql, $params = [])
    {
        $result = pg_query_params($this->conectar, $sql, $params);
        return $result ? pg_fetch_all($result) : false;
    }

    // LISTAR SITIOS
    public function listarSitios()
    {
        try {
            $sql = "SELECT 
                        s.cod_sitiocontrolbiolo,
                        s.nombre_sitio,
                        s.direccion_sitio,
                        b.nombarrio,
                        r.nombre_responsable
                    FROM tblsitiocontrolbiologico s
                    INNER JOIN tblbarrios b ON b.cod_barrio = s.cod_barrio
                    INNER JOIN tblresponsablesitio r ON r.id_responsable = s.id_responsable
                    ORDER BY s.cod_sitiocontrolbiolo DESC";

            $result = pg_query($this->conectar, $sql);

            if (!$result) {
                throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
            }

            $sitios = [];
            while ($row = pg_fetch_assoc($result)) {
                $sitios[] = $row;
            }

            return $sitios;
        } catch (Exception $e) {
            error_log("Error en listarSitios(): " . $e->getMessage());
            return [];
        }
    }

    // OBTENER DETALLE DE UN SITIO
    public function obtenerDetalleSitio($id)
    {
        try {
            $sql = "SELECT 
                        s.cod_sitiocontrolbiolo,
                        s.cod_barrio,
                        s.id_responsable,
                        s.nombre_sitio,
                        s.direccion_sitio,
                        b.nombarrio,
                        r.nombre_responsable,
                        r.apellido_responsable,
                        r.cedula,
                        r.celular
                    FROM tblsitiocontrolbiologico s
                    INNER JOIN tblbarrios b ON b.cod_barrio = s.cod_barrio
                    INNER JOIN tblresponsablesitio r ON r.id_responsable = s.id_responsable
                    WHERE s.cod_sitiocontrolbiolo = $1";

            $result = pg_query_params($this->conectar, $sql, [$id]);

            if (!$result) {
                throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
            }

            return pg_fetch_all($result);
        } catch (Exception $e) {
            error_log("Error en obtenerDetalleSitio(): " . $e->getMessage());
            return [];
        }
    }



    // VERIFICAR SI RESPONSABLE EXISTE POR CÉDULA
    public function verificarResponsableExiste($cedula)
    {
        try {
            $sql = "SELECT 
                    id_responsable,
                    nombre_responsable,
                    apellido_responsable,
                    cedula,
                    celular
                FROM tblresponsablesitio 
                WHERE cedula = $1";

            $result = pg_query_params($this->conectar, $sql, [$cedula]);

            if (!$result) {
                throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
            }

            $responsable = pg_fetch_assoc($result);
            return $responsable ? $responsable : null;
        } catch (Exception $e) {
            error_log("Error en verificarResponsableExiste(): " . $e->getMessage());
            return null;
        }
    }

    // OBTENER ID DE RESPONSABLE POR CÉDULA
    public function obtenerIdResponsablePorCedula($cedula)
    {
        try {
            $sql = "SELECT id_responsable FROM tblresponsablesitio WHERE cedula = $1";

            $result = pg_query_params($this->conectar, $sql, [$cedula]);

            if (!$result) {
                throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
            }

            $responsable = pg_fetch_assoc($result);
            return $responsable ? $responsable['id_responsable'] : null;
        } catch (Exception $e) {
            error_log("Error en obtenerIdResponsablePorCedula(): " . $e->getMessage());
            return null;
        }
    }

    // VERIFICAR SI RESPONSABLE YA ESTÁ ASOCIADO A UN SITIO
    public function verificarAsociacionResponsable($id_responsable, $cod_barrio)
    {
        try {
            $sql = "SELECT cod_sitiocontrolbiolo 
                FROM tblsitiocontrolbiologico 
                WHERE id_responsable = $1 AND cod_barrio = $2";

            $result = pg_query_params($this->conectar, $sql, [$id_responsable, $cod_barrio]);

            if (!$result) {
                throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
            }

            return pg_num_rows($result) > 0;
        } catch (Exception $e) {
            error_log("Error en verificarAsociacionResponsable(): " . $e->getMessage());
            return false;
        }
    }







    public function getAllSitiosWithFilters($filters = [])
    {
        $sql = "SELECT 
                s.cod_sitiocontrolbiolo,
                s.nombre_sitio,
                s.direccion_sitio,
                b.nombarrio,
                r.nombre_responsable,
                r.apellido_responsable
            FROM tblsitiocontrolbiologico s
            INNER JOIN tblbarrios b ON b.cod_barrio = s.cod_barrio
            INNER JOIN tblresponsablesitio r ON r.id_responsable = s.id_responsable
            WHERE 1=1";

        $params = [];
        $i = 1;

        if (!empty($filters['f_sitio']) || !empty($filters['sitio'])) {
            $sql .= " AND s.nombre_sitio ILIKE $" . $i++;
            $params[] = '%' . ($filters['f_sitio'] ?? $filters['sitio']) . '%';
        }

        if (!empty($filters['f_barrio']) || !empty($filters['barrio'])) {
            $sql .= " AND b.nombarrio ILIKE $" . $i++;
            $params[] = '%' . ($filters['f_barrio'] ?? $filters['barrio']) . '%';
        }

        if (!empty($filters['f_nombre']) || !empty($filters['nombre'])) {
            $nombreBuscar = $filters['f_nombre'] ?? $filters['nombre'];
            $sql .= " AND (r.nombre_responsable ILIKE $" . $i . " OR r.apellido_responsable ILIKE $" . ($i + 1) . ")";
            $params[] = '%' . $nombreBuscar . '%';
            $params[] = '%' . $nombreBuscar . '%';
            $i += 2;
        }

        $sql .= " ORDER BY s.cod_sitiocontrolbiolo DESC";

        return $this->Select($sql, $params) ?: [];
    }
}
