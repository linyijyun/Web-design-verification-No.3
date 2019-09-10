-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2019-07-10 10:36:30
-- 伺服器版本： 10.1.38-MariaDB
-- PHP 版本： 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `db03`
--

-- --------------------------------------------------------

--
-- 資料表結構 `ani`
--

CREATE TABLE `ani` (
  `id` int(1) UNSIGNED NOT NULL,
  `ani` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `ani`
--

INSERT INTO `ani` (`id`, `ani`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- 資料表結構 `movie`
--

CREATE TABLE `movie` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(2) NOT NULL,
  `length` int(3) NOT NULL,
  `ondate` date NOT NULL,
  `publish` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `director` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trailer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `intro` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sh` int(1) NOT NULL DEFAULT '1',
  `rank` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `movie`
--

INSERT INTO `movie` (`id`, `name`, `level`, `length`, `ondate`, `publish`, `director`, `trailer`, `poster`, `intro`, `sh`, `rank`) VALUES
(3, '院線片01', 1, 120, '2019-07-08', '院線片01發行商', '院線片01導演', '03B01v.mp4', '03B01.png', '院線片01劇情簡介', 1, 1),
(4, '院線片02', 2, 120, '2019-07-06', '院線片02發行商', '院線片02導演', '03B02v.mp4', '03B02.png', '院線片02劇情簡介', 1, 2),
(5, '院線片03', 3, 120, '2019-07-07', '院線片03發行商', '院線片03導演', '03B03v.mp4', '03B03.png', '院線片03劇情簡介', 1, 3),
(6, '院線片04', 4, 120, '2019-07-09', '院線片04發行商', '院線片04導演', '03B04v.mp4', '03B04.png', '院線片04劇情簡介', 1, 4),
(7, '院線片05', 1, 120, '2019-07-09', '院線片05發行商', '院線片05導演', '03B05v.mp4', '03B05.png', '院線片05劇情簡介', 1, 5),
(8, '院線片06', 2, 120, '2019-07-01', '院線片06發行商', '院線片06導演', '03B06v.mp4', '03B06.png', '院線片06劇情簡介', 1, 6),
(9, '院線片07', 3, 120, '2019-07-04', '院線片07發行商', '院線片07導演', '03B07v.mp4', '03B07.png', '院線片07劇情簡介', 1, 7),
(10, '院線片08', 4, 120, '2019-06-30', '院線片08發行商', '院線片08導演', '03B08v.mp4', '03B08.png', '院線片08劇情簡介', 1, 8),
(11, '院線片09', 1, 120, '2019-06-29', '院線片09發行商', '院線片09導演', '03B09v.mp4', '03B09.png', '院線片09劇情簡介', 1, 9),
(12, '院線片011', 1, 120, '2019-07-07', '院線片01發行商', '院線片01導演', '03B01v.mp4', '03B01.png', '院線片01劇情簡介', 1, 1),
(13, '院線片022', 2, 120, '2019-07-06', '院線片02發行商', '院線片02導演', '03B02v.mp4', '03B02.png', '院線片02劇情簡介', 1, 2),
(14, '院線片033', 3, 120, '2019-07-08', '院線片03發行商', '院線片03導演', '03B03v.mp4', '03B03.png', '院線片03劇情簡介', 1, 3),
(15, '院線片04', 4, 120, '2019-07-10', '院線片04發行商', '院線片04導演', '03B04v.mp4', '03B04.png', '院線片04劇情簡介', 1, 4),
(16, '院線片05', 1, 120, '2019-06-29', '院線片05發行商', '院線片05導演', '03B05v.mp4', '03B05.png', '院線片05劇情簡介', 1, 5),
(17, '院線片06', 1, 120, '2019-07-10', '院線片06發行商', '院線片06導演', '03B06v.mp4', '03B06.png', '院線片06劇情簡介', 1, 6),
(18, '院線片07', 1, 120, '2019-06-29', '院線片07發行商', '院線片07導演', '03B07v.mp4', '03B07.png', '院線片07劇情簡介', 1, 7);

-- --------------------------------------------------------

--
-- 資料表結構 `ord`
--

CREATE TABLE `ord` (
  `id` int(10) UNSIGNED NOT NULL,
  `no` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `movie` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `odate` date NOT NULL,
  `sess` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `qt` int(5) NOT NULL,
  `seat` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `ord`
--

INSERT INTO `ord` (`id`, `no`, `movie`, `odate`, `sess`, `qt`, `seat`) VALUES
(6, '201907100006', '院線片04', '2019-07-10', '14:00~16:00', 3, 'a:3:{i:0;s:1:\"2\";i:1;s:1:\"1\";i:2;s:1:\"0\";}'),
(7, '201907100007', '院線片04', '2019-07-10', '14:00~16:00', 3, 'a:3:{i:0;s:1:\"7\";i:1;s:1:\"8\";i:2;s:1:\"6\";}'),
(9, '201907100008', '院線片01', '2019-07-10', '14:00~16:00', 3, 'a:3:{i:0;s:1:\"7\";i:1;s:1:\"6\";i:2;s:1:\"5\";}');

-- --------------------------------------------------------

--
-- 資料表結構 `poster`
--

CREATE TABLE `poster` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sh` int(2) NOT NULL DEFAULT '1',
  `rank` int(10) NOT NULL,
  `ani` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `poster`
--

INSERT INTO `poster` (`id`, `name`, `file`, `sh`, `rank`, `ani`) VALUES
(2, 'coffee', 'coffee.png', 1, 2, 1),
(3, '預告片01', '03A01.jpg', 1, 3, 2),
(4, '預告片02', '03A02.jpg', 1, 4, 4),
(5, '預告片03', '03A03.jpg', 1, 5, 5),
(6, '預告片04', '03A04.jpg', 1, 6, 3),
(7, '預告片05', '03A05.jpg', 1, 7, 6),
(8, '預告片06', '03A06.jpg', 1, 8, 3),
(9, '預告片07', '03A07.jpg', 1, 9, 1),
(10, '預告片08', '03A08.jpg', 0, 10, 3),
(11, '預告片09', '03A09.jpg', 0, 11, 2),
(12, '資訊展啊啊啊', '003.jpg', 1, 12, 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `ani`
--
ALTER TABLE `ani`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `ord`
--
ALTER TABLE `ord`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `poster`
--
ALTER TABLE `poster`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動增長(AUTO_INCREMENT)
--

--
-- 使用資料表自動增長(AUTO_INCREMENT) `ani`
--
ALTER TABLE `ani`
  MODIFY `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `ord`
--
ALTER TABLE `ord`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動增長(AUTO_INCREMENT) `poster`
--
ALTER TABLE `poster`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
