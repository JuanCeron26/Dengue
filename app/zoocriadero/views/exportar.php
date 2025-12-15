<?php
include_once '../controllers/controllerExportar.php';

if (!isset($_GET['cod_zoo'])) {
    die('Error: No se especificó el código del zoocriadero');
}

$controller = new ExportarZoo();
$data = $controller->obtenerDatosZoo($_GET['cod_zoo']);

if (!$data['success']) {
    die('Error: ' . $data['message']);
}

$zoo = $data['zoo'];
$tanques = $data['tanques'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar Zoocriadero - <?= htmlspecialchars($zoo['nombre_zoo']) ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="../../../src/css/zoo-exportar.css">
</head>

<body>
    <div class="container">
        <!-- Controles -->
        <div class="controls">
            <h2>Exportar a PDF</h2>
            <div class="btn-group">
                <button class="btn-pdf" onclick="generarPDF()">
                    Descargar PDF
                </button>
                <button class="btn-back" onclick="window.close()">
                    ← Volver
                </button>
            </div>
        </div>

        <!-- Contenido para PDF -->
        <div id="pdfContent">
            <!-- Header -->
            <div class="header">
                <div class="logo-section">
                    <img src="../../../src/img/logo-cali.png"
                        alt="Logo Alcaldía"
                        class="logo">
                    <div class="header-text">
                        <h1>ALCALDÍA DE SANTIAGO DE CALI</h1>
                        <p>Secretaría de Salud Pública</p>
                        <p style="font-size: 11px; margin-top: 3px;">Gestión de Zoocriaderos</p>
                    </div>
                </div>
                <div class="doc-title">
                    <h2>FICHA TÉCNICA</h2>
                    <p>Zoocriadero</p>
                    <p style="margin-top: 5px;">Fecha: <?= date('d/m/Y H:i') ?></p>
                </div>
            </div>

            <!-- Información del Zoocriadero -->
            <div class="info-section">
                <div class="section-title">
                    Información del Zoocriadero
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Código</div>
                        <div class="info-value">#<?= htmlspecialchars($zoo['cod_zoo']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Estado</div>
                        <div class="info-value">
                            <span class="badge">✓ Activo</span>
                        </div>
                    </div>
                    <div class="info-item full-width">
                        <div class="info-label">Nombre del Zoocriadero</div>
                        <div class="info-value"><?= htmlspecialchars($zoo['nombre_zoo']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Encargado</div>
                        <div class="info-value"><?= htmlspecialchars($zoo['encargado']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Barrio</div>
                        <div class="info-value"><?= htmlspecialchars($zoo['nombarrio'] ?? 'No especificado') ?></div>
                    </div>
                    <div class="info-item full-width">
                        <div class="info-label">Dirección</div>
                        <div class="info-value"><?= htmlspecialchars($zoo['direccion_zoo']) ?></div>
                    </div>
                </div>
            </div>

            <!-- Tanques Asociados -->
            <div class="info-section">
                <div class="section-title">
                    Tanques Asociados (<?= count($tanques) ?>)
                </div>
                <?php if (count($tanques) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de Tanque</th>
                                <th>Nombre del Tanque</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tanques as $index => $tanque): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($tanque['nomtiptan']) ?></td>
                                    <td><?= htmlspecialchars($tanque['nom_zootanque']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">
                        No hay tanques asociados a este zoocriadero
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>Documento generado electrónicamente - Alcaldía de Santiago de Cali</p>
                <p>Sistema de Gestión de Zoocriaderos - <?= date('Y') ?></p>
            </div>
        </div>
    </div>

    <!-- Js -->
    <!-- Pasar código del zoo a JavaScript -->
    <script>
        // Variable global con el código del zoo
        window.COD_ZOO = <?= $zoo['cod_zoo'] ?>;
    </script>

    <!-- JavaScript personalizado-->
    <script src="../../../src/js/zoo-exportar.js"></script>
</body>

</html>