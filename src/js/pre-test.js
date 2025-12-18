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
            this.syncWithInput(id);
            this.updateTotal();
        }
    }

    decrementCounter(id) {
        const element = document.getElementById(id);
        if (element) {
            const currentValue = parseInt(element.textContent);
            if (currentValue > 0) {
                element.textContent = currentValue - 1;
                this.syncWithInput(id);
                this.updateTotal();
            }
        }
    }

    // Sincronizar valor del contador con el input hidden
    syncWithInput(id) {
        const element = document.getElementById(id);
        const inputField = document.getElementById('input_' + id);
        if (element && inputField) {
            inputField.value = element.textContent;
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
                    this.syncWithInput(id);
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