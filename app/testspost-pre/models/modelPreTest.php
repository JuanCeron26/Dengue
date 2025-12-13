<?php 
include_once '../../../conexionBD/BaseDatos.php';

class modelPreTest
{
    private $conexion;

    public function __construct()
    {
        $bd = new BaseDatos("1234");
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

    
}
?>