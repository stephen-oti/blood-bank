/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.31 : Database - obbs
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`obbs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `obbs`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `req_id` int NOT NULL,
  `a_role` enum('admin','approval') DEFAULT NULL,
  `fname` varchar(26) NOT NULL,
  `lname` varchar(26) NOT NULL,
  `email` varchar(36) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `pword` varchar(10) DEFAULT NULL,
  `admin_status` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `req_id` (`req_id`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`req_id`) REFERENCES `reg_request` (`req_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `admin` */

insert  into `admin`(`id`,`req_id`,`a_role`,`fname`,`lname`,`email`,`phone`,`pword`,`admin_status`) values 
(1,1,'admin','Ezekiel','Mainas','ezekielmaina.me@gmail.com','0700408205','12345678',1),
(2,4,'approval','Kelvin','Wanjohi','kelv@gmail.com','0783673768','12345678',1);

/*Table structure for table `appeal_type` */

DROP TABLE IF EXISTS `appeal_type`;

CREATE TABLE `appeal_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` enum('patient','bank') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `NAME` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `appeal_type` */

insert  into `appeal_type`(`id`,`name`,`description`) values 
(1,'bank','bank to patien'),
(2,'patient','Patients to bank');

/*Table structure for table `bank_appeals` */

DROP TABLE IF EXISTS `bank_appeals`;

CREATE TABLE `bank_appeals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `appeal_type` int DEFAULT '1',
  `bank_id` int NOT NULL,
  `app_date` date DEFAULT NULL,
  `tgt_units` int NOT NULL,
  `coll_units` int DEFAULT '0',
  `app_status` int DEFAULT NULL,
  `blood_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_id` (`bank_id`),
  KEY `appeal_type` (`appeal_type`),
  KEY `bank_appeals_ibfk_3` (`blood_id`),
  CONSTRAINT `bank_appeals_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `blood_bank` (`id`),
  CONSTRAINT `bank_appeals_ibfk_2` FOREIGN KEY (`appeal_type`) REFERENCES `appeal_type` (`id`),
  CONSTRAINT `bank_appeals_ibfk_3` FOREIGN KEY (`blood_id`) REFERENCES `blood_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `bank_appeals` */

insert  into `bank_appeals`(`id`,`appeal_type`,`bank_id`,`app_date`,`tgt_units`,`coll_units`,`app_status`,`blood_id`) values 
(1,1,3,'2023-04-11',12,0,0,6),
(2,1,3,'2023-04-12',100,60,0,3),
(3,1,5,'2023-04-12',120,75,0,3),
(4,1,5,'2023-04-12',60,0,0,1);

/*Table structure for table `blood_bank` */

DROP TABLE IF EXISTS `blood_bank`;

CREATE TABLE `blood_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(36) NOT NULL,
  `email` varchar(36) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `address` varchar(52) NOT NULL,
  `county` varchar(26) NOT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `bank_status` int DEFAULT NULL,
  `officer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  KEY `officer_id` (`officer_id`),
  CONSTRAINT `blood_bank_ibfk_1` FOREIGN KEY (`officer_id`) REFERENCES `officer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `blood_bank` */

insert  into `blood_bank`(`id`,`bank_name`,`email`,`phone`,`address`,`county`,`lat`,`lon`,`bank_status`,`officer_id`) values 
(1,'Kisumu Blood Bank','kisumubb@gmail.com','0700408205','202 - 3000, Kisumu','KISUMU',NULL,NULL,0,NULL),
(2,'Luanda Vihiga BB','luandaVBB@gmail.com','+254788988399','112 - 20200, Vihiga','VIHIGA',NULL,NULL,2,NULL),
(3,'MTTRH Blood Bank','mttrh@obbs.co.ke','0789858589','                            112 - 2019, Kesse       ','ELDORET',-0.0100317,34.5892,1,1),
(4,'JOOTRH Blood Bank','jootrh@bank.gmail.com','0724579300','111 - 33333, Kisumu','KISUMU',NULL,NULL,0,NULL),
(5,'Vihiga Blood Bank','vihigabb@gmail.com','+254734343434','100 - 20100, Vihiga','VIHIGA',-1.27468,36.8345,1,2);

