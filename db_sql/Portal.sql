-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2021 at 12:01 PM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Portal`
--
CREATE DATABASE IF NOT EXISTS `Portal` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `Portal`;

-- --------------------------------------------------------

--
-- Table structure for table `alternateDuty`
--

DROP TABLE IF EXISTS `alternateDuty`;
CREATE TABLE IF NOT EXISTS `alternateDuty` (
  `id` int(11) NOT NULL,
  `dutyDate` date NOT NULL,
  `stauts` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `groupID` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `alternateGroup`
--

DROP TABLE IF EXISTS `alternateGroup`;
CREATE TABLE IF NOT EXISTS `alternateGroup` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `groupID` varchar(10) NOT NULL,
  `alternateGroupID` int(11) NOT NULL,
  `currentYear` int(11) NOT NULL,
  `status` enum('YES','NO') NOT NULL DEFAULT 'YES'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Approval`
--

DROP TABLE IF EXISTS `Approval`;
CREATE TABLE IF NOT EXISTS `Approval` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `immediateSupervisor` varchar(100) DEFAULT NULL,
  `departmentHead` varchar(100) DEFAULT NULL,
  `FinalApprover` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ApprovalLog`
--

DROP TABLE IF EXISTS `ApprovalLog`;
CREATE TABLE IF NOT EXISTS `ApprovalLog` (
  `id` int(11) NOT NULL,
  `leaveApplicationID` int(11) NOT NULL,
  `approver` varchar(100) NOT NULL,
  `status` enum('APPROVED','REJECTED','PENDING') NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Approvers`
--

DROP TABLE IF EXISTS `Approvers`;
CREATE TABLE IF NOT EXISTS `Approvers` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `approver` varchar(100) NOT NULL,
  `position` int(11) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Approvers.20180919`
--

DROP TABLE IF EXISTS `Approvers.20180919`;
CREATE TABLE IF NOT EXISTS `Approvers.20180919` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `approver` varchar(100) NOT NULL,
  `position` int(11) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Approvers.bak`
--

DROP TABLE IF EXISTS `Approvers.bak`;
CREATE TABLE IF NOT EXISTS `Approvers.bak` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `approver` varchar(100) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fileLocation` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AttendanceRecords`
--

DROP TABLE IF EXISTS `AttendanceRecords`;
CREATE TABLE IF NOT EXISTS `AttendanceRecords` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `timeRecord` datetime NOT NULL,
  `type` varchar(100) NOT NULL,
  `deviceID` int(11) DEFAULT NULL,
  `place` varchar(100) DEFAULT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AttendanceRemarks`
--

DROP TABLE IF EXISTS `AttendanceRemarks`;
CREATE TABLE IF NOT EXISTS `AttendanceRemarks` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `timeRecord` datetime NOT NULL,
  `reasonID` int(11) DEFAULT NULL,
  `remark` text NOT NULL,
  `adminInput` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `createdBy` varchar(100) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AuthAssignment`
--

DROP TABLE IF EXISTS `AuthAssignment`;
CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

DROP TABLE IF EXISTS `AuthItem`;
CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

DROP TABLE IF EXISTS `AuthItemChild`;
CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ContentTable`
--

DROP TABLE IF EXISTS `ContentTable`;
CREATE TABLE IF NOT EXISTS `ContentTable` (
  `id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CWRStaff`
--

DROP TABLE IF EXISTS `CWRStaff`;
CREATE TABLE IF NOT EXISTS `CWRStaff` (
  `id` int(11) NOT NULL,
  `cwr` varchar(100) NOT NULL,
  `cwrDate` date DEFAULT NULL,
  `whiteCard` varchar(200) DEFAULT NULL,
  `whiteCardDate` date DEFAULT NULL,
  `greenCard` varchar(200) DEFAULT NULL,
  `greenCardDate` date DEFAULT NULL,
  `staffCode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Department`
--

DROP TABLE IF EXISTS `Department`;
CREATE TABLE IF NOT EXISTS `Department` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `departmentID` int(11) NOT NULL DEFAULT '0',
  `divisionID` int(11) NOT NULL DEFAULT '0',
  `companyID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `DeptHead`
