<?php
require_once '../../../conexionBD/BaseDatos.php';

class EncuestaModel
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
            $preguntas[] = $row;
        }

        pg_free_result($result);
        return $preguntas;
    }

    // Opciones 6 a 10 de satisfacción
    private function obtenerOpcionesSatisfaccion($cod_pregunta)
    {

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

            $query = "INSERT INTO tblcontrolactividad (cod_territorio)
                      VALUES ($1)
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
