-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- 생성 시간: 20-05-24 17:15
-- 서버 버전: 5.7.30-0ubuntu0.18.04.1
-- PHP 버전: 7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `DB2`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `groupchat`
--

CREATE TABLE `groupchat` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `groupchat`
--

INSERT INTO `groupchat` (`id`, `name`) VALUES
(24, 'Boat Development'),
(25, 'Group 1'),
(26, 'Group 2');

-- --------------------------------------------------------

--
-- 테이블 구조 `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `groupchat_id` int(11) NOT NULL,
  `date` datetime(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted_date` datetime(6) DEFAULT NULL,
  `edited_date` datetime(6) DEFAULT NULL,
  `pinned_date` datetime(6) DEFAULT NULL,
  `read_date` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `message`
--

INSERT INTO `message` (`id`, `groupchat_id`, `date`, `user_id`, `deleted_date`, `edited_date`, `pinned_date`, `read_date`) VALUES
(316, 24, '2020-05-23 21:25:30.981812', 21, '2020-05-23 21:27:35.579226', '2020-05-23 21:26:45.675693', NULL, '2020-05-23 21:25:31.967978'),
(317, 24, '2020-05-23 21:25:33.312819', 20, NULL, NULL, NULL, '2020-05-23 21:25:33.949542'),
(318, 24, '2020-05-23 21:27:17.129623', 20, NULL, NULL, NULL, '2020-05-23 21:27:17.209311'),
(319, 24, '2020-05-23 21:27:39.514482', 21, NULL, '2020-05-23 21:30:30.454178', NULL, '2020-05-23 21:27:40.456387'),
(320, 24, '2020-05-23 21:28:04.394151', 21, '2020-05-23 21:30:26.364861', NULL, NULL, '2020-05-23 21:28:04.454505'),
(321, 24, '2020-05-23 21:28:46.891577', 21, '2020-05-23 21:30:47.117301', NULL, NULL, '2020-05-23 21:28:47.452650'),
(322, 24, '2020-05-23 21:29:14.457937', 21, '2020-05-23 21:29:32.164563', NULL, NULL, '2020-05-23 21:29:14.459080'),
(323, 24, '2020-05-23 21:31:19.630321', 21, NULL, NULL, NULL, '2020-05-23 21:31:20.457789'),
(324, 24, '2020-05-24 13:19:24.242643', 20, NULL, '2020-05-24 13:19:33.403669', '2020-05-24 13:21:36.419805', '2020-05-24 13:19:40.441236'),
(325, 24, '2020-05-24 13:19:45.687094', 21, NULL, '2020-05-24 14:02:08.337153', NULL, '2020-05-24 13:19:46.315979'),
(326, 24, '2020-05-24 13:21:26.030229', 20, '2020-05-24 13:24:18.308226', '2020-05-24 13:23:52.045305', NULL, '2020-05-24 13:21:26.155770'),
(327, 24, '2020-05-24 13:21:53.271965', 20, NULL, '2020-05-24 13:22:23.683419', NULL, '2020-05-24 13:21:54.156665'),
(328, 24, '2020-05-24 13:24:23.943228', 20, NULL, '2020-05-24 13:24:29.111639', NULL, '2020-05-24 13:24:24.161912'),
(329, 24, '2020-05-24 13:24:48.441265', 20, NULL, NULL, NULL, '2020-05-24 13:24:49.160197'),
(330, 24, '2020-05-24 13:25:09.458630', 21, NULL, '2020-05-24 14:01:49.096393', NULL, '2020-05-24 13:25:09.595211'),
(331, 24, '2020-05-24 13:25:26.554805', 20, NULL, NULL, NULL, '2020-05-24 13:25:27.335875'),
(332, 24, '2020-05-24 13:35:45.912020', 21, NULL, '2020-05-24 14:00:25.839672', NULL, '2020-05-24 13:35:46.768146'),
(333, 24, '2020-05-24 13:37:51.997946', 20, NULL, NULL, NULL, '2020-05-24 13:37:52.169842'),
(334, 24, '2020-05-24 13:38:59.801255', 20, NULL, NULL, NULL, '2020-05-24 13:39:00.683326'),
(335, 24, '2020-05-24 13:43:05.978482', 20, NULL, '2020-05-24 13:59:49.461493', NULL, '2020-05-24 13:43:06.681526'),
(336, 24, '2020-05-24 13:43:29.877737', 21, NULL, '2020-05-24 14:00:16.599349', NULL, '2020-05-24 13:43:29.898555'),
(337, 24, '2020-05-24 13:44:02.804460', 21, '2020-05-24 13:45:01.870954', '2020-05-24 13:44:07.854789', NULL, '2020-05-24 13:46:46.181166'),
(338, 24, '2020-05-24 13:49:42.279879', 21, '2020-05-24 14:13:51.246187', '2020-05-24 14:13:41.263187', NULL, '2020-05-24 13:49:45.368350'),
(339, 24, '2020-05-24 14:13:58.654820', 21, NULL, NULL, NULL, '2020-05-24 14:13:59.246628'),
(340, 26, '2020-05-24 16:14:20.248698', 23, NULL, NULL, NULL, '2020-05-24 16:16:35.992084'),
(341, 26, '2020-05-24 16:16:04.081839', 23, NULL, NULL, NULL, '2020-05-24 16:16:35.992084'),
(342, 26, '2020-05-24 16:16:40.735954', 20, NULL, '2020-05-24 16:17:36.558173', NULL, '2020-05-24 16:16:41.689425'),
(343, 26, '2020-05-24 16:17:04.006445', 23, NULL, NULL, NULL, '2020-05-24 16:17:11.720191'),
(344, 26, '2020-05-24 16:19:42.186805', 20, '2020-05-24 16:21:05.161541', NULL, NULL, '2020-05-24 16:19:42.689512'),
(345, 26, '2020-05-24 16:21:18.232601', 20, NULL, NULL, NULL, '2020-05-24 16:21:18.692799'),
(346, 26, '2020-05-24 16:21:37.733968', 23, NULL, NULL, NULL, '2020-05-24 16:21:38.668103'),
(347, 26, '2020-05-24 16:22:17.979429', 20, NULL, NULL, NULL, '2020-05-24 16:22:18.694544'),
(348, 26, '2020-05-24 16:24:42.792505', 23, NULL, NULL, NULL, '2020-05-24 16:24:43.670326'),
(349, 26, '2020-05-24 16:43:35.938699', 23, NULL, NULL, NULL, '2020-05-24 16:43:36.681566');

