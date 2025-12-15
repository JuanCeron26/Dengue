document.addEventListener('DOMContentLoaded', async () => {
  // ============================================================================
  // ELEMENTOS DEL DOM
  // ============================================================================
  
  const elements = {
    tbody: document.getElementById('tbody'),
    filterForm: document.getElementById('filterForm'),
    btnApply: document.getElementById('btnApplyFilters'),
    btnClear: document.getElementById('btnClearFilters'),
    currentPage: document.getElementById('currentPage'),
    totalPages: document.getElementById('totalPages'),
    prevBtn: document.getElementById('prevPage'),
    nextBtn: document.getElementById('nextPage'),
    
    // Modal VER
    modalVer: document.getElementById('modalVerDetalle'),
    closeModalVer: document.getElementById('closeModalVer'),
    btnCerrarVer: document.getElementById('btnCerrarVer'),
    verNombre: document.getElementById('ver_nombre'),
    verEncargado: document.getElementById('ver_encargado'),
    verBarrio: document.getElementById('ver_barrio'),
    verDireccion: document.getElementById('ver_direccion'),
    verTanquesList: document.getElementById('ver_tanques_list'),
    
    // Modal EDITAR
    modalEditar: document.getElementById('modalEditar'),
    closeModalEditar: document.getElementById('closeModalEditar'),
    btnCerrarEditar: document.getElementById('btnCerrarEditar'),
    modalFormEditar: document.getElementById('modalFormEditar'),
    editarCodZoo: document.getElementById('editar_cod_zoo'),
    editarNombre: document.getElementById('editar_nombre'),
    editarEncargado: document.getElementById('editar_encargado'),
    editarBarrio: document.getElementById('editar_barrio'),
    editarDireccion: document.getElementById('editar_direccion'),
    editarTanquesList: document.getElementById('editar_tanques_list'),
    btnEditarDireccion: document.getElementById('btnEditarDireccion'),
    btnAgregarTanque: document.getElementById('btnAgregarTanque'),
    
    // Modal Dirección
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
    
    // Modal Agregar Tanque
    modalAgregarTanque: document.getElementById('modalAgregarTanque'),
    btnCerrarModalTanque: document.getElementById('btnCerrarModalTanque'),
    btnGuardarTanque: document.getElementById('btnGuardarTanque'),
    selectTipoTanque: document.getElementById('selectTipoTanque'),
    inputNombreTanque: document.getElementById('inputNombreTanque')
  };

  // ============================================================================
  // ESTADO GLOBAL
  // ============================================================================
  
  const PAGE_SIZE = 8;
  const initialRows = Array.from(elements.tbody.querySelectorAll('tr[data-cod]'));
  
  const state = {
    filters: { filterName: '', filterEncargado: '', filterTipo: '', filterDireccion: '' },
    sortKey: null,
    sortDir: 1,
    page: 1,
    encargados: [],
    barrios: [],
    tiposTanque: [],
    currentCodZoo: null
  };

  // ============================================================================
  // CARGA DE DATOS INICIALES
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

  async function inicializarDatos() {
    state.encargados = await fetchData('getEncargados');
    state.barrios = await fetchData('getBarrios');
    state.tiposTanque = await fetchData('getTiposTanque');
    console.log('Datos inicializados:', { 
      encargados: state.encargados.length, 
      barrios: state.barrios.length, 
      tiposTanque: state.tiposTanque.length 
    });
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
      state.sortDir = (state.sortKey === key) ? -state.sortDir : 1;
      state.sortKey = key;
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
      tr.innerHTML = '<td colspan="5" class="text-center py-4 text-slate-500">No hay registros disponibles.</td>';
      elements.tbody.appendChild(tr);
    } else {
      visible.forEach(origTr => elements.tbody.appendChild(origTr.cloneNode(true)));
    }

    elements.currentPage.textContent = state.page;
    elements.totalPages.textContent = totalPages;
  }

  render();

  // ============================================================================
  // ACCIONES DE LA TABLA
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
  // MODAL VER DETALLE
  // ============================================================================
  
  function showModalVer() {
    elements.modalVer.classList.remove('hidden');
    elements.modalVer.classList.add('flex');
  }

  function hideModalVer() {
    elements.modalVer.classList.add('hidden');
    elements.modalVer.classList.remove('flex');
  }

  elements.closeModalVer.addEventListener('click', hideModalVer);
  elements.btnCerrarVer.addEventListener('click', hideModalVer);
  elements.modalVer.addEventListener('click', (e) => {
    if (e.target === elements.modalVer) hideModalVer();
  });

  async function abrirModalVer(codZoo) {
    try {
      const response = await fetch(`../controllers/controllerVerDetalle.php?cod_zoo=${codZoo}`);
      const data = await response.json();

      if (!data.success) {
        alert(data.message || 'Error al cargar los datos del zoocriadero');
        return;
      }

      elements.verNombre.value = data.zoo.nombre_zoo;
      elements.verEncargado.value = data.zoo.encargado;
      elements.verBarrio.value = data.zoo.nombarrio || '';
      elements.verDireccion.value = data.zoo.direccion_zoo;

      renderTanquesVista(data.tanques || []);
      showModalVer();
      
    } catch (error) {
      console.error('Error:', error);
      alert('Error al cargar los datos del zoocriadero');
    }
  }

  function renderTanquesVista(tanques) {
    const list = elements.verTanquesList;
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

  // ============================================================================
  // MODAL EDITAR
  // ============================================================================
  
  function showModalEditar() {
    elements.modalEditar.classList.remove('hidden');
    elements.modalEditar.classList.add('flex');
  }

  function hideModalEditar() {
    elements.modalEditar.classList.add('hidden');
    elements.modalEditar.classList.remove('flex');
    state.currentCodZoo = null;
  }

  elements.closeModalEditar.addEventListener('click', hideModalEditar);
  elements.btnCerrarEditar.addEventListener('click', hideModalEditar);
  elements.modalEditar.addEventListener('click', (e) => {
    if (e.target === elements.modalEditar) hideModalEditar();
  });

  async function abrirModalEditar(codZoo) {
    try {
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

      console.log('Datos del zoo:', dataZoo);
      console.log('State disponible:', { encargados: state.encargados, barrios: state.barrios, tiposTanque: state.tiposTanque });

      elements.editarCodZoo.value = dataZoo.zoo.cod_zoo;
      elements.editarNombre.value = dataZoo.zoo.nombre_zoo;
      elements.editarDireccion.value = dataZoo.zoo.direccion_zoo;

      // Llenar select de encargados
      elements.editarEncargado.innerHTML = '<option value="">-- Seleccione --</option>';
      state.encargados.forEach(enc => {
        const option = document.createElement('option');
        option.value = enc.id_usuarios;
        option.textContent = `${enc.nombre_usu} ${enc.apellido_usu}`;
        if (enc.id_usuarios == dataZoo.zoo.id_usuarios) {
          option.selected = true;
        }
        elements.editarEncargado.appendChild(option);
      });

      // Llenar select de barrios
      elements.editarBarrio.innerHTML = '<option value="">-- Seleccione --</option>';
      state.barrios.forEach(barrio => {
        const option = document.createElement('option');
        option.value = barrio.cod_barrio;
        option.textContent = barrio.nombarrio;
        if (barrio.cod_barrio == dataZoo.zoo.cod_barrio) {
          option.selected = true;
        }
        elements.editarBarrio.appendChild(option);
      });

      renderTanquesEditables(dataZoo.tanques || []);
      showModalEditar();

    } catch (error) {
      console.error('Error al abrir modal:', error);
      alert('Error al cargar los datos del zoocriadero: ' + error.message);
    }
  }

  function renderTanquesEditables(tanques) {
    const list = elements.editarTanquesList;
    list.innerHTML = '';

    if (tanques && tanques.length > 0) {
      tanques.forEach((t) => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-green-50 transition-colors';
        tr.dataset.codTanque = t.cod_zootanque;
        tr.dataset.codTipotanque = t.cod_tipotanque;
        tr.dataset.nomTanque = t.nom_zootanque;
        tr.dataset.isEditing = 'false';
        
        tr.innerHTML = `
          <td class="py-3 px-4 text-slate-700">
            <div class="tipo-tanque-view flex items-center gap-2">
              <span class="w-2 h-2 bg-green-500 rounded-full"></span>
              <span>${t.nomtiptan || 'N/A'}</span>
            </div>
            <select class="tipo-tanque-edit hidden w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:border-green-500">
              ${state.tiposTanque.map(tipo => 
                `<option value="${tipo.cod_tipotanque}" ${tipo.cod_tipotanque == t.cod_tipotanque ? 'selected' : ''}>
                  ${tipo.nomtiptan}
                </option>`
              ).join('')}
            </select>
          </td>
          <td class="py-3 px-4 text-slate-700">
            <span class="nombre-tanque-view font-medium">${t.nom_zootanque || 'N/A'}</span>
            <input type="text" 
              class="nombre-tanque-edit hidden w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:border-green-500" 
              value="${t.nom_zootanque || ''}"
            />
          </td>
          <td class="py-3 px-4 text-center">
            <div class="flex items-center justify-center gap-2">
              <!-- Botones modo vista -->
              <button type="button" 
                class="btn-editar-tanque inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-full transition-all hover:scale-110" 
                title="Editar tanque">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              </button>
              <button type="button" 
                class="btn-eliminar-tanque inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-full transition-all hover:scale-110" 
                title="Inactivar tanque">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
              
              <!-- Botones modo edición (ocultos por defecto) -->
              <button type="button" 
                class="btn-guardar-tanque hidden inline-flex items-center justify-center w-8 h-8 text-green-600 hover:bg-green-50 rounded-full transition-all hover:scale-110" 
                title="Guardar cambios">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </button>
              <button type="button" 
                class="btn-cancelar-tanque hidden inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-full transition-all hover:scale-110" 
                title="Cancelar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
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

  // Submit del formulario de editar
  elements.modalFormEditar.addEventListener('submit', async (e) => {
    e.preventDefault();

    const nombreZoo = elements.editarNombre.value.trim();
    const direccionZoo = elements.editarDireccion.value.trim();
    const codBarrio = elements.editarBarrio.value || null;
    const idUsuarios = elements.editarEncargado.value;

    if (!nombreZoo || !direccionZoo || !idUsuarios) {
      alert('Por favor complete todos los campos obligatorios');
      return;
    }

    const datosActualizar = {
      cod_zoo: parseInt(elements.editarCodZoo.value),
      nombre_zoo: nombreZoo,
      direccion_zoo: direccionZoo,
      cod_barrio: codBarrio ? parseInt(codBarrio) : null,
      id_usuarios: parseInt(idUsuarios)
    };

    try {
      const response = await fetch('../controllers/controllerEditar.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datosActualizar)
      });
      
      const json = await response.json();
      
      if (json.success) {
        alert(json.message || 'Zoocriadero actualizado correctamente');
        hideModalEditar();
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
  // GESTIÓN DE TANQUES (EDITAR, INACTIVAR)
  // ============================================================================
  
  elements.editarTanquesList.addEventListener('click', async (e) => {
    const tr = e.target.closest('tr');
    if (!tr || !tr.dataset.codTanque) return;

    if (e.target.closest('.btn-editar-tanque')) {
      activarEdicionTanque(tr);
      return;
    }

    if (e.target.closest('.btn-guardar-tanque')) {
      await guardarEdicionTanque(tr);
      return;
    }

    if (e.target.closest('.btn-cancelar-tanque')) {
      cancelarEdicionTanque(tr);
      return;
    }

    if (e.target.closest('.btn-eliminar-tanque')) {
      await inactivarTanque(tr);
      return;
    }
  });

  function activarEdicionTanque(tr) {
    tr.dataset.isEditing = 'true';
    tr.querySelector('.tipo-tanque-view').classList.add('hidden');
    tr.querySelector('.tipo-tanque-edit').classList.remove('hidden');
    tr.querySelector('.nombre-tanque-view').classList.add('hidden');
    tr.querySelector('.nombre-tanque-edit').classList.remove('hidden');
    tr.querySelector('.btn-editar-tanque').classList.add('hidden');
    tr.querySelector('.btn-eliminar-tanque').classList.add('hidden');
    tr.querySelector('.btn-guardar-tanque').classList.remove('hidden');
    tr.querySelector('.btn-cancelar-tanque').classList.remove('hidden');
  }

  function cancelarEdicionTanque(tr) {
    tr.dataset.isEditing = 'false';
    const selectTipo = tr.querySelector('.tipo-tanque-edit');
    const inputNombre = tr.querySelector('.nombre-tanque-edit');
    selectTipo.value = tr.dataset.codTipotanque;
    inputNombre.value = tr.dataset.nomTanque;
    tr.querySelector('.tipo-tanque-view').classList.remove('hidden');
    tr.querySelector('.tipo-tanque-edit').classList.add('hidden');
    tr.querySelector('.nombre-tanque-view').classList.remove('hidden');
    tr.querySelector('.nombre-tanque-edit').classList.add('hidden');
    tr.querySelector('.btn-editar-tanque').classList.remove('hidden');
    tr.querySelector('.btn-eliminar-tanque').classList.remove('hidden');
    tr.querySelector('.btn-guardar-tanque').classList.add('hidden');
    tr.querySelector('.btn-cancelar-tanque').classList.add('hidden');
  }

  async function guardarEdicionTanque(tr) {
    const codTanque = parseInt(tr.dataset.codTanque);
    const codTipoTanque = parseInt(tr.querySelector('.tipo-tanque-edit').value);
    const nombreTanque = tr.querySelector('.nombre-tanque-edit').value.trim();

    if (!nombreTanque) {
      alert('El nombre del tanque no puede estar vacío');
      return;
    }

    try {
      const response = await fetch('../controllers/controllerListar.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
          action: 'actualizarTanque',
          cod_zootanque: codTanque,
          cod_tipotanque: codTipoTanque,
          nom_zootanque: nombreTanque
        })
      });

      const result = await response.json();

      if (result.success) {
        alert('Tanque actualizado correctamente');
        abrirModalEditar(state.currentCodZoo);
      } else {
        alert(result.message || 'Error al actualizar el tanque');
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Error al actualizar el tanque: ' + error.message);
    }
  }

  async function inactivarTanque(tr) {
    const codTanque = parseInt(tr.dataset.codTanque);
    const nombreTanque = tr.dataset.nomTanque;
    
    if (!confirm(`¿Desea inactivar el tanque "${nombreTanque}"?`)) return;

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
  }

  // ============================================================================
  // MODAL AGREGAR TANQUE
  // ============================================================================
  
  function cerrarModalAgregarTanque() {
    if (elements.modalAgregarTanque) {
      elements.modalAgregarTanque.classList.add('hidden');
      elements.modalAgregarTanque.classList.remove('flex');
    }
  }

  if (elements.btnAgregarTanque) {
    elements.btnAgregarTanque.addEventListener('click', () => {
      if (!elements.modalAgregarTanque) {
        console.error('Modal de agregar tanque no encontrado en el DOM');
        alert('Error: El modal de agregar tanque no está disponible');
        return;
      }

      console.log('Abriendo modal agregar tanque. Tipos disponibles:', state.tiposTanque);

      elements.selectTipoTanque.innerHTML = '<option value="">-- Seleccione tipo --</option>';
      
      state.tiposTanque.forEach(tipo => {
        const option = document.createElement('option');
        option.value = tipo.cod_tipotanque;
        option.textContent = tipo.nomtiptan;
        elements.selectTipoTanque.appendChild(option);
      });

      elements.inputNombreTanque.value = '';
      elements.modalAgregarTanque.classList.remove('hidden');
      elements.modalAgregarTanque.classList.add('flex');
    });
  }

  if (elements.btnCerrarModalTanque) {
    elements.btnCerrarModalTanque.addEventListener('click', cerrarModalAgregarTanque);
  }

  const btnCancelarTanque = document.getElementById('btnCancelarTanque');
  if (btnCancelarTanque) {
    btnCancelarTanque.addEventListener('click', cerrarModalAgregarTanque);
  }

  if (elements.btnGuardarTanque) {
    elements.btnGuardarTanque.addEventListener('click', async () => {
      const codTipoTanque = elements.selectTipoTanque.value;
      const nombreTanque = elements.inputNombreTanque.value.trim();

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
  }

  if (elements.modalAgregarTanque) {
    elements.modalAgregarTanque.addEventListener('click', (e) => {
      if (e.target === elements.modalAgregarTanque) {
        cerrarModalAgregarTanque();
      }
    });
  }

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
    if (input) {
      input.addEventListener('input', actualizarVistaPrevia);
      input.addEventListener('change', actualizarVistaPrevia);
    }
  });

  if (elements.btnEditarDireccion) {
    elements.btnEditarDireccion.addEventListener('click', () => {
      const dirActual = elements.editarDireccion.value.trim();
      if (dirActual && dirActual !== '-') {
        const partes = dirActual.split(' ');
        if (partes[0]) elements.tipoVia.value = partes[0];
        if (partes[1]) elements.numeroVia.value = partes[1];
      }

      actualizarVistaPrevia();
      elements.modalDireccion.classList.remove('hidden');
      elements.modalDireccion.classList.add('flex');
    });
  }

  if (elements.btnCerrarModalDir) {
    elements.btnCerrarModalDir.addEventListener('click', () => {
      elements.modalDireccion.classList.add('hidden');
      elements.modalDireccion.classList.remove('flex');
    });
  }

  if (elements.btnBorrarModal) {
    elements.btnBorrarModal.addEventListener('click', () => {
      elements.tipoVia.value = '';
      elements.numeroVia.value = '';
      elements.sufijo.value = '';
      elements.distancia.value = '';
      actualizarVistaPrevia();
    });
  }

  if (elements.btnBorrarUltimoModal) {
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
  }

  if (elements.btnAplicarDireccion) {
    elements.btnAplicarDireccion.addEventListener('click', () => {
      const direccionGenerada = elements.vistaPrevia.textContent;
      elements.editarDireccion.value = direccionGenerada;
      elements.modalDireccion.classList.add('hidden');
      elements.modalDireccion.classList.remove('flex');
    });
  }

  if (elements.modalDireccion) {
    elements.modalDireccion.addEventListener('click', (e) => {
      if (e.target === elements.modalDireccion) {
        elements.modalDireccion.classList.add('hidden');
        elements.modalDireccion.classList.remove('flex');
      }
    });
  }

});