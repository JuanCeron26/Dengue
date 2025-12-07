<?php 
include_once '../../../conexionBD/BaseDatos.php';

class modelAnular
{
    private $base;

    public function __construct()
    {
        $this->base= new BaseDatos("1234");
    }
}
?>