<?php

include 'conexionBD.php';
session_start();


if($_SESSION['conectado'] == 1){
    header('Location:localhost/login/index.html');
}else{

$usuario = $_POST['nombreUsuario'];
$contrasenia = $_POST['contrasenia'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];

# Prevenir sql injection

$usuario = stripcslashes($usuario);
$contrasenia = stripcslashes($contrasenia);
$usuario = mysqli_real_escape_string($db, $usuario);
$contrasenia = mysqli_real_escape_string($db, $contrasenia);

$email = stripcslashes($email);
$telefono = stripcslashes($telefono);
$email = mysqli_real_escape_string($db, $email);
$telefono = mysqli_real_escape_string($db, $telefono);

# Encriptar contraseña

$contrasenia = sha1($contrasenia);



#Metodo para comprobar si existe un usuario en la base de datos con ese nombre

$comprobarUsuario = mysqli_query($db, "SELECT NOMBREUSUARIO FROM TECNICO WHERE NOMBREUSUARIO LIKE '$usuario'");

$numeroRegistros = mysqli_fetch_array($comprobarUsuario);

if($numeroRegistros > 0){
    echo '<script>window.alert("Ese usuario ya está registrado");
                  window.location = "index.php";</script>';
}

else{
    $resultadoConsulta = mysqli_query($db, "INSERT INTO TECNICO (nombreusuario, contrasenia, email, telefono) values ('$usuario', '$contrasenia', '$email', '$telefono')");
    $_SESSION['nombreUsuario'] = $usuario;
    echo '<script>window.alert("¡Usuario registrado con éxito!");
                    window.location = "conexion_correcta.php";</script>';
    
}


mysqli_close($db);

}
?>