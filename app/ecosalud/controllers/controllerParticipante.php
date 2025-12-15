<?php
require_once "../models/modelParticipante.php";
require_once "../controllers/controllerEcosalud.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$participante = new Participantes('ceron123');

// Helper JSON
function jsonResponse($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $action = $_POST['action'] ?? '';

    switch ($action) {

        // ========================================
        //   REGISTRAR MÚLTIPLES PARTICIPANTES
        // ========================================
        case 'registrar_multiple':

            $cod_territorio = $_POST['territorio'] ?? '';
            $participantesData = $_POST['participantes'] ?? [];

            if (empty($cod_territorio)) {
                jsonResponse([
                    "success" => false,
                    "message" => "Debe seleccionar un territorio"
                ]);
            }

            if (empty($participantesData)) {
                jsonResponse([
                    "success" => false,
                    "message" => "No hay participantes para registrar"
                ]);
            }

            $registrados = 0;
            $errores = [];

            foreach ($participantesData as $part) {
                try {

                    // Datos del participante
                    $dataParticipante = [
                        'nom_part'  => trim($part['nombre']),
                        'ape_part'  => trim($part['apellido']),
                        'id_cedula' => trim($part['cedula']),
                        'celular'   => trim($part['celular']),
                    ];

                    // Registrar SOLO participante
                    $resultado = $participante->registrarSoloParticipante(
                        $dataParticipante,
                        $cod_territorio
                    );

                    if ($resultado['success']) {
                        $registrados++;
                    } else {
                        $errores[] = $resultado['message'] . " - " . $part['nombre'];
                    }
                } catch (Exception $e) {
                    $errores[] = "Error con {$part['nombre']}: " . $e->getMessage();
                }
            }
            $objEco = new controllerEcosalud();
            $ejec = $objEco->RegistrarControlActividad($cod_territorio, 2);
            jsonResponse([
                "success" => count($errores) === 0,
                "registrados" => $registrados,
                "errores" => $errores
            ]);
            break;

        // ========================================
        default:
            jsonResponse([
                "success" => false,
                "message" => "Acción no válida"
            ]);
            break;
    }
} else {
    jsonResponse([
        "success" => false,
        "message" => "Método no permitido"
    ]);
}
