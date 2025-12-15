<?php
require_once '../../../conexionBD/BaseDatos.php';


class AsistenciaModel extends BaseDatos
{
    /**
     * Obtener todos los territorios
     */
    public function obtenerTerritorios()
    {
        $sql = "SELECT DISTINCT tp.cod_territorio, s.nombre_sitio
            FROM tblterritoriopriorizado tp
            JOIN tblsitioecosalud s ON tp.cod_sitioeco = s.cod_sitioeco
            ORDER BY s.nombre_sitio";

        $res = pg_query($this->conectar, $sql);

        $territorios = [];
        while ($row = pg_fetch_assoc($res)) {
            $territorios[] = $row;
        }
        return $territorios;
    }

    /**
     * Obtener actividades por territorio
     */
    public function obtenerActividades($cod_territorio)
    {
        $sql = "SELECT ca.cod_controlactividadeco,
                   a.cod_actividadeco,
                   a.nombre_actividad,
                   e.nom_etapa
            FROM tblcontrolactividad ca
            INNER JOIN tblactividadeseco a ON ca.cod_actividadeco = a.cod_actividadeco
            INNER JOIN tbletapas e ON a.cod_etapa = e.cod_etapa
            WHERE ca.cod_territorio = $1
            ORDER BY a.nombre_actividad";

        $res = pg_query_params($this->conectar, $sql, [$cod_territorio]);

        if (!$res) {
            throw new Exception('Error en la consulta: ' . pg_last_error($this->conectar));
        }

        $actividades = [];
        while ($row = pg_fetch_assoc($res)) {
            $actividades[] = $row;
        }
        return $actividades;
    }

    /**
     * Obtener participantes de un territorio
     */
    public function obtenerParticipantes($cod_territorio)
    {
        $sql = "SELECT 
                p.id_part,
                p.nom_part,
                p.ape_part,
                p.id_cedula,
                p.celular,
                
                CASE 
                    WHEN l.id_cedula IS NOT NULL THEN true
                    ELSE false
                END AS es_lider
            FROM tblparticipantes p
            INNER JOIN tblterprioparticipantes t 
                ON p.id_part = t.id_part
            LEFT JOIN tbllider l 
                ON l.id_cedula = p.id_cedula   -- <== Aquí comparamos las cédulas
            WHERE t.cod_territorio = $1
            ORDER BY p.nom_part, p.ape_part";

        $res = pg_query_params($this->conectar, $sql, [$cod_territorio]);

        $participantes = [];
        while ($row = pg_fetch_assoc($res)) {
            // Convertir "t"/"f" a boolean nativo
            $row['es_lider'] = ($row['es_lider'] === 't');
            $participantes[] = $row;
        }

        return $participantes;
    }


    /**
     * Verificar si ya existe un registro de asistencia
     */
    public function existeAsistencia($cod_controlactividadeco)
    {
        $sql = "SELECT cod_asistencia 
                FROM tblasistencia 
                WHERE cod_controlactividadeco = $1 
                LIMIT 1";

        $res = pg_query_params($this->conectar, $sql, [$cod_controlactividadeco]);

        if (pg_num_rows($res) > 0) {
            $row = pg_fetch_assoc($res);
            return $row['cod_asistencia'];
        }
        return null;
    }

    /**
     * Crear registro de asistencia principal
     */
    public function crearAsistencia($cod_controlactividadeco, $valor_asistencia)
    {
        $sql = "INSERT INTO tblasistencia (cod_controlactividadeco, valor_asistencia, fecha)
            VALUES ($1, $2, NOW())
            RETURNING cod_asistencia";

        $res = pg_query_params($this->conectar, $sql, [$cod_controlactividadeco, $valor_asistencia]);

        if ($res) {
            $row = pg_fetch_assoc($res);
            return $row['cod_asistencia'];
        }

        return null;
    }

    /**
     * Actualizar valor de asistencia
     */
    public function actualizarValorAsistencia($cod_asistencia, $valor_asistencia)
    {
        $sql = "UPDATE tblasistencia 
                SET valor_asistencia = $1, fecha = NOW()
                WHERE cod_asistencia = $2";

        return pg_query_params($this->conectar, $sql, [$valor_asistencia, $cod_asistencia]);
    }

    /**
     * Registrar asistencia de participante individual
     */
    public function registrarAsistenciaParticipante($cod_asistencia, $id_part, $valor_asistencia)
    {
        $sql = "INSERT INTO tblasistenciaparticipante 
            (cod_asistencia, id_part, valor_asistencia)
            VALUES ($1, $2, $3)";

        return pg_query_params($this->conectar, $sql, [$cod_asistencia, $id_part, $valor_asistencia]);
    }

    /**
     * Obtener asistencia registrada para una actividad
     */
    public function obtenerAsistenciaRegistrada($cod_controlactividadeco)
    {
        $sql = "SELECT ap.id_part, ap.valor_asistencia
                FROM tblasistencia a
                INNER JOIN tblasistenciaparticipante ap ON a.cod_asistencia = ap.cod_asistencia
                WHERE a.cod_controlactividadeco = $1";

        $res = pg_query_params($this->conectar, $sql, [$cod_controlactividadeco]);

        $asistencias = [];
        while ($row = pg_fetch_assoc($res)) {
            // Convertir 't'/'f' a boolean
            $asistencias[$row['id_part']] = ($row['valor_asistencia'] === 't' || $row['valor_asistencia'] === true || $row['valor_asistencia'] === '1' || $row['valor_asistencia'] == 1);
        }

        return $asistencias;
    }

    /**
     * Eliminar asistencias de participantes para volver a registrar
     */
    public function eliminarAsistenciasParticipantes($cod_asistencia)
    {
        $sql = "DELETE FROM tblasistenciaparticipante WHERE cod_asistencia = $1";
        return pg_query_params($this->conectar, $sql, [$cod_asistencia]);
    }
}
