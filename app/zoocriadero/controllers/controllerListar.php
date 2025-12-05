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
        //Trae la información de los Zoo (nombre y dirección)
        return $this->model->SelectZoo();
    }

    public function ObtenerEncargados()
    {
        //Trae los encargados de los sitios en la tabla y en los filtros
        return $this->model->SelectEncargado();
    }

    public function ObtenerTiposTanque()
    {
        //Trae los tipos de tanques en los filtros
        return $this->model->SelectTiposTanque();
    }

    public function ObtenerBarrio()
    {
        //Trae los barrios
        return $this->model->SelectBarrios();
    }

    public function AgregarTanque($cod_zoo, $cod_tipotanque, $nom_zootanque)
    {
        //Permite agregar tanques nuevos a un zoocriadero
        return $this->model->InsertarTanque($cod_zoo, $cod_tipotanque, $nom_zootanque);
    }

    public function EliminarTanque($cod_zootanque)
    {
        //Cambia de estado de activo a inactivo
        return $this->model->EliminarTanque($cod_zootanque);
    }

    public function ActualizarTanque($cod_zootanque, $cod_tipotanque, $nom_zootanque)
    {
        //Permite actualizar el nombre y el tipo de tanque 
        return $this->model->ActualizarTanque($cod_zootanque, $cod_tipotanque, $nom_zootanque);
    }

    public function procesarPeticion()
    {
        try {
            // Peticiones GET
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                if (isset($_GET['action'])) {
                    switch ($_GET['action']) {
                        case 'getEncargados':
                            $resultado = $this->ObtenerEncargados();
                            echo json_encode(['success' => true, 'data' => $resultado]);
                            break;

                        case 'getBarrios':
                            $resultado = $this->ObtenerBarrio();
                            echo json_encode(['success' => true, 'data' => $resultado]);
                            break;

                        case 'getTiposTanque':
                            $resultado = $this->ObtenerTiposTanque();
                            echo json_encode(['success' => true, 'data' => $resultado]);
                            break;

                        default:
                            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
                            break;
                    }
                }
            }

            // Peticiones POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                header('Content-Type: application/json');

                $json = file_get_contents('php://input');
                $data = json_decode($json, true);

                if (isset($data['action'])) {
                    switch ($data['action']) {
                        case 'agregarTanque':
                            if (!isset($data['cod_zoo']) || !isset($data['cod_tipotanque']) || !isset($data['nom_zootanque'])) {
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Datos incompletos'
                                ]);
                                exit;
                            }

                            $resultado = $this->AgregarTanque(
                                $data['cod_zoo'],
                                $data['cod_tipotanque'],
                                $data['nom_zootanque']
                            );

                            if ($resultado) {
                                echo json_encode([
                                    'success' => true,
                                    'message' => 'Tanque agregado correctamente'
                                ]);
                            } else {
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Error al agregar el tanque'
                                ]);
                            }
                            break;

                        case 'eliminarTanque':
                            if (!isset($data['cod_zootanque'])) {
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Código de tanque no proporcionado'
                                ]);
                                exit;
                            }

                            $resultado = $this->EliminarTanque($data['cod_zootanque']);

                            if ($resultado) {
                                echo json_encode([
                                    'success' => true,
                                    'message' => 'Tanque eliminado correctamente'
                                ]);
                            } else {
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Error al eliminar el tanque'
                                ]);
                            }
                            break;

                        default:
                            echo json_encode([
                                'success' => false,
                                'message' => 'Acción no válida'
                            ]);
                            break;

                        case 'actualizarTanque':
                            if (!isset($data['cod_zootanque']) || !isset($data['cod_tipotanque']) || !isset($data['nom_zootanque'])) {
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Datos incompletos'
                                ]);
                                exit;
                            }

                            $resultado = $this->ActualizarTanque(
                                $data['cod_zootanque'],
                                $data['cod_tipotanque'],
                                $data['nom_zootanque']
                            );

                            echo json_encode([
                                'success' => $resultado,
                                'message' => $resultado ? 'Tanque actualizado correctamente' : 'Error al actualizar el tanque'
                            ]);
                            exit;
                    }
                }
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
