<?php
if (!session_id()) {
    session_start();
}

if ($_SESSION['conectado']) {
    setcookie("nombreUsuario", $_SESSION["nombreUsuario"], time() + 3600);
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../CSS/sidebar.css" />
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
        <title>Home</title>

    </head>

    <body>
        <!--[if lt IE 7]>
                <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
        <div class="wrapper">
            <aside id="sidebar">
                <div class="d-flex">
                    <button class="toggle-btn" type="button">
                        <i class="lni lni-grid-alt"></i>
                    </button>
                    <div class="sidebar-logo">
                        <a href="">DashBoard</a>
                    </div>
                </div>
                <li class="sidebar-item">
                    <a href="home.php" class="sidebar-link">
                        <i class="lni lni-home"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                            <i class="lni lni-user"></i>
                            <span>Usuario</span>
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="listado_usuarios.php" class="sidebar-link">Lista de usuarios</a>
                            </li>

                    </li>

                </ul>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi2" aria-expanded="false" aria-controls="multi2">
                        <i class="lni lni-calendar"></i>
                        <span>Eventos</span>
                    </a>
                    <ul id="multi2" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="listado_eventos.php" class="sidebar-link">Lista de eventos</a>
                        </li>
                    </ul>
                </li>
                </ul>
                <div class="sidebar-footer">
                    <a href="../controlador/cerrar_sesion.php" class="sidebar-link">
                        <i class="lni lni-exit"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </aside>
            <div class="main">
                <div class="container d-flex justify-content-center align-items-center vh-100">
                    <svg class="align-self-center">
                        <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                            Bienvenido, <?= $_SESSION["nombreUsuario"] ?>
                        </text>
                    </svg>
                </div>
            </div>
        </div>
            <script src="../JS/sidebar.js"></script>
    </body>

    </html>



<?php
} else {
    header('Location: ../index.php');
}
?>