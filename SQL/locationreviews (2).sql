-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 14, 2017 at 11:52 AM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `locationreviews`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`) VALUES
(1, 'Normal thing'),
(2, 'Max'),
(666, 'DEVIL');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`user_id`, `company_id`) VALUES
(1, 1),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `company_id`) VALUES
(1, 'Lokaal 1', 1),
(2, 'Lokaal 2', 1),
(3, 'Lokaal 3', 2),
(7, 'Lokaal kaka', 1),
(8, 'Max is derp', 2),
(9, 'DEVILS ROOM', 666),
(10, 'iSpace', 1),
(18, 'Postkamer 2', 2),
(19, 'React Room', 2),
(20, 'Boo', 1),
(21, 'Toiletten', 1),
(22, 'Toiletten 2', 1),
(23, 'Trixie Mattel', 2),
(24, 'Opslagruimte', 666),
(25, 'Upside Down', 1),
(27, 'kaas', 1),
(28, 'MarioLand', 2),
(29, 'LuigiLand', 2),
(30, 'LuigiLand', 2),
(31, 'Treasure Island', 2),
(32, 'Green Room', 2),
(33, 'Upside Down', 2);

-- --------------------------------------------------------

--
-- Table structure for table `problemreactions`
--

CREATE TABLE `problemreactions` (
  `id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `problemreactions`
--

INSERT INTO `problemreactions` (`id`, `problem_id`, `rating`, `description`) VALUES
(1, 1, 0, 'Niet waar!'),
(2, 1, 1, NULL),
(3, 2, 0, ''),
(4, 2, 1, ''),
(5, 2, 1, 'Inderdaad!'),
(6, 5, 1, 'Goed gedaan!'),
(7, 5, 0, 'JSON is beter!'),
(8, 2, 1, 'Eens met React testen'),
(9, 2, 1, 'Eens met React testen'),
(10, 2, 1, 'Eens met React testen'),
(11, 5, 0, ''),
(12, 5, 0, 'Ik vond het stom!'),
(13, 10, 1, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `description` varchar(130) DEFAULT NULL,
  `date` datetime NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `technician` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `location_id`, `description`, `date`, `fixed`, `technician`) VALUES
(1, 1, 'Toilet kapot', '2017-01-01 00:00:00', 1, 8),
(2, 2, 'vuilbakken vol', '2017-10-10 00:00:00', 1, 8),
(3, 7, 'Spoken', '2017-01-03 09:30:00', 0, 8),
(5, 7, 'Andere Spoken', '2017-01-03 09:45:00', 0, 8),
(6, 2, 'verf', '2018-01-03 09:45:00', 0, NULL),
(7, 2, 'API gebruikt geen JSON', '2017-12-20 13:55:00', 0, 5),
(8, 7, 'API gebruikt geen JSON', '2017-12-20 13:55:00', 0, 3),
(9, 2, '\'t Is Weer Kapot', '2017-10-22 16:25:12', 0, NULL),
(10, 24, 'Het staat in brand!', '2017-10-24 13:48:29', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rolename` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `rolename`) VALUES
(2, 'admin'),
(0, 'technician'),
(1, 'workmanager');

-- --------------------------------------------------------

--
-- Table structure for table `statusreports`
--

CREATE TABLE `statusreports` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statusreports`
--

INSERT INTO `statusreports` (`id`, `status`, `date`, `location_id`) VALUES
(3, 1, '2000-01-01 00:00:00', 3),
(4, 2, '2000-01-02 00:00:00', 2),
(5, 1, '2017-02-03 12:30:00', 7),
(6, 0, '2017-12-20 13:55:00', 7),
(7, 0, '2017-10-22 15:27:38', 2),
(9, 0, '2017-10-24 13:32:18', 1),
(10, 1, '2017-10-24 13:33:34', 1),
(11, 2, '2017-10-24 13:48:03', 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`) VALUES
(1, 'Dennis', 2),
(2, 'Max', 2),
(3, 'Papa', 0),
(4, 'Spongebob', 1),
(5, 'Cuphead', 0),
(7, 'Buzz', 1),
(8, 'BobDeBouwer', 0),
(10, 'Dexter', 0),
(11, 'Jan', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_company_id_idx` (`company_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_id_idx` (`company_id`);

--
-- Indexes for table `problemreactions`
--
ALTER TABLE `problemreactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_problem_id_idx` (`problem_id`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_location_id_idx` (`location_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rolesname_UNIQUE` (`rolename`);

--
-- Indexes for table `statusreports`
--
ALTER TABLE `statusreports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_idx` (`location_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_role_idx` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=667;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `problemreactions`
--
ALTER TABLE `problemreactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `statusreports`
--
ALTER TABLE `statusreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `fk_company_id_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `problemreactions`
--
ALTER TABLE `problemreactions`
  ADD CONSTRAINT `fk_problem_id` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `statusreports`
--
ALTER TABLE `statusreports`
  ADD CONSTRAINT `id` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
