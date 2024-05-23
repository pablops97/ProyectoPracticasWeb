<?php

include 'conexionBD.php';

session_start();
$usuario = $_POST['nombreUsuario'];
$contrasenia = $_POST['contrasenia'];

// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

# Prevenir sql injection

$usuario = stripcslashes($usuario);
$contrasenia = stripcslashes($contrasenia);
$usuario = mysqli_real_escape_string($db, $usuario);
$contrasenia = mysqli_real_escape_string($db, $contrasenia);





# EXTRAEMOS EL ID DEL USUARIO

$extraerID = "SELECT id FROM tecnico WHERE nombreusuario = ?";
$stmt = $db->prepare($extraerID);
$stmt->bind_param("s", $usuario);
$stmt->execute();

// Obtener el resultado
$result = $stmt->get_result();
$fila = $result->fetch_assoc();

if ($fila) {
    #extraemos la combinacion para añadirsela a la contraseña
    $extraerID = "SELECT combinacion FROM combinaciontecnico WHERE idtecnico = ?";
    $stmt = $db->prepare($extraerID);
    $stmt->bind_param("i", $fila['id']);
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();

    if ($fila) {
        

        #utilizamos bcrypt para mayor seguridad
        $contraseniafinal = hash("sha256", $contrasenia . $fila['combinacion']);

        #extraer de la base de datos el usuario mediante consulta sql

        $consultaSQL = "SELECT nombreusuario FROM TECNICO WHERE nombreusuario like '$usuario' AND contrasenia like '$contraseniafinal'";



        $resultado = mysqli_query($db, $consultaSQL)
            or die(mysqli_error($db));

        $numeroRegistros = mysqli_fetch_array($resultado);

        if ($numeroRegistros) {
            $_SESSION['nombreUsuario'] = $usuario;
            #variable para comprobar la sesion con un numero >0
            $_SESSION['conectado'] = 1;

            if (!empty($_POST["mantenerConectado"])) 
            { 
  
                // Username is stored as cookie for 10 years as 
                // 10years * 365days * 24hrs * 60mins * 60secs 
                setcookie("user_login", $usuario, time() + 
                                    (10 * 365 * 24 * 60 * 60)); 
  
            } 
            $_SESSION['conectado'] = true;
            header('Location: ../dashboard/home.php');
        } else {
            echo '<script type="text/javascript">alert("Acceso denegado");
                    location.href = "../index.php"</script>';
            
        }
    }else{
        echo '<script type="text/javascript">alert("Error");
                    location.href = "../index.php"</script>';
    }
} else {
    echo '<script type="text/javascript">alert("No existe el usuario");
                    location.href = "../index.php"</script>';
}






mysqli_close($db);
