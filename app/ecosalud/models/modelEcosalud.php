<?php

include_once '../../../conexionBD/BaseDatos.php';

class modelEcosalud
{
    private $conexion;
    private $objDB;

    public function __construct()
    {
        $this->objDB = new BaseDatos("ceron123");
        $this->conexion = $this->objDB->conectar;
    }

    
    protected function InsertControlActividad($cod_territorio, $actividad)
    {
        $sql = "INSERT INTO tblcontrolactividad (cod_territorio, cod_actividadeco)
        VALUES ($1, $2) RETURNING cod_controlactividadeco";

        $ejec = pg_query_params($this->conexion, $sql, [$cod_territorio, $actividad]);
        if ($ejec) {
            $fila = pg_fetch_assoc($ejec); // aquí esta el: ["cod_controlactividadeco"]
            return [
                "success" => true,
                "cod_controlactividad" => $fila["cod_controlactividadeco"]
            ];
        }
    }

    protected function GetCodControlActividad($cod_territorio, $cod_actividad)
    {
        $sql = "SELECT cod_controlactividadeco FROM tblcontrolactividad
        WHERE cod_territorio = $cod_territorio AND cod_actividadeco = $cod_actividad";

        $ejec = pg_query($this->conexion, $sql);
        if ($ejec) {
            return pg_fetch_assoc($ejec);
        }
    }

    // ETAPA 1
    protected function RegistrarTerritorio()
    {
        $sql = "territorio + lider";
        try {
            pg_query($this->conexion, "BEGIN");

            $ejec = $this->objDB->Insert("tblcontrolactividad", $sql);
        } catch (Exception $th) {
            throw $th;
        }
    }

    protected function GetFocosPotencialesTerritorio()
    {
        $sql = "SELECT * FROM tblfocopotenciallugar WHERE realizo = 'Equipo Ecosalud'";
        $ejec = pg_query($this->conexion, $sql);

        return pg_fetch_all($ejec);
    }

    // CONSULTAR

    protected function GetTerritorios()
    {
        $sql = "SELECT tp.cod_territorio, s.nombre_sitio, b.nombarrio
            FROM tblterritoriopriorizado tp
            INNER JOIN tblsitioecosalud s ON tp.cod_sitioeco = s.cod_sitioeco
            INNER JOIN tblbarrios b ON s.cod_barrio = b.cod_barrio";

        $ejec = pg_query($this->conexion, $sql);
        return pg_fetch_all($ejec);
    }

    protected function GetDetalleTerritorio($cod_territorio)
    {
        $sql = "SELECT 
                t.cod_territorio,
                t.fecha_registro,
                s.cod_sitioeco,
                s.nombre_sitio,
                s.direccion AS direccion_sitio,
                s.cod_estadositioeco,
                b.cod_barrio,
                b.nombarrio,
                l.id_lider,
                l.nombre_lider,
                l.apellido_lider,
                l.correo_lider,
                l.celular AS celular_lider
            FROM tblterritoriopriorizado t
            INNER JOIN tbllider l 
                ON l.id_lider = t.id_lider
            INNER JOIN tblsitioecosalud s 
                ON s.cod_sitioeco = t.cod_sitioeco
            LEFT JOIN tblbarrios b 
                ON b.cod_barrio = s.cod_barrio

            WHERE t.cod_territorio = $1
            LIMIT 1";

        $ejec = pg_query_params($this->conexion, $sql, [$cod_territorio]);
        return pg_fetch_assoc($ejec);
    }

    protected function GetDetalleParticipantes($cod_territorio)
    {
        $sql = "SELECT 
                p.id_part,
                p.nom_part,
                p.ape_part,
                p.id_cedula,
                p.celular
            FROM tblterprioparticipantes t
            INNER JOIN tblparticipantes p ON p.id_part = t.id_part
            WHERE t.cod_territorio = $1
            ORDER BY p.nom_part ASC";

        $ejec = pg_query_params($this->conexion, $sql, [$cod_territorio]);
        return pg_fetch_all($ejec);
    }
}
