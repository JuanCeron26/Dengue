/* script.js
   - No contiene datos "quemados".
   - Opera sobre las filas que existan en el DOM (tabla en HTML).
   - Mantén los iconos en ./icons/
*/

/* Helpers */
const hasInvalidChars = s => /[<>\/;{}[\]~`]/.test(s);
const isEmpty = s => !s || !s.trim();
const escapeHtml = unsafe => unsafe
  .replaceAll('&','&amp;')
  .replaceAll('<','&lt;')
  .replaceAll('>','&gt;')
  .replaceAll('"','&quot;')
  .replaceAll("'", '&#039;');

/* ELEMENTS */
const tbody = document.getElementById('tbody');
const btnNew = document.getElementById('btnNew');
const modalForm = document.getElementById('modalForm');
const form = document.getElementById('form');
const btnCancelForm = document.getElementById('btnCancelForm');

const filterName = document.getElementById('filterName');
const filterEncargado = document.getElementById('filterEncargado');
const filterTipo = document.getElementById('filterTipo');
const filterDireccion = document.getElementById('filterDireccion');
const btnApplyFilters = document.getElementById('btnApplyFilters');
const btnClearFilters = document.getElementById('btnClearFilters');
const noResults = document.getElementById('noResults');

const prevPageBtn = document.getElementById('prevPage');
const nextPageBtn = document.getElementById('nextPage');
const currentPageEl = document.getElementById('currentPage');
const totalPagesEl = document.getElementById('totalPages');

const modalView = document.getElementById('modalView');
const detailContent = document.getElementById('detailContent');
const btnCloseView = document.getElementById('btnCloseView');

const modalDelete = document.getElementById('modalDelete');
const btnCancelDelete = document.getElementById('btnCancelDelete');
const btnConfirmDelete = document.getElementById('btnConfirmDelete');

const modalExport = document.getElementById('modalExport');
const exportCSV = document.getElementById('exportCSV');
const exportPDF = document.getElementById('exportPDF');
const btnCloseExport = document.getElementById('btnCloseExport');

let currentPage = 1;
const perPage = 6;
let targetIdToDelete = null;
let targetIdToExport = null;

/* modal helpers */
function openModal(el){ el.classList.remove('hidden'); el.classList.add('flex'); }
function closeModal(el){ el.classList.add('hidden'); el.classList.remove('flex'); }

/* Pagination & rendering */
function getAllRows(){ return Array.from(tbody.querySelectorAll('tr')); }

function updatePagination(){
  const visibleRows = getAllRows().filter(r => r.style.display !== 'none');
  const total = visibleRows.length;
  const totalPages = Math.max(1, Math.ceil(total / perPage));
  if (currentPage > totalPages) currentPage = totalPages;
  const start = (currentPage - 1) * perPage;
  const end = start + perPage;

  getAllRows().forEach(r => r.style.display = 'none');
  visibleRows.forEach((r, idx) => {
    r.style.display = (idx >= start && idx < end) ? '' : 'none';
  });

  currentPageEl.textContent = currentPage;
  totalPagesEl.textContent = totalPages;
}

function changePage(p){
  const visibleCount = getAllRows().filter(r => r.style.display !== 'none').length;
  const totalPages = Math.max(1, Math.ceil(visibleCount / perPage));
  if (p < 1) p = 1;
  if (p > totalPages) p = totalPages;
  currentPage = p;
  updatePagination();
}

/* Filters */
function filterRowsApply(){
  const name = filterName.value.trim().toLowerCase();
  const encargado = filterEncargado.value.trim().toLowerCase();
  const tipo = filterTipo.value;
  const direccion = filterDireccion.value.trim().toLowerCase();

  if (hasInvalidChars(name) || hasInvalidChars(encargado) || hasInvalidChars(direccion)) {
    alert('El campo ingresado contiene caracteres inválidos.');
    return;
  }

  let matched = 0;
  getAllRows().forEach(row => {
    const rName = (row.children[1]?.textContent || '').toLowerCase();
    const rEnc = (row.children[2]?.textContent || '').toLowerCase();
    const rDir = (row.children[3]?.textContent || '').toLowerCase();
    const rTipo = (row.children[4]?.textContent || '');

    const matches = (
      (name ? rName.includes(name) : true) &&
      (encargado ? rEnc.includes(encargado) : true) &&
      (direccion ? rDir.includes(direccion) : true) &&
      (tipo ? rTipo === tipo : true)
    );

    row.style.display = matches ? '' : 'none';
    if (matches) matched++;
  });

  noResults.classList.toggle('hidden', matched > 0);
  currentPage = 1;
  updatePagination();
}

btnApplyFilters.addEventListener('click', filterRowsApply);
btnClearFilters.addEventListener('click', () => {
  filterName.value = '';
  filterEncargado.value = '';
  filterTipo.value = '';
  filterDireccion.value = '';
  getAllRows().forEach(r => r.style.display = '');
  noResults.classList.add('hidden');
  currentPage = 1;
  updatePagination();
});

/* ID generation */
function nextId(){
  const rows = getAllRows();
  let max = 0;
  rows.forEach(r => { const id = Number(r.getAttribute('data-id') || 0); if (id > max) max = id; });
  return max + 1;
}

/* Form create / edit */
btnNew.addEventListener('click', ()=>{
  openModal(modalForm);
  document.getElementById('modalTitle').textContent = 'Registrar Zoocriadero';
  document.getElementById('editingId').value = '';
  form.reset(); hideAllErrs();
});

btnCancelForm.addEventListener('click', ()=> closeModal(modalForm));

function hideAllErrs(){
  ['errName','errEncargado','errTipo','errTanque','errDireccion'].forEach(id=>{
    const el = document.getElementById(id);
    el.classList.add('hidden'); el.textContent='';
  });
}

form.addEventListener('submit', (e)=>{
  e.preventDefault(); hideAllErrs();
  const idEditing = document.getElementById('editingId').value;
  const name = document.getElementById('name').value.trim();
  const encargado = document.getElementById('encargado').value.trim();
  const tipo = document.getElementById('tipo').value;
  const tanque = document.getElementById('tanque').value.trim();
  const direccion = document.getElementById('direccion').value.trim();

  let hasErr = false;

  if (isEmpty(name) || hasInvalidChars(name)) { errName.textContent = 'Si el campo "nombre" está vacío o contiene caracteres inválidos, mostrar mensaje de error.'; errName.classList.remove('hidden'); hasErr = true; }
  if (isEmpty(direccion) || hasInvalidChars(direccion)) { errDireccion.textContent = 'Si el campo Dirección está vacío o contiene caracteres inválidos, mostrar mensaje de error.'; errDireccion.classList.remove('hidden'); hasErr = true; }
  if (isEmpty(encargado) || hasInvalidChars(encargado)) { errEncargado.textContent = 'Si el campo Encargado está vacío o contiene caracteres inválidos, mostrar mensaje de error.'; errEncargado.classList.remove('hidden'); hasErr = true; }
  if (!tipo) { errTipo.textContent = 'Debe seleccionar un tipo de tanque'; errTipo.classList.remove('hidden'); hasErr = true; }
  if (!tanque) { errTanque.textContent = 'Debe seleccionar un tanque'; errTanque.classList.remove('hidden'); hasErr = true; }

  if (!idEditing && !hasErr) {
    const exists = getAllRows().some(r => {
      const rn = (r.children[1]?.textContent || '').trim().toLowerCase();
      const rd = (r.children[3]?.textContent || '').trim().toLowerCase();
      return rn === name.toLowerCase() && rd === direccion.toLowerCase();
    });
    if (exists) return alert('Validar que no exista un zoocriadero registrado con el mismo nombre y dirección.');
  }

  if (hasErr) return;

  if (idEditing) {
    const row = tbody.querySelector(`tr[data-id="${idEditing}"]`);
    row.children[1].textContent = name;
    row.children[2].textContent = encargado;
    row.children[3].textContent = direccion;
    row.children[4].textContent = tipo;
    row.children[5].textContent = tanque;
    alert('El zoocriadero ha sido actualizado correctamente');
  } else {
    const id = nextId();
    const tr = document.createElement('tr');
    tr.setAttribute('data-id', id);
    tr.innerHTML = `
      <td class="py-3 text-center">${id}</td>
      <td class="py-3">${escapeHtml(name)}</td>
      <td class="py-3">${escapeHtml(encargado)}</td>
      <td class="py-3">${escapeHtml(direccion)}</td>
      <td class="py-3">${escapeHtml(tipo)}</td>
      <td class="py-3 text-center">${escapeHtml(tanque)}</td>
      <td class="py-3 text-center">
        <img src="./icons/view.svg" class="action-icon btn-view" title="Ver">
        <img src="./icons/edit.svg" class="action-icon btn-edit" title="Editar">
        <img src="./icons/trash.svg" class="action-icon btn-delete" title="Anular">
        <img src="./icons/export.svg" class="action-icon btn-export" title="Exportar">
      </td>
    `;
    tbody.prepend(tr);
    alert('El zoocriadero fue registrado exitosamente');
  }

  closeModal(modalForm);
  bindRowActions();
  updatePagination();
});

/* Delegación acciones */
function bindRowActions(){
  tbody.querySelectorAll('.btn-view').forEach(btn =>
    btn.onclick = e => openDetail(e.target.closest('tr').dataset.id)
  );

  tbody.querySelectorAll('.btn-edit').forEach(btn =>
    btn.onclick = e => populateFormForEdit(e.target.closest('tr').dataset.id)
  );

  tbody.querySelectorAll('.btn-delete').forEach(btn =>
    btn.onclick = e => {
      targetIdToDelete = e.target.closest('tr').dataset.id;
      document.getElementById('deleteMsg').textContent =
      'Si el zoocriadero está involucrado con otro registro el sistema deberá cancelar la operación... ¿Desea inhabilitarlo?';
      openModal(modalDelete);
    }
  );

  /* ✅ NUEVO: Exportar desde ícono */
  tbody.querySelectorAll('.btn-export').forEach(btn =>
    btn.onclick = e => {
      targetIdToExport = e.target.closest('tr').dataset.id;
      openModal(modalExport);
    }
  );
}

/* Detalle */
function openDetail(id){
  const tr = tbody.querySelector(`tr[data-id="${id}"]`);
  detailContent.innerHTML = `
    <div><strong>ID:</strong> ${tr.children[0].textContent}</div>
    <div><strong>Nombre:</strong> ${tr.children[1].textContent}</div>
    <div><strong>Encargado:</strong> ${tr.children[2].textContent}</div>
    <div><strong>Dirección:</strong> ${tr.children[3].textContent}</div>
    <div><strong>Tipo de tanque:</strong> ${tr.children[4].textContent}</div>
    <div><strong>Tanque:</strong> ${tr.children[5].textContent}</div>
    <div><strong>Fecha de registro:</strong> ${new Date().toLocaleString()}</div>
    <div><strong>Estado:</strong> Activo</div>
  `;
  openModal(modalView);
}

btnCloseView.addEventListener('click', ()=> closeModal(modalView));

/* Editar */
function populateFormForEdit(id){
  const tr = tbody.querySelector(`tr[data-id="${id}"]`);
  openModal(modalForm);
  document.getElementById('modalTitle').textContent = 'Editar Zoocriadero';
  document.getElementById('editingId').value = id;
  document.getElementById('name').value = tr.children[1].textContent;
  document.getElementById('encargado').value = tr.children[2].textContent;
  document.getElementById('direccion').value = tr.children[3].textContent;
  document.getElementById('tipo').value = tr.children[4].textContent;
  document.getElementById('tanque').value = tr.children[5].textContent;
  hideAllErrs();
}

/* Delete */
btnCancelDelete.addEventListener('click', ()=>{ targetIdToDelete = null; closeModal(modalDelete); });
btnConfirmDelete.addEventListener('click', ()=>{
  const tr = tbody.querySelector(`tr[data-id="${targetIdToDelete}"]`);
  tr.style.opacity = '0.5';
  tr.dataset.state = 'Inhabilitado';
  alert('El zoocriadero ha sido inhabilitado correctamente.');
  targetIdToDelete = null; closeModal(modalDelete);
});

/* ✅ Export CSV */
exportCSV.addEventListener('click', () => {
  const row = document.querySelector(`tr[data-id="${targetIdToExport}"]`);
  const cells = Array.from(row.children).map(td => td.textContent.trim());
  const csv = cells.join(",") + "\n";
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `zoocriadero_${targetIdToExport}.csv`;
  a.click();
  closeModal(modalExport);
});

/* ✅ Export PDF */
exportPDF.addEventListener('click', ()=>{
  const tr = tbody.querySelector(`tr[data-id="${targetIdToExport}"]`);
  const html = `
  <div style='font-family:Arial;padding:20px'>
    <h2>Reporte Zoocriadero</h2>
    <p><b>ID:</b> ${tr.children[0].textContent}</p>
    <p><b>Nombre:</b> ${tr.children[1].textContent}</p>
    <p><b>Encargado:</b> ${tr.children[2].textContent}</p>
    <p><b>Dirección:</b> ${tr.children[3].textContent}</p>
    <p><b>Tipo:</b> ${tr.children[4].textContent}</p>
    <p><b>Tanque:</b> ${tr.children[5].textContent}</p>
  </div>
  `;
  const win = window.open('', '_blank');
  win.document.write(html);
  win.print();
  closeModal(modalExport);
});

btnCloseExport.addEventListener('click', ()=> closeModal(modalExport));

/* Pagination buttons */
prevPageBtn.addEventListener('click', ()=> changePage(currentPage - 1));
nextPageBtn.addEventListener('click', ()=> changePage(currentPage + 1));

/* Init */
function init(){
  bindRowActions();
  updatePagination();
}
init();