/*Table structure for table `blood_type` */

DROP TABLE IF EXISTS `blood_type`;

CREATE TABLE `blood_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rhesus` enum('negative','positive') NOT NULL,
  `b_group` varchar(3) NOT NULL,
  `b_name` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `b_name` (`b_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `blood_type` */

insert  into `blood_type`(`id`,`rhesus`,`b_group`,`b_name`) values 
(1,'positive','A','A+'),
(2,'negative','A','A-'),
(3,'positive','B','B+'),
(4,'negative','B','B-'),
(5,'positive','AB','AB+'),
(6,'negative','AB','AB-'),
(7,'positive','O','O+'),
(8,'negative','O','O-');

/*Table structure for table `donor` */

DROP TABLE IF EXISTS `donor`;

CREATE TABLE `donor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(26) NOT NULL,
  `lname` varchar(26) NOT NULL,
  `email` varchar(36) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `bday` date NOT NULL,
  `address` varchar(52) NOT NULL,
  `county` varchar(20) NOT NULL,
  `pword` varchar(10) DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `blood_id` int DEFAULT NULL,
  `d_cond` varchar(100) DEFAULT NULL,
  `d_report` varchar(100) DEFAULT NULL,
  `d_lat` float DEFAULT NULL,
  `d_lon` float DEFAULT NULL,
  `d_status` int DEFAULT NULL,
  `d_next` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  KEY `blood_id` (`blood_id`),
  CONSTRAINT `donor_ibfk_1` FOREIGN KEY (`blood_id`) REFERENCES `blood_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `donor` */

insert  into `donor`(`id`,`fname`,`lname`,`email`,`phone`,`bday`,`address`,`county`,`pword`,`gender`,`blood_id`,`d_cond`,`d_report`,`d_lat`,`d_lon`,`d_status`,`d_next`) values 
(2,'Samwel','Okonda','sam@gmail.com','0789989818','2000-03-22','009 - 10100, Manyatta','KISUMU','12345678','male',6,'Frequent Coughs lately','donor_0000002_1679761726.pdf',-89.9393,-39.494,1,NULL),
(3,'Gilberto','Owako','gilly@gmail.com','0798398337','1990-01-25','099 - 56762, Nakuru Town','NAKURU','12345678','male',7,'Something ailing','donor_0000003_1679775675.pdf',-0.0100164,34.5892,1,'2023-04-04'),
(4,'Samwel','Okonda','isamwel201@gmail.com','0742877831','2002-02-02','1056-50100, Kakamega','KISUMU','Samiedee3$','male',7,'None','donor_0000004_1681469549.pdf',-0.091702,34.768,1,'2023-06-17'),
(5,'Maina','Kagia','mainakag@gmail.com','0783673899','2002-07-14','4089 - 60100, Kikuyu','NYERI','12345678','male',7,'None','donor_0000005_1681474306.pdf',-0.091702,-39.494,1,NULL),
(6,'Emily','Nyasembo','emily@gmail.com','+254789688990','1985-06-12','102 - 30100, Majengo','MOMBASA','12345678','female',4,'General Headache','donor_0000006_1683221639.pdf',-1.29207,36.8219,1,'2023-06-29');

/*Table structure for table `donor_donation` */

DROP TABLE IF EXISTS `donor_donation`;

CREATE TABLE `donor_donation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bank_id` int NOT NULL,
  `bank_app_id` int DEFAULT NULL,
  `donor_id` int NOT NULL,
  `req_date` date DEFAULT NULL,
  `don_date` date DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `don_status` int DEFAULT NULL,
  `don_type` int NOT NULL,
  `blood_id` int NOT NULL,
  `comment` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_id` (`bank_id`),
  KEY `donor_id` (`donor_id`),
  KEY `bank_app_id` (`bank_app_id`),
  KEY `donor_donation_ibfk_4` (`blood_id`),
  CONSTRAINT `donor_donation_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `blood_bank` (`id`),
  CONSTRAINT `donor_donation_ibfk_2` FOREIGN KEY (`donor_id`) REFERENCES `donor` (`id`),
  CONSTRAINT `donor_donation_ibfk_3` FOREIGN KEY (`bank_app_id`) REFERENCES `bank_appeals` (`id`),
  CONSTRAINT `donor_donation_ibfk_4` FOREIGN KEY (`blood_id`) REFERENCES `blood_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `donor_donation` */

insert  into `donor_donation`(`id`,`bank_id`,`bank_app_id`,`donor_id`,`req_date`,`don_date`,`quantity`,`don_status`,`don_type`,`blood_id`,`comment`) values 
(1,3,2,3,'2023-04-12','2023-04-18',12,4,0,7,NULL),
(2,5,NULL,3,'2023-04-14',NULL,NULL,3,1,7,NULL),
(3,3,2,4,'2023-04-14','2023-04-19',24,4,0,7,NULL),
(4,5,3,4,'2023-04-14','2023-04-22',75,4,0,7,NULL),
(5,3,2,4,'2023-04-14',NULL,NULL,2,0,7,'Made more than one application'),
(6,3,2,5,'2023-04-14',NULL,NULL,3,0,7,NULL),
(7,3,NULL,3,'2023-05-03',NULL,NULL,0,1,7,NULL),
(8,5,NULL,6,'2023-05-04','2023-05-04',50,4,1,4,NULL);

/*Table structure for table `inter_bank` */

DROP TABLE IF EXISTS `inter_bank`;

CREATE TABLE `inter_bank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `req_bank` int NOT NULL,
  `appr_bank` int NOT NULL,
  `req_date` date NOT NULL,
  `pouch_id` int DEFAULT NULL,
  `req_status` int DEFAULT NULL,
  `comments` varchar(256) DEFAULT NULL,
  `appr_date` date DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `req_bank` (`req_bank`),
  KEY `appr_bank` (`appr_bank`),
  KEY `pouch_id` (`pouch_id`),
  CONSTRAINT `inter_bank_ibfk_1` FOREIGN KEY (`req_bank`) REFERENCES `blood_bank` (`id`),
  CONSTRAINT `inter_bank_ibfk_2` FOREIGN KEY (`appr_bank`) REFERENCES `blood_bank` (`id`),
  CONSTRAINT `inter_bank_ibfk_3` FOREIGN KEY (`pouch_id`) REFERENCES `pouch` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `inter_bank` */

insert  into `inter_bank`(`id`,`req_bank`,`appr_bank`,`req_date`,`pouch_id`,`req_status`,`comments`,`appr_date`,`quantity`) values 
(2,5,3,'2023-04-23',1002,1,'Transfer completed','2023-04-26',10),
(3,5,3,'2023-04-23',1003,2,'sawa','2023-04-25',5),
(4,3,5,'2023-05-04',1008,1,'Transfer completed','2023-05-04',45);

/*Table structure for table `officer` */

DROP TABLE IF EXISTS `officer`;

CREATE TABLE `officer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `req_id` int NOT NULL,
  `fname` varchar(26) NOT NULL,
  `lname` varchar(26) NOT NULL,
  `email` varchar(36) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `pword` varchar(10) DEFAULT NULL,
  `o_status` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `req_id` (`req_id`),
  CONSTRAINT `officer_ibfk_1` FOREIGN KEY (`req_id`) REFERENCES `reg_request` (`req_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `officer` */

insert  into `officer`(`id`,`req_id`,`fname`,`lname`,`email`,`phone`,`pword`,`o_status`) values 
(1,2,'Stephen','Otieno','steph@gmail.com','0787398939','12345678',1),
(2,6,'Jamila','Mohamed','jam@gmail.com','0799699300','12345678',1);

/*Table structure for table `patient` */

DROP TABLE IF EXISTS `patient`;

CREATE TABLE `patient` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(26) NOT NULL,
  `lname` varchar(26) NOT NULL,
  `email` varchar(36) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `bday` date NOT NULL,
  `address` varchar(52) NOT NULL,
  `county` varchar(20) NOT NULL,
  `pword` varchar(10) DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `blood_id` int DEFAULT NULL,
  `p_cond` varchar(100) DEFAULT NULL,
  `p_report` varchar(100) DEFAULT NULL,
  `p_lat` float DEFAULT NULL,
  `p_lon` float DEFAULT NULL,
  `p_status` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  KEY `blood_id` (`blood_id`),
  CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`blood_id`) REFERENCES `blood_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `patient` */

insert  into `patient`(`id`,`fname`,`lname`,`email`,`phone`,`bday`,`address`,`county`,`pword`,`gender`,`blood_id`,`p_cond`,`p_report`,`p_lat`,`p_lon`,`p_status`) values 
(1,'Vincent','onyango','otieno@tmail.com','0999933344','2023-03-22','2002-40103, maseno','KISUMU','1234','male',8,'None','patient_0000001_1679667454.pdf',-0.091703,34.768,1),
(10,'Sharon','Odhiambo','sha@gmail.com','0799645598','2003-08-17','137 - 80100, Odera Street','KISUMU','12345678','female',1,'None','patient_0000010_1679687657.pdf',-1.27468,36.8345,1),
(12,'Millicent','Akiniyi','millieaki@gmail.com','+254119564568','1994-06-24','2012 - 40103, Sirongo','SIAYA','12345678','female',1,'None','patient_0000012_1679671799.pdf',-0.091702,34.768,1),
(13,'Kennedy','Kilim','kenn@gmail.com','0789837883','2000-01-27','098 - 78890, Kisumu','KISII','12345678','male',5,'Gasping for breath','patient_0000013_1680091945.pdf',-0.0100317,34.5892,1);

/*Table structure for table `patient_appeal` */

DROP TABLE IF EXISTS `patient_appeal`;

CREATE TABLE `patient_appeal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `appeal_type` int DEFAULT '2',
  `app_date` date DEFAULT NULL,
  `bank_id` int DEFAULT NULL,
  `blood_id` int DEFAULT NULL,
  `units` int NOT NULL,
  `site` varchar(52) DEFAULT NULL,
  `app_status` int DEFAULT NULL,
  `patient_id` int DEFAULT NULL,
  `comment` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appeal_type` (`appeal_type`),
  KEY `bank_id` (`bank_id`),
  KEY `blood_id` (`blood_id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `patient_appeal_ibfk_1` FOREIGN KEY (`appeal_type`) REFERENCES `appeal_type` (`id`),
  CONSTRAINT `patient_appeal_ibfk_2` FOREIGN KEY (`bank_id`) REFERENCES `blood_bank` (`id`),
  CONSTRAINT `patient_appeal_ibfk_3` FOREIGN KEY (`blood_id`) REFERENCES `blood_type` (`id`),
  CONSTRAINT `patient_appeal_ibfk_4` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `patient_appeal` */

insert  into `patient_appeal`(`id`,`appeal_type`,`app_date`,`bank_id`,`blood_id`,`units`,`site`,`app_status`,`patient_id`,`comment`) values 
(1,2,'2023-04-19',3,7,14,NULL,4,13,NULL),
(2,2,'2023-05-03',5,7,20,NULL,0,10,NULL),
(3,2,'2023-05-03',5,7,20,NULL,0,12,'Competing needs');

/*Table structure for table `pouch` */

DROP TABLE IF EXISTS `pouch`;

CREATE TABLE `pouch` (
  `id` int NOT NULL AUTO_INCREMENT,
  `donor_id` int NOT NULL,
  `blood_id` int NOT NULL,
  `units` int NOT NULL,
  `fill_date` date DEFAULT NULL,
  `pouch_status` int DEFAULT NULL,
  `bank_id` int NOT NULL,
  `donation_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `donor_id` (`donor_id`),
  KEY `blood_id` (`blood_id`),
  KEY `bank_id` (`bank_id`),
  KEY `donation_id` (`donation_id`),
  CONSTRAINT `pouch_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donor` (`id`),
  CONSTRAINT `pouch_ibfk_2` FOREIGN KEY (`blood_id`) REFERENCES `blood_type` (`id`),
  CONSTRAINT `pouch_ibfk_3` FOREIGN KEY (`bank_id`) REFERENCES `blood_bank` (`id`),
  CONSTRAINT `pouch_ibfk_4` FOREIGN KEY (`donation_id`) REFERENCES `donor_donation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1009 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `pouch` */

insert  into `pouch`(`id`,`donor_id`,`blood_id`,`units`,`fill_date`,`pouch_status`,`bank_id`,`donation_id`) values 
(1002,3,7,12,'2023-04-18',1,5,1),
(1003,4,7,24,'2023-04-19',3,3,3),
(1007,4,7,75,'2023-04-22',1,5,4),
(1008,6,4,50,'2023-05-04',1,3,8);

/*Table structure for table `questionnaire` */

DROP TABLE IF EXISTS `questionnaire`;

CREATE TABLE `questionnaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_type` enum('patient','donor') DEFAULT NULL,
  `p_id` int DEFAULT NULL,
  `d_id` int DEFAULT NULL,
  `q1` enum('yes','no') DEFAULT NULL,
  `q2` enum('yes','no') DEFAULT NULL,
  `q3` enum('yes','no') DEFAULT NULL,
  `q4` enum('yes','no') DEFAULT NULL,
  `q5` enum('yes','no') DEFAULT NULL,
  `q6` enum('yes','no') DEFAULT NULL,
  `q7` enum('yes','no') DEFAULT NULL,
  `q8` enum('yes','no') DEFAULT NULL,
  `q9` enum('yes','no') DEFAULT NULL,
  `q10` enum('yes','no') DEFAULT NULL,
  `last_update_time` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `p_id` (`p_id`),
  KEY `d_id` (`d_id`),
  CONSTRAINT `questionnaire_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `patient` (`id`),
  CONSTRAINT `questionnaire_ibfk_2` FOREIGN KEY (`d_id`) REFERENCES `donor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `questionnaire` */

insert  into `questionnaire`(`id`,`user_type`,`p_id`,`d_id`,`q1`,`q2`,`q3`,`q4`,`q5`,`q6`,`q7`,`q8`,`q9`,`q10`,`last_update_time`) values 
(1,'patient',10,NULL,'yes','no','yes','no','yes','no','yes','yes','yes','yes','2023-05-03'),
(2,'patient',12,NULL,'no','yes','yes','yes','yes','yes','yes','no','yes','yes','2023-05-03'),
(3,'patient',1,NULL,'no','no','no','no','no','no','no','no','no','no','2023-04-09'),
(4,'donor',NULL,2,'no','yes','no','no','yes','yes','no','yes','no','no','2023-04-14'),
(5,'donor',NULL,3,'yes','yes','yes','yes','yes','yes','yes','yes','yes','yes','2023-05-03'),
(6,'patient',13,NULL,'yes','yes','yes','yes','yes','no','no','yes','no','yes','2023-04-28'),
(7,'donor',NULL,4,'no','no','no','no','no','no','no','no','no','no',NULL),
(8,'donor',NULL,5,'yes','no','yes','no','yes','no','yes','yes','yes','no','2023-04-14'),
(9,'donor',NULL,6,'yes','yes','no','yes','no','no','no','no','no','no','2023-05-04');

/*Table structure for table `reg_request` */

DROP TABLE IF EXISTS `reg_request`;

CREATE TABLE `reg_request` (
  `req_id` int NOT NULL AUTO_INCREMENT,
  `req_role` enum('admin','bank_officer') NOT NULL,
  `fname` varchar(26) NOT NULL,
  `lname` varchar(26) NOT NULL,
  `email` varchar(36) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `pword` varchar(10) DEFAULT NULL,
  `req_doc` varchar(100) NOT NULL,
  `req_status` int DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `comments` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`req_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `reg_request` */

insert  into `reg_request`(`req_id`,`req_role`,`fname`,`lname`,`email`,`phone`,`pword`,`req_doc`,`req_status`,`reg_date`,`comments`) values 
(1,'admin','Ezekiel','Maina','ezekielmaina.me@gmail.com','0700408205','12345678','12345678',1,'2023-03-27',NULL),
(2,'bank_officer','stephen','Otieno','steph@gmail.com','0787398939','12345678','bank_officer_stephen_0787398939.pdf',1,'2023-03-27',NULL),
(3,'admin','Paul','Thuku','paul@gmail.com','0799383903','12345678','admin_Paul_0799383903.pdf',0,'2023-04-12',NULL),
(4,'admin','Kelvin','Wanjohi','kelv@gmail.com','0783673768','12345678','admin_Kelvin_0783673768.pdf',1,'2023-04-12',NULL),
(5,'bank_officer','Harrison','Mutuku','harr@gmail.com','0788820046','12345678','bank_officer_Harrison_0788820046.pdf',0,'2023-04-12',NULL),
(6,'bank_officer','Jamila','Moham','jam@gmail.com','0799699300','12345678','bank_officer_Jamila_0799699300.pdf',1,'2023-04-12',NULL);

/*Table structure for table `transfer` */

DROP TABLE IF EXISTS `transfer`;

CREATE TABLE `transfer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trans_date` date DEFAULT NULL,
  `appr_bank` int NOT NULL,
  `req_bank` int NOT NULL,
  `pouch_id` int DEFAULT NULL,
  `inter_bank_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pouch_id` (`pouch_id`),
  KEY `source` (`appr_bank`),
  KEY `destination` (`req_bank`),
  KEY `inter_bank_id` (`inter_bank_id`),
  CONSTRAINT `transfer_ibfk_1` FOREIGN KEY (`pouch_id`) REFERENCES `pouch` (`id`),
  CONSTRAINT `transfer_ibfk_2` FOREIGN KEY (`appr_bank`) REFERENCES `blood_bank` (`id`),
  CONSTRAINT `transfer_ibfk_3` FOREIGN KEY (`req_bank`) REFERENCES `blood_bank` (`id`),
  CONSTRAINT `transfer_ibfk_4` FOREIGN KEY (`inter_bank_id`) REFERENCES `inter_bank` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `transfer` */

insert  into `transfer`(`id`,`trans_date`,`appr_bank`,`req_bank`,`pouch_id`,`inter_bank_id`) values 
(1,'2023-04-26',3,5,1002,2),
(2,'2023-05-04',5,3,1008,4);

/*Table structure for table `transfusion` */

DROP TABLE IF EXISTS `transfusion`;

CREATE TABLE `transfusion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `app_id` int DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  `pouch_id` int DEFAULT NULL,
  `bank_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`),
  KEY `pouch_id` (`pouch_id`),
  KEY `bank_id` (`bank_id`),
  CONSTRAINT `transfusion_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `patient_appeal` (`id`),
  CONSTRAINT `transfusion_ibfk_2` FOREIGN KEY (`pouch_id`) REFERENCES `pouch` (`id`),
  CONSTRAINT `transfusion_ibfk_3` FOREIGN KEY (`bank_id`) REFERENCES `blood_bank` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `transfusion` */

insert  into `transfusion`(`id`,`app_id`,`trans_date`,`pouch_id`,`bank_id`) values 
(1,1,'2023-04-22',1003,3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
