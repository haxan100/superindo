-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2019 at 08:17 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `superindo`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `nama_barang` varchar(30) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(5) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `id_merk` int(11) DEFAULT NULL,
  `kode_supplier` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `nama_barang`, `harga`, `stok`, `id_jenis`, `id_merk`, `kode_supplier`) VALUES
(2, 'BRG0002', 'biets', 3000, 43, 1, NULL, 'sp002'),
(3, 'BRG0003', 'kacang merah', 500000, 20, 1, 1, 'sp002'),
(4, 'BRG0004', 'terong', 20000, 3, 1, NULL, NULL),
(5, 'BRG0005', 'kacang joglo', 50000, 20, 1, 1, 'sp001'),
(6, 'BRG0006', 'sayur kol', 3000, 1000, 1, 1, 'sp001'),
(7, 'BRG0007', 'lencah', 9000, 918, 1, NULL, NULL),
(8, 'BRG0008', 'kol putih', 3000, 1000, 1, NULL, NULL),
(9, 'BRG0009', 'kol merah', 3000, 111, 1, NULL, NULL),
(10, 'BRG0010', 'kacang panjang', 2000, 109, 2, NULL, 'sp001');

-- --------------------------------------------------------

--
-- Table structure for table `detail_faktur`
--

CREATE TABLE `detail_faktur` (
  `kode_faktur` varchar(10) DEFAULT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `qty` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_faktur`
--

INSERT INTO `detail_faktur` (`kode_faktur`, `kode_barang`, `qty`) VALUES
('TR00002', 'BRG0006', 900),
('TR00003', 'BRG0006', 3),
('TR00004', 'BRG0007', 555),
('TR00005', 'BRG0006', 90),
('TR00006', 'BRG0004', 3),
('TR00006', 'BRG0007', 4),
('TR00006', 'BRG0006', 555),
('TR00007', 'BRG0005', 80),
('TR00007', 'BRG0004', 8),
('TR00007', 'BRG0006', 10),
('TR00008', 'BRG0009', 9),
('TR00008', 'BRG0008', 9),
('TR00009', 'BRG0006', 11),
('TR00009', 'BRG0005', 11),
('TR00010', 'BRG0005', 100),
('TR00011', 'BRG0004', 20),
('TR00011', 'BRG0007', 1),
('TR00012', 'BRG0010', 99),
('FR00013', 'BRG0005', 1),
('FR00013', 'BRG0005', 1),
('FR00013', 'BRG0006', 10),
('FR00013', 'BRG0006', 10),
('FR00013', 'BRG0007', 9),
('FR00013', 'BRG0007', 9),
('FR00013', 'BRG0007', 77),
('FR00013', 'BRG0007', 9),
('FR00013', 'BRG0007', 9),
('FR00013', 'BRG0007', 9),
('FR00001', 'BRG0004', 10),
('FR00021', 'BRG0008', 900),
('FR00022', 'BRG0002', 1),
('FR00022', 'BRG0006', 2),
(NULL, 'BRG0003', 6),
('FR00023', 'BRG0010', 90),
('FR00024', 'BRG0010', 9),
('FR00024', 'BRG0007', 9),
('FR00025', 'BRG0007', 9),
('FR00025', 'BRG0003', 10);

--
-- Triggers `detail_faktur`
--
DELIMITER $$
CREATE TRIGGER `stok2_after_save` AFTER INSERT ON `detail_faktur` FOR EACH ROW BEGIN
     UPDATE barang SET stok = stok + NEW.qty
     WHERE kode_Barang = NEW.kode_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_po`
--

CREATE TABLE `detail_po` (
  `kode_po` varchar(10) DEFAULT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `qty` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_po`
--

INSERT INTO `detail_po` (`kode_po`, `kode_barang`, `qty`) VALUES
('TR00002', 'BRG0006', 900),
('TR00003', 'BRG0006', 3),
('TR00004', 'BRG0007', 555),
('TR00005', 'BRG0006', 90),
('TR00006', 'BRG0004', 3),
('TR00006', 'BRG0007', 4),
('TR00006', 'BRG0006', 555),
('TR00007', 'BRG0005', 80),
('TR00007', 'BRG0004', 8),
('TR00007', 'BRG0006', 10),
('TR00008', 'BRG0009', 9),
('TR00008', 'BRG0008', 9),
('TR00009', 'BRG0006', 11),
('TR00009', 'BRG0005', 11),
('TR00010', 'BRG0005', 100),
('TR00011', 'BRG0004', 20),
('TR00011', 'BRG0007', 1),
('TR00012', 'BRG0010', 99),
('TR00013', 'BRG0006', 9000000),
('TR00014', 'BRG0004', 77),
('TR00016', 'BRG0009', 90),
(NULL, 'BRG0006', 11),
('PO00028', 'BRG0004', 1),
('PO00028', 'BRG0005', 23),
('PO00029', 'BRG0008', 22),
('PO00029', 'BRG0005', 12),
('PO00029', 'BRG0009', 12),
('PO00032', 'BRG0005', 88),
('PO00032', 'BRG0008', 111);

-- --------------------------------------------------------

--
-- Table structure for table `faktur`
--

CREATE TABLE `faktur` (
  `id_faktur` int(11) NOT NULL,
  `kode_faktur` varchar(10) DEFAULT NULL,
  `tgl_faktur` date DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faktur`
--

INSERT INTO `faktur` (`id_faktur`, `kode_faktur`, `tgl_faktur`, `total_harga`) VALUES
(20, 'FR00001', '2019-08-15', 200000),
(21, 'FR00021', '2019-08-15', 2700000),
(22, 'FR00022', '2019-08-29', 9000),
(23, 'FR00023', '2019-08-29', 180000),
(24, 'FR00024', '2019-08-29', 99000),
(25, 'FR00025', '2019-09-28', 5081000);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis` int(11) NOT NULL,
  `jenis_barang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jenis`, `jenis_barang`) VALUES
(1, 'sayur organik'),
(2, 'sayur basah');

-- --------------------------------------------------------

--
-- Table structure for table `merk_barang`
--

CREATE TABLE `merk_barang` (
  `id_merk` int(11) NOT NULL,
  `merk_barang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merk_barang`
--

INSERT INTO `merk_barang` (`id_merk`, `merk_barang`) VALUES
(1, 'Merk Super');

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE `po` (
  `id_po` int(11) NOT NULL,
  `kode_po` varchar(10) DEFAULT NULL,
  `tgl_po` date DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po`
--

INSERT INTO `po` (`id_po`, `kode_po`, `tgl_po`, `total_harga`) VALUES
(28, 'PO00028', '2019-09-13', 1170000),
(31, 'PO00029', '2019-09-14', 702000),
(32, 'PO00032', '2019-09-24', 4733000);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `kode_supplier` varchar(10) DEFAULT NULL,
  `nama_supplier` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `no_telp` int(15) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `kode_supplier`, `nama_supplier`, `username`, `password`, `no_telp`, `alamat`) VALUES
(1, 'sp001', 'Supplier A', 'suppliera', 'suppliera', 8989, 'hhhhhhhh'),
(2, 'sp002', 'Supplier B', 'supplierb', 'supplierb', 900, 'pemalang');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faktur`
--

CREATE TABLE `tbl_faktur` (
  `id_faktur` varchar(10) NOT NULL,
  `no_faktur` varchar(10) NOT NULL,
  `id_po` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `qty` int(5) NOT NULL,
  `harga` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `kode_supplier` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faktur`
--

INSERT INTO `tbl_faktur` (`id_faktur`, `no_faktur`, `id_po`, `kode_barang`, `nama_barang`, `qty`, `harga`, `total_harga`, `kode_supplier`) VALUES
('fk001', 'fk001', 10, 'brg002', 'biets', 2, 3000, 6000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `username`, `password`, `level`) VALUES
(1, 'Administrator', 'admin', 'admin', 'admin'),
(2, 'Petugas Gudang', 'gudang', 'gudang', 'petugas gudang'),
(3, 'Manajer', 'manajer', 'manajer', 'manajer'),
(4, 'oficer', 'oficer', 'oficer', 'petugas gudang'),
(5, 'test', 'test', 'tes', 'manajer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `faktur`
--
ALTER TABLE `faktur`
  ADD PRIMARY KEY (`id_faktur`);

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `merk_barang`
--
ALTER TABLE `merk_barang`
  ADD PRIMARY KEY (`id_merk`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`id_po`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tbl_faktur`
--
ALTER TABLE `tbl_faktur`
  ADD PRIMARY KEY (`id_faktur`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `faktur`
--
ALTER TABLE `faktur`
  MODIFY `id_faktur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `merk_barang`
--
ALTER TABLE `merk_barang`
  MODIFY `id_merk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `id_po` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
