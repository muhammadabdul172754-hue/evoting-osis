-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Nov 2026 pada 01.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting-osis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$7N9BhrNQYHT885yBiLFTg.PqVtqfhnEQwTxrrVVLp1SAoua43c/GW');

-- --------------------------------------------------------

--
-- Struktur dari tabel `calon`
--

CREATE TABLE `calon` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `visi_misi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jabatan` enum('ketua','wakil') NOT NULL DEFAULT 'ketua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `calon`
--

INSERT INTO `calon` (`id`, `nama`, `visi_misi`, `foto`, `jabatan`) VALUES
(6, 'Muhammad Abdul Kholiq', 'qwerwerwer', 'calon_6af7c433e7681.jpg', 'ketua'),
(7, 'Luqman', '12334256', 'calon_6af7c43e7f075.png', 'ketua'),
(8, 'Andi', 'cvbgfdfg', 'calon_6af7c452b9062.jpg', 'ketua'),
(9, 'Fareel', 'jkasjda nd', 'calon_6af7c465240af.jpg', 'wakil'),
(10, 'Rama', 'fgasdvv', 'calon_6af7c478153c2.jpg', 'wakil'),
(11, 'uwehrwqbdwjhd', 'qweqwedfyhiwf', 'calon_6af7c48598a1c.png', 'wakil');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `sudah_voting` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `kelas`, `sudah_voting`) VALUES
(1, 'Ahmad', 'X-1', 0),
(2, 'Bella', 'X-2', 0),
(3, 'Citra', 'XI-1', 0),
(4, 'Farreel', 'XII', 0),
(5, 'Nandra', 'XII', 0),
(6, 'Hamzah', 'XII', 0),
(7, 'Gugum', 'XII', 1),
(8, 'Ahmad Fauzi', 'X-1', 0),
(9, 'Budi Santoso', 'X-1', 0),
(10, 'Citra Lestari', 'X-1', 0),
(11, 'Dewi Anggraini', 'X-1', 0),
(12, 'Eko Prasetyo', 'X-1', 0),
(13, 'Fajar Ramadhan', 'X-1', 0),
(14, 'Gita Permata', 'X-1', 0),
(15, 'Hendra Wijaya', 'X-1', 1),
(16, 'Indah Sari', 'X-1', 1),
(17, 'Joko Susilo', 'X-1', 0),
(18, 'Kartika Sari', 'X-2', 1),
(19, 'Lukman Hakim', 'X-2', 0),
(20, 'Maya Safitri', 'X-2', 0),
(21, 'Naufal Rizky', 'X-2', 0),
(22, 'Oktaviani Putri', 'X-2', 0),
(23, 'Putra Mahendra', 'X-2', 0),
(24, 'Qori Amalia', 'X-2', 0),
(25, 'Rudi Hartono', 'X-2', 0),
(26, 'Siti Aminah', 'X-2', 0),
(27, 'Taufik Hidayat', 'X-2', 0),
(28, 'Umar Said', 'X-3', 0),
(29, 'Vina Anjelina', 'X-3', 0),
(30, 'Wahyu Saputra', 'X-3', 0),
(31, 'Yusuf Maulana', 'X-3', 0),
(32, 'Zahra Nabila', 'X-3', 0),
(33, 'Agus Setiawan', 'X-3', 0),
(34, 'Bagas Pratama', 'X-3', 0),
(35, 'Cahyo Nugroho', 'X-3', 0),
(36, 'Dian Puspita', 'X-3', 0),
(37, 'Euis Komariah', 'X-3', 0),
(38, 'Farhan Abdillah', 'X-4', 0),
(39, 'Gilang Ramadhan', 'X-4', 0),
(40, 'Hana Fadhilah', 'X-4', 0),
(41, 'Irfan Hakim', 'X-4', 0),
(42, 'Julia Rahmawati', 'X-4', 0),
(43, 'Kiki Amelia', 'X-4', 0),
(44, 'Luthfi Hakim', 'X-4', 0),
(45, 'Mega Wati', 'X-4', 0),
(46, 'Nanda Pratama', 'X-4', 0),
(47, 'Oki Setiana', 'X-4', 0),
(48, 'Panji Wicaksono', 'XI-1', 0),
(49, 'Qonita Zahra', 'XI-1', 0),
(50, 'Rafi Ahmad', 'XI-1', 0),
(51, 'Sari Dewi', 'XI-1', 0),
(52, 'Tirta Wijaya', 'XI-1', 0),
(53, 'Umi Kalsum', 'XI-1', 0),
(54, 'Vebri Yanto', 'XI-1', 0),
(55, 'Winda Sari', 'XI-1', 0),
(56, 'Yayan Ruhiyan', 'XI-1', 0),
(57, 'Zulfa Afifah', 'XI-1', 0),
(58, 'Aditya Pratama', 'XI-2', 0),
(59, 'Bella Safira', 'XI-2', 0),
(60, 'Candra Kirana', 'XI-2', 0),
(61, 'Dodi Sudirman', 'XI-2', 0),
(62, 'Elsa Marlina', 'XI-2', 0),
(63, 'Fikri Haikal', 'XI-2', 0),
(64, 'Gina Astuti', 'XI-2', 0),
(65, 'Hadi Susanto', 'XI-2', 0),
(66, 'Intan Permata', 'XI-2', 0),
(67, 'Johan Saputra', 'XI-2', 0),
(68, 'Kurniawan Aji', 'XI-3', 0),
(69, 'Lia Amelia', 'XI-3', 0),
(70, 'Muhammad Rizky', 'XI-3', 0),
(71, 'Nia Kurniasih', 'XI-3', 0),
(72, 'Oscar Lumban', 'XI-3', 0),
(73, 'Putri Ayu', 'XI-3', 0),
(74, 'Qomarudin', 'XI-3', 0),
(75, 'Rina Melati', 'XI-3', 0),
(76, 'Sandi Permana', 'XI-3', 0),
(77, 'Tika Puspita', 'XI-3', 0),
(78, 'Udin Sedunia', 'XI-4', 0),
(79, 'Vino Bastian', 'XI-4', 0),
(80, 'Wulan Guritno', 'XI-4', 0),
(81, 'Yudi Kurniawan', 'XI-4', 0),
(82, 'Zainal Abidin', 'XI-4', 0),
(83, 'Aang Kunaefi', 'XI-4', 0),
(84, 'Bambang Pamungkas', 'XI-4', 0),
(85, 'Cinta Laura', 'XI-4', 0),
(86, 'Deddy Corbuzier', 'XI-4', 0),
(87, 'Eka Gustiwana', 'XI-4', 0),
(88, 'Fahmi Idris', 'XII-1', 0),
(89, 'Gita Gutawa', 'XII-1', 0),
(90, 'Hesti Purwadinata', 'XII-1', 0),
(91, 'Iqbal Ramadhan', 'XII-1', 0),
(92, 'Joshua Suherman', 'XII-1', 0),
(93, 'Kezia Karamoy', 'XII-1', 0),
(94, 'Lesti Andryani', 'XII-1', 0),
(95, 'Maudy Ayunda', 'XII-1', 0),
(96, 'Nicholas Saputra', 'XII-1', 0),
(97, 'Olga Syahputra', 'XII-1', 0),
(98, 'Pasha Ungu', 'XII-2', 0),
(99, 'Raffi Ahmad', 'XII-2', 0),
(100, 'Sule Sutisna', 'XII-2', 0),
(101, 'Tukul Arwana', 'XII-2', 0),
(102, 'Uya Kuya', 'XII-2', 1),
(103, 'Vicky Prasetyo', 'XII-2', 0),
(104, 'Wendi Cagur', 'XII-2', 0),
(105, 'Yuki Kato', 'XII-2', 0),
(106, 'Zaskia Gotik', 'XII-2', 0),
(107, 'Ariel Noah', 'XII-2', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `calon_id` int(11) DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `votes`
--

INSERT INTO `votes` (`id`, `siswa_id`, `calon_id`, `waktu`) VALUES
(19, 102, 7, '2026-11-16 01:46:50'),
(20, 102, 11, '2026-11-16 01:46:50'),
(21, 7, 8, '2026-11-16 01:49:29'),
(22, 7, 9, '2026-11-16 01:49:29'),
(23, 16, 6, '2026-11-19 03:11:49'),
(24, 16, 9, '2026-11-19 03:11:49'),
(25, 18, 6, '2026-11-19 03:14:07'),
(26, 18, 11, '2026-11-19 03:14:07'),
(27, 15, 8, '2026-11-19 03:36:27'),
(28, 15, 10, '2026-11-19 03:36:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `calon`
--
ALTER TABLE `calon`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calon_id` (`calon_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `calon`
--
ALTER TABLE `calon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT untuk tabel `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`calon_id`) REFERENCES `calon` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
