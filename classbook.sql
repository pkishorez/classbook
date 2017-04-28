-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2017 at 12:10 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `frm` varchar(10) NOT NULL,
  `too` varchar(10) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `chat`
--
DELIMITER $$
CREATE TRIGGER `after_inserting_into_chat` AFTER INSERT ON `chat` FOR EACH ROW BEGIN
        update chat_stats set unseen=unseen+1, time=CURRENT_TIMESTAMP where too=NEW.too and frm=NEW.frm;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_stats`
--

CREATE TABLE `chat_stats` (
  `frm` varchar(10) NOT NULL,
  `too` varchar(10) NOT NULL,
  `unseen` int(11) DEFAULT '0',
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_stats`
--

INSERT INTO `chat_stats` (`frm`, `too`, `unseen`, `time`) VALUES
('KISHORE', 'KISHORE', 0, '2017-04-28 15:32:42');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `wall_id` int(11) NOT NULL,
  `owner` varchar(45) DEFAULT NULL,
  `comment` mediumtext,
  `has_image` tinyint(1) DEFAULT '0',
  `n_likes` int(11) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `comments`
--
DELIMITER $$
CREATE TRIGGER `after_deleting_comment` AFTER DELETE ON `comments` FOR EACH ROW BEGIN
        update wall set n_comments=n_comments-1 where wall.id=OLD.wall_id;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_inserting_comment` AFTER INSERT ON `comments` FOR EACH ROW BEGIN
        update wall set n_comments=n_comments+1 where wall.id=NEW.wall_id;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `comment_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `comment_likes`
