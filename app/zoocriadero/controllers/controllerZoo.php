<?php 

class ControllerZoo {

    public function vistaActual () {
        $vista = $_GET['view'];
        return $vista;
    }
}

?>