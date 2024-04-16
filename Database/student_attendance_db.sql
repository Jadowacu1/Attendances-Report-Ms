-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 12:47 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_attendance_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

CREATE TABLE `attendence` (
  `attend_Id` int(11) NOT NULL,
  `reg_Number` varchar(10) NOT NULL,
  `Names` varchar(255) NOT NULL,
  `module_name` varchar(30) NOT NULL,
  `total_hours` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `trainerNumber` varchar(13) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendence`
--

INSERT INTO `attendence` (`attend_Id`, `reg_Number`, `Names`, `module_name`, `total_hours`, `marks`, `trainerNumber`, `status`) VALUES
(19, '22RP0003', 'Munyehirwe Allan', 'Java', 12, 90, '+250728880727', 'waiting'),
(20, '22RP0004', 'Niyonshuti Jean', 'Java', 12, 100, '+250728880727', 'waiting'),
(21, '22RP0005', 'Mukunzi Yanick', 'Java', 12, 87, '+250728880727', 'waiting'),
(22, '22RP0006', 'Rukundo Aisha', 'Java', 12, 59, '+250728880727', 'waiting'),
(23, '22RP0007', 'Mutoni Jannette', 'Java', 12, 67, '+250728880727', 'waiting'),
(24, '22RP0008', 'Shema Patrick', 'Java', 12, 78, '+250728880727', 'waiting'),
(25, '22RP0009', 'Nitanga Jean Claude', 'Java', 12, 95, '+250728880727', 'waiting');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_Id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `reg_Number` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_Id`, `email`, `phone`, `reg_Number`, `password`, `type`) VALUES
(1, 'student@gmail.com', '', '22RP0003', '$2y$10$kDbVAZJq5.siKjRvogTiX.KtskV1QNc7iAl3E.3fhj3M5C0dpZK5O', 'student'),
(2, 'trainer@gmail.com', '+250728880727', '', '$2y$10$cxhfNS8CjeZhyspSLZFB0OxJ2r7.zi8OPQ0kj3rbF9JnJC9pD42hi', 'trainer'),
(3, 'director@gmail.com', '', '', '$2y$10$PuC2UlQNCtWIryERAnkPQe.bSk.NxPDP2n6noSBlAIcxWQNvLrPIO', 'director');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendence`
--
ALTER TABLE `attendence`
  ADD PRIMARY KEY (`attend_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendence`
--
ALTER TABLE `attendence`
  MODIFY `attend_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
