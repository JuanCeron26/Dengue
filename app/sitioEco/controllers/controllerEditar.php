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
            exit;
        }

        $codsitio= $_POST['cod_sitioeco']; 
        $nomsitio= trim($_POST['nombre_sitio']);

        //Validar que el campo del nombre no esté vacio
        if(empty($nomsitio)){
            echo json_encode([
                'success' => false,
                'message' => "El nombre del sitio no puede estar vacío"
            ]);
            exit;
        }

        //Validar que el sitio existe
        if(!$this->model->ValidarSitioEcoExista($codsitio)){
            echo json_encode([
                'success' => false,
                'message' => "El sitio no existe en la base de datos"
            ]);
            exit;
        }

        //Actualizar solo el nombre del sitio
        $result= $this->model->EditarSitioEco($nomsitio, $codsitio);

        if($result){
            echo json_encode([
                'success' => true,
                'message' => "Sitio actualizado exitosamente",
                'cod_sitioeco' => $codsitio,
                'nuevo_nombre' => $nomsitio
            ]);
        }
        else{
            echo json_encode([
                'success' => false,
                'message' => "Error al actualizar el sitio en la base de datos"
            ]);
        }
        exit;
    }
}

//Ejecutar si solo hay datos POST
if(!empty($_POST)) {
    $editar= new EditarSitioEco();
    $editar->Editar();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se recibieron datos'
    ]);
}

?>