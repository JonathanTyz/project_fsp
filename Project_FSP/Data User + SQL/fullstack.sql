-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jan 2026 pada 10.15
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
-- Database: `fullstack`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nrp_mahasiswa` char(9) DEFAULT NULL,
  `npk_dosen` char(6) DEFAULT NULL,
  `isadmin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`username`, `password`, `nrp_mahasiswa`, `npk_dosen`, `isadmin`) VALUES
('admin', '$2y$10$gamrHj8ApDatEfWsb67Xf./mAi64rA.vEkd/WUmiX.JStJk5m/0HW', NULL, NULL, 1),
('Anton123', '$2y$10$yHX4efaDhaRG4LjpeJny2O7qASorq3yOty4tAHjL.t3bQH8tVwSey', NULL, '9000', 0),
('Calvin123', '$2y$10$vo81uKlqI3AwRf75Opo.D.9ChzR5dwhmFGf1lRfMeImApdGojQdjq', '160424500', NULL, 0),
('James123', '$2y$10$VKRUSkVI.59oKi9nC0U.n.4ywgruSxzc2IQuL5EvBl0fNg5YJdeC2', NULL, '5000', 0),
('Jonathan123', '$2y$10$YR8n.xJuaFN7smMk5mXLwOTDsH8AVSJpEJtZuMRzWB4BElFEKvV4C', '160423095', NULL, 0),
('Jordan123', '$2y$10$CFu1aH2elWgpL5byiItBQeXD4ksRKGhlZ9HFXLjFr2gzES62o093G', NULL, '1000', 0),
('Ken123', '$2y$10$6Rs4x92OMCo63qi1ouiRMul6fEbd1ufqUMJx2ziZwtxyaNpZbGLsa', '160423071', NULL, 0),
('Maya123', '$2y$10$3xe3KYAXx9lGhwQXOUNV4ORl/UaPjRXCVB7WtRpIKc3lE4dDiPoNm', NULL, '10200', 0),
('Robby123', '$2y$10$PZMoHFzAmXif7l.kMHl0fOPQyJsJc5CK.gb//ld4ESgSIYKG0C6qa', '160423075', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat`
--

CREATE TABLE `chat` (
  `idchat` int(11) NOT NULL,
  `idthread` int(11) NOT NULL,
  `username_pembuat` varchar(20) NOT NULL,
  `isi` text DEFAULT NULL,
  `tanggal_pembuatan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `chat`
--

INSERT INTO `chat` (`idchat`, `idthread`, `username_pembuat`, `isi`, `tanggal_pembuatan`) VALUES
(17, 25, 'Jonathan123', 'tes', '2026-01-09 16:10:13'),
(18, 25, 'Jonathan123', 'halo', '2026-01-09 16:10:15'),
(19, 25, 'Jonathan123', 'haha', '2026-01-09 16:10:20'),
(20, 25, 'Jonathan123', 'haha', '2026-01-09 16:10:22'),
(21, 25, 'Jonathan123', 'haha', '2026-01-09 16:10:25'),
(22, 25, 'Jonathan123', 'haha', '2026-01-09 16:10:26'),
(23, 25, 'Jonathan123', 'haha', '2026-01-09 16:10:27'),
(24, 25, 'Jonathan123', 'haha', '2026-01-09 16:10:28'),
(25, 25, 'Jonathan123', 'haha', '2026-01-09 16:10:30'),
(26, 25, 'Jordan123', 'halo', '2026-01-09 16:11:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `npk` char(6) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `foto_extension` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`npk`, `nama`, `foto_extension`) VALUES
('1000', 'Jordan', 'jpg'),
('10200', 'Maya', 'jpg'),
('5000', 'James', 'jpg'),
('9000', 'Anton', 'jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `idevent` int(11) NOT NULL,
  `idgrup` int(11) NOT NULL,
  `judul` varchar(45) DEFAULT NULL,
  `judul-slug` varchar(45) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `jenis` enum('Privat','Publik') DEFAULT NULL,
  `poster_extension` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`idevent`, `idgrup`, `judul`, `judul-slug`, `tanggal`, `keterangan`, `jenis`, `poster_extension`) VALUES
(42, 36, 'Meeting Skripsi', 'meeting-skripsi', '2026-01-28 00:00:00', 'Meeting Skripsi buat mahasiswa yang bingung ', 'Publik', 'jpg'),
(43, 34, 'UTS Machine Learning', 'uts-machine-learning', '2026-01-24 00:00:00', 'UTS Machine LEARNING OFFLINE DI TF', 'Publik', 'jpg'),
(44, 38, 'Rapat Lab TA', 'rapat-lab-ta', '2026-02-04 00:00:00', 'Persiapan Rapat panitia skripsi lab TA ', 'Publik', 'jpg'),
(45, 42, 'Konsultasi Skripsin buat yang bingung', 'konsultasi-skripsin-buat-yang-bingung', '2026-01-31 00:00:00', 'Konsul', 'Privat', 'png'),
(46, 40, 'Rapat Progress MOB UBAYA', 'rapat-progress-mob-ubaya', '2026-01-09 00:00:00', 'MOB UBAYA', 'Publik', 'jpg'),
(47, 39, 'Statistics KP C ', 'statistics-kp-c-', '2026-01-23 00:00:00', 'Statistics ', 'Privat', 'png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `grup`
--

CREATE TABLE `grup` (
  `idgrup` int(11) NOT NULL,
  `username_pembuat` varchar(20) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `deskripsi` varchar(45) DEFAULT NULL,
  `tanggal_pembentukan` datetime DEFAULT NULL,
  `jenis` enum('Privat','Publik') DEFAULT NULL,
  `kode_pendaftaran` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `grup`
--

INSERT INTO `grup` (`idgrup`, `username_pembuat`, `nama`, `deskripsi`, `tanggal_pembentukan`, `jenis`, `kode_pendaftaran`) VALUES
(34, 'Jordan123', 'Machine Learning KP E', 'Machine learning dan lainnya', '2026-01-09 15:46:07', 'Publik', 'grup34'),
(35, 'Jordan123', 'Cisco Python Essentials', 'Materi Cisco', '2026-01-09 15:46:19', 'Publik', 'grup35'),
(36, 'Jordan123', 'Konsultasi Skripsi DSAI', 'Konsul Skripsi', '2026-01-09 15:46:35', 'Privat', 'grup36'),
(37, 'Maya123', 'Kuliah Tamu HCI', 'HCI Kuliah tamu week 10', '2026-01-09 15:47:15', 'Publik', 'grup37'),
(38, 'Maya123', 'Panitia TA 2026', 'Panitia TA Khusus', '2026-01-09 15:47:28', 'Privat', 'grup38'),
(39, 'Anton123', 'Statistics KP C', 'Matkul Statistics', '2026-01-09 15:47:54', 'Publik', 'grup39'),
(40, 'Anton123', 'Panitia MOB 2026', 'Khusus panitia MOB + Dosen', '2026-01-09 15:48:11', 'Privat', 'grup40'),
(41, 'James123', 'Alpro KP A ', 'Matkul Alpro KP A', '2026-01-09 15:49:06', 'Publik', 'grup41'),
(42, 'James123', 'Konsultasi Skripsi Program NCS ', 'Konsultasi Skripsi', '2026-01-09 15:49:26', 'Privat', 'grup42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nrp` char(9) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `gender` enum('Pria','Wanita') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL,
  `foto_extention` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nrp`, `nama`, `gender`, `tanggal_lahir`, `angkatan`, `foto_extention`) VALUES
('160423071', 'Tanjaya', 'Pria', '2025-10-15', '2023', 'jpg'),
('160423075', 'Robby', 'Pria', '2026-01-20', '2023', 'jpg'),
('160423095', 'Jonathan', 'Pria', '2025-12-26', '2023', 'jpg'),
('160424500', 'Calvin', 'Pria', '2025-10-13', '2025', 'jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member_grup`
--

CREATE TABLE `member_grup` (
  `idgrup` int(11) NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `member_grup`
--

INSERT INTO `member_grup` (`idgrup`, `username`) VALUES
(36, 'Anton123'),
(36, 'Jonathan123'),
(36, 'Ken123'),
(36, 'Maya123'),
(36, 'Robby123'),
(37, 'Calvin123'),
(37, 'Jonathan123'),
(37, 'Jordan123'),
(37, 'Ken123'),
(37, 'Robby123'),
(38, 'Calvin123'),
(38, 'James123'),
(38, 'Robby123'),
(39, 'Calvin123'),
(39, 'Robby123'),
(40, 'Calvin123'),
(40, 'Jonathan123'),
(40, 'Ken123'),
(40, 'Maya123'),
(40, 'Robby123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `thread`
--

CREATE TABLE `thread` (
  `idthread` int(11) NOT NULL,
  `username_pembuat` varchar(20) NOT NULL,
  `idgrup` int(11) NOT NULL,
  `tanggal_pembuatan` datetime DEFAULT NULL,
  `status` enum('Open','Close') DEFAULT 'Open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `thread`
--

INSERT INTO `thread` (`idthread`, `username_pembuat`, `idgrup`, `tanggal_pembuatan`, `status`) VALUES
(25, 'Jordan123', 36, '2026-01-09 15:50:57', 'Open'),
(26, 'Jordan123', 34, '2026-01-09 15:51:01', 'Close'),
(27, 'Jordan123', 35, '2026-01-09 15:51:40', 'Open'),
(28, 'Maya123', 38, '2026-01-09 15:52:32', 'Open'),
(29, 'Maya123', 37, '2026-01-09 15:52:36', 'Close'),
(30, 'James123', 42, '2026-01-09 15:55:27', 'Open'),
(31, 'James123', 41, '2026-01-09 15:55:32', 'Open'),
(32, 'Anton123', 40, '2026-01-09 15:57:33', 'Close'),
(33, 'Anton123', 39, '2026-01-09 15:57:38', 'Open');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`username`),
  ADD KEY `fk_akun_mahasiswa_idx` (`nrp_mahasiswa`),
  ADD KEY `fk_akun_dosen1_idx` (`npk_dosen`);

--
-- Indeks untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`idchat`),
  ADD KEY `fk_chat_thread1_idx` (`idthread`),
  ADD KEY `fk_chat_akun1_idx` (`username_pembuat`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`npk`);

--
-- Indeks untuk tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`idevent`),
  ADD KEY `fk_event_grup1_idx` (`idgrup`);

--
-- Indeks untuk tabel `grup`
--
ALTER TABLE `grup`
  ADD PRIMARY KEY (`idgrup`),
  ADD KEY `fk_grup_akun1_idx` (`username_pembuat`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nrp`);

--
-- Indeks untuk tabel `member_grup`
--
ALTER TABLE `member_grup`
  ADD PRIMARY KEY (`idgrup`,`username`),
  ADD KEY `fk_grup_has_akun_akun1_idx` (`username`),
  ADD KEY `fk_grup_has_akun_grup1_idx` (`idgrup`);

--
-- Indeks untuk tabel `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`idthread`),
  ADD KEY `fk_thread_akun1_idx` (`username_pembuat`),
  ADD KEY `fk_thread_grup1_idx` (`idgrup`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chat`
--
ALTER TABLE `chat`
  MODIFY `idchat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `event`
--
ALTER TABLE `event`
  MODIFY `idevent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `grup`
--
ALTER TABLE `grup`
  MODIFY `idgrup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `thread`
--
ALTER TABLE `thread`
  MODIFY `idthread` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD CONSTRAINT `fk_akun_dosen1` FOREIGN KEY (`npk_dosen`) REFERENCES `dosen` (`npk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_akun_mahasiswa` FOREIGN KEY (`nrp_mahasiswa`) REFERENCES `mahasiswa` (`nrp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `fk_chat_akun1` FOREIGN KEY (`username_pembuat`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_chat_thread1` FOREIGN KEY (`idthread`) REFERENCES `thread` (`idthread`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_grup1` FOREIGN KEY (`idgrup`) REFERENCES `grup` (`idgrup`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `grup`
--
ALTER TABLE `grup`
  ADD CONSTRAINT `fk_grup_akun1` FOREIGN KEY (`username_pembuat`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `member_grup`
--
ALTER TABLE `member_grup`
  ADD CONSTRAINT `fk_grup_has_akun_akun1` FOREIGN KEY (`username`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_grup_has_akun_grup1` FOREIGN KEY (`idgrup`) REFERENCES `grup` (`idgrup`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `fk_thread_akun1` FOREIGN KEY (`username_pembuat`) REFERENCES `akun` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_thread_grup1` FOREIGN KEY (`idgrup`) REFERENCES `grup` (`idgrup`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
