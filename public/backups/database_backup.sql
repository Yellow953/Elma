-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: stockify
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts_account_number_unique` (`account_number`),
  KEY `accounts_currency_id_foreign` (`currency_id`),
  CONSTRAINT `accounts_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=393 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'0000-1010-000000','CAPITAL','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(2,'0000-1011-000000','Subscribed Un-Called Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(3,'0000-1012-000000','Subscribed Called and Unpaid Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(4,'0000-1013-000000','Subscribed Called and Paid-Up Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(5,'0000-1020-000000','CAPITAL PREMIUMS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(6,'0000-1021-000000','Issuance Premiums','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(7,'0000-1022-000000','Merger Premiums','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(8,'0000-1023-000000','Contributions Premiums','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(9,'0000-1024-000000','Conversion Premium of Bonds to Shares ','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(10,'0000-1030-000000','REVALUATION VARIANCES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(11,'0000-1031-000000','Non-Amortizable Assets Reval. Variances','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(12,'0000-1035-000000','Amortizable Assets Reval. Variances','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(13,'0000-1090-000000','OWNER\'S CURRENT ACCOUNT','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(14,'0000-1110-000000','LEGAL RESERVE','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(15,'0000-1120-000000','STATUTORY AND CONTRACTUAL RESERVES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(16,'0000-1190-000000','OTHER RESERVES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(17,'0000-1210-000000','BROUGHT FORWARD RESULTS - PROFITS ','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(18,'0000-1250-000000','BROUGHT FORWARD RESULTS - LOSSES ','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(19,'0000-1300-000000','Current Period Net Result - Profit / (Loss)','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(20,'0000-1380-000000','CURRENT YEAR RESULT - PROFITS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(21,'0000-1390-000000','CURRENT YEAR RESULT - LOSSES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(22,'0000-1410-000000','INVESTMENT SUBSIDIES RECEIVED','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(23,'0000-1450-000000','INVEST. SUBSIDIES TRANSFERED TO RESULTS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(24,'0000-1510-000000','Provisions for Risks','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(25,'0000-1511-000000','Provisions for Litigations & Alike','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(26,'0000-1512-000000','Provisions against Guarantees Given','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(27,'0000-1513-000000','Provisions for Losses on Exchange','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(28,'0000-1514-000000','Provis. for Losses on Term Contracts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(29,'0000-1515-000000','Provisions for Fines & Penalties','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(30,'0000-1516-000000','Provisions for Financial Risks','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(31,'0000-1517-000000','Provisions for Extraordinary Prices Fall','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(32,'0000-1518-000000','Provisions for Non-Oper. Risks & Charges','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(33,'0000-1550-000000','Provisions for Charges','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(34,'0000-1551-000000','Provisions for Deferred Charges','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(35,'0000-1553-000000','Provision for Taxes (Other than Income Tax)','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(36,'0000-1610-000000','LONG TERM LOANS AGAINST BONDS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(37,'0000-1620-000000','LONG TERM LOANS FROM BANKS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(38,'0000-1680-000000','SUNDRY LONG & MED. TERM LOANS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(39,'0000-1810-000000','INTERCOMPANIES & INTERBRANCHES ACCOUNTS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(40,'0000-1860-000000','Interbranches Exchanges - Charges','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(41,'0000-1870-000000','Interbranches Exchanges - Revenues','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(42,'0000-2110-000000','BUSINESS CONCERN','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(43,'0000-2120-000000','FORMATION EXPENSES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(44,'0000-2130-000000','RESEARCH & DEVELOPMENT EXPENSES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(45,'0000-2140-000000','PATENTS, LICENSES, TRADE MARKS & ALIKE','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(46,'0000-2190-000000','OTHER INTANGIBLE FIXED ASSETS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(47,'0000-2210-000000','LANDS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(48,'0000-2211-000000','Virgin Lands - Basic Cost','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(49,'0000-2212-000000','Built-on Properties - Basic Cost','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(50,'0000-2213-000000','Extractive Lands - Basic Cost','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(51,'0000-2214-000000','Landscaping Cost','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(52,'0000-2230-000000','BUILDINGS & CONSTRUCTIONS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(53,'0000-2231-000000','Buildings - Basic Cost','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(54,'0000-2232-000000','Building Installations & Improvem\'ts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(55,'0000-2233-000000','Infra-structure Constructions','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(56,'0000-2234-000000','Constructions on Other Owners\' Lands','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(57,'0000-2240-000000','TECH. INSTALL., MACHINERY & EQUIPMENT','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(58,'0000-2241-000000','Specialized Technical Installations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(59,'0000-2242-000000','Specific Technical Installations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(60,'0000-2243-000000','Industrial Machinery & Equipment','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(61,'0000-2244-000000','Industrial Tools','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(62,'0000-2245-000000','Hotels & Retaurants Appliances','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(63,'0000-2250-000000','VEHICLES AND HANDLING EQUIPMENT','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(64,'0000-2251-000000','Passenger Vehicles','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(65,'0000-2252-000000','Transport Vehicles & Handling Equipment','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(66,'0000-2253-000000','Maritime Tranport Means','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(67,'0000-2254-000000','Air Transport Means','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(68,'0000-2260-000000','OTHER TANGIBLE FIXED ASSETS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(69,'0000-2261-000000','Internal Install. Decor & Improvements','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(70,'0000-2262-000000','Office & Computer Equipment','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(71,'0000-2263-000000','Furnitures, Fixtures & Accessories','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(72,'0000-2264-000000','Agricultural Installations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(73,'0000-2265-000000','Re-usable Containers','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(74,'0000-2270-000000','TANGIBLE FIXED ASSETS IN PROGRESS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(75,'0000-2271-000000','Lands under Acquisition','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(76,'0000-2273-000000','Buildings under Construction','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(77,'0000-2274-000000','Industrial Equipment under Installation','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(78,'0000-2276-000000','Other Tangible Fixed Assets in Progress','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(79,'0000-2280-000000','Advances/Purchase Of Fixed Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(80,'0000-2510-000000','Equity Participations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(81,'0000-2520-000000','Receivables Related To Participations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(82,'0000-2530-000000','OTHER SECURITIES & FINANCIAL ASSETS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(83,'0000-2531-000000','Ownership Deeds (Shares & Parts)','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(84,'0000-2535-000000','Credit Deeds (Bonds & Coupons)','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(85,'0000-2550-000000','LONG AND MEDIUM TERM GRANTED LOANS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(86,'0000-2551-000000','Loans to Partners/Affiliates - Non-Current Part','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(87,'0000-2552-000000','Loans to Employees - Non-Current Part','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(88,'0000-2558-000000','Other Long & Medium Term Loans','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(89,'0000-2590-000000','Other Long & Med.Term Receivables','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(90,'0000-2700-000000','FIXED ASSETS NON-AMORT. REVAL. VARIANCES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(91,'0000-2701-000000','Intang. Fixed Assets Non-Amort. Reval. Variances','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(92,'0000-2702-000000','Tangib. Fixed Assets Non-Amort. Reval. Variances','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(93,'0000-2705-000000','Financ. Fixed Assets Non-Amort. Reval. Variances','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(94,'0000-2800-000000','Amortization of Business Concern','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(95,'0000-2810-000000','Intangible Assets Amortizations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(96,'0000-2811-000000','Amortiz.of Formation Expenses','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(97,'0000-2812-000000','Amortiz.of Research & Develop. Expenses','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(98,'0000-2813-000000','Amortiz.of Patents, Licenses, Trade Marks, etc..','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(99,'0000-2819-000000','Amortiz.of Other Intang. Fixed Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(100,'0000-2820-000000','Tangible Assets Depreciations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(101,'0000-2821-000000','Deprec.of Extractive Lands & Landscaping','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(102,'0000-2823-000000','Deprec. of Buildings & Equipments','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(103,'0000-2824-000000','Deprec. Machinery & Equipment','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(104,'0000-2825-000000','Deprec.of Passenger & Transport Vehicles','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(105,'0000-2826-000000','Deprec.of Other Tangible Fixed Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(106,'0000-2910-000000','Devaluation Prov. of Intangible Fixed Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(107,'0000-2911-000000','Deval. Prov. for Patents, Trade Marks & Alike','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(108,'0000-2919-000000','Deval. Prov. for Other Intang. Fixed Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(109,'0000-2920-000000','Devaluation Prov. of Tangible Fixed Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(110,'0000-2921-000000','Virgin Land Devaluation Provision','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(111,'0000-2923-000000','Buildings Devaluation Provision','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(112,'0000-2926-000000','Deval. Prov. for Other Tangib. F. Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(113,'0000-2950-000000','Devaluation Prov. of Financial Fixed Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(114,'0000-2951-000000','Deval. Prov. for Equity Participations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(115,'0000-2952-000000','Deval. Prov. for  Participations\' Receiv.','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(116,'0000-2953-000000','Deval. Prov. for Other Securities & Fin. Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(117,'0000-2955-000000','Deval. Prov. for Long & Medium Term Loan','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(118,'0000-2959-000000','Deval. Prov. for Other Blocked Fin. Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(119,'0000-3110-000000','STOCK OF RAW MATERIALS & CONSUMABLES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(120,'0000-3150-000000','Inventory - Other Cons. Materials & Supplies','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(121,'0000-3310-000000','STOCK OF GOODS, WORKS & SERV. IN PROGRESS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(122,'0000-3320-000000','Inventory - Work in Progress','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(123,'0000-3350-000000','Inventory - Studies in Progress','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(124,'0000-3360-000000','Inventory - Services to Provide','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(125,'0000-3510-000000','STOCK OF MANUFACTURED PRODUCTS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(126,'0000-3550-000000','Inventory - Finished Products','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(127,'0000-3580-000000','Inventory - Production Waste','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(128,'0000-3700-000000','STOCK OF GOODS FOR SALE','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(129,'0000-3910-000000','DEVAL.PROV. FOR RAW & OTHER MAT. STOCK ','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(130,'0000-3930-000000','DEVAL.PROV. FOR PRODUCTS IN PROCESS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(131,'0000-3950-000000','DEVAL.PROV. FOR PRODUCTS STOCK','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(132,'0000-3970-000000','DEVAL.PROV. FOR GOODS FOR SALE STOCK','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(133,'0000-4010-000000','Suppliers - Creditor Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(134,'0000-4011-000000','Suppliers - Invoices Payable','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(135,'0000-4015-000000','Suppliers - Notes Payable ','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(136,'0000-4018-000000','Suppliers - Invoices Not Received','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(137,'0000-4019-000000','Discounts Obtained from Suppliers','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(138,'0000-4030-000000','Fixed Assets Suppliers','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(139,'0000-4031-000000','Fixed Assets Suppliers - Invoices Payable','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(140,'0000-4035-000000','Fixed Assets Suppliers - Notes Payable','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(141,'0000-4038-000000','F.Assets Suppliers - Invoices Not Received','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(142,'0000-4039-000000','Discounts Obtained from F.A. Suppliers','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(143,'0000-4090-000000','Advances to Suppliers','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(144,'0000-4091-000000','Advance Payments on Purchases','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(145,'0000-4092-000000','Materials Suppliers Accidentally Debtors','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(146,'0000-4093-000000','Fixed Assets Suppliers Accidentally Debtors','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(147,'0000-4110-000000','Customers - Debtors Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(148,'0000-4111-000000','Customers Receivables - Invoices','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(149,'0000-4115-000000','Doubtful Customers','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(150,'0000-4119-000000','Discounts Granted to Customers','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(151,'0000-4130-000000','CUSTOMERS RECEIVABLES - BILLS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(152,'0000-4150-000000','DUES FROM CUSTOMERS ON WORKS IN PROCESS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(153,'0000-4180-000000','DUES FROM CUSTOMERS ON INVOICES IN PROCESS','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(154,'0000-4190-000000','Advances Received on Sales Orders','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(155,'0000-4191-000000','Advances Received on Sales Orders','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(156,'0000-4192-000000','Customers Accidentally Creditors','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(157,'0000-4210-000000','PERSONNEL ACCOUNTS PAYABLE','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(158,'0000-4211-000000','Salaries and Wages due to Personnel','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(159,'0000-4219-000000','Other dues to Personnel','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(160,'0000-4280-000000','PERSONNEL ACCOUNTS RECEIVABLE','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(161,'0000-4281-000000','Loans to Personnel','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(162,'0000-4282-000000','Garnishments on Personnel Dues','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(163,'0000-4289-000000','Other Receivales from Personnel','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(164,'0000-4310-000000','Social Security Fund - Creditor Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(165,'0000-4311-000000','Social Security - Payable Dues','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(166,'0000-4315-000000','Social Security - Notes Payable','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(167,'0000-4318-000000','Social Security - Charges to be Accounted for','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(168,'0000-4380-000000','SOCIAL SECURITY RECEIVABLES','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(169,'0000-4410-000000','Taxes Due on Operations','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(170,'0000-4411-000000','Taxes & Duties (Except Income Tax)','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(171,'0000-4415-000000','Taxes & Duties - Notes Payable','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(172,'0000-4418-000000','Taxes & Duties - Charges to be Accounted for','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(173,'0000-4420-000000','Value Added Tax Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(174,'0000-4425-000000','Value Added Tax - Debtor / Creditor Balance','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(175,'0000-4427-000000','Value Added Tax - Collected on Revenues','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(176,'0000-4429-000000','Value Added Tax - Due for Refund','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(177,'0000-4430-000000','Non-Operational Tax','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(178,'0000-4431-000000','Income Tax on Net Operating Profits','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(179,'0000-4432-000000','Tax on F.Assets Disposal or Revaluation Profits','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(180,'0000-4435-000000','Taxes on Holding or Off-Shore Companies','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(181,'0000-4450-000000','Government & Public Services - Credit Acc.','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(182,'0000-4490-000000','Government & Public Services - Debit Acc.','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(183,'0000-4511-000000','Related Companies Debtor Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(184,'0000-4512-000000','Related Companies Creditor Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(185,'0000-4530-000000','DIVIDENDS PAYABLE','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(186,'0000-4550-000000','SHAREHOLDERS/PARTNERS PAYABLES ON CAPITAL','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(187,'0000-4551-000000','Shareholders/Partners - Contributions to the Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(188,'0000-4552-000000','Shareholders/Partners - Re-imbursment of the Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(189,'0000-4557-000000','Shareholders/Partners - Other Payables on Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(190,'0000-4590-000000','SHAREHOLDERS/PARTNERS RECEIVABLES ON CAPITAL','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(191,'0000-4591-000000','Shareholders - Subscribed/Un-Called Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(192,'0000-4592-000000','Shareholders - Subsc./Called/Unpaid Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(193,'0000-4597-000000','Shareholders/Partners - Other Receivables on Capital','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(194,'0000-4610-000000','Other Operating Creditors','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(195,'0000-4611-000000','Payables on Consignments','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(196,'0000-4619-000000','Other Operating Creditor Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(197,'0000-4630-000000','Payables on Financial Fixed Assets','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(198,'0000-4650-000000','Sundry Non-Operating Accounts Payable','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(199,'0000-4680-000000','Sundry Operating Debtors','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(200,'0000-4681-000000','Receivables on Consignments','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(201,'0000-4689-000000','Other Operating Debtor Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(202,'0000-4690-000000','Sundry Non-Operating Debtors','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(203,'0000-4691-000000','Receivables on Disposals of F. Assets & Finan.Deeds','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(204,'0000-4699-000000','Other Non-Operating Debtor Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(205,'0000-4710-000000','Charges Differred over Futur Periods','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(206,'0000-4711-000000','Pre-Operating Expenses','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(207,'0000-4712-000000','Major Repairs to be Amortized','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(208,'0000-4713-000000','Bonds Settlement Premium','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(209,'0000-4719-000000','Other Deferred Charges','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(210,'0000-4720-000000','Prepaid Charges','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(211,'0000-4730-000000','Accrued Income','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(212,'0000-4740-000000','Accrued Unpaid Charges','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(213,'0000-4750-000000','Exchange Difference - Liability','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(214,'0000-4760-000000','Exchange Difference - Asset','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(215,'0000-4810-000000','Pending & Regularization Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(216,'0000-4820-000000','Periodic Distribution of Revenues','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(217,'0000-4910-000000','Provisions for Customers Bad Debts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(218,'0000-4950-000000','Prov. for Shareholders/Partners Bad Debts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(219,'0000-4960-000000','Sundry Debtors Devaluation Provisions','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(220,'0000-4968-000000','Prov. for Other Operating Bad Debts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(221,'0000-4969-000000','Prov. for Other Non-Operating Bad Debts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(222,'0000-4980-000000','Bad Debts due to Bankrupcy','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(223,'0000-4981-000000','Prov. for Losses on Bankrupt Clients Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(224,'0000-4985-000000','Prov. for Losses on Bankrupt Partners Accounts','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(225,'0000-5010-000000','Transferable Participation Deeds','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(226,'0000-5020-000000','Bonds with Shares Acquisition Rights','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(227,'0000-5050-000000','Bond and Coupons Issued by the Company','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(228,'0000-5060-000000','Bonds with Creditors Rights','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(229,'0000-5110-000000','Cheques & Coupons under Collection','Balance Sheet',1,'2024-05-13 10:21:37','2024-05-13 10:21:37'),(230,'0000-5120-000000','Banks','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(231,'0000-5121-000000','Banks - Current Debtor Accounts','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(232,'0000-5122-000000','Banks - Facilities Accidentally Debtor','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(233,'0000-5123-000000','Banks - Term Deposits Accounts','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(234,'0000-5190-000000','Credit Establisments','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(235,'0000-5191-000000','Banks & Financial Establishments Facilities','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(236,'0000-5192-000000','Banks Current Accounts Accidentally Creditor','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(237,'0000-5300-000000','CASH ON HAND','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(238,'0000-5800-000000','INTERNAL TRANSFERS','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(239,'0000-5900-000000','Prov. for Devaluation of Participation Deeds','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(240,'0000-6010-000000','Purchase of Goods','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(241,'0000-6011-000000','Purchase of Goods','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(242,'0000-6012-000000','Purchase of  Packing Materials for Goods','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(243,'0000-6018-000000','Charges & Expenses on Goods Purchasing','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(244,'0000-6019-000000','Discounts Obtained on Purchased Goods','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(245,'0000-6050-000000','GOODS INVENTORY VARIANCE','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(246,'0000-6051-000000','Stock of Goods - Beg. of Period','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(247,'0000-6052-000000','Stock of Goods - End of Period','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(248,'0000-6110-000000','Purchases of Raw Materials & Consumables','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(249,'0000-6111-000000','Purchase of Raw Materials','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(250,'0000-6112-000000','Purchase of Manufacturing Consumables','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(251,'0000-6113-000000','Purchase of  Packing Materials for Products','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(252,'0000-6118-000000','Chgs & Exp. on R.M & Consum. Purchasing','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(253,'0000-6119-000000','Disc. Obtained on Purchased R.M & Consum.','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(254,'0000-6150-000000','RAW MAT. & CONSUM. INVENTORY VARIANCE','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(255,'0000-6151-000000','Stock of Raw & Other Mat. - Beg. of Period','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(256,'0000-6152-000000','Stock of Raw & Other Mat. - End of Period','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(257,'0000-6210-000000','Purchases from Sub-Contractors','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(258,'0000-6211-000000','Purchase of Works from Sub-Contractors','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(259,'0000-6212-000000','Purchase of Services from Sub-Contractors','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(260,'0000-6250-000000','Leasing, Patent Fees & Royalties','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(261,'0000-6260-000000','External Servises','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(262,'0000-6262-000000','Equip. Maintenance & Repair','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(263,'0000-6267-000000','RESEARCH & STUDIES FEES','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(264,'0000-6268-000000','Insurance Premium','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(265,'0000-6269-000000','Medical Care/advertisng/Financila chargges...','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(266,'0000-6310-000000','Salaries and Wages','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(267,'0000-6311-000000','Staff Salaries','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(268,'0000-6312-000000','Manpower Wages','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(269,'0000-6314-000000','Commissions Paid to Personnel','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(270,'0000-6316-000000','Partners/Managers Remunerations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(271,'0000-6317-000000','Directors Remunerations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(272,'0000-6350-000000','Social Charges (Social Security & Alike..)','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(273,'0000-6351-000000','Social Security FundContributions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(274,'0000-6355-000000','End of Service Indemnities Provisions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(275,'0000-6410-000000','Income Tax On Salaries & Wages','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(276,'0000-6420-000000','Municipal Taxes & Duties','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(277,'0000-6430-000000','Excise Tax','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(278,'0000-6440-000000','Registration & Notary Fees','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(279,'0000-6450-000000','Taxes, Dues & Alike, Including the Tax of Article 51 of law 497/2003','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(280,'0000-6451-000000','Tax of Article 51 of law 497/2003','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(281,'0000-6452-000000','Tax on Profits from F. Assets Disposal or Revaluation','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(282,'0000-6455-000000','Holding Taxes - on Capital and Services','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(283,'0000-6458-000000','Fiscal Fines','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(284,'0000-6459-000000','Other Taxes & Duties','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(285,'0000-6510-000000','Amortization & Depreciations Allocations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(286,'0000-6610-000000','Other Administratives Ordinary Charges','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(287,'0000-6611-000000','Directors Attendance Fees - Out of Profits','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(288,'0000-6612-000000','Losses on Bad Debts','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(289,'0000-6650-000000','Company Part in Losses on Joint Ventures','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(290,'0000-6730-000000','Interests and Similar Charges','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(291,'0000-6731-000000','Interest Due on Payables and Loans','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(292,'0000-6736-000000','Interest Due to Banks & Financial Estab.','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(293,'0000-6739-000000','Bank Commissions & Other Charges','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(294,'0000-6750-000000','Difference of Exchange - Negative','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(295,'0000-6751-000000','Exchange Losses on Current Operations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(296,'0000-6752-000000','Exchange Losses on Capital Expenditures','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(297,'0000-6760-000000','Net Charges on Disposal of Securities','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(298,'0000-6790-000000','Provisions For Deval. Of Financial Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(299,'0000-6791-000000','Amortiz.Alloc. of Reimbursement Premiums','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(300,'0000-6792-000000','Prov.Alloc.for Financial Assets Devaluation','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(301,'0000-6794-000000','Prov.Alloc.for Devaluation of Participations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(302,'0000-6795-000000','Prov.Alloc.for Financial Risks & Charges','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(303,'0000-6810-000000','Net Book Value of Disposed Fixed Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(304,'0000-6811-000000','Book Value of Intang. Assets Disposed of','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(305,'0000-6812-000000','Book Value of Tangible Assets Disposed of','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(306,'0000-6815-000000','Book Value of Financial Assets Disposed of','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(307,'0000-6850-000000','Other Non-Operating Charges','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(308,'0000-6855-000000','Charges on CapitalOperations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(309,'0000-6880-000000','Charges On Extra-Ordinary Events','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(310,'0000-6890-000000','Non Oper\'tg Depreciations & Provisions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(311,'0000-6891-000000','Alloc. for Extra-ordinary Deprec.of F.Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(312,'0000-6892-000000','Prov.Alloc. for Exceptional Depreciations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(313,'0000-6895-000000','Prov.Alloc. for Non-Operat\'g Risks & Charges','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(314,'0000-6900-000000','Taxes on Profits','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(315,'0000-6901-000000','Income Tax on Net Operating Profits','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(316,'0000-7010-000000','Sales of Goods','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(317,'0000-7090-000000','Discounts/Allowances/Returned Goods','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(318,'0000-7110-000000','Sales of Products','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(319,'0000-7111-000000','Sales of Finished Products','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(320,'0000-7112-000000','Sales of Semi-Finished Products','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(321,'0000-7113-000000','Sales of Production Scrap','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(322,'0000-7120-000000','Sales of Works','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(323,'0000-7130-000000','Sales of Services','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(324,'0000-7170-000000','Revenues of Subsidiary Activities','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(325,'0000-7171-000000','Revenues of Sub. Activities - Products','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(326,'0000-7172-000000','Revenues of Sub. Activities - Works','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(327,'0000-7173-000000','Revenues of Sub. Activities - Services','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(328,'0000-7190-000000','Discounts Granted','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(329,'0000-7191-000000','Discounts Granted on Sales of Products','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(330,'0000-7192-000000','Discounts Granted on Sales of Works','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(331,'0000-7193-000000','Discounts Granted on Sales of Services','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(332,'0000-7210-000000','Stock Variation of Products & Works in Progress','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(333,'0000-7211-000000','Stock Variation of Products in Process','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(334,'0000-7212-000000','Stock Variation of Works in Progress','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(335,'0000-7220-000000','Stock Variation of Studies & Services in Progress','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(336,'0000-7225-000000','Stock Variation of Studies in Progress','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(337,'0000-7226-000000','Stock Variation of Services in Progress','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(338,'0000-7250-000000','Stock Variation of Finished, Semi Finised & Scrap','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(339,'0000-7251-000000','Stock Variation of Semi-Finished Products','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(340,'0000-7255-000000','Stock Variation of Finished Products','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(341,'0000-7258-000000','Stock Variation of Production Scrap','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(342,'0000-7310-000000','Production of Intangible Fixed Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(343,'0000-7320-000000','Production of Tangible Fixed Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(344,'0000-7410-000000','Operating Subsidies for Goods','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(345,'0000-7420-000000','Operating Subsidies for Production','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(346,'0000-7520-000000','Reversal of Fixed Assets Devaluation Provisions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(347,'0000-7521-000000','Reversal of Deval.Prov. of Intang.Fixed Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(348,'0000-7522-000000','Reversal of Deval.Prov. of Tang.Fixed Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(349,'0000-7530-000000','REVERSAL OF DEVAL.PROV. OF CURRENT ASSETS','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(350,'0000-7533-000000','Reversal of Deval.Prov. of Stocks','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(351,'0000-7550-000000','Reversal of Risks & Charges Provisions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(352,'0000-7551-000000','Reversal of Deval.Prov. for Risks (Conflicts & alike)','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(353,'0000-7610-000000','Other Operating Ordinary Revenues','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(354,'0000-7611-000000','Patents Royalties Income','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(355,'0000-7612-000000','Rental of Buildings not used by  the Business','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(356,'0000-7613-000000','Board Meetings Attendance Fees Received','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(357,'0000-7615-000000','Other Sundry Operating Income','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(358,'0000-7619-000000','Operating Charges Transferred to Other Accounts','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(359,'0000-7650-000000','Parts in Profits of Joint Activities','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(360,'0000-7651-000000','Net Transfers of Allocated Charges','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(361,'0000-7655-000000','Net Attributions of Income','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(362,'0000-7710-000000','Revenues of Equity Participations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(363,'0000-7720-000000','Revenues of Securities and Receivables','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(364,'0000-7730-000000','Interests and Similar Revenues Earned ','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(365,'0000-7750-000000','Difference of Exchange - Positive','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(366,'0000-7751-000000','Exchange Profits on Current Operations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(367,'0000-7755-000000','Exchange Profits on Capital Transactions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(368,'0000-7780-000000','Other Financial Revenues','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(369,'0000-7781-000000','Net Income on Disposal of Participation Deeds','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(370,'0000-7789-000000','Financial Charges Transferred to Other Accounts','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(371,'0000-7790-000000','Reversal of Financial Provisions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(372,'0000-7793-000000','Reversal of Deval.Prov. Of Finan. F. Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(373,'0000-7794-000000','Reversal of Deval.Prov. Of Participations Deeds','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(374,'0000-7795-000000','Reversal of Prov. for Financial Risks','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(375,'0000-7810-000000','Revenues of Fixed Assets Disposals','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(376,'0000-7811-000000','Income from Disposal of Intang. F. Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(377,'0000-7812-000000','Income from Disposal of Tang. F. Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(378,'0000-7815-000000','Income from Disposal of Financ. F. Assets','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(379,'0000-7819-000000','Fixed Assets Disposal Charges','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(380,'0000-7820-000000','Investment Subsidies Transferred to Results','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(381,'0000-7880-000000','Other Non-Operating Revenues','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(382,'0000-7881-000000','Extra-ordinary Operating Revenues','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(383,'0000-7888-000000','Other Income on Extar-ordinary Transactions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(384,'0000-7889-000000','Sundry Extra-ordinary Charges Transferred','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(385,'0000-7890-000000','Reversal of Non-Operating Provisions','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(386,'0000-7891-000000','Reversal of Prov. for Non-Oper. Depreciations','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(387,'0000-7895-000000','Reversal of Prov. for Non-Oper. Risks & ChargesPrices Fall','P/L',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(388,'0000-0000-000001','Tax Free','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(389,'0000-0000-000002','Tax 11%','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(390,'0000-0000-000003','Supplier 1','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(391,'0000-0000-000004','Client 1','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(392,'0000-0000-000005','DHL','Balance Sheet',1,'2024-05-13 10:21:38','2024-05-13 10:21:38');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barcode_items`
--

DROP TABLE IF EXISTS `barcode_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barcode_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint unsigned NOT NULL,
  `invoice_id` bigint unsigned DEFAULT NULL,
  `receipt_id` bigint unsigned DEFAULT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barcode_items_item_id_foreign` (`item_id`),
  KEY `barcode_items_invoice_id_foreign` (`invoice_id`),
  KEY `barcode_items_receipt_id_foreign` (`receipt_id`),
  CONSTRAINT `barcode_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `barcode_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `barcode_items_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barcode_items`
--

LOCK TABLES `barcode_items` WRITE;
/*!40000 ALTER TABLE `barcode_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `barcode_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c_d_note_items`
--

DROP TABLE IF EXISTS `c_d_note_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `c_d_note_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cdnote_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `c_d_note_items_cdnote_id_foreign` (`cdnote_id`),
  KEY `c_d_note_items_account_id_foreign` (`account_id`),
  CONSTRAINT `c_d_note_items_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `c_d_note_items_cdnote_id_foreign` FOREIGN KEY (`cdnote_id`) REFERENCES `c_d_notes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c_d_note_items`
--

LOCK TABLES `c_d_note_items` WRITE;
/*!40000 ALTER TABLE `c_d_note_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `c_d_note_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c_d_notes`
--

DROP TABLE IF EXISTS `c_d_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `c_d_notes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cdnote_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `journal_voucher_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `c_d_notes_cdnote_number_unique` (`cdnote_number`),
  KEY `c_d_notes_supplier_id_foreign` (`supplier_id`),
  KEY `c_d_notes_client_id_foreign` (`client_id`),
  KEY `c_d_notes_currency_id_foreign` (`currency_id`),
  KEY `c_d_notes_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `c_d_notes_journal_voucher_id_foreign` (`journal_voucher_id`),
  CONSTRAINT `c_d_notes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `c_d_notes_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `c_d_notes_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `c_d_notes_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `c_d_notes_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c_d_notes`
--

LOCK TABLES `c_d_notes` WRITE;
/*!40000 ALTER TABLE `c_d_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `c_d_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `receivable_account_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_name_unique` (`name`),
  UNIQUE KEY `clients_vat_number_unique` (`vat_number`),
  KEY `clients_tax_id_foreign` (`tax_id`),
  KEY `clients_currency_id_foreign` (`currency_id`),
  KEY `clients_account_id_foreign` (`account_id`),
  KEY `clients_receivable_account_id_foreign` (`receivable_account_id`),
  CONSTRAINT `clients_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `clients_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `clients_receivable_account_id_foreign` FOREIGN KEY (`receivable_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `clients_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Client 1','client1@gmail.com','123456789','test address','124',2,1,391,148,'2024-05-13 10:21:38','2024-05-13 10:21:38');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_past_dates` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'YellowTech','yellow.tech.953@gmail.com','+4915204820649','Germany Berlin, werkstrasse 2','2212','https://yellowtech.dev','assets/images/logos/logo.png',1,'2024-05-13 10:21:38','2024-05-13 10:21:38');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'USD','US Dollar','$',1,'2024-05-13 10:21:36','2024-05-13 10:21:36'),(2,'LBP','Lebanese Bank Pound','lbp',95000,'2024-05-13 10:21:36','2024-05-13 10:21:36');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL,
  `unit_cost` double NOT NULL,
  `total_cost` double NOT NULL,
  `unit_price` double NOT NULL,
  `total_price` double NOT NULL,
  `vat` double NOT NULL,
  `rate` double NOT NULL,
  `total_price_after_vat` double NOT NULL,
  `total_foreign_price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  KEY `invoice_items_item_id_foreign` (`item_id`),
  CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `invoice_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `tax_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `journal_voucher_id` bigint unsigned NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'invoice',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_client_id_foreign` (`client_id`),
  KEY `invoices_currency_id_foreign` (`currency_id`),
  KEY `invoices_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `invoices_tax_id_foreign` (`tax_id`),
  KEY `invoices_journal_voucher_id_foreign` (`journal_voucher_id`),
  CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `invoices_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `invoices_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `invoices_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `invoices_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `leveling` int NOT NULL DEFAULT '0',
  `itemcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_cost` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `inventory_account_id` bigint unsigned DEFAULT NULL,
  `cost_of_sales_account_id` bigint unsigned DEFAULT NULL,
  `sales_account_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_warehouse_id_foreign` (`warehouse_id`),
  KEY `items_inventory_account_id_foreign` (`inventory_account_id`),
  KEY `items_cost_of_sales_account_id_foreign` (`cost_of_sales_account_id`),
  KEY `items_sales_account_id_foreign` (`sales_account_id`),
  CONSTRAINT `items_cost_of_sales_account_id_foreign` FOREIGN KEY (`cost_of_sales_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `items_inventory_account_id_foreign` FOREIGN KEY (`inventory_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `items_sales_account_id_foreign` FOREIGN KEY (`sales_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `items_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Item 1','/assets/images/profiles/NoItemImage.png',0,10,'item1','Item 1 Description',1,'2024-05-13 10:21:38','2024-05-13 10:21:38','A1B12','Serialized',0,15,128,240,316),(2,'Item 1','/assets/images/profiles/NoItemImage.png',0,10,'item1','Item 1 Description',2,'2024-05-13 10:21:38','2024-05-13 10:21:38','A2B1','Non Serialized',0,15,128,240,316),(3,'Item 2','/assets/images/profiles/NoItemImage.png',0,10,'item2','Item 2 Description',1,'2024-05-13 10:21:38','2024-05-13 10:21:38','A11B2','Serialized',0,15,128,240,316),(4,'Item 2','/assets/images/profiles/NoItemImage.png',0,10,'item2','Item 2 Description',2,'2024-05-13 10:21:38','2024-05-13 10:21:38','A3B1','Serialized',0,15,128,240,316);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_vouchers`
--

DROP TABLE IF EXISTS `journal_vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal_vouchers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `source` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'system',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unposted',
  `batch` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `journal_vouchers_user_id_foreign` (`user_id`),
  KEY `journal_vouchers_currency_id_foreign` (`currency_id`),
  KEY `journal_vouchers_foreign_currency_id_foreign` (`foreign_currency_id`),
  CONSTRAINT `journal_vouchers_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `journal_vouchers_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `journal_vouchers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_vouchers`
--

LOCK TABLES `journal_vouchers` WRITE;
/*!40000 ALTER TABLE `journal_vouchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_vouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `landed_costs`
--

DROP TABLE IF EXISTS `landed_costs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `landed_costs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `amount` double NOT NULL,
  `rate` double DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `landed_costs_receipt_id_foreign` (`receipt_id`),
  KEY `landed_costs_supplier_id_foreign` (`supplier_id`),
  KEY `landed_costs_currency_id_foreign` (`currency_id`),
  CONSTRAINT `landed_costs_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `landed_costs_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `landed_costs_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `landed_costs`
--

LOCK TABLES `landed_costs` WRITE;
/*!40000 ALTER TABLE `landed_costs` DISABLE KEYS */;
/*!40000 ALTER TABLE `landed_costs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2010_03_27_175725_create_warehouses_table',1),(2,'2014_10_12_000000_create_users_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2022_04_29_153257_create_items_table',1),(7,'2022_05_16_065718_create_logs_table',1),(8,'2023_01_18_213041_create_t_r_o_s_table',1),(9,'2023_01_18_213206_create_t_r_o_items_table',1),(10,'2023_01_19_213207_create_reqs_table',1),(11,'2023_12_18_200339_create_currencies_table',1),(12,'2023_12_18_200659_add_currency_to_users',1),(13,'2023_12_31_225240_create_accounts_table',1),(14,'2023_12_31_225609_create_taxes_table',1),(15,'2023_12_31_244909_create_suppliers_table',1),(16,'2023_12_31_245841_create_clients_table',1),(17,'2024_01_01_155219_create_projects_table',1),(18,'2024_01_02_154810_create_s_o_s_table',1),(19,'2024_01_02_173229_create_s_o_items_table',1),(20,'2024_01_08_103939_create_journal_vouchers_table',1),(21,'2024_01_09_230443_create_transactions_table',1),(22,'2024_01_10_084141_create_p_o_s_table',1),(23,'2024_01_10_084254_create_p_o_items_table',1),(24,'2024_01_15_123008_add_accounting_to_items',1),(25,'2024_01_15_165135_create_requests_table',1),(26,'2024_01_30_155704_create_receipts_table',1),(27,'2024_01_30_160031_create_receipt_items_table',1),(28,'2024_01_30_161231_create_landed_costs_table',1),(29,'2024_02_07_153222_create_v_o_c_s_table',1),(30,'2024_02_07_153915_create_v_o_c_items_table',1),(31,'2024_02_08_113835_create_payments_table',1),(32,'2024_02_08_113836_create_payment_items_table',1),(33,'2024_02_11_131858_create_invoices_table',1),(34,'2024_02_11_131906_create_invoice_items_table',1),(35,'2024_03_08_104333_create_secondary_images_table',1),(36,'2024_03_21_223231_create_companies_table',1),(37,'2024_04_22_102313_create_c_d_notes_table',1),(38,'2024_04_22_102323_create_c_d_note_items_table',1),(39,'2024_04_28_215418_create_search_routes_table',1),(40,'2024_05_05_132606_create_barcode_items_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p_o_items`
--

DROP TABLE IF EXISTS `p_o_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `p_o_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `po_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `p_o_items_po_id_foreign` (`po_id`),
  KEY `p_o_items_item_id_foreign` (`item_id`),
  CONSTRAINT `p_o_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `p_o_items_po_id_foreign` FOREIGN KEY (`po_id`) REFERENCES `p_o_s` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p_o_items`
--

LOCK TABLES `p_o_items` WRITE;
/*!40000 ALTER TABLE `p_o_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `p_o_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `p_o_s`
--

DROP TABLE IF EXISTS `p_o_s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `p_o_s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `p_o_s_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `p_o_s_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p_o_s`
--

LOCK TABLES `p_o_s` WRITE;
/*!40000 ALTER TABLE `p_o_s` DISABLE KEYS */;
/*!40000 ALTER TABLE `p_o_s` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_items`
--

DROP TABLE IF EXISTS `payment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_items_payment_id_foreign` (`payment_id`),
  KEY `payment_items_account_id_foreign` (`account_id`),
  CONSTRAINT `payment_items_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `payment_items_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_items`
--

LOCK TABLES `payment_items` WRITE;
/*!40000 ALTER TABLE `payment_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payment_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `journal_voucher_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_payment_number_unique` (`payment_number`),
  KEY `payments_supplier_id_foreign` (`supplier_id`),
  KEY `payments_client_id_foreign` (`client_id`),
  KEY `payments_currency_id_foreign` (`currency_id`),
  KEY `payments_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `payments_journal_voucher_id_foreign` (`journal_voucher_id`),
  CONSTRAINT `payments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `payments_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `payments_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `payments_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `payments_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` date NOT NULL,
  `number` int unsigned DEFAULT NULL,
  `warehouse_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_warehouse_id_foreign` (`warehouse_id`),
  KEY `projects_client_id_foreign` (`client_id`),
  CONSTRAINT `projects_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `projects_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipt_items`
--

DROP TABLE IF EXISTS `receipt_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receipt_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `receipt_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL,
  `unit_cost` double NOT NULL,
  `total_cost` double NOT NULL,
  `vat` double NOT NULL,
  `rate` double DEFAULT NULL,
  `total_cost_after_vat` double NOT NULL,
  `total_after_landed_cost` double NOT NULL,
  `total_foreign_cost` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receipt_items_receipt_id_foreign` (`receipt_id`),
  KEY `receipt_items_item_id_foreign` (`item_id`),
  CONSTRAINT `receipt_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `receipt_items_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipt_items`
--

LOCK TABLES `receipt_items` WRITE;
/*!40000 ALTER TABLE `receipt_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `receipt_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipts`
--

DROP TABLE IF EXISTS `receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receipts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `receipt_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_invoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `tax_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `journal_voucher_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'receipt',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `receipts_receipt_number_unique` (`receipt_number`),
  KEY `receipts_supplier_id_foreign` (`supplier_id`),
  KEY `receipts_tax_id_foreign` (`tax_id`),
  KEY `receipts_currency_id_foreign` (`currency_id`),
  KEY `receipts_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `receipts_journal_voucher_id_foreign` (`journal_voucher_id`),
  CONSTRAINT `receipts_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `receipts_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `receipts_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `receipts_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `receipts_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipts`
--

LOCK TABLES `receipts` WRITE;
/*!40000 ALTER TABLE `receipts` DISABLE KEYS */;
/*!40000 ALTER TABLE `receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reqs`
--

DROP TABLE IF EXISTS `reqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reqs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `from_id` bigint unsigned NOT NULL,
  `to_id` bigint unsigned NOT NULL,
  `tro_id` bigint unsigned NOT NULL,
  `quantity` double DEFAULT NULL,
  `type` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reqs_from_id_foreign` (`from_id`),
  KEY `reqs_to_id_foreign` (`to_id`),
  KEY `reqs_user_id_foreign` (`user_id`),
  KEY `reqs_item_id_foreign` (`item_id`),
  KEY `reqs_tro_id_foreign` (`tro_id`),
  CONSTRAINT `reqs_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `warehouses` (`id`),
  CONSTRAINT `reqs_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `reqs_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `warehouses` (`id`),
  CONSTRAINT `reqs_tro_id_foreign` FOREIGN KEY (`tro_id`) REFERENCES `t_r_o_s` (`id`),
  CONSTRAINT `reqs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reqs`
--

LOCK TABLES `reqs` WRITE;
/*!40000 ALTER TABLE `reqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `reqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `item_id` bigint unsigned DEFAULT NULL,
  `project_id` bigint unsigned DEFAULT NULL,
  `so_id` bigint unsigned DEFAULT NULL,
  `po_id` bigint unsigned DEFAULT NULL,
  `quantity` double NOT NULL,
  `type` int NOT NULL,
  `status` int NOT NULL,
  `warehouse_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `requests_so_id_foreign` (`so_id`),
  KEY `requests_po_id_foreign` (`po_id`),
  KEY `requests_warehouse_id_foreign` (`warehouse_id`),
  KEY `requests_user_id_foreign` (`user_id`),
  KEY `requests_item_id_foreign` (`item_id`),
  KEY `requests_project_id_foreign` (`project_id`),
  CONSTRAINT `requests_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `requests_po_id_foreign` FOREIGN KEY (`po_id`) REFERENCES `p_o_s` (`id`),
  CONSTRAINT `requests_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `requests_so_id_foreign` FOREIGN KEY (`so_id`) REFERENCES `s_o_s` (`id`),
  CONSTRAINT `requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `requests_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_o_items`
--

DROP TABLE IF EXISTS `s_o_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `s_o_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `so_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `s_o_items_so_id_foreign` (`so_id`),
  KEY `s_o_items_item_id_foreign` (`item_id`),
  CONSTRAINT `s_o_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `s_o_items_so_id_foreign` FOREIGN KEY (`so_id`) REFERENCES `s_o_s` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_o_items`
--

LOCK TABLES `s_o_items` WRITE;
/*!40000 ALTER TABLE `s_o_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_o_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `s_o_s`
--

DROP TABLE IF EXISTS `s_o_s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `s_o_s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_id` bigint unsigned NOT NULL,
  `technician` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_number` int DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `s_o_s_project_id_foreign` (`project_id`),
  CONSTRAINT `s_o_s_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `s_o_s`
--

LOCK TABLES `s_o_s` WRITE;
/*!40000 ALTER TABLE `s_o_s` DISABLE KEYS */;
/*!40000 ALTER TABLE `s_o_s` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search_routes`
--

DROP TABLE IF EXISTS `search_routes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `search_routes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `search_routes_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_routes`
--

LOCK TABLES `search_routes` WRITE;
/*!40000 ALTER TABLE `search_routes` DISABLE KEYS */;
INSERT INTO `search_routes` VALUES (1,'Dashboard','dashboard','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(2,'Signature','signature','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(3,'Statistics','statistics','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(4,'Debit Notes','debit_notes','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(5,'New Debit Note','debit_notes.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(6,'Credit Notes','credit_notes','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(7,'New Credit Note','credit_notes.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(8,'Receipts','receipts','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(9,'New Receipt','receipts.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(10,'Return Receipt','receipts.return','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(11,'Invoices','invoices','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(12,'New Invoice','invoices.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(13,'Return Invoice','invoices.return','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(14,'Payments','payments','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(15,'New Payment','payments.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(16,'Return Payment','payments.return','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(17,'Cash Receipts','cash_receipts','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(18,'New Cash Receipt','cash_receipts.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(19,'Return Cash Receipt','cash_receipts.return','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(20,'VOC','voc','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(21,'New VOC','voc.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(22,'Return VOC','voc.return','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(23,'Journal Vouchers','journal_vouchers','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(24,'New Journal Voucher','journal_vouchers.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(25,'Return Journal Voucher','journal_vouchers.return','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(26,'Accounts','accounts','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(27,'New Account','accounts.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(28,'Taxes','taxes','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(29,'New Tax','taxes.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(30,'Currencies','currencies','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(31,'Suppliers','suppliers','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(32,'New Supplier','suppliers.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(33,'Clients','clients','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(34,'New Client','clients.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(35,'Warehouses','warehouses','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(36,'New Warehouse','warehouses.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(37,'Requests','requests','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(38,'Logs','logs','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(39,'TRO','tro','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(40,'New TRO','tro.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(41,'SO','so','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(42,'New SO','so.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(43,'PO','po','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(44,'New PO','po.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(45,'Backup','backup','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(46,'Export Database','backup.export','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(47,'Notifications','notifications','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(48,'Projects','projects','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(49,'New Project','projects.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(50,'Items','items','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(51,'New Item','items.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(52,'Profile','profile','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(53,'Users','users','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(54,'New User','users.new','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(55,'Statement Of Accounts','accounts.get_statement_of_accounts','','2024-05-13 10:21:38','2024-05-13 10:21:38'),(56,'Trial Balance','accounts.get_trial_balance','','2024-05-13 10:21:38','2024-05-13 10:21:38');
/*!40000 ALTER TABLE `search_routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secondary_images`
--

DROP TABLE IF EXISTS `secondary_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secondary_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_id` bigint unsigned DEFAULT NULL,
  `project_id` bigint unsigned DEFAULT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `secondary_images_project_id_foreign` (`project_id`),
  KEY `secondary_images_item_id_foreign` (`item_id`),
  CONSTRAINT `secondary_images_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `secondary_images_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secondary_images`
--

LOCK TABLES `secondary_images` WRITE;
/*!40000 ALTER TABLE `secondary_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `secondary_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vat_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `payable_account_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_name_unique` (`name`),
  UNIQUE KEY `suppliers_vat_number_unique` (`vat_number`),
  KEY `suppliers_tax_id_foreign` (`tax_id`),
  KEY `suppliers_currency_id_foreign` (`currency_id`),
  KEY `suppliers_account_id_foreign` (`account_id`),
  KEY `suppliers_payable_account_id_foreign` (`payable_account_id`),
  CONSTRAINT `suppliers_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `suppliers_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `suppliers_payable_account_id_foreign` FOREIGN KEY (`payable_account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `suppliers_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Supplier 1','test address','Ali Hamada','supplier1@gmail.com','123','Lebanon','123456789',2,1,390,134,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(2,'DHL','testing','Hans Meier','support@dhl.de','125','Germany','+4915204820649',2,1,392,134,'2024-05-13 10:21:38','2024-05-13 10:21:38');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_r_o_items`
--

DROP TABLE IF EXISTS `t_r_o_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_r_o_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tro_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_r_o_items_tro_id_foreign` (`tro_id`),
  KEY `t_r_o_items_item_id_foreign` (`item_id`),
  CONSTRAINT `t_r_o_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `t_r_o_items_tro_id_foreign` FOREIGN KEY (`tro_id`) REFERENCES `t_r_o_s` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_r_o_items`
--

LOCK TABLES `t_r_o_items` WRITE;
/*!40000 ALTER TABLE `t_r_o_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_r_o_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_r_o_s`
--

DROP TABLE IF EXISTS `t_r_o_s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_r_o_s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_id` bigint unsigned NOT NULL,
  `to_id` bigint unsigned NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_r_o_s_from_id_foreign` (`from_id`),
  KEY `t_r_o_s_to_id_foreign` (`to_id`),
  CONSTRAINT `t_r_o_s_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `warehouses` (`id`),
  CONSTRAINT `t_r_o_s_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_r_o_s`
--

LOCK TABLES `t_r_o_s` WRITE;
/*!40000 ALTER TABLE `t_r_o_s` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_r_o_s` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taxes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double NOT NULL DEFAULT '0',
  `account_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `taxes_name_unique` (`name`),
  KEY `taxes_account_id_foreign` (`account_id`),
  CONSTRAINT `taxes_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxes`
--

LOCK TABLES `taxes` WRITE;
/*!40000 ALTER TABLE `taxes` DISABLE KEYS */;
INSERT INTO `taxes` VALUES (1,'Tax Free',0,388,'2024-05-13 10:21:38','2024-05-13 10:21:38'),(2,'Vat 11%',11,389,'2024-05-13 10:21:38','2024-05-13 10:21:38');
/*!40000 ALTER TABLE `taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `journal_voucher_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `debit` double unsigned NOT NULL,
  `credit` double unsigned NOT NULL,
  `balance` double NOT NULL,
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `foreign_debit` double unsigned DEFAULT NULL,
  `foreign_credit` double unsigned DEFAULT NULL,
  `foreign_balance` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_journal_voucher_id_foreign` (`journal_voucher_id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  KEY `transactions_account_id_foreign` (`account_id`),
  KEY `transactions_currency_id_foreign` (`currency_id`),
  KEY `transactions_foreign_currency_id_foreign` (`foreign_currency_id`),
  CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `transactions_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `transactions_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `transactions_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `location_id` bigint unsigned NOT NULL,
  `signature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terms_agreed` tinyint(1) NOT NULL DEFAULT '0',
  `terms_agreed_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_location_id_foreign` (`location_id`),
  KEY `users_currency_id_foreign` (`currency_id`),
  CONSTRAINT `users_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `users_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `warehouses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','test@test.com','123456789','/assets/images/profiles/NoProfile.png','$2y$12$o4HnyuIOx0iqAkC8UvQhW.MFvdtPBZupSG8gY3qVeqRbMLhMfNMAe',NULL,1,NULL,1,'2024-05-13 12:21:36',NULL,'2024-05-13 10:21:36','2024-05-13 10:21:36',1),(2,'user','user main','test1@test.com','123456789','/assets/images/profiles/NoProfile.png','$2y$12$xGWE4vc4Ck6rdFy/YT7Hf.A6R6tQgIMFkuNMhaoPsdv6gIXOlfsXq',NULL,1,NULL,1,'2024-05-13 12:21:36',NULL,'2024-05-13 10:21:36','2024-05-13 10:21:36',1),(3,'user','user secondary','test2@test.com','123456789','/assets/images/profiles/NoProfile.png','$2y$12$QcE774tWzMBw1Fyv2kQ2nO6glkNA5gtJM7RIigLlsZ5zJvAUSEUqy',NULL,2,NULL,1,'2024-05-13 12:21:37',NULL,'2024-05-13 10:21:37','2024-05-13 10:21:37',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `v_o_c_items`
--

DROP TABLE IF EXISTS `v_o_c_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `v_o_c_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `voc_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `amount` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `v_o_c_items_account_id_foreign` (`account_id`),
  KEY `v_o_c_items_voc_id_foreign` (`voc_id`),
  CONSTRAINT `v_o_c_items_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `v_o_c_items_voc_id_foreign` FOREIGN KEY (`voc_id`) REFERENCES `v_o_c_s` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `v_o_c_items`
--

LOCK TABLES `v_o_c_items` WRITE;
/*!40000 ALTER TABLE `v_o_c_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `v_o_c_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `v_o_c_s`
--

DROP TABLE IF EXISTS `v_o_c_s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `v_o_c_s` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `voc_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `supplier_invoice` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'VOC Transaction',
  `journal_voucher_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `v_o_c_s_voc_number_unique` (`voc_number`),
  KEY `v_o_c_s_supplier_id_foreign` (`supplier_id`),
  KEY `v_o_c_s_currency_id_foreign` (`currency_id`),
  KEY `v_o_c_s_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `v_o_c_s_tax_id_foreign` (`tax_id`),
  KEY `v_o_c_s_journal_voucher_id_foreign` (`journal_voucher_id`),
  CONSTRAINT `v_o_c_s_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `v_o_c_s_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `v_o_c_s_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `v_o_c_s_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `v_o_c_s_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `v_o_c_s`
--

LOCK TABLES `v_o_c_s` WRITE;
/*!40000 ALTER TABLE `v_o_c_s` DISABLE KEYS */;
/*!40000 ALTER TABLE `v_o_c_s` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouses`
--

DROP TABLE IF EXISTS `warehouses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `warehouses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `warehouses_name_unique` (`name`),
  UNIQUE KEY `warehouses_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouses`
--

LOCK TABLES `warehouses` WRITE;
/*!40000 ALTER TABLE `warehouses` DISABLE KEYS */;
INSERT INTO `warehouses` VALUES (1,'main','M','2024-05-13 10:21:36','2024-05-13 10:21:36'),(2,'secondary','S','2024-05-13 10:21:36','2024-05-13 10:21:36');
/*!40000 ALTER TABLE `warehouses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-13 11:22:16
