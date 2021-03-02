-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2021 at 09:11 AM
-- Server version: 8.0.16
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `octa`
--

-- --------------------------------------------------------

--
-- Table structure for table `asgmt_comment`
--

CREATE TABLE `asgmt_comment` (
  `asgmtcomment_id` int(11) NOT NULL,
  `asgmtcomment_msg` varchar(255) DEFAULT NULL,
  `asgmtcomment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `asgmtpost_id` varchar(20) NOT NULL,
  `assignment_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

--
-- Dumping data for table `asgmt_comment`
--

INSERT INTO `asgmt_comment` (`asgmtcomment_id`, `asgmtcomment_msg`, `asgmtcomment_date`, `user_id`, `asgmtpost_id`, `assignment_id`) VALUES
(1, 'Take note on this.', '0000-00-00 00:00:00', 200, 'A1000', 'S0001'),
(2, 'ok', '2021-01-21 16:00:00', 200, 'A1000', 'S0001'),
(6, 'ok', '2021-01-21 16:00:00', 200, 'A1001', 'S0001');

-- --------------------------------------------------------

--
-- Table structure for table `asgmt_post`
--

CREATE TABLE `asgmt_post` (
  `asgmtpost_id` varchar(20) NOT NULL,
  `asgmtpost_title` text,
  `asgmtpost_desc` text,
  `asgmtpost_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `asgmt_startdate` timestamp NULL DEFAULT NULL,
  `asgmt_enddate` timestamp NULL DEFAULT NULL,
  `asgmtfile_name` varchar(255) DEFAULT NULL,
  `asgmtfile_size` varchar(255) DEFAULT NULL,
  `asgmtfile_type` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `assignment_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

--
-- Dumping data for table `asgmt_post`
--

INSERT INTO `asgmt_post` (`asgmtpost_id`, `asgmtpost_title`, `asgmtpost_desc`, `asgmtpost_date`, `asgmt_startdate`, `asgmt_enddate`, `asgmtfile_name`, `asgmtfile_size`, `asgmtfile_type`, `user_id`, `assignment_id`) VALUES
('A1000', 'Group Assignment of Computer Programming', 'Please refer to the good assignment materials.', '2021-01-08 16:52:54', '2021-01-08 16:00:00', '2021-01-15 20:00:00', NULL, NULL, NULL, 200, 'S0001'),
('A1001', 'test', 'testing hi', '2021-01-22 07:18:57', '2021-01-21 00:00:00', '2021-01-21 02:00:00', NULL, NULL, NULL, 200, 'S0001'),
('A1002', 'test', 'file', '2021-01-22 07:48:50', '2021-01-21 00:00:00', '2021-01-21 02:00:00', 'A1002_356764_Outline.ppt', '688128', 'ppt', 200, 'S0001'),
('A2000', 'Individual Assignment for Mathematics Practices', 'Please refer to the individual assignment materials.', '2021-01-08 16:56:18', '2021-01-07 16:00:00', '2021-01-16 16:00:00', NULL, NULL, NULL, 200, 'S0002'),
('A2001', 'Project Guideline', 'Please refer to the project guidelines.', '2021-01-08 16:57:25', '2021-01-09 16:00:00', '2021-01-13 20:00:00', NULL, NULL, NULL, 201, 'S0002'),
('A3001', 'Assignment 1', 'You can download the file here.', '2021-01-17 11:45:52', '2021-01-17 11:45:52', '2021-01-17 11:45:52', 'A3001_361433_1 RE.docx', '15655', 'docx', 200, 'S0003');

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignment_id` varchar(10) NOT NULL,
  `course_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`assignment_id`, `course_id`) VALUES
('S0001', 'C0001'),
('S0002', 'C0002'),
('S0003', 'C0003'),
('S0004', 'C0004'),
('S0005', 'C0005');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_msg` varchar(255) DEFAULT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `post_id` varchar(20) NOT NULL,
  `whiteboard_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`ID`, `name`, `email`, `subject`, `message`, `user_id`) VALUES
