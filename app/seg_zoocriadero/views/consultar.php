<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Seguimientos - Zoocriaderos</title>
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <style>
        /* Estilo personalizado para un hover sutil en la fila */
        .table-row-hover:hover {
            background-color: #f0f9ff;
            /* sky-50 */
            transform: scale(1.005);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="bg-gray-50 p-6 font-sans">
    <div class="max-w-7xl mx-auto mt-8">

        <h1 class="text-4xl font-extrabold text-center mb-10 text-gray-800">
            🔎 Módulo de Consulta de Seguimientos
        </h1>

        <div class="bg-white p-6 md:p-8 shadow-xl rounded-2xl mb-8 transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-2xl font-bold mb-5 text-sky-700 border-b pb-3">Filtros de Búsqueda</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div>
                    <label for="filtro_zoo" class="block font-medium mb-1 text-gray-700">Zoocriadero</label>
                    <select id="filtro_zoo" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-sky-300 transition duration-200">
                        <option value="">Todos los Zoocriaderos</option>
                    </select>
                </div>

                <div>
                    <label for="filtro_tipo_tanque" class="block font-medium mb-1 text-gray-700">Tipo de Tanque</label>
                    <select id="filtro_tipo_tanque" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-sky-300 transition duration-200">
                        <option value="">Todos los Tipos</option>
                    </select>
                </div>

                <div>
                    <label for="filtro_operario" class="block font-medium mb-1 text-gray-700">Realizado por</label>
                    <select id="filtro_operario" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-sky-300 transition duration-200">
                        <option value="">Todos los Operarios</option>
                    </select>
                </div>

                <div class="md:self-end">
                    <button type="button" class="w-full p-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-xl 
                                                 transition-all duration-300 shadow-md hover:shadow-lg">
                        Aplicar Filtros
                    </button>
                </div>

            </div>
        </div>

        <div class="bg-white p-4 md:p-6 shadow-xl rounded-2xl overflow-x-auto transition-all duration-300">

            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h2 class="text-xl font-bold text-gray-700">Resultados de Seguimientos</h2>
                <span class="text-sm text-gray-500">Total: 45 registros</span>
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-sky-50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider rounded-tl-xl">Fecha</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">Zoocriadero</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">Tanque</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">Actividades</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-sky-700 uppercase tracking-wider">Realizó</th>
                        <th class="px-3 py-3 text-center text-xs font-bold text-sky-700 uppercase tracking-wider rounded-tr-xl">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaSeguimientos" class="bg-white divide-y divide-gray-200">
                    <tr class="table-row-hover transition duration-150 ease-in-out">
                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2025-11-20</td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">San Luisa</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800">#1 Siembra</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">Lavado, Aspirado</td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">Juan Pérez</td>
                        <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-between">
                            <a href="#" class="text-sky-600 hover:text-sky-900 font-semibold transition duration-150 ease-in-out">Ver Detalle</a>
                            <a href="#" class="text-sky-600 hover:text-sky-900 font-semibold transition duration-150 ease-in-out">Editar</a>
                            <a href="#" class="text-sky-600 hover:text-sky-900 font-semibold transition duration-150 ease-in-out">Anular</a>
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="mt-6 flex justify-between items-center border-t pt-4">
                <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-150">
                    Anterior
                </button>
                <span class="text-sm text-gray-600">Página 1 de 5</span>
                <button class="px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700 transition duration-150">
                    Siguiente
                </button>
            </div>

        </div>
    </div>

    <script src="../../../src/js/segzoo-consultar.js"></script>
</body>

</html>