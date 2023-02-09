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

$objPersona = new ClsPersona();
$id_infraccion = null;
$dataExtraccion = [
    'id_infraccion' =>  $id_infraccion,
    'tipoMuestra' =>  $_POST['tipoMuestra'],
    'idExtractor' =>  $_POST['idExtractor'],
    'fechaExtraccion' =>  $_POST['fechaExtraccion'],
    'horaExtraccion' =>  $_POST['horaExtraccion'],
];
$dataPeritaje = [
    'id_infraccion' =>  $id_infraccion,
    'tipoMuestra' =>  $_POST['tipoMuestra'],
    'idPerito' =>  $_POST['idPerito'],
    'cuantitativo' =>  $_POST['cuantitativo'],
    'cualitativo' =>  $_POST['cualitativo'],
];
echo json_encode($dataIncidencia);
