-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2021 at 03:22 PM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.3.28-1+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mj_freeway`
--

-- --------------------------------------------------------

--
-- Table structure for table `caffeinated_menu`
--

CREATE TABLE `caffeinated_menu` (
  `id` int UNSIGNED NOT NULL,
  `name` char(255) NOT NULL,
  `description` text NOT NULL,
  `caffeine_quantity` char(255) NOT NULL,
  `caffeine_quantity_unit` enum('mg') NOT NULL DEFAULT 'mg',
  `image` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'assets/images/shop/img_01.png',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('ACTIVE','NOT ACTIVE') NOT NULL DEFAULT 'NOT ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Caffeinated menu table';

--
-- Dumping data for table `caffeinated_menu`
--

INSERT INTO `caffeinated_menu` (`id`, `name`, `description`, `caffeine_quantity`, `caffeine_quantity_unit`, `image`, `updated_at`, `created_at`, `status`) VALUES
(1, 'Monster Ultra\r\nSunrise', 'A refreshing orange beverage that has 75mg of caffeine per serving. Every can has two servings.', '75', 'mg', 'assets/images/shop/img_01.png', '2021-05-12 09:38:42', '2021-05-12 09:38:42', 'ACTIVE'),
(2, 'Black Coffee', 'The classic, the average 8oz. serving of black coffee has 95mg of caffeine.', '95', 'mg', 'assets/images/shop/img_06.png', '2021-05-12 09:38:42', '2021-05-12 09:38:42', 'ACTIVE'),
(3, 'Americano', 'Sometimes you need to water it down a bit... and in comes the americano with an average of 77mg. of caffeine\r\nper serving.', '77', 'mg', 'assets/images/shop/img_03.png', '2021-05-12 09:39:41', '2021-05-12 09:39:41', 'ACTIVE'),
(4, 'Sugar free NOS', 'Another orange delight without the sugar. It has 130 mg. per serving and each can has two servings.', '130', 'mg', 'assets/images/shop/img_01.png', '2021-05-12 09:39:41', '2021-05-12 09:39:41', 'ACTIVE'),
(5, '5 Hour Energy', 'And amazing shot of get up and go! Each 2 fl. oz. container has 200mg of caffeine to get you going.', '200', 'mg', 'assets/images/shop/img_05.png', '2021-05-17 15:46:34', '2021-05-12 09:40:11', 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `caffeinated_menu`
--
ALTER TABLE `caffeinated_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `caffeinated_menu`
--
ALTER TABLE `caffeinated_menu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
