/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.0.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: evemountain_db
-- ------------------------------------------------------
-- Server version	12.0.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cost_per_person` decimal(10,2) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `activities` VALUES
(1,'Quad Biking','Thrilling quad bike rides through the mountain terrain. Suitable for all experience levels with safety briefing provided.',5.00,'bike',1,1,'2026-06-09 12:37:30','2026-06-09 12:37:30'),
(2,'Teambuilding Activities','Structured teambuilding exercises designed for corporate groups, churches and NGOs. Activities tailored to your group\'s goals.',5.00,'users',1,2,'2026-06-09 12:37:30','2026-06-09 12:37:30'),
(3,'Swimming Pool','Relax and cool off in our outdoor swimming pool set against the mountain backdrop.',5.00,'waves',1,3,'2026-06-09 12:37:30','2026-06-09 12:37:30');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `blocked_dates`
--

DROP TABLE IF EXISTS `blocked_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `blocked_dates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `facility_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blocked_dates_facility_id_foreign` (`facility_id`),
  CONSTRAINT `blocked_dates_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocked_dates`
--

LOCK TABLES `blocked_dates` WRITE;
/*!40000 ALTER TABLE `blocked_dates` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `blocked_dates` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `booking_activities`
--

DROP TABLE IF EXISTS `booking_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) unsigned NOT NULL,
  `activity_id` bigint(20) unsigned NOT NULL,
  `pax` int(11) NOT NULL,
  `rate_snapshot` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_activities_booking_id_foreign` (`booking_id`),
  KEY `booking_activities_activity_id_foreign` (`activity_id`),
  CONSTRAINT `booking_activities_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_activities_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_activities`
--

LOCK TABLES `booking_activities` WRITE;
/*!40000 ALTER TABLE `booking_activities` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `booking_activities` VALUES
(1,1,1,23,5.00,115.00,'2026-06-09 12:47:43','2026-06-09 12:47:43'),
(2,1,2,23,5.00,115.00,'2026-06-09 12:47:43','2026-06-09 12:47:43'),
(3,2,1,67,5.00,335.00,'2026-06-09 14:32:50','2026-06-09 14:32:50'),
(4,2,2,67,5.00,335.00,'2026-06-09 14:32:50','2026-06-09 14:32:50'),
(5,2,3,67,5.00,335.00,'2026-06-09 14:32:50','2026-06-09 14:32:50');
/*!40000 ALTER TABLE `booking_activities` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `booking_facilities`
--

DROP TABLE IF EXISTS `booking_facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_facilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) unsigned NOT NULL,
  `facility_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `days` int(11) NOT NULL,
  `rate_snapshot` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_facilities_booking_id_foreign` (`booking_id`),
  KEY `booking_facilities_facility_id_foreign` (`facility_id`),
  CONSTRAINT `booking_facilities_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_facilities_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_facilities`
--

