<?php
session_start();
include 'conexionBD.php';

# Registrar el abandono de sesion
$registroLog = "INSERT INTO REGISTROLOG(MENSAJE, ID_TECNICO) VALUES (?,?)";
$prepared = $db->prepare($registroLog);
$idTecnico = $_SESSION['idTecnicoActual'];
$mensaje = "Ha cerrado sesión";
$prepared->bind_param("si", $mensaje, $idTecnico);
$prepared->execute();

// Destruir todas las variables de sesión.
$_SESSION = array();

#eliminar cookie de sesion
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"]
    );
}

// Finalmente, destruir la sesión.

session_destroy();
header('Location:../index.php');
?>