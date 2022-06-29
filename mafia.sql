-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2019 at 03:02 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mafia`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `has_char` int(1) NOT NULL,
  `login_ip` int(255) NOT NULL,
  `login_count` int(255) NOT NULL,
  `signup_ip` int(255) NOT NULL,
  `owner` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_id`, `username`, `password`, `email`, `has_char`, `login_ip`, `login_count`, `signup_ip`, `owner`) VALUES
(1, 'Tranquill', '06c658f66d7f9f8c7c7711ab5d20350d', 'rileyredfern@gmail.com', 1, 0, 0, 0, 1),
(3, 'testtest', 'cc03e747a6afbbcbf8be7668acfebee5', 'anonymousgamers6@gmail.com', 1, 0, 0, 0, 0),
(4, 'test123', 'cc03e747a6afbbcbf8be7668acfebee5', 'testacc@gmail.com', 1, 0, 0, 0, 0),
(5, 'anothertest', 'cc03e747a6afbbcbf8be7668acfebee5', 'testacc3@gmail.com', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `alpha_keys`
--

CREATE TABLE `alpha_keys` (
  `alpha_key` text NOT NULL,
  `taken` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alpha_keys`
--

INSERT INTO `alpha_keys` (`alpha_key`, `taken`) VALUES
('48TDaJJf6minzp59NG49', 1),
('xqdck0g0BbX8AMgaZ9Gd', 1),
('199Rp58cnQDOEJ6OqCvN', 1),
('xHsVPXGLTiUezHK4cDgt', 1),
('D44adtgoNOrQHyFJMFzO', 1),
('oCdgmndP2qFIhI9EpJLR', 1),
('XNj5vbCtMy00S7kFoCVU', 1),
('ofDJvJNzOigpUEnIS1Ys', 0),
('k8q6lbxCwUFuXwGEeKTB', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `char_id` int(11) NOT NULL,
  `char_name` varchar(11) NOT NULL,
  `money_stored` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `char_id`, `char_name`, `money_stored`) VALUES
(2, 3032, 'Carnage', 109),
(6, 3032, 'Rampage', 109),
(7, 3032, 'Karnage', 109),
(8, 3032, 'Epic', 111),
(15, 3035, 'BossII', 0),
(16, 3035, 'BossII', 0),
(17, 3035, 'BossII', 0),
(18, 3035, 'BossII', 0),
(19, 3035, 'BossII', 0),
(20, 3035, 'BossII', 0),
(21, 3044, 'NewBoss', 0),
(22, 0, 'Crewboy', 0),
(23, 0, 'Jericho', 0);

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `char_id` int(11) NOT NULL,
  `acc_id` int(255) NOT NULL,
  `acc_username` text NOT NULL,
  `char_name` varchar(50) NOT NULL,
  `starting_city` text NOT NULL,
  `current_city` text NOT NULL,
  `gunstat` float NOT NULL,
  `defstat` float NOT NULL,
  `sightstat` float NOT NULL,
  `stealthstat` float NOT NULL,
  `luckstat` float NOT NULL,
  `char_status` char(1) NOT NULL DEFAULT '0',
  `signup` varchar(255) NOT NULL DEFAULT '',
  `money` varchar(20) NOT NULL DEFAULT '1500',
  `wealth_status` varchar(255) NOT NULL,
  `exp` varchar(20) NOT NULL DEFAULT '0',
  `g_exp` varchar(20) NOT NULL DEFAULT '0',
  `rank` char(20) DEFAULT '0',
  `health` char(3) NOT NULL DEFAULT '100',
  `points` varchar(10) NOT NULL DEFAULT '0',
  `job` text NOT NULL,
  `totalCrimes` bigint(255) NOT NULL,
  `lastactive` varchar(255) DEFAULT NULL,
  `lastactive_timestamp` int(255) NOT NULL,
  `nextcrime_timestamp` int(255) NOT NULL,
  `profilepic` varchar(255) NOT NULL,
  `jailtime` int(11) NOT NULL,
  `jailtime_started` int(11) NOT NULL,
  `traveltime` int(11) NOT NULL,
  `quote` text NOT NULL,
  `thugpromo` int(1) NOT NULL,
  `gangsterpromo` int(1) NOT NULL,
  `earnerpromo` int(1) NOT NULL,
  `wgpromo` int(1) NOT NULL,
  `mmpromo` int(1) NOT NULL,
  `capopromo` int(1) NOT NULL,
  `bosspromo` int(1) NOT NULL,
  `donpromo` int(1) NOT NULL,
  `godfatherpromo` int(1) NOT NULL,
  `crewfront_id` int(255) NOT NULL,
  `authed` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`char_id`, `acc_id`, `acc_username`, `char_name`, `starting_city`, `current_city`, `gunstat`, `defstat`, `sightstat`, `stealthstat`, `luckstat`, `char_status`, `signup`, `money`, `wealth_status`, `exp`, `g_exp`, `rank`, `health`, `points`, `job`, `totalCrimes`, `lastactive`, `lastactive_timestamp`, `nextcrime_timestamp`, `profilepic`, `jailtime`, `jailtime_started`, `traveltime`, `quote`, `thugpromo`, `gangsterpromo`, `earnerpromo`, `wgpromo`, `mmpromo`, `capopromo`, `bosspromo`, `donpromo`, `godfatherpromo`, `crewfront_id`, `authed`) VALUES
(3032, 1, 'Tranquill', 'Epic', 'Chicago', 'Chicago', 113.37, 102.23, 91.77, 95.39, 15.3, '0', '', '141328', 'Poor', '0', '42910', 'Don', '100', '0', 'Criminal', 840, '2019-03-04 19:42:59', 1551728579, 1551750231, 'img/1551163751_thump.jpg', 0, 1551407364, 0, '<p style=\"text-align: center;\"><!-- Replaced by CKEditor --><strong>Welcome to the Regime</strong></p>\r\n', 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1),
(3035, 3, 'testtest', 'BossSon', 'Chicago', 'Chicago', 11, 7, 0, 0, 0, '1', '', '4681889', 'Very Poor', '0', '3497', '', '100', '0', 'Civilian', 18, '2019-02-28 15:51:38', 1551369098, 0, 'img/default-profile.jpg', 0, 1551034656, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3045, 3, 'testtest', 'NewBoss', 'Chicago', 'Chicago', 11, 7, 0, 0, 0, '0', '', '13000000', 'Wealthy', '0', '80070', 'Godfather', '100', '0', 'Criminal', 26, '2019-03-03 17:37:37', 1551634657, 0, 'img/1551653443_thump.jpg', 0, 0, 0, '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(3044, 3, 'testtest', 'BossII', 'Chicago', 'Chicago', 11, 7, 0, 0, 0, '1', '', '4681889', 'Very Poor', '0', '3497', '', '100', '0', 'Civilian', 18, '2019-02-28 19:57:03', 1551383823, 0, 'img/default-profile.jpg', 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3046, 4, 'test123', 'Crewboy', 'Chicago', 'Chicago', 0.1, 7.07, 0.08, 0.06, 0.04, '0', '', '150202', 'Poor', '0', '15004', 'Don', '100', '0', 'Criminal', 54, '2019-03-04 18:31:10', 1551724270, 1551745901, 'img/default-profile.jpg', 0, 0, 0, '', 1, 1, 1, 1, 0, 1, 0, 0, 0, 1, 1),
(3047, 5, 'anothertest', 'Jericho', 'Chicago', 'Chicago', 12.57, 19.11, 12.98, 12.85, 6.86, '0', '', '14664', 'Very Poor', '0', '2145', 'Wise Guy', '100', '0', 'Criminal', 141, '2019-03-04 18:22:50', 1551723770, 1551742375, 'img/default-profile.jpg', 0, 0, 0, '', 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `crew_fronts`
--

CREATE TABLE `crew_fronts` (
  `id` int(11) NOT NULL,
  `owner` text NOT NULL,
  `type` text NOT NULL,
  `city` text NOT NULL,
  `crew_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crew_fronts`
--

INSERT INTO `crew_fronts` (`id`, `owner`, `type`, `city`, `crew_name`) VALUES
(1, 'NewBoss', 'casino', 'Chicago', 'The Brotherhood');

-- --------------------------------------------------------

--
-- Table structure for table `crew_invites`
--

CREATE TABLE `crew_invites` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `sent_by` text NOT NULL,
  `crew_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `crew_invites`
--

INSERT INTO `crew_invites` (`id`, `name`, `sent_by`, `crew_id`) VALUES
(7, 'Crewboy', 'NewBoss', 1),
(8, 'Crewboy', 'NewBoss', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_db_id` int(11) NOT NULL,
  `char_id` int(11) NOT NULL,
  `event` text NOT NULL,
  `event_timestamps` int(11) NOT NULL,
  `is_invite` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_db_id`, `char_id`, `event`, `event_timestamps`, `is_invite`) VALUES
(68, 3032, 'Kelp has accepted your trade!', 1551216160, 0),
(70, 3032, 'Boss has sent you a trade!', 1551306504, 0),
(71, 3032, 'You have picked up a Bandage!', 1551325242, 0),
(72, 3032, 'You have picked up a Bandage!', 1551382658, 0),
(73, 3032, 'You have picked up a Bandage!', 1551407468, 0),
(75, 3045, 'You have picked up a Bandage!', 1551461559, 0),
(76, 3045, 'You have been promoted to Wise Guy.', 1551462929, 0),
(96, 3045, 'You have picked up a Bandage!', 1551463093, 0),
(98, 3045, 'You have been promoted to Made Man.', 1551463102, 0),
(108, 3045, 'You have been promoted to Caporegime.', 1551465515, 0),
(109, 3046, 'You have decided to pursue a life of crime, there\'s no turing back now!', 1551476906, 0),
(110, 3046, 'You have been promoted to Thug.', 1551476906, 0),
(112, 3045, 'You have bought a Hotel!', 1551580890, 0),
(118, 3045, 'You have been promoted to Boss.', 1551581186, 0),
(120, 3046, 'You have been promoted to Gangster.', 1551596521, 0),
(121, 3046, 'You have been promoted to Earner.', 1551596521, 0),
(122, 3046, 'You have been promoted to Wise Guy.', 1551596521, 0),
(123, 3046, 'You have left your crew!', 1551648646, 0),
(126, 3046, 'You have picked up a Bandage!', 1551648685, 0),
(127, 3046, 'You have picked up a Bandage!', 1551648687, 0),
(128, 3046, 'You have left your crew!', 1551648838, 0),
(131, 3046, 'You have picked up a Bandage!', 1551648873, 0),
(133, 3046, 'You have picked up a Bandage!', 1551649649, 0),
(134, 3046, 'You have left your crew!', 1551649796, 0),
(137, 3045, 'Crewboy has accepted your invite!', 1551649915, 0),
(141, 3046, 'You have been authed!', 1551650426, 0),
(142, 3046, 'You have left your crew!', 1551650590, 0),
(143, 3045, 'Crewboy has left your crew!', 1551650590, 0),
(144, 3046, 'You have bought a Pizza Place!', 1551650596, 0),
(145, 3046, 'You have been promoted to Caporegime.', 1551650599, 0),
(147, 3045, 'Crewboy has accepted your invite!', 1551651654, 0),
(148, 3045, 'Epic has accepted your invite!', 1551652706, 0),
(149, 3045, 'You have bought a Casino!', 1551652744, 0),
(150, 3045, 'You have been promoted to Don.', 1551652746, 0),
(151, 3032, 'You have been promoted!', 1551652756, 0),
(152, 3032, 'You have been promoted!', 1551652757, 0),
(153, 3032, 'You have been promoted!', 1551652759, 0),
(154, 3046, 'You have been promoted!', 1551652827, 0),
(155, 3047, 'You have picked up a Bandage!', 1551653137, 0),
(156, 3047, 'You have picked up a Bandage!', 1551653138, 0),
(157, 3047, 'You have picked up a Bandage!', 1551653139, 0),
(158, 3047, 'You have picked up a Bandage!', 1551653141, 0),
(159, 3047, 'You have picked up a Bandage!', 1551653147, 0),
(160, 3047, 'You have picked up a Bandage!', 1551653149, 0),
(161, 3047, 'You have picked up a Bandage!', 1551653151, 0),
(162, 3047, 'You have picked up a Bandage!', 1551653152, 0),
(163, 3047, 'You have picked up a Bandage!', 1551653152, 0),
(164, 3047, 'You have picked up a Bandage!', 1551653154, 0),
(165, 3047, 'You have picked up a Bandage!', 1551653156, 0),
(166, 3047, 'You have picked up a Bandage!', 1551653158, 0),
(167, 3047, 'You have picked up a Bandage!', 1551653159, 0),
(168, 3047, 'You have picked up a Bandage!', 1551653166, 0),
(169, 3047, 'You have picked up a Bandage!', 1551653167, 0),
(170, 3047, 'You have picked up a Bandage!', 1551653168, 0),
(171, 3047, 'You have picked up a Bandage!', 1551653176, 0),
(172, 3047, 'You have picked up a Bandage!', 1551653185, 0),
(173, 3047, 'You have picked up a Bandage!', 1551653186, 0),
(174, 3047, 'You have picked up a Bandage!', 1551653187, 0),
(175, 3047, 'You have picked up a Bandage!', 1551653188, 0),
(176, 3047, 'You have picked up a Bandage!', 1551653190, 0),
(177, 3047, 'You have picked up a Bandage!', 1551653193, 0),
(178, 3047, 'You have picked up a Bandage!', 1551653194, 0),
(179, 3047, 'You have picked up a Bandage!', 1551653196, 0),
(180, 3047, 'You have picked up a Bandage!', 1551653197, 0),
(181, 3047, 'You have picked up a Bandage!', 1551653199, 0),
(182, 3047, 'You have picked up a Bandage!', 1551653200, 0),
(183, 3047, 'You have picked up a Bandage!', 1551653201, 0),
(184, 3047, 'You have picked up a Bandage!', 1551653201, 0),
(185, 3047, 'You have picked up a Bandage!', 1551653202, 0),
(186, 3047, 'You have decided to pursue a life of crime, there\'s no turning back now!', 1551653202, 0),
(187, 3047, 'You have been promoted to Thug.', 1551653202, 0),
(188, 3047, 'You have picked up a Bandage!', 1551653202, 0),
(190, 3045, 'Jericho has accepted your invite!', 1551653236, 0),
(191, 3045, 'You have been promoted to Godfather.', 1551653382, 0),
(192, 3045, 'You are the king of Chicago for now.', 1551653382, 0),
(193, 3046, 'You have been promoted!', 1551653414, 0),
(194, 3032, 'You have been promoted!', 1551653415, 0),
(195, 3032, 'You have been authed!', 1551653416, 0),
(196, 3032, 'You have left your crew!', 1551653481, 0),
(197, 3045, 'Epic has left your crew!', 1551653481, 0),
(198, 3032, 'You have bought a Pizza Place!', 1551653487, 0),
(199, 3032, 'You have been promoted to Caporegime.', 1551653489, 0),
(201, 3045, 'Epic has accepted your invite!', 1551653603, 0),
(202, 3032, 'You have been promoted!', 1551653611, 0),
(203, 3032, 'You have been promoted!', 1551653612, 0),
(204, 3032, 'NewBoss has sent you a trade!', 1551654082, 0),
(205, 3045, 'Epic has accepted your trade!', 1551654091, 0),
(206, 3032, 'You have accepted NewBoss\'s trade!', 1551654091, 0),
(207, 3047, 'You have been promoted to Gangster.', 1551734331, 0),
(208, 3047, 'You have been promoted to Earner.', 1551734371, 0),
(209, 3047, 'You have been promoted to Wise Guy.', 1551734421, 0),
(210, 3047, 'You have picked up a Bandage!', 1551736770, 0),
(211, 3032, 'You have picked up a Bandage!', 1551737902, 0);

-- --------------------------------------------------------

--
-- Table structure for table `forum_replies`
--

CREATE TABLE `forum_replies` (
  `id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `forum_type` varchar(11) NOT NULL,
  `sender` varchar(11) NOT NULL,
  `reply` text NOT NULL,
  `time` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_replies`
--

INSERT INTO `forum_replies` (`id`, `forum_id`, `forum_type`, `sender`, `reply`, `time`) VALUES
(8, 1, 'obit', 'Epic', '<p>Test<!-- Replaced by CKEditor --></p>\r\n', 1551250172),
(9, 1, 'obit', 'Paco', '<p>Good riddance you piece of shit!</p>\r\n', 1551305640),
(10, 1, 'obit', 'Epic', '<p>That&#39;s a bit rude, Paco.<!-- Replaced by CKEditor --></p>\r\n', 1551305858),
(11, 1, 'obit', 'Boss', '<p>Oh, dear!</p>\r\n', 1551306152),
(12, 2, 'obit', 'Boss', '<p>RIP, Father.</p>\r\n', 1551306261),
(13, 2, 'obit', 'Boss', '<p>I will avenge you.</p>\r\n', 1551307437),
(14, 3, 'obit', 'BossII', '<p>You had it coming g</p>\r\n', 1551399346);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inv_id` int(11) NOT NULL,
  `char_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inv_id`, `char_id`, `item_id`, `item_quantity`) VALUES
(38, 3032, 8000, 1),
(40, 3032, 8003, 10),
(43, 3032, 8001, 7),
(44, 3032, 8007, 3),
(45, 3045, 8000, 1),
(47, 3045, 8003, 2),
(48, 3046, 8003, 4),
(49, 3047, 8003, 33);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_name` text NOT NULL,
  `item_desc` text NOT NULL,
  `stackable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_name`, `item_desc`, `stackable`) VALUES
(8000, 'Gun', 'This is a semi-automatic pistol capable of ending lives.', 0),
(8001, 'Bullet', 'This would appear to go into a pistol.', 1),
(8002, 'Test Item', 'This is a test item.', 1),
(8003, 'Bandage', 'This is a bandage, it will heal you a little bit.', 1),
(8004, 'Bottle of Antibiotics', 'This bottle of antibiotics will help you cure illness.', 1),
(8005, 'Medical Gauze', 'This medical gauze will heal you a decent amount.', 1),
(8006, 'First-Aid Kit', 'This first-aid kit comes loaded with medical supplies, it will heal you for a lot.', 0),
(8007, 'Police Disguise', 'This police disguise will help you get around the city and help keep your heat low.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE `mail` (
  `mail_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mail`
--

INSERT INTO `mail` (`mail_id`, `time`, `sender`, `receiver`, `subject`, `message`) VALUES
(3, 312321321, 'testchar', 'testchar', 'hi', 'hi'),
(24, 1551222523, 'Kelp', 'Epic', 'copypasta', 'If every male on earth got a boner at the same time, the earth\'s rotation would slow down. Assume there are about 3.8 billion males, with an average dick height of about 80 cm off the ground. The average dick weighs about 100 grams.\r\n\r\nThat\'s a combined mass of 380,000,000 kg of cock.\r\n\r\nNow we must make an approximation. For simplicity\'s sake, let us assume the penises are all evenly lined up in a ring around the equator. The equation for moment of inertia of a ring is I = mass*radius^2. The radius of earth is about 6.371 million meters. Therefore the radius of the approximated dick ring is 6,371,000 + 0.80 = 6,371,000.8 meters.\r\n\r\nI = 380,000,000*6,371,000.8^2 = 1.5424*10^22\r\n\r\nThe Earth has a moment of inertia, I = 8.04Ã—10^37 kg*m^2. The Earth rotates at a moderate angular velocity of 7.2921159 Ã—10^âˆ’5 radians/second.');

-- --------------------------------------------------------

--
-- Table structure for table `obituaries`
--

CREATE TABLE `obituaries` (
  `obit_id` int(11) NOT NULL,
  `char_id` int(11) NOT NULL,
  `char_name` varchar(255) NOT NULL,
  `job` varchar(11) NOT NULL,
  `rank` varchar(11) NOT NULL,
  `death_timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `obituaries`
--

INSERT INTO `obituaries` (`obit_id`, `char_id`, `char_name`, `job`, `rank`, `death_timestamp`) VALUES
(1, 3035, 'Kelp', 'Citizen', '', 1551246222),
(2, 3035, 'Paco', 'Citizen', '', 1551306120),
(3, 3035, 'BossSon', 'Civilian', '', 1551382900),
(4, 3044, 'BossII', 'Civilian', '', 1551405430);

-- --------------------------------------------------------

--
-- Table structure for table `retired`
--

CREATE TABLE `retired` (
  `retired_id` int(255) NOT NULL,
  `char_id` int(255) NOT NULL,
  `char_name` text NOT NULL,
  `retired_timestamp` int(255) NOT NULL,
  `final_words` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retired`
--

INSERT INTO `retired` (`retired_id`, `char_id`, `char_name`, `retired_timestamp`, `final_words`) VALUES
(1, 3035, 'Boss', 1551327769, '<p>it was good boys, not my kind of life to live.<strong> fuck you</strong> epic for killing my father!</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `trade`
--

CREATE TABLE `trade` (
  `trade_id` int(11) NOT NULL,
  `sender` varchar(11) NOT NULL,
  `receiver` varchar(11) NOT NULL,
  `item_id` int(255) NOT NULL,
  `item_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`char_id`);

--
-- Indexes for table `crew_fronts`
--
ALTER TABLE `crew_fronts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crew_invites`
--
ALTER TABLE `crew_invites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_db_id`);

--
-- Indexes for table `forum_replies`
--
ALTER TABLE `forum_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail`
--
ALTER TABLE `mail`
  ADD PRIMARY KEY (`mail_id`);

--
-- Indexes for table `obituaries`
--
ALTER TABLE `obituaries`
  ADD PRIMARY KEY (`obit_id`);

--
-- Indexes for table `retired`
--
ALTER TABLE `retired`
  ADD PRIMARY KEY (`retired_id`);

--
-- Indexes for table `trade`
--
ALTER TABLE `trade`
  ADD PRIMARY KEY (`trade_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `char_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3048;
--
-- AUTO_INCREMENT for table `crew_fronts`
--
ALTER TABLE `crew_fronts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `crew_invites`
--
ALTER TABLE `crew_invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_db_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;
--
-- AUTO_INCREMENT for table `forum_replies`
--
ALTER TABLE `forum_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8008;
--
-- AUTO_INCREMENT for table `mail`
--
ALTER TABLE `mail`
  MODIFY `mail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `obituaries`
--
ALTER TABLE `obituaries`
  MODIFY `obit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `retired`
--
ALTER TABLE `retired`
  MODIFY `retired_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `trade`
--
ALTER TABLE `trade`
  MODIFY `trade_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
