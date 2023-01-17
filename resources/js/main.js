/* const nombreComisarias = [];

window.addEventListener("load", async () => {
    const datos = new FormData();
    datos.append("accion", "LISTAR_COMISARIAS");
    let listadoComisarias = await postData(datos, 'controllerComisaria.php')
    //console.log(listadoComisarias)
    nombreComisarias = listadoComisarias.map((comisaria) => comisaria.comisaria);
    //console.log(nombreComisarias)
    //cargarAutocompletadoComisarias(nombreComisarias, listadoComisarias);

}); */
alert('miau')
cargarComisarias = async () => {
    const datos = new FormData();
    datos.append("accion", "LISTAR_COMISARIAS");
    let listadoComisarias = await postData(datos, 'controllerComisaria.php')
    return listadoComisarias
}
/* function cargarAutocompletadoComisarias(comisarias, dataComisarias) {
    $("#comisaria").autocomplete({
        source: comisarias,
         select: (e, item) => {
            let unidad = item.item.value;
            let position = list.indexOf(unidad);
            nivelIpress = unidades[position].nivel;
            cargarTarifario(nivelIpress)
        }, 
    });
} */

/*----------------------- MODALS ------------------------------- */
const btnCambioPass = document.querySelector('#btnCambioPass');
const modal = document.querySelector('#bg-modal');
const modalContent = document.querySelector('#modal-content');
const modalForm = document.querySelector('#modal_form')

//Abrir Modal
const abrirModal = (form) => {
    modal.style.display = 'table';
    $('#modal_form').load(`App/views/modals/${form}`)
}
//Cerrar Modal
$('a.closeModal').on('click', (e) => {
    e.preventDefault();
    modal.style.display = 'none';
    modalContent.classList.remove('frm-lg');
})

//Botones para abrir modal
btnCambioPass.addEventListener('click', () => abrirModal('frmCambioPass.html'));

$(document).on("click", "#btn-nuevo", async () => {
    modalContent.classList.add('frm-lg')
    abrirModal('frmNuevoRegistro.html')
    let comisarias = await cargarComisarias();
    let nombreComisarias = comisarias.map((comisaria) => comisaria.comisaria)
    autocompletadoComisarias(nombreComisarias, comisarias)
});
function autocompletadoComisarias(nombres, listadoOriginal) {
    $("#comisaria").autocomplete({
        source: nombres,
        select: (e, item) => {
            let comisaria = item.item.value;
            let position = nombres.indexOf(comisaria);
            let idComisaria = listadoOriginal[position].id_comandancia;
            $('#idComisaria').val(idComisaria)
        },
    })
}
/*----------------------- SECTIONS ------------------------------- */
const lnkMuestra = document.querySelector('#lnk-muestra')
const lnkReportes = document.querySelector('#lnk-reportes')
const lnkUsuarios = document.querySelector('#lnk-usuarios')
const contenedor = document.querySelector('#section_view');

const loadView = async (e, lnk) => {
    e.preventDefault()
    $(".list_menu .active").removeClass('active');
    lnk.classList.add('active');
    $("#section_view").load(`App/views/sections/${lnk.pathname}`)
};

lnkMuestra.addEventListener('click', e => loadView(e, lnkMuestra))
lnkReportes.addEventListener('click', e => loadView(e, lnkReportes))
lnkUsuarios.addEventListener('click', e => loadView(e, lnkUsuarios))

/*----------------------- FORMS ------------------------------- */
async function postData(data, url) {
    const response = await fetch(`App/controller/${url}`, {
        method: "POST",
        body: data,
    }).then((res) => res.json());
    return await response;
}
async function buscarPersona(dni) {
    let datos = new FormData();
    datos.append("accion", "CONSULTA_DNI");
    datos.append("dni", dni);
    let persona = await (postData(datos, 'controllerPersona.php'));
    return persona
}

$(document).on("click", "#btn_search_user", async () => {
    let dni = $('#nroDoc').val()
    let persona = await buscarPersona(dni);
    console.log(persona)
});



/* $(document).on("submit", "#frmCambioPass", (e) => {
    e.preventDefault()
    console.log('remiau')
});
 */
/* 
async function ListarPersonas(tipoPersona) {
  let datos = new FormData();
  datos.append("accion", "LISTAR_PERSONAS");
  datos.append("tipoPersona", tipoPersona);
  let personas = await (await postData(datos)).json();
  tipoPersona == 'E' ? renderProfesionales(personas) : renderPacientes(personas);
}

async function postData(data) {
    const response = await fetch("App/controller/controller.php", {
        method: "POST",
        body: data,
    }).then((res) => res.json());
    return await response;
} 


function abrir_seccion(lnk) {
  $(".list-menu .active").removeClass("active");
  $(`#${lnk.id}`).addClass("active");
  fetch(`App/views/${lnk.attributes.href.nodeValue}`)
    .then((res) => res.text())
    .then((res) => $("#wrapper-section").html(res));
}

 <a id="lnk-horarios" href="/horarios.html">
*/
