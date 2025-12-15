<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas - Actividades</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        .barra { background: #10B981; height: 30px; border-radius: 5px; }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">📊 Estadísticas de Actividades</h1>
            <p class="text-gray-600 mt-2">Control Biológico de Campo</p>
        </div>

        <!-- Filtros Simples -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold mb-4">🔍 Filtros</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Fecha Inicio</label>
                    <input type="date" id="fecha-inicio" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Fecha Fin</label>
                    <input type="date" id="fecha-fin" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Sitio</label>
                    <select id="filtro-sitio" class="w-full p-2 border rounded">
                        <option value="">Todos</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button onclick="aplicarFiltros()" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Aplicar
                </button>
                <button onclick="limpiarFiltros()" class="bg-gray-300 text-gray-700 px-6 py-2 rounded ml-2 hover:bg-gray-400">
                    Limpiar
                </button>
            </div>
        </div>

        <!-- Tarjetas de Resumen -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="stat-card bg-green-500 text-white rounded-lg shadow p-6">
                <div class="text-4xl font-bold" id="total">0</div>
                <div class="text-sm mt-1">Total Actividades</div>
            </div>
            <div class="stat-card bg-blue-500 text-white rounded-lg shadow p-6">
                <div class="text-4xl font-bold" id="sitios">0</div>
                <div class="text-sm mt-1">Sitios Activos</div>
            </div>
            <div class="stat-card bg-orange-500 text-white rounded-lg shadow p-6">
                <div class="text-4xl font-bold" id="depositos">0</div>
                <div class="text-sm mt-1">Depósitos</div>
            </div>
            <div class="stat-card bg-purple-500 text-white rounded-lg shadow p-6">
                <div class="text-4xl font-bold" id="inspecciones">0</div>
                <div class="text-sm mt-1">Inspecciones</div>
            </div>
        </div>

        <!-- Sitios con más actividades -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-4">📍 Sitios con Más Actividades</h3>
            <div id="grafica-sitios"></div>
        </div>

        <!-- Actividades por tipo -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-4">📋 Distribución por Tipo de Actividad</h3>
            <div id="grafica-tipos"></div>
        </div>

        <!-- Depósitos -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-bold text-lg mb-4">💧 Actividades por Tipo de Depósito</h3>
            <div id="grafica-depositos"></div>
        </div>

        <!-- Efectividad -->
        <div class="bg-white rounded-lg shadow p-6" id="efectividad" style="display:none;">
            <h3 class="font-bold text-lg mb-4">✅ Efectividad del Control</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-green-50 border-2 border-green-300 rounded p-6 text-center">
                    <div class="text-4xl font-bold text-green-600" id="negativos">0</div>
                    <div class="text-sm mt-2">Sin Vectores</div>
                    <div class="text-xs text-gray-600 mt-1" id="porc-neg">0%</div>
                </div>
                <div class="bg-red-50 border-2 border-red-300 rounded p-6 text-center">
                    <div class="text-4xl font-bold text-red-600" id="positivos">0</div>
                    <div class="text-sm mt-2">Con Vectores</div>
                    <div class="text-xs text-gray-600 mt-1" id="porc-pos">0%</div>
                </div>
            </div>
        </div>

    </div>

    <script>
        let datos = [];
        let filtrados = [];

        // Cargar datos
        window.onload = function() {
            cargarDatos();
        };

        function cargarDatos() {
            // CAMBIA ESTA URL POR LA DE TU API
            fetch('../controller/actividadescontrol.php?accion=listar')
                .then(r => r.json())
                .then(d => {
                    datos = d;
                    filtrados = d;
                    llenarFiltros();
                    actualizar();
                })
                .catch(e => {
                    console.error(e);
                    usarEjemplo();
                });
        }

        function usarEjemplo() {
            datos = [
                {nombre_sitio: 'Parque Central', nombre_deposito: 'Tanque 500L', nombre_actividad: 'Inspección', fecha_actividad: '2024-11-15', cod_act_campo: 4, positivo_larvas_aedes: 'No', positivo_pupas: 'No', positivo_culex: 'No'},
                {nombre_sitio: 'Parque Central', nombre_deposito: 'Tanque 500L', nombre_actividad: 'Siembra', fecha_actividad: '2024-11-16', cod_act_campo: 1},
                {nombre_sitio: 'Escuela Norte', nombre_deposito: 'Alberca', nombre_actividad: 'Inspección', fecha_actividad: '2024-11-18', cod_act_campo: 4, positivo_larvas_aedes: 'Sí', positivo_pupas: 'No', positivo_culex: 'No'},
                {nombre_sitio: 'Escuela Norte', nombre_deposito: 'Alberca', nombre_actividad: 'Siembra', fecha_actividad: '2024-11-19', cod_act_campo: 1},
                {nombre_sitio: 'Hospital Sur', nombre_deposito: 'Cisterna', nombre_actividad: 'Inspección', fecha_actividad: '2024-11-20', cod_act_campo: 4, positivo_larvas_aedes: 'No', positivo_pupas: 'Sí', positivo_culex: 'No'},
                {nombre_sitio: 'Centro Comunitario', nombre_deposito: 'Tanque 1000L', nombre_actividad: 'Resiembra', fecha_actividad: '2024-11-22', cod_act_campo: 2},
                {nombre_sitio: 'Parque Central', nombre_deposito: 'Fuente', nombre_actividad: 'Seguimiento', fecha_actividad: '2024-11-25', cod_act_campo: 3},
                {nombre_sitio: 'Hospital Sur', nombre_deposito: 'Cisterna', nombre_actividad: 'Seguimiento', fecha_actividad: '2024-11-28', cod_act_campo: 3},
            ];
            filtrados = datos;
            llenarFiltros();
            actualizar();
        }

        function llenarFiltros() {
            const sitios = [...new Set(datos.map(d => d.nombre_sitio))];
            const select = document.getElementById('filtro-sitio');
            sitios.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s;
                opt.textContent = s;
                select.appendChild(opt);
            });
        }

        function aplicarFiltros() {
            const fi = document.getElementById('fecha-inicio').value;
            const ff = document.getElementById('fecha-fin').value;
            const sitio = document.getElementById('filtro-sitio').value;

            filtrados = datos.filter(d => {
                if (fi && d.fecha_actividad < fi) return false;
                if (ff && d.fecha_actividad > ff) return false;
                if (sitio && d.nombre_sitio !== sitio) return false;
                return true;
            });
            actualizar();
        }

        function limpiarFiltros() {
            document.getElementById('fecha-inicio').value = '';
            document.getElementById('fecha-fin').value = '';
            document.getElementById('filtro-sitio').value = '';
            filtrados = datos;
            actualizar();
        }

        function actualizar() {
            actualizarTarjetas();
            actualizarGraficas();
            actualizarEfectividad();
        }

        function actualizarTarjetas() {
            document.getElementById('total').textContent = filtrados.length;
            document.getElementById('sitios').textContent = new Set(filtrados.map(d => d.nombre_sitio)).size;
            document.getElementById('depositos').textContent = new Set(filtrados.map(d => d.nombre_deposito)).size;
            document.getElementById('inspecciones').textContent = filtrados.filter(d => d.cod_act_campo == 4).length;
        }

        function actualizarGraficas() {
            // Sitios
            const sitios = {};
            filtrados.forEach(d => {
                sitios[d.nombre_sitio] = (sitios[d.nombre_sitio] || 0) + 1;
            });
            crearBarras('grafica-sitios', sitios);

            // Tipos
            const tipos = {};
            filtrados.forEach(d => {
                tipos[d.nombre_actividad] = (tipos[d.nombre_actividad] || 0) + 1;
            });
            crearBarras('grafica-tipos', tipos);

            // Depósitos
            const deps = {};
            filtrados.forEach(d => {
                deps[d.nombre_deposito] = (deps[d.nombre_deposito] || 0) + 1;
            });
            crearBarras('grafica-depositos', deps);
        }

        function crearBarras(id, data) {
            const div = document.getElementById(id);
            div.innerHTML = '';
            
            const max = Math.max(...Object.values(data));
            
            Object.entries(data).sort((a,b) => b[1] - a[1]).forEach(([nombre, valor]) => {
                const ancho = (valor / max) * 100;
                div.innerHTML += `
                    <div class="mb-3">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium">${nombre}</span>
                            <span class="text-sm font-bold">${valor}</span>
                        </div>
                        <div class="bg-gray-200 rounded h-8">
                            <div class="barra" style="width: ${ancho}%"></div>
                        </div>
                    </div>
                `;
            });
        }

        function actualizarEfectividad() {
            const insp = filtrados.filter(d => d.cod_act_campo == 4);
            if (insp.length === 0) {
                document.getElementById('efectividad').style.display = 'none';
                return;
            }

            document.getElementById('efectividad').style.display = 'block';

            const pos = insp.filter(d => 
                d.positivo_larvas_aedes === 'Sí' || 
                d.positivo_pupas === 'Sí' || 
                d.positivo_culex === 'Sí'
            ).length;

            const neg = insp.length - pos;
            const pPos = ((pos / insp.length) * 100).toFixed(1);
            const pNeg = ((neg / insp.length) * 100).toFixed(1);

            document.getElementById('positivos').textContent = pos;
            document.getElementById('negativos').textContent = neg;
            document.getElementById('porc-pos').textContent = pPos + '%';
            document.getElementById('porc-neg').textContent = pNeg + '%';
        }
    </script>
</body>
</html>