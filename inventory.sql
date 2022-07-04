-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Agu 2019 pada 21.51
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `division`
--

CREATE TABLE `division` (
  `iddivision` int(11) NOT NULL,
  `division` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `division`
--

INSERT INTO `division` (`iddivision`, `division`) VALUES
(1, 'Komersial'),
(3, 'Hukum'),
(4, 'Pengendalian Internal & Manajemen Resiko'),
(5, 'Pengendalian Mutu & Peso'),
(8, 'Property'),
(9, 'Teknik Sipil'),
(10, 'Teknik Mesin & Listrik'),
(11, 'Sistem Informasi'),
(12, 'Rendal & Kepanduan'),
(13, 'Operasi Umum'),
(14, 'Akutansi & Anggaran'),
(15, 'Perbendaharaan'),
(16, 'SDM & KBL');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventory`
--

CREATE TABLE `inventory` (
  `idhardware` int(11) NOT NULL,
  `SN` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `type_id` int(11) NOT NULL,
  `storage` varchar(150) NOT NULL,
  `stock` int(11) NOT NULL,
  `date_hardware` int(11) NOT NULL,
  `first_time` int(11) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `inventory`
--

INSERT INTO `inventory` (`idhardware`, `SN`, `name`, `brand`, `type_id`, `storage`, `stock`, `date_hardware`, `first_time`, `image`) VALUES
(1, '12233115654', 'Printer Canon 123', 'Canon', 2, 'Gudang A', 12, 1566301511, 0, '51XRimXugOL__SL1333_.jpg'),
(2, '12233115656', 'LAPTOP ACER E 14', 'ACER', 1, 'Gudang A', 1, 1566301746, 0, '0_cb5aed7a-ea95-493b-be30-0566935de27f_780_1040.jpg'),
(3, '12233115652', 'CCTV', 'Samsung', 4, 'Gudang A', 6, 1566301700, 0, 'cctv-camera-video-surveillance-dome-ceiling-mounted-49923-5582609.jpg'),
(4, '12233115633', 'Printer Epson 9090', 'Epson', 2, 'Gudang B', 0, 1566301808, 0, '3904010008_5.jpg'),
(15, '1223311565222', 'PC AA', 'HP', 1, 'Gudang B', 1, 1566303458, 1566301934, 'page-impact-1.jpg'),
(16, '1223311563553', 'PC AB', 'HP', 1, 'Gudang B', 2, 1566302974, 1566301972, '59c8ba759cb79.jpg'),
(17, '1223311565499', 'Proyektor Acer 11', 'Acer', 3, 'Gudang B', 4, 1566328761, 1566328761, 'IMG_3842-Ed_R-600x396.jpg'),
(18, '1223311565227', 'Laptop Lenovo 12', 'Lenovo', 1, 'Gudang B', 2, 1566328924, 1566328924, 'laptop-lenovo-thinkpad-t440-ci5-4300u-4gb-180gb.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `performance`
--

CREATE TABLE `performance` (
  `idperformance` int(11) NOT NULL,
  `id_use` int(11) NOT NULL,
  `user` varchar(150) NOT NULL,
  `admin` varchar(150) NOT NULL,
  `id_hardware` int(11) NOT NULL,
  `status_hardware` varchar(50) NOT NULL,
  `date_repaired` int(11) NOT NULL,
  `date_finished` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `performance`
--

INSERT INTO `performance` (`idperformance`, `id_use`, `user`, `admin`, `id_hardware`, `status_hardware`, `date_repaired`, `date_finished`) VALUES
(1, 12, 'Rusmi', 'Yusuf Abdul Rahman', 15, 'No Active', 1566305428, 1566305433),
(2, 9, 'Rusmi', 'Riski', 1, 'No Active', 1566305450, 1566305454),
(3, 10, 'Ita', 'Riski', 15, 'No Active', 1566305460, 1566305562);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `id_hardware` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `stock_out` int(11) NOT NULL,
  `date_stock` int(11) NOT NULL,
  `total_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `stock`
--

INSERT INTO `stock` (`id`, `id_hardware`, `id_type`, `income`, `stock_out`, `date_stock`, `total_stock`) VALUES
(1, 1, 2, 3, 0, 1563823037, 0),
(3, 1, 2, 2, 0, 1563823491, 0),
(4, 1, 2, 0, 1, 1563823585, 0),
(5, 1, 2, 1, 0, 1564539973, 0),
(6, 1, 2, 0, 1, 1564540374, 0),
(7, 14, 1, 0, 1, 1564731625, 0),
(8, 1, 2, 0, 1, 1565276258, 0),
(9, 1, 2, 0, 4, 1565278404, 0),
(10, 0, 0, 3, 0, 1565286084, 0),
(11, 0, 0, 3, 0, 1565286189, 0),
(12, 0, 0, 3, 0, 1565286320, 0),
(13, 0, 0, 1, 0, 1565286378, 0),
(14, 1, 2, 0, 6, 1565286412, 0),
(15, 0, 0, 3, 0, 1565286611, 0),
(16, 1, 2, 1, 0, 1565941462, 11),
(17, 1, 2, 0, 0, 1565942087, 11),
(18, 1, 2, 0, 3, 1565944646, 8),
(19, 1, 2, 2, 0, 1565959520, 10),
(20, 0, 0, 3, 0, 1566025959, 13),
(21, 1, 2, 0, 2, 1566200392, 11),
(22, 0, 0, 2, 0, 1566284422, 13),
(23, 0, 0, 1, 0, 1566284485, 0),
(24, 1, 2, 0, 4, 1566290149, 9),
(25, 0, 0, 3, 0, 1566301511, 12),
(26, 15, 1, 0, 1, 1566302909, 2),
(27, 16, 1, 0, 1, 1566302974, 2),
(28, 15, 1, 0, 1, 1566303458, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `type`
--

CREATE TABLE `type` (
  `idtype` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `type`
--

INSERT INTO `type` (`idtype`, `type`) VALUES
(1, 'PC/LAPTOP'),
(2, 'PRINTER'),
(3, 'ACCESSORIES HARDWARE'),
(4, 'CCTV'),
(5, 'JARINGAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `username` varchar(150) NOT NULL,
  `id_division` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `image` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`iduser`, `nip`, `username`, `id_division`, `position`, `status`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(4, '2121333', 'sfns', 2, 'GM', 'ORGANIK', 'as@gmail.com', 'default.png', '$2y$10$jhG.LMQl3Tar0kBzyj13u.GHcG2btdcM9NH3zTIPA1ix81FJwrd6m', 2, 0, 1556036741),
(5, 'KP0002', 'sadd', 1, '1', '1', '1', 'Alam031.jpg', '1', 1, 1, 0),
(6, '27707136', 'Yusuf Abdul Rahman', 11, 'Supervisor', 'ORGANIK', 'aeryusuf@gmail.com', 'song_joong_ki-169.jpg', '$2y$10$GuoKRwvNfUexbD5jHJBGh.fjvf5m2EGewEWKqOJ5f3N2myCYqhk6u', 2, 1, 1562603180),
(9, '121212', 'Alnov Ceisar', 2, 'Playmaker', 'ORGANIK', 'alnov@gmail.com', 'default.jpg', '$2y$10$ZYpIOxMfvaEd4ua5giz6SO.8twEOP16/B9TvWTWFJRwzS57LnDhuK', 4, 1, 1565782100),
(14, '820100110', 'lolo', 13, 'Supervisor', 'NON ORGANIK', 'lela@gmail.com', 'default.jpg', '$2y$10$VvlYrZa6So5JElNKqly59.2Q4Arkh8ozSOl11saXyGYaopYI24.Uy', 4, 1, 1566029666),
(15, '27707132', 'Rusmi', 3, 'Staff', 'ORGANIK', 'ab@gmail.com', 'untitle-3-b7c7d4d21f5790d891058d49406fa9db_600x400.jpg', '$2y$10$dnKiKS7dfBOFO/8AC/imPO01odyoL7ziDxlJsqLJ02pVHtGJdtX6u', 4, 1, 1566298658),
(16, '27707133', 'Ita', 9, 'Staff', 'ORGANIK', 'aa@gmail.com', '1566154344-iu.jpg', '$2y$10$Ucm8C3Du9IPIi6.WQlASHuM.9qbIOqts6GGjU5yjihmqsLwETeBta', 4, 1, 1566299045),
(17, '27707135', 'Riski', 11, 'Supervisor', 'ORGANIK', 'ac@gmail.com', 'akurat_20171125012725_T0zy81.jpg', '$2y$10$gJn3nX7oTVbtgHyLSl5b9.wPX9UfL0iKUkL9t3TzgWaTRHK4CDIk.', 3, 1, 1566299371);

-- --------------------------------------------------------

--
-- Struktur dari tabel `useruse`
--

CREATE TABLE `useruse` (
  `iduse` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `id_hardware` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `id_division` int(11) NOT NULL,
  `position` varchar(100) NOT NULL,
  `date_use` int(11) NOT NULL,
  `first_time` int(11) NOT NULL,
  `date_maintenance` int(11) NOT NULL,
  `status_hardware` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `complaint` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `useruse`
--

INSERT INTO `useruse` (`iduse`, `id_user`, `username`, `id_hardware`, `id_type`, `id_division`, `position`, `date_use`, `first_time`, `date_maintenance`, `status_hardware`, `amount`, `complaint`) VALUES
(3, 3, 'yusuf', 3, 4, 1, 'DGM', 1562765761, 0, 0, 'Active', 2, ''),
(4, 3, 'yusuf', 1, 2, 1, 'DGM', 1562603364, 0, 0, 'Active', 1, ''),
(6, 3, 'yusuf', 2, 1, 1, 'DGM', 1563461716, 0, 1563461716, 'Active', 1, ''),
(7, 6, 'Yusuf Abdul Rahman', 1, 2, 1, 'ADGM', 1566303184, 1563359186, 1566303184, 'Active', 3, ''),
(9, 15, 'aa', 1, 2, 1, 'DGM', 1566305454, 1566290149, 1566305454, 'Active', 1, ''),
(10, 16, 'Ita', 15, 1, 9, 'Staff', 1566305562, 1566302909, 1566305562, 'Active', 1, ''),
(11, 17, 'Riski', 16, 1, 11, 'Supervisor', 1566302974, 1566302974, 1566302974, 'Active', 1, ''),
(12, 15, 'Rusmi', 15, 1, 3, 'Staff', 1566305433, 1566303458, 1566305433, 'Active', 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(5, 4, 2),
(11, 2, 4),
(13, 3, 2),
(21, 3, 4),
(22, 2, 3),
(23, 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Inventory'),
(4, 'Monitoring'),
(5, 'Menu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(2, 'Administration'),
(3, 'Technician'),
(4, 'User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/editProfile', 'fas fa-fw fa-user-edit', 1),
(4, 5, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 5, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(6, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(7, 3, 'Inventory', 'inventory', 'fas fa-fw fa-warehouse', 1),
(8, 1, 'User List', 'admin/userlist', 'fa fa-fw fa-address-book', 1),
(9, 4, 'Monitoring', 'monitoring', 'fas fa-fw fa-tv', 1),
(10, 7, 'test', 'test', '1', 1),
(11, 1, 'Performance', 'admin/performance', 'fas fa-fw fa-tachometer-alt', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`iddivision`);

--
-- Indeks untuk tabel `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`idhardware`);

--
-- Indeks untuk tabel `performance`
--
ALTER TABLE `performance`
  ADD PRIMARY KEY (`idperformance`);

--
-- Indeks untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`idtype`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- Indeks untuk tabel `useruse`
--
ALTER TABLE `useruse`
  ADD PRIMARY KEY (`iduse`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `division`
--
ALTER TABLE `division`
  MODIFY `iddivision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `inventory`
--
ALTER TABLE `inventory`
  MODIFY `idhardware` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `performance`
--
ALTER TABLE `performance`
  MODIFY `idperformance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `type`
--
ALTER TABLE `type`
  MODIFY `idtype` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `useruse`
--
ALTER TABLE `useruse`
  MODIFY `iduse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
