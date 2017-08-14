-- --------------------------------------------------------
-- Host:                         localhost
-- Versi server:                 5.5.39 - MySQL Community Server (GPL)
-- OS Server:                    Win32
-- HeidiSQL Versi:               9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for koperasional
CREATE DATABASE IF NOT EXISTS `koperasional` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `koperasional`;


-- Dumping structure for table koperasional.bon_gantung
CREATE TABLE IF NOT EXISTS `bon_gantung` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `penerima` tinyint(4) DEFAULT NULL,
  `tggl_bon` date DEFAULT NULL,
  `waktu_bon` datetime DEFAULT NULL,
  `keterangan` text,
  `jumlah` int(9) DEFAULT NULL,
  `tggl_bayar` datetime DEFAULT NULL,
  `bagian` char(6) DEFAULT NULL,
  `status_bon` tinyint(4) DEFAULT NULL,
  `user_kasir` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_bon` (`status_bon`),
  KEY `user_kasir` (`user_kasir`),
  KEY `id_pengguna_kas` (`penerima`),
  CONSTRAINT `FK1_status_bon` FOREIGN KEY (`status_bon`) REFERENCES `status_kas` (`id_kas`) ON UPDATE CASCADE,
  CONSTRAINT `FK_bon_gantung_pengguna_kas` FOREIGN KEY (`penerima`) REFERENCES `pengguna_kas` (`idPengguna`) ON UPDATE CASCADE,
  CONSTRAINT `FK_bon_gantung_user_kasir` FOREIGN KEY (`user_kasir`) REFERENCES `user_kasir` (`idUserKasir`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table koperasional.bon_gantung: ~1 rows (approximately)
/*!40000 ALTER TABLE `bon_gantung` DISABLE KEYS */;
INSERT INTO `bon_gantung` (`id`, `penerima`, `tggl_bon`, `waktu_bon`, `keterangan`, `jumlah`, `tggl_bayar`, `bagian`, `status_bon`, `user_kasir`) VALUES
	(1, 2, '2017-08-14', '2017-08-14 13:59:55', 'Bon Gantung', 6000000, NULL, 'PUSAT', 9, '1307690');
/*!40000 ALTER TABLE `bon_gantung` ENABLE KEYS */;


-- Dumping structure for table koperasional.jenis_biaya
CREATE TABLE IF NOT EXISTS `jenis_biaya` (
  `id_jenis` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nama_jenis` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Dumping data for table koperasional.jenis_biaya: ~16 rows (approximately)
/*!40000 ALTER TABLE `jenis_biaya` DISABLE KEYS */;
INSERT INTO `jenis_biaya` (`id_jenis`, `nama_jenis`) VALUES
	(1, 'Kantor'),
	(2, 'Bonus'),
	(3, 'Gaji / Lembur'),
	(4, 'Dinas'),
	(5, 'BBM'),
	(6, 'PLN'),
	(7, 'PDAM'),
	(8, 'Internet'),
	(9, 'Telepon'),
	(10, 'Entertain'),
	(11, 'Hutang'),
	(12, 'Budget Operasional'),
	(14, 'coba'),
	(15, 'Dropping'),
	(16, 'Setoran'),
	(17, 'Realisasi');
/*!40000 ALTER TABLE `jenis_biaya` ENABLE KEYS */;


