-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 14-08-2023 a las 09:05:52
-- Versión del servidor: 10.5.20-MariaDB
-- Versión de PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crud_empleados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `idEmpleado` varchar(15) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidoPaterno` varchar(35) DEFAULT NULL,
  `apellidoMaterno` varchar(35) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `fechaIngreso` date DEFAULT NULL,
  `genero` char(1) DEFAULT NULL,
  `estatus` char(1) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `telefono` char(10) DEFAULT NULL,
  `fotografia` varchar(80) DEFAULT NULL,
  `puesto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`idEmpleado`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `fechaNacimiento`, `rfc`, `fechaIngreso`, `genero`, `estatus`, `domicilio`, `telefono`, `fotografia`, `puesto`) VALUES
('0001', 'Bernabe', 'Fernandez', 'Gomez', '2001-05-05', 'FEGB01050544', '2023-08-13', '1', '1', 'Las Granjas', '9611917371', '1ea1e5fd1cf4883b1d8b0f8f79e65f8e.jpg', '00001'),
('0002', 'Julio Cesar', 'Mendez', 'Toledo', '1970-12-01', 'METJ701201GH', '2023-05-10', '1', '1', 'Las Palmas', '9614560989', '111c28bb8e613104535ca4c6deb111f4.jpg', '00001'),
('0003', 'Juan', 'Hernandez', 'Perez', '1980-01-04', 'TYUI876545ER3', '2022-04-04', '1', '1', 'Las Palmas', '9614562343', 'e8402aba715e5eccd6c3e060dbe3deeb.jpg', '00002'),
('0005', 'Patricia', 'Jimenez', 'Rojas', '1994-06-14', 'JIRP940614', '2019-06-05', '1', '1', 'La Mision', '9611564534', '58fce7652d04387e7359f1de68cde7e7.jpg', '00004');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `idPuesto` varchar(10) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `sueldo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `puestos`
--

INSERT INTO `puestos` (`idPuesto`, `nombre`, `sueldo`) VALUES
('00001', 'Director Operativo', 12000),
('00002', 'Director Ejecutivo', 12000),
('00003', 'Contralor', 10000),
('00004', 'Gerente RH', 8500),
('00005', 'Auxiliar RH', 7500),
('00006', 'Gerente Sistemas', 8000),
('00007', 'Auxiliar Sistemas', 7500),
('00008', 'Contador Fiscal', 8000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `password`) VALUES
(1, 'admin', 'root');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`idEmpleado`),
  ADD KEY `fk_empleados_puesto` (`puesto`) USING BTREE;

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`idPuesto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleados_puesto` FOREIGN KEY (`puesto`) REFERENCES `puestos` (`idPuesto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
