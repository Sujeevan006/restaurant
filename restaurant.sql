

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(61, 32, 24, 'Biriyani', 1500, 1, 'food2.jpg'),
(71, 33, 24, 'Biriyani', 1500, 1, 'food2.jpg');


DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(8, 33, 'Sujeevan', 'sujee123@gmail.com', '0774152524', 'We need mobile app for order your restaurant foods. '),
(9, 33, 'Kumar', 'kumar@gmail.com', '0774512458', 'I like your services');


DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(12, 33, 'Kumar', '077452584', 'customer@gmail.com', 'cash on delivery', 'flat no. 449/3, Ramalingam road, Thirunelveli, Jaffna. Jaffna Jaffna, Sri Lanka Jaffna Sri Lanka - 40000', ', Biriyani ( 1 ), Fride Rice ( 1 ), Koththu Rotti ( 1 )', 3600, '04-Sep-2024', 'completed'),
(13, 33, 'Sivakumar', '0771256321', 'siva@gmail.com', 'cash on delivery', 'flat no. 123, Main street Jaffna Jaffna Jaffna Sri Lanka - 40000', ', Fride Rice ( 1 ), Koththu Rotti ( 1 )', 2100, '08-Sep-2024', 'pending');



DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `products` (`id`, `name`, `category`, `details`, `price`, `image`) VALUES
(24, 'Biriyani', 'vegfoods', 'Buy 2 full Biryani and get 10% offer', 1500, 'food2.jpg'),
(25, 'Fride Rice', 'nonvegfoods', 'Buy 2 full Biryani and get 10% offer\r\n', 1200, 'food2.jpg'),
(26, 'Koththu Rotti', 'drinks', 'Buy 2 full Biryani and get 10% offer\r\n', 900, 'food2.jpg'),
(27, 'Rice & Curry', 'vegfoods', 'Buy 2 full Biryani and get 10% offer\r\n', 450, 'food2.jpg'),
(28, 'Veg Biriyani', 'nonvegfoods', 'Buy 2 full Biryani and get 10% offer\r\n', 800, 'food2.jpg'),
(29, 'Chicken 65', 'drinks', 'Buy 2 full Biryani and get 10% offer\r\n', 650, 'food2.jpg'),
(30, 'Orange Mojitos', 'drinks', 'Buy 4 orange mojitos and get 1 free!!', 450, 'drinksorange.png'),
(31, 'Chicken Dum Biriyani', 'nonvegfoods', 'Get free 1 liter Pepsi', 1250, 'nonveg1.png');


DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_number` int NOT NULL,
  `persons` int NOT NULL,
  `status` enum('available','booked') NOT NULL,
  `reservation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `reservation` (`id`, `table_number`, `persons`, `status`, `reservation_time`, `date`, `name`) VALUES
(47, 1, 4, '', '0000-00-00 00:00:00', '2024-09-10', 'Sujeevan'),
(41, 5, 20, '', '0000-00-00 00:00:00', '2024-08-15', 'Kumaran'),
(48, 5, 20, '', '0000-00-00 00:00:00', '2024-09-12', 'Kumar');



DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `users` (`id`, `name`, `email`, `password`, `usertype`, `image`) VALUES
(31, 'admin', 'admin@gmail.com', 'b59c67bf196a4758191e42f76670ceba', 'Admin', 'pic-3.png'),
(33, 'customer', 'customer@gmail.com', 'b59c67bf196a4758191e42f76670ceba', 'Customer', 'pic-5.png'),
(35, 'Kumar', 'customer2@gmail.com', 'b59c67bf196a4758191e42f76670ceba', 'Customer', 'pic-3.png'),
(37, 'Staff', 'staff@gmail.com', 'b59c67bf196a4758191e42f76670ceba', 'Staff', 'pic-1.png'),
(38, 'sujeevann', 'sujeevan2@gmail.com', 'b59c67bf196a4758191e42f76670ceba', 'Customer', 'pic-4.png');


DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `wishlist` (`id`, `user_id`, `pid`, `name`, `price`, `image`) VALUES
(67, 33, 28, 'Veg Biriyani', 800, 'food2.jpg');
COMMIT;

