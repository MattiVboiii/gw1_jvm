-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: baseball
-- ------------------------------------------------------
-- Server version	8.0.39

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
-- Table structure for table `age_groups`
--

DROP TABLE IF EXISTS `age_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `age_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `age_groups`
--

LOCK TABLES `age_groups` WRITE;
/*!40000 ALTER TABLE `age_groups` DISABLE KEYS */;
INSERT INTO `age_groups` VALUES (1,'senioren','2024-12-22 19:53:25','2024-12-22 19:53:25',1),(2,'jeugd','2024-12-22 19:53:25','2024-12-22 20:19:35',1);
/*!40000 ALTER TABLE `age_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `age_group_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_categories_category_ages1_idx` (`age_group_id`),
  CONSTRAINT `fk_categories_category_ages1` FOREIGN KEY (`age_group_id`) REFERENCES `age_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Baseball Seniors',1,'2024-12-22 20:27:08','2024-12-22 20:27:08',1),(2,'Softball Dames',1,'2024-12-22 20:27:08','2024-12-22 20:27:08',1),(3,'Softball Heren',1,'2024-12-22 20:27:08','2024-12-22 20:27:08',1),(4,'Beeball Rookies',2,'2024-12-22 20:27:08','2024-12-22 20:27:08',1),(5,'Beeball Majors',2,'2024-12-22 20:27:08','2024-12-22 20:27:08',1),(6,'Miniemen',2,'2024-12-22 20:27:08','2024-12-22 20:27:08',1),(7,'Cadetten',2,'2024-12-22 20:27:08','2024-12-22 20:27:08',1),(8,'Slowpitch Softball',1,'2024-12-22 21:57:43','2024-12-22 21:57:43',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clubs`
--

DROP TABLE IF EXISTS `clubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clubs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `country` varchar(45) NOT NULL,
  `province` varchar(45) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `city` varchar(45) NOT NULL,
  `street` varchar(45) NOT NULL,
  `address` varchar(20) NOT NULL,
  `bus` varchar(20) DEFAULT NULL,
  `logo_url` varchar(255) NOT NULL,
  `longitude` float(9,6) NOT NULL,
  `latitude` float(8,6) NOT NULL,
  `description` blob,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `logo_url_UNIQUE` (`logo_url`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clubs`
--

LOCK TABLES `clubs` WRITE;
/*!40000 ALTER TABLE `clubs` DISABLE KEYS */;
INSERT INTO `clubs` VALUES (1,'Antwerp Eagles','BEL','Antwerpen','2610','Wilrijk','Eglantierlaan','66',NULL,'https://static.wbsc.org/upload/7784025f-15e3-9d72-ec0a-5cea1fb36fac.png',4.396526,51.183582,'','2024-12-22 20:55:32','2024-12-22 20:55:32',1),(2,'Borgerhout Squirrels','BEL','Antwerpen','2140','Borgerhout','Vosstraat','109',NULL,'https://static.wbsc.org/upload/bd187a02-55c9-dbf3-3a25-668902bfcd8d.png',4.452439,51.194595,_binary 'Welkom bij Borgerhout Squirrels!\nEen warme en familiale club waar je vanaf 4 jaar kan komen baseballen. Plezier staat voorop en je voelt je hier vast snel thuis!','2024-12-22 20:55:32','2024-12-22 20:55:32',1),(3,'Deurne Spartans','BEL','Antwerpen','2100','Deurne','Ruimtevaartlaan','22',NULL,'https://static.wbsc.org/upload/fb648008-c9d5-2b15-fca8-960733ae99e3.png',4.456800,51.193951,_binary 'Opgericht op 1 november 1948 door A. Eeckhout als \'Zonnestraal B.C.\' met stamnummer 15, kent de club die uiteindelijk \'Spartans\' zal worden, een woelig bestaan.\n\nVan gedwongen verhuis van terrein over uittochten van spelers, Europese competities, eeuwig wachten op een landstitel, problemen met infrastructuur en alles wat een sportvereniging zoal kan overkomen. Tijden van grote vreugde en droefenis, topprestaties en prestaties die we gelukkig al lang vergeten zijn..., Spartans heeft het allemaal meegemaakt.\n\nDe rijke geschiedenis van de club loopt net als bij andere pioniers van de Belgische baseballsport ook als een rode (of groene zo U wil) draad door diezelfde Belgische baseballgeschiedenis.\n\nHet is onmogelijk om dit rijke verleden in een klein kadertje te vatten. Net daarom kan je onderaan dit artikel de link naar een uitgebreide historiek van onze geliefde club terugvinden. Voor het leesgemak kan je die ook als een PDF-document downloaden of afdrukken.\n\nHet bij elkaar harken van verhalen uit de oude doos, oude websites, verhalen van zij die een groot deel nog zelf meegemaakt hebben, enzovoort is een hele klus. Onze excuses als er dingen zijn die we over het hoofd hebben gezien.\n\nBij deze een warme oproep om het verhaal van onze club verder aan te vullen. Spreek er iemand over aan of contacteer onze beheerder via dit formulier. Alle bijkomende info is welkom. Dat geldt uiteraard ook voor foto\'s, boekjes, documenten en informatie allerhande.\n\nDe huidige versie van ons historisch overzicht loopt tot 2017. Er wordt ondertussen hard gewerkt om alles te actualiseren. Binnenkort zal de nieuwe versie via deze website en onze social media-kanalen beschikbaar worden gemaakt. Nog even geduld dus...\n\nWaar je echter zelden in een historisch overzicht over leest is over die talloze vrijwilligers die een deel van hun leven hebben opgegeven om deze unieke club te maken tot wat ze is. Zonder hen geen accommodatie, geen coaches, geen clubhuis, geen..., kortom geen Deurne Spartans! Daarom uit de grond van het Spartans-hart een oververdiend \'BEDANKT\' aan al die mensen die ons dag in dag uit maken tot wat we zijn: \'WE ARE  SPARTANS!!!\'\n\nVeel leesplezier.\n\nDe Voorzitter.','2024-12-22 20:55:32','2025-01-06 21:18:14',1),(4,'Leuven Twins','BEL','Vlaams-Brabant','3001','Heverlee','Tervuursevest','101',NULL,'https://static.wbsc.org/upload/f6e1e98d-2589-8a8c-493d-91b7db48c173.png',4.693208,50.869488,_binary 'Welkom bij Leuven Twins!\nDe Leuven Twins is een club waar alle leeftijden en alle nationaliteiten welkom zijn. Je kan bij ons terecht voor Beeball, Baseball en Slowpitch Softball. Door onze (internationale) connectie met de KU Leuven hebben we een leuke mengeling van Belgische en internationale spelers. Iedereen is met ander woorden welkom.\nKom zeker eens een kijkje nemen of kom genieten van een leuke Leuven Twins wedstrijd als supporter.','2024-12-22 20:55:32','2024-12-22 20:55:32',1),(5,'Brasschaat Braves','BEL','Antwerpen','2930','Brasschaat','Bredabaan','31',NULL,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRUXyjUsuRVJx6PZSS7K3opt3PJhCWLzg12gA&s',4.490118,51.283684,NULL,'2024-12-22 19:55:32','2024-12-29 11:51:25',1),(6,'Merksem Royals','BEL','Antwerpen','2170','Merksem','Maantjessteenweg','50',NULL,'https://mlm6m4vom9xu.i.optimole.com/cb:xU7g.af0d/w:883/h:1024/q:mauto/f:best/https://www.royalgreys.be/wp-content/uploads/2024/01/New-logo-royal-greys-text-in-color-green.png',4.419784,51.242393,NULL,'2024-12-22 19:55:32','2024-12-29 11:55:33',1),(7,'Gent Knights','BEL','Oost-Vlaanderen','9000','Gent','Sportstraat','12',NULL,'https://gentknights.be/wp-content/uploads/2023/01/12ACBFDD-C9E5-42DC-9D80-6FFDC0FD72DF.png',3.729942,51.053829,NULL,'2024-12-22 19:55:32','2024-12-29 11:55:33',1),(8,'Hoboken Pioneers','BEL','Antwerpen','2660','Hoboken','Hoofdstraat','75',NULL,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRrQG0eEfOwMyZ2uQWaYyTClUkBAdJygTw8Dg&s',4.345067,51.168873,NULL,'2024-12-22 19:55:32','2024-12-29 11:55:33',1),(9,'Namur Angels','BEL','Namen','5000','Namur','Quai des Chasseurs Ardennais','5',NULL,'https://www.namur-angels.be/wp-content/uploads/2012/09/angels150.jpg',4.867928,50.467388,NULL,'2024-12-22 19:55:32','2024-12-29 11:55:33',1),(10,'Mont-Saint-Guibert Phoenix','BEL','Waals-Brabant','1435','Mont-Saint-Guibert','Rue des Sports','3',NULL,'https://www.msgphoenix.be/web/image/website/1/social_default_image?unique=d9a1e32',4.610155,50.645264,_binary 'test','2024-12-22 19:55:32','2025-01-06 07:43:51',1);
/*!40000 ALTER TABLE `clubs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clubs_users`
--

DROP TABLE IF EXISTS `clubs_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clubs_users` (
  `club_id` int NOT NULL,
  `user_id` int NOT NULL,
  `enabled` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`club_id`,`user_id`),
  KEY `fk_clubs_id_idx` (`club_id`) /*!80000 INVISIBLE */,
  KEY `fk_users_id_idx` (`user_id`) /*!80000 INVISIBLE */,
  CONSTRAINT `fk_clubs_id` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clubs_users`
--

LOCK TABLES `clubs_users` WRITE;
/*!40000 ALTER TABLE `clubs_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `clubs_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_references`
--

DROP TABLE IF EXISTS `external_references`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `external_references` (
  `id` int NOT NULL AUTO_INCREMENT,
  `club_id` int NOT NULL,
  `reference_type_id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `show_on_club` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_external_urls_clubs1_idx` (`club_id`),
  KEY `fk_external_urls_url_types1_idx` (`reference_type_id`),
  CONSTRAINT `fk_external_urls_clubs1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_external_urls_url_types1` FOREIGN KEY (`reference_type_id`) REFERENCES `reference_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_references`
--

LOCK TABLES `external_references` WRITE;
/*!40000 ALTER TABLE `external_references` DISABLE KEYS */;
INSERT INTO `external_references` VALUES (1,1,1,NULL,'http://www.antwerpeagles.com',1,'2024-12-22 21:06:50','2024-12-22 21:06:50',1),(2,1,2,NULL,'secretariaat@antwerpeagles.com',1,'2024-12-22 21:06:50','2024-12-22 21:06:50',1),(3,2,1,NULL,'http://www.borgerhoutsquirrels.be',1,'2024-12-22 21:06:50','2024-12-22 21:06:50',1),(4,2,2,NULL,'secretaris@borgerhoutsquirrels.be',1,'2024-12-22 21:06:50','2024-12-22 21:06:50',1),(5,3,1,NULL,'http://www.spartans.be',1,'2024-12-22 21:06:50','2024-12-22 21:06:50',1),(6,3,2,NULL,'info@spartans.be',1,'2024-12-22 21:06:50','2024-12-22 21:06:50',1),(7,4,1,NULL,'http://www.leuventwins.be',1,'2024-12-22 21:06:50','2024-12-22 21:06:50',1),(8,4,2,NULL,'info@leuventwins.be',1,'2024-12-22 21:06:50','2024-12-22 21:06:50',1),(9,1,13,NULL,'https://www.facebook.com/AntwerpEagles/?locale=nl_BE',1,'2025-01-03 00:16:30','2025-01-03 00:16:49',1),(10,1,14,NULL,'https://www.instagram.com/antwerpeagles/',1,'2025-01-03 00:30:20','2025-01-03 00:30:20',1),(11,1,15,NULL,'https://www.youtube.com/@vincentgeldof3286/streams',1,'2025-01-03 00:40:27','2025-01-03 00:40:27',1),(12,2,13,NULL,'https://www.facebook.com/SquirrelsOfficial/?locale=nl_NL',1,'2025-01-03 23:10:46','2025-01-03 23:10:46',1),(13,2,14,NULL,'https://www.instagram.com/squirrelsborgerhout7/',1,'2025-01-03 23:11:33','2025-01-03 23:11:33',1),(14,3,14,NULL,'https://www.instagram.com/deurnespartans/',1,'2025-01-03 23:12:09','2025-01-03 23:12:09',1),(15,3,13,NULL,'https://www.facebook.com/groups/DeurneSpartans/?locale=nl_BE',1,'2025-01-03 23:12:32','2025-01-03 23:12:32',1),(16,3,15,NULL,'https://www.youtube.com/channel/UCYM6DfF_pjbGsau8r0S3a9Q',1,'2025-01-03 23:12:50','2025-01-03 23:12:50',1);
/*!40000 ALTER TABLE `external_references` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `management`
--

DROP TABLE IF EXISTS `management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `management` (
  `id` int NOT NULL AUTO_INCREMENT,
  `club_id` int NOT NULL,
  `management_role_id` int NOT NULL,
  `role_description` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `show_on_club` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_management_management_roles1_idx` (`management_role_id`),
  KEY `fk_management_clubs1_idx` (`club_id`),
  CONSTRAINT `fk_management_clubs1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_management_management_roles1` FOREIGN KEY (`management_role_id`) REFERENCES `management_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `management`
--

LOCK TABLES `management` WRITE;
/*!40000 ALTER TABLE `management` DISABLE KEYS */;
INSERT INTO `management` VALUES (1,1,1,NULL,'Peter','Van Ackeren',NULL,NULL,1,'2024-12-22 21:15:41','2024-12-22 21:15:41',1),(2,1,2,NULL,'Nick','Van Den Bosh',NULL,NULL,1,'2024-12-22 21:15:41','2024-12-22 21:15:41',1),(3,1,3,NULL,'Gert','Van Den Berg',NULL,NULL,1,'2024-12-22 21:15:41','2024-12-22 21:15:41',1),(4,2,1,NULL,'Yannick','Gontier','voorzitter@borgerhoutsquirrels.be',NULL,1,'2024-12-22 21:15:41','2024-12-22 21:24:26',1),(5,2,2,NULL,'Sigrid','Gontier','secretaris@borgerhoutsquirrels.be',NULL,1,'2024-12-22 21:15:41','2024-12-22 21:24:26',1),(6,3,1,NULL,'Luc','Van Hove','luc@spartans.be','+32475203113',1,'2024-12-22 21:15:41','2024-12-22 21:35:38',1),(7,3,2,NULL,'Nicole','Van Den Broek','secretariaat@spartans.be','+32472841395',1,'2024-12-22 21:15:41','2024-12-22 21:35:38',1),(8,3,3,NULL,'Luc','Van Hove','luc@spartans.be','+32475203113',1,'2024-12-22 21:15:41','2024-12-22 21:35:38',1),(9,4,1,NULL,'Arno','Aarts',NULL,NULL,1,'2024-12-22 21:15:41','2024-12-22 21:15:41',1),(10,4,2,NULL,'Fiona','Hermans',NULL,NULL,1,'2024-12-22 21:15:41','2024-12-22 21:15:41',1),(11,4,3,NULL,'Stefan','Verelst',NULL,NULL,1,'2024-12-22 21:15:41','2024-12-22 21:15:41',1),(12,1,4,NULL,'Vincent','Geldof','vinniegeldof@hotmail.com',NULL,0,'2024-12-22 22:19:13','2024-12-22 22:29:36',1),(13,1,4,NULL,'Peter','Van Ackeren','coaching.softballreserven@antwerpeagles.com',NULL,0,'2024-12-22 22:19:13','2024-12-22 22:29:36',1),(14,1,4,NULL,'Oscar','Riera',NULL,NULL,0,'2024-12-22 22:22:40','2024-12-22 22:29:36',1),(15,1,4,NULL,'Carolina','Macias',NULL,NULL,0,'2024-12-22 22:22:40','2024-12-22 22:29:36',1),(16,1,4,NULL,'Peter','Van Ackeren',NULL,NULL,0,'2024-12-22 22:22:40','2024-12-22 22:29:36',1),(17,1,4,NULL,'Vinnie','Van den Bogaert',NULL,NULL,0,'2024-12-22 22:22:40','2024-12-22 22:29:36',1),(18,2,4,NULL,'Stefanie','Joris',NULL,NULL,0,'2024-12-22 22:29:36','2024-12-22 22:30:51',1),(19,2,5,NULL,'Julie','V.',NULL,NULL,0,'2024-12-22 22:29:36','2024-12-22 22:40:51',1),(20,2,4,NULL,'Yannick','Gontier',NULL,NULL,0,'2024-12-22 22:30:51','2024-12-22 22:30:51',1),(21,2,4,NULL,'Danny','Vermuyten',NULL,NULL,0,'2024-12-22 22:32:11','2024-12-22 22:32:11',1),(22,2,4,NULL,'Frank','',NULL,NULL,0,'2024-12-22 22:32:11','2024-12-22 22:33:12',1),(23,2,4,NULL,'Hugo','',NULL,NULL,0,'2024-12-22 22:33:02','2024-12-22 22:33:12',1),(29,4,6,NULL,'Arno','',NULL,NULL,0,'2024-12-22 22:40:51','2024-12-22 22:44:31',1),(30,4,4,NULL,'Thomas','',NULL,NULL,0,'2024-12-22 22:40:51','2024-12-22 22:40:51',1),(31,4,6,NULL,'Matthew','',NULL,NULL,0,'2024-12-22 22:40:51','2024-12-22 22:44:31',1),(32,4,4,'Coach & Trainer','Roel','',NULL,NULL,0,'2024-12-22 22:40:51','2024-12-22 22:44:31',1),(33,4,4,NULL,'Tom','',NULL,NULL,0,'2024-12-22 22:40:51','2024-12-22 22:44:31',1),(34,4,6,NULL,'Terje','',NULL,NULL,0,'2024-12-22 22:44:31','2024-12-22 22:44:31',1);
/*!40000 ALTER TABLE `management` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `management_roles`
--

DROP TABLE IF EXISTS `management_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `management_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(45) NOT NULL,
  `role_rank` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name_UNIQUE` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `management_roles`
--

LOCK TABLES `management_roles` WRITE;
/*!40000 ALTER TABLE `management_roles` DISABLE KEYS */;
INSERT INTO `management_roles` VALUES (1,'Voorzitter',9,'2024-12-22 20:05:07','2024-12-22 20:05:07',1),(2,'Secretaris Generaal',5,'2024-12-22 20:05:07','2024-12-22 21:09:24',1),(3,'Penningmeester',5,'2024-12-22 20:05:07','2024-12-22 21:09:35',1),(4,'Hoofdcoach',1,'2024-12-22 20:27:33','2024-12-22 22:28:21',1),(5,'Hulpcoach',1,'2024-12-22 22:28:21','2024-12-22 22:28:31',1),(6,'Trainer',1,'2024-12-22 22:38:21','2024-12-22 22:41:18',1),(7,'andere',0,'2024-12-22 21:08:01','2024-12-22 22:41:45',1);
/*!40000 ALTER TABLE `management_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `team_1_id` int NOT NULL,
  `team_2_id` int DEFAULT NULL,
  `team_2_name` varchar(45) DEFAULT NULL,
  `team_1_score` int DEFAULT NULL,
  `team_2_score` int DEFAULT NULL,
  `date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_matches_teams1_idx` (`team_1_id`),
  KEY `fk_matches_teams2_idx` (`team_2_id`),
  CONSTRAINT `fk_matches_teams1` FOREIGN KEY (`team_1_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_matches_teams2` FOREIGN KEY (`team_2_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
INSERT INTO `matches` VALUES (1,3,4,'Leuven Twins',NULL,NULL,'2025-04-12 13:00:00','2024-12-28 11:33:27','2025-01-06 13:21:12',1),(2,3,2,'Borgerhout Squirrels',NULL,NULL,'2025-04-19 14:00:00','2024-12-28 11:41:21','2025-01-06 13:21:12',1),(3,3,1,'Antwerp Eagles',NULL,NULL,'2025-04-26 15:00:00','2024-12-28 11:42:08','2025-01-06 13:21:12',1),(4,3,4,'Leuven Twins',NULL,NULL,'2025-05-04 16:00:00','2024-12-28 11:46:55','2025-01-06 13:21:12',1),(5,3,4,'Leuven Twins',8,15,'2024-07-06 00:00:00','2024-12-28 16:48:08','2024-12-28 16:48:08',1),(6,3,2,'Borgerhout Squirrels',5,2,'2024-07-13 00:00:00','2024-12-28 16:48:08','2024-12-28 16:48:08',1),(7,3,1,'Antwerp Eagles',12,7,'2024-07-20 00:00:00','2024-12-28 16:48:08','2024-12-28 16:48:08',1),(8,3,4,'Leuven Twins',1,0,'2024-07-27 00:00:00','2024-12-28 16:48:08','2024-12-28 16:48:08',1),(9,1,2,'Borgerhout Squirrels',NULL,NULL,'2025-05-04 11:00:00','2024-12-30 16:22:17','2025-01-06 13:22:21',1),(10,1,3,'Deurne Spartans',NULL,NULL,'2025-05-11 10:00:00','2024-12-30 16:26:06','2025-01-06 13:22:21',1),(11,1,4,'Leuven Twins',NULL,NULL,'2025-05-18 13:00:00','2024-12-30 16:32:52','2025-01-06 13:22:21',1),(12,2,1,'Antwerp Eagles',NULL,NULL,'2025-06-06 15:00:00','2024-12-30 16:33:41','2025-01-06 13:22:21',1),(13,2,3,'Deurne Spartans',NULL,NULL,'2025-06-13 12:00:00','2024-12-30 16:33:57','2025-01-06 13:22:21',1),(14,2,4,'Leuven Twins',NULL,NULL,'2025-06-20 16:00:00','2024-12-30 16:34:11','2025-01-06 13:22:21',1),(15,4,1,'Anwerp Eagles',NULL,NULL,'2025-07-04 09:00:00','2024-12-30 16:35:32','2025-01-06 13:22:21',1),(16,4,2,'Borgerhout Squirrels',NULL,NULL,'2025-07-11 10:00:00','2024-12-30 16:35:32','2025-01-06 13:22:21',1),(17,4,3,'Deurne Spartans',NULL,NULL,'2025-07-18 11:00:00','2024-12-30 16:35:32','2025-01-06 13:22:21',1);
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `media_url` varchar(500) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `club_id` int NOT NULL,
  `team_id` int DEFAULT NULL,
  `show_on_club` tinyint NOT NULL DEFAULT '1',
  `show_on_team` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_media_clubs1_idx` (`club_id`),
  KEY `fk_media_teams1_idx` (`team_id`),
  CONSTRAINT `fk_media_clubs1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_media_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjkRupZezyxIpP_HaZZ0O7PRGG2AKau8D7UvQu6Y1bHo7xfEaUpQhZCxvXVSabK9qcuTnhxAoZP0N5ABYEAUFQPek1JQEJSABNuJOnmDpB2cyK70FbYP2yv95Dc_q7bZzAL6Ij_LtbIbxgiFWMh92GF5pWZGSk7rSwxkcS817iQrUTO8aZLmGgNE5SBXtcj/w640-h360/DSC04148.JPG',NULL,1,1,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(2,'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEj1wSiuYSWWarVBDPn0kY7pRbqAlZ0eP47eikQME80919fnK50u8zyNLxdh0LyM0ZMEqMC-5IHh7SHIBJyuR_9nZuys5ISdTnwyT-a2_ktUe9rbA7B6Gf3BFHvXBV8Yoh9BQ-sR2LYKu3s0fB8qFgzX48vJNy7kS-yIN7Lr727wKObKS4qjHj-NDqkYtA/w640-h426/DSC09761.JPG',NULL,1,3,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(3,'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEikrFvZIIxq9S2pt7R2w0P8Fw8-yYxBSJL3psgnjlw3xtLatbGhfBFJn55m3Jd097C98b9sC-aGF4bMi3t3wOqximsgXXP5HOK2FlpTn6Hr_Y9XEhI7O8V88e7xdAF6lqazZ_WiHhZh9xSV/s1600/header.png',NULL,1,NULL,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(4,'https://primary.jwwb.nl/public/p/f/j/temp-menmsvoeabpeibtldlps/azlde0/rookies-2.png?enable-io=true&enable=upscale&crop=737%2C547%2Cx0%2Cy0%2Csafe&width=348&height=258',NULL,2,4,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(5,'https://primary.jwwb.nl/public/p/f/j/temp-menmsvoeabpeibtldlps/jncs6f/majors-1.png?enable-io=true&enable=upscale&crop=737%2C547%2Cx0%2Cy0%2Csafe&width=348&height=258',NULL,2,5,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(6,'https://primary.jwwb.nl/public/p/f/j/temp-menmsvoeabpeibtldlps/dgmem7/miniemen-1.png?enable-io=true&enable=upscale&crop=737%2C547%2Cx0%2Cy0%2Csafe&width=348&height=258',NULL,2,6,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(7,'https://primary.jwwb.nl/public/p/f/j/temp-menmsvoeabpeibtldlps/ja4ppq/cadetten-4.png?enable-io=true&enable=upscale&crop=749%2C484%2Cx0%2Cy0%2Csafe&width=348&height=225',NULL,2,7,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(8,'https://primary.jwwb.nl/public/p/f/j/temp-menmsvoeabpeibtldlps/463113126_1074038644727715_2297677579431831810_n-high.jpg?enable-io=true&enable=upscale&crop=1920%2C1920%2Cx0%2Cy0%2Csafe&width=523&height=523',NULL,2,NULL,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(9,'https://primary.jwwb.nl/public/p/f/j/temp-menmsvoeabpeibtldlps/462645634_1106512854120113_6169540701733459687_n-high.jpg?enable-io=true&enable=upscale&crop=1920%2C1080%2Cx0%2Cy0%2Csafe&width=523&height=294',NULL,2,NULL,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(10,'https://www.spartans.be/images/2023_Kampioen_HQ.jpg',NULL,3,NULL,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(11,'https://leuventwins.be/wp-content/uploads/2021/05/Copy-of-softball-Gold-Leuven-Twins-1024x576.png',NULL,4,NULL,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(12,'https://leuventwins.be/wp-content/uploads/2021/05/68422070_2863963663638416_7928824131691216896_n.jpg',NULL,4,8,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(13,'https://leuventwins.be/wp-content/uploads/2021/05/70503829_2587714741287034_8785168828725198848_n-1-1.jpg',NULL,4,10,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(14,'https://leuventwins.be/wp-content/uploads/2021/05/120370252_10221104334705337_3089082688014471360_n.jpg',NULL,4,9,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(15,'https://leuventwins.be/wp-content/uploads/sb-instagram-feed-images/342736492_624836763029214_22941803201527545_n.webplow.jpg',NULL,4,NULL,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1),(16,'https://leuventwins.be/wp-content/uploads/sb-instagram-feed-images/218957971_779072232785010_686608786241323405_nlow.jpg',NULL,4,NULL,1,1,'2024-12-22 22:10:47','2024-12-22 22:10:47',1);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference_types`
--

DROP TABLE IF EXISTS `reference_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reference_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `reference_rank` int NOT NULL DEFAULT '1',
  `is_social` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reference_types`
--

LOCK TABLES `reference_types` WRITE;
/*!40000 ALTER TABLE `reference_types` DISABLE KEYS */;
INSERT INTO `reference_types` VALUES (1,'main url',9,0,'2024-12-22 20:15:06','2024-12-22 21:01:46',1),(2,'main email',8,0,'2024-12-22 20:15:06','2024-12-22 21:01:46',1),(3,'main tel',7,0,'2024-12-22 20:15:06','2024-12-22 21:01:46',1),(4,'shop url',6,0,'2024-12-22 20:15:06','2024-12-22 21:01:46',1),(5,'url',1,0,'2024-12-22 20:15:06','2024-12-22 21:01:46',1),(6,'email',1,0,'2024-12-22 20:15:06','2024-12-22 21:01:46',1),(7,'tel',1,0,'2024-12-22 20:15:06','2024-12-22 21:01:46',1),(12,'X (twitter)',1,1,'2024-12-22 21:40:21','2024-12-22 21:42:16',1),(13,'Facebook',1,1,'2024-12-22 21:40:21','2024-12-22 21:42:16',1),(14,'Instagram',1,1,'2024-12-22 21:40:21','2024-12-22 21:42:16',1),(15,'YouTube',1,1,'2024-12-22 21:40:21','2024-12-22 21:42:16',1);
/*!40000 ALTER TABLE `reference_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_external_references`
--

DROP TABLE IF EXISTS `team_external_references`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_external_references` (
  `external_reference_id` int NOT NULL,
  `team_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`external_reference_id`,`team_id`),
  KEY `fk_external_references_has_teams_teams1_idx` (`team_id`),
  KEY `fk_external_references_has_teams_external_references1_idx` (`external_reference_id`),
  CONSTRAINT `fk_external_references_has_teams_external_references1` FOREIGN KEY (`external_reference_id`) REFERENCES `external_references` (`id`),
  CONSTRAINT `fk_external_references_has_teams_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_external_references`
--

LOCK TABLES `team_external_references` WRITE;
/*!40000 ALTER TABLE `team_external_references` DISABLE KEYS */;
/*!40000 ALTER TABLE `team_external_references` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_management`
--

DROP TABLE IF EXISTS `team_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_management` (
  `team_id` int NOT NULL,
  `management_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`team_id`,`management_id`),
  KEY `fk_teams_has_management_management1_idx` (`management_id`),
  KEY `fk_teams_has_management_teams1_idx` (`team_id`),
  CONSTRAINT `fk_teams_has_management_management1` FOREIGN KEY (`management_id`) REFERENCES `management` (`id`),
  CONSTRAINT `fk_teams_has_management_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_management`
--

LOCK TABLES `team_management` WRITE;
/*!40000 ALTER TABLE `team_management` DISABLE KEYS */;
INSERT INTO `team_management` VALUES (1,12,'2024-12-22 22:29:49','2024-12-22 22:29:49',1),(2,13,'2024-12-22 22:29:49','2024-12-22 22:29:49',1),(3,14,'2024-12-22 22:29:49','2024-12-22 22:29:49',1),(3,15,'2024-12-22 22:29:49','2024-12-22 22:29:49',1),(4,18,'2024-12-22 22:29:49','2024-12-22 22:29:49',1),(4,19,'2024-12-22 22:29:49','2024-12-22 22:29:49',1),(5,20,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(6,21,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(7,22,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(7,23,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(8,29,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(9,30,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(10,31,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(10,32,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(11,16,'2024-12-22 22:29:49','2024-12-22 22:29:49',1),(11,17,'2024-12-22 22:29:49','2024-12-22 22:29:49',1),(12,33,'2024-12-22 22:50:00','2024-12-22 22:50:00',1),(12,34,'2024-12-22 22:50:00','2024-12-22 22:50:00',1);
/*!40000 ALTER TABLE `team_management` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `club_id` int NOT NULL,
  `categories_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` blob,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_teams_clubs_idx` (`club_id`),
  KEY `fk_teams_categories1_idx` (`categories_id`),
  CONSTRAINT `fk_teams_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_teams_clubs` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` VALUES (1,1,2,'Softball Dames',NULL,'2024-12-22 21:57:59','2024-12-22 21:57:59',1),(2,1,3,'Softball Heren Reserven',NULL,'2024-12-22 21:57:59','2024-12-22 21:57:59',1),(3,1,1,'A-team',NULL,'2024-12-22 21:57:59','2024-12-22 22:20:42',1),(4,2,4,'Beeball Rookies',NULL,'2024-12-22 21:57:59','2024-12-22 21:57:59',1),(5,2,5,'Beeball Majors',NULL,'2024-12-22 21:57:59','2024-12-22 21:57:59',1),(6,2,6,'Miniemen',NULL,'2024-12-22 21:57:59','2024-12-22 21:57:59',1),(7,2,7,'Cadetten',NULL,'2024-12-22 21:57:59','2024-12-22 21:57:59',1),(8,4,6,'Miniemen',NULL,'2024-12-22 21:57:59','2024-12-22 21:57:59',1),(9,4,1,'Baseball',NULL,'2024-12-22 21:57:59','2024-12-22 21:57:59',1),(10,4,7,'Slowpitch Gold',NULL,'2024-12-22 21:57:59','2024-12-22 22:36:42',1),(11,1,1,'B-team',NULL,'2024-12-22 22:20:42','2024-12-22 22:20:42',1),(12,4,7,'Slowpitch Silver',NULL,'2024-12-22 22:36:42','2024-12-22 22:36:42',1);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `permissionRole` enum('user','club admin','super admin') NOT NULL DEFAULT 'user',
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (5,'Markie','$2y$10$eARUbq/Kmc2eNXZym0pVPOlh1KGo2mMaE00OnebZrJqRmZg3vv1kW','mark@user.com','user','Mark','De Haan','2025-01-09 10:18:39','2025-01-09 10:18:39',1),(7,'Vinnie','$2y$10$bNehce9Svv1I3GeKsugJHua1jtD4RMIXAaYabSvOKmf0BZE4lGQri','vincent@superadmin.com','super admin','Vincent','Diamond','2025-01-09 10:20:44','2025-01-09 10:20:44',1),(8,'xXKristofXx','$2y$10$.8ZdToFNo9Bwq1FSCVc8pOeYGe2ehPa7KhpK8kGo4Fg1PkaWxJOeK','kristof@admin.com','club admin','Kristof','Raaf','2025-01-09 10:21:52','2025-01-09 10:21:52',1);
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

-- Dump completed on 2025-01-11 20:32:44
