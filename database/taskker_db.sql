-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2024 at 05:44 AM
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
-- Database: `taskker_db`
--

CREATE DATABASE IF NOT EXISTS `taskker_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `taskker_db`;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `pid` int(11) NOT NULL COMMENT 'Provider ID',
  `name` varchar(200) NOT NULL COMMENT 'Provider name',
  `email` varchar(70) NOT NULL COMMENT 'Provider email',
  `password` varchar(50) NOT NULL COMMENT 'Provider Password',
  `phone` bigint(15) NOT NULL COMMENT 'Provider contact #',
  `image` blob NOT NULL COMMENT 'Provider  Profile Image',
  `availbality` varchar(30) NOT NULL COMMENT 'Provider Availabilty',
  `experience` int(11) NOT NULL COMMENT 'Provider Experience',
  `skills` text NOT NULL COMMENT 'Provider skills',
  `bio` text NOT NULL COMMENT 'Provider Bio',
  `status` varchar(50) NOT NULL COMMENT 'provider status',
  `created_At` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Service Provider';

--
-- Dumping data for table `provider`
--
-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` bigint(20) NOT NULL,
  `rating_giver` bigint(20) NOT NULL,
  `rating_taker` bigint(20) NOT NULL,
  `rating` int(11) NOT NULL,
  `rating_createdOn` date NOT NULL,
  `rating_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` bigint(20) NOT NULL,
  `review_giver` bigint(20) NOT NULL,
  `review_taker` bigint(20) NOT NULL,
  `review_createdOn` date NOT NULL,
  `review_status` varchar(50) NOT NULL,
  `review_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seeker`
--

CREATE TABLE `seeker` (
  `sid` int(11) NOT NULL COMMENT 'Seeker Id',
  `name` varchar(200) NOT NULL COMMENT 'Service seeker name',
  `email` varchar(50) NOT NULL COMMENT 'Seeker email',
  `password` varchar(70) NOT NULL COMMENT 'Seeker password',
  `gender` varchar(20) NOT NULL COMMENT 'Gender of user',
  `image` blob NOT NULL COMMENT 'User Profile Image',
  `created_at` date NOT NULL COMMENT 'Account creation date',
  `status` varchar(50) NOT NULL COMMENT 'Account status',
  `m_notifications` varchar(20) NOT NULL COMMENT 'Marketing Notification'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Service Seeker ';

--
-- Dumping data for table `seeker`
--



-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL COMMENT 'Unique task ID',
  `task_title` varchar(200) NOT NULL COMMENT 'Title of task',
  `task_onDate` date NOT NULL COMMENT 'On Date?',
  `task_beforeDate` date NOT NULL COMMENT 'Before Date?',
  `task_location` text DEFAULT NULL COMMENT 'Location ',
  `task_city` varchar(200) NOT NULL COMMENT 'City',
  `task_description` text NOT NULL COMMENT 'Description',
  `task_budget` bigint(20) NOT NULL COMMENT 'Budget',
  `task_status` varchar(200) NOT NULL COMMENT 'Status',
  `task_createdOn` date NOT NULL COMMENT 'Created On',
  `Creater` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--


-- Indexes for dumped tables
--

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `seeker`
--
ALTER TABLE `seeker`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Provider ID', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seeker`
--
ALTER TABLE `seeker`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Seeker Id', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique task ID', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
