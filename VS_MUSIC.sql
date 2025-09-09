-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 12:24 PM
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
-- Database: `VS_MUSIC`

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkPath` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES
(1, 'AP Dhillon', 1, 3, 'assets/images/singers/AP_Dhillon.jpg'),
(2, 'Arijit Singh', 2, 3, 'assets/images/singers/Arijit_Singh.jpg'),
(3, 'Badshah', 3, 3, 'assets/images/singers/Badshah.jpg'),
(4, 'Honey Singh', 4, 3, 'assets/images/singers/honey_singh.jpg'),
(5, 'Karan Aujla', 5, 3, 'assets/images/singers/Karan_Aujla.jpg'),
(6, 'Raftaar', 6, 3, 'assets/images/singers/Raftaar.jpg'),
(7, 'Kalam Ink', 7, 3, 'assets/images/singers/kalam.jpg'),
(8, 'Diljit Dosanjh', 8, 3, 'assets/images/singers/diljit dosanjh.jpg'),
(9, 'Paradox', 9, 3, 'assets/images/singers/paradox.jpg'),
(10, 'Ikka Singh', 10, 3, 'assets/images/singers/ikka singh.jpg'),
(11, 'Dino James', 11, 3, 'assets/images/singers/dino james.jpg'),
(12, 'Seedhe Maut', 12, 3, 'assets/images/singers/Seedhe_Maut.jpg'),
(13, 'Divine', 13, 3, 'assets/images/singers/Divine.jpg'),
(14, 'Kr$na', 14, 3, 'assets/images/singers/kr$na.jpg'),
(15, 'King', 15, 3, 'assets/images/singers/king.jpg'),
(16, 'HanumanKind', 16, 3, 'assets/images/singers/hanuman_kind.jpg'),
(17, 'B Praak', 17, 3, 'assets/images/singers/B_Praak.jpg'),
(18, 'Sidhu Moose Wala', 18, 3, 'assets/images/singers/sidhu_moose_wala.jpg'),
(19, 'Rahat Fateh Ali khan', 19, 3, 'assets/images/singers/Rahat Fateh Ali khan.jpg'),
(20, 'Neha Kakkar', 20, 3, 'assets/images/singers/Neha_Kakkar.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'AP Dhillon'),
(2, 'Arijit Singh'),
(3, 'Badshah'),
(4, 'Honey Singh'),
(5, 'Karan Aujla'),
(6, 'Raftaar'),
(7, 'Kalam Ink'),
(8, 'Diljit Dosanjh'),
(9, 'Paradox'),
(10, 'Ikka Singh'),
(11, 'Dino James'),
(12, 'Seedhe Maut'),
(13, 'Divine'),
(14, 'Kr$na'),
(15, 'King'),
(16, 'HanumanKind'),
(17, 'B Praak'),
(18, 'Sidhu Moose Wala'),
(19, 'Rahat Fateh Ali khan'),
(20, 'Neha Kakkar');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Hip-hop'),
(4, 'Rap'),
(5, 'R & B'),
(6, 'Classical'),
(7, 'Techno'),
(8, 'Jazz'),
(9, 'Folk'),
(10, 'Country');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `owner`, `dateCreated`) VALUES
(30, 'vedant', 'vedant24y4', '2025-03-28 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `playlistssongs`
--

CREATE TABLE `playlistssongs` (
  `id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `playlistssongs`
--

INSERT INTO `playlistssongs` (`id`, `songId`, `playlistId`, `playlistOrder`) VALUES
(3, 24, 3, 0),
(4, 42, 3, 1),
(5, 41, 3, 2),
(6, 32, 4, 0),
(8, 6, 13, 0);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL,
  `filePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`, `filePath`) VALUES
