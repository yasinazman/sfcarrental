-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 18, 2026 at 12:41 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfcarrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'Staff',
  `status` varchar(50) NOT NULL DEFAULT 'Active',
  `last_login` datetime DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `role`, `status`, `last_login`, `created`, `modified`) VALUES
(1, 'yasin', '$2y$12$mm.VsMQP6Robpyb1mzeZOe36FWkdFedSJokGPD3oSU6N24h2D27ba', 'Master', 'Active', '2026-07-17 14:14:24', '2026-07-03 14:18:08', '2026-07-17 14:14:24'),
(12, 'adib', '$2y$12$iuosGJWuyqjCOX1UcLTqSeQNB8Jj7yobKb7gOhUgtfJDWnKyegmHa', 'Staff', 'Active', '2026-07-15 16:07:45', '2026-07-15 16:03:55', '2026-07-15 16:08:40'),
(13, 'mario', '$2y$12$GcGR3FvOm0ulEzZ.fXbxTujMZrOlwyIMs323nPtMoV5PDZzbtGvO6', 'Staff', 'Active', NULL, '2026-07-15 16:04:15', '2026-07-15 16:04:15'),
(14, 'adi', '$2y$12$lCgQFmx9RLoaTJ5f0TXgsuSjDp19YNN7ZqRylzswjfRlEpu9hGvD2', 'Staff', 'Active', NULL, '2026-07-15 16:04:31', '2026-07-15 16:04:31'),
(15, 'aqif', '$2y$12$TfZCJAYKb1JMHhTiaEbLpOJy3sFlLsb2LkB1X7ugBhbpgmLFgqbti', 'Staff', 'Active', NULL, '2026-07-15 16:04:47', '2026-07-15 16:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `car_id` int NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `rental_price` decimal(10,2) NOT NULL,
  `deposit_amount` decimal(10,2) DEFAULT '100.00',
  `total_price` decimal(10,2) NOT NULL,
  `booking_status` varchar(50) DEFAULT 'Pending Payment',
  `lockbox_pin` varchar(10) DEFAULT NULL,
  `deposit_status` varchar(50) DEFAULT 'Pending',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `car_category` varchar(50) DEFAULT 'Economy',
  `car_model` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `engine_capacity` varchar(50) DEFAULT NULL,
  `seat_capacity` int DEFAULT NULL,
  `transmission` varchar(50) DEFAULT NULL,
  `baggage_capacity` int DEFAULT NULL,
  `fuel_type` varchar(50) DEFAULT NULL,
  `spare_tyre` varchar(50) DEFAULT NULL,
  `special_specs` varchar(255) DEFAULT NULL,
  `daily_rate` decimal(10,2) NOT NULL,
  `availability_status` varchar(50) DEFAULT 'Available',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `plate_number`, `car_category`, `car_model`, `category`, `image`, `engine_capacity`, `seat_capacity`, `transmission`, `baggage_capacity`, `fuel_type`, `spare_tyre`, `special_specs`, `daily_rate`, `availability_status`, `latitude`, `longitude`, `created`, `modified`) VALUES
