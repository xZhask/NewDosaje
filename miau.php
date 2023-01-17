<?php
require_once 'App/model/clsComisaria.php';
$objComisaria = new ClsComisaria();
$comisarias = $objComisaria->listarComisarias();
$comisarias = $comisarias->fetchAll(PDO::FETCH_OBJ);
echo json_encode($comisarias);
