<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../models/modelactividad.php';

class EncuestaCapacitacionController
{

    private $encuesta;

    public function __construct()
    {
        $this->encuesta = new EncuestaCapacitacionModel();
    }

    // Obtener encuesta de capacitación (cod_tipo_form = 4)
    public function obtenerEncuesta($cod_tipo_form)
    {

        echo json_encode([
            "success" => true,
            "data" => $this->encuesta->obtenerEncuestaCompleta($cod_tipo_form)
        ]);
    }


    // Guardar encuesta completa
    public function guardarEncuesta()
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (!$data || !isset($data['resultados'])) {
                throw new Exception('Datos incompletos');
            }

            $cod_territorio = $_GET['cod_territorio'] ?? null;

            // Crear control de actividad
            $cod_control = $this->encuesta->crearControlActividad($cod_territorio);

            // Guardar todas las respuestas
            $this->encuesta->guardarRespuestas($cod_control, $data['resultados']);

            echo json_encode([
                'success' => true,
                'message' => 'Encuesta de capacitación guardada exitosamente',
                'cod_controlactividadeco' => $cod_control
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

// Manejo de acciones
$action = $_GET['action'] ?? $_POST['action'] ?? null;

$controller = new EncuestaCapacitacionController();

switch ($action) {

    case 'obtener':
        $cod = $_GET['cod_tipo_form'] ?? null;
        $controller->obtenerEncuesta($cod);
        break;

    case 'guardar':
        $controller->guardarEncuesta();
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Acción no válida"
        ]);
}
