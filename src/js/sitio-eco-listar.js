// ======================================
// SITIO ECO - LISTAR Y EDITAR
// ======================================

// Variable global para almacenar el sitio actualmente en edición
let currentSite = null;

// ======================================
// INICIALIZACIÓN DEL DOM
// ======================================
document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
});

// ======================================
// CONFIGURACIÓN DE EVENT LISTENERS
// ======================================
function initializeEventListeners() {
    // Botones de filtros
    const btnApplyFilters = document.getElementById('btnApplyFilters');
    const btnClearFilters = document.getElementById('btnClearFilters');
    const btnRefresh = document.getElementById('btnRefresh');
    
    if (btnApplyFilters) {
        btnApplyFilters.addEventListener('click', applyFilters);
    }
    
    if (btnClearFilters) {
        btnClearFilters.addEventListener('click', clearFilters);
    }
    
    if (btnRefresh) {
        btnRefresh.addEventListener('click', () => location.reload());
    }
    
    // Botones de las cards (usando delegación de eventos)
    document.addEventListener('click', function(e) {
        // Botón ver detalles
        if (e.target.closest('.btn-view-details')) {
            const btn = e.target.closest('.btn-view-details');
            const sitioData = btn.getAttribute('data-sitio');
            if (sitioData) {
                const sitio = JSON.parse(sitioData);
                viewDetails(sitio);
            }
        }
        
        // Botón editar
        if (e.target.closest('.btn-edit-site')) {
            const btn = e.target.closest('.btn-edit-site');
            const sitioData = btn.getAttribute('data-sitio');
            if (sitioData) {
                const sitio = JSON.parse(sitioData);
                loadSiteData(sitio);
            }
        }
        
        // Botón desactivar
        if (e.target.closest('.btn-deactivate-site')) {
            const btn = e.target.closest('.btn-deactivate-site');
            const cod = btn.getAttribute('data-cod');
            const nombre = btn.getAttribute('data-nombre');
            if (cod && nombre) {
                deactivateSite(cod, nombre);
            }
        }
    });
    
    // Botones del formulario de edición
    const btnSaveSite = document.getElementById('btnSaveSite');
    const btnCancelEdit = document.getElementById('btnCancelEdit');
    
    if (btnSaveSite) {
        btnSaveSite.addEventListener('click', saveSite);
    }
    
    if (btnCancelEdit) {
        btnCancelEdit.addEventListener('click', cancelEdit);
    }
    
    // Botones del modal de detalles
    const btnCloseDetailsModal = document.getElementById('btnCloseDetailsModal');
    const btnAcceptModal = document.getElementById('btnAcceptModal');
    const detailsModal = document.getElementById('detailsModal');
    
    if (btnCloseDetailsModal) {
        btnCloseDetailsModal.addEventListener('click', closeDetailsModal);
    }
    
    if (btnAcceptModal) {
        btnAcceptModal.addEventListener('click', closeDetailsModal);
    }
    
    // Cerrar modal al hacer clic fuera
    if (detailsModal) {
        detailsModal.addEventListener('click', function(e) {
            if (e.target === detailsModal) {
                closeDetailsModal();
            }
        });
    }
    
    // Cerrar modal con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('detailsModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeDetailsModal();
            }
        }
    });
}

// ======================================
// FUNCIONES DE FILTRADO
// ======================================
function applyFilters() {
    const comuna = document.getElementById('filterComuna').value;
    const barrio = document.getElementById('filterBarrio').value;
    
    // Construir URL con parámetros de filtro
    let url = 'listar.php?';
    const params = [];
    
    if (comuna) {
        params.push(`comuna=${encodeURIComponent(comuna)}`);
    }
    
    if (barrio) {
        params.push(`barrio=${encodeURIComponent(barrio)}`);
    }
    
    url += params.join('&');
    
    // Redirigir con los filtros
    window.location.href = url;
}

function clearFilters() {
    document.getElementById('filterComuna').value = '';
    document.getElementById('filterBarrio').value = '';
    
    // Recargar la página sin filtros
    window.location.href = 'listar.php';
}

