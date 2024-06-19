<?php
if (!session_id()) {
    session_start();
}

if ($_SESSION['conectado']) {

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Lista de eventos</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lista de Eventos</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../CSS/sidebar.css" />
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.css">
        <link rel="stylesheet" href="../CSS/eventos.css">
    </head>

    <body>
        <div id="opacidadeventos" class="container-fluid d-none"></div>

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
                        </ul>
                    </li>
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

            <div class="main mt-3 d-flex align-item-center justify-content-center min-vh-100">
                <div class="d-flex align-items-center justify-content-center min-vh-100 position-absolute top-0 start-0 w-100 d-none" id="panelEliminarEvento">
                    <div class="eliminarusuario bg-danger text-center rounded p-4">
                        <h2 class="mt-3" id="tituloPanelEliminarEvento">¿Desea eliminar el evento?</h2>
                        <i class="lni lni-warning"></i>
                        <div class="text-muted"><small>esta acción es irreversible</small></div>
                        <button class="btn btn-primary mt-3 mb-3" id="confirmarEliminacionEvento" onclick="eliminarEvento()">ELIMINAR</button>
                        <button class="btn btn-primary mt-3 mb-3" id="botonCancelarEliminacionEvento" onclick="popup(false, 1)">CANCELAR</button>
                    </div>
                </div>
                <div class="container bg-light bg-opacity-50">
                    <div class="row justify-content-center align-items-center">
                        <div class="col d-flex flex-column align-items-center mt-5 mb-5">
                            <button class="btnCrear" id="botonCrearEvento" onclick="redirectTo('new', 'editar_evento.php?')">AÑADIR EVENTO
                            </button>

                        </div>
                    </div>
                    <div class="contenedor_tabla d-flex justify-content-center align-item-center">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <table class="table table-striped display" id="tablaeventos">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-center">Titulo</th>
                                                <th class="text-center">Descripcion</th>
                                                <th class="text-center">Categoria</th>
                                                <th class="text-center">Localización</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Numero participantes</th>
                                                <th class="text-center">Fecha inicio</th>
                                                <th class="text-center">Fecha Fin</th>
                                                <th class="text-center">Precio</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../controlador/conexionBD.php';
                                            $query = "SELECT E.ID, E.TITULO_EVENTO, E.DESCRIPCION_EVENTO,E.LOCALIZACION, E.ESTADO, E.PRECIO,
                                                  E.FECHA_INICIO_INSCRIPCION, E.FECHA_INICIO, E.FECHA_FIN, E.NUMEROMAXPARTICIPANTES, E.IMAGENEVENTO, C.NOMBRE 
                                                  FROM evento E INNER JOIN CATEGORIA_EVENTO C ON E.IDCATEGORIA = C.ID";

                                            if ($result = $db->query($query)) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if (strcmp($row['ESTADO'], 'Eliminado') !== 0) {
                                            ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <?php
                                                                    $files = scandir('../ImagenesEventos/');
                                                                    $encontrado = false;
                                                                    $nombreImagen = basename($row["IMAGENEVENTO"]);

                                                                    foreach ($files as $file) {
                                                                        if ($nombreImagen === $file) {
                                                                    ?>
                                                                            <img src="../ImagenesEventos/<?= htmlspecialchars($row["IMAGENEVENTO"], ENT_QUOTES, 'UTF-8') ?>" alt="foto" style="width: 45px; height: 45px" class="rounded-circle">
                                                                        <?php
                                                                            $encontrado = true;
                                                                            break;
                                                                        }
                                                                    }

                                                                    if (!$encontrado) {
                                                                        ?>
                                                                        <img src="../ImagenesEventos/evento.jpg" alt="foto" style="width: 45px; height: 45px" class="rounded-circle">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <div class="ms-3">
                                                                        <p class="fw-bold mb-1"><?= $row["TITULO_EVENTO"] ?></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <p class="fw-normal mb-1"><?= $row["DESCRIPCION_EVENTO"] ?></p>
                                                            </td>
                                                            <td class="text-center">
                                                                <p class="fw-normal mb-1"><?= $row["NOMBRE"] ?></p>
                                                            </td>
                                                            <td class="text-center"><?= $row["LOCALIZACION"] ?></td>
                                                            <td class="text-center"><?= $row["ESTADO"] ?></td>
                                                            <td class="text-center"><?= $row["NUMEROMAXPARTICIPANTES"] ?></td>
                                                            <td class="text-center"><?= $row["FECHA_INICIO"] ?></td>
                                                            <td class="text-center"><?= $row["FECHA_FIN"] ?></td>
                                                            <?php
                                                            if ($row["PRECIO"] === 0) {
                                                            ?>
                                                                <td class="text-center">GRATIS</td>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <td class="text-center"><?= $row["PRECIO"] ?>€</td>
                                                            <?php
                                                            }
                                                            ?>
                                                            <td class="text-center">
                                                                <button class="btn btn-primary" onclick="redirectTo(<?= $row['ID'] ?>, 'editar_evento.php?event=')" id="botonEditarEvento"><i class="lni lni-pencil-alt"></i></button>
                                                                <button class="btn btn-danger" id="botonEliminarEvento" onclick="popup(true, <?= $row['ID'] ?>)"><i class="lni lni-trash-can"></i></button>
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            } else {
                                                echo 'error cargando los datos';
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot class="bg-light">
                                            <tr>
                                                <th class="text-center">Titulo</th>
                                                <th class="text-center">Descripcion</th>
                                                <th class="text-center">Categoria</th>
                                                <th class="text-center">Localización</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Numero participantes</th>
                                                <th class="text-center">Fecha inicio</th>
                                                <th class="text-center">Fecha Fin</th>
                                                <th class="text-center">Precio</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../JS/sidebar.js"></script>
        <script src="../JS/botonesDatatableEventos.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script>
            new DataTable('#tablaeventos', {
                layout: {
                    topStart: {
                        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
                    }
                },
                responsive: true,
                scrollX: true,
                scrollY: 500
            });
        </script>
    </body>

    </html>
<?php
} else {
    header('Location:../index.php');
}
?>