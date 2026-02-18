-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2025 at 10:03 PM
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
-- Database: `dmm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(2, 'pawan', 'pawan@gmail.com', 'jvh', '2025-10-19 19:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'cod',
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `email`, `phone`, `address`, `total`, `payment_method`, `status`, `created_at`) VALUES
(1, 'pawan', 'pawan@gmail.com', '3565465465', 'dfdfwd454wd5qwd54qwas', 5000.00, 'cod', 'Pending', '2025-10-19 18:07:47'),
(2, 'pawan', 'pawan@gmail.com', '3565465465', 'vhfjg', 4700.00, 'cod', 'Pending', '2025-10-19 19:07:16'),
(3, 'hi', 'pawan@gmail.com', '3565465465', 'hhhhhhhhhhhhhh', 2700.00, 'cod', 'Pending', '2025-10-19 19:26:23'),
(4, 'hi', 'hlo@gmauil.com', '54654654', 'hvgnbgkj', 2700.00, 'cod', 'confirmed', '2025-10-19 19:36:41'),
(5, 'hi', 'hlo@gmauil.com', '54654654', 'v hmjhb', 4700.00, 'cod', 'confirmed', '2025-10-19 19:37:10'),
(6, 'hi', 'hlo@gmauil.com', '54654654', 'v hmjhb', 0.00, 'cod', 'confirmed', '2025-10-19 19:37:29'),
(7, 'jjj', 'hlo@gmauil.com', '3565465465', 'bh', 2700.00, 'cod', 'Pending', '2025-10-19 19:38:23'),
(8, 'pawankkkkkkkkk', 'hlo@gmauil.com', '3565465465', 'ujjjjjjjjjjj', 4700.00, 'cod', 'Pending', '2025-10-19 19:45:44'),
(9, 'pawankkkkkkkkk', 'hlo@gmauil.com', '3565465465', 'ujjjjjjjjjjj', 0.00, 'cod', 'Pending', '2025-10-19 19:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `saree_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `saree_id`, `quantity`, `price`) VALUES
(1, 1, 73, 1, 2500.00),
(2, 1, 69, 1, 2500.00),
(3, 2, 109, 1, 2700.00),
(4, 2, 90, 1, 2000.00),
(5, 3, 110, 1, 2700.00),
(6, 4, 110, 1, 2700.00),
(7, 5, 111, 1, 2700.00),
(8, 5, 92, 1, 2000.00),
(9, 7, 111, 1, 2700.00),
(10, 8, 110, 1, 2700.00),
(11, 8, 91, 1, 2000.00);

-- --------------------------------------------------------

--
-- Table structure for table `sarees`
--

CREATE TABLE `sarees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `stock` int(11) DEFAULT 10,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sarees`
--

