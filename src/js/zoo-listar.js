document.addEventListener('DOMContentLoaded', async () => {
  // ============================================================================
  // ELEMENTOS DEL DOM
  // ============================================================================
  
  const elements = {
    // Tabla y filtros
    tbody: document.getElementById('tbody'),
    filterForm: document.getElementById('filterForm'),
    btnApply: document.getElementById('btnApplyFilters'),
    btnClear: document.getElementById('btnClearFilters'),
    
    // Paginación
    currentPage: document.getElementById('currentPage'),
    totalPages: document.getElementById('totalPages'),
    prevBtn: document.getElementById('prevPage'),
    nextBtn: document.getElementById('nextPage'),
    
    // Modal principal
    modalOverlay: document.getElementById('modalOverlay'),
    modalTitle: document.getElementById('modalTitle'),
    modalForm: document.getElementById('modalForm'),
    modalCancel: document.getElementById('modalCancel'),
    closeModal: document.getElementById('closeModal'),
    modalSave: document.getElementById('modalSave'),
    btnEditarDireccion: document.getElementById('btnEditarDireccion'),
    btnAgregarTanque: document.getElementById('btnAgregarTanque'),
    
    // Campos del modal principal
    fields: {
      cod: document.getElementById('modal_cod_zoo'),
      nombre: document.getElementById('modal_nombre'),
      encargadoText: document.getElementById('modal_encargado'),
      encargadoSelect: document.getElementById('modal_encargado_select'),
      encargadoId: document.getElementById('modal_encargado_id'),
      barrio: document.getElementById('modal_barrio'),
      barrioSelect: document.getElementById('modal_barrio_select'),
      direccion: document.getElementById('modal_direccion'),
      tanquesList: document.getElementById('modal_tanques_list')
    },
    
    // Modal dirección
    modalDireccion: document.getElementById('modalDireccion'),
    btnCerrarModalDir: document.getElementById('btnCerrarModal'),
    tipoVia: document.getElementById('tipoVia'),
    numeroVia: document.getElementById('numeroVia'),
    sufijo: document.getElementById('sufijo'),
    distancia: document.getElementById('distancia'),
    vistaPrevia: document.getElementById('vistaPrevia'),
    btnBorrarModal: document.getElementById('btnBorrarModal'),
    btnBorrarUltimoModal: document.getElementById('btnBorrarUltimoModal'),
    btnAplicarDireccion: document.getElementById('btnAplicarDireccion'),
    
    // Modal agregar tanque
    modalAgregarTanque: document.getElementById('modalAgregarTanque'),
    btnCerrarModalTanque: document.getElementById('btnCerrarModalTanque'),
    btnGuardarTanque: document.getElementById('btnGuardarTanque'),
    selectTipoTanque: document.getElementById('selectTipoTanque'),
    inputNombreTanque: document.getElementById('inputNombreTanque')
  };

  // ============================================================================
  // CONSTANTES Y ESTADO GLOBAL
  // ============================================================================
  
  const PAGE_SIZE = 8;
  const initialRows = Array.from(elements.tbody.querySelectorAll('tr[data-cod]'));
  
  // Estado global (línea 69 - MANTENER SOLO ESTA)
const state = {
  // Propiedades de filtros
  filters: {
    filterName: '',
    filterEncargado: '',
    filterTipo: '',
    filterDireccion: ''
  },
  sortKey: null,
  sortDir: 1,
  page: 1,
  isEditMode: false,
  encargados: [],
  barrios: [],
  tiposTanque: [],
  tanquesDelZoo: [],
  currentCodZoo: null
};
  // ============================================================================
  // API: CARGA DE DATOS INICIALES
  // ============================================================================
  
  async function fetchData(action) {
    try {
      const response = await fetch(`../controllers/controllerListar.php?action=${action}`);
      const data = await response.json();
      
      if (data.data && Array.isArray(data.data)) {
        return data.data;
      } else if (Array.isArray(data)) {
        return data;
      } else {
        console.error(`Error: datos de ${action} no válidos`, data);
        return [];
      }
    } catch (error) {
      console.error(`Error al cargar ${action}:`, error);
      return [];
    }
  }

  async function cargarEncargados() {
    state.encargados = await fetchData('getEncargados');
    console.log('Encargados cargados:', state.encargados);
  }

  async function cargarBarrios() {
    state.barrios = await fetchData('getBarrios');
    console.log('Barrios cargados:', state.barrios);
  }

  async function cargarTiposTanque() {
    state.tiposTanque = await fetchData('getTiposTanque');
    console.log('Tipos de tanque cargados:', state.tiposTanque);
  }

  async function inicializarDatos() {
    await Promise.all([
      cargarEncargados(),
      cargarBarrios(),
      cargarTiposTanque()
    ]);
    console.log('Datos inicializados correctamente');
  }

  await inicializarDatos();

  // ============================================================================
  // FILTROS
  // ============================================================================
  
  function readFiltersFromForm() {
    state.filters.filterName = document.getElementById('filterName').value.trim();
    state.filters.filterEncargado = document.getElementById('filterEncargado').value.trim();
    state.filters.filterTipo = document.getElementById('filterTipo').value.trim();
    state.filters.filterDireccion = document.getElementById('filterDireccion').value.trim().toLowerCase();
    state.page = 1;
  }

  function clearFilters() {
    elements.filterForm.reset();
    state.filters = { filterName: '', filterEncargado: '', filterTipo: '', filterDireccion: '' };
    state.page = 1;
    render();
  }

  function getFilteredRows() {
    return initialRows.filter(tr => {
      const d = tr.dataset;
      
      if (state.filters.filterName && state.filters.filterName !== d.cod) return false;
      if (state.filters.filterEncargado && state.filters.filterEncargado !== (d.encargadoId || '')) return false;
      if (state.filters.filterTipo && state.filters.filterTipo.toLowerCase() !== (d.tipo || '').toLowerCase()) return false;
      
      if (state.filters.filterDireccion) {
        const dir = (d.direccion || '').toLowerCase();
        if (!dir.includes(state.filters.filterDireccion)) return false;
      }
      
      return true;
    });
  }

  elements.btnApply.addEventListener('click', (e) => {
    e.preventDefault();
    readFiltersFromForm();
    render();
  });

  elements.btnClear.addEventListener('click', (e) => {
    e.preventDefault();
    clearFilters();
  });

  // ============================================================================
  // ORDENAMIENTO
  // ============================================================================
  
  const sortGetters = {
    'index': (tr, i) => i,
    'nombre': tr => (tr.dataset.nombre || '').toLowerCase(),
    'encargado': tr => (tr.dataset.encargado || '').toLowerCase(),
    'direccion': tr => (tr.dataset.direccion || '').toLowerCase(),
    'tipo': tr => (tr.dataset.tipo || '').toLowerCase()
  };

  function sortRows(rows) {
    if (!state.sortKey) return rows;
    
    const getter = sortGetters[state.sortKey] || (tr => tr.textContent.toLowerCase());
    
    return rows.slice().sort((a, b) => {
      const A = getter(a);
      const B = getter(b);
      if (A < B) return -1 * state.sortDir;
      if (A > B) return 1 * state.sortDir;
      return 0;
    });
  }

  document.querySelectorAll('#tableZoos thead th[data-sort-key]').forEach(th => {
    th.addEventListener('click', () => {
      const key = th.getAttribute('data-sort-key');
      state.sortKey = key;
      state.sortDir = (state.sortKey === key) ? -state.sortDir : 1;
      state.page = 1;
      render();
    });
  });

  // ============================================================================
  // PAGINACIÓN
  // ============================================================================
  
  elements.prevBtn.addEventListener('click', () => {
    if (state.page > 1) {
      state.page--;
      render();
    }
  });

  elements.nextBtn.addEventListener('click', () => {
    const total = Math.max(1, Math.ceil(getFilteredRows().length / PAGE_SIZE));
    if (state.page < total) {
      state.page++;
      render();
    }
  });

  // ============================================================================
  // RENDERIZADO
  // ============================================================================
  
  function render() {
    const filtered = getFilteredRows();
    const sorted = sortRows(filtered);
    const totalPages = Math.max(1, Math.ceil(sorted.length / PAGE_SIZE));

    if (state.page > totalPages) state.page = totalPages;

    const start = (state.page - 1) * PAGE_SIZE;
    const visible = sorted.slice(start, start + PAGE_SIZE);

    elements.tbody.innerHTML = '';
    
    if (visible.length === 0) {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td colspan="5" class="text-center py-4 text-slate-500">
          No hay registros disponibles.
        </td>`;
      elements.tbody.appendChild(tr);
    } else {
      visible.forEach(origTr => elements.tbody.appendChild(origTr.cloneNode(true)));
    }

    elements.currentPage.textContent = state.page;
    elements.totalPages.textContent = totalPages;
  }

  render();

  // ============================================================================
  // EVENTOS DE ACCIÓN EN LA TABLA
  // ============================================================================
  
  document.getElementById('tableZoos').addEventListener('click', async (e) => {
    const btn = e.target.closest('[data-action]');
    if (!btn) return;

    const tr = btn.closest('tr');
    const action = btn.dataset.action;
    const d = tr.dataset;

    switch (action) {
      case 'view':
        abrirModalVer(d.cod);
        break;
        
      case 'edit':
        abrirModalEditar(d.cod);
        break;
        
      case 'delete':
        await eliminarZoocriadero(d.cod);
        break;
        
      case 'export':
        window.location.href = `exportar.php?cod_zoo=${encodeURIComponent(d.cod)}`;
        break;
    }
  });

  async function eliminarZoocriadero(codZoo) {
    if (!confirm('¿Estás seguro de anular este registro?')) return;

    try {
      const response = await fetch('../controllers/controllerAnular.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ cod_zoo: parseInt(codZoo) })
      });
      
      const json = await response.json();
      
      if (json.success) {
        alert(json.message || 'Zoocriadero anulado correctamente');
        location.reload();
      } else {
        alert(json.message || 'Error al anular el zoocriadero');
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Error al anular el zoocriadero');
    }
  }

  // ============================================================================
  // MODAL PRINCIPAL: CONTROL
  // ============================================================================
  
  function showModal() {
    elements.modalOverlay.classList.remove('hidden');
    elements.modalOverlay.classList.add('flex');
  }

  function hideModal() {
    elements.modalOverlay.classList.add('hidden');
    elements.modalOverlay.classList.remove('flex');
    state.isEditMode = false;
    state.currentCodZoo = null;
    resetModalFields();
  }

  function resetModalFields() {
    // Encargado
    if (elements.fields.encargadoSelect) {
      elements.fields.encargadoSelect.classList.add('hidden');
    }
    if (elements.fields.encargadoText) {
      elements.fields.encargadoText.classList.remove('hidden');
      elements.fields.encargadoText.readOnly = true;
    }

    // Barrio
    if (elements.fields.barrioSelect) {
      elements.fields.barrioSelect.classList.add('hidden');
    }
    if (elements.fields.barrio) {
      elements.fields.barrio.classList.remove('hidden');
      elements.fields.barrio.readOnly = true;
    }

    // Nombre
    elements.fields.nombre.readOnly = true;
    elements.fields.nombre.classList.add('bg-sky-50');
    elements.fields.nombre.classList.remove('bg-white', 'focus:border-sky-500', 'focus:ring-2', 'focus:ring-sky-200');

    // Botones
    elements.btnEditarDireccion.classList.add('hidden');
    elements.btnAgregarTanque.classList.add('hidden');
    elements.modalSave.classList.add('hidden');
  }

  elements.closeModal.addEventListener('click', hideModal);
  elements.modalCancel.addEventListener('click', hideModal);
  elements.modalOverlay.addEventListener('click', (e) => {
    if (e.target === elements.modalOverlay) hideModal();
  });

  // ============================================================================
  // MODAL PRINCIPAL: SUBMIT (GUARDAR EDICIÓN)
  // ============================================================================
  
  elements.modalForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!state.isEditMode) {
      hideModal();
      return;
    }

    const nombreZoo = elements.fields.nombre.value.trim();
    const direccionZoo = elements.fields.direccion.value.trim();

    let codBarrio = null;
    if (elements.fields.barrioSelect && !elements.fields.barrioSelect.classList.contains('hidden')) {
      codBarrio = elements.fields.barrioSelect.value || null;
    }

    let idUsuarios = null;
    if (elements.fields.encargadoSelect && !elements.fields.encargadoSelect.classList.contains('hidden')) {
      idUsuarios = elements.fields.encargadoSelect.value;
    } else {
      idUsuarios = elements.fields.encargadoId.value;
    }

    if (!nombreZoo || !direccionZoo) {
      alert('Por favor complete todos los campos obligatorios');
      return;
    }

    const datosActualizar = {
      cod_zoo: parseInt(elements.fields.cod.value),
      nombre_zoo: nombreZoo,
      direccion_zoo: direccionZoo,
      cod_barrio: codBarrio ? parseInt(codBarrio) : null,
      id_usuarios: parseInt(idUsuarios)
    };

    console.log('Datos a enviar:', datosActualizar);

    try {
      const response = await fetch('../controllers/controllerEditar.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datosActualizar)
      });
      
      const json = await response.json();
      console.log('Respuesta del servidor:', json);
      
      if (json.success) {
        alert(json.message || 'Zoocriadero actualizado correctamente');
        hideModal();
        location.reload();
      } else {
        alert(json.message || 'Error al actualizar el zoocriadero');
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Error al guardar los cambios: ' + error.message);
    }
  });

  // ============================================================================
// ELEMENTOS DEL DOM - SEPARADOS POR MODAL
// ============================================================================

const elementsVer = {
  modal: document.getElementById('modalVerDetalle'),
  closeBtn: document.getElementById('closeModalVer'),
  cerrarBtn: document.getElementById('btnCerrarVer'),
  nombre: document.getElementById('ver_nombre'),
  encargado: document.getElementById('ver_encargado'),
  barrio: document.getElementById('ver_barrio'),
  direccion: document.getElementById('ver_direccion'),
  tanquesList: document.getElementById('ver_tanques_list')
};

const elementsEditar = {
  modal: document.getElementById('modalEditar'),
  closeBtn: document.getElementById('closeModalEditar'),
  cerrarBtn: document.getElementById('btnCerrarEditar'),
  form: document.getElementById('modalFormEditar'),
  codZoo: document.getElementById('editar_cod_zoo'),
  nombre: document.getElementById('editar_nombre'),
  encargado: document.getElementById('editar_encargado'),
  barrio: document.getElementById('editar_barrio'),
  direccion: document.getElementById('editar_direccion'),
  btnEditarDireccion: document.getElementById('btnEditarDireccion'),
  tanquesList: document.getElementById('editar_tanques_list'),
  btnAgregarTanque: document.getElementById('btnAgregarTanque')
};


// ============================================================================
// MODAL VER DETALLE
// ============================================================================

async function abrirModalVer(codZoo) {
  try {
    const response = await fetch(`../controllers/controllerVerDetalle.php?cod_zoo=${codZoo}`);
    const data = await response.json();

    if (!data.success) {
      alert(data.message || 'Error al cargar los datos del zoocriadero');
      return;
    }

    elementsVer.nombre.value = data.zoo.nombre_zoo;
    elementsVer.encargado.value = data.zoo.encargado;
    elementsVer.barrio.value = data.zoo.nombarrio || '';
    elementsVer.direccion.value = data.zoo.direccion_zoo;

    renderTanquesVista(data.tanques || []);
    
    elementsVer.modal.classList.remove('hidden');
    elementsVer.modal.classList.add('flex');
    
  } catch (error) {
    console.error('Error:', error);
    alert('Error al cargar los datos del zoocriadero');
  }
}

function renderTanquesVista(tanques) {
  const list = elementsVer.tanquesList;
  list.innerHTML = '';

  if (tanques && tanques.length > 0) {
    tanques.forEach((t) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-sky-50 transition-colors';
      tr.innerHTML = `
        <td class="py-3 px-4 text-slate-700">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
            ${t.nomtiptan || 'N/A'}
          </div>
        </td>
        <td class="py-3 px-4 text-slate-700 font-medium">${t.nom_zootanque || 'N/A'}</td>
      `;
      list.appendChild(tr);
    });
  } else {
    list.innerHTML = `
      <tr>
        <td colspan="2" class="py-6 px-4 text-center text-slate-500">
          <div class="flex flex-col items-center gap-2">
            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <span class="text-sm">No hay tanques asociados</span>
          </div>
        </td>
      </tr>`;
  }
}

function cerrarModalVer() {
  elementsVer.modal.classList.add('hidden');
  elementsVer.modal.classList.remove('flex');
}

// Event listeners para cerrar modal Ver
elementsVer.closeBtn?.addEventListener('click', cerrarModalVer);
elementsVer.cerrarBtn?.addEventListener('click', cerrarModalVer);
elementsVer.modal?.addEventListener('click', (e) => {
  if (e.target === elementsVer.modal) {
    cerrarModalVer();
  }
});

// ============================================================================
// MODAL EDITAR
// ============================================================================

async function abrirModalEditar(codZoo) {
  try {
    // Cargar datos iniciales si no están cargados
    if (state.encargados.length === 0 || state.barrios.length === 0) {
      await inicializarDatos();
    }

    const cod = parseInt(codZoo);
    state.currentCodZoo = cod;

    const response = await fetch(`../controllers/controllerEditar.php?cod_zoo=${cod}`);
    const dataZoo = await response.json();

    if (!dataZoo.success) {
      alert(dataZoo.message || 'Error al cargar los datos del zoocriadero');
      return;
    }

    state.tanquesDelZoo = dataZoo.tanques || [];

    elementsEditar.codZoo.value = dataZoo.zoo.cod_zoo;
    elementsEditar.nombre.value = dataZoo.zoo.nombre_zoo;
    elementsEditar.direccion.value = dataZoo.zoo.direccion_zoo;

    // Cargar select de encargados
    elementsEditar.encargado.innerHTML = '<option value="">-- Seleccione --</option>';
    state.encargados.forEach(enc => {
      const option = document.createElement('option');
      option.value = enc.id_usuarios;
      option.textContent = `${enc.nombre_usu} ${enc.apellido_usu}`;
      if (enc.id_usuarios == dataZoo.zoo.id_usuarios) {
        option.selected = true;
      }
      elementsEditar.encargado.appendChild(option);
    });

    // Cargar select de barrios
    elementsEditar.barrio.innerHTML = '<option value="">-- Seleccione --</option>';
    state.barrios.forEach(barrio => {
      const option = document.createElement('option');
      option.value = barrio.cod_barrio;
      option.textContent = barrio.nombarrio;
      if (barrio.cod_barrio == dataZoo.zoo.cod_barrio) {
        option.selected = true;
      }
      elementsEditar.barrio.appendChild(option);
    });

    renderTanquesEditables(dataZoo.tanques || []);

    elementsEditar.modal.classList.remove('hidden');
    elementsEditar.modal.classList.add('flex');

  } catch (error) {
    console.error('Error al abrir modal:', error);
    alert('Error al cargar los datos del zoocriadero: ' + error.message);
  }
}

function renderTanquesEditables(tanques) {
  const list = elementsEditar.tanquesList;
  list.innerHTML = '';

  if (tanques && tanques.length > 0) {
    tanques.forEach((t) => {
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-green-50 transition-colors';
      tr.innerHTML = `
        <td class="py-3 px-4 text-slate-700">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
            ${t.nomtiptan || 'N/A'}
          </div>
        </td>
        <td class="py-3 px-4 text-slate-700 font-medium">${t.nom_zootanque || 'N/A'}</td>
        <td class="py-3 px-4 text-center">
          <button type="button" 
            class="btn-eliminar-tanque inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-full transition-all hover:scale-110" 
            data-cod-tanque="${t.cod_zootanque}"
            title="Eliminar tanque">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </td>
      `;
      list.appendChild(tr);
    });
  } else {
    list.innerHTML = `
      <tr>
        <td colspan="3" class="py-6 px-4 text-center text-slate-500">
          <div class="flex flex-col items-center gap-2">
            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <span class="text-sm">No hay tanques asociados</span>
          </div>
        </td>
      </tr>`;
  }
}

function cerrarModalEditar() {
  elementsEditar.modal.classList.add('hidden');
  elementsEditar.modal.classList.remove('flex');
}

// Event listeners para cerrar modal Editar
elementsEditar.closeBtn?.addEventListener('click', cerrarModalEditar);
elementsEditar.cerrarBtn?.addEventListener('click', cerrarModalEditar);
elementsEditar.modal?.addEventListener('click', (e) => {
  if (e.target === elementsEditar.modal) {
    cerrarModalEditar();
  }
});

// ============================================================================
// GESTIÓN DE TANQUES - ELIMINAR
// ============================================================================

elementsEditar.tanquesList?.addEventListener('click', async (e) => {
  const btn = e.target.closest('.btn-eliminar-tanque');
  if (!btn) return;

  const codTanque = parseInt(btn.dataset.codTanque);
  
  if (!confirm('¿Desea inactivar este tanque?')) return;

  try {
    const response = await fetch('../controllers/controllerListar.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ 
        action: 'eliminarTanque',
        cod_zootanque: codTanque
      })
    });

    const result = await response.json();

    if (result.success) {
      alert('Tanque inactivado correctamente');
      abrirModalEditar(state.currentCodZoo);
    } else {
      alert(result.message || 'Error al inactivar el tanque');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('Error al inactivar el tanque: ' + error.message);
  }
});

// ============================================================================
// MODAL AGREGAR TANQUE
// ============================================================================

const modalAgregarTanque = document.getElementById('modalAgregarTanque');
const selectTipoTanque = document.getElementById('selectTipoTanque');
const inputNombreTanque = document.getElementById('inputNombreTanque');
const btnGuardarTanque = document.getElementById('btnGuardarTanque');
const btnCerrarModalTanque = document.getElementById('closeModalAgregarTanque');
const btnCancelarTanque = document.getElementById('btnCancelarTanque');

function cerrarModalAgregarTanque() {
  if (modalAgregarTanque) {
    modalAgregarTanque.classList.add('hidden');
    modalAgregarTanque.classList.remove('flex');
  }
}

elementsEditar.btnAgregarTanque?.addEventListener('click', () => {
  if (!modalAgregarTanque) {
    console.error('Modal de agregar tanque no encontrado en el DOM');
    alert('Error: El modal de agregar tanque no está disponible');
    return;
  }

  selectTipoTanque.innerHTML = '<option value="">-- Seleccione tipo --</option>';
  
  state.tiposTanque.forEach(tipo => {
    const option = document.createElement('option');
    option.value = tipo.cod_tipotanque;
    option.textContent = tipo.nomtiptan;
    selectTipoTanque.appendChild(option);
  });

  inputNombreTanque.value = '';
  modalAgregarTanque.classList.remove('hidden');
  modalAgregarTanque.classList.add('flex');
});

btnCerrarModalTanque?.addEventListener('click', cerrarModalAgregarTanque);
btnCancelarTanque?.addEventListener('click', cerrarModalAgregarTanque);

btnGuardarTanque?.addEventListener('click', async () => {
  const codTipoTanque = selectTipoTanque.value;
  const nombreTanque = inputNombreTanque.value.trim();

  if (!codTipoTanque || !nombreTanque) {
    alert('Por favor complete todos los campos');
    return;
  }

  if (!state.currentCodZoo) {
    alert('Error: No se ha seleccionado un zoocriadero');
    return;
  }

  try {
    const response = await fetch('../controllers/controllerListar.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        action: 'agregarTanque',
        cod_zoo: state.currentCodZoo,
        cod_tipotanque: parseInt(codTipoTanque),
        nom_zootanque: nombreTanque
      })
    });

    const result = await response.json();

    if (result.success) {
      alert('Tanque agregado correctamente');
      cerrarModalAgregarTanque();
      abrirModalEditar(state.currentCodZoo);
    } else {
      alert(result.message || 'Error al agregar el tanque');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('Error al agregar el tanque: ' + error.message);
  }
});

modalAgregarTanque?.addEventListener('click', (e) => {
  if (e.target === modalAgregarTanque) {
    cerrarModalAgregarTanque();
  }
});

// ============================================================================
// GUARDAR CAMBIOS DEL ZOOCRIADERO
// ============================================================================

elementsEditar.form?.addEventListener('submit', async (e) => {
  e.preventDefault();

  const formData = {
    action: 'actualizarZoocriadero',
    cod_zoo: state.currentCodZoo,
    nombre_zoo: elementsEditar.nombre.value.trim(),
    id_usuarios: elementsEditar.encargado.value,
    cod_barrio: elementsEditar.barrio.value,
    direccion_zoo: elementsEditar.direccion.value.trim()
  };

  if (!formData.nombre_zoo || !formData.id_usuarios || !formData.cod_barrio || !formData.direccion_zoo) {
    alert('Por favor complete todos los campos');
    return;
  }

  try {
    const response = await fetch('../controllers/controllerListar.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formData)
    });

    const result = await response.json();

    if (result.success) {
      alert('Zoocriadero actualizado correctamente');
      cerrarModalEditar();
      // Aquí deberías recargar tu tabla principal
      if (typeof cargarZoocriaderos === 'function') {
        cargarZoocriaderos();
      }
    } else {
      alert(result.message || 'Error al actualizar el zoocriadero');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('Error al actualizar el zoocriadero: ' + error.message);
  }
});

// ============================================================================
// INICIALIZAR DATOS (encargados, barrios, tipos de tanque)
// ============================================================================

async function inicializarDatos() {
  try {
    const response = await fetch('../controllers/controllerListar.php?action=obtenerDatos');
    const data = await response.json();
    
    if (data.success) {
      state.encargados = data.encargados || [];
      state.barrios = data.barrios || [];
      state.tiposTanque = data.tiposTanque || [];
    }
  } catch (error) {
    console.error('Error al inicializar datos:', error);
  }
}

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', () => {
  inicializarDatos();
});

// Exponer funciones globalmente para poder llamarlas desde HTML
window.abrirModalVer = abrirModalVer;
window.abrirModalEditar = abrirModalEditar;
  // ============================================================================
  // MODAL DIRECCIÓN
  // ============================================================================
  
  function actualizarVistaPrevia() {
    const tipo = elements.tipoVia.value;
    const numero = elements.numeroVia.value.trim();
    const suf = elements.sufijo.value.trim();
    const dist = elements.distancia.value.trim();

    let direccion = [];
    if (tipo) direccion.push(tipo);
    if (numero) direccion.push(numero);
    if (suf) direccion.push('#' + suf);
    if (dist) direccion.push(dist);

    elements.vistaPrevia.textContent = direccion.length > 0 ? direccion.join(' ') : '-';
  }

  [elements.tipoVia, elements.numeroVia, elements.sufijo, elements.distancia].forEach(input => {
    input.addEventListener('input', actualizarVistaPrevia);
    input.addEventListener('change', actualizarVistaPrevia);
  });

  elements.btnEditarDireccion.addEventListener('click', () => {
    const dirActual = elements.fields.direccion.value.trim();
    if (dirActual && dirActual !== '-') {
      const partes = dirActual.split(' ');
      if (partes[0]) elements.tipoVia.value = partes[0];
      if (partes[1]) elements.numeroVia.value = partes[1];
    }

    actualizarVistaPrevia();
    elements.modalDireccion.classList.remove('hidden');
    elements.modalDireccion.classList.add('flex');
  });

  elements.btnCerrarModalDir.addEventListener('click', () => {
    elements.modalDireccion.classList.add('hidden');
    elements.modalDireccion.classList.remove('flex');
  });

  elements.btnBorrarModal.addEventListener('click', () => {
    elements.tipoVia.value = '';
    elements.numeroVia.value = '';
    elements.sufijo.value = '';
    elements.distancia.value = '';
    actualizarVistaPrevia();
  });

  elements.btnBorrarUltimoModal.addEventListener('click', () => {
    const actual = elements.vistaPrevia.textContent;
    if (actual && actual !== '-') {
      const partes = actual.trim().split(' ');
      partes.pop();

      if (partes.length > 0) {
        if (partes.length >= 1) elements.tipoVia.value = partes[0];
        if (partes.length >= 2) elements.numeroVia.value = partes[1];
        if (partes.length >= 3) elements.sufijo.value = partes[2].replace('#', '');
        if (partes.length >= 4) elements.distancia.value = partes[3];
      } else {
        elements.tipoVia.value = '';
        elements.numeroVia.value = '';
        elements.sufijo.value = '';
        elements.distancia.value = '';
      }

      actualizarVistaPrevia();
    }
  });

  elements.btnAplicarDireccion.addEventListener('click', () => {
    const direccionGenerada = elements.vistaPrevia.textContent;
    elements.fields.direccion.value = direccionGenerada;
    elements.modalDireccion.classList.add('hidden');
    elements.modalDireccion.classList.remove('flex');
  });

  elements.modalDireccion.addEventListener('click', (e) => {
    if (e.target === elements.modalDireccion) {
      elements.modalDireccion.classList.add('hidden');
      elements.modalDireccion.classList.remove('flex');
    }
  });

});