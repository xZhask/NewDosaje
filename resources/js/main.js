const btnNuevoRegistro = document.querySelector('#btn-nuevo');
const btnCambioPass = document.querySelector('#btnCambioPass');
const modal = document.querySelector('#bg-modal');
const modalContent = document.querySelector('#modal-content');
const closeModal = document.querySelectorAll('.closeModal');

const formCambioPass = document.querySelector('#frmCambioPass');
const formNewRegistro = document.querySelector('#frmHojaRegistro');

//Abrir Modal
const abrirModal = (form) => {
    modal.style.display = 'table';
    form.style.display = 'flex'
}
//Cerrar Modal
$('a.closeModal').on('click', () => { modal.style.display = 'none'; modalContent.classList.remove('frm-lg'); })
//Botones para abrir modal
btnNuevoRegistro.addEventListener('click', () => { modalContent.classList.add('frm-lg'); abrirModal(formNewRegistro) });
btnCambioPass.addEventListener('click', () => abrirModal(formCambioPass));

formCambioPass.addEventListener('submit', e => {
    e.preventDefault();
    console.log('bien ctm')
})
formNewRegistro.addEventListener('submit', e => {
    e.preventDefault();
    console.log('bien ctm2')
})