(1, 'Excuses', 1, 1, 3, '2:37', 'assets/music/AP/Excuses.mp3', 1, 23, ''),
(2, 'Tere Te', 1, 1, 3, '2:35', 'assets/music/AP/TERE-TE.mp3', 2, 16, ''),
(3, 'Brown Munde', 1, 1, 3, '2:33', 'assets/music/AP/Brown-Munde.mp3', 3, 12, ''),
(4, 'All Okk', 1, 1, 3, '2:02', 'assets/music/AP/All-Okk.mp3', 4, 14, ''),
(5, 'Against All Odds', 1, 1, 3, '1:29', 'assets/music/AP/AGAINST-ALL-ODDS.mp3', 5, 10, ''),
(6, 'Agar Tum Saath Ho', 2, 2, 3, '2:37', 'assets/music/arijit/1.mp3', 1, 16, ''),
(7, 'Channa Mereya', 2, 2, 3, '2:35', 'assets/music/arijit/2.mp3', 2, 10, ''),
(8, 'Gerua', 2, 2, 3, '2:33', 'assets/music/arijit/3.mp3', 3, 7, ''),
(9, 'Janam Janam ', 2, 2, 3, '2:02', 'assets/music/arijit/4.mp3', 4, 10, ''),
(10, 'Khairiyat', 2, 2, 3, '1:29', 'assets/music/arijit/5.mp3', 5, 5, ''),
(11, 'Raabta ', 2, 2, 3, '4:04', 'assets/music/arijit/6.mp3', 6, 14, ''),
(12, 'Shayad', 2, 2, 3, '3:07', 'assets/music/arijit/7.mp3', 7, 17, ''),
(13, 'Tera Ban Jaunga', 2, 2, 3, '3:08', 'assets/music/arijit/8.mp3', 8, 7, ''),
(14, 'Tum Hi Ho', 2, 2, 3, '8:03', 'assets/music/arijit/9.mp3', 9, 13, ''),
(15, 'Dj Waley Babu', 3, 3, 3, '1:44', 'assets/music/badshah/1.mp3', 1, 10, ''),
(16, 'Genda Phool', 3, 3, 3, '2:49', 'assets/music/badshah/2.mp3', 2, 23, ''),
(17, 'Gore Gore Mukhde Pe ', 3, 3, 3, '3:50', 'assets/music/badshah/3.mp3', 3, 11, ''),
(18, 'Jugnu', 3, 3, 3, '2:43', 'assets/music/badshah/jugnu.mp3', 4, 40, ''),
(19, 'Kar Gayi Chull ', 3, 3, 3, '3:32', 'assets/music/badshah/5.mp3', 5, 8, ''),
(20, 'Mercy', 3, 3, 3, '4:58', 'assets/music/badshah/6.mp3', 6, 10, ''),
(21, 'Morni ', 3, 3, 3, '2:42', 'assets/music/badshah/morni.mp3', 7, 38, ''),
(22, 'Paagal', 3, 3, 3, '3:36', 'assets/music/badshah/pagal.mp3', 8, 12, ''),
(23, 'Proper Patola', 3, 3, 3, '2:28', 'assets/music/badshah/9.mp3', 9, 8, ''),
(24, 'Angreji Beat ', 4, 4, 3, '4:44', 'assets/music/honey/1.mp3', 1, 33, ''),
(25, 'Blue Eyes ', 4, 4, 3, '3:26', 'assets/music/honey/2.mp3', 2, 8, ''),
(26, 'Brown Rang', 4, 4, 3, '2:20', 'assets/music/honey/3.mp3', 3, 8, ''),
(27, 'Desi Kalakaar', 4, 4, 3, '5:07', 'assets/music/honey/4.mp3', 4, 10, ''),
(28, 'Dope Shope ', 4, 4, 3, '2:03', 'assets/music/honey/5.mp3', 5, 4, ''),
(29, 'High Heels Te Nachche ', 4, 4, 3, '4:16', 'assets/music/honey/6.mp3 ', 6, 3, ''),
(30, 'Love Dose', 4, 4, 3, '2:26', 'assets/music/honey/7.mp3 ', 7, 10, ''),
(31, 'Maniac', 4, 4, 3, '4:54', 'assets/music/honey/8.mp3 ', 8, 55, ''),
(32, 'Millionaire', 4, 4, 3, '4:44', 'assets/music/honey/9.mp3', 9, 1023, ''),
(33, 'Party All Night', 4, 4, 3, '3:26', 'assets/music/honey/10.mp3', 10, 8, ''),
(34, 'Tauba Tauba', 5, 5, 3, '2:20', 'assets/music/karan/1.mp3', 1, 36, ''),
(35, 'Jhanjar', 5, 5, 3, '5:07', 'assets/music/karan/2.mp3', 2, 11, ''),
(36, 'On Top ', 5, 5, 3, '2:03', 'assets/music/karan/3.mp3', 3, 6, ''),
(37, 'Nanak Niva Jo Challe ', 5, 5, 3, '4:16', 'assets/music/karan/4.mp3 ', 4, 7, ''),
(38, 'Top Class Overseas ', 5, 5, 3, '2:26', 'assets/music/karan/5.mp3 ', 5, 9, ''),
(39, '52 Bars ', 5, 5, 3, '4:54', 'assets/music/karan/6.mp3 ', 10, 6, ''),
(40, 'All Black', 6, 6, 3, '4:44', 'assets/music/raftaar/1.mp3', 3, 17, ''),
(41, 'Mera Parichay', 6, 6, 3, '3:26', 'assets/music/raftaar/3.mp3', 2, 13, ''),
(42, 'Saza-E-Maut', 6, 6, 3, '2:20', 'assets/music/raftaar/2.mp3', 1, 517, ''),
(43, 'Regret', 7, 7, 3, '2:48', 'uploads/REGRET.mp3', 1, 1, ''),
(44, 'Alvida', 7, 7, 3, '3:25', 'uploads/ALVIDA  KALAM INK  ISHA  THE LAST MIXTAPE  OFFICIAL MUSIC VIDEO.mp3', 2, 1, ''),
(45, 'K.Y.U', 7, 7, 3, '3:02', 'uploads/K.Y.U  KALAM INK  prod by Raspo  2021 LO-FI STORY TELLING INDIA.mp3', 3, 1, ''),
(46, 'Ra Ta Ta', 7, 7, 3, '2:56', 'uploads/KALAM INK - RA TA TA feat. BELLA  GREYY.BASS  KOLD WORLD (Official Music Audio).mp3', 4, 1, ''),
(47, 'G.O.A.T', 8, 8, 3, '3:24', 'uploads/Diljit Dosanjh - G.O.A.T. (Official Music Video).mp3', 1, 0, ''),
(48, 'Lover', 8, 8, 3, '3:45', 'uploads/Diljit Dosanjh LOVER (Official Music Video) Intense  Raj Ranjodh  MoonChild Era.mp3', 2, 0, ''),
(49, 'Hasti Rahe Tu', 9, 9, 3, '2:06', 'uploads/Hasti Rahe Tu - Paradox (Bhula Main Jahaan) Amulya Rattan  EP- The Unknown Letter  Def Jam India.mp3', 1, 0, ''),
(50, 'Tantrums', 9, 9, 3, '2:45', 'uploads/Tantrums (Official Video)  Paradox  Ishh.mp3', 2, 0, ''),
(51, 'Jaadugar', 9, 9, 3, '3:37', 'uploads/Jaadugar  Paradox  Hustle 2.0.mp3', 3, 0, ''),
(52, 'BT Ho Gayi', 9, 9, 3, '2:54', 'uploads/BT Ho Gayi  Tanishq Singh aka Paradox  Hustle 2.0.mp3', 4, 0, ''),
(53, 'Badam Bam', 9, 9, 3, '2:45', 'uploads/Babam Bam  Paradox  Hustle 2.0.mp3', 5, 0, ''),
(54, 'Blood Is Better Than Tears', 10, 10, 3, '3:23', 'uploads/BLOOD IS BETTER THAN TEARS.mp3', 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(32) NOT NULL,
  `signUpDate` datetime NOT NULL,
  `profilePic` varchar(500) NOT NULL,
  `admin` tinyint(1) DEFAULT 0,
  `status` enum('active','blocked') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `email`, `password`, `signUpDate`, `profilePic`, `admin`, `status`) VALUES
(23, 'vedant24y4', 'Ved', 'Sharma', 'Vedantsharma24y4@gmail.com', 'e7993bef2b6592c56c0c3c279e63a008', '2025-03-27 00:00:00', 'assets/images/profile-pics/user.jpg', 0, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlistssongs`
--
ALTER TABLE `playlistssongs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `playlistssongs`
--
ALTER TABLE `playlistssongs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
