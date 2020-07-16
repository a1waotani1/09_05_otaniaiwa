-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 16, 2020 at 03:06 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gsacf_d06_05`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers_table`
--

CREATE TABLE `followers_table` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `follower_id` int(12) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `followers_table`
--

INSERT INTO `followers_table` (`id`, `user_id`, `follower_id`, `created_at`) VALUES
(3, 1, 3, '2020-07-15 19:27:46'),
(5, 1, 2, '2020-07-15 19:48:22'),
(6, 2, 1, '2020-07-15 19:50:07'),
(7, 2, 2, '2020-07-15 20:02:28'),
(8, 2, 4, '2020-07-15 20:08:00'),
(9, 2, 3, '2020-07-15 20:10:48'),
(10, 1, 1, '2020-07-16 21:02:02'),
(11, 3, 1, '2020-07-16 21:12:59'),
(12, 3, 2, '2020-07-16 21:13:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followers_table`
--
ALTER TABLE `followers_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `followers_table`
--
ALTER TABLE `followers_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
