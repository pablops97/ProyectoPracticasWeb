
var nombre = document.getElementById('nombreUsuarioRegistro');
var contrasenia = document.getElementById('contraseniaRegistro');
var email = document.getElementById('email');
var telefono = document.getElementById('telefono');
var boton = document.getElementById('boton');
var celdaEmail = document.getElementById('email');
const passwordInput = document.getElementById('contraseniaRegistro');

let arrayElementos = { nombre, contrasenia, email, telefono, boton, celdaEmail };

//variables regex
var regexCorreo = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
var regexUsuario = /^[a-zA-Z0-9]+$/;
var regexTelefono = /^[0-9]{9}$/;
var regexContrasenia = /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/;


function restriccionNombre(inputVal) {
    var patt = /^[a-zA-Z0-9]+$/;
    // Verifica si el valor del input contiene solo caracteres permitidos
    if (patt.test(inputVal)) {
        nombre.value = inputVal;
    }
    else {
        // Elimina cualquier carácter no permitido
        var txt = inputVal.slice(0, -1);
        nombre.value = txt;
    }

}

function restriccionPass(inputVal) {
    var pattPermitido = /^[A-Za-z0-9!@#$&*]+$/;
     if (pattPermitido.test(inputVal)) {
        contrasenia.value = inputVal;
        if (isValidPassword(passwordInput.value)) {
            passwordInput.classList.add('valid-border');
        } else {
            passwordInput.classList.remove('valid-border');
        }
    } else {
        
        var txt = inputVal.replace(/[^A-Za-z0-9!@#$&*]/g, '');
        contrasenia.value = txt;
    }

}

function restriccionNumero(inputVal) {
    var patt = /^[0-9]+$/;
    if (patt.test(inputVal)) {
        telefono.value = inputVal;
    } else {
        var txt = inputVal.replace(/[^0-9]/g, '');
        telefono.value = txt;
    }
}

function verificarNombre() {

    if (!nombre.value.match(regexUsuario)) {
        nombre.classList.remove("bg-light")
        nombre.classList.remove("bg-success")
        nombre.classList.add("bg-danger")
    } else {
        nombre.classList.remove("bg-danger")
        nombre.classList.add("bg-success")
    }
}



function verificarContra() {
    
}

function isValidPassword(password) {
    const regex = /^(?=.*[A-Z])(?=.*[a-z].*[a-z].*[a-z])(?=.*\d)(?=.*[!@#$&*]).{8,}$/;
    return regex.test(password);
}

function verificarEmail() {

    if (!email.value.match(regexCorreo)) {
        email.classList.remove("bg-light");
        email.classList.remove("bg-success");
        email.classList.add("bg-danger");
    } else {
        email.classList.remove("bg-danger");
        email.classList.add("bg-success");
    }
    return true;
}

function verificarTelefono() {

    if (!telefono.value.match(regexTelefono)) {
        telefono.classList.remove("bg-light")
        telefono.classList.remove("bg-success")
        telefono.classList.add("bg-danger");
    } else {
        telefono.classList.remove("bg-danger")
        telefono.classList.add("bg-success");
    }
}


function cleanCampos() {
    arrayElementos.forEach(element => {
        element.classList.remove("bg-success");
        element.classList.remove("bg-danger");
        element.classList.add("bg-light");
    });
}

