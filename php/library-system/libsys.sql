-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2024 at 06:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libsys`
--
CREATE DATABASE IF NOT EXISTS `libsys` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `libsys`;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(6) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `author` text NOT NULL,
  `genre` text NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `genre`) VALUES
(1, 'Harry Potter', 'J.K. Rowling', 'adventure'),
(2, 'The Da Vinci Code', 'Dan Brown', 'adventure'),
(3, 'The Alchemist', 'Paulo Coelho', 'action');

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

DROP TABLE IF EXISTS `checkouts`;
CREATE TABLE IF NOT EXISTS `checkouts` (
  `checkout_id` int(6) NOT NULL AUTO_INCREMENT,
  `borrowed_date` date NOT NULL,
  `return_date` date NOT NULL,
  `member_id` int(6) NOT NULL,
  `book_id` int(6) NOT NULL,
  `returned` text NOT NULL DEFAULT 'not returned',
  PRIMARY KEY (`checkout_id`),
  KEY `member_id` (`member_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkouts`
--

INSERT INTO `checkouts` (`checkout_id`, `borrowed_date`, `return_date`, `member_id`, `book_id`, `returned`) VALUES
(1, '2024-03-20', '2024-04-03', 1, 2, 'returned'),
(2, '2024-03-20', '2024-04-03', 2, 3, 'not returned'),
(3, '2024-03-20', '2024-04-03', 1, 3, 'not returned');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `member_id` int(6) NOT NULL AUTO_INCREMENT,
  `fullName` text NOT NULL,
  `password` text DEFAULT NULL,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `membership` text NOT NULL DEFAULT 'member',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `fullName`, `password`, `address`, `phone`, `membership`) VALUES
(1, 'Methupa Perera', '$2y$10$6.9m9Fj58h3vQqBsJQ4JpOqFY.G.LxefG7K6.S2EJLGag8SK4ayxK', 'Bandaragama', '0759437742', 'admin'),
(2, 'Vethmin Penuja', NULL, 'Horana', '0764356879', 'member'),
(3, 'Tharuka Kasun', NULL, 'Matara', '0764356765', 'member');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD CONSTRAINT `book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `member_id` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
