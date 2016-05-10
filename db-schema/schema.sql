-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2013 at 07:27 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `job_admin`
--
-- in use(#1033 - Incorrect information in file: '.\job_portal\job_admin.frm')

-- --------------------------------------------------------

--
-- Table structure for table `job_bookmark`
--

CREATE TABLE IF NOT EXISTS `job_bookmark` (
  `bookmark_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `selected_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`bookmark_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_credit_balance`
--

CREATE TABLE IF NOT EXISTS `job_credit_balance` (
  `credit_balance_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `TRANSACTION_FOR_user_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` enum('earned','spend') NOT NULL DEFAULT 'earned',
  `balance` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`credit_balance_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_feedback`
--

CREATE TABLE IF NOT EXISTS `job_feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `owner_user_id` int(11) NOT NULL,
  `owner_feedback_rate` varchar(3) COLLATE latin1_general_ci NOT NULL,
  `owner_comment` text COLLATE latin1_general_ci NOT NULL,
  `owner_post_date` datetime NOT NULL,
  `bidder_user_id` int(11) NOT NULL,
  `bidder_feedback_rate` varchar(3) COLLATE latin1_general_ci NOT NULL,
  `bidder_comment` text COLLATE latin1_general_ci NOT NULL,
  `bidder_post_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`feedback_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_invited`
--

CREATE TABLE IF NOT EXISTS `job_invited` (
  `invited_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`invited_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_membership`
--

CREATE TABLE IF NOT EXISTS `job_membership` (
  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
  `membership` varchar(255) DEFAULT NULL,
  `subscription_interval` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_premium` tinyint(1) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `membership_cost` float(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`membership_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_message`
--

CREATE TABLE IF NOT EXISTS `job_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `SENDER_user_id` int(11) NOT NULL,
  `RECEIVER_user_id` int(11) NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `message` text CHARACTER SET utf8,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `RECEIVER_read` tinyint(1) NOT NULL DEFAULT '0',
  `parent_message_id` int(11) NOT NULL DEFAULT '0',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_payment_record`
--

CREATE TABLE IF NOT EXISTS `job_payment_record` (
  `payment_record_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` datetime DEFAULT NULL,
  `txn_id` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`payment_record_id`),
  UNIQUE KEY `payment_record_id_2` (`payment_record_id`),
  KEY `payment_record_id` (`payment_record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_portfolio`
--

CREATE TABLE IF NOT EXISTS `job_portfolio` (
  `portfolio_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `client_name` varchar(200) DEFAULT NULL,
  `portfolio_title` varchar(200) DEFAULT NULL,
  `project_url` varchar(200) DEFAULT NULL,
  `project_description` text,
  `portfolio_image` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`portfolio_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_primary_category`
--

CREATE TABLE IF NOT EXISTS `job_primary_category` (
  `primary_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) DEFAULT NULL,
  `category_description` text CHARACTER SET utf8,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`primary_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_project`
--

CREATE TABLE IF NOT EXISTS `job_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `assigned_user_id` int(11) NOT NULL DEFAULT '0',
  `project_category_id` int(11) DEFAULT NULL,
  `project_title` varchar(255) DEFAULT NULL,
  `project_description` text CHARACTER SET utf8,
  `cost` float(10,2) NOT NULL DEFAULT '0.00',
  `CurrencyCode` varchar(32) NOT NULL,
  `additional_remarks` varchar(255) NOT NULL,
  `meet_up_required` tinyint(4) NOT NULL DEFAULT '0',
  `milestone_payments` tinyint(4) NOT NULL DEFAULT '0',
  `require_portfolio` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bid_ending_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `project_status` enum('opened','frozen','hired','cancel','expired','closed','expired') NOT NULL DEFAULT 'opened',
  `archive_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_project_attachment`
--

CREATE TABLE IF NOT EXISTS `job_project_attachment` (
  `project_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`project_attachment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_project_bid`
--

CREATE TABLE IF NOT EXISTS `job_project_bid` (
  `project_bid_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `BIDDER_user_id` int(11) NOT NULL DEFAULT '0',
  `bid_amount` float(10,2) NOT NULL DEFAULT '0.00',
  `CurrencyCode` varchar(10) NOT NULL,
  `time_period` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_assigned` tinyint(1) NOT NULL DEFAULT '0',
  `accept_decline` varchar(1) NOT NULL,
  PRIMARY KEY (`project_bid_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_project_bid_attach`
--

CREATE TABLE IF NOT EXISTS `job_project_bid_attach` (
  `project_bid_attach_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `BIDDER_user_id` int(11) NOT NULL DEFAULT '0',
  `attachment` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`project_bid_attach_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_project_requirment`
--

CREATE TABLE IF NOT EXISTS `job_project_requirment` (
  `project_requirment_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `project_requirment` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`project_requirment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_temporary_project`
--

CREATE TABLE IF NOT EXISTS `job_temporary_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `assigned_user_id` int(11) NOT NULL DEFAULT '0',
  `project_category_id` int(11) DEFAULT NULL,
  `project_title` varchar(255) DEFAULT NULL,
  `project_description` text CHARACTER SET utf8,
  `cost` float(10,2) NOT NULL DEFAULT '0.00',
  `CurrencyCode` varchar(32) NOT NULL,
  `additional_remarks` varchar(255) NOT NULL,
  `meet_up_required` tinyint(4) NOT NULL DEFAULT '0',
  `milestone_payments` tinyint(4) NOT NULL DEFAULT '0',
  `require_portfolio` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bid_ending_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `project_status` enum('opened','frozen','hired','cancel','expired','closed','expired') NOT NULL DEFAULT 'opened',
  `archive_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_temporary_project_attachment`
--

CREATE TABLE IF NOT EXISTS `job_temporary_project_attachment` (
  `project_attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`project_attachment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_testimonials`
--

CREATE TABLE IF NOT EXISTS `job_testimonials` (
  `testimonials_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL DEFAULT '0',
  `client_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `testimonials` text CHARACTER SET utf8,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`testimonials_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_user`
--

CREATE TABLE IF NOT EXISTS `job_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover_image` varchar(200) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `country` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) NOT NULL,
  `primary_category_id` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `NRIC_ROC_number` varchar(255) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) DEFAULT NULL,
  `forget_password` varchar(255) DEFAULT NULL,
  `type` enum('contractor','employer') NOT NULL DEFAULT 'contractor',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_premium` tinyint(1) NOT NULL DEFAULT '0',
  `subscription_start_date` datetime DEFAULT NULL,
  `subscr_id` varchar(100) NOT NULL,
  `user_fb_id` int(100) DEFAULT NULL,
  `twitter_uid` int(100) DEFAULT NULL,
  `twitter_username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_screen_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username_u` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;
