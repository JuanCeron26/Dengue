document.addEventListener('DOMContentLoaded', () => {


document.getElementById('btnAbrirModalAdreess').addEventListener('click', () => {
    openAddressModal()
})

document.getElementById('btnCloseAdress').addEventListener('click', () => {
    closeAddressModal()
})

document.getElementById('btnSaveAdress').addEventListener('click', () => {
    saveAddress()
})
// Funciones para el modal de dirección
function openAddressModal() {
    document.getElementById('addressModal').classList.remove('hidden');
}

function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
}

function saveAddress() {
    const viaType = document.getElementById('viaType').value;
    const mainNumber = document.getElementById('mainNumber').value;
    const secundaryNumber = document.getElementById('secundaryNumber').value;
    const plateNumber = document.getElementById('plateNumber').value;

    // Validar que todos los campos estén llenos
    if (!viaType || !mainNumber || !secundaryNumber || !plateNumber) {
        alert('Por favor completa todos los campos de la dirección');
        return;
    }

    // Construir la dirección
    const fullAddress = `${viaType} ${mainNumber} # ${secundaryNumber} - ${plateNumber}`;
    
    // Establecer la dirección en el campo principal
    document.getElementById('address').value = fullAddress;
    
    // Cerrar el modal
    closeAddressModal();
    
    // Limpiar los campos del modal
    document.getElementById('viaType').value = '';
    document.getElementById('mainNumber').value = '';
    document.getElementById('secundaryNumber').value = '';
    document.getElementById('plateNumber').value = '';
}

// Cerrar modal al hacer clic fuera de él
document.getElementById('addressModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddressModal();
    }
});

// Manejar el envío del formulario
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Validar que todos los campos estén completos
    const sitioEco = document.getElementById('siteName').value.trim();
    const barrio = document.getElementById('barrio').value;
    const direccion = document.getElementById('address').value.trim();

    if (!sitioEco || !barrio || !direccion) {
        alert('Por favor completa todos los campos obligatorios');
        return;
    }

    // Crear FormData con los datos del formulario
    const form = document.getElementById('registerForm');
    const formData = new FormData(form);

    try {
        // Deshabilitar el botón de envío
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Registrando...';

        // Enviar datos al servidor
        const response = await fetch('../controllers/controllerRegistrar.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            // Mostrar mensaje de éxito
            alert('✅ ' + result.message + '\nCódigo del sitio: ' + result.cod_sitioeco);
            
            // Limpiar el formulario
            document.getElementById('registerForm').reset();
            document.getElementById('address').value = '';
            
            // Opcional: redirigir o actualizar la página
            // window.location.href = 'consultar.php';
        } else {
            // Mostrar mensaje de error
            alert('❌ Error: ' + result.message);
        }

        // Rehabilitar el botón
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;

    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al procesar la solicitud. Por favor intenta de nuevo.');
        
        // Rehabilitar el botón
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-map-marker-alt text-xl"></i> Registrar Sitio';
    }
});

// Validación en tiempo real para el campo de nombre del sitio
document.getElementById('siteName').addEventListener('input', function() {
    if (this.value.trim().length > 0) {
        this.classList.remove('border-red-500');
        this.classList.add('border-gray-300');
    }
});

// Validación en tiempo real para el select de barrio
document.getElementById('barrio').addEventListener('change', function() {
    if (this.value) {
        this.classList.remove('border-red-500');
        this.classList.add('border-eco-blue');
    }
});

// Permitir cerrar el modal con la tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('addressModal');
        if (!modal.classList.contains('hidden')) {
            closeAddressModal();
        }
    }
});


})