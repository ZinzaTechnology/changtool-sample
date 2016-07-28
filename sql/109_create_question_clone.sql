--
-- Table structure for table `question_clone`
--

DROP TABLE IF EXISTS `question_clone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_clone` (
  `qc_id` int(11) NOT NULL AUTO_INCREMENT,
  `qc_content` text COLLATE utf8_unicode_ci NOT NULL,
  `qc_type` int(11) NOT NULL,
  `ut_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`qc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

