<?php
// "Se coloca aquí" el contenido del archivo de conexión, pero no se ve directamente para no reescribirlo todo.
include_once "conexion.php";

// pdo es la variable que se encuentra en el archivo conexión.php que tiene como tal la conexión a la instancia de la base de datos.
$pdo->exec("SET NAMES UTF8");

// $_POST contiene la información conjunta en estructura similar o igual a un JSON proveniente de otro archivo, en este caso de main.js
// Un ejemplo de cómo viene la información en POST es: { accion: "iniciar_sesion", curp: "abcd..." }

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : ""; //declaracion de variable $accion: recibe valor de main.js

// En acción la acción determinará lo que va a realizar este archivo clase para generar la consulta correspondiente en la base de datos.
switch ($accion) {
    case 'iniciar_sesion':
        $curp = (isset($_POST['curp'])) ? $_POST['curp']  : "";
        $sql = "SELECT * FROM usuarios WHERE CurpUsuario = '{$curp}' LIMIT 1";
        $usuario_st = $pdo->prepare($sql);
        $usuario_st->execute();
        $usuario = $usuario_st->fetch();
        if (!empty($usuario)) {
            echo "ok";
        } else {
            echo "no";
        }
        break;
    case 'registrar_usuario':
        $curp_registro = (isset($_POST['curp_registro'])) ? $_POS['curp_registro'] : "";
        $grado_grupo_registro = (isset($_POS['grado_grupo_registro'])) ? $_POST['grado_grupo_registro'] : "";
        $usuario_registro = (isset($_POST['usuario_registro'])) ? $_POST['usuario_registro'] : "";
        $sql = "INSERT INTO usuarios(CurpUsuario, NombreUsuario, GradoGrupo) VALUES('{$curp_registro}', '{$usuario_registro}','{$grado_grupo_registro}')";
        $usuario_st = $pdo->prepare($sql);
        // Si puede realizar la inserción de un registro regresa unresultado favorable "OK"
        if ($usuario_st->execute()) {
            echo "OK";
        } else {
            echo $usuario_st->errorInfo()[2]; // Sino regresar el error (Elcual el programador debe colocar en un html en blancopara poder visualizarlo correctamente);
        }
        break;
    case 'registrar_libro':
        $titulo_registro = (isset($_POST['titulo_registro'])) ? $_POST['titulo_registro'] : "";
        $autor_registro = (isset($_POST['autor_registro'])) ? $_POST['autor_registro'] : "";
        $categoria_registro = (isset($_POST['categoria_registro'])) ? $_POST['categoria_registro'] : "";
        $cantidad_registro = (isset($_POST['cantidad_registro'])) ? $_POST['cantidad_registro'] : "";
        $descripcion_registro = (isset($_POST['descripcion_registro'])) ? $_POST['descripcion_registro'] : "";
        $sql = "INSERT INTO libros (IdCategoria, Titulo, Autor, Ejemplares, Descripcion) VALUES ('{$categoria_registro}', '{$titulo_registro}', '{$autor_registro}', '{$cantidad_registro}', '{$descripcion_registro}')";
        $libro_st = $pdo->prepare($sql);
        if ($libro_st->execute()) {
            echo "OK";
        } else {
            echo $libro_st->errorInfo()[2];
        }
        break;
    case 'registrar_categoria':
        $categoria_nuevo = (isset($_POST['categoria_nuevo'])) ? $_POST['categoria_nuevo'] : "";
        $sql = "INSERT INTO categorias (NombreCategoria) VALUES ('{$categoria_nuevo}')";
        $categoria_st = $pdo->prepare($sql);
        if ($categoria_st->execute()) {
            echo "OK";
        } else {
            echo $categoria_st->errorInfo()[2];
        }
        break;
    case 'buscar_libro':
        $libro_buscar = (isset($_POST['libro_buscar'])) ? $_POST['libro_buscar'] : "";
        $sql = "SELECT * FROM libros WHERE Titulo LIKE '%{$libro_buscar}%' OR Autor LIKE '%{$libro_buscar}%'";
        $libro_st = $pdo->prepare($sql);
        $libro_st->execute();
        if ($libro_st->rowCount() > 0) {
            while ($libro = $libro_st->fetch()) {
                $libro_IdCategoria = $libro['IdCategoria'];
                $sql = "SELECT * FROM categorias WHERE IdCategoria = '{$libro_IdCategoria}' LIMIT 1";
                $libro_categoria_st = $pdo->prepare($sql);
                $libro_categoria_st->execute();
                $libro_categoria = $libro_categoria_st->fetch();
                $categoria = $libro_categoria['NombreCategoria'];
                echo "<tr title='{$libro['Descripcion']}' data-bs-toggle='tooltip'>
                <td scope='row'>{$libro['Titulo']}</td>
                <td>{$categoria}</td>
                <td>{$libro['Autor']}</td>
            <tr>";
            }
        } else {
            echo "0";
        }
        break;
    case 'prestar_libro':
        $libro_prestar = (isset($_POST['libro_prestar'])) ? $_POST['libro_prestar'] : "";
        $curp_usuario = (isset($_POST['curp_usuario'])) ? $_POST['curp_usuario'] : "";
        $numero_libro_prestar = (isset($_POST['numero_libro_prestar'])) ? $_POST['numero_libro_prestar'] : "";
        $fecha_prestamo = (isset($_POST['fecha_prestamo'])) ? $_POST['fecha_prestamo'] : $fecha;

        $sql = "SELECT * FROM usuarios WHERE CurpUsuario = '{$curp_usuario}' LIMIT 1";
        $usuario_st = $pdo->prepare($sql);
        $usuario_st->execute();
        $usuario = $usuario_st->fetch();

        $sql = "INSERT INTO prestamolibros(IdLibro, IdUsuario, NumeroLibro, FechaInicio, FechaFin) VALUES ('{$libro_prestar}', '{$usuario['IdUsuario']}', '{$numero_libro_prestar}', '{$fecha_prestamo}', NULL)";
        $prestamos_st = $pdo->prepare($sql);
        if ($prestamos_st->execute()) {

            $sql = "UPDATE libros SET EsPrestado = 'SI' WHERE IdLibro = '{$libro_prestar}'";
            $libros_st = $pdo->prepare($sql);
            if ($libros_st->execute()) {
                echo "OK";
            } else {
                echo "No";
            }
        } else {
            echo "No";
        }
        break;
    case 'buscar_lector':
        $id_usuario = (isset($_POST['id_usuario'])) ? $_POST['id_usuario'] : "";
        $sql = "SELECT * FROM prestamolibros WHERE IdUsuario = '{$id_usuario}' AND FechaFin IS NULL";
        $prestamos_st = $pdo->prepare($sql);
        $prestamos_st->execute();
        $prestamos_conteo = $prestamos_st->rowCount();
        $html = "<option value='' selected>Selecciona el libro</option>";
        while ($prestamo = $prestamos_st->fetch()) {
            $sql = "SELECT * FROM libros WHERE IdLibro = '{$prestamo['IdLibro']}' LIMIT 1";
            $libros_st = $pdo->prepare($sql);
            $libros_st->execute();
            $libro = $libros_st->fetch();

            $sql = "SELECT * FROM usuarios WHERE IdUsuario = {$prestamo['IdUsuario']} LIMIT 1";
            $usuario_st = $pdo->prepare($sql);
            $usuario_st->execute();
            $usuario = $usuario_st->fetch();

            $html .= "<option value='{$prestamo['IdPrestamo']}' title='{$usuario['CurpUsuario']}' id_libro='{$libro['IdLibro']}'>{$libro['Titulo']} - No. {$libro['Numero']}</option>";
        }
        echo $html;
        break;
    case 'buscar_prestamo':
        $id_prestamo = (isset($_POST['id_prestamo'])) ? $_POST['id_prestamo'] : "";
        $sql = "SELECT * FROM prestamolibros WHERE IdPrestamo = {$id_prestamo} LIMIT 1";
        $prestamos_st = $pdo->prepare($sql);
        $prestamos_st->execute();
        $prestamo = $prestamos_st->fetch();

        echo $prestamo['FechaInicio'];
        // echo $sql;
        break;
    case 'devolver_libro':
        $usuario_devolver = (isset($_POST['usuario_devolver'])) ? $_POST['usuario_devolver'] : "";
        $libro_devolver = (isset($_POST['libro_devolver'])) ? $_POST['libro_devolver'] : "";
        $fecha_devolucion = (isset($_POST['fecha_devolucion'])) ? $_POST['fecha_devolucion'] : $fecha;
        $id_libro = (isset($_POST['id_libro'])) ? $_POST['id_libro'] : "";
        $sql = "UPDATE prestamolibros SET FechaFin = '{$fecha_devolucion}' WHERE IdUsuario = '{$usuario_devolver}' AND IdPrestamo = '{$libro_devolver}'";
        $prestamos_st = $pdo->prepare($sql);
        if ($prestamos_st->execute()) {
            $sql = "UPDATE libros SET EsPrestado = 'NO' WHERE IdLibro = '{$id_libro}'";
            $libro = $pdo->prepare($sql);
            if ($libro->execute()) {
                echo "OK";
            } else {
                echo "No";
            }
        } else {
            echo "No";
        }
        break;
    case 'consultar_historial':
        $desde = (isset($_POST['desde'])) ? $_POST['desde'] : "";
        $hasta = (isset($_POST['hasta'])) ? $_POST['hasta'] : "";
        $sql = "SELECT * FROM prestamolibros WHERE FechaInicio BETWEEN '{$desde}' AND '{$hasta}' ORDER BY IdPrestamo DESC";
        $historial_st = $pdo->prepare($sql);
        $historial_st->execute();
        $html = "";
        while ($prestamo = $historial_st->fetch()) {
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

            $html .= "<tr>
                <td>{$prestamo['IdPrestamo']}</td>
                <td>{$libro['Titulo']}</td>
                <td>{$categoria['NombreCategoria']}</td>
                <td>{$libro['Autor']}</td>
                <td>{$prestamo['FechaInicio']}</td>
                <td>{$prestamo['FechaFin']}</td>
                <td>{$usuario['NombreUsuario']}</td>
            </tr>";
        }
        echo $html;
        break;
    default:
        echo "ACCION NO ENCONTRADA";
        break;
}
