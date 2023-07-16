-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2023 at 07:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `masjid`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`username`, `password`, `nama`) VALUES
('admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `blok`
--

CREATE TABLE `blok` (
  `id_blok` int(11) NOT NULL,
  `nama_blok` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blok`
--

INSERT INTO `blok` (`id_blok`, `nama_blok`) VALUES
(125, 'A'),
(126, 'B'),
(127, 'C'),
(128, 'D'),
(129, 'E'),
(130, 'k');

-- --------------------------------------------------------

--
-- Table structure for table `detail_blok`
--

CREATE TABLE `detail_blok` (
  `id_detail_blok` int(11) NOT NULL,
  `id_blok` int(11) NOT NULL,
  `sub_blok` char(2) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_blok`
--

INSERT INTO `detail_blok` (`id_detail_blok`, `id_blok`, `sub_blok`) VALUES
(191, 125, '1'),
(192, 125, '2'),
(193, 126, '1'),
(194, 126, '2'),
(195, 126, '3'),
(196, 126, '4'),
(197, 127, '1'),
(198, 127, '2'),
(199, 127, '3'),
(200, 128, '1'),
(201, 129, '1'),
(202, 130, ''),
(203, 130, '1'),
(204, 130, '2');

-- --------------------------------------------------------

--
-- Table structure for table `keluarga`
--

CREATE TABLE `keluarga` (
  `id_keluarga` int(11) NOT NULL,
  `wakil_keluarga` varchar(50) NOT NULL,
  `id_detail_blok` int(11) NOT NULL,
  `no_rumah` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluarga`
--

INSERT INTO `keluarga` (`id_keluarga`, `wakil_keluarga`, `id_detail_blok`, `no_rumah`) VALUES
(93, 'Andi', 191, '10'),
(94, 'mukidi', 203, '11'),
(95, 'ny. saya', 192, '');

-- --------------------------------------------------------

--
-- Table structure for table `label_transfer`
--

CREATE TABLE `label_transfer` (
  `id_label_transfer` int(11) NOT NULL,
  `label_transfer` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `label_transfer`
--

INSERT INTO `label_transfer` (`id_label_transfer`, `label_transfer`) VALUES
(2, 'yatim piatu'),
(3, 'adasd'),
(4, 'adasd'),
(5, 'asd'),
(8, 'asd'),
(10, 'saya');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id_transfer` int(11) NOT NULL,
  `id_keluarga` int(11) NOT NULL,
  `jenis_transfer` enum('sumbangan','pengeluaran') NOT NULL,
  `id_label_transfer` int(11) NOT NULL,
  `nominal` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `keterangan_transfer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`id_transfer`, `id_keluarga`, `jenis_transfer`, `id_label_transfer`, `nominal`, `waktu`, `keterangan_transfer`) VALUES
(14, 93, 'pengeluaran', 2, -30000, '2023-07-10 21:17:56', 'test test'),
(15, 94, 'sumbangan', 10, 50000, '2023-07-15 22:54:15', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `blok`
--
ALTER TABLE `blok`
  ADD PRIMARY KEY (`id_blok`),
  ADD UNIQUE KEY `nama_blok` (`nama_blok`);

--
-- Indexes for table `detail_blok`
--
ALTER TABLE `detail_blok`
  ADD PRIMARY KEY (`id_detail_blok`),
  ADD UNIQUE KEY `blok_sublok` (`id_blok`,`sub_blok`);

--
-- Indexes for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD PRIMARY KEY (`id_keluarga`),
  ADD UNIQUE KEY `alamat` (`id_detail_blok`,`no_rumah`);

--
-- Indexes for table `label_transfer`
--
ALTER TABLE `label_transfer`
  ADD PRIMARY KEY (`id_label_transfer`) USING BTREE;

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id_transfer`),
  ADD KEY `FK_transfer_keluarga` (`id_keluarga`),
  ADD KEY `FK_transfer_label_transfer` (`id_label_transfer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blok`
--
ALTER TABLE `blok`
  MODIFY `id_blok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `detail_blok`
--
ALTER TABLE `detail_blok`
  MODIFY `id_detail_blok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `keluarga`
--
ALTER TABLE `keluarga`
  MODIFY `id_keluarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `label_transfer`
--
ALTER TABLE `label_transfer`
  MODIFY `id_label_transfer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id_transfer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_blok`
--
ALTER TABLE `detail_blok`
  ADD CONSTRAINT `detail_blok_ibfk_1` FOREIGN KEY (`id_blok`) REFERENCES `blok` (`id_blok`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD CONSTRAINT `keluarga_ibfk_1` FOREIGN KEY (`id_detail_blok`) REFERENCES `detail_blok` (`id_detail_blok`) ON UPDATE CASCADE;

--
-- Constraints for table `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `FK_transfer_keluarga` FOREIGN KEY (`id_keluarga`) REFERENCES `keluarga` (`id_keluarga`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_transfer_label_transfer` FOREIGN KEY (`id_label_transfer`) REFERENCES `label_transfer` (`id_label_transfer`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
