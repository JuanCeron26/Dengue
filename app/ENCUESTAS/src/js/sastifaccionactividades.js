class EncuestaActividades {
    constructor() {
        this.apiUrl = '../controller/controllerActividades.php';
        this.votos = {};
        this.preguntas = [];
        this.codTerritorio = null;
        this.preguntasRespondidas = new Set();

        // URLs de los GIFs - AJUSTA ESTAS RUTAS SEGÚN TU ESTRUCTURA
        this.gifsEmociones = {
            'Muy Satisfecho': '../gif/Happy1.gif',
            'Satisfecho': '../gif/happy.gif',
            'Neutral': '../gif/neutral.gif',
            'Insatisfecho': '../gif/ds.gif',
            'Muy Insatisfecho': '../gif/pues.gif'
        };

        this.init();
    }

    async init() {
        await this.cargarEncuesta();
        this.setupEventListeners();
    }

    async cargarEncuesta() {
        try {
            const response = await fetch(`${this.apiUrl}?action=obtener&cod_tipo_form=4`);
            const data = await response.json();

            console.log('Respuesta:', data);

            if (data.success) {
                this.preguntas = data.data;
                this.renderizarEncuesta();
                document.getElementById('acciones').style.display = 'flex';
            } else {
                this.mostrarError(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            this.mostrarError('Error de conexión: ' + error.message);
        }
    }

    renderizarEncuesta() {
        const container = document.getElementById('encuesta-container');
        container.innerHTML = '';

        this.preguntas.forEach((pregunta, index) => {
            const card = this.crearPreguntaCard(pregunta, index);
            container.appendChild(card);

            pregunta.opciones.forEach(opcion => {
                this.votos[opcion.cod_pregresp] = 0;
            });
        });
    }

    obtenerGifUrl(enunciado) {
        console.log('🔍 Buscando GIF para:', enunciado);

        const emocionesOrdenadas = Object.keys(this.gifsEmociones)
            .sort((a, b) => b.length - a.length);

        for (const emocion of emocionesOrdenadas) {
            if (enunciado.includes(emocion)) {
                console.log('✅ GIF encontrado:', emocion, '→', this.gifsEmociones[emocion]);
                return this.gifsEmociones[emocion];
            }
        }

        console.log('⚠️ No se encontró coincidencia, usando Neutral');
        return this.gifsEmociones['Neutral'];
    }

    crearPreguntaCard(pregunta, index) {
        const card = document.createElement('div');
        card.className = 'pregunta-card';
        if (index > 0) {
            card.classList.add('bloqueada');
        }

        let opcionesHTML = '';

        pregunta.opciones.forEach(opcion => {
            const colorClass = this.obtenerColorClass(opcion.enunciado);
            const gifUrl = this.obtenerGifUrl(opcion.enunciado);

            opcionesHTML += `
                <div class="opcion ${colorClass}" 
                     data-cod-pregresp="${opcion.cod_pregresp}"
                     data-pregunta-index="${index}">
                    <div class="emoji-container">
                        <img src="${gifUrl}" 
                             alt="${opcion.enunciado}" 
                             class="gif-emoji"
                             loading="lazy"
                             onerror="console.error('❌ Error cargando GIF: ${gifUrl}'); this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22><text x=%2250%%22 y=%2250%%22 font-size=%2240%22 text-anchor=%22middle%22 dy=%22.3em%22>❓</text></svg>';">
                    </div>
                    <div class="label">${opcion.enunciado}</div>
                    <div class="contador" id="count-${opcion.cod_pregresp}">0</div>
                    <div class="barra-progreso">
                        <div class="barra-fill" id="bar-${opcion.cod_pregresp}" style="width: 0%"></div>
                    </div>
                    <div class="porcentaje" id="percent-${opcion.cod_pregresp}">0%</div>
                    <button class="btn-restar" 
                            data-cod-pregresp="${opcion.cod_pregresp}"
                            data-pregunta-index="${index}"
                            style="display: none;">
                        ➖ Quitar voto
                    </button>
                </div>
            `;
        });

        const lockIcon = index > 0 ? '<span class="lock-icon">🔒</span>' : '';

        card.innerHTML = `
            <div class="pregunta-header">
                <div class="pregunta-titulo">${pregunta.enunciado_pregunta}</div>
                ${lockIcon}
            </div>
            <div class="opciones">${opcionesHTML}</div>
            <div class="total-votos">
                Total de votos: <span id="total-${index}">0</span>
            </div>
        `;

        return card;
    }

    obtenerColorClass(enunciado) {
        if (enunciado.includes('Muy Satisfecho')) return 'muy-satisfecho';
        if (enunciado.includes('Satisfecho')) return 'satisfecho';
        if (enunciado.includes('Neutral')) return 'neutral';
        if (enunciado.includes('Insatisfecho')) return 'insatisfecho';
        if (enunciado.includes('Muy Insatisfecho')) return 'muy-iinsatisfecho';
        return 'neutral';
    }

    setupEventListeners() {
        document.addEventListener('click', (e) => {
            const opcion = e.target.closest('.opcion');
            if (opcion && !e.target.classList.contains('btn-restar')) {
                this.votar(opcion);
            }

            const btnRestar = e.target.closest('.btn-restar');
            if (btnRestar) {
                e.stopPropagation();
                this.restarVoto(btnRestar);
            }
        });

        document.getElementById('btn-enviar').addEventListener('click', () => {
            this.enviarEncuesta();
        });

        document.getElementById('btn-reiniciar').addEventListener('click', () => {
            this.reiniciarEncuesta();
        });
    }

    votar(opcionElement) {
        const codPregresp = parseInt(opcionElement.dataset.codPregresp);
        const preguntaIndex = parseInt(opcionElement.dataset.preguntaIndex);

        if (preguntaIndex > 0 && !this.preguntasRespondidas.has(preguntaIndex - 1)) {
            this.mostrarAlerta('⚠️ Por favor responde la pregunta anterior primero');
            return;
        }

        this.votos[codPregresp]++;
        this.preguntasRespondidas.add(preguntaIndex);

        this.desbloquearSiguientePregunta(preguntaIndex);

        const countElement = document.getElementById(`count-${codPregresp}`);
        countElement.textContent = this.votos[codPregresp];
        countElement.classList.add('animado');
        setTimeout(() => countElement.classList.remove('animado'), 300);

        const btnRestar = opcionElement.querySelector('.btn-restar');
        if (btnRestar && this.votos[codPregresp] > 0) {
            btnRestar.style.display = 'block';
        }

        const emojiContainer = opcionElement.querySelector('.emoji-container');
        const effect = document.createElement('div');
        effect.className = 'click-effect';
        emojiContainer.appendChild(effect);
        setTimeout(() => effect.remove(), 600);

        this.actualizarPorcentajes(preguntaIndex);
    }

    restarVoto(btnElement) {
        const codPregresp = parseInt(btnElement.dataset.codPregresp);
        const preguntaIndex = parseInt(btnElement.dataset.preguntaIndex);

        if (this.votos[codPregresp] > 0) {
            this.votos[codPregresp]--;

            const countElement = document.getElementById(`count-${codPregresp}`);
            countElement.textContent = this.votos[codPregresp];
            countElement.classList.add('animado');
            setTimeout(() => countElement.classList.remove('animado'), 300);

            if (this.votos[codPregresp] === 0) {
                btnElement.style.display = 'none';
            }

            this.actualizarPorcentajes(preguntaIndex);

            // 🔒 NUEVA LÓGICA: Verificar si la pregunta quedó sin votos
            this.verificarYBloquearSiguientes(preguntaIndex);

            this.mostrarAlerta('✅ Voto eliminado');
        }
    }

    // 🆕 NUEVA FUNCIÓN: Verifica si una pregunta tiene votos
    tienePreguntaVotos(preguntaIndex) {
        const pregunta = this.preguntas[preguntaIndex];
        let totalVotos = 0;

        pregunta.opciones.forEach(opcion => {
            totalVotos += this.votos[opcion.cod_pregresp];
        });

        return totalVotos > 0;
    }

    // 🆕 NUEVA FUNCIÓN: Verifica y bloquea preguntas siguientes si es necesario
    verificarYBloquearSiguientes(preguntaIndex) {
        // Si la pregunta actual quedó sin votos
        if (!this.tienePreguntaVotos(preguntaIndex)) {
            // Eliminarla del set de respondidas
            this.preguntasRespondidas.delete(preguntaIndex);

            // Bloquear todas las preguntas siguientes
            const cards = document.querySelectorAll('.pregunta-card');
            for (let i = preguntaIndex + 1; i < this.preguntas.length; i++) {
                cards[i].classList.add('bloqueada');
                this.preguntasRespondidas.delete(i);
            }

            console.log(`🔒 Pregunta ${preguntaIndex} sin votos. Bloqueadas desde ${preguntaIndex + 1}`);
        }
    }

    desbloquearSiguientePregunta(preguntaIndex) {
        const siguienteIndex = preguntaIndex + 1;
        if (siguienteIndex < this.preguntas.length) {
            const cards = document.querySelectorAll('.pregunta-card');
            if (cards[siguienteIndex]) {
                cards[siguienteIndex].classList.remove('bloqueada');
            }
        }
    }

    mostrarAlerta(mensaje) {
        const alerta = document.createElement('div');
        alerta.className = 'alerta-custom';
        alerta.textContent = mensaje;
        document.body.appendChild(alerta);

        setTimeout(() => {
            alerta.classList.add('show');
        }, 10);

        setTimeout(() => {
            alerta.classList.remove('show');
            setTimeout(() => alerta.remove(), 300);
        }, 2500);
    }

    actualizarPorcentajes(preguntaIndex) {
        const pregunta = this.preguntas[preguntaIndex];
        let totalPregunta = 0;

        pregunta.opciones.forEach(opcion => {
            totalPregunta += this.votos[opcion.cod_pregresp];
        });

        document.getElementById(`total-${preguntaIndex}`).textContent = totalPregunta;

        pregunta.opciones.forEach(opcion => {
            const porcentaje = totalPregunta > 0
                ? (this.votos[opcion.cod_pregresp] / totalPregunta * 100).toFixed(1)
                : 0;

            document.getElementById(`bar-${opcion.cod_pregresp}`).style.width = `${porcentaje}%`;
            document.getElementById(`percent-${opcion.cod_pregresp}`).textContent = `${porcentaje}%`;
        });
    }

    async enviarEncuesta() {
        // 🚫 Validación: deben estar todas las preguntas respondidas
        if (this.preguntasRespondidas.size !== this.preguntas.length) {
            this.mostrarAlerta('⚠️ Debes responder todas las preguntas antes de enviar.');
            return;
        }

        const totalVotos = Object.values(this.votos).reduce((sum, val) => sum + val, 0);

        if (totalVotos === 0) {
            this.mostrarAlerta('⚠️ Debes seleccionar al menos una opción.');
            return;
        }

        const btnEnviar = document.getElementById('btn-enviar');
        btnEnviar.disabled = true;
        btnEnviar.textContent = '⏳ Enviando...';

        try {
            const params = new URLSearchParams(window.location.search);
            const codTerritorio = params.get('cod_territorio');
            const payload = {
                cod_territorio: codTerritorio,
                resultados: this.votos
            };

            console.log('📤 Enviando:', payload);

            const response = await fetch(`${this.apiUrl}?action=guardar`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            console.log('✅ Respuesta guardado:', data);

            if (data.success) {
                this.mostrarExito();
            } else {
                alert('Error: ' + data.message);
                btnEnviar.disabled = false;
                btnEnviar.textContent = '📤 Enviar Encuesta';
            }

        } catch (error) {
            console.error('❌ Error:', error);
            alert('Error de conexión al enviar la encuesta');
            btnEnviar.disabled = false;
            btnEnviar.textContent = '📤 Enviar Encuesta';
        }
    }

    reiniciarEncuesta() {
        if (confirm('¿Estás seguro de reiniciar todos los votos?')) {
            Object.keys(this.votos).forEach(key => {
                this.votos[key] = 0;
            });

            this.preguntasRespondidas.clear();

            const cards = document.querySelectorAll('.pregunta-card');
            cards.forEach((card, index) => {
                if (index > 0) {
                    card.classList.add('bloqueada');
                }
            });

            this.preguntas.forEach((pregunta, index) => {
                pregunta.opciones.forEach(opcion => {
                    document.getElementById(`count-${opcion.cod_pregresp}`).textContent = '0';
                    document.getElementById(`bar-${opcion.cod_pregresp}`).style.width = '0%';
                    document.getElementById(`percent-${opcion.cod_pregresp}`).textContent = '0%';

                    const btnRestar = document.querySelector(`[data-cod-pregresp="${opcion.cod_pregresp}"].btn-restar`);
                    if (btnRestar) {
                        btnRestar.style.display = 'none';
                    }
                });
                document.getElementById(`total-${index}`).textContent = '0';
            });

            cards[0]?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    mostrarExito() {
        document.getElementById('modal-exito').style.display = 'flex';
    }

    mostrarError(mensaje) {
        document.getElementById('encuesta-container').innerHTML = `
            <div class="error-message">
                <h3>❌ Error</h3>
                <p>${mensaje}</p>
                <button onclick="location.reload()">Reintentar</button>
            </div>
        `;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new EncuestaActividades();
});