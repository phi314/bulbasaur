-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 02, 2014 at 09:25 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tamankota`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `waktu` datetime NOT NULL,
  `lama` int(11) NOT NULL COMMENT 'per hari',
  `id_petugas` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_petugas` (`id_petugas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `nama`, `deskripsi`, `waktu`, `lama`, `id_petugas`, `create_date`, `update_date`) VALUES
(1, 'BANDUNG JOB FAIR', 'Ada &lt;b&gt;Ridwan Kamil &lt;/b&gt;lohhh...&lt;br&gt;', '2014-12-11 10:30:00', 2, 1, '2014-12-02 19:53:56', '2014-12-02 13:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE IF NOT EXISTS `fasilitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama` (`nama`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama`, `created_date`, `updated_date`) VALUES
(1, 'WIFI', '2014-11-16 22:28:54', '2014-11-16 15:28:54'),
(2, 'TEMPAT DUDUK', '2014-11-16 22:33:39', '2014-11-16 15:33:39'),
(3, 'LAMPU TAMAN', '2014-11-16 22:37:15', '2014-11-16 15:37:15'),
(4, 'PANGGUNG', '2014-11-16 22:37:59', '2014-11-16 15:37:59'),
(5, 'AREA BERMAIN ANAK', '2014-11-16 22:38:19', '2014-11-16 15:38:19'),
(6, 'BUNGA', '2014-11-16 22:39:01', '2014-11-16 15:39:01'),
(7, 'KOLAM IKAN', '2014-11-16 22:39:16', '2014-11-16 15:39:16'),
(8, 'AREA BERMAIN SKATEBOARD', '2014-11-16 22:39:25', '2014-11-16 15:39:25'),
(9, 'LAYAR TV', '2014-11-16 22:46:11', '2014-11-16 15:46:11'),
(10, 'TOILET', '2014-11-16 22:46:24', '2014-11-16 15:46:24'),
(11, 'LAPANGAN FUTSAL', '2014-11-16 22:46:36', '2014-11-16 15:46:36'),
(12, 'AREA OLAH RAGA', '2014-11-16 22:46:44', '2014-11-16 17:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_lokasi`
--

CREATE TABLE IF NOT EXISTS `fasilitas_lokasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lokasi` int(11) NOT NULL,
  `id_fasilitas` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_lokasi` (`id_lokasi`,`id_fasilitas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `fasilitas_lokasi`
--

INSERT INTO `fasilitas_lokasi` (`id`, `id_lokasi`, `id_fasilitas`, `created_date`, `updated_date`) VALUES
(14, 5, 3, '2014-11-17 00:02:24', '2014-11-16 17:02:24'),
(15, 5, 4, '2014-11-17 00:02:24', '2014-11-16 17:02:24'),
(16, 5, 2, '2014-11-17 00:02:24', '2014-11-16 17:02:24'),
(17, 5, 1, '2014-11-17 00:02:24', '2014-11-16 17:02:24'),
(18, 6, 5, '2014-11-17 00:33:55', '2014-11-16 17:33:55'),
(19, 6, 3, '2014-11-17 00:33:55', '2014-11-16 17:33:55'),
(20, 6, 2, '2014-11-17 00:33:55', '2014-11-16 17:33:55'),
(21, 6, 1, '2014-11-17 00:33:55', '2014-11-16 17:33:55'),
(22, 7, 6, '2014-11-17 00:36:27', '2014-11-16 17:36:27'),
(23, 7, 7, '2014-11-17 00:36:27', '2014-11-16 17:36:27'),
(24, 7, 3, '2014-11-17 00:36:27', '2014-11-16 17:36:27'),
(25, 7, 2, '2014-11-17 00:36:27', '2014-11-16 17:36:27'),
(26, 7, 1, '2014-11-17 00:36:27', '2014-11-16 17:36:27'),
(27, 8, 2, '2014-11-17 00:37:55', '2014-11-16 17:37:55'),
(28, 8, 1, '2014-11-17 00:37:55', '2014-11-16 17:37:55'),
(29, 9, 8, '2014-11-17 00:39:30', '2014-11-16 17:39:30'),
(30, 9, 3, '2014-11-17 00:39:30', '2014-11-16 17:39:30'),
(31, 9, 2, '2014-11-17 00:39:30', '2014-11-16 17:39:30'),
(32, 9, 1, '2014-11-17 00:39:30', '2014-11-16 17:39:30'),
(33, 1, 3, '2014-11-17 00:40:33', '2014-11-16 17:40:33'),
(34, 1, 9, '2014-11-17 00:40:33', '2014-11-16 17:40:33'),
(35, 1, 2, '2014-11-17 00:40:33', '2014-11-16 17:40:33'),
(36, 1, 1, '2014-11-17 00:40:33', '2014-11-16 17:40:33'),
(37, 10, 5, '2014-11-17 00:41:52', '2014-11-16 17:41:52'),
(38, 10, 3, '2014-11-17 00:41:52', '2014-11-16 17:41:52'),
(39, 10, 2, '2014-11-17 00:41:52', '2014-11-16 17:41:52'),
(40, 11, 12, '2014-11-17 00:43:11', '2014-11-16 17:43:11'),
(41, 11, 3, '2014-11-17 00:43:11', '2014-11-16 17:43:11'),
(42, 11, 11, '2014-11-17 00:43:11', '2014-11-16 17:43:11'),
(43, 11, 2, '2014-11-17 00:43:11', '2014-11-16 17:43:11'),
(44, 11, 10, '2014-11-17 00:43:11', '2014-11-16 17:43:11'),
(45, 11, 1, '2014-11-17 00:43:11', '2014-11-16 17:43:11'),
(46, 12, 3, '2014-11-17 00:46:26', '2014-11-16 17:46:26'),
(47, 12, 2, '2014-11-17 00:46:26', '2014-11-16 17:46:26'),
(48, 12, 1, '2014-11-17 00:46:26', '2014-11-16 17:46:26'),
(49, 13, 3, '2014-11-17 00:47:33', '2014-11-16 17:47:33'),
(50, 13, 2, '2014-11-17 00:47:34', '2014-11-16 17:47:34'),
(51, 13, 1, '2014-11-17 00:47:34', '2014-11-16 17:47:34'),
(52, 14, 3, '2014-11-17 00:56:18', '2014-11-16 17:56:18'),
(53, 14, 2, '2014-11-17 00:56:19', '2014-11-16 17:56:19'),
(54, 14, 1, '2014-11-17 00:56:19', '2014-11-16 17:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_lokasi`
--

CREATE TABLE IF NOT EXISTS `gallery_lokasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lokasi` int(11) NOT NULL,
  `filename` varchar(120) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `gallery_lokasi`
--

INSERT INTO `gallery_lokasi` (`id`, `id_lokasi`, `filename`, `created_date`, `updated_date`) VALUES
(1, 7, 'd75901fcb22d49e81c1e77c96b573e317a55306c_1.jpg.jpg', '2014-11-28 14:00:23', '2014-11-28 07:00:23'),
(2, 7, 'd75901fcb22d49e81c1e77c96b573e317a55306c_3.jpg.jpg', '2014-11-28 14:03:29', '2014-11-28 07:03:29'),
(3, 1, '9b0e22194ef09c20c3a3faf3168237b08e8fa119_2.jpg.jpg', '2014-11-28 14:10:59', '2014-11-28 07:10:59'),
(4, 1, '9b0e22194ef09c20c3a3faf3168237b08e8fa119_5.jpg.jpg', '2014-11-28 14:11:07', '2014-11-28 07:11:07'),
(5, 11, 'd57331b3908037073b965d008f736ffbad665385_5.jpg.jpg', '2014-11-28 14:14:33', '2014-11-28 07:14:33'),
(6, 11, 'd57331b3908037073b965d008f736ffbad665385_images.jpg.jpg', '2014-11-28 14:14:41', '2014-11-28 07:14:41'),
(7, 14, '42070ffb1c672ce44ab178708ab5d78ca4da6bb2_2.jpg.jpg', '2014-12-02 20:25:14', '2014-12-02 13:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE IF NOT EXISTS `lokasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_lokasi` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kecamatan` varchar(30) NOT NULL,
  `kelurahan` varchar(30) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `lg` double NOT NULL,
  `lt` double NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `tahun` year(4) NOT NULL,
  `foto_link` varchar(255) NOT NULL,
  `tipe_lokasi` varchar(15) NOT NULL COMMENT 'ada taman ada makam',
  `id_admin` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `kode_lokasi`, `nama`, `alias`, `alamat`, `kecamatan`, `kelurahan`, `kota`, `lg`, `lt`, `deskripsi`, `tahun`, `foto_link`, `tipe_lokasi`, `id_admin`, `createdAt`, `updatedAt`) VALUES
(1, 'TMN-01', 'FILM', '', 'JL. PASUPATI, DIBAWAH JEMBATAN PASUPATI BELAKANG TAMAN SKATEPARK DAN TAMAN JOMBLO', 'DAGO', 'CICENDO', 'BANDUNG', 107.608698, -6.898039, '&lt;b&gt;&lt;/b&gt;Diresmikan pada tahun &lt;b&gt;2014&lt;/b&gt; oleh Walikota Bandung &lt;i&gt;Ridwan Kamil&lt;/i&gt;.&lt;br&gt;', 2014, '356a192b7913b04c54574d18c28d46e6395428ab.jpg', 'TAMAN', 0, '2014-11-11 18:07:46', '2014-11-28 07:10:09'),
(5, 'TMN055', 'MUSIK CENTRUM', '', 'JL. BELITUNG', '', '', 'BANDUNG', 107.616001, -6.911857, 'Ayo &lt;i&gt;Share&lt;/i&gt; karya Musikmu disini!&lt;br&gt;', 2014, '4ddc1ae1549f8b6305504957eade09d38d504d8a.jpg', 'TAMAN', 0, '2014-11-16 23:19:32', '2014-11-28 06:11:47'),
(6, 'TMN003', 'CEMPAKA', 'FOTOGRAFI', 'JL. ANGGREK', '', '', 'BANDUNG', 107.627046, -6.913424, '', 2014, 'c5f462519f176e9a234f480a36aa6ae146903ec2.jpg', 'TAMAN', 0, '2014-11-17 00:26:55', '2014-11-28 06:12:18'),
(7, 'TMN0025', 'CILAKI', 'PUSTAKA BUNGA KANDAGA PUSPA', 'JL. CILAKI', '', '', 'BANDUNG', 107.622906, -6.903422, 'Bunga &lt;i&gt;&lt;/i&gt;lokal dan &lt;i&gt;impor&lt;/i&gt; ada disini.&lt;br&gt;', 2014, 'd75901fcb22d49e81c1e77c96b573e317a55306c.jpg', 'TAMAN', 0, '2014-11-17 00:36:27', '2014-11-16 18:05:51'),
(8, 'TMN0012', 'PASUPATI', 'JOMBLO', 'JL. TAMAN SARI', '', '', 'BANDUNG', 107.609274, -6.898164, 'Untuk para &lt;i&gt;Jomblowan&lt;/i&gt; dan &lt;i&gt;Jomblowati&lt;/i&gt; silahkan mencari jodoh anda.&lt;br&gt;', 2013, '01d57224918495685261546aabe2d85300a45a1a.jpg', 'TAMAN', 1, '2014-11-17 00:37:54', '2014-11-28 06:13:34'),
(9, 'TMN0225', 'SKATEPARK', '', 'JL. TAMAN SARI, BELAKANG TAMAN JOMBLO', '', '', 'BANDUNG', 107.609274, -6.898164, '&lt;i&gt;Skatepunk&lt;/i&gt;&lt;i&gt;ers!&lt;/i&gt; ayo kemari!&lt;br&gt;', 2014, '6fdf8fd06bb76c1ee0e0871509326848fd8021d4.jpg', 'TAMAN', 1, '2014-11-17 00:39:30', '2014-11-28 06:13:43'),
(10, 'TMN1231', 'ANAK TONGKENG', '', 'JL. TONGKENG', '', '', 'BANDUNG', 107.623299, -6.913629, 'Ajaklah anak cucu anda bermain&lt;br&gt;', 2014, '2ecf92892c5d6d782d3f83cd74bb19b5d71e0b21.jpg', 'TAMAN', 0, '2014-11-17 00:41:52', '2014-11-16 18:02:53'),
(11, 'TMNPRSB', 'PERSIB', '', 'JL. SUPRATMAN SETELAH PEREMPATAN', '', '', 'BANDUNG', 107.629883, -6.907657, '6 Lapang Futsal&lt;br&gt;', 2014, 'd57331b3908037073b965d008f736ffbad665385.jpg', 'TAMAN', 0, '2014-11-17 00:43:11', '2014-11-28 08:54:38'),
(12, 'TMNMLK', 'MALUKU', '', 'JL. TAMAN MALUKU', '', '', 'BANDUNG', 107.614251, -6.908461, '', 2001, '2a9e61f8ccef21557598668bd4a06a4b3b8aabcf.jpg', 'TAMAN', 1, '2014-11-17 00:46:25', '2014-11-28 06:13:59'),
(13, 'TMNCKPY', 'CIKAPAYANG DAGO', '', 'JL. IR. H. DJUANDA (JALAN DAGO)', '', '', 'BANDUNG', 107.612543, -6.89862, '', 2007, '9596a670caba7479be4e4948b7bb2fcb725fd1b0.jpg', 'TAMAN', 0, '2014-11-17 00:47:33', '2014-11-16 17:54:22'),
(14, 'TMBVNDA', 'VANDA', '', 'JL. DEWI SARTIKA (BALKOT)', '', '', 'BANDUNG', 107.610144, -6.914025, '', 2014, '42070ffb1c672ce44ab178708ab5d78ca4da6bb2.jpg', 'TAMAN', 1, '2014-11-17 00:56:18', '2014-11-16 17:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_event`
--

CREATE TABLE IF NOT EXISTS `lokasi_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lokasi_event`
--

INSERT INTO `lokasi_event` (`id`, `id_event`, `id_lokasi`, `updated_date`) VALUES
(1, 1, 10, '2014-12-02 12:53:56'),
(2, 1, 5, '2014-12-02 12:53:56'),
(3, 1, 8, '2014-12-02 12:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE IF NOT EXISTS `petugas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nama`, `jk`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `kota`, `telepon`, `email`, `username`, `password`, `is_active`, `create_date`, `updated_date`) VALUES
(1, 'SYAHDAN', 'laki-laki', 'BANDUNG', '1988-07-28', 'Jl. Ngamprah No. 223 Padalarang', 'Cimahi', '085711254699', 'syahdan@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, '2014-10-22 03:00:56', '2014-12-02 12:07:51'),
(6, 'WANDA HAMIDAH', 'perempuan', 'JAKARTA', '1985-03-21', 'Jln. Van Houten no. 88', 'Bandung', '085722569964', 'wanda.hamidah@gmail.com', 'WANDA2080', 'b06b174114394b78787e17f2badde92549401f03', 1, '2014-12-02 18:00:05', '2014-12-02 12:07:15'),
(7, 'ZAENAL MUSTAFA', 'laki-laki', 'Cimahi', '1999-07-19', 'Jl. Mikrowave Komp. Kolones Yakiniku', 'Cimahi', '0857321654845', 'dena@deden.com', 'ZAENA1999', '0f38d1ba5869750ac20f08588dfefe359b94e6a5', 1, '2014-12-02 18:01:36', '2014-12-02 11:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `devices` varchar(100) NOT NULL,
  `signature` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `jk`, `alamat`, `kota`, `telepon`, `email`, `password`, `devices`, `signature`, `created_date`, `updated_date`) VALUES
(11, 'Syafaatul', '', '', '', '', 'syafaatul@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:30.0) Gecko/20100101 Firefox/30.0', '$1$userfulo$uZTEKNwHnPZIDYy4XsH3r.', '2014-11-27 16:28:52', '2014-11-27 09:28:52'),
(13, 'Wahyu Sejati', '', '', '', '', 'wahyu.utama@gmail.com', '3b7375a688b1820b016224646365e127de125ff0', 'Mozilla/5.0 (Linux; U; Android 4.2.2; en-us; HM NOTE 1W Build/JDQ39) AppleWebKit/534.30 (KHTML, like', '$1$userfulo$VuF06yzYDt9zi0ShMhkpD0', '2014-11-27 17:16:48', '2014-12-02 14:20:04'),
(14, 'Hamdan Att', '', '', '', '', 'hamidah@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:30.0) Gecko/20100101 Firefox/30.0', '$1$userfulo$HWqXCvyoDCYVUY4AYaMiM/', '2014-11-27 17:34:34', '2014-12-02 13:57:10'),
(15, 'Iconigo', '', '', '', '', 'iconia@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Mozilla/5.0 (Linux; Android 4.4.4; A500 Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version', '$1$userfulo$yvOC0xd.UQrqSFZ6YPBr6.', '2014-12-02 06:33:48', '2014-12-01 23:33:48');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
