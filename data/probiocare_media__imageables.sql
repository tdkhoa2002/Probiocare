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
-- Table structure for table `media__imageables`
--

DROP TABLE IF EXISTS `media__imageables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media__imageables` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `file_id` int NOT NULL,
  `imageable_id` int NOT NULL,
  `imageable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media__imageables`
--

LOCK TABLES `media__imageables` WRITE;
/*!40000 ALTER TABLE `media__imageables` DISABLE KEYS */;
INSERT INTO `media__imageables` VALUES (1,1,1,'Modules\\Wallet\\Entities\\Currency','CURRENCY_ICON',NULL,'2024-01-10 23:58:13','2024-01-10 23:58:13'),(2,2,2,'Modules\\Wallet\\Entities\\Currency','CURRENCY_ICON',NULL,'2024-01-11 00:00:24','2024-01-11 01:06:39'),(3,3,3,'Modules\\Wallet\\Entities\\Currency','CURRENCY_ICON',NULL,'2024-01-11 00:01:56','2024-01-24 23:48:11'),(4,1,4,'Modules\\Wallet\\Entities\\Currency','CURRENCY_ICON',NULL,'2024-01-11 01:04:58','2024-01-11 01:12:57'),(5,5,5,'Modules\\Wallet\\Entities\\Currency','CURRENCY_ICON',NULL,'2024-01-15 22:33:37','2024-01-15 22:33:37'),(6,4,6,'Modules\\Wallet\\Entities\\Currency','CURRENCY_ICON',NULL,'2024-01-24 02:00:46','2024-01-24 02:00:46'),(7,4,25,'Modules\\Loyalty\\Entities\\Package','PACKAGE_ICON',NULL,'2024-01-24 02:12:48','2024-01-24 02:12:48'),(8,4,1,'Modules\\Loyalty\\Entities\\Package','PACKAGE_ICON',NULL,'2024-01-24 02:15:58','2024-01-25 00:20:04'),(9,3,2,'Modules\\Loyalty\\Entities\\Package','PACKAGE_ICON',NULL,'2024-01-24 02:18:13','2024-01-25 00:20:14'),(10,4,26,'Modules\\Loyalty\\Entities\\Package','PACKAGE_ICON',NULL,'2024-01-24 20:47:02','2024-01-24 20:47:02'),(11,4,5,'Modules\\Loyalty\\Entities\\Package','PACKAGE_ICON',NULL,'2024-01-25 02:09:06','2024-01-25 02:42:16'),(12,6,1,'Modules\\Product\\Entities\\Product','avatar',NULL,'2024-04-01 20:31:46','2024-05-08 02:08:00'),(13,7,2,'Modules\\Product\\Entities\\Product','avatar',NULL,'2024-04-01 20:39:08','2024-05-08 02:08:31'),(14,8,3,'Modules\\Product\\Entities\\Product','avatar',NULL,'2024-05-13 01:52:58','2024-05-13 02:09:09'),(15,9,4,'Modules\\Product\\Entities\\Product','avatar',NULL,'2024-05-13 01:58:35','2024-05-13 01:58:35'),(16,10,5,'Modules\\Product\\Entities\\Product','avatar',NULL,'2024-05-13 02:00:32','2024-05-13 02:06:31'),(17,11,6,'Modules\\Product\\Entities\\Product','avatar',NULL,'2024-05-13 02:05:43','2024-05-13 02:06:21'),(18,12,7,'Modules\\Product\\Entities\\Product','avatar',NULL,'2024-05-13 02:12:17','2024-05-13 02:12:37'),(19,13,8,'Modules\\Product\\Entities\\Product','avatar',NULL,'2024-05-13 02:15:02','2024-05-13 02:32:51'),(20,3,6,'Modules\\Loyalty\\Entities\\Package','PACKAGE_ICON',NULL,'2024-05-13 03:20:22','2024-05-13 03:20:22'),(21,14,1,'Modules\\Customer\\Entities\\PaymentMethod','PAYMEN_METHOD_LOGO',NULL,'2024-05-13 03:22:15','2024-05-13 03:22:15'),(22,15,2,'Modules\\Customer\\Entities\\PaymentMethod','PAYMEN_METHOD_LOGO',NULL,'2024-05-13 03:22:53','2024-05-13 03:22:53'),(23,4,8,'Modules\\Setting\\Entities\\Setting','core::logo',NULL,'2024-05-13 04:11:23','2024-05-13 04:11:23');
/*!40000 ALTER TABLE `media__imageables` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:45
