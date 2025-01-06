-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 08:50 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcafesaw`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `ID_ALTERNATIF` int(3) NOT NULL,
  `TGL_ALTERNATIF` date NOT NULL,
  `ID_CAFE` char(4) NOT NULL,
  `ID_KONSUMEN` char(3) NOT NULL,
  `JARAK` smallint(6) DEFAULT NULL,
  `HASIL` decimal(5,2) DEFAULT NULL,
  `RANGKING` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`ID_ALTERNATIF`, `TGL_ALTERNATIF`, `ID_CAFE`, `ID_KONSUMEN`, `JARAK`, `HASIL`, `RANGKING`) VALUES
(1, '2024-12-11', 'K01', '1', 3000, '0.95', 1),
(2, '2024-12-11', 'K02', '1', 8000, '0.93', 2),
(3, '2024-12-12', 'K07', '1', 3000, '0.63', 2),
(4, '2024-12-12', 'K08', '1', 5000, '0.73', 1),
(5, '2024-12-16', 'K01', '2', 12000, '0.75', 4),
(6, '2024-12-16', 'K06', '2', 4000, '0.80', 3),
(7, '2024-12-16', 'K01', '2', 6000, '0.95', 2),
(8, '2024-12-16', 'K06', '2', 14000, '1.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bobot_kriteria`
--

CREATE TABLE `bobot_kriteria` (
  `ID_KRITERIA` char(2) NOT NULL,
  `ID_KONSUMEN` char(3) NOT NULL,
  `BOBOT` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`ID_KRITERIA`, `ID_KONSUMEN`, `BOBOT`) VALUES
('C1', '1', '0.30'),
('C1', '2', '0.30'),
('C2', '1', '0.20'),
('C2', '2', '0.20'),
('C3', '1', '0.20'),
('C3', '2', '0.20'),
('C4', '1', '0.20'),
('C4', '2', '0.20'),
('C5', '1', '0.10'),
('C5', '2', '0.10');

-- --------------------------------------------------------

--
-- Table structure for table `cafe`
--

