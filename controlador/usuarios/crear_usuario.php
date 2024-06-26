<?php

include '../conexionBD.php';
include '../../utilidades/funciones.php';

session_start();
define("IMAGEN_PREDETERMINADA", "noimage.jpg");

if ($_SESSION['conectado']) {


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        #CREAMOS VARIABLES
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $username = $_POST['username'];
        $pass = $_POST['nuevapass'];
        $confirmarpass = $_POST['confirmarpass'];
        $email = $_POST['email'];
        $provincia = $_POST['provincia'];
        $poblacion = $_POST['poblacion'];
        $cp = $_POST['cp'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $direccion = $_POST['direccion'];
        $cuentaIBAN ='ES' . $_POST['cuentaIBAN']; #Le concateno ES porque no lo introducen en el formulario
        $socio = $_POST['socio'];
        $imagen = IMAGEN_PREDETERMINADA;
        $fecha_actual = date("Y-m-d");


        # SUBIR IMAGEN AL SERVIDOR

        $target_dir = "../../Images/";
        $target_file = $target_dir . basename($_FILES["subirImagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Comprobar si la imagen es real o no
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["subirImagen"]["tmp_name"]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }


        // Comprobar el tamaño de la foto
        if ($_FILES["subirImagen"]["size"] > 500000) {
            echo '<script>alert("Lo sentimos, su archivo es demasiado grande.")</script>';
            $uploadOk = 0;
        }


        // Comprobar si la variable $uploadOk se ha iniciado a 0 por error
        if ($uploadOk == 0) {
            #SI no ha subido archivo, la imagen será la predeterminada
            $imagen = IMAGEN_PREDETERMINADA;
            // Si todo sale bien, se sube la imagen
        } else {
            if (move_uploaded_file($_FILES["subirImagen"]["tmp_name"], $target_file)) {
                $imagen = basename($_FILES["subirImagen"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }



        #COMPROBAMOS SI EL USUARIO YA ESTÁ REGISTRADO CON ESE USERNAME O CORREO ELECTRONICO

        $comprobarExistencia = "SELECT * from usuario where usuario = ? or email = ?";
        $prepared = $db->prepare($comprobarExistencia);
        $prepared->bind_param("ss", $username, $email);
        $prepared->execute();
        $result = $prepared->get_result();
        $filas = $result->fetch_assoc();
        if ($filas) {
            echo '<script>
                alert("el nombre de usuario o el correo electronico que estas utilizando para crear al usuario ya existe en el sistema. No se ha podido crear correctamente.");
                location.href = "../../dashboard/listado_usuarios.php";
            </script>';
        } else {

            # codificar la contraseña

            # Encriptar contraseña

            $salt = generateNumericSalt();
            $contraseniafinal = hash("sha256", $pass . $salt);


            $sql = "INSERT INTO USUARIO (usuario, email, password, nombre, apellidos, direccion, CP, provincia, fecha_nacimiento, cuenta_iban, socio, Fecha_alta, imagen)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param(
                "ssssssisssiss",
                $username,
                $email,
                $contraseniafinal,
                $nombre,
                $apellidos,
                $direccion,
                $cp,
                $provincia,
                $fechaNacimiento,
                $cuentaIBAN,
                $socio,
                $fecha_actual,
                $imagen
            );

            if ($stmt->execute()) {


                # Obtener el id de este usuario que acabamos de crear

                $obtenerID = "SELECT id FROM USUARIO WHERE USUARIO = ? AND EMAIL = ?";
                $query = $db->prepare($obtenerID);
                $query->bind_param("ss", $username, $email);
                $query->execute();
                $resultado = $query->get_result();
                $fila = $resultado->fetch_assoc();

                if ($fila) {
                    $insertarCombinacion = "INSERT INTO COMBINACIONUSUARIO(IDUSUARIO, COMBINACION) VALUES(?,?)";
                    $queryComb = $db->prepare($insertarCombinacion);
                    $queryComb->bind_param("is", $fila["id"], $salt);
                    $queryComb->execute();

                    # ACTUALIZAR EL LOG PARA REGISTRAR QUE TENICO HA CREADO A QUE USUARIO (lo hago aqui para aprovechar la ID del usuario y no tener que realizar otra consulta)
                    $registroLog = "INSERT INTO REGISTROLOG(MENSAJE, ID_TECNICO, ID_USUARIO) VALUES (?,?,?)";
                    $prepared = $db->prepare($registroLog);
                    $idTecnico = $_SESSION['idTecnicoActual'];
                    $mensaje = "Se ha creado usuario";
                    $prepared->bind_param("sii", $mensaje, $idTecnico, $fila['id']);
                    $prepared->execute();
                }

                echo '<script>alert("Usuario creado con éxito.");
            location.href = "../../dashboard/listado_usuarios.php";</script>';
            } else {
                echo '<script>alert("El usuario no se pudo crear correctamente");
            location.href = "../../dashboard/listado_usuarios.php";</script>';
            }
        }
    }
}
