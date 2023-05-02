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
-- Table structure for table `m_user_permission_inventori`
--

CREATE TABLE `m_user_permission_inventori` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8 NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_id` int(3) DEFAULT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int(11) DEFAULT '0',
  `deleted_user` int(11) NOT NULL DEFAULT '0',
  `deleted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_user_permission_inventori`
--

INSERT INTO `m_user_permission_inventori` (`id`, `nama`, `url`, `parent_id`, `created_user`, `created_date`, `updated_user`, `updated_date`, `is_delete`, `deleted_user`, `deleted_date`) VALUES
(1, 'Bahan', '', 0, 2, '2022-06-03 09:11:16', 2, '2022-06-03 09:16:25', 0, 0, '2022-06-03 09:11:16'),
(2, 'View Bahan', 'master/bahan', 1, 2, '2022-06-03 09:13:08', 0, '2022-06-03 09:13:08', 0, 0, '2022-06-03 09:13:08'),
(3, 'Create Bahan', 'bahan/createBahan,bahan/saveBahan', 1, 2, '2022-06-03 09:14:25', 2, '2022-06-03 13:20:37', 0, 0, '2022-06-03 09:14:25'),
(4, 'Edit Bahan', 'bahan/editBahan,bahan/updateBahan', 1, 2, '2022-06-03 09:15:09', 2, '2022-06-03 13:20:46', 0, 0, '2022-06-03 09:15:09'),
(5, 'Delete Bahan', 'bahan/deleteBahan', 1, 2, '2022-06-03 09:15:36', 0, '2022-06-03 09:15:36', 0, 0, '2022-06-03 09:15:36'),
(6, 'Satuan', NULL, 0, 2, '2022-06-03 09:16:10', 0, '2022-06-03 09:16:10', 0, 0, '2022-06-03 09:16:10'),
(7, 'View Satuan', 'master/satuan', 6, 2, '2022-06-03 09:17:31', 0, '2022-06-03 09:17:31', 0, 0, '2022-06-03 09:17:31'),
(8, 'Create Satuan', 'satuan/createSatuan,satuan/saveSatuan', 6, 2, '2022-06-03 09:18:06', 2, '2022-06-03 13:20:52', 0, 0, '2022-06-03 09:18:06'),
(9, 'Edit Satuan', 'satuan/editSatuan,satuan/updateSatuan', 6, 2, '2022-06-03 09:18:23', 2, '2022-06-03 13:20:57', 0, 0, '2022-06-03 09:18:23'),
(10, 'Delete Satuan', 'satuan/deleteSatuan', 6, 2, '2022-06-03 09:19:03', 0, '2022-06-03 09:19:03', 0, 0, '2022-06-03 09:19:03'),
(11, 'Vendor', NULL, 0, 2, '2022-06-03 09:21:24', 0, '2022-06-03 09:21:24', 0, 0, '2022-06-03 09:21:24'),
(12, 'View Vendor', 'master/vendor', 11, 2, '2022-06-03 09:21:37', 0, '2022-06-03 09:21:37', 0, 0, '2022-06-03 09:21:37'),
(13, 'Create Vendor', 'vendor/createVendor,vendor/saveVendor', 11, 2, '2022-06-03 09:21:55', 2, '2022-06-03 13:21:06', 0, 0, '2022-06-03 09:21:55'),
(14, 'Edit Vendor', 'vendor/editVendor,vendor/updateVendor', 11, 2, '2022-06-03 09:22:45', 2, '2022-06-03 13:21:21', 0, 0, '2022-06-03 09:22:45'),
(15, 'Delete Vendor', 'vendor/deleteVendor', 11, 2, '2022-06-03 09:23:05', 0, '2022-06-03 09:23:05', 0, 0, '2022-06-03 09:23:05'),
(16, 'Stok Awal', NULL, 0, 2, '2022-06-03 09:31:33', 0, '2022-06-03 09:31:33', 0, 0, '2022-06-03 09:31:33'),
(17, 'View Stok Awal', 'master/stokAwal', 16, 2, '2022-06-03 09:32:04', 0, '2022-06-03 09:32:04', 0, 0, '2022-06-03 09:32:04'),
(18, 'Edit Stok Awal', 'stokAwal/editStokAwal,stokAwal/updateStokAwal', 16, 2, '2022-06-03 09:32:27', 2, '2022-06-03 13:21:39', 0, 0, '2022-06-03 09:32:27'),
(19, 'Barang Masuk', NULL, 0, 2, '2022-06-03 09:32:45', 0, '2022-06-03 09:32:45', 0, 0, '2022-06-03 09:32:45'),
(20, 'View Barang Masuk', 'transaksi/barangMasuk', 19, 2, '2022-06-03 09:33:01', 2, '2022-06-03 09:37:10', 0, 0, '2022-06-03 09:33:01'),
(21, 'Create Barang Masuk', 'barangMasuk/createBarangMasuk,barangMasuk/saveBarangMasuk', 19, 2, '2022-06-03 09:35:06', 2, '2022-06-03 13:21:58', 0, 0, '2022-06-03 09:35:06'),
(22, 'Edit Barang Masuk', 'barangMasuk/editBarangMasuk,barangMasuk/updateBarangMasuk', 19, 2, '2022-06-03 09:35:28', 2, '2022-06-03 13:43:02', 0, 0, '2022-06-03 09:35:28'),
(23, 'Delete Barang Masuk', 'barangMasuk/deleteBarangMasuk', 19, 2, '2022-06-03 09:36:55', 0, '2022-06-03 09:36:55', 0, 0, '2022-06-03 09:36:55'),
(24, 'View Detail Barang Masuk', 'barangMasuk/detailBarangMasuk', 19, 2, '2022-06-03 09:38:40', 0, '2022-06-03 09:38:40', 0, 0, '2022-06-03 09:38:40'),
(25, 'Barang Keluar', NULL, 0, 2, '2022-06-03 09:38:52', 0, '2022-06-03 09:38:52', 0, 0, '2022-06-03 09:38:52'),
(26, 'View Barang Keluar', 'transaksi/barangKeluar', 25, 2, '2022-06-03 09:39:07', 0, '2022-06-03 09:39:07', 0, 0, '2022-06-03 09:39:07'),
(27, 'Create Barang Keluar', 'barangKeluar/createBarangKeluar,barangKeluar/saveBarangKeluar', 25, 2, '2022-06-03 09:39:35', 2, '2022-06-03 13:37:28', 0, 0, '2022-06-03 09:39:35'),
(28, 'Edit Barang Keluar', 'barangKeluar/editBarangKeluar,barangKeluar/updateBarangKeluar', 25, 2, '2022-06-03 09:39:59', 2, '2022-06-03 13:23:31', 0, 0, '2022-06-03 09:39:59'),
(29, 'Delete Barang Keluar', 'barangKeluar/DeleteBarangKeluar', 25, 2, '2022-06-03 09:40:18', 0, '2022-06-03 09:40:18', 0, 0, '2022-06-03 09:40:18'),
(30, 'Report', '', 0, 2, '2022-06-03 09:56:05', 2, '2022-06-03 09:57:07', 0, 0, '2022-06-03 09:56:05'),
(31, 'View Report Stok Bahan', 'report/reportStok', 30, 2, '2022-06-03 09:56:34', 0, '2022-06-03 09:56:34', 0, 0, '2022-06-03 09:56:34'),
(32, 'View Report Per Bahan', 'report/reportBahan', 30, 2, '2022-06-03 09:57:30', 0, '2022-06-03 09:57:30', 0, 0, '2022-06-03 09:57:30'),
(33, 'View Report Per Parameter', 'report/reportParameter', 30, 2, '2022-06-03 09:57:53', 0, '2022-06-03 09:57:53', 0, 0, '2022-06-03 09:57:53'),
(34, 'View Chart Report Bahan', 'report/chartBahan', 30, 2, '2022-06-03 09:58:28', 0, '2022-06-03 09:58:28', 0, 0, '2022-06-03 09:58:28'),
(35, 'Create Bahan Detail PO', 'po/createBahanPo,po/saveBahanPo', 37, 2, '2022-06-03 13:38:54', 2, '2022-06-13 14:07:06', 0, 0, '2022-06-03 13:38:54'),
(36, 'Delete Bahan PO', 'po/deleteBahanPo', 37, 2, '2022-06-03 13:40:24', 2, '2022-06-13 14:07:34', 0, 0, '2022-06-03 13:40:24'),
(37, 'PO Purchasing', NULL, 0, 2, '2022-06-13 14:01:19', 0, '2022-06-13 14:01:19', 0, 0, '2022-06-13 14:01:19'),
(38, 'View PO Purchasing', 'purchasing/po', 37, 2, '2022-06-13 14:02:32', 0, '2022-06-13 14:02:32', 0, 0, '2022-06-13 14:02:32'),
(39, 'Create PO', 'po/createPo,po/savePo', 37, 2, '2022-06-13 14:08:57', 0, '2022-06-13 14:08:57', 0, 0, '2022-06-13 14:08:57'),
(40, 'Edit PO', 'po/editPo,po/updatePo', 37, 2, '2022-06-13 14:09:16', 0, '2022-06-13 14:09:16', 0, 0, '2022-06-13 14:09:16'),
(41, 'Delete PO', 'po/deletePo', 37, 2, '2022-06-13 14:09:37', 0, '2022-06-13 14:09:37', 0, 0, '2022-06-13 14:09:37'),
(42, 'Detail PO', 'po/detailPo', 37, 2, '2022-06-13 14:13:56', 0, '2022-06-13 14:13:56', 0, 0, '2022-06-13 14:13:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_user_permission_inventori`
--
ALTER TABLE `m_user_permission_inventori`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
