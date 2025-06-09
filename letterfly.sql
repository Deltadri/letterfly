/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.13-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: letterfly
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Autor`
--

DROP TABLE IF EXISTS `Autor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Autor` (
  `idAutor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`idAutor`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Genero`
--

DROP TABLE IF EXISTS `Genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Genero` (
  `idGenero` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`idGenero`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  UNIQUE KEY `idGenero_UNIQUE` (`idGenero`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Lectura`
--

DROP TABLE IF EXISTS `Lectura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Lectura` (
  `idLectura` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL,
  `estado` varchar(15) NOT NULL,
  PRIMARY KEY (`idLectura`),
  KEY `fk_lectura_libro_idx` (`idLibro`),
  KEY `fk_lectura_usuario_idx` (`idUsuario`),
  CONSTRAINT `fk_lectura_libro` FOREIGN KEY (`idLibro`) REFERENCES `Libro` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_lectura_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Libro`
--

DROP TABLE IF EXISTS `Libro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Libro` (
  `idLibro` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `autor` int(11) DEFAULT NULL,
  `descripcion` varchar(2000) DEFAULT NULL,
  `paginas` int(11) DEFAULT NULL,
  `portada` varchar(200) DEFAULT NULL,
  `fpublicacion` date DEFAULT NULL,
  PRIMARY KEY (`idLibro`),
  UNIQUE KEY `idLibro_UNIQUE` (`idLibro`),
  KEY `fk_libro_autor_idx` (`autor`),
  CONSTRAINT `fk_libro_autor` FOREIGN KEY (`autor`) REFERENCES `Autor` (`idAutor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LibroGenero`
--

DROP TABLE IF EXISTS `LibroGenero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `LibroGenero` (
  `idLibro` int(11) NOT NULL,
  `idGenero` int(11) NOT NULL,
  PRIMARY KEY (`idLibro`,`idGenero`),
  KEY `idGenero` (`idGenero`),
  CONSTRAINT `LibroGenero_ibfk_1` FOREIGN KEY (`idLibro`) REFERENCES `Libro` (`idLibro`) ON DELETE CASCADE,
  CONSTRAINT `LibroGenero_ibfk_2` FOREIGN KEY (`idGenero`) REFERENCES `Genero` (`idGenero`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `LibroPropuesto`
--

DROP TABLE IF EXISTS `LibroPropuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `LibroPropuesto` (
  `idPropuesta` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `autor_nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(2000) DEFAULT NULL,
  `paginas` int(11) DEFAULT NULL,
  `portada` varchar(255) DEFAULT NULL,
  `fpublicacion` date DEFAULT NULL,
  `fecha_envio` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','aceptado','rechazado') DEFAULT 'pendiente',
  `generos` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`idPropuesta`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Opinion`
--

DROP TABLE IF EXISTS `Opinion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Opinion` (
  `idOpinion` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `comentario` varchar(250) DEFAULT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`idOpinion`),
  KEY `fk_Opinion_Usuario_idx` (`idUsuario`),
  KEY `fk_Opinion_Libro_idx` (`idLibro`),
  CONSTRAINT `fk_Opinion_Libro` FOREIGN KEY (`idLibro`) REFERENCES `Libro` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_Opinion_Usuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img_perfil` varchar(200) DEFAULT NULL,
  `rol` varchar(5) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `nombre_usuario_UNIQUE` (`nombre_usuario`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-06 16:38:57
