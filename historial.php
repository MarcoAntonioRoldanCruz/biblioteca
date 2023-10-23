<?php
include_once "conexion.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Prestamo de libros</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="css/style.css">
	<script src="js/sweetalert2.all.min.js"></script>
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/main.js"></script>
	<link rel="shortcut icon" href="biblioteca.ico" type="image/x-icon">
</head>

<body class="background">

	<div class="p-5 mb-4 text-bg-info text-center text-white bg-dark">
		<h1>Préstamo de Libros</h1>
	</div>

	<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
		<div class="container-fluid">
			<ul class="navbar-nav ">
				<li class="nav-item">
					<a class="nav-link" href="dashboard.php">Inicio</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="registro.php">Registro de libros</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="busqueda.php">Buscar libros</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="prestamo.php">Préstamo de libros</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="historial.php">Historial</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php">Cerrar sesión</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container my-2">
		<form class="was-validated">
			<div class="input-group mb-3">
				<span class="input-group-text">Desde - Hasta</span>
				<input type="date" id="desde" aria-label="desde" class="form-control" placeholder="Desde" required>
				<input type="date" id="hasta" aria-label="hasta" class="form-control" placeholder="Hasta" required>
				<button onclick="consultar_historial()" class="btn btn-secondary" type="button" id="button-addon2">Historial</button>
			</div>
		</form>
	</div>

	<div class="container-fluid">
		<div class="table-responsive table-bordered">
			<table class="table table-striped-columns table-hover table-bordered align-middle">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Libro</th>
						<th scope="col">Categoría</th>
						<th scope="col">Autor</th>
						<th scope="col">Fecha Prestamo</th>
						<th scope="col">Fecha Devolución</th>
						<th scope="col">Prestado a</th>
					</tr>
				</thead>
				<tbody id="tbody-historial" class="table-group-divider">
					<?php
					$sql = "SELECT * FROM prestamolibros ORDER BY IdPrestamo DESC LIMIT 250";
					$prestamos_st = $pdo->prepare($sql);
					$prestamos_st->execute();
					while ($prestamo = $prestamos_st->fetch()) {
						// DATOS del libro
						$IdLibro = $prestamo['IdLibro'];
						$sql = "SELECT * FROM libros WHERE IdLibro = '{$IdLibro}' LIMIT 1";
						$libro_st = $pdo->prepare($sql);
						$libro_st->execute();
						$libro = $libro_st->fetch();
						$libro_categoria = $libro['IdCategoria'];

						// DATOS de la categoría
						$sql = "SELECT * FROM categorias WHERE IdCategoria = '{$libro_categoria}' LIMIT 1";
						$libro_categoria_st = $pdo->prepare($sql);
						$libro_categoria_st->execute();
						$categoria = $libro_categoria_st->fetch();

						// CONTEO del libro prestado
						$id_libro = $libro['IdLibro'];
						$sql = "SELECT * FROM Usuarios WHERE IdUsuario = '{$prestamo['IdUsuario']}'";
						$usuario_st = $pdo->prepare($sql);
						$usuario_st->execute();
						$usuario = $usuario_st->fetch();
					?>
						<tr>
							<td><?= $prestamo['IdPrestamo'] ?></td>
							<td><?= $libro['Titulo'] ?></td>
							<td><?= $categoria['NombreCategoria'] ?></td>
							<td><?= $libro['Autor'] ?></td>
							<td><?= $prestamo['FechaInicio'] ?></td>
							<td><?= $prestamo['FechaFin'] ?></td>
							<td><?= $usuario['NombreUsuario'] ?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

</body>

</html>