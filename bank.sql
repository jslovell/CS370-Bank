-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 02:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteTicket` (IN `ticket_id` VARCHAR(10))   BEGIN
	DELETE FROM ticket WHERE ticket.ticket_id = ticket_id;
    
    DELETE FROM altereduser WHERE altereduser.ticket_id = ticket_id;
    
    ##New on 4-26-24 as I fixited Check constraint on Priority in Ticket
    DELETE FROM alteredaccount WHERE alteredaccount.ticket_id = ticket_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ExecuteTwoQueries` (IN `account_id` VARCHAR(10))   BEGIN
    -- First query
    UPDATE TRANSACTION SET transaction.send_account = "REMOVED" WHERE transaction.send_account = account_id;

    -- Second query
    UPDATE TRANSACTION SET transaction.rec_account = "REMOVED" WHERE transaction.rec_account = account_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateClientAccounts` (IN `oldUsername` VARCHAR(20), IN `newUsername` VARCHAR(20))   BEGIN
	UPDATE account SET account.account_owner = newUsername
    WHERE account.account_owner = oldUsername;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateClientTickets` (IN `oldUsername` VARCHAR(20), IN `newUsername` VARCHAR(20))   BEGIN
	UPDATE ticket SET ticket.ticket_owner = newUsername
    WHERE ticket.ticket_owner = oldUsername;
    
    #New on 4-26-24 Since I fixed Priority Constraint
    UPDATE alteredaccount SET alteredaccount.account_owner = newUsername
    WHERE alteredaccount.account_owner = oldUsername;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `validUsername` (`username` VARCHAR(20)) RETURNS INT(11)  BEGIN
    	declare username_count integer;
    		select count(*) into username_count
        	from client
        	where client.username = username;
    		return username_count;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` varchar(10) NOT NULL,
  `account_owner` varchar(20) DEFAULT NULL,
  `account_type` varchar(10) DEFAULT NULL,
  `balance` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_owner`, `account_type`, `balance`) VALUES
