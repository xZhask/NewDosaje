const btnNuevoRegistro = document.querySelector('#btn-nuevo');
const btnCambioPass = document.querySelector('#btnCambioPass');
const modal = document.querySelector('#bg-modal');
const modalContent = document.querySelector('#modal-content');

//Abrir Modal
const abrirModal = (url) => {
    modal.style.display = 'table';
    fetch(url).then(res => res.text()).then(res => modalContent.innerHTML = res);
}
//Cerrar Modal
$('a.closeModal').on('click', () => { modal.style.display = 'none'; modalContent.classList.remove('frm-lg'); })

//Botones para abrir modal
btnNuevoRegistro.addEventListener('click', () => { modalContent.classList.add('frm-lg'); abrirModal('modals/frmRegistro.html') });
btnCambioPass.addEventListener('click', () => abrirModal('modals/frmCambioPass.html'));

const btnMiau = document.querySelector('#BtnMiau');
console.log(btnMiau);
if (btnMiau) btnMiau.addEventListener('click', () => { alert('miau'); });