-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 06:46 PM
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
-- Database: `gas_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

CREATE TABLE `checkouts` (
  `serial` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `item_id` char(5) NOT NULL,
  `returned` tinyint(4) NOT NULL DEFAULT 0,
  `type` char(3) NOT NULL CHECK (`type` = 'old' or `type` = 'new'),
  `checkedout_date` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkouts`
--

INSERT INTO `checkouts` (`serial`, `customer_id`, `item_id`, `returned`, `type`, `checkedout_date`) VALUES
(1, 1, 'C12.5', 1, 'new', '2024-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `address`, `phone`) VALUES
(1, 'Methupa Perera', 'No: 129, Samaranayake Road, Bandaragama', '0755260309'),
(2, 'Ganesh Bandara', 'No: 428, Kalutara Road, Kalutara', '0763452346'),
(3, 'Danith Mahesh', 'No: 428, Colombo Road, Colombo', '0769876765'),
(4, 'Savith Kalhara', 'No: 132, Panadura Road, Panadura', '0753425647');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `invoice_number` int(11) NOT NULL,
  `item_id` char(5) NOT NULL,
  `added_stock_old` int(4) NOT NULL,
  `added_stock_new` int(4) NOT NULL,
  `purchased_date` date NOT NULL DEFAULT curdate()
) ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`invoice_number`, `item_id`, `added_stock_old`, `added_stock_new`, `purchased_date`) VALUES
(1, 'C02.0', 5, 10, '2024-05-26'),
(2, 'C12.5', 10, 20, '2024-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` char(5) NOT NULL,
  `name` varchar(128) NOT NULL,
  `old_stock` int(4) NOT NULL DEFAULT 0,
  `borrowed_old_stock` int(4) NOT NULL DEFAULT 0,
  `old_stock_price` float NOT NULL,
  `new_stock` int(4) NOT NULL DEFAULT 0,
  `borrowed_new_stock` int(4) NOT NULL DEFAULT 0,
  `new_stock_price` float NOT NULL
) ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `old_stock`, `borrowed_old_stock`, `old_stock_price`, `new_stock`, `borrowed_new_stock`, `new_stock_price`) VALUES
('C02.0', '2KG Cylinder', 5, 0, 800, 10, 0, 1200),
('C06.0', '6KG Cylinder', 0, 0, 1600, 0, 0, 2000),
('C12.5', '12.5KG Cylinder', 11, 0, 2400, 19, 0, 2800),
('C37.5', '37.5KG Cylinder', 0, 0, 5400, 0, 0, 6000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD PRIMARY KEY (`serial`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invoice_number`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkouts`
--
ALTER TABLE `checkouts`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `invoice_number` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD CONSTRAINT `checkouts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `checkouts_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
