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
-- Table structure for table `customer__countries`
--

DROP TABLE IF EXISTS `customer__countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer__countries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer__countries`
--

LOCK TABLES `customer__countries` WRITE;
/*!40000 ALTER TABLE `customer__countries` DISABLE KEYS */;
INSERT INTO `customer__countries` VALUES (1,'US','United States',NULL,NULL),(2,'CA','Canada',NULL,NULL),(3,'AF','Afghanistan',NULL,NULL),(4,'AL','Albania',NULL,NULL),(5,'DZ','Algeria',NULL,NULL),(6,'AS','American Samoa',NULL,NULL),(7,'AD','Andorra',NULL,NULL),(8,'AO','Angola',NULL,NULL),(9,'AI','Anguilla',NULL,NULL),(10,'AQ','Antarctica',NULL,NULL),(11,'AG','Antigua and/or Barbuda',NULL,NULL),(12,'AR','Argentina',NULL,NULL),(13,'AM','Armenia',NULL,NULL),(14,'AW','Aruba',NULL,NULL),(15,'AU','Australia',NULL,NULL),(16,'AT','Austria',NULL,NULL),(17,'AZ','Azerbaijan',NULL,NULL),(18,'BS','Bahamas',NULL,NULL),(19,'BH','Bahrain',NULL,NULL),(20,'BD','Bangladesh',NULL,NULL),(21,'BB','Barbados',NULL,NULL),(22,'BY','Belarus',NULL,NULL),(23,'BE','Belgium',NULL,NULL),(24,'BZ','Belize',NULL,NULL),(25,'BJ','Benin',NULL,NULL),(26,'BM','Bermuda',NULL,NULL),(27,'BT','Bhutan',NULL,NULL),(28,'BO','Bolivia',NULL,NULL),(29,'BA','Bosnia and Herzegovina',NULL,NULL),(30,'BW','Botswana',NULL,NULL),(31,'BV','Bouvet Island',NULL,NULL),(32,'BR','Brazil',NULL,NULL),(33,'IO','British lndian Ocean Territory',NULL,NULL),(34,'BN','Brunei Darussalam',NULL,NULL),(35,'BG','Bulgaria',NULL,NULL),(36,'BF','Burkina Faso',NULL,NULL),(37,'BI','Burundi',NULL,NULL),(38,'KH','Cambodia',NULL,NULL),(39,'CM','Cameroon',NULL,NULL),(40,'CV','Cape Verde',NULL,NULL),(41,'KY','Cayman Islands',NULL,NULL),(42,'CF','Central African Republic',NULL,NULL),(43,'TD','Chad',NULL,NULL),(44,'CL','Chile',NULL,NULL),(45,'CN','China',NULL,NULL),(46,'CX','Christmas Island',NULL,NULL),(47,'CC','Cocos (Keeling) Islands',NULL,NULL),(48,'CO','Colombia',NULL,NULL),(49,'KM','Comoros',NULL,NULL),(50,'CG','Congo',NULL,NULL),(51,'CK','Cook Islands',NULL,NULL),(52,'CR','Costa Rica',NULL,NULL),(53,'HR','Croatia (Hrvatska)',NULL,NULL),(54,'CU','Cuba',NULL,NULL),(55,'CY','Cyprus',NULL,NULL),(56,'CZ','Czech Republic',NULL,NULL),(57,'CD','Democratic Republic of Congo',NULL,NULL),(58,'DK','Denmark',NULL,NULL),(59,'DJ','Djibouti',NULL,NULL),(60,'DM','Dominica',NULL,NULL),(61,'DO','Dominican Republic',NULL,NULL),(62,'TP','East Timor',NULL,NULL),(63,'EC','Ecudaor',NULL,NULL),(64,'EG','Egypt',NULL,NULL),(65,'SV','El Salvador',NULL,NULL),(66,'GQ','Equatorial Guinea',NULL,NULL),(67,'ER','Eritrea',NULL,NULL),(68,'EE','Estonia',NULL,NULL),(69,'ET','Ethiopia',NULL,NULL),(70,'FK','Falkland Islands (Malvinas)',NULL,NULL),(71,'FO','Faroe Islands',NULL,NULL),(72,'FJ','Fiji',NULL,NULL),(73,'FI','Finland',NULL,NULL),(74,'FR','France',NULL,NULL),(75,'FX','France, Metropolitan',NULL,NULL),(76,'GF','French Guiana',NULL,NULL),(77,'PF','French Polynesia',NULL,NULL),(78,'TF','French Southern Territories',NULL,NULL),(79,'GA','Gabon',NULL,NULL),(80,'GM','Gambia',NULL,NULL),(81,'GE','Georgia',NULL,NULL),(82,'DE','Germany',NULL,NULL),(83,'GH','Ghana',NULL,NULL),(84,'GI','Gibraltar',NULL,NULL),(85,'GR','Greece',NULL,NULL),(86,'GL','Greenland',NULL,NULL),(87,'GD','Grenada',NULL,NULL),(88,'GP','Guadeloupe',NULL,NULL),(89,'GU','Guam',NULL,NULL),(90,'GT','Guatemala',NULL,NULL),(91,'GN','Guinea',NULL,NULL),(92,'GW','Guinea-Bissau',NULL,NULL),(93,'GY','Guyana',NULL,NULL),(94,'HT','Haiti',NULL,NULL),(95,'HM','Heard and Mc Donald Islands',NULL,NULL),(96,'HN','Honduras',NULL,NULL),(97,'HK','Hong Kong',NULL,NULL),(98,'HU','Hungary',NULL,NULL),(99,'IS','Iceland',NULL,NULL),(100,'IN','India',NULL,NULL),(101,'ID','Indonesia',NULL,NULL),(102,'IR','Iran (Islamic Republic of)',NULL,NULL),(103,'IQ','Iraq',NULL,NULL),(104,'IE','Ireland',NULL,NULL),(105,'IL','Israel',NULL,NULL),(106,'IT','Italy',NULL,NULL),(107,'CI','Ivory Coast',NULL,NULL),(108,'JM','Jamaica',NULL,NULL),(109,'JP','Japan',NULL,NULL),(110,'JO','Jordan',NULL,NULL),(111,'KZ','Kazakhstan',NULL,NULL),(112,'KE','Kenya',NULL,NULL),(113,'KI','Kiribati',NULL,NULL),(114,'KP','Korea, Democratic People\'s Republic of',NULL,NULL),(115,'KR','Korea, Republic of',NULL,NULL),(116,'KW','Kuwait',NULL,NULL),(117,'KG','Kyrgyzstan',NULL,NULL),(118,'LA','Lao People\'s Democratic Republic',NULL,NULL),(119,'LV','Latvia',NULL,NULL),(120,'LB','Lebanon',NULL,NULL),(121,'LS','Lesotho',NULL,NULL),(122,'LR','Liberia',NULL,NULL),(123,'LY','Libyan Arab Jamahiriya',NULL,NULL),(124,'LI','Liechtenstein',NULL,NULL),(125,'LT','Lithuania',NULL,NULL),(126,'LU','Luxembourg',NULL,NULL),(127,'MO','Macau',NULL,NULL),(128,'MK','Macedonia',NULL,NULL),(129,'MG','Madagascar',NULL,NULL),(130,'MW','Malawi',NULL,NULL),(131,'MY','Malaysia',NULL,NULL),(132,'MV','Maldives',NULL,NULL),(133,'ML','Mali',NULL,NULL),(134,'MT','Malta',NULL,NULL),(135,'MH','Marshall Islands',NULL,NULL),(136,'MQ','Martinique',NULL,NULL),(137,'MR','Mauritania',NULL,NULL),(138,'MU','Mauritius',NULL,NULL),(139,'TY','Mayotte',NULL,NULL),(140,'MX','Mexico',NULL,NULL),(141,'FM','Micronesia, Federated States of',NULL,NULL),(142,'MD','Moldova, Republic of',NULL,NULL),(143,'MC','Monaco',NULL,NULL),(144,'MN','Mongolia',NULL,NULL),(145,'MS','Montserrat',NULL,NULL),(146,'MA','Morocco',NULL,NULL),(147,'MZ','Mozambique',NULL,NULL),(148,'MM','Myanmar',NULL,NULL),(149,'NA','Namibia',NULL,NULL),(150,'NR','Nauru',NULL,NULL),(151,'NP','Nepal',NULL,NULL),(152,'NL','Netherlands',NULL,NULL),(153,'AN','Netherlands Antilles',NULL,NULL),(154,'NC','New Caledonia',NULL,NULL),(155,'NZ','New Zealand',NULL,NULL),(156,'NI','Nicaragua',NULL,NULL),(157,'NE','Niger',NULL,NULL),(158,'NG','Nigeria',NULL,NULL),(159,'NU','Niue',NULL,NULL),(160,'NF','Norfork Island',NULL,NULL),(161,'MP','Northern Mariana Islands',NULL,NULL),(162,'NO','Norway',NULL,NULL),(163,'OM','Oman',NULL,NULL),(164,'PK','Pakistan',NULL,NULL),(165,'PW','Palau',NULL,NULL),(166,'PA','Panama',NULL,NULL),(167,'PG','Papua New Guinea',NULL,NULL),(168,'PY','Paraguay',NULL,NULL),(169,'PE','Peru',NULL,NULL),(170,'PH','Philippines',NULL,NULL),(171,'PN','Pitcairn',NULL,NULL),(172,'PL','Poland',NULL,NULL),(173,'PT','Portugal',NULL,NULL),(174,'PR','Puerto Rico',NULL,NULL),(175,'QA','Qatar',NULL,NULL),(176,'SS','Republic of South Sudan',NULL,NULL),(177,'RE','Reunion',NULL,NULL),(178,'RO','Romania',NULL,NULL),(179,'RU','Russian Federation',NULL,NULL),(180,'RW','Rwanda',NULL,NULL),(181,'KN','Saint Kitts and Nevis',NULL,NULL),(182,'LC','Saint Lucia',NULL,NULL),(183,'VC','Saint Vincent and the Grenadines',NULL,NULL),(184,'WS','Samoa',NULL,NULL),(185,'SM','San Marino',NULL,NULL),(186,'ST','Sao Tome and Principe',NULL,NULL),(187,'SA','Saudi Arabia',NULL,NULL),(188,'SN','Senegal',NULL,NULL),(189,'RS','Serbia',NULL,NULL),(190,'SC','Seychelles',NULL,NULL),(191,'SL','Sierra Leone',NULL,NULL),(192,'SG','Singapore',NULL,NULL),(193,'SK','Slovakia',NULL,NULL),(194,'SI','Slovenia',NULL,NULL),(195,'SB','Solomon Islands',NULL,NULL),(196,'SO','Somalia',NULL,NULL),(197,'ZA','South Africa',NULL,NULL),(198,'GS','South Georgia South Sandwich Islands',NULL,NULL),(199,'ES','Spain',NULL,NULL),(200,'LK','Sri Lanka',NULL,NULL),(201,'SH','St. Helena',NULL,NULL),(202,'PM','St. Pierre and Miquelon',NULL,NULL),(203,'SD','Sudan',NULL,NULL),(204,'SR','Suriname',NULL,NULL),(205,'SJ','Svalbarn and Jan Mayen Islands',NULL,NULL),(206,'SZ','Swaziland',NULL,NULL),(207,'SE','Sweden',NULL,NULL),(208,'CH','Switzerland',NULL,NULL),(209,'SY','Syrian Arab Republic',NULL,NULL),(210,'TW','Taiwan',NULL,NULL),(211,'TJ','Tajikistan',NULL,NULL),(212,'TZ','Tanzania, United Republic of',NULL,NULL),(213,'TH','Thailand',NULL,NULL),(214,'TG','Togo',NULL,NULL),(215,'TK','Tokelau',NULL,NULL),(216,'TO','Tonga',NULL,NULL),(217,'TT','Trinidad and Tobago',NULL,NULL),(218,'TN','Tunisia',NULL,NULL),(219,'TR','Turkey',NULL,NULL),(220,'TM','Turkmenistan',NULL,NULL),(221,'TC','Turks and Caicos Islands',NULL,NULL),(222,'TV','Tuvalu',NULL,NULL),(223,'UG','Uganda',NULL,NULL),(224,'UA','Ukraine',NULL,NULL),(225,'AE','United Arab Emirates',NULL,NULL),(226,'GB','United Kingdom',NULL,NULL),(227,'UM','United States minor outlying islands',NULL,NULL),(228,'UY','Uruguay',NULL,NULL),(229,'UZ','Uzbekistan',NULL,NULL),(230,'VU','Vanuatu',NULL,NULL),(231,'VA','Vatican City State',NULL,NULL),(232,'VE','Venezuela',NULL,NULL),(233,'VN','Vietnam',NULL,NULL),(234,'VG','Virgin Islands (British)',NULL,NULL),(235,'VI','Virgin Islands (U.S.)',NULL,NULL),(236,'WF','Wallis and Futuna Islands',NULL,NULL),(237,'EH','Western Sahara',NULL,NULL),(238,'YE','Yemen',NULL,NULL),(239,'YU','Yugoslavia',NULL,NULL),(240,'ZR','Zaire',NULL,NULL),(241,'ZM','Zambia',NULL,NULL),(242,'ZW','Zimbabwe',NULL,NULL);
/*!40000 ALTER TABLE `customer__countries` ENABLE KEYS */;
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