-- Dumping structure for table koperasional.kas_operasional
CREATE TABLE IF NOT EXISTS `kas_operasional` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `no_bukti_kas` varchar(20) NOT NULL,
  `penerima` tinyint(4) DEFAULT NULL,
  `jumlah` int(9) DEFAULT NULL,
  `keterangan` text,
  `jenis_biaya` tinyint(4) DEFAULT NULL,
  `bagian` char(6) DEFAULT NULL,
  `tggl_kas` date DEFAULT NULL,
  `waktu_tambah` datetime DEFAULT NULL,
  `user_kasir` varchar(10) DEFAULT NULL,
  `status_kas` tinyint(4) DEFAULT NULL,
  `status_closing` tinyint(4) DEFAULT NULL,
  `jenis_kas` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_bukti_kas` (`no_bukti_kas`),
  KEY `user_kasir` (`user_kasir`),
  KEY `status_kas` (`status_kas`),
  KEY `jenis_biaya` (`jenis_biaya`),
  KEY `id_kas_masuk` (`id`),
  KEY `penerima` (`penerima`),
  KEY `FK_kas_masuk_status_kas` (`status_closing`),
  CONSTRAINT `kas_operasional_ibfk_1` FOREIGN KEY (`status_kas`) REFERENCES `status_kas` (`id_kas`) ON UPDATE CASCADE,
  CONSTRAINT `kas_operasional_ibfk_2` FOREIGN KEY (`jenis_biaya`) REFERENCES `jenis_biaya` (`id_jenis`) ON UPDATE CASCADE,
  CONSTRAINT `kas_operasional_ibfk_3` FOREIGN KEY (`penerima`) REFERENCES `pengguna_kas` (`idPengguna`) ON UPDATE CASCADE,
  CONSTRAINT `kas_operasional_ibfk_4` FOREIGN KEY (`status_closing`) REFERENCES `status_kas` (`id_kas`) ON UPDATE CASCADE,
  CONSTRAINT `kas_operasional_ibfk_5` FOREIGN KEY (`user_kasir`) REFERENCES `user_kasir` (`idUserKasir`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table koperasional.kas_operasional: ~59 rows (approximately)
/*!40000 ALTER TABLE `kas_operasional` DISABLE KEYS */;
INSERT INTO `kas_operasional` (`id`, `no_bukti_kas`, `penerima`, `jumlah`, `keterangan`, `jenis_biaya`, `bagian`, `tggl_kas`, `waktu_tambah`, `user_kasir`, `status_kas`, `status_closing`, `jenis_kas`) VALUES
	(1, '001/KKPST/VIII-2017', 2, 165000, 'Biaya konsumsi lembur an Nova, Trisna, Dayat, Diana, Hamdah, \nAbdi, Rezeki, Samsudin, Rizky, Roy, Ina tgl 30 November 2016', 3, 'PUSAT', '2017-08-09', '2017-08-09 10:34:37', '1307690', 4, 1, 'kas_keluar'),
	(2, '002/KKPST/VIII-2017', 3, 130000, 'Biaya transfer gaji TSA project bulan November 2016', 3, 'PUSAT', '2017-08-09', '2017-08-09 10:34:37', '1307690', 4, 1, 'kas_keluar'),
	(3, '001/KMBJM/VIII-2017', 7, 3725500, 'Dropping kas Operasional Cab. Bjm bulan Desember 2016 (Tahap I)', 15, 'CABANG', '2017-08-09', '2017-08-09 10:39:59', '1307690', 12, 1, 'kas_masuk'),
	(4, '001/KKBJM/VIII-2017', 13, 3725500, 'Uang muka pembelian keperluan dapur untuk bulan Desember 2016', 1, 'CABANG', '2017-08-09', '2017-08-09 10:41:29', '1307690', 11, 1, 'kas_keluar'),
	(6, '002/KKBJM/VIII-2017', 1, 464400, 'Pembelian catridge warna, power supplay, dan Lan card \nuntuk Bp. Nandus', 1, 'CABANG', '2017-08-09', '2017-08-09 10:44:44', '1307690', 4, 1, 'kas_keluar'),
	(7, '003/KKBJM/VIII-2017', 20, 250000, 'Pembelian BBM untuk mobil luxio B 1112 GKM (km. 18751)', 5, 'CABANG', '2017-08-09', '2017-08-09 10:46:55', '1307690', 4, 1, 'kas_keluar'),
	(8, '004/KKBJM/VIII-2017', 16, 150000, 'Biaya jaga malam untuk bulan Desember 2016', 1, 'CABANG', '2017-08-09', '2017-08-09 10:46:55', '1307690', 4, 1, 'kas_keluar'),
	(9, '005/KKBJM/VIII-2017', 21, 165000, 'Biaya konsumsi an Leo driver dan security tgl 28-29 Nov - 1-2-3-4 Des 2016', 3, 'CABANG', '2017-08-09', '2017-08-09 10:50:08', '1307690', 4, 1, 'kas_keluar'),
	(10, '006/KKBJM/VIII-2017', 20, 350000, 'Biaya futsal karyawan Banjarmasin @ 175.000/jam', 10, 'CABANG', '2017-08-09', '2017-08-09 10:50:08', '1307690', 4, 1, 'kas_keluar'),
	(11, '007/KKBJM/VIII-2017', 1, 210000, 'Uang muka pembelian kabel LAN,  keyboard dan mouse untuk Batola', 1, 'CABANG', '2017-08-09', '2017-08-09 10:19:25', '1307690', 5, 1, 'kas_keluar'),
	(12, '008/KKBJM/VIII-2017', 1, 660000, 'Biaya pemasangan internet baru di Handil Bakti', 8, 'CABANG', '2017-08-09', '2017-08-09 10:54:28', '1307690', 4, 1, 'kas_keluar'),
	(13, '002/KMBJM/VIII-2017', 7, 5000000, 'Dropping kas Operasional Cab. Bjm bulan Desember 2016 (Tahap II)', 15, 'CABANG', '2017-08-09', '2017-08-09 10:55:44', '1307690', 12, 1, 'kas_masuk'),
	(14, '009/KKBJM/VIII-2017', 22, 5000000, 'Biaya support ceremony reward racing mom September 2016', 12, 'CABANG', '2017-08-09', '2017-08-09 10:58:00', '1307690', 4, 1, 'kas_keluar'),
	(15, '010/KKBJM/VIII-2017', 20, 30000, 'Biaya parkir', 4, 'CABANG', '2017-08-09', '2017-08-09 11:00:29', '1307690', 4, 1, 'kas_keluar'),
	(16, '011/KKBJM/VIII-2017', 13, 2400000, 'Biaya cetak nota KVS 4 ply Starindo untuk Sales', 1, 'CABANG', '2017-08-09', '2017-08-09 11:00:29', '1307690', 4, 1, 'kas_keluar'),
	(17, '012/KKBJM/VIII-2017', 13, 3576800, 'Pembelian keperluan dapur untuk bulan Desember 2016', 1, 'CABANG', '2017-08-09', '2017-08-09 11:00:29', '1307690', 4, 1, 'kas_keluar'),
	(18, '003/KMBJM/VIII-2017', 1, 550000, 'Pengembalian UM pembelian catridge warna, power supplay, dan Lan card \nuntuk Bp. Nandus (via UM tgl 29 November 2016)', 5, 'CABANG', '2017-08-09', '2017-08-09 13:44:59', '1307690', 12, 1, 'kas_masuk'),
	(19, '004/KMBJM/VIII-2017', 1, 660000, 'Pengembalian UM biaya pemasangan internet baru di Handil Bakti\n(via UM tgl 29 November 2016)', 5, 'CABANG', '2017-08-09', '2017-08-09 13:44:59', '1307690', 12, 1, 'kas_masuk'),
	(20, '005/KMBJM/VIII-2017', 13, 2400000, 'Pengembalian UM biaya cetak nota KVS 4 ply Starindo untuk Sales\n(via UM tgl 30 November 2016)', 5, 'CABANG', '2017-08-09', '2017-08-09 13:44:59', '1307690', 12, 1, 'kas_masuk'),
	(21, '006/KMBJM/VIII-2017', 13, 3725500, 'Pengembalian UM pembelian keperluan dapur untuk bulan Desember 2016\n(via UM tgl 2 Desember 2016)', 5, 'CABANG', '2017-08-09', '2017-08-09 13:44:59', '1307690', 12, 1, 'kas_masuk'),
	(23, '003/KKPST/VIII-2017', 4, 800000, 'Uang muka biaya perpanjangan surat tanda lapor mobil operasional Starindo\nMobil luxio B 1106 GKM (operasional TDC Banjarbaru)\nMobil luxio B 1107 GKM (operasional TDC Banjarbaru)\nMobil luxio B 1108 GKM (operasional TDC Pelaihari)\nMobil luxio B 1109 GKM (operasional TDC Batola)\nMobil luxio B 1110 GKM (operasional TDC Banjarmasin)\nMobil luxio B 1112 GKM (operasional TDC Banjarmasin)\nMobil luxio B 1113 GKM (operasional TDC Banjarmasin)\nMobil luxio B 1560 PRS(operasional TDC Martapura)', 4, 'PUSAT', '2017-08-09', '2017-08-09 14:36:04', '1307690', 5, 1, 'kas_keluar'),
	(24, '004/KKPST/VIII-2017', 6, 60000, 'Biaya konsumsi an Thomas, driver, security utk ambil uang ke BJB, MTP dan PLH', 4, 'PUSAT', '2017-08-09', '2017-08-09 14:32:55', '1307690', 4, 1, 'kas_keluar'),
	(25, '005/KKPST/VIII-2017', 6, 300000, 'Uang muka biaya perdinas an Ibu Linda, Reny, Atika dan driver ke \nMartapura tgl 2-3 Desember 2016', 4, 'PUSAT', '2017-08-09', '2017-08-09 14:32:55', '1307690', 11, 1, 'kas_keluar'),
	(26, '001/KMPST/VIII-2017', 7, 4358500, 'Dropping kas Operasional pusat bulan Desember 2016 (Tahap I)', 15, 'PUSAT', '2017-08-09', '2017-08-09 14:35:23', '1307690', 12, 1, 'kas_masuk'),
	(27, '002/KMPST/VIII-2017', 4, 800000, 'Pengembalian UM biaya perpanjangan surat tanda lapor mobil operasional StarindoMobil luxio B 1106 GKM (operasional TDC Banjarbaru)Mobil luxio B 1107 GKM (operasional TDC Banjarbaru)Mobil luxio B 1108 GKM (operasional TDC Pelaihari)Mobil luxio B 1109 GKM (operasional TDC Batola)Mobil luxio B 1110 GKM (operasional TDC Banjarmasin)Mobil luxio B 1112 GKM (operasional TDC Banjarmasin)Mobil luxio B 1113 GKM (operasional TDC Banjarmasin)Mobil luxio B 1560 PRS(operasional TDC Martapura) (via UM tanggal 2017-08-09)', 17, 'PUSAT', '2017-08-09', '2017-08-09 14:36:04', '1307690', 5, 1, 'kas_masuk'),
	(28, '006/KKPST/VIII-2017', 4, 800000, 'biaya perpanjangan surat tanda lapor mobil operasional Starindo\nMobil luxio B 1106 GKM (operasional TDC Banjarbaru)\nMobil luxio B 1107 GKM (operasional TDC Banjarbaru)\nMobil luxio B 1108 GKM (operasional TDC Pelaihari)\nMobil luxio B 1109 GKM (operasional TDC Batola)\nMobil luxio B 1110 GKM (operasional TDC Banjarmasin)\nMobil luxio B 1112 GKM (operasional TDC Banjarmasin)\nMobil luxio B 1113 GKM (operasional TDC Banjarmasin)\nMobil luxio B 1560 PRS(operasional TDC Martapura)', 4, 'PUSAT', '2017-08-09', '2017-08-09 14:36:04', '1307690', 4, 1, 'kas_keluar'),
	(29, '007/KKPST/VIII-2017', 12, 200000, 'Pembelian BBM untuk mobil avanza DA 7918 AU (km. 19726)', 5, 'PUSAT', '2017-08-09', '2017-08-09 14:37:33', '1307690', 4, 1, 'kas_keluar'),
	(30, '008/KKPST/VIII-2017', 5, 60000, 'Biaya konsumsi an Thomas, driver, security utk ambil uang ke BJB, MTP dan PLH', 4, 'PUSAT', '2017-08-09', '2017-08-09 14:37:33', '1307690', 4, 1, 'kas_keluar'),
	(31, '009/KKPST/VIII-2017', 13, 4358500, 'Uang muka pembelian ATK untuk bulan Desember 2016', 1, 'PUSAT', '2017-08-09', '2017-08-09 14:37:33', '1307690', 11, 1, 'kas_keluar'),
	(32, '010/KKPST/VIII-2017', 8, 45000, 'Biaya konsumsi lembur an Noor aida, Cisil dan Yanti tgl 1 Desember 2016', 3, 'PUSAT', '2017-08-09', '2017-08-09 14:40:08', '1307690', 4, 1, 'kas_keluar'),
	(33, '011/KKPST/VIII-2017', 9, 350000, 'Biaya instruktur senam zumba tgl 3 Desember 2016', 10, 'PUSAT', '2017-08-09', '2017-08-09 14:40:08', '1307690', 4, 1, 'kas_keluar'),
	(34, '012/KKPST/VIII-2017', 1, 400000, 'Uang muka pembelian catridge printer canon untuk Bp. Rahman', 1, 'PUSAT', '2017-08-09', '2017-08-09 14:42:56', '1307690', 5, 1, 'kas_keluar'),
	(35, '013/KKPST/VIII-2017', 10, 25000, 'Biaya sumbangan untuk  Mitra AD', 10, 'PUSAT', '2017-08-09', '2017-08-09 14:41:38', '1307690', 4, 1, 'kas_keluar'),
	(36, '014/KKPST/VIII-2017', 11, 38500, 'Biaya kliring mandiri an PT Carus Indonesia', 12, 'PUSAT', '2017-08-09', '2017-08-09 14:41:38', '1307690', 4, 1, 'kas_keluar'),
	(37, '003/KMPST/VIII-2017', 1, 400000, 'Pengembalian UM pembelian catridge printer canon untuk Bp. Rahman (via UM tanggal 2017-08-09)', 17, 'PUSAT', '2017-08-09', '2017-08-09 14:42:56', '1307690', 5, 1, 'kas_masuk'),
	(38, '015/KKPST/VIII-2017', 1, 378000, 'pembelian catridge printer canon untuk Bp. Rahman', 1, 'PUSAT', '2017-08-09', '2017-08-09 14:42:56', '1307690', 4, 1, 'kas_keluar'),
	(39, '016/KKPST/VIII-2017', 14, 60000, 'Pembelian air galon @ 5.000 (12 galon)', 12, 'PUSAT', '2017-08-09', '2017-08-09 14:43:41', '1307690', 4, 1, 'kas_keluar'),
	(40, '017/KKPST/VIII-2017', 15, 45000, 'Biaya konsumsi lembur an Noor aida, Cisil dan Yanti tgl 2 Desember 2016', 3, 'PUSAT', '2017-08-09', '2017-08-09 14:43:41', '1307690', 4, 1, 'kas_keluar'),
	(41, '018/KKPST/VIII-2017', 9, 244713, 'Pembelian BBM untuk mobil luxio B 1113 GKM (km. 10123)', 12, 'PUSAT', '2017-08-09', '2017-08-09 14:43:41', '1307690', 4, 1, 'kas_keluar'),
	(42, '019/KKPST/VIII-2017', 16, 150000, 'Biaya jaga malam untuk bulan Desember 2016', 1, 'PUSAT', '2017-08-09', '2017-08-09 14:43:41', '1307690', 4, 1, 'kas_keluar'),
	(43, '020/KKPST/VIII-2017', 9, 960000, 'Uang muka pembelian solar untuk genset besar kantor Starindo', 12, 'PUSAT', '2017-08-11', '2017-08-11 05:08:01', '1307690', 5, 1, 'kas_keluar'),
	(44, '021/KKPST/VIII-2017', 17, 70000, 'Biaya sampah untuk bulan Desember 2016', 1, 'PUSAT', '2017-08-09', '2017-08-09 14:45:38', '1307690', 4, 1, 'kas_keluar'),
	(45, '004/KMPST/VIII-2017', 9, 960000, 'Pengembalian UM pembelian solar untuk genset besar kantor Starindo (via UM tanggal 2017-08-09)', 17, 'PUSAT', '2017-08-11', '2017-08-11 05:08:01', '1307690', 5, 10, 'kas_masuk'),
	(46, '022/KKPST/VIII-2017', 9, 780000, 'pembelian solar untuk genset besar kantor Starindo', 12, 'PUSAT', '2017-08-11', '2017-08-11 05:08:01', '1307690', 4, 10, 'kas_keluar'),
	(47, '023/KKPST/VIII-2017', 18, 45000, 'Biaya konsumsi lembur an Noor aida, Cisil dan Yanti tgl 3 Desember 2016', 3, 'PUSAT', '2017-08-11', '2017-08-11 05:08:34', '1307690', 4, 10, 'kas_keluar'),
	(48, '013/KKBJM/VIII-2017', 20, 250000, 'Pembelian BBM untuk mobil luxio B 1112 GKM (km.19068)', 5, 'CABANG', '2017-08-11', '2017-08-11 10:18:10', '1307690', 4, 10, 'kas_keluar'),
	(49, '014/KKBJM/VIII-2017', 20, 23000, 'Biaya parkir', 1, 'CABANG', '2017-08-11', '2017-08-11 10:18:10', '1307690', 4, 10, 'kas_keluar'),
	(50, '007/KMBJM/VIII-2017', 1, 210000, 'Pengembalian UM pembelian kabel LAN,  keyboard dan mouse untuk Batola (via UM tanggal 2017-08-09)', 17, 'CABANG', '2017-08-11', '2017-08-11 10:19:25', '1307690', 5, 10, 'kas_masuk'),
	(51, '015/KKBJM/VIII-2017', 1, 225000, 'pembelian kabel LAN,  keyboard dan mouse untuk Batola', 1, 'CABANG', '2017-08-11', '2017-08-11 10:19:25', '1307690', 4, 10, 'kas_keluar'),
	(52, '016/KKBJM/VIII-2017', 20, 250000, 'Pembelian BBM untuk mobil luxio B 1112 GKM (km. 19381)', 5, 'CABANG', '2017-08-11', '2017-08-11 10:20:05', '1307690', 4, 10, 'kas_keluar'),
	(53, '017/KKBJM/VIII-2017', 23, 1050000, 'Uang muka biaya konsumsi tamu undian September Ceria tgl 10 Desember 2016', 12, 'CABANG', '2017-08-11', '2017-08-11 10:27:22', '1307690', 11, 10, 'kas_keluar'),
	(54, '008/KMBJM/VIII-2017', 7, 5000000, 'Dropping kas Operasional Cab. Bjm bulan Desember 2016 (Tahap III)', 15, 'CABANG', '2017-08-11', '2017-08-11 10:28:20', '1307690', 12, 10, 'kas_masuk'),
	(55, '018/KKBJM/VIII-2017', 21, 120000, 'Biaya konsumsi lembur an Leo driver dan security tgl 5-6-7-8-9 Desember 2016', 3, 'CABANG', '2017-08-11', '2017-08-11 10:30:31', '1307690', 4, 10, 'kas_keluar'),
	(56, '024/KKPST/VIII-2017', 1, 550000, 'Uang muka pembelian batterai UPS untuk komputer gerai Banjarbaru\nUang muka biaya update program multi aktivasi raden soft', 1, 'PUSAT', '2017-08-11', '2017-08-11 10:35:52', '1307690', 11, 10, 'kas_keluar'),
	(57, '025/KKPST/VIII-2017', 11, 5000, 'Biaya ADM BCA an Asep Saepuloh (update program multi aktivasi raden soft)', 1, 'PUSAT', '2017-08-11', '2017-08-11 10:35:52', '1307690', 4, 10, 'kas_keluar'),
	(58, '026/KKPST/VIII-2017', 19, 56000, 'Biaya kirim dokumen Bp. Rahman ke BPP', 1, 'PUSAT', '2017-08-11', '2017-08-11 10:38:22', '1307690', 4, 10, 'kas_keluar'),
	(59, '027/KKPST/VIII-2017', 2, 2500000, 'Biaya entertainmen Bp. Adji', 10, 'PUSAT', '2017-08-11', '2017-08-11 10:38:22', '1307690', 4, 10, 'kas_keluar'),
	(60, '028/KKPST/VIII-2017', 11, 38500, 'Biaya kliring an PT Carus Indonesia', 1, 'PUSAT', '2017-08-11', '2017-08-11 10:38:22', '1307690', 4, 10, 'kas_keluar'),
	(61, '029/KKPST/VIII-2017', 5, 60000, 'Biaya konsumsi an Thomas, driver, security utk ambil uang ke BJB, MTP dan PLH', 4, 'PUSAT', '2017-08-11', '2017-08-11 10:38:22', '1307690', 4, 10, 'kas_keluar');
/*!40000 ALTER TABLE `kas_operasional` ENABLE KEYS */;


-- Dumping structure for table koperasional.pengguna_kas
CREATE TABLE IF NOT EXISTS `pengguna_kas` (
  `idPengguna` tinyint(4) NOT NULL AUTO_INCREMENT,
  `namaPengguna` varchar(20) DEFAULT NULL,
  `alamatPengguna` text,
  `nomorTelpon` varchar(12) DEFAULT NULL,
  `tgglTambah` date DEFAULT NULL,
  `id_user_kasir` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idPengguna`),
  KEY `userTambah` (`id_user_kasir`),
  CONSTRAINT `FK_pengguna_kas_user_kasir` FOREIGN KEY (`id_user_kasir`) REFERENCES `user_kasir` (`idUserKasir`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- Dumping data for table koperasional.pengguna_kas: ~23 rows (approximately)
/*!40000 ALTER TABLE `pengguna_kas` DISABLE KEYS */;
INSERT INTO `pengguna_kas` (`idPengguna`, `namaPengguna`, `alamatPengguna`, `nomorTelpon`, `tgglTambah`, `id_user_kasir`) VALUES
	(1, 'yandi', 'kampung melayu', '081253102019', '2017-07-25', '1307690'),
	(2, 'Bp. Rahman', 'Kampung Melayu', '081253102019', '2017-07-26', '1307690'),
	(3, 'Apriana', 'Sungai Andai', '081253102019', '2017-07-27', '1307690'),
	(4, 'Roni HRD', 'Sungai Andai', '081253102019', '2017-07-27', '1307690'),
	(5, 'Thomas Penagihan', 'Sungai Tabuk', '081253102019', '2017-07-27', '1307690'),
	(6, 'Atika HRD', 'Kampung Gadang', '081253102019', '2017-07-27', '1307690'),
	(7, 'MAN 6666', 'Bank Mandiri', '081253102019', '2017-07-28', '1307690'),
	(8, 'Yanti Kasir', 'Banjarmasin', '081253102019', '2017-07-28', '1307690'),
	(9, 'yoseph HRD', 'Jalan Pramuka', '081253102019', '2017-07-28', '1307690'),
	(10, 'Dantom Keamanan', 'Banjarmasin', '081253102019', '2017-07-28', '1307690'),
	(11, 'Yitno Keuangan', 'Kampung melayu', '081253102019', '2017-07-28', '1307690'),
	(12, 'Syahruji driver', 'Banjarmasin', '081253102019', '2017-07-28', '1307690'),
	(13, 'Reni HRD', 'Banjarmasin', '081253102019', '2017-07-28', '1307690'),
	(14, 'Ratno OB', 'Banjarmasin', '081253102019', '2017-08-03', '1307690'),
	(15, 'Noor Aida Keuangan', 'Banjarmasin', '081253102019', '2017-08-03', '1307690'),
	(16, 'Japar', 'Banjarmasin', '081253102019', '2017-08-03', '1307690'),
	(17, 'Bento', 'Banjarmasin', '081253102019', '2017-08-03', '1307690'),
	(18, 'Cissil Top Gun Pusat', 'Banjarmasin', '081253102019', '2017-08-04', '1307690'),
	(19, 'Dedy OB', 'Banjarmasin', '081253102019', '2017-08-04', '1307690'),
	(20, 'Kamarudin Driver', 'Kampung melayu', '081253102019', '2017-08-09', '1307690'),
	(21, 'Leo Driver', 'Belitung', '081253102019', '2017-08-09', '1307690'),
	(22, 'Bp Ganjar Telkom', 'Banjarmasin', '08114112323', '2017-08-09', '1307690'),
	(23, 'Puteri Adela T-Sel', 'Sungai Andai', '08125114747', '2017-08-11', '1307690');
/*!40000 ALTER TABLE `pengguna_kas` ENABLE KEYS */;


-- Dumping structure for table koperasional.saldo_kas
CREATE TABLE IF NOT EXISTS `saldo_kas` (
  `id_saldo_kas` int(10) NOT NULL AUTO_INCREMENT,
  `bagian` char(6) DEFAULT NULL,
  `saldo_akhir` int(9) DEFAULT '0',
  `tggl_periode` date DEFAULT NULL,
  `waktu_update` datetime DEFAULT NULL,
  `keterangan` text,
  `id_user_kasir` varchar(10) DEFAULT NULL,
  `status_saldo` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_saldo_kas`),
  KEY `status_saldo` (`status_saldo`),
  KEY `FK_saldo_kas_user_kasir` (`id_user_kasir`),
  CONSTRAINT `FK_saldo_kas_status_kas` FOREIGN KEY (`status_saldo`) REFERENCES `status_kas` (`id_kas`) ON UPDATE CASCADE,
  CONSTRAINT `FK_saldo_kas_user_kasir` FOREIGN KEY (`id_user_kasir`) REFERENCES `user_kasir` (`idUserKasir`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='untuk melihat data saldo awal periode dan saldo closing kas.';

-- Dumping data for table koperasional.saldo_kas: ~6 rows (approximately)
/*!40000 ALTER TABLE `saldo_kas` DISABLE KEYS */;
INSERT INTO `saldo_kas` (`id_saldo_kas`, `bagian`, `saldo_akhir`, `tggl_periode`, `waktu_update`, `keterangan`, `id_user_kasir`, `status_saldo`) VALUES
	(9, 'PUSAT', 10029250, '2016-07-16', '2017-07-16 10:42:52', 'saldo awal', '1307690', 2),
	(10, 'PUSAT', 10029250, '2017-07-15', '2017-07-16 10:42:52', 'saldo awal Closing', '1307690', 1),
	(11, 'CABANG', 6236553, '2017-07-16', '2017-07-16 10:42:52', 'saldo awal', '1307690', 2),
	(12, 'CABANG', 6236553, '2017-07-15', '2017-07-16 10:42:52', 'saldo awal Closing', '1307690', 1),
	(13, 'PUSAT', 5948037, '2017-08-09', '2017-08-09 14:46:18', 'Closing', '1307690', 1),
	(14, 'CABANG', 5315853, '2017-08-09', '2017-08-11 05:01:38', 'Closing', '1307690', 1);
/*!40000 ALTER TABLE `saldo_kas` ENABLE KEYS */;


-- Dumping structure for table koperasional.status_kas
CREATE TABLE IF NOT EXISTS `status_kas` (
  `id_kas` tinyint(4) NOT NULL AUTO_INCREMENT,
  `status_kas` varchar(20) NOT NULL,
  KEY `id_kas` (`id_kas`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='closing\r\nsaldo awal periode\r\npengembalian/ biaya / realisasi.\r\nDropping / Setoran\r\nbiaya\r\nuang muka\r\nsudah bayar\r\nbelum bayar';

-- Dumping data for table koperasional.status_kas: ~10 rows (approximately)
/*!40000 ALTER TABLE `status_kas` DISABLE KEYS */;
INSERT INTO `status_kas` (`id_kas`, `status_kas`) VALUES
	(1, 'closing'),
	(2, 'saldo awal periode'),
	(3, 'pengembalian'),
	(4, 'biaya'),
	(5, 'realisasi'),
	(8, 'sudah bayar'),
	(9, 'belum bayar'),
	(10, 'belum closing'),
	(11, 'uang muka'),
	(12, 'kas masuk');
/*!40000 ALTER TABLE `status_kas` ENABLE KEYS */;


-- Dumping structure for table koperasional.stok_kas
CREATE TABLE IF NOT EXISTS `stok_kas` (
  `waktu_tambah` datetime DEFAULT NULL,
  `tggl_kas` date DEFAULT NULL,
  `bagian` char(6) DEFAULT NULL,
  `kertas100` int(8) DEFAULT NULL,
  `kertas50` int(8) DEFAULT NULL,
  `kertas20` int(6) DEFAULT NULL,
  `kertas10` int(6) DEFAULT NULL,
  `kertas5` int(6) DEFAULT NULL,
  `kertas2` int(5) DEFAULT NULL,
  `kertas1` int(5) DEFAULT NULL,
  `logam1000` int(5) DEFAULT NULL,
  `logam500` int(4) DEFAULT NULL,
  `logam200` int(4) DEFAULT NULL,
  `logam100` int(4) DEFAULT NULL,
  `keterangan` text,
  `user_kasir` varchar(10) DEFAULT NULL,
  KEY `user_kasir` (`user_kasir`),
  CONSTRAINT `FK_stok_kas_user_kasir` FOREIGN KEY (`user_kasir`) REFERENCES `user_kasir` (`idUserKasir`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table koperasional.stok_kas: ~2 rows (approximately)
/*!40000 ALTER TABLE `stok_kas` DISABLE KEYS */;
INSERT INTO `stok_kas` (`waktu_tambah`, `tggl_kas`, `bagian`, `kertas100`, `kertas50`, `kertas20`, `kertas10`, `kertas5`, `kertas2`, `kertas1`, `logam1000`, `logam500`, `logam200`, `logam100`, `keterangan`, `user_kasir`) VALUES
	('2017-08-09 14:46:18', '2017-08-09', 'PUSAT', 0, 5100000, 200000, 420000, 210000, 6000, 1000, 6000, 2000, 1600, 1700, 'Closing', '1307690'),
	('2017-08-11 05:01:38', '2017-08-09', 'CABANG', 0, 4600000, 380000, 200000, 90000, 26000, 9000, 6000, 3500, 2000, 1200, 'Closing', '1307690');
/*!40000 ALTER TABLE `stok_kas` ENABLE KEYS */;


-- Dumping structure for table koperasional.user_kasir
CREATE TABLE IF NOT EXISTS `user_kasir` (
  `idUserKasir` varchar(10) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `pic` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idUserKasir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='status_user (1 = aktif, 0 = non aktif)';

-- Dumping data for table koperasional.user_kasir: ~2 rows (approximately)
/*!40000 ALTER TABLE `user_kasir` DISABLE KEYS */;
INSERT INTO `user_kasir` (`idUserKasir`, `nama`, `user_name`, `pwd`, `last_login`, `pic`) VALUES
	('1307690', 'Riandy Fedrianto', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2017-08-14 13:57:37', '30602.jpg'),
	('5566789', 'Global User', 'global', '5ef035d11d74713fcb36f2df26aa7c3d', NULL, '443703.png');
/*!40000 ALTER TABLE `user_kasir` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
