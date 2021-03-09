-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2021 at 06:31 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lepet`
--
CREATE DATABASE IF NOT EXISTS `db_lepet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_lepet`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

DROP TABLE IF EXISTS `tbl_barang`;
CREATE TABLE `tbl_barang` (
  `_id` int(11) NOT NULL,
  `kode_barang` char(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_barang` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`_id`, `kode_barang`, `nama_barang`, `harga_barang`, `stok`, `created_at`) VALUES
(1, 'P-001', 'Panci Ajaib', 700000, 80, '2021-02-14 04:18:50'),
(2, 'P-002', 'Panci Kurang Ajaib Tapi Boong', 1000000, 128, '2021-01-28 15:41:06'),
(3, 'P-003', 'Panci Anti Perang', 1500000, 149, '2021-02-13 14:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_masuk`
--

DROP TABLE IF EXISTS `tbl_barang_masuk`;
CREATE TABLE `tbl_barang_masuk` (
  `_id` int(11) NOT NULL,
  `kode_faktur` char(15) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang_masuk`
--

INSERT INTO `tbl_barang_masuk` (`_id`, `kode_faktur`, `id_barang`, `jumlah`, `tgl_masuk`, `created_at`) VALUES
(24, 'm-001', 1, 50, '2021-01-20', '2021-01-20 15:53:53'),
(25, 'M-002', 3, 50, '2021-02-13', '2021-02-13 14:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_catatan`
--

DROP TABLE IF EXISTS `tbl_catatan`;
CREATE TABLE `tbl_catatan` (
  `_id` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_catatan`
--

INSERT INTO `tbl_catatan` (`_id`, `id_penjualan`, `catatan`) VALUES
(1, 1, 'test'),
(2, 1, 'dfgdkfghdlfgh');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_levels`
--

DROP TABLE IF EXISTS `tbl_levels`;
CREATE TABLE `tbl_levels` (
  `_id` int(11) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_levels`
--

INSERT INTO `tbl_levels` (`_id`, `id_posisi`, `id_menu`) VALUES
(2, 1, 2),
(3, 1, 3),
(4, 1, 5),
(5, 1, 6),
(6, 1, 7),
(7, 1, 9),
(8, 1, 8),
(9, 1, 10),
(10, 1, 13),
(11, 1, 14),
(12, 1, 15),
(13, 1, 1),
(14, 2, 1),
(15, 2, 2),
(16, 2, 5),
(17, 2, 7),
(19, 2, 8),
(20, 2, 9),
(21, 2, 10),
(22, 2, 13),
(23, 5, 5),
(24, 5, 7),
(25, 5, 8),
(26, 5, 9),
(27, 6, 8),
(28, 6, 10),
(29, 8, 5),
(30, 8, 6),
(31, 8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

DROP TABLE IF EXISTS `tbl_menus`;
CREATE TABLE `tbl_menus` (
  `_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `is_main` int(11) NOT NULL,
  `is_aktif` int(11) NOT NULL,
  `ordinal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_menus`
--

INSERT INTO `tbl_menus` (`_id`, `title`, `uri`, `icon`, `is_main`, `is_aktif`, `ordinal`) VALUES
(1, 'Users', '#', 'fa fa-users', 0, 1, 1),
(2, 'Pegawai', 'admin/users', 'fa fa-user', 1, 1, 1),
(3, 'Posisi', 'admin/posisi', 'fas fa-user-shield', 1, 1, 2),
(5, 'Gudang', '#', 'fa fa-warehouse', 0, 1, 2),
(6, 'Barang masuk', 'admin/barang', 'fa fa-truck-loading', 5, 1, 1),
(7, 'Barang', 'admin/barang', 'fas fa-boxes', 5, 1, 2),
(8, 'Transaksi', '#', 'fa fa-cash-register', 0, 1, 3),
(9, 'Penjualan', 'admin/penjualan', 'fa fa-file-invoice-dollar', 8, 1, 1),
(10, 'Penagihan', 'admin/penagihan', 'fas fa-receipt', 8, 1, 2),
(13, 'Laporan', '#', 'fa fa-file-invoice-dollar', 0, 1, 4),
(14, 'Aplikasi', '#', 'fas fa-cog', 0, 1, 0),
(15, 'Menu Aplikasi', 'admin/menu', 'fas fa-cog', 14, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penagihan`
--

DROP TABLE IF EXISTS `tbl_penagihan`;
CREATE TABLE `tbl_penagihan` (
  `_id` int(11) NOT NULL,
  `kode_bayar` char(11) NOT NULL,
  `no_faktur` char(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_penagihan`
--

INSERT INTO `tbl_penagihan` (`_id`, `kode_bayar`, `no_faktur`, `total_bayar`, `tgl_bayar`, `id_user`, `status`, `created_at`) VALUES
(1, 'F-001-1', 'F-001', 100000, '2021-02-01', 1, '1', '2021-02-14 05:23:00'),
(2, 'F-001-2', 'F-001', 500000, '2021-02-11', 1, '0', '2021-02-11 14:16:54'),
(3, 'F-002-1', 'F-002', 70000, '2021-02-11', 1, '0', '2021-02-11 14:19:30'),
(4, 'F-001-3', 'F-001', 70000, '2021-02-11', 1, '0', '2021-01-01 14:20:40'),
(5, 'F-001-4', 'F-001', 50000, '2021-02-11', 1, '0', '2021-02-11 14:58:25'),
(6, 'F-004-1', 'F-004', 700000, '2021-02-12', 1, '0', '2021-02-12 15:00:21'),
(7, 'F-001-5', 'F-001', 50000, '2021-02-13', 1, '0', '2021-02-13 14:04:05'),
(8, 'F-005-1', 'F-005', 100000, '2021-01-01', 1, '0', '2021-02-13 14:05:37'),
(9, 'F-006-1', 'F-006', 700000, '2021-02-13', 1, '0', '2021-02-13 14:06:21'),
(10, 'F-007-1', 'F-007', 300000, '2021-01-14', 1, '0', '2021-02-13 14:41:45'),
(12, 'F-008-1', 'F-008', 70000, '2021-02-14', 1, '0', '2021-02-14 04:18:50'),
(13, 'F-008-2', 'F-008', 70000, '2021-02-14', 1, '0', '2021-02-14 04:24:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penjualan`
--

DROP TABLE IF EXISTS `tbl_penjualan`;
CREATE TABLE `tbl_penjualan` (
  `_id` int(11) NOT NULL,
  `no_faktur` char(11) NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `alamat` longtext NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_user` char(11) NOT NULL,
  `id_penagih` int(11) NOT NULL,
  `status_bayar` enum('0','1','2') NOT NULL,
  `status_penjualan` int(11) NOT NULL,
  `tgl_tempo` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status_approve` enum('0','1') NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_penjualan`
--

INSERT INTO `tbl_penjualan` (`_id`, `no_faktur`, `nama_pembeli`, `alamat`, `no_telp`, `tgl_transaksi`, `id_barang`, `id_user`, `id_penagih`, `status_bayar`, `status_penjualan`, `tgl_tempo`, `total`, `status_approve`, `last_update`) VALUES
(1, 'F-001', 'Lukman', 'test', '213', '2021-02-01', 1, '1', 5, '1', 7, 6, 700000, '1', '2021-02-11 14:22:04'),
(2, 'F-002', 'L', 'kjkj', '4293792834', '2021-02-11', 1, '1', 6, '1', 10, 10, 700000, '1', '2021-02-14 04:56:52'),
(4, 'F-003', 'Hadi', 'Mars', '123123123', '2021-02-12', 1, '1', 7, '0', 0, 0, 700000, '1', '2021-02-12 14:54:00'),
(5, 'F-004', 'Lukman Hadi', 'TEST', '3412341234', '2021-02-12', 1, '1', 7, '0', 0, 0, 700000, '1', '2021-02-12 15:00:44'),
(6, 'F-005', 'JUPLe', 'glc', '555', '2021-01-01', 1, '1', 6, '1', 7, 5, 700000, '1', '2021-02-13 14:45:33'),
(7, 'F-006', 'JUPLe', 'glc', '555', '2021-02-13', 1, '1', 7, '0', 0, 0, 700000, '1', '2021-02-13 14:06:36'),
(8, 'F-007', 'TEST JUAl;', 'LSKDSJKJ', '1212', '2021-01-14', 3, '1', 5, '1', 5, 5, 1500000, '1', '2021-02-13 14:45:45'),
(9, 'F-008', 'TEST APPROVE', 'TEST APPROVE', '123123', '2021-02-14', 1, '1', 5, '1', 10, 5, 700000, '1', '2021-02-14 04:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perusahaan`
--

DROP TABLE IF EXISTS `tbl_perusahaan`;
CREATE TABLE `tbl_perusahaan` (
  `_id` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `telp` char(13) NOT NULL,
  `alamat` longtext NOT NULL,
  `logo` varchar(50) NOT NULL,
  `nama_apps` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posisi`
--

DROP TABLE IF EXISTS `tbl_posisi`;
CREATE TABLE `tbl_posisi` (
  `_id` int(11) NOT NULL,
  `posisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_posisi`
--

INSERT INTO `tbl_posisi` (`_id`, `posisi`) VALUES
(1, 'Superadmin'),
(2, 'Admin'),
(3, 'Supervisor'),
(4, 'Owner'),
(5, 'Sales'),
(6, 'Collector'),
(8, 'Gudang');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `_id` int(11) NOT NULL,
  `nik` char(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `posisi` char(11) NOT NULL,
  `alamat` longtext NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_aktif` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`_id`, `nik`, `nama`, `jk`, `tempat_lahir`, `tgl_lahir`, `tgl_masuk`, `posisi`, `alamat`, `password`, `is_aktif`, `created_at`) VALUES
(1, '11215176', 'Lukman Hadi', 'L', 'PDG', '2021-02-01', '2021-02-01', '1', 'ALAAMT', '$2y$04$n3mccWjUdXvExvhCKBrvY.BDvPuKZzlWtH4961xdKUONecuN3iiRO', '1', '2021-02-13 14:11:50'),
(3, '11215179', 'Lukman Kasep', 'L', 'Padneglang', '2020-12-31', '2021-01-16', '1', 'JAUH', '$2y$04$pHmCNi/c6Tm66jpjkb2mBOQ4a4Lu.NeYtRomSzalCHvlroZEO1GgG', '1', '2021-01-18 12:25:21'),
(4, '11215177', 'Sales', 'L', 'Jauh', '2021-01-20', '2021-01-20', '5', 'Jds', '$2y$04$mKx6ogDf6XBQA4x/NWrKEuIQ96zqy7M/BuKIi8qENN9IgmyPwlmVC', '0', '2021-01-20 16:04:28'),
(5, '123456789', 'Kolektor', 'L', 'Pandeglang', '2020-12-03', '2021-02-11', '6', 'hhhhh', '$2y$04$NYncnn0XN/vXaig8RCpS0.h.ORUgdzMaiHK/d3w91FxUYAeaLUIQW', '1', '2021-02-11 13:26:30'),
(6, '1231231', 'Test Kolektor2', 'L', 'rr', '2020-12-02', '2021-02-11', '6', 'test', '$2y$04$EA7Gx5UV82e8PzLo.M.0CukrjLo1gMPBvFagNY9UOTaaKAWZdbnze', '1', '2021-02-11 13:59:50'),
(7, '102010101', 'TUNAI', 'L', 'PDG', '2021-02-12', '2021-02-12', '6', 'teest', '$2y$04$kXCTMFKqe.FbFSEqsgZ/2ek6UQA.njBwENndaYSLg8Fh/4a0.emL6', '1', '2021-02-12 14:53:44'),
(8, 'inikolektor', 'Ini Kolektor', 'L', 'eeeee', '2021-02-01', '2021-02-14', '6', 'test', '$2y$04$d.6nxTNF8xn3rhgcVF75V.vesy10YDoCZx6cEsiy9DogOKWseO25C', '1', '2021-02-14 05:33:29'),
(9, 'inisales', 'Ini Sales', 'L', 'rere', '2021-02-05', '2021-02-14', '5', 'testetts', '$2y$04$90523Yo2zpd9vNPlLqK2EOf6gmtgwWVBstv8jaWaKByvxz9crzKD.', '1', '2021-02-14 05:33:52'),
(10, 'iniowner', 'Ini Owner', 'L', 'etst', '2021-02-05', '2021-02-14', '4', 'test', '$2y$04$Q95ZqyDyBXBCTsSLTd3UVOIFGTzaC0rlLffTGK2LGH8iajjStObcW', '1', '2021-02-14 05:34:42'),
(11, 'inigudang', 'Ini Gudang', 'L', 'teteet', '2021-02-14', '2021-02-14', '8', 'test', '$2y$04$KsSPavYGMnkxtFQpAvNrTOEsaVTaWHrPgO/2Q3zIa06HyMOwE9tba', '1', '2021-02-14 05:35:13'),
(12, 'iniadmin', 'Ini Admin', 'L', 'test', '2021-02-01', '2021-02-14', '2', 'test', '$2y$04$PJrPtsUuprM7tHyDMxVUUOx2TUodKfPuh/kUVaVG65hBD4qCod7R2', '1', '2021-02-14 05:35:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_catatan`
--
ALTER TABLE `tbl_catatan`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_levels`
--
ALTER TABLE `tbl_levels`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_penagihan`
--
ALTER TABLE `tbl_penagihan`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `kode_bayar` (`kode_bayar`);

--
-- Indexes for table `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `no_faktur` (`no_faktur`);

--
-- Indexes for table `tbl_perusahaan`
--
ALTER TABLE `tbl_perusahaan`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_posisi`
--
ALTER TABLE `tbl_posisi`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_catatan`
--
ALTER TABLE `tbl_catatan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_levels`
--
ALTER TABLE `tbl_levels`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_penagihan`
--
ALTER TABLE `tbl_penagihan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_perusahaan`
--
ALTER TABLE `tbl_perusahaan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_posisi`
--
ALTER TABLE `tbl_posisi`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
