<?php
include_once "conexion.php";
$id_categoria = (isset($_GET['categoria'])) ? $_GET['categoria'] : "";
session_start();
?>
<!DOCTYPE html>
<html id="theme" lang="es" data-bs-theme="light">

<head>
  <title>Búsqueda</title>
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
  <div class="w-100 p-5 mb-4 text-bg-info text-center text-white bg-dark">
    <h1>Búsqueda y filtrado de libros</h1>
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
        <?php if ($_SESSION['GradoGrupo'] == "Administrador") {  ?>
          <li class="nav-item">
            <a class="nav-link" href="registro.php">Registro de libros</a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link active" href="busqueda.php">Buscar libros</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="prestamo.php">Préstamo de libros</a>
        </li>
        <?php if ($_SESSION['GradoGrupo'] == "Administrador") {  ?>
          <li class="nav-item">
            <a class="nav-link" href="historial.php">Historial</a>
          </li>
        <?php } ?>
        <?php if ($_SESSION['GradoGrupo'] == "Administrador") {  ?>
          <li class="nav-item">
            <a class="nav-link" href="usuarios.php">Usuarios</a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Cerrar sesión</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Categoría</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="busqueda.php?categoria=0">Todos</a></li>
            <?php
            $sql = "SELECT * FROM categorias";
            $categorias_st = $pdo->prepare($sql);
            $categorias_st->execute();
            while ($categoria = $categorias_st->fetch()) {
            ?>
              <li><a class="dropdown-item" href="busqueda.php?categoria=<?= $categoria['IdCategoria'] ?>"><?= $categoria['NombreCategoria'] ?></a></li>
            <?php
            }
            ?>
          </ul>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" id="libro_buscar" type="text" placeholder="Buscar">
        <button class="btn btn-primary" type="button" onclick="buscar_libro()">Buscar</button>
      </form>
    </div>
  </nav>

  <div class="container-fluid mt-2">
    <div class="row">
      <div class="col">
        <!-- Carousel -->
        <div id="demo" class="carousel slide" data-bs-ride="carousel">

          <!-- Indicators/dots -->
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
          </div>

          <!-- The slideshow/carousel -->
          <div class="carousel-inner">
            <div class="carousel-item active text-center">
              <img src="img/cultura.png" alt="cultura" class="tamanio tamanio_ancho">
            </div>
            <div class="carousel-item text-center">
              <img src="img/feria.png" alt="feria" class="img-fluid rounded-top tamanio tamanio_ancho">
            </div>
            <div class="carousel-item text-center">
              <img src="img/sol.jpg" alt="sol" class="img-fluid rounded-top tamanio tamanio_ancho">
            </div>
            <div class="carousel-item text-center">
              <img src="img/primera.jpg" alt="primera" class="img-fluid rounded-top tamanio tamanio_ancho">
              <!-- La clase "tamanio" se encuentra en el archivo css/style.css y se puede modificar para ajustar el tamaño de las imágenes; ya sea height: alto, y width: ancho. -->
            </div>
          </div>
          <!-- Left and right controls/icons -->
          <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
      <div class="col">
        <div class="table-responsive-sm">
          <table class="table table-striped-columns table-hover	table-bordered table-info align-middle">
            <thead class="table-light">
              <caption>Coincidencias encontradas</caption>
              <tr>
                <th>Libro</th>
                <th>Categoría</th>
                <th>Autor</th>
              </tr>
            </thead>
            <tbody id="tbody-libros" class="table-group-divider">
              <?php
              $sql = "SELECT * FROM libros";
              if ($id_categoria != "" && $id_categoria != "0") {
                $sql .= " WHERE IdCategoria = '{$id_categoria}'";
              }
              $libro_st = $pdo->prepare($sql);
              $libro_st->execute();
              while ($libro = $libro_st->fetch()) {
              ?>
                <tr class="table-info" title='<?= $libro['Descripcion'] ?>' data-bs-toggle="tooltip">
                  <td scope="row"><?= $libro['Titulo'] ?></td>
                  <td>
                    <?php
                    $libro_IdCategoria = $libro['IdCategoria'];
                    $sql = "SELECT * FROM categorias WHERE IdCategoria = '{$libro_IdCategoria}' LIMIT 1";
                    $libro_categoria_st = $pdo->prepare($sql);
                    $libro_categoria_st->execute();
                    $libro_categoria = $libro_categoria_st->fetch();
                    echo $libro_categoria['NombreCategoria'];
                    ?>
                  </td>
                  <td><?= $libro['Autor'] ?></td>
                </tr>
              <?php
              }
              ?>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>

</html>