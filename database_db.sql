-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2017 at 03:10 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `country`) VALUES
(1, 'Dave', 'Philippines'),
(2, 'Robert', 'Brazil'),
(3, 'joe', 'France'),
(4, 'randy', 'brazil'),
(5, 'jomar', 'USA'),
(6, 'Albert', 'USA'),
(7, 'Ivy', 'Germany'),
(8, 'Sandra', 'Germany'),
(9, 'Digong', 'France'),
(10, 'Sheila', 'Brazil');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'Exective'),
(2, 'Admin'),
(3, 'Sales'),
(4, 'Development'),
(5, 'Design'),
(6, 'Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `hire_date` date DEFAULT NULL,
  `boss_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `last_name`, `middle_name`, `department_id`, `hire_date`, `boss_id`) VALUES
(1, 'Manabu', 'Yamazaki', NULL, 1, NULL, NULL),
(2, 'Tomohiko', 'Takasago', NULL, 3, '2014-04-01', 1),
(3, 'Yuta', 'Kawakami', NULL, 4, '2014-04-01', 1),
(4, 'Shogo', 'Kubota', NULL, 4, '2014-12-01', 1),
(5, 'Lorraine ', 'San Jose', 'P.', 2, '2015-03-10', 1),
(6, 'Haille', 'Dela Cruz', 'A.', 3, '2015-02-15', 2),
(7, 'Godfrey', 'Sarmenta', 'L.', 4, '2015-01-01', 1),
(8, 'Alex', 'Amistad', 'F.', 4, '2015-04-10', 1),
(9, 'Hideshi', 'Ogoshi', NULL, 5, '2015-08-06', 1),
(10, 'Kim', '', NULL, 5, '2015-08-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_positions`
--

CREATE TABLE `employee_positions` (
  `id` int(11) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_positions`
--

INSERT INTO `employee_positions` (`id`, `employee_id`, `position_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 3, 5),
(6, 4, 5),
(7, 5, 5),
(8, 6, 5),
(9, 7, 5),
(10, 8, 5),
(11, 9, 5),
(12, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `order_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_date`, `order_name`) VALUES
(1, 1, '2017-08-10 03:02:58', 'Nike'),
(2, 2, '2017-08-10 03:04:58', 'Adidas'),
(3, 1, '2017-08-10 03:01:09', 'Nike'),
(4, 8, '2017-08-10 03:01:09', 'Adidas'),
(5, 99, '2017-08-10 04:51:14', 'FILA');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `post` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post`, `created`, `modified`) VALUES
(1, 'ggg', '2017-08-30 01:19:49', '2017-08-30 09:19:49'),
(2, 'ddd', '2017-08-30 01:20:03', '2017-08-30 09:20:03'),
(3, 'g', '2017-08-30 01:20:13', '2017-08-30 09:20:13'),
(4, 'g', '2017-08-30 01:20:14', '2017-08-30 09:20:14'),
(5, 'g', '2017-08-30 01:20:15', '2017-08-30 09:20:15'),
(6, 'h', '2017-08-30 01:20:16', '2017-08-30 09:20:16'),
(7, 'g', '2017-08-30 01:20:17', '2017-08-30 09:20:17'),
(8, '1', '2017-08-30 01:20:18', '2017-08-30 09:20:18'),
(9, '2', '2017-08-30 01:20:19', '2017-08-30 09:20:19'),
(10, '3', '2017-08-30 01:20:19', '2017-08-30 09:20:19'),
(11, '11', '2017-08-30 01:20:22', '2017-08-30 09:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(30) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `gender` enum('male','female') DEFAULT NULL,
  `upload` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `description`, `phone`, `country`, `created`, `gender`, `upload`) VALUES
(1, 'Davepogi123', 'deeaf1ea645af982da32ed77fe32a192', 'dave.torrente@gmail.com', 'asdfasdfasdf', '111-1111-1111', 'Azerbaijan', '2017-08-30 09:19:21', 'male', './profile-img/30-08-2017-1504055961-28-08-2017-1503957139-zoro.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_positions`
--
ALTER TABLE `employee_positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
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
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `employee_positions`
--
ALTER TABLE `employee_positions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
