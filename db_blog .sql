-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 20 mars 2015 kl 01:16
-- Serverversion: 5.6.20
-- PHP-version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `db_blog`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumpning av Data i tabell `comments`
--

INSERT INTO `comments` (`id`, `content`, `date`, `post_id`, `user_id`) VALUES
(1, 'New comment', '2015-02-27 13:35:58', 40, 33),
(2, 'ghjhgj', '2015-02-27 18:05:44', 37, 33),
(3, 'dfgfdgfdgfdg', '2015-02-27 18:06:20', 37, 33),
(4, 'kjljl', '2015-02-27 18:10:09', 37, 33),
(5, 'jkljl', '2015-02-27 18:10:33', 37, 33),
(6, 'jkljljkl', '2015-02-27 18:10:44', 37, 33),
(7, 'jkljljkljklkjl', '2015-02-27 18:10:46', 37, 33),
(8, 'Kokoblä', '2015-02-27 18:12:52', 37, 33),
(9, 'koko', '2015-02-27 18:13:05', 37, 33),
(10, 'Fucker', '2015-02-27 18:14:14', 37, 33),
(11, 'jklkjl', '2015-02-27 18:14:47', 37, 33),
(12, 'kjl', '2015-02-27 18:15:36', 37, 33),
(13, 'jhk', '2015-02-27 18:15:55', 37, 33),
(14, 'Here there is no comment!', '2015-02-27 18:22:32', 40, 33),
(15, 'lökök', '2015-02-27 18:22:53', 36, 33),
(16, 'Leave a comment!', '2015-02-28 11:05:56', 35, 33),
(17, '655656', '2015-03-01 15:03:42', 37, 33),
(18, 'ghjhgjgj', '2015-03-01 15:08:27', 35, 33),
(23, 'ghfh', '2015-03-02 01:09:21', 35, 33),
(24, 'heu', '2015-03-02 02:13:51', 43, 33),
(25, 'vbnbvnbvnvbnbvnbvnvb', '2015-03-02 15:05:17', 43, 33),
(26, 'hiouo', '2015-03-03 01:50:39', 41, 33),
(27, 'uyiuyi', '2015-03-04 00:16:06', 41, 33);

-- --------------------------------------------------------

--
-- Tabellstruktur `postsb`
--

CREATE TABLE IF NOT EXISTS `postsb` (
`id` int(11) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumpning av Data i tabell `postsb`
--

INSERT INTO `postsb` (`id`, `content`, `user_id`, `date`) VALUES
(35, '<h1>Max testing</h1>\r\n<p><em>sadsadsdaddsa</em></p>\r\n<p><em>sads</em></p>\r\n<p><em>ads</em></p>\r\n<p><em>ad</em></p>\r\n<p><em>sad</em></p>\r\n<p><em>sad</em></p>\r\n<p><em>sa</em></p>\r\n<p><em>dad</em></p>\r\n<p><em>dfgdfgdfg</em></p>\r\n<p><em>dfg</em></p>', 33, '2015-03-02 02:08:44'),
(36, '<h1>Hello</h1>\r\n<p>asdadd</p>\r\n<p><img src="users/crille/img/1424472370_Koala.jpg" alt="" width="571" height="428" /></p>\r\n<p>abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abcabc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abcabc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abcabc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abc&nbsp;abc&nbsp;abcabc&nbsp;abcabc&nbsp;abc</p>\r\n<p><img src="users/crille/img/1424474186_FF97FD47-32A8-41C4-BE0D-1DD7759A352B.jpg" alt="" width="600" height="400" /></p>', 33, '2015-01-01 12:59:31'),
(37, '<h1>Localhost</h1><p>asdadas asdsadsad sadsadsad asdadas&nbsp;asdadas asdsadsad sadsadsad asdadas&dfgdgnbsp;asdadas asdsadsad sadsadsad asdadas&nbsp;asdadas asdsadsad sadsadsad asdadas&nbsp;</p><p><img src="http://localhost/blog/users/crille/img/1424968648_Chrysanthemum.jpg" alt="" width="1024" height="768" /></p>', 33, '2015-02-05 18:31:58'),
(40, '<h1>sdfdsfdsfdsf</h1>\r\n<p>sadadsada</p>\r\n<p>hej</p>\r\n<p>hej</p>\r\n<p>hej</p>\r\n<p>heasda</p>\r\n<p>sdadadada</p>\r\n<p>dsadada</p>\r\n<p>dasdadada</p>\r\n<p>dasdadada</p>\r\n<p>sad</p>', 33, '2015-03-02 02:09:01'),
(41, '<h1>Hello</h1><p>I am trying to convince my self about this shit. How many characters is 150? Well i dunno but i will soon findsdfsf sdout!</p><p>&nbsp;</p>', 33, '2015-02-10 18:31:13'),
(43, '<h1>Hello</h1>\r\n<p>Today i was at schoolkhjkhjk</p>\r\n<p><img src="http://localhost/blog/users/crille/img/1424968648_Chrysanthemum.jpg" alt="" width="428" height="321" /></p>', 33, '2015-03-03 02:02:00');

-- --------------------------------------------------------

--
-- Tabellstruktur `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `rated_by_user` int(11) NOT NULL,
  `rated_user` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `ratings`
--

INSERT INTO `ratings` (`rated_by_user`, `rated_user`, `rating`) VALUES
(55, 33, 2);

-- --------------------------------------------------------

--
-- Tabellstruktur `subscribers`
--

CREATE TABLE IF NOT EXISTS `subscribers` (
  `sub_user` int(11) NOT NULL,
  `sub_by_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `image`, `url`) VALUES
