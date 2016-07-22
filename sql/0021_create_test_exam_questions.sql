use chang_dev;

CREATE TABLE IF NOT EXISTS `TestExamQuestions` (
    `te_id` int(11) NOT NULL,
    `q_id` int(11) NOT NULL,
    `not_use` bit(1) DEFAULT NULL,
    PRIMARY KEY (`te_id`, `q_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `TestExamQuestions`
  ADD CONSTRAINT `TestExamQuestions_ibfk_1` FOREIGN KEY (`te_id`) REFERENCES `TestExam` (`te_id`),
  ADD CONSTRAINT `TestExamQuestions` FOREIGN KEY (`q_id`) REFERENCES `Question` (`q_id`);