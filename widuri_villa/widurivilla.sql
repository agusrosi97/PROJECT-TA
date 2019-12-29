/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.8-MariaDB : Database - widurivilla
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`widurivilla` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `widurivilla`;

/*Table structure for table `tbl_pengguna` */

DROP TABLE IF EXISTS `tbl_pengguna`;

CREATE TABLE `tbl_pengguna` (
  `id_pengguna` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username_pengguna` varchar(50) DEFAULT NULL,
  `password_pengguna` char(255) DEFAULT NULL,
  `email_pengguna` varchar(50) DEFAULT NULL,
  `hak_akses_pengguna` varchar(20) DEFAULT NULL,
  `tgl_lahir_pengguna` date DEFAULT NULL,
  `no_telp_pengguna` varchar(15) DEFAULT NULL,
  `alamat_pengguna` varchar(255) DEFAULT NULL,
  `jk_pengguna` char(1) DEFAULT NULL,
  `foto_pengguna` longblob DEFAULT NULL,
  `status_pengguna` varbinary(50) DEFAULT NULL,
  PRIMARY KEY (`id_pengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_pengguna` */

insert  into `tbl_pengguna`(`id_pengguna`,`username_pengguna`,`password_pengguna`,`email_pengguna`,`hak_akses_pengguna`,`tgl_lahir_pengguna`,`no_telp_pengguna`,`alamat_pengguna`,`jk_pengguna`,`foto_pengguna`,`status_pengguna`) values 
(1,'rosi','123','agus@gmail.com','admin','2019-11-22','123','kerobokan','L','','Tidak Aktif'),
(2,'Rosi Adi','$2y$10$lJR7HUdiboCM1QZUlZdUd.LQ6ljVs2ibmli15Aw.fP.XYcm.T0Eme','admin@gmail.com','admin','2019-11-22','123','kerobokan','L','','Aktif'),
(3,'Purwibawa','$2y$10$zYmg/ciqpc3znk7brhxAlOfNlMHcQb6Wi9bRnoXemeqSsvw6bHl.e','staf@gmail.com','staf','2019-11-22','123','kerobokan','L','','Aktif'),
(4,'gus rosi','$2y$10$9ur/mTAbfW0QjEfa6eSdHek/0hh.7M8Axi5cp7EhdCP38Szbh0AVG','staf@gmail.com2','staf','2019-11-22','123','kerobokan','L','','Aktif'),
(5,'Agus Rosi Adi Purwibawa','$2y$10$TMiuWs4rn8w7UCCiSyyQMeuHj3ghTpoKkL/Cs932s7tGLzFQK4ICS','owner@gmail.com','owner','1997-09-25','123','kerobokan','L','5dfc2202e19a9.png','Aktif');

/*Table structure for table `tbl_reservasi` */

DROP TABLE IF EXISTS `tbl_reservasi`;

CREATE TABLE `tbl_reservasi` (
  `id_reservasi` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tamu` int(11) DEFAULT NULL,
  `id_pengguna` int(11) unsigned DEFAULT NULL,
  `tgl_checkin` date DEFAULT NULL,
  `tgl_checkout` date DEFAULT NULL,
  `jumlah_hari` int(5) DEFAULT NULL,
  `tipe_kamar` varchar(255) DEFAULT NULL,
  `jumlah_kamar_perPilihan` varchar(255) DEFAULT NULL,
  `jumlah_kamar` int(5) DEFAULT NULL,
  `jumlah_orang` int(5) DEFAULT NULL,
  `jumlah_anak` int(5) DEFAULT NULL,
  `jam_reservasi` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_reservasi`),
  KEY `melakukan1` (`id_tamu`),
  KEY `mengelola1` (`id_pengguna`),
  KEY `index_reservasi` (`tgl_checkin`,`tgl_checkout`,`jam_reservasi`),
  CONSTRAINT `melakukan1` FOREIGN KEY (`id_tamu`) REFERENCES `tbl_tamu` (`id_tamu`),
  CONSTRAINT `mengelolla` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id_pengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_reservasi` */

insert  into `tbl_reservasi`(`id_reservasi`,`id_tamu`,`id_pengguna`,`tgl_checkin`,`tgl_checkout`,`jumlah_hari`,`tipe_kamar`,`jumlah_kamar_perPilihan`,`jumlah_kamar`,`jumlah_orang`,`jumlah_anak`,`jam_reservasi`) values 
(1,1,3,'2019-11-23','2019-11-25',2,'-','0',0,3,0,'2019-11-22 20:50:37'),
(2,2,3,'2019-11-24','2019-11-26',2,'1, 2','1, 1',2,0,0,'2019-11-22 23:09:49'),
(3,3,3,'2019-11-23','2019-11-25',2,'1','1',1,2,0,'2019-11-23 03:19:06'),
(4,3,3,'2019-11-25','2019-11-27',2,'2','1',1,2,0,'2019-11-23 22:16:12'),
(5,4,3,'2019-11-24','2019-11-27',3,'2','1',1,1,0,'2019-11-23 22:42:05'),
(6,4,3,'2019-11-23','2019-11-25',2,'2','1',1,2,0,'2019-11-23 22:46:05'),
(7,5,3,'2019-11-23','2019-11-25',2,'1','2',2,3,0,'2019-11-23 23:06:44'),
(8,4,3,'2019-11-24','2019-11-26',2,'-','0',0,1,1,'2019-11-23 23:27:32'),
(9,4,3,'2019-11-25','2019-11-27',2,'-','0',0,2,0,'2019-11-23 23:29:53'),
(10,4,NULL,'2019-11-25','2019-11-27',2,'-','0',0,2,0,'2019-11-23 23:47:56'),
(11,4,3,'2019-11-23','2019-11-25',2,'1','1',1,1,0,'2019-11-23 23:49:58'),
(12,1,3,'2019-11-24','2019-11-25',1,'1','1',1,2,0,'2019-11-24 00:12:38'),
(13,2,3,'2019-11-25','2019-11-27',2,'1','1',1,2,0,'2019-11-24 00:14:38'),
(14,1,3,'2019-11-25','2019-11-28',3,'2','1',1,2,0,'2019-11-24 00:15:55'),
(15,9,5,'2019-11-24','2019-11-26',2,'1','1',1,2,0,'2019-11-24 23:28:39'),
(16,8,5,'2019-11-25','2019-11-27',2,'2','1',1,2,0,'2019-11-25 00:23:35'),
(17,4,5,'2019-11-28','2019-11-30',2,'1','1',1,0,0,'2019-11-25 16:27:09'),
(18,5,5,'2019-11-25','2019-11-27',2,'2','1',1,0,0,'2019-11-25 16:41:54'),
(19,2,5,'2019-11-26','2019-11-28',2,'2','1',1,2,0,'2019-11-25 16:51:52'),
(20,2,5,'2019-11-28','2019-11-30',2,'1','1',1,2,0,'2019-11-27 21:11:07'),
(21,9,5,'2019-11-29','2019-12-01',2,'1','1',1,2,0,'2019-11-28 14:16:46'),
(22,3,5,'2019-12-02','2019-12-04',2,'1','1',1,2,0,'2019-12-02 01:05:04'),
(23,2,5,'2019-12-04','2019-12-11',2,'1, 2','1, 1',2,2,1,'2019-12-09 23:12:49'),
(24,10,3,'2019-12-05','2019-12-08',3,'2','1',1,1,0,'2019-12-08 19:40:38'),
(25,2,3,'2019-12-08','2019-12-12',4,'1','1',1,1,0,'2019-12-08 20:35:16'),
(26,1,5,'2019-12-07','2019-12-09',2,'1','1',1,2,0,'2019-12-08 19:41:36'),
(27,2,5,'2019-12-10','2019-12-14',4,'1, 2','1, 1',2,2,0,'2019-12-09 22:59:05'),
(28,11,5,'2019-12-16','2019-12-19',3,'1','1',1,2,0,'2019-12-16 11:40:17'),
(29,9,5,'2019-12-14','2019-12-17',3,'2','1',1,2,0,'2019-12-14 02:01:35'),
(30,9,5,'2019-12-20','2019-12-23',3,'1','1',1,0,0,'2019-12-20 18:03:29'),
(31,2,5,'2019-12-23','2019-12-26',3,'2','1',1,2,0,'2019-12-24 15:59:28'),
(32,2,NULL,'2019-12-21','2019-12-23',2,'2','1',1,0,0,'2019-12-20 15:18:21');

/*Table structure for table `tbl_tamu` */

DROP TABLE IF EXISTS `tbl_tamu`;

CREATE TABLE `tbl_tamu` (
  `id_tamu` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tamu` varchar(50) DEFAULT NULL,
  `tgl_lahir_tamu` date DEFAULT NULL,
  `email_tamu` varchar(50) DEFAULT NULL,
  `password_tamu` char(255) DEFAULT NULL,
  `no_telp_tamu` varchar(15) DEFAULT NULL,
  `alamat_tamu` varchar(255) DEFAULT NULL,
  `jk_tamu` char(1) DEFAULT NULL,
  `foto_tamu` longblob DEFAULT NULL,
  `date_create` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tamu`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_tamu` */

insert  into `tbl_tamu`(`id_tamu`,`nama_tamu`,`tgl_lahir_tamu`,`email_tamu`,`password_tamu`,`no_telp_tamu`,`alamat_tamu`,`jk_tamu`,`foto_tamu`,`date_create`) values 
(1,'Komang','2019-11-22','agusrosiadi.p@gmail.com','$2y$10$evIfWzZbtoHy7LqCVZ.CVuOA8KTC34EnWmDRIBlS0kMBXx3EICLIG','08123232322','Kerobokan','L','5dd7ff380c5f5.png','2019-11-24 22:48:30'),
(2,'Agus Rosi','2019-11-22','agusrosiadi.p@gmail.com2','$2y$10$eenwaWHnvWlM08FmR6k0..YB4ACD9zOz4NnUIqH9TAcQPSkmY3zbK','081236573725','Tabanan','L','5dda5541b4559.jpg','2019-11-24 22:48:30'),
(3,'Rosi Adi','2019-11-05','agusrosiadi.p@gmail.com3','$2y$10$wkJa0hRX7CopWOZP8mgXsuT9xcB1JF/ZIsjNLa3DTJG73uqPxUKo6','091819238112','Kintamani','L','','2019-11-24 22:48:30'),
(4,'Rosi','2019-11-03','agusrosiadi.p@gmail.com4','$2y$10$iHhfU/TtlyB/TJjTLLosm..6QFrxPEWkjgeOKH8fYXV0.HOVNsg8y','081236573724','Tabanan','L','','2019-11-24 22:48:30'),
(5,'Ketut','2019-11-23','agusrosiadi.p@gmail.com5','$2y$10$25Ol0e6vOXiGxJKFbvxyU.GEW0Z1FiQmYhRHhM4oXlN.UiOgKEc6i','34234','Pengubengan','L','','2019-11-24 22:48:30'),
(6,'Rosi','2019-11-24','agusrosiadi.p@gmail.com6','$2y$10$hoeuKzQhR0dwjuPNOe4C8e/X6Jc8yRSrq.SMIpmt6kD3On8T8sDBS','22','Bandung','L','','2019-11-24 22:53:20'),
(8,'Tamu 1','1997-09-25','agusrosiadi.p@gmail.com7','$2y$10$TJT16Ie1k.6BOUkb4tPtG.CjIhW18uOqss3pVFH0ThtFc8.4e.IUa','34234','Karangasem','L','','2019-11-24 23:15:11'),
(9,'Gus Rosi','1997-09-25','agusrosiadi.p@gmail.com8','$2y$10$txZPrc/kPEmwQmvbRiQ.VOJpEYdj1ixR5N4cHaSXRolrIP.06wrKe','123','Singaraja','L','','2019-11-24 23:27:46'),
(10,'Rosi','1997-03-25','agusrosiadi.p@gmail.com9','$2y$10$cCB6udl/emvcOpQ/b.URfObIeNigowT0nRKMQ2n/T6Ohiovf5/lR6','123','Jawa Timur','L','','2019-12-04 23:07:43'),
(11,'Rosi','1997-09-25','agusrosiadi.p@gmail.com1','$2y$10$cGV0P83PZw.5QnvFMvpiSO1PTV6wHKYLMYM8qjDztjVlg.EZffLoe','08123123123','Australia','L','','2019-12-12 03:07:29'),
(12,'Rosi','2019-12-10','tamu@gmail.com','$2y$10$eqjJRakeU5ZeY7Q4rc7PSuU6ouIJYsIEht0tHYHUGDf.xfH.P.fey','08179791212','Badung','L','5df7285402f79.png','2019-12-16 14:46:44');

/*Table structure for table `tbl_tipe_kamar` */

DROP TABLE IF EXISTS `tbl_tipe_kamar`;

CREATE TABLE `tbl_tipe_kamar` (
  `id_tipe_kamar` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tipe_kamar` varchar(50) DEFAULT NULL,
  `jumlah_kamar` int(10) DEFAULT NULL,
  `harga_kamar` int(20) DEFAULT NULL,
  `foto_tipe_kamar` longblob DEFAULT NULL,
  `fasilitas` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tipe_kamar`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_tipe_kamar` */

insert  into `tbl_tipe_kamar`(`id_tipe_kamar`,`nama_tipe_kamar`,`jumlah_kamar`,`harga_kamar`,`foto_tipe_kamar`,`fasilitas`) values 
(1,'Tipe Satu',9,400000,'5dd7d7afb346f.jpg','Wifi, Service kamar 24jam, Kolam renang, Dapur'),
(2,'Tipe Dua',8,800000,'5dd7d7d3418dc.jpg','Wifi, Service kamar 24jam, Kolam renang, Dapur, Gazebo');

/*Table structure for table `tbl_transaksi_pembayaran` */

DROP TABLE IF EXISTS `tbl_transaksi_pembayaran`;

CREATE TABLE `tbl_transaksi_pembayaran` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_tamu` int(11) DEFAULT NULL,
  `id_pengguna` int(11) unsigned DEFAULT NULL,
  `id_reservasi` int(11) unsigned DEFAULT NULL,
  `tipe_kamar` varchar(255) DEFAULT NULL,
  `jumlah_kamar_perPilihan` varchar(255) DEFAULT NULL,
  `total_pembayaran_kamar` int(50) DEFAULT NULL,
  `jam_transaksi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(20) DEFAULT NULL,
  `foto_bukti_transaksi` longblob DEFAULT NULL,
  `ket_transaksi` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `mengkonfirmasi1` (`id_pengguna`),
  KEY `menghasilkan1` (`id_reservasi`),
  KEY `melakukanTambahTransaksi` (`id_tamu`),
  KEY `index_transaksi` (`total_pembayaran_kamar`,`jam_transaksi`),
  CONSTRAINT `henghasilkan1` FOREIGN KEY (`id_reservasi`) REFERENCES `tbl_reservasi` (`id_reservasi`) ON DELETE CASCADE,
  CONSTRAINT `menghasilkan2` FOREIGN KEY (`id_tamu`) REFERENCES `tbl_tamu` (`id_tamu`),
  CONSTRAINT `mengkonnfirm` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id_pengguna`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_transaksi_pembayaran` */

insert  into `tbl_transaksi_pembayaran`(`id_transaksi`,`id_tamu`,`id_pengguna`,`id_reservasi`,`tipe_kamar`,`jumlah_kamar_perPilihan`,`total_pembayaran_kamar`,`jam_transaksi`,`status`,`foto_bukti_transaksi`,`ket_transaksi`) values 
(1,1,3,1,'-','0',0,'2019-11-22 22:06:27','VALID','5dd7d9cdb483c.jpg','Online'),
(2,2,NULL,2,'1, 2','1, 1',2400000,'2019-11-23 22:19:46','GAK VALID',NULL,'Offline'),
(3,3,NULL,3,'1','1',800000,'2019-11-23 22:19:43','GAK VALID',NULL,'Online'),
(4,3,3,4,'2','1',1600000,'2019-11-23 22:19:38','VALID','5dd93fd899187.jpg','Online'),
(5,4,3,5,'2','1',2400000,'2019-11-23 22:43:29','VALID','5dd9455b2af1c.jpg','Online'),
(6,4,3,6,'2','1',1600000,'2019-11-23 22:46:20','VALID','5dd945ddd2f90.jpg','Online'),
(7,5,NULL,7,'1','2',1600000,'2019-11-23 23:49:01','GAK VALID',NULL,'Offline'),
(8,4,NULL,8,'-','0',0,'2019-11-23 23:48:56','GAK VALID',NULL,'Online'),
(9,4,NULL,9,'-','0',0,'2019-11-23 23:48:52','GAK VALID',NULL,'Online'),
(10,4,NULL,10,'-','0',0,'2019-11-23 23:48:08','GAK VALID',NULL,'Online'),
(11,4,3,11,'1','1',800000,'2019-11-23 23:50:08','VALID',NULL,'Offline'),
(12,1,NULL,12,'1','1',400000,'2019-11-28 14:03:00','GAK VALID','-.png','Offline'),
(13,2,3,13,'1','1',800000,'2019-11-24 00:16:56','VALID','5dd95afce6e27.jpg','Online'),
(14,1,3,14,'2','1',2400000,'2019-11-24 00:16:52','VALID','5dd95b66d45bd.jpg','Online'),
(15,9,5,15,'1','1',800000,'2019-11-28 14:03:08','VALID','-.png','Offline'),
(16,8,5,16,'2','1',1600000,'2019-11-25 01:35:10','VALID','5ddab865b0f88.jpg','Online'),
(17,4,5,17,'1','1',800000,'2019-11-28 14:05:45','VALID','-.png','Offline'),
(18,5,5,18,'2','1',1600000,'2019-12-04 00:46:23','VALID','-.png','Offline'),
(19,2,5,19,'2','1',1600000,'2019-12-03 23:47:10','VALID','5ddb9704a0a0a.jpg','Online'),
(20,2,NULL,20,'1','1',800000,'2019-11-28 14:09:56','GAK VALID',NULL,'Online'),
(21,9,NULL,21,'1','1',800000,'2019-11-28 17:58:27','GAK VALID','-.png','Offline'),
(22,3,5,22,'1','1',800000,'2019-12-02 01:05:04','VALID','-.png','Offline'),
(23,2,5,23,'1, 2','1, 1',2400000,'2019-12-09 23:12:49','VALID','5de4d0c01819b.jpg','Online'),
(24,10,3,24,'2','1',2400000,'2019-12-08 19:40:38','VALID','-.png','Offline'),
(25,2,3,25,'1','1',1600000,'2019-12-08 20:35:16','VALID','-.png','Offline'),
(26,1,5,26,'1','1',800000,'2019-12-11 00:07:07','VALID','-.png','Offline'),
(27,2,NULL,27,'1, 2','1, 1',4800000,'2019-12-10 19:38:25','GAK VALID',NULL,'Online'),
(28,11,5,28,'1','1',1200000,'2019-12-16 11:40:17','VALID','5df14268690ef.jpg','Online'),
(29,9,5,29,'2','1',2400000,'2019-12-14 02:01:35','VALID','-.png','Offline'),
(30,9,5,30,'1','1',1200000,'2019-12-20 18:03:29','VALID','-.png','Offline'),
(31,2,5,31,'2','1',2400000,'2019-12-24 15:59:28','VALID','-.png','Offline'),
(32,2,NULL,32,'2','1',1600000,'2019-12-20 15:18:21',NULL,'-.png','Offline');

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `ubahStatus` */

/*!50106 DROP EVENT IF EXISTS `ubahStatus`*/;

DELIMITER $$

/*!50106 CREATE DEFINER=`root`@`localhost` EVENT `ubahStatus` ON SCHEDULE EVERY 2 HOUR STARTS '2019-11-17 09:07:43' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `tbl_transaksi_pembayaran` SET `status` = 'GAK VALID' WHERE `foto_bukti_transaksi` is null AND `ket_transaksi` = 'Online' */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
