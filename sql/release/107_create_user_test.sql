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
  `ut_user_answer_ids` text COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ut_id`),
  KEY `user_test_ibfk_1` (`te_id`),
  KEY `user_test` (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;