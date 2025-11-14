<?php

class BaseDatos
{
    private $user;
    private $password;
    private $dbname;
    private $host;
    public $conectar;

    public function __construct($contra = "")
    {
        try {
            $this->user = "postgres";
            $this->password = $contra;
            $this->dbname = "bd_dengue";
            $this->host = "localhost";

            $this->conectar = new PDO(
                "pgsql:host={$this->host};dbname={$this->dbname}",
                $this->user,
                $this->password
            );

            $this->conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            throw $error;
        }
    }

    function Insert($tabla, $datos)
    {

        $campos = implode(",", array_keys($datos));
        $valores = implode(",", array_values($datos));

        $sql = "INSERT INTO " . $tabla . " (";
        $sql .= $campos . ") VALUES (" . $valores . ")";

        $registrar = $this->conexion->prepare($sql);
        $registrar = $registrar->execute();
        if ($registrar) {
            return true;
        } else {
            return false;
        }
    }

    function Delete($tabla, $datos)
    {
        $campo = key($datos);
        $sql = "UPDATE " . $tabla . " WHERE " . $campo . " = " . $datos[0];
        $update = $this->conexion->prepare($sql);
        $update = $update->execute();
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    function Update($tabla, $datos, $id)
    {
        $campo_id = key($id);

        $sql = "UPDATE " . $tabla . " SET ";
        foreach ($datos as $campo => $valor) {
            $sql .= $campo . " = " . $valor;
            if ($valor != end($datos)) {
                $sql .= ", ";
            }
        }

        $sql .= "WHERE " . $campo_id . " = " . $id[0];
    }

    function Select($tabla, $columnas = false, $condiciones = [])
    {
        $sql = "SELECT ";
        if ($columnas == false) {
            $sql .= " * FROM " . $tabla;
        } else {
            $sql .= implode(",", $columnas) . " FROM " . $tabla;
        }

        if (isset($opciones["WHERE"])) {
            $whereParte = [];
            foreach ($opciones["WHERE"] as $col => $val) {
                if (is_array($val) && isset($val["LIKE"])) {
                    $whereParte[] = "$col LIKE '{$val["LIKE"]}'";
                } elseif (is_array($val) && isset($val["BETWEEN"])) {
                    $whereParte[] = "$col BETWEEN '{$val["BETWEEN"][0]}' AND '{$val["BETWEEN"][1]}'";
                } else {
                    $whereParte[] = "$col = '$val'";
                }
            }
            $sql .= " WHERE " . implode(" AND ", $wherePart);
        }

        if (isset($opciones["GROUP BY"])) {
            $sql .= " GROUP BY " . $opciones["GROUP BY"];
        }

        if (isset($opciones["ORDER BY"])) {
            $sql .= " ORDER BY " . $opciones["ORDER BY"];
        }

        if (isset($opciones["LIMIT"])) {
            $sql .= " LIMIT " . (int)$opciones["LIMIT"];
        }
    }

    function CerrarSesion()
    {
        session_destroy();
        $_SESSION = [];
        header("Location:../../login/index.php");
    }
}
/*
$condiciones = [
    "WHERE" => [
        "nombre_zoo" => "San Fernando",
        "ciudad" => ["LIKE" => "%Cali%"],
        "fecha_creacion" => ["BETWEEN" => ["2020-01-01", "2023-01-01"]]
    ],
    "GROUP BY" => "ciudad",
    "ORDER BY" => "nombre_zoo ASC",
    "LIMIT" => 10
];



echo isset($select);


$eliminar = [
    "cod_zoo" => 2,
];

$update = [
    "desc_zoo" => "Hola",
    "direccion_zoo" => "CALLE 90A"
];

$id = [
    "cod_zoo" => 2
];

echo end($update);
*/