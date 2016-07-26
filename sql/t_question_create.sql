use chang_dev;
DROP TABLE IF EXISTS question;
CREATE TABLE IF NOT EXISTS `question` (
  `q_id` int(11) NOT NULL,
  `q_category` int(11) NOT NULL,
  `q_level` int(11) NOT NULL,
  `q_type` int(11) NOT NULL,
  `q_content` text COLLATE utf8_unicode_ci NOT NULL,
  `q_created_date` datetime NOT NULL,
  `q_updated_date` datetime DEFAULT NULL,
  `q_is_deleted` int(4) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `question`
  ADD PRIMARY KEY (`q_id`);

  ALTER TABLE `question`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;