use chang_dev;
DROP TABLE IF EXISTS tag;
CREATE TABLE IF NOT EXISTS `tag` (
  `qt_id` int(11) NOT NULL,
  `qt_content` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `qt_is_deleted` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tag`
  ADD PRIMARY KEY (`qt_id`);
  
  ALTER TABLE `tag`
  MODIFY `qt_id` int(11) NOT NULL AUTO_INCREMENT;