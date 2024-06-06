<?php
$message = "";
$valid = 'true';
include("conexionBD.php");
include '../utilidades/funciones.php';
session_start();



//se recibe por la url la key y el email y se comprueba que exista una petición de recuperar contraseña
if (isset($_GET['key']) && isset($_GET['email'])) {
  $key = $_GET['key'];
  $email = $_GET['email'];
  $check = mysqli_query($db, "SELECT * FROM olvidar_contraseña WHERE email='$email' and clave_temporal='$key'");
  $row = mysqli_fetch_array($check, MYSQLI_ASSOC);




  #mysql_fetch_array($result, MYSQL_ASSOC);
  if (mysqli_num_rows($check) != 1) {
    echo "Esta url es invalida o ya ha sido usada. Por favor, verifiquela de nuevo";
    exit;
  } else
    $creado = strtotime($row['creado']);
  $ahora = time();
  $diferencia = $ahora - $creado;
  if ($diferencia > 300) { // 300 segundos = 5 minutos
    mysqli_query($db, "DELETE FROM olvidar_contraseña WHERE email='$email' AND clave_temporal='$key'");
    echo "El tiempo límite ha sido superado. El registro ha sido eliminado.";
    exit;
  }
} else {
  header('location:../index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $password1 = mysqli_real_escape_string($db, $_POST['password1']);
  $password2 = mysqli_real_escape_string($db, $_POST['password2']);


  #extraemos el id del tecnico
  $extraerID = "SELECT ID FROM TECNICO WHERE EMAIL = ?";
  $stmtID = $db->prepare($extraerID);
  $stmtID->bind_param("s", $email);
  $stmtID->execute();
  $resultID = $stmtID->get_result();
  $filaID = $resultID->fetch_assoc();

  #extraer combinación del técnico
  $combinacionQuery = "SELECT COMBINACION FROM COMBINACIONTECNICO WHERE IDTECNICO = ?";
  $stmtComb = $db->prepare($combinacionQuery);
  $stmtComb->bind_param("i", $filaID['ID']);
  $stmtComb->execute();

  // Obtener el resultado
  $resultComb = $stmtComb->get_result();
  $filaComb = $resultComb->fetch_assoc();

  if ($password2 == $password1) {

    #comprobar que la contraseña sigue los requisitos minimos
    $regexContrasenia = '/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8,}$/';

    if (!preg_match($regexContrasenia, $password1)) {
      $message = "La contraseña que has introducido no sigue los mínimos\n";
    } else {
      $message_success = "Se ha creado una nueva contraseña para el correo " . $email;
      $password = hash("sha256", $password1 . $filaComb['COMBINACION']);
      //se destruye la clave de la tabla
      mysqli_query($db, "DELETE FROM olvidar_contraseña where email='$email' and clave_temporal='$key'");
      //se modifica la contraseña
      mysqli_query($db, "UPDATE tecnico set contrasenia='$password' where email='$email'");
      sleep(2);
      header('Location:../index.php');
    }
  } else {
    $message = "Las contraseñas no son iguales, verificalas";
  }
}

?>


<!DOCTYPE html>
<html>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../CSS/sidebar.css">
  <title>Cambiar contraseña</title>
  <script>
            function myFunction() {
                var x = document.getElementById("contraseniaLogin");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
  </script>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounder-5 p-3 bg-white shadow box-area">
      <div class="col-md-6">
        <form role="form" method="POST">
          <label>Por favor, introduzca su nueva contrseña</label><br><br>
          <div class="form-group">
            <input type="password" class="form-control mt-2" id="pwd" name="password1" placeholder="Contraseña">
            <i class="bi bi-eye-slash" id="togglePassword" onclick="myFunction()"></i>
          </div>
          <div class="form-group">
            <input type="password" class="form-control mt-2" id="pwd" name="password2" placeholder="Vuelve a escribir la contraseña">
            
          </div>
          <?php if (isset($error)) {
            echo "<div class='alert alert-danger' role='alert'>
                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>" . $error . "</div>";
          } ?>
          <?php if ($message <> "") {
            echo "<div class='alert alert-danger' role='alert'>
                    <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>" . $message . "</div>";
          } ?>
          <?php if (isset($message_success)) {
            echo "<div class='alert alert-success' role='alert'>
                    <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>" . $message_success . "</div>";
          } ?>
          <button type="submit" class="btn btn-primary pull-right mt-2" name="submit" style="display: block; width: 100%;">Guardar contraseña</button>
          <br><br>
          <label>Este enlace solo funcionará una vez durante un limite de tiempo.</label>
          <small> <a href="../index.html">Vuelve al inicio</a></small>
          <br>
        </form>
      </div>
      <div class="col-md-6">
        <br><br>
        <div class="row alert alert-primary h-1000 " role="alert" id="informacionPass"><small>La contraseña debe tener:</small>

          <small>- Al menos 8 caracteres</small>
          <small>- Al menos una letra mayúscula (A-Z)</small>
          <small>- Al menos una letra minúscula (a-z)</small>
          <small>- Al menos tres letras minúsculas adicionales (a-z)</small>
          <small>- Al menos un número (0-9)</small>
          <small>- Al menos un carácter especial (!@#$&*)</small>
        </div>
      </div>
    </div>
    <div class="row">

    </div>
</body>




</html>