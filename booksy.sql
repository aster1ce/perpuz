-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2026 at 09:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booksy`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` int(4) DEFAULT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `id_kategori`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `stok`) VALUES
(1, 3, 'Belajar CI3 untuk Pemula', 'Andi', 'Informatika', 2023, 10),
(2, 1, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 10),
(5, NULL, 'sangkuriangss', 'penulisnya guwesafas', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Fiksi'),
(2, 'Pendidikan'),
(3, 'Teknologi');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali_real` date DEFAULT NULL,
  `tanggal_deadline` date DEFAULT NULL,
  `status` enum('menunggu','disetujui','ditolak','kembali','pending_kembali') DEFAULT 'menunggu',
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali_real`, `tanggal_deadline`, `status`, `denda`) VALUES
(6, 2, 1, '2026-04-08', NULL, '2026-04-11', 'disetujui', 0),
(13, 2719, 1, '2026-04-01', NULL, '2026-04-05', 'pending_kembali', 0),
(14, 2719, 1, '2026-04-01', '2026-04-08', '2026-04-05', 'kembali', 6000),
(15, 2719, 1, '2026-04-01', '2026-04-08', '2026-04-05', 'kembali', 6000),
(16, 2719, 1, '2026-04-01', '2026-04-08', '2026-04-05', 'kembali', 6000),
(17, 2719, 1, '2026-04-01', NULL, '2026-04-05', 'pending_kembali', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('admin','siswa') DEFAULT 'siswa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `alamat`, `role`, `created_at`) VALUES
(1, 'admin1', '$2y$10$8Q6/D1O1yG.J.Y.S', 'Admin Perpustakaan', NULL, 'admin', '2026-04-06 06:42:51'),
(2, 'siswa1', '$2y$10$8Q6/D1O1yG.J.Y.S', 'Ridwan Januar', NULL, 'siswa', '2026-04-06 06:42:51'),
(2717, 'admin_baru', '$2y$10$jQORM7yxUQaJU8jJeN6L6u9Pe9Qtmx57Fu5mIGFWvdbgqudNwsV/6', 'Administrator Utama', NULL, 'admin', '2026-04-08 02:43:23'),
(2718, 'siswa_baru', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Siswa Percobaan', NULL, 'siswa', '2026-04-08 02:43:23'),
(2719, 'ridwan', '$2y$10$bMxLZsWubZIYMUUm61DAP.ccEhkZ4MYdfcXurQzDzaxBwvXlDIsPO', 'erjeka cakef', NULL, 'siswa', '2026-04-08 02:58:04'),
(2720, 'siomay', '53c00b8212b0158b154b4ad5c7458119', 'siomay', NULL, 'siswa', '2026-04-08 06:15:12'),
(2722, 'kokoro', '$2y$10$/5/FmnLTDk6SU./sq46sb.hkcxdTgGYpEs1bpv0e9fqvERj07.JBm', 'kokoro', NULL, 'siswa', '2026-04-08 06:21:21'),
(2723, 'aduhay', '$2y$10$cBcd5g.xr3T7firgdgZAjukAC3O6cym11x/ZovxCq3kkWp34oHqvG', 'anak sukses', NULL, 'siswa', '2026-04-08 06:29:01'),
(2725, 'mada', '$2y$10$Y1hEjEjSvgkt7jIa7cJ5meD7OozPI6rNP0DUhSL5MY2Pk919aPYO.', 'mada', NULL, 'siswa', '2026-04-08 06:54:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2726;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
