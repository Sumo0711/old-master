-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2024 年 05 月 20 日 16:40
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `old-master`
--

-- 創建資料庫
CREATE DATABASE IF NOT EXISTS `old-master` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- 切換到新建的資料庫
USE `old-master`;

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `price` int(32) NOT NULL,
  `slogan` varchar(32) NOT NULL,
  `inventory` BOOLEAN DEFAULT TRUE 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `shop_cart`
--

CREATE TABLE `shop_cart` (
  `order_number` int(11) NOT NULL,
  `user_id` int(32) NOT NULL,
  `product_id` int(32) NOT NULL,
  `amount` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user_order_details`
--
CREATE TABLE user_order_details (
    order_details int(11),
    username VARCHAR(32),
    products VARCHAR(32),
    total int(32),
    Finish BOOLEAN DEFAULT FALSE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 替換檢視表以便查看 `user_cart`
-- (請參考以下實際畫面)
--
CREATE TABLE `user_cart` (
`u_id` int(11)
,`username` varchar(32)
,`password` varchar(32)
,`phone` varchar(32)
,`p_id` int(11)
,`name` varchar(32)
,`price` int(32)
,`slogan` varchar(32)
,`order_number` int(11)
,`user_id` int(32)
,`product_id` int(32)
,`amount` int(32)
);

-- --------------------------------------------------------

--
-- 檢視表結構 `user_cart`
--
DROP TABLE IF EXISTS `user_cart`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_cart`  AS   (select `m`.`u_id` AS `u_id`,`m`.`username` AS `username`,`m`.`password` AS `password`,`m`.`phone` AS `phone`,`p`.`p_id` AS `p_id`,`p`.`name` AS `name`,`p`.`price` AS `price`,`p`.`slogan` AS `slogan`,`s`.`order_number` AS `order_number`,`s`.`user_id` AS `user_id`,`s`.`product_id` AS `product_id`,`s`.`amount` AS `amount` from ((`user` `m` join `product` `p`) join `shop_cart` `s`) where `s`.`user_id` = `m`.`u_id` and `s`.`product_id` = `p`.`p_id`)  ;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- 資料表索引 `shop_cart`
--
ALTER TABLE `shop_cart`
  ADD PRIMARY KEY (`order_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `username` (`username`,`phone`);

--
-- 資料表索引 `user_order_details`
--
ALTER TABLE `user_order_details`
  ADD PRIMARY KEY (`order_details`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `shop_cart`
--
ALTER TABLE `shop_cart`
  MODIFY `order_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_order_details`
--
ALTER TABLE `user_order_details`
  MODIFY `order_details` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `shop_cart`
--
ALTER TABLE `shop_cart`
  ADD CONSTRAINT `shop_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`u_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shop_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`p_id`) ON DELETE CASCADE;
COMMIT;

-- --------------------------------------------------------

--
-- INSERT 表結構
--

--
-- 傾印資料表的資料 `product`
--

INSERT INTO `product` (`name`, `price`, `slogan`) VALUES
('日式雞排飯', 90, '「炸至金黃，口感酥脆，日式料理的極致享受。」'),
('鹽水雞肉飯', 80, '「清淡中帶著濃郁的家鄉情懷。」'),
('酥炸排骨飯', 80, '「酥脆香氣四溢，入口即化的絕妙享受。」'),
('日式唐揚雞', 50, '「酥脆外皮，嫩滑多汁，日本風味十足。」'),
('酥炸黃金豆腐', 40, '「外酥內嫩，一口咬下滿溢幸福滋味。」');


--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`username`, `password`, `phone`) VALUES
('test', 'test', '0912345678');

--
-- 傾印資料表的資料 `shop_cart`
--

INSERT INTO `shop_cart` (`user_id`, `product_id`, `amount`) VALUES
('1', '1', '1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
