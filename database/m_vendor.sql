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
-- Table structure for table `m_vendor`
--

CREATE TABLE `m_vendor` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `telp` varchar(50) DEFAULT NULL,
  `pic_nama` varchar(100) DEFAULT NULL,
  `pic_telp` varchar(50) DEFAULT NULL,
  `created_user` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_user` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int(11) DEFAULT '0',
  `deleted_user` int(11) DEFAULT '0',
  `deleted_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_vendor`
--

INSERT INTO `m_vendor` (`id`, `nama`, `alamat`, `telp`, `pic_nama`, `pic_telp`, `created_user`, `created_date`, `updated_user`, `updated_date`, `is_delete`, `deleted_user`, `deleted_date`) VALUES
(1, 'PT Jaya Abadi', 'Brongkal-Pagelaran Malang', '021345', 'Budi', '085336', 2, '2022-05-30 08:06:57', 2, '2022-05-31 07:24:06', 0, 0, '2022-05-30 08:07:09'),
(2, 'CV Berkah', 'Jln. Gapura no.1 Malang', '021345', 'Budi', '085654129343', 2, '2022-05-30 08:07:50', 2, '2022-06-03 13:31:11', 0, 0, '2022-05-30 08:07:50'),
(3, 'PT Anugerah', 'Jalan Mawar No. 10, Surabaya', '012345', 'Adi', '085654129343', 2, '2022-05-31 07:24:41', 0, '2022-05-31 07:24:41', 0, 0, '2022-05-31 07:24:41'),
(4, 'CV Kimia', 'Jl. Pahlawan No.66, Sidoarjo', '02112341', 'Tono', '0812345678', 2, '2022-06-07 03:39:52', 0, '2022-06-07 03:39:52', 0, 0, '2022-06-07 03:39:52'),
(5, 'PT Farma Sejati', 'Jl. Penanggungan No.11, Bojonegoro', '081928374756', 'Handoko', '0850192834765', 2, '2022-06-07 03:39:52', 2, '2022-06-13 06:08:42', 0, 0, '2022-06-07 03:39:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_vendor`
--
ALTER TABLE `m_vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_vendor`
--
ALTER TABLE `m_vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
