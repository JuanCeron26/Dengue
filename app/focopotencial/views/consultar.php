<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Focos Potenciales</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
</head>

<body>
    <div class="bg-linear-to-br from-emerald-50 to-blue-50 min-h-screen py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-emerald-800 mb-2">
                    Lista de Focos Potenciales encontrados
                </h1>
                <p class="text-emerald-700">Consulta y gestiona los registros de focos identificados</p>
                <div class="w-24 h-1 bg-linear-to-r from-emerald-600 to-blue-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Search -->
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 text-emerald-600 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Buscar por dirección, responsable o lugar..."
                            class="w-full pl-12 pr-4 py-3 border-2 border-emerald-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" />
                    </div>
                </div>
            </div>

            <!-- Results Count -->
            <div id="resultsCount" class="mb-4 text-emerald-700 font-medium">
                Mostrando 0 de 0 registros
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-linear-to-r from-emerald-700 to-teal-700 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold">Fecha</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Realizó</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Dirección</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Tipo de Foco</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Lugar</th>
                                <th class="px-6 py-4 text-center text-sm font-bold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-slate-200">
                            <!-- Rows will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden text-center py-12">
                    <div class="text-slate-400 mb-2">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <p class="text-slate-600 text-lg font-medium">No se encontraron registros</p>
                    <p class="text-slate-500 text-sm">Intenta ajustar los filtros de búsqueda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-linear-to-r from-emerald-700 to-teal-700 text-white p-6 rounded-t-2xl">
                <h2 id="modalTitle" class="text-2xl font-bold">Detalle del Foco</h2>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-emerald-50 rounded-xl border-2 border-emerald-200">
                        <p class="text-sm font-semibold text-emerald-800 mb-1">Realizó</p>
                        <p id="modalRealizo" class="text-slate-700"></p>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-xl border-2 border-blue-200">
                        <p class="text-sm font-semibold text-blue-800 mb-1">Fecha</p>
                        <p id="modalFecha" class="text-slate-700"></p>
                    </div>

                    <div class="p-4 bg-sky-50 rounded-xl border-2 border-sky-200">
                        <p class="text-sm font-semibold text-sky-800 mb-1">Dirección</p>
                        <p id="modalDireccion" class="text-slate-700"></p>
                    </div>

                    <div class="p-4 bg-teal-50 rounded-xl border-2 border-teal-200">
                        <p class="text-sm font-semibold text-teal-800 mb-1">Tipo de Foco</p>
                        <p id="modalTipoFoco" class="text-slate-700"></p>
                    </div>

                    <div class="p-4 bg-emerald-50 rounded-xl border-2 border-emerald-200">
                        <p class="text-sm font-semibold text-emerald-800 mb-1">Lugar Específico</p>
                        <p id="modalLugar" class="text-slate-700"></p>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-xl border-2 border-blue-200">
                        <p class="text-sm font-semibold text-blue-800 mb-1">Estado</p>
                        <span id="modalEstado" class="inline-block px-3 py-1 text-sm font-semibold rounded-full border"></span>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-slate-50 rounded-b-2xl flex justify-end gap-3">
                <button
                    id="closeModalBtn"
                    class="px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-300 transition-colors">
                    Cerrar
                </button>
                <button
                    id="editFromModalBtn"
                    class="px-6 py-3 bg-linear-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-teal-700 transition-colors shadow-lg">
                    Editar Registro
                </button>
            </div>
        </div>
    </div>

    <!--Editar-->
    <div id="modalEditar"
        class="fixed inset-0 z-50 hidden items-center justify-center
            bg-black/40 backdrop-blur-sm mx-auto
            opacity-0 invisible transition-all duration-300">

        <div id="modalContent"
            class="bg-white w-full max-w-xl rounded-2xl shadow-2xl p-6 sm:p-8
              transform scale-95 transition-all duration-300
              border-t-8 border-teal-700
              max-h-[90vh] overflow-auto">
            <h2 class="text-2xl font-bold text-emerald-700 mb-6">
                Editar Registro
            </h2>

            <!-- FORMULARIO -->
            <form id="formEditar" class="space-y-5">
                <input type="hidden" name="cod_focopotlugar" id="cod_focopotlugar">
                <!-- FECHA -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Fecha</label>
                    <input type="date" id="editFecha" name="fecha"
                        class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <!-- REALIZÓ -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Realizó</label>
                    <select id="editRealizo" name="realizo"
                        class="w-full border border-slate-300 rounded-lg p-2 bg-white focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">Seleccione...</option>
                    </select>
                </div>

                <!-- DIRECCIÓN -->
                <div class="space-y-2 bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <label class="block font-semibold text-slate-700">Dirección</label>

                    <div class="grid grid-cols-3 gap-3">
                        <select id="dirTipo" name="dirTipo"
                            class="border border-slate-300 rounded-lg p-2 bg-white focus:ring-2 focus:ring-teal-600">
                            <option value="Avenida">Avenida</option>
                            <option value="Carrera">Carrera</option>
                            <option value="Calle">Calle</option>
                        </select>

                        <input id="dirNumero" type="text" placeholder="Número Letra" name="direccion1"
                            class="border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-600">

                        <input id="dirNumero2" type="text" value="#" readonly name="#"
                            class="border border-slate-300 text-black bg-gray-200 rounded-lg p-2 focus:ring-2 focus:ring-teal-600">
                    </div>

                    <input id="dirComplemento" type="text" placeholder="Complemento" name="direccion2"
                        class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-600">
                </div>

                <!-- TIPO DE FOCO -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Tipo de Foco</label>
                    <select id="editFoco" name="cod_tipo_foc"
                        class="w-full border border-slate-300 rounded-lg p-2 bg-white focus:ring-2 focus:ring-teal-600 focus:outline-none">
                        <option value="">Seleccione...</option>
                    </select>
                </div>

                <!-- LUGAR -->
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Lugar</label>
                    <input type="text" id="editLugar" name="lugar"
                        class="w-full border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-600 focus:outline-none">
                </div>

                <!-- BOTONES -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" id="btnCerrarEditar"
                        class="cursor-pointer px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 hover:rotate-3 hover:scale-110 transition">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="cursor-pointer px-5 py-2 rounded-lg bg-teal-700 text-white font-semibold shadow hover:bg-teal-800 hover:rotate-3 hover:scale-110 transition">
                        Guardar Cambios
                    </button>
                </div>
            </form>

        </div>
    </div>


    <script src="../../../src/js/foco-consultar.js"></script>
</body>

</html>