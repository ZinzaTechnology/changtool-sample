-- MySQL dump 10.14  Distrib 5.5.47-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: chang_dev
-- ------------------------------------------------------
-- Server version	5.5.47-MariaDB

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
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `qa_id` int(11) NOT NULL AUTO_INCREMENT,
  `q_id` int(11) NOT NULL,
  `qa_content` text COLLATE utf8_unicode_ci NOT NULL,
<<<<<<< HEAD
  `qa_status` int(4) NOT NULL,
  `is_deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`qa_id`),
  KEY `answer` (`q_id`),
  CONSTRAINT `answer` FOREIGN KEY (`q_id`) REFERENCES `question` (`q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
=======
  `qa_status` bit(1) NOT NULL,
  PRIMARY KEY (`qa_id`,`q_id`),
  KEY `answer` (`q_id`),
  CONSTRAINT `answer` FOREIGN KEY (`q_id`) REFERENCES `question` (`q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>>>>>>> dev/anhlt/frontend
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `answer` VALUES (1,1,'answer 1',0,0),(2,1,'answer 2',1,0),(3,1,'answer 3',0,0),(4,1,'answer 4',0,0),(5,2,'answer 1',1,1),(6,2,'answer 2',1,1),(7,2,'answer 3',0,1);
=======
INSERT INTO `answer` VALUES (16,1,'Q1-A1',''),(17,1,'Q1-A2',''),(18,1,'Q1-A3',''),(19,1,'Q1-A1F','\0'),(20,1,'Q1-A2F','\0'),(21,1,'Q1-A3F','\0'),(22,1,'Q1-A4F','\0'),(23,2,'Q2-A1',''),(24,2,'Q2-A2',''),(25,2,'Q2-A3',''),(26,2,'Q2-A1F','\0'),(27,2,'Q2-A2F','\0'),(28,2,'Q2-A3F','\0');
>>>>>>> dev/anhlt/frontend
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answer_clone`
--

DROP TABLE IF EXISTS `answer_clone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer_clone` (
  `ac_id` int(11) NOT NULL AUTO_INCREMENT,
  `qc_id` int(11) NOT NULL,
  `ac_content` text COLLATE utf8_unicode_ci NOT NULL,
  `ac_status` bit(1) NOT NULL,
  PRIMARY KEY (`ac_id`,`qc_id`),
  KEY `answer_clone` (`qc_id`),
  CONSTRAINT `answer_clone` FOREIGN KEY (`qc_id`) REFERENCES `question_clone` (`qc_id`)
<<<<<<< HEAD
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
=======
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>>>>>>> dev/anhlt/frontend
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer_clone`
--

LOCK TABLES `answer_clone` WRITE;
/*!40000 ALTER TABLE `answer_clone` DISABLE KEYS */;
<<<<<<< HEAD
=======
INSERT INTO `answer_clone` VALUES (1,1,'Q1-A1',''),(2,1,'Q1-A2F','\0'),(3,1,'Q1-A1F','\0'),(4,1,'Q1-A4F','\0'),(5,2,'Q2-A2',''),(6,2,'Q2-A3',''),(7,2,'Q2-A1F','\0'),(8,2,'Q2-A2F','\0'),(9,3,'Q1-A2',''),(10,3,'Q1-A2F','\0'),(11,3,'Q1-A4F','\0'),(12,3,'Q1-A3F','\0'),(13,4,'Q2-A3',''),(14,4,'Q2-A2',''),(15,4,'Q2-A2F','\0'),(16,4,'Q2-A1F','\0');
>>>>>>> dev/anhlt/frontend
/*!40000 ALTER TABLE `answer_clone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `q_id` int(11) NOT NULL AUTO_INCREMENT,
  `q_category` int(11) NOT NULL,
  `q_level` int(11) NOT NULL,
  `q_type` int(11) NOT NULL,
  `q_content` text COLLATE utf8_unicode_ci NOT NULL,
<<<<<<< HEAD
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` int(4) DEFAULT NULL,
  PRIMARY KEY (`q_id`),
  KEY `category_index` (`q_category`),
  KEY `level_index` (`q_level`),
  KEY `type_index` (`q_type`)
=======
  `q_created_date` datetime NOT NULL,
  `q_updated_date` datetime DEFAULT NULL,
  `q_is_deleted` int(4) DEFAULT '0',
  PRIMARY KEY (`q_id`)
>>>>>>> dev/anhlt/frontend
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `question` VALUES (1,1001,1,1,'this is first php question','0000-00-00 00:00:00','2016-08-05 14:03:43',0),(2,1001,2,1,'this is second php question','0000-00-00 00:00:00','2016-08-04 21:57:21',0),(3,1001,2,2,'this is third php question','0000-00-00 00:00:00','2016-08-05 14:43:00',1);
=======
INSERT INTO `question` VALUES (1,1,2,1,'Question 1: What is your name?','2016-07-26 00:00:00','2016-07-26 00:00:00',0),(2,2,1,2,'Question 2: How old are you?\r\n$referenceTable = array();\r\n$referenceTable[\'val1\'] = array(1, 2);\r\n$referenceTable[\'val2\'] = 3;\r\n$referenceTable[\'val3\'] = array(4, 5);\r\n\r\n$testArray = array();\r\n\r\n$testArray = array_merge($testArray, $referenceTable[\'val1\']);\r\nvar_dump($testArray);\r\n$testArray = array_merge($testArray, $referenceTable[\'val2\']);\r\nvar_dump($testArray);\r\n$testArray = array_merge($testArray, $referenceTable[\'val3\']);\r\nvar_dump($testArray);','2016-07-19 00:00:00','2016-07-19 00:00:00',0),(3,1,2,2,'$x = 5;\r\necho $x;\r\necho \"<br />\";\r\necho $x+++$x++;\r\necho \"<br />\";\r\necho $x;\r\necho \"<br />\";\r\necho $x---$x--;\r\necho \"<br />\";\r\necho $x;','2016-07-04 00:00:00','2016-07-13 00:00:00',0);
>>>>>>> dev/anhlt/frontend
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_clone`
--

DROP TABLE IF EXISTS `question_clone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_clone` (
  `qc_id` int(11) NOT NULL AUTO_INCREMENT,
  `qc_content` text COLLATE utf8_unicode_ci NOT NULL,
  `ut_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`qc_id`)
<<<<<<< HEAD
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
=======
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>>>>>>> dev/anhlt/frontend
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_clone`
--

LOCK TABLES `question_clone` WRITE;
/*!40000 ALTER TABLE `question_clone` DISABLE KEYS */;
<<<<<<< HEAD
=======
INSERT INTO `question_clone` VALUES (1,'Question 1: What is your name?',3),(2,'Question 2: How old are you?\r\n$referenceTable = array();\r\n$referenceTable[\'val1\'] = array(1, 2);\r\n$referenceTable[\'val2\'] = 3;\r\n$referenceTable[\'val3\'] = array(4, 5);\r\n\r\n$testArray = array();\r\n\r\n$testArray = array_merge($testArray, $referenceTable[\'val1\']);\r\nvar_dump($testArray);\r\n$testArray = array_merge($testArray, $referenceTable[\'val2\']);\r\nvar_dump($testArray);\r\n$testArray = array_merge($testArray, $referenceTable[\'val3\']);\r\nvar_dump($testArray);',3),(3,'Question 1: What is your name?',4),(4,'Question 2: How old are you?\r\n$referenceTable = array();\r\n$referenceTable[\'val1\'] = array(1, 2);\r\n$referenceTable[\'val2\'] = 3;\r\n$referenceTable[\'val3\'] = array(4, 5);\r\n\r\n$testArray = array();\r\n\r\n$testArray = array_merge($testArray, $referenceTable[\'val1\']);\r\nvar_dump($testArray);\r\n$testArray = array_merge($testArray, $referenceTable[\'val2\']);\r\nvar_dump($testArray);\r\n$testArray = array_merge($testArray, $referenceTable[\'val3\']);\r\nvar_dump($testArray);',4);
>>>>>>> dev/anhlt/frontend
/*!40000 ALTER TABLE `question_clone` ENABLE KEYS */;
UNLOCK TABLES;

--
<<<<<<< HEAD
-- Table structure for table `question_tag`
--

DROP TABLE IF EXISTS `question_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_tag` (
  `qt_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  PRIMARY KEY (`qt_id`),
  KEY `tag_index` (`tag_id`),
  KEY `question_index` (`q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_tag`
--

LOCK TABLES `question_tag` WRITE;
/*!40000 ALTER TABLE `question_tag` DISABLE KEYS */;
INSERT INTO `question_tag` VALUES (1,1101,1),(2,1101,2),(3,1102,1);
/*!40000 ALTER TABLE `question_tag` ENABLE KEYS */;
=======
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `qt_id` int(11) NOT NULL AUTO_INCREMENT,
  `q_id` int(11) NOT NULL,
  `qt_content` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`qt_id`,`q_id`),
  KEY `tag` (`q_id`),
  CONSTRAINT `tag` FOREIGN KEY (`q_id`) REFERENCES `question` (`q_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
>>>>>>> dev/anhlt/frontend
UNLOCK TABLES;

--
-- Table structure for table `test_exam`
--

DROP TABLE IF EXISTS `test_exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_exam` (
  `te_id` int(11) NOT NULL AUTO_INCREMENT,
  `te_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `te_category` int(4) NOT NULL,
  `te_level` int(4) NOT NULL,
  `te_title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `te_time` int(11) NOT NULL,
  `te_num_of_questions` int(11) NOT NULL,
<<<<<<< HEAD
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`te_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
=======
  `te_created_at` datetime DEFAULT NULL,
  `te_last_updated_at` datetime DEFAULT NULL,
  `te_is_deleted` int(4) DEFAULT '0',
  PRIMARY KEY (`te_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>>>>>>> dev/anhlt/frontend
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_exam`
--

LOCK TABLES `test_exam` WRITE;
/*!40000 ALTER TABLE `test_exam` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `test_exam` VALUES (1,'PH01',1001,1,'PHP basic',30,30,NULL,'2016-08-05 15:00:48',0),(2,'PH02',1001,2,'PHP advance',30,30,NULL,'2016-08-05 14:07:17',0),(3,'C001',1002,1,'C basic',50,50,'2016-08-05 20:25:45','2016-08-05 20:25:45',0);
=======
INSERT INTO `test_exam` VALUES (1,'php1',1,2,'inKi test',60,60,'2016-07-22 00:00:00',NULL,0),(2,'php2',1,1,'inKi test2',60,60,'2016-07-22 00:00:00',NULL,0),(3,'PHP1',1,1,'Ha inKi test',60,60,'2016-07-28 09:00:00','2016-07-28 09:06:00',0),(5,'Php_Yii',2,1,'Php Basic',3600,50,NULL,'2016-07-26 04:07:57',0),(6,'Php_Yii',3,1,'Php Basic 1',60,50,NULL,NULL,0),(7,'C#_Yii',2,2,'C# Basic',50,50,'2016-07-26 04:07:52','2016-07-26 04:07:50',0),(8,'Yii ...',2,1,'Php Advance',200,50,NULL,NULL,0);
>>>>>>> dev/anhlt/frontend
/*!40000 ALTER TABLE `test_exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_exam_questions`
--

DROP TABLE IF EXISTS `test_exam_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_exam_questions` (
  `te_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `not_use` bit(1) DEFAULT NULL,
  PRIMARY KEY (`te_id`,`q_id`),
  KEY `test_exam_questions` (`q_id`),
  CONSTRAINT `test_exam_questions` FOREIGN KEY (`q_id`) REFERENCES `question` (`q_id`),
  CONSTRAINT `test_exam_questions_ibfk_1` FOREIGN KEY (`te_id`) REFERENCES `test_exam` (`te_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_exam_questions`
--

LOCK TABLES `test_exam_questions` WRITE;
/*!40000 ALTER TABLE `test_exam_questions` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `test_exam_questions` VALUES (1,1,NULL),(1,2,NULL),(2,1,NULL),(2,2,NULL),(2,3,NULL);
=======
INSERT INTO `test_exam_questions` VALUES (1,3,NULL),(2,1,NULL),(2,2,NULL);
>>>>>>> dev/anhlt/frontend
/*!40000 ALTER TABLE `test_exam_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `u_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `u_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `u_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `u_password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_role` enum('ADMIN','USER') COLLATE utf8_unicode_ci DEFAULT 'USER',
  `u_created_at` datetime DEFAULT NULL,
  `u_updated_at` datetime DEFAULT NULL,
  `u_is_deleted` int(4) DEFAULT '0',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin@zinza.com.vn','0123456789','$2y$13$oRIJni/4Sa2d6wdrmxUAf.AgqD5qQ4Cldq5MVREvHKblINF4ztDna',NULL,NULL,'ADMIN',NULL,NULL,0),(2,'guest','guest@zinza.com.vn','9876543210','$2y$13$y7RwNl27htSDzgTmDqNDnOLnZ2dPUkgFmBgpBbajVqIMsMe8XWZsi',NULL,NULL,'USER',NULL,NULL,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_test`
--

DROP TABLE IF EXISTS `user_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_test` (
  `ut_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `te_id` int(11) NOT NULL,
  `ut_status` enum('ASSIGNED','DOING','DONE') COLLATE utf8_unicode_ci DEFAULT 'ASSIGNED',
  `ut_mark` int(11) DEFAULT NULL,
  `ut_start_at` datetime DEFAULT NULL,
  `ut_finished_at` datetime DEFAULT NULL,
<<<<<<< HEAD
  `ut_question_clone_ids` text COLLATE utf8_unicode_ci NOT NULL,
=======
  `ut_question_clone_ids` text COLLATE utf8_unicode_ci,
>>>>>>> dev/anhlt/frontend
  `ut_user_answer_ids` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ut_id`),
  KEY `user_test_ibfk_1` (`te_id`),
  KEY `user_test` (`u_id`),
  CONSTRAINT `user_test` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`),
  CONSTRAINT `user_test_ibfk_1` FOREIGN KEY (`te_id`) REFERENCES `test_exam` (`te_id`)
<<<<<<< HEAD
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
=======
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>>>>>>> dev/anhlt/frontend
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_test`
--

LOCK TABLES `user_test` WRITE;
/*!40000 ALTER TABLE `user_test` DISABLE KEYS */;
<<<<<<< HEAD
=======
INSERT INTO `user_test` VALUES (1,1,3,'ASSIGNED',NULL,NULL,NULL,NULL,NULL),(2,2,3,'ASSIGNED',NULL,NULL,NULL,NULL,NULL),(3,1,2,'ASSIGNED',NULL,NULL,NULL,NULL,NULL),(4,2,2,'ASSIGNED',NULL,NULL,NULL,NULL,NULL);
>>>>>>> dev/anhlt/frontend
/*!40000 ALTER TABLE `user_test` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

<<<<<<< HEAD
-- Dump completed on 2016-08-06 15:29:27
=======
-- Dump completed on 2016-08-04 15:58:24
>>>>>>> dev/anhlt/frontend
