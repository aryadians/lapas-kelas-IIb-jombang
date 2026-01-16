-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2026 at 12:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lapasjombang`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `event`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'user', 'Data User telah dicreated', 'App\\Models\\User', 1, 'created', NULL, NULL, '{\"attributes\":{\"name\":\"Administrator\",\"email\":\"admin@lapasjombang.go.id\"}}', NULL, '2026-01-16 00:19:50', '2026-01-16 00:19:50'),
(2, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 1, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(3, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 2, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(4, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 3, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(5, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 4, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(6, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 5, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(7, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 6, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(8, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 7, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(9, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 8, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(10, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 9, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(11, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 10, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(12, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 11, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(13, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 12, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(14, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 13, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(15, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 14, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(16, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 15, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(17, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 16, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(18, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 17, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(19, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 18, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(20, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 19, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(21, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 20, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(22, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 21, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(23, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 22, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(24, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 23, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(25, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 24, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(26, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 25, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(27, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 26, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(28, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 27, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(29, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 28, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(30, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 29, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(31, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 30, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(32, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 31, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(33, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 32, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(34, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 33, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(35, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 34, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(36, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 35, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(37, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 36, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(38, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 37, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(39, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 38, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(40, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 39, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(41, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 40, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(42, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 41, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(43, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 42, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(44, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 43, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(45, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 44, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(46, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 45, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(47, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 46, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(48, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 47, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(49, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 48, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(50, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 49, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(51, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 50, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(52, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 51, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(53, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 52, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(54, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 53, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(55, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 54, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(56, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 55, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(57, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 56, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(58, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 57, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(59, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 58, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(60, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 59, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(61, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 60, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(62, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 61, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(63, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 62, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(64, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 63, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(65, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 64, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(66, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 65, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(67, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 66, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(68, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 67, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(69, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 68, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(70, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 69, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(71, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 70, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(72, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 71, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(73, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 72, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(74, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 73, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(75, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 74, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(76, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 75, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(77, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 76, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(78, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 77, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(79, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 78, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(80, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 79, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(81, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 80, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(82, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 81, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(83, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 82, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(84, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 83, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(85, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 84, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(86, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 85, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(87, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 86, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(88, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 87, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(89, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 88, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(90, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 89, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(91, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 90, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(92, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 91, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(93, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 92, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(94, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 93, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(95, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 94, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(96, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 95, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(97, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 96, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(98, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 97, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(99, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 98, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(100, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 99, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(101, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 100, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(102, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 101, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(103, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 102, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(104, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 103, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(105, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 104, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(106, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 105, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(107, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 106, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(108, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 107, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(109, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 108, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(110, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 109, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(111, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 110, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(112, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 111, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(113, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 112, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(114, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 113, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(115, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 114, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(116, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 115, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(117, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 116, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(118, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 117, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(119, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 118, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(120, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 119, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(121, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 120, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(122, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 121, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(123, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 122, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(124, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 123, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(125, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 124, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(126, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 125, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(127, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 126, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(128, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 127, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(129, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 128, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(130, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 129, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(131, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 130, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(132, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 131, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(133, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 132, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(134, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 133, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(135, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 134, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(136, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 135, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(137, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 136, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(138, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 137, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(139, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 138, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(140, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 139, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(141, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 140, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(142, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 141, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(143, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 142, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(144, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 143, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(145, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 144, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(146, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 145, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(147, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 146, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(148, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 147, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(149, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 148, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(150, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 149, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(151, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 150, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(152, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 151, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(153, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 152, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(154, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 153, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(155, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 154, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(156, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 155, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(157, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 156, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(158, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 157, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(159, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 158, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(160, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 159, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(161, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 160, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(162, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 161, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(163, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 162, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(164, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 163, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(165, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 164, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(166, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 165, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(167, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 166, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(168, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 167, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(169, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 168, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(170, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 169, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(171, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 170, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(172, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 171, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(173, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 172, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(174, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 173, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(175, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 174, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(176, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 175, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(177, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 176, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(178, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 177, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(179, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 178, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(180, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 179, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(181, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 180, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(182, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 181, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(183, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 182, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(184, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 183, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(185, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 184, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(186, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 185, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(187, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 186, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(188, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 187, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(189, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 188, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(190, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 189, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(191, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 190, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(192, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 191, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(193, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 192, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(194, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 193, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(195, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 194, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(196, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 195, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(197, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 196, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(198, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 197, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(199, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 198, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(200, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 199, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(201, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 200, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(202, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 201, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(203, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 202, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(204, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 203, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(205, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 204, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(206, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 205, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(207, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 206, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(208, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 207, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(209, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 208, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(210, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 209, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(211, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 210, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(212, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 211, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(213, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 212, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(214, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 213, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(215, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 214, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(216, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 215, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(217, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 216, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(218, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 217, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(219, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 218, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(220, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 219, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(221, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 220, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(222, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 221, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(223, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 222, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(224, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 223, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(225, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 224, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(226, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 225, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(227, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 226, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(228, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 227, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(229, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 228, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(230, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 229, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(231, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 230, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(232, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 231, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(233, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 232, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(234, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 233, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(235, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 234, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(236, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 235, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(237, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 236, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(238, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 237, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(239, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 238, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(240, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 239, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(241, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 240, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(242, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 241, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(243, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 242, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(244, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 243, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(245, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 244, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(246, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 245, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(247, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 246, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(248, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 247, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(249, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 248, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(250, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 249, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(251, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 250, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(252, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 251, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(253, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 252, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(254, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 253, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(255, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 254, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(256, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 255, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(257, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 256, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(258, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 257, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(259, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 258, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(260, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 259, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(261, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 260, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(262, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 261, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(263, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 262, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(264, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 263, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(265, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 264, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(266, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 265, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(267, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 266, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(268, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 267, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(269, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 268, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(270, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 269, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(271, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 270, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(272, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 271, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(273, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 272, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(274, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 273, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(275, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 274, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(276, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 275, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(277, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 276, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(278, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 277, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(279, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 278, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(280, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 279, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(281, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 280, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(282, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 281, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(283, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 282, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(284, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 283, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(285, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 284, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(286, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 285, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(287, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 286, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(288, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 287, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(289, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 288, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(290, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 289, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(291, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 290, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(292, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 291, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(293, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 292, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(294, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 293, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(295, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 294, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(296, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 295, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(297, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 296, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(298, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 297, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(299, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 298, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(300, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 299, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(301, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 300, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(302, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 301, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(303, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 302, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(304, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 303, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(305, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 304, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(306, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 305, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(307, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 306, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(308, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 307, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(309, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 308, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(310, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 309, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(311, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 310, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(312, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 311, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(313, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 312, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(314, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 313, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(315, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 314, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(316, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 315, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `event`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(317, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 316, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(318, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 317, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(319, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 318, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(320, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 319, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(321, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 320, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(322, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 321, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(323, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 322, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(324, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 323, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(325, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 324, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(326, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 325, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(327, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 326, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(328, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 327, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(329, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 328, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(330, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 329, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(331, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 330, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(332, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 331, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(333, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 332, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(334, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 333, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(335, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 334, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(336, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 335, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(337, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 336, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(338, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 337, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(339, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 338, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(340, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 339, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(341, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 340, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(342, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 341, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(343, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 342, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(344, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 343, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(345, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 344, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(346, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 345, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(347, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 346, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(348, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 347, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(349, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 348, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(350, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 349, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(351, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 350, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(352, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 351, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(353, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 352, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(354, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 353, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(355, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 354, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(356, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 355, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(357, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 356, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(358, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 357, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(359, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 358, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(360, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 359, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(361, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 360, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(362, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 361, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(363, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 362, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(364, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 363, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(365, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 364, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(366, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 365, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(367, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 366, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(368, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 367, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(369, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 368, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(370, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 369, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(371, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 370, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(372, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 371, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(373, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 372, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(374, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 373, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(375, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 374, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(376, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 375, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(377, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 376, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(378, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 377, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(379, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 378, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(380, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 379, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(381, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 380, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(382, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 381, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(383, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 382, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(384, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 383, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(385, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 384, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(386, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 385, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(387, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 386, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(388, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 387, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(389, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 388, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(390, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 389, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(391, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 390, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(392, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 391, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(393, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 392, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(394, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 393, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(395, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 394, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(396, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 395, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(397, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 396, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(398, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 397, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(399, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 398, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(400, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 399, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(401, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 400, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(402, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 401, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(403, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 402, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(404, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 403, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(405, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 404, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(406, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 405, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(407, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 406, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(408, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 407, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(409, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 408, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(410, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 409, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(411, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 410, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(412, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 411, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(413, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 412, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(414, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 413, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(415, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 414, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(416, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 415, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(417, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 416, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(418, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 417, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(419, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 418, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(420, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 419, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(421, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 420, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(422, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 421, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(423, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 422, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(424, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 423, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(425, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 424, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(426, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 425, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(427, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 426, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(428, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 427, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(429, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 428, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(430, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 429, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(431, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 430, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(432, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 431, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(433, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 432, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(434, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 433, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(435, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 434, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(436, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 435, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(437, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 436, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(438, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 437, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(439, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 438, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(440, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 439, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(441, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 440, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(442, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 441, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(443, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 442, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(444, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 443, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(445, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 444, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(446, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 445, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(447, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 446, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(448, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 447, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(449, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 448, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(450, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 449, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(451, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 450, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(452, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 451, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(453, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 452, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(454, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 453, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(455, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 454, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(456, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 455, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(457, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 456, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(458, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 457, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(459, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 458, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(460, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 459, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(461, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 460, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(462, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 461, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(463, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 462, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(464, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 463, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(465, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 464, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(466, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 465, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(467, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 466, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(468, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 467, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(469, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 468, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(470, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 469, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(471, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 470, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(472, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 471, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(473, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 472, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(474, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 473, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(475, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 474, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(476, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 475, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(477, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 476, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(478, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 477, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(479, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 478, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(480, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 479, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(481, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 480, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(482, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 481, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(483, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 482, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(484, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 483, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(485, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 484, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(486, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 485, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(487, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 486, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(488, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 487, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(489, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 488, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(490, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 489, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(491, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 490, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(492, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 491, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(493, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 492, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(494, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 493, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(495, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 494, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(496, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 495, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(497, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 496, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(498, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 497, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(499, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 498, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(500, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 499, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(501, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 500, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(502, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 501, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(503, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 502, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(504, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 503, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(505, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 504, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(506, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 505, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(507, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 506, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(508, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 507, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(509, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 508, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(510, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 509, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(511, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 510, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(512, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 511, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(513, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 512, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(514, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 513, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(515, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 514, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(516, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 515, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(517, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 516, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(518, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 517, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(519, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 518, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(520, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 519, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(521, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 520, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(522, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 521, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(523, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 522, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(524, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 523, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(525, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 524, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(526, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 525, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(527, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 526, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(528, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 527, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(529, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 528, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(530, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 529, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(531, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 530, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(532, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 531, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(533, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 532, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(534, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 533, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(535, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 534, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(536, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 535, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(537, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 536, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(538, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 537, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(539, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 538, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(540, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 539, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(541, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 540, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(542, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 541, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(543, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 542, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(544, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 543, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(545, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 544, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(546, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 545, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(547, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 546, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(548, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 547, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(549, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 548, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(550, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 549, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(551, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 550, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(552, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 551, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(553, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 552, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(554, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 553, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(555, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 554, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(556, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 555, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(557, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 556, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(558, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 557, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(559, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 558, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(560, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 559, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(561, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 560, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(562, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 561, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(563, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 562, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(564, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 563, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(565, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 564, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(566, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 565, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(567, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 566, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(568, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 567, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(569, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 568, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(570, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 569, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(571, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 570, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(572, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 571, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(573, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 572, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(574, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 573, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(575, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 574, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(576, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 575, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(577, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 576, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(578, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 577, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(579, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 578, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(580, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 579, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(581, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 580, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(582, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 581, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(583, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 582, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(584, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 583, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(585, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 584, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(586, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 585, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(587, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 586, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(588, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 587, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(589, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 588, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(590, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 589, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(591, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 590, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(592, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 591, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(593, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 592, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(594, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 593, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(595, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 594, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(596, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 595, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(597, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 596, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(598, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 597, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(599, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 598, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(600, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 599, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(601, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 600, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(602, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 601, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(603, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 602, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(604, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 603, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(605, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 604, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(606, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 605, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(607, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 606, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(608, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 607, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(609, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 608, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(610, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 609, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(611, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 610, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(612, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 611, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(613, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 612, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(614, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 613, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(615, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 614, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(616, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 615, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(617, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 616, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(618, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 617, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(619, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 618, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(620, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 619, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(621, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 620, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(622, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 621, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(623, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 622, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(624, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 623, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(625, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 624, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(626, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 625, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(627, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 626, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(628, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 627, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(629, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 628, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(630, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 629, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(631, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 630, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `event`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(632, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 631, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(633, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 632, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(634, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 633, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(635, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 634, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(636, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 635, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(637, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 636, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(638, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 637, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(639, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 638, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(640, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 639, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(641, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 640, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(642, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 641, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(643, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 642, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(644, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 643, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(645, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 644, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(646, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 645, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(647, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 646, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(648, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 647, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(649, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 648, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(650, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 649, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(651, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 650, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(652, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 651, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(653, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 652, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(654, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 653, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(655, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 654, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(656, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 655, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(657, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 656, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(658, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 657, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(659, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 658, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(660, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 659, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(661, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 660, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(662, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 661, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(663, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 662, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(664, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 663, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(665, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 664, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(666, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 665, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(667, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 666, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(668, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 667, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(669, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 668, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(670, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 669, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(671, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 670, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(672, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 671, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(673, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 672, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(674, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 673, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(675, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 674, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(676, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 675, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(677, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 676, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(678, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 677, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(679, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 678, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(680, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 679, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(681, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 680, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(682, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 681, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(683, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 682, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(684, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 683, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(685, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 684, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(686, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 685, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(687, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 686, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(688, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 687, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(689, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 688, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(690, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 689, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(691, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 690, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(692, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 691, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(693, 'wbp', 'Data WBP telah dicreated', 'App\\Models\\Wbp', 692, 'created', 'App\\Models\\User', 1, '[]', NULL, '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(694, 'kunjungan', 'Data Kunjungan telah dicreated', 'App\\Models\\Kunjungan', 1, 'created', 'App\\Models\\User', 1, '{\"attributes\":{\"kode_kunjungan\":\"VIS-XXUYPA\",\"nomor_antrian_harian\":1,\"wbp_id\":43,\"nama_pengunjung\":\"Arya Dian\",\"nik_ktp\":\"1234567890000001\",\"no_wa_pengunjung\":\"083845529777\",\"email_pengunjung\":\"aryadian003@gmail.com\",\"alamat_pengunjung\":\"Jl Srikandi RT\\/RW 004\\/001, Ds. Bandar Kedung Mulyo\",\"barang_bawaan\":\"kecap\",\"jenis_kelamin\":\"Laki-laki\",\"hubungan\":\"Anak\",\"tanggal_kunjungan\":\"2026-01-18T17:00:00.000000Z\",\"sesi\":\"pagi\",\"foto_ktp\":\"uploads\\/ktp\\/hYlbSoiSP24HLgpZhcTnrRXfRLbL7amPfmxQ5eBL.jpg\",\"status\":\"pending\",\"qr_token\":\"9d1ad382-bcdd-4816-aae4-1c540404b91a\",\"pengikut_laki\":0,\"pengikut_perempuan\":0,\"pengikut_anak\":0,\"registration_type\":\"online\",\"visit_started_at\":null,\"visit_ended_at\":null}}', NULL, '2026-01-16 00:25:34', '2026-01-16 00:25:34'),
(695, 'kunjungan', 'Data Kunjungan telah diupdated', 'App\\Models\\Kunjungan', 1, 'updated', 'App\\Models\\User', 1, '{\"attributes\":{\"status\":\"approved\"},\"old\":{\"status\":\"pending\"}}', NULL, '2026-01-16 00:27:05', '2026-01-16 00:27:05'),
(696, 'user', 'Data User telah dicreated', 'App\\Models\\User', 2, 'created', 'App\\Models\\User', 1, '{\"attributes\":{\"name\":\"Arya Dian Saputra\",\"email\":\"aryadian003@gmail.com\"}}', NULL, '2026-01-16 04:07:00', '2026-01-16 04:07:00'),
(697, 'kunjungan', 'Data Kunjungan telah dicreated', 'App\\Models\\Kunjungan', 2, 'created', NULL, NULL, '{\"attributes\":{\"profil_pengunjung_id\":2,\"kode_kunjungan\":\"VIS-7PODGJ\",\"nomor_antrian_harian\":2,\"wbp_id\":196,\"nama_pengunjung\":\"Mellyana Tundjung\",\"nik_ktp\":\"3517185508002009\",\"no_wa_pengunjung\":\"0881011388375\",\"email_pengunjung\":\"tundjungmelly@gmail.com\",\"alamat_pengunjung\":\"Jombang, Jawa Timur\",\"barang_bawaan\":\"hekjrfuw\",\"jenis_kelamin\":\"Perempuan\",\"hubungan\":\"Orang Tua\",\"tanggal_kunjungan\":\"2026-01-18T17:00:00.000000Z\",\"sesi\":\"pagi\",\"foto_ktp\":\"uploads\\/ktp\\/KUfV514tik2cOuhz3hy9XROlp1Tdw8OIug86v0t6.jpg\",\"status\":\"pending\",\"qr_token\":\"97ee336b-86d5-4ccd-a1aa-d3e50dcc43a7\",\"pengikut_laki\":0,\"pengikut_perempuan\":0,\"pengikut_anak\":0,\"registration_type\":\"online\",\"visit_started_at\":null,\"visit_ended_at\":null}}', NULL, '2026-01-16 10:06:07', '2026-01-16 10:06:07'),
(698, 'kunjungan', 'Data Kunjungan telah dicreated', 'App\\Models\\Kunjungan', 3, 'created', NULL, NULL, '{\"attributes\":{\"profil_pengunjung_id\":3,\"kode_kunjungan\":\"VIS-6JCVM5\",\"nomor_antrian_harian\":3,\"wbp_id\":35,\"nama_pengunjung\":\"Mellyana Tundjung\",\"nik_ktp\":\"3517185508102009\",\"no_wa_pengunjung\":\"0881011388375\",\"email_pengunjung\":\"tundjungmelly@gmail.com\",\"alamat_pengunjung\":\"Jombang, Jawa Timur\",\"barang_bawaan\":\"hekjrfuw\",\"jenis_kelamin\":\"Perempuan\",\"hubungan\":\"Orang Tua\",\"tanggal_kunjungan\":\"2026-01-18T17:00:00.000000Z\",\"sesi\":\"pagi\",\"foto_ktp\":\"uploads\\/ktp\\/QbH90i7MWBBi2hVYHofyaUZGhnfo667OtQnjT6V0.jpg\",\"status\":\"pending\",\"qr_token\":\"2d83eb70-65c7-4ce6-8915-fa833beffda5\",\"pengikut_laki\":0,\"pengikut_perempuan\":0,\"pengikut_anak\":0,\"registration_type\":\"online\",\"visit_started_at\":null,\"visit_ended_at\":null}}', NULL, '2026-01-16 10:10:31', '2026-01-16 10:10:31');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `event`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(699, 'kunjungan', 'Data Kunjungan telah dicreated', 'App\\Models\\Kunjungan', 4, 'created', 'App\\Models\\User', 1, '{\"attributes\":{\"profil_pengunjung_id\":4,\"kode_kunjungan\":\"VIS-AR3EIO\",\"nomor_antrian_harian\":4,\"wbp_id\":19,\"nama_pengunjung\":\"Mellyana Tundjung\",\"nik_ktp\":\"3517185508102909\",\"no_wa_pengunjung\":\"0881011388375\",\"email_pengunjung\":\"tundjungmelly@gmail.com\",\"alamat_pengunjung\":\"Jombang, Jawa Timur\",\"barang_bawaan\":\"hekjrfuw\",\"jenis_kelamin\":\"Perempuan\",\"hubungan\":\"Orang Tua\",\"tanggal_kunjungan\":\"2026-01-18T17:00:00.000000Z\",\"sesi\":\"pagi\",\"foto_ktp\":\"data:image\\/jpeg;base64,\\/9j\\/4AAQSkZJRgABAQAAAQABAAD\\/2wCEAAYGBgYHBgcICAcKCwoLCg8ODAwODxYQERAREBYiFRkVFRkVIh4kHhweJB42KiYmKjY+NDI0PkxERExfWl98fKcBBgYGBgcGBwgIBwoLCgsKDw4MDA4PFhAREBEQFiIVGRUVGRUiHiQeHB4kHjYqJiYqNj40MjQ+TERETF9aX3x8p\\/\\/CABEIBAAEAAMBIgACEQEDEQH\\/xAAxAAEAAwEBAQAAAAAAAAAAAAAABAUGAQMCAQEBAQEBAQAAAAAAAAAAAAAAAQIEAwX\\/2gAMAwEAAhADEAAAAsoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA7JuYqwr69\\/C5ZtMFAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHonmny\\/byrZct7+POvD084MY+f33NxT3CVFLsahaUSgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPr59rJFh8ffdxB6YVE6q5OkOfoubinuLkCppNjVLRiUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAATdZ87Trt4x5bx9fVVJ8faH5HH1AtzcU9xcgAVdFsaxaF3koAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADqz3j5mHdxj4ueVH15cXZ98+Xl6AoFzcU9xcgAAVtDsK5c+JQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAH0td+fJB3cYanKn0icfWHh7AAAXFzTXNyAAA53hkfn6+ZoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB9ctd477nfxBYg+tVzdAcvSAAABcXNNc3IAADneGR+fr5mgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHeWWsfUo7+MNZef3VeXp4\\/Jw9gKAAABcXNNc3IAADneGR+fr5mgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABJs9Z7vfxBvA8ZY0DvPn9wZ0AAAABcXNNc3IAADneGS+Pv4mgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB0+7fz9u3k6PbxA5Uyq7k6g5\\/cAAADv3c16QgtvdUt1cgAAPjmdI\\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\\/N1zGqJe+WN060+Mark3zzqM9fLGrexy41\\/1kJVePj9\\/EsvTZnTXIVEzOmzOaCgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAATtHjtPZK+fomah67OywwvvY0\\/fXzu0Gb183e8bx0AAAHXCdAAAAAABzn0PHwmsbq\\/C755elEt4nj6x72g+fL02Hczd2MzpszKCgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAJ8AbFBnXLnRQVuxq1on18yvv4JOmUvfbzu+1Uro8Zb4+vXz6EAABOudAAoAAAAAAI+Ic9jdHy5reTp94B5eoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHvqMhaJeiwDxo9EMc01PLBCgPbxJN9qx64uPSj7vF32n9PTFor\\/AE1mYi+ms+7z+9Z64s6AAAAAAABzvCDAvYfL01w5ugAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADQWOQ0lksIAB4Vl0Mr4bCOuXXUOIL081AAAAA+vrzJ7fcZqTPuA1mz9KhrN39UX3vN2qvb0856P7euPoXIHAAQYF7V8nVGHP7gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPTzGok5LRWSwgAAAHPCQK\\/wALcUXjoxmPPV8XJfGv6Y9rfmMo1XkZppPIoF55FQsPEivTzUB9fIkyqx6ed52kle\\/jYvP09\\/ELHz9Fpfi0q\\/n9oY2AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA+vkX9ljrNL58fdgAAAAAAAAAAAAHPP1ECJdDMxdh5rkl9XRCd4vZURc3X3ST+rnmDo8FTbeHl61I4ewAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD1uaEmw7lbay0fH2AAAAAAAAAAAAAAAeFVeDIfOrp5ax3iyLOk9fbxuHx99nLVR7Sr4ewPP0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA+5teTQTckNiy0qr9USEno3qejg6AAAAAAAAAAACJQ6n4Misq2X1tqT29fO3priB7eUIcnUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB308h7fUcSexSSkUSuxBLRBN+oAsfqsFv90ov\\/bNDW\\/eP9DWs3KsukKWfQFRbjHL6hlly6mz9\\/Gsd54e4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD7+BYWWdJsO5S1stqi1+jHfc+tl9fIAUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD2us+TXZiXPrPCUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABKiiXE+\\/gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\\/8QAAv\\/aAAwDAQACAAMAAAAhAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALIvAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHeOfgDEIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQW8SAPOwIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEn5lDADqmYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABE\\/xTAAX+++IIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADH4AAAAA\\/+++qAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOhEMAAAAA9+++qIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHiCahAAAAA1++++oAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAaCEgAAAAAAV++++AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA0DAoAAAAELA9+++pJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAL9DRhAAAAkpA1++lgfBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAX0\\/DoAAAAIe5AV+5gAXvNAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD8\\/SAAAAGe+sA9+KAAf+\\/JAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUq2\\/6AAAAR++8AV+CAA\\/+uKAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAWB2\\/CAAAA9++8A1+CAAX++iAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA2DSuhAAAAd++8AV+CAAf++rAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAeLDuAAAAWq\\/+0Ad+iAA3+3EJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACcvDXAAAGKri+9AV+CAAfqhUvJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEQ+LQIAAX4LC+5A9+iAAfqB8+qAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQpQvLJAADyrG+5A9+KAA3qBc6qAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAATJApC+rDAA78rC+pA1+iAA\\/qp8+iAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAecAvK2vBlArArW+pAV+qAA3qp8+iAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAXXBxqS\\/rBsCCjW+tAd+qAA\\/qp8+CAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIhR2C2rCQQvhCIFA16iAA3qp0yCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHfAnCWvDGe+cVpjAoLKAAWop88CAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQ7AAwY\\/LCy+\\/zzSghEKBHCog94CAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAs+uAEyvDC2+PDCCCG+u+Y2FjnKAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAbuAIBisMC2+\\/LCAU888oACiHgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAH++bvIAzQ2967LDCSyyiCCCWCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQ8+CqXMLAAAAAARhBDmFMCC+uAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQ86OO+yy\\/dA4KGHDNIAAhX+\\/siAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQC2y6yCCCCCiiCCqivAPADS3cAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB9+OCSyCGKOiCqC6CCDKA3upAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAARGILfiGOOOOOOOKCCCHBGCAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAghxhRBBTzSFPCSljIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAztTDDAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAATEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA\\/8QAAv\\/aAAwDAQACAAMAAAAQ88888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888891288888888888888888888888888888888888888888888888888888888884\\/xMe88088888888888888888888888888888888888888888888888888888888tDS38wzI88888888888888888888888888888888888888888888888888888889gDSc8VXbU08888888888888888888888888888888888888888888888888888uJCFd88BDDDk088888888888888888888888888888888888888888888888888r6CU8888oDDDXU8888888888888888888888888888888888888888888888888uc7v88888LDDDX0888888888888888888888888888888888888888888888888ri9z\\/wDPPPPCwwww\\/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPkAfvvPPPPPAwwww1PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPODgDxvPPPPCPKwwwy0\\/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPKfwAH\\/PPPEA\\/Cww1\\/BF\\/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLafQHPPPPNY0\\/Awy\\/PIIH\\/ADzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzYP0J7zzzOMMbyMN\\/zwgPB\\/zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz70n0zzzzycMNLwMNfzyANNfzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzpYlV7zzzysMNLwsPfzyAMN\\/zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzxdC0P\\/AM888rDDW8jD388IDDW888888888888888888888888888888888888888843J8X88887\\/KDe8LD388ADBJ38888888888888888888888888888888888888888DtUo888zXULDX8nLX88EX3oAX888888888888888888888888888888888888888nUJn888AF8rDT8\\/r3888\\/XUDX88888888888888888888888888888888888888s6vlIe88UPcvDX8fjf88QTXgHf888888888888888888888888888888888888t\\/rq1QpS88sBUrzj87j3880T\\/QD3888888888888888888888888888888888888nC8uZItB98Q9U\\/DH8HH\\/wDPFH\\/0A9\\/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPJCf5KbFaBGL+3Kw0\\/Gw1\\/PHF\\/wA1\\/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPOv+XfSKXb\\/R\\/6\\/e\\/Cx3\\/PCk\\/yD1\\/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPKpfGNaLVOYAD7FdfPcN\\/PAxP0gV\\/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLJsfPb1SPTUv8oA8Ydu8ff4PAxP8AzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzxlN\\/wAOBtQ9K2PCX\\/8AuggkdyfhOF\\/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLrk\\/PLzLAPykvyk\\/aAAAFPLgEPvPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPCgw1GPPLjfrCfASN7jjnvugxWPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLJA\\/wBfj3Hzzzzzx+x132MQMP8A5f8APPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLIh88wz30A3De98sM9PPDmM4EFfPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLHwzxz\\/8A\\/wD\\/AP33\\/wD9Z9BjDR+8Hbzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzx8svP+8\\/8A73zf\\/X\\/H\\/wDjO9KXnvPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPH31uIH888888889\\/\\/AO8n8s3zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzywz\\/wDv\\/wD3zPj9\\/vz9+vPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLBypPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPePPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPHPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP\\/EAD0RAAIBAgMFBQQHBwUBAAAAAAECAwAEEBExBRIhMlEgIkFQcQYTUmEUIzBCkbHRM0BDYmOBwWByc5Chgv\\/aAAgBAgEBPwD\\/ALYIbeec5RRs3oKubaS2cJIV3iMyAc8q3e7mPO0R5GCopY9AMzVvsK7kyMmUQ+fE1b7FsosiymRurafhUskVtA7kAIgzyHCppXmleR9WOZpeUUy+I86iSR5FWMEsTwArZ9vPBAFmmZ26E5hcNvXm862yngvF\\/XwGC8owZfEecW1rNcyiOJcz4nwA6mrDZ8Nmnd7znmepZY4o2kkYKo1NQ7YDwXc7KAqEBF8TnpTu0js7HNmJJOC8oxZfEebWVjNeS7qcFHM3gKtbSG1iCRr6nxNO6opZiAoGZJrae0Wu5MlzESnujr8zW827u58M88sV5R2GXxHmlhs+W8kyHBBzNUEEVvEI41yUYbX2l9Ib3MR+rU8T8R7K8o83sLCS8lyHBBzNUMMcMaxxrkow21tHdBtojxPOeny7S8o82srOS7mEaaas3QVb28VvEscYyAw2nfi0g7v7RuUf5oksSScydT2l5R5rDDJPKscYzZjVlZx2kAjXidWbqcJZUhjaRzkqjM1d3T3U7yt46DoO2vKPNdk7PFrFvuPrXHH5Dpjty+35PoyHuoc3+Z7RXIZ4LyjsMcqIy8v2JYe9k+kOO4h7o6tjtC7FrbNJ97RPU0SWJJOZJzJ7Kr4mn0wXlxLZYaiiMvLbeB55o4k1Y5VBCkESRoO6oyx21d+\\/utxT3YuH9\\/HsqvicH0wXlwZssRRGdEZeWbBtN2NrhhxbgnpjfXH0a1ll8QMl9TRJJJPYRfE4vpgvLg+uI0wIojI+VQRNNNHGurMBUUaxRpGvKoAGPtDPxhgB\\/nP5Dsppi+mC8uD64jQYvr5VsCDfnkmI4IMh6t2Npy+9vp28A26P\\/nh2U0xflwXTB9cRoMX18q2LD7uwQ+LkscXYIjN0BNEliSdSeymmL6YLpg+uI0GL6+VW8fuoIk+FAPwGN827ZXB\\/pN+XZVc+JonJjQOD6YLpg+uI0GBYCgN4HOiCPKLdN+4hT4pFH4nsbQGdlcj+m3YVfE4NzGk1wfTBOXB9cRoMDqaTSiAaIyPk+zxnfWv\\/ACr2J095DInxIR+I7C8owbmNJrg+mCaYPriNBgdaTTB9fJ9nnK+tf+Vfz7O0YPcXsyeG9mPQ8cU5Rg3MaTXB9ME0wfXEaDA0mmD6+SqMzRqF\\/dzRP8Lg\\/gezt+0LRpcKOKd1vTFOUYNzGk1wfTBNMH1xGgwNJpg+vkqa048cLGb31pA\\/VBn6jgew6K6lWGYIyIraNg9pNlrG3I2CcowbmNJrg+mCaYPriNBgaTTB9fJQ2QrM7uYo17P3OaywE6d5ezPBFPG0ci5qav8AZc1oSwzeLwbp60r5cDg\\/MaTXB9ME0wfXEaDA6mk0wfXyZNKYZGrW4a3njlXVTp1FRSpLGsiHNWGYPZIzGRq82HDLm0J923T7pq4s7q1P1kZA+LUGicznSa4PpgmmD64jQYHWk0wfXyZDxplzGGxtoiBvcSn6tj3T8J7ZAIyNXGx7Kbjubh6pwqf2fnXjDKrjoe6alsr2HnhcDrlmPxFFidcFYAVvL1p8s8RoMDqaTTB9fJxTr4jDZe2AgWC4bu6K\\/T5GgQRmPsZbS3l\\/aQo3qoqTYlg+kZX\\/AGk0\\/s7CeSdx6gGn9nZxyTxn1BFPsTaC6IrejD\\/NPs6+TW2k\\/sM\\/ypkZTkyketByK36NJpg+vk6HwwZcsLDa09pkh78fwnw9Ktb62uhnE\\/HxU6j7ZlVhkQCOhqTZtjJzW6f2G7+VTez1uwzildD8+8KuNjX0OZCCQdU\\/SgWUkUGBp9fJwcjQODJ0wVmUgqSCNCKttuXUWQkAlX58G\\/GrfbVjLkC5jPRv1pHVxmrAjqDn9vdbPtbofWIN74hwNX2yZ7XN178fxDUetEk+UKfDEqDRUjFJJIzmjsp6g5VFti\\/j\\/i7w6MM6j9opRz26n0JH60ntDannikX8DSba2e38XL1Bpdo2T6XMf92y\\/OlnhflkRvRgaB+xNbV2OAGnt1+bIPzHlKtnw7BANFK3W6dsMw0JFLd3S8s8g9GNLtTaC6XDH1yP50m3r5ddxvVf0qP2iP37ceoaotu2L8xdPUfpUNzBN+zlRvQ9nbOzRETcRL3Ce+Oh8pVs+3ur0rcWtwVufOtw1uGtxq3G6VunpiCRUG1b6HLKUsOj8attvwPkJ0KHqOK1HLHIoZHDKfEHPB1V1KsMwRkRW0LM2lwyfdPFD1HlIbr+4bq9KKdKKMMILme3feikKn\\/w+tWO3IpcknAR\\/i+6cNr2f0m1JUd+PvL\\/AJHlQJFBh+4kA0UIw2bteS2IjlJaL\\/1aR0kRXRgVIzBFbVtRbXjgDut3l9D5WCRW+a3xW8OtZj7YqDRBFbL2k1q4RyTEx4\\/ynqK27EJbSOZeO4dR8LeZZnrWZ61metZnrWZ61vHrW83Wt81v\\/Kg4rMYEA0QRWzLr30EtjIeZGEZ+fTz0MRQcURmKBZHBByIOYNO5d2Y6sSfPgxFHJh\\/oE\\/8Aah\\/\\/xAA6EQACAAUBBgUBBQcEAwAAAAABAgADBBExEAUSITJQURMgIkFxYTBCcoGRFCMzQFJiwUNgkNGSobH\\/2gAIAQMBAT8A\\/wCWCbPkyReZMVfmJFQk9S6X3b2BIteN71W62zKguzADuYn7ZpJdwl5h+mIn7Yq5vBCJY+mYlJNqZ6JcszHJiVKWVLSWuFFofmhW9j1qYyIjM5AUZvFdPkTp15MoIvfBbTYlLuo1Qw4twX40fm0VvY9YqKiVTyy8xrD\\/AOxW182rfj6UGFiVKebMVEW7GJuyd2dSyQblgS7fEIqoqqosALDR+bVW79Wq6yVSy958nlX3MVNVNqZheYfgewhEZ2CqLkmwEbPoFpZdzxmNzH\\/Ebo3r242tq\\/N5FbqlbWy6WXc8WPKsT58yfMMyY1ydNl7P8BfFmD94w\\/8AEeV+bq9bWS6WXvHix5VidNmTpjO7XY6bIoL2qJg\\/AP8APmbm6tVVUumlF3\\/IdzFRPmT5rTHNydNnURqp12\\/hrzf9QAAAAPM3N1WbNSVLZ3NlAisq3qpxduAwo7DSVKebMWWguWNopqdKeSstfbJ7nztzdV2pW\\/tEzw0P7tT+p12PR+GnjuPU3L9B5g1zbRubyKLwD0\\/a1Z4UvwUPrccfoNaCmNTUKn3Rxb4gAAADA8rN7CEzo3Nqq30vYwDfps6asmU8xsKLxOmvOmvMbLHXZNN4NMGI9T8T8eVm9homdH5tFW+pyYBtAN+mbZqd5lkKeA4trRSPHqZcv2vdvgQBbyM3tqmdHzomNTk6A2gG46VNmLKlu7YUExMdpjs7ZY3Ouw5PpmziM+keV+bVM6PzaJjU5OqY6VtmduyEljLnj8DUxs+V4VHJX+25\\/PyvnVM6PnRManJ1THStqzd+rZfZABqi7zovcgQAAAB5XzqmdHzomNTk6pjpU99+dNfuxOtGt6unH948rNbgIAuogi2iZ0fOiY1OToFvBNiIBB6RObdlTG7KT5KE2rKf8Y8jNbgNF5RD40TOj50TGpydBiHzAJEA3HR6s2pZ\\/wCA+SU25OlN2YHyPzHReUQ+NEzo+dExqcnQQ+dEx0erF6Wf+BvLRTfGpZT++7Y\\/I1fmOi8oh8aJnR86JjU5OgxD50THRWNhAiYu9Lde6keXY1QFZpDHm4rq3MdF5RD40TOj50TGpydBiHzomOiviFPtpVyvCqZq\\/wB1x8HyKzKwZTYg3BiirEqZQOHHMNG5jovKIfGiZ0fOiY1OToIfOiY6KRcxYb1oEbYk8UnAf2nyyp0yTMV0axEUW0JVSAOWZ7r\\/ANQy34xiF5RD40TOj50TGpydBiHzomOjPmAbiJ8lZ0p5bYIiZLaW7IwsVNvLxBuDYxS7YmS7LOG+vf3iTU09Qt0cH6e8AWEPjRM6PnRManJ0GIfOiY6M44QpsdNp0XjL4qD1qOI7jzgkG4JBiRtWrlWBbfHZok7bkNYTEZD+oiXVUs3kmoYAA0ZSTG63aEFhqcnQYh86Jjo5zCN7abQ2bv3myR6vvL3ggg2P2MuqqZfJOcfnCbYrVywb5EJt5\\/vyFPwYTbtOeaU4\\/Qwu16FszCPkGEraR+Wen6wGVsEGCgjc0fOiY6O499Fa+lXs+TUXblf+oRUUc+nPrXh7MMfbKzqbqxHxEvaNbLxPY\\/PGJW3Zw\\/iS1YfTgYkbVo5thv7h7NBAYQVIhMdHMEWOit30IBBBFxE\\/ZNPMuUuh+mInbKq5fKocd1hkZTZlIP1+3pq6ppz6Huv9JxFHtOTU2U+h\\/wCk+\\/x0lhqGIgMDqyI4sygj6iJmzKJ\\/9Ld\\/CbQ+xJR5JzD5F4fYk8csxD+ohtk1q\\/6YPwRDUFYuZD\\/kLw0icvNLYfkY3T2+xEbN2oWKyZ7ccK\\/+D0ll8gYiA8bw85AOQIankNmUh\\/IQ2z6JsyF\\/LhD7GomwGX4MPsJfuTz+YiZsarTl3X+DaJtNPlc8pl+R5dk1\\/iqJExvWB6T3HSWXzXMbzd43zG\\/G\\/wDSN8RviN9Y3li47+Sds6jnZlAHuvCKjYk1bmS4YdjwMPKmS2KupU9jorMjKymxBuDFFVLUyFf3ww+vSSvb+QDHvAeAynSdIlTl3ZiBhFZsd5d3kksv9PuNNl1XgVIUn0PwPSiAYKn+RDEQHB0r9mJUAvLssz\\/0YdHRyrKQwyI2dUftFKjHmHpb5HS7CNwRuGN0xY\\/bBiIBBjaNAtSm8vCYuD3+kbGmtLqJkluG8MfUdSsIsIsO0WEWHaLDtG6I3BG59Y3DFjoCRAIMbQpvDnSqyWOVhvj6d+ulQYKGASDFgykEXBEKoVVXsAOvFQYF1P8AsEf8qH\\/\\/xABBEAABAgIFCAYJAwMEAwAAAAABAgMABAURIDRxEBIhMUFRYIEwMjNhcrETFCJCQ1KRocFAUFMVYvAjcIKwJJLh\\/9oACAEBAAE\\/Av8AtRG5dbja1J2bOPAkq1CuEyqzrNX3hTTTKCqqvHfkovquYiJ2SrrcbGnaOOUyzh7oRKIGvTASBsyTLmcurdkovU5iMk7JV1uNjTtG\\/jVLS1ahCJQe8a4S2lOoWH3MxHflorU5iMs7JV1uNjTtG\\/jQKUnUSIYeeUatdmYcz19wy0VqcxFidks6txsado38ZtMqcwhDaUCoWJlzNR3mxRWpzEWZ2Szq3G9e0cYsy5XpOqAAMpWAQN8GHV56ydmyxRWpzEWp2Sz\\/AG0dbz4vYltq\\/pYddDaazCFqU+knfE05UnNG2zRepzEW5yS9J7aOt5xq4r1wxL5vtHXYccCE1mFrK1VmEHNWk7jC1ZyibNFfExHQTsl6T20dbzgirQeKQCTUIYYCNJ12FrCASYdcLiu7Z0FFfExHQzkkHfbT1vPihKSo1CGWAgd9gmqHni4e7oaK+JiOhOqFdY48TJSVGoQyyGxZmHs45oOjoqK+JiOhOqFdY48SpSVGoQyyGxZmXvcHPo6K+JiOhOqFdZWPEiUlRqEMshsd9mYezE9\\/SUV8TEdCdUL66seIwK4YZzBp12XFhCazC1Faqz0lFfExHQnVC+urHiOXZzRWddk6Ifdz1aNQ6WivicuhOqF9dWPEUsz755Wpp33R01FfF5dCdUL66seIZdnPNZ1C064EJrgkk1npqK+Ly6E6oX11Y8QNtlxVUJSEiq0+5nr7h0euHG1NqzVa8tFfF5dC4pKUEk6IXXnq0cPgVmoQy1mJtTTtQzRt6SSk8z219byifvKstFfF5fnoHHEtpKlGJqaU+r+3YIdlA9LtqHWzBCklJII08PSrXvG0tQSkkwpRUok9HIyeb\\/qLGnYN2SfvKuWWivi8vzbddQ0gqUYmJhb6tOrYMkt2DfhHlE5Jh4VjQqFJKSQRp4cZbz1d22AKrU25Wc3o5GSqqccGnYMs\\/eVcstFa3eX5tPvoZTWTD763lVq5DLLdg14B5ZJuTS8KxoVCkqSopUKiOG2G8xNpxQSkmCaySeikZPU6sYCxP3lXLLRWtzlZmZlDKdOvYIddW6rOUbEt2DXgT5ZZyUDwrHWEKSUkgjTwzKt1qzt1ubcrITz6KSk86pxY0bBZn7yrllorW5ysPuejaUrcIWtS1Zyjpsy3YN+BPlYnJMPCsdaFJKSQRp4XAJIAhtAQkC0tQSkkwolRJ39DJSfpDnrHs7O+1P3lXLLRXWc5WJu7ueE2pXsG\\/CPKzOSYeFY0KhSSkkEaeFpVuslVubXozd\\/QyTKXnalahAFQtT95Vyy0V1nOVicu7nhNqV7BvwjytUiwgt+k2jhZpGYkC2+rOcPdo6GjO3Phtz95Vyy0X1nOVicu7nhNqV7BvwjytT92XwrLIrXXutuqzUE9FRnbnw25+8q5ZaL6znKxOXdzwm1K9g34R5Wp67L4VlkZqB36bc4r2QO\\/y6KjO3Phtz95Vyy0X118rE3d3PCbUrd2\\/CPK1PXZfCiU5ygN5garc0a3OXRUZeD4bc\\/eVcstF9dfKxN3dzwm1Kdg34R5Wp+7L4Ulk1rr\\/wA02zqMOGtxR7+ioztz4bc\\/eVcstF9dfKxN3dzwm1KXdvwi1PXZfCkon2a7ajUmvo6M7dXhtz95Vyy0X118rE3d3PCbUpd2\\/CLU9dnMOFGRU2nD\\/wC23jU2rA9FKyinzuTvid\\/8csei0VVxKzSXk\\/3bRan7yrllovtF8rE3d3PCbUpd2\\/CLK1pQkqUdEImlPzafk06OUTkjm+22NG0cJDSYFuY7JeH5HQykmXjWer5wlISKhFKa2ucJUpCgpJqMSk4l4VHQqzP3lXLLRfaL5WJu7ueE2pO7t+EWHHUNpKlGJmaU+r+3YIkbyjn5ZJ2R1uNjTtHCLPao7jX9OgmOyXh+R0EpJl05y+r5wAAKhkpTW3zyAkGsHTEssrZQo66rE\\/eVcstF9ovCxN3dzwm1J3dvAWJ1xa31AnQDoySN5Rz8ss5I59a0a\\/OCKtB4Pl+05HoJjslYW5GXS8slWobIAqy0prb55ZK7t4WJ+8q5ZaL7VeFicu7nhNqTu7eFiZ7d3xHJJXlH\\/LysUhLIzC6NY4PleurD89A71FYHyt0V8XEfmxSmtvnlk7u3hYn7yrllovtV4WJy7uYG1JXdGFiZvDviOSRvKP8Al5WJ67L4PlOurD89AYUM0kHZaor4vL82KU1t88sld28LE\\/eVcstF9qrCxOXdzA2pK7IwsTPbu+I5JG8owV5WJ67Lw4PlOurD89DMJqcPfptUV8XFP5sUprb55ZK7t4WJ+8q5ZaL7VWFicu7nhtSN2RYme3d8RySN5RgrysT12XhwfLH21YfnoZtGgKtUV8XEfmxSmtvnlkru3hYn7yrlloztleH82Jy7uYWpG7IsTHbu+I5JG8owV5WJ67Lw4LbZU4hxQ92xL9qMD5dC4nOSRBFRqNmivi4p\\/NilNbfPLJXdvCxP3lXLLRnbq8Nicu7mBtSN2RYmO3d8RySN5RgrysT12XhwXRif9JR\\/uibY9C6flOrK0QHEE\\/MIGroZpuo531s0V8XEfmxSmtvnlkru3hYn7yrllozt1eH82Jy7ueG1IXZFiY7d3xHJI3lGCvKxPXZeHBcinNlkYecTTAeaI27IIKSQdYyoVnJr6FSQoEQ4goVVYov4uKfzYpTW3zyyV3bwsT95Vyy0Z26vD+bE5d3MLUhdkWJjt3fEckjeUYK8rE9dl4cFtpzUJG4ZKRla\\/wDVTzyyqq0VbuieaDghSSk1HLRXxcU\\/mxSmtvnlkru3hYn7yrAZaM7dXh\\/Nicu7mFqQuqLEx27viOSRvKMFeVieuzmHBUuK32\\/FDsw2yn2jDbgcQFDbDk4ht0oWKtxibYDas5HUVqySyql1b+jeZDg74UkpNRyUe8htSgo1V1QDXlpTW3zyyV3bwsT95VgMtGdurwfmxOXdzC1R92RYmO3d8RySN5RgrysT12cw4KbcLas4a4UoqNZNZijV1sVbiYpNmtAcGyAtSQQDoOsZAajXDas5IPRraSsaYdZU3hvyMTbrPeN0MTbT23TuyUprb55ZK7t4WJ+8qwGWjO3V4PzYnLu5hao+6osTHbu+I5JG8owV5WJ67OYcGUYupxSd8LSFJIMOtltxSd2WVXpKelclQdKdEKQpOsZGKQcRoX7Q+8T7qHfRKSa9eWSuzeFifvKsBlozt1eD82Jy7uYWqPuqP822Jjt3fEckjeUYK8rE9dl4cGSy8x9B76vrkpJitPpBs14ZQajXDSwtIPSlIMLlB7pqhTa06xYkVp9AgV7LE\\/eVYDLRvbq8H5sTl3cwtUfdUc\\/OxMdu74jkkryjBXlYnrs5hwbKuekZQrugisVRNMehdI2HVlZczFd3T1QuWbVshcqsajX9oKVJ1irImYfTqcMIpF8a6jCKUT7yD5xOOIceKkmsVDLRvbnwfmxOXdzC1R91R\\/m2xMdu74jkkbyjBXlYnrsvDg2i3Osjnkm5cPN1bdkEEEg5Zd6r2Ty\\/Q5ohUs2dn4hUpuVBYdHu14QQRrsNOraJKTsqgUk98qYFKb2z9YTSTB3jERMTLDku5muDVao+6o5+diY7d3xHJI3lGCvKxPXZzDg2Wc9G8lWzblpCV+KnnYYf91X6TNBFWyFSzZ2CDJp2EwZRWxX1j0Dm77x6JwacxX06GUnWm2koVXohM3Lq1OCM4b8kx27viOSRvKMFeViduzmHB0i76RgbxoyzsoWlZyer5WGZirQr6\\/qKhugivXXBYbPuj6QZVs7KoMmnYT5wZM7FfaDKudx\\/zvj0LvyHlpsJWpPVURhCJ6YT71eMOLK1qUdprySN5RgrysTt2cw4OkHvRvVbFZVJCgQYm5UsqrHVsNvKR3iEOJWNB\\/W1DdFWirZBYbPujy8oMmjZXCpVY1GFNrTrTlacLSwsQxPtOaFeye\\/LO3ZzDg+Ve9K0Dt25VoStJSoaImpRTJrGlNgEpNYMNzXzQCD+wrl21bIXKH3T9YUlSdYyMTjrXendDE209qOndE7dnMOD5B\\/0buadSvOwQCKjE1IqbrUjSnduspWpGowib+YQlaVDQf2EoBFUOSm1MKSUmoiASDWI9dUplTa92g8ISUx6VvT1hrszUgF1qRoMLQpBqUKjZBI0gwmZWNemEzSDr0QFpOo\\/sC20rFREOsFGkaRwjLvFlwK+sIUFJBFl5ht0VKEPyDjelPtD79AH3R71eMCcO1P0gTTZgOtn3h+ueltqPpwjR8zmn0StR1W35Np3WNO+HpB5vV7Q6IKUnUSID7o9766YE04N0Cc3p+8CcTtBgTbcesNH3hHpEfMPqMtY3\\/pH5ev2k6\\/PhGRmvSpzVdYdA7LNO9ZMO0X8ivrC5d5vrIOP6AKUNRMemd\\/kV9Y9Yd+b7QJpzuj1xXyiPXf7T9Y9cb7\\/AKQJho+8ICgdWnDT00yz7458IJUpCgpJ0xKzKXkd+0dE5KMOa0CF0Wn3FnzhVHzCdx\\/zvhTTiOsgj9KHHBqWYE053H\\/O6BODakwmYbO38RWOimGsw1jUeEGnVNLCkxLzCH0VjXtHSVCFSzKtaB9IVR0udlUKotPurPnCqMc2LEGj3xuMGTmfk+4j1d\\/+Jf0gtuDWgjl+hSpSdRIhM04NemEzaDr0QFA21JCgRDiChVXCDTq2lZyTEtNIeT37R+iqG6M0boqgtoOsR6uz\\/Gn6CPVmP40\\/+ogyMufcEf0+W+Tzg0Yx3\\/WDRbexSoNFHY59oNGvjamDJTI9z7wpp1PWbUOXQJUpOo1QibI6w+kIdQvUbUy1nJrGscIpUpCgUmoxKzwc9lehX66oboUy0vrJBx0wujpc7KsIXRZ91f1hclMJ9yvCCCDURZBI1Q3NKHWhK0qFYNmYbzF9x4SlqQUjQ5pG+EOJWK0mv9hW0hY9pIMOUa0er7MOyD6NQzsIII12EqUk1gw1Mg6FaDYfbz0HhNt1xo1pMMUihWhfsmAQdX7E7LNO9ZMPUaoaWzX3GFJUk1KFRsNPlGg6oSoKFYyzKM1de\\/hRqZda6p0boZpJs9fRCVpUKwf2JxltwVKTD9HLTpb0jdBBBqOVp1TZ7t0IWFisZJlGcg92nhZK1oNaVEQ3SLyetUr7QikmTr0Ql1tfVUD9\\/wBhmJRt4d++H5dxk6dW\\/K06Wz3bRCFhaaxBhxOatQ4ZTNTCfiHnphNJPDWkGE0on3kHzhNIy521QJuXPxE\\/WA6hWpVcViKxv\\/VLQlYqIiakFN1qRpTuysu+jPdAIIrETadIVy4fBI1GPTPfyK+sesP\\/AMqvrHrUx\\/IY9cmPn+wj1yZ+f7CPXZn5\\/sI9dmfn+wj12Z+f7CPXZn5\\/sI9dmfn+wj16Z+f7R6\\/M7xH9RmO6P6k\\/uT94FJu\\/KI\\/qp\\/j+8ClU7UHzgUmwd4hM7Lq98eXnCXm1dVQOGmKx0E5I1+23r2jLLPZpzTyiYTnNHjRLrqeqtQ5wmfmE7Qf87oRSnzo+kInpdfvAY6ICgbM7J54z0dbzysOekTUrnBFRI3cbpcWjqqIhukXk9bTDU+wvbVjFYOWek663EDTtGRCihVcPVekJG3jpp91rqq5QzSSTocFUJUFCsHJPyvo1Z6RoOvj5p9xo+yeUS08hzQrQqFpStJB1RMMllwp+nH8tPqR7Lmkb4nGg+znJ1jSP9gJaaUwf7d0TaEheeg+yvT\\/sBnnMKdldf\\/aQf\\/\\/EAC0QAAECAggHAQEBAQEBAAAAAAEAESExECBBUWFxofAwYIGRscHR4UDxUHCw\\/9oACAEBAAE\\/If8A6okZMmMZy58NMcsA6ltkiRQOWTRUbpcvuB\\/vPABJYBTsdc+ytLnhoEGYA10h2CgBgsI+dG+XUb4B551jMC8wQcchIfULYQy3FSpfiMmdO2XUTW+GeedNOwqCYC0yarBAXgDG807BdU3gjzzmQhB0\\/iEw1IcLge6myXGrDjzP1EEFjPnBog2Bf+IaABSSBi5uiJg66eMlTYLjWC4eIbTRBBIIYjm4jgWRe\\/iAansQF5R3okQmckfC2ruFxriAha2EIJEEMRMc1gEgAHJkFC\\/j\\/UIUmyj7pi4IZeQT2RTPTKrJuQPAAJgChCICCCxB5pCgOTYgkw7flQhEk7DJJdwJNyB4IiCB2fmgFG5KvMUzuyoIHKaIlMBfieDtMDwZy1LmYPC5V5SZmqckMmRb+cLaYHgzlrXMoONyVfEmZqtgliewcPa4HgzlrnMgKNyVfEpndlUEJnyHtEkkklyeHtcDwZy1DmMhAAOTIIb8yfyqWERZbacTa4HgzlqfMcO49BdVIA5UOKNDHHi+fxPBnLU+YiuA7W\\/KzIeiRHL943k9+DOWv+eYewVeUAwqmZdrzciIjklzxps3ieDOWv8AnmARGVpwQiAZhVJYOpMbrHHhgEgAHJkERsMAe2dM+b34LK4BEqMEg5djjHl8gAOSWAQm7bTfWjJHw4YBJAAim7cUgmlFM2bx4AXAAK5gn9CoKotm+EiiVgBiOXrHnLL9rSEAFbJcOD2o70aDwpmzV5tABtk6IBoNnuKBcNt+BROwAxHLhW7GwQAaswDmfXD+BB+06Hwp1FaL8sLSU4aHQFO83KJR2R+o6AiI5bZxbbnWKyQCNOBLnhPZl7qmj8KdX71XcTlmFEMVYLBlU3i5TBuJR9FE7ADEcsxJKTP8rsDm9cI53lNbiUA0Kmn8KdX71CAw5IWRc4KrvlypAuBkb8CiVgBiOVxIRJYIRO\\/utIAaKKWZPwTAhEiAABhV0\\/hTqPepul1bb7lWRdkb80TsAMRys8tkB7rtiFrQcGxIO16AAAQraHwp2edTaLq233KxyIZvtyqASQAIlAuQViWBKw3A6cHdY19D4U73OpsF1bb7lbR++VcDeZlXwfD9bNeFv8RX0fhTvc6mwXcT7T8qvIz8lfMGzXhb\\/EV9H4U7rOpvl3Eu0\\/vlTCcCEAGDYXV4LcGsffC3eIr6Hwr9ul3ES0fvlR5uD48V9AhipE2y4W3xFfQ+FOnqN0urbBdW0\\/vlRg7x8V3q5HtHh6r5FfR+FOnqN8urbhdW0jzyo28Ov6rvDcQ3vhOWTO9kjgQl26TV3grGj8KdLUbpdW3C6qBAACA8ghvRRKO\\/xrlykBABMlMaEnP8GgNDEoPjAAElrPVNgCRUg6Ij5V0PhToKjcLq2wXVGmACuoB\\/QrR+dEAwKcyI25Y8ovcGwKAYAXDj\\/Dgm3dkNAYAUbvKgaIASIU30L1ND4U6J5qbhdW2q6pFFIBRo\\/PSJja2EIRAQQWIPJ7m7HDcDfYg144BRmJ\\/xAAASp1vrTotTR+FOgeamwXVtNpMituvo03lqGQSdiOTxfZk4DNnNX2OFRr\\/WnTamj8KdB81NiuraNSZFbNfRo\\/LU0vJ+1wcBjOZAg9kWbiIPSt5PGo3+VOi1ND4U6P5qbFdwaMitqvo2i\\/ymW1wcHZjHWtsMKjf5U6LU0fhTo\\/mpq3itoaTIrar6Nov8p01ieo8F4SwxyNbY4VG\\/yp0Wpp\\/CnfYKmq+K2lpMit6vo2i\\/U2WPJdyTLXz+VGbGbghOSIZEIBiCxq7DCo3+VOi1ND4U7jEcJWnpMit6vo2i\\/wAnlnEtAmkBa\\/NMhwOZOpWHrgsA5fVXY4VGv9a66Twp3OCpqVbR+6TIrer6Nov8nkZzi7nWcEVxQymIxFLRej3jwTEDghFR9DeKm4wqN\\/lXzT+FO5wVNZref5pMit6vo2i\\/yeQhsmO0KGDMQIcL+lLLiD3wrkkSKJRsRTsMKjf5V13C6nc4Kmo1vN80mRW9X0bRf5OBms4YTkIlD5sYCZOSlfACOqLOBgZoKminBEDCjJzUS4dzAkd2JvLGiLvWEyg\\/1Akp1vrX3cLqd5gqa7W8vyaTIrer6Nov8nBAjAQCYs6JTiTJWV579pqkZ8iu3dA0EABYguCgjLQ\\/DaQbwRZ57o0EAAcX6QwAMvp0b\\/LhZDaYKmu1vJ8mkyK3q+jaL\\/KAYTAe0PaC84IYhGTahiLKWSMx74hAKeIi6z8RtmveSkm9282imgwbc8KIbTBU12t5PlSZHJb1fRtF\\/lAroomhAuAUzhjudKSAAsQXCCTtdhxR5BAYqMOUmPqnO18x3qMaBIiAiyBBka0N5gqa7W2WKkyK3q+jcL\\/KIXuGLO3VCIVqMwW3z0pm008MUC44zP8AE6EMOEPxSWzRfFPPMKG2RkCXHYr8fnRFy+TfCcJkSXmnVvCprtbyfKkyK3q+jaL\\/ACiU3NrOtBHABiWKEgxBYilyDwtev4SUENAzV3stgi\\/Yewv3BoiBAEEWGozWJcg8JoeZO\\/1DsmQH4iUdhc6GBJfCR7GtssVJkVv19G0X+UQdozNkKBcA0PhmIEOA+VHmJGw3\\/qDEQ\\/iIBmAUXx0Wdk4zsIeFZB1f4n0FsBHh0R2OxEJzV7m4LOwui0JuvMkt5ZAoBkKMlvV9G0X+Uoj02jpQQ4RAKM7ZVJ7y+kCD\\/PhkyYiFzuhMeyHhlLukT7dWS9R8L6H4dCmB6zeiIyzuT0RBBY0k3I3kysEOD2IoDwBMQGNG0X+UoaDuetlIKHBCZw5mBuwqQ3o3ZJ+bMf7SSYdkRLj4LFP+38EY7g6uNU6MHOB+KYQF9nelmlw85RDFNhMH0KBBlyhAJBcIeXs1IEBISRe5e3Z1H4gcFYi2Ikg4IMDL\\/gMHe28QUxF7xA6IBz0fpEGMDjQxh8Z6KESLRT5QiJFlUHQHBTY7y1VHna8HNCkxiJJ3ODD\\/AIJsQDXWIUStgZJyIFARCCJEKd0lobc+UGsFY\\/XWoQDNZ80WFEpoLDVIggG8Ky2g6K3mYfEBdzKPhAgyP98QAJ+9iM+UQElIMEXJwQ9Vnk3YZI8XdrrXBILgsV+oEJ7X11PiRmPjqW9weE4E4ZwTgyP9bKcKNy3LlFvJE\\/zXibN1AqKDlT7IggkEMRwTDnMCytCdlqngPv6RbXp9OvhAPsIm1sx8dCQ8Xll\\/r3tAvEA9iiQJwzgsB3\\/jMVG5kbT88oxWvcceBIs4290SfTi1CfiyFiI0\\/gkKyK\\/1SAb2YHygZv6N4ZC16BPt0P8AEPpf6P0ijeYeWU\\/7FzpxfxZ4Y68fvKDYAJIDMh6B4JANijBhvke4VmGf+FKBllvRRoVeRD+UawIueCFMe03orJMi\\/wATPCDj9QUAGwy4UFo0rjygSKIssIuKGPQDxMNP8zax+6lp5CfbqxnNvhBzmYbw6lXSP1kF8k9r\\/WrWaIfwlnywsrAaDovdX4gTgwvs71zEDghFZ9DeOUAFkdCLioOLD0P4sNQmY9yrVc4+UST2WCJt5opl4vCNz7\\/SKkRy+gVZtmx9BWh3zVsXf4nkx5AUFcBeSA4BVz5FCOt8IA4jfhWgRcfOUThASKavsZKf9uGRx8kDyQGB4y+uorth7HxOcnr0miIgETBqkASIItCgsQvE03gRUKiAFoM+UmI57kZoXFAyb\\/gTTMAXEP5U\\/ksIjVWCO7siBAEETBqQUim\\/0B+IF6WABGzMcpwy7xYc03+s7oI5f8IFAOKf2LZFHZtwajc4dYQAQEGVBDhlgqPrbyprayTKBfogQEgyNn\\/Cb6ITznSfS9EACCJg0wRG0gKZwd96HVb4PzlZ8JwLKGADuVtzxHx0IfID6IEGR\\/4EWBmwCaZYvYGVLlES6iBCOCgceE3snhkYjlgEguFJDbLU2NWDg+1Zzk3wg0esChPkAeVKrJHwsZYZOL\\/6SEYg3rOGWhSXFT+hDRAU2Fm8jl+aAQFLv1\\/qkAf6Lb+C3fksHuwWB3YLb+S3\\/kt\\/4LAdiH5SGyfqG\\/e1a++ULz2\\/FZJk3wjEeoPjosw6\\/wCCN91DwWJXIBUePyP1EEEghiKIhQOq5QjFg46R8c6BWCXAmRqOdDeilO5xaFWxLvogQIM6oTAgQggkEMRQEsQ6v9RzsyIPTnc0+WllLAHsfigpf6PxCQNP2sP2gIHriE5IAB7jnqaTXohN7jfYgwIgyZTTh40PPz+h2lIpnyo25ILTkGKKSUyw5\\/Pgh7oZoPZMhi+HX\\/wC2pKfsEKiGAIvt\\/8AABeF0D\\/9SD\\/\\/xAAtEAEAAQIDBwUBAQACAwAAAAABEQAhMUFRIDBhcYGhsRBgkcHwQNFQ4XCw8f\\/aAAgBAQABPxD\\/ANqJAAecgi8zbD35askwyjpUUhafQt3qIMkHEBAixGfoR\\/FdSOWxh3n7PvgEhVgC61Gxj9WSnWKuqTpfJ91F8lMAk1IClQrAFeRSR2+jz4\\/ER6ftaqQREkbJSqWdz7j9n3qeQHnA6Tj0qIWtH\\/2HxSUKkIIk459S0AIADQ9ReXW5+Hxj6\\/havRAIkiXKa9sQ9x+T70nLpiIDQOFQ5PxQjYWCYXQM1pHuWpgnyePX87V6oIjca51B91ERRIfeUzs4PHpqaOCB1ea5uxLvi\\/c6DuMDchwoLBxUSIEDCNkT3ggNxcB4+FB7AEAEAaHrhdIS6omhdJwmxTgqjE0Z9cdyYSyNEnmLLofshESETJ93IwrcXj+a0Ag9WyStgx0D7cqwzyDAG0HCngw4eBt8m3R3di0UcwDQOB46NPfUiEImInut6yAAlVyKFQUYZj4a8VAABAZequNrAYq4BxaeDhkaBUocjjGFNWuJbNBYN7gCoFcwAZPHRpLJAIRLInulpboBdaNxgh0Dl9nYiqAlrBXIaJ8rm\\/w4E8LXyBpREUS57nRTgjyugZtTNQnP4GnlsL0ABb6F1eBSxkmaj8QZbnDuiv8Ac19zTRT4DVcgrhhcb\\/rYWDBdAxWicLQyRmXJ3d1h3Ne3r8zX3L2xCNV0CoLaE6ifRlsYCuBUsUULUy5v8mPZ1+lr7kRSuArLvUfLZQNqzjdRod2nTIVVlV\\/kx7evx9fcaXlABKrkUwITvPDh52YHwHXgHFypRSchgDAP5cezr9HX3HgnJIcW7Fz+NlSxBqxTLNZItPP\\/ADvcW5z2dfs6+4rQWZcTT9caAAAgNl5MSno8vzDfY\\/ztufZ+4qpMZT\\/FyM6Ig2Y3FwNRhRzCyar\\/ADzez9wlOBAvpUFUAAMgy2TZU7XkTzdXjdvWQAEquAFHGGANkJiT1\\/J03M1TamRRlLeJDFrs+300DAxVsFFrFXDNry02oO2XphXrhu0QKQAuq0ZWNyDQj9dt3sGe8q1BpZr8t6hw04WaIOykxH29ZxgQ6Oy\\/mG0pSIVMQ4ccjjWOU8MgLAcA3ce5cTJSAIDY8\\/b02xh+qVcAZrU91rG2OLq+r5oYdsoogrKTEfbgeLYV45miIAAyIOhtKnsB9b4vu1cBifvfyKICDZ0\\/Z02nDJDfQFL4gmFsv3q7IZ1CHgvCkCkiZe2gVAJWjUCd3rm6GBtX30KamEdVilqlycXdO7FZXnQAAWDak\\/Z02avIZblS\\/FbIdNsCTwJzzwVBWUmI+2Vcrkff+YxQAAEAQbSKLEflwZ67qNsYC6eBQAGBtifk6bEvYIs0KY3jF8BkG5pI414Aog7KTEfa8pQwarYq+GBHFr1O0wCBMGGC7HHIqM2Sowvkbm4qpUtxPCjQW3An4mm\\/4PrGw8EaUirKTEfa0ULS56XfDHXbmZe58vd8bkTcnefAPCjzAIA3PnceP8EjZaUIpmkIfartFAAuq0JYbCmbm9Xa4QE0l3K40mtOCy7n83DulO+\\/gWH3YPD2q80sCfF1GPSgAAsBBtMUouEywdw3Xcv5IjDH5Oja7R5Paois54dr9duLr\\/gJTqjdd23UR2O6oP0NG12vw9qMWgyDgSxLRMIbmhkdDbc4x87\\/AK907hupjsPvusPztG12Dw9qY9RGPH\\/sbbRjGUc6ZyfmK267p\\/JaFw\\/X07XY\\/D2oS4y70ED3dt+l\\/L\\/nd4zT+SjEQfj6dr8zR7UvZMfbbbl8bogrlHG4KSkGEYExmqoeoUke5w\\/jIBh+Pp2Z4ClauDDy6pRmMQd3tKI0gDm0RbhIHBbbfxx4tyVb1zgOGrQSWACADIr9HSrgVyFHIOBLx4P5vLcMEzNi1nOe\\/Jf0SAISOJUvUHefaIERKPRd8VwuD4I2+27gdSdwwaj9gABAB6d34+lPyyiESoEJSGv8jiXEjg0oxyamwsQREs0cVi5dEskAhEsiez72ZG9f77gKJn4fU27IzdAFJ4ULsAev5un8llEzDn9NvXsHbWsnzHLcJgh9nnLyPj3AuzL6sXfd6fk6fz+WJ+e7B2xlP4+J7P7TuOJhKA1FLQUQVcVDuvO98d1Zp+dp3TnavXtHbeI\\/q4ns\\/se40kTJEpFwgTmW3Yd1h3vjuqZPztO9CfsHbeI\\/i4ns8ycP4+huYBZf44Cd9rHsU73x3XAnaN6XL2Dt\\/Ef1cHstpxS2cImOIbBidsl1sblJ4QnQc+jDTaFgcksmzj2Id5477jS79bTa7x5fXtHb+7\\/q4nsuOFf4hB5aeApNI16PVQoc5V1SDcRDzsdy5mzHOy6g2cWxT9XT19u3blP7Om13zy9ewfaR3ehEXfhQ9mn3AORKeGgrJPVl0UjjUy7vobcrYBNSpLUxijQdxR3vj6+y7sRv8\\/Ta7LyevYO39\\/8A3cT2W98gLwEPSRyujE+oEkSlOGFecu6akl1ovHg50ilVz1xbAO99ftm7Yb\\/f02u08\\/r2D7R+IgLNpvH8BV+c2PwVECk0YwKyi+lUzi5ehDDJWJ4jLT0nG2iPm6nDrQiCYNzdAXAcvg60XtgkzE1HM9DkTtpgoXKgQoT1\\/N09fZNvjuWx\\/j6blbsHb+L\\/AIeJ7KizGQYCJCk1xdStQOYWrEQYrvADhL8ZHMyfRJQgMRLjRTARDInEOAybu9feSGEdVk0gWNYHhk+kQPzcOfKjBx3t9GtCIIyV3Pr9l2P3NPXvWx\\/j6bXYeu7B9pnDwNPD5VQWZfUCQlTnuK1LrqepMsZ+t8E9KN3ihknRxKnmYjCX0L0Bvbg4nEiyUKhFEZEpHsn0ObuA3MLDE9ew7H7mnr3je95O8e0zp5XfBFHAMTpM0BmYNPN5pxL1JqGQySrSMl9Qx6PG9TuxBBF1Rz40+6NU\\/wCLvQ8ilAcXSEk7Cs0uC5xisGX1\\/Y09e8b1\\/h2D7U+3hIDP0LsNDgIIRJKHKmU4Z83qe+wzjGHRRkiYGDJfyb5RXBSFUKOTFMga0X+cilpAyPsL3U0ElhITy9IDHsQL5ChQAzdR7wKs3MdGBMKxuDQHq43qOJO0fahw+rOGDk2PocsReVFrrKxEsnraATCeVCJP8CgJgCw8zBpFYpZW9yIkfFYtjhMB1V+KwCCbSH8LlI1aEITYBlegBkQvxKgQrhF8inICZvYUpHmeqVoOxEpHgI7nDsH2psPCzx4PXpjXGg9JvJ4zzuew5ZLdv5ekBUj\\/ABDwRok0QJZTNmfNJU2gWYt5DDtSwnM2HalRq1ZqVnrOGkvQWaeiHF9xucanLne8itGzyIvoTUcBkLYeTWKmj7V+Hxim+dz9T0BBwanX3wGN2CRtsE8fRoW2g9G48nJ\\/mbkNzjepmfjI8UBa0mPhmghA4d6VViDk731X3H6FS4z0vOoI5VXoA0xsPmdIARMR9bX9iS\\/kqCETI\\/opgpCgFTafWe4+0ZVVgdOgiCYPoadYRJEbI03Rza6tiOc8RDzKgOS05IujL+3FzzFSY5lfgyUlLOBVkJlcgHQHmjkOYAW891HqEYzz5LepSszElDExqNcxxLNAEqfaEAERGRLIlTbIEGhx9Y6ClUeyW2NnlsDAHgqKK3LLuDDpRl3EDI8ks\\/8AARQEcw+ShFDoIuti8Uav5HKeQLPWKsuqQESamp6Omyz8DtVG4MmwHtBXG4TkyfOFCII2T1PyJEQRHERxGnVsTEDhqGy1XPEx5Bs1addHqG5TA2YqQ55nWi5b\\/gGxniiZaxrxoBJscbocTrS7QJzNTUpxbCiETMSoHrgGKSx+z2hfzg47lsACCSlI738no1ivg8hqbJ0ngiJ1KjyDa\\/24us0IDSL\\/AFM\\/BTAAMVBObIKuAPJn+96K4xouZo1d+P54OPtGWZwrN\\/ZiUL8IJmJI7KPXjBWqyoMdEYNseUDZGEp675Y\\/luVNdKUDpW5Flxc86iCmcC89SNJBKXBD5UYIeTP9aH6cyp0wxJQfS8PaK5oBotREEZHZQSEEod0x53PrTTyTj\\/bpT5kQiQibnjGBl2ppTkR4Wgo4qg8wopdPJ8KLwfKoMwrjcoYhHNfHTjPA8KgmRNRvBWKHkPlQ+C9FEOCNQ\\/wgCJI1aucQe0UaWUS07ZhISSioTMIQOAIaBK+XCk4AUtjOLIP4Hpd4h4oD7qsPH5djTc9TVFcHoXyoGZcf8ChEI6Q8KggVeI\\/JFLoKMZHlpfix0bO8QRG440rfrkGT7ntA5hso8Oo5lFlIJnbkuyF1zpFVWWMrxhWnS8HJL0VmD5OYFieD\\/LwPvZ8Kkx5tZbGoIfETyqNDmSs5sO6hpUBKbDycHcpOcMyOjrWHK4yaXJy9oQQ7Cua4FOHAsjfeCl08y3ir+ziXgJoTrJvKj6ce6b1T\\/hKeNAVQ\\/ktRJxOS+CvylGtIn8CpakK0jpTJErTBaPh8jVtk+CTo\\/wCChJVMARTwEjtzsgE1NPs41cFC8UaD7QgONkb5oMysJEJW\\/wDo4\\/woOIUpj8JXBUFgnkVYRfpqrFzzbzQ9Hoj4p4tj5CkYV9leD0Bp8srCiqdE+SoSnBSWhCQGtfAzX\\/387Cbha6bMok0dSoKQcr5wfEUzghMMeYblWSRk2Z+ZM6nX2ieKMhR7DDDL\\/bhQgERH+3\\/QCKlB9VPkNLpzUn0USb8J51rO3AcVN5WUeU0ARHiOyjUpEhGog3lXUYNCpQiTCdGbjwdgSJKcdHWpERKBgZg9pOYYzF9yg8HKUj\\/wCAhBONBiDARORKKFXjw\\/BVtR1\\/t3ek0hUkBCJkmwTfrmZomZwasj1ljlL\\/0oBbrw9b2mPtvnD2nOP1nIVa7qrfyydaJARB\\/4FBIQSoi8EGY5JcrmpED0tKHFsRh2H05LPk6nCgshKLiegIsEikcmNwGV9+1GAlLq9OnSiVNdu+pWCqIRXJLP\\/BOsrpMHUzOlT9eheaxRFJICETER9ZHNHGieJo0dvAOFzETIZnpFhYR039rHyZitI0dSoP8AMOFqPB\\/pQ0OABikDmzoKw8mf78kaZMdC2H+nBp7LWCXcHR9cj4uQA8Jk1EPFnBtqZJmUihE48xcozDGU2XOOMPtgAiJglNdj\\/fToIalfKKWNKIBfg+mNTgP81xXfi\\/7VHjHmJQmHz0JgPnbhq\\/rG+G20IJEpELiYg8NQ9ZuixxMTTiFHxExMKhJrAdRdWU6e30hQ1FKDgZwGgvvasIfnHlQf+6HCeqhZuFpcDS4SoHRgxaosn0qH\\/hSDHch8rRS7NFvb1GIEtXPOvywiPk1gSWnlLWVEdGz32wESRoIaYxscZpRECERIRPRxuq5yXg+aBolyZvPd704SKT4UYQtD7pKWziGPhB5qMCIlT\\/EoIMCTibFkSjzhXNGjx0afshESETJ9HjhgK3LaeizxrvelKPe7JE4zS5xjUCa+KkZw3996GTJafSyI4NRrBuWXXk9Ms2w1MSk6yTdUF7++liFOW89HyU1wb3f2UGlJSETUSkAjS3ErTBs+T7+khGzddLXiXpVwkAllx0IdoHMam+cazevEwff+FpY7\\/eKbMaRcwJ\\/4AQ2V+VSJB3AP\\/AEdrJAaNpOZZ\\/8AaQf\\/2Q==\",\"status\":\"pending\",\"qr_token\":\"9fddabe4-c050-4050-a5da-fe2d556a6389\",\"pengikut_laki\":0,\"pengikut_perempuan\":0,\"pengikut_anak\":0,\"registration_type\":\"online\",\"visit_started_at\":null,\"visit_ended_at\":null}}', NULL, '2026-01-16 10:59:56', '2026-01-16 10:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_status`
--

