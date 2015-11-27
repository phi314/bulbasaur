-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 24, 2015 at 02:44 
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bulbasaur_rfid`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE IF NOT EXISTS `absensi` (
`id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `absen` varchar(10) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_siswa`, `tanggal`, `jam_masuk`, `jam_pulang`, `absen`, `keterangan`, `id_guru`, `created_at`, `updated_at`) VALUES
(11, 3, '2015-11-24', '10:25:07', '11:43:53', 'HADIR', '', NULL, '2015-11-24 10:25:07', '2015-11-24 04:43:53'),
(12, 2, '2015-11-24', '10:25:16', '11:43:46', 'HADIR', '', NULL, '2015-11-24 10:25:16', '2015-11-24 04:43:46'),
(13, 1, '2015-11-24', '10:25:19', '11:43:39', 'HADIR', '', NULL, '2015-11-24 10:25:19', '2015-11-24 04:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE IF NOT EXISTS `guru` (
`id` int(11) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(32) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `id_guru` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `jk`, `is_admin`, `username`, `password`, `is_active`, `id_guru`, `created_at`, `updated_at`) VALUES
(1, '123456789', 'Rahmad Darmawan, S.pd', '1', 1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, NULL, '2015-10-30 14:17:36', '2015-11-24 05:53:49'),
(2, '12345678910', 'Deni Nurdin, S.T', 'l', 0, 'guru', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-11-01 15:58:24', '2015-11-24 05:53:59'),
(3, '123', 'Dharmawati, S.pd', 'p', 0, 'dharma0212', 'bb4b09f66e7957df63bca43a271e29e92902bbc9', 1, 1, '2015-11-01 18:18:01', '2015-11-24 05:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
`id` int(11) NOT NULL,
  `tingkat` varchar(1) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tahun` year(4) NOT NULL,
  `id_guru` int(11) NOT NULL COMMENT 'walikelas',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `tingkat`, `nama`, `tahun`, `id_guru`, `created_at`, `updated_at`) VALUES
(1, '1', 'A', 2015, 1, '0000-00-00 00:00:00', '2015-11-02 09:44:42'),
(2, '1', 'B', 2015, 1, '0000-00-00 00:00:00', '2015-11-02 09:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE IF NOT EXISTS `pembayaran` (
`id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_guru` int(11) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `nama`, `jumlah`, `tanggal`, `id_guru`, `is_aktif`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Topup', 0, '2015-10-15 00:00:00', 1, 1, '', '2015-11-15 13:08:05', '2015-11-15 06:08:05'),
(6, 'Iuran Bulan November', 120000, '2015-11-01 00:00:00', 1, 1, '', '2015-11-15 05:02:03', '2015-11-15 04:02:03'),
(7, 'Iuran Bulan Desember', 80000, '2015-12-01 00:00:00', 1, 1, '', '2015-11-24 14:17:22', '2015-11-24 07:17:22');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `max_jam_masuk` time NOT NULL,
  `min_jam_pulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`max_jam_masuk`, `min_jam_pulang`) VALUES
('07:00:00', '11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE IF NOT EXISTS `siswa` (
`id` int(11) NOT NULL,
  `rfid` varchar(20) NOT NULL,
  `nis` varchar(15) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `rfid`, `nis`, `nama`, `jk`, `id_guru`, `id_kelas`, `saldo`, `created_at`, `updated_at`) VALUES
(1, '0005367784', '11236856569', 'Jajang Sukmara', 'l', 0, 1, 800000, '0000-00-00 00:00:00', '2015-11-24 07:21:53'),
(2, '0006505552', '11236856562', 'Anggi Putri', 'p', 1, 2, 1000000, '0000-00-00 00:00:00', '2015-11-24 07:23:17'),
(3, '0007163614', '012938473682', 'Resmi Novianti', 'p', 1, 2, 800000, '2015-11-15 04:09:45', '2015-11-24 07:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE IF NOT EXISTS `transaksi` (
`id` int(11) NOT NULL,
  `kode` varchar(12) NOT NULL,
  `tipe` enum('in','out') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `saldo_akhir` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode`, `tipe`, `jumlah`, `id_siswa`, `tanggal`, `id_pembayaran`, `saldo_akhir`, `id_guru`, `created_at`, `updated_at`) VALUES
(16, '0ebeb817', 'in', 1000000, 3, '2015-11-24 14:21:25', 1, 1000000, 1, '2015-11-24 14:21:25', '2015-11-24 07:21:25'),
(17, '9b5c4500', 'in', 1200000, 2, '2015-11-24 14:21:42', 1, 1200000, 1, '2015-11-24 14:21:42', '2015-11-24 07:21:42'),
(18, '78351baf', 'in', 800000, 1, '2015-11-24 14:21:53', 1, 800000, 1, '2015-11-24 14:21:53', '2015-11-24 07:21:53'),
(19, '0a0cee26', 'out', 120000, 3, '2015-11-24 14:22:26', 6, 880000, 0, '2015-11-24 14:22:26', '2015-11-24 07:22:26'),
(20, '6f2c71e1', 'out', 80000, 3, '2015-11-24 14:22:44', 7, 800000, 0, '2015-11-24 14:22:44', '2015-11-24 07:22:44'),
(21, '5bebbe51', 'out', 80000, 2, '2015-11-24 14:23:03', 7, 1120000, 0, '2015-11-24 14:23:03', '2015-11-24 07:23:03'),
(22, '47de708e', 'out', 120000, 2, '2015-11-24 14:23:17', 6, 1000000, 0, '2015-11-24 14:23:17', '2015-11-24 07:23:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
 ADD PRIMARY KEY (`id`), ADD KEY `id_siswa` (`id_siswa`,`id_guru`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
 ADD PRIMARY KEY (`id`), ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
 ADD PRIMARY KEY (`id`), ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `rfid` (`rfid`), ADD KEY `id_guru` (`id_guru`), ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
 ADD PRIMARY KEY (`id`), ADD KEY `id_siswa` (`id_siswa`), ADD KEY `id_guru` (`id_guru`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
