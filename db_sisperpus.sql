-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 31, 2026 at 06:07 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sisperpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `kode_buku` varchar(255) NOT NULL,
  `judul_buku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `penulis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `penerbit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tahun` int NOT NULL,
  `stok` int NOT NULL,
  `status` enum('tersedia','kosong') NOT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `kode_buku`, `judul_buku`, `penulis`, `penerbit`, `tahun`, `stok`, `status`, `tanggal_dibuat`) VALUES
(1, 'NGE01', 'Neon Genesis Evangelion 01', 'Yoshiyuki Sadamoto', 'M&C', 1995, 100, 'tersedia', '2025-12-27 10:35:15'),
(2, 'NGE02', 'Neon Genesis Evangelion 02', 'Yoshiyuki Sadamoto', 'M&C', 1995, 100, 'tersedia', '2025-12-28 22:27:35'),
(3, 'NGE03', 'Neon Genesis Evangelion 03', 'Yoshiyuki Sadamoto', 'M&C', 1995, 100, 'tersedia', '2025-12-28 22:28:59'),
(4, 'NGE04', 'Neon Genesis Evangelion 04', 'Yoshiyuki Sadamoto', 'M&C', 1995, 100, 'tersedia', '2025-12-28 22:29:53'),
(5, 'NGE05', 'Neon Genesis Evangelion 05', 'Yoshiyuki Sadamoto', 'M&C', 1995, 100, 'tersedia', '2025-12-28 22:30:17'),
(6, 'G0DER', 'Goodbye, Eri', 'Tatsuki Fujimoto', 'M&C', 2022, 100, 'kosong', '2026-01-04 12:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_buku`
--

CREATE TABLE `peminjaman_buku` (
  `id` int NOT NULL,
  `id_buku` int NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_dikembalikan` date NOT NULL,
  `status` enum('dipinjam','dikembalikan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'dipinjam',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman_buku`
--

INSERT INTO `peminjaman_buku` (`id`, `id_buku`, `nama_pengguna`, `jumlah`, `tanggal_pinjam`, `tanggal_dikembalikan`, `status`, `created_at`) VALUES
(1, 1, 'Staff', 3, '2026-01-02', '2026-01-30', 'dikembalikan', '2026-01-02 07:41:48'),
(2, 2, 'Staff', 100, '2026-01-02', '2026-01-30', 'dikembalikan', '2026-01-02 07:42:06'),
(3, 5, 'Staff', 100, '2026-01-02', '2026-02-06', 'dikembalikan', '2026-01-02 08:24:15'),
(4, 3, 'Tes', 3, '2026-01-02', '2026-01-22', 'dikembalikan', '2026-01-02 08:25:09'),
(5, 4, 'Rei', 1, '2026-01-02', '2026-01-21', 'dikembalikan', '2026-01-02 08:25:30'),
(6, 6, 'fauzan', 1, '2026-01-06', '2026-01-07', 'dikembalikan', '2026-01-06 06:55:36'),
(7, 6, 'Staff', 2, '2026-01-14', '2026-01-26', 'dikembalikan', '2026-01-14 07:53:19'),
(8, 6, 'Tes', 3, '2026-01-14', '2026-01-21', 'dikembalikan', '2026-01-14 07:53:48'),
(9, 6, 'Staff', 1, '2026-01-14', '2026-01-22', 'dikembalikan', '2026-01-14 07:56:09'),
(10, 1, 'Lail', 100, '2026-01-30', '2026-01-31', 'dikembalikan', '2026-01-30 13:53:23'),
(11, 6, 'Rei', 3, '2026-01-30', '2026-01-31', 'dikembalikan', '2026-01-30 14:05:14'),
(12, 1, 'fauzan', 2, '2026-01-30', '2026-01-31', 'dikembalikan', '2026-01-30 14:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian_buku`
--

CREATE TABLE `pengembalian_buku` (
  `id` int NOT NULL,
  `id_peminjaman` int NOT NULL,
  `id_buku` int NOT NULL,
  `keterlambatan` int DEFAULT '0',
  `denda` int DEFAULT '0',
  `status_pengembalian` enum('dikembalikan','hilang','rusak') NOT NULL,
  `tanggal_dikembalikan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `jumlah` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengembalian_buku`
--

INSERT INTO `pengembalian_buku` (`id`, `id_peminjaman`, `id_buku`, `keterlambatan`, `denda`, `status_pengembalian`, `tanggal_dikembalikan`, `created_at`, `jumlah`) VALUES
(1, 1, 1, 0, 0, 'dikembalikan', '2026-01-30', '2026-01-02 07:42:20', 1),
(2, 2, 2, 0, 0, 'dikembalikan', '2026-01-30', '2026-01-02 07:42:34', 1),
(3, 3, 5, 0, 0, 'dikembalikan', '2026-02-06', '2026-01-02 08:26:06', 1),
(4, 4, 3, 0, 0, 'dikembalikan', '2026-01-22', '2026-01-02 08:26:17', 1),
(5, 5, 4, 0, 0, 'dikembalikan', '2026-01-21', '2026-01-02 08:26:23', 1),
(6, 6, 6, 0, 0, 'dikembalikan', '2026-01-07', '2026-01-06 06:55:53', 1),
(7, 7, 6, 0, 0, 'dikembalikan', '2026-01-26', '2026-01-14 07:54:09', 1),
(8, 8, 6, 0, 0, 'dikembalikan', '2026-01-21', '2026-01-14 07:54:23', 1),
(9, 9, 6, 0, 0, 'dikembalikan', '2026-01-22', '2026-01-14 07:57:33', 1),
(10, 10, 1, 0, 0, 'dikembalikan', '2026-01-31', '2026-01-30 13:57:17', 1),
(11, 11, 6, 0, 0, 'dikembalikan', '2026-01-31', '2026-01-30 14:06:04', 1),
(12, 12, 1, 0, 0, 'dikembalikan', '2026-01-31', '2026-01-30 14:06:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `username`, `foto`, `password`, `role`, `tanggal_dibuat`) VALUES
(1, 'Admin', 'Admin', '', '$2y$10$V2hfbTMpOvR0jHAa5o8KyuE1oAxWjkloGAr/A1bh2MNeGPG43kvNK', 'admin', '2025-12-22 07:17:33'),
(2, 'Staff', 'Staff', '697cbb0ba0e75.jpg', '$2y$10$lQcfTv7/R68is3Xg1PCg8eBn9HCnFC3EIkOtsReT7Cr2KKTeP3456', 'staff', '2026-01-01 04:51:43'),
(5, 'Tes', 'Tes', '', '$2y$10$XjvjCzdArO.q5DKU6X9NEuYELLarW0.5.fuCxqJSpPAHT9gvYhT8m', 'staff', '2026-01-01 05:18:39'),
(10, 'iqbl', 'iqbl', '', '$2y$10$95qhEj7rMbpqOCeNjdIJkOrK5oCEaLN7Qyx3tHNaZC2PwHXZcvDmi', 'admin', '2026-01-30 13:35:04'),
(11, 'Nahda PNK', 'Nahda', '', '$2y$10$veLul8DEeRTy42fv3pNalenfuUXs8Gv0FJvvR./K66b8DEpjyTfF6', 'staff', '2026-01-30 13:56:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `judul_buku` (`judul_buku`);

--
-- Indexes for table `peminjaman_buku`
--
ALTER TABLE `peminjaman_buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `pengembalian_buku`
--
ALTER TABLE `pengembalian_buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `peminjaman_buku`
--
ALTER TABLE `peminjaman_buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengembalian_buku`
--
ALTER TABLE `pengembalian_buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman_buku`
--
ALTER TABLE `peminjaman_buku`
  ADD CONSTRAINT `peminjaman_buku_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`);

--
-- Constraints for table `pengembalian_buku`
--
ALTER TABLE `pengembalian_buku`
  ADD CONSTRAINT `pengembalian_buku_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman_buku` (`id`),
  ADD CONSTRAINT `pengembalian_buku_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