CREATE TABLE `cafe` (
  `ID_CAFE` char(4) NOT NULL,
  `NAMA_CAFE` varchar(50) DEFAULT NULL,
  `ALAMAT` varchar(200) DEFAULT NULL,
  `NOTELP` varchar(13) DEFAULT NULL,
  `HARGA_MIN` decimal(10,2) DEFAULT NULL,
  `JUMLAH_MENU` int(11) DEFAULT NULL,
  `PELAYANAN` varchar(35) DEFAULT NULL,
  `GAMBAR` varchar(50) DEFAULT NULL,
  `DESKRIPSI` varchar(500) DEFAULT NULL,
  `STATUS_CAFE` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cafe`
--

INSERT INTO `cafe` (`ID_CAFE`, `NAMA_CAFE`, `ALAMAT`, `NOTELP`, `HARGA_MIN`, `JUMLAH_MENU`, `PELAYANAN`, `GAMBAR`, `DESKRIPSI`, `STATUS_CAFE`) VALUES
('K01', 'Excelso - SUB East Coast Center, Pakuwon City', 'Level G, East Coast Center, Jl. Raya Laguna KJW Putih Tambak No.2, Kejawaan Putih Tamba, Kec. Mulyorejo, Surabaya, Jawa Timur 60116', '03158208340', '45000.00', 25, '4', 'https://www.instagram.com/excelso.pcm/', 'Member of @petarunggroup.id\r\nOpen for Dine In from 10 am - 10 pm\r\n📍Pakuwon City Mall 2, G level\r\nAvailable for Delivery!\r\n☎ 031-99218520\r\n📱081252033655(WA)', '1'),
('K02', 'Starbuck Reserve Galaxy Mall 3', 'Jl. Dharmahusada Indah Timur No.35-37, Mulyorejo, Kec. Mulyorejo, Surabaya, Jawa Timur 60114', '0315915044', '50000.00', 35, '4', 'https://www.starbucks.co.id/', 'Our story began in 1971. Back then we were a roaster and retailer of whole bean and ground coffee, tea and spices with a single store in Seattle’s Pike Place Market. Today, we are privileged to connect with millions of customers every day in more than 80 markets.\r\n\r\nFOLKLORE\r\n\r\nStarbucks is named after the first mate in Herman Melville’s “Moby-Dick.” Our logo is also inspired by the sea – featuring a twin-tailed siren from Greek mythology.', '1'),
('K03', 'Ada Apa Dengan Kopi (AADK) - Wiyung', 'Jl. Raya Menganti Karangan No.85, Babatan, Kec. Wiyung, Surabaya, Jawa Timur 60227', '089503370055', '15000.00', 20, '3', 'https://www.instagram.com/adaapadengankopi/', 'https://l.instagram.com/?u=https%3A%2F%2Flinktr.ee%2Faadkcoffeeatery&e=AT0f5b1QTJDi_5MefC2upIe3u6xgpe_pZ03CuZbrnoHvAgLACVqZmu_eo-tgwExhMv5brmgMrERsUX1AaAS85HXyTjqvvZ6T', '1'),
('K04', 'Toko Kopi Padma', 'Tunjungan St No.86-88, Genteng, Surabaya, East Java 60275', '-', '25000.00', 30, '3', 'https://www.instagram.com/tokokopipadma/', 'https://pergikuliner.com/restaurants/toko-kopi-padma-genteng/menus', '1'),
('K05', 'Mawu Cafe', 'Jl. Pandan No.5, Ketabang, Kec. Genteng, Surabaya, Jawa Timur', '-', '15000.00', 35, '2', 'https://www.instagram.com/mawu.cafe/?hl=en', 'https://pergikuliner.com/restaurants/mawu-cafe-dukuh-pakis/menus', '1'),
('K06', 'Starbucks Gubeng', 'Jl. Raya Gubeng No.33, RT.002/RW.06, Gubeng, Kec. Gubeng, Surabaya, Jawa Timur 60281', '-', '50000.00', 30, '4', 'https://www.starbucks.co.id/', 'https://www.starbucks.co.id/about-us', '1'),
('K07', 'JOKOPI - Dinoyo', 'Jl. Dinoyo No.83 B, Keputran, Kec. Tegalsari, Surabaya, Jawa Timur 60265', '087', '20000.00', 15, '3', 'https://www.instagram.com/jo.ko.pi/', 'https://pergikuliner.com/restaurants/jokopi-tegalsari-2/menus', '1'),
('K08', 'Alfa X Tenggilis Mejoyo', 'Jl. Tenggilis Mejoyo AI, Kali Rungkut, Kec. Rungkut, Surabaya, Jawa Timur 60293', '-', '15000.00', 30, '3', 'https://www.instagram.com/p/CYlKQjtAM5t/?img_index', 'https://gofood.co.id/id/surabaya/restaurant/alfa-x-coffee-tenggilis-mejoyo-8e5920bb-67d5-430f-874f-fbda2d647fea', '1'),
('K09', '118th Coffee', 'Jl. Siwalankerto No.118, Siwalankerto, Kec. Wonocolo, Surabaya, Jawa Timur 60234', '081333194820', '25000.00', 25, '3', 'https://www.instagram.com/118bysocra/?hl=en', 'https://gofood.co.id/id/surabaya/restaurant/one-eighteenth-coffee-siwalankerto-006423eb-137a-41f5-9c79-28e9421ed79c', '1'),
('K10', 'Monopole Coffee Lab', 'Jl. Raya Darmo Permai I No.38, Pradahkalikendal, Kec. Dukuhpakis, Surabaya, Jawa Timur 60189', '0317314065', '25000.00', 40, '4', 'https://www.instagram.com/monopolecoffeelab/?hl=en', 'https://pergikuliner.com/restaurants/monopole-coffee-lab-dukuh-pakis/menus', '1'),
('K11', 'Excelso - SUB Sulawesi', 'Jl. Sulawesi No.71, Gubeng, Kec. Gubeng, Surabaya, Jawa Timur 60281', '0315058119', '35000.00', 35, '4', 'https://gofood.co.id/surabaya/restaurants/brand/9a', '-', '1'),
('K12', 'Carnis', 'Jl. Raya Gubeng No.96, Gubeng, Kec. Gubeng, Surabaya, Jawa Timur 60281', '08113520020', '30000.00', 40, '4', 'https://www.instagram.com/carnis.sby/?hl=en', 'https://pergikuliner.com/restaurants/carnis-gubeng/menus', '1'),
('K13', 'Rolag Kopi', 'Jl. Khairil Anwar No.15-19, Darmo, Kec. Wonokromo, Surabaya, Jawa Timur 60241', '082233117117', '20000.00', 35, '3', 'https://www.instagram.com/rolagprapanca.ofc/?hl=en', 'https://pergikuliner.com/restaurants/surabaya/kopi-rolag-wonokromo', '1'),
('K14', 'Serlok Kopi - Kertajaya', 'Jl. Kertajaya No.67, RT.001/RW.03, Airlangga, Kec. Gubeng, Surabaya, Jawa Timur 60286', '081996250000', '20000.00', 30, '3', 'https://www.instagram.com/serlokkopi/?hl=en', 'https://pergikuliner.com/restaurants/surabaya/serlok-kopi-kertajaya', '1');

-- --------------------------------------------------------

--
-- Table structure for table `detil_subkri_fas`
--

CREATE TABLE `detil_subkri_fas` (
  `ID_KRITERIA` char(2) NOT NULL,
  `ID_SUB_KRITERIA` char(3) NOT NULL,
  `ID_FASILITAS` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detil_subkri_fas`
--

INSERT INTO `detil_subkri_fas` (`ID_KRITERIA`, `ID_SUB_KRITERIA`, `ID_FASILITAS`) VALUES
('C2', 'S06', 'F01'),
('C2', 'S06', 'F02'),
('C2', 'S06', 'F03'),
('C2', 'S06', 'F04'),
('C2', 'S06', 'F05'),
('C2', 'S06', 'F06'),
('C2', 'S06', 'F07'),
('C2', 'S06', 'F08'),
('C2', 'S06', 'F09'),
('C2', 'S07', 'F01'),
('C2', 'S07', 'F02'),
('C2', 'S07', 'F03'),
('C2', 'S07', 'F04'),
('C2', 'S07', 'F05'),
('C2', 'S07', 'F07'),
('C2', 'S07', 'F09'),
('C2', 'S08', 'F01'),
('C2', 'S08', 'F03'),
('C2', 'S08', 'F04'),
('C2', 'S08', 'F05'),
('C2', 'S08', 'F07'),
('C2', 'S08', 'F10');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `ID_FASILITAS` char(3) NOT NULL,
  `NAMA_FASILITAS` varchar(35) DEFAULT NULL,
  `STATUS_FASILITAS` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`ID_FASILITAS`, `NAMA_FASILITAS`, `STATUS_FASILITAS`) VALUES
