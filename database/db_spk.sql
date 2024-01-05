-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2024 at 03:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
-- Author: Hizkia Reppi
-- Github: https://github.com/HizkiaReppi/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET GLOBAL time_zone = "+07:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spk_penerimaan_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` enum('admin','member') NOT NULL DEFAULT 'member',
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `role`, `username`, `password`, `photo`) VALUES
('c02b115a-1cc1-4958-ba7f-ebc14f500370', 'Hizkia Jefren Reppi', 'admin', 'hizkia', '$2y$10$zx.rqXzFmOgfRqgFPbwBK.au.rveMVS3VwP7hcnugCEIiUSO4yDhq', NULL),
('177eb5df-cd66-458c-8c5c-0c2d81cc7993', 'Jefren Reppi', 'admin', 'jefren', '$2y$10$r6FXlIxmpTSU7FSEvURbJuXMbG0ZfMWQJ/nT8Hx0GggpwBjRr4mkS', NULL),
('0858b818-2009-40c2-be8d-5df065f4c42c', 'Kia Reppi', 'member', 'kiareppi', '$2y$10$q.zpxCffv2tXjGpTSenwP.LALM2p..vZfBhg00JAbZjFVLDI99no.', '');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quota` int(3) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `name`, `quota`, `slug`) VALUES
("b52d759e-9991-40be-a724-639989fb1d5d", 'Multimedia', 10, 'multimedia'),
("b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'RPL', 10, 'rpl'),
("710d53be-f535-453e-8eac-7f20b507bf13", 'TKJ', 10, 'tkj');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bobot` double NOT NULL,
  `jenis` enum('benefit','cost') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `name`, `bobot`, `jenis`) VALUES
