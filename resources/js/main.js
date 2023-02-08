let actionForm = '';
let CodigoSearch = '';
//window.addEventListener("load", async () => {...});
const cargarComisarias = async () => {
  const datos = new FormData();
  datos.append("accion", "LISTAR_COMISARIAS");
  let listadoComisarias = await postData(datos, "controllerComisaria.php");
  return listadoComisarias;
};
const cargarTipoDoc = async () => {
  let datos = new FormData();
  datos.append("accion", "LISTAR_TIPODOC");
  let tipoDoc = await postData(datos, "controllerDocumento.php");
  return tipoDoc;
};
const cargarExtractores = async () => {
  const datos = new FormData();
  datos.append("accion", "CARGAR_PROFESIONALES");
  datos.append("tipoProfesional", "E");
  let listaExtractores = await postData(datos, "controllerPersona.php");
  return listaExtractores;
};
const cargarPeritos = async () => {
  const datos = new FormData();
  datos.append("accion", "CARGAR_PROFESIONALES");
  datos.append("tipoProfesional", "P");
  let listaPeritos = await postData(datos, "controllerPersona.php");
  return listaPeritos;
};
//Render Opciones
const crearOptionsTipoDoc = (tiposDocumento) =>
  tiposDocumento
    .map(
      (tipodocumento) =>
        `<option value="${tipodocumento.id_tipodoc}">${tipodocumento.tipo_doc}</option>`
    )
    .join("");

/*----------------------- MODALS ------------------------------- */
const btnCambioPass = document.querySelector("#btnCambioPass");
const btnOff = document.querySelector("#btnOff");
const modal = document.querySelector("#bg-modal");
const modalContent = document.querySelector("#modal-content");
const modalForm = document.querySelector("#modal_form");

//Abrir Modal
const abrirModal = (form) => {
  modal.style.display = "table";
  $.ajax({
    url: `App/views/modals/${form}`,
    cache: false,
    dataType: "html",
    success: function (data) {
      $("#modal_form").html(data);
      if (form === 'frmPersonal.html') {
        if (actionForm == 'U') llenarDatosPersonal()
        else $('#btn_search_personal').css('display', 'block');
      }
    },
  });
};
async function llenarDatosPersonal() {
  $('#btn_search_personal').css('display', 'none');
  let datos = new FormData();
  datos.append("accion", "BUSCAR_EMPLEADO");

  datos.append("idPersona", CodigoSearch);
  let respuesta = await postData(datos, "controllerPersona.php");
  let empleado = respuesta[0];
  $('#nroDocPersonal').val(empleado.nro_doc)
  $('#nombrePersonal').val(empleado.nombre);
  $('#gradoPersonal').val(empleado.grado);
  $('#profesionPersonal').val(empleado.profesion);
  $('#perfilPersonal').val(empleado.id_perfil);
  console.log(respuesta);
}
//Cerrar Modal
const cerrarModal = () => {
  modal.style.display = "none";
  modalContent.classList.remove("frm-lg");
  actionForm = ''
}
$("a.closeModal").on("click", (e) => {
  e.preventDefault();
  cerrarModal();
});
/* MODAL MENSAJE ALERT */
const msgAlert = (icono, titulo, texto) => {
  Swal.fire({
    position: 'bottom-end',
    icon: icono,
    title: titulo,
    text: texto,
    showConfirmButton: false,
    timer: 2000
  })
}

