-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2023 at 12:59 PM
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
(120, 8, 'Tan', 'sdsd', 'sssss', '2023-06-22 11:22:33');

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
(8, 'Huawei', 'Test ended Course', 'Intro', '2023-05-28', '2023-06-04', '../files/MMU_Logo.png'),
(9, 'Huawei', 'Algorithm and Stuffs', 'Do you know algorithm? No you dont', '2023-06-04', '2023-07-02', '../files/MMU_Logo.png'),
(10, 'Huawei', 'Software Design', 'Software Design patterns will be taught', '2023-05-01', '2023-06-04', '../files/MMU_Logo.png'),
(11, 'Huawei', 'Software Requirements', 'SRS Development', '2023-06-18', '2023-08-27', '../files/MMU_Logo.png'),
(12, 'Huawei', 'A very long name for a course directed to test this shyt out', 'Testing some stuffs', '2023-01-10', '2023-05-01', '../files/MMU_Logo.png'),
(13, 'Huawei', 'MPU1234 Workplace Communication', 'Introduce to you the ways to communicate in workplace', '2023-08-07', '2023-10-16', '');

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

--
-- Dumping data for table `course_feedback`
--

INSERT INTO `course_feedback` (`course_feedback_id`, `course_section_id`, `username`, `feedback`, `rating`, `date`) VALUES
(2, 8, 'Student1', 'Good course to learn stuffs', 5, '2023-06-29 09:45:30'),
(3, 9, 'Student1', 'Test bad review', 1, '2023-06-29 09:54:15');

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
(8, 8, 'Tan', 'TC1L', '00:00:00', '00:00:00', '', 'Open', 12, NULL),
(9, 9, 'Tan', 'TC1L', '00:00:00', '00:00:00', '', 'Open', 200, NULL),
(12, 11, 'Tan', 'TC1L', NULL, NULL, NULL, 'Open', 100, NULL),
(13, 12, 'Tan', 'TC1L', '10:00:00', '12:00:00', 'Monday', 'Open', 20, NULL),
(17, 13, 'Tan', 'FCI2', NULL, NULL, NULL, 'Open', 190, NULL),
(24, 10, 'new user', 'TC1L', NULL, NULL, NULL, 'Open', 100, NULL),
(25, 10, 'new user', 'TC2L', NULL, NULL, NULL, 'Open', 100, NULL);

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
(5, 13, 'Student1', 0, NULL);

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
('new user', 'Huawei', 'new ', 'name', '1234567890', 'abc@gmail.com'),
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

--
-- Dumping data for table `instructor_feedback`
--

INSERT INTO `instructor_feedback` (`instructor_feedback`, `course_section_id`, `instructor_username`, `student_username`, `feedback`, `rating`, `date`) VALUES
(3, 8, 'Tan', 'Student1', 'Good instructor', 5, '2023-06-29 10:02:37');

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
('Error', 'Error2', '1', '2023-06-15', 'CS', 'Huawei', '', ''),
('Student1', 'T', 'JJ', '2002-01-01', 'CS', 'Huawei', '01234567890', 'TJJ@gmail.com'),
('Valid', 'Valid', '1', '2023-06-08', 'CS', 'Huawei', '', '');

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
('Huawei', 'Huawei Malaysia', '011-123456789', 'Huawei@gmail.com'),
('Samsung', 'Samsung Malaysia', '011-12345678', 'samsung@samsung.com'),
('Training1', 'Training Provider 1', '011-12345678', 'test@gmail.com'),
('unifi', 'Unifi Malaysia', '', ''),
('Xiaomi', 'Xiaomi Talent US', '03-8061234555', 'xiaomi@xiaomi.com');

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
('Admin1', '$2y$10$h8EhhWn20OXGpaZ8RgSt5eyCxQ.zN04X4YoaoLVClfB/fuD1TiyHe', 'Admin', '2023-06-15', '../files/defaultProfileImage.jpg'),
('Crack', '$2y$10$peST3ULy7.DQoW0eorxn3eBFAjE4.QIgyIrH5niFLB/6FV30rhuNC', 'Admin', '2023-06-29', NULL),
('Crack2', '$2y$10$z2kUb4tKuXbzJNea.Zxk/OyeFSLn5tLXazTzkqk/M30h7NH9URQFK', 'Admin', '2023-06-29', NULL),
('Error', '$2y$10$CkjTl3Nt329EhAUGDfCUTuT8wqdcjMpdN9ruloLud3bkLzImFwW32', 'Student', '2023-06-28', NULL),
('Huawei', '$2y$10$w/720MdaulGBO.MVgznuWuSTBBq0r51x0yq3trhaI6k2ntg2UT0ki', 'Provider', '2023-06-14', '../files/defaultProfileImage.jpg'),
('new user', '$2y$10$RyFV9FAuAcgwGKaZhRUBtORR8WdhSsSYufN0amDi2Sd7bpaz8.1Du', 'Instructor', '2023-06-28', NULL),
('Samsung', '$2y$10$lftJuWejMKHxLR6rpUT9cuIAgIAR3R1xkje6yEZmyOF.pIDMKUIPW', 'Provider', '2023-06-27', NULL),
('Student1', '$2y$10$lv2iQhWpRIXCYFmyhe5Tk.qlSTUucjDuQasNtVAnptlkvthgySAxm', 'Student', '2023-06-17', '../files/profile_picture/Student1.png'),
('Tan', '$2y$10$ZPG5ISJ9SyXvqEOoRstsiursTDPmwvY9/Hh4Ttt8WJbgebwf5RFya', 'Instructor', '2023-06-16', '../files/defaultProfileImage.jpg'),
('Test', '$2y$10$g36bMxCE6foQzS/GhO0ZfOekdMAlkPTQP6rIFUmxLj2G5a0q5mo0y', 'Instructor', '2023-06-17', '../files/defaultProfileImage.jpg'),
('test5', '$2y$10$cHDi6b3/k.OYaSoUjkjdfuU5uDkwVSeGPGOO7yEAS5xX.ycOo4.iq', 'Admin', '2023-06-17', '../files/defaultProfileImage.jpg'),
('tests', '$2y$10$B9gu8fQTiFIl4Nb.HcWSUu6rWGRzijJFDFkI4CXXT.6UlAZLBeDui', 'Admin', '2023-06-17', '../files/defaultProfileImage.jpg'),
('Training1', '$2y$10$9I46LSuIVpgSTKNmn.Qf.uRQJqAG.tDCmad5/vC6ww5qNSwnTd/SC', 'Provider', '2023-06-27', NULL),
('unifi', '$2y$10$RK2wA3SB1CT.pNwVCTNapO.NzuxmPA5iEAo13uOTmUyZvnM3d6lce', 'Provider', '2023-06-27', NULL),
('Valid', '$2y$10$P2aMqigfBOOw70IqB0e6iebNX7aXIs4lXmNQYWQFE0V7mjBc/uvje', 'Student', '2023-06-28', NULL),
('Xiaomi', '$2y$10$kU8UtbtZaUfTX7o04Z4DYeVMU8u8THGyPjhQ477faszq8Y4FQNrOS', 'Provider', '2023-06-17', '../files/defaultProfileImage.jpg');

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
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `course_feedback`
--
ALTER TABLE `course_feedback`
  MODIFY `course_feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_section`
--
ALTER TABLE `course_section`
  MODIFY `course_section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `course_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
