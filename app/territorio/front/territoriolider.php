<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Listado de Líderes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../../src/css/styles.css">
    <link rel="stylesheet" href="../../../src/css/territorioo.css" />

    <link rel="stylesheet" href="../../../src/css/iziToast.min.css">


    <!-- iziToast JS -->
    <script src="../../../src/js/iziToast.min.js"></script>
</head>

<body class="min-h-screen font-sans text-slate-800 p-6 bg-gray-100">

    <div class="max-w-[1400px] mx-auto flex gap-8">
        <aside class="w-72 p-6 glass shadow-2xl aside-animate rounded-3xl">
            <h3 class="text-2xl font-bold mb-6 text-[var(--color-primary)] flex items-center gap-2">
                <i class="fas fa-filter"></i> Filtros
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-[var(--color-tertiary)]"></i> Comuna
                    </label>
                    <select id="filterComuna" class="w-full p-3 rounded-xl border-2 border-[var(--color-border)] focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                        <option value="">Todas</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-building text-[var(--color-tertiary)]"></i> Barrio
                    </label>
                    <select id="filterBarrio" class="w-full p-3 rounded-xl border-2 border-[var(--color-border)] focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-user text-[var(--color-tertiary)]"></i> Nombre de líder
                    </label>
                    <select id="filterNombre" class="w-full p-3 rounded-xl border-2 border-[var(--color-border)] focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-crown text-[var(--color-tertiary)]"></i> Tipo de liderazgo
                    </label>
                    <select id="filterLiderazgo" class="w-full p-3 rounded-xl border-2 border-[var(--color-border)] focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-[var(--color-tertiary)]"></i> Fecha
                    </label>
                    <input type="date" id="filterFecha" class="w-full p-3 rounded-xl border-2 border-[var(--color-border)] focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                </div>

                <div class="flex gap-3 pt-2">
                    <button id="btnAplicarFiltros" class="flex-1 px-4 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg">
                        <i class="fas fa-check"></i> Aplicar
                    </button>
                    <button id="btnLimpiarFiltros" class="px-4 py-3 glass-dark border-2 border-[var(--color-border)] rounded-xl font-semibold hover:border-[var(--color-tertiary)] hover:scale-105 transition-transform">
                        <i class="fas fa-eraser"></i>
                    </button>
                </div>
            </div>
        </aside>

        <main class="flex-1 main-animate">
            <div class="flex items-center justify-between mb-8 glass p-6 shadow-2xl rounded-3xl">
                <div>
                    <h1 class="text-4xl font-extrabold text-[var(--color-primary)] flex items-center gap-3">
                        <i class="fas fa-users"></i> Gestión de Líderes/Territorio
                    </h1>
                    <p class="text-lg text-slate-600 mt-2">Listado y asociación de participantes</p>
                </div>
                <button id="openModalBtn" class="w-16 h-16 rounded-full btn-secondary text-white text-3xl shadow-2xl hover:animate-[float_1s_ease-in-out_infinite] transition-all">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            <section id="cardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-1 gap-4">
            </section>
        </main>
    </div>

    <div id="modalCrear" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-3xl glass p-8 shadow-2xl rounded-3xl" style="animation: scaleIn 0.3s ease-out;">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modalCrearTitle" class="text-3xl font-bold text-[var(--color-primary)] flex items-center gap-3">
                    <i class="fas fa-user-plus"></i> Asociar Líder a Territorio
                </h2>
                <button id="closeCrear" class="text-3xl text-slate-600 hover:text-[var(--color-primary)] hover:scale-125 hover:rotate-90 transition-all duration-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-6 flex gap-4">
                <button type="button" id="btnModoNuevo" class="flex-1 px-6 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg">
                    <i class="fas fa-user-plus"></i> Registrar Nuevo Líder
                </button>
                <button type="button" id="btnModoExistente" class="flex-1 px-6 py-3 glass-dark border-2 border-[var(--color-border)] rounded-xl font-semibold text-slate-700 hover:border-[var(--color-tertiary)] transition-colors">
                    <i class="fas fa-users"></i> Asociar Líder Existente
                </button>
            </div>

            <form id="formLider">
                <div id="formNuevo" class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-user text-[var(--color-tertiary)]"></i> Nombre *
                        </label>
                        <input id="inNombre" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" autocomplete="given-name" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-user text-[var(--color-tertiary)]"></i> Apellido *
                        </label>
                        <input id="inApellido" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" autocomplete="family-name" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-id-card"></i> Cédula *
                        </label>
                        <input
                            type="text"
                            id="inCedula"
                            placeholder="Ingresa la cédula"
                            maxlength="10"
                            required
                            class="w-full p-3 border-2 border-gray-300 rounded-xl focus:border-[#7DD3C0] focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-envelope text-[var(--color-tertiary)]"></i> Correo
                        </label>
                        <input id="inCorreo" type="email" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-phone text-[var(--color-tertiary)]"></i> Celular
                        </label>
                        <input id="inCelular" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" inputmode="numeric" />
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-crown text-[var(--color-tertiary)]"></i> Clase de liderazgo
                        </label>
                        <input id="inClase" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                    </div>
                </div>

                <div id="formExistente" class="hidden">
                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-user text-[var(--color-tertiary)]"></i> Seleccionar Líder *
                        </label>
                        <select id="inLiderExistente" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                            <option value="">Selecciona un líder</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5">
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-globe text-[var(--color-tertiary)]"></i> Territorio *
                    </label>
                    <select id="inTerritorio" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                        <option value="">Selecciona sitio</option>
                    </select>
                </div>

                <div class="flex justify-between mt-6 gap-4">
                    <button type="button" id="btnCancelarCrear" class="px-8 py-3 glass-dark border-2 border-red-300 rounded-xl font-bold text-red-600 hover:bg-red-50 hover:scale-105 transition-transform">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" id="btnGuardarLider" class="px-8 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditar" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-3xl glass p-8 shadow-2xl rounded-3xl" style="animation: scaleIn 0.3s ease-out;">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-[var(--color-primary)] flex items-center gap-3">
                    <i class="fas fa-edit"></i> Editar Líder/Territorio
                </h2>
                <button id="closeEditar" class="text-3xl text-slate-600 hover:text-[var(--color-primary)] hover:scale-125 hover:rotate-90 transition-all duration-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="formLiderEditar">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-user text-[var(--color-tertiary)]"></i> Nombre *
                        </label>
                        <input id="inNombreEditar" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" autocomplete="given-name" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-user text-[var(--color-tertiary)]"></i> Apellido *
                        </label>
                        <input id="inApellidoEditar" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" autocomplete="family-name" />
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-id-card"></i> Cédula *
                        </label>
                        <input
                            type="text"
                            id="inCedulaEditar"
                            placeholder="Ingresa la cédula"
                            maxlength="10"
                            required
                            class="w-full p-3 border-2 border-gray-300 rounded-xl focus:border-[#7DD3C0] focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-envelope text-[var(--color-tertiary)]"></i> Correo
                        </label>
                        <input id="inCorreoEditar" type="email" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-phone text-[var(--color-tertiary)]"></i> Celular
                        </label>
                        <input id="inCelularEditar" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" inputmode="numeric" />
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                            <i class="fas fa-crown text-[var(--color-tertiary)]"></i> Clase de liderazgo
                        </label>
                        <input id="inClaseEditar" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                    </div>
                </div>

                <div class="mt-5">
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-globe text-[var(--color-tertiary)]"></i> Territorio *
                    </label>
                    <select id="inTerritorioEditar" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark">
                        <option value="">Selecciona sitio</option>
                    </select>
                </div>

                <div class="flex justify-between mt-6 gap-4">
                    <button type="button" id="btnCancelarEditar" class="px-8 py-3 glass-dark border-2 border-red-300 rounded-xl font-bold text-red-600 hover:bg-red-50 hover:scale-105 transition-transform">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" id="btnGuardarEditar" class="px-8 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalDetalles" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-2xl glass p-8 shadow-2xl rounded-3xl" style="animation: scaleIn 0.3s ease-out;">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-[var(--color-primary)] flex items-center gap-3">
                    <i class="fas fa-info-circle"></i> Detalles del Líder
                </h2>
                <button id="closeDetalles" class="text-3xl text-slate-600 hover:text-[var(--color-primary)] hover:scale-125 hover:rotate-90 transition-all duration-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="detallesContenido" class="space-y-4">
            </div>

            <div class="mt-6 text-center">
                <button id="btnCerrarDetalles" class="px-8 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg">
                    <i class="fas fa-check"></i> Cerrar
                </button>
            </div>
        </div>
    </div>

    <div id="modalParticipantes" class="fixed inset-0 hidden items-center justify-center z-50 bg-black/50 backdrop-blur-sm p-4">
        <div class="w-full max-w-3xl glass p-8 shadow-2xl rounded-3xl" style="animation: scaleIn 0.3s ease-out;">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-[var(--color-primary)] flex items-center gap-3">
                    <i class="fas fa-user-friends"></i> Asociar Participantes
                </h3>
                <button id="closeParticipantes" class="text-3xl text-slate-600 hover:text-[var(--color-primary)] hover:scale-125 hover:rotate-90 transition-all duration-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="formParticipante" class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-user text-[var(--color-tertiary)]"></i> Nombre
                    </label>
                    <input id="pNombre" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-user text-[var(--color-tertiary)]"></i> Apellido
                    </label>
                    <input id="pApellido" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-id-card text-[var(--color-tertiary)]"></i> Cédula
                    </label>
                    <input id="pCedula" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700 mb-2 block flex items-center gap-2">
                        <i class="fas fa-phone text-[var(--color-tertiary)]"></i> Celular
                    </label>
                    <input id="pCelular" class="w-full p-3 border-2 border-[var(--color-border)] rounded-xl focus:border-[var(--color-tertiary)] focus:outline-none glass-dark" />
                </div>

                <div class="col-span-2 flex justify-between mt-3 gap-4">
                    <button id="btnAgregarPart" type="button" class="px-6 py-3 btn-secondary text-white rounded-xl font-bold shadow-lg">
                        <i class="fas fa-user-plus"></i> Agregar participante
                    </button>
                    <button id="btnGuardarParts" type="button" class="px-6 py-3 btn-gradient text-white rounded-xl font-bold shadow-lg">
                        <i class="fas fa-save"></i> Guardar participantes
                    </button>
                </div>
            </form>

            <div class="glass-dark p-6 rounded-xl border-2 border-[var(--color-border)]">
                <h4 class="font-bold text-lg mb-4 text-slate-800 flex items-center gap-2">
                    <i class="fas fa-list text-[var(--color-tertiary)]"></i> Participantes añadidos
                </h4>
                <ul id="listaParticipantes" class="space-y-3 max-h-64 overflow-auto"></ul>
            </div>



        </div>
    </div>

    <script src="../../../src/js/TERRITORIO.js"></script>
</body>

</html>