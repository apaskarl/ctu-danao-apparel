-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2025 at 09:37 AM
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
-- Database: `cebutechapparel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password_hash`, `firstname`, `lastname`, `created_at`) VALUES
(1, 'admin', '$2y$10$r9uMWZ7R7zrgAJo9h.8V9uxxpPZe7NZkASdSXu2G7yh8lZVDZaQuS', 'Karl', 'Apas', '2024-05-19 23:18:13'),
(4, 'aljon', '$2y$10$WN9Dx0eSQPMrIrOYodKKkuOxvhOiNzgIvzEw0vvkpt4gvUHg7j.F2', 'Aljon', 'Montecalvo', '2024-05-20 09:47:56'),
(7, 'admin', 'admin', '', '', '2024-09-20 16:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_cancelled`
--

CREATE TABLE `order_cancelled` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_cancelled_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_cancelled`
--

INSERT INTO `order_cancelled` (`order_id`, `user_id`, `product_img`, `product_id`, `size_id`, `color_id`, `quantity`, `price`, `subtotal`, `order_date`, `order_cancelled_date`) VALUES
(240, 1, 'assets/images/uploads/univshirt2.jpg', 72, 1, 2, 4, 200, 800, '2024-05-30 02:12:25', '2024-05-30 02:12:25'),
(241, 24, 'assets/images/uploads/univshirt2.jpg', 72, 1, 2, 9, 200, 1800, '2024-05-30 03:38:37', '2024-05-30 03:38:37'),
(242, 24, 'assets/images/uploads/univcap1.jpg', 77, 0, 0, 5, 130, 650, '2024-05-30 03:39:09', '2024-05-30 03:41:09'),
(242, 24, 'assets/images/uploads/univshirt2.jpg', 72, 1, 2, 5, 200, 1000, '2024-05-30 03:39:09', '2024-05-30 03:41:09'),
(247, 1, 'assets/images/uploads/univshirt1.jpg', 74, 1, 3, 4, 200, 800, '2024-10-09 12:16:56', '2024-10-09 12:16:56'),
(248, 1, 'assets/images/uploads/cotspartan.jpg', 75, 2, 1, 6, 250, 1500, '2024-10-24 04:37:41', '2024-10-24 04:37:41'),
(249, 1, 'assets/images/uploads/univshirt2.jpg', 72, 2, 2, 2, 200, 400, '2024-11-10 23:50:28', '2024-11-10 23:50:28'),
(250, 1, 'assets/images/uploads/univshirt1.jpg', 74, 2, 3, 2, 200, 400, '2024-11-16 03:15:11', '2024-11-16 03:15:11'),
(253, 1, 'assets/images/uploads/cotspartan.jpg', 75, 2, 1, 3, 250, 750, '2025-02-03 17:57:24', '2025-02-03 17:57:24'),
(253, 1, 'assets/images/uploads/univshirt1.jpg', 74, 2, 3, 4, 200, 800, '2025-02-03 17:57:24', '2025-02-03 17:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `order_checkout`
--

CREATE TABLE `order_checkout` (
  `user_id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_completed`
--

CREATE TABLE `order_completed` (
  `order_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `subtotal` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_completed`
--

INSERT INTO `order_completed` (`order_id`, `user_id`, `product_img`, `product_id`, `size_id`, `color_id`, `quantity`, `price`, `subtotal`, `order_date`, `delivery_date`) VALUES
(243, 24, 'assets/images/uploads/univshirt1.jpg', 74, 2, 3, 1, 200, 200, '2024-05-30 03:40:24', '2024-05-30 03:42:05'),
(246, 1, 'assets/images/uploads/univshirt2.jpg', 72, 1, 2, 7, 200, 1400, '2024-10-09 12:14:35', '2024-10-09 12:16:49'),
(244, 24, 'assets/images/uploads/univshirt2.jpg', 72, 1, 2, 1, 200, 200, '2024-05-30 04:17:57', '2024-11-10 19:59:38');

-- --------------------------------------------------------

--
-- Table structure for table `order_data`
--

CREATE TABLE `order_data` (
  `order_id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `subtotal` int(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_data`
--

INSERT INTO `order_data` (`order_id`, `user_id`, `product_img`, `product_id`, `size_id`, `color_id`, `quantity`, `price`, `subtotal`, `order_date`) VALUES
(252, 1, 'assets/images/uploads/univshirt2.jpg', 72, 2, 2, 5, 200, 1000, '2024-11-17 22:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `order_id_number`
--

CREATE TABLE `order_id_number` (
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_id_number`
--

INSERT INTO `order_id_number` (`order_id`) VALUES
(1),
(189),
(190),
(191),
(192),
(193),
(194),
(195),
(196),
(197),
(198),
(215),
(216),
(217),
(220),
(221),
(222),
(223),
(224),
(225),
(226),
(227),
(228),
(229),
(230),
(231),
(232),
(233),
(234),
(235),
(236),
(237),
(238),
(239),
(240),
(241),
(242),
(243),
(244),
(245),
(246),
(247),
(248),
(249),
(250),
(251),
(252),
(253);

-- --------------------------------------------------------

--
-- Table structure for table `order_processing`
--

CREATE TABLE `order_processing` (
  `order_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `subtotal` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_receive`
--

CREATE TABLE `order_receive` (
  `order_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `size_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` int(255) NOT NULL,
  `subtotal` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_receive`
--

INSERT INTO `order_receive` (`order_id`, `user_id`, `product_img`, `product_id`, `size_id`, `color_id`, `quantity`, `price`, `subtotal`, `order_date`) VALUES
(245, 24, 'assets/images/uploads/univshirt2.jpg', 72, 1, 2, 4, 200, 800, '2024-05-30 04:26:30'),
(251, 1, 'assets/images/uploads/univshirt2.jpg', 72, 2, 3, 10, 200, 2000, '2024-11-13 23:39:10'),
(251, 1, 'assets/images/uploads/univshirt2.jpg', 72, 2, 2, 1, 200, 200, '2024-11-13 23:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_img1` varchar(255) DEFAULT NULL,
  `product_img2` varchar(255) NOT NULL,
  `product_img3` varchar(255) NOT NULL,
  `product_img4` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `category_id`, `description`, `price`, `created_at`) VALUES
(72, 'Technologist Shirt', '../../assets/images/uploads/univshirt2.jpg', '../../assets/images/uploads/univshirt2(3).jpg', '../../assets/images/uploads/univshirt2(2).jpg', '', 1, 'asdasd', 200, '2024-05-20 10:33:31'),
(74, 'Cebu Tech University Shirt', '../../assets/images/uploads/univshirt1.jpg', '../../assets/images/uploads/univshirt1(2).jpg', '../../assets/images/uploads/univshirt1(3).jpg', '../../assets/images/uploads/univshirt1(4).jpg', 1, 'asdas', 200, '2024-05-24 02:25:11'),
(75, 'COT Spartan Shirt', '../../assets/images/uploads/cotspartan.jpg', '../../assets/images/uploads/cotspartan(2).jpg', '', '', 2, 'asdasd', 250, '2024-05-24 02:25:43'),
(76, 'CEAS Knights Shirt', '../../assets/images/uploads/ceasknight.jpg', '../../assets/images/uploads/ceasknight(2).jpg', '', '', 2, 'asd', 250, '2024-05-24 02:26:08'),
(77, 'CTU University Cap ', '../../assets/images/uploads/univcap1.jpg', '', '', '', 3, 'asdasd', 130, '2024-05-24 02:26:53'),
(79, 'Premier Shirt 1', '../../assets/images/uploads/univshirt5.jpg', '../../assets/images/uploads/univshirt5(3).jpg', '../../assets/images/uploads/univshirt5(2).jpg', '', 1, 'asd', 200, '2024-05-24 02:28:15'),
(86, 'COE Samurai Shirt', '../../assets/images/uploads/coesamurai.jpg', '../../assets/images/uploads/coesamurai(2).jpg', '', '', 2, 'erwerwrwr', 250, '2024-05-29 20:21:45'),
(87, 'CME Vikings Shirt', '../../assets/images/uploads/cmeviking.jpg', '../../assets/images/uploads/cmeviking(2).jpg', '', '', 2, 'asdasd', 250, '2024-05-30 10:02:15'),
(88, 'CTU Premier Cap', '../../assets/images/uploads/univcap2.jpg', '', '', '', 3, 'asdasd', 130, '2024-05-30 11:13:02'),
(89, 'CTU Tote Bag', '../../assets/images/uploads/totebag1.jpg', '', '', '', 3, 'asdasd', 150, '2024-05-30 11:13:32'),
(90, 'CTU DANAO BLACK SHIRT', '../../assets/images/uploads/univshirt4.jpg', '../../assets/images/uploads/univshirt4(3).jpg', '', '', 1, 'yutfyutfyt', 200, '2024-05-30 11:43:57'),
(91, 'asdasd', '../../assets/images/uploads/pos.png', '', '', '', 3, 'asdas', 200, '2024-10-09 20:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `product_accessories`
--

CREATE TABLE `product_accessories` (
  `accessory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_accessories`
--

INSERT INTO `product_accessories` (`accessory_id`, `product_id`, `quantity`) VALUES
(16, 77, 100),
(18, 88, 100),
(19, 89, 50);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(11) NOT NULL,
  `main_category` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category_id`, `main_category`, `category`) VALUES
(1, '', 'University Shirt'),
(2, '', 'Intramural Shirt'),
(3, '', 'Accessories'),
(4, '', 'COT'),
(5, '', 'CEAS'),
(6, '', 'CME'),
(7, '', 'COE');

-- --------------------------------------------------------

--
-- Table structure for table `product_color`
--

CREATE TABLE `product_color` (
  `color_id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_color`
--

INSERT INTO `product_color` (`color_id`, `color`) VALUES
(0, ''),
(1, 'Yellow'),
(2, 'Black'),
(3, 'White'),
(4, 'Blue'),
(6, 'Orange'),
(7, 'Green');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `size_id` int(11) NOT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`size_id`, `size`) VALUES
(0, ''),
(1, 'Small'),
(2, 'Medium'),
(3, 'Large'),
(4, 'Extra Large'),
(5, 'XXL'),
(12, 'XXXL');

-- --------------------------------------------------------

--
-- Table structure for table `product_variant`
--

CREATE TABLE `product_variant` (
  `variant_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variant`
--

INSERT INTO `product_variant` (`variant_id`, `product_id`, `color_id`, `size_id`, `quantity`) VALUES
(49, 72, 2, 1, 4),
(50, 72, 2, 2, 29),
(51, 72, 3, 3, 44),
(52, 74, 3, 1, 47),
(55, 72, 3, 2, 0),
(56, 86, 3, 1, 500),
(57, 75, 1, 1, 50),
(58, 75, 1, 2, 50),
(59, 75, 1, 3, 50),
(60, 76, 4, 1, 50),
(61, 76, 4, 2, 50),
(62, 76, 4, 3, 50),
(63, 79, 3, 1, 70),
(64, 79, 3, 2, 50),
(65, 79, 3, 3, 100),
(66, 79, 2, 3, 70),
(67, 79, 2, 2, 50),
(68, 87, 7, 1, 35),
(69, 87, 7, 2, 50),
(70, 87, 7, 3, 100),
(71, 74, 3, 2, 49),
(72, 74, 3, 3, 50),
(73, 74, 2, 1, 50),
(74, 74, 2, 2, 12),
(75, 90, 2, 1, 105),
(76, 90, 2, 2, 1000),
(77, 90, 2, 12, 90);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `email`, `phone`, `password_hash`, `profile_pic`, `username`, `gender`, `created_at`) VALUES
(1, 'Karl', 'Apas', 'jameskarlapas@gmail.com', 9085275762, '$2y$10$EuJBYatmzYz0VjawaULC2uIQelZDFK/lMg1HJ54OI374rrzQC5J/O', 'assets/images/users/userpics/1.jpg', 'karlapas', '', '2024-05-01 19:14:09'),
(12, 'Jason', 'Morre', 'jasonmorre@gmail.com', 0, '$2y$10$XX72JG/eoFGWY7Np.gwSreHOr8NtkalbXY0gSk1/OMtj6D3H6AEsS', 'assets/images/users/userpics/a.jpg', 'jasonmorre', '', '2024-05-01 19:14:09'),
(15, 'Aljon', 'Montecalvo', 'aljon.montecalvo08@gmail.com', 0, '$2y$10$oub0JXcNpRfmi8OjMbJ3Pu/tVkCs9kiMlwKYoF8SgXiALVNpMcECS', 'assets/images/users/userpics/default_pfp.jpg', 'aljonmontecalvo', '', '2024-05-07 07:31:30'),
(16, 'Francie', 'Sioco', 'franciesioco@gmail.com', 0, '$2y$10$KKPDizNOA6gvsdRHxEI0sOgZ6vfDyADszs9zAqIZXdmbjrxpKfLzO', 'assets/images/users/userpics/default_pfp.jpg', 'Francie', '', '2024-05-13 21:11:35'),
(17, 'Stewart', 'Balingcasag ', 'stewartb.1218@gmail.com', 0, '$2y$10$1i3VPhh9prjpxrCD9uI74.4FQiXE5qOUqK/gh/myZHeJfAZGmL5j2', 'assets/images/users/userpics/received_1625510634889913.jpeg', 'Brah@gmail.com', '', '2024-05-23 08:51:44'),
(18, 'Herjun', 'Opaw', 'Herjunpawiks@gmail.com', 0, '$2y$10$rcWsDkN4nLHd5LQmd1.lauuWls/mLVmSZwb9v0kV1YY37DX0zGCLO', 'assets/images/users/userpics/received_1601264200638075.jpeg', 'Herjun', '', '2024-05-23 09:47:11'),
(19, 'Cole', 'Uyan', 'coleuyan55@gmail.com', 0, '$2y$10$84I36lMGLP3AwMGWSW2Coe2ICEn1c2BsaHcUJpE0.BjLI4UGq/FLK', 'assets/images/users/userpics/default_pfp.jpg', 'koljabs', '', '2024-05-23 12:32:12'),
(20, 'Yoyo', 'Gwapo', 'Yoyo@gmail.com', 0, '$2y$10$m9IszzyrGztMzmpWb8nJQuAgEtOrlvLrOHCsiatcIcUNoOZ8HvEau', 'assets/images/users/userpics/1713435049108.jpg', 'Yoyo', '', '2024-05-23 12:49:59'),
(21, 'Em', 'jay', 'asdfghj@gmail.com', 0, '$2y$10$Qzukt37e8qeB9q9LmQ90h.vDzhKkO/5eMdnBoWsKA33f1XYRducM6', 'assets/images/users/userpics/default_pfp.jpg', 'Emjay', '', '2024-05-25 23:41:04'),
(22, 'jibi', 'amat', 'jibiamat12@gmail.com', 0, '$2y$10$HVXN8/USWz0ac3D8MnJEKO.tgRd3mu5p4bJt9V69zQNLqQYbl7bNm', 'assets/images/users/userpics/default_pfp.jpg', 'chessman', '', '2024-05-29 15:51:02'),
(23, 'jibi', 'mata', 'jibimata21@gmail.com', 0, '$2y$10$oYcmFaPXKTcND/boWEPKKuxZ1SlLXiOnCma6AeeOcfmN79WIYZFRW', 'assets/images/users/userpics/default_pfp.jpg', 'janralai', '', '2024-05-29 19:18:05'),
(24, 'Jason', 'Morre', 'jasongwapo@gmail.com', 0, '$2y$10$E2jaeHtuhbinQ7j0wc6ZXOQRcv4e3MW2I83QVY9EeF6pyP5fm.jL.', 'assets/images/users/userpics/24.jpeg', 'jason', '', '2024-05-30 11:31:16'),
(25, 'James', 'Karl', 'jameskarl@gmail.com', 0, '$2y$10$p7lZ6GfhndzwRlik1rjAhOxfohh8j/76S9/iqF8zqC0v/RPrlPjVi', 'assets/images/users/userpics/25.jpg', 'karlapas123', '', '2024-09-13 01:00:17'),
(26, 'James', 'Karl', 'apasjameskarl@gmail.com', 0, '$2y$10$iaTPEpyUIlUP5gqtZuNZ3uzveN16o2WcBSbmsnHZS8hTseQORxOOi', 'assets/images/users/userpics/default_pfp.jpg', 'krlapas', '', '2024-09-18 13:41:01'),
(27, 'Gwenneth', 'Apas', 'gwen@gmail.com', 0, '$2y$10$0NtwMChuG2hWDIGMk25o0ey3P1VBkY.YERkMtmZeKYwPyqxCERoae', 'assets/images/users/userpics/27.png', 'gwenapas', '', '2024-10-09 20:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `UserID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_cart`
--

CREATE TABLE `user_cart` (
  `user_id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `stock` int(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`) VALUES
(19, 23, 72),
(20, 23, 74),
(28, 24, 72),
(29, 24, 75);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `order_data`
--
ALTER TABLE `order_data`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_id_number`
--
ALTER TABLE `order_id_number`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_accessories`
--
ALTER TABLE `product_accessories`
  ADD PRIMARY KEY (`accessory_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `product_variant`
--
ALTER TABLE `product_variant`
  ADD PRIMARY KEY (`variant_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `user_cart`
--
ALTER TABLE `user_cart`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_img` (`product_img`),
  ADD KEY `product_name` (`product_name`),
  ADD KEY `size` (`size`),
  ADD KEY `color` (`color`),
  ADD KEY `price` (`price`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_id_number`
--
ALTER TABLE `order_id_number`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `product_accessories`
--
ALTER TABLE `product_accessories`
  MODIFY `accessory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_color`
--
ALTER TABLE `product_color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_variant`
--
ALTER TABLE `product_variant`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`category_id`);

--
-- Constraints for table `product_variant`
--
ALTER TABLE `product_variant`
  ADD CONSTRAINT `product_variant_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `product_variant_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `product_color` (`color_id`),
  ADD CONSTRAINT `product_variant_ibfk_3` FOREIGN KEY (`size_id`) REFERENCES `product_size` (`size_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
