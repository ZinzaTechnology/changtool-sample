use chang_dev;
DROP TABLE IF EXISTS test_exam_questions;
CREATE TABLE IF NOT EXISTS `test_exam_questions` (
  `te_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `teq_is_deleted` int(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `test_exam_questions`
  ADD PRIMARY KEY (`te_id`,`q_id`),
  ADD KEY `test_exam_questions` (`q_id`);
