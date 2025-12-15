<?php

include_once '../models/modelEcosalud.php';

class controllerEcosalud extends modelEcosalud
{

    public function RegistrarControlActividad($territorio, $actividad)
    {
        $cod_territorio = (int)$territorio;
        $cod_actividad = (int)$actividad; // puede ser 1, 2, 3, 4, 5, 6 o 7.

        return $this->InsertControlActividad($cod_territorio, $cod_actividad);
    }

    public function RegistrarTerritorio() {}

    // Funcion por si algo, por si necesito capturar directamente el cod_controlactividadeco
    public function CapturarCodControlActividad($territorio, $actividad)
    {
        $cod_territorio = (int)$territorio;
        $cod_actividad = (int)$actividad;

        return $this->GetCodControlActividad($cod_territorio, $cod_actividad);
    }

    // ETAPA 1
    public function TraerFocosPotencialesTerritorio()
    {
        return $this->GetFocosPotencialesTerritorio(); // estos son los encontrados por Ecosalud
    }

    // CONSULTAR

    public function TraerTerritorios()
    {
        return $this->GetTerritorios();
    }

    public function VerDetalleTerritorio($id)
    {
        $cod_territorio = (int)$id;
        return $this->GetDetalleTerritorio($cod_territorio);
    }

    public function VerDetalleParticipantes($id)
    {
        $cod_territorio = (int)$id;
        return $this->GetDetalleParticipantes($cod_territorio);
    }
}
