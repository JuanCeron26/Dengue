<?php

include_once '../../../conexionBD/BaseDatos.php';

class ModelZoo
{
    private $conexion;
    private $objDB;

    public function __construct()
    {
        $this->objDB = new BaseDatos("ceron123"); // para usar las funciones genéricas
        $this->conexion = $this->objDB->conectar; // para hacer funciones propias
    }

    protected function GetZoocriaderos()
    {
        $traer = $this->objDB->Select("tblzoocriadero");
        return $traer;
    }

    protected function GetActividades()
    {
        $traer = $this->objDB->Select("tbltipoactividadzoo");
        return $traer;
    }

    protected function GetTanques($cod_zoo)
    {
        $id = (int)$cod_zoo;
        $conexion = $this->conexion;
        $sql = "SELECT tt.*, zt.cod_zootanque, zt.nom_zootanque as nombre
            FROM tblzootanque zt
            INNER JOIN tbltipotanque tt ON tt.cod_tipotanque = zt.cod_tipotanque
            INNER JOIN tblzoocriadero z ON z.cod_zoo = zt.cod_zoo
            WHERE z.cod_zoo = $1";
        $ejecutar = pg_query_params($conexion, $sql, [$id]);
        if ($ejecutar) {
            return pg_fetch_all($ejecutar);
        }
    }

    protected function GetOperarios($cod_zoo)
    {
        $id = (int)$cod_zoo;
        $conexion = $this->conexion;
        $sql = "SELECT u.*, za.id_zooadmin
            FROM tblzooadmin za
            INNER JOIN tblusuarios u ON u.id_usuarios = za.id_usuarios
            WHERE za.cod_zoo = $1";

        $ejecutar = pg_query_params($conexion, $sql, [$id]);
        if ($ejecutar) {
            return pg_fetch_all($ejecutar);
        }
    }

    protected function InsertarSeguimientoZooPrincipal($datos)
    {
        return $this->objDB->InsertReturning("tblseguimientozoo", $datos, "cod_segzoo");
    }

    // Insertar en tblsegzooact y obtener cod_segzooact
    protected function InsertarActividadZoo($datos)
    {
        return $this->objDB->InsertReturning("tblsegzooact", $datos, "cod_segzooact");
    }

    // Insertar en tabla intermedia tblsegzooact_actividades
    protected function InsertarActividadRelacion($cod_segzooact, $cod_tipoactividadzoo)
    {
        $datos = [
            "cod_segzooact" => $cod_segzooact,
            "cod_tipoactividadzoo" => $cod_tipoactividadzoo
        ];
        return $this->objDB->Insert("tblsegzooact_actividades", $datos);
    }

    protected function GetSeguimientos()
    {

        $sql = "SELECT 
            sza.cod_segzooact, 
            sza.fecha_actividad, 
            sza.ph, 
            sza.temperatura, 
            sza.cloro,
            sza.alevines_nacimiento,
            sza.muerte_hembras,
            sza.muerte_machos,
            sza.observaciones,
            STRING_AGG(taz.nombre_actividad, ' - ' ORDER BY taz.nombre_actividad) as actividades,
            z.cod_zoo, 
            z.nombre_zoo, 
            zt.nom_zootanque as nombre_tanque, 
            tt.nomtiptan as tipo_tanque, 
            u.nombre_usu, 
            u.apellido_usu
        FROM tblsegzooact sza
        INNER JOIN tblsegzooact_actividades sa ON sa.cod_segzooact = sza.cod_segzooact
        INNER JOIN tbltipoactividadzoo taz ON sa.cod_tipoactividadzoo = taz.cod_tipoactividadzoo
        INNER JOIN tblseguimientozoo sz ON sz.cod_segzoo = sza.cod_segzoo
        INNER JOIN tblzoocriadero z ON z.cod_zoo = sz.cod_zoo
        INNER JOIN tblzootanque zt ON zt.cod_zootanque = sz.cod_zootanque
        INNER JOIN tblzooadmin za ON za.id_zooadmin = sz.id_zooadmin
        INNER JOIN tblusuarios u ON u.id_usuarios = za.id_usuarios
        INNER JOIN tbltipotanque tt ON tt.cod_tipotanque = zt.cod_tipotanque
        WHERE sza.cod_estado = 1
        GROUP BY 
            sza.cod_segzooact, 
            sza.fecha_actividad, 
            sza.ph, 
            sza.temperatura, 
            sza.cloro,
            sza.alevines_nacimiento,
            sza.muerte_hembras,
            sza.muerte_machos,
            sza.observaciones,
            z.cod_zoo, 
            z.nombre_zoo, 
            zt.nom_zootanque, 
            tt.nomtiptan, 
            u.nombre_usu, 
            u.apellido_usu
        ORDER BY sza.fecha_actividad DESC";

        $ejecutar = pg_query($this->conexion, $sql);
        if ($ejecutar) {
            return pg_fetch_all($ejecutar);
        }
    }