(5, 'Jensen', 'jensen00@gmail.com', 'Student List Error', 'Cannot retrieve student list', 200);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` varchar(10) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_desc` text,
  `course_ref` text,
  `course_lo` text,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_desc`, `course_ref`, `course_lo`, `user_id`) VALUES
('C0001', 'Computer Programming', 'Information technology leads the world, and programming skills are more important that ever. The programming language used in this course is C++. ', 'Walter J. Savitch - Problem Solving with C++-Pearson Education (2018)', 'Strengthen student programming language concept', 200),
('C0002', 'Mathematical Techniques', 'The emphasis is on the use of mathematical tools and techniques. The general exposition and choice of topics appeals to a wide audience of applied practitioners. It covered topics from ordinary differential equations to more sophisticated mathematics--Fourier analysis, vector and tensor analysis, complex variables, partial differential equations, and random processes. ', 'Larry C. Andrews, Ronald L. Phillips - Mathematical Techniques for Engineers and Scientists (2003)', NULL, 201),
('C0003', 'Software Engineering', '', 'Mall B. “Fundamentals of Software Engineering Paperback”.  4th Ed. Prentice Hall India 2014', 'Describe software engineering concept throughout various stages of the development life cycle including planning, requirements gathering, designing and testing', 200),
('C0004', 'Machine Learning', '-', NULL, NULL, 201),
('C0005', 'Programming Language Concept', 'Using various languages', NULL, NULL, 200);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` varchar(20) NOT NULL,
  `post_title` text,
  `post_content` text NOT NULL,
  `post_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `whiteboard_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_content`, `post_date`, `file_name`, `file_size`, `file_type`, `user_id`, `whiteboard_id`) VALUES
('P1000', 'Postpone of Midterm Test', 'Midterm Test will be postponed until further notice. Thank you', '2021-01-09 00:52:54', NULL, NULL, NULL, 200, 'W0001'),
('P1001', 'Midterm Test Date', 'Midterm Test will be carried out on next Friday from 10am to 12pm. Please take note on this.', '2021-01-09 00:56:18', NULL, NULL, NULL, 200, 'W0001'),
('P1002', 'Teaching Plan', 'Students you can find the teaching plan for this course here, thank you', '2021-01-16 07:36:19', 'P1002_Lecture Plan (TCP1121) - Tri1910 (Student).pdf', '339298', 'pdf', 200, 'W0001'),
('P2000', 'Announcement of Course Material Reference', 'Please refer to the book material posted as your reference for study.', '2021-01-09 00:57:25', NULL, NULL, NULL, 201, 'W0002');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_phone` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ai_ci DEFAULT NULL,
  `user_level` varchar(10) NOT NULL,
  `user_website` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ai_ci DEFAULT NULL,
  `user_bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ai_ci,
  `user_country` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_phone`, `user_password`, `user_level`, `user_website`, `user_bio`, `user_country`) VALUES
(100, 'admin', 'admin@gmail.com', NULL, '1234', 'Admin', '', '', ''),
(200, 'Dr Jensen Ackles', 'jensen00@gmail.com', '1234567000', 'jensen00', 'Instructor', '', '', 'USA'),
(201, 'Ts. Khairol Ahmad', 'khairolahmad@gmail.com', '0187739840', 'khairol01', 'Instructor', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `whiteboard`
--

CREATE TABLE `whiteboard` (
  `whiteboard_id` varchar(10) NOT NULL,
  `course_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ai_ci;

--
-- Dumping data for table `whiteboard`
--

INSERT INTO `whiteboard` (`whiteboard_id`, `course_id`) VALUES
('W0001', 'C0001'),
('W0002', 'C0002'),
('W0003', 'C0003'),
('W0004', 'C0004'),
('W0005', 'C0005');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asgmt_comment`
--
ALTER TABLE `asgmt_comment`
  ADD PRIMARY KEY (`asgmtcomment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `asgmtpost_id` (`asgmtpost_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `asgmt_post`
--
ALTER TABLE `asgmt_post`
  ADD PRIMARY KEY (`asgmtpost_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `whiteboard_id` (`whiteboard_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `whiteboard_id` (`whiteboard_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `whiteboard`
--
ALTER TABLE `whiteboard`
  ADD PRIMARY KEY (`whiteboard_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asgmt_comment`
--
ALTER TABLE `asgmt_comment`
  MODIFY `asgmtcomment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asgmt_comment`
--
ALTER TABLE `asgmt_comment`
  ADD CONSTRAINT `asgmt_comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asgmt_comment_ibfk_2` FOREIGN KEY (`asgmtpost_id`) REFERENCES `asgmt_post` (`asgmtpost_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asgmt_comment_ibfk_3` FOREIGN KEY (`assignment_id`) REFERENCES `assignment` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `asgmt_post`
--
ALTER TABLE `asgmt_post`
  ADD CONSTRAINT `asgmt_post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asgmt_post_ibfk_2` FOREIGN KEY (`assignment_id`) REFERENCES `assignment` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`whiteboard_id`) REFERENCES `whiteboard` (`whiteboard_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`whiteboard_id`) REFERENCES `whiteboard` (`whiteboard_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `whiteboard`
--
ALTER TABLE `whiteboard`
  ADD CONSTRAINT `whiteboard_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
