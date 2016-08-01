use chang_dev;
DROP TABLE IF EXISTS questions_tags;

CREATE TABLE IF NOT EXISTS `questions_tags` (
  `q_id` int(11) NOT NULL,
  `qt_id` int(11) NOT NULL,
  `qt_is_deleted` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `questions_tags`
  ADD PRIMARY KEY (`q_id`,`qt_id`),
  ADD KEY `qt_id` (`qt_id`);
