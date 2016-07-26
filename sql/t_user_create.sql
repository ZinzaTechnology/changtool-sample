use chang_dev;
DROP TABLE IF EXISTS user;
CREATE TABLE IF NOT EXISTS `user` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `u_mail` varchar(255) COLLATE utf8_unicode_ci NULL,
  `u_phone` varchar(255) COLLATE utf8_unicode_ci NULL,
  `u_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `u_password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_role` enum('ADMIN','USER') COLLATE utf8_unicode_ci DEFAULT 'USER',
  `u_created_at` datetime DEFAULT NULL,
  `u_updated_at` datetime DEFAULT NULL,
  `u_is_deleted` int(4) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`);

  ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;