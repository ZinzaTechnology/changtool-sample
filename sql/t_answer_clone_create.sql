use chang_dev;
DROP TABLE IF EXISTS answer_clone;
CREATE TABLE IF NOT EXISTS `answer_clone` (
  `ac_id` int(11) NOT NULL,
  `qc_id` int(11) NOT NULL,
  `ac_content` text COLLATE utf8_unicode_ci NOT NULL,
  `ac_status` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `answer_clone`
  ADD PRIMARY KEY (`ac_id`,`qc_id`),
  ADD KEY `answer_clone` (`qc_id`);

  ALTER TABLE `answer_clone`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT;