<?php 
include_once '../models/modelEditar.php';

class EditarSitioEco
{
    private $model;

    public function __construct()
    {
        $this->model= new modelEditar();
    }

    //Método principal para editar el sitioECO
    public function Editar()
    {
        //Validar que vengan los datos necesarios 
        if(empty($_POST['cod_sitioeco']) || empty($_POST['nombre_sitio'])){
            echo json_encode([

                'success' => false,
                'message' => "Faltan datos obligatorios (nombre del sitio o ID)"
            ]);
            return;
        }

        $codsitio= $_POST['cod_sitio'];
        $nomsitio= $_POST['nombre_sitio'];
    }
}

?>