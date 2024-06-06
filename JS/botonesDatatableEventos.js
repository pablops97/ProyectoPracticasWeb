let panelOpacidad = document.getElementById("opacidadeventos");
let panelConfirmacion = document.getElementById("panelEliminarEvento");
let botonConfirmarEliminacion = document.getElementById("confirmarEliminacionEvento");


function popup(confirmacion, id) {

    if (confirmacion == true) {
        
        //Le asigno al boton del popup para confirmar eliminacion, el valor del id del usuario que voy a eliminar
        botonConfirmarEliminacion.value = id;
        console.log("El valor del boton confirmar es " + botonConfirmarEliminacion.value)
        panelOpacidad.classList.remove("d-none");
        panelConfirmacion.classList.remove("d-none");
        document.getElementById("tituloPanelEliminarEvento").innerHTML = "¿Desea eliminar el evento con id " + id + "?";
    } else {
        panelOpacidad.classList.add("d-none");
        panelConfirmacion.classList.add("d-none");
    }
}

function redirectTo(id, url){
    location.href = url + id;
}

function redirectToEvents(){
    location.href = '../listado_eventos.php';
}

function eliminarEvento(id){
    /*Guardo el id del evento a eliminar en el valor del boton para manejarlo mas comodamente*/
    location.href = '../controlador/eventos/delete_evento.php?event=' + botonConfirmarEliminacion.value;
}