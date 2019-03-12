-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2019 at 01:24 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `33_zhiyu_pessdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `dispatch`
--

CREATE TABLE `dispatch` (
  `incidentid` int(11) NOT NULL,
  `patrolcarld` varchar(10) NOT NULL,
  `timeDispatched` datetime NOT NULL,
  `timeArrived` datetime DEFAULT NULL,
  `timeCompleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dispatch`
--

INSERT INTO `dispatch` (`incidentid`, `patrolcarld`, `timeDispatched`, `timeArrived`, `timeCompleted`) VALUES
(1, 'QX1111J', '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `incidentid` int(11) NOT NULL,
  `callerName` varchar(30) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `incidentTypeld` varchar(3) NOT NULL,
  `incidentLocation` varchar(50) NOT NULL,
  `incidentDesc` varchar(100) NOT NULL,
  `incidentStatusld` varchar(1) NOT NULL,
  `timeCalled` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incident`
--

INSERT INTO `incident` (`incidentid`, `callerName`, `phoneNumber`, `incidentTypeld`, `incidentLocation`, `incidentDesc`, `incidentStatusld`, `timeCalled`) VALUES
(1, 'Peter Leow', '81234567', '060', 'Junction of North Bridge Road and Middle Road', 'A bus collided with a taxi, 2 injuries', '2', '2019-02-12 02:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `incidenttype`
--

CREATE TABLE `incidenttype` (
  `incidentid` varchar(3) NOT NULL,
  `incidentTypeDesc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incidenttype`
--

INSERT INTO `incidenttype` (`incidentid`, `incidentTypeDesc`) VALUES
('10', 'Fire'),
('20', 'Riot'),
('30', 'Burglary'),
('40', 'Domestic Violent'),
('50', 'Fallen Tree'),
('60', 'Traffic Accident'),
('70', 'Loan Shark'),
('999', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `incident_statues`
--

CREATE TABLE `incident_statues` (
  `statuesid` varchar(1) NOT NULL,
  `statuesDesc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `incident_statues`
--

INSERT INTO `incident_statues` (`statuesid`, `statuesDesc`) VALUES
('1', 'Pending'),
('2', 'Dispatched'),
('3', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `patrolcar`
--

CREATE TABLE `patrolcar` (
  `patrolcarid` varchar(10) NOT NULL,
  `patrolcarstatusid` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patrolcar`
--

INSERT INTO `patrolcar` (`patrolcarid`, `patrolcarstatusid`) VALUES
('QX1111J', 'F'),
('QX1234A', 'D'),
('QX1342G', 'D'),
('QX2222K', 'F'),
('QX2288D', 'F'),
('QX3456B', 'P'),
('QX5555D', 'P'),
('QX8723W', 'P'),
('QX8769P', 'F'),
('QX8923T', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `patrolcar_status`
--

CREATE TABLE `patrolcar_status` (
  `statuesid` varchar(1) NOT NULL,
  `statuesDesc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patrolcar_status`
--

INSERT INTO `patrolcar_status` (`statuesid`, `statuesDesc`) VALUES
('1', 'Dispatched'),
('2', 'Patrol'),
('3', 'Free'),
('4', 'Arrived');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dispatch`
--
ALTER TABLE `dispatch`
  ADD PRIMARY KEY (`incidentid`,`patrolcarld`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`incidentid`);

--
-- Indexes for table `incident_statues`
--
ALTER TABLE `incident_statues`
  ADD PRIMARY KEY (`statuesid`);

--
-- Indexes for table `patrolcar`
--
ALTER TABLE `patrolcar`
  ADD PRIMARY KEY (`patrolcarid`);

--
-- Indexes for table `patrolcar_status`
--
ALTER TABLE `patrolcar_status`
  ADD PRIMARY KEY (`statuesid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `incidentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
