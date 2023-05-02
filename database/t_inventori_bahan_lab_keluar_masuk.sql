-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 04:18 PM
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
-- Table structure for table `t_inventori_bahan_lab_keluar_masuk`
--

CREATE TABLE `t_inventori_bahan_lab_keluar_masuk` (
  `id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `t_po_purchasing` int(11) DEFAULT '0',
  `tanggal_po` date DEFAULT NULL,
  `nomor_po` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `tanggal_invoice` date DEFAULT NULL,
  `nomor_invoice` varchar(100) CHARACTER SET utf8 NOT NULL,
  `m_vendor` int(11) DEFAULT '0',
  `tanggal_jt_bayar` date DEFAULT NULL,
  `total_harga` double DEFAULT '0',
  `m_status_pembayaran_inv_purchasing` int(1) DEFAULT '1',
  `tanggal_pembayaran` date DEFAULT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int(11) DEFAULT '0',
  `deleted_user` int(11) DEFAULT '0',
  `deleted_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_inventori_bahan_lab_keluar_masuk`
--

INSERT INTO `t_inventori_bahan_lab_keluar_masuk` (`id`, `tanggal`, `t_po_purchasing`, `tanggal_po`, `nomor_po`, `tanggal_invoice`, `nomor_invoice`, `m_vendor`, `tanggal_jt_bayar`, `total_harga`, `m_status_pembayaran_inv_purchasing`, `tanggal_pembayaran`, `created_user`, `created_date`, `updated_user`, `updated_date`, `is_delete`, `deleted_user`, `deleted_date`) VALUES
(1, '2022-06-14 14:48:45', 1, '2022-06-13', '1/PO-GMP/P/VI/2022', '2022-06-14', 'INV00102', 5, '2022-06-30', 750000, 1, NULL, 2, '2022-06-13 07:48:45', 0, '2022-06-13 07:48:45', 0, 0, '2022-06-13 07:48:45'),
(2, '2022-06-13 15:25:03', 2, '2022-06-13', '2/PO-GMP/P/VI/2022', '2022-06-13', '1/INV/ANU/6.2022', 3, '2022-06-30', 350000, 1, NULL, 2, '2022-06-13 08:24:13', 2, '2022-06-13 08:25:03', 0, 0, '2022-06-13 08:24:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_inventori_bahan_lab_keluar_masuk`
--
ALTER TABLE `t_inventori_bahan_lab_keluar_masuk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_inventori_bahan_lab_keluar_masuk`
--
ALTER TABLE `t_inventori_bahan_lab_keluar_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