('1000000001', 'afitzpatrick', 'savings', 2670.78),
('1000000002', 'bpierce', 'savings', 10075.86),
('1000000003', 'aleblanc', 'savings', 6287.47),
('1000000004', 'aleblanc', 'checking', 1221.63),
('1000000005', 'aleblanc', 'savings', 9010.91),
('1000000006', 'bphan', 'savings', 18240.24),
('1000000007', 'bphan', 'checking', 913.41),
('1000000008', 'edelacruz', 'savings', 9232.50),
('1000000009', 'edelacruz', 'checking', 1539.23),
('1000000010', 'mhammond', 'savings', 11247.84),
('1000000011', 'mhammond', 'checking', 2864.53),
('1000000012', 'mhammond', 'savings', 28712.86),
('1000000013', 'hbaker', 'savings', 1769.92),
('1000000014', 'hbaker', 'checking', 3289.54),
('1000000015', 'ekeller', 'savings', 23245.88),
('1000000016', 'lhill', 'savings', 9601.23),
('1000000017', 'iwoods', 'savings', 27152.07),
('1000000018', 'iwoods', 'checking', 4901.33),
('1000000019', 'iwoods', 'savings', 11600.59),
('1000000020', 'rhodges', 'savings', 5565.38),
('1000000021', 'rhodges', 'checking', 2088.73),
('1000000022', 'rhodges', 'savings', 26463.19),
('1000000023', 'aglover', 'savings', 1588.82),
('1000000024', 'abravo', 'savings', 21209.48),
('1000000025', 'gmoody', 'savings', 14146.90),
('1000000026', 'gmoody', 'checking', 1430.80),
('1000000027', 'gmoody', 'savings', 4536.53),
('1000000028', 'eweaver', 'savings', 32226.85),
('1000000029', 'eweaver', 'checking', 629.84),
('1000000030', 'eweaver', 'savings', 3359.67),
('1000000031', 'trosario', 'savings', 4944.85),
('1000000032', 'lescobar', 'savings', 25411.55),
('1000000033', 'lescobar', 'checking', 2549.46),
('1000000034', 'lescobar', 'savings', 17964.52),
('1000000035', 'zknox', 'savings', 17913.62),
('1000000036', 'karmstrong', 'savings', 25072.66),
('1000000037', 'karmstrong', 'checking', 4429.54),
('1000000038', 'gdavila', 'savings', 29812.35),
('1000000039', 'gdavila', 'checking', 1036.16),
('1000000040', 'rwhitney', 'savings', 5994.26),
('1000000041', 'jbooth', 'savings', 30838.52),
('1000000042', 'jbooth', 'checking', 1131.10),
('1000000043', 'jbooth', 'savings', 2011.67),
('1000000044', 'zlogan', 'savings', 19690.20),
('1000000045', 'rgaines', 'savings', 10893.63),
('1000000046', 'aserrano', 'savings', 14008.32),
('1000000047', 'mreed', 'savings', 16303.34),
('1000000048', 'vkeller', 'savings', 148.74),
('1000000049', 'vkeller', 'checking', 2109.08),
('1000000050', 'nhail', 'savings', 21318.08),
('1000000051', 'nhail', 'checking', 1361.34),
('1000000052', 'lphillips', 'savings', 29643.29),
('1000000053', 'lphillips', 'checking', 3489.28),
('1000000054', 'lphillips', 'savings', 30674.20),
('1000000056', 'swade', 'savings', 20259.98),
('1000000057', 'swade', 'checking', 3.15),
('1000000058', 'jmelendez', 'savings', 12392.35),
('1000000059', 'bcisneros', 'savings', 5589.82),
('1000000060', 'bcisneros', 'checking', 1410.41),
('1000000061', 'amarsh', 'savings', 9961.39),
('1000000062', 'amarsh', 'checking', 269.97),
('1000000063', 'anorman', 'savings', 14700.41),
('1000000064', 'anorman', 'checking', 1215.55),
('1000000065', 'adominguez', 'savings', 3039.82),
('1000000066', 'rmagana', 'savings', 1954.05),
('1000000067', 'rbarnes', 'savings', 24774.50),
('1000000068', 'rbarnes', 'checking', 1541.95),
('1000000069', 'lmerritt', 'savings', 25898.83),
('1000000070', 'lmerritt', 'checking', 3132.96),
('1000000071', 'lmerritt', 'savings', 10008.01),
('1000000072', 'cchung', 'savings', 1723.83),
('1000000073', 'rdawson', 'savings', 24778.10),
('1000000074', 'rdawson', 'checking', 1974.31),
('1000000075', 'rdawson', 'savings', 26153.85),
('1000000076', 'ileal', 'savings', 20825.96),
('1000000077', 'mjohnson', 'savings', 2598.39),
('1000000078', 'nprince', 'savings', 30080.96),
('1000000079', 'nprince', 'checking', 1528.49),
('1000000080', 'nprince', 'savings', 8405.66),
('1000000081', 'grhodes', 'savings', 7516.66),
('1000000082', 'grhodes', 'checking', 2681.04),
('1000000083', 'tcox', 'savings', 6021.12),
('1000000084', 'scannon', 'savings', 29309.25),
('1000000085', 'scannon', 'checking', 2124.51),
('1000000086', 'acampbell', 'savings', 28423.61),
('1000000089', 'lfuller', 'savings', 24114.49),
('1000000090', 'odonovan', 'savings', 12290.63),
('1000000091', 'balvarez', 'savings', 1054.85),
('1000000092', 'ldeleon', 'savings', 7491.12),
('1000000093', 'njacobson', 'savings', 16439.28),
('1000000094', 'rhawkins', 'savings', 6995.92),
('1000000095', 'rhawkins', 'checking', 3238.83),
('1000000096', 'vmeyer', 'savings', 17659.68),
('1000000097', 'scervantes', 'savings', 7462.83),
('1000000098', 'kboyd', 'savings', 1146.72),
('1000000099', 'kboyd', 'checking', 647.28),
('1000000100', 'kboyd', 'savings', 4098.20),
('1000000101', 'gklein', 'savings', 14600.98),
('1000000102', 'mli', 'savings', 20448.02),
('1000000103', 'mli', 'checking', 4575.72),
('1000000104', 'pdiaz', 'savings', 18397.78),
('1000000105', 'nsoto', 'savings', 13851.06),
('1000000106', 'nsoto', 'checking', 1925.98),
('1000000107', 'brose', 'savings', 10940.70),
('1000000108', 'harcher', 'savings', 1655.25),
('1000000109', 'harcher', 'checking', 1754.68),
('1000000110', 'kparker', 'savings', 26946.98),
('1000000111', 'cbarron', 'savings', 27663.55),
('1000000112', 'cbarron', 'checking', 475.85),
('1000000113', 'amoran', 'savings', 12570.45),
('1000000114', 'amoran', 'checking', 3962.41),
('1000000115', 'amoran', 'savings', 17469.30),
('1000000116', 'tdavis', 'savings', 28350.53),
('1000000117', 'mfrazier', 'savings', 19737.76),
('1000000118', 'cwebb', 'savings', 12393.46),
('1000000119', 'astephens', 'savings', 31591.59),
('1000000120', 'astephens', 'checking', 3337.74),
('1000000121', 'astephens', 'savings', 28664.80),
('1000000122', 'mbarnes', 'savings', 30568.51),
('1000000123', 'lpatel', 'savings', 18373.42),
('1000000124', 'phancock', 'savings', 23826.26),
('1000000125', 'phancock', 'checking', 4640.94),
('1000000126', 'phancock', 'savings', 32611.91),
('1000000127', 'kluna', 'savings', 8419.55),
('1000000128', 'kluna', 'checking', 1216.50),
('1000000129', 'kluna', 'savings', 11064.36),
('1000000130', 'esharp', 'savings', 16074.09),
('1000000131', 'esharp', 'checking', 4573.19),
('1000000132', 'cwolfe', 'savings', 17968.18),
('1000000133', 'dguerra', 'savings', 19426.20),
('1000000134', 'ecobb', 'savings', 8779.20),
('1000000135', 'rballard', 'savings', 25391.45),
('1000000136', 'aperry', 'savings', 1364.52),
('1000000137', 'wvazquez', 'savings', 474.12),
('1000000138', 'jmcconnell', 'savings', 25547.97),
('1000000139', 'jmcconnell', 'checking', 195.04),
('1000000140', 'jmcconnell', 'savings', 754.21),
('1000000141', 'lmarshall', 'savings', 11672.89),
('1000000142', 'aguerra', 'savings', 9762.87),
('1000000143', 'aguerra', 'checking', 1908.93),
('1000000144', 'lwatson', 'savings', 5204.96),
('1000000145', 'hcohen', 'savings', 5945.66),
('1000000146', 'kpowell', 'savings', 11367.72),
('1000000147', 'vcastaneda', 'savings', 30556.74),
('1000000148', 'vcastaneda', 'checking', 3283.12),
('1000000149', 'candrade', 'savings', 28583.38),
('1000000150', 'ehanson', 'savings', 22018.06),
('1000000151', 'ehanson', 'checking', 2182.06),
('1000000152', 'ehanson', 'savings', 4324.76),
('1000000153', 'kfaulkner', 'savings', 15969.43),
('1000000154', 'kfaulkner', 'checking', 2668.18),
('1000000155', 'ameyer', 'savings', 7783.78),
('1000000156', 'trocha', 'savings', 15871.27),
('1000000157', 'trocha', 'checking', 1027.58),
('1000000158', 'ecampbell', 'savings', 7185.78),
('1000000159', 'ecampbell', 'checking', 1313.01),
('1000000160', 'cortega', 'savings', 2111.90),
('1000000161', 'ljacobs', 'savings', 1454.19),
('1000000162', 'ljacobs', 'checking', 267.33),
('1000000163', 'bstout', 'savings', 25472.02),
('1000000164', 'bstout', 'checking', 3442.77),
('1000000165', 'cbruce', 'savings', 702.14),
('1000000166', 'upatrick', 'savings', 8823.37),
('1000000167', 'upatrick', 'checking', 1595.79),
('1000000168', 'abravo', 'savings', 69420.00),
('1000000169', 'abravo', 'checking', 666.00),
('1000000170', 'abravo', 'savings', 123456.00);

