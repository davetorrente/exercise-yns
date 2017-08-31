-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2017 at 03:09 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) UNSIGNED NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  `answer3` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer1`, `answer2`, `answer3`, `answer`, `question_id`, `created`) VALUES
(1, 'nameClass', 'stdClass', ' newClass', 'stdClass', 1, '2017-08-29 18:28:54'),
(2, 'sort()', 'rsort()', ' asort()', 'rsort()', 2, '2017-08-29 18:28:54'),
(3, '$2name', '$Name', '$_name', '$2name', 3, '2017-08-29 18:28:54'),
(4, '$POST', '$GET', '$_REQUEST', '$_REQUEST', 4, '2017-08-29 18:28:54'),
(5, 'CREATE TABLE table_name (column_name column_type);', 'CREATE table_name (column_name column_type);', 'CREATE table_name (column_type column_name);', 'CREATE TABLE table_name (column_name column_type);', 5, '2017-08-29 18:28:54'),
(6, 'SELECT WHERE Col1, Col2 FROM;	', 'SELECT Col1, Col2 FROM WHERE;', 'SELECT Col1 + Col2 FROM WHERE;', 'SELECT Col1, Col2 FROM WHERE;', 6, '2017-08-29 18:28:54'),
(7, 'bind_param()', 'bound_param()', 'bind_result()', 'bind_param()', 7, '2017-08-29 18:28:54'),
(8, 'Extends', 'Inherits', 'implements', 'Extends', 8, '2017-08-29 18:28:54'),
(9, 'static class', 'Interface', 'Object', 'Interface', 9, '2017-08-29 18:28:54'),
(10, 'query()', 'send_query()', 'query_send()', 'query()', 10, '2017-08-29 18:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `user_id`, `score`, `created`, `modified`) VALUES
(1, 2, 5, '2017-08-30 02:11:24', '2017-08-30 10:11:24');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `created`) VALUES
(1, 'Which class name is generic empty reserved in PHP?', '2017-08-29 18:28:54'),
(2, 'Which of the functions is used to sort an array in descending order?', '2017-08-29 18:28:54'),
(3, 'Which is invalid variable?', '2017-08-29 18:28:54'),
(4, 'Which is a global array in php', '2017-08-29 18:28:54'),
(5, 'Which one of the following statements is used to create a table?', '2017-08-29 18:28:54'),
(6, 'Which one is correct syntax for Where clause in SQL server?', '2017-08-29 18:28:54'),
(7, 'Which of the following methods is used to execute the statement after the parameters have been bound?', '2017-08-29 18:28:54'),
(8, 'Which one of the following keyword is used to inherit our subclass into a superclass?', '2017-08-29 18:28:54'),
(9, 'If your object must inherit behavior from a number of sources you must use a/an', '2017-08-29 18:28:54'),
(10, 'Which one of the following methods is responsible for sending the query to the database?', '2017-08-29 18:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `gender`) VALUES
(2, 'dddddd', 'deeaf1ea645af982da32ed77fe32a192', 'dave.torrente@gmail.com', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
