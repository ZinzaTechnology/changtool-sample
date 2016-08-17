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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`te_id`),
  KEY `te_category` (`te_category`),
  KEY `te_level_index` (`te_level`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;