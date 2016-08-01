use chang_dev;
DROP TABLE IF EXISTS user_test;
CREATE TABLE IF NOT EXISTS `user_test` (
  `ut_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `te_id` int(11) NOT NULL,
  `ut_status` enum('ASSIGNED','DOING','DONE') COLLATE utf8_unicode_ci DEFAULT 'ASSIGNED',
  `ut_mark` int(11) DEFAULT NULL,
  `ut_start_at` datetime DEFAULT NULL,
  `ut_finished_at` datetime DEFAULT NULL,
  `ut_question_clone_ids` text COLLATE utf8_unicode_ci NOT NULL,
  `ut_user_answer_ids` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `user_test`
  ADD PRIMARY KEY (`ut_id`),
  ADD KEY `user_test_ibfk_1` (`te_id`),
  ADD KEY `user_test` (`u_id`);

  ALTER TABLE `user_test`
  MODIFY `ut_id` int(11) NOT NULL AUTO_INCREMENT;