<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestión de Actividades</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#E9F8FF] font-sans">

  <!-- Contenedor principal: sidebar + contenido -->
  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-16 bg-green-100 min-h-screen flex flex-col items-center py-4 space-y-6">

      <button class="p-2 hover:bg-green-200 rounded">
        <img src="iconos/trash-2.svg" alt="">
      </button>

      <button class="p-2 hover:bg-green-200 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 3v18h18M7 13h10M7 9h10M7 17h5" />
        </svg>
      </button>

      <button class="p-2 hover:bg-green-200 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 4h8v16H8z" />
        </svg>
      </button>

      <button class="p-2 hover:bg-green-200 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4l3 3M12 6a9 9 0 100 18 9 9 0 000-18z" />
        </svg>
      </button>

    </aside>

  <!-- Main -->
  <main class="flex-1 p-6 bg-white">

    <h1 class="text-2xl font-bold mb-6">GESTIÓN DE ACTIVIDADES TRABAJO DE CAMPO</h1>

    <!-- Filtros -->
    <div class="flex flex-wrap gap-3 mb-6 items-center">
      <input type="date" id="filtro-fecha" class="px-3 py-2 rounded-md border border-gray-300">

      <select id="filtro-comuna" class="px-3 py-2 rounded-md border border-gray-300">
        <option value="">Comuna</option>
        <option>1</option><option>2</option><option>3</option><option>4</option>
      </select>

      <select id="filtro-barrio" class="px-3 py-2 rounded-md border border-gray-300">
        <option value="">Barrio</option>
        <option>La Rivera</option><option>San Luis</option><option>El Bosque</option><option>Santa Rosa</option>
      </select>

      <!-- Nota: el filtro de sitio permanece en UI pero la tabla actual no tiene columna 'sitio'.
           El JS ignora filtro-sitio para evitar comportamientos inesperados. -->
      <select id="filtro-sitio" class="px-3 py-2 rounded-md border border-gray-300">
        <option value="">Sitio</option>
        <option>Parque</option><option>Escuela</option><option>Cancha</option><option>Río</option>
      </select>

      <select id="filtro-tipo" class="px-3 py-2 rounded-md border border-gray-300">
        <option value="">Tipo de actividad</option>
        <option>Inspección</option>
        <option>Siembra</option>
        <option>Resiembra</option>
        <option>Seguimiento</option>
      </select>

      <button id="btn-aplicar" class="bg-green-400 hover:bg-green-500 text-white px-4 py-2 rounded-md">Aplicar filtros</button>
      <button id="btn-borrar" class="bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-md">Borrar filtros</button>

<a href="registrar_actividad.php"
   class="ml-auto bg-green-600 hover:bg-green-700 text-white w-12 h-12 rounded-full flex items-center justify-center">
    <img src="../../../iconos/agregar.svg" class="w-6 h-6 invert" alt="">
