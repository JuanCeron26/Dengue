<?php
// ============================================================
// IMPORTACIÓN DE MODELOS NECESARIOS
// ============================================================
require_once "../models/ResponsableModel.php";

// ============================================================
// CLASE: CONTROLADOR DE SITIOS
// ============================================================
class SitiosController
{
    private $db;

    public function __construct()
    {
        $this->db = new BaseDatos("ceron123");
    }
    public function registrarNuevoResponsable($datos)
    {
        try {
            $nombreResp = trim($datos["nombre_responsable"] ?? "");
            $apellidoResp = trim($datos["apellido_responsable"] ?? "");
            $cedulaResp = $datos["cedula"] ?? null;
            $celularResp = $datos["celular"] ?? null;

            if (empty($nombreResp) || empty($apellidoResp) || empty($cedulaResp) || empty($celularResp)) {
                return ['success' => false, 'message' => 'Nombre, apellido, cédula y celular son requeridos'];
            }

            //  Verificar si el responsable ya existe
            $responsableExistente = $this->db->verificarResponsableExiste($cedulaResp);

            if ($responsableExistente) {
                return [
                    'success' => false,
                    'existe' => true,
                    'message' => 'Este responsable ya está registrado en el sistema',
                    'responsable' => $responsableExistente
                ];
            }

            // Registrar responsable
            $dataResponsable = [
                "nombre_responsable" => $nombreResp,
                "apellido_responsable" => $apellidoResp,
                "cedula" => $cedulaResp,
                "celular" => $celularResp
            ];

            $nuevoResponsable = $this->db->Insert("tblresponsablesitio", $dataResponsable);

            if (!$nuevoResponsable) {
                return ['success' => false, 'message' => 'Error al registrar responsable'];
            }

            $id_responsable = $nuevoResponsable['id_responsable'];
            $cod_barrio = intval($datos["cod_barrio"] ?? 0);
            $nombreSitio = trim($datos["nombre_sitio"] ?? "");
            $direccionSitio = trim($datos["direccion_sitio"] ?? "");

            if ($cod_barrio <= 0 || empty($nombreSitio) || empty($direccionSitio)) {
                return ['success' => false, 'message' => 'Debe completar todos los datos del sitio'];
            }

            //  VALIDAR SI EL SITIO YA EXISTE POR NOMBRE
            $sitioExistentePorNombre = $this->db->verificarSitioExistePorNombre($nombreSitio);
            if ($sitioExistentePorNombre) {
                return [
                    'success' => false,
                    'existe_sitio' => true,
                    'tipo_duplicado' => 'nombre',
                    'message' => 'Ya existe un sitio con este nombre: "' . $sitioExistentePorNombre['nombre_sitio'] . '"',
                    'sitio' => $sitioExistentePorNombre
                ];
            }

            //  VALIDAR SI EL SITIO YA EXISTE POR DIRECCIÓN
            $sitioExistentePorDireccion = $this->db->verificarSitioExistePorDireccion($direccionSitio);
            if ($sitioExistentePorDireccion) {
                return [
                    'success' => false,
                    'existe_sitio' => true,
                    'tipo_duplicado' => 'direccion',
                    'message' => 'Ya existe un sitio en esta dirección: "' . $sitioExistentePorDireccion['direccion_sitio'] . '"',
                    'sitio' => $sitioExistentePorDireccion
                ];
            }

            // Registrar el sitio
            $dataSitio = [
                "cod_barrio" => $cod_barrio,
                "id_responsable" => $id_responsable,
                "nombre_sitio" => $nombreSitio,
                "direccion_sitio" => $direccionSitio
            ];

            $sitio = $this->db->Insert("tblsitiocontrolbiologico", $dataSitio);

            if (!$sitio) {
                return ['success' => false, 'message' => 'Error al registrar sitio'];
            }

            return [
                'success' => true,
                'message' => 'Responsable y sitio registrados exitosamente',
                'cod_sitio' => $sitio['cod_sitiocontrolbiolo']
            ];
        } catch (Exception $e) {
            error_log("Error en registrarNuevoResponsable: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }



    // ============================================================
    // AGREGAR ESTE MÉTODO DENTRO DE LA CLASE SitiosController
    // (después del método editarSitio)
    // ============================================================

    public function verificarCedulaExiste($cedula)
    {
        try {
            if (empty($cedula)) {
                return [
                    'existe' => false,
                    'message' => 'Debe proporcionar una cédula'
                ];
            }

            $responsable = $this->db->verificarResponsableExiste($cedula);

            if ($responsable) {
                return [
                    'existe' => true,
                    'responsable' => $responsable,
                    'message' => 'Responsable encontrado'
                ];
            } else {
                return [
                    'existe' => false,
                    'message' => 'No existe un responsable con esta cédula'
                ];
            }
        } catch (Exception $e) {
            error_log("Error en verificarCedulaExiste: " . $e->getMessage());
            return [
                'existe' => false,
                'message' => 'Error al verificar la cédula: ' . $e->getMessage()
            ];
        }
    }



    //  TAMBIÉN ACTUALIZA EL MÉTODO asociarResponsableExistente
    public function asociarResponsableExistente($datos)
    {
        try {
            $cedulaResp = $datos["cedula"] ?? null;
            $cod_barrio = intval($datos["cod_barrio"] ?? 0);
            $nombreSitio = trim($datos["nombre_sitio"] ?? "");
            $direccionSitio = trim($datos["direccion_sitio"] ?? "");

            if (empty($cedulaResp)) {
                return ['success' => false, 'message' => 'Debe ingresar la cédula del responsable'];
            }

            $responsable = $this->db->verificarResponsableExiste($cedulaResp);

            if (!$responsable) {
                return ['success' => false, 'message' => 'No existe un responsable con esa cédula'];
            }

            $id_responsable = $responsable['id_responsable'];

            if ($cod_barrio <= 0 || empty($nombreSitio) || empty($direccionSitio)) {
                return ['success' => false, 'message' => 'Debe completar todos los datos del sitio'];
            }

            //  VALIDAR SI EL SITIO YA EXISTE POR NOMBRE
            $sitioExistentePorNombre = $this->db->verificarSitioExistePorNombre($nombreSitio);
            if ($sitioExistentePorNombre) {
                return [
                    'success' => false,
                    'existe_sitio' => true,
                    'tipo_duplicado' => 'nombre',
                    'message' => 'Ya existe un sitio con este nombre: "' . $sitioExistentePorNombre['nombre_sitio'] . '"',
                    'sitio' => $sitioExistentePorNombre
                ];
            }

            //  VALIDAR SI EL SITIO YA EXISTE POR DIRECCIÓN
            $sitioExistentePorDireccion = $this->db->verificarSitioExistePorDireccion($direccionSitio);
            if ($sitioExistentePorDireccion) {
                return [
                    'success' => false,
                    'existe_sitio' => true,
                    'tipo_duplicado' => 'direccion',
                    'message' => 'Ya existe un sitio en esta dirección: "' . $sitioExistentePorDireccion['direccion_sitio'] . '"',
                    'sitio' => $sitioExistentePorDireccion
                ];
            }

            //  SE ELIMINÓ LA VALIDACIÓN DE BARRIO - AHORA PERMITE VARIOS SITIOS EN EL MISMO BARRIO

            $dataSitio = [
                "cod_barrio" => $cod_barrio,
                "id_responsable" => $id_responsable,
                "nombre_sitio" => $nombreSitio,
                "direccion_sitio" => $direccionSitio
            ];

            $sitio = $this->db->Insert("tblsitiocontrolbiologico", $dataSitio);

            if (!$sitio) {
                return ['success' => false, 'message' => 'Error al registrar sitio'];
            }

            return [
                'success' => true,
                'message' => 'Responsable asociado al sitio exitosamente',
                'cod_sitio' => $sitio['cod_sitiocontrolbiolo']
            ];
        } catch (Exception $e) {
            error_log("Error en asociarResponsableExistente: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function listarSitios()
    {
        return $this->db->listarSitios();
    }

    public function eliminarSitio($id)
    {
        $this->db->Delete("tblsitiodepo", ["cod_sitiocontrolbiolo" => $id]);
        return $this->db->Delete("tblsitiocontrolbiologico", ["cod_sitiocontrolbiolo" => $id]);
    }

    public function verDetalle($id)
    {
        if (!$id) return null;
        return $this->db->obtenerDetalleSitio($id);
    }

    //  MÉTODO CORREGIDO PARA FILTROS
    public function listarSitiosConFiltros($filters = [])
    {
        try {
            $data = $this->db->getAllSitiosWithFilters($filters);

            return [
                'success' => true,
                'data' => $data ?: []
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }
    public function editarSitio()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $codSitio = (int)($_POST['cod_sitiocontrolbiolo'] ?? 0);

        if (!$codSitio) {
            echo json_encode(['success' => false, 'message' => 'Error: ID no válido']);
            exit();
        }

        //  OBTENER Y VALIDAR DATOS (sin convertir a int para evitar problemas con cédulas que empiezan en 0)
        $codBarrio = (int)($_POST['cod_barrio'] ?? 0);
        $nombreSitio = trim($_POST['nombre_sitio'] ?? '');
        $direccionSitio = trim($_POST['direccion_sitio'] ?? '');
        $nombreResp = trim($_POST['nombre_responsable'] ?? '');
        $apellidoResp = trim($_POST['apellido_responsable'] ?? '');
        $cedulaResp = trim($_POST['cedula'] ?? ''); // ✅ Se recibe pero NO se actualizará
        $celularResp = trim($_POST['celular'] ?? '');

        //  VALIDAR QUE TODOS LOS CAMPOS ESTÉN COMPLETOS
        if (
            empty($nombreResp) ||
            empty($apellidoResp) ||
            empty($cedulaResp) || // Solo validamos que exista (para logging)
            empty($celularResp) ||
            empty($codBarrio) ||
            empty($nombreSitio) ||
            empty($direccionSitio)
        ) {
            echo json_encode([
                'success' => false,
                'message' => 'Debe completar todos los datos'
            ]);
            exit();
        }

        // Validación de formato
        if (strlen($cedulaResp) !== 10 || strlen($celularResp) !== 10) {
            echo json_encode(['success' => false, 'message' => 'El documento y teléfono deben tener 10 dígitos']);
            exit();
        }

        // Validar duplicados de sitio (excluyendo el actual)
        $sitioExistentePorNombre = $this->db->verificarSitioExistePorNombre($nombreSitio);
        if ($sitioExistentePorNombre && $sitioExistentePorNombre['cod_sitiocontrolbiolo'] != $codSitio) {
            echo json_encode([
                'success' => false,
                'message' => '⚠️ Ya existe un sitio con este nombre: ' . $sitioExistentePorNombre['nombre_sitio']
            ]);
            exit();
        }

        $sitioExistentePorDireccion = $this->db->verificarSitioExistePorDireccion($direccionSitio);
        if ($sitioExistentePorDireccion && $sitioExistentePorDireccion['cod_sitiocontrolbiolo'] != $codSitio) {
            echo json_encode([
                'success' => false,
                'message' => '⚠️ Ya existe un sitio en esta dirección: ' . $sitioExistentePorDireccion['direccion_sitio']
            ]);
            exit();
        }

        // Obtener el sitio actual
        $sitioActual = $this->db->obtenerDetalleSitio($codSitio);
        if (empty($sitioActual)) {
            echo json_encode(['success' => false, 'message' => 'Error: Sitio no encontrado']);
            exit();
        }

        $idResponsableActual = $sitioActual[0]['id_responsable'];

        //  ACTUALIZAR RESPONSABLE SIN LA CÉDULA (solo nombre, apellido y celular)
        $updateResp = $this->db->Update("tblresponsablesitio", [
            "nombre_responsable" => $nombreResp,
            "apellido_responsable" => $apellidoResp,
            "celular" => $celularResp
            // ❌ LA CÉDULA NO SE INCLUYE EN EL UPDATE
        ], ["id_responsable" => $idResponsableActual]);

        if (!$updateResp) {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar responsable']);
            exit();
        }

        // Actualizar el sitio
        $resultado = $this->db->Update("tblsitiocontrolbiologico", [
            "cod_barrio" => $codBarrio,
            "nombre_sitio" => $nombreSitio,
            "direccion_sitio" => $direccionSitio
        ], ["cod_sitiocontrolbiolo" => $codSitio]);

        if ($resultado) {
            echo json_encode(['success' => true, 'message' => '✅ Sitio actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar sitio']);
        }

        exit();
    }
}
// ============================================================
// MANEJO DE PETICIONES
// ============================================================
$controller = new SitiosController();
$accion = $_GET["accion"] ?? "";

// GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($accion === 'listar_filtros') {
        $filters = [
            'f_sitio' => $_GET['f_sitio'] ?? '',
            'f_barrio' => $_GET['f_barrio'] ?? '',
            'f_nombre' => $_GET['f_nombre'] ?? ''
        ];

        header('Content-Type: application/json');
        echo json_encode($controller->listarSitiosConFiltros($filters));
        exit();
    }

    if ($accion === 'obtener') {
        $id = (int)($_GET['cod_sitiocontrolbiolo'] ?? 0);
        $detalle = $controller->verDetalle($id);

        header('Content-Type: application/json');
        echo json_encode($detalle ? $detalle[0] : ['error' => 'No encontrado']);
        exit();
    }

    if ($accion === 'detalle') {
        $id = $_GET['id'] ?? null;
        $detalle = $controller->verDetalle($id);

        header('Content-Type: application/json');
        echo json_encode($detalle ? $detalle[0] : ['error' => 'No encontrado']);
        exit();
    }

    if ($accion === 'eliminar') {
        $id = (int)($_GET['id'] ?? 0);
        $ok = $controller->eliminarSitio($id);

        header('Content-Type: application/json');
        echo json_encode(['status' => $ok]);
        exit();
    }

    if ($accion === 'verificar_cedula') {
        $cedula = $_GET['cedula'] ?? '';

        header('Content-Type: application/json');
        echo json_encode($controller->verificarCedulaExiste($cedula));
        exit();
    }
}

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['accion']) && $_POST['accion'] === 'editar') {
        $controller->editarSitio();
        exit();
    }

    $post = json_decode(file_get_contents("php://input"), true);

    switch ($accion) {
        case "registrar_nuevo":
            header('Content-Type: application/json');
            echo json_encode($controller->registrarNuevoResponsable($post ?? []));
            break;

        case "asociar_existente":
            header('Content-Type: application/json');
            echo json_encode($controller->asociarResponsableExistente($post ?? []));
            break;

        default:
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Acción no válida"]);
            break;
    }

    exit();
}
