function strToFecha(str) {
    if (str == "N/A") {
        return str;
    }
    if (str == null) {
        return "N/A";
    }
    const options = { year: 'numeric', month: 'long', day: 'numeric', timeZone: 'UTC' };
    var dt = new Date(str);
    return dt.toLocaleDateString('es-ES', options);
}
function strToMes(str) {
    const options = { year: 'numeric', month: 'long', timeZone: 'UTC' };
    var dt = new Date(str + "-03");
    // return dt.toLocaleDateString('es-ES', options);
    return capitalizeFirstLetter(dt.toLocaleDateString('es-ES', options));
}
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
function agregarColumnas(nombreCol, columnaObjetivo) {
    var table = document.getElementsByTagName("thead")[0];

    var headerRow = table.getElementsByTagName("tr")[0];
    var headerCell = document.createElement("th");
    var headerBold = document.createElement("b");
    headerBold.textContent = nombreCol;
    headerCell.appendChild(headerBold);
    var cells = headerRow.getElementsByTagName("th");
    if (cells.length > columnaObjetivo) {
        headerRow.insertBefore(headerCell, cells[columnaObjetivo]);
    } else {
        headerRow.appendChild(headerCell);
    }

    var rows = table.getElementsByTagName("tr");
    for (var i = 1; i < rows.length; i++) {
        var newRow = document.createElement("td");
        rows[i].insertBefore(newRow, rows[i].getElementsByTagName("td")[columnaObjetivo]);
    }
}

function strLowSinEspacios(txt) {
    return txt.val().split(" ").join("").toLowerCase();
}
function noValidoCorreoMask(txt) {
    return txt == "" || txt.includes("@_.") || txt.endsWith("._");
}
function noValidoTelefonoMask(txt) {
    return txt == "" || txt.includes("_");
}
const validateEmail = (email) => {
    return String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};
