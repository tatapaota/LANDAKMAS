-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql310.infinityfree.com
-- Waktu pembuatan: 20 Sep 2026 pada 19.13
-- Versi server: 11.4.13-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42618626_landakmas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `nama`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'arsiparpusda@gmail.com', '$2y$12$z76dt4iI.GHN8.nqdHMuZ.5eOVWqJ79Cqg4sBsLqvvm2IP5KgLjRG', '9cfHAVO2zQ7bH9QuG0krxap99BviM3wnrQ6i61NJgzm32Zcjmu8zxiCo70XJ', '2026-08-03 03:37:50', '2026-08-03 03:37:50'),
(5, 'bela', 'bela@gmail.com', '$2y$12$g5ZPre7BD/zWM8AtqA5xJ.G5yNkm1OtDwadLzOpCO090rc7qE3h7a', 'zDaCw5B3ceYE1FuKAt6ytMzdVhLkoDsNhGTUJbAYCjDZJVDZPIz7tUOLc5rO', '2026-08-11 21:14:52', '2026-08-11 21:14:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsips`
--

CREATE TABLE `arsips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `kode_klasifikasi` varchar(255) DEFAULT NULL,
  `nomor_arsip` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `uraian` text DEFAULT NULL,
  `uraian_lengkap` text DEFAULT NULL,
  `media` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `arsips`
--

INSERT INTO `arsips` (`id`, `instansi`, `kode_klasifikasi`, `nomor_arsip`, `tahun`, `uraian`, `uraian_lengkap`, `media`, `status`, `created_at`, `updated_at`) VALUES
(1205, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '1', '1986', 'Album peta rencana induk kota/ rencana bagian wilayah kota / rencana terperinci kota administratip Purwokerto.', 'Album peta rencana induk kota/ rencana bagian wilayah kota / rencana terperinci kota administratip Purwokerto.', NULL, 'dipinjam', '2026-08-11 21:12:28', '2026-08-12 04:16:56'),
(1254, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '412.6', '1', '1985', 'Pengiriman putusan desa tentang penggunaan Bandes tahun 1985/1986 Kecamatan Somagede 9 desa:_x000D_\nDesa Langgeran, Sokawera, Somagede_x000D_\nKlinting, Kemawi, Prasakulon Landing, Somakaton Plana tahun 1985', 'Pengiriman putusan desa tentang penggunaan Bandes tahun 1985/1986 Kecamatan Somagede 9 desa:_x000D_\nDesa Langgeran, Sokawera, Somagede_x000D_\nKlinting, Kemawi, Prasakulon Landing, Somakaton Plana tahun 1985', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1255, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '590', '2', '1985', 'Peraturan Menteri Dalam Negeri Nomor 2 tahun 1985 tekstual', 'Peraturan Menteri Dalam Negeri Nomor 2 tahun 1985 tekstual', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1256, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '590', '3', '1996/1997', 'Data harga pasar tanah taun anggaran 1996/1997 dan para camat', 'Data harga pasar tanah taun anggaran 1996/1997 dan para camat', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1257, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '591', '4', '1994', 'Keputusan Bupati tentang pembenan izin perubahan penggunaan tanah (20) tahun 1994', 'Keputusan Bupati tentang pembenan izin perubahan penggunaan tanah (20) tahun 1994', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1258, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '5', '1985', 'Izin lokasi dan pembebasan tanah untuk gedung kantor Depdikbud Kecamatan Karang Lewas Kabupaten Dati II Banyumas tahun 1985', 'Izin lokasi dan pembebasan tanah untuk gedung kantor Depdikbud Kecamatan Karang Lewas Kabupaten Dati II Banyumas tahun 1985', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1259, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '6', '1987', 'Tanag kapling Munggasari Desa Karang Salam Atas Nama Drs. Soedirman dkk tahun 1987', 'Tanag kapling Munggasari Desa Karang Salam Atas Nama Drs. Soedirman dkk tahun 1987', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1260, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '7', '1987', 'Rekomendasi perluasan tanah kampus tahun 1987', 'Rekomendasi perluasan tanah kampus tahun 1987', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1261, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '8', '1992', 'Peraturan masalah pertanahan tahun 1992 Kepres Nomor 33 tahun 1992 tata cara penanaman modal', 'Peraturan masalah pertanahan tahun 1992 Kepres Nomor 33 tahun 1992 tata cara penanaman modal', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1262, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '9', '1992', 'Penyediaan tanah untuk proyek pembangunan sarana kesehatan di Kecamatan Purwokero Barat, Cilongok, Ajibarang, Purwojati, Sumbang, dan Kemranjen tahun 1992', 'Penyediaan tanah untuk proyek pembangunan sarana kesehatan di Kecamatan Purwokero Barat, Cilongok, Ajibarang, Purwojati, Sumbang, dan Kemranjen tahun 1992', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1263, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '10', '1993', 'Tanah dan bangunan bekas yakkum di Kabupaten Banyumas tahun 1993 tekstual', 'Tanah dan bangunan bekas yakkum di Kabupaten Banyumas tahun 1993 tekstual', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1264, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '11', '1993', 'Rekomendasi penggunaan tanah untuk perumahan dinas Bank Indonesia bulan Mei tahun 1993', 'Rekomendasi penggunaan tanah untuk perumahan dinas Bank Indonesia bulan Mei tahun 1993', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1265, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '12', '1993', 'Rekomendasi penggunaan tanah untuk gedung kantor BTPN bulan Mei 1993', 'Rekomendasi penggunaan tanah untuk gedung kantor BTPN bulan Mei 1993', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1266, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '13', '1993', 'Pembebasan tanah untuk pembangunan 2 (dua) unit kompi Yonifter 405/SK terletak di Desa Klapagading Wangon dari pertanahan tahun 1993', 'Pembebasan tanah untuk pembangunan 2 (dua) unit kompi Yonifter 405/SK terletak di Desa Klapagading Wangon dari pertanahan tahun 1993', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1267, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '14', '1995', 'Izin penggunaan tanah untuk industri mesin pengolahan komponen serta converyer Atas Nama PI GIESELBERG Indonesia tahun 1995', 'Izin penggunaan tanah untuk industri mesin pengolahan komponen serta converyer Atas Nama PI GIESELBERG Indonesia tahun 1995', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1268, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '15', '1995', 'Permohonan hak pakai atas tanah negara seluas 10.828 M2 di Kelurahan Pasir Kidul, Purwokerto Barat Atas Nama Pemda tahun 1995', 'Permohonan hak pakai atas tanah negara seluas 10.828 M2 di Kelurahan Pasir Kidul, Purwokerto Barat Atas Nama Pemda tahun 1995', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1269, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '16', '1995-1997', 'Keputusan kakan pertanahan 164 pemberian izin lokasi untuk keperluan perumahan tahun 1995-1997', 'Keputusan kakan pertanahan 164 pemberian izin lokasi untuk keperluan perumahan tahun 1995-1997', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1270, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '17', '1996', 'SK Bina Marga izin penggunaan tanah jalan yang dikuasai oleh pemerintah provinsi Jawa Tengah tahun 1996', 'SK Bina Marga izin penggunaan tanah jalan yang dikuasai oleh pemerintah provinsi Jawa Tengah tahun 1996', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1271, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '18', '1996', 'Izin penggunaan tanah untuk toko onderdil dan bengkel Atas Nama Waluyo Efendi bulan September 1996', 'Izin penggunaan tanah untuk toko onderdil dan bengkel Atas Nama Waluyo Efendi bulan September 1996', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1272, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '19', '1996', 'Persetujuan penetepan lokasi pembebasan tanah untuk normalisasi Kali Gatel (satu berkas) tahun 1996', 'Persetujuan penetepan lokasi pembebasan tanah untuk normalisasi Kali Gatel (satu berkas) tahun 1996', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1273, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593', '20', '1998', 'Pembenan izin lokasi dan Kantor Pertanahan tahun 1998', 'Pembenan izin lokasi dan Kantor Pertanahan tahun 1998', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1274, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593.1', '21', '1997', 'Keputusan izin sementara pemakaian tanah pengairan Kabupaten Dati II Banyumas Dinas Pengairan tahun 1997', 'Keputusan izin sementara pemakaian tanah pengairan Kabupaten Dati II Banyumas Dinas Pengairan tahun 1997', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1275, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593.4', '22', '1984', 'Permohonan penambahan tanah untuk pengembangan S60 Purwokerto dari Kepala S60N Purwokerto tahun 1984', 'Permohonan penambahan tanah untuk pengembangan S60 Purwokerto dari Kepala S60N Purwokerto tahun 1984', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1276, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593.4', '23', '1992', 'Rekomendasi perpanjangan HGU dan pengalihan HGU atas tanah perkebunan di Desa Damakeradenan Ajibarang 1992', 'Rekomendasi perpanjangan HGU dan pengalihan HGU atas tanah perkebunan di Desa Damakeradenan Ajibarang 1992', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1277, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593.5', '24', '1989', 'Permohanan untuk memperoleh HGB Nomor 72 tanah seluas 277 M2 berdasarkan keputusan Mahkamah Agung Republik Indonesia tahun 1989', 'Permohanan untuk memperoleh HGB Nomor 72 tanah seluas 277 M2 berdasarkan keputusan Mahkamah Agung Republik Indonesia tahun 1989', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1278, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593.5', '25', '1992-1994', 'Kutipan SK pembenan HGB tahun 1992-1994', 'Kutipan SK pembenan HGB tahun 1992-1994', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1279, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593.8', '26', '1985', 'Permohanan rekomendasi penggalian tanah untuk rumah dinas karyawan Bank Dagang Negara cabang Purwokerto tahun 1985', 'Permohanan rekomendasi penggalian tanah untuk rumah dinas karyawan Bank Dagang Negara cabang Purwokerto tahun 1985', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1280, 'SEKRETARIAT DAERAH BAGIAN KETERTIBAN KABUPATEN BANYUMAS', '593.8', '27', '1989', 'Permohonan izin lokasi dan pembebasan tanah untuk rural area Perumtel Desa Klapagading, Wangon, Desa Pernandi, Cilongok, Desa Ajibarang Wetan tahun 1989', 'Permohonan izin lokasi dan pembebasan tanah untuk rural area Perumtel Desa Klapagading, Wangon, Desa Pernandi, Cilongok, Desa Ajibarang Wetan tahun 1989', NULL, 'tersedia', '2026-08-12 14:48:49', '2026-08-12 14:48:49'),
(1281, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '2', '1989', 'Album peta - Rencana Umum Tata Ruang Kota Ibukota Kecamatan Ajibarang Tahun 1989/1990 - 2009/2010 kedalaman RDTRK.', 'Album peta - Rencana Umum Tata Ruang Kota Ibukota Kecamatan Ajibarang Tahun 1989/1990 - 2009/2010 kedalaman RDTRK.', NULL, 'dipinjam', '2026-08-12 15:13:50', '2026-08-12 16:06:12'),
(1282, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '3', '1989', 'Album peta - Rencana Umum Tata Ruang Kota Ibukota Kecamatan Wangon Tahun 1989/1990 - 2009/2010 kedalaman RDTRK.', 'Album peta - Rencana Umum Tata Ruang Kota Ibukota Kecamatan Wangon Tahun 1989/1990 - 2009/2010 kedalaman RDTRK.', NULL, 'dipinjam', '2026-08-12 15:13:50', '2026-08-12 21:01:30'),
(1283, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '4', '1989', 'Album peta - Rencana Umum Tata Ruang Kota Ibukota Kecamatan Ajibarang Tahun 1989/1990 - 2009/2010 kedalaman RDTRK/RTRK.', 'Album peta - Rencana Umum Tata Ruang Kota Ibukota Kecamatan Ajibarang Tahun 1989/1990 - 2009/2010 kedalaman RDTRK/RTRK.', NULL, 'dipinjam', '2026-08-12 15:13:50', '2026-08-12 16:07:21'),
(1284, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '5', '1990', 'Album Peta Rencana Umum Tata Ruang Rencana Detail Tata Ruang Kota Ibukota Kecamatan Sokaraja Tahun 1990/1991 - 2010/2011', 'Album Peta Rencana Umum Tata Ruang Rencana Detail Tata Ruang Kota Ibukota Kecamatan Sokaraja Tahun 1990/1991 - 2010/2011', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1285, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '6', '1990', 'Album Peta Rencana Umum Tata Ruang Rencana Detail Tata Ruang Kota Ibukota Kecamatan Sumpiuh Tahun 1990/1991 - 2010/2011', 'Album Peta Rencana Umum Tata Ruang Rencana Detail Tata Ruang Kota Ibukota Kecamatan Sumpiuh Tahun 1990/1991 - 2010/2011', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1286, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '7', '1991', 'Album Peta Rencana Detail Tata Ruang Kawasan Rencana Teknik Ruang Kawasan Kawasan Wisata Baturaden Pemerintah Kabupaten Daerah Tingkat II Banyumas Tahun 1991/1992', 'Album Peta Rencana Detail Tata Ruang Kawasan Rencana Teknik Ruang Kawasan Kawasan Wisata Baturaden Pemerintah Kabupaten Daerah Tingkat II Banyumas Tahun 1991/1992', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1287, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '8', '1991', 'Album Peta Rencana Teknis Ruang Kota (RTRK) Kota Administratip Purwokerto Tahun 1991/1992 - 2011/2012', 'Album Peta Rencana Teknis Ruang Kota (RTRK) Kota Administratip Purwokerto Tahun 1991/1992 - 2011/2012', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1288, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '9', '1992', 'Peta Kesesuaian Lahan Tanaman Pangan Lahan Kering , Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas', 'Peta Kesesuaian Lahan Tanaman Pangan Lahan Kering , Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1289, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '10', '1992', 'Peta Rencana Pembagian SWP - Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas Tahun 1992.', 'Peta Rencana Pembagian SWP - Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas Tahun 1992.', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1290, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '11', '1992', 'Peta Ketinggian - Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas Tahun 1992.', 'Peta Ketinggian - Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas Tahun 1992.', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1291, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '12', '1992', 'Peta Kemiringan Lahan - Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas Tahun', 'Peta Kemiringan Lahan - Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas Tahun', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1292, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '13', '1992', 'Peta Penggunaan Tanah - Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas Tahun 1992', 'Peta Penggunaan Tanah - Rencana Umum Tata Ruang Daerah Kabupaten Daerah Tingkat II Banyumas Tahun 1992', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1293, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '14', '1992', 'Peta Neraca Sumber Daya Alam Spasial Daerah Kabupaten Dati II Banyumas', 'Peta Neraca Sumber Daya Alam Spasial Daerah Kabupaten Dati II Banyumas', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1294, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '15', '1993', 'Album Peta - Evaluasi dan Revisi Rencana Umum Tata Ruang Kota (RUTRK) Rencana Detail Tata Ruang Kota (RDTRK) Rencana Teknik Ruang Kota (RTRK) Kota Administratif Purwokerto Tahun 1993/1994 - 2003/2004', 'Album Peta - Evaluasi dan Revisi Rencana Umum Tata Ruang Kota (RUTRK) Rencana Detail Tata Ruang Kota (RDTRK) Rencana Teknik Ruang Kota (RTRK) Kota Administratif Purwokerto Tahun 1993/1994 - 2003/2004', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1295, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '16', '1993', 'Album Peta - Rencana Umum Tata Ruang Kota (RUTRK) Rencaa Detail Tata Ruang Kota (RDTRK) Rencana Teknik Ruang Kota ( RTRK ) Kota Administratif Purwokerto Tahun 1993/1994 - 2003/2004', 'Album Peta - Rencana Umum Tata Ruang Kota (RUTRK) Rencaa Detail Tata Ruang Kota (RDTRK) Rencana Teknik Ruang Kota ( RTRK ) Kota Administratif Purwokerto Tahun 1993/1994 - 2003/2004', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1296, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '17', '1994', 'Peta Tata Air - Neraca Sumber Daya Alam Spasial Daerah ( NSASD ) Kabupaten Banyumas Tahun 1994.', 'Peta Tata Air - Neraca Sumber Daya Alam Spasial Daerah ( NSASD ) Kabupaten Banyumas Tahun 1994.', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1297, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '18', '1994', 'Peta Jenis Tanah - Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1994', 'Peta Jenis Tanah - Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1994', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1298, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '19', '1994', 'Peta Kedalaman Air Tanah - Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1994', 'Peta Kedalaman Air Tanah - Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1994', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1299, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '20', '1994', 'Peta Study Daerah Resapan Kabupaten Banyumas (Geologi) - Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1994', 'Peta Study Daerah Resapan Kabupaten Banyumas (Geologi) - Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1994', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1300, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '21', '1994', 'Peta Penggunaan Tanah - Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1994', 'Peta Penggunaan Tanah - Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1994', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1301, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '22', '1994', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Kalibagor Tahun 1994/1995 - 2014/2015', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Kalibagor Tahun 1994/1995 - 2014/2015', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1302, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '23', '1994', 'Album Peta Rencana Umum Tata Ruang Kota dengan Kedalaman Rencana Detail Tata Ruang Kota Ibukota Kecamatan Tambak Kabupaten Daerah Tingkat II Banyumas Provinsi Daerah Tingkat I Jawa Tengah Tahun 1994/1995 - 2014/2015', 'Album Peta Rencana Umum Tata Ruang Kota dengan Kedalaman Rencana Detail Tata Ruang Kota Ibukota Kecamatan Tambak Kabupaten Daerah Tingkat II Banyumas Provinsi Daerah Tingkat I Jawa Tengah Tahun 1994/1995 - 2014/2015', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1303, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '24', '1994', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Jatilawang Tahun 1994/1995 - 2014/2015', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Jatilawang Tahun 1994/1995 - 2014/2015', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1304, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '25', '1995', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Kedungbanteng Tahun 1995/1996 - 2015/2016', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Kedungbanteng Tahun 1995/1996 - 2015/2016', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50');
INSERT INTO `arsips` (`id`, `instansi`, `kode_klasifikasi`, `nomor_arsip`, `tahun`, `uraian`, `uraian_lengkap`, `media`, `status`, `created_at`, `updated_at`) VALUES
(1305, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '26', '1995', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Patikraja Tahun 1995/1996 - 2015/2017', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Patikraja Tahun 1995/1996 - 2015/2017', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1306, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '27', '1995', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Kembaran Tahun 1995/1996 - 2015/2018', 'Album Peta Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Kembaran Tahun 1995/1996 - 2015/2018', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1307, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '28', '1995', 'Album Peta - Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Kabupaten Daerah Tingkat II Banyumas', 'Album Peta - Rencana Umum Tata Ruang Kota (RUTRK) dengan Kedalaman Rencana Detail Tata Ruang Kota (RDTRK) Kabupaten Daerah Tingkat II Banyumas', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1308, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '29', '1997', 'Peta Status Hak Tanah Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', 'Peta Status Hak Tanah Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1309, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '30', '1997', 'Peta Penggunaan Lahan Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', 'Peta Penggunaan Lahan Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', NULL, 'tersedia', '2026-08-12 15:13:50', '2026-08-12 15:13:50'),
(1310, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '31', '1997', 'Peta Pengelolaan Hutan Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', 'Peta Pengelolaan Hutan Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1311, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '32', '1997', 'Peta Curah Hujan Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', 'Peta Curah Hujan Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1312, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '33', '1997', 'Peta Penggunaan Lahan Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', 'Peta Penggunaan Lahan Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1313, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '34', '1997', 'Peta Potensi Galian C Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', 'Peta Potensi Galian C Kabupaten Banyumas Neraca Sumber Daya Alam Spasial Daerah (NSASD) Kabupaten Banyumas Tahun 1997', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1314, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '35', '1998', 'Rencana Detail Tata Ruang Sub Wilayah Pembangunan (SWP) IV Kabupaten Dati II Banyumas Tahun 1998/1999 - 2008/2009 - Album Peta', 'Rencana Detail Tata Ruang Sub Wilayah Pembangunan (SWP) IV Kabupaten Dati II Banyumas Tahun 1998/1999 - 2008/2009 - Album Peta', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1315, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '36', '2000', 'Evaluasi dan Revisi Rencana Umum Tata Ruang Kota (RUTRK) Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Wangon Tahun 2000 - 2010 - Album Peta', 'Evaluasi dan Revisi Rencana Umum Tata Ruang Kota (RUTRK) Rencana Detail Tata Ruang Kota (RDTRK) Ibukota Kecamatan Wangon Tahun 2000 - 2010 - Album Peta', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1316, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '37', '2005', 'Album Peta Rencana Tata Ruang Wilayah Kabupaten Banyumas Provinsi Jawa Tengah Tahun 2005 - 2015', 'Album Peta Rencana Tata Ruang Wilayah Kabupaten Banyumas Provinsi Jawa Tengah Tahun 2005 - 2015', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1317, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '38', '2005', 'Album Peta Rencana Tata Ruang Wilayah Kabupaten Banyumas Provinsi Jawa Tengah Tahun 2005 - 2015 ukuran A0', 'Album Peta Rencana Tata Ruang Wilayah Kabupaten Banyumas Provinsi Jawa Tengah Tahun 2005 - 2015 ukuran A0', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1318, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '39', '2008', 'Album Peta Rencana Rinci Tata Ruang Kawasan Perkotaam Purwokerto BWK V dan VI', 'Album Peta Rencana Rinci Tata Ruang Kawasan Perkotaam Purwokerto BWK V dan VI', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1319, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '40', '2008', 'Album Peta - Rencana Tata Ruang Wilayah Kabupaten Banyumas Tahun 2008 - 2027', 'Album Peta - Rencana Tata Ruang Wilayah Kabupaten Banyumas Tahun 2008 - 2027', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1320, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '41', '2011', 'Peta Pola Ruang Kabupaten Bnayumas RT RW Kabupaten Banyumas 2011 - 2031', 'Peta Pola Ruang Kabupaten Bnayumas RT RW Kabupaten Banyumas 2011 - 2031', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1321, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '42', '2012', 'Album Peta Penyusunan Rencana Detail Tata Ruang (RDTR) Kawasan Wisata Baturaden 2012 - 2023 Tahun Anggaran 2012', 'Album Peta Penyusunan Rencana Detail Tata Ruang (RDTR) Kawasan Wisata Baturaden 2012 - 2023 Tahun Anggaran 2012', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1322, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '43', '2012', 'Album Peta Rencana Pembangunan dan Pengembangan Perumahan dan Kawasan Permukiman ( RP3KP ) Kabupaten Banyumas', 'Album Peta Rencana Pembangunan dan Pengembangan Perumahan dan Kawasan Permukiman ( RP3KP ) Kabupaten Banyumas', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1323, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '44', '2017', 'Peta NKRI', 'Peta NKRI', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1324, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '45', '-', 'Album Peta Perencanaan Revitalisasi Kawasan Kota Lama Banyumas', 'Album Peta Perencanaan Revitalisasi Kawasan Kota Lama Banyumas', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1325, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '46', '-', 'Penyusunan Dokumen Inventarisasi Lahan Pertanian Pangan Berkelanjutan dan Rencana Pengembangan Infrastruktur Irigasi di Kabupaten Banyumas- Album Peta', 'Penyusunan Dokumen Inventarisasi Lahan Pertanian Pangan Berkelanjutan dan Rencana Pengembangan Infrastruktur Irigasi di Kabupaten Banyumas- Album Peta', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1326, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '47', '-', 'Peta Hidrogeologi Kecamatan Purwojati dan sekitarnya Kabupaten Bnayumas Provinsi Jawa Tengah', 'Peta Hidrogeologi Kecamatan Purwojati dan sekitarnya Kabupaten Bnayumas Provinsi Jawa Tengah', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1327, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '48', '-', 'Peta Administrasi Kabupaten Banyumas ( RB 1 : 75000 )', 'Peta Administrasi Kabupaten Banyumas ( RB 1 : 75000 )', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1328, 'BAPPEDALITBANG KABUPATEN BANYUMAS', '050', '49', '-', 'Peta Hidrogeologi Kecamatan Rawalo dan ssekitarnya Kabupaten Bnayumas Provnsi Jawa Tengah', 'Peta Hidrogeologi Kecamatan Rawalo dan ssekitarnya Kabupaten Bnayumas Provnsi Jawa Tengah', NULL, 'tersedia', '2026-08-12 15:13:51', '2026-08-12 15:13:51'),
(1329, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '1', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'dipinjam', '2026-08-12 16:10:25', '2026-08-12 16:15:00'),
(1330, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '2', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'tersedia', '2026-08-12 16:10:25', '2026-08-12 16:10:25'),
(1331, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '3', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'tersedia', '2026-08-12 16:10:25', '2026-08-12 16:10:25'),
(1332, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '4', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'tersedia', '2026-08-12 16:10:25', '2026-08-12 16:10:25'),
(1333, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '5', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'tersedia', '2026-08-12 16:10:25', '2026-08-12 16:10:25'),
(1334, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '6', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'tersedia', '2026-08-12 16:10:25', '2026-08-12 16:10:25'),
(1335, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '7', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'tersedia', '2026-08-12 16:10:25', '2026-08-12 16:10:25'),
(1336, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '8', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'tersedia', '2026-08-12 16:10:25', '2026-08-12 16:10:25'),
(1337, 'KOMISI PEMILIHAN UMUM KABUPATEN BANYUMAS', '270', '9', '2003', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', 'Daftar peta daerah pemilihan anggota DPR RI DPRD Provinsi Jawa Tengah dan DPRD Kabupaten Kota se Jawa Tengah, Komisi Pemilihan Umum Provinsi Jawa Tengah Semarang 2003.', NULL, 'tersedia', '2026-08-12 16:10:25', '2026-08-12 16:10:25'),
(1338, 'KANTOR BP7 KABUPATEN BANYUMAS', '012', '1', '1998', 'Salinan SK Bupati kali tingkat II Banyumas no 22 tahun 1998 tentang juklak pada no 12 tahun 1996 tentang pemakaian rumah dinas milik/yang di kuasai oleh pemda Banyumas tahun 1998', 'Salinan SK Bupati kali tingkat II Banyumas no 22 tahun 1998 tentang juklak pada no 12 tahun 1996 tentang pemakaian rumah dinas milik/yang di kuasai oleh pemda Banyumas tahun 1998', NULL, 'dipinjam', '2026-08-12 21:15:37', '2026-08-13 17:02:46'),
(1339, 'KANTOR BP7 KABUPATEN BANYUMAS', '050', '2', '1997', 'Program kerja BP 7 kabupaten Banyumas dalam rangka peningkatan budaya bangsa tahun 1997', 'Program kerja BP 7 kabupaten Banyumas dalam rangka peningkatan budaya bangsa tahun 1997', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1340, 'KANTOR BP7 KABUPATEN BANYUMAS', '061', '3', '1980', 'SK gubernur KDH tingkat I jateng no 8933/3109/1980 tanggal 29 april 1980 tentang pembentukan BP7 Provinsi Jawa Tengah', 'SK gubernur KDH tingkat I jateng no 8933/3109/1980 tanggal 29 april 1980 tentang pembentukan BP7 Provinsi Jawa Tengah', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1341, 'KANTOR BP7 KABUPATEN BANYUMAS', '061', '4', '1981', 'SK bupati KDH tingkat II Banyumas no 891/002/51.81 tanggal 1 januari 1981 tentang pembentukan BP7 kabupaten dati II Banyumas', 'SK bupati KDH tingkat II Banyumas no 891/002/51.81 tanggal 1 januari 1981 tentang pembentukan BP7 kabupaten dati II Banyumas', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1342, 'KANTOR BP7 KABUPATEN BANYUMAS', '061', '5', '1996', 'pembentukan kantor diklat kabupaten Banyumas berdasarkan keputusan bupati KDH tingkat II Banyumas 061/179A/1996 tanggal 7 maret 1996', 'pembentukan kantor diklat kabupaten Banyumas berdasarkan keputusan bupati KDH tingkat II Banyumas 061/179A/1996 tanggal 7 maret 1996', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1343, 'KANTOR BP7 KABUPATEN BANYUMAS', '131', '6', '1990', 'permasyarakatan P4 (Eka Prasetyo Panca Kaisa) sebagai bahan penyusunan pertanggung jawaban bupati KDH tingkat II Banyumas tahun 1990', 'permasyarakatan P4 (Eka Prasetyo Panca Kaisa) sebagai bahan penyusunan pertanggung jawaban bupati KDH tingkat II Banyumas tahun 1990', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1344, 'KANTOR BP7 KABUPATEN BANYUMAS', '188.42', '7', '1995', 'keputusan mendogri RJ no 134 tahun 1995 tentang desa / kelurahan pelopor P4', 'keputusan mendogri RJ no 134 tahun 1995 tentang desa / kelurahan pelopor P4', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1345, 'KANTOR BP7 KABUPATEN BANYUMAS', '188.45', '8', '1987', 'SK bupati Banyumas tentang penunjukan tim penyelenggara, tim pelatih, dan peserta penataran simulasi P4 bagi dosen, guru, kariyawan. Tokoh masyarakat di kabupaten Banyumas 1987/1988', 'SK bupati Banyumas tentang penunjukan tim penyelenggara, tim pelatih, dan peserta penataran simulasi P4 bagi dosen, guru, kariyawan. Tokoh masyarakat di kabupaten Banyumas 1987/1988', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1346, 'KANTOR BP7 KABUPATEN BANYUMAS', '188.45', '9', '1994', 'SK bupati KDH tingkat II banyumas tentang pembentukan panitia penyelenggara dan penata p4 pada 45 jam bagi kader di wilayah kab. Banyumas tahun 1994/1995', 'SK bupati KDH tingkat II banyumas tentang pembentukan panitia penyelenggara dan penata p4 pada 45 jam bagi kader di wilayah kab. Banyumas tahun 1994/1995', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1347, 'KANTOR BP7 KABUPATEN BANYUMAS', '188.45', '10', '1994', 'keputusan bupati banyumas no 800/102/1994 tanggal 2 september 1994 uji coba 5 hari kerja bagi PNS di lingkungan kab. Banyumas tahun 1994', 'keputusan bupati banyumas no 800/102/1994 tanggal 2 september 1994 uji coba 5 hari kerja bagi PNS di lingkungan kab. Banyumas tahun 1994', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1348, 'KANTOR BP7 KABUPATEN BANYUMAS', '188.52', '11', '1989', 'intruksi mendogri RJ no 15 tahun 1989 tentang penyelenggaraan P4 di daerah seluruh indonesia tahun 1989/1990', 'intruksi mendogri RJ no 15 tahun 1989 tentang penyelenggaraan P4 di daerah seluruh indonesia tahun 1989/1990', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1349, 'KANTOR BP7 KABUPATEN BANYUMAS', '188.52', '12', '1992', 'Instruksi mendagri RJ No 6 tahun 1992 tanggal 17 maret 1992 tentang pelaksanan penataran p4 di daerah seluruh indonesia tahun 1992/1993', 'Instruksi mendagri RJ No 6 tahun 1992 tanggal 17 maret 1992 tentang pelaksanan penataran p4 di daerah seluruh indonesia tahun 1992/1993', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1350, 'KANTOR BP7 KABUPATEN BANYUMAS', '318.45', '13', '1988', 'SK Bupati Banyumas tentang pembentukan panitia penyelenggara P4 pola 25 jam bagi karyawan/dinas instansi vertikal di Kabupaten Banyumas tahun 1988/1999', 'SK Bupati Banyumas tentang pembentukan panitia penyelenggara P4 pola 25 jam bagi karyawan/dinas instansi vertikal di Kabupaten Banyumas tahun 1988/1999', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1351, 'KANTOR BP7 KABUPATEN BANYUMAS', '556', '14', '1990', 'Surat edaran gubernur KDH TK II Jateng no 556/020368 tanggal 15 mei 1990 tentang gerakan pelaksanaan sapta pesona', 'Surat edaran gubernur KDH TK II Jateng no 556/020368 tanggal 15 mei 1990 tentang gerakan pelaksanaan sapta pesona', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1352, 'KANTOR BP7 KABUPATEN BANYUMAS', '556', '15', '1997', 'SK Bupati KDH tingkat II banyumas no 556.i/1449/97 taggal 20 november 1997 tentang uji coba kedua operasional objek wisata bendung gerak serayu kec. Rawalo kab. Dati II Banyumas', 'SK Bupati KDH tingkat II banyumas no 556.i/1449/97 taggal 20 november 1997 tentang uji coba kedua operasional objek wisata bendung gerak serayu kec. Rawalo kab. Dati II Banyumas', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1353, 'KANTOR BP7 KABUPATEN BANYUMAS', '593', '16', '1994', 'SK bupati KDH tingat II banyumas no 593/1377/1994 tanggal 18 november 1994 tentang pembentukan tim koordinasi penertiban tanah wakaf di kab. Banyumas', 'SK bupati KDH tingat II banyumas no 593/1377/1994 tanggal 18 november 1994 tentang pembentukan tim koordinasi penertiban tanah wakaf di kab. Banyumas', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1354, 'KANTOR BP7 KABUPATEN BANYUMAS', '720', '17', '1987', 'laporan hasil pemeriksaan (LHP) reguler bidang pembinaan sospol di kab. Banyumas tahun 1987', 'laporan hasil pemeriksaan (LHP) reguler bidang pembinaan sospol di kab. Banyumas tahun 1987', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1355, 'KANTOR BP7 KABUPATEN BANYUMAS', '914', '18', '1996', 'uraian SK Bupati Kabupaten Banyumas tentang pengesahan Dipda BP7 Kabupaten Banyumas tahun 1996/1997', 'uraian SK Bupati Kabupaten Banyumas tentang pengesahan Dipda BP7 Kabupaten Banyumas tahun 1996/1997', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37');
INSERT INTO `arsips` (`id`, `instansi`, `kode_klasifikasi`, `nomor_arsip`, `tahun`, `uraian`, `uraian_lengkap`, `media`, `status`, `created_at`, `updated_at`) VALUES
(1356, 'KANTOR BP7 KABUPATEN BANYUMAS', '914', '19', '1997', 'DIKDA untuk BP 7 kab. Banyumas beserta perubahanya tahun anggaran 1997/1998', 'DIKDA untuk BP 7 kab. Banyumas beserta perubahanya tahun anggaran 1997/1998', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1357, 'KANTOR BP7 KABUPATEN BANYUMAS', '914', '20', '1998', 'DIKDA  perubahan untuk BP 7 kab. Dati II banyumas tahun anggaran 1998/1999', 'DIKDA  perubahan untuk BP 7 kab. Dati II banyumas tahun anggaran 1998/1999', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1358, 'KANTOR BP7 KABUPATEN BANYUMAS', '914', '21', '1998', 'DIKDA untuk BP 7 kab. Dati II banyumas tahun anggaran 1998/1999', 'DIKDA untuk BP 7 kab. Dati II banyumas tahun anggaran 1998/1999', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1359, 'KANTOR BP7 KABUPATEN BANYUMAS', '915', '22', '1994', 'pengesahan dibda untuk BP 7 kab. Banyumas (bend. Suijinah s.) tahun anggaran 1994/1995', 'pengesahan dibda untuk BP 7 kab. Banyumas (bend. Suijinah s.) tahun anggaran 1994/1995', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1360, 'KANTOR BP7 KABUPATEN BANYUMAS', '915', '23', '1995', 'Keputusan Bupati Banyumas tentang pengesahan Dipda BP7 kabupaten Banyumas beserta perubahannya tahun anggaran 1995/1996', 'Keputusan Bupati Banyumas tentang pengesahan Dipda BP7 kabupaten Banyumas beserta perubahannya tahun anggaran 1995/1996', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1361, 'KANTOR BP7 KABUPATEN BANYUMAS', '915', '24', '1996', 'pengesahan dipda dan perubahanya untuk BP 7 kabupaten banyumas (bend. Suijinah S.) tahun anggaran 1996 / 1997', 'pengesahan dipda dan perubahanya untuk BP 7 kabupaten banyumas (bend. Suijinah S.) tahun anggaran 1996 / 1997', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1362, 'KANTOR BP7 KABUPATEN BANYUMAS', '915', '25', '1996', 'Keputusan Bupati Banyumas tentang pengesahan Dipda BP7 kabupaten Banyumas (bend suijinah S. ) tahun anggaran 1996/1997', 'Keputusan Bupati Banyumas tentang pengesahan Dipda BP7 kabupaten Banyumas (bend suijinah S. ) tahun anggaran 1996/1997', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1363, 'KANTOR BP7 KABUPATEN BANYUMAS', '915', '26', '1997', 'keputusan bupati banyumas tentang pengesahan dibda BP 7 kabupaten banyumas beserta perubahanya tahun anggaran 1997/1998', 'keputusan bupati banyumas tentang pengesahan dibda BP 7 kabupaten banyumas beserta perubahanya tahun anggaran 1997/1998', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1364, 'KANTOR BP7 KABUPATEN BANYUMAS', '915', '27', '1997', 'pengesahan dibda dan perubahanya untuk BP 7 kab. Banyumas (bend suijinah s.) tahun anggaran 1997/1998', 'pengesahan dibda dan perubahanya untuk BP 7 kab. Banyumas (bend suijinah s.) tahun anggaran 1997/1998', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1365, 'KANTOR BP7 KABUPATEN BANYUMAS', '915', '28', '1998', 'SK Bupati Banyumas tentang pengesahan dibda BP 7 kab. Banyumas tahun anggaran 1998/1999', 'SK Bupati Banyumas tentang pengesahan dibda BP 7 kab. Banyumas tahun anggaran 1998/1999', NULL, 'tersedia', '2026-08-12 21:15:37', '2026-08-12 21:15:37'),
(1366, 'KABUPATEN BANYUMAS', '025', '1', '2007', 'Jurnal edaran tentang pemakaian seragam dinas dan kelengkapannya bulan Februari 2007', 'Jurnal edaran tentang pemakaian seragam dinas dan kelengkapannya bulan Februari 2007', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-09-14 17:03:25'),
(1367, 'KABUPATEN BANYUMAS', '050', '2', '1991', 'SK Bupati KDH th II Banyumas tentang prosedur tetap mekanisme perencanaan pembangunan dan bawah di Kabupaten Dati II Banyumas tanggal 23 November 1991', 'SK Bupati KDH th II Banyumas tentang prosedur tetap mekanisme perencanaan pembangunan dan bawah di Kabupaten Dati II Banyumas tanggal 23 November 1991', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-09-14 16:28:52'),
(1368, 'KABUPATEN BANYUMAS', '060', '3', '2001', 'Usulan pembentukan pelaksanaan teknis Dinas (UPTD) obyek wisata Januari Tahun 2001', 'Usulan pembentukan pelaksanaan teknis Dinas (UPTD) obyek wisata Januari Tahun 2001', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1369, 'KABUPATEN BANYUMAS', '061', '4', '2005', 'Surat edaran Sekda banyumas tentang ketentuan kop Surat bupati Banyumas  dan ketentuan penandatanganan naskah dinas keluar daerah mei 2005 dan juli 2007', 'Surat edaran Sekda banyumas tentang ketentuan kop Surat bupati Banyumas  dan ketentuan penandatanganan naskah dinas keluar daerah mei 2005 dan juli 2007', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1370, 'KABUPATEN BANYUMAS', '061', '5', '1988', 'Turun SK Bupati Banyumas tentang jurusan  organisasi dan tata kerja lokawisata Baturaden 16 September 1988', 'Turun SK Bupati Banyumas tentang jurusan  organisasi dan tata kerja lokawisata Baturaden 16 September 1988', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1371, 'KABUPATEN BANYUMAS', '061', '6', '1995', 'Perda  Kabupaten Dati II Banyumas Nomor 30/1995 tentang organisasi dan tata kerja Dinas Pariwisata 10 Maret 1995', 'Perda  Kabupaten Dati II Banyumas Nomor 30/1995 tentang organisasi dan tata kerja Dinas Pariwisata 10 Maret 1995', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1372, 'KABUPATEN BANYUMAS', '061', '7', '2000', 'SK Bupati Banyumas_x000D_\ntentang ketentuan - ketentuan pokok uraian tugas fungsi dan tata kerja Dinas Pariwisata dan Kebudayaan Kabupaten Banyumas Tahun 2000', 'SK Bupati Banyumas_x000D_\ntentang ketentuan - ketentuan pokok uraian tugas fungsi dan tata kerja Dinas Pariwisata dan Kebudayaan Kabupaten Banyumas Tahun 2000', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1373, 'KABUPATEN BANYUMAS', '061', '8', '2001', 'Keputusan kepala dinas pariwisata dan kebudayaan Kabupaten Banyumas tentang anggota tim perencanaan program kerja dinas pariwisata dan kebudayaan Bulan Februari Tahun 2001', 'Keputusan kepala dinas pariwisata dan kebudayaan Kabupaten Banyumas tentang anggota tim perencanaan program kerja dinas pariwisata dan kebudayaan Bulan Februari Tahun 2001', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1374, 'KABUPATEN BANYUMAS', '061', '9', '2005', 'Perbub Banyumas nomer 5/2005 tentang ketentuan jam kerja dilingkungan pemkab Banyumas, tahun 1964, 1995, 2002, 2005', 'Perbub Banyumas nomer 5/2005 tentang ketentuan jam kerja dilingkungan pemkab Banyumas, tahun 1964, 1995, 2002, 2005', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1375, 'KABUPATEN BANYUMAS', '061', '10', '2005', 'Surat edaran Sekda tentang koordinasi bidang tugas para asisten sekda 14 Juli 2005', 'Surat edaran Sekda tentang koordinasi bidang tugas para asisten sekda 14 Juli 2005', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1376, 'KABUPATEN BANYUMAS', '061', '11', '2005', 'Surat edaran bupati banyumas tentang informasi birokrasi pelayanan publik 1 November 2005', 'Surat edaran bupati banyumas tentang informasi birokrasi pelayanan publik 1 November 2005', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1377, 'KABUPATEN BANYUMAS', '061.1', '12', '2000', 'Peraturan daerah Kabupaten Banyumas Nomor 23 Tahun 2000 dan Tahun 2001 tentang pembentukan susunan organisasi dan tata kerja dinas daerah Kabupaten Banyumas dan Dinas lokawisata Baturraden Kabupaten Banyumas', 'Peraturan daerah Kabupaten Banyumas Nomor 23 Tahun 2000 dan Tahun 2001 tentang pembentukan susunan organisasi dan tata kerja dinas daerah Kabupaten Banyumas dan Dinas lokawisata Baturraden Kabupaten Banyumas', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1378, 'KABUPATEN BANYUMAS', '061.2', '13', '2003', 'Surat edaran bupati banyumas tentang ketentuan apel pegawai dan absensi 9 Juni 2003', 'Surat edaran bupati banyumas tentang ketentuan apel pegawai dan absensi 9 Juni 2003', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1379, 'KABUPATEN BANYUMAS', '065.1', '14', '1998', 'SK Bupati Banyumas dan SK Kepala DISPARBUD Kabupaten Banyumas tetang prosedur pengelolaan naskah dinas tahun 1998', 'SK Bupati Banyumas dan SK Kepala DISPARBUD Kabupaten Banyumas tetang prosedur pengelolaan naskah dinas tahun 1998', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1380, 'KABUPATEN BANYUMAS', '127', '15', '1997', 'Keputusan bupati kepala daerah tingkat II Banyumas Nomor 11 Tahun 1997 tentang petunjuk pelaksanaan peraturan daerah Kabupaten DATI II Banyumas Nomor 13 Tahun 1991 tentang wewenang penyelenggaraan dan pengelolaaan sebagai urusan kepariwisataan', 'Keputusan bupati kepala daerah tingkat II Banyumas Nomor 11 Tahun 1997 tentang petunjuk pelaksanaan peraturan daerah Kabupaten DATI II Banyumas Nomor 13 Tahun 1991 tentang wewenang penyelenggaraan dan pengelolaaan sebagai urusan kepariwisataan', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1381, 'KABUPATEN BANYUMAS', '132', '16', '2003', 'SK Bupati Banyumas nomer 20 tahun 2003 tentang penjabaran tugas 2 wewenang wakil bupati 30 april 2003', 'SK Bupati Banyumas nomer 20 tahun 2003 tentang penjabaran tugas 2 wewenang wakil bupati 30 april 2003', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1382, 'KABUPATEN BANYUMAS', '172.5', '17', '2001', 'Surat-surat sekretariat DRDD Kabupaten Banyumas tentang hasil-hasil keputusan rapat dan sejenisnya 2001-2002', 'Surat-surat sekretariat DRDD Kabupaten Banyumas tentang hasil-hasil keputusan rapat dan sejenisnya 2001-2002', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1383, 'KABUPATEN BANYUMAS', '220', '18', '1994', 'Laporan pelaksanaan kegiatan temu pihak dinas pemuda Kabupaten Banyumas 26- 27 Maret 1994', 'Laporan pelaksanaan kegiatan temu pihak dinas pemuda Kabupaten Banyumas 26- 27 Maret 1994', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1384, 'KABUPATEN BANYUMAS', '236', '19', '2002', 'Surat DPC KORPRI Kabupaten Banyumas tentang: \n1. SK Pengangkatan pengurus unit KORPRI DISPARBUD Kabupaten Banyumas\n2. Sayembara pakaian seragam KORPRI\n3. SK Penetapan anggota biro konsultasi dan bantuan KORPRI Kabupaten Banyumas\nbulan Januari dan Februari 2002', 'Surat DPC KORPRI Kabupaten Banyumas tentang: \n1. SK Pengangkatan pengurus unit KORPRI DISPARBUD Kabupaten Banyumas\n2. Sayembara pakaian seragam KORPRI\n3. SK Penetapan anggota biro konsultasi dan bantuan KORPRI Kabupaten Banyumas\nbulan Januari dan Februari 2002', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1385, 'KABUPATEN BANYUMAS', '300.1', '20', '1998', 'Surat edaran dan instruksi bupati Banyumas tentang langkah nyata peningkatan peran pengawasan sesuai aspirasi reformasi dan dukungan aparat wilayah dalam menghadapi gejolak di bidang IPOLEKSOSBUDHANKAM bulan Mei dan Juni 1998', 'Surat edaran dan instruksi bupati Banyumas tentang langkah nyata peningkatan peran pengawasan sesuai aspirasi reformasi dan dukungan aparat wilayah dalam menghadapi gejolak di bidang IPOLEKSOSBUDHANKAM bulan Mei dan Juni 1998', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1386, 'KABUPATEN BANYUMAS', '300.1', '21', '2005', 'Surat edaran Sekda dan Bupati Banyumas tentang menetralitas PNS dalam Pilkada 2005 dan penciptaan situasi dan kondusif daerah dan wilayah bulan Mei sampai Juli 2005', 'Surat edaran Sekda dan Bupati Banyumas tentang menetralitas PNS dalam Pilkada 2005 dan penciptaan situasi dan kondusif daerah dan wilayah bulan Mei sampai Juli 2005', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1387, 'KABUPATEN BANYUMAS', '300.3', '22', '2003', 'Surat Bupati Banyumas tentang kewaspadaan tentang aliran Falun Gong dari RRC 21 Juni 2003', 'Surat Bupati Banyumas tentang kewaspadaan tentang aliran Falun Gong dari RRC 21 Juni 2003', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1388, 'KABUPATEN BANYUMAS', '302', '23', '1994', 'SK Bupati Banyumas penyelenggaraan 5K dan 3K pembentukan tim pemeriksa bangunan di dalam kawasan wisata Baturraden 1994 dan 1996', 'SK Bupati Banyumas penyelenggaraan 5K dan 3K pembentukan tim pemeriksa bangunan di dalam kawasan wisata Baturraden 1994 dan 1996', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1389, 'KABUPATEN BANYUMAS', '356.14', '24', '1996', 'SK Bupati Banyumas dan laporan DEKS tentang penetapan penggolongan dan klasifikasi rumah makan di Kabupaten Banyumas 1996 dan 2002', 'SK Bupati Banyumas dan laporan DEKS tentang penetapan penggolongan dan klasifikasi rumah makan di Kabupaten Banyumas 1996 dan 2002', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1390, 'KABUPATEN BANYUMAS', '476', '25', '2005', 'Surat edaran Bupati Banyumas tentang memfasilitasi pengelolaan program KB, 8 Oktober 2005', 'Surat edaran Bupati Banyumas tentang memfasilitasi pengelolaan program KB, 8 Oktober 2005', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1391, 'KABUPATEN BANYUMAS', '503', '26', '1996', 'SE dan Intruksi mendagri nomer 20 Tahun 1996 tentang penyusunan buku petuntuk pelayanan perizinan didaerah, Juli 1996', 'SE dan Intruksi mendagri nomer 20 Tahun 1996 tentang penyusunan buku petuntuk pelayanan perizinan didaerah, Juli 1996', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1392, 'KABUPATEN BANYUMAS', '503', '27', '2006', 'SK camat Purwokerto Barat tentang pembentukan tim kerja pelayanan perizinan Kecamatan Purwokerto Barat, 13 Januari 2006', 'SK camat Purwokerto Barat tentang pembentukan tim kerja pelayanan perizinan Kecamatan Purwokerto Barat, 13 Januari 2006', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1393, 'KABUPATEN BANYUMAS', '510.16', '28', '1997', 'SK bersama memperindag dan mendagri tentang penataan dan pembinaan pasar dan pertokoan  2 mei 1997', 'SK bersama memperindag dan mendagri tentang penataan dan pembinaan pasar dan pertokoan  2 mei 1997', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1394, 'KABUPATEN BANYUMAS', '546.32', '29', '2003', 'Nota Dinas_x000D_\n- Laporan hasil rapat paparan kajian pengembangan pemanfaatan energi panas bumi di Jawa Tengah, 27 Desember 2003', 'Nota Dinas_x000D_\n- Laporan hasil rapat paparan kajian pengembangan pemanfaatan energi panas bumi di Jawa Tengah, 27 Desember 2003', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1395, 'KABUPATEN BANYUMAS', '556', '30', '1989', 'SK Bupati Banyumas tentang pembentukan tim pemilikan perizinan usaha kepariwisataan di Kabupaten Banyumas 1989 - 1996', 'SK Bupati Banyumas tentang pembentukan tim pemilikan perizinan usaha kepariwisataan di Kabupaten Banyumas 1989 - 1996', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1396, 'KABUPATEN BANYUMAS', '556', '31', '2000', 'Jurnal pengusulan Drs.Pramo tentang penggantian nama Jalan Raya Baturaden menjadi Jalan Raya Kol. Poedjadi Djaring Bandajoeda dan nama Baturaden dengan double R 2000 dan 2004', 'Jurnal pengusulan Drs.Pramo tentang penggantian nama Jalan Raya Baturaden menjadi Jalan Raya Kol. Poedjadi Djaring Bandajoeda dan nama Baturaden dengan double R 2000 dan 2004', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1397, 'KABUPATEN BANYUMAS', '556', '32', '1993', 'SK Bupati Banyumas tentang petunjuk pelaksanaan perda Kabupaten Banyumas Nomor 1 Tahun 1992 tentang usaha rekreasi dan hiburan umum 22 Januari 1993', 'SK Bupati Banyumas tentang petunjuk pelaksanaan perda Kabupaten Banyumas Nomor 1 Tahun 1992 tentang usaha rekreasi dan hiburan umum 22 Januari 1993', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1398, 'KABUPATEN BANYUMAS', '556', '33', '1994', 'SK Bupati KDTI TK II Banyumas tentang _x000D_\n- Tata cara pengajuan keringanan dan pembebasan retribusi bea masuk objek wisata daerah _x000D_\n- Pembentukan tim pembina dan pengawas usaha rekreasi dan hiburan umum Februari dan Maret 1994', 'SK Bupati KDTI TK II Banyumas tentang _x000D_\n- Tata cara pengajuan keringanan dan pembebasan retribusi bea masuk objek wisata daerah _x000D_\n- Pembentukan tim pembina dan pengawas usaha rekreasi dan hiburan umum Februari dan Maret 1994', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1399, 'KABUPATEN BANYUMAS', '556', '34', '1995', 'Nota dinas tentang izin operasional dan penetapan tarif tempat pemandian air panas di lokawisata Baturraden Januari dan Februari 1995', 'Nota dinas tentang izin operasional dan penetapan tarif tempat pemandian air panas di lokawisata Baturraden Januari dan Februari 1995', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1400, 'KABUPATEN BANYUMAS', '556', '35', '1995', 'SK bupati banyumas tentang pembentukan panitia penyelenggaraan kegiatan hiburan ditempat wisata Kabupaten Banyumas 16 mei 1995', 'SK bupati banyumas tentang pembentukan panitia penyelenggaraan kegiatan hiburan ditempat wisata Kabupaten Banyumas 16 mei 1995', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1401, 'KABUPATEN BANYUMAS', '556', '36', '1999', 'SK Bupati Banyumas Nomor 156 tahun 1999 tentang jumlah dan juknis penda Kabupaten Banyumas Nomor 3 tahun 1999 tentang usaha rekreasi dan hiburan umum 31 Desember 1999', 'SK Bupati Banyumas Nomor 156 tahun 1999 tentang jumlah dan juknis penda Kabupaten Banyumas Nomor 3 tahun 1999 tentang usaha rekreasi dan hiburan umum 31 Desember 1999', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1402, 'KABUPATEN BANYUMAS', '556', '37', '2004', 'Jurnal identifikasi permasalahan renstra Barlimascakeb yang berhubugan dengan kegiatan pariwisata dan budaya Desember 2004', 'Jurnal identifikasi permasalahan renstra Barlimascakeb yang berhubugan dengan kegiatan pariwisata dan budaya Desember 2004', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1403, 'KABUPATEN BANYUMAS', '556', '38', '2004', 'Surat Gubernur Jawa Tengah upaya peningkatan daya tarik dan jasa pelayanan wisata 26 Mei 2004', 'Surat Gubernur Jawa Tengah upaya peningkatan daya tarik dan jasa pelayanan wisata 26 Mei 2004', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1404, 'KABUPATEN BANYUMAS', '556', '39', '2004', 'Matriks analisis kinerja penyelenggaraan Pemkab Banyumas untuk pariwisata dan agrowisata tahun 2004', 'Matriks analisis kinerja penyelenggaraan Pemkab Banyumas untuk pariwisata dan agrowisata tahun 2004', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1405, 'KABUPATEN BANYUMAS', '556', '40', '2005', 'Surat-surat keputusan Kepala DISPARBUD Kabupaten Banyumas yang berkaitan dengan bidang pariwisata, seni, budaya dan kebijakan instansi lainnya tahun 2005', 'Surat-surat keputusan Kepala DISPARBUD Kabupaten Banyumas yang berkaitan dengan bidang pariwisata, seni, budaya dan kebijakan instansi lainnya tahun 2005', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1406, 'KABUPATEN BANYUMAS', '556.1', '41', '1995', 'Instruksi dan SK Gubernur Jawa tengah tentang pedoman dan pengolahan objek dan daya tarik wisata daerah dalam wilayah provinsi Jawa Tengah tahun 1995', 'Instruksi dan SK Gubernur Jawa tengah tentang pedoman dan pengolahan objek dan daya tarik wisata daerah dalam wilayah provinsi Jawa Tengah tahun 1995', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1407, 'KABUPATEN BANYUMAS', '556.21', '42', '1973', 'Berkas kepenulisan dan status villa/hotel Krisna an. hak milik Drs. Pramu di Jalan Raya Baturaden Nomor 23 tahun 1973-2004', 'Berkas kepenulisan dan status villa/hotel Krisna an. hak milik Drs. Pramu di Jalan Raya Baturaden Nomor 23 tahun 1973-2004', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07');
INSERT INTO `arsips` (`id`, `instansi`, `kode_klasifikasi`, `nomor_arsip`, `tahun`, `uraian`, `uraian_lengkap`, `media`, `status`, `created_at`, `updated_at`) VALUES
(1408, 'KABUPATEN BANYUMAS', '556.22', '43', '1995', 'SK Bupati Banyumas tentang penetapan penggolongan kelas Hotel Melati di Kabupaten Banyumas 1995-1999', 'SK Bupati Banyumas tentang penetapan penggolongan kelas Hotel Melati di Kabupaten Banyumas 1995-1999', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1409, 'KABUPATEN BANYUMAS', '660.1', '44', '2002', 'Jurnal Bupati Banyumas tentang penyampaian jalinan SK Meneg LH N 8 86/2002 tentang pedoman pelaksanan upaya pengelolaan LH2 upaya bersama lawannya 28 Oktober 2002', 'Jurnal Bupati Banyumas tentang penyampaian jalinan SK Meneg LH N 8 86/2002 tentang pedoman pelaksanan upaya pengelolaan LH2 upaya bersama lawannya 28 Oktober 2002', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1410, 'KABUPATEN BANYUMAS', '660.2', '45', '1995', 'Perda Kabupaten Banyumas Nomor 38 tahun 1995 tentang kebersihan dan keramahan lingkungan 27 September 1995', 'Perda Kabupaten Banyumas Nomor 38 tahun 1995 tentang kebersihan dan keramahan lingkungan 27 September 1995', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1411, 'KABUPATEN BANYUMAS', '710', '46', '2005', 'Jurnal-jurnal edaran dari Sekda Bupati dan Depdagri tentang antisipasi tindakan KKN disipliner dan penyelewangan lainnya 2005-2007', 'Jurnal-jurnal edaran dari Sekda Bupati dan Depdagri tentang antisipasi tindakan KKN disipliner dan penyelewangan lainnya 2005-2007', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1412, 'KABUPATEN BANYUMAS', '714', '47', '2000', 'Jurnal sekda Banyumas tentang peningkatan pengawasan penyelengaraan penembahan desa 25 Mei 2000', 'Jurnal sekda Banyumas tentang peningkatan pengawasan penyelengaraan penembahan desa 25 Mei 2000', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1413, 'KABUPATEN BANYUMAS', '861.1', '48', '2002', 'Jurnal-jurnal pengusulan pegawai DISPARBUD Kabupaten Banyumas untuk memperoleh Jatya Kencana karya Satya tahun 2002', 'Jurnal-jurnal pengusulan pegawai DISPARBUD Kabupaten Banyumas untuk memperoleh Jatya Kencana karya Satya tahun 2002', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1414, 'KABUPATEN BANYUMAS', '934', '49', '1998', 'SPJ rutin Bulan April 1998', 'SPJ rutin Bulan April 1998', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1415, 'KABUPATEN BANYUMAS', '934', '50', '1998', 'SPJ rutin anggaran Deperta Bulan Januari Tahun 1998', 'SPJ rutin anggaran Deperta Bulan Januari Tahun 1998', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1416, 'KABUPATEN BANYUMAS', '934', '51', '1998', 'Buku umum khas daerah dinas pariwisata Bulan Januari 1998', 'Buku umum khas daerah dinas pariwisata Bulan Januari 1998', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1417, 'KABUPATEN BANYUMAS', '934', '52', '1998', 'SPJ rutin anggaran Bulan Februari 1998', 'SPJ rutin anggaran Bulan Februari 1998', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1418, 'KABUPATEN BANYUMAS', '934', '53', '1998', 'Penyampaian SPJ anggaran rutin Bulan Februari 1998', 'Penyampaian SPJ anggaran rutin Bulan Februari 1998', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07'),
(1419, 'KABUPATEN BANYUMAS', '934', '54', '1998', 'Penyampaian SPJ anggaran rutin April 1998', 'Penyampaian SPJ anggaran rutin April 1998', NULL, 'tersedia', '2026-08-12 21:16:07', '2026-08-12 21:16:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking_requests`
--

CREATE TABLE `booking_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `arsip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `tujuan` text NOT NULL,
  `tanggal_pengambilan` date DEFAULT NULL,
  `waktu_pengambilan` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'diproses',
  `dikembalikan_at` timestamp NULL DEFAULT NULL,
  `email_terkirim_at` timestamp NULL DEFAULT NULL,
  `arsip_no` varchar(255) DEFAULT NULL,
  `arsip_kode` varchar(255) DEFAULT NULL,
  `arsip_uraian` text DEFAULT NULL,
  `arsip_instansi` varchar(255) DEFAULT NULL,
  `arsip_tahun` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2026_07_30_000001_create_arsips_table', 1),
(2, '2026_07_31_000001_create_booking_requests_table', 1),
(3, '2026_08_03_000001_create_admins_table', 1),
(4, '2026_08_05_000001_add_status_to_bookings_and_arsips_table', 2),
(5, '2026_08_13_000001_add_waktu_and_email_fields_to_booking_requests_table', 3),
(6, '2026_08_13_000002_create_page_visits_table', 3),
(7, '2026_08_14_000001_add_session_id_to_page_visits_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `page_visits`
--

CREATE TABLE `page_visits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `page_visits`
--

INSERT INTO `page_visits` (`id`, `path`, `label`, `session_id`, `created_at`) VALUES
(1, '/', 'Beranda', 'WybTOYqQ2zD7EeMDCTrofKNMpC1TR2OzMxmUT8wZ', '2026-09-14 17:03:52'),
(2, '/', 'Beranda', '52h04z0dbjKW4wVdqy9exZ0SlplI3AOM4StlRyfo', '2026-09-16 02:00:24'),
(3, '/', 'Beranda', 'yPL0EGQtpW4IMjoic2t9honwwczzWZrIXwvhymmW', '2026-09-16 02:00:31'),
(4, '/', 'Beranda', 'c8c8wYeNDV63FOglVBb3kdG7o6btYCdbEysGn76y', '2026-09-19 01:46:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('arsiparpusda@gmail.com', '$2y$12$8AM/QqdE2fbrd.71k.NehuVznG6ZY2LgxMshVB0fnmz.Ik90R94fe', '2026-08-11 17:10:14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indeks untuk tabel `arsips`
--
ALTER TABLE `arsips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `arsips_instansi_nomor_arsip_unique` (`instansi`,`nomor_arsip`);

--
-- Indeks untuk tabel `booking_requests`
--
ALTER TABLE `booking_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_requests_arsip_id_foreign` (`arsip_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `page_visits`
--
ALTER TABLE `page_visits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_visits_session_id_index` (`session_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `arsips`
--
ALTER TABLE `arsips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1420;

--
-- AUTO_INCREMENT untuk tabel `booking_requests`
--
ALTER TABLE `booking_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `page_visits`
--
ALTER TABLE `page_visits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking_requests`
--
ALTER TABLE `booking_requests`
  ADD CONSTRAINT `booking_requests_arsip_id_foreign` FOREIGN KEY (`arsip_id`) REFERENCES `arsips` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
