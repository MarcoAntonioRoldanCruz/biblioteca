<?php
include_once "conexion.php";
session_start();
?>
<!DOCTYPE html>
<html id="theme" lang="es" data-bs-theme="light">

<head>
    <title>Registro de libros</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="icons/bootstrap-icons.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>
    <link rel="shortcut icon" href="biblioteca.ico" type="image/x-icon">
</head>

<body id="bg" class="background">

    <div class="p-5 mb-4 text-bg-info text-center text-white bg-dark">
        <h1>Registro de libros</h1>
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
                        <a class="nav-link active" href="registro.php">Registro de libros</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="busqueda.php">Buscar libros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="prestamo.php">Préstamo de libros</a>
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

    <div class="container-fluid mt-2"> <!-- Fluid abarca màs ancho de la pantalla que container simple si -->
        <div class="row">
            <div class="col" class="img-thumbnail">
                <form class="was-validated">
                    <div class="mb-3 mt-2"><!--margen debajo 3, margen superior 2-->
                        <label for="titulo_registro" class="form-label">Título del Libro</label>
                        <input type="text" class="form-control" id="titulo_registro" required>
                    </div>
                    <div class="mb-3">
                        <label for="autor_registro" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor_registro" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria_registro" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria_registro" required>
                            <option value="" selected>Selecciona una opción</option>
                            <?php
                            // Código PHP para obtener las categorías de los libros de la base de datos.
                            $sql = "SELECT * FROM categorias";
                            $categorias_st = $pdo->prepare($sql);
                            $categorias_st->execute();
                            while ($categoria = $categorias_st->fetch()) {
                            ?>
                                <option value="<?= $categoria['IdCategoria'] ?>"><?= $categoria['NombreCategoria'] ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_registro" class="form-label">Descripción del libro</label>
                        <textarea class="form-control" name="descripcion_registro" id="descripcion_registro" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad_registro" class="form-label">Número clave de libro</label>
                        <input type="text" class="form-control" id="cantidad_registro" required>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto">
                        <button type="button" onclick="registrar_libro()" class="btn btn-primary">REGISTRAR</button>
                        <!-- Button para disparar la categoría en modo modal usando Bootstrap 5 -->
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#categoriaModal">
                            NUEVA CATEGORÍA
                        </button>
                    </div>
                </form>
            </div>
            <div class="col mb-3" class="img-thumbnail"> <!--Columna derecha-->
                <div class="text-center mt-4">
                    <img src="img/feria.png" class="img-fluid rounded-top" alt="">
                </div>
            </div>


            <!-- Formulario para registrar una nueva categoría de libros en forma modal. -->
            <div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalTitulo" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="categoriaModalTitulo">Nueva categoría</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="was-validated">
                                <label for="categoria_nuevo">Nombre de categoría</label>
                                <input type="text" name="categoria_nuevo" id="categoria_nuevo" class="form-control" required>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="registrar_categoria()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</body>

</html>