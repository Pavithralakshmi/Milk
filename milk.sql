-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2019 at 01:50 PM
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
-- Database: `milk`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_report`
--

CREATE TABLE `access_report` (
  `id` int(11) NOT NULL,
  `uname` text NOT NULL,
  `pass` text NOT NULL,
  `page` text NOT NULL,
  `datetime` datetime NOT NULL,
  `ip` text NOT NULL,
  `success` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `access_report`
--

INSERT INTO `access_report` (`id`, `uname`, `pass`, `page`, `datetime`, `ip`, `success`) VALUES
(1, 'shiva', 'shiva', 'magalir_mattum', '2019-02-28 09:17:14', '::1', 'YES'),
(2, 'Shiva', 'Shiva', 'magalir_mattum', '2019-02-28 09:28:22', '::1', 'YES'),
(3, 'boopathi ', 'boopathi4200', 'magalir_mattum', '2019-02-28 09:31:25', '::1', 'YES'),
(4, 'Shiva', 'Shiva', 'magalir_mattum', '2019-02-28 09:34:21', '::1', 'YES'),
(5, 'Shiva', 'Shiva', 'magalir_mattum', '2019-02-28 11:26:11', '::1', 'YES'),
(6, 'Shiva', 'Shiva', 'magalir_mattum', '2019-02-28 16:14:48', '::1', 'YES'),
(7, 'Shiva', 'Shiva', 'magalir_mattum', '2019-02-28 16:54:09', '::1', 'YES'),
(8, 'admin', 'admin', 'magalir_mattum', '2019-02-28 17:08:54', '192.168.57.1', 'NO'),
(9, 'shiva', 'shiva', 'magalir_mattum', '2019-02-28 17:09:05', '192.168.57.1', 'YES'),
(10, 'shiva', 'shiva', 'magalir_mattum', '2019-02-28 17:31:24', '192.168.57.30', 'YES'),
(11, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-02 09:36:52', '::1', 'YES'),
(12, 'shiva', 'shiva', 'magalir_mattum', '2019-03-02 11:38:45', '192.168.57.30', 'YES'),
(13, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-02 12:12:07', '::1', 'YES'),
(14, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-04 09:30:18', '::1', 'YES'),
(15, 'admin', 'admin', 'magalir_mattum', '2019-03-04 13:50:34', '::1', 'YES'),
(16, 'shiva', 'shiva', 'magalir_mattum', '2019-03-04 15:34:14', '192.168.57.30', 'YES'),
(17, 'shiva', 'shiva', 'magalir_mattum', '2019-03-04 16:43:11', '192.168.57.30', 'YES'),
(18, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-05 09:29:28', '::1', 'YES'),
(19, 'shiva', 'shiva', 'magalir_mattum', '2019-03-05 10:51:07', '192.168.57.30', 'YES'),
(20, 'shiva', 'shiva', 'magalir_mattum', '2019-03-05 10:51:07', '192.168.57.30', 'YES'),
(21, 'shiva', 'shiva', 'magalir_mattum', '2019-03-05 15:09:43', '192.168.57.30', 'YES'),
(22, 'Shiva', 'shiva', 'magalir_mattum', '2019-03-06 09:45:02', '::1', 'NO'),
(23, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-06 09:45:12', '::1', 'YES'),
(24, 'shiva', 'shiva', 'magalir_mattum', '2019-03-06 13:51:20', '192.168.57.30', 'YES'),
(25, 'shiva', 'shiva', 'magalir_mattum', '2019-03-06 13:51:20', '192.168.57.30', 'YES'),
(26, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-07 09:43:12', '::1', 'YES'),
(27, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-11 09:31:26', '::1', 'YES'),
(28, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-12 09:27:07', '::1', 'YES'),
(29, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-13 09:39:27', '::1', 'YES'),
(30, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-13 13:57:25', '::1', 'YES'),
(31, 'shiva', 'shiva', 'magalir_mattum', '2019-03-14 11:30:50', '192.168.57.30', 'YES'),
(32, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-14 09:29:28', '::1', 'YES'),
(33, 'shiva', 'Shiva', 'magalir_mattum', '2019-03-15 09:39:55', '::1', 'NO'),
(34, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-15 09:40:09', '::1', 'YES'),
(35, 'shiva', 'shiva', 'magalir_mattum', '2019-03-15 17:45:40', '192.168.57.30', 'YES'),
(36, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-16 09:59:46', '::1', 'YES'),
(37, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-16 12:07:05', '::1', 'YES'),
(38, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-16 17:36:07', '::1', 'YES'),
(39, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-18 09:37:09', '::1', 'YES'),
(40, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-18 09:40:34', '::1', 'YES'),
(41, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-18 09:44:16', '::1', 'YES'),
(42, 'shiva', 'shiva', 'magalir_mattum', '2019-03-18 12:13:14', '192.168.57.1', 'YES'),
(43, 'Shiva', 'shiva', 'magalir_mattum', '2019-03-18 17:26:20', '192.168.57.1', 'NO'),
(44, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-18 17:26:41', '192.168.57.1', 'YES'),
(45, 'admin', 'admin', 'magalir_mattum', '2019-03-18 17:54:34', '::1', 'YES'),
(46, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-19 09:17:25', '::1', 'YES'),
(47, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-19 09:38:43', '::1', 'YES'),
(48, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-19 10:58:52', '::1', 'YES'),
(49, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-19 13:31:20', '::1', 'YES'),
(50, 'admin', 'admin', 'magalir_mattum', '2019-03-19 16:07:23', '192.168.57.180', 'YES'),
(51, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-19 16:14:45', '::1', 'YES'),
(52, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-19 17:32:46', '::1', 'YES'),
(53, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-20 09:41:24', '::1', 'YES'),
(54, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-20 14:42:44', '::1', 'YES'),
(55, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-21 09:26:43', '::1', 'YES'),
(56, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-21 11:07:51', '::1', 'YES'),
(57, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-21 18:16:10', '::1', 'YES'),
(58, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-23 09:14:14', '::1', 'YES'),
(59, 'shiva', 'shiva', 'magalir_mattum', '2019-03-23 10:06:00', '192.168.57.30', 'YES'),
(60, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-23 10:53:46', '::1', 'YES'),
(61, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-23 16:44:01', '::1', 'YES'),
(62, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-25 09:04:15', '::1', 'YES'),
(63, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-25 10:56:14', '::1', 'YES'),
(64, 'admin', 'admin', 'magalir_mattum', '2019-03-25 13:55:27', '192.168.57.27', 'YES'),
(65, 'ADMIN', 'admin', 'magalir_mattum', '2019-03-25 13:55:40', '192.168.57.27', 'NO'),
(66, 'admin', 'admin', 'magalir_mattum', '2019-03-25 13:55:48', '192.168.57.27', 'YES'),
(67, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-25 15:35:03', '::1', 'YES'),
(68, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-26 09:13:56', '::1', 'YES'),
(69, 'admin', 'admin', 'magalir_mattum', '2019-03-26 09:46:48', '192.168.57.26', 'YES'),
(70, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-26 15:36:33', '::1', 'YES'),
(71, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-26 17:23:52', '::1', 'YES'),
(72, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-26 17:28:37', '::1', 'YES'),
(73, 'Shiva', 'shiva', 'magalir_mattum', '2019-03-27 09:12:35', '::1', 'NO'),
(74, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-27 09:12:46', '::1', 'YES'),
(75, 'shiva', 'shiva', 'magalir_mattum', '2019-03-27 11:07:16', '192.168.57.1', 'YES'),
(76, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-27 12:04:13', '::1', 'YES'),
(77, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-27 13:58:59', '::1', 'YES'),
(78, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-28 09:15:41', '::1', 'YES'),
(79, 'shiva', 'shiva', 'magalir_mattum', '2019-03-28 09:47:56', '192.168.57.30', 'YES'),
(80, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-29 09:24:47', '::1', 'YES'),
(81, 'shiva', 'shiva', 'magalir_mattum', '2019-03-29 12:07:12', '192.168.57.30', 'YES'),
(82, 'shiva', 'shiva', 'magalir_mattum', '2019-03-29 15:10:11', '192.168.57.30', 'YES'),
(83, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-30 09:37:34', '::1', 'YES'),
(84, 'Shiva', 'Shiva', 'magalir_mattum', '2019-03-30 17:29:55', '::1', 'YES'),
(85, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-01 09:21:16', '::1', 'YES'),
(86, 'admin', 'admin', 'magalir_mattum', '2019-04-01 10:58:13', '::1', 'YES'),
(87, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-01 10:59:31', '::1', 'YES'),
(88, 'admin', 'admin', 'magalir_mattum', '2019-04-01 16:38:53', '192.168.57.26', 'YES'),
(89, 'shiva', 'shiva', 'magalir_mattum', '2019-04-02 13:01:41', '192.168.57.30', 'YES'),
(90, 'shiva', 'shiva', 'magalir_mattum', '2019-04-02 14:01:49', '192.168.57.30', 'YES'),
(91, 'shiva', 'shiva', 'magalir_mattum', '2019-04-02 14:04:37', '192.168.57.30', 'YES'),
(92, 'admin', '123!@#NithrA', 'magalir_mattum', '2019-04-02 14:08:05', '103.70.188.79', 'NO'),
(93, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-02 14:10:42', '103.70.188.79', 'YES'),
(94, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-02 14:37:37', '103.70.188.79', 'YES'),
(95, 'Bpc_milk', 'M%Cow', 'magalir_mattum', '2019-04-02 15:46:30', '117.211.49.25', 'NO'),
(96, 'bpc_milk', 'M%Cow', 'magalir_mattum', '2019-04-02 15:47:12', '117.211.49.25', 'NO'),
(97, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-02 15:48:44', '117.211.49.25', 'YES'),
(98, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-02 16:36:45', '103.70.188.79', 'YES'),
(99, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-03 09:06:23', '117.211.49.25', 'YES'),
(100, 'admin', '123!@#NithrA', 'magalir_mattum', '2019-04-03 12:42:48', '103.70.188.79', 'NO'),
(101, 'admin', '123!@#NithrA', 'magalir_mattum', '2019-04-03 12:42:49', '103.70.188.79', 'NO'),
(102, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-03 12:44:20', '103.70.188.79', 'YES'),
(103, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-03 14:59:14', '117.211.49.31', 'YES'),
(104, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-03 15:00:32', '103.70.188.79', 'YES'),
(105, 'bpc_milk', 'Milk%Cow', 'magalir_mattum', '2019-04-03 15:27:46', '103.70.188.79', 'YES'),
(106, 'bpc_milk', 'cow%milk', 'magalir_mattum', '2019-04-04 16:26:40', '::1', 'NO'),
(107, 'admin', 'aqdmin', 'magalir_mattum', '2019-04-04 16:26:48', '::1', 'NO'),
(108, 'admin', 'aqdmin', 'magalir_mattum', '2019-04-04 16:26:54', '::1', 'NO'),
(109, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-04 16:27:09', '::1', 'YES'),
(110, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-04 16:55:26', '::1', 'YES'),
(111, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-05 09:27:12', '::1', 'YES'),
(112, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-06 10:44:54', '::1', 'YES'),
(113, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-08 09:20:38', '::1', 'YES'),
(114, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-08 14:12:54', '::1', 'YES'),
(115, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-08 17:55:40', '::1', 'YES'),
(116, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-11 10:31:22', '::1', 'YES'),
(117, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-11 13:59:59', '::1', 'YES'),
(118, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-12 09:35:33', '::1', 'YES'),
(119, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-15 09:52:09', '::1', 'YES'),
(120, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-16 09:35:15', '::1', 'YES'),
(121, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-17 09:20:08', '::1', 'YES'),
(122, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-17 14:27:34', '::1', 'YES'),
(123, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-19 09:15:48', '::1', 'YES'),
(124, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-20 09:08:57', '::1', 'YES'),
(125, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-20 17:08:17', '::1', 'YES'),
(126, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-22 09:28:25', '::1', 'YES'),
(127, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-23 09:17:31', '::1', 'YES'),
(128, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-23 15:25:34', '::1', 'YES'),
(129, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-23 15:52:47', '::1', 'YES'),
(130, 'shiva', 'shiva', 'magalir_mattum', '2019-04-23 16:37:34', '192.168.57.1', 'YES'),
(131, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-24 09:29:56', '::1', 'YES'),
(132, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-24 11:03:40', '192.168.57.26', 'YES'),
(133, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-25 09:17:29', '::1', 'YES'),
(134, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-26 09:11:18', '::1', 'YES'),
(135, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-29 09:37:09', '::1', 'YES'),
(136, 'Shiva', 'Shiva', 'magalir_mattum', '2019-04-30 09:36:35', '::1', 'YES'),
(137, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-03 09:38:05', '::1', 'YES'),
(138, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-04 09:33:40', '::1', 'YES'),
(139, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-04 12:32:59', '192.168.57.25', 'YES'),
(140, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-04 12:48:21', '192.168.57.27', 'YES'),
(141, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-04 14:24:46', '192.168.57.27', 'YES'),
(142, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-04 14:47:18', '192.168.57.180', 'YES'),
(143, 'shiva', 'shiva', 'magalir_mattum', '2019-05-04 15:39:04', '192.168.57.1', 'YES'),
(144, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-06 09:49:01', '::1', 'YES'),
(145, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-07 09:27:45', '::1', 'YES'),
(146, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-07 18:08:13', '::1', 'YES'),
(147, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-08 09:37:27', '::1', 'YES'),
(148, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-09 09:36:17', '::1', 'YES'),
(149, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-10 09:00:13', '::1', 'YES'),
(150, 'Shiva', 'shiva', 'magalir_mattum', '2019-05-10 14:05:37', '192.168.57.26', 'NO'),
(151, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-10 14:05:55', '192.168.57.26', 'YES'),
(152, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-13 09:37:33', '::1', 'YES'),
(153, 'shiva', 'shiva', 'magalir_mattum', '2019-05-13 17:12:56', '192.168.57.30', 'YES'),
(154, 'Shiva', 'SHIVA', 'magalir_mattum', '2019-05-13 17:35:39', '192.168.57.26', 'NO'),
(155, 'Shiva', 'SHIVA', 'magalir_mattum', '2019-05-13 17:36:06', '192.168.57.26', 'NO'),
(156, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-13 17:36:22', '192.168.57.26', 'YES'),
(157, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-14 09:37:23', '::1', 'YES'),
(158, 'shiva', 'shiva', 'magalir_mattum', '2019-05-14 11:52:01', '192.168.57.30', 'YES'),
(159, 'shiva', 'shiva', 'magalir_mattum', '2019-05-14 18:32:47', '192.168.57.30', 'YES'),
(160, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-15 09:42:43', '::1', 'YES'),
(161, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-16 09:45:09', '::1', 'YES'),
(162, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-17 10:02:09', '::1', 'YES'),
(163, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-17 12:31:55', '192.168.57.1', 'YES'),
(164, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-17 16:36:53', '::1', 'YES'),
(165, 'shiva', 'shiva', 'magalir_mattum', '2019-05-17 18:13:26', '192.168.57.30', 'YES'),
(166, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-18 09:58:48', '::1', 'YES'),
(167, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-18 14:12:53', '::1', 'YES'),
(168, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-18 16:51:09', '192.168.57.26', 'YES'),
(169, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-20 09:49:33', '::1', 'YES'),
(170, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-20 13:01:06', '::1', 'YES'),
(171, 'Shiva', 'sHIVA', 'magalir_mattum', '2019-05-21 09:29:53', '::1', 'NO'),
(172, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-21 09:31:25', '::1', 'YES'),
(173, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-22 09:38:54', '::1', 'YES'),
(174, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-23 09:33:13', '::1', 'YES'),
(175, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-23 09:49:46', '192.168.57.26', 'YES'),
(176, 'Shiva', 'shiva', 'magalir_mattum', '2019-05-23 12:17:30', '192.168.57.26', 'NO'),
(177, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-23 12:17:42', '192.168.57.26', 'YES'),
(178, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-23 17:04:41', '192.168.57.26', 'YES'),
(179, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-23 18:01:59', '::1', 'YES'),
(180, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-24 09:40:53', '::1', 'YES'),
(181, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-24 10:32:48', '192.168.57.26', 'YES'),
(182, 'Shiva', 'Sh9iva', 'magalir_mattum', '2019-05-27 09:38:41', '::1', 'NO'),
(183, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-27 09:38:50', '::1', 'YES'),
(184, 'shiva', 'shiva', 'magalir_mattum', '2019-05-27 12:32:08', '192.168.57.1', 'YES'),
(185, 'shiva', 'shiva', 'magalir_mattum', '2019-05-27 13:52:09', '192.168.57.30', 'YES'),
(186, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-27 14:37:28', '::1', 'YES'),
(187, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-28 09:48:29', '::1', 'YES'),
(188, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-28 10:45:20', '192.168.57.26', 'YES'),
(189, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-28 15:06:18', '192.168.57.26', 'YES'),
(190, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-28 16:56:19', '192.168.57.26', 'YES'),
(191, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-29 09:41:45', '::1', 'YES'),
(192, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-29 10:40:20', '::1', 'YES'),
(193, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-29 16:47:54', '192.168.57.26', 'YES'),
(194, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-30 09:37:18', '::1', 'YES'),
(195, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-30 13:47:40', '192.168.57.26', 'YES'),
(196, 'Shiva', 'Shiva', 'magalir_mattum', '2019-05-31 09:35:06', '::1', 'YES'),
(197, 'Shiva', 'Shiva', 'magalir_mattum', '2019-06-01 09:43:12', '::1', 'YES'),
(198, 'Shiva', 'Shiva', 'magalir_mattum', '2019-06-04 09:43:54', '::1', 'YES'),
(199, 'shiva', 'shiva', 'magalir_mattum', '2019-06-04 14:59:21', '192.168.57.30', 'YES'),
(200, 'shiva', 'shiva', 'magalir_mattum', '2019-06-04 15:04:42', '192.168.57.30', 'YES'),
(201, 'shiva', 'shiva', 'magalir_mattum', '2019-06-04 16:18:23', '::1', 'YES'),
(202, 'Shiva', 'Shiva', 'magalir_mattum', '2019-06-05 09:17:43', '::1', 'YES'),
(203, 'Shiva', 'Shiva', 'magalir_mattum', '2019-06-05 10:18:33', '192.168.57.180', 'YES'),
(204, 'shiva', 'shiva', 'magalir_mattum', '2019-06-05 19:03:19', '192.168.57.30', 'YES'),
(205, 'Shiva', 'Shiva', 'magalir_mattum', '2019-06-06 09:38:42', '::1', 'YES'),
(206, 'Shiva', 'Shiva', 'magalir_mattum', '2019-06-06 16:02:14', '192.168.57.180', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `breedtype`
--

CREATE TABLE `breedtype` (
  `id` int(20) NOT NULL,
  `breedtype` varchar(255) NOT NULL,
  `cowtype` int(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `breedtype`
--

INSERT INTO `breedtype` (`id`, `breedtype`, `cowtype`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'Nattu Madu', 1, '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 'Sinthu Madu', 1, '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'Nattu Erumai', 2, '0000-00-00 00:00:00', '', '', '', '', ''),
(6, 'Test', 1, '0000-00-00 00:00:00', '', '', '', '', ''),
(7, 'tytu5', 2, '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '|2019-06-06-16:42:52', '|192.168.57.180', '|Shiva');

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `id` int(20) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `phoneno` varchar(16) NOT NULL,
  `address` mediumtext NOT NULL,
  `remark` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`id`, `date`, `name`, `phoneno`, `address`, `remark`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, '2019-04-01', ' Mess', '8637622629', 'Mess Hostel', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, '2019-05-04', 'BOOPATHI123', '8888888888', 'KUMARAMANGAKLALAM', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, '2019-05-17', ' Mohan Raj ', '9865924040', 'Namakal', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, '2019-05-23', ' JK Naveen 123', '9876543211', 'dddd', 'dd1232123', '0000-00-00 00:00:00', '', '', '', '', ''),
(5, '2019-06-04', 'JP Dhnaraj123', '8870074461', 'sss', 'sass', '0000-00-00 00:00:00', '', '', '', '', ''),
(6, '2019-06-04', 'Pavi', '7864589666', 'fgjgghj', '', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cowcolor`
--

