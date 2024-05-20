<?php
$message = "";
$valid = 'true';
include("conexionBD.php");
session_start();
if (!$_SESSION['interactuando']) {
  header('Location:../index.php');
} else {


  //se recibe por la url la key y el email y se comprueba que exista una petición de recuperar contraseña
  if (isset($_GET['key']) && isset($_GET['email'])) {
    $key = $_GET['key'];
    $email = $_GET['email'];
    $check = mysqli_query($db, "SELECT * FROM olvidar_contraseña WHERE email='$email' and clave_temporal='$key'");
    $row = mysqli_fetch_array($check, MYSQLI_ASSOC);



    #variable donde almacenar la hora actual del sistema

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
    if ($password2 == $password1) {
      $message_success = "Se ha creado una nueva contraseña para el correo " . $email;
      $password = sha1($password1);
      //se destruye la clave de la tabla
      mysqli_query($db, "DELETE FROM olvidar_contraseña where email='$email' and clave_temporal='$key'");
      //ae modifica la contraseña
      mysqli_query($db, "UPDATE usuario set contrasenia='$password' where email='$email'");
    } else {
      $message = "verifica tu contraseña";
    }
  }

?>


  <!DOCTYPE html>
  <html>

  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <title>Cambiar contraseña</title>
  </head>

  <body>
    <div class="container">
      <div class="row"><br><br><br>
        <div class="col-md-4"></div>
        <div class="col-md-4" style="background-color: #D2D1D1; border-radius:15px;">
          <br><br>
          <form role="form" method="POST">
            <label>Por favor, introduzca su nueva contrseña</label><br><br>
            <div class="form-group">
              <input type="password" class="form-control" id="pwd" name="password1" placeholder="Password">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="pwd" name="password2" placeholder="Re-type Password">
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
            <button type="submit" class="btn btn-primary pull-right" name="submit" style="display: block; width: 100%;">Guardar contraseña</button>
            <br><br>
            <label>Este enlace solo funcionará una vez durante un limite de tiempo.</label>
            <small> <a href="../index.html">Vuelve al inicio</a></small>
            <br>
          </form>
        </div>
      </div>
  </body>

  </html>
<?php

}

?>