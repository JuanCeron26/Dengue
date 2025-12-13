<?php
include_once '../controllers/controllerPreTest.php';

$obj= new PreTest();
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

        <!-- Questions Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <?php
            $totalPreguntas = count($preguntas);
            foreach ($preguntas as $index => $pregunta):
            ?>
                <!-- Question <?php echo $index + 1; ?> -->
                <div class="<?php echo $index < $totalPreguntas - 1 ? 'mb-8' : 'mb-6'; ?>">
                    <h3 class="text-lg font-bold text-secondary-dark mb-4">
                        <?php echo htmlspecialchars($pregunta['enunciado_pregunta']); ?>
                    </h3>
                    <div class="space-y-3">
                        <?php 
                        // Ahora cada pregunta tiene sus propias opciones específicas
                        if (isset($pregunta['opciones']) && count($pregunta['opciones']) > 0): 
                            foreach ($pregunta['opciones'] as $opcion): 
                        ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-accent-light/10 transition-colors">
                                <span class="text-secondary-dark">
                                    <?php echo htmlspecialchars($opcion['codigo_opcion']) . ') ' . htmlspecialchars($opcion['enunciado']); ?>
                                </span>
                                <div class="flex items-center gap-3">
                                    <button
                                        onclick="decrementCounter('q<?php echo $pregunta['cod_pregunta']; ?>_<?php echo $opcion['cod_opcionesres']; ?>')"
                                        class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">
                                        −
                                    </button>
                                    <span
                                        id="q<?php echo $pregunta['cod_pregunta']; ?>_<?php echo $opcion['cod_opcionesres']; ?>"
                                        class="text-2xl font-bold text-accent-blue min-w-[3rem] text-center">
                                        0
                                    </span>
                                    <button
                                        onclick="incrementCounter('q<?php echo $pregunta['cod_pregunta']; ?>_<?php echo $opcion['cod_opcionesres']; ?>')"
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-accent-light to-accent-blue hover:from-accent-blue hover:to-accent-light text-white font-bold transition-all shadow-md flex items-center justify-center">
                                        +
                                    </button>
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

        <!-- Reset Button -->
        <div class="bg-white rounded-2xl shadow-lg p-6 flex justify-center">
            <button onclick="resetCounters()" class="flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-secondary-dark font-semibold rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reiniciar Contadores
            </button>
        </div>
    </div>

    <!-- Script externo -->
    <script src="../../../js/counters.js"></script>
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
    </script>

    <script src="../../../src/js/pre-test.js"></script>
</body>

</html>