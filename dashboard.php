<!DOCTYPE html>
<html lang="en">

<head>
	<title>Portal de Biblioteca</title>
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

	<div class="p-5 mb-4 text-center text-white bg-dark">
		<h1>Biblioteca</h1>
	</div>

	<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
		<div class="container-fluid">
			<ul class="navbar-nav ">
				<li class="nav-item">
					<a class="nav-link active" href="dashboard.php">Inicio</a>
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
					<a class="nav-link" href="historial.php">Historial</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php">Cerrar sesión</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container mt-5">
		<div class="row">
			<div class="col-sm-4">
				<h2>Sobre mi</h2>
				<h5>Cada libro es una aventura, y cada niño un libro nuevo:</h5>
				<div class="fakeimg">
					<img src="img/un_libro_aventura.png" class="img-fluid w-50 ms-5" alt="Cada libro es una aventura, cada niño es un libro">
				</div>
				<h6>Recursos Educativos para Todos</h6>
				<ul>
					<li>Libros cuidadosamente seleccionados para todas las edades y niveles de primaria.</li>
					<li>Variedad de géneros para captar el interés de cada estudiante.</li>
					<li>Material didáctico que apoya el currículo escolar y el desarrollo integral.</li>
				</ul>
				<h3 class="mt-4">Fácil Acceso y Navegación</h3>
				<p>Búsqueda sencilla de libros por nombre, categoría o autor.</p>
				<ul class="nav nav-pills flex-column">
					<li class="nav-item">
						<a class="nav-link active" href="dashboard.php">Bienvenida</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="registro.php">Registro de libros</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="buscar.php">Buscar libros</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="prestamo.php">Préstamo</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="historial.php">Historial</a>
					</li>
				</ul>
				<hr class="d-sm-none">
			</div>
			<div class="col-sm-8">
				<h2>¡Descubre Nuestra Biblioteca Escolar!</h2>
				<h5>Explora una Nueva Forma de Aprender</h5>
				<div class="fakeimg">
					<img src="img/volando_imaginacion.png" alt="La aventura comienza" class="img-fluid w-25 ms-5">
				</div>
				<ul>
					<li>Acceso a una amplia colección de libros.</li>
					<li>Fomenta la lectura y el aprendizaje de una manera emocionante.</li>
					<li>Una experiencia educativa divertida y enriquecedora para ti.</li>
				</ul>



				<h3 class="mt-5">Herramienta para el Crecimiento Personal</h3>
				<h5>¡Ven a leer conmigo!</h5>
				<div class="fakeimg">
					<img src="img/libro_hadas.jpg" alt="El libro es la aventura del alma" class="img-fluid w-25 ms-5">
				</div>
				<ul>
					<li>Promueve habilidades de investigación y comprensión lectora.</li>
					<li>Una biblioteca que cultiva el amor por la lectura desde los primeros años.</li>
					<li>Incentiva la autonomía de los estudiantes en la búsqueda y selección de lecturas.</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="mt-5 p-4 bg-dark text-white text-center">
		<p>Escuela Primaria Urbana General. <br> Ignacio M. Altamirano <br> Tecozautla Hidalgo - 2023 ©</p>
	</div>

</body>

</html>