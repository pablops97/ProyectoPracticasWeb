

// FUNCIONES QUE CONTROLAN LOS CARACTERES QUE SE PUEDEN INTRODUCIR EN TECLADO

function restriccionTexto(value, id) {
    const inputElement = document.getElementById(id);
    const regex = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ\s]*$/;
    if (!regex.test(value)) {
        inputElement.value = value.replace(/[^a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ\s]/g, '');
    }
}




//para que las funciones sean genericas, por parametro se le pasa el valor del input y el id del elemento
function restriccionNombre(inputVal, id) {
    var patt = /^[\p{L}]+$/u;
    // Verifica si el valor del input contiene solo caracteres permitidos
    if (patt.test(inputVal)) {
        document.getElementById(id).value = inputVal;
    }
    else {
        // Elimina cualquier carácter no permitido
        var txt = inputVal.slice(0, -1);
        document.getElementById(id).value = txt;
    }

}

function restriccionApellidos(inputVal, id) {
    // Modifica la expresión regular para permitir letras y espacios
    var patt = /^[\p{L} ]+$/u;
    // Verifica si el valor del input contiene solo caracteres permitidos
    if (patt.test(inputVal)) {
        document.getElementById(id).value = inputVal;
    }
    else {
        // Elimina cualquier carácter no permitido
        var txt = inputVal.slice(0, -1);
        document.getElementById(id).value = txt;
    }
}

function restriccionUsuario(inputVal, id) {
    var patt = /^[a-zA-Z0-9_]+$/;
    // Verifica si el valor del input contiene solo caracteres permitidos
    if (patt.test(inputVal)) {
        document.getElementById(id).value = inputVal;
    }
    else {
        // Elimina cualquier carácter no permitido
        var txt = inputVal.slice(0, -1);
        document.getElementById(id).value = txt;
    }

}

function restriccionPass(inputVal, id) {
    var pattPermitido = /^[A-Za-z0-9!@#$&*]+$/;
     if (pattPermitido.test(inputVal)) {
        document.getElementById(id).value = inputVal;
    } else {
        
        var txt = inputVal.replace(/[^A-Za-z0-9!@#$&*]/g, '');
        document.getElementById(id).value = txt;
    }
}

function restriccionNumero(inputVal, id) {
    var patt = /^[0-9]+$/;
    if (patt.test(inputVal)) {
        document.getElementById(id).value = inputVal;
    } else {
        var txt = inputVal.replace(/[^0-9]/g, '');
        document.getElementById(id).value = txt;
    }
}

function validatePrefix(id) {
    const input = document.getElementById(id);
    const fixedText = 'ES';
    if (!input.value.startsWith(fixedText)) {
        input.value = fixedText;
    }
}

function preventBackspace(event) {
    const input = document.getElementById(id);
    const fixedText = 'ES';
    if (event.key === 'Backspace' && input.selectionStart <= fixedText.length) {
        event.preventDefault();
    }
}


function autorellenarPoblacion(idDireccion, idPoblacion){
    var direccion = document.getElementById(idDireccion).value;
    var spliteo = direccion.split(",")
    if (spliteo.length > 1) {
        // Remover espacios en blanco al principio y al final
        var poblacion = spliteo[1].trim();
        document.getElementById(idPoblacion).value = poblacion;}
}


//Uso de una api para comprobar si el correo existe
function httpGetAsync(url, callback) {
    const xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200)
            callback(xmlHttp.responseText);
    }
    xmlHttp.open("GET", url, true); // true for asynchronous
    xmlHttp.send(null);
}

// Función para validar un correo electrónico utilizando la API de Abstract API
function validarEmail(id) {
    const email = document.getElementById(id);
    const apiKey = "92d5c47a8c534ebd9f4b1317701d0c96";
    const url = `https://emailvalidation.abstractapi.com/v1/?api_key=${apiKey}&email=${encodeURIComponent(email)}`;

    httpGetAsync(url, function(response) {
        const resultado = JSON.parse(response);
        if (resultado.deliverability === "DELIVERABLE") {
            console.log("El correo electrónico es válido.");
            document.getElementById(id).style.color = green;
        } else {
            console.log("El correo electrónico no es válido.");
            document.getElementById(id).style.color = red;
        }
    });
}
/*funcion para ver la contraseña en los input*/

function verPass(id) {
    var x = document.getElementById(id);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}