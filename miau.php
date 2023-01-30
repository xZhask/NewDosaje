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

$nroDocInfractor = '28267676'; // Usuario infractor
//$nroDocInfractor = '48193845'; // Usuario infractor

$infractor = $objPersona->BuscarUsuario($nroDocInfractor);
if ($infractor->rowCount() > 0) {
    $infractor = $infractor->fetch(PDO::FETCH_OBJ);
    echo 'Encontrado id: ' . json_encode($infractor->id_persona);
} else
    echo 'No encontrado pipipi';

//echo json_encode($infractor);
