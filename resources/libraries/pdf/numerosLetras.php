<?php
function numerosLetras($numero)
{
    $unidades = [
        0 => "CERO",
        'E1' => "UN",
        1 => "UNO",
        2 => "DOS",
        3 => "TRES",
        4 => "CUATRO",
        5 => "CINCO",
        6 => "SEIS",
        7 => "SIETE",
        8 => "OCHO",
        9 => "NUEVE",
    ];
    $decenas = [
        10 => "DIEZ",
        11 => "ONCE",
        12 => "DOCE",
        13 => "TRECE",
        14 => "CATORCE",
        15 => "QUINCE",
        20 => "VEINTE",
        30 => "TREINTA",
        40 => "CUARENTA",
        50 => "CINCUENTA",
        60 => "SESENTA",
        70 => "SETENTA",
        80 => "OCHENTA",
        90 => "NOVENTA",
    ];
    list($entero, $decimal) = explode(".", $numero);

    $textoGramos = $entero == 1 ? "GRAMO" : "GRAMOS";
    if ($entero == 1) $entero = "E1";


    $textoDecimal = '';
    if ($decimal % 10 === 0 || ($decimal < 16 && $decimal > 10))
        $textoDecimal = $decenas[$decimal];
    else if ($decimal < 10)
        $textoDecimal = $unidades[$decimal[0]] . ' ' . $unidades[$decimal[1]];
    else if ($decimal < 20 && $decimal > 15)
        $textoDecimal = "DIECI" + $unidades[$decimal[1]];
    else if ($decimal < 30 && $decimal > 20)
        $textoDecimal = "VENITI" + $unidades[$decimal[1]];
    else if ($decimal >= 30)
        $textoDecimal = $decenas[$decimal[0] . '0'] + " Y " + $unidades[$decimal[1]];

    $texto = $unidades[$entero] . ' ' . $textoGramos . ' ' . $textoDecimal . ' CENTÍGRAMOS DE ALCOHOL POR LITRO DE SANGRE';
    return $texto;
}
/* 
$long_cadena = strlen($numero_decimal);
if ($numero_decimal < 10 && $long_cadena == '2') {
    $numero_decimal = $numero_decimal * 1;
}

$numeros = [
    '0' => 'CERO',
    '1' => 'UNO',
    '2' => 'DOS',
    '3' => 'TRES',
    '4' => 'CUATRO',
    '5' => 'CINCO',
    '6' => 'SEIS',
    '7' => 'SIETE',
    '8' => 'OCHO',
    '9' => 'NUEVE',
    '10' => 'DIEZ',
    '11' => 'ONCE',
    '12' => 'DOCE',
    '13' => 'TRECE',
    '14' => 'CATORCE',
    '15' => 'QUINCE',
    '20' => 'VEINTE',
    '30' => 'TREINTA',
    '40' => 'CUARENTA',
    '50' => 'CINCUENTA',
    '60' => 'SESENTA',
    '70' => 'SETENTA',
    '80' => 'OCHENTA',
    '90' => 'NOVENTA',
];

$Entero = EnteroLetras($numero_entero);
$Decimales = DecimalLetras($numero_decimal);
echo $Entero . ' GRAMOS ' . $Decimales . ' CENTÍGRAMOS DE ALCOHOL POR LITRO DE SANGRE';


function EnteroLetras($numero_entero)
{
    global $numeros;
    if ($numero_entero === '1') {
        $EnteroLetra = 'UN';
    } else {
        $EnteroLetra = $numeros[$numero_entero];
    }
    return $EnteroLetra;
}

function DecimalLetras($numero_decimal)
{
    global $numeros;
    if ($numero_decimal > 15 && $numero_decimal < 20) {
        $array = str_split($numero_decimal);
        $DecimalLetra = 'DIECI' . $numeros[$array[1]];
    } else if ($numero_decimal > 20 && $numero_decimal < 30) {
        $array = str_split($numero_decimal);
        $DecimalLetra = 'VEINTI' . $numeros[$array[1]];
    } else if ($numero_decimal > 29 && $numero_decimal < 99) {
        $array = str_split($numero_decimal);
        if ($array[1] === '0') {
            $DecimalLetra = $numeros[$numero_decimal];
        } else {
            $Dec = $numeros[$array[0] * 10];
            $Uni = $numeros[$array[1]];
            $DecimalLetra = $Dec . ' Y ' . $Uni;
        }
    } else {
        $DecimalLetra = $numeros[$numero_decimal];
    }
    return $DecimalLetra;
}
 */