('F01', 'Wifi', '1'),
('F02', 'AC', '1'),
('F03', 'Area Outdoor', '1'),
('F04', 'Toilet', '1'),
('F05', 'Area Parkir', '1'),
('F06', 'Live Music', '1'),
('F07', 'Stop Kontak', '1'),
('F08', 'Keamanan', '1'),
('F09', 'Buka 12 Jam', '1'),
('F10', 'Buka 8 Jam', '1'),
('F11', 'Meja Billiard', '1');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas_cafe`
--

CREATE TABLE `fasilitas_cafe` (
  `ID_CAFE` char(4) NOT NULL,
  `ID_FASILITAS` char(3) NOT NULL,
  `STATUS_FAS_CAFE` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas_cafe`
--

INSERT INTO `fasilitas_cafe` (`ID_CAFE`, `ID_FASILITAS`, `STATUS_FAS_CAFE`) VALUES
('K01', 'F01', '1'),
('K01', 'F02', '1'),
('K01', 'F03', '1'),
('K01', 'F04', '1'),
('K01', 'F05', '1'),
('K01', 'F06', '1'),
('K01', 'F07', '1'),
('K01', 'F08', '1'),
('K01', 'F09', '1'),
('K02', 'F01', '1'),
('K02', 'F02', '1'),
('K02', 'F03', '1'),
('K02', 'F04', '1'),
('K02', 'F05', '1'),
('K02', 'F06', '1'),
('K02', 'F07', '1'),
('K02', 'F08', '1'),
('K02', 'F09', '1'),
('K03', 'F01', '1'),
('K03', 'F02', '1'),
('K03', 'F03', '1'),
('K03', 'F04', '1'),
('K03', 'F05', '1'),
('K03', 'F06', '1'),
('K03', 'F07', '1'),
('K03', 'F08', '1'),
('K03', 'F09', '1'),
('K04', 'F01', '1'),
('K04', 'F02', '1'),
('K04', 'F03', '1'),
('K04', 'F04', '1'),
('K04', 'F05', '1'),
('K04', 'F06', '1'),
('K04', 'F07', '1'),
('K04', 'F08', '1'),
('K04', 'F09', '1'),
('K05', 'F01', '1'),
('K05', 'F03', '1'),
('K05', 'F04', '1'),
('K05', 'F05', '1'),
('K05', 'F07', '1'),
('K05', 'F09', '1'),
('K06', 'F01', '1'),
('K06', 'F02', '1'),
('K06', 'F03', '1'),
('K06', 'F04', '1'),
('K06', 'F05', '1'),
('K06', 'F06', '1'),
('K06', 'F07', '1'),
('K06', 'F08', '1'),
('K06', 'F09', '1'),
('K07', 'F01', '1'),
('K07', 'F02', '1'),
('K07', 'F03', '1'),
('K07', 'F04', '1'),
('K07', 'F05', '1'),
('K07', 'F07', '1'),
('K07', 'F09', '1'),
('K08', 'F01', '1'),
('K08', 'F03', '1'),
('K08', 'F04', '1'),
('K08', 'F05', '1'),
('K08', 'F07', '1'),
('K08', 'F09', '1'),
('K09', 'F01', '1'),
('K09', 'F03', '1'),
('K09', 'F04', '1'),
('K09', 'F05', '1'),
('K09', 'F07', '1'),
('K09', 'F09', '1'),
('K10', 'F01', '1'),
('K10', 'F02', '1'),
('K10', 'F03', '1'),
('K10', 'F04', '1'),
('K10', 'F05', '1'),
('K10', 'F06', '1'),
('K10', 'F07', '1'),
('K10', 'F08', '1'),
('K10', 'F09', '1'),
('K11', 'F01', '1'),
('K11', 'F02', '1'),
('K11', 'F03', '1'),
('K11', 'F04', '1'),
('K11', 'F05', '1'),
('K11', 'F06', '1'),
('K11', 'F07', '1'),
('K11', 'F08', '1'),
('K11', 'F09', '1'),
('K12', 'F01', '1'),
('K12', 'F02', '1'),
('K12', 'F03', '1'),
('K12', 'F04', '1'),
('K12', 'F05', '1'),
('K12', 'F06', '1'),
('K12', 'F07', '1'),
('K12', 'F08', '1'),
('K12', 'F09', '1'),
('K13', 'F01', '1'),
('K13', 'F03', '1'),
('K13', 'F04', '1'),
('K13', 'F05', '1'),
('K13', 'F07', '1'),
('K13', 'F09', '1'),
('K14', 'F01', '1'),
('K14', 'F02', '1'),
('K14', 'F03', '1'),
('K14', 'F04', '1'),
('K14', 'F05', '1'),
('K14', 'F06', '1'),
('K14', 'F07', '1'),
('K14', 'F08', '1'),
('K14', 'F09', '1');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_atribut`
--

CREATE TABLE `jenis_atribut` (
  `ID_JENIS` char(1) NOT NULL,
  `NAMA_JENIS` varchar(10) DEFAULT NULL,
  `STATUS_JENIS` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_atribut`
