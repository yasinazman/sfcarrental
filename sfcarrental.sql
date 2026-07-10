-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2026 at 09:34 AM
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
(1, 'yasin', '$2y$12$Pfia1JONU1X9lzP.3SMlbOzVUYcUq37HN/2VK2O0PosGQk6obB3O2', 'Master', 'Active', '2026-07-10 09:21:51', '2026-07-03 14:18:08', '2026-07-10 09:21:51'),
(7, 'Eyya', '$2y$12$M2e/SuMQiQHHVFWDMGNUjeipfhOfuSb6YsgUDkSM4rKwj1rXMMFfK', 'Staff', 'Active', NULL, '2026-07-04 05:58:20', '2026-07-10 03:19:50'),
(8, 'adib', '$2y$12$zV.cmgVK1esRviwPyi5PJ.jf1jnnvWN6Da/rrDlGSOvb6Iw.pnsFW', 'Staff', 'Active', NULL, '2026-07-06 01:00:17', '2026-07-06 01:00:17');

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

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `car_id`, `start_date`, `end_date`, `rental_price`, `deposit_amount`, `total_price`, `booking_status`, `lockbox_pin`, `deposit_status`, `created`, `modified`) VALUES
(6, 1, 1, '2026-07-05 10:00:00', '2026-07-07 10:00:00', '120.00', '100.00', '340.00', 'Approved', '5644', 'Paid', '2026-07-04 13:09:53', '2026-07-09 13:13:45');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `plate_number` varchar(20) NOT NULL,
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

INSERT INTO `cars` (`id`, `plate_number`, `car_model`, `category`, `image`, `engine_capacity`, `seat_capacity`, `transmission`, `baggage_capacity`, `fuel_type`, `spare_tyre`, `special_specs`, `daily_rate`, `availability_status`, `latitude`, `longitude`, `created`, `modified`) VALUES
(1, 'VHA 1234', 'Perodua Myvi 1.5', 'SUV', '1783138726_perodua-myvi-color-652190.webp', '1500', 5, 'Automatic', 2, 'Petrol Ron95', 'included', '1.3', '120.00', 'Available', '3.14152700', '101.48813600', '2026-07-04 04:18:46', '2026-07-10 08:57:09');

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
(1, 'Ahmad Albab', '012-3456789', 'password123', '', NULL, '', 'Active', '2026-07-04 13:05:29', '2026-07-09 15:17:29'),
(2, 'leo', '123456', '123456', '1783611103_MYKAD.png', '1783611103_ICBack-e1482171138165.png', '1783611103_editors_images_1747880529218-New-2025-Malaysian-driving-licence-design-front-630x415.jpg', 'Active', '2026-07-09 15:31:43', '2026-07-09 15:31:43');

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
(1, 1, 'Engine Oil Change', '', '300.00', 10000, '2026-07-17', '2027-04-02', 'In Progress', '2026-07-06 02:06:35', '2026-07-10 08:57:56');

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
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `payment_time`, `total_payment`, `payment_method`, `payment_status`, `created`, `modified`) VALUES
(1, 6, '2026-07-06 14:30:00', '350.00', 'Online Banking', 'Completed', '2026-07-06 14:30:00', '2026-07-06 14:30:00'),
(2, 6, '2026-06-15 10:15:00', '450.00', 'Credit Card', 'Completed', '2026-06-15 10:15:00', '2026-06-15 10:15:00'),
(3, 6, NULL, '150.00', 'Cash', 'Pending', '2026-07-07 09:00:00', '2026-07-07 09:00:00');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
