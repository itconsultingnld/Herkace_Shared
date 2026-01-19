-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-01-2026 a las 19:52:29
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4mb4 */;

--
-- Base de datos: `vhten3_herkace`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `access`
--

CREATE TABLE `access` (
  `id` int(11) UNSIGNED NOT NULL,
  `key` varchar(40) NOT NULL DEFAULT '',
  `all_access` tinyint(1) NOT NULL DEFAULT 0,
  `controller` varchar(50) NOT NULL DEFAULT '',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_clientes`
--

CREATE TABLE `admin_clientes` (
  `adminClienteID` int(11) NOT NULL,
  `nombreAdminCliente` varchar(100) NOT NULL,
  `apellidoPatAdmin` varchar(100) NOT NULL,
  `apellidoMatAdmin` varchar(100) NOT NULL,
  `empresaAdmin` varchar(100) NOT NULL,
  `puestoAdmin` varchar(100) NOT NULL,
  `numTelAdmin` varchar(10) NOT NULL,
  `correoAdmin` varchar(50) NOT NULL,
  `claveAccesoAdmin` varchar(100) NOT NULL,
  `idrol` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `cliente_id` int(11) NOT NULL,
  `tipo_cliente` varchar(10) NOT NULL,
  `numero_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `curp` varchar(20) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `colonia` varchar(100) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `regimen_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes_facturacion`
--

CREATE TABLE `clientes_facturacion` (
  `cliente_facturacion_id` int(11) NOT NULL,
  `numero_cliente` int(11) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `tipo_persona` varchar(5) NOT NULL DEFAULT '',
  `rfc` varchar(15) NOT NULL,
  `curp` varchar(20) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `numero_ext` varchar(300) NOT NULL,
  `numero_int` varchar(300) NOT NULL,
  `colonia` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL DEFAULT '',
  `municipio` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `pais` varchar(100) NOT NULL DEFAULT '',
  `correo1` varchar(50) NOT NULL DEFAULT '',
  `correo2` varchar(50) NOT NULL DEFAULT '',
  `correo3` varchar(50) NOT NULL DEFAULT '',
  `correo4` varchar(50) NOT NULL DEFAULT '',
  `correo5` varchar(50) NOT NULL DEFAULT '',
  `regimen_id` int(11) NOT NULL,
  `uso_cfdi` varchar(5) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `configuracion_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo_verificacion_id` int(11) NOT NULL,
  `valor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`configuracion_id`, `nombre`, `tipo_verificacion_id`, `valor`) VALUES
(1, 'No. DE APROBACIÓN', 2, 'UV/SCT/CFM/18/421'),
(2, 'No. DE ACREDITACIÓN', 2, 'UVSCAT 421'),
(3, 'No. DE APROBACIÓN', 4, 'UV/SCT/EC/18/289'),
(4, 'No. DE ACREDITACIÓN', 4, 'UVSCAT 289');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `estatus_id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`estatus_id`, `nombre`) VALUES
(1, 'EN PROCESO'),
(2, 'APROBADO'),
(3, 'RECHAZADO'),
(4, 'CANCELADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folios`
--

CREATE TABLE `folios` (
  `folio_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_verificacion_id` int(11) NOT NULL,
  `prefijo` varchar(1) NOT NULL,
  `num_folio` bigint(20) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas_vehiculos`
--

CREATE TABLE `marcas_vehiculos` (
  `marca_vehiculo_id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `activo` tinyint(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `marcas_vehiculos`
--

INSERT INTO `marcas_vehiculos` (`marca_vehiculo_id`, `nombre`, `activo`) VALUES
(1, 'DODGE', 1),
(2, 'DORSEY', 1),
(3, 'FORD', 1),
(4, 'FORZA', 1),
(5, 'FOUNTAINE', 1),
(6, 'FREIGHTLINER', 1),
(7, 'GMC', 1),
(8, 'GREAT', 1),
(9, 'GREAT DANE', 1),
(10, 'HYUNDAI', 1),
(11, 'INLAND', 1),
(12, 'INSENSE', 1),
(13, 'INTERNATIONAL', 1),
(14, 'KENWORTH', 1),
(15, 'MACK', 1),
(16, 'MANAC', 1),
(17, 'NISSAN', 1),
(18, 'PETERBILT', 1),
(19, 'PINE', 1),
(20, 'STERLING', 1),
(21, 'STOUGHTON', 1),
(22, 'TRAILMOBILE', 1),
(23, 'TRANSCRAFT', 1),
(24, 'UTILITY', 1),
(25, 'VANGUARD', 1),
(26, 'VOLVO', 1),
(27, 'WABASH', 1),
(28, 'WABASH NATIONAL', 1),
(29, 'WHGM', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `orden_id` int(11) UNSIGNED NOT NULL,
  `num_orden` int(30) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `condiciones` varchar(300) NOT NULL,
  `usuario_id_vendedor` int(11) NOT NULL,
  `cerrada` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_servicios`
--

CREATE TABLE `ordenes_servicios` (
  `orden_servicio_id` bigint(20) UNSIGNED NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `tipo_unidad_verificacion_id` int(11) NOT NULL,
  `ec` tinyint(1) NOT NULL,
  `fm` tinyint(1) NOT NULL,
  `precio_id_ec` int(11) NOT NULL,
  `precio_id_fm` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `verif_creada` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios`
--

CREATE TABLE `precios` (
  `precio_id` int(11) NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prefacturas`
--

CREATE TABLE `prefacturas` (
  `prefactura_id` int(11) NOT NULL,
  `num_prefactura` varchar(20) NOT NULL,
  `facturada` tinyint(1) NOT NULL DEFAULT 0,
  `cliente_facturacion_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `condiciones` varchar(300) NOT NULL,
  `usuario_id_vendedor` int(11) NOT NULL,
  `razones_cancelacion` varchar(300) NOT NULL,
  `uid` varchar(20) NOT NULL,
  `num_factura` varchar(20) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regimenes`
--

CREATE TABLE `regimenes` (
  `regimen_id` int(11) NOT NULL,
  `regimen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `regimenes`
--

INSERT INTO `regimenes` (`regimen_id`, `regimen`) VALUES
(1, '601 - GENERAL DE LEY PERSONAS MORALES'),
(2, '603 - PERSONAS MORALES CON FINES NO LUCRATIVOS'),
(3, '605 - SUELDOS Y SALARIOS E INGRESOS ASIMILADOS A SALARIOS'),
(4, '606 - ARRENDAMIENTO'),
(5, '607 - RÉGIMEN DE ENAJENACIÓN O ADQUISICIÓN DE BIENES'),
(6, '608 - DEMÁS INGRESOS'),
(7, '609 - CONSOLIDACIÓN'),
(8, '610 - RESIDENTES EN EL EXTRANJERO SIN ESTABLECIMIENTO PERMANENTE EN MÉXICO'),
(9, '611 - INGRESOS POR DIVIDENDOS (\'SOCIOS Y ACCIONISTAS\')'),
(10, '612 - PERSONAS FÍSICAS CON ACTIVIDADES EMPRESARIALES Y PROFESIONALES'),
(11, '614 - INGRESOS POR INTERESES'),
(12, '615 - RÉGIMEN DE LOS INGRESOS POR OBTENCIÓN DE PREMIOS'),
(13, '616 - SIN OBLIGACIONES FISCALES'),
(14, '620 - SOCIEDADES COOPERATIVAS DE PRODUCCIÓN QUE OPTAN POR DIFERIR SUS INGRESOS'),
(15, '621 - INCORPORACIÓN FISCAL'),
(16, '622 - ACTIVIDADES AGRÍCOLAS, GANADERAS, SILVÍCOLAS Y PESQUERAS'),
(17, '623 - OPCIONAL PARA GRUPOS DE SOCIEDADES'),
(18, '624 - COORDINADOS'),
(19, '625 - RÉGIMEN DE LAS ACTIVIDADES EMPRESARIALES CON INGRESOS A TRAVÉS DE PLATAFORMAS TECNOLÓGICAS'),
(20, '626 - RÉGIMEN SIMPLIFICADO DE CONFIANZA'),
(21, '628 - HIDROCARBUROS'),
(22, '629 - DE LOS REGÍMENES FISCALES PREFERENTES Y DE LAS EMPRESAS MULTINACIONALES'),
(23, '630 - ENAJENACIÓN DE ACCIONES EN BOLSA DE VALORES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rol_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol_id`, `nombre`, `activo`) VALUES
(1, 'ADMINISTRADOR', 1),
(2, 'COORDINADOR', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `servicio_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`servicio_id`, `nombre`) VALUES
(1, 'Verificación Físico - Mecánica Motorizado'),
(2, 'Verificación Emisiones Contaminantes'),
(3, 'Verificación Físico - Mecánica Arrastre'),
(4, 'Verificaciones a Tractor para ALTA (FM)'),
(5, 'Verificación a Arrastre para ALTA'),
(6, 'Verificaciones a Tractor para ALTA (EC)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicos`
--

CREATE TABLE `tecnicos` (
  `tecnico_id` int(11) NOT NULL,
  `num_control` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ape_pat` varchar(100) NOT NULL,
  `ape_mat` varchar(100) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_servicios`
--

CREATE TABLE `tipos_servicios` (
  `tipo_servicio_id` int(11) NOT NULL,
  `nomenclatura` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `tipos_servicios`
--

INSERT INTO `tipos_servicios` (`tipo_servicio_id`, `nomenclatura`, `nombre`, `activo`) VALUES
(1, 'CG', 'CARGA GENERAL', 1),
(2, 'MP', 'CARGA ESPECIALIZADA (MATERIALES PELIGROSOS)', 1),
(3, 'M', 'CARGA ESPECIALIZADA (AUTOMOVIL SI RODAR)', 1),
(4, 'FV', 'CARGA ESPECIALIZADA (FONDOS Y VALORES)', 1),
(5, 'P', 'PASAJE', 1),
(6, 'T', 'TURISMO', 1),
(7, 'G', 'GRÚAS DE ARRASTRE Y/O SALVAMENTO', 1),
(8, 'PQ', 'PAQUETERIA Y MENSAJERIA', 1),
(9, '', 'PRIVADO', 1),
(10, '', 'EXCURSION', 1),
(11, '', 'OBJETOS VOLUMINOSOS Y/O GRAN PESO', 1),
(12, '', 'CHOFER GUIA', 1),
(13, '', 'CARGA ESPECIALIZADA', 1),
(14, '', 'PUERTOS Y AEROPUERTOS', 1),
(15, '', 'PUERTOS', 1),
(16, '', 'MATERIALES RES REMANENTES Y DESEC', 1),
(17, '', 'PERSONAS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_unidades`
--

CREATE TABLE `tipos_unidades` (
  `tipo_unidad_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `tipos_unidades`
--

INSERT INTO `tipos_unidades` (`tipo_unidad_id`, `nombre`, `activo`) VALUES
(1, 'CAJA REFRIGERADA', 1),
(2, 'CAJA CERRADA', 1),
(3, 'CAJA SECA', 1),
(4, 'PLATAFORMA', 1),
(5, 'TOLVA', 1),
(6, 'PIPA', 1),
(7, 'TANQUE', 1),
(8, 'CABALLETE', 1),
(9, 'LOWBOY', 1),
(10, 'CAMA B CUELLO G', 1),
(11, 'DOLLY', 1),
(12, 'VOLTEO', 1),
(13, 'PORTACONTENEDOR', 1),
(14, 'ESTACAS', 1),
(15, 'JAULAS', 1),
(16, 'CAMIONES MOTORIZADOS', 1),
(17, 'CAJA ABIERTA', 1),
(18, 'CAJA CERRADA', 1),
(19, 'TIPO GRÚA', 1),
(20, 'CAMION', 1),
(21, 'AUTOMOVIL', 1),
(22, 'AUTOBUS', 1),
(23, 'TRACTOR', 1),
(24, 'TIPO CAJA', 1),
(25, 'PLATAFORMA', 1),
(26, 'ORQUESTA', 1),
(27, 'ESTACAS FIJAS', 1),
(28, 'ESTACAS', 1),
(29, 'ESTACAS O PLATAFORMA', 1),
(30, 'TIPO QUINTA', 1),
(31, 'VAN', 1),
(32, 'VOLTEO', 1),
(33, 'REDILLAS', 1),
(34, 'PIPA', 1),
(35, 'CAMIONETA 3 1/2 ESTACAS', 1),
(36, 'CAMIONETA 3 1/2 PLATAFORMAS', 1),
(37, 'CAMIONETA 3 1/2 CAJA CERRADA', 1),
(38, 'VAGONETA', 1),
(39, 'ESTAQUITAS', 1),
(40, 'ROLL OFF', 1),
(41, 'ROLL', 1),
(42, 'ROLL', 1),
(43, 'EQUIPO ESPECIALIZADO', 1),
(44, 'CAMION CARGA TRASERA', 1),
(45, 'CAMIONETA PIPA', 1),
(46, 'CAMION PORTACONTENEDOR', 1),
(47, 'CAMION PIPA', 1),
(48, 'CAMION TANQUE', 1),
(49, 'MATERIALES PELIGROSOS', 1),
(50, 'PICK UP', 1),
(51, 'PETROLIZADORA', 1),
(52, 'MINIBUS O MICROBUS', 1),
(53, 'GRÚA PLATAFORMA', 1),
(54, 'GRÚA TIPO B', 1),
(55, 'PERFORADORA', 1),
(56, 'MINI VAN', 1),
(57, 'REDILAS', 1),
(58, 'PL', 1),
(59, 'PLATAFORMA PORTA ROLLOS', 1),
(60, 'GRÚA TIPO C', 1),
(61, 'GRÚA TIPO A', 1),
(62, 'GRÚA TIPO D', 1),
(63, 'C-2 REVOLVEDORA', 1),
(64, 'REVOLVEDORA', 1),
(65, 'PANEL', 1),
(66, 'PLATAFORMA ENCORTINADO', 1),
(67, 'FON. Y VALORES', 1),
(68, 'PLATAFORMA TIPO CORTINA GRÚA', 1),
(69, 'PLATAFORMA GRÚA', 1),
(70, 'TOLVA CAJA ABIERTA', 1),
(71, 'UNIDAD DE INYECCION', 1),
(72, 'JAULA GANADERA', 1),
(73, 'GRÚA BRAZO RIGIDO', 1),
(74, 'CAJA CORTINA', 1),
(75, 'PLATAFORMA TUBULAR', 1),
(76, 'CAMA BAJA', 1),
(77, 'GONDOLA MADRINA', 1),
(78, 'GRÚA TIPO TITAN', 1),
(79, 'CAMIONETA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_unidades_verificaciones`
--

CREATE TABLE `tipos_unidades_verificaciones` (
  `tipo_unidad_verificacion_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `tipos_unidades_verificaciones`
--

INSERT INTO `tipos_unidades_verificaciones` (`tipo_unidad_verificacion_id`, `nombre`, `activo`) VALUES
(1, 'CAMION', 1),
(2, 'REMOLQUE', 1),
(3, 'TRACTOR', 1),
(4, 'CAJA SECA', 1),
(5, 'TANQUE', 1),
(6, 'PLATAFORMA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_vehiculos`
--

CREATE TABLE `tipos_vehiculos` (
  `tipo_vehiculo_id` int(11) NOT NULL,
  `nomenclatura` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `tipos_vehiculos`
--

INSERT INTO `tipos_vehiculos` (`tipo_vehiculo_id`, `nomenclatura`, `nombre`, `activo`) VALUES
(1, 'B 2', 'AUTOBUS DE DOS EJES', 1),
(2, 'B 3', 'AUTOBUS DE TRES EJES', 1),
(3, 'B 4', 'AUTOBUS DE TRES EJES', 1),
(4, 'C 2', 'CAMION DE DOS EJES', 1),
(5, 'C 3', 'CAMION DE TRES EJES', 1),
(6, 'C 4', 'CAMION DE CUATRO EJES', 1),
(7, 'T 2', 'TRACTOCAMION DE DOS EJES', 1),
(8, 'T 3', 'TRACTOCAMION DE TRES EJES', 1),
(9, 'S 1', 'SEMIRREMOLQUE DE UN EJE', 1),
(10, 'S 2', 'SEMIRREMOLQUE DE DOS EJES', 1),
(11, 'S 3', 'SEMIRREMOLQUE DE TRES EJES', 1),
(12, 'S 4', 'SEMIRREMOLQUE DE CUATRO EJES', 1),
(13, 'S 5', 'SEMIRREMOLQUE DE CINCO EJES', 1),
(14, 'S 6', 'SEMIRREMOLQUE DE SEIS EJES', 1),
(15, 'D 1', 'DOLLY DE UN EJE', 1),
(16, 'D 2', 'DOLLY DE DOS EJES', 1),
(17, 'G A', 'GRÚA TIPO A', 1),
(18, 'G B', 'GRÚA TIPO B', 1),
(19, 'G C', 'GRÚA TIPO C', 1),
(20, 'G D', 'GRÚA TIPO D', 1),
(21, 'G I', 'GRÚA INDUSTRIAL', 1),
(22, 'VAGONETA', 'VAGONETA', 1),
(23, 'AUTOMOVIL', 'AUTOMOVIL', 1),
(24, 'MIDIBUS', 'MIDIBUS', 1),
(25, 'CAMIONETA', 'CAMIONETA', 1),
(26, 'CAMIONETA', 'CAMIONETA', 1),
(27, 'C 2', 'CAMIONETA PICK UP', 1),
(28, 'C 2', 'CAMIONETA ESTAQUITAS', 1),
(29, 'C 3', 'ROLL OFF', 1),
(30, 'C 2', 'CAMION TANQUE', 1),
(31, 'C 3', 'CARGA TRASERA', 1),
(32, '', 'GRUA PLATAFORMA', 1),
(33, 'C 2', 'CAMION DE DOS EJES TIPO QUINTA RUEDA', 1),
(34, '', 'MINI VAN', 1),
(35, '', 'PLATAFORMA PORTA ROLLOS', 1),
(36, '', 'GI GRÚA INDUSTRIAL C-2', 1),
(37, '', 'REVOLVEDORA', 1),
(38, '', 'C-2 REVOLVEDORA', 1),
(39, '', 'ESTACAS PLATAFORMA C-2', 1),
(40, '', 'ESTACAS PLATAFORMA C-3', 1),
(41, '', 'CAJA CERRADA C-2', 1),
(42, '', 'CAJA CERRADA C-3', 1),
(43, '', 'PLATAFORMA ENCORTINADO', 1),
(44, '', 'PLATAFORMA CON GRÚA', 1),
(45, 'T 4', 'TRACTOCAMION DE CUATRO EJES', 1),
(46, '', 'TOLVA CAJA ABIERTA', 1),
(47, '', 'CAMION GRÚA +CAJA ABIERTA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_verificaciones`
--

CREATE TABLE `tipos_verificaciones` (
  `tipo_verificacion_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `tipos_verificaciones`
--

INSERT INTO `tipos_verificaciones` (`tipo_verificacion_id`, `nombre`) VALUES
(1, 'CONTAMINANTES'),
(2, 'FISICO-MECANICO'),
(3, 'DIESEL GASOLINA'),
(4, 'NOM-EM-167'),
(5, 'GASOLINA DINAMOMETRO'),
(6, 'NOM-053-SCT-2-2010'),
(7, 'NOM-012-SCT-2-2017');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ape_pat` varchar(100) NOT NULL,
  `ape_mat` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_insp`
--

CREATE TABLE `usuarios_insp` (
  `usuarioInspID` int(11) NOT NULL,
  `nombreUsuarioInsp` varchar(100) NOT NULL,
  `apePatUsInsp` varchar(100) NOT NULL,
  `apeMatUsInsp` varchar(100) NOT NULL,
  `empresaUsuarioInsp` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `claveAccesoUsInsp` varchar(100) NOT NULL,
  `consecFolio` int(11) NOT NULL DEFAULT 1,
  `tipo` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_notif`
--

CREATE TABLE `usuarios_notif` (
  `usuarioNotifID` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apePat` varchar(50) NOT NULL,
  `apeMat` varchar(50) NOT NULL,
  `empresa` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `claveAcceso` varchar(100) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `vehiculo_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `marca_vehiculo_id` int(11) NOT NULL,
  `tipo_vehiculo_id` int(11) NOT NULL,
  `tipo_unidad_id` int(11) NOT NULL,
  `tipo_servicio_id` int(11) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `num_serie` varchar(50) NOT NULL,
  `num_placas` varchar(20) NOT NULL,
  `tarjeta_circ` varchar(50) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `capacidad_unidad` varchar(50) NOT NULL,
  `anio` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verificaciones`
--

CREATE TABLE `verificaciones` (
  `verificacion_id` int(11) UNSIGNED NOT NULL,
  `tipo_verificacion_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `tipo_unidad_verificacion_id` int(11) NOT NULL,
  `folio` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `folio_ant` varchar(30) NOT NULL,
  `fecha_ant` date NOT NULL,
  `estatus_id` int(11) NOT NULL,
  `estatus_unidad` tinyint(1) NOT NULL,
  `tecnico_id` int(11) NOT NULL,
  `kilometraje` varchar(20) NOT NULL,
  `periodo` tinyint(1) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_final` time NOT NULL,
  `imprime_nom` tinyint(1) NOT NULL,
  `precio_id` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `viene_orden_servicio` int(11) NOT NULL DEFAULT 0,
  `prefactura_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_clientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_clientes` (
`cliente_id` int(11)
,`tipo_cliente` varchar(10)
,`numero_cliente` int(11)
,`nombre` varchar(100)
,`rfc` varchar(15)
,`curp` varchar(20)
,`calle` varchar(100)
,`numero` varchar(20)
,`colonia` varchar(100)
,`municipio` varchar(100)
,`estado` varchar(100)
,`codigo_postal` varchar(10)
,`correo` varchar(50)
,`regimen` varchar(100)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_clientes_facturacion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_clientes_facturacion` (
`cliente_facturacion_id` int(11)
,`numero_cliente` int(11)
,`uid` varchar(20)
,`tipo_persona` varchar(6)
,`razon_social` varchar(100)
,`rfc` varchar(15)
,`curp` varchar(20)
,`calle` varchar(100)
,`numero_ext` varchar(300)
,`numero_int` varchar(300)
,`colonia` varchar(100)
,`localidad` varchar(100)
,`municipio` varchar(100)
,`estado` varchar(100)
,`codigo_postal` varchar(10)
,`pais` varchar(100)
,`correo1` varchar(50)
,`correo2` varchar(50)
,`correo3` varchar(50)
,`correo4` varchar(50)
,`correo5` varchar(50)
,`regimen` varchar(100)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_configuracion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_configuracion` (
`configuracion_id` int(11)
,`nombre` varchar(50)
,`valor` varchar(100)
,`tipo_verificacion` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_dashboard`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_dashboard` (
`Datos` varchar(19)
,`Cantidad` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_folios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_folios` (
`folio_id` bigint(20) unsigned
,`tipo_verificacion` varchar(50)
,`folio` varchar(21)
,`usuario` varchar(302)
,`fecha_hora` varchar(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_numero_ordenes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_numero_ordenes` (
`num_orden` int(30)
,`cliente` varchar(100)
,`servicio_id` int(11)
,`total` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_numero_servicios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_numero_servicios` (
`num_orden` int(30)
,`nombre_cliente` varchar(100)
,`servicio_id` int(11)
,`Total` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_ordenes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_ordenes` (
`cliente_id` int(11)
,`nombre` varchar(100)
,`orden_id` int(11) unsigned
,`num_orden` int(30)
,`fecha` date
,`hora` time
,`condiciones` varchar(300)
,`usuario_id_vendedor` int(11)
,`vendedor` varchar(302)
,`cerrada` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_ordenes_servicios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_ordenes_servicios` (
`nombre_cliente` varchar(100)
,`nombre_tipo_unidad_verif` varchar(50)
,`num_serie` varchar(50)
,`num_placas` varchar(20)
,`tarjeta_circ` varchar(50)
,`nombre_servicio_ec` varchar(100)
,`nombre_servicio_fm` varchar(100)
,`num_orden` int(30)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_prefacturas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_prefacturas` (
`cliente_facturacion_id` int(11)
,`nombre` varchar(100)
,`prefactura_id` int(11)
,`num_prefactura` varchar(20)
,`num_factura` varchar(20)
,`fecha` date
,`hora` time
,`condiciones` varchar(300)
,`usuario_id_vendedor` int(11)
,`vendedor` varchar(302)
,`facturada` tinyint(1)
,`uso_cfdi` varchar(5)
,`uid` varchar(20)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_reporte_anual`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_reporte_anual` (
`verificacion_id` int(11) unsigned
,`num_unidad_verificadora` varchar(100)
,`tipo_verificacion` varchar(50)
,`cliente` varchar(100)
,`rfc` varchar(15)
,`orden_id` int(11)
,`orden` varchar(30)
,`vehiculo_id` int(11)
,`num_serie` varchar(50)
,`num_placas` varchar(20)
,`folio_limpio` varchar(30)
,`folio` varchar(30)
,`fecha` date
,`fecha_ant` date
,`estatus` varchar(1)
,`estatus_unidad` varchar(1)
,`tecnico` varchar(302)
,`kilometraje` varchar(20)
,`hora_inicio` time
,`hora_final` time
,`tipo_unidad_verificacion_id` int(11)
,`marca` varchar(30)
,`tipo_vehiculo` varchar(20)
,`tipo_servicio` varchar(20)
,`tarjeta_circ` varchar(50)
,`peso` varchar(11)
,`litros` varchar(11)
,`pasajeros` varchar(11)
,`anio` int(11)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_vehiculos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_vehiculos` (
`vehiculo_id` int(11)
,`cliente_id` int(11)
,`cliente` varchar(100)
,`marca_vehiculo` varchar(30)
,`tipo_vehiculo` varchar(50)
,`tipo_unidad` varchar(50)
,`tipo_servicio` varchar(50)
,`modelo` varchar(100)
,`num_serie` varchar(50)
,`anio` int(11)
,`num_placas` varchar(20)
,`tarjeta_circ` varchar(50)
,`capacidad` int(11)
,`capacidad_unidad` varchar(50)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_verificaciones`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_verificaciones` (
`verificacion_id` int(11) unsigned
,`tipo_verificacion` varchar(50)
,`cliente` varchar(100)
,`orden_id` int(11)
,`orden` varchar(30)
,`vehiculo_id` int(11)
,`num_serie` varchar(50)
,`num_placas` varchar(20)
,`tipo_unidad_verificacion` varchar(50)
,`folio` varchar(30)
,`fecha` date
,`folio_ant` varchar(30)
,`fecha_ant` date
,`estatus` varchar(50)
,`estatus_unidad` varchar(7)
,`tecnico` varchar(302)
,`kilometraje` varchar(20)
,`periodo` tinyint(1)
,`hora_inicio` time
,`hora_final` time
,`imprime_nom` tinyint(1)
,`marca` varchar(30)
,`modelo` varchar(100)
,`tarjeta_circ` varchar(50)
,`servicio_id` int(11)
,`servicio` varchar(100)
,`subservicio` varchar(100)
,`precio` decimal(10,2)
,`orden_cerrada` int(4)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_verificaciones_prefactura`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_verificaciones_prefactura` (
`verificacion_id` int(11) unsigned
,`tipo_verificacion` varchar(50)
,`cliente` varchar(100)
,`orden_id` int(11)
,`orden` varchar(30)
,`prefactura_id` int(11)
,`prefactura` varchar(20)
,`vehiculo_id` int(11)
,`num_serie` varchar(50)
,`num_placas` varchar(20)
,`tipo_unidad_verificacion` varchar(50)
,`folio` varchar(30)
,`fecha` date
,`folio_ant` varchar(30)
,`fecha_ant` date
,`estatus_id` int(11)
,`estatus` varchar(50)
,`estatus_unidad` varchar(7)
,`tecnico` varchar(302)
,`kilometraje` varchar(20)
,`periodo` tinyint(1)
,`hora_inicio` time
,`hora_final` time
,`imprime_nom` tinyint(1)
,`marca` varchar(30)
,`modelo` varchar(100)
,`tarjeta_circ` varchar(50)
,`servicio_id` int(11)
,`servicio` varchar(100)
,`subservicio` varchar(100)
,`precio` decimal(10,2)
,`orden_cerrada` int(4)
,`prefactura_facturada` int(4)
,`activo` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_clientes`
--
DROP TABLE IF EXISTS `vw_clientes`;

CREATE VIEW `vw_clientes`  AS SELECT `c`.`cliente_id` AS `cliente_id`, `c`.`tipo_cliente` AS `tipo_cliente`, `c`.`numero_cliente` AS `numero_cliente`, `c`.`nombre` AS `nombre`, `c`.`rfc` AS `rfc`, CASE WHEN `c`.`curp` = '' THEN '-' ELSE `c`.`curp` END AS `curp`, `c`.`calle` AS `calle`, `c`.`numero` AS `numero`, `c`.`colonia` AS `colonia`, `c`.`municipio` AS `municipio`, `c`.`estado` AS `estado`, `c`.`codigo_postal` AS `codigo_postal`, `c`.`correo` AS `correo`, ifnull(`r`.`regimen`,'-') AS `regimen`, `c`.`activo` AS `activo` FROM (`clientes` `c` left join `regimenes` `r` on(`c`.`regimen_id` = `r`.`regimen_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_clientes_facturacion`
--
DROP TABLE IF EXISTS `vw_clientes_facturacion`;

CREATE VIEW `vw_clientes_facturacion`  AS SELECT `c`.`cliente_facturacion_id` AS `cliente_facturacion_id`, `c`.`numero_cliente` AS `numero_cliente`, `c`.`uid` AS `uid`, CASE WHEN `c`.`tipo_persona` = 'F' THEN 'FÍSICA' WHEN `c`.`tipo_persona` = 'M' THEN 'MORAL' ELSE '-' END AS `tipo_persona`, `c`.`razon_social` AS `razon_social`, `c`.`rfc` AS `rfc`, CASE WHEN `c`.`curp` = '' THEN '-' ELSE `c`.`curp` END AS `curp`, `c`.`calle` AS `calle`, `c`.`numero_ext` AS `numero_ext`, `c`.`numero_int` AS `numero_int`, `c`.`colonia` AS `colonia`, `c`.`localidad` AS `localidad`, `c`.`municipio` AS `municipio`, `c`.`estado` AS `estado`, `c`.`codigo_postal` AS `codigo_postal`, `c`.`pais` AS `pais`, `c`.`correo1` AS `correo1`, `c`.`correo2` AS `correo2`, `c`.`correo3` AS `correo3`, `c`.`correo4` AS `correo4`, `c`.`correo5` AS `correo5`, ifnull(`r`.`regimen`,'-') AS `regimen`, `c`.`activo` AS `activo` FROM (`clientes_facturacion` `c` left join `regimenes` `r` on(`c`.`regimen_id` = `r`.`regimen_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_configuracion`
--
DROP TABLE IF EXISTS `vw_configuracion`;

CREATE VIEW `vw_configuracion`  AS SELECT `c`.`configuracion_id` AS `configuracion_id`, `c`.`nombre` AS `nombre`, `c`.`valor` AS `valor`, `tvf`.`nombre` AS `tipo_verificacion` FROM (`tipos_verificaciones` `tvf` join `configuracion` `c` on(`tvf`.`tipo_verificacion_id` = `c`.`tipo_verificacion_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_dashboard`
--
DROP TABLE IF EXISTS `vw_dashboard`;

CREATE VIEW `vw_dashboard`  AS SELECT 'DatosClientes' AS `Datos`, count(0) AS `Cantidad` FROM `clientes` WHERE `clientes`.`activo` = 1unionselect 'DatosVehiculos' AS `Datos`,count(0) AS `Cantidad` from `vehiculos` where `vehiculos`.`activo` = 1 union select 'DatosVerificaciones' AS `Datos`,count(0) AS `Cantidad` from `verificaciones`  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_folios`
--
DROP TABLE IF EXISTS `vw_folios`;

CREATE VIEW `vw_folios`  AS SELECT `f`.`folio_id` AS `folio_id`, `tv`.`nombre` AS `tipo_verificacion`, concat(`f`.`prefijo`,`f`.`num_folio`) AS `folio`, concat(`u`.`nombre`,' ',`u`.`ape_pat`,' ',`u`.`ape_mat`) AS `usuario`, concat(`f`.`fecha`,' ',`f`.`hora`) AS `fecha_hora` FROM ((`folios` `f` join `tipos_verificaciones` `tv` on(`f`.`tipo_verificacion_id` = `tv`.`tipo_verificacion_id`)) join `usuarios` `u` on(`f`.`usuario_id` = `u`.`usuario_id`)) WHERE `f`.`disponible` = 1 ORDER BY `f`.`prefijo` ASC, `f`.`num_folio` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_numero_ordenes`
--
DROP TABLE IF EXISTS `vw_numero_ordenes`;

CREATE VIEW `vw_numero_ordenes`  AS SELECT `o`.`num_orden` AS `num_orden`, ifnull(`c`.`nombre`,'') AS `cliente`, ifnull(`p`.`servicio_id`,0) AS `servicio_id`, count(0) AS `total` FROM (((`ordenes` `o` left join `clientes` `c` on(`o`.`cliente_id` = `c`.`cliente_id`)) left join `verificaciones` `v` on(`v`.`orden_id` = `o`.`orden_id`)) left join `precios` `p` on(`v`.`precio_id` = `p`.`precio_id`)) GROUP BY `o`.`num_orden`, `p`.`servicio_id` ORDER BY `o`.`num_orden` ASC, `p`.`servicio_id` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_numero_servicios`
--
DROP TABLE IF EXISTS `vw_numero_servicios`;

CREATE VIEW `vw_numero_servicios`  AS SELECT `r`.`num_orden` AS `num_orden`, `r`.`nombre_cliente` AS `nombre_cliente`, `r`.`servicio_id` AS `servicio_id`, count(0) AS `Total` FROM (select `o`.`num_orden` AS `num_orden`,`c`.`nombre` AS `nombre_cliente`,`p`.`servicio_id` AS `servicio_id` from (((((`ordenes` `o` join `ordenes_servicios` `os` on(`o`.`orden_id` = `os`.`orden_id`)) left join `precios` `p` on(`p`.`precio_id` = `os`.`precio_id_ec`)) join `servicios` `s` on(`s`.`servicio_id` = `p`.`servicio_id`)) join `vehiculos` `v` on(`v`.`vehiculo_id` = `os`.`vehiculo_id`)) join `clientes` `c` on(`c`.`cliente_id` = `v`.`cliente_id`)) union all select `o`.`num_orden` AS `num_orden`,`c`.`nombre` AS `nombre_cliente`,`p`.`servicio_id` AS `servicio_id` from (((((`ordenes` `o` join `ordenes_servicios` `os` on(`o`.`orden_id` = `os`.`orden_id`)) left join `precios` `p` on(`p`.`precio_id` = `os`.`precio_id_fm`)) join `servicios` `s` on(`s`.`servicio_id` = `p`.`servicio_id`)) join `vehiculos` `v` on(`v`.`vehiculo_id` = `os`.`vehiculo_id`)) join `clientes` `c` on(`c`.`cliente_id` = `v`.`cliente_id`))) AS `r` GROUP BY `r`.`servicio_id`, `r`.`num_orden`, `r`.`nombre_cliente` ORDER BY `r`.`num_orden` ASC, `r`.`nombre_cliente` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_ordenes`
--
DROP TABLE IF EXISTS `vw_ordenes`;

CREATE VIEW `vw_ordenes`  AS SELECT ifnull(`c`.`cliente_id`,0) AS `cliente_id`, ifnull(`c`.`nombre`,'') AS `nombre`, `o`.`orden_id` AS `orden_id`, `o`.`num_orden` AS `num_orden`, `o`.`fecha` AS `fecha`, `o`.`hora` AS `hora`, `o`.`condiciones` AS `condiciones`, `o`.`usuario_id_vendedor` AS `usuario_id_vendedor`, ifnull(concat(`u`.`nombre`,' ',`u`.`ape_pat`,' ',`u`.`ape_mat`),'') AS `vendedor`, `o`.`cerrada` AS `cerrada` FROM ((`ordenes` `o` left join `clientes` `c` on(`o`.`cliente_id` = `c`.`cliente_id`)) left join `usuarios` `u` on(`o`.`usuario_id_vendedor` = `u`.`usuario_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_ordenes_servicios`
--
DROP TABLE IF EXISTS `vw_ordenes_servicios`;

CREATE VIEW `vw_ordenes_servicios`  AS SELECT `c`.`nombre` AS `nombre_cliente`, `tuv`.`nombre` AS `nombre_tipo_unidad_verif`, `v`.`num_serie` AS `num_serie`, `v`.`num_placas` AS `num_placas`, `v`.`tarjeta_circ` AS `tarjeta_circ`, ifnull(`s_ec`.`nombre`,'-') AS `nombre_servicio_ec`, ifnull(`s_fm`.`nombre`,'-') AS `nombre_servicio_fm`, `o`.`num_orden` AS `num_orden`, `os`.`activo` AS `activo` FROM ((((((((`ordenes_servicios` `os` join `vehiculos` `v` on(`os`.`vehiculo_id` = `v`.`vehiculo_id`)) join `tipos_unidades_verificaciones` `tuv` on(`tuv`.`tipo_unidad_verificacion_id` = `os`.`tipo_unidad_verificacion_id`)) left join `precios` `p_ec` on(`p_ec`.`precio_id` = `os`.`precio_id_ec`)) left join `precios` `p_fm` on(`p_fm`.`precio_id` = `os`.`precio_id_fm`)) left join `servicios` `s_ec` on(`s_ec`.`servicio_id` = `p_ec`.`servicio_id`)) left join `servicios` `s_fm` on(`s_fm`.`servicio_id` = `p_fm`.`servicio_id`)) join `ordenes` `o` on(`o`.`orden_id` = `os`.`orden_id`)) join `clientes` `c` on(`c`.`cliente_id` = `v`.`cliente_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_prefacturas`
--
DROP TABLE IF EXISTS `vw_prefacturas`;

CREATE VIEW `vw_prefacturas`  AS SELECT `p`.`cliente_facturacion_id` AS `cliente_facturacion_id`, ifnull(`c`.`razon_social`,'') AS `nombre`, `p`.`prefactura_id` AS `prefactura_id`, `p`.`num_prefactura` AS `num_prefactura`, CASE WHEN `p`.`num_factura` = '' THEN '-' ELSE `p`.`num_factura` END AS `num_factura`, `p`.`fecha` AS `fecha`, `p`.`hora` AS `hora`, `p`.`condiciones` AS `condiciones`, `p`.`usuario_id_vendedor` AS `usuario_id_vendedor`, ifnull(concat(`u`.`nombre`,' ',`u`.`ape_pat`,' ',`u`.`ape_mat`),'') AS `vendedor`, `p`.`facturada` AS `facturada`, `c`.`uso_cfdi` AS `uso_cfdi`, `p`.`uid` AS `uid`, `p`.`activo` AS `activo` FROM ((`prefacturas` `p` left join `clientes_facturacion` `c` on(`p`.`cliente_facturacion_id` = `c`.`cliente_facturacion_id`)) left join `usuarios` `u` on(`p`.`usuario_id_vendedor` = `u`.`usuario_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_reporte_anual`
--
DROP TABLE IF EXISTS `vw_reporte_anual`;

CREATE VIEW `vw_reporte_anual`  AS SELECT `v`.`verificacion_id` AS `verificacion_id`, ifnull(`conf`.`valor`,'') AS `num_unidad_verificadora`, ifnull(`tv`.`nombre`,'') AS `tipo_verificacion`, ifnull(`c`.`nombre`,'') AS `cliente`, `c`.`rfc` AS `rfc`, `v`.`orden_id` AS `orden_id`, ifnull(`o`.`num_orden`,'') AS `orden`, `v`.`vehiculo_id` AS `vehiculo_id`, `vh`.`num_serie` AS `num_serie`, `vh`.`num_placas` AS `num_placas`, replace(replace(`v`.`folio`,'M',''),'A','') AS `folio_limpio`, `v`.`folio` AS `folio`, `v`.`fecha` AS `fecha`, `v`.`fecha_ant` AS `fecha_ant`, CASE WHEN `v`.`estatus_id` = 1 THEN 'P' WHEN `v`.`estatus_id` = 2 THEN 'A' WHEN `v`.`estatus_id` = 3 THEN 'R' WHEN `v`.`estatus_id` = 4 THEN 'C' ELSE '' END AS `estatus`, CASE WHEN `v`.`estatus_unidad` = 1 THEN 'C' ELSE 'V' END AS `estatus_unidad`, ifnull(concat(`t`.`nombre`,' ',`t`.`ape_pat`,' ',`t`.`ape_mat`),'') AS `tecnico`, `v`.`kilometraje` AS `kilometraje`, `v`.`hora_inicio` AS `hora_inicio`, `v`.`hora_final` AS `hora_final`, `v`.`tipo_unidad_verificacion_id` AS `tipo_unidad_verificacion_id`, `mvh`.`nombre` AS `marca`, `tvh`.`nomenclatura` AS `tipo_vehiculo`, `ts`.`nomenclatura` AS `tipo_servicio`, `vh`.`tarjeta_circ` AS `tarjeta_circ`, CASE WHEN `vh`.`capacidad_unidad` = 'K' THEN `vh`.`capacidad` ELSE '' END AS `peso`, CASE WHEN `vh`.`capacidad_unidad` = 'L' THEN `vh`.`capacidad` ELSE '' END AS `litros`, CASE WHEN `vh`.`capacidad_unidad` = 'P' THEN `vh`.`capacidad` ELSE '' END AS `pasajeros`, `vh`.`anio` AS `anio`, `v`.`activo` AS `activo` FROM ((((((((((`verificaciones` `v` left join `tipos_verificaciones` `tv` on(`v`.`tipo_verificacion_id` = `tv`.`tipo_verificacion_id`)) left join `configuracion` `conf` on(`tv`.`tipo_verificacion_id` = `conf`.`tipo_verificacion_id` and `conf`.`nombre` = 'No. DE APROBACIÓN')) left join `clientes` `c` on(`v`.`cliente_id` = `c`.`cliente_id`)) left join `ordenes` `o` on(`v`.`orden_id` = `o`.`orden_id`)) left join `vehiculos` `vh` on(`v`.`vehiculo_id` = `vh`.`vehiculo_id`)) join `marcas_vehiculos` `mvh` on(`vh`.`marca_vehiculo_id` = `mvh`.`marca_vehiculo_id`)) join `tipos_vehiculos` `tvh` on(`vh`.`tipo_vehiculo_id` = `tvh`.`tipo_vehiculo_id`)) join `tipos_servicios` `ts` on(`vh`.`tipo_servicio_id` = `ts`.`tipo_servicio_id`)) left join `estatus` `e` on(`v`.`estatus_id` = `e`.`estatus_id`)) left join `tecnicos` `t` on(`v`.`tecnico_id` = `t`.`tecnico_id`)) ORDER BY ifnull(`o`.`num_orden`,'') ASC, replace(replace(`v`.`folio`,'M',''),'A','') ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_vehiculos`
--
DROP TABLE IF EXISTS `vw_vehiculos`;

CREATE VIEW `vw_vehiculos`  AS SELECT `v`.`vehiculo_id` AS `vehiculo_id`, `c`.`cliente_id` AS `cliente_id`, `c`.`nombre` AS `cliente`, `mv`.`nombre` AS `marca_vehiculo`, `tv`.`nombre` AS `tipo_vehiculo`, `tu`.`nombre` AS `tipo_unidad`, `ts`.`nombre` AS `tipo_servicio`, `v`.`modelo` AS `modelo`, `v`.`num_serie` AS `num_serie`, `v`.`anio` AS `anio`, `v`.`num_placas` AS `num_placas`, `v`.`tarjeta_circ` AS `tarjeta_circ`, `v`.`capacidad` AS `capacidad`, `v`.`capacidad_unidad` AS `capacidad_unidad`, `v`.`activo` AS `activo` FROM (((((`vehiculos` `v` join `clientes` `c` on(`v`.`cliente_id` = `c`.`cliente_id`)) join `marcas_vehiculos` `mv` on(`v`.`marca_vehiculo_id` = `mv`.`marca_vehiculo_id`)) join `tipos_vehiculos` `tv` on(`v`.`tipo_vehiculo_id` = `tv`.`tipo_vehiculo_id`)) join `tipos_unidades` `tu` on(`v`.`tipo_unidad_id` = `tu`.`tipo_unidad_id`)) join `tipos_servicios` `ts` on(`v`.`tipo_servicio_id` = `ts`.`tipo_servicio_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_verificaciones`
--
DROP TABLE IF EXISTS `vw_verificaciones`;

CREATE VIEW `vw_verificaciones`  AS SELECT `v`.`verificacion_id` AS `verificacion_id`, ifnull(`tv`.`nombre`,'-') AS `tipo_verificacion`, ifnull(`c`.`nombre`,'-') AS `cliente`, `v`.`orden_id` AS `orden_id`, ifnull(`o`.`num_orden`,'-') AS `orden`, `v`.`vehiculo_id` AS `vehiculo_id`, `vh`.`num_serie` AS `num_serie`, `vh`.`num_placas` AS `num_placas`, `tuv`.`nombre` AS `tipo_unidad_verificacion`, `v`.`folio` AS `folio`, `v`.`fecha` AS `fecha`, `v`.`folio_ant` AS `folio_ant`, `v`.`fecha_ant` AS `fecha_ant`, ifnull(`e`.`nombre`,'-') AS `estatus`, CASE WHEN `v`.`estatus_unidad` = 1 THEN 'CARGADO' ELSE 'VACÍO' END AS `estatus_unidad`, ifnull(concat(`t`.`nombre`,' ',`t`.`ape_pat`,' ',`t`.`ape_mat`),'-') AS `tecnico`, `v`.`kilometraje` AS `kilometraje`, `v`.`periodo` AS `periodo`, `v`.`hora_inicio` AS `hora_inicio`, `v`.`hora_final` AS `hora_final`, `v`.`imprime_nom` AS `imprime_nom`, `mvh`.`nombre` AS `marca`, `vh`.`modelo` AS `modelo`, `vh`.`tarjeta_circ` AS `tarjeta_circ`, ifnull(`s`.`servicio_id`,0) AS `servicio_id`, ifnull(`s`.`nombre`,'') AS `servicio`, ifnull(`p`.`nombre`,'') AS `subservicio`, ifnull(`p`.`precio`,0.00) AS `precio`, ifnull(`o`.`cerrada`,0) AS `orden_cerrada`, `v`.`activo` AS `activo` FROM ((((((((((`verificaciones` `v` left join `tipos_verificaciones` `tv` on(`v`.`tipo_verificacion_id` = `tv`.`tipo_verificacion_id`)) left join `clientes` `c` on(`v`.`cliente_id` = `c`.`cliente_id`)) left join `ordenes` `o` on(`v`.`orden_id` = `o`.`orden_id`)) left join `vehiculos` `vh` on(`v`.`vehiculo_id` = `vh`.`vehiculo_id`)) join `marcas_vehiculos` `mvh` on(`vh`.`marca_vehiculo_id` = `mvh`.`marca_vehiculo_id`)) join `tipos_unidades_verificaciones` `tuv` on(`v`.`tipo_unidad_verificacion_id` = `tuv`.`tipo_unidad_verificacion_id`)) left join `estatus` `e` on(`v`.`estatus_id` = `e`.`estatus_id`)) left join `tecnicos` `t` on(`v`.`tecnico_id` = `t`.`tecnico_id`)) left join `precios` `p` on(`v`.`precio_id` = `p`.`precio_id`)) left join `servicios` `s` on(`p`.`servicio_id` = `s`.`servicio_id`)) WHERE `v`.`activo` = 1 ORDER BY ifnull(`o`.`num_orden`,'-') ASC, `v`.`folio` ASC, `v`.`fecha` ASC ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_verificaciones_prefactura`
--
DROP TABLE IF EXISTS `vw_verificaciones_prefactura`;

CREATE VIEW `vw_verificaciones_prefactura`  AS SELECT `v`.`verificacion_id` AS `verificacion_id`, ifnull(`tv`.`nombre`,'-') AS `tipo_verificacion`, ifnull(`c`.`nombre`,'-') AS `cliente`, `v`.`orden_id` AS `orden_id`, ifnull(`o`.`num_orden`,'-') AS `orden`, `v`.`prefactura_id` AS `prefactura_id`, ifnull(`pf`.`num_prefactura`,'-') AS `prefactura`, `v`.`vehiculo_id` AS `vehiculo_id`, `vh`.`num_serie` AS `num_serie`, `vh`.`num_placas` AS `num_placas`, `tuv`.`nombre` AS `tipo_unidad_verificacion`, `v`.`folio` AS `folio`, `v`.`fecha` AS `fecha`, `v`.`folio_ant` AS `folio_ant`, `v`.`fecha_ant` AS `fecha_ant`, `v`.`estatus_id` AS `estatus_id`, ifnull(`e`.`nombre`,'-') AS `estatus`, CASE WHEN `v`.`estatus_unidad` = 1 THEN 'CARGADO' ELSE 'VACÍO' END AS `estatus_unidad`, ifnull(concat(`t`.`nombre`,' ',`t`.`ape_pat`,' ',`t`.`ape_mat`),'-') AS `tecnico`, `v`.`kilometraje` AS `kilometraje`, `v`.`periodo` AS `periodo`, `v`.`hora_inicio` AS `hora_inicio`, `v`.`hora_final` AS `hora_final`, `v`.`imprime_nom` AS `imprime_nom`, `mvh`.`nombre` AS `marca`, `vh`.`modelo` AS `modelo`, `vh`.`tarjeta_circ` AS `tarjeta_circ`, ifnull(`s`.`servicio_id`,0) AS `servicio_id`, ifnull(`s`.`nombre`,'') AS `servicio`, ifnull(`p`.`nombre`,'') AS `subservicio`, ifnull(`v`.`precio`,0.00) AS `precio`, ifnull(`o`.`cerrada`,0) AS `orden_cerrada`, ifnull(`pf`.`facturada`,0) AS `prefactura_facturada`, `v`.`activo` AS `activo` FROM (((((((((((`verificaciones` `v` left join `tipos_verificaciones` `tv` on(`v`.`tipo_verificacion_id` = `tv`.`tipo_verificacion_id`)) left join `clientes` `c` on(`v`.`cliente_id` = `c`.`cliente_id`)) left join `ordenes` `o` on(`v`.`orden_id` = `o`.`orden_id`)) left join `prefacturas` `pf` on(`v`.`prefactura_id` = `pf`.`prefactura_id`)) left join `vehiculos` `vh` on(`v`.`vehiculo_id` = `vh`.`vehiculo_id`)) join `marcas_vehiculos` `mvh` on(`vh`.`marca_vehiculo_id` = `mvh`.`marca_vehiculo_id`)) join `tipos_unidades_verificaciones` `tuv` on(`v`.`tipo_unidad_verificacion_id` = `tuv`.`tipo_unidad_verificacion_id`)) left join `estatus` `e` on(`v`.`estatus_id` = `e`.`estatus_id`)) left join `tecnicos` `t` on(`v`.`tecnico_id` = `t`.`tecnico_id`)) left join `precios` `p` on(`v`.`precio_id` = `p`.`precio_id`)) left join `servicios` `s` on(`p`.`servicio_id` = `s`.`servicio_id`)) WHERE `v`.`activo` = 1 ORDER BY ifnull(`pf`.`num_prefactura`,'-') ASC, ifnull(`o`.`num_orden`,'-') ASC, ifnull(`s`.`servicio_id`,0) ASC, ifnull(`p`.`nombre`,'') ASC, ifnull(`v`.`precio`,0.00) DESC, `v`.`folio` ASC, `v`.`fecha` ASC ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `admin_clientes`
--
ALTER TABLE `admin_clientes`
  ADD PRIMARY KEY (`adminClienteID`),
  ADD UNIQUE KEY `correoAdmin` (`correoAdmin`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`configuracion_id`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`estatus_id`);

--
-- Indices de la tabla `folios`
--
ALTER TABLE `folios`
  ADD PRIMARY KEY (`folio_id`);

--
-- Indices de la tabla `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas_vehiculos`
--
ALTER TABLE `marcas_vehiculos`
  ADD PRIMARY KEY (`marca_vehiculo_id`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`orden_id`);

--
-- Indices de la tabla `ordenes_servicios`
--
ALTER TABLE `ordenes_servicios`
  ADD PRIMARY KEY (`orden_servicio_id`);

--
-- Indices de la tabla `precios`
--
ALTER TABLE `precios`
  ADD PRIMARY KEY (`precio_id`);

--
-- Indices de la tabla `prefacturas`
--
ALTER TABLE `prefacturas`
  ADD PRIMARY KEY (`prefactura_id`);

--
-- Indices de la tabla `regimenes`
--
ALTER TABLE `regimenes`
  ADD PRIMARY KEY (`regimen_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`servicio_id`);

--
-- Indices de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  ADD PRIMARY KEY (`tecnico_id`);

--
-- Indices de la tabla `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  ADD PRIMARY KEY (`tipo_servicio_id`);

--
-- Indices de la tabla `tipos_unidades`
--
ALTER TABLE `tipos_unidades`
  ADD PRIMARY KEY (`tipo_unidad_id`);

--
-- Indices de la tabla `tipos_unidades_verificaciones`
--
ALTER TABLE `tipos_unidades_verificaciones`
  ADD PRIMARY KEY (`tipo_unidad_verificacion_id`);

--
-- Indices de la tabla `tipos_vehiculos`
--
ALTER TABLE `tipos_vehiculos`
  ADD PRIMARY KEY (`tipo_vehiculo_id`);

--
-- Indices de la tabla `tipos_verificaciones`
--
ALTER TABLE `tipos_verificaciones`
  ADD PRIMARY KEY (`tipo_verificacion_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`),
  ADD KEY `fk_id_rol_usuarios` (`rol_id`);

--
-- Indices de la tabla `usuarios_insp`
--
ALTER TABLE `usuarios_insp`
  ADD PRIMARY KEY (`usuarioInspID`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `usuarios_notif`
--
ALTER TABLE `usuarios_notif`
  ADD PRIMARY KEY (`usuarioNotifID`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`vehiculo_id`);

--
-- Indices de la tabla `verificaciones`
--
ALTER TABLE `verificaciones`
  ADD PRIMARY KEY (`verificacion_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `admin_clientes`
--
ALTER TABLE `admin_clientes`
  MODIFY `adminClienteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `configuracion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `estatus_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `folios`
--
ALTER TABLE `folios`
  MODIFY `folio_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcas_vehiculos`
--
ALTER TABLE `marcas_vehiculos`
  MODIFY `marca_vehiculo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `orden_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenes_servicios`
--
ALTER TABLE `ordenes_servicios`
  MODIFY `orden_servicio_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precios`
--
ALTER TABLE `precios`
  MODIFY `precio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prefacturas`
--
ALTER TABLE `prefacturas`
  MODIFY `prefactura_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regimenes`
--
ALTER TABLE `regimenes`
  MODIFY `regimen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `servicio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tecnicos`
--
ALTER TABLE `tecnicos`
  MODIFY `tecnico_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos_servicios`
--
ALTER TABLE `tipos_servicios`
  MODIFY `tipo_servicio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tipos_unidades`
--
ALTER TABLE `tipos_unidades`
  MODIFY `tipo_unidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `tipos_unidades_verificaciones`
--
ALTER TABLE `tipos_unidades_verificaciones`
  MODIFY `tipo_unidad_verificacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipos_vehiculos`
--
ALTER TABLE `tipos_vehiculos`
  MODIFY `tipo_vehiculo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `tipos_verificaciones`
--
ALTER TABLE `tipos_verificaciones`
  MODIFY `tipo_verificacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_insp`
--
ALTER TABLE `usuarios_insp`
  MODIFY `usuarioInspID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_notif`
--
ALTER TABLE `usuarios_notif`
  MODIFY `usuarioNotifID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `vehiculo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `verificaciones`
--
ALTER TABLE `verificaciones`
  MODIFY `verificacion_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_id_rol_usuarios` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
