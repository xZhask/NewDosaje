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

$nroDocPersonal = '06948422'; // Usuario Conductor
$tipoDocPersonal = 7; // COD DNI EN LA BD
/* CONDUCTOR */
$Persona = $objPersona->BuscarUsuario($tipoDocPersonal, $nroDocPersonal);
if ($Persona->rowCount() > 0) {
    $respuesta = 'fail';
} else {
    if (!empty($nroDocPersonal)) {
        $data = [
            'id_tipodoc' => $tipoDocPersonal,
            'nro_doc' => $nroDocPersonal,
            'nombre' => 'MIAU',
            'grado' => 'SS PNP',
            'nacionalidad' => 'Peruana',
        ];
        $idPersona = $objPersona->RegistrarConductor($data);
        $pass = '123';
        $pass = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 7]);

        $datosUser = [
            'id_persona' => $idPersona,
            'pass' => $pass,
            'profesion' => 'E',
            'id_perfil' => '2',
        ];
        $idPersonal = $objPersona->RegistrarUsuario($datosUser);
        $respuesta = $datosUser;
    } else
        $respuesta = 'fail';
}
$response = ['response' => $respuesta];
echo json_encode($response);
//$dataUsuario = ['id_infractor' => $idinfractor];
//echo json_encode($dataUsuario);
/*
Si existe -> actualizar
si no existe -> registrar
*/
