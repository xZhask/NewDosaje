-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 21-01-2023 a las 17:14:58
-- Versión del servidor: 8.0.31
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dosajedb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comandancia`
--

CREATE TABLE `comandancia` (
  `id_comandancia` int NOT NULL,
  `comisaria` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comandancia`
--

INSERT INTO `comandancia` (`id_comandancia`, `comisaria`) VALUES
(1, 'COMISARÍA PNP. BAYOVAR-DIVPOL ESTE 1'),
(2, 'COMISARÍA PNP. CAJA DE AGUA-DIVPOL ESTE 1'),
(3, 'COMISARÍA PNP. CANTO REY-DIVPOL ESTE 1'),
(4, 'COMISARÍA PNP. LA HUAYRONA-DIVPOL ESTE 1'),
(5, 'COMISARÍA PNP. MARISCAL CÁCERES-DIVPOL ESTE 1'),
(6, 'COMISARIA PNP. SAN ANTONIO DE JICAMARCA-DIVPOL ESTE 1'),
(7, 'COMISARÍA PNP. SANTA ELIZABETH-DIVPOL ESTE 1'),
(8, 'COMISARÍA PNP. ZARATE-DIVPOL ESTE 1'),
(9, 'COMISARÍA PNP. 10 DE OCTUBRE-DIVPOL ESTE 1'),
(10, 'COMISARÍA PNP. EL AGUSTINO-DIVPOL CENTRO'),
(11, 'COMISARÍA PNP. SAN CAYETANO-DIVPOL CENTRO'),
(12, 'COMISARÍA PNP. SANTOYO-DIVPOL CENTRO'),
(13, 'COMISARÍA PNP. VILLA HERMOSA-DIVPOL CENTRO'),
(14, 'COMISARIA PNP. CARABAYLLO-DIVPOL NORTE 1'),
(15, 'COMISARIA PNP. EL PROGRESO-DIVPOL NORTE 1'),
(16, 'COMISARIA PNP. SANTA ISABEL-DIVPOL NORTE 1'),
(17, 'COMISARIA PNP. SOL DE ORO-DIVPOL NORTE 1'),
(18, 'COMISARIA PNP. CANTA-DIVPOL NORTE 2'),
(19, 'COMISARIA PNP. LA PASCANA-DIVPOL NORTE 2'),
(20, 'COMISARIA PNP. LA UNIFICADA-DIVPOL NORTE 2'),
(21, 'COMISARIA PNP. PAYET-DIVPOL NORTE 2'),
(22, 'COMISARIA PNP. SANTA LUZMILA-DIVPOL NORTE 2'),
(23, 'COMISARIA PNP. TAHUANTINSUYO-DIVPOL NORTE 2'),
(24, 'COMISARIA PNP. TUPAC AMARU - COMAS-DIVPOL NORTE 2'),
(25, 'COMISARIA PNP. UNIVERSITARIA-DIVPOL NORTE 2'),
(26, 'COMISARIA PNP. YANGAS-DIVPOL NORTE 2'),
(27, 'COMISARIA PNP. BARBONCITO-DIVPOL NORTE 3'),
(28, 'COMISARIA PNP. CIUDAD Y CAMPO-DIVPOL NORTE 3'),
(29, 'COMISARIA PNP. EL MANZANO-DIVPOL NORTE 3'),
(30, 'COMISARIA PNP. FLOR DE AMANCAES-DIVPOL NORTE 3'),
(31, 'COMISARIA PNP. PIEDRA LIZA-DIVPOL NORTE 3'),
(32, 'COMISARIA PNP. RIMAC-DIVPOL NORTE 3'),
(33, 'COMISARIA PNP. SAN MARTIN DE PORRES-DIVPOL NORTE 3'),
(34, 'COMISARIA PNP. COLLIQUE-DIVPOL NORTE 2'),
(35, 'COMISARIA PNP . CHACLACAYO'),
(36, 'COMISARIA PNP . INDEPENDENCIA-DIVPOL NORTE 2'),
(37, 'INVERSIONES BRADE S.A'),
(38, 'COMISARIA PNP HUACHIPA'),
(39, 'COMISARIA PNP CHOSICA'),
(40, 'CORPORACION PERUANA DE PRODUCTOS QUIMICOS  S.A.'),
(41, 'COMISARIA PNP PRO - DIVPOL NORTE 1'),
(42, 'COMISARIA PNP ANCON - DIVPOL NORTE 1'),
(43, 'COMISARIA PNP LAURA CALLER - DIVPOL NORTE 1'),
(44, 'COMISARIA PNP PUENTE PIEDRA - DIVPOL NORTE 1'),
(45, 'COMISARIA PNP CONDEVILLA SEÑOR - DVPOL NORTE 3'),
(46, 'COMISARIA PNP ZAPALLAL - DIVPOL NORTE 1'),
(47, 'ESCUELA DE OFICIALES PNP PUENTE PIEDRA'),
(48, 'UIAT-NORTE'),
(49, 'DIRECCION NACIONAL DE OPERACIONES ESPECIALES'),
(50, 'COMISARIA PNP CHACRA COLORADA'),
(51, 'COMISARIA PNP PETIT THOUARS'),
(52, 'COMISARIA PNP COTABAMBA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int NOT NULL,
  `perfil` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `perfil`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'DIGITADOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int NOT NULL,
  `id_tipodoc` int NOT NULL,
  `nro_doc` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `edad` int DEFAULT NULL,
  `lic_conducir` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sexo` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `grado` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `id_tipodoc`, `nro_doc`, `nombre`, `edad`, `lic_conducir`, `sexo`, `fecha_nac`, `grado`) VALUES
(1, 7, '28267676', 'MARILU TELLO MENDOZA', 45, NULL, 'F', NULL, 'CMDTE SPNP'),
(2, 7, '06827376', 'BARBARAN URBANO, NESTOR', NULL, NULL, 'M', NULL, 'SS PNP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipodoc` int NOT NULL,
  `tipo_doc` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipodoc`, `tipo_doc`) VALUES
(7, 'DNI'),
(8, 'Carnet de Extranjería'),
(9, 'Cédula de Identidad'),
(10, 'CPP'),
(11, 'SIDPOL'),
(12, 'Licencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_persona` int DEFAULT NULL,
  `pass` text COLLATE utf8mb4_general_ci,
  `profesion` char(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_perfil` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_persona`, `pass`, `profesion`, `id_perfil`) VALUES
(1, '123', 'P', 1),
(2, '123', 'E', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comandancia`
--
ALTER TABLE `comandancia`
  ADD PRIMARY KEY (`id_comandancia`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `id_tipodoc` (`id_tipodoc`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipodoc`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comandancia`
--
ALTER TABLE `comandancia`
  MODIFY `id_comandancia` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipodoc` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_tipodoc`) REFERENCES `tipo_documento` (`id_tipodoc`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
