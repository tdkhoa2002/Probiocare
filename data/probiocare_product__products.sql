-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: probiocare
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `product__products`
--

DROP TABLE IF EXISTS `product__products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product__products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_sold` int DEFAULT '0',
  `show_homepage` tinyint(1) NOT NULL DEFAULT '0',
  `is_best_selling` tinyint(1) NOT NULL DEFAULT '0',
  `is_new_arrivals` tinyint(1) NOT NULL DEFAULT '0',
  `is_best_choice` tinyint(1) NOT NULL DEFAULT '0',
  `is_promotion` tinyint(1) NOT NULL DEFAULT '0',
  `product_status` tinyint DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `price_sale` double NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price_member` double DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product__products_category_id_foreign` (`category_id`),
  CONSTRAINT `product__products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product__categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product__products`
--

LOCK TABLES `product__products` WRITE;
/*!40000 ALTER TABLE `product__products` DISABLE KEYS */;
INSERT INTO `product__products` VALUES (3,4,'P001',0,1,1,1,0,0,2,307,307,1,'2024-05-13 01:52:58','2024-05-13 02:09:09',153),(4,4,'P002',0,1,1,1,0,0,2,144,144,1,'2024-05-13 01:58:35','2024-05-13 01:58:35',144),(5,10,'P003',0,1,1,1,0,0,2,330,0,1,'2024-05-13 02:00:32','2024-05-13 02:06:31',0),(6,10,'P004',0,1,1,1,0,0,1,148,0,1,'2024-05-13 02:05:43','2024-05-13 02:06:21',0),(7,2,'P005',2,1,1,1,0,0,2,412,737,1,'2024-05-13 02:12:17','2024-05-13 04:58:14',0),(8,2,'P006',4,1,1,1,0,0,1,476,0,1,'2024-05-13 02:14:38','2024-05-13 04:58:14',0);
/*!40000 ALTER TABLE `product__products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:43
