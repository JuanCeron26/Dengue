<?php

include_once '../models/modelUser.php';

class User extends modelUser
{
    // Funciones para imprimir en las vistas
    public function traerUsuarios()
    {
        $usuarios = $this->GetUsuarios();
        return $usuarios;
    }

    public function traerTiposDocumento()
    {
        $tipos = $this->GetTipoDocumento();
        return $tipos;
    }

    public function traerUsuario($id)
    {
        $usuario = $this->GetUsuario($id);
        if ($usuario) {
            return $usuario;
        } else {
            return [
                "accion" => "fallo"
            ];
        }
    }

    public function traerPerfiles()
    {
        $perfiles = $this->GetPerfiles();
        return $perfiles;
    }

    // Funciones de CRUD

    public function registrarUsuario($post)
    {
        $datos = [
            "cod_tipodocum" => $post['tipo_documento'],
            "cod_permiso" => $post['perfil'],
            "nombre_usu" => $post['nombre'],
            "apellido_usu" => $post['apellido'],
            "id_cedula" => $post['numero_documento'],
            "correo_electronico" => $post['correo'],
            "contraseña" => $post['password'],
            "cod_estado" => 1
        ];

        $registrar = $this->InsertUsuario($datos);
        if ($registrar) {
            return "exito";
        } else {
            return "fallo";
        }
    }

    public function editarUsuario($post)
    {
        $id = $post['idUsuario'];

        $datos = [
            "cod_tipodocum" => $post['tipoDocUsuario'],
            "cod_permiso" => $post['perfilUsuario'],
            "nombre_usu" => $post['nombreUsuario'],
            "apellido_usu" => $post['apellidoUsuario'],
            "id_cedula" => $post['idCedulaUsuario'],
            "correo_electronico" => $post['correoUsuario']
        ];

        $editar = $this->UpdateUsuario($id, $datos);
        if ($editar) {
            return "exito";
        } else {
            return "fallo";
        }
    }

    public function eliminarUsuario($post)
    {
        $id = (int)$post['id_user'];
        $eliminar = $this->DeleteUser($id);
        if ($eliminar) {
            return "exito";
        } else {
            return "fallo";
        }
    }
}