INSERT INTO `sarees` (`id`, `name`, `price`, `image`, `stock`, `type`) VALUES
(69, 'Pure Silk Saree 1', 2500.00, 'silk/1.jpeg', 10, 'pure_silk'),
(70, 'Pure Silk Saree 2', 2500.00, 'silk/2.jpeg', 10, 'pure_silk'),
(71, 'Pure Silk Saree 3', 2500.00, 'silk/3.jpeg', 10, 'pure_silk'),
(72, 'Pure Silk Saree 4', 2500.00, 'silk/4.jpeg', 10, 'pure_silk'),
(73, 'Pure Silk Saree 5', 2500.00, 'silk/5.jpeg', 10, 'pure_silk'),
(74, 'Pure Silk Saree 6', 2500.00, 'silk/6.jpeg', 10, 'pure_silk'),
(75, 'Pure Silk Saree 7', 2500.00, 'silk/7.jpeg', 10, 'pure_silk'),
(76, 'Pure Silk Saree 8', 2500.00, 'silk/8.jpeg', 10, 'pure_silk'),
(77, 'Pure Silk Saree 9', 2500.00, 'silk/9.jpeg', 10, 'pure_silk'),
(78, 'Pure Silk Saree 10', 2500.00, 'silk/10.jpeg', 10, 'pure_silk'),
(79, 'Pure Silk Saree 11', 2500.00, 'silk/11.jpeg', 10, 'pure_silk'),
(80, 'Pure Silk Saree 12', 2500.00, 'silk/12.jpeg', 10, 'pure_silk'),
(81, 'Pure Silk Saree 13', 2500.00, 'silk/13.jpeg', 10, 'pure_silk'),
(82, 'Pure Silk Saree 14', 2500.00, 'silk/14.jpeg', 10, 'pure_silk'),
(83, 'Pure Silk Saree 15', 2500.00, 'silk/15.jpeg', 10, 'pure_silk'),
(84, 'Pure Silk Saree 16', 2500.00, 'silk/16.jpeg', 10, 'pure_silk'),
(85, 'Pure Silk Saree 17', 2500.00, 'silk/17.jpeg', 10, 'pure_silk'),
(86, 'Pure Silk Saree 18', 2500.00, 'silk/18.jpeg', 10, 'pure_silk'),
(87, 'Pure Silk Saree 19', 2500.00, 'silk/19.jpeg', 10, 'pure_silk'),
(88, 'Pure Silk Saree 20', 2500.00, 'silk/20.jpeg', 10, 'pure_silk'),
(89, 'Banaras Silk Saree 1', 2000.00, 'banaras/21.jpeg', 10, 'banaras'),
(90, 'Banaras Silk Saree 2', 2000.00, 'banaras/22.jpeg', 10, 'banaras'),
(91, 'Banaras Silk Saree 3', 2000.00, 'banaras/23.jpeg', 10, 'banaras'),
(92, 'Banaras Silk Saree 4', 2000.00, 'banaras/24.jpeg', 10, 'banaras'),
(93, 'Banaras Silk Saree 5', 2000.00, 'banaras/25.jpeg', 10, 'banaras'),
(94, 'Banaras Silk Saree 6', 2000.00, 'banaras/26.jpeg', 10, 'banaras'),
(95, 'Banaras Silk Saree 7', 2000.00, 'banaras/27.jpeg', 10, 'banaras'),
(96, 'Banaras Silk Saree 8', 2000.00, 'banaras/28.jpeg', 10, 'banaras'),
(97, 'Banaras Silk Saree 9', 2000.00, 'banaras/29.jpeg', 10, 'banaras'),
(98, 'Banaras Silk Saree 10', 2000.00, 'banaras/30.jpeg', 10, 'banaras'),
(99, 'Banaras Silk Saree 11', 2000.00, 'banaras/31.jpeg', 10, 'banaras'),
(100, 'Banaras Silk Saree 12', 2000.00, 'banaras/32.jpeg', 10, 'banaras'),
(101, 'Banaras Silk Saree 13', 2000.00, 'banaras/33.jpeg', 10, 'banaras'),
(102, 'Banaras Silk Saree 14', 2000.00, 'banaras/34.jpeg', 10, 'banaras'),
(103, 'Banaras Silk Saree 15', 2000.00, 'banaras/35.jpeg', 10, 'banaras'),
(104, 'Banaras Silk Saree 16', 2000.00, 'banaras/36.jpeg', 10, 'banaras'),
(105, 'Banaras Silk Saree 17', 2000.00, 'banaras/37.jpeg', 10, 'banaras'),
(106, 'Banaras Silk Saree 18', 2000.00, 'banaras/38.jpeg', 10, 'banaras'),
(107, 'Banaras Silk Saree 19', 2000.00, 'banaras/39.jpeg', 10, 'banaras'),
(108, 'Banaras Silk Saree 20', 2000.00, 'banaras/40.jpeg', 10, 'banaras'),
(109, 'Kanchipuram Silk Saree 1', 2700.00, 'kanchipuram/41.jpeg', 10, 'kanchipuram'),
(110, 'Kanchipuram Silk Saree 2', 2700.00, 'kanchipuram/42.jpeg', 10, 'kanchipuram'),
(111, 'Kanchipuram Silk Saree 3', 2700.00, 'kanchipuram/43.jpeg', 10, 'kanchipuram'),
(112, 'Kanchipuram Silk Saree 4', 2700.00, 'kanchipuram/44.jpeg', 10, 'kanchipuram'),
(113, 'Kanchipuram Silk Saree 5', 2700.00, 'kanchipuram/45.jpeg', 10, 'kanchipuram'),
(114, 'Kanchipuram Silk Saree 6', 2700.00, 'kanchipuram/46.jpeg', 10, 'kanchipuram'),
(115, 'Kanchipuram Silk Saree 7', 2700.00, 'kanchipuram/47.jpeg', 10, 'kanchipuram'),
(116, 'Kanchipuram Silk Saree 8', 2700.00, 'kanchipuram/48.jpeg', 10, 'kanchipuram'),
(117, 'Kanchipuram Silk Saree 9', 2700.00, 'kanchipuram/49.jpeg', 10, 'kanchipuram'),
(118, 'Kanchipuram Silk Saree 10', 2700.00, 'kanchipuram/50.jpeg', 10, 'kanchipuram'),
(119, 'Kanchipuram Silk Saree 11', 2700.00, 'kanchipuram/51.jpeg', 10, 'kanchipuram'),
(120, 'Kanchipuram Silk Saree 12', 2700.00, 'kanchipuram/52.jpeg', 10, 'kanchipuram'),
(121, 'Kanchipuram Silk Saree 13', 2700.00, 'kanchipuram/53.jpeg', 10, 'kanchipuram'),
(122, 'Kanchipuram Silk Saree 14', 2700.00, 'kanchipuram/54.jpeg', 10, 'kanchipuram'),
(123, 'Kanchipuram Silk Saree 15', 2700.00, 'kanchipuram/55.jpeg', 10, 'kanchipuram'),
(124, 'Kanchipuram Silk Saree 16', 2700.00, 'kanchipuram/56.jpeg', 10, 'kanchipuram'),
(125, 'Kanchipuram Silk Saree 17', 2700.00, 'kanchipuram/57.jpeg', 10, 'kanchipuram'),
(126, 'Kanchipuram Silk Saree 18', 2700.00, 'kanchipuram/58.jpeg', 10, 'kanchipuram'),
(127, 'Kanchipuram Silk Saree 19', 2700.00, 'kanchipuram/59.jpeg', 10, 'kanchipuram'),
(128, 'Kanchipuram Silk Saree 20', 2700.00, 'kanchipuram/60.jpeg', 10, 'kanchipuram'),
(129, 'Venkatagiri Saree 1', 2600.00, 'venkatagiri/121.jpg', 10, 'venkatagiri'),
(130, 'Venkatagiri Saree 2', 2600.00, 'venkatagiri/122.jpg', 10, 'venkatagiri'),
(131, 'Venkatagiri Saree 3', 2600.00, 'venkatagiri/123.jpg', 10, 'venkatagiri'),
(132, 'Venkatagiri Saree 4', 2600.00, 'venkatagiri/124.jpg', 10, 'venkatagiri'),
(133, 'Venkatagiri Saree 5', 2600.00, 'venkatagiri/125.jpg', 10, 'venkatagiri'),
(134, 'Venkatagiri Saree 6', 2600.00, 'venkatagiri/126.jpg', 10, 'venkatagiri'),
(135, 'Venkatagiri Saree 7', 2600.00, 'venkatagiri/127.jpg', 10, 'venkatagiri'),
(136, 'Venkatagiri Saree 8', 2600.00, 'venkatagiri/128.jpg', 10, 'venkatagiri'),
(137, 'Venkatagiri Saree 9', 2600.00, 'venkatagiri/129.jpg', 10, 'venkatagiri'),
(138, 'Venkatagiri Saree 10', 2600.00, 'venkatagiri/130.jpg', 10, 'venkatagiri'),
(139, 'Venkatagiri Saree 11', 2600.00, 'venkatagiri/131.jpg', 10, 'venkatagiri'),
(140, 'Venkatagiri Saree 12', 2600.00, 'venkatagiri/132.jpg', 10, 'venkatagiri'),
(141, 'Venkatagiri Saree 13', 2600.00, 'venkatagiri/133.jpg', 10, 'venkatagiri'),
(142, 'Venkatagiri Saree 14', 2600.00, 'venkatagiri/134.jpg', 10, 'venkatagiri'),
(143, 'Venkatagiri Saree 15', 2600.00, 'venkatagiri/135.jpg', 10, 'venkatagiri'),
(144, 'Venkatagiri Saree 16', 2600.00, 'venkatagiri/136.jpg', 10, 'venkatagiri'),
(145, 'Venkatagiri Saree 17', 2600.00, 'venkatagiri/137.jpg', 10, 'venkatagiri'),
(146, 'Venkatagiri Saree 18', 2600.00, 'venkatagiri/138.jpg', 10, 'venkatagiri'),
(147, 'Venkatagiri Saree 19', 2600.00, 'venkatagiri/139.jpg', 10, 'venkatagiri'),
(148, 'Venkatagiri Saree 20', 2600.00, 'venkatagiri/140.jpg', 10, 'venkatagiri'),
(149, 'Kuppadam Saree 1', 2400.00, 'kuppadam/141.jpg', 10, 'kuppadam'),
(150, 'Kuppadam Saree 2', 2400.00, 'kuppadam/142.jpg', 10, 'kuppadam'),
(151, 'Kuppadam Saree 3', 2400.00, 'kuppadam/143.jpg', 10, 'kuppadam'),
(152, 'Kuppadam Saree 4', 2400.00, 'kuppadam/144.jpg', 10, 'kuppadam'),
(153, 'Kuppadam Saree 5', 2400.00, 'kuppadam/145.jpg', 10, 'kuppadam'),
(154, 'Kuppadam Saree 6', 2400.00, 'kuppadam/146.jpg', 10, 'kuppadam'),
(155, 'Kuppadam Saree 7', 2400.00, 'kuppadam/147.jpg', 10, 'kuppadam'),
(156, 'Kuppadam Saree 8', 2400.00, 'kuppadam/148.jpg', 10, 'kuppadam'),
(157, 'Kuppadam Saree 9', 2400.00, 'kuppadam/149.jpg', 10, 'kuppadam'),
(158, 'Kuppadam Saree 10', 2400.00, 'kuppadam/150.jpg', 10, 'kuppadam'),
(159, 'Kuppadam Saree 11', 2400.00, 'kuppadam/151.jpg', 10, 'kuppadam'),
(160, 'Kuppadam Saree 12', 2400.00, 'kuppadam/152.jpg', 10, 'kuppadam'),
(161, 'Kuppadam Saree 13', 2400.00, 'kuppadam/153.jpg', 10, 'kuppadam'),
(162, 'Kuppadam Saree 14', 2400.00, 'kuppadam/154.jpg', 10, 'kuppadam'),
(163, 'Kuppadam Saree 15', 2400.00, 'kuppadam/155.jpg', 10, 'kuppadam'),
(164, 'Kuppadam Saree 16', 2400.00, 'kuppadam/156.jpg', 10, 'kuppadam'),
(165, 'Kuppadam Saree 17', 2400.00, 'kuppadam/157.jpg', 10, 'kuppadam'),
(166, 'Kuppadam Saree 18', 2400.00, 'kuppadam/158.jpg', 10, 'kuppadam'),
(167, 'Kuppadam Saree 19', 2400.00, 'kuppadam/159.jpg', 10, 'kuppadam'),
(168, 'Kuppadam Saree 20', 2400.00, 'kuppadam/160.jpg', 10, 'kuppadam'),
(169, 'Upada Saree 1', 2300.00, 'upada/161.jpg', 10, 'upada'),
(170, 'Upada Saree 2', 2300.00, 'upada/162.jpg', 10, 'upada'),
(171, 'Upada Saree 3', 2300.00, 'upada/163.jpg', 10, 'upada'),
(172, 'Upada Saree 4', 2300.00, 'upada/164.jpg', 10, 'upada'),
(173, 'Upada Saree 5', 2300.00, 'upada/165.jpg', 10, 'upada'),
(174, 'Upada Saree 6', 2300.00, 'upada/166.jpg', 10, 'upada'),
(175, 'Upada Saree 7', 2300.00, 'upada/167.jpg', 10, 'upada'),
(176, 'Upada Saree 8', 2300.00, 'upada/168.jpg', 10, 'upada'),
(177, 'Upada Saree 9', 2300.00, 'upada/169.jpg', 10, 'upada'),
(178, 'Upada Saree 10', 2300.00, 'upada/170.jpg', 10, 'upada'),
(179, 'Upada Saree 11', 2300.00, 'upada/171.jpg', 10, 'upada'),
(180, 'Upada Saree 12', 2300.00, 'upada/172.jpg', 10, 'upada'),
(181, 'Upada Saree 13', 2300.00, 'upada/173.jpg', 10, 'upada'),
(182, 'Upada Saree 14', 2300.00, 'upada/174.jpg', 10, 'upada'),
(183, 'Upada Saree 15', 2300.00, 'upada/175.jpg', 10, 'upada'),
(184, 'Upada Saree 16', 2300.00, 'upada/176.jpg', 10, 'upada'),
(185, 'Upada Saree 17', 2300.00, 'upada/177.jpg', 10, 'upada'),
(186, 'Upada Saree 18', 2300.00, 'upada/178.jpg', 10, 'upada'),
(187, 'Upada Saree 19', 2300.00, 'upada/179.jpg', 10, 'upada'),
(188, 'Upada Saree 20', 2300.00, 'upada/180.jpg', 10, 'upada'),
(189, 'Pochampally Saree 1', 2200.00, 'pochampally/181.jpg', 10, 'pochampally'),
(190, 'Pochampally Saree 2', 2200.00, 'pochampally/182.jpg', 10, 'pochampally'),
(191, 'Pochampally Saree 3', 2200.00, 'pochampally/183.jpg', 10, 'pochampally'),
(192, 'Pochampally Saree 4', 2200.00, 'pochampally/184.jpg', 10, 'pochampally'),
(193, 'Pochampally Saree 5', 2200.00, 'pochampally/185.jpg', 10, 'pochampally'),
(194, 'Pochampally Saree 6', 2200.00, 'pochampally/186.jpg', 10, 'pochampally'),
(195, 'Pochampally Saree 7', 2200.00, 'pochampally/187.jpg', 10, 'pochampally'),
(196, 'Pochampally Saree 8', 2200.00, 'pochampally/188.jpg', 10, 'pochampally'),
(197, 'Pochampally Saree 9', 2200.00, 'pochampally/189.jpg', 10, 'pochampally'),
(198, 'Pochampally Saree 10', 2200.00, 'pochampally/190.jpg', 10, 'pochampally'),
(199, 'Pochampally Saree 11', 2200.00, 'pochampally/191.jpg', 10, 'pochampally'),
(200, 'Pochampally Saree 12', 2200.00, 'pochampally/192.jpg', 10, 'pochampally'),
(201, 'Pochampally Saree 13', 2200.00, 'pochampally/193.jpg', 10, 'pochampally'),
(202, 'Pochampally Saree 14', 2200.00, 'pochampally/194.jpg', 10, 'pochampally'),
(203, 'Pochampally Saree 15', 2200.00, 'pochampally/195.jpg', 10, 'pochampally'),
(204, 'Pochampally Saree 16', 2200.00, 'pochampally/196.jpg', 10, 'pochampally'),
(205, 'Pochampally Saree 17', 2200.00, 'pochampally/197.jpg', 10, 'pochampally'),
(206, 'Pochampally Saree 18', 2200.00, 'pochampally/198.jpg', 10, 'pochampally'),
(207, 'Pochampally Saree 19', 2200.00, 'pochampally/199.jpg', 10, 'pochampally'),
(208, 'Pochampally Saree 20', 2200.00, 'pochampally/200.jpg', 10, 'pochampally'),
(209, 'Gadwal Saree 1', 2800.00, 'gadwal/201.jpg', 10, 'gadwal'),
(210, 'Gadwal Saree 2', 2800.00, 'gadwal/202.jpg', 10, 'gadwal'),
(211, 'Gadwal Saree 3', 2800.00, 'gadwal/203.jpg', 10, 'gadwal'),
(212, 'Gadwal Saree 4', 2800.00, 'gadwal/204.jpg', 10, 'gadwal'),
(213, 'Gadwal Saree 5', 2800.00, 'gadwal/205.jpg', 10, 'gadwal'),
(214, 'Gadwal Saree 6', 2800.00, 'gadwal/206.jpg', 10, 'gadwal'),
(215, 'Gadwal Saree 7', 2800.00, 'gadwal/207.jpg', 10, 'gadwal'),
(216, 'Gadwal Saree 8', 2800.00, 'gadwal/208.jpg', 10, 'gadwal'),
(217, 'Gadwal Saree 9', 2800.00, 'gadwal/209.jpg', 10, 'gadwal'),
(218, 'Gadwal Saree 10', 2800.00, 'gadwal/210.jpg', 10, 'gadwal'),
(219, 'Gadwal Saree 11', 2800.00, 'gadwal/211.jpg', 10, 'gadwal'),
(220, 'Gadwal Saree 12', 2800.00, 'gadwal/212.jpg', 10, 'gadwal'),
(221, 'Gadwal Saree 13', 2800.00, 'gadwal/213.jpg', 10, 'gadwal'),
(222, 'Gadwal Saree 14', 2800.00, 'gadwal/214.jpg', 10, 'gadwal'),
(223, 'Gadwal Saree 15', 2800.00, 'gadwal/215.jpg', 10, 'gadwal'),
(224, 'Gadwal Saree 16', 2800.00, 'gadwal/216.jpg', 10, 'gadwal'),
(225, 'Gadwal Saree 17', 2800.00, 'gadwal/217.jpg', 10, 'gadwal'),
(226, 'Gadwal Saree 18', 2800.00, 'gadwal/218.jpg', 10, 'gadwal'),
(227, 'Gadwal Saree 19', 2800.00, 'gadwal/219.jpg', 10, 'gadwal'),
(228, 'Gadwal Saree 20', 2800.00, 'gadwal/220.jpg', 10, 'gadwal');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'pawan', 'kumar', 'pawankothvalamvgr@gmail.com', '9398697842', '$2y$10$3qfy.hl2xG2FAd2vKsXtl.wuFOQ9l9A2Ojf472I2b7C8a2PVuLkcS', '2025-10-19 08:47:11'),
(2, 'pawan', 'kumar', 'pawankothavalamvgr@gmail.com', '9398697842', '$2y$10$ezrkVL..O0Xwk0KWxjJo6.DXvBKoup1tJVLfBacnSl/2Wzlgh1UmC', '2025-10-19 08:49:49'),
(3, 'manoj', 'lakkoju', 'manojlakkoju008@gmail.com', '9398697842', '$2y$10$ILwttlVi6pAwk3EuJsijieN58bd0Zm66NZZO/qC4SOnHFEXz0hXuq', '2025-10-19 18:13:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sarees`
--
ALTER TABLE `sarees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sarees`
--
ALTER TABLE `sarees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
