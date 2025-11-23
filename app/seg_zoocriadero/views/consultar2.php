<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>ZooMonitor Pro — Seguimientos</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <meta name="description" content="Interfaz de consulta de seguimientos de zoocriaderos">
</head>

<body class="min-h-screen bg-[#e5f7fb] font-sans text-slate-700 antialiased">
    <!-- Top bar -->
    <header class="bg-[#dff6fb] border-b border-[#cbeff6]">
        <div class="max-w-7xl mx-auto px-6 py-5 flex items-center gap-6">
            <div class="header-logo">
                <div class="w-14 h-14 rounded-2xl bg-brand-500 flex items-center justify-center shadow-soft text-white transform transition-transform hover:scale-105">
                    <!-- simple logo -->
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" aria-hidden>
                        <path d="M12 2.5C7.31 2.5 3.5 6.31 3.5 11c0 4.69 3.81 8.5 8.5 8.5s8.5-3.81 8.5-8.5S16.69 2.5 12 2.5z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9.5 12.5l1.8 1.8L15 10.6" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-semibold text-[#1a5f77] leading-tight">ZooMonitor Pro</div>
                    <div class="text-sm text-slate-500">Consulta de seguimientos registrados</div>
                </div>
            </div>

            <div class="ml-auto flex items-center gap-4">
                <div class="rounded-full bg-white/60 py-1 px-2 text-sm text-slate-700 shadow-sm">Usuario: <strong class="ml-2">JuanCeron26</strong></div>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-12 gap-6">
        <!-- Sidebar filters -->
        <aside class="col-span-3">
            <div class="card p-6 sticky top-6 border border-white/60">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-lg bg-brand-100 flex items-center justify-center text-brand-600">
                        <!-- icon -->
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M4 6h16M6 12h12M10 18h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-700">Filtros</h3>
                        <p class="text-xs text-slate-400">Refina tu consulta</p>
                    </div>
                </div>

                <hr class="my-4 border-slate-100">

                <!-- Tipo de Tanque -->
                <div class="mb-6">
                    <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" viewBox="0 0 24 24" fill="none">
                            <path d="M3 5h18M6 12h12M10 19h4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Tipo de Tanque
                    </h4>
                    <div class="flex flex-wrap gap-3">
                        <button data-chip="Circular" class="chip border border-slate-200 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-full text-sm transition transform hover:scale-105 focus:outline-none">Circular</button>
                        <button data-chip="Rectangular" class="chip border border-slate-200 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-full text-sm transition transform hover:scale-105">Rectangular</button>
                        <button data-chip="Geomembrana" class="chip border border-slate-200 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-full text-sm transition transform hover:scale-105">Geomembrana</button>
                        <button data-chip="Concreto" class="chip border border-slate-200 bg-slate-100 text-slate-700 px-3 py-1.5 rounded-full text-sm transition transform hover:scale-105">Concreto</button>
                    </div>
                </div>

                <!-- Quién Realizó -->
                <div class="mb-6">
                    <h4 class="font-semibold text-slate-700 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" viewBox="0 0 24 24" fill="none">
                            <path d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20a8 8 0 0116 0" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Quién Realizó
                    </h4>
                    <div class="space-y-3">
                        <button class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                            <div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center font-semibold">JP</div>
                            <div class="text-left">
                                <div class="font-medium">Juan Pérez</div>
                                <div class="text-xs text-slate-400">Responsable norte</div>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                            <div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center font-semibold">MG</div>
                            <div class="text-left">
                                <div class="font-medium">María García</div>
                                <div class="text-xs text-slate-400">Zona sur</div>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-3 p-3 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                            <div class="w-10 h-10 rounded-full bg-brand-600 text-white flex items-center justify-center font-semibold">CL</div>
                            <div class="text-left">
                                <div class="font-medium">Carlos López</div>
                                <div class="text-xs text-slate-400">Técnico</div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Zoocriadero select -->
                <div>
                    <h4 class="font-semibold text-slate-700 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2v20M2 12h20" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Zoocriadero
                    </h4>
                    <select id="zoocriadero" class="w-full border border-slate-200 rounded-lg p-3 bg-white shadow-sm">
                        <option>Todos los zoocriaderos</option>
                        <option>Norte</option>
                        <option>Sur</option>
                        <option>Este</option>
                    </select>
                </div>
            </div>
        </aside>

        <!-- Main panel -->
        <section class="col-span-9">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-[#1f566a]">Seguimientos Registrados</h1>
                    <p class="text-slate-500 mt-1">5 registros encontrados</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="inline-flex items-center bg-white rounded-full p-1 shadow-soft">
                        <button id="view-cards" class="px-4 py-2 rounded-full text-sm bg-white/80 text-slate-700 font-medium hover:bg-white transition">Tarjetas</button>
                        <button id="view-list" class="px-4 py-2 rounded-full text-sm text-slate-500 hover:bg-white transition">Lista</button>
                    </div>
                </div>
            </div>

            <!-- Grid de tarjetas -->
            <div id="cards-container" class="grid grid-cols-2 gap-6">
                <!-- Card template 1 -->
                <article class="card p-6 border-2 border-[#d6f3de] transform transition hover:scale-[1.01]">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-3">
                            <div class="w-3.5 h-3.5 rounded-full bg-green-400 shadow"></div>
                            <div class="text-xs uppercase tracking-wide text-slate-500">Óptimo</div>
                        </div>
                        <button class="p-2 bg-slate-100 rounded-xl hover:bg-slate-200 transition" title="Ver">
                            <svg class="w-5 h-5 text-slate-500" viewBox="0 0 24 24" fill="none">
                                <path d="M12 5c4.97 0 9 3.58 9 7s-4.03 7-9 7-9-3.58-9-7 4.03-7 9-7z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <h2 class="text-2xl font-bold mt-4 text-[#0f4a5b]">Control de Agua</h2>

                    <div class="mt-4 grid grid-cols-2 gap-2 text-sm text-slate-500">
                        <div class="flex items-center gap-2"><svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none">
                                <path d="M7 10h10M12 3v4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>Fecha <span class="ml-auto text-slate-700">19 nov</span></div>
                        <div class="flex items-center gap-2"><svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none">
                                <path d="M12 12a4 4 0 100-8 4 4 0 000 8z" stroke="currentColor" stroke-width="1.2" />
                            </svg>Realizó <span class="ml-auto text-slate-700">Juan</span></div>
                        <div class="flex items-center gap-2"><svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none">
                                <path d="M3 12h18M12 3v18" stroke="currentColor" stroke-width="1.2" />
                            </svg>Zoocriadero <span class="ml-auto text-slate-700">Norte</span></div>
                        <div class="flex items-center gap-2"><svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none">
                                <path d="M4 6h16M6 12h12M10 18h4" stroke="currentColor" stroke-width="1.2" />
                            </svg>Tanque <span class="ml-auto text-slate-700">Circular</span></div>
                    </div>

                    <hr class="my-4 border-slate-100">

                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-xl bg-slate-50 p-3 text-center">
                            <div class="text-xs text-slate-400">pH</div>
                            <div class="text-2xl font-bold text-[#124b65] mt-1">7.2</div>
                        </div>
                        <div class="rounded-xl bg-[#fff0e2] p-3 text-center">
                            <div class="text-xs text-slate-400">Temp</div>
                            <div class="text-2xl font-bold text-[#b65d2c] mt-1">24°</div>
                        </div>
                        <div class="rounded-xl bg-[#e6fbfa] p-3 text-center">
                            <div class="text-xs text-slate-400">Cloro</div>
                            <div class="text-2xl font-bold text-[#167d81] mt-1">0.5</div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-xl bg-slate-50 p-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-md bg-success flex items-center justify-center text-green-700">↗</div>
                            <div>
                                <div class="text-xs text-slate-400">Alevines</div>
                                <div class="font-semibold">1500</div>
                            </div>
                        </div>
                        <div class="h-7 w-px bg-slate-200"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-md bg-danger flex items-center justify-center text-red-600">↘</div>
                            <div>
                                <div class="text-xs text-slate-400">Mortalidad</div>
                                <div class="font-semibold">12</div>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Card template 2 (copy with different data) -->
                <article class="card p-6 border-2 border-[#d6f3de] transform transition hover:scale-[1.01]">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-3">
                            <div class="w-3.5 h-3.5 rounded-full bg-green-400 shadow"></div>
                            <div class="text-xs uppercase tracking-wide text-slate-500">Óptimo</div>
                        </div>
                        <button class="p-2 bg-slate-100 rounded-xl hover:bg-slate-200 transition" title="Ver">
                            <svg class="w-5 h-5 text-slate-500" viewBox="0 0 24 24" fill="none">
                                <path d="M12 5c4.97 0 9 3.58 9 7s-4.03 7-9 7-9-3.58-9-7 4.03-7 9-7z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <h2 class="text-2xl font-bold mt-4 text-[#0f4a5b]">Alimentación</h2>

                    <div class="mt-4 grid grid-cols-2 gap-2 text-sm text-slate-500">
                        <div class="flex items-center gap-2">Fecha <span class="ml-auto text-slate-700">20 nov</span></div>
                        <div class="flex items-center gap-2">Realizó <span class="ml-auto text-slate-700">María</span></div>
                        <div class="flex items-center gap-2">Zoocriadero <span class="ml-auto text-slate-700">Sur</span></div>
                        <div class="flex items-center gap-2">Tanque <span class="ml-auto text-slate-700">Rectangular</span></div>
                    </div>

                    <hr class="my-4 border-slate-100">

                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-xl bg-slate-50 p-3 text-center">
                            <div class="text-xs text-slate-400">pH</div>
                            <div class="text-2xl font-bold text-[#124b65] mt-1">6.8</div>
                        </div>
                        <div class="rounded-xl bg-[#fff0e2] p-3 text-center">
                            <div class="text-xs text-slate-400">Temp</div>
                            <div class="text-2xl font-bold text-[#b65d2c] mt-1">26°</div>
                        </div>
                        <div class="rounded-xl bg-[#e6fbfa] p-3 text-center">
                            <div class="text-xs text-slate-400">Cloro</div>
                            <div class="text-2xl font-bold text-[#167d81] mt-1">0.8</div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-xl bg-slate-50 p-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-md bg-success flex items-center justify-center text-green-700">↗</div>
                            <div>
                                <div class="text-xs text-slate-400">Alevines</div>
                                <div class="font-semibold">2300</div>
                            </div>
                        </div>
                        <div class="h-7 w-px bg-slate-200"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-md bg-danger flex items-center justify-center text-red-600">↘</div>
                            <div>
                                <div class="text-xs text-slate-400">Mortalidad</div>
                                <div class="font-semibold">8</div>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Additional cards (you can duplicate for more) -->
                <article class="card p-6 border-2 border-[#ffe6e6] transform transition hover:scale-[1.01]">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-3">
                            <div class="w-3.5 h-3.5 rounded-full bg-red-300 shadow"></div>
                            <div class="text-xs uppercase tracking-wide text-slate-500">Crítico</div>
                        </div>
                        <button class="p-2 bg-slate-100 rounded-xl hover:bg-slate-200 transition" title="Ver">
                            <svg class="w-5 h-5 text-slate-500" viewBox="0 0 24 24" fill="none">
                                <path d="M12 5c4.97 0 9 3.58 9 7s-4.03 7-9 7-9-3.58-9-7 4.03-7 9-7z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>

                    <h2 class="text-2xl font-bold mt-4 text-[#7a2b2b]">Control sanitario</h2>

                    <div class="mt-4 grid grid-cols-2 gap-2 text-sm text-slate-500">
                        <div class="flex items-center gap-2">Fecha <span class="ml-auto text-slate-700">21 nov</span></div>
                        <div class="flex items-center gap-2">Realizó <span class="ml-auto text-slate-700">Carlos</span></div>
                        <div class="flex items-center gap-2">Zoocriadero <span class="ml-auto text-slate-700">Este</span></div>
                        <div class="flex items-center gap-2">Tanque <span class="ml-auto text-slate-700">Concreto</span></div>
                    </div>

                    <hr class="my-4 border-slate-100">

                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-xl bg-slate-50 p-3 text-center">
                            <div class="text-xs text-slate-400">pH</div>
                            <div class="text-2xl font-bold text-[#124b65] mt-1">6.1</div>
                        </div>
                        <div class="rounded-xl bg-[#fff0e2] p-3 text-center">
                            <div class="text-xs text-slate-400">Temp</div>
                            <div class="text-2xl font-bold text-[#b65d2c] mt-1">29°</div>
                        </div>
                        <div class="rounded-xl bg-[#e6fbfa] p-3 text-center">
                            <div class="text-xs text-slate-400">Cloro</div>
                            <div class="text-2xl font-bold text-[#167d81] mt-1">1.2</div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-xl bg-slate-50 p-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-md bg-success flex items-center justify-center text-green-700">↗</div>
                            <div>
                                <div class="text-xs text-slate-400">Alevines</div>
                                <div class="font-semibold">900</div>
                            </div>
                        </div>
                        <div class="h-7 w-px bg-slate-200"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-md bg-danger flex items-center justify-center text-red-600">↘</div>
                            <div>
                                <div class="text-xs text-slate-400">Mortalidad</div>
                                <div class="font-semibold">25</div>
                            </div>
                        </div>
                    </div>
                </article>

            </div>
        </section>
    </main>

    <script src="../../../src/js/segzoo-consultar.js"></script>
</body>

</html>