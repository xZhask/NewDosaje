/* LOGIN */

async function postData(data, url) {
  const response = await fetch(`App/controller/${url}`, {
    method: "POST",
    body: data,
  }).then((res) => res.text());
  return await response;
}

$(document).on("submit", "#frmlogin", async (e) => {
  e.preventDefault();
  let form = document.querySelector("#frmlogin");
  let datos = new FormData(form);
  datos.append("accion", "LOGIN");
  let respuesta = await postData(datos, "controllerPersona.php");
  if (respuesta === "OK") window.location.assign("index.php");
  else alert("DATOS INCORRECTOS");
});
