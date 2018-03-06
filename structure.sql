-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-03-05 13:15:04
-- 服务器版本： 5.7.20
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wssa_dev`
--

-- --------------------------------------------------------

--
-- 表的结构 `competition`
--

DROP TABLE IF EXISTS `competition`;
CREATE TABLE IF NOT EXISTS `competition` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` char(10) NOT NULL DEFAULT '',
  `wca_competition_id` char(32) NOT NULL DEFAULT '',
  `old_competition_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `name` char(128) NOT NULL DEFAULT '',
  `name_zh` char(50) NOT NULL DEFAULT '',
  `tba` tinyint(1) NOT NULL DEFAULT '0',
  `alias` char(128) NOT NULL,
  `date` int(11) UNSIGNED NOT NULL,
  `end_date` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reg_start` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reg_end` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `province_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `city_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `venue` varchar(512) NOT NULL DEFAULT '',
  `venue_zh` varchar(512) NOT NULL DEFAULT '',
  `entry_fee` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `second_stage_date` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `second_stage_ratio` float UNSIGNED NOT NULL DEFAULT '0',
  `second_stage_all` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `third_stage_date` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `third_stage_ratio` float UNSIGNED NOT NULL DEFAULT '0',
  `third_stage_all` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `online_pay` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `alipay_url` varchar(512) NOT NULL DEFAULT '',
  `regulations` longtext,
  `regulations_zh` longtext,
  `information` longtext,
  `information_zh` longtext,
  `travel` longtext,
  `travel_zh` longtext,
  `cert_name` varchar(20) NOT NULL DEFAULT '',
  `person_num` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `check_person` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `fill_passport` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `show_regulations` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `show_qrcode` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `require_avatar` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `local_type` tinyint(1) NOT NULL DEFAULT '0',
  `multi_countries` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `live` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `disable_chat` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `has_qualifying_time` tinyint(1) UNSIGNED DEFAULT '0',
  `qualifying_end_time` int(11) UNSIGNED DEFAULT '0',
  `paid` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `confirm_time` int(10) UNSIGNED DEFAULT '0',
  `entourage_limit` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `entourage_fee` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `podiums_children` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `podiums_females` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `podiums_new_comers` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `refund_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `cancellation_end_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reg_reopen_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `has_been_full` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `podiums_greater_china` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `podiums_u8` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `podiums_u10` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `podiums_u12` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `t_shirt` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `staff` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `live_stream_url` varchar(256) NOT NULL DEFAULT '',
  `auto_accept` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `podiums_num` tinyint(1) UNSIGNED NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `type` (`type`,`date`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `competition_application`
--

DROP TABLE IF EXISTS `competition_application`;
CREATE TABLE IF NOT EXISTS `competition_application` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(11) UNSIGNED NOT NULL,
  `schedule` text NOT NULL,
  `organized_competition` text NOT NULL,
  `self_introduction` text NOT NULL,
  `team_introduction` text NOT NULL,
  `venue_detail` text NOT NULL,
  `budget` text NOT NULL,
  `sponsor` text NOT NULL,
  `other` text NOT NULL,
  `reason` text,
  `create_time` int(11) UNSIGNED NOT NULL,
  `update_time` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `competition_cert`
--

DROP TABLE IF EXISTS `competition_cert`;
CREATE TABLE IF NOT EXISTS `competition_cert` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `hash` varchar(32) NOT NULL DEFAULT '',
  `has_participations` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`),
  KEY `user_id` (`user_id`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `competition_delegate`
--

DROP TABLE IF EXISTS `competition_delegate`;
CREATE TABLE IF NOT EXISTS `competition_delegate` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `delegate_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `competition_event`
--

DROP TABLE IF EXISTS `competition_event`;
CREATE TABLE IF NOT EXISTS `competition_event` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(11) UNSIGNED NOT NULL,
  `event` varchar(32) DEFAULT NULL,
  `round` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `fee` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `fee_second` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `fee_third` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `qualifying_best` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `qualifying_average` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `competition_event` (`competition_id`,`event`),
  KEY `competition_id` (`competition_id`),
  KEY `event` (`event`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `competition_location`
--

DROP TABLE IF EXISTS `competition_location`;
CREATE TABLE IF NOT EXISTS `competition_location` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `location_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `country_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `province_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `city_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `city_name` varchar(128) NOT NULL DEFAULT '',
  `city_name_zh` varchar(128) NOT NULL DEFAULT '',
  `venue` varchar(512) NOT NULL DEFAULT '',
  `venue_zh` varchar(512) NOT NULL DEFAULT '',
  `delegate_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `delegate_text` varchar(256) NOT NULL DEFAULT '',
  `fee` varchar(128) NOT NULL DEFAULT '',
  `longitude` decimal(12,9) NOT NULL DEFAULT '0.000000000',
  `latitude` decimal(12,9) NOT NULL DEFAULT '0.000000000',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `competition_organizer`
--

DROP TABLE IF EXISTS `competition_organizer`;
CREATE TABLE IF NOT EXISTS `competition_organizer` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `organizer_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`),
  KEY `organizer_id` (`organizer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` varchar(20) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `title_zh` varchar(1024) NOT NULL,
  `content` longtext NOT NULL,
  `content_zh` longtext NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `custom_event`
--

DROP TABLE IF EXISTS `custom_event`;
CREATE TABLE IF NOT EXISTS `custom_event` (
  `id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `name_zh` varchar(32) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `has_icon` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `delegate`
--

DROP TABLE IF EXISTS `delegate`;
CREATE TABLE IF NOT EXISTS `delegate` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(128) NOT NULL,
  `name_zh` char(128) NOT NULL,
  `email` char(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `equipment`
--

DROP TABLE IF EXISTS `equipment`;
CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(1024) NOT NULL,
  `title_zh` varchar(1024) NOT NULL,
  `cover` varchar(256) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `content_zh` longtext NOT NULL,
  `sequence` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status_weight_date` (`status`,`sequence`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `equipment_category`
--

DROP TABLE IF EXISTS `equipment_category`;
CREATE TABLE IF NOT EXISTS `equipment_category` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `name_zh` varchar(128) NOT NULL,
  `sequence` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status_weight_date` (`status`,`sequence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(1024) NOT NULL,
  `title_zh` varchar(1024) NOT NULL,
  `content` longtext NOT NULL,
  `content_zh` longtext NOT NULL,
  `date` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status_weight_date` (`status`,`date`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `faq_category`
--

DROP TABLE IF EXISTS `faq_category`;
CREATE TABLE IF NOT EXISTS `faq_category` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `name_zh` varchar(128) NOT NULL,
  `date` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status_weight_date` (`status`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `group_schedule`
--

DROP TABLE IF EXISTS `group_schedule`;
CREATE TABLE IF NOT EXISTS `group_schedule` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) NOT NULL,
  `day` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `stage` char(10) NOT NULL DEFAULT 'main',
  `start_time` int(10) UNSIGNED NOT NULL,
  `end_time` int(10) UNSIGNED NOT NULL,
  `event` char(64) NOT NULL,
  `group` char(10) NOT NULL DEFAULT '',
  `format` char(10) NOT NULL,
  `round` char(10) NOT NULL,
  `number` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `cut_off` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `time_limit` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `cumulative` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `live_event_round`
--

DROP TABLE IF EXISTS `live_event_round`;
CREATE TABLE IF NOT EXISTS `live_event_round` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `event` varchar(32) DEFAULT NULL,
  `round` char(1) NOT NULL DEFAULT '',
  `format` char(1) NOT NULL DEFAULT '',
  `cut_off` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `time_limit` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `number` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `operator_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`),
  KEY `competition_event_round_average_best` (`competition_id`,`event`,`round`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `live_message`
--

DROP TABLE IF EXISTS `live_message`;
CREATE TABLE IF NOT EXISTS `live_message` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `event` varchar(6) NOT NULL DEFAULT '',
  `round` char(1) NOT NULL DEFAULT '',
  `content` blob NOT NULL,
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`,`user_id`),
  KEY `competition_event_round_average_best` (`competition_id`,`event`,`round`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `live_registration`
--

DROP TABLE IF EXISTS `live_registration`;
CREATE TABLE IF NOT EXISTS `live_registration` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `location_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `events` varchar(512) NOT NULL,
  `total_fee` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `comments` varchar(2048) NOT NULL DEFAULT '',
  `paid` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `date` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `live_result`
--

DROP TABLE IF EXISTS `live_result`;
CREATE TABLE IF NOT EXISTS `live_result` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `number` mediumint(6) UNSIGNED NOT NULL,
  `event` varchar(32) DEFAULT NULL,
  `round` char(1) NOT NULL DEFAULT '',
  `format` char(1) NOT NULL DEFAULT '',
  `best` int(11) NOT NULL DEFAULT '0',
  `average` int(11) NOT NULL DEFAULT '0',
  `value1` int(11) NOT NULL DEFAULT '0',
  `value2` int(11) NOT NULL DEFAULT '0',
  `value3` int(11) NOT NULL DEFAULT '0',
  `value4` int(11) NOT NULL DEFAULT '0',
  `value5` int(11) NOT NULL DEFAULT '0',
  `regional_single_record` char(3) NOT NULL DEFAULT '',
  `regional_average_record` char(3) NOT NULL DEFAULT '',
  `operator_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`,`user_id`),
  KEY `competition_event_round_average_best` (`competition_id`,`event`,`round`,`average`,`best`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `live_user`
--

DROP TABLE IF EXISTS `live_user`;
CREATE TABLE IF NOT EXISTS `live_user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `wcaid` char(10) NOT NULL DEFAULT '',
  `name` char(128) NOT NULL,
  `name_zh` char(128) NOT NULL DEFAULT '',
  `birthday` bigint(20) NOT NULL DEFAULT '0',
  `gender` tinyint(1) UNSIGNED NOT NULL,
  `country_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `province_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `city_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `wcaid` (`wcaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `login_history`
--

DROP TABLE IF EXISTS `login_history`;
CREATE TABLE IF NOT EXISTS `login_history` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '',
  `date` int(10) UNSIGNED NOT NULL,
  `from_cookie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(128) CHARACTER SET utf8mb4 DEFAULT NULL,
  `category` varchar(128) CHARACTER SET utf8mb4 DEFAULT NULL,
  `logtime` int(11) DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mail`
--

DROP TABLE IF EXISTS `mail`;
CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `to` text CHARACTER SET utf8mb4,
  `reply_to` text CHARACTER SET utf8mb4,
  `cc` text CHARACTER SET utf8mb4,
  `bcc` text CHARACTER SET utf8mb4,
  `subject` varchar(256) CHARACTER SET utf8mb4 DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `sent_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sent` (`sent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `title_zh` varchar(1024) NOT NULL,
  `content` longtext NOT NULL,
  `content_zh` longtext NOT NULL,
  `weight` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '排序权重',
  `date` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `description` longtext NOT NULL,
  `description_zh` longtext NOT NULL,
  `alias` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status_weight_date` (`status`,`weight`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `news_template`
--

DROP TABLE IF EXISTS `news_template`;
CREATE TABLE IF NOT EXISTS `news_template` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `title_zh` varchar(1024) NOT NULL,
  `content` longtext NOT NULL,
  `content_zh` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `old_competition`
--

DROP TABLE IF EXISTS `old_competition`;
CREATE TABLE IF NOT EXISTS `old_competition` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `delegate` varchar(255) NOT NULL,
  `delegate_zh` varchar(255) NOT NULL,
  `organizer` varchar(255) NOT NULL,
  `organizer_zh` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `pay`
--

DROP TABLE IF EXISTS `pay`;
CREATE TABLE IF NOT EXISTS `pay` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `channel` char(10) NOT NULL DEFAULT '',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `type_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `sub_type_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `order_no` char(32) NOT NULL,
  `order_name` char(50) NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `paid_amount` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `device_type` char(2) NOT NULL DEFAULT '',
  `pay_channel` char(4) NOT NULL DEFAULT '',
  `pay_account` varchar(64) NOT NULL DEFAULT '',
  `trade_no` varchar(64) NOT NULL DEFAULT '',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `paid_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `refund_amount` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `refund_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `type` (`type`,`type_id`),
  KEY `status` (`status`,`update_time`),
  KEY `order_id` (`order_no`),
  KEY `pay_channel` (`pay_channel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `preferred_event`
--

DROP TABLE IF EXISTS `preferred_event`;
CREATE TABLE IF NOT EXISTS `preferred_event` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `event` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE IF NOT EXISTS `region` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` char(128) NOT NULL,
  `name_zh` char(128) NOT NULL DEFAULT '',
  `pid` int(10) NOT NULL DEFAULT '0',
  `longitude` decimal(12,9) NOT NULL DEFAULT '0.000000000',
  `latitude` decimal(12,9) NOT NULL DEFAULT '0.000000000',
  `second_offset` mediumint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `registration`
--

DROP TABLE IF EXISTS `registration`;
CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `location_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `events` varchar(512) NOT NULL,
  `total_fee` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `comments` varchar(2048) NOT NULL DEFAULT '',
  `entourage_passport_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `entourage_passport_name` varchar(100) NOT NULL DEFAULT '',
  `entourage_passport_number` varchar(20) NOT NULL DEFAULT '',
  `avatar_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `avatar_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `code` varchar(64) NOT NULL DEFAULT '',
  `paid` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `date` int(10) UNSIGNED NOT NULL,
  `signed_in` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `signed_scan_code` varchar(20) NOT NULL DEFAULT '',
  `signed_date` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `has_entourage` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `entourage_name` varchar(100) DEFAULT '',
  `accept_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `cancel_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `guest_paid` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `t_shirt_size` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `staff_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `staff_statement` varchar(2048) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `competition_user` (`competition_id`,`user_id`),
  KEY `competition_id` (`competition_id`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `organizer_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `competition_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `rank` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `comments` varchar(1024) NOT NULL DEFAULT '',
  `date` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status_weight_date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `scan_auth`
--

DROP TABLE IF EXISTS `scan_auth`;
CREATE TABLE IF NOT EXISTS `scan_auth` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `competition_id` int(10) NOT NULL,
  `day` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `stage` char(10) NOT NULL DEFAULT 'main',
  `start_time` int(10) UNSIGNED NOT NULL,
  `end_time` int(10) UNSIGNED NOT NULL,
  `event` char(64) NOT NULL,
  `group` char(10) NOT NULL DEFAULT '',
  `format` char(10) NOT NULL,
  `round` char(10) NOT NULL,
  `number` int(10) UNSIGNED NOT NULL,
  `cut_off` int(10) UNSIGNED NOT NULL,
  `time_limit` int(10) UNSIGNED NOT NULL,
  `cumulative` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `competition_id` (`competition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `sess_id` varbinary(128) NOT NULL,
  `sess_data` blob NOT NULL,
  `sess_lifetime` mediumint(9) NOT NULL,
  `sess_time` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`sess_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `wcaid` char(10) NOT NULL DEFAULT '',
  `name` char(128) NOT NULL,
  `name_zh` char(128) NOT NULL DEFAULT '',
  `email` char(128) NOT NULL,
  `password` char(128) NOT NULL,
  `avatar_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '头像ID',
  `birthday` bigint(20) NOT NULL DEFAULT '0',
  `gender` tinyint(1) UNSIGNED NOT NULL,
  `mobile` char(20) NOT NULL DEFAULT '',
  `country_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `province_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `city_id` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `role` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `identity` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `reg_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `reg_ip` char(15) NOT NULL DEFAULT '',
  `status` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
  `passport_type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `passport_name` varchar(100) DEFAULT '',
  `passport_number` varchar(50) DEFAULT '',
  `show_as_delegate` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `wcaid` (`wcaid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_action`
--

DROP TABLE IF EXISTS `user_action`;
CREATE TABLE IF NOT EXISTS `user_action` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `action` char(20) NOT NULL,
  `code` char(32) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `date` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `action` (`action`,`code`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_avatar`
--

DROP TABLE IF EXISTS `user_avatar`;
CREATE TABLE IF NOT EXISTS `user_avatar` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户ID',
  `md5` char(32) NOT NULL COMMENT '图片md5',
  `extension` char(10) NOT NULL COMMENT '扩展名',
  `width` mediumint(6) UNSIGNED NOT NULL COMMENT '宽度',
  `height` mediumint(6) UNSIGNED NOT NULL COMMENT '高度',
  `add_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '上传时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_permission`
--

DROP TABLE IF EXISTS `user_permission`;
CREATE TABLE IF NOT EXISTS `user_permission` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user_schedule`
--

DROP TABLE IF EXISTS `user_schedule`;
CREATE TABLE IF NOT EXISTS `user_schedule` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `competition_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `heat_id` (`group_id`),
  KEY `competition_id` (`competition_id`),
  KEY `user_id` (`user_id`,`competition_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `wechat_user`
--

DROP TABLE IF EXISTS `wechat_user`;
CREATE TABLE IF NOT EXISTS `wechat_user` (
  `id` varchar(32) NOT NULL,
  `nickname` varchar(128) NOT NULL,
  `avatar` varchar(256) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
