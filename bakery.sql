-- MariaDB dump 10.19-11.0.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bakery
-- ------------------------------------------------------
-- Server version	11.0.2-MariaDB

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `img_url` varchar(60) NOT NULL,
  PRIMARY KEY (`pk_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(17,'Pão','/images/products/vitrine.jpeg'),
(18,'Pizza','/images/products/pizza5.jpeg'),
(19,'Sanduiche','/images/products/sanduiche.jpeg');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `fk_order_id` int(11) NOT NULL,
  `fk_product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  KEY `fk_product_id_idx` (`fk_order_id`),
  KEY `fk_order_id_idx` (`fk_product_id`),
  CONSTRAINT `fk_order_item_order` FOREIGN KEY (`fk_order_id`) REFERENCES `orders` (`pk_id`),
  CONSTRAINT `fk_order_item_product` FOREIGN KEY (`fk_product_id`) REFERENCES `products` (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_user_id` int(11) NOT NULL,
  `order_day` date NOT NULL,
  `delivery` date DEFAULT NULL,
  `payment_method` varchar(20) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `city` varchar(60) NOT NULL,
  `district` varchar(60) NOT NULL,
  `postal` varchar(30) NOT NULL,
  `street` varchar(40) NOT NULL,
  `number` int(11) NOT NULL,
  `complement` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`pk_id`),
  KEY `fk_user_id_idx` (`pk_id`),
  KEY `fk_order_user_idx` (`fk_user_id`),
  CONSTRAINT `fk_order_user_idx` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`pk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `price` decimal(6,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `img_url` varchar(120) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  PRIMARY KEY (`pk_id`),
  KEY `product_category` (`category`),
  CONSTRAINT `product_category` FOREIGN KEY (`category`) REFERENCES `categories` (`pk_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(33,'Pizza De Manjericão','',60.00,0,'/images/products/pizza3.jpeg',18),
(34,'Rosquinhas','\r\n            \r\n            ',5.50,0,'/images/products/gotas2.jpeg',17),
(35,'Pizza de Mussarela','',50.00,0,'/images/products/pizza1.jpeg',18),
(36,'Sanduiche de Mortadela','',10.00,0,'/images/products/mortadela.jpeg',19),
(37,'Hamburguer','',30.00,0,'/images/products/hamburguer.jpeg',19),
(38,'Pão Doce de Frutas','Uva passa e nozes.',10.00,0,'/images/products/doce.jpeg',17),
(39,'Croissant','Um delicioso pão amanteigado',6.00,0,'/images/products/croissant.jpeg',17),
(40,'Boule','',6.00,0,'/images/products/boule.jpeg',17),
(41,'Baguete','',2.00,0,'/images/products/baguete2.jpeg',17),
(42,'Biscoitos','',6.50,0,'/images/products/gotas.jpeg',17);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(120) NOT NULL,
  `birth` date NOT NULL,
  `telephone` varchar(40) NOT NULL,
  `flag` enum('common','admin') DEFAULT 'common',
  PRIMARY KEY (`pk_id`),
  UNIQUE KEY `email_unique_idx` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(158,'Mateus','mateus@gmail.com','$2y$10$EONfhN7i5hccLBwcvSSTyece4kzi5HOdGr6tsPCdhdIO4KFGqJ8BO','2002-10-10','(33) 1212 - 1231','admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-12 21:48:30
