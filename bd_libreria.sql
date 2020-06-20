-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-05-2019 a las 11:10:51
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd_libreria2`

--

create database bd_libreria2;
use bd_libreria2;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE IF NOT EXISTS `autores` (
  `Idautor` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Apellidos` varchar(45) NOT NULL,
  `Nacionalidad` varchar(20) NOT NULL,
  PRIMARY KEY (`Idautor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`Idautor`, `Nombre`, `Apellidos`, `Nacionalidad`) VALUES
(1, 'Russell', 'Borland', 'Ukrania'),
(4, 'Helen', 'Custer', 'USA'),
(5, 'Mark', 'Dodge', 'UK'),
(6, 'Chris', 'Kinata', 'Ukrania'),
(7, 'Frank', 'Fjermedal', 'Israel'),
(8, 'Kyle', 'Geiger', 'Germany'),
(9, 'Michael', 'Halvorson', 'USA'),
(10, 'Adrian', 'King', 'UK'),
(11, 'Steve', 'McConell', 'Germany');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `IdCliente` int(11) NOT NULL,
  `Apellidos` varchar(45) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  PRIMARY KEY (`IdCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`IdCliente`, `Apellidos`, `Nombre`, `Direccion`, `Telefono`) VALUES
(1, 'Davolio', 'Nancy', '415 West Fifth Ave', '206-555-9857'),
(2, 'Fuller', 'Andrew', '908 W. Capital Way', '206-555-9482'),
(3, 'Leverling', 'Janet', '722 Moss Bay Blvd.', '206-555-3412'),
(4, 'Peacock', 'Margaret', '4110 Old Redmond Rd.', '206-555-8122'),
(5, 'Buchanan', 'Steven', '13920 S.E. 40th Street', '206-555-4869'),
(6, 'Suyama', 'Michael', '112 Pike', '206-555-9898'),
(7, 'King', 'Robert', 'Edgeham Hollow', '71-555-5598'),
(8, 'Callahan', 'Laura', '4726 148th N.E.', '206-555-1189'),
(9, 'Dodsworth', 'Anne', '7 Houndstooth Rd.', '71-555-4444'),
(10, 'Viescas', 'John', '15127 NE 24th, Suite 383 ', '206-881-5596'),
(11, 'Sánchez Escribano', 'Nancy', '507 - 20th Ave. E.', '948-555-9857');

