<?php

require_once "../model/modalactcampo.php";

$TrabajoCampo = new actividadesTrabajoCampo('ceron123');

/* ===========================================================
    CONFIG RESPUESTA JSON
  =========================================================== */
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
            if (!$id) jsonResponse(false, "ID no recibido");
            echo json_encode($TrabajoCampo->ReportesdeActividad($id));
            break;

        case "filtrar":
            echo json_encode($TrabajoCampo->FiltrarActividades(
                $_GET['fecha'] ?? '',
                $_GET['sitio'] ?? '',
                $_GET['actividad'] ?? ''
            ));
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

    $accion = $_POST['accion'] ?? ($_GET['accion'] ?? null);

    /* ======================================================
            ***   REGISTRO DE INSPECCIÓN (4)   ***
       ====================================================== */
    if (($_POST['cod_act_campo'] ?? '') === '4') {

        // Lista de campos obligatorios
        $camposObligatorios = [
            "sitio" => "Debe seleccionar un sitio",
            "deposito" => "Debe seleccionar un tipo de depósito",
            "fecha" => "Debe seleccionar una fecha de inspección",
            "usuario" => "Debe seleccionar un usuario responsable",
            "ph" => "Debe ingresar el pH",
            "cloro" => "Debe ingresar el cloro residual",
            "temperatura" => "Debe ingresar la temperatura",
            "ancho" => "Debe ingresar el ancho del depósito",
            "largo" => "Debe ingresar el largo del depósito",
            "profundidad" => "Debe ingresar la profundidad del depósito",
        ];

        foreach ($camposObligatorios as $campo => $mensaje) {
            if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
                jsonResponse(false, $mensaje);
            }
        }

        $sitio = intval($_POST['sitio']);
        $deposito = intval($_POST['deposito']);

        // Evitar duplicados
        $codExistente = $TrabajoCampo->BuscarSitioTipoDepo($deposito, $sitio);
        if ($codExistente && $TrabajoCampo->ExisteInspeccion($codExistente, 4)) {
            jsonResponse(false, 'Ya existe una inspección registrada para este sitio y depósito. No puedes repetirla.');
        }

        $idSitioTipoDepo = $codExistente ?: $TrabajoCampo->InsertSitioTipoDepo($deposito, $sitio);

        // Cargar foto opcional
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
            "ph" => $_POST['ph'],
            "cloro" => $_POST['cloro'],
            "temperatura" => $_POST['temperatura'],
            "ancho_deposito" => $_POST['ancho'],
            "largo_deposito" => $_POST['largo'],
            "profundidad_deposito" => $_POST['profundidad'],
            "observaciones" => $_POST['observaciones'] ?? null,
            "foto" => $foto
        ];

        try {
            $id = $TrabajoCampo->Insert("tblactividadtrabajcampo", $datos);

            if ($id) {
                $TrabajoCampo->Insert("tblusuactrabajocampo", [
                    "id_usuarios" => intval($_POST['usuario']),
                    "cod_actividadtrabajocampo" => $id
                ]);
            }

            jsonResponse(true, "Inspección registrada correctamente", ["id" => $id]);
        } catch (Exception $e) {
            jsonResponse(false, "Error al registrar inspección: " . $e->getMessage());
        }
    }

    /* ======================================================
           *** SIEMBRA (1), RESIEMBRA (2), SEGUIMIENTO (3) ***
       ====================================================== */
    if (in_array($_POST['cod_act_campo'] ?? '', ['1', '2', '3'])) {

        $codAct = $_POST['cod_act_campo'];
        $usuario = $_POST['usuario'] ?? null;

        if (!$usuario) jsonResponse(false, "Debe seleccionar un usuario responsable");
        if (empty($_POST['cod_sitiodepo'])) jsonResponse(false, "Debe seleccionar un sitio y depósito");

        // Manejo de fecha
        $fechaActividad = ($codAct === '3')
            ? ($_POST['fecha_seguimiento'] ?? null)
            : ($_POST['fecha'] ?? null);

        if (!$fechaActividad) jsonResponse(false, "La fecha es obligatoria");

        // Manejo de foto(s)
        $foto = null;
        if ($codAct === '3') {
            if (!empty($_FILES['foto_seguimiento']) && $_FILES['foto_seguimiento']['error'] === 0) {
                $foto = file_get_contents($_FILES['foto_seguimiento']['tmp_name']);
            }
        } else {
            if (isset($_FILES['fotos']['tmp_name'][0]) && $_FILES['fotos']['error'][0] === 0) {
                $foto = file_get_contents($_FILES['fotos']['tmp_name'][0]);
            }
        }

        $datos = [
            "fecha_actividad" => $fechaActividad,
            "cod_sitiodepo" => intval($_POST['cod_sitiodepo']),
            "cod_act_campo" => $codAct,
            "ph" => $codAct === '3' ? ($_POST['ph_actual'] ?? null) : ($_POST['ph'] ?? null),
            "cloro" => $codAct === '3' ? ($_POST['cloro_actual'] ?? null) : ($_POST['cloro'] ?? null),
            "temperatura" => $codAct === '3' ? ($_POST['temperatura_actual'] ?? null) : ($_POST['temperatura'] ?? null),
            "observaciones" => $_POST['observaciones'] ?? null,
            "foto" => $foto,
            "cod_actividad_padre" => $_POST['cod_padre'] ?? null,
        ];

        // Siembra o resiembra
        if (in_array($codAct, ['1', '2'])) {

            $adultos = intval($_POST['adultos'] ?? 0);
            $alevines = intval($_POST['alevines'] ?? 0);

            if ($adultos == 0 && $alevines == 0) {
                jsonResponse(false, "Debe sembrar al menos un pez (alevín o adulto)");
            }

            $datos["adultos_guppies"] = $adultos;
            $datos["alevines_guppies"] = $alevines;
        }

        // Seguimiento
        if ($codAct === '3') {
            $datos["positivo_larvas_aedes"] = $_POST['larvas_aedes'] ?? 0;
            $datos["positivo_pupas"] = $_POST['pupas'] ?? 0;
            $datos["positivo_culex"] = $_POST['larvas_culex'] ?? 0;
        }

        try {
            $id = $TrabajoCampo->Insert("tblactividadtrabajcampo", $datos);

            if ($id) {
                $TrabajoCampo->Insert("tblusuactrabajocampo", [
                    "id_usuarios" => intval($usuario),
                    "cod_actividadtrabajocampo" => $id
                ]);
            }

            $mensajes = [
                '1' => 'Siembra registrada correctamente',
                '2' => 'Resiembra registrada correctamente',
                '3' => 'Seguimiento registrado correctamente'
            ];

            jsonResponse(true, $mensajes[$codAct], ["id" => $id]);
        } catch (Exception $e) {
            jsonResponse(false, "Error al registrar: " . $e->getMessage());
        }
    }

    /* ======================================================
                      ACCIÓN NO RECONOCIDA
       ====================================================== */
    jsonResponse(false, 'Operación no reconocida');
}

jsonResponse(false, 'Método HTTP no permitido');
