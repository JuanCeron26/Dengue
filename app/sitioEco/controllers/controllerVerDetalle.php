<?php 
include_once '../models/modelVerDetalle.php';

class VerDetalleSitioEco
{
    private $model;

    public function __construct()
    {
        $this->model = new modelVerDetalle();
    }

    // Obtener la información de sitioECO
    public function MostrarInfoSitioEco($codSitioeco)
    {
        $sitioeco = $this->model->VerDetalleSitioEco($codSitioeco);

        if($sitioeco){
            echo json_encode([
                'success' => true,
                'sitio'   => [
                    'cod_sitioeco' => $sitioeco['cod_sitioeco'],
                    'nombre_sitio' => $sitioeco['nombre_sitio'],
                    'direccion'    => $sitioeco['direccion'],
                    'nombarrio'    => $sitioeco['nombarrio'],
                    'nomcomun'     => $sitioeco['nomcomun'] ?? 'N/A'
                ]
            ]);
        }
        else{
            echo json_encode([ 
                'success' => false,
                'message' => "Sitio no encontrado"  
            ]);
        }
        exit;
    }
}

// Configurar headers
header('Content-Type: application/json');

// Verificar que venga el código del sitio
if (isset($_GET['cod_sitioeco']) && !empty($_GET['cod_sitioeco'])) {
    $controlador = new VerDetalleSitioEco();
    $controlador->MostrarInfoSitioEco($_GET['cod_sitioeco']);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Código de sitio no proporcionado'
    ]);
}
?>