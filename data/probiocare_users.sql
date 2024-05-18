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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'tdkhoa1101@gmail.com','$2y$10$L.SC6.wdXu4uER5beSvc5.yBpkO41hBiYIUm9iK2oVfKX9KYBDjvu','{\"affiliate.affiliates.index\":true,\"affiliate.affiliates.create\":true,\"affiliate.affiliates.edit\":true,\"affiliate.affiliates.destroy\":true,\"core.sidebar.group\":true,\"customer.customers.index\":true,\"customer.customers.create\":true,\"customer.customers.edit\":true,\"customer.customers.destroy\":true,\"customer.paymentmethods.index\":true,\"customer.paymentmethods.create\":true,\"customer.paymentmethods.edit\":true,\"customer.paymentmethods.destroy\":true,\"customer.wallets.index\":true,\"customer.wallets.create\":true,\"customer.wallets.edit\":true,\"customer.wallets.destroy\":true,\"customer.transactions.add_balance\":true,\"customer.transactions.sub_balance\":true,\"dashboard.index\":true,\"dashboard.update\":true,\"dashboard.reset\":true,\"dynamicfield.dynamicfields.index\":true,\"dynamicfield.dynamicfields.create\":true,\"dynamicfield.dynamicfields.edit\":true,\"dynamicfield.dynamicfields.destroy\":true,\"logviewer.logviewers.index\":true,\"loyalty.packages.index\":true,\"loyalty.packages.create\":true,\"loyalty.packages.edit\":true,\"loyalty.packages.destroy\":true,\"loyalty.orders.index\":true,\"loyalty.orders.create\":true,\"loyalty.orders.edit\":true,\"loyalty.orders.destroy\":true,\"media.medias.index\":true,\"media.medias.create\":true,\"media.medias.edit\":true,\"media.medias.destroy\":true,\"media.folders.index\":true,\"media.folders.create\":true,\"media.folders.edit\":true,\"media.folders.destroy\":true,\"menu.menus.index\":true,\"menu.menus.create\":true,\"menu.menus.edit\":true,\"menu.menus.destroy\":true,\"menu.menuitems.index\":true,\"menu.menuitems.create\":true,\"menu.menuitems.edit\":true,\"menu.menuitems.destroy\":true,\"page.pages.index\":true,\"page.pages.create\":true,\"page.pages.edit\":true,\"page.pages.destroy\":true,\"post.posts.index\":true,\"post.posts.create\":true,\"post.posts.edit\":true,\"post.posts.destroy\":true,\"category.categories.index\":true,\"category.categories.create\":true,\"category.categories.edit\":true,\"category.categories.destroy\":true,\"product.categories.index\":true,\"product.categories.create\":true,\"product.categories.edit\":true,\"product.categories.destroy\":true,\"product.products.index\":true,\"product.products.create\":true,\"product.products.edit\":true,\"product.products.destroy\":true,\"setting.settings.index\":true,\"setting.settings.edit\":true,\"themeoption.themeoptions.index\":true,\"themeoption.themeoptions.edit\":true,\"shop.shops.index\":true,\"shop.shops.create\":true,\"shop.shops.edit\":true,\"shop.shops.destroy\":true,\"shoppingcart.orders.index\":true,\"shoppingcart.orders.edit\":true,\"shoppingcart.orders.destroy\":true,\"slider.sliders.index\":true,\"slider.sliders.create\":true,\"slider.sliders.edit\":true,\"slider.sliders.destroy\":true,\"slider.slides.create\":true,\"slider.slides.edit\":true,\"slider.slides.destroy\":true,\"tag.tags.index\":true,\"tag.tags.create\":true,\"tag.tags.edit\":true,\"tag.tags.destroy\":true,\"translation.translations.index\":true,\"translation.translations.edit\":true,\"translation.translations.import\":true,\"translation.translations.export\":true,\"user.users.index\":true,\"user.users.create\":true,\"user.users.edit\":true,\"user.users.destroy\":true,\"user.roles.index\":true,\"user.roles.create\":true,\"user.roles.edit\":true,\"user.roles.destroy\":true,\"account.api-keys.index\":true,\"account.api-keys.create\":true,\"account.api-keys.destroy\":true,\"wallet.blockchains.index\":true,\"wallet.blockchains.create\":true,\"wallet.blockchains.edit\":true,\"wallet.blockchains.destroy\":true,\"wallet.currencies.index\":true,\"wallet.currencies.create\":true,\"wallet.currencies.edit\":true,\"wallet.currencies.destroy\":true,\"wallet.currencyattrs.index\":true,\"wallet.currencyattrs.create\":true,\"wallet.currencyattrs.edit\":true,\"wallet.currencyattrs.destroy\":true,\"wallet.transactions.index\":true,\"wallet.transactions.create\":true,\"wallet.transactions.edit\":true,\"wallet.transactions.destroy\":true,\"wallet.transactions.resendWithdraw\":true,\"wallet.wallets.index\":true,\"wallet.wallets.create\":true,\"wallet.wallets.edit\":true,\"wallet.wallets.destroy\":true,\"wallet.chainwallets.index\":true,\"wallet.chainwallets.create\":true,\"wallet.chainwallets.edit\":true,\"wallet.chainwallets.destroy\":true,\"wallet.walletchains.index\":true,\"wallet.walletchains.create\":true,\"wallet.walletchains.edit\":true,\"wallet.walletchains.destroy\":true,\"wallet.transactioncodes.index\":true,\"wallet.transactioncodes.create\":true,\"wallet.transactioncodes.edit\":true,\"wallet.transactioncodes.destroy\":true,\"wallet.crawlhistories.index\":true,\"wallet.crawlhistories.crawl\":true,\"workshop.sidebar.group\":true,\"workshop.modules.index\":true,\"workshop.modules.show\":true,\"workshop.modules.update\":true,\"workshop.modules.disable\":true,\"workshop.modules.enable\":true,\"workshop.modules.publish\":true,\"workshop.themes.index\":true,\"workshop.themes.show\":true,\"workshop.themes.publish\":true}','2024-05-14 09:32:07','Tran','Khoa','2024-01-10 23:48:15','2024-05-14 09:32:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
