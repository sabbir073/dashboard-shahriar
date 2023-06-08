-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2023 at 04:15 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shahu`
--

-- --------------------------------------------------------

--
-- Table structure for table `pay_options`
--

CREATE TABLE `pay_options` (
  `id` int(11) NOT NULL,
  `pay_name` varchar(50) NOT NULL,
  `pay_address` varchar(100) NOT NULL,
  `pay_instruction` varchar(255) NOT NULL,
  `pay_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pay_options`
--

INSERT INTO `pay_options` (`id`, `pay_name`, `pay_address`, `pay_instruction`, `pay_image`) VALUES
(3, 'Paypal', 'paypal@gmail.com', 'send money in paypal', 'rsz_brand.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`, `balance`, `created_at`) VALUES
(1, 'Md Sabbir Ahmed', 'md.sabbir073@gmail.com', '$2y$10$R2UQMb9jk8PjuAGioBrPF.DMkm/q89RsMaVsYTyi4J10Gv8T0s3My', 'admin', '0.00', '2023-06-06 18:16:58'),
(7, 'sobuj', 'abc@abcc.com', '$2y$10$nHvYuDhTCAf2bO5y.UYH2e4WLgSue8kAvyWNhDQpUTeZfN6AUP1am', 'user', '50.47', '2023-06-08 17:11:37'),
(8, 'alamin', 'alamin@abc.co', '$2y$10$a4hvncSgetGH9bEK3DsLkusmcKlpqIyUUgAbYHd2XseWrlAsP5ezG', 'user', '95.10', '2023-06-08 17:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `website_setting`
--

CREATE TABLE `website_setting` (
  `id` int(11) NOT NULL,
  `logo_image_name` varchar(255) NOT NULL,
  `background_image_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `website_setting`
--

INSERT INTO `website_setting` (`id`, `logo_image_name`, `background_image_name`, `company_name`) VALUES
(1, 'S STAR FAIR LOGOO.png', 'rsz_relax-area-hotel.jpg', 'Sobuj Company');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pay_options`
--
ALTER TABLE `pay_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `website_setting`
--
ALTER TABLE `website_setting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pay_options`
--
ALTER TABLE `pay_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `website_setting`
--
ALTER TABLE `website_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
