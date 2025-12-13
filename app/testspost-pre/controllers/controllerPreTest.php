<?php 
include_once '../models/modelPreTest.php';

class PreTest
{
    private $model;
    
    // Configuración de rangos de respuestas por pregunta
    // Ajusta estos valores según tus necesidades
    private $rangosRespuestas = [
        1 => ['inicio' => 1, 'fin' => 5],   // Pregunta 1: opciones 1-5 (A-E)
        2 => ['inicio' => 6, 'fin' => 11],  // Pregunta 2: opciones 6-11 (A-F)
    ];

    public function __construct()
    {
        $this->model = new modelPreTest();
    }

    // Obtener preguntas con sus opciones específicas
    public function obtenerPreguntasConOpciones()
    {
        $preguntas = [];
        
        // Obtener preguntas
        $resultPreguntas = $this->model->ObtenerPreguntasPre();
        
        if ($resultPreguntas) {
            while ($pregunta = pg_fetch_assoc($resultPreguntas)) {
                $codPregunta = $pregunta['cod_pregunta'];
                
                // Obtener solo las opciones correspondientes a esta pregunta
                if (isset($this->rangosRespuestas[$codPregunta])) {
                    $rango = $this->rangosRespuestas[$codPregunta];
                    $resultOpciones = $this->model->ObtenerRespuestasPre(
                        $rango['inicio'], 
                        $rango['fin']
                    );
                    
                    $opciones = [];
                    if ($resultOpciones) {
                        while ($opcion = pg_fetch_assoc($resultOpciones)) {
                            $opciones[] = $opcion;
                        }
                    }
                    
                    $pregunta['opciones'] = $opciones;
                } else {
                    // Si no hay rango configurado, asignar array vacío
                    $pregunta['opciones'] = [];
                }
                
                $preguntas[] = $pregunta;
            }
        }
        
        return $preguntas;
    }
    
    // Método para agregar o modificar rangos dinámicamente
    public function configurarRango($codPregunta, $inicio, $fin)
    {
        $this->rangosRespuestas[$codPregunta] = [
            'inicio' => $inicio,
            'fin' => $fin
        ];
    }
}
?>