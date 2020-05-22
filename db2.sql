-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2020 at 06:42 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `groupchat`
--

CREATE TABLE `groupchat` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groupchat`
--

INSERT INTO `groupchat` (`id`, `name`) VALUES
(19, 'Group 1');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `groupchat_id` int(11) NOT NULL,
  `date` datetime(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted_date` datetime(6) DEFAULT NULL,
  `edited_date` datetime(6) DEFAULT NULL,
  `pinned_date` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `groupchat_id`, `date`, `user_id`, `deleted_date`, `edited_date`, `pinned_date`) VALUES
(196, 19, '2020-05-21 13:53:36.966922', 12, NULL, NULL, NULL),
(197, 19, '2020-05-21 14:00:42.174007', 12, NULL, NULL, NULL),
(198, 19, '2020-05-21 15:23:06.395603', 12, NULL, NULL, NULL),
(199, 19, '2020-05-21 17:05:51.215842', 12, NULL, NULL, NULL),
(200, 19, '2020-05-21 17:05:54.535563', 12, NULL, NULL, NULL),
(201, 19, '2020-05-21 17:10:46.511169', 12, NULL, NULL, NULL),
(202, 19, '2020-05-21 17:10:53.814824', 12, NULL, NULL, NULL),
(203, 19, '2020-05-21 17:11:01.870855', 12, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_image`
--

CREATE TABLE `message_image` (
  `id` int(11) NOT NULL,
  `data` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message_poll`
--

CREATE TABLE `message_poll` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `due` datetime DEFAULT NULL,
  `multi_select` tinyint(1) NOT NULL,
  `ended_date` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message_text`
--

CREATE TABLE `message_text` (
  `id` int(11) NOT NULL,
  `data` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_text`
--

INSERT INTO `message_text` (`id`, `data`) VALUES
(196, 'hi'),
(197, 'hihi'),
(198, 'hi loooo'),
(199, 'hi'),
(200, 'looo'),
(201, 'hello'),
(202, 'hello'),
(203, 'how are you');

-- --------------------------------------------------------

--
-- Table structure for table `message_video`
--

CREATE TABLE `message_video` (
  `id` int(11) NOT NULL,
  `data` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `message`, `is_read`, `date`, `message_id`, `user_id`) VALUES
(6, 'Welcome to our application!', 0, '2020-05-21 13:53:26', NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `poll_option`
--

CREATE TABLE `poll_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message_poll_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(12, 'Chantal', 'Ochiai', 'chantalochiai@gmail.com', 'fe31fa90359033016ca35355d37f51e2');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `user_id`, `group_id`) VALUES
(21, 12, 19);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `poll_option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groupchat`
--
ALTER TABLE `groupchat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_key_message_user_id` (`user_id`),
  ADD KEY `fk_foreign_key_message_groupchat_id` (`groupchat_id`);

--
-- Indexes for table `message_image`
--
ALTER TABLE `message_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_poll`
--
ALTER TABLE `message_poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_text`
--
ALTER TABLE `message_text`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_video`
--
ALTER TABLE `message_video`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_key_message_id` (`message_id`),
  ADD KEY `fk_foreign_notification_user_id` (`user_id`);

--
-- Indexes for table `poll_option`
--
ALTER TABLE `poll_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_message_poll_id` (`message_poll_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_key_user_id` (`user_id`),
  ADD KEY `fk_foreign_key_group_id` (`group_id`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_poll_option_id` (`poll_option_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groupchat`
--
ALTER TABLE `groupchat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `poll_option`
--
ALTER TABLE `poll_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_foreign_key_message_groupchat_id` FOREIGN KEY (`groupchat_id`) REFERENCES `groupchat` (`id`),
  ADD CONSTRAINT `fk_foreign_key_message_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_foreign_key_message_id` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `fk_foreign_notification_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `poll_option`
--
ALTER TABLE `poll_option`
  ADD CONSTRAINT `fk_message_poll_id` FOREIGN KEY (`message_poll_id`) REFERENCES `message_poll` (`id`);

--
-- Constraints for table `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `fk_foreign_key_group_id` FOREIGN KEY (`group_id`) REFERENCES `groupchat` (`id`),
  ADD CONSTRAINT `fk_foreign_key_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `fk_poll_option_id` FOREIGN KEY (`poll_option_id`) REFERENCES `poll_option` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
