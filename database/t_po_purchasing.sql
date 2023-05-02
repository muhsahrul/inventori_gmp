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
-- Table structure for table `t_po_purchasing`
--

CREATE TABLE `t_po_purchasing` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `nomor` varchar(100) CHARACTER SET utf8 NOT NULL,
  `nomor_urut` int(5) DEFAULT '0',
  `nomor_bulan` int(2) DEFAULT '0',
  `nomor_tahun` int(4) DEFAULT '0',
  `m_vendor` int(11) DEFAULT '0',
  `total_harga` double DEFAULT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int(11) DEFAULT '0',
  `deleted_user` int(11) DEFAULT '0',
  `deleted_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_po_purchasing`
--

INSERT INTO `t_po_purchasing` (`id`, `tanggal`, `nomor`, `nomor_urut`, `nomor_bulan`, `nomor_tahun`, `m_vendor`, `total_harga`, `created_user`, `created_date`, `updated_user`, `updated_date`, `is_delete`, `deleted_user`, `deleted_date`) VALUES
(1, '2022-06-13', '1/PO-GMP/P/VI/2022', 1, 6, 2022, 5, 900000, 2, '2022-06-13 07:47:57', 2, '2022-06-13 07:53:11', 0, 0, '2022-06-13 07:47:57'),
(2, '2022-06-13', '2/PO-GMP/P/VI/2022', 2, 6, 2022, 3, 350000, 2, '2022-06-13 08:22:21', 0, '2022-06-13 08:22:21', 0, 0, '2022-06-13 08:22:21'),
(3, '2022-06-13', '3/PO-GMP/P/VI/2022', 3, 6, 2022, 3, 60000, 19, '2022-06-13 14:13:06', 19, '2022-06-13 14:14:47', 1, 19, '2022-06-13 14:14:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_po_purchasing`
--
ALTER TABLE `t_po_purchasing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_po_purchasing`
--
ALTER TABLE `t_po_purchasing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
