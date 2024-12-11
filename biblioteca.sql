-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 10:17 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `biblioteca`
--

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `IDCliente` int(11) NOT NULL,
  `Nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Cedula` char(11) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`IDCliente`, `Nombre`, `Cedula`) VALUES
(1, 'Juan Pérez', '00123456789'),
(2, 'Ana Gómez', '00234567890'),
(3, 'Carlos Rodríguez', '00345678901'),
(5, 'María Fernández', '00567890123'),
(6, 'Pedro López', '00678901234'),
(7, 'Sofía Jiménez', '00789012345'),
(8, 'Javier García', '00890123456'),
(9, 'Andrea Morales', '00901234567'),
(10, 'Fernando Díaz', '01012345678'),
(12, 'Miguel Sánchez', '00123456780'),
(13, 'Bartolo Moreno', '22300473647');

-- --------------------------------------------------------

--
-- Table structure for table `devolucion`
--

CREATE TABLE `devolucion` (
  `IDPrestamo` int(11) NOT NULL,
  `FechaDevolucion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devolucion`
--

INSERT INTO `devolucion` (`IDPrestamo`, `FechaDevolucion`) VALUES
(12, '2024-12-16'),
(13, '2024-12-17'),
(15, '2024-12-19'),
(16, '2024-12-20'),
(27, '2024-12-11'),
(20, '2024-12-11'),
(19, '2024-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `libro`
--

CREATE TABLE `libro` (
  `IDLibro` int(11) NOT NULL,
  `ISBN` char(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AnioPublicacion` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `libro`
--

INSERT INTO `libro` (`IDLibro`, `ISBN`, `Titulo`, `AnioPublicacion`) VALUES
(1, '9781234567890', 'Cien Años de Soledad', '1967'),
(2, '9782345678901', 'Don Quijote de la Mancha', '0000'),
(3, '9783456789012', '1984', '1949'),
(4, '9784567890123', 'El Principito', '1943'),
(5, '9785678901234', 'Fahrenheit 451', '1953'),
(6, '9786789012345', 'El Hobbit', '1937'),
(7, '9787890123456', 'Crimen y Castigo', '0000'),
(8, '9788901234567', 'Los Miserables', '0000'),
(9, '9789012345678', 'Orgullo y Prejuicio', '0000'),
(10, '9780123456789', 'El Gran Gatsby', '1925'),
(11, '9781122334455', 'Matar a un Ruiseñor', '1960'),
(12, '9782233445566', 'La Metamorfosis', '1915'),
(13, '9783344556677', 'La Odisea', '0000'),
(14, '9784455667788', 'El Conde de Montecristo', '0000'),
(15, '9785566778899', 'Anna Karenina', '0000'),
(16, '9786677889900', 'Las Mil y Una Noches', '0000'),
(17, '9787788990011', 'El Señor de los Anillos', '1954'),
(19, '9789900112233', 'Drácula', '0000'),
(20, '9780011223344', 'Alicia en el País de las Maravillas', '1951'),
(21, '9789900112233', 'DraculaX', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `prestamo`
--

CREATE TABLE `prestamo` (
  `IDPrestamo` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `FechaPrestamo` date NOT NULL,
  `FechaDevolucion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prestamo`
--

INSERT INTO `prestamo` (`IDPrestamo`, `IDCliente`, `FechaPrestamo`, `FechaDevolucion`) VALUES
(11, 1, '2024-12-01', '2024-12-15'),
(12, 2, '2024-12-02', '2024-12-16'),
(13, 3, '2024-12-03', '2024-12-17'),
(15, 5, '2024-12-05', '2024-12-19'),
(16, 6, '2024-12-06', '2024-12-20'),
(17, 7, '2024-12-07', '2024-12-21'),
(18, 8, '2024-12-08', '2024-12-22'),
(19, 9, '2024-12-09', '2024-12-23'),
(20, 10, '2024-12-10', '2024-12-24'),
(21, 1, '2024-12-10', '2024-12-19'),
(23, 6, '2024-12-10', '2024-12-19'),
(26, 1, '2024-12-11', '2024-12-14'),
(27, 1, '2024-12-01', '2024-12-05'),
(28, 3, '2024-12-02', '2024-12-06'),
(32, 2, '2024-12-11', '2024-12-15'),
(37, 2, '2024-12-11', '2024-12-03'),
(38, 1, '2024-12-11', '2024-12-01'),
(39, 13, '2024-12-11', '2024-12-02'),
(41, 7, '2024-12-11', '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `prestamo_libro`
--

CREATE TABLE `prestamo_libro` (
  `IDPrestamo` int(11) NOT NULL,
  `IDLibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prestamo_libro`
--

INSERT INTO `prestamo_libro` (`IDPrestamo`, `IDLibro`) VALUES
(11, 2),
(12, 3),
(13, 4),
(13, 6),
(13, 8),
(15, 6),
(15, 7),
(15, 19),
(16, 7),
(17, 8),
(17, 9),
(17, 10),
(18, 9),
(19, 10),
(20, 1),
(21, 5),
(23, 5),
(26, 4),
(26, 5),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(28, 5),
(28, 8),
(28, 9),
(32, 9),
(37, 4),
(37, 5),
(38, 4),
(38, 5),
(39, 4),
(39, 5),
(41, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IDCliente`);

--
-- Indexes for table `devolucion`
--
ALTER TABLE `devolucion`
  ADD KEY `IDPrestamo` (`IDPrestamo`);

--
-- Indexes for table `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`IDLibro`);

--
-- Indexes for table `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`IDPrestamo`),
  ADD KEY `IDCliente` (`IDCliente`);

--
-- Indexes for table `prestamo_libro`
--
ALTER TABLE `prestamo_libro`
  ADD PRIMARY KEY (`IDPrestamo`,`IDLibro`),
  ADD KEY `IDLibro` (`IDLibro`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IDCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `libro`
--
ALTER TABLE `libro`
  MODIFY `IDLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `IDPrestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `devolucion`
--
ALTER TABLE `devolucion`
  ADD CONSTRAINT `devolucion_ibfk_1` FOREIGN KEY (`IDPrestamo`) REFERENCES `prestamo` (`IDPrestamo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prestamo_libro`
--
ALTER TABLE `prestamo_libro`
  ADD CONSTRAINT `prestamo_libro_ibfk_1` FOREIGN KEY (`IDPrestamo`) REFERENCES `prestamo` (`IDPrestamo`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestamo_libro_ibfk_2` FOREIGN KEY (`IDLibro`) REFERENCES `libro` (`IDLibro`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
