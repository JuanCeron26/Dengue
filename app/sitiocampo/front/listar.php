<?php

require_once "../controller/sitio.php";

$db = new BaseDatos("ceron123");
$controller = new SitiosController();
$sitios = $controller->listarSitios();


// Obtener barrios
$barrios = $db->Select("SELECT cod_barrio, nombarrio FROM tblbarrios ORDER BY nombarrio");
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <link rel="stylesheet" href="../../../src/css/styles.css">

  <!-- 🔥 AGREGA ESTA LÍNEA -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- iziToast CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">


  <!-- iziToast JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
  <style>
    /* Paleta de colores del sistema */
    :root {
      --verde-oscuro: #0f5a45;
      --verde-principal: #138f6d;
      --verde-claro: #d9f1e7;
      --verde-super-claro: #eaf8f1;
      --verde-tab: #79c4a8;
      --texto-verde: #106852;
    }

    /* Animaciones suaves */
    * {
      transition: all 0.3s ease;
    }



    /* 🔥 AGREGA ESTAS LÍNEAS */
    body.menu-open {
      padding-left: 5rem;
    }
  </style>
</head>

<body class="bg-[color:var(--verde-super-claro)] min-h-screen text-[color:var(--texto-verde)]">


  <!-- 🔥 AGREGA TODO ESTO AQUÍ -->
  <!-- BOTÓN ACTIVADOR -->
  <div id="btn-aside"
    class="fixed z-40 left-0 top-0 w-1 hover:w-3 bg-slate-500/40 h-screen 
    transition-all duration-300 cursor-pointer backdrop-blur-xl">
  </div>

  <!-- MENÚ LATERAL -->
  <aside id="aside"
    class="fixed z-50 top-0 left-0 h-screen w-20 -translate-x-full 
    transition-transform duration-500 ease-in-out
    bg-white/20 backdrop-blur-2xl border-r border-white/30 shadow-2xl
    flex flex-col items-center justify-between py-10">

    <div class="flex flex-col items-center gap-10">

      <!-- Inicio -->
      <a href="inicio.php" class="group flex flex-col items-center">
        <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
          <img
            src="../../../src/icons/casa.png"
            class="w-9 h-9 drop-shadow-md group-hover:drop-shadow-xl">
        </div>
        <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-gray-700 group-hover:text-[color:var(--verde-principal)]">
          Inicio
        </span>
      </a>

      <!-- Sitios Control Biológico -->
      <a href="listar.php" class="group flex flex-col items-center">
        <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
          <img
            src="../../../src/icons/planta (2).png"
            class="w-11 h-11 drop-shadow-md group-hover:drop-shadow-xl">
        </div>
        <span class="mt-2 text-[10px] font-medium opacity-0 text-center translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-gray-700 group-hover:text-[color:var(--verde-principal)] leading-tight px-2">
          Sitios Control<br>Biológico
        </span>
      </a>

      <!-- Actividades Campo -->
      <a href="listar.php" class="group flex flex-col items-center">
        <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
          <img
            src="../../../src/icons/campo.png"
            class="w-11 h-11 drop-shadow-md group-hover:drop-shadow-xl">
        </div>
        <span class="mt-2 text-[10px] font-medium opacity-0 text-center translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-gray-700 group-hover:text-[color:var(--verde-principal)] leading-tight px-2">
          Actividades<br>Campo
        </span>
      </a>

      <!-- Zoocriadero -->
      <a href="registros.php" class="group flex flex-col items-center">
        <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
          <img
            src="../../../src/icons/pez-koi.png"
            class="w-11 h-11 drop-shadow-md group-hover:drop-shadow-xl">
        </div>
        <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-gray-700 group-hover:text-[color:var(--verde-principal)]">
          Zoocriadero
        </span>
      </a>

      <!-- Configuración -->
      <a href="configuracion.php" class="group flex flex-col items-center">
        <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
          <i class="fa-solid fa-gear text-2xl text-gray-600 drop-shadow-md
                    group-hover:text-[color:var(--verde-principal)] group-hover:drop-shadow-xl group-hover:rotate-90"></i>
        </div>
        <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-gray-700 group-hover:text-[color:var(--verde-principal)]">
          Configuración
        </span>
      </a>

    </div>

    <!-- Botón Salir -->
    <div class="flex flex-col items-center">
      <a href="../../../src/icons/logout.php" class="group flex flex-col items-center">
        <div class="transition-all duration-300 group-hover:scale-125 group-hover:-translate-y-1">
          <i class="fa-solid fa-power-off text-2xl text-red-600 drop-shadow-md
                    group-hover:text-red-700 group-hover:drop-shadow-xl group-hover:rotate-12"></i>
        </div>
        <span class="mt-2 text-xs font-medium opacity-0 translate-y-2 
                group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300
                text-red-600 group-hover:text-red-700">
          Salir
        </span>
      </a>
    </div>

  </aside>
  <!-- FIN DEL MENÚ -->

  <!-- BARRA SUPERIOR -->

  <!-- BARRA SUPERIOR -->
  <header class="bg-gradient-to-r from-[color:var(--verde-oscuro)] to-[#0a4433] text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex items-center gap-4">

        <div class="text-sm font-semibold"></div>
      </div>
      <div class="flex items-center gap-4">
        <div class="text-xs opacity-80">Juan José Cerón Arcos</div>
        <div class="w-8 h-8 rounded-full bg-green-700 flex items-center justify-center">JC</div>
      </div>
    </div>
  </header>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="max-w-8xl mx-auto px-6 py-8">
    <div class="grid grid-cols-12 gap-6">

      <!-- FILTROS -->
      <aside class="col-span-4">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-xl">
          <h2 class="text-2xl font-extrabold text-[color:var(--texto-verde)] text-center mb-6">FILTROS</h2>

          <form id="formFilters" class="space-y-5">
            <!-- SITIO (select) -->
            <div>
              <label class="block text-xs font-semibold mb-2">SITIO</label>
              <select name="f_sitio" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)]">
                <option value="">-- Todos --</option>
                <?php foreach ($sitios as $s): ?>
                  <option value="<?= $s['nombre_sitio'] ?>">
                    <?= htmlspecialchars($s['nombre_sitio']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- BARRIO (select) -->
            <div>
              <label class="block text-xs font-semibold mb-2">BARRIO</label>
              <select name="f_barrio" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)]">
                <option value="">-- Todos --</option>
                <?php foreach ($barrios as $barrio): ?>
                  <option value="<?= $barrio['nombarrio'] ?>">
                    <?= htmlspecialchars($barrio['nombarrio']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="block text-xs font-semibold text-[color:var(--texto-verde)] mb-2">NOMBRE DE RESPONSABLE</label>
              <input name="f_nombre" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] outline-none focus:ring-2 focus:ring-[color:var(--verde-principal)]">
            </div>





            <div class="flex gap-3 mt-2">
              <button type="button" id="btnFilter" class="flex-1 px-4 py-3 rounded-full bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white font-semibold hover:shadow-lg hover:scale-105">BUSCAR</button>
              <button type="button" id="btnReset" class="flex-1 px-4 py-3 rounded-full bg-white border-2 border-[color:var(--verde-tab)] text-[color:var(--texto-verde)] hover:bg-[color:var(--verde-super-claro)]">LIMPIAR</button>
            </div>
          </form>
        </div>
      </aside>

      <!-- LISTADO -->
      <section class="col-span-8">
        <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl">

          <!-- header de tabla con boton + -->
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-[color:var(--texto-verde)]">Listado de Sitios</h2>

            <!-- Boton registrar (+) -->
            <button id="openRegister" title="Registrar" class="flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white shadow-lg hover:scale-105">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <span class="font-bold">REGISTRAR</span>
            </button>
          </div>

          <!-- TABLA -->
          <div class="overflow-auto">
            <table class="w-full border-separate" id="tblRegistros">

              <thead>
                <tr class="bg-gradient-to-r from-[color:var(--verde-claro)] to-[color:var(--verde-super-claro)]">
                  <th class="py-2 px-4 text-left font-bold">Código</th>
                  <th class="py-2 px-4 text-left font-bold">Nombre del Sitio</th>
                  <th class="py-2 px-4 text-left font-bold">Dirección</th>
                  <th class="py-2 px-4 text-left font-bold">Responsable</th>
                  <th class="py-3 px-8 text-center font-bold">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($sitios) > 0): ?>
                  <?php foreach ($sitios as $s): ?>
                    <tr class="border-b text-center hover:bg-[color:var(--verde-super-claro)]">
                      <td class="py-2 px-4"><?= $s['cod_sitiocontrolbiolo'] ?></td>
                      <td class="py-2 px-4"><?= htmlspecialchars($s['nombre_sitio']) ?></td>
                      <td class="py-2 px-4"><?= htmlspecialchars($s['direccion_sitio']) ?></td>
                      <td class="py-2 px-4">
                        <?= htmlspecialchars($s['nombre_responsable'] ?? '-') ?>
                        <?= htmlspecialchars($s['apellido_responsable'] ?? '') ?>
                      </td>
                      <td class="py-2 px-4 space-x-2 flex justify-center">

                        <button type="button" class="btnEditar p-2 rounded-lg hover:bg-blue-50 hover:scale-110" data-id="<?= $s['cod_sitiocontrolbiolo'] ?>&accion=editar">
                          <img src="../../../src/icons/icono_edit.png" class="w-5 h-5">
                        </button>

                        <!-- Ver detalle -->
                        <a href="../api/sitio.php?id=<?= $s['cod_sitiocontrolbiolo'] ?>&accion=detalle"
                          class="p-2 rounded-lg hover:bg-green-50 hover:scale-110">
                          <img src="../../../src/icons/zoom.png" class="w-5 h-5">
                        </a>

                        <!-- Eliminar -->
                        <button type="button" class="btnEliminar p-2 rounded-lg hover:bg-red-50 hover:scale-110" data-id="<?= $s['cod_sitiocontrolbiolo'] ?>">
                          <img src="../../../src/icons/trash-2.svg" class="w-5 h-5">
                        </button>

                        <a href="exportar.php?id=<?= $s['cod_sitiocontrolbiolo'] ?>"
                          class="p-2 rounded-lg hover:bg-yellow-50 hover:scale-110">
                          <img src="../../../src/icons/upload.svg" alt="Exportar" class="w-5 h-5">
                        </a>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="py-4 text-center">No hay registros disponibles</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>




          </div>
          <div id="cardsContainer" class="grid grid-cols-3 gap-4"></div>

          <div id="paginacion" class="flex justify-center gap-4 mt-4">
            <button id="btnAnterior">Anterior</button>
            <button id="btnSiguiente">Siguiente</button>
          </div>






        </div>



      </section>
    </div>
  </main>





  <!-- MODAL: Registro (tabs) -->
  <div id="modalRegisterBackdrop" class="hidden fixed inset-0 modal-backdrop bg-black/50 bg-opacity-40 flex items-start justify-center pt-20 px-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-4xl rounded-2xl modal-front shadow-2xl">
      <!-- Header del modal -->
      <div class="flex items-center justify-between p-4 border-b-2 border-[color:var(--verde-claro)] rounded-t-lg bg-gradient-to-r from-[color:var(--verde-super-claro)] to-white">
        <div class="flex items-center gap-3">
          <img src="../../../src/icons/ubicacion.png" alt="maqueta" class="h-10 rounded">
          <h3 class="text-xl font-bold text-[color:var(--texto-verde)]">Registro de Sitio y Responsable</h3>
        </div>
        <button id="closeRegister" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">✕</button>
      </div>

      <!-- BOTONES DE MODO -->
      <div class="p-6">
        <div class="flex gap-4 mb-6">
          <button type="button" id="btnModoNuevo" class="flex-1 px-6 py-3 rounded-xl bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white font-semibold hover:shadow-lg transition-all">
            <i class="fas fa-user-plus"></i> Registrar Nuevo Responsable
          </button>
          <button type="button" id="btnModoExistente" class="flex-1 px-6 py-3 rounded-xl bg-white border-2 border-[color:var(--verde-principal)] text-[color:var(--verde-principal)] font-semibold hover:bg-[color:var(--verde-super-claro)] transition-all">
            <i class="fas fa-users"></i> Asociar Responsable Existente
          </button>
        </div>

        <!-- TABS (solo se muestran en modo nuevo) -->
        <div id="tabsContainer">
          <div class="flex gap-4 mb-4">
            <button data-tab="responsable" class="tab-btn px-6 py-2 rounded-full font-semibold bg-[color:var(--verde-tab)] text-white shadow-md hover:shadow-lg">Responsable</button>
            <button data-tab="sitio" class="tab-btn px-6 py-2 rounded-full font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300">Sitio</button>
          </div>
        </div>

        <form id="formRegister" class="space-y-6" novalidate>

          <!-- TAB RESPONSABLE -->
          <div id="tab-responsable" class="tab-content">
            <!-- FORMULARIO NUEVO RESPONSABLE -->
            <div id="formNuevo">
              <h4 class="font-semibold text-[color:var(--texto-verde)] mb-3">Datos de Responsable</h4>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs text-[color:var(--texto-verde)] mb-1">NOMBRE *</label>
                  <input name="nombre_responsable" id="nombre_responsable" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
                </div>
                <div>
                  <label class="block text-xs text-[color:var(--texto-verde)] mb-1">APELLIDO *</label>
                  <input name="apellido_responsable" id="apellido_responsable" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
                </div>

                <div>
                  <label class="block text-xs text-[color:var(--texto-verde)] mb-1">CÉDULA (10 dígitos) *</label>
                  <input name="cedula" id="cedula" pattern="\d{10}" maxlength="10" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
                </div>
                <div>
                  <label class="block text-xs text-[color:var(--texto-verde)] mb-1">CELULAR (10 dígitos) *</label>
                  <input name="celular" id="celular" pattern="\d{10}" maxlength="10" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
                </div>
              </div>

              <div class="flex justify-end mt-4 gap-3">
                <button type="button" id="nextToSitio" class="px-6 py-3 rounded-full bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white font-semibold hover:shadow-lg hover:scale-105">SIGUIENTE</button>
              </div>
            </div>

            <!-- FORMULARIO ASOCIAR EXISTENTE -->
            <div id="formExistente" class="hidden">
              <h4 class="font-semibold text-[color:var(--texto-verde)] mb-3">Buscar Responsable por Cédula</h4>
              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">CÉDULA DEL RESPONSABLE (10 dígitos) *</label>
                <input name="cedula_existente" id="cedula_existente" pattern="\d{10}" maxlength="10" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none" placeholder="Ingrese la cédula del responsable">
              </div>

              <div class="flex justify-end mt-4 gap-3">
                <button type="button" id="nextToSitioExistente" class="px-6 py-3 rounded-full bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white font-semibold hover:shadow-lg hover:scale-105">SIGUIENTE</button>
              </div>
            </div>
          </div>

          <!-- TAB SITIO -->
          <div id="tab-sitio" class="tab-content hidden">
            <h4 class="font-semibold text-[color:var(--texto-verde)] mb-3">Datos del Sitio</h4>

            <div class="space-y-4">
              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">NOMBRE SITIO *</label>
                <input name="nombre_sitio" id="nombre_sitio" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
              </div>

              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">DIRECCIÓN *</label>
                <div class="flex gap-3">
                  <input id="direccion_sitio" name="direccion_sitio" readonly type="text" placeholder="CONSTRUYE TU DIRECCION AQUI" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)]">
                  <button type="button" id="openAddressBuilder" class="px-4 py-3 rounded-full bg-white border-2 border-[color:var(--verde-principal)] text-[color:var(--verde-principal)] font-semibold hover:bg-[color:var(--verde-super-claro)]">Construir</button>
                </div>
              </div>

              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">BARRIO *</label>
                <select name="cod_barrio" id="cod_barrio" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
                  <option value="">-- Seleccione un barrio --</option>
                  <?php foreach ($barrios as $barrio): ?>
                    <option value="<?= $barrio['cod_barrio'] ?>"><?= htmlspecialchars($barrio['nombarrio']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="flex justify-between mt-6">
              <button type="button" id="backToResponsable" class="px-6 py-3 rounded-full bg-white border-2 border-[color:var(--verde-tab)] text-[color:var(--texto-verde)] font-semibold hover:bg-[color:var(--verde-super-claro)]">ATRÁS</button>
              <button type="submit" id="saveRegister" class="px-6 py-3 rounded-full bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold hover:shadow-lg hover:scale-105">GUARDAR</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- MODAL: Construir Dirección -->
  <div id="modalAddressBackdrop" class="hidden fixed inset-0 modal-backdrop bg-black/50 bg-opacity-50 flex items-center justify-center px-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-xl rounded-2xl p-6 modal-front shadow-2xl">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-[color:var(--texto-verde)]">Ingreso de Dirección</h3>
        <button id="closeAddress" class="text-gray-400 hover:text-gray-600 text-2xl">✕</button>
      </div>

      <div class="grid grid-cols-3 gap-4">
        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">Tipo de Vía</label>
          <select id="tipoVia" class="w-full mt-1 px-3 py-2 rounded-full bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
            <option value="">-</option>
            <option value="Calle">Calle</option>
            <option value="Carrera">Carrera</option>
            <option value="Avenida">Avenida</option>
            <option value="Transversal">Transversal</option>
          </select>
        </div>

        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">Número Vía</label>
          <input id="numeroVia" type="text" class="w-full mt-1 px-3 py-2 rounded-full bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
        </div>

        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">#</label>
          <input id="numero" type="text" class="w-full mt-1 px-3 py-2 rounded-full bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
        </div>

      </div>

      <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">Sufijo / Letra</label>
          <input id="sufijo" type="text" class="w-full mt-1 px-3 py-2 rounded-full bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
        </div>
        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">Distancia</label>
          <input id="distancia" type="text" class="w-full mt-1 px-3 py-2 rounded-full bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-[color:var(--verde-principal)] outline-none">
        </div>
      </div>

      <!-- Dirección generada -->
      <div class="mt-4">
        <label class="text-xs text-[color:var(--texto-verde)]">DIRECCIÓN GENERADA</label>
        <div id="direccionGenerada" class="mt-1 p-3 bg-gradient-to-r from-[color:var(--verde-claro)] to-[color:var(--verde-super-claro)] rounded-xl font-semibold text-[color:var(--texto-verde)] text-center">-</div>
      </div>

      <div class="flex gap-3 justify-end mt-4">
        <button id="btnClearAddress" class="px-4 py-2 rounded-full bg-red-50 text-red-700 border-2 border-red-200 hover:bg-red-100">BORRAR</button>
        <button id="btnDeleteLast" class="px-4 py-2 rounded-full bg-yellow-50 text-yellow-800 border-2 border-yellow-200 hover:bg-yellow-100">BORRAR ÚLTIMO</button>
        <button id="btnSaveAddress" class="px-4 py-2 rounded-full bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white hover:shadow-lg hover:scale-105">GUARDAR</button>
      </div>
    </div>
  </div>

  <!-- Modal Confirmación -->
  <div id="modalConfirm" class="hidden fixed inset-0 bg-black/50 bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 relative">

      <h2 class="text-xl font-semibold text-gray-800 mb-2 text-center">¿Eliminar registro?</h2>

      <p class="text-gray-600 text-center mb-6">
        Esta acción no se puede deshacer.
        ¿Estás segura de que deseas continuar?
      </p>

      <!-- Barra de progreso -->
      <div id="progressBar" class="h-1 bg-green-500 rounded-full scale-x-0 origin-left transition-transform duration-700 mb-4"></div>

      <div class="flex justify-between gap-3">
        <button id="cancelarEliminar" class="flex-1 py-2 rounded-xl bg-gray-300 hover:bg-gray-400">Cancelar</button>
        <button id="confirmarEliminar" class="flex-1 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700">Eliminar</button>
      </div>
    </div>
  </div>

  <!-- Modal Detalle Sitio -->
  <div id="modalDetalle" class="hidden fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 relative">
      <!-- Cerrar -->
      <button id="closeDetalle" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">✕</button>

      <h3 class="text-2xl font-bold mb-4 text-gray-800">Detalle del Sitio</h3>

      <div id="detalleContent" class="space-y-2 text-gray-700">
        <!-- Aquí se va a inyectar la info desde JS -->
      </div>

      <div class="mt-4 flex justify-end">
        <button id="closeDetalleFooter" class="px-4 py-2 bg-gradient-to-r from-[color:var(--verde-principal)] to-[#0f7a5d] text-white rounded-full hover:shadow-lg hover:scale-105">Cerrar</button>
      </div>
    </div>
  </div>

  <!-- MODAL: Editar (tabs) -->
  <div id="modalEditarBackdrop" class="hidden fixed inset-0 modal-backdrop bg-black/50 bg-opacity-40 flex items-start justify-center pt-20 px-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-4xl rounded-2xl modal-front shadow-2xl">
      <!-- Header del modal -->
      <div class="flex items-center justify-between p-4 border-b-2 border-[color:var(--verde-claro)] rounded-t-lg bg-gradient-to-r from-[color:var(--verde-super-claro)] to-white">
        <div class="flex items-center gap-3">
          <img src="../../../src/icons/ubicacion.png" alt="maqueta" class="h-10 rounded">
          <h3 class="text-xl font-bold text-[color:var(--texto-verde)]">Editar Sitio y Responsable</h3>
        </div>
        <button id="closeEditar" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">✕</button>
      </div>

      <!-- TABS -->
      <div class="p-6">
        <div class="flex gap-4 mb-4">
          <button data-tab-edit="responsable" class="tab-btn-edit px-6 py-2 rounded-full font-semibold bg-[color:var(--verde-tab)] text-white shadow-md hover:shadow-lg">Responsable</button>
          <button data-tab-edit="sitio" class="tab-btn-edit px-6 py-2 rounded-full font-semibold bg-gray-200 text-gray-600 hover:bg-gray-300">Sitio</button>
        </div>

        <form id="formEditar" action="../controller/sitio.php" method="POST" class="space-y-6" novalidate>
          <!-- Campo hidden para el ID y acción -->
          <input type="hidden" name="cod_sitiocontrolbiolo" id="edit_cod_sitio">
          <input type="hidden" name="accion" value="editar">

          <!-- TAB RESPONSABLE -->
          <div id="tab-edit-responsable" class="tab-content-edit">
            <h4 class="font-semibold text-[color:var(--texto-verde)] mb-3">Datos de Responsable</h4>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">NOMBRE</label>
                <input name="nombre_responsable" id="edit_nombre_responsable" required type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-blue-500 outline-none">
              </div>
              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">APELLIDO</label>
                <input name="apellido_responsable" id="edit_apellido_responsable" required type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-blue-500 outline-none">
              </div>

              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">CÉDULA (10 dígitos)</label>
                <input name="cedula" id="edit_cedula" required pattern="\d{10}" maxlength="10" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-blue-500 outline-none">
              </div>
              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">CELULAR (10 dígitos)</label>
                <input name="celular" id="edit_celular" required pattern="\d{10}" maxlength="10" type="text" class="w-full rounded-full px-4 py-3 bg-[color:var(--verde-super-claro)] focus:ring-2 focus:ring-blue-500 outline-none">
              </div>
            </div>

            <div class="flex justify-end mt-4 gap-3">
              <button type="button" id="nextToSitioEdit" class="px-6 py-3 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold hover:shadow-lg hover:scale-105">SIGUIENTE</button>
            </div>
          </div>


          <!-- TAB SITIO -->
          <div id="tab-edit-sitio" class="tab-content-edit hidden">
            <h4 class="font-semibold text-[color:var(--texto-verde)] mb-3">Datos del Sitio</h4>

            <div class="space-y-4">
              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">NOMBRE SITIO</label>
                <input name="nombre_sitio" id="edit_nombre_sitio" type="text" class="w-full input-pill px-4 py-3 bg-[color:var(--verde-super-claro)]">
              </div>

              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">DIRECCIÓN</label>
                <div class="flex gap-3">
                  <input id="edit_direccion_sitio" name="direccion_sitio" readonly type="text" placeholder="CONSTRUYE TU DIRECCION AQUI" class="w-full input-pill px-4 py-3 bg-[color:var(--verde-super-claro)]">
                  <button type="button" id="openAddressBuilderEdit" class="px-4 py-3 rounded-full bg-white border border-[color:var(--verde-principal)] text-[color:var(--verde-principal)] font-semibold">Construir</button>
                </div>
              </div>

              <div>
                <label class="block text-xs text-[color:var(--texto-verde)] mb-1">BARRIO</label>
                <select name="cod_barrio" id="edit_cod_barrio" class="w-full input-pill px-4 py-3 bg-[color:var(--verde-super-claro)]" required>
                  <option value="">-- Seleccione un barrio --</option>
                  <?php foreach ($barrios as $barrio): ?>
                    <option value="<?= $barrio['cod_barrio'] ?>"><?= htmlspecialchars($barrio['nombarrio']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="flex justify-between mt-6">
              <button type="button" id="backToResponsableEdit" class="px-6 py-3 rounded-full bg-white border border-[color:var(--verde-tab)] text-[color:var(--texto-verde)] font-semibold">ATRÁS</button>
              <button type="submit" id="saveEditar" class="px-6 py-3 rounded-full bg-[color:var(--verde-principal)] text-white font-semibold">ACTUALIZAR</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- -----------------------
        MODAL: Construir Dirección para EDITAR
        ----------------------- -->
  <div id="btnEditarDireccion" class="hidden fixed inset-0 modal-backdrop bg-black/50 bg-opacity-50 flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-xl card-rounded p-6 modal-front shadow-lg">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-[color:var(--texto-verde)]">Editar Dirección</h3>
        <button id="closeAddressEdit" class="text-[color:var(--texto-verde)]">✕</button>
      </div>

      <div class="grid grid-cols-3 gap-4">
        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">Tipo de Vía</label>
          <select id="tipoViaEdit" class="w-full mt-1 px-3 py-2 input-pill bg-[color:var(--verde-super-claro)]">
            <option value="">-</option>
            <option value="Calle">Calle</option>
            <option value="Carrera">Carrera</option>
            <option value="Avenida">Avenida</option>
            <option value="Transversal">Transversal</option>
          </select>
        </div>

        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">Número Vía</label>
          <input id="numeroViaEdit" type="text" class="w-full mt-1 px-3 py-2 input-pill bg-[color:var(--verde-super-claro)]">
        </div>

        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">#</label>
          <input id="numeroEdit" type="text" class="w-full mt-1 px-3 py-2 input-pill bg-[color:var(--verde-super-claro)]">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mt-4">
        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">Sufijo / Letra</label>
          <input id="sufijoEdit" type="text" class="w-full mt-1 px-3 py-2 input-pill bg-[color:var(--verde-super-claro)]">
        </div>
        <div>
          <label class="text-xs text-[color:var(--texto-verde)]">Distancia</label>
          <input id="distanciaEdit" type="text" class="w-full mt-1 px-3 py-2 input-pill bg-[color:var(--verde-super-claro)]">
        </div>
      </div>

      <!-- Dirección generada -->
      <div class="mt-4">
        <label class="text-xs text-[color:var(--texto-verde)]">DIRECCIÓN GENERADA</label>
        <div id="direccionGeneradaEdit" class="mt-1 p-3 bg-[color:var(--verde-claro)] rounded font-semibold text-[color:var(--texto-verde)]">-</div>
      </div>

      <div class="flex gap-3 justify-end mt-4">
        <button id="btnClearAddressEdit" class="px-4 py-2 rounded-full bg-red-100 text-red-700">BORRAR</button>
        <button id="btnDeleteLastEdit" class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-800">BORRAR ÚLTIMO</button>
        <button id="btnSaveAddressEdit" class="px-4 py-2 rounded-full bg-[color:var(--verde-principal)] text-white">GUARDAR</button>
      </div>
    </div>
  </div>



  <!-- 🔥 AGREGA ESTE SCRIPT AQUÍ -->
  <script>
    const btnAside = document.getElementById('btn-aside');
    const aside = document.getElementById('aside');
    const body = document.body;

    let menuAbierto = false;

    btnAside.addEventListener('click', () => {
      menuAbierto = !menuAbierto;

      if (menuAbierto) {
        aside.classList.remove('-translate-x-full');
        body.classList.add('menu-open');
      } else {
        aside.classList.add('-translate-x-full');
        body.classList.remove('menu-open');
      }
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
      if (menuAbierto && !aside.contains(e.target) && !btnAside.contains(e.target)) {
        aside.classList.add('-translate-x-full');
        body.classList.remove('menu-open');
        menuAbierto = false;
      }
    });
  </script>

  +


  <script defer src="../../../src/js/sitio.js"></script>
  <!-- SCRIPTS: lógica de UI, validaciones y tabla -->



</body>

</html>