<?php

class ControllerZoo extends ModelZoo
{

    public function vistaActual()
    {
        $vista = $_GET['view'] ?? '';
        return $vista;
    }

    public function traerBarrios() {
        $traer = $this->seleccionarBarrios();
        return $traer;
    }
}
