<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <title>Dashboard</title>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <header class="flex justify-between items-center px-6 py-4 bg-white shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="bg-green-500 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold">Dashboard - Trabajo en Terreno</h1>
                <p class="text-sm text-gray-500 font-semibold">Sistema de Monitoreo Ambiental</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <div class="text-right">
                <p class="font-medium">Juan José Cerón Arcos</p>
                <p class="text-gray-500">Inspector</p>
            </div>
            <div class="cursor-pointer bg-green-600 text-white font-semibold rounded-full h-10 w-10 flex items-center justify-center hover:scale-110 transition-transform select-none">
                JC
            </div>
        </div>
    </header>

    <main class="p-6 grow flex flex-col space-y-10 max-w-7xl mx-auto w-full">

        <section>
            <h2 class="text-3xl font-bold text-green-900 mb-1">Resumen de Actividades</h2>
            <p class="text-gray-600 font-semibold max-w-xl">Estadísticas generales del trabajo en terreno con evolución mensual y alertas en tiempo real.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mt-6">
                <div class="cursor-pointer bg-linear-to-r from-green-500 to-green-600 text-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2 animate-fadeInUp">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold">Inspecciones Registradas</h3>
                    </div>
                    <p class="text-4xl font-extrabold">124</p>
                    <div class="mt-4 h-2 bg-green-700 rounded-full relative overflow-hidden">
                        <div class="absolute h-2 bg-green-300 rounded-full animate-pulse" style="width:75%;"></div>
                    </div>
                    <p class="text-xs mt-1">Meta mensual: 165 (75% alcanzado)</p>
                </div>

                <div class="cursor-pointer bg-linear-to-r from-sky-500 to-blue-600 text-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2 animate-fadeInUp" style="animation-delay: 0.1s;">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold">Siembras Realizadas</h3>
                    </div>
                    <p class="text-4xl font-extrabold">48</p>
                    <div class="mt-4 h-2 bg-blue-700 rounded-full relative overflow-hidden">
                        <div class="absolute h-2 bg-blue-300 rounded-full animate-pulse" style="width:55%;"></div>
                    </div>
                    <p class="text-xs mt-1">Meta mensual: 80 (60% alcanzado)</p>
                </div>

                <div class="cursor-pointer bg-linear-to-r from-cyan-400 to-teal-500 text-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2 animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold">Seguimientos Activos</h3>
                    </div>
                    <p class="text-4xl font-extrabold">32</p>
                    <div class="mt-4 h-2 bg-teal-700 rounded-full relative overflow-hidden">
                        <div class="absolute h-2 bg-teal-300 rounded-full animate-pulse" style="width:40%;"></div>
                    </div>
                    <p class="text-xs mt-1">Meta mensual: 50 (64% alcanzado)</p>
                </div>

                <div class="cursor-pointer bg-linear-to-r from-green-600 to-emerald-500 text-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2 animate-fadeInUp" style="animation-delay: 0.3s;">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="font-bold">Resiembras Completadas</h3>
                    </div>
                    <p class="text-4xl font-extrabold">15</p>
                    <div class="mt-4 h-2 bg-emerald-700 rounded-full relative overflow-hidden">
                        <div class="absolute h-2 bg-emerald-300 rounded-full animate-pulse" style="width:75%;"></div>
                    </div>
                    <p class="text-xs mt-1">Meta mensual: 20 (75% alcanzado)</p>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-white rounded-xl shadow p-6 animate-fadeInUp max-h-[480px] overflow-y-auto">
                <h2 class="text-2xl font-bold text-green-900 mb-4">Últimas Actividades</h2>
                <ul class="divide-y divide-gray-200 max-h-[380px] overflow-auto">
                    <li class="py-3 flex justify-between items-center hover:bg-green-50 transition rounded px-3">
                        <div>
                            <p class="font-semibold text-gray-800">Inspección en Sector A</p>
                            <p class="text-sm text-gray-500">Por Juan José • Hace 2 horas</p>
                        </div>
                        <span class="text-xs bg-green-200 text-green-800 rounded-full px-3 py-1 whitespace-nowrap">Inspección</span>
                    </li>
                    <li class="py-3 flex justify-between items-center hover:bg-blue-50 transition rounded px-3">
                        <div>
                            <p class="font-semibold text-gray-800">Siembra de Árboles en Zona 5</p>
                            <p class="text-sm text-gray-500">Por Zamahara • Hace 6 horas</p>
                        </div>
                        <span class="text-xs bg-blue-200 text-blue-800 rounded-full px-3 py-1 whitespace-nowrap">Siembra</span>
                    </li>
                    <li class="py-3 flex justify-between items-center hover:bg-teal-50 transition rounded px-3">
                        <div>
                            <p class="font-semibold text-gray-800">Seguimiento en Proyecto B</p>
                            <p class="text-sm text-gray-500">Por Kelly • Ayer</p>
                        </div>
                        <span class="text-xs bg-teal-200 text-teal-800 rounded-full px-3 py-1 whitespace-nowrap">Seguimiento</span>
                    </li>
                    <li class="py-3 flex justify-between items-center hover:bg-emerald-50 transition rounded px-3">
                        <div>
                            <p class="font-semibold text-gray-800">Resiembra completada en Sector 3</p>
                            <p class="text-sm text-gray-500">Por Luisa • Hace 3 días</p>
                        </div>
                        <span class="text-xs bg-emerald-200 text-emerald-800 rounded-full px-3 py-1 whitespace-nowrap">Resiembra</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-xl shadow p-6 animate-fadeInUp max-h-[480px] overflow-y-auto border-2 border-green-500">
                <h2 class="text-2xl font-bold text-green-900 mb-4">Notificaciones y Alertas</h2>
                <div class="space-y-4 max-h-[420px] overflow-auto">

                    <div class="flex items-center space-x-3 border-l-4 border-red-600 bg-red-100 p-4 rounded shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 2a10 10 0 11-10 10 10 10 0 0110-10z" />
                        </svg>
                        <div>
                            <p class="font-semibold text-red-700">Inspección pendiente sin seguimiento</p>
                            <p class="text-sm text-red-600">Hace 48 horas • Sector B</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 border-l-4 border-yellow-500 bg-yellow-100 p-4 rounded shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m4 0h1v4h1m-7 4v-4H7m10 0v4h-4m6-8h.01M5 13h.01" />
                        </svg>
                        <div>
                            <p class="font-semibold text-yellow-700">Resiembra con crecimiento lento</p>
                            <p class="text-sm text-yellow-600">Sin seguimiento desde hace 5 días</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 border-l-4 border-blue-500 bg-blue-100 p-4 rounded shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m-7 0h14" />
                        </svg>
                        <div>
                            <p class="font-semibold text-blue-700">Nueva siembra sin inspección inicial</p>
                            <p class="text-sm text-blue-600">Hace 12 horas • Zona 7</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 border-l-4 border-green-500 bg-green-100 p-4 rounded shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />
                        </svg>
                        <div>
                            <p class="font-semibold text-green-700">Seguimiento reciente completado</p>
                            <p class="text-sm text-green-600">Hace 1 hora • Sector C</p>
                        </div>
                    </div>

                </div>
            </div>

        </section>

        <section class="border-4 border-dashed border-green-600 rounded-xl p-6 bg-green-50">
            <div class="flex items-center space-x-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />
                </svg>
                <h3 class="text-lg font-semibold text-green-900">Mapa de Sitios Visitados</h3>
            </div>
            <div id="map" class="rounded-xl flex justify-center items-center py-16 bg-green-100 text-green-600 font-semibold">

                Mapa interactivo
            </div>
        </section>

    </main>

    <footer class="text-center font-semibold text-gray-500 border-t-0 shadow-[0_-1px_4px_rgba(0,0,0,0.15)] py-10 select-none">
        Sistema de Monitoreo Ambiental - Módulo de Trabajo en Terreno © 2025
    </footer>
    <style>
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

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease forwards;
        }
    </style>

</body>




</html>