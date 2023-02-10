<?php
/*require_once 'App/model/clsComisaria.php';
$objComisaria = new ClsComisaria();
$comisarias = $objComisaria->listarComisarias();
$comisarias = $comisarias->fetchAll(PDO::FETCH_OBJ);
echo json_encode($comisarias);
 */
/*
fetch('prueba.php',{
    method:"POST",
    body: JSON.stringify({"nombre":"Josué","apellido":"Silva Aguilar"}),
    headers:{'Content-Type': 'application/json'}
})
.then(res=>res.text())
.then(res=>console.log(res));
*/
require_once 'App/model/clsPersona.php';
require_once 'App/model/clsInfraccion.php';

$objPersona = new ClsPersona();
$objInfraccion = new ClsInfraccion();

$id_infraccion = 7;
$peritaje = $objInfraccion->buscarInfraccion($id_infraccion);
$cualitativo = '';
$perito = '';
$cuantitativo = '';
if ($peritaje->rowCount() > 0) {
    $peritaje = $peritaje->fetch(PDO::FETCH_NAMED);
    $perito = $peritaje['perito'];
    if ($perito != NULL) {
        $busquedaPerito = $objPersona->BuscarPersonal($perito);
        $busquedaPerito = $busquedaPerito->fetch(PDO::FETCH_NAMED);
        $perito = $busquedaPerito['nombre'];
    }

    $cualitativo = $peritaje['cualitativo'];
    $cuantitativo = $peritaje['cuantitativo'];
}
echo $cualitativo . ' - ' . $cuantitativo . ' - ' . $perito;
//
/* $perito = '';
if ($peritaje->rowCount() > 0) {
    $peritaje = $peritaje->fetch(PDO::FETCH_NAMED);
    $perito = $peritaje['perito'];
} */
//echo json_encode($peritaje);
