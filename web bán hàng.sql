CREATE TABLE `Role` (
  `id` int PRIMARY KEY,
  `name` varchar(255)
);

CREATE TABLE `User` (
  `id` int PRIMARY KEY,
  `fullname` varchar(255),
  `email` varchar(255),
  `phone_number` varchar(255),
  `address` varchar(255),
  `password` varchar(255),
  `role_id` int,
  `created_at` datetime,
  `updated_at` datetime,
  `deleted` int
);

CREATE TABLE `Category` (
  `id` int PRIMARY KEY,
  `name` varchar(255)
);

CREATE TABLE `Product` (
  `id` int PRIMARY KEY,
  `category_id` int,
  `title` varchar(255),
  `price` int,
  `discount` int,
  `thumbnail` varchar(255),
  `description` longtext,
  `created_at` datetime,
  `updated_at` datetime,
  `deleted` int
);

CREATE TABLE `Galery` (
  `id` int PRIMARY KEY,
  `product_id` int,
  `thumbnail` varchar(255)
);

CREATE TABLE `Feedback` (
  `id` int PRIMARY KEY,
  `firstname` varchar(255),
  `lastname` varchar(255),
  `email` varchar(255),
  `phone_number` varchar(255),
  `subject_name` varchar(255),
  `note` varchar(255)
);

CREATE TABLE `Orders` (
  `id` int PRIMARY KEY,
  `user_id` int,
  `fulltname` varchar(255),
  `email` varchar(255),
  `phone_number` varchar(255),
  `address` varchar(255),
  `note` varchar(255),
  `order_date` datetime,
  `status` int,
  `total_money` int
);

CREATE TABLE `Order_Details` (
  `id` int PRIMARY KEY,
  `order_id` int,
  `product_id` int,
  `price` int,
  `num` int,
  `total_money` int
);

ALTER TABLE `User` ADD FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`);

ALTER TABLE `Product` ADD FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`);

ALTER TABLE `Order_Details` ADD FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`);

ALTER TABLE `Galery` ADD FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`);

ALTER TABLE `Order_Details` ADD FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`);

ALTER TABLE `Orders` ADD FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);
