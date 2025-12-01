      // Referencias a elementos
        const page1 = document.getElementById('page1');
        const page2 = document.getElementById('page2');
        const btnSiguiente = document.getElementById('btnSiguiente');
        const btnAnterior = document.getElementById('btnAnterior');
        const btnAgregarTanque = document.getElementById('btnAgregarTanque');
        const tanquesContainer = document.getElementById('tanquesContainer');
        const pageCounter = document.getElementById('pageCounter');
        const indicator1 = document.getElementById('page-indicator-1');
        const indicator2 = document.getElementById('page-indicator-2');

        // Modal de dirección
        const modalDireccion = document.getElementById('modalDireccion');
        const btnAbrirModal = document.getElementById('btnAbrirModal');
        const btnCerrarModal = document.getElementById('btnCerrarModal');
        const btnAplicarDireccion = document.getElementById('btnAplicarDireccion');
        const btnBorrarModal = document.getElementById('btnBorrarModal');
        const btnBorrarUltimoModal = document.getElementById('btnBorrarUltimoModal');
        const vistaPrevia = document.getElementById('vistaPrevia');

        // Inputs del formulario principal
        const nombreZoo = document.getElementById('nombreZoo');
        const barrio = document.getElementById('barrio');
        const direccion = document.getElementById('direccion');

        // Inputs del modal
        const tipoVia = document.getElementById('tipoVia');
        const numeroVia = document.getElementById('numeroVia');
        const numeroSimbolo = document.getElementById('numeroSimbolo');
        const sufijo = document.getElementById('sufijo');
        const distancia = document.getElementById('distancia');

        // Validar formulario en tiempo real
        function validarFormulario() {
            const valido = nombreZoo.value.trim() !== '' && 
                          barrio.value !== '' && 
                          direccion.value.trim() !== '';
            
            btnSiguiente.disabled = !valido;
        }

        // Event listeners para validación
        nombreZoo.addEventListener('input', validarFormulario);
        barrio.addEventListener('change', validarFormulario);
        direccion.addEventListener('input', validarFormulario);

        // Abrir modal de dirección
        btnAbrirModal.addEventListener('click', () => {
            modalDireccion.classList.remove('hidden');
            modalDireccion.classList.add('flex');
        });

        // Cerrar modal
        function cerrarModal() {
            modalDireccion.classList.add('hidden');
            modalDireccion.classList.remove('flex');
        }

        btnCerrarModal.addEventListener('click', cerrarModal);

        // Actualizar vista previa de dirección
        function actualizarVistaPreviaModal() {
            const partes = [];
            
            if (tipoVia.value && tipoVia.value !== '-') partes.push(tipoVia.value);
            if (numeroVia.value.trim()) partes.push(numeroVia.value.trim());
            if (sufijo.value.trim()) partes.push(sufijo.value.trim());
            if (distancia.value.trim()) partes.push('#' + distancia.value.trim());
            
            const direccionCompleta = partes.length > 0 ? partes.join(' ') : '-';
            vistaPrevia.textContent = direccionCompleta;
        }

        // Event listeners para actualizar vista previa
        tipoVia.addEventListener('change', actualizarVistaPreviaModal);
        numeroVia.addEventListener('input', actualizarVistaPreviaModal);
        sufijo.addEventListener('input', actualizarVistaPreviaModal);
        distancia.addEventListener('input', actualizarVistaPreviaModal);

        // Borrar todo
        btnBorrarModal.addEventListener('click', () => {
            tipoVia.value = '';
            numeroVia.value = '';
            sufijo.value = '';
            distancia.value = '';
            actualizarVistaPreviaModal();
        });

        // Borrar último campo (de derecha a izquierda)
        btnBorrarUltimoModal.addEventListener('click', () => {
            if (distancia.value) {
                distancia.value = '';
            } else if (sufijo.value) {
                sufijo.value = '';
            } else if (numeroVia.value) {
                numeroVia.value = '';
            } else if (tipoVia.value && tipoVia.value !== '') {
                tipoVia.value = '';
            }
            actualizarVistaPreviaModal();
        });

        // Aplicar dirección construida
        btnAplicarDireccion.addEventListener('click', () => {
            const direccionGenerada = vistaPrevia.textContent;
            if (direccionGenerada && direccionGenerada !== '-') {
                direccion.value = direccionGenerada;
                validarFormulario();
                cerrarModal();
            } else {
                alert('Por favor completa al menos un campo de la dirección.');
            }
        });

        // Navegación: Ir a página 2
        btnSiguiente.addEventListener('click', () => {
            page1.classList.add('hidden');
            page2.classList.remove('hidden');
            pageCounter.textContent = '2/2';
            indicator1.classList.remove('bg-azul-primario');
            indicator1.classList.add('bg-gray-300');
            indicator2.classList.remove('bg-gray-300');
            indicator2.classList.add('bg-azul-primario');
        });

        // Navegación: Volver a página 1
        btnAnterior.addEventListener('click', () => {
            page2.classList.add('hidden');
            page1.classList.remove('hidden');
            pageCounter.textContent = '1/2';
            indicator1.classList.remove('bg-gray-300');
            indicator1.classList.add('bg-azul-primario');
            indicator2.classList.remove('bg-azul-primario');
            indicator2.classList.add('bg-gray-300');
        });

        // Agregar nueva fila de tanque
        btnAgregarTanque.addEventListener('click', () => {
            const nuevaFila = document.createElement('div');
            nuevaFila.className = 'grid grid-cols-2 gap-4 tanque-row';
            nuevaFila.innerHTML = `
                <select 
                    name="tipoTanque[]" 
                    class="px-4 py-3 border-2 border-azul-medio rounded-lg focus:outline-none focus:border-azul-primario transition-all bg-azul-claro-1"
                    required
                >
                    <option value="">Seleccionar tipo</option>
                    <option value="1">Acuícola</option>
                    <option value="2">Reproductor</option>
                    <option value="3">Cría</option>
                </select>
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        name="nombreTanque[]" 
                        placeholder="Ingrese nombre"
                        class="flex-1 px-4 py-3 border-2 border-azul-medio rounded-lg focus:outline-none focus:border-azul-primario transition-all bg-azul-claro-1"
                        required
                    >
                    <button 
                        type="button" 
                        class="btn-eliminar bg-red-400 text-white px-3 rounded-lg hover:bg-red-500 transition-all"
                        title="Eliminar"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            `;
            tanquesContainer.appendChild(nuevaFila);

            // Agregar evento para eliminar
            const btnEliminar = nuevaFila.querySelector('.btn-eliminar');
            btnEliminar.addEventListener('click', () => {
                nuevaFila.remove();
            });
        });

        // Enviar formulario
        document.getElementById('formTanques').addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Recopilar datos
            const datosZoocriadero = {
                nombre: nombreZoo.value,
                barrio: barrio.value,
                direccion: direccion.value
            };

            const tanques = [];
            const filas = document.querySelectorAll('.tanque-row');
            filas.forEach(fila => {
                const tipo = fila.querySelector('select[name="tipoTanque[]"]').value;
                const nombre = fila.querySelector('input[name="nombreTanque[]"]').value;
                if (tipo && nombre) {
                    tanques.push({ tipo, nombre });
                }
            });

            console.log('Datos del Zoocriadero:', datosZoocriadero);
            console.log('Tanques asociados:', tanques);

            // Aquí harías el envío al servidor
            alert('Formulario enviado correctamente!\n\nZoocriadero: ' + datosZoocriadero.nombre + '\nDirección: ' + datosZoocriadero.direccion + '\nTanques: ' + tanques.length);
        });