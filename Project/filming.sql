-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2024 at 04:16 PM
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
-- Database: `filming`
--

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `locationID` int(4) NOT NULL,
  `locationName` varchar(255) NOT NULL,
  `movieID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`locationID`, `locationName`, `movieID`) VALUES
(3, 'Savoca, Sicily, Italy', 102),
(4, 'Corleone, Sicily, Italy', 102),
(7, 'Los Angeles, California, USA', 104),
(8, 'Amsterdam, Netherlands', 104),
(9, 'Krakow, Poland', 105),
(10, 'Jerusalem, Israel', 105),
(11, 'Savannah, Georgia, USA', 106),
(12, 'Monument Valley, Arizona, USA', 106),
(13, 'Calgary, Alberta, Canada', 107),
(14, 'Paris, France', 107),
(15, 'Sydney, Australia', 108),
(16, 'Chicago, Illinois, USA', 108),
(17, 'Rosarito, Baja California, Mexico', 109),
(18, 'Kinsale, County Cork, Ireland', 109),
(19, 'Matamata, New Zealand', 110),
(20, 'Fiordland National Park, New Zealand', 110);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `movieID` int(4) NOT NULL,
  `movieName` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `releaseDate` date NOT NULL,
  `director` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`movieID`, `movieName`, `genre`, `releaseDate`, `director`) VALUES
(102, 'The Godfather', 'Crime', '1972-03-24', 'Francis Ford Coppola'),
(104, 'Pulp Fiction', 'Crime', '1994-10-14', 'Quentin Tarantino'),
(105, 'Schindler\'s List', 'Biography', '1993-12-15', 'Steven Spielberg'),
(106, 'Forrest Gump', 'Drama', '1994-07-06', 'Robert Zemeckis'),
(107, 'Inception', 'Sci-Fi', '2010-07-16', 'Christopher Nolan'),
(108, 'The Matrix', 'Action', '1999-03-31', 'Lana Wachowski, Lilly Wachowski'),
(109, 'Titanic', 'Romance', '1997-12-19', 'James Cameron'),
(110, 'The Lord of the Rings: The Fellowship of the Ring', 'Fantasy', '2001-12-19', 'Peter Jackson');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`locationID`),
  ADD KEY `movieID` (`movieID`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`movieID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `locationID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `movieID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`movieID`) REFERENCES `movie` (`movieID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
