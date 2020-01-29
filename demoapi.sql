-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2020 at 08:02 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demoapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE `blog_post` (
  `id` int(11) NOT NULL,
  `user_id` int(250) NOT NULL,
  `post_title` varchar(250) NOT NULL,
  `post_description` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_post`
--

INSERT INTO `blog_post` (`id`, `user_id`, `post_title`, `post_description`, `created_at`, `updated_at`) VALUES
(1, 7, 'Demo post 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing updated.', '2020-01-25 01:33:37', '2020-01-25 05:58:43'),
(3, 7, 'Demo post update', 'Lorem ipsum dolor sit amet, consectetur adipiscing updated.', '2020-01-25 11:06:32', '2020-01-25 05:58:02'),
(4, 2, 'Demo post update', 'Lorem ipsum dolor sit amet, consectetur adipiscing updated.', '2020-01-25 11:34:43', '2020-01-25 06:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `post_image`
--

CREATE TABLE `post_image` (
  `id` int(255) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_image`
--

INSERT INTO `post_image` (`id`, `post_title`, `post_content`, `image`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'demo title', 'this is the demo content', '1580323716pexels-photo-1661470.jpeg', 3, '2020-01-30 00:18:36', '2020-01-29 18:48:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passsword` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `device_token` varchar(200) NOT NULL,
  `device_type` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `passsword`, `address`, `country`, `city`, `pincode`, `mobile`, `device_token`, `device_type`, `created_at`) VALUES
(1, 'Gajendara', 'Mehrah', 'gajendara@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Utrakhand', 'India', 'Dehradun', '140603', '987458210', 'DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B488gSDERHYTNLOJHGRD', 'ios', '2019-10-06 17:45:14'),
(2, 'Muzaffer', 'Khan', 'developer1994@gmail.com', '73aeb2311935a9e2f932f478d6e46079', 'Chandigarh', 'India', 'Chandigreh', '145103', '9874568924', 'DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B488gSDERHYTNLOJHGRD', 'ios', '2019-10-06 17:49:19'),
(3, 'Lovepreet', 'singh', 'trendysector17@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Sydney', 'Australia', 'Opera', '145103', '9876543210', 'DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B48HTYRTFG', 'ios', '2019-10-06 17:52:53'),
(4, 'Vijay', 'singh', 'airtel@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'mohali', 'India', 'mohali', '140603', '987458210', 'DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B488gSDERHYTNLOJHGRD', 'ios', '2019-10-06 17:55:22'),
(7, 'shazidh', 'khan', 'skkhan@yopmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'katihar', 'India', 'choni', '854326', '987458210', 'DUMMY622684085DACD21EBC84DUMMYF4FBE5212FDCF1E2B488gSDERHYTNLOJHGRD', 'ios', '2020-01-24 18:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `users_authentication`
--

CREATE TABLE `users_authentication` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `token` varchar(350) NOT NULL,
  `expired_at` varchar(250) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_authentication`
--

INSERT INTO `users_authentication` (`id`, `users_id`, `token`, `expired_at`, `updated_at`) VALUES
(1, 1, '4LO1B#EGNZEY9NIDE2P32KMCQ', '2019-10-07 04:15:14', '2019-10-06 17:45:14'),
(2, 2, '', '2020-01-30 07:48:35', '2020-01-29 14:18:35'),
(3, 3, 'WJ2FI#@X#FIMHABD9HL4PZ712', '2019-10-07 04:22:53', '2019-10-06 17:52:53'),
(4, 4, '5E6H1CS@0533BA4LNITPDIEXL', '2019-10-07 04:25:22', '2019-10-06 17:55:22'),
(5, 7, '', '2020-01-25 20:20:25', '2020-01-25 02:50:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_image`
--
ALTER TABLE `post_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_authentication`
--
ALTER TABLE `users_authentication`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post_image`
--
ALTER TABLE `post_image`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_authentication`
--
ALTER TABLE `users_authentication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
