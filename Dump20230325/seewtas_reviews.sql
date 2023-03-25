CREATE DATABASE  IF NOT EXISTS `seewtas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `seewtas`;
-- MySQL dump 10.13  Distrib 8.0.29, for macos12 (x86_64)
--
-- Host: localhost    Database: seewtas
-- ------------------------------------------------------
-- Server version	5.7.34

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
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `index` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_bestbuy` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_amazon` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_review_bestbuy` longtext COLLATE utf8mb4_unicode_ci,
  `last_review_amazon` longtext COLLATE utf8mb4_unicode_ci,
  `summary_pros` longtext COLLATE utf8mb4_unicode_ci,
  `summary_cons` longtext COLLATE utf8mb4_unicode_ci,
  `total_positive_reviews` smallint(5) unsigned DEFAULT NULL,
  `total_negative_reviews` smallint(5) unsigned DEFAULT NULL,
  `hits` mediumint(8) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,'Logitech MX Master 3S','Logitech','Computer Accessories','Mice & Keyboards','https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=20&page={$page}&sortBy=date&sortDir=desc		',NULL,'Great mouse.  It is comfortable to use and responsive.  I previously used the Apple mouse, and found this to be an improvement.',NULL,NULL,NULL,NULL,NULL,NULL,'2023-03-25 21:04:20','2023-03-25 21:04:20');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-25 19:06:46
