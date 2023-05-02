-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 04:19 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_think_big`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_po_purchasing_det`
--

CREATE TABLE `t_po_purchasing_det` (
  `id` int(11) NOT NULL,
  `t_po_purchasing` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `m_inventori_bahan_lab` int(11) DEFAULT '0',
  `jumlah` double DEFAULT '0',
  `harga` double DEFAULT '0',
  `keterangan` varchar(200) DEFAULT NULL,
  `total_masuk` double DEFAULT '0',
  `created_user` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int(11) DEFAULT '0',
  `deleted_user` int(11) DEFAULT '0',
  `deleted_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_po_purchasing_det`
--

INSERT INTO `t_po_purchasing_det` (`id`, `t_po_purchasing`, `tanggal`, `m_inventori_bahan_lab`, `jumlah`, `harga`, `keterangan`, `total_masuk`, `created_user`, `created_date`, `updated_user`, `updated_date`, `is_delete`, `deleted_user`, `deleted_date`) VALUES
(1, 1, '2022-06-13 14:47:57', 6, 50, 250000, '', 0, 2, '2022-06-13 07:47:57', 0, '2022-06-13 07:47:57', 0, 0, '2022-06-13 07:49:22'),
(2, 1, '2022-06-13 14:47:57', 7, 35, 350000, '', 0, 2, '2022-06-13 07:47:57', 0, '2022-06-13 07:47:57', 0, 0, '2022-06-13 07:49:26'),
(3, 1, '2022-06-13 14:47:57', 1, 10, 150000, '', 0, 2, '2022-06-13 07:47:57', 0, '2022-06-13 07:47:57', 0, 0, '2022-06-13 07:49:16'),
(4, 1, '2022-06-13 14:53:11', 3, 15, 150000, '', 0, 2, '2022-06-13 07:53:11', 0, '2022-06-13 07:53:11', 0, 0, '2022-06-13 07:53:11'),
(5, 2, '2022-06-13 15:22:21', 4, 20, 150000, '', 0, 2, '2022-06-13 08:22:21', 0, '2022-06-13 08:22:21', 0, 0, '2022-06-13 08:22:21'),
(6, 2, '2022-06-13 15:22:21', 7, 15, 200000, '', 0, 2, '2022-06-13 08:22:21', 0, '2022-06-13 08:22:21', 0, 0, '2022-06-13 08:22:21'),
(7, 3, '2022-06-13 21:13:14', 4, 5, 50000, '', 0, 19, '2022-06-13 14:13:06', 19, '2022-06-13 14:13:14', 1, 19, '2022-06-13 14:14:47'),
(8, 3, '2022-06-13 21:14:38', 5, 6, 60000, '', 0, 19, '2022-06-13 14:14:38', 0, '2022-06-13 14:14:38', 1, 19, '2022-06-13 14:14:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_po_purchasing_det`
--
ALTER TABLE `t_po_purchasing_det`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_po_purchasing_det`
--
ALTER TABLE `t_po_purchasing_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
