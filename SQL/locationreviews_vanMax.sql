SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `companies` (`id`, `name`) VALUES
(1, 'Normal thing'),
(2, 'Max'),
(666, 'DEVIL');

CREATE TABLE `employees` (
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `employees` (`user_id`, `company_id`) VALUES
(1, 1),
(2, 2);

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `locations` (`id`, `name`, `company_id`) VALUES
(1, 'Lokaal 1', 1),
(2, 'Lokaal 2', 1),
(3, 'Lokaal 3', 2),
(7, 'Lokaal kaka', 1),
(8, 'Max is derp', 2),
(9, 'DEVILS ROOM', 666),
(10, 'iSpace', 1);

CREATE TABLE `problemreactions` (
  `id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `problemreactions` (`id`, `problem_id`, `rating`, `description`) VALUES
(1, 1, 0, 'Niet waar!'),
(2, 1, 1, NULL),
(3, 2, 0, ''),
(4, 2, 1, ''),
(5, 2, 1, 'Inderdaad!'),
(6, 5, 1, 'Goed gedaan!');

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `description` varchar(130) DEFAULT NULL,
  `date` datetime NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `technician` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `problems` (`id`, `location_id`, `description`, `date`, `fixed`, `technician`) VALUES
(1, 1, 'Toilet kapot', '2017-01-01 00:00:00', 0, 5),
(2, 2, 'vuilbakken vol', '2017-10-10 00:00:00', 0, 5),
(3, 7, 'Spoken', '2017-01-03 09:30:00', 0, 1),
(5, 7, 'Andere Spoken', '2017-01-03 09:45:00', 1, NULL),
(6, 2, 'verf', '2018-01-03 09:45:00', 1, NULL);

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rolename` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `roles` (`id`, `rolename`) VALUES
(2, 'admin'),
(0, 'technician'),
(1, 'workmanager');

CREATE TABLE `statusreports` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `statusreports` (`id`, `status`, `date`, `location_id`) VALUES
(3, 1, '2000-01-01 00:00:00', 3),
(4, 2, '2000-01-02 00:00:00', 2),
(5, 1, '2017-02-03 12:30:00', 7);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `name`, `role`) VALUES
(1, 'Dennis', 2),
(2, 'Max', 2),
(3, 'Max zijn mama', 0),
(4, 'Spongebob', 1);


ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `employees`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_company_id_idx` (`company_id`);

ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_company_id_idx` (`company_id`);

ALTER TABLE `problemreactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_problem_id_idx` (`problem_id`);

ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_location_id_idx` (`location_id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rolesname_UNIQUE` (`rolename`);

ALTER TABLE `statusreports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_idx` (`location_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_role_idx` (`role`);


ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=667;
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `problemreactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `statusreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `employees`
  ADD CONSTRAINT `fk_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `locations`
  ADD CONSTRAINT `fk_company_id_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `problemreactions`
  ADD CONSTRAINT `fk_problem_id` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `problems`
  ADD CONSTRAINT `fk_location_id` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `statusreports`
  ADD CONSTRAINT `id` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
