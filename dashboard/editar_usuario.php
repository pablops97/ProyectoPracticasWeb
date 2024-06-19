<?php
session_start();
if ($_SESSION['conectado']) {




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
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link href="../CSS/sidebar.css" rel="stylesheet" />
    </head>

    <?php
    if (isset($_GET["user"])) {
        $id = $_GET["user"];
        $_SESSION["idusuario"] = $id;

        include '../controlador/conexionBD.php';
        $query = "SELECT * FROM USUARIO WHERE ID = '$id'";
        $resultado = mysqli_query($db, $query);
        $fila = mysqli_fetch_array($resultado);
        if ($fila) {



    ?>
            <!-- EDITAR USUARIO -->

            <body>
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
                <div class="container d-flex justify-content-center align-items-center vh-100">
                    <div class="row flex-lg-nowrap" id="contenedorDatosUsuario">
                        <div class="col-12 col-lg-auto mb-3">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="mx-auto text-center" style="max-width: 100%;">
                                        <?php
                                        # Bucle para comprobar si la imagen existe en el directorio de imágenes, si no cargar la imagen predeterminada
                                        $files = scandir('../Images/');
                                        $encontrado = false;
                                        $nombreImagen = basename($fila["imagen"]);

                                        foreach ($files as $file) {
                                            if ($nombreImagen === $file) {
                                        ?>
                                                <img src="../Images/<?= htmlspecialchars($fila["imagen"], ENT_QUOTES, 'UTF-8') ?>" alt="foto" style="max-width: 75%; max-height: 75%; ">
                                            <?php
                                                $encontrado = true;
                                                break;
                                            }
                                        }

                                        if (!$encontrado) {
                                            ?>
                                            <img src="../Images/noimage.jpg" alt="foto" style="height:300px; width:300px;">
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                                <form class="form" action="../controlador/usuarios/update.php" method="post" enctype="multipart/form-data" id="formEditarUsuario">
                                    <div class="row mt-3 mb-3 d-none" id="contenedorCambiarImagen">
                                        <input type="file" name="cambiarImagen" id="cambiarImagen" accept="image/png, image/jpg, image/jpeg">
                                    </div>
                                    <div class="mt-2 text-center">
                                        <button class="btn btn-primary" type="button" onclick="document.getElementById('contenedorCambiarImagen').classList.remove('d-none')">
                                            <i class="fa fa-fw fa-camera"></i>
                                            <span>Cambiar fotografía</span>
                                        </button>
                                    </div>

                                    <div class="text-center text-sm-left mb-2 mb-sm-0 mt-4">
                                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?= $fila["nombre"] ?> <?= $fila["apellidos"] ?></h4>
                                        <p class="mb-0">@<?= $fila["usuario"] ?></p>
                                    </div>
                                    <div class="text-center text-sm-right">
                                        <span class="badge badge-secondary">administrator</span>
                                        <div class="text-muted"><small>Se unió el <?= $fila["Fecha_alta"] ?></small></div>
                                    </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="card shadow box-area">
                                        <div class="card-body">
                                            <div class="e-profile">
                                                <div class="tab-content pt-3">
                                                    <div class="tab-pane active">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Nombre</label>
                                                                            <input class="form-control" type="text" name="nombre" id="nombreEditar" placeholder="<?= $fila["nombre"] ?>" oninput="restriccionNombre(value, 'nombreEditar')">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Apellidos</label>
                                                                            <input class="form-control" type="text" name="apellidos" id="apellidosEditar" placeholder="<?= $fila["apellidos"] ?>" oninput="restriccionNombre(value, 'apellidosEditar')">
                                                                        </div>
                                                                    </div>


                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Nombre usuario</label>
                                                                            <input class="form-control" type="text" name="username" id="nombreUsuarioEditar" placeholder="<?= $fila["usuario"] ?>" oninput="restriccionUsuario(value, 'nombreUsuarioEditar')">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Email</label>
                                                                            <input class="form-control" type="text" name="email" id="emailEditarUsuario" placeholder="<?= $fila["email"] ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="">Provincia</label>
                                                                            <input class="form-control" type="text" name="provincia" placeholder="<?= $fila["provincia"] ?>" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="">Población</label>
                                                                            <input class="form-control" type="text" name="poblacion" placeholder="<?= $fila["poblacion"] ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="">Codigo Postal</label>
                                                                            <input class="form-control" type="text" name="cp" id="cp" maxlength="5" minlength="5" placeholder="<?= $fila["CP"] ?>" oninput="restriccionNumero(value, 'cp')"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="cuenta">Cuenta IBAN</label>
                                                                            <input class="form-control" type="text" name="cuenta" id="campoIbanEditar" placeholder="<?= $fila["cuenta_iban"] ?>" onfocus="validatePrefix('campoIbanEditar')" oninput="validatePrefix('campoIbanEditar')" onkeydown="preventBackspace(event)"></input>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-12 col-sm-6 mb-3  mt-2">
                                                                <div class="mb-2"><b>Cambiar contraseña</b></div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group mt-2">
                                                                            <label>Nueva contraseña</label>
                                                                            <input class="form-control" type="password" name="nuevapass" id="passEditarUsuario" placeholder="••••••" oninput="restriccionPass(value, 'passEditarUsuario')">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group mt-2">
                                                                            <label>Confirmar <span class="d-none d-xl-inline">Contraseña</span></label>
                                                                            <input class="form-control" type="password" name="confirmarpass" id="confirmarPassEditarUsuario" placeholder="••••••" oninput="restriccionPass(value, 'confirmarPassEditarUsuario')">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-6 mb-3  mt-3">
                                                                <div class="row alert alert-primary h-1000" role="alert" id="informacionPass">
                                                                    <small class="text-center"> RECUERDA:</small>
                                                                    <small> La contraseña debe tener:</small>
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
                                                            <div class="row mt-3">
                                                                <div class="col d-flex justify-content-end">
                                                                    <button class="btn btn-primary w-100" type="submit">Guardar cambios</button>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col d-flex justify-content-end">
                                                                    <button class="btn btn-primary w-100" id="botonVolverAtrasEditarUsuario" onclick="redirectToList()">Ir atrás</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>

                    <script src="../JS/funcionesRegex.js"></script>
                    <script src="../JS/editarusuario.js"></script>
                    <script src="../JS/regexCrearUsuario.js"></script>
                    <script>
                        function redirectToList() {
                            location.href = "listado_usuarios.php"
                        }
                    </script>
                    
                </div>
            </body>
        <?php
        } else {
            header('Location:listado_usuarios.php');
        }
        ?>
    <?php
    } elseif (isset($_GET["new"])) {

    ?>

        <!-- CREAR NUEVO USUARIO -->

        <body>
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
            <div class="container d-flex justify-content-center align-items-center vh-100 mt-5">
                <form class="form-group" action="../controlador/usuarios/crear_usuario.php" method="post" enctype="multipart/form-data" id="formCrearNuevoUsuario">
                    <div class="row flex-lg-nowrap" id="contenedorDatosUsuario">
                        <div class="col-12 col-lg-auto mb-3">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="mx-auto text-center">
                                    <img src="../Images/noimage.jpg" alt="foto" class="img-fluid" style="max-width: 75%; max-height: 75%; ">
                                    </div>
                                </div>
                                <div class="mt-3 text-center">
                                    <i class="fa fa-fw fa-camera"></i>
                                    <span>Añadir fotografía</span>
                                </div>
                                <div class="mt-2 text-center mt-2">
                                    <input class="btn btn-primary" type="file" name="subirImagen" id="subirImagen" accept="image/png, image/jpeg, image/jpg">
                                    </input>
                                </div>

                            </div>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="card shadow box-area">
                                        <div class="card-body">
                                            <div class="e-profile">
                                                <div class="tab-content pt-3">
                                                    <div class="tab-pane active">

                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="row mt-2">
                                                                    <div class="mb-2"><b>Datos usuario</b></div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Nombre</label>
                                                                            <input class="form-control" type="text" name="nombre" id="nombreNuevoUsuario" maxlength="25" placeholder="Introduce nombre" oninput="restriccionNombre(value, 'nombreNuevoUsuario')" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Apellidos</label>
                                                                            <input class="form-control" type="text" name="apellidos" id="apellidosNuevoUsuario" placeholder="Introduce apellidos" maxlength="50" oninput="restriccionApellidos(value, 'apellidosNuevoUsuario')" required>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Nombre usuario</label>
                                                                            <input class="form-control" type="text" name="username" id="usernameNuevoUsuario" placeholder="Introduce un nombre de usuario" maxlength="16" oninput="restriccionUsuario(value, 'usernameNuevoUsuario')" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Email</label>
                                                                            <input class="form-control" type="text" name="email" id="emailNuevoUsuario" placeholder="Introduce un correo electrónico" maxlength="50" required onkeyup="validarEmail('emailNuevoUsuario')">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="">Provincia</label>
                                                                            <input class="form-control" type="text" name="provincia" id="provinciaNuevoUsuario" required maxlength="25"/>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="">Población</label>
                                                                            <input class="form-control" type="text" id="poblacionNuevoUsuario" name="poblacion" required maxlength="25"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="">Codigo Postal</label>
                                                                            <input class="form-control" type="text" name="cp" id="cpNuevoUsuario" maxlength="5" oninput="restriccionNumero(value, 'cpNuevoUsuario')" required />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="">Dirección</label>
                                                                            <input class="form-control" type="text" name="direccion" id="direccionNuevoUsuario" onblur="autorellenarPoblacion('direccionNuevoUsuario', 'poblacionNuevoUsuario')" required />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="cuenta">Cuenta IBAN (ES añadido automaticamente)</label>
                                                                            <input class="form-control" type="text" name="cuentaIBAN" id="cuentaIBANNuevoUsuario" placeholder="Introduce solo los numeros" maxlength="22" minlength="22" oninput="restriccionNumero(value,'cuentaIBANNuevoUsuario')" required></input>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-3">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="fechaNacimiento">Fecha de nacimiento</label>
                                                                            <input class="form-control" id="fechaNacimiento" type="date" name="fechaNacimiento" max="<?= date("Y/m/d") ?>" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col mt-3 mx-auto">
                                                                        <label>Socio</label>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="socio" id="inlineRadio1" value="1">
                                                                            <label class="form-check-label" for="inlineRadio1">Si</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="socio" id="inlineRadio2" value="0">
                                                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-12 col-sm-6 mb-3  mt-2">
                                                                <div class="mb-2"><b>Añadir contraseña</b></div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group mt-2">
                                                                            <label>Nueva contraseña</label>
                                                                            <input class="form-control" type="password" name="nuevapass" id="nuevaPassNuevoUsuario" placeholder="••••••" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group mt-2">
                                                                            <label>Confirmar <span class="d-none d-xl-inline">Contraseña</span></label>
                                                                            <input class="form-control" type="password" id="confirmarNuevaPassNuevoUsuario" name="confirmarpass" placeholder="••••••" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-6 mb-3  mt-3">
                                                                <div class="row alert alert-primary h-1000" role="alert" id="informacionPass">
                                                                    <small class="text-center"> RECUERDA:</small>
                                                                    <small> La contraseña debe tener:</small>
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
                                                            <div class="row mt-3">
                                                                <div class="col d-flex justify-content-end">
                                                                    <button class="btn btn-primary w-100" type="submit">Guardar cambios</button>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col d-flex justify-content-end">
                                                                    <button class="btn btn-primary w-100" onclick="redirectToList()">Ir atrás</button>
                                                                </div>
                                                            </div>
                                                        </div>
                </form>

            </div>
            </div>
            </div>
            </div>
            </div>
            </div>


            </div>

            </div>
            </div>



            </div>
            <script src="../JS/regexCrearUsuario.js"></script>
            <script src="../JS/funcionesRegex.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn5Ya8X4aZcE5MaGErQDkUprmWgVGINGQ&libraries=places"></script>
            <script>
                function initAutocomplete() {
                    // Crear el objeto de autocompletado y vincularlo al campo de dirección
                    const input = document.getElementById('direccionNuevoUsuario');
                    const autocomplete = new google.maps.places.Autocomplete(input);

                    // Limitar las predicciones a direcciones (opcional)
                    autocomplete.setTypes(['geocode']);

                    // Establecer restricciones de país (opcional)
                    // autocomplete.setComponentRestrictions({'country': ['us']});

                    // Listener para obtener los detalles del lugar cuando el usuario selecciona una dirección
                    autocomplete.addListener('place_changed', function() {
                        const place = autocomplete.getPlace();
                        console.log('Dirección seleccionada:', place.formatted_address);
                        // Puedes realizar otras acciones con los datos de la dirección
                    });
                }

                document.addEventListener('DOMContentLoaded', function() {
                    initAutocomplete();
                });
            </script>
            <script>
                function redirectToList() {
                    location.href = "listado_usuarios.php"
                }
            </script>
        </body>

    </html>



<?php
    }
} else {
    header('Location:../index.php');
}
?>