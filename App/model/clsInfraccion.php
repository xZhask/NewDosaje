<?php
require_once 'conexion.php';
class clsInfraccion
{
    function RegistrarInfraccion($DatosInfraccion)
    {
        $sql = 'INSERT INTO infraccion(hoja_registro, Motivo, fecha_infr, hora_infr, vehiculo, clase, placa, n_oficio, id_comandancia, hora_recepcion, fecha_recepcion, infractor, digitador, personal_conductor, lugar_incidencia) VALUES (:hoja_registro, :Motivo, :fecha_infr, :hora_infr, :vehiculo, :clase, :placa, :n_oficio, :id_comandancia, :hora_recepcion, :fecha_recepcion, :infractor, :digitador, :personal_conductor, :lugar_incidencia)';

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
            ':hora_recepcion' => $DatosInfraccion['hora_recepcion'],
            ':fecha_recepcion' => $DatosInfraccion['fecha_recepcion'],
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
        $sql = 'SELECT i.id_infraccion, i.hoja_registro, i.Motivo, i.fecha_infr, i.hora_infr, i.vehiculo, i.clase, i.placa, i.n_oficio, c.comisaria, i.hora_recepcion, i.fecha_recepcion, u.nombre as infractor, d.nombre as digitador, pc.nombre as conductor, i.lugar_incidencia, u.nro_doc,u.edad, u.sexo, u.lic_conducir FROM infraccion i INNER JOIN comandancia c ON i.id_comandancia=c.id_comandancia INNER JOIN persona u ON i.infractor=u.id_persona INNER JOIN persona d ON i.digitador=d.id_persona INNER JOIN persona pc ON i.personal_conductor=pc.id_persona ORDER BY CONCAT(i.fecha_recepcion," ",i.hora_recepcion) DESC LIMIT 10';
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
        $sql = 'SELECT i.id_infraccion, i.hoja_registro, i.Motivo, i.fecha_infr, i.hora_infr, i.vehiculo, i.clase, i.placa, i.n_oficio, c.comisaria, i.hora_recepcion, i.fecha_recepcion, u.nombre as infractor, d.nombre as digitador, pc.nombre as conductor, pc.grado, pc.nro_doc as docConductor, i.lugar_incidencia, u.id_tipodoc,td.tipo_doc, u.nacionalidad, u.nro_doc,u.edad, u.sexo, u.lic_conducir FROM infraccion i INNER JOIN comandancia c ON i.id_comandancia=c.id_comandancia INNER JOIN persona u ON i.infractor=u.id_persona INNER JOIN persona d ON i.digitador=d.id_persona INNER JOIN persona pc ON i.personal_conductor=pc.id_persona INNER JOIN tipo_documento td ON td.id_tipodoc=u.id_tipodoc WHERE i.id_infraccion=:id_infraccion';
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
    function reporteMuestras($datosReporte)
    {
        $sql = 'SELECT id_infraccion FROM infraccion WHERE (fecha_recepcion>=:fechaInicio AND hora_recepcion>=:horaInicio) AND (fecha_recepcion<=:fechaFin AND hora_recepcion<=:horaFin)';
        global $cnx;
        $parametros = [
            ':fechaInicio' => $datosReporte['fechaInicio'],
            ':horaInicio' => $datosReporte['horaInicio'],
            ':fechaFin' => $datosReporte['fechaFin'],
            ':horaFin' => $datosReporte['horaFin'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function reporteInfracciones($datosReporte)
    {
        $sql = 'SELECT i.id_infraccion,i.hoja_registro,i.Motivo,i.fecha_infr,i.hora_infr,i.vehiculo,i.clase,i.placa,i.n_oficio,i.hora_recepcion,i.fecha_recepcion,i.fecha_registro, inf.nombre as infractor,inf.nro_doc,inf.edad,inf.sexo,inf.lic_conducir,inf.id_tipodoc,cond.nombre as nombreConductor,cond.grado as gradoConductor, d.nombre as digitador,com.comisaria FROM infraccion i INNER JOIN persona inf ON inf.id_persona=i.infractor INNER JOIN persona cond ON cond.id_persona=i.personal_conductor INNER JOIN persona d ON d.id_persona=i.digitador INNER JOIN comandancia com ON com.id_comandancia=i.id_comandancia WHERE (fecha_recepcion>=:fechaInicio AND hora_recepcion>=:horaInicio) AND (fecha_recepcion<=:fechaFin AND hora_recepcion<=:horaFin)';
        global $cnx;
        $parametros = [
            ':fechaInicio' => $datosReporte['fechaInicio'],
            ':horaInicio' => $datosReporte['horaInicio'],
            ':fechaFin' => $datosReporte['fechaFin'],
            ':horaFin' => $datosReporte['horaFin'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function reporteResultados($datosReporte)
    {
        $sql = 'SELECT i.id_infraccion,pj.result_cualitativo,pj.result_cuantitativo FROM infraccion i INNER JOIN peritaje pj ON i.id_infraccion=pj.id_infraccion WHERE (fecha_recepcion>=:fechaInicio AND hora_recepcion>=:horaInicio)AND(fecha_recepcion<=:fechaFin AND hora_recepcion<=:horaFin)';
        global $cnx;
        $parametros = [
            ':fechaInicio' => $datosReporte['fechaInicio'],
            ':horaInicio' => $datosReporte['horaInicio'],
            ':fechaFin' => $datosReporte['fechaFin'],
            ':horaFin' => $datosReporte['horaFin'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function filtrarInfraccionUsuario($datoUsuario)
    {
        $sql = 'SELECT i.id_infraccion, i.hoja_registro, i.Motivo, i.fecha_infr, i.hora_infr, i.vehiculo, i.clase, i.placa, i.n_oficio, c.comisaria, i.hora_recepcion, i.fecha_recepcion, u.nombre as infractor, d.nombre as digitador, pc.nombre as conductor, i.lugar_incidencia, u.nro_doc,u.edad, u.sexo, u.lic_conducir FROM infraccion i INNER JOIN comandancia c ON i.id_comandancia=c.id_comandancia INNER JOIN persona u ON i.infractor=u.id_persona INNER JOIN persona d ON i.digitador=d.id_persona INNER JOIN persona pc ON i.personal_conductor=pc.id_persona WHERE u.nombre LIKE :nombre ORDER BY CONCAT(i.fecha_recepcion," ",i.hora_recepcion) DESC';
        global $cnx;
        $parametros = [
            ':nombre' => '%' . $datoUsuario . '%',
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function extractoresPorTurno($fechas)
    {
        $sql = 'SELECT p.nombre FROM extraccion e INNER JOIN infraccion i ON e.id_infraccion=i.id_infraccion INNER JOIN persona p ON p.id_persona=e.extractor WHERE (i.fecha_recepcion >=:fechaInicio AND i.hora_recepcion>=:horaInicio) AND (i.fecha_recepcion <=:fechaFin AND i.hora_recepcion<=:horaFin) GROUP BY p.nombre';
        global $cnx;
        $parametros = [
            ':fechaInicio' => $fechas['fechaInicio'],
            ':horaInicio' => $fechas['horaInicio'],
            ':fechaFin' => $fechas['fechaFin'],
            ':horaFin' => $fechas['horaFin'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function peritosPorTurno($fechas)
    {
        $sql = 'SELECT p.nombre FROM peritaje pj  INNER JOIN infraccion i ON pj.id_infraccion=i.id_infraccion INNER JOIN persona p ON pj.perito=p.id_persona WHERE (i.fecha_recepcion >=:fechaInicio AND i.hora_recepcion>=:horaInicio) AND (i.fecha_recepcion <=:fechaFin AND i.hora_recepcion<=:horaFin) GROUP BY p.nombre';
        global $cnx;
        $parametros = [
            ':fechaInicio' => $fechas['fechaInicio'],
            ':horaInicio' => $fechas['horaInicio'],
            ':fechaFin' => $fechas['fechaFin'],
            ':horaFin' => $fechas['horaFin'],
        ];
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}
/*
SELECT p.nombre FROM peritaje pj  INNER JOIN infraccion i ON pj.id_infraccion=i.id_infraccion INNER JOIN persona p ON pj.perito=p.id_persona WHERE (i.fecha_recepcion >=:fechaInicio AND i.hora_recepcion>=:horaInicio) AND (i.fecha_recepcion <=:fechaFin AND i.hora_recepcion<=:horaFin) GROUP BY p.nombre
*/