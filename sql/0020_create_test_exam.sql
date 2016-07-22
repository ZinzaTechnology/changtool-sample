use chang_dev;

CREATE TABLE IF NOT EXISTS `TestExam` (
    `te_id` int(11) NOT NULL AUTO_INCREMENT,
    `te_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
    `te_category` int(4) NOT NULL,
    `te_level` int(4) NOT NULL,
    `te_title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
    `te_time` int(11) NOT NULL,
    `te_num_of_questions` int(11) NOT NULL,
    `te_created_at` datetime DEFAULT NULL,
    `te_last_updated_at` datetime DEFAULT NULL,
    `te_is_deleted` int(4) DEFAULT '0',
    PRIMARY KEY (`te_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

