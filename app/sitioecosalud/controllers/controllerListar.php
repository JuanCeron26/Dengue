<?php
include_once '../models/modelListar.php';

class ListarSitioEco
{
    private $model;

    public function __construct()
    {
        $this->model = new modelListar();
    }

    // Obtener sitios con filtros opcionales
    public function MostrarSitioEco()
    {
        $filtros = [];
        
        // Capturar filtros de la URL
        if (isset($_GET['comuna']) && !empty($_GET['comuna'])) {
            $filtros['comuna'] = $_GET['comuna'];
        }
        
        if (isset($_GET['barrio']) && !empty($_GET['barrio'])) {
            $filtros['barrio'] = $_GET['barrio'];
        }

        return $this->model->ListarSitioEco($filtros);
    }

    // Obtener todos los Barrios
    public function ObtenerBarrios()
    {
        return $this->model->SelectBarrios();
    }

    // Obtener todas las Comunas
    public function ObtenerComunas()
    {
        return $this->model->SelectComunas();
    }
}