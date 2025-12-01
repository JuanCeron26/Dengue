document.addEventListener('DOMContentLoaded', () => {
  const tbody = document.getElementById('tbody');
  const initialRows = Array.from(tbody.querySelectorAll('tr[data-cod]'));
  const filterForm = document.getElementById('filterForm');
  const btnApply = document.getElementById('btnApplyFilters');
  const btnClear = document.getElementById('btnClearFilters');
  const currentPageEl = document.getElementById('currentPage');
  const totalPagesEl = document.getElementById('totalPages');
  const prevBtn = document.getElementById('prevPage');
  const nextBtn = document.getElementById('nextPage');
  const pageSize = 8;

  // Modal elements
  const modalOverlay = document.getElementById('modalOverlay');
  const modal = modalOverlay.querySelector('.bg-white');
  const modalTitle = document.getElementById('modalTitle');
  const modalForm = document.getElementById('modalForm');
  const modalCancel = document.getElementById('modalCancel');
  const closeModalBtn = document.getElementById('closeModal');
  const modalSave = document.getElementById('modalSave');
  const btnEditarDireccion = document.getElementById('btnEditarDireccion');

  const modalFields = {
    cod: document.getElementById('modal_cod_zoo'),
    nombre: document.getElementById('modal_nombre'),
    encargadoText: document.getElementById('modal_encargado'),
    encargadoSelect: document.getElementById('modal_encargado_select'),
    encargadoId: document.getElementById('modal_encargado_id'),
    barrio: document.getElementById('modal_barrio'),
    barrioSelect: document.getElementById('modal_barrio_select'),
    direccion: document.getElementById('modal_direccion'),
    tanquesList: document.getElementById('modal_tanques_list')
  };

  // Modal Dirección
  const modalDireccion = document.getElementById('modalDireccion');
  const btnCerrarModal = document.getElementById('btnCerrarModal');
  const tipoVia = document.getElementById('tipoVia');
  const numeroVia = document.getElementById('numeroVia');
  const sufijo = document.getElementById('sufijo');
  const distancia = document.getElementById('distancia');
  const vistaPrevia = document.getElementById('vistaPrevia');
  const btnBorrarModal = document.getElementById('btnBorrarModal');
  const btnBorrarUltimoModal = document.getElementById('btnBorrarUltimoModal');
  const btnAplicarDireccion = document.getElementById('btnAplicarDireccion');

  // Estado
  let state = {
    filters: {
      filterName: '',
      filterEncargado: '',
      filterTipo: '',
      filterDireccion: ''
    },
    sortKey: null,
    sortDir: 1,
    page: 1,
    isEditMode: false
  };

  /* ============================
        FILTROS
  ============================ */
  function readFiltersFromForm() {
    state.filters.filterName = document.getElementById('filterName').value.trim();
    state.filters.filterEncargado = document.getElementById('filterEncargado').value.trim();
    state.filters.filterTipo = document.getElementById('filterTipo').value.trim();
    state.filters.filterDireccion = document.getElementById('filterDireccion').value.trim().toLowerCase();
    state.page = 1;
  }

  function clearFilters() {
    filterForm.reset();
    state.filters = { filterName: '', filterEncargado: '', filterTipo: '', filterDireccion: '' };
    state.page = 1;
    render();
  }

  btnApply.addEventListener('click', (e) => {
    e.preventDefault();
    readFiltersFromForm();
    render();
  });

  btnClear.addEventListener('click', (e) => {
    e.preventDefault();
    clearFilters();
  });

  /* ============================
        ORDENAMIENTO
  ============================ */
  document.querySelectorAll('#tableZoos thead th[data-sort-key]').forEach(th => {
    th.addEventListener('click', () => {
      const key = th.getAttribute('data-sort-key');
      if (state.sortKey === key) {
        state.sortDir = -state.sortDir;
      } else {
        state.sortKey = key;
        state.sortDir = 1;
      }
      state.page = 1;
      render();
    });
  });

  /* ============================
        PAGINACIÓN
  ============================ */
  prevBtn.addEventListener('click', () => {
    if (state.page > 1) {
      state.page--;
      render();
    }
  });

  nextBtn.addEventListener('click', () => {
    const total = Math.max(1, Math.ceil(getFilteredRows().length / pageSize));
    if (state.page < total) {
      state.page++;
      render();
    }
  });

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

  function sortRows(rows) {
    if (!state.sortKey) return rows;
    const mapKey = {
      'index': (tr, i) => i,
      'nombre': tr => (tr.dataset.nombre || '').toLowerCase(),
      'encargado': tr => (tr.dataset.encargado || '').toLowerCase(),
      'direccion': tr => (tr.dataset.direccion || '').toLowerCase(),
      'tipo': tr => (tr.dataset.tipo || '').toLowerCase()
    };
    const getter = mapKey[state.sortKey] || (tr => tr.textContent.toLowerCase());
    return rows.slice().sort((a, b) => {
      const A = getter(a);
      const B = getter(b);
      if (A < B) return -1 * state.sortDir;
      if (A > B) return 1 * state.sortDir;
      return 0;
    });
  }

  /* ============================
        RENDER PRINCIPAL
  ============================ */
  function render() {
    const filtered = getFilteredRows();
    const sorted = sortRows(filtered);
    const totalPages = Math.max(1, Math.ceil(sorted.length / pageSize));

    if (state.page > totalPages) state.page = totalPages;

    const start = (state.page - 1) * pageSize;
    const visible = sorted.slice(start, start + pageSize);

    tbody.innerHTML = '';
    if (visible.length === 0) {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td colspan="5" class="text-center py-4 text-slate-500">
          No hay registros disponibles.
        </td>`;
      tbody.appendChild(tr);
    } else {
      visible.forEach(origTr => tbody.appendChild(origTr.cloneNode(true)));
    }

    currentPageEl.textContent = state.page;
    totalPagesEl.textContent = totalPages;
  }

  render();

  /* ============================
        EVENTOS DE ACCIÓN
  ============================ */
  document.getElementById('tableZoos').addEventListener('click', async (e) => {
    const btn = e.target.closest('[data-action]');
    if (!btn) return;

    const tr = btn.closest('tr');
    const action = btn.dataset.action;
    const d = tr.dataset;

    // --- VIEW ---
    if (action === 'view') {
      abrirModalVer(d.cod);
      return;
    }

    // --- EDITAR ---
    if (action === 'edit') {
      // Redirigir a la página de editar con el código del zoo
      // Si tienes una página editar.php separada, usa esto:
      // window.location.href = `editar.php?cod_zoo=${encodeURIComponent(d.cod)}`;
      
      // O si prefieres abrir un modal de edición en la misma página:
      abrirModalEditar(d.cod);
      return;
    }

    // DELETE/ANULAR
    if (action === 'delete') {
      if (!confirm('¿Estás seguro de anular este registro?')) return;

      // Llamar al controllerAnular.php
      fetch('../controllers/controllerAnular.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ cod_zoo: parseInt(d.cod) })
      })
      .then(r => r.json())
      .then(json => {
        if (json.success) {
          alert(json.message || 'Zoocriadero anulado correctamente');
          location.reload();
        } else {
          alert(json.message || 'Error al anular el zoocriadero');
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        alert('Error al anular el zoocriadero');
      });

      return;
    }

    // EXPORT
    if (action === 'export') {
      window.location.href = `exportar.php?cod_zoo=${encodeURIComponent(d.cod)}`;
      return;
    }
  });

  /* ============================
        MODAL CONTROL
  ============================ */
  function showModal() {
    modalOverlay.classList.remove('hidden');
    modalOverlay.classList.add('flex');
  }

  function hideModal() {
    modalOverlay.classList.add('hidden');
    modalOverlay.classList.remove('flex');
    state.isEditMode = false;
    
    // Resetear campos a readonly
    modalFields.nombre.readOnly = true;
    modalFields.nombre.classList.add('bg-sky-50');
    modalFields.nombre.classList.remove('bg-white', 'focus:border-sky-500', 'focus:ring-2', 'focus:ring-sky-200');
    
    modalFields.barrio.readOnly = true;
    modalFields.barrio.classList.add('bg-sky-50');
    modalFields.barrio.classList.remove('bg-white', 'focus:border-sky-500', 'focus:ring-2', 'focus:ring-sky-200');
    
    btnEditarDireccion.classList.add('hidden');
    modalSave.classList.add('hidden');
  }

  closeModalBtn.addEventListener('click', hideModal);
  modalCancel.addEventListener('click', hideModal);

  modalOverlay.addEventListener('click', (e) => {
    if (e.target === modalOverlay) hideModal();
  });

  modalForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    if (!state.isEditMode) {
      hideModal();
      return;
    }

    // Preparar datos para enviar
    const datosActualizar = {
      cod_zoo: modalFields.cod.value,
      nombre_zoo: modalFields.nombre.value.trim(),
      direccion_zoo: modalFields.direccion.value.trim(),
      cod_barrio: modalFields.barrio.value || null,
      id_usuarios: modalFields.encargadoId.value
    };

    // Validaciones básicas
    if (!datosActualizar.nombre_zoo || !datosActualizar.direccion_zoo) {
      alert('Por favor complete todos los campos obligatorios');
      return;
    }

    // Enviar al controlador
    fetch('../controllers/controllerEditar.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(datosActualizar)
    })
    .then(r => r.json())
    .then(json => {
      if (json.success) {
        alert(json.message || 'Zoocriadero actualizado correctamente');
        hideModal();
        location.reload();
      } else {
        alert(json.message || 'Error al actualizar el zoocriadero');
      }
    })
    .catch((error) => {
      console.error('Error:', error);
      alert('Error al guardar los cambios');
    });
  });

  /* ============================
      MODAL VER DETALLE
  ============================ */
  window.abrirModalVer = function (codZoo) {
    fetch(`../controllers/controllerVerDetalle.php?cod_zoo=${codZoo}`)
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          state.isEditMode = false;
          
          // Datos principales
          modalFields.cod.value = data.zoo.cod_zoo;
          modalFields.nombre.value = data.zoo.nombre_zoo;
          modalFields.encargadoText.value = data.zoo.encargado;
          modalFields.encargadoId.value = data.zoo.id_usuarios;
          modalFields.barrio.value = data.zoo.nombarrio || '';
          modalFields.direccion.value = data.zoo.direccion_zoo;

          modalTitle.textContent = 'Ver Zoocriadero';

          // Tabla tanques
          const list = modalFields.tanquesList;
          list.innerHTML = '';

          if (data.tanques && data.tanques.length > 0) {
            data.tanques.forEach(t => {
              list.innerHTML += `
                <tr class="hover:bg-sky-100">
                  <td class="py-2 px-3">${t.nomtiptan || 'N/A'}</td>
                  <td class="py-2 px-3">${t.nom_zootanque || 'N/A'}</td>
                </tr>`;
            });
          } else {
            list.innerHTML = `
              <tr>
                <td colspan="2" class="py-3 px-3 text-center text-slate-500">
                  No hay tanques asociados
                </td>
              </tr>`;
          }

          // Asegurar campos readonly
          modalFields.nombre.readOnly = true;
          modalFields.barrio.readOnly = true;
          btnEditarDireccion.classList.add('hidden');
          modalSave.classList.add('hidden');

          // Mostrar modal
          showModal();
        } else {
          alert(data.message || 'Error al cargar los datos del zoocriadero');
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        alert('Error al cargar los datos del zoocriadero');
      });
  };

  /* ============================
      MODAL EDITAR
  ============================ */
  window.abrirModalEditar = function (codZoo) {
    fetch(`../controllers/controllerEditar.php?cod_zoo=${codZoo}`)
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          state.isEditMode = true;
          
          // Datos principales
          modalFields.cod.value = data.zoo.cod_zoo;
          modalFields.nombre.value = data.zoo.nombre_zoo;
          modalFields.encargadoText.value = data.zoo.encargado;
          modalFields.encargadoId.value = data.zoo.id_usuarios;
          modalFields.barrio.value = data.zoo.nombarrio || '';
          modalFields.direccion.value = data.zoo.direccion_zoo;

          modalTitle.textContent = 'Editar Zoocriadero';

          // Habilitar campos editables
          modalFields.nombre.readOnly = false;
          modalFields.nombre.classList.remove('bg-sky-50');
          modalFields.nombre.classList.add('bg-white', 'focus:border-sky-500', 'focus:ring-2', 'focus:ring-sky-200');
          
          modalFields.barrio.readOnly = false;
          modalFields.barrio.classList.remove('bg-sky-50');
          modalFields.barrio.classList.add('bg-white', 'focus:border-sky-500', 'focus:ring-2', 'focus:ring-sky-200');

          // Tabla tanques
          const list = modalFields.tanquesList;
          list.innerHTML = '';

          if (data.tanques && data.tanques.length > 0) {
            data.tanques.forEach(t => {
              list.innerHTML += `
                <tr class="hover:bg-sky-100">
                  <td class="py-2 px-3">${t.nomtiptan || 'N/A'}</td>
                  <td class="py-2 px-3">${t.nom_zootanque || 'N/A'}</td>
                </tr>`;
            });
          } else {
            list.innerHTML = `
              <tr>
                <td colspan="2" class="py-3 px-3 text-center text-slate-500">
                  No hay tanques asociados
                </td>
              </tr>`;
          }

          // Mostrar botones de edición
          btnEditarDireccion.classList.remove('hidden');
          modalSave.classList.remove('hidden');

          // Mostrar modal
          showModal();
        } else {
          alert(data.message || 'Error al cargar los datos del zoocriadero');
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        alert('Error al cargar los datos del zoocriadero');
      });
  };

  /* ============================
      MODAL DIRECCIÓN
  ============================ */
  function actualizarVistaPrevia() {
    const tipo = tipoVia.value;
    const numero = numeroVia.value.trim();
    const suf = sufijo.value.trim();
    const dist = distancia.value.trim();

    let direccion = [];
    if (tipo) direccion.push(tipo);
    if (numero) direccion.push(numero);
    if (suf) direccion.push('#' + suf);
    if (dist) direccion.push(dist);

    vistaPrevia.textContent = direccion.length > 0 ? direccion.join(' ') : '-';
  }

  [tipoVia, numeroVia, sufijo, distancia].forEach(input => {
    input.addEventListener('input', actualizarVistaPrevia);
    input.addEventListener('change', actualizarVistaPrevia);
  });

  btnEditarDireccion.addEventListener('click', () => {
    // Intentar parsear dirección actual
    const dirActual = modalFields.direccion.value.trim();
    if (dirActual && dirActual !== '-') {
      const partes = dirActual.split(' ');
      if (partes[0]) tipoVia.value = partes[0];
      if (partes[1]) numeroVia.value = partes[1];
      // Parseo básico - mejorar según formato
    }
    
    actualizarVistaPrevia();
    modalDireccion.classList.remove('hidden');
    modalDireccion.classList.add('flex');
  });

  btnCerrarModal.addEventListener('click', () => {
    modalDireccion.classList.add('hidden');
    modalDireccion.classList.remove('flex');
  });

  btnBorrarModal.addEventListener('click', () => {
    tipoVia.value = '';
    numeroVia.value = '';
    sufijo.value = '';
    distancia.value = '';
    actualizarVistaPrevia();
  });

  btnBorrarUltimoModal.addEventListener('click', () => {
    const actual = vistaPrevia.textContent;
    if (actual && actual !== '-') {
      const partes = actual.trim().split(' ');
      partes.pop();
      
      // Reconstruir campos (simplificado)
      if (partes.length > 0) {
        if (partes.length >= 1) tipoVia.value = partes[0];
        if (partes.length >= 2) numeroVia.value = partes[1];
        if (partes.length >= 3) sufijo.value = partes[2].replace('#', '');
        if (partes.length >= 4) distancia.value = partes[3];
      }
      
      actualizarVistaPrevia();
    }
  });

  btnAplicarDireccion.addEventListener('click', () => {
    const direccionGenerada = vistaPrevia.textContent;
    modalFields.direccion.value = direccionGenerada;
    modalDireccion.classList.add('hidden');
    modalDireccion.classList.remove('flex');
  });

  modalDireccion.addEventListener('click', (e) => {
    if (e.target === modalDireccion) {
      modalDireccion.classList.add('hidden');
      modalDireccion.classList.remove('flex');
    }
  });

});