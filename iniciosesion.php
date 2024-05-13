<?php

include 'conexionBD.php';

session_start();
$usuario = $_POST['nombreUsuario'];
$contrasenia = $_POST['contrasenia'];

# Prevenir sql injection

$usuario = stripcslashes($usuario);
$contrasenia = stripcslashes($contrasenia);
$usuario = mysqli_real_escape_string($db, $usuario);
$contrasenia = mysqli_real_escape_string($db, $contrasenia);


$contrasenia = sha1($contrasenia);


#extraer de la base de datos el usuario mediante consulta sql

$consultaSQL = "SELECT nombreusuario, contrasenia FROM usuario WHERE nombreusuario like '$usuario' AND contrasenia like '$contrasenia'";



$resultado = mysqli_query($db, $consultaSQL)
    or die(mysqli_error($db));

$numeroRegistros = mysqli_fetch_array($resultado);

if($numeroRegistros){
    header('Location: conexion_correcta.php');
    $_SESSION['nombreUsuario'] = $usuario;
    #variable para comprobar la sesion con un numero >0
    $_SESSION['conectado'] = 1;
}

else{
    echo '<script type="text/javascript">alert("ACCESO DENEGADO");
                    window.location = "index.php"</script>';
}


mysqli_close($db);


?>