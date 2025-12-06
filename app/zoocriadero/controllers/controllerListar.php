<?php
include_once "../models/modelListar.php";

class ListarZoo
{
    private $model;

    public function __construct()
    {
        $this->model = new modelListar();
    }

    public function MostrarLista()
    {
        return $this->model->SelectZoo();
    }

    public function ObtenerEncargados()
    {
        return $this->model->SelectEncargado();
    }

    public function ObtenerTiposTanque()
    {
        return $this->model->SelectTiposTanque();
    }

    public function ObtenerBarrio()
    {
        return $this->model->SelectBarrios();
    }

    public function AgregarTanque($cod_zoo, $cod_tipotanque, $nom_zootanque)
    {
        return $this->model->InsertarTanque($cod_zoo, $cod_tipotanque, $nom_zootanque);
    }

    public function ActualizarTanque($cod_zootanque, $cod_tipotanque, $nom_zootanque)
    {
        return $this->model->ActualizarTanque($cod_zootanque, $cod_tipotanque, $nom_zootanque);
    }

    public function EliminarTanque($cod_zootanque)
    {
        return $this->model->EliminarTanque($cod_zootanque);
    }
}

// ============================================================================
// MANEJO DE PETICIONES AJAX
// ============================================================================

// Solo procesar si es petición AJAX (GET con action o POST)
if (isset($_GET['action']) || $_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $listar = new ListarZoo();
    
    try {
        // Peticiones GET (AJAX)
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
            header('Content-Type: application/json');
            
            switch ($_GET['action']) {
                case 'getEncargados':
                    $resultado = $listar->ObtenerEncargados();
                    echo json_encode(['success' => true, 'data' => $resultado]);
                    exit;

                case 'getBarrios':
                    $resultado = $listar->ObtenerBarrio();
                    echo json_encode(['success' => true, 'data' => $resultado]);
                    exit;

                case 'getTiposTanque':
                    $resultado = $listar->ObtenerTiposTanque();
                    echo json_encode(['success' => true, 'data' => $resultado]);
                    exit;

                default:
                    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
                    exit;
            }
        }

        // Peticiones POST (AJAX)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            
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
                            'message' => 'Datos incompletos'
                        ]);
                        exit;
                    }

                    $resultado = $listar->AgregarTanque(
                        $data['cod_zoo'],
                        $data['cod_tipotanque'],
                        $data['nom_zootanque']
                    );

                    echo json_encode([
                        'success' => $resultado,
                        'message' => $resultado ? 'Tanque agregado correctamente' : 'Error al agregar el tanque'
                    ]);
                    exit;

                case 'actualizarTanque':
                    if (!isset($data['cod_zootanque']) || !isset($data['cod_tipotanque']) || !isset($data['nom_zootanque'])) {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Datos incompletos'
                        ]);
                        exit;
                    }

                    $resultado = $listar->ActualizarTanque(
                        $data['cod_zootanque'],
                        $data['cod_tipotanque'],
                        $data['nom_zootanque']
                    );

                    echo json_encode([
                        'success' => $resultado,
                        'message' => $resultado ? 'Tanque actualizado correctamente' : 'Error al actualizar el tanque'
                    ]);
                    exit;

                case 'eliminarTanque':
                    if (!isset($data['cod_zootanque'])) {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Código de tanque no proporcionado'
                        ]);
                        exit;
                    }

                    $resultado = $listar->EliminarTanque($data['cod_zootanque']);

                    echo json_encode([
                        'success' => $resultado,
                        'message' => $resultado ? 'Tanque inactivado correctamente' : 'Error al inactivar el tanque'
                    ]);
                    exit;

                default:
                    echo json_encode([
                        'success' => false,
                        'message' => 'Acción no válida'
                    ]);
                    exit;
            }
        }

    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
        exit;
    }
}

// ============================================================================
// CARGAR DATOS PARA LA VISTA (Solo si NO es petición AJAX)
// ============================================================================

$listar = new ListarZoo();
$zoocriaderos = $listar->MostrarLista();
$admins = $listar->ObtenerEncargados();
$tiposTanque = $listar->ObtenerTiposTanque();

?>