<?php

include '../conexionBD.php';

session_start();
define("IMAGEN_PREDETERMINADA", "evento.jpg");

if (isset($_SESSION['conectado']) && $_SESSION['conectado']) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        #CREAMOS VARIABLES
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $localizacion = $_POST['localizacion'];
        $categoria = $_POST['categoriaCrear'];
        $estado = $_POST['estadoCrear'];
        $precio = $_POST['precio'];
        $participantes = $_POST['participantes'];
        $fechainicioinscripcion = $_POST['fechainicioinscripcion'];
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
        $imagen = IMAGEN_PREDETERMINADA;
        $idTecnico = isset($_SESSION['idTecnicoActual']) ? $_SESSION['idTecnicoActual'] : null;

        # Verificación adicional para asegurarnos de que $idTecnico no sea nulo
        if (is_null($idTecnico)) {
            die('IDTECNICO no puede ser nulo');
        }

        # Depuración: imprimir valores
        echo "IDTECNICO: $idTecnico\n";
        echo "Título: $titulo\n";
        echo "Descripción: $descripcion\n";

        #FORMATEAR LAS FECHAS PARA PODER INSERTARLAS EN MYSQL
        $fechainicioinscripcion = date('Y-m-d', strtotime($fechainicioinscripcion));
        $fechainicio = date('Y-m-d H:i:s', strtotime($fechainicio));
        $fechafin = date('Y-m-d H:i:s', strtotime($fechafin));

        # SUBIR IMAGEN AL SERVIDOR
        $target_dir = "../../ImagenesEventos/";
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

        $sql = "INSERT INTO EVENTO (TITULO_EVENTO, DESCRIPCION_EVENTO, LOCALIZACION, ESTADO, PRECIO, FECHA_INICIO_INSCRIPCION, FECHA_INICIO, FECHA_FIN, IDCATEGORIA, NUMEROMAXPARTICIPANTES, IMAGEN, IDTECNICO)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param(
            "ssssdssssisi",
            $titulo,
            $descripcion,
            $localizacion,
            $estado,
            $precio,
            $fechainicioinscripcion,
            $fechainicio,
            $fechafin,
            $categoria,
            $participantes,
            $imagen,
            $idTecnico
        );

        if ($stmt->execute()) {

            # Obtener el id de este evento que acabamos de crear
            $obtenerID = "SELECT ID FROM EVENTO WHERE TITULO_EVENTO = ? AND DESCRIPCION_EVENTO = ? AND LOCALIZACION = ? AND PRECIO = ?";
            $query = $db->prepare($obtenerID);
            $query->bind_param("sssd", $titulo, $descripcion, $localizacion, $precio);
            $query->execute();
            $resultado = $query->get_result();
            $fila = $resultado->fetch_assoc();

            if ($fila) {

                # ACTUALIZAR EL LOG PARA REGISTRAR QUE TECNICO HA CREADO EL EVENTO
                $registroLog = "INSERT INTO REGISTROLOG(MENSAJE, ID_TECNICO, ID_EVENTO) VALUES (?,?,?)";
                $prepared = $db->prepare($registroLog);
                $mensaje = "Se ha creado un evento";
                $prepared->bind_param("sii", $mensaje, $idTecnico, $fila['ID']);
                $prepared->execute();
            }

            echo '<script>alert("Evento creado con éxito.");
            location.href = "../../dashboard/listado_eventos.php";</script>';
        } else {
            echo '<script>alert("El evento no se pudo crear correctamente");
            location.href = "../../dashboard/listado_eventos.php";</script>';
        }
    } else {
        header('Location:../../dashboard/listado_eventos.php');
    }
} else {
    echo 'No estás conectado.';
}
?>
