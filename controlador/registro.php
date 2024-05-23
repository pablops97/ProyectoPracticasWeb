<?php

define("MAX_LENGTH", 16);
include 'conexionBD.php';
include '../utilidades/funciones.php';
session_start();


if ($_SESSION['conectado']) {
    header('Location:localhost/login/index.html');
} else {

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

    $salt = generateNumericSalt();

    $contraseniafinal = hash("sha256", $contrasenia . $salt);






    #Metodo para comprobar si existe un usuario en la base de datos con ese nombre

    $comprobarUsuario = mysqli_query($db, "SELECT NOMBREUSUARIO FROM TECNICO WHERE NOMBREUSUARIO = '$usuario'");

    $numeroRegistros = mysqli_fetch_array($comprobarUsuario);

    if ($numeroRegistros > 0) {
        echo '<script>window.alert("Ese usuario ya está registrado");
                  window.location = "../index.php";</script>';
    } else {
        $resultadoConsulta = mysqli_query($db, "INSERT INTO TECNICO (nombreusuario, contrasenia, email, telefono) values ('$usuario', '$contraseniafinal', '$email', '$telefono')");
        $_SESSION['nombreUsuario'] = $usuario;
        $_SESSION['conectado'] = true;


        #Extraemos el id del nuevo usuario


        try {
            // Preparar y ejecutar la consulta para extraer el ID
            $extraerID = "SELECT ID FROM TECNICO WHERE NOMBREUSUARIO = ?";
            $stmt = $db->prepare($extraerID);
            $stmt->bind_param("s", $usuario);
            $stmt->execute();

            // Obtener el resultado
            $result = $stmt->get_result();
            $fila = $result->fetch_assoc();

            // Verificar si se obtuvo un resultado
            if ($fila) {
                $id = $fila['ID'];

                // Preparar y ejecutar la consulta para insertar la combinación
                $insertarCombinacion = "INSERT INTO combinaciontecnico (idtecnico, combinacion) VALUES (?, ?)";
                $stmt = $db->prepare($insertarCombinacion);
                $stmt->bind_param("ii", $id, $salt);
                $stmt->execute();

                echo '<script>window.alert("¡Usuario registrado con éxito!");
                    location.href = "../dashboard/home.php";</script>';
            } else {
                // Manejo del caso en que no se encuentra el usuario
                throw new Exception("Usuario no encontrado");
            }
        } catch (PDOException $e) {
            // Manejo de errores de PDO
            echo "Error en la base de datos: " . $e->getMessage();
        } catch (Exception $e) {
            // Manejo de otros errores
            echo "Error: " . $e->getMessage();
        }
    }


    mysqli_close($db);
}
