-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 16 Jun 2023 pada 13.38
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockbarang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `idkeluar` int(11) NOT NULL,
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `keluar` varchar(255) NOT NULL,
  `penerima` varchar(255) NOT NULL,
  `gambarPenerima` varchar(255) NOT NULL,
  `tanggalKeluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`idkeluar`, `idmasuk`, `idbarang`, `keluar`, `penerima`, `gambarPenerima`, `tanggalKeluar`) VALUES
(68, 84, 13, '123', 'asd', '648c47d44ce66.png', '2023-06-16'),
(70, 84, 13, '100', 'as', '648c49112b0ef.png', '2023-06-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `idbarang` int(11) NOT NULL,
  `namaJenisBarang` varchar(255) NOT NULL,
  `tgl` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_barang`
--

INSERT INTO `jenis_barang` (`idbarang`, `namaJenisBarang`, `tgl`) VALUES
(6, 'Ban', '2023-05-28 02:13:35'),
(7, 'Seal Karet', '2023-05-28 02:13:43'),
(8, 'Oli Mesin', '2023-05-28 02:13:53'),
(9, 'Rantai Motor atau V-Belt', '2023-05-28 02:14:10'),
(10, 'Kampas Rem', '2023-05-28 02:14:21'),
(11, 'Busi', '2023-05-28 02:14:25'),
(12, 'Kampas Kopling', '2023-05-28 02:14:37'),
(13, 'Filter atau Saringan Udara', '2023-05-28 02:14:58'),
(14, 'Aki', '2023-05-28 02:15:07'),
(15, 'Lampu', '2023-05-28 02:15:12'),
(16, 'Ban Belakang Motor', '2023-06-12 03:51:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'audy@gmail.com', '12345'),
(5, 'audyardhanasywa@gmail.com', '750c24f23748db704248b6b87001fce7'),
(6, 'andinidini75@ymail.com', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Struktur dari tabel `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `ubah` datetime NOT NULL,
  `gambar` varchar(128) NOT NULL,
  `ukuran` varchar(128) NOT NULL,
  `merk` varchar(128) NOT NULL,
  `code_barang` int(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `update_qty` int(11) NOT NULL,
  `qty_akhir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `ubah`, `gambar`, `ukuran`, `merk`, `code_barang`, `qty`, `update_qty`, `qty_akhir`) VALUES
(78, 6, '2023-06-16 12:04:13', '2023-06-16 12:04:53', '648bed4db1906.png', '12', 'FDR', 620230616, 100, 10, -120),
(79, 8, '2023-06-16 12:15:55', '2023-06-16 12:17:18', '648bf00b6eed0.png', '800ml', 'Yamalube', 820230616, 10, 15, 25),
(80, 8, '2023-06-16 12:18:23', '0000-00-00 00:00:00', '648bf09f39296.png', '300ml', 'Yamalube', 820230616, 50, 0, 13),
(81, 8, '2023-06-16 12:19:05', '0000-00-00 00:00:00', '648bf0c9b0033.png', '300ml', 'Yamalube', 820230616, 7, 0, 17),
(83, 11, '2023-06-16 18:16:45', '0000-00-00 00:00:00', '648c449d5abd8.png', '12', 'sa', 1120230616, 120, 0, 120),
(84, 13, '2023-06-16 18:18:06', '2023-06-16 18:36:10', '648c44ee54fb3.png', 'asa', '12', 1320230616, 120, 90, 390);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`idkeluar`),
  ADD KEY `idbarang` (`idbarang`),
  ADD KEY `idmasuk` (`idmasuk`);

--
-- Indeks untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indeks untuk tabel `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`),
  ADD KEY `idbarang` (`idbarang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `jenis_barang` (`idbarang`);

--
-- Ketidakleluasaan untuk tabel `masuk`
--
ALTER TABLE `masuk`
  ADD CONSTRAINT `masuk_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `jenis_barang` (`idbarang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
