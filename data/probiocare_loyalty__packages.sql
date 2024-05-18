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
-- Table structure for table `loyalty__packages`
--

DROP TABLE IF EXISTS `loyalty__packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loyalty__packages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency_stake_id` int unsigned NOT NULL,
  `currency_reward_id` int unsigned NOT NULL,
  `min_stake` double NOT NULL,
  `max_stake` double NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `principal_is_stake_currency` tinyint(1) DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `hour_reward` int DEFAULT '1',
  `currency_cashback_id` int unsigned NOT NULL,
  `require_entry` tinyint(1) NOT NULL DEFAULT '0',
  `term_matching` int NOT NULL DEFAULT '0',
  `principal_convert_rate` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `loyalty__packages_currency_stake_id_foreign` (`currency_stake_id`),
  KEY `loyalty__packages_currency_reward_id_foreign` (`currency_reward_id`),
  KEY `loyalty__packages_currency_cashback_id_foreign` (`currency_cashback_id`),
  CONSTRAINT `loyalty__packages_currency_cashback_id_foreign` FOREIGN KEY (`currency_cashback_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loyalty__packages_currency_reward_id_foreign` FOREIGN KEY (`currency_reward_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loyalty__packages_currency_stake_id_foreign` FOREIGN KEY (`currency_stake_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loyalty__packages`
--

LOCK TABLES `loyalty__packages` WRITE;
/*!40000 ALTER TABLE `loyalty__packages` DISABLE KEYS */;
INSERT INTO `loyalty__packages` VALUES (1,'2024-01-25 02:03:20','2024-01-25 02:10:08',4,2,100,100,'2024-01-25 00:00:00','2025-01-25 00:00:00',0,1,'2024-01-25 02:10:08',24,3,0,1,0),(2,'2024-01-25 02:05:51','2024-01-25 02:10:10',4,2,100,100,'2024-01-25 00:00:00','2025-01-25 00:00:00',0,1,'2024-01-25 02:10:10',24,3,0,1,0),(3,'2024-01-25 02:05:59','2024-01-25 02:10:12',4,2,100,100,'2024-01-25 00:00:00','2025-01-25 00:00:00',0,1,'2024-01-25 02:10:12',24,3,0,1,0),(4,'2024-01-25 02:06:19','2024-01-25 02:10:14',4,2,100,100,'2024-01-25 00:00:00','2025-01-25 00:00:00',0,1,'2024-01-25 02:10:14',24,3,0,1,0),(5,'2024-01-25 02:09:06','2024-01-25 02:42:16',4,2,100,100,'2024-01-25 00:00:00','2025-01-25 00:00:00',0,1,NULL,24,3,0,1,110),(6,'2024-05-13 03:20:22','2024-05-13 03:20:22',4,2,500,500,'2024-05-13 00:00:00','2025-05-13 00:00:00',1,1,NULL,24,3,1,1,110);
/*!40000 ALTER TABLE `loyalty__packages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:41
