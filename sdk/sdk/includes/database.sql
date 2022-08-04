-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 21, 2020 at 07:49 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdk`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(10) NOT NULL,
  `orden` int(2) NOT NULL DEFAULT '0',
  `titulo` varchar(300) DEFAULT NULL,
  `txt` text,
  `fecha` date DEFAULT NULL,
  `video` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `orden`, `titulo`, `txt`, `fecha`, `video`) VALUES
(6, 0, 'Hola mundo', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '2020-02-21', '');

-- --------------------------------------------------------

--
-- Table structure for table `blogpic`
--

CREATE TABLE `blogpic` (
  `id` int(10) NOT NULL,
  `item` int(10) NOT NULL,
  `titulo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` int(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogpic`
--

INSERT INTO `blogpic` (`id`, `item`, `titulo`, `url`, `orden`) VALUES
(8, 6, NULL, NULL, 99);

-- --------------------------------------------------------

--
-- Table structure for table `calendario`
--

CREATE TABLE `calendario` (
  `id` int(10) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` int(2) DEFAULT NULL,
  `txt` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `folder` int(1) NOT NULL DEFAULT '1',
  `txt1` text CHARACTER SET utf8 COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `calendario`
--

INSERT INTO `calendario` (`id`, `fecha`, `hora`, `txt`, `folder`, `txt1`) VALUES
(16, '2020-01-21', NULL, 'hi', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `calendariopic`
--

CREATE TABLE `calendariopic` (
  `id` int(10) NOT NULL,
  `producto` int(10) NOT NULL,
  `titulo` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `title` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `txt` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `orden` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(10) NOT NULL,
  `orden` int(2) DEFAULT NULL,
  `titulo` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `txt` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `url` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `video` varchar(100) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `orden`, `titulo`, `txt`, `url`, `video`) VALUES
(4, 99, NULL, NULL, NULL, NULL),
(5, 99, NULL, NULL, NULL, NULL),
(9, 99, NULL, NULL, NULL, 'https://www.youtube.com/watch?v=CV_FwOudYko');

-- --------------------------------------------------------

--
-- Table structure for table `carousel2`
--

CREATE TABLE `carousel2` (
  `id` int(10) NOT NULL,
  `orden` int(2) DEFAULT NULL,
  `titulo` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `txt` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `url` text CHARACTER SET latin1 COLLATE latin1_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(2) NOT NULL,
  `title` varchar(200) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `prodspag` int(5) DEFAULT NULL,
  `sliderhmin` int(5) DEFAULT '0',
  `sliderhmax` int(5) DEFAULT '1000',
  `sliderproporcion` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `slideranim` int(1) DEFAULT NULL,
  `slidertextos` int(1) DEFAULT NULL,
  `paypalemail` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `destinatario1` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `destinatario2` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `remitente` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `remitentepass` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `remitentehost` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `remitenteport` varchar(5) COLLATE latin1_spanish_ci DEFAULT NULL,
  `remitenteseguridad` varchar(10) COLLATE latin1_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `telefono1` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `facebook` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `instagram` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `youtube` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `envio` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `envioglobal` varchar(10) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `iva` int(2) DEFAULT NULL,
  `incremento` int(2) DEFAULT NULL,
  `bank` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `tyct1` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `tyct2` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `tyct3` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `tyct4` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `tyc1` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `tyc2` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `tyc3` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `tyc4` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `pdf1` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagen1` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagen2` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagen3` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `about1` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `about2` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `about3` text CHARACTER SET latin1 COLLATE latin1_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`id`, `title`, `description`, `prodspag`, `sliderhmin`, `sliderhmax`, `sliderproporcion`, `slideranim`, `slidertextos`, `paypalemail`, `destinatario1`, `destinatario2`, `remitente`, `remitentepass`, `remitentehost`, `remitenteport`, `remitenteseguridad`, `telefono`, `telefono1`, `facebook`, `instagram`, `youtube`, `envio`, `envioglobal`, `iva`, `incremento`, `bank`, `tyct1`, `tyct2`, `tyct3`, `tyct4`, `tyc1`, `tyc2`, `tyc3`, `tyc4`, `pdf1`, `imagen1`, `imagen2`, `imagen3`, `about1`, `about2`, `about3`) VALUES
