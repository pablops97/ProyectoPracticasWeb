<?php

include '../conexionBD.php';
session_start();
if($_SESSION["conectado"]){
    if($_SERVER["REQUEST_METHOD"] && $_SERVER["REQUEST_METHOD"] == "GET"){
        $idMatricula = $_GET["idmatriculacion"];
        $idUsuario = $_GET['idusuario'];

        //obtener la fecha de hoy
        $fechaActual = date("Y-m-d");

        // Preparar la consulta para evitar inyecciones SQL
        $sql = "UPDATE matriculacion SET FECHA_ANULADO = ?, ESTADO = 'Eliminada' WHERE IDMATRICULACION = ?";
        $stmt = $db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $fechaActual, $idMatricula);
            if ($stmt->execute()) {

                # ACTUALIZAR EL LOG PARA REGISTRAR QUE TENICO HA DADO DE BAJA A QUE USUARIO
                $registroLog = "INSERT INTO REGISTROLOG(MENSAJE, ID_TECNICO, ID_USUARIO, ID_MATRICULA) VALUES (?,?,?,?)";
                $prepared = $db->prepare($registroLog);
                $idTecnico = $_SESSION['idTecnicoActual'];
                $mensaje = "Se ha retirado el usuario del evento";
                $prepared->bind_param("siii", $mensaje, $idTecnico, $idUsuario, $idMatricula);
                $prepared->execute();

                // Redireccionar después de la eliminación
                header('Location:../../dashboard/listado_usuarios_eventos.php');
                exit;
            } else {
                echo "Error eliminando el registro: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparando la consulta: " . $db->error;
        }
    }
}else{
    header('Location: ../../index.php');
}


?>