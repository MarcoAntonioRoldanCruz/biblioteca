-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-10-2023 a las 16:13:33
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `escuela`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `IdCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCategoria` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`IdCategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`IdCategoria`, `NombreCategoria`) VALUES
(1, 'Sin categoría'),
(2, 'Revistas'),
(3, 'Astrolabio'),
(4, 'Infantil'),
(5, 'Fantasía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

DROP TABLE IF EXISTS `libros`;
CREATE TABLE IF NOT EXISTS `libros` (
  `IdLibro` int(11) NOT NULL AUTO_INCREMENT,
  `IdCategoria` int(11) NOT NULL,
  `Titulo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Autor` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Numero` varchar(50) COLLATE utf8_spanish2_ci NOT NULL DEFAULT ' ' COMMENT 'Es la clave del libro con el que fue registrado',
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `EsPrestado` varchar(10) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`IdLibro`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`IdLibro`, `IdCategoria`, `Titulo`, `Autor`, `Numero`, `Descripcion`, `EsPrestado`) VALUES
(1, 4, 'El grúfalo', 'Julia Donaldson', 'Infantil-001', 'Es una historia encantadora sobre un ratón astuto que inventa un animal imaginario llamado \"El Grúfalo\" para evitar ser comido por otros animales del bosque. Sin embargo, se sorprende cuando descubre que el Grúfalo en realidad existe.', 'NO'),
(2, 5, 'Harry Potter y la piedra filosofal', 'J.K. Rowling', 'Fantasia-001', 'Las aventuras mágicas del niño que sobrevivió al malvado ser oscuro cuyo nombre no debe ser mencionado.', 'SI'),
(3, 4, 'El Jardín Secreto', 'Frances Hodgson Burnett', 'Infantil-002', 'Narra la historia de Mary Lennox, una niña solitaria que descubre un misterioso jardín escondido en la mansión de su tío. A través de la magia de la naturaleza y la amistad, Mary transforma no solo el jardín, sino también su propia vida. Una conmovedora obra que celebra la curación y el poder de la esperanza.', 'NO'),
(4, 4, 'El Jardín Secreto', 'Frances Hodgson Burnett', 'Infantil-003', 'Narra la historia de Mary Lennox, una niña solitaria que descubre un misterioso jardín escondido en la mansión de su tío. A través de la magia de la naturaleza y la amistad, Mary transforma no solo el jardín, sino también su propia vida. Una conmovedora obra que celebra la curación y el poder de la esperanza.', 'NO'),
(5, 4, 'El Jardín Secreto', 'Frances Hodgson Burnett', 'Infantil-004', 'Narra la historia de Mary Lennox, una niña solitaria que descubre un misterioso jardín escondido en la mansión de su tío. A través de la magia de la naturaleza y la amistad, Mary transforma no solo el jardín, sino también su propia vida. Una conmovedora obra que celebra la curación y el poder de la esperanza.', 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamolibros`
--

DROP TABLE IF EXISTS `prestamolibros`;
CREATE TABLE IF NOT EXISTS `prestamolibros` (
  `IdPrestamo` int(11) NOT NULL AUTO_INCREMENT,
  `IdLibro` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `NumeroLibro` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date DEFAULT NULL,
  PRIMARY KEY (`IdPrestamo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `prestamolibros`
--

INSERT INTO `prestamolibros` (`IdPrestamo`, `IdLibro`, `IdUsuario`, `NumeroLibro`, `FechaInicio`, `FechaFin`) VALUES
(1, 1, 1, '', '2023-10-23', '2023-10-24'),
(2, 1, 1, '', '2023-10-23', '2023-10-31'),
(3, 2, 1, '', '2023-10-24', '2023-10-31'),
(4, 3, 1, '', '2023-10-18', '2023-10-24'),
(5, 5, 1, '', '2023-10-27', '2023-10-24'),
(6, 1, 1, '', '2023-10-02', '2023-10-24'),
(7, 4, 1, '', '2023-10-13', '2023-10-24'),
(8, 2, 1, '', '2023-10-23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sanciones`
--

DROP TABLE IF EXISTS `sanciones`;
CREATE TABLE IF NOT EXISTS `sanciones` (
  `IdSancion` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) NOT NULL,
  `SancionInicio` date NOT NULL,
  `SancionFin` date NOT NULL,
  PRIMARY KEY (`IdSancion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `CurpUsuario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `NombreUsuario` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `GradoGrupo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`IdUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `CurpUsuario`, `NombreUsuario`, `GradoGrupo`) VALUES
(1, 'ROCM980402HQTLRR01', 'Marco Antonio', 'Administrador');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
