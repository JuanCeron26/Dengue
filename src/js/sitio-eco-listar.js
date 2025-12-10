document.addEventListener('DOMContentLoaded', () => {

    // Referencias a elementos del modal
    const modal = document.getElementById('addressModal');
    const btnOpenModal = document.getElementById('btnAbrirModalAdreess');
    const btnCloseModal = document.getElementById('btnCloseAdress');
    const btnSaveAddress = document.getElementById('btnSaveAdress');
    const btnClearAddress = document.getElementById('btnClearAddress');
    const btnClearLastField = document.getElementById('btnClearLastField');
    
    // Campos del formulario de dirección
    const viaType = document.getElementById('viaType');
    const viaNumber = document.getElementById('viaNumber');
    const suffix = document.getElementById('suffix');
    const distance = document.getElementById('distance');
    const cardinalPoint = document.getElementById('cardinalPoint');
    const generatedAddress = document.getElementById('generatedAddress');
    const addressInput = document.getElementById('address');

    // Función para abrir el modal
    function openAddressModal() {
        modal.classList.remove('hidden');
        updateGeneratedAddress();
    }

    // Función para cerrar el modal
    function closeAddressModal() {
        modal.classList.add('hidden');
    }

    // Función para actualizar la dirección generada en tiempo real
    function updateGeneratedAddress() {
        let addressParts = [];

        // Tipo de Vía + Número Vía
        if (viaType.value && viaNumber.value) {
            addressParts.push(`${viaType.value} ${viaNumber.value}`);
        } else if (viaType.value) {
            addressParts.push(viaType.value);
        } else if (viaNumber.value) {
            addressParts.push(viaNumber.value);
        }

        // Sufijo (opcional) - se agrega inmediatamente después del número de vía
        if (suffix.value) {
            if (addressParts.length > 0) {
                addressParts[addressParts.length - 1] += suffix.value.toUpperCase();
            } else {
                addressParts.push(suffix.value.toUpperCase());
            }
        }

        // # + Distancia - El # se agrega automáticamente si hay distancia
        if (distance.value) {
            addressParts.push(`# ${distance.value}`);
        }

        // Punto Cardinal (opcional)
        if (cardinalPoint.value) {
            addressParts.push(cardinalPoint.value);
        }

        // Mostrar la dirección generada o un guion si está vacía
        const finalAddress = addressParts.length > 0 ? addressParts.join(' ') : '-';
        generatedAddress.textContent = finalAddress;
    }

    // Función para guardar la dirección
    function saveAddress() {
        const finalAddress = generatedAddress.textContent;

        // Validar que al menos haya algo de dirección
        if (finalAddress === '-' || !viaType.value || !viaNumber.value) {
            alert('Por favor completa al menos: Tipo de Vía y Número Vía');
            return;
        }

        // Establecer la dirección en el campo principal
        addressInput.value = finalAddress;
        
        // Cerrar el modal
        closeAddressModal();
    }

    // Función para borrar todos los campos
    function clearAllFields() {
        viaType.value = '';
        viaNumber.value = '';
        suffix.value = '';
        distance.value = '';
        cardinalPoint.value = '';
        updateGeneratedAddress();
    }

    // Función para borrar el último campo completado
    function clearLastField() {
        if (cardinalPoint.value) {
            cardinalPoint.value = '';
        } else if (distance.value) {
            distance.value = '';
        } else if (suffix.value) {
            suffix.value = '';
        } else if (viaNumber.value) {
            viaNumber.value = '';
        } else if (viaType.value) {
            viaType.value = '';
        }
        updateGeneratedAddress();
    }

    // Convertir sufijo a mayúsculas automáticamente
    suffix.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Event Listeners para abrir/cerrar modal
    btnOpenModal.addEventListener('click', openAddressModal);
    btnCloseModal.addEventListener('click', closeAddressModal);
    btnSaveAddress.addEventListener('click', saveAddress);
    btnClearAddress.addEventListener('click', clearAllFields);
    btnClearLastField.addEventListener('click', clearLastField);

    // Event Listeners para actualizar la dirección en tiempo real
    viaType.addEventListener('change', updateGeneratedAddress);
    viaNumber.addEventListener('input', updateGeneratedAddress);
    suffix.addEventListener('input', updateGeneratedAddress);
    distance.addEventListener('input', updateGeneratedAddress);
    cardinalPoint.addEventListener('change', updateGeneratedAddress);

    // Cerrar modal al hacer clic fuera de él
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeAddressModal();
        }
    });

    // Cerrar modal con la tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeAddressModal();
        }
    });

    // Manejar el envío del formulario principal
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validar que todos los campos estén completos
        const sitioEco = document.getElementById('siteName').value.trim();
        const barrio = document.getElementById('barrio').value;
        const direccion = addressInput.value.trim();

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
                
                // Redirigir a listar.php
                window.location.href = 'listar.php';
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
});