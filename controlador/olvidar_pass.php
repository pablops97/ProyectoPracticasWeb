<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

$message = "";
$valid = 'true';
include("conexionBD.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_reg = mysqli_real_escape_string($db, $_POST['cambiarEmail']);
    $details = mysqli_query($db, "SELECT email FROM usuario WHERE email='$email_reg'");
    if (mysqli_num_rows($details) > 0) {
        $message_success = " Por favor, comprueba tu bandeja de entrada o la carpeta de spam y sigue los siguientes pasos";
        //Genera una clave aleatoria
        $key = md5(time() + 123456789 % rand(4000, 55000000));
        //Inserta la clave temporal en la base de datos
        $sql_insert = mysqli_query($db, "INSERT INTO olvidar_contraseña(email,clave_temporal) VALUES('$email_reg','$key')");



        ## servicio de gmail nifd yxct xyxm oqka 


        require 'vendor/autoload.php'; // Path a la carpeta vendor de PHPMailer


        # Configurar el servicio de SMTP para enviar correos
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'proyectofinciclodam@gmail.com';
            $mail->Password = 'jukp mhji fgmw pvdk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // Puerto SMTP
            $mail->setFrom('proyectofinciclodam@gmail.com', 'Pablo developer');
            $mail->addAddress($email_reg);
            $mail->Subject = 'Nueva contraseña APP PROYECTO';
            $htmlMsg = '<a href="localhost/login/controlador/olvidar_pass_reset.php?key=" . $key . "&email=" . $email_reg"/>';
            $mail->Body = "^^ " . "\r\n" . "Pulse " .   $htmlMsg . " para continuar con el proceso de cambio de contraseña ^^";
            $mail->isHTML(true);
            $mail->send();
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        $message = " Lo sentimos, no hay cuenta de correo asociada a este email";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/style.css" />
    <title>Contraseña olvidada</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounder-5 p-3 bg-white shadow box-area"><br><br><br>
            <div class="col-md-4"></div>
            <div class="col-md-12">
                    <form role="form" method="POST">
                        <div class="form-group">
                            <label>Por favor, introduce tu email para recuperar la contraseña</label><br><br>
                            <input class="form-control" id="cambiarEmail" name="cambiarEmail" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Email">
                        </div>

                        <?php if (isset($error)) {
                            echo "<div class='alert alert-danger mt-3' role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>" . $error . "</div>";
                        } ?>
                        <?php if ($message <> "") {
                            echo "<div class='alert alert-danger mt-3' role='alert'>
                      <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>" . $message . "</div>";
                        } ?>
                        <?php if (isset($message_success)) {
                            echo "<div class='alert alert-success mt-3' role='alert'>
                      <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                      <span class='sr-only'>Error:</span>" . $message_success . "</div>";
                        } ?>
                        <button type="submit" class="btn btn-primary pull-right mt-4" name="submit" style="display: block; width: 100%;">Send Email</button>
                        <br><br>
                        <center><a href="../index.php">Volver al inicio de sesión</a></center>
                        <br>
                    </form>

            </div>
        </div>
    </div>
</body>

</html>

?>