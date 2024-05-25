-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2022 at 11:03 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aci_leave`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2020-11-03 13:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentName` varchar(150) DEFAULT NULL,
  `DepartmentShortName` varchar(100) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbldepartments`
--

INSERT INTO `tbldepartments` (`id`, `DepartmentName`, `DepartmentShortName`, `CreationDate`) VALUES
(1, 'Human Resource', 'HR', '2024-01-01 08:00:00'),
(2, 'Information Technology', 'IT', '2024-01-01 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployees`
--

CREATE TABLE `tblemployees` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `Position_Staff` varchar(100) NOT NULL,
  `EmailId` varchar(200) NOT NULL,
  `Password` varchar(180) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `SubDepartment` varchar(30) NULL,
  `Address` varchar(255) NOT NULL,
  `Av_leave` varchar(150) NOT NULL,
  `Phonenumber` char(11) NOT NULL,
  `Status` varchar(10) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(30) NOT NULL,
  `location` varchar(200) NOT NULL,
  `signature` varchar(200) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`emp_id`, `FirstName`, `LastName`, `Position_Staff`, `EmailId`, `Password`, `Gender`, `Dob`, `Department`, `SubDepartment`, `Address`, `Av_leave`, `Phonenumber`, `Status`, `RegDate`, `role`, `signature`) VALUES
(1, 'Michael', 'Tan', 'Admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'Male', '3 February, 1990', 'Admin', '-', '-', '14', '07222288890', 'Online', '2017-11-10 13:40:02', 'Admin', 'reg_de_8587944255_2.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblleave`
--

CREATE TABLE `tblleave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LeaveType` varchar(110) NOT NULL,
  `RequestedDays` int(11) NOT NULL,
  `DaysOutstand` int(11) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `ToDate` varbinary(120) DEFAULT NULL,
  `Sign` varchar(120) DEFAULT NULL,
  `PostingDate` date DEFAULT NULL,
  `WorkCovered` varchar(120) DEFAULT NULL,
  `HodRemarks` int(11) NOT NULL DEFAULT 0,
  `HodSign` varchar(200) NOT NULL,
  `HodDate` varchar(120) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL,
  `num_days` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Table structure for table `tblhodleave`
--

CREATE TABLE `tblhodleave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LeaveType` varchar(110) NOT NULL,
  `RequestedDays` int(11) NOT NULL,
  `DaysOutstand` int(11) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `ToDate` varbinary(120) DEFAULT NULL,
  `Sign` varchar(120) DEFAULT NULL,
  `PostingDate` date DEFAULT NULL,
  `WorkCovered` varchar(120) DEFAULT NULL,
  `CeoRemarks` int(11) NOT NULL DEFAULT 0,
  `CeoSign` varchar(200) NOT NULL,
  `CeoDate` varchar(120) NOT NULL,
  `DceoRemarks` int(11) NOT NULL DEFAULT 0,
  `DceoSign` varchar(200) NOT NULL,
  `DceoDate` varchar(120) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL,
  `num_days` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Indexes for table `tblleave`
--
ALTER TABLE `tblleave`
  ADD KEY `UserEmail` (`empid`);

-- --------------------------------------------------------
--
-- Indexes for table `tblleave`
--
ALTER TABLE `tblhodleave`
  ADD KEY `UserEmail` (`empid`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
