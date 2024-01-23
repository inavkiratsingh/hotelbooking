-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2024 at 09:18 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hbwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `srno` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`srno`, `admin_name`, `admin_pass`) VALUES
(1, 'navkirat', '12345678');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(300) NOT NULL,
  `price` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`sr_no`, `booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phone`, `address`) VALUES
(11, 11, 'Simple Room', 1500, 3000, NULL, 'Navkirat singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(12, 12, 'Simple Room', 1500, 3000, NULL, 'Navkirat singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(13, 13, 'Family Room', 1999, 29985, '45', 'Navkirat singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(14, 14, 'Family Room', 1999, 7996, NULL, 'Navkirat singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(15, 15, 'Simple Room', 1500, 55500, NULL, 'Navkirat singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(16, 16, 'Family Room', 1999, 37981, 'a6', 'Navkirat singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(17, 17, 'Family Room', 1999, 3998, NULL, 'Navkirat singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(18, 18, 'Delux Room', 5999, 47992, '123', 'Navkirat Singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(19, 19, 'Delux Room', 5999, 59990, '67', 'Navkirat Singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(20, 20, 'Simple Room', 1500, 4500, '45', 'Navkirat Singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(21, 21, 'Supreme Delux Room', 9999, 69993, '9', 'Navkirat Singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(22, 22, 'Supreme Delux Room', 9999, 29997, '52', 'Navkirat Singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR'),
(23, 23, 'Delux Room', 5999, 65989, '0', 'Navkirat Singh', '09888441941', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR');

-- --------------------------------------------------------

--
-- Table structure for table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` int(11) NOT NULL DEFAULT 0,
  `refund` int(11) DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'pending',
  `order_id` varchar(150) NOT NULL,
  `trans_id` varchar(200) DEFAULT NULL,
  `trans_amt` int(11) NOT NULL,
  `trans_status` varchar(100) NOT NULL DEFAULT 'pending',
  `trans_resp_msg` varchar(200) DEFAULT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp(),
  `rate_review` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `trans_id`, `trans_amt`, `trans_status`, `trans_resp_msg`, `datentime`, `rate_review`) VALUES
(11, 4, 9, '2024-01-25', '2024-01-27', 0, NULL, 'pending', 'ORD_475612', NULL, 0, 'pending', NULL, '2024-01-02 15:49:01', NULL),
(12, 4, 9, '2024-01-25', '2024-01-27', 0, NULL, 'pending', 'order_NJi2QAPHpoP8cs', NULL, 0, 'pending', NULL, '2024-01-02 15:52:22', NULL),
(13, 4, 10, '2024-01-02', '2024-01-17', 1, NULL, 'booked', 'order_NJiEpQXYOWdL5d', 'order_NJiEpQXYOWdL5d', 2998500, 'DONE', NULL, '2023-11-08 16:04:06', 1),
(14, 4, 10, '2024-01-23', '2024-01-27', 0, 1, 'cancelled', 'order_NJk0ciYlqu1A2X', 'order_NJk0ciYlqu1A2X', 7996, 'DONE', NULL, '2024-01-02 17:48:03', NULL),
(15, 4, 9, '2024-01-02', '2024-02-08', 1, NULL, 'booked', 'order_NJkMn8x1K7uBws', 'order_NJkMn8x1K7uBws', 55500, 'DONE', NULL, '2024-01-02 18:09:02', 1),
(16, 4, 10, '2024-01-23', '2024-02-11', 1, NULL, 'booked', 'order_NJkNjiGBr0Xqw0', 'order_NJkNjiGBr0Xqw0', 37981, 'DONE', NULL, '2023-07-11 18:09:56', 1),
(17, 4, 10, '2024-01-16', '2024-01-18', 0, 0, 'cancelled', 'order_NKCwR09zrIXCBD', 'order_NKCwR09zrIXCBD', 3998, 'DONE', NULL, '2024-01-03 22:06:12', NULL),
(18, 4, 11, '2024-01-05', '2024-01-13', 1, NULL, 'booked', 'order_NKPvAFGK6ktXuH', 'order_NKPvAFGK6ktXuH', 47992, 'DONE', NULL, '2023-08-17 10:48:00', 1),
(19, 4, 11, '2024-01-15', '2024-01-25', 1, NULL, 'booked', 'order_NKPvp80Rkp8hC1', 'order_NKPvp80Rkp8hC1', 59990, 'DONE', NULL, '2024-01-04 10:48:38', 1),
(20, 4, 9, '2024-01-08', '2024-01-11', 1, NULL, 'booked', 'order_NKWetJAvgy6Xwl', 'order_NKWetJAvgy6Xwl', 4500, 'DONE', NULL, '2024-01-04 17:23:27', 1),
(21, 4, 12, '2024-01-05', '2024-01-12', 1, NULL, 'booked', 'order_NKzpM4wKzkNhVw', 'order_NKzpM4wKzkNhVw', 69993, 'DONE', NULL, '2024-01-05 21:55:29', 1),
(22, 4, 12, '2024-01-31', '2024-02-03', 1, NULL, 'booked', 'order_NMuSC0rbkWrjqQ', 'order_NMuSC0rbkWrjqQ', 29997, 'DONE', NULL, '2024-01-10 17:58:05', 0),
(23, 4, 11, '2024-01-20', '2024-01-31', 1, NULL, 'booked', 'order_NQOqEnG4rUBc5H', 'order_NQOqEnG4rUBc5H', 65989, 'DONE', NULL, '2024-01-19 13:38:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `srno` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`srno`, `image`) VALUES
(7, 'IMG_809.png'),
(8, 'IMG_881.png'),
(9, 'IMG_483.png'),
(10, 'IMG_950.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `srno` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gmap` varchar(255) NOT NULL,
  `pn1` varchar(255) NOT NULL,
  `pn2` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fb` varchar(255) NOT NULL,
  `insta` varchar(255) NOT NULL,
  `tw` varchar(255) NOT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`srno`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, ' XYZ, Amritssar, Punjab', 'https://www.google.com/maps/place/Amritsar,+Punjab/@31.633544,74.87012,11z/data=!4m6!3m5!1s0x391964aa569e7355:0xeea2605bee84ef7d!8m2!3d31.6339793!4d74.8722642!16zL20vMDI5a3B5?hl=en&entry=ttu', '917986152243', '917986152243', 'navs6164gmail.com', 'facebook', 'instagram.com/inavkirat10', 'twitter', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d217408.71615317414!2d74.87012!3d31.633544000000004!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391964aa569e7355%3A0xeea2605bee84ef7d!2sAmritsar%2C%20Punjab!5e0!3m2!1sen!2sin!4v1702399803200!5m2!1sen!2sin');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(6, 'IMG_184.svg', 'AC', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum consequuntur placeat necessitatibus recusandae voluptates minus et!'),
(8, 'IMG_688.svg', 'Body massage', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum consequuntur placeat necessitatibus recusandae voluptates minus et!'),
(11, 'IMG_432.svg', 'Room Heater', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum consequuntur placeat necessitatibus recusandae voluptates minus et!');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(10, 'Bathroom'),
(11, 'Kitchen'),
(12, 'Balcony'),
(13, 'Swimming pool');

-- --------------------------------------------------------

--
-- Table structure for table `rating_review`
--

CREATE TABLE `rating_review` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(200) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_review`
--

INSERT INTO `rating_review` (`sr_no`, `booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `datentime`) VALUES
(2, 20, 9, 4, 5, '1Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, ex officiis distinctio, sapiente aspernatur voluptatum sunt nulla doloribus iure numquam nesciunt, delectus dolores. Temporibus ', 1, '2024-01-04 17:25:08'),
(4, 16, 10, 4, 4, '3Lorem im dolor sit amet consectetur adipisicing elit. Laboriosam, ex officiis distinctio, sapiente aspernatur voluptatum sunt nulla doloribus iure numquam nesciunt, delectus dolores. Temporibus quo', 1, '2024-01-04 17:25:23'),
(5, 15, 9, 4, 5, '4em ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, ex officiis distinctio, sapiente aspernatur voluptatum sunt nulla doloribus iure numquam nesciunt, delectus dolores. Temporibus quo', 1, '2024-01-04 17:25:33'),
(6, 13, 10, 4, 2, '5rem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, ex officiis distinctio, sapiente aspernatur voluptatum sunt nulla doloribus iure numquam nesciunt, delectus dolores. Temporibus quo', 1, '2024-01-04 17:25:42'),
(7, 21, 12, 4, 4, 'VERY NICE', 1, '2024-01-05 21:57:17'),
(8, 23, 11, 4, 5, 'navkirat', 0, '2024-01-19 13:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(350) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(9, 'Simple Room', 200, 1500, 20, 2, 1, 'Simple Room', 1, 0),
(10, 'Family Room', 300, 1999, 10, 2, 2, 'Family Room', 1, 0),
(11, 'Delux Room', 500, 5999, 2, 4, 2, 'Delux Room', 1, 0),
(12, 'Supreme Delux Room', 300, 9999, 1, 2, 1, 'Related Keywords: Electric Heater, Radiator, Room, Warm Water, Heater, Heating, Hot, System, Temperature, Weather, Winter, Interior, Real, Symbol, Icon, Icons', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `srno` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`srno`, `room_id`, `facilities_id`) VALUES
(34, 11, 6),
(35, 11, 8),
(40, 10, 6),
(41, 10, 8),
(42, 12, 6),
(43, 12, 8),
(44, 12, 11),
(45, 9, 6),
(46, 9, 8);

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `srno` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`srno`, `room_id`, `features_id`) VALUES
(19, 11, 10),
(20, 11, 11),
(25, 10, 10),
(26, 10, 11),
(27, 10, 12),
(28, 12, 10),
(29, 12, 11),
(30, 12, 12),
(31, 12, 13),
(32, 9, 10),
(33, 9, 11),
(34, 9, 12);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `srno` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`srno`, `room_id`, `image`, `thumb`) VALUES
(15, 9, 'IMG_265.png', 0),
(16, 9, 'IMG_776.jpg', 1),
(17, 10, 'IMG_194.png', 0),
(18, 10, 'IMG_464.png', 1),
(19, 11, 'IMG_989.png', 0),
(20, 11, 'IMG_268.png', 0),
(21, 11, 'IMG_125.png', 1),
(22, 10, 'IMG_384.png', 0),
(23, 9, 'IMG_925.png', 0),
(24, 12, 'IMG_575.png', 1),
(25, 12, 'IMG_254.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `srno` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(250) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`srno`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'NS Hotel', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam, ex officiis distinctio,\n                sapiente aspernatur voluptatum sunt nulla doloribus iure numquam nesciunt, delectus dolores.\n                Temporibus quos modi repellendus', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `srno` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_details`
--

INSERT INTO `team_details` (`srno`, `name`, `picture`) VALUES
(9, 'Navkirat', 'IMG_381.jpg'),
(10, 'Japneet', 'IMG_164.png'),
(11, 'Japneet', 'IMG_335.png'),
(12, 'Paras', 'IMG_116.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_cred`
--

CREATE TABLE `user_cred` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(120) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `profile` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `t_expire` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `dateandtime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cred`
--

INSERT INTO `user_cred` (`id`, `name`, `email`, `address`, `pincode`, `phone`, `dob`, `profile`, `password`, `is_verified`, `token`, `t_expire`, `status`, `dateandtime`) VALUES
(4, 'Navkirat Singh', 'navs6164@gmail.com', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR', '143001', '09888441941', '2004-03-10', 'IMG_188.jpeg', '$2y$10$sV4LuyDrkyThB/lH9mlI.ezWgSkYI/YniIKh3J4Emv2gUa.Kcdwje', 1, NULL, NULL, 1, '2023-12-27 18:30:00'),
(6, 'Japneet', 'japneetk2693@gmail.com', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR', '143001', '07986152243', '2024-01-10', 'IMG_323.jpeg', '$2y$10$/ycwHc83xwZa6pOdVFu5LOa2iAfz.HgwYfYqiBRmDDPyEa0M/ws16', 0, '7446fadfc199b5ef2c487c3e011776cb', NULL, 1, '2024-01-05 16:32:46'),
(7, 'Navkirat singh', 'navkiratsingh5823@gmail.com', 'H NO L-6/2208,GALI NO2,SHAHEED UDHAM SINGH NAGAR', '143001', '09888441', '2024-01-15', 'IMG_343.jpeg', '$2y$10$vxGx87lf1leAUsDA7FJWPeDfOnLBitz1SnfnS/mnQz3I6TcdJQTa.', 1, '58feaa8f0947cc0482a79ad55c475c80', NULL, 0, '2024-01-05 16:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `srno` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`srno`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `facilities id` (`facilities_id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`srno`),
  ADD KEY `features id` (`features_id`),
  ADD KEY `room id` (`room_id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`srno`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`srno`);

--
-- Indexes for table `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`srno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `srno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

--
-- Constraints for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD CONSTRAINT `rating_review_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`),
  ADD CONSTRAINT `rating_review_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `rating_review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`);

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
