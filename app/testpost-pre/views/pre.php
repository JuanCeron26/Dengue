<?php
include_once '../controllers/controllerPreTest.php';

$obj = new PreTest();
$mensaje = null;
$tipo_mensaje = null;

// PROCESAR FORMULARIO SI ES POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $obj->procesarFormulario();
    if ($resultado !== null) {
        $mensaje = $resultado['mensaje'];
        $tipo_mensaje = $resultado['success'] ? 'success' : 'error';
    }
}

// MOSTRAR VISTA - Obtener el primer cod_controlactividadeco disponible
$cod_controlactividadeco = $_GET['cod_actividad'] ?? null;

// Si no hay actividad en GET, buscar la primera disponible
if (!$cod_controlactividadeco) {
    include_once '../../../conexionBD/BaseDatos.php';
    $bd = new BaseDatos("ceron123");
    $conexion = $bd->conectar;

    $sqlPrimera = "SELECT cod_controlactividadeco 
                   FROM tblcontrolactividad 
                   ORDER BY cod_controlactividadeco 
                   LIMIT 1";
    $resultPrimera = pg_query($conexion, $sqlPrimera);

    if ($resultPrimera && pg_num_rows($resultPrimera) > 0) {
        $row = pg_fetch_assoc($resultPrimera);
        $cod_controlactividadeco = $row['cod_controlactividadeco'];
    } else {
        die("Error: No hay actividades disponibles en la base de datos.");
    }
}

$preguntas = $obj->obtenerPreguntasConOpciones();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-Test de Evaluación</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-dark': '#005F3D',
                        'primary-light': '#A5D7AE',
                        'accent-light': '#8EBBFF',
                        'accent-blue': '#4A7BFF',
                        'secondary-light': '#9AC2DA',
                        'secondary-dark': '#3E6E83',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-accent-light/20 to-secondary-light/30 min-h-screen">
    <div class="container mx-auto px-4 py-6 max-w-5xl">

        <!-- Mensaje de éxito/error -->
        <?php if ($mensaje): ?>
            <div class="mb-6 p-4 rounded-lg shadow-lg <?php echo $tipo_mensaje === 'success' ? 'bg-green-100 border-l-4 border-green-500 text-green-700' : 'bg-red-100 border-l-4 border-red-500 text-red-700'; ?>">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?php if ($tipo_mensaje === 'success'): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        <?php endif; ?>
                    </svg>
                    <span class="font-semibold"><?php echo htmlspecialchars($mensaje); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Back Button -->
        <button onclick="window.history.back()" class="mb-6 flex items-center text-accent-blue hover:text-secondary-dark transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al menú
        </button>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border-l-4 border-accent-blue">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-accent-light to-accent-blue rounded-full flex items-center justify-center shadow-lg mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-accent-blue">Pre-Test de Evaluación</h1>
                        <p class="text-secondary-dark text-sm">Registra las respuestas de los participantes antes de la capacitación</p>
                        <p class="text-xs text-gray-500 mt-1">Actividad #<?php echo $cod_controlactividadeco; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Counter -->
        <div class="bg-gradient-to-r from-accent-light to-accent-blue rounded-xl shadow-lg p-4 mb-6">
            <p class="text-white text-center text-lg font-semibold">
                Total de respuestas registradas: <span id="totalCount" class="text-2xl font-bold">0</span>
            </p>
        </div>

        <!-- FORMULARIO -->
        <form id="formPreTest" method="POST" action="">
            <input type="hidden" name="cod_controlactividadeco" value="<?php echo htmlspecialchars($cod_controlactividadeco); ?>">

            <!-- Questions Form -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <?php
                $totalPreguntas = count($preguntas);
                foreach ($preguntas as $index => $pregunta):
                ?>
                    <div class="<?php echo $index < $totalPreguntas - 1 ? 'mb-8' : 'mb-6'; ?>">
                        <h3 class="text-lg font-bold text-secondary-dark mb-4">
                            <?php echo htmlspecialchars($pregunta['enunciado_pregunta']); ?>
                        </h3>
                        <div class="space-y-3">
                            <?php
                            if (isset($pregunta['opciones']) && count($pregunta['opciones']) > 0):
                                foreach ($pregunta['opciones'] as $opcion):
                                    $counterId = 'q' . $pregunta['cod_pregunta'] . '_' . $opcion['cod_opcionesres'];
                            ?>
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-accent-light/10 transition-colors">
                                        <span class="text-secondary-dark">
                                            <?php echo htmlspecialchars($opcion['codigo_opcion']) . ') ' . htmlspecialchars($opcion['enunciado']); ?>
                                        </span>
                                        <div class="flex items-center gap-3">
                                            <button type="button"
                                                onclick="decrementCounter('<?php echo $counterId; ?>')"
                                                class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">
                                                −
                                            </button>
                                            <span
                                                id="<?php echo $counterId; ?>"
                                                class="text-2xl font-bold text-accent-blue min-w-[3rem] text-center">
                                                0
                                            </span>
                                            <button type="button"
                                                onclick="incrementCounter('<?php echo $counterId; ?>')"
                                                class="w-10 h-10 rounded-full bg-gradient-to-r from-accent-light to-accent-blue hover:from-accent-blue hover:to-accent-light text-white font-bold transition-all shadow-md flex items-center justify-center">
                                                +
                                            </button>

                                            <!-- Campos ocultos para enviar datos -->
                                            <input type="hidden" name="<?php echo $counterId; ?>" id="input_<?php echo $counterId; ?>" value="0">
                                            <input type="hidden" name="pregresp_<?php echo $counterId; ?>" value="<?php echo $opcion['cod_pregresp']; ?>">
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <p class="text-gray-500 italic">No hay opciones configuradas para esta pregunta.</p>
                            <?php
                            endif;
                            ?>
                        </div>
                    </div>

                    <?php if ($index < $totalPreguntas - 1): ?>
                        <hr class="border-gray-200 my-6">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col sm:flex-row justify-between gap-4">
                <button type="button" onclick="resetCounters()" class="flex items-center justify-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-secondary-dark font-semibold rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reiniciar Contadores
                </button>

                <button type="submit" class="flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-accent-light to-accent-blue hover:from-accent-blue hover:to-accent-light text-white font-semibold rounded-lg transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Guardar Respuestas
                </button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="../../../src/js/pre-test.js"></script>
    <script>
        // Generar dinámicamente los IDs de los contadores desde PHP
        const counterIds = [
            <?php
            $counterIds = [];
            foreach ($preguntas as $pregunta) {
                if (isset($pregunta['opciones'])) {
                    foreach ($pregunta['opciones'] as $opcion) {
                        $counterIds[] = "'q" . $pregunta['cod_pregunta'] . "_" . $opcion['cod_opcionesres'] . "'";
                    }
                }
            }
            echo implode(",\n            ", $counterIds);
            ?>
        ];

        // Inicializar el manager de contadores
        document.addEventListener('DOMContentLoaded', function() {
            initCounterManager(counterIds);
        });

        // Sincronizar valores antes de enviar el formulario
        document.getElementById('formPreTest').addEventListener('submit', function(e) {
            counterIds.forEach(id => {
                const counterValue = document.getElementById(id).textContent;
                const inputField = document.getElementById('input_' + id);
                if (inputField) {
                    inputField.value = counterValue;
                }
            });
        });
    </script>
</body>

</html>