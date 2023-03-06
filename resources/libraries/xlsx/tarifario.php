<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

require_once '../../../App/model/clsInfraccion.php';
require_once '../../../App/model/clsPersona.php';
$objInfraccion = new clsInfraccion();
$objPersona = new clsPersona();

$parametrosReporte = [
    'fechaInicio' => $_GET['fechaInicio'],
    'horaInicio' => '00:00:00',
    'fechaFin' => $_GET['fechaFin'],
    'horaFin' => '23:59:59',
];

$estiloHeader = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => '26A69A',
        ],
    ],
];
$estiloBody = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ]
    ],
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ]
];
$estiloCentro = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,

    ]
];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
$spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);
$spreadsheet->getActiveSheet()->mergeCells('A1:D1');
$spreadsheet->getActiveSheet()->getStyle('A2:AC2')->applyFromArray($estiloHeader);
$sheet->getColumnDimension('A')->setWidth(10);
$spreadsheet->getActiveSheet()->getStyle('A')->applyFromArray($estiloCentro);
$spreadsheet->getActiveSheet()->getStyle('B')->applyFromArray($estiloCentro);
$spreadsheet->getActiveSheet()->getStyle('D')->applyFromArray($estiloCentro);
$sheet->setCellValue('A1', 'TARIFARIO PARA IPRESS DE NIVEL ');
$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$sheet->setCellValue('A2', 'N°');
$sheet->setCellValue('B2', 'Hoja Registro');
$sheet->getColumnDimension('C')->setWidth(40);
$sheet->setCellValue('C2', 'Nombre de usuario');
$sheet->setCellValue('D2', 'Edad');
$sheet->setCellValue('E2', 'Sexo');
$sheet->setCellValue('F2', 'N°_Doc');
$sheet->setCellValue('G2', 'Licencia');
$sheet->setCellValue('H2', 'Clase');
$sheet->setCellValue('I2', 'Vehículo');
$sheet->setCellValue('J2', 'Placa');
$sheet->getColumnDimension('K')->setWidth(30);
$sheet->setCellValue('K2', 'Comandancia');
$sheet->setCellValue('L2', 'N°_oficio');
$sheet->setCellValue('M2', 'fecha_Oficio');
$sheet->getColumnDimension('N')->setWidth(50);
$sheet->setCellValue('N2', 'Motivo');
$sheet->setCellValue('O2', 'Conductor');
$sheet->setCellValue('P2', 'Hora infracción');
$sheet->setCellValue('Q2', 'Fecha infracción');
$sheet->setCellValue('R2', 'Hora extracción');
$sheet->setCellValue('S2', 'Fecha extracción');
$sheet->setCellValue('T2', 'Hrs.transcurridas');
$sheet->setCellValue('U2', 'Muestra');
$sheet->getColumnDimension('V')->setWidth(30);
$sheet->setCellValue('V2', 'Extractor');
$sheet->setCellValue('W2', 'Observación');
$sheet->getColumnDimension('X')->setWidth(30);
$sheet->setCellValue('X2', 'Perito');
$sheet->setCellValue('Y2', 'Cualitativo');
$sheet->setCellValue('Z2', 'Cuantitativo');
$sheet->setCellValue('AA2', 'fecha_registro');
$sheet->getColumnDimension('AB')->setWidth(30);
$sheet->setCellValue('AB2', 'Digitador');
$sheet->setCellValue('AC2', 'N° Certificados');
$filaExcel = 3;

