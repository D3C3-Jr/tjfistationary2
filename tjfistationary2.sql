-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2024 at 02:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tjfistationary2`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'Administrator', 'Super User'),
(2, 'Guest', 'Common User');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 7),
(2, 6),
(2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'test@test.com', 4, '2023-12-21 04:43:41', 1),
(2, '::1', 'dummy@dummy.com', 6, '2023-12-21 04:49:41', 1),
(3, '::1', 'dummy@dummy.com', 6, '2023-12-21 04:58:41', 1),
(4, '::1', 'dummy@dummy.com', 6, '2023-12-21 04:59:04', 1),
(5, '::1', 'dummy@dummy.com', 6, '2023-12-21 08:40:46', 1),
(6, '::1', 'dummy@dummy.com', 6, '2023-12-21 08:43:23', 1),
(7, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2023-12-21 08:48:37', 1),
(8, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2023-12-26 03:27:17', 1),
(9, '::1', 'dummy@dummy.com', 6, '2023-12-28 02:19:11', 1),
(10, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2023-12-28 02:29:25', 1),
(11, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2023-12-28 06:10:03', 1),
(12, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2023-12-28 09:33:09', 1),
(13, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2023-12-28 09:38:11', 1),
(14, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2024-01-04 06:26:34', 1),
(15, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2024-01-04 08:11:05', 1),
(16, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2024-01-04 08:50:33', 1),
(17, '::1', 'dwi.cahyono@ijtt-id.com', 7, '2024-01-04 09:48:16', 1),
(18, '192.168.174.186', 'dwi.cahyono@ijtt-id.com', 7, '2024-01-10 01:34:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `barang_id` int(10) UNSIGNED NOT NULL,
  `barang_kode` varchar(100) NOT NULL,
  `barang_nama` varchar(100) NOT NULL,
  `barang_id_kategori` int(11) UNSIGNED NOT NULL,
  `barang_id_satuan` int(11) UNSIGNED NOT NULL,
  `barang_stok` int(11) NOT NULL,
  `barang_harga` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`barang_id`, `barang_kode`, `barang_nama`, `barang_id_kategori`, `barang_id_satuan`, `barang_stok`, `barang_harga`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BAR0001', 'Ovaltive', 9, 3, 20, 7000, '2023-12-14 03:56:14', '2024-01-04 09:08:52', '0000-00-00 00:00:00'),
(2, 'BAR0002', 'Chocolatos', 9, 2, 183, 3000, '2023-12-14 03:59:15', '2024-01-10 01:37:26', '0000-00-00 00:00:00'),
(3, 'BAR0003', 'kjnkj', 9, 2, 80, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'BAR0004', 'hiuhi', 9, 2, 100, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'BAR0005', 'Semen', 9, 3, 80, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'BAR0006', 'Pasir', 9, 3, 100, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'BAR0007', 'Kacang', 9, 2, 80, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'BAR0008', 'Kopi', 9, 2, 100, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'BAR0009', 'Gunting', 9, 2, 80, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'BAR0010', 'Susu', 9, 2, 100, 10000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'BAR0011', 'Kran', 9, 2, 80, 8000, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'BAR0012', 'Biskuit', 9, 2, 100, 10000, '0000-00-00 00:00:00', '2024-01-04 09:08:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `barang_keluar_id` int(10) UNSIGNED NOT NULL,
  `barang_keluar_kode` varchar(100) NOT NULL,
  `barang_id` int(10) UNSIGNED NOT NULL,
  `barang_keluar_jumlah` int(11) NOT NULL,
  `barang_keluar_tanggal` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`barang_keluar_id`, `barang_keluar_kode`, `barang_id`, `barang_keluar_jumlah`, `barang_keluar_tanggal`, `created_at`, `updated_at`, `deleted_at`) VALUES
(19, 'BK202312210001', 1, 100, '2023-12-21', '2023-12-21 09:29:27', '2023-12-21 09:29:27', '0000-00-00 00:00:00'),
(20, 'BK202312210002', 1, 50, '2023-12-21', '2023-12-21 09:31:54', '2023-12-21 09:31:54', '0000-00-00 00:00:00'),
(21, 'BK202312210003', 1, 70, '2023-12-21', '2023-12-21 09:33:54', '2023-12-21 09:33:54', '0000-00-00 00:00:00'),
(22, 'BK202312210004', 1, 10, '2023-12-21', '2023-12-21 09:40:48', '2023-12-21 09:40:48', '0000-00-00 00:00:00'),
(23, 'BK202312210005', 1, 20, '2023-12-21', '2023-12-21 09:41:35', '2023-12-21 09:41:35', '0000-00-00 00:00:00'),
(24, 'BK202312210006', 1, 5, '2023-12-21', '2023-12-21 09:42:34', '2023-12-21 09:42:34', '0000-00-00 00:00:00'),
(25, 'BK202312260007', 1, 3, '2023-12-26', '2023-12-26 03:28:20', '2023-12-26 03:28:20', '0000-00-00 00:00:00'),
(26, 'BK202401100008', 2, 30, '2024-01-10', '2024-01-10 01:37:26', '2024-01-10 01:37:26', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `barang_masuk_id` int(10) UNSIGNED NOT NULL,
  `barang_masuk_kode` varchar(100) NOT NULL,
  `barang_id` int(10) UNSIGNED NOT NULL,
  `barang_masuk_jumlah` int(11) NOT NULL,
  `barang_masuk_tanggal` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`barang_masuk_id`, `barang_masuk_kode`, `barang_id`, `barang_masuk_jumlah`, `barang_masuk_tanggal`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'BM202312140001', 1, 10, '2023-12-14', '2023-12-14 09:05:45', '2023-12-14 09:05:45', '0000-00-00 00:00:00'),
(11, 'BM202312140001', 2, 10, '2023-12-14', '2023-12-14 09:05:45', '2023-12-14 09:05:45', '0000-00-00 00:00:00'),
(12, 'BM202312140003', 1, 5, '2023-12-14', '2023-12-14 09:06:50', '2023-12-14 09:06:50', '0000-00-00 00:00:00'),
(13, 'BM202312140003', 2, 100, '2023-12-14', '2023-12-14 09:06:50', '2023-12-14 09:06:50', '0000-00-00 00:00:00'),
(14, 'BM202312140005', 1, 5, '2023-12-14', '2023-12-14 09:08:19', '2023-12-14 09:08:19', '0000-00-00 00:00:00'),
(15, 'BM202312140005', 2, 1, '2023-12-14', '2023-12-14 09:08:19', '2023-12-14 09:08:19', '0000-00-00 00:00:00'),
(16, 'BM202312140007', 1, 100, '2023-12-14', '2023-12-14 09:09:15', '2023-12-14 09:09:15', '0000-00-00 00:00:00'),
(17, 'BM202312140007', 2, 1, '2023-12-14', '2023-12-14 09:09:15', '2023-12-14 09:09:15', '0000-00-00 00:00:00'),
(18, 'BM202312140009', 2, 1, '2023-12-14', '2023-12-14 09:10:23', '2023-12-14 09:10:23', '0000-00-00 00:00:00'),
(19, 'BM202312140009', 1, 200, '2023-12-14', '2023-12-14 09:10:23', '2023-12-14 09:10:23', '0000-00-00 00:00:00'),
(20, 'BM202312140011', 2, 200, '2023-12-14', '2023-12-14 09:11:45', '2023-12-14 09:11:45', '0000-00-00 00:00:00'),
(21, 'BM202312140011', 1, 2, '2023-12-14', '2023-12-14 09:11:45', '2023-12-14 09:11:45', '0000-00-00 00:00:00'),
(22, 'BM202312200013', 1, 500, '2023-12-20', '2023-12-20 02:50:56', '2023-12-20 02:50:56', '0000-00-00 00:00:00'),
(23, 'BM202312200014', 1, 200, '2024-01-01', '2023-12-20 02:51:34', '2023-12-20 02:51:34', '0000-00-00 00:00:00'),
(24, 'BM202312210015', 1, 200, '2023-12-21', '2023-12-21 09:30:22', '2023-12-21 09:30:22', '0000-00-00 00:00:00'),
(25, 'BM202312210016', 1, 100, '2023-12-21', '2023-12-21 09:31:36', '2023-12-21 09:31:36', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cost_centre`
--