-- --------------------------------------------------------

--
-- 테이블 구조 `message_image`
--

CREATE TABLE `message_image` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `message_image`
--

INSERT INTO `message_image` (`id`, `path`) VALUES
(317, 'uploads/317.barcode.gif'),
(322, 'uploads/322.e15d29bf6da428a4df73e84760a2b53ff35f541dv2_hq.jpg'),
(339, 'uploads/339.IMG-20200511-WA0005.jpg'),
(340, 'uploads/340.Logo_white_background.png'),
(344, 'uploads/344.20200410161235_1.jpg'),
(345, 'uploads/345.Nyan-Cat-GIF-source.gif');

-- --------------------------------------------------------

--
-- 테이블 구조 `message_poll`
--

CREATE TABLE `message_poll` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `due` datetime DEFAULT NULL,
  `multi_select` tinyint(1) NOT NULL,
  `ended_date` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `message_poll`
--

INSERT INTO `message_poll` (`id`, `title`, `due`, `multi_select`, `ended_date`) VALUES
(323, 'poll', NULL, 0, '2020-05-23 21:31:35.398839'),
(349, 'Dinner', '2020-05-23 17:00:00', 0, '2020-05-24 16:43:36.683613');

-- --------------------------------------------------------

--
-- 테이블 구조 `message_text`
--

