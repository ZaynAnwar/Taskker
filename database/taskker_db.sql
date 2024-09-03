-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2024 at 07:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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

-- --------------------------------------------------------

--
-- Table structure for table `seeker`
--

CREATE TABLE `seeker` (
  `sid` int(11) NOT NULL COMMENT 'Seeker Id',
  `name` varchar(200) NOT NULL COMMENT 'Service seeker name',
  `email` varchar(50) NOT NULL COMMENT 'Seeker email',
  `password` varchar(70) NOT NULL COMMENT 'Seeker password',
  `created_at` date NOT NULL COMMENT 'Account creation date',
  `status` varchar(50) NOT NULL COMMENT 'Account status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Service Seeker ';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `seeker`
--
ALTER TABLE `seeker`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Provider ID';

--
-- AUTO_INCREMENT for table `seeker`
--
ALTER TABLE `seeker`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Seeker Id';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
