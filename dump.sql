-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: 127.0.0.1
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `number` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collegeUID` int(10) unsigned NOT NULL,
  `balance` double(20,4) NOT NULL,
  `onHold` tinyint(1) NOT NULL DEFAULT '0',
  `createdBy` int(10) unsigned NOT NULL DEFAULT '0',
  `type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `queueID` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `limit` int(11) DEFAULT '0',
  PRIMARY KEY (`number`),
  KEY `accounts_collegeuid_foreign` (`collegeUID`),
  KEY `accounts_createdby_foreign` (`createdBy`),
  CONSTRAINT `accounts_collegeuid_foreign` FOREIGN KEY (`collegeUID`) REFERENCES `users` (`collegeUID`) ON DELETE CASCADE,
  CONSTRAINT `accounts_createdby_foreign` FOREIGN KEY (`createdBy`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB AUTO_INCREMENT=99887768 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`number`, `name`, `collegeUID`, `balance`, `onHold`, `createdBy`, `type`, `queueID`, `created_at`, `updated_at`, `limit`) VALUES (999801,'July Test Event - Cash Account',99887766,7500.0000,0,11711106,25,0,'2019-06-01 22:14:26','2019-06-01 22:14:26',0),(999802,'July Test Event - Expenses Account',99887766,-3000.0000,0,11711106,25,0,'2019-06-01 22:14:26','2019-06-01 22:14:26',0),(999803,'July Test Event - Online Account',99887766,0.0000,0,11711106,25,0,'2019-06-01 22:14:27','2019-06-01 22:14:27',0),(999804,'July Test Event - Promotion Account',99887766,0.0000,0,11711106,25,0,'2019-06-01 22:14:26','2019-06-01 22:14:26',0),(11171115,'test6hm g dfgv - Standard Account',11171115,0.0000,1,11711106,0,0,'2019-06-02 00:17:51','2019-06-02 00:17:51',0),(11171129,'test6sshm gss dfgv - Standard Account',11171129,0.0000,1,11711106,0,0,'2019-06-02 00:35:49','2019-06-02 00:35:49',0),(11701000,'radha kumari - Standard Account',11701000,0.0000,1,11709456,0,0,'2019-06-14 09:37:45','2019-06-14 09:37:45',0),(11709456,'Anukriti Gupta - Standard Account',11709456,-35499.0000,0,99887766,0,0,'2019-02-19 16:33:19','2019-02-19 16:33:17',0),(11709495,'Neel Gupta - Standard Account',11709495,0.0000,1,11711106,0,0,'2019-06-12 02:20:16','2019-06-12 02:20:16',0),(11711106,'Pawan Kumar - Standard Account',11711106,-2451.0000,0,99887766,0,0,'2019-02-19 16:33:19','2019-02-19 16:33:17',0),(11711109,'Siddharth Verma - Standard Account',11711109,-550.0000,1,11711106,0,0,'2019-06-10 20:35:57','2019-06-10 20:35:57',0),(11711129,'TestStudent Two - Standard Account',11711129,0.0000,1,11711106,0,0,'2019-06-03 08:15:51','2019-06-03 08:15:51',0),(11711756,'Rohit Gupta - Standard Account',11711756,-1000.0000,1,11709456,0,0,'2019-06-14 11:01:36','2019-06-14 11:01:36',0),(11711789,'Neelam - Standard Account',11711789,0.0000,1,11711106,0,0,'2019-06-12 02:29:40','2019-06-12 02:29:40',0),(99887766,'Queues - Transactions - Waiting Approval',99887766,35000.0000,0,99887766,100,100,'2019-02-20 08:42:02','2019-02-20 08:42:08',0),(99887767,'Queues - Transactions - Approved',99887766,0.0000,0,99887766,100,101,'2019-02-20 08:46:39','2019-02-20 08:46:42',0);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

--
-- Table structure for table `advertisements`
--

DROP TABLE IF EXISTS `advertisements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertisements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertisements`
--

/*!40000 ALTER TABLE `advertisements` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertisements` ENABLE KEYS */;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attendeeUID` int(10) unsigned NOT NULL,
  `coordinatorUID` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verifiedBy` int(10) unsigned DEFAULT NULL,
  `dateID` bigint(20) unsigned NOT NULL,
  `enrollmentID` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendance_coordinatoruid_foreign` (`coordinatorUID`),
  KEY `attendance_attendeeuid_foreign` (`attendeeUID`),
  CONSTRAINT `attendance_attendeeuid_foreign` FOREIGN KEY (`attendeeUID`) REFERENCES `users` (`collegeUID`),
  CONSTRAINT `attendance_coordinatoruid_foreign` FOREIGN KEY (`coordinatorUID`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` (`id`, `attendeeUID`, `coordinatorUID`, `created_at`, `updated_at`, `verified`, `verifiedBy`, `dateID`, `enrollmentID`) VALUES (77,11701000,11711106,'2019-06-15 20:24:03','2019-06-15 20:24:03',0,NULL,4,5);
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;

--
-- Table structure for table `authorizations`
--

DROP TABLE IF EXISTS `authorizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authorizations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authorizations`
--

/*!40000 ALTER TABLE `authorizations` DISABLE KEYS */;
/*!40000 ALTER TABLE `authorizations` ENABLE KEYS */;

--
-- Table structure for table `awards`
--

