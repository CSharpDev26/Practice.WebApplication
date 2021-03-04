-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: webapplication-database
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cimek`
--

DROP TABLE IF EXISTS `cimek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cimek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `irsz` int(11) NOT NULL,
  `varos` varchar(100) NOT NULL,
  `utca` varchar(100) NOT NULL,
  `hazszam` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  CONSTRAINT `cimek_ibfk_1` FOREIGN KEY (`fid`) REFERENCES `felhasznalok` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cimek`
--

LOCK TABLES `cimek` WRITE;
/*!40000 ALTER TABLE `cimek` DISABLE KEYS */;
INSERT INTO `cimek` VALUES (1,1,7897,'VALAMI','VALAMI',7),(2,2,6756,'VALAMI','VALAMI',7),(16,21,6782,'mora','iskola',2);
/*!40000 ALTER TABLE `cimek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `felhasznalok`
--

DROP TABLE IF EXISTS `felhasznalok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `felhasznalok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `veznev` varchar(100) NOT NULL,
  `keresztnev` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `aktivalokod` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `felhasznalok`
--

LOCK TABLES `felhasznalok` WRITE;
/*!40000 ALTER TABLE `felhasznalok` DISABLE KEYS */;
INSERT INTO `felhasznalok` VALUES (1,'ADMIN','ADMIN','papdis@gmail.com','$2y$10$62IZVjDwwec9aELDXaW4c.dl/wpbcoKa6PUdr5JsNRl5B.KrhgFhy','aktivalva'),(2,'DOLGOZO','DOLGOZO','papdis1@gmail.com','$2y$10$KjAzJebGD/NOBduw7uVMQepjfZK8poEN9nVR2l4O5x/Lzj3b5LPtK','aktivalva'),(21,'Papdi','Lászlóné','papdine67@gmail.com','$2y$10$JpRBRA2nXVqDuV17HEGEYuvd67SLoBGq5aZQk1bzsb6rzgEUTfady','aktivalva');
/*!40000 ALTER TABLE `felhasznalok` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kommentek`
--

DROP TABLE IF EXISTS `kommentek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kommentek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `komment` varchar(10000) NOT NULL,
  `olvasott` varchar(30) NOT NULL DEFAULT 'Nem',
  `datum` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  CONSTRAINT `kommentek_ibfk_1` FOREIGN KEY (`fid`) REFERENCES `felhasznalok` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kommentek`
--

LOCK TABLES `kommentek` WRITE;
/*!40000 ALTER TABLE `kommentek` DISABLE KEYS */;
INSERT INTO `kommentek` VALUES (1,21,'sfasfasfasfasgasg agsaag a ags a','Igen','2021-02-23 17:18:38'),(2,21,'saggag afg ags ag ','Igen','2021-02-23 17:18:38'),(88,21,'safas','Igen','2021-02-26 13:48:26'),(89,21,'safas','Igen','2021-02-26 13:48:58'),(90,21,'safas','Igen','2021-02-26 13:48:59'),(91,21,'asdasd','Igen','2021-02-26 14:26:22'),(92,21,'da','Igen','2021-02-26 14:26:52'),(93,21,'asf','Igen','2021-02-26 14:29:26'),(94,1,'sfsafafa','Nem','2021-03-03 12:27:00');
/*!40000 ALTER TABLE `kommentek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rendelesek`
--

DROP TABLE IF EXISTS `rendelesek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rendelesek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `datum` date NOT NULL DEFAULT current_timestamp(),
  `szallitasi_koltseg` int(11) NOT NULL,
  `fizetesi_koltseg` int(11) NOT NULL,
  `vegosszeg` int(11) NOT NULL,
  `teljesitve` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  CONSTRAINT `rendelesek_ibfk_1` FOREIGN KEY (`fid`) REFERENCES `felhasznalok` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rendelesek`
--

LOCK TABLES `rendelesek` WRITE;
/*!40000 ALTER TABLE `rendelesek` DISABLE KEYS */;
INSERT INTO `rendelesek` VALUES (1,21,'2021-02-12',1200,150,30350,'igen'),(2,21,'2021-02-12',1200,0,181200,'lemondott'),(3,21,'2021-03-03',1200,150,27350,'igen');
/*!40000 ALTER TABLE `rendelesek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rendelesek_termekek`
--

DROP TABLE IF EXISTS `rendelesek_termekek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rendelesek_termekek` (
  `rendeles_id` int(11) NOT NULL,
  `termek_id` int(11) NOT NULL,
  `mennyiseg` int(11) NOT NULL,
  PRIMARY KEY (`rendeles_id`,`termek_id`),
  KEY `termek_id` (`termek_id`),
  CONSTRAINT `rendelesek_termekek_ibfk_1` FOREIGN KEY (`rendeles_id`) REFERENCES `rendelesek` (`id`),
  CONSTRAINT `rendelesek_termekek_ibfk_2` FOREIGN KEY (`termek_id`) REFERENCES `termekek` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rendelesek_termekek`
--

LOCK TABLES `rendelesek_termekek` WRITE;
/*!40000 ALTER TABLE `rendelesek_termekek` DISABLE KEYS */;
INSERT INTO `rendelesek_termekek` VALUES (1,2,5),(1,15,3),(2,19,2),(2,22,1),(3,2,2),(3,15,6);
/*!40000 ALTER TABLE `rendelesek_termekek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `termekek`
--

DROP TABLE IF EXISTS `termekek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `termekek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nev` varchar(100) NOT NULL,
  `leiras` varchar(500) NOT NULL,
  `kep` varchar(100) NOT NULL,
  `tipus` int(11) NOT NULL,
  `ar` decimal(10,0) NOT NULL,
  `akcio_nelkuli_ar` decimal(10,0) NOT NULL DEFAULT 0,
  `mennyiseg` int(11) NOT NULL,
  `datum_hozzaadva` timestamp NOT NULL DEFAULT current_timestamp(),
  `kifutott` varchar(20) NOT NULL DEFAULT 'nem',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `termekek`
--

LOCK TABLES `termekek` WRITE;
/*!40000 ALTER TABLE `termekek` DISABLE KEYS */;
INSERT INTO `termekek` VALUES (1,'1.Autógumi','sdaasfasf','termekek/michelin_primacy_3_n.jpg',2,10000,15000,20,'2021-02-06 12:20:58','nem'),(2,'Gyűrűk ura - A gyűrű szövetsége','Első Gyűrűk ura kötet','termekek/tolkien_gyuru_szovetsege.jpg',1,4000,5000,931,'2021-02-06 12:25:45','nem'),(6,'A Hobbit','A trilógia előzménye','termekek/tolkien_hobbit.jpg',1,2000,3000,20,'2021-02-09 15:14:43','nem'),(15,'Harry Potter - Félvér herceg','Hatodik kötet','termekek/harry_potter_6.jpg',1,3000,4500,510,'2021-02-10 16:24:15','nem'),(17,'Michelin gumi','Michelin gumi','termekek/michelin_1.jpg',2,10000,0,5,'2021-02-10 16:27:28','nem'),(18,'Michelin gumi v2.0','Michelin gumi','termekek/michelin_2.jpg',2,20000,24000,2,'2021-02-10 16:27:58','nem'),(19,'Pirelli gumi','Pirelli gumi','termekek/pirelli_1.jpg',2,40000,0,40,'2021-02-10 16:28:46','nem'),(20,'Pirelli gumi v2.0','Pirelli gumi','termekek/pirelli_2.jpg',2,10000,16000,10,'2021-02-10 16:29:09','igen'),(21,'Óra','Óra','termekek/vegyes_ora.jpg',3,1000,0,50,'2021-02-10 16:29:51','nem'),(22,'Telefon','Telefon','termekek/vegyes_telefon.jpg',3,100000,150000,0,'2021-02-10 16:30:32','nem'),(23,'Hangfal','Hangfal','termekek/vegyes_hangfal.jpg',3,40000,45000,20,'2021-02-10 16:32:52','igen'),(37,'Witcher - Az utolsó kivánság','Az első kötet','termekek/witcher_1.jpg',1,4000,5000,0,'2021-02-23 15:26:47','igen'),(40,'Gyűrűk ura - Trilógia','Három kötet egyben.','termekek/tolkien_trilogia.jpg',1,4000,0,570,'2021-02-23 15:45:13','nem'),(41,'Harry Potter - A bölcek köve','Első kötet.','termekek/harry_potter_1.jpg',1,4000,0,40,'2021-02-23 15:46:07','nem'),(42,'Harry Potter - Titkok kamrája','Második kötet','termekek/harry_potter_2.jpg',1,2500,4000,40,'2021-02-23 15:46:44','nem'),(43,'Harry Potter - Az aszkabani fogoly','Harmadik kötet.','termekek/harry_potter_3.jpg',1,2000,4000,50,'2021-02-23 15:47:20','nem'),(44,'Harry Potter - Tűz serlege','Negyedik kötet.','termekek/harry_potter_4.jpg',1,3000,4000,40,'2021-02-23 15:47:49','nem'),(45,'Harry Potter - Főnix rendje','Ötödik kötet.','termekek/harry_potter_5.jpg',1,4000,5000,40,'2021-02-23 15:48:20','nem'),(46,'Harry Potter - Halál ereklyéi','Hetedik kötet.','termekek/harry_potter_7.jpg',1,5000,6000,40,'2021-02-23 15:48:49','nem'),(48,'Gyűrűk Ura - A két torony','Második kötet','termekek/tolkien_ket_torony.jpg',1,4000,0,40,'2021-02-23 16:01:04','nem'),(49,'Gyűrűk Ura - A király visszatér','Harmadik kötet','termekek/tolkien_kiraly_visszater.jpg',1,3000,5000,46,'2021-02-23 16:01:23','nem'),(53,'Witcher - A végzet kardja','m','termekek/witcher_2.jpg',1,4000,0,50,'2021-02-25 16:54:08','nem');
/*!40000 ALTER TABLE `termekek` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-04 14:57:31
