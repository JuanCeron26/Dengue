<?php
include_once '../models/modelAnular.php';

class AnularSitioEco
{
    private $model;

    public function __construct()
    {
        $this->model = new modelAnular();
    }

    public function Anular()
    {
        // Validar que venga el código del sitioECO (desde FormData)
        if (!isset($_POST['cod_sitioeco']) || empty($_POST['cod_sitioeco'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Código del sitio no proporcionado'
            ]);
            exit;
        }

        $codSitioeco = $_POST['cod_sitioeco'];

        // Verificar que el sitioECO existe
        if (!$this->model->VerificarSitioEcoExiste($codSitioeco)) {
            echo json_encode([
                'success' => false,
                'message' => "El sitio no existe en la base de datos"
            ]);
            exit;
        }

        // Anular el sitioECO
        $result = $this->model->AnularSitioEco($codSitioeco);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => "El sitio fue anulado exitosamente"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "Error al anular el sitio"
            ]);
        }
        exit;
    }
}

// Configurar headers para JSON
header('Content-Type: application/json');

// Verificar que sea método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new AnularSitioEco();
    $controlador->Anular();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido. Use POST'
    ]);
}
