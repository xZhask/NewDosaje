let actionForm = "";
let CodigoSearch = "";
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

/* CARGA DE AUTOCOMPLETADOS Y SELECT */
const llenarListadoPeritos = async () => {
  let peritos = await cargarPeritos();
  let nombrePeritos = peritos.map((perito) => perito.nombre);
  autocompletadoPeritos(nombrePeritos, peritos);
};
const llenarListadoExtractores = async () => {
  let extractores = await cargarExtractores();
  let nombreExtractores = extractores.map((extractor) => extractor.nombre);
  autocompletadoExtractores(nombreExtractores, extractores);
};
const llenarListadoComisarias = async () => {
  let comisarias = await cargarComisarias();
  let nombreComisarias = comisarias.map((comisaria) => comisaria.comisaria);
  autocompletadoComisarias(nombreComisarias, comisarias);
};
const llenarTipoDoc = async () => {
  let tiposDocumento = await cargarTipoDoc();
  $("#tipoDoc").html(crearOptionsTipoDoc(tiposDocumento));
};
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
      if (form === "frmPersonal.html") {
        if (actionForm == "U") llenarDatosPersonal();
        else $("#btn_search_personal").css("display", "block");
      }
      if (form === "frmNuevoRegistro.html") {
        if (actionForm == "U") {
          llenarTipoDoc();
          llenarDatosIncidencia();
          llenarListadoPeritos();
        } else {
          $("#btn_search_user").css("display", "block");
          $("#btn_search_conductor").css("display", "block");
          let fechaActual = cargarFechaActual();
          console.log(fechaActual);
          $("#fechaRecepcion").val(fechaActual["fecha"]);
          $("#horaRecepcion").val(fechaActual["hora"]);
          fechaRecepcion.max = fechaActual["fecha"];
          fechaInfraccion.max = fechaActual["fecha"];
          fechaExtraccion.max = fechaActual["fecha"];
        }
      }
    },
  });
};

//Cerrar Modal
const cerrarModal = () => {
  modal.style.display = "none";
  modalContent.classList.remove("frm-lg");
  actionForm = "";
  CodigoSearch = "";
};
$("a.closeModal").on("click", (e) => {
  e.preventDefault();
  cerrarModal();
});
/* MODAL MENSAJE ALERT */
const msgAlert = (icono, titulo, texto) => {
  Swal.fire({
    position: "top-end",
    icon: icono,
    title: titulo,
    text: texto,
    showConfirmButton: false,
    timer: 2000,
  });
};
/* BOTÓN CERRAR SESIÓN*/
btnOff.addEventListener("click", async () => {
  let datos = new FormData();
  datos.append("accion", "LOGOUT");
  let respuesta = await postData(datos, "controllerPersona.php");
  if (respuesta.respuesta == "logout") window.location.assign("login.php");
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
  actionForm = "R";
  llenarListadoPeritos();
  llenarListadoExtractores();
  llenarListadoComisarias();
  llenarTipoDoc();
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
const lnkReporteDiario = document.querySelector("#lnk-reporteDiario");
const lnkReporteMensual = document.querySelector("#lnk-reporteMensual");
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
lnkReporteDiario.addEventListener("click", (e) => loadView(e, lnkReporteDiario));
lnkReporteMensual.addEventListener("click", (e) => loadView(e, lnkReporteMensual));
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
  } else
    msgAlert(
      "error",
      "Usuario ya registrado",
      `Ya existe un registro con el número de DNI ${nroDoc}`
    );
  $("#btn_search_personal").html('<img src="resources/img/icon-search.svg">');
});

