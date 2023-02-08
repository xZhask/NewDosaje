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

session_start();
$passActual = '123';
$passNueva = '0410';
$datosLogin = $objPersona->ValidarLogin($_SESSION['nroDoc']);
if ($datosLogin->rowCount() > 0) {
    $datosLogin = $datosLogin->fetch(PDO::FETCH_OBJ);
    $userPass = $datosLogin->pass;
    if (password_verify($passActual, $userPass)) {
        $passNueva = password_hash($passNueva, PASSWORD_DEFAULT, ['cost' => 7]);
        $datos = [
            'id_persona' => $_SESSION['iduser'],
            'pass' => $passNueva,
        ];
        $respuesta = $objPersona->UpdatePass($datos);
    } else
        $respuesta = 'Contraseña Incorrecta';
    $response = ['response' => $respuesta];
    echo json_encode($response);
}
