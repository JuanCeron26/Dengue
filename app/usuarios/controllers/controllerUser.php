<?php

include_once '../models/modelUser.php';

class User extends modelUser
{

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

    public function traerRoles()
    {
        $roles = $this->GetRoles();
        return $roles;
    }

    public function traerSegmentos()
    {
        $segmentos = $this->GetSegmentos();
        return $segmentos;
    }
}
