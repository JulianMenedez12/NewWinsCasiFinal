-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: newwins
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articulos`
--

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `contenido` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `categoria_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria` (`categoria_id`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos`
--

LOCK TABLES `articulos` WRITE;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulos_autores`
--

DROP TABLE IF EXISTS `articulos_autores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulos_autores` (
  `articulo_id` int NOT NULL,
  `autor_id` int NOT NULL,
  PRIMARY KEY (`articulo_id`,`autor_id`),
  KEY `fk_autor` (`autor_id`),
  CONSTRAINT `fk_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_autor` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos_autores`
--

LOCK TABLES `articulos_autores` WRITE;
/*!40000 ALTER TABLE `articulos_autores` DISABLE KEYS */;
/*!40000 ALTER TABLE `articulos_autores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulos_etiquetas`
--

DROP TABLE IF EXISTS `articulos_etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulos_etiquetas` (
  `articulo_id` int NOT NULL,
  `etiqueta_id` int NOT NULL,
  PRIMARY KEY (`articulo_id`,`etiqueta_id`),
  KEY `fk_etiqueta_articulo` (`etiqueta_id`),
  CONSTRAINT `fk_articulo_etiqueta` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_etiqueta_articulo` FOREIGN KEY (`etiqueta_id`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos_etiquetas`
--

LOCK TABLES `articulos_etiquetas` WRITE;
/*!40000 ALTER TABLE `articulos_etiquetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `articulos_etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulos_eventos`
--

DROP TABLE IF EXISTS `articulos_eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulos_eventos` (
  `articulo_id` int NOT NULL,
  `evento_id` int NOT NULL,
  PRIMARY KEY (`articulo_id`,`evento_id`),
  KEY `fk_evento_articulo` (`evento_id`),
  CONSTRAINT `fk_articulo_evento` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_evento_articulo` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos_eventos`
--

LOCK TABLES `articulos_eventos` WRITE;
/*!40000 ALTER TABLE `articulos_eventos` DISABLE KEYS */;
/*!40000 ALTER TABLE `articulos_eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autores`
--

DROP TABLE IF EXISTS `autores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `foto_perfil` varchar(255) NOT NULL,
  `biografia` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autores`
--

LOCK TABLES `autores` WRITE;
/*!40000 ALTER TABLE `autores` DISABLE KEYS */;
/*!40000 ALTER TABLE `autores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bandeja_entrada`
--

DROP TABLE IF EXISTS `bandeja_entrada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bandeja_entrada` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `categoria_id` int NOT NULL,
  `imagenes` blob,
  `fecha_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_bandeja_usuario` (`usuario_id`),
  KEY `fk_bandeja_categoria` (`categoria_id`),
  CONSTRAINT `fk_bandeja_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bandeja_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_registrados` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bandeja_entrada`
--

LOCK TABLES `bandeja_entrada` WRITE;
/*!40000 ALTER TABLE `bandeja_entrada` DISABLE KEYS */;
/*!40000 ALTER TABLE `bandeja_entrada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boletines`
--

DROP TABLE IF EXISTS `boletines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `boletines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boletines`
--

LOCK TABLES `boletines` WRITE;
/*!40000 ALTER TABLE `boletines` DISABLE KEYS */;
/*!40000 ALTER TABLE `boletines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boletines_usuarios`
--

DROP TABLE IF EXISTS `boletines_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `boletines_usuarios` (
  `boletin_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`boletin_id`,`usuario_id`),
  KEY `fk_usuario_boletin` (`usuario_id`),
  CONSTRAINT `fk_boletin_usuario` FOREIGN KEY (`boletin_id`) REFERENCES `boletines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_usuario_boletin` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_registrados` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boletines_usuarios`
--

LOCK TABLES `boletines_usuarios` WRITE;
/*!40000 ALTER TABLE `boletines_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `boletines_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `fecha_hora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `texto` text NOT NULL,
  `puntuacion` int NOT NULL,
  `articulo_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comentario_articulo` (`articulo_id`),
  CONSTRAINT `fk_comentario_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etiquetas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nombre_etiqueta` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etiquetas`
--

LOCK TABLES `etiquetas` WRITE;
/*!40000 ALTER TABLE `etiquetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_edicion`
--

DROP TABLE IF EXISTS `historial_edicion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_edicion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `articulo_id` int NOT NULL,
  `fecha_hora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cambio` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historial_articulo` (`articulo_id`),
  CONSTRAINT `fk_historial_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_edicion`
--

LOCK TABLES `historial_edicion` WRITE;
/*!40000 ALTER TABLE `historial_edicion` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial_edicion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenes_multimedia`
--

DROP TABLE IF EXISTS `imagenes_multimedia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes_multimedia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `articulo_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_imagen_articulo` (`articulo_id`),
  CONSTRAINT `fk_imagen_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes_multimedia`
--

LOCK TABLES `imagenes_multimedia` WRITE;
/*!40000 ALTER TABLE `imagenes_multimedia` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagenes_multimedia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicidad`
--

DROP TABLE IF EXISTS `publicidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publicidad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `anunciante` varchar(50) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `campana` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicidad`
--

LOCK TABLES `publicidad` WRITE;
/*!40000 ALTER TABLE `publicidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `publicidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suscripciones`
--

DROP TABLE IF EXISTS `suscripciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suscripciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `categoria_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_suscripcion_usuario` (`usuario_id`),
  KEY `fk_suscripcion_categoria` (`categoria_id`),
  CONSTRAINT `fk_suscripcion_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_suscripcion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_registrados` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suscripciones`
--

LOCK TABLES `suscripciones` WRITE;
/*!40000 ALTER TABLE `suscripciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `suscripciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_registrados`
--

DROP TABLE IF EXISTS `usuarios_registrados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_registrados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `apellido` varchar(30) NOT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nombre_usuario` (`nombre_usuario`),
  UNIQUE KEY `unique_correo_electronico` (`correo_electronico`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_registrados`
--

LOCK TABLES `usuarios_registrados` WRITE;   
/*!40000 ALTER TABLE `usuarios_registrados` DISABLE KEYS */;
INSERT INTO `usuarios_registrados` VALUES (1,'usuario123','$2y$10$QH6n5VPISdRefinDSYLWP.Nuj3rc.pp9K0gd.q2tdOQ3uPw7sfDOu','correo@ejemplo.com','Nombre Usuario','foto.jpg','Ubicación Ejemplo','2024-05-30 15:41:44','',0),(3,'usuario1234','$2y$10$gMHYVI3s9J1EYeGjgpjBRO0zG6OMe4oXRDOboybiRFxu.SKSw8Cz6','correo2@ejemplo.com','Nombre Usuario3','foto.jpg','Ubicación Ejemplo','2024-05-30 15:42:18','',0),(4,'Sebastian','Amaya','AmayaGod','sa@gm.com',NULL,NULL,'2024-05-30 16:54:20','gdfgdfg',0),(6,'Flexzay','12345','rr@gm.com','Ricardo',NULL,NULL,'2024-05-30 16:58:26','Rivera',0),(7,'Demond','$2y$10$Fmr.No0SUFtrfn6YqZRb5Om/xBvE6VGQoxTV7WMEjrUvPth8bobRS','sp@gm.com','Salvador',NULL,NULL,'2024-05-30 16:59:15','Pores',0),(8,'User1no','$2y$10$Vq2QIeedceoVfacHTpQOVeqkzuIH9GceGpdhOFDh8YWscYzCaVSEC','user1@gm.com','User1',NULL,NULL,'2024-05-30 17:04:45','User',0),(9,'Chespirito','$2y$10$4a1N3IgxW6NkmbuonkRk8eTeYw9Q2yqkAxbAPBZquZMQfQtGGq2eS','chavo@gm.com','Robertto',NULL,NULL,'2024-05-30 17:11:12','Gomez Bolaños',0),(10,'Cb12','$2y$10$dN.0fiArbLucTxLXpqyYGeSys6Vzn./.gQOXeBihJ/h7ENjkPRdwi','cb@gm.com','Carlos',NULL,'Brasil','2024-05-31 11:51:48','Baute',0),(11,'amayagod14','$2y$10$UZj311KKQeeKgfSp1F0J0Op6WiiPLhAIygmxJrDKn7vwvx7mIhoYG','amayagod@gm.com','amayagod',NULL,'Bolivia','2024-05-31 12:53:39','amayagod',0),(12,'AdminJulian','$2y$10$u.aTeYsf2A2IgoFV8iQIjeBm9iOzCZdRDJbkPaMqtUBnSA419ljD.','admin@gmail.com','Julian','../uploads/perfiles/CARLOS-WARD-PERFIL.png','Guaviare','2024-05-31 14:30:40','Mendez',1),(13,'dasdasd','$2y$10$u.aTeYsf2A2IgoFV8iQIjeBm9iOzCZdRDJbkPaMqtUBnSA419ljD.','df@gm.com','asdasd',NULL,'Brasil','2024-05-31 14:33:07','dasdasd',0),(14,'Cutu','$2y$10$0jps6dzXvG7M0EzUViNDq.5tLRSICs0oxG5szxQ9o7pVkUECnz6/a','cutu@gm.com','cuto',NULL,'Ecuador','2024-05-31 15:17:02','sanchez',0),(15,'ppp','$2y$10$seOTuJt5xzYJRUWRjZuDIOBZys4LyeJf4XnZT/VMddsfiU5E6Tf0e','ppp@gmail.com','pepito',NULL,'Colombia','2024-06-11 12:50:10','perez',0),(16,'sebastian12','$2y$10$N8Y1i1nzlTTybzWB9Qnn1OTzKUq.MslROHybJYO.67Df2LTd.84Da','sbt@gm.com','Sebast',NULL,'Paraguay','2024-06-11 14:56:44','ian',0),(17,'sebastian123','$2y$10$zbKm2JvKbHe4LaPNO95s7eiONLEfvT/lg3EvPH3CxiwXalmisiSYC','sbt1@gm.com','hola',NULL,'Honduras','2024-06-11 14:59:52','ian',0),(18,'DEMOND10','$2y$10$KHVzz8/KSxCqKeWKLdpoOupwHd2.yYvJH..F90yhaDuE6eKJYA54u','DEMOND333@gmail.com','DEMOND',NULL,'Colombia','2024-06-14 16:57:09','10',1),(21,'YAnflasigay123','$2y$10$Yvlcpsrj23PB58X6RD/MYeFvIVeU0W7Gv2hsJGZjl.9AzgnZ875mq','admin3@gm.com','Juan diego',NULL,'Perú','2024-06-21 13:31:01','Gonzales',1),(22,'SaporesDemond333','$2y$10$pr9l4/.Acfp7U9PCUUfIbO.V2UmT./OPo4NX3u8.yk20qSxMorqrm','sapo@gm.com','Salvador','../uploads/perfiles/WhatsApp Image 2024-06-24 at 7.41.55 AM.jpeg','Perú','2024-06-24 16:57:55','Pores',1);
/*!40000 ALTER TABLE `usuarios_registrados` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-26 10:28:05