LOCK TABLES `booking_facilities` WRITE;
/*!40000 ALTER TABLE `booking_facilities` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `booking_facilities` VALUES
(1,1,5,23,3,8.00,552.00,'2026-06-09 12:47:43','2026-06-09 12:47:43'),
(2,1,2,1,3,100.00,300.00,'2026-06-09 12:47:43','2026-06-09 12:47:43'),
(3,1,3,1,3,60.00,180.00,'2026-06-09 12:47:43','2026-06-09 12:47:43'),
(4,1,4,56,3,0.50,84.00,'2026-06-09 12:47:43','2026-06-09 12:47:43'),
(5,2,1,67,1,12.00,804.00,'2026-06-09 14:32:50','2026-06-09 14:32:50'),
(6,2,2,1,1,100.00,100.00,'2026-06-09 14:32:50','2026-06-09 14:32:50'),
(7,2,3,1,1,60.00,60.00,'2026-06-09 14:32:50','2026-06-09 14:32:50'),
(8,2,4,7,1,0.50,3.50,'2026-06-09 14:32:50','2026-06-09 14:32:50');
/*!40000 ALTER TABLE `booking_facilities` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_type` enum('church','ngo','company','school','other') NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `arrival_date` date NOT NULL,
  `departure_date` date NOT NULL,
  `pax_count` int(11) NOT NULL,
  `accommodation_type` enum('dormitory','outdoor_camp','both','none') NOT NULL,
  `total_quote` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `special_requirements` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_reference_unique` (`reference`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `bookings` VALUES
(1,'EM-2026-0001','werwe','church','werwe','kaliyatilee@gmail.com','3454334','2026-06-10','2026-06-13',23,'outdoor_camp',1346.00,'cancelled','rwerwerwe',NULL,'2026-06-09 13:50:20','2026-06-09 12:47:43','2026-06-09 13:53:38'),
(2,'EM-2026-0002','werwe','ngo','werwe','kaliyatilee@gmail.com','3454334','2026-06-10','2026-06-11',67,'dormitory',1972.50,'pending','y54y56y56y56',NULL,NULL,'2026-06-09 14:32:50','2026-06-09 14:32:50');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `facilities`
--

DROP TABLE IF EXISTS `facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `facilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `rate` decimal(10,2) NOT NULL,
  `rate_unit` enum('per_person_per_night','per_person_per_day','per_day','per_day_per_unit') NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facilities_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facilities`
--

LOCK TABLES `facilities` WRITE;
/*!40000 ALTER TABLE `facilities` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `facilities` VALUES
(1,'Dormitory','dormitory','Bunk bed dormitories fitted with hot water geysers. Maximum 40 pax per dormitory. Multiple dormitories available for larger groups up to 75 people.',12.00,'per_person_per_night',75,'bed',1,1,'2026-06-09 12:37:30','2026-06-09 12:37:30'),
(2,'Auditorium / Gazebo','auditorium','Seats 100 people. Equipped with projector, speakers and printer. Perfect for conferences, worship sessions and presentations.',100.00,'per_day',100,'building',1,2,'2026-06-09 12:37:30','2026-06-09 12:37:30'),
(3,'Kitchen','kitchen','Gas-powered kitchen with three-plate gas stove, two 50kg gas tanks and a fridge. Note: utensils not provided.',60.00,'per_day',NULL,'chef-hat',1,3,'2026-06-09 12:37:30','2026-06-09 12:37:30'),
(4,'Chairs','chairs','Chairs available for use in the auditorium and outdoor areas.',0.50,'per_day_per_unit',NULL,'armchair',1,4,'2026-06-09 12:37:30','2026-06-09 12:37:30'),
(5,'Outdoor Camp','outdoor-camp','Tent camping area for up to 200 people. Includes hot water showers, bathrooms, toilets and a gas-powered cooking area.',8.00,'per_person_per_day',200,'tent',1,5,'2026-06-09 12:37:30','2026-06-09 12:37:30');
/*!40000 ALTER TABLE `facilities` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'general',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_images`
--

LOCK TABLES `gallery_images` WRITE;
/*!40000 ALTER TABLE `gallery_images` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `gallery_images` VALUES
(1,'img_6a281b0089efc.jpeg',NULL,'general',1,1,'2026-06-09 13:54:08','2026-06-09 13:54:08'),
(2,'img_6a281b0791008.jpeg',NULL,'general',2,1,'2026-06-09 13:54:15','2026-06-09 13:54:15');
/*!40000 ALTER TABLE `gallery_images` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `migrations` VALUES
(1,'2024_01_01_000001_create_facilities_table',1),
(2,'2024_01_01_000002_create_activities_table',1),
(3,'2024_01_01_000003_create_bookings_table',1),
(4,'2024_01_01_000004_create_booking_facilities_table',1),
(5,'2024_01_01_000005_create_booking_activities_table',1),
(6,'2024_01_01_000006_create_gallery_images_table',1),
(7,'2024_01_01_000007_create_blocked_dates_table',1),
(8,'2024_01_01_000008_create_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) DEFAULT NULL,
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
set autocommit=0;
INSERT INTO `users` VALUES
(1,'Eve Mountain Admin','admin@evemountain.com','$2y$12$hMEldA6GAhks2wx989YKSeLHdB/wN4DZczuGZQVPmeeMJNm6Ci8u2','admin',NULL,'2026-06-09 12:37:30','2026-06-09 12:37:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-06-10 13:36:21
