CREATE DATABASE  IF NOT EXISTS `seewtas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `seewtas`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: seewtas
-- ------------------------------------------------------
-- Server version	8.0.30

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
  `index` bigint unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_bestbuy` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_amazon` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_review_bestbuy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_review_amazon` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pros` json DEFAULT NULL,
  `cons` json DEFAULT NULL,
  `pros_total` smallint unsigned DEFAULT NULL,
  `cons_total` smallint unsigned DEFAULT NULL,
  `hits` mediumint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,'logitech-mx-master-3s','https://multimedia.bbycastatic.ca/multimedia/products/500x500/161/16157/16157519.jpg','Logitech MX Master 3S','Logitech','Computer Accessories','Mice & Keyboards','https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc',NULL,NULL,NULL,'{\"pros\": [\"Comfortable and customizable mouse with great functionality\", \"Smooth, accurate and quiet clicking for increased productivity\", \"Exceptional battery life and can connect up to three devices at once\", \"Great feel in the hand and fits well like a glove\", \"Improved design over Apple mouse and best mouse owned in 40 years\", \"Perfect for designers and drafting programs with accurate sensor\", \"Two scroll wheels and customizable buttons for fast and easy use\"]}','{\"cons\": [\"Quality control issues\", \"White model turns yellow after use\", \"Great product, highly recommend!\", \"Works exactly as advertised.\", \"Very easy to install and use.\", \"Excellent value for the price.\", \"Sturdy and well-made.\", \"Compact and portable design.\", \"Customer service is top-notch.\", \"Versatile and multi-functional.\", \"Saves a lot of time and effort.\", \"Durable and long-lasting.\", \"Good instructions and user manual.\", \"Great for beginners and experts alike.\", \"Adjustable settings for maximum control.\", \"Efficient and time-saving.\", \"Quiet and low-maintenance.\", \"Affordable and budget-friendly.\", \"Improves productivity and workflow.\", \"Easy to clean and maintain.\"]}',26,2,NULL,'2023-03-29 03:23:28','2023-03-29 03:23:28','active'),(2,'dyson-v8-animal-cordless-stick-vacuum','https://multimedia.bbycastatic.ca/multimedia/products/500x500/152/15265/15265629.jpg','Dyson V8 Animal Cordless Stick Vacuum','Dyson','Vacuums & Floor Care','Stick Vacuums','https://www.bestbuy.ca/api/reviews/v2/products/15265629/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc',NULL,NULL,NULL,'{\"pros\": [\"Powerful vacuum\", \"Easy to clean\", \"Helpful accessories\", \"Lightweight\", \"Rarely have to drag out full sized Dyson\", \"Exactly as described\", \"Great for people with bad hands\", \"Cordless feature is convenient\", \"Sale price was good\", \"Good suction power\", \"Great for quick cleanups\", \"Good for pet hair\", \"Easy to set up\", \"Works well\", \"Good for small spaces\", \"Picks up hair easily\", \"Great solution for pet hair\", \"Vacuums well\", \"Compact size\", \"Charges quickly\"]}','{\"cons\": [\"Rollers died after one year\", \"Hair gets caught inside the side with bearings\", \"Short battery life\", \"Takes a long time to recharge\", \"Cannot recommend it yet\", \"Indeterminate performance\", \"Burnt hair smell\", \"Issues with carpets and picking up everything\", \"Expensive and short-lived\", \"May require unclogging or multiple vacuums for different purposes\", \"High intensity function wears out quickly\", \"Battery may be defective\", \"May need to purchase a commercial vacuum instead\"]}',18,4,NULL,'2023-03-29 03:23:28','2023-03-29 03:23:28','active'),(3,'logitech-mx-master-3s',NULL,'Logitech MX Master 3S','Logitech','Computer Accessories','Mice & Keyboards','https://www.bestbuy.ca/api/reviews/v2/products/16157519/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-03-29 03:23:28','2023-03-29 03:23:28',NULL),(4,'dyson-v8-animal-cordless-stick-vacuum',NULL,'Dyson V8 Animal Cordless Stick Vacuum','Dyson','Vacuums & Floor Care','Stick Vacuums','https://www.bestbuy.ca/api/reviews/v2/products/15265629/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-03-29 03:23:28','2023-03-29 03:23:28',NULL),(5,'logitech-studio-desk-mat ','https://multimedia.bbycastatic.ca/multimedia/products/500x500/157/15766/15766138.jpg','Logitech Studio Desk Mat','Logitech','Computer Accessories','Mice & Keyboards','https://www.bestbuy.ca/api/reviews/v2/products/15766138/reviews?source=all&lang=en-CA&pageSize=10&page=%s&sortBy=date&sortDir=desc',NULL,NULL,NULL,'{\"pros\": [\"Protects desk from scratches and stains\", \"Fits under the computer, and ample room to use the mouse\", \"Mouse glides over it effortlessly\", \"Great for my laptop and monitor set up\", \"Simple design\", \"Nice color\", \"Large size\", \"Feels great\", \"Works exactly as described\", \"Good looking\", \"Quality materials\", \"Great price\", \"Nice quality\", \"Helpful for mouse and keyboard\", \"Non-slip\", \"Water-resistant\", \"Well made\", \"Lays flat\", \"Perfect for small desks\", \"Easy to clean\"]}','{\"cons\": [\"Product is small in size\", \"Quality of the product can be improved\"]}',26,2,NULL,'2023-04-02 04:12:31','2023-04-02 04:12:31','active');
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

-- Dump completed on 2023-04-02 11:52:11
