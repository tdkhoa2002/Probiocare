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
-- Table structure for table `media__files`
--

DROP TABLE IF EXISTS `media__files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media__files` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `is_folder` tinyint(1) NOT NULL DEFAULT '0',
  `filename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mimetype` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filesize` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media__files`
--

LOCK TABLES `media__files` WRITE;
/*!40000 ALTER TABLE `media__files` DISABLE KEYS */;
INSERT INTO `media__files` VALUES (1,0,'tether.png','/assets/media/tether.png','png','image/png','277315','0','2024-01-10 23:58:10','2024-01-10 23:58:10'),(2,0,'fdsf1-1.png','/assets/media/fdsf1-1.png','png','image/png','1488','0','2024-01-11 00:00:19','2024-01-11 00:00:19'),(3,0,'jl-1.png','/assets/media/jl-1.png','png','image/png','2015','0','2024-01-11 00:01:51','2024-01-11 00:01:51'),(4,0,'icon-starter-package.png','/assets/media/icon-starter-package.png','png','image/png','16039','0','2024-01-15 21:34:04','2024-01-15 21:34:04'),(5,0,'download.png','/assets/media/download.png','png','image/png','3258','0','2024-01-15 22:33:07','2024-01-15 22:33:07'),(6,0,'promotions-auto-nuoc-tay-trang-bioderma-danh-cho-da-nhay-cam-500ml-u9gpv85v68pok5k9-img-358x358-843626-fit-center.png','/assets/media/promotions-auto-nuoc-tay-trang-bioderma-danh-cho-da-nhay-cam-500ml-u9gpv85v68pok5k9-img-358x358-843626-fit-center.png','png','image/png','63385','0','2024-04-01 20:27:46','2024-04-01 20:27:46'),(7,0,'facebook-dynamic-422211183-1696227431-img-358x358-843626-fit-center.png','/assets/media/facebook-dynamic-422211183-1696227431-img-358x358-843626-fit-center.png','png','image/png','63314','0','2024-04-01 20:39:04','2024-04-01 20:39:04'),(8,0,'untitled.png','/assets/media/untitled.png','png','image/png','365378','0','2024-05-13 01:51:40','2024-05-13 01:51:40'),(9,0,'product2.png','/assets/media/product2.png','png','image/png','129794','0','2024-05-13 01:57:25','2024-05-13 01:57:25'),(10,0,'product3.png','/assets/media/product3.png','png','image/png','142718','0','2024-05-13 02:00:27','2024-05-13 02:00:27'),(11,0,'product4.png','/assets/media/product4.png','png','image/png','115114','0','2024-05-13 02:04:44','2024-05-13 02:04:44'),(12,0,'product5.png','/assets/media/product5.png','png','image/png','322698','0','2024-05-13 02:12:12','2024-05-13 02:12:12'),(13,0,'product6.png','/assets/media/product6.png','png','image/png','312383','0','2024-05-13 02:14:56','2024-05-13 02:14:56'),(14,0,'logo-paypal.png','/assets/media/logo-paypal.png','png','image/png','7649','0','2024-05-13 03:22:10','2024-05-13 03:22:10'),(15,0,'logo-metamask.png','/assets/media/logo-metamask.png','png','image/png','133166','0','2024-05-13 03:22:48','2024-05-13 03:22:48'),(16,0,'frame-1321316482.png','/assets/media/frame-1321316482.png','png','image/png','3562','0','2024-05-13 04:10:03','2024-05-13 04:10:03');
/*!40000 ALTER TABLE `media__files` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:49
