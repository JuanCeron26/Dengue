<?php

include_once '../models/modelSegZoo.php';

class controllerZoo extends ModelZoo
{

    public function traerZoocriaderos()
    {
        $traer = $this->GetZoocriaderos();
        return $traer;
    }

    public function traerTanques($cod_zoo)
    {
        $traer = $this->GetTanques($cod_zoo);
        return $traer;
    }

    public function traerOperarios($cod_zoo)
    {
        $traer = $this->GetOperarios($cod_zoo);
        return $traer;
    }

    public function traerActividades()
    {
        $traer = $this->GetActividades();
        return $traer;
    }

    public function RegistrarSeguimiento($post)
    {
        // Validar que vengan actividades
        if (!isset($post['actividades']) || empty($post['actividades'])) {
            echo json_encode(['error' => 'Debe seleccionar al menos una actividad']);
            return;
        }

        // ============================================================
        // PASO 1: Insertar en tblseguimientozoo (tabla principal)
        // ============================================================
        $datosSeguimientoZoo = [
            "cod_zootanque" => $post['cod_tanque'],
            "id_zooadmin" => $post['operario'],
            "cod_zoo" => $post['cod_zoocriadero']
        ];

        $cod_segzoo = $this->InsertarSeguimientoZooPrincipal($datosSeguimientoZoo);

        if (!$cod_segzoo) {
            echo json_encode(['error' => 'Error al registrar el seguimiento principal']);
            return;
        }

        // ============================================================
        // PASO 2: Insertar en tblsegzooact (datos del seguimiento)
        // ============================================================
        $datosSegZooAct = [
            "cod_segzoo" => $cod_segzoo,
            "fecha_actividad" => (!empty($post['fecha_actividad'])) ? $post['fecha_actividad'] : date('Y-m-d'),
            "ph" => !empty($post['ph']) ? $post['ph'] : null,
            "temperatura" => !empty($post['temperatura']) ? $post['temperatura'] : null,
            "cloro" => !empty($post['cloro']) ? $post['cloro'] : null,
            "alevines_nacimiento" => !empty($post['alevines_nacimiento']) ? $post['alevines_nacimiento'] : 0,
            "muerte_hembras" => !empty($post['muerte_hembras']) ? $post['muerte_hembras'] : 0,
            "muerte_machos" => !empty($post['muerte_machos']) ? $post['muerte_machos'] : 0,
            "observaciones" => !empty($post['observaciones']) ? $post['observaciones'] : '',
            "cod_estado" => 1
        ];

        $cod_segzooact = $this->InsertarActividadZoo($datosSegZooAct);

        if (!$cod_segzooact) {
            echo json_encode(['error' => 'Error al registrar los datos de seguimiento']);
            return;
        }

        // ============================================================
        // PASO 3: Insertar las actividades en tabla tbl_segzooact_actividades
        // ============================================================
        $errores = 0;
        foreach ($post['actividades'] as $cod_actividad) {
            if (!$this->InsertarActividadRelacion($cod_segzooact, $cod_actividad)) {
                $errores++;
            }
        }

        // ============================================================
        // PASO 4: Responder
        // ============================================================
        if ($errores === 0) {
            echo 'exito';
        } else {
            echo json_encode(['error' => 'Algunas actividades no se pudieron registrar']);
        }
    }

    public function traerSeguimientos()
    {
        return $this->GetSeguimientos();
    }

    public function traerSeguimientoById($cod_segzooact)
    {
        $codigo = (int)$cod_segzooact;
        return $this->GetSeguimientoById($codigo);
    }

    public function EditarSeguimiento($post)
    {
        /*
        $datos = [
            "cod_zoo" => $post['cod_zoocriadero'], // tblseguimientozoo
            "fecha_actividad" => $post['fecha_actividad'], //tblsegzooact
            "cod_zootanque" => $post['cod_tanque'], // tblseguimientozoo y tblzootanque
            "ph" => $post['ph'],
            "temperatura" => $post['temperatura'],
            "cloro" => $post['cloro'],
            "alevines_nacimiento" => $post['alevines_nacimiento'],
            "muerte_hembras" => $post['muerte_hembras'],
            "muerte_machos" => $post['muerte_machos'],
            "actividades" => $post['actividades[]'], // actividades...
            "observaciones" => $post['observaciones'],
            "id_zooadmin" => (int)$post['operario']
        ]; */

        // Cambios en la tblsegzooact
        $cod_segzooact = $post['cod_segzooact']; // tambien usarlo en tblsegzooact_actividades
        $datosSegZooAct = [
            "fecha_actividad" => $post['fecha_actividad'],
            "ph" => $post['ph'],
            "temperatura" => $post['temperatura'],
            "cloro" => $post['cloro'],
            "alevines_nacimiento" => $post['alevines_nacimiento'],
            "muerte_hembras" => $post['muerte_hembras'],
            "muerte_machos" => $post['muerte_machos'],
            "observaciones" => $post['observaciones']
        ];

        // Cambios en la tblseguimientozoo
        $cod_segzoo = $post['cod_segzoo'];
        $datosSegZoo = [
            "cod_zoo" => $post['cod_zoocriadero'],
            "id_zooadmin" => (int)$post['operario'],
            "cod_zootanque" => $post['cod_tanque']
        ];

        // Cambios en la tblsegzooact_actividades
        $actividades = $post['actividades']; // 2, 3

        return $this->UpdateSeguimiento($datosSegZoo, $datosSegZooAct, $actividades, $cod_segzooact, $cod_segzoo);
    }

    public function AnularSeguimiento($post)
    {
        $datos = [
            "cod_estado" => (int)$post['cod_estado']
        ];

        $cod_segzooact = [
            "cod_segzooact" => (int)$post['cod_segzooact']
        ];

        return $this->CancelSeguimiento($datos, $cod_segzooact);
    }

    public function VerDetalleSeguimiento($post)
    {
        $cod_segzooact = (int)$post['cod_segzooact'];

        return $this->GetSeguimientoById($cod_segzooact);
    }

    public function TraerSeguimientosFiltrados($get)
    {
        return $this->GetSeguimientosFiltrados($get);
    }
}
