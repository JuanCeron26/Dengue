<?php
// Desactivar errores visibles (si sale un warning, daña el PDF)
error_reporting(0);
ini_set('display_errors', 0);

// Limpiar cualquier salida previa
if (ob_get_length()) {
    ob_end_clean();
}

// Importante: NO enviar headers manuales de PDF
// Los controla FPDF con ->Output()

require_once('../../../library/fpdf186/fpdf.php');

// Recibir datos JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

class PDF extends FPDF
{
    private $data;

    public function __construct($data)
    {
        parent::__construct('P', 'mm', 'A4');
        $this->data = $data;
    }

    public function Header()
    {
        $this->SetFillColor(23, 88, 168);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 12, 'INFORME DE ACTIVIDAD - CONTROL DE DENGUE', 0, 1, 'C', true);

        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 6, 'ID: ' . ($this->data['cod_actividadtrabajocampo'] ?? 'N/A'), 0, 1, 'C');
        $this->Ln(3);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    public function SectionTitle($title)
    {
        $this->SetFillColor(230, 240, 255);
        $this->SetTextColor(23, 88, 168);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 8, $title, 0, 1, 'L', true);
        $this->SetTextColor(0, 0, 0);
        $this->Ln(1);
    }

    public function FieldRow($label, $value, $unit = '')
    {
        $this->SetFont('Arial', 'B', 9);
        $displayValue = (!empty($value) && $value !== null) ? $value : 'N/A';
        $this->Cell(60, 6, $label . ':', 0, 0);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 6, $displayValue . ' ' . $unit, 0, 1);
    }

    public function generarPDF()
    {
        $this->AddPage();

        // DATOS GENERALES
        $this->SectionTitle('UBICACION Y DATOS GENERALES');
        $this->FieldRow('Fecha', $this->data['fecha_actividad'] ?? 'N/A');
        $this->FieldRow('Codigo Actividad Padre', $this->data['cod_actividad_padre'] ?? 'N/A');
        $this->FieldRow('Codigo Act. Campo', $this->data['cod_act_campo'] ?? 'N/A');
        $this->FieldRow('Codigo Sitio Deposito', $this->data['cod_sitiodepo'] ?? 'N/A');
        $this->Ln(3);

        // PARÁMETROS FÍSICO-QUÍMICOS
        if (!empty($this->data['temperatura']) || !empty($this->data['ph']) || !empty($this->data['cloro'])) {
            $this->SectionTitle('PARAMETROS DE INSPECCION');
            $this->FieldRow('Temperatura', $this->data['temperatura'] ?? 'N/A', '°C');
            $this->FieldRow('PH', $this->data['ph'] ?? 'N/A');
            $this->FieldRow('Cloro', $this->data['cloro'] ?? 'N/A');
            $this->Ln(3);
        }

        // DIMENSIONES
        if (!empty($this->data['ancho_deposito']) || !empty($this->data['largo_deposito']) || !empty($this->data['profundidad_deposito'])) {
            $this->SectionTitle('DIMENSIONES DEL DEPOSITO');
            $this->FieldRow('Ancho', $this->data['ancho_deposito'] ?? 'N/A', 'cm');
            $this->FieldRow('Largo', $this->data['largo_deposito'] ?? 'N/A', 'cm');
            $this->FieldRow('Profundidad', $this->data['profundidad_deposito'] ?? 'N/A', 'cm');
            $this->Ln(3);
        }

        // CONTROL BIOLÓGICO
        if (
            !empty($this->data['adultos_guppies']) || !empty($this->data['alevines_guppies']) ||
            !empty($this->data['positivo_larvas_aedes']) || !empty($this->data['positivo_pupas']) ||
            !empty($this->data['positivo_culex']) || !empty($this->data['peces_muertos'])
        ) {

            $this->SectionTitle('CONTROL BIOLOGICO Y LARVARIO');
            $this->FieldRow('Larvas Aedes (+)', $this->data['positivo_larvas_aedes'] ?? 'N/A');
            $this->FieldRow('Pupas (+)', $this->data['positivo_pupas'] ?? 'N/A');
            $this->FieldRow('Culex (+)', $this->data['positivo_culex'] ?? 'N/A');
            $this->FieldRow('Peces Adultos', $this->data['adultos_guppies'] ?? 'N/A');
            $this->FieldRow('Alevines', $this->data['alevines_guppies'] ?? 'N/A');
            $this->FieldRow('Peces Muertos', $this->data['peces_muertos'] ?? 'N/A');
            $this->Ln(3);
        }

        // OBSERVACIONES
        $this->SectionTitle('OBSERVACIONES');
        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(245, 245, 245);
        $observaciones = $this->data['observaciones'] ?? 'No se registraron observaciones.';
        $this->MultiCell(0, 5, $observaciones, 1, 'L', true);
        $this->Ln(3);

        // PIE
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 5, 'Generado: ' . date('d/m/Y H:i:s'), 0, 1, 'R');
    }
}

try {
    if ($data && is_array($data)) {
        $pdf = new PDF($data);
        $pdf->generarPDF();

        // NO uses headers manuales — FPDF maneja todo
        $pdf->Output(
            'D',
            'Informe_' . ($data['cod_actividadtrabajocampo'] ?? 'Actividad') . '_' . date('YmdHis') . '.pdf'
        );
    } else {
        echo json_encode(['error' => 'No se recibieron datos válidos']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

exit;
