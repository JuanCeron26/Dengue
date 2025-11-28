<?php 
include_once "../models/modelVerDetalle.php";

class VerDetalleZoo
{
    private $model;

    public function __construct()
    {
        $this->model = new modelVerDetalle();
    }

    public function MostrarInfoZoo($codZoo)
    {
        //  Obtener información del zoocriadero
        $zoocriadero = $this->model->VerDetalleZoo($codZoo);
        
        //  Obtener tanques asociados
        $tanques = $this->model->VerTanquesZoo($codZoo);
        
        if ($zoocriadero) {
            echo json_encode([
                'success' => true,
                'zoo' => [
                    'cod_zoo' => $zoocriadero['cod_zoo'],
                    'nombre_zoo' => $zoocriadero['nombre_zoo'],
                    'direccion_zoo' => $zoocriadero['direccion_zoo'],
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
}


if (isset($_GET['cod_zoo']) && !empty($_GET['cod_zoo'])) {
    header('Content-Type: application/json');
    $controlador = new VerDetalleZoo();
    $controlador->MostrarInfoZoo($_GET['cod_zoo']);
    exit; 
}
