use chang_dev;

CREATE TABLE IF NOT EXISTS `UserTest` (
    `ut_id` int(11) NOT NULL AUTO_INCREMENT,
    `u_id` int(11) NOT NULL,
    `te_id` int(11) NOT NULL,
    `ut_status` enum('ASSIGNED','DOING','DONE') COLLATE utf8_unicode_ci DEFAULT 'ASSIGNED',
    `ut_mark` int(11) DEFAULT NULL,
    `ut_start_at` datetime DEFAULT NULL,
    `ut_finished_at` datetime DEFAULT NULL,
    `ut_question_clone_ids` text(1000)COLLATE utf8_unicode_ci NOT NULL,
    `ut_user_answer_ids` text(2000)COLLATE utf8_unicode_ci DEFAULT NULL,
   
    PRIMARY KEY (`ut_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `UserTest`
  ADD CONSTRAINT `UserTest_ibfk_1` FOREIGN KEY (`te_id`) REFERENCES `TestExam` (`te_id`),
  ADD CONSTRAINT `UserTest` FOREIGN KEY (`u_id`) REFERENCES `User` (`u_id`);