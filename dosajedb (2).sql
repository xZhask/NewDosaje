-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 09-02-2023 a las 21:28:36
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
-- Estructura de tabla para la tabla `extraccion`
--

CREATE TABLE `extraccion` (
  `id_extraccion` int NOT NULL,
  `tipo_muestra` char(1) COLLATE utf8mb4_general_ci NOT NULL,
  `hora_extracc` time DEFAULT NULL,
  `fecha_extracc` date DEFAULT NULL,
  `hrs_transcurridas` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `extractor` int DEFAULT NULL,
  `id_infraccion` int DEFAULT NULL,
  `observacion` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `extraccion`
--

INSERT INTO `extraccion` (`id_extraccion`, `tipo_muestra`, `hora_extracc`, `fecha_extracc`, `hrs_transcurridas`, `extractor`, `id_infraccion`, `observacion`) VALUES
(1, 'N', '14:25:00', '2023-02-09', '01:1', 16, 5, 'SIN OBSERVACIONES'),
(2, 'N', '14:25:00', '2023-02-09', '01:1', 16, 7, 'SIN OBSERVACIONES'),
(3, 'N', '15:28:00', '2023-02-09', '01:0', 16, 8, 'SIN OBSERVACIONES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infraccion`
--

CREATE TABLE `infraccion` (
  `id_infraccion` int NOT NULL,
  `hoja_registro` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `Motivo` text COLLATE utf8mb4_general_ci,
  `fecha_infr` date NOT NULL,
  `hora_infr` time NOT NULL,
  `vehiculo` varchar(7) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `clase` varchar(7) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `placa` varchar(7) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `n_oficio` int NOT NULL,
  `id_comandancia` int NOT NULL,
  `hora_registro` time NOT NULL,
  `fecha_registro` date NOT NULL,
  `infractor` int NOT NULL,
  `digitador` int NOT NULL,
  `personal_conductor` int DEFAULT NULL,
  `lugar_incidencia` text COLLATE utf8mb4_general_ci,
  `n_certificado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `infraccion`
--

INSERT INTO `infraccion` (`id_infraccion`, `hoja_registro`, `Motivo`, `fecha_infr`, `hora_infr`, `vehiculo`, `clase`, `placa`, `n_oficio`, `id_comandancia`, `hora_registro`, `fecha_registro`, `infractor`, `digitador`, `personal_conductor`, `lugar_incidencia`, `n_certificado`) VALUES
(1, '2222', 'DESPISTE', '2023-02-09', '10:24:00', '', '', '', 489, 2, '11:23:00', '2023-02-09', 3, 1, 4, '', NULL),
(2, '2222', 'DESPISTE', '2023-02-09', '10:24:00', '', '', '', 489, 2, '11:23:00', '2023-02-09', 3, 1, 4, '', NULL),
(3, '', 'DESPISTE', '2023-02-09', '12:32:00', '-', '-', '-', 456, 1, '13:31:00', '2023-02-09', 3, 1, 4, '', NULL),
(4, '', 'DESPISTE', '2023-02-09', '12:32:00', '-', '-', '-', 456, 1, '13:31:00', '2023-02-09', 3, 1, 4, '', NULL),
(5, '2215', 'DESPISTE', '2023-02-09', '13:24:00', '-', '-', '-', 159, 2, '13:55:00', '2023-02-09', 3, 1, 4, '', NULL),
(6, '2215', 'DESPISTE', '2023-02-09', '13:24:00', '-', '-', '-', 159, 2, '13:55:00', '2023-02-09', 3, 1, 4, '', NULL),
(7, '2215', 'DESPISTE', '2023-02-09', '13:24:00', '-', '-', '-', 159, 2, '13:55:00', '2023-02-09', 3, 1, 4, '', NULL),
(8, '456', 'DESPISTE', '2023-02-09', '14:28:00', '-', '-', '-', 456, 3, '15:28:00', '2023-02-09', 3, 1, 4, '', NULL);

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
-- Estructura de tabla para la tabla `peritaje`
--

CREATE TABLE `peritaje` (
  `id_peritaje` int NOT NULL,
  `result_cualitativo` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `result_cuantitativo` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `perito` int DEFAULT NULL,
  `id_infraccion` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peritaje`
--

INSERT INTO `peritaje` (`id_peritaje`, `result_cualitativo`, `result_cuantitativo`, `perito`, `id_infraccion`) VALUES
(1, 'C', 'T/S/M', NULL, 3),
(2, 'C', 'T/S/M', NULL, 7),
(3, 'C', 'T/S/M', NULL, 8);

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
  `grado` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nacionalidad` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `id_tipodoc`, `nro_doc`, `nombre`, `edad`, `lic_conducir`, `sexo`, `grado`, `nacionalidad`) VALUES
(1, 7, '28267676', 'MARILU TELLO MENDOZA', 25, '-', 'F', 'CMDTE', 'Peruana'),
(2, 7, '06827376', 'BARBARAN URBANO, NESTOR', 25, '-', 'M', 'SS PNP', 'Peruana'),
(3, 7, '48193845', 'SILVA AGUILAR, CESAR JOSUE', 25, 'AB52S', 'M', NULL, 'Peruana'),
(4, 7, '77332033', 'BAUTISTA SANCHEZ, KERLY ZULEYDY', NULL, NULL, NULL, 'CAP', NULL),
(15, 7, '06948422', 'POMA VERGARAY, GUSTAVO VICENTE', NULL, NULL, NULL, 'SS PNP', 'Peruana'),
(16, 7, '09655251', 'ZEGARRA ALBARRAN, ROCIO DEL PILAR', NULL, NULL, NULL, 'SS PNP', 'Peruana');

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
  `id_perfil` int DEFAULT NULL,
  `estado` char(1) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_persona`, `pass`, `profesion`, `id_perfil`, `estado`) VALUES
(1, '$2y$07$Y/eb9FP7SQX5mhETPBISSO8pNvf4RW5iAke5ERbylJ7YMqRQuCw9a', 'P', 1, 'A'),
(2, '$2y$07$63yZpsZQklWG065r98RkVOvYALGvp01zAg57RWLrcGr8316eAkBiq', 'E', 2, 'A'),
(15, '$2y$07$mbe83cctoClZTVQCDE0JauC/IMl.aaTXuH9ptgvs704aTA3QtEydu', 'E', 2, 'A'),
(16, '$2y$07$zrIHxJN4u9khsL7ze2f3NueVzoOiLMuEjzowxwj5qToHVtb.3bFVO', 'E', 2, 'A');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comandancia`
--
ALTER TABLE `comandancia`
  ADD PRIMARY KEY (`id_comandancia`);

--
-- Indices de la tabla `extraccion`
--
ALTER TABLE `extraccion`
  ADD PRIMARY KEY (`id_extraccion`),
  ADD KEY `extractor` (`extractor`),
  ADD KEY `id_infraccion` (`id_infraccion`);

--
-- Indices de la tabla `infraccion`
--
ALTER TABLE `infraccion`
  ADD PRIMARY KEY (`id_infraccion`),
  ADD KEY `id_comandancia` (`id_comandancia`),
  ADD KEY `digitador` (`digitador`),
  ADD KEY `personal_conductor` (`personal_conductor`),
  ADD KEY `infractor` (`infractor`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `peritaje`
--
ALTER TABLE `peritaje`
  ADD PRIMARY KEY (`id_peritaje`),
  ADD KEY `perito` (`perito`),
  ADD KEY `id_infraccion` (`id_infraccion`);

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
-- AUTO_INCREMENT de la tabla `extraccion`
--
ALTER TABLE `extraccion`
  MODIFY `id_extraccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `infraccion`
--
ALTER TABLE `infraccion`
  MODIFY `id_infraccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `peritaje`
--
ALTER TABLE `peritaje`
  MODIFY `id_peritaje` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipodoc` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `extraccion`
--
ALTER TABLE `extraccion`
  ADD CONSTRAINT `extraccion_ibfk_1` FOREIGN KEY (`extractor`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `extraccion_ibfk_2` FOREIGN KEY (`id_infraccion`) REFERENCES `infraccion` (`id_infraccion`);

--
-- Filtros para la tabla `infraccion`
--
ALTER TABLE `infraccion`
  ADD CONSTRAINT `infraccion_ibfk_1` FOREIGN KEY (`id_comandancia`) REFERENCES `comandancia` (`id_comandancia`),
  ADD CONSTRAINT `infraccion_ibfk_2` FOREIGN KEY (`digitador`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `infraccion_ibfk_3` FOREIGN KEY (`personal_conductor`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `infraccion_ibfk_4` FOREIGN KEY (`infractor`) REFERENCES `persona` (`id_persona`);

--
-- Filtros para la tabla `peritaje`
--
ALTER TABLE `peritaje`
  ADD CONSTRAINT `peritaje_ibfk_1` FOREIGN KEY (`perito`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `peritaje_ibfk_2` FOREIGN KEY (`id_infraccion`) REFERENCES `infraccion` (`id_infraccion`);

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
