-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 09, 2022 lúc 06:16 PM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `classrooms`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `birth` date NOT NULL,
  `gender` int(1) NOT NULL DEFAULT 0 COMMENT '0 : Nữ - 1 : Nam',
  `role_id` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `user`, `pass`, `name`, `phone_number`, `birth`, `gender`, `role_id`, `created`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'ADMIN', '0123456789', '2000-01-01', 1, 1, '2022-06-03 08:17:27'),
(2, 'user001', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Văn A', '0123456789', '2022-02-01', 1, 2, '2022-06-03 08:16:02'),
(3, 'user002', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Văn B', '0123456789', '2001-01-01', 0, 2, '2022-05-28 09:24:47'),
(4, 'user003', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Văn C', '0123456789', '2001-01-01', 0, 2, '2022-05-28 09:24:47'),
(5, 'user004', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Văn X', '0123456789', '2001-01-01', 0, 2, '2022-05-28 09:24:47'),
(8, 'user005', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Văn Y', '0123123123', '2000-02-10', 1, 2, '2022-06-03 07:45:46'),
(10, 'user006', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Văn Z', '0123123121', '2000-10-10', 1, 2, '2022-06-03 08:18:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `managements`
--

CREATE TABLE `managements` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `room_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `date_hire` date NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `managements`
--

INSERT INTO `managements` (`id`, `customer_id`, `room_id`, `shift_id`, `date_hire`, `created`) VALUES
(1, 2, 2, 1, '2022-05-29', '2022-05-28 12:25:09'),
(2, 2, 2, 2, '2022-06-03', '2022-06-03 03:41:31'),
(9, 2, 2, 4, '1111-11-11', '2022-06-03 01:31:53'),
(10, 2, 2, 5, '1111-11-11', '2022-06-03 01:31:53'),
(11, 2, 2, 1, '2022-06-02', '2022-06-03 03:57:49'),
(12, 2, 2, 2, '2022-06-03', '2022-06-03 01:34:49'),
(14, 2, 3, 2, '2022-06-03', '2022-06-03 08:10:08'),
(15, 2, 3, 3, '2022-06-03', '2022-06-03 08:10:08'),
(16, 2, 3, 7, '2022-06-03', '2022-06-03 08:10:08'),
(17, 2, 3, 8, '2022-06-03', '2022-06-03 08:10:08'),
(18, 2, 3, 9, '2022-06-03', '2022-06-03 08:10:08'),
(19, 2, 3, 5, '2022-06-03', '2022-06-03 08:16:49'),
(20, 2, 3, 6, '2022-06-03', '2022-06-03 08:16:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Super Admin'),
(2, 'Khách Hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL COMMENT 'Tính theo số học sinh',
  `rentCost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `size`, `rentCost`) VALUES
(1, 'Phòng học nhỏ 1', 15, 100000),
(2, 'Phòng học nhỏ 2', 15, 100000),
(3, 'Phòng học nhỏ 3', 15, 100000),
(4, 'Phòng giảng đường 1', 40, 150000),
(5, 'Phòng giảng đường 2', 40, 150000),
(6, 'Phòng giảng đường 3', 40, 150000),
(7, 'Phòng nghe 1', 20, 130000),
(8, 'Phòng nghe 2', 20, 130000),
(9, 'Phòng nghe 3', 20, 130000),
(10, 'Phòng máy 1', 30, 250000),
(11, 'Phòng máy 2', 30, 250000),
(13, 'Phòng máy 3', 30, 250000),
(14, 'Phòng họp', 10, 100000),
(15, 'Phòng học nhỏ 4', 15, 150000),
(19, 'Phòng nghe 4', 20, 130000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shifts`
--

CREATE TABLE `shifts` (
  `id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `shifts`
--

INSERT INTO `shifts` (`id`, `start`, `end`) VALUES
(1, '2000-01-01 07:00:00', '2000-01-01 07:45:00'),
(2, '2000-01-01 08:00:00', '2000-01-01 08:45:00'),
(3, '2000-01-01 09:00:00', '2000-01-01 09:45:00'),
(4, '2000-01-01 10:00:00', '2000-01-01 10:45:00'),
(5, '2000-01-01 11:00:00', '2000-01-01 11:45:00'),
(6, '2000-01-01 12:00:00', '2000-01-01 12:45:00'),
(7, '2000-01-01 13:00:00', '2000-01-01 13:45:00'),
(8, '2000-01-01 14:00:00', '2000-01-01 14:45:00'),
(9, '2000-01-01 15:00:00', '2000-01-01 15:45:00'),
(10, '2000-01-01 16:00:00', '2000-01-01 16:45:00'),
(11, '2000-01-01 17:00:00', '2000-01-01 17:45:00'),
(12, '2000-01-01 18:00:00', '2000-01-01 18:45:00'),
(13, '2000-01-01 19:00:00', '2000-01-01 19:45:00'),
(14, '2000-01-01 20:00:00', '2000-01-01 20:45:00');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Chỉ mục cho bảng `managements`
--
ALTER TABLE `managements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `shift_id` (`shift_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `managements`
--
ALTER TABLE `managements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Các ràng buộc cho bảng `managements`
--
ALTER TABLE `managements`
  ADD CONSTRAINT `managements_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `managements_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `managements_ibfk_3` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
