//const nombreComisarias = [];

//window.addEventListener("load", async () => {...});
const cargarComisarias = async () => {
    const datos = new FormData();
    datos.append("accion", "LISTAR_COMISARIAS");
    let listadoComisarias = await postData(datos, 'controllerComisaria.php')
    return listadoComisarias
}
const cargarTipoDoc = async () => {
    let datos = new FormData();
    datos.append("accion", "LISTAR_TIPODOC");
    let tipoDoc = await (postData(datos, 'controllerDocumento.php'));
    return tipoDoc
}
//Render Opciones
const crearOptionsTipoDoc = tiposDocumento => tiposDocumento.map((tipodocumento) => `<option value="${tipodocumento.id_tipodoc}">${tipodocumento.tipo_doc}</option>`).join('')

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
    let tiposDocumento = await cargarTipoDoc()
    $('#tipoDoc').html(crearOptionsTipoDoc(tiposDocumento))
});

//Cargar autocompletados
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
async function buscarPersonaReniec(dni) {
    let datos = new FormData();
    datos.append("accion", "CONSULTA_DNI");
    datos.append("dni", dni);
    let persona = await (postData(datos, 'controllerPersona.php'));
    return persona.data
}
async function buscarPersonaBd(nroDoc) {
    let datos = new FormData();
    datos.append("accion", "BUSCAR_PERSONA");
    datos.append("nrodoc", nroDoc);
    let persona = await (postData(datos, 'controllerPersona.php'));
    return persona[0]
}

$(document).on("click", "#btn_search_user", async () => {
    /* Limpiar usuario antes de enviar nuevo número */
    $('#nombre').val('')
    $('#sexo').val('')
    $('#edad').val('')
    $('#licencia').val('')
    /*----*/
    $('#btn_search_user').html('<img src="resources/img/icon-loading.svg" class="loading">')
    let nroDoc = $('#nroDoc').val()
    let tipoDoc = $('#tipoDoc').find('option:selected').text();
    let persona = await buscarPersonaBd(nroDoc);
    if (persona === undefined) { if (tipoDoc === 'DNI') persona = await buscarPersonaReniec(nroDoc); }
    else { $('#sexo').val(persona.sexo); $('#edad').val(persona.edad); $('#licencia').val(persona.licencia) }
    if (persona !== undefined) $('#nombre').val(persona.nombre_completo)
    $('#btn_search_user').html('<img src="resources/img/icon-search.svg">')
});
/* */
$(document).on("click", "#btn_search_conductor", async () => {
    /* Limpiar usuario antes de enviar nuevo número */
    $('#nombreConductor').val('')
    $('#gradoConductor').val('')
    /*----*/
    $('#btn_search_conductor').html('<img src="resources/img/icon-loading.svg" class="loading">')
    let nroDoc = $('#nroDocConductor').val()

    let persona = await buscarPersonaBd(nroDoc);
    if (persona === undefined) persona = await buscarPersonaReniec(nroDoc);
    else $('#gradoConductor').val(persona.grado);

    if (persona !== undefined) $('#nombreConductor').val(persona.nombre_completo)
    $('#btn_search_conductor').html('<img src="resources/img/icon-search.svg">')
});

//buscarUsuario()
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
/* ----------- VALIDACIONES -------------------------- */

