<?php
include_once '../models/modelPreTest.php';

class PreTest
{
    private $model;

    // Configuración de rangos de respuestas por pregunta
    private $rangosRespuestas = [
        1 => ['inicio' => 1, 'fin' => 5],   // Pregunta 1: opciones 1-5 (A-E)
        2 => ['inicio' => 6, 'fin' => 11],  // Pregunta 2: opciones 6-11 (A-F)
    ];

    public function __construct()
    {
        $this->model = new modelPreTest();
    }

    // Obtener preguntas con sus opciones específicas Y cod_pregresp
    public function obtenerPreguntasConOpciones()
    {
        $preguntas = [];

        // Usar el método que trae cod_pregresp
        $resultPreguntas = $this->model->ObtenerPreguntaRespuesta(1); // 1 = Pre-Test

        if ($resultPreguntas) {
            while ($row = pg_fetch_assoc($resultPreguntas)) {
                $codPregunta = $row['cod_pregunta'];

                // Si la pregunta no existe en el array, crearla
                if (!isset($preguntas[$codPregunta])) {
                    $preguntas[$codPregunta] = [
                        'cod_pregunta' => $row['cod_pregunta'],
                        'enunciado_pregunta' => $row['enunciado_pregunta'],
                        'cod_tipo_form' => $row['cod_tipo_form'],
                        'opciones' => []
                    ];
                }

                // Agregar la opción a la pregunta con cod_pregresp
                $preguntas[$codPregunta]['opciones'][] = [
                    'cod_opcionesres' => $row['cod_opcionesres'],
                    'codigo_opcion' => $row['codigo_opcion'],
                    'enunciado' => $row['opcion_enunciado'],
                    'cod_pregresp' => $row['cod_pregresp']  // IMPORTANTE: necesario para guardar
                ];
            }
        }

        // Convertir array asociativo a indexado
        return array_values($preguntas);
    }

    // Guardar respuestas procesadas
    public function guardarRespuestas($cod_controlactividadeco, $datosFormulario)
    {
        // Procesar datos del formulario para extraer cod_pregresp y totales
        $resultados = [];

        foreach ($datosFormulario as $key => $valor) {
            // Buscar pares key-valor donde key sea el contador y exista su cod_pregresp
            if (strpos($key, 'q') === 0 && isset($datosFormulario['pregresp_' . $key])) {
                $cod_pregresp = $datosFormulario['pregresp_' . $key];
                $total = intval($valor);

                if ($total > 0) {
                    $resultados[$cod_pregresp] = $total;
                }
            }
        }

        return $this->model->guardarRespuestas($cod_controlactividadeco, $resultados);
    }

    public function procesarFormulario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cod_controlactividadeco = $_POST['cod_controlactividadeco'] ?? null;

            if (!$cod_controlactividadeco) {
                return ['success' => false, 'mensaje' => 'No se especificó la actividad'];
            }

            try {
                $resultado = $this->guardarRespuestas($cod_controlactividadeco, $_POST);

                if ($resultado) {
                    return ['success' => true, 'mensaje' => 'Respuestas guardadas exitosamente'];
                } else {
                    return ['success' => false, 'mensaje' => 'Error al guardar'];
                }
            } catch (Exception $e) {
                return ['success' => false, 'mensaje' => $e->getMessage()];
            }
        }

        return null;
    }
}