$listadoInfracciones = $objInfraccion->reporteInfracciones($parametrosReporte);
if ($listadoInfracciones->rowCount() > 0) {
    $id = 1;
    while ($fila = $listadoInfracciones->fetch(PDO::FETCH_OBJ)) {
        $idInfraccion = $fila->id_infraccion;

        $extraccion = $objInfraccion->buscarExtraccion($idInfraccion);
        $peritaje = $objInfraccion->buscarPeritaje($idInfraccion);
        $certificados = $objInfraccion->buscarCertificados($idInfraccion);
        if ($extraccion->rowCount() > 0) {
            $extraccion = $extraccion->fetch(PDO::FETCH_OBJ);
            $hrs_transcurridas = $extraccion->hrs_transcurridas;
            $tipo_muestra = $extraccion->tipo_muestra;
            $extractor = $extraccion->extractor;
            $hora_extracc = $extraccion->hora_extracc;
            $fecha_extracc = $extraccion->fecha_extracc;
            $observacion = $extraccion->observacion;
        } else {
            $hrs_transcurridas = '';
            $tipo_muestra = '';
            $extractor = '';
            $hora_extracc = '';
            $fecha_extracc = '';
            $observacion = '';
        }
        if ($peritaje->rowCount() > 0) {
            $peritaje = $peritaje->fetch(PDO::FETCH_OBJ);
            $perito = $peritaje->perito;
            if ($perito !== NULL) {
                $datosPerito = $objPersona->BuscarPersonal($perito);
                $datosPerito = $datosPerito->fetch(PDO::FETCH_OBJ);
                $perito = $datosPerito->nombre;
            }
            $cualitativo = $peritaje->cualitativo;
            $cuantitativo = $peritaje->cuantitativo;
        } else {
            $perito = '';
            $cualitativo = '';
            $cuantitativo = '';
        }
        $lista_certificados = '';
        if ($certificados->rowCount() > 0) {
            while ($row = $certificados->fetch(PDO::FETCH_OBJ)) {
                $lista_certificados .= $row->n_serie . '-'  . $row->n_certificado;
            }
        }
        $sheet->setCellValue('A' . $filaExcel, $idInfraccion);
        $sheet->setCellValue('B' . $filaExcel, $fila->hoja_registro);
        $sheet->setCellValue('C' . $filaExcel, $fila->infractor);
        $sheet->setCellValue('D' . $filaExcel, $fila->edad);
        $sheet->setCellValue('E' . $filaExcel, $fila->sexo);
        $sheet->setCellValue('F' . $filaExcel, $fila->nro_doc);
        $sheet->setCellValue('G' . $filaExcel, $fila->lic_conducir);
        $sheet->setCellValue('H' . $filaExcel, $fila->clase);
        $sheet->setCellValue('I' . $filaExcel, $fila->vehiculo);
        $sheet->setCellValue('J' . $filaExcel, $fila->placa);
        $sheet->setCellValue('K' . $filaExcel, $fila->comisaria);
        $sheet->setCellValue('L' . $filaExcel, $fila->n_oficio);
        $sheet->setCellValue('M' . $filaExcel, $fila->fecha_recepcion);
        $sheet->setCellValue('N' . $filaExcel, $fila->Motivo);
        $sheet->setCellValue('O' . $filaExcel, $fila->gradoConductor);
        $sheet->setCellValue('P' . $filaExcel, $fila->hora_infr);
        $sheet->setCellValue('Q' . $filaExcel, $fila->fecha_infr);
        $sheet->setCellValue('R' . $filaExcel, $hora_extracc);
        $sheet->setCellValue('S' . $filaExcel, $fecha_extracc);
        $sheet->setCellValue('T' . $filaExcel, $hrs_transcurridas);
        $sheet->setCellValue('U' . $filaExcel, $tipo_muestra);
        $sheet->setCellValue('V' . $filaExcel, $extractor);
        $sheet->setCellValue('W' . $filaExcel, $observacion);
        $sheet->setCellValue('X' . $filaExcel, $perito);
        $sheet->setCellValue('Y' . $filaExcel, $cualitativo);
        $sheet->setCellValue('Z' . $filaExcel, $cuantitativo);
        $sheet->setCellValue('AA' . $filaExcel, $fila->fecha_registro);
        $sheet->setCellValue('AB' . $filaExcel, $fila->digitador);
        $sheet->setCellValue('AC' . $filaExcel, $lista_certificados);
        $id++;
        $filaExcel++;
    }
}

/*
$filaExcel--;
$spreadsheet->getActiveSheet()->getStyle('A3:D' . $filaExcel)->applyFromArray($estiloBody); */

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ReporteDosaje.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
