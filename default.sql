-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2023 at 04:45 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `course_feedback`
--

CREATE TABLE `course_feedback` (
  `course_feedback_id` int(11) NOT NULL,
  `course_section_id` int(11) NOT NULL,
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
('Admin1', '$2y$10$AVDTzC7HNdaTKeCrwCXJB.7mmUKd.PB0cQwzcAECeP8Cb/LVSd2FW', 'Admin', '2023-06-15', '../files/defaultProfileImage.jpg');

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
  ADD KEY `course_id` (`course_section_id`),
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
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `course_feedback`
--
ALTER TABLE `course_feedback`
  MODIFY `course_feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_section`
--
ALTER TABLE `course_section`
  MODIFY `course_section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `course_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `instructor_feedback`
--
ALTER TABLE `instructor_feedback`
  MODIFY `instructor_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`course_section_id`) REFERENCES `course_section` (`course_section_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcement_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`provider_username`) REFERENCES `user` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `course_feedback`
--
ALTER TABLE `course_feedback`
  ADD CONSTRAINT `course_feedback_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_feedback_ibfk_3` FOREIGN KEY (`course_section_id`) REFERENCES `course_section` (`course_section_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_section`
--
ALTER TABLE `course_section`
  ADD CONSTRAINT `course_section_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_section_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `course_student`
--
ALTER TABLE `course_student`
  ADD CONSTRAINT `course_student_ibfk_1` FOREIGN KEY (`course_section_id`) REFERENCES `course_section` (`course_section_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_student_ibfk_2` FOREIGN KEY (`username`) REFERENCES `student` (`username`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `instructor_feedback_ibfk_1` FOREIGN KEY (`course_section_id`) REFERENCES `course_section` (`course_section_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `instructor_feedback_ibfk_2` FOREIGN KEY (`instructor_username`) REFERENCES `instructor` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `instructor_feedback_ibfk_3` FOREIGN KEY (`student_username`) REFERENCES `student` (`username`) ON DELETE CASCADE;

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
