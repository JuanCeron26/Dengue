<?php

require_once '../models/modalactcampo.php';

$TrabajoCampo = new actividadesTrabajoCampo('ceron123');

header('Content-Type: application/json; charset=utf-8');

function jsonResponse($success, $mensaje, $data = [])
{
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

    $accion = $_POST['accion'] ?? null;

    /* ------------------------ EDITAR ------------------------ */
    if ($accion === "editar") {

        $idActividad = intval(
            $_POST['cod_actividadtrabajocampo_insp'] ??
            $_POST['cod_actividadtrabajocampo_siembra'] ??
            $_POST['cod_actividadtrabajocampo_resiembra'] ??
            $_POST['cod_actividadtrabajocampo_seg'] ?? 0
        );

        if ($idActividad <= 0) {
            jsonResponse(false, 'ID inválido - no se recibió ID de actividad válido');
        }

        // SITIO - DEPÓSITO
        $nuevoSitio    = !empty($_POST['sitio']) ? intval($_POST['sitio']) : null;
        $nuevoDeposito = !empty($_POST['deposito']) ? intval($_POST['deposito']) : null;

        $idSitioDepo = null;

        if ($nuevoSitio && $nuevoDeposito) {
            $idExistente = $TrabajoCampo->ObtenerIdSitioTipoDepo($nuevoSitio, $nuevoDeposito);
            $idSitioDepo = $idExistente ?: $TrabajoCampo->InsertSitioTipoDepo($nuevoDeposito, $nuevoSitio);
        } elseif (!empty($_POST['cod_sitiodepo'])) {
            $idSitioDepo = intval($_POST['cod_sitiodepo']);
        }

        // FOTO
        $foto = null;
        foreach (['foto', 'fotos', 'foto_seguimiento'] as $f) {
            if ($f === 'fotos' && isset($_FILES[$f]) && isset($_FILES[$f]['tmp_name'][0]) && $_FILES[$f]['error'][0] === 0) {
                $foto = file_get_contents($_FILES[$f]['tmp_name'][0]);
                break;
            } elseif (isset($_FILES[$f]) && $_FILES[$f]['error'] === 0) {
                $foto = file_get_contents($_FILES[$f]['tmp_name']);
                break;
            }
        }

        // MAPEOS
        $mapeo = [
            'fecha' => 'fecha_actividad',
            'fecha_seguimiento' => 'fecha_actividad',
            'ph' => 'ph',
            'ph_actual' => 'ph',
            'cloro' => 'cloro',
            'cloro_actual' => 'cloro',
            'temperatura' => 'temperatura',
            'temperatura_actual' => 'temperatura',
            'ancho' => 'ancho_deposito',
            'largo' => 'largo_deposito',
            'profundidad' => 'profundidad_deposito',
            'positivo_larvas' => 'positivo_larvas_aedes',
            'positivo_pupas' => 'positivo_pupas',
            'positivo_culex' => 'positivo_culex',
            'alevines' => 'alevines_guppies',
            'adultos' => 'adultos_guppies',
            'larvas_aedes' => 'positivo_larvas_aedes',
            'pupas' => 'positivo_pupas',
            'larvas_culex' => 'positivo_culex',
            'observaciones' => 'observaciones'
        ];

        $dataActividad = [];

        foreach ($mapeo as $form => $bd) {
            if (isset($_POST[$form]) && $_POST[$form] !== '') {
                $dataActividad[$bd] = trim($_POST[$form]);
            }
        }

        if ($idSitioDepo) $dataActividad['cod_sitiodepo'] = $idSitioDepo;
        if ($foto) $dataActividad['foto'] = $foto;

        // ACTUALIZAR SITIO/DEPO SI APLICA
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

        // EJECUTAR ACTUALIZACIÓN
        $resultado = $TrabajoCampo->EditarTransaccional(
            $dataActividad,
            $dataSitio,
            $idActividad,
            $idSitioActualizar
        );

        if (!empty($resultado['success'])) {
            jsonResponse(true, $resultado['mensaje']);
        } else {
            jsonResponse(false, $resultado['error'] ?? "Error desconocido al editar");
        }
    }

    /* ------------------------ ANULAR ------------------------ */
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

    /* ------------------------ REGISTRAR ------------------------ */
    if ($accion === "registrar") {
        
        $codAct = $_POST['cod_act_campo'] ?? null;

        if (!$codAct) {
            jsonResponse(false, 'No se especificó el tipo de actividad');
        }

        /* ============== INSPECCIÓN (4) ============== */
        if ($codAct === '4') {

            if (empty($_POST['sitio']) || empty($_POST['deposito'])) {
                jsonResponse(false, 'Debe seleccionar un sitio y un tipo de depósito');
            }

            if (empty($_POST['fecha'])) {
                jsonResponse(false, 'Debe seleccionar una fecha de inspección');
            }

            if (empty($_POST['usuario'])) {
                jsonResponse(false, 'Debe seleccionar un usuario responsable');
            }

            $sitio    = intval($_POST['sitio']);
            $deposito = intval($_POST['deposito']);

            $codExistente = $TrabajoCampo->BuscarSitioTipoDepo($deposito, $sitio);

            if ($codExistente && $TrabajoCampo->ExisteInspeccion($codExistente, 4)) {
                jsonResponse(false, 'Ya existe una inspección registrada para este sitio y depósito');
            }

            $idSitioTipoDepo = $codExistente ?: $TrabajoCampo->InsertSitioTipoDepo($deposito, $sitio);

            $foto = (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0)
                ? file_get_contents($_FILES['foto']['tmp_name'])
                : null;

            $datos = [
                "fecha_actividad" => $_POST['fecha'],
                "cod_sitiodepo" => $idSitioTipoDepo,
                "cod_act_campo" => '4',
                "positivo_larvas_aedes" => $_POST['positivo_larvas'] ?? 'No',
                "positivo_pupas" => $_POST['positivo_pupas'] ?? 'No',
                "positivo_culex" => $_POST['positivo_culex'] ?? 'No',
                "ph" => !empty($_POST['ph']) ? $_POST['ph'] : null,
                "cloro" => !empty($_POST['cloro']) ? $_POST['cloro'] : null,
                "temperatura" => !empty($_POST['temperatura']) ? $_POST['temperatura'] : null,
                "ancho_deposito" => !empty($_POST['ancho']) ? $_POST['ancho'] : null,
                "largo_deposito" => !empty($_POST['largo']) ? $_POST['largo'] : null,
                "profundidad_deposito" => !empty($_POST['profundidad']) ? $_POST['profundidad'] : null,
                "observaciones" => $_POST['observaciones'] ?? null,
                "foto" => $foto
            ];

            try {
                $id = $TrabajoCampo->Insert("tblactividadtrabajcampo", $datos);

                if ($id && !empty($_POST['usuario'])) {
                    $TrabajoCampo->Insert("tblusuactrabajocampo", [
                        "id_usuarios" => intval($_POST['usuario']),
                        "cod_actividadtrabajocampo" => $id
                    ]);
                }

                if ($id) {
                    jsonResponse(true, 'Inspección registrada correctamente', ['id' => $id]);
                } else {
                    jsonResponse(false, 'Error al registrar la inspección en la base de datos');
                }
            } catch (Exception $e) {
                jsonResponse(false, 'Error al registrar la inspección: ' . $e->getMessage());
            }
        }

        /* ======== SIEMBRA (1), RESIEMBRA (2), SEGUIMIENTO (3) ======== */
        if (in_array($codAct, ['1', '2', '3'])) {

            // Validar fecha según tipo
            if ($codAct === '3') {
                if (empty($_POST['fecha_seguimiento'])) {
                    jsonResponse(false, 'Debe seleccionar una fecha de seguimiento');
                }
            } else {
                if (empty($_POST['fecha'])) {
                    jsonResponse(false, 'Debe seleccionar una fecha');
                }
            }

            if (empty($_POST['usuario'])) {
                jsonResponse(false, 'Debe seleccionar un usuario responsable');
            }

            if (empty($_POST['cod_sitiodepo'])) {
                jsonResponse(false, 'No se ha especificado el sitio y depósito');
            }

            // Manejar foto(s)
            $foto = null;
            if ($codAct === '3') {
                // Seguimiento: una sola foto
                if (isset($_FILES['foto_seguimiento']) && $_FILES['foto_seguimiento']['error'] === 0) {
                    $foto = file_get_contents($_FILES['foto_seguimiento']['tmp_name']);
                }
            } else {
                // Siembra/Resiembra: múltiples fotos - tomamos la primera
                if (isset($_FILES['fotos']) && isset($_FILES['fotos']['tmp_name'][0]) && $_FILES['fotos']['error'][0] === 0) {
                    $foto = file_get_contents($_FILES['fotos']['tmp_name'][0]);
                }
            }

            $datos = [
                "fecha_actividad" => $codAct === '3' ? $_POST['fecha_seguimiento'] : $_POST['fecha'],
                "cod_sitiodepo" => intval($_POST['cod_sitiodepo']),
                "cod_act_campo" => $codAct,
                "ph" => $codAct === '3' ? ($_POST['ph_actual'] ?? null) : ($_POST['ph'] ?? null),
                "cloro" => $codAct === '3' ? ($_POST['cloro_actual'] ?? null) : ($_POST['cloro'] ?? null),
                "temperatura" => $codAct === '3' ? ($_POST['temperatura_actual'] ?? null) : ($_POST['temperatura'] ?? null),
                "observaciones" => $_POST['observaciones'] ?? null,
                "foto" => $foto,
                "cod_actividad_padre" => !empty($_POST['cod_padre']) ? intval($_POST['cod_padre']) : null
            ];

            // Datos específicos de siembra/resiembra
            if (in_array($codAct, ['1', '2'])) {
                $datos["adultos_guppies"] = !empty($_POST['adultos']) ? intval($_POST['adultos']) : 0;
                $datos["alevines_guppies"] = !empty($_POST['alevines']) ? intval($_POST['alevines']) : 0;

                if ($datos["adultos_guppies"] == 0 && $datos["alevines_guppies"] == 0) {
                    jsonResponse(false, 'Debe sembrar al menos un pez (alevín o adulto)');
                }
            }

            // Datos específicos de seguimiento
            if ($codAct === '3') {
                $datos["positivo_larvas_aedes"] = $_POST['larvas_aedes'] ?? 0;
                $datos["positivo_pupas"] = $_POST['pupas'] ?? 0;
                $datos["positivo_culex"] = $_POST['larvas_culex'] ?? 0;
            }

            try {
                $id = $TrabajoCampo->Insert("tblactividadtrabajcampo", $datos);

                if ($id && !empty($_POST['usuario'])) {
                    $TrabajoCampo->Insert("tblusuactrabajocampo", [
                        "id_usuarios" => intval($_POST['usuario']),
                        "cod_actividadtrabajocampo" => $id
                    ]);
                }

                $mensajes = [
                    '1' => 'Siembra registrada correctamente',
                    '2' => 'Resiembra registrada correctamente',
                    '3' => 'Seguimiento registrado correctamente'
                ];

                if ($id) {
                    jsonResponse(true, $mensajes[$codAct], ['id' => $id]);
                } else {
                    jsonResponse(false, 'Error al registrar en la base de datos');
                }
            } catch (Exception $e) {
                jsonResponse(false, 'Error al procesar la solicitud: ' . $e->getMessage());
            }
        }
    }

    jsonResponse(false, 'Operación no reconocida');
}

jsonResponse(false, 'Método HTTP no permitido');