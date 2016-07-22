use chang_dev;

CREATE TABLE IF NOT EXISTS `Tag` (
    `qt_id` int(11) NOT NULL AUTO_INCREMENT,
    `q_id` int(11) NOT NULL,
    `qt_content` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`qt_id`, `q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `Tag`
  ADD CONSTRAINT `Tag` FOREIGN KEY (`q_id`) REFERENCES `Question` (`q_id`);