</a>


    </div>

    <!-- Tabla -->
    <div class="bg-green-50 rounded-md shadow p-4 overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="bg-green-200">
          <tr>
            <th class="px-3 py-2">Tipo de actividad</th>
            <th class="px-3 py-2">Fecha</th>
            <th class="px-3 py-2">Comuna</th>
            <th class="px-3 py-2">Barrio</th>
            <th class="px-3 py-2">Responsable</th>
            <th class="px-3 py-2 text-center">Acciones</th>
          </tr>
        </thead>
        <tbody id="tabla-actividades" class="divide-y divide-gray-200">
          <!-- Ejemplo de datos (cada fila YA incluye los íconos de acción) -->
          <tr>
            <td class="px-3 py-2">Inspección</td>
            <td class="px-3 py-2">2024-12-12</td>
            <td class="px-3 py-2">3</td>
            <td class="px-3 py-2">La Rivera</td>
            <td class="px-3 py-2">Juan Pérez</td>
            <td class="px-3 py-2 flex gap-2 justify-center acciones">
              <div class="flex gap-2">
                <img src="../../../iconos/zoom.png" data-action="ver" class="w-5 h-5 cursor-pointer" title="Ver detalles">
                <img src="../../../iconos/edit.svg" data-action="editar" class="w-5 h-5 cursor-pointer" title="Editar">
                <img src="../../../iconos/upload.svg" data-action="exportar" class="w-5 h-5 cursor-pointer" title="Exportar">
                <img src="../../../iconos/trash-2.svg" data-action="eliminar" class="w-5 h-5 cursor-pointer" title="Anular">
              </div>
            </td>
          </tr>

          <tr>
            <td class="px-3 py-2">Siembra</td>
            <td class="px-3 py-2">2024-10-05</td>
            <td class="px-3 py-2">1</td>
            <td class="px-3 py-2">San Luis</td>
            <td class="px-3 py-2">Ana Gómez</td>
            <td class="px-3 py-2 flex gap-2 justify-center acciones">
              <div class="flex gap-2">
              <img src="../../../iconos/zoom.png" data-action="ver" class="w-5 h-5 cursor-pointer" title="Ver detalles">
                <img src="../../../iconos/edit.svg" data-action="editar" class="w-5 h-5 cursor-pointer" title="Editar">
                <img src="../../../iconos/upload.svg" data-action="exportar" class="w-5 h-5 cursor-pointer" title="Exportar">
                <img src="../../../iconos/trash-2.svg" data-action="eliminar" class="w-5 h-5 cursor-pointer" title="Anular">
              </div>
            </td>
          </tr>

          <tr>
            <td class="px-3 py-2">Seguimiento</td>
            <td class="px-3 py-2">2024-09-20</td>
            <td class="px-3 py-2">2</td>
            <td class="px-3 py-2">El Bosque</td>
            <td class="px-3 py-2">Carlos López</td>
            <td class="px-3 py-2 flex gap-2 justify-center acciones">
              <div class="flex gap-2">
                <img src="../../../iconos/zoom.png" data-action="ver" class="w-5 h-5 cursor-pointer" title="Ver detalles">
                <img src="../../../iconos/edit.svg" data-action="editar" class="w-5 h-5 cursor-pointer" title="Editar">
                <img src="../../../iconos/upload.svg" data-action="exportar" class="w-5 h-5 cursor-pointer" title="Exportar">
                <img src="../../../iconos/trash-2.svg" data-action="eliminar" class="w-5 h-5 cursor-pointer" title="Anular">
              </div>
            </td>
          </tr>

          <tr>
            <td class="px-3 py-2">Resiembra</td>
            <td class="px-3 py-2">2024-08-15</td>
            <td class="px-3 py-2">4</td>
            <td class="px-3 py-2">Santa Rosa</td>
            <td class="px-3 py-2">María Díaz</td>
            <td class="px-3 py-2 flex gap-2 justify-center acciones">
              <div class="flex gap-2">
              <img src="../../../iconos/zoom.png" data-action="ver" class="w-5 h-5 cursor-pointer" title="Ver detalles">
                <img src="../../../iconos/edit.svg" data-action="editar" class="w-5 h-5 cursor-pointer" title="Editar">
                <img src="../../../iconos/upload.svg" data-action="exportar" class="w-5 h-5 cursor-pointer" title="Exportar">
                <img src="../../../iconos/trash-2.svg" data-action="eliminar" class="w-5 h-5 cursor-pointer" title="Anular">
              </div>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

    <!-- MODALES -->
    <!-- Modal Ver -->
    <div id="modal-ver" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
      <div class="bg-white rounded-md p-6 w-96">
        <h2 class="text-xl font-bold mb-4">Detalles de la Actividad</h2>
        <div id="ver-contenido" class="text-sm whitespace-pre-wrap"></div>
        <div class="flex justify-end mt-4">
          <button onclick="cerrarModal('ver')" class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500">Cerrar</button>
        </div>
      </div>
    </div>
