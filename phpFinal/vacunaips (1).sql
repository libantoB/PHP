-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2024 a las 22:47:48
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vacunaips`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliId` int(11) NOT NULL,
  `cliNombre` varchar(50) NOT NULL,
  `cliApellido` varchar(50) NOT NULL,
  `cliTipoDocumento` varchar(3) NOT NULL,
  `cliDocumento` varchar(12) NOT NULL,
  `cliTelefono` varchar(12) NOT NULL,
  `cliFechaNacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliId`, `cliNombre`, `cliApellido`, `cliTipoDocumento`, `cliDocumento`, `cliTelefono`, `cliFechaNacimiento`) VALUES
(1, 'Libardo', 'Bolivar', 'cc', '1144077422', '3175406406', '2024-11-14'),
(2, 'oscar', 'oggioni', 'cc', '1123556', '3734830923', '2024-01-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `facNumero` int(11) NOT NULL,
  `clienteId` int(11) NOT NULL,
  `nombreCliente` varchar(50) DEFAULT NULL,
  `productoId` int(11) NOT NULL,
  `nombreProducto` varchar(250) DEFAULT NULL,
  `cantidadProducto` int(11) NOT NULL,
  `valorProducto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `proId` int(11) NOT NULL,
  `proNombreProducto` varchar(250) NOT NULL,
  `proLote` varchar(50) NOT NULL,
  `proValor` double(50,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`proId`, `proNombreProducto`, `proLote`, `proValor`) VALUES
(1, 'Pruebas de PPD', '67834983', 787878.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliId`),
  ADD UNIQUE KEY `cliDocumento` (`cliDocumento`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`facNumero`),
  ADD KEY `clienteId` (`clienteId`),
  ADD KEY `productoId` (`productoId`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`proId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `facNumero` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `proId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`clienteId`) REFERENCES `cliente` (`cliId`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`productoId`) REFERENCES `productos` (`proId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