--
-- Disparadores `clientes`
--
DROP TRIGGER IF EXISTS `trigger_cliente_historico`;
DELIMITER //
CREATE TRIGGER `trigger_cliente_historico` AFTER INSERT ON `clientes`
 FOR EACH ROW BEGIN 
	   INSERT INTO clientes_historicos(IdCliente,Apellidos,Nombre,Direccion,telefono,fecha)
	   VALUES (NEW.Idcliente, NEW.Apellidos, NEW.Nombre, New.Direccion, New.telefono,curdate());
	END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallespedidos`
--

CREATE TABLE IF NOT EXISTS `detallespedidos` (
  `Cantidad` int(11) NOT NULL,
  `ISBN` varchar(13) NOT NULL,
  `IdPedido` int(11) NOT NULL,
  PRIMARY KEY (`ISBN`,`IdPedido`),
  KEY `fk_DetallesPedidos_PEDIDOS1_idx` (`IdPedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallespedidos`
--

INSERT INTO `detallespedidos` (`Cantidad`, `ISBN`, `IdPedido`) VALUES
(2, '1-55615-481-X', 2),
(8, '1-55615-481-x', 3),
(6, '1-55615-481-x', 4),
(11, '1-55615-481-x', 6),
(5, '1-55615-481-x', 7),
(12, '1-55615-481-x', 9),
(10, '1-55615-581-6', 5),
(5, '1-55615-592-1', 2),
(4, '1-55615-627-8', 4),
(12, '1-55615-627-8', 5),
(6, '1-55615-663-4', 9),
(9, '1-55615-668-5', 5),
(5, '1-55615-670-7', 7),
(9, '1-55615-675-8', 2),
(4, '1-55615-675-8', 4),
(2, '1-55615-677-4', 5),
(3, '1-55615-815-7', 9),
(8, '1-55615-822-x', 8),
(3, '1-55615-831-9', 5),
(2, '1-55615-832-7', 4),
(6, '1-55615-852-1', 2),
(5, '1-55615-852-1', 5),
(12, '1-55615-852-1', 9),
(2, '1-55615-875-0', 3),
(11, '1-55615-886-6', 4),
(5, '1-55615-886-6', 7),
(3, '1-55615-897-1', 5),
(9, '1-55615-906-4', 6),
(1, '1-55615-906-4', 9),
(6, '1-55615-910-2', 4),
(5, '1-55615-910-2', 5),
(1, '1-55615-948-x', 2),
(4, '1-57231-304-8', 3),
(5, '1-57231-304-8', 8);

--
-- Disparadores `detallespedidos`
--
DROP TRIGGER IF EXISTS `trigger_existencia_libros_actualizar`;
DELIMITER //
CREATE TRIGGER `trigger_existencia_libros_actualizar` AFTER INSERT ON `detallespedidos`
 FOR EACH ROW BEGIN 
	  Update libros set Existencias=Existencias-New.Cantidad Where libros.isbn=New.Isbn;
	END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `librerias`
--

CREATE TABLE IF NOT EXISTS `librerias` (
  `IdLibreria` int(11) NOT NULL,
  `Nombre` varchar(45) NOT NULL,
  `Direccion` varchar(45) NOT NULL,
  `Ciudad` varchar(20) NOT NULL,
  `Telefono` varchar(11) NOT NULL,
  PRIMARY KEY (`IdLibreria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `librerias`
--

