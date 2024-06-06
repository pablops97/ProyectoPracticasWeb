var inputcambioimagen = document.getElementById("cambiarImagen");


function habilitarCambioImagen(){
    inputcambioimagen.classList.remove("d-none");
    this.disable = true;
}

document.getElementById('formEditarUsuario').addEventListener('submit', function(event) {
    event.preventDefault();
    
    let password = document.getElementById('passEditarUsuario').value;
    let confirmarPassword = document.getElementById('confirmarPassEditarUsuario').value;
    let email = document.getElementById('emailEditarUsuario').value;
    let iban = document.getElementById('cuentaIBANNuevoUsuario').value;

    let errores = '';

    if(email.length !== 0){
        if(!emailRegex.test(email)){
            errores += 'El email que ha introducido no es correcto\n';
        }
    }
    
    if(password.length !== 0){
        if(!regexContrasenia.test(password)){
            errores += 'La contraseña que has introducido no sigue los minimos';
        }
    }
    
    
    if(errores.length === 0) {
        alert('Formulario enviado con éxito.');
        this.submit();
    } else {
        alert(errores);
    }
});