<?php
if (!session_id()) {
    session_start();
}

if ($_SESSION['conectado']) {

?>
    <!DOCTYPE html>

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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">



    </head>

    <body>
        <div id="opacidad" class="container-fluid d-none">

        </div>
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
                        <a href="#">DashBoard</a>
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
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                            <i class="lni lni-user"></i>
                            <span>Usuario</span>
                        </a>
                        <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Lista de usuarios</a>
                            </li>

                    </li>

                </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Task</span>
                    </a>
                </li>
                <!--
    <li class="sidebar-item">
        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
            <i class="lni lni-protection"></i>
            <span>Auth</span>
        </a>
        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">Login</a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">Register</a>
            </li>
        </ul>
    </li>-->

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Setting</span>
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

            <div class="main mt-3 d-flex align-item-center justify-content-center min-vh-100">
                <!-- Contenedor para eliminar el usuario -->
                <div class="d-flex align-items-center justify-content-center min-vh-100 position-absolute top-0 start-0 w-100 d-none" id="confirmacionEliminarUsuario">
                    <div class="eliminarusuario bg-danger text-center rounded p-4">
                        <h2 class="mt-3" id="tituloPanelEliminarUsuario">¿Desea eliminar el usuario?</h2>
                        <i class="lni lni-warning"></i>
                        <div class="text-muted"><small>esta acción es irreversible</small></div>
                        <button class="btn btn-primary mt-3 mb-3" id="confirmarEliminacion" onclick="eliminar()">ELIMINAR</button>
                        <button class="btn btn-primary mt-3 mb-3" id="botonCancelarEliminacion">CANCELAR</button>
                    </div>
                </div>
                <div class="container bg-light bg-opacity-50">
                    <div class="row justify-content-center align-items-center">
                        <div class="col d-flex flex-column align-items-center mt-3">
                            <button title="Add New" class="group cursor-pointer outline-none hover:rotate-90 duration-300 mb-2" id="botonCrearUsuario" onclick="crearUsuario()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="70px" height="70px" viewBox="0 0 24 24" class="stroke-pink-400 fill-none group-hover:fill-pink-800 group-active:stroke-pink-200 group-active:fill-pink-600 group-active:duration-0 duration-300">
                                    <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke-width="1.5"></path>
                                    <path d="M8 12H16" stroke-width="1.5"></path>
                                    <path d="M12 16V8" stroke-width="1.5"></path>
                                </svg>
                            </button>
                            <h2>Añadir nuevo usuario</h2>
                        </div>
                    </div>
                    <table class="table table-striped display" id="tablausuarios">

                        <thead class="bg-light">
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Provincia</th>
                                <th class="text-center">Fecha de alta</th>
                                <th class="text-center">Fecha de nacimiento</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../controlador/conexionBD.php';
                            $query = "SELECT * FROM usuario";

                            if ($result = $db->query($query)) {


                                while ($row = $result->fetch_assoc()) {
                            ?>

                                    <tr>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <?php

                                                # Bucle para comprobar si la imagen existe en el directorio de imágenes, si no cargar la imagen predeterminada
                                                $files = scandir('../Images/');
                                                $encontrado = false;
                                                $nombreImagen = basename($row["imagen"]);

                                                foreach ($files as $file) {
                                                    if ($nombreImagen === $file) {
                                                ?>
                                                        <img src="../Images/<?= htmlspecialchars($row["imagen"], ENT_QUOTES, 'UTF-8') ?>" alt="foto" style="width: 45px; height: 45px" class="rounded-circle">
                                                    <?php
                                                        $encontrado = true;
                                                        break;
                                                    }
                                                }

                                                if (!$encontrado) {
                                                    ?>
                                                    <img src="../Images/noimage.jpg" alt="foto"style="width: 45px; height: 45px" class="rounded-circle">
                                                <?php
                                                }
                                                ?>
                                                <div class="ms-3">
                                                    <p class="fw-bold mb-1"><?= $row["nombre"] ?> <?= $row["apellidos"] ?></p>
                                                    <p class="text-muted mb-0"><?= $row["email"] ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <p class="fw-normal mb-1"><?= $row["provincia"] ?> <?= $row["CP"] ?></p>
                                            <p class="text-muted mb-0"><?= $row["direccion"] ?></p>
                                        </td>
                                        <td class="text-center">
                                            <p class="fw-normal mb-1"><?= $row["Fecha_alta"] ?></p>
                                        </td>
                                        <td class="text-center"><?= $row["fecha_nacimiento"] ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-primary" onclick="redirectTo(<?= $row['id'] ?>)"><i class="lni lni-pencil-alt"></i></button>
                                            <button class="btn btn-danger" id="botonEliminarUsuario" onclick="popup(true, <?= $row['id'] ?>)" value="<?= $row['id'] ?>"><i class="lni lni-trash-can"></i></button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo 'error cargando los datos';
                            }
                            ?>




                        </tbody>

                        <tfoot class="bg-light">
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Provincia</th>
                                <th class="text-center">Dirección</th>
                                <th class="text-center">Fecha de nacimiento</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </tfoot>
                    </table>



                </div>

            </div>
        </div>

        </div>

        <script src="../JS/sidebar.js"></script>
        <script src="../JS/botonesDatatable.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            new DataTable('#tablausuarios', {
                layout: {
                    topStart: {
                        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
                    }
                }
            });
        </script>

    </body>

    </html>

    <!-- añadir boton eliminar a la tabla y boton imprimir tabla exportar a excel pdf e imprimir y añadir 
                        sha1 con contraseña propia
-->

<?php
} else {
    header('Location:../index.php');
}
?>