INSERT INTO `librerias` (`IdLibreria`, `Nombre`, `Direccion`, `Ciudad`, `Telefono`) VALUES
(1, 'Madison Books & Computers', '8006-5 Madison', 'Madison', '205-772-92'),
(2, 'Cook Inlet Book Company', '415 West Fifth Ave', 'Anchorage', '907-258-45'),
(3, 'ASU Bookstore', 'Arizona State', 'Tempe', '602-965-79'),
(4, 'ASUA Bookstore Warehouse', '850 E. 18th St.', 'Tucson', '602-621-28'),
(5, 'Book Mark', '5001 East Speedway', 'Tucson', '602-881-63'),
(6, 'A Clean Well-Lighted Place', '21269 Stevens', 'Cupertino', '408-255-76'),
(7, 'A Clean Well-Lighted Place', '2417 Larkspur', 'Larkspur', '415-461-01'),
(8, 'A Clean Well-Lighted Place', 'Opera Plaza, 601', 'San Francisco', '415-441-66'),
(9, 'ASUC Student Union Building', 'Bancroft Way and', 'Berkeley', '510-642-72'),
(10, 'Basic Living Products', '1321 67th St.', 'Emeryville', '510-428-16'),
(11, 'Books Inc.', '120 Park Lane', 'Brisbane', '415-468-61'),
(12, 'Bookshop Santa Cruz', '1520 Pacific Ave.', 'Santa Cruz', '408-423-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE IF NOT EXISTS `libros` (
  `ISBN` varchar(13) NOT NULL,
  `Titulo` varchar(80) NOT NULL,
  `Precio` decimal(5,2) DEFAULT NULL,
  `IdAutor` int(11) NOT NULL,
  `Existencias` int(11) DEFAULT '5',
  PRIMARY KEY (`ISBN`),
  KEY `fk_LIBROS_AUTORES_idx` (`IdAutor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`ISBN`, `Titulo`, `Precio`, `IdAutor`, `Existencias`) VALUES
('1-55615-481-X', 'Inside Windows NT tm', '24.95', 5, 3),
('1-55615-484-4', 'Code Complete', '35.00', 6, 5),
('1-55615-581-6', 'Field Guide Access® 2 for Windows®', '9.95', 1, 5),
('1-55615-583-2', 'Adventures in Space Simulator', '22.95', 4, 5),
('1-55615-592-1', 'Running Access®2 for Windows®', '39.95', 8, 5),
('1-55615-626-X', 'Inside Windows® 95', '24.95', 1, 5),
('1-55615-627-8', 'The Ultimate MS-DOS® Book', '22.95', 7, 5),
('1-55615-660-X', 'Inside the Windows NT tm File System', '9.95', 4, 5),
('1-55615-663-4', 'Winning Chess Strategies', '9.95', 1, 5),
('1-55615-665-0', 'Developing Applications with Microsoft® Office', '39.95', 5, 5),
('1-55615-667-7', 'Hardcore Visual Basic®', '39.95', 8, 5),
('1-55615-668-5', 'Communications Programming For Windows® 95', '39.95', 4, 5),
('1-55615-669-3', 'Animation Techniques in Win32®', '34.95', 7, 5),
('1-55615-670-7', 'The Ultimate Microsoft® Windows® 95 Book', '24.95', 1, 5),
('1-55615-674-X', 'Running Microsoft® Windows® 95', '39.95', 7, 5),
('1-55615-675-8', 'Field Guide to Microsoft® Windows® 95', '9.95', 7, 5),
('1-55615-677-4', 'Advanced Windows', '44.95', 4, 5),
('1-55615-815-7', 'Inside ODBC', '39.95', 6, 5),
('1-55615-817-3', 'Traveling The Microsoft® Network', '19.95', 1, 5),
('1-55615-822-X', 'Field Guide to the Internet', '9.95', 8, 5),
('1-55615-828-9', 'Microsoft® Word for Windows® 95 Step Step', '29.95', 7, 5),
('1-55615-831-9', 'Running Microsoft® Excel for Windows® 95', '29.95', 1, 5),
('1-55615-832-7', 'Field Guide to Microsoft® Word Windows® 95', '9.95', 5, 5),
('1-55615-839-4', 'Field Guide to Microsoft® Excel Windows® 95', '9.95', 5, 5),
('1-55615-843-2', 'Inside OLE', '49.95', 9, 5),
('1-55615-848-3', 'Running Microsoft® Word for Windows® 95', '29.95', 4, 5),
('1-55615-852-1', 'Running Microsoft® PowerPoint® Windows® 95', '24.95', 5, 5),
('1-55615-875-0', 'Field Guide Microsoft® Access for Windows® 95', '9.95', 1, 5),
('1-55615-876-9', 'Microsoft® Access® for Step by Step', '29.95', 9, 5),
('1-55615-886-6', 'Running Microsoft Access for Windows® 95', '39.95', 10, 5),
('1-55615-894-7', 'Ultimate Microsoft® Office Book', '24.95', 8, 5),
('1-55615-897-1', 'Running Microsoft® Office Windows® 95', '29.95', 9, 5),
('1-55615-898-X', 'Microsoft Office for Windows®', '39.95', 10, 5),
('1-55615-899-8', 'Programming with Visual Basic 4', '39.95', 10, 5),
('1-55615-905-6', 'Microsoft® Visual Basic® Now', '39.95', 6, 5),
('1-55615-906-4', 'Guide Visual Basic® and SQL Server', '44.95', 4, 5),
('1-55615-910-2', 'Winning Chess Brilliancies', '9.95', 8, 5),
('1-55615-948-X', 'HTML In Action', '29.95', 9, 5),
('1-57231-210-6', 'Winning Chess Tactics', '9.95', 9, 5),
('1-57231-232-7', 'Client/Server Microsoft® Visual Basic®', '34.95', 4, 5),
('1-57231-237-8', 'Desktop Publishing By Design', '39.95', 6, 5),
('1-57231-304-8', 'Build Your Own Web Site', '29.95', 11, 5),
('1-57231-320-x', 'Running Microsoft® Word 97  Windows®', '29.95', 5, 5),
('1-57231-321-8', 'Running Microsoft® Excel 97  Windows®', '29.95', 6, 5),
('1-57231-322-6', 'Running Microsoft® Office 97 Windows®', '29.95', 6, 5),
('1-57231-323-4', 'Running Microsoft® Access® 97 Windows®', '39.95', 5, 5),
('1-57231-324-2', 'Running Microsoft® PowerPoint Windows®', '24.95', 11, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `IdPedido` int(11) NOT NULL,
  `FechaPedido` date NOT NULL,
  `Descuento` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `IdLibreria` int(11) NOT NULL,
  PRIMARY KEY (`IdPedido`),
  KEY `fk_PEDIDOS_CLIENTES1_idx` (`IdCliente`),
  KEY `fk_PEDIDOS_LIBRERIAS1_idx` (`IdLibreria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`IdPedido`, `FechaPedido`, `Descuento`, `IdCliente`, `IdLibreria`) VALUES
(2, '1996-07-01', 5, 9, 2),
(3, '1996-07-01', 5, 9, 1),
(4, '1996-07-01', 5, 3, 2),
(5, '1996-07-01', 5, 3, 4),
(6, '1996-07-01', 5, 6, 4),
(7, '1996-07-02', 5, 9, 5),
(8, '1996-07-02', 5, 6, 10),
(9, '1996-07-03', 5, 6, 1),
(10, '1996-07-03', 5, 5, 10),
(11, '1996-07-04', 5, 4, 12),
(12, '1996-07-04', 5, 10, 2),
(13, '1996-07-04', 5, 2, 1),
(14, '1996-07-04', 4, 6, 2),
(15, '1996-07-04', 4, 2, 2),
(16, '1996-07-05', 10, 3, 2),
(17, '1996-07-06', 5, 4, 2),
(18, '1996-07-07', 5, 10, 3),
(19, '1996-07-07', 5, 7, 4),
(20, '1996-07-07', 5, 5, 4),
(21, '1996-07-08', 5, 8, 2),
(22, '1996-07-08', 5, 2, 12),
(23, '1996-07-08', 5, 1, 2),
(24, '1996-07-08', 4, 9, 3),
(25, '1996-07-08', 4, 5, 3),
(26, '1996-07-08', 4, 10, 1),
(27, '1996-07-09', 10, 9, 1),
(28, '1996-07-10', 10, 3, 1),
(29, '1996-07-10', 4, 7, 3),
(30, '1996-07-10', 4, 8, 4),
(31, '1996-07-10', 4, 3, 5),
(32, '1996-07-10', 4, 8, 9),
(33, '1996-07-11', 5, 8, 10),
(34, '1996-07-12', 5, 4, 8),
(35, '1996-07-12', 4, 6, 8),
(36, '1996-07-12', 4, 7, 9),
(37, '1996-07-12', 5, 1, 3),
(38, '1996-07-13', 6, 9, 3),
(39, '1996-07-13', 5, 4, 3),
(40, '1996-07-14', 4, 8, 1),
(41, '1996-07-14', 4, 8, 1),
(42, '1996-07-15', 4, 1, 1),
(43, '1996-07-15', 5, 9, 6),
(44, '1996-07-16', 5, 6, 4),
(45, '1996-07-16', 5, 3, 4),
(46, '1996-07-16', 5, 6, 8),
(47, '1996-07-16', 5, 9, 3);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallespedidos`
--
ALTER TABLE `detallespedidos`
  ADD CONSTRAINT `fk_DetallesPedidos_LIBROS1` FOREIGN KEY (`ISBN`) REFERENCES `libros` (`ISBN`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DetallesPedidos_PEDIDOS1` FOREIGN KEY (`IdPedido`) REFERENCES `pedidos` (`IdPedido`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `fk_LIBROS_AUTORES` FOREIGN KEY (`IdAutor`) REFERENCES `autores` (`Idautor`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_PEDIDOS_CLIENTES1` FOREIGN KEY (`IdCliente`) REFERENCES `clientes` (`IdCliente`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PEDIDOS_LIBRERIAS1` FOREIGN KEY (`IdLibreria`) REFERENCES `librerias` (`IdLibreria`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