function posCursor(input, pos) {
    input.setSelectionRange(pos, pos);
}
function inputMayus(input) {
    var pos = input.selectionStart;
    input.value = input.value.toUpperCase();
    posCursor(input, pos);
}
function inputMinus(input) {
    var pos = input.selectionStart;
    input.value = input.value.toLowerCase();
    posCursor(input, pos);
}
function inputMayusTrim(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    input.value = input.value.toUpperCase().trim();
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function inputSinEspacios(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    input.value = input.value.replace(' ', '');
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function inputNumNoLeadZeros(input) {
    var numero = parseInt(input.value);
    if (numero == 0) {
        input.value = "";
    } else if (numero > 99999999999999999999) {
        input.value = "99999999999999999999";
    } else {
        input.value = numero;
    }
}
function onlyLetras(input) {
    var inputValue = input.value;
    var sanitizedValue = inputValue.replace(/[^A-ZÑa-zñ ]/g, ''); // Solo letras y espacios
    input.value = sanitizedValue;
}
function inputLetras(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    var inputValue = input.value;
    var sanitizedValue = inputValue.replace(/[^A-ZÑa-zñ ]/g, ''); // Solo letras y espacios
    input.value = sanitizedValue.toUpperCase();
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function inputNumeros(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    var inputValue = input.value;
    var sanitizedValue = inputValue.replace(/[^0-9]/g, '');
    input.value = sanitizedValue.toUpperCase();
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function inputLetrasNumeros(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    var inputValue = input.value;
    var sanitizedValue = inputValue.replace(/[^A-ZÑa-zñ0-9]/g, '');
    input.value = sanitizedValue.toUpperCase();
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function inputLetrasNumerosEspacios(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    var inputValue = input.value;
    var sanitizedValue = inputValue.replace(/[^A-ZÑa-zñ0-9 ]/g, ''); // Solo letras y espacios
    input.value = sanitizedValue.toUpperCase();
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function inputLetrasNumerosGuiones(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    var inputValue = input.value;
    var sanitizedValue = inputValue.replace(/[^A-ZÑa-zñ0-9-]+$/g, ''); // Solo letras y espacios
    input.value = sanitizedValue.toUpperCase();
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function inputLetrasNumerosPuntosEspacios(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    var inputValue = input.value;
    var sanitizedValue = inputValue.replace(/[^A-ZÑa-zñ0-9. ]/g, ''); // Solo letras y espacios
    input.value = sanitizedValue.toUpperCase();
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function inputMoney(input) {
    var inputValue = input.value;
    input.value = parseFloat(inputValue).toFixed(2);
}
function validarUsuario(input) {
    var pos = input.selectionStart;
    var len = input.value.length;
    let valorInput = input.value.replace(/[^\w\s_]/gi, '');
    if (/^\d/.test(valorInput)) {
        valorInput = valorInput.substring(1);
    }
    input.value = valorInput;
    var pos_new = pos + input.value.length - len;
    posCursor(input, pos_new);
}
function validatePassword(pw) {
    return /[A-Z]/.test(pw) &&
        /[a-z]/.test(pw) &&
        /[0-9]/.test(pw) &&
        /[^A-Za-z0-9]/.test(pw) &&
        pw.length >= 8;
}
function validarNumerosEnteros(input) {
    // Expresión regular que permite solo números enteros
    var regex = /^\d*$/;

    // Obtener el valor del input
    var valorInput = input.value;

    // Verificar si el valor cumple con la expresión regular
    if (!regex.test(valorInput)) {
        // Si no cumple, eliminar caracteres no permitidos
        input.value = valorInput.replace(/[^\d]/g, '');
    }
}
function validarColonia(input) {
    // Expresión regular que permite letras, números, Ñ, puntos, comas y paréntesis
    var regex = /^[a-zA-ZñÑ0-9 .,()-]*$/;

    // Obtener el valor del input
    var valorInput = input.value;

    // Verificar si el valor cumple con la expresión regular
    if (!regex.test(valorInput)) {
        // Si no cumple, eliminar caracteres no permitidos
        input.value = valorInput.replace(/[^a-zA-ZñÑ0-9 .,()-]/g, '');
    }
}
function rfcValido(rfc, aceptarGenerico = true) {
    if (rfc == 'EXTF900101NI1' || rfc == 'EXT990101NI1') {
        return true;
    }
    const re = /^([A-ZÃ‘&]{3,4})?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01]))?([A-Z\d]{2})([A\d])$/;
    var validado = rfc.match(re);

    if (!validado)  //Coincide con el formato general del regex?
        return false;

    //Separar el dÃ­gito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
        rfcSinDigito = validado.slice(1).join(''),
        len = rfcSinDigito.length,

        //Obtener el digito esperado
        diccionario = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
        indice = len + 1;
    var suma,
        digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for (var i = 0; i < len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dÃ­gito verificador coincide con el esperado?
    // o es un RFC GenÃ©rico (ventas a pÃºblico general)?
    if ((digitoVerificador != digitoEsperado)
        && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;
    return rfcSinDigito + digitoVerificador;
}

//FunciÃ³n para validar una CURP
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);

    if (!validado)  //Coincide con el formato general?
        return false;

    //Validar que coincida el dÃ­gito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma = 0.0,
            lngDigito = 0.0;
        for (var i = 0; i < 17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10) return 0;
        return lngDigito;
    }

    if (validado[2] != digitoVerificador(validado[1]))
        return false;

    return true; //Validado
}

function generarContraseniaStr() {
    const caracteres = [
        'abcdefghjkmnpqrstuvwxyz',
        'ABCDEFGHJKLMNOPQRSTUVWXYZ',
        '0123456789',
        "!\"#$%&'()*+,-./:;<=>?@[\\]^_`{}~"
    ];

    const indices = [0, 1, 2, 3];
    for (let i = 1; i <= 4; i++) {
        indices.push(randomIntFromInterval(0, 3));
    }

    let contrasenia = '';
    for (let i = 0; i < 8; i++) {
        const indice_chars = randomIntFromInterval(0, 7 - i);
        const chars_set = indices[indice_chars];
        const indice = Math.floor(Math.random() * caracteres[chars_set].length);
        contrasenia += caracteres[chars_set].charAt(indice);
        indices.splice(indice_chars, 1);
    }
    return contrasenia;
}

function randomIntFromInterval(min, max) { // min and max included 
    return Math.floor(Math.random() * (max - min + 1) + min)
}

function compararHoras(hora1, hora2) {
    var t1 = new Date('1970-01-01T' + hora1 + 'Z');
    var t2 = new Date('1970-01-01T' + hora2 + 'Z');

    return t1 - t2;
}

function horaEnRango(value) {
    var rangoHoras = ['01:00', '05:59'];
    return value >= rangoHoras[0] && value <= rangoHoras[1];
}

function strNoEsSoloNumerosNiVacio(value) {
    var str = value.trim();
    if (str == '') {
        return false;
    }
    let isnum = /^\d+$/.test(str);
    return !isnum;
}

function pdf_gah(verificacion_id) {
    $('#modalCargando').modal('show');
    var Enviar = {
        "verificacion_id": verificacion_id
    }
    var request = new XMLHttpRequest(), file, fileURL;
    request.open("POST", 'http://localhost/Herkace_Shared/Web/api/app_ws/Verificaciones/pdf_gah');
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.responseType = "arraybuffer";
    request.send(JSON.stringify(Enviar));
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            $('#modalCargando').modal('hide');
            Swal.fire({
                title: 'Archivo abierto en una nueva pestaña',
                text: 'Si no es así, revise la configuración de las pantallas emergentes (pop-up) de su navegador.',
                icon: 'info',
                confirmButtonText: 'ACEPTAR'
            });
            file = new Blob([request.response], { type: 'application/pdf' });
            if (window.navigator && window.navigator.msSaveOrOpenBlob) { // IE
                window.navigator.msSaveOrOpenBlob(file);
            } else {
                fileURL = URL.createObjectURL(file);
                window.open(fileURL);

            }
        }
    };
}

function pdf_certificado(verificacion_id) {
    $('#modalCargando').modal('show');
    var Enviar = {
        "verificacion_id": verificacion_id
    }
    var request = new XMLHttpRequest(), file, fileURL;
    request.open("POST", 'http://localhost/Herkace_Shared/Web/api/app_ws/Verificaciones/pdf_certificado');
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.responseType = "arraybuffer";
    request.send(JSON.stringify(Enviar));
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            $('#modalCargando').modal('hide');
            Swal.fire({
                title: 'Archivo abierto en una nueva pestaña',
                text: 'Si no es así, revise la configuración de las pantallas emergentes (pop-up) de su navegador.',
                icon: 'info',
                confirmButtonText: 'ACEPTAR'
            });
            file = new Blob([request.response], { type: 'application/pdf' });
            if (window.navigator && window.navigator.msSaveOrOpenBlob) { // IE
                window.navigator.msSaveOrOpenBlob(file);
            } else {
                fileURL = URL.createObjectURL(file);
                window.open(fileURL);

            }
        }
    };
}
