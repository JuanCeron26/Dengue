<?php
// ===============================================
// CONTROLADOR - TERRITORIO LÍDER
// ===============================================

header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 0);
require_once "../models/territorio.php";

class TerritorioLiderController
{

    private $model;

    public function __construct()
    {
        $this->model = new TerritorioModel();
    }

    public function listarTerritorios()
    {
        $data = $this->model->listarTerritorios();
        return $data;
    }

    public function listarSitios()
    {
        return $this->model->listarSitiosEcosalud();
    }

    public function listarLideres()
    {
        return $this->model->listarLideres();
    }

    public function verificarLider()
    {
        $post = json_decode(file_get_contents("php://input"), true);

        if (!$post) {
            return [
                'success' => false,
                'existe' => false,
                'message' => 'Datos inválidos'
            ];
        }

        $nombre = trim($post['nombre_lider'] ?? '');
        $apellido = trim($post['apellido_lider'] ?? '');

        if (empty($nombre) || empty($apellido)) {
            return [
                'success' => false,
                'existe' => false,
                'message' => 'Nombre y apellido son requeridos'
            ];
        }

        $lider = $this->model->verificarLiderExiste($nombre, $apellido);

        if ($lider) {
            return [
                'success' => true,
                'existe' => true,
                'message' => 'El líder ya está registrado',
                'data' => $lider
            ];
        } else {
            return [
                'success' => true,
                'existe' => false,
                'message' => 'Líder disponible para registro'
            ];
        }
    }

    public function obtener($cod_territorio)
    {
        $resultado = $this->model->detalleTerritorio($cod_territorio);

        if ($resultado) {
            return [
                'success' => true,
                'data' => $resultado
            ];
        }

        return [
            'success' => false,
            'message' => 'Territorio no encontrado'
        ];
    }

    public function registrarNuevoLider($datos)
    {
        try {
            // Validar campos obligatorios
            $nombre = trim($datos["nombre_lider"] ?? "");
            $apellido = trim($datos["apellido_lider"] ?? "");
            $correo = trim($datos["correo_lider"] ?? "");
            $celular = trim($datos["celular"] ?? "");
            $cedula = trim($datos["id_cedula"] ?? "");
            $clase_liderazgo = trim($datos["clase_liderazgo"] ?? "");

            // Validar que todos los campos estén llenos
            if (empty($nombre)) {
                return ['success' => false, 'message' => '❌ El nombre del líder es obligatorio'];
            }

            if (empty($apellido)) {
                return ['success' => false, 'message' => '❌ El apellido del líder es obligatorio'];
            }

            if (empty($correo)) {
                return ['success' => false, 'message' => '❌ El correo del líder es obligatorio'];
            }

            // Validar formato de correo
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => '❌ El correo electrónico no es válido'];
            }

            if (empty($celular)) {
                return ['success' => false, 'message' => '❌ El celular del líder es obligatorio'];
            }

            // 🔥 VALIDACIÓN CELULAR - Exactamente 10 dígitos
            if (!ctype_digit($celular)) {
                return ['success' => false, 'message' => '❌ El celular solo puede contener números'];
            }

            if (strlen($celular) !== 10) {
                return ['success' => false, 'message' => '❌ El celular debe tener exactamente 10 dígitos'];
            }

            if (empty($cedula)) {
                return ['success' => false, 'message' => '❌ La cédula del líder es obligatoria'];
            }

            // 🔥 VALIDACIÓN CÉDULA - Exactamente 10 dígitos
            if (!ctype_digit($cedula)) {
                return ['success' => false, 'message' => '❌ La cédula solo puede contener números'];
            }



            if (empty($clase_liderazgo)) {
                return ['success' => false, 'message' => '❌ La clase de liderazgo es obligatoria'];
            }

            // Verificar si el líder ya existe
            $liderExistente = $this->model->verificarLiderExiste($nombre, $apellido);

            if ($liderExistente) {
                return [
                    'success' => false,
                    'existe' => true,
                    'message' => '❌ Este líder ya está registrado en el sistema',
                    'data' => $liderExistente
                ];
            }

