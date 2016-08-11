use chang_dev;
DROP TABLE IF EXISTS test_exam;
CREATE TABLE IF NOT EXISTS `test_exam` (
  `te_id` int(11) NOT NULL,
  `te_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `te_category` int(4) NOT NULL,
  `te_level` int(4) NOT NULL,
  `te_title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `te_time` int(11) NOT NULL,
  `te_num_of_questions` int(11) NOT NULL,
  `te_created_at` datetime DEFAULT NULL,
  `te_last_updated_at` datetime DEFAULT NULL,
  `te_is_deleted` int(4) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `test_exam`
  ADD PRIMARY KEY (`te_id`);

  ALTER TABLE `test_exam`
  MODIFY `te_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;