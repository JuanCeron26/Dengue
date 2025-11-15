
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gestión de Zoocriadero</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">
    <?php include_once '../../../src/includes/aside-zoo.php'; ?>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-sky-700 mb-6">
            GESTIÓN DE ZOOCRIADERO
        </h1>


        <div class="flex gap-6">
            <!-- PANEL IZQUIERDO -->
            <aside class="w-80 bg-slate-100 rounded-lg p-5 shadow">
                <div class="w-full flex justify-start">
                    <a href="registrarzoo.php" id="btnNew"
                        class="w-10 h-10 bg-sky-600 text-white font-semibold rounded-full mb-5 flex items-center justify-center shadow-lg">
                        <img src="../../../iconos/plus-circle-fill.svg" class="w-5 h-5 invert" alt="agregar">
                    </a>

                </div>





                <div class="bg-slate-200 rounded-md p-4">
                    <h2 class="text-xl font-semibold text-slate-700 mb-3">Filtros</h2>

                    <!-- FILTRO: NOMBRE DEL ZOOCRIADERO -->
                    <label class="block mb-3">
                        <span class="block text-sm font-medium text-slate-700">NOMBRE DE ZOOCRIADERO</span>
                        <select id="filterName" class="mt-1 block w-full rounded-md border p-2">
                            <option value="">-- Todos --</option>
                            <?php foreach ($zoocriaderos as $zoo) { ?>
                                <option value="<?php echo $zoo['cod_zoo'] ?>"><?php echo $zoo['nombre_zoo']; ?></option>
                            <?php } ?>
                        </select>
                    </label>

                    <!-- FILTRO: ENCARGADO -->
                    <label class="block mb-3">
                        <span class="block text-sm font-medium text-slate-700">ENCARGADO</span>
                        <select id="filterEncargado" class="mt-1 block w-full rounded-md border p-2">
                            <option value="">-- Todos --</option>
                            <?php foreach ($admins as $admin) { ?>
                                <option value="<?php echo $admin['id_usuarios'] ?>"><?php echo $admin['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </label>

                    <label class="block mb-3">
                        <span class="block text-sm font-medium text-slate-700">TIPO DE TANQUE</span>
                        <select id="filterTipo" class="mt-1 block w-full rounded-md border p-2">
                            <option value="">-- Todos --</option>
                            <option value="Acuícola">Acuícola</option>
                            <option value="Reproductor">Reproductor</option>
                            <option value="Cría">Cría</option>
                        </select>
                    </label>

                    <label class="block mb-4">
                        <span class="block text-sm font-medium text-slate-700">DIRECCIÓN</span>
                        <input id="filterDireccion" type="text" placeholder="Buscar por dirección"
                            class="mt-1 block w-full rounded-md border p-2" />
                    </label>

                    <div class="flex justify-between">
                        <button id="btnApplyFilters" class="px-4 py-2 bg-sky-500 text-white rounded-md">Aplicar</button>
                        <button id="btnClearFilters" class="px-4 py-2 bg-slate-300 rounded-md">Borrar filtros</button>
                    </div>
                </div>

                <div class="mt-4 text-sm text-slate-600">
                    <p class="font-semibold">Notas de validación:</p>
                    <ul class="list-disc list-inside mt-2">
                        <li>Se validan caracteres inválidos (<>/; etc.).</li>
                        <li>Si no hay resultados, se mostrará mensaje informativo.</li>
                    </ul>
                </div>
            </aside>

            <!-- PANEL DERECHO -->
            <main class="flex-1 bg-slate-100 p-4 rounded-lg shadow">
                <!-- ENCABEZADO -->
                <div class="overflow-x-auto rounded-lg w-full">

                    <table class="w-full border-collapse bg-white rounded-lg shadow">

                        <thead class="bg-sky-200 text-sky-900 text-sm font-semibold">
                            <tr>
                                <th class="py-3 px-2 text-center w-[8%]">#</th>
                                <th class="py-3 px-2 text-left w-[20%]">NOMBRE DE ZOOCRIADERO</th>
                                <th class="py-3 px-2 text-left w-[18%]">ENCARGADO</th>
                                <th class="py-3 px-2 text-left w-[20%]">DIRECCIÓN</th>
                                <th class="py-3 px-2 text-center w-[10%]">TIPO DE TANQUE</th>
                                <th class="py-3 px-2 text-center w-[10%]">TANQUE</th>
                                <th class="py-3 px-2 text-center w-[80%]">ACCIONES</th>
                            </tr>
                        </thead>

                        <!-- se agregó id="tbody" -->
                        <tbody id="tbody" class="text-sm divide-y divide-slate-200">
                            <tr class="hover:bg-slate-50" data-id="2">
                                <td class="py-3 text-center font-medium">2</td>
                                <td class="py-3">Luisa Toro</td>
                                <td class="py-3">Luisa Toro</td>
                                <td class="py-3">Cra.203-22</td>
                                <td class="py-3 text-center">Acuícola</td>
                                <td class="py-3 text-center">25</td>
                                <td class="py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <img src="../../../src/img/plus-circle-fill.svg" title="Ver" class="btn-view w-5 h-5 cursor-pointer hover:scale-110 transition">
                                        <img src="../../../src/img/edit.svg" title="Editar" class="btn-edit w-5 h-5 cursor-pointer hover:scale-110 transition">
                                        <img src="../../../src/img/trash-2.svg" title="Anular" class="btn-delete w-5 h-5 cursor-pointer hover:scale-110 transition">
                                        <img src="../../../src/img/upload.svg" title="Exportar" class="btn-export w-5 h-5 cursor-pointer hover:scale-110 transition">
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50" data-id="1">
                                <td class="py-3 text-center font-medium">1</td>
                                <td class="py-3">Luisa</td>
                                <td class="py-3">Luisa</td>
                                <td class="py-3">Cra.203-22</td>
                                <td class="py-3 text-center">Reproductor</td>
                                <td class="py-3 text-center">25</td>
                                <td class="py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <img src="../../../src/img/plus-circle-fill.svg" title="Ver" class="btn-view w-5 h-5 cursor-pointer hover:scale-110 transition">
                                        <img src="../../../src/img/edit.svg" title="Editar" class="btn-edit w-5 h-5 cursor-pointer hover:scale-110 transition">
                                        <img src="../../../src/img/trash-2.svg" title="Anular" class="btn-delete w-5 h-5 cursor-pointer hover:scale-110 transition">
                                        <img src="../../../src/img/upload.svg" title="Exportar" class="btn-export w-5 h-5 cursor-pointer hover:scale-110 transition">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>



                <!-- PAGINACIÓN -->
                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <button id="prevPage" class="px-3 py-1 bg-slate-200 rounded mr-2">Anterior</button>
                        <button id="nextPage" class="px-3 py-1 bg-slate-200 rounded">Siguiente</button>
                    </div>
                    <div class="text-sm text-slate-600">
                        Página <span id="currentPage">1</span> / <span id="totalPages">1</span>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- ======== MODALES (IGUALES) ======== -->
    <!-- Modal: Registro / Editar -->
    <div id="modalForm" class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">
        <div class="bg-white rounded-lg w-11/12 max-w-2xl p-6">
            <h3 id="modalTitle" class="text-xl font-bold mb-4">Registrar Zoocriadero</h3>
            <form id="form">
                <input type="hidden" id="editingId" value="">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Nombre *</label>
                        <input id="name" class="mt-1 block w-full rounded border p-2" />
                        <p id="errName" class="text-red-600 text-sm hidden mt-1"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Encargado *</label>
                        <input id="encargado" class="mt-1 block w-full rounded border p-2" />
                        <p id="errEncargado" class="text-red-600 text-sm hidden mt-1"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tipo de tanque *</label>
                        <select id="tipo" class="mt-1 block w-full rounded border p-2">
                            <option value="">-- Seleccione --</option>
                            <option value="Acuícola">Acuícola</option>
                            <option value="Reproductor">Reproductor</option>
                            <option value="Cría">Cría</option>
                        </select>
                        <p id="errTipo" class="text-red-600 text-sm hidden mt-1"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tanque *</label>
                        <input id="tanque" class="mt-1 block w-full rounded border p-2" />
                        <p id="errTanque" class="text-red-600 text-sm hidden mt-1"></p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Dirección *</label>
                        <input id="direccion" class="mt-1 block w-full rounded border p-2" />
                        <p id="errDireccion" class="text-red-600 text-sm hidden mt-1"></p>
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-3">
                    <button type="button" id="btnCancelForm" class="px-4 py-2 rounded bg-slate-200">Cancelar</button>
                    <button type="submit" id="btnSubmitForm" class="px-4 py-2 rounded bg-sky-600 text-white">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Ver detalle -->
    <div id="modalView" class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">
        <div class="bg-white rounded-lg w-11/12 max-w-xl p-6">
            <h3 class="text-xl font-bold mb-4">Detalle del Zoocriadero</h3>
            <div id="detailContent" class="space-y-2 text-sm"></div>
            <div class="mt-4 text-right">
                <button id="btnCloseView" class="px-4 py-2 rounded bg-slate-200">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Modal: Confirmar eliminar -->
    <div id="modalDelete" class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">
        <div class="bg-white rounded-lg w-11/12 max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Confirmar anulación</h3>
            <p id="deleteMsg">¿Desea inhabilitar el zoocriadero seleccionado?</p>
            <div class="mt-4 flex justify-end gap-3">
                <button id="btnCancelDelete" class="px-4 py-2 rounded bg-slate-200">No</button>
                <button id="btnConfirmDelete" class="px-4 py-2 rounded bg-red-600 text-white">Sí, anular</button>
            </div>
        </div>
    </div>

    <!-- Modal: Exportar -->
    <div id="modalExport" class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">
        <div class="bg-white rounded-lg w-11/12 max-w-md p-6">
            <h3 class="text-xl font-bold mb-4">Exportar registro</h3>
            <p>Seleccione formato:</p>
            <div class="mt-4 flex gap-4">
                <button id="exportCSV" class="px-4 py-2 bg-sky-600 text-white rounded">Excel (CSV)</button>
                <button id="exportPDF" class="px-4 py-2 bg-slate-700 text-white rounded">PDF (Imprimir)</button>
            </div>
            <div class="mt-6 text-right">
                <button id="btnCloseExport" class="px-4 py-2 rounded bg-slate-200">Cerrar</button>
            </div>
        </div>
    </div>


    <div id="printable" class="hidden"></div>
    <script src="../../../src/js/aside.js"></script>
    <script src="../../../src/js/zoo-listar.js"></script>
</body>

</html>