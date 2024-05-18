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
-- Table structure for table `staking__packages`
--

DROP TABLE IF EXISTS `staking__packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `staking__packages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `currency_stake_id` int unsigned NOT NULL,
  `currency_reward_id` int unsigned NOT NULL,
  `min_stake` double NOT NULL,
  `max_stake` double NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `principal_is_stake_currency` tinyint(1) DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `hour_reward` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `staking__packages_currency_stake_id_foreign` (`currency_stake_id`),
  KEY `staking__packages_currency_reward_id_foreign` (`currency_reward_id`),
  CONSTRAINT `staking__packages_currency_reward_id_foreign` FOREIGN KEY (`currency_reward_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `staking__packages_currency_stake_id_foreign` FOREIGN KEY (`currency_stake_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staking__packages`
--

LOCK TABLES `staking__packages` WRITE;
/*!40000 ALTER TABLE `staking__packages` DISABLE KEYS */;
INSERT INTO `staking__packages` VALUES (1,1,2,100,101,'2024-01-11 00:00:00','2025-01-11 00:00:00',0,1,'2024-01-11 00:07:13','2024-01-11 01:24:18','2024-01-11 01:24:18',24);
/*!40000 ALTER TABLE `staking__packages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:46
