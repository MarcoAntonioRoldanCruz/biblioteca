<?php
include_once "conexion.php";
session_start();
if (empty($_GET['p'])) {
	$_GET['p'] = 1;
}
$por_pagina = 15;
$sql = "SELECT * FROM usuarios";
$usuarios_st = $pdo->prepare($sql);
$usuarios_st->execute();
$total_usuarios = $usuarios_st->rowCount();
if ($total_usuarios > 0) {
	$paginas = ceil($total_usuarios / $por_pagina);
} else {
	$paginas = 1;
}
?>
<!DOCTYPE html>
<html id="theme" lang="es" data-bs-theme="light">

<head>
	<title>Usuarios</title>
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
		<h1>Usuarios</h1>
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
				<?php if ($_SESSION['GradoGrupo'] == "Administrador") {	?>
					<li class="nav-item">
						<a class="nav-link" href="registro.php">Registro de libros</a>
					</li>
				<?php } ?>
				<li class="nav-item">
					<a class="nav-link" href="busqueda.php">Buscar libros</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="prestamo.php">Préstamo de libros</a>
				</li>
				<?php if ($_SESSION['GradoGrupo'] == "Administrador") {	?>
					<li class="nav-item">
						<a class="nav-link" href="historial.php">Historial</a>
					</li>
				<?php } ?>
				<?php if ($_SESSION['GradoGrupo'] == "Administrador") {	?>
					<li class="nav-item">
						<a class="nav-link active" href="usuarios.php">Usuarios</a>
					</li>
				<?php } ?>
				<li class="nav-item">
					<a class="nav-link" href="index.php">Cerrar sesión</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid mt-5">
		<div class="row">
			<div class="col">
				<!-- <form>
					<div class="mb-3">
						<label for="nombre_usuario" class="form-label">Nombre de usuario</label>
						<input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" placeholder="Nombre de usuario">
					</div>
					<div class="mb-4">
						<label for="curp_usuario" class="form-label">CURP</label>
						<input type="text" name="curp_usuario" id="curp_usuario" class="form-control" placeholder="CURP">
					</div>
					<div class="text-center mb-3">
						<button type="button" class="btn btn-primary" onclick="registrar_usuario()">Registrar</button>
					</div>
				</form> -->



				<form class="was-validated">
					<div class="input-group mb-3">
						<span class="input-group-text">Curp</span>
						<input id="curp_registro" type="text" aria-label="curp" class="form-control text-uppercase" placeholder="CURP" required>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text">Nombre de usuario</span>
						<input id="usuario_registro" type="text" aria-label="curp" class="form-control" placeholder="Nombre (s)" required>
					</div>
					<div class="mb-3">
						<label for="grado_grupo_registro" class="form-label">Grado y Grupo</label>
						<select id="grado_grupo_registro" class="form-select">
							<option selected>Elige una opción</option>
							<option value="1A">1A</option>
							<option value="1B">1B</option>
							<option value="1C">1C</option>
							<option value="1D">1D</option>
							<option value="2A">2A</option>
							<option value="2B">2B</option>
							<option value="2C">2C</option>
							<option value="2D">2D</option>
							<option value="3A">3A</option>
							<option value="3B">3B</option>
							<option value="3C">3C</option>
							<option value="4A">4A</option>
							<option value="4B">4B</option>
							<option value="4C">4C</option>
							<option value="5A">5A</option>
							<option value="5B">5B</option>
							<option value="5C">5C</option>
							<option value="6A">6A</option>
							<option value="6B">6B</option>
							<option value="6C">6C</option>
							<option value="Administrador">Administrador</option>
						</select>
					</div>

					<div class="text-center">
						<button id="btn-registrar_usuario" onclick="registrar_usuario()" type="button" class="btn btn-success">Guardar registro</button>
						<button class="btn btn-secondary" type="reset" onclick="window.location.reload()">Reiniciar</button>
					</div>
				</form>


			</div>
			<div class="col text-center">
				<h6>Usuarios de la Biblioteca</h6>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nombre usuario</th>
							<th>CURP</th>
							<th>Clase</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody id="usuarios">
						<!-- Aquí se cargarán los datos -->
						<?php
						if (!$_GET) {
							header("location:usuarios.php?p=1");
						}
						if ($_GET['p'] >= ($paginas + 1) || $_GET['p'] <= 0) {
							header("location:usuarios.php?p=1");
						}

						$inicio = ($_GET['p'] - 1) * $por_pagina;
						$sql = "SELECT * FROM usuarios LIMIT {$inicio}, {$por_pagina}";
						$usuarios_st = $pdo->prepare($sql);
						$usuarios_st->execute();
						if ($usuarios_st->rowCount() > 0) {
							$usuarios = $usuarios_st->fetchAll(PDO::FETCH_ASSOC);
							foreach ($usuarios as $usuario) {
								echo "<tr>";
								echo "<td>{$usuario['NombreUsuario']}</td>";
								echo "<td>{$usuario['CurpUsuario']}</td>";
								echo "<td>{$usuario['GradoGrupo']}</td>";
								echo "<td>
								<button class='btn btn-outline-info' onclick='editar_usuario({$usuario['IdUsuario']})'><i class='bi bi-pencil-square'></i></button>
								<button class='btn btn-outline-danger' onclick='eliminar_usuario({$usuario['IdUsuario']})'><i class='bi bi-trash'></i></button>
								</td>";
								echo "</tr>";
							}
						} else {
							echo "<tr><td colspan='4'>No hay usuarios todavía registrados.</td></tr>";
						}
						?>
					</tbody>
				</table>
				<nav aria-label="Page navigation">
					<ul class="pagination pagination-sm justify-content-center">
						<li class="page-item <?php echo $_GET['p'] <= 1 ? "disabled" : "" ?>">
							<a class="page-link" href="usuarios.php?p=<?= $_GET['p'] - 1 ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<?php
						for ($i = 0; $i < $paginas; $i++) {
						?>
							<li class="page-item <?php echo $_GET['p'] == $i + 1 ? "active" : "" ?>" aria-current="page">
								<a class="page-link" href="usuarios.php?p=<?= $i + 1 ?>"><?= $i + 1 ?></a>
							</li>
						<?php
						}
						?>
						<li class="page-item <?php echo $_GET['p'] >= $paginas ? "disabled" : "" ?>">
							<a class="page-link" href="usuarios.php?p=<?= $_GET['p'] + 1 ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	</div>
</body>

</html>