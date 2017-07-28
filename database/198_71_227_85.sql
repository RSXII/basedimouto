-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 198.71.227.85:3306
-- Generation Time: Jun 28, 2017 at 09:06 AM
-- Server version: 5.5.43-37.2-log
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `based_database`
--
DROP DATABASE `based_database`;
CREATE DATABASE IF NOT EXISTS `based_database` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `based_database`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` smallint(6) NOT NULL,
  `catname` varchar(60) NOT NULL,
  `description` varchar(300) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `catname`, `description`, `is_approved`) VALUES
(1, 'Announcements', 'Category that all server announcements belong to.  Only moderators may post new topics here.', 1),
(2, 'General', 'General category for all posts that have no specific topic.', 1),
(3, 'Gaming', 'Post anything about video games here.', 1),
(4, 'Anime', 'Anime general', 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `the_liked_user` smallint(6) NOT NULL,
  `the_liking_user` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`the_liked_user`, `the_liking_user`) VALUES
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mod_status`
--

DROP TABLE IF EXISTS `mod_status`;
CREATE TABLE `mod_status` (
  `status_id` tinyint(4) NOT NULL,
  `name` varchar(40) NOT NULL,
  `color` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mod_status`
--

INSERT INTO `mod_status` (`status_id`, `name`, `color`) VALUES
(1, 'Server Administrator', 'red'),
(2, 'Head Moderator', 'orange'),
(0, 'Normal User', ''),
(3, 'Moderator', '#C00BC4');

-- --------------------------------------------------------

--
-- Table structure for table `post-cats`
--

DROP TABLE IF EXISTS `post-cats`;
CREATE TABLE `post-cats` (
  `thread_id` mediumint(9) NOT NULL,
  `cat_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post-cats`
--

INSERT INTO `post-cats` (`thread_id`, `cat_id`) VALUES
(2, 2),
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `title` varchar(256) NOT NULL,
  `body` varchar(2000) NOT NULL,
  `date_created` datetime NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  `last_bumped` datetime NOT NULL,
  `parent_id` mediumint(9) NOT NULL,
  `category_id` smallint(6) NOT NULL,
  `thread_id` smallint(6) NOT NULL,
  `link_image` varchar(2000) NOT NULL DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `title`, `body`, `date_created`, `allow_comments`, `is_published`, `is_locked`, `last_bumped`, `parent_id`, `category_id`, `thread_id`, `link_image`) VALUES
(62, 11, 'Hello', '<blockquote>DirtyNast: test</blockquote>\r\n\r\nThis is a sample moderation post.', '2017-06-24 19:22:10', 1, 1, 0, '0000-00-00 00:00:00', 56, 2, 69, 'none'),
(64, 11, 'ya', 'ya', '2017-06-25 18:39:08', 1, 1, 0, '0000-00-00 00:00:00', 1, 1, 69, 'none'),
(65, 11, 'asdf', '<blockquote>Iffritta: ya</blockquote>\r\n\r\nasdfas', '2017-06-26 09:43:34', 1, 1, 0, '0000-00-00 00:00:00', 64, 1, 69, 'none'),
(69, 11, 'New test thread', 'thread delete', '2017-06-26 10:49:01', 1, 1, 0, '0000-00-00 00:00:00', 0, 2, 69, 'none'),
(70, 11, 'try this', 'lalalala', '2017-06-26 10:51:07', 1, 1, 0, '0000-00-00 00:00:00', 0, 3, 70, 'none'),
(71, 2, 'Hello', 'SSSSSSSSSSSSSSS', '2017-06-27 11:31:41', 1, 1, 0, '0000-00-00 00:00:00', 47, 2, 47, 'none'),
(72, 10, 'Pee pee', 'Sometimes when i poo poo i make pee pee!', '2017-06-27 12:03:29', 1, 1, 0, '0000-00-00 00:00:00', 0, 2, 72, 'none'),
(73, 14, 'Them.spicy memes', 'Wut up boyz', '2017-06-27 12:11:29', 1, 1, 0, '0000-00-00 00:00:00', 0, 2, 73, 'none'),
(74, 15, 'It&#39;s about to be lit folks...', 'Welcome to the purple dimension where everybody does nothin but lean', '2017-06-27 12:19:38', 1, 1, 0, '0000-00-00 00:00:00', 0, 2, 74, 'none'),
(75, 1, 'Yeah boiiiiiiiii', 'I come in the room shining. Playing laser tag with my pretty boy swag, grill so bright it''s causing blindness on sight, like a flasbang in the night. ', '2017-06-27 12:44:34', 1, 1, 0, '0000-00-00 00:00:00', 74, 2, 74, 'none'),
(76, 1, 'Sup', 'Image display incoming for them stolen memes. ', '2017-06-27 12:51:15', 1, 1, 0, '0000-00-00 00:00:00', 73, 2, 73, 'none'),
(88, 15, 'ThE L3aN kInG SuPreMe', 'Droppin rhymes like I''m Big Boi in the ''17\r\nKill Jill, and Bill Phil\r\nCause the new Air Max don''t feel right, Knight\r\nShine bright like a white knight under black light\r\nNot a monsoon like june gloom\r\nIm a Hurricane, crash in the room\r\nShootin lasers for tag\r\nI don''t know about swag\r\nAll I know is this\r\nBoi, it''s in the bag\r\n', '2017-06-27 14:13:27', 1, 1, 0, '0000-00-00 00:00:00', 74, 2, 74, 'none'),
(90, 11, 'Memes', 'Wowe', '2017-06-27 14:34:27', 1, 1, 0, '0000-00-00 00:00:00', 73, 2, 73, 'http://i.imgur.com/Gu5bNNj.png'),
(91, 1, 'Welcome to the board', 'This is an announcement for all newcomers.  \r\n\r\nThe site is still being worked on.  Some of the features are working on the site and some are not.  Please be patient as things will be added in due time.  \r\n\r\nHere is a list of what is currently working.\r\n\r\n1.  You can create an account and log in.\r\n\r\n2. You can change your profile information. (except username)\r\n2a.  Be advised that there is currently no recover password.  This will be added in the future.\r\n\r\n3.  You may make posts and reply to others posts.\r\n\r\n4.  You may post images by linking to them in the image link box.\r\n4a. See <a href="http://basedimouto.com/faq.php">the faq''s</a> to learn exactly how to do this.\r\n\r\nCurrently the private message system is in the works as well as a notification system to tell you when someone has replied to your thread.\r\n\r\nOnce again, this is all under construction so please be patient.', '2017-06-27 15:20:16', 1, 1, 0, '0000-00-00 00:00:00', 0, 1, 91, 'none'),
(92, 5, 'Dream Girlfriends', 'Post your dream girlfriends here.', '2017-06-27 16:22:46', 1, 1, 0, '0000-00-00 00:00:00', 0, 2, 92, 'https://i.imgur.com/fYNwXqL_d.jpg?maxwidth=640&shape=thumb&fidelity=high'),
(94, 1, 'TheBestTheBestTheBest', 'TheBestTheBestTheBest\r\nTheBestTheBestTheBest\r\nTheBestTheBestTheBest\r\nTheBestTheBestTheBest', '2017-06-27 16:30:09', 1, 1, 0, '0000-00-00 00:00:00', 92, 2, 92, 'http://i.imgur.com/BjBUgQ3.jpg'),
(95, 1, 'Shit boi', 'Yeee', '2017-06-27 16:32:15', 1, 1, 0, '0000-00-00 00:00:00', 88, 2, 74, 'http://smilepolitely.com/?ACT=33&f=riffraff.jpg&fid=25&d=13229');

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

DROP TABLE IF EXISTS `rank`;
CREATE TABLE `rank` (
  `rank_id` tinyint(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `points_needed` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`rank_id`, `name`, `points_needed`) VALUES
(1, 'Beginner', 0),
(2, 'Beginner 2', 50),
(3, 'Normal User', 100),
(4, 'Dedicated User', 200);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` mediumint(9) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(256) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `location` varchar(100) NOT NULL,
  `bio` varchar(256) NOT NULL,
  `profile_pic` varchar(2000) NOT NULL,
  `profile_likes` smallint(6) NOT NULL,
  `rank_id` tinyint(20) NOT NULL,
  `points` smallint(6) NOT NULL,
  `join_date` datetime NOT NULL,
  `login_date` datetime NOT NULL,
  `status_id` tinyint(6) NOT NULL,
  `status_date` datetime NOT NULL,
  `status_expiration` datetime NOT NULL,
  `secret_key` varchar(40) NOT NULL,
  `user_is_banned` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `gender`, `location`, `bio`, `profile_pic`, `profile_likes`, `rank_id`, `points`, `join_date`, `login_date`, `status_id`, `status_date`, `status_expiration`, `secret_key`, `user_is_banned`) VALUES
