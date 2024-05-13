var card = document.getElementById('parte-delantera');

document.getElementById('flip').addEventListener('click', function() {
    var parteDelantera = document.getElementById('parte-delantera');
    parteDelantera.classList.add('animacion');

    var parteTrasera = document.getElementById('parte-trasera');
    parteTrasera.classList.add('animacion2');
    parteTrasera.style.display = "inline";
    parteDelantera.style.display = "none";
});


document.getElementById('flip-reverse').addEventListener('click', function(){
    var parteTrasera = document.getElementById('parte-trasera');
    parteTrasera.classList.add('animacion');

    var parteDelantera = document.getElementById('parte-delantera');
    parteDelantera.classList.add('animacion2');
    parteDelantera.style.display = "inline";
    parteTrasera.style.display = "none";
});


//cambiar de inicio de sesion a olvidar contraseña

document.getElementById('cambiarContraseña').addEventListener('click', function() {
    var parteDelantera = document.getElementById('parte-delantera');
    parteDelantera.classList.add('animacion');

    var parteTrasera = document.getElementById('cambiar-contraseña');
    parteTrasera.classList.add('animacion2');
    parteTrasera.style.display = "inline";
    parteDelantera.style.display = "none";
});


document.getElementById('irInicio').addEventListener('click', function(){
    var parteTrasera = document.getElementById('cambiar-contraseña');
    parteTrasera.classList.add('animacion');

    var parteDelantera = document.getElementById('parte-delantera');
    parteDelantera.classList.add('animacion2');
    parteDelantera.style.display = "inline";
    parteTrasera.style.display = "none";
});