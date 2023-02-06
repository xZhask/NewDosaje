<?php
require_once 'conexion.php';

function RegistrarInfractor($DatosInfraccion)
{
    $sql = 'INSERT INTO infraccion(hoja_registro, Motivo, fecha_infr, hora_infr, vehiculo, clase, placa, n_oficio, id_comandancia, hora_registro, fecha_registro, infractor, digitador, personal_conductor, lugar_incidencia, n_certificado) VALUES (:hoja_registro, :Motivo, :fecha_infr, :hora_infr, :vehiculo, :clase, :placa, :n_oficio, :id_comandancia, :hora_registro, :fecha_registro, :infractor, :digitador, :personal_conductor, :lugar_incidencia, :n_certificado)';

    $parametros = [
        ':hoja_registro' => $DatosInfraccion['hoja_registro'],
        ':Motivo' => $DatosInfraccion['Motivo'],
        ':fecha_infr' => $DatosInfraccion['fecha_infr'],
        ':hora_infr' => $DatosInfraccion['hora_infr'],
        ':vehiculo' => $DatosInfraccion['vehiculo'],
        ':clase' => $DatosInfraccion['clase'],
        ':placa' => $DatosInfraccion['placa'],
        ':n_oficio' => $DatosInfraccion['n_oficio'],
        ':id_comandancia' => $DatosInfraccion['id_comandancia'],
        ':hora_registro' => $DatosInfraccion['hora_registro'],
        ':fecha_registro' => $DatosInfraccion['fecha_registro'],
        ':infractor' => $DatosInfraccion['infractor'],
        ':digitador' => $DatosInfraccion['digitador'],
        ':personal_conductor' => $DatosInfraccion['personal_conductor'],
        ':lugar_incidencia' => $DatosInfraccion['lugar_incidencia'],
        ':n_certificad' => $DatosInfraccion['n_certificad']
    ];
    global $cnx;
    $pre = $cnx->prepare($sql);
    $pre->execute($parametros);
    if ($pre->rowCount() > 0) return $cnx->lastInsertId();
}