(1, 'SDK', 'Software de desarrollo Wozial', 4, 100, 2000, '3:1', 2, 0, 'business@wozial.com', 'desarrollo@wozial.com', NULL, 'contacto@eshot.mx', 'LeGuaGua@ElPerrito', 'mail.eshot.mx', '465', 'SSL', '3323381792', '3323381792', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://pinterest.com.mx/', '100', '50', 16, 0, 'Bancomer', 'Aviso de privacidad', 'Métodos de pago', 'Devoluciones y envío', 'Términos y condiciones', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nulla ac libero viverra laoreet. Duis varius scelerisque nunc at feugiat. Sed viverra est non fringilla pellentesque. Sed dictum suscipit tristique. In ultricies neque vel aliquam pharetra. Aliquam magna dolor, accumsan a mi id, commodo consequat purus. Nullam lobortis erat a tempor blandit.</p>\r\n<p>Quisque semper turpis in erat cursus, id auctor nisi sollicitudin. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer at blandit lectus. Pellentesque aliquet velit sem, vitae mollis eros tempor vel. Duis id orci in nulla viverra dignissim at a sem. Mauris iaculis nisl nec enim rhoncus iaculis. Curabitur dapibus fringilla quam, sed blandit ipsum accumsan nec. Donec ac elit lobortis purus sagittis convallis quis et est. Praesent vitae sagittis felis, ac sagittis tortor. Cras tortor lectus, molestie consequat ipsum id, efficitur ullamcorper felis. Sed sapien ipsum, rutrum a odio id, gravida ultrices neque. Nullam finibus mi vel ante dignissim auctor.</p>\r\n<p>In nec diam in ipsum dictum auctor quis sit amet sapien. Mauris augue enim, volutpat a malesuada id, hendrerit vitae neque. Aliquam erat volutpat. Etiam ut finibus neque. Nulla et finibus felis. Etiam vestibulum orci id nisl iaculis sodales. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce fermentum rutrum mi non faucibus. Nulla molestie urna eu orci malesuada dictum. Integer eros dui, tempor ac ipsum a, consectetur facilisis sem. Proin placerat porttitor velit sed mattis. Suspendisse ut erat orci. In hac habitasse platea dictumst.</p>\r\n<p>Aenean cursus maximus odio, vel pharetra leo condimentum vel. In nec molestie massa. Suspendisse a tellus ultrices massa laoreet facilisis ac ultricies neque. Curabitur fringilla nunc sed interdum fermentum. Etiam egestas maximus arcu nec dictum. Integer ornare ligula ipsum, sit amet consequat justo euismod porta. Suspendisse a quam lorem. Donec ac ornare tortor. Suspendisse leo tortor, fringilla ut imperdiet ac, pulvinar nec eros. Etiam dignissim mauris sapien, vitae pulvinar nibh placerat dignissim. Pellentesque vitae vulputate nisl. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam elementum tempor lorem, blandit aliquam ipsum commodo id. Nam dictum iaculis neque, quis tempus tortor luctus sit amet.</p>\r\n<p>Suspendisse porta enim purus, sit amet accumsan ligula molestie quis. Cras rhoncus ultricies odio. Aliquam imperdiet dapibus aliquet. Curabitur et ullamcorper eros. Fusce ut massa sit amet dolor suscipit tincidunt. Phasellus at tincidunt massa. Praesent ac imperdiet est, ac laoreet libero. Ut in turpis velit. Morbi non diam dui.</p>', '<p>Quisque semper turpis in erat cursus, id auctor nisi sollicitudin. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer at blandit lectus. Pellentesque aliquet velit sem, vitae mollis eros tempor vel. Duis id orci in nulla viverra dignissim at a sem. Mauris iaculis nisl nec enim rhoncus iaculis. Curabitur dapibus fringilla quam, sed blandit ipsum accumsan nec. Donec ac elit lobortis purus sagittis convallis quis et est. Praesent vitae sagittis felis, ac sagittis tortor. Cras tortor lectus, molestie consequat ipsum id, efficitur ullamcorper felis. Sed sapien ipsum, rutrum a odio id, gravida ultrices neque. Nullam finibus mi vel ante dignissim auctor.</p>\r\n<p>In nec diam in ipsum dictum auctor quis sit amet sapien. Mauris augue enim, volutpat a malesuada id, hendrerit vitae neque. Aliquam erat volutpat. Etiam ut finibus neque. Nulla et finibus felis. Etiam vestibulum orci id nisl iaculis sodales. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce fermentum rutrum mi non faucibus. Nulla molestie urna eu orci malesuada dictum. Integer eros dui, tempor ac ipsum a, consectetur facilisis sem. Proin placerat porttitor velit sed mattis. Suspendisse ut erat orci. In hac habitasse platea dictumst.</p>\r\n<p>Aenean cursus maximus odio, vel pharetra leo condimentum vel. In nec molestie massa. Suspendisse a tellus ultrices massa laoreet facilisis ac ultricies neque. Curabitur fringilla nunc sed interdum fermentum. Etiam egestas maximus arcu nec dictum. Integer ornare ligula ipsum, sit amet consequat justo euismod porta. Suspendisse a quam lorem. Donec ac ornare tortor. Suspendisse leo tortor, fringilla ut imperdiet ac, pulvinar nec eros. Etiam dignissim mauris sapien, vitae pulvinar nibh placerat dignissim. Pellentesque vitae vulputate nisl. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam elementum tempor lorem, blandit aliquam ipsum commodo id. Nam dictum iaculis neque, quis tempus tortor luctus sit amet.</p>', '<p>Quisque semper turpis in erat cursus, id auctor nisi sollicitudin. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer at blandit lectus. Pellentesque aliquet velit sem, vitae mollis eros tempor vel. Duis id orci in nulla viverra dignissim at a sem. Mauris iaculis nisl nec enim rhoncus iaculis. Curabitur dapibus fringilla quam, sed blandit ipsum accumsan nec. Donec ac elit lobortis purus sagittis convallis quis et est. Praesent vitae sagittis felis, ac sagittis tortor. Cras tortor lectus, molestie consequat ipsum id, efficitur ullamcorper felis. Sed sapien ipsum, rutrum a odio id, gravida ultrices neque. Nullam finibus mi vel ante dignissim auctor.</p>\r\n<p>In nec diam in ipsum dictum auctor quis sit amet sapien. Mauris augue enim, volutpat a malesuada id, hendrerit vitae neque. Aliquam erat volutpat. Etiam ut finibus neque. Nulla et finibus felis. Etiam vestibulum orci id nisl iaculis sodales. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce fermentum rutrum mi non faucibus. Nulla molestie urna eu orci malesuada dictum. Integer eros dui, tempor ac ipsum a, consectetur facilisis sem. Proin placerat porttitor velit sed mattis. Suspendisse ut erat orci. In hac habitasse platea dictumst.</p>\r\n<p>Aenean cursus maximus odio, vel pharetra leo condimentum vel. In nec molestie massa. Suspendisse a tellus ultrices massa laoreet facilisis ac ultricies neque. Curabitur fringilla nunc sed interdum fermentum. Etiam egestas maximus arcu nec dictum. Integer ornare ligula ipsum, sit amet consequat justo euismod porta. Suspendisse a quam lorem. Donec ac ornare tortor. Suspendisse leo tortor, fringilla ut imperdiet ac, pulvinar nec eros. Etiam dignissim mauris sapien, vitae pulvinar nibh placerat dignissim. Pellentesque vitae vulputate nisl. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam elementum tempor lorem, blandit aliquam ipsum commodo id. Nam dictum iaculis neque, quis tempus tortor luctus sit amet.</p>\r\n<p>Suspendisse porta enim purus, sit amet accumsan ligula molestie quis. Cras rhoncus ultricies odio. Aliquam imperdiet dapibus aliquet. Curabitur et ullamcorper eros. Fusce ut massa sit amet dolor suscipit tincidunt. Phasellus at tincidunt massa. Praesent ac imperdiet est, ac laoreet libero. Ut in turpis velit. Morbi non diam dui.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin id nulla ac libero viverra laoreet. Duis varius scelerisque nunc at feugiat. Sed viverra est non fringilla pellentesque. Sed dictum suscipit tristique. In ultricies neque vel aliquam pharetra. Aliquam magna dolor, accumsan a mi id, commodo consequat purus. Nullam lobortis erat a tempor blandit.</p>\r\n<p>In nec diam in ipsum dictum auctor quis sit amet sapien. Mauris augue enim, volutpat a malesuada id, hendrerit vitae neque. Aliquam erat volutpat. Etiam ut finibus neque. Nulla et finibus felis. Etiam vestibulum orci id nisl iaculis sodales. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce fermentum rutrum mi non faucibus. Nulla molestie urna eu orci malesuada dictum. Integer eros dui, tempor ac ipsum a, consectetur facilisis sem. Proin placerat porttitor velit sed mattis. Suspendisse ut erat orci. In hac habitasse platea dictumst.</p>\r\n<p>Aenean cursus maximus odio, vel pharetra leo condimentum vel. In nec molestie massa. Suspendisse a tellus ultrices massa laoreet facilisis ac ultricies neque. Curabitur fringilla nunc sed interdum fermentum. Etiam egestas maximus arcu nec dictum. Integer ornare ligula ipsum, sit amet consequat justo euismod porta. Suspendisse a quam lorem. Donec ac ornare tortor. Suspendisse leo tortor, fringilla ut imperdiet ac, pulvinar nec eros. Etiam dignissim mauris sapien, vitae pulvinar nibh placerat dignissim. Pellentesque vitae vulputate nisl. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam elementum tempor lorem, blandit aliquam ipsum commodo id. Nam dictum iaculis neque, quis tempus tortor luctus sit amet.</p>', NULL, NULL, NULL, '808594938.jpg', '<p>Somos una una empresa mexicana de orgullo familiar fundada en 1997 por los hermanos S&aacute;nchez M&aacute;rquez. Con una gran iniciativa, los hermanos S&aacute;nchez, comenzaron con una peque&ntilde;a f&aacute;brica y una tienda ubicada en el coraz&oacute;n de la zona tur&iacute;stica de Tlaquepaque, Jalisco, M&eacute;xico.</p>\r\n<p>La Gama de productos era muy b&aacute;sica pero muy interesante, lo cual les ayudo a tener una muy buena acept&aacute;cion y el reconocimiento de los clientes Nacionales y Extranjeros.</p>\r\n<p>R&aacute;pidamente fueron aumentando su oferta de productos, lo cual los llev&oacute; a abrir m&aacute;s f&aacute;brica de producci&oacute;n y buscar la ampliaci&oacute;n de la que ser&iacute;a la primera tienda CASA PIEL.</p>', '<p>En nuestras tiendas contamos con una extensa variedad de art&iacute;culoes con un surtido en diferentes texturas, colores y modelos.</p>\r\n<p>Actualmente CASA PIEL ofrece m&aacute;s de 1,000 productos diferentes, siendo cada uno de trabajo artesanal y consideramos cada pieza &uacute;nica y especial, ya que las marcas de la piel hacen que cada pieza lleve un estampado, dise&ntilde;o y color irrepetible a&uacute;n cuendo el molde sea el mismo.</p>', '<p>Habremos logrado satisfacer el gusto delicado del mercado nacional y del extranjero, sinti&eacute;ndonos orgullosos de que el producto hecho en M&eacute;xico sea del agrado de pa&iacute;ses como Canad&aacute;, Estados Unidos y algunos pa&iacute;ses de Europa.</p>\r\n<p>Manejando la m&aacute;s alta calidad en cada uno de nuestros productos hechos con pieles seleccionadas especialmente para nuestos clientes.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `cupones`
--

CREATE TABLE `cupones` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `txt` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descuento` int(2) DEFAULT NULL,
  `vigencia` date DEFAULT NULL,
  `alta` date DEFAULT NULL,
  `usos` int(11) NOT NULL DEFAULT '0',
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cupones`
--

INSERT INTO `cupones` (`id`, `codigo`, `txt`, `descuento`, `vigencia`, `alta`, `usos`, `estatus`) VALUES
(2, 'EFRA', 'D&iacute;a del bicho', 10, '2020-10-26', '2020-05-20', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT '99',
  `estatus` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(5) NOT NULL,
  `orden` int(2) NOT NULL,
  `pregunta` text NOT NULL,
  `respuesta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `producto` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `galerias`
--

CREATE TABLE `galerias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `galerias`
--

INSERT INTO `galerias` (`id`, `titulo`, `orden`) VALUES
(1, 'Hola', 99);

-- --------------------------------------------------------

--
-- Table structure for table `galeriaspic`
--

CREATE TABLE `galeriaspic` (
  `id` int(11) NOT NULL,
  `producto` int(11) DEFAULT NULL,
  `alt` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ipn`
--

CREATE TABLE `ipn` (
  `id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(50) DEFAULT NULL,
  `txn_id` varchar(50) DEFAULT NULL,
  `pedido` int(10) DEFAULT NULL,
  `ipn` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) NOT NULL,
  `idmd5` varchar(50) DEFAULT NULL,
  `uid` int(10) NOT NULL DEFAULT '0',
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT '0',
  `cupon` varchar(30) DEFAULT NULL,
  `invisible` int(1) NOT NULL DEFAULT '0',
  `papelera` int(1) NOT NULL DEFAULT '0',
  `notify` int(1) NOT NULL DEFAULT '0',
  `guia` varchar(20) DEFAULT NULL,
  `linkguia` varchar(100) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `dom` int(11) NOT NULL DEFAULT '0',
  `factura` int(11) DEFAULT '0',
  `tabla` text,
  `cantidad` int(11) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `envio` decimal(15,2) DEFAULT NULL,
  `comprobante` varchar(50) DEFAULT NULL,
  `imagen` varchar(10) DEFAULT NULL,
  `ipn` varchar(50) DEFAULT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `noexterior` varchar(50) DEFAULT NULL,
  `nointerior` varchar(50) DEFAULT NULL,
  `entrecalles` varchar(200) DEFAULT NULL,
  `pais` varchar(20) DEFAULT 'Mexico',
  `estado` varchar(50) DEFAULT NULL,
  `municipio` varchar(50) DEFAULT NULL,
  `colonia` varchar(50) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pedidosdetalle`
--

CREATE TABLE `pedidosdetalle` (
  `id` int(11) NOT NULL,
  `pedido` int(11) DEFAULT NULL,
  `producto` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `productotxt` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(15,2) DEFAULT NULL,
  `importe` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(10) NOT NULL,
  `categoria` int(2) DEFAULT NULL,
  `clasif` int(2) DEFAULT NULL,
  `tipotalla` int(11) DEFAULT NULL,
  `marca` int(2) DEFAULT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `metadescription` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `precio` decimal(20,2) DEFAULT NULL,
  `descuento` int(2) NOT NULL DEFAULT '0',
  `titulo` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `sku` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `txt` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `material` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `inicio` int(1) NOT NULL DEFAULT '0',
  `estatus` int(1) NOT NULL DEFAULT '1',
  `fecha` date DEFAULT NULL,
  `orden` int(2) DEFAULT '99',
  `forro` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `herraje` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `categoria`, `clasif`, `tipotalla`, `marca`, `title`, `metadescription`, `precio`, `descuento`, `titulo`, `sku`, `txt`, `material`, `imagen`, `inicio`, `estatus`, `fecha`, `orden`, `forro`, `herraje`) VALUES
(1, 2, NULL, 2, 1, 'Testing', 'Probando el sitio', '1000.00', 0, 'Testing', 'WOZIAL001', '<p>Esta es una prueba</p>', 'Piel', NULL, 1, 1, '2020-01-12', 99, NULL, NULL),
(2, 2, NULL, 2, 1, 'Prueba 2', 'Probando la web', '1000.00', 0, 'Probando', 'WOZIAL002', '<p>Producto de prueba</p>', 'Piel', NULL, 1, 1, '2020-01-21', 99, NULL, NULL),
(3, 2, NULL, 2, 1, 'Layna', 'Layna', '1000.00', 0, 'Layna', 'WOZIAL003', '<p>Layna</p>', 'Piel', NULL, 1, 1, '2020-01-21', 99, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productoscat`
--

CREATE TABLE `productoscat` (
  `id` int(11) NOT NULL,
  `parent` int(2) NOT NULL,
  `txt` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `imagen` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `imagenhover` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT '0',
  `orden` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data for table `productoscat`
--

INSERT INTO `productoscat` (`id`, `parent`, `txt`, `imagen`, `imagenhover`, `estatus`, `orden`) VALUES
(1, 0, 'Cuadro', NULL, NULL, 0, 99),
(2, 1, 'Circuo', NULL, NULL, 0, 99),
(3, 1, 'Trangulo', NULL, NULL, 0, 99);

-- --------------------------------------------------------

--
-- Table structure for table `productoscolor`
--

CREATE TABLE `productoscolor` (
  `id` int(11) NOT NULL,
  `txt` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `imagen` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  `name` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data for table `productoscolor`
--

INSERT INTO `productoscolor` (`id`, `txt`, `imagen`, `name`) VALUES
(1, '#000000', NULL, 'Negro'),
(2, '#919191', '2019-10-11541970347.jpg', 'Grey');

-- --------------------------------------------------------

--
-- Table structure for table `productosexistencias`
--

CREATE TABLE `productosexistencias` (
  `id` int(11) NOT NULL,
  `producto` int(11) DEFAULT NULL,
  `talla` int(11) DEFAULT NULL,
  `color` int(11) DEFAULT NULL,
  `existencias` int(11) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estatus` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productosexistencias`
--

INSERT INTO `productosexistencias` (`id`, `producto`, `talla`, `color`, `existencias`, `precio`, `estatus`) VALUES
(12, 1, 3, 2, 10, '0.00', 1),
(11, 1, 3, 1, 10, '0.00', 1),
(10, 1, 1, 2, -9, '0.00', 1),
(9, 1, 1, 1, -1, '0.00', 1),
(8, 1, 2, 2, 10, '0.00', 1),
(7, 1, 2, 1, 10, '0.00', 1),
(13, 2, 2, 1, -1, '0.00', 1),
(14, 2, 2, 2, 0, '0.00', 0),
(15, 2, 1, 1, -1, '0.00', 1),
(16, 2, 1, 2, 0, '0.00', 0),
(17, 2, 1, 2, 0, '0.00', 0),
(18, 2, 3, 1, 10, '0.00', 1),
(19, 2, 3, 2, 0, '0.00', 0),
(20, 2, 3, 2, 0, '0.00', 0),
(21, 3, 2, 1, 0, '0.00', 1),
(22, 3, 2, 2, 0, '0.00', 0),
(23, 3, 1, 1, 0, '0.00', 1),
(24, 3, 1, 2, 0, '0.00', 0),
(25, 3, 3, 1, 0, '0.00', 1),
(26, 3, 3, 2, 0, '0.00', 0),
(27, 4, 2, 1, 0, '0.00', 0),
(28, 4, 2, 2, 0, '0.00', 0),
(29, 4, 1, 1, 0, '0.00', 0),
(30, 4, 1, 2, 0, '0.00', 0),
(31, 4, 3, 1, 0, '0.00', 0),
(32, 4, 3, 2, 0, '0.00', 0),
(33, 5, 2, 1, 0, '0.00', 0),
(34, 5, 2, 2, 0, '0.00', 0),
(35, 5, 1, 1, 0, '0.00', 0),
(36, 5, 1, 2, 0, '0.00', 0),
(37, 5, 3, 1, 0, '0.00', 0),
(38, 5, 3, 2, 0, '0.00', 0),
(39, 6, 2, 1, 0, '0.00', 0),
(40, 6, 2, 2, 0, '0.00', 0),
(41, 6, 1, 1, 0, '0.00', 0),
(42, 6, 1, 2, 0, '0.00', 0),
(43, 6, 3, 1, 0, '0.00', 0),
(44, 6, 3, 2, 0, '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productosmarcas`
--

CREATE TABLE `productosmarcas` (
  `id` int(11) NOT NULL,
  `txt` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `productosmarcas`
--

INSERT INTO `productosmarcas` (`id`, `txt`, `imagen`, `orden`) VALUES
(3, 'Patito', '477175676.png', 99);

-- --------------------------------------------------------

--
-- Table structure for table `productospic`
--

CREATE TABLE `productospic` (
  `id` int(10) NOT NULL,
  `producto` int(10) NOT NULL,
  `titulo` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `title` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `txt` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `orden` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data for table `productospic`
--

INSERT INTO `productospic` (`id`, `producto`, `titulo`, `title`, `txt`, `orden`) VALUES
(1, 1, NULL, NULL, NULL, 99),
(2, 2, NULL, NULL, NULL, 99),
(3, 3, NULL, NULL, NULL, 99);

-- --------------------------------------------------------

--
-- Table structure for table `productostalla`
--

CREATE TABLE `productostalla` (
  `id` int(11) NOT NULL,
  `txt` text CHARACTER SET latin1 COLLATE latin1_spanish_ci,
  `tipo` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT 'Chamarras',
  `orden` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Dumping data for table `productostalla`
--

INSERT INTO `productostalla` (`id`, `txt`, `tipo`, `orden`) VALUES
(1, 'Chico', '2', 1),
(2, 'Mediano', '2', 0),
(3, 'Grande', '2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `productostallaclasif`
--

CREATE TABLE `productostallaclasif` (
  `id` int(11) NOT NULL,
  `txt` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` int(2) NOT NULL DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `productostallaclasif`
--

INSERT INTO `productostallaclasif` (`id`, `txt`, `orden`) VALUES
(2, 'Ropa', 99);

-- --------------------------------------------------------

--
-- Table structure for table `productostallarel`
--

CREATE TABLE `productostallarel` (
  `id` int(10) NOT NULL,
  `producto` int(2) DEFAULT NULL,
  `talla` int(3) DEFAULT NULL,
  `espalda` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `manga` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `largo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `busto` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `cintura` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(10) NOT NULL,
  `categoria` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `titulo` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `txt` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `txtdetalle` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `estatus` int(1) NOT NULL DEFAULT '0',
  `fecha` date DEFAULT NULL,
  `orden` int(2) DEFAULT '99',
  `imagen` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `lat` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `lon` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `sucursales`
--

INSERT INTO `sucursales` (`id`, `categoria`, `titulo`, `txt`, `txtdetalle`, `estatus`, `fecha`, `orden`, `imagen`, `lat`, `lon`) VALUES
(1, NULL, 'Wozial', '<p>Probando</p>', NULL, 0, '2019-10-11', 99, '217932748.jpg', '20.667703809107746', '-103.34699871873852');

-- --------------------------------------------------------

--
-- Table structure for table `testimonios`
--

CREATE TABLE `testimonios` (
  `id` int(10) NOT NULL,
  `titulo` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `txt` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `imagen` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `orden` int(2) DEFAULT '99'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `testimonios`
--

INSERT INTO `testimonios` (`id`, `titulo`, `email`, `fecha`, `txt`, `imagen`, `orden`) VALUES
(1, 'Efra', 'ing_efrain@yahoo.com', '2019-10-12', '<p>Probando</p>', '705694155.jpg', 99);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `user` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pass` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `nivel` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user`, `pass`, `fecha`, `nivel`) VALUES
(1, 'efra', '12eb5fef578326a527019871e4ca1c35', '2019-09-16 00:00:00', 2),
(24, 'rosi', '12eb5fef578326a527019871e4ca1c35', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `nivel` int(1) NOT NULL DEFAULT '0',
  `distribuidor` int(1) NOT NULL DEFAULT '0',
  `alta` date DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `udate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `facebook` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pass` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `empresa` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `rfc` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `calle` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `noexterior` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nointerior` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `entrecalles` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pais` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'Mexico',
  `estado` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `municipio` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `colonia` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `cp` varchar(11) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `calle2` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `noexterior2` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nointerior2` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `entrecalles2` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `pais2` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT 'Mexico',
  `estado2` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `municipio2` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `colonia2` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `cp2` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nivel`, `distribuidor`, `alta`, `fecha`, `nombre`, `email`, `telefono`, `facebook`, `pass`, `empresa`, `rfc`, `calle`, `noexterior`, `nointerior`, `entrecalles`, `pais`, `estado`, `municipio`, `colonia`, `cp`, `calle2`, `noexterior2`, `nointerior2`, `entrecalles2`, `pais2`, `estado2`, `municipio2`, `colonia2`, `cp2`, `imagen`) VALUES
(1, 0, 0, '2019-10-31', '2020-05-21 02:49:06', 'Efra', 'ing_efrain@yahoo.com', '3314305376', NULL, '12eb5fef578326a527019871e4ca1c35', 'Wozial', 'GOME771206PJ9', 'Rio Juarez', '1906', 'L 43', 'Rio Medellin e Insurgentes', 'México', 'Jalisco', 'Guadalajara', 'El Rosario', '44898', NULL, NULL, NULL, NULL, 'Mexico', NULL, NULL, NULL, NULL, NULL),
(2, 0, 0, '2019-10-31', '2019-10-31 00:36:56', 'ROSA AURELIA', 'rosyreyess@hotmail.com', '3317114960', NULL, '12eb5fef578326a527019871e4ca1c35', 'Wozial', 'RESR720608', 'RIO ATOTNILCO', '1149', 'Rio Juarez 1906 int L 43', 'Autlán y Amealco', 'México', 'Jalisco', 'Guadalajara', 'Altas', '44898', NULL, NULL, NULL, NULL, 'Mexico', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogpic`
--
ALTER TABLE `blogpic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendariopic`
--
ALTER TABLE `calendariopic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel2`
--
ALTER TABLE `carousel2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cupones`
--
ALTER TABLE `cupones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galerias`
--
ALTER TABLE `galerias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeriaspic`
--
ALTER TABLE `galeriaspic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ipn`
--
ALTER TABLE `ipn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedidosdetalle`
--
ALTER TABLE `pedidosdetalle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productoscat`
--
ALTER TABLE `productoscat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `productoscolor`
--
ALTER TABLE `productoscolor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `productosexistencias`
--
ALTER TABLE `productosexistencias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productosmarcas`
--
ALTER TABLE `productosmarcas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productospic`
--
ALTER TABLE `productospic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productostalla`
--
ALTER TABLE `productostalla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `productostallaclasif`
--
ALTER TABLE `productostallaclasif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productostallarel`
--
ALTER TABLE `productostallarel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonios`
--
ALTER TABLE `testimonios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blogpic`
--
ALTER TABLE `blogpic`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `calendario`
--
ALTER TABLE `calendario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `calendariopic`
--
ALTER TABLE `calendariopic`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `carousel2`
--
ALTER TABLE `carousel2`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cupones`
--
ALTER TABLE `cupones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `galerias`
--
ALTER TABLE `galerias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `galeriaspic`
--
ALTER TABLE `galeriaspic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ipn`
--
ALTER TABLE `ipn`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pedidosdetalle`
--
ALTER TABLE `pedidosdetalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `productoscat`
--
ALTER TABLE `productoscat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `productoscolor`
--
ALTER TABLE `productoscolor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productosexistencias`
--
ALTER TABLE `productosexistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `productosmarcas`
--
ALTER TABLE `productosmarcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `productospic`
--
ALTER TABLE `productospic`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `productostalla`
--
ALTER TABLE `productostalla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productostallaclasif`
--
ALTER TABLE `productostallaclasif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `productostallarel`
--
ALTER TABLE `productostallarel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonios`
--
ALTER TABLE `testimonios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
