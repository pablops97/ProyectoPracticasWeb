<?php

include '../conexionBD.php';
include '../../utilidades/funciones.php';
define("IMAGEN_PREDETERMINADA" , 'evento.jpg');

session_start();

$id = $_SESSION["idevento"];


# Identificacion de imagen 
# SUBIR IMAGEN AL SERVIDOR

$target_dir = "../../ImagenesEventos/";
$target_file = $target_dir . basename($_FILES["cambiarImagen"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

# identificamos si hay imagen o no

if (!empty($_FILES["cambiarImagen"]["name"])) {
    // Comprobar el tamaño de la foto
    if ($_FILES["cambiarImagen"]["size"] > 500000) {
        echo '<script>alert("Lo sentimos, su archivo es demasiado grande.")</script>';
        $uploadOk = 0;
    }


    // Comprobar si la variable $uploadOk se ha iniciado a 0 por error
    if ($uploadOk == 0) {
        #SI no ha subido archivo, la imagen será la predeterminada
        $imagen = IMAGEN_PREDETERMINADA;
        // Si todo sale bien, se sube la imagen
    } else {
        if (move_uploaded_file($_FILES["cambiarImagen"]["tmp_name"], $target_file)) {
            $imagen = basename($_FILES["cambiarImagen"]["name"]);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}




#Extraemos los campos del formulario que no estén vacios

$titulo = !empty($_POST['titulo']) ? $_POST['titulo'] : null;
$descripcion = !empty($_POST['descripcion']) ? $_POST['descripcion'] : null;
$localizacion = !empty($_POST['localizacion']) ? $_POST['localizacion'] : null;
$categoria = !empty($_POST['categoriaEditar']) ? $_POST['categoriaEditar'] : null;
$estado = !empty($_POST['estadoEditar']) ? $_POST['estadoEditar'] : null;
$precio = !empty($_POST['precio']) ? $_POST['precio'] : null;
$participantes = !empty($_POST['participantes']) ? $_POST['participantes'] : null;
$fechainicioinscripcion = !empty($_POST['fechainicioinscripcion']) ? $_POST['fechainicioinscripcion'] : null;
$fechainicio = !empty($_POST['fechainicio']) ? $_POST['fechainicio'] : null;
$fechafin = !empty($_POST['fechafin']) ? $_POST['fechafin'] : null;

$updates = [];

// Agregar los campos a actualizar si no están vacíos
if ($titulo) $updates[] = "TITULO_EVENTO = '$titulo'";
if ($descripcion) $updates[] = "DESCRIPCION_EVENTO = '$descripcion'";
if ($localizacion) $updates[] = "LOCALIZACION = '$localizacion'";

#tratado especial a categoria y estado para que no guarde la opcion "Elige..."
if ($categoria){
    if(strcmp('Elige...',$categoria)!==0){
        $updates[] = "IDCATEGORIA = '$categoria'";
    }
} 
if ($estado) {
    if(strcmp('Elige...', $estado) !== 0 ){
        $updates[] = "ESTADO = '$estado'";
    }
}


if ($precio) $updates[] = "PRECIO = '$precio'";
if ($participantes) $updates[] = "NUMEROMAXPARTICIPANTES = $participantes";
if ($fechainicioinscripcion) $updates[] = "FECHA_INICIO_INSCRIPCION = '$fechainicioinscripcion'";
if ($fechainicio) $updates[] = "FECHA_INICIO = '$fechainicio'";
if ($fechafin) $updates[] = "FECHA_FIN = $fechafin";
if (!empty($imagen)) $updates[] = "IMAGEN = '$imagen'";

// Solo ejecutar la consulta si hay algo que actualizar
if (!empty($updates)) {
    $sql = "UPDATE EVENTO SET " . implode(', ', $updates) . " WHERE id = " . $id;

    if ($db->query($sql) === TRUE) {

        # ACTUALIZAR EL LOG PARA REGISTRAR QUE TENICO HA ACTUALIZADO AL USUARIO
        $registroLog = "INSERT INTO REGISTROLOG(MENSAJE, ID_TECNICO, ID_EVENTO) VALUES (?,?,?)";
        $prepared = $db->prepare($registroLog);
        $idTecnico = $_SESSION['idTecnicoActual'];
        $mensaje = "Se ha actualizado un evento";
        $prepared->bind_param("sii", $mensaje, $idTecnico, $id);
        $prepared->execute();

        echo "<script>
            location.href = '../../dashboard/listado_eventos.php';
            alert('¡Cambios realizados con éxito!');</script>";
        
    } else {
        echo "Error actualizando el registro: " . $db->error;
    }
} else {
    echo "<script>
            location.href = '../../dashboard/listado_eventos.php';
            alert('No hay cambios que realizar');</script>";
}
