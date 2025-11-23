<?php

class BaseDatos
{
    private $user;
    private $password;
    private $dbname;
    private $host;
    private $port;
    public $conectar;

    public function __construct($contra = "")
    {
        $this->user = 'postgres';
        $this->password = $contra;
        $this->dbname = 'bd_dengue';
        $this->port = '5432';
        $this->host = 'localhost';

        $cadena = "host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->password";
        $this->conectar = pg_connect($cadena);

        if (!$this->conectar) {
            die("Error de conexión a PostgreSQL");
        }
    }

    public function Insert($tabla, $datos)
    {
        // Campos: nombre, correo
        $campos = array_keys($datos);

        // Valores: ['Juan', 'a@a.com']
        $valores = array_values($datos);

        // $1, $2, $3...
        $placeholders = [];
        for ($i = 1; $i <= count($datos); $i++) {
            $placeholders[] = '$' . $i;
        }

        $sql = "INSERT INTO $tabla (" . implode(",", $campos) . ") 
            VALUES (" . implode(",", $placeholders) . ")";

        $result = pg_query_params($this->conectar, $sql, $valores);

        return $result ? true : false;
    }

    public function InsertReturning($tabla, $datos, $campoRetornar)
    {
        // Campos: nombre, correo
        $campos = array_keys($datos);

        // Valores: ['Juan', 'a@a.com']
        $valores = array_values($datos);

        // $1, $2, $3...
        $placeholders = [];
        for ($i = 1; $i <= count($datos); $i++) {
            $placeholders[] = '$' . $i;
        }

        $sql = "INSERT INTO $tabla (" . implode(",", $campos) . ") 
            VALUES (" . implode(",", $placeholders) . ")
            RETURNING $campoRetornar";

        $result = pg_query_params($this->conectar, $sql, $valores);

        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row[$campoRetornar]; // Retorna el ID generado
        }

        return false;
    }


    public function Delete($tabla, $datos)
    {
        $campo = key($datos);
        $valor = $datos[$campo];

        $sql = "DELETE FROM $tabla WHERE $campo = $1";

        $result = pg_query_params($this->conectar, $sql, [$valor]);

        return $result ? true : false;
    }

    public function Anular($tabla, $datos, $cod)
    {
        $campo = key($datos);
        $valor = $datos[$campo];
        $pk = key($cod);

        $sql = "UPDATE $tabla SET $campo = $valor WHERE $pk = $1";

        $result = pg_query_params($this->conectar, $sql, [$cod[$pk]]);

        return $result ? true : false;

        /*
        $datos = [
        "cod_estado" => 2
        ] 
        
        $cod = [
        "cod_segzooact" => $id  -> el id de la fila que quiero editar
        ]
        */
    }


    public function Update($tabla, $datos, $id)
    {
        $campo_id = key($id);
        $valor_id = $id[$campo_id];

        $set = [];
        $valores = [];

        $i = 1;
        foreach ($datos as $campo => $valor) {
            $set[] = "$campo = $$i";
            $valores[] = $valor;
            $i++;
        }

        // Añadir el valor del ID como último parámetro
        $valores[] = $valor_id;

        $sql = "UPDATE $tabla SET " . implode(", ", $set) . " 
            WHERE $campo_id = $" . $i;

        $result = pg_query_params($this->conectar, $sql, $valores);

        return $result ? true : false;
    }


    public function Select($tabla, $columnas = ["*"], $condiciones = [])
    {
        $sql = "SELECT " . implode(",", $columnas) . " FROM $tabla";

        $params = [];
        $whereParts = [];
        $i = 1;

        $orderBy = "";
        $orderDir = "ASC";

        foreach ($condiciones as $campo => $valor) {

            if (is_array($valor) && isset($valor["ORDER"])) {
                $orden = strtoupper($valor["ORDER"]);
                $orderBy = $campo;
                $orderDir = ($orden === "DESC") ? "DESC" : "ASC";
                continue; // saltamos para no meter en WHERE
            }

            // LIKE
            if (is_array($valor) && isset($valor["LIKE"])) {
                $whereParts[] = "$campo LIKE $$i";
                $params[] = $valor["LIKE"];
            }
            // BETWEEN
            elseif (is_array($valor) && isset($valor["BETWEEN"])) {
                $whereParts[] = "$campo BETWEEN $$i AND $" . ($i + 1);
                $params[] = $valor["BETWEEN"][0];
                $params[] = $valor["BETWEEN"][1];
                $i++;
            }
            // Igualdad normal
            else {
                $whereParts[] = "$campo = $$i";
                $params[] = $valor;
            }

            $i++;
        }

        if (!empty($whereParts)) {
            $sql .= " WHERE " . implode(" AND ", $whereParts);
        }

        // ORDER si se definió
        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy $orderDir";
        }

        $result = pg_query_params($this->conectar, $sql, $params);
        return pg_fetch_all($result);
    }
}
/*
////////  1. Conectarse a la base de datos: ///////////

    $obj = new BaseDatos("ceron123");

////////  2. INSERT: /////////////////

    $obj->Insert("tblzoocriadero", [
        "cod_zoo" => 1,
        "nom_zoo" => "El pondaje",
        "dir_zoo"   => "$direccion"
    ]);

//////// 3. DELETE: /////////////////

    $obj->Delete("tblusuarios", [
        "id_usuarios" => 10
    ]);

/////// 4. UPDATE //////////////////

    $db->Update("tblusuarios",
        [
            "nombre_usu" => "Carlos Núñez",
            "contraseña_usu" => "1234"
        ],
        [  
        "id" => 3  // El id del usuario que vamos a modificar.
        ]
    );

//////// 5. SELECT ///////////////////////

    - Si van a seleccionar TODO de alguna tabla:
    $resultado = $obj->Select("tblusuarios");


    - Si van a seleccionar ALGUNAS columnas o campos de alguna tabla:
    $resultado = $obj->Select("tblusuarios", ["id_usuarios", "nombre_usu"]);


*/
