-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2024 at 08:58 AM
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
DROP DATABASE IF EXISTS `taskker_db`;
CREATE DATABASE `taskker_db` IF NOT EXISTS
Use `taskker_db`;

-- --------------------------------------------------------

--
-- Table structure for table `applied_tasks`
--

CREATE TABLE `applied_tasks` (
  `at_id` int(11) NOT NULL COMMENT 'Applied Task ID',
  `applier_id` int(11) NOT NULL COMMENT 'Id, Who Applied?',
  `task_id` bigint(20) NOT NULL COMMENT 'Id of Task',
  `applied_on` datetime NOT NULL COMMENT 'Date & Time of Apply',
  `applied_status` varchar(50) NOT NULL COMMENT 'Satus of Application'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applied_tasks`

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL COMMENT 'unique Caht ID',
  `member_1` bigint(20) NOT NULL COMMENT 'ID of Member\r\n',
  `member_2` bigint(20) NOT NULL COMMENT 'ID of Member',
  `chat_last_message_T` datetime NOT NULL COMMENT 'Last Message TimeStamp',
  `chat_last_message_C` text NOT NULL COMMENT 'Last Message Content',
  `chat_status` varchar(50) NOT NULL COMMENT 'Chat Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--


-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` bigint(20) NOT NULL COMMENT 'Unique Id',
  `chat_id` bigint(20) NOT NULL COMMENT 'Relative Chat ID\r\n',
  `sender` bigint(20) NOT NULL COMMENT 'Message Sender',
  `receiver` bigint(20) NOT NULL COMMENT 'Message Receiver',
  `message_type` varchar(20) NOT NULL COMMENT 'Text, Audio, Video, Image?',
  `message_content` text NOT NULL COMMENT 'Message Content',
  `message_media` blob NOT NULL COMMENT 'Media File ',
  `message_timestamp` datetime NOT NULL COMMENT 'Message Date $ Time',
  `message_status` varchar(10) NOT NULL COMMENT 'Message Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

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
  `cnic` bigint(13) NOT NULL COMMENT 'CNIC - National Idntity',
  `image` blob NOT NULL COMMENT 'Provider  Profile Image',
  `gender` varchar(20) NOT NULL COMMENT 'Gender ',
  `availbality` varchar(30) NOT NULL COMMENT 'Provider Availabilty',
  `location` text NOT NULL COMMENT 'Residential Location',
  `experience` int(11) NOT NULL COMMENT 'Provider Experience',
  `skills` text NOT NULL COMMENT 'Provider skills',
  `bio` text NOT NULL COMMENT 'Provider Bio',
  `status` varchar(50) NOT NULL COMMENT 'provider status',
  `last_active` datetime DEFAULT NULL COMMENT 'Time. When provider was online',
  `m_notifications` varchar(10) NOT NULL COMMENT 'Marketing Notifications\r\n',
  `created_At` date NOT NULL COMMENT 'Account Creation date'
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
  `m_notifications` varchar(20) NOT NULL COMMENT 'Marketing Notification',
  `last_Active` datetime DEFAULT NULL COMMENT 'Time. When client was online'
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applied_tasks`
--
ALTER TABLE `applied_tasks`
  ADD PRIMARY KEY (`at_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

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
-- AUTO_INCREMENT for table `applied_tasks`
--
ALTER TABLE `applied_tasks`
  MODIFY `at_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Applied Task ID', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique Caht ID', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique Id', AUTO_INCREMENT=26;

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
