<?php
include_once "../models/modelEditar.php";

class EditarZoo
{
    private $model;

    public function __construct()
    {
        $this->model = new modelEditar();
    }

    //  Obtener información del zoo para cargar en el modal
    public function ObtenerInfoZoo($codZoo)
    {
        $zoocriadero = $this->model->ObtenerZoo($codZoo);
        $tanques = $this->model->ObtenerTanquesZoo($codZoo);

        if ($zoocriadero) {
            echo json_encode([
                'success' => true,
                'zoo' => [
                    'cod_zoo' => $zoocriadero['cod_zoo'],
                    'nombre_zoo' => $zoocriadero['nombre_zoo'],
                    'direccion_zoo' => $zoocriadero['direccion_zoo'],
                    'cod_barrio' => $zoocriadero['cod_barrio'],
                    'encargado' => $zoocriadero['nombre_usu'] . ' ' . $zoocriadero['apellido_usu'],
                    'id_usuarios' => $zoocriadero['id_usuarios'],
                    'nombarrio' => $zoocriadero['nombarrio']
                ],
                'tanques' => $tanques
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Zoocriadero no encontrado'
            ]);
        }
    }

    // Actualizar información del zoo
    public function ActualizarZoo()
    {
        // Leer datos JSON del body
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);

        // Validar datos recibidos
        if (!isset($datos['cod_zoo']) || empty($datos['cod_zoo'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Código de zoocriadero no proporcionado'
            ]);
            return;
        }

        $codZoo = $datos['cod_zoo'];

        // Verificar que exista
        if (!$this->model->VerificarZooExiste($codZoo)) {
            echo json_encode([
                'success' => false,
                'message' => 'El zoocriadero no existe'
            ]);
            return;
        }

        // Validar campos requeridos
        if (empty($datos['nombre_zoo']) || empty($datos['direccion_zoo'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Todos los campos son obligatorios'
            ]);
            return;
        }

        // Actualizar el zoocriadero
        $datosActualizar = [
            'nombre_zoo' => $datos['nombre_zoo'],
            'direccion_zoo' => $datos['direccion_zoo'],
            'cod_barrio' => $datos['cod_barrio'],
            'id_usuarios' => $datos['id_usuarios']
        ];

        $result = $this->model->EditarZoo($codZoo, $datosActualizar);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Zoocriadero actualizado correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar el zoocriadero'
            ]);
        }
    }
}

// Manejar peticiones GET (obtener info) y POST (actualizar)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cod_zoo'])) {
    // Obtener información del zoo
    $controlador = new EditarZoo();
    $controlador->ObtenerInfoZoo($_GET['cod_zoo']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualizar zoo
    $controlador = new EditarZoo();
    $controlador->ActualizarZoo();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
}
