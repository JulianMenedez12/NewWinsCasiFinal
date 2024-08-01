CREATE DATABASE  IF NOT EXISTS `newwins` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `newwins`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: newwins
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `contenido` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria` (`categoria_id`),
  CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos`
--

LOCK TABLES `articulos` WRITE;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` VALUES (6,'NVIDIA está preparando el lanzamiento de la RTX 5090 y su último movimiento es la prueba definitiva','2024-07-30','<h2>La compa&ntilde;&iacute;a est&aacute; reduciendo la producci&oacute;n de la serie RTX 40 hasta un 50%</h2>\r\n<p><img class=\"img-fluid\" src=\"https://i.blogs.es/8ec93e/rtx-5090/1200_800.jpeg\" alt=\"nvidia.jpg\" width=\"1200\" height=\"800\"></p>\r\n<p>Dentro de escasas semanas, la&nbsp;<strong>serie RTX 40</strong>&nbsp;de NVIDIA cumplir&aacute;&nbsp;<strong>dos a&ntilde;os</strong>. Desde entonces, los rumores sobre una hipot&eacute;tica l&iacute;nea&nbsp;<strong>RTX 50</strong>&nbsp;no han dejado de surgir, ya que muchos indican que&nbsp;<a href=\"https://www.3djuegos.com/tecnologia/noticias/rtx-4090-super-real-40-potente-que-origina-no-podras-comprarla-nunca\" data-mrf-link=\"https://www.3djuegos.com/tecnologia/noticias/rtx-4090-super-real-40-potente-que-origina-no-podras-comprarla-nunca\"><u>la ausencia de la RTX 4090 Super</u></a> podr&iacute;a ser un indicativo de los planes de la compa&ntilde;&iacute;a. Y, seg&uacute;n apunta un insider, parece ser que NVIDIA ya estar&iacute;a preparando el lanzamiento de su nueva serie de tarjetas gr&aacute;ficas y, por ende, la principal afectada es la l&iacute;nea RTX 40.</p>\r\n<p data-mrf-recirculation=\"Article links\">Como indica el portal&nbsp;<strong>PC Gamer</strong>&nbsp;en una&nbsp;<a href=\"https://www.pcgamer.com/hardware/graphics-cards/nvidias-reportedly-scaling-back-rtx-40-series-production-by-as-much-as-50-in-preparation-for-the-blackwell-rtx-50-launch/\" rel=\"noopener, noreferrer\" data-mrf-link=\"https://www.pcgamer.com/hardware/graphics-cards/nvidias-reportedly-scaling-back-rtx-40-series-production-by-as-much-as-50-in-preparation-for-the-blackwell-rtx-50-launch/\"><u>reciente publicaci&oacute;n</u></a>, NVIDIA estar&iacute;a&nbsp;<strong>reduciendo significativamente</strong>&nbsp;la producci&oacute;n de sus tarjetas gr&aacute;ficas de gama alta de la serie RTX 40. As&iacute;, la reducci&oacute;n de la producci&oacute;n de los chips&nbsp;<strong>AD102</strong>,&nbsp;<strong>AD103</strong>&nbsp;y&nbsp;<strong>AD104</strong>&nbsp;podr&iacute;a ser de entre un&nbsp;<strong>30%</strong>&nbsp;y un&nbsp;<strong>50%</strong>. &iquest;El motivo? Seg&uacute;n se espera, esta reducci&oacute;n estar&iacute;a directamente relacionada con la preparaci&oacute;n del lanzamiento de la futura l&iacute;nea RTX 50.</p>\r\n<h2>Graves consecuencias para los usuarios</h2>\r\n<p data-mrf-recirculation=\"Article links\">Como consecuencia directa, es probable que al haber menos unidades disponibles se viva un&nbsp;<strong>aumento generalizado</strong>&nbsp;de los precios de tarjetas como las RTX 4070, 4080 y 4090. De hecho, la reducci&oacute;n de producci&oacute;n es una&nbsp;<strong>medida com&uacute;n</strong>&nbsp;antes del lanzamiento de una nueva generaci&oacute;n, ya que con esta maniobra se evita que los minoristas se queden con un&nbsp;<strong>exceso de stock</strong>&nbsp;de los productos &ldquo;antiguos&rdquo;. Y, seg&uacute;n la misma publicaci&oacute;n, el anuncio oficial de NVIDIA se producir&iacute;a en las&nbsp;<strong>pr&oacute;ximas semanas</strong>.</p>\r\n<p data-mrf-recirculation=\"Article links\">Al parecer, muchos insider ya apuntan a&nbsp;<strong>septiembre</strong>&nbsp;como fecha en la que se anunciar&aacute; la serie RTX 50. Durante dicha presentaci&oacute;n, la compa&ntilde;&iacute;a tendr&iacute;a la intenci&oacute;n de confirmar su disponibilidad en tiendas para&nbsp;<strong>finales de octubre</strong>&nbsp;o&nbsp;<strong>principios de noviembre</strong>, coincidiendo as&iacute; con lo que sucedi&oacute; con la actual l&iacute;nea RTX 40. A&uacute;n as&iacute;, muchos creen que&nbsp;<a href=\"https://www.3djuegos.com/tecnologia/noticias/cuanto-cuesta-tarjeta-grafica-5-anos-despues-reflexion-demuestra-que-esperar-no-vale-pena\" data-mrf-link=\"https://www.3djuegos.com/tecnologia/noticias/cuanto-cuesta-tarjeta-grafica-5-anos-despues-reflexion-demuestra-que-esperar-no-vale-pena\"><u>la llegada de una nueva generaci&oacute;n no implicar&iacute;a la bajada de precios de la actual</u></a>, sino todo lo contrario, dado que el n&uacute;mero de unidades disponibles se reducir&iacute;a y, por ello, el valor apenas sufrir&iacute;a modificaciones.</p>','https://www.nvidia.com/content/dam/en-zz/Solutions/geforce/ada/homepage/geforce-ada-40-series-nv-sfg-295x166@2x.jpg',1),(7,'China ya tiene listo un SoC ARM de 6 nm y 45 TOPS. Es lo que necesita para fabricar sus propios PC con IA','2024-08-01','<ul>\r\n<li>\r\n<h2>El dise&ntilde;ador chino de circuitos integrados Cixin Technology tiene entre manos una baza para China</h2>\r\n</li>\r\n<li>\r\n<h2>El SoC Cixin P1 puede ser utilizado en ordenadores port&aacute;tiles, mini-PC, equipos todo en uno u ordenadores de sobremesa</h2>\r\n</li>\r\n</ul>\r\n<p><img class=\"img-fluid\" src=\"https://i.blogs.es/33eb09/cixin-ap/1200_800.jpeg\" alt=\"\" width=\"1200\" height=\"800\"></p>\r\n<p>En plena efervescencia de los ordenadores personales preparados para lidiar con la&nbsp;<a href=\"https://www.xataka.com/robotica-e-ia/que-inteligencia-artificial\" data-mrf-link=\"https://www.xataka.com/robotica-e-ia/que-inteligencia-artificial\">inteligencia artificial</a>&nbsp;(IA) China acaba de hacer un anuncio importante. Y es que Cixin Technology, una de sus compa&ntilde;&iacute;as especializadas en el dise&ntilde;o de circuitos integrados, ha anunciado que va a iniciar&nbsp;<strong>la producci&oacute;n a gran escala de su SoC Cixin P1</strong>. Lo realmente importante es que este chip ha sido ideado para permitir a los ensambladores chinos de PC poner a punto sus propias m&aacute;quinas con capacidades de IA sin necesidad de recurrir a&nbsp;<a href=\"https://www.xataka.com/componentes/procesadores-intel-lunar-lake-explicados-nos-prometen-48-tops-incremento-ipc-68\" data-mrf-link=\"https://www.xataka.com/componentes/procesadores-intel-lunar-lake-explicados-nos-prometen-48-tops-incremento-ipc-68\">los SoC de Intel, AMD o Qualcomm</a>.</p>\r\n<p>Las sanciones que el Gobierno de EEUU ha desplegado desde el&nbsp;<a href=\"https://www.xataka.com/empresas-y-economia/china-tiene-grave-problema-industria-chips-sabe-va-cinco-generaciones-detras\" data-mrf-link=\"https://www.xataka.com/empresas-y-economia/china-tiene-grave-problema-industria-chips-sabe-va-cinco-generaciones-detras\">7 de octubre de 2022</a> impiden a los principales fabricantes de SoC, CPU y GPU, entre los que se encuentran Intel, NVIDIA, AMD o Qualcomm, vender a sus clientes chinos sus soluciones m&aacute;s avanzadas. En esta coyuntura para los usuarios chinos es crucial no quedarse descolgados y tener acceso a la nueva generaci&oacute;n de ordenadores port&aacute;tiles y de sobremesa capacitados para ejecutar procesos de IA, pero las prohibiciones de EEUU lo impiden. El SoC Cixin P1 aspira a resolver este problema de China de un plumazo.</p>\r\n<h2>Las especificaciones del SoC Cixin P1 no est&aacute;n nada mal</h2>\r\n<p data-mrf-recirculation=\"Article links\">Los ingenieros de esta compa&ntilde;&iacute;a china han implementado su nuevo SoC sobre la arquitectura ARM v9.2-A. El SoC Cixin P1 ser&aacute; fabricado utilizando la litograf&iacute;a de 6 nm y aglutinar&aacute; 12 n&uacute;cleos de CPU capaces de trabajar a una frecuencia de reloj m&aacute;xima de 3,2 GHz (8 n&uacute;cleos de alto rendimiento y 4 de alta eficiencia), una GPU de 10 n&uacute;cleos y una NPU con una potencia de 30 TOPS. Si sumamos la capacidad de la NPU y la de la GPU el SoC entrega 45 TOPS, lo que lo sit&uacute;a al mismo nivel de los chips equiparables que est&aacute;n produciendo las compa&ntilde;&iacute;as estadounidenses que he mencionado en el p&aacute;rrafo anterior.</p>','https://i.blogs.es/e65b35/snapdragon-888-chip-case-in-hand/1366_2000.jpg',1);
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulos_autores`
--

