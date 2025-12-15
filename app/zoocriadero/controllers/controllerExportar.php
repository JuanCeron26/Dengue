<?php
include_once '../models/modelExportar.php';

class ExportarZoo
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelExportar();
    }

    public function obtenerDatosZoo($cod_zoo)
    {
        try {
            $zoo = $this->model->obtenerZoocriadero($cod_zoo);
            
            if (!$zoo) {
                return [
                    'success' => false,
                    'message' => 'No se encontró el zoocriadero'
                ];
            }

            $tanques = $this->model->obtenerTanques($cod_zoo);

            return [
                'success' => true,
                'zoo' => $zoo,
                'tanques' => $tanques
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}
?>