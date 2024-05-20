<?php

include 'conexionBD.php';

session_start();

$id = $_SESSION["idusuario"];

#Extraemos los campos del formulario que no estén vacios

$username = !empty($_POST['username']) ? $_POST['username'] : null;
$nombreCompleto = !empty($_POST['nombrecompleto']) ? $_POST['nombrecompleto'] : null;
$email = !empty($_POST['email']) ? $_POST['email'] : null;
$provincia = !empty($_POST['provincia']) ? $_POST['provincia'] : null;
$poblacion = !empty($_POST['poblacion']) ? $_POST['poblacion'] : null;
$cp = !empty($_POST['cp']) ? $_POST['cp'] : null;
$nuevapass = !empty($_POST['nuevapass']) ? $_POST['nuevapass'] : null;

$camposnovacios = [];

#comprobamos que la contraseña es igual (Lo podriamos hacer con javascript)
if ($nuevapass && $confirmar_password && $nuevapass === $confirmar_password) {
    $result = $conn->query("SELECT contrasenia FROM Usuario WHERE id = $user_id");
    $row = $result->fetch_assoc();
    $encryptedpass = sha1($nuevapass);
    if (password_verify($encryptedpass, $row['password'])) {
        $updates[] = "password = '$encryptedpass'";
    } else {
        die("La contraseña actual es incorrecta.");
    }
}

// Agregar los campos a actualizar si no están vacíos
if ($username) $updates[] = "usuario = '$username'";
if ($email) $updates[] = "email = '$email'";
if ($provincia) $updates[] = "provincia = '$provincia'";
if ($poblacion) $updates[] = "poblacion = '$poblacion'";
if ($cp) $updates[] = "CP = $cp";

// Solo ejecutar la consulta si hay algo que actualizar
if (!empty($updates)) {
    $sql = "UPDATE Usuario SET " . implode(', ', $updates) . " WHERE id = $id";

    if ($db->query($sql) === TRUE) {
        header('Location:../dashboard/listado_usuarios.php');
    } else {
        echo "Error actualizando el registro: " . $db->error;
    }
} else {
    echo "<script>alert('No hay cambios que realizar');
            location.href = '../dashboard/listado_usuarios.php';</script>";
    
}


?>