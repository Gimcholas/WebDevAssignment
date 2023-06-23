-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 04:02 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL,
  `course_section_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `upload_date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `course_section_id`, `username`, `title`, `content`, `upload_date_time`) VALUES
(1, 7, 'Tan', 'Test Title', 'Test Content 1\r\nTest content 2\r\nTest Content 3', '2023-06-20 20:44:12'),
(2, 7, 'Tan', 'Test Title 2', 'Test Content 1\r\nTest content 2\r\nTest Content 3', '2023-06-20 20:44:12'),
(120, 8, 'Tan', 'sdsd', 'sssss', '2023-06-22 11:22:33'),
(121, 7, 'Tan', 'bla', 'blablabla', '2023-06-22 11:43:53'),
(122, 7, 'Tan', 'ddd', 'dddddddddd', '2023-06-22 11:43:57');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `provider_username` varchar(20) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `course_description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `course_image_path` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `provider_username`, `course_title`, `course_description`, `start_date`, `end_date`, `course_image_path`) VALUES
(7, 'Huawei', 'Intro to cybers', 'Intro to cyber', '2023-06-18', '2023-07-02', '../files/paris.jpg'),
(8, 'Huawei', 'Test ended Course', 'Intro', '2023-05-28', '2023-06-04', '../files/MMU_Logo.png'),
(9, 'Huawei', 'Algorithm and Stuffs', 'Do you know algorithm? No you dont', '2023-06-04', '2023-07-02', '../files/MMU_Logo.png'),
(10, 'Huawei', 'Software Design', 'Software Design patterns will be taught', '2023-05-01', '2023-06-04', '../files/MMU_Logo.png'),
(11, 'Huawei', 'Software Requirements', 'SRS Development', '2023-06-18', '2023-08-27', '../files/MMU_Logo.png'),
(12, 'Huawei', 'A very long name for a course directed to test this shyt out', 'Testing some stuffs', '2023-01-10', '2023-05-01', '../files/MMU_Logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `course_feedback`
--

CREATE TABLE `course_feedback` (
  `course_feedback_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `feedback` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_section`
--

CREATE TABLE `course_section` (
  `course_section_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `course_section_name` varchar(10) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day` varchar(10) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `max_student_num` int(11) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_section`
--

