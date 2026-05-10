-- MySQL dump 10.13  Distrib 9.6.0, for macos26.3 (arm64)
--
-- Host: localhost    Database: room_booking_system
-- ------------------------------------------------------
-- Server version	9.6.0

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'd06ead0e-37bc-11f1-8f34-6074255c60cc:1-3429';

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `equipment`
--

DROP TABLE IF EXISTS `equipment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL,
  `category` enum('audio','video','accessory','computer','networking') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment`
--

LOCK TABLES `equipment` WRITE;
/*!40000 ALTER TABLE `equipment` DISABLE KEYS */;
INSERT INTO `equipment` VALUES (1,'EQ001','Epson Projector HD',5,'video','2026-05-09 20:08:51','2026-05-09 20:08:51'),(2,'EQ002','Sony 4K Camera',3,'video','2026-05-09 20:08:51','2026-05-09 20:08:51'),(3,'EQ003','Canon DSLR Camera',4,'video','2026-05-09 20:08:51','2026-05-09 20:08:51'),(4,'EQ004','JBL Wireless Microphone',8,'audio','2026-05-09 20:08:51','2026-05-09 20:08:51'),(5,'EQ005','Shure Dynamic Mic',6,'audio','2026-05-09 20:08:51','2026-05-09 20:08:51'),(6,'EQ006','Portable Speaker BOSE',4,'audio','2026-05-09 20:08:51','2026-05-09 20:08:51'),(7,'EQ007','Tripod Stand Heavy Duty',6,'accessory','2026-05-09 20:08:51','2026-05-09 20:08:51'),(8,'EQ008','HDMI Cable 5m',20,'accessory','2026-05-09 20:08:51','2026-05-09 20:08:51'),(9,'EQ009','Extension Power Strip',10,'accessory','2026-05-09 20:08:51','2026-05-09 20:08:51'),(10,'EQ010','MacBook Pro 16\"',2,'computer','2026-05-09 20:08:51','2026-05-09 20:08:51'),(11,'EQ011','Windows Laptop Dell XPS',3,'computer','2026-05-09 20:08:51','2026-05-09 20:08:51'),(12,'EQ012','Wireless Keyboard & Mouse Set',12,'computer','2026-05-09 20:08:51','2026-05-09 20:08:51'),(13,'EQ013','TP-Link Router AC1200',5,'networking','2026-05-09 20:08:51','2026-05-09 20:08:51'),(14,'EQ014','Network Switch 8-Port',4,'networking','2026-05-09 20:08:51','2026-05-09 20:08:51'),(15,'EQ015','LAN Cable Cat6 (10m)',25,'networking','2026-05-09 20:08:51','2026-05-09 20:08:51');
/*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_bookings`
--

DROP TABLE IF EXISTS `equipment_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment_bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_booking_id` bigint unsigned NOT NULL,
  `equipment_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipment_bookings_room_booking_id_equipment_id_unique` (`room_booking_id`,`equipment_id`),
  KEY `equipment_bookings_equipment_id_foreign` (`equipment_id`),
  CONSTRAINT `equipment_bookings_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `equipment_bookings_room_booking_id_foreign` FOREIGN KEY (`room_booking_id`) REFERENCES `room_bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_bookings`
--

LOCK TABLES `equipment_bookings` WRITE;
/*!40000 ALTER TABLE `equipment_bookings` DISABLE KEYS */;
INSERT INTO `equipment_bookings` VALUES (1,1,8,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(2,1,15,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(3,2,9,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(4,2,12,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(5,3,1,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(6,3,4,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(7,3,8,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(8,4,1,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(9,4,10,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(10,5,10,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(11,6,3,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(12,6,4,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(13,6,8,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(14,7,6,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(15,7,10,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(16,8,12,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(17,8,13,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(18,9,10,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(19,9,14,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(20,9,15,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(21,10,2,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(22,10,8,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(23,10,14,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(24,11,1,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(25,11,8,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(26,11,15,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(27,12,5,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(28,13,7,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(29,13,15,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(30,14,6,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(31,14,8,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(32,14,15,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(33,15,3,2,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(34,16,5,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(35,16,9,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(36,16,15,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(37,17,1,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(38,17,14,1,'2026-05-09 20:08:51','2026-05-09 20:08:51'),(39,18,15,1,'2026-05-09 20:08:51','2026-05-09 20:08:51');
/*!40000 ALTER TABLE `equipment_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_09_045410_create_rooms_table',1),(5,'2026_05_09_051224_create_bookings_table',1),(6,'2026_05_09_083143_create_equipment_table',1),(7,'2026_05_09_112151_create_equipment_bookings_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `room_bookings`
--

DROP TABLE IF EXISTS `room_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room_bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `room_id` bigint unsigned NOT NULL,
  `booking_date` date NOT NULL,
  `usage_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('pending','approved','rejected','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `purpose` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_bookings_user_id_foreign` (`user_id`),
  KEY `room_bookings_room_id_foreign` (`room_id`),
  CONSTRAINT `room_bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `room_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_bookings`
--

LOCK TABLES `room_bookings` WRITE;
/*!40000 ALTER TABLE `room_bookings` DISABLE KEYS */;
INSERT INTO `room_bookings` VALUES (1,3,13,'2026-05-05','2026-05-07','10:00:00','11:00:00','approved','Past booking scenario #1','2026-05-09 20:08:51','2026-05-09 20:08:51'),(2,11,13,'2026-04-28','2026-04-30','13:00:00','14:00:00','rejected','Past booking scenario #2','2026-05-09 20:08:51','2026-05-09 20:08:51'),(3,8,15,'2026-04-27','2026-04-29','08:00:00','10:00:00','approved','Past booking scenario #3','2026-05-09 20:08:51','2026-05-09 20:08:51'),(4,11,4,'2026-04-28','2026-04-30','08:00:00','11:00:00','completed','Past booking scenario #4','2026-05-09 20:08:51','2026-05-09 20:08:51'),(5,4,3,'2026-04-27','2026-04-29','12:00:00','14:00:00','approved','Past booking scenario #5','2026-05-09 20:08:51','2026-05-09 20:08:51'),(6,3,3,'2026-04-24','2026-04-26','11:00:00','14:00:00','rejected','Past booking scenario #6','2026-05-09 20:08:51','2026-05-09 20:08:51'),(7,7,6,'2026-04-29','2026-05-01','14:00:00','16:00:00','approved','Past booking scenario #7','2026-05-09 20:08:51','2026-05-09 20:08:51'),(8,10,1,'2026-04-26','2026-04-28','14:00:00','17:00:00','rejected','Past booking scenario #8','2026-05-09 20:08:51','2026-05-09 20:08:51'),(9,5,12,'2026-05-10','2026-05-19','14:00:00','17:00:00','pending','Upcoming booking #1','2026-05-09 20:08:51','2026-05-09 20:08:51'),(10,3,8,'2026-05-10','2026-05-15','08:00:00','10:00:00','pending','Upcoming booking #2','2026-05-09 20:08:51','2026-05-09 20:08:51'),(11,2,3,'2026-05-10','2026-05-11','11:00:00','12:00:00','pending','Upcoming booking #3','2026-05-09 20:08:51','2026-05-09 20:08:51'),(12,9,3,'2026-05-10','2026-05-12','12:00:00','14:00:00','pending','Upcoming booking #4','2026-05-09 20:08:51','2026-05-09 20:08:51'),(13,2,4,'2026-05-10','2026-05-20','14:00:00','17:00:00','pending','Upcoming booking #5','2026-05-09 20:08:51','2026-05-09 20:08:51'),(14,3,2,'2026-05-10','2026-05-14','11:00:00','14:00:00','pending','Upcoming booking #6','2026-05-09 20:08:51','2026-05-09 20:08:51'),(15,3,3,'2026-05-10','2026-05-12','13:00:00','16:00:00','pending','Upcoming booking #7','2026-05-09 20:08:51','2026-05-09 20:08:51'),(16,9,14,'2026-05-10','2026-05-16','09:00:00','10:00:00','pending','Upcoming booking #8','2026-05-09 20:08:51','2026-05-09 20:08:51'),(17,5,1,'2026-05-10','2026-05-16','13:00:00','16:00:00','pending','Upcoming booking #9','2026-05-09 20:08:51','2026-05-09 20:08:51'),(18,10,6,'2026-05-10','2026-05-19','10:00:00','11:00:00','pending','Upcoming booking #10','2026-05-09 20:08:51','2026-05-09 20:08:51');
/*!40000 ALTER TABLE `room_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int NOT NULL,
  `capacity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'2026-05-09 20:08:51','2026-05-09 20:08:51','Lab Komputer 1','Gedung A',3,30),(2,'2026-05-09 20:08:51','2026-05-09 20:08:51','Lab Komputer 2','Gedung A',4,35),(3,'2026-05-09 20:08:51','2026-05-09 20:08:51','Lab AI & Data Science','Gedung C',2,25),(4,'2026-05-09 20:08:51','2026-05-09 20:08:51','Ruang Kelas A101','Gedung A',1,40),(5,'2026-05-09 20:08:51','2026-05-09 20:08:51','Ruang Kelas A102','Gedung A',1,40),(6,'2026-05-09 20:08:51','2026-05-09 20:08:51','Ruang Kelas B201','Gedung B',2,50),(7,'2026-05-09 20:08:51','2026-05-09 20:08:51','Ruang Kelas B202','Gedung B',2,50),(8,'2026-05-09 20:08:51','2026-05-09 20:08:51','Meeting Room Alpha','Gedung B',5,12),(9,'2026-05-09 20:08:51','2026-05-09 20:08:51','Meeting Room Beta','Gedung B',5,15),(10,'2026-05-09 20:08:51','2026-05-09 20:08:51','Auditorium Utama','Gedung B',7,500),(11,'2026-05-09 20:08:51','2026-05-09 20:08:51','Studio Foto & Video','Gedung A',12,12),(12,'2026-05-09 20:08:51','2026-05-09 20:08:51','Music Recording Studio','Gedung C',6,8),(13,'2026-05-09 20:08:51','2026-05-09 20:08:51','Innovation Lab','Gedung C',3,20),(14,'2026-05-09 20:08:51','2026-05-09 20:08:51','Discussion Room 1','Gedung A',2,6),(15,'2026-05-09 20:08:51','2026-05-09 20:08:51','Discussion Room 2','Gedung A',2,6);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('student','lecturer','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_identity_number_unique` (`identity_number`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','+628129214482','00000000001','admin','admin@gmail.com','2026-05-09 20:08:49','$2y$12$jr.4vee5kljNio5avIn8quriUoP9gniT/T.r4UK0CeORX9nnDhJJS','PXMyH1naU1','2026-05-09 20:08:49','2026-05-09 20:08:49'),(2,'Dr. Andi Wijaya','+628112223334','197801011234','lecturer','andi.wijaya@university.ac.id','2026-05-09 20:08:49','$2y$12$lEfMBNteIGCxM1viSezxUeoa0b6ikclAA574uyh0jild0GsY.ivye','tLC71b8CZG','2026-05-09 20:08:49','2026-05-09 20:08:49'),(3,'Prof. Siti Rahma','+628133445566','197502022345','lecturer','siti.rahma@university.ac.id','2026-05-09 20:08:49','$2y$12$n4b05G5CLa0aXh7/7hWPw.EoEDmkSodCvixb01nnz9g.0Hh6mAkoq','yIgZIZtXCg','2026-05-09 20:08:49','2026-05-09 20:08:49'),(4,'Budi Santoso','+628199887766','198003033456','lecturer','budi.santoso@university.ac.id','2026-05-09 20:08:50','$2y$12$Ze7/HNP0E7gFKKRuZCjIk.S2gBqCJMSHBRhYudEX2E.mDv4B1UArm','584pP2zFGj','2026-05-09 20:08:50','2026-05-09 20:08:50'),(5,'Ahmad Rizky','+628521112233','220601001','student','ahmad.rizky@student.ac.id','2026-05-09 20:08:50','$2y$12$Jy4Gq9wIOy.I1GF7Pg5HPu5T4iq1s0RaDaFS2meF7eKLUhq.PESvW','rr4oOwwPU4','2026-05-09 20:08:50','2026-05-09 20:08:50'),(6,'Salsa Aulia','+628522223344','220601002','student','salsa.aulia@student.ac.id','2026-05-09 20:08:50','$2y$12$wFjFewvFE1Kqfoag/x/7CudekWcFoZuOtTlKFUTrCHRrykwg9xmyy','Lm7FbTHFz0','2026-05-09 20:08:50','2026-05-09 20:08:50'),(7,'Rina Putri','+628533334455','220601003','student','rina.putri@student.ac.id','2026-05-09 20:08:50','$2y$12$9ixC146FjV2GdY5Biba.FebKpzA1s2MC1L5nQKe6gz1Vw2TyZw51.','JjQnvHMEYu','2026-05-09 20:08:50','2026-05-09 20:08:50'),(8,'Dimas Pratama','+628544445566','220601004','student','dimas.pratama@student.ac.id','2026-05-09 20:08:50','$2y$12$Ba/ywKMmRBVs6Hre8dFKT.yQlcJgxCpbV8kBo3V3J7NDySZcHfPe6','uuiNf2Bj8T','2026-05-09 20:08:50','2026-05-09 20:08:50'),(9,'Kevin Nugraha','+628555556677','220601005','student','kevin.nugraha@student.ac.id','2026-05-09 20:08:50','$2y$12$JE54tRcvdZWhtFmITSxJ3eXjXSafOzi9ubu8L896rfMfqOAx3D6Yi','qX3ErtF3Ib','2026-05-09 20:08:50','2026-05-09 20:08:50'),(10,'Nadia Lestari','+628566667788','220601006','student','nadia.lestari@student.ac.id','2026-05-09 20:08:51','$2y$12$4rIZqllI2XN1UGUm/CJtu.YWFu6a0N0r7rIqGOUejI8ZCgd8XOwae','AEzmrzXY1s','2026-05-09 20:08:51','2026-05-09 20:08:51'),(11,'Derend Marvel','+6285785541218','0706012210030','student','derend101@gmail.com','2026-05-09 20:08:51','$2y$12$kc18uwH23.XqnMKJtfYRO.rpu.Y/C5oeGjxRCG5LaV31dv6Hx1dDG','GOtioxmZUn','2026-05-09 20:08:51','2026-05-09 20:08:51');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-10 10:10:33
