<?php
require '../../../conexionBD/BaseDatos.php';

class Participantes extends BaseDatos
{

    /* ============================================================
       INSERTAR PARTICIPANTE NORMAL (YA NO REVISA NI REGISTRA LÍDER)
       ============================================================ */
    public function InsertarParticipante($tabla, $datos)
    {
        $campos = array_keys($datos);
        $valores = array_values($datos);

        $placeholders = [];
        for ($i = 1; $i <= count($datos); $i++) {
            $placeholders[] = '$' . $i;
        }

        $sql = "INSERT INTO $tabla (" . implode(",", $campos) . ") 
                VALUES (" . implode(",", $placeholders) . ")
                RETURNING id_part";

        $result = pg_query_params($this->conectar, $sql, $valores);

        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['id_part'];
        }
        return false;
    }

    /* ============================================================
       ASOCIAR PARTICIPANTE A TERRITORIO
       ============================================================ */
    public function InsertTerritorioParticipantes($cod_territorio, $id_part)
    {
        $sql = "INSERT INTO tblterprioparticipantes(cod_territorio, id_part) 
                VALUES ($1, $2) 
                RETURNING cod_terrparticipante";

        $res = pg_query_params($this->conectar, $sql, [$cod_territorio, $id_part]);

        if (!$res) {
            throw new Exception("Error al insertar territorio: " . pg_last_error($this->conectar));
        }

        $row = pg_fetch_assoc($res);
        return $row['cod_terrparticipante'];
    }

    /* ============================================================
       NUEVO MÉTODO: REGISTRA SOLO PARTICIPANTE
       ============================================================ */
    public function registrarSoloParticipante($dataParticipante, $cod_territorio)
    {
        try {

            // 1. Insertar participante
            $id_part = $this->InsertarParticipante("tblparticipantes", $dataParticipante);

            if (!$id_part) {
                return ["success" => false, "message" => "❌ Error al insertar participante"];
            }

            // 2. Asociarlo al territorio
            $idTerritorio = $this->InsertTerritorioParticipantes($cod_territorio, $id_part);

            if (!$idTerritorio) {
                return ["success" => false, "message" => "❌ Error al asociar al territorio"];
            }

            return [
                "success" => true,
                "message" => "🎉 Participante registrado correctamente",
                "id_part" => $id_part
            ];
        } catch (Exception $e) {
            return ["success" => false, "message" => "❌ Error: " . $e->getMessage()];
        }
    }
}