DROP TABLE IF EXISTS `articulos_autores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articulos_autores` (
  `articulo_id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
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
  `articulo_id` int(11) NOT NULL,
  `etiqueta_id` int(11) NOT NULL,
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
  `articulo_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `imagenes` blob DEFAULT NULL,
  `fecha_envio` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_bandeja_usuario` (`usuario_id`),
  KEY `fk_bandeja_categoria` (`categoria_id`),
  CONSTRAINT `fk_bandeja_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bandeja_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_registrados` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bandeja_entrada`
--

LOCK TABLES `bandeja_entrada` WRITE;
/*!40000 ALTER TABLE `bandeja_entrada` DISABLE KEYS */;
INSERT INTO `bandeja_entrada` VALUES (2,12,'adda','<p><strong>aadad</strong></p>',1,NULL,'2024-08-01 13:06:52'),(3,12,'asdasdasd','<p>asdasdadad<strong>adad</strong></p>',1,NULL,'2024-08-01 21:38:14');
/*!40000 ALTER TABLE `bandeja_entrada` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boletines`
--

DROP TABLE IF EXISTS `boletines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `boletines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_envio` timestamp NULL DEFAULT current_timestamp(),
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
  `boletin_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` blob DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'deportes','deportes',NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `fecha_hora` timestamp NULL DEFAULT current_timestamp(),
  `texto` text NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `articulo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comentario_articulo` (`articulo_id`),
  CONSTRAINT `fk_comentario_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (1,'AdminJulian','2024-08-01 13:08:22','Holaaa como vas',0,6),(2,'JulianMendezP12','2024-08-01 15:20:35','y yo con mi 1060 todavía :(',0,6),(4,'AdminJulian','2024-08-01 22:06:53','Amaya es muy gay',0,6),(5,'AdminJulian','2024-08-01 22:08:17','Amaya ya no es tan gay',0,6),(6,'AdminJulian','2024-08-01 22:08:41','hola',0,6),(7,'JulianMendezP12','2024-08-01 22:23:46','Holita',0,6);
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER log_user_activity
AFTER INSERT ON comentarios
FOR EACH ROW
BEGIN
    INSERT INTO user_activity_log (usuario, actividad, fecha_hora)
    VALUES (NEW.usuario, 'Nuevo comentario', NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etiquetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articulo_id` int(11) NOT NULL,
  `fecha_hora` timestamp NULL DEFAULT current_timestamp(),
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `articulo_id` int(11) NOT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anunciante` varchar(50) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `campana` text DEFAULT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_suscripcion_usuario` (`usuario_id`),
  KEY `fk_suscripcion_categoria` (`categoria_id`),
  CONSTRAINT `fk_suscripcion_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_suscripcion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_registrados` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suscripciones`
--

LOCK TABLES `suscripciones` WRITE;
/*!40000 ALTER TABLE `suscripciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `suscripciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_activity_log`
--

DROP TABLE IF EXISTS `user_activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL,
  `actividad` varchar(255) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activity_log`
--

LOCK TABLES `user_activity_log` WRITE;
/*!40000 ALTER TABLE `user_activity_log` DISABLE KEYS */;
INSERT INTO `user_activity_log` VALUES (1,'AdminJulian','Nuevo comentario','2024-08-01 17:08:17'),(2,'AdminJulian','Nuevo comentario','2024-08-01 17:08:41'),(3,'JulianMendezP12','Nuevo comentario','2024-08-01 17:23:46');
/*!40000 ALTER TABLE `user_activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_registrados`
--

DROP TABLE IF EXISTS `usuarios_registrados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_registrados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `apellido` varchar(30) NOT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nombre_usuario` (`nombre_usuario`),
  UNIQUE KEY `unique_correo_electronico` (`correo_electronico`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_registrados`
--

LOCK TABLES `usuarios_registrados` WRITE;
/*!40000 ALTER TABLE `usuarios_registrados` DISABLE KEYS */;
INSERT INTO `usuarios_registrados` VALUES (1,'usuario123','$2y$10$QH6n5VPISdRefinDSYLWP.Nuj3rc.pp9K0gd.q2tdOQ3uPw7sfDOu','correo@ejemplo.com','Nombre Usuario','foto.jpg','Ubicación Ejemplo','2024-05-30 15:41:44','',0),(3,'usuario1234','$2y$10$gMHYVI3s9J1EYeGjgpjBRO0zG6OMe4oXRDOboybiRFxu.SKSw8Cz6','correo2@ejemplo.com','Nombre Usuario3','foto.jpg','Ubicación Ejemplo','2024-05-30 15:42:18','',0),(4,'Sebastian','Amaya','AmayaGod','sa@gm.com',NULL,NULL,'2024-05-30 16:54:20','gdfgdfg',0),(6,'Flexzay','12345','rr@gm.com','Ricardo',NULL,NULL,'2024-05-30 16:58:26','Rivera',0),(7,'Demond','$2y$10$Fmr.No0SUFtrfn6YqZRb5Om/xBvE6VGQoxTV7WMEjrUvPth8bobRS','sp@gm.com','Salvador',NULL,NULL,'2024-05-30 16:59:15','Pores',0),(8,'User1no','$2y$10$Vq2QIeedceoVfacHTpQOVeqkzuIH9GceGpdhOFDh8YWscYzCaVSEC','user1@gm.com','User1',NULL,NULL,'2024-05-30 17:04:45','User',0),(9,'Chespirito','$2y$10$4a1N3IgxW6NkmbuonkRk8eTeYw9Q2yqkAxbAPBZquZMQfQtGGq2eS','chavo@gm.com','Robertto',NULL,NULL,'2024-05-30 17:11:12','Gomez Bolaños',0),(10,'Cb12','$2y$10$dN.0fiArbLucTxLXpqyYGeSys6Vzn./.gQOXeBihJ/h7ENjkPRdwi','cb@gm.com','Carlos',NULL,'Brasil','2024-05-31 11:51:48','Baute',0),(11,'amayagod14','$2y$10$UZj311KKQeeKgfSp1F0J0Op6WiiPLhAIygmxJrDKn7vwvx7mIhoYG','amayagod@gm.com','amayagod',NULL,'Bolivia','2024-05-31 12:53:39','amayagod',0),(12,'AdminJulian','$2y$10$u.aTeYsf2A2IgoFV8iQIjeBm9iOzCZdRDJbkPaMqtUBnSA419ljD.','admin@gmail.com','Julian','../uploads/perfiles/CARLOS-WARD-PERFIL.png','Guaviare','2024-05-31 14:30:40','Mendez',1),(13,'dasdasd','$2y$10$u.aTeYsf2A2IgoFV8iQIjeBm9iOzCZdRDJbkPaMqtUBnSA419ljD.','df@gm.com','asdasd',NULL,'Brasil','2024-05-31 14:33:07','dasdasd',0),(14,'Cutu','$2y$10$0jps6dzXvG7M0EzUViNDq.5tLRSICs0oxG5szxQ9o7pVkUECnz6/a','cutu@gm.com','cuto',NULL,'Ecuador','2024-05-31 15:17:02','sanchez',0),(15,'ppp','$2y$10$seOTuJt5xzYJRUWRjZuDIOBZys4LyeJf4XnZT/VMddsfiU5E6Tf0e','ppp@gmail.com','pepito',NULL,'Colombia','2024-06-11 12:50:10','perez',0),(16,'sebastian12','$2y$10$N8Y1i1nzlTTybzWB9Qnn1OTzKUq.MslROHybJYO.67Df2LTd.84Da','sbt@gm.com','Sebast',NULL,'Paraguay','2024-06-11 14:56:44','ian',0),(17,'sebastian123','$2y$10$zbKm2JvKbHe4LaPNO95s7eiONLEfvT/lg3EvPH3CxiwXalmisiSYC','sbt1@gm.com','hola',NULL,'Honduras','2024-06-11 14:59:52','ian',0),(18,'DEMOND10','$2y$10$KHVzz8/KSxCqKeWKLdpoOupwHd2.yYvJH..F90yhaDuE6eKJYA54u','DEMOND333@gmail.com','DEMOND',NULL,'Colombia','2024-06-14 16:57:09','10',1),(21,'YAnflasigay123','$2y$10$Yvlcpsrj23PB58X6RD/MYeFvIVeU0W7Gv2hsJGZjl.9AzgnZ875mq','admin3@gm.com','Juan diego',NULL,'Perú','2024-06-21 13:31:01','Gonzales',1),(22,'SaporesDemond333','$2y$10$pr9l4/.Acfp7U9PCUUfIbO.V2UmT./OPo4NX3u8.yk20qSxMorqrm','sapo@gm.com','Salvador','../uploads/perfiles/WhatsApp Image 2024-06-24 at 7.41.55 AM.jpeg','Perú','2024-06-24 16:57:55','Pores',1),(23,'JulianMendezP12','$2y$10$v0mU2FlKL60KFGY0C6dSWuuIbJrg0.RQPw1iTdkAVlsAQ4pgRgqTO','jm7126276@gmail.com','Julian',NULL,'Bolivia','2024-07-30 15:13:29','Mendez',0),(25,'JulianMendezP1206','$2y$10$MQdGJGL8oWwDNjQWQxR/COooKgzKj3N/rNDDLAWyy1vExBBwEuiNy','jm@gmail.com','Julian',NULL,'Costa Rica','2024-08-01 14:48:36','Mendez',0),(28,'Yanflasi12','$2y$10$zqc20YPyaSw8zoGCbJr.2u9VA81Sb7Rk9FzAZ8Dk5nEeRfKaSKjN6','yanflasi@gmail.com','Juan Diego',NULL,'Colombia','2024-08-01 14:55:24','Gonzales',0);
/*!40000 ALTER TABLE `usuarios_registrados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valoraciones_articulos`
--

DROP TABLE IF EXISTS `valoraciones_articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `valoraciones_articulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articulo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `valoracion` enum('like','dislike') NOT NULL,
  `fecha_hora` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_valoracion_articulo` (`articulo_id`),
  KEY `fk_valoracion_usuario` (`usuario_id`),
  CONSTRAINT `fk_valoracion_articulo` FOREIGN KEY (`articulo_id`) REFERENCES `articulos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_valoracion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_registrados` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valoraciones_articulos`
--

LOCK TABLES `valoraciones_articulos` WRITE;
/*!40000 ALTER TABLE `valoraciones_articulos` DISABLE KEYS */;
INSERT INTO `valoraciones_articulos` VALUES (1,6,12,'dislike','2024-08-01 12:52:19'),(2,6,12,'dislike','2024-08-01 12:54:17'),(3,6,23,'dislike','2024-08-01 15:20:42'),(4,7,23,'like','2024-08-01 16:30:15'),(5,7,12,'like','2024-08-01 21:38:51');
/*!40000 ALTER TABLE `valoraciones_articulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valoraciones_comentarios`
--

DROP TABLE IF EXISTS `valoraciones_comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `valoraciones_comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `valoracion` enum('like','dislike') NOT NULL,
  `fecha_hora` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_valoracion_comentario` (`comentario_id`),
  KEY `fk_valoracion_comentario_usuario` (`usuario_id`),
  CONSTRAINT `fk_valoracion_comentario` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_valoracion_comentario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_registrados` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valoraciones_comentarios`
--

LOCK TABLES `valoraciones_comentarios` WRITE;
/*!40000 ALTER TABLE `valoraciones_comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `valoraciones_comentarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-01 17:48:04
