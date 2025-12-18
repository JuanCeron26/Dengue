<?php

require '../../../conexionBD/BaseDatos.php';


class actividadesTrabajoCampo extends BaseDatos
{


    //consultas genericas para mostrar en el formulario


    public function ConsultarBarrios()
    {
        return $this->Select("tblbarrios", ["cod_barrio", "nombarrio"]);
    }
    public function ConsultarUsuarios()
    {
        return $this->Select("tblusuarios", ["id_usuarios", "nombre_usu", "apellido_usu"]);
    }

    public function ConsultarTiposDepositos()
    {
        return $this->Select("tbltipodeposito", ["cod_tipo_depo", "nombre_deposito"]);
    }

    public function Tipoactividad()
    {
        return $this->Select("tblactcampo", ["cod_act_campo", "nombre_actividad"]);
    }

    public function Sitios()
    {
        return $this->Select("tblsitiocontrolbiologico", ["cod_sitiocontrolbiolo", "nombre_sitio"]);
    }
    public function BuscarSitioTipoDepo($deposito, $sitio)
    {
        $deposito = intval($deposito);
        $sitio    = intval($sitio);

        $sql = "SELECT cod_sitiodepo 
            FROM tblsitiodepo 
            WHERE cod_tipo_depo = $deposito 
              AND cod_sitiocontrolbiolo = $sitio
            LIMIT 1";

        $res = pg_query($this->conectar, $sql);

        if ($res && pg_num_rows($res) > 0) {
            $row = pg_fetch_assoc($res);
            return $row['cod_sitiodepo'];
        }

        return null;
    }


    public function Insert($tabla, $datos)
    {
        $campos = array_keys($datos);
        $valores = array_values($datos);

        // Generamos: $1, $2, ...
        $placeholders = [];
        for ($i = 1; $i <= count($datos); $i++) {
            $placeholders[] = '$' . $i;
        }

        // OJO: el campo autoincremental en tu tabla se llama:
        // id_tblactividad, cod_actividadtrabajocampo, id, etc.
        // Pon el nombre REAL:
        $sql = "INSERT INTO $tabla (" . implode(",", $campos) . ") 
            VALUES (" . implode(",", $placeholders) . ")
            RETURNING cod_actividadtrabajocampo";

        $result = pg_query_params($this->conectar, $sql, $valores);

        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['cod_actividadtrabajocampo']; // ID real que autogenera Postgres
        }

