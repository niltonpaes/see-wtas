CREATE DATABASE  IF NOT EXISTS `seewtas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `seewtas`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: localhost    Database: seewtas
-- ------------------------------------------------------
-- Server version	5.7.24

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
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `total_pros` smallint(5) unsigned DEFAULT NULL,
  `total_cons` smallint(5) unsigned DEFAULT NULL,
  `hits` mediumint(8) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`index`),
  UNIQUE KEY `path_UNIQUE` (`path`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,'logitech-mx-master-3s','Logitech MX Master 3S','Logitech','Computer Accessories','Mice & Keyboards','https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=20&page={$page}&sortBy=date&sortDir=desc		',NULL,'Great mouse.  It is comfortable to use and responsive.  I previously used the Apple mouse, and found this to be an improvement.',NULL,'{\"summaryPros\": [  \"Ergonomic design for comfortable long-term use\",  \"Smooth and responsive scrolling\",  \"Customizable buttons and controls\",  \"Multi-device connectivity for seamless switching\",  \"Quiet and smooth clicking for office settings\",  \"High precision and control for productivity\",  \"Customizable for gaming with great functionality\",  \"Ultrafast scrolling for efficient navigation\",  \"Exceptional long-term quality for durability\",  \"Silent buttons for peaceful work environments\",  \"Great for hand relaxation and fitting nicely in the hand\",  \"Incredible comfort and usability\",  \"Notched and endless vertical scrolling for flexibility\",  \"Works on any surface for accessibility\",  \"Improves productivity with intuitive button layout\",  \"Great for navigating large spreadsheets and programming buttons\",  \"Terrific battery life for extended use\",  \"Improved DPI sensor for accuracy\",  \"Reduced clicking noise for silent operation\",  \"Easy to use and switch between laptops\"]}','{\"summaryCons\": [  \"Quality control issues\",  \"White color model turns yellow after a few uses\",  \"Software slows down side scrolling\",  \"No spot to store USB receiver in mouse\",  \"Lack of onboard memory\",  \"May have connectivity issues\",  \"Pricey\",  \"Back button placement takes getting used to\",  \"Dependent on installing Logi Options+ app\",  \"Scrolling issues\",  \"Bulkiness might not be for everyone\",  \"Might be too sensitive at times\",  \"Expensive\",  \"Some may find it too large for their hands\",  \"Scroll wheel not as convenient as cheaper models\",  \"Mouse needs to be reset often\",  \"Issues with scrolling detection\",  \"Sensitivity issues on Chromebooks\",  \"Compatibility issues with Apple devices\",  \"Latency not suitable for gaming\"]}',376,73,NULL,'2023-03-25 21:04:20','2023-03-25 21:04:20');
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

-- Dump completed on 2023-03-27 23:37:58
