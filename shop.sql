-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2022 at 07:03 PM
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
(8, 'Hand Made', 'Hand Made Items', 0, 1, 1, 1, 1),
(9, 'Computers', 'Computers Item', 0, 2, 0, 1, 0),
(10, 'Cell Phones', 'Cell Phones', 0, 3, 0, 0, 0),
(11, 'Clothing', 'Clothing And Fashion', 8, 4, 0, 0, 0),
(12, 'Tools', 'Home Tools', 0, 5, 0, 0, 0),
(14, 'Blackberry', 'Blackberry Phones', 10, 6, 0, 0, 0),
(15, 'Hammers', 'Hammers Desc', 12, 7, 0, 0, 0),
(17, 'Games', 'Hand Made Games ', 12, 8, 0, 0, 0),
(18, 'Other', 'Contains All Items That Does Not Have Any Category Or It\'s Category Has Not Added Yet', 0, 0, 0, 0, 0),
(19, 'Video Games', 'A Great PC Game', 0, 10, 0, 0, 0);

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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(15, 'TEST', 1, '2022-04-04', 32, 1),
(17, 'Test', 1, '2022-04-09', 34, 39),
(18, 'Test', 1, '2022-04-09', 34, 39),
(19, 'Test', 1, '2022-04-09', 34, 39),
(21, 'Good Item', 1, '2022-05-04', 66, 1),
(22, 'Good Item', 1, '2022-05-04', 66, 1);

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
(32, 'GTA V', 'A Great PC Game', '15', '2022-04-04', 'USA', '', '1', 0, 1, 19, 1, '', 0, NULL, NULL, NULL, NULL, NULL),
(34, 'GTA IV', 'A Great PC Game', '1', '2022-04-05', 'Syrian Arab Republic , Damascus , AL-Mazza', '', '2', 0, 1, 19, 1, 'pc gaming', -4, NULL, NULL, NULL, NULL, NULL),
(35, 'Morrowind', 'a shit pc game', '12', '2022-04-05', 'USA', '', '4', 0, 1, 19, 1, 'pc gaming', -4, NULL, NULL, NULL, NULL, NULL),
(36, 'hammer', 'just hammer', '1', '2022-04-05', 'Syrian Arab Republic , Damascus , AL-Mazza', '', '3', 0, 1, 19, 1, 'hammer', 2, NULL, NULL, NULL, NULL, NULL),
(37, 'Knife', 'a good knife', '123', '2022-04-05', 'Japan', '', '1', 0, 1, 19, 1, 'Knife', 2, NULL, NULL, NULL, NULL, NULL),
(38, 'Blackberry 1', 'just blckberry 1', '123', '2022-04-06', 'Syrian Arab Republic , Damascus , AL-Mazza', '', '3', 0, 1, 14, 26, 'mobile,phone,cell phone', NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'Just Testing', 'Just Testing', '1', '2022-04-11', 'Syrian Arab Republic , Damascus , AL-Mazza', '2138091371_174333.jpg', '1', 0, 1, 19, 1, 'GTA Vasdasdasd', 1, NULL, NULL, NULL, NULL, NULL),
(42, 'Skyrim', 'A Great PC Game', '22', '2022-04-22', 'Syrian Arab Republic , Damascus , AL-Mazza', '1328827446_90-909966_2k-windows-10-wallpapers-4k.jpg', '1', 0, 1, 19, 1, 'pc gaming,pc,gaming', -60, NULL, NULL, NULL, NULL, NULL),
(43, 'One Piece', 'A Good Anime', '15', '2022-04-22', 'Japan', '6126314438_trying to have fun.jpg', '1', 0, 1, 19, 1, 'Anime', -48, NULL, NULL, NULL, NULL, NULL),
(45, 'Last Test', 'Last Test', '200', '2022-04-23', 'USA', '2495668339_Front vs back.jpg', '1', 0, 1, 10, 44, 'Test', 1, NULL, NULL, NULL, NULL, NULL),
(46, 'Hello', 'Hello Hello Hello', '123', '2022-04-26', 'Syrian Arab Republic , Damascus , AL-Mazza', '2481719101_51-511834_marvel-1080p-wallpaper-spider-man.jpg', '1', 0, 1, 18, 1, 'Hello', 100, '7831507095_', '7803689562_', '2834394737_', '1225878954_', 1),
(47, 'Morrowindfjk', 'A Great PC Game', '15', '2022-04-28', 'Test', '798005065_childnaruto.jpg', '4', 0, 1, 18, 1, '', 6, NULL, NULL, NULL, NULL, NULL),
(48, 'GTA Vice City ', 'A Great PC Game', '22', '2022-04-29', 'Syrian Arab Republic , Damascus , AL-Mazza', '1724812200_Grauation Project.jpg', '1', 0, 1, 19, 1, '12222', 12, NULL, NULL, NULL, NULL, NULL),
(49, 'GTA Vice City ', 'A Great PC Game', '22', '2022-04-29', 'Syrian Arab Republic , Damascus , AL-Mazza', '9657797489_Grauation Project.jpg', '1', 0, 1, 19, 1, '12222', -60, NULL, NULL, NULL, NULL, NULL),
(50, 'GTA Vice City ', 'A Great PC Game', '22', '2022-04-29', 'Syrian Arab Republic , Damascus , AL-Mazza', '5607733091_Grauation Project.jpg', '1', 0, 1, 19, 1, '12222', 12, NULL, NULL, NULL, NULL, NULL),
(51, 'other', 'other other', '123', '2022-04-29', 'Syrian Arab Republic , Damascus , AL-Mazza', '8524973815_Kishimoto.jpg', '1', 0, 1, 19, 1, 'other', 11, NULL, NULL, NULL, NULL, NULL),
(53, 'Grand Torismo', 'A Great PC Game', '15', '2022-04-29', 'Syrian Arab Republic', '2249480490_Inuyashiki.png', '1', 0, 1, 8, 1, 'hammer', 123, '3784391147_', '256198822_', '5739775334_', '6793338987_', 1),
(60, 'Test image 1', 'Test image 1', '12', '2022-04-29', 'Syrian Arab Republic , Damascus , AL-Mazza', '3287806755_Gaara.jpg', '2', 0, 1, 12, 1, 'test', 0, '851142245_Might Guy Promise.jpg', NULL, NULL, NULL, NULL),
(61, 'image 1', 'image 1 image 1', '15', '2022-04-29', 'image 1', '7916172373_Grauation Project.jpg', '1', 0, 1, 18, 1, 'image 1', 0, '317855989_Kishimoto.jpg', NULL, NULL, NULL, NULL),
(63, 'JUST Test', 'test all images', '1', '2022-04-29', 'Syrian Arab Republic', '3532023626_Gaara.jpg', '2', 0, 1, 19, 1, 'test', -1, '969206310_Yugi.jpg', '6374814325_Yugi Card.jpg', '9906633918_wa.jpg', '1374299749_trying to have fun.jpg', NULL),
(64, 'Hello', 'Hello Hello Hello', '1', '2022-04-29', 'Syrian Arab Republic , Damascus , AL-Mazza', '1735203737_174270.jpg', '4', 0, 1, 19, 35, 'Random', 0, '6902220312_174270.jpg', NULL, NULL, NULL, NULL),
(65, 'another test', 'another test', '2', '2022-04-29', 'Syrian Arab Republic , Damascus , AL-Mazza', '6341714070_105-1056055_raven-fortnite-battle-royale-8k-wallpaper-fortnite-raven.jpg', '3', 0, 1, 19, 44, 'another test', 0, '7688289801_3283db6bbc69c487c382af2013682da6.jpg', '6049710027_3283db6bbc69c487c382af2013682da6.jpg', '8723654383_3283db6bbc69c487c382af2013682da6.jpg', '4033528290_3283db6bbc69c487c382af2013682da6.jpg', NULL),
(66, 'Hello Test', 'Hello Test', '123', '2022-04-30', 'Hello Test', '9111063382_2uNvm0.png', '1', 0, 1, 19, 45, 'Hello Test', 0, '3715084668_51-511834_marvel-1080p-wallpaper-spider-man.jpg', '3189048705_90-909966_2k-windows-10-wallpapers-4k.jpg', '7958435280_105-1056055_raven-fortnite-battle-royale-8k-wallpaper-fortnite-raven.jpg', '7958435280_105-1056055_raven-fortnite-battle-royale-8k-wallpaper-fortnite-raven.jpg', NULL),
(67, 'mohamad test', 'mohamad test', '77', '2022-04-30', 'mohamad test', '7875045646_90-909966_2k-windows-10-wallpapers-4k.jpg', '4', 0, 1, 19, 1, 'asdasd', 0, '2793528788_174280.jpg', '5789152378_320439.jpg', '1232844244_656442.jpg', '1232844244_656442.jpg', NULL),
(68, 'just anything', 'just anything', '2', '2022-04-30', 'just anything', '110566782_26a9f47856b814bd67c1b458a88047a4.jpg', '3', 0, 1, 8, 1, 'just anything', 0, '212969371_11792.jpg', '5255752663_513993.jpg', '1507747494_11801.jpg', '1507747494_11801.jpg', NULL),
(69, 'GTA Vice City', 'A Great PC Game', '15', '2022-05-10', 'USA', '5530710254_105-1056055_raven-fortnite-battle-royale-8k-wallpaper-fortnite-raven.jpg', '1', 0, 1, 8, 1, 'test', 1233, '7343308790_11801.jpg', '9336533566_90-909966_2k-windows-10-wallpapers-4k.jpg', '2333612604_26a9f47856b814bd67c1b458a88047a4.jpg', '2333612604_26a9f47856b814bd67c1b458a88047a4.jpg', NULL),
(70, 'hello hello hello', 'hello hello hello', '123321', '2022-05-12', 'USA', '9687786110_2uNvm0.png', '1', 0, 1, 8, 1, 'hello hello hello', 100, '9837194469_', '1410953718_', '9769008226_', '4167157681_', 1),
(71, 'featured item', 'the featured item', '123456789', '2022-05-12', 'USA', '48774009_2uNvm0.png', '4', 0, 1, 14, 43, 'featured item', 150, '8695378663_21-210138_rgb-rog-wallpaper-based-on-the-one-from.png', '5579771241_26a9f47856b814bd67c1b458a88047a4.jpg', '9060915044_51-511834_marvel-1080p-wallpaper-spider-man.jpg', '7114307734_90-909966_2k-windows-10-wallpapers-4k.jpg', 1);

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
(1, 45, NULL, NULL, 1, NULL, NULL),
(3, 1, NULL, NULL, 1, NULL, NULL),
(16, 45, 66, NULL, NULL, NULL, NULL),
(17, 45, 66, NULL, NULL, NULL, NULL),
(18, 1, 67, NULL, NULL, NULL, NULL),
(19, 1, 68, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, NULL, NULL, NULL),
(21, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 1, NULL, NULL, NULL, NULL, 1),
(24, 1, 48, NULL, NULL, NULL, NULL),
(25, 1, 53, NULL, NULL, NULL, NULL),
(26, 1, 51, NULL, NULL, NULL, NULL),
(27, 1, 49, NULL, NULL, NULL, NULL),
(28, 1, 50, NULL, NULL, NULL, NULL),
(30, 1, NULL, NULL, NULL, NULL, 5),
(31, 24, NULL, NULL, NULL, NULL, 6),
(32, 24, NULL, NULL, NULL, NULL, 7),
(33, 1, NULL, NULL, NULL, NULL, 19),
(34, 1, NULL, NULL, NULL, NULL, 18),
(35, 1, 63, NULL, NULL, 1, NULL),
(36, 1, 68, NULL, NULL, 1, NULL),
(37, 1, 61, NULL, NULL, 1, NULL),
(38, 45, 66, NULL, NULL, 1, NULL),
(39, 1, NULL, NULL, NULL, NULL, 29),
(40, 1, NULL, NULL, NULL, NULL, 28),
(41, 24, NULL, NULL, NULL, NULL, 27),
(42, 24, NULL, NULL, NULL, NULL, 26),
(43, 24, NULL, NULL, NULL, NULL, 25),
(44, 24, NULL, NULL, NULL, NULL, 24),
(45, 24, NULL, NULL, NULL, NULL, 23),
(46, 1, NULL, NULL, NULL, NULL, 22),
(47, 1, NULL, NULL, NULL, NULL, 21),
(48, 1, NULL, NULL, NULL, NULL, 20),
(49, 1, NULL, NULL, NULL, NULL, 17),
(50, 1, NULL, NULL, NULL, NULL, 16),
(51, 1, NULL, NULL, NULL, NULL, 15),
(52, 1, NULL, NULL, NULL, NULL, 14),
(53, 1, NULL, NULL, NULL, NULL, 13),
(54, 1, NULL, NULL, NULL, NULL, 12),
(55, 1, NULL, NULL, NULL, NULL, 11),
(56, 1, NULL, NULL, NULL, NULL, 10),
(57, 1, NULL, NULL, NULL, NULL, 9),
(58, 1, NULL, NULL, NULL, NULL, 8),
(59, 44, 65, NULL, NULL, 1, NULL),
(60, 1, 60, NULL, NULL, 1, NULL),
(61, 35, 64, NULL, NULL, 1, NULL),
(62, 1, 69, NULL, NULL, NULL, NULL),
(63, 1, 70, NULL, NULL, NULL, NULL),
(64, 1, NULL, NULL, NULL, NULL, 33),
(65, 1, NULL, NULL, NULL, NULL, 32),
(66, 1, NULL, NULL, NULL, NULL, 31),
(67, 1, NULL, NULL, NULL, NULL, 30);

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `country`, `city`, `address`, `phone`, `items_arr`, `price`, `approve`, `date`) VALUES
(1, 1, 'Syrian Arab Republic', 'homs', 'syria homs akrama', 954250979, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:2:\"10\";}}', 10, 1, '2022-04-10'),
(5, 1, 'Syrian Arab Republic', 'homs', 'syria homs akrama', 123456789, 'a:4:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"3\";}i:1;a:4:{s:7:\"item_id\";s:2:\"45\";s:9:\"item_name\";s:9:\"Last Test\";s:10:\"item_price\";s:3:\"200\";s:13:\"item_quantity\";s:1:\"1\";}i:2;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}i:3;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:1:\"9\";}}', 344, 1, '2022-04-25'),
(6, 24, 'Test', 'Test', 'Test', 123456789, 'a:7:{i:0;a:4:{s:7:\"item_id\";s:2:\"68\";s:9:\"item_name\";s:13:\"just anything\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:1:\"1\";}i:1;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}i:2;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:1:\"4\";}i:3;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:2:\"11\";}i:4;a:4:{s:7:\"item_id\";s:2:\"61\";s:9:\"item_name\";s:7:\"image 1\";s:10:\"item_price\";s:2:\"15\";s:13:\"item_quantity\";s:2:\"13\";}i:5;a:4:{s:7:\"item_id\";s:2:\"46\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:2:\"12\";}i:6;a:4:{s:7:\"item_id\";s:2:\"34\";s:9:\"item_name\";s:6:\"GTA IV\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"1\";}}', 1816, 1, '2022-05-01'),
(7, 24, 'Test', 'Test', 'Test', 123123123, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"61\";s:9:\"item_name\";s:7:\"image 1\";s:10:\"item_price\";s:2:\"15\";s:13:\"item_quantity\";s:1:\"4\";}}', 60, 1, '2022-05-05'),
(8, 1, 'Test', 'Test', 'Test', 2147483647, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:2:\"12\";}}', 24, 1, '2022-05-05'),
(9, 1, 'Test', 'Test', 'Test', 112233, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}}', 123, 1, '2022-05-05'),
(10, 1, 'echo &#39;&#39;', 'echo &#39;&#39;;', 'echo &#39;&#39;;', 11447788, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}}', 123, 1, '2022-05-05'),
(11, 1, 'USA', 'homs', 'syria homs akrama', 211212, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"45\";s:9:\"item_name\";s:9:\"Last Test\";s:10:\"item_price\";s:3:\"200\";s:13:\"item_quantity\";s:1:\"1\";}}', 200, 1, '2022-05-05'),
(12, 1, 'USA', 'homs', 'syria homs akrama', 555555, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:1:\"4\";}}', 8, 1, '2022-05-05'),
(13, 1, 'echo &#39;&#39;;', 'echo &#39;&#39;;', 'echo &#39;&#39;;', 1222121212, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:2:\"12\";}}', 12, 1, '2022-05-05'),
(14, 1, 'USA', 'homs', 'syria homs akrama', 2147483647, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"3\";}}', 3, 1, '2022-05-05'),
(15, 1, 'USA', 'homs', 'syria homs akrama', 2147483647, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}}', 123, 1, '2022-05-05'),
(16, 1, 'Syrian Arab Republic', 'homs', 'syria homs akrama', 12121212, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:1:\"3\";}}', 6, 1, '2022-05-05'),
(17, 1, 'Syrian Arab Republic', 'homs', 'syria homs akrama', 12121212, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}}', 123, 1, '2022-05-05'),
(18, 1, 'Syrian Arab Republic', 'homs', 'syria homs akrama', 1212121212, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}}', 123, 1, '2022-05-05'),
(19, 1, 'Syrian Arab Republic', 'homs', 'syria homs akrama', 2147483647, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:1:\"3\";}}', 6, 1, '2022-05-05'),
(20, 1, 'USA', 'homs', 'syria homs akrama', 123123, 'a:3:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"6\";}i:1;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:1:\"3\";}i:2;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}}', 135, 1, '2022-05-06'),
(21, 1, 'USA', 'homs', 'syria homs akrama', 1111111, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:2:\"12\";}}', 12, 1, '2022-05-06'),
(22, 1, 'USA', 'homs', 'syria homs akrama', 112223333, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:2:\"23\";}}', 46, 1, '2022-05-06'),
(23, 24, 'USA', 'homs', 'syria homs akrama', 111111, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"34\";s:9:\"item_name\";s:6:\"GTA IV\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"2\";}}', 2, 1, '2022-05-06'),
(24, 24, 'USA', 'homs', 'syria homs akrama', 121212, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"35\";s:9:\"item_name\";s:9:\"Morrowind\";s:10:\"item_price\";s:2:\"12\";s:13:\"item_quantity\";s:1:\"2\";}}', 24, 1, '2022-05-06'),
(25, 24, 'Hello', 'homs', 'syria homs akrama', 1212122122, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"63\";s:9:\"item_name\";s:9:\"JUST Test\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"1\";}}', 1, 1, '2022-05-06'),
(26, 24, 'USA', 'homs', 'syria homs akrama', 121212, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"68\";s:9:\"item_name\";s:13:\"just anything\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:1:\"1\";}}', 2, 1, '2022-05-06'),
(27, 24, 'USA', 'homs', 'syria homs akrama', 123321, 'a:2:{i:0;a:4:{s:7:\"item_id\";s:2:\"61\";s:9:\"item_name\";s:7:\"image 1\";s:10:\"item_price\";s:2:\"15\";s:13:\"item_quantity\";s:3:\"123\";}i:1;a:4:{s:7:\"item_id\";s:2:\"60\";s:9:\"item_name\";s:12:\"Test image 1\";s:10:\"item_price\";s:2:\"12\";s:13:\"item_quantity\";s:1:\"1\";}}', 1845, 1, '2022-05-06'),
(28, 1, 'USA', 'homs', 'syria homs akrama', 112233, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"1\";}}', 1, 1, '2022-05-06'),
(29, 1, 'asdasd', 'homs', 'syria homs akrama', 2147483647, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"66\";s:9:\"item_name\";s:10:\"Hello Test\";s:10:\"item_price\";s:3:\"123\";s:13:\"item_quantity\";s:1:\"1\";}}', 123, 1, '2022-05-06'),
(30, 1, 'USA', 'homs', 'syria homs akrama', 1212121212, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"9\";}}', 9, 1, '2022-05-08'),
(31, 1, 'Syrian Arab Republic', 'homs', 'syria homs akrama', 123321, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"65\";s:9:\"item_name\";s:12:\"another test\";s:10:\"item_price\";s:1:\"2\";s:13:\"item_quantity\";s:2:\"50\";}}', 100, 1, '2022-05-10'),
(32, 1, 'USA', 'homs', 'syria homs akrama', 223334, 'a:3:{i:0;a:4:{s:7:\"item_id\";s:2:\"60\";s:9:\"item_name\";s:12:\"Test image 1\";s:10:\"item_price\";s:2:\"12\";s:13:\"item_quantity\";s:1:\"1\";}i:1;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"1\";}i:2;a:4:{s:7:\"item_id\";s:2:\"45\";s:9:\"item_name\";s:9:\"Last Test\";s:10:\"item_price\";s:3:\"200\";s:13:\"item_quantity\";s:1:\"1\";}}', 12, 1, '2022-05-11'),
(33, 1, 'USA', 'homs', 'syria homs akrama', 111222333, 'a:1:{i:0;a:4:{s:7:\"item_id\";s:2:\"64\";s:9:\"item_name\";s:5:\"Hello\";s:10:\"item_price\";s:1:\"1\";s:13:\"item_quantity\";s:1:\"1\";}}', 1, 1, '2022-05-11');

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
(1, 'Mohamad', '601f1889667efaebb33b8c12572835da3f027f78', 'mohamad@gmail.com', 'Mohammad Kawach', 1, 0, 1, '2022-03-01', '9981521789_iron-man-minimalism-4k-sp.jpg'),
(24, 'Ahmed', '601f1889667efaebb33b8c12572835da3f027f78', 'ahmed@ahmed.com', 'Ahmed Sameh', 0, 0, 1, '2022-03-02', ''),
(25, 'Gamal', '601f1889667efaebb33b8c12572835da3f027f78', 'Gamal@mmm.com', 'Gamal Ahmed', 0, 0, 1, '2022-03-09', ''),
(26, 'Sameh', '601f1889667efaebb33b8c12572835da3f027f78', 's123@s.com', 'Sameh Ahmed', 0, 0, 1, '2022-03-15', ''),
(28, 'Khaled', '601f1889667efaebb33b8c12572835da3f027f78', 'Khaled@Khaled.com', 'Khaled Ali', 0, 0, 1, '2022-03-22', '7835874209_656442.jpg'),
(33, 'Thomas', '601f1889667efaebb33b8c12572835da3f027f78', 'thomas@gmail.com', 'Thomas Angelo', 0, 0, 1, '2022-04-02', '373218826_55.jpg'),
(35, 'Test', 'ccbe91b1f19bd31a1365363870c0eec2296a61c1', 'j-kaoush@scs-net.sy', 'TestTest', 0, 0, 1, '2022-04-09', '3469244561_raised on hardwork.jpg'),
(36, 'asdasd', '99baee504a1fe91a07bc66b6900bd39874191889', 'mohmad.kawach.777@gmail.com', 'Ali Daie', 0, 0, 1, '2022-04-09', '7278105569_Yugi Card.jpg'),
(37, 'testteste', '82ab84c9a03ace51218f8f3eff340c8e65feb6ea', 'ali@gmail.com', 'testtestetesttestetestteste', 0, 0, 1, '2022-04-09', '7350382355_250865408_237362391718433_7422499132658687714_n.jpg'),
(38, 'test2', '00ea1da4192a2030f9ae023de3b3143ed647bbab', 'mohmad.kawach.777@gmail.com', 'test2test2test2test2', 0, 0, 1, '2022-04-09', '3908707618_childnaruto.jpg'),
(39, 'Last One', '601f1889667efaebb33b8c12572835da3f027f78', 'lastone@gmail.com', 'i am the last one of them all', 0, 0, 1, '2022-04-09', '9430518763_Wallpaper.jpg'),
(40, 'hello', '601f1889667efaebb33b8c12572835da3f027f78', 'hello@hello.com', 'hello hello', 0, 0, 1, '2022-04-09', '2819335762_FB_IMG_1533762484684.jpg'),
(41, 'asdasdasdadsasd', 'a8056d6a6c9814c168d8c715737c70e90f0f2ef2', 'asd@asd.com', 'Thomas Angelo', 0, 0, 1, '2022-04-09', '1863404449_FB_IMG_1533762484684.jpg'),
(43, 'Avatar', '601f1889667efaebb33b8c12572835da3f027f78', 'Avatar@Avatar.com', 'Avatar Avatar', 0, 0, 1, '2022-04-10', '9191533840_Disco-Dingo_WP_4096x2304.jpg'),
(44, 'testing', '601f1889667efaebb33b8c12572835da3f027f78', 'testing@testing.com', 'testing testing', 0, 0, 1, '2022-04-10', '7992858467_174280.jpg'),
(45, 'Just Test', '601f1889667efaebb33b8c12572835da3f027f78', 'asd@asd.com', 'Just Test', 0, 0, 1, '2022-04-30', '2605646080_174280.jpg');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User', AUTO_INCREMENT=46;

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
