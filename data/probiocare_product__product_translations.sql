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
-- Table structure for table `product__product_translations`
--

DROP TABLE IF EXISTS `product__product_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product__product_translations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumary` text COLLATE utf8mb4_unicode_ci,
  `product_info` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int unsigned NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product__product_translations_product_id_locale_unique` (`product_id`,`locale`),
  KEY `product__product_translations_locale_index` (`locale`),
  CONSTRAINT `product__product_translations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product__products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product__product_translations`
--

LOCK TABLES `product__product_translations` WRITE;
/*!40000 ALTER TABLE `product__product_translations` DISABLE KEYS */;
INSERT INTO `product__product_translations` VALUES (3,'California Gold Nutrition, Omega-3 Premium Fish Oil, 100 Fish Gelatin Softgels','california-gold-nutrition-omega-3-premium-fish-oil-100-fish-gelatin-softgels','California Gold Nutrition, Omega-3 Premium Fish Oil, 100 Fish Gelatin Softgels','<ul>\n	<li>100% Authentic!&nbsp;</li>\n	<li>Best By: 08/2025&nbsp;</li>\n	<li>First Available:&nbsp;10/2014</li>\n	<li>Shipping Weight:&nbsp;&nbsp;0.18 kg&nbsp;</li>\n	<li>Product Code:&nbsp;MLI-00952</li>\n	<li>UPC Code:&nbsp;898220009527</li>\n	<li>Package Quantity:&nbsp;100 Count</li>\n	<li>Dimensions:&nbsp;11.2 x 6.6 x 6.4 cm&nbsp;,&nbsp;0.18 kg</li>\n	<li>\n	<p><strong><a href=\"https://s3.images-iherb.com/cms/CGN-00952.jpg\" rel=\"noopener noreferrer\" target=\"_blank\"><u>iTested Verified</u></a></strong></p>\n\n	<p><strong>Try Risk-Free for 90 Days.</strong>&nbsp;</p>\n	</li>\n</ul>',NULL,NULL,NULL,NULL,NULL,NULL,3,'en'),(4,'California Gold Nutrition, Gold C, USP Grade Vitamin C, 1,000 mg, 60 Veggie Capsules','california-gold-nutrition-gold-c-usp-grade-vitamin-c-1-000-mg-60-veggie-capsules','California Gold Nutrition, Gold C, USP Grade Vitamin C, 1,000 mg, 60 Veggie Capsules','<p>100% Authentic!&nbsp;<br />\nBest By: 02/2027&nbsp;<br />\nFirst Available: 10/2014<br />\nShipping Weight: &nbsp;0.09 kg&nbsp;<br />\nProduct Code: CGN-00931<br />\nUPC Code: 898220009312<br />\nPackage Quantity: 60 Count<br />\nDimensions: 9.7 x 5.1 x 5.1 cm , 0.09 kg<br />\niTested Verified<br />\nTry Risk-Free for 90 Days.&nbsp;</p>',NULL,NULL,NULL,NULL,NULL,NULL,4,'en'),(5,'Mielle, Scalp & Hair Strengthening Oil, Rosemary Mint, 2 fl oz (59 ml)','mielle-scalp-hair-strengthening-oil-rosemary-mint-2-fl-oz-59-ml','Mielle, Scalp & Hair Strengthening Oil, Rosemary Mint, 2 fl oz (59 ml)','<ul>\n	<li>100% Authentic!&nbsp;</li>\n	<li>Best By: 01/2027&nbsp;</li>\n	<li>First Available:&nbsp;10/2021</li>\n	<li>Shipping Weight:&nbsp;&nbsp;0.12 kg&nbsp;</li>\n	<li>Product Code:&nbsp;MIE-00673</li>\n	<li>UPC Code:&nbsp;854102006732</li>\n	<li>Package Quantity:&nbsp;59.147 ml</li>\n	<li>Dimensions:&nbsp;11.8 x 3.8 x 3.8 cm&nbsp;,&nbsp;0.12 kg</li>\n</ul>',NULL,NULL,NULL,NULL,NULL,NULL,5,'en'),(6,'NOW Foods, Solutions, XyliWhite, Toothpaste Gel, Refreshmint, 6.4 oz (181 g)','now-foods-solutions-xyliwhite-toothpaste-gel-refreshmint-64-oz-181-g','NOW Foods, Solutions, XyliWhite, Toothpaste Gel, Refreshmint, 6.4 oz (181 g)','<ul>\n	<li>100% Authentic!&nbsp;</li>\n	<li>Best By: 10/2026&nbsp;</li>\n	<li>First Available:&nbsp;06/2007</li>\n	<li>Shipping Weight:&nbsp;&nbsp;0.2 kg&nbsp;</li>\n	<li>Product Code:&nbsp;NOW-08090</li>\n	<li>UPC Code:&nbsp;733739080905</li>\n	<li>Package Quantity:&nbsp;181.437 g</li>\n	<li>Dimensions:&nbsp;20.3 x 4.8 x 4.8 cm&nbsp;,&nbsp;0.2 kg</li>\n</ul>',NULL,NULL,NULL,NULL,NULL,NULL,6,'en'),(7,'California Gold Nutrition, Sport, Creatine Monohydrate, Unflavored, 1 lb (454 g)','california-gold-nutrition-sport-creatine-monohydrate-unflavored-1-lb-454-g','California Gold Nutrition, Sport, Creatine Monohydrate, Unflavored, 1 lb (454 g)','<ul>\n	<li>100% Authentic!&nbsp;</li>\n	<li>Best By: 03/2026&nbsp;</li>\n	<li>First Available:&nbsp;11/2016</li>\n	<li>Shipping Weight:&nbsp;&nbsp;0.57 kg&nbsp;</li>\n	<li>Product Code:&nbsp;CGN-01059</li>\n	<li>UPC Code:&nbsp;898220010592</li>\n	<li>Package Quantity:&nbsp;453.592 g</li>\n	<li>Dimensions:&nbsp;13 x 12.4 x 12.2 cm&nbsp;,&nbsp;0.57 kg</li>\n	<li>\n	<p><a href=\"https://s3.images-iherb.com/cms/CGN-01059%20%283%29.jpg\" rel=\"noopener noreferrer\" target=\"_blank\"><strong>iTested Verified</strong></a></p>\n\n	<p><strong>Try Risk-Free for 90 Days.</strong>&nbsp;</p>\n\n	<p>&nbsp;</p>\n	</li>\n</ul>',NULL,NULL,NULL,NULL,NULL,NULL,7,'en'),(8,'EVLution Nutrition, CREATINE5000, Unflavored, 10.58 oz (300 g)','evlution-nutrition-creatine5000-unflavored-1058-oz-300-g','EVLution Nutrition, CREATINE5000, Unflavored, 10.58 oz (300 g)','<ul>\n	<li>100% Authentic!&nbsp;</li>\n	<li>Best By: 01/2026&nbsp;</li>\n	<li>First Available:&nbsp;07/2018</li>\n	<li>Shipping Weight:&nbsp;&nbsp;0.36 kg&nbsp;</li>\n	<li>Product Code:&nbsp;EVL-24065</li>\n	<li>UPC Code:&nbsp;852665240655</li>\n	<li>Package Quantity:&nbsp;299.938 g</li>\n	<li>Dimensions:&nbsp;10.9 x 9.4 x 9.4 cm&nbsp;,&nbsp;0.36 kg</li>\n</ul>',NULL,NULL,NULL,NULL,NULL,NULL,8,'en');
/*!40000 ALTER TABLE `product__product_translations` ENABLE KEYS */;
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