/* ----------- VALIDACIONES -------------------------- */
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
  let resCualitativo =
    tipoProc == "C"
      ? "T/S/M"
      : tipoProc == "I"
        ? "N"
        : tipoProc == "S"
          ? "N"
          : tipoProc == "AD"
            ? "A/D"
            : "";
  let resCuantitativo = (tipoProc === "E") ? "" : (tipoProc === "AD") ? "0.00" : tipoProc;
  let textoLabelFecha =
    tipoProc !== "E" ? "Fecha Constatación" : "Fecha Extracción";
  let textoLabelHora =
    tipoProc !== "E" ? "Hora Constatación" : "Hora Extracción";

  let htmlTipoMuestra =
    (tipoProc == "E" || tipoProc == "AD")
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
  if (tipoProc == 'C' || tipoProc == 'AD') $('#lugarComision').css('display', 'block');
  else $('#lugarComision').css('display', 'none')

  $("#cuantitativo").val(resCuantitativo);
  $("#cualitativo").val(resCualitativo);
  $("#lbl_fechaExtraccion").html(textoLabelFecha);
  $("#lbl_horaExtraccion").html(textoLabelHora);
  $("#tipoMuestra").html(htmlTipoMuestra);
});

/* LOGIN */
async function ListarPersonal() {
  let datos = new FormData();
  datos.append("accion", "LISTAR_PERSONAL");
  let personal = await postData(datos, "controllerPersona.php");

  let listPersonal = personal.map((persona) => {
    let profesion = persona.profesion == "E" ? "EXTRACTOR" : "PERITO";
    let estado =
      persona.estado === "A"
        ? "<i class='fa-solid fa-toggle-on i-green user-status'></i>"
        : "<i class='fa-solid fa-toggle-off i-gray user-status'></i>";
    return `<tr><td>${persona.id_persona}</td><td class='t_left'>${persona.nombre}</td><td>${persona.nro_doc}</td><td>${persona.grado}</td><td>${profesion}</td><td>${persona.perfil}</td><td><i class='fa-solid fa-user-pen edit-user i-blue'></i></td><td>${estado}</td></tr>`;
  });
  let cadenaPersonal = JSON.stringify(listPersonal);
  $("#tb_personal").html(cadenaPersonal);
}
/* FORM PERSONAL */
$(document).on("submit", "#frmPersonal", async (e) => {
  e.preventDefault();
  let form = document.querySelector("#frmPersonal");
  let datos = new FormData(form);
  if (actionForm == "U") {
    datos.append("accion", "UPDATE_PERSONAL");
    datos.append("idPersona", CodigoSearch);
  } else datos.append("accion", "REGISTRAR_PERSONAL");
  let respuesta = await postData(datos, "controllerPersona.php");
  if (respuesta.response === 1) {
    msgAlert("success", "Hecho!", "Se actualizó la información");
    cerrarModal();
    ListarPersonal();
  } else msgAlert("error", "algo salió mal", respuesta.response);
});
/* FRM CAMBIO CONTRASEÑA */
$(document).on("submit", "#frmCambioPass", async (e) => {
  e.preventDefault();
  let passActual = $('#passActual').val();
  let passNueva = $('#passNueva').val();
  if (passActual == '' || passNueva == '') {
    msgAlert("warning", "Ingrese campos necesarios", 'Datos incompletos');
  } else {
    let form = document.querySelector("#frmCambioPass");
    let datos = new FormData(form);
    datos.append("accion", "CAMBIAR_PASS");
    let respuesta = await postData(datos, "controllerPersona.php");
    if (respuesta.response === 1) {
      msgAlert(
        "success",
        "Cambio Existoso",
        "Se realizó el cambio de contraseña"
      );
      cerrarModal();
    } else msgAlert("error", "algo salió mal", respuesta.response);
  }
});

//Form Personal
$(document).on("click", "#btn-nuevo-personal", () => {
  abrirModal("frmPersonal.html");
  actionForm = "R";
});
$(document).on("click", "#tb_personal .edit-user", function (e) {
  e.preventDefault();
  let parent = $(this).closest("table");
  let tr = $(this).closest("tr");
  let codigo = $(tr).find("td").eq(0).html();
  abrirModal("frmPersonal.html");
  actionForm = "U";
  CodigoSearch = codigo;
});