            // Verificar si la cédula ya existe
            $cedulaExistente = $this->model->verificarCedulaExiste($cedula);

            if ($cedulaExistente) {
                return [
                    'success' => false,
                    'message' => '❌ Esta cédula ya está registrada en el sistema'
                ];
            }

            // ====================================
            // 1️⃣ INSERTAR LÍDER EN tbllider
            // ====================================
            $dataLider = [
                "nombre_lider" => $nombre,
                "apellido_lider" => $apellido,
                "correo_lider" => $correo,
                "celular" => $celular,
                "id_cedula" => $cedula,
                "clase_liderazgo" => $clase_liderazgo
            ];

            $nuevoLider = $this->model->Insert("tbllider", $dataLider);

            if (!$nuevoLider) {
                return ['success' => false, 'message' => '❌ Error al registrar líder'];
            }

            $id_lider = $nuevoLider['id_lider'];

            // ====================================
            // 2️⃣ INSERTAR LÍDER COMO PARTICIPANTE EN tblparticipantes
            // ====================================
            $dataParticipante = [
                "nom_part" => $nombre,
                "ape_part" => $apellido,
                "id_cedula" => $cedula,
                "celular" => $celular
            ];

            $nuevoParticipante = $this->model->Insert("tblparticipantes", $dataParticipante);

            if (!$nuevoParticipante) {
                error_log("⚠️ Advertencia: No se pudo registrar al líder como participante");
            }

            // ====================================
            // 3️⃣ CREAR TERRITORIO PRIORIZADO
            // ====================================
            $cod_sitioeco = intval($datos["cod_sitioeco"] ?? 0);

            if ($cod_sitioeco <= 0) {
                return ['success' => false, 'message' => '❌ Debe seleccionar un sitio'];
            }

            if ($this->model->verificarAsociacion($id_lider, $cod_sitioeco)) {
                return ['success' => false, 'message' => '❌ Este líder ya está asignado a este sitio'];
            }

            $dataTerritorio = [
                "id_lider" => $id_lider,
                "cod_sitioeco" => $cod_sitioeco
            ];

            $territorio = $this->model->Insert("tblterritoriopriorizado", $dataTerritorio);

            if (!$territorio) {
                return ['success' => false, 'message' => '❌ Error al asociar territorio'];
            }

