-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221120.420485a41b
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2023 at 11:23 AM
-- Server version: 8.0.33-0ubuntu0.22.04.2
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peerfleet`
--

-- --------------------------------------------------------

--
-- Table structure for table `pf_sailing_area`
--

CREATE TABLE `pf_sailing_area` (
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pf_sailing_area`
--

INSERT INTO `pf_sailing_area` (`id`, `name`, `deleted`) VALUES
('australia-oceania', 'Australia / Oceania', 0),
('baltic-sea', 'Baltic Sea', 0),
('bering-sea', 'Bering Sea', 0),
('caribbean-sea', 'Caribbean Sea', 0),
('caspian-sea', 'Caspian Sea', 0),
('east-africa', 'East Africa', 0),
('east-mediterranean-black-sea', 'East Mediterranean Sea & Black Sea', 0),
('great-lakes', 'Great Lakes', 0),
('indian-ocean', 'Indian Ocean', 0),
('north-america-east-coast', 'North America East Coast', 0),
('north-america-west-coast', 'North America West Coast', 0),
('north-asia-japan-korea', 'North Asia (Japan, Korea)', 0),
('north-pacific', 'North Pacific', 0),
('north-sea-atlantic', 'North Sea / Atlantic', 0),
('red-sea-persian-gulf', 'Red Sea & Persian Gulf', 0),
('south-africa', 'South Africa', 0),
('south-america-east-coast', 'South America East Coast', 0),
('south-america-west-coast', 'South America West Coast', 0),
('south-asia', 'South Asia', 0),
('south-east-asia-china-vietnam', 'South East Asia (China, Vietnam)', 0),
('south-pacific-ocean', 'South Pacific Ocean', 0),
('us-gulf', 'US Gulf', 0),
('west-africa', 'West Africa', 0),
('west-mediterranean-sea', 'West Mediterranean Sea', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pf_sailing_area`
--
ALTER TABLE `pf_sailing_area`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
