-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 03, 2020 at 09:28 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `f34ee`
--

-- --------------------------------------------------------

--
-- Table structure for table `Booking`
--

CREATE TABLE IF NOT EXISTS `Booking` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PremiereDate` date NOT NULL,
  `TimeslotId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `TimeslotId` (`TimeslotId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `Booking`
--

INSERT INTO `Booking` (`Id`, `PremiereDate`, `TimeslotId`, `UserId`) VALUES
(15, '2020-11-02', 70, 4),
(16, '2020-11-02', 40, 4),
(17, '2020-11-02', 55, 4),
(18, '2020-11-02', 55, 4),
(19, '2020-11-02', 46, 5),
(20, '2020-11-08', 55, 6),
(21, '2020-11-08', 55, 6);

-- --------------------------------------------------------

--
-- Table structure for table `Card`
--

CREATE TABLE IF NOT EXISTS `Card` (
  `CardNumber` char(16) NOT NULL,
  `Name` text NOT NULL,
  `CVV` char(3) NOT NULL,
  `ExpiryDate` char(5) NOT NULL,
  PRIMARY KEY (`CardNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Card`
--

INSERT INTO `Card` (`CardNumber`, `Name`, `CVV`, `ExpiryDate`) VALUES
('1234123412341234', 'John Doe', '123', '11/22'),
('1234123412341235', 'abc ABCDD', '111', '12/20'),
('1234561234561234', 'Hue Jin Nee', '321', '11/22'),
('1234567890234567', 'Jane Rose Doe', '222', '11/22'),
('4242424242424242', 'Tester', '424', '24/24');

-- --------------------------------------------------------

--
-- Table structure for table `CardHolder`
--

CREATE TABLE IF NOT EXISTS `CardHolder` (
  `UserId` int(11) NOT NULL,
  `CardNumber` char(16) NOT NULL,
  PRIMARY KEY (`UserId`,`CardNumber`),
  KEY `UserId` (`UserId`),
  KEY `CardNumber` (`CardNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `CardHolder`
--

INSERT INTO `CardHolder` (`UserId`, `CardNumber`) VALUES
(1, '4242424242424242'),
(3, '1234567890234567'),
(4, '1234123412341234'),
(5, '1234561234561234'),
(6, '1234123412341235');

-- --------------------------------------------------------

--
-- Table structure for table `Cast`
--

CREATE TABLE IF NOT EXISTS `Cast` (
  `PeopleId` int(11) NOT NULL,
  `MovieDetailId` int(11) NOT NULL,
  PRIMARY KEY (`MovieDetailId`,`PeopleId`),
  KEY `PeopleId` (`PeopleId`),
  KEY `MovieDetailId` (`MovieDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Cast`
--

INSERT INTO `Cast` (`PeopleId`, `MovieDetailId`) VALUES
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(28, 5),
(29, 5),
(30, 5),
(32, 6),
(33, 6),
(34, 6),
(35, 6),
(36, 6),
(38, 7),
(39, 7),
(40, 7),
(41, 7),
(43, 8),
(44, 8),
(45, 8),
(46, 8),
(48, 9),
(49, 9),
(51, 9),
(52, 9),
(54, 10),
(55, 10),
(56, 10),
(57, 10),
(58, 10);

-- --------------------------------------------------------

--
-- Table structure for table `Director`
--

CREATE TABLE IF NOT EXISTS `Director` (
  `PeopleId` int(11) NOT NULL,
  `MovieDetailId` int(11) NOT NULL,
  PRIMARY KEY (`MovieDetailId`,`PeopleId`),
  KEY `MovieDetailId` (`MovieDetailId`),
  KEY `PeopleId` (`PeopleId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Director`
--

INSERT INTO `Director` (`PeopleId`, `MovieDetailId`) VALUES
(1, 1),
(10, 2),
(15, 3),
(22, 4),
(27, 5),
(31, 6),
(37, 7),
(42, 8),
(47, 9),
(53, 10);

-- --------------------------------------------------------

--
-- Table structure for table `MovieDetail`
--

CREATE TABLE IF NOT EXISTS `MovieDetail` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Language` text NOT NULL,
  `Genre` text NOT NULL,
  `ReleaseDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Duration` int(11) NOT NULL,
  `Rating` float(2,1) NOT NULL,
  `Synopsis` text NOT NULL,
  `Name` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `MovieDetail`
--

INSERT INTO `MovieDetail` (`Id`, `Language`, `Genre`, `ReleaseDate`, `Duration`, `Rating`, `Synopsis`, `Name`) VALUES
(1, 'English', 'Action, Adventure', '2020-03-17 16:00:00', 120, 3.4, 'To save her ailing father from serving in the Imperial Army, a fearless young woman disguises herself as a man to battle northern invaders in China.', 'Mulan'),
(2, 'English', 'Action, Adventure', '2020-09-20 16:00:00', 90, 3.0, 'A tank truck crashes in a tunnel in the ice-cold Norwegian mountains, brutally trapping families, teenagers and tourists on their way home for Christmas. A blizzard is raging outside and the first responders struggle to get to the scene of the accident. The wrecked tanker catches fire and the tunnel is filled with deadly smoke. Will the help get there in time?', 'The Tunnel'),
(3, 'English', 'Horror, Thriller', '2020-09-21 16:00:00', 86, 4.2, 'Separated from her fiance after sneaking onto a restricted slope, Mia, a free riding snowboarder, must survive not only against nature, but the masked snowmobile rider in black who''s out for her blood.', 'Let It Snow'),
(4, 'Mandarin, English', 'Crime, Action', '2020-09-29 16:00:00', 108, 5.0, 'Vanguard is a 2020 Chinese action adventure spy-thriller drama film written and directed by Stanley Tong, starring Jackie Chan (in his sixth collaboration with Tong), Yang Yang and Miya Muqi.', 'Vanguard'),
(5, 'English', 'Action, Sci-fi', '2020-08-26 16:00:00', 150, 4.8, 'A secret agent embarks on a dangerous, time-bending mission to prevent the start of World War III', 'Tenet'),
(6, 'English', 'Horror, Thriller', '2021-04-22 16:00:00', 100, 4.2, 'The Abbott family must now face the terrors of the outside world as they fight for survival in silence. Forced to venture into the unknown, they realize that the creatures that hunt by sound are not the only threats that lurk beyond the sand path.', 'A Quiet Place Part 2'),
(7, 'English', 'Comedy, Fantasy', '2021-03-03 16:00:00', 100, 3.9, 'When a single mother and her two children move to a new town, they soon discover that they have a connection to the original Ghostbusters and their grandfather''s secret legacy.', 'GhostBusters: AfterLife'),
(8, 'English', 'Action, Adventure', '2020-09-30 16:00:00', 116, 1.9, 'A battle-hardened mercenary leads a team of soldiers on a daring mission to rescue hostages in remote Africa.', 'Rogue'),
(9, 'English', 'Animation, Comedy', '2021-03-24 16:00:00', 100, 4.5, 'The Boss Baby: Family Business is an upcoming American 3D computer-animated comedy film loosely based on the 2010 picture book of the same name by Marla Frazee, produced by DreamWorks Animation and distributed by Universal Pictures.', 'The Boss Baby: Family Business'),
(10, 'English', 'Action, Adventure', '2021-03-31 16:00:00', 163, 3.5, 'Recruited to rescue a kidnapped scientist, globe-trotting spy James Bond finds himself hot on the trail of a mysterious villain, who''s armed with a dangerous new technology.', 'No Time to Die');

-- --------------------------------------------------------

--
-- Table structure for table `People`
--

CREATE TABLE IF NOT EXISTS `People` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ImageUrl` int(11) DEFAULT NULL,
  `Name` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `People`
--

INSERT INTO `People` (`Id`, `ImageUrl`, `Name`) VALUES
(1, NULL, 'Niki Caro'),
(2, NULL, 'Yifei Liu'),
(3, NULL, 'Donnie Yan'),
(4, NULL, 'Tzi Ma'),
(5, NULL, 'Jason Scott Lee'),
(6, NULL, 'Yoson An'),
(7, NULL, 'Ron Yuan'),
(8, NULL, 'Gong Li'),
(9, NULL, 'Jet Li'),
(10, NULL, 'Pal Oie'),
(11, NULL, 'Thorbjorn Harr'),
(12, NULL, 'Ingvild Holthe Bygdnes'),
(13, NULL, 'Silje Breivik'),
(14, NULL, 'Mikkel Bratt Silset'),
(15, NULL, 'Luke Snellin'),
(16, NULL, 'Isabela Merced'),
(17, NULL, 'Matthew Noszka'),
(18, NULL, 'Liv Hewson'),
(19, NULL, 'Odeya Rush'),
(20, NULL, 'Anna Akana'),
(21, NULL, 'Jocob Batalon'),
(22, NULL, 'Stanley Tong'),
(23, NULL, 'Jackie Chan'),
(24, NULL, 'Ai Lun'),
(25, NULL, 'Yang Yang'),
(26, NULL, 'Miya Muqi'),
(27, NULL, 'Christopher Nolan'),
(28, NULL, 'John David Washington'),
(29, NULL, 'Robert Pattinson'),
(30, NULL, 'Elizabeth Debicki'),
(31, NULL, 'John Krasinski'),
(32, NULL, 'Emily Blunt'),
(33, NULL, 'Cillian Murphy'),
(34, NULL, 'Millicent Simmonds'),
(35, NULL, 'Noah Jupe'),
(36, NULL, 'Djimon Hounsou'),
(37, NULL, 'Jason Reitman'),
(38, NULL, 'Carrie Coon'),
(39, NULL, 'Finn Wolfhard'),
(40, NULL, 'Mckenna Grace'),
(41, NULL, 'Paul Rudd'),
(42, NULL, 'M. J. Bassett'),
(43, NULL, 'Megan Fox'),
(44, NULL, 'Lee-Anne Liebenberg'),
(45, NULL, 'Phillip Winchester'),
(46, NULL, 'Jessica Sutton'),
(47, NULL, 'Tom McGrath'),
(48, NULL, 'Alec Baldwin'),
(49, NULL, 'James Marsden'),
(50, NULL, 'Amy Sedaris'),
(51, NULL, 'Eva Longoria'),
(52, NULL, 'Jimmy Kimmel'),
(53, NULL, 'Cary Joji Fukunaga'),
(54, NULL, 'Daniel Craig'),
(55, NULL, 'Rami Malek'),
(56, NULL, 'Lea Seydoux'),
(57, NULL, 'Lashana Lynch'),
(58, NULL, 'Ben Whishaw');

-- --------------------------------------------------------

--
-- Table structure for table `Photo`
--

CREATE TABLE IF NOT EXISTS `Photo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PhotoUrl` text NOT NULL,
  `MovieDetailId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `MovieDetailId` (`MovieDetailId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `Photo`
--

INSERT INTO `Photo` (`Id`, `PhotoUrl`, `MovieDetailId`) VALUES
(1, 'AQuietPlace', 6),
(2, 'GhostbustersAfterlife', 7),
(3, 'LetItSnow', 3),
(4, 'Mulan', 1),
(5, 'NoTimeToDie', 10),
(6, 'Rogue', 8),
(7, 'Tenet', 5),
(8, 'TheBossBaby', 9),
(9, 'Tunnel', 2),
(10, 'Vanguard', 4);

-- --------------------------------------------------------

--
-- Table structure for table `Seating`
--

CREATE TABLE IF NOT EXISTS `Seating` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Row` char(1) NOT NULL,
  `Column` char(2) NOT NULL,
  `TheatreId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `TheatreId` (`TheatreId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=901 ;

--
-- Dumping data for table `Seating`
--

INSERT INTO `Seating` (`Id`, `Row`, `Column`, `TheatreId`) VALUES
(1, 'a', '01', 1),
(2, 'a', '02', 1),
(3, 'a', '03', 1),
(4, 'a', '04', 1),
(5, 'a', '05', 1),
(6, 'a', '06', 1),
(7, 'a', '07', 1),
(8, 'a', '08', 1),
(9, 'a', '09', 1),
(10, 'a', '10', 1),
(11, 'a', '11', 1),
(12, 'a', '12', 1),
(13, 'b', '01', 1),
(14, 'b', '02', 1),
(15, 'b', '03', 1),
(16, 'b', '04', 1),
(17, 'b', '05', 1),
(18, 'b', '06', 1),
(19, 'b', '07', 1),
(20, 'b', '08', 1),
(21, 'b', '09', 1),
(22, 'b', '10', 1),
(23, 'b', '11', 1),
(24, 'b', '12', 1),
(25, 'c', '01', 1),
(26, 'c', '02', 1),
(27, 'c', '03', 1),
(28, 'c', '04', 1),
(29, 'c', '05', 1),
(30, 'c', '06', 1),
(31, 'c', '07', 1),
(32, 'c', '08', 1),
(33, 'c', '09', 1),
(34, 'c', '10', 1),
(35, 'c', '11', 1),
(36, 'c', '12', 1),
(37, 'd', '01', 1),
(38, 'd', '02', 1),
(39, 'd', '03', 1),
(40, 'd', '04', 1),
(41, 'd', '05', 1),
(42, 'd', '06', 1),
(43, 'd', '07', 1),
(44, 'd', '08', 1),
(45, 'd', '09', 1),
(46, 'd', '10', 1),
(47, 'd', '11', 1),
(48, 'd', '12', 1),
(49, 'e', '01', 1),
(50, 'e', '02', 1),
(51, 'e', '03', 1),
(52, 'e', '04', 1),
(53, 'e', '05', 1),
(54, 'e', '06', 1),
(55, 'e', '07', 1),
(56, 'e', '08', 1),
(57, 'e', '09', 1),
(58, 'e', '10', 1),
(59, 'e', '11', 1),
(60, 'e', '12', 1),
(61, 'a', '01', 2),
(62, 'a', '02', 2),
(63, 'a', '03', 2),
(64, 'a', '04', 2),
(65, 'a', '05', 2),
(66, 'a', '06', 2),
(67, 'a', '07', 2),
(68, 'a', '08', 2),
(69, 'a', '09', 2),
(70, 'a', '10', 2),
(71, 'a', '11', 2),
(72, 'a', '12', 2),
(73, 'b', '01', 2),
(74, 'b', '02', 2),
(75, 'b', '03', 2),
(76, 'b', '04', 2),
(77, 'b', '05', 2),
(78, 'b', '06', 2),
(79, 'b', '07', 2),
(80, 'b', '08', 2),
(81, 'b', '09', 2),
(82, 'b', '10', 2),
(83, 'b', '11', 2),
(84, 'b', '12', 2),
(85, 'c', '01', 2),
(86, 'c', '02', 2),
(87, 'c', '03', 2),
(88, 'c', '04', 2),
(89, 'c', '05', 2),
(90, 'c', '06', 2),
(91, 'c', '07', 2),
(92, 'c', '08', 2),
(93, 'c', '09', 2),
(94, 'c', '10', 2),
(95, 'c', '11', 2),
(96, 'c', '12', 2),
(97, 'd', '01', 2),
(98, 'd', '02', 2),
(99, 'd', '03', 2),
(100, 'd', '04', 2),
(101, 'd', '05', 2),
(102, 'd', '06', 2),
(103, 'd', '07', 2),
(104, 'd', '08', 2),
(105, 'd', '09', 2),
(106, 'd', '10', 2),
(107, 'd', '11', 2),
(108, 'd', '12', 2),
(109, 'e', '01', 2),
(110, 'e', '02', 2),
(111, 'e', '03', 2),
(112, 'e', '04', 2),
(113, 'e', '05', 2),
(114, 'e', '06', 2),
(115, 'e', '07', 2),
(116, 'e', '08', 2),
(117, 'e', '09', 2),
(118, 'e', '10', 2),
(119, 'e', '11', 2),
(120, 'e', '12', 2),
(121, 'a', '01', 3),
(122, 'a', '02', 3),
(123, 'a', '03', 3),
(124, 'a', '04', 3),
(125, 'a', '05', 3),
(126, 'a', '06', 3),
(127, 'a', '07', 3),
(128, 'a', '08', 3),
(129, 'a', '09', 3),
(130, 'a', '10', 3),
(131, 'a', '11', 3),
(132, 'a', '12', 3),
(133, 'b', '01', 3),
(134, 'b', '02', 3),
(135, 'b', '03', 3),
(136, 'b', '04', 3),
(137, 'b', '05', 3),
(138, 'b', '06', 3),
(139, 'b', '07', 3),
(140, 'b', '08', 3),
(141, 'b', '09', 3),
(142, 'b', '10', 3),
(143, 'b', '11', 3),
(144, 'b', '12', 3),
(145, 'c', '01', 3),
(146, 'c', '02', 3),
(147, 'c', '03', 3),
(148, 'c', '04', 3),
(149, 'c', '05', 3),
(150, 'c', '06', 3),
(151, 'c', '07', 3),
(152, 'c', '08', 3),
(153, 'c', '09', 3),
(154, 'c', '10', 3),
(155, 'c', '11', 3),
(156, 'c', '12', 3),
(157, 'd', '01', 3),
(158, 'd', '02', 3),
(159, 'd', '03', 3),
(160, 'd', '04', 3),
(161, 'd', '05', 3),
(162, 'd', '06', 3),
(163, 'd', '07', 3),
(164, 'd', '08', 3),
(165, 'd', '09', 3),
(166, 'd', '10', 3),
(167, 'd', '11', 3),
(168, 'd', '12', 3),
(169, 'e', '01', 3),
(170, 'e', '02', 3),
(171, 'e', '03', 3),
(172, 'e', '04', 3),
(173, 'e', '05', 3),
(174, 'e', '06', 3),
(175, 'e', '07', 3),
(176, 'e', '08', 3),
(177, 'e', '09', 3),
(178, 'e', '10', 3),
(179, 'e', '11', 3),
(180, 'e', '12', 3),
(181, 'a', '01', 4),
(182, 'a', '02', 4),
(183, 'a', '03', 4),
(184, 'a', '04', 4),
(185, 'a', '05', 4),
(186, 'a', '06', 4),
(187, 'a', '07', 4),
(188, 'a', '08', 4),
(189, 'a', '09', 4),
(190, 'a', '10', 4),
(191, 'a', '11', 4),
(192, 'a', '12', 4),
(193, 'b', '01', 4),
(194, 'b', '02', 4),
(195, 'b', '03', 4),
(196, 'b', '04', 4),
(197, 'b', '05', 4),
(198, 'b', '06', 4),
(199, 'b', '07', 4),
(200, 'b', '08', 4),
(201, 'b', '09', 4),
(202, 'b', '10', 4),
(203, 'b', '11', 4),
(204, 'b', '12', 4),
(205, 'c', '01', 4),
(206, 'c', '02', 4),
(207, 'c', '03', 4),
(208, 'c', '04', 4),
(209, 'c', '05', 4),
(210, 'c', '06', 4),
(211, 'c', '07', 4),
(212, 'c', '08', 4),
(213, 'c', '09', 4),
(214, 'c', '10', 4),
(215, 'c', '11', 4),
(216, 'c', '12', 4),
(217, 'd', '01', 4),
(218, 'd', '02', 4),
(219, 'd', '03', 4),
(220, 'd', '04', 4),
(221, 'd', '05', 4),
(222, 'd', '06', 4),
(223, 'd', '07', 4),
(224, 'd', '08', 4),
(225, 'd', '09', 4),
(226, 'd', '10', 4),
(227, 'd', '11', 4),
(228, 'd', '12', 4),
(229, 'e', '01', 4),
(230, 'e', '02', 4),
(231, 'e', '03', 4),
(232, 'e', '04', 4),
(233, 'e', '05', 4),
(234, 'e', '06', 4),
(235, 'e', '07', 4),
(236, 'e', '08', 4),
(237, 'e', '09', 4),
(238, 'e', '10', 4),
(239, 'e', '11', 4),
(240, 'e', '12', 4),
(241, 'a', '01', 5),
(242, 'a', '02', 5),
(243, 'a', '03', 5),
(244, 'a', '04', 5),
(245, 'a', '05', 5),
(246, 'a', '06', 5),
(247, 'a', '07', 5),
(248, 'a', '08', 5),
(249, 'a', '09', 5),
(250, 'a', '10', 5),
(251, 'a', '11', 5),
(252, 'a', '12', 5),
(253, 'b', '01', 5),
(254, 'b', '02', 5),
(255, 'b', '03', 5),
(256, 'b', '04', 5),
(257, 'b', '05', 5),
(258, 'b', '06', 5),
(259, 'b', '07', 5),
(260, 'b', '08', 5),
(261, 'b', '09', 5),
(262, 'b', '10', 5),
(263, 'b', '11', 5),
(264, 'b', '12', 5),
(265, 'c', '01', 5),
(266, 'c', '02', 5),
(267, 'c', '03', 5),
(268, 'c', '04', 5),
(269, 'c', '05', 5),
(270, 'c', '06', 5),
(271, 'c', '07', 5),
(272, 'c', '08', 5),
(273, 'c', '09', 5),
(274, 'c', '10', 5),
(275, 'c', '11', 5),
(276, 'c', '12', 5),
(277, 'd', '01', 5),
(278, 'd', '02', 5),
(279, 'd', '03', 5),
(280, 'd', '04', 5),
(281, 'd', '05', 5),
(282, 'd', '06', 5),
(283, 'd', '07', 5),
(284, 'd', '08', 5),
(285, 'd', '09', 5),
(286, 'd', '10', 5),
(287, 'd', '11', 5),
(288, 'd', '12', 5),
(289, 'e', '01', 5),
(290, 'e', '02', 5),
(291, 'e', '03', 5),
(292, 'e', '04', 5),
(293, 'e', '05', 5),
(294, 'e', '06', 5),
(295, 'e', '07', 5),
(296, 'e', '08', 5),
(297, 'e', '09', 5),
(298, 'e', '10', 5),
(299, 'e', '11', 5),
(300, 'e', '12', 5),
(301, 'a', '01', 6),
(302, 'a', '02', 6),
(303, 'a', '03', 6),
(304, 'a', '04', 6),
(305, 'a', '05', 6),
(306, 'a', '06', 6),
(307, 'a', '07', 6),
(308, 'a', '08', 6),
(309, 'a', '09', 6),
(310, 'a', '10', 6),
(311, 'a', '11', 6),
(312, 'a', '12', 6),
(313, 'b', '01', 6),
(314, 'b', '02', 6),
(315, 'b', '03', 6),
(316, 'b', '04', 6),
(317, 'b', '05', 6),
(318, 'b', '06', 6),
(319, 'b', '07', 6),
(320, 'b', '08', 6),
(321, 'b', '09', 6),
(322, 'b', '10', 6),
(323, 'b', '11', 6),
(324, 'b', '12', 6),
(325, 'c', '01', 6),
(326, 'c', '02', 6),
(327, 'c', '03', 6),
(328, 'c', '04', 6),
(329, 'c', '05', 6),
(330, 'c', '06', 6),
(331, 'c', '07', 6),
(332, 'c', '08', 6),
(333, 'c', '09', 6),
(334, 'c', '10', 6),
(335, 'c', '11', 6),
(336, 'c', '12', 6),
(337, 'd', '01', 6),
(338, 'd', '02', 6),
(339, 'd', '03', 6),
(340, 'd', '04', 6),
(341, 'd', '05', 6),
(342, 'd', '06', 6),
(343, 'd', '07', 6),
(344, 'd', '08', 6),
(345, 'd', '09', 6),
(346, 'd', '10', 6),
(347, 'd', '11', 6),
(348, 'd', '12', 6),
(349, 'e', '01', 6),
(350, 'e', '02', 6),
(351, 'e', '03', 6),
(352, 'e', '04', 6),
(353, 'e', '05', 6),
(354, 'e', '06', 6),
(355, 'e', '07', 6),
(356, 'e', '08', 6),
(357, 'e', '09', 6),
(358, 'e', '10', 6),
(359, 'e', '11', 6),
(360, 'e', '12', 6),
(361, 'a', '01', 7),
(362, 'a', '02', 7),
(363, 'a', '03', 7),
(364, 'a', '04', 7),
(365, 'a', '05', 7),
(366, 'a', '06', 7),
(367, 'a', '07', 7),
(368, 'a', '08', 7),
(369, 'a', '09', 7),
(370, 'a', '10', 7),
(371, 'a', '11', 7),
(372, 'a', '12', 7),
(373, 'b', '01', 7),
(374, 'b', '02', 7),
(375, 'b', '03', 7),
(376, 'b', '04', 7),
(377, 'b', '05', 7),
(378, 'b', '06', 7),
(379, 'b', '07', 7),
(380, 'b', '08', 7),
(381, 'b', '09', 7),
(382, 'b', '10', 7),
(383, 'b', '11', 7),
(384, 'b', '12', 7),
(385, 'c', '01', 7),
(386, 'c', '02', 7),
(387, 'c', '03', 7),
(388, 'c', '04', 7),
(389, 'c', '05', 7),
(390, 'c', '06', 7),
(391, 'c', '07', 7),
(392, 'c', '08', 7),
(393, 'c', '09', 7),
(394, 'c', '10', 7),
(395, 'c', '11', 7),
(396, 'c', '12', 7),
(397, 'd', '01', 7),
(398, 'd', '02', 7),
(399, 'd', '03', 7),
(400, 'd', '04', 7),
(401, 'd', '05', 7),
(402, 'd', '06', 7),
(403, 'd', '07', 7),
(404, 'd', '08', 7),
(405, 'd', '09', 7),
(406, 'd', '10', 7),
(407, 'd', '11', 7),
(408, 'd', '12', 7),
(409, 'e', '01', 7),
(410, 'e', '02', 7),
(411, 'e', '03', 7),
(412, 'e', '04', 7),
(413, 'e', '05', 7),
(414, 'e', '06', 7),
(415, 'e', '07', 7),
(416, 'e', '08', 7),
(417, 'e', '09', 7),
(418, 'e', '10', 7),
(419, 'e', '11', 7),
(420, 'e', '12', 7),
(421, 'a', '01', 8),
(422, 'a', '02', 8),
(423, 'a', '03', 8),
(424, 'a', '04', 8),
(425, 'a', '05', 8),
(426, 'a', '06', 8),
(427, 'a', '07', 8),
(428, 'a', '08', 8),
(429, 'a', '09', 8),
(430, 'a', '10', 8),
(431, 'a', '11', 8),
(432, 'a', '12', 8),
(433, 'b', '01', 8),
(434, 'b', '02', 8),
(435, 'b', '03', 8),
(436, 'b', '04', 8),
(437, 'b', '05', 8),
(438, 'b', '06', 8),
(439, 'b', '07', 8),
(440, 'b', '08', 8),
(441, 'b', '09', 8),
(442, 'b', '10', 8),
(443, 'b', '11', 8),
(444, 'b', '12', 8),
(445, 'c', '01', 8),
(446, 'c', '02', 8),
(447, 'c', '03', 8),
(448, 'c', '04', 8),
(449, 'c', '05', 8),
(450, 'c', '06', 8),
(451, 'c', '07', 8),
(452, 'c', '08', 8),
(453, 'c', '09', 8),
(454, 'c', '10', 8),
(455, 'c', '11', 8),
(456, 'c', '12', 8),
(457, 'd', '01', 8),
(458, 'd', '02', 8),
(459, 'd', '03', 8),
(460, 'd', '04', 8),
(461, 'd', '05', 8),
(462, 'd', '06', 8),
(463, 'd', '07', 8),
(464, 'd', '08', 8),
(465, 'd', '09', 8),
(466, 'd', '10', 8),
(467, 'd', '11', 8),
(468, 'd', '12', 8),
(469, 'e', '01', 8),
(470, 'e', '02', 8),
(471, 'e', '03', 8),
(472, 'e', '04', 8),
(473, 'e', '05', 8),
(474, 'e', '06', 8),
(475, 'e', '07', 8),
(476, 'e', '08', 8),
(477, 'e', '09', 8),
(478, 'e', '10', 8),
(479, 'e', '11', 8),
(480, 'e', '12', 8),
(481, 'a', '01', 9),
(482, 'a', '02', 9),
(483, 'a', '03', 9),
(484, 'a', '04', 9),
(485, 'a', '05', 9),
(486, 'a', '06', 9),
(487, 'a', '07', 9),
(488, 'a', '08', 9),
(489, 'a', '09', 9),
(490, 'a', '10', 9),
(491, 'a', '11', 9),
(492, 'a', '12', 9),
(493, 'b', '01', 9),
(494, 'b', '02', 9),
(495, 'b', '03', 9),
(496, 'b', '04', 9),
(497, 'b', '05', 9),
(498, 'b', '06', 9),
(499, 'b', '07', 9),
(500, 'b', '08', 9),
(501, 'b', '09', 9),
(502, 'b', '10', 9),
(503, 'b', '11', 9),
(504, 'b', '12', 9),
(505, 'c', '01', 9),
(506, 'c', '02', 9),
(507, 'c', '03', 9),
(508, 'c', '04', 9),
(509, 'c', '05', 9),
(510, 'c', '06', 9),
(511, 'c', '07', 9),
(512, 'c', '08', 9),
(513, 'c', '09', 9),
(514, 'c', '10', 9),
(515, 'c', '11', 9),
(516, 'c', '12', 9),
(517, 'd', '01', 9),
(518, 'd', '02', 9),
(519, 'd', '03', 9),
(520, 'd', '04', 9),
(521, 'd', '05', 9),
(522, 'd', '06', 9),
(523, 'd', '07', 9),
(524, 'd', '08', 9),
(525, 'd', '09', 9),
(526, 'd', '10', 9),
(527, 'd', '11', 9),
(528, 'd', '12', 9),
(529, 'e', '01', 9),
(530, 'e', '02', 9),
(531, 'e', '03', 9),
(532, 'e', '04', 9),
(533, 'e', '05', 9),
(534, 'e', '06', 9),
(535, 'e', '07', 9),
(536, 'e', '08', 9),
(537, 'e', '09', 9),
(538, 'e', '10', 9),
(539, 'e', '11', 9),
(540, 'e', '12', 9),
(541, 'a', '01', 10),
(542, 'a', '02', 10),
(543, 'a', '03', 10),
(544, 'a', '04', 10),
(545, 'a', '05', 10),
(546, 'a', '06', 10),
(547, 'a', '07', 10),
(548, 'a', '08', 10),
(549, 'a', '09', 10),
(550, 'a', '10', 10),
(551, 'a', '11', 10),
(552, 'a', '12', 10),
(553, 'b', '01', 10),
(554, 'b', '02', 10),
(555, 'b', '03', 10),
(556, 'b', '04', 10),
(557, 'b', '05', 10),
(558, 'b', '06', 10),
(559, 'b', '07', 10),
(560, 'b', '08', 10),
(561, 'b', '09', 10),
(562, 'b', '10', 10),
(563, 'b', '11', 10),
(564, 'b', '12', 10),
(565, 'c', '01', 10),
(566, 'c', '02', 10),
(567, 'c', '03', 10),
(568, 'c', '04', 10),
(569, 'c', '05', 10),
(570, 'c', '06', 10),
(571, 'c', '07', 10),
(572, 'c', '08', 10),
(573, 'c', '09', 10),
(574, 'c', '10', 10),
(575, 'c', '11', 10),
(576, 'c', '12', 10),
(577, 'd', '01', 10),
(578, 'd', '02', 10),
(579, 'd', '03', 10),
(580, 'd', '04', 10),
(581, 'd', '05', 10),
(582, 'd', '06', 10),
(583, 'd', '07', 10),
(584, 'd', '08', 10),
(585, 'd', '09', 10),
(586, 'd', '10', 10),
(587, 'd', '11', 10),
(588, 'd', '12', 10),
(589, 'e', '01', 10),
(590, 'e', '02', 10),
(591, 'e', '03', 10),
(592, 'e', '04', 10),
(593, 'e', '05', 10),
(594, 'e', '06', 10),
(595, 'e', '07', 10),
(596, 'e', '08', 10),
(597, 'e', '09', 10),
(598, 'e', '10', 10),
(599, 'e', '11', 10),
(600, 'e', '12', 10),
(601, 'a', '01', 11),
(602, 'a', '02', 11),
(603, 'a', '03', 11),
(604, 'a', '04', 11),
(605, 'a', '05', 11),
(606, 'a', '06', 11),
(607, 'a', '07', 11),
(608, 'a', '08', 11),
(609, 'a', '09', 11),
(610, 'a', '10', 11),
(611, 'a', '11', 11),
(612, 'a', '12', 11),
(613, 'b', '01', 11),
(614, 'b', '02', 11),
(615, 'b', '03', 11),
(616, 'b', '04', 11),
(617, 'b', '05', 11),
(618, 'b', '06', 11),
(619, 'b', '07', 11),
(620, 'b', '08', 11),
(621, 'b', '09', 11),
(622, 'b', '10', 11),
(623, 'b', '11', 11),
(624, 'b', '12', 11),
(625, 'c', '01', 11),
(626, 'c', '02', 11),
(627, 'c', '03', 11),
(628, 'c', '04', 11),
(629, 'c', '05', 11),
(630, 'c', '06', 11),
(631, 'c', '07', 11),
(632, 'c', '08', 11),
(633, 'c', '09', 11),
(634, 'c', '10', 11),
(635, 'c', '11', 11),
(636, 'c', '12', 11),
(637, 'd', '01', 11),
(638, 'd', '02', 11),
(639, 'd', '03', 11),
(640, 'd', '04', 11),
(641, 'd', '05', 11),
(642, 'd', '06', 11),
(643, 'd', '07', 11),
(644, 'd', '08', 11),
(645, 'd', '09', 11),
(646, 'd', '10', 11),
(647, 'd', '11', 11),
(648, 'd', '12', 11),
(649, 'e', '01', 11),
(650, 'e', '02', 11),
(651, 'e', '03', 11),
(652, 'e', '04', 11),
(653, 'e', '05', 11),
(654, 'e', '06', 11),
(655, 'e', '07', 11),
(656, 'e', '08', 11),
(657, 'e', '09', 11),
(658, 'e', '10', 11),
(659, 'e', '11', 11),
(660, 'e', '12', 11),
(661, 'a', '01', 12),
(662, 'a', '02', 12),
(663, 'a', '03', 12),
(664, 'a', '04', 12),
(665, 'a', '05', 12),
(666, 'a', '06', 12),
(667, 'a', '07', 12),
(668, 'a', '08', 12),
(669, 'a', '09', 12),
(670, 'a', '10', 12),
(671, 'a', '11', 12),
(672, 'a', '12', 12),
(673, 'b', '01', 12),
(674, 'b', '02', 12),
(675, 'b', '03', 12),
(676, 'b', '04', 12),
(677, 'b', '05', 12),
(678, 'b', '06', 12),
(679, 'b', '07', 12),
(680, 'b', '08', 12),
(681, 'b', '09', 12),
(682, 'b', '10', 12),
(683, 'b', '11', 12),
(684, 'b', '12', 12),
(685, 'c', '01', 12),
(686, 'c', '02', 12),
(687, 'c', '03', 12),
(688, 'c', '04', 12),
(689, 'c', '05', 12),
(690, 'c', '06', 12),
(691, 'c', '07', 12),
(692, 'c', '08', 12),
(693, 'c', '09', 12),
(694, 'c', '10', 12),
(695, 'c', '11', 12),
(696, 'c', '12', 12),
(697, 'd', '01', 12),
(698, 'd', '02', 12),
(699, 'd', '03', 12),
(700, 'd', '04', 12),
(701, 'd', '05', 12),
(702, 'd', '06', 12),
(703, 'd', '07', 12),
(704, 'd', '08', 12),
(705, 'd', '09', 12),
(706, 'd', '10', 12),
(707, 'd', '11', 12),
(708, 'd', '12', 12),
(709, 'e', '01', 12),
(710, 'e', '02', 12),
(711, 'e', '03', 12),
(712, 'e', '04', 12),
(713, 'e', '05', 12),
(714, 'e', '06', 12),
(715, 'e', '07', 12),
(716, 'e', '08', 12),
(717, 'e', '09', 12),
(718, 'e', '10', 12),
(719, 'e', '11', 12),
(720, 'e', '12', 12),
(721, 'a', '01', 13),
(722, 'a', '02', 13),
(723, 'a', '03', 13),
(724, 'a', '04', 13),
(725, 'a', '05', 13),
(726, 'a', '06', 13),
(727, 'a', '07', 13),
(728, 'a', '08', 13),
(729, 'a', '09', 13),
(730, 'a', '10', 13),
(731, 'a', '11', 13),
(732, 'a', '12', 13),
(733, 'b', '01', 13),
(734, 'b', '02', 13),
(735, 'b', '03', 13),
(736, 'b', '04', 13),
(737, 'b', '05', 13),
(738, 'b', '06', 13),
(739, 'b', '07', 13),
(740, 'b', '08', 13),
(741, 'b', '09', 13),
(742, 'b', '10', 13),
(743, 'b', '11', 13),
(744, 'b', '12', 13),
(745, 'c', '01', 13),
(746, 'c', '02', 13),
(747, 'c', '03', 13),
(748, 'c', '04', 13),
(749, 'c', '05', 13),
(750, 'c', '06', 13),
(751, 'c', '07', 13),
(752, 'c', '08', 13),
(753, 'c', '09', 13),
(754, 'c', '10', 13),
(755, 'c', '11', 13),
(756, 'c', '12', 13),
(757, 'd', '01', 13),
(758, 'd', '02', 13),
(759, 'd', '03', 13),
(760, 'd', '04', 13),
(761, 'd', '05', 13),
(762, 'd', '06', 13),
(763, 'd', '07', 13),
(764, 'd', '08', 13),
(765, 'd', '09', 13),
(766, 'd', '10', 13),
(767, 'd', '11', 13),
(768, 'd', '12', 13),
(769, 'e', '01', 13),
(770, 'e', '02', 13),
(771, 'e', '03', 13),
(772, 'e', '04', 13),
(773, 'e', '05', 13),
(774, 'e', '06', 13),
(775, 'e', '07', 13),
(776, 'e', '08', 13),
(777, 'e', '09', 13),
(778, 'e', '10', 13),
(779, 'e', '11', 13),
(780, 'e', '12', 13),
(781, 'a', '01', 14),
(782, 'a', '02', 14),
(783, 'a', '03', 14),
(784, 'a', '04', 14),
(785, 'a', '05', 14),
(786, 'a', '06', 14),
(787, 'a', '07', 14),
(788, 'a', '08', 14),
(789, 'a', '09', 14),
(790, 'a', '10', 14),
(791, 'a', '11', 14),
(792, 'a', '12', 14),
(793, 'b', '01', 14),
(794, 'b', '02', 14),
(795, 'b', '03', 14),
(796, 'b', '04', 14),
(797, 'b', '05', 14),
(798, 'b', '06', 14),
(799, 'b', '07', 14),
(800, 'b', '08', 14),
(801, 'b', '09', 14),
(802, 'b', '10', 14),
(803, 'b', '11', 14),
(804, 'b', '12', 14),
(805, 'c', '01', 14),
(806, 'c', '02', 14),
(807, 'c', '03', 14),
(808, 'c', '04', 14),
(809, 'c', '05', 14),
(810, 'c', '06', 14),
(811, 'c', '07', 14),
(812, 'c', '08', 14),
(813, 'c', '09', 14),
(814, 'c', '10', 14),
(815, 'c', '11', 14),
(816, 'c', '12', 14),
(817, 'd', '01', 14),
(818, 'd', '02', 14),
(819, 'd', '03', 14),
(820, 'd', '04', 14),
(821, 'd', '05', 14),
(822, 'd', '06', 14),
(823, 'd', '07', 14),
(824, 'd', '08', 14),
(825, 'd', '09', 14),
(826, 'd', '10', 14),
(827, 'd', '11', 14),
(828, 'd', '12', 14),
(829, 'e', '01', 14),
(830, 'e', '02', 14),
(831, 'e', '03', 14),
(832, 'e', '04', 14),
(833, 'e', '05', 14),
(834, 'e', '06', 14),
(835, 'e', '07', 14),
(836, 'e', '08', 14),
(837, 'e', '09', 14),
(838, 'e', '10', 14),
(839, 'e', '11', 14),
(840, 'e', '12', 14),
(841, 'a', '01', 15),
(842, 'a', '02', 15),
(843, 'a', '03', 15),
(844, 'a', '04', 15),
(845, 'a', '05', 15),
(846, 'a', '06', 15),
(847, 'a', '07', 15),
(848, 'a', '08', 15),
(849, 'a', '09', 15),
(850, 'a', '10', 15),
(851, 'a', '11', 15),
(852, 'a', '12', 15),
(853, 'b', '01', 15),
(854, 'b', '02', 15),
(855, 'b', '03', 15),
(856, 'b', '04', 15),
(857, 'b', '05', 15),
(858, 'b', '06', 15),
(859, 'b', '07', 15),
(860, 'b', '08', 15),
(861, 'b', '09', 15),
(862, 'b', '10', 15),
(863, 'b', '11', 15),
(864, 'b', '12', 15),
(865, 'c', '01', 15),
(866, 'c', '02', 15),
(867, 'c', '03', 15),
(868, 'c', '04', 15),
(869, 'c', '05', 15),
(870, 'c', '06', 15),
(871, 'c', '07', 15),
(872, 'c', '08', 15),
(873, 'c', '09', 15),
(874, 'c', '10', 15),
(875, 'c', '11', 15),
(876, 'c', '12', 15),
(877, 'd', '01', 15),
(878, 'd', '02', 15),
(879, 'd', '03', 15),
(880, 'd', '04', 15),
(881, 'd', '05', 15),
(882, 'd', '06', 15),
(883, 'd', '07', 15),
(884, 'd', '08', 15),
(885, 'd', '09', 15),
(886, 'd', '10', 15),
(887, 'd', '11', 15),
(888, 'd', '12', 15),
(889, 'e', '01', 15),
(890, 'e', '02', 15),
(891, 'e', '03', 15),
(892, 'e', '04', 15),
(893, 'e', '05', 15),
(894, 'e', '06', 15),
(895, 'e', '07', 15),
(896, 'e', '08', 15),
(897, 'e', '09', 15),
(898, 'e', '10', 15),
(899, 'e', '11', 15),
(900, 'e', '12', 15);

-- --------------------------------------------------------

--
-- Table structure for table `Theatre`
--

CREATE TABLE IF NOT EXISTS `Theatre` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Location` text NOT NULL,
  `Number` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `Theatre`
--

INSERT INTO `Theatre` (`Id`, `Location`, `Number`) VALUES
(1, 'Hougang Mall', '1'),
(2, 'Hougang Mall', '2'),
(3, 'Hougang Mall', '3'),
(4, 'JEM', '1'),
(5, 'JEM', '2'),
(6, 'JEM', '3'),
(7, 'City Square Mall', '1'),
(8, 'City Square Mall', '2'),
(9, 'City Square Mall', '3'),
(10, 'PLQ', '1'),
(11, 'PLQ', '2'),
(12, 'PLQ', '3'),
(13, 'NorthPoint City', '1'),
(14, 'NorthPoint City', '2'),
(15, 'NorthPoint City', '3');

-- --------------------------------------------------------

--
-- Table structure for table `Ticket`
--

CREATE TABLE IF NOT EXISTS `Ticket` (
  `SeatId` int(11) NOT NULL,
  `BookingId` int(11) NOT NULL,
  PRIMARY KEY (`SeatId`,`BookingId`),
  KEY `SeatId` (`SeatId`),
  KEY `BookingId` (`BookingId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Ticket`
--

INSERT INTO `Ticket` (`SeatId`, `BookingId`) VALUES
(450, 16),
(451, 16),
(582, 19),
(583, 19),
(601, 21),
(602, 21),
(603, 21),
(604, 21),
(605, 21),
(606, 21),
(607, 21),
(608, 21),
(609, 21),
(610, 21),
(611, 21),
(612, 21),
(613, 21),
(614, 21),
(615, 21),
(616, 21),
(617, 21),
(618, 21),
(619, 21),
(620, 21),
(621, 21),
(622, 21),
(623, 21),
(624, 21),
(625, 21),
(626, 21),
(627, 21),
(628, 21),
(629, 21),
(630, 21),
(631, 21),
(632, 21),
(633, 21),
(634, 21),
(635, 21),
(636, 21),
(637, 21),
(638, 21),
(639, 21),
(640, 18),
(640, 21),
(641, 18),
(641, 21),
(642, 21),
(643, 20),
(644, 21),
(645, 21),
(646, 21),
(647, 21),
(648, 21),
(649, 21),
(650, 21),
(651, 21),
(652, 21),
(653, 21),
(654, 17),
(654, 21),
(655, 17),
(655, 21),
(656, 21),
(657, 21),
(658, 21),
(659, 21),
(660, 21),
(810, 15),
(811, 15);

-- --------------------------------------------------------

--
-- Table structure for table `Timeslot`
--

CREATE TABLE IF NOT EXISTS `Timeslot` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `StartTime` time NOT NULL,
  `MovieDetailId` int(11) NOT NULL,
  `TheatreId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `MovieId` (`MovieDetailId`),
  KEY `TheatreId` (`TheatreId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `Timeslot`
--

INSERT INTO `Timeslot` (`Id`, `StartTime`, `MovieDetailId`, `TheatreId`) VALUES
(1, '10:30:00', 1, 1),
(2, '13:00:00', 3, 1),
(3, '16:00:00', 2, 1),
(4, '19:30:00', 5, 1),
(5, '23:30:00', 8, 1),
(6, '09:00:00', 5, 2),
(7, '12:30:00', 4, 2),
(8, '15:30:00', 4, 2),
(9, '19:30:00', 3, 2),
(10, '22:30:00', 4, 2),
(11, '09:30:00', 2, 3),
(12, '12:30:00', 4, 3),
(13, '16:00:00', 5, 3),
(14, '19:30:00', 8, 3),
(15, '23:30:00', 8, 3),
(16, '09:30:00', 1, 4),
(17, '13:00:00', 3, 4),
(18, '16:00:00', 2, 4),
(19, '19:30:00', 5, 4),
(20, '23:30:00', 8, 4),
(21, '09:00:00', 5, 5),
(22, '12:30:00', 4, 5),
(23, '15:30:00', 4, 5),
(24, '19:30:00', 3, 5),
(25, '22:30:00', 4, 5),
(26, '09:30:00', 2, 6),
(27, '12:30:00', 4, 6),
(28, '16:00:00', 5, 6),
(29, '19:30:00', 8, 6),
(30, '23:30:00', 8, 6),
(31, '09:30:00', 1, 7),
(32, '13:00:00', 3, 7),
(33, '16:00:00', 2, 7),
(34, '19:30:00', 5, 7),
(35, '23:30:00', 8, 7),
(36, '09:00:00', 5, 8),
(37, '12:30:00', 4, 8),
(38, '15:30:00', 4, 8),
(39, '19:30:00', 3, 8),
(40, '22:30:00', 4, 8),
(41, '09:30:00', 2, 9),
(42, '12:30:00', 4, 9),
(43, '16:00:00', 5, 9),
(44, '19:30:00', 8, 9),
(45, '23:30:00', 8, 9),
(46, '09:30:00', 1, 10),
(47, '13:00:00', 3, 10),
(48, '16:00:00', 2, 10),
(49, '19:30:00', 5, 10),
(50, '23:30:00', 8, 10),
(51, '09:00:00', 5, 11),
(52, '12:35:00', 4, 11),
(53, '15:30:00', 4, 11),
(54, '19:30:00', 3, 11),
(55, '22:30:00', 4, 11),
(56, '09:30:00', 2, 12),
(57, '12:30:00', 4, 12),
(58, '16:00:00', 5, 12),
(59, '19:30:00', 8, 12),
(60, '23:30:00', 8, 12),
(61, '09:30:00', 1, 13),
(62, '13:00:00', 3, 13),
(63, '16:00:00', 2, 13),
(64, '19:30:00', 5, 13),
(65, '23:30:00', 8, 13),
(66, '09:00:00', 5, 14),
(67, '12:30:00', 4, 14),
(68, '15:30:00', 4, 14),
(69, '19:30:00', 3, 14),
(70, '22:30:00', 4, 14),
(71, '09:30:00', 2, 15),
(72, '12:30:00', 4, 15),
(73, '16:00:00', 5, 15),
(74, '19:30:00', 8, 15),
(75, '23:30:00', 8, 15);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Email` varchar(255) NOT NULL,
  `PhoneNumber` char(8) NOT NULL,
  `Password` char(32) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`Id`, `Name`, `Email`, `PhoneNumber`, `Password`) VALUES
(1, 'Test', 'Test@test.com', '89898989', '161ebd7d45089b3446ee4e0d86dbcf92'),
(3, 'Jane Doe', 'janedoe@abc.com', '87654321', '0000f619eb43c6aee85aced91418bec8'),
(4, 'John Elias Doe', 'john@doe.com', '98765432', '1bf25b04bc57e7a84d5cca410e6b6c28'),
(5, 'Hue Jin Nee', 'jinnee@gmail.com', '98768765', '2af9b1ba42dc5eb01743e6b3759b6e4b'),
(6, 'abc ABCD', '1234_abc@abc.com', '99998888', '2af9b1ba42dc5eb01743e6b3759b6e4b');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Booking`
--
ALTER TABLE `Booking`
  ADD CONSTRAINT `Booking_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `User` (`Id`);

--
-- Constraints for table `CardHolder`
--
ALTER TABLE `CardHolder`
  ADD CONSTRAINT `CardHolder_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `User` (`Id`),
  ADD CONSTRAINT `CardHolder_ibfk_2` FOREIGN KEY (`CardNumber`) REFERENCES `Card` (`CardNumber`) ON UPDATE CASCADE;

--
-- Constraints for table `Cast`
--
ALTER TABLE `Cast`
  ADD CONSTRAINT `Cast_ibfk_1` FOREIGN KEY (`PeopleId`) REFERENCES `People` (`Id`),
  ADD CONSTRAINT `Cast_ibfk_2` FOREIGN KEY (`MovieDetailId`) REFERENCES `MovieDetail` (`Id`);

--
-- Constraints for table `Director`
--
ALTER TABLE `Director`
  ADD CONSTRAINT `Director_ibfk_2` FOREIGN KEY (`MovieDetailId`) REFERENCES `MovieDetail` (`Id`),
  ADD CONSTRAINT `Director_ibfk_3` FOREIGN KEY (`PeopleId`) REFERENCES `People` (`Id`);

--
-- Constraints for table `Photo`
--
ALTER TABLE `Photo`
  ADD CONSTRAINT `Photo_ibfk_1` FOREIGN KEY (`MovieDetailId`) REFERENCES `MovieDetail` (`Id`);

--
-- Constraints for table `Seating`
--
ALTER TABLE `Seating`
  ADD CONSTRAINT `Seating_ibfk_1` FOREIGN KEY (`TheatreId`) REFERENCES `Theatre` (`Id`);

--
-- Constraints for table `Ticket`
--
ALTER TABLE `Ticket`
  ADD CONSTRAINT `Ticket_ibfk_1` FOREIGN KEY (`SeatId`) REFERENCES `Seating` (`Id`),
  ADD CONSTRAINT `Ticket_ibfk_2` FOREIGN KEY (`BookingId`) REFERENCES `Booking` (`Id`);

--
-- Constraints for table `Timeslot`
--
ALTER TABLE `Timeslot`
  ADD CONSTRAINT `Timeslot_ibfk_2` FOREIGN KEY (`TheatreId`) REFERENCES `Theatre` (`Id`),
  ADD CONSTRAINT `Timeslot_ibfk_3` FOREIGN KEY (`MovieDetailId`) REFERENCES `MovieDetail` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
