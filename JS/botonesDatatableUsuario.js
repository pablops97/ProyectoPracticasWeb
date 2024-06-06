var botonEditar = document.getElementById("botonEditarDatatable");
var panelOpacidad = document.getElementById("opacidad");
var panelConfirmacion = document.getElementById("confirmacionEliminarUsuario");
var botonCancelar = document.getElementById("botonCancelarEliminacion")
var botonConfirmarEliminacion = document.getElementById("confirmarEliminacion");
var botonEliminarUsuario = document.getElementById("botonEliminarUsuario");
var botonEliminar = document.getElementById("botonEliminarUsuario")





botonCancelar.addEventListener("click", function () {
    popup(false, 1)
})


function redirectTo(id) {
    location.href = "editar_usuario.php?user=" + id;
}

function eliminar() {
    location.href = "../controlador/usuarios/delete.php?user=" + botonConfirmarEliminacion.value;
}

function crearUsuario(){
    location.href = "../dashboard/editar_usuario.php?new";
}


function popup(confirmacion, id) {

    if (confirmacion == true) {
        
        //Le asigno al boton del popup para confirmar eliminacion, el valor del id del usuario que voy a eliminar
        botonConfirmarEliminacion.value = id;
        console.log("El valor del boton confirmar es " + botonConfirmarEliminacion.value)
        panelOpacidad.classList.remove("d-none");
        panelConfirmacion.classList.remove("d-none");
        document.getElementById("tituloPanelEliminarUsuario").innerHTML = "¿Desea eliminar el usuario con id " + id + "?";
    } else {
        panelOpacidad.classList.add("d-none");
        panelConfirmacion.classList.add("d-none");
    }
}


function extraerId() {
    var text = document.getElementById("tituloPanelEliminarUsuario").value;
    var separacion = text.split(" ");
    return separacion[6];
}

