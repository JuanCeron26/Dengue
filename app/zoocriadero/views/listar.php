<?php
include_once "../models/modelListar.php";
include_once "../models/modelVerDetalle.php";
include_once "../models/modelEditar.php";

// Instanciar modelos
$modelListar = new modelListar();
$modelEditar = new modelEditar();

// Obtener datos para los filtros
$zoocriaderos = $modelListar->SelectZoo();
$encargados = $modelListar->SelectEncargado();
$tiposTanque = $modelListar->SelectTiposTanque();

// Aplicar filtros si existen
$zoocriaderosFiltrados = $zoocriaderos;

if (!empty($_GET)) {
    $zoocriaderosFiltrados = array_filter($zoocriaderos, function($zoo) {
        $cumpleFiltros = true;
        
        // Filtro por nombre
        if (!empty($_GET['nombre']) && $_GET['nombre'] != $zoo['cod_zoo']) {
            $cumpleFiltros = false;
        }
        
        // Filtro por encargado
        if (!empty($_GET['encargado']) && $_GET['encargado'] != $zoo['id_usuarios']) {
            $cumpleFiltros = false;
        }
        
        // Filtro por tipo de tanque
        if (!empty($_GET['tipo_tanque']) && $_GET['tipo_tanque'] != $zoo['nomtiptan']) {
            $cumpleFiltros = false;
        }
        
        // Filtro por dirección
        if (!empty($_GET['direccion']) && stripos($zoo['direccion_zoo'], $_GET['direccion']) === false) {
            $cumpleFiltros = false;
        }
        
        return $cumpleFiltros;
    });
}

// Paginación
$registrosPorPagina = 8;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$totalRegistros = count($zoocriaderosFiltrados);
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
$offset = ($paginaActual - 1) * $registrosPorPagina;
$zoocriaderosPaginados = array_slice($zoocriaderosFiltrados, $offset, $registrosPorPagina);

