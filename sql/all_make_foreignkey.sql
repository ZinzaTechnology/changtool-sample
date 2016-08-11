use chang_dev;

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer` FOREIGN KEY (`q_id`) REFERENCES `question` (`q_id`);

--
-- Constraints for table `answer_clone`
--
ALTER TABLE `answer_clone`
  ADD CONSTRAINT `answer_clone` FOREIGN KEY (`qc_id`) REFERENCES `question_clone` (`qc_id`);

--
-- Constraints for table `questions_tags`
--
ALTER TABLE `questions_tags`
  ADD CONSTRAINT `questions_tags_ibfk_2` FOREIGN KEY (`qt_id`) REFERENCES `tag` (`qt_id`),
  ADD CONSTRAINT `questions_tags_ibfk_1` FOREIGN KEY (`q_id`) REFERENCES `question` (`q_id`);

--
-- Constraints for table `test_exam_questions`
--
ALTER TABLE `test_exam_questions`
  ADD CONSTRAINT `test_exam_questions` FOREIGN KEY (`q_id`) REFERENCES `question` (`q_id`),
  ADD CONSTRAINT `test_exam_questions_ibfk_1` FOREIGN KEY (`te_id`) REFERENCES `test_exam` (`te_id`);

--
-- Constraints for table `user_test`
--
ALTER TABLE `user_test`
  ADD CONSTRAINT `user_test` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `user_test_ibfk_1` FOREIGN KEY (`te_id`) REFERENCES `test_exam` (`te_id`);
