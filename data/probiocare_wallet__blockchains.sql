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
-- Table structure for table `wallet__blockchains`
--

DROP TABLE IF EXISTS `wallet__blockchains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet__blockchains` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rpc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chainid` int NOT NULL,
  `wallet_receive` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet__blockchains`
--

LOCK TABLES `wallet__blockchains` WRITE;
/*!40000 ALTER TABLE `wallet__blockchains` DISABLE KEYS */;
INSERT INTO `wallet__blockchains` VALUES (1,'ETH','Ethereum Mainet','https://api.zmok.io/mainnet/oaen6dy8ff6hju9k','https://etherscan.io/','ETH','ETHEREUM',1,'0x071a5B1451c55153Df15243d0Ff64c8078F75E46',1,'2024-01-10 23:57:23','2024-01-10 23:57:23',NULL),(2,'BEP20','BSC chain','https://bsc-dataseed1.defibit.io/','https://bscscan.com/','BNB','ETHEREUM',56,'0x071a5B1451c55153Df15243d0Ff64c8078F75E46',1,'2024-01-22 19:41:37','2024-01-22 19:41:37',NULL),(3,'BSC Testnet','Smart Chain - Testnet','https://data-seed-prebsc-1-s1.binance.org:8545/','https://testnet.bscscan.com','BNB','ETHEREUM',97,'0x63df2c1f265B5873976f115b7dB6e63f7354eD22',1,'2024-04-25 00:15:33','2024-04-25 00:15:33',NULL);
/*!40000 ALTER TABLE `wallet__blockchains` ENABLE KEYS */;
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
