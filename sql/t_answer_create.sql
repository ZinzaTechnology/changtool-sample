use chang_dev;
DROP TABLE IF EXISTS answer;

CREATE TABLE IF NOT EXISTS `answer` (
  `qa_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `qa_content` text COLLATE utf8_unicode_ci NOT NULL,
  `qa_status` bit(1) NOT NULL,
  `qa_is_deleted` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `answer`
  ADD PRIMARY KEY (`qa_id`,`q_id`),
  ADD KEY `answer` (`q_id`);
  
  ALTER TABLE `answer`
  MODIFY `qa_id` int(11) NOT NULL AUTO_INCREMENT;