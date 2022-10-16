-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2022 a las 06:00:01
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
-- Base de datos: `tpe_web2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(31) NOT NULL,
  `estructura_especificaciones` varchar(511) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `estructura_especificaciones`) VALUES
(1, 'Procesadores', 'a:3:{i:0;s:7:\"Nucleos\";i:1;s:5:\"Hilos\";i:2;s:10:\"Frecuencia\";}'),
(2, 'Placas de video', 'a:3:{i:0;s:9:\"Capacidad\";i:1;s:4:\"Hdmi\";i:2;s:12:\"Displayports\";}'),
(3, 'Almacenamiento', 'a:4:{i:0;s:4:\"Tipo\";i:1;s:9:\"Capacidad\";i:2;s:33:\"Velocidad de escritura secuencial\";i:3;s:31:\"Velocidad de lectura secuencial\";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_productos`
--

CREATE TABLE `lista_productos` (
  `id` int(11) NOT NULL,
  `categoria_fk` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(63) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `especificaciones` varchar(511) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lista_productos`
--

INSERT INTO `lista_productos` (`id`, `categoria_fk`, `nombre`, `imagen`, `stock`, `precio`, `especificaciones`) VALUES
(130, 1, 'Intel Core i7 12700K', 'app/views/images/634b024adfc4d.jpg', 20, 111500, 'a:4:{i:0;s:2:\"12\";i:1;s:2:\"20\";i:2;s:8:\"2700 mhz\";i:3;s:8:\"5000 mhz\";}'),
(131, 1, 'Intel Core i7 12700KF', 'app/views/images/634b030a4bad7.jpg', 33, 104400, 'a:4:{i:0;s:2:\"12\";i:1;s:2:\"20\";i:2;s:8:\"2700 mhz\";i:3;s:8:\"5000 mhz\";}'),
(132, 1, 'Intel Core i7 12700', 'app/views/images/634b03453babd.jpg', 15, 92500, 'a:4:{i:0;s:2:\"12\";i:1;s:2:\"20\";i:2;s:8:\"2100 mhz\";i:3;s:8:\"4900 mhz\";}'),
(133, 1, 'Intel Core i5 12600KF', 'app/views/images/634b03c9c0a1c.jpg', 45, 61200, 'a:4:{i:0;s:2:\"10\";i:1;s:2:\"16\";i:2;s:8:\"2800 mhz\";i:3;s:8:\"4900 mhz\";}'),
(136, 3, 'WD 2TB Black SN850X', 'app/views/images/634b07525d9da.jpg', 12, 73500, 'a:5:{i:0;s:2:\"M2\";i:1;s:4:\"2 TB\";i:2;s:9:\"7300 mb/s\";i:3;s:9:\"6600 mb/s\";i:4;s:0:\"\";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_admin`
--

CREATE TABLE `users_admin` (
  `id` int(11) NOT NULL,
  `nombre` varchar(31) NOT NULL,
  `contrasenia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users_admin`
--

INSERT INTO `users_admin` (`id`, `nombre`, `contrasenia`) VALUES
(1, 'Admin1', '$2a$12$17rQub70BZ8z8vuzqoXZh.gncQUyhx2AMjqVHrLLP8dhtvhb2y2Zi');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categoria_unica` (`categoria`);

--
-- Indices de la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lista_productos_ibfk_1` (`categoria_fk`);

--
-- Indices de la tabla `users_admin`
--
ALTER TABLE `users_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT de la tabla `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  ADD CONSTRAINT `lista_productos_ibfk_1` FOREIGN KEY (`categoria_fk`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