        return false;
    }




    // Verificar si ya existe la relaciÃ³n sitioâ€“tipo de depÃ³sito

    public function ObtenerIdSitioTipoDepo($cod_sitio, $cod_tipo_depo)
    {
        $sql = "SELECT cod_sitiodepo FROM tblsitiodepo WHERE cod_sitiocontrolbiolo = $1 AND cod_tipo_depo = $2";
        $res = pg_query_params($this->conectar, $sql, [$cod_sitio, $cod_tipo_depo]);
        if (!$res) {
            throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
        }
        if ($row = pg_fetch_assoc($res)) {
            return $row['cod_sitiodepo'];
        }
        return false;
    }


    // Insertar nueva relaciÃ³n sitioâ€“tipo de depÃ³sito
    public function InsertSitioTipoDepo($cod_tipo_depo, $cod_sitio)
    {
        $sql = "INSERT INTO tblsitiodepo(cod_tipo_depo,cod_sitiocontrolbiolo) VALUES ($1, $2) RETURNING cod_sitiodepo";
        $res = pg_query_params($this->conectar, $sql, [$cod_tipo_depo, $cod_sitio]);
        if (!$res) {
            throw new Exception("Error al insertar: " . pg_last_error($this->conectar));
        }
        $row = pg_fetch_assoc($res);
        return $row['cod_sitiodepo'];
    }

    public function ConsultarActividades()
    {

        $sql = "SELECT 
            ac.cod_actividadtrabajocampo,
            ac.cod_act_campo,                 -- Tipo de actividad: 1=Siembra, 4=InspecciÃ³n, etc.
            ac.cod_actividad_padre, 
            ac.cod_sitiodepo,
          -- ID de la inspecciÃ³n asociada (si es siembra)
            tac.nombre_actividad,
            b.nombarrio,
            si.nombre_sitio,
            r.nombre_responsable || ' ' || r.apellido_responsable AS responsable,
            ac.positivo_larvas_aedes,
            ac.positivo_pupas,
            ac.positivo_culex,
            ac.ph,
            u.nombre_usu || ' ' || u.apellido_usu AS usuario,
            ac.adultos_guppies,
            ac.alevines_guppies,
            ti.nombre_deposito,
            ac.temperatura,
            ac.peces_muertos,
            ac.cloro,
            ac.ancho_deposito,
            ac.largo_deposito,
            ac.profundidad_deposito,
            ac.observaciones,
            ac.fecha_actividad
        FROM tblactividadtrabajcampo ac
        JOIN tblactcampo tac ON ac.cod_act_campo = tac.cod_act_campo
        JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
        JOIN tblsitiocontrolbiologico si ON st.cod_sitiocontrolbiolo = si.cod_sitiocontrolbiolo
        JOIN tblbarrios b ON b.cod_barrio = si.cod_barrio
        JOIN tblresponsablesitio r ON r.id_responsable = si.id_responsable
        JOIN tbltipodeposito ti ON ti.cod_tipo_depo = st.cod_tipo_depo
        JOIN tblusuactrabajocampo uac ON uac.cod_actividadtrabajocampo = ac.cod_actividadtrabajocampo
        JOIN tblusuarios u ON u.id_usuarios = uac.id_usuarios
        where ac.cod_estado = 1
        ORDER BY  ac.fecha_actividad DESC";


        $res = pg_query($this->conectar, $sql);



        if (!$res) {
            return []; // evita errores
        }

        return pg_fetch_all($res);
    }

    public function ObtenerIdInspeccion($cod_sitiodepo, $fecha, $cod_actividadtrabajocampo)
    {
        $sql = "SELECT cod_actividadtrabajocampo FROM tblactividadtrabajcampo 
            WHERE cod_sitiodepo = $1 AND fecha_actividad = $2 AND cod_act_campo = $3 
            ORDER BY cod_act_campo DESC LIMIT 1";
        $res = pg_query_params($this->conectar, $sql, [$cod_sitiodepo, $fecha, $cod_actividadtrabajocampo]);

        if (!$res) {
            throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
        }

        if ($row = pg_fetch_assoc($res)) {
            return $row['cod_actividadtrabajocampo']; // este es el ID de la inspecciÃ³n
        }

        return false;
    }



    public function AnularActividad($data)
    {
        // Tabla principal
        $tabla = "tblactividadtrabajcampo";

        // ID que viene del formulario
        $id = $data["id_actividad"];

        // Datos a actualizar
        $updateData = ["cod_estado" => 2];

        // Condiciones: solo si cod_estado = 1
        $condiciones = ["cod_actividadtrabajocampo" => $id, "cod_estado" => 1];


        $ok = $this->Update($tabla, $updateData, $condiciones);

        return $ok
            ? ["success" => true, "mensaje" => "Actividad anulada correctamente"]
            : ["error" => "No se pudo anular la actividad. Puede que ya estÃ© anulada o no exista"];
    }
    public function EditarTransaccional($dataActividad, $dataSitio, $idActividad, $idSitio)
    {
        try {
            pg_query($this->conectar, "BEGIN");

            // 1. ACTUALIZAR tblsitiodepo (solo si hay datos)
            if (!empty($dataSitio) && !empty($idSitio)) {
                $okSitio = $this->Update(
                    "tblsitiodepo",
                    $dataSitio,
                    ["cod_sitiodepo" => $idSitio]
                );

                if (!$okSitio) {
                    pg_query($this->conectar, "ROLLBACK");
                    return ["success" => false, "error" => "No se pudo actualizar el sitio/depósito"];
                }
            }

            // 2. ACTUALIZAR tblactividadtrabajcampo (actividad principal)
            if (!empty($dataActividad)) {
                $okAct = $this->Update(
                    "tblactividadtrabajcampo",
                    $dataActividad,
                    ["cod_actividadtrabajocampo" => $idActividad]
                );

                if (!$okAct) {
                    pg_query($this->conectar, "ROLLBACK");
                    return ["success" => false, "error" => "No se pudo actualizar la actividad"];
                }
            }

            pg_query($this->conectar, "COMMIT");
            return ["success" => true, "mensaje" => "Registro actualizado correctamente"];
        } catch (Exception $e) {
            pg_query($this->conectar, "ROLLBACK");
            return ["success" => false, "error" => "Error transaccional: " . $e->getMessage()];
        }
    }

    public function ObtenerDatosActividad($idActividad)
    {
        $sql = "SELECT 
                ac.cod_actividadtrabajocampo,
                ac.cod_act_campo,
                ac.cod_actividad_padre,
                ac.cod_sitiodepo,
                ac.positivo_larvas_aedes,
                ac.positivo_pupas,
                ac.positivo_culex,
                ac.ph,
                ac.adultos_guppies,
                ac.alevines_guppies,
                ac.temperatura,
                ac.peces_muertos,
                ac.cloro,
                ba.nombarrio,
                co.nomcomun,
                ac.ancho_deposito,
                ac.largo_deposito,
                ac.profundidad_deposito,
                ac.observaciones,
                ac.fecha_actividad,
                st.cod_tipo_depo,
                st.cod_sitiocontrolbiolo
            FROM tblactividadtrabajcampo ac
            JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
            JOIN tblbarrios ba ON ba.cod_barrio=ac.cod_barrio
            JOIN tblcomuna co ON co.cod_comun=ba.cod_comun
            WHERE ac.cod_actividadtrabajocampo = $1";

        $res = pg_query_params($this->conectar, $sql, [$idActividad]);

        if (!$res) {
            throw new Exception("Error en la consulta: " . pg_last_error($this->conectar));
        }

        return pg_fetch_assoc($res);
    }
    public function ReportesdeActividad($idActividad)
    {
        $sql = "SELECT 
                -- Datos de la actividad actual
                ac.cod_actividadtrabajocampo,
                ac.cod_act_campo,
                tac.nombre_actividad AS tipo_actividad,
                ac.cod_actividad_padre, 
                ac.cod_sitiodepo,

                -- Datos del sitio
                b.nombarrio,
                co.nomcomun,
                si.nombre_sitio,
                r.nombre_responsable || ' ' || r.apellido_responsable AS responsable,

                -- Depósito
                ti.nombre_deposito,

                -- Datos propios de la actividad
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
                ac.fecha_actividad,

                -- Usuario que la registró
                u.nombre_usu || ' ' || u.apellido_usu AS usuario_registro,

                -- Datos del padre
                padre.cod_act_campo AS tipo_padre,
                padre.fecha_actividad AS fecha_padre,
                padre.observaciones AS observaciones_padre,

                -- Datos técnicos del padre
                padre.positivo_larvas_aedes AS padre_larvas,
                padre.positivo_pupas AS padre_pupas,
                padre.positivo_culex AS padre_culex,
                padre.ph AS padre_ph,
                padre.cloro AS padre_cloro,
                padre.temperatura AS padre_temperatura,
                padre.ancho_deposito AS padre_ancho,
                padre.largo_deposito AS padre_largo,
                padre.profundidad_deposito AS padre_profundidad

            FROM tblactividadtrabajcampo ac

            JOIN tblactcampo tac ON ac.cod_act_campo = tac.cod_act_campo
            JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
            JOIN tblsitiocontrolbiologico si ON st.cod_sitiocontrolbiolo = si.cod_sitiocontrolbiolo
            JOIN tblbarrios b ON b.cod_barrio = si.cod_barrio
            JOIN tblcomuna co ON co.cod_comun = b.cod_comun
            JOIN tblresponsablesitio r ON r.id_responsable = si.id_responsable
            JOIN tbltipodeposito ti ON ti.cod_tipo_depo = st.cod_tipo_depo

            -- Usuario de la actividad
            LEFT JOIN tblusuactrabajocampo uac ON uac.cod_actividadtrabajocampo = ac.cod_actividadtrabajocampo
            LEFT JOIN tblusuarios u ON u.id_usuarios = uac.id_usuarios

            -- Unión del padre
            LEFT JOIN tblactividadtrabajcampo padre 
                ON padre.cod_actividadtrabajocampo = ac.cod_actividad_padre

            WHERE ac.cod_actividadtrabajocampo = $1";

        $res = pg_query_params($this->conectar, $sql, [$idActividad]);

        if (!$res) {
            throw new Exception("Error en la consulta ReportesdeActividad: " . pg_last_error($this->conectar));
        }

        return pg_fetch_assoc($res);
    }


    public function ObtenerActividadRaiz($idActividad)
    {
        $sql = "SELECT 
                CASE 
                    WHEN cod_actividad_padre IS NULL OR cod_actividad_padre = 0 
                        THEN cod_actividadtrabajocampo
                    ELSE cod_actividad_padre
                END AS raiz
            FROM tblactividadtrabajcampo
            WHERE cod_actividadtrabajocampo = $1";

        $res = pg_query_params($this->conectar, $sql, [$idActividad]);

        if (!$res) {
            throw new Exception("Error obteniendo raíz: " . pg_last_error($this->conectar));
        }

        $row = pg_fetch_assoc($res);
        return $row["raiz"];
    }


    public function ExisteInspeccion($cod_sitiodepo, $cod_act_campo)
    {
        $sql = "SELECT 1 
            FROM tblactividadtrabajcampo
            WHERE cod_sitiodepo = $cod_sitiodepo
            AND cod_act_campo = $cod_act_campo
            AND cod_estado = 1
            LIMIT 1";

        $res = pg_query($this->conectar, $sql);

        if (!$res) {
            return false; // Si hay error, no bloqueamos pero registramos luego
        }

        return pg_fetch_row($res) ? true : false;
    }
    public function FiltrarActividades($fecha, $sitio, $actividad)
    {

        $sql = "SELECT 
                ac.cod_actividadtrabajocampo,
                ac.cod_act_campo,
                ac.cod_actividad_padre,
                ac.cod_sitiodepo,
                tac.nombre_actividad,
                b.nombarrio,
                si.nombre_sitio,
                r.nombre_responsable || ' ' || r.apellido_responsable AS responsable,
                ac.positivo_larvas_aedes,
                ac.positivo_pupas,
                ac.positivo_culex,
                ac.ph,
                u.nombre_usu || ' ' || u.apellido_usu AS usuario,
                ac.adultos_guppies,
                ac.alevines_guppies,
                ti.nombre_deposito,
                ac.temperatura,
                ac.peces_muertos,
                ac.cloro,
                ac.ancho_deposito,
                ac.largo_deposito,
                ac.profundidad_deposito,
                ac.observaciones,
                ac.fecha_actividad
            FROM tblactividadtrabajcampo ac
            JOIN tblactcampo tac ON ac.cod_act_campo = tac.cod_act_campo
            JOIN tblsitiodepo st ON ac.cod_sitiodepo = st.cod_sitiodepo
            JOIN tblsitiocontrolbiologico si ON st.cod_sitiocontrolbiolo = si.cod_sitiocontrolbiolo
            JOIN tblbarrios b ON b.cod_barrio = si.cod_barrio
            JOIN tblresponsablesitio r ON r.id_responsable = si.id_responsable
            JOIN tbltipodeposito ti ON ti.cod_tipo_depo = st.cod_tipo_depo
            JOIN tblusuactrabajocampo uac ON uac.cod_actividadtrabajocampo = ac.cod_actividadtrabajocampo
            JOIN tblusuarios u ON u.id_usuarios = uac.id_usuarios
            WHERE ac.cod_estado = 1";

        // ============================
        // AGREGAR FILTROS DINÁMICOS
        // ============================

        if (!empty($fecha)) {
            $sql .= " AND ac.fecha_actividad = '$fecha'";
        }

        if (!empty($sitio)) {
            // sitio = cod_sitiocontrolbiolo
            $sql .= " AND si.cod_sitiocontrolbiolo = '$sitio'";
        }

        if (!empty($actividad)) {
            // actividad = cod_act_campo
            $sql .= " AND ac.cod_act_campo = '$actividad'";
        }

        $sql .= " ORDER BY ac.fecha_actividad DESC";

        $res = pg_query($this->conectar, $sql);

        if (!$res) {
            return [];
        }

        return pg_fetch_all($res);
    }
}