// ======================================
// FUNCIONES DEL MODAL DE DETALLES
// ======================================
function viewDetails(sitio) {
    // Llenar el modal con los datos del sitio
    document.getElementById('modalNombre').textContent = sitio.nombre_sitio || '-';
    document.getElementById('modalId').textContent = sitio.cod_sitioeco || '-';
    document.getElementById('modalComuna').textContent = sitio.nomcomun || '-';
    document.getElementById('modalBarrio').textContent = sitio.nombarrio || '-';
    document.getElementById('modalDireccion').textContent = sitio.direccion || '-';
    
    // Mostrar el modal
    const modal = document.getElementById('detailsModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeDetailsModal() {
    const modal = document.getElementById('detailsModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// ======================================
// FUNCIONES DE EDICIÓN
// ======================================
function loadSiteData(sitio) {
    // Guardar el sitio actual en edición
    currentSite = sitio;
    
    // Llenar los campos del formulario
    document.getElementById('siteId').value = sitio.cod_sitioeco || '';
    document.getElementById('neighborhood').value = sitio.nombarrio || '';
    document.getElementById('address').value = sitio.direccion || '';
    document.getElementById('siteName').value = sitio.nombre_sitio || '';
    
    // Mostrar el formulario de edición y ocultar el estado vacío
    document.getElementById('emptyState').classList.add('hidden');
    document.getElementById('editForm').classList.remove('hidden');
    
    // Hacer scroll suave hacia el formulario
    const editFormContainer = document.getElementById('editForm').closest('.bg-white');
    if (editFormContainer) {
        editFormContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

function cancelEdit() {
    // Limpiar el sitio actual
    currentSite = null;
    
    // Limpiar los campos
    document.getElementById('siteId').value = '';
    document.getElementById('neighborhood').value = '';
    document.getElementById('address').value = '';
    document.getElementById('siteName').value = '';
    
    // Mostrar el estado vacío y ocultar el formulario
    document.getElementById('emptyState').classList.remove('hidden');
    document.getElementById('editForm').classList.add('hidden');
}

async function saveSite() {
    if (!currentSite) {
        alert('No hay ningún sitio seleccionado para editar');
        return;
    }
    
    const newName = document.getElementById('siteName').value.trim();
    
    // Validar que el nombre no esté vacío
    if (!newName) {
        alert('Por favor ingresa un nombre para el sitio');
        return;
    }
    
    // Validar que el nombre haya cambiado
    if (newName === currentSite.nombre_sitio) {
        alert('No se han realizado cambios en el nombre del sitio');
        return;
    }
    
    // Confirmar la actualización
    const confirmacion = confirm(`¿Estás seguro de actualizar el nombre del sitio a:\n"${newName}"?`);
    if (!confirmacion) {
        return;
    }
    
    try {
        // Preparar los datos para enviar
        const formData = new FormData();
        formData.append('cod_sitioeco', currentSite.cod_sitioeco);
        formData.append('nombre_sitio', newName);
        formData.append('accion', 'actualizar');
        
        // Enviar la petición al servidor
        const response = await fetch('../controllers/controllerActualizar.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✅ ' + result.message);
            
            // Recargar la página para ver los cambios
            window.location.reload();
        } else {
            alert('❌ Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error al actualizar:', error);
        alert('❌ Error al procesar la solicitud. Por favor intenta de nuevo.');
    }
}

// ======================================
// FUNCIÓN DE DESACTIVACIÓN
// ======================================
async function deactivateSite(codSitio, nombreSitio) {
    // Confirmar la desactivación
    const confirmacion = confirm(
        `¿Estás seguro de anular el sitio:\n"${nombreSitio}"?\n\nEsta acción no se puede deshacer.`
    );
    
    if (!confirmacion) {
        return;
    }
    
    try {
        // Preparar los datos para enviar
        const formData = new FormData();
        formData.append('cod_sitioeco', codSitio);
        formData.append('accion', 'anular');
        
        // Enviar la petición al servidor
        const response = await fetch('../controllers/controllerAnular.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✅ ' + result.message);
            
            // Recargar la página para ver los cambios
            window.location.reload();
        } else {
            alert('❌ Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error al anular:', error);
        alert('❌ Error al procesar la solicitud. Por favor intenta de nuevo.');
    }
}