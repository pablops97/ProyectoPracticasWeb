<?php
session_start();
$_SESSION['conectado'] = false;
if (!$_SESSION['conectado']) {

?>

    <!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
    <!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Inicio de sesión</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- añadimos boostrap al proyecto -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="CSS/style.css" />
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!--API GOOGLE-->
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="439422053220-tu5pji8mo5p40fm9vp79gi91atll43gu.apps.googleusercontent.com">

        <!--Funcion para limpir los input de la pagina-->
        <script>
            function limpiarFormulario() {
                document.getElementById("formulario").reset;
            }
        </script>
        <style>
            form i {
                margin-left: -30px;
                cursor: pointer;
            }
        </style>
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

    <body class="bg-white" onload="limpiarFormulario()">
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <main>

            <!--CONTENEDOR PRINCIPAL-->

            <div class="container d-flex justify-content-center align-items-center min-vh-100">



                <!--CONTENEDOR login-->


                <div class="row border rounder-5 p-3 bg-white shadow box-area flip-card" id="tarjeta">

                    <!--Formulario-->
                    <div class="col-md-6 parte-delantera ">
                        <div class="row d-flex justify-content-center align-items-center h-1000">
                            <img src="https://static4.depositphotos.com/1013084/343/v/450/depositphotos_3430480-stock-illustration-sport-silhouettes.jpg" class="img-fluid">
                        </div>
                        <div class="row alert alert-primary h-1000 d-none " role="alert" id="informacionPass"><small>La contraseña debe tener:</small>

                            <small>- Al menos 8 caracteres</small>
                            <small>- Al menos una letra mayúscula (A-Z)</small>
                            <small>- Al menos una letra minúscula (a-z)</small>
                            <small>- Al menos tres letras minúsculas adicionales (a-z)</small>
                            <small>- Al menos un número (0-9)</small>
                            <small>- Al menos un carácter especial (!@#$&*)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center" id="parte-delantera">
                            <div class="header-text mb-4">
                                <p style="text-align: center;">Inicio de sesión</p>
                            </div>
                            <form method="post" action="controlador/iniciosesion.php" id="formulario">
                                <label for="nombreUsuario">Usuario</label><span class="obligatory">*</span>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control bg-light" id="nombreUsuario" name="nombreUsuario" placeholder="Introduce usuario" minlength="5" maxlength="16" required>
                                </div>

                                <label for="contrasenia" placeholder="Introduce contraseña">Contraseña</label><span class="obligatory">*</span>
                                <div class="input-group mb-3"><input type="password" class="form-control bg-light" id="contraseniaLogin" name="contrasenia" placeholder="Introduce contraseña" minlength="5" maxlength="16" required>
                                    <i class="bi bi-eye-slash" id="togglePassword" onclick="myFunction()"></i>
                                </div>

                                <div class="row">
                                    <div class="col-md-7"></div>
                                    <div class="col-md-5">
                                        <small>Mantener conectado</small>
                                        <input class="form-check-input" type="checkbox" name="mantenerConectado" id="mantenerConectado" style="margin-left: 5%;">
                                    </div>
                                </div>

                                <div class="input-group mb-4">
                                    <button class="btn btn-md btn-primary w-100" id="botonInicioSesion" style="margin-top: 2%;">Iniciar Sesion</button>
                                </div>
                                <div class="row">
                                    <small>¿Has olvidado la contraseña? <a class="text-primary" href="controlador/olvidar_pass.php" id="cambiarContraseña">Pulse aquí</a></small>
                                </div>

                                <!--En caso de querer añadir funcionalidad con inicio de sesión mediante api de google añadir otro botón-->

                                <div class="row">
                                    <small>¿No tienes cuenta? <a class="text-primary" id="flip">Registrate desde aqui</a></small>
                                </div>
                            </form>

                        </div>

                        <!-- Registro -->
                        <div class="row align-items-center" id="parte-trasera">
                            <div class="header-text mb-4">
                                <p style="text-align: center;">Registro nuevo usuario</p>
                            </div>
                            <form method="post" action="controlador/registro.php">
                                <label for="nombreUsuario">Usuario</label><span class="obligatory">*</span>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="nombreUsuarioRegistro" name="nombreUsuarioRegistro" placeholder="Introduce nombre de usuario" minlength="5" maxlength="16" required oninput="restriccionUsuario(value, 'nombreUsuarioRegistro')">
                                </div>
                                <label for="contrasenia" placeholder="Introduce contraseña">Contraseña</label><span class="obligatory">*</span>
                                <div class="input-group mb-3"><input type="password" class="form-control" id="contraseniaRegistro" name="contraseniaRegistro" placeholder="Introduce contraseña" minlength="7" maxlength="16" required onfocus="mostrarInfo()" onblur="ocultarInfo()" oninput="restriccionPass(value, 'contraseniaRegistro')">
                                </div>
                                <label for="email">Correo electrónico</label>
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" id="emailRegistro" name="emailRegistro" placeholder="Introduce correo electrónico" oninput="verificarEmail('emailRegistro')">
                                </div>
                                <label for="telefono">Teléfono</label>
                                <div class="input-group mb-3">
                                    <input type="tel" class="form-control" id="telefono" name="telefonoRegistro" maxlength="9" placeholder="Introduce su teléfono" oninput="restriccionNumero(value, 'telefonoRegistro')">
                                </div>


                                <div class="input-group mb-4">
                                    <button class="btn btn-md btn-primary w-100" id="botonRegistro">Registrarse</button>
                                </div>

                                <div class="row">
                                    <small>¿Ya tienes cuenta? <a class="text-primary" id="flip-reverse">Inicia sesión</a></small>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>



        </main>
        <script>
            //Uso de una api para comprobar si el correo existe
            function httpGetAsync(url, callback) {
                const xmlHttp = new XMLHttpRequest();
                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState === 4 && xmlHttp.status === 200)
                        callback(xmlHttp.responseText);
                }
                xmlHttp.open("GET", url, true); // true for asynchronous
                xmlHttp.send(null);
            }

            // Función para validar un correo electrónico utilizando la API de Abstract API
            function validarEmail(id) {
                const email = document.getElementById(id);
                const apiKey = "92d5c47a8c534ebd9f4b1317701d0c96";
                const url = `https://emailvalidation.abstractapi.com/v1/?api_key=${apiKey}&email=${encodeURIComponent(email)}`;

                httpGetAsync(url, function(response) {
                    const resultado = JSON.parse(response);
                    if (resultado.deliverability === "DELIVERABLE") {
                        console.log("El correo electrónico es válido.");
                        document.getElementById(id).style.color = green;
                    } else {
                        console.log("El correo electrónico no es válido.");
                        document.getElementById(id).style.color = red;
                    }
                });
            }
        </script>
        <script src="JS/funcionesRegex.js"></script>
        <script src="JS/animacionLogin.js"></script>
        <script src="JS/regexRegistro.js"></script>
    </body>

    </html>

<?php
} else {
    header('Location:dashboard/home.php');
}
?>