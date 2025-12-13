// Clase para manejar los contadores del formulario
class CounterManager {
    constructor(counterIds) {
        this.counters = counterIds;
        this.init();
    }

    init() {
        this.updateTotal();
    }

    incrementCounter(id) {
        const element = document.getElementById(id);
        if (element) {
            const currentValue = parseInt(element.textContent);
            element.textContent = currentValue + 1;
            this.updateTotal();
        }
    }

    decrementCounter(id) {
        const element = document.getElementById(id);
        if (element) {
            const currentValue = parseInt(element.textContent);
            if (currentValue > 0) {
                element.textContent = currentValue - 1;
                this.updateTotal();
            }
        }
    }

    updateTotal() {
        let total = 0;
        this.counters.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                total += parseInt(element.textContent) || 0;
            }
        });
        const totalElement = document.getElementById('totalCount');
        if (totalElement) {
            totalElement.textContent = total;
        }
    }

    resetCounters() {
        if (confirm('¿Estás seguro de que deseas reiniciar todos los contadores?')) {
            this.counters.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = '0';
                }
            });
            this.updateTotal();
        }
    }

    // Método para obtener todos los valores actuales
    getCounterValues() {
        const values = {};
        this.counters.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                values[id] = parseInt(element.textContent) || 0;
            }
        });
        return values;
    }

    // Método para guardar los datos (opcional, para futuro uso)
    async saveData() {
        const data = this.getCounterValues();
        console.log('Datos a guardar:', data);
        
        // Aquí puedes hacer una llamada AJAX para guardar en la BD
        /*
        try {
            const response = await fetch('guardar_respuestas.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            console.log('Respuesta del servidor:', result);
            return result;
        } catch (error) {
            console.error('Error al guardar:', error);
        }
        */
    }
}

// Función global para inicializar el manager
let counterManager;

function initCounterManager(counterIds) {
    counterManager = new CounterManager(counterIds);
}

// Funciones globales para mantener compatibilidad con el HTML
function incrementCounter(id) {
    if (counterManager) {
        counterManager.incrementCounter(id);
    }
}

function decrementCounter(id) {
    if (counterManager) {
        counterManager.decrementCounter(id);
    }
}

function updateTotal() {
    if (counterManager) {
        counterManager.updateTotal();
    }
}

function resetCounters() {
    if (counterManager) {
        counterManager.resetCounters();
    }
}

function getCounterValues() {
    if (counterManager) {
        return counterManager.getCounterValues();
    }
    return {};
}

function saveData() {
    if (counterManager) {
        return counterManager.saveData();
    }
}