(1, 'XII', '58bb31d27490b8189ed1701c909465774aeb7e56', 'dirtyhouse4life@gmail.com', 'Male', 'San Diego', 'Just a regular guy.', '2657cb970a8cae158702925a305e42a27ebe5725', 0, 1, 0, '2017-06-19 10:51:40', '0000-00-00 00:00:00', 1, '2017-06-19 10:52:48', '0000-00-00 00:00:00', '43589c00d80ad0ca9a5160e600fa2aae1948e68c', '0'),
(2, 'Guy', '6797c55e9f97a4983202c0c9e7986cf3b7548d7d', 'guy@guy.com', 'Helicopter', 'Earth', 'A robot', 'ddf517de21d9967e4449e7ff1733101c727d9cdb', 0, 1, 0, '2017-06-19 10:52:02', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '5079c373955ee4252be1f1a604799757bd80fdf2', '0'),
(3, 'newuser', 'cf57e574a1a2b5f88a59706f8a6aa8b4fee3c756', 'user@email.com', '', '', '', 'r34.jpg', 0, 1, 0, '2017-06-19 09:37:18', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0'),
(4, 'ryan', 'cf57e574a1a2b5f88a59706f8a6aa8b4fee3c756', 'ryan@ryan.com', '', '', '', '', 0, 1, 0, '2017-06-19 10:44:26', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0'),
(5, 'Franchestnut', '14036a0c8feceebc79c207026c911fe7a7d0403e', 'francescapoeschl@gmail.com', 'Attack Helicopter', 'SD', '', '6d694e177f83ae74c1b2424734ca148e84978c7d', 0, 1, 0, '2017-06-20 14:32:01', '0000-00-00 00:00:00', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '131fc899205a6dc35d2e25858b46cf3d8ead9d66', '0'),
(6, 'hugh jass', '62d263d6849319b49a846c9fbaae6f4224721663', '123@aol.com', '', '', '', '', 0, 1, 0, '2017-06-22 08:02:45', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '6e6483d1dcb5b068845a6ea4e8efeeb7d9423a74', '0'),
(7, 'joe', '3e4355da981d20b886edf11d7644edd41a62bd21', 'ma@ma.com', '', '', '', '', 0, 1, 0, '2017-06-22 08:05:13', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '0'),
(8, 'joe1', '62d263d6849319b49a846c9fbaae6f4224721663', 'mama@mama.com', '', '', '', '', 0, 1, 0, '2017-06-22 08:06:11', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'de46481805b4d44bd354be010ffb60496ec3d7a9', '0'),
(9, 'testuser', 'cf57e574a1a2b5f88a59706f8a6aa8b4fee3c756', 'test@test.com', '', '', '', '9702b733aec742dfa79cd5a043309e1e0895700b', 0, 1, 0, '2017-06-23 11:36:12', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0e072566a7c7339e6b86c828bb77cabe49832d39', '0'),
(10, 'DirtyNast', '7a83302a39d507572e2bb3a50d802e88d42284d8', 'rlaumandesign@gmail.com', '', '', '', '463e913d13d534ad1da7846a2f8eac46eccea674', 0, 1, 0, '2017-06-23 18:43:54', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'd58f19a12764929396a7e218f3e210c3fd506720', '0'),
(11, 'Iffritta', '58bb31d27490b8189ed1701c909465774aeb7e56', 'ryanschultz0107@platt.edu', 'Female', 'San Diego, CA', 'Random moderator.  Please don&#39;t think too much of me, I work for free.', 'add3da9fbd6dc26babd3ad10cb761294f4f26c8e', 0, 1, 0, '2017-06-24 19:13:28', '0000-00-00 00:00:00', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'a54f33c62d9419cadcfce5cdda5a2118060ce03c', '0'),
(12, 'A Random Dude', 'cf57e574a1a2b5f88a59706f8a6aa8b4fee3c756', 'dude@dude.com', '', '', '', '', 0, 1, 0, '2017-06-25 17:18:39', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1ad78037fbeb3ff24bbf003561dff450e9d160a6', '0'),
(13, 'Mobile user', '58bb31d27490b8189ed1701c909465774aeb7e56', 'mobile@user.com', 'Male', 'California', 'Yeee ', '6900cf1621e155ee1d0df85dd0c870094ca8e41b', 0, 1, 0, '2017-06-27 11:37:06', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1ba303a95db8d7e1377f8f58d42ae2c07fa53f55', '0'),
(14, 'Imoutoswag!', '07b3aa48f9634c70bb9e13d6d6664eeea3ff04e9', 'ryan.saldana@yahoo.com', '', '', '', 'c42de02906df95f7eb8f7caf7e0921613fd6891c', 0, 1, 0, '2017-06-27 12:07:06', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'c4001759274493920acc36834abf92abe2113e87', '0'),
(15, 'SenpaisGoldenGoodies', '9d9d788fa09b4425317d04695ba492af71347b15', 'coltonwood772@yahoo.com', 'Senpai', 'SD Boi', 'Sexy bunnies and drippin hunnies. Cryppin ain&#39;t easy but somebody&#39;s gotta do it. #ShizukuKun #PhantomTroupe', 'd47330540258c9dd3c4be979f568a2b3bdab9a1b', 0, 1, 0, '2017-06-27 12:12:20', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'd082b60e7906d4b87d5cce1e70e0b84ed9eda19a', '0'),
(16, 'rudolphprather', '26668757adbd54f12fed7b2718493ac5fd96c153', 'rudolphprather@gmail.com', 'Male', '', '', '4b26105a391fed3a3693bfb8dc805e603822807e', 0, 1, 0, '2017-06-28 07:34:39', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'aaaa034f337d64bd58184823bea6ac891d0919ac', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