-- --------------------------------------------------------

--
-- Table structure for table `alteredaccount`
--

CREATE TABLE `alteredaccount` (
  `ticket_id` varchar(10) NOT NULL,
  `account_owner` varchar(20) NOT NULL,
  `account_type` varchar(10) DEFAULT NULL,
  `balance` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alteredaccount`
--

INSERT INTO `alteredaccount` (`ticket_id`, `account_owner`, `account_type`, `balance`) VALUES
('10105', 'bpierce', 'checking', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `altereduser`
--

CREATE TABLE `altereduser` (
  `ticket_id` varchar(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `f_name` varchar(20) DEFAULT NULL,
  `l_name` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone_num` varchar(10) DEFAULT NULL,
  `street_num` varchar(10) DEFAULT NULL,
  `street` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `altereduser`
--

INSERT INTO `altereduser` (`ticket_id`, `username`, `password`, `f_name`, `l_name`, `email`, `phone_num`, `street_num`, `street`, `city`) VALUES
('10103', 'abravo', '1756', 'Alessia', 'Bravo', 'abravo2@gmail.com', '3095551660', '308', 'Fredonia', 'Peoria'),
('10104', 'aleblanc', '1961', 'Arabella', 'Leblanc', 'aleblanc@gmail.com', '3095557251', '409', 'Taiga St.', 'East Peoria');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `f_name` varchar(20) DEFAULT NULL,
  `l_name` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone_num` varchar(10) DEFAULT NULL,
  `street_num` varchar(10) DEFAULT NULL,
  `street` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`username`, `password`, `f_name`, `l_name`, `email`, `phone_num`, `street_num`, `street`, `city`) VALUES
('', '', '', '', '', '', '', '', ''),
('abravo', '1756', 'Alessia', 'Bravo', 'abravo@gmail.com', '3095551660', '308', 'Fredonia', 'Peoria'),
('acampbell', '8105', 'Archie', 'Campbell', 'acampbell@gmail.com', '3095554528', '114', 'Main St.', 'Peoria'),
('adominguez', '7191', 'Aziel', 'Dominguez', 'adominguez@gmail.com', '3095551685', '202', 'Fredonia Ave.', 'Peoria'),
('afitzpatrick', '1041', 'Adaline', 'Fitzpatrick', 'afitzpatrick@gmail.com', '3095559047', '224', 'Elmwood Ave.', 'Peoria'),
('aglover', '5101', 'Alonzo', 'Glover', 'aglover@gmail.com', '3095553983', '84', 'Main St.', 'Peoria'),
('aguerra', '5532', 'Adalyn', 'Guerra', 'aguerra@gmail.com', '3095551373', '135', 'Frink St.', 'Peoria'),
('aleblanc', '1961', 'Arabella', 'Leblanc', 'aleblanc@gmail.com', '3095557251', '436', 'Bradley St.', 'Peoria'),
('amarsh', '7281', 'Alden', 'Marsh', 'amarsh@gmail.com', '3095557989', '472', 'Fredonia Ave.', 'Peoria'),
('ameyer', '1875', 'Ansley', 'Meyer', 'ameyer@gmail.com', '3095557082', '432', 'Frink St.', 'Peoria'),
('amoran', '2018', 'Anya', 'Moran', 'amoran@gmail.com', '3095550294', '87', 'Main St.', 'Peoria'),
('anorman', '1538', 'Adelina', 'Norman', 'anorman@gmail.com', '3095550982', '157', 'University St.', 'Peoria'),
('aperry', '3337', 'Alejandra', 'Perry', 'aperry@gmail.com', '3095556191', '22', 'Moss Ave.', 'Peoria'),
('aserrano', '4602', 'Aya', 'Serrano', 'aserrano@gmail.com', '3095554610', '20', 'Fredonia Ave.', 'Peoria'),
('astephens', '8423', 'Ariella', 'Stephens', 'astephens@gmail.com', '3095553220', '96', 'University St.', 'Peoria'),
('balvarez', '3222', 'Brayan', 'Alvarez', 'balvarez@gmail.com', '3095550519', '173', 'Columbia Ter.', 'Peoria'),
('bcisneros', '8448', 'Bethany', 'Cisneros', 'bcisneros@gmail.com', '3095550880', '296', 'University St.', 'Peoria'),
('bphan', '6604', 'Braden', 'Phan', 'bphan@gmail.com', '3095552232', '421', 'Frink St.', 'Peoria'),
('bpierce', '3358', 'Blaze', 'Pierce', 'bpierce@gmail.com', '3095555542', '281', 'Fredonia Ave.', 'Peoria'),
('brose', '5413', 'Brynlee', 'Rose', 'brose@gmail.com', '3095555004', '333', 'Main St.', 'Peoria'),
('bstout', '6997', 'Bryan', 'Stout', 'bstout@gmail.com', '3095557169', '467', 'Elmwood Ave.', 'Peoria'),
('candrade', '8705', 'Collin', 'Andrade', 'candrade@gmail.com', '3095550182', '413', 'Bradley St.', 'Peoria'),
('cbarron', '9302', 'Caleb', 'Barron', 'cbarron@gmail.com', '3095553861', '351', 'Frink St.', 'Peoria'),
('cbruce', '9129', 'Chana', 'Bruce', 'cbruce@gmail.com', '3095551430', '77', 'Main St.', 'Peoria'),
('cchung', '7389', 'Colten', 'Chung', 'cchung@gmail.com', '3095550025', '3', 'Institute Pl.', 'Peoria'),
('cortega', '9740', 'Christopher', 'Ortega', 'cortega@gmail.com', '3095559584', '192', 'Bradley St.', 'Peoria'),
('cwebb', '4487', 'Callum', 'Webb', 'cwebb@gmail.com', '3095557547', '129', 'Frink St.', 'Peoria'),
('cwolfe', '2357', 'Camryn', 'Wolfe', 'cwolfe@gmail.com', '3095553874', '387', 'Main St.', 'Peoria'),
('dguerra', '5850', 'Donovan', 'Guerra', 'dguerra@gmail.com', '3095554380', '405', 'Fredonia Ave.', 'Peoria'),
('ecampbell', '2497', 'Emmie', 'Campbell', 'ecampbell@gmail.com', '3095553509', '314', 'Elmwood Ave.', 'Peoria'),
('ecobb', '5111', 'Edith', 'Cobb', 'ecobb@gmail.com', '3095552654', '350', 'Institute Pl.', 'Peoria'),
('edelacruz', '2718', 'Elsa', 'Delacruz', 'edelacruz@gmail.com', '3095551675', '38', 'Fredonia Ave.', 'Peoria'),
('ehanson', '2855', 'Emmy', 'Hanson', 'ehanson@gmail.com', '3095551225', '377', 'Elmwood Ave.', 'Peoria'),
('ekeller', '7868', 'Ezra', 'Keller', 'ekeller@gmail.com', '3095557247', '37', 'Moss Ave.', 'Peoria'),
('esharp', '5007', 'Erick', 'Sharp', 'esharp@gmail.com', '3095559807', '303', 'Moss Ave.', 'Peoria'),
('eweaver', '5929', 'Elaine', 'Weaver', 'eweaver@gmail.com', '3095559531', '158', 'Fredonia Ave.', 'Peoria'),
('gdavila', '4724', 'Grant', 'Davila', 'gdavila@gmail.com', '3095551706', '7', 'Fredonia Ave.', 'Peoria'),
('gklein', '4102', 'Georgia', 'Klein', 'gklein@gmail.com', '3095552730', '99', 'Columbia Ter.', 'Peoria'),
('gmoody', '6439', 'Genesis', 'Moody', 'gmoody@gmail.com', '3095558736', '118', 'Elmwood Ave.', 'Peoria'),
('grhodes', '8441', 'Greta', 'Rhodes', 'grhodes@gmail.com', '3095558052', '253', 'University St.', 'Peoria'),
('harcher', '8760', 'Hayden', 'Archer', 'harcher@gmail.com', '3095550576', '140', 'Frink St.', 'Peoria'),
('hbaker', '5322', 'Holly', 'Baker', 'hbaker@gmail.com', '3095551433', '211', 'University St.', 'Peoria'),
('hcohen', '5741', 'Hailey', 'Cohen', 'hcohen@gmail.com', '3095551595', '370', 'Fredonia Ave.', 'Peoria'),
('ileal', '2585', 'Iker', 'Leal', 'ileal@gmail.com', '3095556852', '117', 'Fredonia Ave.', 'Peoria'),
('iwoods', '2842', 'Isaac', 'Woods', 'iwoods@gmail.com', '3095552068', '264', 'Institute Pl.', 'Peoria'),
('jbooth', '1758', 'Jeffery', 'Booth', 'jbooth@gmail.com', '3095556281', '6', 'Moss Ave.', 'Peoria'),
('jmcconnell', '7229', 'Journee', 'McConnell', 'jmcconnell@gmail.com', '3095556295', '355', 'University St.', 'Peoria'),
('jmelendez', '3485', 'Jake', 'Melendez', 'jmelendez@gmail.com', '3095557333', '314', 'Columbia Ter.', 'Peoria'),
('karmstrong', '6655', 'Kallie', 'Armstrong', 'karmstrong@gmail.com', '3095550214', '150', 'Elmwood Ave.', 'Peoria'),
('kboyd', '9177', 'Kamari', 'Boyd', 'kboyd@gmail.com', '3095558303', '192', 'Columbia Ter.', 'Peoria'),
('kfaulkner', '6678', 'Khalil', 'Faulkner', 'kfaulkner@gmail.com', '3095553632', '40', 'Moss Ave.', 'Peoria'),
('kluna', '1662', 'Katelyn', 'Luna', 'kluna@gmail.com', '3095558309', '78', 'Institute Pl.', 'Peoria'),
('kparker', '3695', 'Kadence', 'Parker', 'kparker@gmail.com', '3095556594', '194', 'Frink St.', 'Peoria'),
('kpowell', '5934', 'Killian', 'Powell', 'kpowell@gmail.com', '3095558035', '279', 'Elmwood Ave.', 'Peoria'),
('ldeleon', '4044', 'Leilani', 'Deleon', 'ldeleon@gmail.com', '3095553929', '24', 'Bradley St.', 'Peoria'),
('lescobar', '9924', 'Louisa', 'Escobar', 'lescobar@gmail.com', '3095557902', '73', 'Elmwood Ave.', 'Peoria'),
('lfuller', '3053', 'Lawson', 'Fuller', 'lfuller@gmail.com', '3095555282', '313', 'Bradley St.', 'Peoria'),
('lhill', '9723', 'Logan', 'Hill', 'lhill@gmail.com', '3095556891', '35', 'Frink St.', 'Peoria'),
('ljacobs', '8264', 'Lilah', 'Jacobs', 'ljacobs@gmail.com', '3095555931', '108', 'Fredonia Ave.', 'Peoria'),
('lmarshall', '8962', 'London', 'Marshall', 'lmarshall@gmail.com', '3095552444', '457', 'Frink St.', 'Peoria'),
('lmerritt', '2322', 'Liliana', 'Merritt', 'lmerritt@gmail.com', '3095557911', '476', 'Main St.', 'Peoria'),
('lpatel', '6030', 'Liliana', 'Patel', 'lpatel@gmail.com', '3095551116', '47', 'Elmwood Ave.', 'Peoria'),
('lphillips', '6310', 'Lainey', 'Phillips', 'lphillips@gmail.com', '3095559437', '116', 'Columbia Ter.', 'Peoria'),
('lwatson', '5848', 'Leland', 'Watson', 'lwatson@gmail.com', '3095552385', '254', 'Institute Pl.', 'Peoria'),
('mbarnes', '5261', 'Messiah', 'Barnes', 'mbarnes@gmail.com', '3095550455', '202', 'Moss Ave.', 'Peoria'),
('mfrazier', '4043', 'Mia', 'Frazier', 'mfrazier@gmail.com', '3095552948', '86', 'Bradley St.', 'Peoria'),
('mhammond', '2912', 'Memphis', 'Hammond', 'mhammond@gmail.com', '3095554597', '203', 'Fredonia Ave.', 'Peoria'),
('mjohnson', '1832', 'Murphy', 'Johnson', 'mjohnson@gmail.com', '3095551492', '189', 'Frink St.', 'Peoria'),
('mli', '3625', 'Marco', 'Li', 'mli@gmail.com', '3095552343', '61', 'Fredonia Ave.', 'Peoria'),
('mreed', '7021', 'Milan', 'Reed', 'mreed@gmail.com', '3095554898', '281', 'Bradley St.', 'Peoria'),
('nhail', '1467', 'Nico', 'Hail', 'nhail@gmail.com', '3095553838', '307', 'Bradley St.', 'Peoria'),
('njacobson', '3510', 'Nasir', 'Jacobson', 'njacobson@gmail.com', '3095553695', '474', 'Frink St.', 'Peoria'),
('nprince', '5329', 'Noah', 'Prince', 'nprince@gmail.com', '3095555528', '434', 'Moss Ave.', 'Peoria'),
('nsoto', '1142', 'Nathan', 'Soto', 'nsoto@gmail.com', '3095550462', '187', 'Columbia Ter.', 'Peoria'),
('odonovan', '2321', 'Oakley', 'Donovan', 'odonovan@gmail.com', '3095551268', '144', 'Elmwood Ave.', 'Peoria'),
('pdiaz', '5003', 'Paige', 'Diaz', 'pdiaz@gmail.com', '3095555352', '31', 'Frink St.', 'Peoria'),
('phancock', '4520', 'Parker', 'Hancock', 'phancock@gmail.com', '3095553840', '440', 'Moss Ave.', 'Peoria'),
('rballard', '6485', 'Raphael', 'Ballard', 'rballard@gmail.com', '3095557666', '26', 'Main St.', 'Peoria'),
('rbarnes', '2433', 'Rey', 'Barnes', 'rbarnes@gmail.com', '3095556429', '381', 'Elmwood Ave.', 'Peoria'),
('rdawson', '9861', 'Rivka', 'Dawson', 'rdawson@gmail.com', '3095555918', '423', 'Moss Ave.', 'Peoria'),
('rgaines', '7359', 'Rocco', 'Gaines', 'rgaines@gmail.com', '3095553874', '95', 'Bradley St.', 'Peoria'),
('rhawkins', '3168', 'Royal', 'Hawkins', 'rhawkins@gmail.com', '3095558578', '391', 'Frink St.', 'Peoria'),
('rhodges', '1446', 'Reese', 'Hodges', 'rhodges@gmail.com', '3095550905', '350', 'Elmwood Ave.', 'Peoria'),
('rmagana', '7272', 'Raegan', 'Magana', 'rmagana@gmail.com', '3095552685', '386', 'University St.', 'Peoria'),
('rwhitney', '7457', 'Rayne', 'Whitney', 'rwhitney@gmail.com', '3095555337', '409', 'Moss Ave.', 'Peoria'),
('scannon', '2866', 'Sadie', 'Cannon', 'scannon@gmail.com', '3095557539', '416', 'Columbia Ter.', 'Peoria'),
('scervantes', '7372', 'Sara', 'Cervantes', 'scervantes@gmail.com', '3095557039', '297', 'Elmwood Ave.', 'Peoria'),
('swade', '7224', 'Serenity', 'Wade', 'swade@gmail.com', '3095559948', '202', 'Bradley St.', 'Peoria'),
('tcox', '4423', 'Titus', 'Cox', 'tcox@gmail.com', '3095559769', '49', 'Institute Pl.', 'Peoria'),
('tdavis', '2926', 'Tate', 'Davis', 'tdavis@gmail.com', '3095555070', '76', 'Frink St.', 'Peoria'),
('trocha', '4695', 'Tristan', 'Rocha', 'trocha@gmail.com', '3095558019', '185', 'Main St.', 'Peoria'),
('trosario', '1930', 'Tucker', 'Rosario', 'trosario@gmail.com', '3095556367', '21', 'Columbia Ter.', 'Peoria'),
('upatrick', '9683', 'Uriah', 'Patrick', 'upatrick@gmail.com', '3095551423', '392', 'Bradley St.', 'Peoria'),
('vcastaneda', '4193', 'Vivian', 'Castaneda', 'vcastaneda@gmail.com', '3095556474', '493', 'Fredonia Ave.', 'Peoria'),
('vkeller', '1053', 'Valentina', 'Keller', 'vkeller@gmail.com', '3095550889', '288', 'Main St.', 'Peoria'),
('vmeyer', '4625', 'Victor', 'Meyer', 'vmeyer@gmail.com', '3095554447', '334', 'Columbia Ter.', 'Peoria'),
('wvazquez', '2112', 'Waylon', 'Vazquez', 'wvazquez@gmail.com', '3095551567', '423', 'Bradley St.', 'Peoria'),
('zknox', '8512', 'Zachariah', 'Knox', 'zknox@gmail.com', '3095556106', '355', 'Columbia Ter.', 'Peoria'),
('zlogan', '8413', 'Zariyah', 'Logan', 'zlogan@gmail.com', '3095552108', '155', 'Institute Pl.', 'Peoria');

--
-- Triggers `client`
--
DELIMITER $$
CREATE TRIGGER `delete_client_trigger` BEFORE DELETE ON `client` FOR EACH ROW BEGIN
	UPDATE transaction SET transaction.send_account = "REMOVED" WHERE transaction.send_account IN (SELECT account_id FROM account WHERE account_owner = OLD.username);
  
  UPDATE transaction SET transaction.rec_account = "REMOVED" WHERE transaction.rec_account IN (SELECT account_id FROM account WHERE account_owner = OLD.username);

  -- Delete related rows from the account table
  DELETE FROM account WHERE account.account_owner = OLD.username;

  -- Delete Tranaction Rows where both send and rec accounts have been deleted/no longer exist
  DELETE FROM TRANSACTION WHERE transaction.send_account = "REMOVED" and transaction.rec_account = "REMOVED";

  -- Delete related rows from the ticket table
  #DELETE FROM ticket WHERE ticket.ticket_owner = OLD.username;
  
  -- Added on 4-23-24 for deleting tickets
    DELETE FROM altereduser WHERE ticket_id IN (SELECT ticket_id FROM ticket WHERE ticket_owner = OLD.username);
    
    DELETE FROM alteredaccount WHERE ticket_id IN (SELECT ticket_id FROM ticket WHERE ticket_owner = OLD.username);
    
    -- Delete related rows from the ticket table
  DELETE FROM ticket WHERE ticket.ticket_owner = OLD.username;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `new_del_client_trigger` BEFORE DELETE ON `client` FOR EACH ROW BEGIN
    -- Update tickets in altereduser table
    DELETE FROM altereduser WHERE ticket_id IN (SELECT ticket_id FROM ticket WHERE ticket_owner = OLD.username);
  
    -- Delete related rows from the ticket table
    DELETE FROM ticket WHERE ticket_owner = OLD.username;

    -- Update transactions
    UPDATE transaction SET send_account = "REMOVED" WHERE send_account IN (SELECT account_id FROM account WHERE account_owner = OLD.username);
    UPDATE transaction SET rec_account = "REMOVED" WHERE rec_account IN (SELECT account_id FROM account WHERE account_owner = OLD.username);
    
    -- Delete related rows from the account table
    DELETE FROM account WHERE account_owner = OLD.username;

    -- Delete transactions where both send and rec accounts have been deleted
    DELETE FROM transaction WHERE send_account = "REMOVED" AND rec_account = "REMOVED";
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateClientInfo` AFTER UPDATE ON `client` FOR EACH ROW begin
  if (new.username != old.username and new.username is not null)
  then CALL updateClientAccounts(old.username, new.username);
  
CALL updateClientTickets(old.username, new.username);
 END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `lastestaccount`
-- (See below for the actual view)
--
CREATE TABLE `lastestaccount` (
`account_id` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `latestticket`
-- (See below for the actual view)
--
CREATE TABLE `latestticket` (
`ticket_id` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `latesttransaction`
-- (See below for the actual view)
--
CREATE TABLE `latesttransaction` (
`transaction_id` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tempyboi`
-- (See below for the actual view)
--
CREATE TABLE `tempyboi` (
`username` varchar(20)
,`password` varchar(20)
,`f_name` varchar(20)
,`l_name` varchar(20)
,`email` varchar(50)
,`phone_num` varchar(10)
,`street_num` varchar(10)
,`street` varchar(20)
,`city` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` varchar(10) NOT NULL,
  `ticket_owner` varchar(20) DEFAULT NULL,
  `priority` varchar(1) DEFAULT NULL,
  `description` varchar(20) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticket_id`, `ticket_owner`, `priority`, `description`, `timestamp`) VALUES
('10102', NULL, NULL, NULL, NULL),
('10103', 'abravo', '2', 'Update Client Info', '2024-04-30 02:00:37'),
('10104', 'aleblanc', '2', 'Update Client Info', '2024-04-30 02:02:28'),
('10105', 'bpierce', '4', 'Add account', '2024-04-30 02:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` varchar(10) NOT NULL,
  `send_account` varchar(10) DEFAULT NULL,
  `rec_account` varchar(10) DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `send_account`, `rec_account`, `amount`, `timestamp`) VALUES
('1000000001', '1000000082', '1000000127', 58.00, '2024-01-01 06:00:00'),
('1000000002', '1000000136', '1000000001', 528.00, '2024-01-02 11:00:00'),
('1000000003', 'REMOVED', '1000000033', 860.00, '2024-01-03 07:00:00'),
('1000000004', '1000000078', '1000000071', 610.00, '2024-01-04 08:00:00'),
('1000000005', '1000000115', '1000000065', 841.00, '2024-01-05 06:00:00'),
('1000000006', '1000000164', '1000000005', 865.00, '2024-01-06 18:00:00'),
('1000000007', '1000000045', '1000000073', 750.00, '2024-01-07 06:00:00'),
('1000000008', '1000000062', '1000000069', 661.00, '2024-01-08 23:00:00'),
('1000000009', '1000000025', '1000000100', 278.00, '2024-01-09 01:00:00'),
('1000000010', '1000000064', '1000000020', 75.00, '2024-01-10 02:00:00'),
('1000000011', '1000000051', '1000000152', 360.00, '2024-01-11 10:00:00'),
('1000000012', '1000000164', '1000000078', 492.00, '2024-01-12 01:00:00'),
('1000000013', '1000000127', 'REMOVED', 735.00, '2024-01-13 10:00:00'),
('1000000014', '1000000077', '1000000148', 892.00, '2024-01-14 14:00:00'),
('1000000015', '1000000148', '1000000128', 369.00, '2024-01-15 20:00:00'),
('1000000016', '1000000085', '1000000096', 252.00, '2024-01-16 07:00:00'),
('1000000017', '1000000065', '1000000017', 208.00, '2024-01-17 00:00:00'),
('1000000018', '1000000158', '1000000031', 649.00, '2024-01-18 07:00:00'),
('1000000019', '1000000122', '1000000023', 100.00, '2024-01-19 12:00:00'),
('1000000020', 'REMOVED', '1000000005', 851.00, '2024-01-20 18:00:00'),
('1000000021', '1000000077', '1000000166', 200.00, '2024-01-21 06:00:00'),
('1000000022', '1000000138', '1000000147', 919.00, '2024-01-22 20:00:00'),
('1000000023', '1000000034', '1000000073', 544.00, '2024-01-23 04:00:00'),
('1000000024', '1000000128', '1000000065', 525.00, '2024-01-24 11:00:00'),
('1000000025', '1000000028', '1000000145', 193.00, '2024-01-25 04:00:00'),
('1000000026', '1000000129', '1000000058', 834.00, '2024-01-26 16:00:00'),
('1000000027', '1000000102', '1000000114', 529.00, '2024-01-27 04:00:00'),
('1000000028', '1000000102', '1000000068', 392.00, '2024-01-28 10:00:00'),
('1000000029', '1000000023', '1000000036', 979.00, '2024-01-29 11:00:00'),
('1000000030', '1000000093', '1000000074', 193.00, '2024-02-01 12:00:00'),
('1000000031', '1000000122', '1000000133', 276.00, '2024-02-02 14:00:00'),
('1000000032', '1000000070', '1000000052', 159.00, '2024-02-03 18:00:00'),
('1000000033', '1000000104', '1000000160', 449.00, '2024-02-04 12:00:00'),
('1000000034', 'REMOVED', '1000000027', 8.00, '2024-02-05 07:00:00'),
('1000000035', '1000000022', '1000000132', 503.00, '2024-02-06 10:00:00'),
('1000000036', '1000000043', '1000000002', 74.00, '2024-02-07 18:00:00'),
('1000000037', 'REMOVED', '1000000149', 761.00, '2024-02-08 16:00:00'),
('1000000038', '1000000032', '1000000102', 683.00, '2024-02-09 12:00:00'),
('1000000039', '1000000060', '1000000069', 741.00, '2024-02-10 10:00:00'),
('1000000040', '1000000134', '1000000024', 396.00, '2024-02-11 04:00:00'),
('1000000041', '1000000075', '1000000050', 599.00, '2024-02-12 00:00:00'),
('1000000042', '1000000005', '1000000014', 32.00, '2024-02-13 11:00:00'),
('1000000043', '1000000020', '1000000060', 517.00, '2024-02-14 14:00:00'),
('1000000044', '1000000154', '1000000075', 882.00, '2024-02-15 01:00:00'),
('1000000045', '1000000017', '1000000029', 105.00, '2024-02-16 05:00:00'),
('1000000046', '1000000062', '1000000116', 916.00, '2024-02-17 06:00:00'),
('1000000047', '1000000159', '1000000053', 58.00, '2024-02-18 01:00:00'),
('1000000048', '1000000059', '1000000147', 729.00, '2024-02-19 09:00:00'),
('1000000049', '1000000157', '1000000007', 676.00, '2024-02-20 09:00:00'),
('1000000050', '1000000025', '1000000095', 565.00, '2024-02-21 21:00:00'),
('1000000051', '1000000082', '1000000161', 243.00, '2024-02-22 01:00:00'),
('1000000052', '1000000167', '1000000149', 55.00, '2024-02-23 07:00:00'),
('1000000053', '1000000129', '1000000072', 748.00, '2024-02-24 11:00:00'),
('1000000054', '1000000132', '1000000141', 446.00, '2024-02-25 17:00:00'),
('1000000055', '1000000132', '1000000101', 916.00, '2024-02-26 18:00:00'),
('1000000056', '1000000094', '1000000106', 912.00, '2024-02-27 10:00:00'),
('1000000057', '1000000133', '1000000074', 815.00, '2024-02-28 21:00:00'),
('1000000058', '1000000138', '1000000100', 52.00, '2024-02-29 20:00:00'),
('1000000059', '1000000035', '1000000136', 226.00, '2024-03-01 10:00:00'),
('1000000060', '1000000089', '1000000138', 394.00, '2024-03-02 12:00:00'),
('1000000061', '1000000066', '1000000060', 65.00, '2024-03-03 17:00:00'),
('1000000062', '1000000077', '1000000054', 78.00, '2024-03-04 06:00:00'),
('1000000063', '1000000113', '1000000103', 947.00, '2024-03-05 21:00:00'),
('1000000064', '1000000004', '1000000083', 489.00, '2024-03-06 06:00:00'),
('1000000065', '1000000138', '1000000161', 865.00, '2024-03-07 14:00:00'),
('1000000066', '1000000082', '1000000121', 432.00, '2024-03-08 16:00:00'),
('1000000067', '1000000002', '1000000133', 882.00, '2024-03-09 10:00:00'),
('1000000068', '1000000107', '1000000051', 187.00, '2024-03-10 09:00:00'),
('1000000069', '1000000134', '1000000143', 538.00, '2024-03-11 07:00:00'),
('1000000070', '1000000076', '1000000161', 646.00, '2024-03-12 04:00:00'),
('1000000071', '1000000042', '1000000130', 422.00, '2024-03-13 18:00:00'),
('1000000072', '1000000137', '1000000116', 28.00, '2024-03-14 22:00:00'),
('1000000073', '1000000018', '1000000029', 777.00, '2024-03-15 04:00:00'),
('1000000074', '1000000146', '1000000007', 431.00, '2024-03-16 18:00:00'),
('1000000075', '1000000098', '1000000003', 106.00, '2024-03-17 16:00:00'),
('1000000076', '1000000124', '1000000096', 281.00, '2024-03-18 05:00:00'),
('1000000077', '1000000074', '1000000083', 124.00, '2024-03-19 06:00:00'),
('1000000078', '1000000118', '1000000021', 774.00, '2024-03-20 03:00:00'),
('1000000079', '1000000116', '1000000051', 253.00, '2024-03-21 10:00:00'),
('1000000080', '1000000115', '1000000141', 888.00, '2024-03-22 17:00:00'),
('1000000081', '1000000040', '1000000072', 680.00, '2024-03-23 06:00:00'),
('1000000082', '1000000128', '1000000105', 801.00, '2024-03-24 01:00:00'),
('1000000083', '1000000005', '1000000148', 363.00, '2024-03-25 04:00:00'),
('1000000084', '1000000053', '1000000166', 245.00, '2024-03-26 17:00:00'),
('1000000085', '1000000052', '1000000048', 353.00, '2024-03-27 05:00:00'),
('1000000086', '1000000113', '1000000028', 110.00, '2024-03-28 19:00:00'),
('1000000087', '1000000098', '1000000159', 529.00, '2024-03-29 21:00:00'),
('1000000088', '1000000109', '1000000117', 381.00, '2024-04-01 15:00:00'),
('1000000089', '1000000004', '1000000139', 805.00, '2024-04-02 20:00:00'),
('1000000090', '1000000140', '1000000149', 320.00, '2024-04-03 05:00:00'),
('1000000091', '1000000068', '1000000140', 293.00, '2024-04-04 22:00:00'),
('1000000092', '1000000026', '1000000082', 206.00, '2024-04-05 03:00:00'),
('1000000093', '1000000131', '1000000057', 697.00, '2024-04-06 12:00:00'),
('1000000094', '1000000148', '1000000166', 788.00, '2024-04-07 13:00:00'),
('1000000095', '1000000116', '1000000113', 978.00, '2024-04-08 17:00:00'),
('1000000096', '1000000008', '1000000094', 684.00, '2024-04-09 00:00:00'),
('1000000097', '1000000038', '1000000044', 97.00, '2024-04-10 14:00:00'),
('1000000098', '1000000009', '1000000003', 785.00, '2024-04-11 14:00:00'),
('1000000099', '1000000162', '1000000063', 710.00, '2024-04-12 07:00:00'),
('1000000100', '1000000116', '1000000028', 85.00, '2024-04-13 06:00:00');

-- --------------------------------------------------------

--
-- Structure for view `lastestaccount`
--
DROP TABLE IF EXISTS `lastestaccount`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lastestaccount`  AS SELECT `account`.`account_id` AS `account_id` FROM `account` ORDER BY `account`.`account_id` DESC LIMIT 0, 1 ;

-- --------------------------------------------------------

--
-- Structure for view `latestticket`
--
DROP TABLE IF EXISTS `latestticket`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `latestticket`  AS SELECT `ticket`.`ticket_id` AS `ticket_id` FROM `ticket` ORDER BY `ticket`.`ticket_id` DESC LIMIT 0, 1 ;

-- --------------------------------------------------------

--
-- Structure for view `latesttransaction`
--
DROP TABLE IF EXISTS `latesttransaction`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `latesttransaction`  AS SELECT `transaction`.`transaction_id` AS `transaction_id` FROM `transaction` ORDER BY `transaction`.`transaction_id` DESC LIMIT 0, 1 ;

-- --------------------------------------------------------

--
-- Structure for view `tempyboi`
--
DROP TABLE IF EXISTS `tempyboi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tempyboi`  AS SELECT `altereduser`.`username` AS `username`, `altereduser`.`password` AS `password`, `altereduser`.`f_name` AS `f_name`, `altereduser`.`l_name` AS `l_name`, `altereduser`.`email` AS `email`, `altereduser`.`phone_num` AS `phone_num`, `altereduser`.`street_num` AS `street_num`, `altereduser`.`street` AS `street`, `altereduser`.`city` AS `city` FROM `altereduser` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `account_ibfk_1` (`account_owner`);

--
-- Indexes for table `alteredaccount`
--
ALTER TABLE `alteredaccount`
  ADD PRIMARY KEY (`ticket_id`) USING BTREE;

--
-- Indexes for table `altereduser`
--
ALTER TABLE `altereduser`
  ADD PRIMARY KEY (`ticket_id`) USING BTREE;

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `ticket_ibfk_1` (`ticket_owner`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `send_account` (`send_account`),
  ADD KEY `rec_account` (`rec_account`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`account_owner`) REFERENCES `client` (`username`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