    protected function GetSeguimientoById($cod_segzooact)
    {
        $sql = "SELECT 
            sza.cod_segzooact, 
            sza.cod_segzoo,
            sza.fecha_actividad, 
            sza.ph, 
            sza.temperatura, 
            sza.cloro,
            sza.alevines_nacimiento,
            sza.muerte_hembras,
            sza.muerte_machos,
            sza.observaciones,
            sz.cod_zootanque,  --  faltaba esto
            sz.id_zooadmin,
            STRING_AGG(taz.cod_tipoactividadzoo::text, ',' ORDER BY taz.cod_tipoactividadzoo) as actividades_ids, -- ::text es para convertir los IDs en texto. Ya que es un STRING_AGG
            STRING_AGG(taz.nombre_actividad, ' - ' ORDER BY taz.nombre_actividad) as actividades,
            z.cod_zoo, 
            z.nombre_zoo, 
            zt.nom_zootanque as nombre_tanque, 
            tt.nomtiptan as tipo_tanque, 
            u.nombre_usu, 
            u.apellido_usu
        FROM tblsegzooact sza
        INNER JOIN tblsegzooact_actividades sa ON sa.cod_segzooact = sza.cod_segzooact
        INNER JOIN tbltipoactividadzoo taz ON sa.cod_tipoactividadzoo = taz.cod_tipoactividadzoo
        INNER JOIN tblseguimientozoo sz ON sz.cod_segzoo = sza.cod_segzoo
        INNER JOIN tblzoocriadero z ON z.cod_zoo = sz.cod_zoo
        INNER JOIN tblzootanque zt ON zt.cod_zootanque = sz.cod_zootanque
        INNER JOIN tblzooadmin za ON za.id_zooadmin = sz.id_zooadmin
        INNER JOIN tblusuarios u ON u.id_usuarios = za.id_usuarios
        INNER JOIN tbltipotanque tt ON tt.cod_tipotanque = zt.cod_tipotanque
        WHERE sza.cod_segzooact = $1
        GROUP BY 
            sza.cod_segzooact, 
            sza.fecha_actividad, 
            sza.ph, 
            sza.temperatura, 
            sza.cloro,
            sza.alevines_nacimiento,
            sza.muerte_hembras,
            sza.muerte_machos,
            sza.observaciones,
            sz.cod_zootanque,  -- 
            sz.id_zooadmin,
            z.cod_zoo, 
            z.nombre_zoo, 
            zt.nom_zootanque, 
            tt.nomtiptan, 
            u.nombre_usu, 
            u.apellido_usu
        ORDER BY sza.fecha_actividad DESC";

        $ejecutar = pg_query_params($this->conexion, $sql, [$cod_segzooact]);
        if ($ejecutar) {
            return pg_fetch_assoc($ejecutar);
        }
    }

