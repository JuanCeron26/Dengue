const counters = [
    'q1a', 'q1b', 'q1c', 'q1d',
    'q2a', 'q2b', 'q2c', 'q2d',
    'q3a', 'q3b', 'q3c', 'q3d'
];

function incrementCounter(id) {
    const element = document.getElementById(id);
    const currentValue = parseInt(element.textContent);
    element.textContent = currentValue + 1;
    updateTotal();
}

function decrementCounter(id) {
    const element = document.getElementById(id);
    const currentValue = parseInt(element.textContent);
    if (currentValue > 0) {
        element.textContent = currentValue - 1;
        updateTotal();
    }
}

function updateTotal() {
    let total = 0;
    counters.forEach(id => {
        total += parseInt(document.getElementById(id).textContent);
    });
    document.getElementById('totalCount').textContent = total;
}

function resetCounters() {
    if (confirm('¿Estás seguro de que deseas reiniciar todos los contadores?')) {
        counters.forEach(id => {
            document.getElementById(id).textContent = '0';
        });
        updateTotal();
    }
}