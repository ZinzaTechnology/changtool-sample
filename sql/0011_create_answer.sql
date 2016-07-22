use chang_dev;

CREATE TABLE IF NOT EXISTS `Answer` (
    `qa_id` int(11) NOT NULL AUTO_INCREMENT,
    `q_id` int(11) NOT NULL,
    `qa_content` text(250) COLLATE utf8_unicode_ci NOT NULL,
    `qa_status` bit(1) NOT NULL,
    PRIMARY KEY (`qa_id`, `q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `Answer`
  ADD CONSTRAINT `Answer` FOREIGN KEY (`q_id`) REFERENCES `Question` (`q_id`);