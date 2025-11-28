<?php
include_once "../models/modelListar.php";

// Instancia del controlador
$listar = new ListarZoo();
$listar->MostrarLista();


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
}
