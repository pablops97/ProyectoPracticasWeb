
let regexContrasenia = /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/;
let emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail|outlook|hotmail|yahoo|aol|icloud|live|msn|mail|yandex|protonmail|inbox)\.(com|es|net|org|info|gov|edu)$/;




document.getElementById('formCrearNuevoUsuario').addEventListener('submit', function(event) {
    event.preventDefault();    
    let password = document.getElementById('nuevaPassNuevoUsuario').value;
    let confirmarPassword = document.getElementById('confirmarNuevaPassNuevoUsuario').value;
    let email = document.getElementById('emailNuevoUsuario').value;
    let iban = document.getElementById('cuentaIBANNuevoUsuario').value;

    let errores = '';

    if(!emailRegex.test(email)){
        errores += '- El email que ha introducido no es correcto\n';
    }

    if(!regexContrasenia.test(password)){
        errores += '- La contraseña que has introducido no sigue los minimos\n';
    }

    if(password != confirmarPassword){
        errores += '- Las contraseñas no son iguales\n';
    }
    
    if(errores.length === 0) {
        alert('Formulario enviado con éxito.');
        this.submit();
    } else {
        alert(errores);
    }
});