-- MySQL dump 10.13  Distrib 5.6.26, for Win32 (x86)
--
-- Host: localhost    Database: raport_6771
-- ------------------------------------------------------
-- Server version	5.6.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `raport_6771`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `raport_6771` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `raport_6771`;

--
-- Table structure for table `agama_6771`
--

DROP TABLE IF EXISTS `agama_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agama_6771` (
  `id_agama` int(2) NOT NULL AUTO_INCREMENT,
  `agama` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_agama`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agama_6771`
--

LOCK TABLES `agama_6771` WRITE;
/*!40000 ALTER TABLE `agama_6771` DISABLE KEYS */;
INSERT INTO `agama_6771` VALUES (1,'Islam'),(2,'Shinto'),(3,'Kristen'),(4,'Katolik'),(5,'Budha'),(6,'Hindu');
/*!40000 ALTER TABLE `agama_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guru_6771`
--

DROP TABLE IF EXISTS `guru_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guru_6771` (
  `kode_guru` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `nip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nama` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `telepon` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci,
  `photo` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`kode_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru_6771`
--

LOCK TABLES `guru_6771` WRITE;
/*!40000 ALTER TABLE `guru_6771` DISABLE KEYS */;
INSERT INTO `guru_6771` VALUES ('agoes1','928174431','Drs. Agoes Soeprijanto','087321221','Solo','1986-02-15','Jln. PKI Uni Soviet',NULL),('akb1',NULL,'Ju Jingyi','08921`','Beijing','2009-12-30','Islamabad',NULL),('asu1','1233211','Miyawaki Sakura','0121121','Kagoshima','2000-07-15','Kagoshima, japan','./assets/images/guru/8de01b3689f4ef4064036b617d8ec13c.jpg'),('dewi1',NULL,'Dewi Trisnasari, S.Pd','08912373812','Solo','1976-07-03','Jln. Mbuh',NULL),('endng1',NULL,'Endang Sukarningsih, S.Pd','0892348271','Denhag','1987-11-20','Jln. Pegangsaan Timur no. 13','./assets/images/guru/c21a60b778e8da98f212e29c4dbbfc82.jpg'),('ikkehx',NULL,'Ahmad Fahrozzi','467541','Jakarta','1961-03-09','Jln. Gay','./assets/images/guru/ae4a22a825a35cda2b020f028de9c212.jpg'),('jawa1',NULL,'Esti Dian Firstyani, S.Pd','0891248743','Demak','2016-02-04','Jln. Bhs Jawa','./assets/images/guru/1ba666b65c0a5314e9276ecca968ca24.jpg'),('JKT48','','Nabila Ratna Ayu','44322','Jakarta','2000-07-05','addad','./assets/images/guru/b4c0500669dedc6f09196efb0ad15e92.jpg'),('kalim1',NULL,'Kalim, S.Pd','08213443910','Semarang','1985-10-05','Jln. Metafore no. 43','./assets/images/guru/d4ae2e046db9c1f35ac49511045184a5.jpg'),('kode1',NULL,'Muhammad Farizal','08331333','Solo','1986-07-02','Jln. jendral sudir\'man',NULL),('kwu1',NULL,'Drs. Budi Prastowo','456931','Tokyo','1984-10-24','Jln. Kewirausahaan Rak Dadi',NULL),('math1','1839221`','Dra. Almiati, M.Si','444782','Jakarta','1984-07-04','Jln. Integral Persamaan Kuadrat',NULL),('MBUH','11111','Herp','934433','Trash','2016-01-16','dddd','./assets/images/guru/3f15d42aae050a2a7277354f7ca336ae.jpg'),('mc-21',NULL,'Azazel Di Raziel','08331333','Hell','1982-07-07','asadasdas',NULL),('msfh1',NULL,'Mushofan, S.Ag','444891','Semarang','1980-02-20','Jln. Onta Arab','./assets/images/guru/98829d384eda8956a9844ffc3d32906c.jpg'),('rpl1',NULL,'Dian Nirmala Santi, S.Kom','081991474811','Semarang','1981-08-20','Jln. Hacker Programmer no. 666',NULL),('rpl2','9282746293','Fitriyanto Santi Nugroho, SE','08912487431','Semarang','1970-04-29','Jln. Pemrograman Grafik','./assets/images/guru/d66d57cea0bc437f6cbaa3557aa8b358.jpg'),('rpl3',NULL,'Nuning Minarsih, S.Pd, M.Kom','08919993910','Semarang','1975-08-31','Jln. Mbuh Gak Roh',NULL),('rpl4',NULL,'Fajar Wahyu Nugroho, S.Kom','085923474812','Semarang','1981-12-29','Jln. Gay','./assets/images/guru/d3bee4ee2c7607ae7cfcc3ffd967e6ad.jpg'),('rpl5',NULL,'Rusminar Asih Oktavia, S.Kom','08567213494','Pati','1990-07-12','Jln. Mbuh Gak Roh','./assets/images/guru/273294f462e77a50ea26e3e35ba283a5.jpg'),('snh49','333211','333','333','333','2015-09-01','333','./assets/images/guru/632095b92cadc710d4d01788ff974bbe.jpg'),('sriyani1','188301100','Sriyani Widiastuti, S.pd','081923474812','Kudus','1952-12-06','Jln. Mbuh Gak Roh','./assets/images/guru/6a98d84af98d5b0d0ec8a56d032331bf.jpg'),('susilo1',NULL,'Susilo Purwanto, SH','085192331','London','1990-02-23','Jln. Simple Past Tense Had Been','./assets/images/guru/2512f8e7be8ccd898f77aea9aef23111.jpg');
/*!40000 ALTER TABLE `guru_6771` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_guru_insert` AFTER INSERT ON `guru_6771` FOR EACH ROW insert into tr_log_aktivitas values('insert',concat('Guru dgn kode \'',new.kode_guru,'\' telah dibuat'),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_guru_edit` BEFORE UPDATE ON `guru_6771` FOR EACH ROW insert into tr_log_aktivitas values('update',concat('Guru dgn kode \'',old.kode_guru,'\' telah diupdate'),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_guru_hapus` BEFORE DELETE ON `guru_6771` FOR EACH ROW insert into tr_log_aktivitas values('delete',concat('Guru dgn kode \'',old.kode_guru,'\' telah dihapus'),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `guru_mengajar_6771`
--

DROP TABLE IF EXISTS `guru_mengajar_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guru_mengajar_6771` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `kode_guru` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `kd_mapel` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `nip` (`kode_guru`),
  CONSTRAINT `guru_mengajar_6771_ibfk_1` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `guru_mengajar_6771_ibfk_2` FOREIGN KEY (`kode_guru`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guru_mengajar_6771`
--

LOCK TABLES `guru_mengajar_6771` WRITE;
/*!40000 ALTER TABLE `guru_mengajar_6771` DISABLE KEYS */;
INSERT INTO `guru_mengajar_6771` VALUES (10,'JKT48','c1'),(11,'JKT48','c2'),(12,'snh49','c2'),(14,'rpl3','pbo'),(15,'rpl1','pwd'),(16,'rpl2','kprpl'),(17,'rpl4','bd'),(18,'rpl5','abd'),(19,'msfh1','a5'),(20,'agoes1','pkn'),(21,'kalim1','indo'),(22,'math1','mtk'),(23,'endng1','a2'),(24,'susilo1','inggris'),(25,'sriyani1','senbud'),(26,'dewi1','penjas'),(27,'kwu1','kwu'),(28,'jawa1','jawa'),(29,'rpl1','a3'),(30,'rpl2','grafik'),(31,'agoes1','a2');
/*!40000 ALTER TABLE `guru_mengajar_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurusan_6771`
--

DROP TABLE IF EXISTS `jurusan_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jurusan_6771` (
  `id_jurusan` int(3) NOT NULL AUTO_INCREMENT,
  `nama_jurusan` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nama_full` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kode_diklat` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_jurusan`),
  KEY `kode_diklat` (`kode_diklat`),
  CONSTRAINT `jurusan_6771_ibfk_1` FOREIGN KEY (`kode_diklat`) REFERENCES `mata_diklat_6771` (`kode_mata_diklat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurusan_6771`
--

LOCK TABLES `jurusan_6771` WRITE;
/*!40000 ALTER TABLE `jurusan_6771` DISABLE KEYS */;
INSERT INTO `jurusan_6771` VALUES (1,'RPL','Rekayasa Perangkat Lunak','TKI'),(2,'MM','Multimedia','TKI'),(3,'TKJ','Teknik Komputer dan Jaringan','TKI');
/*!40000 ALTER TABLE `jurusan_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas_6771`
--

DROP TABLE IF EXISTS `kelas_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kelas_6771` (
  `id_kelas` int(3) NOT NULL AUTO_INCREMENT,
  `prefix_kelas` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `kd_jurusan` int(3) NOT NULL,
  `nomor_kelas` int(1) NOT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `kd_jurusan` (`kd_jurusan`),
  CONSTRAINT `kelas_6771_ibfk_1` FOREIGN KEY (`kd_jurusan`) REFERENCES `jurusan_6771` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas_6771`
--

LOCK TABLES `kelas_6771` WRITE;
/*!40000 ALTER TABLE `kelas_6771` DISABLE KEYS */;
INSERT INTO `kelas_6771` VALUES (4,'XI',1,1),(5,'XI',1,2),(6,'XI',1,3),(7,'XII',1,1),(8,'XII',1,2),(10,'X',2,1),(11,'X',2,2),(12,'X',2,3),(13,'XI',2,1),(14,'XI',2,2),(16,'XII',2,1),(17,'XII',2,2),(18,'XII',2,3),(19,'X',3,1),(20,'X',3,2),(21,'XI',3,1),(23,'XII',1,3),(24,'X',1,2),(25,'X',1,1),(35,'XI',3,2);
/*!40000 ALTER TABLE `kelas_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelompok_mapel_6771`
--

DROP TABLE IF EXISTS `kelompok_mapel_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kelompok_mapel_6771` (
  `kode_kelompok` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `nama_kelompok_mapel` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`kode_kelompok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelompok_mapel_6771`
--

LOCK TABLES `kelompok_mapel_6771` WRITE;
/*!40000 ALTER TABLE `kelompok_mapel_6771` DISABLE KEYS */;
INSERT INTO `kelompok_mapel_6771` VALUES ('A','Adaptif'),('B','Normatif'),('C','Peminatan');
/*!40000 ALTER TABLE `kelompok_mapel_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mapel_6771`
--

DROP TABLE IF EXISTS `mapel_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mapel_6771` (
  `kode_mapel` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nama_mapel` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`kode_mapel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mapel_6771`
--

LOCK TABLES `mapel_6771` WRITE;
/*!40000 ALTER TABLE `mapel_6771` DISABLE KEYS */;
INSERT INTO `mapel_6771` VALUES ('a2','Sejarah Indonesia'),('a3','Pemrograman Bergerak'),('a5','Pendidikan Agama dan Budi'),('abd','Administrasi Basis Data'),('arab','Bahasa Arab'),('bd','Basis Data'),('c1','Matematika'),('c2','Bahasa Jepang'),('c3','Bahasa Arab'),('c4','Pemrograman Grafik'),('grafik','Pemrograman Grafik'),('indo','Bahasa Indonesia'),('inggris','Bahasa Inggris'),('jawa','Bahasa Jawa'),('kprpl','Kerja Proyek Rekayasa Perangkat Lunak'),('kwu','Prakarya dan Kewirausahaan'),('mtk','Matematika'),('pbo','Pemrograman Berorientasi Objek'),('penjas','Pendidikan Jasmani, Olahraga, dan Kesehatan'),('pkn','Pendidikan Pancasila dan Kewarganegaraan'),('ppb','Pemrograman Perangkat Bergeraak'),('pwd','Pemrograman Web Dinamis'),('sejarah','Sejarah Indonesia'),('senbud','Seni Budaya');
/*!40000 ALTER TABLE `mapel_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mata_diklat_6771`
--

DROP TABLE IF EXISTS `mata_diklat_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mata_diklat_6771` (
  `kode_mata_diklat` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nama_mata_diklat` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`kode_mata_diklat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mata_diklat_6771`
--

LOCK TABLES `mata_diklat_6771` WRITE;
/*!40000 ALTER TABLE `mata_diklat_6771` DISABLE KEYS */;
INSERT INTO `mata_diklat_6771` VALUES ('TKI','Teknik Komputer dan Informatika');
/*!40000 ALTER TABLE `mata_diklat_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai_portofolio_6771`
--

DROP TABLE IF EXISTS `nilai_portofolio_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nilai_portofolio_6771` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `kd_mapel` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `semester` int(2) DEFAULT NULL,
  `tahun_ajaran` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nilai` float NOT NULL,
  `kd_guru_penilai` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `kd_guru_penilai` (`kd_guru_penilai`),
  CONSTRAINT `nilai_portofolio_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_portofolio_6771_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_portofolio_6771_ibfk_3` FOREIGN KEY (`kd_guru_penilai`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_portofolio_6771`
--

LOCK TABLES `nilai_portofolio_6771` WRITE;
/*!40000 ALTER TABLE `nilai_portofolio_6771` DISABLE KEYS */;
INSERT INTO `nilai_portofolio_6771` VALUES (4,'7099','jawa',2,'2015-2016',78,'jawa1'),(5,'2222','pwd',1,'2016-2017',100,'rpl1'),(6,'6745','a3',1,'2015-2016',98,'rpl1'),(7,'6771','a3',1,'2015-2016',90,'rpl1'),(8,'6771','inggris',2,'2014-2015',100,'susilo1'),(9,'6771','inggris',2,'2014-2015',98,'susilo1'),(10,'6771','inggris',1,'2015-2016',98,'susilo1'),(11,'6771','inggris',1,'2015-2016',100,'susilo1'),(12,'6771','pkn',1,'2015-2016',98,'agoes1'),(13,'6771','indo',1,'2015-2016',100,'kalim1'),(14,'6771','mtk',1,'2015-2016',98,'math1'),(15,'6771','senbud',1,'2015-2016',98,'sriyani1'),(16,'6771','jawa',1,'2015-2016',98,'jawa1'),(17,'6771','pwd',1,'2015-2016',98,'rpl1'),(18,'6771','pwd',1,'2015-2016',9,'rpl1'),(19,'6771','pwd',1,'2015-2016',97,'rpl1'),(20,'6771','pwd',1,'2015-2016',97,'rpl1');
/*!40000 ALTER TABLE `nilai_portofolio_6771` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiportofolio_insert` AFTER INSERT ON `nilai_portofolio_6771` FOR EACH ROW insert into tr_log_aktivitas VALUES('insert',concat('NIS \'',new.nis,'\' diberi nilai Portofolio ',new.nilai,' di kd_mapel \'',new.kd_mapel,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiportofolio_edit` AFTER UPDATE ON `nilai_portofolio_6771` FOR EACH ROW begin
if old.nilai<>new.nilai then
insert into tr_log_aktivitas VALUES('update',concat('Nilai Portofolio di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.nilai,'\' ke \'',new.nilai,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.semester<>new.semester then 
insert into tr_log_aktivitas VALUES('update',concat('Semester nilai Portofolio di kd_mapel \'',old.kd_mapel,'\' diupdate dari ',old.semester,' ke ',new.semester,' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.tahun_ajaran<>new.tahun_ajaran then 
insert into tr_log_aktivitas VALUES('update',concat('Tahun ajaran nilai Portofolio di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.tahun_ajaran,'\' ke \'',new.tahun_ajaran,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiportofolio_hapus` BEFORE DELETE ON `nilai_portofolio_6771` FOR EACH ROW INSERT into tr_log_aktivitas VALUES('delete',concat('Nilai Portofolio \'',old.nilai,'\' di kd_mapel \'',old.kd_mapel,'\' dihapus di NIS \'',old.nis,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `nilai_praktek_6771`
--

DROP TABLE IF EXISTS `nilai_praktek_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nilai_praktek_6771` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `kd_mapel` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `semester` int(2) DEFAULT NULL,
  `tahun_ajaran` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nilai` float NOT NULL,
  `kd_guru_penilai` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `kd_guru_penilai` (`kd_guru_penilai`),
  CONSTRAINT `nilai_praktek_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_praktek_6771_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_praktek_6771_ibfk_3` FOREIGN KEY (`kd_guru_penilai`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_praktek_6771`
--

LOCK TABLES `nilai_praktek_6771` WRITE;
/*!40000 ALTER TABLE `nilai_praktek_6771` DISABLE KEYS */;
INSERT INTO `nilai_praktek_6771` VALUES (1,'7099','pwd',2,'2015-2016',89,'rpl1'),(2,'7099','pwd',2,'2015-2016',54,'rpl1'),(3,'7099','pwd',2,'2015-2016',64.54,'rpl1'),(4,'7099','pwd',2,'2015-2016',90.5,'rpl1'),(5,'7099','pwd',2,'2015-2016',100,'rpl1'),(7,'6771','pwd',2,'2015-2016',90,'rpl1'),(8,'6771','pwd',2,'2015-2016',100,'rpl1'),(9,'6771','pwd',2,'2015-2016',100,'rpl1'),(10,'6771','pwd',2,'2015-2016',100,'rpl1'),(11,'6771','pwd',2,'2015-2016',100,'rpl1'),(14,'6771','pwd',1,'2015-2016',100,'rpl1'),(15,'6745','a3',1,'2015-2016',99,'rpl1'),(16,'6745','a3',1,'2015-2016',98,'rpl1'),(17,'6771','a3',1,'2015-2016',98,'rpl1'),(18,'6771','inggris',2,'2014-2015',100,'susilo1'),(19,'6771','inggris',2,'2014-2015',98.5,'susilo1'),(20,'6771','inggris',1,'2015-2016',98,'susilo1'),(21,'6771','inggris',1,'2015-2016',98,'susilo1'),(22,'6771','pkn',1,'2015-2016',98,'agoes1'),(23,'6771','pkn',1,'2015-2016',100,'agoes1'),(24,'6771','indo',1,'2015-2016',100,'kalim1'),(25,'6771','mtk',1,'2015-2016',98,'math1'),(26,'6771','senbud',1,'2015-2016',98,'sriyani1'),(27,'6771','jawa',1,'2015-2016',98,'jawa1'),(28,'6771','pwd',1,'2015-2016',100,'rpl1');
/*!40000 ALTER TABLE `nilai_praktek_6771` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiprakter_insert` AFTER INSERT ON `nilai_praktek_6771` FOR EACH ROW insert into tr_log_aktivitas VALUES('insert',concat('NIS \'',new.nis,'\' diberi nilai Praktek ',new.nilai,' di kd_mapel \'',new.kd_mapel,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaipraktek_edit` AFTER UPDATE ON `nilai_praktek_6771` FOR EACH ROW begin
if old.nilai<>new.nilai then
insert into tr_log_aktivitas VALUES('update',concat('Nilai Praktek di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.nilai,'\' ke \'',new.nilai,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.semester<>new.semester then 
insert into tr_log_aktivitas VALUES('update',concat('Semester nilai Praktek di kd_mapel \'',old.kd_mapel,'\' diupdate dari ',old.semester,' ke ',new.semester,' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.tahun_ajaran<>new.tahun_ajaran then 
insert into tr_log_aktivitas VALUES('update',concat('Tahun ajaran nilai Praktek di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.tahun_ajaran,'\' ke \'',new.tahun_ajaran,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaipraktek_hapus` BEFORE DELETE ON `nilai_praktek_6771` FOR EACH ROW INSERT into tr_log_aktivitas VALUES('delete',concat('Nilai Praktek \'',old.nilai,'\' di kd_mapel \'',old.kd_mapel,'\' dihapus di NIS \'',old.nis,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `nilai_proyek_6771`
--

DROP TABLE IF EXISTS `nilai_proyek_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nilai_proyek_6771` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `kd_mapel` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `semester` int(2) DEFAULT NULL,
  `tahun_ajaran` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nilai` float NOT NULL,
  `kd_guru_penilai` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `kd_guru_penilai` (`kd_guru_penilai`),
  CONSTRAINT `nilai_proyek_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_proyek_6771_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_proyek_6771_ibfk_3` FOREIGN KEY (`kd_guru_penilai`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_proyek_6771`
--

LOCK TABLES `nilai_proyek_6771` WRITE;
/*!40000 ALTER TABLE `nilai_proyek_6771` DISABLE KEYS */;
INSERT INTO `nilai_proyek_6771` VALUES (4,'6745','a3',1,'2015-2016',100,'rpl1'),(5,'6745','a3',1,'2015-2016',98.4,'rpl1'),(6,'6771','a3',1,'2015-2016',98.5,'rpl1'),(7,'6771','inggris',2,'2014-2015',98.5,'susilo1'),(8,'6771','inggris',2,'2014-2015',98,'susilo1'),(9,'6771','inggris',1,'2015-2016',100,'susilo1'),(10,'6771','inggris',1,'2015-2016',98,'susilo1'),(11,'6771','pkn',1,'2015-2016',100,'agoes1'),(12,'6771','pkn',1,'2015-2016',98,'agoes1'),(13,'6771','indo',1,'2015-2016',98,'kalim1'),(14,'6771','senbud',1,'2015-2016',98,'sriyani1'),(15,'6771','jawa',1,'2015-2016',87,'jawa1'),(16,'6771','pwd',1,'2015-2016',98.5,'rpl1');
/*!40000 ALTER TABLE `nilai_proyek_6771` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiproyek_insert` AFTER INSERT ON `nilai_proyek_6771` FOR EACH ROW insert into tr_log_aktivitas VALUES('insert',concat('NIS \'',new.nis,'\' diberi nilai Proyek ',new.nilai,' di kd_mapel \'',new.kd_mapel,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiproyek_edit` AFTER UPDATE ON `nilai_proyek_6771` FOR EACH ROW begin
if old.nilai<>new.nilai then
insert into tr_log_aktivitas VALUES('update',concat('Nilai Proyek di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.nilai,'\' ke \'',new.nilai,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.semester<>new.semester then 
insert into tr_log_aktivitas VALUES('update',concat('Semester nilai Proyek di kd_mapel \'',old.kd_mapel,'\' diupdate dari ',old.semester,' ke ',new.semester,' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.tahun_ajaran<>new.tahun_ajaran then 
insert into tr_log_aktivitas VALUES('update',concat('Tahun ajaran nilai Proyek di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.tahun_ajaran,'\' ke \'',new.tahun_ajaran,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiproyek_hapus` BEFORE DELETE ON `nilai_proyek_6771` FOR EACH ROW INSERT into tr_log_aktivitas VALUES('delete',concat('Nilai Proyek \'',old.nilai,'\' di kd_mapel \'',old.kd_mapel,'\' dihapus di NIS \'',old.nis,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `nilai_sikap_6771`
--

DROP TABLE IF EXISTS `nilai_sikap_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nilai_sikap_6771` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `kd_mapel` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `semester` int(2) DEFAULT NULL,
  `tahun_ajaran` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nilai_observasi` float NOT NULL,
  `nilai_diri` float NOT NULL,
  `nilai_antarteman` float NOT NULL,
  `nilai_jurnal` float NOT NULL,
  `kd_guru_penilai` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `kd_guru_penilai` (`kd_guru_penilai`),
  CONSTRAINT `nilai_sikap_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_sikap_6771_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_sikap_6771_ibfk_3` FOREIGN KEY (`kd_guru_penilai`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_sikap_6771`
--

LOCK TABLES `nilai_sikap_6771` WRITE;
/*!40000 ALTER TABLE `nilai_sikap_6771` DISABLE KEYS */;
INSERT INTO `nilai_sikap_6771` VALUES (3,'7099','a3',1,'2015-2016',4,4,1,3,'rpl1'),(4,'6745','pwd',1,'2015-2016',2,3,2,3,'rpl1'),(6,'2222','pwd',1,'2013-2014',1,3,3,3,'rpl1'),(7,'6745','a3',1,'2015-2016',4,4,4,4,'rpl1'),(8,'6771','pwd',1,'2015-2016',4,3,3.5,3,'rpl1'),(9,'6771','a3',1,'2015-2016',4,4,3.5,4,'rpl1'),(10,'6766','pwd',1,'2016-2017',3,4,4,4,'rpl1'),(11,'6771','inggris',2,'2014-2015',3,3,4,4,'susilo1'),(12,'6771','inggris',1,'2015-2016',3,4,3.4,3.1,'susilo1'),(13,'6771','pkn',1,'2015-2016',3,3.2,3,3,'agoes1'),(14,'6771','indo',1,'2015-2016',3.5,4,4,3,'kalim1'),(15,'6771','mtk',1,'2015-2016',4,3,3,3,'math1'),(16,'6771','senbud',1,'2015-2016',4,3.3,3,3,'sriyani1'),(17,'6771','jawa',1,'2015-2016',3,3,0,4,'jawa1');
/*!40000 ALTER TABLE `nilai_sikap_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai_tugas_6771`
--

DROP TABLE IF EXISTS `nilai_tugas_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nilai_tugas_6771` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `kd_mapel` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `semester` int(2) DEFAULT NULL,
  `tahun_ajaran` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nilai` float NOT NULL,
  `kd_guru_penilai` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `kd_guru_penilai` (`kd_guru_penilai`),
  CONSTRAINT `nilai_tugas_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_tugas_6771_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_tugas_6771_ibfk_3` FOREIGN KEY (`kd_guru_penilai`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_tugas_6771`
--

LOCK TABLES `nilai_tugas_6771` WRITE;
/*!40000 ALTER TABLE `nilai_tugas_6771` DISABLE KEYS */;
INSERT INTO `nilai_tugas_6771` VALUES (1,'6771','a3',1,'2015-2016',84,'rpl1'),(4,'6771','a3',1,'2015-2016',100,'rpl1'),(5,'6771','pwd',1,'2015-2016',82.3,'rpl1'),(6,'6745','a3',1,'2015-2016',87,'rpl1'),(8,'6745','a3',1,'2015-2016',80,'rpl1'),(9,'6757','indo',1,'2015-2016',94,'kalim1'),(10,'6757','indo',1,'2015-2016',100,'kalim1'),(11,'6661','pwd',1,'2015-2016',100,'rpl1'),(12,'6661','pwd',1,'2015-2016',98,'rpl1'),(13,'6771','pwd',1,'2015-2016',100,'rpl1'),(14,'2222','pwd',1,'2014-2015',78,'rpl1'),(26,'6771','jawa',1,'2015-2016',89,'jawa1'),(27,'6771','jawa',1,'2015-2016',89,'jawa1'),(28,'6771','jawa',1,'2015-2016',100,'jawa1'),(29,'6766','pwd',1,'2015-2016',80,'rpl1'),(30,'6771','inggris',2,'2014-2015',100,'susilo1'),(31,'6771','inggris',1,'2015-2016',100,'susilo1'),(32,'6771','inggris',1,'2015-2016',98,'susilo1'),(33,'6771','a3',1,'2013-2014',100,'rpl1'),(34,'6771','a3',1,'2013-2014',98,'rpl1'),(35,'6771','pkn',1,'2015-2016',100,'agoes1'),(36,'6771','pkn',1,'2015-2016',98,'agoes1'),(37,'6771','indo',1,'2015-2016',100,'kalim1'),(38,'6771','indo',1,'2015-2016',98,'kalim1'),(39,'6771','mtk',1,'2015-2016',100,'math1'),(40,'6771','mtk',1,'2015-2016',87,'math1'),(41,'6771','senbud',1,'2015-2016',100,'sriyani1'),(42,'6771','senbud',1,'2015-2016',100,'sriyani1');
/*!40000 ALTER TABLE `nilai_tugas_6771` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilai_insert` AFTER INSERT ON `nilai_tugas_6771` FOR EACH ROW insert into tr_log_aktivitas VALUES('insert',concat('NIS \'',new.nis,'\' diberi nilai Tugas ',new.nilai,' di kd_mapel \'',new.kd_mapel,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nila_edit` AFTER UPDATE ON `nilai_tugas_6771` FOR EACH ROW begin
if old.nilai<>new.nilai then
insert into tr_log_aktivitas VALUES('update',concat('Nilai Tugas di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.nilai,'\' ke \'',new.nilai,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.semester<>new.semester then 
insert into tr_log_aktivitas VALUES('update',concat('Semester nilai Tugas di kd_mapel \'',old.kd_mapel,'\' diupdate dari ',old.semester,' ke ',new.semester,' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.tahun_ajaran<>new.tahun_ajaran then 
insert into tr_log_aktivitas VALUES('update',concat('Tahun ajaran nilai Tugas di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.tahun_ajaran,'\' ke \'',new.tahun_ajaran,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilai_hapus` BEFORE DELETE ON `nilai_tugas_6771` FOR EACH ROW INSERT into tr_log_aktivitas VALUES('delete',concat('Nilai Tugas \'',old.nilai,'\' di kd_mapel \'',old.kd_mapel,'\' dihapus di NIS \'',old.nis,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `nilai_uas_6771`
--

DROP TABLE IF EXISTS `nilai_uas_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nilai_uas_6771` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `kd_mapel` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `semester` int(2) DEFAULT NULL,
  `tahun_ajaran` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nilai` float NOT NULL,
  `kd_guru_penilai` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `kd_guru_penilai` (`kd_guru_penilai`),
  CONSTRAINT `nilai_uas_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_uas_6771_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_uas_6771_ibfk_3` FOREIGN KEY (`kd_guru_penilai`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_uas_6771`
--

LOCK TABLES `nilai_uas_6771` WRITE;
/*!40000 ALTER TABLE `nilai_uas_6771` DISABLE KEYS */;
INSERT INTO `nilai_uas_6771` VALUES (1,'6745','a2',1,'2015-2016',100,'endng1'),(2,'6673','a2',1,'2015-2016',44.3,'endng1'),(3,'6745','jawa',1,'2015-2016',89.5,'jawa1'),(5,'6771','jawa',1,'2015-2016',89,'jawa1'),(6,'6745','a3',1,'2015-2016',89.6,'rpl1'),(8,'6771','inggris',2,'2014-2015',97.5,'susilo1'),(9,'6771','inggris',1,'2015-2016',98,'susilo1'),(10,'6771','pkn',1,'2015-2016',98,'agoes1'),(11,'6771','indo',1,'2015-2016',98,'kalim1'),(12,'6771','mtk',1,'2015-2016',100,'math1'),(13,'6771','senbud',1,'2015-2016',87,'sriyani1'),(14,'6771','pwd',1,'2015-2016',100,'rpl1');
/*!40000 ALTER TABLE `nilai_uas_6771` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiuas_insert` AFTER INSERT ON `nilai_uas_6771` FOR EACH ROW insert into tr_log_aktivitas VALUES('insert',concat('NIS \'',new.nis,'\' diberi nilai UAS ',new.nilai,' di kd_mapel \'',new.kd_mapel,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiuas_edit` AFTER UPDATE ON `nilai_uas_6771` FOR EACH ROW begin
if old.nilai<>new.nilai then
insert into tr_log_aktivitas VALUES('update',concat('Nilai UAS di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.nilai,'\' ke \'',new.nilai,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.semester<>new.semester then 
insert into tr_log_aktivitas VALUES('update',concat('Semester Nilai UAS Tugas di kd_mapel \'',old.kd_mapel,'\' diupdate dari ',old.semester,' ke ',new.semester,' di NIS \'',old.nis,'\''),now(),user());
end if;
if old.tahun_ajaran<>new.tahun_ajaran then 
insert into tr_log_aktivitas VALUES('update',concat('Tahun Ajaran Nilai Tugas di kd_mapel \'',old.kd_mapel,'\' diupdate dari \'',old.tahun_ajaran,'\' ke \'',new.tahun_ajaran,'\' di NIS \'',old.nis,'\''),now(),user());
end if;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_nilaiuas_hapus` BEFORE DELETE ON `nilai_uas_6771` FOR EACH ROW INSERT into tr_log_aktivitas VALUES('delete',concat('Nilai UAS \'',old.nilai,'\' di kd_mapel \'',old.kd_mapel,'\' dihapus di NIS \'',old.nis,'\''),now(),user()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `nilai_uts_6771`
--

DROP TABLE IF EXISTS `nilai_uts_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nilai_uts_6771` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `kd_mapel` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `semester` int(2) DEFAULT NULL,
  `tahun_ajaran` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nilai` float NOT NULL,
  `kd_guru_penilai` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `kd_guru_penilai` (`kd_guru_penilai`),
  CONSTRAINT `nilai_uts_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_uts_6771_ibfk_2` FOREIGN KEY (`kd_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nilai_uts_6771_ibfk_3` FOREIGN KEY (`kd_guru_penilai`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_uts_6771`
--

LOCK TABLES `nilai_uts_6771` WRITE;
/*!40000 ALTER TABLE `nilai_uts_6771` DISABLE KEYS */;
INSERT INTO `nilai_uts_6771` VALUES (3,'6771','jawa',1,'2015-2016',100,'jawa1'),(4,'6666','pwd',2,'2015-2016',98.5,'rpl1'),(5,'6745','a3',1,'2015-2016',100,'rpl1'),(6,'6771','inggris',2,'2014-2015',98,'susilo1'),(7,'6771','inggris',1,'2015-2016',100,'susilo1'),(8,'6771','pkn',1,'2015-2016',94,'agoes1'),(9,'6771','indo',1,'2015-2016',98,'kalim1'),(10,'6771','mtk',1,'2015-2016',100,'math1'),(11,'6771','senbud',1,'2015-2016',98,'sriyani1'),(12,'6771','pwd',1,'2015-2016',98,'rpl1'),(13,'6771','a3',1,'2015-2016',100,'rpl1');
/*!40000 ALTER TABLE `nilai_uts_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ortu_siswa_6771`
--

DROP TABLE IF EXISTS `ortu_siswa_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ortu_siswa_6771` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nama_ayah` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nama_ibu` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alamat_ortu` text COLLATE utf8_unicode_ci,
  `pekerjaan_ayah` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pekerjaan_ibu` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  CONSTRAINT `ortu_siswa_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ortu_siswa_6771`
--

LOCK TABLES `ortu_siswa_6771` WRITE;
/*!40000 ALTER TABLE `ortu_siswa_6771` DISABLE KEYS */;
INSERT INTO `ortu_siswa_6771` VALUES (9,'6746','Leloutch\'','Okada Ayaka','Jln. Mbh','Hacker','Coder');
/*!40000 ALTER TABLE `ortu_siswa_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembagian_mapel_6771`
--

DROP TABLE IF EXISTS `pembagian_mapel_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembagian_mapel_6771` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `semester` int(1) NOT NULL,
  `tahun_ajaran` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `kelas_prefix` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `kd_jurusan` int(3) NOT NULL,
  `kode_mapel` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `kode_kelompok_mapel` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kode_kelompok_mapel` (`kode_kelompok_mapel`),
  KEY `kode_mapel` (`kode_mapel`),
  KEY `kd_jurusan` (`kd_jurusan`),
  CONSTRAINT `pembagian_mapel_6771_ibfk_1` FOREIGN KEY (`kode_kelompok_mapel`) REFERENCES `kelompok_mapel_6771` (`kode_kelompok`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembagian_mapel_6771_ibfk_2` FOREIGN KEY (`kode_mapel`) REFERENCES `mapel_6771` (`kode_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pembagian_mapel_6771_ibfk_3` FOREIGN KEY (`kd_jurusan`) REFERENCES `jurusan_6771` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembagian_mapel_6771`
--

LOCK TABLES `pembagian_mapel_6771` WRITE;
/*!40000 ALTER TABLE `pembagian_mapel_6771` DISABLE KEYS */;
INSERT INTO `pembagian_mapel_6771` VALUES (8,1,'2015-2016','XII',1,'a3','C'),(10,1,'2015-2016','XII',1,'a2','B'),(11,1,'2015-2016','XII',1,'pkn','A'),(12,1,'2015-2016','XII',1,'a5','A'),(13,1,'2015-2016','XII',1,'indo','A'),(14,1,'2015-2016','XII',1,'mtk','A'),(15,1,'2015-2016','XII',1,'a2','A'),(16,1,'2015-2016','XII',1,'inggris','A'),(17,1,'2015-2016','XII',1,'senbud','B'),(18,1,'2015-2016','XII',1,'penjas','B'),(19,1,'2015-2016','XII',1,'kwu','B'),(20,1,'2015-2016','XII',1,'jawa','B'),(21,1,'2015-2016','XII',1,'ppb','C'),(22,1,'2015-2016','XII',1,'grafik','C'),(23,1,'2015-2016','XII',1,'pbo','C'),(24,1,'2015-2016','XII',1,'pwd','C'),(25,1,'2015-2016','XII',1,'kprpl','C'),(26,1,'2015-2016','XII',1,'bd','C'),(27,1,'2015-2016','XII',1,'abd','C'),(28,0,'2015-2016','XI',1,'a2','C'),(29,2,'2015-2016','XII',1,'inggris','A'),(30,2,'2015-2016','XII',1,'a2','A');
/*!40000 ALTER TABLE `pembagian_mapel_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengumuman_6771`
--

DROP TABLE IF EXISTS `pengumuman_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengumuman_6771` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `gambar` text,
  `author` int(3) NOT NULL,
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  CONSTRAINT `pengumuman_6771_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user_6771` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengumuman_6771`
--

LOCK TABLES `pengumuman_6771` WRITE;
/*!40000 ALTER TABLE `pengumuman_6771` DISABLE KEYS */;
INSERT INTO `pengumuman_6771` VALUES (13,'Simple Sqli Dork Scanner','Coded in C#\r\nIDE : Visual Studio 2013\r\n\r\n...','./assets/images/pengumuman/913a19f2e2a539405bd0368eae91e6e2.png',2,'2016-02-06 21:52:43'),(14,'Auto invite software mati','Sementara Auto Invite mati,,, \r\nmohon sabar\r\nadmin masiih sibuk\r\nikkeh ikkeh','./assets/images/pengumuman/a3ea666334f7910b179acb3ef60ba126.png',2,'2016-02-06 21:57:58'),(15,'Besok libur','besok libur sampe mati',NULL,2,'2016-02-07 02:53:17'),(16,'Besok kiamat','besok kiamat\r\nmohon perbanyak dosa\r\nkurangi amal dan pahala',NULL,2,'2016-02-07 02:53:46'),(17,'Stop execution after call ...','There is a third optional parameter lets you change the behavior of the function so that it returns data as a string rather than sending it to your browser. This can be useful if you want to process the data in some way.\r\n\r\necho $this->load->view(\'myView\', \'\', TRUE);\r\n    die();',NULL,2,'2016-02-07 02:54:49'),(18,'CAPTCHA Helper','The captcha function requires the GD image library.\r\nOnly the img_path and img_url are required.\r\nIf a word is not supplied, the function will generate a random ASCII string. You might put together your own word library that you can draw randomly from.\r\nIf you do not specify a path to a TRUE TYPE font, the native ugly GD font will be used.','./assets/images/pengumuman/6e49ea607104d903f9194807d4769070.png',2,'2016-02-07 02:56:02'),(19,'Using the CAPTCHA helper','$vals = array(\r\n        \'word\'          => \'Random word\',\r\n        \'img_path\'      => \'./captcha/\',\r\n        \'img_url\'       => \'http://example.com/captcha/\',\r\n        \'font_path\'     => \'./path/to/fonts/texb.ttf\',\r\n        \'img_width\'     => \'150\',\r\n        \'img_height\'    => 30,\r\n        \'expiration\'    => 7200,\r\n        \'word_length\'   => 8,\r\n        \'font_size\'     => 16,\r\n        \'img_id\'        => \'Imageid\',\r\n        \'pool\'          => \'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ\',\r\n\r\n        // White background and border, black text and red grid\r\n        \'colors\'        => array(\r\n                \'background\' => array(255, 255, 255),\r\n                \'border\' => array(255, 255, 255),\r\n                \'text\' => array(0, 0, 0),\r\n                \'grid\' => array(255, 40, 40)\r\n        )\r\n);\r\n\r\n$cap = create_captcha($vals);\r\necho $cap[\'image\'];','./assets/images/pengumuman/de93988877f46e35b65e36adc517199d.jpg',2,'2016-02-07 02:57:30'),(20,'test','tet',NULL,16,'2016-02-13 13:21:55');
/*!40000 ALTER TABLE `pengumuman_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswa_6771`
--

DROP TABLE IF EXISTS `siswa_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `siswa_6771` (
  `nis` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nisn` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nama` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jen_kel` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `kd_jurusan` int(3) NOT NULL,
  `kd_kelas` int(3) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `kd_agama` int(2) NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci NOT NULL,
  `photo` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`nis`),
  KEY `kd_jurusan` (`kd_jurusan`),
  KEY `kd_kelas` (`kd_kelas`),
  KEY `kd_agama` (`kd_agama`),
  CONSTRAINT `siswa_6771_ibfk_1` FOREIGN KEY (`kd_jurusan`) REFERENCES `jurusan_6771` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `siswa_6771_ibfk_2` FOREIGN KEY (`kd_kelas`) REFERENCES `kelas_6771` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `siswa_6771_ibfk_3` FOREIGN KEY (`kd_agama`) REFERENCES `agama_6771` (`id_agama`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa_6771`
--

LOCK TABLES `siswa_6771` WRITE;
/*!40000 ALTER TABLE `siswa_6771` DISABLE KEYS */;
INSERT INTO `siswa_6771` VALUES ('2222','22222','Miyawaki Sakura\'','L','',3,19,'0000-00-00','',1,'',NULL),('6661','83434321','Lelouch vi Britaniia','L','08945673456',1,6,'1998-10-08','London',3,'Jln. Britannia Raya','./assets/images/siswa/e67c2e1c638e47ca5f585a620079c883.jpg'),('6666','82903433211','Cadis Etrama Di Raizel','L','0856781045',1,6,'1996-02-24','Paris',4,'','./assets/images/siswa/d55979d27abfcb3386a801c4c189d7e7.jpg'),('6673','99211134343','AFIF WICAKSONO','L','081586944113',1,7,'1981-02-07','Semarang',1,'Jln. Kimcil','./assets/images/siswa/0eab89251bf14acdd1325bdd9939c37d.jpg'),('6745','1111111111','ADITYA ABDUL AZIZ\'','L','0823843921',1,23,'1998-02-05','Semarang',1,'',NULL),('6746','222222222','AHMAD LUKMAN HAKIM','L','0892234342',1,23,'2000-07-08','Semarang',1,'Jln. Dota 2','./assets/images/siswa/3c7e3ce42c5c065a8dd70b65bf9e6b86.png'),('6747','3333333333','DEA ANGGRAINI','P','08284930133',1,23,'2000-02-16','Semarang',1,'Jln. Mbuh Gak Roh',NULL),('6748','4444444444','DESYA SULISTYANINGTYAS','P','0822334411',1,23,'1999-06-08','Semarang',1,'Mbuh',NULL),('6753','5555555555','KEVIN PRAYOGI','L','08331334221',1,23,'1999-08-21','Solo',4,'ASAdasd',NULL),('6757','6666666666','MATHIAS YUDHI SETYA PERMANA','L','08927262213',1,23,'1997-04-01','Denhag',1,'Jln. Shcmasdes','./assets/images/siswa/8998e24fd8d486135953a4c62b71034c.jpg'),('6766','67661814618311','Oktio Ryan Ardiyanto','L','083838622935',1,23,'1998-10-12','Semarang',1,'','./assets/images/siswa/c840801ebb6a7cdc672bab42968ab565.jpg'),('6769','9986854112','Richa Kusuma Dewi Ratna','P','089699575213',1,23,'1998-07-10','Semarang',1,'Jalan WR.Supratman',NULL),('6771','9972173789','Rieqy Muwachid Erysya','L','082138984068',1,23,'1998-07-18','Kudus',1,'Jln. Jendral Sudirman no.206 D','./assets/images/siswa/9423a496272feaea15e28f5e8aaa261f.jpg'),('6773','9331124422','hendra budi ','L','081586944113',1,8,'2016-03-02','Semarang',1,'sdf',NULL),('7099','9248674318','AGUNG WIBISONO','L','086789332133',1,4,'1999-07-29','Solo',1,'Mbuh',NULL),('9131','24324342423','Ahmad Zabidi','L','086424435214',1,25,'1942-08-08','Solo',1,'Jln. mbuh',NULL),('9798','4242','asdadasd','L','asd',1,24,'2016-02-18','asdda',4,'asdasd',NULL);
/*!40000 ALTER TABLE `siswa_6771` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_siswa_insert` AFTER INSERT ON `siswa_6771` FOR EACH ROW BEGIN
INSERT into tr_log_aktivitas VALUES('insert',concat('Siswa dgn nis \'',new.nis,'\' telah dibuat'),now(),user());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_siswa_edit` BEFORE UPDATE ON `siswa_6771` FOR EACH ROW begin
insert into tr_log_aktivitas VALUES('update',concat('Siswa dgn nis \'',old.nis,'\' telah diupdate'),now(),user());
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_log_siswa_hapus` BEFORE DELETE ON `siswa_6771` FOR EACH ROW begin
insert into tr_log_aktivitas VALUES('delete',concat('Siswa dgn nis \'',old.nis,'\' telah dihapus'), now(),user());
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `raport_6771` CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_hapus_siswa` AFTER DELETE ON `siswa_6771` FOR EACH ROW BEGIN
INSERT into tr_hapus_siswa values(OLD.nis,OLD.nisn,OLD.nama,OLD.jen_kel,OLD.no_telp,OLD.kd_jurusan,OLD.kd_kelas,OLD.tgl_lahir,OLD.tempat_lahir,OLD.kd_agama,OLD.alamat,now(),USER());
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `raport_6771` CHARACTER SET utf8 COLLATE utf8_general_ci ;

--
-- Table structure for table `submitraport_6771`
--

DROP TABLE IF EXISTS `submitraport_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `submitraport_6771` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `id_kelas` int(3) NOT NULL,
  `semester` int(2) DEFAULT NULL,
  `tahun_ajaran` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `submit` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nis` (`nis`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `submitraport_6771_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa_6771` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `submitraport_6771_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_6771` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submitraport_6771`
--

LOCK TABLES `submitraport_6771` WRITE;
/*!40000 ALTER TABLE `submitraport_6771` DISABLE KEYS */;
INSERT INTO `submitraport_6771` VALUES (1,'6745',23,1,'2015-2016',1),(2,'6757',23,1,'2015-2016',1),(3,'6766',23,1,'2015-2016',1),(4,'6771',23,1,'2013-2014',1),(5,'6771',23,1,'2015-2016',1),(6,'2222',19,1,'2014-2015',0),(7,'6661',6,1,'2015-2016',0),(8,'6771',23,2,'2014-2015',1);
/*!40000 ALTER TABLE `submitraport_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_hapus_siswa`
--

DROP TABLE IF EXISTS `tr_hapus_siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_hapus_siswa` (
  `nis` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nisn` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nama` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jen_kel` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `no_telp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `kd_jurusan` int(3) NOT NULL,
  `kd_kelas` int(3) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `kd_agama` int(2) NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci NOT NULL,
  `tgl_hapus` datetime NOT NULL,
  `user` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`nis`),
  KEY `kd_jurusan` (`kd_jurusan`),
  KEY `kd_kelas` (`kd_kelas`),
  KEY `kd_agama` (`kd_agama`),
  CONSTRAINT `tr_hapus_siswa_ibfk_1` FOREIGN KEY (`kd_jurusan`) REFERENCES `jurusan_6771` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tr_hapus_siswa_ibfk_2` FOREIGN KEY (`kd_kelas`) REFERENCES `kelas_6771` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tr_hapus_siswa_ibfk_3` FOREIGN KEY (`kd_agama`) REFERENCES `agama_6771` (`id_agama`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_hapus_siswa`
--

LOCK TABLES `tr_hapus_siswa` WRITE;
/*!40000 ALTER TABLE `tr_hapus_siswa` DISABLE KEYS */;
INSERT INTO `tr_hapus_siswa` VALUES ('1111','1111111111','Rieqy Erysya','P','',2,13,'0000-00-00','',2,'','2016-01-28 14:36:22','root@localhost'),('6712','9332112442','AKHMAD RIDHO','L','085489999123',1,8,'1989-08-04','Semarang',1,'','2016-02-09 03:16:34','root@localhost'),('888\'','222\'\'','9999\'\'','P','',2,10,'0000-00-00','',1,'','2016-01-28 15:19:42','root@localhost'),('91123','23i23123123l','3333','L','9999',2,10,'0000-00-00','',1,'','2016-02-10 11:30:33','root@localhost'),('99999','1111','','L','000',2,10,'0000-00-00','999',4,'','2016-02-10 11:30:54','root@localhost'),('999999','9999','999','P','',2,10,'0000-00-00','',1,'','2016-02-10 11:30:58','root@localhost');
/*!40000 ALTER TABLE `tr_hapus_siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tr_log_aktivitas`
--

DROP TABLE IF EXISTS `tr_log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_log_aktivitas` (
  `jenis` varchar(50) DEFAULT NULL,
  `log` text NOT NULL,
  `waktu` datetime NOT NULL,
  `user` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tr_log_aktivitas`
--

LOCK TABLES `tr_log_aktivitas` WRITE;
/*!40000 ALTER TABLE `tr_log_aktivitas` DISABLE KEYS */;
INSERT INTO `tr_log_aktivitas` VALUES ('insert','Siswa dengan nis \'6712\' telah dibuat','2016-02-09 03:03:45','root@localhost'),('update','Siswa dengan nis \'6712\' telah diupdate','2016-02-09 03:10:46','root@localhost'),('insert','Siswa dengan nis \'111\' telah dibuat','2016-02-09 03:16:24','root@localhost'),('delete','Siswa dengan nis \'6712\' telah dihapus','2016-02-09 03:16:34','root@localhost'),('delete','Siswa dengan nis \'111\' telah dihapus','2016-02-09 03:16:58','root@localhost'),('insert','Guru dengan kode_guru \'mc-21\' telah dibuat','2016-02-09 03:54:36','root@localhost'),('update','Guru dgn kode \'mc-21\' telah diupdate','2016-02-09 03:59:10','root@localhost'),('insert','NIS \'2222\' diberi nilai \'98.5\' di kd_mapel \'pwd\'','2016-02-09 09:02:28','root@localhost'),('update','Nilai di NIS \'2222\' diupdate dari 98.5 ke 98 di kd_mapel pwd','2016-02-09 09:04:39','root@localhost'),('update','Nilai di NIS \'2222\' diupdate dari 98 ke 98 di kd_mapel pwd','2016-02-09 09:04:39','root@localhost'),('insert','Siswa dgn nis \'6673\' telah dibuat','2016-02-09 10:55:55','root@localhost'),('update','Nilai di NIS \'2222\' diupdate dari 98 ke 90 di kd_mapel \'pwd\'','2016-02-09 12:37:00','root@localhost'),('update','Nilai di NIS \'2222\' diupdate dari 90 ke 90 di kd_mapel \'pwd\'','2016-02-09 12:37:00','root@localhost'),('update','Semester nilai di NIS \'2222\' diupdate dari 1 ke 2 di kd_mapel \'pwd\'','2016-02-09 13:17:04','root@localhost'),('update','Semester nilai di NIS \'2222\' diupdate dari 2 ke 1 di kd_mapel \'pwd\'','2016-02-09 13:17:39','root@localhost'),('update','Tahun ajaran nilai di NIS \'2222\' diupdate dari 2015-2016 ke 2014-2015 di kd_mapel \'pwd\'','2016-02-09 13:17:39','root@localhost'),('insert','NIS \'1220\' diberi nilai 100 di kd_mapel \'jawa\'','2016-02-09 13:24:04','root@localhost'),('insert','NIS \'1220\' diberi nilai 98 di kd_mapel \'jawa\'','2016-02-09 13:24:04','root@localhost'),('insert','Siswa dgn nis \'6773\' telah dibuat','2016-02-09 14:17:29','root@localhost'),('insert','Siswa dgn nis \'6766\' telah dibuat','2016-02-09 14:45:21','root@localhost'),('insert','NIS \'6745\' diberi nilai UAS 100 di kd_mapel \'a2\'','2016-02-09 21:08:09','root@localhost'),('insert','NIS \'6673\' diberi nilai UAS 0 di kd_mapel \'a2\'','2016-02-09 21:09:23','root@localhost'),('insert','NIS \'6745\' diberi nilai Tugas 99 di kd_mapel \'a2\'','2016-02-09 21:19:09','root@localhost'),('insert','NIS \'6745\' diberi nilai Tugas 100 di kd_mapel \'a2\'','2016-02-09 21:19:37','root@localhost'),('update','Nilai UAS di NIS \'6673\' diupdate dari 0 ke 44 di kd_mapel \'a2\'','2016-02-09 22:37:47','root@localhost'),('update','Nilai UAS di NIS \'6673\' diupdate dari 44 ke 44.3 di kd_mapel \'a2\'','2016-02-09 22:37:55','root@localhost'),('update','Semester nilai UAS di NIS \'6673\' diupdate dari 1 ke 2 di kd_mapel \'a2\'','2016-02-09 22:38:02','root@localhost'),('update','Tahun ajaran nilai UAS di NIS \'6673\' diupdate dari 2015-2016 ke 2013-2014 di kd_mapel \'a2\'','2016-02-09 22:38:09','root@localhost'),('update','Semester nilai UAS di NIS \'6673\' diupdate dari 2 ke 1 di kd_mapel \'a2\'','2016-02-09 22:56:02','root@localhost'),('update','Tahun ajaran nilai UAS di NIS \'6673\' diupdate dari 2013-2014 ke 2015-2016 di kd_mapel \'a2\'','2016-02-09 22:56:02','root@localhost'),('delete','Nilai Tugas di NIS \'1220\' dihapus','2016-02-09 23:06:04','root@localhost'),('delete','Nilai Tugas di NIS \'1220\' dihapus','2016-02-09 23:06:04','root@localhost'),('insert','NIS \'1220\' diberi nilai Tugas 31 di kd_mapel \'jawa\'','2016-02-09 23:11:34','root@localhost'),('insert','NIS \'1220\' diberi nilai Tugas 43 di kd_mapel \'jawa\'','2016-02-09 23:11:50','root@localhost'),('insert','NIS \'1220\' diberi nilai Tugas 43 di kd_mapel \'jawa\'','2016-02-09 23:11:50','root@localhost'),('insert','NIS \'1220\' diberi nilai Tugas 100 di kd_mapel \'jawa\'','2016-02-09 23:11:50','root@localhost'),('delete','Nilai Tugas \'31\' di NIS \'1220\' dihapus di kd_mapel \'jawa\'','2016-02-09 23:12:02','root@localhost'),('delete','Nilai Tugas \'43\' di NIS \'1220\' dihapus di kd_mapel \'jawa\'','2016-02-09 23:12:02','root@localhost'),('delete','Nilai Tugas \'43\' di NIS \'1220\' dihapus di kd_mapel \'jawa\'','2016-02-09 23:12:02','root@localhost'),('delete','Nilai Tugas \'100\' di NIS \'1220\' dihapus di kd_mapel \'jawa\'','2016-02-09 23:12:02','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 89.3 di kd_mapel \'jawa\'','2016-02-09 23:22:15','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 89.3 di kd_mapel \'jawa\'','2016-02-09 23:22:15','root@localhost'),('update','Nilai Tugas di kd_mapel \'jawa\' diupdate dari \'89.3\' ke \'89\' di NIS \'6771\'','2016-02-09 23:22:54','root@localhost'),('update','Nilai Tugas di kd_mapel \'jawa\' diupdate dari \'89.3\' ke \'90\' di NIS \'6771\'','2016-02-09 23:22:54','root@localhost'),('update','Nilai Tugas di kd_mapel \'jawa\' diupdate dari \'90\' ke \'100\' di NIS \'6771\'','2016-02-09 23:23:30','root@localhost'),('delete','Nilai Tugas \'89\' di kd_mapel \'jawa\' dihapus di NIS \'6771\'','2016-02-09 23:23:44','root@localhost'),('delete','Nilai Tugas \'100\' di kd_mapel \'jawa\' dihapus di NIS \'6771\'','2016-02-09 23:23:44','root@localhost'),('insert','NIS \'6745\' diberi nilai UAS 89 di kd_mapel \'jawa\'','2016-02-09 23:30:44','root@localhost'),('update','Nilai UAS di kd_mapel \'jawa\' diupdate dari \'89\' ke \'89.5\' di NIS \'6745\'','2016-02-09 23:30:56','root@localhost'),('insert','NIS \'1220\' diberi nilai UAS 100 di kd_mapel \'jawa\'','2016-02-09 23:33:16','root@localhost'),('insert','NIS \'1220\' diberi nilai Tugas 100 di kd_mapel \'jawa\'','2016-02-09 23:36:40','root@localhost'),('update','Nilai UAS di kd_mapel \'a2\' diupdate dari \'100\' ke \'0\' di NIS \'6745\'','2016-02-10 07:58:47','root@localhost'),('update','Tahun Ajaran Nilai Tugas di kd_mapel \'a2\' diupdate dari \'2015-2016\' ke \'2016-2017\' di NIS \'6745\'','2016-02-10 07:58:47','root@localhost'),('update','Nilai UAS di kd_mapel \'a2\' diupdate dari \'0\' ke \'100\' di NIS \'6745\'','2016-02-10 07:59:06','root@localhost'),('update','Tahun Ajaran Nilai Tugas di kd_mapel \'a2\' diupdate dari \'2016-2017\' ke \'2015-2016\' di NIS \'6745\'','2016-02-10 07:59:06','root@localhost'),('update','Tahun Ajaran Nilai Tugas di kd_mapel \'a2\' diupdate dari \'2015-2016\' ke \'2016-2017\' di NIS \'6745\'','2016-02-10 07:59:38','root@localhost'),('update','Tahun Ajaran Nilai Tugas di kd_mapel \'a2\' diupdate dari \'2016-2017\' ke \'2015-2016\' di NIS \'6745\'','2016-02-10 08:00:04','root@localhost'),('delete','Nilai UAS \'100\' di kd_mapel \'jawa\' dihapus di NIS \'1220\'','2016-02-10 08:09:55','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 89 di kd_mapel \'jawa\'','2016-02-10 09:40:16','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 89 di kd_mapel \'jawa\'','2016-02-10 09:40:25','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'jawa\'','2016-02-10 09:40:25','root@localhost'),('insert','NIS \'6771\' diberi nilai UAS 89 di kd_mapel \'jawa\'','2016-02-10 09:41:51','root@localhost'),('insert','Siswa dgn nis \'9131\' telah dibuat','2016-02-10 11:29:34','root@localhost'),('update','Siswa dgn nis \'91123\' telah diupdate','2016-02-10 11:30:09','root@localhost'),('delete','Siswa dgn nis \'91123\' telah dihapus','2016-02-10 11:30:33','root@localhost'),('delete','Siswa dgn nis \'99999\' telah dihapus','2016-02-10 11:30:54','root@localhost'),('delete','Siswa dgn nis \'999999\' telah dihapus','2016-02-10 11:30:58','root@localhost'),('insert','Guru dgn kode \'ikkehx\' telah dibuat','2016-02-10 11:45:52','root@localhost'),('update','Guru dgn kode \'989890\'\' telah diupdate','2016-02-10 11:46:01','root@localhost'),('delete','Guru dgn kode \'989890\'\' telah dihapus','2016-02-10 11:55:55','root@localhost'),('insert','NIS \'1220\' diberi nilai UAS 90 di kd_mapel \'pwd\'','2016-02-10 13:11:54','root@localhost'),('insert','Siswa dgn nis \'7099\' telah dibuat','2016-02-10 19:16:49','root@localhost'),('insert','NIS \'7099\' diberi nilai Portofolio 78 di kd_mapel \'jawa\'','2016-02-10 22:17:21','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 100 di kd_mapel \'pwd\'','2016-02-10 23:53:31','root@localhost'),('update','Nilai Tugas di kd_mapel \'pwd\' diupdate dari \'90\' ke \'78\' di NIS \'2222\'','2016-02-11 01:04:26','root@localhost'),('delete','Nilai Tugas \'100\' di kd_mapel \'jawa\' dihapus di NIS \'1220\'','2016-02-11 01:11:30','root@localhost'),('delete','Nilai UAS \'90\' di kd_mapel \'pwd\' dihapus di NIS \'1220\'','2016-02-11 01:15:15','root@localhost'),('insert','NIS \'2222\' diberi nilai Portofolio 100 di kd_mapel \'pwd\'','2016-02-11 08:55:34','root@localhost'),('insert','NIS \'6745\' diberi nilai UAS 89.6 di kd_mapel \'a3\'','2016-02-11 09:40:26','root@localhost'),('insert','NIS \'6745\' diberi nilai Praktek 99 di kd_mapel \'a3\'','2016-02-11 09:40:53','root@localhost'),('insert','NIS \'6745\' diberi nilai Praktek 98 di kd_mapel \'a3\'','2016-02-11 09:40:53','root@localhost'),('insert','NIS \'6745\' diberi nilai Proyek 100 di kd_mapel \'a3\'','2016-02-11 10:09:02','root@localhost'),('insert','NIS \'6745\' diberi nilai Proyek 98.4 di kd_mapel \'a3\'','2016-02-11 10:09:20','root@localhost'),('insert','NIS \'6745\' diberi nilai Portofolio 98 di kd_mapel \'a3\'','2016-02-11 10:10:35','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 98 di kd_mapel \'a3\'','2016-02-11 10:58:30','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 98.5 di kd_mapel \'a3\'','2016-02-11 10:58:57','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 90 di kd_mapel \'a3\'','2016-02-11 10:59:17','root@localhost'),('insert','NIS \'6766\' diberi nilai Tugas 80 di kd_mapel \'pwd\'','2016-02-11 13:13:09','root@localhost'),('update','Siswa dgn nis \'6766\' telah diupdate','2016-02-11 21:07:46','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'inggris\'','2016-02-12 05:20:20','root@localhost'),('insert','NIS \'1220\' diberi nilai UAS 100 di kd_mapel \'inggris\'','2016-02-12 05:22:24','root@localhost'),('insert','NIS \'6771\' diberi nilai UAS 97.5 di kd_mapel \'inggris\'','2016-02-12 05:23:57','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 100 di kd_mapel \'inggris\'','2016-02-12 05:25:13','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 98.5 di kd_mapel \'inggris\'','2016-02-12 05:25:27','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 98.5 di kd_mapel \'inggris\'','2016-02-12 05:26:03','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 98 di kd_mapel \'inggris\'','2016-02-12 05:26:20','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 100 di kd_mapel \'inggris\'','2016-02-12 05:26:46','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 98 di kd_mapel \'inggris\'','2016-02-12 05:26:46','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'inggris\'','2016-02-12 09:41:49','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 98 di kd_mapel \'inggris\'','2016-02-12 09:41:49','root@localhost'),('insert','NIS \'6771\' diberi nilai UAS 98 di kd_mapel \'inggris\'','2016-02-12 13:51:18','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 98 di kd_mapel \'inggris\'','2016-02-12 14:44:10','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 98 di kd_mapel \'inggris\'','2016-02-12 14:44:10','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 100 di kd_mapel \'inggris\'','2016-02-12 14:44:47','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 98 di kd_mapel \'inggris\'','2016-02-12 14:44:47','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 98 di kd_mapel \'inggris\'','2016-02-12 14:45:46','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 100 di kd_mapel \'inggris\'','2016-02-12 14:45:46','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'a3\'','2016-02-13 05:00:54','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 98 di kd_mapel \'a3\'','2016-02-13 05:00:54','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'pkn\'','2016-02-13 08:31:33','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 98 di kd_mapel \'pkn\'','2016-02-13 08:31:33','root@localhost'),('insert','NIS \'6771\' diberi nilai UAS 98 di kd_mapel \'pkn\'','2016-02-13 08:32:39','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 98 di kd_mapel \'pkn\'','2016-02-13 08:33:06','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 100 di kd_mapel \'pkn\'','2016-02-13 08:33:06','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 100 di kd_mapel \'pkn\'','2016-02-13 08:33:33','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 98 di kd_mapel \'pkn\'','2016-02-13 08:33:33','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 98 di kd_mapel \'pkn\'','2016-02-13 08:37:04','root@localhost'),('insert','Siswa dgn nis \'6779\' telah dibuat','2016-02-13 10:42:28','root@localhost'),('insert','Guru dgn kode \'kode1\' telah dibuat','2016-02-13 10:45:50','root@localhost'),('insert','Siswa dgn nis \'6769\' telah dibuat','2016-02-13 14:01:17','root@localhost'),('update','Siswa dgn nis \'2222\' telah diupdate','2016-02-13 15:22:54','root@localhost'),('update','Siswa dgn nis \'6745\' telah diupdate','2016-02-14 14:17:01','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'indo\'','2016-02-14 15:54:58','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 98 di kd_mapel \'indo\'','2016-02-14 15:54:58','root@localhost'),('insert','NIS \'6771\' diberi nilai UAS 98 di kd_mapel \'indo\'','2016-02-14 15:55:25','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 100 di kd_mapel \'indo\'','2016-02-14 15:55:48','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 98 di kd_mapel \'indo\'','2016-02-14 15:56:02','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 100 di kd_mapel \'indo\'','2016-02-14 15:56:19','root@localhost'),('update','Guru dgn kode \'dra1\' telah diupdate','2016-02-14 15:57:17','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'mtk\'','2016-02-14 15:58:31','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 87 di kd_mapel \'mtk\'','2016-02-14 15:58:31','root@localhost'),('insert','NIS \'6771\' diberi nilai UAS 100 di kd_mapel \'mtk\'','2016-02-14 15:59:03','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 98 di kd_mapel \'mtk\'','2016-02-14 15:59:23','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 98 di kd_mapel \'mtk\'','2016-02-14 15:59:43','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'senbud\'','2016-02-14 16:01:40','root@localhost'),('insert','NIS \'6771\' diberi nilai Tugas 100 di kd_mapel \'senbud\'','2016-02-14 16:01:53','root@localhost'),('insert','NIS \'6771\' diberi nilai UAS 87 di kd_mapel \'senbud\'','2016-02-14 16:02:18','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 98 di kd_mapel \'senbud\'','2016-02-14 16:02:32','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 98 di kd_mapel \'senbud\'','2016-02-14 16:02:47','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 98 di kd_mapel \'senbud\'','2016-02-14 16:03:00','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 98 di kd_mapel \'jawa\'','2016-02-14 16:19:06','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 87 di kd_mapel \'jawa\'','2016-02-14 16:19:23','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 98 di kd_mapel \'jawa\'','2016-02-14 16:19:36','root@localhost'),('insert','NIS \'6771\' diberi nilai Praktek 100 di kd_mapel \'pwd\'','2016-02-16 12:13:17','root@localhost'),('insert','NIS \'6771\' diberi nilai Proyek 98.5 di kd_mapel \'pwd\'','2016-02-16 12:22:06','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 98 di kd_mapel \'pwd\'','2016-02-16 12:30:19','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 9 di kd_mapel \'pwd\'','2016-02-16 12:31:43','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 97 di kd_mapel \'pwd\'','2016-02-16 12:31:46','root@localhost'),('insert','NIS \'6771\' diberi nilai Portofolio 97 di kd_mapel \'pwd\'','2016-02-16 12:31:50','root@localhost'),('insert','NIS \'6771\' diberi nilai UAS 100 di kd_mapel \'pwd\'','2016-02-16 12:36:21','root@localhost');
/*!40000 ALTER TABLE `tr_log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_6771`
--

DROP TABLE IF EXISTS `user_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_6771` (
  `id_user` int(3) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_telp` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `kd_role` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `kd_role` (`kd_role`),
  CONSTRAINT `user_6771_ibfk_1` FOREIGN KEY (`kd_role`) REFERENCES `user_role_6771` (`kode_role`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_6771`
--

LOCK TABLES `user_6771` WRITE;
/*!40000 ALTER TABLE `user_6771` DISABLE KEYS */;
INSERT INTO `user_6771` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','Rieqy Muwachid Erysya','rieqyns13@gmail.com','082138984068','admin'),(2,'1220','5f4dcc3b5aa765d61d8327deb882cf99','宮脇 桜','rieqyns13@gmail.com','098900','siswa'),(3,'JKT48','21232f297a57a5a743894a0e4a801fc3','Nabila Ratna Ayu','nabilah48@gmail.com','333003','guru'),(4,'1233211','102a6ed6587b5b8cb4ebbe972864690b','asdads','asu@google.ccom','03322','guru'),(5,'1221','102a6ed6587b5b8cb4ebbe972864690b','Ikkeh Ikkeh','ikkeh@gmail.com','032433323','siswa'),(6,'989890\'','102a6ed6587b5b8cb4ebbe972864690b','Ordering results\'','gmail@fbi.gov','444684','guru'),(7,'333211','71a4d4cd2f30b185d707718273b17d05','Lorem Ipsum Dolor Sit Amet','lorem@ipsum.com','456431','guru'),(8,'akb1','71a4d4cd2f30b185d707718273b17d05','Paypal Checker','service@paypal.com','989890809','guru'),(9,'rpl1','f97de4a9986d216a6e0fea62b0450da9','Dian Nirmala Santi','mbokbawel@gmail.com','0891238271`','guru'),(10,'susilo1','102a6ed6587b5b8cb4ebbe972864690b','Susilo Purwanto','susilo.mastah@gmail.','085560589491','guru'),(11,'kalim1','6a79564b3d00f85ca3aae5c990346b93','Kalim','kalim.indo@gmail.com','081586944113','guru'),(12,'endng1','7565a1fb1ffd44d62ba851ce3540b5e4','Endang Sukarningsih','endang.sejarah@gmail','081586944113','guru'),(13,'jawa1','0f511511d980a0998b35d8c159ef9bec','Esti Dian Firstyani','esti.bhsjawa@gmail.c','08564331454','guru'),(14,'tatausaha','82849c85acf1f4e6e4eec748f0aeddf4','Rieqy Tatausaha','rieqymaho@gmail.com','089343321','tatausaha'),(15,'kurikulum','4e7f2477836fa0c289105740fee0ebb1','Rieqy Kurikulum','rieqy.gay@gmail.com','0853334353332','kurikulum'),(16,'6771','102a6ed6587b5b8cb4ebbe972864690b','Rieqy Muwachid Erysya','rieqyns13@gmail.com','085489999123','siswa'),(17,'6745','102a6ed6587b5b8cb4ebbe972864690b','Aditya Abdul Kodir','aditya@gmail.com','0873321331','siswa'),(18,'928174431','6e11873b9d9d94a44058bef5747735ce','Drs. Agoes Soeprijanto','agoes@gmail.com','085194554423','guru'),(19,'math1','7e676e9e663beb40fd133f5ee24487c2','Almiyati','almiyati@gmail.com','082138984068','guru'),(20,'sriyani1','8e55f38f31e89cf63b8af6ab7c37aa10','Sriyani Widiastuti, S.pd','sriyanti@gmail.com','085194554423','guru');
/*!40000 ALTER TABLE `user_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_6771`
--

DROP TABLE IF EXISTS `user_role_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role_6771` (
  `kode_role` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nama_role` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`kode_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_6771`
--

LOCK TABLES `user_role_6771` WRITE;
/*!40000 ALTER TABLE `user_role_6771` DISABLE KEYS */;
INSERT INTO `user_role_6771` VALUES ('admin','Admin'),('guru','Guru'),('kurikulum','Kurikulum'),('siswa','Siswa'),('tatausaha','Tata Usaha');
/*!40000 ALTER TABLE `user_role_6771` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `walikelas_6771`
--

DROP TABLE IF EXISTS `walikelas_6771`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `walikelas_6771` (
  `kode_guru` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `id_kelas` int(3) NOT NULL,
  PRIMARY KEY (`kode_guru`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `walikelas_6771_ibfk_1` FOREIGN KEY (`kode_guru`) REFERENCES `guru_6771` (`kode_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `walikelas_6771_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `kelas_6771` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `walikelas_6771`
--

LOCK TABLES `walikelas_6771` WRITE;
/*!40000 ALTER TABLE `walikelas_6771` DISABLE KEYS */;
INSERT INTO `walikelas_6771` VALUES ('akb1',6),('JKT48',21),('susilo1',23);
/*!40000 ALTER TABLE `walikelas_6771` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-22 16:33:18
