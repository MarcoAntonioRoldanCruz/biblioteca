<?php
include_once "conexion.php"; // Es igual que traer todo el contenido del archivo en esta línea.
// Códigos y funcionalidad. En estos fragmentos. (PHP).
if (session_status() == 2) {
    session_destroy();
}
?>

<!DOCTYPE html>
<html id="theme" lang="es">

<head>
    <title>Sistema de Biblioteca</title>
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
    <!-- main.js son codigos y funcionalidad JavaScript-->
    <!-- Es importante considerar que se pueden crear más archivos js a conveniencia del programador y necesidades del sistema -->
    <script>
        localStorage.setItem("CurpUsuario", "");
        localStorage.setItem("GradoGrupo", "");
    </script>
</head>

<html id="theme" lang="es" data-bs-theme="light">

<div class="p-5 mb-4 text-center text-white bg-dark">
    <h1>Iniciar sesión</h1>
    <i class="bi bi-moon-stars-fill float-end" onclick="dark_mode()"></i>
</div>

<body id="bg" class="background">

    <div class="container">
        <div class="row">
            <div class="col" class="img-thumbnail">
                <div class="text-center mt-5">
                    <!-- O -->
                    <img src="img/logo_altamirano.png" class="img-fluid rounded-top" alt="class le da estilos">
                </div>
            </div>
            <div class="col"> <!--Columna derecha-->
                <form class="was-validated">

                    <div class="mb-3 mt-4"><!--margen debajo 3, margen superior 2-->
                        <label for="sesion_curp" class="form-label">Curp</label>
                        <input id="sesion_curp" type="text" class="form-control" required>
                    </div>
                    <!-- <div class="mb-2">
                        <label for="sesion_contrasenia" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="sesion_contrasenia" required>

                    </div> -->

                    <div class="input-group mb-3">
                        <input type="password" id="sesion_contrasenia" class="form-control" placeholder="Contraseña" aria-label="Contraseña" required aria-describedby="btn_contrasenia">
                        <button class="btn btn-secondary" type="button" id="btn_contrasenia" onclick="ver_contrasenia()">
                            <i class="bi bi-eye-slash" id="ver_contrasenia_icon"></i>
                        </button>
                    </div>


                    <div class="d-grid gap-2 col-6 mx-auto">
                        <input type="button" class="btn btn-primary" onclick="iniciar_sesion()" value="INICIAR SESION">
                    </div>
                </form>
                <!-- <div class="d-grid gap-2 col-6 mx-auto bg-light mt-2" data-bs-toggle="modal" data-bs-target="#myModal">
                    <button class="btn btn-link">REGISTRARME</button>
                </div> -->

            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">CREAR NUEVA CUENTA</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
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
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button id="btn-registrar_usuario" onclick="registrar_usuario()" type="button" class="btn btn-success" data-bs-dismiss="modal">Guardar registro</button>
                </div>
                </form>

            </div>
        </div>
    </div>


</body>

</html>