CREATE TABLE `antrian_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `sesi` enum('pagi','siang') NOT NULL,
  `nomor_terpanggil` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `antrian_status`
--

INSERT INTO `antrian_status` (`id`, `tanggal`, `sesi`, `nomor_terpanggil`, `created_at`, `updated_at`) VALUES
(1, '2026-01-16', 'pagi', 0, '2026-01-16 00:21:01', '2026-01-16 00:21:01'),
(2, '2026-01-16', 'siang', 0, '2026-01-16 00:21:01', '2026-01-16 00:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1768561255),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1768561255;', 1768561255),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1768558664),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1768558664;', 1768558664);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kunjungans`
--

CREATE TABLE `kunjungans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profil_pengunjung_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kode_kunjungan` varchar(255) DEFAULT NULL,
  `nama_pengunjung` varchar(255) NOT NULL,
  `nik_ktp` varchar(16) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `no_wa_pengunjung` varchar(255) NOT NULL,
  `email_pengunjung` varchar(255) DEFAULT NULL,
  `alamat_pengunjung` text NOT NULL,
  `barang_bawaan` varchar(255) DEFAULT NULL,
  `hubungan` varchar(255) NOT NULL,
  `pengikut_laki` int(11) NOT NULL DEFAULT 0,
  `pengikut_perempuan` int(11) NOT NULL DEFAULT 0,
  `pengikut_anak` int(11) NOT NULL DEFAULT 0,
  `tanggal_kunjungan` date NOT NULL,
  `foto_ktp` longtext DEFAULT NULL,
  `nomor_antrian_harian` int(10) UNSIGNED DEFAULT NULL,
  `sesi` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','rejected','called','in_progress','completed') NOT NULL DEFAULT 'pending',
  `visit_started_at` timestamp NULL DEFAULT NULL,
  `visit_ended_at` timestamp NULL DEFAULT NULL,
  `preferred_notification_channel` varchar(255) DEFAULT NULL,
  `qr_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wbp_id` bigint(20) UNSIGNED DEFAULT NULL,
  `registration_type` varchar(255) NOT NULL DEFAULT 'online'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kunjungans`
--

INSERT INTO `kunjungans` (`id`, `profil_pengunjung_id`, `kode_kunjungan`, `nama_pengunjung`, `nik_ktp`, `jenis_kelamin`, `no_wa_pengunjung`, `email_pengunjung`, `alamat_pengunjung`, `barang_bawaan`, `hubungan`, `pengikut_laki`, `pengikut_perempuan`, `pengikut_anak`, `tanggal_kunjungan`, `foto_ktp`, `nomor_antrian_harian`, `sesi`, `status`, `visit_started_at`, `visit_ended_at`, `preferred_notification_channel`, `qr_token`, `created_at`, `updated_at`, `wbp_id`, `registration_type`) VALUES
(1, NULL, 'VIS-XXUYPA', 'Arya Dian', '1234567890000001', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-19', 'uploads/ktp/hYlbSoiSP24HLgpZhcTnrRXfRLbL7amPfmxQ5eBL.jpg', 1, 'pagi', 'approved', NULL, NULL, NULL, '9d1ad382-bcdd-4816-aae4-1c540404b91a', '2026-01-16 00:25:34', '2026-01-16 00:27:05', 43, 'online'),
(2, 2, 'VIS-7PODGJ', 'Mellyana Tundjung', '3517185508002009', 'Perempuan', '0881011388375', 'tundjungmelly@gmail.com', 'Jombang, Jawa Timur', 'hekjrfuw', 'Orang Tua', 0, 0, 0, '2026-01-19', 'uploads/ktp/KUfV514tik2cOuhz3hy9XROlp1Tdw8OIug86v0t6.jpg', 2, 'pagi', 'pending', NULL, NULL, NULL, '97ee336b-86d5-4ccd-a1aa-d3e50dcc43a7', '2026-01-16 10:06:04', '2026-01-16 10:06:04', 196, 'online'),
(3, 3, 'VIS-6JCVM5', 'Mellyana Tundjung', '3517185508102009', 'Perempuan', '0881011388375', 'tundjungmelly@gmail.com', 'Jombang, Jawa Timur', 'hekjrfuw', 'Orang Tua', 0, 0, 0, '2026-01-19', 'uploads/ktp/QbH90i7MWBBi2hVYHofyaUZGhnfo667OtQnjT6V0.jpg', 3, 'pagi', 'pending', NULL, NULL, NULL, '2d83eb70-65c7-4ce6-8915-fa833beffda5', '2026-01-16 10:10:31', '2026-01-16 10:10:31', 35, 'online'),
(4, 4, 'VIS-AR3EIO', 'Mellyana Tundjung', '3517185508102909', 'Perempuan', '0881011388375', 'tundjungmelly@gmail.com', 'Jombang, Jawa Timur', 'hekjrfuw', 'Orang Tua', 0, 0, 0, '2026-01-19', 'data:image/jpeg;base64,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AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/8QAAv/aAAwDAQACAAMAAAAhAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA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AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAztTDDAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAATEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/8QAAv/aAAwDAQACAAMAAAAQ88888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888891288888888888888888888888888888888888888888888888888888888884/xMe88088888888888888888888888888888888888888888888888888888888tDS38wzI88888888888888888888888888888888888888888888888888888889gDSc8VXbU08888888888888888888888888888888888888888888888888888uJCFd88BDDDk088888888888888888888888888888888888888888888888888r6CU8888oDDDXU8888888888888888888888888888888888888888888888888uc7v88888LDDDX0888888888888888888888888888888888888888888888888ri9z/wDPPPPCwwww/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPkAfvvPPPPPAwwww1PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPODgDxvPPPPCPKwwwy0/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPKfwAH/PPPEA/Cww1/BF/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLafQHPPPPNY0/Awy/PIIH/ADzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzYP0J7zzzOMMbyMN/zwgPB/zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz70n0zzzzycMNLwMNfzyANNfzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzpYlV7zzzysMNLwsPfzyAMN/zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzxdC0P/AM888rDDW8jD388IDDW888888888888888888888888888888888888888843J8X88887/KDe8LD388ADBJ38888888888888888888888888888888888888888DtUo888zXULDX8nLX88EX3oAX888888888888888888888888888888888888888nUJn888AF8rDT8/r3888/XUDX88888888888888888888888888888888888888s6vlIe88UPcvDX8fjf88QTXgHf888888888888888888888888888888888888t/rq1QpS88sBUrzj87j3880T/QD3888888888888888888888888888888888888nC8uZItB98Q9U/DH8HH/wDPFH/0A9/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPJCf5KbFaBGL+3Kw0/Gw1/PHF/wA1/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPOv+XfSKXb/R/6/e/Cx3/PCk/yD1/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPKpfGNaLVOYAD7FdfPcN/PAxP0gV/PPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPLJsfPb1SPTUv8oA8Ydu8ff4PAxP8AzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzxlN/wAOBtQ9K2PCX/8Auggk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', 4, 'pagi', 'pending', NULL, NULL, NULL, '9fddabe4-c050-4050-a5da-fe2d556a6389', '2026-01-16 10:59:56', '2026-01-16 10:59:56', 19, 'online');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_01_01_000000_create_users_table', 1),
(2, '2025_12_03_030145_create_news_table', 1),
(3, '2025_12_03_030149_create_announcements_table', 1),
(4, '2025_12_25_100000_create_kunjungans_table', 1),
(5, '2025_12_25_110000_add_role_column_to_users_table', 1),
(6, '2025_12_26_110000_add_email_to_kunjungans_table', 1),
(7, '2025_12_26_120000_add_queue_and_session_to_kunjungans_table', 1),
(8, '2025_12_27_100000_add_unique_constraint_to_kunjungans_table', 1),
(9, '2025_12_27_110000_add_qr_token_to_kunjungans_table', 1),
(10, '2025_12_28_000000_change_image_column_to_long_text_in_news_table', 1),
(11, '2025_12_29_094759_create_failed_jobs_table', 1),
(12, '2025_12_29_150000_update_user_roles', 1),
(13, '2025_12_30_000000_create_contacts_table', 1),
(14, '2026_01_02_084707_add_status_to_news_table', 1),
(15, '2026_01_02_085001_add_status_to_announcements_table', 1),
(16, '2026_01_02_091250_create_cache_table', 1),
(17, '2026_01_07_100539_create_wbps_table', 1),
(18, '2026_01_07_100833_add_details_to_kunjungans_table', 1),
(19, '2026_01_07_172024_add_wbp_id_to_kunjungans_table', 1),
(20, '2026_01_07_174830_add_details_to_kunjungans_table', 1),
(21, '2026_01_07_180818_create_pengikuts_table', 1),
(22, '2026_01_07_191250_add_jenis_kelamin_to_kunjungans_table', 1),
(23, '2026_01_07_192626_fix_kunjungans_table_structure', 1),
(24, '2026_01_07_193043_clean_up_kunjungans_table', 1),
(25, '2026_01_07_194700_remove_nama_wbp_from_kunjungans_table', 1),
(26, '2026_01_07_210845_add_email_to_kunjungans_table', 1),
(27, '2026_01_07_211727_add_barang_bawaan_to_kunjungans_table', 1),
(28, '2026_01_09_100000_create_surveys_table', 1),
(29, '2026_01_10_100000_add_preferred_notification_channel_to_kunjungans_table', 1),
(30, '2026_01_11_160957_update_unique_constraint_kunjungans_table', 1),
(31, '2026_01_13_120000_create_antrian_status_table', 1),
(32, '2026_01_13_130000_create_products_table', 1),
(33, '2026_01_13_140000_add_completed_status_to_kunjungans_table', 1),
(34, '2026_01_14_000000_create_surveys_table', 1),
(35, '2026_01_14_100000_add_registration_type_to_kunjungans_table', 1),
(36, '2026_01_14_200000_update_daily_unique_constraint_in_kunjungans_table', 1),
(37, '2026_01_15_100000_add_visit_timestamps_to_kunjungans_table', 1),
(38, '2026_01_15_110000_modify_status_enum_in_kunjungans_table', 1),
(39, '2026_01_15_120000_create_profil_pengunjungs_table', 1),
(40, '2026_01_15_120001_create_profil_pengunjung_pengikut_table', 1),
(41, '2026_01_15_130000_add_profil_pengunjung_id_to_kunjungans_table', 1),
(42, '2026_01_15_140000_create_activity_log_table', 1),
(43, '2026_01_16_071445_create_sessions_table', 1),
(44, '2026_01_16_072233_assign_superadmin_role_to_first_user', 2);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengikuts`
--

