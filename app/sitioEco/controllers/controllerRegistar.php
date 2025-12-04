<?php
include_once '../models/modelRegistrar.php';

class RegistrarSitioEco
{
    private $model;

    public function __construct()
    {
        $this->model = new modelRegistrar();
    }

    //Método principal que registra TODO
    public function Registar()
    {
        //Validar que vengan los datos necesarios
        if (empty($_POST['sitioEco']) || empty($_POST['barrio']) || empty($_POST['direccion'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Faltan datos obligatorios'
            ]);
            return;
        }


        //Registrar el SITIO ECO
        $datositioeco = [
            "nombre_sitio"       =>     $_POST['sitioEco'],
            "direccion"          =>     $_POST['direccion'],
            "cod_barrio"         =>     $_POST['barrio'],
            "cod_estadositioeco" =>     1
        ];

        $resultSitio = $this->model->RegistarSitioEco($datositioeco);

        if(!$resultSitio){
            echo json_encode([
                'success' => false,
                "message" => 'Error al registrar el sitio'
            ]);
            return;
        }

        //Obtener el ID  del sitio ECO recién creado
        $cod_sitioeco = $this->model->ObtenerUltimoSitioEco();

        if(!$cod_sitioeco){
            echo json_encode([
                "success" => false,
                "message" => 'Error al obtener el código del sitio'
            ]);
            return;
        }

        //Responder con éxito
        echo json_encode([
            "success"      => true,
            "message"      => 'Sitios ECOSalud registrados exitosamente',
            "cod_sitioeco" => $cod_sitioeco
        ]);
    }


    //Obtener los Barrios para el select
    public function ObtenerBarrios()
    {
        return $this->model->SelectBarrio();
    }
}

 //Ejecutar solo si hay datos POST
    if (!empty($_POST)){
        $registrar = new RegistrarSitioEco();
        $registrar->Registar();
    }

