-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 11, 2025 at 07:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `empresa`
--

-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `apellidos` varchar(128) NOT NULL,
  `correo` varchar(128) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `rol` int(1) NOT NULL,
  `archivo_nombre` varchar(255) NOT NULL,
  `archivo_file` varchar(128) NOT NULL,
  `eliminado` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `empleados`
--
INSERT INTO `empleados` (`id`, `nombre`, `apellidos`, `correo`, `pass`, `rol`, `archivo_nombre`, `archivo_file`, `eliminado`) VALUES
(1, 'Luis', 'Fernandez Soto', 'luis.fernandez@empresa.com', '123456', 2, '', '', 0),
(2, 'Valeria', 'Gomez Rivera', 'valeria.gomez@empresa.com', '123456', 1, '', '', 0),
(3, 'Miguel', 'Torres Castillo', 'miguel.torres@empresa.com', '123456', 2, '', '', 0),
(4, 'Sofia', 'Lopez Morales', 'sofia.lopez@empresa.com', '123456', 2, '', '', 0),
(5, 'Andrea', 'Mendoza Cruz', 'andrea.mendoza@empresa.com', '123456', 1, '', '', 0);

-- Set AUTO_INCREMENT to next available value
ALTER TABLE `empleados` AUTO_INCREMENT=6;

COMMIT;
