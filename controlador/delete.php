<?php
session_start();
if (isset($_SESSION['conectado']) && $_SESSION['conectado']) {
    if (isset($_GET["user"])) {
        $id = intval($_GET["user"]);  // Convierte el id a un entero para mayor seguridad

        include 'conexionBD.php';  // Asegúrate de incluir la conexión a la base de datos

        // Preparar la consulta para evitar inyecciones SQL
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $db->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                // Redireccionar después de la eliminación
                header('Location:../dashboard/listado_usuarios.php');
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
    header('Location: ../index.php');
    exit;
}