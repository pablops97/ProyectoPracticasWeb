<?php
include '../conexionBD.php';
session_start();
if (isset($_SESSION['conectado']) && $_SESSION['conectado']) {
    if (isset($_GET["event"])) {
        $id = intval($_GET["event"]);  // Convierte el id a un entero para mayor seguridad

        


        //obtener la fecha de hoy
        $estado = 'Eliminado';

        // Preparar la consulta para evitar inyecciones SQL
        $sql = "UPDATE evento SET ESTADO = ? WHERE id = ?";
        $stmt = $db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $estado, $id);
            if ($stmt->execute()) {

                # ACTUALIZAR EL LOG PARA REGISTRAR QUE TENICO HA DADO DE BAJA A QUE USUARIO
                $registroLog = "INSERT INTO REGISTROLOG(MENSAJE, ID_TECNICO, ID_EVENTO) VALUES (?,?,?)";
                $prepared = $db->prepare($registroLog);
                $idTecnico = $_SESSION['idTecnicoActual'];
                $mensaje = "Se ha eliminado un evento";
                $prepared->bind_param("sii", $mensaje, $idTecnico, $id);
                $prepared->execute();

                // Redireccionar después de la eliminación
                header('Location:../../dashboard/listado_eventos.php');
                exit;
            } else {
                echo "Error eliminando el registro: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparando la consulta: " . $db->error;
        }




        $db->close();
    } else {
        echo "ID de usuario no proporcionado.";
    }
} else {
    echo "Acceso denegado. Por favor, inicie sesión.";
    // Redireccionar a la página de inicio de sesión u otra página de error
    header('Location:../../index.php');
    exit;
}