(8, 'VHA 1011', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078050_axia5.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:14:10', '2026-07-15 14:59:28'),
(9, 'VHA 1012', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078152_axia5.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:15:52', '2026-07-15 01:34:17'),
(10, 'VHA 1013', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078236_axia4.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:17:16', '2026-07-15 01:34:11'),
(11, 'VHA 1014', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078281_axia4.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:18:01', '2026-07-15 01:34:05'),
(12, ' VHA 1015', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078326_axia3.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:18:46', '2026-07-15 01:33:59'),
(13, 'VHA 1016', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078372_axia3.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:19:33', '2026-07-15 01:33:50'),
(14, 'VHA 1017', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078409_axia3.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:20:09', '2026-07-15 01:33:42'),
(15, 'VHA 1018', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078447_axia2.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:20:47', '2026-07-15 01:33:35'),
(16, 'VHA 1019', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078485_axia2.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:21:25', '2026-07-15 01:33:28'),
(17, 'VHA 1020', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078554_axia2.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:22:34', '2026-07-15 01:33:21'),
(18, 'VHA 1021', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078589_axia1.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:23:09', '2026-07-15 01:33:14'),
(19, 'VHA 1022', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078625_axia1.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:23:45', '2026-07-15 01:32:29'),
(20, 'VHA 1023', 'Economy', 'Perodua Axia 1.0G', 'Economy', '1784078657_axia1.webp', '998', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.0L VVT-i', '110.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:24:17', '2026-07-15 01:32:21'),
(21, 'VHB 2101', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079103_saga1.webp', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:31:43', '2026-07-15 01:31:43'),
(22, 'VHB 2102', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079329_saga1.webp', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:35:29', '2026-07-15 01:35:29'),
(23, 'VHB 2103', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079365_saga1.webp', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:36:05', '2026-07-15 01:36:05'),
(24, 'VHB 2104', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079396_saga1.webp', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:36:36', '2026-07-15 01:36:36'),
(25, 'VHB 2105', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079428_saga2.avif', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:37:08', '2026-07-15 01:37:08'),
(26, 'VHB 2106', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079469_saga2.avif', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:37:49', '2026-07-15 01:37:49'),
(27, 'VHB 2107', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079515_saga2.avif', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:38:35', '2026-07-15 01:38:35'),
(28, 'VHB 2108', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079556_saga2.avif', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:39:16', '2026-07-15 01:39:16'),
(29, 'VHB 2109', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079592_saga3.avif', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:39:52', '2026-07-15 01:39:52'),
(30, 'VHB 2110', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079621_saga3.avif', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:40:21', '2026-07-15 01:40:21'),
(31, 'VHB 2111', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079652_saga3.avif', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:40:52', '2026-07-15 01:40:52'),
(32, 'VHB 2112', 'Economy', 'Proton Saga 1.3 Premium', 'Economy', '1784079683_saga3.avif', '1332 ', 5, 'Automatic', 2, 'Petrol EEV - RON 95', 'Built-In', '1.3L VVT', '120.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:41:23', '2026-07-15 01:41:23'),
(33, 'BQG 4401', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080057_bezza1.webp', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:47:37', '2026-07-15 02:07:15'),
(34, 'BQG 4402', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080164_bezza1.webp', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:49:24', '2026-07-15 02:07:08'),
(35, 'BQG 4403', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080244_bezza1.webp', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:50:44', '2026-07-15 02:07:01'),
(36, 'BQG 4404', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080338_bezza1.webp', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:52:18', '2026-07-15 02:06:54'),
(37, 'BQG 4405', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080373_bezza2.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:52:53', '2026-07-15 02:06:46'),
(38, 'BQG 4406', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080405_bezza2.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:53:25', '2026-07-15 02:06:39'),
(39, 'BQG 4407', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080437_bezza2.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:53:57', '2026-07-15 02:06:30'),
(40, 'BQG 4408', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080470_bezza3.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:54:30', '2026-07-15 02:06:23'),
(41, 'BQG 4409', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080528_bezza3.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:55:28', '2026-07-15 02:06:16'),
(42, 'BQG 4410', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080560_bezza3.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'Built-In', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:56:00', '2026-07-15 02:00:17'),
(43, 'BQG 4411', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080598_bezza3.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:56:38', '2026-07-15 02:06:07'),
(44, 'BQG 4412', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080640_bezza4.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:57:20', '2026-07-15 02:05:57'),
(45, 'BQG 4413', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080677_bezza4.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:57:57', '2026-07-15 02:05:49'),
(46, 'BQG 4414', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080731_bezza4.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:58:51', '2026-07-15 02:05:42'),
(47, 'BQG 4415', 'Economy', 'Perodua Bezza 1.3 X', 'Sedan', '1784080781_bezza4.avif', '1329', 5, 'Automatic', 3, 'Petrol EEV - RON 95', 'included', '1.3L Dual VVT-i', '130.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 01:59:41', '2026-07-15 02:05:32'),
(48, 'VHC 5501', 'Economy', 'Proton Persona 1.6 Premium', 'Sedan', '1784081115_persona1.webp', '1597', 5, 'Automatic', 3, 'Petrol - RON 95', 'included', '1.6L VVT', '150.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:05:16', '2026-07-15 02:05:16'),
(49, 'VHC 5502', 'Economy', 'Proton Persona 1.6 Premium', 'Sedan', '1784081346_persona1.webp', '1,597', 5, 'Automatic', 3, 'Petrol - RON 95', 'included', '1.6L VVT', '150.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:09:06', '2026-07-15 02:09:06'),
(50, 'VHC 5503', 'Economy', 'Proton Persona 1.6 Premium', 'Sedan', '1784081391_persona2.jpg', '1597', 5, 'Automatic', 3, 'Petrol - RON 95', 'included', '1.6L VVT', '150.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:09:51', '2026-07-15 02:09:51'),
(51, 'VHC 5504', 'Economy', 'Proton Persona 1.6 Premium', 'Sedan', '1784081434_persona2.jpg', '1597', 5, 'Automatic', 3, 'Petrol - RON 95', 'included', '1.6L VVT', '150.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:10:34', '2026-07-15 02:10:34'),
(52, 'VHC 5505', 'Economy', 'Proton Persona 1.6 Premium', 'Sedan', '1784081461_persona3.webp', '1597', 5, 'Automatic', 3, 'Petrol - RON 95', '', '1.6L VVT', '150.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:11:02', '2026-07-15 02:11:02'),
(53, 'BQF 3301', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081669_myvi1.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:14:29', '2026-07-15 02:14:29'),
(54, 'BQF 3302', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081706_myvi1.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:15:06', '2026-07-15 02:15:06'),
(55, 'BQF 3303', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081749_myvi1.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:15:49', '2026-07-15 02:15:49'),
(56, 'BQF 3304', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081787_myvi1.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:16:27', '2026-07-15 02:16:27'),
(57, 'BQF 3305', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081819_myvi1.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:16:59', '2026-07-15 02:16:59'),
(58, 'BQF 3306', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081851_myvi2.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:17:31', '2026-07-15 02:17:31'),
(59, 'BQF 3307', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081889_myvi2.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:18:09', '2026-07-15 02:18:09'),
(60, 'BQF 3308', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081925_myvi2.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:18:45', '2026-07-15 02:18:45'),
(61, 'BQF 3309', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081954_myvi2.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:19:14', '2026-07-15 02:19:14'),
(62, 'BQF 3310', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784081986_myvi2.avif', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:19:46', '2026-07-15 02:19:46'),
(63, 'BQF 3311', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082018_myvi3.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:20:18', '2026-07-15 02:20:18'),
(64, 'BQF 3312', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082090_myvi3.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:21:30', '2026-07-15 02:21:30'),
(65, 'BQF 3313', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082151_myvi3.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:22:32', '2026-07-15 02:22:32'),
(66, 'BQF 3314', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082183_myvi3.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:23:03', '2026-07-15 02:23:04'),
(67, 'BQF 3315', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082208_myvi3.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:23:28', '2026-07-15 02:23:28'),
(68, 'BQF 3316', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082242_myvi4.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:24:02', '2026-07-15 02:24:02'),
(69, 'BQF 3317', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082269_myvi4.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:24:29', '2026-07-15 02:24:29'),
(70, 'BQF 3318', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082310_myvi4.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:25:10', '2026-07-15 02:25:10'),
(71, 'BQF 3319', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082338_myvi4.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:25:38', '2026-07-15 02:25:38'),
(72, 'BQF 3320', 'Economy', 'Perodua Myvi 1.5H', 'Compact', '1784082369_myvi4.webp', '1496', 5, 'Automatic', 2, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '140.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:26:09', '2026-07-15 02:26:09'),
(73, 'VHC 6601', 'Economy', 'Perodua Alza 1.5 AV', 'MPV', '1784082818_alza1.jpg', '1496', 7, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '180.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:33:38', '2026-07-15 02:35:25'),
(74, 'VHC 6602', 'Economy', 'Perodua Alza 1.5 AV', 'MPV', '1784082892_alza2.webp', '1496', 7, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '180.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:34:52', '2026-07-15 02:34:52'),
(75, 'VHC 6603', 'Economy', 'Perodua Alza 1.5 AV', 'MPV', '1784082955_alza2.webp', '1496', 7, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '180.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:35:55', '2026-07-15 02:35:55'),
(76, 'VHC 6604', 'Economy', 'Perodua Alza 1.5 AV', 'MPV', '1784082986_alza3.jpg', '1496', 7, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '180.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:36:26', '2026-07-15 02:36:26'),
(77, 'VHC 6605', 'Economy', 'Perodua Alza 1.5 AV', 'MPV', '1784083021_alza3.jpg', '1496', 7, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '180.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:37:01', '2026-07-15 02:37:01'),
(78, 'VHC 6606', 'Economy', 'Perodua Alza 1.5 AV', 'MPV', '1784083158_alza1.jpg', '1496', 7, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '180.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:39:18', '2026-07-15 02:40:21'),
(79, 'VHC 6607', 'Economy', 'Perodua Alza 1.5 AV', 'MPV', '1784083192_alza2.webp', '1496', 7, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '180.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:39:52', '2026-07-15 02:40:32'),
(80, 'VHC 6608', 'Economy', 'Perodua Alza 1.5 AV', 'MPV', '1784083308_alza3.jpg', '1496', 7, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Dual VVT-i', '180.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:41:09', '2026-07-15 02:41:48'),
(81, 'BQH 7704', 'Economy', 'Nissan Serena 2.0 S-Hybrid', 'MPV', '1784083444_serena1.webp', '1997', 7, 'Automatic', 4, 'Petrol - RON 95/97', 'included', '2.0L Hybrid', '350.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:43:20', '2026-07-15 02:44:40'),
(82, 'BQH 7705', 'Economy', 'Nissan Serena 2.0 S-Hybrid', 'MPV', '1784083435_serena1.webp', '1997', 7, 'Automatic', 4, 'Petrol - RON 95/97', 'included', '2.0L Hybrid', '350.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:43:55', '2026-07-15 02:44:55'),
(83, 'VHD 8801', 'Economy', 'Proton X50 1.5T Standard', 'SUV', '1784083851_x503.webp', '1477', 5, '', 3, 'Petrol - RON 95', 'included', '1.5L Turbo', '250.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:50:51', '2026-07-15 02:50:51'),
(84, 'VHD 8802', 'Economy', 'Proton X50 1.5T Standard', 'SUV', '1784083899_x502.webp', '1477', 5, 'Automatic', 3, 'Petrol - RON 95', 'included', '1.5L Turbo', '250.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:51:39', '2026-07-15 02:51:39'),
(85, 'VHD 8803', 'Economy', 'Proton X50 1.5T Standard', 'SUV', '1784083939_x501.webp', '1477', 5, 'Automatic', 3, 'Petrol - RON 95', 'included', '1.5L Turbo', '250.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:52:20', '2026-07-15 14:58:52'),
(86, 'VHD 9901', 'Economy', 'Proton x70 1.5 Standard', 'SUV', '1784084225_x70.webp', '1477', 5, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Turbo', '300.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:57:05', '2026-07-15 15:58:53'),
(87, 'VHD 9902', 'Economy', 'Proton x70 1.5 Standard', 'SUV', '1784084262_x70.webp', '1477', 5, 'Automatic', 4, 'Petrol - RON 95', 'included', '1.5L Turbo', '300.00', 'Available', '3.06860000', '101.49040000', '2026-07-15 02:57:42', '2026-07-15 15:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ic_file_path` varchar(255) NOT NULL,
  `ic_back_file_path` varchar(255) DEFAULT NULL,
  `license_file_path` varchar(255) NOT NULL,
  `account_status` varchar(50) NOT NULL DEFAULT 'Active',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `phone_number`, `password`, `ic_file_path`, `ic_back_file_path`, `license_file_path`, `account_status`, `created`, `modified`) VALUES
(5, 'Zaki', '0112223333', '$2y$12$oTdIU1BvXJJW10jrU7xxiumZJpoqwlC44q0xkpOSlFzvMBR7EFwf6', 'uploads/1784293398_ic_front_x70.webp', 'uploads/1784293398_ic_back_x503.webp', 'uploads/1784293398_license_x502.webp', 'Active', '2026-07-17 13:03:18', '2026-07-17 13:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` int NOT NULL,
  `car_id` int NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `description` text,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mileage` int DEFAULT NULL,
  `service_date` date NOT NULL,
  `next_service_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Completed',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `maintenances`
--

INSERT INTO `maintenances` (`id`, `car_id`, `service_type`, `description`, `cost`, `mileage`, `service_date`, `next_service_date`, `status`, `created`, `modified`) VALUES
(5, 87, 'Brake Pad Replacement', '', '0.00', NULL, '2026-09-11', '2026-12-10', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 15:42:59'),
(6, 41, 'General Inspection', NULL, '0.00', NULL, '2026-09-11', '2027-03-10', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(7, 35, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-09-10', '2026-12-09', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(8, 53, 'General Inspection', NULL, '0.00', NULL, '2026-09-09', '2027-03-08', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(9, 51, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-09-08', '2026-12-07', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(10, 10, 'General Inspection', NULL, '0.00', NULL, '2026-09-06', '2027-03-05', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(11, 52, 'Tyre Replacement', NULL, '0.00', NULL, '2026-09-05', '2027-03-04', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(12, 84, 'Battery Change', NULL, '0.00', NULL, '2026-09-02', '2027-03-01', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(13, 14, 'Battery Change', NULL, '0.00', NULL, '2026-08-30', '2026-11-28', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(14, 86, 'Battery Change', NULL, '0.00', NULL, '2026-08-30', '2026-11-28', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(15, 27, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-08-28', '2027-02-24', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(16, 30, 'Repair (Other)', NULL, '0.00', NULL, '2026-08-28', '2026-11-26', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(17, 78, 'General Inspection', NULL, '0.00', NULL, '2026-08-27', '2027-02-23', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(18, 60, 'Battery Change', NULL, '0.00', NULL, '2026-08-26', '2027-02-22', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(19, 32, 'Battery Change', NULL, '0.00', NULL, '2026-08-23', '2026-11-21', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(20, 37, 'Engine Oil Change', NULL, '0.00', NULL, '2026-08-22', '2027-02-18', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(21, 29, 'Battery Change', NULL, '0.00', NULL, '2026-08-22', '2027-02-18', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(22, 69, 'General Inspection', NULL, '0.00', NULL, '2026-08-21', '2026-11-19', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(23, 77, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-08-20', '2027-02-16', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(24, 18, 'Repair (Other)', NULL, '0.00', NULL, '2026-08-16', '2027-02-12', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(25, 15, 'Repair (Other)', NULL, '0.00', NULL, '2026-08-16', '2027-02-12', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(26, 28, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-08-14', '2027-02-10', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(27, 68, 'Engine Oil Change', NULL, '0.00', NULL, '2026-08-14', '2027-02-10', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(28, 16, 'Battery Change', NULL, '0.00', NULL, '2026-08-12', '2027-02-08', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(29, 71, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-08-08', '2026-11-06', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(30, 64, 'Repair (Other)', NULL, '0.00', NULL, '2026-08-06', '2027-02-02', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(31, 56, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-08-06', '2027-02-02', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(32, 43, 'Engine Oil Change', NULL, '0.00', NULL, '2026-08-05', '2027-02-01', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(33, 13, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-08-04', '2027-01-31', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(34, 46, 'General Inspection', NULL, '0.00', NULL, '2026-07-31', '2027-01-27', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(35, 42, 'Tyre Replacement', NULL, '0.00', NULL, '2026-07-31', '2027-01-27', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(36, 11, 'Battery Change', NULL, '0.00', NULL, '2026-07-28', '2027-01-24', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(37, 8, 'Engine Oil Change', NULL, '0.00', NULL, '2026-07-26', '2027-01-22', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(38, 17, 'Battery Change', NULL, '0.00', NULL, '2026-07-26', '2026-10-24', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(39, 73, 'Tyre Replacement', NULL, '0.00', NULL, '2026-07-25', '2027-01-21', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(40, 26, 'Battery Change', NULL, '0.00', NULL, '2026-07-22', '2027-01-18', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(41, 81, 'Brake Pad Replacement', NULL, '0.00', NULL, '2026-07-22', '2026-10-20', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(42, 79, 'Engine Oil Change', NULL, '0.00', NULL, '2026-07-19', '2026-10-17', 'Scheduled', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(43, 82, 'Engine Oil Change', NULL, '525.00', NULL, '2026-07-16', '2026-10-14', 'In Progress', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(44, 70, 'Tyre Replacement', NULL, '945.00', NULL, '2026-07-15', '2027-01-11', 'In Progress', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(45, 76, 'Battery Change', NULL, '350.00', NULL, '2026-07-15', '2026-10-13', 'In Progress', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(46, 39, 'Tyre Replacement', NULL, '877.50', NULL, '2026-07-15', '2027-01-11', 'In Progress', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(47, 12, 'Tyre Replacement', NULL, '742.50', NULL, '2026-07-14', '2027-01-10', 'In Progress', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(48, 34, 'General Inspection', NULL, '80.00', NULL, '2026-07-14', '2026-10-12', 'In Progress', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(49, 20, 'Battery Change', NULL, '250.00', NULL, '2026-07-13', '2027-01-09', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(50, 40, 'Battery Change', NULL, '250.00', NULL, '2026-07-10', '2027-01-06', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(51, 23, 'General Inspection', NULL, '80.00', NULL, '2026-07-09', '2026-10-07', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(52, 61, 'General Inspection', NULL, '80.00', NULL, '2026-07-08', '2027-01-04', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(53, 67, 'Tyre Replacement', NULL, '945.00', NULL, '2026-07-07', '2026-10-05', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(54, 83, 'Brake Pad Replacement', NULL, '562.50', NULL, '2026-07-04', '2026-10-02', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(55, 75, 'Brake Pad Replacement', NULL, '405.00', NULL, '2026-07-02', '2026-09-30', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(56, 66, 'Battery Change', NULL, '250.00', NULL, '2026-07-01', '2026-12-28', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(57, 25, 'Engine Oil Change', NULL, '180.00', NULL, '2026-06-25', '2026-09-23', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(58, 31, 'Repair (Other)', NULL, '290.50', NULL, '2026-06-25', '2026-12-22', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(59, 54, 'Tyre Replacement', NULL, '945.00', NULL, '2026-06-25', '2026-09-23', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(60, 55, 'Brake Pad Replacement', NULL, '315.00', NULL, '2026-06-24', '2026-09-22', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(61, 74, 'Battery Change', NULL, '350.00', NULL, '2026-06-22', '2026-12-19', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(62, 85, 'Battery Change', NULL, '350.00', NULL, '2026-06-18', '2026-09-16', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(63, 48, 'Repair (Other)', NULL, '409.83', NULL, '2026-06-14', '2026-12-11', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(64, 19, 'Engine Oil Change', NULL, '165.00', NULL, '2026-06-13', '2026-12-10', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(65, 58, 'Brake Pad Replacement', NULL, '315.00', NULL, '2026-06-10', '2026-12-07', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(66, 59, 'Repair (Other)', NULL, '463.80', NULL, '2026-06-08', '2026-09-06', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(67, 62, 'General Inspection', NULL, '80.00', NULL, '2026-06-07', '2026-09-05', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(68, 49, 'Brake Pad Replacement', NULL, '337.50', NULL, '2026-06-05', '2026-12-02', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(69, 24, 'Battery Change', NULL, '250.00', NULL, '2026-06-04', '2026-12-01', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(70, 33, 'Tyre Replacement', NULL, '877.50', NULL, '2026-06-03', '2026-12-00', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(71, 72, 'Repair (Other)', NULL, '374.96', NULL, '2026-06-03', '2026-12-00', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(72, 36, 'Engine Oil Change', NULL, '195.00', NULL, '2026-06-02', '2026-08-31', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(73, 50, 'Repair (Other)', NULL, '529.62', NULL, '2026-06-01', '2026-11-28', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(74, 63, 'Engine Oil Change', NULL, '210.00', NULL, '2026-05-31', '2026-11-27', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(75, 65, 'Brake Pad Replacement', NULL, '315.00', NULL, '2026-05-29', '2026-08-27', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(76, 80, 'Engine Oil Change', NULL, '270.00', NULL, '2026-05-28', '2026-08-26', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(77, 9, 'Brake Pad Replacement', NULL, '247.50', NULL, '2026-05-27', '2026-08-25', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(78, 44, 'Repair (Other)', NULL, '288.75', NULL, '2026-05-26', '2026-08-24', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(79, 38, 'Repair (Other)', NULL, '438.74', NULL, '2026-05-24', '2026-08-22', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(80, 47, 'General Inspection', NULL, '80.00', NULL, '2026-05-22', '2026-08-20', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(81, 22, 'Engine Oil Change', NULL, '180.00', NULL, '2026-05-21', '2026-08-19', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(82, 21, 'Repair (Other)', NULL, '289.84', NULL, '2026-05-20', '2026-08-18', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(83, 57, 'Engine Oil Change', NULL, '210.00', NULL, '2026-05-18', '2026-11-14', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41'),
(84, 45, 'Tyre Replacement', NULL, '877.50', NULL, '2026-05-17', '2026-08-15', 'Completed', '2026-07-15 19:38:41', '2026-07-15 19:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `payment_time` datetime DEFAULT NULL,
  `total_payment` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT 'Pending',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Constraints for table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
