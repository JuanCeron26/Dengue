<?php
include_once "../models/modelTanque.php";

class ControllerTanque
{
    private $model;

    public function __construct()
    {
        $this->model = new modelTanque();
    }

    public function ObtenerTanquesPorZoo($cod_zoo)
    {
        return $this->model->SelectTanquesZoo($cod_zoo);
    }

    public function ObtenerTanquePorId($cod_zootanque)
    {
        return $this->model->SelectTanqueId($cod_zootanque);
    }

    public function AgregarTanque($cod_zoo, $cod_tipotanque, $nom_zootanque)
    {
        return $this->model->InsertarTanque($cod_zoo, $cod_tipotanque, $nom_zootanque);
    }

    public function EditarTanque($cod_zootanque, $cod_tipotanque, $nom_zootanque)
    {
        return $this->model->EditarTanque($cod_zootanque, $cod_tipotanque, $nom_zootanque);
    }

    public function AnularTanque($cod_zootanque)
    {
        return $this->model->AnularTanque($cod_zootanque);
    }

    public function ObtenerTiposTanque()
    {
        return $this->model->SelectTiposTanque();
    }
}

// ============================================================================
// MANEJO DE PETICIONES AJAX
// ============================================================================

header('Content-Type: application/json');

try {
    $controller = new ControllerTanque();

    // ========== PETICIONES GET ==========
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
        
        switch ($_GET['action']) {
            
            case 'getTanquesByZoo':
                if (!isset($_GET['cod_zoo'])) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Código de zoo no proporcionado'
                    ]);
                    exit;
                }
                
                $resultado = $controller->ObtenerTanquesPorZoo($_GET['cod_zoo']);
                echo json_encode([
                    'success' => true,
                    'data' => $resultado
                ]);
                exit;

            case 'getTanqueById':
                if (!isset($_GET['cod_zootanque'])) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Código de tanque no proporcionado'
                    ]);
                    exit;
                }
                
                $resultado = $controller->ObtenerTanquePorId($_GET['cod_zootanque']);
                
                if ($resultado) {
                    echo json_encode([
                        'success' => true,
                        'data' => $resultado
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Tanque no encontrado'
                    ]);
                }
                exit;

            case 'getTiposTanque':
                $resultado = $controller->ObtenerTiposTanque();
                echo json_encode([
                    'success' => true,
                    'data' => $resultado
                ]);
                exit;

            default:
                echo json_encode([
                    'success' => false,
                    'message' => 'Acción GET no válida'
                ]);
                exit;
        }
    }

    // ========== PETICIONES POST ==========
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!isset($data['action'])) {
            echo json_encode([
                'success' => false,
                'message' => 'No se especificó una acción'
            ]);
            exit;
        }

        switch ($data['action']) {
            
            case 'agregarTanque':
                if (!isset($data['cod_zoo']) || !isset($data['cod_tipotanque']) || !isset($data['nom_zootanque'])) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Datos incompletos para agregar tanque'
                    ]);
                    exit;
                }

                // Validar nombre
                $nombre = trim($data['nom_zootanque']);
                if (empty($nombre)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'El nombre del tanque no puede estar vacío'
                    ]);
                    exit;
                }

                // Validar caracteres inválidos
                if (preg_match('/[<>\/;]/', $nombre)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'El nombre contiene caracteres inválidos (<, >, /, ;)'
                    ]);
                    exit;
                }

                $resultado = $controller->AgregarTanque(
                    $data['cod_zoo'],
                    $data['cod_tipotanque'],
                    $nombre
                );

                echo json_encode([
                    'success' => $resultado,
                    'message' => $resultado ? 'Tanque agregado correctamente' : 'Error al agregar el tanque'
                ]);
                exit;

            case 'editarTanque':
                if (!isset($data['cod_zootanque']) || !isset($data['cod_tipotanque']) || !isset($data['nom_zootanque'])) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Datos incompletos para editar tanque'
                    ]);
                    exit;
                }

                // Validar nombre
                $nombre = trim($data['nom_zootanque']);
                if (empty($nombre)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'El nombre del tanque no puede estar vacío'
                    ]);
                    exit;
                }

                // Validar caracteres inválidos
                if (preg_match('/[<>\/;]/', $nombre)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'El nombre contiene caracteres inválidos (<, >, /, ;)'
                    ]);
                    exit;
                }

                $resultado = $controller->EditarTanque(
                    $data['cod_zootanque'],
                    $data['cod_tipotanque'],
                    $nombre
                );

                echo json_encode([
                    'success' => $resultado,
                    'message' => $resultado ? 'Tanque editado correctamente' : 'Error al editar el tanque'
                ]);
                exit;

            case 'anularTanque':
                if (!isset($data['cod_zootanque'])) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Código de tanque no proporcionado'
                    ]);
                    exit;
                }

                $resultado = $controller->AnularTanque($data['cod_zootanque']);

                echo json_encode([
                    'success' => $resultado,
                    'message' => $resultado ? 'Tanque anulado correctamente' : 'Error al anular el tanque'
                ]);
                exit;

            default:
                echo json_encode([
                    'success' => false,
                    'message' => 'Acción POST no válida'
                ]);
                exit;
        }
    }

    // Si no es GET ni POST
    echo json_encode([
        'success' => false,
        'message' => 'Método de petición no válido'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
}
?>