-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 24, 2021 at 09:46 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`_id`, `kode_barang`, `nama_barang`, `harga_barang`, `stok`, `created_at`) VALUES
(1, 'P-001', 'Panci Ajaib', 700000, 93, '2021-01-23 15:30:19'),
(2, 'P-002', 'Panci Kurang Ajaib Tapi Boong', 1000000, 129, '2021-01-23 13:53:42');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barang_masuk`
--

INSERT INTO `tbl_barang_masuk` (`_id`, `kode_faktur`, `id_barang`, `jumlah`, `tgl_masuk`, `created_at`) VALUES
(24, 'm-001', 1, 50, '2021-01-20', '2021-01-20 15:53:53');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_penagihan`
--

INSERT INTO `tbl_penagihan` (`_id`, `kode_bayar`, `no_faktur`, `total_bayar`, `tgl_bayar`, `id_user`, `status`, `created_at`) VALUES
(5, 'F-002-1', 'F-002', 70000, '2020-01-01', 1, '0', '2021-01-23 14:07:05'),
(6, 'F-003-1', 'F-003', 100000, '2021-01-13', 1, '0', '2021-01-23 14:20:55'),
(7, 'F-002-2', 'F-002', 70000, '2020-01-01', 1, '0', '2021-01-23 14:55:25'),
(8, 'F-002-3', 'F-002', 70000, '2020-01-01', 1, '0', '2021-01-23 14:55:43'),
(9, 'F-003-2', 'F-003', 50000, '2021-01-23', 1, '0', '2021-01-23 15:03:51'),
(10, 'F-003-3', 'F-003', 50000, '2021-01-23', 1, '0', '2021-01-23 15:04:33'),
(11, 'F-006-1', 'F-006', 70000, '2021-01-23', 1, '0', '2021-01-23 15:30:19'),
(12, 'F-006-2', 'F-006', 70000, '2021-01-23', 1, '0', '2021-01-23 15:31:54');

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
  `status_bayar` enum('0','1','2') NOT NULL,
  `status_penjualan` int(11) NOT NULL,
  `tgl_tempo` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status_approve` enum('0','1') NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_penjualan`
--

INSERT INTO `tbl_penjualan` (`_id`, `no_faktur`, `nama_pembeli`, `alamat`, `no_telp`, `tgl_transaksi`, `id_barang`, `id_user`, `status_bayar`, `status_penjualan`, `tgl_tempo`, `total`, `status_approve`, `last_update`) VALUES
(1, 'F-001', 'Bokri', 'JAUH BET', '0888888888', '2021-01-19', 1, '1', '0', 0, 0, 700000, '0', '2021-01-23 13:46:59'),
(3, 'F-002', 'Lexvet', 'Jauh', '0', '2020-01-01', 1, '1', '1', 10, 5, 700000, '1', '2021-01-23 14:29:43'),
(4, 'F-003', 'Lexvet', 'Testing', '08765', '2021-01-13', 1, '1', '1', 7, 6, 700000, '1', '2021-01-23 14:29:37'),
(6, 'F-004', 'Test', 'test', '8', '2021-01-23', 1, '1', '0', 0, 0, 700000, '1', '2021-01-23 14:29:30'),
(7, 'F-005', 'Testing', 'Jauh Bet', '8989898', '2021-01-23', 1, '1', '0', 0, 0, 700000, '1', '2021-01-23 15:31:11'),
(8, 'F-006', 'Lukman H', 'shshshshsh', '9898922', '2021-01-23', 1, '1', '1', 10, 7, 700000, '1', '2021-01-23 15:31:18');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`_id`, `nik`, `nama`, `jk`, `tempat_lahir`, `tgl_lahir`, `tgl_masuk`, `posisi`, `alamat`, `password`, `is_aktif`, `created_at`) VALUES
(1, '11215176', 'Lukman Hadi', 'L', 'dijauh bos', '2021-01-03', '2021-01-05', '2', 'kepoooo', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1', '2021-01-17 17:03:41'),
(3, '11215179', 'Lukman Kasep', 'L', 'Padneglang', '2020-12-31', '2021-01-16', '1', 'JAUH', '$2y$04$pHmCNi/c6Tm66jpjkb2mBOQ4a4Lu.NeYtRomSzalCHvlroZEO1GgG', '1', '2021-01-18 12:25:21'),
(4, '11215177', 'Sales', 'L', 'Jauh', '2021-01-20', '2021-01-20', '5', 'Jds', '$2y$04$mKx6ogDf6XBQA4x/NWrKEuIQ96zqy7M/BuKIi8qENN9IgmyPwlmVC', '0', '2021-01-20 16:04:28');

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
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_catatan`
--
ALTER TABLE `tbl_catatan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_penagihan`
--
ALTER TABLE `tbl_penagihan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
