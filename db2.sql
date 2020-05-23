-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 20-05-22 19:21
-- 서버 버전: 10.4.11-MariaDB
-- PHP 버전: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `db2`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `groupchat`
--

CREATE TABLE `groupchat` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- 테이블 구조 `message_image`
--

CREATE TABLE `message_image` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- 테이블 구조 `message_text`
--

CREATE TABLE `message_text` (
  `id` int(11) NOT NULL,
  `data` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 테이블 구조 `message_video`
--

CREATE TABLE `message_video` (
  `id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- 테이블 구조 `poll_option`
--

CREATE TABLE `poll_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message_poll_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- 테이블 구조 `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 테이블의 AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- 테이블의 AUTO_INCREMENT `message_image`
--
ALTER TABLE `message_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- 테이블의 AUTO_INCREMENT `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 테이블의 AUTO_INCREMENT `poll_option`
--
ALTER TABLE `poll_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 테이블의 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 테이블의 AUTO_INCREMENT `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