// Obtener barrios para el modal de edición
$barrios = $modelEditar->ObtenerBarrios();
$encargadosEditar = $modelEditar->ObtenerEncargados();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Zoocriadero</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    
    <!-- Mensaje de éxito/error -->
    <?php if(isset($_GET['success'])): ?>
        <div class="container mx-auto px-4 pt-4">
            <?php if($_GET['success'] == 'false'): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Error en la operación'; ?></span>
                </div>
            <?php else: ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Operación exitosa'; ?></span>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="container mx-auto px-4 py-8">
        <!-- Título -->
        <h1 class="text-3xl font-bold text-blue-600 mb-8">GESTIÓN DE ZOOCRIADERO</h1>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Panel de Filtros -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-500 text-white rounded-full p-3">
                            <i class="fas fa-filter"></i>
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold mb-4">Filtros</h2>

                    <form id="formFiltros" method="GET" action="listar.php">
                        <!-- Filtro Nombre -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">NOMBRE DE ZOOCRIADERO</label>
                            <select name="nombre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Todos --</option>
                                <?php foreach($zoocriaderos as $zoo): ?>
                                    <option value="<?php echo $zoo['cod_zoo']; ?>" <?php echo (isset($_GET['nombre']) && $_GET['nombre'] == $zoo['cod_zoo']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($zoo['nombre_zoo']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Filtro Encargado -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">ENCARGADO</label>
                            <select name="encargado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Todos --</option>
                                <?php foreach($encargados as $encargado): ?>
                                    <option value="<?php echo $encargado['id_usuarios']; ?>" <?php echo (isset($_GET['encargado']) && $_GET['encargado'] == $encargado['id_usuarios']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($encargado['nombre_usu'] . ' ' . $encargado['apellido_usu']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Filtro Tipo de Tanque -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">TIPO DE TANQUE</label>
                            <select name="tipo_tanque" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Todos --</option>
                                <?php foreach($tiposTanque as $tipo): ?>
                                    <option value="<?php echo htmlspecialchars($tipo['nomtiptan']); ?>" <?php echo (isset($_GET['tipo_tanque']) && $_GET['tipo_tanque'] == $tipo['nomtiptan']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($tipo['nomtiptan']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Filtro Dirección -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">DIRECCIÓN</label>
                            <input type="text" name="direccion" value="<?php echo isset($_GET['direccion']) ? htmlspecialchars($_GET['direccion']) : ''; ?>" placeholder="Buscar por dirección" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition">
                                Aplicar
                            </button>
                            <button type="button" onclick="limpiarFiltros()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-md transition">
                                Borrar filtros
                            </button>
                        </div>
                    </form>

                    <!-- Notas de validación -->
                    <div class="mt-6 text-xs text-gray-600">
                        <p class="font-semibold mb-2">Notas de validación:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Se validan caracteres inválidos (&lt;*/, etc.).</li>
                            <li>Si no hay resultados, se mostrará mensaje informativo.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tabla de Resultados -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <?php if(count($zoocriaderosPaginados) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NOMBRE DE ZOOCRIADERO</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ENCARGADO</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DIRECCIÓN</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php 
                                $contador = $offset + 1;
                                foreach($zoocriaderosPaginados as $zoo): 
                                ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $contador++; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($zoo['nombre_zoo']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php 
                                        if(!empty($zoo['nombre_usu'])) {
                                            echo htmlspecialchars($zoo['nombre_usu'] . ' ' . $zoo['apellido_usu']); 
                                        }
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($zoo['direccion_zoo']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex gap-2">
                                            <button onclick="verZoocriadero(<?php echo $zoo['cod_zoo']; ?>)" class="text-blue-600 hover:text-blue-800" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick="editarZoocriadero(<?php echo $zoo['cod_zoo']; ?>)" class="text-green-600 hover:text-green-800" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="eliminarZoocriadero(<?php echo $zoo['cod_zoo']; ?>)" class="text-red-600 hover:text-red-800" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button onclick="exportarZoocriadero(<?php echo $zoo['cod_zoo']; ?>)" class="text-purple-600 hover:text-purple-800" title="Exportar">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <?php if($totalPaginas > 1): ?>
                    <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <?php if($paginaActual > 1): ?>
                            <a href="?pagina=<?php echo $paginaActual - 1; ?><?php echo http_build_query(array_merge($_GET, ['pagina' => $paginaActual - 1])); ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Anterior
                            </a>
                            <?php endif; ?>
                            <?php if($paginaActual < $totalPaginas): ?>
                            <a href="?pagina=<?php echo $paginaActual + 1; ?><?php echo http_build_query(array_merge($_GET, ['pagina' => $paginaActual + 1])); ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Siguiente
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Página <span class="font-medium"><?php echo $paginaActual; ?></span> / <span class="font-medium"><?php echo $totalPaginas; ?></span>
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <?php if($paginaActual > 1): ?>
                                    <a href="?<?php echo http_build_query(array_merge($_GET, ['pagina' => $paginaActual - 1])); ?>" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Anterior
                                    </a>
                                    <?php endif; ?>
                                    <?php if($paginaActual < $totalPaginas): ?>
                                    <a href="?<?php echo http_build_query(array_merge($_GET, ['pagina' => $paginaActual + 1])); ?>" class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Siguiente
                                    </a>
                                    <?php endif; ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php else: ?>
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-4"></i>
                        <p class="text-lg">No se encontraron resultados</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Zoocriadero -->
    <div id="modalVer" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
            <!-- Header -->
            <div class="bg-blue-200 px-6 py-4 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-500 text-white rounded-full p-2">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Ver Zoocriadero</h3>
                            <p class="text-sm text-gray-600">Información detallada</p>
                        </div>
                    </div>
                    <button onclick="cerrarModal('modalVer')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-6">
                <div class="space-y-4" id="contenidoModalVer">
                    <div class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-4xl text-blue-500"></i>
                        <p class="mt-4 text-gray-600">Cargando información...</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end gap-3">
                <button onclick="cerrarModal('modalVer')" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-md transition">
                    Cerrar
                </button>
                <button onclick="abrirModalEditarDesdeVer()" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-md transition flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Editar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Editar Zoocriadero -->
    <div id="modalEditar" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-0 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
            <!-- Header -->
            <div class="bg-blue-200 px-6 py-4 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-500 text-white rounded-full p-2">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Editar Zoocriadero</h3>
                            <p class="text-sm text-gray-600">Información detallada</p>
                        </div>
                    </div>
                    <button onclick="cerrarModal('modalEditar')" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-6">
                <form id="formEditar">
                    <input type="hidden" id="edit_cod_zoo" name="cod_zoo">
                    <div class="space-y-4" id="contenidoModalEditar">
                        <div class="text-center py-8">
                            <i class="fas fa-spinner fa-spin text-4xl text-blue-500"></i>
                            <p class="mt-4 text-gray-600">Cargando información...</p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-end gap-3">
                <button onclick="cerrarModal('modalEditar')" type="button" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-md transition">
                    Cerrar
                </button>
                <button onclick="guardarEdicion()" type="button" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-md transition flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Datos para JS -->
    <script>
        const BARRIOS = <?php echo json_encode($barrios); ?>;
        const ENCARGADOS = <?php echo json_encode($encargadosEditar); ?>;
    </script>

    <script src="../js/zoo-listar.js"></script>
</body>
</html>