SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `shopping` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `shopping`;

CREATE TABLE `manager` (
  `manager_id` int(10) UNSIGNED NOT NULL,
  `account` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `order_detail` (
  `order_detail_id` int(10) UNSIGNED NOT NULL,
  `order_menu_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `amount` int(10) UNSIGNED DEFAULT '1',
  `deal_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `order_menu` (
  `order_menu_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `is_checkout` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '0:待上架 1:售賣中 2已下架',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `saled` int(10) UNSIGNED NOT NULL,
  `descript` text,
  `image` varchar(255) NOT NULL DEFAULT 'noimage.jpg',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未刪除 1:已刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `account` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_number` varchar(10) NOT NULL,
  `name` varchar(10) NOT NULL,
  `cash` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `order_menu_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `permission` tinyint(1) NOT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_id`);

ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_detail_id`);

ALTER TABLE `order_menu`
  ADD PRIMARY KEY (`order_menu_id`);

ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `manager`
  MODIFY `manager_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `order_detail`
  MODIFY `order_detail_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `order_menu`
  MODIFY `order_menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
