<?php
include_once '../../../conexionBD/BaseDatos.php';

class modelPreTest
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos("ceron123");
        $this->conexion = $bd->conectar;
    }

    // Obtener información de las preguntas del PRE-test
    public function ObtenerPreguntasPre()
    {
        $sql = "SELECT cod_pregunta, cod_tipo_form, enunciado_pregunta
        FROM tblpregunta
        WHERE cod_tipo_form = 1
        ORDER BY cod_pregunta";

        $result = pg_query($this->conexion, $sql);

        return $result;
    }

    // Obtener información de las respuestas por rango
    public function ObtenerRespuestasPre($inicio, $fin)
    {
        $sql = "SELECT cod_opcionesres, enunciado, codigo_opcion
        FROM tbloprespuesta
        WHERE cod_opcionesres BETWEEN $1 AND $2
        ORDER BY cod_opcionesres";

        $result = pg_query_params($this->conexion, $sql, array($inicio, $fin));

        return $result;
    }

    // AGREGAR ESTE MÉTODO - Obtener preguntas con sus opciones desde tblpreguntarespuesta
    public function ObtenerPreguntaRespuesta($cod_tipo_form)
    {
        $sql = "SELECT 
            p.cod_pregunta, 
            p.enunciado_pregunta, 
            p.cod_tipo_form, 
            o.cod_opcionesres,
            o.enunciado as opcion_enunciado, 
            o.codigo_opcion, 
            pr.cod_pregresp
        FROM tblpregunta p
        INNER JOIN tblpreguntarespuesta pr ON pr.cod_pregunta = p.cod_pregunta
        INNER JOIN tbloprespuesta o ON o.cod_opcionesres = pr.cod_opcionesres
        WHERE p.cod_tipo_form = $1
        ORDER BY p.cod_pregunta, o.cod_opcionesres";

        $result = pg_query_params($this->conexion, $sql, array($cod_tipo_form));

        return $result;
    }

    // Guardar respuestas en tbldatorespuesta
    public function guardarRespuestas($cod_controlactividadeco, $resultados)
    {
        pg_query($this->conexion, "BEGIN");

        try {
            foreach ($resultados as $cod_pregresp => $total) {
                if ($total > 0) {
                    // Primero verificar si existe
                    $sqlCheck = "SELECT cod_datorespuesta 
                            FROM tbldatorespuesta 
                            WHERE cod_controlactividadeco = $1 
                            AND cod_pregresp = $2";

                    $resultCheck = pg_query_params(
                        $this->conexion,
                        $sqlCheck,
                        array($cod_controlactividadeco, $cod_pregresp)
                    );

                    if (pg_num_rows($resultCheck) > 0) {
                        // UPDATE si existe
                        $sqlUpdate = "UPDATE tbldatorespuesta 
                                 SET total_respuesta = $1
                                 WHERE cod_controlactividadeco = $2 
                                 AND cod_pregresp = $3";

                        $result = pg_query_params(
                            $this->conexion,
                            $sqlUpdate,
                            array($total, $cod_controlactividadeco, $cod_pregresp)
                        );
                    } else {
                        // INSERT si no existe
                        $sqlInsert = "INSERT INTO tbldatorespuesta
                                 (cod_controlactividadeco, cod_pregresp, total_respuesta)
                                 VALUES ($1, $2, $3)";

                        $result = pg_query_params(
                            $this->conexion,
                            $sqlInsert,
                            array($cod_controlactividadeco, $cod_pregresp, $total)
                        );
                    }

                    if (!$result) {
                        throw new Exception("Error al guardar respuesta: " . pg_last_error($this->conexion));
                    }

                    pg_free_result($resultCheck);
                    if (isset($result)) {
                        pg_free_result($result);
                    }
                }
            }

            pg_query($this->conexion, "COMMIT");
            return true;
        } catch (Exception $e) {
            pg_query($this->conexion, "ROLLBACK");
            throw $e;
        }
    }
}
