-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 04, 2024 at 12:45 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doantotnghiep`
--

-- --------------------------------------------------------

--
-- Table structure for table `baocaothongke`
--

DROP TABLE IF EXISTS `baocaothongke`;
CREATE TABLE IF NOT EXISTS `baocaothongke` (
  `id` int NOT NULL AUTO_INCREMENT,
  `loai` varchar(50) DEFAULT NULL,
  `ngayTao` datetime DEFAULT NULL,
  `thoiGianBatDau` datetime DEFAULT NULL,
  `thoiGianKetThuc` datetime DEFAULT NULL,
  `tongSoDonHang` int DEFAULT NULL,
  `soLuongSanPhamNhapRa` int DEFAULT NULL,
  `tongDoanhThu` decimal(10,2) DEFAULT NULL,
  `nhanvien_id` int NOT NULL,
  PRIMARY KEY (`id`,`nhanvien_id`),
  KEY `fk_baocaothongke_nhanvien_idx` (`nhanvien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `soLuong` int DEFAULT NULL,
  `gia` decimal(15,2) DEFAULT NULL,
  `donhang_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_donhang` (`donhang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`id`, `soLuong`, `gia`, `donhang_id`) VALUES
(37, NULL, NULL, 49),
(38, 2, '15890000.00', 50),
(39, 2, '33490000.00', 50),
(40, 2, '15890000.00', 51),
(41, 1, '33490000.00', 52),
(42, 1, '33490000.00', 53),
(43, 2, '15890000.00', 54),
(44, 1, '15890000.00', 55);

-- --------------------------------------------------------

--
-- Table structure for table `chitietgiohang`
--

DROP TABLE IF EXISTS `chitietgiohang`;
CREATE TABLE IF NOT EXISTS `chitietgiohang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `soLuong` int DEFAULT NULL,
  `gia` decimal(15,2) DEFAULT NULL,
  `giohang_id` int NOT NULL,
  PRIMARY KEY (`id`,`giohang_id`),
  KEY `fk_chitietgiohang_giohang1_idx` (`giohang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chitietgiohang`
--

INSERT INTO `chitietgiohang` (`id`, `soLuong`, `gia`, `giohang_id`) VALUES
(3, NULL, NULL, 12),
(4, NULL, NULL, 20),
(12, NULL, NULL, 25),
(25, 1, '15000000.00', 29),
(26, 1, '15000000.00', 29),
(27, 1, '240.00', 29),
(28, 1, '260.00', 29),
(29, 1, '15000000.00', 30),
(30, 1, '120.00', 30),
(46, 1, '240.00', 34);

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieuxuat`
--

DROP TABLE IF EXISTS `chitietphieuxuat`;
CREATE TABLE IF NOT EXISTS `chitietphieuxuat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `soLuong` int DEFAULT NULL,
  `baoHanh` datetime DEFAULT NULL,
  `ghiChu` text,
  `chitietdonhang_id` int NOT NULL,
  `phieuxuathang_id` int NOT NULL,
  `yeucautrahang_id` int DEFAULT NULL,
  `yeucaudoihang_id` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_chitietphieuxuat_chitietdonhang1_idx` (`chitietdonhang_id`),
  KEY `fk_chitietphieuxuat_phieuxuathang1_idx` (`phieuxuathang_id`),
  KEY `fk_chitietphieuxuat_yeucautrahang1_idx` (`yeucautrahang_id`),
  KEY `fk_chitietphieuxuat_yeucaudoihang1_idx` (`yeucaudoihang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chitietphieuxuat`
--

INSERT INTO `chitietphieuxuat` (`id`, `soLuong`, `baoHanh`, `ghiChu`, `chitietdonhang_id`, `phieuxuathang_id`, `yeucautrahang_id`, `yeucaudoihang_id`) VALUES
(28, 1, '2025-01-05 23:43:00', 'Không bảo hành rơi vỡ, rớt nước', 38, 32, NULL, NULL),
(29, 1, '2025-01-05 23:43:00', 'Không bảo hành rơi vỡ, rớt nước', 39, 32, NULL, NULL),
(30, 1, '2024-12-21 02:46:00', 'không bảo hành rơi vỡ rớt nước', 44, 33, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieuxuat_has_suachuabaotri`
--

DROP TABLE IF EXISTS `chitietphieuxuat_has_suachuabaotri`;
CREATE TABLE IF NOT EXISTS `chitietphieuxuat_has_suachuabaotri` (
  `chitietphieuxuat_id` int NOT NULL,
  `suachuabaotri_id` int NOT NULL,
  PRIMARY KEY (`chitietphieuxuat_id`,`suachuabaotri_id`),
  KEY `fk_chitietphieuxuat_has_suachuabaotri_suachuabaotri1_idx` (`suachuabaotri_id`),
  KEY `fk_chitietphieuxuat_has_suachuabaotri_chitietphieuxuat1_idx` (`chitietphieuxuat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhgia`
--

DROP TABLE IF EXISTS `danhgia`;
CREATE TABLE IF NOT EXISTS `danhgia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `soSao` int DEFAULT NULL,
  `noiDung` text,
  `ngayTao` datetime DEFAULT NULL,
  `khachhang_id` int NOT NULL,
  `sanpham_id` int NOT NULL,
  PRIMARY KEY (`id`,`khachhang_id`,`sanpham_id`),
  KEY `fk_danhgia_khachhang1_idx` (`khachhang_id`),
  KEY `fk_danhgia_sanpham1_idx` (`sanpham_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
CREATE TABLE IF NOT EXISTS `danhmuc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenDanhMuc` varchar(100) DEFAULT NULL,
  `moTa` text,
  `ngayTao` datetime DEFAULT NULL,
  `ngayCapNhat` datetime DEFAULT NULL,
  `trangThai` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `tenDanhMuc`, `moTa`, `ngayTao`, `ngayCapNhat`, `trangThai`) VALUES
(19, 'Laptop', 'Laptop thôi', '2024-12-01 16:30:03', '2024-12-01 16:30:03', 1),
(20, 'Điện Thoại', 'Điện Thoại thôi', '2024-12-01 16:30:25', '2024-12-01 16:30:25', 1),
(21, 'Màn Hình', 'Màn Hình thôi', '2024-12-01 16:30:37', '2024-12-01 16:30:37', 1),
(22, 'Bàn Phím', 'Bàn Phím thôi', '2024-12-01 16:30:51', '2024-12-01 16:30:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

DROP TABLE IF EXISTS `donhang`;
CREATE TABLE IF NOT EXISTS `donhang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenKhachHang` varchar(100) NOT NULL,
  `ngayDatHang` datetime DEFAULT NULL,
  `tongTien` decimal(15,2) DEFAULT NULL,
  `trangThai` varchar(50) DEFAULT NULL,
  `diaChiGiaoHang` text,
  `sdt` varchar(15) DEFAULT NULL,
  `nhanvien_id` int DEFAULT NULL,
  `khachhang_id` int NOT NULL,
  `updated_by` date NOT NULL,
  `phuongThucThanhToan` varchar(45) NOT NULL,
  `maVanChuyen` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_donhang_nhanvien1_idx` (`nhanvien_id`),
  KEY `fk_donhang_khachhang1_idx` (`khachhang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`id`, `tenKhachHang`, `ngayDatHang`, `tongTien`, `trangThai`, `diaChiGiaoHang`, `sdt`, `nhanvien_id`, `khachhang_id`, `updated_by`, `phuongThucThanhToan`, `maVanChuyen`) VALUES
(49, '11', '2024-12-01 15:13:26', '3220.00', 'Đã giao cho đơn vị vận chuyển', 'asdasd', '1111111111', 1, 10, '2024-12-03', 'Thanh toán khi nhận hàng (COD)', 'adsfadsf23'),
(50, 'Thi Văn Ngọc', '2024-12-01 16:42:42', '98760000.00', 'Đang xử lý', 'P4 Q8 HCM', '0907124121', 1, 10, '2024-12-02', 'Thanh toán khi nhận hàng (COD)', ''),
(51, 'aDdấda', '2024-12-02 15:43:03', '31780000.00', 'Đã giao cho đơn vị vận chuyển', 'ádasdfdsaf', '1111111111', 1, 39, '2024-12-03', 'Thanh toán khi nhận hàng (COD)', 'G8A7Y484'),
(52, 'aDdấda', '2024-12-02 15:46:26', '33490000.00', 'Đã hoàn thành', 'ádasdfdsaf', '1111111111', 1, 39, '2024-12-03', 'Thanh toán khi nhận hàng (COD)', 'G8A7Y484'),
(53, 'Trần Văn Ngọc Thi1', '2024-12-02 16:51:57', '33490000.00', 'Đã hoàn thành', 'P4 Q8 HCM', '0123456789', 1, 38, '2024-12-03', 'Thanh toán khi nhận hàng (COD)', 'd312asdae23'),
(54, 'thy', '2024-12-03 02:16:16', '31780000.00', 'Đang xử lý', 'ádasdfdsaf', '1111111111', 1, 39, '2024-12-03', 'Thanh toán khi nhận hàng (COD)', NULL),
(55, 'xxxx', '2024-12-03 19:45:28', '15890000.00', 'Đã hủy', 'hcm', '1111111111', 1, 39, '2024-12-03', 'Thanh toán khi nhận hàng (COD)', 'G8A7Y484');

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

DROP TABLE IF EXISTS `giohang`;
CREATE TABLE IF NOT EXISTS `giohang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tongTien` decimal(15,2) DEFAULT NULL,
  `tongSoLuong` int DEFAULT NULL,
  `khachhang_id` int NOT NULL,
  PRIMARY KEY (`id`,`khachhang_id`),
  KEY `fk_giohang_khachhang1_idx` (`khachhang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `giohang`
--

INSERT INTO `giohang` (`id`, `tongTien`, `tongSoLuong`, `khachhang_id`) VALUES
(1, '0.00', 0, 7),
(3, '0.00', 0, 8),
(5, '0.00', 0, 9),
(7, '0.00', 0, 10),
(10, '0.00', 0, 11),
(12, '3720.00', 13, 12),
(14, '0.00', 0, 13),
(16, '0.00', 0, 14),
(20, '240.00', 2, 16),
(23, '0.00', 2, 19),
(24, '0.00', 0, 20),
(25, '2520.00', 7, 1),
(26, '0.00', 0, 21),
(27, '0.00', 0, 22),
(28, '0.00', 0, 23),
(29, '260.00', 1, 24),
(30, '120.00', 1, 26),
(31, '0.00', 0, 34),
(32, '0.00', 0, 30),
(33, '0.00', 0, 35),
(34, '240.00', 1, 36),
(35, '0.00', 0, 37),
(36, '0.00', 0, 38),
(37, '0.00', 0, 39);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenTaiKhoan` varchar(100) DEFAULT NULL,
  `matKhau` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `diaChi` text,
  `hoTen` varchar(100) DEFAULT NULL,
  `ngayTao` datetime DEFAULT NULL,
  `ngayCapNhat` datetime DEFAULT NULL,
  `trangThai` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`id`, `tenTaiKhoan`, `matKhau`, `email`, `sdt`, `diaChi`, `hoTen`, `ngayTao`, `ngayCapNhat`, `trangThai`) VALUES
(1, 'khách hàng', '111111', 'a@a.a', '1111111111', 'ádasDÀ', 'KHACHHANG', '2024-11-22 19:04:09', '2024-11-24 05:42:07', 0),
(2, 'khachhang', '$2y$10$yxO2VD1VyN2MnlkgZlgjjOsu1i.2dd1MND67QJs52uKupVkU3W2MO', 'tranvanthi03092001@gmail.com', '1111111111', 'asdasd1', 'aaaaaa1111', '2024-11-22 12:07:10', '2024-11-25 12:54:56', 0),
(3, 'khachhang2', '$2y$10$QDW76ChZnGrjzTEe9Sj9iuZWQuCFvGw/VaHWLVYV3tnLBcDO83n2y', 'tranvanthi030921001@gmail.com', '1111111111', 'asdasd', 'khachhang2', '2024-11-22 12:16:24', '2024-11-22 12:16:24', 1),
(4, 'khachhang3', '$2y$10$eCwzYnFoNpvLoFSAp9fUE.bqI0gpSL93Mry2UTu4gr8x06vKjx.k6', 'tranvanthi0309211001@gmail.com', '1111111111', 'asdasd', 'khachhang3', '2024-11-22 12:17:34', '2024-11-22 14:20:23', 1),
(5, 'a', '$2y$10$7JbvQAo1Q4BW5OJLC0Hx7uwEd.d0jAfdPQlDJ85rI6JUhH3Di6/8e', 'tranvanthi030s92001@gmail.com', '1111111111', 'asdasd', 'aaaaaa', '2024-11-24 09:31:04', '2024-11-24 09:31:04', 1),
(6, '1212', '$2y$10$9wOdRNZBFvAHU4ExZQC9z.ctsZ1oaLNnggaZXN7eGHglyLNroBkse', 'emlgwal@hot2mail.com', '1111111111', 'asdasd', '121212', '2024-11-24 09:32:58', '2024-11-24 09:32:58', 1),
(7, 'nhanvien4', '$2y$10$LGZbbTi0/O6vb4veR.joROiy2KsTheYD0bL84kGVmyGPRu4KeBCOy', 'tranvanthi0223092001@gmail.com', '1111111111', 'asdasd', 'aaaaaa', '2024-11-24 09:34:46', '2024-11-24 09:34:46', 1),
(8, 'khachhang5', '$2y$10$1Ddcb8vBLIeM4SZKT/IGu.FU5ClXCwVSU4cebDGA1j55A5D4FEOum', 'tranvanthi030920011@gmail.com', '1111111111', 'asdasd', 'khach hang 5', '2024-11-24 09:36:44', '2024-11-24 09:36:44', 1),
(9, 'khachhang6', '$2y$10$BDBolb6n/jhF8Eqhsky48.DSt.PQHFGBy6LYpUbBMcQxQyS.DMu06', 'tranvanthi03120920011@gmail.com', '1111111111', 'asdasd', 'khach hang 6', '2024-11-24 09:41:52', '2024-11-24 09:41:52', 1),
(10, 'khachhang11', '$2y$10$bJqYYJ8rQtCAtCRXTSBuWeQkvimEv266VKHlaMl8dCnHp7QoPGriG', 'emlgwal@hotmail.com11', '1111111111', 'asdasd', '11', '2024-11-24 10:06:54', '2024-11-24 10:06:54', 1),
(11, 'khachhang22', '$2y$10$ZeAxBw5vV9r38095Ks1gvu5h78fSnkXtaLn/OVe.r1N3JkUJiksdu', 'emlgwal@hotmail.c', '1111111111', 'asdasd', 'khach hang22', '2024-11-24 11:19:21', '2024-11-24 11:19:21', 1),
(12, 'khachhang33', '$2y$10$dyUrU1vhaIHFrgJ2VcTOCutGaffUDA8vv9j.hcZzGRltIm3db/UKW', 'tranvan2001@gmail.com', '1111111111', 'asdasd', 'khach hang 33', '2024-11-24 11:32:57', '2024-11-24 11:32:57', 1),
(13, 'khachhang44', '$2y$10$WK/.jATiMq5Cw39xQoYVw.7tCbZnjsYzvbdUO4pPeTGvhS5x6aC46', 'tranva292001@gmail.com', '1111111111', 'asdasd', 'khach hang44', '2024-11-25 00:10:13', '2024-11-25 00:10:13', 1),
(14, 'khachhang55', '$2y$10$cFjkSNLk3JIrR1385EU.TOGKlCTZ1Q56kqdC8157tpkHI7BAVAwBG', 'tr2i03092001@gmail.com', '1111111111', 'asdasd', 'khach hang55', '2024-11-25 00:11:29', '2024-11-25 00:11:29', 1),
(15, 'khachhang12', '$2y$10$oP7VW4UZlK6BPHxZqilDnuZEu0XtaDJcovdDG5RQtO8Lk/eCs.Hje', 'tranv1001@gmail.com', '1111111111', 'asdasd', 'khach hang12', '2024-11-25 00:22:43', '2024-11-25 00:22:43', 1),
(16, 'khachhang13', '$2y$10$u0l9KM95LdPzdei5NLny6uzm87okKs8oVLmplOPACVVaeBc644L9q', 'tra11101@gmail.com', '1111111111', '111', 'khach hang13', '2024-11-25 00:25:21', '2024-11-25 00:25:21', 1),
(17, 'khachhang14', '$2y$10$fVMlbeTql90lZmpKYxDrKel7B6GA/M3FQdELK.4Jp/jCauhnkuWn.', 'tr1a101@gmail.com', '1111111111', 'asdasd', 'khach hang14', '2024-11-25 02:45:59', '2024-11-25 02:45:59', 1),
(18, 'khachhang15', '$2y$10$2gP967Se3w6mNlx2wNGxN.BGxldXQtcmGVmISDxyZipNThTTLMhiS', 'tranvaz92001@gmail.com', '1111111111', 'asdasd1', 'khach hang15', '2024-11-25 02:56:06', '2024-11-25 02:56:06', 1),
(19, 'khachhang16', '$2y$10$N53KO1aaZW0quc3HeA/5aOzP.MMBMRoGMxOfTGXYqiDtvr0ApuzfW', 'tranvaz920101@gmail.com', '1111111111', 'asdasd1', 'khach hang16', '2024-11-25 03:02:06', '2024-11-25 03:02:06', 1),
(20, 'khachhang17', '$2y$10$UEIh4puY67Gdekml.TlP1.6gmaSuF55uq2pYMXED5unR8JHnkxjve', 'tr11@gmail.com', '1111111111', 'asdasd', 'khach hang17', '2024-11-25 12:43:40', '2024-11-25 12:43:40', 1),
(21, 'khachhang18', '$2y$10$rRmE/.W8IzsRzA.qQkPcXuIwxEeb8u0d4CCiJzjmMtyTCPA3UMbqq', 'tr1@gmail.com', '1111111111', 'asdasd', 'khach hang18', '2024-11-25 14:23:43', '2024-11-25 14:23:43', 1),
(22, 'khachhang20', '$2y$10$/.gkFXseLLX0gw9JJNuixehi6xUak3mEHOG2kjHN6hfuvgR2WDdUy', 'emlgwal@ho1', '1111111111', 'asdasd', 'khach hang20', '2024-11-25 16:01:03', '2024-11-25 16:01:03', 1),
(23, 'khachhang21', '$2y$10$ZgoO6LklnarGmCoc0ZjJEu/qq5e5dsSIDDHudDjfgeNIBI8YTiB6G', 'tr2hi03092001@gmail.com', '1111111111', 'asdasd1', 'khach hang21', '2024-11-25 17:00:10', '2024-11-25 17:00:10', 1),
(24, 'ngocthi', '$2y$10$dqqmfN8vzh/vB5yXygHE2OmWK.9/8R3PYx./gnYODDFYK6Az3.ibe', '1@gmail.com', '1111111111', 'P4 Q8 HCM', 'Trần Văn Ngọc Thi', '2024-11-25 17:44:31', '2024-11-25 17:44:31', 1),
(25, 'khachhang111', '$2y$10$6qY5WwwmJvBxMK6VbSdsteZSrK5J2KbSo3y580x5E8ez1XpZk6arC', '11@gmail.com', '1111111111', 'P4 Q8 HCM', 'khach hang111', '2024-11-26 09:16:40', '2024-11-26 09:16:49', 1),
(26, 'khachhang23', '$2y$10$Dzf2vivqUB4cBjVAum2x5O4ajPovcFZQihWqrYVgsdquVTIkdp9Z.', 'tranvanthi03091@gmail.com', '1111111111', 'P4 Q8 HCM', 'khach hang23', '2024-11-26 10:48:16', '2024-11-26 10:48:16', 1),
(27, 'khachhang24', '$2y$10$NbSiOvqX9vBXJgJBWeUMVe0K6f/9LS/7O5xfTzJTbXy66KVKFzC3u', 'tranvans91@gmail.com', '1111111111', 'P4 Q8 HCM', 'khach hang24', '2024-11-26 11:06:35', '2024-11-26 11:06:35', 1),
(28, 'khachhang242', '$2y$10$p5mTH3zaxwkgKutQCDLzKecPjzay19lm6IA9WV1CXw8MJc1WkjXW.', '12123@gmail.com', '1111111111', 'P4 Q8 HCM', 'khach hang242', '2024-11-26 11:20:04', '2024-11-26 11:20:04', 1),
(29, 'khachhang2421', '$2y$10$47PBcAtBCqdxBzWWiwtCWeVozcXCS0wtjSF8J1RCkmVPX4TlnKxzG', '121123@gmail.com', '1111111111', 'P4 Q8 HCM', 'khach hang242', '2024-11-26 11:25:50', '2024-11-26 11:25:50', 1),
(30, 'khachhang123', '$2y$10$joZSuEjaG8hVNStn7kMrSuZmknLfOC2qIi6r.gub0XdSaOpd.lLTm', 'tranvans91@g1mail.com', '1111111111', 'P4 Q8 HCM', 'khach hang123', '2024-11-26 17:33:54', '2024-11-26 17:33:54', 1),
(31, 'khachhang1234', '$2y$10$H2gsg1PrVVdLgGTEdf2d9eRkDGacFBg1uPSyyY35rFcXRMBFGZoxC', 'tranvans91@g14mail.com', '1111111111', 'P4 Q8 HCM', 'khach hang1234', '2024-11-26 17:52:00', '2024-11-26 17:52:00', 1),
(32, 'khachhang12345', '$2y$10$3RCnSs95KKFLRzL5McbVde45kjhtWUs10MUMKMni5NQVU39etUebG', 'tranvans91@g145mail.com', '1111111111', 'P4 Q8 HCM', 'khach hang12345', '2024-11-26 18:10:03', '2024-11-26 18:10:03', 1),
(33, 'khachhang123456', '$2y$10$udFuetXBR4K.P8zqpPM3I.IKCJ5GPN8dcuO0D7603WOyzCpDTeUDW', 'tranvans91@g1456mail.com', '1111111111', 'P4 Q8 HCM', 'khach hang123456', '2024-11-26 18:11:04', '2024-11-26 18:11:04', 1),
(34, 'x', '$2y$10$RB3qVT3QpUITEgaNFA/2POAL8nvW.TuB.xyKeSIaW5JpXhWGssF5S', 'cxl@hotmail.com', '1111111111', 'P4 Q8 HCM', 'x', '2024-11-26 18:24:48', '2024-11-26 18:24:48', 1),
(35, 'Nhi', '$2y$10$gk4ESC8HZ9ZzYqZhmNTqD.76GOSZVJwFqOeKsejUQgacvtuIGxfuG', '101@gmail.com', '1111111111', 'P4 Q8 HCM', 'P NHI', '2024-11-27 10:58:17', '2024-11-27 10:58:17', 1),
(36, 'thideptrai', '$2y$10$aLUAT0bf.TwQ.iWimfRyyeimblZVeLKmiRvALx9EIauJQPXZbjr.O', 'trdw@gmail.com', '1111111111', 'P4 Q8 HCM', 'Trần Văn Ngọc Thi', '2024-11-27 19:28:51', '2024-11-27 19:28:51', 1),
(37, 'thithi', '$2y$10$GtrKxsyyA0GauEemyCly1uhu3p3SwsbuIdOVy2p4EWAf6ejcUNQtm', 'tranvanthi030920011111@gmail.com', '1111111111', 'P4 Q8 HCM', 'Trần Văn Ngọc Thi1', '2024-11-27 20:32:00', '2024-11-27 20:32:00', 1),
(38, 'khachthi', '$2y$10$0SH6PhX/vthwk6GgLmd6bOBYJ2nhVevrPBfwwcp32GdtlsufIZvFe', '12123@gmail.com1', '0123456789', 'P4 Q8 HCM', 'Trần Văn Ngọc Thi1', '2024-11-28 21:30:12', '2024-11-28 21:30:12', 1),
(39, 'khachhang331', '$2y$10$n3xCPMaBZhb9Ix/zkynhEuiw/21MuSESYvjk9rxHHZ0bVQ0eYYcu2', '11111x@gmail.com', '1111111111', 'ádasdfdsaf', 'aDdấda', '2024-12-02 15:23:07', '2024-12-02 15:23:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `magiamgia`
--

DROP TABLE IF EXISTS `magiamgia`;
CREATE TABLE IF NOT EXISTS `magiamgia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `giaTri` float DEFAULT NULL,
  `ngayBatDau` datetime DEFAULT NULL,
  `ngayKetThuc` datetime DEFAULT NULL,
  `trangThai` varchar(50) DEFAULT NULL,
  `ma` text NOT NULL,
  `donhang_id` int NOT NULL,
  PRIMARY KEY (`id`,`donhang_id`),
  KEY `fk_magiamgia_donhang1_idx` (`donhang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

DROP TABLE IF EXISTS `nhanvien`;
CREATE TABLE IF NOT EXISTS `nhanvien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenTaiKhoan` varchar(100) DEFAULT NULL,
  `matKhau` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `diaChi` text,
  `hoTen` varchar(100) DEFAULT NULL,
  `vaiTro` varchar(50) DEFAULT NULL,
  `ngayTao` datetime DEFAULT NULL,
  `ngayCapNhat` datetime DEFAULT NULL,
  `trangThai` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`id`, `tenTaiKhoan`, `matKhau`, `email`, `sdt`, `diaChi`, `hoTen`, `vaiTro`, `ngayTao`, `ngayCapNhat`, `trangThai`) VALUES
(1, 'admin', '$2y$10$dj1/gK0CrMIlMOKDyRDPHuIuZ3X6nBNjv3R0Awl7TN4GPZgghu1Gi', 'tranvanthi03092001@gmail.com', '0902342566', 'asdasd', 'ADMIN', 'admin', '2024-11-22 12:06:16', '2024-12-01 15:28:14', 1),
(4, 'admin1', '$2y$10$psz7lJzBce.EBqWElOyGbuDoLUHvKRvGQUH6OjJ4CFoiolwR5Nl9K', 'emlgwal@hotmail.com', '1111111111', 'asdasd', 'admin1', 'admin', '2024-11-25 03:13:11', '2024-11-25 17:53:41', 1),
(6, 'nv2', '$2y$10$iAxiHrPDaM4.BifK8q1rdOVRgAc6bu0LukUOgrA/pqcXT9p.5b3Sy', 'tranvanthi030920012@gmail.com', '1111111111', 'P4 Q8 HCM', 'nhan vien 2', 'nhanvien', '2024-11-25 17:55:44', '2024-11-25 17:55:44', 1),
(7, 'nv3', '$2y$10$86O2FegKXLhTKDDPDTqOEeBowk57emtMYhPdLlxbQxJjuEMeQplKG', 'tranvanthi030920013@gmail.com', '1111111111', 'P4 Q8 HCM', 'nhan vien 3', 'nhanvien', '2024-11-25 17:55:58', '2024-11-25 17:55:58', 1),
(8, 'ql1', '$2y$10$EVLwbvJVVtugm1U9Y5JVueSaCXiAF9VAQn/hHI.mzGdxTG/80Ps2i', 'tranvanthi030920014@gmail.com', '1111111111', 'P4 Q8 HCM', 'quan ly1', 'quanly', '2024-11-25 17:56:30', '2024-11-25 17:56:30', 1),
(9, 'ql2', '$2y$10$WdG9vywjSy9cqBeRcyKCP.X0PcBtszDbBt7Ex0bybn2Po3Muk7voa', 'tranvanthi030920015@gmail.com', '1111111111', 'P4 Q8 HCM', 'quan ly2', 'quanly', '2024-11-25 17:56:47', '2024-11-25 17:56:47', 1),
(10, 'quanly1', '$2y$10$nRlutQogKBh72xln0V2BReLoNbPTiPJBi.2iKAPLufbF97ccr6ZeS', 't1r1@gmail.com', '2347562347', 'asdasd', 'quan ly11', 'quanly', '2024-11-26 09:15:51', '2024-12-03 16:43:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien_has_suachuabaotri`
--

DROP TABLE IF EXISTS `nhanvien_has_suachuabaotri`;
CREATE TABLE IF NOT EXISTS `nhanvien_has_suachuabaotri` (
  `nhanvien_id` int NOT NULL,
  `suachuabaotri_id` int NOT NULL,
  PRIMARY KEY (`nhanvien_id`,`suachuabaotri_id`),
  KEY `fk_nhanvien_has_suachuabaotri_suachuabaotri1_idx` (`suachuabaotri_id`),
  KEY `fk_nhanvien_has_suachuabaotri_nhanvien1_idx` (`nhanvien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieuxuathang`
--

DROP TABLE IF EXISTS `phieuxuathang`;
CREATE TABLE IF NOT EXISTS `phieuxuathang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ngayXuat` datetime DEFAULT NULL,
  `trangThai` varchar(50) DEFAULT NULL,
  `donhang_id` int NOT NULL,
  `nhanvien_id` int NOT NULL,
  `ngayTao` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_phieuxuathang_donhang1_idx` (`donhang_id`),
  KEY `fk_nhanvien` (`nhanvien_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `phieuxuathang`
--

INSERT INTO `phieuxuathang` (`id`, `ngayXuat`, `trangThai`, `donhang_id`, `nhanvien_id`, `ngayTao`) VALUES
(29, '2024-12-01 22:19:00', 'đã xuất', 49, 1, '2024-12-01 15:22:23'),
(30, '2024-12-01 22:19:00', 'đã xuất', 49, 1, '2024-12-01 15:22:42'),
(31, '2024-12-01 22:19:00', 'đã xuất', 49, 1, '2024-12-01 15:22:48'),
(32, '2024-12-01 23:43:00', 'đã xuất', 50, 1, '2024-12-01 16:43:36'),
(33, '2024-12-04 02:46:00', 'đã xuất', 55, 1, '2024-12-03 19:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenSanPham` varchar(100) DEFAULT NULL,
  `moTa` text,
  `gia` decimal(15,0) DEFAULT NULL,
  `hinhAnh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `ngayTao` datetime DEFAULT NULL,
  `ngayCapNhat` datetime DEFAULT NULL,
  `soLuong` int DEFAULT NULL,
  `trangThai` tinyint(1) DEFAULT NULL,
  `danhmuc_id` int NOT NULL,
  PRIMARY KEY (`id`,`danhmuc_id`),
  KEY `fk_sanpham_danhmuc1_idx` (`danhmuc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `tenSanPham`, `moTa`, `gia`, `hinhAnh`, `ngayTao`, `ngayCapNhat`, `soLuong`, `trangThai`, `danhmuc_id`) VALUES
(150, 'Laptop ASUS Vivobook 15 X1504ZA-NJ582W', 'Nguyên hộp, đầy đủ phụ kiện từ nhà sản suất\r\nBảo hành pin 12 tháng\r\nBảo hành 24 tháng tại trung tâm bảo hành Chính hãng. 1 đổi 1 trong 30 ngày nếu có lỗi phần cứng từ nhà sản xuất. (xem chi tiết)\r\nGiá sản phẩm đã bao gồm VAT', '15890000', '[\"1733070987-Screenshot 2024-12-01 233310.png\",\"1733070987-Screenshot 2024-12-01 233344.png\",\"1733070987-Screenshot 2024-12-01 233357.png\",\"1733070987-Screenshot 2024-12-01 233410.png\",\"1733070987-Screenshot 2024-12-01 233423.png\",\"1733070987-Screenshot 2024-12-01 233440.png\",\"1733070987-Screenshot 2024-12-01 233518.png\",\"1733070987-Screenshot 2024-12-01 233535.png\",\"1733070987-Screenshot 2024-12-01 233557.png\",\"1733071051-Screenshot 2024-12-01 233609.png\"]', '2024-12-01 16:36:27', '2024-12-01 16:37:31', 43, 0, 19),
(151, 'iPhone 16 Pro Max 256GB | Chính hãng VN/A', 'Máy mới 100% , chính hãng Apple Việt Nam.\r\nCellphoneS hiện là đại lý bán lẻ uỷ quyền iPhone chính hãng VN/A của Apple Việt Nam\r\niPhone sử dụng iOS 18, Cáp Sạc USB‑C (1m), Tài liệu\r\n1 ĐỔI 1 trong 30 ngày nếu có lỗi phần cứng nhà sản xuất. Bảo hành 12 tháng tại trung tâm bảo hành chính hãng Apple: CareS.vn(xem chi tiết)\r\nGiá sản phẩm đã bao gồm VAT', '33490000', '[\"1733071266-Screenshot 2024-12-01 233935.png\",\"1733071266-Screenshot 2024-12-01 234001.png\",\"1733071266-Screenshot 2024-12-01 234013.png\",\"1733071266-Screenshot 2024-12-01 234024.png\",\"1733071266-Screenshot 2024-12-01 234036.png\",\"1733071266-Screenshot 2024-12-01 234049.png\"]', '2024-12-01 16:41:06', '2024-12-01 16:41:06', 46, 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham_has_chitietdonhang`
--

DROP TABLE IF EXISTS `sanpham_has_chitietdonhang`;
CREATE TABLE IF NOT EXISTS `sanpham_has_chitietdonhang` (
  `sanpham_id` int NOT NULL,
  `chitietdonhang_id` int NOT NULL,
  `soLuong` int NOT NULL,
  PRIMARY KEY (`sanpham_id`,`chitietdonhang_id`),
  KEY `fk_sanpham_has_chitietdonhang_chitietdonhang1_idx` (`chitietdonhang_id`),
  KEY `fk_sanpham_has_chitietdonhang_sanpham1_idx` (`sanpham_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sanpham_has_chitietdonhang`
--

INSERT INTO `sanpham_has_chitietdonhang` (`sanpham_id`, `chitietdonhang_id`, `soLuong`) VALUES
(150, 38, 2),
(150, 40, 2),
(150, 43, 2),
(150, 44, 1),
(151, 39, 2),
(151, 41, 1),
(151, 42, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham_has_chitietgiohang`
--

DROP TABLE IF EXISTS `sanpham_has_chitietgiohang`;
CREATE TABLE IF NOT EXISTS `sanpham_has_chitietgiohang` (
  `sanpham_id` int NOT NULL,
  `soLuong` int DEFAULT '0',
  `chitietgiohang_id` int NOT NULL,
  PRIMARY KEY (`sanpham_id`,`chitietgiohang_id`),
  KEY `fk_sanpham_has_chitietgiohang_chitietgiohang1_idx` (`chitietgiohang_id`),
  KEY `fk_sanpham_has_chitietgiohang_sanpham1_idx` (`sanpham_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanpham_has_sukien`
--

DROP TABLE IF EXISTS `sanpham_has_sukien`;
CREATE TABLE IF NOT EXISTS `sanpham_has_sukien` (
  `sanpham_id` int NOT NULL,
  `sukien_id` int NOT NULL,
  PRIMARY KEY (`sanpham_id`,`sukien_id`),
  KEY `fk_sanpham_has_sukien_sukien1_idx` (`sukien_id`),
  KEY `fk_sanpham_has_sukien_sanpham1_idx` (`sanpham_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seri`
--

DROP TABLE IF EXISTS `seri`;
CREATE TABLE IF NOT EXISTS `seri` (
  `id` int NOT NULL AUTO_INCREMENT,
  `maSeri` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `chitietphieuxuat_id` int NOT NULL,
  `yeucautrahang_id` int DEFAULT NULL,
  `yeucaudoihang_id` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_seri_chitietphieuxuat1_idx` (`chitietphieuxuat_id`),
  KEY `fk_seri_yeucautrahang1_idx` (`yeucautrahang_id`),
  KEY `fk_seri_yeucaudoihang1_idx` (`yeucaudoihang_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `seri`
--

INSERT INTO `seri` (`id`, `maSeri`, `chitietphieuxuat_id`, `yeucautrahang_id`, `yeucaudoihang_id`) VALUES
(30, '432867489071234897', 28, NULL, NULL),
(31, '789423018947092817', 28, NULL, NULL),
(32, '708234790123874123', 29, NULL, NULL),
(33, '982319048812374890', 29, NULL, NULL),
(34, '34214231dasfgh', 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seri_has_suachuabaotri`
--

DROP TABLE IF EXISTS `seri_has_suachuabaotri`;
CREATE TABLE IF NOT EXISTS `seri_has_suachuabaotri` (
  `seri_id` int NOT NULL,
  `suachuabaotri_id` int NOT NULL,
  PRIMARY KEY (`seri_id`,`suachuabaotri_id`),
  KEY `fk_seri_has_suachuabaotri_suachuabaotri1_idx` (`suachuabaotri_id`),
  KEY `fk_seri_has_suachuabaotri_seri1_idx` (`seri_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suachuabaotri`
--

DROP TABLE IF EXISTS `suachuabaotri`;
CREATE TABLE IF NOT EXISTS `suachuabaotri` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ngayNhan` datetime DEFAULT NULL,
  `ngayDuKienHoanThanh` datetime DEFAULT NULL,
  `ngayHoanThanh` datetime DEFAULT NULL,
  `chiPhi` decimal(10,2) DEFAULT NULL,
  `moTaLoi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `tinhTrangKhiNhanSanPham` varchar(100) DEFAULT NULL,
  `trangThai` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sukien`
--

DROP TABLE IF EXISTS `sukien`;
CREATE TABLE IF NOT EXISTS `sukien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenSuKien` varchar(100) DEFAULT NULL,
  `moTaSuKien` text,
  `thoiGianBatDau` datetime DEFAULT NULL,
  `thoiGianKetThuc` datetime DEFAULT NULL,
  `loaiSuKien` varchar(50) DEFAULT NULL,
  `trangThai` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thanhtoan`
--

DROP TABLE IF EXISTS `thanhtoan`;
CREATE TABLE IF NOT EXISTS `thanhtoan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `phuongThuc` varchar(50) DEFAULT NULL,
  `trangThaiGiaoDich` varchar(50) DEFAULT NULL,
  `soTien` decimal(10,2) DEFAULT NULL,
  `maGiaoDichNganHang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ngayGiaoDich` datetime DEFAULT NULL,
  `donhang_id` int NOT NULL,
  `maGiaoDichMomo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_thanhtoan_donhang1_idx` (`donhang_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thongbao`
--

DROP TABLE IF EXISTS `thongbao`;
CREATE TABLE IF NOT EXISTS `thongbao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tieuDe` varchar(255) DEFAULT NULL,
  `noiDung` text,
  `ngayTao` datetime DEFAULT NULL,
  `trangThai` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thongbao_has_khachhang`
--

DROP TABLE IF EXISTS `thongbao_has_khachhang`;
CREATE TABLE IF NOT EXISTS `thongbao_has_khachhang` (
  `thongbao_id` int NOT NULL,
  `khachhang_id` int NOT NULL,
  PRIMARY KEY (`thongbao_id`,`khachhang_id`),
  KEY `fk_thongbao_has_khachhang_khachhang1_idx` (`khachhang_id`),
  KEY `fk_thongbao_has_khachhang_thongbao1_idx` (`thongbao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thongbao_has_nhanvien`
--

DROP TABLE IF EXISTS `thongbao_has_nhanvien`;
CREATE TABLE IF NOT EXISTS `thongbao_has_nhanvien` (
  `thongbao_id` int NOT NULL,
  `nhanvien_id` int NOT NULL,
  PRIMARY KEY (`thongbao_id`,`nhanvien_id`),
  KEY `fk_thongbao_has_nhanvien_nhanvien1_idx` (`nhanvien_id`),
  KEY `fk_thongbao_has_nhanvien_thongbao1_idx` (`thongbao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `yeucaudoihang`
--

DROP TABLE IF EXISTS `yeucaudoihang`;
CREATE TABLE IF NOT EXISTS `yeucaudoihang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ngayYeuCau` datetime DEFAULT NULL,
  `hinhAnh` text,
  `lyDo` text,
  `phiDoiHang` decimal(10,2) DEFAULT NULL,
  `trangThai` tinyint(1) DEFAULT NULL,
  `soLuong` int DEFAULT NULL,
  `giaTri` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `yeucautrahang`
--

DROP TABLE IF EXISTS `yeucautrahang`;
CREATE TABLE IF NOT EXISTS `yeucautrahang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ngayYeuCau` datetime DEFAULT NULL,
  `lyDo` text,
  `hinhAnh` text,
  `trangThai` tinyint(1) DEFAULT NULL,
  `soLuongTra` int DEFAULT NULL,
  `giaTriTra` decimal(10,2) DEFAULT NULL,
  `soTienHoanTra` decimal(10,2) DEFAULT NULL,
  `ngayHoanTien` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baocaothongke`
--
ALTER TABLE `baocaothongke`
  ADD CONSTRAINT `fk_baocaothongke_nhanvien` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`);

--
-- Constraints for table `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `fk_donhang` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`);

--
-- Constraints for table `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD CONSTRAINT `fk_chitietgiohang_giohang1` FOREIGN KEY (`giohang_id`) REFERENCES `giohang` (`id`);

--
-- Constraints for table `chitietphieuxuat`
--
ALTER TABLE `chitietphieuxuat`
  ADD CONSTRAINT `fk_chitietphieuxuat_chitietdonhang1` FOREIGN KEY (`chitietdonhang_id`) REFERENCES `chitietdonhang` (`id`),
  ADD CONSTRAINT `fk_chitietphieuxuat_phieuxuathang1` FOREIGN KEY (`phieuxuathang_id`) REFERENCES `phieuxuathang` (`id`),
  ADD CONSTRAINT `fk_chitietphieuxuat_yeucaudoihang1` FOREIGN KEY (`yeucaudoihang_id`) REFERENCES `yeucaudoihang` (`id`),
  ADD CONSTRAINT `fk_chitietphieuxuat_yeucautrahang1` FOREIGN KEY (`yeucautrahang_id`) REFERENCES `yeucautrahang` (`id`);

--
-- Constraints for table `chitietphieuxuat_has_suachuabaotri`
--
ALTER TABLE `chitietphieuxuat_has_suachuabaotri`
  ADD CONSTRAINT `fk_chitietphieuxuat_has_suachuabaotri_chitietphieuxuat1` FOREIGN KEY (`chitietphieuxuat_id`) REFERENCES `chitietphieuxuat` (`id`),
  ADD CONSTRAINT `fk_chitietphieuxuat_has_suachuabaotri_suachuabaotri1` FOREIGN KEY (`suachuabaotri_id`) REFERENCES `suachuabaotri` (`id`);

--
-- Constraints for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `fk_danhgia_khachhang1` FOREIGN KEY (`khachhang_id`) REFERENCES `khachhang` (`id`),
  ADD CONSTRAINT `fk_danhgia_sanpham1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`);

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `fk_donhang_khachhang1` FOREIGN KEY (`khachhang_id`) REFERENCES `khachhang` (`id`),
  ADD CONSTRAINT `fk_donhang_nhanvien1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`),
  ADD CONSTRAINT `fk_donhang_nhanvien1_idx` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `fk_giohang_khachhang1` FOREIGN KEY (`khachhang_id`) REFERENCES `khachhang` (`id`);

--
-- Constraints for table `magiamgia`
--
ALTER TABLE `magiamgia`
  ADD CONSTRAINT `fk_magiamgia_donhang1` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`);

--
-- Constraints for table `nhanvien_has_suachuabaotri`
--
ALTER TABLE `nhanvien_has_suachuabaotri`
  ADD CONSTRAINT `fk_nhanvien_has_suachuabaotri_nhanvien1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`),
  ADD CONSTRAINT `fk_nhanvien_has_suachuabaotri_suachuabaotri1` FOREIGN KEY (`suachuabaotri_id`) REFERENCES `suachuabaotri` (`id`);

--
-- Constraints for table `phieuxuathang`
--
ALTER TABLE `phieuxuathang`
  ADD CONSTRAINT `fk_nhanvien` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`),
  ADD CONSTRAINT `fk_phieuxuathang_donhang1` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sanpham_danhmuc1` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sanpham_has_chitietdonhang`
--
ALTER TABLE `sanpham_has_chitietdonhang`
  ADD CONSTRAINT `fk_sanpham_has_chitietdonhang_chitietdonhang1` FOREIGN KEY (`chitietdonhang_id`) REFERENCES `chitietdonhang` (`id`),
  ADD CONSTRAINT `fk_sanpham_has_chitietdonhang_sanpham1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`);

--
-- Constraints for table `sanpham_has_chitietgiohang`
--
ALTER TABLE `sanpham_has_chitietgiohang`
  ADD CONSTRAINT `fk_sanpham_has_chitietgiohang_chitietgiohang1` FOREIGN KEY (`chitietgiohang_id`) REFERENCES `chitietgiohang` (`id`),
  ADD CONSTRAINT `fk_sanpham_has_chitietgiohang_sanpham1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`);

--
-- Constraints for table `sanpham_has_sukien`
--
ALTER TABLE `sanpham_has_sukien`
  ADD CONSTRAINT `fk_sanpham_has_sukien_sanpham1` FOREIGN KEY (`sanpham_id`) REFERENCES `sanpham` (`id`),
  ADD CONSTRAINT `fk_sanpham_has_sukien_sukien1` FOREIGN KEY (`sukien_id`) REFERENCES `sukien` (`id`);

--
-- Constraints for table `seri`
--
ALTER TABLE `seri`
  ADD CONSTRAINT `fk_seri_chitietphieuxuat1` FOREIGN KEY (`chitietphieuxuat_id`) REFERENCES `chitietphieuxuat` (`id`),
  ADD CONSTRAINT `fk_seri_yeucaudoihang1` FOREIGN KEY (`yeucaudoihang_id`) REFERENCES `yeucaudoihang` (`id`),
  ADD CONSTRAINT `fk_seri_yeucautrahang1` FOREIGN KEY (`yeucautrahang_id`) REFERENCES `yeucautrahang` (`id`);

--
-- Constraints for table `seri_has_suachuabaotri`
--
ALTER TABLE `seri_has_suachuabaotri`
  ADD CONSTRAINT `fk_seri_has_suachuabaotri_seri1` FOREIGN KEY (`seri_id`) REFERENCES `seri` (`id`),
  ADD CONSTRAINT `fk_seri_has_suachuabaotri_suachuabaotri1` FOREIGN KEY (`suachuabaotri_id`) REFERENCES `suachuabaotri` (`id`);

--
-- Constraints for table `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `fk_thanhtoan_donhang1` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`);

--
-- Constraints for table `thongbao_has_khachhang`
--
ALTER TABLE `thongbao_has_khachhang`
  ADD CONSTRAINT `fk_thongbao_has_khachhang_khachhang1` FOREIGN KEY (`khachhang_id`) REFERENCES `khachhang` (`id`),
  ADD CONSTRAINT `fk_thongbao_has_khachhang_thongbao1` FOREIGN KEY (`thongbao_id`) REFERENCES `thongbao` (`id`);

--
-- Constraints for table `thongbao_has_nhanvien`
--
ALTER TABLE `thongbao_has_nhanvien`
  ADD CONSTRAINT `fk_thongbao_has_nhanvien_nhanvien1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`),
  ADD CONSTRAINT `fk_thongbao_has_nhanvien_thongbao1` FOREIGN KEY (`thongbao_id`) REFERENCES `thongbao` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