$(document).on("change", "#ChangePass", () => {
  if (document.getElementById("ChangePass").checked) {
    $("#passPersonal").removeClass("input-disabled");
    $("#passPersonal").prop("readonly", false);
  } else {
    $("#passPersonal").addClass("input-disabled");
    $("#passPersonal").prop("readonly", true);
    $("#passPersonal").val("");
  }
});
async function llenarDatosPersonal() {
  $("#btn_search_personal").css("display", "none");
  let datos = new FormData();
  datos.append("accion", "BUSCAR_EMPLEADO");
  datos.append("idPersona", CodigoSearch);
  let respuesta = await postData(datos, "controllerPersona.php");
  let empleado = respuesta[0];
  $("#nroDocPersonal").val(empleado.nro_doc);
  $("#nombrePersonal").val(empleado.nombre);
  $("#gradoPersonal").val(empleado.grado);
  $("#profesionPersonal").val(empleado.profesion);
  $("#perfilPersonal").val(empleado.id_perfil);

  $("#nroDocPersonal").prop("readonly", true);
  $("#nombrePersonal").prop("readonly", true);
  $("#passPersonal").prop("readonly", true);
  $("#passPersonal").addClass("input-disabled");
  $("#cont-changePass").removeClass("n-visible");
}
$(document).on("click", "#tb_personal .user-status", async function (e) {
  e.preventDefault();
  Swal.fire({
    title: "Activar/Inactivar Usuario?",
    text: "¿Desea cambiar estado actual del usuario?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3498db",
    cancelButtonColor: "#d33",
    confirmButtonText: "Continuar",
    cancelButtonText: "Cancelar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      Swal.fire("Hecho!", "Se realizó el cambio de estado", "success");
      let parent = $(this).closest("table");
      let tr = $(this).closest("tr");
      let codigo = $(tr).find("td").eq(0).html();
      let datos = new FormData();
      datos.append("accion", "UPDATE_ESTADO");
      datos.append("idPersona", codigo);
      let respuesta = await postData(datos, "controllerPersona.php");
      if (respuesta !== "fail") ListarPersonal();
    }
  });
});
/* INCIDENCIA */
$(document).on("submit", "#frmHojaRegistro", async (e) => {
  e.preventDefault();
  let form = document.querySelector("#frmHojaRegistro");
  let datos = new FormData(form);
  if (actionForm === "U") {
    datos.append("accion", "REGISTRAR_PERITAJE");
    datos.append("idInfraccion", CodigoSearch);
  } else datos.append("accion", "REGISTRAR_INCIDENCIA");
  let respuesta = await postData(datos, "controllerIncidencia.php");
  respuesta = respuesta.response;
  console.log(respuesta);
  if (respuesta !== 0) {
    msgAlert("success", "Hecho", "Se registró la información");
    listarIncidencias();
    if (actionForm == "R") PDFHojaRegistro(respuesta);
    cerrarModal();
  } else
    msgAlert("error", "Algo salió mal", "No se pudo registrar la información");
});

/* INCIDENCIAS */