CREATE TABLE `message_text` (
  `id` int(11) NOT NULL,
  `data` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `message_text`
--

INSERT INTO `message_text` (`id`, `data`) VALUES
(316, 'yayyyyyyy 23'),
(319, 'hellowie'),
(320, 'hi'),
(321, 'hi'),
(324, 'Hello'),
(325, 'hello y'),
(326, '??'),
(327, 'Enough???'),
(328, 'Smother me'),
(329, 'She\'s gone'),
(330, '@Junhyeok Han (junhyeok.john.han@gmail.com) mwa <3 lobe'),
(331, 'Chacha said \"hello\"'),
(332, '@Junhyeok Han (junhyeok.john.han@gmail.com)  hehe'),
(333, '@Chantal Ochiai (chantalochiai@gmail.com) '),
(334, '@Chantal Ochiai (chantalochiai@gmail.com) '),
(335, 'hh'),
(336, 'hello meh 3 loloh'),
(337, 'hello e3'),
(338, 'hello \'s wie'),
(342, 'What is the first picture?'),
(343, 'the globe'),
(346, 'nyan nyan'),
(347, '@Kenny Trinh (kennytrinh@gmail.com) :D'),
(348, '@Junhyeok Han (junhyeok.john.han@gmail.com) Hello again');

-- --------------------------------------------------------

--
-- 테이블 구조 `message_video`
--

CREATE TABLE `message_video` (
  `id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 테이블의 덤프 데이터 `message_video`
--

INSERT INTO `message_video` (`id`, `path`) VALUES
(318, 'uploads/318.file_example_MOV_640_800kB.mov'),
(341, 'uploads/341.file_example_MOV_480_700kB.mov');

-- --------------------------------------------------------

--
-- 테이블 구조 `notification`
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
-- 테이블의 덤프 데이터 `notification`
--

INSERT INTO `notification` (`id`, `message`, `is_read`, `date`, `message_id`, `user_id`) VALUES
(14, 'Welcome to Boat!', 1, '2020-05-23 21:25:09', NULL, 20),
(15, 'Welcome to Boat!', 1, '2020-05-23 21:25:11', NULL, 21),
(16, 'Junhyeok Han has mentioned you.', 1, '2020-05-24 13:43:05', 335, 21),
(17, 'Welcome to Boat!', 0, '2020-05-24 14:39:37', NULL, 22),
(18, 'Welcome to Boat!', 1, '2020-05-24 16:13:11', NULL, 23),
(19, 'Junhyeok Han has mentioned you.', 1, '2020-05-24 16:22:17', 347, 23),
(20, 'Kenny Trinh has mentioned you.', 0, '2020-05-24 16:24:42', 348, 20);

-- --------------------------------------------------------

--
-- 테이블 구조 `poll_option`
--

CREATE TABLE `poll_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message_poll_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `poll_option`
--

INSERT INTO `poll_option` (`id`, `name`, `message_poll_id`) VALUES
(36, 'option 2', 323),
(37, 'option 1', 323),
(38, 'Pizza', 349),
(39, 'Sushi', 349);

-- --------------------------------------------------------

--
-- 테이블 구조 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`) VALUES
(20, 'Junhyeok', 'Han', 'junhyeok.john.han@gmail.com', 'b6e4f77c121675901cf84c9eb3ff5875'),
(21, 'Chantal', 'Ochiai', 'chantalochiai@gmail.com', 'fe31fa90359033016ca35355d37f51e2'),
(22, 'Vishnupriya', 'Manchiganti', 'vishnupriyamanchiganti@gmail.com', '027881bf924f5fb7c690bf74efc218d5'),
(23, 'Kenny', 'Trinh', 'kennytrinh@gmail.com', '152a1f7596aa453beaa590ec13c19fa5');

-- --------------------------------------------------------

--
-- 테이블 구조 `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `user_group`
--

INSERT INTO `user_group` (`id`, `user_id`, `group_id`) VALUES
(31, 21, 24),
(32, 20, 24),
(33, 23, 25),
(34, 21, 26),
(35, 22, 26),
(36, 20, 26),
(37, 23, 26);

-- --------------------------------------------------------

--
-- 테이블 구조 `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `poll_option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `vote`
--

INSERT INTO `vote` (`id`, `user_id`, `poll_option_id`) VALUES
(14, 21, 36);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `groupchat`
--
ALTER TABLE `groupchat`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_key_message_user_id` (`user_id`),
  ADD KEY `fk_foreign_key_message_groupchat_id` (`groupchat_id`);

--
-- 테이블의 인덱스 `message_image`
--
ALTER TABLE `message_image`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `message_poll`
--
ALTER TABLE `message_poll`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `message_text`
--
ALTER TABLE `message_text`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `message_video`
--
ALTER TABLE `message_video`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_key_message_id` (`message_id`),
  ADD KEY `fk_foreign_notification_user_id` (`user_id`);

--
-- 테이블의 인덱스 `poll_option`
--
ALTER TABLE `poll_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_message_poll_id` (`message_poll_id`);

--
-- 테이블의 인덱스 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foreign_key_user_id` (`user_id`),
  ADD KEY `fk_foreign_key_group_id` (`group_id`);

--
-- 테이블의 인덱스 `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_poll_option_id` (`poll_option_id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `groupchat`
--
ALTER TABLE `groupchat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- 테이블의 AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=350;
--
-- 테이블의 AUTO_INCREMENT `message_image`
--
ALTER TABLE `message_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=346;
--
-- 테이블의 AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 테이블의 AUTO_INCREMENT `poll_option`
--
ALTER TABLE `poll_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- 테이블의 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- 테이블의 AUTO_INCREMENT `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- 테이블의 AUTO_INCREMENT `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- 덤프된 테이블의 제약사항
--

--
-- 테이블의 제약사항 `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_foreign_key_message_groupchat_id` FOREIGN KEY (`groupchat_id`) REFERENCES `groupchat` (`id`),
  ADD CONSTRAINT `fk_foreign_key_message_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 테이블의 제약사항 `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_foreign_key_message_id` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
  ADD CONSTRAINT `fk_foreign_notification_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 테이블의 제약사항 `poll_option`
--
ALTER TABLE `poll_option`
  ADD CONSTRAINT `fk_message_poll_id` FOREIGN KEY (`message_poll_id`) REFERENCES `message_poll` (`id`);

--
-- 테이블의 제약사항 `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `fk_foreign_key_group_id` FOREIGN KEY (`group_id`) REFERENCES `groupchat` (`id`),
  ADD CONSTRAINT `fk_foreign_key_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- 테이블의 제약사항 `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `fk_poll_option_id` FOREIGN KEY (`poll_option_id`) REFERENCES `poll_option` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
