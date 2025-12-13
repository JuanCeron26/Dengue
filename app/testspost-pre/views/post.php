<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post-Test de Evaluación</title>
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

<body class="bg-gradient-to-br from-primary-light/30 to-primary-dark/10 min-h-screen">
    <div class="container mx-auto px-4 py-6 max-w-5xl">
        <!-- Back Button -->
        <button onclick="window.history.back()" class="mb-6 flex items-center text-primary-dark hover:text-primary-dark/70 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver al menú
        </button>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border-l-4 border-primary-dark">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-light to-primary-dark rounded-full flex items-center justify-center shadow-lg mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-primary-dark">Post-Test de Evaluación</h1>
                        <p class="text-secondary-dark text-sm">Registra las respuestas de los participantes después de la capacitación</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Counter -->
        <div class="bg-gradient-to-r from-primary-light to-primary-dark rounded-xl shadow-lg p-4 mb-6">
            <p class="text-white text-center text-lg font-semibold">
                Total de respuestas registradas: <span id="totalCount" class="text-2xl font-bold">0</span>
            </p>
        </div>

        <!-- Questions Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <!-- Question 1 -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-secondary-dark mb-4">¿Cuál es tu nivel de conocimiento sobre el tema después de la capacitación?</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">A) Ninguno</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q1a')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q1a" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q1a')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">B) Básico</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q1b')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q1b" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q1b')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">C) Intermedio</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q1c')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q1c" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q1c')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">D) Avanzado</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q1d')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q1d" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q1d')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 my-6">

            <!-- Question 2 -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-secondary-dark mb-4">¿Con qué frecuencia aplicarás estos conceptos en tu trabajo?</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">A) Nunca</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q2a')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q2a" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q2a')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">B) Raramente</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q2b')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q2b" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q2b')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">C) Frecuentemente</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q2c')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q2c" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q2c')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">D) Siempre</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q2d')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q2d" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q2d')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 my-6">

            <!-- Question 3 -->
            <div class="mb-6">
                <h3 class="text-lg font-bold text-secondary-dark mb-4">¿Qué tan confiado te sientes ahora al resolver problemas relacionados?</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">A) Nada confiado</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q3a')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q3a" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q3a')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">B) Poco confiado</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q3b')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q3b" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q3b')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">C) Confiado</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q3c')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q3c" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q3c')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-primary-light/10 transition-colors">
                        <span class="text-secondary-dark">D) Muy confiado</span>
                        <div class="flex items-center gap-3">
                            <button onclick="decrementCounter('q3d')" class="w-10 h-10 rounded-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold transition-colors flex items-center justify-center">−</button>
                            <span id="q3d" class="text-2xl font-bold text-primary-dark min-w-[3rem] text-center">0</span>
                            <button onclick="incrementCounter('q3d')" class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-light to-primary-dark hover:from-primary-dark hover:to-primary-light text-white font-bold transition-all shadow-md flex items-center justify-center">+</button>
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Js -->
    <script src="../../../src/js/post-test.js"></script>

</body>

</html>