-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: elma
-- ------------------------------------------------------
-- Server version	8.0.40-0ubuntu0.24.04.1

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
-- Table structure for table `account_types`
--

DROP TABLE IF EXISTS `account_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `level` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_types_parent_id_foreign` (`parent_id`),
  CONSTRAINT `account_types_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `account_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_types`
--

LOCK TABLES `account_types` WRITE;
/*!40000 ALTER TABLE `account_types` DISABLE KEYS */;
INSERT INTO `account_types` VALUES (1,'Balance Sheet',NULL,1,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(2,'P/L',NULL,1,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(3,'Sales',2,2,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(4,'Sales external',3,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(5,'Sales to related parties',3,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(6,'Rebates and discounts granted to customers',3,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(7,'Cost of Sales',2,2,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(8,'Cost of Sales external',7,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(9,'Cost of sales to related parties',7,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(10,'Other operating income',2,2,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(11,'Write back provisions',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(12,'Rental income',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(13,'Management revenue',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(14,'Marketing management revenue',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(15,'Rebates and Discounts Received',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(16,'Income from reallocation of inter-company expenses',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(17,'Share of profits on joint venture',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(18,'Gain from disposal of fixed assets',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(19,'Income from Subleasing right-of-use assets',10,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(20,'Finance income',2,2,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(21,'Revenue from participation investments',20,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(22,'Revenue from other investments',20,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(23,'Realized gain/loss from FVTOCI Securities',20,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(24,'Dividend Income from marketable securities',20,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(25,'Interest income',20,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(26,'Profit on exchange',2,2,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(27,'Exceptional Income',2,2,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(28,'Personnel expenses',2,2,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(29,'Personnel salaries and benefits',28,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(30,'Social security charges',28,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(31,'Recharge by department - Personnel expenses',28,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(32,'Funded Head Contribution',28,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(33,'Allocation of Personnel Expenses to COS',28,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(34,'Inter-company Personnel expenses',28,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(35,'Operating and administrative expenses',2,2,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(36,'Accounting Charges',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(37,'Attorney Fees',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(38,'Audit Fees',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(39,'Provision for Expected Credit Losses',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(40,'Account Receivable Direct Write off',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(41,'Certification',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(42,'Consulting Fees and Commissions',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(43,'Call Center Cost',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(44,'Donations',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(46,'Electricity and Water',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(47,'Entertainment and invitation',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(48,'Exceptional Loss',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(49,'Marketing expenses',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(50,'Factoring',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(51,'Freight Clearing and Customs',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(52,'Gifts and Promotional Items',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(53,'Hardware and Software Maintenance',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(54,'Head office expenses',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(55,'Insurance premiums',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(56,'Inter-company expenses G&A',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(57,'Impairment loss of stock and work-in-progress',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(58,'Inventory write-off',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(59,'Localization',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(60,'Loss from disposal of fixed assets',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(61,'Management Fees',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(62,'Office expenses and maintenance',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(63,'Penalty Charges',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(64,'Postage Courier and telecommunications',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(65,'Printing supplies and stationary',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(66,'Recharge by department - Operating and administrative expenses',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(67,'Recruitment expenses',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(68,'Rent',35,3,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(69,'Sales commission to other',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(70,'Shares of loss joint venture',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(71,'Sponsor Fees',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(72,'Subscription and Magazines',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(73,'Sundries',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(74,'Taxes fees and other similar charges',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(75,'Tender fees',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(76,'Tools Spare parts and Repair',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(77,'Training and seminars',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(78,'Transport and Car repairs',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(79,'Travel Expenses',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(80,'Warranty and maintenance for BG',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(81,'Impairment for Advance Billing (Unbilled AR)',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(82,'Provisions for Contingencies',35,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(83,'Depreciation amortization and impairment loss',2,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(84,'Depreciation and amortization',83,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(85,'Impairment loss',83,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(86,'Financial charges',2,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(87,'Interest expenses',86,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(88,'Trade finance charges (charges on BGs and L/Cs)',86,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(89,'Commission and fees charges',86,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(90,'Other Finance Cost',86,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(91,'Loss on exchange',2,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(92,'Expenses',2,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(93,'Taxes on profit',2,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(94,'Current year tax',93,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(95,'Prior year tax Adjustment',93,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(96,'Non-Current Assets',1,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(97,'Property plant and equipment',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(98,'Other plant and equipments',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(99,'Transportation vehicles',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(100,'Technical installations and industrial machinery',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(101,'Furniture and Fixtures',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(102,'Leasehold Improvements',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(103,'Real Estate',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(104,'Tangible Assets under construction',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(105,'General Property plant and equipment',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(106,'Right-of-Use Assets',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(107,'Advances on purchase of tangible assets',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(108,'Leased Equipment',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(109,'Investment Property',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(110,'Goodwill',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(111,'Other Intangible Assets',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(112,'Other Non-Current Assets',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(113,'Financial Assets',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(114,'Participation investments',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(115,'Net receivable on disposal of a subsidiary',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(116,'Other non-current investments',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(117,'Long and medium terms loans receivable',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(118,'Restricted cash (pledged deposit)- Non Current',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(119,'Deferred tax assets',96,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(120,'Current Assets',1,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(121,'Trading Assets',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(122,'Stock and work in progress (WIP)',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(123,'Impairment of stock and WIP',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(124,'Trade Receivables',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(125,'Trade receivables outstanding',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(126,'Impairment of trade receivables',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(127,'Trade receivables due from related parties',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(128,'Bills and L/C receivables',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(129,'Advance Billing (Unbilled AR)',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(130,'Trade payables - advances and claims',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(131,'Advances paid to trade payables',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(132,'Claims due from Trade Payables',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(133,'Impairment loss of Trade Payables advances and claims',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(134,'Staff receivables',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(135,'Social Security establishments- Assets',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(136,'State and public establishments',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(137,'Related parties',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(138,'Other current assets',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(139,'Right-Of-Use asset - Current',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(140,'Regularization Accounts',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(141,'Exchange difference variance - Assets',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(142,'Other current investments',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(143,'Cash and cash equivalent',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(144,'Restricted cash (pledged deposit)- Current',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(145,'Assets classified as held for sale',120,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(146,'Total Assets',1,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(147,'Shareholders Equity',1,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(148,'Group Shareholders Equity',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(149,'Capital',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(150,'Reserves',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(151,'Reported Results',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(152,'Current Year Result',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(153,'Shareholders Accounts',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(154,'Option Adjustment (sold shares with back value)',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(155,'Dividend for the year',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(156,'Translation difference',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(157,'Consolidation difference',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(158,'Equity amount relating to non-current assets classified as held for sale',147,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(159,'Non-Current Liabilities',1,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(160,'Long and medium terms loans payable',159,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(161,'Deferred Income > 1 year',159,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(162,'Provisions for contingencies and charges',159,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(163,'Deferred tax liabilities',159,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(164,'Lease liabilities - Non Current',159,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(165,'Current Liabilities',1,2,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(166,'Trade payables',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(167,'Trade payables due to related parties',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(168,'Trade receivables - advances and claims',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(169,'Advances received from trade receivables',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(170,'Claims due to trade receivables',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(171,'Staff payables',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(172,'Social Security establishments- Liabilities',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(173,'State and public establishments',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(174,'Related parties',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(175,'Lease liabilities - Current',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(176,'Other Current Payables',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(177,'Regularization Accounts- Liabilities',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(178,'Exchange Difference Variance - Liabilities',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(179,'Deferred Income < 1 year',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(180,'Accrued Expenses',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(181,'Banks and financial establishment liabilities',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL),(182,'Sundry Creditors',165,3,'2025-01-04 17:13:37','2025-01-04 17:13:37',NULL);
/*!40000 ALTER TABLE `account_types` ENABLE KEYS */;
UNLOCK TABLES;

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
  `currency_id` bigint unsigned NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts_account_number_unique` (`account_number`),
  KEY `accounts_currency_id_foreign` (`currency_id`),
  CONSTRAINT `accounts_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=395 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'0000-1010-000000','CAPITAL',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(2,'0000-1011-000000','Subscribed Un-Called Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(3,'0000-1012-000000','Subscribed Called and Unpaid Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(4,'0000-1013-000000','Subscribed Called and Paid-Up Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(5,'0000-1020-000000','CAPITAL PREMIUMS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(6,'0000-1021-000000','Issuance Premiums',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(7,'0000-1022-000000','Merger Premiums',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(8,'0000-1023-000000','Contributions Premiums',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(9,'0000-1024-000000','Conversion Premium of Bonds to Shares ',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(10,'0000-1030-000000','REVALUATION VARIANCES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(11,'0000-1031-000000','Non-Amortizable Assets Reval. Variances',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(12,'0000-1035-000000','Amortizable Assets Reval. Variances',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(13,'0000-1090-000000','OWNER\'S CURRENT ACCOUNT',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(14,'0000-1110-000000','LEGAL RESERVE',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(15,'0000-1120-000000','STATUTORY AND CONTRACTUAL RESERVES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(16,'0000-1190-000000','OTHER RESERVES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(17,'0000-1210-000000','BROUGHT FORWARD RESULTS - PROFITS ',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(18,'0000-1250-000000','BROUGHT FORWARD RESULTS - LOSSES ',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(19,'0000-1300-000000','Current Period Net Result - Profit / (Loss)',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(20,'0000-1380-000000','CURRENT YEAR RESULT - PROFITS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(21,'0000-1390-000000','CURRENT YEAR RESULT - LOSSES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(22,'0000-1410-000000','INVESTMENT SUBSIDIES RECEIVED',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(23,'0000-1450-000000','INVEST. SUBSIDIES TRANSFERED TO RESULTS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(24,'0000-1510-000000','Provisions for Risks',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(25,'0000-1511-000000','Provisions for Litigations & Alike',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(26,'0000-1512-000000','Provisions against Guarantees Given',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(27,'0000-1513-000000','Provisions for Losses on Exchange',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(28,'0000-1514-000000','Provis. for Losses on Term Contracts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(29,'0000-1515-000000','Provisions for Fines & Penalties',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(30,'0000-1516-000000','Provisions for Financial Risks',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(31,'0000-1517-000000','Provisions for Extraordinary Prices Fall',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(32,'0000-1518-000000','Provisions for Non-Oper. Risks & Charges',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(33,'0000-1550-000000','Provisions for Charges',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(34,'0000-1551-000000','Provisions for Deferred Charges',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(35,'0000-1553-000000','Provision for Taxes (Other than Income Tax)',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(36,'0000-1610-000000','LONG TERM LOANS AGAINST BONDS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(37,'0000-1620-000000','LONG TERM LOANS FROM BANKS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(38,'0000-1680-000000','SUNDRY LONG & MED. TERM LOANS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(39,'0000-1810-000000','INTERCOMPANIES & INTERBRANCHES ACCOUNTS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(40,'0000-1860-000000','Interbranches Exchanges - Charges',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(41,'0000-1870-000000','Interbranches Exchanges - Revenues',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(42,'0000-2110-000000','BUSINESS CONCERN',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(43,'0000-2120-000000','FORMATION EXPENSES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(44,'0000-2130-000000','RESEARCH & DEVELOPMENT EXPENSES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(45,'0000-2140-000000','PATENTS, LICENSES, TRADE MARKS & ALIKE',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(46,'0000-2190-000000','OTHER INTANGIBLE FIXED ASSETS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(47,'0000-2210-000000','LANDS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(48,'0000-2211-000000','Virgin Lands - Basic Cost',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(49,'0000-2212-000000','Built-on Properties - Basic Cost',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(50,'0000-2213-000000','Extractive Lands - Basic Cost',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(51,'0000-2214-000000','Landscaping Cost',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(52,'0000-2230-000000','BUILDINGS & CONSTRUCTIONS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(53,'0000-2231-000000','Buildings - Basic Cost',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(54,'0000-2232-000000','Building Installations & Improvem\'ts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(55,'0000-2233-000000','Infra-structure Constructions',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(56,'0000-2234-000000','Constructions on Other Owners\' Lands',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(57,'0000-2240-000000','TECH. INSTALL., MACHINERY & EQUIPMENT',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(58,'0000-2241-000000','Specialized Technical Installations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(59,'0000-2242-000000','Specific Technical Installations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(60,'0000-2243-000000','Industrial Machinery & Equipment',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(61,'0000-2244-000000','Industrial Tools',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(62,'0000-2245-000000','Hotels & Retaurants Appliances',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(63,'0000-2250-000000','VEHICLES AND HANDLING EQUIPMENT',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(64,'0000-2251-000000','Passenger Vehicles',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(65,'0000-2252-000000','Transport Vehicles & Handling Equipment',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(66,'0000-2253-000000','Maritime Tranport Means',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(67,'0000-2254-000000','Air Transport Means',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(68,'0000-2260-000000','OTHER TANGIBLE FIXED ASSETS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(69,'0000-2261-000000','Internal Install. Decor & Improvements',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(70,'0000-2262-000000','Office & Computer Equipment',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(71,'0000-2263-000000','Furnitures, Fixtures & Accessories',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(72,'0000-2264-000000','Agricultural Installations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(73,'0000-2265-000000','Re-usable Containers',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(74,'0000-2270-000000','TANGIBLE FIXED ASSETS IN PROGRESS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(75,'0000-2271-000000','Lands under Acquisition',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(76,'0000-2273-000000','Buildings under Construction',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(77,'0000-2274-000000','Industrial Equipment under Installation',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(78,'0000-2276-000000','Other Tangible Fixed Assets in Progress',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(79,'0000-2280-000000','Advances/Purchase Of Fixed Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(80,'0000-2510-000000','Equity Participations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(81,'0000-2520-000000','Receivables Related To Participations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(82,'0000-2530-000000','OTHER SECURITIES & FINANCIAL ASSETS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(83,'0000-2531-000000','Ownership Deeds (Shares & Parts)',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(84,'0000-2535-000000','Credit Deeds (Bonds & Coupons)',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(85,'0000-2550-000000','LONG AND MEDIUM TERM GRANTED LOANS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(86,'0000-2551-000000','Loans to Partners/Affiliates - Non-Current Part',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(87,'0000-2552-000000','Loans to Employees - Non-Current Part',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(88,'0000-2558-000000','Other Long & Medium Term Loans',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(89,'0000-2590-000000','Other Long & Med.Term Receivables',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(90,'0000-2700-000000','FIXED ASSETS NON-AMORT. REVAL. VARIANCES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(91,'0000-2701-000000','Intang. Fixed Assets Non-Amort. Reval. Variances',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(92,'0000-2702-000000','Tangib. Fixed Assets Non-Amort. Reval. Variances',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(93,'0000-2705-000000','Financ. Fixed Assets Non-Amort. Reval. Variances',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(94,'0000-2800-000000','Amortization of Business Concern',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(95,'0000-2810-000000','Intangible Assets Amortizations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(96,'0000-2811-000000','Amortiz.of Formation Expenses',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(97,'0000-2812-000000','Amortiz.of Research & Develop. Expenses',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(98,'0000-2813-000000','Amortiz.of Patents, Licenses, Trade Marks, etc..',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(99,'0000-2819-000000','Amortiz.of Other Intang. Fixed Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(100,'0000-2820-000000','Tangible Assets Depreciations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(101,'0000-2821-000000','Deprec.of Extractive Lands & Landscaping',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(102,'0000-2823-000000','Deprec. of Buildings & Equipments',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(103,'0000-2824-000000','Deprec. Machinery & Equipment',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(104,'0000-2825-000000','Deprec.of Passenger & Transport Vehicles',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(105,'0000-2826-000000','Deprec.of Other Tangible Fixed Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(106,'0000-2910-000000','Devaluation Prov. of Intangible Fixed Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(107,'0000-2911-000000','Deval. Prov. for Patents, Trade Marks & Alike',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(108,'0000-2919-000000','Deval. Prov. for Other Intang. Fixed Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(109,'0000-2920-000000','Devaluation Prov. of Tangible Fixed Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(110,'0000-2921-000000','Virgin Land Devaluation Provision',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(111,'0000-2923-000000','Buildings Devaluation Provision',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(112,'0000-2926-000000','Deval. Prov. for Other Tangib. F. Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(113,'0000-2950-000000','Devaluation Prov. of Financial Fixed Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(114,'0000-2951-000000','Deval. Prov. for Equity Participations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(115,'0000-2952-000000','Deval. Prov. for  Participations\' Receiv.',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(116,'0000-2953-000000','Deval. Prov. for Other Securities & Fin. Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(117,'0000-2955-000000','Deval. Prov. for Long & Medium Term Loan',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(118,'0000-2959-000000','Deval. Prov. for Other Blocked Fin. Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(119,'0000-3110-000000','STOCK OF RAW MATERIALS & CONSUMABLES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(120,'0000-3150-000000','Inventory - Other Cons. Materials & Supplies',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(121,'0000-3310-000000','STOCK OF GOODS, WORKS & SERV. IN PROGRESS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(122,'0000-3320-000000','Inventory - Work in Progress',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(123,'0000-3350-000000','Inventory - Studies in Progress',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(124,'0000-3360-000000','Inventory - Services to Provide',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(125,'0000-3510-000000','STOCK OF MANUFACTURED PRODUCTS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(126,'0000-3550-000000','Inventory - Finished Products',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(127,'0000-3580-000000','Inventory - Production Waste',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(128,'0000-3700-000000','STOCK OF GOODS FOR SALE',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(129,'0000-3910-000000','DEVAL.PROV. FOR RAW & OTHER MAT. STOCK ',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(130,'0000-3930-000000','DEVAL.PROV. FOR PRODUCTS IN PROCESS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(131,'0000-3950-000000','DEVAL.PROV. FOR PRODUCTS STOCK',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(132,'0000-3970-000000','DEVAL.PROV. FOR GOODS FOR SALE STOCK',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(133,'0000-4010-000000','Suppliers - Creditor Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(134,'0000-4011-000000','Suppliers - Invoices Payable',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(135,'0000-4015-000000','Suppliers - Notes Payable ',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(136,'0000-4018-000000','Suppliers - Invoices Not Received',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(137,'0000-4019-000000','Discounts Obtained from Suppliers',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(138,'0000-4030-000000','Fixed Assets Suppliers',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(139,'0000-4031-000000','Fixed Assets Suppliers - Invoices Payable',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(140,'0000-4035-000000','Fixed Assets Suppliers - Notes Payable',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(141,'0000-4038-000000','F.Assets Suppliers - Invoices Not Received',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(142,'0000-4039-000000','Discounts Obtained from F.A. Suppliers',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(143,'0000-4090-000000','Advances to Suppliers',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(144,'0000-4091-000000','Advance Payments on Purchases',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(145,'0000-4092-000000','Materials Suppliers Accidentally Debtors',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(146,'0000-4093-000000','Fixed Assets Suppliers Accidentally Debtors',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(147,'0000-4110-000000','Customers - Debtors Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(148,'0000-4111-000000','Customers Receivables - Invoices',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(149,'0000-4115-000000','Doubtful Customers',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(150,'0000-4119-000000','Discounts Granted to Customers',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(151,'0000-4130-000000','CUSTOMERS RECEIVABLES - BILLS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(152,'0000-4150-000000','DUES FROM CUSTOMERS ON WORKS IN PROCESS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(153,'0000-4180-000000','DUES FROM CUSTOMERS ON INVOICES IN PROCESS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(154,'0000-4190-000000','Advances Received on Sales Orders',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(155,'0000-4191-000000','Advances Received on Sales Orders',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(156,'0000-4192-000000','Customers Accidentally Creditors',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(157,'0000-4210-000000','PERSONNEL ACCOUNTS PAYABLE',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(158,'0000-4211-000000','Salaries and Wages due to Personnel',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(159,'0000-4219-000000','Other dues to Personnel',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(160,'0000-4280-000000','PERSONNEL ACCOUNTS RECEIVABLE',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(161,'0000-4281-000000','Loans to Personnel',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(162,'0000-4282-000000','Garnishments on Personnel Dues',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(163,'0000-4289-000000','Other Receivales from Personnel',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(164,'0000-4310-000000','Social Security Fund - Creditor Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(165,'0000-4311-000000','Social Security - Payable Dues',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(166,'0000-4315-000000','Social Security - Notes Payable',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(167,'0000-4318-000000','Social Security - Charges to be Accounted for',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(168,'0000-4380-000000','SOCIAL SECURITY RECEIVABLES',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(169,'0000-4410-000000','Taxes Due on Operations',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(170,'0000-4411-000000','Taxes & Duties (Except Income Tax)',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(171,'0000-4415-000000','Taxes & Duties - Notes Payable',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(172,'0000-4418-000000','Taxes & Duties - Charges to be Accounted for',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(173,'0000-4420-000000','Value Added Tax Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(174,'0000-4425-000000','Value Added Tax - Debtor / Creditor Balance',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(175,'0000-4427-000000','Value Added Tax - Collected on Revenues',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(176,'0000-4429-000000','Value Added Tax - Due for Refund',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(177,'0000-4430-000000','Non-Operational Tax',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(178,'0000-4431-000000','Income Tax on Net Operating Profits',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(179,'0000-4432-000000','Tax on F.Assets Disposal or Revaluation Profits',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(180,'0000-4435-000000','Taxes on Holding or Off-Shore Companies',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(181,'0000-4450-000000','Government & Public Services - Credit Acc.',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(182,'0000-4490-000000','Government & Public Services - Debit Acc.',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(183,'0000-4511-000000','Related Companies Debtor Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(184,'0000-4512-000000','Related Companies Creditor Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(185,'0000-4530-000000','DIVIDENDS PAYABLE',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(186,'0000-4550-000000','SHAREHOLDERS/PARTNERS PAYABLES ON CAPITAL',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(187,'0000-4551-000000','Shareholders/Partners - Contributions to the Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(188,'0000-4552-000000','Shareholders/Partners - Re-imbursment of the Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(189,'0000-4557-000000','Shareholders/Partners - Other Payables on Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(190,'0000-4590-000000','SHAREHOLDERS/PARTNERS RECEIVABLES ON CAPITAL',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(191,'0000-4591-000000','Shareholders - Subscribed/Un-Called Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(192,'0000-4592-000000','Shareholders - Subsc./Called/Unpaid Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(193,'0000-4597-000000','Shareholders/Partners - Other Receivables on Capital',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(194,'0000-4610-000000','Other Operating Creditors',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(195,'0000-4611-000000','Payables on Consignments',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(196,'0000-4619-000000','Other Operating Creditor Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(197,'0000-4630-000000','Payables on Financial Fixed Assets',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(198,'0000-4650-000000','Sundry Non-Operating Accounts Payable',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(199,'0000-4680-000000','Sundry Operating Debtors',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(200,'0000-4681-000000','Receivables on Consignments',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(201,'0000-4689-000000','Other Operating Debtor Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(202,'0000-4690-000000','Sundry Non-Operating Debtors',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(203,'0000-4691-000000','Receivables on Disposals of F. Assets & Finan.Deeds',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(204,'0000-4699-000000','Other Non-Operating Debtor Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(205,'0000-4710-000000','Charges Differred over Futur Periods',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(206,'0000-4711-000000','Pre-Operating Expenses',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(207,'0000-4712-000000','Major Repairs to be Amortized',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(208,'0000-4713-000000','Bonds Settlement Premium',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(209,'0000-4719-000000','Other Deferred Charges',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(210,'0000-4720-000000','Prepaid Charges',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(211,'0000-4730-000000','Accrued Income',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(212,'0000-4740-000000','Accrued Unpaid Charges',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(213,'0000-4750-000000','Exchange Difference - Liability',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(214,'0000-4760-000000','Exchange Difference - Asset',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(215,'0000-4810-000000','Pending & Regularization Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(216,'0000-4820-000000','Periodic Distribution of Revenues',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(217,'0000-4910-000000','Provisions for Customers Bad Debts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(218,'0000-4950-000000','Prov. for Shareholders/Partners Bad Debts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(219,'0000-4960-000000','Sundry Debtors Devaluation Provisions',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(220,'0000-4968-000000','Prov. for Other Operating Bad Debts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(221,'0000-4969-000000','Prov. for Other Non-Operating Bad Debts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(222,'0000-4980-000000','Bad Debts due to Bankrupcy',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(223,'0000-4981-000000','Prov. for Losses on Bankrupt Clients Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(224,'0000-4985-000000','Prov. for Losses on Bankrupt Partners Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(225,'0000-5010-000000','Transferable Participation Deeds',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(226,'0000-5020-000000','Bonds with Shares Acquisition Rights',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(227,'0000-5050-000000','Bond and Coupons Issued by the Company',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(228,'0000-5060-000000','Bonds with Creditors Rights',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(229,'0000-5110-000000','Cheques & Coupons under Collection',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(230,'0000-5120-000000','Banks',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(231,'0000-5121-000000','Banks - Current Debtor Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(232,'0000-5122-000000','Banks - Facilities Accidentally Debtor',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(233,'0000-5123-000000','Banks - Term Deposits Accounts',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(234,'0000-5190-000000','Credit Establisments',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(235,'0000-5191-000000','Banks & Financial Establishments Facilities',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(236,'0000-5192-000000','Banks Current Accounts Accidentally Creditor',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(237,'0000-5300-000000','CASH ON HAND',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(238,'0000-5800-000000','INTERNAL TRANSFERS',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(239,'0000-5900-000000','Prov. for Devaluation of Participation Deeds',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(240,'0000-6010-000000','Purchase of Goods',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(241,'0000-6011-000000','Purchase of Goods',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(242,'0000-6012-000000','Purchase of  Packing Materials for Goods',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(243,'0000-6018-000000','Charges & Expenses on Goods Purchasing',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(244,'0000-6019-000000','Discounts Obtained on Purchased Goods',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(245,'0000-6050-000000','GOODS INVENTORY VARIANCE',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(246,'0000-6051-000000','Stock of Goods - Beg. of Period',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(247,'0000-6052-000000','Stock of Goods - End of Period',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(248,'0000-6110-000000','Purchases of Raw Materials & Consumables',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(249,'0000-6111-000000','Purchase of Raw Materials',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(250,'0000-6112-000000','Purchase of Manufacturing Consumables',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(251,'0000-6113-000000','Purchase of  Packing Materials for Products',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(252,'0000-6118-000000','Chgs & Exp. on R.M & Consum. Purchasing',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(253,'0000-6119-000000','Disc. Obtained on Purchased R.M & Consum.',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(254,'0000-6150-000000','RAW MAT. & CONSUM. INVENTORY VARIANCE',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(255,'0000-6151-000000','Stock of Raw & Other Mat. - Beg. of Period',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(256,'0000-6152-000000','Stock of Raw & Other Mat. - End of Period',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(257,'0000-6210-000000','Purchases from Sub-Contractors',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(258,'0000-6211-000000','Purchase of Works from Sub-Contractors',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(259,'0000-6212-000000','Purchase of Services from Sub-Contractors',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(260,'0000-6250-000000','Leasing, Patent Fees & Royalties',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(261,'0000-6260-000000','External Servises',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(262,'0000-6262-000000','Equip. Maintenance & Repair',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(263,'0000-6267-000000','RESEARCH & STUDIES FEES',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(264,'0000-6268-000000','Insurance Premium',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(265,'0000-6269-000000','Medical Care/advertisng/Financila chargges...',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(266,'0000-6310-000000','Salaries and Wages',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(267,'0000-6311-000000','Staff Salaries',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(268,'0000-6312-000000','Manpower Wages',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(269,'0000-6314-000000','Commissions Paid to Personnel',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(270,'0000-6316-000000','Partners/Managers Remunerations',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(271,'0000-6317-000000','Directors Remunerations',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(272,'0000-6350-000000','Social Charges (Social Security & Alike..)',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(273,'0000-6351-000000','Social Security FundContributions',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(274,'0000-6355-000000','End of Service Indemnities Provisions',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(275,'0000-6410-000000','Income Tax On Salaries & Wages',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(276,'0000-6420-000000','Municipal Taxes & Duties',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(277,'0000-6430-000000','Excise Tax',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(278,'0000-6440-000000','Registration & Notary Fees',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(279,'0000-6450-000000','Taxes, Dues & Alike, Including the Tax of Article 51 of law 497/2003',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(280,'0000-6451-000000','Tax of Article 51 of law 497/2003',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(281,'0000-6452-000000','Tax on Profits from F. Assets Disposal or Revaluation',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(282,'0000-6455-000000','Holding Taxes - on Capital and Services',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(283,'0000-6458-000000','Fiscal Fines',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(284,'0000-6459-000000','Other Taxes & Duties',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(285,'0000-6510-000000','Amortization & Depreciations Allocations',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(286,'0000-6610-000000','Other Administratives Ordinary Charges',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(287,'0000-6611-000000','Directors Attendance Fees - Out of Profits',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(288,'0000-6612-000000','Losses on Bad Debts',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(289,'0000-6650-000000','Company Part in Losses on Joint Ventures',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(290,'0000-6730-000000','Interests and Similar Charges',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(291,'0000-6731-000000','Interest Due on Payables and Loans',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(292,'0000-6736-000000','Interest Due to Banks & Financial Estab.',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(293,'0000-6739-000000','Bank Commissions & Other Charges',1,'P/L',NULL,NULL,'2025-01-04 17:13:35','2025-01-04 17:13:35',NULL),(294,'0000-6750-000000','Difference of Exchange - Negative',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(295,'0000-6751-000000','Exchange Losses on Current Operations',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(296,'0000-6752-000000','Exchange Losses on Capital Expenditures',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(297,'0000-6760-000000','Net Charges on Disposal of Securities',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(298,'0000-6790-000000','Provisions For Deval. Of Financial Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(299,'0000-6791-000000','Amortiz.Alloc. of Reimbursement Premiums',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(300,'0000-6792-000000','Prov.Alloc.for Financial Assets Devaluation',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(301,'0000-6794-000000','Prov.Alloc.for Devaluation of Participations',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(302,'0000-6795-000000','Prov.Alloc.for Financial Risks & Charges',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(303,'0000-6810-000000','Net Book Value of Disposed Fixed Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(304,'0000-6811-000000','Book Value of Intang. Assets Disposed of',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(305,'0000-6812-000000','Book Value of Tangible Assets Disposed of',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(306,'0000-6815-000000','Book Value of Financial Assets Disposed of',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(307,'0000-6850-000000','Other Non-Operating Charges',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(308,'0000-6855-000000','Charges on CapitalOperations',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(309,'0000-6880-000000','Charges On Extra-Ordinary Events',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(310,'0000-6890-000000','Non Oper\'tg Depreciations & Provisions',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(311,'0000-6891-000000','Alloc. for Extra-ordinary Deprec.of F.Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(312,'0000-6892-000000','Prov.Alloc. for Exceptional Depreciations',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(313,'0000-6895-000000','Prov.Alloc. for Non-Operat\'g Risks & Charges',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(314,'0000-6900-000000','Taxes on Profits',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(315,'0000-6901-000000','Income Tax on Net Operating Profits',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(316,'0000-7010-000000','Sales of Goods',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(317,'0000-7090-000000','Discounts/Allowances/Returned Goods',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(318,'0000-7110-000000','Sales of Products',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(319,'0000-7111-000000','Sales of Finished Products',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(320,'0000-7112-000000','Sales of Semi-Finished Products',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(321,'0000-7113-000000','Sales of Production Scrap',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(322,'0000-7120-000000','Sales of Works',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(323,'0000-7130-000000','Sales of Services',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(324,'0000-7170-000000','Revenues of Subsidiary Activities',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(325,'0000-7171-000000','Revenues of Sub. Activities - Products',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(326,'0000-7172-000000','Revenues of Sub. Activities - Works',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(327,'0000-7173-000000','Revenues of Sub. Activities - Services',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(328,'0000-7190-000000','Discounts Granted',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(329,'0000-7191-000000','Discounts Granted on Sales of Products',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(330,'0000-7192-000000','Discounts Granted on Sales of Works',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(331,'0000-7193-000000','Discounts Granted on Sales of Services',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(332,'0000-7210-000000','Stock Variation of Products & Works in Progress',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(333,'0000-7211-000000','Stock Variation of Products in Process',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(334,'0000-7212-000000','Stock Variation of Works in Progress',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(335,'0000-7220-000000','Stock Variation of Studies & Services in Progress',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(336,'0000-7225-000000','Stock Variation of Studies in Progress',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(337,'0000-7226-000000','Stock Variation of Services in Progress',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(338,'0000-7250-000000','Stock Variation of Finished, Semi Finised & Scrap',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(339,'0000-7251-000000','Stock Variation of Semi-Finished Products',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(340,'0000-7255-000000','Stock Variation of Finished Products',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(341,'0000-7258-000000','Stock Variation of Production Scrap',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(342,'0000-7310-000000','Production of Intangible Fixed Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(343,'0000-7320-000000','Production of Tangible Fixed Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(344,'0000-7410-000000','Operating Subsidies for Goods',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(345,'0000-7420-000000','Operating Subsidies for Production',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(346,'0000-7520-000000','Reversal of Fixed Assets Devaluation Provisions',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(347,'0000-7521-000000','Reversal of Deval.Prov. of Intang.Fixed Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(348,'0000-7522-000000','Reversal of Deval.Prov. of Tang.Fixed Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(349,'0000-7530-000000','REVERSAL OF DEVAL.PROV. OF CURRENT ASSETS',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(350,'0000-7533-000000','Reversal of Deval.Prov. of Stocks',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(351,'0000-7550-000000','Reversal of Risks & Charges Provisions',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(352,'0000-7551-000000','Reversal of Deval.Prov. for Risks (Conflicts & alike)',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(353,'0000-7610-000000','Other Operating Ordinary Revenues',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(354,'0000-7611-000000','Patents Royalties Income',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(355,'0000-7612-000000','Rental of Buildings not used by  the Business',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(356,'0000-7613-000000','Board Meetings Attendance Fees Received',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(357,'0000-7615-000000','Other Sundry Operating Income',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(358,'0000-7619-000000','Operating Charges Transferred to Other Accounts',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(359,'0000-7650-000000','Parts in Profits of Joint Activities',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(360,'0000-7651-000000','Net Transfers of Allocated Charges',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(361,'0000-7655-000000','Net Attributions of Income',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(362,'0000-7710-000000','Revenues of Equity Participations',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(363,'0000-7720-000000','Revenues of Securities and Receivables',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(364,'0000-7730-000000','Interests and Similar Revenues Earned ',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(365,'0000-7750-000000','Difference of Exchange - Positive',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(366,'0000-7751-000000','Exchange Profits on Current Operations',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(367,'0000-7755-000000','Exchange Profits on Capital Transactions',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(368,'0000-7780-000000','Other Financial Revenues',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(369,'0000-7781-000000','Net Income on Disposal of Participation Deeds',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(370,'0000-7789-000000','Financial Charges Transferred to Other Accounts',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(371,'0000-7790-000000','Reversal of Financial Provisions',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(372,'0000-7793-000000','Reversal of Deval.Prov. Of Finan. F. Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(373,'0000-7794-000000','Reversal of Deval.Prov. Of Participations Deeds',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(374,'0000-7795-000000','Reversal of Prov. for Financial Risks',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(375,'0000-7810-000000','Revenues of Fixed Assets Disposals',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(376,'0000-7811-000000','Income from Disposal of Intang. F. Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(377,'0000-7812-000000','Income from Disposal of Tang. F. Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(378,'0000-7815-000000','Income from Disposal of Financ. F. Assets',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(379,'0000-7819-000000','Fixed Assets Disposal Charges',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(380,'0000-7820-000000','Investment Subsidies Transferred to Results',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(381,'0000-7880-000000','Other Non-Operating Revenues',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(382,'0000-7881-000000','Extra-ordinary Operating Revenues',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(383,'0000-7888-000000','Other Income on Extar-ordinary Transactions',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(384,'0000-7889-000000','Sundry Extra-ordinary Charges Transferred',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(385,'0000-7890-000000','Reversal of Non-Operating Provisions',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(386,'0000-7891-000000','Reversal of Prov. for Non-Oper. Depreciations',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(387,'0000-7895-000000','Reversal of Prov. for Non-Oper. Risks & ChargesPrices Fall',1,'P/L',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(388,'0000-0000-000001','Tax Free',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(389,'0000-0000-000002','Tax 11%',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(390,'0000-0000-000003','Supplier 1',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(391,'0000-0000-000004','Client 1',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(392,'0000-0000-000005','DHL',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(393,'0000-0000-000006','CMA',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(394,'0000-0000-000007','Maersk',1,'Balance Sheet',NULL,NULL,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
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
  `amount` double unsigned NOT NULL,
  `tax` double unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
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
  `tax_id` bigint unsigned DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `journal_voucher_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `c_d_notes_cdnote_number_unique` (`cdnote_number`),
  KEY `c_d_notes_supplier_id_foreign` (`supplier_id`),
  KEY `c_d_notes_client_id_foreign` (`client_id`),
  KEY `c_d_notes_tax_id_foreign` (`tax_id`),
  KEY `c_d_notes_currency_id_foreign` (`currency_id`),
  KEY `c_d_notes_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `c_d_notes_journal_voucher_id_foreign` (`journal_voucher_id`),
  CONSTRAINT `c_d_notes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `c_d_notes_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `c_d_notes_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `c_d_notes_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `c_d_notes_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `c_d_notes_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`)
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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:108:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"users.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:12:\"users.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:12:\"users.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"clients.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"clients.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"clients.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:14:\"clients.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:14:\"clients.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:14:\"suppliers.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:16:\"suppliers.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:16:\"suppliers.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:16:\"suppliers.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:16:\"suppliers.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:9:\"logs.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:11:\"logs.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:17:\"credit_notes.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:19:\"credit_notes.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:19:\"credit_notes.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:19:\"credit_notes.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:19:\"credit_notes.return\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:19:\"credit_notes.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:16:\"debit_notes.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:18:\"debit_notes.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:18:\"debit_notes.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:18:\"debit_notes.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:18:\"debit_notes.return\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:18:\"debit_notes.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:10:\"items.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:12:\"items.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"items.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"items.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:12:\"items.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:13:\"receipts.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:15:\"receipts.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:15:\"receipts.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:15:\"receipts.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:15:\"receipts.return\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:15:\"receipts.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:13:\"invoices.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:15:\"invoices.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:15:\"invoices.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:15:\"invoices.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:15:\"invoices.return\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:15:\"invoices.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:13:\"payments.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:15:\"payments.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:15:\"payments.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:15:\"payments.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:15:\"payments.return\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:15:\"payments.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:18:\"cash_receipts.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:20:\"cash_receipts.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:20:\"cash_receipts.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:20:\"cash_receipts.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:20:\"cash_receipts.return\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:20:\"cash_receipts.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:9:\"vocs.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:11:\"vocs.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:11:\"vocs.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:11:\"vocs.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:11:\"vocs.return\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:11:\"vocs.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:21:\"journal_vouchers.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:23:\"journal_vouchers.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:23:\"journal_vouchers.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:23:\"journal_vouchers.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:23:\"journal_vouchers.return\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:23:\"journal_vouchers.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:20:\"purchase_orders.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:22:\"purchase_orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:22:\"purchase_orders.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:22:\"purchase_orders.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:22:\"purchase_orders.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:17:\"sales_orders.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:19:\"sales_orders.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:19:\"sales_orders.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:19:\"sales_orders.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:19:\"sales_orders.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:17:\"transactions.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:19:\"transactions.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:19:\"transactions.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:19:\"transactions.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:19:\"transactions.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:13:\"accounts.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:15:\"accounts.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:15:\"accounts.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:15:\"accounts.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:15:\"accounts.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:10:\"taxes.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:12:\"taxes.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:12:\"taxes.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:12:\"taxes.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:12:\"taxes.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:15:\"currencies.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:17:\"currencies.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:17:\"currencies.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:17:\"currencies.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:17:\"currencies.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:14:\"shipments.read\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:16:\"shipments.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:16:\"shipments.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:16:\"shipments.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:16:\"shipments.export\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:12:\"settings.all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:14:\"statistics.all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:11:\"backups.all\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"staff\";s:1:\"c\";s:3:\"web\";}}}',1736253567);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
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
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `receivable_account_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_name_unique` (`name`),
  KEY `clients_tax_id_foreign` (`tax_id`),
  KEY `clients_currency_id_foreign` (`currency_id`),
  KEY `clients_account_id_foreign` (`account_id`),
  KEY `clients_receivable_account_id_foreign` (`receivable_account_id`),
  CONSTRAINT `clients_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `clients_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `clients_receivable_account_id_foreign` FOREIGN KEY (`receivable_account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `clients_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Client 1','client1@gmail.com','123456789','test address','124',2,1,391,148,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'USD','US Dollar','$',1,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(2,'LBP','Lebanese Bank Pound','lbp',95000,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL);
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
  `quantity` double unsigned NOT NULL,
  `unit_cost` double unsigned NOT NULL,
  `total_cost` double unsigned NOT NULL,
  `unit_price` double unsigned NOT NULL,
  `total_price` double unsigned NOT NULL,
  `vat` double unsigned NOT NULL,
  `rate` double unsigned NOT NULL,
  `total_price_after_vat` double unsigned NOT NULL,
  `total_foreign_price` double unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
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
  `sales_order_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_number_unique` (`invoice_number`),
  KEY `invoices_client_id_foreign` (`client_id`),
  KEY `invoices_currency_id_foreign` (`currency_id`),
  KEY `invoices_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `invoices_tax_id_foreign` (`tax_id`),
  KEY `invoices_journal_voucher_id_foreign` (`journal_voucher_id`),
  KEY `invoices_sales_order_id_foreign` (`sales_order_id`),
  CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `invoices_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `invoices_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `invoices_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `invoices_sales_order_id_foreign` FOREIGN KEY (`sales_order_id`) REFERENCES `sales_orders` (`id`),
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
  `description` text COLLATE utf8mb4_unicode_ci,
  `unit_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'item',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Sea Freight - 20DRY','Sea freight for a 20DRY container',1000.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(2,'Sea Freight - 40HC','Sea freight for a 40HC container',1500.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(3,'Sea Freight - 20T','Sea freight for a 20T container',1200.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(4,'Sea Freight - 40T','Sea freight for a 40T container',1800.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(5,'Sea Freight - 20 Reefer','Sea freight for a 20 Reefer container',2000.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(6,'Sea Freight - 40 Reefer','Sea freight for a 40 Reefer container',2500.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(7,'Air Freight - 20DRY','Air freight for a 20DRY container',3000.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(8,'Air Freight - 40HC','Air freight for a 40HC container',4500.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(9,'Air Freight - 20T','Air freight for a 20T container',3500.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(10,'Air Freight - 40T','Air freight for a 40T container',5000.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(11,'Air Freight - 20 Reefer','Air freight for a 20 Reefer container',5500.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(12,'Air Freight - 40 Reefer','Air freight for a 40 Reefer container',7000.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(13,'Land Freight - 20DRY','Land freight for a 20DRY container',800.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(14,'Land Freight - 40HC','Land freight for a 40HC container',1200.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(15,'Land Freight - 20T','Land freight for a 20T container',900.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(16,'Land Freight - 40T','Land freight for a 40T container',1300.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(17,'Land Freight - 20 Reefer','Land freight for a 20 Reefer container',1600.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(18,'Land Freight - 40 Reefer','Land freight for a 40 Reefer container',2000.00,'per container','item','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(19,'Shipping Fee','Shipping cost charged by supplier',0.00,'flat','expense','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(20,'Customs Fee','Customs clearance fee',0.00,'flat','expense','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(21,'Transporter Fee','Transportation cost by agent',0.00,'flat','expense','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
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
  `deleted_at` timestamp NULL DEFAULT NULL,
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
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'Admin created new Shipment: EL-1000, datetime: 2025-01-04 19:18:16','2025-01-04 17:18:16','2025-01-04 17:18:16',NULL),(2,'Admin created Purchase Order PO-2025-2, datetime :   2025-01-04 19:21:04','2025-01-04 17:21:04','2025-01-04 17:21:04',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_00_000000_create_currencies_table',1),(2,'0001_01_01_000000_create_users_table',1),(3,'0001_01_01_000001_create_cache_table',1),(4,'0001_01_01_000002_create_jobs_table',1),(5,'2024_12_27_000001_create_accounts_table',1),(6,'2024_12_27_000002_create_logs_table',1),(7,'2024_12_27_000003_create_items_table',1),(8,'2024_12_27_000004_create_taxes_table',1),(9,'2024_12_27_000005_create_suppliers_table',1),(10,'2024_12_27_000006_create_clients_table',1),(11,'2024_12_27_000007_create_shipments_table',1),(12,'2024_12_27_000008_create_shipment_items_table',1),(13,'2024_12_27_000009_create_sales_orders_table',1),(14,'2024_12_27_000010_create_sales_order_items_table',1),(15,'2024_12_27_000011_create_journal_vouchers_table',1),(16,'2024_12_27_000012_create_transactions_table',1),(17,'2024_12_27_000013_create_purchase_orders_table',1),(18,'2024_12_27_000014_create_purchase_order_items_table',1),(19,'2024_12_27_000016_create_receipts_table',1),(20,'2024_12_27_000017_create_receipt_items_table',1),(21,'2024_12_27_000019_create_v_o_c_s_table',1),(22,'2024_12_27_000020_create_v_o_c_items_table',1),(23,'2024_12_27_000021_create_payments_table',1),(24,'2024_12_27_000022_create_payment_items_table',1),(25,'2024_12_27_000023_create_invoices_table',1),(26,'2024_12_27_000024_create_invoice_items_table',1),(27,'2024_12_27_000027_create_c_d_notes_table',1),(28,'2024_12_27_000028_create_c_d_note_items_table',1),(29,'2024_12_27_000029_create_search_routes_table',1),(30,'2024_12_27_000031_create_account_types_table',1),(31,'2024_12_27_154629_create_permission_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
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
  `amount` double unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL,
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'users.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(2,'users.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(3,'users.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(4,'users.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(5,'users.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(6,'clients.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(7,'clients.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(8,'clients.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(9,'clients.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(10,'clients.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(11,'suppliers.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(12,'suppliers.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(13,'suppliers.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(14,'suppliers.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(15,'suppliers.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(16,'logs.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(17,'logs.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(18,'credit_notes.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(19,'credit_notes.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(20,'credit_notes.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(21,'credit_notes.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(22,'credit_notes.return','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(23,'credit_notes.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(24,'debit_notes.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(25,'debit_notes.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(26,'debit_notes.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(27,'debit_notes.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(28,'debit_notes.return','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(29,'debit_notes.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(30,'items.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(31,'items.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(32,'items.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(33,'items.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(34,'items.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(35,'receipts.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(36,'receipts.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(37,'receipts.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(38,'receipts.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(39,'receipts.return','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(40,'receipts.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(41,'invoices.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(42,'invoices.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(43,'invoices.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(44,'invoices.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(45,'invoices.return','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(46,'invoices.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(47,'payments.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(48,'payments.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(49,'payments.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(50,'payments.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(51,'payments.return','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(52,'payments.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(53,'cash_receipts.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(54,'cash_receipts.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(55,'cash_receipts.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(56,'cash_receipts.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(57,'cash_receipts.return','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(58,'cash_receipts.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(59,'vocs.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(60,'vocs.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(61,'vocs.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(62,'vocs.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(63,'vocs.return','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(64,'vocs.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(65,'journal_vouchers.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(66,'journal_vouchers.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(67,'journal_vouchers.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(68,'journal_vouchers.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(69,'journal_vouchers.return','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(70,'journal_vouchers.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(71,'purchase_orders.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(72,'purchase_orders.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(73,'purchase_orders.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(74,'purchase_orders.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(75,'purchase_orders.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(76,'sales_orders.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(77,'sales_orders.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(78,'sales_orders.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(79,'sales_orders.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(80,'sales_orders.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(81,'transactions.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(82,'transactions.create','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(83,'transactions.update','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(84,'transactions.delete','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(85,'transactions.export','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(86,'accounts.read','web','2025-01-04 17:13:37','2025-01-04 17:13:37'),(87,'accounts.create','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(88,'accounts.update','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(89,'accounts.delete','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(90,'accounts.export','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(91,'taxes.read','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(92,'taxes.create','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(93,'taxes.update','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(94,'taxes.delete','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(95,'taxes.export','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(96,'currencies.read','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(97,'currencies.create','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(98,'currencies.update','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(99,'currencies.delete','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(100,'currencies.export','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(101,'shipments.read','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(102,'shipments.create','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(103,'shipments.update','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(104,'shipments.delete','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(105,'shipments.export','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(106,'settings.all','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(107,'statistics.all','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(108,'backups.all','web','2025-01-04 17:13:38','2025-01-04 17:13:38');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order_items`
--

DROP TABLE IF EXISTS `purchase_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'expense',
  `purchase_order_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT '1',
  `unit_price` double NOT NULL DEFAULT '1',
  `total_price` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_items_purchase_order_id_foreign` (`purchase_order_id`),
  KEY `purchase_order_items_item_id_foreign` (`item_id`),
  KEY `purchase_order_items_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `purchase_order_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_order_items_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_order_items_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order_items`
--

LOCK TABLES `purchase_order_items` WRITE;
/*!40000 ALTER TABLE `purchase_order_items` DISABLE KEYS */;
INSERT INTO `purchase_order_items` VALUES (1,'expense',1,21,NULL,1,9,9,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL),(2,'expense',2,21,2,1,12,12,'2025-01-04 17:21:04','2025-01-04 17:21:04',NULL);
/*!40000 ALTER TABLE `purchase_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_orders`
--

DROP TABLE IF EXISTS `purchase_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `po_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `shipment_id` bigint unsigned NOT NULL,
  `order_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_orders_supplier_id_foreign` (`supplier_id`),
  KEY `purchase_orders_shipment_id_foreign` (`shipment_id`),
  CONSTRAINT `purchase_orders_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_orders`
--

LOCK TABLES `purchase_orders` WRITE;
/*!40000 ALTER TABLE `purchase_orders` DISABLE KEYS */;
INSERT INTO `purchase_orders` VALUES (1,'PO-2025-1',2,1,'2025-01-25',NULL,'new',NULL,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL),(2,'PO-2025-2',2,1,'2025-01-04',NULL,'New',NULL,'2025-01-04 17:21:04','2025-01-04 17:21:04',NULL);
/*!40000 ALTER TABLE `purchase_orders` ENABLE KEYS */;
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
  `quantity` double unsigned NOT NULL,
  `unit_cost` double unsigned NOT NULL,
  `total_cost` double unsigned NOT NULL,
  `vat` double unsigned NOT NULL,
  `rate` double unsigned NOT NULL,
  `total_cost_after_vat` double unsigned NOT NULL,
  `total_foreign_cost` double unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
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
  `purchase_order_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `receipts_receipt_number_unique` (`receipt_number`),
  UNIQUE KEY `receipts_supplier_invoice_unique` (`supplier_invoice`),
  KEY `receipts_supplier_id_foreign` (`supplier_id`),
  KEY `receipts_tax_id_foreign` (`tax_id`),
  KEY `receipts_currency_id_foreign` (`currency_id`),
  KEY `receipts_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `receipts_journal_voucher_id_foreign` (`journal_voucher_id`),
  KEY `receipts_purchase_order_id_foreign` (`purchase_order_id`),
  CONSTRAINT `receipts_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `receipts_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `receipts_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `receipts_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
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
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(1,2),(6,2),(11,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2025-01-04 17:13:38','2025-01-04 17:13:38'),(2,'staff','web','2025-01-04 17:13:38','2025-01-04 17:13:38');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_order_items`
--

DROP TABLE IF EXISTS `sales_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales_order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'item',
  `sales_order_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT '1',
  `unit_price` double NOT NULL DEFAULT '1',
  `total_price` double NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_order_items_sales_order_id_foreign` (`sales_order_id`),
  KEY `sales_order_items_item_id_foreign` (`item_id`),
  KEY `sales_order_items_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `sales_order_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_order_items_sales_order_id_foreign` FOREIGN KEY (`sales_order_id`) REFERENCES `sales_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_order_items_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order_items`
--

LOCK TABLES `sales_order_items` WRITE;
/*!40000 ALTER TABLE `sales_order_items` DISABLE KEYS */;
INSERT INTO `sales_order_items` VALUES (1,'item',1,1,NULL,1,1000,1000,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL),(2,'item',1,16,NULL,1,1300,1300,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL);
/*!40000 ALTER TABLE `sales_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_orders`
--

DROP TABLE IF EXISTS `sales_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `so_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `shipment_id` bigint unsigned NOT NULL,
  `order_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_orders_client_id_foreign` (`client_id`),
  KEY `sales_orders_shipment_id_foreign` (`shipment_id`),
  CONSTRAINT `sales_orders_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_orders_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_orders`
--

LOCK TABLES `sales_orders` WRITE;
/*!40000 ALTER TABLE `sales_orders` DISABLE KEYS */;
INSERT INTO `sales_orders` VALUES (1,'SO-2025-1',1,1,'2025-01-25',NULL,'new',NULL,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL);
/*!40000 ALTER TABLE `sales_orders` ENABLE KEYS */;
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `search_routes_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search_routes`
--

LOCK TABLES `search_routes` WRITE;
/*!40000 ALTER TABLE `search_routes` DISABLE KEYS */;
INSERT INTO `search_routes` VALUES (1,'Dashboard','dashboard','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(2,'Statistics','statistics','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(3,'Debit Notes','debit_notes','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(4,'New Debit Note','debit_notes.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(5,'Credit Notes','credit_notes','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(6,'New Credit Note','credit_notes.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(7,'Receipts','receipts','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(8,'Return Receipt','receipts.return','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(9,'Invoices','invoices','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(10,'Return Invoice','invoices.return','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(11,'Payments','payments','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(12,'New Payment','payments.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(13,'Return Payment','payments.return','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(14,'Cash Receipts','cash_receipts','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(15,'New Cash Receipt','cash_receipts.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(16,'Return Cash Receipt','cash_receipts.return','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(17,'VOC','voc','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(18,'New VOC','voc.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(19,'Return VOC','voc.return','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(20,'Journal Vouchers','journal_vouchers','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(21,'New Journal Voucher','journal_vouchers.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(22,'Return Journal Voucher','journal_vouchers.return','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(23,'Accounts','accounts','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(24,'New Account','accounts.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(25,'Taxes','taxes','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(26,'New Tax','taxes.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(27,'Currencies','currencies','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(28,'Suppliers','suppliers','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(29,'New Supplier','suppliers.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(30,'Clients','clients','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(31,'New Client','clients.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(32,'Logs','logs','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(33,'Sales Orders','sales_orders','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(34,'New Sales Order','sales_orders.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(35,'Purchase Orders','purchase_orders','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(36,'New Purchase Orders','purchase_orders.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(37,'Backup','backup','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(38,'Export Database','backup.export','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(39,'Items','items','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(40,'New Item','items.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(41,'Profile','profile','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(42,'Users','users','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(43,'New User','users.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(44,'Statement Of Accounts','accounts.get_statement_of_accounts','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(45,'Trial Balance','accounts.get_trial_balance','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(46,'Track Item Serial Number','items.track_page','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(47,'Item Report','items.report_page','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(48,'Shipments','shipments','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(49,'New Shipment','shipments.new','','2025-01-04 17:13:36','2025-01-04 17:13:36',NULL);
/*!40000 ALTER TABLE `search_routes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('7pzc8cTXLRblNWwmS0Tb9QMM25kSdcNReJAPpJjz',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRWNIWFlkcjlxNm91VWNiajl0NUFkTFppMjhIeHZWN0VSOEJWT2pNTCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYmFja3VwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3MzYxNjcxNjc7fX0=',1736172257);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipment_items`
--

DROP TABLE IF EXISTS `shipment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipment_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'item',
  `shipment_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  `quantity` double NOT NULL DEFAULT '1',
  `unit_price` double NOT NULL DEFAULT '1',
  `total_price` double NOT NULL DEFAULT '1',
  `supplier_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_items_shipment_id_foreign` (`shipment_id`),
  KEY `shipment_items_item_id_foreign` (`item_id`),
  KEY `shipment_items_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `shipment_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shipment_items_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shipment_items_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipment_items`
--

LOCK TABLES `shipment_items` WRITE;
/*!40000 ALTER TABLE `shipment_items` DISABLE KEYS */;
INSERT INTO `shipment_items` VALUES (1,'item',1,1,1,1000,1000,NULL,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL),(2,'item',1,16,1,1300,1300,NULL,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL),(3,'expense',1,21,1,9,9,2,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL);
/*!40000 ALTER TABLE `shipment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipment_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departure` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrival` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commodity` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `client_id` bigint unsigned NOT NULL,
  `shipping_date` date NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipments_client_id_foreign` (`client_id`),
  CONSTRAINT `shipments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipments`
--

LOCK TABLES `shipments` WRITE;
/*!40000 ALTER TABLE `shipments` DISABLE KEYS */;
INSERT INTO `shipments` VALUES (1,'EL-1000','Air','Dubai AirPort','Port Beirut','Goodies','New',1,'2025-01-25',NULL,NULL,'2025-01-04 17:18:16','2025-01-04 17:18:16',NULL);
/*!40000 ALTER TABLE `shipments` ENABLE KEYS */;
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
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` bigint unsigned NOT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `account_id` bigint unsigned NOT NULL,
  `payable_account_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_name_unique` (`name`),
  KEY `suppliers_tax_id_foreign` (`tax_id`),
  KEY `suppliers_currency_id_foreign` (`currency_id`),
  KEY `suppliers_account_id_foreign` (`account_id`),
  KEY `suppliers_payable_account_id_foreign` (`payable_account_id`),
  CONSTRAINT `suppliers_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `suppliers_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `suppliers_payable_account_id_foreign` FOREIGN KEY (`payable_account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `suppliers_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Supplier 1','Ali Hamada','supplier1@gmail.com','123456789','test address','123','Lebanon',2,1,390,134,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(2,'DHL','Hans Meier','support@dhl.de','+4915204820649','testing','125','Germany',2,1,392,134,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(3,'CMA','Maria','support@cma.lb','+4915204820649','beirut','12231325','Lebanon',2,1,393,134,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(4,'Maersk','Joe','support@maersk.lb','+4915204820649','beirut','1297325','Lebanon',2,1,394,134,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL);
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `taxes_name_unique` (`name`),
  KEY `taxes_account_id_foreign` (`account_id`),
  CONSTRAINT `taxes_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxes`
--

LOCK TABLES `taxes` WRITE;
/*!40000 ALTER TABLE `taxes` DISABLE KEYS */;
INSERT INTO `taxes` VALUES (1,'Tax Free',0,388,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL),(2,'Vat 11%',11,389,'2025-01-04 17:13:36','2025-01-04 17:13:36',NULL);
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
  `debit` double unsigned NOT NULL DEFAULT '0',
  `credit` double unsigned NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `foreign_currency_id` bigint unsigned DEFAULT NULL,
  `foreign_debit` double unsigned DEFAULT NULL,
  `foreign_credit` double unsigned DEFAULT NULL,
  `foreign_balance` double DEFAULT NULL,
  `rate` double unsigned DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `client_id` bigint unsigned DEFAULT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_journal_voucher_id_foreign` (`journal_voucher_id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  KEY `transactions_account_id_foreign` (`account_id`),
  KEY `transactions_currency_id_foreign` (`currency_id`),
  KEY `transactions_foreign_currency_id_foreign` (`foreign_currency_id`),
  KEY `transactions_client_id_foreign` (`client_id`),
  KEY `transactions_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  CONSTRAINT `transactions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `transactions_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `transactions_foreign_currency_id_foreign` FOREIGN KEY (`foreign_currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `transactions_journal_voucher_id_foreign` FOREIGN KEY (`journal_voucher_id`) REFERENCES `journal_vouchers` (`id`),
  CONSTRAINT `transactions_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
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
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `currency_id` bigint unsigned NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_currency_id_foreign` (`currency_id`),
  CONSTRAINT `users_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','test@test.com',NULL,1,'$2y$12$hxvMVX2NZ7FpE9auo4rgqeNK9I3HrIuc6DsvBdDos9cl6e3LXFPiK',NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL),(2,'user','user@user.com',NULL,1,'$2y$12$haUE4Ti91r3vUI/BtNZ2m.RaN3hAFrD2popa./3Z3KHy3.SKCsDMe',NULL,'2025-01-04 17:13:34','2025-01-04 17:13:34',NULL);
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
  `amount` double unsigned NOT NULL,
  `tax` double unsigned NOT NULL,
  `total` double unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `v_o_c_s_voc_number_unique` (`voc_number`),
  UNIQUE KEY `v_o_c_s_supplier_invoice_unique` (`supplier_invoice`),
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-06 16:04:21
