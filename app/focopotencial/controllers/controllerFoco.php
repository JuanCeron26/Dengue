<?php

include_once '../models/modelFoco.php';

class controllerFoco extends modelFofo
{
    // para el cod_controlactividadeco, puedo extraerlo con un SELECT diciendo WHERE cod_territorio y cod_actividad

    public function RegistrarFocoPotencial($post)
    {
        // Construir dirección completa

        $tipovia = $post['tipoVia'] ?? '';
        $numeroVia = $post['numeroVia'] ?? '';
        $sufijo = $post['sufijo'] ?? '';
        $distancia = $post['distancia'] ?? '';


        $direccion_completa = $tipovia . ' ' . $numeroVia . ' ' . '#' . ' ' . $sufijo . '-' . $distancia;

        // Registrar en tblfocopotenciallugar
        $datos = [
            "cod_controlactividadeco" => 3, // por ahora el 3
            "realizo" => $post['realizo'] ?? 'Equipo Ecosalud',
            "dirección" => $direccion_completa,
            "tipo_via" => $post['tipoVia'] ?? '',
            "numero_via" => $post['numeroVia'] ?? '',
            "sufijo" => $post['sufijo'] ?? '',
            "distancia" => $post['distancia'] ?? '',
            "lugar" => $post['lugar']
        ];

        // Registrar en muchos a muchos
        $datos2 = [
            "cod_tipo_foc" => $post['cod_tipo_foc']
        ];

        return $this->InsertFocoPotencial($datos, $datos2);
    }

    public function traerTiposFocos()
    {
        return $this->GetTiposFocos();
    }

    public function traerFocosPotenciales()
    {
        return $this->GetFocosPotenciales();
    }

    public function EditarFocoPotencial($post)
    {
        // realizo, direccion, lugar, tipo de foco

        $cod_focopotlugar = (int)$post['cod_focopotlugar'];
        $datos = [
            "fecha" => ($post['fecha']),
            "realizo" => $post['realizo'],
            "dirección" => $post['dirTipo'] . ' ' . $post['direccion1'] . ' ' . $post['#'] . ' ' . $post['direccion2'],
            "lugar" => $post['lugar']
        ];

        $datos2 = [
            "cod_tipo_foc" => $post['cod_tipo_foc']
        ];

        return $this->UpdateFocoPotencial($datos, $datos2, $cod_focopotlugar);
    }

    public function ActualizarFocoPotencial($post)
    {
        // Construir dirección completa
        $tipovia = $post['tipoVia'] ?? '';
        $numeroVia = $post['numeroVia'] ?? '';
        $sufijo = $post['sufijo'] ?? '';
        $distancia = $post['distancia'] ?? '';


        $direccion_completa = $tipovia . ' ' . $numeroVia . ' ' . '#' . ' ' . $sufijo . '-' . $distancia;

        // Datos para actualizar tblfocopotenciallugar
        $datos = [
            "realizo" => $post['realizo'] ?? 'Equipo Ecosalud',
            "dirección" => $direccion_completa,
            "tipo_via" => $post['tipoVia'] ?? '',
            "numero_via" => $post['numeroVia'] ?? '',
            "sufijo" => $post['sufijo'] ?? '',
            "distancia" => $post['distancia'] ?? '',
            "lugar" => $post['lugar']
        ];

        // Datos para actualizar tipo de foco
        $datos2 = [
            "cod_tipo_foc" => $post['cod_tipo_foc']
        ];

        $cod_focopotlugar = $post['cod_focopotlugar']; // id del foco a editar

        return $this->UpdateFocoPotencial($cod_focopotlugar, $datos, $datos2);
    }

    public function traerFocoPotencial($cod_focopotlugar)
    {
        return $this->GetFocoPotencial($cod_focopotlugar);
    }

    public function traerUsersEco($post)
    {

        $cod_controlactividadeco = (int)$post['cod_territorio'];
        return $this->GetUsersEcosalud($cod_controlactividadeco);
    }

    public function traerParticipantes($post)
    {
        $cod_controlactividadeco = (int)$post['cod_territorio'];
        return $this->GetParticipantes($cod_controlactividadeco);
    }

    public function traerFocosActuales($cod_controlactividadeco)
    {
        $cod = (int)$cod_controlactividadeco;
        return $this->GetFocosActuales($cod);
    }

    public function eliminarFocoActual($cod_focopotlugar)
    {
        $cod = (int)$cod_focopotlugar;
        $t = $this->DeleteFocoActual($cod);
        if ($t) {
            return "exito";
        }
    }
}
/*
$c = new controllerFoco();
$post = [
    "cod_territorio" => 3
];
print_r($c->traerUsersEco($post));
*/