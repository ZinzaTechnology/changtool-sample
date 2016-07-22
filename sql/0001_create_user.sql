use chang_dev;

CREATE TABLE `User` (
    `u_id` int(11) NOT NULL AUTO_INCREMENT,
    `u_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
    `u_mail` varchar(255)COLLATE utf8_unicode_ci NOT NULL,
    `u_phone` varchar(255)COLLATE utf8_unicode_ci NOT NULL,
    `u_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `u_password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `u_auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `u_role` enum('ADMIN','USER') COLLATE utf8_unicode_ci DEFAULT 'USER',
    `u_created_at` datetime DEFAULT NULL,
    `u_updated_at` datetime DEFAULT NULL,
    `u_is_deleted` int(4) DEFAULT '0',
    PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

