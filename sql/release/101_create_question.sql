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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_deleted` int(4) DEFAULT '0',
  PRIMARY KEY (`q_id`),
  KEY `category_index` (`q_category`),
  KEY `level_index` (`q_level`),
  KEY `type_index` (`q_type`)
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