async function listarIncidencias() {
  let datos = new FormData();
  datos.append("accion", "LISTAR_INCIDENCIAS");
  let incidencias = await postData(datos, "controllerIncidencia.php");
  $("#tb_incidencias").html(incidencias.listado);
}
/* REG PERITAJE */
$(document).on("click", "#tb_incidencias .btnRegPeritaje", async function (e) {
  e.preventDefault();
  let parent = $(this).closest("table");
  let tr = $(this).closest("tr");
  let codigo = $(tr).find("td").eq(0).html();
  modalContent.classList.add("frm-lg");
  abrirModal("frmNuevoRegistro.html");
  actionForm = "U";
  CodigoSearch = codigo;
});
async function llenarDatosIncidencia() {
  $("#btn_search_user").css("display", "none");
  $("#btn_search_conductor").css("display", "none");
  let datos = new FormData();
  datos.append("accion", "BUSCAR_INFRACCION");
  datos.append("idInfraccion", CodigoSearch);
  let respuesta = await postData(datos, "controllerIncidencia.php");
  let infraccion = respuesta.infraccion[0];
  let extraccion = respuesta.extraccion;
  console.log(infraccion);
  console.log(extraccion);

  $("#nombre").val(infraccion.infractor);
  $("#comisaria").val(infraccion.comisaria);
  $("#nroDoc").val(infraccion.nro_doc);
  $("#nroOficio").val(infraccion.n_oficio);
  $("#fechaRecepcion").val(infraccion.fecha_recepcion);
  $("#horaRecepcion").val(infraccion.hora_recepcion);
  $("#edad").val(infraccion.edad);
  $("#vehiculo").val(infraccion.vehiculo);
  $("#placa").val(infraccion.placa);
  $("#clase").val(infraccion.clase);
  $("#licConducir").val(infraccion.lic_conducir);
  $("#sexo").val(infraccion.sexo);
  $("#motivo").val(infraccion.Motivo);
  $("#fechaInfraccion").val(infraccion.fecha_infr);
  $("#horaInfraccion").val(infraccion.hora_infr);
  $("#nombreConductor").val(infraccion.conductor);
  $("#gradoConductor").val(infraccion.grado);
  $("#nroDocConductor").val(infraccion.docConductor);
  $("#nacionalidad").val(infraccion.nacionalidad);
  $("#tipoDoc").val(infraccion.id_tipodoc);
  $("#hojaRegistro").val(infraccion.hoja_registro);

  let htmlTipoMuestra =
    extraccion.tipo_muestra !== "N"
      ? `<option value=" 0">Tipo Muestra</option><option value="S">Sangre</option><option value="O">Orina</option>`
      : `<option value="N">Sin Muestra</option>`;
  $("#tipoMuestra").html(htmlTipoMuestra);

  $("#tipoMuestra").val(extraccion.tipo_muestra);
  $("#extractor").val(extraccion.extractor);
  $("#fechaExtraccion").val(extraccion.fecha_extracc);
  $("#horaExtraccion").val(extraccion.hora_extracc);
  $("#observacion").val(extraccion.observacion);
}
function PDFHojaRegistro(idInfraccion) {
  var ancho = 1000;
  var alto = 800;
  var x = parseInt(window.screen.width / 2 - ancho / 2);
  var y = parseInt(window.screen.height / 2 - alto / 2);

  $url = `resources/libraries/pdf/PDFhojaregistro.php?IdHojaRegistro=${idInfraccion}`;
  window.open(
    $url,
    "Comprobante",
    `left=${x} ,top=${y},height= ${alto}, width= ${ancho},scrollbar=si,location=no,resizable=si,menubar=no`
  );
}
$(document).on("click", "#tb_incidencias .btnUpdateCertificado", function (e) {
  e.preventDefault();
  Swal.fire({
    title: "Desea anular los cerfiticados anteriores y registrar uno nuevo?",
    text: "esta operación no puede ser revertida",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#46aef7",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Continuar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      let parent = $(this).closest("table");
      let tr = $(this).closest("tr");
      let codigo = $(tr).find("td").eq(0).html();
      abrirModal("frmNewCertificado.html");
      actionForm = "U";
      CodigoSearch = codigo;
    }
  });
});
$(document).on("click", "#tb_incidencias .btnRegCertificado", function (e) {
  e.preventDefault();
  let parent = $(this).closest("table");
  let tr = $(this).closest("tr");
  let codigo = $(tr).find("td").eq(0).html();
  abrirModal("frmNewCertificado.html");
  actionForm = "R";
  CodigoSearch = codigo;
});
$(document).on("submit", "#frmNewCertificado", async (e) => {
  e.preventDefault();
  let form = document.querySelector("#frmNewCertificado");
  let datos = new FormData(form);
  datos.append("accion", "REGISTRAR_CERTIFICADO");
  datos.append("idInfraccion", CodigoSearch);
  let respuesta = await postData(datos, "controllerIncidencia.php");
  respuesta = respuesta.response;
  console.log(respuesta);
  if (respuesta !== 0) {
    msgAlert("success", "Hecho", "Se registró la información");
    listarIncidencias();
    cerrarModal();
  } else
    msgAlert("error", "Algo salió mal", "No se pudo registrar la información");
});