--
DELIMITER $$
CREATE TRIGGER `AFTER_LIKING_COMMENT` AFTER INSERT ON `comment_likes` FOR EACH ROW BEGIN
        UPDATE comments set n_likes=n_likes+1 where NEW.comment_id=comments.id;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `AFTER_UNLIKING_COMMENT` AFTER DELETE ON `comment_likes` FOR EACH ROW BEGIN
        UPDATE comments set n_likes=n_likes-1 where OLD.comment_id=comments.id;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE `online` (
  `user_id` varchar(10) NOT NULL,
  `last_online` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` varchar(10) NOT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `facebook_id` varchar(100) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `ph_no` varchar(15) DEFAULT NULL,
  `fav_actor` varchar(100) DEFAULT NULL,
  `fav_movies` varchar(100) DEFAULT NULL,
  `fav_dish` varchar(45) DEFAULT NULL,
  `fav_place` varchar(45) DEFAULT NULL,
  `fav_subject` varchar(100) DEFAULT NULL,
  `fav_teacher` varchar(100) DEFAULT NULL,
  `fav_color` varchar(20) DEFAULT NULL,
  `best_friend` varchar(45) DEFAULT NULL,
  `hobbies` varchar(200) DEFAULT NULL,
  `quote` varchar(45) DEFAULT NULL,
  `ambition` varchar(100) DEFAULT NULL,
  `role_model` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `father_name`, `mother_name`, `nickname`, `dob`, `facebook_id`, `email`, `ph_no`, `fav_actor`, `fav_movies`, `fav_dish`, `fav_place`, `fav_subject`, `fav_teacher`, `fav_color`, `best_friend`, `hobbies`, `quote`, `ambition`, `role_model`) VALUES
('KISHORE', '', '', 'Kishore', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(10) NOT NULL,
  `orig_name` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `dob` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `graphpassword` varchar(45) DEFAULT NULL,
  `first_time_login` tinyint(1) DEFAULT '0',
  `cover_photo_top` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `orig_name`, `name`, `gender`, `dob`, `password`, `graphpassword`, `first_time_login`, `cover_photo_top`) VALUES
('CHAYA', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('HARI', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('HARIKA', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('JAGGU', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('KISHORE', NULL, 'Kishore', 'male', '1993/8/10', 'kittu', NULL, 0, -178),
('MADHU', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('MANI', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('RAJU', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('RAMA', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('RAVALI', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('SATISHG', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0),
('VAMSI', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wall`
--

CREATE TABLE `wall` (
  `id` int(11) NOT NULL,
  `owner` varchar(10) DEFAULT NULL,
  `posted_on` varchar(10) DEFAULT NULL,
  `message` text,
  `images` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT 'POST',
  `n_comments` int(11) DEFAULT '0',
  `n_likes` int(11) DEFAULT '0',
  `time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wall`
--

INSERT INTO `wall` (`id`, `owner`, `posted_on`, `message`, `images`, `type`, `n_comments`, `n_likes`, `time`) VALUES
(230, 'KISHORE', NULL, '', 1, 'PROF_CHANGE', 0, 0, '2017-04-28 15:35:34');

-- --------------------------------------------------------

--
-- Table structure for table `wall_likes`
--

CREATE TABLE `wall_likes` (
  `wall_id` int(11) NOT NULL,
  `user_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `wall_likes`
--
DELIMITER $$
CREATE TRIGGER `AFTER_LIKING_WALL` AFTER INSERT ON `wall_likes` FOR EACH ROW BEGIN
        UPDATE wall SET n_likes=n_likes+1 WHERE wall.id=NEW.wall_id;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `AFTER_UNLIKING_WALL` AFTER DELETE ON `wall_likes` FOR EACH ROW BEGIN
        UPDATE wall SET n_likes=n_likes-1 WHERE wall.id=OLD.wall_id;
    END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`too`,`frm`),
  ADD KEY `fk_chat_1` (`too`),
  ADD KEY `fk_chat_2` (`frm`);

--
-- Indexes for table `chat_stats`
--
ALTER TABLE `chat_stats`
  ADD PRIMARY KEY (`frm`,`too`),
  ADD KEY `index2` (`too`),
  ADD KEY `fk_chat_stats_1` (`frm`),
  ADD KEY `fk_chat_stats_2` (`too`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`wall_id`),
  ADD KEY `fk_comments_1` (`wall_id`),
  ADD KEY `index4` (`owner`),
  ADD KEY `fk_comments_2` (`owner`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`comment_id`,`user_id`),
  ADD KEY `index2` (`comment_id`),
  ADD KEY `fk_comment_likes_1` (`comment_id`),
  ADD KEY `fk_comment_likes_2` (`user_id`),
  ADD KEY `index5` (`user_id`);

--
-- Indexes for table `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_online_1` (`user_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_profile_1` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wall`
--
ALTER TABLE `wall`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`owner`),
  ADD KEY `fk_wall_1` (`owner`),
  ADD KEY `index4` (`posted_on`),
  ADD KEY `fk_wall_2` (`posted_on`);

--
-- Indexes for table `wall_likes`
--
ALTER TABLE `wall_likes`
  ADD PRIMARY KEY (`wall_id`,`user_id`),
  ADD KEY `index2` (`wall_id`),
  ADD KEY `index3` (`user_id`),
  ADD KEY `fk_wall_likes_1` (`wall_id`),
  ADD KEY `fk_wall_likes_2` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=412;
--
-- AUTO_INCREMENT for table `wall`
--
ALTER TABLE `wall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `fk_chat_1` FOREIGN KEY (`too`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chat_2` FOREIGN KEY (`frm`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `chat_stats`
--
ALTER TABLE `chat_stats`
  ADD CONSTRAINT `fk_chat_stats_1` FOREIGN KEY (`frm`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chat_stats_2` FOREIGN KEY (`too`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_1` FOREIGN KEY (`wall_id`) REFERENCES `wall` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_2` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `fk_comment_likes_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comment_likes_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `online`
--
ALTER TABLE `online`
  ADD CONSTRAINT `fk_online_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_profile_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wall`
--
ALTER TABLE `wall`
  ADD CONSTRAINT `fk_wall_1` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wall_2` FOREIGN KEY (`posted_on`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wall_likes`
--
ALTER TABLE `wall_likes`
  ADD CONSTRAINT `fk_wall_likes_1` FOREIGN KEY (`wall_id`) REFERENCES `wall` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wall_likes_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