/* BOTÓN CERRAR SESIÓN*/
btnOff.addEventListener("click", async () => {
  let datos = new FormData();
  datos.append("accion", "LOGOUT");
  let respuesta = await postData(datos, "controllerPersona.php");
  if (respuesta.respuesta == 'logout') window.location.assign("login.php");
});
//Botones para abrir modal
btnCambioPass.addEventListener("click", () => abrirModal("frmCambioPass.html"));
//
const cargarFechaActual = () => {
  let fecha = new Date();
  let hoy = fecha.toLocaleDateString();
  let ahora = fecha.toLocaleTimeString();
  let cadenaFecha = hoy.split("/");
  let cadenaHora = ahora.split(":");
  if (cadenaFecha[1] < 10) cadenaFecha[1] = `0${cadenaFecha[1]}`;
  if (cadenaFecha[0] < 10) cadenaFecha[0] = `0${cadenaFecha[0]}`;
  let data = {
    fecha: `${cadenaFecha[2]}-${cadenaFecha[1]}-${cadenaFecha[0]}`,
    hora: `${cadenaHora[0]}:${cadenaHora[1]}`,
  };
  return data;
};
//
$(document).on("click", "#btn-nuevo", async () => {
  modalContent.classList.add("frm-lg");
  abrirModal("frmNuevoRegistro.html");
  let comisarias = await cargarComisarias();
  let extractores = await cargarExtractores();
  let peritos = await cargarPeritos();
  let nombreComisarias = comisarias.map((comisaria) => comisaria.comisaria);
  let nombreExtractores = extractores.map((extractor) => extractor.nombre);
  let nombrePeritos = peritos.map((perito) => perito.nombre);

  autocompletadoComisarias(nombreComisarias, comisarias);
  autocompletadoExtractores(nombreExtractores, extractores);
  autocompletadoPeritos(nombrePeritos, peritos);
  let tiposDocumento = await cargarTipoDoc();
  $("#tipoDoc").html(crearOptionsTipoDoc(tiposDocumento));
  let fechaActual = cargarFechaActual();
  $("#fechaRecepcion").val(fechaActual["fecha"]);
  $("#horaRecepcion").val(fechaActual["hora"]);
  fechaRecepcion.max = fechaActual["fecha"];
  fechaInfraccion.max = fechaActual["fecha"];
  fechaExtraccion.max = fechaActual["fecha"];
});
//Cargar autocompletados
function autocompletadoComisarias(nombres, listadoOriginal) {
  $("#comisaria").autocomplete({
    source: nombres,
    select: (e, item) => {
      let comisaria = item.item.value;
      let position = nombres.indexOf(comisaria);
      let idComisaria = listadoOriginal[position].id_comandancia;
      $("#idComisaria").val(idComisaria);
    },
  });
}
function autocompletadoExtractores(nombres, listadoOriginal) {
  $("#extractor").autocomplete({
    source: nombres,
    select: (e, item) => {
      let extractor = item.item.value;
      let position = nombres.indexOf(extractor);
      let idExtractor = listadoOriginal[position].id_persona;
      $("#idExtractor").val(idExtractor);
      //console.log(idExtractor)
    },
  });
}
function autocompletadoPeritos(nombres, listadoOriginal) {
  $("#perito").autocomplete({
    source: nombres,
    select: (e, item) => {
      let perito = item.item.value;
      let position = nombres.indexOf(perito);
      let idPerito = listadoOriginal[position].id_persona;
      $("#idPerito").val(idPerito);
    },
  });
}
/*----------------------- SECTIONS ------------------------------- */
const lnkMuestra = document.querySelector("#lnk-muestra");
const lnkReportes = document.querySelector("#lnk-reportes");
const lnkUsuarios = document.querySelector("#lnk-usuarios");
const contenedor = document.querySelector("#section_view");

const loadView = async (e, lnk) => {
  e.preventDefault();
  $(".list_menu .active").removeClass("active");
  lnk.classList.add("active");
  $.ajax({
    url: `App/views/sections/${lnk.pathname}`,
    cache: false,
    dataType: "html",
    success: function (data) {
      $("#section_view").html(data);
    },
  });
};

lnkMuestra.addEventListener("click", (e) => loadView(e, lnkMuestra));
lnkReportes.addEventListener("click", (e) => loadView(e, lnkReportes));
lnkUsuarios.addEventListener("click", (e) => loadView(e, lnkUsuarios));

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
  let persona = await postData(datos, "controllerPersona.php");
  if (persona.success !== false) persona.data.nacionalidad = "Peruana";
  return persona.data;
}
async function buscarPersonaBd(tipoDoc, nroDoc) {
  let datos = new FormData();
  datos.append("accion", "BUSCAR_PERSONA");
  datos.append("tipoDoc", tipoDoc);
  datos.append("nrodoc", nroDoc);
  let persona = await postData(datos, "controllerPersona.php");
  return persona[0];
}

