<?php
if (!session_id()) {
    session_start();
}

if ($_SESSION['conectado']) {
    include '../controlador/conexionBD.php';
    if (isset($_POST))
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
        <title>Listado eventos usuario</title>

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
                            <li class="sidebar-item">
                                <a href="editar_usuario.php?new" class="sidebar-link">Nuevo usuario</a>
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
                        <li class="sidebar-item">
                            <a href="editar_evento.php?new" class="sidebar-link">Nuevo evento</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="listado_usuarios_eventos.php" class="sidebar-link">
                        <i class="lni lni-link"></i>
                        <span>Eventos por usuario</span>
                    </a>
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
                <div class="container-flex p-5 mt-5 bg-light bg-gradient" style="--bs-bg-opacity: .5;">
                    <div class="row text-center">
                        <div class="col-md-6 text-center d-flex flex-column align-items-center">
                            <button class="botonUsuarioEvento mb-3" onclick="mostrarInputBuscarUsuario()">Usuarios</button>
                            <input class="form-control mt-4 d-none" type="text" name="" id="buscarUsuario" placeholder="Buscar usuario" onkeyup="buscarPorUsuario()">
                        </div>
                        <div class="col-md-6 text-center d-flex flex-column align-items-center">
                            <button class="botonUsuarioEvento mb-3" onclick="mostrarInputBuscarEvento()">Eventos</button>
                            <input class="form-control d-none mt-4" type="text" name="" id="buscarEvento" placeholder="Buscar evento" onkeyup="buscarPorEvento()">
                        </div>
                    </div>

                    <div class="row h-75 mt-5 text-center" id="contenido">
                        <?php
                    include '../controlador/conexionBD.php';
                    $consultaUsuarioEvento = "SELECT M.IDMATRICULACION, M.IDEVENTO, M.IDUSUARIO, M.FECHA_MATRICULACION, M.FECHA_ANULADO, M.ESTADO, U.usuario, E.TITULO_EVENTO, u.imagen, e.IMAGENEVENTO from MATRICULACION M
                                  INNER JOIN USUARIO U ON M.IDUSUARIO = U.id
                                  INNER JOIN EVENTO E ON M.IDEVENTO = E.ID";
                    if ($result = $db->query($consultaUsuarioEvento)) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['FECHA_ANULADO'] == null) {
                        ?>
                                    <div class="row mb-2" id="datos">
                                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                                            <div class="card" style="width: 500px; margin-top:5px">
                                                <div class="row no-gutters">
                                                    <div class="col-sm-5">
                                                        <img class="card-img img-fluid" src="../Images/<?= $row['imagen'] ?>" alt="<?= $row['imagen'] ?>">
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div class="card-body">
                                                            <h5 class="card-title nombreUsuario"><?= $row['usuario'] ?></h5>
                                                            <a href="#" class="btn btn-primary mt-5" onclick="location.href = 'editar_usuario.php?user=' + <?= $row['IDUSUARIO'] ?>; ">VER PERFIL</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                                            <div class="card" style="width: 500px; margin-top:5px">
                                                <div class="row no-gutters">
                                                    <div class="col-sm-5">
                                                        <img class="card-img img-fluid" src="../ImagenesEventos/<?= $row['IMAGENEVENTO'] ?>" alt="<?= $row['IMAGENEVENTO'] ?>">
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div class="card-body">
                                                            <h5 class="card-title nombreEvento"><?= $row['TITULO_EVENTO'] ?></h5>
                                                            <p>Fecha de matriculación: <?= $row['FECHA_MATRICULACION'] ?></p>
                                                            <a href="#" class="btn btn-primary mt-2" onclick="location.href = 'editar_evento.php?event=' + <?= $row['IDEVENTO'] ?>; ">VER EVENTO</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="eliminar d-flex align-items-center justify-content-center">
                                                <button class="btn btn-danger" style="margin-left: 10px;" onclick="alerta(<?= $row['IDMATRICULACION'] ?>, <?= $row['IDUSUARIO'] ?>);"><i class="lni lni-trash-can"></i></button>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                            }
                        }
                    }
                        ?>
                        <!--
                        <div class="table-responsive">
                            <table class="table table-hover mt-5" id="tablaEventosPorUsuario">
                                <thead>
                                    <tr>
                                        <th class="text-center">Usuario</th>
                                        <th class="text-center">Eventos</th>
                                        <th class="text-center">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Usuario</th>
                                        <th class="text-center">Eventos</th>
                                        <th class="text-center">Eliminar</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <script src="../JS/sidebar.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../JS/busqueda.js"></script>
        <script>
            function alerta(idmatricula, idusuario) {
                Swal.fire({
                    title: "¿Seguro que deseas eliminar?",
                    showDenyButton: true,
                    confirmButtonText: "Eliminar",
                    denyButtonText: `Cancelar`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {                        
                        location.href = "../controlador/eventousuario/eliminar_evento_usuario.php?idmatriculacion=" + idmatricula + "&idusuario=" + idusuario;
                        Swal.fire("Eliminado!", "", "success");

                    } else if (result.isDenied) {
                        Swal.fire("No ha sido eliminado", "", "info");
                    }
                });
            }

            function buscar() {
                let inputUsuario = document.getElementById();
                let inputEvento = document.getElementById();
            }
        </script>
    </body>

    </html>



<?php
} else {
    header('Location: ../index.php');
}
?>