CREATE TABLE `cowcolor` (
  `id` int(10) NOT NULL,
  `cowcolor` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cowcolor`
--

INSERT INTO `cowcolor` (`id`, `cowcolor`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'Black', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 'Brown', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'Black & White ', '0000-00-00 00:00:00', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cowreg`
--

CREATE TABLE `cowreg` (
  `id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cowcode` varchar(255) NOT NULL,
  `cowcolor` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `cowtype` varchar(20) NOT NULL,
  `breedtype` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `bdob` date DEFAULT NULL,
  `father` varchar(255) NOT NULL,
  `mother` varchar(255) NOT NULL,
  `ml` int(11) NOT NULL,
  `el` int(11) NOT NULL,
  `sold` varchar(255) NOT NULL,
  `solddate` date NOT NULL,
  `amount` int(10) NOT NULL,
  `age` int(11) NOT NULL,
  `teeth` int(11) DEFAULT NULL,
  `remark` mediumtext NOT NULL,
  `g_reg` varchar(10) NOT NULL,
  `greg` varchar(10) NOT NULL,
  `active` varchar(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cowreg`
--

INSERT INTO `cowreg` (`id`, `name`, `cowcode`, `cowcolor`, `gender`, `cowtype`, `breedtype`, `dob`, `bdob`, `father`, `mother`, `ml`, `el`, `sold`, `solddate`, `amount`, `age`, `teeth`, `remark`, `g_reg`, `greg`, `active`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'Karuppan', 'TnC001', '3', 'male', '1', '1', '2009-01-05', '0000-00-00', '', '', 0, 0, '', '2019-06-01', 0, 10, 0, 'First', '', '', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'Example', '01', '2', 'male', '1', '6', '0000-00-00', '2019-05-29', '', '', 0, 0, '', '2019-06-01', 0, 0, 6, 'ytu', '', '', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, 'Maha Lakshmi', 'TnC0054', '3', 'female', '1', '2', '2008-12-08', '0000-00-00', '', '', 5, 5, '', '2019-06-01', 0, 11, 0, '', '', '', 'Yes', '0000-00-00 00:00:00', '', '', '', '', ''),
(5, 'Komaadha', 'TnC0045', '1', 'female', '1', '1', '2011-03-01', '0000-00-00', '', '', 4, 3, '', '2019-06-01', 0, 8, 0, 'te', '', '', 'Yes', '0000-00-00 00:00:00', '', '', '', '', ''),
(6, 'kkk', 'TnC0019', '1', 'female', '2', '3', '1970-01-01', '2019-06-11', '', '5', 4, 5, '', '2019-06-04', 0, 8, 45, '56', '', '', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(7, 'Cow No1', 'C1', '3', 'female', '1', '1', '1970-01-01', '1970-01-01', '', '', 0, 0, '', '2019-06-04', 0, 0, 0, '', 'yes', '123456', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(8, 'pavi7867', '54676', '2', 'female', '1', '2', '2010-07-22', '0000-00-00', '', '6', 6, 6, '', '2019-06-06', 0, 9, 0, 'uyiyui', '', '', 'Yes', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cowsell`
--

CREATE TABLE `cowsell` (
  `id` int(10) NOT NULL,
  `product` varchar(255) NOT NULL,
  `sold_cowname` int(11) NOT NULL,
  `sold_pname` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `total_unit` int(10) NOT NULL,
  `rate` int(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `total_amount` float NOT NULL,
  `paid` float NOT NULL,
  `balance` float NOT NULL,
  `sellername` varchar(255) NOT NULL,
  `remark` mediumtext NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cowsell`
--

INSERT INTO `cowsell` (`id`, `product`, `sold_cowname`, `sold_pname`, `date`, `total_unit`, `rate`, `unit`, `total_amount`, `paid`, `balance`, `sellername`, `remark`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'cow', 4, '', '2019-06-05', 0, 0, '', 50000, 50000, 0, '5', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 'cow', 5, '', '2019-06-05', 0, 0, '', 45000, 45000, 0, '5', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'cow', 1, '', '2019-06-06', 0, 0, '', 5000, 500, 0, '2', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, 'product', 0, '5', '2019-06-05', 5, 65, '3', 325, 325, 0, '1', '', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cowtype`
--

CREATE TABLE `cowtype` (
  `id` int(20) NOT NULL,
  `cowtype` varchar(255) NOT NULL,
  `cby` varchar(255) NOT NULL,
  `cdate` date NOT NULL,
  `cip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cowtype`
--

INSERT INTO `cowtype` (`id`, `cowtype`, `cby`, `cdate`, `cip`) VALUES
(1, 'Cow', 'Shiva', '2019-03-12', '198.162.27.180'),
(2, 'Buffalo', 'Shiva', '2019-03-13', '198.162..27.180');

-- --------------------------------------------------------

--
-- Table structure for table `dailymilk`
--

CREATE TABLE `dailymilk` (
  `id` int(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `date` date DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `cowtype` varchar(255) DEFAULT NULL,
  `breedtype` varchar(255) DEFAULT NULL,
  `remark` mediumtext,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dailymilk`
--

INSERT INTO `dailymilk` (`id`, `name`, `type`, `date`, `session`, `total`, `cowtype`, `breedtype`, `remark`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, '4', 'single', '2019-06-05', 'morning', 15, '1', '2', 'd', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, NULL, 'bulk', '2019-06-05', 'evening', 50, '1', '2', 'ddd', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, '7', 'single', '2019-06-06', 'morning', 50, '1', '1', 'sss', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, '7', 'single', '2019-06-05', 'evening', 5, '1', '1', 'yi', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', ''),
(5, NULL, 'bulk', '2019-06-04', 'evening', 6, '2', '3', 'yu', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(20) NOT NULL,
  `expences` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `expences`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'Solathattu', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 'Feeds Exp', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'Kadalai Kodi', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, 'Medical Exp', '0000-00-00 00:00:00', '', '', '', '', ''),
(7, 'qwerty', '0000-00-00 00:00:00', '', '', '', '', ''),
(8, 'qwertyuo8u9', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(10) NOT NULL,
  `buyer_id` int(10) NOT NULL,
  `cowsell_id` int(10) NOT NULL,
  `milksell_id` int(10) NOT NULL,
  `product` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `paid` float NOT NULL,
  `balance` float NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `payment_mode` varchar(233) DEFAULT NULL,
  `cby` varchar(255) DEFAULT NULL,
  `cdate` date NOT NULL,
  `cip` varchar(255) DEFAULT NULL,
  `mdate` date NOT NULL,
  `mip` varchar(255) DEFAULT NULL,
  `mby` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `buyer_id`, `cowsell_id`, `milksell_id`, `product`, `amount`, `paid`, `balance`, `remarks`, `payment_date`, `payment_mode`, `cby`, `cdate`, `cip`, `mdate`, `mip`, `mby`) VALUES
(1, 2, 3, 0, 'cow', 5000, 500, 4500, '67', '2019-06-06', 'bank', '', '0000-00-00', '::1', '0000-00-00', NULL, NULL),
(2, 2, 0, 2, 'Nattu Erumai Milk', 450, 50, 400, '5767', '2019-06-06', 'cash', '', '0000-00-00', '::1', '0000-00-00', NULL, NULL),
(3, 1, 4, 0, 'product', 0, 325, 0, 'yju', '2019-06-06', 'cash', 'Shiva', '2019-06-06', '192.168.57.180', '0000-00-00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inward`
--

CREATE TABLE `inward` (
  `id` int(10) NOT NULL,
  `inwardno` int(10) NOT NULL,
  `sellername` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `voucharno` int(12) NOT NULL,
  `expences` varchar(255) NOT NULL,
  `qunty` float NOT NULL,
  `rate` float NOT NULL,
  `amount` float NOT NULL,
  `paid` float NOT NULL,
  `total_amount` float NOT NULL,
  `total_amount1` float NOT NULL,
  `discount` float NOT NULL,
  `balance` float NOT NULL,
  `unit` varchar(10) NOT NULL,
  `total_unit` varchar(10) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inward`
--

INSERT INTO `inward` (`id`, `inwardno`, `sellername`, `date`, `voucharno`, `expences`, `qunty`, `rate`, `amount`, `paid`, `total_amount`, `total_amount1`, `discount`, `balance`, `unit`, `total_unit`, `remark`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 6, '3', '2019-06-06', 0, '3', 0, 50, 0, 2000, 12500, 12500, 0, 12500, '1', '250', 'a', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 7, '2', '2019-06-06', 63, '3', 0, 5, 0, 30, 30, 30, 0, 30, '1', '6', '4', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `milksell`
--

CREATE TABLE `milksell` (
  `id` int(10) NOT NULL,
  `breedtype` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `session` varchar(10) NOT NULL,
  `total_milk` float NOT NULL,
  `sellername` varchar(255) NOT NULL,
  `total_amount` float NOT NULL,
  `paid` int(10) NOT NULL,
  `balance` int(25) NOT NULL,
  `rate` float NOT NULL,
  `remark` mediumtext NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `milksell`
--

INSERT INTO `milksell` (`id`, `breedtype`, `date`, `session`, `total_milk`, `sellername`, `total_amount`, `paid`, `balance`, `rate`, `remark`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, '2', '2019-06-05', 'morning', 10, '5', 7000, 7000, 0, 70, 'dfsdf', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, '3', '2019-06-06', 'morning', 2, '2', 450, 50, 0, 10, 'dsfsdfs', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, '2', '2019-06-06', 'morning', 50, '1', 2500, 500, 0, 50, '324234', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, '2', '2019-06-06', 'morning', 5, '2', 250, 0, 0, 50, 'erte', '0000-00-00 00:00:00', '', '', '', '', ''),
(5, '3', '2019-06-06', 'morning', 2, '1', 108, 0, 0, 54, '745', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `nithrausers`
--

CREATE TABLE `nithrausers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `apps` varchar(50) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nithrausers`
--

INSERT INTO `nithrausers` (`id`, `username`, `password`, `role`, `apps`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'Shiva', 'Shiva', 'Admin', 'All', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 'shiva', 'shiva', 'admin', 'all', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'bpc_milk', 'Milk%Cow', 'office', 'all', '0000-00-00 00:00:00', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `otherdirectexp`
--

CREATE TABLE `otherdirectexp` (
  `id` int(10) NOT NULL,
  `otherwardno` int(255) NOT NULL,
  `particularexp` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `total_amount` varchar(20) NOT NULL,
  `balance` int(6) NOT NULL,
  `paid` int(10) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `cdate` text NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `otherdirectexp`
--

INSERT INTO `otherdirectexp` (`id`, `otherwardno`, `particularexp`, `date`, `total_amount`, `balance`, `paid`, `remark`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 1, '1', '2019-06-05', '50', 50, 0, 'u', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 2, '3', '2019-05-30', '687', 687, 0, 'kbjl', '0000-00-00 00:00:00', '', '', '|2019-06-06-17:06:25', '|192.168.57.180', '|Shiva'),
(3, 3, '3', '2019-06-05', '5', 5, 0, 'tyt', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `outcome`
--

CREATE TABLE `outcome` (
  `outcome_id` int(10) NOT NULL,
  `seller_id` int(10) NOT NULL,
  `inwardno` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `amount` float NOT NULL,
  `paid` float NOT NULL,
  `balance` float NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_mode` varchar(35) NOT NULL,
  `cby` varchar(36) NOT NULL,
  `cdate` date NOT NULL,
  `cip` varchar(36) NOT NULL,
  `mby` varchar(36) NOT NULL,
  `mdate` date NOT NULL,
  `mip` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `outcome`
--

INSERT INTO `outcome` (`outcome_id`, `seller_id`, `inwardno`, `date`, `amount`, `paid`, `balance`, `remarks`, `payment_date`, `payment_mode`, `cby`, `cdate`, `cip`, `mby`, `mdate`, `mip`) VALUES
(1, 3, '6', '0000-00-00', 12000, 500, 11500, 'h', '2019-06-06', 'cheque', '', '0000-00-00', '::1', '', '0000-00-00', ''),
(2, 3, '6', '0000-00-00', 11000, 500, 10500, 'y8', '2019-06-06', 'cheque', '', '0000-00-00', '::1', '', '0000-00-00', ''),
(3, 2, '7', '0000-00-00', 30, 30, 0, 'jg', '2019-06-06', 'bank', 'Shiva', '2019-06-06', '192.168.57.180', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `outward`
--

CREATE TABLE `outward` (
  `id` int(10) NOT NULL,
  `outwardno` int(255) NOT NULL,
  `date` date NOT NULL,
  `expences` varchar(255) NOT NULL,
  `balance` varchar(6) NOT NULL,
  `unit` varchar(6) NOT NULL,
  `total_unit` varchar(6) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `outward`
--

INSERT INTO `outward` (`id`, `outwardno`, `date`, `expences`, `balance`, `unit`, `total_unit`, `remark`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 1, '2019-06-05', '3', '450', '50', '500', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 2, '2019-06-05', '3', '195', '5', '200', '6', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 3, '2019-06-05', '3', '195', '6', '201', '4l;k', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `particularexp`
--

CREATE TABLE `particularexp` (
  `id` int(10) NOT NULL,
  `particularexp` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `particularexp`
--

INSERT INTO `particularexp` (`id`, `particularexp`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'Other Exp ', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'Salary', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, 'ukoyu', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sb_productname`
--

CREATE TABLE `sb_productname` (
  `id` int(11) NOT NULL,
  `product` varchar(200) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` text NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sb_productname`
--

INSERT INTO `sb_productname` (`id`, `product`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'Palkova', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 'Curd', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'Butter', '0000-00-00 00:00:00', '', '', '', '', ''),
(4, 'cake', '0000-00-00 00:00:00', '', '', '', '', ''),
(5, 'Dung', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id` int(20) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `phoneno` varchar(16) NOT NULL,
  `address` mediumtext NOT NULL,
  `remark` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`id`, `date`, `name`, `phoneno`, `address`, `remark`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, '2019-04-06', ' Shiva', '9750460100', 'Erode', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, '2019-05-04', 'DHANRAJ P', '8870074461', '1-53, \r\nPUDHUR,\r\nPULLAGOUNDAMPATTI,\r\nTIRUCHENGODE,\r\n', '', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, '2019-05-25', ' Kavin Seller123', '9876543211', 'dddddd', 'sdfsdf', '0000-00-00 00:00:00', '', '', '', '', ''),
(5, '2019-06-04', 'JP RAJA', '8870074462', 'asdas', 'dasd', '0000-00-00 00:00:00', '', '', '', '', ''),
(6, '2019-06-06', 'pavitu', '9879635211', 'utyiutyi', '', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(10) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `cip` text NOT NULL,
  `cby` varchar(200) NOT NULL,
  `mdate` text NOT NULL,
  `mip` text NOT NULL,
  `mby` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit`, `cdate`, `cip`, `cby`, `mdate`, `mip`, `mby`) VALUES
(1, 'Litre', '0000-00-00 00:00:00', '', '', '', '', ''),
(2, 'Kgs', '0000-00-00 00:00:00', '', '', '', '', ''),
(3, 'BOX', '0000-00-00 00:00:00', '', '', '', '', ''),
(5, '67870hj', '2019-06-06 00:00:00', '192.168.57.180', 'Shiva', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE `usergroup` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `access_per` mediumtext NOT NULL,
  `modify_per` mediumtext NOT NULL,
  `cby` longtext NOT NULL,
  `cdate` longtext NOT NULL,
  `cip` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usergroup`
--

INSERT INTO `usergroup` (`id`, `name`, `access_per`, `modify_per`, `cby`, `cdate`, `cip`) VALUES
(1, 'admin', '1,2,3,5,7,9,11,14,12,13,15,16,18,19,20,21,22,24,26,28,29,30,31,32,34,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53', '', '', '23-02-2019', 'Shiva'),
(2, 'office', '1,2,3,5,7,9,11,14,12,13,15,16,18,19,20,21,22,24,26,28,29,30,31,32,34,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53', '', 'Shiva', '2019-02-02', '123.09.46.8');

-- --------------------------------------------------------

--
-- Table structure for table `usermodules`
--

CREATE TABLE `usermodules` (
  `id` int(10) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `parent` int(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `submenu` int(255) NOT NULL,
  `icons` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `position` int(10) NOT NULL,
  `cby` varchar(255) NOT NULL,
  `cdate` date NOT NULL,
  `cip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usermodules`
--

INSERT INTO `usermodules` (`id`, `mname`, `parent`, `url`, `submenu`, `icons`, `status`, `position`, `cby`, `cdate`, `cip`) VALUES
(1, 'Home', 0, '/milk/dashboard.php', 0, 'md-home', 0, 1, 'Shiva', '2019-01-04', '198.68.27.180'),
(2, 'Transactions', 0, '/milk/registration.php', 0, 'md-assignment-ind', 0, 3, 'Shiva', '2019-01-04', '198.89.34.9'),
(3, 'Cattle Registration', 11, 'cowreg.php', 0, '', 0, 3, 'Shiva', '2019-01-04', '198.67.09.8'),
(5, 'Daily Milking Entry', 2, 'dailymilk.php', 0, '0', 0, 4, 'Shiva', '2019-01-04', '190.67.89.4'),
(7, 'Milk Sale Entry', 2, 'milksale.php', 0, '0', 0, 6, 'Shiva', '2019-01-04', '198.34.9.90'),
(9, 'Buyer Details', 8, 'buyerdetails.php', 0, '0', 0, 8, 'Shiva', '2019-01-04', '198.89.98.8'),
(10, 'Seller Details', 8, 'sellerdetails.php', 0, '0', 0, 9, 'Siva', '2019-01-04', '198.24.89.9'),
(11, 'Master', 0, 'Master', 0, ' md-folder', 0, 1, 'Shiva', '2019-01-04', '198.09.90.89'),
(12, 'Add Breed Type', 11, 'breed.php', 0, '0', 0, 2, 'Shiva', '2019-01-04', '198.23.56.1'),
(13, 'Add Buyer', 11, 'buyer.php', 0, '0', 0, 7, 'Shiva', '2019-01-04', '198.09.89.7'),
(14, 'Add Seller', 11, 'seller.php', 0, '0', 0, 8, 'Shiva', '2019-01-04', '198.78.09.9'),
(15, 'Accounts', 0, 'Finance', 0, 'md-account-balance', 0, 6, 'shiva', '2019-01-04', '198.78.98.9'),
(16, 'Payment Receipt', 15, 'income.php', 0, '0', 0, 6, 'Shiva', '2019-01-04', '198.89.98.7'),
(18, 'User Management', 0, 'User Management', 0, 'md-account-child', 0, 9, 'Shiva', '2019-01-04', '198.09.89.78'),
(19, 'User Group', 18, 'usergroup2.php', 0, '0', 0, 18, 'Shiva', '2019-01-04', '198.09.80.83'),
(20, 'User Modules', 18, 'usermodules2.php', 0, '1', 0, 19, 'Shiva', '2019-01-04', '198.89.89.09'),
(21, 'User Registration', 18, 'userreg.php', 0, '0', 0, 20, 'Shiva', '2019-01-04', '198.09.89.9'),
(22, 'Cattle / Product Sale Entry', 2, 'cowsell.php', 0, '0', 0, 6, 'Shiva', '2019-01-09', '198.57.90.180'),
(23, 'Add Units', 11, 'addunits.php', 0, '0', 0, 8, 'Shiva', '2018-12-18', '198.45.7.89'),
(24, 'Add Sale Product Name', 11, 'addcate.php', 0, '0', 0, 5, 'Shiva', '2018-12-18', '129.68.9.77'),
(25, 'Milk Rate', 11, 'milkrate.php', 0, '', 0, 3, 'Shiva', '2019-01-25', '198.168.28.180'),
(26, 'Statement Report', 38, 'report.php', 0, '0', 0, 10, 'Shiva', '2019-01-27', '198.28.60.180'),
(27, 'Report', 38, 'report.php', 0, '0', 0, 18, 'Shiva', '2019-01-27', '198.28.60.180'),
(28, 'Add Purchase Product Name', 11, 'exx.php', 0, '0', 0, 4, 'Shiva', '2019-01-29', '198.68.49.180'),
(29, 'Buyerwise Balance', 39, 'balance.php', 0, '0', 0, 10, 'Shiva', '2019-01-07', '198.168.28.180'),
(30, 'Add Cattle Color', 11, 'color.php', 0, '0', 0, 2, 'Shiva', '2019-01-16', '192.168.26.180'),
(31, 'Add Units', 11, 'addunit.php', 0, '0', 0, 2, 'Shiva', '2019-02-04', '192.168.26.180'),
(32, 'General Purchase Entry', 2, 'inward.php', 0, '0', 0, 7, 'Shiva', '2019-02-03', '192.168.28.180'),
(33, 'Expenses Type', 15, 'exp.php', 0, '0', 0, 9, 'Shiva', '2019-01-01', '198.168.28.180'),
(34, 'Outward Entry', 2, 'outward.php', 0, '0', 0, 8, 'Shiva', '2019-02-01', '192.168.28.180'),
(36, 'Outward Report', 38, 'outwardreport.php', 0, '0', 0, 5, 'Shiva', '2019-02-05', '192.168.29.180'),
(37, ' Payment Issue', 15, 'outcome.php', 0, '0', 0, 8, 'Shiva', '2019-02-04', '198.162.28.180'),
(38, 'Report', 0, 'Report', 0, 'md-description', 0, 7, 'Shiva', '2019-02-05', '198.168.28.180'),
(39, 'Balance', 0, 'Balance', 0, 'md-payment', 0, 8, '7', '2019-02-13', '192.168.28.180'),
(40, 'Sellerwise Balance', 39, 'sellerbalance.php', 0, '0', 0, 11, 'Shiva', '2019-03-03', '192.168.28.180'),
(41, 'Stock Report', 38, 'stack_report.php', 0, '0', 0, 10, 'Shiva', '2019-03-03', '198.168.28.180'),
(42, 'Purchase Report', 38, 'inwardreport.php', 0, '0', 0, 4, 'Shiva', '2018-12-03', '198.168.28.180'),
(43, 'Other Expenses', 15, 'otherdirectexp.php', 0, '0', 0, 9, 'Shiva', '2019-03-03', '198.162.28.180'),
(44, 'Amount Receipt Report', 38, 'amountrece.php', 0, '0', 0, 5, 'Shiva', '2019-02-04', '198.168.28.180'),
(45, 'Amount Issue Report', 38, 'amountissue.php', 0, '0', 0, 6, 'Shiva', '2019-02-03', '198.162.28.180'),
(46, 'Daily Milking Report', 38, 'dailymilkingreport.php', 0, '0', 0, 11, 'Shiva', '2019-03-03', '198.162.28.180'),
(47, 'Milk Sale Report', 38, 'milksalereport.php', 0, '0', 0, 12, 'Shiva', '2019-03-13', '198.162.28.180'),
(48, 'Add Other Expenses Head', 11, 'particularexp.php', 0, '0', 0, 6, 'Shiva', '2019-03-12', '198.169.29.180'),
(49, 'Cattlesell Report', 38, 'cowsellreport.php', 0, '0', 0, 13, 'Shiva', '2019-03-04', '192.168.28.180'),
(50, 'Milk Report', 38, 'milkreport.php', 0, '0', 0, 14, 'Shiva', '2019-03-13', '198.162.28.180'),
(51, 'Buyer Ledger', 38, 'ledger.php', 0, '0', 0, 15, 'Shiva', '2019-02-04', '198.162.29.180'),
(52, 'Seller Ledger', 38, 'sellerledger.php', 0, '0', 0, 16, 'Shiva', '2019-03-13', '198.162.49.180'),
(53, 'Bulk Milking Entry', 2, 'Bulkmilkentry.php', 0, '0', 0, 5, 'Shiva', '2019-01-01', '192.28.13.180');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_report`
--
ALTER TABLE `access_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `breedtype`
--
ALTER TABLE `breedtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cowcolor`
--
ALTER TABLE `cowcolor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cowreg`
--
ALTER TABLE `cowreg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cowsell`
--
ALTER TABLE `cowsell`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cowtype`
--
ALTER TABLE `cowtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dailymilk`
--
ALTER TABLE `dailymilk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `inward`
--
ALTER TABLE `inward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milksell`
--
ALTER TABLE `milksell`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nithrausers`
--
ALTER TABLE `nithrausers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otherdirectexp`
--
ALTER TABLE `otherdirectexp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outcome`
--
ALTER TABLE `outcome`
  ADD PRIMARY KEY (`outcome_id`);

--
-- Indexes for table `outward`
--
ALTER TABLE `outward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `particularexp`
--
ALTER TABLE `particularexp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sb_productname`
--
ALTER TABLE `sb_productname`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usergroup`
--
ALTER TABLE `usergroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usermodules`
--
ALTER TABLE `usermodules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_report`
--
ALTER TABLE `access_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `breedtype`
--
ALTER TABLE `breedtype`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cowcolor`
--
ALTER TABLE `cowcolor`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cowreg`
--
ALTER TABLE `cowreg`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cowsell`
--
ALTER TABLE `cowsell`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cowtype`
--
ALTER TABLE `cowtype`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dailymilk`
--
ALTER TABLE `dailymilk`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inward`
--
ALTER TABLE `inward`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `milksell`
--
ALTER TABLE `milksell`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nithrausers`
--
ALTER TABLE `nithrausers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `otherdirectexp`
--
ALTER TABLE `otherdirectexp`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `outcome`
--
ALTER TABLE `outcome`
  MODIFY `outcome_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `outward`
--
ALTER TABLE `outward`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `particularexp`
--
ALTER TABLE `particularexp`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sb_productname`
--
ALTER TABLE `sb_productname`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usergroup`
--
ALTER TABLE `usergroup`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usermodules`
--
ALTER TABLE `usermodules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
