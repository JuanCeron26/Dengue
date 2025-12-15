<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../models/EncuestaModel.php';

class EncuestaController
{

    private $encuesta;

    public function __construct()
    {
        $this->encuesta = new EncuestaModel();
    }

    // Obtener encuesta
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

            $cod_territorio = $data['cod_territorio'] ?? null;

            $cod_control = $this->encuesta->crearControlActividad($cod_territorio);

            $this->encuesta->guardarRespuestas($cod_control, $data['resultados']);

            echo json_encode([
                'success' => true,
                'message' => 'Encuesta guardada exitosamente',
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

$action = $_GET['action'] ?? $_POST['action'] ?? null;

$controller = new EncuestaController();

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
