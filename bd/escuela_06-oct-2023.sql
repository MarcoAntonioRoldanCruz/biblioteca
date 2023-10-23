-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-10-2023 a las 20:38:42
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`IdCategoria`, `NombreCategoria`) VALUES
(1, 'Sin categoría'),
(2, 'Revistas'),
(3, 'Astrolabio'),
(4, 'Infantil');

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
  `Ejemplares` int(11) NOT NULL DEFAULT '1' COMMENT 'Es la cantidad de libros existentes en biblioteca',
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  PRIMARY KEY (`IdLibro`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`IdLibro`, `IdCategoria`, `Titulo`, `Autor`, `Ejemplares`, `Descripcion`) VALUES
(1, 4, 'El grúfalo', 'Julia Donaldson', 2, 'Es una historia encantadora sobre un ratón astuto que inventa un animal imaginario llamado \"El Grúfalo\" para evitar ser comido por otros animales del bosque. Sin embargo, se sorprende cuando descubre que el Grúfalo en realidad existe.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamolibros`
--

DROP TABLE IF EXISTS `prestamolibros`;
CREATE TABLE IF NOT EXISTS `prestamolibros` (
  `IdPrestamo` int(11) NOT NULL AUTO_INCREMENT,
  `IdLibro` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `NumeroLibro` int(11) NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFin` date DEFAULT NULL,
  PRIMARY KEY (`IdPrestamo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
