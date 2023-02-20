<?php
require_once '../../../App/model/clsInfraccion.php';
require_once '../../../App/model/clsPersona.php';
include 'numerosLetras.php';

function getPlantilla($idInfraccion)
{
    $objIncidencia = new clsInfraccion();
    $objPersona = new clsPersona();

    $infraccion = $objIncidencia->buscarInfraccion($idInfraccion);
    $infraccion = $infraccion->fetch(PDO::FETCH_NAMED);

    $extraccion = $objIncidencia->buscarExtraccion($idInfraccion);
    $extraccion = $extraccion->fetch(PDO::FETCH_NAMED);

    $Peritaje = $objIncidencia->buscarPeritaje($idInfraccion);
    $Peritaje = $Peritaje->fetch(PDO::FETCH_NAMED);
    $perito = $Peritaje['perito'];
    $perito = '-';
    $gradoPerito = '-';
    $docPerito = '-';
    if ($perito != NULL) {
        $busquedaPerito = $objPersona->BuscarPersonal($perito);
        $busquedaPerito = $busquedaPerito->fetch(PDO::FETCH_NAMED);
        $perito = $busquedaPerito['nombre'];
        $gradoPerito = $busquedaPerito['grado'];
        $docPerito = $busquedaPerito['nro_doc'];
    }

    $cuantitativo = $Peritaje['cuantitativo'];
    $cualitativo = $Peritaje['cualitativo'];


    if ($cuantitativo > 0) {
        $conclusion = 'LA MUESTRA CONTIENE ALCOHOL';
        $letras = numerosLetras($cuantitativo);
    } else if ($cuantitativo === 0) {
        $conclusion = 'LA MUESTRA NO CONTIENE ALCOHOL';
        $letras = numerosLetras($cuantitativo);
    } else {
        $conclusion = '------';
    }


    $sexo = $infraccion['sexo'];
    $fecha = $infraccion['fecha_registro'] . ' ' . $infraccion['hora_registro'];
    $dia = date("d", strtotime($fecha));
    $mes = date("m", strtotime($fecha));
    $year = date("Y", strtotime($fecha));
    $hora = date("h:i", strtotime($fecha));
    if ($sexo === 'M') {
        $sexo = '(MASCULINO)';
    } else {
        $sexo = '(FEMENINO)';
    }
    $fecha_actual = date('Y/m/d H:i:s');
    $Muestra = $extraccion['tipo_muestra'];
    if ($Muestra === 'S') {
        $textoMuestra = 'VIAL CONTENIENDO MUESTRA DE SANGRE OXALATADA DEBIDAMENTE SELLADA Y ETIQUETADA';
    } else if ($Muestra === 'O') {
        $textoMuestra = 'VIAL CONTENIENDO MUESTRA DE ORINA <br> .';
    } else {
        $textoMuestra = 'SIN MUESTRA <br> .';
    }

    if ($cuantitativo === 'T/S/M') {
        $textoConstata = 'CONSTATACIÓN REALIZADA A LAS';
        $textoMetodo = '----------';
        $conclusion = '----------';
    } else {
        $textoConstata = '-';
        $textoMetodo = 'SHEFTEL MODIFICADO PARA FOTO COLORIMETRÍA';
    }
    $plantilla = '<body><div class="Certificado">
        <p class="nombreCert txtbold">' . $infraccion['infractor'] . '</p>
        <table class="filaCertificado EdadCert">
            <tr><td class="edadInfCert">' . $infraccion['edad'] . ' AÑOS </td><td>' . $sexo . '</td></tr>
        </table>
        <p>' . $infraccion['tipo_doc'] . ' N° ' . $infraccion['nro_doc'] . '</p>
        <table class="filaCertificado LicenciaCert">
            <tr><td class="licenciaCert">' . $infraccion['lic_conducir'] . '</td><td>' . $infraccion['clase'] . '</td></tr>
        </table>
        <table class="filaCertificado vehiculoCert">
            <tr><td class="vehCert">' . $infraccion['vehiculo'] . '</td><td>' . $infraccion['placa'] . '</td></tr>
        </table>
        <p>' . $infraccion['comisaria'] . '</p>
        <p class="oficioCert"> Of. N° ' . $infraccion['n_oficio'] . '-' . $year . ' RECEPCIONADO A LAS ' . $hora . '</p>
        <p class="fecharecepCert"> DEL ' . $dia . '-' . $mes . '-' . $year . '</p>
        <p class="motivoCert">' . $infraccion['Motivo'] . '</p>
        <p class="conductorCert">' . $infraccion['grado'] . ' ' . $infraccion['conductor'] . '</p>
        <p class="DatosInfCert">' . $infraccion['hora_infr'] . ' Horas del ' . date("d-m-Y", strtotime($infraccion['fecha_infr'])) . '</p>';
    $plantilla .= '<p class="textoConstata">' . $textoConstata . '</p>';

    $plantilla .= '<p class="DatosExtCert">' . $extraccion['hora_extracc'] . ' Horas del ' . date("d-m-Y", strtotime($extraccion['fecha_extracc'])) . '</p>
        <p class="ExtractorCert">' . $extraccion['grado'] . ' ' . $extraccion['extractor'] . '</p>
        <p class="TipoMuestraCert">' . $textoMuestra . '</p>
        <p class="MetodoCert"> ' . $textoMetodo . ' </p>';
    $plantilla .= '<p class="PeritoCert">' . $perito . '</p>
        <table class="filaCertificado P$PeritajeCert">
            <tr><td class="gradoPeritoCert">' . $gradoPerito . '</td><td>' . $docPerito . '</td></tr>
        </table>';
    if ($cuantitativo === 'T/S/M') {
        $plantilla .= '<p class="HorasTransCert">-------------------</p>';
    } else {
        $plantilla .= '<p class="HorasTransCert">MUESTRA EXTRAÍDA DESPUÉS DE: ' . $extraccion['hrs_transcurridas'] . ' HORAS' . '</p>';
    }
    $plantilla .= '<p class="ObsCert">' . $extraccion['observacion'] . '</p>
        <p class="ResultCuantCert">' . $cuantitativo . ' g/L</p>';
    if ($cuantitativo === 'T/S/M') {
        $plantilla .= '<p class="letrasCert">CONSTATACIÓN</p>';
    } else {
        $plantilla .= '<p class="letrasCert">' . $letras . '</p>';
    }
    $plantilla .= '<p class="conclusionCert">' . $conclusion . '</p>
        <p class="fechaactualCert">' . date("d-m-Y", strtotime($fecha_actual)) . '</p>';

    $plantilla .= '</div></body>';
    return $plantilla;
}
