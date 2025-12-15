<?php

require '../../../../conexionBD/BaseDatos.php';

class EstadisticasModel extends BaseDatos
{
    // ==========================================
    // CONSULTAS PARA FILTROS
    // ==========================================

    public function ObtenerSitios()
    {
        return $this->Select("tblsitiocontrolbiologico", ["cod_sitiocontrolbiolo", "nombre_sitio"]);
    }

    public function ObtenerTiposActividad()
    {
        return $this->Select("tblactcampo", ["cod_act_campo", "nombre_actividad"]);
    }

    public function ObtenerUsuarios()
    {
        $sql = "SELECT DISTINCT u.id_usuarios, u.nombre_usu || ' ' || u.apellido_usu AS nombre_completo
                FROM tblusuarios u
                JOIN tblusuactrabajocampo uac ON u.id_usuarios = uac.id_usuarios
                ORDER BY nombre_completo";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    // ==========================================
    // ESTADÍSTICAS PRINCIPALES
    // ==========================================

    public function SitiosConMasInspecciones($fechaInicio = null, $fechaFin = null, $usuario = null)
    {
        $sql = "SELECT 
                    si.nombre_sitio,
                    b.nombarrio,
                    COUNT(ac.cod_actividadtrabajocampo) as total_inspecciones
                FROM tblactividadtrabajcampo ac
                JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
                JOIN tblsitiocontrolbiologico si ON st.cod_sitiocontrolbiolo = si.cod_sitiocontrolbiolo
                JOIN tblbarrios b ON b.cod_barrio = si.cod_barrio
                LEFT JOIN tblusuactrabajocampo uac ON uac.cod_actividadtrabajocampo = ac.cod_actividadtrabajocampo
                WHERE ac.cod_act_campo = 4 
                AND ac.cod_estado = 1";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        if ($usuario) {
            $sql .= " AND uac.id_usuarios = $usuario";
        }

        $sql .= " GROUP BY si.nombre_sitio, b.nombarrio
                  ORDER BY total_inspecciones DESC
                  LIMIT 10";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    public function SitiosConMasSiembras($fechaInicio = null, $fechaFin = null, $usuario = null)
    {
        $sql = "SELECT 
                    si.nombre_sitio,
                    b.nombarrio,
                    COUNT(ac.cod_actividadtrabajocampo) as total_siembras
                FROM tblactividadtrabajcampo ac
                JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
                JOIN tblsitiocontrolbiologico si ON st.cod_sitiocontrolbiolo = si.cod_sitiocontrolbiolo
                JOIN tblbarrios b ON b.cod_barrio = si.cod_barrio
                LEFT JOIN tblusuactrabajocampo uac ON uac.cod_actividadtrabajocampo = ac.cod_actividadtrabajocampo
                WHERE ac.cod_act_campo = 1 
                AND ac.cod_estado = 1";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        if ($usuario) {
            $sql .= " AND uac.id_usuarios = $usuario";
        }

        $sql .= " GROUP BY si.nombre_sitio, b.nombarrio
                  ORDER BY total_siembras DESC
                  LIMIT 10";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    public function SitiosConMasResiembras($fechaInicio = null, $fechaFin = null, $usuario = null)
    {
        $sql = "SELECT 
                    si.nombre_sitio,
                    b.nombarrio,
                    COUNT(ac.cod_actividadtrabajocampo) as total_resiembras
                FROM tblactividadtrabajcampo ac
                JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
                JOIN tblsitiocontrolbiologico si ON st.cod_sitiocontrolbiolo = si.cod_sitiocontrolbiolo
                JOIN tblbarrios b ON b.cod_barrio = si.cod_barrio
                LEFT JOIN tblusuactrabajocampo uac ON uac.cod_actividadtrabajocampo = ac.cod_actividadtrabajocampo
                WHERE ac.cod_act_campo = 2 
                AND ac.cod_estado = 1";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        if ($usuario) {
            $sql .= " AND uac.id_usuarios = $usuario";
        }

        $sql .= " GROUP BY si.nombre_sitio, b.nombarrio
                  ORDER BY total_resiembras DESC
                  LIMIT 10";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    public function UsuariosConMasActividades($fechaInicio = null, $fechaFin = null, $tipoActividad = null)
    {
        $sql = "SELECT 
                    u.nombre_usu || ' ' || u.apellido_usu AS usuario,
                    COUNT(ac.cod_actividadtrabajocampo) as total_actividades,
                    tac.nombre_actividad
                FROM tblusuactrabajocampo uac
                JOIN tblusuarios u ON u.id_usuarios = uac.id_usuarios
                JOIN tblactividadtrabajcampo ac ON ac.cod_actividadtrabajocampo = uac.cod_actividadtrabajocampo
                LEFT JOIN tblactcampo tac ON tac.cod_act_campo = ac.cod_act_campo
                WHERE ac.cod_estado = 1";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        if ($tipoActividad) {
            $sql .= " AND ac.cod_act_campo = $tipoActividad";
        }

        $sql .= " GROUP BY u.nombre_usu, u.apellido_usu, tac.nombre_actividad
                  ORDER BY total_actividades DESC
                  LIMIT 10";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    public function ActividadesAnuladas($fechaInicio = null, $fechaFin = null)
    {
        $sql = "SELECT 
                    TO_CHAR(ac.fecha_actividad, 'YYYY-MM') as mes,
                    COUNT(ac.cod_actividadtrabajocampo) as total_anuladas,
                    tac.nombre_actividad
                FROM tblactividadtrabajcampo ac
                JOIN tblactcampo tac ON ac.cod_act_campo = tac.cod_act_campo
                WHERE ac.cod_estado = 2";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        $sql .= " GROUP BY TO_CHAR(ac.fecha_actividad, 'YYYY-MM'), tac.nombre_actividad
                  ORDER BY mes DESC";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    // ==========================================
    // TENDENCIAS Y ANÁLISIS
    // ==========================================

    public function TendenciasMensuales($fechaInicio = null, $fechaFin = null)
    {
        $sql = "SELECT 
                    TO_CHAR(ac.fecha_actividad, 'YYYY-MM') as mes,
                    tac.nombre_actividad,
                    COUNT(ac.cod_actividadtrabajocampo) as total
                FROM tblactividadtrabajcampo ac
                JOIN tblactcampo tac ON ac.cod_act_campo = tac.cod_act_campo
                WHERE ac.cod_estado = 1";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        $sql .= " GROUP BY TO_CHAR(ac.fecha_actividad, 'YYYY-MM'), tac.nombre_actividad
                  ORDER BY mes ASC";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    public function ActividadesPorBarrio($fechaInicio = null, $fechaFin = null)
    {
        $sql = "SELECT 
                    b.nombarrio,
                    COUNT(ac.cod_actividadtrabajocampo) as total_actividades
                FROM tblactividadtrabajcampo ac
                JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
                JOIN tblsitiocontrolbiologico si ON st.cod_sitiocontrolbiolo = si.cod_sitiocontrolbiolo
                JOIN tblbarrios b ON b.cod_barrio = si.cod_barrio
                WHERE ac.cod_estado = 1";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        $sql .= " GROUP BY b.nombarrio
                  ORDER BY total_actividades DESC
                  LIMIT 10";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    // ==========================================
    // PARÁMETROS DE CALIDAD
    // ==========================================

    public function PromedioParametros($fechaInicio = null, $fechaFin = null)
    {
        $sql = "SELECT 
                    AVG(CAST(ac.ph AS NUMERIC)) as promedio_ph,
                    AVG(CAST(ac.temperatura AS NUMERIC)) as promedio_temperatura,
                    AVG(CAST(ac.cloro AS NUMERIC)) as promedio_cloro,
                    COUNT(CASE WHEN ac.positivo_larvas_aedes = 'Si' THEN 1 END) as total_larvas_positivas,
                    COUNT(CASE WHEN ac.positivo_pupas = 'Si' THEN 1 END) as total_pupas_positivas,
                    COUNT(ac.cod_actividadtrabajocampo) as total_muestras
                FROM tblactividadtrabajcampo ac
                WHERE ac.cod_estado = 1
                AND ac.cod_act_campo = 4";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_assoc($res) : [];
    }

    // ==========================================
    // DATOS DETALLADOS PARA EXPORTACIÓN
    // ==========================================

    public function ObtenerDatosCompletos($fechaInicio = null, $fechaFin = null, $sitio = null, $tipoActividad = null, $usuario = null)
    {
        $sql = "SELECT 
                    ac.cod_actividadtrabajocampo,
                    ac.fecha_actividad,
                    tac.nombre_actividad,
                    si.nombre_sitio,
                    b.nombarrio,
                    co.nomcomun,
                    ti.nombre_deposito,
                    u.nombre_usu || ' ' || u.apellido_usu AS usuario,
                    r.nombre_responsable || ' ' || r.apellido_responsable AS responsable_sitio,
                    ac.positivo_larvas_aedes,
                    ac.positivo_pupas,
                    ac.positivo_culex,
                    ac.ph,
                    ac.temperatura,
                    ac.cloro,
                    ac.adultos_guppies,
                    ac.alevines_guppies,
                    ac.peces_muertos,
                    ac.ancho_deposito,
                    ac.largo_deposito,
                    ac.profundidad_deposito,
                    ac.observaciones,
                    CASE WHEN ac.cod_estado = 1 THEN 'Activa' ELSE 'Anulada' END as estado
                FROM tblactividadtrabajcampo ac
                JOIN tblactcampo tac ON ac.cod_act_campo = tac.cod_act_campo
                JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
                JOIN tblsitiocontrolbiologico si ON st.cod_sitiocontrolbiolo = si.cod_sitiocontrolbiolo
                JOIN tblbarrios b ON b.cod_barrio = si.cod_barrio
                JOIN tblcomuna co ON co.cod_comun = b.cod_comun
                JOIN tblresponsablesitio r ON r.id_responsable = si.id_responsable
                JOIN tbltipodeposito ti ON ti.cod_tipo_depo = st.cod_tipo_depo
                LEFT JOIN tblusuactrabajocampo uac ON uac.cod_actividadtrabajocampo = ac.cod_actividadtrabajocampo
                LEFT JOIN tblusuarios u ON u.id_usuarios = uac.id_usuarios
                WHERE 1=1";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND ac.fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        if ($sitio) {
            $sql .= " AND si.cod_sitiocontrolbiolo = $sitio";
        }

        if ($tipoActividad) {
            $sql .= " AND ac.cod_act_campo = $tipoActividad";
        }

        if ($usuario) {
            $sql .= " AND uac.id_usuarios = $usuario";
        }

        $sql .= " ORDER BY ac.fecha_actividad DESC";

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_all($res) : [];
    }

    // ==========================================
    // RESUMEN GENERAL (CARDS)
    // ==========================================

    public function ObtenerResumenGeneral($fechaInicio = null, $fechaFin = null)
    {
        $sql = "SELECT 
                    COUNT(CASE WHEN cod_estado = 1 THEN 1 END) as total_activas,
                    COUNT(CASE WHEN cod_estado = 2 THEN 1 END) as total_anuladas,
                    COUNT(CASE WHEN cod_act_campo = 1 THEN 1 END) as total_siembras,
                    COUNT(CASE WHEN cod_act_campo = 2 THEN 1 END) as total_resiembras,
                    COUNT(CASE WHEN cod_act_campo = 4 THEN 1 END) as total_inspecciones,
                    COUNT(DISTINCT cod_sitiodepo) as sitios_trabajados
                FROM tblactividadtrabajcampo
                WHERE 1=1";

        if ($fechaInicio && $fechaFin) {
            $sql .= " AND fecha_actividad BETWEEN '$fechaInicio' AND '$fechaFin'";
        }

        $res = pg_query($this->conectar, $sql);
        return $res ? pg_fetch_assoc($res) : [];
    }
}
/*
$obj = new EstadisticasModel();
print_r($obj->ObtenerSitios());
*/