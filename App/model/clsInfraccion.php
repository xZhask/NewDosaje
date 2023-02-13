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
    function ListarInfracciones()
    {
        $sql = 'SELECT i.id_infraccion, i.hoja_registro, i.Motivo, i.fecha_infr, i.hora_infr, i.vehiculo, i.clase, i.placa, i.n_oficio, c.comisaria, i.hora_registro, i.fecha_registro, u.nombre as infractor, d.nombre as digitador, pc.nombre as conductor, i.lugar_incidencia, i.n_certificado, u.nro_doc,u.edad, u.sexo, u.lic_conducir FROM infraccion i INNER JOIN comandancia c ON i.id_comandancia=c.id_comandancia INNER JOIN persona u ON i.infractor=u.id_persona INNER JOIN persona d ON i.digitador=d.id_persona INNER JOIN persona pc ON i.personal_conductor=pc.id_persona';
        global $cnx;
        return $cnx->query($sql);
    }
    function buscarExtraccion($idInfraccion)
    {
        $sql = 'SELECT e.tipo_muestra, e.hora_extracc, e.fecha_extracc, e.hrs_transcurridas,p.grado, p.nombre as extractor, e.observacion
        FROM extraccion e INNER JOIN persona p ON e.extractor=p.id_persona WHERE e.id_infraccion=:id_infraccion';
        global $cnx;
        $parametros = [
            ':id_infraccion' => $idInfraccion,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function buscarPeritaje($idInfraccion)
    {
        $sql = 'SELECT result_cualitativo as cualitativo, result_cuantitativo as cuantitativo, perito FROM peritaje WHERE id_infraccion=:id_infraccion';
        global $cnx;
        $parametros = [
            ':id_infraccion' => $idInfraccion,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function buscarInfraccion($idInfraccion)
    {
        $sql = 'SELECT i.id_infraccion, i.hoja_registro, i.Motivo, i.fecha_infr, i.hora_infr, i.vehiculo, i.clase, i.placa, i.n_oficio, c.comisaria, i.hora_registro, i.fecha_registro, u.nombre as infractor, d.nombre as digitador, pc.nombre as conductor, pc.grado, pc.nro_doc as docConductor, i.lugar_incidencia, i.n_certificado, u.id_tipodoc,td.tipo_doc, u.nacionalidad, u.nro_doc,u.edad, u.sexo, u.lic_conducir FROM infraccion i INNER JOIN comandancia c ON i.id_comandancia=c.id_comandancia INNER JOIN persona u ON i.infractor=u.id_persona INNER JOIN persona d ON i.digitador=d.id_persona INNER JOIN persona pc ON i.personal_conductor=pc.id_persona INNER JOIN tipo_documento td ON td.id_tipodoc=u.id_tipodoc WHERE i.id_infraccion=:id_infraccion';
        global $cnx;
        $parametros = [
            ':id_infraccion' => $idInfraccion,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function buscarCertificados($idInfraccion)
    {
        $sql = 'SELECT n_serie,n_certificado,estado FROM certificado WHERE id_infraccion=:id_infraccion';
        global $cnx;
        $parametros = [
            ':id_infraccion' => $idInfraccion,
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function RegistrarCertificado($DatosCertificado)
    {
        $sql = 'INSERT INTO certificado(id_infraccion, n_certificado, n_serie, estado) VALUES (:id_infraccion, :n_certificado, :n_serie, :estado)';

        $parametros = [
            ':n_certificado' => $DatosCertificado['n_certificado'],
            ':n_serie' => $DatosCertificado['n_serie'],
            ':estado' => 'A',
            ':id_infraccion' => $DatosCertificado['id_infraccion'],
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre->rowCount();
    }
    function AnularCertificados($idIfraccion)
    {
        $sql = 'UPDATE certificado SET estado=:estado WHERE id_infraccion=:id_infraccion';

        $parametros = [
            ':estado' => 'I',
            ':id_infraccion' => $idIfraccion,
        ];
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre->rowCount();
    }
    /* REPORTES */
    function reporteResultados()
    {
        $sql = 'SELECT * FROM peritaje';
        global $cnx;
        return $cnx->query($sql);
    }
}
