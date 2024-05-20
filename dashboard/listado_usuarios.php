<?php
if (!session_id()) {
    session_start();
}

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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../CSS/sidebar.css" />
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready( function () {
            $('#tablausuarios').DataTable();
            });
        </script>
        <script src="../JS/botonesDatatable.js"></script>
        
        
        
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
                    <a href="../cerrar_sesion.php" class="sidebar-link">
                        <i class="lni lni-exit"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </aside>



            <div class="main p-3 bg-light bg-opacity-50">
                <table class="table table-striped" id="tablausuarios">
                    <thead class="bg-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Provincia</th>
                            <th>Dirección</th>
                            <th>Fecha de nacimiento</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../conexionBD.php';
                        $query = "SELECT * FROM usuario";

                        if ($result = $db->query($query)) {

                            
                            while ($row = $result->fetch_assoc()) {

                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="../Images/<?= $row["imagen"] ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1"><?= $row["nombre"] ?> <?= $row["apellidos"] ?></p>
                                        <p class="text-muted mb-0"><?= $row["email"] ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1"><?= $row["provincia"] ?> <?= $row["CP"] ?></p>
                                <p class="text-muted mb-0"><?= $row["direccion"] ?></p>
                            </td>
                            <td>
                                <span class="badge badge-success rounded-pill d-inline">Active</span>
                            </td>
                            <td><?= $row["fecha_nacimiento"]?></td>
                            <td>
                                <button class="btn btn-primary" onclick="redirectTo(<?= $row['id']?>)"><i class="lni lni-pencil-alt"></i></button>
                                <button class="btn btn-danger"><i class="lni lni-trash-can"></i></button>
                                <button class="btn btn-light"><i class="lni lni-printer"></i></button>
                            </td>
                        </tr>

                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Provincia</th>
                            <th>Dirección</th>
                            <th>Fecha de nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <script src="../JS/sidebar.js"></script>

        
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