("9ca00950-3f0f-4531-b595-8e1efcc9174f", 'Ujian Sekolah', 0.3, 'benefit'),
("b0004cb2-7aef-4c5e-958b-75d00fd8e9d0", 'Tes Tertulis', 0.25, 'benefit'),
("0894802a-a274-4179-bfe6-9efc3c8ac699", 'Tes Wawancara', 0.2, 'benefit'),
("32bca39a-600b-4168-a83c-6f4bbedf191f", 'Minat Terhadap Jurusan', 0.15, 'benefit'),
("56f85ddc-c1c0-4d49-b3ca-4a10c7fffb05", 'Rata-Rata Nilai Raport', 0.1, 'benefit');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` varchar(255) NOT NULL,
  `no_pendaftaran` varchar(8) NOT NULL,
  `C1` double NOT NULL,
  `C2` double NOT NULL,
  `C3` double NOT NULL,
  `C4` double NOT NULL,
  `C5` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `no_pendaftaran`, `C1`, `C2`, `C3`, `C4`, `C5`) VALUES
("8a94426f-61e1-43e6-a24f-6b351972481c", 'S-0001', 42.3, 81.6, 91.6, 91.2, 87.3),
("3fe8495c-ccbc-4dc7-a315-e845017b7d41", 'S-0002', 38.9, 83, 86.9, 91.6, 89.3),
("2a4fa0be-1f10-4a4f-b118-cb6b40b8025d", 'S-0003', 45.6, 91.6, 82, 83.3, 90.6),
("0e7221be-1c43-4db8-a6c0-e03dd5675dcd", 'S-0004', 39.2, 81.2, 82.2, 87.1, 81.1),
("2c760f56-5f1c-4f1a-822e-57804b9addaa", 'S-0005', 43.8, 92.1, 81.2, 91.7, 92.9),
("1af6fcc1-39d0-4cfd-8b5c-0758ab47e86d", 'S-0006', 36.7, 81.4, 90.4, 85.9, 92.2),
("c86e326c-a9a1-47d7-984d-7338dc4c5195", 'S-0007', 41.4, 81.5, 92.6, 82.5, 82.9),
("fb341814-e06d-4b6b-af2b-374f0c6cb690", 'S-0008', 47.2, 87.1, 92.8, 80.5, 86.1),
("938a6cae-5c02-47fe-b80d-df2f6fba9bb1", 'S-0009', 38.5, 81, 80.7, 80.5, 80.4),
("a5f23e12-ce4c-4317-9e7b-bd94251e2c9e", 'S-0010', 46.8, 80.6, 81.8, 87, 81.7),
("24643879-5883-4cfb-819f-db260941880c", 'S-0011', 35.2, 81.4, 82.2, 86.5, 91.9),
("b42292b2-4b22-4ee6-a1b4-21a2dbe1d559", 'S-0012', 42.7, 91.9, 89.9, 93.7, 90.7),
("ea353acd-9106-40d7-a0e2-30d961ef8295", 'S-0013', 49.1, 92.6, 83, 84.9, 81.7),
("39eeeb72-b1f7-4583-8b57-c77e9775dc62", 'S-0014', 37.6, 87.8, 86, 86.4, 80.3),
("d4fd1974-1fbd-49ae-bb04-c4a3143459fc", 'S-0015', 44.3, 90, 87.3, 86.5, 90.7),
("21f21f06-7c90-4aed-83f9-2eb62c07c0d2", 'S-0016', 43.6, 85.8, 90.9, 89.3, 93.5),
("7763268d-ad4a-4b4a-a13a-324b13fae16e", 'S-0017', 38.2, 91.7, 83.9, 92.4, 88.3),
("013276a5-f2f0-4c22-92b1-96df312583ac", 'S-0018', 44.9, 84.6, 91.7, 82.9, 87.5),
("52f5ac3f-ded8-4b93-aaa5-a3a30eee719a", 'S-0019', 39.6, 80.8, 89.6, 83.4, 82.3),
("8870e22c-def7-4abd-9b79-48087fa51c4f", 'S-0020', 46.3, 81.2, 93.2, 86.5, 86.7),
("5f80f400-da13-4e39-8175-57e7280e2d08", 'S-0021', 41, 93.9, 87.4, 89.6, 91.6),
("c3434fc1-c704-4a79-bd98-6e1301ea6ba0", 'S-0022', 45.7, 81.2, 93.1, 86.2, 85.6),
("aa46adc1-eee2-4954-94c6-f456bd3f9504", 'S-0023', 40.4, 89.2, 81.2, 86.5, 81.1),
("c807bc93-56a7-4b63-a87f-a5db04561fba", 'S-0024', 46.1, 93.7, 89.4, 86, 81.5),
("393bad1f-6164-4169-81ae-37e95bc07f8d", 'S-0025', 40.8, 83.6, 93.4, 80.1, 82.3),
("ad8245ab-bb65-413a-928f-2a4efbb3804d", 'S-0026', 45.5, 91.4, 88, 85.7, 84.7),
("789c563f-fa49-479b-81c2-ffe68167cfb2", 'S-0027', 40.2, 86.2, 83.1, 91, 83.7),
("bb308b6e-a202-4c78-9ce9-5baa3e0077c0", 'S-0028', 44.9, 93.4, 80.1, 82.2, 90.5),
("cfef5440-d576-476f-b7db-ad751424cb6d", 'S-0029', 43.1, 84.2, 83.2, 83.6, 88.4),
("43f7a5b3-adcd-45af-b192-91d80db75de9", 'S-0030', 37.9, 83, 83.8, 90, 90.8),
("7a634860-64e8-4f48-b1b2-e524dc18ce00", 'S-0031', 41.5, 89.8, 82.7, 91.9, 89.6),
("2e440129-ba0a-46ba-9fec-d68f38384a06", 'S-0032', 38.2, 92.2, 84.1, 91.9, 85.3),
("2775c6ed-1e16-471d-b185-680dec8bfc56", 'S-0033', 44.9, 84.6, 87.2, 88, 84.7),
("6b4dd790-6fa3-47ec-b1b5-307d55219578", 'S-0034', 39.6, 93.6, 91.7, 83.8, 91.9),
("f34f1dac-e08b-44b1-8f59-b879c333bd01", 'S-0035', 46.3, 85.9, 87.8, 87.2, 92.7),
("1443172f-df21-42bc-bc9d-c8c18b260a5a", 'S-0036', 41, 80.1, 84.4, 87.4, 90.1),
("2cdd96d3-c4b5-4c63-a3b4-66ba4b32302f", 'S-0037', 43.3, 80.2, 92.9, 87.7, 93.9),
("d1bd7528-e7b5-46fe-8134-7d74d1d11294", 'S-0038', 38.8, 84.5, 88.7, 81.9, 91.6),
("df93f3a2-7a97-41ab-a1af-0ae7fb53fd2a", 'S-0039', 45.5, 90.3, 82.7, 90.4, 81.8),
("e009cb3c-b1aa-4f74-9274-f259c7f47307", 'S-0040', 39.2, 86.1, 90.9, 88.5, 89.5),
("82c5f95c-042f-4772-9fe4-9fca38ac4fe2", 'S-0041', 46.9, 88, 91.4, 85.2, 85.8),
("a2ccaa7f-1807-4ec7-a4a1-65c53891b409", 'S-0042', 44.9, 93.3, 87.1, 89.5, 92.3),
("42df41fe-9a85-4fd8-a9b0-1a36a8f1620e", 'S-0043', 39.6, 85, 81.9, 88.6, 89.2),
("9226af90-c7b7-4dc2-b7a6-7484f9962f71", 'S-0044', 46.3, 86.1, 83.2, 91.4, 85.7),
("87a14eb6-6901-412b-acee-1a371ddd13b0", 'S-0045', 41, 88.4, 90.6, 93.7, 88.8);

-- --------------------------------------------------------

--
-- Table structure for table `normalisasi`
--

CREATE TABLE `normalisasi` (
  `id` varchar(255) NOT NULL,
  `no_pendaftaran` varchar(8) NOT NULL,
  `C1` double NOT NULL,
  `C2` double NOT NULL,
  `C3` double NOT NULL,
  `C4` double NOT NULL,
  `C5` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `normalisasi`
--

INSERT INTO `normalisasi` (`id`, `no_pendaftaran`, `C1`, `C2`, `C3`, `C4`, `C5`) VALUES
("38ac48a9-723b-41ba-828c-09d7b60c11bb", 'S-0001', 0, 0, 0, 0, 0),
("7a453e55-b518-4c79-ae34-df40d91d4802", 'S-0002', 0, 0, 0, 0, 0),
("4165c3d7-f02b-4e7f-b754-794204679278", 'S-0003', 0, 0, 0, 0, 0),
("37daad53-6bd5-49dc-bfc3-96c9c0260f2c", 'S-0004', 0.798371, 0.866596, 0.884822, 0.942641, 0.863685),
("f4f95176-324f-4e4b-b0bd-cd48f5313949", 'S-0005', 0, 0, 0, 0, 0),
("93b2949a-5302-4b98-9c19-21558842a394", 'S-0006', 0.747454, 0.86873, 0.973089, 0.929654, 0.981896),
("505687fb-80ae-48cd-b40b-b0f60af48637", 'S-0007', 0, 0, 0, 0, 0),
("7051a686-effb-4d2a-96af-d9d20b833028", 'S-0008', 0, 0, 0, 0, 0),
("16e2f97f-dd5b-46d6-8216-c73b48584172", 'S-0009', 0.831533, 0.86262, 0.887789, 0.859125, 0.859893),
("f815fd8e-e8f3-46e1-86a7-32c29ea64cb7", 'S-0010', 0.953157, 0.860192, 0.880517, 0.941558, 0.870075),
("41147f94-51b6-4fa4-adac-e633f9cb6bbb", 'S-0011', 0.760259, 0.86688, 0.90429, 0.923159, 0.982888),
("ae5ffc02-0b04-4bee-852f-2cad07c14cac", 'S-0012', 0.922246, 0.978701, 0.988999, 1, 0.970053),
("58ef291a-f77f-4c67-86e1-74926bc72e85", 'S-0013', 1, 0.98826, 0.893434, 0.918831, 0.870075),
("92219cad-b39a-45d1-b23d-67bb2819bb9f", 'S-0014', 0, 0, 0, 0, 0),
("bf4cceee-8444-4a87-8e20-da105c849d23", 'S-0015', 0, 0, 0, 0, 0),
("48e75993-aa47-4254-91bf-8f65581d6bad", 'S-0016', 0.941685, 0.913738, 1, 0.953042, 1),
("5930a3f8-4476-47c4-957e-afb2084a9309", 'S-0017', 0.778004, 0.978655, 0.903122, 1, 0.940362),
("450b2cb7-d647-4101-a853-0500ae3cce7d", 'S-0018', 0.91446, 0.902882, 0.987083, 0.897186, 0.931842),
("9b0113c0-f872-4a28-87cb-6d8fbb8cef7d", 'S-0019', 0, 0, 0, 0, 0),
("b3c9096e-5805-4d14-87aa-4f0074009edd", 'S-0020', 0, 0, 0, 0, 0),
("7d7bfe3e-352d-450a-a4a1-3bf256cb0594", 'S-0021', 0.885529, 1, 0.961496, 0.956243, 0.979679),
("b8a56b6b-bdee-473b-8547-4c9c148002d1", 'S-0022', 0, 0, 0, 0, 0),
("c25ee3fb-a414-4737-afb7-885a5ddde50a", 'S-0023', 0, 0, 0, 0, 0),
("49f7f7b7-8e79-4350-aafc-ac60a1fa34f8", 'S-0024', 0.9389, 1, 0.962325, 0.930736, 0.867945),
("ade6b10e-6705-4178-af29-52c2d8965a9a", 'S-0025', 0, 0, 0, 0, 0),
("b3af200f-9b8d-4bcc-8a9a-073883546cfd", 'S-0026', 0, 0, 0, 0, 0),
("6693cec0-28cd-4d7f-92a2-e45cb3b93c73", 'S-0027', 0.868251, 0.917998, 0.914191, 0.971185, 0.895187),
("9103e0d6-7b02-439b-968f-5930ebeb3740", 'S-0028', 0.969762, 0.994675, 0.881188, 0.877268, 0.967914),
("67ababd4-4fe8-402c-81c2-8da3af4e5e23", 'S-0029', 0.930886, 0.896699, 0.915292, 0.892209, 0.945455),
("eb9fb742-98fc-4913-bc2d-e7a554bac3d0", 'S-0030', 0.818575, 0.883919, 0.921892, 0.960512, 0.971123),
("2bd51610-b869-4ad2-a5d7-af610acdf155", 'S-0031', 0, 0, 0, 0, 0),
("cf302e12-8816-4ad6-b466-144426daca83", 'S-0032', 0, 0, 0, 0, 0),
("0e8b4681-6214-4126-b20a-53a10f44ed88", 'S-0033', 0.969762, 0.900958, 0.959296, 0.939168, 0.905882),
("5b34fff8-7846-4da6-a7ca-54a2dc7232ef", 'S-0034', 0, 0, 0, 0, 0),
("5f45c8aa-ad82-46cd-b43e-0622e62a2b0e", 'S-0035', 1, 0.914803, 0.965897, 0.93063, 0.991444),
("7420116d-f9a5-40b0-8fd4-bbf12988d192", 'S-0036', 0, 0, 0, 0, 0),
("c84b7c3c-a59f-4c4d-9c33-0a1b6b6d76e7", 'S-0037', 0.881874, 0.855923, 1, 0.949134, 1),
("e82a47b6-5e9f-47db-b0f2-5384af1e8dc5", 'S-0038', 0.790224, 0.901814, 0.95479, 0.886364, 0.975506),
("66ec024f-1d3c-46ef-9036-44c1a24c933d", 'S-0039', 0.92668, 0.963714, 0.890205, 0.978355, 0.87114),
("39056626-fb3d-4e34-a93a-e9a3f6ed6794", 'S-0040', 0.798371, 0.91889, 0.978471, 0.957792, 0.953142),
("701858d6-29a4-4fbe-b324-fbd93191f68a", 'S-0041', 0.955193, 0.939168, 0.983854, 0.922078, 0.913738),
("075a0b2d-7f3e-4003-b11a-e4e619686837", 'S-0042', 0.91446, 0.995731, 0.937567, 0.968615, 0.982961),
("d5bd96c6-c3d1-4cf5-8cd0-f94dfb34b1b7", 'S-0043', 0, 0, 0, 0, 0),
("a50fbd82-6e19-423c-87c7-9cdb7df5ca2f", 'S-0044', 0.942974, 0.91889, 0.895587, 0.989177, 0.912673),
("e09f3092-0d00-469b-99ea-fe7a7c120511", 'S-0045', 0.885529, 0.941427, 0.9967, 1, 0.949733);

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `no_pendaftaran` varchar(8) NOT NULL,
  `email` varchar(75) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `id_jurusan` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tanggal_lahir` varchar(11) NOT NULL,
  `alamat` text DEFAULT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `nilai_ujian_sekolah` double NOT NULL,
  `nilai_akhir` double DEFAULT NULL,
  `ranking` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`no_pendaftaran`, `email`, `password`, `nisn`, `id_jurusan`, `name`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `asal_sekolah`, `nilai_ujian_sekolah`, `nilai_akhir`, `ranking`) VALUES
