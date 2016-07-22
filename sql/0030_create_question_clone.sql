use chang_dev;

CREATE TABLE IF NOT EXISTS `QuestionClone` (
    `qc_id` int(11) NOT NULL AUTO_INCREMENT,
    `qc_content` text(500) COLLATE utf8_unicode_ci NOT NULL,
   	`ut_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`qc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
