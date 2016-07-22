-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 22, 2016 at 08:49 AM
-- Server version: 5.5.47-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chang_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `Answer`
--

CREATE TABLE IF NOT EXISTS `Answer` (
  `qa_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `qa_content` text COLLATE utf8_unicode_ci NOT NULL,
  `qa_status` bit(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `AnswerClone`
--

CREATE TABLE IF NOT EXISTS `AnswerClone` (
  `ac_id` int(11) NOT NULL,
  `qc_id` int(11) NOT NULL,
  `ac_content` text COLLATE utf8_unicode_ci NOT NULL,
  `ac_status` bit(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Question`
--

CREATE TABLE IF NOT EXISTS `Question` (
  `q_id` int(11) NOT NULL,
  `q_category` int(11) NOT NULL,
  `q_level` int(11) NOT NULL,
  `q_type` int(11) NOT NULL,
  `q_content` text COLLATE utf8_unicode_ci NOT NULL,
  `q_created_date` datetime NOT NULL,
  `q_updated_date` datetime DEFAULT NULL,
  `q_is_deleted` int(4) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `QuestionClone`
--

CREATE TABLE IF NOT EXISTS `QuestionClone` (
  `qc_id` int(11) NOT NULL,
  `qc_content` text COLLATE utf8_unicode_ci NOT NULL,
  `ut_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tag`
--

CREATE TABLE IF NOT EXISTS `Tag` (
  `qt_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `qt_content` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TestExam`
--

CREATE TABLE IF NOT EXISTS `TestExam` (
  `te_id` int(11) NOT NULL,
  `te_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `te_category` int(4) NOT NULL,
  `te_level` int(4) NOT NULL,
  `te_title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `te_time` int(11) NOT NULL,
  `te_num_of_questions` int(11) NOT NULL,
  `te_created_at` datetime DEFAULT NULL,
  `te_last_updated_at` datetime DEFAULT NULL,
  `te_is_deleted` int(4) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TestExamQuestions`
--

CREATE TABLE IF NOT EXISTS `TestExamQuestions` (
  `te_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `not_use` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `u_mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `u_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `u_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `u_password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_role` enum('ADMIN','USER') COLLATE utf8_unicode_ci DEFAULT 'USER',
  `u_created_at` datetime DEFAULT NULL,
  `u_updated_at` datetime DEFAULT NULL,
  `u_is_deleted` int(4) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`u_id`, `u_name`, `u_mail`, `u_phone`, `u_password_hash`, `u_password_reset_token`, `u_auth_key`, `u_role`, `u_created_at`, `u_updated_at`, `u_is_deleted`) VALUES
(1, 'admin', 'admin@zinza.com.vn', '0123456789', '$2y$13$oRIJni/4Sa2d6wdrmxUAf.AgqD5qQ4Cldq5MVREvHKblINF4ztDna', NULL, NULL, 'ADMIN', NULL, NULL, 0),
(2, 'guest', 'guest@zinza.com.vn', '9876543210', '$2y$13$y7RwNl27htSDzgTmDqNDnOLnZ2dPUkgFmBgpBbajVqIMsMe8XWZsi', NULL, NULL, 'USER', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `UserTest`
--

CREATE TABLE IF NOT EXISTS `UserTest` (
  `ut_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `te_id` int(11) NOT NULL,
  `ut_status` enum('ASSIGNED','DOING','DONE') COLLATE utf8_unicode_ci DEFAULT 'ASSIGNED',
  `ut_mark` int(11) DEFAULT NULL,
  `ut_start_at` datetime DEFAULT NULL,
  `ut_finished_at` datetime DEFAULT NULL,
  `ut_question_clone_ids` text COLLATE utf8_unicode_ci NOT NULL,
  `ut_user_answer_ids` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Answer`
--
ALTER TABLE `Answer`
  ADD PRIMARY KEY (`qa_id`,`q_id`),
  ADD KEY `Answer` (`q_id`);

--
-- Indexes for table `AnswerClone`
--
ALTER TABLE `AnswerClone`
  ADD PRIMARY KEY (`ac_id`,`qc_id`),
  ADD KEY `AnswerClone` (`qc_id`);

--
-- Indexes for table `Question`
--
ALTER TABLE `Question`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `QuestionClone`
--
ALTER TABLE `QuestionClone`
  ADD PRIMARY KEY (`qc_id`);

--
-- Indexes for table `Tag`
--
ALTER TABLE `Tag`
  ADD PRIMARY KEY (`qt_id`,`q_id`),
  ADD KEY `Tag` (`q_id`);

--
-- Indexes for table `TestExam`
--
ALTER TABLE `TestExam`
  ADD PRIMARY KEY (`te_id`);

--
-- Indexes for table `TestExamQuestions`
--
ALTER TABLE `TestExamQuestions`
  ADD PRIMARY KEY (`te_id`,`q_id`),
  ADD KEY `TestExamQuestions` (`q_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `UserTest`
--
ALTER TABLE `UserTest`
  ADD PRIMARY KEY (`ut_id`),
  ADD KEY `UserTest_ibfk_1` (`te_id`),
  ADD KEY `UserTest` (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Answer`
--
ALTER TABLE `Answer`
  MODIFY `qa_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `AnswerClone`
--
ALTER TABLE `AnswerClone`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Question`
--
ALTER TABLE `Question`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `QuestionClone`
--
ALTER TABLE `QuestionClone`
  MODIFY `qc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Tag`
--
ALTER TABLE `Tag`
  MODIFY `qt_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `TestExam`
--
ALTER TABLE `TestExam`
  MODIFY `te_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `UserTest`
--
ALTER TABLE `UserTest`
  MODIFY `ut_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Answer`
--
ALTER TABLE `Answer`
  ADD CONSTRAINT `Answer` FOREIGN KEY (`q_id`) REFERENCES `Question` (`q_id`);

--
-- Constraints for table `AnswerClone`
--
ALTER TABLE `AnswerClone`
  ADD CONSTRAINT `AnswerClone` FOREIGN KEY (`qc_id`) REFERENCES `QuestionClone` (`qc_id`);

--
-- Constraints for table `Tag`
--
ALTER TABLE `Tag`
  ADD CONSTRAINT `Tag` FOREIGN KEY (`q_id`) REFERENCES `Question` (`q_id`);

--
-- Constraints for table `TestExamQuestions`
--
ALTER TABLE `TestExamQuestions`
  ADD CONSTRAINT `TestExamQuestions_ibfk_1` FOREIGN KEY (`te_id`) REFERENCES `TestExam` (`te_id`),
  ADD CONSTRAINT `TestExamQuestions` FOREIGN KEY (`q_id`) REFERENCES `Question` (`q_id`);

--
-- Constraints for table `UserTest`
--
ALTER TABLE `UserTest`
  ADD CONSTRAINT `UserTest_ibfk_1` FOREIGN KEY (`te_id`) REFERENCES `TestExam` (`te_id`),
  ADD CONSTRAINT `UserTest` FOREIGN KEY (`u_id`) REFERENCES `User` (`u_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
