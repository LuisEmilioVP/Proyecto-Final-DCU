-- DROP DATABASE `db_softschool`;
-- CREATE DATABASE `db_softschool`;
-- USE `db_softschool`;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 18, 2023 at 01:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_softschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrativo`
--

CREATE TABLE `administrativo` (
  `IdAmin` int NOT NULL,
  `Nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Genero` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `Correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Telefono` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `Cargo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Foto` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Clave` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrativo`
--

INSERT INTO `administrativo` (`IdAmin`, `Nombre`, `Apellido`, `Genero`, `Correo`, `Telefono`, `Cargo`, `Foto`, `Clave`) VALUES
(1, 'Alan', 'Baldez', 'Masculino', 'alanvaldezz@gmail.com', '(809) 269-5699', 'Supervisor', 'he-01.png', '2c1ba65436082e22241be2f5c88422446827835d'),
(7, 'Luis', 'Valenzuela', 'Masculino', 'luisvp@gmail.com', '(809) 269-56659', 'Administrador', 'Foto001.JPG', '4c9e7ca5ffd483361f9ea8d95a13c7aa90cb3b12');

-- --------------------------------------------------------

--
-- Table structure for table `aula`
--

CREATE TABLE `aula` (
  `IdAula` int NOT NULL,
  `NúmeroAula` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `Capacidad` int NOT NULL,
  `Tipo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aula`
--

INSERT INTO `aula` (`IdAula`, `NúmeroAula`, `Capacidad`, `Tipo`) VALUES
(1, '1 A2', 35, 'Teórica');

-- --------------------------------------------------------

--
-- Table structure for table `estudiante`
--

CREATE TABLE `estudiante` (
  `IdEstudiante` int NOT NULL,
  `Nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Edad` int NOT NULL,
  `Genero` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `Correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Telefono` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `Direccion` varchar(155) COLLATE utf8mb4_general_ci NOT NULL,
  `Foto` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `estudiante_materia`
--

CREATE TABLE `estudiante_materia` (
  `IdMateria` int DEFAULT NULL,
  `IdEstudiante` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materia`
--

CREATE TABLE `materia` (
  `IdMateria` int NOT NULL,
  `NombreMateria` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Descripción` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `IdProfesor` int NOT NULL,
  `IdAula` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materia`
--
-- --------------------------------------------------------

--
-- Table structure for table `profesor`
--

CREATE TABLE `profesor` (
  `IdProfesor` int NOT NULL,
  `Nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Genero` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `Edad` int NOT NULL,
  `Correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Telefono` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `Especialidad` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Foto` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profesor`
--
--
-- Indexes for table `administrativo`
--
ALTER TABLE `administrativo`
  ADD PRIMARY KEY (`IdAmin`);

--
-- Indexes for table `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`IdAula`);

--
-- Indexes for table `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`IdEstudiante`);

--
-- Indexes for table `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  ADD KEY `IdMateria` (`IdMateria`),
  ADD KEY `IdEstudiante` (`IdEstudiante`);

--
-- Indexes for table `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`IdMateria`),
  ADD KEY `IdProfesor` (`IdProfesor`),
  ADD KEY `IdAula` (`IdAula`);

--
-- Indexes for table `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`IdProfesor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrativo`
--
ALTER TABLE `administrativo`
  MODIFY `IdAmin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for table `estudiante_materia`
--
ALTER TABLE `estudiante_materia`
  ADD CONSTRAINT `estudiante_materia_ibfk_1` FOREIGN KEY (`IdMateria`) REFERENCES `materia` (`IdMateria`),
  ADD CONSTRAINT `estudiante_materia_ibfk_2` FOREIGN KEY (`IdEstudiante`) REFERENCES `estudiante` (`IdEstudiante`);

--
-- Constraints for table `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`IdProfesor`) REFERENCES `profesor` (`IdProfesor`),
  ADD CONSTRAINT `materia_ibfk_2` FOREIGN KEY (`IdAula`) REFERENCES `aula` (`IdAula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;