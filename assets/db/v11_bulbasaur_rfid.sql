-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 24, 2015 at 10:16 
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
CREATE DATABASE IF NOT EXISTS `bulbasaur_rfid` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bulbasaur_rfid`;

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE IF NOT EXISTS `absensi` (
`id` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_pelajaran` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `id_tahun_ajaran` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_guru`, `id_pelajaran`, `id_kelas`, `tanggal`, `keterangan`, `id_tahun_ajaran`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, '2015-11-25', 'Bahasa Indonesia', 1, '2015-11-25 21:50:42', '2015-12-24 02:35:48'),
(2, 1, 0, 0, '2015-11-25', 'Bahasa Indonesia', 1, '2015-11-25 21:56:27', '2015-12-24 02:35:52'),
(3, 1, 0, 0, '2015-11-25', 'Bahasa Indonesia\r\n', 1, '2015-11-25 21:56:39', '2015-12-24 02:35:55'),
(4, 12, 0, 0, '2015-12-04', 'matematika\r\n', 1, '2015-12-04 16:10:32', '2015-12-24 02:35:56'),
(5, 2, 1, 1, '2015-12-15', '', 1, '2015-12-15 15:28:45', '2015-12-24 02:35:58'),
(6, 2, 1, 1, '2015-12-17', '2', 1, '2015-12-17 20:21:35', '2015-12-24 02:36:00'),
(7, 2, 1, 2, '2015-12-17', '1', 1, '2015-12-17 20:28:23', '2015-12-24 02:36:01'),
(9, 2, 2, 1, '2015-12-24', '', 1, '2015-12-24 09:30:06', '2015-12-24 02:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `absensi_detail`
--

CREATE TABLE IF NOT EXISTS `absensi_detail` (
`id` int(11) NOT NULL,
  `id_absensi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `absen` varchar(10) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi_detail`
--

INSERT INTO `absensi_detail` (`id`, `id_absensi`, `id_siswa`, `tanggal`, `jam_masuk`, `absen`, `keterangan`, `created_at`, `updated_at`) VALUES
(33, 6, 5, '2015-12-04', '16:50:53', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-17 14:30:58'),
(34, 6, 4, '2015-12-04', '16:50:55', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-17 14:31:00'),
(35, 7, 7, '2015-12-04', '16:51:06', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-17 13:51:22'),
(36, 6, 6, '2015-12-04', '16:51:08', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-17 14:31:02'),
(37, 7, 3, '2015-12-04', '16:51:12', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-17 13:51:25'),
(38, 1, 6, '2015-12-24', '09:53:42', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 02:53:42'),
(39, 1, 7, '2015-12-24', '09:53:48', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 02:53:48'),
(40, 1, 4, '2015-12-24', '09:53:51', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 02:53:51'),
(41, 1, 8, '2015-12-24', '09:53:59', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 02:53:59'),
(42, 1, 5, '2015-12-24', '09:54:02', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 02:54:02'),
(43, 2, 8, '2015-12-24', '09:54:16', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 02:54:16'),
(44, 2, 5, '2015-12-24', '09:54:22', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 02:54:22'),
(45, 9, 8, '2015-12-24', '10:05:14', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 03:05:14'),
(46, 9, 5, '2015-12-24', '10:05:25', 'HADIR', '', '0000-00-00 00:00:00', '2015-12-24 03:05:25');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE IF NOT EXISTS `guru` (
`id` int(11) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `user_level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: guru, 1: admin, 2: tu',
  `username` varchar(32) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `id_guru` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `jk`, `user_level`, `username`, `password`, `is_active`, `id_guru`, `created_at`, `updated_at`) VALUES
