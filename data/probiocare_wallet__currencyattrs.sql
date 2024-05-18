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
-- Table structure for table `wallet__currencyattrs`
--

DROP TABLE IF EXISTS `wallet__currencyattrs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet__currencyattrs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `blockchain_id` int unsigned NOT NULL,
  `currency_id` int unsigned NOT NULL,
  `token_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abi` longtext COLLATE utf8mb4_unicode_ci,
  `native_token` int DEFAULT NULL,
  `decimal` int NOT NULL,
  `withdraw_fee_token` double DEFAULT '0',
  `withdraw_fee_token_type` tinyint DEFAULT '0',
  `withdraw_fee_chain` double DEFAULT '0',
  `value_need_approve` double DEFAULT '0',
  `value_need_approve_currency` int DEFAULT '0',
  `max_amount_withdraw_daily` double DEFAULT '0',
  `max_amount_withdraw_daily_currency` int DEFAULT '0',
  `max_times_withdraw` int DEFAULT '0',
  `min_withdraw` double DEFAULT '0',
  `max_withdraw` double DEFAULT '0',
  `type_withdraw` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ONCHAIN',
  `type_deposit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ONCHAIN',
  `type_transfer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ONCHAIN',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet__currencyattrs_blockchain_id_foreign` (`blockchain_id`),
  KEY `wallet__currencyattrs_currency_id_foreign` (`currency_id`),
  CONSTRAINT `wallet__currencyattrs_blockchain_id_foreign` FOREIGN KEY (`blockchain_id`) REFERENCES `wallet__blockchains` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wallet__currencyattrs_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `wallet__currencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet__currencyattrs`
--

LOCK TABLES `wallet__currencyattrs` WRITE;
/*!40000 ALTER TABLE `wallet__currencyattrs` DISABLE KEYS */;
INSERT INTO `wallet__currencyattrs` VALUES (1,1,1,'0xdac17f958d2ee523a2206206994597c13d831ec7',NULL,NULL,0,0,0,0,0,NULL,0,NULL,0,0,0,'ONCHAIN','ONCHAIN','INTERNAL_TRANSFER',1,'2024-01-10 23:58:47','2024-01-10 23:58:47',NULL),(2,2,2,'0x071a5B1451c55153Df15243d0Ff64c8078F75E46',NULL,2,0,0,0,0,0,NULL,0,NULL,0,0,0,'ONCHAIN','ONCHAIN','INTERNAL_TRANSFER',1,'2024-01-11 00:01:07','2024-01-22 19:43:06',NULL),(3,1,3,'0x071a5B1451c55153Df15243d0Ff64c8078F75E46',NULL,3,18,0,0,0,0,NULL,0,NULL,0,0,0,'ONCHAIN','ONCHAIN','INTERNAL_TRANSFER',1,'2024-01-11 00:02:25','2024-01-11 00:02:25',NULL),(4,1,4,'0xdac17f958d2ee523a2206206994597c13d831ec7',NULL,1,18,0,0,0,0,NULL,0,NULL,0,0,0,'ONCHAIN','ONCHAIN','INTERNAL_TRANSFER',1,'2024-01-11 01:05:43','2024-01-11 01:05:43',NULL),(5,2,4,'0x071a5B1451c55153Df15243d0Ff64c8078F75E46',NULL,4,0,0,0,0,0,NULL,0,NULL,0,0,0,'ONCHAIN','ONCHAIN','INTERNAL_TRANSFER',1,'2024-01-24 00:18:29','2024-01-24 00:18:29',NULL),(6,1,2,'0x071a5B1451c55153Df15243d0Ff64c8078F75E46',NULL,2,0,0,0,0,0,NULL,0,NULL,0,0,0,'ONCHAIN','ONCHAIN','INTERNAL_TRANSFER',1,'2024-01-24 00:28:01','2024-01-24 00:28:01',NULL),(7,3,4,'0xD484bCDe100862849800ef8549BAFA23A88e47d5',NULL,5,18,0,0,0,0,NULL,0,NULL,0,0,0,'ONCHAIN','ONCHAIN','INTERNAL_TRANSFER',1,'2024-04-25 00:19:08','2024-04-25 00:19:08',NULL);
/*!40000 ALTER TABLE `wallet__currencyattrs` ENABLE KEYS */;
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
