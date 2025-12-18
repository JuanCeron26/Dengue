<?php

require_once "../model/modalactcampo.php";

$TrabajoCampo = new actividadesTrabajoCampo('ceron123');

/**
 * Función para retornar respuestas JSON
 */
header('Content-Type: application/json; charset=utf-8');

function jsonResponse($success, $mensaje, $data = [])
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'mensaje' => $mensaje,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

/* ===========================================================
                      PETICIONES GET
  =========================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $accion = $_GET['accion'] ?? null;

    switch ($accion) {
        case "sitios":
            echo json_encode($TrabajoCampo->Sitios());
            break;

        case "depositos":
            echo json_encode($TrabajoCampo->ConsultarTiposDepositos());
            break;

        case "listar":
            echo json_encode($TrabajoCampo->ConsultarActividades());
            break;

        case "usuarios":
            echo json_encode($TrabajoCampo->ConsultarUsuarios());
            break;

        case "tipo_actividad":
            echo json_encode($TrabajoCampo->Tipoactividad());
            break;

        case "informe":
            $id = $_GET['id'] ?? null;

            if (!$id) {
                jsonResponse(false, "ID no recibido");
            }

            try {
                $datos = $TrabajoCampo->ReportesdeActividad($id);
                echo json_encode($datos);
            } catch (Exception $e) {
                jsonResponse(false, $e->getMessage());
            }
            break;

        case "filtrar":
            $fecha = $_GET['fecha'] ?? '';
            $sitio = $_GET['sitio'] ?? '';
            $actividad = $_GET['actividad'] ?? '';

            echo json_encode($TrabajoCampo->FiltrarActividades($fecha, $sitio, $actividad));
            break;

        default:
            jsonResponse(false, 'Acción GET no válida');
    }

    exit;
}

/* ===========================================================
                      PETICIONES POST
  =========================================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // PRIORIZAR POST sobre GET
    $accion = $_POST['accion'] ?? $_GET['accion'] ?? null;

    /* ==================== EDITAR ==================== */
    if ($accion === "editar") {

        // Obtener ID de cualquiera de los campos posibles
        $idActividad = intval(
            $_POST['cod_actividadtrabajocampo_insp'] ??
                $_POST['id_actividad_inspeccion'] ??
                $_POST['id_actividad'] ??
                $_POST['id_resiembra'] ??
                $_POST['cod_actividadtrabajocampo_seg'] ?? 0
        );

        // Obtener el tipo de actividad
        $codActCampo = $_POST['cod_act_campo'] ?? null;

        if ($idActividad <= 0) {
            jsonResponse(false, 'ID inválido - no se recibió ID de actividad. ID recibido: ' . $idActividad);
        }

        /* ==================== INSPECCIÓN (cod_act_campo = 4) ==================== */
        if ($codActCampo === '4') {

            $camposObligatorios = [
                'fecha'            => 'Fecha de inspección',
                'usuario'          => 'Responsable',
                'sitio'            => 'Sitio de inspección',
                'deposito'         => 'Tipo de depósito',
                'positivo_larvas'  => 'Larvas Aedes',
                'positivo_pupas'   => 'Pupas',
                'positivo_culex'   => 'Larvas Culex'
            ];

            foreach ($camposObligatorios as $campo => $nombre) {
                if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
                    jsonResponse(false, "El campo {$nombre} es obligatorio");
                }
            }

            /* ==================== SITIO - DEPÓSITO ==================== */
            $nuevoSitio    = intval($_POST['sitio']);
            $nuevoDeposito = intval($_POST['deposito']);
            $idSitioDepo = null;

            if ($nuevoSitio && $nuevoDeposito) {
                $idExistente = $TrabajoCampo->ObtenerIdSitioTipoDepo($nuevoSitio, $nuevoDeposito);
                $idSitioDepo = $idExistente ?: $TrabajoCampo->InsertSitioTipoDepo($nuevoDeposito, $nuevoSitio);
            } elseif (!empty($_POST['cod_sitiodepo'])) {
                $idSitioDepo = intval($_POST['cod_sitiodepo']);
            }

            if (!$idSitioDepo) {
                jsonResponse(false, 'No fue posible determinar el sitio y depósito');
            }

            /* ==================== FOTO (OPCIONAL) ==================== */
            $foto = null;
            if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
            }

            /* ==================== DATOS A ACTUALIZAR ==================== */
            $dataActividad = [
                'fecha_actividad'       => $_POST['fecha'],
                'cod_sitiodepo'         => $idSitioDepo,
                'positivo_larvas_aedes' => $_POST['positivo_larvas'],
                'positivo_pupas'        => $_POST['positivo_pupas'],
                'positivo_culex'        => $_POST['positivo_culex'],
                'ph'                    => $_POST['ph'] ?? null,
                'cloro'                 => $_POST['cloro'] ?? null,
                'temperatura'           => $_POST['temperatura'] ?? null,
                'ancho_deposito'        => $_POST['ancho'] ?? null,
                'largo_deposito'        => $_POST['largo'] ?? null,
                'profundidad_deposito'  => $_POST['profundidad'] ?? null,
                'observaciones'         => $_POST['observaciones'] ?? null
            ];

            if ($foto) {
                $dataActividad['foto'] = $foto;
            }

            /* ==================== ACTUALIZAR SITIO (SI APLICA) ==================== */
            $dataSitio = [];
            $idSitioActualizar = null;

            if (!empty($_POST['cod_tipodepo']) && !empty($_POST['cod_sitiocontrolbiolo'])) {
                $dataSitio = [
                    'cod_tipo_depo' => intval($_POST['cod_tipodepo']),
                    'cod_sitiocontrolbiolo' => intval($_POST['cod_sitiocontrolbiolo'])
                ];

                if (!empty($_POST['cod_sitiodepo'])) {
                    $idSitioActualizar = intval($_POST['cod_sitiodepo']);
                }
            }

            /* ==================== EJECUTAR ACTUALIZACIÓN ==================== */
            $resultado = $TrabajoCampo->EditarTransaccional(
                $dataActividad,
                $dataSitio,
                $idActividad,
                $idSitioActualizar
            );

            if (!empty($resultado['success'])) {
                jsonResponse(true, $resultado['mensaje']);
            } else {
                jsonResponse(false, $resultado['error'] ?? 'Error desconocido al editar inspección');
            }
        }

        /* ==================== SIEMBRA (1), RESIEMBRA (2), SEGUIMIENTO (3) ==================== */
        if (in_array($codActCampo, ['1', '2', '3'])) {

            /* ---------- VALIDACIONES ---------- */
            if (empty($_POST['usuario'])) {
                jsonResponse(false, 'Debe seleccionar un responsable');
            }

            /* ---------- FECHA ---------- */
            if ($codActCampo === '3') {
                if (empty($_POST['fecha_seguimiento'])) {
                    jsonResponse(false, 'Debe seleccionar una fecha de seguimiento');
                }
                $fecha = $_POST['fecha_seguimiento'];
            } else {
                if (empty($_POST['fecha'])) {
                    jsonResponse(false, 'Debe seleccionar una fecha');
                }
                $fecha = $_POST['fecha'];
            }

            /* ---------- FOTO ---------- */
            $foto = null;
            if ($codActCampo === '3') {
                if (!empty($_FILES['foto_seguimiento']) && $_FILES['foto_seguimiento']['error'] === 0) {
                    $foto = file_get_contents($_FILES['foto_seguimiento']['tmp_name']);
                }
            } else {
                if (!empty($_FILES['fotos']['tmp_name'][0]) && $_FILES['fotos']['error'][0] === 0) {
                    $foto = file_get_contents($_FILES['fotos']['tmp_name'][0]);
                }
            }

            /* ---------- DATOS BASE ---------- */
            $dataActividad = [
                "fecha_actividad" => $fecha,
                "ph"              => $codActCampo === '3' ? ($_POST['ph_actual'] ?? null) : ($_POST['ph'] ?? null),
                "cloro"           => $codActCampo === '3' ? ($_POST['cloro_actual'] ?? null) : ($_POST['cloro'] ?? null),
                "temperatura"     => $codActCampo === '3' ? ($_POST['temperatura_actual'] ?? null) : ($_POST['temperatura'] ?? null),
                "observaciones"   => $_POST['observaciones'] ?? null
            ];

            if ($foto) {
                $dataActividad['foto'] = $foto;
            }

            /* ---------- SIEMBRA / RESIEMBRA ---------- */
            if (in_array($codActCampo, ['1', '2'])) {
                $adultos  = intval($_POST['adultos'] ?? 0);
                $alevines = intval($_POST['alevines'] ?? 0);

                if ($adultos === 0 && $alevines === 0) {
                    jsonResponse(false, 'Debe registrar al menos un pez');
                }

                $dataActividad["adultos_guppies"]  = $adultos;
                $dataActividad["alevines_guppies"] = $alevines;
            }

            /* ---------- SEGUIMIENTO ---------- */
            if ($codActCampo === '3') {
                $vectores = [
                    'larvas_aedes' => 'Larvas Aedes',
                    'pupas'        => 'Pupas',
                    'positivo_culex' => 'Larvas Culex'
                ];

                foreach ($vectores as $campo => $nombre) {
                    if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
                        jsonResponse(false, "Debe seleccionar {$nombre}");
                    }
                }

                $dataActividad["positivo_larvas_aedes"] = $_POST['larvas_aedes'];
                $dataActividad["positivo_pupas"]        = $_POST['pupas'];
                $dataActividad["positivo_culex"]        = $_POST['positivo_culex'];
            }

            /* ==================== EJECUTAR ACTUALIZACIÓN ==================== */
            $resultado = $TrabajoCampo->EditarTransaccional(
                $dataActividad,
                [], // Sin actualización de sitio en estos casos
                $idActividad,
                null
            );

            if (!empty($resultado['success'])) {
                $mensajes = [
                    '1' => 'Siembra actualizada correctamente',
                    '2' => 'Resiembra actualizada correctamente',
                    '3' => 'Seguimiento actualizado correctamente'
                ];
                jsonResponse(true, $mensajes[$codActCampo]);
            } else {
                jsonResponse(false, $resultado['error'] ?? 'Error desconocido al editar');
            }
        }

        jsonResponse(false, 'Tipo de actividad no reconocido para edición');
    }

    /* ==================== ANULAR ==================== */
    if ($accion === "anular") {

        $idActividad = $_POST['id_actividad'] ?? null;

        if (!$idActividad) {
            jsonResponse(false, 'ID de actividad no proporcionado');
        }

        $resultado = $TrabajoCampo->AnularActividad(["id_actividad" => intval($idActividad)]);

        if (!empty($resultado['success'])) {
            jsonResponse(true, $resultado['mensaje']);
        } else {
            jsonResponse(false, $resultado['error'] ?? "Error al anular la actividad");
        }
    }

    /* ==================== REGISTRAR ==================== */
    $codActCampo = $_POST['cod_act_campo'] ?? null;

    /* ==========================================================
       INSPECCIÓN (4)
    ========================================================== */
    if ($codActCampo === '4' && $accion !== 'editar') {

        /* ---------- VALIDACIONES OBLIGATORIAS ---------- */
        $obligatorios = [
            'sitio'            => 'Sitio de inspección',
            'deposito'         => 'Tipo de depósito',
            'fecha'            => 'Fecha de inspección',
            'usuario'          => 'Responsable',
            'positivo_larvas'  => 'Larvas Aedes',
            'positivo_pupas'   => 'Pupas',
            'positivo_culex'   => 'Larvas Culex'
        ];

        foreach ($obligatorios as $campo => $nombre) {
            if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
                jsonResponse(false, "Debe seleccionar {$nombre}");
            }
        }

        $sitio    = intval($_POST['sitio']);
        $deposito = intval($_POST['deposito']);

        /* ---------- VALIDAR DUPLICADO ---------- */
        $codExistente = $TrabajoCampo->BuscarSitioTipoDepo($deposito, $sitio);

        if ($codExistente && $TrabajoCampo->ExisteInspeccion($codExistente, 4)) {
            jsonResponse(false, 'Ya existe una inspección registrada para este sitio y depósito');
        }

        $idSitioTipoDepo = $codExistente ?: $TrabajoCampo->InsertSitioTipoDepo($deposito, $sitio);

        /* ---------- FOTO (OPCIONAL) ---------- */
        $foto = null;
        if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        }

        /* ---------- DATOS A INSERTAR ---------- */
        $datos = [
            "fecha_actividad"       => $_POST['fecha'],
            "cod_sitiodepo"         => $idSitioTipoDepo,
            "cod_act_campo"         => '4',
            "positivo_larvas_aedes" => $_POST['positivo_larvas'],
            "positivo_pupas"        => $_POST['positivo_pupas'],
            "positivo_culex"        => $_POST['positivo_culex'],
            "ph"                    => $_POST['ph'] ?? null,
            "cloro"                 => $_POST['cloro'] ?? null,
            "temperatura"           => $_POST['temperatura'] ?? null,
            "ancho_deposito"        => $_POST['ancho'] ?? null,
            "largo_deposito"        => $_POST['largo'] ?? null,
            "profundidad_deposito"  => $_POST['profundidad'] ?? null,
            "observaciones"         => $_POST['observaciones'] ?? null,
            "foto"                  => $foto
        ];

        try {
            $id = $TrabajoCampo->Insert("tblactividadtrabajcampo", $datos);

            if ($id) {
                $TrabajoCampo->Insert("tblusuactrabajocampo", [
                    "id_usuarios" => intval($_POST['usuario']),
                    "cod_actividadtrabajocampo" => $id
                ]);

                jsonResponse(true, 'Inspección registrada correctamente', ['id' => $id]);
            }

            jsonResponse(false, 'Error al registrar la inspección');
        } catch (Exception $e) {
            jsonResponse(false, 'Error: ' . $e->getMessage());
        }
    }

    /* ==========================================================
       SIEMBRA (1) - RESIEMBRA (2) - SEGUIMIENTO (3)
    ========================================================== */
    if (in_array($codActCampo, ['1', '2', '3']) && $accion !== 'editar') {

        /* ---------- VALIDACIONES COMUNES ---------- */
        if (empty($_POST['usuario'])) {
            jsonResponse(false, 'Debe seleccionar un responsable');
        }

        if (empty($_POST['cod_sitiodepo'])) {
            jsonResponse(false, 'No se ha definido el sitio y depósito');
        }

        /* ---------- FECHA ---------- */
        if ($codActCampo === '3') {
            if (empty($_POST['fecha_seguimiento'])) {
                jsonResponse(false, 'Debe seleccionar una fecha de seguimiento');
            }
            $fecha = $_POST['fecha_seguimiento'];
        } else {
            if (empty($_POST['fecha'])) {
                jsonResponse(false, 'Debe seleccionar una fecha');
            }
            $fecha = $_POST['fecha'];
        }

        /* ---------- FOTO ---------- */
        $foto = null;

        if ($codActCampo === '3') {
            if (!empty($_FILES['foto_seguimiento']) && $_FILES['foto_seguimiento']['error'] === 0) {
                $foto = file_get_contents($_FILES['foto_seguimiento']['tmp_name']);
            }
        } else {
            if (!empty($_FILES['fotos']['tmp_name'][0]) && $_FILES['fotos']['error'][0] === 0) {
                $foto = file_get_contents($_FILES['fotos']['tmp_name'][0]);
            }
        }

        /* ---------- DATOS BASE ---------- */
        $datos = [
            "fecha_actividad"       => $fecha,
            "cod_sitiodepo"         => intval($_POST['cod_sitiodepo']),
            "cod_act_campo"         => $codActCampo,
            "ph"                    => $codActCampo === '3' ? ($_POST['ph_actual'] ?? null) : ($_POST['ph'] ?? null),
            "cloro"                 => $codActCampo === '3' ? ($_POST['cloro_actual'] ?? null) : ($_POST['cloro'] ?? null),
            "temperatura"           => $codActCampo === '3' ? ($_POST['temperatura_actual'] ?? null) : ($_POST['temperatura'] ?? null),
            "observaciones"         => $_POST['observaciones'] ?? null,
            "foto"                  => $foto,
            "cod_actividad_padre"   => $_POST['cod_padre'] ?? null
        ];

        /* ---------- SIEMBRA / RESIEMBRA ---------- */
        if (in_array($codActCampo, ['1', '2'])) {

            $adultos  = intval($_POST['adultos'] ?? 0);
            $alevines = intval($_POST['alevines'] ?? 0);

            if ($adultos === 0 && $alevines === 0) {
                jsonResponse(false, 'Debe registrar al menos un pez');
            }

            $datos["adultos_guppies"]  = $adultos;
            $datos["alevines_guppies"] = $alevines;
        }

        /* ---------- SEGUIMIENTO ---------- */
        if ($codActCampo === '3') {

            $vectores = [
                'larvas_aedes' => 'Larvas Aedes',
                'pupas'        => 'Pupas',
                'larvas_culex' => 'Larvas Culex'
            ];

            foreach ($vectores as $campo => $nombre) {
                if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
                    jsonResponse(false, "Debe seleccionar {$nombre}");
                }
            }

            $datos["positivo_larvas_aedes"] = $_POST['larvas_aedes'];
            $datos["positivo_pupas"]        = $_POST['pupas'];
            $datos["positivo_culex"]        = $_POST['larvas_culex'];
        }

        try {
            $id = $TrabajoCampo->Insert("tblactividadtrabajcampo", $datos);

            if ($id) {
                $TrabajoCampo->Insert("tblusuactrabajocampo", [
                    "id_usuarios" => intval($_POST['usuario']),
                    "cod_actividadtrabajocampo" => $id
                ]);

                $mensajes = [
                    '1' => 'Siembra registrada correctamente',
                    '2' => 'Resiembra registrada correctamente',
                    '3' => 'Seguimiento registrado correctamente'
                ];

                jsonResponse(true, $mensajes[$codActCampo], ['id' => $id]);
            }

            jsonResponse(false, 'Error al registrar la actividad');
        } catch (Exception $e) {
            jsonResponse(false, 'Error: ' . $e->getMessage());
        }
    }

    jsonResponse(false, 'Operación no reconocida');
}

jsonResponse(false, 'Método HTTP no permitido');
