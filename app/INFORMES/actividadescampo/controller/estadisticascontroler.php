<?php

require_once '../model/estadisticasmodel.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

class EstadisticasController
{
    private $model;

    public function __construct()
    {
        $this->model = new EstadisticasModel('ceron123');
    }

    // ==========================================
    // OBTENER DATOS PARA FILTROS
    // ==========================================

    public function obtenerFiltros()
    {
        try {
            $data = [
                'sitios' => $this->model->ObtenerSitios(),
                'tipos_actividad' => $this->model->ObtenerTiposActividad(),
                'usuarios' => $this->model->ObtenerUsuarios()
            ];

            echo json_encode(['success' => true, 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // ==========================================
    // OBTENER TODAS LAS ESTADÍSTICAS
    // ==========================================

    public function obtenerEstadisticas()
    {
        try {
            $fechaInicio = $_POST['fecha_inicio'] ?? null;
            $fechaFin = $_POST['fecha_fin'] ?? null;
            $sitio = $_POST['sitio'] ?? null;
            $tipoActividad = $_POST['tipo_actividad'] ?? null;
            $usuario = $_POST['usuario'] ?? null;

            $data = [
                'resumen' => $this->model->ObtenerResumenGeneral($fechaInicio, $fechaFin),
                'sitios_inspecciones' => $this->model->SitiosConMasInspecciones($fechaInicio, $fechaFin, $usuario),
                'sitios_siembras' => $this->model->SitiosConMasSiembras($fechaInicio, $fechaFin, $usuario),
                'sitios_resiembras' => $this->model->SitiosConMasResiembras($fechaInicio, $fechaFin, $usuario),
                'usuarios_activos' => $this->model->UsuariosConMasActividades($fechaInicio, $fechaFin, $tipoActividad),
                'actividades_anuladas' => $this->model->ActividadesAnuladas($fechaInicio, $fechaFin),
                'tendencias_mensuales' => $this->model->TendenciasMensuales($fechaInicio, $fechaFin),
                'actividades_barrio' => $this->model->ActividadesPorBarrio($fechaInicio, $fechaFin),
                'parametros_promedio' => $this->model->PromedioParametros($fechaInicio, $fechaFin)
            ];

            echo json_encode(['success' => true, 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // ==========================================
    // OBTENER DATOS DETALLADOS PARA TABLA
    // ==========================================

    public function obtenerDatosDetallados()
    {
        try {
            $fechaInicio = $_POST['fecha_inicio'] ?? null;
            $fechaFin = $_POST['fecha_fin'] ?? null;
            $sitio = $_POST['sitio'] ?? null;
            $tipoActividad = $_POST['tipo_actividad'] ?? null;
            $usuario = $_POST['usuario'] ?? null;

            $datos = $this->model->ObtenerDatosCompletos($fechaInicio, $fechaFin, $sitio, $tipoActividad, $usuario);

            echo json_encode(['success' => true, 'data' => $datos]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // ==========================================
    // EXPORTAR A EXCEL
    // ==========================================

    public function exportarExcel()
    {
        try {
            $fechaInicio = $_POST['fecha_inicio'] ?? null;
            $fechaFin = $_POST['fecha_fin'] ?? null;
            $sitio = $_POST['sitio'] ?? null;
            $tipoActividad = $_POST['tipo_actividad'] ?? null;
            $usuario = $_POST['usuario'] ?? null;

            $datos = $this->model->ObtenerDatosCompletos($fechaInicio, $fechaFin, $sitio, $tipoActividad, $usuario);

            if (empty($datos)) {
                echo json_encode(['success' => false, 'error' => 'No hay datos para exportar']);
                return;
            }

            // Preparar datos para Excel
            $excelData = [];
            $excelData[] = array_keys($datos[0]); // Headers

            foreach ($datos as $fila) {
                $excelData[] = array_values($fila);
            }

            echo json_encode(['success' => true, 'data' => $excelData]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // ==========================================
    // MANEJAR SOLICITUDES
    // ==========================================

    public function manejarSolicitud()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            switch ($accion) {
                case 'obtener_filtros':
                    $this->obtenerFiltros();
                    break;

                case 'obtener_estadisticas':
                    $this->obtenerEstadisticas();
                    break;

                case 'obtener_datos_detallados':
                    $this->obtenerDatosDetallados();
                    break;

                case 'exportar_excel':
                    $this->exportarExcel();
                    break;

                default:
                    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
            }
        }
    }
}

// Ejecutar controlador si se recibe una petición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EstadisticasController();
    $controller->manejarSolicitud();
}
/*
$obj = new EstadisticasController();
print_r($obj->obtenerFiltros());
*/