(33, 'crille', '$2y$10$gbgFDV5UbkpiSAjEMbYM9ualC7uagkCs6N5VbjmoEuS7Qcuy.GAXa', 'test@olle.com', NULL, '//localhost/Blog/users/crille'),
(54, 'crillenew', '$2y$10$RrfUbkuXGLyp/wuYApqi4uvzG/3URN00SBQs2LJFqtKZW1eC5VB2W', 'fjantztone@gmail.com', NULL, 'users/crillenew'),
(55, 'Joel', '$2y$10$6rU2krkYK73No33h3.HbpOxskp1lgUwOTey5F0v/J8zoQFDaDQIIq', 'joelkarlsson@hotmail.com', NULL, 'users/Joel');

-- --------------------------------------------------------

--
-- Tabellstruktur `walls`
--

CREATE TABLE IF NOT EXISTS `walls` (
`id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `blog_name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumpning av Data i tabell `walls`
--

INSERT INTO `walls` (`id`, `image`, `content`, `user_id`, `blog_name`) VALUES
(54, '', 'My name is crickel!', 33, 'Crickel');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_c_post_id` (`post_id`), ADD KEY `fk_c_user_id` (`user_id`);

--
-- Index för tabell `postsb`
--
ALTER TABLE `postsb`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_postsb_user_id` (`user_id`);

--
-- Index för tabell `ratings`
--
ALTER TABLE `ratings`
 ADD PRIMARY KEY (`rated_by_user`,`rated_user`), ADD KEY `fk_rated_by` (`rated_user`);

--
-- Index för tabell `subscribers`
--
ALTER TABLE `subscribers`
 ADD PRIMARY KEY (`sub_user`,`sub_by_user`), ADD KEY `fk_sub_by_user` (`sub_by_user`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `email` (`email`);

--
-- Index för tabell `walls`
--
ALTER TABLE `walls`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_wall_user_id` (`user_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT för tabell `postsb`
--
ALTER TABLE `postsb`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT för tabell `walls`
--
ALTER TABLE `walls`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `fk_c_post_id` FOREIGN KEY (`post_id`) REFERENCES `postsb` (`id`),
ADD CONSTRAINT `fk_c_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `postsb`
--
ALTER TABLE `postsb`
ADD CONSTRAINT `fk_postsb_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `ratings`
--
ALTER TABLE `ratings`
ADD CONSTRAINT `fk_rated_by` FOREIGN KEY (`rated_user`) REFERENCES `users` (`id`),
ADD CONSTRAINT `fk_rated_by_user` FOREIGN KEY (`rated_by_user`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `subscribers`
--
ALTER TABLE `subscribers`
ADD CONSTRAINT `fk_sub_by_user` FOREIGN KEY (`sub_by_user`) REFERENCES `users` (`id`),
ADD CONSTRAINT `fk_sub_user` FOREIGN KEY (`sub_user`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `walls`
--
ALTER TABLE `walls`
ADD CONSTRAINT `fk_wall_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
