<?php
include_once "../models/modelRegistrar.php";

class RegistrarZoo
{
    private $model;

    public function __construct()
    {
        $this->model = new modelRegistrar();
    }

    // Método principal que registra TODO
    public function Registrar()
    {
        // Validar que vengan los datos necesarios
        if (empty($_POST['nombreZoo']) || empty($_POST['barrio']) || empty($_POST['direccion'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Faltan datos obligatorios'
            ]);
            return;
        }

        //Registrar el ZOOCRIADERO
        $datosZoo = [
            "nombre_zoo"      => $_POST['nombreZoo'],
            "direccion_zoo"   => $_POST['direccion'],
            "cod_barrio"      => $_POST['barrio'],
            "cod_estado"      => 1
        ];

        $resultZoo = $this->model->RegistrarZoo($datosZoo);

        if (!$resultZoo) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al registrar el zoocriadero'
            ]);
            return;
        }

        //Obtener el ID del zoocriadero recién creado
        $cod_zoo = $this->model->ObtenerUltimoZoo();

        if (!$cod_zoo) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener el código del zoocriadero'
            ]);
            return;
        }

        //Registrar TODOS los tanques (LOOP)
        $tiposTanque = $_POST['tipoTanque'] ?? [];
        $nombresTanque = $_POST['nombreTanque'] ?? [];

        // Validar que haya al menos un tanque
        if (empty($tiposTanque) || empty($nombresTanque)) {
            echo json_encode([
                'success' => false,
                'message' => 'Debe agregar al menos un tanque'
            ]);
            return;
        }

        // Registrar cada tanque
        $tanquesRegistrados = 0;
        for ($i = 0; $i < count($tiposTanque); $i++) {
            // Validar que ambos campos tengan valor
            if (empty($tiposTanque[$i]) || empty($nombresTanque[$i])) {
                continue; // Saltar este tanque si está incompleto
            }

            $datosTanque = [
                "cod_zoo"         => $cod_zoo,              
                "cod_tipotanque"  => $tiposTanque[$i],      
                "nom_zootanque"   => $nombresTanque[$i],
                "cod_estado"      => 1     
            ];

            $resultTanque = $this->model->RegistrarTanqueZoo($datosTanque);

            if ($resultTanque) {
                $tanquesRegistrados++;
            }
        }

        // Responder con éxito
        echo json_encode([
            'success' => true,
            'message' => "Zoocriadero y $tanquesRegistrados tanque(s) registrados exitosamente",
            'cod_zoo' => $cod_zoo,
            'tanques' => $tanquesRegistrados
        ]);
    }

    //Obtener barrios para el select
    public function ObtenerBarrio()
    {
        return $this->model->SelectBarrio();
    }

    //Obtener tipos de tanque para el select
    public function ObtenerTiposTanque()
    {
        return $this->model->SelectTiposTanque();
    }
}

//Ejecutar solo si hay datos POST
if (!empty($_POST)) {
    $registrar = new RegistrarZoo();
    $registrar->Registrar();
}
