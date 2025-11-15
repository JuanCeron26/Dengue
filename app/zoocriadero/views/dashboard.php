

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Zoocriadero de Guppys</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../src/css/styles.css">
</head>

<body class="bg-(--color-east-bay-50) text-(--color-east-bay-950) min-h-screen">

    <?php include_once '../../../src/includes/aside-zoo.php'; ?>

    <header class="sticky top-0 z-10 flex justify-between items-center px-8 py-4 bg-white/80 backdrop-blur-md shadow-lg border-b border-[var(--color-east-bay-100)] transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-2 rounded-xl bg-(--color-east-bay-700) shadow-(--color-east-bay-200) animate-pulse-slow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M7 3H2v5h5V3zM7 12H2v5h5v-5zM15 3h-5v5h5V3zM15 12h-5v5h5v-5z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-(--color-east-bay-900) tracking-tight">SIG-GPCETV: Control Biológico de Guppys</h1>
                <p class="text-sm text-(--color-east-bay-500) font-medium">Zoocriadero San Carlos, Comuna 11 - Monitoreo de Tanques</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="font-bold text-[var(--color-east-bay-700)]">Juan José Cerón</p>
                <p class="text-[var(--color-east-bay-500)] text-sm">Operario Principal</p>
            </div>
            <div class="cursor-pointer bg-emerald-500 text-white font-semibold rounded-full h-12 w-12 flex items-center justify-center ring-2 ring-emerald-300 hover:ring-4 hover:bg-emerald-600 transition duration-300 ease-in-out transform hover:scale-105">
                JC
            </div>
        </div>
    </header>

    <main class="p-8 grow flex flex-col space-y-12 max-w-7xl mx-auto w-full">

        <section>
            <h2 class="text-3xl font-bold text-[var(--color-east-bay-800)] mb-2 border-l-4 border-emerald-400 pl-3">📈 Indicadores de Bioseguridad y Reproducción</h2>
            <p class="text-[var(--color-east-bay-600)] mb-6">Métricas clave para la trazabilidad y el bienestar de los Guppys.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-[var(--color-east-bay-500)] hover:shadow-2xl transition transform hover:-translate-y-1 duration-300 animate-fadeInUp">
                    <div class="flex items-center space-x-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--color-east-bay-600)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="font-bold text-lg text-[var(--color-east-bay-700)]">Tanques Operacionales</h3>
                    </div>
                    <p class="text-5xl font-extrabold text-[var(--color-east-bay-900)]">8</p>
                    <p class="text-sm text-[var(--color-east-bay-500)] mt-2">Total de unidades de reproducción (100%)</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-emerald-500 hover:shadow-2xl transition transform hover:-translate-y-1 duration-300 animate-fadeInUp" style="animation-delay:0.1s;">
                    <div class="flex items-center space-x-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        <h3 class="font-bold text-lg text-emerald-700">Registro de Nacimientos</h3>
                    </div>
                    <p class="text-5xl font-extrabold text-emerald-900">1.245</p>
                    <div class="flex items-center mt-2 space-x-2">
                        <span class="text-xs font-semibold text-white bg-emerald-500 px-2 py-1 rounded-full">+12%</span>
                        <p class="text-sm text-[var(--color-east-bay-500)]">Incremento de alevines este mes</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-sky-500 hover:shadow-2xl transition transform hover:-translate-y-1 duration-300 animate-fadeInUp" style="animation-delay:0.2s;">
                    <div class="flex items-center space-x-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <h3 class="font-bold text-lg text-sky-700">Mediciones Físico-Q.</h3>
                    </div>
                    <p class="text-5xl font-extrabold text-sky-900">214</p>
                    <p class="text-sm text-[var(--color-east-bay-500)] mt-2">Registros de pH, Temp y Cloro (Últimos 7 días)</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-red-500 hover:shadow-2xl transition transform hover:-translate-y-1 duration-300 animate-fadeInUp" style="animation-delay:0.3s;">
                    <div class="flex items-center space-x-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-8V7h2v1H9v2zm0 3h2v1H9v-1z" clip-rule="evenodd" />
                        </svg>
                        <h3 class="font-bold text-lg text-red-700">Muertes Registradas</h3>
                    </div>
                    <p class="text-5xl font-extrabold text-red-900">7</p>
                    <p class="text-sm text-[var(--color-east-bay-500)] mt-2">Tasa de mortalidad: **0.56%** (Monitoreo constante)</p>
                </div>
            </div>
        </section>

        <hr class="border-[var(--color-east-bay-200)]">

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 bg-white rounded-2xl shadow-xl p-6 animate-fadeInUp border border-[var(--color-east-bay-100)]">
                <h2 class="text-2xl font-bold text-[var(--color-east-bay-800)] mb-4 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--color-east-bay-500)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span>Registro de Acciones</span>
                </h2>
                <ul class="divide-y divide-[var(--color-east-bay-100)]">
                    <li class="py-3 flex justify-between items-center group cursor-pointer hover:bg-[var(--color-east-bay-50)] transition duration-200 rounded-lg px-2">
                        <div>
                            <p class="font-semibold text-[var(--color-east-bay-900)]">Medición de pH y Temp - Tanque **T-3**</p>
                            <p class="text-sm text-[var(--color-east-bay-500)]">Por Kelly • Hace 1 hora</p>
                        </div>
                        <span class="text-xs font-semibold text-sky-700 bg-sky-100 rounded-full px-3 py-1">Parámetros</span>
                    </li>
                    <li class="py-3 flex justify-between items-center group cursor-pointer hover:bg-[var(--color-east-bay-50)] transition duration-200 rounded-lg px-2">
                        <div>
                            <p class="font-semibold text-[var(--color-east-bay-900)]">Lavado Parcial y Nivelación - Tanque **T-5**</p>
                            <p class="text-sm text-[var(--color-east-bay-500)]">Por Juan José • Hace 3 horas</p>
                        </div>
                        <span class="text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full px-3 py-1">Mantenimiento</span>
                    </li>
                    <li class="py-3 flex justify-between items-center group cursor-pointer hover:bg-[var(--color-east-bay-50)] transition duration-200 rounded-lg px-2">
                        <div>
                            <p class="font-semibold text-[var(--color-east-bay-900)]">Registro de Nacimientos - Tanque **T-2**</p>
                            <p class="text-sm text-[var(--color-east-bay-500)]">Por Zamahara • Hoy</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full px-3 py-1">Reproducción</span>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-6 animate-fadeInUp border border-[var(--color-east-bay-100)]" style="animation-delay:0.1s;">
                <h2 class="text-2xl font-bold text-[var(--color-east-bay-800)] mb-4 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 animate-bounce-slow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Alertas de Bioseguridad (¡Requiere Formulario de Seguimiento!)</span>
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 border-l-4 border-red-600 bg-red-50 p-4 rounded-xl shadow-md cursor-pointer hover:bg-red-100 transition transform hover:scale-[1.01] duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 animate-flash" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="font-bold text-red-800">Dato Crítico: **pH 8.9** en Tanque **T-4**</p>
                            <p class="text-sm text-red-600">Acción: **Nivelación urgente** y registro en formulario. Riesgo para los Guppys.</p>
                        </div>
                        <button class="ml-auto text-xs font-semibold text-white bg-red-500 hover:bg-red-700 rounded-full px-4 py-1 transition">Resolver</button>
                    </div>
                    <div class="flex items-center space-x-4 border-l-4 border-yellow-500 bg-yellow-50 p-4 rounded-xl shadow-md cursor-pointer hover:bg-yellow-100 transition transform hover:scale-[1.01] duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m4 0h1v4h1m-7 4v-4H7" />
                        </svg>
                        <div>
                            <p class="font-bold text-yellow-800">Advertencia: Nivel de **Cloro residual alto** - Tanque **T-7**</p>
                            <p class="text-sm text-yellow-600">Acción: Monitorear el filtrado y diluir agua. Posible problema en la descloración.</p>
                        </div>
                        <button class="ml-auto text-xs font-semibold text-white bg-yellow-500 hover:bg-yellow-700 rounded-full px-4 py-1 transition">Verificar</button>
                    </div>
                </div>
            </div>
        </section>

        <hr class="border-[var(--color-east-bay-200)]">

        <section>
            <h2 class="text-3xl font-bold text-[var(--color-east-bay-800)] mb-6 border-l-4 border-emerald-400 pl-3">🗺️ Estado de los 8 Tanques del Zoocriadero</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white rounded-xl p-5 shadow-lg border border-[var(--color-east-bay-100)] hover:shadow-xl hover:border-emerald-300 transition duration-300 transform hover:scale-[1.02]">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-xl font-extrabold text-[var(--color-east-bay-900)]">Tanque T-1 (Reproducción)</h4>
                        <span class="text-sm font-bold text-emerald-700 bg-emerald-100 rounded-full px-3 py-1">Óptimo</span>
                    </div>
                    <p class="text-[var(--color-east-bay-500)] text-sm">Población: **210** Guppys</p>
                    <div class="mt-3 text-xs">
                        <p class="text-[var(--color-east-bay-600)]">pH: 7.2 | Temp: 25.5°C</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-lg border border-red-300 ring-2 ring-red-100 hover:shadow-2xl hover:border-red-500 transition duration-300 transform hover:scale-[1.02] animate-pulse-slow">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-xl font-extrabold text-[var(--color-east-bay-900)]">Tanque T-4 (Engorde)</h4>
                        <span class="text-sm font-bold text-red-700 bg-red-100 rounded-full px-3 py-1">Crítico</span>
                    </div>
                    <p class="text-[var(--color-east-bay-500)] text-sm">Población: **180** Guppys</p>
                    <div class="mt-3 text-xs">
                        <p class="font-bold text-red-600">pH: **8.9** (FUERA DE RANGO)</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-lg border border-[var(--color-east-bay-100)] hover:shadow-xl hover:border-sky-300 transition duration-300 transform hover:scale-[1.02]">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-xl font-extrabold text-[var(--color-east-bay-900)]">Tanque T-8 (Cuarentena)</h4>
                        <span class="text-sm font-bold text-sky-700 bg-sky-100 rounded-full px-3 py-1">Mantenimiento</span>
                    </div>
                    <p class="text-[var(--color-east-bay-500)] text-sm">Población: **Vacío (Limpieza)**</p>
                    <div class="mt-3 text-xs">
                        <p class="text-[var(--color-east-bay-600)]">Próxima siembra: Hoy</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-lg border border-[var(--color-east-bay-100)] hover:shadow-xl hover:border-emerald-300 transition duration-300 transform hover:scale-[1.02]">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-xl font-extrabold text-[var(--color-east-bay-900)]">Tanque T-5 (Alevines)</h4>
                        <span class="text-sm font-bold text-emerald-700 bg-emerald-100 rounded-full px-3 py-1">Bueno</span>
                    </div>
                    <p class="text-[var(--color-east-bay-500)] text-sm">Población: **350** Alevines</p>
                    <div class="mt-3 text-xs">
                        <p class="text-[var(--color-east-bay-600)]">pH: 7.5 | Temp: 26.0°C</p>
                    </div>
                </div>

            </div>

        </section>

    </main>

    <footer class="text-center text-sm font-medium text-[var(--color-east-bay-500)] border-t border-[var(--color-east-bay-100)] py-6 mt-8 select-none bg-white/70 backdrop-blur-sm">
        Sistema SIG-GPCETV - Módulo de Zoocriaderos © 2025. Desarrollado por el SENA.
    </footer>

    <script src="../../../src/js/aside.js"></script>

    <style>
        :root {
            --color-east-bay-50: #f4f6fa;
            --color-east-bay-100: #e6e9f3;
            --color-east-bay-200: #d2d7eb;
            --color-east-bay-300: #b3bddd;
            --color-east-bay-400: #8f9ccb;
            --color-east-bay-500: #747fbd;
            --color-east-bay-600: #6268af;
            --color-east-bay-700: #56589f;
            --color-east-bay-800: #4a4b83;
            --color-east-bay-900: #42436e;
            --color-east-bay-950: #2a2a41;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-slow {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.9;
            }

            50% {
                transform: scale(1.02);
                opacity: 1;
            }
        }

        @keyframes flash {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s infinite ease-in-out;
        }

        .animate-flash {
            animation: flash 1.5s infinite alternate;
        }
    </style>
</body>

</html>