-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2026 a las 22:35:24
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
-- Base de datos: `proyecto_alzheimer`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estado` enum('pendiente','realizada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `usuario_id`, `titulo`, `descripcion`, `fecha`, `hora`, `estado`) VALUES
(1, 1, 'comer', 'Comer la cena', '2026-05-06', '20:05:00', 'realizada'),
(2, 1, 'Medicina', 'Tomar la medicina de la tension', '2026-05-09', '16:33:00', 'realizada'),
(3, 1, 'Caminar', 'Realizar caminata durante 20 minutos', '2026-05-09', '16:56:00', 'realizada'),
(4, 1, 'Desayuno', 'Comer el desayuno con la hidratación indicada', '2026-05-09', '16:22:00', ''),
(5, 1, 'ducha', 'ducha', '2026-05-09', '16:08:00', ''),
(6, 1, 'merienda', 'comer merienda sin azúcar', '2026-05-09', '16:34:00', ''),
(7, 1, 'Tomar medicamento para el azúcar', 'Nombre del medicamento', '2026-05-09', '17:17:00', 'pendiente'),
(8, 1, 'Hacer ejercicio', 'Realizar caminata rápida durante 10 minutos', '2026-05-10', '08:10:00', 'pendiente'),
(9, 1, 'Analiticas', 'toma de analìticas para medir niveles de bilirrubina', '2026-05-12', '06:02:00', 'pendiente'),
(10, 1, 'Analiticas', 'toma de analìticas para medir niveles de bilirrubina', '2026-05-12', '06:02:00', 'pendiente'),
(11, 1, 'Analiticas', 'toma de analìticas para medir niveles de bilirrubina', '2026-05-12', '06:02:00', 'pendiente'),
(12, 1, 'Analiticas', 'toma de analìticas para medir niveles de bilirrubina', '2026-05-12', '06:02:00', 'pendiente'),
(18, 1, 'ver futbol', 'ver futbol', '2026-05-11', '17:25:00', 'pendiente'),
(21, 1, 'ver futbol', 'ver futbol', '2026-05-11', '07:22:00', 'pendiente'),
(22, 1, 'caminar', 'caminar', '2026-05-11', '19:00:00', 'pendiente'),
(23, 1, 'ver futbol', 'ver futbol', '2026-05-21', '19:14:00', 'pendiente'),
(24, 1, 'ver futbol', 'ver futbol', '2026-05-25', '00:11:00', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

CREATE TABLE `contenido` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `archivo` varchar(255) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`id`, `titulo`, `descripcion`, `archivo`, `categoria`, `creado_en`) VALUES
(1, 'Biología en la sangre', 'Nuevos hallazgos médicos de pruebas en sangre', '/uploads/contenido/1778263365-avances-en-la-investigacion.pdf', NULL, '2026-05-08 18:02:45'),
(2, 'Guía del Cuidador', 'Cuidados para paciente y recursos para familiares y cuidadores', '/uploads/contenido/1778263441-GuiaCuidadores.pdf', NULL, '2026-05-08 18:04:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro_respuestas`
--

