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

$nroDocInfractor = '48193845'; // Usuario infractor
$tipoDoc = 7;
//$nroDocInfractor = '48193845'; // Usuario infractor

$infractor = $objPersona->BuscarUsuario($tipoDoc, $nroDocInfractor);
if ($infractor->rowCount() > 0) {
    $infractor = $infractor->fetch(PDO::FETCH_OBJ);
    $idInfractor = $infractor->id_persona;
    $data = [
        'edad' => 25,
        'lic_conducir' => '-',
        'id_persona' => $idInfractor
    ];
    $objPersona->ActualizarDatosPersona($data);
} else {
    $data = [
        'id_tipodoc' => 7,
        'nro_doc' => '48193845',
        'nombre' => 'CÉSAR JOSUÉ SILVA AGUILAR',
        'edad' => 28,
        'sexo' => 'M',
        'lic_conducir' => '-',
        'nacionalidad' => 'Peruano',
    ];
    $idInfractor = $objPersona->RegistrarInfractor($data);
}
echo $idInfractor;
//$dataUsuario = ['id_infractor' => $idinfractor];
//echo json_encode($dataUsuario);
/*
Si existe -> actualizar
si no existe -> registrar
*/
