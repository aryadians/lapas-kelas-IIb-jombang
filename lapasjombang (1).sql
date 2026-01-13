-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jan 2026 pada 03.05
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
-- Database: `lapasjombang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungans`
--

CREATE TABLE `kunjungans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_kunjungan` varchar(255) DEFAULT NULL,
  `wbp_id` bigint(20) UNSIGNED NOT NULL,
  `nama_pengunjung` varchar(255) NOT NULL,
  `nik_ktp` varchar(16) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `no_wa_pengunjung` varchar(255) NOT NULL,
  `email_pengunjung` varchar(255) DEFAULT NULL,
  `alamat_pengunjung` text NOT NULL,
  `barang_bawaan` varchar(255) DEFAULT NULL,
  `hubungan` varchar(255) NOT NULL,
  `pengikut_laki` int(11) NOT NULL DEFAULT 0,
  `pengikut_perempuan` int(11) NOT NULL DEFAULT 0,
  `pengikut_anak` int(11) NOT NULL DEFAULT 0,
  `tanggal_kunjungan` date NOT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `nomor_antrian_harian` int(10) UNSIGNED DEFAULT NULL,
  `sesi` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `preferred_notification_channel` varchar(255) DEFAULT NULL,
  `qr_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kunjungans`
--

INSERT INTO `kunjungans` (`id`, `kode_kunjungan`, `wbp_id`, `nama_pengunjung`, `nik_ktp`, `jenis_kelamin`, `no_wa_pengunjung`, `email_pengunjung`, `alamat_pengunjung`, `barang_bawaan`, `hubungan`, `pengikut_laki`, `pengikut_perempuan`, `pengikut_anak`, `tanggal_kunjungan`, `foto_ktp`, `nomor_antrian_harian`, `sesi`, `status`, `preferred_notification_channel`, `qr_token`, `created_at`, `updated_at`) VALUES
(20, 'VIS-VUKDHH', 1690, 'Arya Dian', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/63ufSd1wdcGdLRacYIhofNl10O973s1bZNGWe4xB.jpg', 1, 'pagi', 'approved', NULL, 'af6a42d5-80f5-45ca-b9a9-ad131c307f35', '2026-01-11 08:04:23', '2026-01-11 09:15:02'),
(21, 'VIS-EBANEE', 1690, 'Arya Dian', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/LVXv0ODI9qBb7FoOFHFRVzLBuWGPPmDpJBCj8Iu8.jpg', 2, 'pagi', 'approved', NULL, '5aceb5e1-0d6c-4da6-90ce-49b0d8ca149e', '2026-01-11 08:15:44', '2026-01-11 09:15:03'),
(22, 'VIS-BOW6HN', 1690, 'Arya Dian', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/oBjivWYrnOIwFDXD9BzrtCAX4YbofAmNflcQfx25.jpg', 3, 'pagi', 'approved', NULL, 'c82960f4-7d72-4201-a306-136b6e5356ae', '2026-01-11 08:28:02', '2026-01-11 09:15:03'),
(23, 'VIS-Q1OFQI', 1690, 'Arya Dian', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/1Zk3UViIcS2kT2DVJT1Sir4M2lHzSH8eMSGsOChd.jpg', 4, 'pagi', 'approved', NULL, 'c1fd1b2d-f0fa-4091-8557-9d449a1c96bb', '2026-01-11 08:28:57', '2026-01-11 09:15:03'),
(24, 'VIS-XA4PDG', 1690, 'Arya Dian', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/SsM0hZfphl88iEvwmZRWOuzO29wqmqd5DZIPHm7V.jpg', 5, 'pagi', 'approved', NULL, '72768301-ec49-489d-a0a5-8115cd02f263', '2026-01-11 08:29:02', '2026-01-11 09:15:03'),
(25, 'VIS-RCB5EE', 1690, 'Arya Dian', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/MFsc3ZQrZHvm1XM7RZckrWJIrkIRO0ddS5Ztlsnd.jpg', 6, 'pagi', 'approved', NULL, '4d40380a-6178-480f-8eca-20199a386503', '2026-01-11 08:35:28', '2026-01-11 09:15:03'),
(26, 'VIS-GNNVZC', 1690, 'Arya Dian', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/flJYQTSmn4VKW86SukXxefeXXYZyKUX2FpRDnePv.jpg', 7, 'pagi', 'approved', NULL, '6387262c-5076-43e2-ac11-62aec733edc5', '2026-01-11 08:39:44', '2026-01-11 09:15:03'),
(31, 'VIS-B7RP7A', 1656, 'Arya Dian', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Istri/Suami', 0, 0, 0, '2026-01-12', 'uploads/ktp/gTMVJFQ6MbbnOGfh5ZPD8iiJ5Do6LB8NpNFnNCWK.jpg', 1, 'siang', 'approved', NULL, '6bf7a600-c0bf-42e2-aa5e-da3e558d7bcf', '2026-01-11 09:13:34', '2026-01-11 09:15:03'),
(32, 'VIS-FGRI4S', 2075, 'Arya Dian S', '1234567890987654', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Saudara', 0, 0, 0, '2026-01-12', 'uploads/ktp/xIryh4nctgK7X93uStAqkDdDT2ZioTfME6qNJdQm.jpg', 8, 'pagi', 'pending', NULL, '5b729458-3212-43ea-83f7-29556543127d', '2026-01-11 09:17:34', '2026-01-11 09:17:34'),
(33, 'VIS-KST2M1', 1689, 'Arya Dian', '1234567890000000', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/jNrXdGbslWoPS73F3ybV86blcvMyTd6buC5W58rd.jpg', 2, 'siang', 'pending', NULL, '557b9d7d-9353-4abb-bdd2-8e13b77dd89c', '2026-01-11 09:35:57', '2026-01-11 09:35:57'),
(36, 'VIS-7SXNH3', 1836, 'Arya Dian', '3517180106020001', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Anak', 0, 0, 0, '2026-01-12', 'uploads/ktp/UXzn9fIRqVggoN8GNJwMCp65R0ObNNRjoiXqMmaP.jpg', 3, 'siang', 'pending', NULL, 'dd65b584-cc10-4893-ac87-7e751d062d1f', '2026-01-11 09:58:03', '2026-01-11 09:58:03'),
(37, 'VIS-ZNETMK', 1929, 'Arya Dian', '1234567890000002', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Saudara', 0, 0, 0, '2026-01-12', 'uploads/ktp/mPxvaMXevg4OzgUATtuQUSJrl275aVnvpHYl0w0y.jpg', 9, 'pagi', 'pending', NULL, 'afa9e034-5ac0-4efc-885f-49d4152b57fe', '2026-01-11 10:00:41', '2026-01-11 10:00:41'),
(38, 'VIS-QSCXSF', 1697, 'Arya Dian', '1234567890000003', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Orang Tua', 0, 0, 0, '2026-01-12', 'uploads/ktp/uPVVBdvljbeMUqdXT9ULJQdHh0kwgnqFb1L82yZ4.jpg', 4, 'siang', 'approved', NULL, 'bf2ac9f7-a10a-493c-a036-f1ebbb8b90c3', '2026-01-11 10:07:54', '2026-01-11 10:08:55'),
(39, 'VIS-EMJZBF', 1811, 'Arya Dian', '1234567890000009', 'Laki-laki', '083845529777', 'aryadian003@gmail.com', 'Jl Srikandi RT/RW 004/001, Ds. Bandar Kedung Mulyo', 'kecap', 'Orang Tua', 0, 0, 0, '2026-01-12', 'uploads/ktp/MMAsy8aSkOpafOl4ObDTKCetkBNOF2JhgC46KBWP.jpg', 10, 'pagi', 'approved', NULL, 'cbaae0e1-3f6d-4e1f-a330-e5f287733d4c', '2026-01-11 11:57:24', '2026-01-11 11:58:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_01_01_000000_create_users_table', 1),
(2, '2025_12_03_030145_create_news_table', 1),
(3, '2025_12_03_030149_create_announcements_table', 1),
(4, '2025_12_25_100000_create_kunjungans_table', 1),
(5, '2025_12_25_110000_add_role_column_to_users_table', 1),
(6, '2025_12_26_110000_add_email_to_kunjungans_table', 1),
(7, '2025_12_26_120000_add_queue_and_session_to_kunjungans_table', 1),
(8, '2025_12_27_100000_add_unique_constraint_to_kunjungans_table', 1),
(9, '2025_12_27_110000_add_qr_token_to_kunjungans_table', 1),
(10, '2025_12_28_000000_change_image_column_to_long_text_in_news_table', 1),
(11, '2025_12_29_094759_create_failed_jobs_table', 1),
(12, '2025_12_29_150000_update_user_roles', 1),
(13, '2025_12_30_000000_create_contacts_table', 1),
(14, '2026_01_02_084707_add_status_to_news_table', 1),
(15, '2026_01_02_085001_add_status_to_announcements_table', 1),
(16, '2026_01_02_091250_create_cache_table', 1),
(18, '2026_01_07_100833_add_details_to_kunjungans_table', 1),
(21, '2026_01_07_100539_create_wbps_table', 2),
(22, '2026_01_07_172024_add_wbp_id_to_kunjungans_table', 3),
(23, '2026_01_07_174830_add_details_to_kunjungans_table', 4),
(24, '2026_01_07_180818_create_pengikuts_table', 5),
(25, '2026_01_07_191250_add_jenis_kelamin_to_kunjungans_table', 6),
(26, '2026_01_07_192626_fix_kunjungans_table_structure', 7),
(27, '2026_01_07_193043_clean_up_kunjungans_table', 8),
(28, '2026_01_07_194700_remove_nama_wbp_from_kunjungans_table', 9),
(29, '2026_01_07_210845_add_email_to_kunjungans_table', 10),
(30, '2026_01_07_211727_add_barang_bawaan_to_kunjungans_table', 10),
(31, '2026_01_09_100000_create_surveys_table', 11),
(32, '2026_01_10_100000_add_preferred_notification_channel_to_kunjungans_table', 12),
(33, '2026_01_11_160957_update_unique_constraint_kunjungans_table', 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengikuts`
--

CREATE TABLE `pengikuts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kunjungan_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `hubungan` varchar(255) DEFAULT NULL,
  `barang_bawaan` varchar(255) DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `surveys`
--

CREATE TABLE `surveys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `saran` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `surveys`
--

INSERT INTO `surveys` (`id`, `rating`, `saran`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 4, 'mantap', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 16:26:36', '2026-01-09 16:26:36'),
(2, 3, 'baik', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-09 16:27:08', '2026-01-09 16:27:08'),
(3, 4, 'keren, pelayanannya mantap. teratur, terstruktur dan tidak banyak masalah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 01:15:40', '2026-01-10 01:15:40'),
(4, 1, 'keren, pelayanannya mantap. teratur, terstruktur dan tidak banyak masalah, keren, pelayanannya mantap. teratur, terstruktur dan tidak banyak masalah, keren, pelayanannya mantap. teratur, terstruktur dan tidak banyak masalah', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-10 01:16:01', '2026-01-10 01:16:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@lapasjombang.go.id', '2026-01-07 04:03:32', '$2y$12$f0D5CQDA/2jaSwjHkt0zGuN4tSe2nh16FFlj8jm22Bmq7L8I./EUq', 'admin', NULL, '2026-01-07 04:03:32', '2026-01-07 04:03:32'),
(2, 'ARYA DIAN SAPUTRA', 'admin@lapasjombang.com', NULL, '$2y$12$TjEcYX6GNk4edUPcGgK6L.w8BG/VyW/xVrIQpJjXfKvl6p6lhKzry', 'super_admin', NULL, '2026-01-07 04:05:28', '2026-01-07 04:05:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wbps`
--

CREATE TABLE `wbps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_registrasi` varchar(255) NOT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `tanggal_ekspirasi` date DEFAULT NULL,
  `nama_panggilan` varchar(255) DEFAULT NULL,
  `blok` varchar(255) DEFAULT NULL,
  `kamar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `wbps`
--

INSERT INTO `wbps` (`id`, `nama`, `no_registrasi`, `tanggal_masuk`, `tanggal_ekspirasi`, `nama_panggilan`, `blok`, `kamar`, `created_at`, `updated_at`) VALUES
(1655, 'A. SYAFIUL HAQIQI BIN SUPRATMAN', 'BI. 195/2025', '2025-02-25', '2026-07-22', 'HAQI', 'A', 'A7', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1656, 'ABD WAHED BIN ASMARA', 'B.I 077/2023', '2023-01-26', '2027-11-29', NULL, 'A', 'A8', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1657, 'ABDI EKOYONO BIN DASIM', 'BI. 352/2022', '2022-05-30', '2029-01-31', NULL, 'C', 'C16', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1658, 'ABDU HAKIM BIN MOCHAMAD ABDUL RAHMAN', 'BI.N 107/2024', '2023-07-12', '2028-08-12', 'JUBEK', 'BA', 'BA6', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1659, 'ABDUL AFANDI BIN SOKIP', 'BI.N 006/2024', '2022-12-12', '2027-03-01', 'GENTONG', 'A', 'A7', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1660, 'ABDUL AZIZ BIN SUHARTONO', 'BI.N 564/2023', '2023-01-18', '2027-06-01', 'KADUL', 'C', 'C13', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1661, 'ABDUL GHONI BIN MUSTOFA', 'BI.N 029/2025', '2024-09-24', '2030-10-03', 'GONI', 'A', 'A5', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1662, 'ABDUL HAMID BIN MARDI (ALM)', 'AIIIN. 340/2025', '2025-07-23', '2026-02-22', 'HAMID', 'A', 'A11', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1663, 'ABDUL ROHMAN AKBAR BIN ROBANGI', 'AIIIN. 330/2025', '2025-10-28', '2026-02-12', NULL, 'A', 'A3', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1664, 'ABDUL ROZAQ EFENDI BIN NUR SALIM', 'BI.N 080/2025', '2024-04-09', '2030-02-27', NULL, 'C', 'C17', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1665, 'ACH. LIMAN BIN MARLAS', 'BI.106/2025', '2025-06-05', '2028-04-26', 'SLEBOR', 'A', 'A8', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1666, 'ACHMAD ABDI SUSANTO BIN WAKIDI', 'BI. 215/2025', '2025-01-09', '2039-11-05', 'SANTO', 'BA', 'BA8', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1667, 'ACHMAD AFANDI BIN RIBUT SUPARYONO', 'BI.N 168/2024', '2024-07-08', '2028-12-05', NULL, 'A', 'A11', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1668, 'ACHMAD ANDI MUHTAMIM BIN SUKARI', 'BI.N 017/2025', '2024-08-12', '2030-06-23', NULL, 'D', 'D4', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1669, 'ACHMAD CHOIRURROZIQIN IMRONULLOH BIN M.AYUB', 'BI.N 222/2023', '2022-01-18', '2027-06-15', 'IMRON', 'C', 'C16', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1670, 'ACHMAD FAHMI RAHMATULLAH BIN JAMAL', 'BI.N 206/2025', '2025-01-09', '2030-09-08', NULL, 'C', 'C6', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1671, 'ACHMAD FATHUR ROZI BIN SUNARDI', 'BI.N 327/2023', '2023-06-13', '2028-05-11', NULL, 'BA', 'BA7', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1672, 'ACHMAD FATQUR ROHMAN BIN ABDUR ROHMAN (ALM)', 'BI.N 221/2023', '2022-01-18', '2027-06-15', 'JEMBLUNG', 'BA', 'BA13', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1673, 'ACHMAD FAUZAN BIN SULIS TYO HADI', 'BI.N 285/2023', '2023-05-25', '2029-08-20', NULL, 'A', 'A7', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1674, 'ACHMAD FEBRIYANTO LIKHIN BIN SOLIKHIN', 'BI.N 294/2025', '2025-05-16', '2029-04-25', 'RIYAN', 'C', 'C10', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1675, 'ACHMAD GILANG FERDIANSYAH BIN PURWO EDI', 'BI.N 003/2024', '2023-06-08', '2028-07-18', 'SATIM', 'A', 'A12', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1676, 'ACHMAD MUKLIS BIN JA\'FAR', 'BI.N 066/2025', '2024-07-08', '2028-05-08', 'ARIF', 'A', 'A11', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1677, 'ACHMAD SAIFUDIN BIN SLAMET', 'BI.N 186/2025', '2024-08-12', '2026-03-27', 'MAD', 'C', 'C15', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1678, 'ACHMAD SOCHI BIN ROKIM (ALM)', 'BI.N 241/2025', '2025-03-25', '2027-01-17', 'SOKEK', 'C', 'C6', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1679, 'ACHMAD TAUFIQ BIN MISNO', 'AII. 378/2025', '2025-11-18', '2026-01-18', NULL, 'A', 'A7', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1680, 'ACHMAD TORIQ FIRMANSYAH BIN WARSITO', 'AIVN. 065/2025', '2025-03-25', '2026-01-22', NULL, 'D', 'D4', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1681, 'ACHMAD ZULKIFLI BIN EDRUS', 'BI. 251/2025', '2025-01-09', '2042-11-12', 'KIPLI', 'A', 'A7', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1682, 'ADE ANGGRYAWAN BIN ISWANTO', 'BI.N 186/2024', '2024-07-08', '2029-12-02', 'DOPO', 'C', 'C9', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1683, 'ADE KRISTIAN BIN TOTOK WIDODO', 'BI. 158/2024', '2024-06-24', '2026-04-26', NULL, 'A', 'A11', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1684, 'ADI PRASETYO UTOMO BIN SUWADI', 'AIIIN. 337/2025', '2025-07-23', '2026-02-22', NULL, 'A', 'A11', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1685, 'ADI SANTOSO BIN MURI (ALM)', 'BI.N 078/2025', '2024-01-26', '2027-08-16', 'PESEK', 'C', 'C16', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1686, 'ADI SUPRAPTO BIN MATSUI', 'BI.N 464/2023', '2023-09-12', '2027-10-28', NULL, 'A', 'A9', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1687, 'ADI SUTRISNO BIN SUGENG', 'BI.N 093/2024', '2023-12-14', '2028-02-15', 'GOPEK', 'BA', 'BA7', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1688, 'ADIP SUSANTO BIN ALIMUN (ALM)', 'BI.N 096/2025', '2024-11-13', '2028-12-21', 'KODOP', 'C', 'C14', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1689, 'ADITYA ANGGA NEGARA BIN ZAINUL ARIFIN (ALM)', 'BI.N 139/2025', '2024-09-24', '2030-08-04', 'ADIT', 'BA', 'BA2', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1690, 'ADITYA WICAKSONO BIN -', 'BI. 159/2024', '2024-04-09', '2029-10-26', 'CUYONG', 'A', 'A5', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1691, 'ADITYA YUDHA PRATAMA BIN MUJI SLAMET', 'BI. 313/2025', '2025-08-31', '2028-03-14', 'SINYO', 'A', 'A13', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1692, 'AFREYZA TEGAR SUWITO PUTRA BIN HERU SUWITO', 'BI. 183/2024', '2024-05-27', '2029-12-03', NULL, 'A', 'A5', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1693, 'AGIL FERIANDA BIN MOCH MASTUR', 'BI. 127/2025', '2025-06-10', '2026-07-12', NULL, 'BA', 'BA12', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1694, 'AGUNG SANTOSO BIN SLAMET HARIADI', 'AI. 388/2025', '2025-12-23', '2026-02-04', NULL, 'D', 'D6', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1695, 'AGUNG SEDAYU BIN SUPARNO (ALM)', 'AI.N 348/2025', '2025-11-18', '2026-01-21', 'DAYU', 'A', 'A10', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1696, 'AGUS ARIFIN BIN (ALM) MISLAN BIN MISLAN (ALM)', 'AI.N 302/2025', '2025-10-14', '2026-01-14', 'KANCIL', 'A', 'A12', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1697, 'AGUS BUDIONO BIN SLAMET', 'BI. 339/2022', '2022-07-21', '2036-04-27', 'UCLUK', 'BA', 'BA11', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1698, 'AGUS EKO SANTOSO BIN SOEMITRO', 'AV. 015/2025', '2025-03-17', '2026-02-16', NULL, 'A', 'A12', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1699, 'AGUS HARIADI BIN PAMUJI', 'AIII. 355/2025', '2025-08-31', '2026-03-02', NULL, 'BA', 'BA2', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1700, 'AGUS HARYADI BIN SOLIKAN', 'AI.N 352/2025', '2025-11-18', '2026-01-22', 'BOGEL', 'A', 'A9', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1701, 'AGUS PURNOMO BIN IKSAN', 'BI.N 010/2025', '2024-08-27', '2032-08-17', 'KETENG', 'A', 'A6', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1702, 'AGUS PURNOMO BIN RASIMIN (ALM)', 'AIVN. 074/2025', '2025-05-16', '2026-03-01', NULL, 'A', 'A9', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1703, 'AGUS SETYONO BIN KARYONO (ALM)', 'BI. 240/2025', '2025-05-16', '2026-06-29', NULL, 'A', 'A8', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1704, 'AGUS SULISTYONO BIN SUTRISNO', 'AIIIN. 308/2025', '2025-06-04', '2026-02-13', 'POTRO', 'A', 'A13', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1705, 'AGUS SUTIYONO BIN SAMAJI', 'AVN. 025/2025', '2025-03-17', '2026-04-16', 'AGUS KUPRIT', 'C', 'C8', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1706, 'AGUS SUTOPO BIN MASHUDI', 'BI.N 138/2024', '2024-03-06', '2028-06-13', 'LOWING', 'C', 'C16', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1707, 'AGUS SUYANTO BIN SUKAMTO', 'BI. 410/2021', '2021-06-02', '2038-07-11', 'OM', 'BA', 'BA13', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1708, 'AGUS WAHYU WIDODO BIN KARSONO (ALM)', 'BI.N 149/2023', '2022-09-14', '2027-01-10', 'KONTENG', 'C', 'C1', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1709, 'AGUS WAHYUDI BIN HENDRA', 'BI.N 429/2023', '2023-08-18', '2028-11-12', NULL, 'A', 'A7', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1710, 'AGUS WAHYUDI BIN KARSONO', 'BI.N 215/2024', '2024-03-06', '2028-06-12', 'GENDUT', 'C', 'C1', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1711, 'AGUS WIDODO BIN KARSIMIN', 'BI.N 324/2022', '2022-07-26', '2027-03-18', NULL, 'C', 'C14', '2026-01-11 01:52:17', '2026-01-11 01:52:17'),
(1712, 'AGUS YULIANTO BIN SUJIONO (ALM)', 'BI.N 097/2025', '2024-04-05', '2026-09-27', 'SOGAL', 'BA', 'BA5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1713, 'AGYL FEBRIAWAN BIN SALI', 'BI.N 209/2024', '2023-10-20', '2030-09-27', 'AGYL', 'C', 'C5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1714, 'AHMAD CHOIRUL BASYARUDIN ALIAS GLITOK BIN SUPARNO (ALM)', 'AIVN 071/2025', '2025-05-16', '2026-02-25', 'GLITOK', 'C', 'C8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1715, 'AHMAD FARIDH BIN KUSNAN JUDI (ALM)', 'BI. 210/2025', '2024-10-15', '2028-01-17', NULL, 'A', 'A1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1716, 'AHMAD FATONI ALS TONI BIN SABILILLAH ROSYAD (ALM)', 'BI.N 190/2025', '2025-02-25', '2026-05-01', 'TONI', 'BA', 'BA2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1717, 'AHMAD JUNAIDI BIN MISKAN (ALM)', 'BI.N 348/2022', '2022-03-09', '2027-12-04', 'JUNET', 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1718, 'AHMAD KADAVI BIN SODIQ', 'BI. 217/2025', '2025-04-28', '2027-04-02', 'DAVI', 'BA', 'BA8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1719, 'AHMAD MASYHADI BIN ABDUL GHOFUR', 'AI.N 350/2025', '2025-11-18', '2026-01-22', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1720, 'AHMAD NUR HAIMIN BIN JAJADI', 'AI. 379/2025', '2025-12-03', '2026-01-12', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1721, 'AHMAD SUMARDIYANTO BIN SUGIANTO', 'BI.N 320/2023', '2022-04-18', '2028-01-16', NULL, 'C', 'C5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1722, 'AHMAD YUNUS BIN SUNADI', 'BI. 140/2025', '2024-12-05', '2026-01-09', 'CAKMAT', 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1723, 'AHMAT ROY BIN MAT SALIM', 'BI. 132/2025', '2025-06-10', '2027-12-24', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1724, 'AHMAT YUSUF ARDIANSYAH BIN FATKUR ROHMAN', 'BI.N 205/2025', '2025-02-11', '2030-10-03', 'KIPLI', 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1725, 'AKBAR ALFIANTO HADI BIN SAMSUL HADI', 'BI.N 257/2025', '2025-03-17', '2026-11-01', 'ATENG', 'BA', 'BA8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1726, 'AKHMAD YUSUF AFANDI BIN SETYO BUDI (ALM)', 'AIII. 329/2025', '2025-08-26', '2026-02-10', NULL, 'BA', 'BA1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1727, 'ALAM ADITYA PRAMONO BIN KUSWONO', 'BI.N 526/2023', '2023-11-03', '2028-03-03', NULL, 'BA', 'BA6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1728, 'ALANG HENDRA BIN PONARI', 'AI. 361/2025', '2025-11-18', '2026-01-14', 'ALANG', 'A', 'A10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1729, 'ALDY SATRIYO BIN SYAMSUDIN (ALM)', 'BI. 250/2025', '2025-06-24', '2026-11-26', 'ALDY', 'BA', 'BA12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1730, 'ALFIYATUL LAILIYAH BINTI MANSYUR (ALM)', 'BI.P 009/2025', '2025-05-16', '2027-02-09', 'ALFI', 'WANITA', '1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1731, 'ALI FIQRI FIRMANSYAH BIN AGUSTHOLIB', 'AVN. 030/2025', '2025-03-25', '2026-05-30', 'FIKRI', 'C', 'C11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1732, 'ALI MACHMUD BIN ALI MAKSUN (ALM)', 'BI.N 301/2025', '2025-06-04', '2032-05-24', 'JUSTO', 'D', 'D5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1733, 'ALI SANDRA BIN JADI ( ALM )', 'BI. 247/2021', '2021-04-06', '2027-06-06', NULL, 'A', 'A5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1734, 'ALIF RAHMAN HAKIM BIN SUTEJO', 'AIVN. 067/2025', '2025-05-16', '2026-02-17', NULL, 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1735, 'AMAL MAKRUF BIN MAHMUD YUNUS KATILI', 'AIII. 309/2025', '2025-08-31', '2026-01-14', 'ANGGA', 'BA', 'BA5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1736, 'AMAN WAHYUDI BIN MAKSYUR (ALM)', 'BI. 120/2025', '2025-06-10', '2026-08-13', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1737, 'AMIN ROES BIN MUKADI', 'BI. 260/2025', '2025-03-17', '2042-12-30', NULL, 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1738, 'AMIR MAHMUD BIN MUALIB', 'AIIIN. 365/2025', '2025-08-31', '2026-01-10', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1739, 'ANANG AUNUR ROFIQ BIN SUNAJI (ALM)', 'BI.N 163/2024', '2024-07-08', '2032-05-28', 'KEMIS', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1740, 'ANAS ASRORI BIN JUMAIN', 'BI.N 247/2023', '2022-12-12', '2027-07-22', 'KATE', 'C', 'C7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1741, 'ANDA ARI IRAWAN BIN IRFAINI', 'BI.N 345/2022', '2022-05-19', '2027-01-14', NULL, 'C', 'C3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1742, 'ANDHI WAHYUDIONO BIN SURAHMAD', 'AII. 362/2025', '2025-10-30', '2026-02-03', NULL, 'A', 'A3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1743, 'ANDHIKA HERU WIJAYA BIN NURHADI SISWANTO', 'AIII. 333/2025', '2025-10-14', '2026-02-15', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1744, 'ANDI ADAM PRATAMA BIN MUGENI', 'BI.N 167/2024', '2024-03-06', '2029-08-22', 'ANDIK', 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1745, 'ANDI BAYU PRASETYO BIN NANANG PRAYOGO', 'AV.N 016/2025', '2025-02-11', '2026-03-25', NULL, 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1746, 'ANDI FERISTIAWAN BIN SUGENG', 'BI.N 497/2023', '2023-04-12', '2027-11-24', 'PENDEK', 'C', 'C6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1747, 'ANDI SAMUDRA AL FATEKHA BIN DARWANTO', 'BI. 261/2025', '2025-02-25', '2042-12-30', 'GARENG', 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1748, 'ANDIK ARIYANTO BIN SUPARLAN (ALM)', 'BI.N 191/2024', '2023-12-12', '2029-03-14', 'GONDEK', 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1749, 'ANDIK SANTOSO BIN TAYES (ALM)', 'BI.N 351/2021', '2021-05-03', '2027-08-09', NULL, 'BA', 'BA13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1750, 'ANDIKA WISNU WIJAYA BIN ANDI SUTRISNO', 'BI. 137/2024', '2024-01-17', '2029-03-10', 'DIKA', 'BA', 'BA11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1751, 'ANDREAN AHMAT FARESI BIN SLAMET WAHYUDI', 'BI.N 258/2025', '2025-05-16', '2029-04-25', 'ANDRE', 'C', 'C17', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1752, 'ANDRI PURWO PUTRO BIN HARIONO', 'AIIIN. 348/2025', '2025-07-23', '2026-02-24', NULL, 'BA', 'BA1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1753, 'ANDRI SUYANTO BIN DACHLAN', 'BI.N 565/2023', '2023-06-08', '2028-01-29', 'KENTOS', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1754, 'ANDRIANTO BIN GUNARTO (ALM)', 'BI.N 212/2025', '2024-08-12', '2027-05-09', 'BANDREK', 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1755, 'ANDRIANTO BIN MUZAKKI', 'BI.N 208/2024', '2024-03-26', '2030-03-04', 'AMBON', 'BA', 'BA1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1756, 'ANDRIE EKA BASTIAN BIN HAMZAR BASTIAN', 'AVN. 023/2025', '2025-03-17', '2026-04-17', 'ANDRIA', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1757, 'ANDUNG SUDARIYONO BIN TAMADI (ALM)', 'BI.N 102/2025', '2024-11-13', '2029-07-11', NULL, 'A', 'A2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1758, 'ANITA RINI AGUSTIN BINTI SADIR', 'BI.P 004/2025', '2025-01-30', '2026-01-14', NULL, 'WANITA', '4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1759, 'ANSORI BIN MOCH SAWIR', 'BI.N 467/2023', '2023-09-12', '2027-11-03', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1760, 'ANTIKA SITI ALPIYAH BINTI DARYANTO', 'BI.P 008/2025', '2025-03-17', '2027-03-13', 'TIKA', 'WANITA', '4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1761, 'ANTONIUS DANANG SUPANTORO BIN TARSISIUS SUPARGE', 'AI. 391/2025', '2025-12-23', '2026-01-21', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1762, 'ANWAR SADAD BIN ABDUL KOLIK (ALM)', 'BI. 265/2025', '2025-04-17', '2033-03-26', 'KAWUK', 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1763, 'APRIL MUHIBDIYANTO BIN SLAMET', 'BI.N 181/2024', '2024-07-09', '2028-09-20', 'KABIR', 'BA', 'BA10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1764, 'APRILIANGGA BIN M. HASYIM', 'AIIN. 356/2025', '2025-08-31', '2026-01-28', 'BANGOR', 'D', 'D4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1765, 'ARDI SEPTIAWAN BIN BACHRUL ROZI', 'BI.N 222/2025', '2025-01-30', '2026-06-23', NULL, 'BA', 'BA1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1766, 'ARDIANSYAH PUTRA WIJAYA BIN NOVIANTO', 'AIV. 064/2025', '2025-03-27', '2026-01-22', 'SALIKIN', 'D', 'D4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1767, 'ARI KURNIAWAN BIN SUKAMTO', 'BIIa. 100/2025', '2025-03-17', '2026-03-01', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1768, 'ARIADI BIN CHANDRA', 'BI.N 283/2025', '2025-03-25', '2036-03-24', 'ACONG', 'C', 'C10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1769, 'ARIES PRADANA BIN SUWARNO', 'AI. 343/2025', '2025-10-30', '2026-01-12', NULL, 'A', 'A3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1770, 'ARIF NASRULLAH BIN MUCHLASON', 'BI.N 184/2025', '2025-01-30', '2030-03-22', 'AYIK', 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1771, 'ARIF WICAKSONO BIN WIJI (ALM)', 'BI.N 303/2025', '2024-12-05', '2028-11-19', 'GUK YEH', 'C', 'C6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1772, 'ARIF WIDARMOKO BIN IMAM SUPARDI', 'BI.N 056/2024', '2023-08-14', '2027-07-17', 'ABLEH', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1773, 'ARIFIN BIN AMIN', 'AII. 365/2025', '2025-08-31', '2026-01-11', 'ARIF', 'A', 'A4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1774, 'ARIS CANDRA LIANTO BIN SULIKAN', 'BI. 175/2025', '2025-01-09', '2028-01-16', NULL, 'BA', 'BA11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1775, 'ARIS SETIYAWAN BIN ASEP ROEBY SOETOPO', 'AIIIN 325/2025', '2025-08-31', '2026-02-02', NULL, 'A', 'A13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1776, 'ARIS ZUWANTO BIN ABDULLAH', 'BI. 316/2025', '2025-08-26', '2027-03-21', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1777, 'ARISANTO BIN ABU HARSONO', 'BI. 053/2024', '2023-12-12', '2028-11-04', NULL, 'A', 'A5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1778, 'ARY HANDOKO, S.H BIN USMAN (ALM)', 'BI. 174/2023', '2022-08-25', '2029-06-09', 'HAN', 'BA', 'BA13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1779, 'ARY PRASTYO BIN DOJYO', 'BI.N 062/2024', '2023-10-16', '2029-01-18', 'DORI', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1780, 'ARYA INDRAYANA BRAMASTA BIN NARIONO', 'BI.N 028/2025', '2024-09-24', '2028-04-17', 'PITIK', 'A', 'A13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1781, 'ARYA NANDA PRATAMA BIN AGUS SUPRIADI', 'BI.N 557/2023', '2022-11-14', '2027-12-27', NULL, 'STRAF SEL', 'STRAF SEL 2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1782, 'ASEP ROEBY SOETOPO BIN KAMSILAN (ALM)', 'BI.N 032/2023', '2022-06-15', '2027-04-29', NULL, 'A', 'A13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1783, 'ASMADI BIN TAMANI', 'BI.N 379/2023', '2023-07-18', '2026-10-10', 'AAS', 'A', 'A10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1784, 'AUNIUR ROUF BIN SUTIMAN', 'BI. 136/2025', '2025-06-10', '2027-11-18', NULL, 'BA', 'BA2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1785, 'AWANG HERMANTO BIN MANSUR (ALM)', 'BI.N 284/2025', '2025-03-25', '2033-03-24', NULL, 'C', 'C5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1786, 'AZI YUSVA MEGA PUTRA BIN JAYA SUPENO', 'BI.N 182/2024', '2024-08-12', '2028-01-28', 'ENCEP', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1787, 'AZIZ SUHADA BIN MAMAD', 'BI.N 131/2024', '2024-03-21', '2030-05-29', NULL, 'C', 'C8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1788, 'BAGAST TRISTYANTO PUTRA BIN SUGIANTO', 'BI. 124/2025', '2025-06-10', '2026-10-09', NULL, 'A', 'A9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1789, 'BAGUS ADIANSYAH BIN SUHARIYONO', 'BI.N 234/2025', '2025-03-17', '2031-08-29', NULL, 'C', 'C2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1790, 'BAGUS ARDIANTO BIN SUWANTO (ALM)', 'BI.N 307/2025', '2025-01-09', '2029-01-04', 'BAJOL', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1791, 'BAGUS CANDRA TRI WAHYUDI BIN KUNAR FATONI (ALM)', 'BI.N 170/2024', '2024-07-08', '2028-11-30', NULL, 'C', 'C7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1792, 'BAGUS NURDIANSYAH BIN SUDARTO (ALM)', 'BI.N 546/2023', '2023-06-08', '2026-01-21', 'JALU', 'C', 'C7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1793, 'BAGUS PRASETIYO BIN MISMAN', 'BI.N 153/2023', '2022-09-05', '2027-06-01', 'BLOTONG', 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1794, 'BAGUS PRAYOGO BIN M. KHAFID', 'AIIIN. 312/2025', '2025-06-24', '2026-01-19', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1795, 'BAGUS SAPUTRA BIN SUWAJI', 'AIII. 314/2025', '2025-06-24', '2026-01-21', NULL, 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1796, 'BAGUS SUGARAH BIN KUAT WIBOWO', 'BI.N 187/2025', '2025-01-09', '2029-09-08', 'KUAT', 'C', 'C6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1797, 'BAGUS WIBISONO ALIAS TELO BIN SUDJIONO (ALM)', 'BI.N 266/2025', '2024-12-05', '2033-01-18', 'TELO', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1798, 'BAHAR HERMANSYAH BIN DATENG', 'BI.N 083/2025', '2024-09-24', '2028-10-10', NULL, 'A', 'A9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1799, 'BAHRUL IMANNUDIN KHAQ BIN EDI SANTOSO', 'AV.N 014/2025', '2025-02-11', '2026-03-18', NULL, 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1800, 'BAHRUS SHOLEH BIN KHABIB SHOLEH', 'BI.N 117/2024', '2023-12-20', '2027-03-26', 'MONYOR', 'A', 'A6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1801, 'BAMBANG BIN SUKADI', 'BI. 192/2024', '2024-06-24', '2027-08-24', 'AGUS', 'A', 'A12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1802, 'BAMBANG KANDI KRESTANTO BIN SUROSO (ALM)', 'AVN. 028/2025', '2025-03-25', '2026-05-21', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1803, 'BAMBANG RISDIANTO BIN USUP KUSUMODIHARJO (ALM)', 'BI.K 058/2024', '2024-04-04', '2027-08-25', NULL, 'BA', 'BA3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1804, 'BANYU TOPAN BIN KASIMAN', 'BI.N 048/2024', '2023-05-05', '2028-09-13', 'JEBAT', 'D', 'D4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1805, 'BASUKI RAHMAD BIN TARMUJI', 'BI.N 092/2024', '2023-10-04', '2031-03-20', 'LEK', 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1806, 'BAYU HUDAYANA BINEDI SUBAGIYO', 'AIIIN. 364/2025', '2025-08-31', '2026-03-11', NULL, 'C', 'C11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1807, 'BENI UTOMO BIN SUGIANTO(ALM)', 'BI. 089/2024', '2023-12-12', '2030-03-10', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1808, 'BIMA EKA PUTRA BIN RAJIAN', 'AI. 385/2025', '2025-12-23', '2026-02-01', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1809, 'BIMA TRIO PRAYOGI BIN SUYADI (ALM)', 'BI.N 178/2024', '2024-05-27', '2028-09-07', 'GUNDUL', 'BA', 'BA6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1810, 'BUDI SANTOSO BIN SUTIYO URIP (ALM)', 'AI. 389/2025', '2025-12-23', '2026-01-08', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1811, 'BUDI SUSENO BIN SUKAMTO', 'BI. 037/2025', '2024-10-15', '2027-03-08', NULL, 'A', 'A6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1812, 'BUDI TRIANTO BIN SUMARNO', 'BI.N 330/2022', '2022-01-04', '2027-10-11', 'BOH', 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1813, 'BUDIANTO BIN RAKI', 'BI. 385/2023', '2023-07-18', '2028-09-17', NULL, 'BA', 'BA6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1814, 'BUDIONO PURNOMO BIN SAIDI (ALM)', 'B.I 089/2023', '2023-01-26', '2029-05-21', 'BUDI', 'BA', 'BA1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1815, 'BUNALI BIN MARJU', 'BI.N 473/2023', '2023-09-12', '2028-07-30', NULL, 'A', 'A10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1816, 'BUSUR KRISMA AJI BIN SURI', 'AI. 374/2025', '2025-12-03', '2026-01-19', 'KRIS', 'A', 'A3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1817, 'BUWADI BIN KUSEN (ALM)', 'BI. 009/2023', '2022-08-02', '2029-05-02', NULL, 'BA', 'BA13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1818, 'CAHYO AGUS YULIANTO BIN SUBAKIR', 'BI. 315/2025', '2025-08-26', '2027-01-20', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1819, 'CANDRA ADI DAYA BIN SUHADI', 'BI.N 116/2024', '2023-12-20', '2027-03-26', 'CECEP', 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1820, 'CANDRA BIMANTARA ARIFIN BIN ZAINAL ARIFIN', 'AIIN 358/2025', '2025-08-31', '2026-01-29', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1821, 'CATUR LUTFI HIMAWAN BIN MOENADJI (ALM)', 'BI.N 525/2023', '2023-11-03', '2028-09-04', NULL, 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1822, 'CHENDI PRATAMA BIN SUGIANTO', 'BIIa. 105/2025', '2025-05-16', '2026-05-04', NULL, 'A', 'A1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1823, 'CHOIRIYAH BINTI SARPOH (ALM)', 'BI.PN 002/2025', '2024-03-06', '2027-10-15', 'RIA', 'WANITA', '3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1824, 'CHOIRUL MUKMININ BIN SALI', 'BI.N 173/2025', '2024-08-12', '2029-11-03', 'IRUL', 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1825, 'CHRISTIANI YULI LARASATI BINTI KOESWANTORO (ALM)', 'AIIIP. 016/2025', '2025-08-26', '2026-01-25', NULL, 'WANITA', '4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1826, 'DADANG KURNIAWAN BIN SUTRISNO', 'AIVN. 061/2025', '2025-04-17', '2026-01-15', 'MEE', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1827, 'DANANG PRAYITNO BIN SLAMET', 'AIIIN. 321/2025', '2025-06-24', '2026-01-26', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1828, 'DANDI RIZKIAWAN BIN SAMU\'IN', 'BI.N 02/2023', '2022-10-19', '2029-12-09', 'MBAH', 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1829, 'DANI EKA BUDI ERFANI BIN HUSNI TAMRIN', 'BI.N 094/2024', '2023-06-08', '2027-07-18', 'ACIL', 'A', 'A12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1830, 'DANU PRASTIYO BIN WIRYO', 'BI. 138/2025', '2025-02-11', '2033-09-26', 'GENDUT', 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1831, 'DANY TRI HARIYONO BIN SUBADI (ALM)', 'BI.N 221/2025', '2024-10-22', '2031-09-15', 'SETROK', 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1832, 'DARA ARI KUNTORO BIN PARIYADI', 'BI.N 102/2023', '2022-05-19', '2027-11-09', NULL, 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1833, 'DAVID ANDRIANTO BIN SUKADI', 'BI.N 353/2023', '2022-12-12', '2029-09-13', 'KORENG', 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1834, 'DAVID SUBAGIYO BIN TAKAT ALMARTA (ALMARHUM)', 'BI.N 153/2025', '2025-06-25', '2028-01-24', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1835, 'DEDI FARISTIA GUNATA BIN KANAN', 'BI.N 428/2023', '2023-08-18', '2028-12-24', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1836, 'DEDIK HARIYO SANTOSO BIN SUWARDI', 'BI.N 142/2024', '2023-10-04', '2026-03-14', NULL, 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1837, 'DEDIK SUPRIYANTO BIN SANUSI', 'BI. 133/2025', '2025-06-10', '2027-02-01', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1838, 'DENDIK ANGGA IRIANTO BIN KAREN', 'AIVN 068/2025', '2025-06-04', '2026-02-17', 'LONGOR', 'C', 'C17', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1839, 'DENI KURNIAWAN BIN YATIMAN (ALM)', 'BIIa. 109/2025', '2025-06-04', '2026-02-14', NULL, 'A', 'A10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1840, 'DENNY ERFIANTO BIN SULIYONO (ALM)', 'AVN. 031/2025', '2025-03-25', '2026-05-01', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1841, 'DENY FAKHRUDIN BIN ABDUL WAKHCID (ALM)', 'AIVN. 075/2025', '2025-05-16', '2026-03-03', 'PUNUK', 'C', 'C5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1842, 'DENY HANDOYO BIN BAMBANG JOKO MULYONO', 'AIII. 367/2025', '2025-10-14', '2026-03-12', NULL, 'A', 'A14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1843, 'DIAN ARINI BINTI SUWAJI', 'AI.PN 018/2025', '2025-10-30', '2026-01-07', NULL, 'WANITA', '4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1844, 'DIAN ERWANTO BIN NURPA\'I', 'BI. 131/2025', '2025-06-10', '2027-06-17', NULL, 'BA', 'BA1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1845, 'DICKY ALFATHTONI RAMADHAN BIN PITONO', 'BI.N 115/2024', '2024-01-17', '2027-03-26', 'TENGKEK', 'BA', 'BA6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1846, 'DICKY FARID ARIFUDIN BIN M. SAIFUDIN', 'AI.N 331/2025', '2025-10-30', '2026-01-08', 'BOWO', 'C', 'C5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1847, 'DICKY FIRMAN RIZARD BIN SUKIR', 'BI. 255/2025', '2025-05-16', '2027-10-31', NULL, 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1848, 'DIDIK NUR HADI BIN (ALM) HADI AGUSTIAN', 'BI.N 137/2025', '2024-09-24', '2031-01-24', 'JEMBLONG', 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1849, 'DIDIK WINARTO BIN TAMAN (ALM)', 'B.I. 316/2023', '2023-05-31', '2029-09-03', NULL, 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1850, 'DIDIN EKO WARDONO BIN SUJAK', 'BI.N 262/2025', '2025-06-26', '2033-08-09', 'DEDIN', 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1851, 'DIDIT ADITYA BIN TOTOK SUYANTO', 'BI.N 488/2023', '2023-03-21', '2028-01-23', 'WAK NYO', 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1852, 'DIKI MAULANA BIN EDY HARIONO', 'BI. 548/2023', '2023-05-05', '2027-07-10', NULL, 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1853, 'DIMAS ALDI FIRMANSYAH BIN M ZAINURI', 'BI.N 211/2025', '2025-01-09', '2032-03-26', NULL, 'BA', 'BA2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1854, 'DIMAS ALFIAN SUAPRIANTO BIN BUDI PURWANTO', 'BI.N 146/2024', '2024-03-06', '2030-08-22', NULL, 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1855, 'DIMAS TRI CAHYONO BIN EDI MURYANTO', 'AIII. 368/2025', '2025-10-30', '2026-03-12', 'JINJET', 'A', 'A13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1856, 'DIYAN ARIFIN BIN M. ZAKARIA', 'BI. 237/2025', '2025-02-25', '2027-01-10', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1857, 'DODIK EFENDI BIN MUDAKIR', 'BI.N 569/2023', '2023-01-18', '2027-11-12', 'KENZO', 'C', 'C1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1858, 'DONI OKTAVIANUS BIN ABU MUALIM (ALM)', 'AIII. 324/2025', '2025-08-31', '2026-01-29', NULL, 'BA', 'BA2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1859, 'DONY EKA PRASETIA BIN SOLIKIN (ALM)', 'BI. 128/2025', '2025-06-10', '2028-08-25', NULL, 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1860, 'DWI AGUS SETYAWAN BIN SUWANDI', 'BI.N 244/2023', '2022-05-17', '2029-12-20', 'CEPER', 'C', 'C10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1861, 'DWI ANDRIANSYAH BIN AGUS KARIYANTO', 'AI. 384/2025', '2025-12-23', '2026-02-01', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1862, 'DWI ANGGARA BIN ALI (ALM)', 'BI. 176/2023', '2022-09-28', '2031-01-20', 'UCOK', 'BA', 'BA11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1863, 'DWI BAYU AJI BIN TRI DJONARKO', 'AI.N 365/2025', '2025-12-03', '2026-01-11', NULL, 'C', 'C8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1864, 'DWI PURWANTO BIN KASTURI', 'BI.N 041/2025', '2024-10-22', '2029-06-17', 'NDAWIR', 'C', 'C9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1865, 'EDI WIDAYANTO BIN WARIDI', 'BI. 249/2025', '2025-04-17', '2026-07-01', NULL, 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1866, 'EDY SUMARNO BIN HARIANTO', 'BI. 289/2025', '2025-06-24', '2028-12-11', NULL, 'BA', 'BA1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1867, 'EKA ARDIANSYAH BIN MINAL FAIZIN', 'AIII. 347/2025', '2025-10-14', '2026-02-24', NULL, 'D', 'D2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1868, 'EKO AGUS SETYAWAN BIN SRIYADI', 'AIIN. 372/2025', '2025-10-30', '2026-01-13', NULL, 'C', 'C8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1869, 'EKO FITRIANTO BIN ALEX SISWADI', 'AIV. 060/2025', '2025-03-25', '2026-01-15', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1870, 'EKO HARI PURNOMO BIN ARUMAN', 'BI. 245/2025', '2025-06-30', '2028-05-04', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1871, 'EKO JALU SULAKSONO BIN RAMOJO SOEJOTO', 'AI N 397/2025', '2025-12-23', '2026-01-27', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1872, 'EKO NUR AKBAR PUTRA PRATAMA BIN SULAIMAN', 'BI. 033/2024', '2023-08-29', '2031-04-18', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1873, 'EKO SUSANTO BIN SUNDARI (ALM)', 'BI. 081/2025', '2025-01-09', '2026-10-10', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1874, 'EKO ZAIWAN FITRIANTO BIN ZAINUDIN', 'AI.N 299/2025', '2025-10-14', '2026-01-10', NULL, 'A', 'A12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1875, 'ERICH SATRIYO NUGROHO BIN GATOT SUBROTO', 'BI.N 431/2023', '2023-08-18', '2028-04-02', NULL, 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1876, 'ERWIN ANDRIAN BIN SARIAN', 'BI.N 068/2023', '2022-05-30', '2029-06-05', 'BOLENG', 'D', 'D3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1877, 'ERWIN PRANATA BIN DJOKO WALUYO', 'BI. 112/2025', '2025-06-10', '2028-06-19', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1878, 'FADIL AMZAH BIN ACHMAD MARZUKI', 'BI.N 050/2023', '2023-01-19', '2028-07-28', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1879, 'FADLI NURULARDI BIN AISMAN', 'BIIa. 088/2025', '2025-03-17', '2026-03-04', 'ASDOL', 'BA', 'BA5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1880, 'FAISAL ADITYA BIN NUR FALIQ', 'BI.N 105/2024', '2023-08-29', '2028-10-26', NULL, 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1881, 'FAISAL RISKI BIN EFENDI', 'BI.N 090/2025', '2024-10-22', '2029-12-13', NULL, 'C', 'C5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1882, 'FAJAR ALFARITZI BIN SLAMET', 'BI.N 079/2024', '2023-07-24', '2027-12-03', 'BONENG', 'C', 'C3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1883, 'FAJAR LUSMANTO BIN M FATCHI', 'BI.N 475/2023', '2023-09-12', '2028-01-04', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1884, 'FAJAR RAMADHANI BIN BUNAWI (ALM)', 'AIIN. 357/2025', '2025-08-31', '2026-01-29', 'SOTO', 'A', 'A3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1885, 'FAKHRUDDIN ARROZY BIN BADRINOERDIANSYAH', 'BI.N 188/2025', '2024-11-13', '2030-12-21', NULL, 'C', 'C7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1886, 'FANDI NOVAL BACHTIAR BIN FATCHUR ROCHIM', 'AI.N 334/2025', '2025-10-30', '2026-01-15', NULL, 'A', 'A10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1887, 'FARI FERDIYAN NASRULLAH BIN HARIYANTO', 'AIII. 322/2025', '2025-08-31', '2026-01-26', NULL, 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1888, 'FARID SYAIFUDIN BIN TUWAJI', 'AIIIN. 305/2025', '2025-06-24', '2026-02-11', NULL, 'A', 'A4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1889, 'FARIZKY TRI MAULANA YUSUF BIN WARLIK', 'BI. 304/2025', '2025-06-04', '2033-05-22', 'TRIMY', 'BA', 'BA11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1890, 'FATHKURROJI BIN SAMSUL HUDA', 'BI.N 180/2024', '2024-07-09', '2028-09-20', 'TUEK', 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1891, 'FATHUR SAFA BIN SUGENG PURWANTO (ALM)', 'AIIIN. 369/2025', '2025-11-27', '2026-03-15', NULL, 'C', 'C7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1892, 'FATQUR ROHMAN BIN SUNARDI', 'AIII. 342/2025', '2025-10-14', '2026-02-22', NULL, 'A', 'A14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1893, 'FEBRI WAHYUDI BIN SUWONO', 'BI. 263/2025', '2025-02-11', '2037-12-11', NULL, 'A', 'A5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1894, 'FELIX ANGGORO KASIH BIN DENDA LIANTORO', 'BI.N 177/2024', '2024-07-24', '2028-03-09', NULL, 'BA', 'BA8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1895, 'FERA SETYA PUTRI BINTI RIFAI', 'AIVPN. 004/2025', '2025-04-24', '2026-01-11', NULL, 'WANITA', '4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1896, 'FERDI KRISDIANTO BIN PADELAN', 'BI.N 109/2025', '2024-12-05', '2032-07-09', 'KENTIT', 'A', 'A12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1897, 'FERI EKO SETIAWAN BIN ZAINUDIN', 'AIII. 338/2025', '2025-10-14', '2026-02-23', NULL, 'A', 'A9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1898, 'FERIS HERMANTO BIN SALI', 'BI.N 239/2025', '2025-03-17', '2032-09-07', NULL, 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1899, 'FERRY BIN KASBI', 'BI. 119/2025', '2025-06-10', '2026-11-10', NULL, 'BA', 'BA2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1900, 'FIKI NUR HIDAYAT BIN ISNUN SYAHRONI', 'BI.N 218/2024', '2024-08-12', '2031-11-04', NULL, 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1901, 'FIQI EFFENDI BIN AMIR MAKMUN (ALM)', 'BI.K 292/2025', '2024-10-01', '2028-08-17', NULL, 'BA', 'BA3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1902, 'FIRDI DWI ANGGA BIN KOIRUL ANAM', 'BI.N 236/2025', '2025-03-17', '2032-10-06', 'ANGGA', 'C', 'C17', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1903, 'FIRMANDA AL MA\'RUF BIN MUHTAR HARIONO', 'AIIN. 374/2025', '2025-08-31', '2026-01-13', 'BRIK', 'C', 'C8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1904, 'FRAHASYA ADYTYA WASMA BIN SUGENG WAHYUDI', 'BI.N 079/2025', '2024-08-12', '2030-01-25', NULL, 'C', 'C6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1905, 'FURQONI BIN DIMYATI (ALM)', 'B.I 175/2024', '2024-05-06', '2029-03-24', NULL, 'BA', 'BA10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1906, 'G JOKO IRIANTO BIN H SULAIMAN', 'BI. 238/2025', '2025-02-25', '2028-06-22', NULL, 'A', 'A1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1907, 'GAGUK PRASETYAWAN BIN DJANIMAN', 'AIII. 344/2025', '2025-10-14', '2026-02-23', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1908, 'GALANG PRASETYO AJI BIN SLAMET', 'BI.N 161/2024', '2024-06-26', '2029-03-16', NULL, 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1909, 'GALIH PRAMESTA BIN H. SOLIKIN', 'BI.N 221/2024', '2024-08-27', '2029-11-29', 'HOLIP', 'A', 'A6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1910, 'GATOT SAMUDRA BIN SULANI (ALM)', 'BI.N 282/2025', '2025-03-25', '2032-01-11', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1911, 'GIGIK IKMAWAN BIN BUDIONO', 'BI.N 209/2025', '2025-01-30', '2026-06-19', 'PENCULIT', 'A', 'A9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1912, 'GILANG ADI SASONGKO BIN SUMONO', 'BI.N 006/2025', '2024-08-12', '2031-11-12', NULL, 'D', 'D4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1913, 'GUNAWAN ADI SAPUTRO BIN MARIJONO', 'AI N 398/2025', '2025-12-23', '2026-02-04', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1914, 'GUNDRIK ANDRIARDI BIN SUWARDI', 'BI.N 090/2024', '2023-12-12', '2029-09-08', NULL, 'C', 'C17', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1915, 'GURUH SURYA SAPUTRA BIN M SURYADI', 'B.I N 074/2023', '2023-01-26', '2028-04-12', NULL, 'A', 'A9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1916, 'H MAHFUD BIN SAHWERI', 'BI.N 460/2023', '2023-09-12', '2027-07-26', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1917, 'HABIB MURTADLO BIN ACHMAD SLAMET', 'AIIIN. 302/2025', '2025-06-24', '2026-01-06', NULL, 'C', 'C2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1918, 'HADI PRANATA BIN KARSAN', 'AII. 366/2025', '2025-11-18', '2026-01-11', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1919, 'HADI PRAYITNO BIN TOHIR SANTOSO', 'AI.N 367/2025', '2025-12-03', '2026-01-12', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1920, 'HALIMAN BIN SADI (ALM)', 'BI.N 130/2024', '2023-12-20', '2029-10-05', 'MAN', 'D', 'D3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1921, 'HAMSAH BIN DARIUS YAN', 'BI.N 375/2023', '2023-07-18', '2026-03-10', NULL, 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1922, 'HAMSAH KURNIA PUTRA BIN KUKU WALUYO', 'BI.N 193/2025', '2025-07-18', '2026-02-08', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1923, 'HANDOKO BIN SEGER', 'AIV. 076/2025', '2025-08-31', '2026-01-09', NULL, 'BA', 'BA5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1924, 'HANIF MANSUR MUSTOFA BIN ABU BAKAR', 'AV. 032/1025', '2025-02-25', '2026-03-29', 'KEJENG', 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1925, 'HANIF RIDHO PRIYOKO BIN MACHFUD (ALM)', 'BI.N 169/2025', '2025-06-25', '2026-04-27', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1926, 'HARI JULIANTORO BIN MARDIJANTO', 'BI.N 045/2023', '2023-01-19', '2029-07-16', 'RAMPOK', 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1927, 'HARI UTAMA BIN MUHTADI (ALM)', 'AI.N 329/2025', '2025-10-30', '2026-01-07', NULL, 'C', 'C13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1928, 'HARIONO BIN BADRUN (ALM)', 'BI.N 179/2025', '2024-07-24', '2027-03-08', 'BADRUN', 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1929, 'HARISUL MUTTAQIN BIN M. ANWAR', 'BI. 095/2025', '2024-11-13', '2027-12-08', NULL, 'A', 'A10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1930, 'HARTINI BINTI SUROTO (ALM)', 'AIIIP. 017/2025', '2025-10-14', '2026-03-09', NULL, 'WANITA', '3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1931, 'HARTO UTOMO BIN BUAMIN (ALM)', 'BI.N 198/2024', '2024-04-09', '2028-10-07', NULL, 'A', 'A9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1932, 'HARTONO BIN HERMANTO', 'AIVN. 080/2025.', '2025-05-16', '2026-03-04', 'MANDONO', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1933, 'HARTONO BIN KASELAN', 'BI. 264/2025', '2025-06-24', '2027-01-18', 'HAR', 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1934, 'HENDRA PRASETYO NUGROHO BIN BUDI P', 'BI. 195/2022', '2021-11-29', '2029-03-06', NULL, 'BA', 'BA8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1935, 'HENDRA WIJAYA BIN ROHMAN', 'AIII. 353/2025', '2025-10-14', '2026-03-02', NULL, 'D', 'D5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1936, 'HENDY SUDARYANTO BIN SUPANDI', 'BI.N 059/2025', '2024-09-24', '2030-10-30', 'SIWO', 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1937, 'HENGKY PURWANTO BIN BAMBANG EDI PURNOMO', 'BI.N 132/2024', '2024-01-17', '2029-04-22', NULL, 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1938, 'HERLAMBANG BINTARA SETIAWAN BIN ANDRIANTO', 'BI. 269/2025', '2025-03-17', '2028-09-07', 'LAMBANG', 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1939, 'HERMANSYAH BIN YULIANSYAH (ALM)', 'AII. 370/2025', '2025-11-18', '2026-01-12', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1940, 'HERU CAHYO SETIYONO BIN SUPRAPTO (ALM)', 'BI.K 074/2017', '2015-12-08', '2026-04-26', NULL, 'BA', 'BA3', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1941, 'HERU FACHRUDIN BIN IBRAHIM', 'BI. 293/2025', '2025-07-23', '2027-04-29', 'HERU', 'A', 'A12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1942, 'HERU PRASETYO BIN SUGIANTO', 'BI.N 033/2025', '2024-01-26', '2027-05-21', NULL, 'C', 'C8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1943, 'HERU SANTOSO BIN SARNO MASDUKI', 'AI.N 303/2025', '2025-10-14', '2026-01-24', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1944, 'HERY SUSANTO BIN AHMAD SUGENG', 'BI.N 046/2025', '2024-09-11', '2028-08-21', 'KETEK', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1945, 'HERY SUSETYO BIN SUSWARDONO', 'BI.N 494/2023', '2023-03-21', '2028-02-25', 'HERI MAMA', 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1946, 'HIDAYATUL ARIF BIN PANI (ALM)', 'BI.N 259/2025', '2025-02-11', '2027-06-02', 'TUEK', 'BA', 'BA12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1947, 'HIMAWAN MAHESUDHI BIN SYAFI\'INA', 'AI. 383/2025', '2025-12-23', '2026-01-21', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1948, 'HOIRUL ANAM BIN JAELANI', 'BI. 287/2025', '2025-06-04', '2033-04-29', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1949, 'HUJANG MOMON BIN WADI', 'BI. 207/2025', '2025-03-17', '2026-06-27', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1950, 'IBNU RAKHMAD HIDAYAH BIN -', 'BI. 252/2025', '2025-06-04', '2026-11-13', NULL, 'D', 'D2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1951, 'IBRA KRISNA BIN DANY ISWANDY', 'BI. 115/2025', '2025-06-10', '2026-12-14', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1952, 'IDA SURYAWATI BIN SOHOR', 'AIIP. 019/2025', '2025-10-14', '2026-01-21', NULL, 'WANITA', '1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1953, 'IIR YUSWANTORO BIN SUYONO (ALM)', 'AIIIN. 351/2025', '2025-08-26', '2026-03-01', 'COKIL', 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1954, 'IKE DEWI SARTIKA BINTI MUNAIM', 'AI. PN. 020 / 2025', '2025-12-23', '2026-02-14', NULL, 'WANITA', '1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1955, 'ILHAM RIONALDI RIANTORO BIN JAENAL SOEKANTO', 'BI. 231/2025', '2025-03-25', '2026-10-24', 'RIO', 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1956, 'IMAM FAUZI BIN SUPARLAN', 'BI.N 187/2024', '2024-08-12', '2031-06-08', 'CINO', 'C', 'C10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1957, 'IMAM HARIRI BIN TAMANI', 'BI.N 377/2023', '2023-07-18', '2026-10-07', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1958, 'IMAM MUJAHIDIN BIN CHOLIL', 'BI.N 471/2023', '2023-09-12', '2028-05-22', NULL, 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1959, 'IMAM SANTOSO BIN WARTONO', 'BI.N 095/2024', '2023-04-12', '2027-11-24', 'PAELA', 'C', 'C6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1960, 'IMAM SUBEKI BIN SUBUR ALAM', 'BI. 189/2025', '2025-04-17', '2026-08-21', 'BONJOL', 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1961, 'IMAM SUTRISNO BIN SUWONO', 'BI.N 184/2024', '2024-05-27', '2029-11-10', 'GANDEN', 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1962, 'INDRA TEGUH WAHYUDI BIN SUJONO (ALM)', 'AI.N 304/2025', '2025-10-14', '2026-01-28', NULL, 'A', 'A14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1963, 'IQBAL ARIF BIN ARIF SUPRAYOGI', 'BI.N 013/2025', '2024-08-12', '2029-02-11', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1964, 'IRDANZIZ ZAMRONI BIN USMAN', 'BI.N 420/2023', '2023-02-01', '2028-12-23', NULL, 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1965, 'IRHAM FAHRIHIN BIN SLAMET', 'AIV.N 081/2025', '2025-06-24', '2026-02-10', 'IPUNG', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1966, 'ISDIANTORO BIN NIZARWAN', 'BIIa. 101/2025', '2025-03-17', '2026-01-07', NULL, 'A', 'A2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1967, 'ISMAIL ARIANTO BIN ARCHAN MUCHTAR', 'BI. 015/2025', '2024-07-08', '2027-07-13', 'MUNIP', 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1968, 'ISMAIL BIN SUKATO (ALM)', 'AIIIN. 334/2025', '2025-08-31', '2026-02-16', 'LIAM', 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1969, 'ISMAN BIN WAKIYO', 'AIII. 341/2025', '2025-07-23', '2026-02-22', NULL, 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1970, 'ISMANTO BIN PURNOMO', 'BI.N 220/2024', '2024-08-12', '2030-01-19', 'SATI\'ING', 'C', 'C2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1971, 'ITTAQI TAFUZ BIN UBAIDILLAH', 'BI.N 032/2025', '2024-01-26', '2027-05-21', 'TEKEK', 'A', 'A13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1972, 'IVAN ADAM BRAMANSYAH BIN IWAN ALVIANTO', 'BI.N 367/2023', '2023-07-18', '2027-12-30', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1973, 'IWAN SANTOSO BIN TATMO SUCIANTO (ALM)', 'BI.N 294/2023', '2023-05-25', '2026-02-16', NULL, 'BA', 'BA5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1974, 'IWAN UTOMO BIN SUBARI', 'BI.N 047/2024', '2023-08-29', '2027-05-07', 'HONG', 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1975, 'JACKVANDEN GANGGADARMA JUNI GLORIA BIN NATANAEL JUNANI', 'AV. 017/2025', '2025-01-09', '2026-04-22', NULL, 'A', 'A9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1976, 'JAELANI BIN SAMURI', 'BI.N 568/2023', '2022-08-15', '2027-05-11', 'ALAN', 'D', 'D4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1977, 'JAMIL BIN SAKRI', 'BI. 101/2024', '2023-12-12', '2030-03-04', NULL, 'A', 'A5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1978, 'JAMINAL BIN SAMIADI', 'BI.N 153/2024', '2024-07-08', '2029-11-29', 'BATAK', 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1979, 'JAWA AYOGA BIN SARWADI (ALM)', 'BI.N 018/2025', '2024-07-24', '2030-12-02', NULL, 'BA', 'BA14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1980, 'JIE KO MING BIN JIE CHUN SIN', 'AI. 381/2025', '2025-12-03', '2026-01-11', 'AMING', 'C', 'C12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1981, 'JIHAN HILMI BIN NURUL HAKIM', 'BI.N 233/2023', '2022-10-18', '2027-05-06', 'JEMBLONG', 'C', 'C4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1982, 'JODY SURYA PRATAMA BIN LILIK WIYANTO', 'BI.N 169/2023', '2022-09-05', '2028-01-31', NULL, 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1983, 'JOGA SIER YUNAINI BIN BAMBANG HADI SOERJO', 'BI. 123/2025', '2025-06-10', '2026-11-12', 'YOGA ARDIANSYAH', 'D', 'D5', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1984, 'JOHAN PRATOMO BIN YAKUB SULAIMAN (ALM)', 'BI. 275/2025', '2025-06-04', '2026-11-20', 'TOTOM', 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1985, 'JOKO ADREYANTO BIN SUYANTO', 'AI.N 335/2025', '2025-10-30', '2026-01-16', NULL, 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1986, 'JONI HARSONO BIN SUNARTO (ALM)', 'BI.N 308/2025', '2025-02-11', '2029-01-31', 'JONI', 'A', 'A12', '2026-01-11 01:52:18', '2026-01-11 01:52:18');
INSERT INTO `wbps` (`id`, `nama`, `no_registrasi`, `tanggal_masuk`, `tanggal_ekspirasi`, `nama_panggilan`, `blok`, `kamar`, `created_at`, `updated_at`) VALUES
(1987, 'JUHAN CARLOS FERNANDO BIN KORNELIS SETIYAWAN', 'BI.N 333/2023', '2023-06-13', '2026-05-27', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1988, 'JUMADI BIN TAMAJI', 'AI. 392/2025', '2025-12-23', '2026-02-08', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1989, 'JUMANTO BIN SARMAT', 'BI.N 509/2023', '2022-12-12', '2027-10-01', 'TATO', 'BA', 'BA6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1990, 'JUNI SAPUTRA BIN AMIRUDIN', 'AIII. 354/2025', '2025-10-14', '2026-03-02', NULL, 'A', 'A13', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1991, 'KARIAWAN BIN SAGI', 'AI.N 395/2025', '2025-12-23', '2026-01-27', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1992, 'KARSONO HADI WIBOWO BIN KARSIDIN', 'BIIa. 028/2024', '2023-10-04', '2026-02-04', NULL, 'A', 'A1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1993, 'KHOIRUL ABIDIN BIN SLAMET', 'BI.N 145/2023', '2022-10-19', '2030-06-12', NULL, 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1994, 'KHOIRUL ANAM BIN ISNAN', 'BI.N 108/2025', '2024-12-05', '2030-07-31', 'GECOL', 'A', 'A12', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1995, 'KHOIRUL ANAM BIN SAMANHUDI', 'BI.N 196/2024', '2023-08-29', '2028-10-24', 'COPET', 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1996, 'KHOIRUL ANAM BIN WARJI (ALM)', 'BI. 297/2025', '2025-05-16', '2033-04-17', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1997, 'KHOMARUDIN BIN KUSNAN', 'B.I N 425/2021', '2021-10-04', '2029-04-17', NULL, 'C', 'C9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1998, 'KHOMSUN ADHA BALIA BIN SOLEHUDIN', 'BI. 299/2025', '2025-05-16', '2030-04-17', NULL, 'A', 'A6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(1999, 'KIAN BARA BIN SETYO WAHYUDI', 'BI.N 179/2024', '2024-03-06', '2029-08-22', 'BARA', 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2000, 'KRISNO BIN SAPUAN (ALM)', 'AIIIN. 328/2025', '2025-05-16', '2026-02-04', 'KIPLI', 'C', 'C8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2001, 'KUNCORO HADIYANTO BIN SILAS (ALM)', 'AIII. 363/2025', '2025-10-14', '2026-03-11', NULL, 'BA', 'BA10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2002, 'KUSENAN BIN SUTAWI', 'BI.N 508/2023', '2022-12-23', '2028-05-20', 'BELONG', 'C', 'C15', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2003, 'KUSNADI BIN SLAMET', 'AI. 380/2025', '2025-12-03', '2026-01-12', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2004, 'LINTAR PRATAMA PUTRA BIN SUNARYO (ALM)', 'BIIa. 096/2025', '2025-03-25', '2026-03-23', 'ARI', 'A', 'A11', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2005, 'LUKKY WULYONO BIN SUKIRAN', 'BI.N 196/2023', '2022-01-04', '2028-02-18', 'WUL', 'A', 'A8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2006, 'LUKMAN ARIF KURNIAWAN BIN SUWANDI', 'BI.N 147/2024', '2023-10-20', '2029-01-16', 'DEMANG', 'C', 'C8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2007, 'LUTFI INAHNU FEDA BIN MAT SALIM ARIAN', 'AIV. 063/2025', '2025-03-25', '2026-01-22', 'BOBY', 'D', 'D4', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2008, 'LUTVI ALFIAN BIN SIDIK (ALM)', 'AIIIN. 323/2025', '2025-06-24', '2026-01-27', 'FIAN', 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2009, 'M FERI BISMA RAMADHANI BIN M.JAINURI', 'BIIa.N 080/2023', '2022-03-09', '2029-11-26', 'KEHED', 'BA', 'BA1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2010, 'M IKSAN FANANI BIN SULAIMAN', 'BI.N 073/2023', '2022-07-26', '2027-09-07', NULL, 'C', 'C10', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2011, 'M IMAM PATRIO BIN SUWOTO', 'BI.N 003/2025', '2024-08-12', '2028-01-26', NULL, 'C', 'C6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2012, 'M RAFI MAFAZI BIN SLAMET', 'BI.N 025/2025', '2024-07-24', '2030-02-02', NULL, 'BA', 'BA2', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2013, 'M SYAIFUDIN ILHAM BIN KASTURI (ALM)', 'BI.2336/DP/K/2021', '2022-12-14', '2026-01-02', NULL, 'A', 'A7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2014, 'M. AFIF DWI WAHYUDI BIN DWI SETIAWAN', 'BI.N 204/2024', '2024-04-09', '2028-10-07', 'ITEM', 'A', 'A9', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2015, 'M. ANDRI PRASTYO BIN MUKTAROM', 'BI. 110/2025', '2025-01-09', '2027-08-17', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2016, 'M. ARBA\'I BIN JUMAD (ALM)', 'BI. 009/2022', '2021-09-01', '2033-10-22', 'BAI', 'C', 'C16', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2017, 'M. ARFANDI PUTRA BIN SUDIN', 'BI.N 296/2025', '2025-06-04', '2029-05-24', NULL, 'C', 'C17', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2018, 'M. KAMIM, S.PD BIN SUPADI', 'BI. 054/2024', '2023-10-16', '2031-07-27', NULL, 'BA', 'BA8', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2019, 'M. KHOIRUL ANWAR BIN SOKIB', 'BI.N 198/2025', '2025-02-11', '2028-10-10', 'KAMI', 'A', 'A6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2020, 'M. KHOYYUM BIN SUPARMAN', 'BI.N 056/2025', '2024-09-11', '2028-05-19', NULL, 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2021, 'M. KUKUH CAKRA WIBAWA BIN ABDUL HADI', 'AIIN. 363/2025', '2025-08-31', '2026-01-08', 'KOKO', 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2022, 'M. MUHLISIN BIN RIDUWAN (ALM)', 'AI.N 394/2025', '2025-12-23', '2026-01-25', NULL, 'D', 'D6', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2023, 'M. NURHADI BIN SAIFUL ROZI', 'AIVN 083/2025', '2025-07-23', '2026-01-21', NULL, 'A', 'A1', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2024, 'M. RIZKY WAHYU FIRMANSYAH BIN ANWAR', 'BI.N 181/2025', '2024-05-27', '2030-02-26', 'CIKI', 'C', 'C17', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2025, 'M. ROMADHON BIN HADI MULYONO', 'BI.N 072/2024', '2023-08-02', '2027-05-19', 'MADUN', 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2026, 'M. SAIFULLO BIN ABDUL MALIK', 'BI.N 027/2025', '2024-07-08', '2030-11-29', 'KEBO', 'BA', 'BA7', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2027, 'M. SHOLEH BIN MULYONO', 'BI.N 151/2023', '2022-08-25', '2027-06-04', NULL, 'C', 'C14', '2026-01-11 01:52:18', '2026-01-11 01:52:18'),
(2028, 'M. SOCHIB ANGSORI BIN TAUHID', 'BI.N 004/2025', '2024-09-11', '2028-02-23', 'AAN', 'A', 'A9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2029, 'M. YUSRIL WIRIDHANA BIN M. ARIF', 'BI.N 267/2025', '2024-09-24', '2026-05-31', NULL, 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2030, 'M.AMIN BIN ABDUL MALIK', 'BI.N 419/2023', '2023-02-22', '2027-01-18', 'MINTI', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2031, 'M.ARIF TRI LAKSONO BIN WIBISONO', 'AIIN. 349/2025', '2025-08-31', '2026-01-16', 'BATANG', 'C', 'C10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2032, 'M.DANI SAPUTRA BIN KASIADI (ALM)', 'BI.N 361/2023', '2022-04-05', '2026-01-04', NULL, 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2033, 'M.YANI BIN AHMAD JUNAEDI (ALM)', 'BI.N 091/2024', '2023-08-29', '2031-11-19', 'TEMON', 'C', 'C14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2034, 'MACHFUDZ MAULANA BIN SALIM (ALM)', 'BI.N 067/2025', '2024-08-12', '2029-02-06', NULL, 'C', 'C4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2035, 'MAHENDRA SAPUTRA BIN CATUR SUGIARTO', 'AII. 361/2025', '2025-10-30', '2026-01-31', 'HENDRA', 'A', 'A3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2036, 'MAHFUDIN BIN PARJOKO', 'BI. 044/2025', '2024-08-12', '2035-02-10', 'UDIN', 'BA', 'BA6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2037, 'MAILUL FADHLI BIN SOLEH', 'BI. 178/2025', '2025-02-11', '2029-10-03', 'BONDET', 'BA', 'BA11', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2038, 'MALINDO NUR NUGRAHA BIN NASURI', 'AIIN 377/2025', '2025-10-14', '2026-01-18', 'NUR', 'A', 'A14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2039, 'MAMAT WICAKSONO BIN KUSNANTO (ALM)', 'AVN.002/2025', '2025-01-30', '2026-02-19', NULL, 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2040, 'MANSUR BIN TIMAN', 'BI. 309/2025', '2025-01-09', '2033-12-11', NULL, 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2041, 'MARDAHERA RAKA ANUGRAH JANUAR BIN ATMODJO SUKRO NUGROHO', 'AII. 375/2025', '2025-11-18', '2026-01-13', NULL, 'BA', 'BA8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2042, 'MARIANTO BIN SIRAM', 'BI.N 063/2025', '2024-08-12', '2029-12-27', 'BECU', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2043, 'MARSAI BIN MARSUDIN', 'AI. 372/2025', '2025-12-03', '2026-01-18', NULL, 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2044, 'MARSAM BIN MARSUDIN', 'AI. 371/2025', '2025-12-03', '2026-01-18', 'SAM', 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2045, 'MASDUKAN BIN KAMISAN', 'BI. 235/2025', '2025-02-25', '2027-06-22', NULL, 'A', 'A1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2046, 'MASHUDI BIN SAMIDI', 'BI.N 276/2025', '2025-04-17', '2030-07-08', NULL, 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2047, 'MAT ROMSEH BIN MARSUDIN', 'AI. 373/2025', '2025-12-03', '2026-01-18', NULL, 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2048, 'MAULANA SYARIF AHMAD BIN WIDARTO EFENDI', 'BI.N 434/2022', '2022-05-17', '2030-12-23', 'SLEDOT', 'BA', 'BA13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2049, 'MIFTANANG YULIANTORO BIN ARIFIN (ALM)', 'BI.N 094/2025', '2024-12-05', '2030-07-14', 'BOCIL', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2050, 'MINARTI BINTI ASMINAN', 'BI.P 010/2025', '2025-07-02', '2026-12-23', NULL, 'WANITA', '3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2051, 'MIRA MARYANI BINTI DIDI JUNAEDI', 'AI.P 019/2025', '2025-11-18', '2026-01-12', NULL, 'WANITA', '4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2052, 'MISBAHUL ULUM BIN MASDUQI (ALM)', 'BI. 273/2025', '2025-01-30', '2028-06-01', 'KABUL', 'A', 'A8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2053, 'MOCH BASORI BIN SANIMAN', 'BI. 114/2025', '2025-06-10', '2029-01-09', NULL, 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2054, 'MOCH JINAR RIDWAN BIN MUNIWAR', 'AIII. 343/2025', '2025-10-14', '2026-02-23', NULL, 'A', 'A13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2055, 'MOCH SAFII BIN SARBIDIN', 'BI. 530/2023', '2023-11-03', '2027-12-21', NULL, 'D', 'D3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2056, 'MOCH SYAIFUL BIN TASERI', 'BI. 218/2025', '2025-04-28', '2027-04-02', 'SYAIFUL', 'A', 'A12', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2057, 'MOCH. MACHROMIN BIN MARSO (ALM)', 'BI.N 052/2025', '2024-10-15', '2028-12-08', 'CAK MEN', 'BA', 'BA2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2058, 'MOCH. YUSUF BIN KABIL', 'BI.N 253/2025', '2024-11-13', '2027-10-09', 'ENCEP', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2059, 'MOCHAMAD GHOFAR BIN PA\'I', 'AIII. 359/2025', '2025-10-30', '2026-03-05', 'GOPAR', 'D', 'D2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2060, 'MOCHAMAD IMAM SAFII BIN SLAMET', 'BI. 136/2024', '2024-03-06', '2033-06-09', NULL, 'BA', 'BA11', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2061, 'MOCHAMAD MAHFUD BIN SARDI', 'BI. 214/2025', '2025-04-28', '2027-04-02', 'PUD', 'D', 'D5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2062, 'MOCHAMAD NURDIANSAH BIN NUR SOHIB (ALM)', 'BI.N 227/2023', '2022-09-28', '2028-07-18', 'DIAN', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2063, 'MOCHAMAD REGA DWI ARTA BIN SAMIDI', 'BI. 271/2025', '2025-06-24', '2026-12-06', NULL, 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2064, 'MOCHAMAD RIAN ISMAIL BIN KASMALIK (ALM)', 'BI.N 298/2025', '2025-06-04', '2032-06-24', 'GONDO', 'C', 'C11', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2065, 'MOCHAMAD RIANTO BIN RIADI (ALM)', 'BI.N 152/2024', '2024-04-05', '2033-01-13', 'JE', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2066, 'MOCHAMAD SOLEH BIN JAELANI', 'BI.N 427/2023', '2023-08-18', '2026-10-10', NULL, 'C', 'C14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2067, 'MOCHAMMAD BADRUS SHOLEH BIN MAWARDI (ALM)', 'BI. 071/2025', '2024-12-05', '2026-04-23', NULL, 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2068, 'MOCHAMMAD IMRON ROSYADI BIN SOBIRIN', 'BI.N 232/2025', '2024-11-13', '2027-10-02', 'GEMBUK', 'A', 'A6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2069, 'MOCHAMMAD IZAACH MAHENDRA BIN BUDIYONO', 'BI.N 439/2023', '2023-08-18', '2028-06-17', 'TUWEK', 'BA', 'BA5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2070, 'MOCHAMMAD MISBACHULFAUZI BIN KAMIM', 'AI. 390/2025', '2025-12-23', '2026-02-01', NULL, 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2071, 'MOCHAMMAD SYUFII BIN UNTUNG SUBIANTORO (ALM)', 'BI.N 024/2025', '2024-08-12', '2030-12-08', 'BITOR', 'C', 'C12', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2072, 'MOH IMAN ROMADLONA BIN ASNAN SANTOSO', 'BI.N 174/2024', '2024-04-05', '2028-03-24', NULL, 'C', 'C9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2073, 'MOH RIFKI BIN ISMAIL (ALM)', 'AI.N 345/2025', '2025-11-18', '2026-01-27', 'PAIJO', 'A', 'A9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2074, 'MOH RIYAN FEBRIYAN BIN SUNIDI', 'BI.N 477/2023', '2023-09-12', '2026-07-26', NULL, 'A', 'A8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2075, 'MOH. ANABSIR BIN SUHARSONO (ALM)', 'BI.N 254/2025', '2024-11-13', '2030-11-07', 'ANAS', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2076, 'MOH. ASHARUDIN HIDAYATULLOH BIN MUHAJIR', 'AIV 079/2025', '2025-08-31', '2026-01-16', NULL, 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2077, 'MOH. IWAN BIN ISMAIL', 'BI.N 281/2025', '2025-04-17', '2035-04-08', 'JEBER', 'BA', 'BA12', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2078, 'MOH. RODIANTO BIN MA\'AD', 'BI. 022/2023', '2022-04-27', '2027-01-11', 'ACONG', 'BA', 'BA1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2079, 'MOH.AGUS FAUZI BIN AHMADI', 'BI.N 418/2023', '2023-01-18', '2028-11-11', 'SOGOL', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2080, 'MOHAMAD ADE YOGA BIN SAIFUL KULUD', 'AIII. 345/2025', '2025-10-14', '2026-02-23', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2081, 'MOHAMAD JAILANI BIN PAERAN (ALM)', 'AV.N 013/2025', '2025-01-30', '2026-03-21', 'MAD', 'C', 'C14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2082, 'MOHAMAT EHWAN BIN SUNARDI (ALM)', 'BI. 219/2025', '2025-02-11', '2026-12-29', NULL, 'A', 'A8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2083, 'MOHAMMAD AGIL AZIZI BIN BONAJI', 'BI. 128/2024', '2024-01-17', '2031-04-23', 'POCONG', 'BA', 'BA14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2084, 'MOHAMMAD AGUS SULIS STIAWANTO BIN SUWARTO', 'BI.N 061/2025', '2024-05-27', '2030-11-28', 'ULIS', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2085, 'MOHAMMAD ANDI SATRIO BIN MURSIDI (ALM)', 'AIII. 292/2025', '2025-07-23', '2025-12-30', NULL, 'A', 'A8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2086, 'MOHAMMAD ARDIANSYAH BIN SIKAN', 'BI. 023/2024', '2023-08-29', '2029-04-18', 'ARDI', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2087, 'MOHAMMAD MUNDIR BIN M. SAHID', 'BI.N 256/2025', '2025-06-26', '2026-10-14', 'BAGONG', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2088, 'MOHAMMAD REJO BIN MUHAMMAD SOKEH (ALM)', 'BI. 318/2023', '2023-05-31', '2029-09-04', NULL, 'BA', 'BA14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2089, 'MOHAMMAD SAID BIN SARIJO', 'BI.N 214/2024', '2024-01-17', '2030-12-10', NULL, 'A', 'A5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2090, 'MOHAMMAD ZAINAL FANANI BIN ZAINURI', 'BI.N 055/2025', '2024-03-26', '2030-09-06', 'CAKNAN', 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2091, 'MUCHAMAD ADAM AFRIZAL BIN MULYADI', 'BI.N 302/2025', '2025-09-04', '2032-02-07', NULL, 'C', 'C1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2092, 'MUCHAMAD AMIQ ABDILLAH BIN NUR CHOLIS', 'BI. 214/2023', '2022-10-19', '2029-08-18', 'AMIQ', 'BA', 'BA6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2093, 'MUCHAMAD ANTOK BIN SAMIAN', 'AIVN.070/2025', '2025-05-16', '2026-02-25', NULL, 'C', 'C8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2094, 'MUCHAMAD FAJAR BIN ZAINUL ARIFIN', 'AI.N 336/2025', '2025-10-30', '2026-01-19', NULL, 'A', 'A9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2095, 'MUCHAMAD ROBI BIN NUR KODIM (ALM)', 'AI.N 349/2025', '2025-11-18', '2026-01-22', 'BOY', '-', '-', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2096, 'MUCHAMMAD ABDUL HAFIDHZ AL ASYARI BIN ARIF SANTOSO (ALM)', 'BI.N 226/2023', '2022-09-28', '2028-07-22', 'ASYARI', 'D', 'D3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2097, 'MUCHLAS HIDAYAH BIN MAULAN', 'BI.N 185/2025', '2024-08-21', '2027-03-21', 'GERANDONG', 'BA', 'BA5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2098, 'MUFID KHOIRON BIN SUPARMAN (ALM)', 'BI.N 164/2024', '2023-07-04', '2027-08-26', NULL, 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2099, 'MUHAMAD EKO PUTRA ADI SUSANTO BIN SULIMIN', 'AV.N 018/2025', '2025-01-30', '2026-03-21', 'CURUT', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2100, 'MUHAMAD HERI SETIAWAN BIN WAIDI', 'BI.N 242/2025', '2024-09-24', '2027-07-13', NULL, 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2101, 'MUHAMAD RIZAL BIN DIUN', 'BI.N 223/2025', '2025-01-30', '2026-06-23', 'RIZAL', 'C', 'C14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2102, 'MUHAMAD ROMLI BIN ADI', 'AIIIN. 349/2025', '2025-08-26', '2026-03-01', NULL, 'A', 'A4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2103, 'MUHAMMAD ABDI YUNUS BIN USMAN', 'BI.N 567/2023', '2023-01-18', '2028-11-11', 'GANDEN', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2104, 'MUHAMMAD AGUNG SUBEKTI ARI HARTADI BIN MULJADI', 'AI. 341/2025', '2025-10-30', '2026-01-11', 'AGUNG', 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2105, 'MUHAMMAD AGUS JAMALUDIN BIN SUWITO (ALM)', 'AIV.N 082/2025', '2025-06-24', '2026-02-10', 'BAGUS', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2106, 'MUHAMMAD ALI MANSYUR BIN MUHAMMAD SYAFII', 'AI.N 393/2025', '2025-12-23', '2026-01-25', 'KLOPO', 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2107, 'MUHAMMAD ALI SHOFYAN BIN ABU HARI', 'BI.N 431/2022', '2022-07-11', '2027-09-20', 'FIYAN', 'D', 'D3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2108, 'MUHAMMAD AMAN BIN ABDUL MALIK', 'BI.N 315/2022', '2021-12-07', '2029-09-22', 'TOLET', 'BA', 'BA6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2109, 'MUHAMMAD ANDRI BIN MUNARI', 'BI.n 058/2021', '2020-07-15', '2026-07-09', 'TUBI', 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2110, 'MUHAMMAD ANGGA SETIA ABADI BIN AGUS ZAINAL', 'AVN. 026/2025', '2025-03-17', '2026-05-16', NULL, 'C', 'C10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2111, 'MUHAMMAD ANSHORI BIN SUTRISNO', 'AIII. 313/2025', '2025-08-31', '2026-01-19', NULL, 'D', 'D3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2112, 'MUHAMMAD ARIF KHOIRUL HAKIM BIN CHUSNAN', 'BI.N 226/2025', '2024-10-22', '2029-04-29', 'NDAREP', 'A', 'A13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2113, 'MUHAMMAD BAGUS BASORI BIN MACHFUD', 'BIIa. 106/2025', '2025-04-17', '2026-01-01', 'GENTONG', 'BA', 'BA12', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2114, 'MUHAMMAD DAFALA BIN USAMAH', 'BI.N 527/2023', '2023-11-03', '2029-08-14', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2115, 'MUHAMMAD DENI TEGUH FIRMANSYAH BIN PURNOMO', 'BI. 246/2025', '2025-03-25', '2035-03-17', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2116, 'MUHAMMAD EFAN ADITIYA BIN DAMIN', 'BI. 288/2025', '2025-02-25', '2031-01-16', 'ADIT', 'BA', 'BA14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2117, 'MUHAMMAD FATICHUL ILMI BIN SYAIFUL ANWAR', 'BI. 219/2024', '2024-05-27', '2033-11-22', 'FATIC', 'BA', 'BA8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2118, 'MUHAMMAD FATKUR SLAMET BIN SUJONO', 'BI.N 093/2025', '2024-10-22', '2031-02-16', 'JONET', 'C', 'C10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2119, 'MUHAMMAD FERI FADLI BIN MU\'ID', 'BIIa. 112/2025', '2025-08-31', '2026-08-12', NULL, 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2120, 'MUHAMMAD FERY DARMAWAN BIN ABDUL WAKIT', 'BI.N 119/2024', '2023-12-12', '2029-10-30', NULL, 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2121, 'MUHAMMAD FIKRI HAIKAL SETIAWAN BIN HERU SETIAWAN', 'BI. 570/2023', '2023-07-04', '2027-09-01', 'MONDI', 'BA', 'BA6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2122, 'MUHAMMAD HASAN BASALAMAH BIN HASAN (ALM)', 'AI.N 328/2025', '2025-10-30', '2026-01-04', 'MAMED', 'C', 'C5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2123, 'MUHAMMAD HASAN FADELI BIN ASMARI', 'BI.N 171/2025', '2025-06-26', '2028-07-02', 'FAFA', 'D', 'D1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2124, 'MUHAMMAD HUSNI AFIFFUDDIN BIN MUHAMMAD ALIUDIN', 'BI. 270/2025', '2025-03-25', '2026-07-01', 'AFIF', 'A', 'A13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2125, 'MUHAMMAD IHWAN FAUZI BIN ABDUL MALIK', 'BI.N 040/2025', '2024-05-27', '2030-09-07', 'WAWAN', 'C', 'C6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2126, 'MUHAMMAD IMRON MAULANA BIN SARTO', 'AIIIN. 298/2025', '2025-05-16', '2026-01-04', 'NYAMBEK', 'C', 'C2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2127, 'MUHAMMAD KALAM BIN BADRI (ALM)', 'BI.N 135/2024', '2024-03-06', '2028-06-03', 'MBEM', 'C', 'C1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2128, 'MUHAMMAD LUSMIYADI BIN MUCHSIN', 'AIII. 357/2025', '2025-10-14', '2026-03-05', NULL, 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2129, 'MUHAMMAD RIFO ARIFIANTO BIN ARIF YANTO', 'BI.N 170/2023', '2022-09-14', '2026-12-07', 'AMBON', 'C', 'C3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2130, 'MUHAMMAD RIZQI MUBAROK BIN ZAINAL ARIFIN', 'BI. 208/2025', '2025-02-25', '2031-10-14', 'RIZKI', 'BA', 'BA14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2131, 'MUHAMMAD ROZAQ BIN MAT PALAL', 'AIIN. 360/2025', '2025-08-31', '2026-01-30', 'ROJAK', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2132, 'MUHAMMAD SHOLAKHUDIN BIN PONAJI', 'BI. 190/2023', '2022-09-28', '2034-07-20', NULL, 'BA', 'BA13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2133, 'MUHAMMAD SOBIRIN BIN ABDUL ALAWI', 'BI. 125/2025', '2025-06-10', '2028-12-03', NULL, 'BA', 'BA5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2134, 'MUHAMMAD SULTON BIN ABU YAZID BASTOMI (ALM)', 'BI. 098/2025', '2024-07-08', '2030-01-10', NULL, 'BA', 'BA8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2135, 'MUHAMMAD SURIPTO BIN SURIPTO', 'BI. 121/2025', '2025-06-10', '2026-09-08', NULL, 'BA', 'BA1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2136, 'MUHAMMAD SYIFA BIN ZULKIFLI ARIEF', 'BI.N 344/2022', '2022-05-19', '2027-01-14', 'PAUL', 'C', 'C3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2137, 'MUHAMMAD TAQYUDDIN BIN M HUSNAN (ALM)', 'BI.N 047/2023', '2023-01-19', '2029-07-19', 'CAK YUD', 'BA', 'BA6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2138, 'MUHAMMAD ZAMRONI BIN MUSLIM', 'BI. 244/2025', '2025-03-17', '2026-06-27', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2139, 'MUHARWANDA AL FARUQI BIN SUKARDI', 'BI.N 189/2024', '2024-04-05', '2028-03-24', NULL, 'C', 'C9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2140, 'MUJAHIDIN BIN SUTIK', 'BI.N 143/2024', '2023-10-20', '2029-08-14', 'BOWO', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2141, 'MUJIANTO BIN RADI', 'BI.N 312/2025', '2025-02-11', '2030-05-20', 'METENG', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2142, 'MUJIONO BIN MIAN', 'AIII. 360/2025', '2025-10-14', '2026-03-09', 'PYEK', 'A', 'A3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2143, 'MUKAMMAD SADDIKIN BIN KARIMAN', 'BI.N 050/2025', '2024-09-24', '2033-01-27', 'SODIK', 'A', 'A4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2144, 'MUKHAMAD AMALUDIN BIN KUSNADI', 'BI.N 213/2025', '2024-09-11', '2027-05-10', 'UDIN', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2145, 'MUKHAMAD IQBAL ROZAKI BIN PARJIN', 'BI. 300/2025', '2025-05-16', '2031-04-17', 'JAROT', 'A', 'A6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2146, 'MUKHSON HABIB BIN WAJIB', 'AV.N 011/2025', '2025-01-30', '2026-02-25', NULL, 'A', 'A6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2147, 'MULYONO CONY BIN CORNELIS CONY', 'BI. 134/2025', '2025-06-10', '2026-06-25', NULL, 'D', 'D5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2148, 'MUSA BIN NURUL HAKIM', 'BIII.sN 109/2025', '2022-10-18', '2027-07-29', NULL, 'C', 'C4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2149, 'MUSLIMIN BIN SETU', 'AI. 386/2025', '2025-12-23', '2026-02-04', NULL, 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2150, 'MUSTIKA AYU BINTI MUSTOFA', 'AV.P 001/2025', '2025-01-30', '2026-03-20', NULL, 'WANITA', '1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2151, 'MUZAKKI ABDAIN BIN MUHAMAD SHOLIKIN', 'AIIN. 373/2025', '2025-08-31', '2026-01-13', NULL, 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2152, 'NAILAL BIN KHOLIL BIN KHOLIL', 'AIII. 336/2025', '2025-10-14', '2026-02-18', NULL, 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2153, 'NANANG ISWAHYUDI BIN SUGATI', 'AIII. 362/2025', '2025-10-14', '2026-03-10', NULL, 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2154, 'NANANG SETYADI BIN JUDIN (ALM)', 'BI.N 205/2024', '2024-04-09', '2031-04-25', 'OLENG', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2155, 'NANDA PUTRA ARIF BIN MUHAMMAD ARIF', 'BIIa. 111/2025', '2025-06-04', '2026-05-23', NULL, 'A', 'A4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2156, 'NATHAN PUTRA DWIVAN BIN IVAN YUARTA', 'AI.N 330/2025', '2025-10-30', '2026-01-08', NULL, 'A', 'A6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2157, 'NOOFRIANDI ARIFIN BIN TRIMAN SUPRIYADI', 'BI.N 468/2023', '2023-09-12', '2028-05-03', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2158, 'NOVA DWI PANDEGA BIN BAMBANG', 'AI.N 301/2025', '2025-10-14', '2026-01-14', 'GAMBER', 'A', 'A3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2159, 'NOVIRA INDRAYANI BINTI YARSAN', 'AIIP. 020/2025', '2025-10-30', '2026-01-08', NULL, 'WANITA', '2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2160, 'NUR ALI BIN UNTUNG', 'BI.N 070/2024', '2023-07-04', '2029-11-23', 'KAMID', 'BA', 'BA8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2161, 'NUR ANDIK BIN MUNADJI', 'BI.N 216/2024', '2024-03-06', '2031-05-30', 'PENDEK', 'C', 'C3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2162, 'NUR ROZIHUL FAUZAN BIN TAUCHID', 'BI.N 272/2025', '2025-07-10', '2033-04-14', 'JUSUK', 'A', 'A14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2163, 'NURA KURNIAWAN BIN SUNGKONO', 'AIII. 320/2025', '2025-06-24', '2026-01-25', NULL, 'A', 'A6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2164, 'NURAFIF BIN FADELAN', 'BI.N 051/2025', '2024-09-24', '2031-05-07', 'APIP', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2165, 'NURCHOLIS BIN MUNALI', 'BI.N 575/2023', '2023-12-19', '2028-12-05', 'KACONK', 'D', 'D4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2166, 'NURIL ANWAR BIN GUNARTO', 'AIVN. 069/2025', '2025-05-16', '2026-02-17', 'NURIL', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2167, 'NURY MOCHAMAD YUSUF BIN NUR EDI', 'BI.N 246/2023', '2022-11-14', '2026-07-01', 'RACUN', 'C', 'C14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2168, 'OFI MIFTAHUDIN BIN KASIYANTO', 'BI. 002/2024', '2023-05-17', '2030-01-01', 'OFI', 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2169, 'OGAN YURIS VALENTINO FEBRIANSYAH BIN SUSANTO', 'AI.N 396/2025', '2025-12-23', '2026-01-27', NULL, 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2170, 'OKY LUTVIANDI BIN SUBARI', 'AI.N 368/2025', '2025-12-03', '2026-01-17', NULL, 'D', 'D4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2171, 'ONY SATYAWAN BIN SAMID', 'BI.N 048/2025', '2024-09-11', '2030-03-02', NULL, 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2172, 'OPPI MEIBRIAN SIFAK BIN SETIYO AGUNG PRIANTO', 'AIIIN. 352/2025', '2025-07-23', '2026-03-01', 'ACIL', 'C', 'C9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2173, 'OTNIEL NICO NEHEMIA BIN SLAMET', 'BI. 140/2024', '2024-01-26', '2032-05-14', 'PENDHEK', 'A', 'A6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2174, 'PAEMAN BIN JUMENAN (ALM)', 'BI.N 144/2024', '2024-01-26', '2028-05-20', NULL, 'C', 'C6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2175, 'PANDI IRJAN TAIB BIN KHOIRON', 'BI.N 005/2024', '2023-04-12', '2028-05-23', 'BENDOL', 'C', 'C17', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2176, 'PAUL SELLA ANDRIANTO BIN SUYITNO', 'BI. 072/2025', '2024-10-15', '2029-06-11', 'ANDRE', 'A', 'A5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2177, 'PERMATA SANDHI CAHYANA BIN SAMSI ADIS', 'BI. 141/2025', '2025-01-30', '2026-02-26', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2178, 'PIPIT DISTANTO BIN ABDUL MANAN (ALM)', 'BI. 285/2025', '2025-06-24', '2026-12-15', 'PIPIT', 'BA', 'BA11', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2179, 'PONCO MARDI UTOMO BIN MARGONO ATMOWIJOYO', 'AIIIK. 282/2025', '2025-07-15', '2026-02-08', 'YUUT', 'BA', 'BA4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2180, 'PONIMAN BIN SUWANI', 'AIIN. 376/2025', '2025-10-14', '2026-01-13', NULL, 'A', 'A13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2181, 'PRASETYO BUDI SANTOSO BIN AGUNG P', 'BI.N 142/2025', '2024-09-11', '2033-01-01', NULL, 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2182, 'PRIYONO BIN MUJIONO', 'BIIa. 108/2025', '2025-05-16', '2026-01-11', 'SALEHO', 'A', 'A2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2183, 'PUJIANTO BIN MULYONO', 'B.I 082/2023', '2023-01-26', '2028-12-25', NULL, 'BA', 'BA6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2184, 'PULUNG RINDAWAN AMINDAMA BIN DAYONO', 'BI.N 507/2023', '2023-01-18', '2027-11-12', NULL, 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2185, 'PUNGKI WINARDO BIN WINARKO', 'BI.N 317/2025', '2025-02-11', '2027-01-30', 'JATIL', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2186, 'PURNOMO BIN IMAM', 'AI. 382/2025', '2025-12-03', '2026-01-21', NULL, 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2187, 'PURNOMO BIN MUKSIN', 'B.I 080/2023', '2023-01-26', '2029-04-26', NULL, 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2188, 'PURNOMO BIN SLAMET (ALM)', 'AIIN. 359/2025', '2025-08-31', '2026-01-30', NULL, 'C', 'C8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2189, 'QOYYUM EFENDI BIN MAHFUD', 'BI.N 227/2022', '2021-09-01', '2028-01-18', 'PENDIK', 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2190, 'R. DADAN SURACHMAT, S.E BIN HIDAYAT SANJAYA DIPURA', 'AI. 353/2025', '2025-11-18', '2026-01-02', NULL, 'BA', 'BA3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2191, 'RACHMAD GIRAN PRAYUGO BIN WAGIRAN', 'BI.N 480/2023', '2023-09-12', '2026-05-29', 'RAHMAT BIN WAGIRAN', 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2192, 'RAFI SUGIANTO BIN SUMARDI (ALM)', 'AI.N 351/2025', '2025-11-18', '2026-01-22', NULL, 'A', 'A9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2193, 'RAHMAN SEPTIAN PRAKOSO BIN RAHMAD KUSNARYO', 'BI.N 014/2024', '2023-06-08', '2029-04-10', NULL, 'BA', 'BA2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2194, 'RAKA OBIM BAGAS SAPUTRA BIN BAGAS (ALM)', 'BI.N 278/2025', '2025-03-17', '2032-03-05', 'BAGAS', 'D', 'D5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2195, 'RATNO WIBOWO BIN KASTUR (ALM)', 'BI.N 233/2025', '2024-09-24', '2034-04-20', 'SONGKEL', 'A', 'A4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2196, 'REFAN INDRIANTO BIN PURNOMO ADI', 'AVN. 029/2025', '2025-03-25', '2026-05-21', NULL, 'C', 'C9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2197, 'RENDRA KURNIAWAN BIN ABIDIN (ALM)', 'AVN. 008/2025', '2025-02-11', '2026-03-26', 'KEMPU', 'C', 'C7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2198, 'RENGGA ADITYA PAMUNGKAS BIN WIJI NOWO SAYEKTI', 'BI.N 051/2024', '2023-10-20', '2030-10-27', 'ANGGA', 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2199, 'RENO PRIBADI BIN SUMARJI', 'AI.N 305/2025', '2025-10-14', '2026-01-29', NULL, 'D', 'D2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2200, 'REVIN NALDO AGUSTIAN NARENDRA BIN NANANG TEGUH WIYANTO', 'BI.N 191/2023', '2022-08-02', '2027-05-01', NULL, 'C', 'C9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2201, 'REYNALDI RIZAL FIRMANSYAH BIN WIJIANTO', 'BI.N 578/2023', '2023-06-08', '2029-01-12', NULL, 'BA', 'BA6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2202, 'REZA AFKAR PIRAGA BIN M GUFRON', 'BI.N 088/2025', '2024-07-08', '2031-06-04', 'AGA', 'C', 'C12', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2203, 'RICO MEGA EMERLA BIN MUHADI', 'BI.N 002/2025', '2023-10-20', '2028-01-16', NULL, 'A', 'A8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2204, 'RIDWAN CANDRA DARMAWAN BIN DADANG DARMAWAN', 'AIII. 326/2025', '2025-08-31', '2026-02-02', NULL, 'A', 'A6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2205, 'RIKO HANI PAMBUDI BIN SUWANTO', 'AI 378/2025', '2025-12-23', '2026-02-04', NULL, 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2206, 'RIO DIANSYAH AJI PRATAMA BIN SURAJI (ALM)', 'AII. 364/2025', '2025-11-18', '2026-01-08', NULL, 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2207, 'RISAL OKTANDO BIN PURNIADI', 'BI.N 217/2024', '2024-04-05', '2030-07-17', 'ATENG', 'C', 'C15', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2208, 'RIYAN SYARIF BIN ABDUR ROHMAN', 'AIII. 346/2025', '2025-10-14', '2026-02-24', NULL, 'D', 'D2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2209, 'RIYONO BIN GIMAN', 'BI.N 203/2024', '2024-05-27', '2029-11-28', 'BENJOL', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2210, 'RIZA ZAKARIA ANHAR BIN SIAMAR', 'BI.N 065/2025', '2024-12-05', '2029-07-14', NULL, 'C', 'C5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2211, 'RIZAL RAMADHAN BIN BENY HANDAYANTO', 'BI.N 310/2025', '2025-06-04', '2031-05-25', 'ICHANG', 'C', 'C11', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2212, 'RIZAL WAHYUDI BIN HAFILUDDIN', 'BI. 164/2023', '2022-08-25', '2026-06-02', 'KACONG', 'A', 'A5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2213, 'RIZKI FEBRIANTO BIN M. CHOLIQ', 'AIIIN. 307/2025', '2025-06-04', '2026-02-13', NULL, 'A', 'A13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2214, 'RIZKI FIRMANDANI BIN ARTIMAN', 'BI.N 148/2023', '2022-05-30', '2027-03-11', NULL, 'BA', 'BA5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2215, 'ROFI FIRDAUS ANWAR BIN SULAIMAN YUDI', 'AIIN. 371/2025', '2025-10-30', '2026-01-13', 'KIPIL', 'C', 'C2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2216, 'ROHMAD NUR HIDAYAT BIN WARSUDI SANTOSO', 'BI.N 268/2025', '2025-02-11', '2031-01-09', 'DAYAT', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2217, 'ROKIM BIN MIRAN', 'BI. 269/2023', '2022-09-14', '2033-06-03', NULL, 'A', 'A5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2218, 'ROMY KURNIAWAN DWIYANTO BIN SUKARLAN', 'BI. 228/2025', '2025-02-25', '2027-01-14', NULL, 'BA', 'BA8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2219, 'RONI FIRDAUS BIN DIMYATI', 'BI.N 274/2025', '2025-01-30', '2030-07-20', 'RONDO', 'D', 'D4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2220, 'ROZAQ ALDY BIN MUSAWIR', 'BI.N 064/2024', '2023-08-29', '2028-10-26', NULL, 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2221, 'RUDI HARTONO BIN KHUSNUL IMRON', 'BI.N 050/2024', '2022-12-23', '2027-11-04', NULL, 'A', 'A12', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2222, 'RUDI HARTONO BIN M. KASAN (ALM)', 'BI.N 185/2024', '2024-07-24', '2030-12-02', NULL, 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2223, 'RUDI HERWANTO ALIAS GRANDONG BIN SLAMET (ALM)', 'AI.N 306/2025', '2025-10-14', '2026-01-30', 'GERANDONG', 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2224, 'RUDI SANTOSO BIN M. URIP (ALM)', 'BI.N 099/2024', '2023-08-29', '2027-11-10', NULL, 'D', 'D2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2225, 'RUDI SETYAWAN BIN SUTRISNO', 'BI. 202/2025', '2025-03-17', '2027-03-05', 'WAWAN', 'A', 'A3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2226, 'RUKIN HARIANTO BIN SLAMET (ALM)', 'AV. 024/2025', '2025-03-25', '2026-04-15', NULL, 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2227, 'RUSMAN HADI BIN IMAM SANUSI (ALM)', 'BI.N 157/2023', '2022-10-18', '2028-11-28', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2228, 'SADDAM KURNIAWAN BIN MUKSIN', 'BI. 286/2025', '2025-06-24', '2026-09-17', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2229, 'SAFIRA PUTRI LISTIANA BINTI SULISTIONO (ALM)', 'AIIIPN. 015/2025', '2025-06-24', '2026-01-01', NULL, 'WANITA', '4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2230, 'SAIFUL ANAM BIN BUAMIN (ALM)', 'BI.N 372/2023', '2023-07-18', '2028-05-05', NULL, 'C', 'C17', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2231, 'SAIFUL ANAM BIN KASDI', 'BI. 194/2025', '2025-01-30', '2030-03-09', 'ANAM', 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2232, 'SAIFUL ANAM BIN SUPRIADI (ALM)', 'AI.N 347/2025', '2025-11-18', '2026-01-21', NULL, 'A', 'A7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2233, 'SAKUR BIN SARIYAN', 'BI. 258/2022', '2021-10-06', '2032-02-21', NULL, 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2234, 'SAMPURNO RIADIN BIN SAMPAN', 'AI. 370/2025', '2025-12-03', '2026-01-17', 'SAMPAN', 'A', 'A4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2235, 'SAMSI BIN PONAJI (ALM)', 'AIII. 331/2025', '2025-08-26', '2026-02-12', NULL, 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2236, 'SAMSUL ARIFIN BIN NGATEMIN', 'BI. 215/2019', '2019-03-11', '2032-08-01', 'SAMSUL', 'BA', 'BA8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2237, 'SAMSUL ARIFIN BIN SOLIKIN', 'BI.N 052/2024', '2023-10-20', '2034-06-11', NULL, 'BA', 'BA14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2238, 'SAMSUL HADI BIN TAMAJI', 'BI. 229/2025', '2025-02-25', '2027-12-25', NULL, 'A', 'A1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2239, 'SAMUEL DWI CHRISTANTO BIN DWI MARGONO', 'BI. 199/2024', '2024-06-24', '2028-11-10', 'GENDUT', 'A', 'A9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2240, 'SAMUJI BIN (ALM) TEGUH', 'BI.N 230/2025', '2025-01-30', '2033-10-24', 'MUJI', 'BA', 'BA5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2241, 'SANDI BIN MUSTAMIN (ALM)', 'BI. 019/2025', '2024-07-24', '2038-01-24', NULL, 'A', 'A5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2242, 'SANG BAGUS WIBOWO BIN DUKI', 'BI.N 005/2025', '2023-10-20', '2028-01-16', 'DEPE', 'C', 'C8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2243, 'SANGSANG FAISOL KADHAFI BIN SUGENG', 'BI.N 035/2025', '2024-08-12', '2030-01-31', 'DAVID', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2244, 'SAPUTRO JULIARSO BIN SIMAN', 'AI.N 366/2025', '2025-12-03', '2026-01-12', NULL, 'C', 'C8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2245, 'SATRIA FEDORA DAFFA BIN AGUNG WAHYU BHARATA', 'A.IN 300/2025', '2025-10-14', '2026-01-12', NULL, 'A', 'A14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2246, 'SEGER ALY SAHAB BIN SAKIMAN (ALM)', 'BI. 498/2023', '2022-09-14', '2035-06-11', NULL, 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2247, 'SEPTIAN DWI CAHYONO BIN BAMBANG SETIYONO', 'BI. 243/2025', '2025-03-17', '2026-10-25', 'TIAN', 'A', 'A2', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2248, 'SEPTIAN KUSUMA WARDANI BIN WARSONO', 'AI.N 363/2025', '2025-12-03', '2026-01-07', NULL, 'C', 'C12', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2249, 'SETIA YULI FARDIANTO BIN KASIANTO', 'AIIIN. 332/2025', '2025-07-23', '2026-02-15', NULL, 'A', 'A8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2250, 'SETIYO KUSPRIYONI BIN MOHAMAD KOSIM', 'BI.N 325/2023', '2023-02-01', '2031-12-12', 'CUPLIS', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2251, 'SETYO PURNOMO BIN EKO SETIAWAN (ALM)', 'AIIIN. 339/2025', '2025-07-23', '2026-02-22', 'CAKMO', 'A', 'A3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2252, 'SLAMET BIN MUSLAN', 'AV. 012/2025', '2025-03-25', '2026-01-25', 'GALITONG', 'A', 'A10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2253, 'SLAMET EFENDI BIN ISMAN', 'BI.N 503/2023', '2023-06-08', '2027-07-20', NULL, 'A', 'A9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2254, 'SLAMET HARIYANTO BIN MAT CHOIRI', 'BI.N 043/2023', '2023-01-19', '2026-11-01', NULL, 'D', 'D5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2255, 'SLAMET ZULI RIYANTO BIN SAKIRMAN', 'BI. 216/2025', '2025-04-28', '2027-04-02', 'ZULI', 'BA', 'BA4', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2256, 'SODIKUL BIN PARNO', '-BI. 152/2023', '2022-09-28', '2034-07-24', 'GEMBUS', 'BA', 'BA14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2257, 'SOLIKIN BIN SALIWON (ALM)', 'AI. 378/2025', '2025-12-03', '2026-01-25', NULL, 'A', 'A9', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2258, 'SRI WAHYUDI BIN SALI', 'BI.N 203/2025', '2025-01-09', '2029-09-08', 'KONTENG', 'C', 'C5', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2259, 'SUCIPTO BIN KASDUL (ALM)', 'BI.N 046/2024', '2023-11-29', '2028-01-22', NULL, 'C', 'C11', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2260, 'SUDIBYO BIN SUBANDIAN (ALM)', 'BI.N 057/2025', '2024-09-24', '2030-10-26', 'GUNDUL', 'C', 'C16', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2261, 'SUGENG ARIEF FIRMANSYAH BIN SUWARNO', 'AI.N 399/2025', '2025-12-23', '2026-02-03', NULL, 'D', 'D6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2262, 'SUGENG WIDODO BIN BUDIONO', 'BI.N 180/2023', '2022-05-30', '2027-03-11', 'GRANDONG', 'C', 'C13', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2263, 'SUGIAWAN SUMARSONO BIN BAMBANG BUDJIONO', 'BI.N 366/2023', '2023-07-18', '2027-11-20', NULL, 'D', 'D3', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2264, 'SUGIONO BIN SUKEM', 'BI. 305/2025', '2025-05-16', '2034-05-02', NULL, 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2265, 'SUGITO BIN SOLEH', 'BI.N 172/2025', '2024-08-12', '2028-05-15', NULL, 'C', 'C14', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2266, 'SUHARMINTO BIN SOIM', 'BI.N 042/2025', '2024-03-06', '2030-09-06', 'HARMINTO', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2267, 'SUKARDI FAN BIN UMAR FAN', 'BI. 031/2025', '2024-07-24', '2029-01-22', NULL, 'A', 'A6', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2268, 'SUKIRAN BIN MATSIRAN', 'BI. 191/2025', '2025-07-18', '2027-06-14', NULL, 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2269, 'SULAIMAN BIN PONIDI', 'BI.N 423/2022', '2022-01-18', '2027-12-12', NULL, 'A', 'A8', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2270, 'SULISTIAWAN BIN MANIRAN (ALM)', 'BI. 213/2024', '2024-12-19', '2035-10-31', NULL, 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2271, 'SUMARIONO BIN KASTAM (ALM)', 'BI. 111/2023', '2022-10-19', '2029-05-10', 'YONO', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2272, 'SUMARNO BIN KASERAN SUNARTO', 'BI. 009/2024', '2023-08-02', '2029-10-12', 'OM', 'BA', 'BA10', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2273, 'SUNYOTO BIN ABDUL ROKIM (ALM)', 'BI.N 535/2023', '2023-11-03', '2029-01-25', NULL, 'C', 'C17', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2274, 'SUNYOTO BIN PONIDI (ALM)', 'BI. 053/2025', '2024-09-24', '2027-04-30', 'TEMON', 'BA', 'BA7', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2275, 'SUNYOTO BIN TANIMAN (ALM)', 'BI. 248/2025', '2025-06-04', '2026-09-06', 'NJOTO', 'D', 'D1', '2026-01-11 01:52:19', '2026-01-11 01:52:19'),
(2276, 'SUPARDI BIN KANTUN', 'BI.N 326/2023', '2023-06-13', '2029-01-12', 'PARTENG', 'C', 'C15', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2277, 'SUPARI AGUNG BIN KARTIMAN', 'BI.N 082/2024', '2023-12-12', '2029-03-22', 'SUPEH', 'BA', 'BA8', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2278, 'SUPRAYITNO BIN MANSRAH', 'BI. 227/2025', '2025-04-17', '2026-10-08', 'NO', 'A', 'A8', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2279, 'SUPRIYONO BIN M. IKHSAN', 'AIVN. 073/2025', '2025-06-04', '2026-03-01', 'PENO', 'C', 'C10', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2280, 'SUPRIYONO BIN SAMIRIN (ALM)', 'BI.N 352/2023', '2022-12-23', '2026-10-29', 'SATE', 'C', 'C15', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2281, 'SUPRIYONO BIN SU\'EB', 'BI.N 059/2024', '2023-12-14', '2028-02-15', 'KAMPRET', 'BA', 'BA8', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2282, 'SUROTO BIN SAERI', 'BI. 291/2025', '2025-03-17', '2039-03-04', NULL, 'BA', 'BA14', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2283, 'SURYA DEWANGGA SAKTI BIN WIDI', 'BI.N 105/2025', '2025-06-05', '2026-04-11', 'DEWA', 'BA', 'BA14', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2284, 'SUTAJI BIN SUROSO', 'BI.N 370/2022', '2022-04-18', '2026-12-23', 'TAJI', 'C', 'C16', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2285, 'SUTIYO BIN KATIJO (ALM)', 'BI.N 355/2023', '2022-12-23', '2027-11-16', 'MBAH YO', 'C', 'C15', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2286, 'SUWAJI BIN MARKADI', 'AIII. 315/2025', '2025-06-24', '2026-01-21', NULL, 'A', 'A7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2287, 'SUWARNO BIN SAEMO', 'AII. 367/2025', '2025-08-31', '2026-01-11', NULL, 'A', 'A11', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2288, 'SUWARNO BIN SUPARTO', 'AI.N 369/2025', '2025-12-03', '2026-02-02', 'GOMBLOH', 'A', 'A4', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2289, 'SWANTORO BIN MISTAM (ALM)', 'AII. 369/2025', '2025-11-18', '2026-01-11', NULL, 'A', 'A9', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2290, 'SWESTYAWAN DWI SORAYA BIN SUGENG SUJIANTO (ALM)', 'BI. 290/2025', '2025-07-02', '2027-09-21', NULL, 'A', 'A7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2291, 'SYAIFUDDIN ZUHRI BIN SYAFI\'I', 'AIII. 366/2025', '2025-10-14', '2026-03-12', NULL, 'A', 'A2', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2292, 'SYAMSUL ARIFIN BIN IMAM MAHMUDI (ALM)', 'AIVN. 072/2025', '2025-06-04', '2026-02-26', 'ARIF', 'C', 'C4', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2293, 'TAKIM BIN MUSTOFA', 'BI. 176/2025', '2025-01-09', '2039-08-07', NULL, 'BA', 'BA8', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2294, 'TAMSIR BIN KALIL', 'BIIIs.N 204/2025', '2022-08-02', '2026-01-28', NULL, 'C', 'C4', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2295, 'TATA AGENDA PANJI ARUM BIN SUGENG PARIKIR', 'BI. 003/2023', '2022-06-15', '2028-03-11', NULL, 'C', 'C16', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2296, 'TATA NUGRAHA AKHLAQI BIN AINUL YAQIN', 'BIIa. 097/2025', '2025-06-24', '2026-05-30', 'KENTANG', 'BA', 'BA11', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2297, 'TAUFAN BAHARI, S.H BIN MASADI', 'AIV. 077/2025', '2025-08-26', '2026-01-10', NULL, 'A', 'A1', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2298, 'TEGUH AMINUDIN BIN M. TOHA (ALM)', 'BI.N 247/2025', '2024-09-24', '2028-07-28', NULL, 'C', 'C13', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2299, 'TEGUH HADI SANTOSA BIN SUGIONO', 'BI.N 145/2024', '2024-01-26', '2027-05-21', 'BOKIR', 'BA', 'BA7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2300, 'TIKO KUMORO BIN MARIYANTO', 'AIII. 335/2025', '2025-10-14', '2026-02-18', NULL, 'A', 'A9', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2301, 'TISNA ADI BASUKI BIN MAT ALI', 'AIIIN. 311/2025', '2025-07-23', '2026-01-19', 'MONOT', 'A', 'A1', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2302, 'TITIS PRABOWO BIN SUTRISNO', 'AII. 379/2025', '2025-11-18', '2026-01-18', NULL, 'A', 'A7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2303, 'TIYONO BIN GIMAN (ALM)', 'BI. 006/2022', '2021-06-02', '2031-07-18', NULL, 'BA', 'BA8', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2304, 'TJAHJA FADJARI, M.ENG BIN NGASNO HADI PURWANTO (ALM)', 'AIIIK. 281/2025', '2025-05-23', '2026-02-08', NULL, 'BA', 'BA4', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2305, 'TOMMY ADI SAPUTRO BIN MISNAN (ALM)', 'AI.N 346/2025', '2025-11-18', '2026-01-27', 'TOMEK', 'A', 'A9', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2306, 'TONI HANDOKO BIN SLAMET', 'BI. 200/2025', '2025-03-25', '2027-06-15', NULL, 'A', 'A10', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2307, 'TONI RISWAHYUDI BIN SOETIKNO', 'BI. 295/2023', '2023-05-25', '2028-09-01', NULL, 'C', 'C16', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2308, 'TONI WALOYO BIN (ALM) SUTAR', 'BI.N 281/2022', '2021-12-07', '2026-08-14', NULL, 'BA', 'BA14', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2309, 'TONY HARIYONO BIN PONIMAN ( ALM )', 'BI.N 311/2025', '2025-06-04', '2033-11-19', NULL, 'A', 'A11', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2310, 'TRI AGUS WULYO BIN JIUN', 'BI.N 202/2024', '2024-09-11', '2029-08-19', NULL, 'D', 'D4', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2311, 'TRI ARBI PAMUNGKAS BIN SUKIS', 'AVN. 009/2025', '2025-02-11', '2026-03-21', 'DOBOL', 'C', 'C15', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2312, 'TRIONO WISNU SAPUTRA BIN SUROSO WISNU SAPUTRO', 'BI.N 407/2023', '2023-01-18', '2026-12-01', 'KOCET', 'C', 'C14', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2313, 'TULUS CAHYO UTOMO BIN ACHMAD SISWOYO', 'BI.N 020/2025', '2024-09-11', '2032-03-02', NULL, 'C', 'C13', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2314, 'USA SUBEKTI ALIAS REMON BIN SUBEKTI', 'BI.N 230/2022', '2021-04-06', '2026-11-28', 'REMON', 'C', 'C3', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2315, 'USSOFAN BIN OSIN', 'BI.N 280/2025', '2025-04-17', '2033-04-08', 'SOFAN', 'BA', 'BA12', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2316, 'VICKY BAGUS SANTOSO BIN SUGIMAN BIN SUGIMAN', 'AIIIN. 370/2025', '2025-11-27', '2026-01-14', NULL, 'C', 'C7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2317, 'VICKY REZA PRASETYO BIN -', 'AIII. 356/2025', '2025-07-02', '2026-03-03', 'GENDUT', 'A', 'A13', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2318, 'VILBYAN AL JAFARI MUNIF BIN JUMANI MUNIF', 'AIII. 358/2025', '2025-10-30', '2026-03-05', 'ARI', 'A', 'A13', '2026-01-11 01:52:20', '2026-01-11 01:52:20');
INSERT INTO `wbps` (`id`, `nama`, `no_registrasi`, `tanggal_masuk`, `tanggal_ekspirasi`, `nama_panggilan`, `blok`, `kamar`, `created_at`, `updated_at`) VALUES
(2319, 'WAHYU HENDRA SAPUTRA BIN SUWITO', 'BI.N 279/2025', '2025-03-17', '2032-03-05', NULL, 'C', 'C14', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2320, 'WAHYU SEPTIAN ISKANDAR BIN MUSTAKIM', 'BI.N 039/2025', '2023-08-29', '2027-11-24', NULL, 'BA', 'BA11', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2321, 'WAHYUDI BIN SANEMAN', 'BI. 306/2025', '2025-08-31', '2028-03-15', 'YUDI', 'A', 'A6', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2322, 'WAKHID RAHMAT DONNY BIN SUMIKAN', 'AIIN. 368/2025', '2025-08-31', '2026-01-11', 'DANI', 'A', 'A14', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2323, 'WARSILAN BIN SANUWAR', 'BI. 500/2023', '2023-05-22', '2031-07-26', NULL, 'BA', 'BA7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2324, 'WAWAN BIN MUNARI (ALM)', 'AIIIN. 361/2025', '2025-08-31', '2026-03-09', 'GENDON', 'A', 'A10', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2325, 'WAWAN PRIBADI BIN SUBANDI', 'BI.N 092/2025', '2024-12-05', '2035-01-13', 'CIPRUT', 'A', 'A12', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2326, 'WIDARTO ADE GUNAWAN BIN SAMAD (ALM)', 'BI.N 199/2025', '2024-09-24', '2027-07-29', 'MENTES', 'BA', 'BA6', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2327, 'WIJAYA BIN KEMAN', 'BI. 314/2025', '2025-08-26', '2027-03-20', NULL, 'BA', 'BA1', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2328, 'WILLY EKO WARDANA BIN WISNU SUROSO', 'BI.N 137/2023', '2022-01-04', '2026-04-29', NULL, 'C', 'C13', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2329, 'WINDIYANTO BIN WIJIHADI SISWOTO', 'BI.N 114/2023', '2022-05-30', '2027-08-13', 'TOMPEL', 'BA', 'BA6', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2330, 'WIRA DWI PUTRANTO BIN PUJI (ALM)', 'BI.N 193/2024', '2024-04-05', '2028-03-24', 'JAMBRONG', 'C', 'C12', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2331, 'YANTO BIN WARIMIN', 'BI. 183/2025', '2025-01-09', '2028-01-16', NULL, 'BA', 'BA11', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2332, 'YATENO BIN KASUT', 'BI. 277/2025', '2025-07-02', '2026-12-21', NULL, 'A', 'A7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2333, 'YERI ANDREAWAN BIN BASUKI', 'BI.N 016/2025', '2024-09-11', '2029-10-14', 'BASUKI', 'C', 'C6', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2334, 'YOGIG AL AZHAR BIN SLAMET ARIFIN (ALM)', 'BI.N 370/2023', '2023-07-18', '2028-08-08', NULL, 'C', 'C13', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2335, 'YOKI SISWANTO BIN JUMA\'IN', 'AV.N 020/2025', '2025-02-25', '2026-03-25', 'YOKI', 'A', 'A5', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2336, 'YONGKI FERDIAN FARANDI BIN HADI SUKAREM (ALM)', 'AVN. 027/2025', '2025-03-25', '2026-05-17', NULL, 'A', 'A12', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2337, 'YUDA ADITYA PUTRA BIN JUSDI', 'BI.N 329/2023', '2023-06-13', '2027-11-28', NULL, 'A', 'A7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2338, 'YUDI ARIVIYANTO BIN H. IRFAN', 'BI.N 143/2025', '2024-11-13', '2031-07-26', 'KENTUNG', 'BA', 'BA5', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2339, 'YUNUS ANWAR BIN SUYOTO', 'BI.N 278/2022', '2022-02-04', '2027-06-21', NULL, 'BA', 'BA7', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2340, 'YUNUS FIRMANSYAH BIN ISMAIL ( ALM )', 'AI.N 364/2025', '2025-12-03', '2026-01-11', NULL, 'D', 'D2', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2341, 'YUSUF EFENDI BIN SARWANTO', 'AIIIN. 350/2025', '2025-07-23', '2026-03-01', NULL, 'A', 'A3', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2342, 'ZAENAL ARIFIN BIN SUPARMAN (ALM)', 'AV.N 019/2025', '2025-03-17', '2026-03-29', 'BOWO', 'C', 'C13', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2343, 'ZAINAL ABIDIN BIN KHUDORI', 'BI.N 182/2025', '2025-01-09', '2031-11-30', 'PITON', 'A', 'A5', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2344, 'ZAINUL ABIDIN BIN RIYADI', 'AVN. 010/2025', '2025-02-11', '2026-03-21', NULL, 'C', 'C6', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2345, 'ZAKI PUTRA WARDANA BIN SUWARNO', 'BI.N 295/2025', '2025-06-04', '2029-05-24', NULL, 'A', 'A5', '2026-01-11 01:52:20', '2026-01-11 01:52:20'),
(2346, 'ZAMANIA MUAMMAR MUBAROK BIN ACHMAD ZAINI', 'BI. 100/2025', '2025-04-09', '2026-05-24', 'AMAR GONDRONG', 'A', 'A7', '2026-01-11 01:52:20', '2026-01-11 01:52:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `kunjungans`
--
ALTER TABLE `kunjungans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kunjungans_qr_token_unique` (`qr_token`),
  ADD UNIQUE KEY `kunjungans_kode_kunjungan_unique` (`kode_kunjungan`),
  ADD UNIQUE KEY `kunjungan_unik_per_sesi` (`tanggal_kunjungan`,`sesi`,`nomor_antrian_harian`),
  ADD KEY `kunjungans_wbp_id_foreign` (`wbp_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengikuts`
--
ALTER TABLE `pengikuts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengikuts_kunjungan_id_foreign` (`kunjungan_id`);

--
-- Indeks untuk tabel `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `wbps`
--
ALTER TABLE `wbps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wbps_no_registrasi_unique` (`no_registrasi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kunjungans`
--
ALTER TABLE `kunjungans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengikuts`
--
ALTER TABLE `pengikuts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `wbps`
--
ALTER TABLE `wbps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2347;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kunjungans`
--
ALTER TABLE `kunjungans`
  ADD CONSTRAINT `kunjungans_wbp_id_foreign` FOREIGN KEY (`wbp_id`) REFERENCES `wbps` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengikuts`
--
ALTER TABLE `pengikuts`
  ADD CONSTRAINT `pengikuts_kunjungan_id_foreign` FOREIGN KEY (`kunjungan_id`) REFERENCES `kunjungans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
