

// FUNCIONES QUE CONTROLAN LOS CARACTERES QUE SE PUEDEN INTRODUCIR EN TECLADO

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