DROP TABLE IF EXISTS `awards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `awards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `eventID` bigint(20) unsigned NOT NULL,
  `collegeUID` int(10) unsigned DEFAULT NULL,
  `itemID` int(10) unsigned DEFAULT NULL,
  `teamID` int(10) unsigned DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `awards_eventid_foreign` (`eventID`),
  KEY `awards_collegeuid_foreign` (`collegeUID`),
  CONSTRAINT `awards_collegeuid_foreign` FOREIGN KEY (`collegeUID`) REFERENCES `users` (`collegeUID`),
  CONSTRAINT `awards_eventid_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `awards`
--

/*!40000 ALTER TABLE `awards` DISABLE KEYS */;
/*!40000 ALTER TABLE `awards` ENABLE KEYS */;

--
-- Table structure for table `budgets`
--

DROP TABLE IF EXISTS `budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budgets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budgets`
--

/*!40000 ALTER TABLE `budgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `budgets` ENABLE KEYS */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `intendedUID` int(10) unsigned NOT NULL,
  `issuedBy` int(10) unsigned NOT NULL,
  `amount` double(16,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `eventID` bigint(20) unsigned NOT NULL,
  `participantCollegeUID` int(10) unsigned NOT NULL,
  `facilitatorCollegeUID` int(10) unsigned NOT NULL,
  `fundTransactionID` bigint(20) unsigned DEFAULT NULL,
  `enrollmentFeesTransactionID` bigint(20) unsigned NOT NULL,
  `partialPay` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teamID` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enrollments_eventid_foreign` (`eventID`),
  KEY `enrollments_participantcollegeuid_foreign` (`participantCollegeUID`),
  KEY `enrollments_facilitatorcollegeuid_foreign` (`facilitatorCollegeUID`),
  KEY `enrollments_fundtransactionid_foreign` (`fundTransactionID`),
  KEY `enrollments_enrollmentfeestransactionid_foreign` (`enrollmentFeesTransactionID`),
  CONSTRAINT `enrollments_enrollmentfeestransactionid_foreign` FOREIGN KEY (`enrollmentFeesTransactionID`) REFERENCES `transactions` (`id`),
  CONSTRAINT `enrollments_eventid_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`id`),
  CONSTRAINT `enrollments_facilitatorcollegeuid_foreign` FOREIGN KEY (`facilitatorCollegeUID`) REFERENCES `users` (`collegeUID`),
  CONSTRAINT `enrollments_fundtransactionid_foreign` FOREIGN KEY (`fundTransactionID`) REFERENCES `transactions` (`id`),
  CONSTRAINT `enrollments_participantcollegeuid_foreign` FOREIGN KEY (`participantCollegeUID`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollments`
--

/*!40000 ALTER TABLE `enrollments` DISABLE KEYS */;
INSERT INTO `enrollments` (`id`, `eventID`, `participantCollegeUID`, `facilitatorCollegeUID`, `fundTransactionID`, `enrollmentFeesTransactionID`, `partialPay`, `created_at`, `updated_at`, `teamID`) VALUES (1,8,11711109,11711106,56,57,1,'2019-06-10 20:35:58',NULL,12),(2,8,11709495,11711106,58,59,0,'2019-06-12 02:20:17','2019-06-14 13:03:20',13),(4,3,11709495,11711106,58,59,0,'2019-06-12 02:20:17',NULL,11),(5,8,11701000,11709456,63,64,0,'2019-06-14 09:37:45',NULL,11),(6,8,11711756,11709456,65,66,1,'2019-06-14 11:01:36',NULL,13);
/*!40000 ALTER TABLE `enrollments` ENABLE KEYS */;

--
-- Table structure for table `eventdates`
--

DROP TABLE IF EXISTS `eventdates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventdates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `motive` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `coordinatorsRequired` int(10) unsigned NOT NULL DEFAULT '1',
  `eventID` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attendanceState` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `eventdates_eventid_foreign` (`eventID`),
  CONSTRAINT `eventdates_eventid_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventdates`
--

/*!40000 ALTER TABLE `eventdates` DISABLE KEYS */;
INSERT INTO `eventdates` (`id`, `date`, `motive`, `description`, `startTime`, `endTime`, `coordinatorsRequired`, `eventID`, `created_at`, `updated_at`, `attendanceState`) VALUES (1,'2019-07-01','Day 1','basics','13:00:00','16:00:00',1,8,'2019-06-01 22:16:44','2019-06-01 22:16:44',0),(2,'2019-07-04','motivation','basic','07:00:00','09:00:00',1,8,'2019-06-01 22:16:44','2019-06-01 22:16:44',0),(3,'2019-07-07','last day',NULL,'11:00:00','12:00:00',1,8,'2019-06-01 22:16:44','2019-06-01 22:16:44',0),(4,'2019-06-12','test day','test decs','11:00:00','12:00:00',10,8,'2019-06-01 22:16:44','2019-06-15 20:24:03',1);
/*!40000 ALTER TABLE `eventdates` ENABLE KEYS */;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requesterID` int(10) unsigned NOT NULL,
  `approvalID` int(10) unsigned NOT NULL DEFAULT '0',
  `ticketPrice` int(10) unsigned NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `seats` int(10) unsigned NOT NULL,
  `teaming` tinyint(1) NOT NULL DEFAULT '0',
  `maxIncentiveRate` double(5,2) NOT NULL,
  `supportMail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supportMobile` bigint(20) unsigned DEFAULT NULL,
  `altSupportMobile` bigint(20) unsigned DEFAULT NULL,
  `minimumPayment` tinyint(3) unsigned NOT NULL DEFAULT '100',
  `approvalStatus` tinyint(1) NOT NULL DEFAULT '0',
  `approvalDate` date DEFAULT NULL,
  `fillingStatus` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `minimumUserPower` smallint(5) unsigned NOT NULL DEFAULT '0',
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `filledSeats` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_requesterid_foreign` (`requesterID`),
  KEY `events_approvalid_foreign` (`approvalID`),
  CONSTRAINT `events_approvalid_foreign` FOREIGN KEY (`approvalID`) REFERENCES `users` (`collegeUID`),
  CONSTRAINT `events_requesterid_foreign` FOREIGN KEY (`requesterID`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` (`id`, `name`, `requesterID`, `approvalID`, `ticketPrice`, `startDate`, `endDate`, `seats`, `teaming`, `maxIncentiveRate`, `supportMail`, `supportMobile`, `altSupportMobile`, `minimumPayment`, `approvalStatus`, `approvalDate`, `fillingStatus`, `minimumUserPower`, `visibility`, `filledSeats`, `created_at`, `updated_at`) VALUES (1,'testevent1',11709456,11709456,100,'2019-06-30 20:25:06','2019-06-30 20:25:16',100,0,0.00,'',97988987987,8979889799,100,1,'2019-06-01',1,0,1,0,NULL,NULL),(2,'testevent2',11709456,11711106,100,'2019-06-30 20:25:06','2019-06-30 20:25:16',100,0,0.00,'',97988987987,8979889799,100,1,'2019-06-01',1,0,1,0,NULL,NULL),(3,'eventTeamable1',11709456,11711106,100,'2019-06-30 20:25:06','2019-06-30 20:25:16',100,1,0.00,'',97988987987,8979889799,100,1,'2019-06-01',1,0,1,0,NULL,NULL),(8,'July Test Event',11711106,11711106,1500,'2019-07-01 00:00:00','2019-07-07 00:00:00',509,1,12.00,'support@sdsd.sds',8080808080,8070807080,30,1,'2019-01-01',1,0,1,8,'2019-06-01 22:14:26','2019-06-01 22:14:26');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `eventID` bigint(20) unsigned NOT NULL,
  `collegeUID` int(10) unsigned NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_eventid_foreign` (`eventID`),
  KEY `feedback_collegeuid_foreign` (`collegeUID`),
  CONSTRAINT `feedback_collegeuid_foreign` FOREIGN KEY (`collegeUID`) REFERENCES `users` (`collegeUID`),
  CONSTRAINT `feedback_eventid_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;

--
-- Table structure for table `gateways`
--

DROP TABLE IF EXISTS `gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gateways` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gateways`
--

/*!40000 ALTER TABLE `gateways` DISABLE KEYS */;
/*!40000 ALTER TABLE `gateways` ENABLE KEYS */;

--
-- Table structure for table `invitations`
--

DROP TABLE IF EXISTS `invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invitations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `intendedUID` int(10) unsigned NOT NULL,
  `eventID` bigint(20) unsigned NOT NULL,
  `invitedBy` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invitations_intendeduid_foreign` (`intendedUID`),
  KEY `invitations_eventid_foreign` (`eventID`),
  KEY `invitations_invitedby_foreign` (`invitedBy`),
  CONSTRAINT `invitations_eventid_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`id`),
  CONSTRAINT `invitations_intendeduid_foreign` FOREIGN KEY (`intendedUID`) REFERENCES `users` (`collegeUID`),
  CONSTRAINT `invitations_invitedby_foreign` FOREIGN KEY (`invitedBy`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitations`
--

/*!40000 ALTER TABLE `invitations` DISABLE KEYS */;
/*!40000 ALTER TABLE `invitations` ENABLE KEYS */;

--
-- Table structure for table `mentors`
--

DROP TABLE IF EXISTS `mentors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mentors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `groupID` bigint(20) unsigned NOT NULL,
  `memberID` int(10) unsigned NOT NULL,
  `eventID` bigint(20) unsigned NOT NULL,
  `memberType` smallint(5) unsigned NOT NULL DEFAULT '0',
  `dayID` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mentors_memberid_foreign` (`memberID`),
  KEY `mentors_eventid_foreign` (`eventID`),
  KEY `mentors_dayid_foreign` (`dayID`),
  CONSTRAINT `mentors_dayid_foreign` FOREIGN KEY (`dayID`) REFERENCES `eventdates` (`id`),
  CONSTRAINT `mentors_eventid_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`id`),
  CONSTRAINT `mentors_memberid_foreign` FOREIGN KEY (`memberID`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mentors`
--

/*!40000 ALTER TABLE `mentors` DISABLE KEYS */;
/*!40000 ALTER TABLE `mentors` ENABLE KEYS */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_06_01_000001_create_oauth_auth_codes_table',1),(4,'2016_06_01_000002_create_oauth_access_tokens_table',1),(5,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(6,'2016_06_01_000004_create_oauth_clients_table',1),(7,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(8,'2019_02_03_165119_create_roles_table',1),(9,'2019_02_03_165144_create_events_table',1),(10,'2019_02_03_165212_create_accounts_table',1),(11,'2019_02_03_165234_create_transactions_table',1),(12,'2019_02_03_165306_create_expenses_table',1),(13,'2019_02_03_165321_create_stocks_table',1),(14,'2019_02_03_165334_create_projects_table',1),(15,'2019_02_03_170600_create_budgets_table',1),(16,'2019_02_03_170615_create_awards_table',1),(17,'2019_02_03_170628_create_venues_table',1),(18,'2019_02_03_170637_create_pages_table',1),(19,'2019_02_03_170709_create_enrollments_table',1),(20,'2019_02_03_170731_create_coupons_table',1),(21,'2019_02_03_170751_create_gateways_table',1),(22,'2019_02_03_170805_create_requests_table',1),(23,'2019_02_03_170847_create_feedback_table',1),(24,'2019_02_03_170941_create_queues_table',1),(25,'2019_02_03_170959_create_invitations_table',1),(26,'2019_02_03_171055_create_responsibilites_table',1),(27,'2019_02_03_171107_create_tasks_table',1),(28,'2019_02_03_173039_create_attendence_table',1),(29,'2019_02_03_173107_create_sponsorships_table',1),(30,'2019_02_03_173135_create_teams_table',1),(31,'2019_02_03_173158_create_teammates_table',1),(32,'2019_02_03_173220_create_venuetypes_table',1),(33,'2019_02_03_173256_create_advertisements_table',1),(34,'2019_02_03_173312_create_stock_items_table',1),(35,'2019_02_08_143029_create_user_navigation_titles_table',1),(36,'2019_02_08_143115_create_user_navigation_table',1),(37,'2019_02_09_093741_create_comments_table',1),(38,'2019_02_16_162543_create_authorizations_table',1),(39,'2019_02_16_162642_create_system_table',1),(40,'2019_02_21_022046_create_smartcards_table',1),(41,'2019_05_30_032427_create_targets_table',1),(42,'2019_05_31_140546_create_eventdates_table',1),(43,'2019_05_31_140656_create_mentors_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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

/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

--
-- Table structure for table `queues`
--

DROP TABLE IF EXISTS `queues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `requesterRemarks` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci,
  `approveTimeRemarks` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestedBy` int(10) unsigned NOT NULL,
  `approvedBy` int(10) unsigned NOT NULL DEFAULT '0',
  `authenticationLevel` smallint(5) unsigned NOT NULL,
  `type` smallint(5) unsigned NOT NULL,
  `isApproved` tinyint(1) NOT NULL DEFAULT '0',
  `specificApproval` int(10) unsigned NOT NULL DEFAULT '0',
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `approvalTime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `typeMessage` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queues`
--

/*!40000 ALTER TABLE `queues` DISABLE KEYS */;
INSERT INTO `queues` (`id`, `requesterRemarks`, `parameters`, `approveTimeRemarks`, `requestedBy`, `approvedBy`, `authenticationLevel`, `type`, `isApproved`, `specificApproval`, `visibility`, `approvalTime`, `created_at`, `updated_at`, `typeMessage`) VALUES (42,'Attendance Marked','8',NULL,11709456,0,1000,505,0,0,1,NULL,'2019-06-15 08:34:36','2019-06-15 08:34:36','Attendance Approval'),(43,'att','8',NULL,11711106,0,1000,505,0,0,1,NULL,NULL,NULL,NULL),(44,'money transfer','8',NULL,11711106,0,1000,100,0,0,1,NULL,NULL,NULL,'money rqst'),(45,'Attendance Marked','8',NULL,11709456,0,1000,505,0,0,1,NULL,'2019-06-15 20:17:32','2019-06-15 20:17:32','Attendance Approval'),(46,'Attendance Marked','8',NULL,11711106,0,1000,505,0,0,1,NULL,'2019-06-15 20:24:03','2019-06-15 20:24:03','Attendance Approval');
/*!40000 ALTER TABLE `queues` ENABLE KEYS */;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `requesterCollegeUID` int(10) unsigned NOT NULL,
  `approverCollegeUID` int(10) unsigned NOT NULL,
  `type` smallint(5) unsigned NOT NULL,
  `levelRequired` smallint(5) unsigned NOT NULL,
  `requestReason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `approvalRemarks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionID` bigint(20) unsigned DEFAULT NULL,
  `queueID` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `requests_requestercollegeuid_foreign` (`requesterCollegeUID`),
  KEY `requests_approvercollegeuid_foreign` (`approverCollegeUID`),
  KEY `requests_transactionid_foreign` (`transactionID`),
  CONSTRAINT `requests_approvercollegeuid_foreign` FOREIGN KEY (`approverCollegeUID`) REFERENCES `users` (`collegeUID`),
  CONSTRAINT `requests_requestercollegeuid_foreign` FOREIGN KEY (`requesterCollegeUID`) REFERENCES `users` (`collegeUID`),
  CONSTRAINT `requests_transactionid_foreign` FOREIGN KEY (`transactionID`) REFERENCES `transactions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;

--
-- Table structure for table `responsibilites`
--

DROP TABLE IF EXISTS `responsibilites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responsibilites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsibilites`
--

/*!40000 ALTER TABLE `responsibilites` DISABLE KEYS */;
/*!40000 ALTER TABLE `responsibilites` ENABLE KEYS */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorityGrant` smallint(5) unsigned NOT NULL,
  `creatorUID` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_creatoruid_foreign` (`creatorUID`),
  CONSTRAINT `roles_creatoruid_foreign` FOREIGN KEY (`creatorUID`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

--
-- Table structure for table `smartcards`
--

DROP TABLE IF EXISTS `smartcards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `smartcards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sIDA` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sIDB` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sIDC` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sIDD` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sIDE` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `touched` tinyint(1) NOT NULL DEFAULT '0',
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `redeemTimeStamp` datetime DEFAULT NULL,
  `studentCollegeUID` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `eventID` bigint(20) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `smartcards_sida_sidb_sidc_sidd_side_unique` (`sIDA`,`sIDB`,`sIDC`,`sIDD`,`sIDE`),
  KEY `smartcards_studentcollegeuid_foreign` (`studentCollegeUID`),
  CONSTRAINT `smartcards_studentcollegeuid_foreign` FOREIGN KEY (`studentCollegeUID`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smartcards`
--

/*!40000 ALTER TABLE `smartcards` DISABLE KEYS */;
/*!40000 ALTER TABLE `smartcards` ENABLE KEYS */;

--
-- Table structure for table `sponsorships`
--

DROP TABLE IF EXISTS `sponsorships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sponsorships` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sponsorships`
--

/*!40000 ALTER TABLE `sponsorships` DISABLE KEYS */;
/*!40000 ALTER TABLE `sponsorships` ENABLE KEYS */;

--
-- Table structure for table `stock_items`
--

DROP TABLE IF EXISTS `stock_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_items`
--

/*!40000 ALTER TABLE `stock_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_items` ENABLE KEYS */;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;

--
-- Table structure for table `system`
--

DROP TABLE IF EXISTS `system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system`
--

/*!40000 ALTER TABLE `system` DISABLE KEYS */;
/*!40000 ALTER TABLE `system` ENABLE KEYS */;

--
-- Table structure for table `targets`
--

DROP TABLE IF EXISTS `targets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `targets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `targets`
--

/*!40000 ALTER TABLE `targets` DISABLE KEYS */;
/*!40000 ALTER TABLE `targets` ENABLE KEYS */;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

--
-- Table structure for table `teammates`
--

DROP TABLE IF EXISTS `teammates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teammates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `teamID` bigint(20) unsigned NOT NULL,
  `collegeUID` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `teammates_collegeuid_foreign` (`collegeUID`),
  CONSTRAINT `teammates_collegeuid_foreign` FOREIGN KEY (`collegeUID`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teammates`
--

/*!40000 ALTER TABLE `teammates` DISABLE KEYS */;
/*!40000 ALTER TABLE `teammates` ENABLE KEYS */;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maxCapacity` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `availedCapacity` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `eventID` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`,`eventID`),
  KEY `teams_eventid_foreign` (`eventID`),
  CONSTRAINT `teams_eventid_foreign` FOREIGN KEY (`eventID`) REFERENCES `events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
INSERT INTO `teams` (`id`, `name`, `maxCapacity`, `availedCapacity`, `eventID`, `created_at`, `updated_at`, `description`) VALUES (3,'Individual',2,0,3,'2019-06-01 22:14:27','2019-06-01 22:14:27',NULL),(11,'Individual',2,1,8,'2019-06-01 22:14:27','2019-06-01 22:14:27',NULL),(12,'July Rokks',5,1,8,'2019-06-10 20:31:43','2019-06-14 13:03:20','july rokks'),(13,'July Test Team',2,2,8,'2019-06-14 11:00:07','2019-06-14 13:03:20','july test team desc'),(14,'team1',2,0,3,NULL,NULL,NULL);
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `receiver` int(10) unsigned NOT NULL,
  `sender` int(10) unsigned NOT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wasQueued` tinyint(1) NOT NULL DEFAULT '0',
  `amount` double(16,4) NOT NULL,
  `visibility` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `initBy` int(10) unsigned NOT NULL,
  `queueID` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_sender_foreign` (`sender`),
  KEY `transactions_receiver_foreign` (`receiver`),
  KEY `transactions_initby_foreign` (`initBy`),
  CONSTRAINT `transactions_initby_foreign` FOREIGN KEY (`initBy`) REFERENCES `users` (`collegeUID`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` (`id`, `receiver`, `sender`, `description`, `wasQueued`, `amount`, `visibility`, `initBy`, `queueID`, `created_at`, `updated_at`) VALUES (45,99887766,11709456,'Transfer request scheduled for 11711106',1,500.0000,1,11711106,27,'2019-06-09 11:55:35',NULL),(46,99887766,11711106,'Money requested by11709456 via request',1,501.0000,0,11711106,28,'2019-06-09 11:55:55',NULL),(47,11711106,99887766,'Money Transferred from  using Transfer Request',1,500.0000,1,11709456,27,'2019-06-09 11:57:12',NULL),(48,11709456,99887766,'Money Transferred from 11711106 using Transfer Request',1,501.0000,1,11709456,28,'2019-06-09 11:57:49',NULL),(49,99887766,11709456,'Transfer request scheduled for 11711106',1,5000.0000,1,11711106,29,'2019-06-09 12:00:20',NULL),(50,99887766,11709456,'Transfer request scheduled for 11711106',1,5000.0000,1,11711106,30,'2019-06-09 12:00:24',NULL),(51,99887766,11709456,'Transfer request scheduled for 11711106',1,5000.0000,1,11711106,31,'2019-06-09 12:00:25',NULL),(52,99887766,11709456,'Transfer request scheduled for 11711106',1,5000.0000,1,11711106,32,'2019-06-09 12:00:25',NULL),(53,99887766,11709456,'Transfer request scheduled for 11711106',1,5000.0000,1,11711106,33,'2019-06-09 12:00:27',NULL),(54,99887766,11709456,'Transfer request scheduled for 11711106',1,5000.0000,1,11711106,34,'2019-06-09 12:00:27',NULL),(55,99887766,11709456,'Transfer request scheduled for 11711106',1,5000.0000,1,11711106,35,'2019-06-09 12:00:27',NULL),(56,11711109,11711106,'Money Transfer for enrollment in July Test Event with pending payment of ₹550',0,950.0000,1,11711106,NULL,'2019-06-10 20:35:58',NULL),(57,999801,11711109,'Enrollment successful for 11711109 by 11711106 using PartialPay',0,1500.0000,1,11711106,NULL,'2019-06-10 20:35:58',NULL),(58,11709495,11711106,'Enrollment Fees for July Test Event transferred by 11711106',0,1500.0000,1,11711106,NULL,'2019-06-12 02:20:17',NULL),(59,999801,11709495,'Enrollment successful for 11709495 by 11711106',0,1500.0000,1,11711106,NULL,'2019-06-12 02:20:17',NULL),(60,11711789,11711106,'Money Transfer for enrollment in July Test Event with pending payment of ₹600',0,900.0000,1,11711106,NULL,'2019-06-12 02:29:40',NULL),(61,999801,11711789,'Enrollment successful for 11711789 by 11711106 using PartialPay',0,1500.0000,1,11711106,NULL,'2019-06-12 02:29:40',NULL),(62,11711789,11711106,'Direct Cash Deposit/Transfer by 11711106',0,600.0000,1,11711106,NULL,'2019-06-12 07:25:30',NULL),(63,11701000,11709456,'Enrollment Fees for July Test Event transferred by 11709456',0,1500.0000,1,11709456,NULL,'2019-06-14 09:37:45',NULL),(64,999801,11701000,'Enrollment successful for 11701000 by 11709456',0,1500.0000,1,11709456,NULL,'2019-06-14 09:37:45',NULL),(65,11711756,11709456,'Money Transfer for enrollment in July Test Event with pending payment of ₹1000',0,500.0000,1,11709456,NULL,'2019-06-14 11:01:36',NULL),(66,999801,11711756,'Enrollment successful for 11711756 by 11709456 using PartialPay',0,1500.0000,1,11709456,NULL,'2019-06-14 11:01:36',NULL);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;

--
-- Table structure for table `user_navigation`
--

DROP TABLE IF EXISTS `user_navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_navigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `menu_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) unsigned NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(10) unsigned NOT NULL,
  `jump_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_navigation`
--

/*!40000 ALTER TABLE `user_navigation` DISABLE KEYS */;
INSERT INTO `user_navigation` (`id`, `menu_id`, `menu_name`, `icon`, `parent_id`, `link`, `status`, `title`, `level`, `jump_id`, `created_at`, `updated_at`) VALUES (1,10000,'Home','home',0,'#',1,'1',0,0,NULL,NULL),(2,10001,'Dashboard','',10000,'/home',1,'-1',0,0,NULL,NULL),(3,14000,'Enrollments','account-plus',0,'#',1,'2',0,0,NULL,NULL),(4,14001,'Add Student','',14000,'/serve/forms/enrollment/new',1,'-1',10,0,NULL,NULL),(5,16000,'Finances','cash-multiple',0,'#',1,'2',0,0,NULL,NULL),(6,16001,'Collect Cash','',16000,'/serve/forms/enrollment/collectCash',1,'-1',10,0,NULL,NULL),(7,16500,'Gift Certificates','gift',0,'#',1,'2',1000,0,NULL,NULL),(8,16501,'Allot Gift Certificates','',16500,'/home#/serve/offers/grant/giftCard',1,'-1',1000,0,NULL,NULL),(9,16502,'Cancel Gift Certificates','',16500,'../serve/CancelGiftCertificates',1,'-1',1000,0,NULL,NULL),(10,17000,'Online Payments','square-inc-cash',0,'#',1,'2',1000,0,NULL,NULL),(11,17001,'Manage Payment Gateway','',17000,'404',1,'-1',1000,0,NULL,NULL),(12,17002,'Manage Payment Gateway','',17000,'404',1,'-1',1000,0,NULL,NULL),(13,17003,'Test Payment Gateway','',17000,'404',1,'-1',1000,0,NULL,NULL),(14,17004,'List Transactions','',17000,'404',1,'-1',0,0,NULL,NULL),(15,17005,'Prepare Reports','',17000,'404',1,'-1',0,0,NULL,NULL),(16,18000,'Requests','elevator',0,'#',1,'2',0,0,NULL,NULL),(17,18001,'Refund Request','',18000,'../request/StudentRefundRequest',1,'-1',100,0,NULL,NULL),(18,18002,'Send Invitation','',18000,'../request/SendInvitationToStudent',1,'-1',10,0,NULL,NULL),(19,20000,'Cash Handling','currency-inr',0,'#',1,'3',0,0,NULL,NULL),(20,20100,'Balance Transfer',' ',20000,'#',1,'-1',10,0,NULL,NULL),(21,20110,'To Coordinator','',20100,'/serve/forms/money/transferBalance/interMember',1,'-1',10,0,NULL,NULL),(22,20120,'To Board','',20100,'../serve/SendCashToAdministartors',1,'-1',10,0,NULL,NULL),(23,20200,'Transfer Money','bank',0,'#',1,'3',0,0,NULL,NULL),(24,20230,'To Organization','',20200,'#',1,'-1',10,0,NULL,NULL),(25,20231,'BHIM','',20230,'../serve/SendCashToOrganizationUsingBhim',1,'-1',0,0,NULL,NULL),(26,20232,'Google Pay(Tez)','',20230,'404',1,'-1',0,0,NULL,NULL),(27,20233,'PayTM','',20230,'404',1,'-1',0,0,NULL,NULL),(28,20234,'Debit/Credit Card','',20230,'404',1,'-1',0,0,NULL,NULL),(29,22000,'Transactions','transcribe',0,'#',1,'3',0,0,NULL,NULL),(30,22001,'My Transactions','',22000,'/MyAccount/FinancialTransactions',1,'-1',10,0,NULL,NULL),(31,24000,'Events','flag-checkered',0,'#',1,'7',0,0,NULL,NULL),(32,24001,'List Events','',24000,'../reports/events',1,'-1',0,0,NULL,NULL),(33,24002,'Add Event','',24000,'/serve/forms/event/new',1,'-1',1000,0,NULL,NULL),(34,24003,'Modify Event','',24000,'/home#/serve/alterEvent',1,'-1',1000,0,NULL,NULL),(35,24010,'Event Pages','internet-explorer',0,'#',1,'-1',1000,0,NULL,NULL),(36,24011,'Add Event Page','',24010,'../serve/AddEventPage',1,'-1',1000,0,NULL,NULL),(37,24012,'Modify Event Page','',24010,'../serve/ModifyEventPage',1,'-1',1000,0,NULL,NULL),(38,24013,'Suggest Event','',24000,'404',1,'-1',0,0,NULL,NULL),(39,24014,'My Suggestions','',24013,'404',1,'-1',0,0,NULL,NULL),(40,24015,'Review Suggestions','',24013,'404',1,'-1',0,0,NULL,NULL),(41,24020,'Budgets','scale',0,'#',1,'-1',0,0,NULL,NULL),(42,24021,'Display','',24020,'../reports/eventBudget',1,'-1',1000,0,NULL,NULL),(43,24022,'Modify','',24020,'../serve/modifyEventBudget',1,'-1',1000,0,NULL,NULL),(44,24023,'Add','',24020,'../serve/addEventBudget',1,'-1',1000,0,NULL,NULL),(45,24030,'Participants','',24000,'404',1,'-1',0,0,NULL,NULL),(46,24050,'Practice Event','package-variant',0,'#',1,'7',1000,0,NULL,NULL),(47,24051,'Reports','',24000,'#',1,'-1',0,0,NULL,NULL),(48,24100,'Prepare Dummy Event','',24050,'../action/AddDummyEvent',1,'-1',1000,0,NULL,NULL),(49,24200,'Honors & Awards','trophy',0,'#',1,'-1',100,0,NULL,NULL),(50,24201,'Award a Title','',24200,'404',1,'-1',100,0,NULL,NULL),(51,24300,'Groups','account-multiple',0,'#',1,'-1',10,0,NULL,NULL),(52,24301,'Prepare Groups','',24300,'/home#/serve/event/prepare/groups',1,'-1',1000,0,NULL,NULL),(53,24302,'Assign Students','',24300,'404',1,'-1',1000,0,NULL,NULL),(54,24500,'Venues','store',0,'#',1,'7',100,0,NULL,NULL),(55,24501,'Add Venue','',24500,'/serve/forms/venues/new',1,'-1',1000,0,NULL,NULL),(56,24502,'Allot Venue','',24500,'404',1,'-1',1000,0,NULL,NULL),(57,24503,'Venue Request','',24500,'404',1,'-1',1000,0,NULL,NULL),(58,24504,'Generate Alert','',24500,'404',1,'-1',100,0,NULL,NULL),(59,25000,'Event Reports','book-open-page-variant',0,'#',1,'3',1000,0,NULL,NULL),(60,26000,'Event Expenses','currency-inr',0,'#',1,'6',0,0,NULL,NULL),(61,26001,'Add Event Expense','',26000,'../request/AddEventExpense',1,'-1',100,0,NULL,NULL),(62,26002,'Approve Event Expense','',26000,'../actions/ApproveEventExpense',1,'-1',1000,0,NULL,NULL),(63,28000,'Club Expenses','currency-inr',0,'#',1,'-1',0,0,NULL,NULL),(64,28001,'Add Club Expense','',28000,'../serve/AddClubExpense',1,'-1',1000,0,NULL,NULL),(65,28002,'Approve Club Expense','',28000,'../actions/ApproveClubExpense',1,'-1',1000,0,NULL,NULL),(66,32000,'User Management','account-circle',0,'#',1,'8',0,0,NULL,NULL),(67,34000,'Student Attendance','qrcode-scan',0,'#',1,'13',0,0,NULL,NULL),(68,34003,'Mark Student Attendence','',34000,'/serve/action/events/MarkStudentAttendance',1,'-1',10,0,NULL,NULL),(69,34004,'Verify Attendence','',34000,'/serve/action/events/VerifyStudentAttendance',1,'-1',0,0,NULL,NULL),(70,34050,'Staff Attendance','loupe',0,'#',1,'-1',0,0,NULL,NULL),(71,34051,'Mark Attendance','',34050,'404',1,'-1',100,0,NULL,NULL),(72,34052,'Approve Attendance','',34050,'404',1,'-1',0,0,NULL,NULL),(73,34053,'Non Group Verification','',34000,'404',1,'-1',0,0,NULL,NULL),(74,35000,'Stock Management','truck',0,'#',1,'16',0,0,NULL,NULL),(75,35100,'Update Stock','',35000,'#',1,'-1',0,0,NULL,NULL),(76,35101,'Add Quantity','',35100,'404',1,'-1',100,0,NULL,NULL),(77,35102,'Add Consuption','',35100,'404',1,'-1',100,0,NULL,NULL),(78,35200,'Stock Report','',35000,'404',1,'-1',1000,0,NULL,NULL),(79,35300,'Stock Items','',35000,'#',1,'-1',1000,0,NULL,NULL),(80,35301,'Add Stock Item','',35300,'404',1,'-1',1000,0,NULL,NULL),(81,35302,'Remove Stock Item','',35300,'404',1,'-1',1000,0,NULL,NULL),(82,35303,'Modify Stock Item','',35300,'404',1,'-1',1000,0,NULL,NULL),(83,36000,'Meetings','account-switch',0,'#',1,'9',10,0,NULL,NULL),(84,36001,'Call Meeting','',36000,'../action/callmeeting',1,'-1',100,0,NULL,NULL),(85,36002,'Request Meeting','',36000,'../request/meeting',1,'-1',10,0,NULL,NULL),(86,36003,'Meeting Details','',36000,'404',1,'-1',10,0,NULL,NULL),(87,36004,'Online Meeting','',36000,'404',1,'-1',10,0,NULL,NULL),(88,37000,'Offline Registrations','keyboard-off',0,'#',1,'15',10,0,NULL,NULL),(89,37001,'Upload Payment Data','',37000,'404',1,'-1',10,0,NULL,NULL),(90,37002,'Upload Student Data','',37000,'404',1,'-1',10,0,NULL,NULL),(91,37050,'Offline Passes','clipboard-text',0,'#',1,'15',10,0,NULL,NULL),(92,37051,'Generate Offline Passes','',37050,'../action/GeneratePasses',1,'-1',100,0,NULL,NULL),(93,37052,'Request Offline Passes','',37050,'../request/offlinePasses',1,'-1',10,0,NULL,NULL),(94,38000,'Team Feedback','thumbs-up-down',0,'#',1,'18',10,0,NULL,NULL),(95,38001,'Give FeedBack','',38000,'../feedbacks/internal',1,'-1',10,0,NULL,NULL),(96,39000,'Site FeedBack','',0,'#',1,'12',0,0,NULL,NULL),(97,39001,'Report an Error','',0,'#',1,'12',0,0,NULL,NULL),(98,39002,'Suggest Improvement','',0,'#',1,'12',0,0,NULL,NULL),(99,40000,'Recruitment','worker',0,'#',1,'11',0,0,NULL,NULL),(100,40001,'Recruit Member','',40000,'../serve/AddMember',1,'-1',10,0,NULL,NULL),(101,40002,'Recruit Vendor','',40000,'../serve/AddVendor',1,'-1',1000,0,NULL,NULL),(102,40003,'Post Recruitment Drive','',40000,'../serve/PostRecruitmentDrive',1,'-1',1000,0,NULL,NULL),(103,40005,'Dismissial','',40000,'404',1,'-1',100,0,NULL,NULL),(104,40050,'Vacancies','account-multiple-plus',0,'#',1,'-1',0,0,NULL,NULL),(105,40051,'Add Vacancies','',40050,'404',1,'-1',1000,0,NULL,NULL),(106,42000,'Designations','tag-faces',0,'#',1,'11',0,0,NULL,NULL),(107,42001,'Add Designation','',42000,'../serve/AddDesignation',1,'-1',1000,0,NULL,NULL),(108,42002,'Allot Designation','',42000,'../action/AllotDesignation',1,'-1',1000,0,NULL,NULL),(109,42003,'Modify Designation','',42000,'../serve/ModifyDesignation',1,'-1',1000,0,NULL,NULL),(110,42004,'Remove Designation','',42000,'../serve/RemoveDesignation',1,'-1',1000,0,NULL,NULL),(111,43000,'Responsibilities','account-check',0,'#',1,'-1',0,0,NULL,NULL),(112,43001,'Add Duty','',43000,'404',1,'-1',1000,0,NULL,NULL),(113,43002,'Remove Duty','',43000,'404',1,'-1',1000,0,NULL,NULL),(114,43003,'Manage Duties','',43000,'404',1,'-1',1000,0,NULL,NULL),(115,43004,'List Duties','',43000,'404',1,'-1',100,0,NULL,NULL),(116,44000,'Site Settings','verified',0,'#',1,'12',0,0,NULL,NULL),(117,44100,'Core Settings','',44000,'../site/AlterSettings',1,'-1',1000,0,NULL,NULL),(118,45000,'Access Management','lock',0,'#',1,'8',1000,0,NULL,NULL),(119,45001,'Grant Access','',45000,'404',1,'-1',1000,0,NULL,NULL),(120,45002,'Block Access','',45000,'404',1,'-1',1000,0,NULL,NULL),(121,45500,'Generate User Timeline','fingerprint',0,'../action/GenrateUserTimeline',1,'-1',1000,0,NULL,NULL),(122,46000,'Collaboration','wechat',0,'#',1,'14',0,0,NULL,NULL),(123,46001,'Messageing','',46000,'404',1,'-1',0,0,NULL,NULL),(124,46002,'Discuss an Idea','',46000,'404',1,'-1',0,0,NULL,NULL),(125,48000,'Profile','face',0,'#',1,'17',0,0,NULL,NULL),(126,48001,'Request Core Profile','',48000,'404',1,'-1',0,0,NULL,NULL),(127,48002,'Update Payment Details','',48000,'../profile/Payment',1,'-1',0,0,NULL,NULL),(128,48003,'Update Profile','',48000,'404',1,'-1',0,0,NULL,NULL),(129,48004,'Reset Password','',48000,'404',1,'-1',0,0,NULL,NULL),(130,48005,'Apply as Coordinator','',48000,'404',1,'-1',0,0,NULL,NULL),(131,48006,'Apply as Member','',48000,'404',1,'-1',0,0,NULL,NULL),(132,48007,'Join as Soft Staff','',48000,'404',1,'-1',0,0,NULL,NULL),(133,48008,'Resign Club','',48000,'404',1,'-1',0,0,NULL,NULL),(134,48050,'Jobs','briefcase',0,'#',1,'-1',0,0,NULL,NULL),(135,48051,'Campus Ambassedor','',48050,'404',1,'-1',0,0,NULL,NULL),(136,50000,'Student Requests','',0,'#',1,'4',0,0,NULL,NULL),(137,50001,'Pending Requests','',50000,'404',1,'-1',0,0,NULL,NULL),(138,50002,'Solved Requests','',50000,'404',1,'-1',0,0,NULL,NULL),(139,52000,'Internal Issues','',0,'#',1,'4',0,0,NULL,NULL),(140,52001,'Raise Issue','',52000,'404',1,'-1',0,0,NULL,NULL),(141,52002,'List Issues','',52000,'404',1,'-1',0,0,NULL,NULL),(142,85000,'DSA Reports','',0,'#',1,'5',1000,0,NULL,NULL),(143,85001,'Generate NAAC','',85000,'404',1,'-1',1000,0,NULL,NULL),(144,85002,'Genrate Member Reports','',85000,'404',1,'-1',1000,0,NULL,NULL),(145,85003,'Generate Annexure 98','',85000,'404',1,'-1',1000,0,NULL,NULL),(146,88000,'Vendor Reports','',0,'../request/vendorReport',1,'-1',1000,0,NULL,NULL),(147,88020,'SMS Gateway','',44000,'4004',1,'-1',1000,0,NULL,NULL),(148,88040,'SMTP Mailer','',44000,'4004',1,'-1',1000,0,NULL,NULL),(149,34001,'Scan SmartCard','',34000,'/serve/forms/digitalAttendance/Scanner',1,'-1',10,0,NULL,NULL),(150,100000,'Developer Console','briefcase',10000,'/test',1,'-1',1024,0,NULL,NULL),(151,14002,'Add Team',' ',14000,'/serve/forms/event/teams/new',1,'-1',10,0,NULL,NULL),(152,20050,'Request Money',' \r\n \r\n ',20000,'#',1,'-1',20,0,NULL,NULL),(153,20051,'Request Balance',' \r\n \r\n ',20050,'/serve/forms/money/requestBalance/interMember',1,'-1',20,0,NULL,NULL),(154,22002,'Search Transaction','find-replace',22000,'/serve/forms/search/transaction',1,'-1',1000,0,NULL,NULL),(155,14003,'Change Team',' ',14000,'/serve/forms/enrollments/changeTeam',1,'-1',1000,0,NULL,NULL);
/*!40000 ALTER TABLE `user_navigation` ENABLE KEYS */;

--
-- Table structure for table `user_navigation_titles`
--

DROP TABLE IF EXISTS `user_navigation_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_navigation_titles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_navigation_titles`
--

/*!40000 ALTER TABLE `user_navigation_titles` DISABLE KEYS */;
INSERT INTO `user_navigation_titles` (`id`, `title`, `created_at`, `updated_at`) VALUES (1,'Basic Navigation & Dashboard',NULL,NULL),(2,'Student Affairs',NULL,NULL),(3,'Finances',NULL,NULL),(4,'Help and Support',NULL,NULL),(5,'Reports',NULL,NULL),(6,'Expenses',NULL,NULL),(7,'Event Management',NULL,NULL),(8,'User Management',NULL,NULL),(9,'Meetings and Board',NULL,NULL),(11,'HR Department',NULL,NULL),(12,'Site and Rules',NULL,NULL),(13,'Attendance Management ',NULL,NULL),(14,'Collaboration and Team',NULL,NULL),(15,'Offline Tasks',NULL,NULL),(16,'Inventory',NULL,NULL),(17,'Account and Profile',NULL,NULL),(18,'Timeline Management',NULL,NULL);
/*!40000 ALTER TABLE `user_navigation_titles` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middleName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fathersName` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdBy` bigint(20) unsigned NOT NULL DEFAULT '0',
  `gender` smallint(5) unsigned NOT NULL DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `nationality` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IN',
  `bloodGroup` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastLogin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `incentiveRate` double(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `mobile` bigint(20) NOT NULL,
  `altMobile` bigint(20) DEFAULT NULL,
  `authorityLevel` smallint(5) unsigned NOT NULL DEFAULT '0',
  `address` text COLLATE utf8mb4_unicode_ci,
  `collegeUID` int(10) unsigned NOT NULL,
  `referenceUID` int(10) unsigned DEFAULT '0',
  `theme` smallint(5) unsigned NOT NULL DEFAULT '0',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_collegeuid_unique` (`collegeUID`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `firstName`, `middleName`, `lastName`, `fathersName`, `createdBy`, `gender`, `birthday`, `nationality`, `bloodGroup`, `lastLogin`, `incentiveRate`, `status`, `mobile`, `altMobile`, `authorityLevel`, `address`, `collegeUID`, `referenceUID`, `theme`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `school`, `branch`) VALUES (1,'Administrator',NULL,NULL,NULL,0,0,NULL,'IN',NULL,'2019-02-16 21:47:18',0.00,1,7007694145,NULL,1024,NULL,11711106,0,7,'ems.admin@nukrip.com',NULL,'$2y$10$j/pRApueuX44YRyWQKWQPOY3/KlWd4AlA/cWBeADpcl2TNWozc88K','4i3NlZVlsgg9qTClEQVCgkuXKqp7OYEDjbpmTeIoRAcXKO8rYa00Rq2Rkf1H',NULL,'2019-06-17 09:39:33',NULL,NULL),(2,'System','Queue','Account','System',1,0,NULL,'IN',NULL,'2019-02-20 19:45:36',0.00,0,1,0,0,'',99887766,11711106,0,'system@sasSystem',NULL,'46',NULL,NULL,NULL,NULL,NULL),(4,'Anukriti Gupta',NULL,NULL,NULL,0,0,NULL,'IN',NULL,'2019-02-16 21:47:18',0.00,1,7007694145,NULL,1024,NULL,11709456,0,8,'anukritigupta@nukrip.com',NULL,'$2y$10$j/pRApueuX44YRyWQKWQPOY3/KlWd4AlA/cWBeADpcl2TNWozc88K','dAz7H4IvoAi2lXHmk2yYE79aOxqE9JWnl7o6xZR5ScLN1TGrHgE9TlHkBnxr',NULL,'2019-06-07 13:06:54',NULL,NULL),(31,'test6hm','g','dfgv','ijhj yugu jhoij',11711106,1,NULL,'IN',NULL,'2019-06-02 11:17:51',0.00,1,8080808070,NULL,0,NULL,11171115,11711106,0,'fg@fg.gh',NULL,'$2y$10$adCnkL1SBSnA2nyxvrLQMuNSvZSsWTkJBRc0N9oDyzrZd4OTZgNDu',NULL,'2019-06-02 00:17:51','2019-06-02 00:17:51',NULL,NULL),(32,'test6sshm','gss','dfgv','ijhj yugu jhoij',11711106,1,NULL,'IN',NULL,'2019-06-02 11:35:49',0.00,1,8080808770,NULL,0,NULL,11171129,11711106,0,'fgxx@fg.gh',NULL,'$2y$10$4fujOi/zo7dxVVld2YErrekWUVk1SyRXqDKIZWA74c0j4zoPVJN/q',NULL,'2019-06-02 00:35:49','2019-06-02 00:35:49',NULL,NULL),(33,'TestStudent','Two',NULL,NULL,11711106,1,NULL,'IN',NULL,'2019-06-03 19:15:51',0.00,1,7080908070,NULL,0,NULL,11711129,11711106,0,'teststu@lpu.in',NULL,'$2y$10$KSXHbIysSEeVJxrKyH8YgOvCMYJq75vIRpaUiEyjYt3S/T7gpWLRu',NULL,'2019-06-03 08:15:51','2019-06-03 08:15:51',NULL,NULL),(34,'Siddharth',NULL,'Verma','Niranjan Verma',11711106,1,NULL,'IN',NULL,'2019-06-11 07:35:54',0.00,1,9988774466,NULL,0,NULL,11711109,11711106,0,'siddharthcverma@gmail.com',NULL,'$2y$10$y0j0ylgMjOjLBrsSJRZseOnCBmzPbel55O4jIYtbt9hK1ihwk.NG2',NULL,'2019-06-10 20:35:57','2019-06-10 20:35:57','K','Bachelor of Technology - Computer Science and Engineering'),(35,'Neel',NULL,'Gupta',NULL,11711106,1,NULL,'IN',NULL,'2019-06-12 13:20:15',0.00,1,7080208070,NULL,0,NULL,11709495,11711106,0,'neelgupta2@gmail.com',NULL,'$2y$10$Gks3ZXIk1yLXcmwYiuinseCAZo5Zt9itZ.1x/lqgEfCgZq/1RQq6O',NULL,'2019-06-12 02:20:16','2019-06-12 02:20:16','D','BCA'),(36,'Neelam',NULL,NULL,NULL,11711106,2,NULL,'IN',NULL,'2019-06-12 13:29:40',0.00,1,7080708070,NULL,0,NULL,11711789,11711106,0,'neelam@gmail.com',NULL,'$2y$10$XrZuFI.NKLmHuu2ZzwNNQeMXud5xpUA3WutAuB40E9zfzYOHPpj.a',NULL,'2019-06-12 02:29:40','2019-06-12 02:29:40','D','BCA'),(37,'radha',NULL,'kumari','rajan kumar',11709456,2,'2021-12-31','IN','o+','2019-06-14 20:37:45',0.00,1,9898986565,NULL,0,'dhwjkdgwjkhdgbwkjdh',11701000,11709456,0,'radhakumari@gmail.com',NULL,'$2y$10$y.yGBEjInAYMpTpB1p50Vek85Fet3sLp9Jvd3bCwvYHIc6z8Km8tC',NULL,'2019-06-14 09:37:45','2019-06-14 09:37:45','C','civil engg'),(38,'Rohit',NULL,'Gupta','Rahul Gupta',11709456,1,NULL,'IN',NULL,'2019-06-14 22:01:36',0.00,1,7080808075,NULL,0,NULL,11711756,11709456,0,'rohitgupta2@gmail.com',NULL,'$2y$10$CVVPr/qnGc2yEYAbprrjw.MLqIob5fNHRIy7dVZsq1tx4JXmn1.0O',NULL,'2019-06-14 11:01:36','2019-06-14 11:01:36','K','Btech');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

--
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registeredBy` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL DEFAULT '1',
  `primaryAddressLine` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secondaryAddressLine` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tertiaryAddressLine` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortAddress` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coordinatorsRequired` int(10) unsigned NOT NULL DEFAULT '1',
  `capacity` int(10) unsigned NOT NULL,
  `price` double(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venues`
--

/*!40000 ALTER TABLE `venues` DISABLE KEYS */;
/*!40000 ALTER TABLE `venues` ENABLE KEYS */;

--
-- Table structure for table `venuetypes`
--

DROP TABLE IF EXISTS `venuetypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venuetypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venuetypes`
--

/*!40000 ALTER TABLE `venuetypes` DISABLE KEYS */;
/*!40000 ALTER TABLE `venuetypes` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-18  1:03:47