INSERT INTO `course_section` (`course_section_id`, `course_id`, `username`, `course_section_name`, `start_time`, `end_time`, `day`, `status`, `max_student_num`, `description`) VALUES
(7, 7, 'Tan', 'TC1L', '00:00:00', '00:00:00', '', 'Open', 80, NULL),
(8, 8, 'Tan', 'TC1L', '00:00:00', '00:00:00', '', 'Open', 12, NULL),
(9, 9, 'Tan', 'TC1L', '00:00:00', '00:00:00', '', 'Open', 200, NULL),
(10, 10, 'Tan', 'TC1L', NULL, NULL, NULL, 'Open', 100, NULL),
(11, 10, 'Tan', 'TC2L', NULL, NULL, NULL, 'Open', 80, NULL),
(12, 11, 'Tan', 'TC1L', NULL, NULL, NULL, 'Open', 100, NULL),
(13, 12, 'Tan', 'TC1L', NULL, NULL, NULL, 'Open', 20, NULL),
(14, 7, 'Tan', 'TC2L', '00:00:00', '00:00:00', '', 'Open', 80, NULL),
(15, 7, 'Tan', 'TC3L', '00:00:00', '00:00:00', '', 'Close', 80, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE `course_student` (
  `course_student_id` int(11) NOT NULL,
  `course_section_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `course_completed` tinyint(1) DEFAULT 0,
  `course_completed_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_student`
--

INSERT INTO `course_student` (`course_student_id`, `course_section_id`, `username`, `course_completed`, `course_completed_date`) VALUES
(2, 7, 'Student1', 0, NULL),
(3, 7, 'Student1', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `username` varchar(20) NOT NULL,
  `provider_username` varchar(20) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`username`, `provider_username`, `first_name`, `last_name`, `contact_number`, `email`) VALUES
('Tan', 'Huawei', 'Instructor', 'Tan', '011-12345678', '1201101723@student.mmu.edu.my'),
('Test', 'Huawei', 'Test', '123', '011-123415894', 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_feedback`
--

CREATE TABLE `instructor_feedback` (
  `instructor_feedback` int(11) NOT NULL,
  `course_section_id` int(11) NOT NULL,
  `instructor_username` varchar(20) NOT NULL,
  `student_username` varchar(20) NOT NULL,
  `feedback` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `username` varchar(20) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `date_of_birth` date NOT NULL,
  `academic_program` varchar(100) NOT NULL,
  `provider_username` varchar(20) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`username`, `first_name`, `last_name`, `date_of_birth`, `academic_program`, `provider_username`, `contact_number`, `email`) VALUES
('Student1', 'JJ', 'T', '2002-01-01', 'CS', 'Huawei', '01234567890', 'TJJ@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `training_provider`
--

CREATE TABLE `training_provider` (
  `username` varchar(20) NOT NULL,
  `provider_name` varchar(50) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_provider`
--

INSERT INTO `training_provider` (`username`, `provider_name`, `contact_number`, `email`) VALUES
('Huawei', 'Huawei Malaysia', '', ''),
('Xiaomi', 'Xiaomi Talent', '03-8061234555', 'xiaomi@xiaomi.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `joined_date` date NOT NULL DEFAULT current_timestamp(),
  `profile_image_path` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password_hash`, `usertype`, `joined_date`, `profile_image_path`) VALUES
('Admin1', '$2y$10$QM2mAwxkhOX4gUqKmtykI.QtsqIm.rycGVHMozCSeTMp72hZMUn9i', 'Admin', '2023-06-15', '../files/defaultProfileImage.jpg'),
('Huawei', '$2y$10$owGhWijpI8.bXKUdTR72ge2alNH0dq3hF.TBQmDl57hfzLZB8cQmm', 'Provider', '2023-06-14', '../files/defaultProfileImage.jpg'),
('Student1', '$2y$10$7S/foCUCm064uMuZ.8s.YOBRB0mh8qFqOzTc7PaCLxttSQodqPlMq', 'Student', '2023-06-17', '../files/defaultProfileImage.jpg'),
('Tan', '$2y$10$ZPG5ISJ9SyXvqEOoRstsiursTDPmwvY9/Hh4Ttt8WJbgebwf5RFya', 'Instructor', '2023-06-16', '../files/defaultProfileImage.jpg'),
('Test', '$2y$10$ZgWFh0YRPryznKAHAUY/1.TQ1lwKcwIfO2vixw/pYOvPFj/u40JFW', 'Instructor', '2023-06-17', '../files/defaultProfileImage.jpg'),
('test5', '$2y$10$l50yCDfjT9O.yqj2U.Gh5.U/j.mlBPlukAv0cYpCn3Eg20jkLfbr6', 'Admin', '2023-06-17', '../files/defaultProfileImage.jpg'),
('tests', '$2y$10$B9gu8fQTiFIl4Nb.HcWSUu6rWGRzijJFDFkI4CXXT.6UlAZLBeDui', 'Admin', '2023-06-17', '../files/defaultProfileImage.jpg'),
('Xiaomi', '$2y$10$UZdivLyOGEc83PwqZOBvJ.TWTD87rOWqAFAp8rOBdAbFWeNnXu4GW', 'Provider', '2023-06-17', '../files/defaultProfileImage.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `course_section_id` (`course_section_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `provider_username` (`provider_username`);

--
-- Indexes for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD PRIMARY KEY (`course_feedback_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `course_section`
--
ALTER TABLE `course_section`
  ADD PRIMARY KEY (`course_section_id`,`course_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `course_student`
--
ALTER TABLE `course_student`
  ADD PRIMARY KEY (`course_student_id`),
  ADD KEY `course_section_id` (`course_section_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`username`),
  ADD KEY `provider_username` (`provider_username`);

--
-- Indexes for table `instructor_feedback`
--
ALTER TABLE `instructor_feedback`
  ADD PRIMARY KEY (`instructor_feedback`),
  ADD KEY `course_section_id` (`course_section_id`),
  ADD KEY `instructor_username` (`instructor_username`),
  ADD KEY `student_username` (`student_username`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`username`),
  ADD KEY `provider_username` (`provider_username`);

--
-- Indexes for table `training_provider`
--
ALTER TABLE `training_provider`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `course_feedback`
--
ALTER TABLE `course_feedback`
  MODIFY `course_feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_section`
--
ALTER TABLE `course_section`
  MODIFY `course_section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `course_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `instructor_feedback`
--
ALTER TABLE `instructor_feedback`
  MODIFY `instructor_feedback` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`course_section_id`) REFERENCES `course_section` (`course_section_id`),
  ADD CONSTRAINT `announcement_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`provider_username`) REFERENCES `user` (`username`);

--
-- Constraints for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD CONSTRAINT `course_feedback_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `course_feedback_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `course_section`
--
ALTER TABLE `course_section`
  ADD CONSTRAINT `course_section_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `course_section_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Constraints for table `course_student`
--
ALTER TABLE `course_student`
  ADD CONSTRAINT `course_student_ibfk_1` FOREIGN KEY (`course_section_id`) REFERENCES `course_section` (`course_section_id`),
  ADD CONSTRAINT `course_student_ibfk_2` FOREIGN KEY (`username`) REFERENCES `student` (`username`);

--
-- Constraints for table `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `instructor_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `instructor_ibfk_2` FOREIGN KEY (`provider_username`) REFERENCES `training_provider` (`username`);

--
-- Constraints for table `instructor_feedback`
--
ALTER TABLE `instructor_feedback`
  ADD CONSTRAINT `instructor_feedback_ibfk_1` FOREIGN KEY (`course_section_id`) REFERENCES `course_section` (`course_section_id`),
  ADD CONSTRAINT `instructor_feedback_ibfk_2` FOREIGN KEY (`instructor_username`) REFERENCES `instructor` (`username`),
  ADD CONSTRAINT `instructor_feedback_ibfk_3` FOREIGN KEY (`student_username`) REFERENCES `student` (`username`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`provider_username`) REFERENCES `training_provider` (`username`);

--
-- Constraints for table `training_provider`
--
ALTER TABLE `training_provider`
  ADD CONSTRAINT `training_provider_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