            return [
                'success' => true,
                'message' => '✅ Líder registrado, asociado y agregado como participante exitosamente',
                'cod_territorio' => $territorio['cod_territorio']
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => '❌ ' . $e->getMessage()];
        }
    }

    public function asociarLiderExistente($datos)
    {
        try {
            $id_lider = intval($datos["id_lider"] ?? 0);
            $cod_sitioeco = intval($datos["cod_sitioeco"] ?? 0);

            if ($id_lider <= 0 || $cod_sitioeco <= 0) {
                return ['success' => false, 'message' => '❌ Datos inválidos'];
            }

            if ($this->model->verificarAsociacion($id_lider, $cod_sitioeco)) {
                return ['success' => false, 'message' => '❌ Este líder ya está asignado a este sitio'];
            }

            $dataTerritorio = [
                "id_lider" => $id_lider,
                "cod_sitioeco" => $cod_sitioeco
            ];

            $territorio = $this->model->Insert("tblterritoriopriorizado", $dataTerritorio);

            if (!$territorio) {
                return ['success' => false, 'message' => '❌ Error al asociar territorio'];
            }

            return [
                'success' => true,
                'message' => '✅ Líder asociado al territorio exitosamente',
                'cod_territorio' => $territorio['cod_territorio']
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => '❌ ' . $e->getMessage()];
        }
    }

    public function actualizar($datos)
    {
        try {
            $cod_territorio = intval($datos["cod_territorio"] ?? 0);

            if ($cod_territorio <= 0) {
                return ['success' => false, 'message' => '❌ Código inválido'];
            }

            $detalleResult = $this->model->detalleTerritorio($cod_territorio);

            if (!$detalleResult) {
                return ['success' => false, 'message' => '❌ Territorio no encontrado'];
            }

            $id_lider = $detalleResult['id_lider'];
            $cedula_lider = $detalleResult['id_cedula'];

            // 🔥 VALIDACIONES ACTUALIZAR
            $celular = trim($datos["celular"] ?? "");

            if (!empty($celular)) {
                if (!ctype_digit($celular)) {
                    return ['success' => false, 'message' => '❌ El celular solo puede contener números'];
                }

                if (strlen($celular) !== 10) {
                    return ['success' => false, 'message' => '❌ El celular debe tener exactamente 10 dígitos'];
                }
            }

            // ====================================
            // 1️⃣ ACTUALIZAR LÍDER EN tbllider
            // ====================================
            if (!empty($datos["nombre_lider"]) || !empty($datos["apellido_lider"])) {
                $dataLider = [
                    "nombre_lider" => $datos["nombre_lider"] ?? $detalleResult['nombre_lider'],
                    "apellido_lider" => $datos["apellido_lider"] ?? $detalleResult['apellido_lider'],
                    "correo_lider" => $datos["correo_lider"] ?? $detalleResult['correo_lider'],
                    "celular" => $datos["celular"] ?? $detalleResult['celular'],
                    "id_cedula" => $datos["id_cedula"] ?? $detalleResult['id_cedula'],
                    "clase_liderazgo" => $datos["clase_liderazgo"] ?? $detalleResult['clase_liderazgo']
                ];

                $updateLider = $this->model->Update("tbllider", $dataLider, ["id_lider" => $id_lider]);

                if (!$updateLider) {
                    return ['success' => false, 'message' => '❌ Error al actualizar líder'];
                }

                // ====================================
                // 2️⃣ ACTUALIZAR PARTICIPANTE EN tblparticipantes
                // ====================================
                $dataParticipante = [
                    "nom_part" => $datos["nombre_lider"] ?? $detalleResult['nombre_lider'],
                    "ape_part" => $datos["apellido_lider"] ?? $detalleResult['apellido_lider'],
                    "celular" => $datos["celular"] ?? $detalleResult['celular']
                ];

                $updateParticipante = $this->model->Update(
                    "tblparticipantes",
                    $dataParticipante,
                    ["id_cedula" => $cedula_lider]
                );

                if (!$updateParticipante) {
                    error_log("⚠️ Advertencia: No se pudo actualizar el participante");
                }
            }

            // ====================================
            // 3️⃣ ACTUALIZAR TERRITORIO
            // ====================================
            $nuevo_cod_sitioeco = intval($datos["cod_sitioeco"] ?? 0);

            if ($nuevo_cod_sitioeco > 0 && $nuevo_cod_sitioeco != $detalleResult['cod_sitioeco']) {
                $updateTerritorio = $this->model->Update(
                    "tblterritoriopriorizado",
                    ["cod_sitioeco" => $nuevo_cod_sitioeco],
                    ["cod_territorio" => $cod_territorio]
                );

                if (!$updateTerritorio) {
                    return ['success' => false, 'message' => '❌ Error al actualizar territorio'];
                }
            }

            return ['success' => true, 'message' => '✅ Líder y participante actualizados exitosamente'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => '❌ ' . $e->getMessage()];
        }
    }

    public function eliminar()
    {
        try {
            if (!isset($_GET['cod_territorio'])) {
                return ['success' => false, 'message' => '❌ Código no proporcionado'];
            }

            $cod_territorio = $_GET['cod_territorio'];

            if ($this->model->verificarParticipantesTerritorio($cod_territorio)) {
                return [
                    'success' => false,
                    'message' => '❌ No se puede eliminar: Tiene participantes asociados'
                ];
            }

            $eliminado = $this->model->Delete(
                "tblterritoriopriorizado",
                ["cod_territorio" => $cod_territorio]
            );

            if ($eliminado) {
                return ['success' => true, 'message' => '✅ Territorio eliminado exitosamente'];
            } else {
                return ['success' => false, 'message' => '❌ Error al eliminar'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => '❌ ' . $e->getMessage()];
        }
    }

    // Obtener datos para los filtros
    public function obtenerDatosFiltros()
    {
        return [
            'success' => true,
            'comunas' => $this->model->obtenerComunas() ?: [],
            'barrios' => $this->model->obtenerBarrios() ?: [],
            'lideres' => $this->model->obtenerNombresLideres() ?: [],
            'liderazgos' => $this->model->obtenerTiposLiderazgo() ?: []
        ];
    }

    // Obtener barrios por comuna
    public function obtenerBarriosPorComuna()
    {
        $cod_comun = $_GET['cod_comun'] ?? null;

        if (!$cod_comun) {
            return [
                'success' => false,
                'message' => 'Comuna no proporcionada'
            ];
        }

        $barrios = $this->model->obtenerBarrios($cod_comun);

        return [
            'success' => true,
            'data' => $barrios ?: []
        ];
    }

    // Listar territorios con filtros
    public function listarTerritoriosFiltrados()
    {
        $post = json_decode(file_get_contents("php://input"), true);

        $filtros = [
            'comuna' => $post['comuna'] ?? '',
            'barrio' => $post['barrio'] ?? '',
            'nombre' => $post['nombre'] ?? '',
            'liderazgo' => $post['liderazgo'] ?? '',
            'fecha' => $post['fecha'] ?? ''
        ];

        // Limpiar filtros vacíos
        $filtros = array_filter($filtros, function ($valor) {
            return $valor !== '' && $valor !== null;
        });

        $data = $this->model->listarTerritoriosFiltrados($filtros);

        return [
            'success' => true,
            'data' => $data ?: [],
            'filtros_aplicados' => $filtros
        ];
    }
}