$(document).on("click", "#btn_search_user", async () => {
  /* Limpiar usuario antes de enviar nuevo número */
  $("#nombre").val("");
  $("#sexo").val(0);
  $("#edad").val("");
  $("#licConducir").val("");
  /*----*/
  $("#btn_search_user").html(
    '<img src="resources/img/icon-loading.svg" class="loading">'
  );
  let nroDoc = $("#nroDoc").val();
  let tipoDoc = $("#tipoDoc").find("option:selected");

  let persona = await buscarPersonaBd(tipoDoc.val(), nroDoc);
  if (persona === undefined) {
    if (tipoDoc.text() === "DNI") persona = await buscarPersonaReniec(nroDoc);
  } else {
    $("#sexo").val(persona.sexo);
    $("#edad").val(persona.edad);
    $("#licConducir").val(persona.lic_conducir);
  }
  if (persona !== undefined) {
    $("#nombre").val(persona.nombre_completo);
    $("#nacionalidad").val(persona.nacionalidad);
  }
  $("#btn_search_user").html('<img src="resources/img/icon-search.svg">');
});
/* */
$(document).on("click", "#btn_search_conductor", async () => {
  /* Limpiar usuario antes de enviar nuevo número */
  $("#nombreConductor").val("");
  $("#gradoConductor").val("");
  /*----*/
  $("#btn_search_conductor").html(
    '<img src="resources/img/icon-loading.svg" class="loading">'
  );
  let nroDoc = $("#nroDocConductor").val();

  let persona = await buscarPersonaBd(7, nroDoc); // 7 = DNI EN BD
  if (persona === undefined) persona = await buscarPersonaReniec(nroDoc);
  else $("#gradoConductor").val(persona.grado);

  if (persona !== undefined) $("#nombreConductor").val(persona.nombre_completo);
  $("#btn_search_conductor").html('<img src="resources/img/icon-search.svg">');
});
$(document).on("click", "#btn_search_personal", async () => {
  $("#nombrePersonal").val("");
  $("#btn_search_personal").html(
    '<img src="resources/img/icon-loading.svg" class="loading">'
  );
  let nroDoc = $("#nroDocPersonal").val();
  let persona = await buscarPersonaBd(7, nroDoc); // 7 = DNI EN BD
  if (persona === undefined) {
    persona = await buscarPersonaReniec(nroDoc);
    $("#nombrePersonal").val(persona.nombre_completo);
  }
  else msgAlert('error', 'Usuario ya registrado', `Ya existe un registro con el número de DNI ${nroDoc}`)
  $("#btn_search_personal").html('<img src="resources/img/icon-search.svg">');
});

/* ----------- VALIDACIONES -------------------------- */

/* */
const isNumber = (e) => {
  if (e.keyCode < 48 || e.keyCode > 57) return false;
};
$(document).on("keypress", "#nroDoc", (e) => {
  let cadena = $("#nroDoc").val();
  if (cadena.length === 8) return false;
  return isNumber(e);
});
$(document).on("keypress", "#nroDocConductor", (e) => {
  let cadena = $("#nroDocConductor").val();
  if (cadena.length === 8) return false;
  return isNumber(e);
});
$(document).on("keypress", "#edad", (e) => {
  return isNumber(e);
});
$(document).on("keypress", "#nroOficio", (e) => {
  return isNumber(e);
});

$(document).on("keypress", "#cuantitativo", (e) => {
  if (e.keyCode < 46 || e.keyCode > 57 || e.keyCode == 47) return false;
  let cadena = $("#cuantitativo").val();
  if (e.keyCode == 46) if (cadena.indexOf(".") >= 0) return false;
});

