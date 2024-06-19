let regexContrasenia = /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/;
let emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail|outlook|hotmail|yahoo|aol|icloud|live|msn|mail|yandex|protonmail|inbox)\.(com|es|net|org|info|gov|edu)$/;




document.getElementById('formularioRegistroTecnico').addEventListener('submit', function(event) {
    event.preventDefault();    
    let password = document.getElementById('contraseniaRegistro').value;
    let email = document.getElementById('emailRegistro').value;

    let errores = '';

    if(!emailRegex.test(email)){
        errores += '- El email que ha introducido no es correcto\n';
    }

    if(!regexContrasenia.test(password)){
        errores += '- La contraseña que has introducido no sigue los minimos\n';
    }
    
    if(errores.length === 0) {
        this.submit();
    } else {
        alert(errores);
    }
});