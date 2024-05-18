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
-- Table structure for table `wallet__wallets`
--

DROP TABLE IF EXISTS `wallet__wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet__wallets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int unsigned NOT NULL,
  `currency_id` int unsigned NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `onhold` double DEFAULT '0',
  `balance` double DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet__wallets_customer_id_foreign` (`customer_id`),
  KEY `wallet__wallets_currency_id_foreign` (`currency_id`),
  CONSTRAINT `wallet__wallets_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wallet__wallets_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer__customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet__wallets`
--

LOCK TABLES `wallet__wallets` WRITE;
/*!40000 ALTER TABLE `wallet__wallets` DISABLE KEYS */;
INSERT INTO `wallet__wallets` VALUES (1,1,2,'CRYPTO',0,72643.689726027,1,'2024-01-11 01:11:20','2024-05-13 03:14:21',NULL),(2,1,4,'CRYPTO',0,1774434.7925,1,'2024-01-11 01:11:29','2024-05-13 03:14:21',NULL),(3,1,3,'CRYPTO',0,130.74,1,'2024-01-12 00:49:52','2024-01-24 23:49:14',NULL),(4,2,4,'CRYPTO',0,13948.229,1,'2024-01-16 01:19:40','2024-01-25 00:27:18',NULL),(5,2,2,'CRYPTO',0,5185,1,'2024-01-16 01:28:18','2024-01-25 00:27:18',NULL),(6,3,4,'CRYPTO',0,416168.1455,1,'2024-01-16 20:18:41','2024-01-19 01:10:26',NULL),(7,3,2,'CRYPTO',0,46410,1,'2024-01-16 20:27:01','2024-01-17 21:23:09',NULL),(8,2,3,'CRYPTO',0,10.2195,1,'2024-01-17 18:56:55','2024-01-19 01:10:26',NULL),(9,3,3,'CRYPTO',0,206.145,1,'2024-01-17 18:59:42','2024-01-19 00:56:21',NULL),(10,4,4,'CRYPTO',0,9985474.02,1,'2024-01-19 01:00:06','2024-01-19 02:26:31',NULL),(11,4,2,'CRYPTO',0,9988270.2,1,'2024-01-19 01:00:43','2024-01-19 02:21:22',NULL),(12,4,3,'CRYPTO',0,32.67,1,'2024-01-19 01:10:26','2024-01-19 01:10:26',NULL),(13,5,4,'CRYPTO',0,99995698,1,'2024-01-19 02:22:54','2024-01-19 02:27:16',NULL),(14,5,2,'CRYPTO',0,5547.6,1,'2024-01-19 02:23:26','2024-01-19 02:27:16',NULL),(15,1,5,'CRYPTO',0,32,1,'2024-01-23 00:54:48','2024-01-23 20:56:34',NULL),(16,1,1,'CRYPTO',0,23,1,'2024-01-24 23:45:30','2024-01-24 23:45:30',NULL);
/*!40000 ALTER TABLE `wallet__wallets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:42
