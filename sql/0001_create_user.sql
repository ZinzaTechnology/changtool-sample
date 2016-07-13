CREATE TABLE `User` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
    `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `role` enum('ADMIN','USER') COLLATE utf8_unicode_ci DEFAULT 'USER',
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `is_deleted` int(4) DEFAULT '0',
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
