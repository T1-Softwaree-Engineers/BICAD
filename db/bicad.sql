-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2022 a las 22:48:05
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bicad`
--
CREATE DATABASE IF NOT EXISTS `bicad` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bicad`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adultosm`
--

CREATE TABLE IF NOT EXISTS `adultosm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ecuidador` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `edad` int(2) NOT NULL,
  `genero` varchar(25) NOT NULL,
  `contacto` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ecuidador` (`ecuidador`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `adultosm`
--

INSERT INTO `adultosm` (`id`, `ecuidador`, `nombre`, `apellido`, `edad`, `genero`, `contacto`) VALUES
(1, 'eochoa11@ucol.mx', 'Enrique', 'Ochoa Preciado', 21, 'Hombre', '3141076334');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contacto` varchar(15) NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `role` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contacto` (`contacto`),
  KEY `email` (`email`),
  KEY `email_2` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `nombre`, `apellidos`, `email`, `contacto`, `pwd`, `role`) VALUES
(1, 'eochoa11', 'Enrique de Jesús', 'Ochoa Preciado', 'eochoa11@ucol.mx', '3141076334', 'e50d11e94bafcd7c78120d7a6478bce07c60b70207f7aa19e71ebdb37eecccbde475e051a28209fdfb5c9a217ea08d335422244574465e73c39863c8f18874fa', 'usuario');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adultosm`
--
ALTER TABLE `adultosm`
  ADD CONSTRAINT `adultosm_ibfk_1` FOREIGN KEY (`ecuidador`) REFERENCES `usuarios` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
