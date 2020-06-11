-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2019 at 12:06 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tkphoto_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profile`
--

CREATE TABLE `admin_profile` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_profile`
--

INSERT INTO `admin_profile` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(1, 'Kuhle', 'Hanisi', 'kay@gmail.com', '$2y$10$dtsqOJa9949AjebuGsPZwOHXX0HcaV2Ey2bZGlVcY5PZkC/2UNdOi', '2019-03-30 23:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `codename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `codename`) VALUES
(1, 'Singles', 'singles'),
(2, 'Groups', 'groups'),
(3, 'Weddings', 'weddings'),
(4, 'Birthdays', 'birthdays'),
(5, 'Swimwear', 'swimwear'),
(6, 'Sports', 'sports'),
(7, 'Branding', 'branding'),
(8, 'Baby Showers', 'babyshowers'),
(9, 'Graduation', 'graduation'),
(10, 'Events', 'events');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image_title` varchar(200) NOT NULL,
  `image_url` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `category_id`, `image_title`, `image_url`, `created_at`) VALUES
(12, 1, 'Testing 9', 'singles__1516491585__94a23310b474a00c50f7c459bfb45545.jpg', '2019-03-30 22:39:45'),
(13, 6, 'Testing 10', 'sports__1553298044__25337ac6990292e92a8095ecb736cb60.jpg', '2019-03-30 22:40:44'),
(20, 8, 'baby shower', 'babyshowers__1510396109__4ae3dc7475250ee8ab3fd0cfdf6845ca.jpg', '2019-03-31 09:28:29'),
(21, 4, 'birthday', 'birthdays__1512815359__45e4075ccbf114cd60eea402af754dd6.jpg', '2019-03-31 09:29:20'),
(22, 7, 'branding', 'branding__1486895400__1d53dfb06acb76fec137c13e4cc90df2.jpg', '2019-03-31 09:30:00'),
(23, 10, 'event', 'events__1486290638__faa547a31a1f40825d31e322a9a30a7a.jpg', '2019-03-31 09:30:38'),
(24, 9, 'graduation', 'graduation__1505467889__9e0d323c3d4899d9fa61af59f6b426d2.jpg', '2019-03-31 09:31:29'),
(25, 2, 'group', 'groups__1509877934__787893d8191e8993f082063ac8e30b5e.jpg', '2019-03-31 09:32:14'),
(26, 5, 'swimming', 'swimwear__1509791574__5cc7daea4bf763502424516a6ee88771.jpg', '2019-03-31 09:32:54'),
(27, 3, 'wedding', 'weddings__1512210812__6822821f0e1435fb03a6e556d816a0a0.jpg', '2019-03-31 09:33:33');

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `url` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`id`, `title`, `url`, `created_at`) VALUES
(7, 'Doc Test 1', '1554023869_c4ca4238a0b923820dcc509a6f75849b.jpg', '2019-03-31 09:17:49'),
(10, 'test 4', '1554023947_c81e728d9d4c2f636f067f89cc14862c.jpg', '2019-03-31 09:19:08'),
(11, 'test 5', '1554023966_eccbc87e4b5ce2fe28308fd9f2a7baf3.jpg', '2019-03-31 09:19:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_profile`
--
ALTER TABLE `admin_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_profile`
--
ALTER TABLE `admin_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
