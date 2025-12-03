<?php
include_once "../models/modelEditar.php";

class EditarZoo
{
    private $model;

    public function __construct()
    {
        $this->model = new modelEditar();
    }

    public function ObtenerInfoZoo($codZoo)
    {
        try {
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
                    'tanques' => $tanques ?: []
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Zoocriadero no encontrado'
                ], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener información: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    public function ActualizarZoo()
    {
        try {
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error en el formato JSON recibido'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            if (!isset($datos['cod_zoo']) || empty($datos['cod_zoo'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Código de zoocriadero no proporcionado'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            $codZoo = $datos['cod_zoo'];

            if (!$this->model->VerificarZooExiste($codZoo)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'El zoocriadero no existe'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            if (empty($datos['nombre_zoo']) || empty($datos['direccion_zoo'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Todos los campos son obligatorios'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            // ACTUALIZAR ZOOCRIADERO
            $datosActualizar = [
                'nombre_zoo' => $datos['nombre_zoo'],
                'direccion_zoo' => $datos['direccion_zoo'],
                'cod_barrio' => $datos['cod_barrio'],
                'id_usuarios' => $datos['id_usuarios']
            ];

            $resultZoo = $this->model->EditarZoo($codZoo, $datosActualizar);

            if (!$resultZoo) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar el zoocriadero'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            // PROCESAR TANQUES ELIMINADOS
            if (isset($datos['tanques_eliminados']) && is_array($datos['tanques_eliminados'])) {
                foreach ($datos['tanques_eliminados'] as $codTanque) {
                    $this->model->EliminarTanque($codTanque);
                }
            }

            // PROCESAR TANQUES EDITADOS
            if (isset($datos['tanques_editados']) && is_array($datos['tanques_editados'])) {
                foreach ($datos['tanques_editados'] as $tanque) {
                    if (isset($tanque['cod_zootanque'])) {
                        $datosTanque = [
                            'nom_zootanque' => $tanque['nom_zootanque'],
                            'cod_tipotanque' => $tanque['cod_tipotanque']
                        ];
                        $this->model->EditarTanque($tanque['cod_zootanque'], $datosTanque);
                    }
                }
            }

            echo json_encode([
                'success' => true,
                'message' => 'Zoocriadero y tanques actualizados correctamente'
            ], JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}

// Manejar peticiones
try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['cod_zoo'])) {
        $controlador = new EditarZoo();
        $controlador->ObtenerInfoZoo($_GET['cod_zoo']);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controlador = new EditarZoo();
        $controlador->ActualizarZoo();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ], JSON_UNESCAPED_UNICODE);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