--

DROP TABLE IF EXISTS `DeptHead`;
CREATE TABLE IF NOT EXISTS `DeptHead` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `deptID` int(11) NOT NULL,
  `active` enum('YES','NO') NOT NULL DEFAULT 'YES'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
CREATE TABLE IF NOT EXISTS `holidays` (
  `id` int(11) NOT NULL,
  `holidayName` varchar(100) NOT NULL,
  `eventDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `holidaysGroup`
--

DROP TABLE IF EXISTS `holidaysGroup`;
CREATE TABLE IF NOT EXISTS `holidaysGroup` (
  `id` int(11) NOT NULL,
  `holidaysID` int(11) NOT NULL,
  `groupName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `holidaysGroup.bak`
--

DROP TABLE IF EXISTS `holidaysGroup.bak`;
CREATE TABLE IF NOT EXISTS `holidaysGroup.bak` (
  `id` int(11) NOT NULL,
  `holidaysID` int(11) NOT NULL,
  `groupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveApplication`
--

DROP TABLE IF EXISTS `LeaveApplication`;
CREATE TABLE IF NOT EXISTS `LeaveApplication` (
  `id` int(11) NOT NULL,
  `refNo` varchar(100) DEFAULT NULL,
  `staffCode` varchar(100) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `startDateType` enum('ALL','AM','PM') NOT NULL,
  `endDateType` enum('ALL','AM','PM') NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `reasonID` int(11) DEFAULT NULL,
  `reasonRemarks` text,
  `commentID` int(11) DEFAULT NULL,
  `commentRemarks` text,
  `attachmentID` int(11) DEFAULT NULL,
  `status` enum('ACTIVE','WAIVE','CANCEL') NOT NULL DEFAULT 'ACTIVE',
  `approvedBy` varchar(100) DEFAULT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `HRStatus` int(11) NOT NULL DEFAULT '159',
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createdBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveApplicationApply`
--

DROP TABLE IF EXISTS `LeaveApplicationApply`;
CREATE TABLE IF NOT EXISTS `LeaveApplicationApply` (
  `id` int(11) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `applyStartDate` date NOT NULL,
  `applyEndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveApplicationCount`
--

DROP TABLE IF EXISTS `LeaveApplicationCount`;
CREATE TABLE IF NOT EXISTS `LeaveApplicationCount` (
  `id` int(11) NOT NULL,
  `currentYear` int(11) NOT NULL,
  `totalCount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveApplicationRef`
--

DROP TABLE IF EXISTS `LeaveApplicationRef`;
CREATE TABLE IF NOT EXISTS `LeaveApplicationRef` (
  `id` int(11) NOT NULL,
  `applicationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveBalance`
--

DROP TABLE IF EXISTS `LeaveBalance`;
CREATE TABLE IF NOT EXISTS `LeaveBalance` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `balanceDate` date NOT NULL,
  `balance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveBalance.bak`
--

DROP TABLE IF EXISTS `LeaveBalance.bak`;
CREATE TABLE IF NOT EXISTS `LeaveBalance.bak` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `balanceDate` date NOT NULL,
  `balance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logTable`
--

DROP TABLE IF EXISTS `logTable`;
CREATE TABLE IF NOT EXISTS `logTable` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `action` text NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Projects`
--

DROP TABLE IF EXISTS `Projects`;
CREATE TABLE IF NOT EXISTS `Projects` (
  `id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `code` varchar(100) NOT NULL,
  `code2` varchar(100) DEFAULT NULL,
  `projectTitle` text NOT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `remainBalance`
--

DROP TABLE IF EXISTS `remainBalance`;
CREATE TABLE IF NOT EXISTS `remainBalance` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `remaining` double NOT NULL,
  `Year` int(11) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Rights`
--

DROP TABLE IF EXISTS `Rights`;
CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Staff`
--

DROP TABLE IF EXISTS `Staff`;
CREATE TABLE IF NOT EXISTS `Staff` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `surName` varchar(100) NOT NULL,
  `givenName` varchar(200) NOT NULL,
  `nickName` varchar(100) DEFAULT NULL,
  `chineseName` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `HKID` varchar(100) DEFAULT NULL,
  `mobilePhone` varchar(100) DEFAULT NULL,
  `whiteCard` varchar(100) DEFAULT NULL,
  `greenCard` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `StaffDuty`
--

DROP TABLE IF EXISTS `StaffDuty`;
CREATE TABLE IF NOT EXISTS `StaffDuty` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `dutyGroup` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `StaffEmployment`
--

DROP TABLE IF EXISTS `StaffEmployment`;
CREATE TABLE IF NOT EXISTS `StaffEmployment` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime DEFAULT NULL,
  `Basis` int(11) NOT NULL,
  `positionID` int(11) NOT NULL DEFAULT '1',
  `leaveGroup` int(11) NOT NULL,
  `probationEndDate` date DEFAULT NULL,
  `projectCode` text,
  `registeredTrade` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `StaffGroup`
--

DROP TABLE IF EXISTS `StaffGroup`;
CREATE TABLE IF NOT EXISTS `StaffGroup` (
  `id` int(11) NOT NULL,
  `groupID` int(11) NOT NULL,
  `groupName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `StaffPosition`
--

DROP TABLE IF EXISTS `StaffPosition`;
CREATE TABLE IF NOT EXISTS `StaffPosition` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `postitionID` int(11) NOT NULL,
  `employmentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `starSystem`
--

DROP TABLE IF EXISTS `starSystem`;
CREATE TABLE IF NOT EXISTS `starSystem` (
  `id` int(11) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `contractID` varchar(100) NOT NULL,
  `place` varchar(200) NOT NULL,
  `shortCode` varchar(100) DEFAULT NULL,
  `displayName` varchar(100) DEFAULT NULL,
  `status` enum('YES','NO') NOT NULL DEFAULT 'YES'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `timeSlot`
--

DROP TABLE IF EXISTS `timeSlot`;
CREATE TABLE IF NOT EXISTS `timeSlot` (
  `id` int(11) NOT NULL,
  `timeslotName` varchar(100) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `type` varchar(45) NOT NULL,
  `days` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `timeSlotAissigment`
--

DROP TABLE IF EXISTS `timeSlotAissigment`;
CREATE TABLE IF NOT EXISTS `timeSlotAissigment` (
  `id` int(11) NOT NULL,
  `timeSlotGroup` int(11) NOT NULL,
  `timeSlot` int(11) NOT NULL,
  `createDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `timeSlotGroup`
--

DROP TABLE IF EXISTS `timeSlotGroup`;
CREATE TABLE IF NOT EXISTS `timeSlotGroup` (
  `id` int(11) NOT NULL,
  `groupName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `timeSlotStaff`
--

DROP TABLE IF EXISTS `timeSlotStaff`;
CREATE TABLE IF NOT EXISTS `timeSlotStaff` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `timeSlotGroup` int(11) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `status` enum('ACTIVE','PENDING') NOT NULL DEFAULT 'PENDING',
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `roles` varchar(100) NOT NULL DEFAULT 'user',
  `resigned` enum('YES','NO') NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL,
  `staffCode` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `resigned` enum('YES','NO') NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `YiiLog`
--

DROP TABLE IF EXISTS `YiiLog`;
CREATE TABLE IF NOT EXISTS `YiiLog` (
  `id` int(11) NOT NULL,
  `level` varchar(128) DEFAULT NULL,
  `category` varchar(128) DEFAULT NULL,
  `logtime` datetime DEFAULT NULL,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternateDuty`
--
ALTER TABLE `alternateDuty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alternateGroup`
--
ALTER TABLE `alternateGroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `Approval`
--
ALTER TABLE `Approval`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `immediateSupervisor` (`immediateSupervisor`),
  ADD KEY `departmentHead` (`departmentHead`),
  ADD KEY `departmentHead_2` (`departmentHead`),
  ADD KEY `FinalApprover` (`FinalApprover`);

--
-- Indexes for table `ApprovalLog`
--
ALTER TABLE `ApprovalLog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approver` (`approver`),
  ADD KEY `leaveApplicationID` (`leaveApplicationID`);

--
-- Indexes for table `Approvers`
--
ALTER TABLE `Approvers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `apperover` (`approver`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `Approvers.20180919`
--
ALTER TABLE `Approvers.20180919`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `apperover` (`approver`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `Approvers.bak`
--
ALTER TABLE `Approvers.bak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `apperover` (`approver`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `AttendanceRecords`
--
ALTER TABLE `AttendanceRecords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `AttendanceRemarks`
--
ALTER TABLE `AttendanceRemarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `createdBy` (`createdBy`);

--
-- Indexes for table `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD PRIMARY KEY (`itemname`,`userid`);

--
-- Indexes for table `AuthItem`
--
ALTER TABLE `AuthItem`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `ContentTable`
--
ALTER TABLE `ContentTable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `CWRStaff`
--
ALTER TABLE `CWRStaff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `Department`
--
ALTER TABLE `Department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DeptHead`
--
ALTER TABLE `DeptHead`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `deptID` (`deptID`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidaysGroup`
--
ALTER TABLE `holidaysGroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holidaysID` (`holidaysID`),
  ADD KEY `groupID` (`groupName`);

--
-- Indexes for table `holidaysGroup.bak`
--
ALTER TABLE `holidaysGroup.bak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holidaysID` (`holidaysID`),
  ADD KEY `groupID` (`groupID`);

--
-- Indexes for table `LeaveApplication`
--
ALTER TABLE `LeaveApplication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachmentID` (`attachmentID`),
  ADD KEY `reasonID` (`reasonID`),
  ADD KEY `commentID` (`commentID`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `createdBy` (`createdBy`),
  ADD KEY `approvedBy` (`approvedBy`);

--
-- Indexes for table `LeaveApplicationApply`
--
ALTER TABLE `LeaveApplicationApply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LeaveApplicationCount`
--
ALTER TABLE `LeaveApplicationCount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LeaveApplicationRef`
--
ALTER TABLE `LeaveApplicationRef`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `LeaveBalance`
--
ALTER TABLE `LeaveBalance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `LeaveBalance.bak`
--
ALTER TABLE `LeaveBalance.bak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `logTable`
--
ALTER TABLE `logTable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Projects`
--
ALTER TABLE `Projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remainBalance`
--
ALTER TABLE `remainBalance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `staffCode_2` (`staffCode`);

--
-- Indexes for table `Rights`
--
ALTER TABLE `Rights`
  ADD PRIMARY KEY (`itemname`);

--
-- Indexes for table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `StaffDuty`
--
ALTER TABLE `StaffDuty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `StaffEmployment`
--
ALTER TABLE `StaffEmployment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `Basis` (`Basis`),
  ADD KEY `positionID` (`positionID`),
  ADD KEY `leaveGroup` (`leaveGroup`);

--
-- Indexes for table `StaffGroup`
--
ALTER TABLE `StaffGroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`groupID`),
  ADD KEY `deptID` (`groupName`),
  ADD KEY `groupID` (`groupID`);

--
-- Indexes for table `StaffPosition`
--
ALTER TABLE `StaffPosition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `starSystem`
--
ALTER TABLE `starSystem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeSlot`
--
ALTER TABLE `timeSlot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeSlotAissigment`
--
ALTER TABLE `timeSlotAissigment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timeSlotGroup` (`timeSlotGroup`),
  ADD KEY `timeSlot` (`timeSlot`);

--
-- Indexes for table `timeSlotGroup`
--
ALTER TABLE `timeSlotGroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeSlotStaff`
--
ALTER TABLE `timeSlotStaff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`),
  ADD KEY `timeSlotGroup` (`timeSlotGroup`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staffCode` (`staffCode`);

--
-- Indexes for table `YiiLog`
--
ALTER TABLE `YiiLog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternateDuty`
--
ALTER TABLE `alternateDuty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `alternateGroup`
--
ALTER TABLE `alternateGroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Approval`
--
ALTER TABLE `Approval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ApprovalLog`
--
ALTER TABLE `ApprovalLog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Approvers`
--
ALTER TABLE `Approvers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Approvers.20180919`
--
ALTER TABLE `Approvers.20180919`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Approvers.bak`
--
ALTER TABLE `Approvers.bak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `AttendanceRecords`
--
ALTER TABLE `AttendanceRecords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `AttendanceRemarks`
--
ALTER TABLE `AttendanceRemarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ContentTable`
--
ALTER TABLE `ContentTable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `CWRStaff`
--
ALTER TABLE `CWRStaff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Department`
--
ALTER TABLE `Department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `DeptHead`
--
ALTER TABLE `DeptHead`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `holidaysGroup`
--
ALTER TABLE `holidaysGroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `holidaysGroup.bak`
--
ALTER TABLE `holidaysGroup.bak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `LeaveApplication`
--
ALTER TABLE `LeaveApplication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `LeaveApplicationApply`
--
ALTER TABLE `LeaveApplicationApply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `LeaveApplicationCount`
--
ALTER TABLE `LeaveApplicationCount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `LeaveApplicationRef`
--
ALTER TABLE `LeaveApplicationRef`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `LeaveBalance`
--
ALTER TABLE `LeaveBalance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `LeaveBalance.bak`
--
ALTER TABLE `LeaveBalance.bak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logTable`
--
ALTER TABLE `logTable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Projects`
--
ALTER TABLE `Projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `remainBalance`
--
ALTER TABLE `remainBalance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Staff`
--
ALTER TABLE `Staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `StaffDuty`
--
ALTER TABLE `StaffDuty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `StaffEmployment`
--
ALTER TABLE `StaffEmployment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `StaffGroup`
--
ALTER TABLE `StaffGroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `StaffPosition`
--
ALTER TABLE `StaffPosition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `starSystem`
--
ALTER TABLE `starSystem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timeSlot`
--
ALTER TABLE `timeSlot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timeSlotAissigment`
--
ALTER TABLE `timeSlotAissigment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timeSlotGroup`
--
ALTER TABLE `timeSlotGroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timeSlotStaff`
--
ALTER TABLE `timeSlotStaff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `YiiLog`
--
ALTER TABLE `YiiLog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alternateGroup`
--
ALTER TABLE `alternateGroup`
  ADD CONSTRAINT `alternateGroup_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `Approval`
--
ALTER TABLE `Approval`
  ADD CONSTRAINT `Approval_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `Approval_ibfk_2` FOREIGN KEY (`immediateSupervisor`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `Approval_ibfk_3` FOREIGN KEY (`departmentHead`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `Approval_ibfk_4` FOREIGN KEY (`FinalApprover`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `ApprovalLog`
--
ALTER TABLE `ApprovalLog`
  ADD CONSTRAINT `ApprovalLog_ibfk_1` FOREIGN KEY (`leaveApplicationID`) REFERENCES `LeaveApplication` (`id`),
  ADD CONSTRAINT `ApprovalLog_ibfk_2` FOREIGN KEY (`approver`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `Approvers`
--
ALTER TABLE `Approvers`
  ADD CONSTRAINT `Approvers_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `Approvers_ibfk_3` FOREIGN KEY (`position`) REFERENCES `ContentTable` (`id`),
  ADD CONSTRAINT `Approvers_ibfk_4` FOREIGN KEY (`approver`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `AttendanceRecords`
--
ALTER TABLE `AttendanceRecords`
  ADD CONSTRAINT `AttendanceRecords_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `AttendanceRemarks`
--
ALTER TABLE `AttendanceRemarks`
  ADD CONSTRAINT `AttendanceRemarks_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `AttendanceRemarks_ibfk_2` FOREIGN KEY (`createdBy`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `AuthAssignment`
--
ALTER TABLE `AuthAssignment`
  ADD CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `AuthItemChild`
--
ALTER TABLE `AuthItemChild`
  ADD CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `CWRStaff`
--
ALTER TABLE `CWRStaff`
  ADD CONSTRAINT `CWRStaff_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `DeptHead`
--
ALTER TABLE `DeptHead`
  ADD CONSTRAINT `DeptHead_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `DeptHead_ibfk_2` FOREIGN KEY (`deptID`) REFERENCES `ContentTable` (`id`);

--
-- Constraints for table `holidaysGroup`
--
ALTER TABLE `holidaysGroup`
  ADD CONSTRAINT `holidaysGroup_ibfk_3` FOREIGN KEY (`holidaysID`) REFERENCES `holidays` (`id`);

--
-- Constraints for table `LeaveApplication`
--
ALTER TABLE `LeaveApplication`
  ADD CONSTRAINT `LeaveApplication_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `LeaveApplication_ibfk_2` FOREIGN KEY (`reasonID`) REFERENCES `ContentTable` (`id`),
  ADD CONSTRAINT `LeaveApplication_ibfk_3` FOREIGN KEY (`commentID`) REFERENCES `ContentTable` (`id`),
  ADD CONSTRAINT `LeaveApplication_ibfk_4` FOREIGN KEY (`attachmentID`) REFERENCES `attachments` (`id`),
  ADD CONSTRAINT `LeaveApplication_ibfk_5` FOREIGN KEY (`createdBy`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `LeaveApplication_ibfk_6` FOREIGN KEY (`approvedBy`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `LeaveBalance`
--
ALTER TABLE `LeaveBalance`
  ADD CONSTRAINT `LeaveBalance_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `remainBalance`
--
ALTER TABLE `remainBalance`
  ADD CONSTRAINT `remainBalance_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `Rights`
--
ALTER TABLE `Rights`
  ADD CONSTRAINT `Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `StaffDuty`
--
ALTER TABLE `StaffDuty`
  ADD CONSTRAINT `StaffDuty_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`);

--
-- Constraints for table `StaffEmployment`
--
ALTER TABLE `StaffEmployment`
  ADD CONSTRAINT `StaffEmployment_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `StaffEmployment_ibfk_2` FOREIGN KEY (`Basis`) REFERENCES `ContentTable` (`id`),
  ADD CONSTRAINT `StaffEmployment_ibfk_3` FOREIGN KEY (`positionID`) REFERENCES `ContentTable` (`id`);

--
-- Constraints for table `StaffGroup`
--
ALTER TABLE `StaffGroup`
  ADD CONSTRAINT `StaffGroup_ibfk_1` FOREIGN KEY (`groupID`) REFERENCES `ContentTable` (`id`);

--
-- Constraints for table `timeSlotAissigment`
--
ALTER TABLE `timeSlotAissigment`
  ADD CONSTRAINT `timeSlotAissigment_ibfk_1` FOREIGN KEY (`timeSlotGroup`) REFERENCES `timeSlotGroup` (`id`),
  ADD CONSTRAINT `timeSlotAissigment_ibfk_2` FOREIGN KEY (`timeSlot`) REFERENCES `timeSlot` (`id`);

--
-- Constraints for table `timeSlotStaff`
--
ALTER TABLE `timeSlotStaff`
  ADD CONSTRAINT `timeSlotStaff_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`),
  ADD CONSTRAINT `timeSlotStaff_ibfk_2` FOREIGN KEY (`timeSlotGroup`) REFERENCES `timeSlotAissigment` (`timeSlotGroup`);

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`staffCode`) REFERENCES `Staff` (`staffCode`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
