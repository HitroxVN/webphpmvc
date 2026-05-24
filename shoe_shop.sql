-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 23, 2026 lúc 05:58 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shoe_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `variant_id`, `quantity`) VALUES
(150, 1, 2, 4),
(156, 1, 8, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','hide') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`) VALUES
(3, 'snaker', 'active', '2025-10-25 14:57:06'),
(10, 'adedas', 'active', '2025-10-26 15:07:42'),
(12, 'france', 'active', '2025-11-02 04:52:40'),
(37, 'nife', 'active', '2025-11-26 00:45:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
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
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shipping_address`, `total_amount`, `payment_method`, `status`, `created_at`) VALUES
(1, 2, 'Hà Nội, Việt Nam', 2500000.00, 'COD', 'pending', '2025-10-25 14:57:06'),
(12, 1, 'Bắc từ liêm, hà nội', 413847.00, 'COD', 'shipped', '2025-11-11 15:40:42'),
(13, 1, 'Bắc từ liêm, hà nội', 12098000.00, 'COD', 'confirmed', '2025-09-02 05:41:11'),
(15, 7, 'ad1', 97233.00, 'COD', 'confirmed', '2025-06-03 11:42:42'),
(16, 1, 'Bắc từ liêm, hà nội', 123412.00, 'COD', 'shipped', '2025-08-12 13:39:29'),
(17, 1, 'Bắc từ liêm, hà nội', 1234000.00, 'COD', 'cancelled', '2025-07-23 14:40:02'),
(18, 7, 'ad1', 1480912.00, 'COD', 'delivered', '2025-05-20 08:56:41'),
(19, 1, 'Bắc từ liêm, hà nội', 3670714.00, 'COD', 'cancelled', '2026-04-17 15:16:07'),
(20, 1, 'Bắc từ liêm, hà nội', 97233.00, 'COD', 'cancelled', '2025-11-12 00:43:08'),
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
(39, NULL, 'ddd', 150000.00, 'COD', 'cancelled', '2025-11-17 08:37:01'),
(40, 10, 'cc', 9696.00, 'COD', 'pending', '2025-11-18 01:54:57'),
(41, 6, 'ad1', 30000000.00, 'COD', 'delivered', '2025-11-18 07:28:57'),
(42, 6, 'ad1', 249257.00, 'COD', 'pending', '2025-11-18 07:36:24'),
(44, 6, 'ad1', 617280.00, 'COD', 'pending', '2025-11-18 07:37:09'),
(45, 6, 'ad1', 864192.00, 'COD', 'pending', '2025-11-18 07:39:01'),
(46, 6, 'ad1', 13240736.00, 'COD', 'pending', '2025-11-18 07:39:46'),
(47, 6, 'ad1', 2500000.00, 'COD', 'pending', '2025-11-18 12:34:12'),
(48, 6, 'ad1', 3232.00, 'COD', 'cancelled', '2025-11-18 12:34:30'),
(49, 1, 'Bắc từ liêm, hà nội, vn', 10013296.00, 'COD', 'pending', '2025-11-18 14:22:53'),
(50, 6, 'ad1', 1780000.00, 'COD', 'delivered', '2025-12-14 06:01:43'),
(51, 6, 'ad1', 890000.00, 'COD', 'confirmed', '2025-12-16 06:05:15'),
(52, 6, 'ad1', 1500000.00, 'COD', 'shipped', '2025-12-17 06:21:19'),
(53, 6, 'ad1', 25000000.00, 'COD', 'pending', '2026-01-27 19:09:52'),
(54, 6, 'ad1', 123456.00, 'COD', 'shipped', '2026-03-10 16:35:01'),
(55, 6, 'ad1', 950000.00, 'COD', 'pending', '2026-03-10 17:51:55'),
(56, 6, 'ad1', 55645.00, 'BANKING', 'cancelled', '2026-03-10 18:00:47'),
(57, 6, 'ad1', 1500000.00, 'BANKING', 'shipped', '2026-03-10 18:06:32'),
(58, 6, 'ad1', 5000000.00, 'BANKING', 'delivered', '2026-03-10 18:09:15'),
(59, 6, 'ad1', 890000.00, 'BANKING', 'shipping', '2026-03-10 18:10:57'),
(60, 6, 'ad1', 1500000.00, 'BANKING', 'pending', '2026-03-11 03:11:14'),
(61, 6, 'ad1', 123456.00, 'BANKING', 'pending', '2026-03-11 03:20:30'),
(62, 6, 'ad1', 2500000.00, 'BANKING', 'confirmed', '2026-03-11 03:21:18'),
(63, 6, 'ad1', 55645.00, 'BANKING', 'confirmed', '2026-03-11 03:55:46'),
(64, 6, 'ad1', 890000.00, 'BANKING', 'cancelled', '2026-03-11 18:18:51'),
(65, 6, 'ad1', 2500.00, 'BANKING', 'shipping', '2026-03-11 19:26:40'),
(66, 6, 'ad1', 2500.00, 'BANKING', 'confirmed', '2026-03-12 15:58:28'),
(67, 6, 'ad1', 5000.00, 'BANKING', 'delivered', '2026-03-12 16:06:51'),
(68, 6, 'ad1', 2500.00, 'COD', 'pending', '2026-03-12 16:34:38'),
(70, 18, '23 Bắc từ liêm, hà nội, Việt Nam', 2500.00, 'COD', 'pending', '2026-03-12 16:36:27'),
(71, 18, '23 Bắc từ liêm, hà nội, Việt Nam', 2500.00, 'BANKING', 'cancelled', '2026-03-12 16:36:51'),
(72, 18, '23 Bắc từ liêm, hà nội, Việt Nam', 2500.00, 'BANKING', 'confirmed', '2026-03-12 16:37:52'),
(73, 18, '23 Bắc từ liêm, hà nội, Việt Nam', 55645.00, 'BANKING', 'confirmed', '2026-03-12 16:45:12'),
(74, 18, '23 Bắc từ liêm, hà nội, Việt Nam', 2500.00, 'BANKING', 'confirmed', '2026-03-12 17:05:13'),
(75, 18, '23 Bắc từ liêm, hà nội, Việt Nam', 2500.00, 'BANKING', 'confirmed', '2026-03-12 17:22:50'),
(76, 18, '23 Bắc từ liêm, hà nội, Việt Nam', 5000000.00, 'BANKING', 'cancelled', '2026-03-12 17:33:20'),
(77, 18, '23 Bắc từ liêm, hà nội, Việt Nam', 5000000.00, 'BANKING', 'cancelled', '2026-03-12 17:37:17'),
(78, 6, 'ad1', 7500.00, 'BANKING', 'confirmed', '2026-03-12 17:43:43'),
(79, 6, 'ad1', 1500000.00, 'BANKING', 'pending', '2026-03-12 17:55:36'),
(80, 6, 'ad1', 2500.00, 'BANKING', 'confirmed', '2026-03-13 07:00:25'),
(81, 6, 'ad1', 2500.00, 'BANKING', 'confirmed', '2026-03-13 07:05:15'),
(82, 6, 'ad1', 5000.00, 'BANKING', 'confirmed', '2026-03-13 07:09:07'),
(83, 6, 'ad1', 2500.00, 'BANKING', 'pending', '2026-03-13 08:11:30'),
(84, 6, 'ad1', 123456.00, 'BANKING', 'pending', '2026-04-03 06:09:07'),
(85, 6, 'ad1', 1500000.00, 'BANKING', 'pending', '2026-04-03 07:13:43'),
(86, 6, 'ad1', 3210000.00, 'BANKING', 'pending', '2026-04-03 07:14:23'),
(87, 6, 'ad1', 123456.00, 'BANKING', 'confirmed', '2026-04-06 07:26:43'),
(88, 7, 'ad1', 370368.00, 'COD', 'pending', '2026-05-13 19:24:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `variant_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 2500000.00),
(3, 12, 5, 2, 123456.00),
(4, 12, NULL, 3, 55645.00),
(5, 13, NULL, 2, 1234000.00),
(6, 13, 2, 3, 3210000.00),
(9, 15, NULL, 3, 32411.00),
(10, 16, 14, 1, 123412.00),
(11, 17, 13, 1, 1234000.00),
(12, 18, 5, 2, 123456.00),
(13, 18, 13, 1, 1234000.00),
(14, 19, NULL, 7, 65432.00),
(15, 19, 4, 1, 2345.00),
(16, 19, NULL, 1, 345.00),
(17, 19, 2, 1, 3210000.00),
(18, 20, NULL, 3, 32411.00),
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
(31, 33, NULL, 1, 345.00),
(32, 34, NULL, 4, 3232.00),
(33, 35, 14, 1, 123412.00),
(34, 36, 8, 2, 123456.00),
(35, 37, 5, 3, 123456.00),
(36, 38, 2, 1, 3210000.00),
(37, 39, 14, 1, 300.00),
(38, 40, NULL, 3, 3232.00),
(39, 41, 24, 12, 2500000.00),
(40, 42, 4, 1, 2345.00),
(41, 42, 8, 2, 123456.00),
(42, 44, 5, 5, 123456.00),
(43, 45, 9, 7, 123456.00),
(44, 46, 1, 5, 2500000.00),
(45, 46, 8, 6, 123456.00),
(46, 47, 24, 1, 2500000.00),
(47, 48, NULL, 1, 3232.00),
(48, 49, 9, 3, 123456.00),
(49, 49, NULL, 4, 3232.00),
(50, 49, 2, 3, 3210000.00),
(51, 50, 32, 2, 890000.00),
(52, 51, 32, 1, 890000.00),
(53, 52, 28, 1, 1500000.00),
(54, 53, 26, 5, 5000000.00),
(55, 54, 5, 1, 123456.00),
(56, 55, 6, 1, 950000.00),
(57, 56, 34, 1, 55645.00),
(58, 57, 30, 1, 1500000.00),
(59, 58, 25, 1, 5000000.00),
(60, 59, 33, 1, 890000.00),
(61, 60, 28, 1, 1500000.00),
(62, 61, 5, 1, 123456.00),
(63, 62, 17, 1, 2500000.00),
(64, 63, 35, 1, 55645.00),
(65, 64, 33, 1, 890000.00),
(66, 65, 24, 1, 2500.00),
(67, 66, 17, 1, 2500.00),
(68, 67, 17, 2, 2500.00),
(69, 68, 24, 1, 2500.00),
(70, 70, 17, 1, 2500.00),
(71, 71, 1, 1, 2500.00),
(72, 72, 1, 1, 2500.00),
(73, 73, 34, 1, 55645.00),
(74, 74, 24, 1, 2500.00),
(75, 75, 24, 1, 2500.00),
(76, 76, 26, 1, 5000000.00),
(77, 77, 26, 1, 5000000.00),
(78, 78, 24, 3, 2500.00),
(79, 79, 29, 1, 1500000.00),
(80, 80, 24, 1, 2500.00),
(81, 81, 24, 1, 2500.00),
(82, 82, 24, 2, 2500.00),
(83, 83, 24, 1, 2500.00),
(84, 84, 5, 1, 123456.00),
(85, 85, 28, 1, 1500000.00),
(86, 86, 2, 1, 3210000.00),
(87, 87, 8, 1, 123456.00),
(88, 88, 8, 3, 123456.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `bank_transaction_code` varchar(100) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `raw_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw_payload`)),
  `status` enum('pending','confirmed','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `transaction_date`, `bank_transaction_code`, `amount`, `content`, `raw_payload`, `status`) VALUES
(1, 81, '2026-03-12 02:27:00', 'FT26471040339089', 56000, 'order81', '{\"gateway\":\"MBBank\",\"transactionDate\":\"2026-03-12 02:27:00\",\"accountNumber\":\"52000000001\",\"subAccount\":null,\"code\":null,\"content\":\"order81\",\"transferType\":\"in\",\"description\":\"test order71\",\"transferAmount\":56000,\"referenceCode\":\"FT26471040339089\",\"accumulated\":0,\"id\":44960089}', 'confirmed'),
(2, 80, '2026-03-13 14:01:00', 'FT26072118973308', 2500, 'order80', '{\"gateway\":\"MBBank\",\"transactionDate\":\"2026-03-13 14:01:00\",\"accountNumber\":\"52000000001\",\"subAccount\":null,\"code\":null,\"content\":\"order80\",\"transferType\":\"in\",\"description\":\"BankAPINotify order80\",\"transferAmount\":2500,\"referenceCode\":\"FT26072118973308\",\"accumulated\":0,\"id\":45138214}', 'confirmed'),
(3, 82, '2026-03-13 14:09:00', 'FT26072105368483', 5000, 'order82', '{\"gateway\":\"MBBank\",\"transactionDate\":\"2026-03-13 14:09:00\",\"accountNumber\":\"52000000001\",\"subAccount\":null,\"code\":null,\"content\":\"order82\",\"transferType\":\"in\",\"description\":\"BankAPINotify order82\",\"transferAmount\":5000,\"referenceCode\":\"FT26072105368483\",\"accumulated\":0,\"id\":45139102}', 'confirmed'),
(4, 87, '2026-03-12 02:27:00', 'FT26471040339087', 123456, 'order87', '{\"gateway\":\"MBBank\",\"transactionDate\":\"2026-03-12 02:27:00\",\"accountNumber\":\"52000000001\",\"subAccount\":null,\"code\":null,\"content\":\"order87\",\"transferType\":\"in\",\"description\":\"test order71\",\"transferAmount\":123456,\"referenceCode\":\"FT26471040339087\",\"accumulated\":0,\"id\":44960089}', 'confirmed');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
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
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `status`, `created_at`) VALUES
(1, 12, 'Nike Air Max 270', 'Giày chạy bộ phong cách thể thao.', 2500.00, 'active', '2025-10-25 14:57:06'),
(2, 10, 'Adedas Ultraboost 22', 'Giày tập luyện cao cấp.', 3210000.00, 'active', '2025-10-25 14:57:06'),
(3, 10, 'A Văn B', 'des adsfsg', 2345.00, 'hide', '2025-10-26 08:34:46'),
(4, 37, 'Giày Nife nam', 'Mềm nhẹ, dễ mang, đế chống trượt, thích hợp di chuyển nhiều.', 890000.00, 'active', '2025-10-27 13:40:53'),
(5, 3, 'Giày Snekae Nữ 2025', 'Mô tatr apsfd pádjid', 55645.00, 'active', '2025-10-27 14:18:27'),
(6, 10, 'Giày Adedas nam 2025', 'sàeweafwg giày vip', 123456.00, 'active', '2025-10-27 14:21:53'),
(7, 10, 'Giày Thể Thao Adedas Runner', 'Giày chạy bộ siêu nhẹ, đế EVA đàn hồi, thoáng khí, phù hợp cho tập luyện hàng ngày.', 950000.00, 'active', '2025-10-28 14:07:08'),
(8, 3, '82f2dabc-4515-370f-97f0-c92ca8cfe5ef.yml', 'zxcvzsvrszb', 1234000.00, 'hide', '2025-11-02 04:48:16'),
(9, 10, 'Truong Hoang', 'sdđs', 123412.00, 'hide', '2025-11-02 08:26:02'),
(17, 3, 'Giày Sneaker Urban Street', 'Thiết kế trẻ trung, phối màu hiện đại, dễ phối đồ, phù hợp đi học – đi chơi.', 5000000.00, 'active', '2025-11-26 00:50:02'),
(18, 37, 'Giày Thể Thao Nife Training', 'Đế cao su bám đường, thân giày dệt knit co giãn, hỗ trợ tốt khi tập gym.', 1500000.00, 'active', '2025-11-26 00:55:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`, `created_at`) VALUES
(25, 8, 'uploads/main_6906e290e2f1b1.04900462.png', 1, '2025-11-02 04:48:16'),
(26, 8, 'uploads/img_6906e290e43382.71713428.png', 0, '2025-11-02 04:48:16'),
(27, 8, 'uploads/img_6906e290e55e82.67574759.png', 0, '2025-11-02 04:48:16'),
(28, 9, 'uploads/main_6907159ae8f021.59787098.png', 1, '2025-11-02 08:26:02'),
(29, 9, 'uploads/img_6907159ae9e6b5.60863852.png', 0, '2025-11-02 08:26:02'),
(63, 17, 'uploads/main_69264eba1a6848.08059048.png', 1, '2025-11-26 00:50:02'),
(64, 17, 'uploads/img_69264eba1b6060.46158729.png', 0, '2025-11-26 00:50:02'),
(65, 17, 'uploads/img_69264eba1c9305.86053960.png', 0, '2025-11-26 00:50:02'),
(66, 7, 'uploads/69264f55111598.65494559.png', 1, '2025-11-26 00:52:37'),
(67, 7, 'uploads/69264f55124c46.69499887.png', 0, '2025-11-26 00:52:37'),
(68, 18, 'uploads/main_6926500447abc3.29050775.png', 1, '2025-11-26 00:55:32'),
(69, 18, 'uploads/img_6926500448f043.71425630.png', 0, '2025-11-26 00:55:32'),
(70, 18, 'uploads/img_692650044a0f37.41836124.png', 0, '2025-11-26 00:55:32'),
(71, 4, 'uploads/6926504eb4cb40.05269642.png', 1, '2025-11-26 00:56:46'),
(72, 1, 'uploads/692652b3567d50.11321001.jpg', 1, '2025-11-26 01:06:59'),
(73, 2, 'uploads/6926602b942e13.96573207.png', 1, '2025-11-26 02:04:27'),
(74, 2, 'uploads/6926602b950bf9.02183449.png', 0, '2025-11-26 02:04:27'),
(75, 2, 'uploads/6926602b95fdf1.99607527.png', 0, '2025-11-26 02:04:27'),
(76, 4, 'uploads/692660604e3f62.78429916.png', 0, '2025-11-26 02:05:20'),
(77, 5, 'uploads/69266081801730.97236142.png', 1, '2025-11-26 02:05:53'),
(78, 5, 'uploads/6926608181af45.97815894.png', 0, '2025-11-26 02:05:53'),
(79, 5, 'uploads/6926608182e671.36127040.png', 0, '2025-11-26 02:05:53'),
(80, 6, 'uploads/692660fc362333.57849223.png', 0, '2025-11-26 02:07:56'),
(81, 6, 'uploads/692660fc374ae8.69993814.png', 1, '2025-11-26 02:07:56'),
(82, 6, 'uploads/692660fc3854d5.20724806.png', 0, '2025-11-26 02:07:56'),
(83, 7, 'uploads/692661234e6c90.62824060.png', 0, '2025-11-26 02:08:35'),
(84, 7, 'uploads/692661234f7c09.98701198.png', 0, '2025-11-26 02:08:35'),
(85, 7, 'uploads/69266123505443.11441577.png', 0, '2025-11-26 02:08:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
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
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `color`, `size`, `stock`, `created_at`) VALUES
(1, 1, 'đen', '41', 12, '2025-10-25 14:57:06'),
(2, 2, 'trắng', '42', 4, '2025-10-25 14:57:06'),
(4, 3, 'Đen', '39', 9, '2025-10-26 10:39:21'),
(5, 6, 'Đen', '41', 67, '2025-10-27 14:45:28'),
(6, 7, 'đen', '41', 29, '2025-10-28 14:47:05'),
(7, 7, 'đỏ', '42', 40, '2025-10-30 08:23:19'),
(8, 6, 'Đỏ', '42', 70, '2025-10-30 08:28:50'),
(9, 6, 'Đen', '42', 30, '2025-10-31 10:24:41'),
(13, 8, 'đen', '41', 1, '2025-11-02 04:49:04'),
(14, 9, 'trắng', '6', 1, '2025-11-02 08:26:02'),
(17, 1, 'vàng', '42', 0, '2025-11-02 08:46:57'),
(24, 1, 'bac', '42', 31, '2025-11-17 08:06:51'),
(25, 17, 'trắng', '40', 70, '2025-11-26 00:50:02'),
(26, 17, 'đen', '41', 55, '2025-11-26 00:50:02'),
(27, 17, 'bạc', '42', 50, '2025-11-26 00:50:02'),
(28, 18, 'đen', '40', 67, '2025-11-26 00:55:32'),
(29, 18, 'trắng', '42', 49, '2025-11-26 00:55:32'),
(30, 18, 'vàng', '41', 49, '2025-11-26 00:55:32'),
(31, 18, 'trắng', '41', 20, '2025-11-26 00:55:32'),
(32, 4, 'trắng', '41', 47, '2025-11-26 00:56:46'),
(33, 4, 'đen', '41', 19, '2025-11-26 00:56:46'),
(34, 5, 'trắng', '42', 79, '2025-11-26 02:06:21'),
(35, 5, 'trắng', '41', 54, '2025-11-26 02:06:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
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
  `status` enum('active','deleted','banned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `address`, `role`, `created_at`, `status`) VALUES
(1, 'admin 123', 'test@gmail.com', '$2y$10$sCpnkLtqYJCAAfneBhzxkO6mFcTDpb5s.B8bS3fnDJLMyBLFHPWZS', '0905123456', 'Bắc từ liêm, hà nội, vn', 'admin', '2025-10-25 15:53:40', 'active'),
(2, 'Hoang Van Truong', 'truong@gmail.com', '123456', '0333285325', '1123 Ha Noi', 'customer', '2025-10-25 15:37:46', 'active'),
(6, 'Hui', 'hui86851@jioso.com', '$2y$10$sCpnkLtqYJCAAfneBhzxkO6mFcTDpb5s.B8bS3fnDJLMyBLFHPWZS', '0564774568', 'ad1', 'customer', '2025-10-28 16:48:24', 'active'),
(7, 'Truong Hoang', 'truongsina2005@gmail.com', '$2y$10$actLheHQS72FVpscusatSu6ag.eqJsviDYUQmnyo4/Dt8Rnbf5Nxq', '0333824720', 'ad1', 'staff', '2025-10-28 16:58:49', 'active'),
(10, 'Nhân viên', 'nhanvien@gmail.com', '$2y$10$sCpnkLtqYJCAAfneBhzxkO6mFcTDpb5s.B8bS3fnDJLMyBLFHPWZS', '19001834', 'cc', 'staff', '2025-11-17 09:06:44', 'active'),
(16, NULL, 'abc@gmail.com', '$2y$10$M6/q.DQhnsdlFsK8x5d6wO2/aJ41cXOhH0P.B6ONypaFM57mNjGXS', NULL, NULL, 'customer', '2026-03-11 06:54:34', 'active'),
(17, NULL, 'abcd@gmail.com', '$2y$10$fb8fTY/dd4aFUe9f.wejzu6ygS2eypmZtXAd7x2efKwuq34qzBuPK', NULL, NULL, 'customer', '2026-03-11 06:56:21', 'active'),
(18, 'TRUONG HOANG VAN', 'test1@gmail.com', '$2y$10$2HRAah4.Yewo.ZVJsRKR6O7qzhpGeEA0l7HibirHj3J.HPkYvA2e6', '0905123456', '23 Bắc từ liêm, hà nội, Việt Nam', 'customer', '2026-03-12 16:36:01', 'active');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_carts` (`user_id`,`variant_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bank_transaction_code` (`bank_transaction_code`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