$(document).on("keyup", "#cuantitativo", () => {
  let tipoProc = $("#tipoProcedimiento").val();
  if (tipoProc == "E") {
    let cadena = $("#cuantitativo").val();
    let cualitativo = cadena > 0 ? "POSITIVO" : "NEGATIVO";
    $("#cualitativo").val(cualitativo);
  }
});
/* TipoProc */
$(document).on("change", "#tipoProcedimiento", () => {
  let tipoProc = $("#tipoProcedimiento").val();
  let resCuantitativo =
    tipoProc == "C"
      ? "T/S/M"
      : tipoProc == "I"
        ? "N"
        : tipoProc == "S"
          ? "N"
          : "";
  let resCualitativo = tipoProc !== "E" ? tipoProc : "";
  let textoLabelFecha =
    tipoProc !== "E" ? "Fecha Constatación" : "Fecha Extracción";
  let textoLabelHora =
    tipoProc !== "E" ? "Hora Constatación" : "Hora Extracción";

  let htmlTipoMuestra =
    tipoProc == "E"
      ? `<option value=" 0">Tipo Muestra</option><option value="S">Sangre</option><option value="O">Orina</option>`
      : `<option value="N">Sin Muestra</option>`;

  if (tipoProc !== "E") {
    $(".control_peritaje").prop("readonly", "true");
    $(".control_peritaje").addClass("input_block");
    $("#idPerito").val("");
    $("#perito").val("");
  } else {
    $(".control_peritaje").prop("readonly", false);
    $(".control_peritaje").removeClass("input_block");
  }

  $("#cuantitativo").val(resCuantitativo);
  $("#cualitativo").val(resCualitativo);
  $("#lbl_fechaExtraccion").html(textoLabelFecha);
  $("#lbl_horaExtraccion").html(textoLabelHora);
  $("#tipoMuestra").html(htmlTipoMuestra);
});

$(document).on("submit", "#frmHojaRegistro", async (e) => {
  e.preventDefault();
  let form = document.querySelector("#frmHojaRegistro");
  let datos = new FormData(form);
  datos.append("accion", "REG_INCIDENCIA");
  let respuesta = await postData(datos, "controllerIncidencia.php");
  console.log(respuesta);
});
/* LOGIN */
async function ListarPersonal() {
  let datos = new FormData();
  datos.append("accion", "LISTAR_PERSONAL");
  let personal = await postData(datos, "controllerPersona.php");

  let listPersonal = personal.map((persona) => {
    let profesion = persona.profesion == "E" ? "EXTRACTOR" : "PERITO";
    return `<tr><td>${persona.id_persona}</td><td class='t_left'>${persona.nombre}</td><td>${persona.nro_doc}</td><td>${persona.grado}</td><td>${profesion}</td><td>${persona.perfil}</td><td><i class='fa-solid fa-user-pen edit-user i-blue'></i></td><td><i class='fa-solid fa-toggle-on i-green'></i></i></td></tr>`;
  });
  let cadenaPersonal = JSON.stringify(listPersonal);
  $("#tb_personal").html(cadenaPersonal);
}
/* FORM PERSONAL */
$(document).on("submit", "#frmPersonal", async (e) => {
  e.preventDefault();
  let form = document.querySelector("#frmPersonal");
  let datos = new FormData(form);
  datos.append("accion", "REGISTRAR_PERSONAL");
  let respuesta = await postData(datos, "controllerPersona.php");
  console.log(respuesta);
});
/* FRM CAMBIO CONTRASEÑA */
$(document).on("submit", "#frmCambioPass", async (e) => {
  e.preventDefault();
  let form = document.querySelector("#frmCambioPass");
  let datos = new FormData(form);
  datos.append("accion", "CAMBIAR_PASS");
  let respuesta = await postData(datos, "controllerPersona.php");
  //respuesta=respuesta.response
  if (respuesta.response === 1) {
    msgAlert('success', 'Cambio Existoso', 'Se realizó el cambio de contraseña')
    cerrarModal()
  }
  else
    msgAlert('error', 'algo salió mal', respuesta.response)
});

//Form Personal
$(document).on("click", "#btn-nuevo-personal", () => {
  abrirModal("frmPersonal.html");
  actionForm = 'R';
});
$(document).on("click", "#tb_personal .edit-user", function (e) {
  e.preventDefault()
  let parent = $(this).closest("table");
  let tr = $(this).closest("tr");
  let codigo = $(tr).find("td").eq(0).html();
  abrirModal("frmPersonal.html");
  actionForm = 'U';
  CodigoSearch = codigo
});

