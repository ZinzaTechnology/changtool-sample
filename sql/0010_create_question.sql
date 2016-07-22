use chang_dev;

CREATE TABLE IF NOT EXISTS `Question` (
    `q_id` int(11) NOT NULL AUTO_INCREMENT,
    `q_category` int(11) NOT NULL,
    `q_level` int(11) NOT NULL,
    `q_type` int(11) NOT NULL,
    `q_content` text(500) COLLATE utf8_unicode_ci NOT NULL,
    `q_created_date` datetime NOT NULL,
    `q_updated_date` datetime DEFAULT NULL,
    `q_is_deleted` int(4) DEFAULT '0',
    
    PRIMARY KEY (`q_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

