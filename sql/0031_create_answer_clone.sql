use chang_dev;

CREATE TABLE IF NOT EXISTS `AnswerClone` (
    `ac_id` int(11) NOT NULL AUTO_INCREMENT,
    `qc_id` int(11) NOT NULL,
    `ac_content` text(250) COLLATE utf8_unicode_ci NOT NULL,
    `ac_status` bit(1) NOT NULL,
    PRIMARY KEY (`ac_id`, `qc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `AnswerClone`
  ADD CONSTRAINT `AnswerClone` FOREIGN KEY (`qc_id`) REFERENCES `QuestionClone` (`qc_id`);