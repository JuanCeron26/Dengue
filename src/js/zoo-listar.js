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
    isEditMode: false,
    encargados: [],
    barrios: [],
    tiposTanque: [],
    tanquesDelZoo: []
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

    if (action === 'view') {
      abrirModalVer(d.cod);
      return;
    }

    if (action === 'edit') {
      abrirModalEditar(d.cod);
      return;
    }

    if (action === 'delete') {
      if (!confirm('¿Estás seguro de anular este registro?')) return;

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

    // Resetear campos
    resetModalFields();
  }

  function resetModalFields() {
    // Ocultar selects y mostrar inputs readonly
    if (modalFields.encargadoSelect) {
      modalFields.encargadoSelect.classList.add('hidden');
    }
    if (modalFields.encargadoText) {
      modalFields.encargadoText.classList.remove('hidden');
      modalFields.encargadoText.readOnly = true;
    }

    if (modalFields.barrioSelect) {
      modalFields.barrioSelect.classList.add('hidden');
    }
    if (modalFields.barrio) {
      modalFields.barrio.classList.remove('hidden');
      modalFields.barrio.readOnly = true;
    }

    modalFields.nombre.readOnly = true;
    modalFields.nombre.classList.add('bg-sky-50');
    modalFields.nombre.classList.remove('bg-white', 'focus:border-sky-500', 'focus:ring-2', 'focus:ring-sky-200');

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

    // Obtener valores de los campos
    const nombreZoo = modalFields.nombre.value.trim();
    const direccionZoo = modalFields.direccion.value.trim();

    // Obtener cod_barrio del select o input
    let codBarrio = null;
    if (modalFields.barrioSelect && !modalFields.barrioSelect.classList.contains('hidden')) {
      codBarrio = modalFields.barrioSelect.value || null;
    }

    // Obtener id_usuarios del select o hidden
    let idUsuarios = null;
    if (modalFields.encargadoSelect && !modalFields.encargadoSelect.classList.contains('hidden')) {
      idUsuarios = modalFields.encargadoSelect.value;
    } else {
      idUsuarios = modalFields.encargadoId.value;
    }

    // Validaciones
    if (!nombreZoo || !direccionZoo) {
      alert('Por favor complete todos los campos obligatorios');
      return;
    }

    // Preparar datos
    const datosActualizar = {
      cod_zoo: parseInt(modalFields.cod.value),
      nombre_zoo: nombreZoo,
      direccion_zoo: direccionZoo,
      cod_barrio: codBarrio ? parseInt(codBarrio) : null,
      id_usuarios: parseInt(idUsuarios)
    };

    console.log('Datos a enviar:', datosActualizar);

    // Enviar al controlador
    fetch('../controllers/controllerEditar.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(datosActualizar)
    })
      .then(r => r.json())
      .then(json => {
        console.log('Respuesta del servidor:', json);
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
        alert('Error al guardar los cambios: ' + error.message);
      });
  });

  /* ============================
      MODAL VER DETALLE 
  ============================ */
  document.getElementById('tbody').addEventListener('click', (e) => {
    const boton = e.target.closest('img');
    if (!boton) return;

    const tr = e.target.closest('tr');
    const d = tr.dataset;
    if (boton.classList.contains('btn-editar')) {
      abrirModalEditar(d.cod);
    }
  });

  const abrirModalVer = function (codZoo) {
    fetch(`../controllers/controllerVerDetalle.php?cod_zoo=${codZoo}`)
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          state.isEditMode = false;

          modalFields.cod.value = data.zoo.cod_zoo;
          modalFields.nombre.value = data.zoo.nombre_zoo;

          // MODO VER: Mostrar texto readonly, ocultar selects
          if (modalFields.encargadoSelect) {
            modalFields.encargadoSelect.classList.add('hidden');
          }
          modalFields.encargadoText.classList.remove('hidden');
          modalFields.encargadoText.value = data.zoo.encargado;
          modalFields.encargadoId.value = data.zoo.id_usuarios;

          if (modalFields.barrioSelect) {
            modalFields.barrioSelect.classList.add('hidden');
          }
          modalFields.barrio.classList.remove('hidden');
          modalFields.barrio.value = data.zoo.nombarrio || '';

          modalFields.direccion.value = data.zoo.direccion_zoo;

          modalTitle.textContent = 'Ver Zoocriadero';

          // Tabla tanques - SOLO LECTURA (sin botón eliminar)
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

          resetModalFields();
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
  const abrirModalEditar = function (codZoo) {
    const cod = parseInt(codZoo);

    // Cargar datos auxiliares primero
    Promise.all([
      fetch('../controllers/controllerEditar.php?cod_zoo=' + cod).then(r => r.json()),
      fetch('../controllers/controllerListar.php?action=getEncargados').then(r => r.json()),
      fetch('../controllers/controllerListar.php?action=getBarrios').then(r => r.json())
    ])
      .then(([dataZoo, dataEncargados, dataBarrios]) => {
        if (!dataZoo.success) {
          alert(dataZoo.message || 'Error al cargar los datos del zoocriadero');
          return;
        }

        state.isEditMode = true;
        state.encargados = dataEncargados.data || [];
        state.barrios = dataBarrios.data || [];
        state.tanquesDelZoo = dataZoo.tanques || [];

        // Datos principales
        modalFields.cod.value = dataZoo.zoo.cod_zoo;
        modalFields.nombre.value = dataZoo.zoo.nombre_zoo;
        modalFields.direccion.value = dataZoo.zoo.direccion_zoo;

        modalTitle.textContent = 'Editar Zoocriadero';

        // Habilitar campo nombre
        modalFields.nombre.readOnly = false;
        modalFields.nombre.classList.remove('bg-sky-50');
        modalFields.nombre.classList.add('bg-white', 'focus:border-sky-500', 'focus:ring-2', 'focus:ring-sky-200');

        // AGREGAR AL INICIO DEL ARCHIVO, DONDE INICIALIZAS EL STATE
        const state = {
          encargados: [],
          barrios: [],
          tiposTanque: []
          // ... otros datos que tengas
        };

        // FUNCIÓN PARA CARGAR ENCARGADOS
        async function cargarEncargados() {
          try {
            const response = await fetch('../controllers/controladorListar.php?action=getEncargados');
            const data = await response.json();

            if (data && Array.isArray(data)) {
              state.encargados = data;
              console.log('Encargados cargados:', state.encargados);
            } else {
              console.error('Error: datos de encargados no válidos', data);
              state.encargados = [];
            }
          } catch (error) {
            console.error('Error al cargar encargados:', error);
            state.encargados = [];
          }
        }

        // FUNCIÓN PARA CARGAR BARRIOS
        async function cargarBarrios() {
          try {
            const response = await fetch('../controllers/controladorListar.php?action=getBarrios');
            const data = await response.json();

            if (data && Array.isArray(data)) {
              state.barrios = data;
              console.log('Barrios cargados:', state.barrios);
            } else {
              console.error('Error: datos de barrios no válidos', data);
              state.barrios = [];
            }
          } catch (error) {
            console.error('Error al cargar barrios:', error);
            state.barrios = [];
          }
        }

        // FUNCIÓN PARA INICIALIZAR TODOS LOS DATOS
        async function inicializarDatos() {
          await Promise.all([
            cargarEncargados(),
            cargarBarrios()
          ]);
          console.log('Datos inicializados correctamente');
        }

        // LLAMAR AL CARGAR LA PÁGINA
        document.addEventListener('DOMContentLoaded', async () => {
          await inicializarDatos();
          // ... resto de tu código de inicialización
        });

        // FUNCIÓN PARA ABRIR MODAL EDITAR (ACTUALIZADA)
        async function abrirModalEditar(codZoo) {
          try {
            // Asegurarse de que los datos estén cargados
            if (state.encargados.length === 0 || state.barrios.length === 0) {
              console.log('Recargando datos...');
              await inicializarDatos();
            }

            // Obtener datos del zoocriadero
            const response = await fetch(`../controllers/controladorEditar.php?cod_zoo=${codZoo}`);
            const dataZoo = await response.json();

            if (!dataZoo.success) {
              alert(dataZoo.message || 'Error al obtener datos');
              return;
            }

            console.log('Datos del zoo:', dataZoo);
            console.log('Encargados disponibles:', state.encargados);
            console.log('Barrios disponibles:', state.barrios);

            // Llenar campos del modal
            const modalFields = {
              nombre: document.getElementById('modal_nombre'),
              direccion: document.getElementById('modal_direccion'),
              encargadoText: document.getElementById('modal_encargado'),
              encargadoSelect: document.getElementById('modal_encargado_select'),
              barrio: document.getElementById('modal_barrio'),
              barrioSelect: document.getElementById('modal_barrio_select')
            };

            modalFields.nombre.value = dataZoo.zoo.nombre_zoo || '';
            modalFields.direccion.value = dataZoo.zoo.direccion_zoo || '';

            // CREAR SELECT DE ENCARGADOS
            if (modalFields.encargadoText) modalFields.encargadoText.classList.add('hidden');

            if (!modalFields.encargadoSelect) {
              const selectEncargado = document.createElement('select');
              selectEncargado.id = 'modal_encargado_select';
              selectEncargado.name = 'id_usuarios';
              selectEncargado.className = 'w-full border border-sky-200 rounded-lg p-3 bg-white text-slate-800 focus:border-sky-500 focus:ring-2 focus:ring-sky-200';
              modalFields.encargadoText.parentNode.insertBefore(selectEncargado, modalFields.encargadoText.nextSibling);
              modalFields.encargadoSelect = selectEncargado;
            }

            modalFields.encargadoSelect.innerHTML = '<option value="">-- Seleccione --</option>';

            if (state.encargados.length > 0) {
              state.encargados.forEach(enc => {
                const option = document.createElement('option');
                option.value = enc.id_usuarios;
                option.textContent = `${enc.nombre_usu} ${enc.apellido_usu}`;
                if (enc.id_usuarios == dataZoo.zoo.id_usuarios) {
                  option.selected = true;
                }
                modalFields.encargadoSelect.appendChild(option);
              });
            } else {
              console.warn('No hay encargados disponibles');
            }

            modalFields.encargadoSelect.classList.remove('hidden');

            // CREAR SELECT DE BARRIOS
            if (modalFields.barrio) modalFields.barrio.classList.add('hidden');

            if (!modalFields.barrioSelect) {
              const selectBarrio = document.createElement('select');
              selectBarrio.id = 'modal_barrio_select';
              selectBarrio.name = 'cod_barrio';
              selectBarrio.className = 'w-full border border-sky-200 rounded-lg p-3 bg-white text-slate-800 focus:border-sky-500 focus:ring-2 focus:ring-sky-200';
              modalFields.barrio.parentNode.insertBefore(selectBarrio, modalFields.barrio.nextSibling);
              modalFields.barrioSelect = selectBarrio;
            }

            modalFields.barrioSelect.innerHTML = '<option value="">-- Seleccione --</option>';

            if (state.barrios.length > 0) {
              state.barrios.forEach(barrio => {
                const option = document.createElement('option');
                option.value = barrio.cod_barrio;
                option.textContent = barrio.nombarrio;
                if (barrio.cod_barrio == dataZoo.zoo.cod_barrio) {
                  option.selected = true;
                }
                modalFields.barrioSelect.appendChild(option);
              });
            } else {
              console.warn('No hay barrios disponibles');
            }

            modalFields.barrioSelect.classList.remove('hidden');

            // Abrir el modal
            // ... tu código para mostrar el modal

          } catch (error) {
            console.error('Error al abrir modal:', error);
            alert('Error al cargar los datos del zoocriadero');
          }
        }

        // Tabla tanques EDITABLE
        renderTanquesEditables(dataZoo.tanques || []);

        // Mostrar botones de edición
        btnEditarDireccion.classList.remove('hidden');
        modalSave.classList.remove('hidden');

        showModal();
      })
      .catch((error) => {
        console.error('Error:', error);
        alert('Error al cargar los datos: ' + error.message);
      });
  };

  function renderTanquesEditables(tanques) {
    const list = modalFields.tanquesList;
    list.innerHTML = '';

    if (tanques && tanques.length > 0) {
      tanques.forEach((t, index) => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-sky-100';
        tr.innerHTML = `
          <td class="py-2 px-3">${t.nomtiptan || 'N/A'}</td>
          <td class="py-2 px-3">${t.nom_zootanque || 'N/A'}</td>
          <td class="py-2 px-3 text-center">
            <button type="button" class="text-red-600 hover:text-red-800" onclick="eliminarTanque(${index})">
              ✕
            </button>
          </td>
        `;
        list.appendChild(tr);
      });
    } else {
      list.innerHTML = `
        <tr>
          <td colspan="3" class="py-3 px-3 text-center text-slate-500">
            No hay tanques asociados
          </td>
        </tr>`;
    }
  }

  // Función global para eliminar tanque
  window.eliminarTanque = function (index) {
    if (confirm('¿Desea eliminar este tanque?')) {
      state.tanquesDelZoo.splice(index, 1);
      renderTanquesEditables(state.tanquesDelZoo);
    }
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
    const dirActual = modalFields.direccion.value.trim();
    if (dirActual && dirActual !== '-') {
      const partes = dirActual.split(' ');
      if (partes[0]) tipoVia.value = partes[0];
      if (partes[1]) numeroVia.value = partes[1];
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