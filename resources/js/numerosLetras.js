/* ----------- VALIDACIONES -------------------------- */
const unidades = {
    0: "CERO",
    E1: "UN",
    1: "UNO",
    2: "DOS",
    3: "TRES",
    4: "CUATRO",
    5: "CINCO",
    6: "SEIS",
    7: "SIETE",
    8: "OCHO",
    9: "NUEVE",
};
const decenas = {
    10: "DIEZ",
    11: "ONCE",
    12: "DOCE",
    13: "TRECE",
    14: "CATORCE",
    15: "QUINCE",
    20: "VEINTE",
    30: "TREINTA",
    40: "CUARENTA",
    50: "CINCUENTA",
    60: "SESENTA",
    70: "SETENTA",
    80: "OCHENTA",
    90: "NOVENTA",
};

const numeroLetras = (numero) => {
    let cadena = numero.split(".");
    let entero = cadena[0];
    let decimal = cadena[1];
    /* parte decimal */
    let textoGramos = entero == 1 ? "GRAMO" : "GRAMOS";
    if (entero == 1) entero = "E1";
    /* parte decimal */
    let textoDecimal;
    if (decimal % 10 === 0 || (decimal < 16 && decimal > 10))
        textoDecimal = decenas[decimal];
    else if (decimal < 10)
        textoDecimal = `${unidades[decimal[0]]} ${unidades[decimal[1]]}`;
    else if (decimal < 20 && decimal > 15)
        textoDecimal = "DIECI" + unidades[decimal[1]];
    else if (decimal < 30 && decimal > 20)
        textoDecimal = "VENITI" + unidades[decimal[1]];
    else if (decimal >= 30)
        textoDecimal = decenas[`${decimal[0]}0`] + " Y " + unidades[decimal[1]];

    let texto = `${unidades[entero]} ${textoGramos} ${textoDecimal} CENTÍGRAMOS DE ALCOHOL POR LITRO DE SANGRE`;
    return texto;
};