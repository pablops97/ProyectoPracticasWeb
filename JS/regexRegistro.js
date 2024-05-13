
var nombre = document.getElementById('nombreUsuario');
var contrasenia = document.getElementById('contrasenia');
var email = document.getElementById('email');
var telefono = document.getElementById('telefono');
var boton = document.getElementById('boton');
var celdaEmail = document.getElementById('email');

//variables regex
var regexCorreo      = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
var regexUsuario     = /^[a-zA-Z0-9]+$/;
var regexTelefono    = /^[0-9]{10}$/;
var regexContrasenia = /^[A-Za-z]\w{7,14}$/;

boton.addEventListener(input, function(){
    if(!email.value.match(validRegex)){
        //celdaEmail.style.borderBlockColor = #
    }
});



function verificarNombre(){
    
    if(!nombre.value.match(regexUsuario)){
        nombre.classList.add('bg-danger');
        return false;
    }else{
        nombre.style.backgroundColor = "green";
        return true;
    }
}

function verificarContrasenia(){

    if(!contrasenia.value.match(regexContrasenia)){
        contrasenia.style.backgroundColor = "red";
        return false
    }else{
        contrasenia.style.backgroundColor = "green";
    }
    return true;
}


function verificarEmail(){

    if(!email.value.match(regexCorreo)){
        email.style.backgroundColor = "red"
        return false;
    }else{
        email.style.backgroundColor = "green";
    }
    return true;
}

function verificarTelefono(){

    if(!telefono.value.match(regexTelefono)){
        telefono.style.backgroundColor = "red";
        return false;
    }else{
        email.style.backgroundColor = "green";
    }
    return true;
}


