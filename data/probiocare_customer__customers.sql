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
-- Table structure for table `customer__customers`
--

DROP TABLE IF EXISTS `customer__customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer__customers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gg_auth` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_gg_auth` tinyint DEFAULT '0',
  `status_kyc` tinyint DEFAULT '0',
  `sponsor_id` int unsigned DEFAULT NULL,
  `sponsor_floor` int DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_agent` tinyint NOT NULL DEFAULT '0',
  `term_matching` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer__customers`
--

LOCK TABLES `customer__customers` WRITE;
/*!40000 ALTER TABLE `customer__customers` DISABLE KEYS */;
INSERT INTO `customer__customers` VALUES (1,'tdkhoa1101@gmail.com','$2y$10$gT9.x7Mb4vg8fE4w10V2huoLAwmUzJdlcnxJ5bgPoQFwnV//Tz5Qq','J1KN45ZBLC',NULL,0,0,NULL,0,1,NULL,'2024-01-11 01:00:18','2024-01-25 00:13:31',NULL,0,7),(2,'khoatran03091406@gmail.com','$2y$10$2e7Vdli0TIXn4ab8FQk0SeBSVf1UdDy.mDr8L/67x05fsN38YSMQW','FDCSOQMKZW',NULL,0,0,1,1,1,NULL,'2024-01-16 01:18:44','2024-01-25 00:27:18',NULL,0,8),(3,'deekayytb@gmail.com','$2y$10$oqaztwmuhAiaxV3gwuyIIO1cMhbFeaQZmNGRgpP3e5vidaamS5IO.','FID9MQPGR0',NULL,0,0,2,2,1,NULL,'2024-01-16 20:03:17','2024-01-16 20:13:03',NULL,0,0),(4,'tdkhoa1102@gmail.com','$2y$10$atf2/eXlpEXQSB5nsYSU6OIVr8c0ZF6.HH/Ylr6rZp5fVArvP5CU.','ONG7M2AQ0P',NULL,0,0,3,3,1,NULL,'2024-01-19 00:59:11','2024-05-14 09:28:55','2024-05-14 09:28:55',0,0),(5,'tdkhoa1103@gmail.com','$2y$10$UFsM0LWVSWMrUeK1nfuMyO4cCvHJw0GBxvJp/Z6qnVqKeOyFtkgNO','QE9N1ZPKOT',NULL,0,0,4,4,1,NULL,'2024-01-19 02:22:37','2024-05-14 09:28:58','2024-05-14 09:28:58',0,0),(6,'2051052065khoa@ou.edu.vn','$2y$10$v3TeXOKThn.Hjt3.sIPc6OdhfCptnbE3MWx01ITr3xNIbLbwzo65q','MPEAD715NK',NULL,0,0,NULL,0,1,NULL,'2024-05-09 01:55:37','2024-05-09 01:56:46',NULL,0,0);
/*!40000 ALTER TABLE `customer__customers` ENABLE KEYS */;
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
