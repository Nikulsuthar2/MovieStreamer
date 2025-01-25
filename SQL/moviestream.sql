-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2025 at 07:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moviestream`
--

-- --------------------------------------------------------

--
-- Table structure for table `actor_dtl`
--

CREATE TABLE `actor_dtl` (
  `actor_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `imagepath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_dtl`
--

CREATE TABLE `admin_dtl` (
  `admin_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_dtl`
--

INSERT INTO `admin_dtl` (`admin_id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', 'adminadmin');

-- --------------------------------------------------------

--
-- Table structure for table `cast_dtl`
--

CREATE TABLE `cast_dtl` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(1, 'Action'),
(2, 'Free'),
(3, 'Kids'),
(4, 'Animation'),
(5, 'Super Hero'),
(6, 'Sci-Fi'),
(7, 'Romance'),
(8, 'Comedy'),
(9, 'Bollywood'),
(10, 'hollywood'),
(11, 'Marvel'),
(12, 'Advanture'),
(13, 'Biography');

-- --------------------------------------------------------

--
-- Table structure for table `genre_dtl`
--

CREATE TABLE `genre_dtl` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_dtl`
--

CREATE TABLE `movie_dtl` (
  `movie_id` int(11) NOT NULL,
  `Name` text NOT NULL,
  `releasedt` date DEFAULT NULL,
  `Provider` text NOT NULL,
  `language` text DEFAULT NULL,
  `agelimit` int(11) DEFAULT NULL,
  `subType` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `moviepath` text NOT NULL,
  `posterpath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_dtl`
--

CREATE TABLE `payment_dtl` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `pay_date` date NOT NULL,
  `pay_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_dtl`
--

CREATE TABLE `subscription_dtl` (
  `id` int(11) NOT NULL,
  `Name` text NOT NULL,
  `price` int(11) NOT NULL,
  `Duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_dtl`
--

INSERT INTO `subscription_dtl` (`id`, `Name`, `price`, `Duration`) VALUES
(1, 'standard', 199, 1),
(2, 'Prime', 999, 3),
(3, 'Elite', 1999, 12);

-- --------------------------------------------------------

--
-- Table structure for table `user_dtl`
--

CREATE TABLE `user_dtl` (
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `subscription` text NOT NULL DEFAULT 'free',
  `sub_type` int(11) DEFAULT NULL,
  `sub_date` date DEFAULT NULL,
  `sub_exp_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actor_dtl`
--
ALTER TABLE `actor_dtl`
  ADD PRIMARY KEY (`actor_id`);

--
-- Indexes for table `admin_dtl`
--
ALTER TABLE `admin_dtl`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cast_dtl`
--
ALTER TABLE `cast_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `genre_dtl`
--
ALTER TABLE `genre_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movie_dtl`
--
ALTER TABLE `movie_dtl`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `payment_dtl`
--
ALTER TABLE `payment_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_dtl`
--
ALTER TABLE `subscription_dtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_dtl`
--
ALTER TABLE `user_dtl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actor_dtl`
--
ALTER TABLE `actor_dtl`
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_dtl`
--
ALTER TABLE `admin_dtl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cast_dtl`
--
ALTER TABLE `cast_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `genre_dtl`
--
ALTER TABLE `genre_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movie_dtl`
--
ALTER TABLE `movie_dtl`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_dtl`
--
ALTER TABLE `payment_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_dtl`
--
ALTER TABLE `subscription_dtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_dtl`
--
ALTER TABLE `user_dtl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
