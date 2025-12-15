<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../models/asistenciamodel.php';

$model = new AsistenciaModel('ceron123');
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

try {
    switch ($action) {

        /**
         * OBTENER TODOS LOS TERRITORIOS
         * GET: ?action=obtenerTerritorios
         */
        case 'obtenerTerritorios':
            $territorios = $model->obtenerTerritorios();
            echo json_encode([
                'success' => true,
                'territorios' => $territorios
            ]);
            break;

        /**
         * OBTENER ACTIVIDADES POR TERRITORIO
         * GET: ?action=obtenerActividades&cod_territorio=X
         */
        case 'obtenerActividades':
            $cod_territorio = $_GET['cod_territorio'] ?? null;

            // ← AÑADE ESTO: limpiar y convertir a entero
            $cod_territorio = $cod_territorio !== null ? (int)$cod_territorio : null;

            if (!$cod_territorio || $cod_territorio <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Código de territorio inválido']);
                exit;
            }

            try {
                $actividades = $model->obtenerActividades($cod_territorio);
                echo json_encode([
                    'success' => true,
                    'actividades' => $actividades
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error en el servidor: ' . $e->getMessage()
                ]);
            }
            break;

        /**
         * OBTENER PARTICIPANTES DE UN TERRITORIO
         * GET: ?action=obtenerParticipantes&cod_territorio=X&cod_controlactividadeco=Y
         */
        case 'obtenerParticipantes':
            $cod_territorio = $_GET['cod_territorio'] ?? null;
            $cod_controlactividadeco = $_GET['cod_controlactividadeco'] ?? null;

            if (!$cod_territorio) {
                throw new Exception('Código de territorio no proporcionado');
            }

            $participantes = $model->obtenerParticipantes($cod_territorio);

            // Si hay cod_controlactividadeco, traer asistencias ya registradas
            $asistencias = [];
            if ($cod_controlactividadeco) {
                $asistencias = $model->obtenerAsistenciaRegistrada($cod_controlactividadeco);
            }

            // Agregar el estado de asistencia a cada participante
            foreach ($participantes as &$p) {
                $p['asistio'] = isset($asistencias[$p['id_part']]) ? $asistencias[$p['id_part']] : null;
            }

            echo json_encode([
                'success' => true,
                'participantes' => $participantes
            ]);
            break;

        /**
         * GUARDAR ASISTENCIA COMPLETA
         * POST: action=guardarAsistencia&cod_controlactividadeco=X&asistencias=[...]
         */
        case 'guardarAsistencia':
            $cod_controlactividadeco = $_POST['cod_controlactividadeco'] ?? null;
            $asistencias = json_decode($_POST['asistencias'] ?? '[]', true);

            if (!$cod_controlactividadeco || !is_array($asistencias)) {
                throw new Exception('Datos incompletos para guardar asistencia');
            }

            // Contar presentes para el valor_asistencia
            $valor_asistencia = 0;
            foreach ($asistencias as $asist) {
                if ($asist['asistio'] === true) {
                    $valor_asistencia++;
                }
            }

            // Verificar si ya existe un registro de asistencia para esta actividad
            $cod_asistencia = $model->existeAsistencia($cod_controlactividadeco);

            if ($cod_asistencia) {
                // Ya existe, actualizar el valor de asistencia
                $model->actualizarValorAsistencia($cod_asistencia, $valor_asistencia);

                // Eliminar asistencias de participantes anteriores para volver a registrar
                $model->eliminarAsistenciasParticipantes($cod_asistencia);
            } else {
                // No existe, crear nuevo registro de asistencia
                $cod_asistencia = $model->crearAsistencia($cod_controlactividadeco, $valor_asistencia);

                if (!$cod_asistencia) {
                    throw new Exception('Error al crear registro de asistencia');
                }
            }

            // Registrar asistencia de cada participante
            $errores = [];
            $exitosos = 0;

            foreach ($asistencias as $asist) {
                $resultado = $model->registrarAsistenciaParticipante(
                    $cod_asistencia,
                    $asist['id_part'],
                    $asist['asistio'] ? 't' : 'f'
                );

                if ($resultado) {
                    $exitosos++;
                } else {
                    $errores[] = "Error al registrar participante ID: " . $asist['id_part'];
                }
            }

            if (!empty($errores)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Algunos registros no se pudieron guardar',
                    'exitosos' => $exitosos,
                    'errores' => $errores
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'message' => 'Asistencia guardada correctamente',
                    'cod_asistencia' => $cod_asistencia,
                    'total_presentes' => $valor_asistencia,
                    'total_registrados' => $exitosos
                ]);
            }
            break;

        /**
         * OBTENER RESUMEN DE ASISTENCIA
         * GET: ?action=obtenerResumen&cod_controlactividadeco=X
         */
        case 'obtenerResumen':
            $cod_controlactividadeco = $_GET['cod_controlactividadeco'] ?? null;

            if (!$cod_controlactividadeco) {
                throw new Exception('Código de actividad no proporcionado');
            }

            $asistencias = $model->obtenerAsistenciaRegistrada($cod_controlactividadeco);

            $presentes = 0;
            $ausentes = 0;
            foreach ($asistencias as $asistio) {
                if ($asistio) {
                    $presentes++;
                } else {
                    $ausentes++;
                }
            }

            echo json_encode([
                'success' => true,
                'total' => count($asistencias),
                'presentes' => $presentes,
                'ausentes' => $ausentes,
                'porcentaje_asistencia' => count($asistencias) > 0 ? round(($presentes / count($asistencias)) * 100, 2) : 0
            ]);
            break;

        /**
         * ACCIÓN NO VÁLIDA
         */
        default:
            throw new Exception('Acción no válida: ' . $action);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'action' => $action
    ]);
}