('S-0001', 'budisantoso@gmail.com', '$2y$10$H7rcgezCk2cEreVdD2/kCujbGMsvUpDWyRolkBpDz8ykOB9brhwa2', '754212', "710d53be-f535-453e-8eac-7f20b507bf13", 'Budi Santoso', 'L', '15-04-2003', 'Tomohon Selatan, Sulawesi Utara', 'SMP Negeri 1 Tomohon', 42.3, NULL, NULL),
('S-0002', 'sitirahayu@gmail.com', '$2y$10$9UzBgCCPQaRn0siEmfm7VeYZBEM5A7Qk/SLt0eOnXBSHa080UYqf2', '743243', "710d53be-f535-453e-8eac-7f20b507bf13", 'Siti Rahayu', 'P', '20-05-2003', 'Tondano Timur, Sulawesi Utara', 'SMP Negeri 6 Tondano', 38.9, NULL, NULL),
('S-0003', 'jokoprasetyo@gmail.com', '$2y$10$cWuQWtfqUIB2W.1KpaL9KuXppwzW8xNIIXGOoBqHZCWEGKEvyPLy6', '865425', "710d53be-f535-453e-8eac-7f20b507bf13", 'Joko Prasetyo', 'L', '25-06-2003', 'Langowan Utara, Sulawesi Utara', 'SMP Negeri 1 Langowan', 45.6, NULL, NULL),
('S-0004', 'putrianindya@gmail.com', '$2y$10$I7huI/Jd2BxYR40ujPVMoefSmywJiaib1jSIyAx/ljmiVHae7fo2O', '627923', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Putri Anindya', 'P', '30-07-2003', 'Wori, Sulawesi Utara', 'SMP Negeri Wori', 39.2, 0.860889, NULL),
('S-0005', 'aguswidodo@gmail.com', '$2y$10$rEtO0QK3s9JM/bTNPBusdeqm/xMZr5YD2rHjOBs8sb66MQ/MOEFNe', '874632', "710d53be-f535-453e-8eac-7f20b507bf13", 'Agus Widodo', 'L', '05-08-2003', 'Kema, Sulawesi Utara', 'SMP Negeri 3 Kema', 43.8, NULL, NULL),
('S-0006', 'dewilestari@gmail.com', '$2y$10$7QlxbUI7mQz22TyIXAuSWeQNEUe6yZ4AdSyprpE/pvIOmUCw3MgGu', '432638', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Dewi Lestari', 'P', '10-09-2003', 'Ranowangko, Sulawesi Utara', 'SMP Negeri 3 Ranowangko', 36.7, 0.873674, NULL),
('S-0007', 'adinugroho@gmail.com', '$2y$10$51A.wXQsBI.EJotQVQ7KYOGTZ4al6xnBY3wPLftNsfsPtF1JISTpm', '789012', "710d53be-f535-453e-8eac-7f20b507bf13", 'Adi Nugroho', 'L', '15-04-2004', 'Kakas, Sulawesi Utara', 'SMP Negeri 2 Kakas', 41.4, NULL, NULL),
('S-0008', 'retnowulandari@gmail.com', '$2y$10$teJjz3Z13lmmL5XqXLn7TuES2bCkprHx3TG56PXM9CK8vp3zEDb9S', '890123', "710d53be-f535-453e-8eac-7f20b507bf13", 'Retno Wulandari', 'L', '20-05-2004', 'Airmadidi, Sulawesi Utara', 'SMP Negeri Airmadidi', 47.2, NULL, NULL),
('S-0009', 'dwiwahyuni@gmail.com', '$2y$10$f.6WURTs0909UeYGYGhBluHLqyuo5zIhDYhbniEX4ZhgLAXLYGjUa', '901234', "b52d759e-9991-40be-a724-639989fb1d5d", 'Dwi Wahyuni', 'P', '25-06-2004', 'Malalayang, Sulawesi Utara', 'SMP Negeri 7 Malalayang', 38.5, 0.857531, NULL),
('S-0010', 'irfanmalik@gmail.com', '$2y$10$d2WkTzl6oQR9Yt.sc0KbUOO4TlB71nEJ2YOopRWeu5htxzQ/iVrXC', '643278', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Irfan Malik', 'L', '30-07-2004', 'Likupang Barat, Sulawesi Utara', 'SMP Negeri 1 Likupang', 46.8, 0.90534, NULL),
('S-0011', 'mayasari@gmail.com', '$2y$10$hmVzspUtQquhgAMvLk2YTO6xyVlguSMD6N2sZkCZ27LzY.5Jn1EhW', '472364', "b52d759e-9991-40be-a724-639989fb1d5d", 'Maya Sari', 'P', '05-08-2004', 'Sonder, Sulawesi Utara', 'SMP Negeri 1 Sonder', 35.2, 0.862418, NULL),
('S-0012', 'rudihermawan@gmail.com', '$2y$10$7aCRHKP4lInRSwNyeMmmsuxT4c3u8CWPOSI/O881Mxu9fsMJqnl1.', '432742', "b52d759e-9991-40be-a724-639989fb1d5d", 'Rudi Hermawan', 'L', '10-09-2004', 'Kauditan, Sulawesi Utara', 'SMP Negeri 2 Kauditan', 42.7, 0.966154, NULL),
('S-0013', 'yuniartiputri@gmail.com', '$2y$10$cz7kETe33NkSIV/8qKssdu16rzMpv4EzeD/mrYR8majUFIHzPBfJy', '864237', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Yuniarti Putri', 'P', '15-04-2005', 'Dumoga Utara, Sulawesi Utara', 'SMP Negeri 3 Dumoga', 49.1, 0.950584, NULL),
('S-0014', 'herusetiawan@gmail.com', '$2y$10$6Y17zmWB4wgwsIhkQVlNTOcxjXU2p73dzJINxxFLOka9lmYdYV4O.', '243862', "710d53be-f535-453e-8eac-7f20b507bf13", 'Heru Setiawan', 'L', '20-05-2005', 'Matani, Sulawesi Utara', 'SMP Negeri 1 Matani', 37.6, NULL, NULL),
('S-0015', 'intanpurnama@gmail.com', '$2y$10$fzDJziZYkyJ6oKAc7IdsouYGGdgAcJ9yaqQEZb4Uo/8ezbA0ekF6.', '324374', "710d53be-f535-453e-8eac-7f20b507bf13", 'Intan Purnama', 'P', '25-06-2005', 'Kumelembuai, Sulawesi Utara', 'SMP Negeri 4 Kumelembuai', 44.3, NULL, NULL),
('S-0016', 'ahmadyani@gmail.com', '$2y$10$GWVTZIoyffV/C48jSqmn6Ons1NpkWDXLx8X5YWvT3YfJUObpOSjZ6', '156345', "b52d759e-9991-40be-a724-639989fb1d5d", 'Ahmad Yani', 'L', '30-07-2005', 'Tomohon Selatan, Sulawesi Utara', 'SMP Negeri 2 Tomohon', 43.6, 0.953896, NULL),
('S-0017', 'rinasusanti@gmail.com', '$2y$10$YtnZpSNU9Z57.xSKOkKG1emh.J2G7xZdAG9.4dGqmuCQqCisO7wNm', '345453', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Rina Susanti', 'P', '05-08-2005', 'Tondano Timur, Sulawesi Utara', 'SMP Negeri 5 Tondano', 38.2, 0.902726, NULL),
('S-0018', 'fajarsitiawan@gmail.com', '$2y$10$EEmD88UxaZeIeskSqVcPv.Ih/f.8jwCuutiaaXOXvCqDAm2KBMaIa', '538535', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Fajar Setiawan', 'L', '10-09-2005', 'Langowan Utara, Sulawesi Utara', 'SMP Negeri 2 Langowan', 44.9, 0.925237, NULL),
('S-0019', 'triutami@gmail.com', '$2y$10$xABw.bvjMCAQtjNETN4A/e1A/Qh443lxP0LBVRZ/XzaBw7Wg8wxBO', '495739', "710d53be-f535-453e-8eac-7f20b507bf13", 'Tri Utami', 'P', '15-10-2005', 'Wori, Sulawesi Utara', 'SMP Negeri Wori', 39.6, NULL, NULL),
('S-0020', 'yogapratama@gmail.com', '$2y$10$1p.wUySbAhBEtZGmb0X8vOycbl/hgvmTGpZNYbDa7AXhxnNshNqUC', '932743', "710d53be-f535-453e-8eac-7f20b507bf13", 'Yoga Pratama', 'L', '20-11-2005', 'Kema, Sulawesi Utara', 'SMP Negeri 4 Kema', 46.3, NULL, NULL),
('S-0021', 'siskaramadhani@gmail.com', '$2y$10$dtOKF70sVPzBOs.2hznb6uUdEG2tpnCJrrKH35SlW1nN2xClYiif6', '234289', "b52d759e-9991-40be-a724-639989fb1d5d", 'Siska Ramadhani', 'P', '25-12-2005', 'Ranowangko, Sulawesi Utara', 'SMP Negeri 5 Ranowangko', 41, 0.949362, NULL),
('S-0022', 'fandigunawan@gmail.com', '$2y$10$sU/xF4oARSYrYM75nFR.b.oIHVtOuepISsc8YvT9i/h7jGg89vZ3m', '426438', "710d53be-f535-453e-8eac-7f20b507bf13", 'Fandi Gunawan', 'L', '30-01-2006', 'Kakas, Sulawesi Utara', 'SMP Negeri 3 Kakas', 45.7, NULL, NULL),
('S-0023', 'dinaamelia@gmail.com', '$2y$10$9wd6wqWxRjfQlE.BMEMTf.vp1N/eHdQI3nYmqdY46ZFiS5o2BHbdm', '123263', "710d53be-f535-453e-8eac-7f20b507bf13", 'Dina Amelia', 'P', '04-02-2006', 'Airmadidi, Sulawesi Utara', 'SMP Negeri 3 Airmadidi', 40.4, NULL, NULL),
('S-0024', 'indrapermana@gmail.com', '$2y$10$viA.REHfBbmWDoGhFSthl.lUIHEio/IYOo1RtmTwYBwvIz1ngazVO', '912335', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Indra Permana', 'L', '10-03-2006', 'Malalayang, Sulawesi Utara', 'SMP Negeri 6 Malalayang', 46.1, 0.95054, NULL),
('S-0025', 'linafitriani@gmail.com', '$2y$10$6yLdY0/6uu82D3Bdnsign.Zlnq1wF.mBTY7RG.MWBbChw8oZu6ke.', '937241', "710d53be-f535-453e-8eac-7f20b507bf13", 'Lina Fitriani', 'P', '15-04-2006', 'Likupang Barat, Sulawesi Utara', 'SMP Negeri 1 Likupang', 40.8, NULL, NULL),
('S-0026', 'rizkysaputra@gmail.com', '$2y$10$pShVf1BXEPP6p901Gd8P6OYVTqaGW19cQCar/UYWnrsk4nxVOweva', '134723', "710d53be-f535-453e-8eac-7f20b507bf13", 'Rizky Saputra', 'L', '20-05-2006', 'Sonder, Sulawesi Utara', 'SMP Negeri 3 Sonder', 45.5, NULL, NULL),
('S-0027', 'nitaayu@gmail.com', '$2y$10$6urWTpUPm2TrIKtssK3lc.hn28QJfOVPL6EDDM9612V5pneCaK2hm', '432972', "b52d759e-9991-40be-a724-639989fb1d5d", 'Nita Ayu', 'P', '25-06-2006', 'Kauditan, Sulawesi Utara', 'SMP Negeri 1 Kauditan', 40.2, 0.908009, NULL),
('S-0028', 'agungkusuma@gmail.com', '$2y$10$2qItpGelN6i43rNA0Lh.O.6e7G18.V0y4dyOgun/APM0QwuMwL1VG', '348624', "b52d759e-9991-40be-a724-639989fb1d5d", 'Agung Kusuma', 'L', '30-07-2006', 'Dumoga Utara, Sulawesi Utara', 'SMP Negeri 2 Dumoga', 44.9, 0.944217, NULL),
('S-0029', 'tonisiregar@gmail.com', '$2y$10$pAesnWoNxe3RzCdtsM/Y6u7ZiAz4fTAPwh6n8yXR/unzheXoBQYfK', '974623', "b52d759e-9991-40be-a724-639989fb1d5d", 'Toni Siregar', 'L', '10-11-2003', 'Airmadidi, Sulawesi Utara', 'SMP Negeri 2 Airmadidi', 43.1, 0.914876, NULL),
('S-0030', 'finanovita@gmail.com', '$2y$10$Aowd6hGjhSMA5SysgXK1h.N5IyELczdY3co1zrmYSmF4o33kaPdQ6', '429742', "b52d759e-9991-40be-a724-639989fb1d5d", 'Fina Novita', 'P', '15-12-2003', 'Malalayang, Sulawesi Utara', 'SMP Negeri 8 Malalayang', 37.9, 0.89212, NULL),
('S-0031', 'andisaputra@gmail.com', '$2y$10$4ZD9nW.JHF.EMaAGtUebZec2erAdX.8VD0QJD9y5PlT0/yyNwCP3u', '153633', "710d53be-f535-453e-8eac-7f20b507bf13", 'Andi Saputra', 'L', '20-01-2004', 'Likupang Barat, Sulawesi Utara', 'SMP Negeri 2 Likupang', 41.5, NULL, NULL),
('S-0032', 'dewianggraeni@gmail.com', '$2y$10$Wcj7RhWCWND5l7p5HmbQf.j7RF0i2xrfEtAVX6NPJN2pElIQ6Ql8q', '463824', "710d53be-f535-453e-8eac-7f20b507bf13", 'Dewi Anggraeni', 'P', '25-02-2004', 'Sonder, Sulawesi Utara', 'SMP Negeri 2 Sonder', 38.2, NULL, NULL),
('S-0033', 'arindwei@gmail.com', '$2y$10$Ux5z8tMnyCiOBoNt1TU3HOqo2sYicD6DF4tQd21Ub/B4SEoMoN7M.', '153452', "b52d759e-9991-40be-a724-639989fb1d5d", 'Arin Dwei', 'P', '30-03-2004', 'Kauditan, Sulawesi Utara', 'SMP Negeri 3 Kauditan', 44.9, 0.939491, NULL),
('S-0034', 'rinamwijaya@gmail.com', '$2y$10$39.NhOd6VD8Aq0HdXlO88e3/5MZ171RKVbOVN4nOLrLyTCeXgHsSK', '874283', "710d53be-f535-453e-8eac-7f20b507bf13", 'Rina Wijaya', 'P', '05-04-2004', 'Dumoga Utara, Sulawesi Utara', 'SMP Negeri 4 Dumoga', 39.6, NULL, NULL),
('S-0035', 'hendrosantoso@gmail.com', '$2y$10$lBNkypJYhnscPbZitbTe0uN5XYIRFijuIClztFHB7CoHV1Z/lg5ya', '987432', "b52d759e-9991-40be-a724-639989fb1d5d", 'Hendro Santoso', 'L', '10-05-2004', 'Matani, Sulawesi Utara', 'SMP Negeri 1 Matani', 46.3, 0.960619, NULL),
('S-0036', 'dewiputri@gmail.com', '$2y$10$fGQupf8MpsGtuBc7YA8iqOMByyiFuxE8TPShTrYqW7qT43I4R2flC', '127453', "710d53be-f535-453e-8eac-7f20b507bf13", 'Dewi Putri', 'P', '15-06-2004', 'Kumelembuai, Sulawesi Utara', 'SMP Negeri 7 Kumelembuai', 41, NULL, NULL),
('S-0037', 'billysantoso@gmail.com', '$2y$10$dx98pBBKsZ7NmvXhEwPbZe9q7LaniilwvWarsQXmbjpyRDEN4RVmu', '974263', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Billy Santoso', 'L', '20-07-2004', 'Tomohon Selatan, Sulawesi Utara', 'SMP Negeri 3 Tomohon', 43.3, 0.920913, NULL),
('S-0038', 'dianarahayu@gmail.com', '$2y$10$KasPbvDV/9HBUoKG3.F4ruHXGfHlcYV8KCAUL5rQ8v3KNSl1LkXja', '874263', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Diana Rahayu', 'P', '25-08-2004', 'Tondano Timur, Sulawesi Utara', 'SMP Negeri 4 Tondano', 38.8, 0.883984, NULL),
('S-0039', 'fikrialamsyah@gmail.com', '$2y$10$7FTsMYs4x3rTo5szRN/QuekkjB62t/uYv1vdpuFCXrtEZKgpHu3vO', '982361', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Fikri Alamsyah', 'L', '30-09-2004', 'Langowan Utara, Sulawesi Utara', 'SMP Negeri 5 Langowan', 45.5, 0.930841, NULL),
('S-0040', 'trisnaapriliani@gmai', '$2y$10$rYdpXdyJ6U81iR4KquKiuuVQAxzSYseH7WMKWCngeTgrq7lFxbzKG', '142623', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Trisna Apriliani', 'P', '05-10-2004', 'Wori, Sulawesi Utara', 'SMP Negeri 6 Wori', 39.2, 0.903911, NULL),
('S-0041', 'reynaldiputra@gmail.com', '$2y$10$5DXjX/1DTcboV33my00HfupOACyY847VZntGG.Smdq6hNWb3OLkuO', '743252', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Reynaldi Putra', 'L', '10-11-2004', 'Kema, Sulawesi Utara', 'SMP Negeri 7 Kema', 46.9, 0.947806, NULL),
('S-0042', 'arifinharahap@gmail.com', '$2y$10$l/ngpAAjflmJaanAXvTGa.dVFvkqdZinbeoAyJ/6IAongqqM/7t3a', '826123', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Arifin Harahap', 'L', '30-03-2004', 'Kauditan, Sulawesi Utara', 'SMP Negeri 3 Kauditan', 44.9, 0.954373, NULL),
('S-0043', 'rinamariana@gmail.com', '$2y$10$Rn4eepIHBwdiATFrm.9hwumMRMSDOB1s91lEWq5fIRrEpzTubUQXy', '352513', "710d53be-f535-453e-8eac-7f20b507bf13", 'Rina Mariana', 'P', '05-04-2004', 'Dumoga Utara, Sulawesi Utara', 'SMP Negeri 4 Dumoga', 39.6, NULL, NULL),
('S-0044', 'hendrawijaya@gmail.com', '$2y$10$xQd9wh3Mcbfn4G8w66Ng3usReWH2PFKbpT1IEg2gQfSXNelXCHyR.', '843261', "b9cd8707-e11e-43f7-b449-98e02aa4ea1c", 'Hendra Wijaya', 'L', '10-05-2004', 'Matani, Sulawesi Utara', 'SMP Negeri 1 Matani', 46.3, 0.931376, NULL),
('S-0045', 'deviputri@gmail.com', '$2y$10$IuunE0CDjsbUYFnfvxhzOuazmVNCVJt4TwshxaaNafSrjAIWUw3k.', '142642', "b52d759e-9991-40be-a724-639989fb1d5d", 'Devi Putri', 'P', '15-06-2004', 'Kumelembuai, Sulawesi Utara', 'SMP Negeri 7 Kumelembuai', 41, 0.945329, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_pendaftaran` (`no_pendaftaran`);

--
-- Indexes for table `normalisasi`
--
ALTER TABLE `normalisasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `no_pendaftaran` (`no_pendaftaran`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`no_pendaftaran`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`no_pendaftaran`) REFERENCES `peserta` (`no_pendaftaran`);

--
-- Constraints for table `normalisasi`
--
ALTER TABLE `normalisasi`
  ADD CONSTRAINT `normalisasi_ibfk_1` FOREIGN KEY (`no_pendaftaran`) REFERENCES `peserta` (`no_pendaftaran`);

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
