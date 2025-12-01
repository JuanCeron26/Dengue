<?php
include_once '../controllers/controllerListar.php';

$obj = new ListarZoo();
$zoocriaderos = $obj->MostrarLista();
$admins = $obj->ObtenerEncargados();
$tiposTanque = $obj->ObtenerTiposTanque();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Gestión de Zoocriadero</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800">

    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-3xl font-bold text-sky-700 mb-6">
            GESTIÓN DE ZOOCRIADERO
        </h1>

        <div class="flex gap-6">

            <!-- PANEL IZQUIERDO -->
            <aside class="w-80 bg-slate-100 rounded-lg p-5 shadow">

                <div class="w-full flex justify-start">
                    <a href="registrar.php" id="btnNew"
                        class="w-10 h-10 bg-sky-600 text-white font-semibold rounded-full mb-5 flex items-center justify-center shadow-lg">
                        <img src="../../../src/icons/plus-circle-fill.svg" class="w-5 h-5 invert" alt="agregar">
                    </a>
                </div>

                <form id="filterForm">
                    <div class="bg-slate-200 rounded-md p-4">
                        <h2 class="text-xl font-semibold text-slate-700 mb-3">Filtros</h2>

                        <!-- FILTRO: NOMBRE DE ZOOCRIADERO -->
                        <label class="block mb-3">
                            <span class="block text-sm font-medium text-slate-700">NOMBRE DE ZOOCRIADERO</span>
                            <select id="filterName" class="mt-1 block w-full rounded-md border p-2">
                                <option value="">-- Todos --</option>

                                <?php if (!empty($zoocriaderos)) { ?>
                                    <?php foreach ($zoocriaderos as $zoo) { ?>
                                        <option value="<?= $zoo['cod_zoo'] ?>">
                                            <?= htmlspecialchars($zoo['nombre_zoo']) ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>

                            </select>
                        </label>

                        <!-- FILTRO: ENCARGADO -->
                        <label class="block mb-3">
                            <span class="block text-sm font-medium text-slate-700">ENCARGADO</span>
                            <select id="filterEncargado" name="filterEncargado" class="mt-1 block w-full rounded-md border p-2">
                                <option value="">-- Todos --</option>

                                <?php if (!empty($admins)) { ?>
                                    <?php foreach ($admins as $admin) { ?>
                                        <option value="<?= $admin['id_usuarios'] ?>">
                                            <?= htmlspecialchars($admin['nombre_usu'] . ' ' . $admin['apellido_usu']) ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>

                            </select>
                        </label>

                        <!-- TIPO DE TANQUE -->
                        <label class="block mb-3">
                            <span class="block text-sm font-medium text-slate-700">TIPO DE TANQUE</span>
                            <select id="filterTipo" name="filterTipo" class="mt-1 block w-full rounded-md border p-2">
                                <option value="">-- Todos --</option>

                                <?php if (!empty($tiposTanque)) { ?>
                                    <?php foreach ($tiposTanque as $tipo) { ?>
                                        <option value="<?= htmlspecialchars($tipo['nomtiptan']) ?>">
                                            <?= htmlspecialchars($tipo['nomtiptan']) ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>

                            </select>
                        </label>

                        <!-- DIRECCION -->
                        <label class="block mb-4">
                            <span class="block text-sm font-medium text-slate-700">DIRECCIÓN</span>
                            <input id="filterDireccion" type="text" placeholder="Buscar por dirección"
                                class="mt-1 block w-full rounded-md border p-2" />
                        </label>

                        <div class="flex justify-between">
                            <button id="btnApplyFilters" type="button" class="px-4 py-2 bg-sky-500 text-white rounded-md">Aplicar</button>
                            <button id="btnClearFilters" type="button" class="px-4 py-2 bg-slate-300 rounded-md">Borrar filtros</button>
                        </div>
                    </div>
                </form>

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

                <div class="overflow-x-auto rounded-lg w-full">

                    <table id="tableZoos" class="w-full border-collapse bg-white rounded-lg shadow">

                        <thead class="bg-sky-200 text-sky-900 text-sm font-semibold">
                            <tr>
                                <th class="py-3 px-2 text-center cursor-pointer hover:bg-sky-300" data-sort-key="index">#</th>
                                <th class="py-3 px-2 text-center cursor-pointer hover:bg-sky-300" data-sort-key="nombre">NOMBRE DE ZOOCRIADERO</th>
                                <th class="py-3 px-2 text-center cursor-pointer hover:bg-sky-300" data-sort-key="encargado">ENCARGADO</th>
                                <th class="py-3 px-2 text-center cursor-pointer hover:bg-sky-300" data-sort-key="direccion">DIRECCIÓN</th>
                                <th class="py-3 px-2 text-center">ACCIONES</th>
                            </tr>
                        </thead>

                        <tbody id="tbody" class="text-sm divide-y divide-slate-200">

                            <?php if (!empty($zoocriaderos)) { ?>

                                <?php foreach ($zoocriaderos as $index => $zoo) { ?>
                                    <tr class="hover:bg-slate-50"
                                        data-cod="<?= $zoo['cod_zoo'] ?>"
                                        data-nombre="<?= htmlspecialchars($zoo['nombre_zoo']) ?>"
                                        data-encargado="<?= htmlspecialchars($zoo['nombre_usu'] . ' ' . $zoo['apellido_usu']) ?>"
                                        data-encargado-id="<?= $zoo['id_usuarios'] ?>"
                                        data-barrio="<?= htmlspecialchars($zoo['barrio_zoo'] ?? '') ?>"
                                        data-direccion="<?= htmlspecialchars($zoo['direccion_zoo']) ?>"
                                        data-tipo="<?= htmlspecialchars($zoo['tipo_tanque'] ?? '') ?>">

                                        <td class="py-3 text-center font-medium"><?= $index + 1 ?></td>

                                        <td class="py-3 text-center font-medium"><?= htmlspecialchars($zoo['nombre_zoo']) ?></td>

                                        <td class="py-3 text-center font-medium">
                                            <?= htmlspecialchars($zoo['nombre_usu'] . ' ' . $zoo['apellido_usu']) ?>
                                        </td>

                                        <td class="py-3 text-center font-medium"><?= htmlspecialchars($zoo['direccion_zoo']) ?></td>

                                        <td class="py-3 text-center">
                                            <div class="flex justify-center gap-2">
                                                <img src="../../../src/icons/zoom.png" title="Ver" data-action="view"
                                                    class="w-5 h-5 cursor-pointer hover:scale-110 transition">
                                                <img src="../../../src/icons/edit.svg" title="Editar" data-action="edit"
                                                    class="w-5 h-5 cursor-pointer hover:scale-110 transition">
                                                <img src="../../../src/icons/trash-2.svg" title="Anular" data-action="delete"
                                                    class="w-5 h-5 cursor-pointer hover:scale-110 transition">
                                                <img src="../../../src/icons/upload.svg" title="Exportar" data-action="export"
                                                    class="w-5 h-5 cursor-pointer hover:scale-110 transition">
                                            </div>
                                        </td>

                                    </tr>
                                <?php } ?>

                            <?php } else { ?>

                                <tr>
                                    <td colspan="5" class="text-center py-4 text-slate-500">
                                        No hay registros disponibles.
                                    </td>
                                </tr>

                            <?php } ?>

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

    <!-- MODAL OVERLAY -->
    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

            <!-- HEADER -->
            <div class="bg-sky-400 p-4 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 id="modalTitle" class="text-white font-semibold text-lg">Ver Zoocriadero</h3>
                        <p class="text-sky-100 text-xs">Información detallada</p>
                    </div>
                </div>
                <button id="closeModal" class="text-white hover:text-sky-100 text-2xl font-bold leading-none">&times;</button>
            </div>

            <!-- FORM -->
            <form id="modalForm" action="editar.php" method="POST" class="p-6">
                <input type="hidden" name="cod_zoo" id="modal_cod_zoo">

                <div class="mb-4">
                    <label class="flex items-center gap-2 text-sm font-medium text-sky-700 mb-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                        </svg>
                        Nombre del Zoocriadero
                    </label>
                    <input name="nombre" id="modal_nombre" class="w-full border border-sky-200 rounded-lg p-3 bg-sky-50 text-slate-800" readonly>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-sky-700 mb-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            Encargado
                        </label>
                        <input id="modal_encargado" class="w-full border border-sky-200 rounded-lg p-3 bg-sky-50 text-slate-800" readonly>
                        <input type="hidden" name="id_usuarios" id="modal_encargado_id">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-sky-700 mb-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            Barrio
                        </label>
                        <input name="barrio" id="modal_barrio" class="w-full border border-sky-200 rounded-lg p-3 bg-sky-50 text-slate-800" readonly>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2 text-sm font-medium text-sky-700 mb-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Dirección
                    </label>
                    <div class="flex gap-2">
                        <input name="direccion" id="modal_direccion" class="flex-1 border border-sky-200 rounded-lg p-3 bg-sky-50 text-slate-800" readonly>
                        <button id="btnEditarDireccion" type="button" class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition font-medium hidden">
                            Editar Dirección
                        </button>
                    </div>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-sky-700 mb-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z" />
                            <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z" />
                            <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z" />
                        </svg>
                        Tanques Asociados
                    </label>
                    <div class="bg-sky-50 rounded-lg border border-sky-200 overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-sky-100 text-sky-800">
                                <tr>
                                    <th class="py-2 px-3 text-left font-medium">Tipo de Tanque</th>
                                    <th class="py-2 px-3 text-left font-medium">Nombre</th>
                                </tr>
                            </thead>
                            <tbody id="modal_tanques_list" class="divide-y divide-sky-100">
                                <tr>
                                    <td colspan="2" class="py-3 px-3 text-center text-slate-500">No hay tanques asociados</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" id="modalCancel" class="px-6 py-2 rounded-lg bg-slate-300 text-slate-700 font-medium hover:bg-slate-400 transition">Cerrar</button>
                    <button type="submit" id="modalSave" class="px-8 py-2 rounded-lg bg-sky-500 text-white font-semibold hover:bg-sky-600 transition hidden">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DE DIRECCIÓN -->
    <div id="modalDireccion" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-3xl">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-blue-500">Ingreso de Dirección</h2>
                <button type="button" id="btnCerrarModal" class="text-gray-400 hover:text-gray-600 text-3xl font-bold leading-none">×</button>
            </div>

            <!-- Grid de campos -->
            <div class="grid grid-cols-3 gap-6 mb-6">

                <!-- Tipo de Vía -->
                <div>
                    <label class="block text-sm font-medium text-blue-500 mb-2">Tipo de Vía</label>
                    <select id="tipoVia" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-cyan-500 bg-teal-50 text-gray-700">
                        <option value="">-</option>
                        <option value="Calle">Calle</option>
                        <option value="Carrera">Carrera</option>
                        <option value="Avenida">Avenida</option>
                        <option value="Diagonal">Diagonal</option>
                        <option value="Transversal">Transversal</option>
                    </select>
                </div>

                <!-- Número Vía -->
                <div>
                    <label class="block text-sm font-medium text-blue-500 mb-2">Número Vía</label>
                    <input type="text" id="numeroVia" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 bg-teal-50">
                </div>

                <!-- # -->
                <div>
                    <label class="block text-sm font-medium text-blue-500 mb-2">#</label>
                    <input type="text" id="numeroSimbolo" value="#" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 bg-teal-50" readonly>
                </div>

                <!-- Sufijo / Letra -->
                <div>
                    <label class="block text-sm font-medium text-blue-500 mb-2">Sufijo / Letra</label>
                    <input type="text" id="sufijo" maxlength="5" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 bg-teal-50">
                </div>

                <!-- Distancia -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-blue-500 mb-2">Distancia</label>
                    <input type="text" id="distancia" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500 bg-teal-50">
                </div>

            </div>

            <!-- Dirección Generada -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-blue-500 mb-2">DIRECCIÓN GENERADA</label>
                <div class="w-full px-4 py-4 border-2 border-gray-200 rounded-lg bg-teal-50 min-h-[60px] flex items-center">
                    <p id="vistaPrevia" class="text-lg text-gray-700 font-medium">-</p>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <button type="button" id="btnBorrarModal" class="bg-red-100 text-red-600 font-semibold px-8 py-3 rounded-lg hover:bg-red-200 transition-all uppercase">
                    BORRAR
                </button>
                <button type="button" id="btnBorrarUltimoModal" class="bg-yellow-100 text-yellow-700 font-semibold px-8 py-3 rounded-lg hover:bg-yellow-200 transition-all uppercase">
                    BORRAR ÚLTIMO
                </button>
                <button type="button" id="btnAplicarDireccion" class="bg-blue-400 text-white font-semibold px-8 py-3 rounded-lg hover:bg-blue-500 transition-all uppercase shadow-lg">
                    GUARDAR
                </button>
            </div>
        </div>
    </div>

    <script src="../../../src/js/zoo-listar.js"></script>

</body>

</html>