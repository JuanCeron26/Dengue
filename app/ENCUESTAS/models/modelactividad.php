<?php
require_once '../../../conexionBD/BaseDatos.php';

class EncuestaCapacitacionModel
{

    private $conectar;

    public function __construct()
    {
        // Conexion correcta a PostgreSQL
        $db = new BaseDatos("ceron123");
        $this->conectar = $db->conectar;
    }

    // Obtener preguntas completas con sus opciones
    public function obtenerEncuestaCompleta($cod_tipo_form)
    {

        $query = "SELECT cod_pregunta, enunciado_pregunta
                  FROM tblpregunta
                  WHERE cod_tipo_form = $1
                  ORDER BY cod_pregunta";

        $result = pg_query_params($this->conectar, $query, array($cod_tipo_form));

        if (!$result) {
            throw new Exception("Error al obtener preguntas: " . pg_last_error($this->conectar));
        }

        $preguntas = array();

        while ($row = pg_fetch_assoc($result)) {
            $row['opciones'] = $this->obtenerOpcionesSatisfaccion($row['cod_pregunta']);

            // 🔍 DEBUG: Ver cuántas opciones se obtienen
            error_log("Pregunta {$row['cod_pregunta']}: " . count($row['opciones']) . " opciones");

            $preguntas[] = $row;
        }

        pg_free_result($result);
        return $preguntas;
    }

    // 🔧 VERSIÓN CORREGIDA: Primero intenta con filtro, si no hay resultados trae todas
    private function obtenerOpcionesSatisfaccion($cod_pregunta)
    {

        // Intento 1: Buscar opciones de satisfacción (6-10)
        $query = "SELECT pr.cod_pregresp, op.cod_opcionesres, op.enunciado, op.codigo_opcion
                  FROM tblpreguntarespuesta pr
                  INNER JOIN tbloprespuesta op ON pr.cod_opcionesres = op.cod_opcionesres
                  WHERE pr.cod_pregunta = $1
                  AND op.cod_opcionesres BETWEEN 6 AND 10
                  ORDER BY op.cod_opcionesres";

        $result = pg_query_params($this->conectar, $query, array($cod_pregunta));

        if (!$result) {
            throw new Exception("Error al obtener opciones: " . pg_last_error($this->conectar));
        }

        $opciones = array();
        while ($row = pg_fetch_assoc($result)) {
            $opciones[] = $row;
        }
        pg_free_result($result);

        // 🔧 Si no hay opciones, intenta SIN filtro
        if (empty($opciones)) {
            error_log("⚠️ No se encontraron opciones 6-10 para pregunta $cod_pregunta. Intentando sin filtro...");

            $query2 = "SELECT pr.cod_pregresp, op.cod_opcionesres, op.enunciado, op.codigo_opcion
                      FROM tblpreguntarespuesta pr
                      INNER JOIN tbloprespuesta op ON pr.cod_opcionesres = op.cod_opcionesres
                      WHERE pr.cod_pregunta = $1
                      ORDER BY op.cod_opcionesres";

            $result2 = pg_query_params($this->conectar, $query2, array($cod_pregunta));

            if ($result2) {
                while ($row = pg_fetch_assoc($result2)) {
                    $opciones[] = $row;
                    error_log("  → Opción encontrada: cod_opcionesres={$row['cod_opcionesres']}, enunciado={$row['enunciado']}");
                }
                pg_free_result($result2);
            }
        }

        return $opciones;
    }

    // Crear control actividad (sin id_usuario)
    public function crearControlActividad($cod_territorio = null)
    {

        if ($cod_territorio === null) {

            $query = "INSERT INTO tblcontrolactividad (cod_territorio)
                      VALUES (NULL)
                      RETURNING cod_controlactividadeco";

            $result = pg_query($this->conectar, $query);
        } else {

            $query = "INSERT INTO tblcontrolactividad (cod_territorio, cod_actividadeco)
                      VALUES ($1, 3)
                      RETURNING cod_controlactividadeco";

            $result = pg_query_params($this->conectar, $query, array($cod_territorio));
        }

        if (!$result) {
            throw new Exception("Error al crear control: " . pg_last_error($this->conectar));
        }

        $row = pg_fetch_assoc($result);
        pg_free_result($result);

        return $row['cod_controlactividadeco'];
    }

    // Guardar respuestas
    public function guardarRespuestas($cod_controlactividadeco, $resultados)
    {

        pg_query($this->conectar, "BEGIN");

        try {

            $query = "INSERT INTO tbldatorespuesta
                      (cod_controlactividadeco, cod_pregresp, total_respuesta)
                      VALUES ($1, $2, $3)";

            foreach ($resultados as $cod_pregresp => $total) {

                if ($total > 0) {

                    $result = pg_query_params(
                        $this->conectar,
                        $query,
                        array($cod_controlactividadeco, $cod_pregresp, $total)
                    );

                    if (!$result) {
                        throw new Exception("Error al guardar respuesta: " . pg_last_error($this->conectar));
                    }

                    pg_free_result($result);
                }
            }

            pg_query($this->conectar, "COMMIT");
            return true;
        } catch (Exception $e) {
            pg_query($this->conectar, "ROLLBACK");
            throw $e;
        }
    }
}
