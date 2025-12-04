<?php
include_once '../models/modelListar.php';

class ListarSitioEco
{
    private $model;

    public function __construct()
    {
        $this->model = new modelListar();
    }

    //Obtener todos los Sitios
    public function MostrarSitioEco()
    {
        return $this->model->ListarSitioEco();
    }

    //Obtener todos los Barrios
    public function ObtenerBarrios()
    {
        return $this->model->SelectBarrios();
    }

    //Obtener todas las Comunas
    public function ObtenerComunas()
    {
        return $this->model->SelectComunas();
    }

    
}
