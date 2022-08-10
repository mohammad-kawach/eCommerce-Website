-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2022 at 11:55 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(23, 'Electronics', 'All about Electronics', 0, 0, 0, 0, 0),
(24, 'Bags', 'All kinds of bags', 0, 0, 0, 0, 0),
(26, 'Laptops', 'All about Laptops', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `Count` int(11) DEFAULT NULL,
  `img1` varchar(255) DEFAULT NULL,
  `img2` varchar(255) DEFAULT NULL,
  `img3` varchar(255) DEFAULT NULL,
  `img4` varchar(255) DEFAULT NULL,
  `Featured` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`, `Count`, `img1`, `img2`, `img3`, `img4`, `Featured`) VALUES
(75, 'Anker PowerBank', '20,000 mAh , 18 W', '45', '2022-08-08', 'Syria', '6872477502_1.jpg', '1', 0, 1, 23, 49, 'Battery , Electronics , powerbank , power', 75, '2523359065_photo_2022-08-06_15-15-17.jpg', '6915738427_photo_2022-08-06_15-15-18.jpg', '1806369346_photo_2022-08-06_15-15-20.jpg', '9933937178_photo_2022-08-06_15-15-22.jpg', 1),
(80, 'HAMMERHEAD BT', 'Fantastic Headphones From Razer', '35', '2022-08-08', 'Egypt', '1710090454_1.jpg', '1', 0, 1, 23, 49, 'air set, headphones', 70, '2236242519_photo_2022-08-06_15-18-49.jpg', '7950049186_photo_2022-08-06_15-18-50.jpg', '7231993946_photo_2022-08-06_15-18-57.jpg', '9222360579_photo_2022-08-06_15-18-55.jpg', 0),
(81, 'JBL Headset 2', 'a great headset for gamers', '100', '2022-08-09', 'Qatar', '7578011319_photo_2022-08-09_15-49-54.jpg', '1', 0, 1, 23, 50, 'headset, headphones', 150, '2504401955_photo_2022-08-09_15-49-54.jpg', '3564625178_photo_2022-08-09_15-49-57.jpg', '6616563335_photo_2022-08-09_15-49-56.jpg', '8738605726_photo_2022-08-09_15-49-55.jpg', 1),
(82, 'ASUS X541UAK', 'Intel Core i3-6006U , RAM 8GB , 1TB HDD , Intel HD Graphics 520', '320', '2022-08-10', 'Turkey', '9849989613_photo_2022-08-10_11-06-26.jpg', '1', 0, 1, 26, 50, 'Laptop', 25, '2237987502_photo_2022-08-10_11-06-23.jpg', '8676845486_photo_2022-08-10_11-06-21.jpg', '2783983179_photo_2022-08-10_11-06-20.jpg', '3282499721_photo_2022-08-10_11-06-18.jpg', NULL),
(83, 'HP 15-bw0xx', 'AMD A4-9120 @2.2GHz , 8 GB RAM , 500 GB HDD', '340', '2022-08-10', 'Germany', '1353854687_photo_2022-08-10_11-10-53.jpg', '2', 0, 1, 26, 50, 'Laptop', 55, '2511622609_photo_2022-08-10_11-10-54.jpg', '209822220_photo_2022-08-10_11-10-56.jpg', '8207094411_photo_2022-08-10_11-10-57.jpg', '2091620032_photo_2022-08-10_11-10-59.jpg', NULL),
(84, 'Lenovo W540', 'Intel Core i7-4900MQ , RAM 8GB , 256 GB SSD , NVIDIA Quadro K2100M', '390', '2022-08-10', 'Albania', '436400771_photo_2022-08-10_11-17-30.jpg', '1', 0, 1, 26, 50, 'Laptop', 30, '5357280533_photo_2022-08-10_11-17-28.jpg', '7056046483_photo_2022-08-10_11-17-27.jpg', '8375894213_photo_2022-08-10_11-17-25.jpg', '8795920360_photo_2022-08-10_11-17-24.jpg', NULL),
(85, 'LENOVO 81LW', 'Ryzen 3-3200U , 8 RAM , 500GB TB , AMD Radeon Vega 3', '400', '2022-08-10', 'USA', '7046929116_1.jpg', '1', 0, 1, 26, 50, 'Laptop', 100, '8126781770_photo_2022-08-10_11-22-24.jpg', '3943460231_photo_2022-08-10_11-22-22.jpg', '225311240_photo_2022-08-10_11-22-21.jpg', '5980812381_photo_2022-08-10_11-22-20.jpg', 0),
(86, 'TOSHIBA A50-C', 'Intel Core i7-5500U , 12GB RAM , 500GB HDD , NVIDIA GeForce 930M', '420', '2022-08-10', 'Canada', '5823475535_1.jpg', '1', 0, 1, 26, 50, 'Laptop', 15, '8945371845_photo_2022-08-10_11-27-00.jpg', '4808990008_photo_2022-08-10_11-26-58.jpg', '2141583019_photo_2022-08-10_11-26-55.jpg', '7565631039_photo_2022-08-10_11-26-51.jpg', NULL),
(87, 'Lenovo Y2', 'Intel Core i5-7200U , RAM 8GB, 180GB SSD , NVIDIA GeForce 940MX', '550', '2022-08-10', 'Saudi', '6449960622_1.jpg', '1', 0, 1, 26, 50, 'Laptop', 200, '7133772644_photo_2022-08-10_11-32-34.jpg', '3856695753_photo_2022-08-10_11-32-32.jpg', '8241550282_photo_2022-08-10_11-32-30.jpg', '3546783385_photo_2022-08-10_11-32-25.jpg', NULL),
(88, 'DELL 15 XPS', 'Intel Core i5-6300HQ , 8GB RAM , 500 GB SSD , NVIDIA GeForce GTX 960', '500', '2022-08-10', 'Ukraine', '7339600755_photo_2022-08-10_12-20-26.jpg', '1', 0, 1, 26, 51, 'Laptop', 25, '1892775117_photo_2022-08-10_12-20-55.jpg', '9241003243_photo_2022-08-10_12-20-47.jpg', '494458776_photo_2022-08-10_12-20-44.jpg', '7968804141_photo_2022-08-10_12-20-43.jpg', NULL),
(89, 'Lenovo Bag', 'A great Bag For Laptops', '50', '2022-08-10', 'Japan', '6615732108_1.jpg', '2', 0, 1, 24, 51, 'bag , laptop', 5, '997721493_photo_2022-08-10_12-33-05.jpg', '6033423374_photo_2022-08-10_12-33-03.jpg', '9538918136_photo_2022-08-10_12-33-02.jpg', '4572742978_photo_2022-08-10_12-33-01.jpg', NULL),
(90, 'G203 LightSync', 'A great gaming mouse', '35', '2022-08-10', 'Lebanon', '7993732074_1.jpg', '1', 0, 1, 23, 51, 'mouse,gaming mouse,gaming', 75, '8543819261_photo_2022-08-10_12-39-10.jpg', '416137362_photo_2022-08-10_12-39-08.jpg', '8355613027_photo_2022-08-10_12-39-07.jpg', '6159897344_photo_2022-08-10_12-39-06.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_approve` tinyint(1) DEFAULT NULL,
  `out_of_stock` tinyint(1) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `u_id`, `item_id`, `comment_id`, `user_approve`, `out_of_stock`, `order_id`) VALUES