<!-- Modal Editar -->
<div id="modal-editar" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white rounded-md p-6 w-[600px]">
    <h2 class="text-xl font-bold mb-4">Editar Actividad</h2>

    <form id="form-editar" class="grid grid-cols-2 gap-3">

      <!-- ID Actividad -->
      <div class="flex flex-col">
        <label class="text-sm font-medium">ID Actividad</label>
        <input type="text" id="editar-id" placeholder="ID de la actividad" class="border px-3 py-2 rounded-md" readonly>
      </div>

      <!-- Tipo -->
      <div class="flex flex-col">
        <label class="text-sm font-medium">Tipo de Actividad</label>
        <select id="editar-tipo" class="border px-3 py-2 rounded-md">
          <option>SIEMBRA</option>
          <option>RESIEMBRA</option>
          <option>SEGUIMIENTO</option>
        </select>
      </div>

      <!-- Fecha -->
      <div class="flex flex-col">
        <label class="text-sm font-medium">Fecha</label>
        <input type="date" id="editar-fecha" class="border px-3 py-2 rounded-md">
      </div>

      <!-- Comuna -->
      <div class="flex flex-col">
        <label class="text-sm font-medium">Comuna</label>
        <select id="editar-comuna" class="border px-3 py-2 rounded-md">
          <option>1</option><option>2</option><option>3</option><option>4</option>
        </select>
      </div>

      <!-- Barrio -->
      <div class="flex flex-col">
        <label class="text-sm font-medium">Barrio</label>
        <select id="editar-barrio" class="border px-3 py-2 rounded-md">
          <option>La Rivera</option><option>San Luis</option><option>El Bosque</option><option>Santa Rosa</option>
        </select>
      </div>

      <!-- Sitio -->
      <div class="flex flex-col">
        <label class="text-sm font-medium">Sitio</label>
        <select id="editar-sitio" class="border px-3 py-2 rounded-md">
          <option>Parque</option><option>Escuela</option><option>Cancha</option><option>Río</option>
        </select>
      </div>

      <!-- Sujeto -->
      <div class="flex flex-col">
        <label class="text-sm font-medium">Sujeto</label>
        <input type="text" id="editar-sujeto" placeholder="Nombre del sujeto" class="border px-3 py-2 rounded-md">
      </div>

      <!-- Contacto -->
      <div class="flex flex-col">
        <label class="text-sm font-medium">Contacto</label>
        <input type="text" id="editar-contacto" placeholder="Contacto" class="border px-3 py-2 rounded-md">
      </div>

      <!-- Responsable (ya existe) -->
      <div class="flex flex-col col-span-2">
        <label class="text-sm font-medium">Auxiliar / Responsable</label>
        <input type="text" id="editar-responsable" placeholder="Responsable" class="border px-3 py-2 rounded-md">
      </div>

      <!-- BOTONES -->
      <div class="col-span-2 flex justify-end gap-2 mt-4">
        <button type="button" onclick="cerrarModal('editar')" id="btn-cancelar-editar" class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500">Cancelar</button>
        <button type="submit" class="px-4 py-2 bg-green-500 rounded text-white hover:bg-green-600">Guardar</button>
      </div>

    </form>
  </div>
</div>




    <!-- Modal Exportar -->
    <div id="modal-exportar" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
      <div class="bg-white rounded-md p-6 w-80">
        <h2 class="text-xl font-bold mb-4">Exportar Actividad</h2>
        <p id="export-text">Seleccione el formato en que desea exportar la actividad:</p>
        <div class="flex justify-end gap-2 mt-4">
          <button id="export-pdf" class="px-4 py-2 bg-blue-500 rounded text-white hover:bg-blue-600">PDF</button>
          <button id="export-excel" class="px-4 py-2 bg-green-500 rounded text-white hover:bg-green-600">Excel</button>
          <button type="button" onclick="cerrarModal('exportar')" class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500">Cancelar</button>
        </div>
      </div>
    </div>

    <!-- Modal Eliminar -->
    <div id="modal-eliminar" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
      <div class="bg-white rounded-md p-6 w-80">
        <h2 class="text-xl font-bold mb-4">Confirmar Anulación</h2>
        <p id="eliminar-text">¿Desea anular esta actividad?</p>
        <div class="flex justify-end gap-2 mt-4">
          <button type="button" onclick="cerrarModal('eliminar')" id="btn-cancelar-eliminar" class="px-4 py-2 bg-gray-400 rounded hover:bg-gray-500">Cancelar</button>
          <button type="button" id="btn-confirmar-eliminar" class="px-4 py-2 bg-red-500 rounded text-white hover:bg-red-600">Anular</button>
        </div>
      </div>
    </div>

  </main>

  <script src="../../../src/js/listartrc.js"></script>
</body>
</html>