CREATE TABLE `pengikuts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kunjungan_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `hubungan` varchar(255) DEFAULT NULL,
  `barang_bawaan` varchar(255) DEFAULT NULL,
  `foto_ktp` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 1,
  `wbp_creator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('tersedia','terjual') NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil_pengunjungs`
--

CREATE TABLE `profil_pengunjungs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nomor_hp` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profil_pengunjungs`
--

INSERT INTO `profil_pengunjungs` (`id`, `nik`, `nama`, `nomor_hp`, `email`, `alamat`, `jenis_kelamin`, `created_at`, `updated_at`) VALUES
(1, '1234567890000001', 'Arya Dian', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'Laki-laki', '2026-01-16 00:25:33', '2026-01-16 00:25:33'),
(2, '3517185508002009', 'Mellyana Tundjung', '0881011388375', 'tundjungmelly@gmail.com', 'Jombang, Jawa Timur', 'Perempuan', '2026-01-16 10:05:48', '2026-01-16 10:05:48'),
(3, '3517185508102009', 'Mellyana Tundjung', '0881011388375', 'tundjungmelly@gmail.com', 'Jombang, Jawa Timur', 'Perempuan', '2026-01-16 10:10:30', '2026-01-16 10:10:30'),
(4, '3517185508102909', 'Mellyana Tundjung', '0881011388375', 'tundjungmelly@gmail.com', 'Jombang, Jawa Timur', 'Perempuan', '2026-01-16 10:59:56', '2026-01-16 10:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `profil_pengunjung_pengikut`
--

CREATE TABLE `profil_pengunjung_pengikut` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `profil_pengunjung_id` bigint(20) UNSIGNED NOT NULL,
  `pengikut_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `saran` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@lapasjombang.go.id', '2026-01-16 00:19:49', '$2y$12$g/yln0nfrSLH83p/r/0PrOTtlWwXRma5/cIW4CgjhdWv.z/dOwVYm', 'admin', NULL, '2026-01-16 00:19:49', '2026-01-16 00:41:55'),
(2, 'Arya Dian Saputra', 'aryadian003@gmail.com', NULL, '$2y$12$zjfs0P1ghzLXv9g70RYmX.yb/5vjYURn9e9zBDTtDqO/e5.Jeksna', 'super_admin', NULL, '2026-01-16 04:07:00', '2026-01-16 04:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `wbps`
--

CREATE TABLE `wbps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_registrasi` varchar(255) NOT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `tanggal_ekspirasi` date DEFAULT NULL,
  `nama_panggilan` varchar(255) DEFAULT NULL,
  `blok` varchar(255) DEFAULT NULL,
  `kamar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wbps`
--

INSERT INTO `wbps` (`id`, `nama`, `no_registrasi`, `tanggal_masuk`, `tanggal_ekspirasi`, `nama_panggilan`, `blok`, `kamar`, `created_at`, `updated_at`) VALUES
(1, 'A. SYAFIUL HAQIQI BIN SUPRATMAN', 'BI. 195/2025', '2025-02-25', '2026-07-22', 'HAQI', 'A', 'A7', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(2, 'ABD WAHED BIN ASMARA', 'B.I 077/2023', '2023-01-26', '2027-11-29', NULL, 'A', 'A8', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(3, 'ABDI EKOYONO BIN DASIM', 'BI. 352/2022', '2022-05-30', '2029-01-31', NULL, 'C', 'C16', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(4, 'ABDU HAKIM BIN MOCHAMAD ABDUL RAHMAN', 'BI.N 107/2024', '2023-07-12', '2028-08-12', 'JUBEK', 'BA', 'BA6', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(5, 'ABDUL AFANDI BIN SOKIP', 'BI.N 006/2024', '2022-12-12', '2027-03-01', 'GENTONG', 'A', 'A7', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(6, 'ABDUL AZIZ BIN SUHARTONO', 'BI.N 564/2023', '2023-01-18', '2027-06-01', 'KADUL', 'C', 'C13', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(7, 'ABDUL GHONI BIN MUSTOFA', 'BI.N 029/2025', '2024-09-24', '2030-10-03', 'GONI', 'A', 'A5', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(8, 'ABDUL HAMID BIN MARDI (ALM)', 'AIIIN. 340/2025', '2025-07-23', '2026-02-22', 'HAMID', 'A', 'A11', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(9, 'ABDUL ROHMAN AKBAR BIN ROBANGI', 'AIIIN. 330/2025', '2025-10-28', '2026-02-12', NULL, 'A', 'A3', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(10, 'ABDUL ROZAQ EFENDI BIN NUR SALIM', 'BI.N 080/2025', '2024-04-09', '2030-02-27', NULL, 'C', 'C17', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(11, 'ACH. LIMAN BIN MARLAS', 'BI.106/2025', '2025-06-05', '2028-04-26', 'SLEBOR', 'A', 'A8', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(12, 'ACHMAD ABDI SUSANTO BIN WAKIDI', 'BI. 215/2025', '2025-01-09', '2039-11-05', 'SANTO', 'BA', 'BA8', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(13, 'ACHMAD AFANDI BIN RIBUT SUPARYONO', 'BI.N 168/2024', '2024-07-08', '2028-12-05', NULL, 'A', 'A11', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(14, 'ACHMAD ANDI MUHTAMIM BIN SUKARI', 'BI.N 017/2025', '2024-08-12', '2030-06-23', NULL, 'D', 'D4', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(15, 'ACHMAD CHOIRURROZIQIN IMRONULLOH BIN M.AYUB', 'BI.N 222/2023', '2022-01-18', '2027-06-15', 'IMRON', 'C', 'C16', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(16, 'ACHMAD FAHMI RAHMATULLAH BIN JAMAL', 'BI.N 206/2025', '2025-01-09', '2030-09-08', NULL, 'C', 'C6', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(17, 'ACHMAD FATHUR ROZI BIN SUNARDI', 'BI.N 327/2023', '2023-06-13', '2028-05-11', NULL, 'BA', 'BA7', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(18, 'ACHMAD FATQUR ROHMAN BIN ABDUR ROHMAN (ALM)', 'BI.N 221/2023', '2022-01-18', '2027-06-15', 'JEMBLUNG', 'BA', 'BA13', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(19, 'ACHMAD FAUZAN BIN SULIS TYO HADI', 'BI.N 285/2023', '2023-05-25', '2029-08-20', NULL, 'A', 'A7', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(20, 'ACHMAD FEBRIYANTO LIKHIN BIN SOLIKHIN', 'BI.N 294/2025', '2025-05-16', '2029-04-25', 'RIYAN', 'C', 'C10', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(21, 'ACHMAD GILANG FERDIANSYAH BIN PURWO EDI', 'BI.N 003/2024', '2023-06-08', '2028-07-18', 'SATIM', 'A', 'A12', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(22, 'ACHMAD MUKLIS BIN JA\'FAR', 'BI.N 066/2025', '2024-07-08', '2028-05-08', 'ARIF', 'A', 'A11', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(23, 'ACHMAD SAIFUDIN BIN SLAMET', 'BI.N 186/2025', '2024-08-12', '2026-03-27', 'MAD', 'C', 'C15', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(24, 'ACHMAD SOCHI BIN ROKIM (ALM)', 'BI.N 241/2025', '2025-03-25', '2027-01-17', 'SOKEK', 'C', 'C6', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(25, 'ACHMAD TAUFIQ BIN MISNO', 'AII. 378/2025', '2025-11-18', '2026-01-18', NULL, 'A', 'A7', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(26, 'ACHMAD TORIQ FIRMANSYAH BIN WARSITO', 'AIVN. 065/2025', '2025-03-25', '2026-01-22', NULL, 'D', 'D4', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(27, 'ACHMAD ZULKIFLI BIN EDRUS', 'BI. 251/2025', '2025-01-09', '2042-11-12', 'KIPLI', 'A', 'A7', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(28, 'ADE ANGGRYAWAN BIN ISWANTO', 'BI.N 186/2024', '2024-07-08', '2029-12-02', 'DOPO', 'C', 'C9', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(29, 'ADE KRISTIAN BIN TOTOK WIDODO', 'BI. 158/2024', '2024-06-24', '2026-04-26', NULL, 'A', 'A11', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(30, 'ADI PRASETYO UTOMO BIN SUWADI', 'AIIIN. 337/2025', '2025-07-23', '2026-02-22', NULL, 'A', 'A11', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(31, 'ADI SANTOSO BIN MURI (ALM)', 'BI.N 078/2025', '2024-01-26', '2027-08-16', 'PESEK', 'C', 'C16', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(32, 'ADI SUPRAPTO BIN MATSUI', 'BI.N 464/2023', '2023-09-12', '2027-10-28', NULL, 'A', 'A9', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(33, 'ADI SUTRISNO BIN SUGENG', 'BI.N 093/2024', '2023-12-14', '2028-02-15', 'GOPEK', 'BA', 'BA7', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(34, 'ADIP SUSANTO BIN ALIMUN (ALM)', 'BI.N 096/2025', '2024-11-13', '2028-12-21', 'KODOP', 'C', 'C14', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(35, 'ADITYA ANGGA NEGARA BIN ZAINUL ARIFIN (ALM)', 'BI.N 139/2025', '2024-09-24', '2030-08-04', 'ADIT', 'BA', 'BA2', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(36, 'ADITYA WICAKSONO BIN -', 'BI. 159/2024', '2024-04-09', '2029-10-26', 'CUYONG', 'A', 'A5', '2026-01-16 00:21:25', '2026-01-16 00:21:25'),
(37, 'ADITYA YUDHA PRATAMA BIN MUJI SLAMET', 'BI. 313/2025', '2025-08-31', '2028-03-14', 'SINYO', 'A', 'A13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(38, 'AFREYZA TEGAR SUWITO PUTRA BIN HERU SUWITO', 'BI. 183/2024', '2024-05-27', '2029-12-03', NULL, 'A', 'A5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(39, 'AGIL FERIANDA BIN MOCH MASTUR', 'BI. 127/2025', '2025-06-10', '2026-07-12', NULL, 'BA', 'BA12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(40, 'AGUNG SANTOSO BIN SLAMET HARIADI', 'AI. 388/2025', '2025-12-23', '2026-02-04', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(41, 'AGUNG SEDAYU BIN SUPARNO (ALM)', 'AI.N 348/2025', '2025-11-18', '2026-01-21', 'DAYU', 'A', 'A10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(42, 'AGUS ARIFIN BIN (ALM) MISLAN BIN MISLAN (ALM)', 'AI.N 302/2025', '2025-10-14', '2026-01-14', 'KANCIL', 'A', 'A12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(43, 'AGUS BUDIONO BIN SLAMET', 'BI. 339/2022', '2022-07-21', '2036-04-27', 'UCLUK', 'BA', 'BA11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(44, 'AGUS EKO SANTOSO BIN SOEMITRO', 'AV. 015/2025', '2025-03-17', '2026-02-16', NULL, 'A', 'A12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(45, 'AGUS HARIADI BIN PAMUJI', 'AIII. 355/2025', '2025-08-31', '2026-03-02', NULL, 'BA', 'BA2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(46, 'AGUS HARYADI BIN SOLIKAN', 'AI.N 352/2025', '2025-11-18', '2026-01-22', 'BOGEL', 'A', 'A9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(47, 'AGUS PURNOMO BIN IKSAN', 'BI.N 010/2025', '2024-08-27', '2032-08-17', 'KETENG', 'A', 'A6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(48, 'AGUS PURNOMO BIN RASIMIN (ALM)', 'AIVN. 074/2025', '2025-05-16', '2026-03-01', NULL, 'A', 'A9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(49, 'AGUS SETYONO BIN KARYONO (ALM)', 'BI. 240/2025', '2025-05-16', '2026-06-29', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(50, 'AGUS SULISTYONO BIN SUTRISNO', 'AIIIN. 308/2025', '2025-06-04', '2026-02-13', 'POTRO', 'A', 'A13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(51, 'AGUS SUTIYONO BIN SAMAJI', 'AVN. 025/2025', '2025-03-17', '2026-04-16', 'AGUS KUPRIT', 'C', 'C8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(52, 'AGUS SUTOPO BIN MASHUDI', 'BI.N 138/2024', '2024-03-06', '2028-06-13', 'LOWING', 'C', 'C16', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(53, 'AGUS SUYANTO BIN SUKAMTO', 'BI. 410/2021', '2021-06-02', '2038-07-11', 'OM', 'BA', 'BA13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(54, 'AGUS WAHYU WIDODO BIN KARSONO (ALM)', 'BI.N 149/2023', '2022-09-14', '2027-01-10', 'KONTENG', 'C', 'C1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(55, 'AGUS WAHYUDI BIN HENDRA', 'BI.N 429/2023', '2023-08-18', '2028-11-12', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(56, 'AGUS WAHYUDI BIN KARSONO', 'BI.N 215/2024', '2024-03-06', '2028-06-12', 'GENDUT', 'C', 'C1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(57, 'AGUS WIDODO BIN KARSIMIN', 'BI.N 324/2022', '2022-07-26', '2027-03-18', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(58, 'AGUS YULIANTO BIN SUJIONO (ALM)', 'BI.N 097/2025', '2024-04-05', '2026-09-27', 'SOGAL', 'BA', 'BA5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(59, 'AGYL FEBRIAWAN BIN SALI', 'BI.N 209/2024', '2023-10-20', '2030-09-27', 'AGYL', 'C', 'C5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(60, 'AHMAD CHOIRUL BASYARUDIN ALIAS GLITOK BIN SUPARNO (ALM)', 'AIVN 071/2025', '2025-05-16', '2026-02-25', 'GLITOK', 'C', 'C8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(61, 'AHMAD FARIDH BIN KUSNAN JUDI (ALM)', 'BI. 210/2025', '2024-10-15', '2028-01-17', NULL, 'A', 'A1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(62, 'AHMAD FATONI ALS TONI BIN SABILILLAH ROSYAD (ALM)', 'BI.N 190/2025', '2025-02-25', '2026-05-01', 'TONI', 'BA', 'BA2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(63, 'AHMAD JUNAIDI BIN MISKAN (ALM)', 'BI.N 348/2022', '2022-03-09', '2027-12-04', 'JUNET', 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(64, 'AHMAD KADAVI BIN SODIQ', 'BI. 217/2025', '2025-04-28', '2027-04-02', 'DAVI', 'BA', 'BA8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(65, 'AHMAD MASYHADI BIN ABDUL GHOFUR', 'AI.N 350/2025', '2025-11-18', '2026-01-22', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(66, 'AHMAD NUR HAIMIN BIN JAJADI', 'AI. 379/2025', '2025-12-03', '2026-01-12', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(67, 'AHMAD SUMARDIYANTO BIN SUGIANTO', 'BI.N 320/2023', '2022-04-18', '2028-01-16', NULL, 'C', 'C5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(68, 'AHMAD YUNUS BIN SUNADI', 'BI. 140/2025', '2024-12-05', '2026-01-09', 'CAKMAT', 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(69, 'AHMAT ROY BIN MAT SALIM', 'BI. 132/2025', '2025-06-10', '2027-12-24', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(70, 'AHMAT YUSUF ARDIANSYAH BIN FATKUR ROHMAN', 'BI.N 205/2025', '2025-02-11', '2030-10-03', 'KIPLI', 'C', 'C4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(71, 'AKBAR ALFIANTO HADI BIN SAMSUL HADI', 'BI.N 257/2025', '2025-03-17', '2026-11-01', 'ATENG', 'BA', 'BA8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(72, 'AKHMAD YUSUF AFANDI BIN SETYO BUDI (ALM)', 'AIII. 329/2025', '2025-08-26', '2026-02-10', NULL, 'BA', 'BA1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(73, 'ALAM ADITYA PRAMONO BIN KUSWONO', 'BI.N 526/2023', '2023-11-03', '2028-03-03', NULL, 'BA', 'BA6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(74, 'ALANG HENDRA BIN PONARI', 'AI. 361/2025', '2025-11-18', '2026-01-14', 'ALANG', 'A', 'A10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(75, 'ALDY SATRIYO BIN SYAMSUDIN (ALM)', 'BI. 250/2025', '2025-06-24', '2026-11-26', 'ALDY', 'BA', 'BA12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(76, 'ALFIYATUL LAILIYAH BINTI MANSYUR (ALM)', 'BI.P 009/2025', '2025-05-16', '2027-02-09', 'ALFI', 'WANITA', '1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(77, 'ALI FIQRI FIRMANSYAH BIN AGUSTHOLIB', 'AVN. 030/2025', '2025-03-25', '2026-05-30', 'FIKRI', 'C', 'C11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(78, 'ALI MACHMUD BIN ALI MAKSUN (ALM)', 'BI.N 301/2025', '2025-06-04', '2032-05-24', 'JUSTO', 'D', 'D5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(79, 'ALI SANDRA BIN JADI ( ALM )', 'BI. 247/2021', '2021-04-06', '2027-06-06', NULL, 'A', 'A5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(80, 'ALIF RAHMAN HAKIM BIN SUTEJO', 'AIVN. 067/2025', '2025-05-16', '2026-02-17', NULL, 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(81, 'AMAL MAKRUF BIN MAHMUD YUNUS KATILI', 'AIII. 309/2025', '2025-08-31', '2026-01-14', 'ANGGA', 'BA', 'BA5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(82, 'AMAN WAHYUDI BIN MAKSYUR (ALM)', 'BI. 120/2025', '2025-06-10', '2026-08-13', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(83, 'AMIN ROES BIN MUKADI', 'BI. 260/2025', '2025-03-17', '2042-12-30', NULL, 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(84, 'AMIR MAHMUD BIN MUALIB', 'AIIIN. 365/2025', '2025-08-31', '2026-01-10', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(85, 'ANANG AUNUR ROFIQ BIN SUNAJI (ALM)', 'BI.N 163/2024', '2024-07-08', '2032-05-28', 'KEMIS', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(86, 'ANAS ASRORI BIN JUMAIN', 'BI.N 247/2023', '2022-12-12', '2027-07-22', 'KATE', 'C', 'C7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(87, 'ANDA ARI IRAWAN BIN IRFAINI', 'BI.N 345/2022', '2022-05-19', '2027-01-14', NULL, 'C', 'C3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(88, 'ANDHI WAHYUDIONO BIN SURAHMAD', 'AII. 362/2025', '2025-10-30', '2026-02-03', NULL, 'A', 'A3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(89, 'ANDHIKA HERU WIJAYA BIN NURHADI SISWANTO', 'AIII. 333/2025', '2025-10-14', '2026-02-15', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(90, 'ANDI ADAM PRATAMA BIN MUGENI', 'BI.N 167/2024', '2024-03-06', '2029-08-22', 'ANDIK', 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(91, 'ANDI BAYU PRASETYO BIN NANANG PRAYOGO', 'AV.N 016/2025', '2025-02-11', '2026-03-25', NULL, 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(92, 'ANDI FERISTIAWAN BIN SUGENG', 'BI.N 497/2023', '2023-04-12', '2027-11-24', 'PENDEK', 'C', 'C6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(93, 'ANDI SAMUDRA AL FATEKHA BIN DARWANTO', 'BI. 261/2025', '2025-02-25', '2042-12-30', 'GARENG', 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(94, 'ANDIK ARIYANTO BIN SUPARLAN (ALM)', 'BI.N 191/2024', '2023-12-12', '2029-03-14', 'GONDEK', 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(95, 'ANDIK SANTOSO BIN TAYES (ALM)', 'BI.N 351/2021', '2021-05-03', '2027-08-09', NULL, 'BA', 'BA13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(96, 'ANDIKA WISNU WIJAYA BIN ANDI SUTRISNO', 'BI. 137/2024', '2024-01-17', '2029-03-10', 'DIKA', 'BA', 'BA11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(97, 'ANDREAN AHMAT FARESI BIN SLAMET WAHYUDI', 'BI.N 258/2025', '2025-05-16', '2029-04-25', 'ANDRE', 'C', 'C17', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(98, 'ANDRI PURWO PUTRO BIN HARIONO', 'AIIIN. 348/2025', '2025-07-23', '2026-02-24', NULL, 'BA', 'BA1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(99, 'ANDRI SUYANTO BIN DACHLAN', 'BI.N 565/2023', '2023-06-08', '2028-01-29', 'KENTOS', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(100, 'ANDRIANTO BIN GUNARTO (ALM)', 'BI.N 212/2025', '2024-08-12', '2027-05-09', 'BANDREK', 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(101, 'ANDRIANTO BIN MUZAKKI', 'BI.N 208/2024', '2024-03-26', '2030-03-04', 'AMBON', 'BA', 'BA1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(102, 'ANDRIE EKA BASTIAN BIN HAMZAR BASTIAN', 'AVN. 023/2025', '2025-03-17', '2026-04-17', 'ANDRIA', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(103, 'ANDUNG SUDARIYONO BIN TAMADI (ALM)', 'BI.N 102/2025', '2024-11-13', '2029-07-11', NULL, 'A', 'A2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(104, 'ANITA RINI AGUSTIN BINTI SADIR', 'BI.P 004/2025', '2025-01-30', '2026-01-14', NULL, 'WANITA', '4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(105, 'ANSORI BIN MOCH SAWIR', 'BI.N 467/2023', '2023-09-12', '2027-11-03', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(106, 'ANTIKA SITI ALPIYAH BINTI DARYANTO', 'BI.P 008/2025', '2025-03-17', '2027-03-13', 'TIKA', 'WANITA', '4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(107, 'ANTONIUS DANANG SUPANTORO BIN TARSISIUS SUPARGE', 'AI. 391/2025', '2025-12-23', '2026-01-21', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(108, 'ANWAR SADAD BIN ABDUL KOLIK (ALM)', 'BI. 265/2025', '2025-04-17', '2033-03-26', 'KAWUK', 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(109, 'APRIL MUHIBDIYANTO BIN SLAMET', 'BI.N 181/2024', '2024-07-09', '2028-09-20', 'KABIR', 'BA', 'BA10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(110, 'APRILIANGGA BIN M. HASYIM', 'AIIN. 356/2025', '2025-08-31', '2026-01-28', 'BANGOR', 'D', 'D4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(111, 'ARDI SEPTIAWAN BIN BACHRUL ROZI', 'BI.N 222/2025', '2025-01-30', '2026-06-23', NULL, 'BA', 'BA1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(112, 'ARDIANSYAH PUTRA WIJAYA BIN NOVIANTO', 'AIV. 064/2025', '2025-03-27', '2026-01-22', 'SALIKIN', 'D', 'D4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(113, 'ARI KURNIAWAN BIN SUKAMTO', 'BIIa. 100/2025', '2025-03-17', '2026-03-01', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(114, 'ARIADI BIN CHANDRA', 'BI.N 283/2025', '2025-03-25', '2036-03-24', 'ACONG', 'C', 'C10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(115, 'ARIES PRADANA BIN SUWARNO', 'AI. 343/2025', '2025-10-30', '2026-01-12', NULL, 'A', 'A3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(116, 'ARIF NASRULLAH BIN MUCHLASON', 'BI.N 184/2025', '2025-01-30', '2030-03-22', 'AYIK', 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(117, 'ARIF WICAKSONO BIN WIJI (ALM)', 'BI.N 303/2025', '2024-12-05', '2028-11-19', 'GUK YEH', 'C', 'C6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(118, 'ARIF WIDARMOKO BIN IMAM SUPARDI', 'BI.N 056/2024', '2023-08-14', '2027-07-17', 'ABLEH', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(119, 'ARIFIN BIN AMIN', 'AII. 365/2025', '2025-08-31', '2026-01-11', 'ARIF', 'A', 'A4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(120, 'ARIS CANDRA LIANTO BIN SULIKAN', 'BI. 175/2025', '2025-01-09', '2028-01-16', NULL, 'BA', 'BA11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(121, 'ARIS SETIYAWAN BIN ASEP ROEBY SOETOPO', 'AIIIN 325/2025', '2025-08-31', '2026-02-02', NULL, 'A', 'A13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(122, 'ARIS ZUWANTO BIN ABDULLAH', 'BI. 316/2025', '2025-08-26', '2027-03-21', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(123, 'ARISANTO BIN ABU HARSONO', 'BI. 053/2024', '2023-12-12', '2028-11-04', NULL, 'A', 'A5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(124, 'ARY HANDOKO, S.H BIN USMAN (ALM)', 'BI. 174/2023', '2022-08-25', '2029-06-09', 'HAN', 'BA', 'BA13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(125, 'ARY PRASTYO BIN DOJYO', 'BI.N 062/2024', '2023-10-16', '2029-01-18', 'DORI', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(126, 'ARYA INDRAYANA BRAMASTA BIN NARIONO', 'BI.N 028/2025', '2024-09-24', '2028-04-17', 'PITIK', 'A', 'A13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(127, 'ARYA NANDA PRATAMA BIN AGUS SUPRIADI', 'BI.N 557/2023', '2022-11-14', '2027-12-27', NULL, 'STRAF SEL', 'STRAF SEL 2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(128, 'ASEP ROEBY SOETOPO BIN KAMSILAN (ALM)', 'BI.N 032/2023', '2022-06-15', '2027-04-29', NULL, 'A', 'A13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(129, 'ASMADI BIN TAMANI', 'BI.N 379/2023', '2023-07-18', '2026-10-10', 'AAS', 'A', 'A10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(130, 'AUNIUR ROUF BIN SUTIMAN', 'BI. 136/2025', '2025-06-10', '2027-11-18', NULL, 'BA', 'BA2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(131, 'AWANG HERMANTO BIN MANSUR (ALM)', 'BI.N 284/2025', '2025-03-25', '2033-03-24', NULL, 'C', 'C5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(132, 'AZI YUSVA MEGA PUTRA BIN JAYA SUPENO', 'BI.N 182/2024', '2024-08-12', '2028-01-28', 'ENCEP', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(133, 'AZIZ SUHADA BIN MAMAD', 'BI.N 131/2024', '2024-03-21', '2030-05-29', NULL, 'C', 'C8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(134, 'BAGAST TRISTYANTO PUTRA BIN SUGIANTO', 'BI. 124/2025', '2025-06-10', '2026-10-09', NULL, 'A', 'A9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(135, 'BAGUS ADIANSYAH BIN SUHARIYONO', 'BI.N 234/2025', '2025-03-17', '2031-08-29', NULL, 'C', 'C2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(136, 'BAGUS ARDIANTO BIN SUWANTO (ALM)', 'BI.N 307/2025', '2025-01-09', '2029-01-04', 'BAJOL', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(137, 'BAGUS CANDRA TRI WAHYUDI BIN KUNAR FATONI (ALM)', 'BI.N 170/2024', '2024-07-08', '2028-11-30', NULL, 'C', 'C7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(138, 'BAGUS NURDIANSYAH BIN SUDARTO (ALM)', 'BI.N 546/2023', '2023-06-08', '2026-01-21', 'JALU', 'C', 'C7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(139, 'BAGUS PRASETIYO BIN MISMAN', 'BI.N 153/2023', '2022-09-05', '2027-06-01', 'BLOTONG', 'C', 'C4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(140, 'BAGUS PRAYOGO BIN M. KHAFID', 'AIIIN. 312/2025', '2025-06-24', '2026-01-19', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(141, 'BAGUS SAPUTRA BIN SUWAJI', 'AIII. 314/2025', '2025-06-24', '2026-01-21', NULL, 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(142, 'BAGUS SUGARAH BIN KUAT WIBOWO', 'BI.N 187/2025', '2025-01-09', '2029-09-08', 'KUAT', 'C', 'C6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(143, 'BAGUS WIBISONO ALIAS TELO BIN SUDJIONO (ALM)', 'BI.N 266/2025', '2024-12-05', '2033-01-18', 'TELO', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(144, 'BAHAR HERMANSYAH BIN DATENG', 'BI.N 083/2025', '2024-09-24', '2028-10-10', NULL, 'A', 'A9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(145, 'BAHRUL IMANNUDIN KHAQ BIN EDI SANTOSO', 'AV.N 014/2025', '2025-02-11', '2026-03-18', NULL, 'C', 'C4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(146, 'BAHRUS SHOLEH BIN KHABIB SHOLEH', 'BI.N 117/2024', '2023-12-20', '2027-03-26', 'MONYOR', 'A', 'A6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(147, 'BAMBANG BIN SUKADI', 'BI. 192/2024', '2024-06-24', '2027-08-24', 'AGUS', 'A', 'A12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(148, 'BAMBANG KANDI KRESTANTO BIN SUROSO (ALM)', 'AVN. 028/2025', '2025-03-25', '2026-05-21', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(149, 'BAMBANG RISDIANTO BIN USUP KUSUMODIHARJO (ALM)', 'BI.K 058/2024', '2024-04-04', '2027-08-25', NULL, 'BA', 'BA3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(150, 'BANYU TOPAN BIN KASIMAN', 'BI.N 048/2024', '2023-05-05', '2028-09-13', 'JEBAT', 'D', 'D4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(151, 'BASUKI RAHMAD BIN TARMUJI', 'BI.N 092/2024', '2023-10-04', '2031-03-20', 'LEK', 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(152, 'BAYU HUDAYANA BINEDI SUBAGIYO', 'AIIIN. 364/2025', '2025-08-31', '2026-03-11', NULL, 'C', 'C11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(153, 'BENI UTOMO BIN SUGIANTO(ALM)', 'BI. 089/2024', '2023-12-12', '2030-03-10', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(154, 'BIMA EKA PUTRA BIN RAJIAN', 'AI. 385/2025', '2025-12-23', '2026-02-01', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(155, 'BIMA TRIO PRAYOGI BIN SUYADI (ALM)', 'BI.N 178/2024', '2024-05-27', '2028-09-07', 'GUNDUL', 'BA', 'BA6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(156, 'BUDI SANTOSO BIN SUTIYO URIP (ALM)', 'AI. 389/2025', '2025-12-23', '2026-01-08', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(157, 'BUDI SUSENO BIN SUKAMTO', 'BI. 037/2025', '2024-10-15', '2027-03-08', NULL, 'A', 'A6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(158, 'BUDI TRIANTO BIN SUMARNO', 'BI.N 330/2022', '2022-01-04', '2027-10-11', 'BOH', 'C', 'C16', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(159, 'BUDIANTO BIN RAKI', 'BI. 385/2023', '2023-07-18', '2028-09-17', NULL, 'BA', 'BA6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(160, 'BUDIONO PURNOMO BIN SAIDI (ALM)', 'B.I 089/2023', '2023-01-26', '2029-05-21', 'BUDI', 'BA', 'BA1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(161, 'BUNALI BIN MARJU', 'BI.N 473/2023', '2023-09-12', '2028-07-30', NULL, 'A', 'A10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(162, 'BUSUR KRISMA AJI BIN SURI', 'AI. 374/2025', '2025-12-03', '2026-01-19', 'KRIS', 'A', 'A3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(163, 'BUWADI BIN KUSEN (ALM)', 'BI. 009/2023', '2022-08-02', '2029-05-02', NULL, 'BA', 'BA13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(164, 'CAHYO AGUS YULIANTO BIN SUBAKIR', 'BI. 315/2025', '2025-08-26', '2027-01-20', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(165, 'CANDRA ADI DAYA BIN SUHADI', 'BI.N 116/2024', '2023-12-20', '2027-03-26', 'CECEP', 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(166, 'CANDRA BIMANTARA ARIFIN BIN ZAINAL ARIFIN', 'AIIN 358/2025', '2025-08-31', '2026-01-29', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(167, 'CATUR LUTFI HIMAWAN BIN MOENADJI (ALM)', 'BI.N 525/2023', '2023-11-03', '2028-09-04', NULL, 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(168, 'CHENDI PRATAMA BIN SUGIANTO', 'BIIa. 105/2025', '2025-05-16', '2026-05-04', NULL, 'A', 'A1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(169, 'CHOIRIYAH BINTI SARPOH (ALM)', 'BI.PN 002/2025', '2024-03-06', '2027-10-15', 'RIA', 'WANITA', '3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(170, 'CHOIRUL MUKMININ BIN SALI', 'BI.N 173/2025', '2024-08-12', '2029-11-03', 'IRUL', 'C', 'C4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(171, 'CHRISTIANI YULI LARASATI BINTI KOESWANTORO (ALM)', 'AIIIP. 016/2025', '2025-08-26', '2026-01-25', NULL, 'WANITA', '4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(172, 'DADANG KURNIAWAN BIN SUTRISNO', 'AIVN. 061/2025', '2025-04-17', '2026-01-15', 'MEE', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(173, 'DANANG PRAYITNO BIN SLAMET', 'AIIIN. 321/2025', '2025-06-24', '2026-01-26', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(174, 'DANDI RIZKIAWAN BIN SAMU\'IN', 'BI.N 02/2023', '2022-10-19', '2029-12-09', 'MBAH', 'C', 'C16', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(175, 'DANI EKA BUDI ERFANI BIN HUSNI TAMRIN', 'BI.N 094/2024', '2023-06-08', '2027-07-18', 'ACIL', 'A', 'A12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(176, 'DANU PRASTIYO BIN WIRYO', 'BI. 138/2025', '2025-02-11', '2033-09-26', 'GENDUT', 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(177, 'DANY TRI HARIYONO BIN SUBADI (ALM)', 'BI.N 221/2025', '2024-10-22', '2031-09-15', 'SETROK', 'C', 'C4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(178, 'DARA ARI KUNTORO BIN PARIYADI', 'BI.N 102/2023', '2022-05-19', '2027-11-09', NULL, 'C', 'C4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(179, 'DAVID ANDRIANTO BIN SUKADI', 'BI.N 353/2023', '2022-12-12', '2029-09-13', 'KORENG', 'C', 'C4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(180, 'DAVID SUBAGIYO BIN TAKAT ALMARTA (ALMARHUM)', 'BI.N 153/2025', '2025-06-25', '2028-01-24', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(181, 'DEDI FARISTIA GUNATA BIN KANAN', 'BI.N 428/2023', '2023-08-18', '2028-12-24', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(182, 'DEDIK HARIYO SANTOSO BIN SUWARDI', 'BI.N 142/2024', '2023-10-04', '2026-03-14', NULL, 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(183, 'DEDIK SUPRIYANTO BIN SANUSI', 'BI. 133/2025', '2025-06-10', '2027-02-01', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(184, 'DENDIK ANGGA IRIANTO BIN KAREN', 'AIVN 068/2025', '2025-06-04', '2026-02-17', 'LONGOR', 'C', 'C17', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(185, 'DENI KURNIAWAN BIN YATIMAN (ALM)', 'BIIa. 109/2025', '2025-06-04', '2026-02-14', NULL, 'A', 'A10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(186, 'DENNY ERFIANTO BIN SULIYONO (ALM)', 'AVN. 031/2025', '2025-03-25', '2026-05-01', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(187, 'DENY FAKHRUDIN BIN ABDUL WAKHCID (ALM)', 'AIVN. 075/2025', '2025-05-16', '2026-03-03', 'PUNUK', 'C', 'C5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(188, 'DENY HANDOYO BIN BAMBANG JOKO MULYONO', 'AIII. 367/2025', '2025-10-14', '2026-03-12', NULL, 'A', 'A14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(189, 'DIAN ARINI BINTI SUWAJI', 'AI.PN 018/2025', '2025-10-30', '2026-01-07', NULL, 'WANITA', '4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(190, 'DIAN ERWANTO BIN NURPA\'I', 'BI. 131/2025', '2025-06-10', '2027-06-17', NULL, 'BA', 'BA1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(191, 'DICKY ALFATHTONI RAMADHAN BIN PITONO', 'BI.N 115/2024', '2024-01-17', '2027-03-26', 'TENGKEK', 'BA', 'BA6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(192, 'DICKY FARID ARIFUDIN BIN M. SAIFUDIN', 'AI.N 331/2025', '2025-10-30', '2026-01-08', 'BOWO', 'C', 'C5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(193, 'DICKY FIRMAN RIZARD BIN SUKIR', 'BI. 255/2025', '2025-05-16', '2027-10-31', NULL, 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(194, 'DIDIK NUR HADI BIN (ALM) HADI AGUSTIAN', 'BI.N 137/2025', '2024-09-24', '2031-01-24', 'JEMBLONG', 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(195, 'DIDIK WINARTO BIN TAMAN (ALM)', 'B.I. 316/2023', '2023-05-31', '2029-09-03', NULL, 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(196, 'DIDIN EKO WARDONO BIN SUJAK', 'BI.N 262/2025', '2025-06-26', '2033-08-09', 'DEDIN', 'A', 'A11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(197, 'DIDIT ADITYA BIN TOTOK SUYANTO', 'BI.N 488/2023', '2023-03-21', '2028-01-23', 'WAK NYO', 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(198, 'DIKI MAULANA BIN EDY HARIONO', 'BI. 548/2023', '2023-05-05', '2027-07-10', NULL, 'C', 'C16', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(199, 'DIMAS ALDI FIRMANSYAH BIN M ZAINURI', 'BI.N 211/2025', '2025-01-09', '2032-03-26', NULL, 'BA', 'BA2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(200, 'DIMAS ALFIAN SUAPRIANTO BIN BUDI PURWANTO', 'BI.N 146/2024', '2024-03-06', '2030-08-22', NULL, 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(201, 'DIMAS TRI CAHYONO BIN EDI MURYANTO', 'AIII. 368/2025', '2025-10-30', '2026-03-12', 'JINJET', 'A', 'A13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(202, 'DIYAN ARIFIN BIN M. ZAKARIA', 'BI. 237/2025', '2025-02-25', '2027-01-10', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(203, 'DODIK EFENDI BIN MUDAKIR', 'BI.N 569/2023', '2023-01-18', '2027-11-12', 'KENZO', 'C', 'C1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(204, 'DONI OKTAVIANUS BIN ABU MUALIM (ALM)', 'AIII. 324/2025', '2025-08-31', '2026-01-29', NULL, 'BA', 'BA2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(205, 'DONY EKA PRASETIA BIN SOLIKIN (ALM)', 'BI. 128/2025', '2025-06-10', '2028-08-25', NULL, 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(206, 'DWI AGUS SETYAWAN BIN SUWANDI', 'BI.N 244/2023', '2022-05-17', '2029-12-20', 'CEPER', 'C', 'C10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(207, 'DWI ANDRIANSYAH BIN AGUS KARIYANTO', 'AI. 384/2025', '2025-12-23', '2026-02-01', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(208, 'DWI ANGGARA BIN ALI (ALM)', 'BI. 176/2023', '2022-09-28', '2031-01-20', 'UCOK', 'BA', 'BA11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(209, 'DWI BAYU AJI BIN TRI DJONARKO', 'AI.N 365/2025', '2025-12-03', '2026-01-11', NULL, 'C', 'C8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(210, 'DWI PURWANTO BIN KASTURI', 'BI.N 041/2025', '2024-10-22', '2029-06-17', 'NDAWIR', 'C', 'C9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(211, 'EDI WIDAYANTO BIN WARIDI', 'BI. 249/2025', '2025-04-17', '2026-07-01', NULL, 'A', 'A11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(212, 'EDY SUMARNO BIN HARIANTO', 'BI. 289/2025', '2025-06-24', '2028-12-11', NULL, 'BA', 'BA1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(213, 'EKA ARDIANSYAH BIN MINAL FAIZIN', 'AIII. 347/2025', '2025-10-14', '2026-02-24', NULL, 'D', 'D2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(214, 'EKO AGUS SETYAWAN BIN SRIYADI', 'AIIN. 372/2025', '2025-10-30', '2026-01-13', NULL, 'C', 'C8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(215, 'EKO FITRIANTO BIN ALEX SISWADI', 'AIV. 060/2025', '2025-03-25', '2026-01-15', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(216, 'EKO HARI PURNOMO BIN ARUMAN', 'BI. 245/2025', '2025-06-30', '2028-05-04', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(217, 'EKO JALU SULAKSONO BIN RAMOJO SOEJOTO', 'AI N 397/2025', '2025-12-23', '2026-01-27', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(218, 'EKO NUR AKBAR PUTRA PRATAMA BIN SULAIMAN', 'BI. 033/2024', '2023-08-29', '2031-04-18', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(219, 'EKO SUSANTO BIN SUNDARI (ALM)', 'BI. 081/2025', '2025-01-09', '2026-10-10', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(220, 'EKO ZAIWAN FITRIANTO BIN ZAINUDIN', 'AI.N 299/2025', '2025-10-14', '2026-01-10', NULL, 'A', 'A12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(221, 'ERICH SATRIYO NUGROHO BIN GATOT SUBROTO', 'BI.N 431/2023', '2023-08-18', '2028-04-02', NULL, 'C', 'C16', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(222, 'ERWIN ANDRIAN BIN SARIAN', 'BI.N 068/2023', '2022-05-30', '2029-06-05', 'BOLENG', 'D', 'D3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(223, 'ERWIN PRANATA BIN DJOKO WALUYO', 'BI. 112/2025', '2025-06-10', '2028-06-19', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(224, 'FADIL AMZAH BIN ACHMAD MARZUKI', 'BI.N 050/2023', '2023-01-19', '2028-07-28', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(225, 'FADLI NURULARDI BIN AISMAN', 'BIIa. 088/2025', '2025-03-17', '2026-03-04', 'ASDOL', 'BA', 'BA5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(226, 'FAISAL ADITYA BIN NUR FALIQ', 'BI.N 105/2024', '2023-08-29', '2028-10-26', NULL, 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(227, 'FAISAL RISKI BIN EFENDI', 'BI.N 090/2025', '2024-10-22', '2029-12-13', NULL, 'C', 'C5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(228, 'FAJAR ALFARITZI BIN SLAMET', 'BI.N 079/2024', '2023-07-24', '2027-12-03', 'BONENG', 'C', 'C3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(229, 'FAJAR LUSMANTO BIN M FATCHI', 'BI.N 475/2023', '2023-09-12', '2028-01-04', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(230, 'FAJAR RAMADHANI BIN BUNAWI (ALM)', 'AIIN. 357/2025', '2025-08-31', '2026-01-29', 'SOTO', 'A', 'A3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(231, 'FAKHRUDDIN ARROZY BIN BADRINOERDIANSYAH', 'BI.N 188/2025', '2024-11-13', '2030-12-21', NULL, 'C', 'C7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(232, 'FANDI NOVAL BACHTIAR BIN FATCHUR ROCHIM', 'AI.N 334/2025', '2025-10-30', '2026-01-15', NULL, 'A', 'A10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(233, 'FARI FERDIYAN NASRULLAH BIN HARIYANTO', 'AIII. 322/2025', '2025-08-31', '2026-01-26', NULL, 'A', 'A11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(234, 'FARID SYAIFUDIN BIN TUWAJI', 'AIIIN. 305/2025', '2025-06-24', '2026-02-11', NULL, 'A', 'A4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(235, 'FARIZKY TRI MAULANA YUSUF BIN WARLIK', 'BI. 304/2025', '2025-06-04', '2033-05-22', 'TRIMY', 'BA', 'BA11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(236, 'FATHKURROJI BIN SAMSUL HUDA', 'BI.N 180/2024', '2024-07-09', '2028-09-20', 'TUEK', 'C', 'C16', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(237, 'FATHUR SAFA BIN SUGENG PURWANTO (ALM)', 'AIIIN. 369/2025', '2025-11-27', '2026-03-15', NULL, 'C', 'C7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(238, 'FATQUR ROHMAN BIN SUNARDI', 'AIII. 342/2025', '2025-10-14', '2026-02-22', NULL, 'A', 'A14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(239, 'FEBRI WAHYUDI BIN SUWONO', 'BI. 263/2025', '2025-02-11', '2037-12-11', NULL, 'A', 'A5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(240, 'FELIX ANGGORO KASIH BIN DENDA LIANTORO', 'BI.N 177/2024', '2024-07-24', '2028-03-09', NULL, 'BA', 'BA8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(241, 'FERA SETYA PUTRI BINTI RIFAI', 'AIVPN. 004/2025', '2025-04-24', '2026-01-11', NULL, 'WANITA', '4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(242, 'FERDI KRISDIANTO BIN PADELAN', 'BI.N 109/2025', '2024-12-05', '2032-07-09', 'KENTIT', 'A', 'A12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(243, 'FERI EKO SETIAWAN BIN ZAINUDIN', 'AIII. 338/2025', '2025-10-14', '2026-02-23', NULL, 'A', 'A9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(244, 'FERIS HERMANTO BIN SALI', 'BI.N 239/2025', '2025-03-17', '2032-09-07', NULL, 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(245, 'FERRY BIN KASBI', 'BI. 119/2025', '2025-06-10', '2026-11-10', NULL, 'BA', 'BA2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(246, 'FIKI NUR HIDAYAT BIN ISNUN SYAHRONI', 'BI.N 218/2024', '2024-08-12', '2031-11-04', NULL, 'A', 'A11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(247, 'FIQI EFFENDI BIN AMIR MAKMUN (ALM)', 'BI.K 292/2025', '2024-10-01', '2028-08-17', NULL, 'BA', 'BA3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(248, 'FIRDI DWI ANGGA BIN KOIRUL ANAM', 'BI.N 236/2025', '2025-03-17', '2032-10-06', 'ANGGA', 'C', 'C17', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(249, 'FIRMANDA AL MA\'RUF BIN MUHTAR HARIONO', 'AIIN. 374/2025', '2025-08-31', '2026-01-13', 'BRIK', 'C', 'C8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(250, 'FRAHASYA ADYTYA WASMA BIN SUGENG WAHYUDI', 'BI.N 079/2025', '2024-08-12', '2030-01-25', NULL, 'C', 'C6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(251, 'FURQONI BIN DIMYATI (ALM)', 'B.I 175/2024', '2024-05-06', '2029-03-24', NULL, 'BA', 'BA10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(252, 'G JOKO IRIANTO BIN H SULAIMAN', 'BI. 238/2025', '2025-02-25', '2028-06-22', NULL, 'A', 'A1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(253, 'GAGUK PRASETYAWAN BIN DJANIMAN', 'AIII. 344/2025', '2025-10-14', '2026-02-23', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(254, 'GALANG PRASETYO AJI BIN SLAMET', 'BI.N 161/2024', '2024-06-26', '2029-03-16', NULL, 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(255, 'GALIH PRAMESTA BIN H. SOLIKIN', 'BI.N 221/2024', '2024-08-27', '2029-11-29', 'HOLIP', 'A', 'A6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(256, 'GATOT SAMUDRA BIN SULANI (ALM)', 'BI.N 282/2025', '2025-03-25', '2032-01-11', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(257, 'GIGIK IKMAWAN BIN BUDIONO', 'BI.N 209/2025', '2025-01-30', '2026-06-19', 'PENCULIT', 'A', 'A9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(258, 'GILANG ADI SASONGKO BIN SUMONO', 'BI.N 006/2025', '2024-08-12', '2031-11-12', NULL, 'D', 'D4', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(259, 'GUNAWAN ADI SAPUTRO BIN MARIJONO', 'AI N 398/2025', '2025-12-23', '2026-02-04', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(260, 'GUNDRIK ANDRIARDI BIN SUWARDI', 'BI.N 090/2024', '2023-12-12', '2029-09-08', NULL, 'C', 'C17', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(261, 'GURUH SURYA SAPUTRA BIN M SURYADI', 'B.I N 074/2023', '2023-01-26', '2028-04-12', NULL, 'A', 'A9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(262, 'H MAHFUD BIN SAHWERI', 'BI.N 460/2023', '2023-09-12', '2027-07-26', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(263, 'HABIB MURTADLO BIN ACHMAD SLAMET', 'AIIIN. 302/2025', '2025-06-24', '2026-01-06', NULL, 'C', 'C2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(264, 'HADI PRANATA BIN KARSAN', 'AII. 366/2025', '2025-11-18', '2026-01-11', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(265, 'HADI PRAYITNO BIN TOHIR SANTOSO', 'AI.N 367/2025', '2025-12-03', '2026-01-12', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(266, 'HALIMAN BIN SADI (ALM)', 'BI.N 130/2024', '2023-12-20', '2029-10-05', 'MAN', 'D', 'D3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(267, 'HAMSAH BIN DARIUS YAN', 'BI.N 375/2023', '2023-07-18', '2026-03-10', NULL, 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(268, 'HAMSAH KURNIA PUTRA BIN KUKU WALUYO', 'BI.N 193/2025', '2025-07-18', '2026-02-08', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(269, 'HANDOKO BIN SEGER', 'AIV. 076/2025', '2025-08-31', '2026-01-09', NULL, 'BA', 'BA5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(270, 'HANIF MANSUR MUSTOFA BIN ABU BAKAR', 'AV. 032/1025', '2025-02-25', '2026-03-29', 'KEJENG', 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(271, 'HANIF RIDHO PRIYOKO BIN MACHFUD (ALM)', 'BI.N 169/2025', '2025-06-25', '2026-04-27', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(272, 'HARI JULIANTORO BIN MARDIJANTO', 'BI.N 045/2023', '2023-01-19', '2029-07-16', 'RAMPOK', 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(273, 'HARI UTAMA BIN MUHTADI (ALM)', 'AI.N 329/2025', '2025-10-30', '2026-01-07', NULL, 'C', 'C13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(274, 'HARIONO BIN BADRUN (ALM)', 'BI.N 179/2025', '2024-07-24', '2027-03-08', 'BADRUN', 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(275, 'HARISUL MUTTAQIN BIN M. ANWAR', 'BI. 095/2025', '2024-11-13', '2027-12-08', NULL, 'A', 'A10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(276, 'HARTINI BINTI SUROTO (ALM)', 'AIIIP. 017/2025', '2025-10-14', '2026-03-09', NULL, 'WANITA', '3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(277, 'HARTO UTOMO BIN BUAMIN (ALM)', 'BI.N 198/2024', '2024-04-09', '2028-10-07', NULL, 'A', 'A9', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(278, 'HARTONO BIN HERMANTO', 'AIVN. 080/2025.', '2025-05-16', '2026-03-04', 'MANDONO', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(279, 'HARTONO BIN KASELAN', 'BI. 264/2025', '2025-06-24', '2027-01-18', 'HAR', 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(280, 'HENDRA PRASETYO NUGROHO BIN BUDI P', 'BI. 195/2022', '2021-11-29', '2029-03-06', NULL, 'BA', 'BA8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(281, 'HENDRA WIJAYA BIN ROHMAN', 'AIII. 353/2025', '2025-10-14', '2026-03-02', NULL, 'D', 'D5', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(282, 'HENDY SUDARYANTO BIN SUPANDI', 'BI.N 059/2025', '2024-09-24', '2030-10-30', 'SIWO', 'BA', 'BA14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(283, 'HENGKY PURWANTO BIN BAMBANG EDI PURNOMO', 'BI.N 132/2024', '2024-01-17', '2029-04-22', NULL, 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(284, 'HERLAMBANG BINTARA SETIAWAN BIN ANDRIANTO', 'BI. 269/2025', '2025-03-17', '2028-09-07', 'LAMBANG', 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(285, 'HERMANSYAH BIN YULIANSYAH (ALM)', 'AII. 370/2025', '2025-11-18', '2026-01-12', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(286, 'HERU CAHYO SETIYONO BIN SUPRAPTO (ALM)', 'BI.K 074/2017', '2015-12-08', '2026-04-26', NULL, 'BA', 'BA3', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(287, 'HERU FACHRUDIN BIN IBRAHIM', 'BI. 293/2025', '2025-07-23', '2027-04-29', 'HERU', 'A', 'A12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(288, 'HERU PRASETYO BIN SUGIANTO', 'BI.N 033/2025', '2024-01-26', '2027-05-21', NULL, 'C', 'C8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(289, 'HERU SANTOSO BIN SARNO MASDUKI', 'AI.N 303/2025', '2025-10-14', '2026-01-24', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(290, 'HERY SUSANTO BIN AHMAD SUGENG', 'BI.N 046/2025', '2024-09-11', '2028-08-21', 'KETEK', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(291, 'HERY SUSETYO BIN SUSWARDONO', 'BI.N 494/2023', '2023-03-21', '2028-02-25', 'HERI MAMA', 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(292, 'HIDAYATUL ARIF BIN PANI (ALM)', 'BI.N 259/2025', '2025-02-11', '2027-06-02', 'TUEK', 'BA', 'BA12', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(293, 'HIMAWAN MAHESUDHI BIN SYAFI\'INA', 'AI. 383/2025', '2025-12-23', '2026-01-21', NULL, 'D', 'D6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(294, 'HOIRUL ANAM BIN JAELANI', 'BI. 287/2025', '2025-06-04', '2033-04-29', NULL, 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(295, 'HUJANG MOMON BIN WADI', 'BI. 207/2025', '2025-03-17', '2026-06-27', NULL, 'A', 'A8', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(296, 'IBNU RAKHMAD HIDAYAH BIN -', 'BI. 252/2025', '2025-06-04', '2026-11-13', NULL, 'D', 'D2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(297, 'IBRA KRISNA BIN DANY ISWANDY', 'BI. 115/2025', '2025-06-10', '2026-12-14', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(298, 'IDA SURYAWATI BIN SOHOR', 'AIIP. 019/2025', '2025-10-14', '2026-01-21', NULL, 'WANITA', '1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(299, 'IIR YUSWANTORO BIN SUYONO (ALM)', 'AIIIN. 351/2025', '2025-08-26', '2026-03-01', 'COKIL', 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(300, 'IKE DEWI SARTIKA BINTI MUNAIM', 'AI. PN. 020 / 2025', '2025-12-23', '2026-02-14', NULL, 'WANITA', '1', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(301, 'ILHAM RIONALDI RIANTORO BIN JAENAL SOEKANTO', 'BI. 231/2025', '2025-03-25', '2026-10-24', 'RIO', 'A', 'A11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(302, 'IMAM FAUZI BIN SUPARLAN', 'BI.N 187/2024', '2024-08-12', '2031-06-08', 'CINO', 'C', 'C10', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(303, 'IMAM HARIRI BIN TAMANI', 'BI.N 377/2023', '2023-07-18', '2026-10-07', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(304, 'IMAM MUJAHIDIN BIN CHOLIL', 'BI.N 471/2023', '2023-09-12', '2028-05-22', NULL, 'C', 'C16', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(305, 'IMAM SANTOSO BIN WARTONO', 'BI.N 095/2024', '2023-04-12', '2027-11-24', 'PAELA', 'C', 'C6', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(306, 'IMAM SUBEKI BIN SUBUR ALAM', 'BI. 189/2025', '2025-04-17', '2026-08-21', 'BONJOL', 'A', 'A11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(307, 'IMAM SUTRISNO BIN SUWONO', 'BI.N 184/2024', '2024-05-27', '2029-11-10', 'GANDEN', 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(308, 'INDRA TEGUH WAHYUDI BIN SUJONO (ALM)', 'AI.N 304/2025', '2025-10-14', '2026-01-28', NULL, 'A', 'A14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(309, 'IQBAL ARIF BIN ARIF SUPRAYOGI', 'BI.N 013/2025', '2024-08-12', '2029-02-11', NULL, 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(310, 'IRDANZIZ ZAMRONI BIN USMAN', 'BI.N 420/2023', '2023-02-01', '2028-12-23', NULL, 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(311, 'IRHAM FAHRIHIN BIN SLAMET', 'AIV.N 081/2025', '2025-06-24', '2026-02-10', 'IPUNG', 'C', 'C15', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(312, 'ISDIANTORO BIN NIZARWAN', 'BIIa. 101/2025', '2025-03-17', '2026-01-07', NULL, 'A', 'A2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(313, 'ISMAIL ARIANTO BIN ARCHAN MUCHTAR', 'BI. 015/2025', '2024-07-08', '2027-07-13', 'MUNIP', 'BA', 'BA7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(314, 'ISMAIL BIN SUKATO (ALM)', 'AIIIN. 334/2025', '2025-08-31', '2026-02-16', 'LIAM', 'C', 'C14', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(315, 'ISMAN BIN WAKIYO', 'AIII. 341/2025', '2025-07-23', '2026-02-22', NULL, 'A', 'A11', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(316, 'ISMANTO BIN PURNOMO', 'BI.N 220/2024', '2024-08-12', '2030-01-19', 'SATI\'ING', 'C', 'C2', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(317, 'ITTAQI TAFUZ BIN UBAIDILLAH', 'BI.N 032/2025', '2024-01-26', '2027-05-21', 'TEKEK', 'A', 'A13', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(318, 'IVAN ADAM BRAMANSYAH BIN IWAN ALVIANTO', 'BI.N 367/2023', '2023-07-18', '2027-12-30', NULL, 'A', 'A7', '2026-01-16 00:21:26', '2026-01-16 00:21:26'),
(319, 'IWAN SANTOSO BIN TATMO SUCIANTO (ALM)', 'BI.N 294/2023', '2023-05-25', '2026-02-16', NULL, 'BA', 'BA5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(320, 'IWAN UTOMO BIN SUBARI', 'BI.N 047/2024', '2023-08-29', '2027-05-07', 'HONG', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(321, 'JACKVANDEN GANGGADARMA JUNI GLORIA BIN NATANAEL JUNANI', 'AV. 017/2025', '2025-01-09', '2026-04-22', NULL, 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(322, 'JAELANI BIN SAMURI', 'BI.N 568/2023', '2022-08-15', '2027-05-11', 'ALAN', 'D', 'D4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(323, 'JAMIL BIN SAKRI', 'BI. 101/2024', '2023-12-12', '2030-03-04', NULL, 'A', 'A5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(324, 'JAMINAL BIN SAMIADI', 'BI.N 153/2024', '2024-07-08', '2029-11-29', 'BATAK', 'C', 'C4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(325, 'JAWA AYOGA BIN SARWADI (ALM)', 'BI.N 018/2025', '2024-07-24', '2030-12-02', NULL, 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(326, 'JIE KO MING BIN JIE CHUN SIN', 'AI. 381/2025', '2025-12-03', '2026-01-11', 'AMING', 'C', 'C12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(327, 'JIHAN HILMI BIN NURUL HAKIM', 'BI.N 233/2023', '2022-10-18', '2027-05-06', 'JEMBLONG', 'C', 'C4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(328, 'JODY SURYA PRATAMA BIN LILIK WIYANTO', 'BI.N 169/2023', '2022-09-05', '2028-01-31', NULL, 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(329, 'JOGA SIER YUNAINI BIN BAMBANG HADI SOERJO', 'BI. 123/2025', '2025-06-10', '2026-11-12', 'YOGA ARDIANSYAH', 'D', 'D5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(330, 'JOHAN PRATOMO BIN YAKUB SULAIMAN (ALM)', 'BI. 275/2025', '2025-06-04', '2026-11-20', 'TOTOM', 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(331, 'JOKO ADREYANTO BIN SUYANTO', 'AI.N 335/2025', '2025-10-30', '2026-01-16', NULL, 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(332, 'JONI HARSONO BIN SUNARTO (ALM)', 'BI.N 308/2025', '2025-02-11', '2029-01-31', 'JONI', 'A', 'A12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(333, 'JUHAN CARLOS FERNANDO BIN KORNELIS SETIYAWAN', 'BI.N 333/2023', '2023-06-13', '2026-05-27', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(334, 'JUMADI BIN TAMAJI', 'AI. 392/2025', '2025-12-23', '2026-02-08', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(335, 'JUMANTO BIN SARMAT', 'BI.N 509/2023', '2022-12-12', '2027-10-01', 'TATO', 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27');
INSERT INTO `wbps` (`id`, `nama`, `no_registrasi`, `tanggal_masuk`, `tanggal_ekspirasi`, `nama_panggilan`, `blok`, `kamar`, `created_at`, `updated_at`) VALUES
(336, 'JUNI SAPUTRA BIN AMIRUDIN', 'AIII. 354/2025', '2025-10-14', '2026-03-02', NULL, 'A', 'A13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(337, 'KARIAWAN BIN SAGI', 'AI.N 395/2025', '2025-12-23', '2026-01-27', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(338, 'KARSONO HADI WIBOWO BIN KARSIDIN', 'BIIa. 028/2024', '2023-10-04', '2026-02-04', NULL, 'A', 'A1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(339, 'KHOIRUL ABIDIN BIN SLAMET', 'BI.N 145/2023', '2022-10-19', '2030-06-12', NULL, 'A', 'A11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(340, 'KHOIRUL ANAM BIN ISNAN', 'BI.N 108/2025', '2024-12-05', '2030-07-31', 'GECOL', 'A', 'A12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(341, 'KHOIRUL ANAM BIN SAMANHUDI', 'BI.N 196/2024', '2023-08-29', '2028-10-24', 'COPET', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(342, 'KHOIRUL ANAM BIN WARJI (ALM)', 'BI. 297/2025', '2025-05-16', '2033-04-17', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(343, 'KHOMARUDIN BIN KUSNAN', 'B.I N 425/2021', '2021-10-04', '2029-04-17', NULL, 'C', 'C9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(344, 'KHOMSUN ADHA BALIA BIN SOLEHUDIN', 'BI. 299/2025', '2025-05-16', '2030-04-17', NULL, 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(345, 'KIAN BARA BIN SETYO WAHYUDI', 'BI.N 179/2024', '2024-03-06', '2029-08-22', 'BARA', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(346, 'KRISNO BIN SAPUAN (ALM)', 'AIIIN. 328/2025', '2025-05-16', '2026-02-04', 'KIPLI', 'C', 'C8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(347, 'KUNCORO HADIYANTO BIN SILAS (ALM)', 'AIII. 363/2025', '2025-10-14', '2026-03-11', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(348, 'KUSENAN BIN SUTAWI', 'BI.N 508/2023', '2022-12-23', '2028-05-20', 'BELONG', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(349, 'KUSNADI BIN SLAMET', 'AI. 380/2025', '2025-12-03', '2026-01-12', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(350, 'LINTAR PRATAMA PUTRA BIN SUNARYO (ALM)', 'BIIa. 096/2025', '2025-03-25', '2026-03-23', 'ARI', 'A', 'A11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(351, 'LUKKY WULYONO BIN SUKIRAN', 'BI.N 196/2023', '2022-01-04', '2028-02-18', 'WUL', 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(352, 'LUKMAN ARIF KURNIAWAN BIN SUWANDI', 'BI.N 147/2024', '2023-10-20', '2029-01-16', 'DEMANG', 'C', 'C8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(353, 'LUTFI INAHNU FEDA BIN MAT SALIM ARIAN', 'AIV. 063/2025', '2025-03-25', '2026-01-22', 'BOBY', 'D', 'D4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(354, 'LUTVI ALFIAN BIN SIDIK (ALM)', 'AIIIN. 323/2025', '2025-06-24', '2026-01-27', 'FIAN', 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(355, 'M FERI BISMA RAMADHANI BIN M.JAINURI', 'BIIa.N 080/2023', '2022-03-09', '2029-11-26', 'KEHED', 'BA', 'BA1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(356, 'M IKSAN FANANI BIN SULAIMAN', 'BI.N 073/2023', '2022-07-26', '2027-09-07', NULL, 'C', 'C10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(357, 'M IMAM PATRIO BIN SUWOTO', 'BI.N 003/2025', '2024-08-12', '2028-01-26', NULL, 'C', 'C6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(358, 'M RAFI MAFAZI BIN SLAMET', 'BI.N 025/2025', '2024-07-24', '2030-02-02', NULL, 'BA', 'BA2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(359, 'M SYAIFUDIN ILHAM BIN KASTURI (ALM)', 'BI.2336/DP/K/2021', '2022-12-14', '2026-01-02', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(360, 'M. AFIF DWI WAHYUDI BIN DWI SETIAWAN', 'BI.N 204/2024', '2024-04-09', '2028-10-07', 'ITEM', 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(361, 'M. ANDRI PRASTYO BIN MUKTAROM', 'BI. 110/2025', '2025-01-09', '2027-08-17', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(362, 'M. ARBA\'I BIN JUMAD (ALM)', 'BI. 009/2022', '2021-09-01', '2033-10-22', 'BAI', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(363, 'M. ARFANDI PUTRA BIN SUDIN', 'BI.N 296/2025', '2025-06-04', '2029-05-24', NULL, 'C', 'C17', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(364, 'M. KAMIM, S.PD BIN SUPADI', 'BI. 054/2024', '2023-10-16', '2031-07-27', NULL, 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(365, 'M. KHOIRUL ANWAR BIN SOKIB', 'BI.N 198/2025', '2025-02-11', '2028-10-10', 'KAMI', 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(366, 'M. KHOYYUM BIN SUPARMAN', 'BI.N 056/2025', '2024-09-11', '2028-05-19', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(367, 'M. KUKUH CAKRA WIBAWA BIN ABDUL HADI', 'AIIN. 363/2025', '2025-08-31', '2026-01-08', 'KOKO', 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(368, 'M. MUHLISIN BIN RIDUWAN (ALM)', 'AI.N 394/2025', '2025-12-23', '2026-01-25', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(369, 'M. NURHADI BIN SAIFUL ROZI', 'AIVN 083/2025', '2025-07-23', '2026-01-21', NULL, 'A', 'A1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(370, 'M. RIZKY WAHYU FIRMANSYAH BIN ANWAR', 'BI.N 181/2025', '2024-05-27', '2030-02-26', 'CIKI', 'C', 'C17', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(371, 'M. ROMADHON BIN HADI MULYONO', 'BI.N 072/2024', '2023-08-02', '2027-05-19', 'MADUN', 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(372, 'M. SAIFULLO BIN ABDUL MALIK', 'BI.N 027/2025', '2024-07-08', '2030-11-29', 'KEBO', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(373, 'M. SHOLEH BIN MULYONO', 'BI.N 151/2023', '2022-08-25', '2027-06-04', NULL, 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(374, 'M. SOCHIB ANGSORI BIN TAUHID', 'BI.N 004/2025', '2024-09-11', '2028-02-23', 'AAN', 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(375, 'M. YUSRIL WIRIDHANA BIN M. ARIF', 'BI.N 267/2025', '2024-09-24', '2026-05-31', NULL, 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(376, 'M.AMIN BIN ABDUL MALIK', 'BI.N 419/2023', '2023-02-22', '2027-01-18', 'MINTI', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(377, 'M.ARIF TRI LAKSONO BIN WIBISONO', 'AIIN. 349/2025', '2025-08-31', '2026-01-16', 'BATANG', 'C', 'C10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(378, 'M.DANI SAPUTRA BIN KASIADI (ALM)', 'BI.N 361/2023', '2022-04-05', '2026-01-04', NULL, 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(379, 'M.YANI BIN AHMAD JUNAEDI (ALM)', 'BI.N 091/2024', '2023-08-29', '2031-11-19', 'TEMON', 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(380, 'MACHFUDZ MAULANA BIN SALIM (ALM)', 'BI.N 067/2025', '2024-08-12', '2029-02-06', NULL, 'C', 'C4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(381, 'MAHENDRA SAPUTRA BIN CATUR SUGIARTO', 'AII. 361/2025', '2025-10-30', '2026-01-31', 'HENDRA', 'A', 'A3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(382, 'MAHFUDIN BIN PARJOKO', 'BI. 044/2025', '2024-08-12', '2035-02-10', 'UDIN', 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(383, 'MAILUL FADHLI BIN SOLEH', 'BI. 178/2025', '2025-02-11', '2029-10-03', 'BONDET', 'BA', 'BA11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(384, 'MALINDO NUR NUGRAHA BIN NASURI', 'AIIN 377/2025', '2025-10-14', '2026-01-18', 'NUR', 'A', 'A14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(385, 'MAMAT WICAKSONO BIN KUSNANTO (ALM)', 'AVN.002/2025', '2025-01-30', '2026-02-19', NULL, 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(386, 'MANSUR BIN TIMAN', 'BI. 309/2025', '2025-01-09', '2033-12-11', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(387, 'MARDAHERA RAKA ANUGRAH JANUAR BIN ATMODJO SUKRO NUGROHO', 'AII. 375/2025', '2025-11-18', '2026-01-13', NULL, 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(388, 'MARIANTO BIN SIRAM', 'BI.N 063/2025', '2024-08-12', '2029-12-27', 'BECU', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(389, 'MARSAI BIN MARSUDIN', 'AI. 372/2025', '2025-12-03', '2026-01-18', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(390, 'MARSAM BIN MARSUDIN', 'AI. 371/2025', '2025-12-03', '2026-01-18', 'SAM', 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(391, 'MASDUKAN BIN KAMISAN', 'BI. 235/2025', '2025-02-25', '2027-06-22', NULL, 'A', 'A1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(392, 'MASHUDI BIN SAMIDI', 'BI.N 276/2025', '2025-04-17', '2030-07-08', NULL, 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(393, 'MAT ROMSEH BIN MARSUDIN', 'AI. 373/2025', '2025-12-03', '2026-01-18', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(394, 'MAULANA SYARIF AHMAD BIN WIDARTO EFENDI', 'BI.N 434/2022', '2022-05-17', '2030-12-23', 'SLEDOT', 'BA', 'BA13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(395, 'MIFTANANG YULIANTORO BIN ARIFIN (ALM)', 'BI.N 094/2025', '2024-12-05', '2030-07-14', 'BOCIL', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(396, 'MINARTI BINTI ASMINAN', 'BI.P 010/2025', '2025-07-02', '2026-12-23', NULL, 'WANITA', '3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(397, 'MIRA MARYANI BINTI DIDI JUNAEDI', 'AI.P 019/2025', '2025-11-18', '2026-01-12', NULL, 'WANITA', '4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(398, 'MISBAHUL ULUM BIN MASDUQI (ALM)', 'BI. 273/2025', '2025-01-30', '2028-06-01', 'KABUL', 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(399, 'MOCH BASORI BIN SANIMAN', 'BI. 114/2025', '2025-06-10', '2029-01-09', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(400, 'MOCH JINAR RIDWAN BIN MUNIWAR', 'AIII. 343/2025', '2025-10-14', '2026-02-23', NULL, 'A', 'A13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(401, 'MOCH SAFII BIN SARBIDIN', 'BI. 530/2023', '2023-11-03', '2027-12-21', NULL, 'D', 'D3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(402, 'MOCH SYAIFUL BIN TASERI', 'BI. 218/2025', '2025-04-28', '2027-04-02', 'SYAIFUL', 'A', 'A12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(403, 'MOCH. MACHROMIN BIN MARSO (ALM)', 'BI.N 052/2025', '2024-10-15', '2028-12-08', 'CAK MEN', 'BA', 'BA2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(404, 'MOCH. YUSUF BIN KABIL', 'BI.N 253/2025', '2024-11-13', '2027-10-09', 'ENCEP', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(405, 'MOCHAMAD GHOFAR BIN PA\'I', 'AIII. 359/2025', '2025-10-30', '2026-03-05', 'GOPAR', 'D', 'D2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(406, 'MOCHAMAD IMAM SAFII BIN SLAMET', 'BI. 136/2024', '2024-03-06', '2033-06-09', NULL, 'BA', 'BA11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(407, 'MOCHAMAD MAHFUD BIN SARDI', 'BI. 214/2025', '2025-04-28', '2027-04-02', 'PUD', 'D', 'D5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(408, 'MOCHAMAD NURDIANSAH BIN NUR SOHIB (ALM)', 'BI.N 227/2023', '2022-09-28', '2028-07-18', 'DIAN', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(409, 'MOCHAMAD REGA DWI ARTA BIN SAMIDI', 'BI. 271/2025', '2025-06-24', '2026-12-06', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(410, 'MOCHAMAD RIAN ISMAIL BIN KASMALIK (ALM)', 'BI.N 298/2025', '2025-06-04', '2032-06-24', 'GONDO', 'C', 'C11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(411, 'MOCHAMAD RIANTO BIN RIADI (ALM)', 'BI.N 152/2024', '2024-04-05', '2033-01-13', 'JE', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(412, 'MOCHAMAD SOLEH BIN JAELANI', 'BI.N 427/2023', '2023-08-18', '2026-10-10', NULL, 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(413, 'MOCHAMMAD BADRUS SHOLEH BIN MAWARDI (ALM)', 'BI. 071/2025', '2024-12-05', '2026-04-23', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(414, 'MOCHAMMAD IMRON ROSYADI BIN SOBIRIN', 'BI.N 232/2025', '2024-11-13', '2027-10-02', 'GEMBUK', 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(415, 'MOCHAMMAD IZAACH MAHENDRA BIN BUDIYONO', 'BI.N 439/2023', '2023-08-18', '2028-06-17', 'TUWEK', 'BA', 'BA5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(416, 'MOCHAMMAD MISBACHULFAUZI BIN KAMIM', 'AI. 390/2025', '2025-12-23', '2026-02-01', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(417, 'MOCHAMMAD SYUFII BIN UNTUNG SUBIANTORO (ALM)', 'BI.N 024/2025', '2024-08-12', '2030-12-08', 'BITOR', 'C', 'C12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(418, 'MOH IMAN ROMADLONA BIN ASNAN SANTOSO', 'BI.N 174/2024', '2024-04-05', '2028-03-24', NULL, 'C', 'C9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(419, 'MOH RIFKI BIN ISMAIL (ALM)', 'AI.N 345/2025', '2025-11-18', '2026-01-27', 'PAIJO', 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(420, 'MOH RIYAN FEBRIYAN BIN SUNIDI', 'BI.N 477/2023', '2023-09-12', '2026-07-26', NULL, 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(421, 'MOH. ANABSIR BIN SUHARSONO (ALM)', 'BI.N 254/2025', '2024-11-13', '2030-11-07', 'ANAS', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(422, 'MOH. ASHARUDIN HIDAYATULLOH BIN MUHAJIR', 'AIV 079/2025', '2025-08-31', '2026-01-16', NULL, 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(423, 'MOH. IWAN BIN ISMAIL', 'BI.N 281/2025', '2025-04-17', '2035-04-08', 'JEBER', 'BA', 'BA12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(424, 'MOH. RODIANTO BIN MA\'AD', 'BI. 022/2023', '2022-04-27', '2027-01-11', 'ACONG', 'BA', 'BA1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(425, 'MOH.AGUS FAUZI BIN AHMADI', 'BI.N 418/2023', '2023-01-18', '2028-11-11', 'SOGOL', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(426, 'MOHAMAD ADE YOGA BIN SAIFUL KULUD', 'AIII. 345/2025', '2025-10-14', '2026-02-23', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(427, 'MOHAMAD JAILANI BIN PAERAN (ALM)', 'AV.N 013/2025', '2025-01-30', '2026-03-21', 'MAD', 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(428, 'MOHAMAT EHWAN BIN SUNARDI (ALM)', 'BI. 219/2025', '2025-02-11', '2026-12-29', NULL, 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(429, 'MOHAMMAD AGIL AZIZI BIN BONAJI', 'BI. 128/2024', '2024-01-17', '2031-04-23', 'POCONG', 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(430, 'MOHAMMAD AGUS SULIS STIAWANTO BIN SUWARTO', 'BI.N 061/2025', '2024-05-27', '2030-11-28', 'ULIS', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(431, 'MOHAMMAD ANDI SATRIO BIN MURSIDI (ALM)', 'AIII. 292/2025', '2025-07-23', '2025-12-30', NULL, 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(432, 'MOHAMMAD ARDIANSYAH BIN SIKAN', 'BI. 023/2024', '2023-08-29', '2029-04-18', 'ARDI', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(433, 'MOHAMMAD MUNDIR BIN M. SAHID', 'BI.N 256/2025', '2025-06-26', '2026-10-14', 'BAGONG', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(434, 'MOHAMMAD REJO BIN MUHAMMAD SOKEH (ALM)', 'BI. 318/2023', '2023-05-31', '2029-09-04', NULL, 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(435, 'MOHAMMAD SAID BIN SARIJO', 'BI.N 214/2024', '2024-01-17', '2030-12-10', NULL, 'A', 'A5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(436, 'MOHAMMAD ZAINAL FANANI BIN ZAINURI', 'BI.N 055/2025', '2024-03-26', '2030-09-06', 'CAKNAN', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(437, 'MUCHAMAD ADAM AFRIZAL BIN MULYADI', 'BI.N 302/2025', '2025-09-04', '2032-02-07', NULL, 'C', 'C1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(438, 'MUCHAMAD AMIQ ABDILLAH BIN NUR CHOLIS', 'BI. 214/2023', '2022-10-19', '2029-08-18', 'AMIQ', 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(439, 'MUCHAMAD ANTOK BIN SAMIAN', 'AIVN.070/2025', '2025-05-16', '2026-02-25', NULL, 'C', 'C8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(440, 'MUCHAMAD FAJAR BIN ZAINUL ARIFIN', 'AI.N 336/2025', '2025-10-30', '2026-01-19', NULL, 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(441, 'MUCHAMAD ROBI BIN NUR KODIM (ALM)', 'AI.N 349/2025', '2025-11-18', '2026-01-22', 'BOY', '-', '-', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(442, 'MUCHAMMAD ABDUL HAFIDHZ AL ASYARI BIN ARIF SANTOSO (ALM)', 'BI.N 226/2023', '2022-09-28', '2028-07-22', 'ASYARI', 'D', 'D3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(443, 'MUCHLAS HIDAYAH BIN MAULAN', 'BI.N 185/2025', '2024-08-21', '2027-03-21', 'GERANDONG', 'BA', 'BA5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(444, 'MUFID KHOIRON BIN SUPARMAN (ALM)', 'BI.N 164/2024', '2023-07-04', '2027-08-26', NULL, 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(445, 'MUHAMAD EKO PUTRA ADI SUSANTO BIN SULIMIN', 'AV.N 018/2025', '2025-01-30', '2026-03-21', 'CURUT', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(446, 'MUHAMAD HERI SETIAWAN BIN WAIDI', 'BI.N 242/2025', '2024-09-24', '2027-07-13', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(447, 'MUHAMAD RIZAL BIN DIUN', 'BI.N 223/2025', '2025-01-30', '2026-06-23', 'RIZAL', 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(448, 'MUHAMAD ROMLI BIN ADI', 'AIIIN. 349/2025', '2025-08-26', '2026-03-01', NULL, 'A', 'A4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(449, 'MUHAMMAD ABDI YUNUS BIN USMAN', 'BI.N 567/2023', '2023-01-18', '2028-11-11', 'GANDEN', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(450, 'MUHAMMAD AGUNG SUBEKTI ARI HARTADI BIN MULJADI', 'AI. 341/2025', '2025-10-30', '2026-01-11', 'AGUNG', 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(451, 'MUHAMMAD AGUS JAMALUDIN BIN SUWITO (ALM)', 'AIV.N 082/2025', '2025-06-24', '2026-02-10', 'BAGUS', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(452, 'MUHAMMAD ALI MANSYUR BIN MUHAMMAD SYAFII', 'AI.N 393/2025', '2025-12-23', '2026-01-25', 'KLOPO', 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(453, 'MUHAMMAD ALI SHOFYAN BIN ABU HARI', 'BI.N 431/2022', '2022-07-11', '2027-09-20', 'FIYAN', 'D', 'D3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(454, 'MUHAMMAD AMAN BIN ABDUL MALIK', 'BI.N 315/2022', '2021-12-07', '2029-09-22', 'TOLET', 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(455, 'MUHAMMAD ANDRI BIN MUNARI', 'BI.n 058/2021', '2020-07-15', '2026-07-09', 'TUBI', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(456, 'MUHAMMAD ANGGA SETIA ABADI BIN AGUS ZAINAL', 'AVN. 026/2025', '2025-03-17', '2026-05-16', NULL, 'C', 'C10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(457, 'MUHAMMAD ANSHORI BIN SUTRISNO', 'AIII. 313/2025', '2025-08-31', '2026-01-19', NULL, 'D', 'D3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(458, 'MUHAMMAD ARIF KHOIRUL HAKIM BIN CHUSNAN', 'BI.N 226/2025', '2024-10-22', '2029-04-29', 'NDAREP', 'A', 'A13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(459, 'MUHAMMAD BAGUS BASORI BIN MACHFUD', 'BIIa. 106/2025', '2025-04-17', '2026-01-01', 'GENTONG', 'BA', 'BA12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(460, 'MUHAMMAD DAFALA BIN USAMAH', 'BI.N 527/2023', '2023-11-03', '2029-08-14', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(461, 'MUHAMMAD DENI TEGUH FIRMANSYAH BIN PURNOMO', 'BI. 246/2025', '2025-03-25', '2035-03-17', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(462, 'MUHAMMAD EFAN ADITIYA BIN DAMIN', 'BI. 288/2025', '2025-02-25', '2031-01-16', 'ADIT', 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(463, 'MUHAMMAD FATICHUL ILMI BIN SYAIFUL ANWAR', 'BI. 219/2024', '2024-05-27', '2033-11-22', 'FATIC', 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(464, 'MUHAMMAD FATKUR SLAMET BIN SUJONO', 'BI.N 093/2025', '2024-10-22', '2031-02-16', 'JONET', 'C', 'C10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(465, 'MUHAMMAD FERI FADLI BIN MU\'ID', 'BIIa. 112/2025', '2025-08-31', '2026-08-12', NULL, 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(466, 'MUHAMMAD FERY DARMAWAN BIN ABDUL WAKIT', 'BI.N 119/2024', '2023-12-12', '2029-10-30', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(467, 'MUHAMMAD FIKRI HAIKAL SETIAWAN BIN HERU SETIAWAN', 'BI. 570/2023', '2023-07-04', '2027-09-01', 'MONDI', 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(468, 'MUHAMMAD HASAN BASALAMAH BIN HASAN (ALM)', 'AI.N 328/2025', '2025-10-30', '2026-01-04', 'MAMED', 'C', 'C5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(469, 'MUHAMMAD HASAN FADELI BIN ASMARI', 'BI.N 171/2025', '2025-06-26', '2028-07-02', 'FAFA', 'D', 'D1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(470, 'MUHAMMAD HUSNI AFIFFUDDIN BIN MUHAMMAD ALIUDIN', 'BI. 270/2025', '2025-03-25', '2026-07-01', 'AFIF', 'A', 'A13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(471, 'MUHAMMAD IHWAN FAUZI BIN ABDUL MALIK', 'BI.N 040/2025', '2024-05-27', '2030-09-07', 'WAWAN', 'C', 'C6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(472, 'MUHAMMAD IMRON MAULANA BIN SARTO', 'AIIIN. 298/2025', '2025-05-16', '2026-01-04', 'NYAMBEK', 'C', 'C2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(473, 'MUHAMMAD KALAM BIN BADRI (ALM)', 'BI.N 135/2024', '2024-03-06', '2028-06-03', 'MBEM', 'C', 'C1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(474, 'MUHAMMAD LUSMIYADI BIN MUCHSIN', 'AIII. 357/2025', '2025-10-14', '2026-03-05', NULL, 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(475, 'MUHAMMAD RIFO ARIFIANTO BIN ARIF YANTO', 'BI.N 170/2023', '2022-09-14', '2026-12-07', 'AMBON', 'C', 'C3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(476, 'MUHAMMAD RIZQI MUBAROK BIN ZAINAL ARIFIN', 'BI. 208/2025', '2025-02-25', '2031-10-14', 'RIZKI', 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(477, 'MUHAMMAD ROZAQ BIN MAT PALAL', 'AIIN. 360/2025', '2025-08-31', '2026-01-30', 'ROJAK', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(478, 'MUHAMMAD SHOLAKHUDIN BIN PONAJI', 'BI. 190/2023', '2022-09-28', '2034-07-20', NULL, 'BA', 'BA13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(479, 'MUHAMMAD SOBIRIN BIN ABDUL ALAWI', 'BI. 125/2025', '2025-06-10', '2028-12-03', NULL, 'BA', 'BA5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(480, 'MUHAMMAD SULTON BIN ABU YAZID BASTOMI (ALM)', 'BI. 098/2025', '2024-07-08', '2030-01-10', NULL, 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(481, 'MUHAMMAD SURIPTO BIN SURIPTO', 'BI. 121/2025', '2025-06-10', '2026-09-08', NULL, 'BA', 'BA1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(482, 'MUHAMMAD SYIFA BIN ZULKIFLI ARIEF', 'BI.N 344/2022', '2022-05-19', '2027-01-14', 'PAUL', 'C', 'C3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(483, 'MUHAMMAD TAQYUDDIN BIN M HUSNAN (ALM)', 'BI.N 047/2023', '2023-01-19', '2029-07-19', 'CAK YUD', 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(484, 'MUHAMMAD ZAMRONI BIN MUSLIM', 'BI. 244/2025', '2025-03-17', '2026-06-27', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(485, 'MUHARWANDA AL FARUQI BIN SUKARDI', 'BI.N 189/2024', '2024-04-05', '2028-03-24', NULL, 'C', 'C9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(486, 'MUJAHIDIN BIN SUTIK', 'BI.N 143/2024', '2023-10-20', '2029-08-14', 'BOWO', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(487, 'MUJIANTO BIN RADI', 'BI.N 312/2025', '2025-02-11', '2030-05-20', 'METENG', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(488, 'MUJIONO BIN MIAN', 'AIII. 360/2025', '2025-10-14', '2026-03-09', 'PYEK', 'A', 'A3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(489, 'MUKAMMAD SADDIKIN BIN KARIMAN', 'BI.N 050/2025', '2024-09-24', '2033-01-27', 'SODIK', 'A', 'A4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(490, 'MUKHAMAD AMALUDIN BIN KUSNADI', 'BI.N 213/2025', '2024-09-11', '2027-05-10', 'UDIN', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(491, 'MUKHAMAD IQBAL ROZAKI BIN PARJIN', 'BI. 300/2025', '2025-05-16', '2031-04-17', 'JAROT', 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(492, 'MUKHSON HABIB BIN WAJIB', 'AV.N 011/2025', '2025-01-30', '2026-02-25', NULL, 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(493, 'MULYONO CONY BIN CORNELIS CONY', 'BI. 134/2025', '2025-06-10', '2026-06-25', NULL, 'D', 'D5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(494, 'MUSA BIN NURUL HAKIM', 'BIII.sN 109/2025', '2022-10-18', '2027-07-29', NULL, 'C', 'C4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(495, 'MUSLIMIN BIN SETU', 'AI. 386/2025', '2025-12-23', '2026-02-04', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(496, 'MUSTIKA AYU BINTI MUSTOFA', 'AV.P 001/2025', '2025-01-30', '2026-03-20', NULL, 'WANITA', '1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(497, 'MUZAKKI ABDAIN BIN MUHAMAD SHOLIKIN', 'AIIN. 373/2025', '2025-08-31', '2026-01-13', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(498, 'NAILAL BIN KHOLIL BIN KHOLIL', 'AIII. 336/2025', '2025-10-14', '2026-02-18', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(499, 'NANANG ISWAHYUDI BIN SUGATI', 'AIII. 362/2025', '2025-10-14', '2026-03-10', NULL, 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(500, 'NANANG SETYADI BIN JUDIN (ALM)', 'BI.N 205/2024', '2024-04-09', '2031-04-25', 'OLENG', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(501, 'NANDA PUTRA ARIF BIN MUHAMMAD ARIF', 'BIIa. 111/2025', '2025-06-04', '2026-05-23', NULL, 'A', 'A4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(502, 'NATHAN PUTRA DWIVAN BIN IVAN YUARTA', 'AI.N 330/2025', '2025-10-30', '2026-01-08', NULL, 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(503, 'NOOFRIANDI ARIFIN BIN TRIMAN SUPRIYADI', 'BI.N 468/2023', '2023-09-12', '2028-05-03', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(504, 'NOVA DWI PANDEGA BIN BAMBANG', 'AI.N 301/2025', '2025-10-14', '2026-01-14', 'GAMBER', 'A', 'A3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(505, 'NOVIRA INDRAYANI BINTI YARSAN', 'AIIP. 020/2025', '2025-10-30', '2026-01-08', NULL, 'WANITA', '2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(506, 'NUR ALI BIN UNTUNG', 'BI.N 070/2024', '2023-07-04', '2029-11-23', 'KAMID', 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(507, 'NUR ANDIK BIN MUNADJI', 'BI.N 216/2024', '2024-03-06', '2031-05-30', 'PENDEK', 'C', 'C3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(508, 'NUR ROZIHUL FAUZAN BIN TAUCHID', 'BI.N 272/2025', '2025-07-10', '2033-04-14', 'JUSUK', 'A', 'A14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(509, 'NURA KURNIAWAN BIN SUNGKONO', 'AIII. 320/2025', '2025-06-24', '2026-01-25', NULL, 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(510, 'NURAFIF BIN FADELAN', 'BI.N 051/2025', '2024-09-24', '2031-05-07', 'APIP', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(511, 'NURCHOLIS BIN MUNALI', 'BI.N 575/2023', '2023-12-19', '2028-12-05', 'KACONK', 'D', 'D4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(512, 'NURIL ANWAR BIN GUNARTO', 'AIVN. 069/2025', '2025-05-16', '2026-02-17', 'NURIL', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(513, 'NURY MOCHAMAD YUSUF BIN NUR EDI', 'BI.N 246/2023', '2022-11-14', '2026-07-01', 'RACUN', 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(514, 'OFI MIFTAHUDIN BIN KASIYANTO', 'BI. 002/2024', '2023-05-17', '2030-01-01', 'OFI', 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(515, 'OGAN YURIS VALENTINO FEBRIANSYAH BIN SUSANTO', 'AI.N 396/2025', '2025-12-23', '2026-01-27', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(516, 'OKY LUTVIANDI BIN SUBARI', 'AI.N 368/2025', '2025-12-03', '2026-01-17', NULL, 'D', 'D4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(517, 'ONY SATYAWAN BIN SAMID', 'BI.N 048/2025', '2024-09-11', '2030-03-02', NULL, 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(518, 'OPPI MEIBRIAN SIFAK BIN SETIYO AGUNG PRIANTO', 'AIIIN. 352/2025', '2025-07-23', '2026-03-01', 'ACIL', 'C', 'C9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(519, 'OTNIEL NICO NEHEMIA BIN SLAMET', 'BI. 140/2024', '2024-01-26', '2032-05-14', 'PENDHEK', 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(520, 'PAEMAN BIN JUMENAN (ALM)', 'BI.N 144/2024', '2024-01-26', '2028-05-20', NULL, 'C', 'C6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(521, 'PANDI IRJAN TAIB BIN KHOIRON', 'BI.N 005/2024', '2023-04-12', '2028-05-23', 'BENDOL', 'C', 'C17', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(522, 'PAUL SELLA ANDRIANTO BIN SUYITNO', 'BI. 072/2025', '2024-10-15', '2029-06-11', 'ANDRE', 'A', 'A5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(523, 'PERMATA SANDHI CAHYANA BIN SAMSI ADIS', 'BI. 141/2025', '2025-01-30', '2026-02-26', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(524, 'PIPIT DISTANTO BIN ABDUL MANAN (ALM)', 'BI. 285/2025', '2025-06-24', '2026-12-15', 'PIPIT', 'BA', 'BA11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(525, 'PONCO MARDI UTOMO BIN MARGONO ATMOWIJOYO', 'AIIIK. 282/2025', '2025-07-15', '2026-02-08', 'YUUT', 'BA', 'BA4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(526, 'PONIMAN BIN SUWANI', 'AIIN. 376/2025', '2025-10-14', '2026-01-13', NULL, 'A', 'A13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(527, 'PRASETYO BUDI SANTOSO BIN AGUNG P', 'BI.N 142/2025', '2024-09-11', '2033-01-01', NULL, 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(528, 'PRIYONO BIN MUJIONO', 'BIIa. 108/2025', '2025-05-16', '2026-01-11', 'SALEHO', 'A', 'A2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(529, 'PUJIANTO BIN MULYONO', 'B.I 082/2023', '2023-01-26', '2028-12-25', NULL, 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(530, 'PULUNG RINDAWAN AMINDAMA BIN DAYONO', 'BI.N 507/2023', '2023-01-18', '2027-11-12', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(531, 'PUNGKI WINARDO BIN WINARKO', 'BI.N 317/2025', '2025-02-11', '2027-01-30', 'JATIL', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(532, 'PURNOMO BIN IMAM', 'AI. 382/2025', '2025-12-03', '2026-01-21', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(533, 'PURNOMO BIN MUKSIN', 'B.I 080/2023', '2023-01-26', '2029-04-26', NULL, 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(534, 'PURNOMO BIN SLAMET (ALM)', 'AIIN. 359/2025', '2025-08-31', '2026-01-30', NULL, 'C', 'C8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(535, 'QOYYUM EFENDI BIN MAHFUD', 'BI.N 227/2022', '2021-09-01', '2028-01-18', 'PENDIK', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(536, 'R. DADAN SURACHMAT, S.E BIN HIDAYAT SANJAYA DIPURA', 'AI. 353/2025', '2025-11-18', '2026-01-02', NULL, 'BA', 'BA3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(537, 'RACHMAD GIRAN PRAYUGO BIN WAGIRAN', 'BI.N 480/2023', '2023-09-12', '2026-05-29', 'RAHMAT BIN WAGIRAN', 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(538, 'RAFI SUGIANTO BIN SUMARDI (ALM)', 'AI.N 351/2025', '2025-11-18', '2026-01-22', NULL, 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(539, 'RAHMAN SEPTIAN PRAKOSO BIN RAHMAD KUSNARYO', 'BI.N 014/2024', '2023-06-08', '2029-04-10', NULL, 'BA', 'BA2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(540, 'RAKA OBIM BAGAS SAPUTRA BIN BAGAS (ALM)', 'BI.N 278/2025', '2025-03-17', '2032-03-05', 'BAGAS', 'D', 'D5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(541, 'RATNO WIBOWO BIN KASTUR (ALM)', 'BI.N 233/2025', '2024-09-24', '2034-04-20', 'SONGKEL', 'A', 'A4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(542, 'REFAN INDRIANTO BIN PURNOMO ADI', 'AVN. 029/2025', '2025-03-25', '2026-05-21', NULL, 'C', 'C9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(543, 'RENDRA KURNIAWAN BIN ABIDIN (ALM)', 'AVN. 008/2025', '2025-02-11', '2026-03-26', 'KEMPU', 'C', 'C7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(544, 'RENGGA ADITYA PAMUNGKAS BIN WIJI NOWO SAYEKTI', 'BI.N 051/2024', '2023-10-20', '2030-10-27', 'ANGGA', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(545, 'RENO PRIBADI BIN SUMARJI', 'AI.N 305/2025', '2025-10-14', '2026-01-29', NULL, 'D', 'D2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(546, 'REVIN NALDO AGUSTIAN NARENDRA BIN NANANG TEGUH WIYANTO', 'BI.N 191/2023', '2022-08-02', '2027-05-01', NULL, 'C', 'C9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(547, 'REYNALDI RIZAL FIRMANSYAH BIN WIJIANTO', 'BI.N 578/2023', '2023-06-08', '2029-01-12', NULL, 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(548, 'REZA AFKAR PIRAGA BIN M GUFRON', 'BI.N 088/2025', '2024-07-08', '2031-06-04', 'AGA', 'C', 'C12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(549, 'RICO MEGA EMERLA BIN MUHADI', 'BI.N 002/2025', '2023-10-20', '2028-01-16', NULL, 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(550, 'RIDWAN CANDRA DARMAWAN BIN DADANG DARMAWAN', 'AIII. 326/2025', '2025-08-31', '2026-02-02', NULL, 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(551, 'RIKO HANI PAMBUDI BIN SUWANTO', 'AI 378/2025', '2025-12-23', '2026-02-04', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(552, 'RIO DIANSYAH AJI PRATAMA BIN SURAJI (ALM)', 'AII. 364/2025', '2025-11-18', '2026-01-08', NULL, 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(553, 'RISAL OKTANDO BIN PURNIADI', 'BI.N 217/2024', '2024-04-05', '2030-07-17', 'ATENG', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(554, 'RIYAN SYARIF BIN ABDUR ROHMAN', 'AIII. 346/2025', '2025-10-14', '2026-02-24', NULL, 'D', 'D2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(555, 'RIYONO BIN GIMAN', 'BI.N 203/2024', '2024-05-27', '2029-11-28', 'BENJOL', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(556, 'RIZA ZAKARIA ANHAR BIN SIAMAR', 'BI.N 065/2025', '2024-12-05', '2029-07-14', NULL, 'C', 'C5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(557, 'RIZAL RAMADHAN BIN BENY HANDAYANTO', 'BI.N 310/2025', '2025-06-04', '2031-05-25', 'ICHANG', 'C', 'C11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(558, 'RIZAL WAHYUDI BIN HAFILUDDIN', 'BI. 164/2023', '2022-08-25', '2026-06-02', 'KACONG', 'A', 'A5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(559, 'RIZKI FEBRIANTO BIN M. CHOLIQ', 'AIIIN. 307/2025', '2025-06-04', '2026-02-13', NULL, 'A', 'A13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(560, 'RIZKI FIRMANDANI BIN ARTIMAN', 'BI.N 148/2023', '2022-05-30', '2027-03-11', NULL, 'BA', 'BA5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(561, 'ROFI FIRDAUS ANWAR BIN SULAIMAN YUDI', 'AIIN. 371/2025', '2025-10-30', '2026-01-13', 'KIPIL', 'C', 'C2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(562, 'ROHMAD NUR HIDAYAT BIN WARSUDI SANTOSO', 'BI.N 268/2025', '2025-02-11', '2031-01-09', 'DAYAT', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(563, 'ROKIM BIN MIRAN', 'BI. 269/2023', '2022-09-14', '2033-06-03', NULL, 'A', 'A5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(564, 'ROMY KURNIAWAN DWIYANTO BIN SUKARLAN', 'BI. 228/2025', '2025-02-25', '2027-01-14', NULL, 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(565, 'RONI FIRDAUS BIN DIMYATI', 'BI.N 274/2025', '2025-01-30', '2030-07-20', 'RONDO', 'D', 'D4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(566, 'ROZAQ ALDY BIN MUSAWIR', 'BI.N 064/2024', '2023-08-29', '2028-10-26', NULL, 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(567, 'RUDI HARTONO BIN KHUSNUL IMRON', 'BI.N 050/2024', '2022-12-23', '2027-11-04', NULL, 'A', 'A12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(568, 'RUDI HARTONO BIN M. KASAN (ALM)', 'BI.N 185/2024', '2024-07-24', '2030-12-02', NULL, 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(569, 'RUDI HERWANTO ALIAS GRANDONG BIN SLAMET (ALM)', 'AI.N 306/2025', '2025-10-14', '2026-01-30', 'GERANDONG', 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(570, 'RUDI SANTOSO BIN M. URIP (ALM)', 'BI.N 099/2024', '2023-08-29', '2027-11-10', NULL, 'D', 'D2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(571, 'RUDI SETYAWAN BIN SUTRISNO', 'BI. 202/2025', '2025-03-17', '2027-03-05', 'WAWAN', 'A', 'A3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(572, 'RUKIN HARIANTO BIN SLAMET (ALM)', 'AV. 024/2025', '2025-03-25', '2026-04-15', NULL, 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(573, 'RUSMAN HADI BIN IMAM SANUSI (ALM)', 'BI.N 157/2023', '2022-10-18', '2028-11-28', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(574, 'SADDAM KURNIAWAN BIN MUKSIN', 'BI. 286/2025', '2025-06-24', '2026-09-17', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(575, 'SAFIRA PUTRI LISTIANA BINTI SULISTIONO (ALM)', 'AIIIPN. 015/2025', '2025-06-24', '2026-01-01', NULL, 'WANITA', '4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(576, 'SAIFUL ANAM BIN BUAMIN (ALM)', 'BI.N 372/2023', '2023-07-18', '2028-05-05', NULL, 'C', 'C17', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(577, 'SAIFUL ANAM BIN KASDI', 'BI. 194/2025', '2025-01-30', '2030-03-09', 'ANAM', 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(578, 'SAIFUL ANAM BIN SUPRIADI (ALM)', 'AI.N 347/2025', '2025-11-18', '2026-01-21', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(579, 'SAKUR BIN SARIYAN', 'BI. 258/2022', '2021-10-06', '2032-02-21', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(580, 'SAMPURNO RIADIN BIN SAMPAN', 'AI. 370/2025', '2025-12-03', '2026-01-17', 'SAMPAN', 'A', 'A4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(581, 'SAMSI BIN PONAJI (ALM)', 'AIII. 331/2025', '2025-08-26', '2026-02-12', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(582, 'SAMSUL ARIFIN BIN NGATEMIN', 'BI. 215/2019', '2019-03-11', '2032-08-01', 'SAMSUL', 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(583, 'SAMSUL ARIFIN BIN SOLIKIN', 'BI.N 052/2024', '2023-10-20', '2034-06-11', NULL, 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(584, 'SAMSUL HADI BIN TAMAJI', 'BI. 229/2025', '2025-02-25', '2027-12-25', NULL, 'A', 'A1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(585, 'SAMUEL DWI CHRISTANTO BIN DWI MARGONO', 'BI. 199/2024', '2024-06-24', '2028-11-10', 'GENDUT', 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(586, 'SAMUJI BIN (ALM) TEGUH', 'BI.N 230/2025', '2025-01-30', '2033-10-24', 'MUJI', 'BA', 'BA5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(587, 'SANDI BIN MUSTAMIN (ALM)', 'BI. 019/2025', '2024-07-24', '2038-01-24', NULL, 'A', 'A5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(588, 'SANG BAGUS WIBOWO BIN DUKI', 'BI.N 005/2025', '2023-10-20', '2028-01-16', 'DEPE', 'C', 'C8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(589, 'SANGSANG FAISOL KADHAFI BIN SUGENG', 'BI.N 035/2025', '2024-08-12', '2030-01-31', 'DAVID', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(590, 'SAPUTRO JULIARSO BIN SIMAN', 'AI.N 366/2025', '2025-12-03', '2026-01-12', NULL, 'C', 'C8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(591, 'SATRIA FEDORA DAFFA BIN AGUNG WAHYU BHARATA', 'A.IN 300/2025', '2025-10-14', '2026-01-12', NULL, 'A', 'A14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(592, 'SEGER ALY SAHAB BIN SAKIMAN (ALM)', 'BI. 498/2023', '2022-09-14', '2035-06-11', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(593, 'SEPTIAN DWI CAHYONO BIN BAMBANG SETIYONO', 'BI. 243/2025', '2025-03-17', '2026-10-25', 'TIAN', 'A', 'A2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(594, 'SEPTIAN KUSUMA WARDANI BIN WARSONO', 'AI.N 363/2025', '2025-12-03', '2026-01-07', NULL, 'C', 'C12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(595, 'SETIA YULI FARDIANTO BIN KASIANTO', 'AIIIN. 332/2025', '2025-07-23', '2026-02-15', NULL, 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(596, 'SETIYO KUSPRIYONI BIN MOHAMAD KOSIM', 'BI.N 325/2023', '2023-02-01', '2031-12-12', 'CUPLIS', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(597, 'SETYO PURNOMO BIN EKO SETIAWAN (ALM)', 'AIIIN. 339/2025', '2025-07-23', '2026-02-22', 'CAKMO', 'A', 'A3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(598, 'SLAMET BIN MUSLAN', 'AV. 012/2025', '2025-03-25', '2026-01-25', 'GALITONG', 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(599, 'SLAMET EFENDI BIN ISMAN', 'BI.N 503/2023', '2023-06-08', '2027-07-20', NULL, 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(600, 'SLAMET HARIYANTO BIN MAT CHOIRI', 'BI.N 043/2023', '2023-01-19', '2026-11-01', NULL, 'D', 'D5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(601, 'SLAMET ZULI RIYANTO BIN SAKIRMAN', 'BI. 216/2025', '2025-04-28', '2027-04-02', 'ZULI', 'BA', 'BA4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(602, 'SODIKUL BIN PARNO', '-BI. 152/2023', '2022-09-28', '2034-07-24', 'GEMBUS', 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(603, 'SOLIKIN BIN SALIWON (ALM)', 'AI. 378/2025', '2025-12-03', '2026-01-25', NULL, 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(604, 'SRI WAHYUDI BIN SALI', 'BI.N 203/2025', '2025-01-09', '2029-09-08', 'KONTENG', 'C', 'C5', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(605, 'SUCIPTO BIN KASDUL (ALM)', 'BI.N 046/2024', '2023-11-29', '2028-01-22', NULL, 'C', 'C11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(606, 'SUDIBYO BIN SUBANDIAN (ALM)', 'BI.N 057/2025', '2024-09-24', '2030-10-26', 'GUNDUL', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(607, 'SUGENG ARIEF FIRMANSYAH BIN SUWARNO', 'AI.N 399/2025', '2025-12-23', '2026-02-03', NULL, 'D', 'D6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(608, 'SUGENG WIDODO BIN BUDIONO', 'BI.N 180/2023', '2022-05-30', '2027-03-11', 'GRANDONG', 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(609, 'SUGIAWAN SUMARSONO BIN BAMBANG BUDJIONO', 'BI.N 366/2023', '2023-07-18', '2027-11-20', NULL, 'D', 'D3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(610, 'SUGIONO BIN SUKEM', 'BI. 305/2025', '2025-05-16', '2034-05-02', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(611, 'SUGITO BIN SOLEH', 'BI.N 172/2025', '2024-08-12', '2028-05-15', NULL, 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(612, 'SUHARMINTO BIN SOIM', 'BI.N 042/2025', '2024-03-06', '2030-09-06', 'HARMINTO', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(613, 'SUKARDI FAN BIN UMAR FAN', 'BI. 031/2025', '2024-07-24', '2029-01-22', NULL, 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(614, 'SUKIRAN BIN MATSIRAN', 'BI. 191/2025', '2025-07-18', '2027-06-14', NULL, 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(615, 'SULAIMAN BIN PONIDI', 'BI.N 423/2022', '2022-01-18', '2027-12-12', NULL, 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(616, 'SULISTIAWAN BIN MANIRAN (ALM)', 'BI. 213/2024', '2024-12-19', '2035-10-31', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(617, 'SUMARIONO BIN KASTAM (ALM)', 'BI. 111/2023', '2022-10-19', '2029-05-10', 'YONO', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(618, 'SUMARNO BIN KASERAN SUNARTO', 'BI. 009/2024', '2023-08-02', '2029-10-12', 'OM', 'BA', 'BA10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(619, 'SUNYOTO BIN ABDUL ROKIM (ALM)', 'BI.N 535/2023', '2023-11-03', '2029-01-25', NULL, 'C', 'C17', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(620, 'SUNYOTO BIN PONIDI (ALM)', 'BI. 053/2025', '2024-09-24', '2027-04-30', 'TEMON', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(621, 'SUNYOTO BIN TANIMAN (ALM)', 'BI. 248/2025', '2025-06-04', '2026-09-06', 'NJOTO', 'D', 'D1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(622, 'SUPARDI BIN KANTUN', 'BI.N 326/2023', '2023-06-13', '2029-01-12', 'PARTENG', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(623, 'SUPARI AGUNG BIN KARTIMAN', 'BI.N 082/2024', '2023-12-12', '2029-03-22', 'SUPEH', 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(624, 'SUPRAYITNO BIN MANSRAH', 'BI. 227/2025', '2025-04-17', '2026-10-08', 'NO', 'A', 'A8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(625, 'SUPRIYONO BIN M. IKHSAN', 'AIVN. 073/2025', '2025-06-04', '2026-03-01', 'PENO', 'C', 'C10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(626, 'SUPRIYONO BIN SAMIRIN (ALM)', 'BI.N 352/2023', '2022-12-23', '2026-10-29', 'SATE', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(627, 'SUPRIYONO BIN SU\'EB', 'BI.N 059/2024', '2023-12-14', '2028-02-15', 'KAMPRET', 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(628, 'SUROTO BIN SAERI', 'BI. 291/2025', '2025-03-17', '2039-03-04', NULL, 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(629, 'SURYA DEWANGGA SAKTI BIN WIDI', 'BI.N 105/2025', '2025-06-05', '2026-04-11', 'DEWA', 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(630, 'SUTAJI BIN SUROSO', 'BI.N 370/2022', '2022-04-18', '2026-12-23', 'TAJI', 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(631, 'SUTIYO BIN KATIJO (ALM)', 'BI.N 355/2023', '2022-12-23', '2027-11-16', 'MBAH YO', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(632, 'SUWAJI BIN MARKADI', 'AIII. 315/2025', '2025-06-24', '2026-01-21', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(633, 'SUWARNO BIN SAEMO', 'AII. 367/2025', '2025-08-31', '2026-01-11', NULL, 'A', 'A11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(634, 'SUWARNO BIN SUPARTO', 'AI.N 369/2025', '2025-12-03', '2026-02-02', 'GOMBLOH', 'A', 'A4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(635, 'SWANTORO BIN MISTAM (ALM)', 'AII. 369/2025', '2025-11-18', '2026-01-11', NULL, 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(636, 'SWESTYAWAN DWI SORAYA BIN SUGENG SUJIANTO (ALM)', 'BI. 290/2025', '2025-07-02', '2027-09-21', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(637, 'SYAIFUDDIN ZUHRI BIN SYAFI\'I', 'AIII. 366/2025', '2025-10-14', '2026-03-12', NULL, 'A', 'A2', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(638, 'SYAMSUL ARIFIN BIN IMAM MAHMUDI (ALM)', 'AIVN. 072/2025', '2025-06-04', '2026-02-26', 'ARIF', 'C', 'C4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(639, 'TAKIM BIN MUSTOFA', 'BI. 176/2025', '2025-01-09', '2039-08-07', NULL, 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(640, 'TAMSIR BIN KALIL', 'BIIIs.N 204/2025', '2022-08-02', '2026-01-28', NULL, 'C', 'C4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(641, 'TATA AGENDA PANJI ARUM BIN SUGENG PARIKIR', 'BI. 003/2023', '2022-06-15', '2028-03-11', NULL, 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(642, 'TATA NUGRAHA AKHLAQI BIN AINUL YAQIN', 'BIIa. 097/2025', '2025-06-24', '2026-05-30', 'KENTANG', 'BA', 'BA11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(643, 'TAUFAN BAHARI, S.H BIN MASADI', 'AIV. 077/2025', '2025-08-26', '2026-01-10', NULL, 'A', 'A1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(644, 'TEGUH AMINUDIN BIN M. TOHA (ALM)', 'BI.N 247/2025', '2024-09-24', '2028-07-28', NULL, 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(645, 'TEGUH HADI SANTOSA BIN SUGIONO', 'BI.N 145/2024', '2024-01-26', '2027-05-21', 'BOKIR', 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(646, 'TIKO KUMORO BIN MARIYANTO', 'AIII. 335/2025', '2025-10-14', '2026-02-18', NULL, 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(647, 'TISNA ADI BASUKI BIN MAT ALI', 'AIIIN. 311/2025', '2025-07-23', '2026-01-19', 'MONOT', 'A', 'A1', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(648, 'TITIS PRABOWO BIN SUTRISNO', 'AII. 379/2025', '2025-11-18', '2026-01-18', NULL, 'A', 'A7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(649, 'TIYONO BIN GIMAN (ALM)', 'BI. 006/2022', '2021-06-02', '2031-07-18', NULL, 'BA', 'BA8', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(650, 'TJAHJA FADJARI, M.ENG BIN NGASNO HADI PURWANTO (ALM)', 'AIIIK. 281/2025', '2025-05-23', '2026-02-08', NULL, 'BA', 'BA4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(651, 'TOMMY ADI SAPUTRO BIN MISNAN (ALM)', 'AI.N 346/2025', '2025-11-18', '2026-01-27', 'TOMEK', 'A', 'A9', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(652, 'TONI HANDOKO BIN SLAMET', 'BI. 200/2025', '2025-03-25', '2027-06-15', NULL, 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(653, 'TONI RISWAHYUDI BIN SOETIKNO', 'BI. 295/2023', '2023-05-25', '2028-09-01', NULL, 'C', 'C16', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(654, 'TONI WALOYO BIN (ALM) SUTAR', 'BI.N 281/2022', '2021-12-07', '2026-08-14', NULL, 'BA', 'BA14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(655, 'TONY HARIYONO BIN PONIMAN ( ALM )', 'BI.N 311/2025', '2025-06-04', '2033-11-19', NULL, 'A', 'A11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(656, 'TRI AGUS WULYO BIN JIUN', 'BI.N 202/2024', '2024-09-11', '2029-08-19', NULL, 'D', 'D4', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(657, 'TRI ARBI PAMUNGKAS BIN SUKIS', 'AVN. 009/2025', '2025-02-11', '2026-03-21', 'DOBOL', 'C', 'C15', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(658, 'TRIONO WISNU SAPUTRA BIN SUROSO WISNU SAPUTRO', 'BI.N 407/2023', '2023-01-18', '2026-12-01', 'KOCET', 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(659, 'TULUS CAHYO UTOMO BIN ACHMAD SISWOYO', 'BI.N 020/2025', '2024-09-11', '2032-03-02', NULL, 'C', 'C13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(660, 'USA SUBEKTI ALIAS REMON BIN SUBEKTI', 'BI.N 230/2022', '2021-04-06', '2026-11-28', 'REMON', 'C', 'C3', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(661, 'USSOFAN BIN OSIN', 'BI.N 280/2025', '2025-04-17', '2033-04-08', 'SOFAN', 'BA', 'BA12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(662, 'VICKY BAGUS SANTOSO BIN SUGIMAN BIN SUGIMAN', 'AIIIN. 370/2025', '2025-11-27', '2026-01-14', NULL, 'C', 'C7', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(663, 'VICKY REZA PRASETYO BIN -', 'AIII. 356/2025', '2025-07-02', '2026-03-03', 'GENDUT', 'A', 'A13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(664, 'VILBYAN AL JAFARI MUNIF BIN JUMANI MUNIF', 'AIII. 358/2025', '2025-10-30', '2026-03-05', 'ARI', 'A', 'A13', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(665, 'WAHYU HENDRA SAPUTRA BIN SUWITO', 'BI.N 279/2025', '2025-03-17', '2032-03-05', NULL, 'C', 'C14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(666, 'WAHYU SEPTIAN ISKANDAR BIN MUSTAKIM', 'BI.N 039/2025', '2023-08-29', '2027-11-24', NULL, 'BA', 'BA11', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(667, 'WAHYUDI BIN SANEMAN', 'BI. 306/2025', '2025-08-31', '2028-03-15', 'YUDI', 'A', 'A6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(668, 'WAKHID RAHMAT DONNY BIN SUMIKAN', 'AIIN. 368/2025', '2025-08-31', '2026-01-11', 'DANI', 'A', 'A14', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(669, 'WARSILAN BIN SANUWAR', 'BI. 500/2023', '2023-05-22', '2031-07-26', NULL, 'BA', 'BA7', '2026-01-16 00:21:27', '2026-01-16 00:21:27');
INSERT INTO `wbps` (`id`, `nama`, `no_registrasi`, `tanggal_masuk`, `tanggal_ekspirasi`, `nama_panggilan`, `blok`, `kamar`, `created_at`, `updated_at`) VALUES
(670, 'WAWAN BIN MUNARI (ALM)', 'AIIIN. 361/2025', '2025-08-31', '2026-03-09', 'GENDON', 'A', 'A10', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(671, 'WAWAN PRIBADI BIN SUBANDI', 'BI.N 092/2025', '2024-12-05', '2035-01-13', 'CIPRUT', 'A', 'A12', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(672, 'WIDARTO ADE GUNAWAN BIN SAMAD (ALM)', 'BI.N 199/2025', '2024-09-24', '2027-07-29', 'MENTES', 'BA', 'BA6', '2026-01-16 00:21:27', '2026-01-16 00:21:27'),
(673, 'WIJAYA BIN KEMAN', 'BI. 314/2025', '2025-08-26', '2027-03-20', NULL, 'BA', 'BA1', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(674, 'WILLY EKO WARDANA BIN WISNU SUROSO', 'BI.N 137/2023', '2022-01-04', '2026-04-29', NULL, 'C', 'C13', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(675, 'WINDIYANTO BIN WIJIHADI SISWOTO', 'BI.N 114/2023', '2022-05-30', '2027-08-13', 'TOMPEL', 'BA', 'BA6', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(676, 'WIRA DWI PUTRANTO BIN PUJI (ALM)', 'BI.N 193/2024', '2024-04-05', '2028-03-24', 'JAMBRONG', 'C', 'C12', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(677, 'YANTO BIN WARIMIN', 'BI. 183/2025', '2025-01-09', '2028-01-16', NULL, 'BA', 'BA11', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(678, 'YATENO BIN KASUT', 'BI. 277/2025', '2025-07-02', '2026-12-21', NULL, 'A', 'A7', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(679, 'YERI ANDREAWAN BIN BASUKI', 'BI.N 016/2025', '2024-09-11', '2029-10-14', 'BASUKI', 'C', 'C6', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(680, 'YOGIG AL AZHAR BIN SLAMET ARIFIN (ALM)', 'BI.N 370/2023', '2023-07-18', '2028-08-08', NULL, 'C', 'C13', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(681, 'YOKI SISWANTO BIN JUMA\'IN', 'AV.N 020/2025', '2025-02-25', '2026-03-25', 'YOKI', 'A', 'A5', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(682, 'YONGKI FERDIAN FARANDI BIN HADI SUKAREM (ALM)', 'AVN. 027/2025', '2025-03-25', '2026-05-17', NULL, 'A', 'A12', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(683, 'YUDA ADITYA PUTRA BIN JUSDI', 'BI.N 329/2023', '2023-06-13', '2027-11-28', NULL, 'A', 'A7', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(684, 'YUDI ARIVIYANTO BIN H. IRFAN', 'BI.N 143/2025', '2024-11-13', '2031-07-26', 'KENTUNG', 'BA', 'BA5', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(685, 'YUNUS ANWAR BIN SUYOTO', 'BI.N 278/2022', '2022-02-04', '2027-06-21', NULL, 'BA', 'BA7', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(686, 'YUNUS FIRMANSYAH BIN ISMAIL ( ALM )', 'AI.N 364/2025', '2025-12-03', '2026-01-11', NULL, 'D', 'D2', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(687, 'YUSUF EFENDI BIN SARWANTO', 'AIIIN. 350/2025', '2025-07-23', '2026-03-01', NULL, 'A', 'A3', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(688, 'ZAENAL ARIFIN BIN SUPARMAN (ALM)', 'AV.N 019/2025', '2025-03-17', '2026-03-29', 'BOWO', 'C', 'C13', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(689, 'ZAINAL ABIDIN BIN KHUDORI', 'BI.N 182/2025', '2025-01-09', '2031-11-30', 'PITON', 'A', 'A5', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(690, 'ZAINUL ABIDIN BIN RIYADI', 'AVN. 010/2025', '2025-02-11', '2026-03-21', NULL, 'C', 'C6', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(691, 'ZAKI PUTRA WARDANA BIN SUWARNO', 'BI.N 295/2025', '2025-06-04', '2029-05-24', NULL, 'A', 'A5', '2026-01-16 00:21:28', '2026-01-16 00:21:28'),
(692, 'ZAMANIA MUAMMAR MUBAROK BIN ACHMAD ZAINI', 'BI. 100/2025', '2025-04-09', '2026-05-24', 'AMAR GONDRONG', 'A', 'A7', '2026-01-16 00:21:28', '2026-01-16 00:21:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian_status`
--
ALTER TABLE `antrian_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `antrian_status_tanggal_sesi_unique` (`tanggal`,`sesi`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kunjungans`
--
ALTER TABLE `kunjungans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kunjungans_qr_token_unique` (`qr_token`),
  ADD UNIQUE KEY `kunjungans_kode_kunjungan_unique` (`kode_kunjungan`),
  ADD UNIQUE KEY `kunjungan_unik_per_hari` (`tanggal_kunjungan`,`nomor_antrian_harian`),
  ADD KEY `kunjungans_wbp_id_foreign` (`wbp_id`),
  ADD KEY `kunjungans_profil_pengunjung_id_foreign` (`profil_pengunjung_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengikuts`
--
ALTER TABLE `pengikuts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengikuts_kunjungan_id_foreign` (`kunjungan_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_wbp_creator_id_foreign` (`wbp_creator_id`);

--
-- Indexes for table `profil_pengunjungs`
--
ALTER TABLE `profil_pengunjungs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profil_pengunjungs_nik_unique` (`nik`);

--
-- Indexes for table `profil_pengunjung_pengikut`
--
ALTER TABLE `profil_pengunjung_pengikut`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profil_pengunjung_pengikut_profil_pengunjung_id_foreign` (`profil_pengunjung_id`),
  ADD KEY `profil_pengunjung_pengikut_pengikut_id_foreign` (`pengikut_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wbps`
--
ALTER TABLE `wbps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wbps_no_registrasi_unique` (`no_registrasi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=700;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian_status`
--
ALTER TABLE `antrian_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kunjungans`
--
ALTER TABLE `kunjungans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengikuts`
--
ALTER TABLE `pengikuts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profil_pengunjungs`
--
ALTER TABLE `profil_pengunjungs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `profil_pengunjung_pengikut`
--
ALTER TABLE `profil_pengunjung_pengikut`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wbps`
--
ALTER TABLE `wbps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=693;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kunjungans`
--
ALTER TABLE `kunjungans`
  ADD CONSTRAINT `kunjungans_profil_pengunjung_id_foreign` FOREIGN KEY (`profil_pengunjung_id`) REFERENCES `profil_pengunjungs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kunjungans_wbp_id_foreign` FOREIGN KEY (`wbp_id`) REFERENCES `wbps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengikuts`
--
ALTER TABLE `pengikuts`
  ADD CONSTRAINT `pengikuts_kunjungan_id_foreign` FOREIGN KEY (`kunjungan_id`) REFERENCES `kunjungans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_wbp_creator_id_foreign` FOREIGN KEY (`wbp_creator_id`) REFERENCES `wbps` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `profil_pengunjung_pengikut`
--
ALTER TABLE `profil_pengunjung_pengikut`
  ADD CONSTRAINT `profil_pengunjung_pengikut_pengikut_id_foreign` FOREIGN KEY (`pengikut_id`) REFERENCES `pengikuts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `profil_pengunjung_pengikut_profil_pengunjung_id_foreign` FOREIGN KEY (`profil_pengunjung_id`) REFERENCES `profil_pengunjungs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
