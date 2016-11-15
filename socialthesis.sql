SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Βάση: `socialthesis`
--

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `published` datetime NOT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '1' COMMENT '(0: hide, 1: show)',
  `category` tinyint(1) NOT NULL,
  `content_id` int(11) NOT NULL COMMENT '(1: thesis, 2:suggestions)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

DELETE FROM `st_comments`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_config` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

DELETE FROM `st_config`;

INSERT INTO `st_config` (`id`, `name`, `value`) VALUES
(1, 'page_title', 'Social Thesis'),
(2, 'page_description', 'Η περιγραφή για το Social Thesis'),
(3, 'page_keywords', 'ΤΕΙ, διπλωματικές'),
(4, 'page_robots', 'nofollow'),
(5, 'page_welcome_text', '<h5><span>Welcome<br></span></h5><p><span>Καλωσήρθατε στο socialthesis</p>'),
(6, 'page_footer', 'Copyright <strong>2016</strong> © M102 - 2016 Team'),
(7, 'page_theme', 'default-fixed');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_divisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

DELETE FROM `st_divisions`;

INSERT INTO `st_divisions` (`id`, `title`) VALUES
(1, 'Τομέας Ανάλυσης και προγραμματισμού'),
(2, 'Τομέας Συστημάτων και Τεχνολογίας Υπολογιστών'),
(3, 'Πρόγραμμα Μεταπτυχιακών Σπουδών (ΠΜΣ) στις Ευφυείς Τεχνολογίες Διαδικτύου');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_favorites` (
  `user_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `category` tinyint(1) NOT NULL COMMENT '(1: thesis, 2: suggestions)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELETE FROM `st_favorites`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `published` datetime NOT NULL,
  `author_id` int(11) NOT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '1' COMMENT '(0: hide, 1: show)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

DELETE FROM `st_news`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(2) NOT NULL,
  `thesis_id` int(11) NOT NULL,
  `set_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `submitted` datetime NOT NULL,
  `selected` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=57 ;

DELETE FROM `st_requests`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELETE FROM `st_sessions`;

INSERT INTO `st_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('a76f679f3270e5e3b37c00709c4e7188', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:5.0) Gecko/', 1308866275, 'a:8:{s:9:"firstname";s:4:"Mighty";s:8:"God";s:8:"Koukliatis";s:5:"photo";s:15:"admin_photo.jpg";s:2:"id";s:1:"1";s:8:"username";s:5:"admin";s:5:"email";s:17:"admin@ait.teithe.gr";s:6:"access";s:1:"1";s:9:"logged_in";b:1;}');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_sets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `professor_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

DELETE FROM `st_sets`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_suggestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `published` datetime NOT NULL,
  `author_id` int(11) NOT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '1' COMMENT '(0: hide, 1: show)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

DELETE FROM `st_suggestions`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_thesis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `set_id` int(11) NOT NULL,
  `zipfile` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` int(11) NOT NULL,
  `abstract` text COLLATE utf8_unicode_ci NOT NULL,
  `final_file` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `directory` tinyint(1) NOT NULL DEFAULT '0' COMMENT '(1: published to directory)',
  `date_published` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=87 ;

DELETE FROM `st_thesis`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `st_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `access` tinyint(1) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1' COMMENT '(0: inactive, 1: active, 2: waiting activation)',
  `firstname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `professor_attr` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `professor_bio` text COLLATE utf8_unicode_ci,
  `professor_dir_id` int(11) NOT NULL,
  `student_aem` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `student_grade` float NOT NULL,
  `student_year` int(2) DEFAULT NULL,
  `student_cleft` int(2) NOT NULL,
  `student_dir_id` int(11) NOT NULL,
  `student_file` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `logged` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

DELETE FROM `st_users`;

INSERT INTO `st_users` (`id`, `username`, `password`, `email`, `access`, `activated`, `firstname`, `lastname`, `photo`, `address`, `phone`, `professor_attr`, `professor_bio`, `professor_dir_id`, `student_aem`, `student_grade`, `student_year`, `student_cleft`, `student_dir_id`, `student_file`, `created`, `logged`) VALUES
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin@ait.teithe.gr', 1, 1, 'Mighty', 'God', 'admin_photo.jpg', '', '', '', NULL, 0, '', 0, NULL, 0, 0, '', '0000-00-00 00:00:00', '2016-10-25 00:23:02');
