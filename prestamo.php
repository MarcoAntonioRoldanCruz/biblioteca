<?php
include_once "conexion.php";
session_start();

date_default_timezone_set('America/Mexico_City');
$diassemana = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

$fecha_hoy = $diassemana[date('w')] . " " . date('d') . " de " . $meses[date('m') - 1] . " del " . date('Y'); // Fecha completa; ej: Miércoles 04 de Octubre de 2023.

$n_dia = intval(date("d"));
$n_dia_2 = intval(date("d"));
$n_mes = intval(date("m"));
$n_mes_2 = intval(date("m"));
$n_anio = intval(date("Y"));
if ($n_dia < 10) {
    $n_dia_2 = "0" . $n_dia;
}
if ($n_mes < 10) {
    $n_mes_2 = "0" . $n_mes;
}
$fecha = $n_anio . "-" . $n_mes_2 . "-" . $n_dia_2; // Fecha corta; ej: 04-10-2023
?>
<!DOCTYPE html>
<html id="theme" lang="es" data-bs-theme="light">

<head>
    <title>Préstamo de libros</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="icons/bootstrap-icons.css">
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>
    <link rel="shortcut icon" href="biblioteca.ico" type="image/x-icon">
</head>

<body id="bg" class="background">

    <div class="p-5 mb-4 text-bg-info text-center text-white bg-dark">
        <h1>Préstamo de Libros</h1>
        <i class="bi bi-moon-stars-fill float-end" onclick="dark_mode()"></i>
        <input type="hidden" class="form-control" name="curp" id="curp">
        <input type="hidden" class="form-control" name="gradoG" id="gradoG">
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
        <div class="container-fluid">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Inicio</a>
                </li>
                <?php if ($_SESSION['GradoGrupo'] == "Administrador") {    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php">Registro de libros</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="busqueda.php">Buscar libros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="prestamo.php">Préstamo de libros</a>
                </li>
                <?php if ($_SESSION['GradoGrupo'] == "Administrador") {    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="historial.php">Historial</a>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['GradoGrupo'] == "Administrador") {    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios.php">Usuarios</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid mt-3"> <!-- Fluid abarca màs ancho de la pantalla que container simple si -->
        <div class="row">
            <div class="col">
                <h4 class="text-center mt-2"><?= $fecha_hoy ?></h4>
                <div class="accordion mt-3" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Prestar
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="libro_prestar" class="form-label">Libro</label>
                                        <select class="form-select" name="libro_prestar" id="libro_prestar">
                                            <option selected>Selecciona un libro</option>
                                            <?php
                                            $sql = "SELECT * FROM libros WHERE EsPrestado = 'NO'";
                                            $libros_st = $pdo->prepare($sql);
                                            $libros_st->execute();
                                            while ($libro = $libros_st->fetch()) {
                                                echo "<option numero='{$libro['Numero']}' value='{$libro['IdLibro']}' >{$libro['Titulo']} - No. {$libro['Numero']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="usuario_prestar" class="form-label">Lector</label>
                                        <select class="form-select" name="usuario_prestar" id="usuario_prestar">
                                            <option selected>Selecciona al lector</option>
                                            <?php
                                            $sql = "SELECT * FROM usuarios";
                                            $usuario_st = $pdo->prepare($sql);
                                            $usuario_st->execute();
                                            while ($usuario = $usuario_st->fetch()) {
                                            ?>
                                                <option value="<?= $usuario['CurpUsuario'] ?>" title="<?= $usuario['CurpUsuario'] ?>"><?= $usuario['NombreUsuario'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha_prestamo" class="form-label">Fecha de préstamo</label>
                                        <input type="date" class="form-control border-info" name="fecha_prestamo" id="fecha_prestamo" aria-describedby="fecha_prestamo_helpId" value="<?= $fecha ?>">
                                        <small id="fecha_prestamo_helpId" class="form-text text-muted">Fecha cuando el libro <strong>sale</strong> de biblioteca</small>
                                    </div>
                                    <!-- <div class="mb-3">
                                        <label for="numero_libro_prestar" class="form-label">Número clave de libro</label>
                                        <select class="form-control form-select" name="numero_libro_prestar" id="numero_libro_prestar">
                                            <option value="">Selecciona la clave de un libro</option>
                                        </select>
                                        <small id="helpId" class="form-text text-muted">Es la clave del libros prestado</small>
                                    </div> -->
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <button type="button" class="btn btn-warning" onclick="prestar_libro()">PRESTAR</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Devolver
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="usuario_devolver" class="form-label">Lector</label>
                                        <select class="form-select" name="usuario_devolver" id="usuario_devolver" onchange="buscar_lector(this.value)">
                                            <option selected>Selecciona al lector</option>
                                            <?php
                                            $sql = "SELECT * FROM usuarios";
                                            $usuario_st = $pdo->prepare($sql);
                                            $usuario_st->execute();
                                            while ($usuario = $usuario_st->fetch()) {
                                            ?>
                                                <option value="<?= $usuario['IdUsuario'] ?>" title="<?= $usuario['CurpUsuario'] ?>"><?= $usuario['NombreUsuario'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="libro_devolver" class="form-label">Libro</label>
                                        <select class="form-select " name="libro_devolver" id="libro_devolver" onchange="buscar_prestamo(this.value)">
                                            <option selected>Selecciona el libro</option>
                                            <?php
                                            $sql = "SELECT * FROM prestamolibros WHERE FechaFin IS NULL";
                                            $prestamos_st = $pdo->prepare($sql);
                                            $prestamos_st->execute();
                                            $prestamos_conteo = $prestamos_st->rowCount();
                                            while ($prestamo = $prestamos_st->fetch()) {
                                                $sql = "SELECT * FROM libros WHERE IdLibro = '{$prestamo['IdLibro']}' LIMIT 1";
                                                $libros_st = $pdo->prepare($sql);
                                                $libros_st->execute();
                                                $libro = $libros_st->fetch();

                                                $sql = "SELECT * FROM usuarios WHERE IdUsuario = {$prestamo['IdUsuario']} LIMIT 1";
                                                $usuario_st = $pdo->prepare($sql);
                                                $usuario_st->execute();
                                                $usuario = $usuario_st->fetch();

                                                echo "<option value='{$prestamo['IdPrestamo']}' title='{$usuario['CurpUsuario']}' id_libro='{$libro['IdLibro']}'>{$libro['Titulo']} - No. {$libro['Numero']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha_devolucion_prestado" class="form-label">Fecha de préstamo</label>
                                        <input type="date" class="form-control border-info" name="fecha_devolucion_prestado" id="fecha_devolucion_prestado" aria-describedby="fecha_prestado_helpId" readonly>
                                        <small id="fecha_prestado_helpId" class="form-text text-muted">Fecha cuando el libro fue <strong>prestado</strong> de biblioteca</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fecha_devolucion" class="form-label">Fecha de devolución</label>
                                        <input type="date" class="form-control border-info" name="fecha_devolucion" id="fecha_devolucion" aria-describedby="fecha_devolucion_helpId" value="<?= $fecha ?>">
                                        <small id="fecha_devolucion_helpId" class="form-text text-muted">Fecha cuando el libro es <strong>devuelto</strong> a biblioteca</small>
                                    </div>
                                    <div class="d-grid gap-2 col-6 mx-auto">
                                        <button type="button" class="btn btn-info" onclick="devolver_libro()">DEVOLVER</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col" class="img-thumbnail"> <!--Columna derecha-->
                <div class="text-center">
                    <img src="img/libreria.jpg" title="Recuerda entregar el libro o renovar el préstamo siguiendo las indicaciones" data-bs-toggle="tooltip" class="img-thumbnail h-25">
                </div>
            </div>
        </div>
    </div>

    <br>
</body>

</html>