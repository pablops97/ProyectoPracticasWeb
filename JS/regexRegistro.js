
var nombre = document.getElementById('nombreUsuarioRegistro');
var contrasenia = document.getElementById('contraseniaRegistro');
var email = document.getElementById('email');
var telefono = document.getElementById('telefono');
var boton = document.getElementById('boton');
var celdaEmail = document.getElementById('email');

let arrayElementos = {nombre, contrasenia, email, telefono, boton, celdaEmail};

//variables regex
var regexCorreo      = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
var regexUsuario     = /^[a-zA-Z0-9]+$/;
var regexTelefono    = /^[0-9]{9}$/;
var regexContrasenia = /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/;





function verificarNombre(){
    
    if(!nombre.value.match(regexUsuario)){
        nombre.classList.remove("bg-light")
        nombre.classList.remove("bg-success")
        nombre.classList.add("bg-danger");
    }else{
        nombre.classList.remove("bg-danger")
        nombre.classList.add("bg-success");
    }
}

function verificarContrasenia(){
    console.log("contrasenia");
    if(!contrasenia.value.match(regexContrasenia)){
        contrasenia.classList.remove("bg-light")
        contrasenia.classList.remove("bg-success")
        contrasenia.classList.add("bg-danger");
    }else{
        contrasenia.classList.remove("bg-danger")
        contrasenia.classList.add("bg-success");
    }
}


function verificarEmail(){

    if(!email.value.match(regexCorreo)){
        email.classList.remove("bg-light")
        email.classList.remove("bg-success")
        email.classList.add("bg-danger");
    }else{
        email.classList.remove("bg-success")
        email.classList.add("bg-danger");
    }
    return true;
}

function verificarTelefono(){

    if(!telefono.value.match(regexTelefono)){
        telefono.classList.remove("bg-light")
        telefono.classList.remove("bg-success")
        telefono.classList.add("bg-danger");
    }else{
        telefono.classList.remove("bg-danger")
        telefono.classList.add("bg-success");
    }
}


function cleanCampos(){
    arrayElementos.forEach(element => {
        element.classList.remove("bg-success");
        element.classList.remove("bg-danger");
        element.classList.add("bg-light");
    });
}