CREATE TABLE `foro_respuestas` (
  `id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foro_respuestas`
--

INSERT INTO `foro_respuestas` (`id`, `tema_id`, `usuario_id`, `respuesta`, `fecha`) VALUES
(1, 5, 2, 'esto es', '2026-05-10 16:46:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro_temas`
--

CREATE TABLE `foro_temas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foro_temas`
--

INSERT INTO `foro_temas` (`id`, `usuario_id`, `titulo`, `contenido`, `fecha`) VALUES
(1, 3, 'Como llevas el día a día con tu familiar', 'Comenta tu experiencia y como sobrellevas las actividades del día a día', '2026-05-08 18:04:50'),
(2, 3, 'Como ayudar a nuestros familiares a dormir placidamente', 'Comenta sobre las técnicas que empleas para lograr que tu familiar tenga un sueño tranquilo', '2026-05-08 18:12:56'),
(3, 3, 'Tratamiento de la enfermedad', 'Debate sobre la medicina alternativa, terapéutica o tradicional para el tratamiento. ¿Qué prefieres?', '2026-05-09 10:08:01'),
(4, 2, 'Ejemplo', 'Lorem ipsum', '2026-05-09 16:30:47'),
(5, 1, 'dfeewety', 'sauyseru', '2026-05-09 19:46:46'),
(6, 2, 'JSJSJS', 'JSJSJS', '2026-05-10 17:07:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `leida` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `usuario_id`, `mensaje`, `fecha`, `leida`) VALUES
(1, 1, 'No completaste la actividad: \'Desayuno\' antes de la hora límite.', '2026-05-09 16:46:51', 1),
(2, 2, 'El paciente no completó la actividad: \'Desayuno\' antes de la hora límite.', '2026-05-09 16:46:51', 0),
(3, 1, 'No completaste la actividad: \'ducha\' antes de la hora límite.', '2026-05-09 16:46:51', 1),
(4, 2, 'El paciente no completó la actividad: \'ducha\' antes de la hora límite.', '2026-05-09 16:46:51', 0),
(6, 2, 'El paciente no completó la actividad: \'merienda\' antes de la hora límite.', '2026-05-09 16:46:51', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `user_id`, `fecha_nacimiento`, `direccion`, `telefono`, `genero`, `diagnostico`, `fecha_creacion`) VALUES
(1, 1, '1950-01-19', NULL, NULL, NULL, NULL, '2026-05-05 16:32:02'),
(2, 4, '1951-02-11', NULL, NULL, NULL, NULL, '2026-05-09 17:30:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesionales`
--

CREATE TABLE `profesionales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `especialidad` varchar(120) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `servicios` text DEFAULT NULL,
  `horario_lunes` varchar(50) DEFAULT NULL,
  `horario_martes` varchar(50) DEFAULT NULL,
  `horario_miercoles` varchar(50) DEFAULT NULL,
  `horario_jueves` varchar(50) DEFAULT NULL,
  `horario_viernes` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesionales`
--

INSERT INTO `profesionales` (`id`, `nombre`, `especialidad`, `direccion`, `servicios`, `horario_lunes`, `horario_martes`, `horario_miercoles`, `horario_jueves`, `horario_viernes`, `foto`, `creado_en`) VALUES
(1, 'Sofia Barreto', 'Neurología', 'Gijón', NULL, 'Cerrado', 'Tarde (16:00–20:00)', 'Tarde (16:00–20:00)', 'Mañana (08:00–14:00)', 'Completo (08:00–20:00)', NULL, '2026-05-08 16:41:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relaciones_familiares`
--

CREATE TABLE `relaciones_familiares` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `familiar_id` int(11) NOT NULL,
  `parentesco` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `relaciones_familiares`
--

INSERT INTO `relaciones_familiares` (`id`, `paciente_id`, `familiar_id`, `parentesco`) VALUES
(1, 1, 2, 'Cuidador'),
(2, 4, 2, 'hijo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `juego` varchar(100) NOT NULL,
  `puntaje` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `detalle` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados`
--

INSERT INTO `resultados` (`id`, `usuario_id`, `juego`, `puntaje`, `fecha`, `detalle`) VALUES
(1, 1, 'rompecabezas', 1, '2026-05-08 06:47:09', 'Juego: rompecabezas | Dificultad: facil | Tiempo: 5s'),
(2, 1, 'memoria', 6, '2026-05-08 06:47:56', 'Juego: memoria | Dificultad: facil | Tiempo: 19s'),
(3, 1, 'colores', 5, '2026-05-08 06:48:46', 'Juego: colores | Dificultad: facil | Tiempo: 34s'),
(4, 1, 'memoria', 2, '2026-05-08 06:50:01', 'Juego: memoria | Dificultad: ninguna | Tiempo: 0s'),
(5, 1, 'atencion', 4, '2026-05-08 06:50:45', 'Juego: atencion | Dificultad: ninguna | Tiempo: 0s'),
(6, 1, 'rompecabezas', 1, '2026-05-08 06:54:46', 'Juego: rompecabezas | Dificultad: medio | Tiempo: 24s | Puntuación: 1'),
(7, 1, 'memoria', 3, '2026-05-08 06:55:16', 'Test: memoria | Dificultad: ninguna | Tiempo: 0s | Puntuación: 3'),
(8, 1, 'actividad', NULL, '2026-05-08 13:32:24', 'Actividad realizada: Medicina'),
(9, 1, 'actividad', NULL, '2026-05-08 14:07:32', 'Actividad realizada: Caminar'),
(10, 1, 'memoria', 2, '2026-05-09 09:01:24', 'Test: memoria | Dificultad: ninguna | Tiempo: 0s | Puntuación: 2'),
(11, 1, 'atencion', 3, '2026-05-09 09:02:10', 'Test: atencion | Dificultad: ninguna | Tiempo: 0s | Puntuación: 3'),
(12, 1, 'rompecabezas', 1, '2026-05-09 15:13:22', 'Juego: rompecabezas | Dificultad: facil | Tiempo: 6s | Puntuación: 1'),
(13, 1, 'memoria', 6, '2026-05-09 15:14:03', 'Test: memoria | Dificultad: facil | Tiempo: 20s | Puntuación: 6'),
(14, 1, 'colores', 5, '2026-05-09 15:14:53', 'Juego: colores | Dificultad: facil | Tiempo: 33s | Puntuación: 5'),
(15, 1, 'memoria', 2, '2026-05-09 15:18:05', 'Test: memoria | Dificultad: ninguna | Tiempo: 0s | Puntuación: 2'),
(16, 1, 'atencion', 2, '2026-05-09 15:18:56', 'Test: atencion | Dificultad: ninguna | Tiempo: 0s | Puntuación: 2'),
(17, 1, 'orientacion', 3, '2026-05-09 15:19:37', 'Test: orientacion | Dificultad: ninguna | Tiempo: 0s | Puntuación: 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','paciente','familiar','cuidador') NOT NULL,
  `perfil_completado` tinyint(4) DEFAULT 0,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `email`, `password`, `rol`, `perfil_completado`, `fecha_registro`, `telefono`) VALUES
(1, 'GILBERTO', 'CARACHE', 'gilberto@gilberto.com', '$2y$10$Fdnksu2k5BnDNb1Svy48T.rzp7N/aBD5FyeFdqEeohQKgJt/1Y6Iu', 'paciente', 1, '2026-05-04 14:12:46', '603916599'),
(2, 'carolina', 'sanchez', 'carolina@carolina.com', '$2y$10$MUrIYbRn9q3H1QburvNa2OPX27s1KM1.SAt1liVhNVK/.EG8GG2C.', 'cuidador', 1, '2026-05-04 14:17:11', NULL),
(3, 'Administrador', 'Admin', 'admin@admin.com', '$2y$10$MUrIYbRn9q3H1QburvNa2OPX27s1KM1.SAt1liVhNVK/.EG8GG2C.', 'admin', 0, '2026-05-08 14:22:09', NULL),
(4, 'adriana', 'almeida', 'adriana@adriana.com', '$2y$10$RAEuZ0IeyLL5B3CpbTvqK.dJ3YlBwUDRY3yt6nFhLKi5WhWgKXvQW', 'paciente', 1, '2026-05-09 15:29:59', '666777888');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `foro_respuestas`
--
ALTER TABLE `foro_respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tema_id` (`tema_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `foro_temas`
--
ALTER TABLE `foro_temas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notificacion_usuario` (`usuario_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_paciente_usuario` (`user_id`);

--
-- Indices de la tabla `profesionales`
--
ALTER TABLE `profesionales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `relaciones_familiares`
--
ALTER TABLE `relaciones_familiares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `familiar_id` (`familiar_id`);

--
-- Indices de la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `contenido`
--
ALTER TABLE `contenido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `foro_respuestas`
--
ALTER TABLE `foro_respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `foro_temas`
--
ALTER TABLE `foro_temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profesionales`
--
ALTER TABLE `profesionales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `relaciones_familiares`
--
ALTER TABLE `relaciones_familiares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `foro_respuestas`
--
ALTER TABLE `foro_respuestas`
  ADD CONSTRAINT `foro_respuestas_ibfk_1` FOREIGN KEY (`tema_id`) REFERENCES `foro_temas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `foro_respuestas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `foro_temas`
--
ALTER TABLE `foro_temas`
  ADD CONSTRAINT `foro_temas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_notificacion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `fk_paciente_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `relaciones_familiares`
--
ALTER TABLE `relaciones_familiares`
  ADD CONSTRAINT `relaciones_familiares_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `relaciones_familiares_ibfk_2` FOREIGN KEY (`familiar_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resultados`
--
ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
