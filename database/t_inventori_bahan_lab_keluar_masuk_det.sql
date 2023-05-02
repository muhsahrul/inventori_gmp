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
-- Table structure for table `t_inventori_bahan_lab_keluar_masuk_det`
--

CREATE TABLE `t_inventori_bahan_lab_keluar_masuk_det` (
  `id` int(11) NOT NULL,
  `t_inventori_bahan_lab_keluar_masuk` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `m_inventori_bahan_lab` int(11) DEFAULT '0',
  `jumlah` double DEFAULT '0',
  `harga` double DEFAULT '0',
  `keterangan` varchar(200) DEFAULT NULL,
  `is_masuk` tinyint(1) DEFAULT '0',
  `m_parameter_uji` int(11) DEFAULT '0',
  `total_masuk` double DEFAULT '0',
  `jumlah_masuk` double DEFAULT '0',
  `created_user` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int(11) DEFAULT '0',
  `deleted_user` int(11) DEFAULT '0',
  `deleted_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_inventori_bahan_lab_keluar_masuk_det`
--

INSERT INTO `t_inventori_bahan_lab_keluar_masuk_det` (`id`, `t_inventori_bahan_lab_keluar_masuk`, `tanggal`, `m_inventori_bahan_lab`, `jumlah`, `harga`, `keterangan`, `is_masuk`, `m_parameter_uji`, `total_masuk`, `jumlah_masuk`, `created_user`, `created_date`, `updated_user`, `updated_date`, `is_delete`, `deleted_user`, `deleted_date`) VALUES
(1, 1, '2022-06-14 14:48:45', 6, 50, 250, '', 1, 0, 0, 20, 2, '2022-06-13 07:48:45', 0, '2022-06-13 07:48:45', 0, 0, '2022-06-13 07:48:45'),
(2, 1, '2022-06-14 14:48:45', 7, 35, 350, '', 1, 0, 0, 15, 2, '2022-06-13 07:48:45', 0, '2022-06-13 07:48:45', 0, 0, '2022-06-13 07:48:45'),
(3, 1, '2022-06-14 14:48:45', 1, 10, 150, '', 1, 0, 0, 10, 2, '2022-06-13 07:48:45', 0, '2022-06-13 07:48:45', 0, 0, '2022-06-13 07:48:45'),
(4, 2, '2022-06-13 15:24:13', 4, 20, 150, '', 1, 0, 0, 10, 2, '2022-06-13 08:24:13', 0, '2022-06-13 08:24:13', 0, 0, '2022-06-13 08:24:13'),
(5, 2, '2022-06-13 15:24:13', 7, 15, 200, '', 1, 0, 0, 5, 2, '2022-06-13 08:24:13', 0, '2022-06-13 08:24:13', 0, 0, '2022-06-13 08:24:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_inventori_bahan_lab_keluar_masuk_det`
--
ALTER TABLE `t_inventori_bahan_lab_keluar_masuk_det`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_inventori_bahan_lab_keluar_masuk_det`
--
ALTER TABLE `t_inventori_bahan_lab_keluar_masuk_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
