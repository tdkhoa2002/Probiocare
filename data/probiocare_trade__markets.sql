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
-- Table structure for table `trade__markets`
--

DROP TABLE IF EXISTS `trade__markets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trade__markets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` int unsigned NOT NULL,
  `currency_pair_id` int unsigned NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'spot',
  `taker` double DEFAULT '0',
  `maker` double DEFAULT '0',
  `min_amount` double DEFAULT '0',
  `max_amount` double DEFAULT '0',
  `price` double DEFAULT '0',
  `price_usd` double DEFAULT '0',
  `price_change_24h` double DEFAULT '0',
  `hight_24h` double DEFAULT '0',
  `low_24h` double DEFAULT '0',
  `volume_24h` double DEFAULT '0',
  `volume_pair_24h` double DEFAULT '0',
  `service_base_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_base_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_quote_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_quote_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_customer_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trade__markets_currency_id_foreign` (`currency_id`),
  KEY `trade__markets_currency_pair_id_foreign` (`currency_pair_id`),
  CONSTRAINT `trade__markets_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `trade__markets_currency_pair_id_foreign` FOREIGN KEY (`currency_pair_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trade__markets`
--

LOCK TABLES `trade__markets` WRITE;
/*!40000 ALTER TABLE `trade__markets` DISABLE KEYS */;
/*!40000 ALTER TABLE `trade__markets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:40
