-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2015 at 07:23 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentomato_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(10) unsigned NOT NULL,
  `ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `action` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `action_body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE IF NOT EXISTS `amenities` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `amenity_category_id` int(11) unsigned DEFAULT NULL,
  `type` enum('TINYINT','INT','ENUM') NOT NULL DEFAULT 'TINYINT',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `title`, `amenity_category_id`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Construction year', 1, 'INT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(2, 'Floors', 1, 'INT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(3, 'Energy label', 1, 'INT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(4, 'Video surveillance', 1, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(5, 'Gym', 1, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(6, 'Parking', 1, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(7, 'Garage', 1, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(8, 'Garden', 1, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(9, 'Disability ramps', 2, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(10, 'Elevator', 2, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(11, 'Bathroom', 3, 'INT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(12, 'Toilet', 3, 'INT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(13, 'Balcony', 3, 'INT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(14, 'Terrace', 3, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(15, 'Basement', 3, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(16, 'Dishwasher', 3, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(17, 'Washing machine', 3, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(18, 'Dryer', 3, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(19, 'Furnished', 3, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(20, 'Double-glaze windows', 3, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(21, 'Gas', 4, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(22, 'Water', 4, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(23, 'Electricity ', 4, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(24, 'Internet', 4, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(25, 'Reception', 5, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(26, 'Meeting room', 5, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(27, 'Kitchen', 5, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(28, 'Phone', 5, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(29, 'Lunch facilities', 5, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(30, 'Furnished', 5, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(31, 'Gym', 5, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(32, 'Parking', 5, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(33, 'Registration', 6, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(34, 'Smoking', 6, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(35, 'Events', 6, 'TINYINT', '2015-11-25 09:36:03', '2015-11-25 09:36:03', NULL),
(36, 'Pets', 6, 'TINYINT', '2015-11-24 22:00:00', '2015-11-24 22:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `amenity_categories`
--

CREATE TABLE IF NOT EXISTS `amenity_categories` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amenity_categories`
--

INSERT INTO `amenity_categories` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Building', '2015-11-25 09:28:21', '2015-11-25 09:28:21', NULL),
(2, 'Accesibillity', '2015-11-25 09:28:21', '2015-11-25 09:28:21', NULL),
(3, 'Property', '2015-11-25 09:28:21', '2015-11-25 09:28:21', NULL),
(4, 'Utilities Included', '2015-11-25 09:28:21', '2015-11-25 09:28:21', NULL),
(5, 'Facilities', '2015-11-25 09:28:21', '2015-11-25 09:28:21', NULL),
(6, 'Extras', '2015-11-25 09:28:21', '2015-11-25 09:28:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `amenity_values`
--

CREATE TABLE IF NOT EXISTS `amenity_values` (
  `id` int(10) unsigned NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `amenity_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `amenity_values`
--

INSERT INTO `amenity_values` (`id`, `value`, `amenity_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 1, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(2, NULL, 2, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(3, NULL, 3, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(4, '0', 4, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(5, '0', 5, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(6, '0', 7, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(7, '0', 8, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(8, '0', 9, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(9, '0', 10, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(10, NULL, 11, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(11, NULL, 12, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(12, NULL, 13, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(13, '0', 14, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(14, '0', 15, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(15, '0', 16, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(16, '0', 17, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(17, '0', 18, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(18, '0', 19, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(19, '0', 20, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(20, '0', 21, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(21, '0', 22, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(22, '0', 23, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(23, '0', 24, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(24, '0', 25, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(25, '0', 26, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(26, '0', 27, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(27, '0', 28, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(28, '0', 29, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(29, '0', 30, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(30, '0', 31, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(31, '0', 32, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(32, '0', 33, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(33, '0', 34, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(34, '0', 35, '2015-11-25 09:50:39', '2015-11-25 09:50:39', NULL),
(35, '0', 36, '2015-11-24 22:00:00', '2015-11-24 22:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `name`, `domain`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'ECE', 'ece.rentomato.com', '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(2, NULL, 'Hospa', 'hospa.rentomato.com', '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(3, NULL, 'Rotterdams', 'rotterdams.rentomato.com', '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(4, NULL, 'SU', 'su.rentomato.com', '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `title`, `status`) VALUES
(1, 'Netherlands', 1),
(2, 'Germany', 1),
(3, 'United Kingdom', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `symbol` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `title`, `symbol`, `html`, `slug`, `weight`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'eur', '€', '&euro;', 'eur', 1, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(2, 'gbp', '£', '&pound;', 'gbp', 2, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(3, 'usd', '$', '$', 'usd', 3, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(10) unsigned NOT NULL,
  `file` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `file_size` int(10) unsigned DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `privacy` enum('Private','Password','Public','Friends') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Private',
  `property_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `folder_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `file`, `file_size`, `description`, `privacy`, `property_id`, `user_id`, `folder_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 09:57:07', '2015-11-18 09:57:07', NULL),
(2, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 10:07:23', '2015-11-18 10:07:23', NULL),
(3, '/uploads/properties/0/docs/National Parks (58).jpg', 3140390, 'My best filex', 'Private', NULL, 8, 1, 1, '2015-11-18 10:08:28', '2015-11-27 14:49:24', NULL),
(4, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 10:46:12', '2015-11-18 10:46:12', NULL),
(5, '', NULL, 'xxxx', 'Private', 117, 8, 1, 1, '2015-11-18 12:54:57', '2015-11-18 12:55:01', NULL),
(6, '', NULL, 'xxxu', 'Public', 117, 8, 1, 1, '2015-11-18 12:55:17', '2015-11-18 12:55:26', NULL),
(7, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 13:19:02', '2015-11-18 13:19:02', NULL),
(8, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:19:53', '2015-11-26 21:44:59', '2015-11-26 21:44:59'),
(9, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:28:11', '2015-11-26 21:45:15', '2015-11-26 21:45:15'),
(10, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', NULL, 8, 1, 1, '2015-11-18 13:28:38', '2015-11-26 21:47:36', '2015-11-26 21:47:36'),
(11, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:29:07', '2015-11-26 21:40:59', '2015-11-26 21:40:59'),
(12, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:29:41', '2015-11-26 21:45:26', '2015-11-26 21:45:26'),
(13, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:30:44', '2015-11-27 07:15:51', '2015-11-27 07:15:51'),
(14, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:31:14', '2015-11-27 07:06:29', '2015-11-27 07:06:29'),
(15, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:31:34', '2015-11-18 14:40:01', '2015-11-18 14:40:01'),
(16, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:33:40', '2015-11-18 14:36:11', '2015-11-18 14:36:11'),
(17, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:36:36', '2015-11-18 14:36:56', '2015-11-18 14:36:56'),
(18, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:40:49', '2015-11-27 07:16:18', '2015-11-27 07:16:18'),
(19, '/uploads/docs/129836253893c86.JPG', 42174, 'This is a private document', 'Private', NULL, 8, 1, 1, '2015-11-18 13:41:18', '2015-11-27 07:17:16', NULL),
(20, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:41:48', '2015-11-27 14:55:16', '2015-11-27 14:55:16'),
(21, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:43:04', '2015-11-18 13:43:08', NULL),
(22, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:44:37', '2015-11-18 13:44:43', NULL),
(23, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:45:21', '2015-11-18 13:45:25', NULL),
(24, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:47:48', '2015-11-18 13:47:54', NULL),
(25, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:49:35', '2015-11-18 13:49:43', NULL),
(26, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:50:13', '2015-11-18 13:50:16', NULL),
(27, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:51:06', '2015-11-18 13:51:14', NULL),
(28, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 13:52:40', '2015-11-18 13:52:40', NULL),
(29, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:53:56', '2015-11-18 13:54:00', NULL),
(30, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 13:55:18', '2015-11-18 13:55:18', NULL),
(31, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 13:56:29', '2015-11-18 13:56:29', NULL),
(32, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 13:57:55', '2015-11-18 13:57:55', NULL),
(33, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 13:58:32', '2015-11-18 13:58:32', NULL),
(34, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 13:58:57', '2015-11-18 13:58:57', NULL),
(35, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 13:59:46', '2015-11-18 13:59:48', NULL),
(36, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:00:44', '2015-11-18 14:00:48', NULL),
(37, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:01:05', '2015-11-18 14:01:07', NULL),
(38, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:01:30', '2015-11-18 14:01:33', NULL),
(39, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:04:44', '2015-11-18 14:04:46', NULL),
(40, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 14:07:04', '2015-11-18 14:07:04', NULL),
(41, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 14:26:21', '2015-11-18 14:26:21', NULL),
(42, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 14:26:44', '2015-11-18 14:26:44', NULL),
(43, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-18 14:27:02', '2015-11-18 14:27:02', NULL),
(44, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:27:26', '2015-11-18 14:27:31', NULL),
(45, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:28:16', '2015-11-18 14:28:20', NULL),
(46, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:29:32', '2015-11-18 14:29:38', NULL),
(47, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:30:11', '2015-11-18 14:30:18', NULL),
(48, '/uploads/docs/129836253893c86.JPG', 42174, 'asdasdas', 'Private', 117, 8, 1, 1, '2015-11-18 14:31:25', '2015-11-18 14:45:04', '2015-11-18 14:45:04'),
(49, '/uploads/docs/129836253893c86.JPG', 42174, NULL, 'Private', 117, 8, 1, 0, '2015-11-18 14:31:38', '2015-11-18 14:31:41', NULL),
(50, '/uploads/properties/117/docs/1298362538be920.JPG', 90920, 'ui', 'Private', 117, 8, 1, 1, '2015-11-18 14:32:17', '2015-11-27 07:15:44', '2015-11-27 07:15:44'),
(51, '/uploads/properties/2/docs/1298362580a109b.JPG', 40314, 'terter', 'Private', 2, 8, 1, 1, '2015-11-20 10:18:01', '2015-11-20 10:18:06', NULL),
(52, '/uploads/properties/118/docs/129836253893c86.JPG', 42174, 'Mu', 'Private', 118, 8, 1, 1, '2015-11-23 08:17:09', '2015-11-27 07:14:14', '2015-11-27 07:14:14'),
(53, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-26 10:21:19', '2015-11-26 10:21:19', NULL),
(54, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-26 10:21:28', '2015-11-26 10:21:28', NULL),
(55, '', NULL, NULL, 'Private', NULL, 8, 1, 0, '2015-11-27 14:57:32', '2015-11-27 14:57:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `document_shares`
--

CREATE TABLE IF NOT EXISTS `document_shares` (
  `id` int(11) NOT NULL,
  `document_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `document_shares`
--

INSERT INTO `document_shares` (`id`, `document_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 3, 9, '0000-00-00 00:00:00', '2015-11-26 21:20:35', '2015-11-26 21:20:35'),
(4, 3, 12, '0000-00-00 00:00:00', '2015-11-26 21:20:35', '2015-11-26 21:20:35'),
(5, 3, 22, '0000-00-00 00:00:00', '2015-11-26 21:20:35', '2015-11-26 21:20:35'),
(6, 3, 9, '2015-11-26 21:20:44', '2015-11-26 21:38:39', '2015-11-26 21:38:39'),
(7, 3, 12, '2015-11-26 21:20:44', '2015-11-26 21:38:39', '2015-11-26 21:38:39'),
(8, 3, 22, '2015-11-26 21:20:44', '2015-11-26 21:38:39', '2015-11-26 21:38:39'),
(9, 3, 9, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(10, 3, 12, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(11, 3, 20, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(12, 3, 21, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(13, 3, 22, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(14, 3, 23, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(15, 3, 24, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(16, 3, 25, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(17, 3, 26, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(18, 3, 27, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(19, 3, 28, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(20, 3, 29, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(21, 3, 30, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(22, 3, 31, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(23, 3, 32, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(24, 3, 33, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(25, 3, 34, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(26, 3, 35, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(27, 3, 36, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(28, 3, 37, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(29, 3, 38, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(30, 3, 39, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(31, 3, 40, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(32, 3, 41, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(33, 3, 42, '2015-11-26 21:38:56', '2015-11-26 21:39:21', '2015-11-26 21:39:21'),
(34, 3, 9, '2015-11-26 21:39:34', '2015-11-26 21:40:43', '2015-11-26 21:40:43'),
(35, 3, 9, '2015-11-26 21:40:43', '2015-11-27 14:48:42', '2015-11-27 14:48:42'),
(36, 10, 9, '2015-11-26 21:46:59', '2015-11-26 21:47:36', '2015-11-26 21:47:36'),
(37, 19, 20, '2015-11-27 07:17:16', '2015-11-27 07:17:16', NULL),
(38, 3, 9, '2015-11-27 14:48:42', '2015-11-27 14:48:51', '2015-11-27 14:48:51'),
(39, 3, 12, '2015-11-27 14:48:42', '2015-11-27 14:48:51', '2015-11-27 14:48:51'),
(40, 3, 22, '2015-11-27 14:48:42', '2015-11-27 14:48:51', '2015-11-27 14:48:51'),
(41, 3, 9, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(42, 3, 12, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(43, 3, 20, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(44, 3, 21, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(45, 3, 22, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(46, 3, 23, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(47, 3, 24, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(48, 3, 25, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(49, 3, 26, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(50, 3, 27, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(51, 3, 28, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(52, 3, 29, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(53, 3, 30, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(54, 3, 31, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(55, 3, 32, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(56, 3, 33, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(57, 3, 34, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(58, 3, 35, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(59, 3, 36, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(60, 3, 37, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(61, 3, 38, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(62, 3, 39, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(63, 3, 40, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(64, 3, 41, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(65, 3, 42, '2015-11-27 14:48:52', '2015-11-27 14:49:24', '2015-11-27 14:49:24'),
(66, 3, 9, '2015-11-27 14:49:24', '2015-11-27 14:49:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(10) unsigned NOT NULL,
  `email_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `language_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE IF NOT EXISTS `help` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `language_id` int(10) unsigned NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `i18n`
--

CREATE TABLE IF NOT EXISTS `i18n` (
  `id` int(10) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `language_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `landlord_id` int(10) unsigned DEFAULT NULL,
  `tenant_id` int(10) unsigned DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `amount` double(8,2) NOT NULL,
  `discount` int(11) NOT NULL,
  `currency` tinyint(4) NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `due_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `property_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL,
  `position` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `user_id_edited` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `position`, `name`, `lang_code`, `status`, `icon`, `user_id`, `user_id_edited`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'English', 'en', 1, 'gb.png', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(2, NULL, 'Nederlands', 'nl', 1, 'nl.png', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `roles` varchar(225) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `label`, `url`, `icon`, `status`, `roles`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dashboard', '#/dashboard', 'icon-speedometer', 1, '["administrator","tenant","landlord","manager"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(2, 'Properties', '#/properties/', 'icon-home', 1, '["administrator","tenant","landlord","manager"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(3, 'Tenants', '#/tenants/', 'icon-user', 1, '["administrator","tenant","landlord","manager"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(4, 'Documents', '#/documents', 'icon-doc', 1, '["administrator","tenant","landlord","manager"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(5, 'Finances', '#/finances', 'icon-credit-card', 1, '["administrator","tenant","landlord","manager"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(6, 'Messages', '#/messages', 'icon-envelope', 1, '["administrator","tenant","landlord","manager"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(7, 'Settings', '#/settings', 'icon-settings', 1, '["administrator","tenant","landlord","manager"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(8, 'Translations', '#/translations', 'icon-book-open', 1, '["administrator"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(9, 'Emails', '#/emails', 'icon-envelope-open', 1, '["administrator"]', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL,
  `thread` int(10) unsigned NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `sender_id` int(10) unsigned NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `thread`, `subject`, `text`, `sender_id`, `priority`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'This is a message', 'A sample message for you!', 2, 0, 'message', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(2, 1, 'This is a new subject for within the same thread', 'This is another text', 3, 1, 'message', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(3, 2, 'You have won the jackpot!', 'You earned 5 billion nothings!', 1, -1, 'messages', '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `message_tag`
--

CREATE TABLE IF NOT EXISTS `message_tag` (
  `message_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_user`
--

CREATE TABLE IF NOT EXISTS `message_user` (
  `message_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `starred` tinyint(1) NOT NULL DEFAULT '0',
  `read_date` timestamp NULL DEFAULT NULL,
  `postponed_date` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `message_user`
--

INSERT INTO `message_user` (`message_id`, `user_id`, `read`, `starred`, `read_date`, `postponed_date`, `deleted_at`) VALUES
(1, 1, 0, 1, NULL, NULL, NULL),
(1, 3, 0, 0, NULL, NULL, NULL),
(2, 1, 0, 0, NULL, NULL, NULL),
(2, 2, 0, 0, NULL, NULL, NULL),
(3, 1, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2014_10_18_195027_create_languages_table', 1),
('2014_10_18_225928_create_photo_albums_table', 1),
('2014_10_18_231619_create_photos_table', 1),
('2015_02_07_172606_create_roles_table', 1),
('2015_02_07_172633_create_role_user_table', 1),
('2015_02_07_172649_create_permissions_table', 1),
('2015_02_07_172657_create_permission_role_table', 1),
('2015_02_17_152439_create_permission_user_table', 1),
('2015_08_24_074754_create_documents_table', 1),
('2015_08_24_074849_create_folders_table', 1),
('2015_08_24_074915_create_invoices_table', 1),
('2015_08_24_074948_create_activity_table', 1),
('2015_08_24_075003_create_payments_table', 1),
('2015_08_24_075034_create_profiles_table', 1),
('2015_08_24_075040_create_properties_table', 1),
('2015_08_24_075050_create_property_tenants', 1),
('2015_08_24_075057_create_roles', 1),
('2015_08_24_094008_create_clients_table', 1),
('2015_08_24_195234_alter_invoices_table', 1),
('2015_09_11_130611_create_table_menu', 1),
('2015_09_11_135318_create_table_i18n', 1),
('2015_09_14_220203_create_jobs_table', 1),
('2015_09_15_161745_create_property_types_table', 1),
('2015_09_15_162509_add_property_type_to_properties', 1),
('2015_09_15_171628_create_countries_table', 1),
('2015_09_15_171643_add_country_to_properties', 1),
('2015_09_17_085243_create_property_photos_table', 1),
('2015_09_25_234549_create_messaging_tables', 1),
('2015_09_26_205420_create_property_financials_table', 1),
('2015_09_26_205513_create_property_monthly_expenses_table', 1),
('2015_10_02_204623_alter_property_tenant', 1),
('2015_10_03_205325_alter_properties_add_latlng', 1),
('2015_10_04_203153_create_tags_tables', 1),
('2015_10_05_103024_rent_null_property_financial', 1),
('2015_10_05_105441_add_media_share_property', 1),
('2015_10_12_051652_create_help_table', 1),
('2015_10_12_053856_create_notifications_table', 1),
('2015_10_12_151244_create_currency_table', 1),
('2015_10_12_163331_alter_properties_financial_table', 1),
('2015_10_12_164112_alter_property_monthly_expenses_table', 1),
('2015_10_12_170416_alter_countries_table', 1),
('2015_10_13_155150_alter_property_table', 1),
('2015_10_14_053706_alter_users_table_add_login_flag', 1),
('2015_10_14_134538_alter_profile_table', 1),
('2015_10_14_152353_alter_property_financial_dropcurrency_table', 1),
('2015_10_14_163628_alter_currencies_table', 1),
('2015_10_20_230949_create_emails_table', 1),
('2015_10_21_133511_add_transaction_categories_table', 1),
('2015_10_21_133530_add_transaction_types_table', 1),
('2015_10_21_133608_alter_property_tenants_table', 1),
('2015_10_22_094051_alter_users_table_add_demo_flag', 1),
('2015_10_22_132104_alter_profiles_table', 1),
('2015_10_23_083538_add_transaction_recurrings_table', 1),
('2015_10_26_123424_add_property_user_transactions_table', 1),
('2015_10_28_132454_alter_transaction_categories_table', 1),
('2015_10_29_130650_create_property_transactions_table', 1),
('2015_10_29_130906_alter_property_user_transactions_table', 1),
('2015_11_02_211228_alter_property_photos_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `creator_id` int(11) NOT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `action`, `creator_id`, `receiver_id`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 'delete-Document', 8, 0, 'Document /uploads/docs/129836253893c86.JPG was deleted', '2015-11-18 14:36:11', '2015-11-18 14:36:11', NULL),
(2, 0, 'delete-Document', 8, 0, 'Document /uploads/docs/129836253893c86.JPG was deleted', '2015-11-18 14:36:56', '2015-11-18 14:36:56', NULL),
(3, 0, 'delete-Document', 8, 0, 'Document /uploads/docs/129836253893c86.JPG was deleted', '2015-11-26 21:40:59', '2015-11-26 21:40:59', NULL),
(4, 0, 'delete-Document', 8, 0, 'Document /uploads/docs/129836253893c86.JPG was deleted', '2015-11-26 21:44:59', '2015-11-26 21:44:59', NULL),
(5, 0, 'delete-Document', 8, 0, 'Document /uploads/docs/129836253893c86.JPG was deleted', '2015-11-26 21:45:15', '2015-11-26 21:45:15', NULL),
(6, 0, 'delete-Document', 8, 0, 'Document /uploads/docs/129836253893c86.JPG was deleted', '2015-11-26 21:45:26', '2015-11-26 21:45:26', NULL),
(7, 0, 'delete-Document', 8, 0, 'Document /uploads/docs/129836253893c86.JPG was deleted', '2015-11-26 21:47:36', '2015-11-26 21:47:36', NULL),
(8, 0, 'delete-Document', 8, 0, 'Document /uploads/docs/129836253893c86.JPG was deleted', '2015-11-27 07:06:29', '2015-11-27 07:06:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(10) unsigned NOT NULL,
  `invoice_id` int(10) unsigned DEFAULT NULL,
  `landlord_id` int(10) unsigned NOT NULL,
  `tenant_id` int(10) unsigned NOT NULL,
  `amount` double(8,2) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `merchant_reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `psp_reference` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_auth_result` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL,
  `inherit_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `inherit_id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, NULL, 'menu', '{"create":true,"view":true,"update":true,"delete":true,"view.phone":true}', 'manage user permissions', '2015-11-02 21:33:35', '2015-11-02 21:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2015-11-02 21:33:35', '2015-11-02 21:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE IF NOT EXISTS `permission_user` (
  `id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(10) unsigned NOT NULL,
  `language_id` int(10) unsigned NOT NULL,
  `position` int(11) DEFAULT NULL,
  `slider` tinyint(1) DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `photo_album_id` int(10) unsigned DEFAULT NULL,
  `album_cover` tinyint(1) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `user_id_edited` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photo_albums`
--

CREATE TABLE IF NOT EXISTS `photo_albums` (
  `id` int(10) unsigned NOT NULL,
  `language_id` int(10) unsigned NOT NULL,
  `position` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `folder_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `user_id_edited` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(10) unsigned NOT NULL,
  `phone` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `notifications` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `currency_id` int(10) unsigned DEFAULT '1',
  `vat` smallint(6) DEFAULT NULL,
  `swift` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iban` varchar(34) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `phone`, `address`, `city`, `country`, `website`, `bio`, `avatar`, `visibility`, `notifications`, `user_id`, `currency_id`, `vat`, `swift`, `iban`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 8, 1, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(10) unsigned NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `property_type_id` int(10) unsigned DEFAULT NULL,
  `plan` enum('free','pro') COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) unsigned DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street_no` int(11) NOT NULL,
  `street` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `post_code` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `lng` double(9,6) NOT NULL,
  `lat` double(9,6) NOT NULL,
  `rental_price` double(8,2) NOT NULL,
  `deposit` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned DEFAULT NULL,
  `internal_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `media` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `parent_id`, `title`, `unit`, `property_type_id`, `plan`, `country_id`, `slug`, `address`, `street_no`, `street`, `city`, `state`, `post_code`, `country`, `lng`, `lat`, `rental_price`, `deposit`, `status`, `user_id`, `internal_id`, `media`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Apartment Rooseveltlaan in Amsterdam', NULL, 1, 'free', 1, 'apartment-rooseveltlaan-in-amsterdam', '1078 NH Amsterdam (Noord-Holland)', 0, 'Rooseveltlaan', 'Amsterdam', 'Noord-Holland', '1078 NH', '', 0.000000, 0.000000, 2100.00, 127, 1, 1, NULL, NULL, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(2, NULL, 'Apartment Tweede Helmersstraat 76 in Amsterdam ', NULL, 2, 'free', 1, 'apartment-tweede-helmersstraat-76-in-amsterdam', '1054 CM Amsterdam (Noord-Holland)', 0, 'Tweede Helmersstraat', 'Amsterdam', 'Noord-Holland', '1054 CM', '', 0.000000, 0.000000, 3500.00, 127, 1, 8, NULL, NULL, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL),
(3, NULL, '', NULL, NULL, 'free', NULL, NULL, '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 21:56:19', '2015-11-02 21:56:19', NULL),
(4, NULL, '', NULL, NULL, 'free', NULL, '-1', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 21:58:01', '2015-11-02 21:58:01', NULL),
(5, NULL, '', NULL, NULL, 'free', NULL, '-2', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 21:58:38', '2015-11-02 21:58:38', NULL),
(6, NULL, '', NULL, NULL, 'free', NULL, '-3', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 21:58:45', '2015-11-02 21:58:45', NULL),
(7, NULL, '', NULL, NULL, 'free', NULL, '-4', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 21:59:56', '2015-11-02 21:59:56', NULL),
(8, NULL, '', NULL, NULL, 'free', NULL, '-5', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:02:01', '2015-11-02 22:02:01', NULL),
(9, NULL, '', NULL, NULL, 'free', NULL, '-6', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:03:06', '2015-11-02 22:03:06', NULL),
(10, NULL, '', NULL, NULL, 'free', NULL, '-7', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:04:08', '2015-11-02 22:04:08', NULL),
(11, NULL, '', NULL, NULL, 'free', NULL, '-8', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:06:30', '2015-11-02 22:06:30', NULL),
(12, NULL, '', NULL, NULL, 'free', NULL, '-9', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:07:30', '2015-11-02 22:07:30', NULL),
(13, NULL, '', NULL, NULL, 'free', NULL, '-10', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:08:32', '2015-11-02 22:08:32', NULL),
(14, NULL, '', NULL, NULL, 'free', NULL, '-11', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:09:50', '2015-11-02 22:09:50', NULL),
(15, NULL, '', NULL, NULL, 'free', NULL, '-12', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:11:01', '2015-11-02 22:11:01', NULL),
(16, NULL, '', NULL, NULL, 'free', NULL, '-13', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:12:04', '2015-11-02 22:12:04', NULL),
(17, NULL, '', NULL, NULL, 'free', NULL, '-14', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-02 22:12:30', '2015-11-02 22:12:30', NULL),
(18, NULL, '', NULL, NULL, 'free', NULL, '-15', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:03:17', '2015-11-03 07:03:17', NULL),
(19, NULL, '', NULL, NULL, 'free', NULL, '-16', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:04:27', '2015-11-03 07:04:27', NULL),
(20, NULL, '', NULL, NULL, 'free', NULL, '-17', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:04:56', '2015-11-03 07:04:56', NULL),
(21, NULL, '', NULL, NULL, 'free', NULL, '-18', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:05:16', '2015-11-03 07:05:16', NULL),
(22, NULL, '', NULL, NULL, 'free', NULL, '-19', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:07:59', '2015-11-03 07:07:59', NULL),
(23, NULL, '', NULL, NULL, 'free', NULL, '-20', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:09:10', '2015-11-03 07:09:10', NULL),
(24, NULL, '', NULL, NULL, 'free', NULL, '-21', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:10:55', '2015-11-03 07:10:55', NULL),
(25, NULL, '', NULL, NULL, 'free', NULL, '-22', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:11:59', '2015-11-03 07:11:59', NULL),
(26, NULL, '', NULL, NULL, 'free', NULL, '-23', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:13:17', '2015-11-03 07:13:17', NULL),
(27, NULL, '', NULL, NULL, 'free', NULL, '-24', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:13:39', '2015-11-03 07:13:39', NULL),
(28, NULL, '', NULL, NULL, 'free', NULL, '-25', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:14:10', '2015-11-03 07:14:10', NULL),
(29, NULL, '', NULL, NULL, 'free', NULL, '-26', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:14:40', '2015-11-03 07:14:40', NULL),
(30, NULL, '', NULL, NULL, 'free', NULL, '-27', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:14:50', '2015-11-03 07:14:50', NULL),
(31, NULL, '', NULL, NULL, 'free', NULL, '-28', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:16:01', '2015-11-03 07:16:01', NULL),
(32, NULL, '', NULL, NULL, 'free', NULL, '-29', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:16:22', '2015-11-03 07:16:22', NULL),
(33, NULL, '', NULL, NULL, 'free', NULL, '-30', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:17:17', '2015-11-03 07:17:17', NULL),
(34, NULL, '', NULL, NULL, 'free', NULL, '-31', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:17:51', '2015-11-03 07:17:51', NULL),
(35, NULL, '', NULL, NULL, 'free', NULL, '-32', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:18:17', '2015-11-03 07:18:17', NULL),
(36, NULL, '', NULL, NULL, 'free', NULL, '-33', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:18:55', '2015-11-03 07:18:55', NULL),
(37, NULL, '', NULL, NULL, 'free', NULL, '-34', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:19:12', '2015-11-03 07:19:12', NULL),
(38, NULL, '', NULL, NULL, 'free', NULL, '-35', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:19:26', '2015-11-03 07:19:26', NULL),
(39, NULL, '', NULL, NULL, 'free', NULL, '-36', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:20:03', '2015-11-03 07:20:03', NULL),
(40, NULL, '', NULL, NULL, 'free', NULL, '-37', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:20:31', '2015-11-03 07:20:31', NULL),
(41, NULL, '', NULL, NULL, 'free', NULL, '-38', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:21:39', '2015-11-03 07:21:39', NULL),
(42, NULL, '', NULL, NULL, 'free', NULL, '-39', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:22:01', '2015-11-03 07:22:01', NULL),
(43, NULL, '', NULL, NULL, 'free', NULL, '-40', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:22:20', '2015-11-03 07:22:20', NULL),
(44, NULL, '', NULL, NULL, 'free', NULL, '-41', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:27:39', '2015-11-03 07:27:39', NULL),
(45, NULL, '', NULL, NULL, 'free', NULL, '-42', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:28:37', '2015-11-03 07:28:37', NULL),
(46, NULL, 'fsdfsd', NULL, NULL, 'free', 3, 'fsdfsd', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:31:06', '2015-11-03 07:31:36', NULL),
(47, 46, 'dasdas', NULL, NULL, 'free', NULL, 'dasdas', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, NULL, NULL, NULL, '2015-11-03 07:35:06', '2015-11-03 07:35:06', NULL),
(48, NULL, '', NULL, NULL, 'free', NULL, '-43', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:45:29', '2015-11-03 07:45:29', NULL),
(49, NULL, '', NULL, NULL, 'free', NULL, '-44', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:45:59', '2015-11-03 07:45:59', NULL),
(50, NULL, '', NULL, NULL, 'free', NULL, '-45', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:47:29', '2015-11-03 07:47:29', NULL),
(51, NULL, '', NULL, NULL, 'free', NULL, '-46', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:48:41', '2015-11-03 07:48:41', NULL),
(52, NULL, '', NULL, NULL, 'free', NULL, '-47', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:50:42', '2015-11-03 07:50:42', NULL),
(53, NULL, '', NULL, NULL, 'free', NULL, '-48', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:51:12', '2015-11-03 07:51:12', NULL),
(54, NULL, '', NULL, NULL, 'free', NULL, '-49', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:53:43', '2015-11-03 07:53:43', NULL),
(55, NULL, '', NULL, NULL, 'free', NULL, '-50', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:57:26', '2015-11-03 07:57:26', NULL),
(56, NULL, '', NULL, NULL, 'free', NULL, '-51', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 07:57:51', '2015-11-03 07:57:51', NULL),
(57, NULL, '', NULL, NULL, 'free', NULL, '-52', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:00:32', '2015-11-03 08:00:32', NULL),
(58, NULL, '', NULL, NULL, 'free', NULL, '-53', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:01:29', '2015-11-03 08:01:29', NULL),
(59, NULL, '', NULL, NULL, 'free', NULL, '-54', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:12:17', '2015-11-03 08:12:17', NULL),
(60, NULL, '', NULL, NULL, 'free', NULL, '-55', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:12:42', '2015-11-03 08:12:42', NULL),
(61, NULL, '', NULL, NULL, 'free', NULL, '-56', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:13:17', '2015-11-03 08:13:17', NULL),
(62, NULL, '', NULL, NULL, 'free', NULL, '-57', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:26:22', '2015-11-03 08:26:22', NULL),
(63, NULL, '', NULL, NULL, 'free', NULL, '-58', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:27:19', '2015-11-03 08:27:19', NULL),
(64, NULL, '', NULL, NULL, 'free', NULL, '-59', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:28:14', '2015-11-03 08:28:14', NULL),
(65, NULL, '', NULL, NULL, 'free', NULL, '-60', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:28:43', '2015-11-03 08:28:43', NULL),
(66, NULL, '', NULL, NULL, 'free', NULL, '-61', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:29:23', '2015-11-03 08:29:23', NULL),
(67, NULL, '', NULL, NULL, 'free', NULL, '-62', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:31:13', '2015-11-03 08:31:13', NULL),
(68, NULL, '', NULL, NULL, 'free', NULL, '-63', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:31:56', '2015-11-03 08:31:56', NULL),
(69, NULL, '', NULL, NULL, 'free', NULL, '-64', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:33:26', '2015-11-03 08:33:26', NULL),
(70, NULL, '', NULL, NULL, 'free', NULL, '-65', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:34:01', '2015-11-03 08:34:01', NULL),
(71, NULL, '', NULL, NULL, 'free', NULL, '-66', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:34:28', '2015-11-03 08:34:28', NULL),
(72, NULL, '', NULL, NULL, 'free', NULL, '-67', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:34:49', '2015-11-03 08:34:49', NULL),
(73, NULL, '', NULL, NULL, 'free', NULL, '-68', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:36:48', '2015-11-03 08:36:48', NULL),
(74, NULL, '', NULL, NULL, 'free', NULL, '-69', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:37:17', '2015-11-03 08:37:17', NULL),
(75, NULL, '', NULL, NULL, 'free', NULL, '-70', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:37:48', '2015-11-03 08:37:48', NULL),
(76, NULL, '', NULL, NULL, 'free', NULL, '-71', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:38:40', '2015-11-03 08:38:40', NULL),
(77, NULL, '', NULL, NULL, 'free', NULL, '-72', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:39:09', '2015-11-03 08:39:09', NULL),
(78, NULL, '', NULL, NULL, 'free', NULL, '-73', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:39:32', '2015-11-03 08:39:32', NULL),
(79, NULL, '', NULL, NULL, 'free', NULL, '-74', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:43:20', '2015-11-03 08:43:20', NULL),
(80, NULL, '', NULL, NULL, 'free', NULL, '-75', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:44:02', '2015-11-03 08:44:02', NULL),
(81, NULL, '', NULL, NULL, 'free', NULL, '-76', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:44:45', '2015-11-03 08:44:45', NULL),
(82, NULL, '', NULL, NULL, 'free', NULL, '-77', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:45:24', '2015-11-03 08:45:24', NULL),
(83, NULL, '', NULL, NULL, 'free', NULL, '-78', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:45:54', '2015-11-03 08:45:54', NULL),
(84, NULL, '', NULL, NULL, 'free', NULL, '-79', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:51:48', '2015-11-03 08:51:48', NULL),
(85, NULL, '', NULL, NULL, 'free', NULL, '-80', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:56:32', '2015-11-03 08:56:32', NULL),
(86, NULL, '', NULL, NULL, 'free', NULL, '-81', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:57:18', '2015-11-03 08:57:18', NULL),
(87, NULL, '', NULL, NULL, 'free', NULL, '-82', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:58:23', '2015-11-03 08:58:23', NULL),
(88, NULL, '', NULL, NULL, 'free', NULL, '-83', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 08:59:24', '2015-11-03 08:59:24', NULL),
(89, NULL, 'fsdfsdf', NULL, 1, 'free', 3, 'fsdfsdf', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-03 09:01:57', '2015-11-25 21:35:38', '2015-11-25 21:35:38'),
(90, NULL, 'fsdfsd', NULL, 1, 'free', 3, 'fsdfsd-1', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-03 09:05:42', '2015-11-25 21:31:11', '2015-11-25 21:31:11'),
(91, 90, 'dasdas', NULL, NULL, 'free', NULL, 'dasdas-1', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, NULL, NULL, NULL, '2015-11-03 09:06:00', '2015-11-03 09:06:00', NULL),
(92, NULL, 'asdasda', NULL, 1, 'free', 3, 'asdasda', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-03 09:09:31', '2015-11-25 21:38:00', '2015-11-25 21:38:00'),
(93, NULL, 'fsdfsdfs', NULL, 1, 'free', 3, 'fsdfsdfs', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-03 09:10:15', '2015-11-25 21:36:05', '2015-11-25 21:36:05'),
(94, 93, 'bbbbbbb', NULL, NULL, 'free', NULL, 'bbbbbbb', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, NULL, NULL, NULL, '2015-11-03 09:11:39', '2015-11-03 09:11:39', NULL),
(95, NULL, 'dasdasdas', NULL, 1, 'free', 3, 'dasdasdas', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-03 09:13:08', '2015-11-25 21:37:11', '2015-11-25 21:37:11'),
(96, 95, 'bbbbbb', NULL, NULL, 'free', NULL, 'bbbbbb', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, NULL, NULL, NULL, '2015-11-03 09:13:23', '2015-11-03 09:13:23', NULL),
(97, NULL, '', NULL, NULL, 'free', NULL, '-84', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 12:27:13', '2015-11-03 12:27:13', NULL),
(98, NULL, '', NULL, NULL, 'free', NULL, '-85', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 13:41:58', '2015-11-03 13:41:58', NULL),
(99, NULL, '', NULL, NULL, 'free', NULL, '-86', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-03 13:48:05', '2015-11-03 13:48:05', NULL),
(100, NULL, '', NULL, NULL, 'free', NULL, '-87', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:37:15', '2015-11-04 09:37:15', NULL),
(101, NULL, '', NULL, NULL, 'free', NULL, '-88', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:39:58', '2015-11-04 09:39:58', NULL),
(102, NULL, '', NULL, NULL, 'free', NULL, '-89', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:40:20', '2015-11-04 09:40:20', NULL),
(103, NULL, '', NULL, NULL, 'free', NULL, '-90', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:40:35', '2015-11-04 09:40:35', NULL),
(104, NULL, '', NULL, NULL, 'free', NULL, '-91', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:41:02', '2015-11-04 09:41:02', NULL),
(105, NULL, '', NULL, NULL, 'free', NULL, '-92', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:42:49', '2015-11-04 09:42:49', NULL),
(106, NULL, '', NULL, NULL, 'free', NULL, '-93', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:54:44', '2015-11-04 09:54:44', NULL),
(107, NULL, '', NULL, NULL, 'free', NULL, '-94', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:56:28', '2015-11-04 09:56:28', NULL),
(108, NULL, '', NULL, NULL, 'free', NULL, '-95', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 09:59:53', '2015-11-04 09:59:53', NULL),
(109, NULL, '', NULL, NULL, 'free', NULL, '-96', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:01:11', '2015-11-04 10:01:11', NULL),
(110, NULL, 'fsdfsd', NULL, 2, 'free', 3, 'fsdfsd-2', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-04 10:04:04', '2015-11-25 21:36:42', '2015-11-25 21:36:42'),
(111, 110, 'fsdfsd', NULL, NULL, 'free', NULL, 'fsdfsd-3', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, NULL, NULL, NULL, '2015-11-04 10:04:48', '2015-11-04 10:04:48', NULL),
(112, NULL, '', NULL, NULL, 'free', NULL, '-97', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:07:10', '2015-11-04 10:07:10', NULL),
(113, NULL, '', NULL, NULL, 'free', NULL, '-98', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:09:51', '2015-11-04 10:09:51', NULL),
(114, NULL, '', NULL, NULL, 'free', NULL, '-99', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:10:39', '2015-11-04 10:10:39', NULL),
(115, NULL, '', NULL, NULL, 'free', NULL, '-100', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:11:43', '2015-11-04 10:11:43', NULL),
(116, NULL, '', NULL, NULL, 'free', NULL, '-101', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:21:31', '2015-11-04 10:21:31', NULL),
(117, NULL, 'dasdeasasxx', NULL, 2, 'free', 1, 'dasdeasasxx', 'Amsterdamsestraatweg 123, Utrecht, Netherlands', 123, 'Amsterdamsestraatweg', 'Utrecht', '', '3513 AD', '', 0.000000, 0.000000, 0.00, 0, 1, 8, 'b123', '{"tenants":{"students":true,"all":true},"share":{"online_platforms":true}}', '2015-11-04 10:25:15', '2015-11-26 10:09:57', NULL),
(118, 117, 'Best', 'unit #1', NULL, 'free', NULL, 'best', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, 'ac1', '{"tenants":{"students":true,"working":true}}', '2015-11-04 10:25:43', '2015-11-23 08:16:56', NULL),
(119, NULL, '', NULL, NULL, 'free', NULL, '-102', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:26:11', '2015-11-04 10:26:11', NULL),
(120, NULL, '', NULL, NULL, 'free', NULL, '-103', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:26:43', '2015-11-04 10:26:43', NULL),
(121, NULL, '', NULL, NULL, 'free', NULL, '-104', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:36:34', '2015-11-04 10:36:34', NULL),
(122, NULL, '', NULL, NULL, 'free', NULL, '-105', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:36:57', '2015-11-04 10:36:57', NULL),
(123, NULL, '', NULL, NULL, 'free', NULL, '-106', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:41:22', '2015-11-04 10:41:22', NULL),
(124, NULL, '', NULL, NULL, 'free', NULL, '-107', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:41:53', '2015-11-04 10:41:53', NULL),
(125, NULL, '', NULL, NULL, 'free', NULL, '-108', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:42:01', '2015-11-04 10:42:01', NULL),
(126, NULL, '', NULL, NULL, 'free', NULL, '-109', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:45:44', '2015-11-04 10:45:44', NULL),
(127, NULL, '', NULL, NULL, 'free', NULL, '-110', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:46:28', '2015-11-04 10:46:28', NULL),
(128, NULL, '', NULL, NULL, 'free', NULL, '-111', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:46:50', '2015-11-04 10:46:50', NULL),
(129, NULL, '', NULL, NULL, 'free', NULL, '-112', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:47:15', '2015-11-04 10:47:15', NULL),
(130, NULL, '', NULL, NULL, 'free', NULL, '-113', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:47:59', '2015-11-04 10:47:59', NULL),
(131, NULL, '', NULL, NULL, 'free', NULL, '-114', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:50:09', '2015-11-04 10:50:09', NULL),
(132, NULL, '', NULL, NULL, 'free', NULL, '-115', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:53:20', '2015-11-04 10:53:20', NULL),
(133, NULL, '', NULL, NULL, 'free', NULL, '-116', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:54:01', '2015-11-04 10:54:01', NULL),
(134, NULL, '', NULL, NULL, 'free', NULL, '-117', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:54:17', '2015-11-04 10:54:17', NULL),
(135, NULL, '', NULL, NULL, 'free', NULL, '-118', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:55:24', '2015-11-04 10:55:24', NULL),
(136, NULL, '', NULL, NULL, 'free', NULL, '-119', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:55:52', '2015-11-04 10:55:52', NULL),
(137, NULL, '', NULL, NULL, 'free', NULL, '-120', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:56:03', '2015-11-04 10:56:03', NULL),
(138, NULL, '', NULL, NULL, 'free', NULL, '-121', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 10:58:48', '2015-11-04 10:58:48', NULL),
(139, NULL, '', NULL, NULL, 'free', NULL, '-122', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 11:01:49', '2015-11-04 11:01:49', NULL),
(140, NULL, '', NULL, NULL, 'free', NULL, '-123', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 11:02:05', '2015-11-04 11:02:05', NULL),
(141, NULL, '', NULL, NULL, 'free', NULL, '-124', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 11:03:45', '2015-11-04 11:03:45', NULL),
(142, NULL, '', NULL, NULL, 'free', NULL, '-125', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 11:05:47', '2015-11-04 11:05:47', NULL),
(143, NULL, '', NULL, NULL, 'free', NULL, '-126', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 11:05:55', '2015-11-04 11:05:55', NULL),
(144, NULL, '', NULL, NULL, 'free', NULL, '-127', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 11:06:05', '2015-11-04 11:06:05', NULL),
(145, NULL, '', NULL, NULL, 'free', NULL, '-128', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 11:07:37', '2015-11-04 11:07:37', NULL),
(146, NULL, '', NULL, NULL, 'free', NULL, '-129', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-04 19:30:20', '2015-11-04 19:30:20', NULL),
(147, NULL, '', NULL, NULL, 'free', NULL, '-130', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:27:10', '2015-11-05 08:27:10', NULL),
(148, NULL, '', NULL, NULL, 'free', NULL, '-131', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:27:28', '2015-11-05 08:27:28', NULL),
(149, NULL, '', NULL, NULL, 'free', NULL, '-132', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:27:58', '2015-11-05 08:27:58', NULL),
(150, NULL, '', NULL, NULL, 'free', NULL, '-133', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:28:37', '2015-11-05 08:28:37', NULL),
(151, NULL, '', NULL, NULL, 'free', NULL, '-134', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:28:48', '2015-11-05 08:28:48', NULL),
(152, NULL, '', NULL, NULL, 'free', NULL, '-135', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:28:58', '2015-11-05 08:28:58', NULL),
(153, NULL, '', NULL, NULL, 'free', NULL, '-136', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:30:05', '2015-11-05 08:30:05', NULL),
(154, NULL, '', NULL, NULL, 'free', NULL, '-137', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:30:17', '2015-11-05 08:30:17', NULL),
(155, NULL, '', NULL, NULL, 'free', NULL, '-138', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:32:18', '2015-11-05 08:32:18', NULL),
(156, NULL, '', NULL, NULL, 'free', NULL, '-139', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:32:26', '2015-11-05 08:32:26', NULL),
(157, NULL, '', NULL, NULL, 'free', NULL, '-140', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:33:38', '2015-11-05 08:33:38', NULL),
(158, NULL, 'sdfsd', NULL, 1, 'free', 3, 'sdfsd', '1234 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-05 08:34:14', '2015-11-05 08:37:54', NULL),
(159, NULL, '', NULL, NULL, 'free', NULL, '-141', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:41:10', '2015-11-05 08:41:10', NULL),
(160, NULL, '', NULL, NULL, 'free', NULL, '-142', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:41:22', '2015-11-05 08:41:22', NULL),
(161, NULL, '', NULL, NULL, 'free', NULL, '-143', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:41:52', '2015-11-05 08:41:52', NULL),
(162, NULL, '', NULL, NULL, 'free', NULL, '-144', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-05 08:42:22', '2015-11-05 08:42:22', NULL),
(163, NULL, 'czxczxczx', NULL, 1, 'free', 3, 'czxczxczx', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-05 11:49:42', '2015-11-05 11:50:34', NULL),
(164, NULL, 'dasdasdas', NULL, 1, 'free', 3, 'dasdasdas-1', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-05 12:15:49', '2015-11-05 12:15:59', NULL),
(165, NULL, '', NULL, NULL, 'free', NULL, '-145', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 07:30:24', '2015-11-06 07:30:24', NULL),
(166, NULL, '', NULL, NULL, 'free', NULL, '-146', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:14:16', '2015-11-06 12:14:16', NULL),
(167, NULL, '', NULL, NULL, 'free', NULL, '-147', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:14:22', '2015-11-06 12:14:22', NULL),
(168, NULL, '', NULL, NULL, 'free', NULL, '-148', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:27:39', '2015-11-06 12:27:39', NULL),
(169, NULL, '', NULL, NULL, 'free', NULL, '-149', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:29:09', '2015-11-06 12:29:09', NULL),
(170, NULL, '', NULL, NULL, 'free', NULL, '-150', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:29:48', '2015-11-06 12:29:48', NULL),
(171, NULL, '', NULL, NULL, 'free', NULL, '-151', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:29:58', '2015-11-06 12:29:58', NULL),
(172, NULL, 'uytytugjh', NULL, 1, 'free', 3, 'uytytugjh', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-06 12:52:53', '2015-11-06 12:53:26', NULL),
(173, NULL, '', NULL, NULL, 'free', NULL, '-152', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:54:28', '2015-11-06 12:54:28', NULL),
(174, NULL, '', NULL, NULL, 'free', NULL, '-153', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:55:04', '2015-11-06 12:55:04', NULL),
(175, NULL, '', NULL, NULL, 'free', NULL, '-154', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:57:09', '2015-11-06 12:57:09', NULL),
(176, NULL, '', NULL, NULL, 'free', NULL, '-155', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:58:56', '2015-11-06 12:58:56', NULL),
(177, NULL, '', NULL, NULL, 'free', NULL, '-156', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 12:59:07', '2015-11-06 12:59:07', NULL),
(178, NULL, 'fsdfasd', NULL, 1, 'free', 3, 'fsdfasd', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-06 13:00:07', '2015-11-26 10:13:17', '2015-11-26 10:13:17'),
(179, 117, 'aaaa', 'unit #2', NULL, 'free', NULL, 'aaaa', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, NULL, NULL, NULL, '2015-11-06 13:18:58', '2015-11-06 13:18:58', NULL),
(180, 117, 'unit 3', 'unit #3', NULL, 'free', NULL, 'unit-3', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, NULL, NULL, NULL, '2015-11-06 13:36:37', '2015-11-13 14:50:43', NULL),
(181, 117, 'unit 2', 'unit #4', NULL, 'free', NULL, 'unit-2', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, NULL, NULL, NULL, '2015-11-06 13:36:58', '2015-11-06 14:08:10', '2015-11-06 14:08:10'),
(182, NULL, '', NULL, NULL, 'free', NULL, '-157', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-06 14:56:54', '2015-11-06 14:56:54', NULL),
(183, NULL, 'fsdfsdfs', NULL, 1, 'free', 3, 'fsdfsdfs-1', '123 Amsterdam Way, Norwich, United Kingdom', 0, '', 'Norwich', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, NULL, NULL, '2015-11-06 14:57:06', '2015-11-25 21:38:42', '2015-11-25 21:38:42'),
(184, 183, 'dasdasdas', NULL, NULL, 'free', NULL, 'dasdasdas-2', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, NULL, NULL, NULL, '2015-11-06 15:09:40', '2015-11-06 15:09:40', NULL),
(185, NULL, 'My best property', NULL, 2, 'free', 1, 'my-best-property', 'Amsterdam 123, Bijlmer-Oost, Netherlands', 123, 'Bijlmerdreef', 'Amsterdam Zuid-Oost', '', '1102 BP', '', 0.000000, 0.000000, 0.00, 0, 1, 8, 'b343', NULL, '2015-11-17 13:17:02', '2015-11-25 21:39:12', '2015-11-25 21:39:12'),
(186, 185, 'mountain view', 'unit #1', NULL, 'free', NULL, 'mountain-view', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, NULL, NULL, NULL, '2015-11-17 13:18:08', '2015-11-17 13:18:08', NULL),
(187, NULL, 'By mega apartment', NULL, 2, 'free', 1, 'by-mega-apartment', 'Amstel 123, Amsterdam, Netherlands', 123, 'Amstel', 'Amsterdam', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, 8, 'b123', NULL, '2015-11-17 13:19:30', '2015-11-25 21:42:41', '2015-11-25 21:42:41'),
(188, 187, 'unit mega', 'unit #1', NULL, 'free', NULL, 'unit-mega', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 1, NULL, NULL, NULL, '2015-11-17 13:20:25', '2015-11-17 13:20:25', NULL),
(189, NULL, '', NULL, NULL, 'free', NULL, '-158', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:16:53', '2015-11-17 15:16:53', NULL),
(190, NULL, '', NULL, NULL, 'free', NULL, '-159', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:17:23', '2015-11-17 15:17:23', NULL),
(191, NULL, '', NULL, NULL, 'free', NULL, '-160', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:17:48', '2015-11-17 15:17:48', NULL),
(192, NULL, '', NULL, NULL, 'free', NULL, '-161', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:18:18', '2015-11-17 15:18:18', NULL),
(193, NULL, '', NULL, NULL, 'free', NULL, '-162', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:18:49', '2015-11-17 15:18:49', NULL),
(194, NULL, '', NULL, NULL, 'free', NULL, '-163', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:19:20', '2015-11-17 15:19:20', NULL),
(195, NULL, '', NULL, NULL, 'free', NULL, '-164', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:19:54', '2015-11-17 15:19:54', NULL),
(196, NULL, '', NULL, NULL, 'free', NULL, '-165', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:20:08', '2015-11-17 15:20:08', NULL),
(197, NULL, '', NULL, NULL, 'free', NULL, '-166', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:21:45', '2015-11-17 15:21:45', NULL),
(198, NULL, '', NULL, NULL, 'free', NULL, '-167', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:22:56', '2015-11-17 15:22:56', NULL),
(199, NULL, '', NULL, NULL, 'free', NULL, '-168', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-17 15:23:09', '2015-11-17 15:23:09', NULL),
(200, NULL, '', NULL, NULL, 'free', NULL, '-169', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-20 11:24:14', '2015-11-20 11:24:14', NULL),
(201, NULL, '', NULL, NULL, 'free', NULL, '-170', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-24 09:11:01', '2015-11-24 09:11:01', NULL),
(202, NULL, '', NULL, NULL, 'free', NULL, '-171', '', 0, '', '', '', '', '', 0.000000, 0.000000, 0.00, 0, 0, 8, NULL, NULL, '2015-11-24 09:15:23', '2015-11-24 09:15:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_amenities`
--

CREATE TABLE IF NOT EXISTS `property_amenities` (
  `id` int(10) unsigned NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `amenity_value_id` int(10) unsigned DEFAULT NULL,
  `property_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `property_amenities`
--

INSERT INTO `property_amenities` (`id`, `value`, `amenity_value_id`, `property_id`) VALUES
(13, '10', 3, 117),
(14, '1', 5, 117),
(15, '1', 7, 117),
(16, '10', 10, 117),
(17, '122', 12, 117),
(18, '1', 14, 117);

-- --------------------------------------------------------

--
-- Table structure for table `property_photos`
--

CREATE TABLE IF NOT EXISTS `property_photos` (
  `id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `file` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_size` int(10) unsigned DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_main` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `property_photos`
--

INSERT INTO `property_photos` (`id`, `property_id`, `file`, `file_size`, `status`, `deleted_at`, `created_at`, `updated_at`, `is_main`) VALUES
(1, 45, '/img/uploads/45/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-03 07:30:31', '2015-11-03 07:30:31', 1),
(2, 46, '/img/uploads/46/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 07:36:08', '2015-11-03 07:36:08', 1),
(3, 48, '/img/uploads/48/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 07:45:33', '2015-11-03 07:45:33', 1),
(4, 49, '/img/uploads/49/photos/1298362580effad.JPG', 100958, 1, NULL, '2015-11-03 07:46:03', '2015-11-03 07:46:03', 1),
(5, 50, '/img/uploads/50/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 07:47:32', '2015-11-03 07:47:32', 1),
(6, 51, '/img/uploads/51/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 07:48:45', '2015-11-03 07:48:45', 1),
(7, 52, '/img/uploads/52/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 07:50:49', '2015-11-03 07:50:49', 1),
(8, 53, '/img/uploads/53/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 07:51:16', '2015-11-03 07:51:16', 1),
(9, 54, '/img/uploads/54/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 07:53:47', '2015-11-03 07:53:47', 1),
(10, 55, '/img/uploads/55/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 07:57:32', '2015-11-03 07:57:32', 1),
(11, 56, '/img/uploads/56/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 07:57:54', '2015-11-03 07:57:54', 1),
(12, 57, '/img/uploads/57/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:00:34', '2015-11-03 08:00:34', 1),
(13, 58, '/img/uploads/58/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:01:34', '2015-11-03 08:01:34', 1),
(14, 61, '/img/uploads/61/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:13:21', '2015-11-03 08:13:21', 1),
(15, 61, '/img/uploads/61/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-03 08:13:23', '2015-11-03 08:13:23', 1),
(16, 62, '/img/uploads/62/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-03 08:26:26', '2015-11-03 08:26:26', 1),
(17, 62, '/img/uploads/62/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:26:29', '2015-11-03 08:26:29', 1),
(18, 63, '/img/uploads/63/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:27:23', '2015-11-03 08:27:23', 1),
(19, 63, '/img/uploads/63/photos/1298362580a109b.JPG', 40314, 1, NULL, '2015-11-03 08:27:25', '2015-11-03 08:27:25', 1),
(20, 64, '/img/uploads/64/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:28:19', '2015-11-03 08:28:19', 1),
(21, 64, '/img/uploads/64/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:28:22', '2015-11-03 08:28:22', 1),
(22, 65, '/img/uploads/65/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:28:48', '2015-11-03 08:28:48', 1),
(23, 65, '/img/uploads/65/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:28:50', '2015-11-03 08:28:50', 1),
(24, 66, '/img/uploads/66/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-03 08:29:26', '2015-11-03 08:29:26', 1),
(25, 66, '/img/uploads/66/photos/1298362580a109b.JPG', 40314, 1, NULL, '2015-11-03 08:29:28', '2015-11-03 08:29:28', 1),
(26, 67, '/img/uploads/67/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:31:17', '2015-11-03 08:31:17', 1),
(27, 67, '/img/uploads/67/photos/1298362580effad.JPG', 100958, 1, NULL, '2015-11-03 08:31:19', '2015-11-03 08:31:19', 1),
(28, 68, '/img/uploads/68/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:32:00', '2015-11-03 08:32:00', 1),
(29, 68, '/img/uploads/68/photos/1298362580effad.JPG', 100958, 1, NULL, '2015-11-03 08:32:04', '2015-11-03 08:32:04', 1),
(30, 69, '/img/uploads/69/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:33:29', '2015-11-03 08:33:29', 1),
(31, 70, '/img/uploads/70/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:34:05', '2015-11-03 08:34:05', 1),
(32, 70, '/img/uploads/70/photos/1298362580a109b.JPG', 40314, 1, NULL, '2015-11-03 08:34:08', '2015-11-03 08:34:08', 1),
(33, 71, '/img/uploads/71/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:34:31', '2015-11-03 08:34:31', 1),
(34, 71, '/img/uploads/71/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:34:33', '2015-11-03 08:34:33', 1),
(35, 72, '/img/uploads/72/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:34:53', '2015-11-03 08:34:53', 1),
(36, 72, '/img/uploads/72/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:34:55', '2015-11-03 08:34:55', 1),
(37, 73, '/img/uploads/73/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:36:51', '2015-11-03 08:36:51', 1),
(38, 73, '/img/uploads/73/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:36:54', '2015-11-03 08:36:54', 1),
(39, 74, '/img/uploads/74/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:37:21', '2015-11-03 08:37:21', 1),
(40, 74, '/img/uploads/74/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-03 08:37:23', '2015-11-03 08:37:23', 1),
(41, 75, '/img/uploads/75/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:37:52', '2015-11-03 08:37:52', 1),
(42, 75, '/img/uploads/75/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:37:53', '2015-11-03 08:37:53', 1),
(43, 76, '/img/uploads/76/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:38:44', '2015-11-03 08:38:44', 1),
(44, 76, '/img/uploads/76/photos/1298362580a109b.JPG', 40314, 1, NULL, '2015-11-03 08:38:46', '2015-11-03 08:38:46', 1),
(45, 77, '/img/uploads/77/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:39:16', '2015-11-03 08:39:16', 1),
(46, 77, '/img/uploads/77/photos/1298362580a109b.JPG', 40314, 1, NULL, '2015-11-03 08:39:19', '2015-11-03 08:39:19', 1),
(47, 78, '/img/uploads/78/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:39:35', '2015-11-03 08:39:35', 1),
(48, 79, '/img/uploads/79/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:43:23', '2015-11-03 08:43:23', 1),
(49, 79, '/img/uploads/79/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:43:26', '2015-11-03 08:43:26', 1),
(50, 80, '/img/uploads/80/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:44:06', '2015-11-03 08:44:06', 1),
(51, 80, '/img/uploads/80/photos/1298362580a109b.JPG', 40314, 1, NULL, '2015-11-03 08:44:09', '2015-11-03 08:44:09', 1),
(52, 81, '/img/uploads/81/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:44:47', '2015-11-03 08:44:47', 1),
(53, 81, '/img/uploads/81/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:44:49', '2015-11-03 08:44:49', 1),
(54, 82, '/img/uploads/82/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:45:30', '2015-11-03 08:45:30', 1),
(55, 82, '/img/uploads/82/photos/1298362580a109b.JPG', 40314, 1, NULL, '2015-11-03 08:45:31', '2015-11-03 08:45:31', 1),
(56, 83, '/img/uploads/83/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 08:45:56', '2015-11-03 08:45:56', 1),
(57, 83, '/img/uploads/83/photos/1298362580effad.JPG', 100958, 1, NULL, '2015-11-03 08:46:59', '2015-11-03 08:46:59', 1),
(58, 84, '/img/uploads/84/photos/1298362580effad.JPG', 100958, 1, NULL, '2015-11-03 08:51:59', '2015-11-03 08:51:59', 1),
(59, 84, '/img/uploads/84/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 08:53:55', '2015-11-03 08:53:55', 1),
(60, 85, '/img/uploads/85/photos/129836253892c6c.JPG', 51830, 1, '2015-11-03 08:56:38', '2015-11-03 08:56:35', '2015-11-03 08:56:38', 1),
(61, 85, '/img/uploads/85/photos/1298362580effad.JPG', 100958, 1, NULL, '2015-11-03 08:56:38', '2015-11-03 08:56:38', 1),
(62, 89, '/img/uploads/89/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-03 09:02:21', '2015-11-03 09:02:21', NULL),
(63, 89, '/img/uploads/89/photos/1298362580effad.JPG', 100958, 1, NULL, '2015-11-03 09:02:23', '2015-11-03 09:02:23', NULL),
(64, 89, '/img/uploads/89/photos/1298362580a109b.JPG', 40314, 1, NULL, '2015-11-03 09:03:33', '2015-11-03 09:03:33', 1),
(65, 98, '/img/uploads/98/photos/1298362538be920.JPG', 90920, 1, '2015-11-03 13:43:15', '2015-11-03 13:43:12', '2015-11-03 13:43:15', 1),
(66, 98, '/img/uploads/98/photos/129836253893c86.JPG', 42174, 1, NULL, '2015-11-03 13:43:15', '2015-11-03 13:43:15', 1),
(68, 105, '/img/uploads/105/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-04 09:42:53', '2015-11-04 09:42:53', 1),
(69, 116, '/img/uploads/116/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-04 10:22:33', '2015-11-04 10:22:33', 1),
(70, 119, '/img/uploads/119/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-04 10:26:15', '2015-11-04 10:26:15', 1),
(71, 123, '/img/uploads/123/photos/12983625777f5e9.JPG', 57281, 1, NULL, '2015-11-04 10:41:26', '2015-11-04 10:41:26', 1),
(72, 124, '/img/uploads/124/photos/12983625777f5e9.JPG', 57281, 1, NULL, '2015-11-04 10:41:56', '2015-11-04 10:41:56', 1),
(73, 117, '/img/uploads/117/photos/1298362580a109b.JPG', 40314, 1, '2015-11-06 13:01:12', '2015-11-06 12:52:20', '2015-11-06 13:01:12', 1),
(74, 117, '/img/uploads/117/photos/1298362580effad.JPG', 100958, 1, '2015-11-06 13:01:37', '2015-11-06 13:01:12', '2015-11-06 13:01:37', 1),
(75, 117, '/img/uploads/117/photos/12983625389ec20.JPG', 78614, 1, '2015-11-06 14:51:49', '2015-11-06 13:01:37', '2015-11-06 14:51:49', 1),
(76, 117, '/img/uploads/117/photos/129836253893c86.JPG', 42174, 1, '2015-11-19 09:00:40', '2015-11-06 13:04:56', '2015-11-19 09:00:40', NULL),
(77, 117, '/img/uploads/117/photos/129836253893c86.JPG', 42174, 1, '2015-11-16 10:36:18', '2015-11-06 14:51:49', '2015-11-16 10:36:18', 1),
(78, 117, '/img/uploads/117/photos/1298362580a109b.JPG', 40314, 1, '2015-11-16 10:39:15', '2015-11-16 10:36:18', '2015-11-16 10:39:15', 1),
(79, 117, '/img/uploads/117/photos/12983625389ec20.JPG', 78614, 1, '2015-11-16 10:39:21', '2015-11-16 10:39:15', '2015-11-16 10:39:21', 1),
(80, 117, '/img/uploads/117/photos/129836253893c86.JPG', 42174, 1, '2015-11-16 11:42:13', '2015-11-16 10:39:21', '2015-11-16 11:42:13', 1),
(81, 117, '/img/uploads/117/photos/12983625389ec20.JPG', 78614, 1, '2015-11-16 11:42:37', '2015-11-16 11:42:13', '2015-11-16 11:42:37', 1),
(82, 117, '/img/uploads/117/photos/129836253893c86.JPG', 42174, 1, '2015-11-16 11:43:06', '2015-11-16 11:42:37', '2015-11-16 11:43:06', 1),
(83, 117, '/img/uploads/117/photos/1298362580effad.JPG', 100958, 1, '2015-11-16 11:43:24', '2015-11-16 11:43:06', '2015-11-16 11:43:24', 1),
(84, 117, '/img/uploads/117/photos/12983625389ec20.JPG', 78614, 1, '2015-11-16 11:43:43', '2015-11-16 11:43:24', '2015-11-16 11:43:43', 1),
(85, 117, '/img/uploads/117/photos/129836253893c86.JPG', 42174, 1, '2015-11-16 11:44:42', '2015-11-16 11:43:43', '2015-11-16 11:44:42', 1),
(86, 117, '/img/uploads/117/photos/1298362580effad.JPG', 100958, 1, '2015-11-16 11:44:49', '2015-11-16 11:44:42', '2015-11-16 11:44:49', 1),
(87, 117, '/img/uploads/117/photos/129836253893c86.JPG', 42174, 1, '2015-11-16 11:44:55', '2015-11-16 11:44:49', '2015-11-16 11:44:55', 1),
(88, 117, '/img/uploads/117/photos/129836253892c6c.JPG', 51830, 1, '2015-11-16 11:44:57', '2015-11-16 11:44:55', '2015-11-16 11:44:57', 1),
(89, 117, '/img/uploads/117/photos/129836253893c86.JPG', 42174, 1, '2015-11-16 11:44:59', '2015-11-16 11:44:57', '2015-11-16 11:44:59', 1),
(90, 117, '/img/uploads/117/photos/12983625389ec20.JPG', 78614, 1, '2015-11-16 11:45:01', '2015-11-16 11:44:59', '2015-11-16 11:45:01', 1),
(91, 117, '/img/uploads/117/photos/129836253892c6c.JPG', 51830, 1, '2015-11-16 11:48:15', '2015-11-16 11:45:01', '2015-11-16 11:48:15', 1),
(92, 117, '/img/uploads/117/photos/1298362580effad.JPG', 100958, 1, '2015-11-16 11:52:06', '2015-11-16 11:48:15', '2015-11-16 11:52:06', 1),
(93, 117, '/img/uploads/117/photos/12983625389ec20.JPG', 78614, 1, '2015-11-19 08:57:08', '2015-11-16 11:52:06', '2015-11-19 08:57:08', 1),
(94, 187, '/img/uploads/187/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-17 13:19:33', '2015-11-17 13:19:33', 1),
(95, 117, '/uploads/properties/117/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-19 08:57:08', '2015-11-19 08:57:08', 1),
(96, 117, '/uploads/properties/117/photos/1298362538be920.JPG', 90920, 1, NULL, '2015-11-19 09:00:35', '2015-11-19 09:00:35', NULL),
(97, 2, '/uploads/properties/2/photos/129836253892c6c.JPG', 51830, 1, NULL, '2015-11-19 09:25:50', '2015-11-19 09:25:50', 1),
(98, 118, '/uploads/properties/118/photos/National Parks (63).jpg', 3731750, 1, NULL, '2015-11-23 08:38:42', '2015-11-23 08:38:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_tenants`
--

CREATE TABLE IF NOT EXISTS `property_tenants` (
  `id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `collection_day` tinyint(4) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `property_tenants`
--

INSERT INTO `property_tenants` (`id`, `property_id`, `unit_id`, `user_id`, `collection_day`, `start_date`, `end_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, NULL, 9, 15, '2015-10-31 22:00:00', '2015-11-09 22:00:00', '2015-09-20 11:00:00', '2015-11-02 21:33:35', NULL),
(2, 117, NULL, 20, 1, '2015-10-26 22:00:00', '2015-11-02 22:00:00', '2015-11-09 21:31:56', '2015-11-11 14:01:52', NULL),
(4, 2, NULL, 12, 2, '2015-11-01 22:00:00', '2015-11-07 22:00:00', '2015-11-09 22:00:00', '0000-00-00 00:00:00', NULL),
(5, 2, NULL, 9, 1, '2015-11-01 22:00:00', '2015-11-11 22:00:00', '2015-11-10 21:07:29', '2015-11-10 21:07:29', NULL),
(8, 2, NULL, 9, 1, '2015-11-02 22:00:00', '2015-11-03 22:00:00', '2015-11-10 21:16:06', '2015-11-10 21:16:06', NULL),
(9, 2, NULL, 12, 1, '2015-10-26 22:00:00', '2015-11-08 22:00:00', '2015-11-10 21:17:36', '2015-11-10 21:17:36', NULL),
(10, 117, NULL, 20, 1, '2015-10-26 22:00:00', '2015-11-10 00:07:00', '2015-11-10 21:25:32', '2015-11-11 13:45:17', NULL),
(11, 117, NULL, 28, 1, '2015-10-26 22:00:00', '2015-11-09 22:00:00', '2015-11-10 21:28:42', '2015-11-10 21:28:42', NULL),
(12, 117, NULL, 29, 1, '2015-10-27 22:00:00', '2015-11-09 22:00:00', '2015-11-10 21:32:42', '2015-11-10 21:32:42', NULL),
(13, 2, NULL, 30, 1, '2015-10-26 22:00:00', '2015-11-08 22:00:00', '2015-11-10 21:33:15', '2015-11-10 21:33:15', NULL),
(14, 117, NULL, 31, 1, '2015-10-26 22:00:00', '2015-11-17 22:00:00', '2015-11-10 21:33:47', '2015-11-10 21:33:47', NULL),
(15, 117, NULL, 32, 1, '2015-10-26 22:00:00', '2015-11-09 22:00:00', '2015-11-10 21:40:34', '2015-11-10 21:40:34', NULL),
(16, 117, NULL, 33, 1, '2015-10-27 22:00:00', '2015-11-17 22:00:00', '2015-11-10 21:47:27', '2015-11-10 21:47:27', NULL),
(17, 117, NULL, 34, 1, '2015-10-27 22:00:00', '2015-11-09 22:00:00', '2015-11-10 21:48:05', '2015-11-10 21:48:05', NULL),
(18, 117, NULL, 35, 1, '2015-10-26 22:00:00', '2015-11-02 22:00:00', '2015-11-10 21:48:32', '2015-11-12 07:41:42', NULL),
(19, 117, NULL, 36, 1, '2015-11-02 22:00:00', '2015-11-10 22:00:00', '2015-11-11 08:12:59', '2015-11-11 14:00:45', NULL),
(20, 117, NULL, 37, 1, '2015-10-26 22:00:00', '2015-11-10 22:00:00', '2015-11-11 08:26:21', '2015-11-11 14:01:20', NULL),
(21, 117, NULL, 12, 2, '2015-10-25 22:00:00', '2015-11-08 22:00:00', '2015-11-11 19:50:02', '2015-11-11 19:50:02', NULL),
(22, 117, 179, 9, 1, '2015-11-01 22:00:00', '2015-11-24 22:00:00', '2015-11-11 20:01:41', '2015-11-20 10:27:54', NULL),
(23, 117, NULL, 38, 2, '2015-10-26 22:00:00', '2015-11-10 22:00:00', '2015-11-12 07:54:25', '2015-11-12 07:54:25', NULL),
(24, 117, NULL, 39, 1, '2015-10-26 22:00:00', '2015-11-23 22:00:00', '2015-11-12 08:00:24', '2015-11-16 11:33:14', NULL),
(25, 117, NULL, 40, 1, '2015-11-01 22:00:00', '2015-11-16 22:00:00', '2015-11-12 08:02:08', '2015-11-12 08:02:08', NULL),
(26, 117, NULL, 21, 1, '2015-10-26 22:00:00', '2015-11-16 22:00:00', '2015-11-12 08:57:07', '2015-11-12 08:57:07', NULL),
(27, 117, 118, 23, 1, '2015-11-03 22:00:00', '2015-11-29 22:00:00', '2015-11-16 10:14:28', '2015-11-20 10:29:14', NULL),
(28, 117, NULL, 27, 1, '2015-11-02 22:00:00', '2015-11-29 22:00:00', '2015-11-16 10:38:46', '2015-11-16 10:38:46', NULL),
(29, 117, NULL, 41, 1, '2015-11-02 22:00:00', '2015-11-09 22:00:00', '2015-11-20 09:52:14', '2015-11-20 09:52:14', NULL),
(30, 117, NULL, 24, 1, '2015-10-25 22:00:00', '2015-11-16 22:00:00', '2015-11-20 10:22:46', '2015-11-20 10:23:08', NULL),
(31, 117, NULL, 42, 1, '2015-10-27 22:00:00', '2015-11-23 22:00:00', '2015-11-20 10:28:31', '2015-11-20 10:28:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_transactions`
--

CREATE TABLE IF NOT EXISTS `property_transactions` (
  `id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `unit_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `transaction_category_id` int(10) unsigned DEFAULT NULL,
  `transaction_recurring_id` int(10) unsigned DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `amount_tax` double(4,2) DEFAULT NULL,
  `amount_tax_included` smallint(6) DEFAULT NULL,
  `amount_total` double(8,2) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `property_transactions`
--

INSERT INTO `property_transactions` (`id`, `property_id`, `unit_id`, `user_id`, `transaction_category_id`, `transaction_recurring_id`, `amount`, `amount_tax`, `amount_tax_included`, `amount_total`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 117, NULL, NULL, 1, 3, 20.00, NULL, 0, 20.00, NULL, '2015-11-04 20:51:36', '2015-11-16 20:31:23', NULL),
(9, 168, NULL, NULL, 1, 3, 100.00, NULL, 0, 100.00, NULL, '2015-11-06 12:27:49', '2015-11-06 12:27:49', NULL),
(10, 117, NULL, 9, 4, 3, 999.00, NULL, 0, 999.00, 'Internet super', '2015-11-12 14:16:12', '2015-11-12 14:16:12', NULL),
(11, 117, 180, NULL, 6, 2, 110.00, 10.00, 0, 121.00, 'Cleaning super', '2015-11-12 14:16:12', '2015-11-19 09:49:10', NULL),
(12, 117, 179, NULL, 1, 3, 1500.00, NULL, 0, 1500.00, NULL, '2015-11-12 14:19:43', '2015-11-12 14:19:43', NULL),
(21, 117, 179, 9, 1, 3, 44.00, NULL, NULL, 44.00, 'baux', '2015-11-12 23:37:31', '2015-11-16 10:17:54', NULL),
(22, 117, 179, 9, 1, 1, 150.00, NULL, NULL, 160.00, 'Tv antena 12', '2015-11-13 08:41:42', '2015-11-16 18:13:51', NULL),
(23, 117, 179, 9, 1, 3, 120.00, NULL, NULL, 120.00, 'Tv antena 2', '2015-11-13 09:16:42', '2015-11-16 20:04:13', NULL),
(27, 117, 179, 9, NULL, NULL, 5000.00, NULL, NULL, 5000.00, 'girls', '2015-11-13 14:39:20', '2015-11-13 14:41:18', '2015-11-13 14:41:18'),
(28, 117, 179, 9, 1, 3, 10000.00, NULL, NULL, 10000.00, 'Girls', '2015-11-16 10:16:07', '2015-11-16 18:09:37', '2015-11-16 18:09:37'),
(29, 117, 118, NULL, 5, 3, 100.00, NULL, 0, 100.00, NULL, '2015-11-16 20:34:12', '2015-11-16 20:34:12', NULL),
(30, 117, NULL, NULL, 3, 7, 180.00, 10.00, 0, 198.00, NULL, '2015-11-16 20:36:50', '2015-11-16 20:36:50', NULL),
(31, 117, NULL, NULL, 3, 7, 178.00, 25.00, 0, 222.50, NULL, '2015-11-16 20:37:26', '2015-11-16 20:37:26', NULL),
(32, 117, NULL, NULL, 3, 7, 110.00, NULL, 0, 110.00, NULL, '2015-11-16 20:38:04', '2015-11-19 09:41:44', NULL),
(33, 117, NULL, NULL, 6, 7, 150.00, 10.00, 0, 165.00, 'my cleaningx', '2015-11-16 20:38:28', '2015-11-19 09:54:30', NULL),
(34, 187, NULL, NULL, 1, 3, 150.00, 10.00, 0, 165.00, NULL, '2015-11-17 13:20:59', '2015-11-17 13:20:59', NULL),
(35, 89, NULL, NULL, 1, 3, 100.00, NULL, 0, 100.00, NULL, '2015-11-17 16:06:35', '2015-11-17 16:06:35', '2015-11-16 22:00:00'),
(36, 89, NULL, NULL, 1, 3, 150.00, NULL, 0, 150.00, NULL, '2015-11-17 16:11:47', '2015-11-17 16:11:47', '2015-11-16 22:00:00'),
(37, 89, NULL, NULL, 1, 3, 150.00, NULL, 0, 150.00, NULL, '2015-11-17 16:13:45', '2015-11-17 16:14:10', '2015-11-17 16:14:10'),
(38, 89, NULL, NULL, 1, 3, 150.00, NULL, 0, 150.00, NULL, '2015-11-17 16:17:55', '2015-11-17 16:18:00', '2015-11-17 16:18:00'),
(39, 89, NULL, NULL, 1, 3, 180.00, NULL, 0, 180.00, NULL, '2015-11-17 16:18:09', '2015-11-17 16:18:49', '2015-11-17 16:18:49'),
(40, 89, NULL, NULL, 1, 3, 190.00, NULL, 0, 190.00, NULL, '2015-11-17 16:18:53', '2015-11-17 16:21:44', '2015-11-17 16:21:44'),
(41, 89, NULL, NULL, 1, 3, 11.00, NULL, 0, 11.00, NULL, '2015-11-17 16:21:47', '2015-11-17 16:28:49', '2015-11-17 16:28:49'),
(42, 89, NULL, NULL, 1, 3, 180.00, NULL, 0, 180.00, NULL, '2015-11-17 16:28:53', '2015-11-17 16:30:29', '2015-11-17 16:30:29'),
(43, 89, NULL, NULL, 1, 3, 190.00, NULL, 0, 190.00, NULL, '2015-11-17 16:30:32', '2015-11-17 16:36:43', '2015-11-17 16:36:43'),
(44, 89, NULL, NULL, 1, 3, 120.00, NULL, 0, 120.00, NULL, '2015-11-17 16:36:47', '2015-11-17 16:42:56', '2015-11-17 16:42:56'),
(45, 89, NULL, NULL, 1, 3, 50.00, NULL, 0, 50.00, NULL, '2015-11-17 16:42:59', '2015-11-17 16:44:17', '2015-11-17 16:44:17'),
(46, 89, NULL, NULL, 1, 3, 150.00, NULL, 0, 150.00, NULL, '2015-11-17 16:44:28', '2015-11-17 16:44:35', '2015-11-17 16:44:35'),
(47, 89, NULL, NULL, 1, 3, 120.00, NULL, 0, 120.00, NULL, '2015-11-17 16:46:19', '2015-11-17 16:46:19', NULL),
(48, 117, NULL, NULL, 1, 3, 170.00, NULL, 0, 170.00, 'ggg', '2015-11-19 09:55:10', '2015-11-19 09:55:10', NULL),
(49, 117, NULL, NULL, 1, 3, 52.00, NULL, 0, 52.00, NULL, '2015-11-19 09:58:45', '2015-11-19 09:58:45', NULL),
(50, 117, NULL, NULL, 1, 3, 89.00, NULL, 0, 89.00, NULL, '2015-11-19 09:59:00', '2015-11-19 09:59:00', NULL),
(51, 117, NULL, NULL, 1, 3, 12.00, NULL, 0, 12.00, NULL, '2015-11-19 09:59:33', '2015-11-19 09:59:33', NULL),
(52, 117, NULL, NULL, 1, 3, 89.00, NULL, 0, 89.00, NULL, '2015-11-19 09:59:45', '2015-11-19 09:59:45', NULL),
(53, 117, NULL, NULL, 1, 3, 45.00, NULL, 0, 45.00, NULL, '2015-11-19 09:59:52', '2015-11-19 09:59:52', NULL),
(54, 117, NULL, NULL, 1, 3, 78.00, NULL, 0, 78.00, NULL, '2015-11-19 10:03:22', '2015-11-19 10:03:22', NULL),
(55, 117, NULL, NULL, 1, 3, 15.00, NULL, 0, 15.00, NULL, '2015-11-19 10:04:19', '2015-11-19 10:04:19', NULL),
(56, 117, NULL, 23, NULL, NULL, 14.00, NULL, NULL, 14.00, 'fsdfsd', '2015-11-20 09:36:20', '2015-11-20 09:36:20', NULL),
(57, 117, NULL, 23, NULL, NULL, 100.00, NULL, NULL, 100.00, 'hfghfg', '2015-11-20 09:39:07', '2015-11-20 09:39:07', NULL),
(58, 117, NULL, NULL, 1, 3, 100.00, NULL, 0, 100.00, 'fdfs', '2015-11-20 09:54:39', '2015-11-20 09:54:39', NULL),
(59, 117, 179, 9, NULL, 1, 100.00, NULL, NULL, 100.00, 'eqweqweqw', '2015-11-20 09:55:04', '2015-11-20 09:55:18', NULL),
(60, 117, 118, NULL, 1, 3, 100.00, NULL, 0, 100.00, 'xxx', '2015-11-20 09:55:49', '2015-11-20 09:55:49', NULL),
(61, 2, NULL, NULL, 1, 3, 100.00, NULL, 0, 100.00, 'uju', '2015-11-20 09:59:22', '2015-11-20 09:59:57', '2015-11-20 09:59:57'),
(62, 2, NULL, NULL, 1, 3, 100.00, NULL, 0, 100.00, 'fsdf', '2015-11-20 10:00:20', '2015-11-20 10:02:19', '2015-11-20 10:02:19'),
(63, 2, NULL, NULL, 1, 3, 100.00, NULL, 0, 100.00, 'hh', '2015-11-20 10:02:31', '2015-11-20 10:05:15', '2015-11-20 10:05:15'),
(64, 2, NULL, NULL, 1, 3, 100.00, NULL, 0, 100.00, 'ggg', '2015-11-20 10:05:25', '2015-11-20 10:09:39', '2015-11-20 10:09:39'),
(65, 2, NULL, NULL, 1, 3, 100.00, NULL, 0, 100.00, 'ggg', '2015-11-20 10:09:53', '2015-11-20 10:12:09', '2015-11-20 10:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `property_types`
--

CREATE TABLE IF NOT EXISTS `property_types` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `property_types`
--

INSERT INTO `property_types` (`id`, `title`) VALUES
(1, 'Room'),
(2, 'Apartment'),
(3, 'House'),
(4, 'Buidling'),
(5, 'Office'),
(6, 'Space'),
(7, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `property_type_amenities`
--

CREATE TABLE IF NOT EXISTS `property_type_amenities` (
  `id` int(11) unsigned NOT NULL,
  `property_type_id` int(10) unsigned DEFAULT NULL,
  `amenity_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `property_type_amenities`
--

INSERT INTO `property_type_amenities` (`id`, `property_type_id`, `amenity_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(2, 1, 2, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(3, 1, 3, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(4, 1, 4, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(5, 1, 5, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(6, 1, 6, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(7, 1, 7, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(8, 1, 8, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(9, 1, 9, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(10, 1, 10, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(11, 1, 11, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(12, 1, 12, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(13, 1, 13, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(14, 1, 14, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(15, 1, 15, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(16, 1, 16, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(17, 1, 17, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(18, 1, 18, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(19, 1, 19, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(20, 1, 20, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(21, 1, 21, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(22, 1, 22, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(23, 1, 24, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(24, 1, 33, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(25, 1, 34, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(26, 1, 35, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(27, 2, 1, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(28, 2, 2, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(29, 2, 3, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(30, 2, 4, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(31, 2, 5, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(32, 2, 6, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(33, 2, 7, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(34, 2, 8, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(35, 2, 9, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(36, 2, 10, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(37, 2, 11, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(38, 2, 12, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(39, 2, 13, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(40, 2, 14, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(41, 2, 15, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(42, 2, 16, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(43, 2, 17, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(44, 2, 18, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(45, 2, 19, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(46, 2, 20, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(47, 2, 21, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(48, 2, 22, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(49, 2, 24, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(50, 2, 33, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(51, 2, 34, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(52, 2, 35, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(53, 3, 1, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(54, 3, 2, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(55, 3, 3, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(56, 3, 4, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(57, 3, 5, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(58, 3, 6, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(59, 3, 7, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(60, 3, 8, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(61, 3, 9, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(62, 3, 10, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(63, 3, 11, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(64, 3, 12, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(65, 3, 13, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(66, 3, 14, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(67, 3, 15, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(68, 3, 16, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(69, 3, 17, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(70, 3, 18, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(71, 3, 25, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(72, 3, 26, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(73, 3, 21, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(74, 3, 22, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(75, 3, 24, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(76, 3, 33, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(77, 3, 27, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(78, 3, 28, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(79, 3, 29, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(80, 3, 30, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(81, 3, 31, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(82, 3, 32, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(83, 3, 34, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL),
(84, 3, 35, '2015-11-25 10:05:47', '2015-11-25 10:05:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_user_transactions`
--

CREATE TABLE IF NOT EXISTS `property_user_transactions` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `property_transaction_id` int(10) unsigned DEFAULT NULL,
  `transaction_type_id` int(10) unsigned DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `property_user_transactions`
--

INSERT INTO `property_user_transactions` (`id`, `user_id`, `property_transaction_id`, `transaction_type_id`, `amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 20, 10, 1, 65.00, '2015-11-11 22:00:00', '2015-11-12 23:22:31', NULL),
(18, 9, 22, 1, 160.00, '2015-11-13 08:41:42', '2015-11-16 18:12:18', '2015-11-16 18:12:18'),
(19, 9, 23, 1, 100.00, '2015-11-13 09:16:42', '2015-11-13 09:20:38', '2015-11-13 09:20:38'),
(20, 9, NULL, 1, 299.00, '2015-11-13 09:27:48', '2015-11-13 09:42:47', '2015-11-13 09:42:47'),
(21, 9, NULL, 1, 199.00, '2015-11-13 09:29:56', '2015-11-13 09:42:46', '2015-11-13 09:42:46'),
(22, 9, NULL, 1, 10.00, '2015-11-13 09:35:10', '2015-11-13 09:42:50', '2015-11-13 09:42:50'),
(23, 9, 7, 1, 8.00, '2015-11-13 09:42:39', '2015-11-13 14:38:53', '2015-11-13 14:38:53'),
(24, 9, NULL, 1, 30.00, '2015-11-13 09:43:45', '2015-11-13 09:43:52', '2015-11-13 09:43:52'),
(25, 9, 27, 1, 5000.00, '2015-11-13 14:39:20', '2015-11-13 14:39:20', NULL),
(26, 9, 11, 1, 10.00, '2015-11-16 10:15:28', '2015-11-16 10:15:41', '2015-11-16 10:15:41'),
(27, 9, 28, 1, 10000.00, '2015-11-16 10:16:07', '2015-11-16 10:20:40', '2015-11-16 10:20:40'),
(28, 9, 22, 1, 160.00, '2015-11-16 18:12:25', '2015-11-16 18:12:31', '2015-11-16 18:12:31'),
(29, 9, 22, 1, 120.00, '2015-11-16 18:12:37', '2015-11-16 18:13:43', '2015-11-16 18:13:43'),
(30, 9, 22, 1, 160.00, '2015-11-16 18:13:51', '2015-11-16 18:13:51', NULL),
(31, 23, 56, 1, 14.00, '2015-11-20 09:36:20', '2015-11-20 09:36:20', NULL),
(32, 23, 57, 1, 100.00, '2015-11-20 09:39:07', '2015-11-20 09:39:07', NULL),
(33, 9, 59, 1, 100.00, '2015-11-20 09:55:04', '2015-11-20 09:55:04', NULL),
(34, 23, 60, 1, 100.00, '2015-11-23 14:24:24', '2015-11-23 14:24:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', 'administrator privileges', '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(2, 'Landlord', 'landlord', 'landlord privileges', '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(3, 'Accountant', 'accountant', 'Accountant privileges', '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(4, 'Tenant', 'tenant', 'Tenant privileges', '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(5, 'Manager', 'manager', 'Manager privileges', '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(6, 'Guest', 'guest', 'Guest privileges', '2015-11-02 21:33:35', '2015-11-02 21:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(2, 1, 4, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(3, 1, 7, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(4, 1, 10, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(5, 1, 13, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(6, 1, 16, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(7, 2, 2, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(8, 2, 5, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(9, 2, 8, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(10, 2, 11, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(11, 2, 14, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(12, 2, 17, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(13, 4, 3, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(14, 4, 6, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(15, 4, 9, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(16, 4, 12, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(17, 4, 15, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(18, 4, 18, '2015-11-02 21:33:35', '2015-11-02 21:33:35'),
(19, 5, 13, '2015-11-02 21:33:35', '2015-11-02 21:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_categories`
--

CREATE TABLE IF NOT EXISTS `transaction_categories` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `transaction_recurring_id` int(10) unsigned DEFAULT NULL,
  `weight` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction_categories`
--

INSERT INTO `transaction_categories` (`id`, `title`, `user_id`, `transaction_recurring_id`, `weight`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Rent', NULL, 3, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(2, 'Deposit', NULL, NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(3, 'Commission', NULL, NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(4, 'Internet', NULL, 3, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(5, 'Utilities', NULL, 3, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL),
(6, 'Cleaning', NULL, NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_recurrings`
--

CREATE TABLE IF NOT EXISTS `transaction_recurrings` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight` tinyint(4) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction_recurrings`
--

INSERT INTO `transaction_recurrings` (`id`, `title`, `weight`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Weekly', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34'),
(2, 'Bi-Weekly', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34'),
(3, 'Monthly', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34'),
(4, 'Semi-Monthly', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34'),
(5, 'Annually', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34'),
(6, 'Semi-Annually', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34'),
(7, 'Quarterly', NULL, NULL, '2015-11-02 21:33:34', '2015-11-02 21:33:34');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

CREATE TABLE IF NOT EXISTS `transaction_types` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sign` smallint(6) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction_types`
--

INSERT INTO `transaction_types` (`id`, `title`, `sign`, `deleted_at`) VALUES
(1, 'in', 1, NULL),
(2, 'out', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_demo` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `has_login` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `parent_id`, `email`, `password`, `confirmation_code`, `confirmed`, `admin`, `remember_token`, `has_demo`, `created_at`, `updated_at`, `deleted_at`, `has_login`) VALUES
(1, 'Vasy Dragan', 0, 'vasy.dragan@gmail.com', '$2y$10$46ONz5ODq0NRkAl1s0FjvehdX4iSK7WGDBWoQnry5mL6HL3QWeRp.', 'cc4ea7a9c8d3f51eb2b1ef0d05a6f932', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(2, 'Vasy Landlord', 0, 'vasy.dragan+landlord@gmail.com', '$2y$10$AKjUfAqPX6sWZvMW5GeCpupDp1yxG5DNqpE0rmATO/XM6Nrek9Ftm', 'e87f18d8ec02e9072f3718e7bd4bda25', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(3, 'Vasy Tenant', 2, 'vasy.dragan+tenant@gmail.com', '$2y$10$3YLYHk4aF1NHIpzOu1naVeSRhIeEbYtaWdaq41C1bJGr2Jy/e1IHW', '26e66ba0fafa28f84ca8950f482e6a17', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(4, 'Razvan Admin', 0, 'razvan@rentomato.com', '$2y$10$1AfEwlCz.zUwDIAb9DXj5uohKwF0VxYttdtaTkoSzTUw.GtqOv8dC', '2b9c393a8e7d7dedbf9ba688fae7cce7', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(5, 'Razvan Landlord', 0, 'razvan+landlord@rentomato.com', '$2y$10$k2qyVssRfcx2NOdvN9hzm.pJw/OsVWvkzAqAwiC8Mn683dIVT3yrK', 'dffe317e8833a48ac5428c32e14785f2', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(6, 'Razvan Tenant', 5, 'razvan+tenant@rentomato.com', '$2y$10$FQe2iRs/SPSjaa6RCXfiwebEXrR.dQqVay2mOcHNyx0SlX2n3/MBu', '99a40f088a50fbcd5fd2ccddcbc56a94', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(7, 'Cos Admin', 0, 'cosinus84@gmail.com', '$2y$10$kBNpTP7X2lI.XYFlzzcQJOaSCcaNxe7hy4rbrh0OXZ7Rsww.QGt4e', 'e93b6ba285b5ccf1c5e5eff8e7354b27', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(8, 'Cos Landlord', 0, 'cosinus84+landlord@gmail.com', '$2y$10$EDMELfCPhsOdRtpK27r1fOONAhXiapitgi2kbwsWSTSEdxepiiiDO', '18c5c0e3ff69501337b75ff478e8ad6e', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:55:58', NULL, 1),
(9, 'Cos Tenant', 8, 'cosinus84+tenant@gmail.com', '$2y$10$mvubEHXhuPJoHN1WZQEoEOEIS0UI9WazVjYlDcYA2nvY79lNkytq2', '0fb32a70adc734a2d66fbcc81392012e', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(10, 'Dominik Admin', 0, 'dominik@rentomato.com', '$2y$10$Looc0svGxERaGcgxZ2HEueovkwflR0ReIL7grikMT6dPH94k8uSFq', 'd44d9b7d8f04fdfbcd98d9b5f18140e2', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(11, 'Dominik Landlord', 0, 'dominik+landlord@rentomato.com', '$2y$10$n8vEs1KSfaPs7.yR8Kapc.vv5Y1yKUF/wUbfxNqz9xd3.kHhH5DMe', 'd1f0566b727a3788027972e70d43612c', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(12, 'Dominik Tenant', 8, 'dominik+tenant@rentomato.com', '$2y$10$broI0lOwbqPRNQpzVpFQ0OmPN2LVtWyNSbGOonDoKcf/Nk7XsSIFu', '30463bb75c3a4fc9d5c7dbd98f4f7b10', 1, 1, NULL, 1, '2015-11-02 21:33:34', '2015-11-02 21:33:34', NULL, 0),
(13, 'Tom Admin', 0, 'tom@rentomato.com', '$2y$10$oLXxEzS1Q2CaSGCOi9L52ukqp8l/JJ.bG5u4217aKKxFqO9TaEzPO', '68903f8a8a8866f67c8be16f23be4901', 1, 1, NULL, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL, 0),
(14, 'Tom Landlord', 0, 'tom+landlord@rentomato.com', '$2y$10$hUSlt0N128iRmwy7w88L4uijACtgz6bKDySyLmb68ZAD.aK6fcpQ.', '492972a482e42cf62d5bee78c622a94d', 1, 1, NULL, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL, 0),
(15, 'Tom Tenant', 14, 'tom+tenant@rentomato.com', '$2y$10$.h28I2hadPjgYy90CVQ.BudLsjiks2lK3GUAIFA2aA/mam1BWJ71W', '6365798b992b63970d64ebf59a3888dc', 1, 1, NULL, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL, 0),
(16, 'Sander Admin', 0, 'sander@rentomato.com', '$2y$10$GpyCGuMKDKynnOmDGyklDuDECjtpL5Gxy.BxlM5qk2/kjZ9/4r3Xe', '572dd0e7aa69748018d9fd7b7fde01cd', 1, 1, NULL, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL, 0),
(17, 'Sander Landlord', 0, 'sander+landlord@rentomato.com', '$2y$10$o8pbr8bsSTm730cvXLfZpulKx0QVIq.Y.7eJAGCnPNRy0ALAEEhMi', 'bbdd63f48a77467c08000fda2d05f803', 1, 1, NULL, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL, 0),
(18, 'Sander Tenant', 18, 'sander+tenant@rentomato.com', '$2y$10$QRgTIjHrrOSvhjXK9fC7Zu3Y5x1UYi/1Ync5LfwQhmZ.xxcrtCSyu', 'dcc746810cb15d04068da8fcd3770936', 1, 1, NULL, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL, 0),
(19, 'Demo Manager', 0, 'info+manager@rentomato.com', '$2y$10$C.r96ERFSwNbh5chKWqZ6.ir2L8vDT0WSl0A3OjkT6l3oeuaHbgMe', '1d8a4b98861002aef90aa689984eab12', 1, 1, NULL, 1, '2015-11-02 21:33:35', '2015-11-02 21:33:35', NULL, 0),
(20, 'dasdaxzzzux', 8, 'caaosinus84@gmail.com', '$2y$10$jt6wm0C2EMe.iIICV/kyYOgN4Y3owG7n0leI6mETZdgsHRua1umdS', '', 1, 0, NULL, 1, '2015-11-09 21:31:22', '2015-11-11 13:47:16', NULL, 0),
(21, 'fsdfsd', 8, 'cosixxxnus84@gmail.com', '$2y$10$EJ540cohx0R7voMmm7sceOnm4ba2GdmC1A30clZnfeoabG06.EZNW', '', 1, 0, NULL, 1, '2015-11-09 21:35:15', '2015-11-09 21:35:15', NULL, 0),
(22, 'cos', 8, 'cos@yahoo.com', '$2y$10$vG2lOVfnNW/7gc9VZ3znY.spa9PBLsGGuMFzxE57GFIv5w8BcOVXC', '', 1, 0, NULL, 1, '2015-11-10 21:07:29', '2015-11-10 21:07:29', NULL, 0),
(23, 'csdas', 8, 'cosinusx84@yahoo.com', '$2y$10$mwSV1.dpW1mn9uTGPu6uou9iMiSVhVBAB1LiiG05SOfNFsKUWyXWa', '', 1, 0, NULL, 1, '2015-11-10 21:12:24', '2015-11-10 21:12:24', NULL, 0),
(24, 'csdas', 8, 'cosinuxxs84@yahoo.com', '$2y$10$g6SCptePQgLifpUO1XIZvOTRxedgQkw.gdsC3eH9.UwoFjmKrG5wK', '', 1, 0, NULL, 1, '2015-11-10 21:13:13', '2015-11-10 21:13:13', NULL, 0),
(25, 'dasda', 8, 'dasda@yahoo.com', '$2y$10$3aK.4cghX5KM9GU9ZWje0Og3RXCikb1xpHYL/jzD5XpgeqMTNfEQy', '', 1, 0, NULL, 1, '2015-11-10 21:16:06', '2015-11-10 21:16:06', NULL, 0),
(26, 'dasdas', 8, 'das@fdfad.com', '$2y$10$EvuipSWTkbWIzvd.tLZ73OmHHaCGATNVaGwNsY8PzUxhoVdVVwGVG', '', 1, 0, NULL, 1, '2015-11-10 21:17:36', '2015-11-10 21:17:36', NULL, 0),
(27, 'kkkkkautff', 8, 'dasds@fsdfs.com', '$2y$10$VFtoXY1ZV1t6DYc9VJKOP.ACirLcvVW9s03G4f8cvYeSnD2ZMgiE2', '', 1, 0, NULL, 1, '2015-11-10 21:25:32', '2015-11-11 10:01:50', NULL, 0),
(28, 'hggjgh', 8, 'cosinuxxs84@gmail.com', '$2y$10$UMtIUqGh9iXLvSHnyCh3Yem.oaxuMeRjJCksLvBaGIxwoppe5fK1K', '', 1, 0, NULL, 1, '2015-11-10 21:28:42', '2015-11-10 21:28:42', NULL, 0),
(29, 'aaaa', 8, 'cosindddus84@gmail.com', '$2y$10$xvtut0JVD5pOQqI7zr2sZe1vxlwcLqslSohWkUDCIpzG1WasHzP4q', '', 1, 0, NULL, 1, '2015-11-10 21:32:42', '2015-11-10 21:32:42', NULL, 0),
(30, 'dasdas', 8, 'cosinadasus84@gmail.com', '$2y$10$sx.XPIu0DtRLiMFJB598u.F6/wdONZTqycbwMRVDQWeYrbBI/9Ld6', '', 1, 0, NULL, 1, '2015-11-10 21:33:15', '2015-11-10 21:33:15', NULL, 0),
(31, 'rrrrrrr', 8, 'rere@rre.com', '$2y$10$azlW99XvmDgOTnLGd/r1WuNOLVRF44IPpDiRhGxGkITNSqNC3Utu2', '', 1, 0, NULL, 1, '2015-11-10 21:33:47', '2015-11-10 21:33:47', NULL, 0),
(32, 'bbb', 8, 'bb@bb.com', '$2y$10$jGO.kB9QVL.esyuyydgNaeNlpZXlk7cxmutKUPXWtFsdl917UVp6K', '', 1, 0, NULL, 1, '2015-11-10 21:40:34', '2015-11-10 21:40:34', NULL, 0),
(33, 'uuuuu', 8, 'das@u.com', '$2y$10$672FGaKlbBVzGGWa9eelYuNypxmuTAqfHPDqgDiRZbT.a/PAobqhm', '', 1, 0, NULL, 1, '2015-11-10 21:47:27', '2015-11-10 21:47:27', NULL, 0),
(34, 'sssss', 8, 'das@yahoo.om', '$2y$10$dDTeanM1gn1vCFdAbjU4.OjicWALwoxde6IKVSM.U8V8twnMWLv1y', '', 1, 0, NULL, 1, '2015-11-10 21:48:05', '2015-11-10 21:48:05', NULL, 0),
(35, 'yyyy', 8, 'yy@yy.com', '$2y$10$TqUxDOEYzcol0uWTAdSjeuOxzMhZrJF0QSmOVH1E0bcpXlEBUbWSC', '', 1, 0, NULL, 1, '2015-11-10 21:48:32', '2015-11-10 21:48:32', NULL, 0),
(36, 'fsdfsd', 8, 'fsdf@afsdf.com', '$2y$10$FumMIKki3E4FIgxyyG1zX.E5mGb8Yn1wLyZHhUgp1e5H5BslOJuJC', '', 1, 0, NULL, 1, '2015-11-11 08:12:59', '2015-11-11 08:12:59', NULL, 0),
(37, 'ttttt', 8, 'ttt@yahoo.com', '$2y$10$.ubLe0TOMM3G3RLss3ykC.JIeLD0HFEZiAXcP3BEbp0ZLL7MOer.e', '', 1, 0, NULL, 1, '2015-11-11 08:26:21', '2015-11-11 08:26:21', NULL, 0),
(38, 'fsdfsddasdas', 8, 'cosixxxrnus84@gmail.com', '$2y$10$g42N4k2x.X23ouCx62vwGOYwEf06Q5d.75da9MC8bO9Dpvd9JD1kS', '', 1, 0, NULL, 1, '2015-11-12 07:54:25', '2015-11-12 07:54:25', NULL, 0),
(39, 'dasdasasdihjhjhkj', 8, 'dasdas5454@yahoo.com', '$2y$10$NdJ4mr7sxPmWwEf05YvHP.5GdXL8XkzMExsPJDi9/mtuIkApVz4l6', '', 1, 0, NULL, 1, '2015-11-12 08:00:24', '2015-11-16 11:33:14', NULL, 0),
(40, 'fsdfsd', 8, 'cosiaszxxxnus84@gmail.com', '$2y$10$KROxiHMxVPX5m3OESRywbeKz6HwErW0n4FKIwEZYuRZctzYYcCtmq', '', 1, 0, NULL, 1, '2015-11-12 08:02:08', '2015-11-12 08:02:08', NULL, 0),
(41, 'dasdasaaazz', 8, 'cosinus84x@gmail.com', '$2y$10$WDv9J3aJGhDFY.BfqriglOxU1ValyzuGRGlr7yfUIjXjjw/l7h8YW', '', 1, 0, NULL, 1, '2015-11-20 09:52:14', '2015-11-20 09:52:14', NULL, 0),
(42, 'axte', 8, 'cxcx@czcz.com', '$2y$10$5wrngU9ronN6kXjoYIw2wOEaLjtbPHdWS7P9IjFHjWfNAwwhd1Q7S', '', 1, 0, NULL, 1, '2015-11-20 10:28:31', '2015-11-20 10:28:31', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_user_id_foreign` (`user_id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenity_categories`
--
ALTER TABLE `amenity_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenity_values`
--
ALTER TABLE `amenity_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `document_shares`
--
ALTER TABLE `document_shares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emails_user_id_foreign` (`user_id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folders_user_id_foreign` (`user_id`);

--
-- Indexes for table `help`
--
ALTER TABLE `help`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `i18n`
--
ALTER TABLE `i18n`
  ADD PRIMARY KEY (`id`),
  ADD KEY `i18n_user_id_foreign` (`user_id`),
  ADD KEY `i18n_language_id_foreign` (`language_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_user_id_foreign` (`user_id`),
  ADD KEY `invoices_landlord_id_foreign` (`landlord_id`),
  ADD KEY `invoices_tenant_id_foreign` (`tenant_id`),
  ADD KEY `invoices_property_id_foreign` (`property_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_lang_code_unique` (`lang_code`),
  ADD KEY `languages_user_id_foreign` (`user_id`),
  ADD KEY `languages_user_id_edited_foreign` (`user_id_edited`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`);

--
-- Indexes for table `message_tag`
--
ALTER TABLE `message_tag`
  ADD KEY `message_tag_message_id_foreign` (`message_id`),
  ADD KEY `message_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `message_user`
--
ALTER TABLE `message_user`
  ADD KEY `message_user_message_id_foreign` (`message_id`),
  ADD KEY `message_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_inherit_id_index` (`inherit_id`),
  ADD KEY `permissions_name_index` (`name`),
  ADD KEY `permissions_slug_index` (`slug`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_user_permission_id_index` (`permission_id`),
  ADD KEY `permission_user_user_id_index` (`user_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photos_language_id_foreign` (`language_id`),
  ADD KEY `photos_photo_album_id_foreign` (`photo_album_id`),
  ADD KEY `photos_user_id_foreign` (`user_id`),
  ADD KEY `photos_user_id_edited_foreign` (`user_id_edited`);

--
-- Indexes for table `photo_albums`
--
ALTER TABLE `photo_albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photo_albums_language_id_foreign` (`language_id`),
  ADD KEY `photo_albums_user_id_foreign` (`user_id`),
  ADD KEY `photo_albums_user_id_edited_foreign` (`user_id_edited`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`),
  ADD KEY `profiles_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_user_id_foreign` (`user_id`),
  ADD KEY `properties_property_type_id_foreign` (`property_type_id`),
  ADD KEY `properties_country_id_foreign` (`country_id`);

--
-- Indexes for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_photos`
--
ALTER TABLE `property_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_photos_property_id_foreign` (`property_id`);

--
-- Indexes for table `property_tenants`
--
ALTER TABLE `property_tenants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_tenants_property_id_foreign` (`property_id`),
  ADD KEY `property_tenants_user_id_foreign` (`user_id`);

--
-- Indexes for table `property_transactions`
--
ALTER TABLE `property_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_transactions_property_id_foreign` (`property_id`),
  ADD KEY `property_transactions_unit_id_foreign` (`unit_id`),
  ADD KEY `property_transactions_transaction_recurring_id_foreign` (`transaction_recurring_id`),
  ADD KEY `property_transactions_transaction_category_id_foreign` (`transaction_category_id`);

--
-- Indexes for table `property_types`
--
ALTER TABLE `property_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_type_amenities`
--
ALTER TABLE `property_type_amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_user_transactions`
--
ALTER TABLE `property_user_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_user_transactions_user_id_foreign` (`user_id`),
  ADD KEY `property_user_transactions_transaction_type_id_foreign` (`transaction_type_id`),
  ADD KEY `property_user_transactions_property_transaction_id_foreign` (`property_transaction_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_user_role_id_index` (`role_id`),
  ADD KEY `role_user_user_id_index` (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_user_id_foreign` (`user_id`);

--
-- Indexes for table `transaction_categories`
--
ALTER TABLE `transaction_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_categories_user_id_foreign` (`user_id`),
  ADD KEY `transaction_categories_transaction_recurring_id_foreign` (`transaction_recurring_id`);

--
-- Indexes for table `transaction_recurrings`
--
ALTER TABLE `transaction_recurrings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_types`
--
ALTER TABLE `transaction_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `amenity_categories`
--
ALTER TABLE `amenity_categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `amenity_values`
--
ALTER TABLE `amenity_values`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `document_shares`
--
ALTER TABLE `document_shares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `help`
--
ALTER TABLE `help`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `i18n`
--
ALTER TABLE `i18n`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `permission_user`
--
ALTER TABLE `permission_user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `photo_albums`
--
ALTER TABLE `photo_albums`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=203;
--
-- AUTO_INCREMENT for table `property_amenities`
--
ALTER TABLE `property_amenities`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `property_photos`
--
ALTER TABLE `property_photos`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `property_tenants`
--
ALTER TABLE `property_tenants`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `property_transactions`
--
ALTER TABLE `property_transactions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `property_types`
--
ALTER TABLE `property_types`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `property_type_amenities`
--
ALTER TABLE `property_type_amenities`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `property_user_transactions`
--
ALTER TABLE `property_user_transactions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction_categories`
--
ALTER TABLE `transaction_categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `transaction_recurrings`
--
ALTER TABLE `transaction_recurrings`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `transaction_types`
--
ALTER TABLE `transaction_types`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `emails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `folders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `i18n`
--
ALTER TABLE `i18n`
  ADD CONSTRAINT `i18n_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `i18n_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_landlord_id_foreign` FOREIGN KEY (`landlord_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_tenant_id_foreign` FOREIGN KEY (`tenant_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_user_id_edited_foreign` FOREIGN KEY (`user_id_edited`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `languages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `message_tag`
--
ALTER TABLE `message_tag`
  ADD CONSTRAINT `message_tag_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`),
  ADD CONSTRAINT `message_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Constraints for table `message_user`
--
ALTER TABLE `message_user`
  ADD CONSTRAINT `message_user_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`),
  ADD CONSTRAINT `message_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_inherit_id_foreign` FOREIGN KEY (`inherit_id`) REFERENCES `permissions` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `photos_photo_album_id_foreign` FOREIGN KEY (`photo_album_id`) REFERENCES `photo_albums` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `photos_user_id_edited_foreign` FOREIGN KEY (`user_id_edited`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `photos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `photo_albums`
--
ALTER TABLE `photo_albums`
  ADD CONSTRAINT `photo_albums_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `photo_albums_user_id_edited_foreign` FOREIGN KEY (`user_id_edited`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `photo_albums_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `properties_property_type_id_foreign` FOREIGN KEY (`property_type_id`) REFERENCES `property_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `property_photos`
--
ALTER TABLE `property_photos`
  ADD CONSTRAINT `property_photos_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `property_tenants`
--
ALTER TABLE `property_tenants`
  ADD CONSTRAINT `property_tenants_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `property_tenants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `property_transactions`
--
ALTER TABLE `property_transactions`
  ADD CONSTRAINT `property_transactions_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `property_transactions_transaction_category_id_foreign` FOREIGN KEY (`transaction_category_id`) REFERENCES `transaction_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `property_transactions_transaction_recurring_id_foreign` FOREIGN KEY (`transaction_recurring_id`) REFERENCES `transaction_recurrings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `property_transactions_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `properties` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `property_user_transactions`
--
ALTER TABLE `property_user_transactions`
  ADD CONSTRAINT `property_user_transactions_property_transaction_id_foreign` FOREIGN KEY (`property_transaction_id`) REFERENCES `property_transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `property_user_transactions_transaction_type_id_foreign` FOREIGN KEY (`transaction_type_id`) REFERENCES `transaction_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `property_user_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaction_categories`
--
ALTER TABLE `transaction_categories`
  ADD CONSTRAINT `transaction_categories_transaction_recurring_id_foreign` FOREIGN KEY (`transaction_recurring_id`) REFERENCES `transaction_recurrings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaction_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
