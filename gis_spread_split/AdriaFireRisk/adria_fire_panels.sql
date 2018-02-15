-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2016 at 01:30 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zavrsni_rad_baza`
--

-- --------------------------------------------------------

--
-- Table structure for table `adria_fire_panels`
--

CREATE TABLE `adria_fire_panels` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `lat` decimal(7,5) NOT NULL,
  `longi` decimal(7,5) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `risk` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adria_fire_panels`
--

INSERT INTO `adria_fire_panels` (`id`, `name`, `lat`, `longi`, `date`, `time`, `risk`) VALUES
(1, 'Mosor', '43.50810', '18.21458', '2016-05-03', '03:15:22', 2),
(2, 'Kozjak', '21.50810', '15.25555', '2016-05-03', '12:00:00', 3),
(3, 'Svilaja', '10.50810', '12.55555', '2016-05-03', '04:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adria_fire_panels`
--
ALTER TABLE `adria_fire_panels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adria_fire_panels`
--
ALTER TABLE `adria_fire_panels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
