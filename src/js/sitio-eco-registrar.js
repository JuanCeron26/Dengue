// ======================================
// SITIO ECO - REGISTRAR
// ======================================

// ======================================
// INICIALIZACIÓN DEL DOM
// ======================================
document.addEventListener('DOMContentLoaded', function () {
    initializeModalElements();
    initializeFormElements();
    initializeEventListeners();
});

// ======================================
// REFERENCIAS A ELEMENTOS DEL MODAL
// ======================================
let modalElements = {};
let formElements = {};

function initializeModalElements() {
    modalElements = {
        modal: document.getElementById('addressModal'),
        btnOpenModal: document.getElementById('btnAbrirModalAdreess'),
        btnCloseModal: document.getElementById('btnCloseAdress'),
        btnSaveAddress: document.getElementById('btnSaveAdress'),
        btnClearAddress: document.getElementById('btnClearAddress'),
        btnClearLastField: document.getElementById('btnClearLastField'),
        viaType: document.getElementById('viaType'),
        viaNumber: document.getElementById('viaNumber'),
        suffix: document.getElementById('suffix'),
        distance: document.getElementById('distance'),
        cardinalPoint: document.getElementById('cardinalPoint'),
        generatedAddress: document.getElementById('generatedAddress')
    };
}

function initializeFormElements() {
    formElements = {
        registerForm: document.getElementById('registerForm'),
        siteName: document.getElementById('siteName'),
        barrio: document.getElementById('barrio'),
        addressInput: document.getElementById('address')
    };
}

// ======================================
// CONFIGURACIÓN DE EVENT LISTENERS
// ======================================
function initializeEventListeners() {
    // Event Listeners del Modal
    if (modalElements.btnOpenModal) {
        modalElements.btnOpenModal.addEventListener('click', openAddressModal);
    }

    if (modalElements.btnCloseModal) {
        modalElements.btnCloseModal.addEventListener('click', closeAddressModal);
    }

    if (modalElements.btnSaveAddress) {
        modalElements.btnSaveAddress.addEventListener('click', saveAddress);
    }

    if (modalElements.btnClearAddress) {
        modalElements.btnClearAddress.addEventListener('click', clearAllFields);
    }

    if (modalElements.btnClearLastField) {
        modalElements.btnClearLastField.addEventListener('click', clearLastField);
    }

    // Event Listeners para actualizar dirección en tiempo real
    if (modalElements.viaType) {
        modalElements.viaType.addEventListener('change', updateGeneratedAddress);
    }

    if (modalElements.viaNumber) {
        modalElements.viaNumber.addEventListener('input', updateGeneratedAddress);
    }

    if (modalElements.suffix) {
        modalElements.suffix.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
            updateGeneratedAddress();
        });
    }

    if (modalElements.distance) {
        modalElements.distance.addEventListener('input', updateGeneratedAddress);
    }

    if (modalElements.cardinalPoint) {
        modalElements.cardinalPoint.addEventListener('change', updateGeneratedAddress);
    }

    // Cerrar modal al hacer clic fuera de él
    if (modalElements.modal) {
        modalElements.modal.addEventListener('click', function (e) {
            if (e.target === modalElements.modal) {
                closeAddressModal();
            }
        });
    }

    // Cerrar modal con la tecla Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modalElements.modal && !modalElements.modal.classList.contains('hidden')) {
            closeAddressModal();
        }
    });

    // Event Listener del formulario principal
    if (formElements.registerForm) {
        formElements.registerForm.addEventListener('submit', handleFormSubmit);
    }

    // Validación en tiempo real para el nombre del sitio
    if (formElements.siteName) {
        formElements.siteName.addEventListener('input', function () {
            if (this.value.trim().length > 0) {
                this.classList.remove('border-red-500');
                this.classList.add('border-gray-300');
            }
        });
    }

    // Validación en tiempo real para el select de barrio
    if (formElements.barrio) {
        formElements.barrio.addEventListener('change', function () {
            if (this.value) {
                this.classList.remove('border-red-500');
                this.classList.add('border-eco-green-dark');
            }
        });
    }
}

