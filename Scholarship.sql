-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: scholarshipdb
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `appli_details`
--

DROP TABLE IF EXISTS appli_details;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE appli_details (
  Appli_Num int NOT NULL AUTO_INCREMENT,
  LRN bigint NOT NULL,
  Assistance_Type char(15) NOT NULL DEFAULT 'Regular',
  Assistance_Applied varchar(15) NOT NULL DEFAULT 'PHD',
  appli_detailscol varchar(45) NOT NULL,
  PRIMARY KEY (Appli_Num),
  UNIQUE KEY Appli_Num_UNIQUE (Appli_Num),
  KEY LRN_idx (LRN),
  CONSTRAINT LRN FOREIGN KEY (LRN) REFERENCES appli_profile (LRN)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appli_details`
--

LOCK TABLES appli_details WRITE;
/*!40000 ALTER TABLE appli_details DISABLE KEYS */;
/*!40000 ALTER TABLE appli_details ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appli_profile`
--

DROP TABLE IF EXISTS appli_profile;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE appli_profile (
  LRN bigint NOT NULL,
  LastName varchar(30) NOT NULL,
  FirstName varchar(30) NOT NULL,
  MidName varchar(30) DEFAULT NULL,
  Suffix char(4) DEFAULT NULL,
  BirthDate date NOT NULL,
  BirthPlace char(30) NOT NULL,
  Sex char(10) NOT NULL,
  CivilStat char(15) NOT NULL,
  EthnoGroupStudent varchar(15) NOT NULL,
  ContactNo char(11) NOT NULL,
  EmailAdd varchar(40) NOT NULL,
  Perma_Stud_Add varchar(60) NOT NULL,
  Current_Stud_Add varchar(60) NOT NULL,
  PLifeStatus char(10) NOT NULL,
  ParentName varchar(60) NOT NULL,
  Parent_Add varchar(60) NOT NULL,
  ParentPrimaryOccu varchar(40) NOT NULL,
  ParentOfficeAdd varchar(60) DEFAULT NULL,
  ParentEduc char(10) NOT NULL,
  EthnoGroupPrt varchar(15) NOT NULL,
  Parent_Income int NOT NULL,
  ITR_Year year NOT NULL,
  PRIMARY KEY (LRN)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appli_profile`
--

LOCK TABLES appli_profile WRITE;
/*!40000 ALTER TABLE appli_profile DISABLE KEYS */;
/*!40000 ALTER TABLE appli_profile ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `degree_program`
--

DROP TABLE IF EXISTS degree_program;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE degree_program (
  DegCode int NOT NULL AUTO_INCREMENT,
  DegLevel char(10) NOT NULL,
  DegreeProgram char(30) NOT NULL,
  PRIMARY KEY (DegCode),
  UNIQUE KEY DegCode_UNIQUE (DegCode)
) ENGINE=InnoDB AUTO_INCREMENT=4009 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `degree_program`
--

LOCK TABLES degree_program WRITE;
/*!40000 ALTER TABLE degree_program DISABLE KEYS */;
INSERT INTO degree_program VALUES (4001,'Undergrad','BS Computer Science'),(4002,'Undergrad','BS Electronic Engineering'),(4003,'Undergrad','BS Mathematics'),(4004,'Masters','MA Computer Science'),(4005,'Masters','MS Data Science'),(4006,'Masters','MS Accountancy'),(4007,'Phd','DP in Computer Science'),(4008,'Phd','DP in Data Science');
/*!40000 ALTER TABLE degree_program ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `educ_bg`
--

DROP TABLE IF EXISTS educ_bg;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE educ_bg (
  LRN bigint NOT NULL,
  Educ_Background char(10) NOT NULL,
  SchoolCode int NOT NULL,
  Year_Grad year NOT NULL,
  Ave_Grade float NOT NULL,
  ranking char(25) DEFAULT NULL,
  PRIMARY KEY (LRN,Educ_Background),
  KEY SchoolCode_edubg_idx (SchoolCode),
  CONSTRAINT LRN_educbg FOREIGN KEY (LRN) REFERENCES appli_profile (LRN),
  CONSTRAINT SchoolCode_edubg FOREIGN KEY (SchoolCode) REFERENCES schooldetails (School_Code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `educ_bg`
--

LOCK TABLES educ_bg WRITE;
/*!40000 ALTER TABLE educ_bg DISABLE KEYS */;
/*!40000 ALTER TABLE educ_bg ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prioritylist`
--

DROP TABLE IF EXISTS prioritylist;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE prioritylist (
  Appli_Num int NOT NULL,
  DegCode int NOT NULL,
  School_Code int NOT NULL,
  PrioNum int NOT NULL,
  PRIMARY KEY (Appli_Num,DegCode,School_Code),
  KEY DegCode_idx (DegCode),
  KEY School_Code_idx (School_Code),
  CONSTRAINT `Appli_num fk` FOREIGN KEY (Appli_Num) REFERENCES appli_details (Appli_Num),
  CONSTRAINT DegCode FOREIGN KEY (DegCode) REFERENCES degree_program (DegCode),
  CONSTRAINT School_Code FOREIGN KEY (School_Code) REFERENCES schooldetails (School_Code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prioritylist`
--

LOCK TABLES prioritylist WRITE;
/*!40000 ALTER TABLE prioritylist DISABLE KEYS */;
/*!40000 ALTER TABLE prioritylist ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schooldetails`
--

DROP TABLE IF EXISTS schooldetails;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE schooldetails (
  School_Code int NOT NULL,
  School_Name varchar(60) NOT NULL,
  School_Address varchar(60) NOT NULL,
  School_Type char(10) NOT NULL,
  SchoolLevel char(10) NOT NULL,
  PRIMARY KEY (School_Code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schooldetails`
--

LOCK TABLES schooldetails WRITE;
/*!40000 ALTER TABLE schooldetails DISABLE KEYS */;
INSERT INTO schooldetails VALUES (1,'University of the Philippines Diliman','Diliman, Quezon City, Metro Manila','SUC Main','TERTIARY'),(19,'Polytechnic University of the Philippines Manila','Anonas Street, Sta. Mesa, Manila','SUC Main','TERTIARY'),(125,'De La Salle University Manila','2401 Taft Avenue, Manila','Private','TERTIARY'),(1579,'De La Salle–College of Saint Benilde','2401 Taft Avenue, Manila','Private','TERTIARY'),(104006,'New Era University','Central, Quezon City','Private','TERTIARY'),(136640,'Sto. Nino Elementary School','Bagong Silang Caloocan','Public','ELEM'),(136687,'Sto. Nino Elementary School','Sto. Nino, Marikina City','Public','ELEM'),(136753,'Fourth Estate Elementary School','Fourth Estate, Paranaque City','Public','ELEM'),(301442,'San Jose National High School','Montalban, Rizal','Public','HS'),(305381,'Bagong Silang High School','Bagong Silang Caloocan','Public','HS'),(305389,'Caloocan Business High School','Urduja Caloocan','Public','HS'),(305405,'Sta. Elena High School','Sta. Elena, Marikina City','Public','HS'),(320201,'Paranaque Science High School','Sto. Nino, Paranaque City','Public','HS'),(403107,'Sta. Cecilia Parochial School','San Mateo, Rizal','Public','ELEMHS'),(406324,'National Teachers College','Quiapo, Manila','Private','TERTIARY'),(425665,'Gentle Kiddie Learning Academy','Montalban, Rizal','Private','ELEM'),(478012,'Philippine Institute of Quezon City','Banawe, Quezon City','Private','ELEMHS');
/*!40000 ALTER TABLE schooldetails ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'scholarshipdb'
--

--
-- Dumping routines for database 'scholarshipdb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-02 20:11:09
