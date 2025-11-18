-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2025 at 02:59 AM
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
-- Database: `shoe_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `variant_id`, `quantity`, `created_at`, `updated_at`) VALUES
(131, 7, 8, 3, '2025-11-16 06:12:09', '2025-11-16 06:15:02'),
(132, 7, 19, 5, '2025-11-16 06:25:16', '2025-11-16 06:25:19'),
(135, 1, 9, 2, '2025-11-16 16:14:21', '2025-11-16 16:31:47'),
(136, 1, 19, 6, '2025-11-16 16:27:21', '2025-11-16 16:31:52'),
(137, 1, 2, 2, '2025-11-16 16:29:59', '2025-11-16 16:30:04'),
(139, 1, 20, 1, '2025-11-16 16:32:01', '2025-11-16 16:32:01');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','hide') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`) VALUES
(3, 'sneaker', 'active', '2025-10-25 14:57:06'),
(10, 'adedas', 'active', '2025-10-26 15:07:42'),
(12, 'frence', 'active', '2025-11-02 04:52:40'),
(36, 'test account 1', 'active', '2025-11-15 08:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('COD','BANKING') NOT NULL DEFAULT 'COD',
  `status` enum('shipping','pending','confirmed','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shipping_address`, `total_amount`, `payment_method`, `status`, `created_at`) VALUES
(1, 2, 'Hà Nội, Việt Nam', 2500000.00, 'COD', 'cancelled', '2025-10-25 14:57:06'),
(12, 1, 'Bắc từ liêm, hà nội', 413847.00, 'COD', 'pending', '2025-11-01 15:40:42'),
(13, 1, 'Bắc từ liêm, hà nội', 12098000.00, 'COD', 'shipped', '2025-11-02 05:41:11'),
(15, 7, 'ad1', 97233.00, 'COD', 'confirmed', '2025-11-02 11:42:42'),
(16, 1, 'Bắc từ liêm, hà nội', 123412.00, 'COD', 'pending', '2025-11-02 13:39:29'),
(17, 1, 'Bắc từ liêm, hà nội', 1234000.00, 'COD', 'pending', '2025-11-02 14:40:02'),
(18, 7, 'ad1', 1480912.00, 'COD', 'shipping', '2025-11-09 08:56:41'),
(19, 1, 'Bắc từ liêm, hà nội', 3670714.00, 'COD', 'cancelled', '2025-11-11 15:16:07'),
(20, 1, 'Bắc từ liêm, hà nội', 97233.00, 'COD', 'pending', '2025-11-12 00:43:08'),
(21, 1, 'Bắc từ liêm, hà nội', 123456.00, 'COD', 'pending', '2025-11-12 06:47:57'),
(22, 1, 'Bắc từ liêm, hà nội', 123456.00, 'COD', 'pending', '2025-11-12 06:52:08'),
(23, 1, 'Bắc từ liêm, hà nội', 123456.00, 'COD', 'pending', '2025-11-12 15:41:53'),
(24, 1, 'Bắc từ liêm, hà nội', 5000000.00, 'COD', 'pending', '2025-11-12 15:48:35'),
(25, 1, 'Bắc từ liêm, hà nội', 123456.00, 'COD', 'pending', '2025-11-12 15:54:59'),
(26, 1, 'Bắc từ liêm, hà nội', 123456.00, 'COD', 'pending', '2025-11-12 16:05:29'),
(27, 1, 'Bắc từ liêm, hà nội', 2500000.00, 'COD', 'pending', '2025-11-12 16:08:37'),
(28, 1, 'Bắc từ liêm, hà nội', 2500000.00, 'COD', 'pending', '2025-11-15 10:22:25'),
(29, 1, 'Bắc từ liêm, hà nội, vn', 2345.00, 'COD', 'pending', '2025-11-15 11:44:13'),
(30, 7, 'ad1', 11092.00, 'COD', 'pending', '2025-11-15 12:01:54'),
(31, 7, 'ad1', 21340.00, 'COD', 'pending', '2025-11-15 12:02:12'),
(32, 7, 'ad1', 2134.00, 'COD', 'pending', '2025-11-15 12:05:00'),
(33, 1, 'Bắc từ liêm, hà nội, vn', 345.00, 'COD', 'pending', '2025-11-15 15:09:23'),
(34, 7, 'ad1', 12928.00, 'COD', 'pending', '2025-11-16 05:03:30'),
(35, 6, 'ad1', 123412.00, 'COD', 'pending', '2025-11-16 05:18:36'),
(36, 7, 'ad1', 246912.00, 'COD', 'pending', '2025-11-16 05:32:22'),
(37, 7, 'ad1', 370368.00, 'COD', 'pending', '2025-11-16 05:41:23'),
(38, 1, 'Bắc từ liêm, hà nội, vn', 3210000.00, 'COD', 'pending', '2025-11-16 14:38:59'),
(39, 9, 'ddd', 150000.00, 'COD', 'pending', '2025-11-17 08:37:01'),
(40, 10, 'cc', 9696.00, 'COD', 'pending', '2025-11-18 01:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `variant_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 2500000.00),
(3, 12, 5, 2, 123456.00),
(4, 12, NULL, 3, 55645.00),
(5, 13, NULL, 2, 1234000.00),
(6, 13, 2, 3, 3210000.00),
(9, 15, 18, 3, 32411.00),
(10, 16, 14, 1, 123412.00),
(11, 17, 13, 1, 1234000.00),
(12, 18, 5, 2, 123456.00),
(13, 18, 13, 1, 1234000.00),
(14, 19, NULL, 7, 65432.00),
(15, 19, 4, 1, 2345.00),
(16, 19, 21, 1, 345.00),
(17, 19, 2, 1, 3210000.00),
(18, 20, 18, 3, 32411.00),
(19, 21, 8, 1, 123456.00),
(20, 22, 8, 1, 123456.00),
(21, 23, 2, 1, 3210000.00),
(22, 23, 14, 2, 123412.00),
(23, 26, 8, 1, 123456.00),
(24, 27, 1, 1, 2500000.00),
(25, 28, 1, 1, 2500000.00),
(26, 29, 4, 1, 2345.00),
(27, 30, 4, 2, 2345.00),
(28, 30, NULL, 3, 2134.00),
(29, 31, NULL, 10, 2134.00),
(30, 32, NULL, 1, 2134.00),
(31, 33, 21, 1, 345.00),
(32, 34, 19, 4, 3232.00),
(33, 35, 14, 1, 123412.00),
(34, 36, 8, 2, 123456.00),
(35, 37, 5, 3, 123456.00),
(36, 38, 2, 1, 3210000.00),
(37, 39, 14, 1, 300.00),
(38, 40, 20, 3, 3232.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('active','hide') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `status`, `created_at`) VALUES
(1, 12, 'Nike Air Max 270', 'Giày chạy bộ phong cách thể thao.', 2500000.00, 'active', '2025-10-25 14:57:06'),
(2, 3, 'Adidas Ultraboost 22', 'Giày tập luyện cao cấp.', 3210000.00, 'active', '2025-10-25 14:57:06'),
(3, 10, 'A Văn B', 'des adsfsg', 2345.00, 'active', '2025-10-26 08:34:46'),
(4, NULL, 'Giày Nike nam', 'poisyion you', 890000.00, 'active', '2025-10-27 13:40:53'),
(5, 3, 'Giày Snekae Nữ 2025', 'Mô tatr apsfd pádjid', 55645.00, 'active', '2025-10-27 14:18:27'),
(6, 3, 'Giày Sneakerrrr Nam 20225', 'sàeweafwg\r\n\"SELECT image_url FROM {$this->table} WHERE id = ? LIMIT 1', 123456.00, 'active', '2025-10-27 14:21:53'),
(7, NULL, 'exemple.yml', 'this is .....', 5000000.00, 'active', '2025-10-28 14:07:08'),
(8, NULL, '82f2dabc-4515-370f-97f0-c92ca8cfe5ef.yml', 'zxcvzsvrszb', 1234000.00, 'active', '2025-11-02 04:48:16'),
(9, 10, 'Truong Hoang', 'sdđs', 123412.00, 'active', '2025-11-02 08:26:02'),
(11, NULL, 'Truong Hoang', 'tr54673', 32411.00, 'active', '2025-11-02 08:52:24'),
(12, 36, 'áaa', '23', 3232.00, 'active', '2025-11-02 08:56:09'),
(13, 10, 'Sản phẩm test', 'aaa', 345.00, 'hide', '2025-11-09 09:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`, `created_at`) VALUES
(16, 6, 'uploads/6900ab1f9737a8.07179975.png', 1, '2025-10-28 11:38:07'),
(19, 5, 'uploads/69017ed9ba15c4.96198354.png', 1, '2025-10-29 02:41:29'),
(20, 7, 'uploads/6902076d1933f2.66610285.png', 1, '2025-10-29 12:24:13'),
(21, 6, 'uploads/690321c2051929.07222284.png', 0, '2025-10-30 08:28:50'),
(22, 6, 'uploads/690321c20628f0.48627382.png', 0, '2025-10-30 08:28:50'),
(23, 2, 'uploads/69033eb1dee959.57146768.png', 1, '2025-10-30 10:32:17'),
(24, 2, 'uploads/69033ecdc38250.07330880.png', 0, '2025-10-30 10:32:45'),
(25, 8, 'uploads/main_6906e290e2f1b1.04900462.png', 1, '2025-11-02 04:48:16'),
(26, 8, 'uploads/img_6906e290e43382.71713428.png', 0, '2025-11-02 04:48:16'),
(27, 8, 'uploads/img_6906e290e55e82.67574759.png', 0, '2025-11-02 04:48:16'),
(28, 9, 'uploads/main_6907159ae8f021.59787098.png', 1, '2025-11-02 08:26:02'),
(29, 9, 'uploads/img_6907159ae9e6b5.60863852.png', 0, '2025-11-02 08:26:02'),
(32, 11, 'uploads/main_69071bc8507a75.72189920.png', 1, '2025-11-02 08:52:24'),
(33, 11, 'uploads/img_69071bc8514d74.51764515.png', 0, '2025-11-02 08:52:24'),
(34, 12, 'uploads/main_69071ca9c59199.95884400.png', 1, '2025-11-02 08:56:09'),
(35, 12, 'uploads/img_69071ca9c64375.78294798.png', 0, '2025-11-02 08:56:09'),
(46, 13, 'uploads/6918abff62dbf8.09622371.png', 1, '2025-11-15 16:36:15'),
(48, 6, 'uploads/6919e015b66160.82366810.png', 0, '2025-11-16 14:30:45'),
(49, 6, 'uploads/6919e015b76b07.77349055.png', 0, '2025-11-16 14:30:45'),
(50, 6, 'uploads/6919e015b87a80.86486684.png', 0, '2025-11-16 14:30:45'),
(51, 6, 'uploads/6919e015b93800.52329557.png', 0, '2025-11-16 14:30:45'),
(52, 6, 'uploads/6919e015ba18c0.59676471.png', 0, '2025-11-16 14:30:45'),
(53, 6, 'uploads/6919e015bb2a51.26400845.png', 0, '2025-11-16 14:30:45'),
(54, 6, 'uploads/6919e015bc4131.83588578.png', 0, '2025-11-16 14:30:45'),
(55, 6, 'uploads/6919e015bd2d37.87915917.png', 0, '2025-11-16 14:30:45'),
(56, 6, 'uploads/6919e015be71e8.23570400.png', 0, '2025-11-16 14:30:45'),
(57, 6, 'uploads/6919e015bf9936.83807481.png', 0, '2025-11-16 14:30:45'),
(58, 6, 'uploads/6919e015c0bd57.03289010.png', 0, '2025-11-16 14:30:45'),
(59, 6, 'uploads/6919e015c1be81.34718317.png', 0, '2025-11-16 14:30:45'),
(60, 2, 'uploads/6919e1e702dee3.50265913.png', 0, '2025-11-16 14:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `color`, `size`, `stock`, `created_at`) VALUES
(1, 1, 'đen', '41', 18, '2025-10-25 14:57:06'),
(2, 2, 'trắng', '42', 8, '2025-10-25 14:57:06'),
(4, 3, 'Đen', '39', 9, '2025-10-26 10:39:21'),
(5, 6, 'Đen', '41', 7, '2025-10-27 14:45:28'),
(6, 7, 'Đen', '41', 3, '2025-10-28 14:47:05'),
(7, 7, 'red', '42', 4, '2025-10-30 08:23:19'),
(8, 6, 'Đỏ', '42', 8, '2025-10-30 08:28:50'),
(9, 6, 'Đen', '42', 4, '2025-10-31 10:24:41'),
(13, 8, 'đen', '41', 1, '2025-11-02 04:49:04'),
(14, 9, 'trắng', '6', 0, '2025-11-02 08:26:02'),
(17, 1, 'vàng', '42', 5, '2025-11-02 08:46:57'),
(18, 11, 'vàng', '41', 3, '2025-11-02 08:52:24'),
(19, 12, 'vàng', '42', 11, '2025-11-02 08:56:09'),
(20, 12, 'vàng', '41', 0, '2025-11-02 08:57:19'),
(21, 13, 'vàng', '41', 3, '2025-11-09 09:01:59'),
(24, 1, 'bac', '42', 56, '2025-11-17 08:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin','staff') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('active','deleted','banned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `address`, `role`, `created_at`, `updated_at`, `status`) VALUES
(1, 'admin 123', 'test@gmail.com', '$2y$10$sCpnkLtqYJCAAfneBhzxkO6mFcTDpb5s.B8bS3fnDJLMyBLFHPWZS', '0905123456', 'Bắc từ liêm, hà nội, vn', 'admin', '2025-10-25 15:53:40', '2025-11-16 17:17:55', 'active'),
(2, 'Hoang Van Truong', 'truong@gmail.com', '123456', '0333285325', '1123 Ha Noi', 'customer', '2025-10-25 15:37:46', '2025-11-16 17:09:22', 'active'),
(3, 'Nguyen van test van b', 'qqd@gmail.com', '12314', '0905123456', 'Khoá', 'customer', '2025-10-25 18:48:11', '2025-11-16 17:18:18', 'banned'),
(6, 'Hui sin', 'hui86851@jioso.com', '$2y$10$sCpnkLtqYJCAAfneBhzxkO6mFcTDpb5s.B8bS3fnDJLMyBLFHPWZS', '0564774568', 'ad1', 'customer', '2025-10-28 16:48:24', '2025-10-31 15:41:27', 'active'),
(7, 'Truong Hoang', 'truongsina2005@gmail.com', '$2y$10$actLheHQS72FVpscusatSu6ag.eqJsviDYUQmnyo4/Dt8Rnbf5Nxq', '0333824720', 'ad1', 'staff', '2025-10-28 16:58:49', '2025-11-17 06:11:47', 'active'),
(8, 'Truong Hoang', 'b@gmail.com', '$2y$10$3Dp3Qt9PggfQjE6cYxnGuO.HzdOcyEWa46dEKsfxcjBZI.r6dZCaK', '01294323', 'ad1', 'customer', '2025-11-15 12:05:37', '2025-11-16 15:14:22', 'active'),
(9, NULL, 'dzy45077@toaik.com', '$2y$10$j1ThsjzE0KJZ/PojmHJtMOrPpEWLacf9hvanlPxpnqX9qqUof7JES', NULL, NULL, 'customer', '2025-11-16 04:49:49', '2025-11-16 04:49:49', 'active'),
(10, 'Nhân viên', 'nhanvien@gmail.com', '$2y$10$sCpnkLtqYJCAAfneBhzxkO6mFcTDpb5s.B8bS3fnDJLMyBLFHPWZS', '19001834', 'cc', 'staff', '2025-11-17 09:06:44', '2025-11-17 09:07:03', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_carts` (`user_id`,`variant_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