$(document).on("click", "#tb_incidencias .lnkCertificado", function (e) {
  e.preventDefault();
  let parent = $(this).closest("table");
  let tr = $(this).closest("tr");
  let codigo = $(tr).find("td").eq(0).html();
  PDFCertificado(codigo);
});
function PDFCertificado(idInfraccion) {
  var ancho = 1000;
  var alto = 800;
  var x = parseInt(window.screen.width / 2 - ancho / 2);
  var y = parseInt(window.screen.height / 2 - alto / 2);

  $url = `resources/libraries/pdf/PDFcertificado.php?idInfraccion=${idInfraccion}`;
  window.open(
    $url,
    "Comprobante",
    `left=${x} ,top=${y},height= ${alto}, width= ${ancho},scrollbar=si,location=no,resizable=si,menubar=no`
  );
}
$(document).on("click", "#btn-reporteDiario", async function (e) {
  e.preventDefault();
  let fecha = $('#repFecha').val();
  let turno = $('#repTurno').val();
  if (fecha === '' || turno === '0')
    msgAlert('warning', 'Seleccione fecha y turno porfavor', 'Campos necesarios')
  else {
    let datos = new FormData();
    datos.append("accion", "REPORTE_RESULTADOS");
    datos.append("fechaInicio", fecha);
    datos.append("turno", turno);
    let respuesta = await postData(datos, "controllerIncidencia.php");
    //console.log(respuesta);
    let html = respuesta.data;
    $('#tbReporte').html(html);
    if (respuesta.response == 1) {
      let datos = new FormData();
      datos.append("accion", "PERSONAL_TURNO");
      datos.append("fechaInicio", fecha);
      datos.append("turno", turno);
      let respuesta = await postData(datos, "controllerIncidencia.php");
      html = respuesta.data;
      $('#t_PersonalTurno').html(html)
    } else $('#t_PersonalTurno').html('')
  }
});
function PDFReporteDiario() {
  let fecha = $('#repFecha').val();
  let turno = $('#repTurno').val();
  var ancho = 1000;
  var alto = 800;
  var x = parseInt(window.screen.width / 2 - ancho / 2);
  var y = parseInt(window.screen.height / 2 - alto / 2);

  $url = `resources/libraries/pdf/PDFreporteDiario.php?fechaInicio=${fecha}&turno=${turno}`;
  window.open(
    $url,
    "Comprobante",
    `left=${x} ,top=${y},height= ${alto}, width= ${ancho},scrollbar=si,location=no,resizable=si,menubar=no`
  );
}
$(document).on("click", "#btnImprmirReporte", async function (e) {
  let fecha = $('#repFecha').val();
  let turno = $('#repTurno').val();
  if (fecha === '' || turno === '')
    msgAlert('warning', 'Seleccione fecha y turno porfavor', 'Campos necesarios')
  else
    PDFReporteDiario();
});
$(document).on("click", "#btn-reporteMensual", async function (e) {
  e.preventDefault();
  let fecha = $('#repFechaInicio').val();
  alert(fecha)
});
$(document).on("keyup", "#searchInfraccion", async function (e) {
  e.preventDefault();
  let datoSearch = $('#searchInfraccion').val();
  let datos = new FormData();
  datos.append("accion", "LISTAR_INCIDENCIAS");
  datos.append("datoSearch", datoSearch);
  let incidencias = await postData(datos, "controllerIncidencia.php");
  $("#tb_incidencias").html(incidencias.listado);
});