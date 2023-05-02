-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 04:17 PM
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
-- Table structure for table `m_inventori_bahan_lab`
--

CREATE TABLE `m_inventori_bahan_lab` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `no_katalog` varchar(50) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tgl_stok_awal` date DEFAULT NULL COMMENT 'tgl awal masuk barang',
  `stok_awal` double DEFAULT '0' COMMENT 'stok awal barang masuk',
  `stok_akhir` double DEFAULT '0',
  `m_inventori_bahan_lab_satuan` int(11) NOT NULL DEFAULT '0',
  `created_user` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int(11) DEFAULT '0',
  `deleted_user` int(11) DEFAULT '0',
  `deleted_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_inventori_bahan_lab`
--

INSERT INTO `m_inventori_bahan_lab` (`id`, `kode`, `no_katalog`, `nama`, `tgl_stok_awal`, `stok_awal`, `stok_akhir`, `m_inventori_bahan_lab_satuan`, `created_user`, `created_date`, `updated_user`, `updated_date`, `is_delete`, `deleted_user`, `deleted_date`) VALUES
(1, '1', '1.12', 'N ( 1- Naphtyl) Ethyline-diamine- dihydrochoride', '2022-05-30', 25, 0, 1, 2, '2022-05-30 06:27:52', 2, '2022-05-31 08:44:05', 0, 0, '2022-05-30 06:27:52'),
(2, '3', '1.001', 'Sodium Chloride', '2022-05-30', 15, 0, 1, 2, '2022-05-30 06:28:28', 2, '2022-05-30 08:53:06', 0, 0, '2022-05-30 06:28:28'),
(3, '4', '2.01', 'Titriplex (EDTA)', '2022-05-30', 40, 0, 2, 2, '2022-05-30 06:28:45', 2, '2022-05-31 08:57:51', 0, 0, '2022-05-30 06:28:45'),
(4, '5', '', 'Calsium carbonate', NULL, 0, 0, 1, 2, '2022-06-09 02:47:07', 0, '2022-06-09 02:47:07', 0, 0, '2022-06-09 02:47:07'),
(5, '6', '', 'Potasium chloride', NULL, 0, 0, 1, 2, '2022-06-09 02:47:22', 0, '2022-06-09 02:47:22', 0, 0, '2022-06-09 02:47:22'),
(6, '7', '', 'Potasium iodide', NULL, 0, 0, 1, 2, '2022-06-09 02:47:34', 0, '2022-06-09 02:47:34', 0, 0, '2022-06-09 02:47:34'),
(7, '8', '', 'Silver Nitrate', NULL, 0, 0, 1, 2, '2022-06-09 02:47:48', 0, '2022-06-09 02:47:48', 0, 0, '2022-06-09 02:47:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_inventori_bahan_lab`
--
ALTER TABLE `m_inventori_bahan_lab`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_inventori_bahan_lab`
--
ALTER TABLE `m_inventori_bahan_lab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
