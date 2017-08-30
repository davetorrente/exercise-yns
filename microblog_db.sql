-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2017 at 07:49 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `microblog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `follow_id` int(11) NOT NULL,
  `isFollow` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `retweets`
--

CREATE TABLE `retweets` (
  `id` int(11) UNSIGNED NOT NULL,
  `tweet` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `retweets`
--

INSERT INTO `retweets` (`id`, `tweet`, `user_id`, `tweet_id`, `created`, `modified`) VALUES
(2, '12', 22, 53, '2017-08-30 15:11:21', '2017-08-30 15:11:21'),
(3, 'Tweet from sample user', 22, 61, '2017-08-30 15:38:56', '2017-08-30 15:38:56');

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) UNSIGNED NOT NULL,
  `tweet` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `isRetweet` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`id`, `tweet`, `user_id`, `isRetweet`, `created`, `modified`) VALUES
(73, 'hahaha', 22, 0, '2017-08-30 15:47:46', '2017-08-30 15:47:46'),
(72, 'ez', 22, 0, '2017-08-30 15:47:24', '2017-08-30 15:47:24'),
(71, '11', 22, 0, '2017-08-30 15:41:32', '2017-08-30 15:41:32'),
(70, '10', 22, 0, '2017-08-30 15:39:13', '2017-08-30 15:39:13'),
(69, '9', 22, 0, '2017-08-30 15:39:11', '2017-08-30 15:39:11'),
(68, '8', 22, 0, '2017-08-30 15:39:10', '2017-08-30 15:39:10'),
(67, '7', 22, 0, '2017-08-30 15:39:09', '2017-08-30 15:39:09'),
(66, '6', 22, 0, '2017-08-30 15:39:08', '2017-08-30 15:39:08'),
(65, '5', 22, 0, '2017-08-30 15:39:08', '2017-08-30 15:39:08'),
(64, '4', 22, 0, '2017-08-30 15:39:07', '2017-08-30 15:39:07'),
(63, '3', 22, 0, '2017-08-30 15:39:05', '2017-08-30 15:39:05'),
(62, 'Tweet from sample 2', 22, 0, '2017-08-30 15:38:44', '2017-08-30 15:38:44'),
(61, 'Tweet from sample user', 21, 1, '2017-08-30 15:38:21', '2017-08-30 15:38:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `upload` text CHARACTER SET utf8mb4,
  `description` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `email`, `gender`, `upload`, `description`, `created`) VALUES
(21, 'Dave', 'Torrente', 'sampleuser', 'deeaf1ea645af982da32ed77fe32a192', 'dave.torrente@gmail.com', 'male', './profile-img/default-user.png', NULL, '2017-08-30 14:20:34'),
(22, 'Dave', 'Torrente', 'sample2', 'deeaf1ea645af982da32ed77fe32a192', 'dave.torrente55@gmail.com', 'male', './profile-img/default-user.png', NULL, '2017-08-30 15:07:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retweets`
--
ALTER TABLE `retweets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
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
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `retweets`
--
ALTER TABLE `retweets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