(70, 49, NULL, NULL, 1, NULL, NULL),
(71, 49, 75, NULL, NULL, NULL, NULL),
(72, 50, NULL, NULL, 1, NULL, NULL),
(73, 51, NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` int(30) DEFAULT NULL,
  `items_arr` varchar(10000) DEFAULT NULL,
  `price` int(255) DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To Identify User',
  `Username` varchar(255) NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0 COMMENT 'Identify User Group',
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'Seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'User Approval',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'Mohamad', '601f1889667efaebb33b8c12572835da3f027f78', 'mohamad@gmail.com', 'Mohammad Kawach', 1, 0, 1, '2022-03-01', '7608303180_admin_avatar.png'),
(49, 'wael', '601f1889667efaebb33b8c12572835da3f027f78', 'Wael@gmail.com', 'Wael Alsheikh', 0, 0, 1, '2022-08-08', '5648177020_man-face-avatar-cartoon-free-vector.jpg'),
(50, 'ammar', '601f1889667efaebb33b8c12572835da3f027f78', 'ammar@gmail.com', 'Ammar Alsoleman', 0, 0, 1, '2022-08-09', '4612374502_127626271_176738944113454_8788377206497839260_o.jpg'),
(51, 'essa', '601f1889667efaebb33b8c12572835da3f027f78', 'essa@gmail.com', 'Essa Albahry', 0, 0, 1, '2022-08-10', '8720485650_128860657_2735170280070275_2469267349259933046_o.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User', AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`),
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`c_id`),
  ADD CONSTRAINT `notifications_ibfk_4` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