// ======================================
// FUNCIONES DEL MODAL DE DIRECCIÓN
// ======================================
function openAddressModal() {
    if (modalElements.modal) {
        modalElements.modal.classList.remove('hidden');
        updateGeneratedAddress();
    }
}

function closeAddressModal() {
    if (modalElements.modal) {
        modalElements.modal.classList.add('hidden');
    }
}

function updateGeneratedAddress() {
    let addressParts = [];

    // Tipo de Vía + Número Vía
    if (modalElements.viaType.value && modalElements.viaNumber.value) {
        addressParts.push(`${modalElements.viaType.value} ${modalElements.viaNumber.value}`);
    } else if (modalElements.viaType.value) {
        addressParts.push(modalElements.viaType.value);
    } else if (modalElements.viaNumber.value) {
        addressParts.push(modalElements.viaNumber.value);
    }

    // Sufijo (opcional) - se agrega inmediatamente después del número de vía
    if (modalElements.suffix.value) {
        if (addressParts.length > 0) {
            addressParts[addressParts.length - 1] += modalElements.suffix.value.toUpperCase();
        } else {
            addressParts.push(modalElements.suffix.value.toUpperCase());
        }
    }

    // Punto Cardinal - VA AQUÍ (después del número, antes del #)
    if (modalElements.cardinalPoint.value) {
        addressParts.push(modalElements.cardinalPoint.value);
    }

    // # + Distancia - El # se agrega automáticamente si hay distancia
    if (modalElements.distance.value) {
        addressParts.push(`# ${modalElements.distance.value}`);
    }

    // Mostrar la dirección generada o un guion si está vacía
    const finalAddress = addressParts.length > 0 ? addressParts.join(' ') : '-';

    if (modalElements.generatedAddress) {
        modalElements.generatedAddress.textContent = finalAddress;
    }
}

function saveAddress() {
    const finalAddress = modalElements.generatedAddress.textContent;

    // Validar que al menos haya algo de dirección
    if (finalAddress === '-' || !modalElements.viaType.value || !modalElements.viaNumber.value) {
        alert('Por favor completa al menos: Tipo de Vía y Número Vía');
        return;
    }

    // Establecer la dirección en el campo principal
    if (formElements.addressInput) {
        formElements.addressInput.value = finalAddress;
    }

    // Cerrar el modal
    closeAddressModal();
}

function clearAllFields() {
    modalElements.viaType.value = '';
    modalElements.viaNumber.value = '';
    modalElements.suffix.value = '';
    modalElements.distance.value = '';
    modalElements.cardinalPoint.value = '';
    updateGeneratedAddress();
}

function clearLastField() {
    if (modalElements.cardinalPoint.value) {
        modalElements.cardinalPoint.value = '';
    } else if (modalElements.distance.value) {
        modalElements.distance.value = '';
    } else if (modalElements.suffix.value) {
        modalElements.suffix.value = '';
    } else if (modalElements.viaNumber.value) {
        modalElements.viaNumber.value = '';
    } else if (modalElements.viaType.value) {
        modalElements.viaType.value = '';
    }
    updateGeneratedAddress();
}

// ======================================
// MANEJO DEL FORMULARIO PRINCIPAL
// ======================================
async function handleFormSubmit(e) {
    e.preventDefault();

    // Validar que todos los campos estén completos
    const sitioEco = formElements.siteName.value.trim();
    const barrio = formElements.barrio.value;
    const direccion = formElements.addressInput.value.trim();

    if (!sitioEco || !barrio || !direccion) {
        alert('Por favor completa todos los campos obligatorios');
        return;
    }

    // Crear FormData con los datos del formulario
    const formData = new FormData(formElements.registerForm);

    try {
        // Deshabilitar el botón de envío
        const submitBtn = formElements.registerForm.querySelector('button[type="submit"]');
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

            // Rehabilitar el botón si hay error
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }

    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al procesar la solicitud. Por favor intenta de nuevo.');

        // Rehabilitar el botón
        const submitBtn = formElements.registerForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-map-marker-alt text-xl"></i> Registrar Sitio';
        }
    }
}