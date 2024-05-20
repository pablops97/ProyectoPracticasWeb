<?php

session_start();
if ($_SESSION['conectado']) {

    $id = $_GET["user"];
    $_SESSION["idusuario"] = $id;

    include '../conexionBD.php';
    $query = "SELECT * FROM USUARIO WHERE ID = '$id'";
    $resultado = mysqli_query($db, $query);
    $fila = mysqli_fetch_array($resultado);


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

    <body>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="row flex-lg-nowrap shadow box-area" id="contenedorDatosUsuario">
                <div class="col-12 col-lg-auto mb-3">
                    <div class="card p-3">
                        <div class="row">
                            <div class="mx-auto text-center">
                                <img src="../Images/noimage.jpg" alt="foto" srcset="" style="height:300px; width:300px;">
                            </div>
                        </div>
                        <div class="mt-2 text-center mt-2">
                            <button class="btn btn-primary" type="button">
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="e-profile">                                    
                                        <div class="tab-content pt-3">
                                            <div class="tab-pane active">
                                                <form class="form" action="../update.php" method="post">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Nombre completo</label>
                                                                        <input class="form-control" type="text" name="nombrecompleto" placeholder="<?= $fila["nombre"] ?> <?= $fila["apellidos"] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Nombre usuario</label>
                                                                        <input class="form-control" type="text" name="username" placeholder="<?= $fila["usuario"] ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Email</label>
                                                                        <input class="form-control" type="text" name="email" placeholder="<?= $fila["email"] ?>">
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
                                                                        <input class="form-control" type="number" name="cp" id="cp" placeholder="<?= $fila["CP"] ?>" />
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
                                                                        <input class="form-control" type="password" name="nuevapass" placeholder="••••••">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group mt-2">
                                                                        <label>Confirmar <span class="d-none d-xl-inline">Contraseña</span></label>
                                                                        <input class="form-control" type="password" name="confirmarpass" placeholder="••••••">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-end">
                                                            <button class="btn btn-primary" type="submit">Guardar cambios</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col d-flex justify-content-end">
                                                            <button class="btn btn-danger mt-3">ELIMINAR USUARIO</button>
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

    </html>


<?php
} else {
    header('Location:../index.php');
}
?>