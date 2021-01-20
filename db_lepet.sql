-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2021 at 11:25 AM
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
(1, 'P-001', 'Panci Ajaib', 700000, 50, '2021-01-18 14:08:31'),
(2, 'P-002', 'Panci Kurang Ajaib Tapi Boong', 1000000, 70, '2021-01-18 14:20:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_masuk`
--

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
(1, 'M-001', 1, 20, '2021-01-03', '2021-01-18 15:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penagihan`
--

CREATE TABLE `tbl_penagihan` (
  `_id` int(11) NOT NULL,
  `kode_bayar` int(11) NOT NULL,
  `no_faktur` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `_id` int(11) NOT NULL,
  `no_faktur` char(11) NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `alamat` longtext NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `kode_barang` int(11) NOT NULL,
  `nik_sales` char(11) NOT NULL,
  `status_bayar` enum('0','1','2') NOT NULL,
  `status_penjualan` enum('0','1') NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perusahaan`
--

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
(1, '11215176', 'Lukman Hadi', 'L', 'dijauh bos', '2021-01-03', '2021-01-05', '2', 'kepoooo', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1', '2021-01-17 17:03:41'),
(3, '11215179', 'Lukman Kasep', 'L', 'Padneglang', '2020-12-31', '2021-01-16', '1', 'JAUH', '$2y$04$pHmCNi/c6Tm66jpjkb2mBOQ4a4Lu.NeYtRomSzalCHvlroZEO1GgG', '1', '2021-01-18 12:25:21');

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
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_penagihan`
--
ALTER TABLE `tbl_penagihan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
