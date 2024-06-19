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
        <title>Editar evento</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="../CSS/sidebar.css" rel="stylesheet" />
    </head>

    <?php
    if (isset($_GET["event"])) {
        $id = $_GET["event"];
        $_SESSION["idevento"] = $id;

        include '../controlador/conexionBD.php';
        $query = "SELECT E.ID, E.TITULO_EVENTO, E.DESCRIPCION_EVENTO,E.LOCALIZACION, E.ESTADO, E.PRECIO,
        E.FECHA_INICIO_INSCRIPCION, E.FECHA_INICIO, E.FECHA_FIN, E.NUMEROMAXPARTICIPANTES, E.IMAGENEVENTO, C.NOMBRE 
        FROM evento E INNER JOIN CATEGORIA_EVENTO C ON E.IDCATEGORIA = C.ID
        AND E.ID = $id";
        $resultado = mysqli_query($db, $query);
        $fila = mysqli_fetch_array($resultado);
        if ($fila) {
    ?>
            <!-- EDITAR EVENTO -->

            <body>
                <div class="container d-flex justify-content-center align-items-center vh-100">
                    <div class="row flex-lg-nowrap" id="contenedorDatosUsuario">
                        <div class="col-12 col-lg-auto mb-3">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="mx-auto text-center">
                                        <?php
                                        # Bucle para comprobar si la imagen existe en el directorio de imágenes, si no cargar la imagen predeterminada
                                        $files = scandir('../ImagenesEventos/');
                                        $encontrado = false;
                                        $nombreImagen = basename($fila["IMAGENEVENTO"]);

                                        foreach ($files as $file) {
                                            if ($nombreImagen === $file) {
                                        ?>
                                                <img src="../ImagenesEventos/<?= htmlspecialchars($fila["IMAGENEVENTO"], ENT_QUOTES, 'UTF-8') ?>" alt="foto" style="height:300px; width:300px;">
                                            <?php
                                                $encontrado = true;
                                                break;
                                            }
                                        }

                                        if (!$encontrado) {
                                            ?>
                                            <img src="../ImagenesEventos/evento.jpg" alt="foto" style="height:300px; width:300px;">
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <form class="form" action="../controlador/eventos/update_evento.php" method="post" enctype="multipart/form-data" id="formEditarEvento">
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
                                        <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?= $fila["TITULO_EVENTO"] ?></h4>
                                        <p class="mb-0"><?= $fila["NOMBRE"] ?></p>
                                    </div>
                                    <div class="text-center text-sm-right">
                                        <span class="badge badge-secondary">administrator</span>
                                        <div class="text-muted"><small>Estado: <?= $fila["ESTADO"] ?></small></div>
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
                                                                    <div class="mb-4 text-center"><b>Datos evento</b></div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="titulo">Titulo</label>
                                                                            <input class="form-control" type="text" name="titulo" id="tituloEventoEditar" placeholder="<?= $fila["TITULO_EVENTO"] ?>" oninput="restriccionTexto(value, 'tituloEventoEditar')">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-2">
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <label>Descripción</label>
                                                                                <input class="form-control" type="text" name="descripcion" id="descripcionEventoEditar" placeholder="<?= $fila["DESCRIPCION_EVENTO"] ?>" oninput="restriccionTexto(value, 'tituloEventoCrear')">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-2">
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <label for="localizacion">Localización</label>
                                                                                <input class="form-control" type="text" name="localizacion" placeholder="<?= $fila["LOCALIZACION"] ?>" oninput="restriccionTexto(value, 'tituloEventoCrear')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-4">
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <label class="input-group-text" for="inputGroupSelect01">Categoría</label>
                                                                                    </div>
                                                                                    
                                                                                    <select class="form-select" id="inputGroupSelect01" name="categoriaEditar">
                                                                                    <option selected>Elige...</option>
                                                                                    <?php
                                                                                    $categoriaQuery = "SELECT * FROM categoria_evento";
                                                                                    $result = mysqli_query($db, $categoriaQuery);
                                                                                    
                                                                                    // Verificamos si la consulta tuvo éxito
                                                                                    if ($result) {
                                                                                        // Iteramos sobre los resultados
                                                                                        while ($row = mysqli_fetch_array($result)) {
                                                                                            ?>
                                                                                            <option value="<?= $row['ID'] ?>"><?= $row['NOMBRE'] ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    } else {
                                                                                        // Manejar el error si la consulta falla
                                                                                        echo "Error: " . mysqli_error($db);
                                                                                    }?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-group">
                                                                                <div class="input-group mb-3">
                                                                                    <div class="input-group-prepend">
                                                                                        <label class="input-group-text" for="inputGroupSelect02">Estado</label>
                                                                                    </div>
                                                                                    <select class="form-select" id="inputGroupSelect02" name="estadoEditar">
                                                                                        <option selected>Elige...</option>
                                                                                        <option value="En curso">En curso</option>
                                                                                        <option value="Planificado">Planificado</option>
                                                                                        <option value="Completado">Completado</option>
                                                                                        <option value="Eliminado">Eliminado</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Precio</label>
                                                                        <input class="form-control" type="text" name="precio" id="precioEventoEditar" placeholder="<?= $fila["PRECIO"] ?>€" oninput="restriccionNumero(value, 'precioEventoEditar')" maxlength="3">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label>Numero participantes</label>
                                                                        <input class="form-control" type="text" name="participantes" id="participantesEventoEditar" placeholder="<?= $fila["NUMEROMAXPARTICIPANTES"] ?>" oninput="restriccionNumero(value, 'participantesEventoEditar')" maxlength="3">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-4">
                                                                <div class="mb-2 text-center"><b>Fechas</b></div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group mt-2">
                                                                            <label for="fechainicioinscripcion">Fecha inicio inscripción</label>
                                                                            <input type="date" name="fechainicioinscripcion" id="fechaInicioInscripcionEventoEditar">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group mt-2">
                                                                            <label for="fechainicio">Fecha inicio</label>
                                                                            <input type="datetime-local" name="fechainicio" id="fechaInicioInscripcionEventoEditar">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group mt-2">
                                                                            <label for="fechafin">Fecha fin</label>
                                                                            <input type="datetime-local" name="fechafin" id="fechaInicioInscripcionEventoEditar">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-5">
                                                                <div class="row mt-3">
                                                                    <div class="col d-flex justify-content-end">
                                                                        <button class="btn btn-primary w-100" type="submit">Guardar cambios</button>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                                <div class="row mt-3">
                                                                    <div class="col d-flex justify-content-end">
                                                                        <button class="btn btn-secondary w-100" id="botonVolverAtrasEditarUsuario" onclick="redirectTo('','listado_eventos.php')">Ir atrás</button>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script src="../JS/botonesDatatableEventos.js"></script>
                                            <script src="../JS/funcionesRegex.js"></script>
            </body>

        <?php
        } else {
            header('Location:listado_usuarios.php');
        }
        ?>
    <?php
    } elseif (isset($_GET["new"])) {

    ?>

        <!-- CREAR NUEVO EVENTO -->

        <body>
            <div class="container d-flex justify-content-center align-items-center vh-100">
                <form class="form" action="../controlador/eventos/crear_evento.php" method="post" enctype="multipart/form-data" id="formCrearNuevoEvento">
                    <div class="row flex-lg-nowrap" id="contenedorDatosEvento">
                        <div class="col-12 col-lg-auto mb-3">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="mx-auto text-center">
                                        <img src="../ImagenesEventos/evento.jpg" alt="foto" srcset="" style="height:300px; width:300px;">
                                    </div>
                                </div>
                                <div class="mt-3 text-center">
                                    <i class="fa fa-fw fa-camera"></i>
                                    <span>Añadir fotografía</span>
                                </div>
                                <div class="mt-2 text-center mt-2">
                                    <input class="btn btn-primary" type="file" name="subirImagen" id="subirImagen" accept="image/png, image/jpeg, image/jpg">
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
                                                                    <div class="mb-4 text-center"><b>Datos evento</b></div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="titulo">Titulo</label>
                                                                            <input class="form-control" type="text" name="titulo" id="tituloEventoCrear" oninput="restriccionTexto(value, 'tituloEventoCrear')" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Descripción</label>
                                                                            <input class="form-control" type="text" name="descripcion" id="descripcionEventoCrear" oninput="restriccionTexto(value, 'descripcionEventoCrear')" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label for="localizacion">Localización</label>
                                                                            <input class="form-control" type="text" name="localizacion" id="localizacionCrearEvento" oninput="restriccionTexto(value, 'localizacionCrearEvento')" required />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <label class="input-group-text" for="inputGroupSelect01">Categoría</label>
                                                                                </div>
                                                                                <select class="form-select" id="inputGroupSelect01" name="categoriaCrear">
                                                                                <?php
                                                                                    include '../controlador/conexionBD.php';
                                                                                    $categoriaQuery = "SELECT * FROM categoria_evento";
                                                                                    $result = mysqli_query($db, $categoriaQuery);
                                                                                    
                                                                                    // Verificamos si la consulta tuvo éxito
                                                                                    if ($result) {
                                                                                        // Iteramos sobre los resultados
                                                                                        while ($row = mysqli_fetch_array($result)) {
                                                                                            ?>
                                                                                            <option value="<?= $row['ID'] ?>"><?= $row['NOMBRE'] ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    } else {
                                                                                        // Manejar el error si la consulta falla
                                                                                        echo "Error: " . mysqli_error($db);
                                                                                    }?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <label class="input-group-text" for="inputGroupSelect02">Estado</label>
                                                                                </div>
                                                                                <select class="form-select" id="inputGroupSelect02" name="estadoCrear">
                                                                                    <option value="En curso">En curso</option>
                                                                                    <option value="Planificado" selected>Planificado</option>
                                                                                    <option value="Completado">Completado</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Precio</label>
                                                                            <input class="form-control" type="text" name="precio" id="precioEventoCrear" placeholder="€" oninput="restriccionNumero(value, 'precioEventoEditar')" maxlength="3" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Numero participantes</label>
                                                                            <input class="form-control" type="text" name="participantes" id="participantesEventoCrear" placeholder="Número máximo de participantes" oninput="restriccionNumero(value, 'participantesEventoEditar')" maxlength="3" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-4">
                                                                    <div class="mb-2 text-center"><b>Fechas</b></div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-group mt-2">
                                                                                <label for="fechainicioinscripcion">Fecha inicio inscripción</label>
                                                                                <input type="date" name="fechainicioinscripcion" id="fechaInicioInscripcionEventoCrear" required min="<?= date('Y-m-d') ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-group mt-2">
                                                                                <label for="fechainicio">Fecha inicio</label>
                                                                                <input type="datetime-local" name="fechainicio" id="fechaInicioInscripcionEventoCrear" required min="<?= date('Y-m-d') ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-group mt-2">
                                                                                <label for="fechafin">Fecha fin</label>
                                                                                <input type="datetime-local" name="fechafin" id="fechaInicioInscripcionEventoCrearr" required min="<?= date('Y-m-d') ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-5">
                                                                    <div class="row mt-3">
                                                                        <div class="col d-flex justify-content-end">
                                                                            <button class="btn btn-primary w-100" type="submit">Guardar cambios</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-3">
                                                                        <div class="col d-flex justify-content-end">
                                                                            <button class="btn btn-secondary w-100" id="botonVolverAtrasCrearEvento" onclick="redirectTo('', 'listado_eventos.php')">Ir atrás</button>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <script src="../JS/botonesDatatableEventos.js"></script>
            <script src="../JS/funcionesRegex.js"></script>
        </body>

    </html>



<?php
    }
} else {
    header('Location:../index.php');
}
?>