--

INSERT INTO `jenis_atribut` (`ID_JENIS`, `NAMA_JENIS`, `STATUS_JENIS`) VALUES
('1', 'Cost', '1'),
('2', 'Benefit', '1');

-- --------------------------------------------------------

--
-- Table structure for table `konsumen`
--

CREATE TABLE `konsumen` (
  `ID_KONSUMEN` char(3) NOT NULL,
  `NAMA_KONSUMEN` varchar(50) DEFAULT NULL,
  `NOHP` varchar(13) DEFAULT NULL,
  `USERNAME` varchar(20) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL,
  `STATUS_KONSUMEN` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konsumen`
--

INSERT INTO `konsumen` (`ID_KONSUMEN`, `NAMA_KONSUMEN`, `NOHP`, `USERNAME`, `PASSWORD`, `STATUS_KONSUMEN`) VALUES
('1', 'Mikha Gunawan Andy Wijaya', '087', '18410100055', '$2y$10$ekdzE.dYWZZZ70VwFnU8FuiIvVuLdi6QWSx6XSxJoqgjkdpaL51Du', '1'),
('2', 'User2', '1234', 'user2', '$2y$10$wAhQOov6X7pH.NdkIT5ww.N9tVGWfpsqq9ICDV5UNli8E4MsIVu4K', '1');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `ID_KRITERIA` char(2) NOT NULL,
  `ID_JENIS` char(1) NOT NULL,
  `NAMA_KRITERIA` varchar(15) DEFAULT NULL,
  `STATUS_KRITERIA` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`ID_KRITERIA`, `ID_JENIS`, `NAMA_KRITERIA`, `STATUS_KRITERIA`) VALUES
('C1', '1', 'Harga', '1'),
('C2', '2', 'Fasilitas', '1'),
('C3', '1', 'Jarak', '1'),
('C4', '2', 'Varian Menu', '1'),
('C5', '2', 'Pelayanan', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `ID_KRITERIA` char(2) NOT NULL,
  `ID_SUB_KRITERIA` char(3) NOT NULL,
  `NAMA_SUB_KRITERIA` varchar(30) DEFAULT NULL,
  `INDIKATOR` varchar(50) DEFAULT NULL,
  `NILAI_SUB_KRITERIA` int(11) DEFAULT NULL,
  `STATUS_SUB_KRITERIA` char(1) DEFAULT NULL,
  `BATAS_BAWAH` int(11) DEFAULT NULL,
  `BATAS_ATAS` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`ID_KRITERIA`, `ID_SUB_KRITERIA`, `NAMA_SUB_KRITERIA`, `INDIKATOR`, `NILAI_SUB_KRITERIA`, `STATUS_SUB_KRITERIA`, `BATAS_BAWAH`, `BATAS_ATAS`) VALUES
('C1', 'S01', 'Sangat Mahal', 'Rp 100.000 ≤ C1', 1, '1', 100000, 500000),
('C1', 'S02', 'Mahal', 'Rp 70.000 ≤ C1 < Rp 100.000', 2, '1', 70000, 100000),
('C1', 'S03', 'Cukup Murah', 'Rp 40.000 ≤ C1 < Rp 70.000', 3, '1', 40000, 70000),
('C1', 'S04', 'Murah', 'Rp 10.000 ≤ C1 < Rp 40.000', 4, '1', 10000, 40000),
('C1', 'S05', 'Sangat Murah', 'Rp 500 ≤ C1 < Rp 10.000', 5, '1', 500, 10000),
('C2', 'S06', 'Lengkap', 'F01, F02, F03, F04, F05, F06, F07, F08, F09', 3, '1', 0, 0),
('C2', 'S07', 'Cukup Lengkap', 'F01, F02, F03, F04, F05, F07, F09', 2, '1', 0, 0),
('C2', 'S08', 'Kurang Lengkap', 'F01, F03, F04, F05, F07, F10', 1, '1', 0, 0),
('C3', 'S09', 'Sangat Jauh', '20.000 m (20 km) ≤ C3', 1, '1', 20000, 100000),
('C3', 'S10', 'Jauh', '10.000 m (10 km) ≤ C3 < 20.000 m (20 km)', 2, '1', 10000, 20000),
('C3', 'S11', 'Sedang', '5.000 m (5 km) ≤ C3 < 10.000 m (10 km)', 3, '1', 5000, 10000),
('C3', 'S12', 'Dekat', '1.000 m (1 km) ≤  C3 < 5.000 m (5 km)', 4, '1', 1000, 5000),
('C3', 'S13', 'Sangat Dekat', '0 m (0 km) ≤ C3 < 1.000 m (1 km)', 5, '1', 0, 1000),
('C4', 'S14', 'Sangat Beragam', '30 Item Menu ≤ C4', 4, '1', 30, 100),
('C4', 'S15', 'Beragam', '20 Item Menu ≤ C4 < 30 Item Menu', 3, '1', 20, 30),
('C4', 'S16', 'Cukup Beragam', '10 Item Menu ≤ C4 < 20 Item Menu', 2, '1', 10, 20),
('C4', 'S17', 'Kurang Beragam', '0 ≤ C4 < 10 Item Menu', 1, '1', 0, 10),
('C5', 'S18', 'Sangat Puas', 'Pegawai sangat responsif terhadap konsumen', 4, '1', 0, 0),
('C5', 'S19', 'Puas', 'Pegawai responsif terhadap konsumen', 3, '1', 0, 0),
('C5', 'S20', 'Cukup Puas', 'Pegawai cukup responsif terhadap konsumen', 2, '1', 0, 0),
('C5', 'S21', 'Kurang Puas', 'Pegawai kurang responsif terhadap konsumen', 1, '1', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria_cafe`
--

CREATE TABLE `sub_kriteria_cafe` (
  `ID_KRITERIA` char(2) NOT NULL,
  `ID_SUB_KRITERIA` char(3) NOT NULL,
  `ID_CAFE` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria_cafe`
--

INSERT INTO `sub_kriteria_cafe` (`ID_KRITERIA`, `ID_SUB_KRITERIA`, `ID_CAFE`) VALUES
('C1', 'S03', 'K01'),
('C1', 'S03', 'K02'),
('C1', 'S03', 'K06'),
('C1', 'S04', 'K03'),
('C1', 'S04', 'K04'),
('C1', 'S04', 'K05'),
('C1', 'S04', 'K07'),
('C1', 'S04', 'K08'),
('C1', 'S04', 'K09'),
('C1', 'S04', 'K10'),
('C1', 'S04', 'K11'),
('C1', 'S04', 'K12'),
('C1', 'S04', 'K13'),
('C1', 'S04', 'K14'),
('C2', 'S06', 'K01'),
('C2', 'S06', 'K02'),
('C2', 'S06', 'K03'),
('C2', 'S06', 'K04'),
('C2', 'S06', 'K06'),
('C2', 'S06', 'K10'),
('C2', 'S06', 'K11'),
('C2', 'S06', 'K12'),
('C2', 'S06', 'K14'),
('C2', 'S07', 'K05'),
('C2', 'S07', 'K07'),
('C2', 'S07', 'K08'),
('C2', 'S07', 'K09'),
('C2', 'S07', 'K13'),
('C3', 'S10', 'K01'),
('C3', 'S10', 'K03'),
('C3', 'S10', 'K06'),
('C3', 'S11', 'K01'),
('C3', 'S11', 'K02'),
('C3', 'S11', 'K03'),
('C3', 'S11', 'K06'),
('C3', 'S12', 'K04'),
('C3', 'S12', 'K05'),
('C3', 'S12', 'K06'),
('C3', 'S12', 'K07'),
('C3', 'S12', 'K08'),
('C4', 'S14', 'K02'),
('C4', 'S14', 'K04'),
('C4', 'S14', 'K05'),
('C4', 'S14', 'K06'),
('C4', 'S14', 'K08'),
('C4', 'S14', 'K10'),
('C4', 'S14', 'K11'),
('C4', 'S14', 'K12'),
('C4', 'S14', 'K13'),
('C4', 'S14', 'K14'),
('C4', 'S15', 'K01'),
('C4', 'S15', 'K03'),
('C4', 'S15', 'K09'),
('C4', 'S16', 'K07'),
('C5', 'S18', 'K01'),
('C5', 'S18', 'K02'),
('C5', 'S18', 'K06'),
('C5', 'S18', 'K10'),
('C5', 'S18', 'K11'),
('C5', 'S18', 'K12'),
('C5', 'S19', 'K03'),
('C5', 'S19', 'K04'),
('C5', 'S19', 'K07'),
('C5', 'S19', 'K08'),
('C5', 'S19', 'K09'),
('C5', 'S19', 'K13'),
('C5', 'S19', 'K14'),
('C5', 'S20', 'K05');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID_ADMIN` char(3) NOT NULL,
  `NAMA_ADMIN` varchar(40) NOT NULL,
  `NOHP` varchar(13) NOT NULL,
  `USERNAME` varchar(15) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `STATUS_ADMIN` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID_ADMIN`, `NAMA_ADMIN`, `NOHP`, `USERNAME`, `PASSWORD`, `STATUS_ADMIN`) VALUES
('A1', 'Administrator', '085123', 'admin', '$2y$10$WxHC8MMwwzA6DYMTJU92Kuw5MEBLVreSq08X2EFm3nHYe2kGvjsla', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`ID_ALTERNATIF`,`TGL_ALTERNATIF`,`ID_CAFE`,`ID_KONSUMEN`) USING BTREE,
  ADD UNIQUE KEY `ALTERNATIF_PK` (`ID_ALTERNATIF`,`ID_CAFE`,`ID_KONSUMEN`,`TGL_ALTERNATIF`) USING BTREE,
  ADD KEY `MENENTUKAN_FK` (`ID_KONSUMEN`),
  ADD KEY `MENGGUNAKAN_FK` (`ID_CAFE`);

--
-- Indexes for table `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD PRIMARY KEY (`ID_KRITERIA`,`ID_KONSUMEN`),
  ADD UNIQUE KEY `BOBOT_KRITERIA_PK` (`ID_KRITERIA`,`ID_KONSUMEN`),
  ADD KEY `BOBOT_KRITERIA_FK2` (`ID_KRITERIA`),
  ADD KEY `BOBOT_KRITERIA_FK` (`ID_KONSUMEN`);

--
-- Indexes for table `cafe`
--
ALTER TABLE `cafe`
  ADD PRIMARY KEY (`ID_CAFE`),
  ADD UNIQUE KEY `CAFE_PK` (`ID_CAFE`);

--
-- Indexes for table `detil_subkri_fas`
--
ALTER TABLE `detil_subkri_fas`
  ADD PRIMARY KEY (`ID_KRITERIA`,`ID_SUB_KRITERIA`,`ID_FASILITAS`),
  ADD UNIQUE KEY `DETIL_SUB_KRITERIA_FASILITAS_P` (`ID_KRITERIA`,`ID_SUB_KRITERIA`,`ID_FASILITAS`),
  ADD KEY `DETIL_SUB_KRITERIA_FASILITAS_F` (`ID_KRITERIA`,`ID_SUB_KRITERIA`),
  ADD KEY `DETIL_SUB_KRITERIA_FASILITAS_2` (`ID_FASILITAS`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`ID_FASILITAS`),
  ADD UNIQUE KEY `FASILITAS_PK` (`ID_FASILITAS`);

--
-- Indexes for table `fasilitas_cafe`
--
ALTER TABLE `fasilitas_cafe`
  ADD PRIMARY KEY (`ID_CAFE`,`ID_FASILITAS`),
  ADD UNIQUE KEY `FASILITAS_CAFE_PK` (`ID_CAFE`,`ID_FASILITAS`),
  ADD KEY `FASILITAS_CAFE_FK2` (`ID_CAFE`),
  ADD KEY `FASILITAS_CAFE_FK` (`ID_FASILITAS`);

--
-- Indexes for table `jenis_atribut`
--
ALTER TABLE `jenis_atribut`
  ADD PRIMARY KEY (`ID_JENIS`),
  ADD UNIQUE KEY `JENIS_ATRIBUT_PK` (`ID_JENIS`);

--
-- Indexes for table `konsumen`
--
ALTER TABLE `konsumen`
  ADD PRIMARY KEY (`ID_KONSUMEN`),
  ADD UNIQUE KEY `KONSUMEN_PK` (`ID_KONSUMEN`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`ID_KRITERIA`),
  ADD UNIQUE KEY `KRITERIA_PK` (`ID_KRITERIA`),
  ADD KEY `TERMASUK_FK` (`ID_JENIS`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`ID_KRITERIA`,`ID_SUB_KRITERIA`),
  ADD UNIQUE KEY `SUB_KRITERIA_PK` (`ID_KRITERIA`,`ID_SUB_KRITERIA`),
  ADD KEY `MEMILIKI_FK` (`ID_KRITERIA`);

--
-- Indexes for table `sub_kriteria_cafe`
--
ALTER TABLE `sub_kriteria_cafe`
  ADD PRIMARY KEY (`ID_KRITERIA`,`ID_SUB_KRITERIA`,`ID_CAFE`),
  ADD UNIQUE KEY `SUB_KRITERIA_CAFE_PK` (`ID_KRITERIA`,`ID_SUB_KRITERIA`,`ID_CAFE`),
  ADD KEY `SUB_KRITERIA_CAFE_FK2` (`ID_KRITERIA`,`ID_SUB_KRITERIA`),
  ADD KEY `SUB_KRITERIA_CAFE_FK` (`ID_CAFE`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID_ADMIN`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD CONSTRAINT `alternatif_ibfk_1` FOREIGN KEY (`ID_KONSUMEN`) REFERENCES `konsumen` (`ID_KONSUMEN`),
  ADD CONSTRAINT `alternatif_ibfk_2` FOREIGN KEY (`ID_CAFE`) REFERENCES `cafe` (`ID_CAFE`);

--
-- Constraints for table `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD CONSTRAINT `bobot_kriteria_ibfk_1` FOREIGN KEY (`ID_KRITERIA`) REFERENCES `kriteria` (`ID_KRITERIA`),
  ADD CONSTRAINT `bobot_kriteria_ibfk_2` FOREIGN KEY (`ID_KONSUMEN`) REFERENCES `konsumen` (`ID_KONSUMEN`);

--
-- Constraints for table `detil_subkri_fas`
--
ALTER TABLE `detil_subkri_fas`
  ADD CONSTRAINT `detil_subkri_fas_ibfk_1` FOREIGN KEY (`ID_KRITERIA`,`ID_SUB_KRITERIA`) REFERENCES `sub_kriteria` (`ID_KRITERIA`, `ID_SUB_KRITERIA`),
  ADD CONSTRAINT `detil_subkri_fas_ibfk_2` FOREIGN KEY (`ID_FASILITAS`) REFERENCES `fasilitas` (`ID_FASILITAS`);

--
-- Constraints for table `fasilitas_cafe`
--
ALTER TABLE `fasilitas_cafe`
  ADD CONSTRAINT `fasilitas_cafe_ibfk_1` FOREIGN KEY (`ID_CAFE`) REFERENCES `cafe` (`ID_CAFE`),
  ADD CONSTRAINT `fasilitas_cafe_ibfk_2` FOREIGN KEY (`ID_FASILITAS`) REFERENCES `fasilitas` (`ID_FASILITAS`);

--
-- Constraints for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD CONSTRAINT `kriteria_ibfk_1` FOREIGN KEY (`ID_JENIS`) REFERENCES `jenis_atribut` (`ID_JENIS`);

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`ID_KRITERIA`) REFERENCES `kriteria` (`ID_KRITERIA`);

--
-- Constraints for table `sub_kriteria_cafe`
--
ALTER TABLE `sub_kriteria_cafe`
  ADD CONSTRAINT `sub_kriteria_cafe_ibfk_1` FOREIGN KEY (`ID_KRITERIA`,`ID_SUB_KRITERIA`) REFERENCES `sub_kriteria` (`ID_KRITERIA`, `ID_SUB_KRITERIA`),
  ADD CONSTRAINT `sub_kriteria_cafe_ibfk_2` FOREIGN KEY (`ID_CAFE`) REFERENCES `cafe` (`ID_CAFE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