(1, '196008021985033', 'Rahmad Darmawan, S.pd', 'l', 0, 'rahmed', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, NULL, '2015-10-30 14:17:36', '2015-12-03 16:30:31'),
(2, '196068021355054', 'Deni Nurdin, S.T', 'l', 0, 'guru', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-11-01 15:58:24', '2015-12-03 16:30:44'),
(3, '196328421352053', 'Dharmawati, S.pd', 'p', 0, 'dharma0212', 'bb4b09f66e7957df63bca43a271e29e92902bbc9', 1, 1, '2015-11-01 18:18:01', '2015-12-03 16:31:07'),
(12, '196328528362055', 'Yandi Sofyan', 'l', 1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1, '0000-00-00 00:00:00', '2015-12-03 16:31:22'),
(13, '196321221352053', 'Mumsika Habibah', 'p', 2, 'tu', 'a3da4c6307d230e1f1c8ad62e00d05ff1f1f5b52', 1, 1, '0000-00-00 00:00:00', '2015-12-03 16:31:32'),
(14, '196111111986031', 'Drs.Agus Rukmawan,S.IP,MM', 'l', 0, '196111111986031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(15, '195711121984031', 'Drs.H. Shihabudin,S.Pd', 'p', 0, '195711121984031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(16, '195911141987031', 'Drs.Dedi Kusdinar,MM', 'l', 0, '195911141987031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(17, '196105121986032', 'Dra.Hj. Marpuah', 'p', 0, '196105121986032', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(18, '195902121984031', 'Drs.Asep Kundrat', 'l', 0, '195902121984031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(19, '196008021985031', 'Drs.Tamrin,M.Pd', 'l', 0, '196008021985031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(20, '196107031988031', 'Drs.Lalu Mugni', 'l', 0, '196107031988031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(21, '196105121988031', 'Drs.Maman Kosman,MM', 'l', 0, '196105121988031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(22, '196203161986031', 'Drs.Bahrudin,MM', 'l', 0, '196203161986031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:44'),
(23, '196201221987031', 'Drs.H.Trisdonardi', 'l', 0, '196201221987031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(24, '196107201988031', 'Drs.Abdul Hamid', 'l', 0, '196107201988031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(25, '195909301988032', 'Dra.Hj.Jeni Sarojini Somawi', 'p', 0, '195909301988032', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(26, '195502201980031', 'Drs.Asban Silitonga', 'l', 0, '195502201980031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(27, '196503051991031', 'Drs.Wiyono', 'l', 0, '196503051991031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(28, '196610291992031', 'Drs.Deden Hamdani,MM', 'l', 0, '196610291992031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(29, '195607231984101', 'Drs.Ridwan Efendi', 'l', 0, '195607231984101', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(30, '196003151988031', 'H.Rusmadi,S.Pd', 'l', 0, '196003151988031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(31, '196406111988031', 'Asep Mahmudin,S.Pd,MM', 'l', 0, '196406111988031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(32, '195502241980031', 'Wawan Kustiawan,S.Pd', 'l', 0, '195502241980031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(33, '196603081988032', 'Ida Farida Artati', 'l', 0, '196603081988032', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(34, '196501011989021', 'Uma Pahrevi,S.Pd,M.Pd', 'p', 0, '196501011989021', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(35, '196401021993031', 'Drs.Yosmar Sumargana,M.Pd', 'p', 0, '196401021993031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(36, '196412041994031', 'Drs.H.Dedi Jubaedi,MM', 'p', 0, '196412041994031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(37, '195603011994061', 'Drs.Iyan Sukhyar', 'p', 0, '195603011994061', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(38, '196202261987031', 'Sutarsa', 'l', 0, '196202261987031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(39, '196803111990031', 'Cosmas Marojahan SitanggangS.Pd, MM', 'l', 0, '196803111990031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(40, '195801251994031', 'Drs.Tatang Haidar', 'l', 0, '195801251994031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(41, '196105121994031', 'Drs.H.Ujang Komarudin,S.Pd,MM', 'l', 0, '196105121994031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(42, '196911101994032', 'Hj.Diah Handayani, S.Pd', 'p', 0, '196911101994032', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(43, '196801021995121', 'Sukma Surya Purnama,S.Pd,MT', 'l', 0, '196801021995121', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(44, '196408121994121', 'Drs.Kusmaya Permana', 'p', 0, '196408121994121', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(45, '196001131986111', 'Leli Suherli,S.Pd,M.Pd', 'l', 0, '196001131986111', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(46, '196911221997022', 'Dra.Endang Dwi Winarti', 'p', 0, '196911221997022', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(47, '196608171990032', 'Hy.Bara Tulastiana', 'l', 0, '196608171990032', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(48, '197101191998011', 'Dedi Suandi Setiawan,S.Pd,M.Pd', 'p', 0, '197101191998011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(49, '196809172000121', 'Abdul Hapid,S.Pd', 'l', 0, '196809172000121', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(50, '196708141999031', 'Caska,S.Pd', 'l', 0, '196708141999031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(51, '196305271998031', 'Sugeng,S.Pd,M.Pd', 'l', 0, '196305271998031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(52, '196711041992031', 'Dendi Bagus Wicaksana,S.ST', 'l', 0, '196711041992031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:45'),
(53, '197012092005011', 'Ahmad Bustomi Sahrul,S.Pd', 'p', 0, '197012092005011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(54, '197008102005011', 'Tjetjep Rony Budiman,S.Pd, MT', 'l', 0, '197008102005011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(55, '197305072005012', 'Alia Maedina,S.Pd,M.Pd', 'p', 0, '197305072005012', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(56, '197702232005011', 'Dafik Derajat,S.Pd', 'p', 0, '197702232005011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(57, '197106171998011', 'Asep Tatang Suryana,S.Pd,MM', 'p', 0, '197106171998011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(58, '197509052005011', 'Pono Siswanto,M.Pd', 'p', 0, '197509052005011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(59, '197206162006041', 'Risin,S.Pd', 'p', 0, '1972061620060410', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(60, '197310092000604', 'H.Chaerudin,S.Pd,MM', 'l', 0, '19731009.200604.1.', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-16 13:25:01'),
(61, '197608242006042', 'Hj.Diah Gustanti,ST', 'l', 0, '197608242006042', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(62, '197702252006041', 'Husain Choiri,S.Pd.T', 'p', 0, '197702252006041', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(63, '196607132007011', 'Drs.Encep Pranseda,M.Pd', 'l', 0, '196607132007011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(64, '196910102008012', 'Faridawaty Saragih,S.Si', 'l', 0, '196910102008012', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(65, '197408162007011', 'Roi Supriadi,S.Pd', 'l', 0, '197408162007011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(66, '196606112008011', 'Slamet Raharjo,S.Pd, MT', 'l', 0, '196606112008011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(67, '198009042009022', 'Rita Rosita,S.Pd', 'p', 0, '198009042009022', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(68, '197410202007012', 'Iin Kartini,S.Pd', 'l', 0, '197410202007012', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(69, '196511302007011', 'A.Solihuddin,S.Pd.I,M.Pd', 'l', 0, '196511302007011', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(70, '198208172010012', 'Eka Merdekawati,S.Pd', 'l', 0, '198208172010012', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(71, '197710122009022', 'Siti Nurhayati,S.Pd', 'l', 0, '197710122009022', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(72, '197804062009022', 'Heni Handayani H,S.Pd', 'p', 0, '197804062009022', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(73, '196511111986031', 'Suryana', 'l', 0, '196511111986031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(74, '196407051986021', 'Ahmadi', 'p', 0, '196407051986021', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(75, '196604161991031', 'Saman, S.Pd.I', 'p', 0, '196604161991031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46'),
(76, '196303142000003', 'Taslim', 'l', 0, '1963031420000031', 'a1872e333d0e52644f6125da2276530f7ebe5e77', 1, NULL, '2015-12-03 00:00:00', '2015-12-03 16:23:46');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
`id` int(11) NOT NULL,
  `tingkat` varchar(2) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tahun` year(4) NOT NULL,
  `id_guru` int(11) NOT NULL COMMENT 'walikelas',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `tingkat`, `nama`, `tahun`, `id_guru`, `created_at`, `updated_at`) VALUES
(1, '1', 'A', 2015, 3, '0000-00-00 00:00:00', '2015-11-30 03:15:34'),
(2, '1', 'B', 2015, 1, '0000-00-00 00:00:00', '2015-11-02 09:44:32'),
(3, '3', 'A', 2015, 2, '2015-11-30 11:00:58', '2015-11-30 04:00:58');

-- --------------------------------------------------------

--
-- Table structure for table `pelajaran`
--

CREATE TABLE IF NOT EXISTS `pelajaran` (
`id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelajaran`
--

INSERT INTO `pelajaran` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Matematika', '2015-12-15 15:15:56', '2015-12-15 08:15:56'),
(2, 'Bahasa Indonesia', '2015-12-15 15:16:04', '2015-12-15 08:16:04'),
(3, 'Biologi', '2015-12-15 15:16:26', '2015-12-15 08:16:26');

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
(7, 'Iuran Bulan Desember', 150000, '2015-12-01 00:00:00', 13, 1, '', '2015-12-24 09:40:27', '2015-12-24 02:40:27');

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
  `rfid` varchar(20) DEFAULT NULL,
  `nis` varchar(15) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `id_guru` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `saldo` int(11) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `rfid`, `nis`, `nama`, `jk`, `id_guru`, `id_kelas`, `saldo`, `telepon`, `created_at`, `updated_at`) VALUES
(3, '0007163614', '14150922', 'Resmi Novianti', 'p', 1, 2, 800000, '085722010699', '2015-11-15 04:09:45', '2015-12-17 14:30:42'),
(4, '0008569586', '14150001', 'Adi Setya Permana', 'l', 0, 1, 50000, '', '2015-12-03 00:00:00', '2015-12-24 02:52:51'),
(5, '0008618587', '14150002', 'Agung Kurniawan Ritonga', 'l', 0, 1, 0, '', '2015-12-03 00:00:00', '2015-12-17 13:52:03'),
(6, '0008580485', '14150004', 'Ajeng Indah Pramudita Sari', 'p', 0, 1, 850000, '', '2015-12-03 00:00:00', '2015-12-24 02:51:33'),
(7, '0008579197', '14150005', 'Ardisa Lestari', 'p', 0, 1, 300000, '', '2015-12-03 00:00:00', '2015-12-24 02:52:19'),
(8, '0008574702', '14150006', 'Asep Erdin', 'l', 0, 2, 0, '', '2015-12-03 00:00:00', '2015-12-17 14:29:50'),
(9, NULL, '14150007', 'Burhanudin', 'l', NULL, 2, 0, '', '2015-12-03 00:00:00', '2015-12-17 14:29:48'),
(10, NULL, '14150008', 'Danis Fikri', 'l', NULL, 2, 0, '', '2015-12-03 00:00:00', '2015-12-17 14:29:45'),
(11, NULL, '14150009', 'Devi Ramadhanis', 'p', NULL, 1, 0, '', '2015-12-03 00:00:00', '2015-12-17 13:52:08'),
(12, NULL, '14150010', 'Dikri Fauzan Adam', 'l', NULL, 1, 0, '', '2015-12-03 00:00:00', '2015-12-17 13:52:12'),
(13, NULL, '14150011', 'Edah Jubaedah', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:35'),
(14, NULL, '14150012', 'Fithri Fadhillah', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:35'),
(15, NULL, '14150013', 'Fitra Ragastara', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:35'),
(16, NULL, '14150014', 'Frida Wulan Dari', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:35'),
(17, NULL, '14150015', 'Haidir Jafar Sidiq', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(18, NULL, '14150016', 'Ibnu Kemal Mustafa', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(19, NULL, '14150017', 'Indriyani', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(20, NULL, '14150018', 'Janudin', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(21, NULL, '14150019', 'Karnaya', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(22, NULL, '14150020', 'Lita Fauziyah Utami', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(23, NULL, '14150021', 'Mamal Maillani', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(24, NULL, '14150022', 'Mega Septiani', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(25, NULL, '14150023', 'Mochammad Iqbal Ramadhan', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(26, NULL, '14150024', 'Muhammad Iskandar Zulkarnaen', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(27, NULL, '14150025', 'Mutiara Hermania', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(28, NULL, '14150026', 'Nur Agesti', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(29, NULL, '14150027', 'Pedrik Maulana', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(30, NULL, '14150028', 'Muhammad Faisal Alifa Shidik', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(31, NULL, '14150029', 'Rayana Rizki Zaini', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(32, NULL, '14150030', 'Ridwan Maulana', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(33, NULL, '14150031', 'Rifqi Bachtiar Abdul Wahab', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(34, NULL, '14150032', 'Riva Maryani', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(35, NULL, '14150033', 'Suryani', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(36, NULL, '14150034', 'Syifa Nur Ihsani', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(37, NULL, '14150035', 'Utari Krisyanti', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(38, NULL, '14150036', 'Vicky Mauludin S', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(39, NULL, '14150037', 'Wawan Hardiana', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(40, NULL, '14150038', 'Wibianto Adi Nugroho', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(41, NULL, '14150039', 'Winda Hadi Suteja', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(42, NULL, '14150040', 'Yogi Wahyu Ramadhan', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(43, NULL, '14150880', 'Achmad Bima Wardana', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(44, NULL, '14150881', 'Aditya Nur Ramadhan', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(45, NULL, '14150882', 'Afdal Khalid', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:36'),
(46, NULL, '14150883', 'Anna Nur Jannah', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(47, NULL, '14150884', 'Aulia Dewi Kumala Sari', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(48, NULL, '14150885', 'Bobby Abdurrahman Haris', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(49, NULL, '14150886', 'Chitia Liviana Kurniawan', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(50, NULL, '14150887', 'Dion Supriatna', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(51, NULL, '14150888', 'Eksa Bagus Utama', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(52, NULL, '14150889', 'Fadlika', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(53, NULL, '14150890', 'Fretty Yulyenta Santa Anna', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(54, NULL, '14150891', 'Handika Deon Hartono', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(55, NULL, '14150892', 'Kevin Christianto', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(56, NULL, '14150893', 'Laela Destiana', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(57, NULL, '14150894', 'Lina Zulkarnaen', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(58, NULL, '14150895', 'Mochammad Alfian Jurdil Hidayatulloh', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(59, NULL, '14150896', 'Muhammad Ardiansyah', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(60, NULL, '14150897', 'Muhammad Kresna Mahardika', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(61, NULL, '14150898', 'Muhammad Panji Maulana', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(62, NULL, '14150899', 'Nanang Hidayat', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(63, NULL, '14150900', 'Nanda Shella Aryani', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(64, NULL, '14150901', 'Nazaryo Radja', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(65, NULL, '14150902', 'Nur Ika Anung Essa', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(66, NULL, '14150903', 'Pradana Ramdan Pangestu', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:37'),
(67, NULL, '14150904', 'Puspa Nurmalasari', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(68, NULL, '14150905', 'Rama Dhani Al Jaelani', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(69, NULL, '14150906', 'Ratnasari', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(70, NULL, '14150907', 'Rina Paramita', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(71, NULL, '14150908', 'Riziq Ainnur Rohmat', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(72, NULL, '14150909', 'Rizky Anugrah', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(73, NULL, '14150910', 'Sartika', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(74, NULL, '14150911', 'Siti Rokayah', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(75, NULL, '14150912', 'Tiara Nita Julian', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(76, NULL, '14150913', 'Tuti Alawiah', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(77, NULL, '14150914', 'Vera Anjang Juniar', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(78, NULL, '14150915', 'Virdy Ramadhani', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(79, NULL, '14150916', 'Yola Febria', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(80, NULL, '14150917', 'Yusi Sekar Armianti', 'p', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(81, NULL, '14150918', 'Yusuf Rudiana', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(82, NULL, '14150919', 'Zaldy Ramadhani Sanusi', 'l', NULL, NULL, 0, '', '2015-12-03 00:00:00', '2015-12-03 16:15:38'),
(89, '12345', '123', '123', 'l', 12, NULL, 0, '', '2015-12-16 20:16:48', '2015-12-16 13:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE IF NOT EXISTS `tahun_ajaran` (
`id` int(11) NOT NULL,
  `tahun` varchar(9) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `tahun`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, '2015-2016', 1, '2015-12-24 09:01:28', '2015-12-24 02:35:38'),
(2, '2017-2018', 0, '2015-12-24 09:17:33', '2015-12-24 02:35:38');

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
  `sms_notification` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode`, `tipe`, `jumlah`, `id_siswa`, `tanggal`, `id_pembayaran`, `saldo_akhir`, `id_guru`, `sms_notification`, `created_at`, `updated_at`) VALUES
(19, '0a0cee26', 'out', 120000, 3, '2015-11-24 14:22:26', 6, 880000, 0, 1, '2015-11-24 14:22:26', '2015-12-10 11:16:37'),
(25, '093d5783', 'in', 600000, 6, '2015-12-24 09:49:27', 1, 600000, 13, 0, '2015-12-24 09:49:27', '2015-12-24 02:49:27'),
(26, 'afc02cd8', 'in', 400000, 6, '2015-12-24 09:49:52', 1, 1000000, 13, 0, '2015-12-24 09:49:52', '2015-12-24 02:49:52'),
(27, 'f8df9af0', 'out', 150000, 6, '2015-12-24 09:51:33', 7, 850000, 0, 0, '2015-12-24 09:51:33', '2015-12-24 02:51:33'),
(28, '68948ec0', 'in', 450000, 7, '2015-12-24 09:52:14', 1, 450000, 13, 0, '2015-12-24 09:52:14', '2015-12-24 02:52:14'),
(29, '431c95be', 'out', 150000, 7, '2015-12-24 09:52:19', 7, 300000, 0, 0, '2015-12-24 09:52:19', '2015-12-24 02:52:19'),
(30, '43e08f09', 'in', 200000, 4, '2015-12-24 09:52:39', 1, 200000, 13, 0, '2015-12-24 09:52:39', '2015-12-24 02:52:39'),
(31, 'ad6b4ebe', 'out', 150000, 4, '2015-12-24 09:52:51', 7, 50000, 0, 0, '2015-12-24 09:52:51', '2015-12-24 02:52:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
 ADD PRIMARY KEY (`id`), ADD KEY `id_guru` (`id_guru`), ADD KEY `id_guru_2` (`id_guru`), ADD KEY `id_pelajaran` (`id_pelajaran`), ADD KEY `id_kelas` (`id_kelas`), ADD KEY `id_tahun_ajaran` (`id_tahun_ajaran`);

--
-- Indexes for table `absensi_detail`
--
ALTER TABLE `absensi_detail`
 ADD PRIMARY KEY (`id`), ADD KEY `id_siswa` (`id_siswa`), ADD KEY `id_absensi` (`id_absensi`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `nip` (`nip`), ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
 ADD PRIMARY KEY (`id`), ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `pelajaran`
--
ALTER TABLE `pelajaran`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
 ADD PRIMARY KEY (`id`), ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `nis` (`nis`), ADD UNIQUE KEY `rfid` (`rfid`), ADD KEY `id_guru` (`id_guru`), ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
 ADD PRIMARY KEY (`id`), ADD KEY `id_siswa` (`id_siswa`), ADD KEY `id_guru` (`id_guru`), ADD KEY `id_siswa_2` (`id_siswa`), ADD KEY `id_pembayaran` (`id_pembayaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `absensi_detail`
--
ALTER TABLE `absensi_detail`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pelajaran`
--
ALTER TABLE `pelajaran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`);

--
-- Constraints for table `absensi_detail`
--
ALTER TABLE `absensi_detail`
ADD CONSTRAINT `absensi_detail_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`),
ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
