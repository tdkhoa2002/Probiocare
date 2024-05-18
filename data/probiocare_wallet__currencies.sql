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
-- Table structure for table `wallet__currencies`
--

DROP TABLE IF EXISTS `wallet__currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet__currencies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_crawl` double DEFAULT '0',
  `transfer_fee` double DEFAULT '0',
  `transfer_fee_type` int DEFAULT '0',
  `swap_enable` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `swap_fee` double DEFAULT '0',
  `swap_fee_type` double DEFAULT '0',
  `min_swap` double DEFAULT '0',
  `max_swap` double DEFAULT '0',
  `usd_rate` double DEFAULT '0',
  `link_rate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_supply` double DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet__currencies`
--

LOCK TABLES `wallet__currencies` WRITE;
/*!40000 ALTER TABLE `wallet__currencies` DISABLE KEYS */;
INSERT INTO `wallet__currencies` VALUES (1,'USD','United States Dollar','CRYPTO',0,0,0,NULL,0,0,10,10000000,1,NULL,0,0,'2024-01-10 23:58:13','2024-01-11 01:06:12',NULL),(2,'PLC','Probiocare Loyalty Credit','CRYPTO',0,0,0,'[4]',0,0,10,10000000,1,NULL,0,1,'2024-01-11 00:00:24','2024-01-11 01:06:39',NULL),(3,'PCT','Probiocare Token','CRYPTO',0,0,0,'[4]',0,0,10,1000000,1,NULL,0,1,'2024-01-11 00:01:56','2024-01-24 23:48:11',NULL),(4,'USDt','United States Dollar token','CRYPTO',0,0,0,'[3,2]',0,0,0,0,1,NULL,0,1,'2024-01-11 01:04:58','2024-01-11 01:12:57',NULL),(5,'BNB','BNB','CRYPTO',0,0,0,NULL,0,0,10,100000000,320,NULL,0,1,'2024-01-15 22:33:37','2024-01-15 22:33:37',NULL),(6,'ABC','ABC','CRYPTO',0,0,0,NULL,0,0,0,0,1,NULL,0,0,'2024-01-24 02:00:45','2024-04-25 00:16:04',NULL);
/*!40000 ALTER TABLE `wallet__currencies` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:47
