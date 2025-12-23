-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 21, 2021 at 03:36 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

DROP TABLE IF EXISTS `vehicle_types`;
CREATE TABLE IF NOT EXISTS `vehicle_types` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `station_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>Active, 0=>Inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `added_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_types_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `station_id`, `name`, `status`, `deleted_at`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Car', 1, NULL, 0, NULL, '2021-03-02 06:57:12', '2021-03-02 06:57:12'),
(2, 1, 'Bike', 1, NULL, 0, NULL, '2021-03-02 06:57:03', '2021-03-02 06:57:03'),
(5, 2, 'Car', 1, '2021-12-21 03:34:38', 0, NULL, '2021-04-07 05:36:16', '2021-12-21 03:34:38'),
(6, 2, 'Bike', 1, '2021-12-21 03:34:36', 0, NULL, '2021-04-07 05:36:24', '2021-12-21 03:34:36'),
(7, 3, 'Car', 1, '2021-12-21 03:34:32', 0, NULL, '2021-12-21 03:09:46', '2021-12-21 03:34:32'),
(8, 3, 'Bike', 1, '2021-12-21 03:34:28', 0, NULL, '2021-12-21 03:09:55', '2021-12-21 03:34:28');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
