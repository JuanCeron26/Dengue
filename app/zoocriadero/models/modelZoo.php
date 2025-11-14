<?php

class ModelZoo
{
    private $objDB;
    private $conexion;

    public function __construct()
    {
        $this->objDB = new BaseDatos("ceron123");
        $this->conexion = $this->objDB->conectar;
    }

    public function registrarZoo($post)
    {
        $direccion = $post["dir_tipo"] . " " . $post["dir_num1"] . $post["dir_letra1"] . " # " . $post["dir_num2"] . $post["dir_letra2"] . " - " . $post["dir_num3"] . $post["dir_letra3"];

        $tanques = isset($post["tanques"]) ? implode(",", $post["tanques"]) : "";

        $zoocriadero = [
            "nombre_zoo" => $post["nombre"],
            "direccion_zoo" => $direccion,
            "cod_barrio" => $post["barrio"]
        ];

        // Primero inserto el zoocriadero
        $this->objDB->Insert("tblzoocriadero", $zoocriadero);
    }

    public function seleccionarBarrios()
    {
        $sql = "SELECT cod_barrio, nombarrio FROM tblbarrios";
        $select = $this->conexion->prepare($sql);

        $ejecutar = $select->execute();
        if ($ejecutar) {
            return $select->fetchAll();
        } else {
            return false;
        }
    }
}
