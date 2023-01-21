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
const cargarExtractores = async () => {
    const datos = new FormData();
    datos.append("accion", "CARGAR_PROFESIONALES");
    datos.append("tipoProfesional", "E");
    let listaExtractores = await postData(datos, 'controllerPersona.php')
    return listaExtractores
}
const cargarPeritos = async () => {
    const datos = new FormData();
    datos.append("accion", "CARGAR_PROFESIONALES");
    datos.append("tipoProfesional", "P");
    let listaPeritos = await postData(datos, 'controllerPersona.php')
    return listaPeritos
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
    let extractores = await cargarExtractores();
    let peritos = await cargarPeritos();
    let nombreComisarias = comisarias.map((comisaria) => comisaria.comisaria)
    let nombreExtractores = extractores.map((extractor) => extractor.nombre)
    let nombrePeritos = peritos.map((perito) => perito.nombre)

    autocompletadoComisarias(nombreComisarias, comisarias)
    autocompletadoExtractores(nombreExtractores, extractores)
    autocompletadoPeritos(nombrePeritos, peritos)
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
function autocompletadoExtractores(nombres, listadoOriginal) {
    $("#extractor").autocomplete({
        source: nombres,
        select: (e, item) => {
            let extractor = item.item.value;
            let position = nombres.indexOf(extractor);
            let idExtractor = listadoOriginal[position].id_persona;
            $('#idExtractor').val(idExtractor)
            //console.log(idExtractor)
        },
    })
}
function autocompletadoPeritos(nombres, listadoOriginal) {
    $("#perito").autocomplete({
        source: nombres,
        select: (e, item) => {
            let perito = item.item.value;
            let position = nombres.indexOf(perito);
            let idPerito = listadoOriginal[position].id_persona;
            $('#idPerito').val(idPerito)

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

const unidades = {
    0: 'CERO',
    'E1': 'UN',
    1: 'UNO',
    2: 'DOS',
    3: 'TRES',
    4: 'CUATRO',
    5: 'CINCO',
    6: 'SEIS',
    7: 'SIETE',
    8: 'OCHO',
    9: 'NUEVE',
}
const decenas = {
    10: 'DIEZ',
    11: 'ONCE',
    12: 'DOCE',
    13: 'TRECE',
    14: 'CATORCE',
    15: 'QUINCE',
    20: 'VEINTE',
    30: 'TREINTA',
    40: 'CUARENTA',
    50: 'CINCUENTA',
    60: 'SESENTA',
    70: 'SETENTA',
    80: 'OCHENTA',
    90: 'NOVENTA'
}

const numeroLetras = (numero) => {
    let cadena = numero.split('.');
    let entero = cadena[0];
    let decimal = cadena[1];
    /* parte decimal */
    let textoGramos = (entero == 1) ? 'GRAMO' : 'GRAMOS';
    if (entero == 1) entero = 'E1';
    /* parte decimal */
    let textoDecimal;
    if (decimal % 10 === 0 || (decimal < 16 && decimal > 10)) textoDecimal = decenas[decimal];
    else if (decimal < 10) textoDecimal = `${unidades[decimal[0]]} ${unidades[decimal[1]]}`
    else if (decimal < 20 && decimal > 15) textoDecimal = 'DIECI' + unidades[decimal[1]]
    else if (decimal < 30 && decimal > 20) textoDecimal = 'VENITI' + unidades[decimal[1]]
    else if (decimal >= 30) textoDecimal = decenas[`${decimal[0]}0`] + ' Y ' + unidades[decimal[1]]

    let texto = `${unidades[entero]} ${textoGramos} ${textoDecimal} CENTÍGRAMOS DE ALCOHOL POR LITRO DE SANGRE`
    return texto
}
/*
console.log(numeroLetras('5.07'))
console.log(numeroLetras('1.11'))
console.log(numeroLetras('2.30'))
console.log(numeroLetras('4.40'))
console.log(numeroLetras('7.27'))
console.log(numeroLetras('5.52'))
console.log(numeroLetras('0.83'))
console.log(numeroLetras('0.15'))*/