// ===============================================
// EJECUTAR CONTROLLER
// ===============================================
try {
    $controller = new TerritorioLiderController();
    $accion = $_GET["accion"] ?? "";

    switch ($accion) {
        case "listar":
            $result = $controller->listarTerritorios();
            echo json_encode(["success" => true, "data" => $result ?: []]);
            break;

        case "listar_sitios":
            $result = $controller->listarSitios();
            echo json_encode(["success" => true, "data" => $result ?: []]);
            break;

        case "listar_lideres":
            $result = $controller->listarLideres();
            echo json_encode(["success" => true, "data" => $result ?: []]);
            break;

        case "verificar_lider":
            $result = $controller->verificarLider();
            echo json_encode($result);
            break;

        case "obtener":
            $cod_territorio = intval($_GET["cod_territorio"] ?? 0);

            if ($cod_territorio <= 0) {
                echo json_encode(["success" => false, "message" => "❌ ID inválido"]);
                break;
            }

            $result = $controller->obtener($cod_territorio);
            echo json_encode($result);
            break;

        case "registrar_nuevo":
            $post = json_decode(file_get_contents("php://input"), true);
            $result = $controller->registrarNuevoLider($post ?? []);
            echo json_encode($result);
            break;

        case "asociar_existente":
            $post = json_decode(file_get_contents("php://input"), true);
            $result = $controller->asociarLiderExistente($post ?? []);
            echo json_encode($result);
            break;

        case "actualizar":
            $post = json_decode(file_get_contents("php://input"), true);
            $result = $controller->actualizar($post ?? []);
            echo json_encode($result);
            break;

        case "eliminar":
            $result = $controller->eliminar();
            echo json_encode($result);
            break;

        case "obtener_datos_filtros":
            $result = $controller->obtenerDatosFiltros();
            echo json_encode($result);
            break;

        case "obtener_barrios_por_comuna":
            $result = $controller->obtenerBarriosPorComuna();
            echo json_encode($result);
            break;

        case "listar_filtrados":
            $result = $controller->listarTerritoriosFiltrados();
            echo json_encode($result);
            break;

        default:
            echo json_encode(["success" => false, "message" => "❌ Acción no válida"]);
            break;
    }
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "❌ Error del servidor: " . $e->getMessage()
    ]);
}