CREATE TABLE `cost_centre` (
  `cost_centre_id` int(10) UNSIGNED NOT NULL,
  `cost_centre_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cost_centre`
--

INSERT INTO `cost_centre` (`cost_centre_id`, `cost_centre_nama`) VALUES
(2, 'HRGA'),
(3, 'Accounting'),
(4, 'Purchasing'),
(5, 'Exim');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(10) UNSIGNED NOT NULL,
  `kategori_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_nama`) VALUES
(9, 'Office Supply'),
(10, 'Production Supply');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-12-13-040143', 'App\\Database\\Migrations\\BarangMigration', 'default', 'App', 1702442808, 1),
(2, '2023-12-13-040158', 'App\\Database\\Migrations\\BarangMasukMigration', 'default', 'App', 1702442808, 1),
(3, '2023-12-13-040212', 'App\\Database\\Migrations\\BarangKeluarMigration', 'default', 'App', 1702442809, 1),
(4, '2023-12-13-040238', 'App\\Database\\Migrations\\KategoriMigration', 'default', 'App', 1702442809, 1),
(5, '2023-12-13-040257', 'App\\Database\\Migrations\\SatuanMigration', 'default', 'App', 1702442809, 1),
(6, '2023-12-13-044153', 'App\\Database\\Migrations\\CostCentreMigration', 'default', 'App', 1702442809, 1),
(7, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1703132695, 2);

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `satuan_id` int(10) UNSIGNED NOT NULL,
  `satuan_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`satuan_id`, `satuan_nama`) VALUES
(2, 'Dus'),
(3, 'Kaleng'),
(4, 'Liter'),
(6, 'Botol');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `cost_centre_id` int(10) UNSIGNED NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `cost_centre_id`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'dummy@dummy.com', 'Dummy', 2, '$2y$10$ghJ4A8vQFV03S0WRy/91X.ScnJEHOkfLz1SmHrZCs2JbisNRMgS..', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-12-21 04:48:37', '2023-12-21 04:48:37', NULL),
(7, 'dwi.cahyono@ijtt-id.com', 'Dwi Cahyono', 2, '$2y$10$WmhjIBdoX6lXgWa4i5bVaOPisnQSz6PyaUHq/qBi37jhARN.RoYWm', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2023-12-21 08:48:26', '2023-12-21 08:48:26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`barang_keluar_id`),
  ADD KEY `barang_keluar_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`barang_masuk_id`),
  ADD KEY `barang_masuk_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `cost_centre`
--
ALTER TABLE `cost_centre`
  ADD PRIMARY KEY (`cost_centre_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`satuan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `barang_keluar_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `barang_masuk_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cost_centre`
--
ALTER TABLE `cost_centre`
  MODIFY `cost_centre_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `satuan_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD CONSTRAINT `barang_keluar_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`);

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`barang_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
