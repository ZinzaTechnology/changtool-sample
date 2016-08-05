use chang_dev;
DROP TABLE IF EXISTS question_clone;
CREATE TABLE IF NOT EXISTS `question_clone` (
  `qc_id` int(11) NOT NULL,
  `qc_content` text COLLATE utf8_unicode_ci NOT NULL,
  `qc_category` int(11) DEFAULT NULL,
  `qc_level` int(11) DEFAULT NULL,
  `qc_type` int(11) DEFAULT NULL,
  `qc_created_at` datetime DEFAULT NULL,
  `qc_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `question_clone`
  ADD PRIMARY KEY (`qc_id`);

  ALTER TABLE `question_clone`
  MODIFY `qc_id` int(11) NOT NULL AUTO_INCREMENT;