<?php

include '../conexionBD.php';
include '../../utilidades/funciones.php';

session_start();

$id = $_SESSION["idusuario"];


# Identificacion de imagen 
# SUBIR IMAGEN AL SERVIDOR

$target_dir = "../../Images/";
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

$username = !empty($_POST['username']) ? $_POST['username'] : null;
$nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : null;
$apellidos = !empty($_POST['apellidos']) ? $_POST['apellidos'] : null;
$email = !empty($_POST['email']) ? $_POST['email'] : null;
$provincia = !empty($_POST['provincia']) ? $_POST['provincia'] : null;
$poblacion = !empty($_POST['poblacion']) ? $_POST['poblacion'] : null;
$cp = !empty($_POST['cp']) ? $_POST['cp'] : null;
$nuevapass = !empty($_POST['nuevapass']) ? $_POST['nuevapass'] : null;
$confirmar_password = !empty($_POST['confirmarpass']) ? $_POST['confirmarpass'] : null;

$updates = [];

#comprobamos que la contraseña es igual (Lo podriamos hacer con javascript)
if ($nuevapass && $confirmar_password && $nuevapass === $confirmar_password) {
    $result = $db->query("SELECT password FROM Usuario WHERE id = $id");
    $row = $result->fetch_assoc();

    $extraerCombinacion = "SELECT combinacion FROM combinacionusuario WHERE idusuario = ?";
    $stmt = $db->prepare($extraerCombinacion);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();

    #si hay resultados, obtenemos la combinacion y encriptamos la contraseña
    if ($fila) {

        $contraseniafinal = hash("sha256", $contrasenia . $fila['combinacion']);
        $updates[] = "password = '$contraseniafinal'";

        #si no, generamos una combinacion, la introducimos en la tabla y encriptamos la contraseña con esa combinacion
    } else {
        $combinacion = generateNumericSalt();
        $insertarCombinacion = "INSERT INTO COMBINACIONUSUARIO(IDUSUARIO, COMBINACION) VALUES (?, ?)";
        $insert = $db->prepare($insertarCombinacion);
        $insert->bind_param("ii", $id, $combinacion);
        $insert->execute();
        $contraseniafinal = hash("sha256", $contrasenia . $combinacion);
        $updates[] = "password = '$contraseniafinal'";
    }
} elseif ($nuevapass && $confirmar_password && $nuevapass !== $confirmar_password) {
    echo '<script>alert("Las contraseñas no son iguales, no se modificará");
                   </script>';                    
}

// Agregar los campos a actualizar si no están vacíos
if ($username) $updates[] = "usuario = '$username'";
if ($email) $updates[] = "email = '$email'";
if ($nombre) $updates[] = "nombre = '$nombre'";
if ($apellidos) $updates[] = "apellidos = '$apellidos'";
if ($provincia) $updates[] = "provincia = '$provincia'";
if ($poblacion) $updates[] = "poblacion = '$poblacion'";
if ($cp) $updates[] = "CP = $cp";
if (!empty($imagen)) $updates[] = "imagen = '$imagen'";

// Solo ejecutar la consulta si hay algo que actualizar
if (!empty($updates)) {
    $sql = "UPDATE Usuario SET " . implode(', ', $updates) . " WHERE id = $id";

    if ($db->query($sql) === TRUE) {

        # ACTUALIZAR EL LOG PARA REGISTRAR QUE TENICO HA ACTUALIZADO AL USUARIO
        $registroLog = "INSERT INTO REGISTROLOG(MENSAJE, ID_TECNICO, ID_USUARIO) VALUES (?,?,?)";
        $prepared = $db->prepare($registroLog);
        $idTecnico = $_SESSION['idTecnicoActual'];
        $mensaje = "Se ha actualizado un usuario";
        $prepared->bind_param("sii", $mensaje, $idTecnico, $id);
        $prepared->execute();

        header('Location:../dashboard/listado_usuarios.php');
    } else {
        echo "Error actualizando el registro: " . $db->error;
    }
} else {
    echo "<script>alert('No hay cambios que realizar');
            location.href = '../../dashboard/listado_usuarios.php';</script>";
}
