<?php
include_once "../models/modelAnular.php";

class AnularZoo
{
    private $model;

    public function __construct()
    {
        $this->model = new modelAnular();
    }

    public function Anular()
    {
        // Leer datos JSON del body
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Validar que venga el código del zoocriadero
        if (!isset($data['cod_zoo']) || empty($data['cod_zoo'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Código de zoocriadero no proporcionado'
            ]);
            return;
        }

        $codZoo = (int)$data['cod_zoo'];

        // Verificar que exista
        if (!$this->model->VerificarZooExiste($codZoo)) {
            echo json_encode([
                'success' => false,
                'message' => 'El zoocriadero no existe'
            ]);
            return;
        }

        // Anular el zoocriadero
        $result = $this->model->AnularZoo($codZoo);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Zoocriadero anulado correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al anular el zoocriadero'
            ]);
        }
    }
}

// Configurar headers para JSON
header('Content-Type: application/json');

// Verificar que sea método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new AnularZoo();
    $controlador->Anular();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No fue permitido hacer la acción. intente nuevamente'
    ]);
}
?>