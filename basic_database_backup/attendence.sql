-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 22, 2020 at 10:08 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendence`
--

-- --------------------------------------------------------

--
-- Table structure for table `1_calender`
--

CREATE TABLE `1_calender` (
  `id` int(11) NOT NULL,
  `dates` datetime DEFAULT NULL,
  `stdClassId` int(225) NOT NULL,
  `present_std_ids` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `1_calender`
--

INSERT INTO `1_calender` (`id`, `dates`, `stdClassId`, `present_std_ids`) VALUES
(1, '2020-07-07 00:00:00', 1, '4,2,3'),
(2, '2020-07-24 00:00:00', 1, '4,2,3,8'),
(3, '2020-07-25 00:00:00', 1, '4,2,3,8'),
(4, '2020-07-11 00:00:00', 2, '5,6,13,9'),
(5, '2020-07-18 00:00:00', 2, '5,6,9');

-- --------------------------------------------------------

--
-- Table structure for table `1_students`
--

CREATE TABLE `1_students` (
  `id` int(11) NOT NULL,
  `stdName` varchar(60) NOT NULL,
  `stdRoll` varchar(100) NOT NULL,
  `present_date_ids` varchar(10000) NOT NULL,
  `stdEmail` varchar(70) NOT NULL,
  `stdClassId` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `1_students`
--

INSERT INTO `1_students` (`id`, `stdName`, `stdRoll`, `present_date_ids`, `stdEmail`, `stdClassId`) VALUES
(2, 'Black Widow', '2', ',1,2,3', 'natasha@gmail.com', 1),
(4, 'Steve Roggers', '1', ',1,2,3', 'chrisevans@gmail.com', 1),
(5, 'Steve Roggers', '1', ',4,5', 'chrisevans@gmail.com', 2),
(6, 'Black Widow', '2', ',4,5', 'natasha@gmail.com', 2),
(8, 'Spider Man', '4', ',2,3', 'peterparker@gmail.com', 1),
(9, 'Spider Man', '4', ',4,5', 'peterparker@gmail.com', 2),
(12, 'Ant Man', '3', '', 'antman@gmail.com', 1),
(13, 'Ant Man', '3', ',4', 'antman@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `1_test_individiual_qns`
--

CREATE TABLE `1_test_individiual_qns` (
  `id` int(11) NOT NULL,
  `testId` int(225) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `question` varchar(4000) DEFAULT NULL,
  `opa` varchar(2000) DEFAULT NULL,
  `opb` varchar(2000) DEFAULT NULL,
  `opc` varchar(2000) DEFAULT NULL,
  `opd` varchar(2000) DEFAULT NULL,
  `correctAnswers` varchar(20) DEFAULT NULL,
  `qnImg` varchar(1000) DEFAULT NULL,
  `opa_img` varchar(100) DEFAULT NULL,
  `opb_img` varchar(100) DEFAULT NULL,
  `opc_img` varchar(100) DEFAULT NULL,
  `opd_img` varchar(100) DEFAULT NULL,
  `qnType` int(10) DEFAULT NULL,
  `noOfcumplQn` int(10) DEFAULT NULL,
  `qnIdentityNo` int(225) NOT NULL,
  `secIdentityNo` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `1_test_individiual_qns`
--

INSERT INTO `1_test_individiual_qns` (`id`, `testId`, `unit`, `question`, `opa`, `opb`, `opc`, `opd`, `correctAnswers`, `qnImg`, `opa_img`, `opb_img`, `opc_img`, `opd_img`, `qnType`, `noOfcumplQn`, `qnIdentityNo`, `secIdentityNo`) VALUES
(1, 2, 'Sec 1', '', 'kkk', NULL, NULL, NULL, NULL, 'a4_211.png', '681679_211_0.jpg', 'cg11_211_1.png', 'a5b2_211_2.png', 'newa1_211_3.png', NULL, 2, 1, 1),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'WhatsApp Image 2020-05-14 at 6_212.10', 'xmlHttpRequest_Object_methods_212_0.png', 'laptop_212_1.jpeg', 'git4_212_2.png', 'this_grabs_212_3.png', NULL, NULL, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `allStudents`
--

CREATE TABLE `allStudents` (
  `id` bigint(225) NOT NULL,
  `stdName` varchar(80) NOT NULL,
  `classesJoined` text NOT NULL,
  `eqvIdInProfTable` text NOT NULL,
  `testTaken` text NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allStudents`
