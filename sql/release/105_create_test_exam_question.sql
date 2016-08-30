--
-- Table structure for table `test_exam_questions`
--

DROP TABLE IF EXISTS `test_exam_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_exam_questions` (
  `te_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `not_use` int(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`te_id`,`q_id`),
  KEY `te_id_index` (`te_id`),
  KEY `q_id_index` (`q_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;