    protected function UpdateSeguimiento($datosSegZoo, $datosSegZooAct, $actividades, $cod_segzooact, $cod_segzoo)
    {
        try {
            pg_query($this->conexion, "BEGIN");

            // Parte de tblsegzooact_actividades

            $sql = "DELETE FROM tblsegzooact_actividades WHERE cod_segzooact = $cod_segzooact";
            $ejecucion = pg_query($this->conexion, $sql);
            if (!$ejecucion) {
                pg_query($this->conexion, "ROLLBACK");
                return false;
            }

            $errores = 0;
            foreach ($actividades as $cod_tipoactividadzoo) {
                $datosActividad = [
                    "cod_segzooact" => $cod_segzooact,
                    "cod_tipoactividadzoo" => $cod_tipoactividadzoo
                ];
                $sql2 = $this->objDB->Insert("tblsegzooact_actividades", $datosActividad);
                if (!$sql2) {
                    $errores++;
                }
            }

            // Parte de tblseguimientozoo y tblsegzooact

            $ejecucion2 = $this->objDB->Update("tblseguimientozoo", $datosSegZoo, ["cod_segzoo" => $cod_segzoo]);
            $ejecucion3 = $this->objDB->Update("tblsegzooact", $datosSegZooAct, ["cod_segzooact" => $cod_segzooact]);

            if ($errores == 0 && $ejecucion2 && $ejecucion3) {
                pg_query($this->conexion, "COMMIT");
                return true;
            } else {
                pg_query($this->conexion, "ROLLBACK");
                return false;
            }
        } catch (Exception $th) {
            pg_query($this->conexion, "ROLLBACK");
            throw $th;
        }
    }

    protected function CancelSeguimiento($datos, $cod)
    {
        return $this->objDB->Anular("tblsegzooact", $datos, $cod);
    }

    // Reportes

    protected function GetSeguimientosFiltrados($get)
    {
        $fecha_inicio = $get['fecha_inicio'] ?? null;
        $fecha_fin = $get['fecha_fin'] ?? null;
        $cod_zoo = $get['cod_zoo'] ?? null;
        $cod_tanque = $get['cod_tanque'] ?? null;

        $sql = "SELECT 
        sza.cod_segzooact, 
        sza.fecha_actividad, 
        sza.ph, 
        sza.temperatura, 
        sza.cloro,
        sza.alevines_nacimiento,
        sza.muerte_hembras,
        sza.muerte_machos,
        sza.observaciones,
        STRING_AGG(taz.nombre_actividad, ' - ' ORDER BY taz.nombre_actividad) as actividades,
        z.cod_zoo, 
        z.nombre_zoo, 
        zt.nom_zootanque as nombre_tanque, 
        tt.nomtiptan as tipo_tanque, 
        u.nombre_usu, 
        u.apellido_usu
        FROM tblsegzooact sza
        INNER JOIN tblsegzooact_actividades sa ON sa.cod_segzooact = sza.cod_segzooact
        INNER JOIN tbltipoactividadzoo taz ON sa.cod_tipoactividadzoo = taz.cod_tipoactividadzoo
        INNER JOIN tblseguimientozoo sz ON sz.cod_segzoo = sza.cod_segzoo
        INNER JOIN tblzoocriadero z ON z.cod_zoo = sz.cod_zoo
        INNER JOIN tblzootanque zt ON zt.cod_zootanque = sz.cod_zootanque
        INNER JOIN tblzooadmin za ON za.id_zooadmin = sz.id_zooadmin
        INNER JOIN tblusuarios u ON u.id_usuarios = za.id_usuarios
        INNER JOIN tbltipotanque tt ON tt.cod_tipotanque = zt.cod_tipotanque
        WHERE sza.cod_estado = 1";

        // Aplicar filtros dinámicamente
        if ($fecha_inicio) {
            $sql .= " AND sza.fecha_actividad >= '$fecha_inicio'";
        }
        if ($fecha_fin) {
            $sql .= " AND sza.fecha_actividad <= '$fecha_fin'";
        }
        if ($cod_zoo) {
            $sql .= " AND z.cod_zoo = $cod_zoo";
        }
        if ($cod_tanque) {
            $sql .= " AND zt.cod_zootanque = $cod_tanque";
        }

        $sql .= " GROUP BY 
        sza.cod_segzooact, 
        sza.fecha_actividad, 
        sza.ph, 
        sza.temperatura, 
        sza.cloro,
        sza.alevines_nacimiento,
        sza.muerte_hembras,
        sza.muerte_machos,
        sza.observaciones,
        z.cod_zoo, 
        z.nombre_zoo, 
        zt.nom_zootanque, 
        tt.nomtiptan, 
        u.nombre_usu, 
        u.apellido_usu
        ORDER BY sza.fecha_actividad DESC";

        $ejecutar = pg_query($this->conexion, $sql);
        if ($ejecutar) {
            return pg_fetch_all($ejecutar) ?: [];
        }
        return [];
    }
}

/* $obj = (new ModelZoo())->GetSeguimientos();
print_r($obj); */
