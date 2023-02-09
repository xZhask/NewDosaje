<?php
require_once 'conexion.php';
class clsInfraccion
{
    function RegistrarInfraccion($DatosInfraccion)
    {
        $sql = 'INSERT INTO infraccion(hoja_registro, Motivo, fecha_infr, hora_infr, vehiculo, clase, placa, n_oficio, id_comandancia, hora_registro, fecha_registro, infractor, digitador, personal_conductor, lugar_incidencia) VALUES (:hoja_registro, :Motivo, :fecha_infr, :hora_infr, :vehiculo, :clase, :placa, :n_oficio, :id_comandancia, :hora_registro, :fecha_registro, :infractor, :digitador, :personal_conductor, :lugar_incidencia)';

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
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        if ($pre->rowCount() > 0) return $cnx->lastInsertId();
    }
    function RegistrarExtraccion($DatosExtraccion)
    {
        $sql = 'INSERT INTO extraccion(tipo_muestra, hora_extracc, fecha_extracc, hrs_transcurridas, extractor, id_infraccion, observacion) VALUES
        (:tipo_muestra, :hora_extracc, :fecha_extracc, :hrs_transcurridas, :extractor, :id_infraccion, :observacion)';

        $parametros = [
            ':tipo_muestra' => $DatosExtraccion['tipo_muestra'],
            ':hora_extracc' => $DatosExtraccion['hora_extracc'],
            ':fecha_extracc' => $DatosExtraccion['fecha_extracc'],
            ':hrs_transcurridas' => $DatosExtraccion['hrs_transcurridas'],
            ':extractor' => $DatosExtraccion['extractor'],
            ':id_infraccion' => $DatosExtraccion['id_infraccion'],
            ':observacion' => $DatosExtraccion['observacion'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        if ($pre->rowCount() > 0) return $cnx->lastInsertId();
    }
    function RegistrarPeritaje($DatosPeritaje)
    {
        $sql = 'INSERT INTO peritaje(result_cualitativo, result_cuantitativo, perito, id_infraccion) VALUES(:result_cualitativo, :result_cuantitativo, :perito, :id_infraccion)';

        $parametros = [
            ':result_cualitativo' => $DatosPeritaje['result_cualitativo'],
            ':result_cuantitativo' => $DatosPeritaje['result_cuantitativo'],
            ':perito' => $DatosPeritaje['perito'],
            ':id_infraccion' => $DatosPeritaje['id_infraccion'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        if ($pre->rowCount() > 0) return $cnx->lastInsertId();
    }
}
