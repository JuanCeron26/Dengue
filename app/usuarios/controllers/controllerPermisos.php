<?php

include_once '../models/modelPermisos.php';

class Permisos extends ModelPermisos
{

    public function traerRoles()
    {
        $traer = $this->GetRoles();
        return $traer;
    }

    public function editarRol($post)
    {

        $id = [
            "cod_rol" => $post['id_rol']
        ];
        $datos = [
            "nombre_rol" => $post['nombre_rol']
        ];

        $editar = $this->UpdateRol($datos, $id);
        if ($editar) {
            return true;
        } else {
            return false;
        }
    }

    public function crearRol($post)
    {
        $datos = [
            "nombre_rol" => $post['nombreRol']
        ];

        $crear = $this->CreateRol($datos);
        if ($crear) {
            return true;
        } else {
            return false;
        }
    }

    public function anularRol($post)
    {
        $id = ["cod_rol" => (int)$post['id_rol']];

        $sql = $this->DeleteRol($id);
        if ($sql) {
            return true;
        } else {
            return false;
        }
    }
}