--

INSERT INTO `allStudents` (`id`, `stdName`, `classesJoined`, `eqvIdInProfTable`, `testTaken`, `email`, `username`, `password`) VALUES
(1, 'Avaneesh Yadav', '', '', '', 'avaneeshdyadav@gmail.com', 'Avi', '$2y$10$hbSADmMUKCVqyy/E6oD/QukFDtEwMfYmcAFHJTIKUovhfEGSInnP.');

-- --------------------------------------------------------

--
-- Table structure for table `allTests`
--

CREATE TABLE `allTests` (
  `id` int(225) NOT NULL,
  `profId` int(225) NOT NULL,
  `classId` int(225) NOT NULL,
  `testName` varchar(200) NOT NULL,
  `testType` varchar(70) NOT NULL,
  `status` int(20) NOT NULL,
  `startTime` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `testDate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allTests`
--

INSERT INTO `allTests` (`id`, `profId`, `classId`, `testName`, `testType`, `status`, `startTime`, `duration`, `testDate`) VALUES
(1, 1, 2, 'Unit Test 1', 'On Fixed time Fixed date', 0, '08:00 AM', '0 hr 30 min', '21 Jul 2020'),
(2, 1, 1, 'Unit Test 1', 'On Fixed time Fixed date', 0, '08:00 PM', '0 hr 30 min', '22 Jul 2020');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(200) NOT NULL,
  `profId` int(225) NOT NULL,
  `className` varchar(50) NOT NULL,
  `subj` varchar(25) NOT NULL,
  `division` varchar(10) NOT NULL,
  `creatorClassId` int(225) NOT NULL,
  `isAdmin` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `profId`, `className`, `subj`, `division`, `creatorClassId`, `isAdmin`) VALUES
(1, 1, 'Avengers', 'Avengers Assemble', 'Mark23', 1, 1),
(2, 1, 'Avengers', 'Team Spirit', 'Mark23', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invite_notification`
--

CREATE TABLE `invite_notification` (
  `id` int(225) NOT NULL,
  `sender_id` int(225) NOT NULL,
  `receiver_id` int(225) NOT NULL,
  `status` int(2) NOT NULL,
  `creator_class_id` int(225) NOT NULL,
  `reciever_subj` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invite_notification`
--

INSERT INTO `invite_notification` (`id`, `sender_id`, `receiver_id`, `status`, `creator_class_id`, `reciever_subj`) VALUES
(1, 1, 2, 0, 1, 'C++');

-- --------------------------------------------------------

--
-- Table structure for table `std_email_conf_pending`
--

CREATE TABLE `std_email_conf_pending` (
  `id` int(225) NOT NULL,
  `stdName` varchar(80) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL,
  `expiryFlag` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(200) NOT NULL,
  `firstName` varchar(15) NOT NULL,
  `lastName` varchar(15) NOT NULL,
  `profEmail` varchar(50) NOT NULL,
  `profUsername` varchar(40) NOT NULL,
  `profPassword` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `firstName`, `lastName`, `profEmail`, `profUsername`, `profPassword`) VALUES
(1, 'Tony', 'Stark', 'tonystark199724@gmail.com', 'Iron man', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `1_calender`
--
ALTER TABLE `1_calender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `1_students`
--
ALTER TABLE `1_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `1_test_individiual_qns`
--
ALTER TABLE `1_test_individiual_qns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allStudents`
--
ALTER TABLE `allStudents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allTests`
--
ALTER TABLE `allTests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invite_notification`
--
ALTER TABLE `invite_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `std_email_conf_pending`
--
ALTER TABLE `std_email_conf_pending`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profUsername` (`profUsername`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `1_calender`
--
ALTER TABLE `1_calender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `1_students`
--
ALTER TABLE `1_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `1_test_individiual_qns`
--
ALTER TABLE `1_test_individiual_qns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `allStudents`
--
ALTER TABLE `allStudents`
  MODIFY `id` bigint(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `allTests`
--
ALTER TABLE `allTests`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invite_notification`
--
ALTER TABLE `invite_notification`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `std_email_conf_pending`
--
ALTER TABLE `std_email_conf_pending`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
